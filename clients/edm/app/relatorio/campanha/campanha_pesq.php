<?

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.extras.php";
include_once "../../libs/cla.combo.php";

$acao = $_REQUEST['acao'];

if(!(($acao == 'cs' && permissao('relagendamentopesq.php', 'cs')) || ($acao == 'upd' && permissao('relagendamentopesq.php', 'al')))){
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
    <title>Relatório Campanha</title>
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

	function vai_para( id ){
		document.forms[0].action = id;
	}
	</script>
</head>

<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" action="campanha_res.php" id="formula" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório Campanhas
		</td>
	</tr>
</table>		
<table border="0" width="100%" cellpadding="1" cellspacing="0" class="form">
	<tbody>
		<tr>
			<td>
				&nbsp;<label  for="datacadastro">Campanha:</label>
			</td>
			<td>
			<?
				$sql = "Select cod_campanha, nome_campanha from campanha  ";
				combo($sql, "cod_campanha", $cod_campanha, " ", "");
			?>			
			</td>
		</tr>	
		<tr>
			<td>
				&nbsp;<label  for="datacadastro">Data de Participação na Campanha:</label>
			</td>
			<td>
				&nbsp;<label for="dt_participacaode">de&nbsp;</&nbsp;<label>
				<input type="text" id="dt_participacaode" name="dt_participacaode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="dt_participacaoate">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="dt_participacaoate" name="dt_participacaoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />				
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="Radio" name="relatorio" value="campanha_res.php" checked onclick="vai_para(this.value)"> Sintético
				<input type="Radio" name="relatorio" value="campanha_operador_res.php" onclick="vai_para(this.value)"> Analítico
			</td>
		</tr>
		<tr>
			<td colspan="2">
				&nbsp;
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

