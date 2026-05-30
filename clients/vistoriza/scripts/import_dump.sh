#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")/.."

DUMP="${1:-database/gepros1com_vistoriza.sql.gz}"
DB_NAME="${DB_NAME:-gepros1com_vistoriza}"
DB_USER="${DB_USER:-gepros1com_vistoriza}"
DB_PASS="${DB_PASS:-gepros15082008}"
MYSQL_ROOT_PASSWORD="${MYSQL_ROOT_PASSWORD:-root}"
LOG_DIR="logs"
LOG_FILE="${LOG_DIR}/import-dump.log"

mkdir -p "$LOG_DIR"
: > "$LOG_FILE"

if [[ ! -f "$DUMP" ]]; then
  echo "Dump nao encontrado: $DUMP" | tee -a "$LOG_FILE"
  exit 1
fi

echo "Validando gzip antes da importacao..." | tee -a "$LOG_FILE"
gzip -t "$DUMP" 2>&1 | tee -a "$LOG_FILE"

echo "Subindo MySQL..." | tee -a "$LOG_FILE"
docker compose up -d mysql 2>&1 | tee -a "$LOG_FILE"

echo "Aguardando MySQL ficar pronto..." | tee -a "$LOG_FILE"
until docker compose exec -T mysql mysqladmin ping -h127.0.0.1 -uroot -p"$MYSQL_ROOT_PASSWORD" --silent >/dev/null 2>&1; do
  sleep 5
done

echo "Recriando banco e usuario do legado..." | tee -a "$LOG_FILE"
docker compose exec -T mysql mysql -h127.0.0.1 -uroot -p"$MYSQL_ROOT_PASSWORD" <<SQL 2>&1 | tee -a "$LOG_FILE"
SET GLOBAL max_allowed_packet=1073741824;
SET GLOBAL net_read_timeout=3600;
SET GLOBAL net_write_timeout=3600;
DROP DATABASE IF EXISTS \`${DB_NAME}\`;
CREATE DATABASE \`${DB_NAME}\` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
CREATE USER IF NOT EXISTS '${DB_USER}'@'%' IDENTIFIED BY '${DB_PASS}';
ALTER USER '${DB_USER}'@'%' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'%';
FLUSH PRIVILEGES;
SQL

echo "Importando dump compactado por streaming. Esta etapa pode demorar bastante." | tee -a "$LOG_FILE"
set -o pipefail
gzip -cd "$DUMP" | docker compose exec -T mysql mysql \
  -h127.0.0.1 \
  -uroot \
  -p"$MYSQL_ROOT_PASSWORD" \
  --database="$DB_NAME" \
  --binary-mode=1 \
  --default-character-set=utf8 \
  --max_allowed_packet=1G \
  --net_buffer_length=1M \
  2>&1 | tee -a "$LOG_FILE"

echo "Importacao finalizada. Rodando verificacao..." | tee -a "$LOG_FILE"
scripts/verify_import.sh "$DUMP" 2>&1 | tee -a "$LOG_FILE"
