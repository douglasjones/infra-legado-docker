function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_motivo_pausa:{
                required:true,
                minlength:3
            }

        },
        messages:{
            ds_motivo_pausa:{
                required:"Por favor, informe Motivo Pausa",
                minlength:"Motivo Pausa deve ter pelo menos 3 caracteres"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_motivo_pausa = $("#ds_motivo_pausa").val();


    var objParametros = {
        "pk": pk,
        "ds_motivo_pausa": (v_ds_motivo_pausa)        
    };    

    var arrEnviar = carregarController("motivo_pausa", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("motivo_pausa_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("motivo_pausa_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("motivo_pausa", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_motivo_pausa").val(arrCarregar.data[0]['ds_motivo_pausa']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

$(document).ready(function()
    {
        
        var arrCarregar = permissao("motivo_pausa", "ins");        

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
