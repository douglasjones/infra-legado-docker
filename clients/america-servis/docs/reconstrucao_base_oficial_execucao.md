# Reconstrucao da Base Oficial

Data: 2026-03-26

## Fonte usada

Reconstrucao executada usando exclusivamente:

- `01_fonte_legado/tar_servidor/americaservis/`

Nao foi utilizado nenhum arquivo de:

- `01_fonte_legado/ftp/`
- `01_fonte_legado/referencias/`
- `02_workspace/app-atual/`

## Destino reconstruido

Destino recriado do zero:

- `02_workspace/app-docker/`

Procedimento executado:

1. Remocao apenas do conteudo existente em `02_workspace/app-docker/`
2. Recriacao da pasta
3. Copia integral da raiz oficial para o destino preservando a estrutura

## O que foi copiado

Itens existentes na fonte oficial e copiados para `02_workspace/app-docker/`:

- `app/`
- `public/`
- `vendor/`
- `composer.json`
- `composer.lock`
- `package.json`
- `package-lock.json`
- `vercao.txt`

## Validacao estrutural da copia

Validado no destino:

- `public/index.php`
- `app/settings.php`
- `app/middleware.php`
- `app/dependencies.php`
- `app/routes.php`
- `app/routes-api.php`
- `vendor/autoload.php`
- `public/assets/js/global/`
- `public/assets/js/local/`

## Unico ajuste aplicado na aplicacao

Arquivo alterado:

- `02_workspace/app-docker/app/settings.php`

Ajuste realizado:

- `db.host`: `localhost` -> `america-mysql`

Nenhum outro campo de banco foi alterado.
Nenhum controller, model, query, template ou JS foi modificado.

## Ajustes de infraestrutura aplicados

Arquivo ajustado:

- `03_infra/docker-compose.clean.yml`

Ajustes realizados:

- volume do `america-clean-php`: `../02_workspace/app-docker:/var/www/html`
- volume do `america-clean-nginx`: `../02_workspace/app-docker:/var/www/html:ro`

Validacoes de path realizadas antes da subida:

- app volume do compose clean apontando para `02_workspace/app-docker`
- nginx clean montando `03_infra/docker/nginx/default.clean.conf`
- `root` do nginx clean mantido em `/var/www/html/public`
- php-fpm clean trabalhando em `/var/www/html`

Observacao:

- `03_infra/docker/nginx/default.clean.conf` nao precisou ser alterado

## Subida da stack clean

Stack clean/paralela colocada em execucao com:

- `america-clean-php`
- `america-clean-nginx`

Dependencia operacional usada na validacao:

- container existente `america-mysql`, iniciado para atender o host `db.host=america-mysql`

Status verificado:

- `america-clean-php`: `Up`
- `america-clean-nginx`: `Up`
- `america-mysql`: `Up (healthy)` durante a validacao

## Resultado das validacoes

Validacoes executadas na stack clean em `http://127.0.0.1:8081`:

1. `/login` respondeu `200 OK`
2. login realizado com sucesso via `/api/auth/login`
3. `/menu/principal` respondeu `200 OK` apos autenticacao
4. `/api/usuario/verificarPermissaoMenu` respondeu com `status=true`
5. edicao de Lead abriu em `/lead/leadMainPainel?pk=65&ic_abertura=1` com `200 OK`
6. edicao de Colaborador abriu em `/colaborador/cadForm?colaborador_pk=2&local=1` com `200 OK`

## Problemas que permaneceram

Nenhum erro funcional minimo foi observado nas validacoes executadas.

Ponto operacional a observar:

- a stack clean depende do container `america-mysql` estar em execucao, pois o banco nao esta definido no `docker-compose.clean.yml`

## Checklist de aceite

- [x] `app-docker` recriado a partir da fonte oficial
- [x] nenhuma mistura com `ftp`, `referencias` ou `app-atual`
- [x] apenas `db.host` alterado na aplicacao
- [x] stack clean apontando para a nova base
- [x] login validado
- [x] menu validado
- [x] editar Lead testado
- [x] editar Colaborador testado
- [x] documentacao registrada
