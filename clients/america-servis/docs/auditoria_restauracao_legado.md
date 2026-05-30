# Auditoria de Restauracao do Legado

## Objetivo
Mapear o que ainda esta faltando ou divergente na restauracao do legado dentro do ambiente Docker, sem alterar regra de negocio.

## Metodologia
- Comparacao estrutural entre o app Docker atual e o legado funcional parcial disponivel em `appPonto/`.
- Cruzamento de referencias de assets em `app/templates/` com a existencia real em `public/`.
- Comparacao de conteudo dos arquivos compartilhados entre `public/` e `appPonto/public/`.
- Validacao adicional dos fluxos ja afetados: menu principal, editar lead e editar colaborador.

## Escopo Comparado
- Docker atual:
  - `app/templates/`
  - `public/assets/js/global/`
  - `public/assets/js/local/`
  - `public/assets/css/`
  - `public/assets/img/`
- Legado funcional parcial:
  - `appPonto/app/templates/`
  - `appPonto/public/assets/js/global/`
  - `appPonto/public/assets/js/local/`
  - `appPonto/public/assets/css/`
  - `appPonto/public/assets/img/`

## Observacao Importante
`appPonto/` nao e uma copia completa do mesmo app principal.

Evidencias:
- o app atual tem dezenas de modulos em `app/templates/` como `lead`, `colaborador`, `financeiro`, `compra`, `usuario`
- `appPonto/app/templates/` so contem `theme/`, `partials/` e `area_colaborador/`
- contagem de JS locais:
  - Docker atual: 130 arquivos em `public/assets/js/local/`
  - `appPonto`: 1 arquivo em `appPonto/public/assets/js/local/`
- contagem de JS globais:
  - Docker atual: 4 arquivos em `public/assets/js/global/`
  - `appPonto`: 5 arquivos em `appPonto/public/assets/js/global/`

Conclusao: `appPonto/` serve como referencia util para `theme/`, `area_colaborador/` e JS globais, mas nao cobre todos os modulos do app principal. Quando um asset esta faltando no Docker e tambem nao aparece em `appPonto/`, isso indica que o pacote restaurado atual esta incompleto e nao que o fluxo deveria ser reescrito.

## Estrutura
### Diferencas de diretorio
- O app Docker atual possui arvore de templates muito maior que `appPonto/`.
- `appPonto/app/templates/` nao contem `lead/`, `colaborador/`, `financeiro/`, `usuario/`, `compra/` e varias outras areas do app principal.
- `public/assets/css/`, `public/assets/img/` e `public/assets/plugins/` estao estruturalmente alinhados com `appPonto/`.
- Em `public/assets/js/global/`, `appPonto/` possui um arquivo extra: `break.js`.

## Arquivos Compartilhados Comparados
### Identicos
- `public/assets/js/global/bestflow.js`
- `public/assets/css/global/styles.css`
- `public/assets/css/local/authentication.css`
- `public/assets/css/local/chat.css`
- `public/assets/css/local/occurrence.css`
- `public/assets/css/local/queue-service.css`
- `public/assets/css/local/receptivo.css`
- imagens compartilhadas como `logo/logo-white.png`, `square.png`, `passos.png`, `novoRegistro.png`, `registroPonto.png`
- `app/templates/theme/404.twig`
- `app/templates/theme/base.cliente.twig`

### Divergentes
- `public/assets/js/global/utils.js`
  - Docker: 82 linhas
  - `appPonto`: 798 linhas
  - criticidade: critica
  - impacto: helpers globais reduzidos em relacao ao legado
- `public/assets/js/global/company.js`
  - Docker: 13 linhas
  - `appPonto`: 426 linhas
  - criticidade: media
  - impacto: fluxo de login/base compartilhada nao esta fiel ao legado
- `public/assets/js/global/oauth.js`
  - Docker: 59 linhas
  - `appPonto`: 99 linhas
  - criticidade: media
  - impacto: login e troca de senha divergem do legado
- `app/templates/theme/base.login.twig`
  - no Docker faltam includes CDN de jQuery e `jquery.mask` que existem em `appPonto`
  - criticidade: media
- `app/templates/theme/menu.twig`
  - logos e itens de navegacao diferem do legado parcial
  - criticidade: media
- `app/templates/theme/base.twig`
  - divergencia minima, essencialmente irrelevante para funcionalidade observada
  - criticidade: baixa

## Bloco A - Arquivos Faltantes no Docker e Existentes no Legado Parcial
- `public/assets/js/global/break.js`
  - existe em `appPonto/public/assets/js/global/break.js`
  - nao existe em `public/assets/js/global/break.js`
  - criticidade: baixa no estado atual
  - observacao: nao encontrei referencia ativa a ele nos templates auditados

## Bloco B - Arquivos Existentes nos Dois Lados, Mas Divergentes
- `public/assets/js/global/utils.js`
- `public/assets/js/global/company.js`
- `public/assets/js/global/oauth.js`
- `app/templates/theme/base.login.twig`
- `app/templates/theme/menu.twig`
- `app/templates/theme/base.twig`

