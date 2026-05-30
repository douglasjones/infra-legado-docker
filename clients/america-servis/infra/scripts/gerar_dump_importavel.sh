#!/usr/bin/env bash

set -Eeuo pipefail

MYSQL_USER="${MYSQL_USER:-root}"
MYSQL_PASSWORD="${MYSQL_PASSWORD:-}"
MYSQL_DATABASE="${MYSQL_DATABASE:-}"
OUTPUT_FILE="${1:-dump_importavel.sql}"
MYSQL_DEFAULT_CHARSET="${MYSQL_DEFAULT_CHARSET:-latin1}"

if [[ -z "${MYSQL_PASSWORD}" || -z "${MYSQL_DATABASE}" ]]; then
  cat <<'EOF'
Uso:
  MYSQL_PASSWORD=sua_senha MYSQL_DATABASE=seu_banco ./scripts/gerar_dump_importavel.sh [arquivo_saida.sql]

Comando base utilizado:
  mysqldump --default-character-set=latin1 --single-transaction --routines --triggers --skip-extended-insert BANCO > dump_importavel.sql
EOF
  exit 1
fi

exec mysqldump \
  -u"${MYSQL_USER}" \
  -p"${MYSQL_PASSWORD}" \
  --default-character-set="${MYSQL_DEFAULT_CHARSET}" \
  --single-transaction \
  --routines \
  --triggers \
  --skip-extended-insert \
  "${MYSQL_DATABASE}" > "${OUTPUT_FILE}"
