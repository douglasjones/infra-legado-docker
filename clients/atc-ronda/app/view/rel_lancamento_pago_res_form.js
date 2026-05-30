var tblResultado;
var click_id = 0;
function fcValidarForm(){

    $("#form").validate({
        rules :{
        },
        messages:{
        },
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcCarregarGrid(){
    
    
    var tipo_lancamento = 0;
    if($("#tipo_lancamento_receita").is(":checked") == true && $("#tipo_lancamento_despesa").is(":checked") == true){
        tipo_lancamento = 0;
    }
    else if($("#tipo_lancamento_receita").is(":checked") == true){
        tipo_lancamento = 1;
    }
    else if($("#tipo_lancamento_despesa").is(":checked") == true){
        tipo_lancamento = 2;
    }
    else{
        tipo_lancamento = 0;
    }
    
    var dt_pagamento_ini = $("#dt_pagamento_ini").val();
    var dt_pagamento_fim = $("#dt_pagamento_fim").val();
    var dt_lancamento_ini = $("#dt_lancamento_ini").val();
    var dt_lancamento_fim = $("#dt_lancamento_fim").val();
    
    var lancamento_pk = $("#lancamento_pk").val();
    var pk_cliente = $("#pk_cliente").val();
    var cnpj_cliente = $("#cnpj_cliente").val();
    var cnpj_fornecedor = $("#cnpj_fornecedor").val();
    

    sendPost('rel_lancamento_pago_cad_form.php', {token: token,
        dt_pagamento_ini:dt_pagamento_ini,
        dt_pagamento_fim:dt_pagamento_fim,
        dt_lancamento_ini:dt_lancamento_ini,
        dt_lancamento_fim:dt_lancamento_fim,
        lancamento_pk:lancamento_pk,
        tipo_lancamento_pk:tipo_lancamento,
        pk_cliente:pk_cliente,
        cnpj_cliente:cnpj_cliente,
        cnpj_fornecedor:cnpj_fornecedor
       
    });
}

function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}


$(document).ready(function(){    
           
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
    
    
    $('#dt_pagamento_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

    $("#dt_pagamento_ini").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_pagamento_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

    $("#dt_pagamento_fim").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_lancamento_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

    $("#dt_lancamento_ini").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_lancamento_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

    $("#dt_lancamento_fim").keypress(function(){
       mascara(this,mdata);
    });
    
    
    $("#cnpj_cliente").keypress(function(){
        chama_mascara(this);
     });
    $("#cnpj_fornecedor").keypress(function(){
        chama_mascara(this);
     });
     
     $("#pk_cliente").keypress(function(){
        mascara(this,soNumeros);
     });
     $("#lancamento_pk").keypress(function(){
        mascara(this,soNumeros);
     });
    
    
});


