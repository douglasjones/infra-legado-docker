# Analise Da Arquitetura Do Legado Original

Data: 2026-03-26

## Bloco A - Arquitetura real do legado

### 1. Bootstrap e framework

O fluxo principal da aplicacao usa Slim de forma real e direta.

Pontos comprovados:

- document root real: `legado-original/public/`
- entrypoint HTTP: `legado-original/public/index.php`
- bootstrap:
  - carrega `vendor/autoload.php`
  - inicia sessao
  - instancia `new \Slim\App($settings)`
  - registra `middleware.php`
  - registra `dependencies.php`
  - registra `routes.php`
  - registra `routes-api.php`
  - executa `$app->run()`

Framework identificado:

- `slim/slim` `3.12.5`
- `slim/twig-view` `2.5.0`

Conclusao:

- o sistema nao e PHP puro no fluxo principal
- o request web normal entra pelo Slim
- controllers, views Twig e APIs internas estao todos conectados ao Slim

### 2. Container, view e banco

Em `legado-original/app/dependencies.php` o container do Slim registra:

- `view`: Twig com templates em `legado-original/app/templates`
- `pdo`: conexao PDO MySQL manual
- `notFoundHandler`: renderiza `theme/404.twig`

O `BaseController` recebe o `Container` e injeta:

- `$this->view`
- `$this->pdo`

Isso prova o padrao real:

- controller Slim
- render Twig
- model proprio com PDO e SQL manual

Nao ha ORM.

### 3. Middlewares e sessao

O middleware efetivo relevante e `App\Middleware\Authentication`.

Funcao real:

- le `Session::getSession('session_user')`
- exige `par1` na sessao
- se nao houver sessao, redireciona para `/login`
- e aplicado nas rotas GET de interface em `routes.php`

Importante:

- `routes-api.php` organiza os endpoints em grupos `/api/...`
- nessa leitura, a protecao principal por middleware esta explicitamente nas rotas de tela
- varias APIs dependem da sessao mesmo sem um middleware global visivel nesse arquivo

### 4. Estrutura real do projeto

Diretorios essenciais do legado:

- `legado-original/public/`
  - entrada HTTP
  - assets publicos
- `legado-original/app/`
  - bootstrap parcial
  - rotas
  - middlewares
  - settings
  - dependencies
- `legado-original/app/src/controllers/`
  - controllers Slim
- `legado-original/app/src/models/`
  - models com SQL manual
- `legado-original/app/src/middlewares/`
  - middlewares proprios
- `legado-original/app/templates/`
  - views e partials Twig
- `legado-original/vendor/`
  - dependencias Composer

### 5. Estrutura publica real

Padrao de templates:

- telas principais estendem `theme/base.twig`
- login estende `theme/base.login.twig`
- `theme/base.twig` inclui:
  - `theme/menu.twig`
  - conteudo da tela
  - `theme/footer.twig`

Padrao de JS:

- JS globais sao carregados no base
- JS locais por modulo sao carregados no template da tela

Observacao importante sobre esta copia:

- os templates da app principal referenciam `/assets/js/global/...`
- nesta arvore entregue, os arquivos globais efetivamente localizados estao em `legado-original/appPonto/public/assets/js/global/`
- `legado-original/public/assets/js/local/` existe e contem os JS locais principais

Isso indica que a copia analisada preserva a arquitetura da app, mas a distribuicao fisica dos assets globais nesta snapshot nao esta toda concentrada em um unico caminho da raiz `public/`.

## Bloco B - Funcionamento real dos fluxos criticos

### 1. Login

Fluxo real:

1. rota GET `/login` em `legado-original/app/routes.php`
2. `LoginController::login()`
3. render de `login/login.twig`
4. `login/login.twig` estende `theme/base.login.twig`
5. a tela carrega `oauth.js`
6. `oauth.js` intercepta o clique em `.btn-auth`
7. faz `POST /api/auth/login`
8. `LoginController::apiLogin()` chama `Login::login()`
9. `Login::login()` consulta `usuarios`, `grupos` e `contas`
10. se autenticar, grava `$_SESSION['session_user']`
11. JS redireciona para `menu/principal`

Caracteristicas:

- login de tela: server-side para render inicial
- autenticacao: client-side via AJAX para `/api/auth/login`
- resposta de login nao renderiza a proxima tela; ela apenas cria sessao e o browser navega

### 2. Menu principal

Fluxo real:

