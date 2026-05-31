# Historico Consolidado

Data de consolidacao: 2026-04-25

Objetivo deste arquivo:
- consolidar em um unico ponto o historico recente registrado nos clientes
- servir de base operacional para replicacao nos proximos clientes
- evitar retrabalho e perda de contexto entre atendimentos

Escopo desta consolidacao:
- ultimos 3 dias com historico documentado nos MDs dos clientes
- fontes usadas:
  - `clients/brasil-servis/docs/historico_ajustes_integracao_api.md`
  - `clients/america-servis/docs/HISTORICO.md`

---

## 2026-04-23

### Cliente: `brasil-servis`

#### Integracao com API externa do app ponto

Problemas identificados:
- botao `Liberar Acesso` retornava sucesso local sem refletir no status real
- leitura do status acontecia na API externa e a escrita ficava apenas na base local
- sincronizacao de colaborador usava dados crus do formulario em vez do estado final salvo
- exclusao logica local apagava indevidamente o colaborador no servidor externo
- `empresas_pk` podia ser contaminado com `ds_conta`

Correcoes aplicadas:
- fluxo de liberacao passou a enviar `api_pk` e `colaborador_pk`
- backend passou a chamar a API externa `action=liberarAcesso`
- sincronizacao de colaborador passou a usar o estado persistido no banco
- exclusao local deixou de chamar remocao fisica do colaborador no servidor externo
- retorno de `empresas_pk` foi corrigido para PK real

Arquivos-base da replicacao:
- `clients/brasil-servis/app/public/assets/js/local/colaborador_cad_form.js`
- `clients/brasil-servis/app/app/src/controllers/SolicitacaoAcessoAppController.php`
- `clients/brasil-servis/app/app/src/models/SolicitacaoAcessoApp.php`
- `clients/brasil-servis/app/app/src/models/Colaborador.php`

#### Registro de ponto vindo do servidor externo

Problemas identificados:
- `getParsedBody()` isolado podia falhar com JSON bruto
- latitude/longitude eram obrigatorias
- `ic_ponto_fora_turno` tinha nomes inconsistentes
- falha no tratamento de imagem podia impedir o `INSERT`

Correcoes aplicadas:
- parser com fallback para JSON bruto
- latitude/longitude passaram a ser opcionais
- leitura de `ic_ponto_fora_turno` em `snake_case` e `camelCase`
- imagem invalida deixou de bloquear o registro

Arquivos-base da replicacao:
- `clients/brasil-servis/app/app/src/controllers/WebPontoApiController.php`
- `clients/brasil-servis/app/app/src/models/Ponto.php`

#### Reducao de imagem do ponto

Problema identificado:
- o sistema apenas recomprimia a imagem e mantinha a resolucao original

Correcao aplicada:
- helper central para redimensionar largura maxima para `1280px`
- conversao para JPEG com qualidade `75`

Arquivo-base da replicacao:
- `clients/brasil-servis/app/app/src/models/Ponto.php`

#### Pendencia relevante

- confirmar se a API externa aceita `CPF + CNPJ` nas consultas:
  - `action=getImagemLiberacaoApp`
  - `action=consultaAcessoApp`

---

## 2026-04-24

### Cliente: `brasil-servis`

#### Reloginho com diferenca entre local e producao

Problema identificado:
- local preenchia `Data Inicio` e `Data Fim`
- producao abria o reloginho com os campos vazios

Causa identificada:
- preenchimento automatico acontece no JS
- ambiente de producao indicava asset antigo ou cache antigo

Correcao aplicada:
- `cache bust` do JS alterado de `?v=14` para `?v=15`

Arquivos-base da replicacao:
- `clients/brasil-servis/app/app/templates/colaborador/colaborador_res_form.twig`
- `clients/brasil-servis/app/app/templates/conta/colaborador/colaborador_res_form.twig`

#### Prova de erro de producao no registro de ponto

Validacao executada:
- teste real via Postman em `registrarPontoApp`

Resultado confirmado:
- erro: `Call to undefined function App\\Model\\imagecreatefromstring()`

Conclusao:
- requisicao chegava corretamente
- falha ocorria no processamento da imagem
- ambiente sem suporte funcional a GD

#### Fallback sem GD

Correcao aplicada:
- `normalizePointImage()` passou a validar existencia das funcoes GD
- na ausencia delas, mantem a imagem original e segue com o `INSERT`

Arquivo-base da replicacao:
- `clients/brasil-servis/app/app/src/models/Ponto.php`

### Cliente: `america-servis`

#### Replicacao das correcoes do `brasil-servis`

