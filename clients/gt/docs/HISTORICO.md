# Historico - GT

## 2026-05-14

### Solicitacao

Registrar tudo que foi feito no cliente GT e preparar a referencia para subida do codigo e banco local funcional para producao.

### Estado final local

Cliente GT funcional em Docker local:

- URL local: `http://localhost:8086`
- container web: `gt-nginx`
- container PHP: `gt-php`
- container MySQL: `gt-mysql`
- banco: `gepros1com_gt`
- usuario MySQL: `gepros1com_gt`
- senha MySQL: `gepros15082008`
- porta web local: `8086`
- porta MySQL local: `3312`

Regra de migracao mantida:

- codigo base da GT deve seguir Brasil Servis;
- banco deve ser o banco do cliente GT;
- nao alterar fluxo, senha ou comportamento legado sem evidencia;
- corrigir somente incompatibilidades de Docker/schema/erro real.

### Codigo aplicado/validado

Arquivos com ajustes relevantes no estado local funcional:

- `app/app/settings.php`
- `app/app/dependencies.php`
- `app/app/src/models/Lancamento.php`
- `app/app/src/models/PontoFolha.php`
- `app/app/src/controllers/PontoFolhaController.php`
- `app/public/assets/js/local/financeiro_grid_extrato_mes.js`
- `app/app/templates/partials/financeiro_grid_extrato_mes.twig`
- `app/app/templates/ocorrencia/partials/financeiro_grid_extrato_mes.twig`

### Banco local funcional

O banco local do container `gt-mysql` contem os ajustes de schema necessarios para o codigo Brasil Servis funcionar com a base GT:

- `leads.dia_faturamento`
- `leads.ic_inss_aplicacao`
- `leads.ic_iss_retido_tomador`
- `apontamento_folga.feriado_pk`
- tabela `feriados`
- `agenda_colaborador_padrao.hr_total_expediente`
- `agenda_colaborador_padrao.hr_jornada_trabalho_intervalo`

Senha validada no dump local funcional:

- usuario: `admin`
- senha: `@Gpres_25`

Observacao:

- `@Gpros_25` foi testada e nao autentica no banco GT atual.
- O dump GT restaurado contem `@Gpres_25`.

### Validacoes finais

Valido localmente:

- `POST /api/auth/login` com `admin / @Gpres_25` retornou `status=true`.
- `GET /api/feriado/listarFeriadoRelogio?...` retornou `HTTP 200` com JSON valido.
- `POST /api/ponto_folha/listarConsultaPontoColaborador?...` retornou `HTTP 200` com JSON valido.
- `POST /api/lancamento/listarExtratoMes?...` retornou `HTTP 200` com `status=true`.
- `php -l` sem erro nos arquivos PHP alterados e validados dentro do container `gt-php`.

### Orientacao registrada para producao

Para subir a GT no VPS de producao, usar o estado local funcional como fonte unica:

1. Gerar dump do banco local funcional:

```bash
docker exec gt-mysql mysqldump -ugepros1com_gt -pgepros15082008 --single-transaction --routines --triggers gepros1com_gt | gzip > gt_producao_$(date +%Y%m%d_%H%M%S).sql.gz
```

2. Enviar para o VPS:

- dump gerado do container local;
- pasta local `infra-legado-docker/clients/gt/app`.

3. Antes de substituir no VPS:

- fazer backup do banco GT atual de producao;
- fazer backup da pasta `app` atual da GT;
- confirmar containers/caminhos da GT para nao afetar outro cliente.

4. Espelhar codigo usando `rsync --delete` somente na pasta `app` da GT:

```bash
rsync -avz --delete infra-legado-docker/clients/gt/app/ usuario@VPS:/CAMINHO/DO/CLIENTE/GT/app/
```

5. Importar o dump no banco GT do VPS:

```bash
gunzip -c gt_producao_YYYYMMDD_HHMMSS.sql.gz | docker exec -i gt-mysql mysql -ugepros1com_gt -pgepros15082008 gepros1com_gt
```

6. Reiniciar somente containers GT:

```bash
docker restart gt-php gt-nginx
```

