function fcValidarForm(){

    $("#form").validate({
        rules :{
            dt_vencimento:{
                required:true,
                minlength:3
            },
            ds_lancamento:{
                required:true,
                minlength:3
            },
            vl_lancamento:{
                required:true,
                minlength:3
            },
            operacao_pk:{
                required:true,
                minlength:3
            },
            tipo_grupo_pk:{
                required:true,
                minlength:3
            },
            grupo_leancamento_pk:{
                required:true,
                minlength:3
            },
            grupo_leancamento_pk:{
                required:true,
                minlength:3
            },
            ic_status_patamento:{
                required:true,
                minlength:3
            },
            obs_lancamento:{
                required:true,
                minlength:3
            },
            dt_competencia:{
                required:true,
                minlength:3
            },
            n_documento:{
                required:true,
                minlength:3
            },
            contas_bancarias_pk:{
                required:true,
                minlength:3
            },
            tipos_operacao_pk:{
                required:true,
                minlength:3
            },
            metodos_pagamento_pk:{
                required:true,
                minlength:3
            }

        },
        messages:{
            dt_vencimento:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            ds_lancamento:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            vl_lancamento:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            operacao_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            tipo_grupo_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            grupo_leancamento_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            grupo_leancamento_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            ic_status_patamento:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            obs_lancamento:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            dt_competencia:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            n_documento:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            contas_bancarias_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            tipos_operacao_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            metodos_pagamento_pk:{
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

    var v_dt_vencimento = $("#dt_vencimento").val();
    var v_ds_lancamento = $("#ds_lancamento").val();
    var v_vl_lancamento = $("#vl_lancamento").val();
    var v_operacao_pk = $("#operacao_pk").val();
    var v_tipo_grupo_pk = $("#tipo_grupo_pk").val();
    var v_grupo_leancamento_pk = $("#grupo_leancamento_pk").val();
    var v_grupo_leancamento_pk = $("#grupo_leancamento_pk").val();
    var v_ic_status_patamento = $("#ic_status_patamento").val();
    var v_obs_lancamento = $("#obs_lancamento").val();
    var v_dt_competencia = $("#dt_competencia").val();
    var v_n_documento = $("#n_documento").val();
    var v_contas_bancarias_pk = $("#contas_bancarias_pk").val();
    var v_tipos_operacao_pk = $("#tipos_operacao_pk").val();
    var v_metodos_pagamento_pk = $("#metodos_pagamento_pk").val();


    var objParametros = {
        "pk": pk,
        "dt_vencimento": encodeURIComponent(v_dt_vencimento),
        "ds_lancamento": encodeURIComponent(v_ds_lancamento),
        "vl_lancamento": encodeURIComponent(v_vl_lancamento),
        "operacao_pk": encodeURIComponent(v_operacao_pk),
        "tipo_grupo_pk": encodeURIComponent(v_tipo_grupo_pk),
        "grupo_leancamento_pk": encodeURIComponent(v_grupo_leancamento_pk),
        "grupo_leancamento_pk": encodeURIComponent(v_grupo_leancamento_pk),
        "ic_status_patamento": encodeURIComponent(v_ic_status_patamento),
        "obs_lancamento": encodeURIComponent(v_obs_lancamento),
        "dt_competencia": encodeURIComponent(v_dt_competencia),
        "n_documento": encodeURIComponent(v_n_documento),
        "contas_bancarias_pk": encodeURIComponent(v_contas_bancarias_pk),
        "tipos_operacao_pk": encodeURIComponent(v_tipos_operacao_pk),
        "metodos_pagamento_pk": encodeURIComponent(v_metodos_pagamento_pk)        
    };    

    var arrEnviar = carregarController("lancamento", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("lancamento_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("lancamento_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("lancamento", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#dt_vencimento").val(arrCarregar.data[0]['dt_vencimento']);
            $("#ds_lancamento").val(arrCarregar.data[0]['ds_lancamento']);
            $("#vl_lancamento").val(arrCarregar.data[0]['vl_lancamento']);
            $("#operacao_pk").val(arrCarregar.data[0]['operacao_pk']);
            $("#tipo_grupo_pk").val(arrCarregar.data[0]['tipo_grupo_pk']);
            $("#grupo_leancamento_pk").val(arrCarregar.data[0]['grupo_leancamento_pk']);
            $("#grupo_leancamento_pk").val(arrCarregar.data[0]['grupo_leancamento_pk']);
            $("#ic_status_patamento").val(arrCarregar.data[0]['ic_status_patamento']);
            $("#obs_lancamento").val(arrCarregar.data[0]['obs_lancamento']);
            $("#dt_competencia").val(arrCarregar.data[0]['dt_competencia']);
            $("#n_documento").val(arrCarregar.data[0]['n_documento']);
            $("#contas_bancarias_pk").val(arrCarregar.data[0]['contas_bancarias_pk']);
            $("#tipos_operacao_pk").val(arrCarregar.data[0]['tipos_operacao_pk']);
            $("#metodos_pagamento_pk").val(arrCarregar.data[0]['metodos_pagamento_pk']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}



function fcAbrirFormDespesaFixa(){
    //limpa os dados de qualquer registro existe
    //fcLimparFormMaterial();
    
    $("#modal_lancamento").modal();
    $("#acao").val("ins");  
}

function fcAbrirFormDespesaVariavel(){
    //limpa os dados de qualquer registro existe
    //fcLimparFormMaterial();
    
    $("#modal_lancamento").modal();
    $("#acao").val("ins");
}

function fcAbrirFormImposto(){
    //limpa os dados de qualquer registro existe
    //fcLimparFormMaterial();
    
    $("#modal_lancamento").modal();
    $("#acao").val("ins");
}

function fcAbrirFormTransferencia(){
    //limpa os dados de qualquer registro existe
    //fcLimparFormMaterial();
    
    $("#modal_lancamento").modal();
    $("#acao").val("ins");
}


$(document).ready(function(){

        //DESPEA FIXA  
        $(document).on('click', '#cmdIncluirDespesaFixa', fcAbrirFormDespesaFixa);
        //DESPESA VARIAVEL
        $(document).on('click', '#cmdIncluirDespesaVariavel', fcAbrirFormDespesaVariavel);
        //IMPOSTOS
        $(document).on('click', '#cmdIncluirImposto', fcAbrirFormImposto);
        //TRANSFERENCIAS
        $(document).on('click', '#cmdIncluirTransferencia', fcAbrirFormTransferencia);
        
        
        alert($("#acao").val());
        
   
        
        
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
});
