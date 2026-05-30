# Restauracao Com Legado Original

Data: 2026-03-25

## Fonte validada

Estrutura real encontrada:

- projeto Docker atual: raiz do diretorio atual
- copia original completa: `legado-original/`

Observacao:

- nao existe um diretorio fisico `app-docker/`
- para esta auditoria, a base Docker foi tratada como a raiz atual do projeto

## Arquivos criticos procurados no original

Arquivos alvo:

- `public/assets/js/local/lead_det_form.js`
- `public/assets/js/local/colaborador_cad_form.js`
- `public/assets/js/local/colaborador_documento_res.js`
- `public/assets/js/local/colaborador_controle_escala_cad_form.js`

Resultado:

- ausentes em `legado-original/public/assets/js/local`
- ausentes em `legado-original/appPonto/public/assets/js/local`

Conclusao:

- esses arquivos nao podem ser restaurados fielmente a partir desta copia original
- a origem deles continua externa ao material atualmente disponivel

## Templates que confirmam a expectativa dos assets

O original confirma que os templates esperam exatamente esses assets:

- `legado-original/app/templates/lead/lead_main_form.twig`
- `legado-original/app/templates/colaborador/colaborador_cad_form.twig`

Ou seja:

- os nomes dos arquivos ausentes estao corretos
- o problema nao e nome errado no template
- o problema e ausencia fisica dos assets na copia disponivel

## Globais e bases comparados com o original

Comparacao final:

- `public/assets/js/global/utils.js` = identico ao original de `legado-original/appPonto/public/assets/js/global/utils.js`
- `public/assets/js/global/company.js` = identico ao original de `legado-original/appPonto/public/assets/js/global/company.js`
- `public/assets/js/global/oauth.js` = identico ao original de `legado-original/appPonto/public/assets/js/global/oauth.js`
- `public/assets/js/global/bestflow.js` = identico ao original de `legado-original/appPonto/public/assets/js/global/bestflow.js`

## Templates restaurados a partir do original

Arquivos alinhados com a copia original:

- `app/templates/theme/menu.twig`
- `app/templates/theme/base.login.twig`

Status:

- ambos agora estao identicos ao original em `legado-original/app/templates/theme/`

## structure/oauth.twig

Verificacao:

- ausente em `legado-original/app/templates/structure/oauth.twig`
- ausente em `legado-original/appPonto/app/templates/structure/oauth.twig`

Conclusao:

- nao existe versao real desse arquivo na copia original atual
- a ponte temporaria em `app/templates/structure/oauth.twig` deve ser mantida ate surgir nova evidencia

## Validacao de runtime

Containers:

- `america-mysql`: up e healthy
- `america-nginx`: up
- `america-php`: up

Arquivos JS locais criticos ainda ausentes no app Docker:

- `lead_det_form.js`
- `colaborador_cad_form.js`
- `colaborador_documento_res.js`
- `colaborador_controle_escala_cad_form.js`

## Resultado objetivo

Resolvido nesta etapa:

- validacao da copia `legado-original` como fonte principal
- confirmacao de que os templates do original referenciam os mesmos assets
- alinhamento de `menu.twig` e `base.login.twig` ao original completo
- confirmacao de integridade dos JS globais restaurados

Nao resolvido nesta etapa:

- restauracao dos JS locais criticos de edicao

Motivo:

- os arquivos nao existem na copia original atualmente disponivel

## Proximo passo recomendado

Para concluir fielmente os fluxos de editar Lead e Colaborador, ainda sera necessario localizar uma fonte adicional que contenha os assets locais ausentes, como:

- copia publicada do servidor funcional
- backup de deploy
- branch historica nao presente localmente
- outro snapshot completo do cliente
