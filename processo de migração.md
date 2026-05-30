# Processo de Migração

Data: 2026-04-25

Objetivo:
- documentar o processo padrao para migrar um cliente legado para Docker
- manter codigo e banco o mais fieis possivel ao legado
- registrar a ordem correta para evitar mistura de fontes e erros de restauracao

Este documento consolida o fluxo que foi usado como referencia nos clientes:
- `america-servis`
- `brasil-servis`

---

## 1. Estrutura padrao do cliente

Cada cliente deve seguir esta organizacao:

- `clients/<cliente>/app/`
- `clients/<cliente>/infra/`
- `clients/<cliente>/database/`
- `clients/<cliente>/source/tar/`
- `clients/<cliente>/docs/`

Uso de cada pasta:

- `app/`: copia ativa do sistema usada pelos containers
- `infra/`: docker-compose, Dockerfiles e scripts operacionais
- `database/`: dump do banco do cliente
- `source/tar/`: fonte oficial do legado compactada e extraida
- `docs/`: historicos, auditorias e instrucoes do cliente

Regra:
- o `app/` deve ser reconstruido a partir da fonte oficial em `source/tar/`
- nao misturar com `ftp`, `referencias` ou copias antigas do `app`

---

## 2. Origem correta do codigo legado

Fonte preferencial:
- arquivo compactado do legado em `source/tar/*.tar.gz`

Fluxo esperado:
1. colocar o arquivo `.tar.gz` em `clients/<cliente>/source/tar/`
2. extrair o legado oficial dentro de `clients/<cliente>/source/tar/<raiz_legado>/`
3. recriar o `app/` a partir dessa fonte extraida

Exemplo de nomes reais usados:
- `source/tar/brasilservis_code.tar.gz`
- `source/tar/brasilservis/`

Regra de integridade:
- preservar a fonte oficial extraida
- usar `app/` apenas como area ativa para Docker

---

## 3. Reconstrucao do `app/`

Passo a passo:

1. fazer backup do `app/` atual se ele ja existir
2. remover apenas o conteudo antigo do `app/`
3. copiar integralmente a raiz oficial extraida para `app/`
4. validar que os pontos de entrada foram copiados

Arquivos e diretorios que devem existir no `app/` reconstruido:
- `public/index.php`
- `app/settings.php` ou `app/app/settings.php`
- `app/middleware.php` ou equivalente
- `app/dependencies.php`
- `app/routes.php`
- `app/routes-api.php`
- `vendor/autoload.php`
- assets JS/CSS locais e globais

Regra:
- nao alterar controller, model, query ou template durante a reconstrucao base
- aplicar apenas o ajuste minimo de ambiente necessario para o Docker subir

---

## 4. Ajuste tecnico minimo na aplicacao

O ajuste minimo normalmente necessario e no host do banco.

Exemplo:
- `localhost` -> nome do container MySQL do cliente

Casos reais:
- `america-mysql`
- `brasil-mysql`

Arquivos tipicos:
- `app/app/settings.php`

Boas praticas:
- manter os valores originais do legado como fallback
- permitir override por variavel de ambiente quando o projeto ja estiver preparado para isso
- nao alterar logica funcional nessa etapa

---

## 5. Infraestrutura Docker

Stack padrao usada:
- PHP 7.3
- MySQL 5.7
- nginx 1.24-alpine

Passos:
1. validar `docker-compose.yml`
2. confirmar volumes apontando para o `app/` correto
3. confirmar `root` do nginx em `/var/www/html/public`
4. confirmar PHP-FPM usando o diretório da aplicacao montado

Validacoes minimas:
- `docker compose config`
- `docker compose up -d --build`
- `docker compose ps`

Containers esperados por cliente:
- `<cliente>-php`
- `<cliente>-nginx`
- `<cliente>-mysql`

---

## 6. Onde colocar o dump do banco

O dump deve ficar na raiz de:

- `clients/<cliente>/database/`

Padrao operacional:
- `.sql.gz` ou `.sql`

Exemplos usados:
- `clients/brasil-servis/database/dump.sql.gz`
- `clients/america-servis/database/dump.sql.gz`

Observacao:
- alguns scripts antigos podem esperar nomes especificos
- se o arquivo tiver outro nome, chamar o script informando explicitamente o caminho