## Bloco C - Referencias Quebradas em Templates/Views

### Referencia Twig quebrada
- `structure/oauth.twig`
  - usado em `app/templates/oauth/login.twig`
  - nao existe em `app/templates/structure/`
  - criticidade: critica

### Assets publicos referenciados e inexistentes no Docker
Total de referencias unicas ausentes: 76

#### Criticos
- `/assets/js/local/lead_det_form.js`
  - usado em `app/templates/lead/lead_main_form.twig`
  - impacto: formulario de Lead abre sem preencher os dados
- `/assets/js/local/colaborador_cad_form.js`
  - usado em `app/templates/colaborador/colaborador_cad_form.twig`
  - impacto: formulario de Colaborador abre sem script de carga da edicao
- `/assets/js/local/colaborador_controle_escala_cad_form.js`
  - usado em `app/templates/colaborador/colaborador_cad_form.twig`
  - impacto: aba/fluxo de escala incompleto
- `/assets/js/local/colaborador_documento_res.js`
  - usado em `app/templates/colaborador/colaborador_cad_form.twig` e `app/templates/colaborador/painel.twig`
  - impacto: documentacao do colaborador sem script
- `/assets/js/local/agenda_res_form.js`
  - usado em `app/templates/lead/lead_main_form.twig`
  - impacto: aba Agenda do Lead sem script
- `/assets/js/local/agenda_cad_form.js`
  - usado em `app/templates/lead/lead_main_form.twig`, `app/templates/lead/lead_res.twig` e agenda/calendario
  - impacto: formularios de agenda quebrados
- `/assets/js/local/comercial_cad_form.js`
  - usado em `app/templates/lead/lead_main_form.twig`
  - impacto: aba Comercial do Lead incompleta
- `/assets/js/local/documento_res_form.js`
  - usado em `app/templates/lead/lead_main_form.twig`
  - impacto: aba Documento(s) do Lead sem script
- `/assets/js/local/area_colaborador.js`
  - usado em `app/templates/area_colaborador/receptivo.twig` e partials
  - impacto: area do colaborador restaurada de forma incompleta

#### Medios
- `/assets/css/pages/settings-selectables.css`
- `/assets/img/favicon.png`
- `/assets/img/bg/error.png`
- `/assets/js/local/agenda_escala_cad_form.js`
- `/assets/js/local/auditoria_categoria_tipos_cad_form.js`
- `/assets/js/local/beneficio_cad_form.js`
- `/assets/js/local/beneficio_res_form.js`
- `/assets/js/local/calendario_escala.js`
- `/assets/js/local/categoria_produto_cad_form.js`
- `/assets/js/local/colaborador_cad_form_cliente.js`
- `/assets/js/local/colaborador_cliente_res.js`
- `/assets/js/local/colaborador_formulario_contrato_res_form.js`
- `/assets/js/local/colaborador_painel.js`
- `/assets/js/local/compra_cad_form.js`
- `/assets/js/local/compra_res_form.js`
- `/assets/js/local/compras_solicitacao_orcamentos_cad_form.js`
- `/assets/js/local/conciliacao_bancaria_res_form.js`
- `/assets/js/local/controle_nfse_cad_form.js`
- `/assets/js/local/curso_cad_form.js`
- `/assets/js/local/discriminacao_servicos_res_form.js`
- `/assets/js/local/documento_cliente_form.js`
- `/assets/js/local/entrada_estoque_cad_form.js`
- `/assets/js/local/entrada_estoque_res_form.js`
- `/assets/js/local/faturamento_adicionar_contratos_form.js`
- `/assets/js/local/faturamento_item_res_form.js`
- `/assets/js/local/faturamento_res_form.js`
- `/assets/js/local/financeiro_contas_pagar_receber_res_form.js`
- `/assets/js/local/financeiro_documento_cad_form.js`
- `/assets/js/local/financeiro_documento_historico_res_form.js`
- `/assets/js/local/financeiro_grid_extrato_mes.js`
- `/assets/js/local/financeiro_grid_lancamento.js`
- `/assets/js/local/financeiro_grid_receita.js`
- `/assets/js/local/fornecedor_cad_form.js`
- `/assets/js/local/impressao_material.js`
- `/assets/js/local/inc_apontamento_folga_cad_form.js`
- `/assets/js/local/inc_ponto_folha_regerar_form.js`
- `/assets/js/local/modulo_cad.js`
- `/assets/js/local/modulo_res.js`
- `/assets/js/local/nfe_add_servico_cad_form.js`
- `/assets/js/local/ocorrencia_operacional_res_form.js`
- `/assets/js/local/pesqRelContasPagarPeriodo.js`
- `/assets/js/local/pesq_acompanhamento_banco_horas.js`
- `/assets/js/local/plano_contas_cad_form.js`
- `/assets/js/local/ponto_folha_res_form.js`
- `/assets/js/local/processo_default_cad_form.js`
- `/assets/js/local/produto_add.js`
- `/assets/js/local/rel_acompanhamento_ferias_res.js`
- `/assets/js/local/rel_acompanhamento_ponto_analitico_res.js`
- `/assets/js/local/rel_acompanhamento_ponto_sintetico_pesq.js`
- `/assets/js/local/rel_colaborador_apontamento_res.js`
- `/assets/js/local/rel_colaborador_exame_curso_pesq.js`
- `/assets/js/local/rel_colaboradores_curso_cad_form.js`
- `/assets/js/local/rel_compra_movimentacao_lead_res.js`
- `/assets/js/local/rel_contrato_res.js`
- `/assets/js/local/rel_controle_compra_pesq.js`
- `/assets/js/local/rel_dados_colaborador_pesq.js`
- `/assets/js/local/rel_dados_colaborador_res.js`
- `/assets/js/local/rel_estoque_sintetico_res.js`
- `/assets/js/local/rel_fluxo_caixa_pesq.js`
- `/assets/js/local/rel_fluxo_caixa_res.js`
- `/assets/js/local/rel_receita_posto_trabalho_res.js`
- `/assets/js/local/rel_titulo_plano_contas_res.js`
- `/assets/js/local/res_acompanhamento_banco_horas.js`
- `/assets/js/local/res_acompanhamento_supervisor.js`
- `/assets/js/local/solicitacao_acesso_app_res.js`
- `/assets/js/local/supervisao_auditoria_lead_cad_form.js`

