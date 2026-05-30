
function fcCarregarCoberturaFalta(colaborador_pk) {
	if(colaborador_pk > 0){
		var objParametros = {
			pk: colaborador_pk
		};
		var arrCarregar = carregarController("colaborador", "RelatorioDadosColaborador", objParametros);
		var qualificacao = arrCarregar.data[0]['ds_qualificacao'];
		qualificacao = qualificacao.replace(/,/g , "");
		
		var objParametros = {
			ds_produtos_servicos: qualificacao,
			colaborador_pk: colaborador_pk
		};
		
		var arrCarregar = carregarController("colaborador", "listarColaboradoresQualificacao", objParametros);
        //NewWindow(v_last_url)
		carregarComboAjax($("#colaborador_cobertura_falta_pk"), arrCarregar, " ", "pk", "ds_colaborador");
	}
}

function fcAbrirSelectsFalta(){

    if($("#colaborador_cobertura_falta_pk") != ""){
        $('#falta_lead_pk').css('display', 'block')
        $('#motivo_cobertura_pk').css('display', 'block')
        $('#dv_vl_ft_falta').css('display', 'block')
    }
}

function fcLimparFormFalta(){
    $("#ds_obs_falta").val("");
	$("#colaborador_cobertura_falta_pk").val("");
	$("#motivo_falta_pk").val("");
	$("#vl_ft_falta").val("");
	$("#motivo_cobertura_falta_pk").val("");
}

$(document).ready(function () {
    $('#motivo_cobertura_pk').css('display', 'none')
    $('#dv_vl_ft_falta').css('display', 'none')
    $('#falta_lead_pk').css('display', 'none')
    $("#vl_ft_falta").keypress(function(){
        mascara(this,moeda);
    });
});