<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo.php";

$acao = $_REQUEST['acao'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css">
    <!--Cabeçalho-->
	<title>Oportunidades</title>
	<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		var frm = document.forms[0]
		frm.submit()
		self.close()
		return true
	}
	function carregar(){
		var frm = document.forms[0];
	}
	</script>
</head>

<!--HTML-->

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
<form name="dados" method="get" action="ocs_mailing_res.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
<tr>
	 <td  class="titulo">
		Ocorrências X Mailing
	</td>
</tr>
</table>
<table border="0" class="form" align="center" width="100%">
	<tr>
		<td>&nbsp;<label>Data Cadastro O.C.:</&nbsp;<label></td>
		<td>
			<input type="text" id="dt_ocorrencia_ini" name="dt_ocorrencia_ini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;&nbsp;até&nbsp;
			<input type="text" id="dt_ocorrencia_fim" name="dt_ocorrencia_fim" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label>Mailing:</label>
		</td>
		<td>
			<?combo::combo_mailing($mailing_pk);?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label>Usuário Cadastro:</label>
		</td>
		<td>
			<?
				$sql = "select codusuariointerno, nome from usuariosinternos where desativado = -1 order by nome asc ";
				combo($sql,"codusuariointerno", "", " ", "");	
			?>
			</select>
		</td>
	</tr>	
	<tr>
		<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
		<td>
		<?	combo::consultor_equipe($_SESSION['codusuario'], $_SESSION['codusuario'], " "); ?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="atendente">Atendente:</label></td>
		<td>
		<?	combo::atendente_equipe($_SESSION['codusuario']);?>
		</td>
	</tr>	
	<tr>
		<td colspan=2>
			&nbsp;
		</td>
	</tr>
	<tr>
		<th colspan="2">
			<input type="button" value="Enviar" onclick="enviar()" />
			&nbsp;
			<input type="button" value="Fechar" onclick="window.close()" />
		</th>
	</tr>
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