Correcoes replicadas:
- liberacao de acesso do app ponto
- sincronizacao de colaborador com estado final persistido
- remocao da exclusao indevida no servidor externo
- correcao de `empresas_pk`
- robustez do endpoint de ponto
- fallback de imagem e reducao de tamanho
- correcao do reloginho para considerar intervalos como ponto valido

Arquivos-base aplicados:
- `clients/america-servis/app/public/assets/js/local/colaborador_cad_form.js`
- `clients/america-servis/app/app/src/controllers/SolicitacaoAcessoAppController.php`
- `clients/america-servis/app/app/src/models/SolicitacaoAcessoApp.php`
- `clients/america-servis/app/app/src/models/Colaborador.php`
- `clients/america-servis/app/app/src/controllers/WebPontoApiController.php`
- `clients/america-servis/app/app/src/models/Ponto.php`
- `clients/america-servis/app/app/src/models/PontoFolha.php`

#### Compatibilizacao adicional do legado

Problema identificado:
- coluna `leads.dia_faturamento` inexistente no banco legado restaurado

Correcao aplicada:
- `Lead.php` passou a consultar/gravar `dia_faturamento` apenas quando a coluna existir

Observacao:
- esse tipo de compatibilizacao precisa ser verificado cliente a cliente conforme o dump legado

---

## 2026-04-25

### Consolidacao de historico

Acao realizada:
- criado este `historico.md` na raiz para centralizar o aprendizado recente
- consolidacao focada em acoes repetiveis para os proximos clientes

---

## 2026-05-05

### Cliente: `atc`

#### Dockerizacao inicial do legado

Acao realizada:
- estrutura padrao criada com `app/`, `infra/`, `database/`, `docs/` e `logs/`
- fonte oficial `clients/atc/source/tar/atcNew/` copiada para `clients/atc/app/`
- dump `gepros1com_atc.sql.gz` copiado para `clients/atc/database/dump.sql.gz`
- stack Docker criada com PHP 7.3 FPM, nginx 1.24-alpine e MySQL 5.7
- ajuste minimo aplicado em `app/app/settings.php`: `db.host` de `localhost` para `atc-mysql`
- dump importado no banco `gepros1com_atc`

Validacoes:
- `docker compose config` valido
- containers `atc-php`, `atc-nginx` e `atc-mysql` ativos
- MySQL `healthy`
- dump validado com `CREATE TABLE usuarios`, `INSERT INTO usuarios` e finalizacao normal
- schema importado com 163 tabelas
- tabela `usuarios` com 16 registros
- `/login` respondeu `HTTP 200` em `http://127.0.0.1:8085/login`
- `/api/auth/login` com usuario `admin` retornou `status=true`

Observacoes:
- nenhuma alteracao funcional foi feita em controller, model, template, rota ou JavaScript
- o script de importacao recebeu o ajuste ja aprendido em clientes anteriores: logs de descompactacao de `.sql.gz` enviados para `stderr`
- o script de verificacao do dump foi corrigido no cliente para evitar falso negativo com `grep -q` sob `pipefail`

#### Ajuste ambiental do financeiro

Problema identificado:
- tela `/lancamento/contasPagarReceberReceptivo?rh=1` ficava presa no loading
- o AJAX `POST /api/lancamento/listarExtratoMes` retornava `500`
- o codigo legado usa `cal_days_in_month()`, mas a imagem PHP inicial nao tinha a extensao `calendar`

Correcao aplicada:
- `clients/atc/infra/docker/php/Dockerfile` passou a instalar `calendar` junto com `pdo_mysql`
- imagem `atc-php` foi reconstruida

Validacao:
- `function_exists("cal_days_in_month")` retornou `true`
- `POST /api/lancamento/listarExtratoMes` passou a responder `HTTP 200` com `status=true`

---

## 2026-05-07

### Cliente: `atc`

#### Contexto geral dos problemas informados no VPS

Telas/problemas informados pelo cliente:
- formulario de colaborador para editar ficava carregando
- reloginho / acompanhamento de ponto nao preenchia automaticamente `Data Inicio` e `Data Fim`
- RH Escalas nao carregava corretamente
- Financeiro nao carregava completo
- `Contas a Pagar e Receber` nao listava dados
- em Financeiro, o campo `Empresa(s)` carregava conta bancaria no lugar de empresa
- em Financeiro, o campo `Conta(s)` ficava vazio
- abas `Receita(s)` e `Despesa(s)` carregavam, mas o botao `Buscar` parecia sem acao

Observacao importante:
- a primeira lista de subida gerada durante o atendimento ficou focada no Financeiro
- posteriormente foi corrigido o entendimento: o pacote de subida da ATC precisa incluir tambem RH/Ponto/Reloginho/Colaborador/Escalas, pois esses problemas tambem foram informados no mesmo escopo

#### Pasta correta local da ATC

