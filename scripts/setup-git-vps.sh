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
MAX_ALLOWED_BYTES=$((100 * 1024 * 1024))

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

Safety:
  - applies .gitignore before staging
  - never stages database/source/backups/dumps/packages
  - stops when non-ignored files above 100 MB are found
EOF
}

format_bytes() {
  local bytes="$1"
  awk -v bytes="$bytes" '
    function human(x) {
      split("B KB MB GB TB", unit, " ");
      i = 1;
      while (x >= 1024 && i < 5) {
        x /= 1024;
        i++;
      }
      return sprintf("%.2f %s", x, unit[i]);
    }
    BEGIN { print human(bytes) }
  '
}

is_prohibited_path() {
  local rel="$1"
  case "$rel" in
    database/*|source/*|logs/*|tmp/*|temp/*|cache/*|uploads/*|storage/*|node_modules/*|vendor/*|public/uploads/*)
      return 0
      ;;
    backup/*|backups/*|*/backup/*|*/backups/*)
      return 0
      ;;
    app_backup*|*/app_backup*|*_backup*|*/*_backup*)
      return 0
      ;;
    *.sql|*.sql.gz|*.dump|*.tar|*.tar.gz|*.tgz|*.zip)
      return 0
      ;;
  esac
  return 1
}

find_tracked_prohibited_files() {
  local output_file="$1"
  : > "$output_file"

  while IFS= read -r rel; do
    [[ -z "$rel" ]] && continue
    if is_prohibited_path "$rel"; then
      printf '%s\n' "$rel" >> "$output_file"
    fi
  done < <(git ls-files)
}

collect_stageable_files() {
  local output_file="$1"
  local large_file_report="$2"
  local rel=""
  local size_bytes=""

  : > "$output_file"
  : > "$large_file_report"

  while IFS= read -r -d '' rel; do
    rel="${rel#./}"
    [[ -z "$rel" ]] && continue

    if is_prohibited_path "$rel"; then
      continue
    fi

    if git check-ignore -q "$rel"; then
      continue
    fi

    size_bytes="$(wc -c < "$rel" | tr -d ' ')"
    if [[ -n "$size_bytes" ]] && (( size_bytes > MAX_ALLOWED_BYTES )); then
      printf '%s|%s\n' "$size_bytes" "$rel" >> "$large_file_report"
    fi

    printf '%s\n' "$rel" >> "$output_file"
  done < <(find . -path './.git' -prune -o -type f -print0)
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
backup/
backups/
app_backup*/
*_backup*/
*.tar
*.tar.gz
*.tgz
*.zip
*.sql
*.sql.gz
*.dump
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

  STAGEABLE_FILE_LIST="$(mktemp)"
  LARGE_FILE_REPORT="$(mktemp)"
  TRACKED_PROHIBITED_REPORT="$(mktemp)"

  find_tracked_prohibited_files "$TRACKED_PROHIBITED_REPORT"
  if [[ -s "$TRACKED_PROHIBITED_REPORT" ]]; then
    echo -e "  ${RED}Tracked files matching prohibited backup/dump patterns were found.${NC}"
    sed 's/^/    - /' "$TRACKED_PROHIBITED_REPORT"
    echo "  Cleanup these tracked files manually before running setup-git-vps.sh again."
    FAILED+=("$CLIENT")
    rm -f "$STAGEABLE_FILE_LIST" "$LARGE_FILE_REPORT" "$TRACKED_PROHIBITED_REPORT"
    continue
  fi

  collect_stageable_files "$STAGEABLE_FILE_LIST" "$LARGE_FILE_REPORT"

  if [[ -s "$LARGE_FILE_REPORT" ]]; then
    echo -e "  ${RED}Large non-ignored files above 100 MB detected.${NC}"
    while IFS='|' read -r size_bytes rel; do
      printf '    - %s (%s)\n' "$rel" "$(format_bytes "$size_bytes")"
    done < "$LARGE_FILE_REPORT"

    read -r -p "  Type CONTINUE to stage these files anyway: " CONFIRM_LARGE_FILES
    if [[ "$CONFIRM_LARGE_FILES" != "CONTINUE" ]]; then
      echo "  Aborted for safety."
      FAILED+=("$CLIENT")
      rm -f "$STAGEABLE_FILE_LIST" "$LARGE_FILE_REPORT" "$TRACKED_PROHIBITED_REPORT"
      continue
    fi
  fi

  git add -u -- .
  while IFS= read -r rel; do
    [[ -n "$rel" ]] && git add -- "$rel"
  done < "$STAGEABLE_FILE_LIST"

  if git diff --cached --quiet; then
    echo -e "  ${GREEN}No pending changes${NC}"
    SKIPPED+=("$CLIENT")
    rm -f "$STAGEABLE_FILE_LIST" "$LARGE_FILE_REPORT" "$TRACKED_PROHIBITED_REPORT"
    continue
  fi

  FILE_COUNT=$(git diff --cached --name-only | wc -l | tr -d ' ')
  git commit -m "chore: baseline VPS state $CLIENT $(date '+%Y-%m-%d')"
  rm -f "$STAGEABLE_FILE_LIST" "$LARGE_FILE_REPORT" "$TRACKED_PROHIBITED_REPORT"

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