7. Validar no VPS:

- `/login` abre;
- `admin / @Gpres_25` autentica;
- `RH > Colaboradores` carrega;
- `RH > Acompanhamento de Ponto` nao mostra erro DataTables;
- `Pesquisar Ponto` nao retorna `Falhou a requisicao`;
- `Financeiro > Contas a Pagar e Receber` carrega sem erro.

Pontos criticos:

- nao alterar senha no banco;
- nao importar dump em banco de outro cliente;
- nao copiar codigo da ATC para GT;
- nao reiniciar containers de outros clientes;
- manter codigo GT baseado no Brasil Servis com os ajustes locais ja aplicados.

## 2026-05-13

### Solicitacao

Ler o historico da ATC e aplicar na GT as correcoes documentadas.

### Correcoes aplicadas

Foram aplicados na GT os ajustes documentados na ATC para ambiente Docker/proxy, assets de data e financeiro:

- `app/app/settings.php`: URL base passou a considerar `HTTP_X_FORWARDED_PROTO`, `HTTP_X_FORWARDED_SSL` e `HTTP_X_FORWARDED_HOST`, mantendo conexao GT em `gt-mysql/gepros1com_gt`.
- `app/app/dependencies.php`: `base_url()` do Twig foi fixado como caminho relativo (`setBaseUrl('')`).
- `app/public/assets/js/local/financeiro_grid_extrato_mes.js`: adicionada protecao para retorno vazio/erro antes de acessar `arrCarregar.data`.
- `app/app/src/models/Lancamento.php`: removida dependencia de `cal_days_in_month()`, ajustada baixa parcial por subquery agregada e adicionadas verificacoes antes de acessar lead/colaborador/fornecedor relacionado.
- `app/app/templates/partials/financeiro_grid_extrato_mes.twig`: asset financeiro atualizado para `v=15`.
- `app/app/templates/ocorrencia/partials/financeiro_grid_extrato_mes.twig`: asset financeiro atualizado para `v=15`.

### Ajustes de schema

No banco/container GT:

- container: `gt-mysql`
- banco: `gepros1com_gt`

Foram adicionadas as colunas documentadas na ATC:

```sql
ALTER TABLE leads
  ADD COLUMN dia_faturamento int(11) DEFAULT NULL AFTER leads_pai_pk,
  ADD COLUMN ic_inss_aplicacao int(11) DEFAULT NULL AFTER dia_faturamento,
  ADD COLUMN ic_iss_retido_tomador int(11) DEFAULT NULL AFTER ic_inss_aplicacao;

ALTER TABLE apontamento_folga
  ADD COLUMN feriado_pk int(11) DEFAULT NULL AFTER apontamento_falta_pk;
```

### Validacoes

- `php -l` sem erros em `settings.php`, `dependencies.php` e `Lancamento.php` dentro do container `gt-php`.
- Templates financeiros apontando para `/assets/js/local/financeiro_grid_extrato_mes.js?v=15`.
- `POST /api/lancamento/listarExtratoMes` retornou `HTTP 200` com `status=true`.
- Login validado:
  - `admin / @Gpres_25`: `status=true`
  - `admin / @Gpros_25`: `status=false`
- O dump GT restaurado contem `usuarios.ds_senha = @Gpres_25` para o usuario `admin`.

### Complemento

A tela `/colaborador/receptivo?local=1` apresentou alerta:

```text
DataTables warning: table id=tblFeriado - Invalid JSON response
```

Causa identificada:

- `GET /api/feriado/listarFeriadoRelogio` retornava erro SQL em texto:
  - `Table 'gepros1com_gt.feriados' doesn't exist`

Correcao aplicada:

- Criada a tabela `feriados` na GT usando a estrutura existente no dump Brasil Servis:

```sql
CREATE TABLE `feriados` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `dt_cadastro` datetime NOT NULL,
  `usuario_cadastro_pk` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
```

Validacao:

- `GET /api/feriado/listarFeriadoRelogio?...` retornou `HTTP 200` com JSON valido:

