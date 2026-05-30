var tblMaterial;
function fcCarregarGridConjuntoMateriais(){
    
    var objParametros = {
       "leads_pk": leads_pk,
       "colaborador_pk": colaborador_pk,
    };     

    var v_url = montarUrlController("conjunto_material", "listarColaboradorPk", objParametros);
    
    //Trata a tabela
    tblConjuntoMaterial = $('#tblConjuntoMaterial').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": true,
        "paging": true,
        "bFilter": true,
        "bInfo": false, 
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/impressora.png'></span></a>"
            },
           {"targets": -2, "data": "ds_conjunto_material"},           
           {"targets": -3, "data": "pk"}, 
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });   
    
    //Atribui os eventos na coluna ação.
    $('#tblConjuntoMaterial tbody').on('click', '.function_edit', function () {
         var data;
        
        rLinhaSelecionada = null;
        
        if(tblConjuntoMaterial.row( $(this).parents('li')).data()){
            data = tblConjuntoMaterial.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblConjuntoMaterial.row( $(this).parents('tr')).data()){
            data = tblConjuntoMaterial.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        
        fcEditarConjuntoMaterial(data);  
     
    } );   
    //Atribui os eventos na coluna ação.
    $('#tblConjuntoMaterial tbody').on('click', '.function_delete', function () {
         var data;
        
        rLinhaSelecionada = null;
        
        if(tblConjuntoMaterial.row( $(this).parents('li')).data()){
            data = tblConjuntoMaterial.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblConjuntoMaterial.row( $(this).parents('tr')).data()){
            data = tblConjuntoMaterial.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        
        fcImprimirConjuntoMaterial(data);  
     
    } );   
    
    return false;
}

function fcImprimirConjuntoMaterial(objRegistro){

   sendPost('impressao_material.php',{token: token, pk: objRegistro['colaborador_pk'],leads_pk:leads_pk,conjunto_material_pk:objRegistro['pk'],ds_colaborador:$("#ds_colaborador").val(),ds_re:$("#ds_re").val(),ds_secao:$("#ds_secao").val(),dt_admissao:$("#dt_admissao").val(),dt_demissao:$("#dt_demissao").val()});
}

function fcCarregarGridMateriais(){
    
    var objParametros = {
       "leads_pk": leads_pk,
       "colaborador_pk": colaborador_pk,
       "conjunto_material_pk":$("#conjunto_material_pk").val()
    };     

    var v_url = montarUrlController("movimentacao_estoque", "listar_por_pk_conjunto", objParametros);
    
    //Trata a tabela
    tblMaterial = $('#tblMaterial').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": true,
        "paging": true,
        "bFilter": true,
        "bInfo": false, 
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "obs_material"}, 
           {"targets": -3, "data": "dt_devolucao"}, 
           {"targets": -4, "data": "dt_entrega"},
           {"targets": -5, "data": "produtos_itens_pk",visible:false}, 
           {"targets": -6, "data": "ds_produtos_itens"},   
           {"targets": -7, "data": "produtos_pk",visible:false},
           {"targets": -8, "data": "ds_produtos"},
           {"targets": -9, "data": "categorias_produto_pk",visible:false}, 
           {"targets": -10, "data": "ds_categorias_produto"},           
           {"targets": -11, "data": "pk"}, 
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });   
    
    //Atribui os eventos na coluna ação.
    $('#tblMaterial tbody').on('click', '.function_edit', function () {
         var data;
        
        rLinhaSelecionadaMaterial = null;
        
        if(tblMaterial.row( $(this).parents('li')).data()){
            data = tblMaterial.row( $(this).parents('li')).data();
            rLinhaSelecionadaMaterial = $(this).parents('li');
        }
        else if(tblMaterial.row( $(this).parents('tr')).data()){
            data = tblMaterial.row( $(this).parents('tr')).data();
            rLinhaSelecionadaMaterial = $(this).parents('tr');
        }
        
        fcEditarMaterial(data);
     
    } );   
    
    
    $('#tblMaterial tbody').on('click', '.function_painel', function () {
         var data;
        
        rLinhaSelecionadaMaterial = null;
        
        if(tblMaterial.row( $(this).parents('li')).data()){
            data = tblMaterial.row( $(this).parents('li')).data();
            rLinhaSelecionadaMaterial = $(this).parents('li');
        }
        else if(tblMaterial.row( $(this).parents('tr')).data()){
            data = tblMaterial.row( $(this).parents('tr')).data();
            rLinhaSelecionadaMaterial = $(this).parents('tr');
        }
        if(data['pk'] != ""){
            fcExcluirMaterial(data['pk']);
        }
        tblMaterial.row($(this).parents('tr')).remove().draw();
        
        
        
    } ); 
    
    
    
    return false;
}

