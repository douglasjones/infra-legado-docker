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

	if(!permissao('gerentecontas', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>

<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public1.css" type="text/css">
<?	include_once "../../libs/head.php";?>
</head>

<!-- Comandos HTML -->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?	$sql = "select * ";
	$sql .= " from usuariosinternos ";
	$sql .= " where GerenteContas = 1 ";
	$sql .= " order by nome ";
	$result = sql_query($sql);

    //Função grid
    grid($result, "CodUsuarioInterno", "Código//Nome", "CodUsuarioInterno//Nome");
	mysql_free_result($result);?>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
