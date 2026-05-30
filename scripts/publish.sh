#!/usr/bin/env bash
set -euo pipefail

# publish.sh (v2)
# Run on Mac/local workstation.
# Flow:
#   publish -> md5 validation -> release manifest -> tag
#
# Commands:
#   ./scripts/publish.sh brasil-servis
#   ./scripts/publish.sh brasil-servis --dry-run
#   ./scripts/publish.sh brasil-servis --restart
#   ./scripts/publish.sh brasil-servis --file app/app/src/controllers/Foo.php
#   ./scripts/publish.sh brasil-servis --audit

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
CLIENTS_DIR="$ROOT_DIR/clients"
CONFIG_DIR="$ROOT_DIR/config"
CONTAINER_MAP="$CONFIG_DIR/containers.map"
LOG_FILE="$ROOT_DIR/historico.md"

VPS_USER="${VPS_USER:-root}"
VPS_HOST="${VPS_HOST:-SEU_IP_VPS}"
VPS_BASE="${VPS_BASE:-/opt/gpros/infra-legado-docker/clients}"

CLIENT=""
DRY_RUN=false
DO_RESTART=false
AUDIT_ONLY=false
SINGLE_FILE=""
MOTIVO=""

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

usage() {
  cat <<'EOF'
Usage:
  ./scripts/publish.sh <cliente> [--dry-run] [--restart] [--file caminho] [--motivo "texto"] [--audit]

Examples:
  ./scripts/publish.sh brasil-servis
  ./scripts/publish.sh brasil-servis --dry-run
  ./scripts/publish.sh brasil-servis --audit
  ./scripts/publish.sh brasil-servis --file app/app/src/models/Colaborador.php
EOF
}

while [[ $# -gt 0 ]]; do
  case "$1" in
    --dry-run)
      DRY_RUN=true
      shift
      ;;
    --restart)
      DO_RESTART=true
      shift
      ;;
    --audit)
      AUDIT_ONLY=true
      shift
      ;;
    --file)
      SINGLE_FILE="${2:-}"
      shift 2
      ;;
    --motivo)
      MOTIVO="${2:-}"
      shift 2
      ;;
    -h|--help)
      usage
      exit 0
      ;;
    *)
      if [[ -n "$CLIENT" ]]; then
        echo -e "${RED}Unexpected argument: $1${NC}"
        usage
        exit 1
      fi
      CLIENT="$1"
      shift
      ;;
  esac
done

if [[ -z "$CLIENT" ]]; then
  usage
  exit 1
fi

if [[ "$VPS_HOST" == "SEU_IP_VPS" && "$DRY_RUN" == false ]]; then
  echo -e "${RED}Configure VPS_HOST before using publish/audit.${NC}"
  exit 1
fi

CLIENT_DIR="$CLIENTS_DIR/$CLIENT"
if [[ ! -d "$CLIENT_DIR" ]]; then
  echo -e "${RED}Client not found: $CLIENT_DIR${NC}"
  exit 1
fi

if [[ ! -f "$CONTAINER_MAP" ]]; then
  echo -e "${RED}Container map not found: $CONTAINER_MAP${NC}"
  exit 1
fi

cd "$ROOT_DIR"

resolve_container() {
  awk -F= -v client="$CLIENT" '
    $1 == client { print $2; found=1; exit }
    END { if (!found) exit 1 }
  ' "$CONTAINER_MAP"
}

local_md5() {
  local file="$1"
  if command -v md5 >/dev/null 2>&1; then
    md5 -q "$file"
  else
    md5sum "$file" | awk '{print $1}'
  fi
}

remote_md5() {
  local file="$1"
  ssh "$VPS_USER@$VPS_HOST" "if [ -f '$file' ]; then if command -v md5sum >/dev/null 2>&1; then md5sum '$file' | cut -d' ' -f1; else md5 -q '$file'; fi; fi"
}

last_release_tag() {
  git tag --list "release/${CLIENT}/*" --sort=-creatordate | head -1
}

current_commit() {
  git log -1 --pretty="%H"
}

current_commit_short() {
  git log -1 --pretty="%h"
}

current_commit_msg() {
  git log -1 --pretty="%s"
}

read_lines_into_array() {
  local __target_var="$1"
  local __line=""

  eval "$__target_var=()"
  while IFS= read -r __line; do
    eval "$__target_var+=(\"\$__line\")"
  done
}

pending_changes_for_scope() {
  git status --porcelain -- \
    "clients/$CLIENT/app" \
    "scripts/publish.sh" \
    "scripts/rollback.sh" \
    "scripts/setup-git-vps.sh" \
    "config/containers.map" \
    "docs/deploy-process-v2.md"
}

container_name="$(resolve_container || true)"

if [[ -z "$container_name" ]]; then
  container_name="UNMAPPED"
fi