function fcExcluirMaterial(v_pk){

    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("movimentacao_estoque", "excluir", objParametros);   
       
        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            fcRecarregarGridMateriais();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}
function fcEditarMaterial(objRegistro){

    fcLimparFormMaterial();
    fcCarregarProdutosItens(objRegistro['produtos_pk'],objRegistro['produtos_itens_pk']);
    $("#movimentacao_estoque_pk").val("");
    $("#acao").val("upd");
    if(objRegistro['pk']){
         $("#div_dt_devolucao").show();
    }
    //Carrega as informações da linha selecionada.
    $("#movimentacao_estoque_pk").val(objRegistro['pk']);
    $("#categorias_produto_pk").val(objRegistro['categorias_produto_pk']);
    $("#produtos_pk").val(objRegistro['produtos_pk']);
    $("#produtos_itens_pk").val(objRegistro['produtos_itens_pk']); 
    $("#dt_entrega").val(objRegistro['dt_entrega']); 
    $("#dt_devolucao").val(objRegistro['dt_devolucao']); 
    $("#observacao_material").val(objRegistro['obs_material']); 
    
    
}

function fcEditarConjuntoMaterial(objRegistro){

    $("#janela_materiais").modal();
    
    
     fcCarregarCategorias("");
     
    $(".chzn-select").chosen('destroy');
    
    
    //Produtos
    fcCarregarProdutos("");
    fcCarregarProdutosItens("","");
    
    $("#ds_conjunto_material").val("");
    $("#conjunto_material_pk").val("");
    $("#movimentacao_estoque_pk").val("");
    $("#categorias_produto_pk").val("");
    $("#produtos_pk").val("");
    $("#produtos_itens_pk").val(""); 
    $("#dt_entrega").val(""); 
    $("#dt_devolucao").val(""); 
    $("#observacao_material").val(""); 
    $("#conjunto_material_pk").val(objRegistro['pk']);
    $("#ds_conjunto_material").val(objRegistro['ds_conjunto_material']);
    
    $(".chzn-select").chosen({allow_single_deselect: true});
    
    tblMaterial.clear().destroy();    
    fcCarregarGridMateriais();
        
}

function fcValidarFormModalMateriais(){
    $("#form_materiais").validate({
        rules :{
            ds_conjunto_material:{
                required:true
            }
        },
        messages:{
            ds_conjunto_material:{
                required:"Por favor, informe Descrição Conjunto Material"
            }
        },
        submitHandler: function(form){
            fcEnviarConjuntoMateriais(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}

function fcEnviarConjuntoMateriais(){
    fcSalvarConjuntoMateriais();
}

function fcValidarMaterial(){
    if($('#categorias_produto_pk').val()==""){
        $("#alert_categoria").show();
        $("#alert_categoria").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_categoria").slideUp(500);
        });
        $('#categorias_produto_pk').focus();
        return false;
    }
    if($('#produtos_pk').val()==""){
        $("#alert_produto").show();
        $("#alert_produto").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_produto").slideUp(500);
        });
        $('#produtos_pk').focus();
        return false;
    }
    if($('#produtos_itens_pk').val()==""){
        $("#alert_produtos_itens_pk").show();
        $("#alert_produtos_itens_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_produtos_itens_pk").slideUp(500);
        });
        $('#produtos_itens_pk').focus();
        return false;
    }
    if($('#dt_entrega').val()==""){
        $("#alert_dt_entrega").show();
        $("#alert_dt_entrega").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_entrega").slideUp(500);
        });
        $('#dt_entrega').focus();
        return false;
    }
    return true;
}
function fcIncluirMateriais(){
    if($("#conjunto_material_pk").val() == ""){
       if($("#acao").val() == "ins"){
           if(fcValidarMaterial()){
               fcIncluirMateriaisSemPk();
              fcLimparFormMaterial();
           }
       }
       else if($("#acao").val() == "upd"){
           if(fcValidarMaterial()){
               fcEditarMateriaisSemPk();
               fcLimparFormMaterial();
           }
       }
   }
   else{
       if(fcValidarMaterial()){
          fcSalvarMateriais();
        }
       
   }   
   
}

