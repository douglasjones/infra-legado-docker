# Historico de Tarefas

Este arquivo registra, em ordem cronologica, as tarefas concluídas neste projeto.

## 2026-03-23

### Solicitação
Definir um historico persistente em Markdown para registrar as tarefas concluídas daqui para frente.

### Ação realizada
Criado este arquivo `HISTORICO.md` na raiz do projeto como fonte unica de historico operacional.

### Regra adotada
Ao concluir uma tarefa solicitada neste projeto, o historico deve ser atualizado com:

- data
- resumo da solicitação
- ação realizada
- observações relevantes, quando houver

### Solicitação
Investigar por que o dump em `backup/database` não carrega todas as tabelas no banco local Docker, usando como exemplo a tabela `usuarios`.

### Ação realizada
Recriado o ambiente MySQL do projeto com `docker compose down -v` e `docker compose up -d america-mysql`, iniciada a importação completa do arquivo `backup/database/americaservs.sql.gz` e monitorada a sessão de carga no MySQL.

### Observações relevantes
- O dump tem 7.6 GB.
- A importação iniciou sem erro imediato e permaneceu ativa por varios minutos.
- Durante o monitoramento, o schema local estabilizou em 105 tabelas enquanto o MySQL processava um `INSERT INTO ponto` de grande volume.
- Nao houve `ERROR` no arquivo de captura `/tmp/america_import.stderr`; apenas o warning padrao do cliente MySQL sobre senha na linha de comando.
- A tabela `ponto` mostrou crescimento ativo durante a carga, com cerca de 64 mil linhas visiveis no status da tabela no momento do monitoramento.
- A tabela `usuarios` ainda nao estava presente no schema no momento observado.
- As primeiras ocorrencias de `usuarios` no dump indicaram referencias por coluna e a tabela `equipes_usuarios`, o que sugere verificar se `usuarios` realmente existe no dump alem de confirmar a ordem em que as tabelas aparecem apos o bloco massivo de `ponto`.

## 2026-04-24

### Solicitação
Aplicar no `america-servis` as correcoes operacionais ja homologadas no `brasil-servis`, mantendo a compatibilidade com o legado restaurado.

### Ação realizada
Foram replicadas no `america-servis` as seguintes correcoes:

- liberacao de acesso do app ponto com envio de `api_pk` e `colaborador_pk` no fluxo de colaborador
- ajuste do controller e model de `SolicitacaoAcessoApp` para atualizar a API externa e manter fallback local
- correcao da sincronizacao de colaborador para usar o estado final salvo no banco ao enviar para a API externa
- remocao da exclusao indevida do colaborador no servidor externo ao fazer exclusao logica local
- correcao do bug `empresas_pk => ds_conta`
- robustez do endpoint de ponto para aceitar JSON bruto, latitude/longitude opcionais e `ic_ponto_fora_turno`
- normalizacao e reducao da imagem de ponto com fallback quando GD nao estiver disponivel
- correcao do reloginho para considerar tambem `ini/fim intervalo` como evidencia de ponto no dia

### Arquivos alterados

- `app/public/assets/js/local/colaborador_cad_form.js`
- `app/app/src/controllers/SolicitacaoAcessoAppController.php`
- `app/app/src/models/SolicitacaoAcessoApp.php`
- `app/app/src/models/Colaborador.php`
- `app/app/src/controllers/WebPontoApiController.php`
- `app/app/src/models/Ponto.php`
- `app/app/src/models/PontoFolha.php`

### Observações relevantes

- O `america-servis` tambem apresentava a divergencia de schema do legado em `leads.dia_faturamento`; foi aplicada compatibilizacao adicional no `Lead.php` para o menu RH funcionar mesmo quando a coluna nao existir.
- As correcoes replicadas seguiram a mesma linha do historico do `brasil-servis`, adaptadas ao estado atual do codigo deste cliente.

## 2026-04-25

### Solicitação
Atualizar o banco local do projeto `america-servis` usando o dump `clients/america-servis/database/gepros1com_americaservis.sql.gz`.

### Ação realizada
Executada a importacao do dump no container `america-mysql`, seguindo o fluxo documentado em `processo de migração.md` e `docs/importacao_dump_grande.md`.

Durante o processo, o script `infra/scripts/import_dump.sh` foi ajustado para:

- enviar logs de descompactacao de `.sql.gz` para `stderr`, evitando contaminar o caminho retornado por `ensure_sql_dump`
- permitir sobrescrever `VERIFY_SCRIPT` por variavel de ambiente em execucoes operacionais

### Observações relevantes

