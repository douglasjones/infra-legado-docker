# Migracao de banco - RH Restaurante Tilapia

Data: 2026-06-03

## Objetivo

Subir o dump do cliente `rh-restaurante-tilapia` no ambiente Docker local e aplicar ao final as alteracoes de banco documentadas para compatibilidade com os ajustes de reloginho e folha.

## Ambiente utilizado

- Projeto: `clients/rh-restaurante-tilapia`
- Container MySQL: `rh-restaurante-tilapia-mysql`
- Banco: `wwgepr_rest_tilapia`
- Porta MySQL: `3318`

## Dump identificado

Dump inicialmente esperado:

- `clients/rh-restaurante-tilapia/database/wwgepr_rest_tilapia.sql.gz`

Problema encontrado:

- o arquivo acima esta truncado/corrompido
- ao validar/leitura, o `gzip` retornou `unexpected end of file`

Dump alternativo utilizado:

- `clients/restaurante/database/wwgepr_rest_tilapia.sql.gz`

Observacao:

- a copia alternativa estava integra e foi usada para concluir a importacao

## Procedimento executado

1. Validado que o ambiente Docker do cliente estava ativo e com o MySQL `healthy`.
2. Confirmado que a base atual estava incompleta antes da carga.
3. Recriado o banco `wwgepr_rest_tilapia`.
4. Importado o dump integro por streaming para o container MySQL.
5. Aplicado o SQL final de compatibilidade:
   - `clients/rh-restaurante-tilapia/database/20260602_compat_campos_reloginho_folha.sql`
6. Validado o schema final.

## Validacoes finais

- banco importado com `40` tabelas
- `16` campos de compatibilidade presentes no schema
- tabela `validar_reloginho` continua ausente neste cliente

## Campos validados apos a compatibilidade

- `colaboradores.dt_admissao`
- `colaboradores.ds_re`
- `agenda_colaborador_padrao.hr_jornada_trabalho_intervalo`
- `agenda_colaborador_padrao.hr_total_expediente`
- `agenda_colaborador_apontamento.ic_status`
- `apontamento_falta.hr_ini_abono`
- `apontamento_falta.hr_ini_intervalo_abono`
- `apontamento_falta.hr_termino_intervalo_abono`
- `apontamento_falta.hr_termino_abono`
- `apontamento_falta.dt_inicio_atestado`
- `apontamento_falta.dt_fim_atestado`
- `apontamento_folga.feriado_pk`
- `ponto.ds_latitude`
- `ponto.ds_longitude`
- `ponto.ic_validacao_facial`
- `ponto.ds_img`

## Referencias

- `clients/rh-restaurante-tilapia/database/20260602_compat_campos_reloginho_folha.sql`
- `clients/rh-restaurante-tilapia/database/20260603_levantamento_compat_campos_codigo_banco.md`
