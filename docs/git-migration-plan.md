# Plano de Migração Git — infra-legado-docker

## Objetivo

Preparar o projeto `infra-legado-docker` para versionamento Git sem iniciar o repositório nesta etapa, definindo:

- escopo do que deve entrar no Git
- exclusões obrigatórias
- riscos da migração
- estratégia inicial de versionamento

## Estrutura atual

Estrutura principal identificada na raiz:

```text
infra-legado-docker/
├── clients/
├── core/
├── images/
├── modelo-git/
├── scripts/
├── README.md
├── IMPLANTAR_MACBOOK_M1.md
├── historico.md
└── processo de migração.md
```

Diretórios de clientes detectados:

```text
_template-php56
_template-php73
america-servis
atc
atc-ronda
brasil-servis
consultor
cstelefonia
edm
gt
gt-ronda
hemil
jmr
jrm-ronda
rctelefonia
restaurante
vistoriza
vistoriza_at
vs-solucoes
```

## Tamanho estimado do repositório

Volume bruto atual:

```text
infra-legado-docker/ ≈ 170G
clients/             ≈ 170G
```

Principais consumidores de espaço identificados:

```text
clients/america-servis   ≈ 63G
clients/vistoriza        ≈ 30G
clients/brasil-servis    ≈ 28G
clients/edm              ≈ 17G
clients/vistoriza_at     ≈ 14G
clients/restaurante      ≈ 7.7G
clients/atc              ≈ 2.6G
```

Distribuição interna relevante:

```text
clients/america-servis/database   ≈ 61G
clients/america-servis/source     ≈ 903M
clients/america-servis/app        ≈ 236M

clients/brasil-servis/database    ≈ 19G
clients/brasil-servis/source      ≈ 8.9G
clients/brasil-servis/app         ≈ 188M

clients/vistoriza/database        ≈ 29G
clients/vistoriza/source          ≈ 950M

clients/vistoriza_at/database     ≈ 14G
clients/vistoriza_at/app          ≈ 188M

clients/edm/app                   ≈ 10G
clients/edm/source                ≈ 6.3G
clients/edm/database              ≈ 91M
```

## Conclusão de volume

O estado atual **não é adequado** para `git init` seguido de `git add .`.

Se o repositório for criado sem saneamento:

- o histórico inicial ficará excessivamente pesado
- haverá risco de travamento local e push inviável
- o repositório ficará contaminado com dumps, tarballs, vendors e artefatos de runtime

## Diretórios e arquivos que não devem entrar no Git

### Exclusões mandatórias

```text
clients/*/database/
clients/*/logs/
clients/*/source/
clients/*/app/vendor/
clients/*/app/node_modules/
clients/*/app/.next/
clients/*/app/storage/
clients/*/app/uploads/
clients/*/app/public/uploads/
clients/*/app/public/assets/face-api/dist/
clients/*/app/**/error_log
clients/*/app/**/doc/
clients/*/app/app/src/docs/ponto/
```

### Arquivos pesados / derivados

```text
*.sql
*.sql.gz
*.dump
*.tar
*.tar.gz
*.zip
*.7z
```

### Temporários / cache / logs

```text
*.log
tmp/
temp/
cache/
.cache/
```

### IDE / sistema

```text
.DS_Store
.idea/
.vscode/
*.swp
*.swo
```

## Achados de risco

### 1. Dumps e backups de produção dentro dos clientes

Foram encontrados vários artefatos como:

```text
clients/*/database/*.sql
clients/*/database/*.sql.gz
clients/*/source/*.tar.gz
clients/*/*release*.tar.gz
```

Risco:

- vazamento de dados de produção
- repositório excessivamente pesado
- versionamento de binários sem benefício operacional

### 2. Dependências já instaladas em múltiplos clientes

Foram encontrados vários `vendor/` dentro de `app/` e dentro de cópias auxiliares em `source/`.

Risco:

- duplicação massiva de arquivos
- ruído de diff
- histórico Git desnecessariamente grande

### 3. Cópias auxiliares, rebuilds e referências históricas

Exemplos encontrados:

```text
clients/*/source/referencias/
clients/*/source/tar/
clients/*/source/bkp/
clients/*/source/tmp_analysis/
clients/*/source/tmp_rebuild/
```

Risco:

- código duplicado
- mistura entre código ativo e material de suporte
- dificuldade de saber o que é fonte de verdade

### 4. Artefatos pesados dentro de `app/`

Foram encontrados diretórios e arquivos muito grandes ainda dentro do código ativo:

```text
clients/edm/app/vendas/leads/doc        ≈ 6.5G
clients/edm/app/vendas/leads/error_log  ≈ 2.7G
clients/restaurante/app/app/src/docs/ponto ≈ 2.3G
clients/edm/app/error_log               ≈ 510M
```

Risco:

- o repositório cresce para múltiplos gigabytes mesmo sem `database/` e `source/`
- baseline inicial fica impraticável
- push para GitHub fica arriscado e lento

### 5. Clientes vazios ou placeholders

Há diretórios praticamente vazios:

```text
clients/consultor
clients/cstelefonia
clients/jrm-ronda
clients/rctelefonia
```

Risco:

- repositório com estrutura inconsistente
- diretórios sem função definida

## O que deve entrar no Git nesta fase

### Entrar

```text
README.md
IMPLANTAR_MACBOOK_M1.md
historico.md
processo de migração.md
core/
images/
scripts/
modelo-git/
clients/*/app/           (sem vendor/uploads/storage)
clients/*/docs/
clients/*/infra/         (quando existir)
clients/*/docker*        (quando existir)
clients/*/README*        (quando existir)
clients/*/changelog*     (quando existir)
```

### Não entrar

```text
clients/*/database/
clients/*/source/
clients/*/logs/
vendor/
node_modules/
artefatos de runtime
backups/tarballs/dumps
```

## Estratégia de versionamento recomendada

### Fase 1 — Repositório raiz limpo

Criar o repositório Git do `infra-legado-docker` com foco em:

- infraestrutura compartilhada
- scripts operacionais
- documentação
- código ativo dos clientes

Sem incluir:

- banco
- source histórico
- vendors
- dumps
- pacotes compactados

### Fase 2 — Padronização por cliente

Para cada cliente:

- confirmar se `app/` é a fonte real de código
- manter `docs/` versionado
- tratar `database/` fora do Git até haver política específica

### Fase 3 — Governança de banco e artefatos

Se futuramente houver necessidade de versionar SQL:

- criar uma pasta controlada apenas para migrações manuais pequenas
- não versionar dumps integrais

Exemplo futuro:

```text
clients/<cliente>/migrations/
```

em vez de:

```text
clients/<cliente>/database/
```

## Riscos de iniciar Git sem este saneamento

- repositório inicial gigante
- commit baseline de difícil manutenção
- risco de incluir dados sensíveis
- pushes lentos ou inviáveis
- histórico inutilizável para diff real de código

## Recomendação final

Antes de `git init`, adotar a proposta de `.gitignore` da raiz e revisar rapidamente se algum cliente precisa de exceção específica.

### Decisão recomendada para a Tarefa 1

```text
APROVAR a criação do repositório base apenas com:
- infraestrutura
- scripts
- documentação
- código ativo dos clientes

REPROVAR a entrada de:
- database
- source
- vendor
- dumps
- tarballs
- logs
```

## Entregáveis desta etapa

- `.gitignore` raiz proposto
- `docs/git-migration-plan.md`

## Fora de escopo nesta etapa

Não executar ainda:

```text
git init
git add
git commit
git push
```
