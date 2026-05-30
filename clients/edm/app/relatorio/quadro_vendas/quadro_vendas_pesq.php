<?

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.extras.php";
include_once "../../libs/cla.combo.php";

$acao = $_REQUEST['acao'];

if(!(($acao == 'cs' && permissao('quadro_vendas_pesq.php', 'cs')) || ($acao == 'upd' && permissao('quadro_vendas_pesq.php', 'al')))){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}
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
		if(!validateForm(frm)) return false
		frm.submit()
		self.close()
		return true
	}

	</script>
</head>

<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" action="quadro_vendas_res.php" target="pagina">
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
			<?	combo::polo();?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codequipe">Equipe:</label></td>
			<td>
			<?combo::equipe();?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codequipe">Data Envio Operadora:</label></td>
			<td>
				&nbsp;<label for="dataenviocontratode">de&nbsp;</&nbsp;<label>
				<input type="text" id="dataenviocontratode" name="dataenviocontratode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="datacadastroate">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="dataenviocontratoate" name="dataenviocontratoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />

			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="dataentregaaparelho">Data Entrega Aparelhos:</label></td>
			<td>
				&nbsp;<label for="dataentregaaparelhode">de&nbsp;</&nbsp;<label>
				<input type="text" id="dataentregaaparelhode" name="dataentregaaparelhode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="dataentregaaparelho">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="dataentregaaparelhoate" name="dataentregaaparelhoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
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

