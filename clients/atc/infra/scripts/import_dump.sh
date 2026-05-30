#!/usr/bin/env bash

set -Eeuo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
CLIENT_DIR="$(cd "${ROOT_DIR}/.." && pwd)"
BACKUP_DIR="${CLIENT_DIR}/database"
LOG_DIR="${CLIENT_DIR}/logs"
CONTAINER_NAME="${CONTAINER_NAME:-atc-mysql}"
DB_NAME="${DB_NAME:-gepros1com_atc}"
DB_USER="${DB_USER:-root}"
DB_PASSWORD="${DB_PASSWORD:-SENHA}"
DB_CHARSET="${DB_CHARSET:-latin1}"
DB_COLLATION="${DB_COLLATION:-latin1_swedish_ci}"
DUMP_SQL="${DUMP_SQL:-${BACKUP_DIR}/dump.sql}"
DUMP_GZ="${DUMP_GZ:-${BACKUP_DIR}/dump.sql.gz}"
CONTAINER_TMP_PATH="${CONTAINER_TMP_PATH:-/tmp/atc_dump.sql}"
PRECHECK_LOG="${LOG_DIR}/import-precheck.log"
FULL_LOG="${LOG_DIR}/import-full.log"
MONITOR_LOG="${LOG_DIR}/import-monitor.log"
MYSQL_HOST="${MYSQL_HOST:-127.0.0.1}"
MYSQL_PING_RETRIES="${MYSQL_PING_RETRIES:-120}"
MYSQL_PING_SLEEP="${MYSQL_PING_SLEEP:-5}"
MONITOR_INTERVAL="${MONITOR_INTERVAL:-5}"
MONITOR_ITERATIONS="${MONITOR_ITERATIONS:-0}"
VERIFY_SCRIPT="${ROOT_DIR}/scripts/verificar_dump.sh"

mkdir -p "${LOG_DIR}"

log() {
  printf '[%s] %s\n' "$(date '+%Y-%m-%d %H:%M:%S')" "$*"
}

fail() {
  log "ERRO: $*" >&2
  exit 1
}

usage() {
  cat <<EOF
Uso:
  ./scripts/import_dump.sh [caminho_dump.sql|caminho_dump.sql.gz]
  ./scripts/import_dump.sh --monitor

Ambiente configuravel:
  CONTAINER_NAME=${CONTAINER_NAME}
  DB_NAME=${DB_NAME}
  DB_USER=${DB_USER}
  DB_PASSWORD=******
  DUMP_SQL=${DUMP_SQL}
  DUMP_GZ=${DUMP_GZ}
  CONTAINER_TMP_PATH=${CONTAINER_TMP_PATH}
EOF
}

run_monitor() {
  local iteration=1
  : > "${MONITOR_LOG}"

  while :; do
    {
      log "Monitoracao do import"
      docker compose ps
      docker exec "${CONTAINER_NAME}" mysql -u"${DB_USER}" -p"${DB_PASSWORD}" -Nse "SHOW FULL PROCESSLIST;"
      docker exec "${CONTAINER_NAME}" mysql -u"${DB_USER}" -p"${DB_PASSWORD}" -Nse \
        "SELECT COUNT(*) AS total_tabelas FROM information_schema.tables WHERE table_schema='${DB_NAME}';"
      docker exec "${CONTAINER_NAME}" mysql -u"${DB_USER}" -p"${DB_PASSWORD}" -Nse \
        "SHOW TABLES FROM \`${DB_NAME}\` LIKE 'usuarios';"
      printf '\n'
    } 2>&1 | tee -a "${MONITOR_LOG}"

    if (( MONITOR_ITERATIONS > 0 && iteration >= MONITOR_ITERATIONS )); then
      break
    fi

    iteration=$((iteration + 1))
    sleep "${MONITOR_INTERVAL}"
  done
}

pick_dump() {
  local candidate="${1:-}"

  if [[ -n "${candidate}" ]]; then
    [[ -f "${candidate}" ]] || fail "Dump informado nao encontrado: ${candidate}"
    printf '%s\n' "${candidate}"
    return
  fi

  if [[ -f "${DUMP_SQL}" ]]; then
    printf '%s\n' "${DUMP_SQL}"
    return
  fi

  if [[ -f "${DUMP_GZ}" ]]; then
    printf '%s\n' "${DUMP_GZ}"
    return
  fi

  fail "Nenhum dump .sql ou .sql.gz encontrado em ${BACKUP_DIR}"
}

