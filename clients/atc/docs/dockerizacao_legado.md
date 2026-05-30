# Dockerizacao do Legado ATC

Data: 2026-05-05

## Origem dos arquivos utilizados

Fonte oficial usada para a app ativa:

- `source/tar/atcNew/`

Dump usado:

- `database/dump.sql.gz`

## Estrutura final adotada

- `app/`
- `source/tar/`
- `infra/`
- `database/`
- `docs/`
- `logs/`

## Stack definida

- PHP 7.3 FPM
- Extensoes PHP: `pdo_mysql`, `calendar`
- nginx 1.24-alpine
- MySQL 5.7

## Portas usadas

- nginx: `8085:80`
- MySQL: `3310:3306`

## Ajuste tecnico minimo realizado

Arquivo alterado:

- `app/app/settings.php`

Ajuste:

- `db.host`: `localhost` -> `atc-mysql`

Nenhum controller, model, template, rota, JS ou regra funcional foi alterado nesta dockerizacao inicial.

## Como subir o ambiente

```bash
cd clients/atc/infra
docker compose up -d --build
```

## Como derrubar o ambiente

```bash
cd clients/atc/infra
docker compose down
```

## Como validar logs

```bash
cd clients/atc/infra
./scripts/logs.sh
```

## Como importar o dump

```bash
cd clients/atc/infra
./scripts/import_dump.sh
```

## Root e pontos de execucao validados estruturalmente

- `app/public/index.php`
- `app/app/settings.php`
- `app/app/routes.php`
- `app/app/routes-api.php`
- `app/vendor/autoload.php`

## Validacoes executadas

- `docker compose config` validado.
- Stack subida com `atc-php`, `atc-nginx` e `atc-mysql`.
- Dump validado com `CREATE TABLE usuarios`, `INSERT INTO usuarios` e final `-- Dump completed on 2026-05-05  7:25:10`.
- Importacao concluida no `atc-mysql`.
- Pos-validacao encontrou tabela `usuarios`.
- Schema importado com 163 tabelas.
- Tabela `usuarios` com 16 registros.
- `php -l /var/www/html/app/settings.php` sem erros.
- `/login` respondeu `HTTP 200` em `http://127.0.0.1:8085/login`.
- Login via `/api/auth/login` com `admin` retornou `status=true`.

## Observacoes

- O Compose emitiu aviso de containers orfaos por outros clientes usarem o mesmo nome de projeto default (`infra`). Nenhum container de outro cliente foi removido.
- O primeiro `curl` do host falhou por restricao da sandbox; a validacao com permissao local retornou `HTTP 200`.
- O script de importacao precisou receber o mesmo ajuste ja documentado em clientes anteriores: logs de descompactacao de `.sql.gz` foram enviados para `stderr` para nao contaminar o caminho retornado.
