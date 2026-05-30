<?
header('Content-Type: text/html; charset=ISO-8859-1');
include_once "../../libs/maininclude.php";
include_once "../../libs/combo.php";
$leads_pk = $_REQUEST['leads_pk'];
$agendalead_pk = $_REQUEST['agendalead_pk'];

?>
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
<?include_once "../../libs/head.php";?>
<script>
	//NOVA PROPOSTA
	function add_new_proposta(leads_pk,agendalead_pk){		
		var operador_pk = document.getElementById('operador_pk').options[document.getElementById('operador_pk').selectedIndex].value			
		NewWindow("../../vendas/leads/propostas_cad_form.php?acao=ins&codlead="+leads_pk+"&agendalead_pk="+agendalead_pk+"&operador_pk="+ operador_pk, 1160, 600)	
		parent.myLytebox.end();
	}
</script>
<form name="dados" id="dados" action="seleciona_proposta.php" method="post">
    <input type="hidden" name="codlead" value="<?=$codlead;?>" />
    <input type="hidden" name="codagendalead" value="<?=$codagendalead;?>" /> 
    <table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
        <tr>
            <td class="titulo">
                Selecionar Propostas
            </td>
        </tr>
    </table>
    <table class="form" width="100%"  border="0" cellpadding="0" cellspacing="0">    
       <tr>
			<td>&nbsp;<label for="nomecontato">Proposta:</label></td>
			<td>

            <img border=0 src='../../images/adicionar.png' width=20 height=20 title="Adicionar Proposta" onClick="add_new_proposta(<?=$leads_pk;?>,<?=$agendalead_pk;?>)">&nbsp;
				<?
					$sql = "Select
								o.cod_operador operador_pk
								,o.dsc_operador
							from operador o
								inner join empresa_operador eo on o.cod_operador = eo.cod_operador";
					$sql.=" group by o.cod_operador";
					combo($sql,"operador_pk", $operador_pk, "", " ");
				?>
			</td>
		</tr>
		 
    </table>
</form>
