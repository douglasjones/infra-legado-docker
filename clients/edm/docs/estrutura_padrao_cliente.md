# Estrutura Padrao do Cliente EDM

Data: 2026-05-15

## Estrutura

```text
clients/edm/
├── app/
├── source/
├── infra/
│   ├── docker/
│   ├── docker-compose.yml
│   └── scripts/
├── database/
├── docs/
└── logs/
```

## Fonte e banco

- Fonte oficial preservada: `source/edm_code.tar.gz`
- App ativa Docker: `app/`
- Dump oficial recebido: `database/wwgepr_edm.sql.gz`
- Banco: `wwgepr_edm`
- Usuario: `wwgepr_edm`
- Senha: `gepros15082008`

## Stack

- PHP 5.6 Apache, necessario porque o legado usa funcoes `mysql_*`.
- MySQL 5.7.
- Porta web local: `8086`.
- Porta MySQL local: `3311`.

## Ajuste minimo aplicado

O legado original usa `localhost` em `libs/conectar_info.php`.
Para Docker, o host precisa apontar para o container MySQL:

```text
edm-mysql
```

Nenhuma melhoria funcional deve ser aplicada neste cliente durante a migracao inicial.
