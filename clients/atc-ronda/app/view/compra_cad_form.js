function fcSalvarCompra(){    
    
    //var strProdutoItem = fcFormatarDadosProdutos();
    var strDocs = fcFormatarDadosDocumentos();
    
    if($("#fornecedor_pk_ins").val()==""){
        $("#alert_fornecedor").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_fornecedor").slideUp(500);
        });
        $('#fornecedor_pk_ins').focus();
        return false;
    }
    if($("#categoria_pk_ins").val()==""){
        $("#alert_categoria").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_categoria").slideUp(500);
        });
        $('#categoria_pk_ins').focus();
        return false;
    }
    if($("#empresa_pk_ins").val()==""){
        $("#alert_empresa").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_empresa").slideUp(500);
        });
        $('#empresa_pk_ins').focus();
        return false;
    }
    if($("#ds_numero_nota_ins").val()==""){
        $("#alert_n_doc").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_n_doc").slideUp(500);
        });
        $('#ds_numero_nota_ins').focus();
        return false;
    }
    if($("#dt_pagamento").val()==""){
        $("#alert_dt_pag").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_pag").slideUp(500);
        });
        $('#dt_pagamento').focus();
        return false;
    }
    if($("#metodos_pagamento_pk").val()==""){
        $("#alert_forma_apg").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_forma_apg").slideUp(500);
        });
        $('#metodos_pagamento_pk').focus();
        return false;
    }
    if($("#vl_notafiscal").val()==""){
        $("#alert_vl_n_doc").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_vl_n_doc").slideUp(500);
        });
        $('#vl_notafiscal').focus();
        return false;
    }
    
    var vl_frete = "";
    if($("#vl_frete").val()!=""){
        var vl_frete = moeda2float($("#vl_frete").val());
    }
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": pk,
        "fornecedor_pk": $("#fornecedor_pk_ins").val(),
        "categoria_pk": $("#categoria_pk_ins").val(),
        "conta_pk": $("#empresa_pk_ins").val(),
        "dt_pagamento": $("#dt_pagamento").val(),
        "metodos_pagamento_pk": $("#metodos_pagamento_pk").val(),
        "qtde_parcelas": $("#qtde_parcelas").val(),
        "ds_numero_nota": $("#ds_numero_nota_ins").val(),
        "vl_notafiscal": moeda2float($("#vl_notafiscal").val()),
        "vl_frete":vl_frete,
        "dt_entrega": $("#dt_entrega").val(),
        "grupo_lancamento_centro_custo_pk": $("#grupo_lancamento_centro_custo_pk").val(),
        "centro_custo_pk": $("#tipo_grupo_centro_custo_pk").val(),
        "ic_status": $("#ic_status").val(),
        "documentos_pk": strDocs
    }; 
    var arrEnviar = carregarController("compra", "salvar", objParametros);
   
    if (arrEnviar.result == 'success'){
        
        $("#compras_pk").val(arrEnviar.data[0]['pk']);
        fcSalvarProdutoAposSalvarCompra();
        alert(arrEnviar.message);
        sendPost("compra_res_form.php", {token: token});
        
        
    }    
    else{
        alert(arrEnviar.result);
    }
    
}


function fcSalvarProdutoAposSalvarCompra(){
    var  data = tblCompraProduto.rows().data();
        
    for(i = 0; i< data.length; i++){
        var objParametros = {
            "pk": data[i]['pk'],
            "compras_pk": $("#compras_pk").val(),
            "produtos_pk": data[i]['produtos_pk'],
            "qtde": data[i]['qtde'],
            "ic_status": $("#ic_status").val(),
            "vl_item": moeda2float(data[i]['vl_item']),
            "ic_entrega": data[i]['ic_entrega']
        }; 
        var arrEnviar = carregarController("compra", "salvarProduto", objParametros);

        if (arrEnviar.result == 'success'){
           
        }    
        else{
            alert(arrEnviar.result);
        }
    }
    
}


