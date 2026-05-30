# Implantar Migração no MacBook M1

## Contexto

Este workspace deve rodar diretamente no HD externo no MacBook M1, mantendo o padrão estrutural do Mac mini.

Raiz esperada no HD externo:

```text
/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao
```

Cliente principal de validação:

```text
infra-legado-docker/clients/vistoriza
```

O projeto roda via Docker Compose.

## Pré-requisitos no MacBook M1

- Docker Desktop instalado e aberto.
- HD externo montado em `/Volumes/MACWORK`.
- Terminal com acesso ao Docker.

## Regra Importante

Não tentar copiar containers Docker do Mac mini.

Os volumes Docker serão recriados no MacBook M1. Para cada cliente:

1. entrar na pasta do cliente
2. subir `docker compose up -d --build`
3. importar o dump da pasta `database`
4. validar portas e aplicação

## Cliente Vistoriza

### 1. Entrar na pasta

```bash
cd /Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/vistoriza
```

### 2. Validar estrutura

```bash
ls -lh
ls -lh database
ls -lh source/vistoriza
```

Dump esperado:

```text
database/gepros1com_vistoriza.sql.gz
```

### 3. Conferir Docker Compose

```bash
cat docker-compose.yml
```

O MySQL deve conter:

```yaml
platform: linux/amd64
image: mysql:5.7.44
```

Isso é necessário para rodar no MacBook M1.

### 4. Subir containers

```bash
docker compose up -d --build
```

### 5. Verificar status

```bash
docker compose ps
```

Esperado:

```text
mysql healthy
web up
colaborador up, se existir no compose
```

### 6. Importar banco

```bash
gzip -cd database/gepros1com_vistoriza.sql.gz | docker compose exec -T mysql mysql -uroot -proot gepros1com_vistoriza
```

### 7. Validar banco

```bash
docker compose exec mysql mysql -uroot -proot -e "SHOW DATABASES;"
```

```bash
docker compose exec mysql mysql -uroot -proot gepros1com_vistoriza -e "SHOW TABLES LIMIT 10;"
```

### 8. Ajustar permissões, se necessário

```bash
find source/vistoriza -type d -exec chmod 755 {} \;
find source/vistoriza -type f -exec chmod 644 {} \;
```

### 9. Validar aplicação

```bash
curl -I http://127.0.0.1:8087
curl -I http://127.0.0.1:8088
```

Abrir no navegador:

```text
http://localhost:8087
http://localhost:8088
```

## Problemas Comuns

### Porta ocupada

```bash
lsof -i :8087
lsof -i :8088
lsof -i :33076
```

Se estiver ocupada, alterar portas no `docker-compose.yml` do cliente.

### MySQL não sobe no M1

Confirmar no serviço MySQL:

```yaml
platform: linux/amd64
```

### Banco vazio ou aplicação sem dados

Reimportar dump:

```bash
gzip -cd database/gepros1com_vistoriza.sql.gz | docker compose exec -T mysql mysql -uroot -proot gepros1com_vistoriza
```

### Reset completo do cliente

Usar somente se puder apagar o banco local desse cliente:

```bash
docker compose down -v
docker compose up -d --build
gzip -cd database/gepros1com_vistoriza.sql.gz | docker compose exec -T mysql mysql -uroot -proot gepros1com_vistoriza
```

## Checklist Final

- [ ] Docker Desktop aberto no MacBook M1
- [ ] HD externo montado em `/Volumes/MACWORK`
- [ ] `docker compose up -d --build` executado
- [ ] MySQL `healthy`
- [ ] dump importado
- [ ] `http://localhost:8087` abre
- [ ] `http://localhost:8088` abre, se aplicável
- [ ] logs sem erro crítico

## Observação Para Outros Clientes

Repetir o mesmo padrão:

1. entrar em `infra-legado-docker/clients/NOME_CLIENTE`
2. conferir `docker-compose.yml`
3. subir containers
4. importar dump em `database/*.sql.gz` ou `database/*.sql`
5. validar portas do compose

