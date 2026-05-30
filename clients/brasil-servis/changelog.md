# Changelog - Brasil Servis

## [2026-05-27] - Escala Alternada, Edicao de Escala e Ajustes de Integracao

### Contexto
Solicitacao para tratar problema no modulo de escalas e reloginho quando a escala possui:

- `Escala Alternada = Sim`
- escala do tipo `5x1` ou `6x1`
- folga movel baseada na primeira semana da escala
- necessidade de alternancia `progressiva` ou `regressiva`

Tambem foi solicitado ajustar o fluxo de edicao para:

- distinguir ajuste simples de mudanca estrutural
- confirmar cancelamento da escala atual e criacao de nova escala
- manter historico da escala cancelada

### Regra funcional consolidada

- o quadro semanal representa a primeira semana do inicio da escala
- o dia de folga marcado nessa primeira semana e a referencia inicial do ciclo
- se `Escala Alternada = Nao`, a escala continua fixa
- se `Escala Alternada = Sim`:
  - aplica apenas para `5x1` e `6x1`
  - usa `dias_escala_alternada` como salto semanal
  - usa `tipo_escala_alternada` para definir:
    - `1 = progressiva`
    - `2 = regressiva`
- a regra deve materializar corretamente `escala_dados_colaborador`

### Alteracoes de banco

- criado arquivo de migration:
  - `database/import/20260527_000001_escala_alternada_brasil_servis.sql`
- novos campos em `agenda_colaborador_padrao`:
  - `dias_escala_alternada`
  - `tipo_escala_alternada`

### Alteracoes de backend

#### Controller
- arquivo:
  - `app/app/src/controllers/AgendaColaboradorPadraoController.php`
- ajustes realizados:
  - leitura dos novos campos da escala alternada
  - suporte ao campo `confirmar_nova_escala`
  - resposta JSON do `salvar` e `escalaDadosColaborador`
  - correcao do uso de `withJson(...)`

#### Model
- arquivo:
  - `app/app/src/models/AgendaColaboradorPadrao.php`
- ajustes realizados:
  - persistencia dos campos novos
  - nova logica de alternancia semanal para `5x1` e `6x1`
  - suporte a folga progressiva e regressiva
  - validacao de campos obrigatorios quando `Escala Alternada = Sim`
  - classificacao de mudanca simples versus estrutural
  - retorno de `requires_confirmation` para alteracoes estruturais
  - fluxo para cancelar a escala atual e criar nova escala
  - preservacao de `processos_etapas_pk` da escala atual quando o frontend nao o reenviar na edicao

### Alteracoes de frontend

#### Templates Twig
- arquivos:
  - `app/app/templates/escala/agenda_escala_cad_form.twig`
  - `app/app/templates/conta/escala/agenda_escala_cad_form.twig`
  - `app/app/templates/partials/colaborador_controle_escala_cad_form.twig`
- ajustes realizados:
  - campos novos:
    - `Tipo de Escala Alternada`
    - `Dias Escala Alternada`
  - ordem visual ajustada para mostrar primeiro o tipo e depois os dias
  - texto de apoio alterado para:
    - `O quadro de escala abaixo representa a primeira semana do inicio da escala.`

#### JavaScript local
- arquivos:
  - `app/public/assets/js/local/agenda_escala_cad_form.js`
  - `app/public/assets/js/local/colaborador_controle_escala_cad_form.js`
- ajustes realizados:
  - toggle dos campos da escala alternada
  - validacao dos novos campos
  - envio dos novos parametros no `salvar`
  - suporte ao fluxo de confirmacao para nova escala
  - tentativa de preservacao de `processos_etapas_pk` na edicao

#### JavaScript global
- arquivo:
  - `app/public/assets/js/global/bestflow.js`
- ajuste realizado:
  - `carregarController()` passou a preservar respostas com `requires_confirmation`
  - evita toast de erro generico antes da tela tratar a confirmacao estrutural

### Problemas diagnosticados hoje

#### 1. `parsererror` no salvar da escala
- causa identificada:
  - resposta HTTP voltava com warning PHP em vez de JSON valido
  - erro encontrado no `Network`:
    - `json_encode() expects parameter 2 to be int, array given`
- causa tecnica:
  - uso incorreto de `withJson(..., 200, [])`
- correcao aplicada:
  - ajuste para `withJson(..., 200)` e `withJson(..., 500)`

#### 2. Confirmacao estrutural sendo tratada como erro generico
- causa identificada:
  - backend respondia corretamente com:
    - `status: false`
    - `requires_confirmation: true`
  - mas o helper global descartava a resposta e exibia:
    - `Falhou a requisicao`
