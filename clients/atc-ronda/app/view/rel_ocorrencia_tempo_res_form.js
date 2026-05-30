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
    var ds_lead = $("#leads_pk option:selected").text();
    var ds_supervisor = $("#supervisor_pk option:selected").text();
    var ds_tipo_oc = $("#tipo_ocorrencia_pk option:selected").text();
    

    sendPost('rel_ocorrencia_tempo_cad_form.php', {token: token, 
        leads_pk: $("#leads_pk").val(),
        supervisor_pk: $("#supervisor_pk").val(),
        tipo_ocorrencia_pk: $("#tipo_ocorrencia_pk").val(),
        dt_abertura_ini:$("#dt_abertura_ini").val(),
        dt_abertura_fim:$("#dt_abertura_fim").val(),
        dt_atendimento_ini:$("#dt_atendimento_ini").val(),
        dt_atendimento_fim:$("#dt_atendimento_fim").val(),
        ds_lead:ds_lead,
        ds_supervisor:ds_supervisor,
        ds_tipo_oc:ds_tipo_oc,
    });
}


function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}
function fcCarregarLead(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
    
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");         
}
function fcCarregarSupervisor(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarSupervisor", objParametros);    
    carregarComboAjax($("#supervisor_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
}
function fcCarregarTipoOc(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("tipo_ocorrencia", "listarTodos", objParametros);    
   
    carregarComboAjax($("#tipo_ocorrencia_pk"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia");         
}

$(document).ready(function(){    
    /*var arrCarregar = permissao("rel_colaborador", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
           
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
        //Datas
    $('#dt_abertura_ini').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_abertura_ini").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_abertura_fim').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_abertura_fim").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_atendimento_ini').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_atendimento_ini").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_atendimento_fim').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_atendimento_fim").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    
   
    
   
    
    
   
    fcCarregarLead();

    fcCarregarSupervisor();
    
    fcCarregarTipoOc();

    $(".chzn-select").chosen({allow_single_deselect: true});
});


