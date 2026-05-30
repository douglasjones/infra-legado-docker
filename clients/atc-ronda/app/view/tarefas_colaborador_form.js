function fcCancelar(){
    sendPost("tarefas_login.php", {});
}

function fcCarregar(){
    
    var v_pk = $("#tarefas_pk").val();

    var url = '../controller/agenda_colaborador_tarefa_itens.controller.php?job=listarPk&pk=' + v_pk;

    var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){
        if (output.result == 'success'){           
           $("#ds_identificacao_tarefa").html(output.data[0]['ds_tarefa'])
           $("#ds_posto_trabalho").html(output.data[0]['ds_lead'])
           $("#ds_setor").html(output.data[0]['ds_local'])
           $("#ds_area").html(output.data[0]['ds_area'])
           $("#ds_tarefa").html(output.data[0]['ds_tarefa_tipo_servico'])
           $("#ds_dias_hr").html(output.data[0]['ds_dias_hr'])
           $("#ds_obs").html(output.data[0]['obs']) 
           
   
           
           if(output.data[0]['dt_ini_execucao']!=null){  
               $('#linha_separacao').show();
               $('#dt_inicio_execucao').show();
               $('#dt_termino_execucao').show();
               
               $("#dt_ini_execucao").html(output.data[0]['dt_ini_execucao']) 
               $("#dt_fim_execucao").html(output.data[0]['dt_fim_execucao']) 
               
               if(output.data[0]['dt_fim_execucao']==null){ 
                   $('#btn_termino_tarefa').show();
                   $('#btn_inicio_tarefa').hide();
               }else{
                   $('#btn_termino_tarefa').hide();
                   $('#btn_inicio_tarefa').hide();
               }
                
            }           
           
           
        }else{
            alert('erro')
        }
    }); 
}
function fcIniciarTarefa(){

     var v_pk = $("#tarefas_pk").val();
     var v_dt_ini_tarefa = 1;
     var v_colaborador_exec_ini_pk = $("#colaborador_pk").val();
     
    var url = '../controller/agenda_colaborador_tarefa_itens.controller.php?job=salvar&pk='+v_pk+'&dt_ini_execucao='+v_dt_ini_tarefa+'&colaborador_exec_ini_pk='+v_colaborador_exec_ini_pk;   
    //alert(url)
    var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){
        if (output.result == 'success'){  
            alert('Tarefa iniciada!');
            sendPost("tarefas_login.php", {});
        }else{
            alert('Falhou a requisição para salvar o registro');
        }
    }); 
}
function fcFinalizaTarefa(){
     var v_pk = $("#tarefas_pk").val();
     var v_dt_fim_tarefa = 1;
     var v_colaborador_exec_fim_pk = $("#colaborador_pk").val();
     
    var url = '../controller/agenda_colaborador_tarefa_itens.controller.php?job=salvar&pk='+v_pk+'&dt_fim_execucao='+v_dt_fim_tarefa+'&colaborador_exec_fim_pk='+v_colaborador_exec_fim_pk;
    
    //alert(url)
    var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){
        if (output.result == 'success'){  
            alert('Tarefa finalizada!');
            sendPost("tarefas_login.php", {});
        }else{
            alert('Falhou a requisição para salvar o registro');
        }
    }); 
}
$(document).ready(function(){    
    $("#ds_colaborador_logado").html($("#ds_colaborador").val())
    
    $(document).on('click', '#cmdCancelar', fcCancelar); 
    
    fcCarregar();   
    
    $(document).on('click', '#cmdInicioTarefa', fcIniciarTarefa); 
    
    $(document).on('click', '#cmdTerminoTarefa', fcFinalizaTarefa);
    
});