Base local:
- `clients/atc` dentro de `infra-legado-docker`

No workspace atual:
- `/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/atc`

Raiz real da aplicacao:
- `infra-legado-docker/clients/atc/app`

Estrutura esperada no VPS:
- `app/app`
- `app/public`
- `app/vendor`

Comandos recomendados para descobrir/validar a pasta real no VPS:
- `find /home -path '*financeiro_contas_pagar_receber_res_form.twig' 2>/dev/null`
- `find /var/www -path '*financeiro_contas_pagar_receber_res_form.twig' 2>/dev/null`
- `find /home -path '*colaborador_res_form.js' 2>/dev/null`
- `find /var/www -path '*colaborador_res_form.js' 2>/dev/null`

Arquivos sentinela para confirmar a pasta correta:
- `app/app/templates/lancamento/financeiro_contas_pagar_receber_res_form.twig`
- `app/public/assets/js/local/financeiro_grid_receita.js`
- `app/public/assets/js/local/colaborador_res_form.js`
- `app/app/src/models/Ponto.php`

#### Ajuste do ambiente local ATC

Acao realizada:
- containers Docker da ATC validados e mantidos ativos
- ambiente local acessivel em `http://127.0.0.1:8085`

Containers:
- `atc-nginx`
- `atc-php`
- `atc-mysql`

Validacoes:
- `/login` respondeu `HTTP 200`
- `/menu/financeiro` carregou
- `/lancamento/contasPagarReceberReceptivo?rh=1` carregou

#### Financeiro - menu e permissoes

Problema identificado:
- menu Financeiro vinha de base/copia em que a empresa de origem nao usava o Financeiro
- blocos do Financeiro da ATC nao apareciam ou ficavam incompletos por permissoes/dominos incorretos

Arquivo alterado:
- `clients/atc/app/app/templates/menu/financeiro.twig`

Correcoes aplicadas:
- permissoes do menu financeiro ajustadas para dominios existentes/liberaveis
- links de Faturas/Boletos corrigidos para `/faturamento/receptivo`
- blocos do Financeiro passaram a depender dos dominios corretos

Dominios financeiros tratados/liberados localmente:
- `menu_financeiro`
- `faturamento_modulo`
- `financeiro_controle_moodulo`
- `financeiro_lancamentos_usuarios_modulo`
- `financeiro_nfse`
- `financeiro_contas_menu_extrato`
- `financeiro_contas_menu_receita`
- `financeiro_contas_menu_despesa`
- `financeiro_contas_menu_lancamentos`
- `contas_bancarias`
- `plano_contas`
- `fornecedor`
- `lancamento_empresa`
- `lancamento_contabancaria`
- `lancar_dt_atual_retroativa`
- `status_finaceiro`
- `excluir_lancamentos`
- `analise_financeira_modulo`
- `atualizar_itens_pagos`
- `documento`

Observacao:
- manter exatamente `status_finaceiro`, com esse erro de grafia, pois e assim que o legado consulta o dominio

#### Financeiro - `Empresa(s)` e `Conta(s)`

Problema identificado:
- em `Contas a Pagar e Receber`, o combo `Empresa(s)` carregava contas bancarias
- como resultado, o combo `Conta(s)` recebia um `empresas_pk` invalido e ficava vazio

Arquivo alterado:
- `clients/atc/app/app/src/models/ContaBancaria.php`

Funcao alterada:
- `listarEmpresaContasAtivas()`

Correcoes aplicadas:
- a funcao voltou a retornar empresas que possuem contas bancarias ativas
- comportamento alinhado com referencia anterior do projeto

Consulta esperada:
- retorna `c.pk` e `c.ds_conta` a partir de `contas`
- filtra empresas por contas bancarias ativas em `contas_bancarias`

Validacoes locais:
- `Empresa(s)` passou a retornar empresas, incluindo `Grupo ATC`
- `Conta(s)` passou a retornar contas bancarias da empresa selecionada
- para `Grupo ATC`, retornou contas como Bradesco, SICOOB, Itau e Caixa

#### Financeiro - erro 500 em `Receita(s)`

Problema identificado:
- ao abrir/clicar `Receita(s)`, a API `/api/lancamento/listarReceita` retornava `HTTP 500`
- o erro ficava mascarado por warning no `withJson`, mas a causa real era schema faltante

Causa:
- a tabela `lancamentos_financeiros` nao tinha a coluna `nfse_pk`
- o codigo financeiro/NFSE da ATC usa `lancamentos_financeiros.nfse_pk`

Banco ajustado localmente:
- criada coluna `lancamentos_financeiros.nfse_pk`
- preenchido `nfse_pk = numero_nfse` quando possivel

Arquivo de script alterado:
- `clients/atc/database/aplicar_ajustes_atc_schema.sh`

