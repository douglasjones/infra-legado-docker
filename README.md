# Infraestrutura Legado Docker

Este projeto contém a infraestrutura Docker para ambientes PHP legados (5.6 e 7.3) com MySQL e um proxy reverso.

## Estrutura de Diretórios

- **core/**: Contém a configuração principal para o proxy (Nginx Proxy Manager ou Traefik) e o servidor MySQL.
- **images/**: Contém os Dockerfiles para as versões PHP 5.6 e 7.3.
- **clients/**: Contém configurações específicas para cada cliente/projeto, incluindo templates.
- **scripts/**: Contém scripts úteis para gerenciamento de clientes, backup e restauração de banco de dados.

## Como Subir Tudo

1.  **Configurar o Proxy Reverso (Nginx Proxy Manager ou Traefik):**
    *   Vá para `core/proxy/` e configure seu `docker-compose.yml`.
    *   Inicie o proxy: `docker-compose up -d`

2.  **Configurar o MySQL:**
    *   Vá para `core/mysql/` e configure seu `docker-compose.yml`.
    *   Para scripts de inicialização (opcional), coloque arquivos `.sql` em `core/mysql/init/`.
    *   Inicie o MySQL: `docker-compose up -d`

3.  **Criar Redes Compartilhadas:**
    *   É recomendável criar uma rede Docker compartilhada para que os serviços de proxy, mysql e clientes possam se comunicar.
    *   Exemplo: `docker network create client_network` (o nome `client_network` é usado nos `docker-compose.yml` dos clientes).

4.  **Criar um Novo Cliente:**
    *   Use o script `scripts/create-client.sh`:
        ```bash
        ./scripts/create-client.sh <nome_do_cliente> <php_version>
        ```
        Exemplo: `./scripts/create-client.sh meuapp php56`
    *   Isso irá copiar o template apropriado para `clients/<nome_do_cliente>`.
    *   Edite o arquivo `clients/<nome_do_cliente>/env/.env` para ajustar a porta e o nome do cliente, se necessário.

5.  **Adicionar Código do Cliente:**
    *   Copie o código-fonte do seu aplicativo PHP para `clients/<nome_do_cliente>/www/`.

6.  **Iniciar o Serviço do Cliente:**
    *   Vá para `clients/<nome_do_cliente>/` e inicie o serviço: `docker-compose up -d`

## Scripts Úteis

-   **`scripts/create-client.sh <nome_do_cliente> <php_version>`**: Cria um novo diretório de cliente a partir de um template.
-   **`scripts/backup.sh <nome_do_banco> <nome_do_arquivo_backup>`**: Realiza backup de um banco de dados MySQL.
-   **`scripts/restore.sh <nome_do_banco> <nome_do_arquivo_backup>`**: Restaura um banco de dados MySQL a partir de um backup.

## Observações

-   Certifique-se de que as portas definidas nos arquivos `.env` dos clientes não entrem em conflito.
-   A senha do root do MySQL no script de backup/restore é `MY_SQL_ROOT_PASSWORD`. Altere conforme a sua configuração.
