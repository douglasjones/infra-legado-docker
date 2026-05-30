<?php
    include_once ( "../../libs/maininclude.php" ) ;
	include_once ( "../../libs/grid.php" ) ;
	if( !permissao( 'produtos' , 'cs' ) )
	{
		javascriptalert( 'Você não tem permissão para acessar esta página!!!' ) ;
		exit ;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public1.css" type="text/css">
<?	include_once "../../libs/head.php";?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?	
	
	if( isset( $_REQUEST['CodEstorno'] ) && !empty( $_REQUEST['CodEstorno'] ) && isset( $_REQUEST['acao'] ) && $_REQUEST['acao'] == 'ex' ){
		$codestorno = $_REQUEST['CodEstorno'] ;
	    $sql = "SELECT TipoEstorno FROM propostas WHERE TipoEstorno = {$codestorno}" ;
	    $qry = mysql_query( $sql ) ;
	    if ( mysql_num_rows( $qry ) == 0 )
	    {
			$sql= "DELETE FROM estorno WHERE CodEstorno = {$codestorno}" ;
			mysql_query( $sql ) ;
			javascriptalert( "Operação executada com sucesso" ) ;
			exit();
	    }
	    else
	    {
	    	javascriptalert( "Erro, esse estorno já está sendo utilizado." ) ;
	    	exit() ;
	    }
	}

	$sql = "Select 
				e.codestorno
				,e.dscestorno
				,op.dsc_operador
			from estorno e 
				left join operador op on e.cod_operador = op.cod_operador
				left join empresa_operador eo on op.cod_operador = eo.cod_operador
			order by e.codestorno" ;
	$result = sql_query( $sql ) ;
	grid( $result , "codestorno" , "Código//Descrição//Operador" , "codestorno//dscestorno//dsc_operador" ) ;
	@mysql_free_result( $result ) ;
?>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
