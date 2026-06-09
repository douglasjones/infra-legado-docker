# Historico de Tarefas

Este arquivo registra, em ordem cronologica, as tarefas concluidas neste cliente.

## 2026-06-09

### Solicitacao

Corrigir o relatorio de Rondas no ATC, que apresentava erro de `Invalid JSON response` na tela de resultado e, em seguida, passou a bloquear a geracao quando as datas vinham vazias na pesquisa.

### Solicitacao complementar

Ajustar a geracao de QR Code em `Leads > Gerar QRCode` para usar o padrao legado com URL fixa de producao:

```text
https://gepros1.com.br/crm/facilities/atc/view/ronda_cad_form.php?posto=<posto>&local=<local>
```

Tambem foi necessario remover um erro de JavaScript na tela quando a URL vinha com `?&...` e tratar corretamente o caso em que o posto ainda nao possui pontos cadastrados.

### Causa raiz

Foram identificados dois problemas no fluxo:

1. A API `/api/ronda/relRondas` fazia consulta sem periodo obrigatorio e tentava carregar volume muito grande da tabela `ronda`, causando `Allowed memory size exhausted` e retornando HTML de erro no lugar do JSON esperado pelo DataTables.
2. A tela de pesquisa nao inicializava as datas com valor padrao, entao a nova protecao do backend passou a exigir datas preenchidas sem oferecer um fluxo amigavel ao usuario.
3. A tela de resultado estava reenviando os filtros errados, usando os campos de descricao em vez dos campos hidden com os PKs reais de cliente e posto.

### Ajustes aplicados em arquivos

Arquivo:

- `app/app/src/models/Ronda.php`

Ajustes:

- Removido o `echo json_encode(...); exit(0);` direto do model.
- Passado a retornar objeto estruturado para o controller.
- Tornado o periodo de ronda obrigatorio no backend para evitar consulta sem filtro.
- Refeito o filtro usando binds e PKs reais de cliente/posto:
  - `ll.pk = :leads_clientes_pk`
  - `l.pk = :leads_pk`
- Mantido retorno JSON valido mesmo em cenario sem periodo informado.
- Padronizado retorno com `COALESCE(...)` para evitar campos nulos no grid.

Arquivo:

- `app/public/assets/js/local/rel_rondas_res.js`

Ajuste:

- Corrigido o envio dos filtros na tela de resultado para usar:
  - `#leads_clientes_pk`
  - `#leads_pk`

Em vez de:

- `#ds_lead_clientes`
- `#ds_lead`

Arquivo:

- `app/public/assets/js/local/rel_rondas_pesq.js`

Ajustes:

- Adicionada inicializacao automatica de `dt_ini_ronda` e `dt_fim_ronda` com a data atual ao abrir a tela.
- Adicionada protecao para preencher ambas com a data atual quando os dois campos vierem vazios antes do envio.
- Mantida validacao para impedir envio com apenas uma das datas preenchida.

Arquivos:

- `app/app/templates/relatorio/operacional/rel_rondas_pesq.twig`
- `app/app/templates/ocorrencia/relatorio/operacional/rel_rondas_pesq.twig`

Ajuste:

- Atualizado o versionamento do asset JS para `rel_rondas_pesq.js?v=16`, forcando o navegador a descartar cache antigo.

Arquivo:

- `app/public/assets/js/global/bestflow.js`

Ajustes:

- Corrigido o parser global de query string para suportar URLs com segmentos vazios, como `?&ds_lead=...&pk=...`.
- Evitado erro de `trim()` em parametros indefinidos.

Arquivo:

- `app/public/assets/js/local/qrCode.js`

Ajustes:

- Alterada a geracao do QR Code para voltar ao padrao legado com URL fixa de producao:

```text
https://gepros1.com.br/crm/facilities/atc/view/ronda_cad_form.php?posto=<posto>&local=<local>
```

- O QR agora carrega:
  - nome do posto de trabalho em `posto`
  - descricao do ponto/local de ronda em `local`
- Removido toast de erro quando o posto ainda nao possui pontos QR cadastrados, mantendo a tela vazia para inclusao manual.
- Mantido toast apenas para falha real na API de carregamento.

Arquivo:

- `app/app/templates/lead/qrCode.twig`

Ajuste:

- Atualizado o versionamento do asset para `qrCode.js?v=19`.

Arquivo:

- `app/public/crm/facilities/atc/view/ronda_cad_form.php`

Ajuste:

- Criado arquivo de compatibilidade para o caminho legado do ATC.
- O arquivo recebe `posto` e `local` pela query string e redireciona para `/ronda/legado`.

### Arquivos que precisam subir no VPS

```text
app/app/src/models/Ronda.php
app/public/assets/js/local/rel_rondas_res.js
app/public/assets/js/local/rel_rondas_pesq.js
app/app/templates/relatorio/operacional/rel_rondas_pesq.twig
app/app/templates/ocorrencia/relatorio/operacional/rel_rondas_pesq.twig
app/public/assets/js/global/bestflow.js
app/public/assets/js/local/qrCode.js
app/app/templates/lead/qrCode.twig
app/public/crm/facilities/atc/view/ronda_cad_form.php
```

