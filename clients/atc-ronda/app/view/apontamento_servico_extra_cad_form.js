function fcCarregarLeads() {
    var arrCarregar = carregarController("lead", "listarLeadsCombo");
	carregarComboAjax($("#leads_pk_modal"), arrCarregar, " ", "leads_pk", "ds_lead");		
}

function fcCarregarContratos(leads_pk) {
	  
    var arrCarregar = carregarController("contrato", "listaLeadContratos");
	var objParametrosPausa = {
		"leads_pk": leads_pk
	};  
    carregarComboAjax($("#contrato_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fcLimparFormServicoExtra(){
	$("#dt_fim_exec_servico").val("");
	$("#dt_ini_exec_servico").val("");
	$("#contrato_pk").val("");
	$("#ds_obs_servico_extra").val("");
	$("#leads_pk_modal").val("");
	$("#vl_servico").val("");
}

function fcMascaraFormServicoExtra(){
	$("#vl_servico").keypress(function () {
		mascara(this, moeda);
	});

	$('#dt_ini_exec_servico').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
	$('#dt_fim_exec_servico').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });

	$("#dt_ini_exec_servico").keypress(function () {
		mascara(this, mdata);
	});
	$("#dt_fim_exec_servico").keypress(function () {
		mascara(this, mdata);
	});
}


$(document).ready(function () {
	fcMascaraFormServicoExtra();

});