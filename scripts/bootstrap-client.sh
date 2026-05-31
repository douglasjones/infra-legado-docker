#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
CLIENTS_DIR="$ROOT_DIR/clients"

VPS_USER="${VPS_USER:-root}"
VPS_HOST="${VPS_HOST:-SEU_IP_VPS}"
VPS_BASE="${VPS_BASE:-/opt/gpros/infra-legado-docker/clients}"

CLIENT=""
DRY_RUN=false
DO_RESTART=false

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

usage() {
  cat <<'EOF'
Usage:
  ./scripts/bootstrap-client.sh <cliente> [--dry-run] [--restart]

Purpose:
  Create the initial client structure on the VPS from the local Git source.
  This script bootstraps app/ and infra/, and creates empty database/docs/logs/source dirs.

Notes:
  - database/ is created as structure only; dumps are never copied
  - use publish.sh only after bootstrap creates the remote client structure
  - this script syncs app/ and infra/ with rsync --delete after explicit confirmation
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

if [[ "$VPS_HOST" == "SEU_IP_VPS" ]]; then
  echo -e "${RED}Configure VPS_HOST before bootstrap.${NC}"
  exit 1
fi

CLIENT_DIR="$CLIENTS_DIR/$CLIENT"
if [[ ! -d "$CLIENT_DIR" ]]; then
  echo -e "${RED}Client not found: $CLIENT_DIR${NC}"
  exit 1
fi

if [[ ! -d "$CLIENT_DIR/app" || ! -d "$CLIENT_DIR/infra" ]]; then
  echo -e "${RED}Client bootstrap source is incomplete. Expected app/ and infra/.${NC}"
  exit 1
fi

RSYNC_ARGS=(-az)
if $DRY_RUN; then
  RSYNC_ARGS+=(-n)
fi

echo -e "${BLUE}=================================================${NC}"
echo -e "${BLUE}  BOOTSTRAP - $CLIENT${NC}"
echo -e "${BLUE}=================================================${NC}"
echo "Source:   $CLIENT_DIR"
echo "Target:   $VPS_USER@$VPS_HOST:$VPS_BASE/$CLIENT"
echo "App:      clients/$CLIENT/app/"
echo "Infra:    clients/$CLIENT/infra/"
echo "Folders:  database/ docs/ logs/ source/"
echo

if ! $DRY_RUN; then
  read -r -p "Type the client name ($CLIENT) to confirm bootstrap sync: " CONFIRM_CLIENT
  if [[ "$CONFIRM_CLIENT" != "$CLIENT" ]]; then
    echo -e "${RED}Bootstrap aborted. Confirmation did not match the client name.${NC}"
    exit 1
  fi

  ssh "$VPS_USER@$VPS_HOST" "
    mkdir -p '$VPS_BASE/$CLIENT/app' \
             '$VPS_BASE/$CLIENT/infra' \
             '$VPS_BASE/$CLIENT/database' \
             '$VPS_BASE/$CLIENT/docs' \
             '$VPS_BASE/$CLIENT/logs' \
             '$VPS_BASE/$CLIENT/source'
  "
fi

rsync "${RSYNC_ARGS[@]}" --delete "$CLIENT_DIR/app/" "$VPS_USER@$VPS_HOST:$VPS_BASE/$CLIENT/app/"
rsync "${RSYNC_ARGS[@]}" --delete "$CLIENT_DIR/infra/" "$VPS_USER@$VPS_HOST:$VPS_BASE/$CLIENT/infra/"
rsync "${RSYNC_ARGS[@]}" --exclude 'releases/' "$CLIENT_DIR/docs/" "$VPS_USER@$VPS_HOST:$VPS_BASE/$CLIENT/docs/"

if $DO_RESTART; then
  echo
  echo -e "${YELLOW}Bootstrap does not restart containers automatically.${NC}"
  echo "Review the remote infra and run docker compose manually after bootstrap."
fi

echo
if $DRY_RUN; then
  echo -e "${YELLOW}Dry-run finished. Nothing was transferred.${NC}"
else
  echo -e "${GREEN}Bootstrap finished successfully.${NC}"
fi
