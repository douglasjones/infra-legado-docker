function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_genero:{
                required:true,
                minlength:3
            }

        },
        messages:{
            ds_genero:{
                required:"Por favor, informe Gênero",
                minlength:"Gênero deve ter pelo menos 3 caracteres"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_genero = $("#ds_genero").val();


    var objParametros = {
        "pk": pk,
        "ds_genero": (v_ds_genero)        
    };    

    var arrEnviar = carregarController("genero", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("genero_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("genero_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("genero", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_genero").val(arrCarregar.data[0]['ds_genero']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

$(document).ready(function()
    {
        var arrCarregar = permissao("genero", "ins");        

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
