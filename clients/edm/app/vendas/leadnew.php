<?
require "../../libs/ajax/xajax_core/xajax.inc.php"; // XAJAX
require "../../libs/funBuscarCep.php"; // Função que faz a busca do cep
require "../../libs/naoperturbe.php"; // Função que faz a busca do nao perturbe procon

$checkedcpf = "";
$checkedcnpj = "checked";
$cnpjcpf_mask = "cnpj";

$ajax = new xajax();
$ajax->registerFunction("buscaCep");
$ajax->registerFunction("buscar_nao_perturbe");

function buscar_nao_perturbe($telefone, $descricao_bloqueado, $bloqueado){

	//Instancia o objeto XAJAX response
	$objResponse = new xajaxResponse('ISO-8859-1');
	$resultado_busca = naoperturbe($telefone);

	$objResponse->assign($bloqueado, "value", $resultado_busca['bloqueado']);
	$objResponse->assign($descricao_bloqueado, "innerHTML", $resultado_busca['descricao']);

	return $objResponse;
}

##################################### BUSCA CEP #####################################
function buscaCep($cep, $endereco, $bairro, $cidade, $uf){

	//Instancia o objeto XAJAX response
	$objResponse = new xajaxResponse('ISO-8859-1');

	if(empty($cep)){
		return $objResponse;
	}

	//$cep = str_replace("-", "", $cep);

	$resultado_busca = busca_cep($cep); // Retorna um array

	// Coloca os valores dos arrays nos campos do formulário
	$objResponse->assign($endereco, "value", $resultado_busca['tipo_logradouro']." ".$resultado_busca['logradouro']);
	$objResponse->assign($bairro, "value", $resultado_busca['bairro']);
	$objResponse->assign($cidade, "value", $resultado_busca['cidade']);
	$objResponse->assign($uf, "value", $resultado_busca['uf']);

	// Retorna a resposta de XML gerada pelo objeto do xajaxResponse
	return $objResponse;
}

// Manda o ajax processar os pedidos acima
$ajax->processRequest();
include_once "../../libs/maininclude.php";
$ajax->printJavascript('../../libs/ajax/');


	include_once "../../libs/cla.leads.php";
	include_once "../../libs/combo.php";
	include_once "../../libs/cla.combo.php";
	include_once( "../../libs/cla.comboajax.php" ) ;
	include_once( "../../libs/cla.logg.php" ) ;


	$_REQUEST['CodLead'] = @$_REQUEST['codlead'];


	if(!empty($_REQUEST['excluir'])){
		if(leads::excluir($_REQUEST['CodLead']))
		{
			javascriptalert('Operação executada com sucesso!!!' , false ); ?>

			<script type="text/javascript" language="javascript">
			if(opener)
			{
				if(opener.top.pagina)
				{
					opener.top.pagina.location.href = "../../blank.php" ;
				}
			}
			self.close();
			</script>
			<?
			exit;
		}
	}

	if(!empty($_REQUEST['enviar'])){
		if(!empty($_REQUEST['datacadastro'][0]) && !empty($_REQUEST['datacadastro'][1]))
			$_REQUEST['datacadastro'] = dataYMD($_REQUEST['datacadastro'][0]).' '.$_REQUEST['datacadastro'][1];
		else
			$_REQUEST['datacadastro'] = null;
		if(!empty($_REQUEST['vencimentocontrato']))
			$_REQUEST['vencimentocontrato'] = dataYMD($_REQUEST['vencimentocontrato']);
		else
			$_REQUEST['vencimentocontrato'] = null;
		if(!empty($_REQUEST['ativacao']))
			$_REQUEST['ativacao'] = dataYMD($_REQUEST['ativacao']);
		else
			$_REQUEST['ativacao'] = null;
		if(empty($_REQUEST['CodLead'])){
			if($codlead = leads::adicionar($_REQUEST)){
				javascriptalert('Operação executada com sucesso!!!', false, false);?>
	<script type="text/javascript" language="javascript">
		if(opener){
			if(opener.top.pagina)
				opener.top.pagina.location.href = "leadgerenciamentores.php?codlead=<?=$codlead;?>";
		}
		self.close();
	</script>
<?			}else{

				javascriptalert('Falha na operação!!!');
			}
		}else{
			if(leads::alterar($_REQUEST['CodLead'], $_REQUEST))
				javascriptalert('Operação executada com sucesso!!!');
			else
				javascriptalert('Falha na operação!!!');
		}
	}

	if(!empty($_REQUEST['CodLead'])){
		$acao = 'upd';

		$sql  = "Select
		l.PontoRef
		, l.cod_polo
		, l.Ativacao
		, l.VencimentoContrato
		, l.CodMotivo
		, l.mailing_pk
		, l.CodAtendente
		, l.Segmento
		, l.CodStatusClassificacaoLead
		, l.DataCadastro
		, l.CodGerenteConta
		, l.CodLead
		, l.RazaoSocial
		, l.NomeFantasia
		, l.CNPJ_CPF
		, l.IE
		, l.InscricaoMunicipal
		, l.Site
		, l.ddd
		, l.tel
		, l.dddfax
		, l.fax
		, l.Endereco
		, l.Numero
		, l.Complemento
		, l.Bairro
		, l.Cep
		, l.cidade
		, l.uf
		, l.qtde_linhas
		, gc.Nome GerenteConta
		, a.Nome Atendente
		, m.Descricao Motivo
		, s.Descricao StatusClassificacaoLead
		, l.senha_cliente
		, l.identificacao
		, l.tel_bloqueado
		, l.fax_bloqueado
		, l.iluminado
		, l.tipo_pessoa
		, l.id_fornecedor
		From leads l
		left join usuariosinternos gc on l.CodGerenteConta = gc.CodUsuarioInterno
		left join usuariosinternos a on l.CodAtendente = a.CodUsuarioInterno
		left join motivoslead m on l.CodMotivo = m.CodMotivoLead
		left join statusclassificacaolead s on l.CodStatusClassificacaoLead = s.CodStatusClassificacaoLead
		Where CodLead = " . mysqlnull($_REQUEST['CodLead']);

		$result = sql_query($sql);
		if($row = mysql_fetch_array($result)){
			array_merge($row, $_REQUEST);
			$_REQUEST = $row;
		}

		//efetua o tratamento para marcar cpf ou cnpj.
		if(strlen($_REQUEST['CNPJ_CPF']) == 14){
			$checkedcpf = "checked";
			$checkedcnpj = "";
			$cnpjcpf_mask = "cpf";
		}
		else{
			$checkedcpf = "";
			$checkedcnpj = "checked";
			$cnpjcpf_mask = "cnpj";
		}

		mysql_free_result($result);
	}else{
		$_REQUEST['CodGerenteConta'] = ($GerenteContas?$_SESSION['codusuario']:null);
		$_REQUEST['CodAtendente'] = ($Atendente?$_SESSION['codusuario']:null);
		$_REQUEST['CodStatusClassificacaoLead'] = 2;
		$_REQUEST['StatusClassificacaoLead'] = 'Target';
	}

	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 <!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>

