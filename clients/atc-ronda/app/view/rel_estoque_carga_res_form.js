var tblResultado;
var click_id = 0;
function fcValidarForm(){

    $("#form").validate({
        rules :{
        },
        messages:{
        },
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcCarregarGrid(){
    var ds_categoria = $("#categorias_pk option:selected").text();
    var ds_produto = $("#produtos_pk option:selected").text();
    var ds_lead = $("#leads_pk option:selected").text();
    

    sendPost('rel_estoque_carga_cad_form.php', {token: token, 
        dt_movimentacao_ini: $("#dt_movimentacao_ini").val(),
        dt_movimentacao_fim: $("#dt_movimentacao_fim").val(),
        categorias_pk: $("#categorias_pk").val(),
        produtos_pk: $("#produtos_pk").val(),
        leads_pk: $("#leads_pk").val(),
        ds_produto:ds_produto,
        ds_lead:ds_lead,
        ds_categoria:ds_categoria
    });
}


function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}
function fcCarregarCategorias(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);    
    carregarComboAjax($("#categorias_pk"), arrCarregar, " ", "pk", "ds_categoria");        
}
function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);  

    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");        
}
function fcCarregarProdutos(categorias_produto_pk){    
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };          
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros);  

    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");        
}
$(document).ready(function(){    
    /*var arrCarregar = permissao("rel_colaborador", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
           
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
   //Categorias
    fcCarregarCategorias("");
    //Produtos
    fcCarregarProdutos("");
    
    fcCarregarLeads();
    
    $('#dt_movimentacao_ini').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_movimentacao_ini").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_movimentacao_fim').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_movimentacao_fim").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
       
    $("#categorias_pk").change(function(){         
        $(".chzn-select").chosen('destroy');
        fcCarregarProdutos($("#categorias_pk").val());
        $(".chzn-select").chosen({allow_single_deselect: true});
    });   

    $(".chzn-select").chosen({allow_single_deselect: true});
});


