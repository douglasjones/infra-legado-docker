# Vistoriza Docker

Migracao Docker criada especificamente para o legado do cliente Vistoriza.

## Servicos

- Sistema principal: `http://localhost:8087`
- Subprojeto colaborador/documentos: `http://localhost:8088`
- MySQL 5.7.44 local: `127.0.0.1:33076`

O codigo legado usa `localhost` para o MySQL. O container PHP mantem esse comportamento criando um socket local `/var/run/mysqld/mysqld.sock` que encaminha para o servico `mysql`, sem alterar `app/settings.php`.

## Banco Grande

O dump fica em `database/gepros1com_vistoriza.sql.gz` e deve ser importado por streaming, sem descompactar em disco.

```bash
cd infra-legado-docker/clients/vistoriza
scripts/precheck_dump.sh
scripts/import_dump.sh
```

O import recria o banco `gepros1com_vistoriza`, importa o dump e compara a quantidade de tabelas criadas com a quantidade esperada no arquivo.

## Subir Aplicacao

```bash
cd infra-legado-docker/clients/vistoriza
docker compose up -d
```

Logs:

```bash
docker compose logs -f web
docker compose logs -f colaborador
docker compose logs -f mysql
```