ensure_sql_dump() {
  local source_dump="$1"

  case "${source_dump}" in
    *.sql)
      [[ -s "${source_dump}" ]] || fail "Arquivo SQL vazio: ${source_dump}"
      printf '%s\n' "${source_dump}"
      ;;
    *.sql.gz)
      log "Validando integridade gzip: ${source_dump}" >&2
      gzip -t "${source_dump}" || fail "Falha na validacao gzip do dump: ${source_dump}"

      log "Descompactando dump para ${DUMP_SQL}" >&2
      rm -f "${DUMP_SQL}"
      gunzip -c "${source_dump}" > "${DUMP_SQL}"
      [[ -s "${DUMP_SQL}" ]] || fail "Arquivo SQL gerado vazio: ${DUMP_SQL}"
      printf '%s\n' "${DUMP_SQL}"
      ;;
    *)
      fail "Formato nao suportado: ${source_dump}"
      ;;
  esac
}

wait_for_mysql() {
  local attempt=1

  log "Aguardando container ${CONTAINER_NAME} ficar pronto"
  docker compose ps 2>&1 | tee -a "${FULL_LOG}"

  while (( attempt <= MYSQL_PING_RETRIES )); do
    if docker exec "${CONTAINER_NAME}" mysqladmin --no-defaults ping \
      -h "${MYSQL_HOST}" \
      -u"${DB_USER}" \
      -p"${DB_PASSWORD}" \
      --silent >/dev/null 2>&1; then
      log "MySQL respondeu ao ping"
      return
    fi

    sleep "${MYSQL_PING_SLEEP}"
    attempt=$((attempt + 1))
  done

  fail "MySQL nao respondeu apos $((MYSQL_PING_RETRIES * MYSQL_PING_SLEEP)) segundos"
}

copy_dump_to_container() {
  local sql_dump="$1"

  log "Copiando dump para ${CONTAINER_NAME}:${CONTAINER_TMP_PATH}"
  docker cp "${sql_dump}" "${CONTAINER_NAME}:${CONTAINER_TMP_PATH}"
  docker exec "${CONTAINER_NAME}" ls -lh "${CONTAINER_TMP_PATH}" 2>&1 | tee -a "${FULL_LOG}"
}