if $AUDIT_ONLY; then
  echo -e "${BLUE}=================================================${NC}"
  echo -e "${BLUE}  AUDIT - $CLIENT${NC}"
  echo -e "${BLUE}=================================================${NC}"
  echo "Container:     $container_name"
  echo "Last release:  $(last_release_tag || true)"
  echo "Last commit:   $(current_commit_short) - $(current_commit_msg)"
  echo

  read_lines_into_array TRACKED_FILES < <(git ls-files "clients/$CLIENT/app" | sed "s#^clients/$CLIENT/##")
  FAIL_COUNT=0
  OK_COUNT=0
  for rel in "${TRACKED_FILES[@]}"; do
    local_file="$CLIENT_DIR/$rel"
    remote_file="$VPS_BASE/$CLIENT/$rel"
    if [[ ! -f "$local_file" ]]; then
      continue
    fi
    local_hash="$(local_md5 "$local_file")"
    remote_hash="$(remote_md5 "$remote_file")"
    if [[ "$local_hash" == "$remote_hash" && -n "$remote_hash" ]]; then
      OK_COUNT=$((OK_COUNT + 1))
    else
      FAIL_COUNT=$((FAIL_COUNT + 1))
      printf 'FAIL  %s\n' "$rel"
    fi
  done
  echo
  echo "Divergent files: $FAIL_COUNT"
  echo "Matching files:  $OK_COUNT"
  exit 0
fi

UNCOMMITTED=$(pending_changes_for_scope | wc -l | tr -d ' ')
if [[ "$UNCOMMITTED" -gt 0 ]]; then
  echo -e "${RED}There are uncommitted files in the publish scope for $CLIENT.${NC}"
  pending_changes_for_scope
  exit 1
fi

LAST_TAG="$(last_release_tag || true)"

if [[ -n "$SINGLE_FILE" ]]; then
  if [[ ! -f "$CLIENT_DIR/$SINGLE_FILE" ]]; then
    echo -e "${RED}File not found: $CLIENT_DIR/$SINGLE_FILE${NC}"
    exit 1
  fi
  read_lines_into_array FILES_TO_SYNC < <(printf '%s\n' "$SINGLE_FILE")
  FILES_TO_DELETE=()
else
  if [[ -n "$LAST_TAG" ]]; then
    read_lines_into_array FILES_TO_SYNC < <(
      git diff --diff-filter=ACMRT --name-only "$LAST_TAG" HEAD -- "clients/$CLIENT/app" \
        | sed "s#^clients/$CLIENT/##"
    )
    read_lines_into_array FILES_TO_DELETE < <(
      git diff --diff-filter=D --name-only "$LAST_TAG" HEAD -- "clients/$CLIENT/app" \
        | sed "s#^clients/$CLIENT/##"
    )
  else
    read_lines_into_array FILES_TO_SYNC < <(
      git ls-files "clients/$CLIENT/app" \
        | sed "s#^clients/$CLIENT/##"
    )
    FILES_TO_DELETE=()
  fi
fi