Trecho essencial adicionado:
- `CALL add_column_if_missing('lancamentos_financeiros', 'nfse_pk', 'int(11) DEFAULT NULL');`
- `UPDATE lancamentos_financeiros SET nfse_pk = numero_nfse WHERE nfse_pk IS NULL AND numero_nfse IS NOT NULL;`

Validacoes:
- `/api/lancamento/listarReceita` passou a responder `HTTP 200`
- `/api/lancamento/listarDespesa` respondeu `HTTP 200`
- `/api/lancamento/listarLancamento` respondeu `HTTP 200`

#### Financeiro - filtros e botao `Buscar` em Receita/Despesa

Problemas identificados:
- Receita/Despesa iniciavam `Periodo Vencimento` como hoje + amanha
- `Todos Lancamentos` usava mes completo, mas Receita/Despesa nao
- o backend prioriza filtros por ordem; se `Periodo Vencimento` fica preenchido, o filtro de `Periodo Faturamento` pode ser ignorado
- o usuario tinha receitas no dia 15 de maio por `dt_faturamento`, mas o filtro ativo era por `dt_vencimento`
- o botao `Buscar` da Receita parecia sem acao quando a API retornava vazio
- a tela podia mostrar um periodo visivel enquanto o JS usava outro valor salvo no `localStorage`

Arquivos alterados:
- `clients/atc/app/public/assets/js/local/financeiro_contas_pagar_receber_res_form.js`
- `clients/atc/app/public/assets/js/local/financeiro_grid_receita.js`
- `clients/atc/app/app/templates/lancamento/financeiro_contas_pagar_receber_res_form.twig`
- `clients/atc/app/app/templates/partials/financeiro_grid_receita.twig`

Correcoes aplicadas:
- `Periodo Vencimento` de Receita/Despesa passou a iniciar com mes completo
- criada funcao `fcLimparPeriodosFinanceiro(sufixo, manter)`
- ao selecionar um periodo em uma aba, os outros periodos da mesma aba sao limpos
- criada funcao `fcPeriodoReceita(campo)` para ler diretamente o campo visivel no clique do Buscar
- clique do Buscar da Receita passou a usar `off/on` para evitar handler duplicado
- quando a API retorna vazio, tabela exibe `Nenhum registro encontrado`
- cache bust atualizado:
  - `financeiro_contas_pagar_receber_res_form.js?v=16`
  - `financeiro_grid_receita.js?v=15`

Validacoes:
- Receita por `Periodo Faturamento` de maio retornou registros
- Despesa por mes completo retornou registros
- `Todos Lancamentos` por mes completo retornou registros
- foi confirmado que nao havia receita em `dt_vencimento` de maio/2026 no banco local, mas havia receitas em maio/2025 por `dt_faturamento`

#### RH / Ponto / Reloginho / Escalas - schema necessario

Problemas relacionados:
- reloginho/acompanhamento de ponto nao preenchia periodo automaticamente
- RH Escalas nao carregava corretamente
- tela de colaborador ficava carregando ao editar

Arquivo de schema consolidado:
- `clients/atc/database/aplicar_ajustes_atc_schema.sh`

Ajustes de banco incluidos:
- `leads.dia_faturamento`
- `apontamento_folga.feriado_pk`
- tabela `feriados`
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

Arquivos locais modificados relacionados ao pacote completo ATC:
- `clients/atc/app/app/src/controllers/PontoFolhaController.php`
- `clients/atc/app/app/src/controllers/RondaController.php`
- `clients/atc/app/app/src/models/AgendaColaboradorPadrao.php`
- `clients/atc/app/app/src/models/Ponto.php`
- `clients/atc/app/app/src/models/Ronda.php`
- `clients/atc/app/app/templates/colaborador/colaborador_res_form.twig`
- `clients/atc/app/app/templates/conta/colaborador/colaborador_res_form.twig`
- `clients/atc/app/public/assets/js/local/colaborador_res_form.js`
- `clients/atc/app/app/templates/ronda/registrar.twig`
- `clients/atc/app/public/assets/js/local/ronda_registro.js`
- `clients/atc/app/app/routes-api.php`
- `clients/atc/app/app/routes.php`

Observacao:
- esses arquivos devem ser considerados no pacote de subida completo da ATC, pois fazem parte dos problemas relatados originalmente, embora o primeiro relatorio tenha focado indevidamente no Financeiro

#### Arquivos que devem subir no pacote completo ATC

