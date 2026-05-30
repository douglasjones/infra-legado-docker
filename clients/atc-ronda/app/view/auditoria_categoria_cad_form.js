function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_categoria:{
                required:true,
                minlength:3
            },
            ic_status:{
                required:true
            }

        },
        messages:{
            ds_categoria:{
                required:"Por favor, informe Categoria",
                minlength:"Categoria deve ter pelo menos 3 caracteres"
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

    var v_ds_categoria = $("#ds_categoria").val();
    var v_ic_status = $("#ic_status").val();


    var objParametros = {
        "pk": pk,
        "ds_categoria": v_ds_categoria,
        "ic_status": v_ic_status      
    };    

    var arrEnviar = carregarController("auditoria_categoria", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("auditoria_categoria_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("auditoria_categoria_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("auditoria_categoria", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_categoria").val(arrCarregar.data[0]['ds_categoria']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

$(document).ready(function(){
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);
