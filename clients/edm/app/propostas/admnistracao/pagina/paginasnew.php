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

	$codpagina = null;
	$nome = null;
	$descricao = null;
	$acao = "ins";

	if (!empty($_REQUEST['codpagina'])){
		$codpagina = $_REQUEST['codpagina'];
		$acao = "upd";
		
		//Faz a pesquisa no banco de dados.
		$sql = "select * from paginas where codpagina = $codpagina ";
		$result = sql_query($sql);
		if($row = mysql_fetch_array($result)){
			$nome = $row['Nome'];
			$descricao = $row['Descricao'];
		}
		mysql_free_result($result);
	}
	if(!(($acao == 'ins' && permissao('paginas', 'ic')) || ($acao == 'upd' && permissao('paginas', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">

    <!-- Cabeçalho -->
	<title>Páginas</title>
<?	include_once "../../libs/head.php";?>

</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="post" action="paginascad.php">
<input type="hidden" name="codpagina" value="<?=$codpagina;?>" />
<input type="hidden" name="acao" value="<?=$acao?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Páginas
		</td>
	</tr>
</table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tbody>
   	<tr>
          <td>
              &nbsp;
          </td>
    </tr>
		<tr>
			<td>&nbsp;<label for="nome">Nome:</label></td>
			<td><input type="text" name="nome" value="<?=$nome;?>" maxlength="50" size="25" validate="required" /></td>
		</tr>
		<tr>
			<td>&nbsp;<label for="descricao">Descrição:</label></td>
			<td><input type="text" name="descricao" value="<?=$descricao;?>" maxlength="255" size="40" validate="required" /></td>
		</tr>
	</tbody>
		<tr>
			<td colspan="2" align="right">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="submit" class="botao" value="Enviar" />
				<input type="button" class="botao" value="Fechar" onclick="self.close();" />&nbsp;
			</td>
		</tr>
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
