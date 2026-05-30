<?
require "../../libs/ajax/xajax_core/xajax.inc.php"; // XAJAX
require "../../libs/naoperturbe.php"; // Fun��o que faz a busca do nao perturbe procon
require "../../libs/cla.equipes.php";

$ajax = new xajax();
$ajax->registerFunction("buscar_nao_perturbe");
function buscar_nao_perturbe($telefone, $descricao_bloqueado){

	//Instancia o objeto XAJAX response
	$objResponse = new xajaxResponse('ISO-8859-1');
	$resultado_busca = naoperturbe($telefone);

	$objResponse->assign($descricao_bloqueado, "innerHTML", $resultado_busca['descricao']);

	return $objResponse;
}
function n_data_proposta($proposta_pk,$data_proposta_operador_pk,$ds_label_data){
	if(!empty($data_proposta_operador_pk)){
		$sql = "Select
					ndp.pk,
					DATE_FORMAT(ndp.vl_data_proposta, '%d/%m/%Y') as dr_linha 
				from n_datas_proposta ndp
					inner join n_data_proposta_operador ndpo on ndp.data_proposta_operador_pk = ndpo.pk
				where ndp.propostas_pk=".$proposta_pk;
		$sql .= " and ndpo.ds_label_data='".$ds_label_data."'";
		
		$result = sql_query($sql);
		$row = mysql_fetch_array($result);	
		
		return($row['dr_linha']);
	}else{
	 //return("&nbsp;");	
	}		
}	
$ajax->processRequest();
include_once "../../libs/maininclude.php";
$ajax->printJavascript('../../libs/ajax/');

	include_once "../../libs/combo.php";
	include_once "../../libs/cla.campanha.php";
	include_once "../../libs/cla.ocorrencias.php";

	if(!permissao('leads', 'dt')){
		javascriptalert('Voce nao tem permissao para acessar esta pagina!!!');
		exit;
	}

	$codlead = $_REQUEST['codlead'];

	//tratamento para a campanha
	if(!empty($_REQUEST['resultado_campanha'])){
		$cod_campanha = $_REQUEST['cod_campanha'];
		$resultado_campanha = $_REQUEST['resultado_campanha'];
		$campanha = new campanha($cod_campanha);

		$campanha->participarCampanha($codlead, $resultado_campanha);
        
	}
	if (isset($_REQUEST['codlead'])){
		$codlead = $_REQUEST['codlead'];
		$sql = "select l.codlead,
		l.razaosocial,
		l.NomeFantasia,
		l.CNPJ_CPF,
        l.ativacao,
		l.IE,
		l.InscricaoMunicipal,
		l.Site,
		l.ddd,
		l.tel,
		l.dddfax,
		l.fax,
		l.Endereco,
		l.Numero,
		l.Complemento,
		l.Bairro,
		l.Cep,
		l.cidade,
		l.uf,
		l.CodGerenteConta,
		l.DataCadastro,
		l.CodStatusClassificacaoLead,
		l.Segmento,l.codigooriginal,
		l.CodAtendente,
		ml.dsc_mailing Mailing,
		l.CodMotivo,
		l.VencimentoContrato,
		l.CodTransf,
		l.Ativacao,
		l.cod_polo,
		l.PontoRef,
		l.tel_bloqueado,
		l.fax_bloqueado,
		l.qtde_linhas,
		l.tipo_pessoa,
		g.Nome GerenteConta,
		a.Nome Atendente,
		ui.Nome Usuario,
		s.Descricao StatusClassificacaoLead,
		m.Descricao Motivo,
		pl.n_polo as polo,
		l.id_fornecedor,
		l.iluminado,
        l.classificacao_vivo_pk,
        cl.NomeContato,
        cl.email email_contato,
        cl.fone,
        cl.DDD_fone,
        g.email,
        g.nome,
        l.classificacao_claro_pk ";
		$sql .=" from leads l";
		$sql .=" left join statusclassificacaolead s on l.CodStatusClassificacaoLead = s.CodStatusClassificacaoLead";
		$sql .=" left join motivoslead m on l.CodMotivo = m.CodMotivoLead ";
		$sql .=" left join contatoslead cl on l.codlead = cl.codlead ";
		$sql .=" left join usuariosinternos g on l.CodGerenteConta = g.CodUsuarioInterno";
		$sql .=" left join usuariosinternos a on l.CodAtendente = a.CodUsuarioInterno ";
		$sql .=" left join usuariosinternos ui on l.usuariocadastro= ui.CodUsuarioInterno ";
		$sql .=" left join polo pl on l.cod_polo = pl.cod_polo";
		$sql .=" left join mailing ml on ml.pk = l.mailing_pk";
		$sql .=" where l.codlead = " . mysqlnull($codlead);
            $result = sql_query($sql);
            $row = mysql_fetch_array($result);
            
        $codlead = $row['codlead'];
        $razaosocial = $row['razaosocial'];
        $ddd = $row['ddd'];
        $tel = $row['tel'];
        $CodGerenteConta = $row['CodGerenteConta'];
        $NomeContato = $row['NomeContato'];
        $fone = $row['fone'];
        $DDD_fone = $row['DDD_fone'];
        $email_contato = $row['email_contato'];
        $emailpara = $row['email'];
        $nome = $row['nome'];//consultor
        
        
        
		//------------ Verifica  se  o usuario  � gerente de conta
		
		if($GerenteContas && $_SESSION['codusuario'] != $lead['CodGerenteConta'] && !permissao('leadoutrogerente', 'al')){
			//$sql .=" and l.codgerenteconta=".$_SESSION['codusuario'];
			//----------valida se o usuario e lider de equipe ou gerente de conta normal
			if($equipe)
				$sql .= " and l.CodGerenteConta in (select Fk_Usuario from tb_usuarioequipe where Fk_Equipe = $equipe)";
			elseif($GerenteContas)
				$sql .= " and l.CodGerenteConta = ".mysqlnull($_SESSION['codusuario']
			);
		}
		
		//if(!permissao('leadoutrogerente', 'al')){
		//	$sql .= " and l.CodGerenteConta in (".equipes::getCodUsuariosEquipe($codusuariointerno).") ";
		//}

		$result = sql_query($sql);
		$lead = mysql_fetch_array($result);
		if(!$lead){
			?>
				<script>
					alert('Voce nao tem permissao para acessar Lead de outro Consultor!!!!');
					location.href=("../../blank.php");
				</script>
			<?
		exit;
		}

		$result = sql_query($sql);
		$lead = mysql_fetch_array($result);
		if(!$lead)
			exit;
		mysql_free_result($result);
	}
	if($GerenteContas && $_SESSION['codusuario'] != $lead['CodGerenteConta'] && !permissao('leadoutrogerente', 'al')){?>
		<script type="text/javascript" language="javascript">
			alert('Voce nao tem permissao para acessar Lead de outro Gerente de Contas!!!!')
			if(top.pagina)
				window.history.back()
			else
				self.close()
		</script>
<?		exit;
	}
	//Verifica o atendente do lead e compara com o usuario do sistema
	if($Atendente && $_SESSION['codusuario'] != $lead['CodAtendente'] && !permissao('leadoutrooperador', 'al') ){?>
		<script type="text/javascript" language="javascript">
			alert('Voce nao tem permissao para acessar Lead de outro Operador!!!!')
			if(top.pagina)
				location.href=("../../blank.php");
			else
				self.close()
		</script>
<?		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Detalhes do Lead</title>
                <script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>
	<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
<?include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
function abrirHistorico(vlr){

	NewWindow('../../vendas/leads/leadagendavisualiza.php?codlead=<?=$codlead;?>', 700, 500)
}

function editarCliente(){
	NewWindow('../../vendas/leads/leadnew.php?codlead=<?=$codlead;?>', 900, 600)
}

function excluirCliente(){
	if(confirm('Confirma exclus�o do Lead?'))
		return true
	else
		return false
}

function agendarRetorno(){
	NewWindow("../../vendas/leads/leadsagendaretornonew.php?acao=ins&codlead=<?=$codlead;?>", 500, 350)
}

function leadSemInteresse(){
	NewWindow("../../vendas/leads/leadseminteresse.php?codlead=<?=$codlead;?>", 350, 200)
}

function novaAgenda(){
	NewWindow("../../vendas/leads/leadsagendanew.php?acao=ins&codlead=<?=$codlead; ?>", 700, 600)
	//NewWindow("../../vendas/agenda/preagendamentonew.php?acao=ins&codlead=<?=$codlead; ?>", 650, 560)
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

		NewWindow("../propostas/ordemservicoimp.php?codos="+tmp, 700, 500)
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
	NewWindow("leadsagendanew.php?acao=upd&codagendalead="+vlr, 700, 600)
<?	}elseif(permissao('agenda', 'dt')){?>
	NewWindow("leadsagendadet.php?codagendalead="+vlr, 590, 560)
<?	}?>
}

