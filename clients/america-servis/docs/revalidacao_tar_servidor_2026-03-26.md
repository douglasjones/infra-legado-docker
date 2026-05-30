# Revalidacao Do Tar Do Servidor 2026-03-26

Data: 2026-03-26

## Escopo

Validacao objetiva do pacote `americaservis_full_2026-03-26_10-41-12.tar.gz`, baixado diretamente do servidor, extraido sem sobrescrever o conteudo atual de `legado-original/`.

Premissas desta etapa:

- o tar foi tratado como a melhor evidencia disponivel neste momento
- nenhuma correcao foi feita
- nenhuma copia foi aplicada sobre o app Docker
- a comparacao com a copia FTP anterior foi feita com base no relatorio `docs/revalidacao_legado_original_ftp.md`, porque a arvore FTP anterior nao esta mais presente no filesystem atual

## 1. Inspecao Do Tar Antes Da Extracao

Arquivo inspecionado:

- `legado-original/americaservis_full_2026-03-26_10-41-12.tar.gz`

Tamanho observado:

- aproximadamente `80M`

Resultado da listagem do topo do tar:

- o pacote contem uma unica raiz de topo: `americaservis/`
- nao ha arquivos soltos no nivel raiz do tar

Evidencias do topo do pacote:

- `americaservis/composer.json`
- `americaservis/composer.lock`
- `americaservis/package.json`
- `americaservis/vendor/`
- `americaservis/app/`
- `americaservis/public/`

Conclusao da inspecao inicial:

- o tar ja se apresenta como uma aplicacao completa agrupada sob uma unica pasta raiz
- a estrutura declarada no pacote e mais forte que a evidenciada na copia FTP anterior

## 2. Extracao Segura Em Pasta Separada

Pasta criada para rastreabilidade:

- `legado-original/extraido-tar-2026-03-26/`

Extracao realizada para:

- `legado-original/extraido-tar-2026-03-26/americaservis/`

Garantia aplicada:

- nenhum arquivo existente foi sobrescrito dentro de `legado-original/`
- a nova fonte ficou isolada para comparacao limpa

## 3. Raiz Real Do Projeto Extraido

Raiz real identificada:

- `legado-original/extraido-tar-2026-03-26/americaservis/`

Estrutura principal confirmada:

- `app/`
- `public/`
- `vendor/`

Arquivos de topo relevantes confirmados:

- `composer.json`
- `composer.lock`
- `package.json`
- `package-lock.json`
- `vercao.txt`

Diretorios relevantes confirmados:

- `app/src/`
- `app/templates/`
- `public/assets/`
- `vendor/`

Resultado sobre subarvores adicionais:

- nao foi encontrado `appPonto/`
- nao ha evidencia de mais de uma aplicacao principal dentro do pacote

Conclusao sobre a raiz do projeto:

- o pacote contem uma unica aplicacao principal, claramente organizada, com bootstrap, templates, assets e vendor sob a mesma raiz

## 4. Revalidacao Dos Arquivos Criticos

### Bootstrap / runtime

- `app/settings.php`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/app/settings.php`

- `app/middleware.php`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/app/middleware.php`

- `app/dependencies.php`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/app/dependencies.php`

- `app/routes.php`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/app/routes.php`

- `app/routes-api.php`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/app/routes-api.php`

- `public/index.php`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/public/index.php`

Revalidacao objetiva do bootstrap:

- `public/index.php` exige `vendor/autoload.php`, `app/settings.php`, `app/middleware.php`, `app/dependencies.php`, `app/routes.php` e `app/routes-api.php`
- todos esses arquivos existem fisicamente na nova extracao

### Assets globais

- `public/assets/js/global/utils.js`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/public/assets/js/global/utils.js`

- `public/assets/js/global/company.js`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/public/assets/js/global/company.js`

- `public/assets/js/global/oauth.js`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/public/assets/js/global/oauth.js`

- `public/assets/js/global/bestflow.js`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/public/assets/js/global/bestflow.js`

Observacao adicional:

- `break.js` tambem existe em `public/assets/js/global/`

### Assets locais criticos

- `public/assets/js/local/lead_det_form.js`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/public/assets/js/local/lead_det_form.js`

- `public/assets/js/local/colaborador_cad_form.js`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/public/assets/js/local/colaborador_cad_form.js`

- `public/assets/js/local/colaborador_documento_res.js`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/public/assets/js/local/colaborador_documento_res.js`

- `public/assets/js/local/colaborador_controle_escala_cad_form.js`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/public/assets/js/local/colaborador_controle_escala_cad_form.js`

Contagens observadas:

- `public/assets/js/global`: 5 arquivos
- `public/assets/js/local`: 203 arquivos
- `public/assets/css`: 6 arquivos

### Templates criticos

- `oauth/login.twig`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/app/templates/oauth/login.twig`

- `structure/oauth.twig`
  - nao existe
  - nao foi encontrado em `legado-original/extraido-tar-2026-03-26/americaservis/app/templates/`

- `app/templates/theme/menu.twig`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/app/templates/theme/menu.twig`

