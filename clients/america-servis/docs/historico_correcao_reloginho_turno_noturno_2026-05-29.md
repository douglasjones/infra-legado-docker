# Historico de Analise - Correcao do Reloginho em Turno Noturno

Data: 2026-05-29

Cliente: `america-servis`

Objetivo deste arquivo:
- registrar o problema funcional identificado no reloginho para turnos noturnos
- mapear os metodos e pontos do codigo que participam do erro
- deixar documentadas as correcoes necessarias antes da implementacao

## 1. Descricao do problema

Foi identificado deslocamento dos registros de ponto no reloginho para colaboradores com turno noturno.

Cenario observado:
- o expediente comeca em um dia, por exemplo `28/05/2026`, por volta de `21:43`
- as demais batidas acontecem na madrugada de `29/05/2026`
- o conjunto inteiro pertence operacionalmente ao turno iniciado em `28/05/2026`
- porem a tela do reloginho passa a exibir parte ou a totalidade desse conjunto na linha do dia `29/05/2026`

Conclusao funcional:
- o sistema esta classificando o ponto noturno pela data civil do timestamp
- o comportamento correto e classificar pela data de inicio da escala noturna

## 2. Regra correta esperada

Para turno noturno:
- a linha do reloginho deve ser ancorada em `dt_escala`
- se o turno cruza meia-noite, todas as batidas ate o encerramento da jornada devem permanecer vinculadas ao dia de inicio da escala

Exemplo correto:
- inicio do expediente em `28/05/2026 21:43`
- intervalo e saida em `29/05/2026 01:07`, `02:21`, `05:57`

Resultado esperado:
- todos esses registros devem compor a linha de `28/05/2026`
- a linha de `29/05/2026` so deve receber batidas do turno iniciado em `29/05/2026`

## 3. Causa raiz resumida

O problema nao e de cadastro do ponto pelo colaborador.

O problema esta na regra de agrupamento e consulta do reloginho:
- parte do fluxo usa janela noturna corretamente
- outras partes ainda usam dia civil, `DATE(dt_hora_ponto)` ou intervalos fechados `00:00:00` a `23:59:59`
- isso faz a madrugada ser empurrada para o dia seguinte, embora ela ainda pertença ao turno iniciado no dia anterior

## 4. Mapa tecnico do fluxo afetado

### 4.1. Entrada do reloginho

Arquivo:
- `app/app/src/controllers/PontoFolhaController.php`

Metodo:
- `listarConsultaPontoColaborador()`

Referencia:
- [PontoFolhaController.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/controllers/PontoFolhaController.php:423)

Papel no fluxo:
- recebe `dt_inicio`, `dt_fim`, `leads_pk`, `colaborador_pk` e `agenda_colaborador_pk`
- converte o periodo e delega para `PontoFolha->listarConsultaPontoColaborador(...)`

Observacao:
- o controller nao parece ser a origem do erro
- ele apenas abre o periodo consultado

### 4.2. Historico do reloginho por dia

Arquivo:
- `app/app/src/models/Ponto.php`

Metodo:
- `reloginhoHistoricoPonto($leads_pk,$colaborador_pk,$dt_ini,$dt_fim,$agenda_colaborador_padrao_pk)`

Referencia:
- [Ponto.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/Ponto.php:1189)

Papel no fluxo:
- identifica se o turno e noturno por meio de `listarTurnosPk(...)`
- escolhe entre `pegarPontoNormal(...)` e `pegarPontoNoturno(...)`
- monta o retorno visual do historico

Risco identificado:
- o retorno usa `DATE_FORMAT(pt.dt_hora_ponto, '%d/%m/%Y')` como `dt_rh_entratada`
- para turno noturno, isso pode refletir o dia civil do timestamp, nao o dia operacional da escala

### 4.3. Consulta normal de pontos

Arquivo:
- `app/app/src/models/Ponto.php`

Metodo:
- `pegarPontoNormal($dt_ini,$dt_fim,$colaborador_pk,$leads_pk)`

Referencia:
- [Ponto.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/Ponto.php:1962)

Trecho critico:
- filtra por:
  - `pt.dt_hora_ponto BETWEEN 'dt_escala 00:00:00' AND 'dt_escala 23:59:59'`

Leitura:
- esse metodo esta correto para turno normal
- nao deve ser reutilizado para a classificacao final de turno noturno

### 4.4. Consulta noturna de pontos

Arquivo:
- `app/app/src/models/Ponto.php`

