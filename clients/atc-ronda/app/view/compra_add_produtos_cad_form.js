

function fcLimparVariavelProdutos(){
    $("#produto_compra_pk").val("");
    $("#categorias_ins_prod_pk").val("");
    $("#produtos_ins_prod_pk").val("");
    $("#vl_item_produto").val("");
    $("#qtde_produto").val("");
    $("#acao").val("ins")
    
    if($("#categoria_pk_ins").val()!=""){
        $("#categorias_ins_prod_pk").val($("#categoria_pk_ins").val());
    }
    
    $('#ic_entrega').prop('checked', true);
     
}

function fcCarregarProdutosProd(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros);  
  
    carregarComboAjax($("#produtos_ins_prod_pk"), arrCarregar, " ", "pk", "ds_produto");        
}

function fcCarregarCategoriasProd(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);           
    carregarComboAjax($("#categorias_ins_prod_pk"), arrCarregar, " ", "pk", "ds_categoria");       
}

function fcIncluirProduto(){
    
    fcLimparVariavelProdutos();
    fcCarregarCategoriasProd();
    $("#categorias_ins_prod_pk").change(function(){     
        fcCarregarProdutosProd($("#categorias_ins_prod_pk").val());    
        $('#produtos_ins_prod_pk').select2(); 
    });
    $('#categorias_ins_prod_pk').select2(); 
    $("#vl_item_produto").on('keyup', function () {
        mascara(this,moeda);       
    });
    $("#qtde_produto").on('keyup', function () {
        mascara(this,soNumeros);       
    });
    
    $("#janela_produto").modal();
    
}

function fcExcluirProduto(v_pk){

    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("produto_iten", "excluir", objParametros); 
       
        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            //fcRecarregarGridMateriais();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcEditarProduto(objRegistro){
    fcLimparVariavelProdutos();
    fcCarregarCategoriasProd();
   //Lista fornecedor e Produtos conforme a categoria        
    fcCarregarProdutosProd(objRegistro['categorias_produto_pk']);
    
    $("#acao").val("upd");
    $("#produto_compra_pk").val(objRegistro['pk']);
    $("#categorias_ins_prod_pk").val(objRegistro['categorias_produto_pk']);
    $("#produtos_ins_prod_pk").val(objRegistro['produtos_pk']);
    $("#vl_item_produto").val((objRegistro['vl_item']));
    $("#qtde_produto").val(objRegistro['qtde']);
    $('#categorias_ins_prod_pk').select2();     
    $('#produtos_ins_prod_pk').select2(); 
    if(objRegistro['ic_entrega']==2){
        $('#ic_entrega').prop('checked', true);
    }
    else{
        $('#ic_entrega').prop('checked', false);
    }
    

    $("#janela_produto").modal();
    
    
}

function fcEnviarProduto(){
    
    if($("#categorias_ins_prod_pk").val()==""){
        $("#alert_categoria_prod").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_categoria_prod").slideUp(500);
        });
        $('#categorias_ins_prod_pk').focus();
        return false;
    }
    if($("#produtos_ins_prod_pk").val()==""){
        $("#alert_produto_prod").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_produto_prod").slideUp(500);
        });
        $('#produtos_ins_prod_pk').focus();
        return false;
    }
    if($("#vl_item_produto").val()==""){
        $("#alert_vl_prod").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_vl_prod").slideUp(500);
        });
        $('#vl_item_produto').focus();
        return false;
    }
    if($("#qtde_produto").val()==""){
        $("#alert_qtde_prod").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_qtde_prod").slideUp(500);
        });
        $('#qtde_produto').focus();
        return false;
    }
    if($("#compras_pk").val() == ""){
        if($("#acao").val() == "ins"){
            fcIncluirProdutoSemPk();
        }
        else if($("#acao").val() == "upd"){
            fcEditarProdutoSemPk();
        }
    }else{
        fcSalvarProduto();
    }   
    $("#janela_produto").modal("hide");
    $("#modal_compra").modal("show");
}

function fcEditarProdutoSemPk(){
    fcIncluirProdutoSemPk();
    tblCompraProduto.row(rLinhaSelecionadaProd).remove().draw();
    return false;
}

function fcIncluirProdutoSemPk(){  
    var v_ic_entrega = 1;
    var ds_ic_entrega = "";
    if($('#ic_entrega').is(":checked")){
        v_ic_entrega = 2;
        ds_ic_entrega = "Sim";
    }
    else{
        v_ic_entrega = 1;
        ds_ic_entrega = "Não";
    }
    
    tblCompraProduto.row.add(
        {
            "pk":"",
            "categorias_produto_pk":$("#categorias_ins_prod_pk").val(),
            "ds_categoria":$("#categorias_ins_prod_pk option:selected").text(),
            "produtos_pk":$("#produtos_ins_prod_pk").val(),
            "ds_produto":$("#produtos_ins_prod_pk option:selected").text(),
            "qtde":$("#qtde_produto").val(),
            "ic_entrega":v_ic_entrega,
            "ds_entrega":ds_ic_entrega,
            "vl_item":$("#vl_item_produto").val(),
            
            "t_functions":""
        }
    ).draw();
    
    return false;
}

function fcRecarregarGridProduto(){
    tblCompraProduto.clear().destroy();    
    fcCarregarGridProduto();
}

function fcSalvarProduto(){
    
    var v_ic_entrega = 1;
    if($('#ic_entrega').is(":checked")){
        v_ic_entrega = 2;
    }
    else{
        v_ic_entrega = 1;
    }
    
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#produto_compra_pk").val(),
        "compras_pk": $("#compras_pk").val(),
        "produtos_pk": $("#produtos_ins_prod_pk").val(),
        "qtde": $("#qtde_produto").val(),
        "ic_status": $("#ic_status").val(),
        "vl_item": moeda2float($("#vl_item_produto").val()),
        "ic_entrega": v_ic_entrega
    }; 
    var arrEnviar = carregarController("compra", "salvarProduto", objParametros);
  
    if (arrEnviar.result == 'success'){
        fcRecarregarGridProduto();
    }    
    else{
        alert(arrEnviar.result);
    }
    
}


function fcFormatarDadosProdutos(){    
    try{
        var pk = "";
        var categorias_produto_pk = "";
        var produtos_pk =  "";
        var qtde = "";
        var vl_item= "";
        var ic_entrega= "";
        
        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "pk";
        arrKeys[1] = "categorias_produto_pk";
        arrKeys[2] = "produtos_pk";
        arrKeys[3] = "qtde";
        arrKeys[4] = "vl_item";
        arrKeys[5] = "ic_entrega";
        
        var  data = tblCompraProduto.rows().data();
        
        for(i = 0; i< data.length; i++){
            if(data[i]['pk']==""){
                
                pk = data[i]['pk'];
                categorias_produto_pk = data[i]['categorias_produto_pk'];
                produtos_pk =  data[i]['produtos_ins_prod_pk'];
                qtde = data[i]['qtde'];
                vl_item = moeda2float(data[i]['vl_item']);
                ic_entrega = data[i]['ic_entrega'];
                
                arrDados[i] = [pk, categorias_produto_pk, produtos_pk, qtde, vl_item, ic_entrega]; 
            }
                                   
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}
