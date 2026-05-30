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
 include_once "../../libs/combo.php";

    $codmotivolead = $_REQUEST['codmotivolead'];

    $sql = "select * from motivoslead where CodMotivoLead = '$codmotivolead'";
	$result = sql_query($sql);
	if(!($row = mysql_fetch_array($result))) {
		mysql_free_result($result);
		javascriptalert('Código de motivo inválido.');
			exit();
		}else{
	
	$mlead = $row['CodMotivoLead'];
	$descricao = $row['Descricao'];
  }
 
?>
<html>

<head>
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<?	include_once "../../libs/head.php";?>
<title> Detalhes do Motivo </title>

</head>

<body>

Código Motivo Lead:
<? echo $mlead; ?> <br>

Descricao:
<? echo $descricao; ?> <br>

</body>
</html>

<? include_once "../../libs/desconectar.php";?>
