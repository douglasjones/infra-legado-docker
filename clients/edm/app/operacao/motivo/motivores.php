<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/grid.php";

	$codmotivolead = $_REQUEST['codmotivolead'];

	if(!permissao('motivos', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}

	if( isset( $_REQUEST['codmotivolead'] ) && !empty( $_REQUEST['codmotivolead'] ) && isset( $_REQUEST['acao'] ) && $_REQUEST['acao'] == 'ex' )
	{
		$codmotivolead = $_REQUEST['codmotivolead'] ;

		$sql = "Select codlead from leads where CodMotivo = " . mysqlnull( $codmotivolead ) ;
		$rs = sql_query( $sql ) ;
		if( mysql_fetch_array( $rs ) )
		{
			javascriptalert('Motivo está sendo utilizado.');
			exit();
		}
		mysql_free_result( $rs ) ;

		$sql = "Select codproposta from propostas where CodMotivo = " . mysqlnull( $codmotivolead );
		$rs  = sql_query( $sql ) ;
		if( mysql_fetch_array( $rs ) )
		{
			javascriptalert('Motivo está sendo utilizado.');
			exit();
		}
		mysql_free_result( $rs ) ;

		$sql = "delete from motivoslead where codmotivolead = {$codmotivolead}" ;
		
		mysql_query( $sql ) ;

		javascriptalert('Operação executada com sucesso.') ;
	}

	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?	include_once "../../libs/head.php";?>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public1.css" type="text/css">
</head>

<!--Tags HTML-->

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form action="motivodet.php">
<?	$sql = "select
				m.CodMotivoLead
				,m.Descricao
				,op.dsc_operador
			from motivoslead  m
				left join operador op on m.cod_operador = op.cod_operador
				left join empresa_operador eo on op.cod_operador = eo.cod_operador
			order by m.CodMotivoLead";
	$result = sql_query($sql);
	grid($result, "CodMotivoLead", "Código//Descrição//Operador", "CodMotivoLead//Descricao//dsc_operador");
	mysql_free_result($result);?>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
