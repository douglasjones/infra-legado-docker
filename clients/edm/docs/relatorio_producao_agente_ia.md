# Relatorio para Agente de IA - Subida Producao EDM

Data: 2026-05-15

## 1. Objetivo

Subir o cliente EDM em producao/homologacao usando exatamente o ambiente legado dockerizado localmente, sem melhorias funcionais e sem reescrever o sistema.

Regra principal: manter o legado como esta. A unica alteracao funcionalmente necessaria para Docker foi o host do banco em `app/libs/conectar_info.php`, de `localhost` para `edm-mysql`.

## 2. Localizacao do projeto no ambiente local

Unidade local:

```text
/Volumes/HDDisco
```

Raiz do workspace de migracao:

```text
/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao
```

Raiz do cliente EDM:

```text
/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm
```

## 3. Estrutura local do cliente EDM

```text
clients/edm/
├── app/
├── source/
│   └── edm_code.tar.gz
├── database/
│   └── wwgepr_edm.sql.gz
├── infra/
│   ├── docker-compose.yml
│   ├── docker/
│   │   ├── php/
│   │   └── mysql/
│   └── scripts/
├── docs/
└── logs/
```

Principais caminhos absolutos:

```text
/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/app
/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/source/edm_code.tar.gz
/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/database/wwgepr_edm.sql.gz
/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/infra/docker-compose.yml
/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/infra/scripts
/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/docs
/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/logs
```

## 4. Origem do codigo e banco

Codigo original recebido:

```text
clients/edm/source/edm_code.tar.gz
```

Tamanho:

```text
6.3G
```

Raiz interna do pacote:

```text
edm/
```

App ativa extraida:

```text
clients/edm/app/
```

Entrada web ativa:

```text
clients/edm/app/index.php
```

Dump recebido:

```text
clients/edm/database/wwgepr_edm.sql.gz
```

Tamanho:

```text
91M
```

Banco:

```text
wwgepr_edm
```

## 5. Stack Docker local

Containers:

```text
edm-php
edm-mysql
```

Status local validado:

```text
NAME        IMAGE           SERVICE     STATUS                  PORTS
edm-mysql   mysql:5.7       edm-mysql   Up, healthy             0.0.0.0:3311->3306/tcp
edm-php     infra-edm-php   edm-php     Up                      0.0.0.0:8086->80/tcp
```

Portas locais:

```text
Web:   8086 -> 80
MySQL: 3311 -> 3306
```

URL local:

```text
http://127.0.0.1:8086
```

Versoes:

```text
PHP:   5.6.40 Apache
MySQL: 5.7.44
```

Motivo do PHP 5.6: o legado EDM usa funcoes antigas `mysql_*`, por exemplo `mysql_connect`, `mysql_query`, `mysql_select_db`. Nao migrar para PHP 7.3 sem refatorar o sistema.

## 6. Banco de dados

Credenciais usadas no legado:

```text
Database: wwgepr_edm
Usuario:  wwgepr_edm
Senha:    gepros15082008
Host app: edm-mysql
Porta container: 3306
Porta host local: 3311
```

Credenciais root do container local:

```text
Usuario: root
Senha:   SENHA
```

Charset/collation configurados no MySQL Docker:

```text
character-set-server=latin1
collation-server=latin1_swedish_ci
```

Observacao: o dump inicia com `SET NAMES utf8`, mas as tabelas analisadas usam majoritariamente `DEFAULT CHARSET=latin1`. A configuracao local foi mantida em `latin1` para respeitar o comportamento legado.

## 7. Arquivos criados para Docker

Arquivos de infraestrutura:

```text
clients/edm/infra/docker-compose.yml
clients/edm/infra/docker/php/Dockerfile
clients/edm/infra/docker/php/php.ini
clients/edm/infra/docker/mysql/conf.d/edm.cnf
clients/edm/infra/scripts/up.sh
clients/edm/infra/scripts/down.sh
clients/edm/infra/scripts/logs.sh
clients/edm/infra/scripts/import_dump.sh
clients/edm/infra/scripts/verificar_dump.sh
```

Documentacao criada:

```text
clients/edm/docs/estrutura_padrao_cliente.md
clients/edm/docs/migracao_docker.md
clients/edm/docs/relatorio_producao_agente_ia.md
```

Logs gerados:

```text
clients/edm/logs/import-full.log
clients/edm/logs/import-precheck.log
```

## 8. Unica alteracao aplicada no legado

Arquivo:

```text
clients/edm/app/libs/conectar_info.php
```

Antes:

```php
function getHost(){
        return "localhost";
}
```

Depois:

```php
function getHost(){
        return "edm-mysql";
}
```

Motivo: dentro do container PHP, `localhost` aponta para o proprio container PHP. O banco esta no container `edm-mysql`.

Nao foram aplicadas melhorias, refatoracoes, mudancas de layout, mudancas de regra de negocio ou upgrades de framework.

## 9. Validacoes locais executadas

Dump:

```text
gzip valido
MySQL dump 5.7.44
146 tabelas identificadas no dump
```

Banco importado:

```text
146 tabelas em wwgepr_edm
232 registros em usuariosinternos
1 registro em empresa
```

Aplicacao:

```text
http://127.0.0.1:8086/          -> HTTP 200
http://127.0.0.1:8086/topo.php  -> HTTP 200, formulario de login carregado
http://127.0.0.1:8086/login.php -> HTTP 200
```

PHP:

```text
Modulo mysql carregado
Modulo mysqli carregado
Modulo pdo_mysql carregado
Conexao pelo proprio app/libs/conectar.php validada
mysql_get_server_info retornou 5.7.44
mysql_select_db('wwgepr_edm') retornou OK
```

Login completo nao foi validado com credencial oficial do cliente. O dump contem usuarios legados em `usuariosinternos`.

## 10. Comandos locais principais

Subir ambiente:

```bash
cd /Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/infra
./scripts/up.sh --build
```

Importar banco:

```bash
cd /Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/infra
./scripts/import_dump.sh
```

Verificar containers:

```bash
cd /Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/infra
docker compose ps
```

Ver logs:

```bash
cd /Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/infra
./scripts/logs.sh
```

Parar:

```bash
cd /Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/edm/infra
./scripts/down.sh
```

## 11. Processo recomendado para producao

### 11.1 Arquivos que devem ser enviados

Enviar integralmente:

```text
clients/edm/app/
clients/edm/infra/
clients/edm/database/wwgepr_edm.sql.gz
clients/edm/docs/
```

Preservar tambem, se houver espaco e politica de backup:

```text
clients/edm/source/edm_code.tar.gz
```

### 11.2 Preparar no servidor

No VPS, usar uma pasta equivalente, por exemplo:

```text
/opt/clients/edm
```

Estrutura esperada:

```text
/opt/clients/edm/app
/opt/clients/edm/infra
/opt/clients/edm/database
/opt/clients/edm/docs
/opt/clients/edm/logs
```

### 11.3 Subir containers no VPS

```bash
cd /opt/clients/edm/infra
docker compose up -d --build
```

### 11.4 Importar banco no VPS

```bash
cd /opt/clients/edm/infra
./scripts/import_dump.sh ../database/wwgepr_edm.sql.gz
```

### 11.5 Validar banco no VPS

```bash
docker exec edm-mysql mysql -uroot -pSENHA -Nse "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='wwgepr_edm';"
docker exec edm-mysql mysql -uroot -pSENHA -Nse "SELECT COUNT(*) FROM wwgepr_edm.usuariosinternos;"
docker exec edm-mysql mysql -uroot -pSENHA -Nse "SELECT COUNT(*) FROM wwgepr_edm.empresa;"
```

Valores esperados:

```text
146
232
1
```

### 11.6 Validar HTTP no VPS

```bash
curl -i http://127.0.0.1:8086/
curl -i http://127.0.0.1:8086/topo.php
```

Esperado:

```text
HTTP 200
X-Powered-By: PHP/5.6.40
```

## 12. Ajustes possiveis no VPS

Se a porta `8086` estiver ocupada, alterar em `infra/docker-compose.yml`:

```yaml
ports:
  - "8086:80"
```

Se a porta MySQL `3311` estiver ocupada, alterar:

```yaml
ports:
  - "3311:3306"
```

Nao alterar o host interno `edm-mysql` em `app/libs/conectar_info.php`, a menos que o nome do servico/container MySQL tambem seja alterado.

## 13. Pontos de atencao

- Nao usar PHP 7.3 para este cliente sem refatorar `mysql_*`.
- Nao trocar charset para `utf8mb4` durante a virada; manter comportamento legado.
- Nao misturar arquivos de outros clientes.
- Nao substituir `app/` por outra fonte sem nova validacao.
- Nao apagar `source/edm_code.tar.gz`; ele e a fonte original recebida.
- Confirmar proxy/reverso de producao apontando para a porta interna correta do container web.
- Se o VPS usar proxy externo, o servico `edm-php` pode continuar expondo `80` internamente e o proxy deve encaminhar para ele ou para a porta publicada.

## 14. Checklist final de virada

1. Fazer backup do ambiente atual do VPS, se ja existir.
2. Fazer backup do banco atual do VPS, se ja existir.
3. Enviar `app/`, `infra/`, `database/` e `docs/` do EDM.
4. Conferir `app/libs/conectar_info.php` com host `edm-mysql`.
5. Conferir `infra/docker-compose.yml` com nomes `edm-php` e `edm-mysql`.
6. Conferir portas de producao/homologacao antes de subir.
7. Executar `docker compose up -d --build`.
8. Aguardar `edm-mysql` ficar healthy.
9. Executar `./scripts/import_dump.sh ../database/wwgepr_edm.sql.gz`.
10. Validar contagem de tabelas: `146`.
11. Validar `usuariosinternos`: `232`.
12. Validar `empresa`: `1`.
13. Abrir `/` e `topo.php`.
14. Testar login com credencial oficial do cliente.
15. Testar menu principal apos login.
16. Testar uma tela de consulta e uma tela de cadastro sem salvar dados reais.
17. Verificar logs do `edm-php` e `edm-mysql`.
18. Somente depois apontar DNS/proxy definitivo.

## 15. Estado atual local

Ambiente local EDM esta ativo para teste em:

```text
http://127.0.0.1:8086
```

Containers locais:

```text
edm-php   Up
edm-mysql Up healthy
```
