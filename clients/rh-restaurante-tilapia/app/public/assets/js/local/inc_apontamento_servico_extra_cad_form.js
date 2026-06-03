function fcMascarasCamposServicosExtra(){
    $('#dt_ini_servico_extra').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });

    $('#dt_fim_servico_extra').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });


    $("#dt_ini_servico_extra").keypress(function () {
        mascara(this, mdata);
    });
    $("#hr_ini_servico_extra").keypress(function () {
        mascara(this, horamask);
    });
    $("#hr_fim_servico_extra").keypress(function () {
        mascara(this, horamask);
    });
    $("#vl_servico_extra").keypress(function () {
        mascara(this,moeda);
    });
    $("#vl_mao_obra_servico_extra").keypress(function () {
        mascara(this,moeda);
    });

    $("#dt_fim_servico_extra").keypress(function () {
        mascara(this, mdata);
    });

}

function fcCarregarLeadServicoExtra(){
    var objParametros = {
        pk: ""
    };

    var arrCarregar = carregarController("lead", "listarTodos", objParametros);
    carregarComboAjax($("#leads_servico_extra_pk"), arrCarregar, " ", "pk", "ds_lead");

}
function fcCarregarProdutoServicoExtra(){
    var objParametros = {
    };

    var arrCarregar = carregarController("servico", "listarTodos", objParametros);
    carregarComboAjax($("#pordutos_servicos_extra_pk"), arrCarregar, " ", "pk", "ds_produto_servico");

}
function fcLimparFormServicoExtra(){

    $("#leads_servico_extra_pk").val("");
    $("#pordutos_servicos_extra_pk").val("");
    $("#dt_ini_servico_extra").val("");
    $("#hr_ini_servico_extra").val("");
    $("#dt_fim_servico_extra").val("");
    $("#hr_fim_servico_extra").val("");
    $("#vl_servico_extra").val("");
    $("#vl_mao_obra_servico_extra").val("");
    $("#obs_servico_extra").val("");
}




$(document).ready(function () {
    fcMascarasCamposServicosExtra();
    fcCarregarLeadServicoExtra();
    fcCarregarProdutoServicoExtra();


});