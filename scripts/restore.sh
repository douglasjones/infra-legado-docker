#!/bin/bash
# scripts/restore.sh

# Verifica se o nome do banco de dados e o arquivo de backup foram fornecidos
if [ -z "$1" ] || [ -z "$2" ]; then
  echo "Uso: $0 <nome_do_banco> <nome_do_arquivo_backup>"
  echo "Exemplo: $0 meu_banco meu_banco_backup.sql"
  exit 1
fi

DB_NAME=$1
BACKUP_FILE=$2
BACKUP_DIR="./core/mysql/backups"

# Verifica se o arquivo de backup existe
if [ ! -f "$BACKUP_DIR/$BACKUP_FILE" ]; then
  echo "Arquivo de backup não encontrado: $BACKUP_DIR/$BACKUP_FILE"
  exit 1
fi

# Executa a restauração
cat "$BACKUP_DIR/$BACKUP_FILE" | docker-compose -f core/mysql/docker-compose.yml exec -T mysql mysql -u root -pMY_SQL_ROOT_PASSWORD "$DB_NAME"

if [ $? -eq 0 ]; then
  echo "Banco de dados '$DB_NAME' restaurado com sucesso a partir de '$BACKUP_DIR/$BACKUP_FILE'."
else
  echo "Erro ao restaurar banco de dados '$DB_NAME'."
fi