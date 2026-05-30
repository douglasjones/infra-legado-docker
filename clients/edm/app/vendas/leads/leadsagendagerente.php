<?	
/*
/---------------------------------------------------\
|						    						|
|DESCRI&#199;&#195;O: PRINCIPAIS FUN&#199;&#213;ES DO SISTEMA EM PHP    |
|						    						|
|					     	    					|
|REVIS&#213;ES:					    					|
|						    						|
|						    						| 
|DESESENVOLVIDO POR: DOUGLAS JONES LOPES	    	|
|						    						|
|DATA: 24/07/2008	     			    			|
\____________________G_E_P_R_O_S____________________/
*/
	include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo.php";
	if(!permissao('agendagerentecontas', 'ic')){
		javascriptalert('Voc&#234; n&#227;o tem permiss&#227;o para acessar esta p&#225;gina!!!');
		exit;
	}
	$codgerenteconta = $_REQUEST['codgerenteconta'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
<head>
	<title>Gerentes Contas</title>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
function enviar(){
	var d = opener.document.forms[0]
	var frm = document.forms[0]
	var elemento = opener.document.createElement("OPTION")
	if (frm.codgerenteconta.value==""){
		alert('Selecione um Gerentede Conta !!')
		frm.codgerenteconta.focus()
		return false
	}
	elemento.value = frm.codgerenteconta.options[frm.codgerenteconta.selectedIndex].value
	elemento.text = frm.codgerenteconta.options[frm.codgerenteconta.selectedIndex].text
	try	{
		d.gerentecontas.add(elemento, null)
	}catch(e){
		d.gerentecontas.add(elemento, 0)
	}
	self.close()
}
	</script>
</head>

    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form>
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Gerentes Contas
		</td>
	</tr>
</table>			
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">

			<tbody>
				<tr>
          <td>&nbsp;
              
          </td>
    </tr>
			<tbody>
				<tr>
					<td> &nbsp;Selecione:</td>
					<td>
						<?	
						combo::consultor_equipe($_SESSION['codusuario'], $_SESSION['codusuario'], "");
						?>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
		          <td>&nbsp;
		              
		          </td>
  				  </tr>
				<tr>
					<th colspan="2" align="right">
						<input type="button" value="Enviar" onclick="enviar()" />
						&nbsp;
						<input type="button" value="Fechar" onclick="self.close()" />&nbsp;
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>