<!--Cabeçalho-->
<title>Leads</title>

<?	include_once "../../libs/head.php";?>

 <!--Comandos Javascript-->
<script type="text/javascript">

function incluirContato(){

	tel_contato_descricao_bloqueado.innerHTML = "";
	celular_contato_descricao_bloqueado.innerHTML = "";

	var frm = $('formcontato')
	Form.reset(frm)
	var acao = $('contatoacao')
	$('codcontatolead').value = ''
	acao.value = 'add'
	frm.style.display = 'block'
	createSimpleBox(frm)
	Form.focusFirstElement(frm)
}

function editarContato(){	
	tel_contato_descricao_bloqueado.innerHTML = "";
	celular_contato_descricao_bloqueado.innerHTML = "";

	var rd = document.getElementsByName('rd')
	var tb = $('contatos')
	var frm = $('formcontato')
	var acao = $('contatoacao')	
	acao.value = 'edit'
	for(var i = 0; i < rd.length; i++){
		if(rd[i].checked){
			
			$('codcontatolead').value = (document.getElementsByName('contato[' + rd[i].value + '][codcontatolead]')[0]).value
			$('nomecontato').value = (document.getElementsByName('contato[' + rd[i].value + '][nomecontato]')[0]).value
			$('ddd_fone').value = (document.getElementsByName('contato[' + rd[i].value + '][ddd_fone]')[0]).value
			$('fone').value = (document.getElementsByName('contato[' + rd[i].value + '][fone]')[0]).value
			$('tel_contato_bloqueado').value = (document.getElementsByName('contato[' + rd[i].value + '][tel_contato_bloqueado]')[0]).value
			$('ramal_fone').value = (document.getElementsByName('contato[' + rd[i].value + '][ramal_fone]')[0]).value
			$('id_radio').value = (document.getElementsByName('contato[' + rd[i].value + '][id_radio]')[0]).value
			$('ddd_cel').value = (document.getElementsByName('contato[' + rd[i].value + '][ddd_cel]')[0]).value
			$('cel').value = (document.getElementsByName('contato[' + rd[i].value + '][cel]')[0]).value
			$('cel_contato_bloqueado').value = (document.getElementsByName('contato[' + rd[i].value + '][cel_contato_bloqueado]')[0]).value
			$('email').value = (document.getElementsByName('contato[' + rd[i].value + '][email]')[0]).value
			$('n_rg').value = (document.getElementsByName('contato[' + rd[i].value + '][n_rg]')[0]).value
			$('n_cpf').value = (document.getElementsByName('contato[' + rd[i].value + '][n_cpf]')[0]).value
			$('codsetorcontato').value = document.getElementsByName('contato[' + rd[i].value + '][codsetorcontato]')[0].value
			$('codfuncaocontato').value = document.getElementsByName('contato[' + rd[i].value + '][codfuncaocontato]')[0].value
			frm.style.display = 'block'
			createSimpleBox(frm)
			Form.focusFirstElement(frm)
		}
	}
}

function excluirContato(){
	var rd = document.getElementsByName('rd')
	for(var i = 0; i < rd.length; i++){
		if(rd[i].checked){
			var obj = rd[i].parentNode
			while(obj){
				if(obj.tagName == 'TR'){
					Element.remove(obj)
				}
				obj = obj.parentNode
			}
		}
	}
}