if [[ ${#FILES_TO_SYNC[@]} -eq 0 && ${#FILES_TO_DELETE[@]} -eq 0 ]]; then
  echo -e "${YELLOW}No files to publish for $CLIENT.${NC}"
  exit 0
fi

if [[ -z "$MOTIVO" ]]; then
  MOTIVO="$(current_commit_msg)"
fi

echo -e "${BLUE}=================================================${NC}"
echo -e "${BLUE}  PUBLISH - $CLIENT${NC}"
echo -e "${BLUE}=================================================${NC}"
echo "Branch:   $(git rev-parse --abbrev-ref HEAD)"
echo "Commit:   $(current_commit_short) - $(current_commit_msg)"
echo "Container:$container_name"
echo "Reason:   $MOTIVO"
echo

declare -a VALIDATION_ROWS=()
declare -a SYNCED_ROWS=()
VALIDATION_FAIL=false

for rel in "${FILES_TO_SYNC[@]}"; do
  [[ -z "$rel" ]] && continue
  local_file="$CLIENT_DIR/$rel"
  remote_file="$VPS_BASE/$CLIENT/$rel"

  if $DRY_RUN; then
    printf 'DRY-RUN upload %s\n' "$rel"
    VALIDATION_ROWS+=("SKIP|$rel||")
    continue
  fi

  ssh "$VPS_USER@$VPS_HOST" "mkdir -p '$(dirname "$remote_file")'"
  rsync -az --checksum "$local_file" "$VPS_USER@$VPS_HOST:$remote_file"
  local_hash="$(local_md5 "$local_file")"
  remote_hash="$(remote_md5 "$remote_file")"

  if [[ "$local_hash" == "$remote_hash" && -n "$remote_hash" ]]; then
    VALIDATION_ROWS+=("OK|$rel|$local_hash|$remote_hash")
  else
    VALIDATION_ROWS+=("FAIL|$rel|$local_hash|$remote_hash")
    VALIDATION_FAIL=true
  fi
  SYNCED_ROWS+=("$rel")
done

for rel in "${FILES_TO_DELETE[@]:-}"; do
  [[ -z "$rel" ]] && continue
  remote_file="$VPS_BASE/$CLIENT/$rel"
  if $DRY_RUN; then
    printf 'DRY-RUN delete %s\n' "$rel"
    VALIDATION_ROWS+=("SKIP_DELETE|$rel||")
    continue
  fi

  ssh "$VPS_USER@$VPS_HOST" "rm -f '$remote_file'"
  if ssh "$VPS_USER@$VPS_HOST" "[ ! -e '$remote_file' ]"; then
    VALIDATION_ROWS+=("OK_DELETE|$rel||")
  else
    VALIDATION_ROWS+=("FAIL_DELETE|$rel||")
    VALIDATION_FAIL=true
  fi
done

echo -e "${BLUE}Validation report${NC}"
for row in "${VALIDATION_ROWS[@]}"; do
  IFS='|' read -r status rel local_hash remote_hash <<< "$row"
  printf '%-11s %s\n' "$status" "$rel"
done

if $DRY_RUN; then
  echo
  echo -e "${YELLOW}Dry-run finished. Nothing was transferred.${NC}"
  exit 0
fi

if $VALIDATION_FAIL; then
  echo
  echo -e "${RED}MD5 validation failed. Release manifest and tag were not created.${NC}"
  exit 1
fi

if $DO_RESTART; then
  if [[ "$container_name" == "UNMAPPED" ]]; then
    echo -e "${RED}Container is not mapped for $CLIENT. Aborting restart.${NC}"
    exit 1
  fi
  echo
  echo -e "${BLUE}Restarting container $container_name${NC}"
  ssh "$VPS_USER@$VPS_HOST" "docker restart '$container_name'"
fi

RELEASE_DATE="$(date '+%Y-%m-%d')"
RELEASE_TIME="$(date '+%H-%M-%S')"
MANIFEST_DIR="$CLIENT_DIR/docs/releases"
MANIFEST_FILE="$MANIFEST_DIR/release-$RELEASE_DATE-$RELEASE_TIME.txt"
TAG_NAME="release/${CLIENT}/$RELEASE_DATE-$RELEASE_TIME"

if git rev-parse "$TAG_NAME" >/dev/null 2>&1; then
  echo -e "${RED}Release tag already exists: $TAG_NAME${NC}"
  exit 1
fi

mkdir -p "$MANIFEST_DIR"

{
  echo "====================================="
  echo "RELEASE MANIFEST - $CLIENT"
  echo "====================================="
  echo "Date:     $(date '+%Y-%m-%d %H:%M:%S')"
  echo "Branch:   $(git rev-parse --abbrev-ref HEAD)"
  echo "Commit:   $(current_commit_short)"
  echo "Message:  $(current_commit_msg)"
  echo "Reason:   $MOTIVO"
  echo "Operator: $(whoami)"
  echo "VPS:      $VPS_HOST"
  echo "Container: $container_name"
  echo
  echo "FILES PUBLISHED:"
  for rel in "${SYNCED_ROWS[@]}"; do
    echo "  - $rel"
  done
  for rel in "${FILES_TO_DELETE[@]:-}"; do
    [[ -n "$rel" ]] && echo "  - DELETE $rel"
  done
  echo
  echo "MD5 VALIDATION:"
  for row in "${VALIDATION_ROWS[@]}"; do
    IFS='|' read -r status rel local_hash remote_hash <<< "$row"
    printf '  - %-11s %s\n' "$status" "$rel"
    [[ -n "$local_hash" ]] && printf '      local:  %s\n' "$local_hash"
    [[ -n "$remote_hash" ]] && printf '      remote: %s\n' "$remote_hash"
  done
  echo
  echo "LAST 5 COMMITS:"
  git log -5 --pretty="  %h %ci %s"
  echo "====================================="
} > "$MANIFEST_FILE"

{
  echo "## [$(date '+%Y-%m-%d %H:%M')] Publish - $CLIENT"
  echo "- Commit: $(current_commit_short) - $(current_commit_msg)"
  echo "- Reason: $MOTIVO"
  echo "- Container: $container_name"
  echo "- Manifest: $MANIFEST_FILE"
  echo
} >> "$LOG_FILE"

git add "$MANIFEST_FILE" "$LOG_FILE"
git commit -m "chore: release manifest $CLIENT $RELEASE_DATE $RELEASE_TIME"
git tag "$TAG_NAME"

echo
echo -e "${GREEN}Publish finished successfully.${NC}"
echo "Manifest: $MANIFEST_FILE"
echo "Tag:      $TAG_NAME"