### Validacoes locais executadas

Dentro do container `atc-php`:

```bash
php -l /var/www/html/app/src/models/Ronda.php
```

Resultado:

- sem erros de sintaxe.

Validacao da API sem datas:

```bash
curl -s 'http://127.0.0.1:8085/api/ronda/relRondas?leads_clientes_pk=%20&leads_pk=%20&dt_ini_ronda=&dt_fim_ronda='
```

Resultado:

```json
{"status":false,"message":"Informe a data inicial e final da ronda.","data":[]}
```

Validacao da API com datas:

```bash
curl -s 'http://127.0.0.1:8085/api/ronda/relRondas?leads_clientes_pk=%20&leads_pk=%20&dt_ini_ronda=09/06/2026&dt_fim_ronda=09/06/2026'
```

Resultado:

```json
{"status":true,"message":"Dados carregados com sucesso !","data":[]}
```

Validacao do QR Code:

- Confirmado que o posto `pk=3` nao possuia registros em `lead_ronda_qrcode`.
- Confirmado que tambem nao havia historico legado em `ronda` para esse posto.
- A tela passou a abrir sem erro JavaScript e sem toast indevido, pronta para inclusao manual de linhas.

Validacao do arquivo legado ATC:

```bash
php -l app/public/crm/facilities/atc/view/ronda_cad_form.php
```

Resultado:

- sem erros de sintaxe.

### Validacoes recomendadas no VPS

Após publicar os arquivos:

1. Abrir `Relatorios > Operacional > Rondas`.
2. Confirmar que `Dt Ini Ronda` e `Dt Fim Ronda` carregam automaticamente com a data atual.
3. Gerar o relatorio sem alterar os campos para validar o fluxo padrao.
4. Gerar novamente filtrando por cliente/posto para validar os PKs corretos.

No navegador, nao deve mais aparecer:

```text
DataTables warning: table id=tblResultado - Invalid JSON response
Allowed memory size exhausted
```

## 2026-05-13

### Solicitacao

Registrar as correcoes aplicadas apos deploy do ATC no VPS, onde o sistema nao se comportava igual ao ambiente local.

Problemas reportados no VPS:

- `RH > Colaboradores > Editar` ficava carregando.
- `RH > Acompanhamento de Ponto` nao carregava datas automaticamente e os campos de data ficavam sem mascara.
- `Financeiro > Contas a Pagar e Receber` ficava carregando ou retornava `Falhou a requisicao: error`.
- No console do navegador apareciam erros como:
  - `$(...).datepicker is not a function`
  - `ERR_CERT_COMMON_NAME_INVALID`
  - `Cannot read properties of undefined (reading 'data')`
  - `POST /api/lancamento/listarExtratoMes ... 500 Internal Server Error`

### Causa raiz

Foram identificadas causas distintas:

1. `base_url()` gerava URLs absolutas inconsistentes em ambiente VPS/proxy, fazendo assets JS/CSS carregarem com protocolo/host/porta diferentes da pagina.
2. O navegador carregava assets criticos de data em URL incorreta, impedindo `bootstrap-datepicker` e `daterangepicker` de inicializarem.
3. O JS do extrato mensal financeiro assumia que `carregarController()` sempre retornaria objeto com `data`, mas em falha de API o retorno vinha `undefined` e a tela quebrava.
4. O backend do extrato mensal financeiro tinha fragilidades no SQL/model:
   - dependencia de `cal_days_in_month()`, que pode falhar no VPS se a extensao PHP `calendar` nao estiver habilitada;
   - uso de `GROUP BY l.pk` com agregacao direta de baixa parcial;
   - acesso direto a registros relacionados de cliente/colaborador/fornecedor sem verificar se o relacionamento existe.

### Ajustes aplicados em arquivos

Arquivo:

- `app/app/settings.php`

Ajuste:

- Tornada a URL base sensivel a headers de proxy:
  - `HTTP_X_FORWARDED_PROTO`
  - `HTTP_X_FORWARDED_SSL`
  - `HTTP_X_FORWARDED_HOST`

Arquivo:

- `app/app/dependencies.php`

Ajuste:

- Forcado `base_url()` do Twig para caminho relativo a origem atual:

```php
$twigExtension = new TwigExtension($c->get('router'), $c->get('request')->getUri());
$twigExtension->setBaseUrl('');
$view->addExtension($twigExtension);
```

Com isso, chamadas como `{{ base_url() }}/assets/...` passam a renderizar `/assets/...`, preservando o mesmo protocolo, host e porta da pagina aberta no navegador.

Arquivos:

- `app/app/templates/partials/financeiro_grid_extrato_mes.twig`
- `app/app/templates/ocorrencia/partials/financeiro_grid_extrato_mes.twig`

Ajuste:

- Atualizado o versionamento do asset financeiro:

```html
<script src="/assets/js/local/financeiro_grid_extrato_mes.js?v=15"></script>
```

Motivo:

- Forcar o navegador/VPS a abandonar o cache antigo `v=14`, que ainda executava o JS sem a correcao.

Arquivo:

- `app/public/assets/js/local/financeiro_grid_extrato_mes.js`

Ajuste:

- Adicionada protecao para retorno vazio/erro da API antes de acessar `arrCarregar.data`.
- Quando a API nao retorna `status=true` com `data`, os totais do extrato sao zerados e a funcao encerra sem quebrar a tela.

Arquivo:

- `app/app/src/models/Lancamento.php`

Ajustes:

- Removida dependencia de `cal_days_in_month()` no extrato mensal.
- Substituido por calculo nativo:

```php
$ds_mes = str_pad((int)$ds_mes, 2, "0", STR_PAD_LEFT);
$ultimo_dia_mes = date('t', strtotime($ds_ano."-".$ds_mes."-01"));
```

- Refeito calculo de baixa parcial usando subquery agregada:

```sql
LEFT JOIN (
  SELECT lancamentos_financeiros_pk, SUM(vl_baixa_parcial) vl_baixa_parcial
  FROM lancamentos_financeiros_baixa_parcial
  GROUP BY lancamentos_financeiros_pk
) lfbp ON lfbp.lancamentos_financeiros_pk = l.pk
```

- Removido `GROUP BY l.pk` da query principal do extrato mensal.
- Adicionadas verificacoes antes de acessar dados relacionados de lead, colaborador ou fornecedor, evitando erro quando o registro financeiro aponta para relacionamento ausente.

### Arquivos que precisam subir no VPS

```text
app/app/settings.php
app/app/dependencies.php
app/app/src/models/Lancamento.php
app/public/assets/js/local/financeiro_grid_extrato_mes.js
app/app/templates/partials/financeiro_grid_extrato_mes.twig
app/app/templates/ocorrencia/partials/financeiro_grid_extrato_mes.twig
```

### Validacoes locais executadas

Dentro do container `atc-php`:

```bash
php -l /var/www/html/app/settings.php
php -l /var/www/html/app/dependencies.php
php -l /var/www/html/app/src/models/Lancamento.php
```

Resultados:

- sem erros de sintaxe.

Validacao do Twig/base_url:

```bash
grep -R -n "financeiro_grid_extrato_mes.js?v=" /var/www/html/app/templates/partials /var/www/html/app/templates/ocorrencia/partials
```

Resultado esperado:

```text
financeiro_grid_extrato_mes.js?v=15
```

Validacao do endpoint financeiro:

```bash
curl -s -i -X POST 'http://127.0.0.1:8085/api/lancamento/listarExtratoMes?empresas_pk=1&contas_bancarias_pk=25&ds_ano=2026&ds_mes=5'
```

Resultado:

- `HTTP 200`
- JSON com `status=true`
- retorno com registro financeiro para o Grupo ATC em `05/2026`

Tambem validado:

```bash
curl -s -i -X POST 'http://127.0.0.1:8085/api/lancamento/listarExtratoMes?empresas_pk=4&contas_bancarias_pk=26&ds_ano=2026&ds_mes=5'
```

Resultado:

- `HTTP 200`
- JSON com `status=true`

### Validacoes recomendadas no VPS

Apos subir os arquivos e reiniciar somente os containers ATC:

```bash
curl -s -i -X POST 'http://127.0.0.1:8085/api/lancamento/listarExtratoMes?empresas_pk=1&contas_bancarias_pk=25&ds_ano=2026&ds_mes=5'
```

Deve retornar:

```text
HTTP/1.1 200 OK
```

E JSON:

```json
{"status":true}
```

No navegador, em `Financeiro > Contas a Pagar e Receber > Extrato Mes`, o Network deve mostrar:

```text
/assets/js/local/financeiro_grid_extrato_mes.js?v=15
POST /api/lancamento/listarExtratoMes -> 200
```

Nao deve mais aparecer:

```text
financeiro_grid_extrato_mes.js?v=14
POST /api/lancamento/listarExtratoMes -> 500
ERR_CERT_COMMON_NAME_INVALID
$(...).datepicker is not a function
```

## 2026-05-12

### Solicitacao

Subir novamente o dump do cliente ATC e corrigir os erros que voltaram apos a importacao, especialmente ao acessar o menu RH e a tela de colaboradores.

### Causa raiz

O dump `database/gepros1com_atc.sql.gz`, gerado em `2026-05-12 07:51:21`, restaurou o schema legado do ATC sem algumas colunas que o codigo atual da aplicacao ja utiliza.

Com isso, alguns endpoints passaram a retornar erro apos a importacao:

- `POST /api/lead/listarTodos?&pk=` retornava `500` porque `Lead::listarTodos()` consulta `leads.dia_faturamento`.
- A tela `/colaborador/receptivo?local=1` exibia `DataTables warning: table id=tblFeriado - Invalid JSON response` porque `/api/feriado/listarFeriadoRelogio` quebrava ao consultar `apontamento_folga.feriado_pk`.

### Ajustes aplicados no banco

Banco/container:

- container: `atc-mysql`
- banco: `gepros1com_atc`

Comandos aplicados:

```sql
ALTER TABLE leads
  ADD COLUMN dia_faturamento int(11) DEFAULT NULL AFTER leads_pai_pk,
  ADD COLUMN ic_inss_aplicacao int(11) DEFAULT NULL AFTER dia_faturamento,
  ADD COLUMN ic_iss_retido_tomador int(11) DEFAULT NULL AFTER ic_inss_aplicacao;

ALTER TABLE apontamento_folga
  ADD COLUMN feriado_pk int(11) DEFAULT NULL AFTER apontamento_falta_pk;
```

### Validacoes

- `SHOW COLUMNS FROM leads` confirmou as colunas:
  - `dia_faturamento`
  - `ic_inss_aplicacao`
  - `ic_iss_retido_tomador`
- `SHOW COLUMNS FROM apontamento_folga LIKE 'feriado_pk'` confirmou a coluna `feriado_pk`.
- `/menu/rh` respondeu `HTTP 200`.
- `/api/lead/listarTodos?&pk=` respondeu `HTTP 200` com JSON valido.
- `/api/feriado/listarFeriadoRelogio?...` respondeu `HTTP 200` com JSON valido:

```json
{"status":true,"data":[],"message":"Dados carregados com sucesso","iTotalDisplayRecords":0,"iTotalRecords":0}
```

### Observacoes relevantes

- Estes ajustes sao de compatibilidade de schema entre o dump legado restaurado e o codigo atual do ATC.
- Se o dump for reimportado novamente, estas colunas precisarao ser reaplicadas ou incorporadas ao processo de importacao/migracao.
- Nenhum arquivo PHP/JS/Twig foi alterado nesta correcao; a alteracao foi apenas estrutural no banco e foi registrada aqui para nao se perder apos novo restore.

## 2026-05-13

### Solicitacao

Corrigir erro ao clicar na aba `Receita(s)` em `Financeiro > Contas a Pagar e Receber`, apos atualizacao/importacao do banco.

### Causa raiz

A requisicao da aba `Receita(s)`:

- `POST /api/lancamento/listarReceita`

retornava `HTTP 500`.

As permissoes das abas financeiras ja estavam presentes no banco atual, conforme correcao anterior:

- `financeiro_contas_menu_extrato`
- `financeiro_contas_menu_receita`
- `financeiro_contas_menu_despesa`
- `financeiro_contas_menu_lancamentos`
- `status_finaceiro`

O erro real estava mascarado pelo retorno generico do `catch`. Ao reproduzir a chamada autenticada, a causa identificada foi schema incompleto no dump atual:

```text
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'l.nfse_pk' in 'field list'
```

O codigo atual de `Lancamento::listarReceita` seleciona `l.nfse_pk`, mas a tabela `lancamentos_financeiros` importada pelo dump nao possuia essa coluna.

### Ajustes aplicados no banco

Banco/container:

- container: `atc-mysql`
- banco: `gepros1com_atc`

Coluna adicionada:

```sql
ALTER TABLE lancamentos_financeiros
ADD COLUMN nfse_pk int(11) NULL DEFAULT NULL;
```

### Ajustes para nao voltar apos novo import

Foi atualizado o script de importacao:

- `infra/scripts/import_dump.sh`

Adicionada rotina `post_import_fixes`, executada logo apos o `SOURCE` do dump, para reaplicar automaticamente:

- coluna `lancamentos_financeiros.nfse_pk`, quando ausente
- modulos das abas financeiras, quando ausentes
- permissoes das abas financeiras para os grupos `1`, `8`, `9` e `10`
- permissao de `status_finaceiro` para o grupo `1`

### Validacoes

- `bash -n infra/scripts/import_dump.sh` sem erros.
- `php -l /var/www/html/app/src/controllers/LancamentoController.php` sem erros dentro do container `atc-php`.
- `POST /api/lancamento/listarReceita?...dt_vencimento=01/05/2026 - 31/05/2026...` respondeu `HTTP 200`.
- A resposta da API retornou:

```json
{"status":true,"message":"Dados carregados com sucesso","data":[]}
```

## 2026-05-12

### Solicitacao

Verificar a tela financeira `/lancamento/contasPagarReceberReceptivo?rh=1`, que carregava apenas o botao `Novo Lancamento` e nao exibia as abas internas ja corrigidas anteriormente.

### Causa raiz

Era permissao.

O dump restaurado nao possuia os modulos usados pelo template atual para exibir as abas internas da tela financeira:

- `financeiro_contas_menu_extrato`
- `financeiro_contas_menu_receita`
- `financeiro_contas_menu_despesa`
- `financeiro_contas_menu_lancamentos`

Tambem faltava permissao do grupo `1` para o dominio legado com typo:

- `status_finaceiro`

Como o template `lancamento/financeiro_contas_pagar_receber_res_form.twig` chama `permissao(...)` para esses dominios e oculta as classes quando `status != true`, as abas ficavam escondidas mesmo com a pagina respondendo `HTTP 200`.

### Ajustes aplicados no banco

Banco/container:

- container: `atc-mysql`
- banco: `gepros1com_atc`

Modulos criados:

