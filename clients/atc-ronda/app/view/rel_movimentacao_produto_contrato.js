function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
    
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");         
}



function fcCarregarGridMovimentacaoEstoqueProduto(){
        
    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "dt_troca_ini": $("#dt_troca_ini").val(),
        "dt_troca_fim": $("#dt_troca_fim").val()
    };         

    var v_url = montarUrlController("movimentacao_estoque", "relatorioMovimentacaoEstoqueProduto", objParametros); 
    //NewWindow(v_last_url)
    tblMovimentacaoProdutoContrato = $('#tblMovimentacaoProdutoContrato').DataTable({
        "scrollX": false,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "ordering": false,
        "columnDefs": [
        { "targets": -1, "data": "vl_total_item"},
        {"targets": -2, "data": "t_vl_item"},
        { "targets": -3, "data": "t_qtde" },
        {"targets": -4, "data": ""},
        { "targets": -5, "data": "t_tipo_unidade_pk" },
        { "targets": -6, "data": "t_ds_produto" },
        { "targets": -7, "data": "t_ds_lead" }
        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });

    
    
}

function fcPesquisarMovimentacaoEstoqueProduto() {
    
    tblMovimentacaoProdutoContrato.clear().destroy();
    fcCarregarGridMovimentacaoEstoqueProduto();  
}







$(document).ready(function(){    
    $(document).on('click', '#cmdPesquisarMovimentacaoEstoqueProduto', fcPesquisarMovimentacaoEstoqueProduto);
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

    fcCarregarLeads();
    fcCarregarGridMovimentacaoEstoqueProduto();

    $(".chzn-select").chosen({allow_single_deselect: true});
});
