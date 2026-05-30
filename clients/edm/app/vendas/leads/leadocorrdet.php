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
	include_once "../../libs/head.php";
	
	if(!permissao('leads', 'dt')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
	
	$codlead = null;
	
	if (isset($_REQUEST['codlead'])){
		$codlead = $_REQUEST['codlead'];
		$sql = "select l.*, g.Nome GerenteConta, a.Nome Atendente, s.Descricao StatusClassificacaoLead, m.Descricao Motivo from leads l left join statusclassificacaolead s on l.CodStatusClassificacaoLead = s.CodStatusClassificacaoLead left join motivoslead m on l.CodMotivo = m.CodMotivoLead left join usuariosinternos g on l.CodGerenteConta = g.CodUsuarioInterno left join usuariosinternos a on l.CodAtendente = a.CodUsuarioInterno where l.codlead = " . mysqlnull($codlead);
		$result = sql_query($sql);
		$lead = mysql_fetch_array($result);
		$lead_voip = $lead['VoIP'];
		if(!$lead)
			exit;
		mysql_free_result($result);
	}
	if($GerenteContas && $_SESSION['codusuario'] != $lead['CodGerenteConta'] && !permissao('leadoutrogerente', 'al')){?>
		<script type="text/javascript" language="javascript">
			alert('Você não tem permissão para acessar Lead de outro Gerente de Contas!!!!')
			if(top.pagina)
				window.history.back()
			else
				self.close()
		</script>
<?		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">

<!--Cabeçalho-->
<title>Detalhes do Lead</title>

<!--Comandos Javascript-->
<script type="text/javascript" language="javascript">
function abrirHistorico(vlr){
	NewWindow('leadagendavisualiza.php?codlead=<?=$codlead;?>', 700, 500)
}

function editarCliente(){
	NewWindow('leadnew.php?codlead=<?=$codlead;?>', 700, 500)
}

function excluirCliente(){
	if(confirm('Confirma exclusão do Lead?'))
		return true
	else
		return false
}

function agendarRetorno(){
	NewWindow("leadsagendaretornonew.php?acao=ins&codlead=<?=$codlead;?>", 500, 350)
}

function leadSemInteresse(){
	NewWindow("leadseminteresse.php?codlead=<?=$codlead;?>", 350, 200)
}

function novaAgenda(){
	NewWindow("leadsagendanew.php?acao=ins&codlead=<?=$codlead; ?>", 650, 560)
}

function Checklist() {
	NewWindow("checklist.php?codlead=<?=$codlead;?>",500, 500);
}

function novaOS() {
	NewWindow("ordemservico.php?acao=new&codlead=<?=$codlead;?>",700, 500);
}

function impOS() {
	var r2 = document.getElementsByName('r2')
	var tmp = ''
	if (r2){
		if (r2.length)
			for (i=0;i<r2.length;i++)
				if (r2[i].checked)
					tmp = r2[i].value
		else
			if (r2.checked)
			tmp = r2.value
	}
	if (tmp==''){
		alert('Selecione uma OS!!!')
		return false
	}
	else{
		NewWindow("ordemservicoimp.php?codos="+tmp, 700, 500)
	}
}

function editaOS(){
	var r2 = document.getElementsByName('r2')
	var tmp = ''
	if (r2){
		if (r2.length)
			for (i=0;i<r2.length;i++)
				if (r2[i].checked)
					tmp = r2[i].value
		else
			if (r2.checked)
			tmp = r2.value
	}
	if (tmp==''){
		alert('Selecione uma OS!!!')
		return false
	}
	else{
		NewWindow("ordemservico.php?acao=edi&codos="+tmp, 700, 500)
	}
}

function editarAgenda(vlr){
<?	if(permissao('agenda', 'al')){?>
	NewWindow("leadsagendanew.php?acao=upd&codagendalead="+vlr, 590, 560)
<?	}elseif(permissao('agenda', 'dt')){?>
	NewWindow("leadsagendadet.php?codagendalead="+vlr, 590, 560)
<?	}?>
}

function abrirOcorrencia(){
	NewWindow("leadhistoricoocorrencia.php?codlead=<?=$codlead?>", 750, 400)
}

function novaOcorrencia(){
	NewWindow("leadocorrencianew.php?codlead=<?=$codlead?>", 500, 300)
}

function novaProposta(){
	var codproduto = document.getElementById('produtonova').options[document.getElementById('produtonova').selectedIndex].value
	NewWindow("propostanew.php?acao=ins&codlead=<?=$codlead;?>&codproduto=" + codproduto, 700, 500)
}

function novaVersaoProposta(){
	var rl = document.getElementsByName('rl')
	var tmp = ''
	if (rl){
		if (rl.length)
			for (i=0;i<rl.length;i++)
				if (rl[i].checked)
					tmp = rl[i].value
		else
			if (rl.checked)
				tmp = rl.value
	}
	if (tmp==''){
		alert('Selecione uma Proposta!!!')
		return false
	}
	else{
		var tmp = tmp.split('.')
		var codProposta = tmp[0]
		var versao = tmp[1]
		NewWindow('propostanew.php?acao=ins&codproposta=' + codProposta + '&versao=' + versao + '&codlead=<?=$codlead;?>&novaversao=1', 700, 500)
	}
}

function editaProposta(){
	var rl = document.getElementsByName('rl')
	var tmp = ''
	if (rl){
		if (rl.length)
			for (i=0;i<rl.length;i++)
				if (rl[i].checked)
					tmp = rl[i].value
		else
			if (rl.checked)
			tmp = rl.value
	}
	if (tmp==''){
		alert('Selecione uma Proposta!!!')
		return false
	}
	else{
		tmp = tmp.split('.')
		var codProposta = tmp[0]
		var versao = tmp[1]
		NewWindow("propostanew.php?acao=upd&codproposta=" + codProposta + '&versao=' + versao + "&codlead=<?=$codlead;?>", 700, 500)
	}
}
function PropostaImp(){
	var rl = document.getElementsByName('rl')
	var tmp = ''
	if (rl){
		if (rl.length)
			for (i=0;i<rl.length;i++)
				if (rl[i].checked)
					tmp = rl[i].value
		else
			if (rl.checked)
			tmp = rl.value
	}
	if (tmp == ''){
		alert("Por favor, selecione uma Proposta.")
		return
	}else{
		tmp = tmp.split('.')
		var codProposta = tmp[0]
		var versao = tmp[1]
		NewWindow("propostaimp.php?acao=imp&codproposta=" + codProposta + '&versao=' + versao + "&codlead=<?=$codlead;?>", 800, 600)
	}
}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form action="">
		<input type="hidden" id="codlead" name="codlead" value="<?=$codlead;?>" />
		<table border="0" cellpadding="0" cellspacing="0" class="form" summary="">
			<thead>
				<tr>
					<th colspan="2">Código: <?=$codlead;?></th>
					<th colspan="2">Status: <?=$lead['StatusClassificacaoLead'] . ($lead['CodStatusClassificacaoLead'] == 1?" - Motivo: {$lead['Motivo']}":null);?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Razão Social:</td>
					<td><?=$lead['RazaoSocial'];?></td>
					<td>Fantasia:</td>
					<td><?=$lead['NomeFantasia'];?></td>
				</tr>
				<tr>
					<td>CNPJ:</td>
					<td><?=$lead['CNPJ_CPF'];?></td>
					<td>Inscrição Estadual:</td>
					<td><?=$lead['IE'];?></td>
				</tr>
				<tr>
					<td>Inscrição Municipal:</td>
					<td><?=$lead['InscricaoMunicipal'];?></td>
					<td>Site:</td>
					<td><?=$lead['Site'];?></td>
				</tr>
				<tr>
					<td>Telefone:</td>
					<td><?=(!empty($lead['ddd'])?"({$lead['ddd']})&nbsp;":null) . $lead['tel'];?></td>
					<td>Fax:</td>
					<td><?=(!empty($lead['dddfax'])?"({$lead['dddfax']})&nbsp;":null ) . $lead['fax'];?></td>
				</tr>
				<tr>
					<td>Gerente de Contas:</td>
					<td><?=$lead['GerenteConta'];?></td>
					<td>Atendente:</td>
					<td><?=$lead['Atendente'];?></td>
				</tr>
				<tr>
					<td>Endereço:</td>
					<td><?=$lead['Endereco'];?><?=(!empty($lead['Numero'])?",&nbsp;{$lead['Numero']}":null);?><?=(!empty($lead['Complemento'])?"&nbsp;-&nbsp;{$lead['Complemento']}":null);?></td>
					<td>Vencimento do Contrato:</td>
					<td><strong><?=(!empty($lead['VencimentoContrato'])?date('d/m/Y', strtotime($lead['VencimentoContrato'])):null);?></strong></td>
				</tr>
				<tr>
					<td>Bairro:</td>
					<td><?=$lead['Bairro'];?></td>
					<td>Data de ativação:</td>
					<td><strong><?=(!empty($lead['Ativacao'])?date('d/m/Y', strtotime($lead['Ativacao'])):null);?></strong></td>
				</tr>
				<tr>
					<td>Cidade:</td>
					<td><?=$lead['cidade'] . (!empty($lead['uf'])?"/{$lead['uf']}":null);?></td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>CEP:</td>
					<td><?=$lead['Cep'];?></td>
					<td colspan="2">
<?	$sql = "Select count(CodOcorrenciaLead) Total From ocorrenciaslead Where CodLead = $codlead";
	$rs = sql_query($sql);
	$row = mysql_fetch_array($rs);
	$totalocorrencias = $row['Total'];
	mysql_free_result($rs);?>
						<a href="javascript:abrirOcorrencia()">(<?=$totalocorrencias;?>) Histórico Ocorrências</a>
<?	if(permissao('ocorrencias', 'ic')){?>
						&nbsp;<input type="button" value="Adicionar Ocorrência" onClick="novaOcorrencia()" title="Nova Ocorrência" />
<?	}?>
					</td>
				</tr>
				<tr>
					<th colspan="4">Contato</th>
				</tr>
				<tr>
					<td colspan="4">
						<table border="0" id="contatos" cellpadding="0" cellspacing="0" class="grid">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Setor</th>
									<th>Função</th>				
									<th>Telefone</th>
									<th>Ramal</th>
									<th>Celular</th>		
									<th>Email</th>
								</tr>
							</thead>
							<tbody>
<?	$sql = "Select ct.*, sc.Descricao as NomeSetor, fc.Descricao as NomeFuncao ";
	$sql .= " From contatoslead ct";
	$sql .= " left join setorcontatos sc on ct.CodSetorContato = sc.CodSetorContato";
	$sql .= " left join funcaocontato fc on ct.CodFuncaoContato = fc.CodFuncaoContato";
	$sql .= " where ct.codlead = ".$codlead;
	$result = sql_query($sql);
	$cont = 0;
	while($contato = mysql_fetch_array($result)){?>
								<tr>
									<td><?=$contato['NomeContato'];?></td>
									<td><?=$contato['NomeSetor'];?></td>
									<td><?$contato['NomeFuncao'];?></td>
									<td><?=(!empty($contato['DDD_Fone'])?"({$contato['DDD_Fone']})&nbsp;":null);?><?=$contato['Fone'];?></td>
									<td><?=$contato['Ramal_Fone'];?></td>
									<td><?=(!empty($contato['DDD_Cel'])?"({$contato['DDD_Cel']})&nbsp;":null);?><?=$contato['Cel'];?></td>
									<td><?=$contato['Email'];?></td>
								</tr>
<?	}
	mysql_free_result($result);?>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<th colspan="4">
<?	if(permissao('leads', 'al')){?>
						<input type="button" value="Editar Lead" onClick="editarCliente()" />
<?	}
	if(permissao('agendaretorno', 'ic')){?>
						<input type="button" value="Agendar Retorno de Ligação" onClick="agendarRetorno()" />
<?	}
	if($lead['CodStatusClassificacaoLead'] != 1 || $Root){?>
						<input type="button" value="Lead sem Interesse" onClick="leadSemInteresse()" />
<?	}

	if($lead_voip==1) {?>
						<input type="button" value="Checklist" onClick="Checklist()" />
<?	}
?>
					</th>
				</tr>
			</tbody>
		</table>
<?	if(permissao('agenda', array('dt', 'al'))){?>
		<table border="0" cellpadding="0" cellspacing="0" class="form">
			<thead>
				<tr>
					<th colspan="4">Última Visita</th>
				</tr>
			</thead>
<?		//Pesquisa os dados da ultima agenda.
		$sql = "Select a.*, t.Descricao Tipo, s.Descricao Status, ui.Nome UsuarioInterno, ui1.Nome AgendadoPara, c.NomeContato Contato";
		$sql .= " from agendaslead a ";
		$sql .= " left join tipoagendamento t on a.CodTipo = t.CodTipo ";
		$sql .= " left join statusagendamento s on a.CodStatus = s.CodStatus ";
		$sql .= " left join usuariosinternos ui on a.CodUsuarioInterno = ui.CodUsuarioInterno ";
		$sql .= " left join usuariosinternos ui1 on a.AgendadoPara = ui1.CodUsuarioInterno ";
		$sql .= " left join contatoslead c on a.CodContatoLead = c.CodContatoLead ";
		$sql .= " Where a.CodLead = $codlead ";
		$sql .= " And a.DataCancelamento Is Null ";
		$sql .= " Order By a.CodAgendaLead Desc Limit 1";
		$result = sql_query($sql);
		$visita = mysql_fetch_array($result);
		$codagendalead = @$visita['CodAgendaLead'];?>
			<tbody>
				<tr>
					<td>Código Agenda:</td>
					<td><?=@$visita['CodAgendaLead'];?>&nbsp; - &nbsp;<?=(!empty($visita['DataCadastro'])?date('d/m/Y \à\s H:i:s', strtotime($visita['DataCadastro'])):null);?></td>
					<td colspan="2"><a href="javascript:abrirHistorico()">Histórico das visitas</a></td>
				</tr>
				<tr>
					<td>Tipo Agendamento:</td>
					<td><?=@$visita['Tipo'];?></td>
					<td>Status:</td>
					<td><?=@$visita['Status'];?></td>
				</tr>
				<Tr>
					<td>Agendado por:</td>
					<td><?=@$visita['UsuarioInterno'];?></td>
					<td>Agendado para:</td>
					<td><?=@$visita['AgendadoPara'];?></td>
				</tr>
				<tr>
					<td>Data e Horário:</td>
					<td><?=(!empty($visita['DataHorario'])?date('d/m/Y \à\s H:i', strtotime($visita['DataHorario'])):null);?></td>
					<td>Término:</td>
					<td><?=(!empty($visita['Termino'])?date('H:i', strtotime($visita['Termino'])):null);?></td>
				</tr>
				<tr>
					<td>Gerentes Contas:</td>
					<td colspan="3">
<?		if(!empty($visita['CodAgendaLead'])){
			$sql = "select u.Nome ";
			$sql .= " from usuariosinternos u ";
			$sql .= " inner join agendagerenteconta ag on u.codusuariointerno = ag.codgerenteconta ";
			$sql .= " where ag.codagendalead = {$visita['CodAgendaLead']}";
			$result1 = sql_query($sql);
			while($gerentevisita = mysql_fetch_array($result1)){?>
						<?=$gerentevisita['Nome'];?><br />
<?			}
			mysql_free_result($result1);
		}?>
					</td>
				</tr>
				<tr>
					<td>Descrição:</td>
					<td colspan="3"><?=$visita['Descricao'];?></td>
				</tr>
			</tbody>
<?		}?>
			<tfoot>
				<tr>
					<th colspan="4">
<?		if(permissao('agenda', 'ic')){?>
						<input type="button" value="Agendar Visita" onClick="novaAgenda()" />
<?		}
 		if(!empty($codagendalead) && permissao('agenda', array('al', 'dt'))){?>
						<input type="button" value="Classificar Visita" onClick="editarAgenda(<?=$codagendalead;?>)" />
<? 		}?>
					</th>
				</tr>
			</tfoot>
		</table>
<?	mysql_free_result($result);
	if(permissao('proposta', 'cs')){?>
		<table border="0" cellpadding="0" cellspacing="0" class="form">
			<thead>
				<tr>
					<th colspan="2">Propostas</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">
						<div class="iframe">
							<table border="0" cellpadding="0" cellspacing="0" id="tabelaproposta" class="grid">
								<thead>
									<tr>
										<th>#</th>
										<th>Versão Proposta</th>
										<th>Valor Proposta</th>
										<th>Valor Contrato</th>
										<th>Data Cadastro</th>
										<th>Data Envio</th>
										<th>Data Recebimento</th>
									</tr>
								</thead>
								<tbody>
<?		$sql = "select p.CodProposta, p.Versao, p.TotalProposta, p.ValorContrato, p.DataCadastro, p.DataCancelamento, p.DataEnvio, p.DataRecebimento, pr.Nome as Produto";
		$sql .= " from propostas p ";
		$sql .= " left join usuariosinternos u on p.CodUsuarioInterno = u.CodUsuarioInterno";
		$sql .= " left join produtos pr on p.CodProduto = pr.CodProduto ";
		$sql .= " where p.CodLead = $codlead ";
		$sql .= " Order By p.CodProposta Desc, p.Versao Desc";
		$result = sql_query($sql);
		While($proposta = mysql_fetch_array($result)){?>
									<tr>
										<td><input  type='radio' name='rl' value="<?=$proposta['CodProposta'] . '.' . $proposta['Versao'];?>" /></td>
										<td><?=$proposta['CodProposta'] . '.' . $proposta['Versao'] . '&nbsp;-&nbsp;' . $proposta['Produto'];?></td>
										<td style="text-align:right"><?=(!empty($proposta['TotalProposta'])?'R$&nbsp;' . number_format($proposta['TotalProposta'], 2, ',', '.'):null);?></td>
										<td style="text-align:right"><?=(!empty($proposta['ValorContrato'])?'R$&nbsp;' . number_format($proposta['ValorContrato'], 2, ',', '.'):null);?></td>
										<td><?=(!empty($proposta['DataCadastro'])?date('d/m/Y', strtotime($proposta['DataCadastro'])):null).(!empty($proposta['DataCancelamento'])?'<strong style="color:red">&nbsp;Cancelada</strong>':null);?></td>
										<td><?=(!empty($proposta['DataEnvio'])?date('d/m/Y', strtotime($proposta['DataEnvio'])):null);?></td>
										<td><?=(!empty($proposta['DataRecebimento'])?date('d/m/Y', strtotime($proposta['DataRecebimento'])):null);?></td>
									</tr>
							<?	}?>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<th>&nbsp;
<?		if(permissao('proposta', array('dt', 'ic', 'al'))){?>
						Selecionado:
<?		}?>
<?		if(permissao('proposta', 'dt')){?>
						<input type="button" value="Imprimir Proposta" onClick="PropostaImp()" />&nbsp;
<?		}?>
<?		if(permissao('proposta', 'ic')){?>
						<input type="button" value="Nova Ver. Proposta" onClick="novaVersaoProposta()" />&nbsp;
<?		}?>
<?		if(permissao('proposta', 'al')){?>
						<input type="button" value="Editar Proposta" onClick="editaProposta()" />
<?		}?>
					</th>
					<th>&nbsp;
<?		if(permissao('proposta', 'ic')){
			$sql = "select * from produtos where desativado is null order by nome";
			combo($sql,"produtonova", "", "", "");?>
						<input type="Button" value="Nova Proposta" onClick="novaProposta()" />
<?		}?>
					</th>
				</tr>
			</tbody>
		</table>
<?	}
	$sql = 'SELECT CodLead FROM propostas WHERE CodLead='.$codlead;
	
	if($lead_voip==1 && mysql_num_rows(sql_query($sql))>0) {?>
		<table border="0" cellpadding="0" cellspacing="0" class="form">
			<thead>
				<tr>
					<th>Ordens de Servi&ccedil;o</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">
						<div class="iframe">
							<table border="0" cellpadding="0" cellspacing="0" id="tabelaproposta" class="grid">
								<thead>
									<tr>
										<th>#</th>
										<th>Data OS</th>
										<th>Per&iacute;odo</th>
										<th>Status</th>
										<th>Try &amp; Buy</th>
										<th>Proposta</th>
										<th>Versão Proposta</th>
									</tr>
								</thead>
								<tbody>
								<?
								$sql = '
								SELECT OS.CodOS, OS.CodProposta, OS.VersaoProposta, OS.DataOS, OS.Periodo, OS.Status, OS.DataTryBuyDe, OS.DataTryBuyAte 
									FROM ordemservico AS OS 
									INNER JOIN propostas AS PR ON OS.CodProposta=PR.CodProposta 
									WHERE PR.CodLead='.$codlead.' 
									ORDER BY DataOS ASC';
								$result = sql_query($sql);
								while($osrow = mysql_fetch_array($result)) {
									$osdata = date('d/m/Y',strtotime($osrow['DataOS']));
									$osperiodo = ($osrow['Periodo']==0?'Manhã':'Tarde');
									$osstatus = ($osrow['Status']==0?'Não realizado':'Realizado');
									
									if(!empty($osrow['DataTryBuyDe']) && !empty($osrow['DataTryBuyAte'])) {
										$ostrybuy = date('d/m/Y',strtotime($osrow['DataTryBuyDe'])).' a '.date('d/m/Y',strtotime($osrow['DataTryBuyAte']));
									}
									else {
										$ostrybuy = 'Não';
									}
									
								?>
									<tr>
										<td><input type="radio" name="r2" id="r2" value="<?=$osrow['CodOS'];?>" /></td>
										<td><?=$osdata;?></td>
										<td><?=$osperiodo;?></td>
										<td><?=$osstatus;?></td>
										<td><?=$ostrybuy;?></td>
										<td><?=$osrow['CodProposta'];?></td>
										<td><?=$osrow['VersaoProposta'];?></td>
									</tr>
								<?
								}
								?>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<th>&nbsp;
<?		if(permissao('ordemservico', array('dt', 'ic', 'al'))){?>
						Selecionado:
<?		}?>
<?		if(permissao('ordemservico', 'dt')){?>
						<input type="button" value="Imprimir OS" onClick="impOS()" />&nbsp;
<?		}?>
<?		if(permissao('ordemservico', 'ic')){?>
						<input type="button" value="Nova OS" onClick="novaOS()" />&nbsp;
<?		}?>
<?		if(permissao('ordemservico', 'al')){?>
						<input type="button" value="Editar OS" onClick="editaOS()" />
<?		}?>
					</th>
				</tr>
			</tbody>
		</table>
<?	}
?>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