Metodo:
- `pegarPontoNoturno($dt_ini,$dt_fim,$colaborador_pk,$leads_pk)`

Referencia:
- [Ponto.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/Ponto.php:2072)

Trecho relevante:
- monta janela de turno:
  - inicio no dia da escala
  - fim no dia seguinte
- hoje usa:
  - `pt.dt_hora_ponto BETWEEN 'dt_escala 16:00:00' AND 'dt_escala+1 10:00:00'`

Riscos identificados:
- a janela esta hardcoded
- a classificacao final ainda expõe `dt_rh_entratada` com base no proprio `dt_hora_ponto`
- isso ajuda a produzir o deslocamento visual para o dia seguinte

### 4.5. Consulta de pontos por dia na folha/reloginho

Arquivo:
- `app/app/src/models/PontoFolha.php`

Metodo:
- `listarDadosPonto($dt_escala,$colaboradores_pk,$agenda_colaborador_padrao_pk)`

Referencia:
- [PontoFolha.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/PontoFolha.php:3759)

Papel no fluxo:
- busca a escala do dia
- detecta se o turno e noturno
- escolhe entre:
  - `verificarPontoEscalaNormal(...)`
  - `verificarPontoEscalaNoturnaPorDiaFechamento(...)`

Importancia:
- este e um dos pontos mais provaveis de ajuste principal
- e daqui que a linha do dia precisa sair com o agrupamento correto

### 4.6. Consulta normal por dia da escala

Arquivo:
- `app/app/src/models/PontoFolha.php`

Metodo:
- `verificarPontoEscalaNormal($dt_escala, $colaboradores_pk, $agenda_colaborador_padrao_pk = "")`

Referencia:
- [PontoFolha.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/PontoFolha.php:3582)

Trechos criticos:
- subquery com `DATE(dt_hora_ponto) = :dt_escala`
- filtro final com `DATE(p.dt_hora_ponto) = :dt_escala`

Leitura:
- correto para turno normal
- inadequado para qualquer madrugada pertencente ao turno iniciado no dia anterior

### 4.7. Consulta noturna por dia da escala

Arquivo:
- `app/app/src/models/PontoFolha.php`

Metodo:
- `verificarPontoEscalaNoturna($dt_escala, $colaboradores_pk, $agenda_colaborador_padrao_pk = "")`

Referencia:
- [PontoFolha.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/PontoFolha.php:3634)

Trecho atual:
- entrada:
  - de `dt_escala 14:30:00` ate `dt_escala+1 02:00:00`
- demais batidas:
  - de `dt_escala+1 00:00:00` ate `dt_escala+1 10:30:00`

Leitura:
- esta mais alinhado ao conceito noturno
- mas continua usando faixas fixas e nao necessariamente os horarios reais da escala do colaborador

### 4.8. Consulta noturna usada no fechamento da linha do dia

Arquivo:
- `app/app/src/models/PontoFolha.php`

Metodo:
- `verificarPontoEscalaNoturnaPorDiaFechamento($dt_escala, $colaboradores_pk, $agenda_colaborador_padrao_pk = "")`

Referencia:
- [PontoFolha.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/PontoFolha.php:3697)

Trecho atual:
- considera:
  - entrada do dia anterior a `02:00` do dia da linha
  - demais batidas de `00:00` ate `10:30` do dia da linha

Leitura:
- este metodo esta conceitualmente no lugar certo para resolver o problema
- mas precisa virar a referencia oficial e consistente da linha operacional noturna

## 5. Pontos de risco adicionais no codigo

Abaixo estao trechos que merecem revisao porque usam dia civil e podem manter o deslocamento:

### 5.1. Comparacoes diretas por data do timestamp

Arquivo:
- `app/app/src/models/Ponto.php`

Trecho:
- `date_format(dt_hora_ponto, '%Y/%m/%d') = date_format('".$dt_escala."', '%Y/%m/%d')`

Referencia:
- [Ponto.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/Ponto.php:193)

Risco:
- ignora a data operacional do turno noturno

### 5.2. Faixas fixas do dia civil

Arquivos:
- `app/app/src/models/Ponto.php`

Exemplos:
- [Ponto.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/Ponto.php:2042)
- [Ponto.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/Ponto.php:1520)

Padrao de risco:
- `00:00:00` ate `23:59:59`

Risco:
- qualquer rotina auxiliar que ainda use esse criterio em turno noturno pode reintroduzir o bug

### 5.3. Uso misto de janela noturna com `DATE(dt_hora_ponto)`

