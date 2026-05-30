var tblResultado;
var click_id = 0;
function fcValidarForm(){

    $("#form").validate({
        rules :{
        },
        messages:{
        },
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcCarregarGrid(){
    
    if($("#mes_pk").val()==''){
        alert('Selecione o mês corrente!')
        return false;
    }

    if($("#ano_pk").val()==''){
        alert('Selecione o ano corrente!!')
        return false;
    }
    
    
    var ds_colaborador = $("#colaborador_pk option:selected").text()
    
    var leads_pk = $("#leads_pk option:selected").val()
    
    sendPost('rel_colaborador_planilha_cad_form.php', {token: token,
        ds_colaborador:ds_colaborador,
        colaborador_pk:$("#colaborador_pk").val(),
        produtos_servicos_pk:$("#produtos_servicos_pk").val(),
        turnos_pk:$("#turnos_pk").val(),
        mes_pk:$("#mes_pk").val(),
        ano_pk:$("#ano_pk").val(),
        leads_pk:leads_pk
    });
}

function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}

function fcCarregarComboColaborador(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("colaborador", "listarTodos", objParametros);    
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");
        
}
function fcCarregarQualificacao(){

    var objParametros = {
        "pk": ""

    };

    var arrCarregar = carregarController("produto_servico", "listarTodos", objParametros);
    carregarComboAjax($("#produtos_servicos_pk"), arrCarregar, " ", "pk", "ds_produto_servico");
}


function fcCarregarPostoTrabalho(){
    carregarComboAjax($("#leads_pk_agenda"), arrCarregar, " ", "leads_pk", "ds_lead");
}

function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
   
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");         
}


$(document).ready(function(){    
                      
    fcCarregarComboColaborador();
    fcCarregarQualificacao() 
    fcCarregarLeads();
    
   /*$('#dt_inicio').datepicker({defaultDate: "getDate()",
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
    });   */
    
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
        
    $(".chzn-select").chosen({allow_single_deselect: true});
});


