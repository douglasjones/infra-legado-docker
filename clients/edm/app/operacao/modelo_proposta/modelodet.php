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
	if(!permissao('modelosproposta', 'dt')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}

	$codmodelo = null;
	$nome = null;
	$style = null;
	$modelo = null;
	
	if (isset($_REQUEST['codmodelo'])){
		$codmodelo = $_REQUEST['codmodelo'];
		
		//Faz a pesquisa no banco de dados.
		$sql = "select * ";
		$sql .= " from modelos ";
		$sql .= " where CodModelo = $codmodelo";
		$result = sql_query($sql);
		if($row = mysql_fetch_array($result)){
			$nome = $row['Nome'];
			$style = $row['Style'];
			$modelo = $row['Modelo'];
		}
		mysql_free_result($result);
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Modelos</title>
<?	include_once "../../libs/head.php";?>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form id="dados">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Modulos
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
		<tr><th colspan="2">Estilo:</th></tr>
		<tr>
			<td colspan="2"><pre><?=htmlentities($style);?></pre></td>
		</tr>
		<tr><th colspan="2">Modelo:</th></tr>
		<tr>
			<td colspan="2"><pre><?=htmlentities($modelo);?></pre></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">
				<input type="button" value="Fechar" onclick="self.close();" />
			</th>
		</tr>
	</tfoot>
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
