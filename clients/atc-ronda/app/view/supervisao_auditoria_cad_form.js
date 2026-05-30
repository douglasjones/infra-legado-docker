function fcValidarForm(){

    $("#form").validate({
        rules :{
            leads_pk:{
                required:true,
                minlength:3
            },
            auditorias_categorias_pk:{
                required:true,
                minlength:3
            },
            dt_agendamento:{
                required:true,
                minlength:3
            },
            usuario_agendamento_pk:{
                required:true,
                minlength:3
            },
            dt_execucao:{
                required:true,
                minlength:3
            },
            usuario_execucao_pk:{
                required:true,
                minlength:3
            },
            ic_contato_cliente:{
                required:true,
                minlength:3
            },
            obs_contato_cliente:{
                required:true,
                minlength:3
            },
            obs_geral:{
                required:true,
                minlength:3
            },
            ds_localizacao:{
                required:true,
                minlength:3
            }

        },
        messages:{
            leads_pk:{
                required:"Por favor, informe Posto Trabalho",
                minlength:"Posto Trabalho deve ter pelo menos 3 caracteres"
            },
            auditorias_categorias_pk:{
                required:"Por favor, informe Tipo Auditoria",
                minlength:"Tipo Auditoria deve ter pelo menos 3 caracteres"
            },
            dt_agendamento:{
                required:"Por favor, informe Dt Agendamento",
                minlength:"Dt Agendamento deve ter pelo menos 3 caracteres"
            },
            usuario_agendamento_pk:{
                required:"Por favor, informe Agendado Para",
                minlength:"Agendado Para deve ter pelo menos 3 caracteres"
            },
            dt_execucao:{
                required:"Por favor, informe Dt auditoria",
                minlength:"Dt auditoria deve ter pelo menos 3 caracteres"
            },
            usuario_execucao_pk:{
                required:"Por favor, informe Feita Por",
                minlength:"Feita Por deve ter pelo menos 3 caracteres"
            },
            ic_contato_cliente:{
                required:"Por favor, informe Falu com o CLiente",
                minlength:"Falu com o CLiente deve ter pelo menos 3 caracteres"
            },
            obs_contato_cliente:{
                required:"Por favor, informe Observao Cliente",
                minlength:"Observao Cliente deve ter pelo menos 3 caracteres"
            },
            obs_geral:{
                required:"Por favor, informe Observarcao",
                minlength:"Observarcao deve ter pelo menos 3 caracteres"
            },
            ds_localizacao:{
                required:"Por favor, informe Localizacao",
                minlength:"Localizacao deve ter pelo menos 3 caracteres"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_leads_pk = $("#leads_pk").val();
    var v_auditorias_categorias_pk = $("#auditorias_categorias_pk").val();
    var v_dt_agendamento = $("#dt_agendamento").val();
    var v_usuario_agendamento_pk = $("#usuario_agendamento_pk").val();
    var v_dt_execucao = $("#dt_execucao").val();
    var v_usuario_execucao_pk = $("#usuario_execucao_pk").val();
    var v_ic_contato_cliente = $("#ic_contato_cliente").val();
    var v_obs_contato_cliente = $("#obs_contato_cliente").val();
    var v_obs_geral = $("#obs_geral").val();
    var v_ds_localizacao = $("#ds_localizacao").val();


    var objParametros = {
        "pk": pk,
        "leads_pk": encodeURIComponent(v_leads_pk),
        "auditorias_categorias_pk": encodeURIComponent(v_auditorias_categorias_pk),
        "dt_agendamento": encodeURIComponent(v_dt_agendamento),
        "usuario_agendamento_pk": encodeURIComponent(v_usuario_agendamento_pk),
        "dt_execucao": encodeURIComponent(v_dt_execucao),
        "usuario_execucao_pk": encodeURIComponent(v_usuario_execucao_pk),
        "ic_contato_cliente": encodeURIComponent(v_ic_contato_cliente),
        "obs_contato_cliente": encodeURIComponent(v_obs_contato_cliente),
        "obs_geral": encodeURIComponent(v_obs_geral),
        "ds_localizacao": encodeURIComponent(v_ds_localizacao)        
    };    

    var arrEnviar = carregarController("supervisao_auditoria", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("supervisao_auditoria_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("supervisao_auditoria_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("supervisao_auditoria", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);
            $("#auditorias_categorias_pk").val(arrCarregar.data[0]['auditorias_categorias_pk']);
            $("#dt_agendamento").val(arrCarregar.data[0]['dt_agendamento']);
            $("#usuario_agendamento_pk").val(arrCarregar.data[0]['usuario_agendamento_pk']);
            $("#dt_execucao").val(arrCarregar.data[0]['dt_execucao']);
            $("#usuario_execucao_pk").val(arrCarregar.data[0]['usuario_execucao_pk']);
            $("#ic_contato_cliente").val(arrCarregar.data[0]['ic_contato_cliente']);
            $("#obs_contato_cliente").val(arrCarregar.data[0]['obs_contato_cliente']);
            $("#obs_geral").val(arrCarregar.data[0]['obs_geral']);
            $("#ds_localizacao").val(arrCarregar.data[0]['ds_localizacao']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}
function fcCarregarLeads() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listarTodos", objParametros); 
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");
}
function fcCarregarCategorias() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("auditoria_categoria", "listarTodos", objParametros);
    carregarComboAjax($("#auditoria_categoria_pk"), arrCarregar, " ", "pk", "ds_categoria");
}
$(document).ready(function(){
    fcCarregarLeads();    
    fcCarregarCategorias();
    $(".chzn-select").chosen({ allow_single_deselect: true });
    //Atribui os eventos
    $(document).on('click', '#cmdCancelar', fcCancelar);

    //Atribui a validação do formulário dos campos obrigatórios
    fcValidarForm();

    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregar();
});
