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
|DATA: 13/10/2008	     			    			|
\___________________G_E_P_R_O_S_____________________/
*/

    include_once "../../libs/maininclude.php";
	include_once "../../libs/grid.php";
	
	$codmotivolead = $_REQUEST['codmotivolead'];
	
	if(!permissao('motivos', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
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
<?	$sql = "select m.cod_menu,m.dsc_menu,s.dsc_status,ordem";
	$sql .= "   from menu m ";
	$sql .= " 	inner join status s on m.cod_status = s.cod_status";	
	$sql .= "  order by ordem";

	$result = sql_query($sql);

	grid($result, "cod_menu", "Código//Menu//Status//Ordem","cod_menu//dsc_menu//dsc_status//ordem");
	mysql_free_result($result);?>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
