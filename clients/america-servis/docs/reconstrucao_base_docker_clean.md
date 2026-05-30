# Reconstrucao Da Base Docker Clean

Data: 2026-03-26

## Objetivo

Criar uma base paralela limpa a partir do `legado-original`, sem substituir a base atual, para comparar:

- base reativa atual
- base limpa reconstruida a partir do original

## Estrutura criada

Nova base:

- `app-docker-clean/`

Infraestrutura criada para validacao paralela:

- `docker-compose.clean.yml`
- `docker/nginx/default.clean.conf`

## O que foi copiado do legado-original

Copiado diretamente de `legado-original/` para `app-docker-clean/`:

- `app/`
- `public/`
- `vendor/`
- `composer.json`
- `composer.lock`
- `package.json`
- `package-lock.json`
- `vercao.txt`

Observacao:

- nenhum controller, template ou asset foi copiado da base reativa atual
- a unica excecao posterior foi a camada `vendor/`, descrita abaixo

## Ajustes minimos de infraestrutura aplicados

### 1. Banco

Arquivo ajustado:

- `app-docker-clean/app/settings.php`

Ajuste:

- `db.host`: `localhost` -> `america-mysql`

Motivo:

- permitir que a app limpa use o MySQL ja existente no Docker

### 2. Docker paralelo

Compose paralelo criado em `docker-compose.clean.yml`:

- `america-clean-php`
- `america-clean-nginx`

Porta publicada:

- `8081`

Rede usada:

- `america-servis_america-net`

Motivo:

- reutilizar o MySQL atual sem derrubar a stack existente

### 3. Nginx

Config criada:

- `docker/nginx/default.clean.conf`

Mantido:

- document root em `/var/www/html/public`
- `try_files` para `index.php`
- FastCGI para `america-clean-php:9000`

## O que foi propositalmente descartado da base antiga

Nao foi levado da base atual:

- `LoginController.php` alterado
- `LeadController.php` alterado
- `ColaboradorController.php` alterado
- logs temporarios
- bridge de comportamento
- assets restaurados reativamente

## Excecao tecnica justificada

Durante a subida da base limpa, o `vendor/` vindo do `legado-original` quebrou o bootstrap por falta de dependencias Composer:

- `mpdf`
- `psr`
- `swiftmailer`
- `twbs`

Prova:

- o autoload falhou por ausencia de `mpdf/mpdf/src/functions.php`

Como `composer` nao esta disponivel no host e o objetivo era validar a app limpa em runtime, foi feita uma sincronizacao apenas da camada `vendor/` a partir do `vendor/` atual.

Importante:

- isso nao alterou `app/`, `public/`, templates, controllers ou regras de negocio da base limpa
- a contaminacao de codigo de aplicacao foi evitada
- a excecao ficou restrita a dependencias Composer

## Resultado das validacoes

### 1. Bootstrap

Status:

- `america-clean-php` subiu
- `america-clean-nginx` subiu
- a rota `/login` respondeu `200 OK`

Conclusao:

- a base limpa sobe no Docker
- o Slim inicializa

### 2. Login

Resultados:

- tela `/login` renderiza `200 OK`
- `POST /api/auth/login` funciona
- autenticacao validada com usuario real:
  - login: `adm2americaservis@gmail.com`
  - senha: `2025`

Conclusao:

- backend de login da base limpa funciona
- sessao PHP e autenticacao API estao operacionais

### 3. Menu

Resultados:

- `/menu/principal` renderiza `200 OK` apos login
- `POST /api/usuario/verificarPermissaoMenu` funciona e retorna flags de permissao

Exemplo validado:

- `arrMenuComercial: true`
- `arrMenuOperacional: true`
- `arrMenuCompraEstoque: true`
- `arrMenuRh: true`

Conclusao:

- rota e API de menu funcionam na base limpa

### 4. Fluxos criticos

#### Lead

Validado:

- `/lead/leadMainPainel?ic_abertura=1&pk=124&local=1`
- a tela renderiza e referencia:
  - `lead_main_form.js`
  - `lead_det_form.js`
  - `contato_res_form.js`
  - `documento_res_form.js`

Estado real dos assets:

- `lead_main_form.js`: `200`
- `lead_det_form.js`: `404`

#### Colaborador

Validado:

- `/colaborador/cadForm?colaborador_pk=2&local=1`
- a tela renderiza e referencia:
  - `colaborador_cad_form.js`
  - `colaborador_documento_res.js`
  - `colaborador_controle_escala_cad_form.js`

Estado real dos assets:

- `colaborador_cad_form.js`: `404`
- `colaborador_documento_res.js`: `404`
- `colaborador_controle_escala_cad_form.js`: `404`

## Comparacao entre base antiga e base limpa

### O que a base limpa comprovou

- o nucleo da arquitetura Slim do legado original sobe corretamente em Docker
- login API, sessao e menu API funcionam
- a base atual nao estava errada ao preservar Slim, Twig, controllers e rotas

### O que a base limpa expôs

- o `legado-original` raiz, por si so, nao contem os JS globais referenciados pelos templates:
  - `/assets/js/global/utils.js`
  - `/assets/js/global/company.js`
  - `/assets/js/global/oauth.js`
  - `/assets/js/global/bestflow.js`

Status HTTP na base limpa:

- todos `404`

- os JS locais criticos de edicao tambem continuam ausentes na base limpa:
  - `lead_det_form.js`
  - `colaborador_cad_form.js`
  - `colaborador_documento_res.js`
  - `colaborador_controle_escala_cad_form.js`

Status HTTP na base limpa:

- todos `404`

### O que a base antiga estava mascarando

A base atual tinha ganho estabilidade adicional porque ja havia:

- restaurado `bestflow.js`
- alinhado globais a partir de outra origem disponivel
- recebido correcoes reativas e instrumentacao

Ou seja:

- a base atual nao inventou a arquitetura
- mas ela compensou lacunas fisicas que a base limpa, por fidelidade ao `legado-original` raiz, ainda expoe

## Recomendacao final

### A nova base deve substituir a antiga agora?

Resposta:

- nao

Motivo:

- a `app-docker-clean` e utilissima como base de comparacao arquitetural
- mas ainda nao e melhor que a base atual para uso principal
- ela sobe, autentica e renderiza, porem continua com lacunas fisicas relevantes de assets

### Recomendacao pratica

Manter as duas bases:

- base atual: referencia operacional da restauracao em andamento
- `app-docker-clean`: referencia limpa de comparacao

Ordem recomendada daqui para frente:

1. nao substituir a base atual ainda
2. usar `app-docker-clean` como espelho de comparacao do original
3. validar e localizar a origem real dos assets que faltam tambem na base limpa
4. so depois decidir se a `app-docker-clean` deve virar a base principal

## Sintese

A reconstrucao limpa foi bem-sucedida para provar a arquitetura e o bootstrap real do legado em Docker.

Ela tambem provou que:

- o problema nao e o Slim
- o problema nao e o bootstrap principal
- as principais lacunas continuam concentradas em assets fisicos ausentes no material de origem usado

Portanto, a decisao correta neste momento e:

- manter a base atual
- manter a base limpa em paralelo
- usar a comparacao entre as duas como criterio para a proxima etapa
