function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_beneficio:{
                required:true,
                minlength:3
            },
            ic_status:{
                required:true
            }

        },
        messages:{
            ds_beneficio:{
                required:"Por favor, informe Benefícios",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            ic_status:{
                required:"Por favor, informe "
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_beneficio = $("#ds_beneficio").val();
    var v_ic_status = $("#ic_status").val();


    var objParametros = {
        "pk": pk,
        "ds_beneficio": (v_ds_beneficio),
        "ic_status": (v_ic_status)        
    };    

    var arrEnviar = carregarController("beneficio", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("beneficio_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("beneficio_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("beneficio", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_beneficio").val(arrCarregar.data[0]['ds_beneficio']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

$(document).ready(function()
    {
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);
