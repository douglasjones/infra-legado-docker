function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_cargo:{
                required:true,
                minlength:3
            }

        },
        messages:{
            ds_cargo:{
                required:"Por favor, informe Cargo",
                minlength:"Cargo deve ter pelo menos 3 caracteres"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_cargo = $("#ds_cargo").val();


    var objParametros = {
        "pk": pk,
        "ds_cargo": v_ds_cargo  
    };    

    var arrEnviar = carregarController("cargo", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("cargo_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("cargo_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("cargo", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_cargo").val(arrCarregar.data[0]['ds_cargo']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

$(document).ready(function()
    {
        var arrCarregar = permissao("cargo", "ins");        
        
        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);