```sql
INSERT INTO modulos (..., pk, ds_modulo, ds_dominio)
VALUES
  (141, 'Financeiro -> Contas Menu Extrato', 'financeiro_contas_menu_extrato'),
  (142, 'Financeiro -> Contas Menu Receita', 'financeiro_contas_menu_receita'),
  (143, 'Financeiro -> Contas Menu Despesa', 'financeiro_contas_menu_despesa'),
  (144, 'Financeiro -> Contas Menu Lancamentos', 'financeiro_contas_menu_lancamentos');
```

Permissoes liberadas para os mesmos grupos que ja tinham acesso ao modulo financeiro:

- grupo `1` - Administracao do Sistema
- grupo `8` - Contabil
- grupo `9` - Controller
- grupo `10` - Financeiro

Para os quatro modulos novos:

```sql
ic_ins=2, ic_upd=2, ic_del=2, ic_cons=1
```

Tambem foi adicionada permissao para o grupo `1` em `status_finaceiro`:

```sql
ic_ins=1, ic_upd=1, ic_del=2, ic_cons=1
```

### Validacoes

As chamadas abaixo passaram a retornar `{"status":true,"message":"Voce tem permissao","data":[]}`:

- `/api/usuario/verificarPermissao?ds_dominio_modulo=financeiro_contas_menu_extrato&ic_acao=cons`
- `/api/usuario/verificarPermissao?ds_dominio_modulo=financeiro_contas_menu_receita&ic_acao=cons`
- `/api/usuario/verificarPermissao?ds_dominio_modulo=financeiro_contas_menu_despesa&ic_acao=cons`
- `/api/usuario/verificarPermissao?ds_dominio_modulo=financeiro_contas_menu_lancamentos&ic_acao=cons`
- `/api/usuario/verificarPermissao?ds_dominio_modulo=status_finaceiro&ic_acao=cons`

Tambem foram validados:

- `/lancamento/contasPagarReceberReceptivo?rh=1` respondeu `HTTP 200`.
- `/api/lancamento/listarExtratoMes?...` respondeu `HTTP 200` com `status=true`.

### Observacoes relevantes

- O nome `status_finaceiro` esta com typo no codigo e no banco legado; foi mantido assim por compatibilidade.
- Se o dump for reimportado novamente, estes modulos/permissoes precisarao ser reaplicados ou entrar em uma migracao pos-importacao.

## 2026-05-05

### Solicitacao

Dockerizar o cliente `atc` usando a fonte legado `source/tar/atcNew/` e o banco legado disponivel, seguindo o processo ja definido e sem modificacoes funcionais.

### Acao realizada

- Criada a estrutura padrao do cliente com `app/`, `infra/`, `database/`, `docs/` e `logs/`.
- Copiada a fonte oficial `source/tar/atcNew/` para `app/`.
- Copiado o dump `gepros1com_atc.sql.gz` para `database/dump.sql.gz`.
- Criada stack Docker com PHP 7.3 FPM, nginx 1.24-alpine e MySQL 5.7.
- Ajustado apenas `db.host` em `app/app/settings.php` de `localhost` para `atc-mysql`.
- Criados scripts locais de subida, parada, logs, verificacao e importacao do dump.
- Subidos os containers `atc-php`, `atc-nginx` e `atc-mysql`.
- Importado o dump no banco `gepros1com_atc`.

### Arquivos criados

- `infra/docker-compose.yml`
- `infra/docker/php/Dockerfile`
- `infra/docker/nginx/default.conf`
- `infra/scripts/up.sh`
- `infra/scripts/down.sh`
- `infra/scripts/logs.sh`
- `infra/scripts/verificar_dump.sh`
- `infra/scripts/import_dump.sh`
- `docs/estrutura_padrao_cliente.md`
- `docs/dockerizacao_legado.md`

### Arquivos alterados

- `app/app/settings.php`
- `infra/scripts/import_dump.sh`
- `infra/scripts/verificar_dump.sh`

### Validacoes

- `docker compose config` valido.
- Containers ativos:
  - `atc-php`
  - `atc-nginx`
  - `atc-mysql`
- MySQL `healthy`.
- Dump validado com `CREATE TABLE usuarios`, `INSERT INTO usuarios` e finalizacao normal.
- Pos-validacao da importacao:
  - tabela `usuarios` encontrada
  - schema com 163 tabelas
  - `usuarios` com 16 registros
- `php -l` em `app/settings.php` sem erros.
- `/login` respondeu `HTTP 200`.
- Login via `/api/auth/login` com usuario `admin` retornou `status=true`.

### Observacoes relevantes

- Nenhuma alteracao funcional foi feita em controller, model, template, rota ou JavaScript.
- `source/tar/atc/` foi preservado, mas nao usado nesta rodada porque a fonte indicada para a dockerizacao foi `atcNew`.
- O dump original na raiz do cliente foi preservado; a copia padrao usada pelos scripts ficou em `database/dump.sql.gz`.

## 2026-05-05

### Solicitacao

Investigar a tela `Financeiro > contas a pagar/receber`, que abria em `/lancamento/contasPagarReceberReceptivo?rh=1` mas permanecia no loading.

### Acao realizada

Identificado que a tela carregava o HTML, mas o AJAX:

