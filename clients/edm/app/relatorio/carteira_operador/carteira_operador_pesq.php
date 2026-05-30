<?
/*

 Includes

*/
    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo.php";
	$acao = $_REQUEST['acao'];
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <!--Cabeçalho-->
	<title>Relatório Carteria Operador</title>

<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
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

<form name="dados" method="get" action="carteira_operador_res.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		<th class="titulo">Carteira Operador</th>
	</tr>
</table>
	
<table border="0" cellpadding="3" cellspacing="3" class="form">
	<tbody>
		<tr>
			<td>
				<label  for="datacadastro">Polo:</label>
			</td>
			<td>
			<?//COMBO DE POLO
				combo::polo($_SESSION['codusuario']);
			?>
			</td>
		</tr>
		<tr>
			<td><label for="codgerenteconta">Consultor:</label></td>
			<td>
			<?	combo::consultor_equipe($_SESSION['codusuario']);?>
			</td>
		</tr>		
		<tr>
			<td><label for="codgerenteconta">Atendente:</label></td>
			<td>
			<?	combo::atendente_equipe($_SESSION['codusuario']);?>
			</td>
		</tr>
		<tr>
			<td valign="top">Operadora:</td>
			<td>
				<?php 				
				$sql="select op.cod_operadora codigo, op.dsc_operadora nome from operadoras op";
				combo($sql,"cod_operadora", "", " ", "");	
				?>
			</td>
		</tr>
		<tr>
			<td><label for="mailing">Mailing:</label></td>
			<td>
			<?combo::combo_mailing($mailing_pk);?>
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

<? include_once "../../libs/desconectar.php";?>

