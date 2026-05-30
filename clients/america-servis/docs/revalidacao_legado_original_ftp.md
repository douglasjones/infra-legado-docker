# Revalidacao Do Legado Original FTP

Data: 2026-03-26

## Escopo

Revalidacao objetiva da pasta `legado-original/` apos nova copia via FTP do ambiente real da America Servs.

Premissas aplicadas nesta etapa:

- a nova copia substitui a analise anterior sobre ausencia de arquivos
- nenhuma correcao foi feita
- nenhuma sincronizacao com o app Docker foi feita
- a conclusao abaixo usa apenas evidencia do filesystem local

## 1. Estrutura Geral Revalidada

### Estrutura encontrada

Diretorios principais encontrados:

- `legado-original/app/`
- `legado-original/public/`
- `legado-original/vendor/`

Diretorios relevantes dentro de `public/assets/`:

- `legado-original/public/assets/js/global/`
- `legado-original/public/assets/js/local/`
- `legado-original/public/assets/css/global/`
- `legado-original/public/assets/css/local/`
- `legado-original/public/assets/plugins/`
- `legado-original/public/assets/fonts/`
- `legado-original/public/assets/img/`

Contagens verificadas:

- `public/assets/js/global`: 5 arquivos
- `public/assets/js/local`: 203 arquivos
- `public/assets/css`: 6 arquivos

Arquivos CSS confirmados:

- `legado-original/public/assets/css/global/styles.css`
- `legado-original/public/assets/css/local/authentication.css`
- `legado-original/public/assets/css/local/chat.css`
- `legado-original/public/assets/css/local/occurrence.css`
- `legado-original/public/assets/css/local/queue-service.css`
- `legado-original/public/assets/css/local/receptivo.css`

### Bootstrap Slim revalidado

O entrypoint existe:

- `legado-original/public/index.php`

Esse arquivo continua exigindo:

- `../vendor/autoload.php`
- `../app/settings.php`
- `../app/middleware.php`
- `../app/dependencies.php`
- `../app/routes.php`
- `../app/routes-api.php`

Status fisico em `legado-original/app/`:

- encontrado: `routes-api.php`
- nao encontrados em nenhum lugar de `legado-original/`:
  - `settings.php`
  - `middleware.php`
  - `dependencies.php`
  - `routes.php`

Conclusao estrutural:

- a nova copia esta mais completa na camada de assets e templates do que a analisada antes
- mas nao esta completa como arvore de bootstrap PHP, porque faltam arquivos exigidos diretamente por `public/index.php`

### `appPonto/`

Resultado:

- nenhum diretorio `legado-original/appPonto/` foi encontrado nesta nova copia

Impacto:

- os JS globais e locais relevantes agora foram encontrados em `legado-original/public/assets/...`
- portanto a nova copia nao depende mais de `appPonto/` para explicar esses assets

## 2. Arquivos Criticos Revalidados

### JS globais

- `public/assets/js/global/utils.js`
  - existe
  - caminho: `legado-original/public/assets/js/global/utils.js`

- `public/assets/js/global/company.js`
  - existe
  - caminho: `legado-original/public/assets/js/global/company.js`

- `public/assets/js/global/oauth.js`
  - existe
  - caminho: `legado-original/public/assets/js/global/oauth.js`

- `public/assets/js/global/bestflow.js`
  - existe
  - caminho: `legado-original/public/assets/js/global/bestflow.js`

### JS locais

- `public/assets/js/local/lead_det_form.js`
  - existe
  - caminho: `legado-original/public/assets/js/local/lead_det_form.js`

- `public/assets/js/local/colaborador_cad_form.js`
  - existe
  - caminho: `legado-original/public/assets/js/local/colaborador_cad_form.js`

- `public/assets/js/local/colaborador_documento_res.js`
  - existe
  - caminho: `legado-original/public/assets/js/local/colaborador_documento_res.js`

- `public/assets/js/local/colaborador_controle_escala_cad_form.js`
  - existe
  - caminho: `legado-original/public/assets/js/local/colaborador_controle_escala_cad_form.js`

### Template OAuth base

- `structure/oauth.twig`
  - nao existe no caminho esperado `legado-original/app/templates/structure/oauth.twig`
  - nao foi encontrada outra copia fisica com nome `oauth.twig` fora de `legado-original/app/templates/oauth/login.twig`

Observacao objetiva:

- existe `legado-original/app/templates/oauth/login.twig`
- esse arquivo faz `extends "structure/oauth.twig"`
- portanto a referencia continua apontando para um template base ausente

## 3. Templates E Referencias Revalidados

### `lead_main_form.twig`

Arquivo:

- `legado-original/app/templates/lead/lead_main_form.twig`

Referencia confirmada:

- `/assets/js/local/lead_det_form.js?v=14`

Status fisico do asset:

- existe em `legado-original/public/assets/js/local/lead_det_form.js`

### `colaborador_cad_form.twig`

Arquivo:

- `legado-original/app/templates/colaborador/colaborador_cad_form.twig`

Referencias confirmadas:

- `/assets/js/local/colaborador_cad_form.js?v=14`
- `/assets/js/local/colaborador_documento_res.js?v=14`
- `/assets/js/local/colaborador_controle_escala_cad_form.js?v=14`

Status fisico dos assets:

- todos existem em `legado-original/public/assets/js/local/`

### `menu.twig`

Arquivo:

- `legado-original/app/templates/theme/menu.twig`

Observacao:

- o arquivo nao referencia diretamente os JS globais
- ele continua sendo incluido por `theme/base.twig`

### `base.login.twig`

Arquivo:

- `legado-original/app/templates/theme/base.login.twig`

