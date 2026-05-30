#!/bin/bash
# scripts/create-client.sh

# Verifica se o nome do cliente e a versão do PHP foram fornecidos
if [ -z "$1" ] || [ -z "$2" ]; then
  echo "Uso: $0 <nome_do_cliente> <php_version>"
  echo "Exemplo: $0 meu_cliente php56"
  exit 1
fi

CLIENT_NAME=$1
PHP_VERSION=$2

TEMPLATE_DIR=""
if [ "$PHP_VERSION" == "php56" ]; then
  TEMPLATE_DIR="_template-php56"
elif [ "$PHP_VERSION" == "php73" ]; then
  TEMPLATE_DIR="_template-php73"
else
  echo "Versão PHP inválida. Use 'php56' ou 'php73'."
  exit 1
fi

CLIENTS_DIR="./clients"
SOURCE_TEMPLATE_PATH="$CLIENTS_DIR/$TEMPLATE_DIR"
DEST_CLIENT_PATH="$CLIENTS_DIR/$CLIENT_NAME"

# Verifica se o template existe
if [ ! -d "$SOURCE_TEMPLATE_PATH" ]; then
  echo "Diretório de template não encontrado: $SOURCE_TEMPLATE_PATH"
  exit 1
fi

# Copia o template para o novo cliente
cp -r "$SOURCE_TEMPLATE_PATH" "$DEST_CLIENT_PATH"

# Atualiza o .env do novo cliente
ENV_FILE="$DEST_CLIENT_PATH/env/.env"
sed -i "s/CLIENT_NAME=.*/CLIENT_NAME=$CLIENT_NAME/g" "$ENV_FILE"

# Define uma porta para o novo cliente (exemplo: a partir de 8080)
# Você pode implementar uma lógica mais sofisticada para encontrar uma porta livre
# Por simplicidade, vamos usar 8080 + um offset ou pedir para o usuário definir.
# Por enquanto, vamos manter a porta do template e o usuário pode ajustar.
# sed -i "s/PHP_PORT=.*/PHP_PORT=$NEW_PORT/g" "$ENV_FILE"

echo "Cliente '$CLIENT_NAME' criado com sucesso em '$DEST_CLIENT_PATH' usando o template '$TEMPLATE_DIR'."
echo "Lembre-se de configurar a porta no arquivo '$ENV_FILE'."