```json
{"status":true,"data":[],"message":"Dados carregados com sucesso","iTotalDisplayRecords":0,"iTotalRecords":0}
```

### Complemento 2

A tela `/colaborador/receptivo` apresentou erro ao clicar em `Pesquisar Ponto`:

```text
Falhou a requisicao: error
```

Causa identificada:

- `POST /api/ponto_folha/listarConsultaPontoColaborador` retornava `500`.
- O banco GT nao tinha as colunas usadas pelo codigo base em `agenda_colaborador_padrao`:
  - `hr_total_expediente`
  - `hr_jornada_trabalho_intervalo`
- Para o colaborador testado, a agenda selecionada terminava em `2025-12-31`, sem escala ativa para `05/2026`; o model continuava a execucao sem dados de escala e montava SQL invalido.

Correcoes aplicadas:

```sql
ALTER TABLE agenda_colaborador_padrao
  ADD COLUMN hr_total_expediente time DEFAULT NULL AFTER hr_retorno_intervalo,
  ADD COLUMN hr_jornada_trabalho_intervalo time DEFAULT NULL AFTER hr_total_expediente;
```

- `app/app/src/models/PontoFolha.php`: quando nao existe escala para o colaborador/periodo, a API retorna lista vazia em vez de erro.
- `app/app/src/controllers/PontoFolhaController.php`: o `catch` do endpoint foi ajustado para retornar JSON valido no Slim.

Validacao:

- `php -l /var/www/html/app/src/models/PontoFolha.php` sem erro.
- `POST /api/ponto_folha/listarConsultaPontoColaborador?...` retornou:

```json
{"status":true,"message":"","data":[]}
```

## 2026-05-05

### Solicitacao

Migrar o cliente GT para Docker usando a base de dados GT e o codigo migrado da Brasil Servis como base da aplicacao.

### Insumos

- Banco: `clients/gt/database/gepros1com_gt.sql.gz`
- Codigo de referencia solicitado: `clients/brasil-servis/app`
- Codigo legado recebido da GT: `clients/gt/source/gt_code.tar.gz`

### Acao realizada

Foi criada a estrutura ativa do cliente GT:

- `clients/gt/app`
- `clients/gt/infra`
- `clients/gt/docs`
- `clients/gt/logs`

O `app` e a infraestrutura Docker foram criados a partir do cliente Brasil Servis, com ajustes de ambiente para GT:

- container PHP: `gt-php`
- container nginx: `gt-nginx`
- container MySQL: `gt-mysql`
- banco: `gepros1com_gt`
- usuario: `gepros1com_gt`
- porta web: `8086`
- porta MySQL: `3312`

O arquivo `app/app/settings.php` foi ajustado para conectar no banco `gt-mysql`.

### Importacao do banco

O dump `gepros1com_gt.sql.gz` foi validado com `gzip -t`.

Durante a primeira execucao do importador, o script herdado confundiu logs de descompactacao com o caminho do SQL. A descompactacao gerou corretamente:

- `clients/gt/database/dump.sql`

A importacao foi concluida usando esse `.sql`.

Pos-validacao:

- tabela `usuarios` encontrada
- total de tabelas: `148`
- usuarios ativos identificados, incluindo `admin`

### Ajustes de schema

O codigo Brasil Servis consulta `leads.dia_faturamento`, mas a base GT nao possuia essa coluna.

Foi adicionada:

- `leads.dia_faturamento int(11) NULL DEFAULT NULL`

### Validacoes

- `docker compose config` executado sem erro.
- Stack GT subiu com containers `gt-nginx`, `gt-php`, `gt-mysql`.
- `gt-mysql` ficou `healthy`.
- `/login` respondeu `HTTP 200` dentro do container.
- `POST /api/auth/login` com `admin` retornou `status=true`.
- `/menu/principal` respondeu `HTTP 200` apos login.
- `/api/lead/listarTodos` respondeu `HTTP 200` apos ajuste de schema.
- Lint PHP sem erros em `app/settings.php`.

### Acesso local

- Sistema GT: `http://127.0.0.1:8086/login`
- Usuario validado: `admin`
- Senha validada: `@Gpres_25`
