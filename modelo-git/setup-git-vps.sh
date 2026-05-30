#!/bin/bash
# =============================================================================
# setup-git-vps.sh
# Executa NA VPS — inicializa Git em todos os clientes de uma vez
#
# Uso:
#   bash setup-git-vps.sh
#   bash setup-git-vps.sh brasil-servis        # cliente específico
#
# O que faz:
#   1. Detecta todos os clientes em clients/ (ignora _template*)
#   2. Faz git init em cada um (seguro — não sobrescreve se já existir)
#   3. Cria .gitignore padrão PHP legado
#   4. Faz o commit de baseline com o estado atual de produção
#   5. Gera relatório do que foi feito
# =============================================================================

set -e

INFRA_ROOT="/opt/gpros/infra-legado-docker"
CLIENTS_DIR="$INFRA_ROOT/clients"
LOG_FILE="$INFRA_ROOT/historico.md"
TARGET_CLIENT="$1"  # opcional: cliente específico

# Cores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}=================================================${NC}"
echo -e "${BLUE}  Gpros — Git Setup em Lote (VPS)${NC}"
echo -e "${BLUE}  $(date '+%Y-%m-%d %H:%M:%S')${NC}"
echo -e "${BLUE}=================================================${NC}"
echo ""

# Valida diretório raiz
if [ ! -d "$CLIENTS_DIR" ]; then
  echo -e "${RED}❌ Diretório não encontrado: $CLIENTS_DIR${NC}"
  exit 1
fi

# Monta lista de clientes
if [ -n "$TARGET_CLIENT" ]; then
  CLIENTS=("$TARGET_CLIENT")
else
  mapfile -t CLIENTS < <(
    find "$CLIENTS_DIR" -maxdepth 1 -mindepth 1 -type d \
    | xargs -I{} basename {} \
    | grep -v '^_' \
    | sort
  )
fi

echo -e "${YELLOW}Clientes encontrados: ${#CLIENTS[@]}${NC}"
for c in "${CLIENTS[@]}"; do echo "  → $c"; done
echo ""

SUCCESS=()
SKIPPED=()
FAILED=()

for CLIENT in "${CLIENTS[@]}"; do
  CLIENT_DIR="$CLIENTS_DIR/$CLIENT"

  if [ ! -d "$CLIENT_DIR" ]; then
    echo -e "${RED}  ⚠️  Diretório não existe: $CLIENT — pulando${NC}"
    FAILED+=("$CLIENT")
    continue
  fi

  echo -e "${BLUE}─────────────────────────────────────────────────${NC}"
  echo -e "${YELLOW}▶ Processando: $CLIENT${NC}"

  cd "$CLIENT_DIR"

  # Já tem Git?
  if [ -d ".git" ]; then
    echo -e "  ${YELLOW}⚠️  Git já existe — atualizando com estado atual${NC}"
    git add -A
    if git diff --cached --quiet; then
      echo -e "  ${GREEN}✓  Sem mudanças pendentes — nada a commitar${NC}"
      SKIPPED+=("$CLIENT")
    else
      git commit -m "chore: sync estado atual produção $(date '+%Y-%m-%d')"
      echo -e "  ${GREEN}✓  Commit de sync realizado${NC}"
      SUCCESS+=("$CLIENT")
    fi
    continue
  fi

  # Cria .gitignore se não existir
  if [ ! -f ".gitignore" ]; then
    cat > .gitignore << 'GITIGNORE'
# Dependências PHP
vendor/

# Logs
*.log
logs/
log/

# Cache
cache/
tmp/
temp/
.cache/

# Uploads e arquivos gerados
uploads/
storage/
public/uploads/

# Dumps de banco (não versionar dumps grandes)
*.sql.gz
*.dump

# Arquivos de sistema
.DS_Store
Thumbs.db
desktop.ini

# IDE
.idea/
.vscode/
*.swp
*.swo

# Ambiente local
.env.local
.env.development

# Compilados / assets gerados (se usar build)
node_modules/
dist/
build/
GITIGNORE
    echo -e "  ${GREEN}✓  .gitignore criado${NC}"
  fi

  # Git init
  git init -b main
  echo -e "  ${GREEN}✓  git init realizado${NC}"

  # Configura identidade local (evita erro em VPS sem config global)
  git config user.email "deploy@gpros.com.br"
  git config user.name "Gpros Deploy"

  # Baseline commit
  git add -A
  FILE_COUNT=$(git diff --cached --numstat | wc -l)
  git commit -m "chore: baseline inicial $CLIENT — produção $(date '+%Y-%m-%d')"
  echo -e "  ${GREEN}✓  Baseline commitado — $FILE_COUNT arquivos${NC}"

  # Log no historico.md
  echo "## [$( date '+%Y-%m-%d %H:%M')] Setup Git — $CLIENT" >> "$LOG_FILE"
  echo "- Baseline inicial criado na VPS" >> "$LOG_FILE"
  echo "- Arquivos: $FILE_COUNT" >> "$LOG_FILE"
  echo "" >> "$LOG_FILE"

  SUCCESS+=("$CLIENT")
  echo -e "  ${GREEN}✅ $CLIENT — concluído${NC}"
done

# Relatório final
echo ""
echo -e "${BLUE}=================================================${NC}"
echo -e "${BLUE}  RELATÓRIO FINAL${NC}"
echo -e "${BLUE}=================================================${NC}"
echo -e "${GREEN}✅ Configurados: ${#SUCCESS[@]}${NC}"
for c in "${SUCCESS[@]}"; do echo "   → $c"; done

if [ ${#SKIPPED[@]} -gt 0 ]; then
  echo -e "${YELLOW}⏭  Sem mudanças: ${#SKIPPED[@]}${NC}"
  for c in "${SKIPPED[@]}"; do echo "   → $c"; done
fi

if [ ${#FAILED[@]} -gt 0 ]; then
  echo -e "${RED}❌ Falhou: ${#FAILED[@]}${NC}"
  for c in "${FAILED[@]}"; do echo "   → $c"; done
fi

echo ""
echo -e "${GREEN}Próximo passo: git clone de cada cliente no Mac${NC}"
echo -e "ssh root@VPS_IP"
echo -e "cat $LOG_FILE"
