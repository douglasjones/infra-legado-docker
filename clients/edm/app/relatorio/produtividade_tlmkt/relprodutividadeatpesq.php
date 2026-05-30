<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo_relatorios.php";

$acao = $_REQUEST['acao'];	
	if(!(($acao == 'cs' && permissao('relprodutividadeatpesq.php', 'cs')) || ($acao == 'upd' && permissao('relprodutividadeatpesq.php', 'al')))){
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
<form name="dados" method="get" action="relprodutividadeatres.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório de Produtividade
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
				combo::polo($_SESSION['codusuario']);
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="codAtendente">Equipe:</label></td>
		<td>
		<?combo::equipe($codequipe);?>
		</tz>
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
		<td>&nbsp;<label for="codAtendente">Status Usuário(s):</label></td>
		<td>
			<select name="statususuario">				
				<option value="">Todos</option>
				<option value="1">Ativo</option>
				<option value="2">Desativado</option>
			</select>
		</td>
	</tr>	
	<tr>
		<td>&nbsp;<label for="faixadatasde">Faixa de Datas:</label></td>
		<td>
			&nbsp;<label for="faixade">de&nbsp;</label>
			<input type="text" id="faixade" name="faixade" onkeypress="mascara(this,datamask)" size="12" value="<?= date("d/m/Y");?>"  maxlength="10" validate="datatype=date;required" />
			&nbsp;<label for="datastatusate">&nbsp;até&nbsp;</label>
			<input type="text" id="faixaate" name="faixaate" onkeypress="mascara(this,datamask)" size="12" value="<?= date("d/m/Y");?>"  maxlength="10" validate="datatype=date;required" />
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<input type="button" value="Enviar" onclick="enviar()" />
			&nbsp;
			<input type="button" value="Fechar" onclick="window.close()" />&nbsp;
		</td>
	</tr>
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

