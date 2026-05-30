var tblResultado;
var click_id = 0;
function fcValidarForm() {

    $("#form").validate({
        rules: {
        },
        messages: {
        },
        submitHandler: function (form) {
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcCarregarGrid() {

    if ($("#dt_inicio").val() == '') {
        alert('Informe Dt Iní Benef Período!!')
        return false;
    }

    if ($("#dt_fim").val() == '') {
        alert('Informe Dt Fim Benef Período!!')
        return false;
    }

    if ($("#dt_falta_inicio").val() == '') {
        alert('Informe Dt Iní Falta Período!!')
        return false;
    }

    if ($("#dt_falta_fim").val() == '') {
        alert('Informe Dt Fim Falta Período!!')
        return false;
    }

    var ds_colaborador = $("#colaborador_pk option:selected").text()
    var ds_lead = $("#leads_pk option:selected").text()
    var ds_produto_servico = $("#produtos_servicos_pk option:selected").text()
    var ds_turno = $("#turnos_pk option:selected").text()    
    var leads_pk = $("#leads_pk option:selected").val()

    sendPost('rel_projecao_beneficios_cad_form.php', {
        token: token,
        ds_colaborador: ds_colaborador,
        ds_lead: ds_lead,
        ds_produto_servico: ds_produto_servico,
        ds_turno: ds_turno,
        colaborador_pk: $("#colaborador_pk").val(),
        produtos_servicos_pk: $("#produtos_servicos_pk").val(),
        turnos_pk: $("#turnos_pk").val(),
        dt_fim: $("#dt_fim").val(),
        dt_inicio: $("#dt_inicio").val(),
        dt_falta_fim: $("#dt_falta_fim").val(),
        dt_falta_inicio: $("#dt_falta_inicio").val(),
        
        leads_pk: leads_pk
    });
}

function fcCancelar() {

    sendPost("menu_relatorios.php", { token: token });
}

function fcCarregarComboColaborador() {

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("colaborador", "listarColaboradorAgenda", objParametros);    
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");
}
function fcCarregarQualificacao() {

    var objParametros = {
        "pk": ""

    };

    var arrCarregar = carregarController("produto_servico", "listarTodos", objParametros);
    carregarComboAjax($("#produtos_servicos_pk"), arrCarregar, " ", "pk", "ds_produto_servico");
}


function fcCarregarPostoTrabalho() {
    carregarComboAjax($("#leads_pk_agenda"), arrCarregar, " ", "leads_pk", "ds_lead");
}

function fcCarregarLeads() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);

    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");
}


$(document).ready(function () {

    fcCarregarComboColaborador();
    fcCarregarQualificacao()
    fcCarregarLeads();

    $('#dt_inicio').datepicker({defaultDate: "getDate()",
         dateFormat: 'dd/mm/yyyy',
         language: "pt-BR",
         autoclose: true,
         todayHighlight: true,
         todayBtn: "linked",
         minDate: 0
     }).datepicker("setDate", ); 
     $("#dt_inicio").keypress(function(){
        mascara(this,mdata);
     });   
     
    $('#dt_fim').datepicker({defaultDate: "getDate()",
         dateFormat: 'dd/mm/yyyy',
         language: "pt-BR",
         autoclose: true,
         todayHighlight: true,
         todayBtn: "linked",
         minDate: 0
     }).datepicker("setDate", ); 
     $("#dt_fim").keypress(function(){
        mascara(this,mdata);
     });   
   
     $('#dt_falta_inicio').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", ); 
    $("#dt_falta_inicio").keypress(function(){
        mascara(this,mdata);
    });   

    $('#dt_falta_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", ); 
    $("#dt_falta_fim").keypress(function(){
        mascara(this,mdata);
    });   

    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);

    $(".chzn-select").chosen({ allow_single_deselect: true });
});


