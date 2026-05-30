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
	if(!permissao('paginas', 'dt')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}

	$codpagina = null;
	$nome = null;
	$descricao = null;

	if (!empty($_REQUEST['codpagina'])){
		$codpagina = $_REQUEST['codpagina'];
		
		//Faz a pesquisa no banco de dados.
		$sql = "select * from paginas where codpagina = " . mysqlnull($codpagina);
		$result = sql_query($sql);
		if($row = mysql_fetch_array($result)){
			$nome = $row['Nome'];
			$descricao = $row['Descricao'];
		}
		mysql_free_result($result);
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    
    <!--Código Javascript-->
	<title>Páginas</title>
<?	include_once "../../libs/head.php";?>
</head>

<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
			<td>&nbsp;Nome:</td>
			<td><?=$nome;?></td>
		</tr>
		<tr>
			<td>&nbsp;Descrição:</td>
			<td><?=$descricao;?></td>
		</tr>
	</tbody>
		<tr>
			<td colspan="2" align="right">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="Button" class="botao" value="Fechar" onclick="self.close();" />&nbsp;
			</td>
		</tr>

</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
