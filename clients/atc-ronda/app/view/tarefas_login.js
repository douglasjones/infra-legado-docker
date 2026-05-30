
function fcEnviar(){

    event.preventDefault();
    
    var v_ds_login =  $("#ds_login").val();
    var v_tarefa_pk =  $("#pk").val();    
    if(v_ds_login==""){
        $("#alert_login").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_login").slideUp(500);
        });
        $('#ds_login').focus();
        return false;
    }
    
    var url = '../controller/colaborador.controller.php?job=autenticarColaborador&ds_pin=' + encodeURIComponent(v_ds_login);

    var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){
        if (output.result == 'success'){
            
            if(output.data[0]['ic_status']==1){
                sendPost("tarefas_colaborador_form.php", {token:output.data[0]['token'],colaborador_pk:output.data[0]['colaborador_pk'],ds_colaborador:output.data[0]['ds_colaborador'],tarefas_pk:v_tarefa_pk}); 
                //fcAbrirPopUpRedirecionar(output.data[0]['token'],output.data[0]['colaborador_pk'],output.data[0]['ds_colaborar'],v_tarefa_pk);
            }else{
                alert('Pin do colabarador desativado!');
                $('#ds_login').val(""); 
            }

        } 
        else{
            alert('Pin não localizado ou incorreto!');
            $('#ds_login').val(""); 
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Usuário ou Senha Incorreto ' + textStatus);
    });   
}


$(document).ready(function(){
        //Atribui a validação do formulário dos campos obrigatórios
        
        $(document).on('click', '#cmdEnviar', fcEnviar);
        
         $.ajax({
            url : "../versao.txt",
            success : function (data) {
               $("#ds_versao").text(data);
            }
        });
        
        //Verifica se o registro é para alteracao e puxa os dados.
    }    
);
