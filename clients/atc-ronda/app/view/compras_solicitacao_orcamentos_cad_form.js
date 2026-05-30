var tblProdutosItens;
function fcEnviar(){
    try {
        //validação de campos
    var v_vl_toral = new Number(0);        
     var  data = tblProdutosItens.rows().data(); 
     if(data.length==0){
        alert('Inclua ao menos um Produto / Item para salvar o orçamento!'); 
        return false; 
     }
 
     for(i = 0; i< data.length; i++){//calcula o valor total
        var vl_item = data[i]['vl_unitario'].replace(',','.');
        v_vl_toral +=(vl_item * data[i]['qtde_produto']) 
     }
     
     var v_fornecedor_pk = $("#fornecedor_pk").val();
     var v_dt_pevisao_entrega = $("#dt_pevisao_entrega").val();
     var v_vl_frete = $("#vl_frete").val().replace(',','.');
     var v_vl_total = v_vl_toral;
     var v_obs_orcamento = $("#obs_orcamento").val();
     var v_compra_solicitacao_pk = "";
     var v_obs_aprovacao= $("#obs_aprovacao").val();
     if(compra_solicitacao_pk > 0){
         v_compra_solicitacao_pk = compra_solicitacao_pk;
     }
    
     if(usuario_aprovacao_pk > 0){       
         if($("#ic_status_orcamento").val()==2){
             var resultado = confirm("Todos os dados do Orçamento foram conferidos, estão corretos ? Deseja realmente aprovar este Orçamento ?");
             if (resultado == false) {
                 return false;
             }
         }              
         var v_ic_status = $("#ic_status_orcamento").val(); 
         var v_ds_status = $("#ic_status_orcamento option:selected").text() 
         $("#dt_aprovacao").val("sysdate()");
         $("#obs_aprovacao").val($("#obs_aprovacao_orcamento").val());   
         $("#ic_status").val($("#ic_status_orcamento").val());  
     }else{
         var v_ic_status = 1; 
         var v_ds_status = "Em Analise"; 
         $("#ic_status").val(1);
     }
 
     var objParametros = {
         "pk": pk,
         "fornecedor_pk": (v_fornecedor_pk),
         "dt_pevisao_entrega": (v_dt_pevisao_entrega),
         "vl_frete": float2moeda(v_vl_frete),
         "vl_total": float2moeda(v_vl_total),
         "obs_orcamento": (v_obs_orcamento),
         "ic_status": (v_ic_status),
         "obs_aprovacao": (v_obs_aprovacao),
         "compra_solicitacao_pk": (v_compra_solicitacao_pk)        
     };    
 
     var arrEnviar = carregarController("compras_solicitacao_orcamentos", "salvar", objParametros); 
    // NewWindow(v_last_url) 
     if (arrEnviar.result == 'success'){
         if(arrEnviar.data[0]['pk'] > 0){ //Excluir Itens
             var objParametros01 = { 
                 "compras_solicitacao_orcamentos_pk": arrEnviar.data[0]['pk']          
             };    
             var arrEnviarItens0 = carregarController("compras_solicitacao_orcamento_itens", "excluirPorSolicitacaoOrcamento", objParametros01);  
         }
 
         //cadastra os itens dos produtos
         var  data1 = tblProdutosItens.rows().data();    
         
         for(j = 0; j< data1.length; j++){       
             var vl_item_li = data[j]['vl_unitario'].replace(',','.');                        
             var objParametros0 = {       
                 "categorias_produto_pk": data1[j]['categorias_produto_pk'],
                 "produtos_pk": data1[j]['produtos_pk'],
                 "ds_produto": data1[j]['ds_produto'],
                 "qtde_produto": data1[j]['qtde_produto'],
                 "vl_unitario": float2moeda(vl_item_li),
                 "compras_solicitacao_orcamentos_pk": arrEnviar.data[0]['pk']        
             };    
             var arrEnviarItens = carregarController("compras_solicitacao_orcamento_itens", "salvar", objParametros0); 
             //NewWindow(v_last_url)        
         }
         sendPost("compras_solicitacao_cad_form.php", {token: token, compra_solicitacao_pk: compra_solicitacao_pk});
    
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
} catch (error) {
    alert(error)   
   }
}

function fcCarregar(){
    if(pk > 0){
        var objParametros = {
            "pk": pk
        };       
        
        var arrCarregar = carregarController("compras_solicitacao_orcamentos", "listarPk", objParametros);
        if (arrCarregar.result == 'success'){        
            $("#fornecedor_pk").val(arrCarregar.data[0]['fornecedor_pk']);
            $("#dt_pevisao_entrega").val(arrCarregar.data[0]['dt_pevisao_entrega']);
            $("#vl_frete").val(arrCarregar.data[0]['vl_frete']);
            $("#vl_total").val(arrCarregar.data[0]['vl_total']);
            $("#obs_orcamento").val(arrCarregar.data[0]['obs_orcamento']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
            $("#compra_solicitacao_pk").val(arrCarregar.data[0]['compra_solicitacao_pk']);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

//COMBOS
function  fcComboFornecedor(){
    var objParametros = {
    };       
    var arrCarregar = carregarController("fornecedor", "listarTodos", objParametros)
    carregarComboAjax($("#fornecedor_pk"), arrCarregar, " ", "pk", "ds_fornecedor");
}

function fcComboCategoriasProduto(){
    var arrCarregar = carregarController("categoria_produto", "listarTodos", '')
    carregarComboAjax($("#categorias_produto_pk"), arrCarregar, " ", "pk", "ds_categoria");
}

function fcComboProdutos(categoria_pk){
    var objParametros = {
        "categorias_produto_pk":categoria_pk
    };       
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros)

    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");
}

//Inclusoes e grids
function fcGridItensProduto(){
    try {
    
        var objParametros = {
            "compras_solicitacao_orcamentos_pk": pk
        };     
    
        var v_url = montarUrlController("compras_solicitacao_orcamento_itens", "listarItensOrcamentoPk", objParametros);
        //NewWindow(v_url)
        //Trata a tabela
        tblProdutosItens = $('#tblProdutosItens').DataTable({
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
                    "defaultContent": "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
                },
                {"targets": -2, "data": "vl_unitario"},       
                {"targets": -3, "data": "qtde_produto"},
                {"targets": -4, "data": "ds_produto"},
                //{"targets": -5, "data": "produtos_pk",visible:false},
                {"targets": -5, "data": "ds_categoria"},
                {"targets": -6, "data": "categorias_produto_pk",visible:false},
                {"targets": -7, "data": "pk"}
                ],
            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
                }
        });    
        $('#tblProdutosItens tbody').on('click', '.function_delete', function () {
            var data;
    
            if(tblProdutosItens.row( $(this).parents('li') ).data()){
                data = tblProdutosItens.row( $(this).parents('li') ).data();
            } else if(tblProdutosItens.row( $(this).parents('tr') ).data()){
                data = tblProdutosItens.row( $(this).parents('tr') ).data();
            }
            
            tblProdutosItens.row($(this).parents('tr')).remove().draw();
            //fcExcluir(data['pk']);
        } );   
        
    } catch (error) {
        alert(error)
    }
    
    
}

function excluirlinhatabela(){
    tblProdutosItens.row($(this).parents('tr')).remove().draw();
}

function fcIncluirItem(){
    if($("#categorias_produto_pk").val()==""){
        $("#alert_categorias_produto_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_fornecedor").slideUp(500);
        });
        $('#categorias_produto_pk').focus();
        return false;
    }

    if($("#produtos_pk").val()==""){
        $("#alert_produtos_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_produtos_pk").slideUp(500);
        });
        $('#produtos_pk').focus();
        return false;
    }
    
    if($("#qtde_produto").val()==""){
        $("#alert_qtde_produto").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_qtde_produto").slideUp(500);
        });
        $('#qtde_produto').focus();
        return false;
    }
    
    if($("#vl_item_produto").val()==""){
        $("#alert_vl_item_produto").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_vl_item_produto").slideUp(500);
        });
        $('#vl_item_produto').focus();
        return false;
    }
    
    tblProdutosItens.row.add(
        {
            "pk":"",
            "categorias_produto_pk": $("#categorias_produto_pk").val(),
            "ds_categoria":$("#categorias_produto_pk option:selected").text().substring(0,15),
            "produtos_pk":$("#produtos_pk").val(),
            //"ds_produto":$("#ds_produto").val(),
            "ds_produto":$("#produtos_pk option:selected").text().substring(0,15),
            "qtde_produto":$("#qtde_produto").val(),
            "vl_unitario":$("#vl_item_produto").val(),
            
            "t_functions":""
        }
    ).draw();   
    
    $("#categorias_produto_pk").val('');
    $("#produtos_pk").val('');
    //$("#ds_produto").val('');
    $("#qtde_produto").val('');
    $("#vl_item_produto").val('');
    
    return false;    
}

