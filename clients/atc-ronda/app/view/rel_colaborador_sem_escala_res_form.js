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
    

    sendPost('rel_colaborador_sem_escala_cad_form.php', {token: token, 
        colaboradores_pk: $("#colaboradores_pk").val(),
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
    var arrCarregar = carregarController("colaborador", "listarTodosComboRelSemEscala", objParametros);    
    
    carregarComboAjax($("#colaboradores_pk"), arrCarregar, " ", "pk", "ds_colaborador");         
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
    

    $(".chzn-select").chosen({allow_single_deselect: true});
});


