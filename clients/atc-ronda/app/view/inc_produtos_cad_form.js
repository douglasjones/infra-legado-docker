function  fcValidarFormProdutos(){
    $("#form_produtos").validate({
        rules :{
            modal_categorias_produto_pk:{
                required:true         
            },
            ds_produto:{
                required:true
            },
            tipo_unidade_pk:{
                required:true
            }
        },
        messages:{
            modal_categorias_produto_pk:{
                required:"Por favor, selecione a categoria "                
            },
            ds_produto:{
                required:"Por favor, informe o produto"                
            },
            tipo_unidade_pk:{
                required:"Por favor, informe o produto"                
            }
        },
        submitHandler: function(form){
            fcEnviarProdutos(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
        
    });
}
function fcEnviarProdutos(){
    var objParametros = {
        "pk": pk,
        "categorias_produto_pk": ($("#modal_categorias_produto_pk").val()),
        "ds_produto": ($("#ds_produto").val()),
        "tipo_unidade_pk": ($("#tipo_unidade_pk").val()),
        "ic_status": ($("#ic_status").val()),     
    };   

    var arrEnviar = carregarController("produto_estoque", "salvar", objParametros); 

    alert('Registro salvo com Sucesso!');
    fcCarregarProdutos();    
    $("#janela_produto").modal("hide"); 
}

function fcCarregarCategorias1(){  

    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);    
    carregarComboAjax($("#modal_categorias_produto_pk"), arrCarregar, " ", "pk", "ds_categoria");        
}
function fcLimparProdutos(){
    $("#modal_categorias_produto_pk").val();
    $("#ds_produto").val();
    $("#tipo_unidade_pk").val();
}

$(document).ready(function(){
 fcLimparProdutos();   
 fcCarregarCategorias1();
 fcValidarFormProdutos();   
    
});