- `app/templates/theme/base.login.twig`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/app/templates/theme/base.login.twig`

- `lead_main_form.twig`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/app/templates/lead/lead_main_form.twig`

- `colaborador_cad_form.twig`
  - existe
  - caminho: `legado-original/extraido-tar-2026-03-26/americaservis/app/templates/colaborador/colaborador_cad_form.twig`

### Referencias nos templates

Referencias confirmadas:

- `theme/base.login.twig` referencia:
  - `/assets/js/global/utils.js`
  - `/assets/js/global/company.js`

- `theme/base.twig` referencia:
  - `/assets/js/global/utils.js`
  - `/assets/js/global/bestflow.js`

- `login/login.twig` referencia:
  - `/assets/js/global/oauth.js`

- `lead/lead_main_form.twig` referencia:
  - `/assets/js/local/lead_det_form.js`

- `colaborador/colaborador_cad_form.twig` referencia:
  - `/assets/js/local/colaborador_cad_form.js`
  - `/assets/js/local/colaborador_documento_res.js`
  - `/assets/js/local/colaborador_controle_escala_cad_form.js`

- `oauth/login.twig` continua fazendo:
  - `extends "structure/oauth.twig"`

Conclusao dos templates:

- todos os assets criticos referenciados pelos templates existem fisicamente na nova extracao
- a unica lacuna de template que continua evidente e `structure/oauth.twig`

## 5. Revalidacao Do `vendor/`

### O que existe

Arquivos base confirmados:

- `vendor/autoload.php`
- `vendor/composer/installed.php`
- `vendor/composer/installed.json`

Diretorios criticos revalidados:

- `vendor/mpdf/` existe
- `vendor/twbs/` existe
- `vendor/psr/` existe

Provas adicionais:

- `vendor/mpdf/mpdf/src/functions.php` existe
- `vendor/twbs/bootstrap-icons/font/bootstrap-icons.css` existe
- `vendor/psr/http-message/` existe

### Coerencia com `composer.json`

Dependencias declaradas em `composer.json`:

- `slim/slim`
- `mpdf/mpdf`
- `slim/twig-view`
- `twbs/bootstrap-icons`
- `swiftmailer/swiftmailer`
- `guzzlehttp/guzzle`

Resultado observado na arvore `vendor/`:

- todas as dependencias criticas antes faltantes agora possuem diretorios fisicos presentes
- o autoload gerado referencia caminhos que agora existem no filesystem

Conclusao sobre `vendor`:

- o `vendor/` agora parece coerente e autossuficiente para o runtime, no nivel de estrutura e integridade fisica observavel
- nao foram encontradas as lacunas fisicas de `mpdf`, `twbs` e `psr` que apareciam na analise FTP anterior

Observacao:

- nao foi possivel executar `php` localmente nesta etapa porque o binario continua indisponivel no host atual
- ainda assim, estruturalmente o `vendor/` do tar esta consistente com `composer.json`, `composer.lock` e com o autoload gerado

## 6. Comparacao Com A Copia FTP Anterior

Base de comparacao:

- relatorio anterior: `docs/revalidacao_legado_original_ftp.md`

### O que o tar trouxe que o FTP anterior nao mostrava

O tar trouxe de forma objetiva:

- `app/settings.php`
- `app/middleware.php`
- `app/dependencies.php`
- `app/routes.php`
- `vendor/mpdf/`
- `vendor/twbs/`
- `vendor/psr/`

### O que isso prova

- o material analisado via FTP anteriormente estava incompleto para bootstrap e runtime
- o tar confirma que a ausencia desses arquivos na etapa anterior nao era uma caracteristica do sistema, e sim uma limitacao da copia FTP entao disponivel

### O que permanece igual nas duas fontes

- os assets globais criticos existem
- os assets locais criticos existem
- `oauth/login.twig` continua referenciando `structure/oauth.twig`
- `structure/oauth.twig` continua ausente

### Confiabilidade relativa

Resposta objetiva:

- sim, o tar e mais confiavel que a copia FTP anterior para validar runtime
- sim, o tar deve passar a ser a nova fonte principal de verificacao da migracao

## 7. Conclusao Final Objetiva

Resposta curta:

- esta nova copia extraida do tar esta substancialmente mais completa que a copia FTP anterior
- ela contem a raiz real do projeto com `app/`, `public/`, `vendor/`, bootstrap e dependencias criticas
- ela deve virar a nova fonte principal de referencia da migracao

Status objetivo:

- bootstrap principal: completo
- assets globais criticos: presentes
- assets locais criticos: presentes
- `vendor/`: fisicamente completo para os pontos antes faltantes
- lacuna remanescente identificada: `app/templates/structure/oauth.twig` continua ausente

Conclusao final:

- a nova copia do tar e completa o suficiente para substituir a copia FTP anterior como base correta da migracao
- a unica ausencia critica ainda objetivamente visivel nesta verificacao e `structure/oauth.twig`
- fora essa lacuna de template, a extracao do tar se apresenta como a versao mais integra e confiavel do legado observada ate agora
