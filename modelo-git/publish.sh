#!/bin/bash
# =============================================================================
# publish.sh
# Executa NO MAC LOCAL — substitui SCP manual
#
# Uso:
#   ./scripts/publish.sh brasil-servis
#   ./scripts/publish.sh brasil-servis --dry-run        # simula sem subir
#   ./scripts/publish.sh brasil-servis --file app/app/src/controllers/Foo.php
#   ./scripts/publish.sh brasil-servis --restart        # reinicia container após
#
# O que faz:
#   1. Valida que há commit no Git (bloqueia publicação sem rastreabilidade)
#   2. Detecta arquivos modificados desde o último publish
#   3. Sincroniza via rsync (só o que mudou)
#   4. Gera Release Manifest automático em docs/releases/
#   5. Registra em historico.md
#   6. Reinicia container se --restart
# =============================================================================

set -e

# ─── Configuração — ajuste aqui ───────────────────────────────────────────────
VPS_USER="root"
VPS_HOST="SEU_IP_VPS"                          # ← altere
VPS_BASE="/opt/gpros/infra-legado-docker/clients"
LOCAL_BASE="$(cd "$(dirname "$0")/.." && pwd)/clients"
INFRA_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
LOG_FILE="$INFRA_ROOT/historico.md"
# ─────────────────────────────────────────────────────────────────────────────

# Cores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Flags
CLIENT=""
DRY_RUN=false
SINGLE_FILE=""
DO_RESTART=false
MOTIVO=""

# Parse argumentos
while [[ $# -gt 0 ]]; do
  case $1 in
    --dry-run)   DRY_RUN=true; shift ;;
    --restart)   DO_RESTART=true; shift ;;
    --file)      SINGLE_FILE="$2"; shift 2 ;;
    --motivo)    MOTIVO="$2"; shift 2 ;;
    *)           CLIENT="$1"; shift ;;
  esac
done

# Validações básicas
if [ -z "$CLIENT" ]; then
  echo -e "${RED}❌ Informe o cliente.${NC}"
  echo "Uso: ./scripts/publish.sh brasil-servis [--dry-run] [--restart] [--file caminho] [--motivo 'descrição']"
  exit 1
fi

CLIENT_DIR="$LOCAL_BASE/$CLIENT"

if [ ! -d "$CLIENT_DIR" ]; then
  echo -e "${RED}❌ Cliente não encontrado: $CLIENT_DIR${NC}"
  exit 1
fi

cd "$CLIENT_DIR"

# ─── Validação Git obrigatória ────────────────────────────────────────────────
if [ ! -d ".git" ]; then
  echo -e "${RED}❌ Git não inicializado em $CLIENT${NC}"
  echo "Execute primeiro: bash scripts/setup-git-vps.sh $CLIENT"
  exit 1
fi

# Bloqueia publicação se houver arquivos não commitados
UNCOMMITTED=$(git status --porcelain | wc -l | tr -d ' ')
if [ "$UNCOMMITTED" -gt 0 ]; then
  echo -e "${RED}❌ Há $UNCOMMITTED arquivo(s) não commitado(s) em $CLIENT${NC}"
  echo ""
  git status --short
  echo ""
  echo -e "${YELLOW}Faça o commit antes de publicar:${NC}"
  echo "  cd $CLIENT_DIR"
  echo "  git add -A"
  echo "  git commit -m 'fix: descrição da correção'"
  exit 1
fi

# Captura info do commit atual
COMMIT_HASH=$(git log -1 --pretty="%h")
COMMIT_MSG=$(git log -1 --pretty="%s")
COMMIT_DATE=$(git log -1 --pretty="%ci")
BRANCH=$(git rev-parse --abbrev-ref HEAD)

# ─── Detecta arquivos modificados ─────────────────────────────────────────────
# Compara com o último tag de release, ou todos os arquivos se não houver tag
LAST_TAG=$(git tag --sort=-creatordate | grep "^release/" | head -1)
if [ -n "$LAST_TAG" ]; then
  CHANGED_FILES=$(git diff --name-only "$LAST_TAG" HEAD)
else
  CHANGED_FILES=$(git log --name-only --pretty=format: | sort -u | grep -v '^$')
fi

# ─── Header ──────────────────────────────────────────────────────────────────
echo -e "${BLUE}=================================================${NC}"
echo -e "${BLUE}  Gpros Publish — $CLIENT${NC}"
if $DRY_RUN; then
  echo -e "${YELLOW}  MODO DRY-RUN (simulação — nada será enviado)${NC}"
fi
echo -e "${BLUE}  $(date '+%Y-%m-%d %H:%M:%S')${NC}"
echo -e "${BLUE}=================================================${NC}"
echo ""
echo -e "  Branch:  ${YELLOW}$BRANCH${NC}"
echo -e "  Commit:  ${YELLOW}$COMMIT_HASH${NC} — $COMMIT_MSG"
echo ""

# ─── Solicita motivo se não informado ─────────────────────────────────────────
if [ -z "$MOTIVO" ]; then
  echo -e "${YELLOW}Descreva o motivo da publicação (Enter para usar mensagem do commit):${NC}"
  read -r MOTIVO_INPUT
  MOTIVO="${MOTIVO_INPUT:-$COMMIT_MSG}"
fi