function fcCarregarGridProduto(){
    
    var objParametros = {
       "compras_pk": pk
   };     
   
   var v_url = montarUrlController("produto_iten", "listarPorCompra", objParametros);
 
   //Trata a tabela
   tblCompraProduto = $('#tblCompraProduto').DataTable({
       "scrollX": false,
       "ajax": {"url": v_url, "type": "POST"},
       "responsive": true,
       "columnDefs": [{
               "targets": -1,
               "data": null,
               "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
           },
          {"targets": -2, "data": "vl_item"},
          {"targets": -3, "data": "ds_entrega"},
          {"targets": -4, "data": "qtde"},
          {"targets": -5, "data": "ic_entrega","visible":false},
          {"targets": -6, "data": "ds_produto"},
          {"targets": -7, "data": "produtos_pk","visible":false},
          {"targets": -8, "data": "ds_categoria"},
          {"targets": -9, "data": "categorias_produto_pk","visible":false},
          {"targets": -10, "data": "pk"}

        ],
       "language":{
           "url": "../inc/js/datatables/pt_br.php",
           "type": "GET"
           }
   });
   
   
   //Atribui os eventos na coluna ação.
   $('#tblCompraProduto tbody').on('click', '.function_edit', function () {
       var data;
       rLinhaSelecionadaProd = null;
       if(tblCompraProduto.row( $(this).parents('li')).data()){
           data = tblCompraProduto.row( $(this).parents('li')).data();
           rLinhaSelecionadaProd = $(this).parents('li');
       }
       else if(tblCompraProduto.row( $(this).parents('tr')).data()){
           data = tblCompraProduto.row( $(this).parents('tr')).data();
           rLinhaSelecionadaProd = $(this).parents('tr');
       }
       fcEditarProduto(data);
       
   } );   
   
   $('#tblCompraProduto tbody').on('click', '.function_delete', function () {
       var data;
       if(tblCompraProduto.row( $(this).parents('li') ).data()){
           data = tblCompraProduto.row( $(this).parents('li') ).data();
       }
       else if(tblCompraProduto.row( $(this).parents('tr') ).data()){
           data = tblCompraProduto.row( $(this).parents('tr') ).data();
       }
       if(data['pk'] != ""){
           fcExcluirProduto(data['pk']);
       }
       tblCompraProduto.row($(this).parents('tr')).remove().draw();
       
   } );
}

function fcCarregarGridDocumentos(){
    var objParametros = {
        "compras_pk": pk
    };

    var v_url = montarUrlController("documento", "listarDocumentosCompra", objParametros);
   
    //Trata a tabela
    tblDocumentos = $('#tblDocumentos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' download><span><img width=16 height=16 src='../img/download.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_nome_original"},
           {"targets": -3, "data": "t_ds_obs"},
           {"targets": -4, "data": "t_ds_documento"},
           {"targets": -5, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblDocumentos tbody').on('click', '.function_edit', function () {
        var data;

        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }
        fcDownloadDocumento(data['t_ds_documento']);
    });
    
}

function fcCarregarCategorias(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);      
    carregarComboAjax($("#categoria_pk_ins"), arrCarregar, " ", "pk", "ds_categoria");            
}

function fcCarregarFornecedor(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("fornecedor", "listarPorCategoria", objParametros);      
    carregarComboAjax($("#fornecedor_pk_ins"), arrCarregar, " ", "pk", "ds_fornecedor");        
}

function fcCarregarProdutos(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros);  
  
    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");        
}

function fcLimparVariavelCompras(){
    $("#fornecedor_pk_ins").val("");
    $("#categoria_pk_ins").val("");
    $("#empresa_pk_ins").val("");
    $("#tipo_grupo_centro_custo_pk").val("");
    $("#grupo_lancamento_centro_custo_pk").val("");
    $("#ds_numero_nota_ins").val("");
    $("#dt_pagamento").val("");
    $("#dt_entrega").val("");
    $("#metodos_pagamento_pk").val("");
    $("#qtde_parcelas").val("");
    $("#vl_notafiscal").val("");
    $("#vl_frete").val("");
    $("#compras_pk").val("");  
}

function fcListarOptionParcela(){
    $("#qtde_parcela_combo").append("");
    $("#qtde_parcela_combo").empty();
    var str ="";
    str += "<select class='form-control form-control-sm'  id='qtde_parcelas' name='qtde_parcelas' >";
    str += "    <option ></option>";
    for(i=1;i<73;i++){
        str += "<option value='"+i+"'>"+i+" Parcela(s)</option>";
    }
    str += "</select>";
    
    $("#qtde_parcela_combo").append(str);
}

function fcListarMetodosPagamentoReceita(){
    var objParametros = {
        "pk": ""
    };          
   
    var arrCarregar = carregarController("metodo_pagamento", "listarTodos", objParametros);   
    carregarComboAjax($("#metodos_pagamento_pk"), arrCarregar, " ", "pk", "ds_metodo_pagamento");     
}

function fcListarItensGruposCentroCustoReceita(){
    var objParametros = {
        "tipo_grupo_pk": ""
    };          
    if($("#tipo_grupo_centro_custo_pk").val()==1){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros); 
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk"), arrCarregar, " ", "pk", "ds_lead"); 
        
    }else if($("#tipo_grupo_centro_custo_pk").val()==2){
        
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk"), arrCarregar, " ", "pk", "ds_colaborador");   
        
    }else if($("#tipo_grupo_centro_custo_pk").val()==3){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk"), arrCarregar, " ", "pk", "ds_fornecedor");  
        
    }
    else if($("#tipo_grupo_centro_custo_pk").val()==4){
        var arrCarregar = carregarController("equipe", "listarTodos", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk"), arrCarregar, " ", "pk", "ds_equipe");   
    }
}

