<?
/*___________________G_E_P_R_O_S_______________________________*/
/*   Descricao: Pagina PHP                                   */
/*   File:     Relatorio                                     */
/*-----------------------------------------------------------*/
/*   Autor:   Douglas Jones Lopes                            */
/*   Data:    33/11/2009                                     */
/*   Versao:  1.0.6.T.5T.Relatorio novo-Douglas-05/11/2009   */
/*   Descrição: Novo relatoro novo status 80                 */
/*-----------------------------------------------------------*/

    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo.php";

	$codusuario = $_SESSION['codusuario'];
	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);
	$acao = $_REQUEST['acao'];

	if(!(($acao == 'cs' && permissao('relforecast80pesq', 'cs')) || ($acao == 'upd' && permissao('relforecast80pesq', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css">
    <!--Cabeçalho-->
	<title>Relatório Forecast 80%</title>	
<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		var frm = document.forms[0]
		if(!validateForm(frm)) return false
		frm.submit()
		self.close()
		return true
	}
	</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form name="dados" method="get" action="../relatorio.php" target="pagina">
	<input type="hidden" name="dirrel" value="forecast80">
	<input type="hidden" name="pgrel" value="relforecastres80.php">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório Controle Forecast 80%	</td>
	</tr>
</table>		
<table border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td>
			&nbsp;<label  for="cod_polo">Polo:</label>
		</td>
		<td>
		<? combo::polo();?>
		</td>
	</tr>
		<tr>
			<td>&nbsp;<label for="codequipe">Equipe:</label></td>
			<td>
		<? combo::equipe($GerenteContas);?>
			</td>
		</tr>
		<tr>
				<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
					<td>
		<?	combo::consultor($GerenteContas, $NomeUsuario);?>
					</td>
				</tr>	
				
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2">
						<input type="button" value="Enviar" onclick="enviar()" />
						&nbsp;
						<input type="button" value="Fechar" onclick="window.close()" />
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

