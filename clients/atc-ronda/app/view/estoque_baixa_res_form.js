var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    fcColorirGrid();
    
}

function fcCarregarGrid(){

    
    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "categorias_pk": $("#categorias_pk").val(),
        "produtos_pk": $("#produtos_pk").val(),
        "dt_inicio": $("#dt_inicio").val(),
        "ic_status": $("#ic_status").val(),
        "dt_fim": $("#dt_fim").val()
    };     
    
    var v_url = montarUrlController("movimentacao_estoque", "listarEstoqueBaixa", objParametros);
   
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "aaSorting"      : [],
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>"
            },
           
           {"targets": -2, "data": "obs_baixa"},
           {"targets": -3, "data": "dt_baixa"},
           {"targets": -4, "data": "dt_entrega"},
           {"targets": -5, "data": "ds_lead"},
           {"targets": -6, "data": "ds_categoria"},
           {"targets": -7, "data": "ds_produtos_itens"},
           {"targets": -8, "data": "ds_produtos_itens_grid"},
           {"targets": -9, "data": "pk"}

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
        abrirModal(data['pk'],data['ds_produtos_itens'],data['dt_baixa'],data['obs_baixa']);
        
    } );   
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        
    } );            
    
}
function abrirModal(pk,ds_produto_itens,dt_baixa,obs_baixa){
    $("#produtos_itens_pk").val(pk);
    $("#dt_baixa").val(dt_baixa);
    $("#obs_baixa").val(obs_baixa);
    $("#ds_produto").html("Produto Item: <b>"+ds_produto_itens+"</b>");
    
    $("#janela_baixa").modal();
    
}
function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
    
    carregarComboAjax($("#leads_pk"), arrCarregar, "", "pk", "ds_lead");        
}

function fcCarregarCategorias(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);    
    carregarComboAjax($("#categorias_pk"), arrCarregar, " ", "pk", "ds_categoria");        
}

function fcCarregarProdutos(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros);  

    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");        
}


function fcSalvarBaixa(){   
     if($('#dt_baixa').val()==""){
        $("#alert_dt_baixa").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_baixa").slideUp(500);
        });
        $('#dt_baixa').focus();
        return false;
    }

    var objParametros = {
        "pk": $("#produtos_itens_pk").val(),
        "dt_baixa": $("#dt_baixa").val(),
        "obs_baixa": $("#obs_baixa").val()
    };    

    var arrEnviar = carregarController("produto_iten", "salvar", objParametros); 
 
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        tblResultado.clear().destroy();
        fcCarregarGrid();
        fcColorirGrid();
        $("#janela_baixa").modal("hide");
        
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}
function fcColorirGrid(){
    setTimeout(function(){
        $('#tblResultado tbody tr').each(function () {
             var colunas = $(this).children();
             if($(colunas[6]).text()!=""){
                 for(i=0;i<7;i++){
                     $(colunas[i]).css("background-color", "#1dc2ff"); 
                 }
             }

         });
     }, 2000);
}
$(document).ready(function(){

    //faz a carga inicial do grid.
   
    
    fcCarregarCategorias("");
    //Produtos
    fcCarregarProdutos("");
    
    fcCarregarLeads();
    
    fcCarregarGrid();
    
    window.setInterval(function() {
        fcColorirGrid();
    }, 50);
     
     
       
    $("#categorias_pk").change(function(){         
        fcCarregarProdutos($("#categorias_pk").val());
    });  
    
    $('#dt_inicio').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate" ); 
    $("#dt_inicio").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate"); 
    $("#dt_fim").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_baixa').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate"); 
    $("#dt_baixa").keypress(function(){
       mascara(this,mdata);
    });
    
    
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdEnviarBaixa', fcSalvarBaixa);
    

});