Arquivos principais:
- `clients/atc/app/app/routes-api.php`
- `clients/atc/app/app/routes.php`
- `clients/atc/app/app/src/controllers/PontoFolhaController.php`
- `clients/atc/app/app/src/controllers/RondaController.php`
- `clients/atc/app/app/src/models/AgendaColaboradorPadrao.php`
- `clients/atc/app/app/src/models/ContaBancaria.php`
- `clients/atc/app/app/src/models/Ponto.php`
- `clients/atc/app/app/src/models/Ronda.php`
- `clients/atc/app/app/templates/colaborador/colaborador_res_form.twig`
- `clients/atc/app/app/templates/conta/colaborador/colaborador_res_form.twig`
- `clients/atc/app/app/templates/lancamento/financeiro_contas_pagar_receber_res_form.twig`
- `clients/atc/app/app/templates/menu/financeiro.twig`
- `clients/atc/app/app/templates/partials/financeiro_grid_receita.twig`
- `clients/atc/app/app/templates/ronda/registrar.twig`
- `clients/atc/app/public/assets/js/local/colaborador_res_form.js`
- `clients/atc/app/public/assets/js/local/financeiro_contas_pagar_receber_res_form.js`
- `clients/atc/app/public/assets/js/local/financeiro_grid_receita.js`
- `clients/atc/app/public/assets/js/local/ronda_registro.js`
- `clients/atc/database/aplicar_ajustes_atc_schema.sh`

Arquivos que apareceram alterados localmente, mas exigem cuidado antes de subir:
- `clients/atc/app/app/settings.php`
- `clients/atc/app/app/templates/login/login.twig`
- `clients/atc/app/app/templates/theme/base.login.twig`
- `clients/atc/app/app/templates/lead/qrCode.twig`
- `clients/atc/app/public/assets/js/local/qrCode.js`

Motivo do cuidado:
- `settings.php` pode conter configuracao local de Docker/banco
- arquivos de login/QRCode podem nao fazer parte do problema de producao atual

Arquivos que nao devem subir como aplicacao:
- `clients/atc/database/dump.sql`
- `clients/atc/database/dump.sql.gz`

#### Validacao recomendada no VPS apos subida

Na pasta real do projeto no VPS:
- `grep -R "financeiro_grid_receita.js?v=15" -n app/app/templates`
- `grep -R "financeiro_contas_pagar_receber_res_form.js?v=16" -n app/app/templates`
- `grep -R "fcPeriodoReceita" -n app/public/assets/js/local/financeiro_grid_receita.js`
- `grep -R "fcLimparPeriodosFinanceiro" -n app/public/assets/js/local/financeiro_contas_pagar_receber_res_form.js`
- `grep -R "listarEmpresaContasAtivas" -n app/app/src/models/ContaBancaria.php`
- `grep -R "hr_trabalhadas" -n app/app/src app/public/assets/js/local app/app/templates`
- `grep -R "reloginhoHistoricoPonto" -n app/app/src`

No banco usado pela producao:
- `SHOW COLUMNS FROM lancamentos_financeiros LIKE 'nfse_pk';`
- `SHOW COLUMNS FROM leads LIKE 'dia_faturamento';`
- `SHOW COLUMNS FROM apontamento_folga LIKE 'feriado_pk';`
- `SHOW COLUMNS FROM agenda_colaborador_padrao LIKE 'hr_total_expediente';`
- `SHOW COLUMNS FROM agenda_colaborador_padrao LIKE 'hr_jornada_trabalho_intervalo';`
- `SHOW COLUMNS FROM agenda_colaborador_apontamento LIKE 'ic_status';`
- `SHOW COLUMNS FROM apontamento_ponto LIKE 'hr_trabalhadas';`
- `SHOW COLUMNS FROM apontamento_ponto LIKE 'hr_excedentes';`
- `SHOW COLUMNS FROM apontamento_ponto LIKE 'hr_faltantes';`
- `SHOW COLUMNS FROM ponto LIKE 'ic_validacao_facial';`
- `SHOW TABLES LIKE 'feriados';`
- `SHOW TABLES LIKE 'validar_reloginho';`

Cache/opcache:
- se Docker: `docker restart atc-php atc-nginx`
- se PHP-FPM/nginx: reiniciar PHP-FPM e nginx
- se Apache: reiniciar Apache
- no navegador: recarregar com cache limpo

#### Correcao de comunicacao registrada

Erro no atendimento:
- foi gerado inicialmente um relatorio de subida incompleto, focado no Financeiro
- isso nao cobria todos os problemas informados pelo cliente no VPS

Correcao:
- pacote completo ATC deve considerar Financeiro + RH/Ponto/Reloginho + Colaborador + Escalas + schema
- nao recomendar subida do projeto inteiro no escuro
- primeiro validar se arquivos foram enviados para a pasta correta, se o banco correto recebeu o schema e se o cache/opcache foi limpo

---

## 2026-05-08

### Cliente: `atc`

