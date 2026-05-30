
function fcComboCategoriasProdutoModal(){
    var objParametros = {};       
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros)

    carregarComboAjax($("#categoria_pk_modal"), arrCarregar, " ", "pk", "ds_categoria");
}

function fcValidarFormProduto(){

    $("#janela_adicionar_produto").validate({
        rules :{
            categoria_pk_modal:{
                required:true
            },
            ds_produto_modal:{
                required:true
            },
            ic_status_modal:{
                required:true
            }

        },
        messages:{
            categoria_pk_modal:{
                required:"Por favor, informe Categoria"
            },
            ds_produto_modal:{
                required:"Por favor, informe Produto"
            },
            ic_status_modal:{
                required:"Por favor, informe Status"
            }

        },
        submitHandler: function(form){
            fcSalvarProduto(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcSalvarProduto(){

    var v_ds_produto = $("#ds_produto_modal").val();
    var v_categoria_pk = $("#categoria_pk_modal").val();
    var v_ic_status = $("#ic_status_modal").val();

    var objParametros = {
        "ds_produto": v_ds_produto,   
        "categorias_produto_pk": v_categoria_pk,
        "ic_status": v_ic_status  
    };    

    var arrEnviar = carregarController("produto", "salvar", objParametros);  
            
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        $("#categorias_produto_pk").val(v_categoria_pk);
        fcComboProdutos($("#categorias_produto_pk").val())
        $("#produtos_pk").val(arrEnviar.data[0]['pk']);
        $("#janela_adicionar_produto").modal("hide");
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
    
}

function fcAbrirModalAdicionarProduto(){
    try {
        fcComboCategoriasProdutoModal()
        $("#janela_adicionar_produto").modal();
    } catch (error) {
        alert(error)
    }
}