Referencias confirmadas:

- `/assets/js/global/utils.js?v={{ config.VERSION_ID }}`
- `/assets/js/global/company.js?v={{ config.VERSION_ID }}`

Status fisico:

- ambos existem em `legado-original/public/assets/js/global/`

### Templates de login e oauth

Arquivos:

- `legado-original/app/templates/login/login.twig`
- `legado-original/app/templates/oauth/login.twig`

Referencias confirmadas:

- `login/login.twig` faz `extends "theme/base.login.twig"` e carrega `/assets/js/global/oauth.js`
- `oauth/login.twig` faz `extends "structure/oauth.twig"` e carrega `/assets/js/global/oauth.js`

Status fisico do asset:

- `legado-original/public/assets/js/global/oauth.js` existe

Mudanca em relacao a analise anterior:

- os assets JS antes marcados como ausentes agora existem fisicamente na nova copia
- a ausencia de `structure/oauth.twig` continua verdadeira

## 4. Camada `vendor/` Revalidada

### O que existe

Arquivos base confirmados:

- `legado-original/composer.json`
- `legado-original/composer.lock`
- `legado-original/vendor/autoload.php`
- `legado-original/vendor/composer/installed.php`
- `legado-original/vendor/composer/installed.json`

Pacotes fisicamente presentes na arvore `vendor/`:

- `slim/slim`
- `slim/twig-view`
- `twig/twig`
- `guzzlehttp/guzzle`
- `swiftmailer/swiftmailer`
- `phpmailer/phpmailer`
- `setasign/fpdi`
- alguns pacotes auxiliares de `symfony`, `doctrine`, `paragonie`, `pimple`, `nikic`, `myclabs`, `egulias`

### O que o Composer declara

`composer.json` declara explicitamente:

- `slim/slim`
- `mpdf/mpdf`
- `slim/twig-view`
- `twbs/bootstrap-icons`
- `swiftmailer/swiftmailer`
- `guzzlehttp/guzzle`

`composer.lock` tambem lista:

- `mpdf/mpdf`
- `twbs/bootstrap-icons`

### Inconsistencias objetivas

Diretorios ausentes no filesystem:

- `legado-original/vendor/mpdf/`
- `legado-original/vendor/twbs/`
- `legado-original/vendor/psr/`

Provas adicionais:

- `vendor/composer/autoload_files.php` aponta para `vendor/mpdf/mpdf/src/functions.php`
- esse arquivo nao existe fisicamente
- `vendor/composer/autoload_psr4.php` aponta para:
  - `vendor/psr/log/Psr/Log`
  - `vendor/psr/http-message/src`
  - `vendor/psr/container/src`
  - `vendor/mpdf/psr-log-aware-trait/src`
  - `vendor/mpdf/psr-http-message-shim/src`
  - `vendor/mpdf/mpdf/src`
- essas arvores nao existem fisicamente

Conclusao sobre `vendor`:

- `vendor/` nao esta completo
- a nova copia nao e autossuficiente para runtime apenas com o material atual
- ha evidencia objetiva de desalinhamento entre `composer.lock` e os diretorios realmente presentes em `vendor/`

### Observacao de validacao

Nao foi possivel executar `php` localmente nesta etapa porque o binario nao esta disponivel no host atual (`php: command not found`).

Mesmo sem runtime, a insuficiencia do `vendor` ja esta comprovada pelo proprio autoload gerado e pela ausencia fisica dos caminhos referenciados.

## 5. Comparacao Com A Analise Anterior

### O que mudou

O diagnostico anterior de ausencia dos seguintes assets nao continua verdadeiro para a nova copia:

- `public/assets/js/local/lead_det_form.js`
- `public/assets/js/local/colaborador_cad_form.js`
- `public/assets/js/local/colaborador_documento_res.js`
- `public/assets/js/local/colaborador_controle_escala_cad_form.js`
- `public/assets/js/global/utils.js`
- `public/assets/js/global/company.js`
- `public/assets/js/global/oauth.js`
- `public/assets/js/global/bestflow.js`

Todos esses arquivos agora existem diretamente em `legado-original/public/assets/js/...`

### O que continua verdadeiro

Continuam verdadeiras as seguintes faltas/inconsistencias:

- `app/templates/structure/oauth.twig` continua ausente
- `vendor/` continua incompleto
- a arvore `app/` continua incompleta para o bootstrap exigido por `public/index.php`

Arquivos de bootstrap PHP ainda ausentes:

- `legado-original/app/settings.php`
- `legado-original/app/middleware.php`
- `legado-original/app/dependencies.php`
- `legado-original/app/routes.php`

### Nova conclusao sobre a suficiencia de `legado-original`

Resposta objetiva:

- sim, a nova copia melhora significativamente a confiabilidade de `legado-original` como fonte de assets e templates
- nao, a nova copia ainda nao esta integra como fonte unica e autossuficiente de runtime

## 6. Conclusao Final Objetiva

Resposta curta:

- a nova copia FTP esta mais completa do que a analisada anteriormente
- varios arquivos criticos antes tratados como ausentes agora existem
- porem a copia ainda nao esta integra para servir sozinha como base executavel do sistema

Motivos objetivos:

- os JS globais e locais criticos agora existem
- `structure/oauth.twig` continua ausente
- faltam arquivos de bootstrap PHP exigidos por `public/index.php`
- o `vendor/` continua incompleto e desalinhado com `composer.json` e `composer.lock`

Conclusao pratica desta etapa:

- `legado-original/` passa a ser uma fonte melhor e mais confiavel para migracao do que na analise anterior
- mas ainda nao pode ser tratada como copia integral e autossuficiente do sistema sem complementacao adicional