- O gzip foi validado com sucesso.
- O dump foi descompactado para `clients/america-servis/database/americaservs_full.sql`.
- A pre-validacao confirmou `CREATE TABLE usuarios`.
- A varredura por `INSERT INTO usuarios` no SQL de 12 GB ficou excessivamente lenta e foi interrompida; a importacao prosseguiu com o SQL ja validado/descompactado.
- A importacao concluiu com pos-validacao positiva: tabela `usuarios` encontrada e schema com 150 tabelas.
- Validacao adicional: `usuarios` contem 5 registros.
- A rota `/login` respondeu `HTTP 200` em `http://127.0.0.1:8080/login`.

## 2026-04-27

### Solicitação
Corrigir o reloginho do `america-servis` para turnos noturnos que iniciam em um dia e terminam no dia seguinte, sem afetar os demais tipos de escala.

### Ação realizada
Atualizada a montagem dos pontos em `PontoFolha::listarConsultaPontoColaborador` para identificar turno noturno pelo `turno_pk` ou por horario de inicio maior que o horario de termino. Para dias de escala noturna, a busca dos apontamentos passou a considerar o dia de fechamento da jornada: entrada na vespera e saida na madrugada do dia exibido.

### Observações relevantes

- O problema ocorria porque a consulta normal por `DATE(dt_hora_ponto)` encontrava primeiro a saida da madrugada e impedia o uso da regra noturna.
- Em dias de folga noturna, a entrada da proxima escala nao e mais capturada indevidamente.
- Validado com Andre Luiz de Freitas, periodo `01/04/2026` a `07/04/2026`: as linhas de escala passaram a mostrar pares como `17:49`/`05:48`, `17:51`/`05:57` e `17:52`/`05:47`.
- Validado tambem um caso de escala diurna no mesmo endpoint, mantendo resposta JSON com os apontamentos esperados.

## 2026-04-27

### Solicitação
Replicar no `america-servis` as correcoes aplicadas no `brasil-servis` para edicao de escalas e reloginho.

### Ação realizada

- O endpoint de edicao de escala passou a retornar tambem `ds_produto_servico`, `ds_colaborador` e `contratos_itens_pk`.
- O JS da tela de edicao de escala passou a preservar o servico, colaborador e item de contrato ja gravados quando o combo derivado do contrato nao trouxer a opcao salva.
- Adicionado loading no carregamento da edicao da escala.
- Ajustado fallback do reloginho para retorno vazio de folha de ponto como array vazio, evitando risco de warning antes do JSON.
- Atualizado cache bust do JS de escala de `v=14` para `v=15`.

### Arquivos alterados

- `app/app/src/models/AgendaColaboradorPadrao.php`
- `app/public/assets/js/local/agenda_escala_cad_form.js`
- `app/app/templates/escala/agenda_escala_cad_form.twig`
- `app/app/src/models/PontoFolha.php`

### Validações

- `php -l` no container `america-php` para `AgendaColaboradorPadrao.php` e `PontoFolha.php`.
- `node --check` para `agenda_escala_cad_form.js`.
- Endpoint `agenda_colaborador_padrao/lisarEscalaEditar?pk=34` retornou `ds_produto_servico`, `ds_colaborador` e `contratos_itens_pk`.
- Endpoint do reloginho validado com Andre Luiz de Freitas, periodo `01/04/2026` a `07/04/2026`, mantendo JSON valido e os apontamentos noturnos esperados.

## 2026-04-27

### Solicitação
Comparar o reloginho local com o legado em producao para a colaboradora Claudeir Pereira De Rezende, pois a producao mostrava pontos no inicio de abril e o ambiente local nao.

### Ação realizada

Identificado que os pontos existiam no banco local para a colaboradora `pk=19`, agenda `pk=15`, posto `Amipa`, mas o codigo local nao consultava pontos noturnos quando o dia da grade estava marcado como `Folga`.

Para escala noturna 12x36, o legado exibe a jornada pela data de fechamento. Assim, uma entrada no dia anterior e a saida de madrugada aparecem na linha do dia seguinte, mesmo que essa linha esteja com situacao `Folga`.

Foi removido o bloqueio por `ic_escala == 1` na consulta noturna por dia de fechamento. A consulta continua usando janela restrita:
- entrada: dia anterior entre `14:30` e `02:00`
- saida: dia exibido entre `00:00` e `10:30`

### Validações

- `php -l` em `PontoFolha.php` no container `america-php`.
- Claudeir Pereira De Rezende, periodo `01/04/2026` a `07/04/2026`: retornou pontos em `01/04`, `03/04`, `05/04` e `07/04`, com posto `Amipa`, conforme producao.
- Andre Luiz de Freitas, periodo `01/04/2026` a `07/04/2026`: mantidos os apontamentos noturnos esperados.
