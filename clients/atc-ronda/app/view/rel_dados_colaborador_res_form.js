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
    var ds_colaborador = $("#colaborador_pk option:selected").text()
    var ic_status = $("#ic_status").val()
    

    sendPost('rel_dados_colaborador_cad_form.php', {token: token,
        ds_colaborador:ds_colaborador,
        colaborador_pk:$("#colaborador_pk").val(),
        ic_status:ic_status
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

$(document).ready(function(){    
           
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
    fcCarregarComboColaborador();
    $(".chzn-select").chosen({allow_single_deselect: true});
});


