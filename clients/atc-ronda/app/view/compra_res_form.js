var tblResultado;
var tblCompraProduto;
var rLinhaSelecionadaProd;

function fcCarregarGrid(){
    var objParametros = {
        "fornecedor_pk": $("#fornecedor_pk").val(),
        "categorias_pk": $("#categorias_pk").val(),
        "ds_numero_nota": $("#ds_numero_nota").val(),
        "contas_pk": $("#empresas_pk").val(),
        "dt_cadastro_ini": $("#dt_cadastro_ini").val(),
        "dt_cadastro_fim": $("#dt_cadastro_fim").val()
    };     
    
    var v_url = montarUrlController("compra", "listarDataTable", objParametros);
    
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "vl_pagamento"},
           {"targets": -3, "data": "dt_cadastro"},
           {"targets": -4, "data": "ds_conta"},
           {"targets": -5, "data": "ds_numero_nota"},
           {"targets": -6, "data": "ds_categoria"},
           {"targets": -7, "data": "ds_fornecedor"},
           {"targets": -8, "data": "pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcEditar(data['pk']);
        
    });   
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['pk']);
    });            
}

function fcEditar(v_pk){
    sendPost('compra_cad_form.php', {token: token, pk: v_pk});
}

function fcIncluir(){
    sendPost('compra_cad_form.php', {token: token, pk:''});
}

function fcPesquisar(){
    tblResultado.clear().destroy();
    fcCarregarGrid();
}

function fcExcluir(v_pk){
    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("compra", "excluir", objParametros);   

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

            }
            else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}

function fcCarregarCategorias(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);    
    carregarComboAjax($("#categorias_pk"), arrCarregar, " ", "pk", "ds_categoria");         
    carregarComboAjax($("#categorias_ins_prod_pk"), arrCarregar, " ", "pk", "ds_categoria");        
}

function fcCarregarFornecedor(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("fornecedor", "listarPorCategoria", objParametros);    
    carregarComboAjax($("#fornecedor_pk"), arrCarregar, " ", "pk", "ds_fornecedor");           
}


function fcCarregarEmpresa(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("conta", "listarPk", objParametros);    
    
    carregarComboAjax($("#empresas_pk"), arrCarregar, " ", "pk", "ds_conta");        
}

$(document).ready(function(){

    //faz a carga inicial do grid.
    fcCarregarGrid();

    //Carregar Combos
    fcCarregarCategorias();
    fcCarregarFornecedor("");
    fcCarregarEmpresa();
    
    //Formatar Campos
    $('#categorias_pk').select2();
    $('#fornecedor_pk').select2();
    $('#empresas_pk').select2();

    $('#dt_cadastro_ini').datepicker({defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_ini").on('keyup', function () {
        mascara(this,mdata);       
    });

    $('#dt_cadastro_fim').datepicker({defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_fim").on('keyup', function () {
        mascara(this,mdata);       
    });

    //Atribui os eventos
        $(document).on('click', '#cmdPesquisar', fcPesquisar);
        $(document).on('click', '#cmdIncluir', fcIncluir);

    

});


