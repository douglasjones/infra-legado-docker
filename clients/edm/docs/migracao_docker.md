# Migracao Docker EDM

Data: 2026-05-15

## Objetivo

Migrar o cliente EDM para Docker mantendo o legado como esta, sem melhorias funcionais.

## Origem

- Codigo: `source/edm_code.tar.gz`
- Raiz interna do pacote: `edm/`
- Banco: `database/wwgepr_edm.sql.gz`

## App ativa

O pacote foi extraido para:

```text
clients/edm/app/
```

A raiz web ficou em:

```text
clients/edm/app/index.php
```

## Docker

Stack criada:

- `edm-php`: PHP 5.6 Apache
- `edm-mysql`: MySQL 5.7

Portas:

- Web: `http://127.0.0.1:8086`
- MySQL: `127.0.0.1:3311`

Banco:

- Database: `wwgepr_edm`
- Usuario: `wwgepr_edm`
- Senha: `gepros15082008`
- Host interno Docker: `edm-mysql`

## Ajuste minimo aplicado no legado

Arquivo:

```text
app/libs/conectar_info.php
```

Alteracao:

```text
localhost -> edm-mysql
```

Motivo: dentro do container PHP, `localhost` aponta para o proprio container PHP. O banco esta no container `edm-mysql`.

## Validacoes executadas

- Dump validado com gzip.
- Dump identificado como MySQL 5.7.44.
- Dump contem 146 tabelas.
- Containers subiram:
  - `edm-mysql` healthy
  - `edm-php` up
- Importacao do dump concluida.
- Banco importado com 146 tabelas.
- Tabela `usuariosinternos`: 232 registros.
- Tabela `empresa`: 1 registro.
- `http://127.0.0.1:8086/` respondeu HTTP 200.
- `http://127.0.0.1:8086/topo.php` respondeu HTTP 200 e exibiu o formulario de login.
- PHP dentro do container conectou ao MySQL usando o proprio `libs/conectar.php`.
- Modulo PHP `mysql` esta carregado.

## Comandos principais

Subir:

```bash
cd clients/edm/infra
./scripts/up.sh --build
```

Importar banco:

```bash
cd clients/edm/infra
./scripts/import_dump.sh
```

Ver status:

```bash
cd clients/edm/infra
docker compose ps
```

Parar:

```bash
cd clients/edm/infra
./scripts/down.sh
```
