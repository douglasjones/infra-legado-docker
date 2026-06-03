# Relatorio para importacao do dump do cliente Restaurante no VPS

## Objetivo

Subir para o VPS e importar o dump atualizado do banco legado do cliente `restaurante`.

## Arquivo local do dump

Caminho completo no ambiente local:

```bash
/Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/restaurante/database/wwgepr_rest_tilapia.sql.gz
```

Arquivo:

```text
wwgepr_rest_tilapia.sql.gz
```

Tamanho aproximado:

```text
1.7G
```

Banco de destino:

```text
wwgepr_rest_tilapia
```

Container MySQL esperado no compose do cliente:

```text
restaurante-mysql
```

Senha root configurada no compose local:

```text
SENHA
```

## Caminho recomendado no VPS

Copiar o arquivo para o mesmo caminho relativo do cliente no VPS:

```bash
infra-legado-docker/clients/restaurante/database/wwgepr_rest_tilapia.sql.gz
```

Se o projeto no VPS estiver em outro diretorio base, manter a mesma estrutura abaixo do diretorio base:

```bash
<DIRETORIO_BASE_DO_PROJETO>/infra-legado-docker/clients/restaurante/database/wwgepr_rest_tilapia.sql.gz
```

## Envio do arquivo para o VPS

Usar `rsync` ou `scp`. Exemplo com `rsync`:

```bash
rsync -avh --progress \
  /Volumes/HDDisco/gpros-workspace/03-clients/active/facilities/migracao/infra-legado-docker/clients/restaurante/database/wwgepr_rest_tilapia.sql.gz \
  USUARIO@IP_DO_VPS:/CAMINHO/DO/PROJETO/infra-legado-docker/clients/restaurante/database/wwgepr_rest_tilapia.sql.gz
```

Substituir:

```text
USUARIO
IP_DO_VPS
/CAMINHO/DO/PROJETO
```

pelos dados reais do VPS.

## Preparacao no VPS

Entrar no diretorio de infraestrutura do cliente:

```bash
cd /CAMINHO/DO/PROJETO/infra-legado-docker/clients/restaurante/infra
```

Subir os containers, se ainda nao estiverem rodando:

```bash
docker compose up -d
```

Conferir status:

```bash
docker compose ps
```

O esperado e:

```text
restaurante-mysql   Up / healthy
restaurante-php     Up
restaurante-nginx   Up
```

## Backup antes da importacao

Antes de importar, gerar backup do banco atual do VPS:

```bash
mkdir -p ../database/bkp
docker exec restaurante-mysql mysqldump \
  -uroot -pSENHA \
  --default-character-set=latin1 \
  wwgepr_rest_tilapia \
  | gzip > ../database/bkp/wwgepr_rest_tilapia_antes_import_$(date +%Y%m%d_%H%M%S).sql.gz
```

## Importacao do dump

O projeto ja possui script de importacao:

```bash
./scripts/import_dump.sh ../database/wwgepr_rest_tilapia.sql.gz
```

Esse script executa, na pratica:

```bash
gzip -dc ../database/wwgepr_rest_tilapia.sql.gz \
  | docker exec -i restaurante-mysql mysql \
      --default-character-set=latin1 \
      -uroot -pSENHA \
      wwgepr_rest_tilapia
```

## Validacao apos importacao

Conferir se o banco responde:

```bash
docker exec restaurante-mysql mysql -uroot -pSENHA -e "SHOW TABLES;" wwgepr_rest_tilapia
```

Conferir contagens basicas:

```bash
docker exec restaurante-mysql mysql -uroot -pSENHA wwgepr_rest_tilapia -e "
SELECT COUNT(*) AS usuarios FROM usuarios;
SELECT COUNT(*) AS colaboradores FROM colaboradores;
SELECT COUNT(*) AS leads FROM leads;
"
```

Testar a aplicacao:

```text
http://IP_OU_DOMINIO_DO_VPS:8093
```

ou a URL publica configurada no proxy do VPS.

## Observacoes importantes

- Nao apagar o dump antigo antes de validar a aplicacao.
- Confirmar espaco em disco no VPS antes da copia e da importacao, pois o arquivo compactado tem aproximadamente `1.7G` e o SQL descompactado sera maior.
- Se o banco no VPS ja tiver dados validos, manter o backup antes da importacao.
- Se a importacao falhar no meio, verificar logs do MySQL:

```bash
docker logs --tail=200 restaurante-mysql
```

- O dump deve ser importado com `--default-character-set=latin1`, conforme script existente do projeto.
