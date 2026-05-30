var tblResultado;
var click_id = 0;
function fcValidarForm(){

    $("#form").validate({
        rules :{
            colaboradores_pk:{
                required:true
            },
            ic_mes:{
                required: true
            },
            ds_ano:{
                required: true,
                minlength:4
            }

        },
        messages:{
            colaboradores_pk:{
                required:"Por favor, selecione Colaborador"
            },
            ic_mes:{
                required:"Por favor, selecione Mês"
            },
            ds_ano:{
                required:"Por favor, informe Ano",
                minlength:"Por favor, informe Ano válido"
            }
        },
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcCarregarGrid(){
    sendPost('rel_conciliacao_colaborador_cad_form.php', {token: token, colaboradores_pk: $("#colaboradores_pk").val(),ic_mes: $("#ic_mes").val(),ds_ano: $("#ds_ano").val()});
}

function fcCarregarColaborador(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("colaborador", "listarTodosRel", objParametros);    
    carregarComboAjax($("#colaboradores_pk"), arrCarregar, " ", "pk", "ds_colaborador");
        
}

function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}

$(document).ready(function(){    
    var arrCarregar = permissao("rel_colaborador", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
    fcCarregarColaborador();
    
    $("#ds_ano").keypress(function(){
        mascara(this, soNumeros);
    });

});