function salvarContato(e){
	
	if(!validateForm(Event.findElement(e, 'form'))){
		Event.stop(e)
		return false
	}
	var element = Event.element(e)
	var frm = $('formcontato')
	var acao = $('contatoacao')
	if(acao.value == 'edit'){
		var rd = document.getElementsByName('rd')
		for(var i = 0; i < rd.length; i++){
			if(rd[i].checked){
				var obj = rd[i].parentNode
				while(obj){
					if(obj.tagName == 'TR'){
						Element.remove(obj)
					}
					obj = obj.parentNode
				}
			}
		}
	}
	var codcontato = $('codcontatolead')
	var codsetorcontato = $('codsetorcontato')
	var codfuncaocontato = $('codfuncaocontato')
	var nomecontato = $('nomecontato')
	var ddd_fone = $('ddd_fone')
	var fone = $('fone')
	var tel_contato_bloqueado = $('tel_contato_bloqueado')
	var ramal = $('ramal_fone')
	var id_radio = $('id_radio')
	var ddd_cel = $('ddd_cel')
	var cel = $('cel')
	var cel_contato_bloqueado = $('cel_contato_bloqueado')
	var email = $('email')
	var n_rg = $('n_rg')
	var n_cpf = $('n_cpf')
	var t = $('contatos')
	var tb = t.tBodies[0]
	var r = tb.insertRow(tb.rows.length)
	var td = r.insertCell(r.cells.length)
	cont = (document.getElementsByName('rd')).length + 1
	td.innerHTML = '<input type="radio" name="rd" value="' + cont + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][codcontatolead]" value="' + codcontato.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][nomecontato]" value="' + nomecontato.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][fone]" value="' + fone.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][ddd_fone]" value="' + ddd_fone.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][tel_contato_bloqueado]" value="' + tel_contato_bloqueado.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][ramal_fone]" value="' + ramal.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][id_radio]" value="' + id_radio.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][cel]" value="' + cel.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][ddd_cel]" value="' + ddd_cel.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][cel_contato_bloqueado]" value="' + cel_contato_bloqueado.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][email]" value="' + email.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][n_rg]" value="' + n_rg.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][n_cpf]" value="' + n_cpf.value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][codsetorcontato]" value="' + codsetorcontato.options[codsetorcontato.selectedIndex].value + '" />'
	td.innerHTML = td.innerHTML + '<input type="hidden" name="contato[' + cont + '][codfuncaocontato]" value="' + codfuncaocontato.options[codfuncaocontato.selectedIndex].value + '" />'
	r.insertCell(r.cells.length).innerHTML = nomecontato.value
	r.insertCell(r.cells.length).innerHTML = codsetorcontato.options[codsetorcontato.selectedIndex].text
	r.insertCell(r.cells.length).innerHTML = codfuncaocontato.options[codfuncaocontato.selectedIndex].text
	r.insertCell(r.cells.length).innerHTML = (ddd_fone.value != '' && fone.value != '')?"(" + ddd_fone.value + ") " + fone.value:''
	if(tel_contato_bloqueado.value == 1)
		r.insertCell(r.cells.length).innerHTML = "Bloqueado Não Perturbe";
	else
		r.insertCell(r.cells.length).innerHTML = "Liberado";

	r.insertCell(r.cells.length).innerHTML = ramal.value
	r.insertCell(r.cells.length).innerHTML = id_radio.value
	r.insertCell(r.cells.length).innerHTML = (ddd_cel.value != '' && cel.value != '')?"(" + ddd_cel.value + ") " + cel.value:''

	if(cel_contato_bloqueado.value == 1)
		r.insertCell(r.cells.length).innerHTML = "Bloqueado Não Perturbe";
	else
		r.insertCell(r.cells.length).innerHTML = "Liberado";

	r.insertCell(r.cells.length).innerHTML = email.value
	r.insertCell(r.cells.length).innerHTML = n_rg.value
	r.insertCell(r.cells.length).innerHTML = n_cpf.value
	closeSimpleBox(frm)
}

function cpfoucnpj(vlr){

	var frm = document.forms[0];
	frm.cnpj_cpf.value = "";
	if (vlr == "PJ"){
		frm.cnpj_cpf.onkeypress = function onkeypress(event) {mascara(frm.cnpj_cpf,cnpj);};
		frm.cnpj_cpf.onblur = function onblur(event) {}
	}
	else if(vlr == "PF"){
		frm.cnpj_cpf.onkeypress = function onkeypress(event) {mascara(frm.cnpj_cpf,cpf);};
		frm.cnpj_cpf.onblur = function onblur(event) {}
	}
	else{
		frm.cnpj_cpf.onkeypress = function onkeypress(event) {frm.cnpj_cpf.value = "";};
		frm.cnpj_cpf.onblur = function onblur(event) {frm.cnpj_cpf.value = "";}
	}
}

Event.observe(window, 'load', function(e){
	Event.observe('incluircontato', 'click', incluirContato);
	Event.observe('editarcontato', 'click', editarContato);
	Event.observe('salvarcontato', 'click', salvarContato);
	Event.observe('excluircontato', 'click', excluirContato);
});

	//Função de Caixa de Sugestoes Leads
	function lookup(inputString)
	{
		inputString = remover_charespecial(inputString);

		if(inputString.length < 3) J('#suggestions').hide();
		else {
			J.post("../../libs/leads_sugestao.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					J('#suggestions').show();
					J('#autoSuggestionsList').html(data);
				}
				else J('#suggestions').hide();
			});
		}
	}

	function fill(thisValue) {
		J('#razaosocial').val(thisValue);
		setTimeout("J('#suggestions').hide();", 200);
	}

	function consulta_np_telefone(){
		var frm = document.forms[0];
		var strTelefone = frm.ddd.value+""+frm.tel.value.replace("-","");
		if(strTelefone.length >= 10)
			xajax_buscar_nao_perturbe(strTelefone, 'tel_descricao_bloqueado', 'tel_bloqueado');
	}

	function consulta_np_fax(){
		var frm = document.forms[0];
		var strTelefone = frm.dddfax.value+""+frm.fax.value.replace("-","");
		if(strTelefone.length >= 10)
			xajax_buscar_nao_perturbe(strTelefone, 'fax_descricao_bloqueado', 'fax_bloqueado');
	}

	function consulta_np_telefone_contato(){
		var frm = document.forms['formcontato'];
		var strTelefone = frm.ddd_fone.value+""+frm.fone.value.replace("-","");
		if(strTelefone.length >= 10)
			xajax_buscar_nao_perturbe(strTelefone, "tel_contato_descricao_bloqueado", 'tel_contato_bloqueado');
	}

	function consulta_np_celular_contato(){
		var frm = document.forms['formcontato'];
		var strTelefone = frm.ddd_cel.value+""+frm.cel.value.replace("-","");
		if(strTelefone.length >= 10)
			xajax_buscar_nao_perturbe(strTelefone, "celular_contato_descricao_bloqueado", 'cel_contato_bloqueado');
	}


	function carregar(){
		var frm = document.forms[0];
		<?
		if(@$_REQUEST['tipo_pessoa'] != ""){
			echo "frm.tipo_pessoa.value = '".@$_REQUEST['tipo_pessoa']."';";
		}
		?>
		cpfoucnpj('<?=@$_REQUEST['tipo_pessoa'];?>');
		frm.cnpj_cpf.value = "<?=@$_REQUEST['CNPJ_CPF'];?>";
		frm.cod_polo.focus();


	}

	function esconderCaixaSugestao(){
		caixa_sugestao.innerHTML = "";
		caixa_sugestao.style.display = "none";
	}

	function sucessoPesquisarLeadSugestao(retorno){
		caixa_sugestao.innerHTML = retorno;
		caixa_sugestao.style.display = "";
	}

	function erroPesquisarLeadSugestao(){
		caixa_sugestao.innerHTML = "";
		caixa_sugestao.style.display = "none";
	}

	function pesquisarLeadSugestao(strValor){

		if(strValor.length >= 3){

			var url = '../../libs/leads_sugestao.php';
			var pars = 'queryString='+strValor;

			var myAjax = new Ajax.Request
						(url,
							{
							method:'post',
							parameters: pars,
							onSuccess:
								function(transport){
									sucessoPesquisarLeadSugestao(transport.responseText);
								},
							onFailure:
								function(){
									erroPesquisarLeadSugestao();
								}
							}
						);
		}
		else{
			//Código a ser implementado.
			caixa_sugestao.innetHTML = "";
		}
	}



