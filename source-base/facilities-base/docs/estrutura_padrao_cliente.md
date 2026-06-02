# Estrutura Padrao do Cliente Vistoriza AT

```text
clients/vistoriza_at/
├── app/
├── database/
│   └── gepros1com_vistoriza.sql.gz
├── docs/
├── infra/
│   ├── docker-compose.yml
│   ├── docker/
│   └── scripts/
├── logs/
└── source/
```

## Origem

- `app/`: copia da base Docker/codigo da Brasil Servis.
- `database/`: dump proprio do cliente `vistoriza_at`.
- `infra/`: Docker e scripts parametrizados para `vistoriza_at`.

## Portas

- Aplicacao: `8094:80`
- MySQL: `3317:3306`

## Banco

- Nome: `gepros1com_vistoriza`
- Usuario: `gepros1com_vistoriza`
- Senha: `gepros15082008`
