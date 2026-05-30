<?php

	include_once ( "../../libs/maininclude.php" ) ;

	$sqlDescricao = "" ;
	$sqlCodigo 	  = "" ;

	if( isset( $_REQUEST['acao'] ) && !empty( $_REQUEST['acao'] ) )
	{
		$acao 	   = $_REQUEST['acao'     ] ;
		$descricao = $_REQUEST['descricao'] ;

		if ( $acao == 'ins' )
		{
			$sql = "INSERT INTO tipo_lancamento ( descricao ) VALUES ( '{$descricao}' )" ;
			sql_query( $sql ) ;
		}
		elseif( $acao == 'al'  )
		{
			$codigo = $_REQUEST['codigo'] ;

			$sql = "UPDATE tipo_lancamento
		           	   SET descricao = " . mysqlnull( $descricao ) . "
		  		 	 WHERE cod_lancamento = {$codigo}" ;

			sql_query( $sql ) ;
		}
			elseif( $acao == 'ex' )
			{
				$codigo = $_REQUEST['cod_lancamento'] ;
				$sql = "DELETE FROM tipo_lancamento WHERE cod_lancamento = {$codigo} " ;
				sql_query( $sql ) ;
			}
				elseif( $acao == 'pesq' )
				{
					$sqlDescricao = ( !empty( $descricao ) ) ? " AND descricao LIKE '%{$descricao}%'" : "" ;
					$sqlCodigo 	  = ( !empty( $_REQUEST['codigo'] ) ) ? " AND cod_lancamento = " . $_REQUEST['codigo'] : "" ;
				}

	}

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
	include_once( "../../libs/grid.php" ) ;

	$pagina = 1 ;

	if( isset( $_REQUEST['pagina'] ) )
		$pagina = $_REQUEST['pagina'] ;

	if( $pagina == 0 )
		$pagina = 1 ;

	if( isset( $_REQUEST['sql'] ) )
		$sql = $_REQUEST['sql'] ;
	else
	{
		$sql = "SELECT cod_lancamento , descricao
				  FROM  tipo_lancamento
				 WHERE 1
				  {$sqlDescricao}
				  {$sqlCodigo}
				  ORDER BY cod_lancamento" ;
	}

	$result = sql_query( $sql ) ;
	pagegrid( $sql , "cod_lancamento" , array( "Código" , "Descrição" ) , array( "cod_lancamento" , "descricao" ) , 30 , $pagina ) ;



?>


</body>
</html>
<?	include_once( "../../libs/desconectar.php" ) ; ?>