</script>
<style type="text/css">
<!--
#contatos.td {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	color: #666666;
	text-decoration: none;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
<form id="dados" method="post" action="leadnew.php" onSubmit="return validateForm(this)">
		<input type="hidden" id="codlead" name="codlead" value="<?=@$_REQUEST['CodLead'];?>" />
		<input type="hidden" id="acao" name="acao" value="<?=$acao?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo">
			&nbsp;Lead
		</td>
	</tr>
</table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
<tr>
          <td>&nbsp;          </td>
    </tr>
	<tr>
		<td>
			&nbsp;<label  for="cod_polo">Polo:</label>		</td>
		<td>
		<?
			//PARAMETRO DO POLO
			$polo = "";
			if(!empty($_REQUEST['cod_polo'])){
				$polo = $_REQUEST['cod_polo'];
			}else{
				$polo = $_SESSION['cod_polo'];
			}
			combo::polo($polo,'');
		?>
		</td>
	</tr>
	<tr>
					<td>&nbsp;<label for="datacadastro">Data Cadastro:</label></td>
					<td>
<?	if($Root){?>
						<input type="text" id="datacadastro" name="datacadastro[]" size="10" value="<?=(!empty($_REQUEST['DataCadastro'])?date('d/m/Y', strtotime($_REQUEST['DataCadastro'])):null);?>" maxlength="10" validate="datatype=date" />
						&nbsp;às&nbsp;<input type="text" id="horariocadastro" name="datacadastro[]" size="8" value="<?=(!empty($_REQUEST['DataCadastro'])?date('H:i:s', strtotime($_REQUEST['DataCadastro'])):null);?>" maxlength="8" validate="datatype=time" />
<?	}else{?>
						<?=(!empty($_REQUEST['DataCadastro'])?date('d/m/Y \à\s H:i:s', strtotime($_REQUEST['DataCadastro'])):null);?>
<?	} ?>					</td>
	  </tr>
				<tr>
					<td>&nbsp;<label for="razaosocial">Razão Social:</label></td>
					<td>
						<input type="text" class="input1" id="razaosocial" name="razaosocial" size="80" maxlength="150"  value="<?=@$_REQUEST['RazaoSocial'];?>" validate="required" onkeyup="pesquisarLeadSugestao(this.value);" onblur="esconderCaixaSugestao();"/> <br />
					<!-- SUGESTOES -->
					<div class="caixa_sugestao" id="caixa_sugestao" class='lista_sugestao' style='display: none'>
					</div>
					</td>
				</tr>



				<tr>
					<td>&nbsp;<label for="nomefantasia">Nome Fantasia:</label></td>
					<td>

						<input type="text" id="nomefantasia" name="nomefantasia" size="80" maxlength="150" value="<?=@$_REQUEST['NomeFantasia'];?>"  />				  </td>
				</tr>
				<tr>
					<td>&nbsp;<label for="cnpj_cpf">CNPJ/CPF:</label></td>
					<td>
						<select name='tipo_pessoa' onchange="cpfoucnpj(this.value)">
							<option></option>
							<option value='PJ'>CNPJ</option>
							<option value='PF'>CPF</option>
						</select>
						<input type="text" id="cnpj_cpf" name="cnpj_cpf" size="22" maxlength="18" value="<?=@$_REQUEST['CNPJ_CPF'];?>" validate="datatype=cnpj_cpf" />
					</td>
				</tr>

				<tr>
					<td>&nbsp;<label for="ie">Inscrição Estadual:</label></td>
					<td>
						<input type="text" id="ie" name="ie" maxlength="50" size="22" value="<?=@$_REQUEST['IE'];?>" />					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="inscricaomunicipal">Inscrição Municipal:</label></td>
					<td>
						<input type="text" id="inscricaomunicipal" name="inscricaomunicipal" maxlength="50" size="22" value="<?=@$_REQUEST['InscricaoMunicipal'];?>" />					</td>
				</tr>
			   <!--CASO A BASE SEJA DE BANDEIRA NEXTEL-->
			   <?
			   	//FUNCAO VERIFICA EMPRESA OPERADORA SE FOR NEXTEL LIBERA O PARAMENTRO PARA FILTRO, ESTA FUNCAO ESTA NA MANINCLUDE
		 		if(empresa_operador(4) == 4){
				?>
				   <tr>
						<td>&nbsp;<label for="senhacliente">Identificação:</label></td>
						<td>
							<input type="text" id="identificacao" name="identificacao" maxlength="16" size="22" value="<?=@$_REQUEST['identificacao'];?>" />					</td>
				   </tr>
	               <tr>
						<td>&nbsp;<label for="senhacliente">Senha Cliente:</label></td>
						<td>
							<input type="text" id="senha_cliente" name="senha_cliente" maxlength="16" size="22" value="<?=@$_REQUEST['senha_cliente'];?>" />					</td>
					</tr>
				<?}?>

				<tr>
					<td>&nbsp;<label for="site">Site:</label></td>
					<td>
						<input type="text" id="site" name="site" size="40" maxlength="150" value="<?=@$_REQUEST['Site'];?>" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="ddd">Telefone:</label>					</td>
					<td>
						(
						<input type="text" id="ddd" class="input1" name="ddd" size="2" maxlength="2" onKeyPress="mascara(this,soNumeros)" value="<?=@$_REQUEST['ddd'];?>" onblur="consulta_np_telefone()" validate="required;regexp=/^\d{2}$/" />
						)&nbsp;<input type="text" id="tel" class="input1" name="tel" maxlength="10" size="11" onKeyPress="mascara(this,telefone1)" value="<?=@$_REQUEST['tel'];?>" onblur="consulta_np_telefone()" validate="required;datatype=tel" />
						<input type="hidden" id="tel_bloqueado" name="tel_bloqueado" value="<?=@$_REQUEST['tel_bloqueado'];?>">
						<a href="javascript: consulta_np_telefone()" title="Consultar bloqueio Não Perturbe - Procon/SP"><img border="0" src="../../images/interrogacao.png"></a>
						<font id="tel_cor" face="Arial" color="red"><span id="tel_descricao_bloqueado"><?
						if($_REQUEST['tel_bloqueado'] == 1)
							echo "Bloqueado Não Perturbe";
						?></span></font>
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="dddfax">Fax:</label></td>
					<td>
						(
						<input type="text" size="2" maxlength="2" id="dddfax" name="dddfax" onKeyPress="mascara(this,soNumeros)" value="<?=@$_REQUEST['dddfax'];?>" onblur="consulta_np_fax()" validate="regexp=/^\d{2}$/" />
						)&nbsp;<input type="text" id="fax" name="fax" maxlength="10" size="11" onKeyPress="mascara(this,telefone1)" value="<?=@$_REQUEST['fax'];?>" onblur="consulta_np_fax()" validate="datatype=tel" />
						<input type="hidden" id="fax_bloqueado" name="fax_bloqueado" value="<?=@$_REQUEST['fax_bloqueado'];?>">
						<a href="javascript: consulta_np_fax()" title="Consultar bloqueio Não Perturbe - Procon/SP"><img border="0" src="../../images/interrogacao.png"></a>
						<font id="fax_cor" face="Arial" color="red"><span id="fax_descricao_bloqueado"><?
						if($_REQUEST['fax_bloqueado'] == 1)
							echo "Bloqueado Não Perturbe";
						?></span></font>
					</td>
				</tr>
                <tr>
                  <td >&nbsp;<label for="cep">Cep:</label></td>
                  <td align="left"><input name="cep" type="text" class="forms" id="cep" size="11" maxlength="9" onkeyup="if(this.value.length == 9) xajax_buscaCep(this.value, 'endereco', 'bairro', 'cidade', 'uf');" onblur="xajax_buscaCep(this.value, 'endereco', 'bairro', 'cidade', 'uf');" value="<?=@$_REQUEST['Cep'];?>" onKeyPress="mascara(this,cep1)"  validate="datatype=cep"/></td>
                </tr>
                <tr>
                  <td >&nbsp;<label for="endereco">Endereço:</label></td>
                  <td align="left"><input type="text" id="endereco" name="endereco" size="80" maxlength="150" value="<?=@$_REQUEST['Endereco'];?>" />						</td>
                </tr>
                <tr>
                  <td >&nbsp;<label for="numero">Numero:</label></td>
                  <td align="left"><input type="text" id="numero" name="numero" size="5" maxlength="5" onKeyPress="mascara(this,soNumeros)" value="<?=@$_REQUEST['Numero'];?>" /></td>
                </tr>
                <tr>
                 <td >&nbsp;<label for="complemento">Complemento:</label></td>
                  <td align="left"><input type="text" id="complemento" name="complemento" size="20" value="<?=@$_REQUEST['Complemento'];?>" /></td>
                </tr>
                <tr>
                 <td >&nbsp;<label for="bairro">Bairro:</label></td>
                  <td align="left"><input type="text" id="bairro" name="bairro" maxlength="63" size="63" value="<?=@$_REQUEST['Bairro'];?>" /></td>
                </tr>
                <tr>
                 <td >&nbsp;<label for="cidade">Cidade:</label></td>
                  <td align="left"><input type="text" id="cidade" name="cidade" maxlength="29" size="29" value="<?=@$_REQUEST['cidade'];?>" /></td>
                </tr>
                <tr>
                 <td >&nbsp;<label for="estado">Estado:</label></td>
                  <td align="left">
                  <?	$sql = "Select uf , nome from estados order by nome";
            	combo($sql, "uf", @$_REQUEST['uf'], "Selecione um Estado", "");?>
                 </td>
                </tr>
                <tr>
					<td>&nbsp;<label for="pontoref">Ponto de Refer&ecirc;ncia:</label></td>
					<td>
						<input type="text" id="pontoref" name="pontoref" maxlength="200" size="20" value="<?=@$_REQUEST['PontoRef'];?>" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="segmento">Segmento:</label></td>
					<td>
						<input type="text" id="segmento" name="segmento" maxlength="100" size="20" value="<?=@$_REQUEST['Segmento'];?>" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="mailing">Mailing:</label></td>
					<td>
						<?
						//VERIFICA SE É CONSULTOR DE NEGOCIOS
						if($GerenteContas){													
							$mailing_pk = "1";
							$codgerenteconta = ($acao==''&&$GerenteContas?$_SESSION['codusuario']:@$_REQUEST['CodGerenteConta']);
							//VERIFICA SE O CONSULTOR TEM OU NÃO PERMISSÃO DE ALTERAR O MAILING								
							if(permissao('alterar_mailing_lead', 'al')){	
								$sql ="";
								$sql.="SELECT m.pk, m.dsc_mailing
									   FROM mailing m
										left join leads l on l.mailing_pk = m.pk
									WHERE m.dt_cancelamento IS NULL";
								//$sql.=" and l.codgerenteconta=".$codgerenteconta;
								$sql.=" union";
								$sql.=" SELECT m.pk, m.dsc_mailing
										FROM mailing m
										WHERE m.dt_cancelamento IS NULL
										and m.pk=1";					
								combo( $sql, "mailing_pk" ,$mailing_pk,"" );
								
							}else{
								//VERIFICA SE O LEADS ESTA SENDO CADASTRADO
								if(!empty($_REQUEST['CodLead'])){		
									$mailing_pk = @$_REQUEST['mailing_pk'];	
														
									if(!empty($mailing_pk)){
										
										$sql ="";
										$sql.="SELECT m.pk, m.dsc_mailing
											   FROM mailing m
											   where m.pk=".$mailing_pk;
										$rss = sql_query($sql);
										$mailing = mysql_fetch_array($rss);
										
										echo $mailing['dsc_mailing'];
										echo "<input type='hidden' id='mailing_pk' name='mailing_pk' value='".$mailing['pk']."' />";
										mysql_free_result($rss);
									}
									
								}else{
									
									echo "Prospeccao";
									echo "<input type='hidden' id='mailing_pk' name='mailing_pk' value='1' />";
								}									
							}								
						}else{
							
							$mailing_pk = @$_REQUEST['mailing_pk'];	
							//VERIFICA SE O LEADS ESTA SENDO CADASTRADO
							if(!empty($_REQUEST['CodLead'])){
								if(permissao('alterar_mailing_lead', 'al')){															
									combo::combo_mailing($mailing_pk);	
								}else{
									$mailing_pk = @$_REQUEST['mailing_pk'];	
									if(!empty($mailing_pk)){
										$sql ="";
										$sql.="SELECT m.pk, m.dsc_mailing
											   FROM mailing m
											   where m.pk=".$mailing_pk;
										$rss = sql_query($sql);
										$mailing = mysql_fetch_array($rss);
										echo $mailing['dsc_mailing'];
										echo "<input type='hidden' id='mailing_pk' name='mailing_pk' value=".$mailing['pk']." />";
										mysql_free_result($rss);
									}	
								}	
							}else{
								if(permissao('alterar_mailing_lead', 'ic')){
									combo::combo_mailing($mailing_pk);	
								}							
										
							}								
						}	
						?>										
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="ativacao">Data de ativação:</label></td>
					<td>
						<input type="text" id="ativacao" name="ativacao" maxlength="10" size="12" onKeyPress="mascara(this,datamask)" value="<?=(!empty($_REQUEST['Ativacao'])?date('d/m/Y', strtotime($_REQUEST['Ativacao'])):null);?>" validate="datatype=date" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
					<td>
						<?
							if(!permissao('alteraconsultor', 'al')){

                                $consuldefault = ($acao==''&&$GerenteContas?$_SESSION['codusuario']:@$_REQUEST['CodGerenteConta']);

								if(!empty($consuldefault)){
									$sql = "Select
												l.CodUsuarioInterno
												, l.Nome
											from usuariosinternos l
											where l.codusuariointerno=".$consuldefault;
									$rs1 = sql_query($sql);
									$consultor = mysql_fetch_array($rs1);
									print "<input type=hidden name=codgerenteconta value=".$consultor['CodUsuarioInterno']." />";
									print $consultor['Nome'];
								}
							}else{
								$ConsultorDefault = ($acao==''?$_SESSION['codusuario']:@$_REQUEST['CodGerenteConta']);
								combo::consultor_equipe1($ConsultorDefault);
							}
						?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="codatendente">Atendente:</label></td>
					<td>
						<?
							if(!permissao('alteraatendente', 'al')){
							 $Atendefault = ($acao=='ins'&&$Atendente?$_SESSION['codusuario']:@$_REQUEST['CodAtendente']);

								if(!empty($Atendefault)){
									$sql = "Select
												l.CodUsuarioInterno
												, l.Nome
											from usuariosinternos l
											where l.codusuariointerno=".$Atendefault;
									$rs = sql_query($sql);
									$atendente = mysql_fetch_array($rs);
									print "<input type=hidden name=codatendente value=".$atendente['CodUsuarioInterno']." />";
									print $atendente['Nome'];
								}
							}else{
								$Atendefault = ($acao==''?$_SESSION['codusuario']:@$_REQUEST['CodAtendente']);
								combo::atendente_equipe1($Atendefault);
							}
						?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="codstatusclassificacaolead">Classificação:</label></td>