# ─── Execução do publish ──────────────────────────────────────────────────────
RSYNC_FLAGS="-avz --checksum"
EXCLUDES="--exclude='.git' --exclude='vendor/' --exclude='*.log' --exclude='logs/' --exclude='cache/' --exclude='uploads/' --exclude='*.sql.gz'"

if $DRY_RUN; then
  RSYNC_FLAGS="$RSYNC_FLAGS --dry-run"
fi

echo -e "${BLUE}▶ Sincronizando arquivos...${NC}"

if [ -n "$SINGLE_FILE" ]; then
  # Arquivo específico
  echo -e "  Arquivo: ${YELLOW}$SINGLE_FILE${NC}"
  if ! $DRY_RUN; then
    scp "$CLIENT_DIR/$SINGLE_FILE" "$VPS_USER@$VPS_HOST:$VPS_BASE/$CLIENT/$SINGLE_FILE"
  fi
  SYNCED_FILES="$SINGLE_FILE"
else
  # Pacote completo via rsync
  RSYNC_OUTPUT=$(eval rsync $RSYNC_FLAGS $EXCLUDES \
    "$CLIENT_DIR/app/" \
    "$VPS_USER@$VPS_HOST:$VPS_BASE/$CLIENT/app/" 2>&1)
  echo "$RSYNC_OUTPUT" | grep -E "^(sending|>f)" | head -30 || true
  SYNCED_FILES=$(echo "$RSYNC_OUTPUT" | grep "^>f" | awk '{print $2}' | tr '\n' '\n')
fi

SYNC_COUNT=$(echo "$SYNCED_FILES" | grep -c . || echo 0)
echo -e "${GREEN}✓  $SYNC_COUNT arquivo(s) sincronizado(s)${NC}"

# ─── Restart do container ─────────────────────────────────────────────────────
CONTAINER_NAME="${CLIENT//-servis/-php}"   # heurística: brasil-servis → brasil-php
if $DO_RESTART && ! $DRY_RUN; then
  echo ""
  echo -e "${BLUE}▶ Reiniciando container: $CONTAINER_NAME${NC}"
  ssh "$VPS_USER@$VPS_HOST" "docker restart $CONTAINER_NAME 2>/dev/null && echo OK || echo 'Container não encontrado: $CONTAINER_NAME'"
  echo -e "${GREEN}✓  Container reiniciado${NC}"
fi

# ─── Gera Release Manifest ────────────────────────────────────────────────────
if ! $DRY_RUN; then
  RELEASE_DATE=$(date '+%Y-%m-%d')
  RELEASE_TIME=$(date '+%H-%M')
  MANIFEST_DIR="$CLIENT_DIR/docs/releases"
  mkdir -p "$MANIFEST_DIR"
  MANIFEST_FILE="$MANIFEST_DIR/release-$RELEASE_DATE-$RELEASE_TIME.txt"

  cat > "$MANIFEST_FILE" << MANIFEST
=====================================
RELEASE MANIFEST — $CLIENT
=====================================
Data:     $(date '+%Y-%m-%d %H:%M:%S')
Branch:   $BRANCH
Commit:   $COMMIT_HASH
Msg:      $COMMIT_MSG
Motivo:   $MOTIVO
Operador: $(whoami)
VPS:      $VPS_HOST

ARQUIVOS PUBLICADOS:
$(echo "$SYNCED_FILES" | sed 's/^/  - /' | head -100)

HISTÓRICO RECENTE (últimos 5 commits):
$(git log -5 --pretty="  %h %ci %s")
=====================================
MANIFEST

  echo ""
  echo -e "${GREEN}✓  Release Manifest gerado:${NC}"
  echo -e "   $MANIFEST_FILE"

  # Commita o manifest automaticamente
  git add "$MANIFEST_FILE"
  git commit -m "chore: release manifest $RELEASE_DATE $RELEASE_TIME"

  # Tag de release
  TAG_NAME="release/$RELEASE_DATE-$RELEASE_TIME"
  git tag "$TAG_NAME"
  echo -e "${GREEN}✓  Tag criada: $TAG_NAME${NC}"

  # Registra no historico.md global
  echo "" >> "$LOG_FILE"
  echo "## [$RELEASE_DATE $RELEASE_TIME] Publish — $CLIENT" >> "$LOG_FILE"
  echo "- Commit: $COMMIT_HASH — $COMMIT_MSG" >> "$LOG_FILE"
  echo "- Motivo: $MOTIVO" >> "$LOG_FILE"
  echo "- Arquivos: $SYNC_COUNT" >> "$LOG_FILE"
  echo "- Manifest: $MANIFEST_FILE" >> "$LOG_FILE"
fi

# ─── Resumo final ─────────────────────────────────────────────────────────────
echo ""
echo -e "${BLUE}=================================================${NC}"
if $DRY_RUN; then
  echo -e "${YELLOW}  DRY-RUN concluído — nenhum arquivo enviado${NC}"
else
  echo -e "${GREEN}  ✅ Publish concluído — $CLIENT${NC}"
fi
echo -e "${BLUE}=================================================${NC}"
echo ""

if $DRY_RUN; then
  echo -e "${YELLOW}Para publicar de verdade:${NC}"
  echo "  ./scripts/publish.sh $CLIENT"
fi
