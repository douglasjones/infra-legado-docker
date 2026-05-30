function fcMascaraFormConta(){
    $("#ds_cpf_cnpj").keypress(function(){
        chama_mascara(this);
    });    


    $("#ds_cep").keypress(function(){
        mascara(this,cep);
    });

    $("#ds_cep").change(function(){
        fcCarregarCep($("#ds_cep").val());
    });

    $('#dt_ativacao').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });

    $("#ds_tel_fixo").keypress(function(){
        mascara(this, mascaraTelefone);
    });
    $("#ds_tel_fixo1").keypress(function(){
        mascara(this, mascaraTelefone);
    });

}

function fcValidarForm(){
    $("#form").validate({
        rules :{
            ds_tipo_pessoa:{
                required:true
            },
            ic_tipo_conta:{
                required:true
            },
            ic_tipo_segmento:{
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
            ic_tipo_faturamento:{
                required:true
            },
            ic_dia_faturamento:{
                required:true
            }
        },
        messages:{
            ds_tipo_pessoa:{
                required:"Por favor, informe o Tipo Pessoa"    
            },
            ic_tipo_conta:{
                required:"Por favor, informe o Tipo Conta"
            },
            ic_tipo_segmento:{
                required:"Por favor, informe o Segmento"
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
            ic_tipo_faturamento:{
                required:"Por favor, informe o tipo faturamento "
            },
            ic_dia_faturamento:{
                required:"Por favor, informe o dia Faturamento "
            }

        },
        submitHandler: function(form){

            fcEnviarConta();

            return false;
        }
    });
}

function fcEnviarConta(){
    try {
        var v_pk = $('#pk').val()
        var v_ds_tipo_pessoa = $("#ds_tipo_pessoa").val();
        var v_ds_conta = $("#ds_conta").val();
        var v_ds_razao_social = $("#ds_razao_social").val();
        var v_ds_cpf_cnpj = $("#ds_cpf_cnpj").val();
        var v_ds_tel_fixo = $("#ds_tel_fixo").val();
        var v_ds_tel_fixo1 = $("#ds_tel_fixo1").val();
        var v_ds_cep = $("#ds_cep").val();
        var v_ds_endereco = $("#ds_endereco").val();
        var v_ds_numero = $("#ds_numero").val();
        var v_ds_complemento = $("#ds_complemento").val();
        var v_ds_bairro = $("#ds_bairro").val();
        var v_ds_cidade = $("#ds_cidade").val();
        var v_ds_uf = $("#ds_uf").val();
        var v_dt_ativacao = $("#dt_ativacao").val();
        var v_ic_status = $("#ic_status").val();
        var v_ic_tipo_faturamento = $("#ic_tipo_faturamento").val();
        var v_ic_dia_faturamento = $("#ic_dia_faturamento").val();
        var v_ic_tipo_conta = $("#ic_tipo_conta").val();
        var v_ic_tipo_segmento = $("#ic_tipo_segmento").val();


        var objParametros = {
            "pk": (v_pk),
            "ds_tipo_pessoa": (v_ds_tipo_pessoa),
            "ds_conta": (v_ds_conta),
            "ds_razao_social": (v_ds_razao_social),
            "ds_cpf_cnpj": (v_ds_cpf_cnpj),
            "ds_tel": (v_ds_tel_fixo),
            "ds_cel": (v_ds_tel_fixo1),
            "ds_cep": (v_ds_cep),
            "ds_endereco": (v_ds_endereco),
            "ds_numero": (v_ds_numero),
            "ds_complemento": (v_ds_complemento),
            "ds_bairro": (v_ds_bairro),
            "ds_cidade": (v_ds_cidade),
            "ds_uf": (v_ds_uf),
            "dt_ativacao": (v_dt_ativacao),
            "ic_status": (v_ic_status),
            "ic_tipo_faturamento": (v_ic_tipo_faturamento),
            "ic_dia_faturamento": (v_ic_dia_faturamento),
            "ic_tipo_conta": (v_ic_tipo_conta),
            "ic_tipo_segmento": (v_ic_tipo_segmento),

        };    
        var arrEnviar = carregarController("conta", "salvar", objParametros);

        if (arrEnviar.status == true){
            // Reload datable
            utilsJS.toastNotify(true, arrEnviar.message);
            sendPost('conta', 'receptivo', '');
        }
        else{
            utilsJS.toastNotify(false, 'Falhou a requisição para salvar o registro');
        }
    } catch (error) {
        console.log(error)
    }

}

function fcCancelar(){
    sendPost('conta', 'receptivo', '');
}

function fcCarregarConta(){
    try {
        let pk = $('#pk').val()
        if(pk > 0){
    
            var objParametros = {
                "pk": pk
            };        
            
            var arrCarregar = carregarController("conta", "listarPk", objParametros);
           // NewWindow(v_last_url)
            
            if (arrCarregar.status == true){

                $("#ds_tipo_pessoa").val(arrCarregar.data[0]['ds_tipo_pessoa']);
                $("#ds_conta").val(arrCarregar.data[0]['ds_conta']);
                $("#ds_razao_social").val(arrCarregar.data[0]['ds_razao_social']);
                $("#ds_cpf_cnpj").val(arrCarregar.data[0]['ds_cpf_cnpj']);
                $("#ds_tel_fixo").val(arrCarregar.data[0]['ds_tel']);
                $("#ds_tel_fixo1").val(arrCarregar.data[0]['ds_cel']);
                $("#ds_cep").val(arrCarregar.data[0]['ds_cep']);
                $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
                $("#ds_numero").val(arrCarregar.data[0]['ds_numero']);
                $("#ds_complemento").val(arrCarregar.data[0]['ds_complemento']);
                $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
                $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
                $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);
                $("#dt_ativacao").val(arrCarregar.data[0]['dt_ativacao']);
                $("#ic_status").val(arrCarregar.data[0]['ic_status']);
                $("#ic_tipo_faturamento").val(arrCarregar.data[0]['ic_tipo_faturamento']);
                $("#ic_dia_faturamento").val(arrCarregar.data[0]['ic_dia_faturamento']);
                $("#ic_tipo_conta").val(arrCarregar.data[0]['ic_tipo_conta']);
                $("#ic_tipo_segmento").val(arrCarregar.data[0]['ic_tipo_segmento']);
            }
            else{
                utilsJS.toastNotify(false, 'Falhar ao carregar o registro');
            }
        }
    } catch (error) {
        alert(error)
    }
   
}

function fcVerificarCNPJ(){
    var ds_cpf_cnpj = $("#ds_cpf_cnpj").val();
    if(ds_cpf_cnpj.length == 14 || ds_cpf_cnpj.length == 18){
        var objParametros = {
            "ds_cpf_cnpj": $("#ds_cpf_cnpj").val()
        };

        var arrCarregar = carregarController("lead", "verificarCNPJ", objParametros);

        if (arrCarregar.status == true){

            if(arrCarregar.data.length > 0){

                utilsJS.toastNotify(false, "Já existe um Lead com esse CNPJ");
                $("#ds_lead").val("");
                $("#ds_cpf_cnpj").val("");
                $("#ds_cidade").val("");
                $("#ds_endereco").val("");
                $("#ds_bairro").val("");
                $("#ds_uf").val("");

            }
        }
        else{
            utilsJS.toastNotify(false, 'Falhar ao carregar o registro');
        }
    }
}
$(document).ready(function(){
    //Dados Cadastrais
        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregarConta();

        //mascaras
        fcMascaraFormConta();

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();  

        //Atribui os eventos
        $(document).on('click', '#cmdVoltarConta', fcCancelar);
        $(document).on('click', '#cmdEnviarConta', fcValidarForm);

        $("#cmdConsultarCNPJ").click(function(){
            fcVerificarCNPJ($("#ds_cpf_cnpj").val());
        });


        //Atribuir eventos 
        $(document).on('click', '#cmdEnviarConta', fcValidarForm);

        $("#dados-tab").click(function(){
            $("#dados-tab").removeClass();
            $("#dados-tab").addClass('nav-link active');

            $("#dados").addClass('tab-pane fade show active');
        });


});

