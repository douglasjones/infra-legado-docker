function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_produto_servico:{
                required:true,
                minlength:3
            }

        },
        messages:{
            ds_produto_servico:{
                required:"Por favor, informe Produto/Serviço",
                minlength:"Produto/Serviço deve ter pelo menos 3 caracteres"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_produto_servico = $("#ds_produto_servico").val();
    var v_ds_cbo = $("#ds_cbo").val();
    var v_vl_servico = $("#vl_servico").val();

    var objParametros = {
        "pk": pk,
        "ds_produto_servico": (v_ds_produto_servico),
        "ds_cbo": (v_ds_cbo),  
        "vl_servico": (v_vl_servico)  
    };    

    var arrEnviar = carregarController("produto_servico", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("produto_servico_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("produto_servico_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("produto_servico", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_produto_servico").val(arrCarregar.data[0]['ds_produto_servico']);
            $("#ds_cbo").val(arrCarregar.data[0]['ds_cbo']);
            $("#vl_servico").val(arrCarregar.data[0]['vl_servico']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

$(document).ready(function()
    {
        var arrCarregar = permissao("produto_servico", "ins");        

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