- correcao aplicada:
  - ajuste no `bestflow.js` para nao tratar `requires_confirmation` como falha de transporte

#### 3. Erro de integridade ao criar nova escala
- erro exibido:
  - `SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'processos_etapas_pk' cannot be null`
- causa identificada:
  - no fluxo de criacao da nova escala estrutural, `processos_etapas_pk` chegava vazio na tela
  - o backend tentava inserir a nova escala com esse campo nulo
- correcao aplicada:
  - preservacao do valor existente da escala atual no backend

### Ajustes de versionamento de assets

- `bestflow.js` passou para `v=5` nos templates base
- `agenda_escala_cad_form.js` passou a usar versionamento para forcar refresh de cache
- `colaborador_controle_escala_cad_form.js` tambem recebeu versionamento

### Validacoes executadas

- `php -l app/app/src/controllers/AgendaColaboradorPadraoController.php`
- `php -l app/app/src/models/AgendaColaboradorPadrao.php`
- `node --check app/public/assets/js/global/bestflow.js`
- analise precisa do `Network` no navegador para determinar:
  - resposta JSON invalida
  - retorno de `requires_confirmation`
  - erro de banco com `processos_etapas_pk`

### Pendencias e proximo passo recomendado

- validar ponta a ponta a edicao estrutural com criacao da nova escala
- validar a geracao de `escala_dados_colaborador` apos confirmacao
- validar o reflexo final no reloginho e no fechamento
- revisar se ainda existe algum ponto do frontend que deixa `processos_etapas_pk` vazio na edicao, mesmo com a protecao no backend

## [2026-05-22] - Análise de Código - Módulo Folha de Ponto

### Descrição
Solicitação para verificar e comentar os cálculos de **H.T (Horas Trabalhadas)**, **H.E (Horas Excedentes)** e **H.F (Horas Faltantes)** no módulo de folha de ponto, para que não sejam mais apresentados.

### Arquivos analisados

#### Backend (PHP)
- `app/src/models/PontoFolha.php`
  - Métodos que calculam totais: `TotalHrTrabalhada()`, `TotalHrExcedentes()`, `TotalHrFaltantes()`, `TotalHrExtra50()`, `TotalHrExtra100()`
  - Retorno dos totais nas linhas ~2524-2528 (método `listarRegistros`)
  - Retorno dos totais nas linhas ~2987-2991 (outro método de listagem)
  - Função `calcularHrsTrabalhadas()` - cálculo interno de horas
  - Função `retornarDifHora()` - cálculo de diferença entre horários
  - Função `retornarDifHoraFaltantes()` - cálculo de horas faltantes

- `app/src/controllers/PontoFolhaController.php`
  - Método `receptivoPrint()` - renderiza a view de impressão da folha de ponto
  - Método `listarDadosImpressao()` - retorna dados para impressão

#### Frontend (JavaScript)
- `public/assets/js/local/ponto_folha_registros_cad_form.js`
  - Função `PreencherAutomatico()` - calcula automaticamente H.T, H.E e H.F baseado nos horários de entrada/saída/intervalo
  - Função `calculoOnchange()` - recalcula quando os campos são alterados
  - Função `calcTotal()` - soma os totais de H.T, H.E, H.F e A.N de todas as linhas
  - Função `hmToMins()` - converte horário HH:MM para minutos
  - Função `converHrs()` - converte minutos para formato HH:MM
  - Variáveis `v_ht_total`, `v_he_total`, `v_hf_total` (linhas ~230-237) - recebem os totais do backend
  - Renderização dos totais nas linhas que montam `v_html`:
    - `D.T` (Dias Trabalhados)
    - `H.T` (Horas Trabalhadas)
    - `H.E` (Horas Excedentes)
    - `H.F` (Horas Faltantes)
    - `H.E1` (Hora Extra 50%)
    - `H.E2` (Hora Extra 100%)
    - `A.N` (Adicional Noturno)

#### Templates (Twig)
- `templates/ponto_folha/ponto_folha_registros_cad_form.twig` (linhas ~131-174)
  - Cabeçalhos da tabela: H.T, H.E, H.F, H.E1, H.E2
  - Legenda no rodapé explicando cada sigla

### Pendente
As alterações solicitadas (comentar/remover os cálculos e exibição de H.T, H.E, H.F) **ainda não foram implementadas**. Aguardando confirmação do que deve ser feito exatamente.

### Containers
- **brasil-nginx** → porta 8083
- **brasil-mysql** → porta 3309
- **brasil-php** → porta 9000
