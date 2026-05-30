# Dockerizacao Legado ATC Ronda

Data: 2026-05-14

## Origem

- Cliente: `atc-ronda`
- Fonte: `source/atc_code.tar.gz`
- Raiz do pacote: `atc/`
- App ativa: `app/`

## Decisoes tecnicas

- O legado e uma aplicacao PHP direta em raiz, com `index.php`, `controller/`, `model/`, `view/` e `inc/`.
- O nginx usa `root /var/www/html`.
- A stack nao cria container MySQL porque este projeto usa o banco ATC oficial no VPS Hostinger.
- O host padrao do banco no container e `187.127.23.38:3309`, apontando para o container remoto `atc-mysql` exposto pelo VPS.
- A stack usa `name: atc-ronda` para nao conflitar com outros clientes que tambem executam Compose dentro de uma pasta chamada `infra`.

## Arquivos criados

- `infra/docker-compose.yml`
- `infra/docker/nginx/default.conf`
- `infra/docker/php/Dockerfile`
- `infra/scripts/up.sh`
- `infra/scripts/down.sh`
- `infra/scripts/logs.sh`
- `docs/estrutura_padrao_cliente.md`
- `docs/dockerizacao_legado.md`

## Arquivos ajustados na app ativa

- `app/inc/classes/bestflow/DataBase.php`
- `app/inc/DataBase.php`

Os ajustes permitem override de banco por variaveis de ambiente, mantendo os valores originais como fallback.

## Validacao local

- `docker compose config` validado.
- Containers `atc-ronda-php` e `atc-ronda-nginx` iniciados.
- `GET /view/login_form.php` respondeu `200`.
- `GET /controller/conta.controller.php?job=carregarLogo` respondeu JSON `success` apos subir o MySQL compartilhado do cliente `atc`.