#### Registro consolidado das ultimas 48 horas

Acao realizada:
- este historico foi atualizado com o pacote completo de alteracoes e validacoes da ATC
- objetivo e evitar nova subida parcial e deixar claro o que precisa ser aplicado no VPS

Resumo final do pacote:
- Financeiro: menu, permissoes, combos Empresa/Conta, Receita/Despesa/Todos Lancamentos, filtros e cache bust
- Banco: schema ATC consolidado no `aplicar_ajustes_atc_schema.sh`
- RH/Ponto/Reloginho/Escalas/Colaborador: incluir os arquivos modificados relacionados e validar colunas/tabelas do schema
- VPS: confirmar pasta correta, banco correto e limpeza de cache/opcache

---

## Base Para Proximos Clientes

### 1. Integracao com API externa do app ponto

Verificar sempre:
- se a tela le status na API externa
- se o botao de escrita tambem escreve na API externa
- se existe mistura entre `pk` local e `pk` externo

Aplicar quando necessario:
- envio de `api_pk`
- envio de `colaborador_pk`
- sincronizacao pelo estado final salvo no banco

### 2. Sincronizacao de colaborador

Verificar sempre:
- se o payload externo e montado a partir do request bruto
- se `empresas_pk` ou `contas_pk` recebem descricao textual em vez de PK
- se exclusao logica local chama remocao fisica no servidor externo

Aplicar quando necessario:
- sincronizacao pelo registro persistido
- separacao entre desativar e excluir

### 3. Endpoint de registro de ponto

Verificar sempre:
- suporte a JSON bruto
- latitude/longitude obrigatorias
- nomes inconsistentes de campos
- dependencia forte de GD

Aplicar quando necessario:
- parser com fallback
- geolocalizacao opcional
- normalizacao de `ic_ponto_fora_turno`
- fallback para imagem invalida ou ambiente sem GD

### 4. Reloginho

Verificar sempre:
- se o JS publicado e o mesmo do local
- versao do asset via query string
- se a resposta do endpoint vem limpa, sem warning PHP antes do JSON
- se a grade trata corretamente dias com apenas intervalo/fim de expediente

Aplicar quando necessario:
- ajuste de `cache bust`
- saneamento do backend para nao emitir warning/notice
- revisao das regras de consolidacao diaria

### 5. Compatibilidade com legado restaurado

Verificar sempre:
- diferencas de schema entre o dump e o codigo
- colunas opcionais ausentes
- dumps desatualizados em relacao a producao

Aplicar quando necessario:
- guards por existencia de coluna
- validacao do dump antes de concluir erro funcional

---

## Ordem Recomendada de Replicacao

1. Validar se o dump/base local realmente contem os dados esperados.
2. Corrigir fluxo de liberacao e sincronizacao com API externa.
3. Corrigir endpoint de ponto e tratamento de imagem.
4. Ajustar reloginho e consistencia das respostas JSON.
5. Validar diferencas de schema do legado.
6. Atualizar historico do cliente e este consolidado.

---

## Fontes

- `clients/brasil-servis/docs/historico_ajustes_integracao_api.md`
- `clients/america-servis/docs/HISTORICO.md`

---

## 2026-05-05 - ATC: de/para controlado com Brasil Servis

Foi aplicado no cliente ATC o pacote de ajustes replicaveis da Brasil Servis, sem copia integral do sistema.

Arquivos sincronizados:
- `colaborador_cad_form.js`
- `SolicitacaoAcessoAppController.php`
- `SolicitacaoAcessoApp.php`
- `Colaborador.php`
- `WebPontoApiController.php`
- `Ponto.php`
- `PontoFolha.php`
- `AgendaColaboradorPadrao.php`
- `agenda_escala_cad_form.js`
- `agenda_escala_cad_form.twig`

Backup previo dos arquivos ATC:
- `clients/atc/source/referencias/pre-brasil-sync-2026-05-05/app/`

Ajuste especifico aplicado:
- `Ponto.php` passou a verificar a existencia de `ponto.ic_ponto_fora_turno` antes de tentar gravar a coluna, pois o dump restaurado do ATC nao possui esse campo.

Validacoes:
- lint PHP e JS sem erros
- containers ATC ativos e MySQL healthy
- login, menu principal, colaborador, grid de colaborador, logo/API basica e financeiro responderam `HTTP 200`
- endpoints validados retornaram `status=true` onde aplicavel

---

## 2026-05-05 - ATC: base completa Brasil Servis

Por solicitacao do cliente, o ATC passou a usar o codigo completo da Brasil Servis como base correta.

