<?

    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo_relatorios.php";
	$codusuario = $_SESSION['codusuario'];
	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);
	$acao = $_REQUEST['acao'];
	if(!(($acao == 'cs' && permissao('relpipelineforecastpesq.php', 'cs')) || ($acao == 'upd' && permissao('relpipelineforecastpesq.php', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
?>
<html>
<head>
    <!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css">
    <!--Cabeçalho-->
	<title>Relatório de Pipeline e Forecast</title>
	
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
<form name="dados" method="get" action="relpipelineforecastres_new.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório de Pipeline e Forecast
		</td>
	</tr>
</table>		

<table border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td>
			&nbsp;<label  for="cod_polo">Polo:</label>
		</td>
		<td>
			<?//COMBO DE POLO
				combo::polo($codpolo);
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
		<td>&nbsp;<label for="mailing">Mailing:</label></td>
		<td>
				<?combo::combo_mailing($mailing_pk);?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="datastatusde">Alteração de Status:</label></td>
		<td>
		&nbsp;<label for="datastatusde">de&nbsp;</label>
		<input type="text" id="datastatusde" name="datastatusde" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		&nbsp;<label for="datastatusate">&nbsp;até&nbsp;</label>
		<input type="text" id="datastatusate" name="datastatusate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	</tbody>
	<tfoot>
	<tr>
		<th colspan="2" align="right">
			<input type="button" value="Enviar" onclick="enviar()" />
			&nbsp;
			<input type="button" value="Fechar" onclick="window.close()" />&nbsp;
		</th>
	</tr>
	</tfoot>
	</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
