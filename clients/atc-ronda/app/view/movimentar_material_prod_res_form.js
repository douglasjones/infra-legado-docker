
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}

function fcCarregarGrid(){
    
    
    var colaborador_pk = "";
    var leads_pk = "";
    
    if($("#grupo_para_movimentacao_pk").val()==1){
        var colaborador_pk = $("#movimentar_para_pesq_pk").val();
    }
    else if($("#grupo_para_movimentacao_pk").val()==2){
        var leads_pk = $("#movimentar_para_pesq_pk").val();
    }
    
    
    
    
    
    var objParametros = {
       "leads_pk": leads_pk,
       "colaborador_pk": colaborador_pk,
       "categoria_pk": $("#categoria_res_pk").val(),
       "produtos_pk": $("#produtos_res_pk").val(),
       "dt_movimentacao_ini": $("#dt_movimentacao_ini").val(),
       "dt_movimentacao_fim": $("#dt_movimentacao_fim").val(),
    };     

    var v_url = montarUrlController("conjunto_material", "listarMovimentarMaterialProd", objParametros);
    
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
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
           {"targets": -2, "data": "dt_cadastro"},           
           {"targets": -3, "data": "qtde"},           
           {"targets": -4, "data": "ds_produto"},           
           {"targets": -5, "data": "ds_categoria"},           
           {"targets": -6, "data": "ds_movimentado"},           
           {"targets": -7, "data": "ds_grupo_movimentado"},           
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
        
        rLinhaSelecionada = null;
        
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        
        fcEditarConjuntoMaterial(data);  
     
    } );   
    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_delete', function () {
         var data;
        
        rLinhaSelecionada = null;
        
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        
        fcImprimirConjuntoMaterial(data);  
     
    } );   
    
    return false;
}




function fcVerificarMovimentadoPara(){
    $("#str_opc").text("");
    if($("#grupo_para_movimentacao_pk").val()==1){
        
        $("#str_opc").text("Colaborador(es)");
        var objParametros = {
            "pk": ""
        };          
        var arrCarregar = carregarController("colaborador", "listarTodos", objParametros);    
        carregarComboAjax($("#movimentar_para_pesq_pk"), arrCarregar, " ", "pk", "ds_colaborador");  
    }
    else if($("#grupo_para_movimentacao_pk").val()==2){
        $("#str_opc").text("Posto(s) de Trabalho");
        var objParametros = {
            "pk": ""
        };          
        var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
        carregarComboAjax($("#movimentar_para_pesq_pk"), arrCarregar, " ", "pk", "ds_lead");  
    }
     
}



function fcCarregarCategorias(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);    
    carregarComboAjax($("#categoria_res_pk"), arrCarregar, " ", "pk", "ds_categoria");        
    carregarComboAjax($("#categorias_produto_pk"), arrCarregar, " ", "pk", "ds_categoria");        
}

function fcCarregarProdutos(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros);  

    carregarComboAjax($("#produtos_res_pk"), arrCarregar, " ", "pk", "ds_produto");        
    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");        
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
    $("#janela_materiais").modal();
    $("#div_dt_devolucao").show();
    $("#movimentacao_estoque_pk").val("");
    $("#acao").val("upd");
    
    //Carrega as informações da linha selecionada.
    $("#movimentacao_estoque_pk").val(objRegistro['pk']);
    $("#categorias_produto_pk").val(objRegistro['categorias_produto_pk']);
    $("#produtos_pk").val(objRegistro['produtos_pk']);
    $("#produtos_itens_pk").val(objRegistro['produtos_itens_pk']); 
    $("#dt_entrega").val(objRegistro['dt_entrega']); 
    $("#dt_devolucao").val(objRegistro['dt_devolucao']); 
    $("#obs_material").val(objRegistro['obs_material']); 
    $("input[id=ic_mateiral_carga]").prop("checked", false);
    if(objRegistro['ic_mateiral_carga']==1){
        $("input[id=ic_mateiral_carga]").prop("checked", "true");
    }
    else{
        $("input[id=ic_mateiral_carga]").prop("checked", false);
    }
    $("#qtde_materias").val(1); 
    $("#produtos_itens_pk").prop('disabled',false);
    $("#qtde_materias").prop('disabled',true);
    
    
}

