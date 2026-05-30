function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_tipo_servico:{
                required:true,
                minlength:3
            },
            dt_faturamento:{
                required:true,
                minlength:3
            },
            dt_emissao:{
                required:true,
                minlength:3
            },
            vl_bruto:{
                required:true,
                minlength:3
            },
            vl_liquido:{
                required:true,
                minlength:3
            },
            dt_cancelamento:{
                required:true,
                minlength:3
            },
            ds_xml:{
                required:true,
                minlength:3
            },
            obs:{
                required:true,
                minlength:3
            },
            leads_pk:{
                required:true,
                minlength:3
            },
            contratos_pk:{
                required:true,
                minlength:3
            },
            faturamento_itens_pk:{
                required:true,
                minlength:3
            }

        },
        messages:{
            ds_tipo_servico:{
                required:"Por favor, informe Servico",
                minlength:"Servico deve ter pelo menos 3 caracteres"
            },
            dt_faturamento:{
                required:"Por favor, informe Data Faturamento",
                minlength:"Data Faturamento deve ter pelo menos 3 caracteres"
            },
            dt_emissao:{
                required:"Por favor, informe Data Emissao",
                minlength:"Data Emissao deve ter pelo menos 3 caracteres"
            },
            vl_bruto:{
                required:"Por favor, informe VL Bruto.",
                minlength:"VL Bruto. deve ter pelo menos 3 caracteres"
            },
            vl_liquido:{
                required:"Por favor, informe VL Liquido",
                minlength:"VL Liquido deve ter pelo menos 3 caracteres"
            },
            dt_cancelamento:{
                required:"Por favor, informe Cliente",
                minlength:"Cliente deve ter pelo menos 3 caracteres"
            },
            ds_xml:{
                required:"Por favor, informe Contrato",
                minlength:"Contrato deve ter pelo menos 3 caracteres"
            },
            obs:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            leads_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            contratos_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            faturamento_itens_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_tipo_servico = $("#ds_tipo_servico").val();
    var v_dt_faturamento = $("#dt_faturamento").val();
    var v_dt_emissao = $("#dt_emissao").val();
    var v_vl_bruto = $("#vl_bruto").val();
    var v_vl_liquido = $("#vl_liquido").val();
    var v_dt_cancelamento = $("#dt_cancelamento").val();
    var v_ds_xml = $("#ds_xml").val();
    var v_obs = $("#obs").val();
    var v_leads_pk = $("#leads_pk").val();
    var v_contratos_pk = $("#contratos_pk").val();
    var v_faturamento_itens_pk = $("#faturamento_itens_pk").val();


    var objParametros = {
        "pk": pk,
        "ds_tipo_servico": encodeURIComponent(v_ds_tipo_servico),
        "dt_faturamento": encodeURIComponent(v_dt_faturamento),
        "dt_emissao": encodeURIComponent(v_dt_emissao),
        "vl_bruto": encodeURIComponent(v_vl_bruto),
        "vl_liquido": encodeURIComponent(v_vl_liquido),
        "dt_cancelamento": encodeURIComponent(v_dt_cancelamento),
        "ds_xml": encodeURIComponent(v_ds_xml),
        "obs": encodeURIComponent(v_obs),
        "leads_pk": encodeURIComponent(v_leads_pk),
        "contratos_pk": encodeURIComponent(v_contratos_pk),
        "faturamento_itens_pk": encodeURIComponent(v_faturamento_itens_pk)        
    };    

    var arrEnviar = carregarController("nota_fiscal", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("nota_fiscal_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("nota_fiscal_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("nota_fiscal", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_tipo_servico").val(arrCarregar.data[0]['ds_tipo_servico']);
            $("#dt_faturamento").val(arrCarregar.data[0]['dt_faturamento']);
            $("#dt_emissao").val(arrCarregar.data[0]['dt_emissao']);
            $("#vl_bruto").val(arrCarregar.data[0]['vl_bruto']);
            $("#vl_liquido").val(arrCarregar.data[0]['vl_liquido']);
            $("#dt_cancelamento").val(arrCarregar.data[0]['dt_cancelamento']);
            $("#ds_xml").val(arrCarregar.data[0]['ds_xml']);
            $("#obs").val(arrCarregar.data[0]['obs']);
            $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);
            $("#contratos_pk").val(arrCarregar.data[0]['contratos_pk']);
            $("#faturamento_itens_pk").val(arrCarregar.data[0]['faturamento_itens_pk']);

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

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);
