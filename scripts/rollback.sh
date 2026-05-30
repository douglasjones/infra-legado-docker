#!/usr/bin/env bash
set -euo pipefail

# rollback.sh
# Restore a client app directory from a release tag to the VPS.
#
# Usage:
#   ./scripts/rollback.sh brasil-servis release/brasil-servis/2026-05-29-14-30-00
#   ./scripts/rollback.sh brasil-servis release/brasil-servis/2026-05-29-14-30-00 --dry-run
#   ./scripts/rollback.sh brasil-servis release/brasil-servis/2026-05-29-14-30-00 --restart

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
CLIENTS_DIR="$ROOT_DIR/clients"
CONTAINER_MAP="$ROOT_DIR/config/containers.map"

VPS_USER="${VPS_USER:-root}"
VPS_HOST="${VPS_HOST:-SEU_IP_VPS}"
VPS_BASE="${VPS_BASE:-/opt/gpros/infra-legado-docker/clients}"

CLIENT="${1:-}"
TAG_NAME="${2:-}"
DRY_RUN=false
DO_RESTART=false

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

shift $(( $# > 1 ? 2 : $# ))
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
    -h|--help)
      cat <<'EOF'
Usage:
  ./scripts/rollback.sh <cliente> <tag> [--dry-run] [--restart]
EOF
      exit 0
      ;;
    *)
      echo -e "${RED}Unexpected argument: $1${NC}"
      exit 1
      ;;
  esac
done

if [[ -z "$CLIENT" || -z "$TAG_NAME" ]]; then
  echo -e "${RED}Informe cliente e tag.${NC}"
  exit 1
fi

if [[ "$VPS_HOST" == "SEU_IP_VPS" && "$DRY_RUN" == false ]]; then
  echo -e "${RED}Configure VPS_HOST before rollback.${NC}"
  exit 1
fi

CLIENT_DIR="$CLIENTS_DIR/$CLIENT"
if [[ ! -d "$CLIENT_DIR" ]]; then
  echo -e "${RED}Client not found: $CLIENT_DIR${NC}"
  exit 1
fi

cd "$ROOT_DIR"
git rev-parse "$TAG_NAME" >/dev/null

container_name="$(awk -F= -v client="$CLIENT" '$1 == client { print $2; exit }' "$CONTAINER_MAP")"
TMP_DIR="$(mktemp -d)"
trap 'rm -rf "$TMP_DIR"' EXIT

git archive "$TAG_NAME" "clients/$CLIENT/app" | tar -x -C "$TMP_DIR"

echo -e "${BLUE}=================================================${NC}"
echo -e "${BLUE}  ROLLBACK - $CLIENT${NC}"
echo -e "${BLUE}=================================================${NC}"
echo "Tag:       $TAG_NAME"
echo "Container: ${container_name:-UNMAPPED}"
echo

if $DRY_RUN; then
  rsync -azn --delete "$TMP_DIR/clients/$CLIENT/app/" "$VPS_USER@$VPS_HOST:$VPS_BASE/$CLIENT/app/"
  exit 0
fi

rsync -az --delete "$TMP_DIR/clients/$CLIENT/app/" "$VPS_USER@$VPS_HOST:$VPS_BASE/$CLIENT/app/"

if $DO_RESTART; then
  if [[ -z "$container_name" ]]; then
    echo -e "${RED}Container not mapped. Restart aborted.${NC}"
    exit 1
  fi
  ssh "$VPS_USER@$VPS_HOST" "docker restart '$container_name'"
fi

echo -e "${GREEN}Rollback completed.${NC}"
