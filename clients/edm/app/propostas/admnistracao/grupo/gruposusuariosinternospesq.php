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
	if(!permissao('grupos', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
     <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    
    <!-- Cabeçalho -->
	<title>Pesquisar Grupos</title>
<?	include_once "../../libs/head.php";?>

    <!--Código Javascript-->
	<script type="text/javascript" language="javascript">
function enviar(){
	document.forms[0].submit();
	self.close();
}
	</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" action="gruposusuariosinternosres.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Pesquisar Grupos Usuários
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
			<td> &nbsp;Nome:</td>
			<td><input type="text" name="nome" maxlength="25" size="25" /></td>
		</tr>
	</tbody>
		<tr>
			<td colspan="2" align="right">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="button" value="Enviar" onclick="enviar()" />
				<input type="button" value="Fechar" onclick="self.close();" />&nbsp;
			</td>
		</tr>

</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