<?	if(!empty($_REQUEST['CodLead']) && ($Root || $Admin)){?>
					<td>
						<?php
							$sql = "select codstatusclassificacaolead, descricao from statusclassificacaolead";
							combo($sql, "codstatusclassificacaolead", @$_REQUEST['CodStatusClassificacaoLead'], " ", "");
						?>
					</td>
<?	}else{?>
					<td>
						<input type="hidden" id="codstatusclassificacaolead" name="codstatusclassificacaolead" value="<?=@$_REQUEST['CodStatusClassificacaoLead'];?>" />
						<?=@$_REQUEST['StatusClassificacaoLead'];?>
					</td>
<?	}?>
				</tr>
<?	if(!empty($_REQUEST['CodMotivo']) || $Root){?>
				<tr>
					<td>&nbsp;Motivo:</td>
					<td>
<?		if($Root){
				$sql = "select codmotivolead, descricao from motivoslead";
				combo($sql, "codmotivo", @$_REQUEST['CodMotivo'], " ", "");
		}else{?>
					<?=@$_REQUEST['Motivo'];?>
<?		}?>
					</td>
				</tr>
<?	}

//FUNCAO VERIFICA EMPRESA OPERADORA SE FOR EMBRATEL LIBERA O PARAMENTRO PARA FILTRO
 if(empresa_operador(5) == 5){
?>
<tr>
	<td align="left" valign="top">&nbsp;Ponto Embratel:</td>
	<td>

	<?

	$checked1="";
	$checked2="";
	if(@$_REQUEST['iluminado']=="2"){
		$checked2="checked";
	}
	if(@$_REQUEST['iluminado']=="1"){
		$checked1="checked";
	}
	?>
		<input type="Radio" name="iluminado" value="1" <?=$checked1;?>>&nbsp;Iluminado
		&nbsp;<input type="Radio" name="iluminado" value="2" <?=$checked2;?>>&nbsp;Não Iluminado
	</td>
</tr>
<?}?>
				<tr>
					<td align="left" valign="top">&nbsp;ID Fornecedor</td>
					<td><input type='text' name='id_fornecedor' id='id_fornecedor' value='<?= $_REQUEST['id_fornecedor'];?>'></td>
				</tr>

				<tr>
					<td class="topo_grid">Oportunidade Identificada</td>
					<td bgcolor="#5982AA">&nbsp;
				</tr>
				<tr>
					<td>&nbsp;<label for="vencimentocontrato">Vencimento do Contrato:</label></td>
					<td>
						<input type="text" id="vencimentocontrato" name="vencimentocontrato" onKeyPress="mascara(this,datamask)" maxlength="10" size="12" value="<?=(!empty($_REQUEST['VencimentoContrato'])?date('d/m/Y', strtotime($_REQUEST['VencimentoContrato'])):null);?>" validate="datatype=date" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="vencimentocontrato">Qtde de Linhas:</label></td>
					<td>
						<input type="text" id="qtde_linhas" name="qtde_linhas" onKeyPress="mascara(this,soNumeros)" maxlength="10" size="12" value="<?=$_REQUEST['qtde_linhas'];?>" />
					</td>
				</tr>
				<tr>
				<td align="left" valign="top">&nbsp;Operadoras:</td>
				<td>
				<?php
					if(!empty($_GET['codlead']))  $operadoras = leads::operadoras($_GET['codlead']);

					$sql="select op.cod_operadora codigo, op.dsc_operadora nome from operadoras op";
					$result = sql_query($sql);
					while($row = mysql_fetch_array($result))
					{
						(!empty($_GET['codlead'])? (in_array($row['codigo'], $operadoras)? $checado='checked' : $checado='') : $checado='');
						echo "<div style='float:left; padding-right:10px;'><input type='checkbox' name='operadoras[".$row["codigo"]."]' value='".$row["codigo"]."' ".$checado."/>".$row["nome"]."</div>";
					}

					mysql_free_result($result);
				?>
				</td>
				</tr>
				<tr>
					<td align="left" valign="top">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
