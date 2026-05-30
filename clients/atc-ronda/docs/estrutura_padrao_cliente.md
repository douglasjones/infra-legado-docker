# Estrutura Padrao do Cliente

Data: 2026-05-14

## Estrutura final

```text
clients/atc-ronda/
├── app/
├── source/
├── infra/
│   ├── docker/
│   ├── docker-compose.yml
│   └── scripts/
├── database/
├── docs/
└── logs/
```

## Fonte oficial e app ativa

Fonte oficial preservada:

- `source/atc_code.tar.gz`

App ativa em Docker:

- `app/`

Observacao:

- o pacote foi extraido para `app/` removendo a raiz `atc/`
- nenhum arquivo dentro de `source/` foi alterado

## Infra Docker

- PHP: `7.3-fpm-buster`
- nginx: `1.24-alpine`
- MySQL: nao ha container MySQL proprio para este cliente
- Compose project: `atc-ronda`

Porta padrao:

- aplicacao nginx: `http://127.0.0.1:8086`

## Banco

O legado usa banco ATC compartilhado.

Credenciais padrao preservadas:

- banco: `gepros1com_atc`
- usuario: `gepros1com_atc`
- senha: `gepros15082008`

No Docker, a conexao e controlada por variaveis:

- `DB_HOST` padrao: `187.127.23.38`
- `DB_PORT` padrao: `3309`
- `DB_USER` padrao: `gepros1com_atc`
- `DB_PASSWORD` padrao: `gepros15082008`
- `DB_NAME` padrao: `gepros1com_atc`

Esse padrao usa o MySQL oficial ATC no VPS Hostinger exposto em `187.127.23.38:3309`, sem criar banco proprio para `atc-ronda`.

Pre-requisito local:

- acesso de rede liberado do ambiente local para `187.127.23.38:3309`

## Ajustes aplicados na app ativa

- `app/inc/classes/bestflow/DataBase.php` aceita variaveis de ambiente para conexao MySQL.
- `app/inc/DataBase.php` aceita variaveis de ambiente para conexao MySQL.
- `infra/docker/php/Dockerfile` habilita `mysqli`, `pdo_mysql`, `calendar` e `short_open_tag`.
- `infra/docker/php/Dockerfile` desativa exibicao de warnings/notices em tela e registra erros em log.
- `infra/docker/nginx/default.conf` usa root em `/var/www/html`, pois o legado nao tem pasta `public/`.

## Operacao

```bash
cd clients/atc-ronda/infra
./scripts/up.sh
./scripts/down.sh
./scripts/logs.sh
```

## Checklist

- [x] existe `app/`
- [x] existe `source/`
- [x] existe `infra/`
- [x] existe `database/`
- [x] existe `docs/`
- [x] existe `logs/`
- [x] compose aponta para `app/`
- [x] app nao possui banco proprio
- [x] fonte oficial preservada em `source/atc_code.tar.gz`
