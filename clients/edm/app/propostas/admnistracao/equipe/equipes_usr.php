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

	if(!empty($_REQUEST['codequipe']))
		$codequipe = $_REQUEST['codequipe'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">

    <!--Cabeçalho-->
	<title>Equipes</title>
	
<?	include_once "../../libs/head.php";?>
</head>
<body>
	<form name="dados" method="post" action="equipescad.php">
		<input type="hidden" name="acao" value="ins_usr" />
		<input type="hidden" name="codequipe" value="<?=$codequipe;?>" />
		<table border="0" cellpadding="0" cellspacing="0" class="form">
			<thead>
				<tr>
					<th colspan="2">Usu&aacute;rios</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><label for="descricao">Nome:</label></td>
					<td>
<?	$sql = "Select codusuariointerno AS codusr, Nome, Desativado from usuariosinternos order by Desativado, Nome;";
	$tipos[0]['valor'] = '-1';
	$tipos[1]['valor'] = 1;
	$tipos[0]['style'] = 'color:#009900';
	$tipos[1]['style'] = 'color:#990000';
	$tipos['max'] = 2;
	combo_tipos($sql, "codusr", $tipos, "", " ", null);?>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2">
						<input type="submit" value="Enviar" />
						<input type="button" value="Fechar" onclick="self.close();" />
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
