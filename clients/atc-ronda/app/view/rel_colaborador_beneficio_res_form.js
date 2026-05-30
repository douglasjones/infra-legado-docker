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
    var ds_colaborador = $("#colaboradores_pk option:selected").text();
    var ds_lead = $("#leads_pk option:selected").text();
    

    sendPost('rel_colaborador_beneficio_cad_form.php', {token: token, 
        colaboradores_pk: $("#colaboradores_pk").val(),
        leads_pk: $("#leads_pk").val(),
        dt_ini:$("#dt_ini").val(),
        dt_fim:$("#dt_fim").val(),
        ds_colaborador:ds_colaborador,
        ds_lead:ds_lead,
    });
}

function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}

function fcCarregarColaboradores(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("colaborador", "listarTodosReservas", objParametros);    
   
    carregarComboAjax($("#colaboradores_pk"), arrCarregar, " ", "pk", "ds_colaborador");         
}
function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
   
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");         
}

$(document).ready(function(){    
    /*var arrCarregar = permissao("rel_colaborador", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
           
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
   
    fcCarregarColaboradores();
    fcCarregarLeads();

    $(".chzn-select").chosen({allow_single_deselect: true});
});


