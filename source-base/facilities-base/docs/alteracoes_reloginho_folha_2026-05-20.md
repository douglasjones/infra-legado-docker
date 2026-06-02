# Alteracoes no Reloginho e Folha de Ponto - 2026-05-20

Este documento registra as alteracoes feitas no cliente `vistoriza_at` para servir como referencia caso seja necessario aplicar o mesmo conjunto de ajustes em outro projeto/cliente legado.

## Contexto

As alteracoes foram feitas principalmente nos modulos:

- Colaboradores > acao do reloginho / acompanhamento de ponto.
- RH > Folha de ponto > edicao de registros.
- RH > Folha de ponto > impressao individual e imprimir todas.

Objetivo geral:

- Ajustar o periodo do reloginho.
- Corrigir criacao/uso da folha conforme periodo real.
- Preservar folhas antigas no modelo 01 ao ultimo dia do mes.
- Melhorar edicao/apontamentos da folha.
- Melhorar layout e usabilidade do reloginho.
- Corrigir carregamentos e impressao.

## Arquivos principais alterados

### JavaScript

- `app/public/assets/js/local/colaborador_res_form.js`
- `app/public/assets/js/local/ponto_folha_registros_cad_form.js`
- `app/public/assets/js/local/ponto_folha_registros_res_form.js`
- `app/public/assets/js/local/ponto_folha_print_form.js`

### Templates Twig

- `app/app/templates/partials/inc_consulta_folha_ponto_colaborador.twig`
- `app/app/templates/colaborador/colaborador_res_form.twig`
- `app/app/templates/conta/colaborador/colaborador_res_form.twig`
- `app/app/templates/ponto_folha/ponto_folha_registros_cad_form.twig`
- `app/app/templates/ocorrencia/ponto_folha/ponto_folha_registros_cad_form.twig`
- `app/app/templates/ponto_folha/ponto_folha_print_form.twig`
- `app/app/templates/ocorrencia/ponto_folha/ponto_folha_print_form.twig`

### Backend PHP

- `app/src/models/PontoFolha.php`

## Regras de periodo do reloginho

Foi implementada a regra de periodo de afericao:

- A partir de maio/2026, o periodo deve iniciar no dia 21 do mes anterior e terminar no dia que completa a quantidade de dias do mes vigente.
- Exemplo para maio/2026:
  - Inicio: `21/04/2026`
  - Fim: `21/05/2026`
- Para meses anteriores a maio/2026, continua permitido o modelo antigo:
  - Inicio no dia 01 do mes.
  - Fim no ultimo dia do mes.

Funcoes envolvidas em `colaborador_res_form.js`:

- `calcularPeriodoReloginho(dataBase)`
- `calcularPeriodoPermitidoReloginho(dataBase)`
- `validarPeriodoUmMes(dtIni, dtFim)`
- `mensagemPeriodoPermitidoReloginho(dtFim)`
- `validarPeriodoReloginho()`
- `aplicarPeriodoPadraoReloginho()`

Comportamento:

- Ao abrir o reloginho, os campos `dt_ini_reloginho` e `dt_fim_reloginho` sao preenchidos automaticamente conforme a regra.
- Se o usuario alterar as datas, a validacao usa o mes da data final como mes vigente.
- Se o periodo for vazio, menor ou maior do que permitido, o sistema alerta e nao executa `Pesquisar Ponto`.

## Limpeza do modal do reloginho

Foi adicionada limpeza explicita ao abrir o modal do reloginho, para evitar reaproveitamento de estado anterior.

Funcao criada:

- `limparModalReloginho()`

Ela limpa:

- Grid de ponto.
- Mensagem de folha finalizada.
- PK da folha.
- Status da folha.
- Agenda, lead e colaborador do modal.
- Datas do periodo, antes de reaplicar o periodo padrao.
- Turno e periodo de trabalho.
- Texto do colaborador.
- Estado visual do botao de imprimir.
- Scroll do modal.

Importante:

- Depois da limpeza, deve sempre chamar `aplicarPeriodoPadraoReloginho()` para restaurar as datas do periodo.

## Pesquisar Ponto e criacao/atualizacao de folha

Foi analisado e ajustado o fluxo esperado:

- Ao clicar em `Pesquisar Ponto`, o sistema deve verificar se existe uma `ponto_folha` para o periodo real informado e para o posto de trabalho.
- Caso nao exista, deve criar a folha.
- Deve criar/vincular o colaborador em `ponto_folha_colaborador`.
- Deve criar/atualizar os registros em `ponto_folha_registros`.
- Registros validados nao devem ser sobrescritos.

Ponto de atencao:

- Folhas antigas no modelo `01/MM/AAAA` ate ultimo dia do mes nao podem ser alteradas pela regra nova.
- Folhas novas no modelo dia 21 devem ser agrupadas/listadas pelo mes da data final.

## Listagem da folha por mes

Foi ajustada a listagem para nao mudar a estrutura geral do modulo.

Regra aplicada:

- Se a folha foi gerada no modelo novo, iniciando no dia 21, ela deve aparecer no mes da data final.
- As folhas antigas continuam aparecendo conforme o modelo anterior.

Arquivo envolvido:

- `ponto_folha_registros_res_form.js`

## Ordem dos registros na edicao da folha

Problema:

- Em folhas no novo periodo, a tela de edicao exibia datas fora da ordem esperada.

Ajuste:

- Para folhas no novo formato, os registros devem ser ordenados corretamente conforme o periodo real.
- Folhas antigas nao devem ser afetadas.

## Edicao da folha: apontamentos

Foram aplicadas duas etapas de ajuste:

### Etapa 1 - Mesmas opcoes do reloginho

Na edicao da folha, o combo de apontamento passou a usar as mesmas opcoes do reloginho.

Foi preservada a compatibilidade com folhas antigas:

- O campo/situacao existente continua sendo exibido.
- O combo nao assume automaticamente uma referencia antiga quando nao existe apontamento real salvo.
- Isso evita perda de referencia em dados antigos.

Funcoes auxiliares em `ponto_folha_registros_cad_form.js`:

- `textoSituacaoApontamentoFolha(tipo)`
- `tipoRegistroFolhaPorSituacao(situacao, tipoApontamento)`
- `montarOptionsApontamentoFolha(tipoSelecionado)`
- `marcarApontamentoAlterado(row)`
- `aplicarBloqueioCamposApontamentoFolha(row, limpar)`
- `estiloSituacaoFolha(situacao)`

### Etapa 2 - Salvar apontamentos em lote

Na folha, foi permitido alterar varios dias de apontamento e salvar tudo no botao superior.

Backend em `PontoFolha.php`:

- `desabilitarApontamentosAtivosDia($colaborador_pk, $leads_pk, $dt_apontamento)`
- `salvarApontamentoFolha($dadosRegistro)`
- `alterarRegistrosFolhaPonto()` passou a chamar `salvarApontamentoFolha()` por linha alterada.

## Bloqueio de campos na edicao da folha

Regras aplicadas:

- Se o registro estiver marcado como `Validado`, nao deve permitir alterar campos de ponto/horas nem o apontamento.
- Se o apontamento selecionado nao exige horario, os campos de ponto/horas ficam bloqueados.
- `Falta`, `Folga`, `Ferias`, `Afastamento` e outros apontamentos sem horario limpam/bloqueiam horarios quando selecionados.
- Apenas apontamentos que exigem horario liberam campos de ponto.

Tipos que permitem preenchimento de horario:

- `1` - Ponto/Expediente
- `33` - Declaracao de horas abonar
- `36` - Audiencia
- `37` - Atestado de horas

## Cor rosa para Falta

Foi aplicada cor rosa para destacar `Falta`:

- No reloginho.
- Na edicao da folha.
- Quando a falta ja vem salva.
- Quando a falta e selecionada no combo.

Funcoes/estilos:

- `estiloSituacaoReloginho(...)`
- `estiloSituacaoFolha(situacao)`

Cor usada:

- `#f8c8dc`

## Folha finalizada na edicao da folha

Na tela de edicao da folha:

- Se `ic_folha_finalizada = 1`, a tela deve ficar apenas para consulta.
- Deve aparecer somente o botao `Voltar`.
- Deve ocultar:
  - `Salvar Folha Completa`
  - label `FOLHA FINALIZADA`
  - checkbox de finalizacao.

Funcao envolvida:

- `configurarAcoesFolhaFinalizada(finalizada)`

Arquivo:

- `ponto_folha_registros_cad_form.js`

## Loader na edicao da folha

Foi adicionado loader ao entrar na tela de edicao da folha.

Comportamento final:

- Usa o loader padrao simples do sistema:
  - `utilsJS.loading("Carregando as informações !")`
  - `utilsJS.loaded()`
- Foi testado um loader com o `G` da Gepros, mas removido por decisao visual.

Importante:

- O loader nao altera fluxo, consulta ou regra.
- Apenas indica carregamento durante o atraso/processamento ja existente.

## Impressao da folha

### Impressao individual

Foi analisado o fluxo de impressao a partir do reloginho.

Ponto importante:

- Nao deve criar protecoes novas sem validacao previa do processo.
- O fluxo de imprimir deve respeitar a folha existente/finalizada conforme regra do sistema.

### Imprimir Todas

Problemas encontrados:

- O `Imprimir Todas` consultava folha por folha e redesenhava o HTML acumulado a cada colaborador.
- Isso aumentava a demora conforme a quantidade de folhas.
- Alguns campos de resultado nao apareciam corretamente na impressao.

Ajustes:

- O HTML da impressao passou a ser inserido uma unica vez ao final do processamento.
- Corrigida exibicao dos totais:
  - `H.T`
  - `H.E`
  - `H.F`
  - `H.E1`
  - `H.E2`
  - `A.N`
- Corrigida exibicao de valores por linha:
  - `H.E1`
  - `H.E2`
  - `A.N`

Arquivo:

- `ponto_folha_print_form.js`

## Layout do reloginho

Arquivo principal:

- `app/app/templates/partials/inc_consulta_folha_ponto_colaborador.twig`

Ajustes aplicados:

- Botao `Folha Finalizada` ficou verde preenchido.
- Botao `Imprimir Folha` ficou amarelo preenchido.
- Botao `Fechar` ficou vermelho preenchido.
- Area superior reorganizada em 3 colunas:
  - Coluna 1: dados do colaborador, periodo, turno e periodo de trabalho.
  - Coluna 2: legenda centralizada.
  - Coluna 3: reservada para avisos, como folha finalizada.
- Botao `Pesquisar Ponto` ficou abaixo das 3 colunas, centralizado.
- Legenda ficou vertical, sutil e limpa.
- Fonte dos dados superiores ficou menor, igual ao estilo da legenda.
- Cabecalho da tabela ficou preto, maior e em negrito.
- Conteudo da tabela ficou preto, menor e sem negrito.

Classes CSS adicionadas no partial:

- `.reloginho-header-actions`
- `.reloginho-tools`
- `.reloginho-legenda`
- `.reloginho-legenda-label`
- `.reloginho-legenda-chip`
- `.reloginho-legenda-swatch`
- `.reloginho-action-icon`
- `.reloginho-action-save`
- `.reloginho-action-delete`
- `.reloginho-action-history`
- `.reloginho-action-image`
- `.reloginho-pesquisar-row`
- `.reloginho-dados-col`
- `.reloginho-finalizada-aviso`

## Icones da coluna Acao do reloginho

Foram padronizados os icones da coluna `Acao`:

- Salvar apontamento:
  - `fa fa-save`
- Excluir apontamento:
  - `bi bi-trash3-fill`
- Historico de ponto:
  - `bi bi-clock-history`
- Ver imagem do ponto:
  - `bi bi-image`

Tambem foram adicionados `title` nos icones.

## Mensagem de folha finalizada no reloginho

Antes:

- Mensagem grande e centralizada acima da tabela:
  - `Está folha já está finalizada e não pode ser alterada!`

Depois:

- Mensagem menor na terceira coluna do layout superior.
- Fonte segue o padrao do modal.
- Classe:
  - `.reloginho-finalizada-aviso`

Texto atual:

- `Esta folha já está finalizada e não pode ser alterada.`

## Botao Folha Finalizada no reloginho

Regra aplicada:

- Ao pesquisar/carregar o ponto, se a folha estiver finalizada, o botao `Folha Finalizada` deve ficar oculto.
- Ao abrir novamente ou carregar folha nao finalizada, o botao volta a aparecer.

Implementacao:

- Botao recebeu classe:
  - `.finalizar_folha`
- Quando `#ic_status_ponto_folha_pk == 1`:
  - `$(".finalizar_folha").hide().prop("disabled", true);`
- Caso contrario:
  - `$(".finalizar_folha").show().prop("disabled", false);`

## Downloads de documentos do colaborador

Foi corrigido o processo de download de documentos do colaborador:

- Ao anexar um `.docx`, o download nao deve transformar/baixar como PDF.
- O arquivo deve baixar com extensao e conteudo original.
- O nome ideal do download deve ser o nome original do arquivo.

Ponto de atencao para replicacao:

- Verificar controller/rota de download.
- Verificar `Content-Type`.
- Verificar `Content-Disposition`.
- Usar o nome original salvo no cadastro quando disponivel.

## Performance de colaborador

Foi analisada a demora no carregamento/edicao de colaborador.

Ponto importante:

- A consulta externa faz parte do processo do sistema.
- Nao alterar fluxo ou processo sem confirmacao.
- O que foi solicitado foi identificar se a demora vinha do sistema ou da consulta externa.
- Alteracoes que mudavam o fluxo da pesquisa de colaborador foram revertidas conforme orientacao.

## Banco de dados e importacao

Foi identificado problema inicial de login causado por banco nao importado:

- Mensagem:
  - `Banco de dados ainda nao importado: tabela usuarios nao encontrada`

Validacoes feitas no processo:

- Verificar se o dump continha a tabela `usuarios`.
- Verificar logs/estado da importacao.
- Importacao do dump grande exigia acompanhamento por logs/container.

Ponto de atencao:

- Nao assumir que erro de login e senha/autenticacao quando o banco ainda nao tem tabela `usuarios`.

## Contrato e escala

Foram analisados erros:

- Modulo contrato no cadastro:
  - Erro de requisicao/parsing.
- Modulo escala na edicao:
  - Erro de integridade `tipo_escala_pk cannot be null`.
- Cadastro de escala:
  - Ao trocar colaborador, alerta de escala existente deve ser recalculado para o novo colaborador.

Ponto de atencao:

- Essas analises devem ser revisitadas antes de replicar alteracoes, pois dependem do estado atual do banco e do fluxo de cada cliente.

## Cache/versionamento dos JS

Foram atualizados parametros `v=` em templates para forcar recarregamento do navegador.

Versoes finais relevantes:

- `colaborador_res_form.js?v=29`
- `ponto_folha_registros_cad_form.js?v=21`
- `ponto_folha_print_form.js?v=17`

Ao replicar em outro projeto:

- Atualizar os `v=` correspondentes.
- Limpar cache do navegador se necessario.

## Historico do reloginho

Foi ajustada a tela de historico por dia no reloginho:

- O icone de historico voltou a aparecer em todas as linhas, como estava antes.
- Nao foi mantida a regra de esconder/desabilitar o icone por falta de historico.
- `listarModalPonto` passou a retornar JSON valido vazio quando nao houver dados ou escala para o dia.
- O DataTables do historico passou a tratar resposta vazia/invalida como lista vazia.
- Isso evita o alerta tecnico de `Invalid JSON response` ao abrir o modal sem historico.

Tambem foi padronizado o layout dos modais acionados pelos icones do reloginho:

- Modal de historico (`janela_historico`) com fonte, tamanho e cor no mesmo padrao do reloginho.
- Modal de ponto do dia/camera (`janela_ponto_diario`) com o mesmo padrao visual.
- Tabelas internas usando fonte preta, cabecalho menor em negrito e corpo menor sem negrito.

Arquivos alterados:

- `app/app/src/models/PontoFolha.php`
- `app/public/assets/js/local/colaborador_res_form.js`
- `app/app/templates/partials/inc_consulta_folha_ponto_colaborador.twig`
- `app/app/templates/colaborador/colaborador_res_form.twig`
- `app/app/templates/conta/colaborador/colaborador_res_form.twig`

## Validacoes executadas

Foram executadas validacoes de sintaxe:

- `node --check app/public/assets/js/local/colaborador_res_form.js`
- `node --check app/public/assets/js/local/ponto_folha_registros_cad_form.js`
- `node --check app/public/assets/js/local/ponto_folha_print_form.js`
- `php -l /var/www/html/app/src/models/PontoFolha.php` dentro do container PHP.