function fcSelecionarCategoriaFornecedor(){    
    var objParametros = {
        "pk": $("#fornecedor_pk_ins").val()
    };          
    var arrCarregar = carregarController("fornecedor", "listarPk", objParametros);  
    if(arrCarregar.data[0]['categorias_produto_pk']!=null){
        $("#categoria_pk_ins").val(arrCarregar.data[0]['categorias_produto_pk']);
    }
          
}

function fcCarregar(){
    if(pk>0){
        var objParametros = {
            "pk": pk
        };          
        var arrCarregar = carregarController("compra", "listarPk", objParametros);  
        $("#categoria_pk_ins").val(arrCarregar.data[0]['categoria_pk'])
        fcCarregarFornecedor('');   
        fcCarregarProdutos($("#categoria_pk_ins").val());   
        $("#fornecedor_pk_ins").val(arrCarregar.data[0]['fornecedor_pk'])
        $("#empresa_pk_ins").val(arrCarregar.data[0]['conta_pk'])
        $("#tipo_grupo_centro_custo_pk").val(arrCarregar.data[0]['centro_custo_pk'])
        fcListarItensGruposCentroCustoReceita();
        $("#grupo_lancamento_centro_custo_pk").val(arrCarregar.data[0]['grupo_lancamento_centro_custo_pk'])
        $("#metodos_pagamento_pk").val(arrCarregar.data[0]['metodos_pagamento_pk'])
        $("#ds_numero_nota_ins").val(arrCarregar.data[0]['ds_numero_nota'])
        $("#dt_pagamento").val(arrCarregar.data[0]['dt_pagamento'])
        $("#dt_entrega").val(arrCarregar.data[0]['dt_entrega'])
        $("#vl_notafiscal").val(arrCarregar.data[0]['vl_notafiscal'])
        $("#vl_frete").val(arrCarregar.data[0]['vl_frete'])
        $("#qtde_parcelas").val(arrCarregar.data[0]['qtde_parcelas'])
        $("#ic_status").val(arrCarregar.data[0]['ic_status'])
        $("#compras_pk").val(arrCarregar.data[0]['pk'])
    }   
}

function fcCarregarEmpresa(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("conta", "listarPk", objParametros);      
    carregarComboAjax($("#empresa_pk_ins"), arrCarregar, " ", "pk", "ds_conta");        
}

function fcVoltar(){
    sendPost("compra_res_form.php", {token: token});
}


$(document).ready(function(){
    fcListarOptionParcela();
    fcCarregarCategorias();
    fcCarregarFornecedor('');
    $("#categoria_pk_ins").change(function(){     
        fcCarregarProdutos($("#categoria_pk_ins").val());     
    });
    fcCarregarEmpresa();
    fcListarMetodosPagamentoReceita();
    $("#tipo_grupo_centro_custo_pk").change(function(){    
        fcListarItensGruposCentroCustoReceita();   
    });
    fcCarregarGridProduto();
    fcCarregarGridDocumentos();
    fcCarregar();
    fcCarregarGridArquivos();

    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdIncluirProduto', fcIncluirProduto);   
    $(document).on('click', '#cmdIncluirDocumento', fcAbrirFormNovoDocumento);
    $(document).on('click', '#cmdSalvarCompra', fcSalvarCompra);
    $(document).on('click', '#cmdEnviarProduto', fcEnviarProduto);
    $(document).on('click', '#cmdEnviarDocumento', fcValidarDocumentos);

    $("#vl_notafiscal").on('keyup', function () {
        mascara(this,moeda);       
    });
    $("#vl_frete").on('keyup', function () {
        mascara(this,moeda);       
    });
    $("#ds_numero_nota_ins").on('keyup', function () {
        mascara(this,soNumeros);       
    });
   
    $('#dt_pagamento').datepicker({defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_pagamento").on('keyup', function () {
        mascara(this,mdata);       
    });

    $('#dt_entrega').datepicker({defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_entrega").on('keyup', function () {   
        mascara(this,mdata);       
    });

    
    //Formatar Campos
    $('#fornecedor_pk_ins').select2();
    $('#categoria_pk_ins').select2();
    $('#empresa_pk_ins').select2();
    $('#grupo_lancamento_centro_custo_pk').select2();
    $('#metodos_pagamento_pk').select2();
    $('#qtde_parcelas').select2();


});
