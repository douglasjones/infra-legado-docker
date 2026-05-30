<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo_relatorios.php";
?>
<html>
<head>
    <!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css">
    <!--Cabeçalho-->
	<title>Relatório Produtividade Comercial Resumo</title>
	
<?	include_once "../../libs/head.php";?>

    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		var frm = document.forms[0]
		
		if(frm.dt_base_ini.value == ""){
			alert('Data Base Início é obrigatório');
			frm.dt_base_ini.focus();
			return false;
		}
		
		if(frm.dt_base_fim.value == ""){
			alert('Data Base Fim é obrigatório');
			frm.dt_base_fim.focus();
			return false;
		}		
		
		if(!validateForm(frm)) return false
		frm.submit()
		self.close()
		return true
	}
	</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" action="prod_comercial_resumo_res.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Produtividade Comercial Resumo
		</td>
	</tr>
</table>		
<table border="0" class="form" align='center'>
	<tbody>
		<tr>
			<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
			<td>
			<?	combo::consultor_equipe($_SESSION['codusuario'], $_SESSION['codusuario'], " "); ?>
			</td>
		</tr>		
		<tr>
			<td>&nbsp;<label>Data Base:</&nbsp;<label></td>
			<td>
				<input type="text" id="dt_base_ini" name="dt_base_ini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;&nbsp;até&nbsp;
				<input type="text" id="dt_base_fim" name="dt_base_fim" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr>
		<tr>
			<td colspan=2>
				&nbsp;
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2" align='center'>
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