---

## 7. Importacao do dump

Pre-requisitos:
- Docker Desktop ativo
- stack do cliente ja iniciada
- dump presente em `database/`
- espaco em disco para descompactar dumps grandes

Fluxo recomendado:
1. subir os containers
2. validar se o MySQL esta `healthy`
3. validar integridade do `.gz`
4. descompactar para `.sql` quando necessario
5. copiar o `.sql` para `/tmp` dentro do container MySQL
6. rodar a importacao via `SOURCE` dentro do proprio container
7. fazer pos-validacao do schema

Exemplo operacional:

```bash
cd clients/<cliente>/infra
./scripts/up.sh
./scripts/import_dump.sh
```

Quando o nome do dump nao for o esperado pelo script:

```bash
cd clients/<cliente>/infra
./scripts/import_dump.sh ../database/dump.sql.gz
```

Regra importante:
- nao assumir que o script vai localizar automaticamente `dump.sql.gz`
- conferir o nome esperado dentro do `import_dump.sh`

---

## 8. Validacao do dump antes de culpar o codigo

Antes de concluir que o sistema esta com erro funcional, validar:

1. o dump contem as tabelas esperadas
2. o dump contem os dados esperados para o caso testado
3. o dump nao esta truncado
4. a base importada local e a mesma base que se imaginava exportar da producao

Exemplos de verificacao:
- existencia da tabela `usuarios`
- contagem de tabelas do schema
- consulta do colaborador testado
- consulta dos registros de ponto do periodo testado

Regra:
- se a producao mostra dados e o local nao mostra, confirmar primeiro se o dump local contem esses dados

---

## 9. Validacoes minimas apos subir o ambiente

Validar:

1. `/login` responde
2. autenticacao funciona
3. `/menu/principal` abre
4. modulo principal do cliente abre
5. uma tela de edicao de cadastro abre
6. consultas AJAX principais respondem com JSON limpo

Exemplos uteis:
- login
- menu RH
- tela de colaborador
- reloginho

---

## 10. Quando a tela falha com `parsererror`

Causa comum:
- endpoint responde `200`, mas com `warning`, `notice`, `echo` ou HTML antes do JSON

Como validar:
1. abrir logs do nginx/php
2. chamar o endpoint diretamente
3. verificar o corpo bruto da resposta

Regra:
- `parsererror` quase sempre significa resposta suja, nao problema de cache puro

---

## 11. Correcao de ambiente para registro de ponto

Pontos que devem ser revisados:
- parser de JSON no controller
- latitude/longitude opcionais
- tratamento robusto de `ic_ponto_fora_turno`
- tolerancia a imagem invalida
- fallback quando GD nao estiver instalada

Regra:
- o registro de ponto nao deve falhar so porque a imagem nao pode ser recomprimida

---

## 12. Correcao do reloginho

Pontos que devem ser revisados:
- preenchimento automatico das datas no JS
- `cache bust` do asset JS
- consolidacao dos pontos do dia
- suporte a dias com:
  - apenas inicio de intervalo
  - apenas fim de intervalo
  - apenas fim de expediente

Regra:
- o dia deve ser considerado com ponto quando houver qualquer uma das quatro batidas

---

## 13. Ordem recomendada de migracao

1. organizar a estrutura do cliente
2. colocar o `.tar.gz` do legado em `source/tar/`
3. extrair a fonte oficial
4. reconstruir `app/` a partir da fonte oficial
5. aplicar apenas o ajuste minimo de `db.host`
6. validar o `docker-compose`
7. subir a stack
8. colocar o dump em `database/`
9. importar o dump
10. validar login e modulo principal
11. validar dados reais de um caso conhecido
12. so depois iniciar correcoes funcionais

---

## 14. Checklist operacional

- [ ] arquivo legado compactado colocado em `source/tar/`
- [ ] fonte oficial extraida
- [ ] `app/` recriado sem mistura de fontes
- [ ] ajuste minimo de banco aplicado
- [ ] stack Docker sobe sem erro
- [ ] dump colocado em `database/`
- [ ] importacao executada com o arquivo correto
- [ ] login validado
- [ ] menu validado
- [ ] caso real comparado com producao
- [ ] historico do cliente atualizado

---

## 15. Fontes internas usadas nesta consolidacao

