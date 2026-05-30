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
 
?>
<html>

<head>

<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<title> Detalhes do Motivo </title>

<?	include_once "../../libs/head.php";?>

<form method="post" action="motivodetres.php">

<body>

Código Motivo Lead
<input type="text" name="codmotivolead" size="6" maxlenght="6"> <br>

<input type="submit" value="Enviar">
<input type="button" value="Fechar" onclick="self.close();" />
</form>
</body>
</html>

<? include_once "../../libs/desconectar.php";?>