function fcSalvarMateriais(){   
    
    var v_movimentacao_estoque_pk = $("#movimentacao_estoque_pk").val();
    var v_produtos_itens_pk = $("#produtos_itens_pk").val();    
    var v_dt_entrega = $("#dt_entrega").val();
    if($("#movimentacao_estoque_pk").val()!=""){
        var v_dt_devolucao = $("#dt_devolucao").val();
    }else{
        var v_dt_devolucao = "";
    }
    var v_obs_material = $("#observacao_material").val();   

    


    
    var v_leads_pk = leads_pk; 
    var v_colaborador_pk = colaborador_pk;   

    var objParametros = {
        "pk": v_movimentacao_estoque_pk,
        "produtos_itens_pk": encodeURIComponent(v_produtos_itens_pk),
        "dt_entrega": v_dt_entrega,
        "dt_devolucao": v_dt_devolucao,
        "obs_material": (v_obs_material),
        "leads_pk": v_leads_pk,
        "colaborador_pk": v_colaborador_pk,
        "conjunto_material_pk":$("#conjunto_material_pk").val()
    };    

    var arrEnviar = carregarController("movimentacao_estoque", "salvar", objParametros); 
    
    if (arrEnviar.result == 'success'){
        // Reload datable
        //alert(arrEnviar.message);
        fcLimparFormMaterial();
        fcRecarregarGridMateriais();
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcEditarMateriaisSemPk(){
    fcIncluirMateriaisSemPk();
    tblMaterial.row(rLinhaSelecionadaMaterial).remove().draw();
    return false;
}

function fcIncluirMateriaisSemPk(){ 
    
    tblMaterial.row.add(        
        {            
            "pk":"",
            "ds_categorias_produto":$("#categorias_produto_pk option:selected").text(),
            "categorias_produto_pk":$("#categorias_produto_pk option:selected").val(),
            "ds_produtos":$("#produtos_pk option:selected").text(),
            "produtos_pk":$("#produtos_pk option:selected").val(),
            "ds_produtos_itens":$("#produtos_itens_pk option:selected").text(),
            "produtos_itens_pk":$("#produtos_itens_pk option:selected").val(),
            "dt_entrega":$("#dt_entrega").val(),
            "dt_devolucao":"",
            "obs_material":$("#observacao_material").val(),
            "t_functions":""
        }
    ).draw();    
    return false;
}


function fcSalvarConjuntoMateriais(){   
    
    //Esta função está em colaborador_cad_form.js
    var strJSONDadosMateriais = fcFormatarDadosMateriais();
    var  data = tblMaterial.rows().data();
    if(data.length==0){
        alert("Por favor, Incluir um Material");
         return false;
    }
   

    var v_colaborador_pk = colaborador_pk;   
    var v_ds_conjunto_material = $("#ds_conjunto_material").val();   

    var objParametros = {
        "pk": $("#conjunto_material_pk").val(),
        "ds_conjunto_material":v_ds_conjunto_material,
        "colaborador_pk": v_colaborador_pk,
        "materiais_pk":strJSONDadosMateriais
    };    

    var arrEnviar = carregarController("conjunto_material", "salvar", objParametros); 
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        $("#janela_materiais").modal("hide");
        fcRecarregarGridConjuntoMateriais();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}
function fcRecarregarGridMateriais(){
    tblMaterial.clear().destroy();    
    fcCarregarGridMateriais();
}
function fcRecarregarGridConjuntoMateriais(){
    tblConjuntoMaterial.clear().destroy();    
    fcCarregarGridConjuntoMateriais();
}

function fcCarregarMateriais(){
    if(colaborador_pk > 0){

        var objParametros = {
            "pk": colaborador_pk
        };        
        
        var arrCarregar = carregarController("colaboradores_materiais", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#tipo_material_pk").val(arrCarregar.data[0]['tipo_material_pk']);
            $("#material_pk").val(arrCarregar.data[0]['material_pk']);
            $("#qtde_material").val(arrCarregar.data[0]['qtde_material']);
            $("#dt_entrega").val(arrCarregar.data[0]['dt_entrega']);
            $("#dt_devolucao").val(arrCarregar.data[0]['dt_devolucao']);
            $("#obs").val(arrCarregar.data[0]['obs']);
            $("#colaborador_pk").val(arrCarregar.data[0]['colaborador_pk']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcAbrirFormNovoMaterial(){
    
    
    
    //limpa os dados de qualquer registro existe
    fcLimparFormMaterial();
    //$("#conjunto_material_pk").val("");
    $("#ds_conjunto_material").val("");
    $("#janela_materiais").modal();
    tblMaterial.clear().destroy();    
    fcCarregarGridMateriais();
    $("#acao").val("ins");
    
    $(".chzn-select").chosen('destroy');
    fcCarregarProdutos("");
    fcCarregarProdutosItens("","");
    $(".chzn-select").chosen({allow_single_deselect: true});
}

function  fcLimparFormMaterial(){
    //$("#acao").val("");
    $("#categorias_produto_pk").val("");
    $("#produtos_pk").val("");
    $("#produtos_itens_pk").val("");
    $("#dt_entrega").val("");
    $("#observacao_material").val("");      
    $("#dt_devolucao").val("");      
    //$("#ds_conjunto_material").val("");      
}

function fcCarregarCategorias(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);    
    carregarComboAjax($("#categorias_produto_pk"), arrCarregar, " ", "pk", "ds_categoria");        
}

function fcCarregarProdutos(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros);  

    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");        
}

function fcCarregarProdutosItens(produtos_pk,produtos_itens_pk){   
    
     var  data = tblMaterial.rows().data();
     var strProdutoGrid = "";
    if(data.length > 0){
        strProdutoGrid += "not in ("
        for(i = 0; i< data.length; i++){
            if(produtos_itens_pk!=data[i]['produtos_itens_pk']){
                strProdutoGrid += data[i]['produtos_itens_pk'] + ",";    
            }
                            
        }
        strProdutoGrid += "0)";
    }    
    
    var objParametros = {
        "produtos_pk": produtos_pk,
        "leads_pk":"",
        "produtos_itens_pk":produtos_itens_pk,
        "strProdutoGrid":strProdutoGrid
    };     
    
    var arrCarregar = carregarController("produto_iten", "listarPorPkProduto", objParametros);    
    
    carregarComboAjax($("#produtos_itens_pk"), arrCarregar, " ", "pk", "ds_produto_item");     
}


$(document).ready(function(){
    
   //Atribui os eventos
    //$(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdIncluirConjuntoMaterial', fcAbrirFormNovoMaterial); 
    $(document).on('click', '#cmdIncluirMaterial', fcIncluirMateriais); 
    
    fcCarregarGridConjuntoMateriais();
    fcCarregarGridMateriais();
    
     //Categorias
    fcCarregarCategorias("");
    //Produtos
    fcCarregarProdutos("");
    fcCarregarProdutosItens("","");
       
    $("#categorias_produto_pk").change(function(){  
        $(".chzn-select").chosen('destroy');
    
        fcCarregarProdutos($("#categorias_produto_pk").val());
        $(".chzn-select").chosen({allow_single_deselect: true});
    });   
    
    //Seleciona o produto
    $("#produtos_pk").change(function(){  
       
       //Itens Material
       $(".chzn-select").chosen('destroy');
        fcCarregarProdutosItens($("#produtos_pk").val(),"");  
        $(".chzn-select").chosen({allow_single_deselect: true});
    });

    $('#dt_entrega').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#dt_entrega").keypress(function(){
       mascara(this,mdata);
    });
    $("#dt_entrega").keypress(function(){
       mascara(this,horamask);
    });

    $('#dt_devolucao').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#dt_devolucao").keypress(function(){
       mascara(this,mdata);
    });
    $("#dt_devolucao").keypress(function(){
       mascara(this,horamask);
    });
    
  
    
    //Atribui a validação do formulário dos campos obrigatórios
    fcValidarFormModalMateriais();
    
    
});
