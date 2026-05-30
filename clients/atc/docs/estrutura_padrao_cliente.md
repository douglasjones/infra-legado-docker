# Estrutura Padrao do Cliente

Data: 2026-05-05

## Estrutura final

```text
clients/atc/
├── app/
├── source/
│   └── tar/
├── infra/
│   ├── docker/
│   ├── docker-compose.yml
│   └── scripts/
├── database/
├── docs/
└── logs/
```

## Funcao de cada pasta

- `app/`: aplicacao ativa usada pelos containers Docker
- `source/tar/`: fonte oficial do legado compactada e extraida
- `infra/`: operacao Docker do cliente, incluindo compose, nginx, PHP e scripts locais
- `database/`: dumps usados na importacao do banco
- `docs/`: documentacao operacional e historico do cliente
- `logs/`: logs de importacao e validacao

## Fonte oficial e app ativa

Fonte oficial usada:

- `source/tar/atcNew/`

App ativa em Docker:

- `app/`

Observacao:

- `source/tar/atc/` existe como outra fonte no material recebido, mas nao foi usada na dockerizacao inicial porque a solicitacao indicou `atcNew` como legado dos arquivos.

## Onde subir e parar o Docker

Toda a operacao deve ser feita dentro de:

- `infra/`

Comandos principais:

```bash
cd clients/atc/infra
docker compose up -d
docker compose down
```

## Portas

- Aplicacao nginx: `http://127.0.0.1:8085`
- MySQL host: `3310`
- MySQL container: `3306`

## Banco

Banco configurado:

- `gepros1com_atc`

Credenciais do legado preservadas na aplicacao:

- usuario: `gepros1com_atc`
- senha: `gepros15082008`

Dump padronizado:

- `database/dump.sql.gz`
- `database/dump.sql`

Observacao:

- O dump original `gepros1com_atc.sql.gz` foi preservado na raiz do cliente e copiado para `database/dump.sql.gz` para seguir o processo padrao.

## Ajustes de caminho aplicados

- `infra/docker-compose.yml` monta `../app` como raiz da aplicacao.
- `infra/docker/nginx/default.conf` usa root em `/var/www/html/public`.
- `infra/scripts/import_dump.sh` usa `../database` e `../logs`.
- `app/app/settings.php` teve apenas `db.host` ajustado de `localhost` para `atc-mysql`.

## Checklist

- [x] existe `app/`
- [x] existe `source/tar/`
- [x] existe `infra/`
- [x] existe `database/`
- [x] existe `docs/`
- [x] existe `logs/`
- [x] compose aponta para `app/`
- [x] dump padronizado em `database/`
- [x] fonte oficial preservada em `source/tar/atcNew/`