function abrirOcorrencia(){
	NewWindow("leadhistoricoocorrencia.php?codlead=<?=$codlead?>", 950, 400)
}

function novaOcorrencia(){
	NewWindow("leadocorrencianew.php?codlead=<?=$codlead?>", 500, 420)
}

function abrirDocumentos(){
	NewWindow("documentosres.php?codlead=<?=$codlead?>", 1000, 400)
}

function novoDocumento_fatura(operadora_pk){
	NewWindow("documentos_cad_form.php?codlead=<?=$codlead?>&operadora_pk="+operadora_pk, 600, 400)
}
function abrirDocumentos_fatura(operadora_pk){
	NewWindow("documentosres.php?codlead=<?=$codlead?>&operadora_pk="+operadora_pk, 1000, 400)
}

function novoDocumento(){
	NewWindow("documentos_cad_form.php?codlead=<?=$codlead?>", 600, 400)
}

//NOVA PROPOSTA
function add_new_proposta(){	
	var operador_pk = document.getElementById('operador_pk').options[document.getElementById('operador_pk').selectedIndex].value			
	NewWindow("propostas_cad_form.php?acao=ins&codlead=<?=$codlead;?>&operador_pk=" + operador_pk, 1160, 600)
}
//UPDATE NOVA PROPOSTA
function upd_proposta(propostas_pk,operador_pk){			
	NewWindow("propostas_cad_form.php?acao=ins&codlead=<?=$codlead;?>&pk="+propostas_pk+"&operador_pk="+operador_pk, 1160, 600)	
}
//PRINT NOVA PROPOSTA
function imprimir_proposta(propostas_pk,operador_pk){			
	NewWindow("propostas_print_form.php?acao=ins&codlead=<?=$codlead;?>&pk="+propostas_pk+'&operador_pk='+operador_pk, 1160, 600)	
}
//PROCESSO BKO
function processo_adm(propostas_pk,operador_pk){			
	NewWindow("adm_propostas_cad_form.php?acao=ins&codlead=<?=$codlead;?>&pk="+propostas_pk+"&operador_pk="+operador_pk, 1160, 600)	
}
//CANCELA PROPOSTA 
function cancelar_proposta(propostas_pk){			
	NewWindow("proposta_cancelamento_form.php?acao=ins&codlead=<?=$codlead;?>&pk="+propostas_pk, 400, 180)	
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
		NewWindow("../propostas/propostaimp.php?acao=imp&codproposta=" + codProposta + '&versao=' + versao + "&codlead=<?=$codlead;?>", 800, 600)
	}
}

	function consulta_np_tel(vlr){
		var strTelefone = vlr.replace("-","");
		if(strTelefone.length >= 10)
			xajax_buscar_nao_perturbe(strTelefone, 'tel_descricao_bloqueado');
	}

	function consulta_np_fax(vlr){
		var strTelefone = vlr.replace("-","");
		if(strTelefone.length >= 10)
			xajax_buscar_nao_perturbe(strTelefone, 'fax_descricao_bloqueado');
	}
    function formularioimp (){
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
            NewWindow("formulario.php?acao=imp&codproposta=" + codProposta + '&versao=' + versao + "&codlead=<?=$codlead;?>", 800, 600)
        }
    }
	function consulta_np_tel_contato(vlr, indice){
		var strTelefone = vlr.replace("-","");
		var vlr_codlead = "";
		if(strTelefone.length >= 10)
			xajax_buscar_nao_perturbe(strTelefone, ('tel_contato_descricao_bloqueado'+indice));
	}
	function consulta_np_cel_contato(vlr, indice){
		var strTelefone = vlr.replace("-","");
		var vlr_codlead = "";
		if(strTelefone.length >= 10)
			xajax_buscar_nao_perturbe(strTelefone, ('cel_contato_descricao_bloqueado'+indice));
	}
	function visualizarcontato(cd){
		var cod = cd;
		var div = $('divImagem');
		div.innerHTML = "Carregando..."
		div.style.display = "block";
		var pars = 'cod=2';
		new Ajax.Updater('divImagem', 'contatoAjax.php?codcontatolead='+cod, { method: 'post', parameters: pars } );
	}
	function fecharAjax(){
		var div = $('divImagem');
		div.style.display = "none";
	}
	function showImg(){
		var div = $('ImageDiv');
		div.style.display = "block";
	}
    function contrato(){
        NewWindow("contrato_claro_total.php?acao=ins&codlead=<?=$codlead;?>", 1160, 600)
    }

