function fcCancelar(){
    var objParametros = {};
    sendPost('menu','relatorio' ,objParametros);
}

function fcGeralRelatorio(){
    var ds_colaboradores = $("#colaborador_pk option:selected").text();
    var ds_leads = $("#leads_pk option:selected").text();
    var ds_mes = $("#ic_mes option:selected").text();
    var tiposApontamento = [];
    var dsApontamentos = [];

    $(".tipo-apontamento-checkbox:checked").each(function () {
        tiposApontamento.push($(this).val());
        dsApontamentos.push($.trim($("label[for='" + $(this).attr("id") + "']").text()));
    });

    var ds_apontamento = dsApontamentos.length > 0 ? dsApontamentos.join(", ") : "";

    var objParametros = {
        colaborador_pk: $("#colaborador_pk").val(),
        leads_pk:$("#leads_pk").val(),
        ic_mes:$("#ic_mes").val(),
        ic_ano:$("#ic_ano").val(),
        tipo_apontamento_pk:tiposApontamento.join(","),
        "ds_leads":ds_leads,
        "ds_mes":ds_mes,
        "ds_apontamento":ds_apontamento,
        "ds_colaboradores":ds_colaboradores
    }
    sendPost("relatorio","receptivoAcompanhamentoFalta",objParametros);
    //cria rota, voce vai colocar ela em colaboradores, por que é um relatorio que pega informação
    //especifica de colaborador.
}

function fcCarregarLeads() {
    //Carrega os grupos

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("lead", "listarTodos", objParametros);
    
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");

}

function fcCarregarColaborador() {
    //Carrega os grupos
    
    var objParametros = {
        "leads_pk": $("#leads_pk").val()
    };

    var arrCarregar = carregarController("colaborador", "listarColaboradorLead", objParametros);
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");

}



$(document).ready(function () {
    $(document).on('click', '#cmdEnviar', fcGeralRelatorio);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    fcCarregarLeads();
    fcCarregarColaborador();
    $("#leads_pk").change(function () {
        
        $(".chzn-select").chosen('destroy');
        fcCarregarColaborador();
        $(".chzn-select").chosen({ allow_single_deselect: true });

    });


    const dataAtual = new Date();

    // Obtém o mês atual (os meses são indexados a partir de 0, então adicionamos 1)
    const mes = dataAtual.getMonth() + 1;
    if(mes<=9){
        mesAtual = "0"+mes;
    }
    else{
        mesAtual = mes;
    }


    // Obtém o ano atual
    const anoAtual = dataAtual.getFullYear();
    
    $("#ic_mes").val(mesAtual);


    var html = "";
    for(i=parseInt(anoAtual);i >= parseInt(anoAtual-3);i--){
     
        html += "<option value='" + i + "'>" + i + "</option>";
    }
    $("select[name=ic_ano]").html(html);


    $(".chzn-select").chosen({ allow_single_deselect: true });

});

