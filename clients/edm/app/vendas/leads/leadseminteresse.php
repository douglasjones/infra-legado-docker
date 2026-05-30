<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.leads.php";
	include_once "../../libs/cla.agendaslead.php";
	include_once "../../libs/cla.propostas.php";
	include_once "../../libs/cla.ocorrencias.php";
	include_once "../../libs/combo.php";

	
	$sql = "";
	
	
	if(!empty($_REQUEST['enviar'])){

		$codlead = $_REQUEST['codlead'];
		$codmotivo = $_REQUEST['codmotivolead'];
		$descricao = $_REQUEST['descricao'];
		
		//Cancela os agendamentos
		$sql = "Select CodAgendaLead From agendaslead";
		$sql .= " Where CodLead = $codlead";
		$sql .= " And DataHorario > SYSDATE()";
		$sql .= " And CodStatus Is Null ";
		$rs = sql_query($sql);
		while($row = mysql_fetch_array($rs)){
			agendaslead::cancelar($row['CodAgendaLead'], $descricao);
		}
		mysql_free_result($rs);
		//Cancela as propostas
		$sql = "Select CodProposta, Versao From propostas";
		$sql .= " Where CodLead = $codlead ";
		$sql .= " And DataCancelamento is null ";
		$sql .= " And DataRecebimentoContrato is null ";
		$rs = sql_query($sql);
			
		while($row = mysql_fetch_array($rs)){
			propostas::alterar($row['CodProposta'], $row['Versao'], $codlead, array('datacancelamento' => 'SYSDATE()', 'codmotivo' => $codmotivo, 'cancelamento' => $descricao));
		}
		mysql_free_result($rs);
		
		//Atualiza o Status do Lead
		$status = 1;
		$sql = "Update leads ";
		$sql .= " set codmotivo = $codmotivo, ";
		$sql .= " CodStatusClassificacaoLead = $status ";
		$sql .= "Where CodLead = $codlead";
		sql_query($sql);

		//Inclui a ocorrência de cancelamento
		$sql = "";
		$sql .= "Select * ";
		$sql .= " from motivoslead ";
		$sql .= " Where CodMotivoLead = $codmotivo";
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		$descricao = $row['Descricao'].' - '.$descricao;
		ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => $descricao, 'codtipoocorrencialead' => 5));
		javascriptalert('Operação executada com sucesso.');
		mysql_free_result($rs);
	}
	
	$acao = "ins";
	
	$codlead = null;
	$razaosocial = null;

	$codmotivo = null;
	
	if(!empty($_REQUEST['codlead']))
		$codlead = $_REQUEST['codlead'];
	
	//Pesquisa os dados do lead.
	$sql = "select RazaoSocial, NomeFantasia ";
	$sql .= " from leads ";
	$sql .= " where codlead = $codlead ";
	$result = sql_query($sql);
	if($row = mysql_fetch_array($result)){
		$razaosocial = $row['RazaoSocial'];
	}
	mysql_free_result($result); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">

    <!--Cabeçalho-->
	<title>Lead Sem Interesse</title>
<?	include_once "../../libs/head.php";?>

    <!--Código Javascript-->
	<script type="text/javascript" language="javascript">
function validaCampos(){
	if(!validateForm(document.forms[0])) return false;
	return true
}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form name="dados" method="post" action="leadseminteresse.php" onsubmit="return validaCampos(this)">
		<input type="hidden" id="codlead" name="codlead" value="<?=$codlead;?>" />
		
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Lead sem Interesse
		</td>
	</tr>
</table>		
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tbody>
		<tr>
	          <td colspan="2">
	              &nbsp;
	          </td>
	    </tr>
		<tr>
			<td>&nbsp;Lead:</td>
			<td><?=$razaosocial;?></td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codmotivolead">Motivo:</label></td>
			<td>
			<?	
				$sql = "Select m.* ";
				$sql .= " from motivoslead m ";
				$sql .= " Order By m.Descricao ";
				combo($sql, "codmotivolead", "", "", 'validate="required"');
			?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="descricao">Descrição:</label></td>
			<td><textarea id="descricao" name="descricao" rows="6" style="width: 90%"></textarea></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>
		<tr>
			<th colspan="2" align="right">
				<input type="submit" name="enviar" value="Enviar" />
				&nbsp;
				<input type="reset" name="limpar" value="Limpar" />
				&nbsp;
				<input type="button" name="fechar" value="Fechar" onclick="window.close()" />&nbsp;
			</th>
		</tr>
	</tfoot>
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php"; ?>
