#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")/.."

DUMP="${1:-database/gepros1com_vistoriza.sql.gz}"
LOG_DIR="logs"
LOG_FILE="${LOG_DIR}/precheck-dump.log"

mkdir -p "$LOG_DIR"
: > "$LOG_FILE"

if [[ ! -f "$DUMP" ]]; then
  echo "Dump nao encontrado: $DUMP" | tee -a "$LOG_FILE"
  exit 1
fi

{
  echo "Arquivo: $DUMP"
  echo "Tamanho:"
  ls -lh "$DUMP"
  echo
  echo "Validando gzip..."
} | tee -a "$LOG_FILE"

gzip -t "$DUMP" 2>&1 | tee -a "$LOG_FILE"

{
  echo
  echo "Cabecalho:"
  gzip -cd "$DUMP" | sed -n '1,35p'
} | tee -a "$LOG_FILE"

{
  echo
  echo "Contando CREATE TABLE no dump..."
  gzip -cd "$DUMP" | grep -a -c '^CREATE TABLE '
} | tee -a "$LOG_FILE"

echo "Precheck concluido. Log: $LOG_FILE" | tee -a "$LOG_FILE"