//----------------------------------MODAL---------------------------------// 
    
function fcVerificarMovimentadoParaIns(){
    $("#str_opc_ins").text("");
    if($("#grupo_para_movimentacao_ins_pk").val()==1){
        
        $("#str_opc_ins").text("Colaborador(es)");
        var objParametros = {
            "pk": ""
        };          
        var arrCarregar = carregarController("colaborador", "listarTodos", objParametros);    
        carregarComboAjax($("#movimentar_para_pk"), arrCarregar, " ", "pk", "ds_colaborador");  
    }
    else if($("#grupo_para_movimentacao_ins_pk").val()==2){
        $("#str_opc_ins").text("Posto(s) de Trabalho");
        var objParametros = {
            "pk": ""
        };          
        var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
        carregarComboAjax($("#movimentar_para_pk"), arrCarregar, " ", "pk", "ds_lead");  
    }
     
}

function fcValidarFormModalMateriais(){
    $("#form_materiais").validate({
        rules :{

        },
        messages:{

        },
        submitHandler: function(form){
            fcEnviarMateriais(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}

function fcEnviarMateriais(){
    
    if($("#grupo_para_movimentacao_ins_pk").val()==""){
        alert("Por favor, selecione Grupo Para Movimentação.");
        return false;
    }
    if($("#grupo_para_movimentacao_ins_pk").val()==1){
        if($("#movimentar_para_pk").val()==""){
            alert("Por favor, selecione Colaborador.");
            return false;
        }
    }
    if($("#grupo_para_movimentacao_ins_pk").val()==2){
        if($("#movimentar_para_pk").val()==""){
            alert("Por favor, selecione Posto de Trabalho.");
            return false;
        }
    }
    
    if($("#categorias_produto_pk").val()==""){
        alert("Por favor, selecione a Categoria.");
        return false;
    }
    if($("#produtos_pk").val()==""){
        alert("Por favor, selecione o Produto.");
        return false;
    }
    if($("#qtde_materias").val()=="" || $("#qtde_materias").val()==0){
        if($("#produtos_itens_pk").val()==""){
            alert("Por favor,  selecione o Material.");
            return false;
        }
    }
    if($("#produtos_itens_pk").val()==""){
        if($("#qtde_materias").val()=="" || $("#qtde_materias").val()== 0){
            alert("Por favor, Informe a Quantidade.");
            return false;
        }
        
    }
    
    if($("#qtde_materias").val()>0){
        if($("#qtde_materias").val()> $("#count_material").val()){
            alert("Quantidade disponível em estoque inferior. Quantidade disponivel "+$("#count_material").val());
            return false;
        }
    }
    
    if($("#dt_entrega").val()==""){
        alert("Por favor, informe a data de entrega.");
        return false;
    }
    
    
       
    fcSalvarMateriais();
    $("#janela_materiais").modal("hide");
    
   
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
    var v_obs_material = $("#obs_material").val();  
    
    
    
    if($("#ic_mateiral_carga").is(":checked") == true){
        var ds_ic_mateiral_carga = "Sim";
        var ic_mateiral_carga = 1;
    }
    else{
        var ds_ic_mateiral_carga = "Não";
        var ic_mateiral_carga = 2;
    }
    

    var colaborador_pk = "";
    var leads_pk = "";
    
    if($("#grupo_para_movimentacao_ins_pk").val()==1){
        var colaborador_pk = $("#movimentar_para_pk").val();
    }
    else if($("#grupo_para_movimentacao_ins_pk").val()==2){
        var leads_pk = $("#movimentar_para_pk").val();
    }
    
    
    if($("#qtde_materias").val()>0){
        
        var  data = tblResultado.rows().data();
        var strProdutoGrid = "";
       if(data.length > 0){
           strProdutoGrid += "not in ("
           for(i = 0; i< data.length; i++){
                strProdutoGrid += data[i]['produtos_itens_pk'] + ",";    

           }
           strProdutoGrid += "0)";
       }
        
        
        
        
        
        var objParametros1 = {
            "produtos_pk": $("#produtos_pk").val(),
            "qtde":$("#qtde_materias").val(),
            "strProdutoGrid":strProdutoGrid
        };          
        var arrCarregar1 = carregarController("produto_iten", "listarPorProdutosQtde", objParametros1); 
        
        if(arrCarregar1.data.length > 0){
            if($("#qtde_materias").val()> arrCarregar1.data.length){
                alert("Só existem "+arrCarregar1.data.length+" unidades desse produto.");
                $("#janela_materiais").modal("show");
                return false;
            }
            for(i=0;i<arrCarregar1.data.length;i++){
                
                var objParametros = {
                    "pk": v_movimentacao_estoque_pk,
                    "produtos_itens_pk": arrCarregar1.data[i]['pk'],
                    "dt_entrega": v_dt_entrega,
                    "dt_devolucao": v_dt_devolucao,
                    "obs_material": (v_obs_material),
                    "ic_mateiral_carga": (ic_mateiral_carga),
                    "leads_pk": leads_pk,
                    "colaborador_pk": colaborador_pk
                };    

                var arrEnviar = carregarController("movimentacao_estoque", "salvar", objParametros); 

                if (arrEnviar.result == 'success'){
                    // Reload datable
                    
                }
                else{
                    alert('Falhou a requisição para salvar o registro');
                }
            } 
        }       
    }
    else{
         var objParametros = {
                "pk": v_movimentacao_estoque_pk,
                "produtos_itens_pk": v_produtos_itens_pk,
                "dt_entrega": v_dt_entrega,
                "dt_devolucao": v_dt_devolucao,
                "ic_mateiral_carga": ic_mateiral_carga,
                "obs_material": (v_obs_material),
                "leads_pk": leads_pk,
                "colaborador_pk": colaborador_pk
            };    

            var arrEnviar = carregarController("movimentacao_estoque", "salvar", objParametros); 
            
            if (arrEnviar.result == 'success'){
                // Reload datable

            }
            else{
                alert('Falhou a requisição para salvar o registro');
            }
    }
    
    alert("Registro salvo com sucesso.");
    fcRecarregarGridMateriais();

    
}
function fcRecarregarGridMateriais(){
    tblResultado.clear().destroy();    
    fcCarregarGrid();
}


function fcAbrirFormNovoMaterial(){
    $(".chzn-select").chosen('destroy');
        
    fcCarregarProdutosItens("","");
    

    //limpa os dados de qualquer registro existe
    fcLimparFormMaterial();
    $("#produtos_itens_pk").prop('disabled',false);
   
    
    
    $("#janela_materiais").modal();
    setTimeout(function(){ $(".chzn-select").chosen({allow_single_deselect: true}); }, 1000);
   
    
    $("#acao").val("ins");
}

function  fcLimparFormMaterial(){
    $("#acao").val("");
    $("#categorias_produto_pk").val("");
    $("#grupo_para_movimentacao_ins_pk").val("");
    $("#str_opc_ins").text("");
    $("#movimentar_para_pk").val("");
    $("#produtos_pk").val("");
    $("#produtos_itens_pk").val("");
    $("#dt_entrega").val("");
    $("#obs_material").val("");      
    $("#dt_devolucao").val("");      
    $("#qtde_materias").val("");      
}


function fcCarregarProdutos(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros);  

    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");        
}


function pegarPkProdutosItensNotIn(produtos_itens_pk_res){
    try{
        var produtos_itens_pk = "";
        
        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "produtos_itens_pk";
        
        var  data = tblResultado.rows().data();
        
        for(i = 0; i< data.length; i++){
            if(produtos_itens_pk_res!=data[i]['produtos_itens_pk']){
                produtos_itens_pk = data[i]['produtos_itens_pk'];  
                arrDados[i] = [produtos_itens_pk];      
            }
                                
                             
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}
function fcCarregarProdutosItens(produtos_pk,produtos_itens_pk){   
    
    //var strProdGrid = pegarPkProdutosItensNotIn(produtos_itens_pk);

    var objParametros = {
        "produtos_pk": produtos_pk,
        //"leads_pk":leads_pk,
        "produtos_itens_pk":produtos_itens_pk
        //"strProdutoGrid":strProdGrid
    };     
    
    var arrCarregar = carregarController("produto_iten", "listarPorPkProdutoNotIn", objParametros);    
   
    carregarComboAjax($("#produtos_itens_pk"), arrCarregar, " ", "pk", "ds_produto_item"); 
    
    $("#count_material").val(arrCarregar.data.length);
}

$(document).ready(function(){

    $(".chzn-select").chosen('destroy');
    
    
    
    fcCarregarCategorias("");
    //Produtos
    fcCarregarProdutos("");
    
       
    $("#categorias_produto_pk").change(function(){  
        $(".chzn-select").chosen('destroy');
    
        fcCarregarProdutos($("#categorias_produto_pk").val());
        $(".chzn-select").chosen({allow_single_deselect: true});
    }); 
    
    fcCarregarGrid();
    
     
    
    $(".chzn-select").chosen({allow_single_deselect: true});
    
    $("#grupo_para_movimentacao_pk").change(function(){
        if($("#grupo_para_movimentacao_pk").val()==1){
            $(".chzn-select").chosen('destroy');
            fcVerificarMovimentadoPara();
            $(".chzn-select").chosen({allow_single_deselect: true});
        }
        else if($("#grupo_para_movimentacao_pk").val()==2){
            $(".chzn-select").chosen('destroy');
            fcVerificarMovimentadoPara();
            $(".chzn-select").chosen({allow_single_deselect: true});
            
        }
        
    });
    
    
    $("#dt_movimentacao_ini").on('keyup', function () {
        mascara(this,mdata);       
    });
    $("#dt_movimentacao_fim").on('keyup', function () {
        mascara(this,mdata);       
    });
   
    
    $('#dt_movimentacao_ini').datepicker({defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $('#dt_movimentacao_fim').datepicker({defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
  
  
  
  
  
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcAbrirFormNovoMaterial);
  
  //------------------------MODAL------------------------------//
  
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
    $("#produtos_itens_pk").change(function(){        
       if($("#produtos_itens_pk").val()!=""){
           $("#qtde_materias").prop('disabled',true);
           $("#qtde_materias").val("");
       }
       else{
           $("#qtde_materias").prop('disabled',false);
       }
        
    });
    
    $("#qtde_materias").keypress(function(){
       mascara(this,soNumeros);
    });
    
    $("#qtde_materias").change(function(){  
        if($("#qtde_materias").val()!=""){
            if($("#qtde_materias").val() > 0){
                $("#produtos_itens_pk").prop('disabled',true);
                $("#produtos_itens_pk").val("");
            }
            else{
                $("#produtos_itens_pk").prop('disabled',false);
            }
        }
        else{
            $("#produtos_itens_pk").prop('disabled',false);
        }
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
    
    $("#grupo_para_movimentacao_ins_pk").change(function(){
        if($("#grupo_para_movimentacao_ins_pk").val()==1){
            $(".chzn-select").chosen('destroy');
            fcVerificarMovimentadoParaIns();
            $(".chzn-select").chosen({allow_single_deselect: true});
        }
        else if($("#grupo_para_movimentacao_ins_pk").val()==2){
            $(".chzn-select").chosen('destroy');
            fcVerificarMovimentadoParaIns();
            $(".chzn-select").chosen({allow_single_deselect: true});
            
        }
        
    });
    
    //Atribui a validação do formulário dos campos obrigatórios
    fcValidarFormModalMateriais();
  

});


