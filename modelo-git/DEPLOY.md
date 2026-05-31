# Gpros — Guia Operacional de Deploy
## infra-legado-docker

---

## O Problema que Este Guia Resolve

Publicação parcial sem rastreabilidade:
- Arquivo A atualizado, Arquivo B esquecido
- Horas investigando se era cache, opcache, banco ou JS
- Quando na verdade era: produção diferente do local

---

## Fluxo Correto

```
Codex trabalha no Mac (branch fix/nome-da-correcao)
  ↓
git add -A && git commit -m "fix: descrição"
  ↓
git checkout main && git merge fix/nome-da-correcao
  ↓
./scripts/publish.sh brasil-servis --motivo "Correção escala colaborador"
  ↓
Release Manifest gerado automaticamente em docs/releases/
  ↓
Tag de release criada no Git
  ↓
historico.md atualizado
```

---

## Setup Inicial (fazer uma vez)

### Passo 1 — Inicializar Git na VPS (somente baseline operacional)

```bash
# Conectar na VPS
ssh root@SEU_IP_VPS

# Executar setup em lote (todos os clientes)
bash /opt/gpros/infra-legado-docker/scripts/setup-git-vps.sh

# Ou cliente específico
bash /opt/gpros/infra-legado-docker/scripts/setup-git-vps.sh brasil-servis
```

### Passo 2 — Manter o Git local/Mac como fonte de verdade

```bash
# O repositório local no Mac é a referência para deploy.
# A VPS é somente ambiente de execução.
# Não usar a VPS como origem principal de código.
```

### Passo 3 — Configurar VPS_HOST no publish.sh

```bash
# Editar scripts/publish.sh e alterar:
VPS_HOST="SEU_IP_VPS"   # ← colocar o IP real
```

### Passo 4 — Dar permissão aos scripts

```bash
chmod +x scripts/setup-git-vps.sh
chmod +x scripts/publish.sh
```

---

## Uso Diário

### Regra de segurança antes de qualquer baseline na VPS

```text
Nunca rodar git add -A em cliente legado sem validar arquivos grandes.
Nunca versionar dumps, backups, tar.gz, source original ou database.
```

### Bootstrap inicial de cliente na VPS

```bash
./scripts/bootstrap-client.sh america-servis
```

Esse fluxo cria a estrutura inicial do cliente na VPS com:

- `app/`
- `infra/`
- `database/` somente estrutura
- `docs/`
- `logs/`
- `source/`

Depois do bootstrap, use `publish.sh` apenas para atualização incremental de `app/`.

### Publicar um cliente (fluxo completo)

```bash
# Commitar primeiro — obrigatório
cd clients/brasil-servis
git add -A
git commit -m "fix: corrige recriação escala colaborador"
git checkout main
git merge fix/escala-colaborador

# Publicar
./scripts/publish.sh brasil-servis
```

Observação:

- `publish.sh` publica somente `clients/<cliente>/app/`
- `publish.sh` não cria cliente do zero
- se `app/`, `infra/` ou `infra/docker-compose.yml` não existirem na VPS, o script deve abortar

### Simular publicação sem enviar nada

```bash
./scripts/publish.sh brasil-servis --dry-run
```

### Publicar e reiniciar container

```bash
./scripts/publish.sh brasil-servis --restart
```

### Publicar arquivo específico (hotfix urgente)

```bash
./scripts/publish.sh brasil-servis --file app/app/src/controllers/AgendaColaboradorPadrao.php
```

### Passar motivo direto (sem prompt interativo)

```bash
./scripts/publish.sh brasil-servis --motivo "Correção urgente ponto folha"
```

---

## Release Manifest

Gerado automaticamente a cada publicação em:

```
clients/<cliente>/docs/releases/release-YYYY-MM-DD-HH-MM.txt
```

Conteúdo:
```
=====================================
RELEASE MANIFEST — brasil-servis
=====================================
Data:     2026-05-30 14:32:00
Branch:   main
Commit:   a3f7c12
Msg:      fix: corrige recriação escala colaborador
Motivo:   Correção urgente solicitada pelo cliente
Operador: douglas

ARQUIVOS PUBLICADOS:
  - app/app/src/controllers/AgendaColaboradorPadrao.php
  - app/app/src/models/Colaborador.php
  - app/public/assets/js/local/agenda_escala.js

HISTÓRICO RECENTE (últimos 5 commits):
  a3f7c12 2026-05-30 fix: corrige recriação escala colaborador
  ...
=====================================
```

---

## Reverter uma Publicação

```bash
# Ver tags de release disponíveis
git tag | grep release/

# Reverter para o estado de uma release anterior
git checkout release/2026-05-29-10-00 -- app/
git commit -m "hotfix: revert para release 2026-05-29"
./scripts/publish.sh brasil-servis --motivo "Rollback — instabilidade pós-deploy"
```

---

## Convenções Git

| Branch | Uso |
|--------|-----|
| `main` | Produção — o que está na VPS |
| `fix/nome` | Correção pontual do Codex |
| `feat/nome` | Nova funcionalidade |

| Prefixo de commit | Uso |
|-------------------|-----|
| `fix:` | Correção de bug |
| `feat:` | Nova funcionalidade |
| `hotfix:` | Correção urgente em produção |
| `chore:` | Ajuste de config, infraestrutura |

---

## Fonte de Verdade

```text
Git local/Mac = fonte de verdade
VPS = ambiente de execução
```

## Regra de Ouro

> **Nunca publicar sem commitar.**
> O publish.sh bloqueia se houver arquivos não commitados.
> Isso é intencional — garante que toda publicação seja rastreável.

---

## Roadmap

| Fase | O que | Quando |
|------|-------|--------|
| ✅ Fase 1 | Git obrigatório + Release Manifest | Agora |
| ✅ Fase 2 | publish.sh + rsync automatizado | Agora |
| 🔜 Fase 3 | GitHub remoto + push para repositório central | Próximo mês |
| 🔜 Fase 4 | GitHub Actions para projetos Next.js/React | Após Fase 3 |
