function fcValidarForm(){

    $("#form").validate({
        rules :{
            produtos_pk:{
                required:true
            },
            fornecedor_pk:{
                required:true
            },
            qtde:{
                required:true
            }
            ,vl_unitario:{
                required:true
            }

        },
        messages:{
            fornecedor_pk:{
                required:"Por favor, informe o fornecedor!"
            },
            produtos_pk:{
                required:"Por favor, informe o produto "               
            },
            qtde:{
                required:"Por favor, informe a quantidade"               
            }
            ,vl_unitario:{
                required:"Por favor, informe o Valor Unitário"               
            }
        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_n_ordem = $("#ds_n_ordem").val();
    var v_obs_entrada_estoque = $("#obs_entrada_estoque").val();
    var v_fornecedor_pk = $("#fornecedor_pk").val();
    var v_produtos_pk = $("#produtos_pk").val();
    var v_qtde = $("#qtde").val();
    var v_vl_unitario = $("#vl_unitario").val();
    var strProdutoItens = fcFormatarDados();
    


    var objParametros = {
        "pk": pk,
        "ds_n_ordem": (v_ds_n_ordem),
        "obs_entrada_estoque": (v_obs_entrada_estoque),
        "fornecedor_pk": (v_fornecedor_pk),
        "produtos_pk": (v_produtos_pk),
        "qtde": (v_qtde),
        "vl_unitario": moeda2float(v_vl_unitario),
        "produtos_itens": (strProdutoItens)
    };    

    var arrEnviar = carregarController("entrada_estoque", "salvar", objParametros);           
   
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("entrada_estoque_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("entrada_estoque_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("entrada_estoque", "listarPk", objParametros);

        if (arrCarregar.result == 'success'){
            $(".chzn-select").chosen('destroy');
            $("#ds_n_ordem").val(arrCarregar.data[0]['ds_n_ordem']);
            $("#obs_entrada_estoque").val(arrCarregar.data[0]['obs_entrada_estoque']);
            $("#fornecedor_pk").val(arrCarregar.data[0]['fornecedor_pk']);
            $("#produtos_pk").val(arrCarregar.data[0]['produtos_pk']);
            $("#vl_unitario").val(float2moeda(arrCarregar.data[0]['vl_unitario']));
            $("#categorias_produto_pk").val(arrCarregar.data[0]['categorias_produto_pk']);
            $("#qtde").val(arrCarregar.data[0]['qtde']);
            $("#qtde_registro").val(arrCarregar.data[0]['qtde']);
             $(".chzn-select").chosen({allow_single_deselect: true});
             
             if(fcCarregarQtdeProdutosItens() > 0){
                   $('#ic_listar_itens').prop('checked', true);
                   $('#ic_listar_itens').prop('disabled', true);
                   $('#qtde').prop('disabled', true);
                   fcAtualizarDadosGrid();
                   $('#exibir_grid_produto_itens').show();
               }
               else{
                   $('#ic_listar_itens').prop('checked', false);
                   $('#ic_listar_itens').prop('disabled', false);
                   $('#qtde').prop('disabled', true);
                   $('#exibir_grid_produto_itens').hide();
               } 

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}
function fcCarregarCategorias(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);    
    carregarComboAjax($("#categorias_produto_pk"), arrCarregar, " ", "pk", "ds_categoria");        
}
function fcCarregarFornecedor(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("fornecedor", "listarPorCategoria", objParametros);    
    carregarComboAjax($("#fornecedor_pk"), arrCarregar, " ", "pk", "ds_fornecedor");        
}
function fcCarregarProdutos(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros);  

    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");        
}



function fcFormatarGrid(){
        
    tblProdutoItens = $("#tblProdutoItens").DataTable({
        "scrollX": false,
        "responsive": true,
        "searching": false,
        "paging": false,
        "autoWidth": false,
     "columnDefs":
           [
               {
                   "targets": [0],
                   "visible": true,
                   "width": "2%"
               },
               {
                   "targets": [1],
                   "visible": true,
                   "searchable": true,
                   "width": "98%"
               }],
           
    
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }            
    });
    
    return false;
    
}
function fcIncluirLinha(){
    
    tblProdutoItens.row.add(
            ["<input type='text'  id='produtos_itens_pk' class='form-control form-control-sm' disabled/>",
             "<input type='text' class='form-control form-control-sm' id='ds_n_serie' />"
            ]
    ).draw( false );

    
    return false;
}

function fcFormatarDados(){

    var produtos_itens_pk = $("input[id='produtos_itens_pk']");
    var ds_n_serie = $("input[id='ds_n_serie']");
    
    var arrKeys = [];
    arrKeys[0] = "produtos_itens_pk";
    arrKeys[1] = "ds_n_serie";
    
    var arrDados = [];
   
    var  data = tblProdutoItens.rows().data();
    for(i = 0; i < data.length; i++){
        if(produtos_itens_pk.get(i).value!="" || ds_n_serie.get(i).value!=""){
            arrDados[i] = [produtos_itens_pk.get(i).value, ds_n_serie.get(i).value];
        }
        
        
    }
    
    return arrayToJson(arrKeys, arrDados);
    
}

function fcAtualizarDadosGrid(){
    if(pk!=""){
        
        var v_url = "../controller/produto_iten.controller.php?job=listarProdutoEstoque&token="+token+"&entrada_estoque_pk="+pk;
        var request = $.ajax({
            url:          v_url,
            cache:        false,
            dataType:     'json',
            contentType:  'application/json; charset=utf-8',
            type:         'post'
        });

        request.done(function(output){
            if (output.result == 'success'){
                for(i = 0; i < output.data.length; i++){

                    //Adiciona a linha.
                    fcIncluirLinha();

                    //Pega as variaveis 
                    var produtos_itens_pk = $("input[id='produtos_itens_pk']");
                    var ds_n_serie = $("input[id='ds_n_serie']");

                    produtos_itens_pk.get(i).value = output.data[i]['pk'];
                    ds_n_serie.get(i).value = output.data[i]['ds_n_serie'];
                }
            }
            else{
                alert('Falhar ao carregar o registro');
            }
        });
        request.fail(function(jqXHR, textStatus){
            alert('Falha ao carregar o registro: ' + textStatus);
        });    
    }
    
    
}
function fcCarregarQtdeProdutosItens(){
    if(pk!=""){
        var objParametros = {
            "entrada_estoque_pk": pk
        };          
        var arrCarregar = carregarController("produto_iten", "listarProdutoEstoqueNSerie", objParametros);  

        return arrCarregar.data.length ;
    }
}

function fcMostrarGridProdutosItens(){
    if(pk!=""){
         if($('#ic_listar_itens').is(":checked")){
            tblProdutoItens.clear().destroy();
            fcFormatarGrid();
            fcAtualizarDadosGrid();
            $('#exibir_grid_produto_itens').show();
            for(i=0; i< ($("#qtde").val() - $("#qtde_registro").val());i++){
                fcIncluirLinha();
            } 
        }
        else{
            tblProdutoItens.clear().destroy();
            fcFormatarGrid();

           $('#exibir_grid_produto_itens').hide();
        }       
    }
    else{
        if($('#ic_listar_itens').is(":checked")){
            tblProdutoItens.clear().destroy();
            fcFormatarGrid();
            fcAtualizarDadosGrid();
            $('#exibir_grid_produto_itens').show();
            for(i=0; i< ($("#qtde").val());i++){
                fcIncluirLinha();
            } 
        }
        else{
            tblProdutoItens.clear().destroy();
            fcFormatarGrid();

           $('#exibir_grid_produto_itens').hide();
        } 
    }
    
}

$(document).ready(function()
    {
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);
         $(document).on('click', '#ic_listar_itens', fcMostrarGridProdutosItens);
        
        $("#vl_unitario").keypress(function(){
            mascara(this,moeda);
        });
        
        
        //Combo Categorias        
        fcCarregarCategorias();
        //Combo Fornecedores
        fcCarregarFornecedor("");       
        //Combo  Produtos
        fcCarregarProdutos("");
        $(".chzn-select").chosen({allow_single_deselect: true});
        //Lista fornecedor e Produtos conforme a categoria        
        $("#categorias_produto_pk").change(function(){     
            if($("#categorias_produto_pk").val()!=''){
                $(".chzn-select").chosen('destroy');
                fcCarregarFornecedor($("#categorias_produto_pk").val());
                fcCarregarProdutos($("#categorias_produto_pk").val());
                $(".chzn-select").chosen({allow_single_deselect: true});
            }            
        });
        
        
        
        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        
        
        fcFormatarGrid();
        
        $("#qtde").change(function(){
            /*if(pk!=""){
                
                tblProdutoItens.clear().destroy();
                fcFormatarGrid();
                fcAtualizarDadosGrid();
                for(i=0; i< ($("#qtde").val() - $("#qtde_registro").val());i++){
                    fcIncluirLinha();
                }
            }
            else{*/
                tblProdutoItens.clear().destroy();
                fcFormatarGrid();
                fcAtualizarDadosGrid();
                for(i=0; i< $("#qtde").val();i++){
                    fcIncluirLinha();
                }
            //}
            
        });
        
        fcCarregar();
    }
);
