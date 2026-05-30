<?
/*___________________G_E_P_R_O_S_______________________________*/
/*   Descricao: Pagina PHP                                   */
/*   File:     Relatorio                                     */
/*-----------------------------------------------------------*/
/*   Autor:   Douglas Jones Lopes                            */
/*   Data:    18/10/2009                                     */
/*   Versao:  181009RC1.0                                    */
/*-----------------------------------------------------------*/
/*   Descri;cao:Adequa;áo do relatorio no layout com pagina;áo*/
/*---------------A-L-T-E-R-A-D-O-----------------------------*/
/*   Alterado:Douglas Jones Lopes                            */
/*   Data:    23/11/2009                                     */
/*   Versao:  1.0.6.T.5T.Correção / Layout-Douglas-05/11/2009*/
/*   Descri;cao:Correção do relatorio e adequação do layout  */
/*-------------------------------------------------------------*/
    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo_relatorios.php";
	$codusuario = $_SESSION['codusuario'];
	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);
	$acao = $_REQUEST['acao'];
	if(!(($acao == 'cs' && permissao('relpipelineforecastpesq.php', 'cs')) || ($acao == 'upd' && permissao('relpipelineforecastpesq.php', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
?>
<html>
<head>
    <!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css">
    <!--Cabeçalho-->
	<title>Relatório de Pipeline e Forecast</title>
	
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
<form name="dados" method="get" action="pipe_forecast_atendente_res.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Pipeline e Forecast Atendente
		</td>
	</tr>
</table>		

<table border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td>
			&nbsp;<label  for="cod_polo">Polo:</label>
		</td>
		<td>
			<?//COMBO DE POLO
				combo::polo($codpolo);
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="codatendente">Atendente:</label></td>
		<td>
		<?	combo::atendente_equipe($_SESSION['codusuario']); ?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="mailing">Mailing:</label></td>
		<td>
		<?	combo::mailing();?>
		</td>
	</tr>
	</tbody>
	<tfoot>
	<tr>
		<th colspan="2" align="right">
			<input type="button" value="Enviar" onclick="enviar()" />
			&nbsp;
			<input type="button" value="Fechar" onclick="window.close()" />&nbsp;
		</th>
	</tr>
	</tfoot>
	</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
