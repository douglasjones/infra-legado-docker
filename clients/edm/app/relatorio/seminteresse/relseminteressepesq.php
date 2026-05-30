<?	

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo_relatorios.php";
$codusuario = $_SESSION['codusuario'];
$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
@$equipe = mysql_result($result,0);
@mysql_free_result($result); 

$acao = $_REQUEST['acao'];

if(!(($acao == 'cs' && permissao('relseminteressepesq.php', 'cs')) || ($acao == 'upd' && permissao('relseminteressepesq.php', 'al')))){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}
?>

<html>
<head>
<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>

<!--Cabeçalho-->
<title>Relatório de Leads Sem Interesse</title>
<!--Comandos Javascript-->
<?	include_once "../../libs/head.php";?>
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
<script type="text/javascript" language="javascript">

function trocar(vlr){
	var frm = document.forms[0];
	frm.action = vlr;
}

function enviar(){

	var frm = document.forms[0];
	if(!validateForm(frm)) return false
	frm.submit()
	self.close()
}
</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" action="relseminteresseres.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Leads Sem Interesse
		</td>
	</tr>
</table>	
<table border="0" width="100%" cellpadding="0" cellspacing="0" class="form">
	<tbody>
        <tr>
            <td>&nbsp;<label for="codequipe">Equipe:</label></td>
            <td>
            <? 
                combo::equipe(@$equipe);
            ?>
            </td>
        </tr>
		<tr>
			<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
			<td>
			<? combo::consultor_equipe($_SESSION['codusuario'], $_SESSION['codusuario'], " ");?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="atendente">Atendente:</label></td>
			<td>
			<?	combo::atendente_equipe($_SESSION['codusuario']);?>
			</td>
		</tr>		
		<tr>
			<td>&nbsp;<label for="mailing">Mailing:</label></td>
			<td>
				<?combo::combo_mailing($mailing_pk);?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="datastatusde">Alteração de Status:</label></td>
			<td>
				<input type="text" id="dataini" name="dataini" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />
				&nbsp;<label for="datastatusate">&nbsp;até&nbsp;</label>
				<input type="text" id="datafim" name="datafim" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="motivo">Motivo Sem Interesse:</label></td>
			<td>
                <?	combo::motivo_seminteresse($_SESSION['CodMotivoLead']);?>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;<label for="datastatusde">Tipo de Relatório:</label>
			</td>
			<td>
				<input type="Radio" name="tp_relatorio" value="relseminteresseres.php" onclick='trocar(this.value)' checked> Analítico
				<input type="Radio" name="tp_relatorio" value="relseminteresseres_sintetico.php" onclick='trocar(this.value)'> Sintético
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<th colspan="2" align="center" >
				<input type="button" value="Enviar" onclick="enviar()" />&nbsp;
				<input type="button" value="Fechar" onclick="window.close()" />&nbsp;
			</th>
		</tr>
	</tfoot>
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