Todas as validacoes citadas passaram sem erro no momento em que foram executadas.

## Relatorio de faltas

Foi adicionado o botao `Exportar Excel` no relatorio `Relatorio Acompanhamento Falta`.

Arquivos alterados:

- `app/public/assets/js/local/res_acompanhamento_falta.js`
- `app/public/assets/js/local/pesq_acompanhamento_falta.js`
- `app/app/templates/relatorio/rh/resAcompanhamentoFalta.twig`
- `app/app/templates/relatorio/rh/pesqAcompanhamentoFalta.twig`
- `app/app/src/models/AgendaColaboradorApontamento.php`

Comportamento:

- O botao fica junto ao `Exportar PDF`, usando o mesmo grupo de botoes do DataTables.
- A exportacao gera arquivo `.xls`.
- O arquivo inclui os dados de cabecalho/filtros do relatorio e a tabela exibida na tela.
- Cache atualizado para `res_acompanhamento_falta.js?v=15`.

Tambem foi ajustada a coluna `Definicao Apontamento`:

- A coluna deve seguir `agenda_colaborador_apontamento.tipo_apontamento_pk`, que e o campo usado pelo reloginho para exibir `Falta`, `Atestado`, `Abonada` e demais tipos.
- Nao deve usar `apontamento_falta.motivo_falta_pk` nesse relatorio, pois no fluxo do reloginho esse campo pode receber valor padrao e nao refletir a situacao exibida na tela.

Filtro de tipo de apontamento:

- O filtro deixou de ser `select`.
- Passou a ser grupo de checkboxes com os tipos que compoem faltas, igual ao reloginho.
- O filtro foi reposicionado para ser o ultimo campo, depois de `Ano`.
- O usuario pode selecionar nenhum, um ou varios tipos.
- Nenhum selecionado significa sem filtro por tipo, retornando todos os tipos do grupo.
- O backend passou a aceitar lista separada por virgula e filtrar com `IN`.
- Cache atualizado para `pesq_acompanhamento_falta.js?v=15`.

Validacoes executadas para este relatorio:

- `node --check app/public/assets/js/local/res_acompanhamento_falta.js`
- `node --check app/public/assets/js/local/pesq_acompanhamento_falta.js`
- `php -l /var/www/html/app/src/models/AgendaColaboradorApontamento.php` dentro do container PHP.

## Cuidados para aplicar em outro projeto

Antes de replicar:

1. Confirmar se o cliente usa o mesmo fluxo de reloginho e folha.
2. Confirmar se as tabelas e colunas existem com os mesmos nomes:
   - `ponto_folha`
   - `ponto_folha_colaborador`
   - `ponto_folha_registros`
   - `agenda_colaborador_apontamento`
3. Confirmar regra de periodo com o cliente.
4. Confirmar se folhas antigas devem permanecer no modelo 01 ao ultimo dia.
5. Confirmar se maio/2026 e o marco inicial da regra nova.
6. Nao alterar consulta externa/processos de colaborador sem confirmacao.
7. Testar com folha antiga e folha nova.
8. Testar folha finalizada e nao finalizada.
9. Testar apontamentos:
   - Falta
   - Folga
   - Ponto/Expediente
   - Atestado de horas
   - Declaracao de horas abonar
10. Testar impressao individual e imprimir todas.

## Checklist rapido de teste

- Abrir reloginho e verificar periodo preenchido.
- Clicar `Pesquisar Ponto` em periodo valido.
- Tentar periodo invalido e confirmar alerta.
- Verificar se folha nova aparece no mes da data final.
- Abrir edicao da folha nova e confirmar ordem das datas.
- Marcar `Falta` e salvar; confirmar cor rosa.
- Tentar editar linha validada; deve bloquear.
- Tentar preencher horarios em `Falta`; deve bloquear.
- Finalizar folha.
- Reabrir reloginho; botao `Folha Finalizada` deve sumir.
- Mensagem de folha finalizada deve aparecer na terceira coluna.
- Abrir edicao de folha finalizada; deve aparecer somente `Voltar`.
- Imprimir folha individual.
- Imprimir todas.
