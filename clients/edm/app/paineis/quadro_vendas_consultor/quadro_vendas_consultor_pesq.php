<?

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.extras.php";
include_once "../../libs/cla.combo.php";

$acao = $_REQUEST['acao'];

/*
if(!(($acao == 'cs' && permissao('quadro_vendas_consultor_pesq.php', 'cs')) || ($acao == 'upd' && permissao('quadro_vendas_consultor_pesq.php', 'al')))){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css" />

    <!--Cabeçalho-->
    <title>Quadro de Vendas</title>
<?	include_once "../../libs/head.php";?>

    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
	
		var frm = document.forms[0]
		var var_url = "";
		
		if(!validateForm(frm)) 
			return;
						
		//verifica se apenas uma data foi preenchida
		if(frm.recebe_assinaturade.value != "" && frm.envio_contrato_operadorade.value != ""){
			alert('Digite apenas uma data!');
			return;
		}
		
		var_url  = "quadro_vendas_consultor_res.php?";
		var_url +=  "cod_polo="+frm.cod_polo.value;
		var_url += "&codequipe="+frm.codequipe.value;
		var_url += "&recebe_assinaturade="+frm.recebe_assinaturade.value;
		var_url += "&recebe_assinaturaate="+frm.recebe_assinaturaate.value;
		var_url += "&envio_contrato_operadorade="+frm.envio_contrato_operadorade.value;
		var_url += "&envio_contrato_operadoraate="+frm.envio_contrato_operadoraate.value;
		
		window.open(var_url,"","toolbar=no,status=no,menubar=no,scrollbars=yes,width="+1200+",height="+600+",resizable=yes,maximized=yes")
		
		self.close()
	}

	</script>
</head>

<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" target="pagina" method="get" action="quadro_vendas_consultor_res.php">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Quadro de Vendas
		</td>
	</tr>
</table>		
<table border="0" width="100%" cellpadding="1" cellspacing="0" class="form">
	<tbody>
		<tr>
			<td>
				&nbsp;<label  for="datacadastro">Polo:</label>
			</td>
			<td>
				<?//COMBO DE POLO
					$polo = $_SESSION['cod_polo'];
					combo::polo($polo,'nenhum');
				?>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;<label for="codequipe">Equipe:</label>
			</td>
			<td>
				<?combo::equipe(); ?>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;<label for="dataentregaaparelho">Recebimento Assinatura:</label>
			</td>
			<td>
				&nbsp;<label for="dataentregaaparelhode">de&nbsp;</&nbsp;<label>
				<input type="text" id="recebe_assinaturade" name="recebe_assinaturade" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="dataentregaaparelho">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="recebe_assinaturaate" name="recebe_assinaturaate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr>				
		<tr>
			<td>
				&nbsp;<label for="codequipe">Envio de contrato para a Operadora:</label>
			</td>
			<td>
				&nbsp;<label for="dataenviocontratode">de&nbsp;</&nbsp;<label>
				<input type="text" id="envio_contrato_operadorade" name="envio_contrato_operadorade" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="datacadastroate">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="envio_contrato_operadoraate" name="envio_contrato_operadoraate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />

			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">
				<input type="button" value="Enviar" onclick="enviar()" />
				&nbsp;
				<input type="button" value="Fechar" onclick="window.close()" />
			</th>
		</tr>
	</tfoot>
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

