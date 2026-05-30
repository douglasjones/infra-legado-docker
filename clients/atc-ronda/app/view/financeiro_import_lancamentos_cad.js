function fcEnviar(){
try {
    var obs = $("#obs").val();
    var v_ds_documento = $("#ds_documento").val();
    var v_ds_link_arquivo = '..docs/arquivosImportLancamento/arquivoprocessamento/'+v_ds_documento;

    var objParametros = {
        "obs": obs,   
        "ds_arquivo": v_ds_documento,   
        "ds_link_arquivo": v_ds_link_arquivo,   
        "ic_status": 1 
    };    

    var arrEnviar = carregarController("financeiro_import_lancamentos", "salvar", objParametros);
    if (arrEnviar.result == 'success'){
        // Reload datable
        var pk = arrEnviar.data[0]['pk'];
        fcEnviarItens(pk)
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
} catch (error) {
    alert(error)
}
}

function fcEnviarItens(pk){

    var v_ds_documento = $("#ds_documento").val();

    var objParametros = {
        "ds_arquivo": v_ds_documento,
        "financeiro_import_lancamentos_pk": pk
    };    

    var arrEnviar = carregarController("financeiro_import_lancamento_itens", "salvar", objParametros); 
    //NewWindow(v_last_url)  
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost('financeiro_lote_lancamentos_res.php', { token: token });
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcAlterarNomeArquivo(v_arquivo){    
    
    var objParametros = {
        "ds_arquivo": v_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "renomearArquivoImportLancamento", objParametros);  

    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#ds_documento").val(arrEnviar.data[0]['t_ds_nome_salvo']);
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }    
}

function fcValidarForm(){
    if ($('#ds_documento').val() == "") {
        $("#alert_ds_documento").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_ds_documento").slideUp(500);
        });
        $('#fileupload').focus();
        return false;
    }
    fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
}

$(function () {
    
    $('#fileupload').fileupload({
        
        dataType: 'json',
        done: function (e, data) {
            window.setTimeout('Reset()', 2000);
            $.each(data.files, function (index, file) {
                $("#ds_nome_original").text(file.name);
                fcAlterarNomeArquivo(file.name);
                alert("Sucesso ao subir o arquivo");
                
            });
        },
        fail: function (data) {
            alert("Falha ao subir o arquivo");
        },            
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css('width', progress + '%');
        }
    });
});

function Reset(){
    $('#progress .progress-bar').css('width', '0%');
}

function fsClean() {
    $('#progress .progress-bar').css('width', '0%');
}

function fcVoltar() {
    sendPost('financeiro_lote_lancamentos_res.php', { token: token });
}


$(document).ready(function () {
    $(document).on('click', '#cmdIncluir', fcValidarForm);
    $(document).on('click', '#cmdVoltar', fcVoltar);

})