1. rota GET `/menu/principal`
2. `MenuController::principal()`
3. render de `menu/principal.twig` ou `menu/principal_cliente.twig`
4. template estende `theme/base.twig`
5. `theme/base.twig` inclui `theme/menu.twig`
6. `theme/base.twig` chama `permissaoMenu()` no `$(document).ready(...)`
7. `permissaoMenu()` esta em `bestflow.js`
8. `bestflow.js` faz `POST /api/usuario/verificarPermissaoMenu`
9. `UsuarioController::verificarPermissaoMenu()` agrega 8 verificacoes
10. `Usuario::verificarPermissaoMenu()` consulta:
   - `usuarios`
   - `grupos`
   - `modulos_grupos`
   - `modulos`
11. o JS mostra ou oculta itens do menu conforme as flags retornadas

Conclusao:

- o menu e hibrido
- a pagina e renderizada no servidor
- a permissao visual dos modulos e decidida no client-side a partir de uma API Slim

### 3. Editar Lead

Fluxo real do grid para painel:

1. a lista usa `public/assets/js/local/lead_res.js`
2. a acao de painel chama `sendPost('lead', 'leadMainPainel', { ic_abertura, pk, local })`
3. `sendPost()` esta em `bestflow.js` e apenas navega via `window.location.href`
4. rota GET `/lead/leadMainPainel`
5. `LeadController::leadMainPainel()`
6. render de `lead/lead_main_form.twig`
7. o template inclui:
   - `lead_main_form.js`
   - `lead_det_form.js`
   - `contato_res_form.js`
   - `contato_cad_form.js`
   - `agenda_res_form.js`
   - `agenda_cad_form.js`
   - `comercial_res_form.js`
   - `comercial_cad_form.js`
   - `ocorrencia_res_form.js`
   - `ocorrencia_cad_form.js`
   - `documento_res_form.js`
   - `documento_cad_form.js`
8. o template inclui o partial `lead/lead_det_form.twig`

Comportamento real do formulario:

- `lead_det_form.twig` renderiza inputs vazios
- o HTML nao traz os valores do registro preenchidos server-side
- o partial contem `input` e `div` estruturais como:
  - `#leads_pk`
  - `#ds_lead`
  - `#ds_lead_titulo`
  - `#id_lead`
  - `#dt_cadastro_lead`
  - `#dt_ult_atualizacao_lead`
- isso prova que o preenchimento do painel de Lead e client-side

Fonte de dados:

- `LeadController::listarPk()`
- `Lead::listarPorPk($pk)`
- SQL manual em `leads` com joins em `usuarios`

Conclusao:

- o painel de edicao de Lead nao foi desenhado para vir preenchido no HTML
- ele depende de JS local para consultar `/api/lead/listarPk` e hidratar a tela

### 4. Editar Colaborador

Fluxo real do grid para formulario:

1. a lista usa `public/assets/js/local/colaborador_res_form.js`
2. a acao `fcEditar(v_pk)` chama `sendPost('colaborador', 'cadForm', { colaborador_pk, local })`
3. rota GET `/colaborador/cadForm`
4. `ColaboradorController::cadForm()`
5. render de `colaborador/colaborador_cad_form.twig`
6. o template inclui:
   - `colaborador_cad_form.js`
   - `colaborador_qualificacao_res_form.js`
   - `colaborador_exames_cursos_res.js`
   - `colaborador_beneficios_res.js`
   - `colaborador_documento_res.js`
   - `colaborador_afastamento_ferias_res.js`
   - `movimentar_estoque_res_form.js`
   - `colaborador_controle_escala_res_form.js`
   - `colaborador_controle_escala_cad_form.js`
7. o formulario contem apenas:
   - hidden `#colaborador_pk` preenchido com o pk
   - campos estruturais vazios como `#ds_colaborador`

Fonte de dados:

- `ColaboradorController::listarPk()`
- `Colaborador::listarPk($pk)`
- SQL manual grande em `colaboradores` e joins associados

Conclusao:

- o formulario de Colaborador tambem e hibrido com preenchimento client-side
- o servidor entrega a casca da tela e o pk
- o JS local deve buscar os dados reais via API e preencher os campos

### 5. Padrao real PHP -> View -> JS

Padrao predominante no legado:

- GET Slim renderiza a pagina Twig
- Twig inclui partials e scripts locais por tela
- JS local usa `sendPost()` para navegar entre telas
- JS local usa `carregarController()` para chamar `/api/<modulo>/<acao>`
- APIs retornam JSON por `Json::run(...)`
- models executam SQL manual via PDO

Portanto:

- o sistema e fortemente hibrido
- nao e server-side puro
- nao e SPA
- a tela nasce no servidor e se completa no navegador

## Bloco C - Diagnostico comparativo com a base Docker atual

### 1. O que foi preservado corretamente

No app atual em Docker, permanecem identicos ao legado original:

- `public/index.php`
- `app/dependencies.php`
- `app/routes.php`
- `app/routes-api.php`
- `app/src/controllers/BaseController.php`
- `app/src/middlewares/Authentication.php`
- `app/templates/login/login.twig`
- `app/templates/menu/principal.twig`
- `app/templates/lead/lead_main_form.twig`
- `app/templates/colaborador/colaborador_cad_form.twig`

Conclusao:

- a arquitetura Slim principal foi preservada
- o problema principal da migracao nao e ter perdido o framework ou refeito a estrutura da app

### 2. Divergencias reais no Docker atual

#### Divergencia estrutural aceitavel

- `app/settings.php`
  - no legado original usa `host = localhost`
  - no Docker usa `host = america-mysql`

Isso e adaptacao de infraestrutura, nao mudanca de regra de negocio.

#### Divergencias reativas identificadas

Controllers modificados localmente:

- `app/src/controllers/LoginController.php`
  - foi alterado para redirecionar para `/menu/principal` se ja houver sessao
  - o original destruia/limpava sessao ao entrar em `login()`

- `app/src/controllers/LeadController.php`
- `app/src/controllers/ColaboradorController.php`
  - receberam logs temporarios `debugEditLog(...)`

Conclusao:

- a base Docker preserva a arquitetura real
- mas ja sofreu correcoes reativas e instrumentacao local
- portanto nao esta mais 100% limpa em relacao ao original

### 3. O que estava sendo mal interpretado

Pontos que a analise do legado corrige:

- editar Lead e Colaborador nao sao telas pensadas para vir totalmente preenchidas server-side
- o fluxo correto depende de JS local e endpoints `/api/.../listarPk`
- menu nao e so Twig; ele depende de `bestflow.js` e da API `/api/usuario/verificarPermissaoMenu`
- login nao e submit tradicional de form; ele usa AJAX em `oauth.js`

### 4. Sobre os assets

Os JS globais estruturais sao:

- `utils.js`
- `bestflow.js`
- `oauth.js`
- `company.js`

Funcoes estruturais identificadas:

- `sendPost()` para navegacao
- `carregarController()` para chamadas sincronas de API
- `routes()` e `routes_api()` para montar URLs
- `permissao()` e `permissaoMenu()` para autorizacao de acoes e menu

Ponto critico:

- os templates do legado dependem de JS locais adicionais para hidratar formularios
- a falta desses arquivos quebra o comportamento esperado porque a tela foi desenhada para depender deles

### 5. A base Docker atual e confiavel para continuar?

Resposta curta:

- sim, como base arquitetural
- nao, como base limpa de restauracao fiel

Justificativa:

- o nucleo Slim e a estrutura de request/response foram preservados
- a maior parte das views principais tambem
- mas a base atual ja recebeu:
  - restauracoes reativas
  - alinhamentos por material parcial
  - logs temporarios em controllers
  - ponte temporaria para `structure/oauth.twig`

### 6. Recomendacao tecnica

O caminho mais correto para continuar nao e refazer tudo do zero, mas tambem nao e seguir corrigindo no escuro.

O metodo correto daqui para frente e:

1. usar este mapeamento do legado como referencia obrigatoria
2. manter o Slim e o padrao hibrido original
3. remover suposicoes de server-side puro
4. restaurar assets e partials com base no fluxo real da tela
5. tratar a base Docker como uma restauracao em andamento, nao como fonte de verdade
6. sempre comparar com `legado-original` antes de nova correcao

## Sintese final

Arquitetura real do legado:

- Slim 3
- Twig
- PDO com SQL manual
- rotas GET para telas
- `/api/...` para operacoes e hidratacao client-side
- JS global estrutural
- JS local por modulo

Funcionamento real dos fluxos criticos:

- login: hibrido com AJAX em `/api/auth/login`
- menu: render server-side + permissao client-side por API
- editar Lead: tela server-side + preenchimento client-side
- editar Colaborador: tela server-side + preenchimento client-side

Diagnostico do Docker:

- a arquitetura real foi majoritariamente preservada
- o problema principal nao foi perder o Slim
- o problema principal foi restauracao incompleta/desalinhada de assets e alguns ajustes reativos sobre a base atual
