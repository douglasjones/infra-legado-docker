#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")/.."

DUMP="${1:-database/gepros1com_vistoriza.sql.gz}"
DB_NAME="${DB_NAME:-gepros1com_vistoriza}"
MYSQL_ROOT_PASSWORD="${MYSQL_ROOT_PASSWORD:-root}"
LOG_DIR="logs"
LOG_FILE="${LOG_DIR}/verify-import.log"

mkdir -p "$LOG_DIR"
: > "$LOG_FILE"

echo "Contando tabelas esperadas no dump..." | tee -a "$LOG_FILE"
EXPECTED_TABLES="$(gzip -cd "$DUMP" | grep -a -c '^CREATE TABLE ')"
echo "Tabelas no dump: $EXPECTED_TABLES" | tee -a "$LOG_FILE"

echo "Contando tabelas carregadas no MySQL..." | tee -a "$LOG_FILE"
LOADED_TABLES="$(docker compose exec -T mysql mysql -h127.0.0.1 -N -uroot -p"$MYSQL_ROOT_PASSWORD" -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='${DB_NAME}';")"
echo "Tabelas no banco: $LOADED_TABLES" | tee -a "$LOG_FILE"

if [[ "$EXPECTED_TABLES" != "$LOADED_TABLES" ]]; then
  echo "Falha: quantidade de tabelas carregadas diferente do dump." | tee -a "$LOG_FILE"
  exit 1
fi

echo "Validando acesso do usuario legado..." | tee -a "$LOG_FILE"
docker compose exec -T mysql mysql -h127.0.0.1 -N -u gepros1com_vistoriza -pgepros15082008 "$DB_NAME" -e "SELECT DATABASE(), COUNT(*) FROM information_schema.tables WHERE table_schema=DATABASE();" 2>&1 | tee -a "$LOG_FILE"

echo "Verificacao concluida com sucesso." | tee -a "$LOG_FILE"