- `POST /api/lancamento/listarExtratoMes`

retornava `500`.

A causa era ambiental: o codigo legado usa `cal_days_in_month()` em `Lancamento::listarExtratoMes`, mas a imagem PHP inicial nao tinha a extensao `calendar` habilitada.

Foi ajustada a imagem PHP do cliente para instalar tambem a extensao `calendar`.

### Arquivos alterados

- `infra/docker/php/Dockerfile`

### Validacoes

- `function_exists("cal_days_in_month")` retornou `true` no container `atc-php`.
- Endpoint `POST /api/lancamento/listarExtratoMes` passou a responder `HTTP 200`.
- Resposta retornou JSON com `status=true` e `message="Dados carregados com sucesso"`.

### Observacoes relevantes

- Nenhuma regra funcional da aplicacao foi alterada.
- O ajuste ficou restrito ao ambiente Docker PHP.

## 2026-05-05

### Solicitacao

Fazer um de/para com a Brasil Servis e atualizar o ATC com os ajustes ja estabilizados, mantendo o processo definido e sem sobrescrever o sistema inteiro.

### Acao realizada

Foi feita sincronizacao controlada dos arquivos que compoem o pacote de ajustes replicaveis ja documentado na Brasil Servis:

- `public/assets/js/local/colaborador_cad_form.js`
- `app/src/controllers/SolicitacaoAcessoAppController.php`
- `app/src/models/SolicitacaoAcessoApp.php`
- `app/src/models/Colaborador.php`
- `app/src/controllers/WebPontoApiController.php`
- `app/src/models/Ponto.php`
- `app/src/models/PontoFolha.php`
- `app/src/models/AgendaColaboradorPadrao.php`
- `public/assets/js/local/agenda_escala_cad_form.js`
- `app/templates/escala/agenda_escala_cad_form.twig`

Antes da substituicao, os arquivos originais do ATC foram preservados em:

- `source/referencias/pre-brasil-sync-2026-05-05/app/`

### Adaptacao especifica do ATC

Durante a validacao do de/para foi identificada diferenca de schema: o codigo da Brasil Servis pode gravar `ponto.ic_ponto_fora_turno`, mas o dump restaurado do ATC nao possui essa coluna.

Para manter compatibilidade com o banco ATC sem perder a melhoria importada, `Ponto.php` recebeu guarda por existencia de coluna antes de incluir `ic_ponto_fora_turno` nos inserts.

### Validacoes

- `php -l` sem erros nos PHP sincronizados.
- `node --check` sem erros nos JS sincronizados.
- Containers ativos:
  - `atc-php`
  - `atc-nginx`
  - `atc-mysql`
- MySQL `healthy`.
- Login via `/api/auth/login` com usuario `admin` retornou `status=true`.
- `/menu/principal` respondeu `HTTP 200`.
- `/colaborador/receptivo?local=1` respondeu `HTTP 200`.
- `/api/colaborador/listarGrid` respondeu `HTTP 200` com `status=true`.
- `/api/conta/carregarLogo` respondeu `HTTP 200` com `status=true`.
- `/api/lancamento/listarExtratoMes` respondeu `HTTP 200` com `status=true` usando os parametros reais da tela financeira.

### Observacoes relevantes

- Nao foi feita copia integral do sistema Brasil Servis sobre o ATC.
- A atualizacao ficou restrita aos arquivos com correcoes replicaveis e ja mapeadas.
- O CSS `assets/css/pages/settings-selectables.css` segue retornando `404`, mas nao bloqueou as validacoes funcionais realizadas.

## 2026-05-05

### Solicitacao

Substituir o codigo do ATC pela base completa da Brasil Servis, considerando a Brasil Servis como codigo correto.

### Acao realizada

Foi feito backup completo do estado anterior do ATC em:

- `source/referencias/full-pre-brasil-base-2026-05-05/app/`

Em seguida, foi aplicada a base completa de:

- `clients/brasil-servis/app/`

para:

- `clients/atc/app/`

usando sincronizacao com remocao de diferencas, para deixar a estrutura do ATC igual a Brasil Servis.

### Excecoes preservadas

Foram mantidas apenas as diferencas necessarias para o ATC executar no ambiente e banco corretos:

- `app/settings.php`: preservado com `host=atc-mysql`, `user=gepros1com_atc` e `dbname=gepros1com_atc`.
- `app/src/models/Ponto.php`: base Brasil Servis mantida, com guarda de compatibilidade para nao gravar `ponto.ic_ponto_fora_turno` quando a coluna nao existir no banco ATC restaurado.

### Validacoes

- Comparacao seca com Brasil Servis nao apontou diferencas restantes, exceto `settings.php` e `Ponto.php`.
- `php -l` sem erros em `app/settings.php`.
- `php -l` sem erros em `app/src/models/Ponto.php`.
- Containers ativos:
  - `atc-php`
  - `atc-nginx`
  - `atc-mysql`
