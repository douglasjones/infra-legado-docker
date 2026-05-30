<?
/*___________________G_E_P_R_O_S_______________________________*/
/*   Descricao: Pagina PHP                                   */
/*   File:     Relatorio                                     */
/*-----------------------------------------------------------*/
/*   Autor:   Alex Andrade                                   */
/*   Data:    33/11/2009                                     */
/*   Versao:  1.0.6.T.5T.Relatorio novo-Alex-05/11/2009      */
/*   Descrição: Novo Relatório quantidade de linhas e tipo 
     de linhas                                               */
/*-----------------------------------------------------------*/

    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo.php";

	$codusuario = $_SESSION['codusuario'];
	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);
	$acao = $_REQUEST['acao'];

	if(!(($acao == 'cs' && permissao('relresumolinhaspesq', 'cs')) || ($acao == 'upd' && permissao('relresumolinhaspesq', 'al')))){
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
	<input type="hidden" name="dirrel" value="linhas_ativas">
	<input type="hidden" name="pgrel" value="rellinhas_ativas.php">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório Linhas Ativas
         </td>
	</tr>
</table>	
<table border="0" class="form"  cellpadding="0" cellspacing="0">	
	<tr>
		<td>
			&nbsp;<label  for="cod_polo">Polo:</label>
		</td>
		<td>
		<? combo::polo();?>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label>Equipe(s):</label>
		</td>
		<td>
			<? combo::equipe($GerenteContas);?>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="codgerenteconta">Consultor:</label>
		</td>
		<td>
			<?	combo::consultor($GerenteContas, $NomeUsuario);?>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="data">Faixa data de ativação:</label>
		</td>
		<td>
			&nbsp;<label for="dataini">de&nbsp;</label>
			<input type="text" id="dataini" name="dataini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="datafim">&nbsp;até&nbsp;</label>
			<input type="text" id="datafim" name="datafim" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	<tr>
		<td colspan="3" >&nbsp;
			
		</td>
	</tr>
	<tr>
		<td colspan="3" align="right">
			<input type="button" value="Enviar" onclick="enviar()" />
			&nbsp;
			<input type="button" value="Fechar" onclick="window.close()" />&nbsp;&nbsp;
		</td>
	</tr>
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

