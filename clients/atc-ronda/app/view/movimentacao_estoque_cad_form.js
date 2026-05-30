function fcValidarForm(){

    $("#form").validate({
        rules :{
            leads_pk:{
                required:true,
                minlength:3
            },
            colaborador_pk:{
                required:true,
                minlength:3
            },
            produtos_itens_pk:{
                required:true,
                minlength:3
            },
            qtde:{
                required:true,
                minlength:3
            },
            obs_movimentacao:{
                required:true,
                minlength:3
            }

        },
        messages:{
            leads_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            colaborador_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            produtos_itens_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            qtde:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            obs_movimentacao:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_leads_pk = $("#leads_pk").val();
    var v_colaborador_pk = $("#colaborador_pk").val();
    var v_produtos_itens_pk = $("#produtos_itens_pk").val();
    var v_qtde = $("#qtde").val();
    var v_obs_movimentacao = $("#obs_movimentacao").val();


    var objParametros = {
        "pk": pk,
        "leads_pk": encodeURIComponent(v_leads_pk),
        "colaborador_pk": encodeURIComponent(v_colaborador_pk),
        "produtos_itens_pk": encodeURIComponent(v_produtos_itens_pk),
        "qtde": encodeURIComponent(v_qtde),
        "obs_movimentacao": encodeURIComponent(v_obs_movimentacao)        
    };    

    var arrEnviar = carregarController("movimentacao_estoque", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("movimentacao_estoque_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("movimentacao_estoque_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("movimentacao_estoque", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);
            $("#colaborador_pk").val(arrCarregar.data[0]['colaborador_pk']);
            $("#produtos_itens_pk").val(arrCarregar.data[0]['produtos_itens_pk']);
            $("#qtde").val(arrCarregar.data[0]['qtde']);
            $("#obs_movimentacao").val(arrCarregar.data[0]['obs_movimentacao']);

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
