<?php

	include_once ( "../../libs/maininclude.php" ) ;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public1.css" type="text/css">

<?	include_once( "../../libs/head.php" ) ; ?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<form name="dados" method="post" action="tipolancamento.php" onsubmit="self.close();" target="pagina">
		<input type="hidden"  name="acao" value="pesq" />
		<table width="100%" align="center"  height="5"  class="topo"  cellpadding="1" cellspacing="3">
			<tr>
				 <td  class="titulo">
					&nbsp;Pesquisar Tipos de Lançamento
				</td>
			</tr>
		</table>
		<table style="margin:20px 0 0 10px;"  width="380" align="center" border="0" cellpadding="1" cellspacing="3" class="form">
			<tr>
				<td width="80">Código:</td><td><input type="text" name="codigo" size="10" maxlength="10" /></td>
			</tr>
			<tr>
				<td width="80">Descrição:</td><td><input type="text" name="descricao" size="50" maxlength="50" /></td>
			</tr>
			<tr>
				<td style="padding-top:30px; text-align:right;" colspan="2"><input type="submit" value="Enviar" name="enviar" /></td>
			</tr>
		</table>
	</form>
</body>
</html>
<?	include_once( "../../libs/desconectar.php" ) ; ?>