- MySQL `healthy`.
- Login via `/api/auth/login` com usuario `admin` retornou `status=true`.
- `/menu/principal` respondeu `HTTP 200`.
- `/colaborador/receptivo?local=1` respondeu `HTTP 200`.
- `/lancamento/contasPagarReceberReceptivo?rh=1` respondeu `HTTP 200`.
- `/api/colaborador/listarGrid` respondeu `HTTP 200` com `status=true`.
- `/api/lancamento/listarExtratoMes` respondeu `HTTP 200` com `status=true`.
- `/api/conta/carregarLogo` respondeu `HTTP 200`.

## 2026-05-05

### Solicitacao

Corrigir a tela de login apos a aplicacao da base completa Brasil Servis, pois o layout ficou fora do padrao visual do ATC.

### Acao realizada

O `base.login.twig` da Brasil Servis usava um logo GPROS fixo no painel lateral. No ATC, esse painel passou a usar o mesmo logo do cliente carregado por `/api/conta/carregarLogo`.

Tambem foram travados os tamanhos dos logos do login para evitar estouro visual:

- logo lateral: classe `login-side-logo`
- logo superior do formulario: classe `login-client-logo`

### Arquivos alterados

- `app/templates/theme/base.login.twig`
- `app/templates/login/login.twig`
- `public/assets/js/global/oauth.js`
- `public/assets/css/local/authentication.css`

### Validacoes

- `/login` respondeu `HTTP 200`.
- CSS atualizado esta sendo servido pelo container.
- JS atualizado esta sendo servido pelo container.
- `node --check` em `oauth.js` sem erros.

### Revisao posterior

O painel lateral do login deve permanecer institucional GPROS, com fundo azul. Foi restaurado o logo GPROS fixo no lado esquerdo e mantido o logo do cliente ATC apenas no formulario.

Validado:
- `/login` respondeu `HTTP 200`.
- HTML servido contem `logo_base.png` no painel lateral.
- CSS servido contem fundo azul `#0d3f77` para `.img-holder`.

### Reforco de compatibilidade visual

Como o navegador ainda podia manter CSS antigo em cache, o fundo azul do painel lateral foi aplicado tambem inline em `base.login.twig`.

Validado:
- `/login` respondeu `HTTP 200`.
- HTML servido contem `background-color: #0d3f77`, `linear-gradient` e `logo_base.png` no painel lateral.

## 2026-05-05

### Solicitacao

Ao clicar no menu RH, o sistema exibia a mensagem `Falhou a requisição: error`.

### Diagnostico

A tela `/menu/rh` carregava com `HTTP 200`, mas um AJAX disparado pelo menu falhava:

- `POST /api/lead/listarTodos?&pk=` retornava `HTTP 500`.

O codigo da Brasil Servis consulta a coluna `leads.dia_faturamento`. O dump restaurado do ATC estava desatualizado e nao possuia essa coluna.

### Acao realizada

Como a Brasil Servis e a base correta solicitada para o ATC, o schema ATC foi alinhado com a coluna esperada:

- `leads.dia_faturamento int(11) NULL DEFAULT NULL`

### Validacoes

- `/menu/rh` respondeu `HTTP 200`.
- `POST /api/lead/listarTodos?&pk=` passou a responder `HTTP 200`.
- Resposta do endpoint retornou `status=true`.
- `POST /api/agenda_colaborador_apontamento/listarDisciplina?&pk=` continuou respondendo `HTTP 200`.
- Comparacao seca contra Brasil Servis nao apontou diferencas de codigo alem das adaptacoes locais ja conhecidas: `settings.php`, `Ponto.php` e ajustes visuais do login ATC.

## 2026-05-05

### Solicitacao

Na tela `/colaborador/receptivo?local=1`, o navegador exibia:

- `DataTables warning: table id=tblFeriado - Invalid JSON response`

### Diagnostico

O DataTables `tblFeriado` chama:

- `GET /api/feriado/listarFeriadoRelogio`

O endpoint respondia `HTTP 200`, mas o corpo nao era JSON. O retorno continha erros SQL:

- coluna ausente `apontamento_folga.feriado_pk`
- tabela ausente `feriados`

Esses objetos existem na base Brasil Servis e sao esperados pelo codigo que agora e a base correta do ATC.

### Acao realizada

Schema ATC alinhado com a Brasil Servis:

- adicionada coluna `apontamento_folga.feriado_pk int(11) NULL DEFAULT NULL`
- criada tabela `feriados` com a mesma estrutura da Brasil Servis

### Validacoes

- `/colaborador/receptivo?local=1` respondeu `HTTP 200`.
- `/api/feriado/listarFeriadoRelogio` respondeu `HTTP 200` com JSON valido:
  - `status=true`
  - `data=[]`
  - `iTotalDisplayRecords=0`
  - `iTotalRecords=0`
- `/api/colaborador/listarGrid` respondeu `HTTP 200`.

## 2026-05-05

### Solicitacao

No modal `Acompanhamento de Ponto`, o botao `Pesquisar Ponto` nao carregava a grade.

### Diagnostico

O clique dependia dos campos ocultos `agenda_consulta_folha_colaborador_pk` e `leads_consulta_folha_pk`. Quando a tela era aberta sem esses campos preenchidos, o fluxo parava antes de chamar a API.

