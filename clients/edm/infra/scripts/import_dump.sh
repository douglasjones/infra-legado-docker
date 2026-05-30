#!/usr/bin/env bash
set -Eeuo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
CLIENT_DIR="$(cd "${ROOT_DIR}/.." && pwd)"
LOG_DIR="${CLIENT_DIR}/logs"
DUMP_PATH="${1:-${CLIENT_DIR}/database/wwgepr_edm.sql.gz}"
CONTAINER_NAME="${CONTAINER_NAME:-edm-mysql}"
DB_NAME="${DB_NAME:-wwgepr_edm}"
DB_USER="${DB_USER:-root}"
DB_PASSWORD="${DB_PASSWORD:-SENHA}"
DB_CHARSET="${DB_CHARSET:-latin1}"
DB_COLLATION="${DB_COLLATION:-latin1_swedish_ci}"

mkdir -p "${LOG_DIR}"

log() {
  printf '[%s] %s\n' "$(date '+%Y-%m-%d %H:%M:%S')" "$*"
}

fail() {
  log "ERRO: $*" >&2
  exit 1
}

[[ -f "${DUMP_PATH}" ]] || fail "Dump nao encontrado: ${DUMP_PATH}"

cd "${ROOT_DIR}"

log "Aguardando MySQL em ${CONTAINER_NAME}"
for attempt in $(seq 1 120); do
  if docker exec "${CONTAINER_NAME}" mysqladmin --no-defaults ping -h 127.0.0.1 -u"${DB_USER}" -p"${DB_PASSWORD}" --silent >/dev/null 2>&1; then
    break
  fi
  sleep 5
  if [[ "${attempt}" == "120" ]]; then
    fail "MySQL nao respondeu"
  fi
done

log "Recriando banco ${DB_NAME}"
docker exec -i "${CONTAINER_NAME}" mysql -u"${DB_USER}" -p"${DB_PASSWORD}" --default-character-set="${DB_CHARSET}" <<SQL
DROP DATABASE IF EXISTS \`${DB_NAME}\`;
CREATE DATABASE \`${DB_NAME}\` CHARACTER SET ${DB_CHARSET} COLLATE ${DB_COLLATION};
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO 'wwgepr_edm'@'%' IDENTIFIED BY 'gepros15082008';
FLUSH PRIVILEGES;
SQL

log "Importando ${DUMP_PATH}"
if [[ "${DUMP_PATH}" == *.gz ]]; then
  gzip -t "${DUMP_PATH}"
  gzip -cd "${DUMP_PATH}" | docker exec -i "${CONTAINER_NAME}" mysql -u"${DB_USER}" -p"${DB_PASSWORD}" --default-character-set="${DB_CHARSET}" "${DB_NAME}" 2>&1 | tee "${LOG_DIR}/import-full.log"
else
  docker exec -i "${CONTAINER_NAME}" mysql -u"${DB_USER}" -p"${DB_PASSWORD}" --default-character-set="${DB_CHARSET}" "${DB_NAME}" < "${DUMP_PATH}" 2>&1 | tee "${LOG_DIR}/import-full.log"
fi

log "Validando quantidade de tabelas"
docker exec -i "${CONTAINER_NAME}" mysql -u"${DB_USER}" -p"${DB_PASSWORD}" -Nse "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='${DB_NAME}';" | tee "${LOG_DIR}/import-precheck.log"
