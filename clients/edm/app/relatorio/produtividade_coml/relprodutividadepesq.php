<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo_relatorios.php";
	$codusuario = $_SESSION['codusuario'];
	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);
$acao = $_REQUEST['acao'];
if(!permissao('relprodutividadepesq.php', 'cs')){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}

?>
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css" />
<!--Cabeçalho-->
<title>Relatório de Produtividade</title>
<?	include_once "../../libs/head.php";?>
<!--Comandos Javascript-->
<script type="text/javascript" language="javascript" src="../../extras/mascaras.js"></script>
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
<form name="dados" method="get" action="relprodutividaderes.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo">
			Relatório de Produtividade Comercial
		</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="form" width="100%">
	<tbody>
	<tr>
		<td>
			&nbsp;<label  for="cod_polo">Polo:</label>
		</td>
		<td>
			<?//COMBO DE POLO
				combo::polo($_SESSION['codpolo']);
			?>
		</td>
	</tr>	
    <tr>
		<td>&nbsp;<label for="codequipe">Equipe:</label></td>
		<td>
		<? 
			combo::equipe(@$equipe);
		?>
		</td>
	</tr>
		<tr>
			<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
			<td>
				<?	combo::consultor_equipe($_SESSION['codusuario']); ?>
			</td>
		</tr>
		
		<tr>
			<td>&nbsp;<label for="faixadatasde">Período:</label></td>
			<td>
				<input type="text" id="dataini" name="dataini" onkeypress="mascara(this,datamask)" size="12" maxlength="10" value="<?= date("d/m/Y");?>" validate="datatype=date" />
				&nbsp;<label for="datastatusate">&nbsp;até&nbsp;</label>
				<input type="text" id="datafim" name="datafim" onkeypress="mascara(this,datamask)" size="12" maxlength="10" value="<?= date("d/m/Y");?>" validate="datatype=date" />
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
