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
	if(!permissao('grupos', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">
    
<?	include_once "../../libs/head.php";?>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?	
	if( isset( $_REQUEST['codgrupousuariointerno'] ) && !empty( $_REQUEST['codgrupousuariointerno'] ) && isset( $_REQUEST['acao'] ) && $_REQUEST['acao'] == 'ex' )
	{
		
		$sql= "delete from gruposusuariosinternoswhere codgrupousuariointerno =".$_REQUEST['codgrupousuariointerno'];		 
	    $sql_del = mysql_query($sql);
	    javascriptalert("Operação executada com sucesso");	
	}

	$sql = "select codgrupousuariointerno, nome ";
	$sql .= " from gruposusuariosinternos where CodGrupoUsuarioInterno > 0 ";
	if (!empty($_REQUEST['nome']))
		$sql .= " and Nome Like " . mysqlnull("%{$_REQUEST['nome']}%");

	$sql .= " order by codgrupousuariointerno,nome";
	$result = sql_query($sql);
	grid($result, "codgrupousuariointerno", "Código//Nome", "codgrupousuariointerno//nome");?>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