#### Baixos
- `/assets/js/local/afd_receptivo.js`

## Fluxos Ja Afetados
### Menu principal
- causa anterior confirmada: `public/assets/js/global/bestflow.js` estava ausente
- estado atual:
  - `bestflow.js` foi restaurado e esta identico ao legado parcial
  - ainda existem divergencias em `utils.js`, `company.js`, `oauth.js` e `theme/menu.twig`

### Editar Lead
Arquivos participantes:
- `app/templates/lead/lead_main_form.twig`
- `app/templates/lead/lead_det_form.twig`
- `app/src/controllers/LeadController.php`
- `app/src/models/Lead.php`
- assets referenciados:
  - `lead_main_form.js` existe
  - `lead_det_form.js` nao existe
  - `agenda_res_form.js` nao existe
  - `agenda_cad_form.js` nao existe
  - `comercial_res_form.js` existe
  - `comercial_cad_form.js` nao existe
  - `documento_res_form.js` nao existe
  - `documento_cad_form.js` existe

Diagnostico:
- o backend recebe `pk` e `listarPk` retorna o registro
- o form vem vazio porque o carregamento da edicao e client-side
- parte do conjunto de JS esperado na tela nao foi restaurado

### Editar Colaborador
Arquivos participantes:
- `app/templates/colaborador/colaborador_cad_form.twig`
- `app/src/controllers/ColaboradorController.php`
- `app/src/models/Colaborador.php`
- assets referenciados:
  - `colaborador_cad_form.js` nao existe
  - `colaborador_qualificacao_res_form.js` existe
  - `colaborador_exames_cursos_res.js` existe
  - `colaborador_beneficios_res.js` existe
  - `colaborador_documento_res.js` nao existe
  - `colaborador_controle_escala_res_form.js` existe
  - `colaborador_controle_escala_cad_form.js` nao existe

Diagnostico:
- a rota abre
- `listarPk` retorna dados quando o `pk` existe
- o template depende de JS client-side ausente para preencher o formulario e inicializar sub-fluxos

## Recomendacao de Ordem de Restauracao
1. Restaurar os assets criticos dos fluxos de edicao:
   - `lead_det_form.js`
   - `colaborador_cad_form.js`
   - `colaborador_controle_escala_cad_form.js`
   - `colaborador_documento_res.js`
   - `agenda_res_form.js`
   - `agenda_cad_form.js`
   - `comercial_cad_form.js`
   - `documento_res_form.js`
2. Restaurar as referencias internas quebradas:
   - `app/templates/structure/oauth.twig`
3. Alinhar os JS globais divergentes com o legado parcial:
   - `utils.js`
   - `company.js`
   - `oauth.js`
4. Revisar os assets ausentes usados por relatorios, financeiro e agenda, porque a auditoria mostrou 76 referencias unicas quebradas.
5. Revalidar navegacao, edicao e login apos restauracao dos arquivos reais do legado, sem reescrever logica.

## Resumo Executivo
- A restauracao atual esta incompleta no frontend.
- O backend e o banco ja respondem corretamente em varios fluxos testados.
- O principal problema nao e regra de negocio: e ausencia de arquivos e divergencia de assets globais.
- O comparador `appPonto/` confirma integridade de varios arquivos base, mas nao cobre todos os modulos do app principal.
- No estado atual, existem:
  - 1 referencia Twig interna quebrada
  - 76 referencias unicas a assets publicos inexistentes no Docker
  - 1 arquivo presente no legado parcial e ausente no Docker (`break.js`)
  - 6 arquivos compartilhados com divergencia de conteudo relevante, concentrados em `theme/` e `js/global/`
