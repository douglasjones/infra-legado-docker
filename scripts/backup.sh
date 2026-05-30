#!/bin/bash
# scripts/backup.sh

# Verifica se o nome do banco de dados e o arquivo de backup foram fornecidos
if [ -z "$1" ] || [ -z "$2" ]; then
  echo "Uso: $0 <nome_do_banco> <nome_do_arquivo_backup>"
  echo "Exemplo: $0 meu_banco meu_banco_backup.sql"
  exit 1
fi

DB_NAME=$1
BACKUP_FILE=$2
BACKUP_DIR="./core/mysql/backups"

# Cria o diretório de backups se não existir
mkdir -p "$BACKUP_DIR"

# Executa o backup
docker-compose -f core/mysql/docker-compose.yml exec mysql mysqldump -u root -pMY_SQL_ROOT_PASSWORD "$DB_NAME" > "$BACKUP_DIR/$BACKUP_FILE"

if [ $? -eq 0 ]; then
  echo "Backup de '$DB_NAME' criado com sucesso em '$BACKUP_DIR/$BACKUP_FILE'."
else
  echo "Erro ao criar backup de '$DB_NAME'."
fi