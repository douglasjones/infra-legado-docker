#!/usr/bin/env bash

set -Eeuo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${ROOT_DIR}"
docker compose logs -f "${@:-vistoriza-at-nginx vistoriza-at-php vistoriza-at-mysql}"
