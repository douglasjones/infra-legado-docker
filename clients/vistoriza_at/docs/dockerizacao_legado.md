# Dockerizacao do Legado Vistoriza AT

Cliente: `vistoriza_at`

Base de codigo adotada: `clients/brasil-servis/app`

Dump do banco: `database/gepros1com_vistoriza.sql.gz`

## Ambiente Docker

- PHP: `vistoriza-at-php`
- Nginx: `vistoriza-at-nginx`
- MySQL: `vistoriza-at-mysql`
- HTTP local: `http://127.0.0.1:8094`
- MySQL local: `127.0.0.1:3317`
- Banco: `gepros1com_vistoriza`
- Usuario: `gepros1com_vistoriza`

## Como subir

```bash
cd clients/vistoriza_at/infra
./scripts/up.sh
```

## Como importar o dump

```bash
cd clients/vistoriza_at/infra
./scripts/import_dump.sh
```

O script usa por padrao o dump `../database/gepros1com_vistoriza.sql.gz`.

## Observacoes

- O codigo foi copiado da base migrada da Brasil Servis.
- As configuracoes de banco no `app/app/settings.php` usam variaveis do Docker quando disponiveis.
- A importacao materializa `database/dump.sql` ao descompactar o dump compactado.
