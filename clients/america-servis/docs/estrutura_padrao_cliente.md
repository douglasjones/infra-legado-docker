# Estrutura Padrao do Cliente

Data: 2026-03-27

## Estrutura final

```text
clients/america-servis/
├── app/
├── source/
│   ├── tar/
│   ├── ftp/
│   └── referencias/
├── infra/
│   ├── docker/
│   ├── docker-compose.yml
│   ├── docker-compose.clean.yml
│   └── scripts/
├── database/
│   ├── dump.sql
│   ├── dump.sql.gz
│   └── import/
├── docs/
└── logs/
```

## Funcao de cada pasta

- `app/`: aplicacao ativa usada pelos containers Docker
- `source/tar/`: fonte oficial do legado vinda do tar do servidor
- `source/ftp/`: copia legada obtida por FTP, preservada apenas para referencia
- `source/referencias/`: materiais auxiliares e bases antigas mantidas apenas para consulta
- `infra/`: toda a operacao Docker do cliente, incluindo compose, Dockerfiles, nginx e scripts locais
- `database/`: dumps e apoio de importacao do banco do cliente
- `docs/`: documentacao operacional, analises, homologacoes e historico do cliente
- `logs/`: logs gerados durante importacoes, depuracoes e validacoes locais

## Fonte oficial e app ativa

Fonte oficial do cliente:

- `source/tar/americaservis/`

App ativa em Docker:

- `app/`

Base auxiliar preservada apenas para referencia:

- `source/ftp/legado-original/`
- `source/referencias/app-atual/`
- `source/referencias/appPonto/`

## Onde subir e parar o Docker

Toda a operacao deve ser feita dentro de:

- `infra/`

Comandos principais:

```bash
cd clients/america-servis/infra
docker compose up -d
docker compose down
docker compose -f docker-compose.clean.yml up -d
docker compose -f docker-compose.clean.yml down
```

## Onde ficam os dumps

Arquivos padrao do banco:

- `database/dump.sql`
- `database/dump.sql.gz`

Pasta de apoio:

- `database/import/`

Os scripts locais em `infra/scripts/` passaram a considerar `database/` como pasta padrao de dumps.

## Onde ficam docs e logs

- documentacao do cliente: `docs/`
- logs operacionais do cliente: `logs/`

## Rastreabilidade da reorganizacao

Movimentos principais executados:

- `02_workspace/app-docker` -> `app/`
- `01_fonte_legado/tar_servidor/americaservis` -> `source/tar/americaservis/`
- `01_fonte_legado/tar_servidor/americaservis_full_2026-03-26_10-41-12.tar.gz` -> `source/tar/`
- `01_fonte_legado/ftp/legado-original` -> `source/ftp/legado-original/`
- `01_fonte_legado/referencias/appPonto` -> `source/referencias/appPonto/`
- `02_workspace/app-atual` -> `source/referencias/app-atual/`
- `03_infra` -> `infra/`
- `04_database/backup/database/americaservs_full.sql` -> `database/dump.sql`
- `04_database/backup/database/americaservs_full.sql.gz` -> `database/dump.sql.gz`
- `05_docs/*` -> `docs/`
- `06_logs/logs/*` -> `logs/`

Estruturas antigas foram preservadas em pastas auxiliares de rastreabilidade, sem exclusao de conteudo.

## Ajustes de caminho aplicados

- `infra/docker-compose.yml` agora monta `../app` como raiz da aplicacao
- `infra/docker-compose.clean.yml` agora monta `../app` como raiz da aplicacao
- `infra/scripts/import_dump.sh` agora usa `../database` e `../logs`
- `infra/scripts/verificar_dump.sh` agora usa `../database/dump.sql` e `../database/dump.sql.gz`

## Checklist

- [x] existe `app/`
- [x] existe `source/tar/`
- [x] existe `source/ftp/`
- [x] existe `source/referencias/`
- [x] existe `infra/`
- [x] existe `database/`
- [x] existe `docs/`
- [x] existe `logs/`
- [x] compose aponta para `app/`
- [x] infra do cliente esta isolada em `infra/`
- [x] nada foi apagado
