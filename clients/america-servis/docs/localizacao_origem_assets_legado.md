# Localizacao Da Origem Dos Assets Locais Ausentes

Data da verificacao: 2026-03-25

## Objetivo

Localizar a origem real dos arquivos JS locais criticos ausentes do fluxo de edicao, sem reconstrucao manual.

Arquivos alvo principais:

- `public/assets/js/local/lead_det_form.js`
- `public/assets/js/local/colaborador_cad_form.js`
- `public/assets/js/local/colaborador_documento_res.js`
- `public/assets/js/local/colaborador_controle_escala_cad_form.js`

## Metodologia

Foi feita busca por:

- nomes exatos dos arquivos
- referencias em templates Twig
- nomes relacionados em `public/assets/js/local`
- arvores irmas em `facilities/*`
- copias parciais do legado em `appPonto/`
- diretorios com perfil de deploy/publicacao
- arquivos compactados relevantes no workspace

Escopo principal pesquisado:

- `/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities`
- `/Volumes/HDDisco/gpros-workspace`
- projeto atual `america-servis`
- copia parcial `america-servis/appPonto`
- projeto irmao `atc`

## Resultado

### 1. Encontrados por nome exato

Nenhum dos arquivos abaixo foi encontrado fisicamente no workspace pesquisado:

- `lead_det_form.js`
- `colaborador_cad_form.js`
- `colaborador_documento_res.js`
- `colaborador_controle_escala_cad_form.js`

Tambem nao houve resultado por `mdfind` para esses nomes exatos.

### 2. Equivalentes encontrados por referencia

O projeto irmao `atc` contem os mesmos templates e as mesmas referencias de assets locais usados pelos fluxos quebrados do `america-servis`.

Referencias confirmadas em `atc`:

- `atc/app/templates/lead/lead_main_form.twig`
  - referencia `lead_main_form.js`
  - referencia `lead_det_form.js`
  - referencia `contato_res_form.js`
  - referencia `contato_cad_form.js`
  - referencia `agenda_res_form.js`
  - referencia `agenda_cad_form.js`
  - referencia `comercial_res_form.js`
  - referencia `comercial_cad_form.js`
  - referencia `ocorrencia_res_form.js`
  - referencia `ocorrencia_cad_form.js`
  - referencia `documento_res_form.js`
  - referencia `documento_cad_form.js`

- `atc/app/templates/colaborador/colaborador_cad_form.twig`
  - referencia `colaborador_cad_form.js`
  - referencia `colaborador_qualificacao_res_form.js`
  - referencia `colaborador_exames_cursos_res.js`
  - referencia `colaborador_beneficios_res.js`
  - referencia `colaborador_documento_res.js`
  - referencia `colaborador_afastamento_ferias_res.js`
  - referencia `movimentar_estoque_res_form.js`
  - referencia `colaborador_controle_escala_res_form.js`
  - referencia `colaborador_controle_escala_cad_form.js`

- `atc/app/templates/partials/cliente/colaborador_cad_form_cliente.twig`
  - referencia `colaborador_cad_form_cliente.js`
  - referencia `colaborador_documento_res.js`
  - referencia `colaborador_controle_escala_cad_form.js`

Conclusao parcial:

- o `atc` confirma a nomenclatura real esperada dos assets
- o `atc` confirma que os fluxos de `lead` e `colaborador` usam a mesma convencao de assets do `america-servis`
- o `atc` nao trouxe a copia fisica dos arquivos `.js` correspondentes

### 3. Arquivos correlatos existentes no projeto atual

No `america-servis/public/assets/js/local`, existem assets proximos do mesmo fluxo, o que confirma que a restauracao esta parcial e seletiva:

- `lead_cad_form.js`
- `lead_main_form.js`
- `lead_res.js`
- `colaborador_res_form.js`
- `colaborador_qualificacao_res_form.js`
- `colaborador_exames_cursos_res.js`
- `colaborador_beneficios_res.js`
- `colaborador_afastamento_ferias_res.js`
- `colaborador_controle_escala_res_form.js`
- `contato_cad_form.js`
- `contato_res_form.js`
- `comercial_res_form.js`
- `documento_cad_form.js`
- `inc_apontamento_colaborador_cad_form.js`
- `inc_apontamento_troca_escala_cad_form.js`

Isso reforca que os assets ausentes nao parecem ter sido renomeados localmente; eles simplesmente nao vieram na restauracao atual.

### 4. Outras origens verificadas

Verificacoes executadas:

- `facilities/*/app/templates`
- `facilities/*/appPonto`
- diretorios `public` dentro de `facilities`
- busca por arquivos compactados relevantes dentro de `atc`
- busca por nomes exatos no workspace

Achados:

- em `facilities`, apenas `america-servis` possui `public/` montado de forma completa
- apenas `america-servis` e `atc` possuem `appPonto/`
- o `appPonto` disponivel nao contem os JS locais criticos pesquisados
- nao foi localizada, no acervo atual pesquisado, uma copia publicada contendo esses arquivos

## Lista Final

### Encontrados

- nenhum arquivo fisico encontrado por nome exato

### Equivalentes encontrados com outro nome

- nenhum equivalente fisico confirmado ate agora
- houve apenas equivalencia por referencia em templates do projeto `atc`

### Ainda nao localizados

- `lead_det_form.js`
- `colaborador_cad_form.js`
- `colaborador_documento_res.js`
- `colaborador_controle_escala_cad_form.js`
- `agenda_res_form.js`
- `agenda_cad_form.js`
- `comercial_cad_form.js`
- `ocorrencia_cad_form.js`
- `documento_res_form.js`
- possivelmente outros JS locais de formularios detalhados ainda nao restaurados

## Conclusao

Com o material local atualmente disponivel, nao foi possivel localizar a origem fisica real dos JS locais criticos ausentes.

O melhor indicio objetivo obtido foi:

- o projeto `atc` preserva os templates e confirma os nomes corretos dos assets ausentes
- a origem fisica desses arquivos provavelmente esta fora do repositorio local atual, em uma copia publicada mais completa, backup externo ou servidor funcional

## Proximo passo recomendado

Para continuar a restauracao fiel sem reconstrucao manual, a proxima fonte a verificar deve ser uma destas:

- copia publicada do servidor funcional
- backup zipado/tar fora do workspace atual
- branch antiga nao presente localmente
- snapshot de deploy do cliente

Sem uma dessas fontes, a localizacao da origem real permanece inconclusiva.
