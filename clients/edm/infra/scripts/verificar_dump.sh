#!/usr/bin/env bash
set -Eeuo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
CLIENT_DIR="$(cd "${ROOT_DIR}/.." && pwd)"
DUMP_PATH="${1:-${CLIENT_DIR}/database/wwgepr_edm.sql.gz}"

[[ -f "${DUMP_PATH}" ]] || {
  echo "Dump nao encontrado: ${DUMP_PATH}" >&2
  exit 1
}

echo "Arquivo: ${DUMP_PATH}"
ls -lh "${DUMP_PATH}"

if [[ "${DUMP_PATH}" == *.gz ]]; then
  gzip -t "${DUMP_PATH}"
  gzip -cd "${DUMP_PATH}" | grep -nE '^-- Host:|^-- Server version|^/\*!40101 SET NAMES|^CREATE TABLE `|^-- Dump completed' | head -n 40
  echo "Tabelas:"
  gzip -cd "${DUMP_PATH}" | grep -c '^CREATE TABLE `'
else
  grep -nE '^-- Host:|^-- Server version|^/\*!40101 SET NAMES|^CREATE TABLE `|^-- Dump completed' "${DUMP_PATH}" | head -n 40
  echo "Tabelas:"
  grep -c '^CREATE TABLE `' "${DUMP_PATH}"
fi
