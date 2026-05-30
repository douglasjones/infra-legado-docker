#!/usr/bin/env bash
set -euo pipefail

# setup-git-vps.sh (v2)
# Run on the VPS to initialize Git per client directory with a safe baseline.
#
# Usage:
#   bash scripts/setup-git-vps.sh
#   bash scripts/setup-git-vps.sh brasil-servis
#   bash scripts/setup-git-vps.sh --dry-run
#   bash scripts/setup-git-vps.sh brasil-servis --dry-run

INFRA_ROOT="/opt/gpros/infra-legado-docker"
CLIENTS_DIR="$INFRA_ROOT/clients"
LOG_FILE="$INFRA_ROOT/historico.md"
TEMPLATE_GITIGNORE="$INFRA_ROOT/modelo-git/.gitignore-php-legado"

TARGET_CLIENT=""
DRY_RUN=false
MANAGED_GITIGNORE_MARKER="# Managed by setup-git-vps.sh"

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

usage() {
  cat <<'EOF'
Usage:
  bash scripts/setup-git-vps.sh [cliente] [--dry-run]

Examples:
  bash scripts/setup-git-vps.sh
  bash scripts/setup-git-vps.sh brasil-servis
  bash scripts/setup-git-vps.sh --dry-run
EOF
}

ensure_gitignore_block() {
  local gitignore_file="$1"

  if [[ ! -f "$gitignore_file" ]]; then
    cp "$TEMPLATE_GITIGNORE" "$gitignore_file"
  fi

  if grep -Fq "$MANAGED_GITIGNORE_MARKER" "$gitignore_file"; then
    return 0
  fi

  cat >> "$gitignore_file" <<'EOF'

# Managed by setup-git-vps.sh
# Directories intentionally excluded from per-client Git on VPS
database/
source/
logs/
node_modules/
.next/

# Runtime/dependency/generated content
vendor/
storage/
public/uploads/

# Heavy legacy artifacts found in some clients
app/**/error_log
app/**/doc/
app/app/src/docs/
app/public/assets/face-api/dist/
EOF
}

while [[ $# -gt 0 ]]; do
  case "$1" in
    --dry-run)
      DRY_RUN=true
      shift
      ;;
    -h|--help)
      usage
      exit 0
      ;;
    *)
      if [[ -n "$TARGET_CLIENT" ]]; then
        echo -e "${RED}Unexpected argument: $1${NC}"
        usage
        exit 1
      fi
      TARGET_CLIENT="$1"
      shift
      ;;
  esac
done

if [[ ! -d "$CLIENTS_DIR" ]]; then
  echo -e "${RED}Directory not found: $CLIENTS_DIR${NC}"
  exit 1
fi

if [[ ! -f "$TEMPLATE_GITIGNORE" ]]; then
  echo -e "${RED}Template not found: $TEMPLATE_GITIGNORE${NC}"
  exit 1
fi

mapfile -t CLIENTS < <(
  if [[ -n "$TARGET_CLIENT" ]]; then
    printf '%s\n' "$TARGET_CLIENT"
  else
    find "$CLIENTS_DIR" -maxdepth 1 -mindepth 1 -type d \
      | xargs -I{} basename "{}" \
      | grep -v '^_' \
      | sort
  fi
)

echo -e "${BLUE}=================================================${NC}"
echo -e "${BLUE}  Gpros - Git Setup on VPS (v2)${NC}"
echo -e "${BLUE}  $(date '+%Y-%m-%d %H:%M:%S')${NC}"
if $DRY_RUN; then
  echo -e "${YELLOW}  DRY-RUN enabled${NC}"
fi
echo -e "${BLUE}=================================================${NC}"
echo

SUCCESS=()
SKIPPED=()
FAILED=()

for CLIENT in "${CLIENTS[@]}"; do
  CLIENT_DIR="$CLIENTS_DIR/$CLIENT"

  if [[ ! -d "$CLIENT_DIR" ]]; then
    echo -e "${RED}Missing directory: $CLIENT_DIR${NC}"
    FAILED+=("$CLIENT")
    continue
  fi

  echo -e "${BLUE}-------------------------------------------------${NC}"
  echo -e "${YELLOW}Processing: $CLIENT${NC}"

  if $DRY_RUN; then
    if [[ -d "$CLIENT_DIR/.git" ]]; then
      echo "  DRY-RUN: .git already exists"
    else
      echo "  DRY-RUN: would run git init -b main"
      echo "  DRY-RUN: would seed/update .gitignore with managed exclusions"
      echo "  DRY-RUN: would create baseline commit"
    fi
    SKIPPED+=("$CLIENT")
    continue
  fi

  cd "$CLIENT_DIR"

  if [[ ! -d ".git" ]]; then
    git init -b main
    git config user.email "deploy@gpros.com.br"
    git config user.name "Gpros Deploy"
  fi

  ensure_gitignore_block ".gitignore"

  git add -A
  if git diff --cached --quiet; then
    echo -e "  ${GREEN}No pending changes${NC}"
    SKIPPED+=("$CLIENT")
    continue
  fi

  FILE_COUNT=$(git diff --cached --name-only | wc -l | tr -d ' ')
  git commit -m "chore: baseline VPS state $CLIENT $(date '+%Y-%m-%d')"

  {
    echo "## [$(date '+%Y-%m-%d %H:%M')] Setup Git VPS - $CLIENT"
    echo "- Baseline/sync committed on VPS"
    echo "- Files: $FILE_COUNT"
    echo
  } >> "$LOG_FILE"

  echo -e "  ${GREEN}Committed baseline/sync with $FILE_COUNT file(s)${NC}"
  SUCCESS+=("$CLIENT")
done

echo
echo -e "${BLUE}=================================================${NC}"
echo -e "${BLUE}  FINAL REPORT${NC}"
echo -e "${BLUE}=================================================${NC}"
echo -e "${GREEN}Configured: ${#SUCCESS[@]}${NC}"
for c in "${SUCCESS[@]}"; do echo "  - $c"; done
echo -e "${YELLOW}Skipped: ${#SKIPPED[@]}${NC}"
for c in "${SKIPPED[@]}"; do echo "  - $c"; done
echo -e "${RED}Failed: ${#FAILED[@]}${NC}"
for c in "${FAILED[@]}"; do echo "  - $c"; done