- `clients/america-servis/docs/reconstrucao_base_oficial_execucao.md`
- `clients/america-servis/docs/importacao_dump_grande.md`
- `clients/brasil-servis/docs/dockerizacao_legado.md`
- `historico.md`

---

## 16. Modelo de comandos por cliente

Substitua `<cliente>` pelo nome real do cliente.

### 16.1. Verificar estrutura basica

```bash
cd /Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker

ls -lah clients/<cliente>
ls -lah clients/<cliente>/source/tar
ls -lah clients/<cliente>/database
ls -lah clients/<cliente>/infra
```

### 16.2. Extrair o legado compactado

Exemplo generico:

```bash
cd clients/<cliente>/source/tar
tar -xzf arquivo_legado.tar.gz
```

Depois validar:

```bash
ls -lah clients/<cliente>/source/tar
```

### 16.3. Backup do `app/` atual antes de reconstruir

```bash
mkdir -p clients/<cliente>/source/referencias/app-rebuild-history
mv clients/<cliente>/app clients/<cliente>/source/referencias/app-rebuild-history/app-pre-rebuild-$(date +%F-%H%M%S)
mkdir -p clients/<cliente>/app
```

Observacao:
- usar esse fluxo apenas quando o `app/` atual precisar ser preservado

### 16.4. Copiar a fonte oficial para `app/`

Exemplo generico:

```bash
cp -R clients/<cliente>/source/tar/<raiz_legado>/. clients/<cliente>/app/
```

### 16.5. Conferir arquivos de entrada

```bash
ls -lah clients/<cliente>/app
ls -lah clients/<cliente>/app/public
ls -lah clients/<cliente>/app/app
```

### 16.6. Ajustar host do banco

Procurar o arquivo de configuracao:

```bash
rg -n "localhost|DB_HOST|db.host" clients/<cliente>/app
```

Valor esperado:
- nome do container MySQL do cliente

Exemplos:
- `america-mysql`
- `brasil-mysql`

### 16.7. Subir a stack Docker

```bash
cd clients/<cliente>/infra
docker compose up -d --build
docker compose ps
```

### 16.8. Validar aplicacao publicada

Exemplo generico:

```bash
curl -I http://127.0.0.1:<porta>
```

Esperado:
- `200 OK`
- ou `302` redirecionando para `/login`

### 16.9. Importar o dump padrao

Se o script do cliente aceitar o nome padrao do dump:

```bash
cd clients/<cliente>/infra
./scripts/import_dump.sh
```

Se o arquivo estiver com nome diferente:

```bash
cd clients/<cliente>/infra
./scripts/import_dump.sh ../database/dump.sql.gz
```

### 16.10. Monitorar importacao

```bash
cd clients/<cliente>/infra
./scripts/import_dump.sh --monitor
docker compose ps
docker logs <cliente>-mysql
```

### 16.11. Validar schema importado

Exemplo generico:

```bash
docker exec <cliente>-mysql mysql -uroot -pSENHA -e "SHOW TABLES FROM <banco> LIKE 'usuarios';"
docker exec <cliente>-mysql mysql -uroot -pSENHA -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='<banco>';"
```

### 16.12. Validar um caso real do cliente

Exemplos:
- um usuario de login
- um colaborador conhecido
- uma tela que existe na producao
- um periodo de ponto conhecido

Consultas uteis:

```bash
docker exec <cliente>-mysql mysql -uroot -pSENHA -e "SELECT pk, ds_colaborador FROM <banco>.colaboradores LIMIT 10;"
docker exec <cliente>-mysql mysql -uroot -pSENHA -e "SELECT pk, ds_usuario FROM <banco>.usuarios LIMIT 10;"
```

### 16.13. Validar endpoints com erro

Quando a tela quebrar:

```bash
docker logs <cliente>-nginx
docker logs <cliente>-php
```

Quando houver suspeita de JSON sujo:

```bash
docker exec <cliente>-nginx sh -lc "curl -i -s -X POST 'http://127.0.0.1/api/<endpoint>'"
```

### 16.14. Atualizar documentacao do cliente

Depois de concluir:

```bash
ls -lah clients/<cliente>/docs
```

Registrar:
- historico
- arquivos alterados
- pendencias abertas
- ajustes replicaveis
