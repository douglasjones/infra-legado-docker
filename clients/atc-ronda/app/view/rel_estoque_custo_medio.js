
function fcCarregarProdutos(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("produto", "listarTodos", objParametros);  

    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");        
}


function fcCarregarEstoqueCustoMedio(){
        
    var objParametros = {
        "produtos_pk": $("#produtos_pk").val(),
        "dt_troca_ini": $("#dt_troca_ini").val(),
        "dt_troca_fim": $("#dt_troca_fim").val()
    };         

    var v_url = montarUrlController("movimentacao_estoque", "relatorioMovimentacaoEstoqueCustoMedio", objParametros);  
    //NewWindow(v_last_url)
    tblEstoqueCustoMedio = $('#tblEstoqueCustoMedio').DataTable({
        "scrollX": false,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "ordering": false,
        "columnDefs": [
        { "targets": -1, "data": "t_vl_item"},
        {"targets": -2, "data": "t_vl_total_item_saida"},
        { "targets": -3, "data": "t_qtde" },
        { "targets": -4, "data": "t_vl_total_item_entrada"},
        {"targets": -5, "data": "t_qtde_inicial"},
        { "targets": -6, "data": "t_qtde_inicial" },//QT. EST. INICIAL
        {"targets": -7, "data": "t_vl_unitario"},
        { "targets": -8, "data": "t_ds_tipo_unidade" },
        { "targets": -9, "data": "t_ds_n_serie" },
        { "targets": -10, "data": "t_ds_produto" }
        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });

    
    
}

function fcPesquisarCustoMedioEstoque() {
    tblEstoqueCustoMedio.clear().destroy();
    fcCarregarEstoqueCustoMedio();  
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

    fcCarregarProdutos();
    fcCarregarEstoqueCustoMedio();

    $(".chzn-select").chosen({allow_single_deselect: true});

    $(document).on('click', '#cmdPesquisarCustoMedioEstoque', fcPesquisarCustoMedioEstoque);
});