$(document).ready(function(){
    //combos                    
    fcComboFornecedor(); 
    fcComboCategoriasProduto();      
    $("#categorias_produto_pk").change(function(){ 
        //$(".chzn-select").chosen('destroy');
        fcComboProdutos($("#categorias_produto_pk").val())//combo de centros de custo  
    });
    //Grids
    fcGridItensProduto()
    
    //mascaras de campos
    $('#dt_pevisao_entrega').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate",  );
    
    $("#vl_frete").keypress(function(){
       mascara(this,moeda);
    });   
    
    $("#dt_pevisao_entrega").keypress(function(){
       mascara(this,mdata);
    });   
    
    $("#qtde_produto").on('keyup', function () {        
        mascara(this,soNumeros);       
    });
     
    //Incluir Produtos e itens
    $(document).on('click', '#cmdIncluirItem', fcIncluirItem);
    
    //Atribui os eventos
    $(document).on('click', '#cmdEnviarOrcamento', fcEnviar);
    $(document).on('click', '#cmdAddProduto', fcAbrirModalAdicionarProduto);

    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregar();
   
    $(".chzn-select").chosen('destroy'); 
    
   /* //careega campos
    $("#acao").val("upd");        
    $("#compras_solicitacao_orcamentos_pk").val(objRegistro['t_compras_solicitacao_orcamentos_pk']);    
    $("#fornecedor_pk").val(objRegistro['t_fornecedor_pk']);
    $("#dt_pevisao_entrega").val(objRegistro['t_dt_pevisao_entrega']);
    $("#vl_frete").val(objRegistro['t_vl_frete']);
    $("#obs_orcamento").val(objRegistro['t_obs_orcamento']);*/

          
    if(usuario_aprovacao_pk > 0){//libera a aprovação do orçamento    
       $("#div_titulo_aprovacao").show();
       $("#div_aprovacao_status").show();
       $("#div_aprovacao_obs").show(); 
       //desabilita os campos       

       $("#fornecedor_pk").prop("disabled", true);
       $("#dt_pevisao_entrega").prop("disabled", true);
       $("#vl_frete").prop("disabled", true);
       $("#obs_orcamento").prop("disabled", true);
       $("#div_incluir_item").hide();
       $("#div_incluir_produto").hide();
       
       $("#obs_aprovacao_orcamento").val('');
       $(".chzn-select").chosen('destroy'); 
       $("#ic_status_orcamento").val('');
    }else{
       $("#div_titulo_arovacao").hide();
       $("#div_aprovacao_status").hide();
       $("#div_aprovacao_obs").hide(); 
       $("#div_incluir_item").show();
       $("#div_incluir_produto").show();
    }                
          
    $("#tblProdutosItens").dataTable().fnDestroy();//destroi o grid
    fcGridItensProduto();//recarrega o grid
     
});
