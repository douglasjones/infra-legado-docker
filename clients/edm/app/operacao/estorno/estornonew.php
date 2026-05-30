<?
    include_once ( "../../libs/maininclude.php" ) ;
	include_once ( "../../libs/combo.php" ) ;

	$cod_estorno = null ;
	$dsc_estorno = null ;
	$acao = "ins";

	if ( isset( $_REQUEST['CodEstorno'] ) )
	{
		$cod_estorno = $_REQUEST['CodEstorno'] ;
		$acao = "upd" ;

		$sql = "SELECT CodEstorno , DscEstorno, cod_operador FROM estorno WHERE CodEstorno = " . mysqlnull( $cod_estorno ) ;

		$result = sql_query( $sql ) ;

		$row = mysql_fetch_object( $result ) ;
		$cod_estorno = $row->CodEstorno ;
		$dsc_estorno = $row->DscEstorno ;
		$cod_operador = $row->cod_operador ;
		mysql_free_result( $result ) ;
	}
	if( ! ( ( $acao == 'ins' && permissao( 'produtos' , 'ic' ) ) || ( $acao == 'upd' && permissao( 'produtos' , 'al' ) ) ) )
	{
		javascriptalert( 'Você não tem permissão para acessar esta página!!!' ) ;
		exit ;
	}
?>

	<title>Estornos</title>
<script type="text/javascript" language="javascript">
function valida( frm )
{
	if( frm.descricao.value.length < 2 )
	{
		alert( "Preencha o campo Descrição." ) ;
		return false ;
	}
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form id="dados" method="post" action="estornocad.php" onsubmit="return valida( this );">
		<input type="hidden" name="codestorno" value="<?= $cod_estorno ; ?>" />
		<input type="hidden" name="acao" value="<?= $acao ; ?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		<td  class="titulo">
			&nbsp;Estornos
		</td>
	</tr>
</table>
<table width="100%"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td>
		&nbsp;<label for="descricao">Descrição:</label>
		</td>
		<td>
		<input type="text" id="descricao" name="descricao" maxlength="50" size="50" value="<?= $dsc_estorno ; ?>" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="operador">Operador:</label></td>
		<td>
		<?	$sql = "select
						op.cod_operador
						,op.dsc_operador
					from  operador op 
					  inner join empresa_operador eo on op.cod_operador = eo.cod_operador
					where eo.dat_canc is null
					order by op.cod_operador";
			combo($sql, "cod_operador", $cod_operador, " ", "");?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right" style="padding-top:30px;">
		<input type="submit" value="Enviar" />&nbsp;
		<input type="button" value="Fechar" onclick="self.close();" />&nbsp;
		</td>
	</tr>
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
