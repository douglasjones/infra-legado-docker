var tblMaterial;




function fcCarregarGridMateriais(){
    if(leads_pk!=""){
        var objParametros = {
            "leads_pk": leads_pk
         };
    }
    else{
        var objParametros = {
            "leads_pk": leads_pk,
            "colaborador_pk": colaborador_pk
         };
    }
         

    var v_url = montarUrlController("movimentacao_estoque", "listar_por_pk", objParametros);
   
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
           {"targets": -2, "data": "ds_ic_mateiral_carga"}, 
           {"targets": -3, "data": "ic_mateiral_carga",visible:false}, 
           {"targets": -4, "data": "obs_material"}, 
           {"targets": -5, "data": "dt_devolucao"}, 
           {"targets": -6, "data": "dt_entrega"},
           {"targets": -7, "data": "produtos_itens_pk",visible:false}, 
           {"targets": -8, "data": "ds_produtos_itens"},   
           {"targets": -9, "data": "produtos_pk",visible:false},
           {"targets": -10, "data": "ds_produtos"},
           {"targets": -11, "data": "categorias_produto_pk",visible:false}, 
           {"targets": -12, "data": "ds_categorias_produto"},           
           {"targets": -13, "data": "pk"}, 
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

function fcValidarFormModalMateriais(){
    $("#form_materiais").validate({
        rules :{
            /*categorias_produto_pk:{
                required:true
            },
            produtos_pk:{
                required:true
            },
            produtos_itens_pk:{
                required:true
            },            
            dt_entrega:{
                required:true
            }*/
        },
        messages:{
            /*categorias_produto_pk:{
                required:"Por favor, selecione a Categoria"
            },
            produtos_pk:{
                required:"Por favor, selecione o Produto"
            },
            produtos_itens_pk:{
                required:"Por favor, selecione o Material"
            },            
            dt_entrega:{
                required:"Por favor, informe a data de entrega"
            }*/
        },
        submitHandler: function(form){
            fcEnviarMateriais(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}

function fcEnviarMateriais(){
    
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
    
    if($("#dt_entrega").val()==""){
        alert("Por favor, informe a data de entrega.");
        return false;
    }
    
    
    
 
    if(leads_pk == ""){
       if($("#acao").val() == "ins"){   
           fcIncluirMateriaisSemPk();
           
       }else if($("#acao").val() == "upd"){
   
           fcEditarMateriaisSemPk();
       }
   }else{
       
       fcSalvarMateriais();
       $("#janela_materiais").modal("hide");
   }   
   
}
function fcEditarMateriaisSemPk(){
  
    fcIncluirMateriaisSemPk();
    tblMaterial.row(rLinhaSelecionadaMaterial).remove().draw();
    return false;
}

function fcIncluirMateriaisSemPk(){ 
    
    
    
    if($("#ic_mateiral_carga").is(":checked") == true){
        var ds_ic_mateiral_carga = "Sim";
        var ic_mateiral_carga = 1;
    }
    else{
        var ds_ic_mateiral_carga = "Não";
        var ic_mateiral_carga = 2;
    }
    
    if($("#qtde_materias").val()>0){
        
        var  data = tblMaterial.rows().data();
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
                tblMaterial.row.add(        
                    {            
                        "pk":"",
                        "ds_categorias_produto":$("#categorias_produto_pk option:selected").text(),
                        "categorias_produto_pk":$("#categorias_produto_pk option:selected").val(),
                        "ds_produtos":$("#produtos_pk option:selected").text(),
                        "produtos_pk":$("#produtos_pk option:selected").val(),
                        "ds_produtos_itens":arrCarregar1.data[i]['ds_produto_item'],
                        "produtos_itens_pk":arrCarregar1.data[i]['pk'],
                        "dt_entrega":$("#dt_entrega").val(),
                        "dt_devolucao":"",
                        "obs_material":$("#obs_material").val(),
                        "ic_mateiral_carga":ic_mateiral_carga,
                        "ds_ic_mateiral_carga":ds_ic_mateiral_carga,
                        "t_functions":""
                    }
                ).draw(); 
            } 
        }       
    }
    else{
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
                "obs_material":$("#obs_material").val(),
                "ic_mateiral_carga":ic_mateiral_carga,
                "ds_ic_mateiral_carga":ds_ic_mateiral_carga,
                "t_functions":""
            }
        ).draw();
    }
    $("#janela_materiais").modal("hide");   
    return false;
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
    

    var v_leads_pk = leads_pk; 
    var v_colaborador_pk = colaborador_pk;
    
    
    if($("#qtde_materias").val()>0){
        
        var  data = tblMaterial.rows().data();
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
                    "leads_pk": v_leads_pk,
                    "colaborador_pk": v_colaborador_pk
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
                "leads_pk": v_leads_pk,
                "colaborador_pk": v_colaborador_pk
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
    tblMaterial.clear().destroy();    
    fcCarregarGridMateriais();
}

function fcCarregarMateriais(){
    if(pk > 0){

        var objParametros = {
            "pk": pk
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
    $("#produtos_pk").val("");
    $("#produtos_itens_pk").val("");
    $("#dt_entrega").val("");
    $("#obs_material").val("");      
    $("#dt_devolucao").val("");      
    $("#qtde_materias").val("");      
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


function pegarPkProdutosItensNotIn(produtos_itens_pk_res){
    try{
        var produtos_itens_pk = "";
        
        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "produtos_itens_pk";
        
        var  data = tblMaterial.rows().data();
        
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
        "leads_pk":leads_pk,
        "produtos_itens_pk":produtos_itens_pk
        //"strProdutoGrid":strProdGrid
    };     
    
    var arrCarregar = carregarController("produto_iten", "listarPorPkProdutoNotIn", objParametros);    
   
    carregarComboAjax($("#produtos_itens_pk"), arrCarregar, " ", "pk", "ds_produto_item");     
}


$(document).ready(function(){
    
   //Atribui os eventos
    //$(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdIncluirMaterial', fcAbrirFormNovoMaterial); 
  
    
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
    
  
    
    //Atribui a validação do formulário dos campos obrigatórios
    fcValidarFormModalMateriais();
});