<?	if(permissao('contatoslead', 'dt')){?>
				<tr>
					<td class="topo_grid">Contatos</td>
					<td bgcolor="#5982AA">&nbsp;
<?		if(permissao('contatoslead', 'ic')){?>
						<input type="button" id="incluircontato" value="Incluir" />&nbsp;
<?		}
		if(permissao('contatoslead', 'al')){?>
						<input type="button" id="editarcontato" value="Editar" />&nbsp;
<?		}
		if(permissao('contatoslead', 'ex')){?>
						<input type="button" id="excluircontato" value="Excluir" />
<?		}?>				  </td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="iframe" style="width:100%;">
							<table width="98%" border="0" cellpadding="0" cellspacing="0" class="fonte_lista" id="contatos" >
								<thead>
									<tr >
										<th>#</th>
										<th>Nome</th>
										<th>Setor</th>
										<th>Função</th>
										<th>Telefone</th>
										<th>Bloqueado</th>
										<th>Ramal</th>
										<th>ID Radio</th>
										<th>Celular</th>
										<th>Bloqueado</th>
										<th>Email</th>
										<th>RG</th>
										<th>CPF</th>
									</tr>
								</thead>
								<tbody>
<?		$sql = "Select c.CodContatoLead , c.NomeContato , c.Fone , c.DDD_Fone , c.id_radio , c.Cel, c.DDD_Cel, c.Email, c.CodSetorContato, c.CodFuncaoContato , s.Descricao Setor , f.Descricao Funcao, c.tel_contato_bloqueado, c.cel_contato_bloqueado, c.Ramal_Fone,c.n_rg,c.n_cpf ";
		$sql .= " From contatoslead c";
		$sql .= " left join setorcontatos s on c.CodSetorContato = s.CodSetorContato";
		$sql .= " left join funcaocontato f on c.CodFuncaoContato = f.CodFuncaoContato";
		$sql .= " where c.codlead = ". mysqlnull(@$_REQUEST['CodLead']);

		$result = sql_query($sql);
		$cont = 0;
		while($row = mysql_fetch_array($result)){?>
									<tr>
										<td align="center">
											<input type="radio" name="rd" value="<?=$cont;?>" />
											<input type="hidden" name="contato[<?=$cont;?>][codcontatolead]" value="<?=$row['CodContatoLead'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][nomecontato]" value="<?=$row['NomeContato'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][fone]" value="<?=$row['Fone'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][ddd_fone]" value="<?=$row['DDD_Fone'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][ramal_fone]" value="<?=$row['Ramal_Fone'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][tel_contato_bloqueado]" value="<?=$row['tel_contato_bloqueado'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][id_radio]" value="<?=$row['id_radio'];?>" />
									    	<input type="hidden" name="contato[<?=$cont;?>][cel]" value="<?=$row['Cel'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][ddd_cel]" value="<?=$row['DDD_Cel'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][cel_contato_bloqueado]" value="<?=$row['cel_contato_bloqueado'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][email]" value="<?=$row['Email'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][n_rg]" value="<?=$row['n_rg'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][n_cpf]" value="<?=$row['n_cpf'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][codsetorcontato]" value="<?=$row['CodSetorContato'];?>" />
											<input type="hidden" name="contato[<?=$cont;?>][codfuncaocontato]" value="<?=$row['CodFuncaoContato'];?>" />
									  </td>
										<td align="center"><?=$row['NomeContato'];?></td>
										<td align="center"><?=$row['Setor'];?></td>
										<td align="center"><?=$row['Funcao'];?></td>
										<td class="fonte_lista">(<?=$row['DDD_Fone'];?>) <?=$row['Fone'];?></td>
										<td class="fonte_lista">
											<?
											if($row['tel_contato_bloqueado']=='1'){
												echo "Bloqueado Não Perturbe";
											}
											else{
												echo "Liberado";
											}
											?>
										</td>
										<td align="center"><?=$row['Ramal_Fone'];?></td>
										<td align="center"><?=$row['id_radio'];?></td>
										<td class="fonte_lista">(<?=$row['DDD_Cel'];?>) <?=$row['Cel'];?></td>
										<td class="fonte_lista">
											<?
											if($row['cel_contato_bloqueado']=='1'){
												echo "Bloqueado Não Perturbe";
											}
											else{
												echo "Liberado";
											}
											?>
										</td>
										<td align="center"><?=$row['Email'];?></td>
										<td align="center"><?=$row['n_rg'];?></td>
										<td align="center"><?=$row['n_cpf'];?></td>
									</tr>
<?			$cont++;
		}
		mysql_free_result($result);
		?>
								</tbody>
						  </table>
						</div>
					</td>
				</tr>
<?	}?>
<tr>
			<td colspan="2" align="right">&nbsp;

			</td>
		</tr>
		<?if ($acao == ""){?>
			<tr>
				<td colspan="2">
					Informações Adicionais da Prospecção
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<textarea id="txtocorrenciaini" name="txtocorrenciaini" style="width: 100%" rows="5"></textarea>
				</td>
			</tr>
		<?}?>
			</tbody>
				<tr>
					<th colspan="2">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<?	if(!empty($_REQUEST['CodLead']) && permissao('leads', 'ex')){?>
											<input type="submit" name="excluir" value="Excluir Lead" onClick="return confirm('Excluir Lead?')" />
									<?	}?>
									&nbsp;
								</td>
								<td align="right">
									<input type="submit" name="enviar" value="Enviar" />&nbsp;
									<input type="button" value="Fechar" onClick="self.close();" />
								</td>
							</tr>
						</table>
					</th>
				</tr>
  </table>
  <br>