Procedimento:
- backup completo do ATC anterior em `clients/atc/source/referencias/full-pre-brasil-base-2026-05-05/app/`
- sincronizacao completa de `clients/brasil-servis/app/` para `clients/atc/app/`
- remocao das diferencas antigas do ATC durante a sincronizacao

Excecoes mantidas:
- `clients/atc/app/app/settings.php`, para manter conexao com `atc-mysql` e banco `gepros1com_atc`
- `clients/atc/app/app/src/models/Ponto.php`, com guarda de compatibilidade para a coluna `ponto.ic_ponto_fora_turno`, ausente no dump ATC restaurado

Validacoes:
- comparacao seca contra Brasil Servis sem diferencas, exceto as duas excecoes acima
- lint PHP de `settings.php` e `Ponto.php` sem erros
- containers ATC ativos e MySQL healthy
- login, menu principal, colaborador, financeiro, grid de colaborador e extrato financeiro responderam `HTTP 200`
- APIs de login, colaborador e financeiro retornaram `status=true`

### Ajuste visual posterior no login ATC

Depois da base Brasil Servis completa, a tela `/login` exibiu layout fora do padrao visual do ATC porque o painel lateral herdado tinha logo GPROS fixo.

Foi ajustado:
- `base.login.twig` para o painel lateral usar o logo do cliente carregado por `/api/conta/carregarLogo`
- `oauth.js` para aplicar o logo em todos os elementos `.js-client-logo`
- `authentication.css` para limitar o tamanho dos logos no login

Validado `/login` com `HTTP 200`, CSS/JS servidos pelo container e `node --check` em `oauth.js` sem erros.

### Ajuste RH ATC apos base Brasil Servis

Ao abrir `/menu/rh`, o ATC exibia `Falhou a requisição: error`.

Causa:
- `POST /api/lead/listarTodos?&pk=` retornava `HTTP 500`
- o codigo Brasil Servis consulta `leads.dia_faturamento`
- o dump ATC restaurado nao tinha essa coluna

Acao:
- adicionada a coluna `leads.dia_faturamento int(11) NULL DEFAULT NULL` no banco `gepros1com_atc`

Validacoes:
- `/menu/rh` respondeu `HTTP 200`
- `/api/lead/listarTodos?&pk=` respondeu `HTTP 200` com `status=true`
- `/api/agenda_colaborador_apontamento/listarDisciplina?&pk=` permaneceu `HTTP 200`
- comparacao seca de codigo contra Brasil Servis sem diferencas, exceto adaptacoes locais ja documentadas

### Ajuste Colaborador ATC - DataTables tblFeriado

Na tela `/colaborador/receptivo?local=1`, o DataTables `tblFeriado` exibia `Invalid JSON response`.

Causa:
- `/api/feriado/listarFeriadoRelogio` retornava erro SQL em texto puro
- faltavam no banco ATC objetos esperados pelo codigo Brasil Servis:
  - coluna `apontamento_folga.feriado_pk`
  - tabela `feriados`

Acao:
- adicionada `apontamento_folga.feriado_pk int(11) NULL DEFAULT NULL`
- criada tabela `feriados` com a estrutura da Brasil Servis

Validacoes:
- `/api/feriado/listarFeriadoRelogio` respondeu `HTTP 200` com JSON valido e `status=true`
- `/colaborador/receptivo?local=1` respondeu `HTTP 200`
- `/api/colaborador/listarGrid` respondeu `HTTP 200`

### Ajuste ATC - Pesquisar Ponto no Reloginho

No modal `Acompanhamento de Ponto`, o botao `Pesquisar Ponto` nao carregava a grade quando os campos ocultos de escala/posto vinham vazios.

Causa:
- o frontend parava antes de chamar a API se `agenda_consulta_folha_colaborador_pk` nao estivesse preenchido
- a busca de escala considerava apenas `dt_inicio_agenda` dentro do mes, mas a base ATC possui escalas iniciadas em anos anteriores e ainda vigentes
- o banco ATC ainda estava sem objetos esperados pelo codigo Brasil Servis no fluxo de ponto

Acao:
- ajustada a busca `pegarPostoByColaboradorPorMesAno` para considerar agendas vigentes no periodo
- ajustado `colaborador_res_form.js` para tentar preencher escala/posto antes de bloquear a pesquisa
- alinhado schema ATC com Brasil Servis:
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

Validacoes:
- busca de escala para colaborador com agenda vigente respondeu `HTTP 200` e retornou agenda
- grade `/api/ponto_folha/listarConsultaPontoColaborador` respondeu `HTTP 200` com `status=true`
- colaboradora `pk=917` informada na tela nao possui escala no banco ATC; nesse caso o fluxo agora deve exibir o aviso de falta de escala
- lint PHP sem erros nos arquivos alterados

