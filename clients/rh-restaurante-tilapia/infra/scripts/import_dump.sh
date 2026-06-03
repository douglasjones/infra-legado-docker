#!/usr/bin/env bash
set -euo pipefail

DUMP_PATH="${1:-../database/wwgepr_rest_tilapia.sql.gz}"
DB_NAME="${DB_NAME:-wwgepr_rest_tilapia}"
DB_USER="${DB_USER:-root}"
DB_PASS="${DB_PASS:-SENHA}"
CONTAINER="${CONTAINER:-rh-restaurante-tilapia-mysql}"

if [ ! -f "$DUMP_PATH" ]; then
  echo "Dump nao encontrado: $DUMP_PATH" >&2
  exit 1
fi

gzip -dc "$DUMP_PATH" | docker exec -i "$CONTAINER" mysql --default-character-set=latin1 -u"$DB_USER" -p"$DB_PASS" "$DB_NAME"
