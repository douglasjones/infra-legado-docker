function show_orig(){
	var div = $('lead');
	var bd_orig = $('bd_orig');
	if ( bd_orig.value == ''){
		div.style.display = "none";
	} else {
		div.style.display = "block";
	}
	var pars = 'acao=lead';
	new Ajax.Updater('lead', 'MigracaoAjax.php', { method: 'post', parameters: pars } );
}
function sel_lead(){
	var div = $('sel_lead');
	var bd_orig = $('bd_orig');
	var lead = $('nome_lead');
	var pars = 'acao=sel_lead&bd=' + bd_orig.value + '&lead=' + lead.value;
	div.innerHTML = "<table border='0' cellpadding='0' cellspacing='0' class='form'><thead><tr><th>Selecione o lead:</th></tr></thead></table>";
	new Ajax.Updater('sel_lead', 'MigracaoAjax.php', { method: 'post', parameters: pars } );
	div.style.display = "block";
}
function lead_selected(){
	var div = $('sel_lead');
	div.style.display = "none";
	var lead = $('select_lead');
	var pars = 'acao=set_lead&lead=' + lead;
	var nome_lead = $('nome_lead');
	var codlead = $('codlead');
	var array_lead = lead.value.split(",");
	codlead.value = array_lead[0];
	nome_lead.value = array_lead[1];
	nome_lead.disabled = true;
}
function limpa_lead(){
	var nome_lead = $('nome_lead');
	nome_lead.value = "";
	nome_lead.disabled = false;
}
function show_dest(){
	var div = $('usuarios');
	var bd_dest = $('bd_dest');
	var pars = 'acao=usuarios&bd=' + bd_dest.value;
	if ( bd_dest.value == ''){
		div.style.display = "none";
	} else {
		div.style.display = "block";
		new Ajax.Updater('usuarios', 'MigracaoAjax.php', { method: 'post', parameters: pars } );
	}
}
function validar(){
	var bd_orig = $('bd_orig');
	var bd_dest = $('bd_dest');
	var codlead = $('codlead');
	var nomelead = $('nome_lead');
	var gerenteconta = $('gerenteconta');
	var atendente = $('atendente');
	var migra_oc = $('migra_oc');
	var usr_oc = $('usr_oc');
	var status = $('status');
	if (bd_orig.value == ''){
		window.alert('Selecione o Banco de origem.');
		return false;
	}
	if (bd_dest.value == ''){
		window.alert('Selecione o Banco de destino.');
		return false;
	}
	if (codlead.value == ''){
		window.alert('Selecione o Lead.');
		return false;
	}
	if (nomelead.disabled == false){
		window.alert('Selecione o Lead.');
		return false;
	}
	if (gerenteconta.value == 'none'){
		window.alert('Selecione o Gerente de Contas.');
		return false;
	}
	if (atendente.value == 'none'){
		window.alert('Selecione o Atendente.');
		return false;
	}
	if (migra_oc.checked == true && usr_oc.value == 'none'){
		window.alert('Selecione o Usuario padrao de ocorrencias.');
		return false;
	}
	var form = $('form');
	form.submit();
}