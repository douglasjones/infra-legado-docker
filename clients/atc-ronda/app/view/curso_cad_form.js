function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_curso:{
                required:true
            },
            ic_status:{
                required:true
            }

        },
        messages:{
            ds_curso:{
                required:"Por favor, informe Curso"
            },
            ic_status:{
                required:"Por favor, informe Status"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_curso = $("#ds_curso").val();
    var v_ic_status = $("#ic_status").val();


    var objParametros = {
        "pk": pk,
        "ds_curso": (v_ds_curso),
        "ic_status": (v_ic_status)        
    };    

    var arrEnviar = carregarController("curso", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("curso_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("curso_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("curso", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_curso").val(arrCarregar.data[0]['ds_curso']);
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
