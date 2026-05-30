$(document).ready(function(){
	
        //mascaras
        fcMascaraFormConta();
        
        
        $("#ds_cep").change(function(){
            fcCarregarCep($("#ds_cep").val());
        });
                
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);

function fcMascaraFormConta(){
    $("#ds_cpf_cnpj").keypress(function(){
        chama_mascara(this);
    });    
    
    $("#ds_tel_fixo").keypress(function(){
     mascara(this, mascaraTelefone);
   });

   $("#ds_tel_fixo1").keypress(function(){
     mascara(this, mascaraTelefone);
   });
   
   $("#ds_cep").keypress(function(){
      mascara(this,cep);
   });
   
   $('#dt_cancelamento').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
   $('#dt_ativacao').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });

}

function fcValidarForm(){
    
    $("#form").validate({
        rules :{
            ds_tipo_pessoa:{
                required:true
            },
            ds_conta:{
                required:true
            },
            ds_cep:{
                required:true
            },
            ds_endereco:{
                required:true
            },
            ds_numero:{
                required:true
            },
            ds_bairro:{
                required:true
            },
            ds_cidade:{
                required:true
            },
            ds_uf:{
                required:true
            },
			tipo_conta_pk:{
				required:true
			}
        },
        messages:{
            ds_tipo_pessoa:{
                required:"Por favor, informe o Tipo Pessoa"    
            },
            ds_conta:{
                required:"Por favor, informe o Nome da Conta"                
            },
            ds_cep:{
                required:"Por favor, informe o Cep ",
                minlength:"Por favor, informe um Cep valido"
            },
            ds_endereco:{
                required:"Por favor, informe o Endereço "
            },
            ds_numero:{
                required:"Por favor, informe o Número"
            },
            ds_bairro:{
                required:"Por favor, informe o Bairro "
            },
            ds_cidade:{
                required:"Por favor, informe a Cidade "
            },
            ds_uf:{
                required:"Por favor, informe o UF "
            },
			tipo_conta_pk:{
				required:"Por favor, informe o Tipo Conta"
			}

        },
        submitHandler: function(form){
			if(fcVerificarConta() != 0){
				fcEnviar();
			}		   //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcVerificarConta(){
	var v_tipo_conta_pk = $("#tipo_conta_pk").val();
	
	if(v_tipo_conta_pk == 1){

		var arrCarregar = carregarController("conta", "verificarConta");
		
		for(i=0; i<arrCarregar.data.length; i++){
			if(arrCarregar.data[i]['tipo_conta_pk'] == 1 && pk != arrCarregar.data[i]['pk']){
				alert("Apenas uma conta pode ser Principal");
				return 0;
				break;
			}
		}
	}
}

function fcEnviar(){
try {
    var v_ds_tipo_pessoa = $("#ds_tipo_pessoa").val();
    var v_ds_conta = $("#ds_conta").val();
    var v_ds_razao_social = $("#ds_razao_social").val();
    var v_ds_cpf_cnpj = $("#ds_cpf_cnpj").val();
    var v_ds_cnae = $("#ds_cnae").val();
    var v_ds_rg = $("#ds_rg").val();
    var v_ds_tel_fixo = $("#ds_tel_fixo").val();
    var v_ds_email_contato_receita = $("#ds_email_contato_receita").val();
    var v_ds_tel_fixo1 = $("#ds_tel_fixo1").val();
    var v_ds_cep = $("#ds_cep").val();
    var v_ds_endereco = $("#ds_endereco").val();
    var v_ds_numero = $("#ds_numero").val();
    var v_ds_complemento = $("#ds_complemento").val();
    var v_ds_bairro = $("#ds_bairro").val();
    var v_ds_cidade = $("#ds_cidade").val();
    var v_ds_uf = $("#ds_uf").val();
    var v_dt_ativacao = $("#dt_ativacao").val();
    var v_dt_cancelamento = $("#dt_cancelamento").val();
    var v_ic_status = $("#ic_status").val();    
    var v_id_cliente = $("#id_cliente").val();  
	var v_ds_img_cliente = $("#ds_img_cliente").val();
	var v_tipo_conta_pk = $("#tipo_conta_pk").val();
	var v_ic_preencher_folha = $("#ic_preencher_folha").val();
	var v_ic_teto_gastos = $("#ic_teto_gastos").val();
	var v_ic_analise_financeira = $("#ic_analise_financeira").val();
	var v_ic_faturamento = $("#ic_faturamento").val();
	var v_ic_nf_gerar = $("#ic_nf_gerar").val();
	var v_ic_boleto = $("#ic_boleto").val();
    

    var objParametros = {
        "pk": pk,
        "ds_tipo_pessoa": (v_ds_tipo_pessoa),
        "ds_conta": (v_ds_conta),
        "ds_razao_social": (v_ds_razao_social),
        "ds_cpf_cnpj": (v_ds_cpf_cnpj),
        "ds_cnae": (v_ds_cnae),
        "ds_rg": (v_ds_rg),
        "ds_tel": (v_ds_tel_fixo),
        "ds_email": (v_ds_email_contato_receita),
        "ds_cel": (v_ds_tel_fixo1),
        "ds_cep": (v_ds_cep),
        "ds_endereco": (v_ds_endereco),
        "ds_numero": (v_ds_numero),
        "ds_complemento": (v_ds_complemento),
        "ds_bairro": (v_ds_bairro),
        "ds_cidade": (v_ds_cidade),
        "ds_uf": (v_ds_uf),
        "dt_ativacao": (v_dt_ativacao),
        "dt_cancelamento": (v_dt_cancelamento),
        "id_cliente": (v_id_cliente),
        "ic_status": (v_ic_status),
		"ds_img_cliente": (v_ds_img_cliente),
		"tipo_conta_pk": (v_tipo_conta_pk), 
		"ic_preencher_folha": (v_ic_preencher_folha),
		"ic_teto_gastos": (v_ic_teto_gastos),
		"ic_analise_financeira": (v_ic_analise_financeira),
		"ic_faturamento": (v_ic_faturamento),
		"ic_nf_gerar": (v_ic_nf_gerar),
		"ic_boleto": (v_ic_boleto)
		
    };    
    var arrEnviar = carregarController("conta", "salvar", objParametros);
 
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("conta_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
} catch (error) {
    alert(error)
}
    
}

function fcCancelar(){

    sendPost("conta_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("conta", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
            $("#ds_tipo_pessoa").val(arrCarregar.data[0]['ds_tipo_pessoa']);
            $("#ds_conta").val(arrCarregar.data[0]['ds_conta']);
            $("#ds_razao_social").val(arrCarregar.data[0]['ds_razao_social']);
            $("#ds_cpf_cnpj").val(arrCarregar.data[0]['ds_cpf_cnpj']);
            $("#ds_cnae").val(arrCarregar.data[0]['ds_cnae']);
            $("#ds_rg").val(arrCarregar.data[0]['ds_rg']);
            $("#ds_ddd").val(arrCarregar.data[0]['ds_ddd']);
            $("#ds_tel_fixo").val(arrCarregar.data[0]['ds_tel']);
            $("#ds_ddd_cel").val(arrCarregar.data[0]['ds_ddd_cel']);
            $("#ds_email_contato_receita").val(arrCarregar.data[0]['ds_email']);
            $("#ds_tel_fixo1").val(arrCarregar.data[0]['ds_cel']);
            $("#ds_cep").val(arrCarregar.data[0]['ds_cep']);
            $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
            $("#ds_numero").val(arrCarregar.data[0]['ds_numero']);
            $("#ds_complemento").val(arrCarregar.data[0]['ds_complemento']);
            $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
            $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
            $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);
            $("#segmentos_pk").val(arrCarregar.data[0]['segmentos_pk']);
            $("#dt_ativacao").val(arrCarregar.data[0]['dt_ativacao']);
            $("#dt_cancelamento").val(arrCarregar.data[0]['dt_cancelamento']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
            $("#id_cliente").val(arrCarregar.data[0]['id_cliente']);
			$("#ds_img_cliente").val(arrCarregar.data[0]['ds_img_cliente']);
			$("#tipo_conta_pk").val(arrCarregar.data[0]['tipo_conta_pk']);
			$("#ic_preencher_folha").val(arrCarregar.data[0]['ic_preencher_folha']==0?'2':arrCarregar.data[0]['ic_preencher_folha']);
			$("#ic_teto_gastos").val(arrCarregar.data[0]['ic_teto_gastos']==null?'2':arrCarregar.data[0]['ic_teto_gastos']);
			$("#ic_analise_financeira").val(arrCarregar.data[0]['ic_analise_financeira']==null?'2':arrCarregar.data[0]['ic_analise_financeira']);
			$("#ic_faturamento").val(arrCarregar.data[0]['ic_faturamento']==null?'2':arrCarregar.data[0]['ic_faturamento']);
			$("#ic_nf_gerar").val(arrCarregar.data[0]['ic_nf_gerar']==null?'2':arrCarregar.data[0]['ic_nf_gerar']);
			$("#ic_boleto").val(arrCarregar.data[0]['ic_boleto']==null?'2':arrCarregar.data[0]['ic_boleto']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}


