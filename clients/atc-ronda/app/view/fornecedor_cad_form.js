function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_fornecedor:{
                required:true
            }

        },
        messages:{
            ds_fornecedor:{
                required:"Por favor, informe o nome do fornecedor"                
            }
        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_fornecedor = $("#ds_fornecedor").val();
    var v_ds_ddd = $("#ds_ddd").val();
    var v_ds_tel = $("#ds_tel").val();
    var v_ds_email = $("#ds_email").val();
    var v_categorias_produto_pk = $("#categorias_produto_pk").val();
    var v_ic_status = $("#ic_status").val();
    
    var v_ds_endereco = $("#ds_endereco").val();
    var v_ds_numero = $("#ds_numero").val();
    var v_ds_complemento = $("#ds_complemento").val();
    var v_ds_bairro = $("#ds_bairro").val();
    var v_ds_cep = $("#ds_cep").val();
    var v_ds_cidade = $("#ds_cidade").val();
    var v_ds_uf = $("#ds_uf").val();
    var v_ds_pix = $("#ds_pix").val();
    var v_ds_favorecido = $("#ds_conta_favorecido").val();
    //var vl_salario = $("#vl_salario").val();


    var objParametros = {
        "pk": pk,
        "ds_fornecedor": (v_ds_fornecedor),
        "ds_ddd": "",
        "ds_tel": (v_ds_tel),
        "ds_email": (v_ds_email),
        "categorias_produto_pk": (v_categorias_produto_pk),
        "ds_razao_social":$("#ds_razao_social").val(),
        "ds_cpf_cnpj":$("#ds_cpf_cnpj").val(),
        "tipo_conta_bancaria":$("#tipo_conta_bancaria").val(),
        "ds_agencia":$("#ds_agencia").val(),
        "ds_conta":$("#ds_conta").val(),
        "ds_digito":$("#ds_digito").val(),
        "bancos_pk":$("#bancos_pk").val(),
        "ds_endereco": (v_ds_endereco),
        "ds_numero": (v_ds_numero),
        "ds_complemento": (v_ds_complemento),
        "ds_bairro": (v_ds_bairro),
        "ds_cep": (v_ds_cep),
        "ds_cidade": (v_ds_cidade),
        "ds_uf": (v_ds_uf),
        //"vl_salario": moeda2float(vl_salario),
        "ic_status": (v_ic_status),       
        "ds_pix": (v_ds_pix),       
        "ds_favorecido_pix": (v_ds_favorecido)        
    };    

    var arrEnviar = carregarController("fornecedor", "salvar", objParametros); 
     
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("fornecedor_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("fornecedor_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("fornecedor", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_fornecedor").val(arrCarregar.data[0]['ds_fornecedor']);
            $("#ds_ddd").val(arrCarregar.data[0]['ds_ddd']);
            $("#ds_tel").val(arrCarregar.data[0]['ds_tel']);
            $("#ds_email").val(arrCarregar.data[0]['ds_email']);
            $("#categorias_produto_pk").val(arrCarregar.data[0]['categorias_produto_pk']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
            $("#ds_razao_social").val(arrCarregar.data[0]['ds_razao_social']);
            $("#ds_cpf_cnpj").val(arrCarregar.data[0]['ds_cpf_cnpj']);
            $("#tipo_conta_bancaria").val(arrCarregar.data[0]['tipo_conta_bancaria']);
            $("#ds_agencia").val(arrCarregar.data[0]['ds_agencia']);
            $("#ds_conta").val(arrCarregar.data[0]['ds_conta']);
            $("#ds_digito").val(arrCarregar.data[0]['ds_digito']);
            $("#bancos_pk").val(arrCarregar.data[0]['bancos_pk']);
            $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
            $("#ds_numero").val(arrCarregar.data[0]['ds_numero']);
            $("#ds_complemento").val(arrCarregar.data[0]['ds_complemento']);
            $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
            $("#ds_cep").val(arrCarregar.data[0]['ds_cep']);
            $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
            $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);
            $("#vl_salario").val(float2moeda(arrCarregar.data[0]['vl_salario']));
            
            
            
            

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

function fcCarregarBancos(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("banco", "listarTodos", objParametros);
    carregarComboAjax($("#bancos_pk"), arrCarregar, " ", "pk", "ds_banco");

}
function fcCarregarCep(){
    var cpf = $("#ds_cep").val();

    if(cpf.length == 9){

        var objParametros = {
            "ds_cep": $("#ds_cep").val()
        };

        var arrCarregar = carregarController("cep", "buscarCep", objParametros);

        if (arrCarregar.result == 'success'){

            $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
            $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
            $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
            $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);


        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}
$(document).ready(function()
    {
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);
        
        fcCarregarCategorias();
        
        $("#ds_tel").keypress(function(){
           mascara(this,mascaraTelefone);
        });  
        $("#ds_cpf_cnpj").keypress(function(){
           chama_mascara(this);
        });
        
        $("#ds_agencia").keypress(function(){
           mascara(this,soNumeros);
        });
        $("#ds_conta").keypress(function(){
           mascara(this,soNumeros);
        });
        $("#ds_agencia").keypress(function(){
           mascara(this,soNumeros);
        });

        /*$("#vl_salario").keypress(function(){
            mascara(this,moeda);
        });*/
        
        fcCarregarBancos();
        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
        
        $(".chzn-select").chosen({allow_single_deselect: true});
        
        $("#ds_cep").keypress(function(){
           mascara(this,cep);
        });
        

        $("#ds_cep").change(function(){
            fcCarregarCep();
        });
    }
);
