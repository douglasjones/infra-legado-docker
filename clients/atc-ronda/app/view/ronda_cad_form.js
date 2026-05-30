function fcValidarForm(){

    $("#form").validate({
        rules :{
            leads_pk:{
                required:true,
                minlength:3
            },
            local_ronda_pk:{
                required:true,
                minlength:3
            },
            dt_ronda:{
                required:true,
                minlength:3
            }

        },
        messages:{
            leads_pk:{
                required:"Por favor, informe Posto de Trabalho",
                minlength:"Posto de Trabalho deve ter pelo menos 3 caracteres"
            },
            local_ronda_pk:{
                required:"Por favor, informe  Ronda",
                minlength:" Ronda deve ter pelo menos 3 caracteres"
            },
            dt_ronda:{
                required:"Por favor, informe Dt Hora Ronda",
                minlength:"Dt Hora Ronda deve ter pelo menos 3 caracteres"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
/*function fcEnviar(){

    var v_leads_pk = $("#leads_pk").val();
    var v_local_ronda_pk = $("#local_ronda_pk").val();
    var v_dt_ronda = $("#dt_ronda").val();


    var objParametros = {
        "pk": pk,
        "leads_pk": encodeURIComponent(v_leads_pk),
        "local_ronda_pk": encodeURIComponent(v_local_ronda_pk),
        "dt_ronda": encodeURIComponent(v_dt_ronda)        
    };    

    var arrEnviar = carregarController("ronda", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("ronda_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}*/


function fcEnviar(){

    var local_ronda_pk = $("#local_ronda_pk").val();
    var leads_pk= $("#leads_pk").val();
   
    var url = '../controller/ronda.controller.php?job=salvar&local_ronda_pk=' + local_ronda_pk + '&leads_pk='+ leads_pk;

    var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    alert('Registro salvo com sucesso!')
}

function fcCancelar(){
    sendPost("ronda_res_form.php", {token: token});
}

function fcCarregar(){
    if(pk > 0){
        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("ronda", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);
            $("#local_ronda_pk").val(arrCarregar.data[0]['local_ronda_pk']);
            $("#dt_ronda").val(arrCarregar.data[0]['dt_ronda']);

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
