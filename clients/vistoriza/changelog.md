# Changelog - Vistoriza

## [2026-05-22] - Relatório de Acompanhamento de Falta

### Descrição
O relatório `getRelatorioAcompanhamentoFalta` estava listando todos os apontamentos que possuíam registro na tabela `apontamento_falta`, incluindo tipos como "Atestado", "Abono", etc., quando o esperado era listar **apenas o tipo "Falta" (tipo_apontamento_pk = 2)**.

### Arquivo alterado
- `app/src/models/AgendaColaboradorApontamento.php`

### O que foi feito
Adicionado filtro `AND a.tipo_apontamento_pk IN (2)` na cláusula WHERE da query SQL do método `getRelatorioAcompanhamentoFalta`, garantindo que apenas registros do tipo "Falta" sejam retornados no relatório.

### Código alterado
Na linha onde estava:
```sql
WHERE 1=1
```
Foi alterado para:
```sql
WHERE 1=1
  AND a.tipo_apontamento_pk IN (2)
```

### Impacto
- O relatório agora exibe **apenas** apontamentos do tipo "Falta" (código 2)
- Tipos como "Atestado" (16), "Abono" (11), etc. não aparecem mais no resultado