</form>
<br>
<form id="formcontato" name="frmcontato" method="post" onSubmit="return gravarContato(this)" style="display:none">
	<input type="hidden" name="contatoacao" id="contatoacao" value="add" />
	<input type="hidden" name="codcontatolead" id="codcontatolead" />
<table class="form1" width="480"  border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td colspan="2">
				<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
				<tr><td class="titulo_contato">Contato</td></tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="nomecontato">Nome:</label></td>
			<td>
				<input type="text" id="nomecontato" name="nomecontato" value="" maxlength="50" size="25" validate="required" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="ddd_fone">Telefone:</label></td>
			<td>
				(<input type='text' id="ddd_fone" name='ddd_fone' value="" size="2" onblur="consulta_np_telefone_contato()" onKeyPress="mascara(this,soNumeros)" maxlength="2" validate="regexp=/^\d{2}$/" />
				)&nbsp;<input type="text" id="fone" name="fone" value="" size="11" maxlength="10" onblur="consulta_np_telefone_contato()" onKeyPress="mascara(this,telefone1)" validate="datatype=tel" />
				<input type="hidden" id="tel_contato_bloqueado" name="tel_contato_bloqueado" value="">
				<a href="#" onclick="consulta_np_telefone_contato()" title="Consultar bloqueio Não Perturbe - Procon/SP"><img border="0" src="../../images/interrogacao.png"></a>
				<br>
				<font id="tel_cor" face="Arial" color="red"><span id="tel_contato_descricao_bloqueado"></span></font>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="ramal_fone">Ramal:</label></td>
			<td>
				<input type="text" id="ramal_fone" name="ramal_fone" value="" size="5" onKeyPress="mascara(this,soNumeros)" maxlength="5" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="id_nexte;">ID Radio:</label></td>
			<td>
				<input type="text" id="id_radio" name="id_radio" value="" size="10" maxlength="10" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="ddd_cel">Celular:</label></td>
			<td>
				(<input type='text' id="ddd_cel" name='ddd_cel' value="" size="2" onblur="consulta_np_celular_contato()" onKeyPress="mascara(this,soNumeros)" maxlength="2" validate="regexp=/^\d{2}$/" />
				)&nbsp;<input type="text" id="cel" name="cel" value="" size="11" maxlength="10" onblur="consulta_np_celular_contato()" onKeyPress="mascara(this,telefone1)" validate="datatype=tel" />
				<input type="hidden" name="cel_contato_bloqueado" id="cel_contato_bloqueado" value="">
				<a href="#" onclick="consulta_np_celular_contato()" title="Consultar bloqueio Não Perturbe - Procon/SP"><img border="0" src="../../images/interrogacao.png"></a>
				<br>
				<font face="Arial" color="red"><span id="celular_contato_descricao_bloqueado"></span></font>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="email">E-mail:</label></td>
			<td>
				<input type='text' id="email" size="25" maxlength="50" name="email" value="" validate="datatype=email" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="rg">RG:</label></td>
			<td>
				<input type='text' id="n_rg" size="18" maxlength="18" name="n_rg" value="" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="cpf">CPF:</label></td>
			<td>
				<input type="text" id="n_cpf" name="n_cpf" size="18" maxlength="14" value=""  validate="datatype=cnpj_cpf" onKeyPress="mascara(this,cpf)"  />
			</td>
		</tr>				
		<tr>
			<td>&nbsp;<label for="codsetorcontato">Setor:</label></td>
			<td>
			<?	$sql = "Select codsetorcontato, descricao from setorcontatos order by descricao;";
			combo($sql, "codsetorcontato", @$data['CodSetorContato'], " ", null);?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codfuncaocontato">Função:</label></td>
			<td>
			<?	$sql = "select CodFuncaoContato, Descricao from funcaocontato order by Descricao";
			combo($sql, "codfuncaocontato", @$data['CodFuncaoContato'], " ", null);?>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">
				<input type="button" id="salvarcontato" value="Enviar" />
				<input type="button" value="Fechar" onClick="closeSimpleBox()" />&nbsp;
			</th>
		</tr>
	</tfoot>
</table>
	</form>
</html>
<?	include_once "../../libs/desconectar.php"; ?>
