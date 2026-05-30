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
    var ds_mes_aniversario = $("#ds_mes_aniversario option:selected").text();
    

    sendPost('rel_colaboradores_aniversariantes_cad_form.php', {token: token, 
        mes_aniversario_pk: $("#ds_mes_aniversario").val(),
        ds_mes_aniversario: ds_mes_aniversario
    });
}

function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}

$(document).ready(function(){   
           
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);

    $(".chzn-select").chosen({allow_single_deselect: true});
});


