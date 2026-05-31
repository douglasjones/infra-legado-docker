# Deploy Process v2

## Scope

This document describes the v2 deployment scripts created for `infra-legado-docker` after the Git baseline was established at the repository root.

Source of truth:

- local Git on the Mac/workstation is the source of truth
- the VPS is the execution environment

Files delivered:

```text
scripts/setup-git-vps.sh
scripts/publish.sh
scripts/rollback.sh
config/containers.map
```

## Key changes from v1

### 1. Container map instead of heuristics

The old heuristic:

```bash
CONTAINER_NAME="${CLIENT//-servis/-php}"
```

was removed.

Container resolution now uses:

```text
config/containers.map
```

This prevents restarting the wrong runtime when client naming and container naming diverge.

### 2. MD5 validation is mandatory

`publish.sh` now validates each transferred file:

- local file hash
- remote file hash on VPS
- status per file: `OK` or `FAIL`

If any file fails validation:

- the publish exits with error
- no release manifest is created
- no tag is created

### 3. Release artifacts happen after validation

New order:

```text
publish
-> md5 validation
-> release manifest
-> tag
```

This prevents creating false release records for incomplete or divergent publishes.

### 4. Rollback script

New script:

```text
scripts/rollback.sh
```

Usage example:

```bash
./scripts/rollback.sh brasil-servis release/brasil-servis/2026-05-29-14-30-00
```

Behavior:

- exports the client `app/` directory from the release tag
- syncs it back to the VPS
- optionally restarts the mapped container

### 5. Audit mode

New command:

```bash
./scripts/publish.sh brasil-servis --audit
```

Output includes:

- divergent files
- mapped container
- last release tag
- last commit

This mode does not publish anything.

## setup-git-vps.sh

Purpose:

- initialize Git inside each client directory on the VPS
- reuse the PHP legacy `.gitignore` template
- append managed exclusions for heavy/non-versioned client directories
- create a baseline commit or sync commit if changes exist
- stop and require explicit confirmation if non-ignored files above 100 MB are found

Supports:

```bash
bash scripts/setup-git-vps.sh
bash scripts/setup-git-vps.sh brasil-servis
bash scripts/setup-git-vps.sh --dry-run
```

Safety rules:

- never run blind `git add -A` in a legacy client
- never version dumps, backups, `.tar.gz`, original `source/` or `database/`
- validate large files before accepting a baseline commit

## bootstrap-client.sh

Purpose:

- create the initial remote client structure on the VPS
- sync `app/` and `infra/` from the local Git source
- create empty `database/`, `docs/`, `logs/` and `source/` directories
- avoid copying dumps during the initial bootstrap

Usage:

```bash
./scripts/bootstrap-client.sh america-servis
./scripts/bootstrap-client.sh america-servis --dry-run
```

## publish.sh

Purpose:

- publish client `app/` files from local repo to VPS
- validate each published file by MD5
- create release manifest only after successful validation
- create client-specific release tag
- abort if the remote client structure is incomplete

Supported flags:

```text
--dry-run
--restart
--file <path>
--motivo <text>
--audit
```

Notes:

- default publish scope is the client `app/` directory
- publish incremental does not create `infra/`, `database/`, `docs/`, `logs/` or `source/`
- `--file` path is relative to the client root
- script blocks if the repository has uncommitted changes

## rollback.sh

Purpose:

- restore a client `app/` directory from a release tag

Supported flags:

```text
--dry-run
--restart
```

## Release tags

v2 uses client-specific tags:

```text
release/<cliente>/YYYY-MM-DD-HH-MM
```

Example:

```text
release/brasil-servis/2026-05-29-14-30-00
```

## Review checklist before production use

1. Validate `VPS_HOST` in local shell or export it before running `publish.sh`.
2. Review `config/containers.map` for every active client.
3. Confirm SSH access from Mac to VPS without interactive blockers.
4. Test `--dry-run` and `--audit` before first real publish.
5. Test one real publish on a lower-risk client before batch adoption.

## Not executed in this task

This task only delivered the files above.

It did **not**:

- run `setup-git-vps.sh` on the VPS
- publish any client with `publish.sh`
- execute rollback on any environment
