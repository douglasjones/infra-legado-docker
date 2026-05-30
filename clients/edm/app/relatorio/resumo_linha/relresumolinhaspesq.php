<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo.php";

	$codusuario = $_SESSION['codusuario'];
	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);
	$acao = $_REQUEST['acao'];

	if(!(($acao == 'cs' && permissao('relresumolinhaspesq', 'cs')) || ($acao == 'upd' && permissao('relresumolinhaspesq', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css">
    <!--Cabeçalho-->
	<title>Relatório Resumo de Linhas</title>	
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
	<form name="dados" method="get" action="relresumolinhas.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório Resumo de Linhas	</td>
	</tr>
</table>		
<table border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td>
			&nbsp;<label  for="cod_polo">Polo:</label>
		</td>
		<td>
			<?//COMBO DE POLO
				$polo = $_SESSION['cod_polo'];
				combo::polo($polo,'');
			?>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label  >Status Lead´s:</label>
		</td>
		<td>
			<input name="led50" id="led50" type="checkbox" />50% &nbsp;
			<input name="led75" id="led75" type="checkbox" />75% &nbsp;
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="codequipe">Equipe:</label></td>
		<td>
		<? 
			combo::equipe($codequipe);
		?>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="codgerenteconta">Consultor:</label>
		</td>
		<td>
			<?	combo::consultor($GerenteContas, $NomeUsuario);?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="codAtendente">Atendente:</label></td>
		<td>
		<? 
		combo::atendente_equipe($_SESSION['codusuario']);
		?>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="dataenvioproposta">Envio da Proposta:</label>
		</td>
		<td>
			&nbsp;<label for="dataenviopropostaini">de&nbsp;</label>
			<input type="text" id="dataenviopropostaini" name="dataenviopropostaini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="dataenviopropostafim">&nbsp;até&nbsp;</label>
			<input type="text" id="dataenviopropostafim" name="dataenviopropostafim" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	<tr>
		<td colspan="3" >&nbsp;
			
		</td>
	</tr>
	<tr>
		<td colspan="3" align="center">
			<input type="button" value="Enviar" onclick="enviar()" />
			&nbsp;
			<input type="button" value="Fechar" onclick="window.close()" />&nbsp;&nbsp;
		</td>
	</tr>

	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