Reforco:
- atualizado include de `colaborador_res_form.js` de `v=15` para `v=16` para forcar o navegador a baixar o JS novo
- adicionada mensagem visivel dentro do modal quando nao existir escala para o colaborador/periodo

### Integracao ATC - Ronda no Docker

A ferramenta separada de Ronda localizada em `/source/atc` foi analisada e integrada ao ATC dockerizado sem copiar o fluxo antigo `gtronda`.

Causa:
- o ATC ja tinha cadastro/impressao de QR Code e relatorio de rondas
- o QR Code ainda apontava para a aplicacao externa `https://gepros1.com.br/crm/facilities/gtronda/view/ronda_cad_form.php`
- o legado antigo gravava na tabela `ronda` recebendo `posto` e `local` pela URL

Acao:
- criada rota publica `/ronda/registrar?qr=<pk>`
- criada API `POST /api/ronda/registrar`
- criada tela nativa `ronda/registrar.twig`
- criado JS `ronda_registro.js`
- atualizado `qrCode.js` para gerar QR Code apontando ao proprio host do ATC via `window.location.origin`
- adicionados metodos no model `Ronda` para buscar `lead_ronda_qrcode.pk` e gravar em `ronda`

Compatibilidade:
- a tabela `ronda` foi mantida no formato legado
- a gravacao continua populando `leads_pk`, `local_ronda_pk` e `ds_ronda` como o relatorio atual espera
- nao foi alterado menu, relatorio ou fluxo migrado existente

Validacoes:
- lint PHP sem erros em `Ronda.php` e `RondaController.php`
- `/ronda/registrar?qr=1` respondeu `HTTP 200` dentro do container
- `POST /api/ronda/registrar` respondeu `HTTP 200` com `status=true`
- `/api/ronda/relRondas` retornou o registro criado no teste
- dados temporarios de teste removidos do banco

Complemento para QR Code antigo:
- criado arquivo de compatibilidade em `/crm/facilities/gtronda/view/ronda_cad_form.php`
- o caminho antigo redireciona para `/ronda/legado`
- `/ronda/legado` resolve `posto` e `local` no cadastro `lead_ronda_qrcode`
- quando localizado, redireciona para `/ronda/registrar?qr=<pk>`
- validado fluxo completo com `302 -> 302 -> HTTP 200`

### Migracao GT para Docker

Cliente GT migrado para Docker usando o codigo migrado da Brasil Servis como base da aplicacao e o dump proprio da GT.

Insumos:
- `clients/gt/database/gepros1com_gt.sql.gz`
- `clients/gt/source/gt_code.tar.gz`
- base de codigo ativa usada como referencia: `clients/brasil-servis/app`

Acao:
- criada estrutura ativa `clients/gt/app`
- criada infraestrutura `clients/gt/infra`
- configurados containers separados:
  - `gt-nginx`
  - `gt-php`
  - `gt-mysql`
- configurado banco `gepros1com_gt`
- configurada porta web `8086`
- configurada porta MySQL `3312`
- ajustado `app/app/settings.php` para `gt-mysql`
- importado dump GT

Observacao:
- a primeira execucao do importador gerou `database/dump.sql`, mas falhou por uma fragilidade do script herdado ao misturar logs com retorno de caminho
- a importacao foi concluida apontando diretamente para `database/dump.sql`
- o script de importacao do GT foi ajustado para imprimir logs em `stderr`, evitando essa falha em proximas importacoes

Compatibilidade de schema:
- adicionada coluna `leads.dia_faturamento int(11) NULL DEFAULT NULL`, esperada pelo codigo Brasil Servis e ausente no dump GT

Validacoes:
- `docker compose config` sem erro
- `gt-mysql` healthy
- banco importado com `148` tabelas
- tabela `usuarios` presente
- `/login` respondeu `HTTP 200`
- `POST /api/auth/login` com `admin` retornou `status=true`
- `/menu/principal` respondeu `HTTP 200`
- `/api/lead/listarTodos` respondeu `HTTP 200` apos ajuste de schema

Acesso:
- `http://127.0.0.1:8086/login`
- usuario validado: `admin`
- senha validada: `@Gpres_25`
## [2026-05-30 11:05] Publish - brasil-servis
- Commit: cb06925 - fix: corrige write_array_to_file para set -e
- Reason: Piloto Git Deploy Brasil Servis
- Container: brasil-php
- Manifest: /Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/brasil-servis/docs/releases/release-2026-05-30-11-05-26.txt

## [2026-05-31 10:36] Publish - america-servis
- Commit: eb3c9bb - chore: release manifest brasil-servis 2026-05-30 11-05-26
- Reason: Piloto Git Deploy America Servis
- Container: america-php
- Manifest: /Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/docs/releases/release-2026-05-31-10-36-21.txt

