<?
	include_once( "../../libs/maininclude.php" ) ;
	include_once( "../../libs/cla.produtos.php" ) ;

	$acao = null;
	$estorno = array();

	if( !empty( $_REQUEST['acao'] ) )
		$acao = $_REQUEST['acao'] ;
//VERIFICA O ULTIMO CODIGO DE PRODUTO POR OPERADOR	
	if ($acao == 'ins'){
		//PRODUTOS CLARO
		if($_REQUEST['cod_operador']==1){			
			$sql = "Select 
			max(e.codestorno) as codestorno
			from estorno e
			where e.cod_operador=1";
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			$codestorno= $row['codestorno'];
			$codestorno = $codestorno + 1;			
		}	
		//PRODUTOS TIM
		if($_REQUEST['cod_operador']==2){			
			$sql = "Select 
			max(e.codestorno) as codestorno
			from estorno e
			where e.cod_operador=2";
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			$codestorno= $row['codestorno'];
			$codestorno = $codestorno + 1;			
		}	
		//PRODUTOS VIVO
		if($_REQUEST['cod_operador']==3){			
			$sql = "Select 
			max(e.codestorno) as codestorno
			from estorno e
			where e.cod_operador=3";
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			$codestorno= $row['codestorno'];
			$codestorno = $codestorno + 1;		
		}	
		//PRODUTOS NEXTEL
		if($_REQUEST['cod_operador']==4){			
			$sql = "Select 
			max(e.codestorno) as codestorno
			from estorno e
			where e.cod_operador=4";
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			$codestorno= $row['codestorno'];
			$codestorno = $codestorno + 1;			
		}
	}	
	if( !empty( $_REQUEST['codestorno'] ) ){
		$estorno['CodEstorno'] = $_REQUEST['codestorno'] ;
	}else{
		$estorno['CodEstorno'] = $codestorno  ;
	}
	if( !empty( $_REQUEST['descricao'] ) )
		$estorno['DscEstorno'] = $_REQUEST['descricao'];
	//OPERADOR
	if( !empty( $_REQUEST['cod_operador'] ) )
		$estorno['cod_operador'] = $_REQUEST['cod_operador'];

	if ( $acao == 'ins' )
	{
		$sql = sqlinsert( 'estorno' , $estorno ) ;
		sql_query( $sql ) ;
		javascriptalert( 'Operação executada com sucesso.' ) ;
	}
	else if($acao == 'upd' && !empty($estorno['CodEstorno'] ) )
	{
		$sql = sqlupdate( 'estorno' , $estorno, 'CodEstorno = ' . mysqlnull( $estorno['CodEstorno'] ) ) ;
		sql_query( $sql ) ;
		javascriptalert( 'Operação executada com sucesso.' ) ;
	}

	include_once "../../libs/desconectar.php";
?>