Arquivo:
- `app/app/src/models/Ponto.php`

Referencias:
- [Ponto.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/Ponto.php:2428)
- [Ponto.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/Ponto.php:2435)

Risco:
- o sistema monta uma janela especial, mas depois volta a fixar em `DATE(dt_hora_ponto)` do dia civil
- isso pode deslocar a primeira ou a ultima batida

## 6. Correcoes necessarias

### 6.1. Adotar a data operacional do turno noturno

Necessario:
- criar ou padronizar o conceito de `data_operacional`
- para turno noturno, `data_operacional` deve ser o dia de inicio da escala

Resultado esperado:
- as batidas da madrugada continuam pertencendo ao dia anterior quando fizerem parte da mesma jornada

### 6.2. Parar de usar `DATE(dt_hora_ponto)` para turno noturno

Necessario:
- remover dependencias de `DATE(dt_hora_ponto) = :dt_escala` nas rotinas noturnas
- substituir por filtros em janela de jornada

Aplicacao direta:
- revisar `verificarPontoEscalaNormal(...)` para garantir que so seja usado em turno normal
- consolidar `verificarPontoEscalaNoturna(...)` e `verificarPontoEscalaNoturnaPorDiaFechamento(...)` como referencia unica do noturno

### 6.3. Ancorar a linha do reloginho em `dt_escala`

Necessario:
- a linha exibida no reloginho precisa ser a data da escala, nao a data civil de cada batida
- o campo visual de data nao deve depender de `DATE_FORMAT(pt.dt_hora_ponto, ...)` para turno noturno

### 6.4. Parar de usar janelas fixas hardcoded quando houver horario real da escala

Hoje existem faixas fixas como:
- `14:30`
- `02:00`
- `10:30`
- `16:00`

Necessario:
- usar os horarios reais da escala do colaborador, obtidos de:
  - `pegarHorarioDeEntradaPorDataDiaSemana(...)`
- montar janela dinamica a partir de:
  - inicio real do expediente no dia `dt_escala`
  - termino real do expediente no dia seguinte, quando cruza meia-noite

### 6.5. Garantir consistencia entre reloginho, fechamento e historico

Necessario:
- o mesmo criterio de turno noturno precisa valer para:
  - consulta do reloginho
  - historico do ponto
  - folha de ponto
  - fechamento/regeneracao

Se apenas um metodo for corrigido:
- a grade pode mostrar certo
- mas a regeneracao, impressao ou fechamento podem continuar errados

## 7. Ordem recomendada para a futura implementacao

1. Ajustar `PontoFolha::listarDadosPonto(...)` para centralizar a regra operacional noturna.
2. Ajustar `PontoFolha::verificarPontoEscalaNoturnaPorDiaFechamento(...)` para usar janela dinamica da escala.
3. Garantir que `PontoFolha::verificarPontoEscalaNormal(...)` nunca seja usado para montar linha noturna.
4. Ajustar `Ponto::reloginhoHistoricoPonto(...)` para exibir a data da escala, e nao a data civil da batida, quando o turno for noturno.
5. Revisar consultas auxiliares em `Ponto.php` que ainda usam `DATE(dt_hora_ponto)` ou `00:00:00` a `23:59:59` em contextos que tambem atendem turno noturno.
6. Validar com caso real:
   - entrada em `28/05 21:43`
   - demais registros em `29/05 01:07`, `02:21`, `05:57`
   - todos aparecendo na linha `28/05`

## 8. Conclusao

O caso foi entendido como erro de regra de negocio no reloginho para turnos noturnos.

O sistema hoje mistura dois modelos:
- dia civil do timestamp
- dia operacional da escala

Para resolver de forma definitiva:
- o turno noturno precisa ser tratado sempre por `dt_escala`
- a madrugada precisa continuar vinculada ao dia anterior quando a jornada tiver iniciado naquele dia
- a mesma regra deve valer em consulta, historico e fechamento

## 9. Plano enxuto de correcao por arquivo

### 9.1. Arquivo-chave

Arquivo:
- `app/app/src/models/PontoFolha.php`

Direcao da correcao:
- centralizar aqui a regra oficial do turno noturno
- fazer o reloginho usar `dt_escala` como ancora da linha
- evitar que a madrugada seja reclassificada pelo dia civil do timestamp