</script>
</head>
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
        <script type="text/javascript" language="JavaScript" src="leads.js"></script>
	<link rel="stylesheet" href="../../extras/lytebox.css" type="text/css" media="screen" />
        
    <script type="text/javascript" language="javascript" src="../../extras/lytebox.js"></script>
    
            <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
            <form action="">
            <input type="hidden" id="codlead" name="codlead" value="<?=$codlead;?>" />
            <input type="hidden" id="razaosocial" name="razaosocial" value="<?=$razaosocial;?>" />
            <input type="hidden" id="ddd" name="ddd" value="<?=$ddd;?>" />
            <input type="hidden" id="tel" name="tel" value="<?=$tel;?>" />
            <input type="hidden" id="CodGerenteConta" name="CodGerenteConta" value="<?=$CodGerenteConta;?>" />
            <input type="hidden" id="NomeContato" name="NomeContato" value="<?=$NomeContato;?>" />
            <input type="hidden" id="DDD_fone" name="DDD_fone" value="<?=$DDD_fone;?>" />
            <input type="hidden" id="fone" name="fone" value="<?=$fone;?>" />
            <input type="hidden" id="email_contato" name="email_contato" value="<?=$email_contato;?>" />
            <input type="hidden" id="email" name="email" value="<?=$emailpara;?>" />
            <input type="hidden" id="nome" name="nome" value="<?=$nome;?>" />
            <table width="100%" align="center"  height="5"    cellpadding="0" cellspacing="0">
    <tr>
        <td>
        <!--TOPO DA PAGINA TRAZ O CODIGO DO LEAD E O STATUS--->
            <table width="100%" align="left"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
                <tr>
                    <td  class="titulo">
                        &nbsp;C�digo: <?=$codlead;?>
                    </td>
                    <td  class="titulo">
                        &nbsp;Status: <?=$lead['StatusClassificacaoLead'] . ($lead['CodStatusClassificacaoLead'] == 1?" - Motivo: {$lead['Motivo']}":null);?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!--EXIBE OS DADOS DE CADASTRO DO LEAD E CONTROLA AS OCORRENCIAS-->
    <tr>
        <td >
        	<table width="95%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
                <tr>
                    <td align="left" valign="middle">
                        Polo		</td>
                    <td width="26%" align="left" valign="middle">
                        <?=$lead['polo'];?>
                    <td width="13%" align="left" valign="middle">
                    <td width="47%" align="left" valign="middle">&nbsp;</td>
                    <td width="2%">&nbsp;</td>
                </tr>
                <tr align="left" valign="middle">
                    <td>Usuario Cadastro:</td>
                    <td><?=$lead['Usuario'];?></td>
                    <td>Data Cadastro:</td>
                    <td><?=(!empty($lead['DataCadastro'])?date('d/m/Y \�\s H:i:s', strtotime($lead['DataCadastro'])):null);?></td>
                </tr>
                <tr align="left" valign="middle">
                    <td>Razao Social:</td>
                    <td><?=$razaosocial;?></td>
                    
                    <td>Fantasia:</td>
                    <td><?=$lead['NomeFantasia'];?></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td>Site:</td>
			<td><a target="_new" href="http://<?=$lead['Site'];?>"><?=$lead['Site'];?></a></td>
                </tr>
                <tr align="left" valign="middle">
                    <td>CNPJ/CPF:</td>
                    <td><?=$lead['CNPJ_CPF'];?>&nbsp&nbsp(<?= str_replace("-","", str_replace("/","", str_replace(".","",$lead['CNPJ_CPF']))) ;?>)</td>
                    <td>Tipo Pessoa:</td>
                    <td><?=$lead['tipo_pessoa'];?></td>
                </tr>
                <tr align="left" valign="middle">
                    <td>Inscricao Estadual:</td>
                    <td><?=$lead['IE'];?></td>
                    <td>Inscricao Municipal:</td>
                    <td><?=$lead['InscricaoMunicipal'];?></td>
                </tr>
                <tr align="left" valign="middle">
                    <td>Telefone:</td>
                    <td>
						<?=(!empty($lead['ddd'])?"({$lead['ddd']})&nbsp;":null) . $lead['tel'];?>
						<a href="#" onclick="consulta_np_tel('<?=$lead['ddd'].$lead['tel'];?>',<?=$codlead;?>)" title="Consultar bloqueio Nao Perturbe - Procon/SP"><img border="0" src="../../images/interrogacao.png"></a>
						<font color="Red"><span id="tel_descricao_bloqueado" >
						<?
						if($lead['tel_bloqueado']==1)
							echo "Bloqueado Nao Perturbe";
						?>
						</span>
						</font>
					</td>
                    <td>Fax:</td>
                    <td>
						<?=(!empty($lead['dddfax'])?"({$lead['dddfax']})&nbsp;":null ) . $lead['fax'];?>
                            <a href="javascript: consulta_np_fax('<?=$lead['dddfax'].$lead['fax'];?>',<?=$codlead;?>)" title="Consultar bloqueio Nao Perturbe - Procon/SP"><img border="0" src="../../images/interrogacao.png"></a>
                            <font color="Red"><span id="fax_descricao_bloqueado">
						<?
						if($lead['fax_bloqueado']==1)
							echo "Bloqueado Nao Perturbe";
						?>
						</span>
						</font>
					</td>
                </tr>
                <tr align="left" valign="middle">
                    <td>Consultor:</td>
                    <td><?=$lead['GerenteConta'];?></td>
                    <td>Atendente:</td>
                    <td><?=$lead['Atendente'];?></td>
                </tr>
                <tr align="left" valign="middle">
                    <td>Mailing:</td>
                    <td><?= $lead["Mailing"];?></td>
                    <td>Pos Vendas:</td>
                    <td><?=$lead['Atendente'];?></td>
                </tr>
                <tr align="left" valign="middle">
                    <td>Endere�o:</td>
                    <td colspan="3"><?=$lead['Endereco'];?><?=(!empty($lead['Numero'])?",&nbsp;{$lead['Numero']}":null);?><?=(!empty($lead['Complemento'])?"&nbsp;-&nbsp;{$lead['Complemento']}":null);?></td>
                </tr>
                <tr align="left" valign="middle">
                    <td>Bairro:</td>
                    <td><?=$lead['Bairro'];?></td>
                    <td>Data de ativacao:</td>
                    <td><strong><?=(!empty($lead['Ativacao'])?date('d/m/Y', strtotime($lead['Ativacao'])):null);?></strong></td>
                </tr>
                <tr align="left" valign="middle">
                    <td>Cidade:</td>
                    <td><?=$lead['cidade'] . (!empty($lead['uf'])?"/{$lead['uf']}":null);?></td>
                    <td colspan="2">Ponto de Referencia:&nbsp;&nbsp;<?=$lead['PontoRef'];?></td>
                </tr>
                <tr align="left" valign="middle">
                    <td>CEP:</td>
                    <td><?=$lead['Cep'];?></td>
                    <td colspan="2">
            <?	$sql = "Select count(CodOcorrenciaLead) Total From ocorrenciaslead Where CodLead = $codlead";
                $rs = sql_query($sql);
                $row = mysql_fetch_array($rs);
                $totalocorrencias = $row['Total'];
                mysql_free_result($rs);

				$sql = "Select count(CodOcorrenciaLead) Total From ocorrenciaslead where CodLead = $codlead and datafechamento is null";

                $rs = sql_query($sql);
                $row = mysql_fetch_array($rs);
                $totalocorrenciasabertas = $row['Total'];
                mysql_free_result($rs);

			?>
                                    <a href="javascript:abrirOcorrencia()">(<span title="Total ocorr�ncias Abertas"><?= $totalocorrenciasabertas;?></span> / <span title="Total ocorr�ncias"><?=$totalocorrencias;?></span>) <span title="Lista todas as ocorr�ncias do Lead">Historico Ocorrencias</span></a>
            <?	if(permissao('ocorrencias', 'ic')){?>
                                    &nbsp;<input type="button" class="botao" value="+" onClick="novaOcorrencia()" title="Nova Ocorr�ncia" />
            <?	}?>
						&nbsp;&nbsp;&nbsp;
		            <?	$sql = "Select count(*) Total From documentos Where CodLead = $codlead and ic_ativo = 1";
		                $rs = sql_query($sql);
		                $row = mysql_fetch_array($rs);
		                $totaldocumentos = $row['Total'];
		                mysql_free_result($rs);?>
						<a href="javascript:abrirDocumentos()">(<?=$totaldocumentos;?>) Historico Documentos</a>
						&nbsp;<input type="button" class="botao" value="+" onClick="novoDocumento()" title="Novo Documento" />

                    </td>
                </tr>
                <tr>
                    <td colspan="2">
            		</td>
                        <?
                            //FUNCAO VERIFICA EMPRESA OPERADORA SE FOR EMBRATEL LIBERA O PARAMENTRO PARA FILTRO
                             if(empresa_operador(5) == 5){
                        ?>	
                                <td>Ponto Embratel:</td>
                                <td><?if($lead['iluminado']==1){?>Iluminado<?}else{?>Nao Iluminado<?};?></td>	
                        <?}else{?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>	
                        <?}?>
				</tr>
				<tr>
					<td colspan="2">
					<?
					$campanha = new campanha(0);
					$campanha->campanha_lead($codlead);
					if ($campanha->getcod_campanha() !=0) {
					?>
						Campanha :
						<form name="dados">
                            <input type="Hidden" name="cod_campanha" value="<?=$campanha->getcod_campanha();?>"></input>
						<select name="resultado_campanha">
							<option></option>
							<option value="1">Sucesso</option>
							<option value="2">Sem Sucesso</option>
						</select>
						&nbsp;
                            <input type="submit" value="Gravar"></input>
						</form>
					<?}?>
					</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
                <tr>
                    <td align="center">&nbsp;</td>
                </tr> 
                <tr>
                    <td align="center" colspan=2>
                        <table width="100%" align="left"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="15" align="left"  class="titulo">&nbsp;Informacoes do Lead / Oportunidade Identificada</td>
                          </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="85%"   align="center" border="1" cellpadding="0" cellspacing="0" class="form">
                            <tr class="grid">
                                <td>
                                    Item
                                </td>
                            <?
                                $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                
                                $result = sql_query($sql);
                                $v_coluna = "";
                                while($row = mysql_fetch_array($result)){
                                
                            ?>
                                <td align="center">
                                    <?=$row['dsc_operadora'];?>
                                </td>   
                            <?
                                $v_coluna ++;
                                }
                                mysql_free_result($result);
                            ?>
                            </tr>
                            <tr>
                                <td align="center">
                                    Cliente
                                </td>                                
                                <?
                                    $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $v_coluna = "";
                                    $cliente_operadora_pk ="";
                                    while($row = mysql_fetch_array($result)){
                                        $sql ="";
                                        $sql.="SELECT nldc.lead_cliente
                                                FROM n_leads_dados_cliente nldc
                                               WHERE nldc.leads_pk =".$codlead;  
                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];
                                    
                                        $results = sql_query($sql);    
                                        $rows = mysql_fetch_array($results);
                                        $cliente_operadora_pk = $rows['lead_cliente']; 
                                        mysql_free_result($results);
                                         
                                                            
                                ?>
                                    <td align="center">
                                        <select name="<?$row['dsc_operadora']?>"  id="<?$row['dsc_operadora']?>" class='formulario_select' onchange="cliente(this.value,<?=$row['cod_operadora'];?>,<?=$codlead;?>)">
                                            
                                            <option value=""></option>
                                 
                                            
                                            <option value="1" <?if($cliente_operadora_pk=='1'){echo "selected";}?>>Sim</option>
                                            <option value="2" <?if($cliente_operadora_pk=='2'){echo "selected";}?> >Nao</option>
                                        </select>
                                    </td>   
                                <?
                                   
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr>
                            <tr>
                                <td align="center">
                                    Base
                                </td>                                
                                <?
                                   $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $v_coluna = "";
                                    $cliente_operadora_pk ="";
                                    while($row = mysql_fetch_array($result)){
                                        $sql ="";
                                        $sql.="SELECT nldc.lead_cliente_base
                                                FROM n_leads_dados_base nldc
                                               WHERE nldc.leads_pk =".$codlead;  
                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];
                                            
                                        $results = sql_query($sql);    
                                        $rows = mysql_fetch_array($results);
                                        $lead_cliente_base = $rows['lead_cliente_base']; 
                                        mysql_free_result($results);
                                        
                                       
                                            
                                ?>
                                    <td align="center">
                                        <select name="<?$row['dsc_operadora']?>"  id="<?$row['dsc_operadora']?>" class='formulario_select' onchange="base(this.value,<?=$row['cod_operadora'];?>,<?=$codlead;?>)">
                                            <option value=""></option>
                                            <option value="1" <?if($lead_cliente_base==1){echo "selected";}?>>Sim</option>
                                            <option value="2" <?if($lead_cliente_base==2){echo "selected";}?> >Nao</option>                                               
                                        </select>
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr>
                            <tr>
                                <td align="center">
                                    DT da ativa��o
                                </td>                                
                                <?
                                    $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $dt_vencimento = "";
                                    while($row = mysql_fetch_array($result)){
                                        $sql ="";
                                        $sql.="SELECT DATE_FORMAT(nldc.dt_ativacao, '%d/%m/%Y') dt_ativacao
                                                FROM n_leads_dados_ativacao nldc
                                               WHERE nldc.leads_pk =".$codlead;  
                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                        $results = sql_query($sql);    
                                        $rows = mysql_fetch_array($results);
                                        $dt_ativacao = $rows['dt_ativacao']; 
                                        mysql_free_result($results);

                                ?>
                                    <td align="center">
                                        <input class="input" value="<?=$dt_ativacao;?>" id="dt_ativacao" name="dt_ativacao" size="12" maxlength="10" onkeypress="mascara(this,datamask)"  onblur="dt_ativacao_contrato(this.value,<?=$row['cod_operadora'];?>,<?=$codlead;?>)"></input>
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr>
                            <tr>
                                <td align="center">
                                    DT Venc Contrato
                                </td>                                
                                <?
                                   $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $dt_vencimento = "";
                                    while($row = mysql_fetch_array($result)){
                                        $sql ="";
                                        $sql.="SELECT DATE_FORMAT(nldc.dt_vencimento, '%d/%m/%Y') dt_vencimento
                                                FROM n_leads_dados_vencimento nldc
                                               WHERE nldc.leads_pk =".$codlead;  
                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                        $results = sql_query($sql);    
                                        $rows = mysql_fetch_array($results);
                                        $dt_vencimento = $rows['dt_vencimento']; 
                                        mysql_free_result($results);

                                ?>
                                    <td align="center">
                                        <input class="input" value="<?=$dt_vencimento;?>" id="dt_vencimento" name="dt_dt_vencimento" size="12" maxlength="10" onkeypress="mascara(this,datamask)"  onblur="vencimento_contrato(this.value,<?=$row['cod_operadora'];?>,<?=$codlead;?>)">
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr>
                            <tr>
                                <td align="center">
                                    Qtde de linhas voz
                                </td>                                
                                <?
                                    $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $dt_vencimento = "";
                                    while($row = mysql_fetch_array($result)){
                                        $sql ="";
                                        $sql.="SELECT nldc.qtde_voz
                                                FROM n_leads_qtde_voz nldc
                                               WHERE nldc.leads_pk =".$codlead;  
                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                        $results = sql_query($sql);    
                                        $rows = mysql_fetch_array($results);
                                        $qtde_voz = $rows['qtde_voz']; 
                                        mysql_free_result($results);

                                ?>
                                    <td align="center">
                                        <input type="text" class="input" value="<?=$qtde_voz;?>" id="qtde_voz" name="qtde_voz" size="3" maxlength="5"  onblur="qtde_voz_lead(this.value,<?=$row['cod_operadora'];?>,<?=$codlead;?>)">
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr> 
                            <tr>
                                <td align="center">
                                    Qtde de linhas Dados
                                </td>                                
                                <?
                                    $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $dt_vencimento = "";
                                    while($row = mysql_fetch_array($result)){
                                        $sql ="";
                                        $sql.="SELECT nldc.qtde_dados
                                                FROM n_leads_qtde_dados nldc
                                               WHERE nldc.leads_pk =".$codlead;  
                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                        $results = sql_query($sql);    
                                        $rows = mysql_fetch_array($results);
                                        $qtde_dados = $rows['qtde_dados']; 
                                        mysql_free_result($results);

                                ?>
                                    <td align="center">
                                        <input type="text" class="input" value="<?=$qtde_dados;?>" id="qtde_dados" name="qtde_dados" size="3" maxlength="5"  onblur="qtde_dados_lead(this.value,<?=$row['cod_operadora'];?>,<?=$codlead;?>)">
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr>                             
                            <tr>
                                <td align="center">
                                    Classifica��o
                                </td>                                
                                <?
                                   $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    
                                    $result = sql_query($sql);
                                    $operadora_pk= "";
                                    $classificacao_operadora_pk = "";
                                    while($row = mysql_fetch_array($result)){
                                        $operadora_pk = $row['cod_operadora'];   
                                        $sql ="";
                                            $sql.="SELECT nldc.classificacao_operadora_pk
                                                    FROM n_leads_dados_classificacao nldc
                                                   WHERE nldc.leads_pk =".$codlead;  
                                            $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                            $results = sql_query($sql);    
                                            $rows = mysql_fetch_array($results);
                                            $classificacao_operadora_pk = $rows['classificacao_operadora_pk']; 
                                            mysql_free_result($results);
                                ?>
                                    <td align="center">
                                        <?
                                          $sql = "";
                                          $sql.="SELECT nco.pk classificacao_pk, nco.dsc_classificacao
                                                     FROM n_classificacao_operadora nco";                                          
                                          $sql.= " WHERE nco.operadora_pk = ".$row['cod_operadora'];
                                   
                                          combo($sql, "classificacao_pk", $classificacao_operadora_pk, " ", "onchange='classificacao_operadora_lead(this.value,$operadora_pk,$codlead)'");
                                        ?>
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr>
                            <tr>
                                <td align="center">
                                    Arquivar Fatura
                                </td>                                
                                <?
                                    $sql ="";
                                    $sql .="SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $cod_operadora = "";
                                    while($row = mysql_fetch_array($result)){
                                       $cod_operadora = $row['cod_operadora']; 
                                ?>
                                    <td align="center">
                                      
                                       <?	
                                                $sql = "";
                                                $sql.= "Select count(*) Total From documentos Where operadora_pk=".$row['cod_operadora'];
                                                $sql.=" and CodLead = $codlead and ic_ativo = 1";
                                               
                                                $rs = sql_query($sql);
                                                $rows = mysql_fetch_array($rs);
                                                $totaldocumentos = $rows['Total'];
                                                mysql_free_result($rs);?>
						<a href="javascript:abrirDocumentos_fatura(<?=$cod_operadora;?>)">(<?=$totaldocumentos;?>) Historico Faturas</a>
						&nbsp;<input type="button" class="botao" value="+" onClick="novoDocumento_fatura(<?=$row['cod_operadora'];?>)" title="Novo Documento" />
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr>
                            <!-- <tr>
                                    <td align="center">
                                        Arquivar Fatura
                                    </td>                                
                                    <?
                                        $sql ="";
                                        $sql .="SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                                FROM operadoras op
                                                     LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                     where op.cod_operadora not in(7,8,4)
                                                GROUP BY op.dsc_operadora";
                                        $result = sql_query($sql);
                                        $cod_operadora = "";
                                        while($row = mysql_fetch_array($result)){
                                           $cod_operadora = $row['cod_operadora']; 
                                    ?>
                                        <td align="center">

                                           <?	
                                                    $sql = "";
                                                    $sql.= "Select count(*) Total From documentos Where operadora_pk=".$row['cod_operadora'];
                                                    $sql.=" and CodLead = $codlead and ic_ativo = 1";

                                                    $rs = sql_query($sql);
                                                    $rows = mysql_fetch_array($rs);
                                                    $totaldocumentos = $rows['Total'];
                                                    mysql_free_result($rs);?>
                                                    <a href="javascript:abrirDocumentos_fatura(<?=$cod_operadora;?>)">(<?=$totaldocumentos;?>) Historico Faturas</a>
                                                    &nbsp;<input type="button" class="botao" value="+" onClick="novoDocumento_fatura(<?=$row['cod_operadora'];?>)" title="Novo Documento" />
                                        </td>   
                                    <?
                                        $v_coluna ++;
                                        }
                                        mysql_free_result($result);
                                    ?>
                                </tr>-->
                                <!--<tr>
                                    <td align="center">
                                        Solicita��o de Propostas
                                    </td>
                                       <?
                                        $sql ="";
                                        $sql .="SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                                FROM operadoras op
                                                     LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                     where op.cod_operadora not in(7,8,4)
                                                GROUP BY op.dsc_operadora";
                                        $result = sql_query($sql);
                                        $cod_operadora = "";
                                        while($row = mysql_fetch_array($result)){


                                    ?>
                                        <td align="center">
                                            &nbsp;<input type="button"  value="Solicita��o Proposta" onClick="enviar_email(<?=$row['cod_operadora'];?>)" title="Solicita��o Propostas"/>
                                        </td>   
                                    <?
                                        $v_coluna ++;
                                        }
                                        //mysql_free_result($result);
                                         //ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => 'Solicita��o de proposta ', 'codtipoocorrencialead' => 6027));
                                    ?>

                                </tr>-->
                                 <tr>
                                    <td class="grid_topo" align="center">
                                        Custo Atual R$
                                    </td>                                
                                    <?
                                        $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                                FROM operadoras op
                                                     LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                     where op.cod_operadora not in(7,8,4)
                                                GROUP BY op.dsc_operadora";
                                        $result = sql_query($sql);
                                        $dt_vencimento = "";
                                        while($row = mysql_fetch_array($result)){
                                            $sql ="";
                                            $sql.="SELECT nlca.vl_custo_atual
                                                    FROM n_leads_custo_atual nlca
                                                   WHERE nlca.leads_pk =".$codlead;  
                                            $sql.="  AND nlca.operadora_pk = ".$row['cod_operadora'];

                                            $results = sql_query($sql);    
                                            $rows = mysql_fetch_array($results);
                                            $vl_custo_atual = number_format($rows['vl_custo_atual'],2,",","."); 
                                            mysql_free_result($results);

                                    ?>
                                        <td align="center">
                                            <input type="text" class="formulario_imput_text" value="<?=$vl_custo_atual;?>" id="vl_custo_atual" name="vl_custo_atual" size="12" maxlength="12"  onblur="custo_atual_lead(this.value,<?=$row['cod_operadora'];?>,<?=$codlead;?>)" onkeypress='mascara(this,Valor)'>
                                        </td>   
                                    <?
                                        $v_coluna ++;
                                        }
                                        mysql_free_result($result);
                                    ?>
                                </tr> 
                                <tr>
                                    <td class="grid_topo" align="center">
                                        Score
                                    </td>                                
                                    <?
                                        $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                                FROM operadoras op
                                                     LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                     where op.cod_operadora not in(7,8,4)
                                                GROUP BY op.dsc_operadora";
                                        $result = sql_query($sql);
                                        $dt_vencimento = "";
                                        while($row = mysql_fetch_array($result)){
                                            $sql ="";
                                            $sql.="SELECT nls.n_score
                                                    FROM n_leads_score nls
                                                   WHERE nls.leads_pk =".$codlead;  
                                            $sql.="  AND nls.operadora_pk = ".$row['cod_operadora'];

                                            $results = sql_query($sql);    
                                            $rows = mysql_fetch_array($results);
                                            $n_score = $rows['n_score']; 
                                            mysql_free_result($results);

                                    ?>
                                        <td align="center">
                                            <input type="text" class="formulario_imput_text" value="<?=$n_score;?>" id="n_score" name="n_score" size="8" maxlength="10"  onblur="score_lead(this.value,<?=$row['cod_operadora'];?>,<?=$codlead;?>)">
                                        </td>   
                                    <?
                                        $v_coluna ++;
                                        }
                                        mysql_free_result($result);
                                    ?>
                                </tr>  
                        </table>
                    </td>                        
                </tr>
            </table>
        </td>    
    </tr>
    <??>
     <!--EXIBE O CONTROLE DE CONTATOS, EDICAO DE LEADS, CONTROLE DE AGENDAS RETORNO, CONTROLE DE LEADS SEM INTERESSE--->
    <tr>
        <td>
        	<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
                <tr>
                    <td align="center">&nbsp;</td>
                </tr>

                <?	if(permissao('agenda', array('dt', 'al'))){?>
                <tr>
                    <td align="center">
                        <table width="100%" align="left"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="15" align="left"  class="titulo">&nbsp;Contato </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                  <td align="center">
                      <table width="1000" border="0" cellpadding="0" cellspacing="0">
                        <tr class="grid">
                          <td width="200">Nome</td>
                          <td width="150">Telefone</td>
                          <td width="150">Bloqueado</td>
                          <td width="150">Celular</td>
                          <td width="150">Bloqueado</td>
                          <td width="200">Email</td>
                        </tr>
                      </table>
                  </td>
                </tr>
                <tr>
                  <td align="center">
                      <div class="iframe" style="height:80px; width:1000">
                          <table width="1000" border="0" align="left" cellpadding="0" cellspacing="0" id="contatos" >
                        <?	$sql = "Select ct.CodContatoLead
                                          ,ct.CodLead
                                          ,SUBSTR(ct.NomeContato, 1, 15) as NomeContato
                                          ,ct.Fone
                                          ,ct.DDD_Fone
                                          ,ct.Ramal_Fone
                                          ,ct.Cel
                                          ,ct.DDD_Cel
                                          ,ct.Email
                                          ,ct.CodSetorContato
                                          ,ct.CodFuncaoContato
                                          ,ct.id_radio
                                          ,ct.tel_contato_bloqueado
                                          ,ct.cel_contato_bloqueado
                                          ,sc.Descricao as NomeSetor
                                          ,fc.Descricao as NomeFuncao ";
                              $sql .= " From contatoslead ct";
                              $sql .= " left join setorcontatos sc on ct.CodSetorContato = sc.CodSetorContato";
                              $sql .= " left join funcaocontato fc on ct.CodFuncaoContato = fc.CodFuncaoContato";
                              $sql .= " where ct.codlead = ".$codlead;
                              $result = sql_query($sql);
                              $cont = 0;
                            while($contato = mysql_fetch_array($result)){?>
                                <tr>
                                  <td width="201" align="center" class="form">&nbsp;
                                       <a href=javascript:visualizarcontato(<?=$contato['CodContatoLead'];?>)><?=$contato['NomeContato'];?></a></td>
                                  <td width="151" align="center" class="form">&nbsp;
                                      <?=(!empty($contato['DDD_Fone'])?"({$contato['DDD_Fone']})&nbsp;":null);?>
                                      <?=$contato['Fone'];?>
                                      <a href="#" onclick="consulta_np_tel_contato('<?=$contato['DDD_Fone'].$contato['Fone'];?>',<?= $cont;?>)" title="Consultar bloqueio Nao Perturbe - Procon/SP"><img border="0" src="../../images/interrogacao.png"></a>
                                  </td>
                                  <td width="151" align="center" class="form">&nbsp;
                                  <span id="tel_contato_descricao_bloqueado<?= $cont;?>">
                                  <?if($contato['tel_contato_bloqueado']==1){
                                      echo "Bloqueado Nao Perturbe";
                                    }
                                    ?>
                                    </span>
                                  </td>
                                  <td width="151" align="center" class="form">&nbsp;
                                      <?=(!empty($contato['DDD_Cel'])?"({$contato['DDD_Cel']})&nbsp;":null);?>
                                      <?=$contato['Cel'];?>
                                      <a href="#" onclick="consulta_np_cel_contato('<?=$contato['DDD_Cel'].$contato['Cel'];?>', <?= $cont;?>)" title="Consultar bloqueio Nao Perturbe - Procon/SP"><img border="0" src="../../images/interrogacao.png"></a>
                                  </td>
                                  <td width="151" align="center" class="form">&nbsp;
                                  <span id="cel_contato_descricao_bloqueado<?= $cont;?>">
                                  <?
                                  if($contato['cel_contato_bloqueado']==1){
                                      echo "Bloqueado Nao Perturbe";
                                  }
                                  ?>
                                  </span>
                                  </td>
                                  <td width="201" align="center" class="form">&nbsp;
                                      <a href="mailto:<?=$contato['Email'];?>"><?=$contato['Email'];?></a>
                                  </td>
                                </tr>
                        <? }
                              mysql_free_result($result);?>
                          </table>
                      </div>
                  </td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center"><?	if(permissao('leads', 'al')){?>
                      <input name="button" type="button" class="botao" onClick="editarCliente()" value="Editar Lead" />
                      <?	}
                if(permissao('agendaretorno', 'ic')){?>
                          <?	}?>
            &nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    </tr>
        <!--EXIBE CONTROLE DE AGENDA DE VISITA--->
    <tr>
        <td>
        	<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
                 <tr>
                    <td align="center">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        <table width="100%" align="left"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="15" align="left"  class="titulo">&nbsp;&Uacute;ltima Visita </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
					<td align="left">
			        	<table width="95%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
                    <?		//Pesquisa os dados da ultima agenda.
                    $sql = "Select a.*, t.Descricao Tipo, s.Descricao Status, ui.Nome UsuarioInterno, ui1.Nome AgendadoPara, c.NomeContato Contato,CONCAT(a.Endereco, IFNULL(CONCAT(', ', a.Numero), ''), IFNULL(CONCAT(' - ', a.Complemento), '')) Endereco1";
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
                    <tr>
                        <td width="141">&nbsp;C&oacute;digo Agenda:</td>
                        <td width="363"><?=@$visita['CodAgendaLead'];?>
                          &nbsp; - &nbsp;
                          <?=(!empty($visita['DataCadastro'])?date('d/m/Y \�\s H:i:s', strtotime($visita['DataCadastro'])):null);?></td>
                        <?
                        $sql = "Select count(codagendalead) Total From agendaslead Where CodLead = $codlead";
                        $rs1 = sql_query($sql);
                        $row1 = mysql_fetch_array($rs1);
                        $totalagenda = $row1['Total'];
                        mysql_free_result($rs1);
        ?>
                        <td colspan="2"><a href="javascript:abrirHistorico()">(<?=$totalagenda?>) Hist&oacute;rico das visitas</a></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Tipo Agendamento:</td>
                        <td><?=@$visita['Tipo'];?></td>
                        <td width="202">Status:</td>
                        <td width="294"><?=@$visita['Status'];?></td>
                    </tr>
                    <Tr>
                        <td>&nbsp;Agendado por:</td>
                        <td><?=@$visita['UsuarioInterno'];?></td>
                        <td>Agendado para:</td>
                        <td><?=@$visita['AgendadoPara'];?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Data e Hor&aacute;rio:</td>
                        <td><?=(!empty($visita['DataHorario'])?date('d/m/Y \�\s H:i', strtotime($visita['DataHorario'])):null);?></td>
                        <td>T&eacute;rmino:</td>
                        <td><?=(!empty($visita['Termino'])?date('H:i', strtotime($visita['Termino'])):null);?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Consultor:</td>
                        <td colspan="3">
                        <?if(!empty($visita['CodAgendaLead'])){
                            $sql = "select u.Nome ";
                            $sql .= " from usuariosinternos u ";
                            $sql .= " inner join agendagerenteconta ag on u.codusuariointerno = ag.codgerenteconta ";
                            $sql .= " where ag.codagendalead = {$visita['CodAgendaLead']}";
                            $result1 = sql_query($sql);
                            while($gerentevisita = mysql_fetch_array($result1)){?>
                                <?=$gerentevisita['Nome'];?>
                                <br />
                            <?} mysql_free_result($result1);}?>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;Descri&ccedil;&atilde;o:</td>
                        <td colspan="3"><?=$visita['Descricao'];?></td>
                    </tr>
                        <tr>
                        <td>&nbsp;Endere�o Vis�ta:</td>
                        <td colspan="3" align="left"><?=$visita['Endereco1'];?></td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">&nbsp;&nbsp;
                        <?if(permissao('agenda', 'ic')){?>
                            <input name="button2" type="button" class="botao" onClick="novaAgenda()" value="Agendar Visita" />
                            <?		}
                            if(!empty($codagendalead) && permissao('agenda', array('al', 'dt'))){?>
                            <input name="button2" type="button" class="botao" onClick="editarAgenda(<?=$codagendalead;?>)" value="Classificar Visita" />
                            <? 		}?>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center">
              <?	mysql_free_result($result);?>
            </td>
        </tr>
    </table>
        <!--NOVO MODULO DE PROPOSTAS--->
    <tr>
        <td>
        	<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
				<tr>
					<td colspan="2">
						<table width="100%" align="left"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
						<tr>
						  <td height="15" align="left"  class="titulo">&nbsp;Nova Proposta</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>	
						<table width="80%"  border='0'  align="center" cellpadding="0" cellspacing="0" >
							<tr>
								<td>						
									<table width="100%"  border='0' bordercolor="#CCCCCC" align="left" cellpadding="0" cellspacing="0" >									
										<thead>
											<tr class="grid">
												<th width="30" nowrap="true">
													ID
												</th>
												<th width="95"  nowrap="true">
													Dt Cadastro
												</th>
												<th width="95"  nowrap="true">
													Dt Validade
												</th>
												<th width="95" nowrap="true">
													Dt Envio
												</th>	
												<th width="95" nowrap="true">
													Dt Previs�o<br>Recebimento
												</th>	
												<th width="95"  nowrap="true">
													Dt<br>Recebimento
												</th>
												<th width="95" nowrap="true">
													Dt Input<br>Pedido Operadora
												</th>					
												<th width="95" >
													Dt Ativa��o
												</th>
												<th width="95">
													Vl Proposta
												</th>	
												<th width="95">
													Dt Validade
												</th>	
												<th width="95">
													Operadora
												</th>	
												<th width="94" nowrap="true">
													A��o
												</th>
											</tr>
										</thead>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<div class="iframe1" style="height:80px; width:100%">
										<table width="100%"  border='0' bordercolor="#CCCCCC" align="left" cellpadding="0" cellspacing="0" >		
											
											<?$sql = "Select
													  np.pk
													  ,DATE_FORMAT(np.dt_cadastro, '%d/%m/%Y') dt_cad
													  ,ndp.pk as data_proposta_pk
													  ,np.dt_cancelamento
													  ,np.operador_pk
													  ,DATE_FORMAT(np.dt_validade, '%d/%m/%Y') dt_validade
													  ,np.vl_total_proposta
													  ,op.dsc_operador
													from n_propostas np
													left join n_itens_propostas nip on np.pk = nip.propostas_pk
													left join n_produtos npr on nip.produtos_pk = npr.pk
													left join n_datas_proposta ndp on np.pk = ndp.propostas_pk
													inner join operador op on op.cod_operador = np.operador_pk
													where np.leads_pk=".$codlead;
											   $sql .= " group by np.pk
														order by np.dt_cadastro desc";
											   $result = sql_query($sql);
											   while($row = mysql_fetch_array($result)){
												   $v_dt_previsao = n_data_proposta($row['pk'],$row['data_proposta_pk'],"previsao_recebe_assinatura");		
												   $vl_proposta  = $row['vl_total_proposta'];	
                                                   $operador_pk = $row['operador_pk'];
                                                   $vencimento = "Vencida";
                                                   
											?>
												<tr>
													<td width="30" align="center" class="form">
														<?if($row['dt_cancelamento']==""){?>
															<a href="#"   onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=$row['pk'];?>
															</a>
														<?}else{?>
															<a href="#"   onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=$row['pk'];?>
															</a>
														 <?}?>
													</td>
													<td width="95" align="center" class="form">
														  <?if($row['dt_cancelamento']==""){?>
															<a href="#"   onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?echo $row['dt_cad']."&nbsp;";?>
															</a>
														<?}else{?>
															<a href="#"   onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?echo $row['dt_cad']."&nbsp;";?>
															</a>
														 <?}?>	
													</td>
													<td width="95" align="center" class="form">
														<?if($row['dt_cancelamento']==""){?>
															<a href="#"   onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=$row['dt_validade'];?>&nbsp;	
															</a>
														<?}else{?>
															<a href="#"   onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=$row['dt_validade'];?>&nbsp;	
															</a>
														<?}?>													
													</td>
													<td width="95" align="center" class="form">
														<?if($row['dt_cancelamento']==""){?>
															<a href="#"   onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=n_data_proposta($row['pk'],$row['data_proposta_pk'],"envio_lead");?>&nbsp;	
															</a>
														<?}else{?>
															<a href="#"   onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=n_data_proposta($row['pk'],$row['data_proposta_pk'],"envio_lead");?>&nbsp;	
															</a>
														<?}?>													
													</td>
													<td width="95"  align="center" class="form">
														<?if($row['dt_cancelamento']==""){?>
															<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=n_data_proposta($row['pk'],$row['data_proposta_pk'],"previsao_recebe_assinatura");?>&nbsp;
															</a>
														<?}else{?>
															<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=n_data_proposta($row['pk'],$row['data_proposta_pk'],"previsao_recebe_assinatura");?>&nbsp;
															</a>
														<?}?>	
													</td>
													<td width="95" align="center" class="form">
														<?if($row['dt_cancelamento']==""){?>
															<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=n_data_proposta($row['pk'],$row['data_proposta_pk'],"recebe_assinatura");?>&nbsp;
															</a>
														<?}else{?>
																<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=n_data_proposta($row['pk'],$row['data_proposta_pk'],"recebe_assinatura");?>&nbsp;
															</a>
														<?}?>	
													</td>
													<td width="95" align="center" class="form">
														<?if($row['dt_cancelamento']==""){?>
															<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=n_data_proposta($row['pk'],$row['data_proposta_pk'],"envio_contrato_operadora");?>&nbsp;
															</a>
														<?}else{?>
															<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=n_data_proposta($row['pk'],$row['data_proposta_pk'],"envio_contrato_operadora");?>&nbsp;
															</a>
														<?}?>
													</td>
													<td width="95" align="center" class="form">
														<?if($row['dt_cancelamento']==""){?>
															<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=n_data_proposta($row['pk'],$row['data_proposta_pk'],"cliente");?>&nbsp;
															</a>
														<?}else{?>
															<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=n_data_proposta($row['pk'],$row['data_proposta_pk'],"cliente");?>&nbsp;
															</a>
														<?}?>	
													</td>													
													<td width="95" align="center" class="form">
														<?if($row['dt_cancelamento']==""){?>
															<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=number_format($vl_proposta,2,",",".");?>
															</a>
														<?}else{?>
															<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?=number_format($vl_proposta,2,",",".");?>
															</a>
														<?}?>
													</td>
													<td width="94" align="center" class="form">
														<?if($row['dt_cancelamento']==""){?>

                                                        <?if(DataYMD($row['dt_validade'])< date('Y-m-d')){?>
                                                             <font color=red>Vencida</font>
                                                        <?}else{?>
                                                             <a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
                                                             <?echo $row['dt_validade']."&nbsp;";?>
                                                             </a>
                                                         <?}?>
                                                             <?}else{?>
                                                                <?if(DataYMD($row['dt_validade'])< date('Y-m-d')){?>
                                                             <font color=red>Vencida</font> 
                                                        <?}else{?>
                                                             <a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
                                                             <?echo $row['dt_validade']."&nbsp;";?>
                                                             </a>
                                                         <?}?>
														<?}?>                                                        
													</td>
													<td width="93" align="center" class="form">
														<?if($row['dt_cancelamento']==""){?>
															<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?echo $row['dsc_operador']."&nbsp;";?>
															</a>
														<?}else{?>
															<a href="#"  onClick="upd_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)">
																<?echo $row['dsc_operador']."&nbsp;";?>
															</a>
														<?}?>  
													</td>
													<td width="94" align="center" class="form">
														
														<?if($row['dt_cancelamento']==""){?>
															
															<?if($row['dt_validade']>= date('d/m/y')){?>
                                                                <a href="#" onClick="imprimir_proposta(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)"><img border=0 src='../../images/impressora.png' width=20 height=18 title="Imprimir Proposta" ></a>
                                                            <?}?>															
															<?if(!empty($v_dt_previsao)){
                                                                if(permissao('dataproposta', 'ic') || $Root){
                                                                    if(DataYMD($row['dt_validade'])>= date('Y-m-d')){
                                                            ?>                                                                                                                        
                                                                        <a href="#" onClick="processo_adm(<?=$row['pk'];?>,<?=$row['operador_pk'];?>)"><img border=0 src='../../images/bko2.jpg' width=20 height=18 title="Processo ADM" ></a>
															<?	
                                                                    }
                                                                }
															}
                                                            ?>	
															<!--<?//if(!empty($v_dt_previsao)){
																//if(permissao('dataproposta', 'ic') || $Root){?>
                                                            <?//if($operador_pk==1){?>
                                                             <a href="#" onClick="contrato(<?=$row['pk'];?>)"><img border=0 src='../../images/Contrato.png' width=20 height=18 title="Contrato" ></a>

                                                            <? //}?>
															
															<?//}
                                                            
															//}?>-->
															<a href="#" onClick="cancelar_proposta(<?=$row['pk'];?>)"><img border=0 src='../../images/cancelar.jpg' width=20 height=18 title="Cancelar Proposta" ></a>
														<?}else{?>
                                                            
															<font color=red>Cancelada</font> 
														<?}?>														
													</td>
												</tr>
											<? }
											   mysql_free_result($result);
											?>											
										</table>
									</div>
								</td>
							</tr>
							<?if(permissao('proposta', array('dt', 'ic', 'al'))){?>
								<tr>
									<td align="center" valign="top">	<br>
										<a href="#" onClick="add_new_proposta()"><img border=0 src='../../images/adicionar.png' width=20 height=20 title="Adicionar Proposta" ></a>&nbsp;
											
											<?
												$sql = "Select
														    o.cod_operador operador_pk
															,o.dsc_operador
														from operador o";
												$sql .="	inner join empresa_operador eo on o.cod_operador = eo.cod_operador";
												if(!empty($_SESSION['cod_empresa'])){
													$sql .=" where eo.cod_empresa=".$_SESSION['cod_empresa'];
												}
												$sql .=" group by o.dsc_operador";
												
												combo($sql,"operador_pk", $operador_pk, "", " ");
											?>		
									</td>
								</tr>
							<?}?>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>								
				
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>	
		</td>		
	</tr>
	<?
	$sql = "select
			p.CodProposta
			, p.Versao
			, mp.Valor
			, mp.Calculado
			, p.DataCadastro
			,CASE dp.nome_data WHEN 'envio_lead' THEN dp.valor_data else p.DataEnvio  END DataEnvio
			,CASE dp1.nome_data WHEN 'previsao_recebe_assinatura' THEN dp1.valor_data else p.DataRecebimento END DataRecebimento
			,CASE dp2.nome_data WHEN 'envio_contrato_operadora' THEN dp2.valor_data else p.DataEnvioContrato END DataEnvioContrato
			,CASE dp3.nome_data WHEN 'entrega_aparelho' THEN dp3.valor_data else p.DataEntregaAparelho END DataEntregaAparelho
            , p.DataCancelamento
			, pr.Nome as Produto
			,p.codlead
			,date_format(p.dt_vencimentocontrato,'%d/%m/%Y') vencimentocontrato
			,p.DataCancelamento
			from propostas p
			left join usuariosinternos u on p.CodUsuarioInterno = u.CodUsuarioInterno
			left join produtos pr on p.CodProduto = pr.CodProduto
			left join modulosproposta mp on mp.CodProposta = p.CodProposta AND p.Versao = mp.Versao AND mp.CodLead = p.CodLead and mp.ID = 'qtdelinhas'
			left join data_proposta dp on p.CodLead = dp.codlead and p.CodProposta = dp.codproposta and p.Versao = dp.versao AND nome_data = 'envio_lead'
			left join data_proposta dp1 on p.CodLead = dp1.codlead and p.CodProposta = dp1.codproposta and p.Versao = dp1.versao AND dp1.nome_data = 'previsao_recebe_assinatura'
			left join data_proposta dp2 on p.CodLead = dp2.codlead and p.CodProposta = dp2.codproposta and p.Versao = dp2.versao AND dp2.nome_data = 'envio_contrato_operadora'
			left join data_proposta dp3 on p.CodLead = dp3.codlead and p.CodProposta = dp3.codproposta and p.Versao = dp3.versao AND dp3.nome_data = 'entrega_aparelho'";
	$sql .= " where p.CodLead = $codlead

	 group by p.CodLead,p.CodProposta,p.Versao
	 Order By p.CodProposta Desc, p.Versao Desc";
	 
	$tipo = mysql_query($sql);
	$num = mysql_num_rows($tipo);	
	if(!empty($num)){
	?>
	<!--MODULO DE PROPOSTAS ANTIGO-->
	<tr>
        <td>
        	<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
				<tr>
					<td colspan="2">
						<table width="100%" align="left"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
						<tr>
						  <td height="15" align="left"  class="titulo">&nbsp;Propostas Antigas</td>
						</tr>
						</table>
					</td>
				</tr>
			   <tr>
					<td colspan="2"  align="center">
						<table width="1000" border="0" cellpadding="0" cellspacing="0">
							<tr class="grid">
								  <th width="28">#</th>
								  <th width="168">Vers&atilde;o Proposta</th>
							  <th width="81" align="center">Qtd. Linhas</th>
								  <th width="143">Dt Envio</th>
								  <th width="145">Dt Recebimento</th>
								  <th width="143">Dt Envio Para Oper</th>
								  <th width="148">Entrega de Aparelhos</th>
								  <th width="148">Vencimento Contrato</th>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<div class="iframe" style="height: 90px; width:1000px">
							<table width="1000" border="0" cellpadding="0" cellspacing="0" id="tabelaproposta" >
								<?
								$result = sql_query($sql);
								While($proposta = mysql_fetch_array($result)){
								$linhas = ($proposta['Calculado']?$proposta['Calculado']:(!empty($proposta['Valor'])?' ' . number_format($proposta['Valor'], 0, ',', '.'):null));
								
								?>
									<tr align="center">
										<td width="29" class="form" align="left">&nbsp;
									  <input  type='radio' name='rl' value="<?=$proposta['CodProposta'] . '.' . $proposta['Versao'];?>" /></td>
										<td width="167" class="form">&nbsp;<?=$proposta['CodProposta'] . '.' . $proposta['Versao'] . '&nbsp;-&nbsp;' . $proposta['Produto'];?>
											<?
											if(!empty($proposta["DataCancelamento"])){
												echo "<font color=Red><b>(Cancelada)</b></font>";
												
											}
											?>
										</td>
										<td width="82" class="form" style="text-align:center">&nbsp;<?=$linhas;?></td>
										<td width="144" class="form">&nbsp;<?=(!empty($proposta['DataEnvio'])?date('d/m/Y', strtotime($proposta['DataEnvio'])):null);?></td>
										<td width="144" class="form">&nbsp;<?=(!empty($proposta['DataRecebimento'])?date('d/m/Y', strtotime($proposta['DataRecebimento'])):null);?></td>
										<td width="144" class="form">&nbsp;<?=(!empty($proposta['DataEnvioContrato'])?date('d/m/Y', strtotime($proposta['DataEnvioContrato'])):null);?></td>
										<td width="146" class="form">&nbsp;<?=(!empty($proposta['DataEntregaAparelho'])?date('d/m/Y', strtotime($proposta['DataEntregaAparelho'])):null);?></td>
										<td width="146" class="form">&nbsp;<?=$proposta['vencimentocontrato'];?></td>
                                    </tr>
										<?	}?>
							 </table>
						</div>
					</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
					<td align="center" colspan=2>
						<?if(permissao('proposta', array('dt', 'ic', 'al'))){?>
							Selecionado:
						<?}?>
						<?if(permissao('proposta', 'dt')){?>
							<input name="button4" type="button" onClick="PropostaImp()"  value="Imprimir" />
							&nbsp;
							<?if(permissao('proposta', 'al')){?>
								<input name="button4" type="button" onClick="editaProposta()"  value="Visualizar" />
                                
								<input name='button4' type='button' onClick='enviar_email()'  value='enviar' />
							<?}?>
						<?}?>  					
					</td>
				</tr>
				<tr>
					<td width="50%">&nbsp;</td>
					<td width="49%">&nbsp;</td>
				</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<?}?>		
<? } ?>
</form>
<div id="divImagem" style="display:none; position:absolute; top:150px; left: 30%;>
</div>
<div id='recebe_up_basico'>&nbsp; </div>
</body>
</html>
<?	if($_REQUEST['Imagem']){?>
<script>
	showImg();
</script>
<?}	include_once "../../libs/desconectar.php";?>
