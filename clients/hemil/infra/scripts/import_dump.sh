#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")/.."

dump="../database/gepros1com_hemil.sql.gz"

if [ ! -f "$dump" ]; then
  echo "Dump nao encontrado: $dump" >&2
  exit 1
fi

docker compose exec -T hemil-mysql sh -c 'mysqladmin --no-defaults ping -h 127.0.0.1 -uroot -p"$MYSQL_ROOT_PASSWORD" --silent'
gzip -cd "$dump" | docker compose exec -T hemil-mysql mysql -uroot -pSENHA gepros1com_hemil