run_import() {
  log "Iniciando importacao dentro do container com SOURCE em sessao unica"
  docker exec -i "${CONTAINER_NAME}" sh -lc "
    mysql \
      -u\"${DB_USER}\" \
      -p\"${DB_PASSWORD}\" \
      --default-character-set=\"${DB_CHARSET}\" <<'SQL'
CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET ${DB_CHARSET} COLLATE ${DB_COLLATION};
USE \`${DB_NAME}\`;
SET SESSION sql_log_bin=0;
SET SESSION autocommit=0;
SET SESSION unique_checks=0;
SET SESSION foreign_key_checks=0;
SOURCE ${CONTAINER_TMP_PATH};
COMMIT;
SET SESSION foreign_key_checks=1;
SET SESSION unique_checks=1;
SET SESSION autocommit=1;
SQL
  " 2>&1 | tee -a "${FULL_LOG}"
}

post_import_fixes() {
  log "Aplicando ajustes pos-importacao do ATC"
  docker exec -i "${CONTAINER_NAME}" sh -lc "
    mysql \
      -u\"${DB_USER}\" \
      -p\"${DB_PASSWORD}\" \
      --default-character-set=\"${DB_CHARSET}\" \"${DB_NAME}\" <<'SQL'
SET @add_nfse_pk = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE lancamentos_financeiros ADD COLUMN nfse_pk int(11) NULL DEFAULT NULL',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'lancamentos_financeiros'
    AND COLUMN_NAME = 'nfse_pk'
);
PREPARE stmt FROM @add_nfse_pk;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_leads_dia_faturamento = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE leads ADD COLUMN dia_faturamento int(11) DEFAULT NULL AFTER leads_pai_pk',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'leads'
    AND COLUMN_NAME = 'dia_faturamento'
);
PREPARE stmt FROM @add_leads_dia_faturamento;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_leads_ic_inss_aplicacao = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE leads ADD COLUMN ic_inss_aplicacao int(11) DEFAULT NULL AFTER dia_faturamento',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'leads'
    AND COLUMN_NAME = 'ic_inss_aplicacao'
);
PREPARE stmt FROM @add_leads_ic_inss_aplicacao;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_leads_ic_iss_retido_tomador = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE leads ADD COLUMN ic_iss_retido_tomador int(11) DEFAULT NULL AFTER ic_inss_aplicacao',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'leads'
    AND COLUMN_NAME = 'ic_iss_retido_tomador'
);
PREPARE stmt FROM @add_leads_ic_iss_retido_tomador;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_apontamento_folga_feriado_pk = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE apontamento_folga ADD COLUMN feriado_pk int(11) DEFAULT NULL AFTER apontamento_falta_pk',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'apontamento_folga'
    AND COLUMN_NAME = 'feriado_pk'
);
PREPARE stmt FROM @add_apontamento_folga_feriado_pk;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

CREATE TABLE IF NOT EXISTS feriados (
  pk int(11) NOT NULL AUTO_INCREMENT,
  dt_cadastro datetime NOT NULL,
  usuario_cadastro_pk int(11) NOT NULL,
  nome varchar(255) NOT NULL,
  data date NOT NULL,
  tipo int(11) NOT NULL,
  estado varchar(2) DEFAULT NULL,
  cidade varchar(255) DEFAULT NULL,
  PRIMARY KEY (pk)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

SET @add_agenda_colaborador_padrao_hr_jornada = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE agenda_colaborador_padrao ADD COLUMN hr_jornada_trabalho_intervalo time DEFAULT NULL',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'agenda_colaborador_padrao'
    AND COLUMN_NAME = 'hr_jornada_trabalho_intervalo'
);
PREPARE stmt FROM @add_agenda_colaborador_padrao_hr_jornada;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_agenda_colaborador_padrao_hr_total = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE agenda_colaborador_padrao ADD COLUMN hr_total_expediente time DEFAULT NULL',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'agenda_colaborador_padrao'
    AND COLUMN_NAME = 'hr_total_expediente'
);
PREPARE stmt FROM @add_agenda_colaborador_padrao_hr_total;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_agenda_colaborador_apontamento_ic_status = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE agenda_colaborador_apontamento ADD COLUMN ic_status int(11) DEFAULT ''1''',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'agenda_colaborador_apontamento'
    AND COLUMN_NAME = 'ic_status'
);
PREPARE stmt FROM @add_agenda_colaborador_apontamento_ic_status;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_apontamento_ponto_hr_faltantes = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE apontamento_ponto ADD COLUMN hr_faltantes varchar(25) DEFAULT NULL',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'apontamento_ponto'
    AND COLUMN_NAME = 'hr_faltantes'
);
PREPARE stmt FROM @add_apontamento_ponto_hr_faltantes;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_apontamento_ponto_hr_excedentes = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE apontamento_ponto ADD COLUMN hr_excedentes varchar(25) DEFAULT NULL',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'apontamento_ponto'
    AND COLUMN_NAME = 'hr_excedentes'
);
PREPARE stmt FROM @add_apontamento_ponto_hr_excedentes;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_apontamento_ponto_hr_trabalhadas = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE apontamento_ponto ADD COLUMN hr_trabalhadas varchar(25) DEFAULT NULL',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'apontamento_ponto'
    AND COLUMN_NAME = 'hr_trabalhadas'
);
PREPARE stmt FROM @add_apontamento_ponto_hr_trabalhadas;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

CREATE TABLE IF NOT EXISTS validar_reloginho (
  pk int(11) NOT NULL AUTO_INCREMENT,
  dt_cadastro datetime NOT NULL,
  usuario_cadastro_pk int(11) NOT NULL,
  dt_ult_atualizacao datetime NOT NULL,
  usuario_ult_atualizacao_pk int(11) NOT NULL,
  colaborador_pk int(11) NOT NULL,
  dt_hora_ponto date NOT NULL,
  leads_pk int(11) NOT NULL,
  ic_verificado int(11) NOT NULL,
  PRIMARY KEY (pk)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

SET @add_ponto_ic_validacao_facial = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE ponto ADD COLUMN ic_validacao_facial int(11) DEFAULT ''1''',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'ponto'
    AND COLUMN_NAME = 'ic_validacao_facial'
);
PREPARE stmt FROM @add_ponto_ic_validacao_facial;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_ponto_dt_validacao_facial = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE ponto ADD COLUMN dt_validacao_facial datetime DEFAULT NULL',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'ponto'
    AND COLUMN_NAME = 'dt_validacao_facial'
);
PREPARE stmt FROM @add_ponto_dt_validacao_facial;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @add_ponto_usuario_validacao_facial = (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE ponto ADD COLUMN usuario_validacao_facial int(11) DEFAULT NULL',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'ponto'
    AND COLUMN_NAME = 'usuario_validacao_facial'
);
PREPARE stmt FROM @add_ponto_usuario_validacao_facial;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

INSERT IGNORE INTO modulos (
  pk,
  dt_cadastro,
  usuario_cadastro_pk,
  dt_ult_atualizacao,
  usuario_ult_atualizacao_pk,
  ds_modulo,
  ds_dominio,
  tipo_modulo_pk,
  ds_obs
) VALUES
  (141, NOW(), 1, NOW(), 1, 'Financeiro -> Contas Menu Extrato', 'financeiro_contas_menu_extrato', NULL, NULL),
  (142, NOW(), 1, NOW(), 1, 'Financeiro -> Contas Menu Receita', 'financeiro_contas_menu_receita', NULL, NULL),
  (143, NOW(), 1, NOW(), 1, 'Financeiro -> Contas Menu Despesa', 'financeiro_contas_menu_despesa', NULL, NULL),
  (144, NOW(), 1, NOW(), 1, 'Financeiro -> Contas Menu Lancamentos', 'financeiro_contas_menu_lancamentos', NULL, NULL);

INSERT IGNORE INTO modulos_grupos (modulos_pk, grupos_pk, ic_ins, ic_upd, ic_del, ic_cons)
SELECT m.pk, g.pk, 2, 2, 2, 1
FROM modulos m
JOIN grupos g ON g.pk IN (1, 8, 9, 10)
WHERE m.ds_dominio IN (
  'financeiro_contas_menu_extrato',
  'financeiro_contas_menu_receita',
  'financeiro_contas_menu_despesa',
  'financeiro_contas_menu_lancamentos'
);

INSERT IGNORE INTO modulos_grupos (modulos_pk, grupos_pk, ic_ins, ic_upd, ic_del, ic_cons)
SELECT m.pk, 1, 1, 1, 2, 1
FROM modulos m
WHERE m.ds_dominio = 'status_finaceiro';
SQL
  " 2>&1 | tee -a "${FULL_LOG}"
}

post_validate() {
  {
    log "Pos-validacao do banco"
    docker exec "${CONTAINER_NAME}" mysql -u"${DB_USER}" -p"${DB_PASSWORD}" -Nse \
      "SHOW TABLES FROM \`${DB_NAME}\` LIKE 'usuarios';"
    docker exec "${CONTAINER_NAME}" mysql -u"${DB_USER}" -p"${DB_PASSWORD}" -Nse \
      "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='${DB_NAME}';"
  } 2>&1 | tee -a "${FULL_LOG}"
}

main() {
  local arg="${1:-}"
  local chosen_dump sql_dump

  if [[ "${arg}" == "--help" || "${arg}" == "-h" ]]; then
    usage
    exit 0
  fi

  if [[ "${arg}" == "--monitor" ]]; then
    run_monitor
    exit 0
  fi

  : > "${FULL_LOG}"
  chosen_dump="$(pick_dump "${arg}")"
  sql_dump="$(ensure_sql_dump "${chosen_dump}")"

  "${VERIFY_SCRIPT}" "${sql_dump}" 2>&1 | tee "${PRECHECK_LOG}"

  wait_for_mysql
  copy_dump_to_container "${sql_dump}"
  run_import
  post_import_fixes
  post_validate
}

main "$@"
