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
    var ds_status = $("#ic_status option:selected").text();
    

    sendPost('rel_pin_colaborador_cad_form.php', {token: token, 
        colaboradores_pk: $("#colaboradores_pk").val(),
        ic_status:$("#ic_status").val(),
        ds_status:ds_status,
        ds_colaborador:ds_colaborador
    });
}

function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}

function fcCarregarColaboradores(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("colaborador", "listarTodosRel", objParametros);    
   
    carregarComboAjax($("#colaboradores_pk"), arrCarregar, " ", "pk", "ds_colaborador");         
}

$(document).ready(function(){    
           
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
    

    fcCarregarColaboradores();

    $(".chzn-select").chosen({allow_single_deselect: true});
});


