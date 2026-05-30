<?session_start();
include_once "libs/conectar.php";
conectar(1);
//pesquisa o nome da empresa
$sql = "select * from empresa ";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$empresa = $row['razao_social'];
$leads_pk = $row['leads_pk'];
mysql_free_result($result);

?>
<html>
<head>
	<title>Untitled</title>
<link rel="stylesheet" href="extras/public1.css" type="text/css">
<?
include_once "libs/head.php";
?>
<script>

function NewWindow(url, w, h){
	var barraWin = 25
	var x = (screen.width - (w + 9)) / 2
	var y = ((screen.height - (h + 40)) / 2) - barraWin
	var newWindow = window.open(url, "chat", "width=" + w + ", height=" + h + ", top=" + y + ", left=" + x + ", scrollbars=yes, statusbars=yes, resizable=yes,maximized=yes");
	if(window.top != window.self){
		newWindow.opener = window.top.pagina
	}else{
		newWindow.opener = window.self
	}
	return newWindow
}


function abrirChat(){
	NewWindow('http://interno.gepros1.com.br/chat/client/index.php?leads_pk=<?= $leads_pk;?>&empresa=<?= $empresa;?>', 800, 600);
}
</script>
</head>

<body background="images/barra.png" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
<table width="100%" border="0"   >
	<tr>
		<td class="font_branca" valign='baseline'  >
		<b><a href='#' onclick="javascript:abrirChat()"><font color="white">Suporte Online</font></a></b>&nbsp;&nbsp;
		Gepros | Copyright 2005&nbsp;ver.2.2 - PRODUÇÃO
		</td>
		<td valign='baseline' class="font_branca" width="33%" >
			&nbsp;
		</td>
		<td align="right" class="font_branca" >
		<?php if ($_SESSION['codusuario'] == "") {?>
		&nbsp;
		<?}else{?>
			<form method="get" action="vendas/leads/leadres.php" target="pagina">
				<label for="busca">Busca de Lead :</label> &nbsp;
				<input class="input" type="text" name="busca" id="txtbusca" size="50" />
				<input class="botao" type="submit" value="Buscar"  id="cmdbusca"/>
			</form>
		<?}?>
		</td>
	</tr>
</table>
</body>
</html>