Ajustes previstos:
- em `listarDadosPonto(...)`, manter a decisao do turno noturno concentrada no fluxo de fechamento por dia
- em `verificarPontoEscalaNoturnaPorDiaFechamento(...)`, substituir janelas fixas por janela dinamica baseada na escala real
- garantir que a consulta normal nao reassuma controle quando a jornada cruza meia-noite

### 9.2. Arquivo de apoio

Arquivo:
- `app/app/src/models/Ponto.php`

Direcao da correcao:
- alinhar o historico do reloginho com a mesma regra operacional da folha
- impedir que a data exibida venha diretamente do dia civil de `dt_hora_ponto` em contexto noturno

Ajustes previstos:
- em `reloginhoHistoricoPonto(...)`, usar a data operacional da escala quando o turno for noturno
- revisar `pegarPontoNoturno(...)` para nao devolver a madrugada como se pertencesse ao dia seguinte
- revisar apoios que ainda filtram por `DATE(dt_hora_ponto)` ou por dia fechado

## 10. Mapa objetivo de metodos para implementar

### 10.1. `PontoFolha::listarDadosPonto(...)`

Referencia:
- [PontoFolha.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/PontoFolha.php:3759)

O que fazer:
- manter este metodo como ponto central da decisao entre turno normal e noturno
- se `isTurnoNoturno` for verdadeiro, a linha do dia deve ser montada exclusivamente com a logica noturna
- evitar fallback para consultas normais quando a escala cruza meia-noite

### 10.2. `PontoFolha::verificarPontoEscalaNoturnaPorDiaFechamento(...)`

Referencia:
- [PontoFolha.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/PontoFolha.php:3697)

O que fazer:
- transformar este metodo na referencia principal da linha noturna
- trocar os horarios fixos:
  - `14:30`
  - `02:00`
  - `10:30`
- por faixa dinamica baseada na escala real do colaborador

Janela desejada:
- inicio: `dt_escala + hr_inicio_expediente`
- fim: dia seguinte + `hr_termino_expediente`, quando houver cruzamento de meia-noite

Resultado esperado:
- batidas da madrugada continuam pertencendo ao dia de inicio da jornada

### 10.3. `PontoFolha::verificarPontoEscalaNoturna(...)`

Referencia:
- [PontoFolha.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/PontoFolha.php:3634)

O que fazer:
- revisar se este metodo ainda precisa existir separado do fluxo de fechamento
- se continuar existindo, aplicar a mesma regra dinamica da escala real
- garantir que ele nao classifique pontos noturnos com base em janela fixa incompatível com outras rotinas

### 10.4. `PontoFolha::verificarPontoEscalaNormal(...)`

Referencia:
- [PontoFolha.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/PontoFolha.php:3582)

O que fazer:
- manter este metodo restrito a turno normal
- nao reutilizar este fluxo quando a jornada cruza meia-noite
- preservar `DATE(dt_hora_ponto)` somente para cenarios realmente diurnos

### 10.5. `Ponto::reloginhoHistoricoPonto(...)`

Referencia:
- [Ponto.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/Ponto.php:1189)

O que fazer:
- manter a escolha entre `pegarPontoNormal(...)` e `pegarPontoNoturno(...)`
- para turno noturno, a data retornada para exibicao nao deve ser derivada diretamente de `dt_hora_ponto`
- a data visual precisa refletir o dia operacional da escala

### 10.6. `Ponto::pegarPontoNoturno(...)`

Referencia:
- [Ponto.php](/Volumes/MACWORK/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/america-servis/app/app/src/models/Ponto.php:2072)

O que fazer:
- revisar a janela atual de captura
- substituir a faixa fixa `16:00` ate `10:00` do dia seguinte por janela dinamica da escala
- evitar que o metodo exponha `dt_rh_entratada` como data civil da batida quando o objetivo for compor o dia operacional do reloginho

## 11. Checklist tecnico de implementacao

1. Identificar no dia consultado o `hr_inicio_expediente` e `hr_termino_expediente` reais da escala.
2. Detectar formalmente se a jornada cruza meia-noite.
3. Calcular uma janela operacional do turno noturno baseada nesses horarios.
4. Buscar todas as batidas da jornada dentro dessa janela.
5. Vincular o resultado ao `dt_escala` do inicio do turno.
6. Garantir que a camada visual do reloginho use essa data operacional.
7. Revisar historico, folha e fechamento para usar a mesma regra.
8. Remover dependencias residuais de `DATE(dt_hora_ponto)` nos fluxos noturnos.

## 12. Caso real de validacao

Caso que deve passar apos a correcao:
- `28/05/2026 21:43`
- `29/05/2026 01:07`
- `29/05/2026 02:21`
- `29/05/2026 05:57`

