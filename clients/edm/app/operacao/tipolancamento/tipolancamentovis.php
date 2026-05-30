<?php

	include_once ( "../../libs/maininclude.php" ) ;

	$titulo = "Novo Tipo de Lançamento" ;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public1.css" type="text/css">

<?	include_once( "../../libs/head.php" ) ; ?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?

	if( isset( $_REQUEST['acao'] ) && $_REQUEST['acao'] == 'al' )
	{
		$titulo = "Editar Tipos de Lançamento" ;
		$sql = "SELECT descricao FROM tipo_lancamento WHERE cod_lancamento = " . $_REQUEST['cod_lancamento'] ;
		$qry = sql_query( $sql ) ;
		$res = mysql_result( $qry , 0 , 0 ) ;
	}
	else
	{
		$acao = 'ins' ;
	}

?>

	<form name="dados" method="post" action="tipolancamento.php" onsubmit="self.close();" target="pagina">
		<input type="hidden"  name="acao" value="<?= $acao ; ?>" />
		<input type="hidden"  name="codigo" value="<?= @$_REQUEST['cod_lancamento'] ; ?>" /> <!-- var pode ou nao estar setada por isso deixei o arroba para evitar mensagens de erro -->
		<table width="100%" align="center"  height="5"  class="topo"  cellpadding="1" cellspacing="3">
			<tr>
				 <td  class="titulo">
					&nbsp;<?= $titulo ; ?>
				</td>
			</tr>
		</table>
		<table style="margin:20px 0 0 10px;"  width="380" align="center" border="0" cellpadding="0" cellspacing="0" class="form">
			<tr>
				<td width="80">Descrição:</td>
				<td><input type="text" name="descricao" size="50" maxlength="50" value="<?= @$res ; ?>" /></td>
			</tr>
			<tr>
				<td style="padding-top:30px; text-align:right;" colspan="2"><input type="submit" value="Enviar" name="enviar" /></td>
			</tr>
		</table>
	</form>
</body>
</html>
<?	include_once( "../../libs/desconectar.php" ) ; ?>