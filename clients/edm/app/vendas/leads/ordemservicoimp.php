<?
/*
/---------------------------------------------------\
|						    						|
|DESCRIÇÃO: PRINCIPAIS FUNÇÕES DO SISTEMA EM PHP    |
|						    						|
|					     	    					|
|REVISÕES:					    					|
|						    						|
|						    						| 
|DESESENVOLVIDO POR: DOUGLAS JONES LOPES	    	|
|						    						|
|DATA: 24/09/2008	     			    			|
\___________________G_E_P_R_O_S_____________________/
*/
    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.os.php";

	$codos	= $_REQUEST['codos'];
	$values = os::imprimir($codos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">

<!--Cabeçalho-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css" title="123">
body {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:9pt;
	width:auto;
	color:#333333;
}
h1, h2, h3, table, p, ul {
	page-break-before: auto;
}
th, td {
	font-size:8pt;
	border:solid 1px black;
	padding:5px;
}
th {
	background-color:#E5E5E5;
	text-align: left;
	font-weight: normal;
}
#page {
	page-break-after: always;
	background: url(http://www.bestpartner.com.br/salesmanager/images/bg_bestphone.gif) no-repeat center;
	height: 240mm;
	width: 160mm;
	text-align: justify;
}
#texto {
	font-size: 12px;
	clear: both;
}
#header1 {
	font: 12px Tahoma;
}
#header2 {
	font: 12px Tahoma;
	text-align:right;
}
hr {
	clear:both;
	width: 90%;
	margin: 10px auto;
}
#table1 {
	width: 100%;
	margin:10px auto;
}
</style>
</head>
<body>
<div id="page">
<table id="table1">
	<tbody>
		<tr>
			<td id="header1" colspan="2">Best Partner Servi&ccedil;os de Marketing e Intermedia&ccedil;&atilde;o de Neg&oacute;cios Ltda<br />R. Nova Orleans, 267, Brooklin 
CEP. 04561-030 - S&atilde;o Paulo, SP<br />
Fone: 11 2171 0001<br />
<strong>WWW.BESTPARTNER.COM.BR</strong></td>
			<td id="header2" colspan="2">C&oacute;digo da OS: <?=@$values['codos'];?><br />C&oacute;digo da Proposta: <?=@$values['codproposta'].'.'.@$values['versaoproposta'];?></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<th style=" width:25%;"><strong>Data:</strong> <?=$values['dataos'];?></th>
			<th style=" width:25%;"><strong>Per&iacute;odo:</strong> <?=$values['periodo'];?></th>
			<th style=" width:25%;"><strong>Status:</strong> <?=$values['status'];?></th>
			<th style=" width:25%;"><strong>A&ccedil;&atilde;o:</strong> <?=$values['osacao'];?></th>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<th><strong>Instalador:</strong></th>
			<td><?=$values['nomeinstalador'];?></td>
			<th><strong>Consultor:</strong></th>
			<td><?=$values['nomeconsultor'];?></td>
		</tr>
		<tr>
			<th><strong>Contato T&eacute;cnico:</strong></th>
			<td><?=$values['responsavel'];?></td>
			<th><strong>Telefone:</strong></th>
			<td><?=$values['respctt'];?></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<th><strong>Serial do Gateway:</strong></th>
			<td><?=$values['serialgateway'];?></td>
			<th><strong>Endere&ccedil;o IP:</strong></th>
			<td><?=$values['enderecoip'];?></td>
		</tr>
		<tr>
			<th><strong>Login:</strong></th>
			<td><?=$values['login'];?></td>
			<th><strong>Senha:</strong></th>
			<td><?=$values['senha'];?></td>
		</tr>
		<tr>
			<th><strong>N&ordm; de canais:</strong></th>
			<td><?=$values['canais'];?></td>
			<th><strong>Vencimento Try &amp; Buy:</strong></th>
			<td><?=$values['datatrybuyate'];?></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2"><strong>Descri&ccedil;&atilde;o:</strong></th>
			<th colspan="2"><strong>Observa&ccedil;&otilde;es:</strong></th>
		</tr>
		<tr style="height: 80px;">
			<td colspan="2"><?=$values['descinst'];?></td>
			<td colspan="2"><?=$values['observacoes'];?></td>
		</tr>
		<tr>
			<th colspan="4"><strong>Informa&ccedil;&otilde;es &Uacute;teis:</strong></th>
		</tr>
		<tr style="height: 80px;">
			<td colspan="4"><?=$values['infuteis'];?></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="4"><strong>Dados da Contratante</strong>:</th>
		</tr>
		<tr style="height: 80px;">
			<td colspan="4">
			<?=$values['ldrazaosocial'];?><br />
			<?=$values['ldendereco'];?>, <?=$values['ldnumero'];?><br />
			<?=$values['ldcidade'];?>, <?=$values['lduf'];?> - CEP: <?=$values['ldcep'];?><br />
			Fone: <?=$values['ldddd'].' '.$values['ldtel'];?>
			<?=$values['ldsite'];?>
			<br /><br /></td>
		</tr>
		<tr>
			<th colspan="2"><strong>Assinatura - Instalador:</strong></th>
			<th colspan="2"><strong>Assinatura - Respons&aacute;vel:</strong></th>
		</tr>
		<tr style="text-align: center">
			<td colspan="2"><br /><br /><br /><hr /><?=strtoupper($values['nomeinstalador']);?></td>
			<td colspan="2"><br /><br /><br /><hr /><?=strtoupper($values['responsavel']);?></td>
		</tr>
	</tbody>
</table>
</div>
<script type="text/javascript" language="javascript">
	window.print();
</script>
</body>
</html>