Tambem havia divergencias entre o schema ATC restaurado e o schema esperado pelo codigo Brasil Servis:

- `agenda_colaborador_padrao.hr_total_expediente`
- `agenda_colaborador_padrao.hr_jornada_trabalho_intervalo`
- `agenda_colaborador_apontamento.ic_status`
- `apontamento_ponto.hr_faltantes`
- `apontamento_ponto.hr_excedentes`
- `apontamento_ponto.hr_trabalhadas`
- tabela `validar_reloginho`
- `ponto.ic_validacao_facial`
- `ponto.dt_validacao_facial`
- `ponto.usuario_validacao_facial`

### Acao realizada

Foi ajustada a busca de escala para considerar agendas ativas que comecaram antes do periodo pesquisado e continuam vigentes no periodo.

No frontend, o botao `Pesquisar Ponto` passou a tentar preencher automaticamente a escala/posto pelo colaborador e periodo antes de exibir a mensagem de falta de escala.

O schema ATC foi alinhado com os objetos acima, conforme a estrutura usada pela Brasil Servis.

### Validacoes

- `/api/agenda_colaborador_padrao/pegarPostoByColaboradorPorMesAno?dt_inicio=01/05/2026&dt_fim=31/05/2026&colaborador_pk=790` respondeu `HTTP 200` com agenda `pk=93`.
- `/api/ponto_folha/listarConsultaPontoColaborador?leads_pk=34&colaborador_pk=790&agenda_colaborador_pk=93&dt_inicio=01/05/2026&dt_fim=31/05/2026` respondeu `HTTP 200` com `status=true` e dados da grade de ponto.
- Para a colaboradora `pk=917` da tela informada, a busca de escala retorna `data=[]`; nesse caso o sistema deve avisar `Esse colaborador não tem escala!`.
- Lint PHP sem erros em `AgendaColaboradorPadrao.php` e `PontoFolhaController.php`.

### Reforco posterior

Como o navegador podia manter o JS anterior em cache, o include de `colaborador_res_form.js` foi atualizado de `v=15` para `v=16` nos templates de colaborador. Tambem foi adicionada uma mensagem visivel dentro do modal quando nao existir escala para o colaborador/periodo.

## 2026-05-05

### Solicitacao

Integrar no ATC dockerizado a ferramenta separada de Ronda existente em `/source/atc`, sem manter a dependencia da aplicacao externa `gtronda`.

### Diagnostico

O ATC dockerizado ja possuia:

- cadastro/impressao de QR Code em `/lead/qrCode`
- relatorio de rondas em `/relatorio/pesqRondas`
- API de relatorio em `/api/ronda/relRondas`

O ponto ainda fora do fluxo era o QR Code gerado pelo sistema, que apontava para:

- `https://gepros1.com.br/crm/facilities/gtronda/view/ronda_cad_form.php`

No legado antigo, essa tela recebia `posto` e `local` pela URL e gravava diretamente na tabela `ronda`.

### Acao realizada

Foi criada uma integracao nativa no ATC:

- rota publica `/ronda/registrar?qr=<pk>`
- API `POST /api/ronda/registrar`
- template `ronda/registrar.twig`
- JS `ronda_registro.js`
- metodo no model `Ronda` para buscar o ponto pelo `lead_ronda_qrcode.pk`
- metodo no model `Ronda` para gravar na tabela `ronda`

O QR Code passou a apontar para a rota interna do proprio ATC, usando `window.location.origin`, sem URL fixa de producao.

A gravacao continua preenchendo os campos legados esperados pelo relatorio atual:

- `ronda.leads_pk` com o nome do posto de trabalho
- `ronda.local_ronda_pk` com o local/ponto da ronda
- `ronda.ds_ronda` com a observacao opcional

### Observacao de schema

A tabela `ronda` possui todos os registros com `pk=0` e nao tem chave primaria/auto incremento. Para nao alterar o historico legado nem exigir saneamento dos 109.673 registros existentes, a integracao manteve a compatibilidade com esse schema.

### Validacoes

- Lint PHP sem erros em `Ronda.php`.
- Lint PHP sem erros em `RondaController.php`.
- `/ronda/registrar?qr=1` respondeu `HTTP 200` dentro do container.
- `POST /api/ronda/registrar` respondeu `HTTP 200` com `status=true`.
- `/api/ronda/relRondas` retornou o registro criado no teste.
- Os registros temporarios de teste foram removidos do banco.

### Compatibilidade com QR Code antigo

Para os QR Codes ja impressos, foi mantido o caminho antigo:

- `/crm/facilities/gtronda/view/ronda_cad_form.php?posto=<posto>&local=<local>`

Esse arquivo agora redireciona para `/ronda/legado`, que resolve `posto` e `local` na tabela `lead_ronda_qrcode` e encaminha para a tela nova `/ronda/registrar?qr=<pk>`.

Validado com URL no formato legado:

- caminho antigo respondeu `302`
- `/ronda/legado` respondeu `302`
- `/ronda/registrar?qr=<pk>` respondeu `HTTP 200`
- dado temporario de teste removido do banco
