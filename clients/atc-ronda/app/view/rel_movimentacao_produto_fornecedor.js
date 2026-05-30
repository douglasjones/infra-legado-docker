function fcCarregarFornecedor(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("fornecedor", "listarTodosFornecedores", objParametros);    
    
    carregarComboAjax($("#fornecedor_pk"), arrCarregar, " ", "pk", "ds_fornecedor");         
}





function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}


function fcCarregarGridMovimentacaoProdutoFornecedor(){
    
    var leads_pk_option = $("#leads_pk option:selected").text();
    var fornecedor_pk_option = $("#leads_pk option:selected").text();
    
   
    sendPost('rel_movimentacao_produto_fornecedor_cad_form.php', {token: token, 
        dt_movimentacao_ini: $("#dt_troca_ini").val(),
        dt_movimentacao_fim: $("#dt_troca_fim").val(),
        leads_pk: $("#leads_pk").val(),
        fornecedor_pk: $("#fornecedor_pk").val(),
        fornecedor_pk_option:fornecedor_pk_option,
        leads_pk_option:leads_pk_option
    });
}




$(document).ready(function(){    
    
        //Datas
    $('#dt_troca_ini').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_troca_ini").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_troca_fim').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_troca_fim").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });

    fcCarregarFornecedor();
    //fcCarregarGridMovimentacaoEstoqueProduto();
    $(document).on('click', '#fcCarregarGridMovimentacaoProdutoFornecedor', fcCarregarGridMovimentacaoProdutoFornecedor);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(".chzn-select").chosen({allow_single_deselect: true});
    
   
});