Comportamento esperado:
- todos os registros compondo a linha de `28/05/2026`
- nenhum desses registros sendo empurrado para a linha de `29/05/2026`

## 13. Implementacao aplicada localmente

Data da implementacao local:
- `2026-05-29`

Arquivos alterados:
- `app/app/src/models/PontoFolha.php`
- `app/app/src/models/Ponto.php`

### 13.1. Ajustes aplicados em `PontoFolha.php`

Foi implementado:
- helper para normalizar horario da escala
- helper para montar janela operacional da jornada
- helper para buscar os ultimos pontos dentro de uma janela unica

Mudanca principal:
- as rotinas noturnas deixaram de usar a logica que ancorava a linha do dia atual no turno iniciado no dia anterior
- a janela operacional passou a ser montada a partir do proprio `dt_escala` consultado

Impacto esperado:
- a linha `29/05` deixa de puxar o turno iniciado em `28/05`
- a linha `28/05` passa a concentrar as batidas da jornada iniciada em `28/05`

### 13.2. Ajustes aplicados em `Ponto.php`

Foi implementado:
- helper para montar a janela operacional noturna com base na escala real
- ajuste em `reloginhoHistoricoPonto(...)` para encaminhar o `agenda_colaborador_padrao_pk` ao fluxo noturno
- ajuste em `pegarPontoNoturno(...)` para usar a mesma janela operacional baseada na escala

Impacto esperado:
- historico e consulta de ponto noturno passam a seguir a mesma ancora operacional da folha
- reduz a divergencia entre grade principal e historico do reloginho

### 13.3. Validacao tecnica executada

Validado localmente:
- sintaxe PHP sem erros em `PontoFolha.php`
- sintaxe PHP sem erros em `Ponto.php`

Pendencia restante:
- validar comportamento funcional com a base local restaurada do cliente

## 14. Execucao local realizada nesta etapa

### 14.1. Stack Docker local

Foi executado localmente:
- criacao do volume Docker `america-servis_america_mysql_data`
- subida da stack do cliente em `infra/`

Resultado:
- `america-mysql` criado e iniciado
- `america-php` criado e iniciado
- `america-nginx` criado e iniciado

Objetivo:
- preparar o ambiente local da America Servis para restauracao do dump e validacao funcional da correcao

### 14.2. Restauracao da base local

Dump utilizado:
- `database/gepros1com_americaservis.sql`

Tamanho observado:
- aproximadamente `13G`

Tentativas realizadas:
- tentativa inicial pelo script `infra/scripts/import_dump.sh`
- o processo ficou retido no precheck textual do dump muito grande
- em seguida foi iniciada a estrategia de restauracao direta com Docker, copiando o dump para o container `america-mysql`

Status ao final desta etapa:
- restauracao iniciada
- nao houve confirmacao de termino da copia/importacao dentro desta mesma sessao

Conclusao operacional:
- a preparacao do ambiente local e a rotina de restauracao foram iniciadas corretamente
- a validacao funcional final depende da conclusao dessa carga grande no MySQL local

### 14.3. Correcoes de codigo aplicadas

Arquivos alterados nesta etapa:
- `app/app/src/models/PontoFolha.php`
- `app/app/src/models/Ponto.php`

Resumo do que foi implementado:
- centralizacao da janela operacional do turno noturno
- remocao da ancoragem incorreta que fazia a linha do dia seguinte puxar a jornada do dia anterior
- alinhamento entre grade do reloginho e historico do ponto para usar a mesma referencia operacional noturna

### 14.4. Estado final desta etapa

Concluido:
- analise tecnica do problema
- mapeamento dos metodos afetados
- implementacao da correcao principal no codigo
- validacao sintatica dos arquivos alterados
- registro documental do historico
- subida da stack local

Pendente:
- concluir a restauracao do dump grande no MySQL local
- validar funcionalmente o caso real do turno noturno com dados da base do cliente

## 15. Arquivos e artefatos envolvidos nesta etapa

Arquivos de codigo:
- `app/app/src/models/PontoFolha.php`
- `app/app/src/models/Ponto.php`

Arquivos de infraestrutura:
- `infra/docker-compose.yml`
- `infra/scripts/import_dump.sh`

Artefatos de banco:
- `database/gepros1com_americaservis.sql`

Documento de historico atualizado:
- `docs/historico_correcao_reloginho_turno_noturno_2026-05-29.md`
