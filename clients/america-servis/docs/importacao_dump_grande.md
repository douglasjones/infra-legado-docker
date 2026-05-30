# Importacao de dump grande

## Pre-requisitos

- Docker Desktop ativo
- Containers do projeto criados com `docker compose up -d`
- Dump em `backup/database/americaservs_full.sql.gz` ou `backup/database/americaservs_full.sql`
- Espaco em disco livre para descompactar o dump `.gz` em `.sql`

## Subir os containers

```bash
docker compose up -d --build
```

## Importar o dump

```bash
./scripts/import_dump.sh
```

Se quiser informar outro arquivo:

```bash
./scripts/import_dump.sh /caminho/para/dump.sql.gz
```

## Estrategia A

Esta estrategia foi escolhida para evitar pipe cego longo do macOS para o MySQL e manter os `SET SESSION` junto com o restore na mesma sessao do cliente `mysql`.

Fluxo:

- validar integridade do dump
- checar se o dump contem `CREATE TABLE usuarios`, `INSERT INTO usuarios`, `CREATE DATABASE` e `USE`
- copiar o `.sql` para `/tmp/americaservs_full.sql` dentro do container
- executar `SOURCE /tmp/americaservs_full.sql` dentro do `america-mysql`
- registrar logs no host
- validar automaticamente a criacao da tabela `usuarios`

## Validar o dump antes de importar

```bash
./scripts/verificar_dump.sh
```

Ou apontando outro arquivo:

```bash
./scripts/verificar_dump.sh /caminho/para/dump.sql.gz
```

Se `CREATE TABLE usuarios` nao existir, trate isso como problema potencial do dump, nao como falha automatica da importacao.

## Copiar dump para o container

O script principal faz isso automaticamente com `docker cp`, mas o passo equivalente e:

```bash
docker cp backup/database/americaservs_full.sql america-mysql:/tmp/americaservs_full.sql
docker exec america-mysql ls -lh /tmp/americaservs_full.sql
```

Nao use o arquivo diretamente pelo bind mount do macOS para a carga principal.

## Executar a importacao

```bash
./scripts/import_dump.sh
```

O script:

- valida `.sql` ou `.sql.gz`
- gera `logs/import-precheck.log`
- aguarda o MySQL responder
- copia o dump para `/tmp/americaservs_full.sql`
- executa `SOURCE` dentro do container em sessao unica
- grava a execucao em `logs/import-full.log`
- faz pos-validacao da tabela `usuarios`

## Onde ver logs

- Precheck do dump: `logs/import-precheck.log`
- Execucao completa do restore: `logs/import-full.log`
- Monitoramento opcional: `logs/import-monitor.log`
- Status dos containers: `docker compose ps`
- Logs do MySQL: `docker logs america-mysql`

## Como monitorar progresso

```bash
./scripts/import_dump.sh --monitor
```

Esse modo consulta em loop:

- `SHOW FULL PROCESSLIST`
- total de tabelas no schema alvo
- existencia da tabela `usuarios`

## Como verificar a tabela usuarios

Depois da importacao, o script roda automaticamente:

```sql
SHOW TABLES FROM gepros1com_americaservis LIKE 'usuarios';
SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='gepros1com_americaservis';
```

Tambem pode validar manualmente:

```bash
docker exec america-mysql mysql -uroot -pSENHA -e "SHOW TABLES FROM gepros1com_americaservis LIKE 'usuarios';"
```

## Se usuarios nao existir no dump

- confirme o resultado em `logs/import-precheck.log`
- se `CREATE TABLE usuarios` nao aparecer, a ausencia no banco pode ser problema do dump
- nesse caso, valide a origem do backup antes de insistir na importacao

## Se o SQL parecer truncado

- rode `./scripts/verificar_dump.sh`
- revise as ultimas 50 linhas do dump
- se o arquivo terminar abruptamente, o script interrompe a importacao
- gere um novo dump na origem antes de tentar novamente

## Plano B: gerar dump mais importavel na origem

Se o dump original continuar ruim para importar, gere outro na origem com inserts menores:

```bash
mysqldump -uUSUARIO -pSENHA \
  --default-character-set=latin1 \
  --single-transaction \
  --routines \
  --triggers \
  --skip-extended-insert \
  BANCO > dump_importavel.sql
```

Tambem existe um helper local:

```bash
MYSQL_PASSWORD=sua_senha MYSQL_DATABASE=seu_banco ./scripts/gerar_dump_importavel.sh dump_importavel.sql
```
