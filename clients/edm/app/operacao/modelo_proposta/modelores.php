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
	include_once "../../libs/grid.php";
	if(!permissao('modelosproposta', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}

	if( isset( $_REQUEST['codmodelo'] ) && !empty( $_REQUEST['codmodelo'] ) && isset( $_REQUEST['acao'] ) && $_REQUEST['acao'] == 'ex' )
	{
		$codmodelo = $_REQUEST['codmodelo'];
	    $sql = "delete from modelos where CodModelo = " . mysqlnull( $codmodelo ) ;
	    $sql_del = mysql_query( $sql ) ;
	    javascriptalert( "Operação executada com sucesso" ) ;
	}

	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Tags HTML -->
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public1.css" type="text/css">

<?	include_once "../../libs/head.php";?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?		$sql = "select 
				m.codmodelo as CodModelo
				,m.Nome
				,m.Style
				,m.Modelo
				,op.dsc_operador
			from modelos m
				left join produtos p on m.codmodelo = p.codmodelo
				left join operador op on p.cod_operador = op.cod_operador
				left join empresa_operador eo on op.cod_operador = eo.cod_operador";
				$sql .= " where  eo.dat_canc is null";
				if(!empty($_REQUEST['nome'])){
					$sql .= " and nome like '%" . mysqlnull($_REQUEST['nome']) . "%'";				
				}
				$sql .= ' group by m.codmodelo
						  Order By m.codmodelo';

	$result = sql_query($sql);
	grid($result, "CodModelo", "Código//Nome//Operador", "CodModelo//Nome//dsc_operador");
	mysql_free_result($result); ?>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
