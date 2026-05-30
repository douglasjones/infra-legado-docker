<?
include_once "../../libs/maininclude.php";
include_once "mailing_cla.php";
	
$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
/*if(!(($acao == 'ic' && permissao('novo_mailing', 'ic')) || ($acao == 'cs' && permissao('novo_mailing', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
}*/

if(!empty($pk)){
	$mailing = new mailing($pk);
	$pk = $mailing->getpk();
	$dsc_mailing = $mailing->getdsc_mailing();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<!--Cabeçalho-->
	<title>mailing</title>	
	<!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="JavaScript" src="mailing_cad_form.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
<form name="dados" method="post" action="mailing_cad_proc.php">
<input type='hidden' name='acao' id='acao' value='' />
<input type='hidden' name='pk' value='<?= $pk;?>' />

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
			<td  class="titulo">
			 mailing
		</td>
	</tr>
</table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="1" cellspacing="1" class="form">
	<tr>
		<td colspan="2">
			 
		</td>
	</tr>
	<tr>
		<td  width="25%">
			Mailing: 
		</td>
		<td>
			<input type='text' id='dsc_mailing' name='dsc_mailing' maxlength="40" size="30" value='<?=$dsc_mailing;?>' />
		</td>
	</tr>	
	<tr>
		<td colspan="2" align="center" >
					
			<input type='button' name='cmdEnviar' id='cmdEnviar' value="Enviar" onclick="enviar_mailing ();" />
			 
			<input type="button" name="cmdFechar" id='cmdFechar' value="Fechar" onclick="self.close()" />
		</td>
	</tr>							
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
