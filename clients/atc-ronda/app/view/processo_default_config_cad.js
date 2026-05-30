function fcValidarForm(){

    if($('#processo_default_pk').val()==""){
        $("#alert_processo_default_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_processo_default_pk").slideUp(500);
        });
        $('#processo_default_pk').focus();
        return false;
    }
    if($('#ds_processo_default_etapa').val()==""){
        $("#alert_ds_processo_default_etapa").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_processo_default_etapa").slideUp(500);
        });
        $('#ds_processo_default_etapa').focus();
        return false;
    }

    if($('#ds_processo_default_configuracao').val()==""){
        $("#alert_ds_processo_default_configuracao").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_processo_default_configuracao").slideUp(500);
        });
        $('#ds_processo_default_configuracao').focus();
        return false;
    }

    if($('#n_ordem').val()==""){
        $("#alert_n_ordem").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_n_ordem").slideUp(500);
        });
        $('#n_ordem').focus();
        return false;
    }

    fcEnviar(); 
}

function fcEnviar(){
    var arrGrupos = fcFormatarGrupos()
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "processo_default_configuracao_pk": pk,
        "pk": $("#processos_default_etapas_pk").val(),
        "processos_default_pk": $("#processo_default_pk").val(),
        "ds_processo_default_etapa":  $("#ds_processo_default_etapa").val(),
        "ds_processo_default_configuracao": $("#ds_processo_default_configuracao").val(),
        "n_ordem_etapa": $("#n_ordem").val(),
        "ds_cor": $("#ds_cor").val(),
        "tempo_execucao_pk": $("#tempo_execucao_pk").val(),
        "tipos_ocorrencias_pk": $("#tipos_ocorrencias_pk").val(),
        "processos_default_modulos_pk": $("#processos_default_modulos_pk").val(),
        "ic_status": $("#ic_status").val(),
        "processos_default_modulos_obrigatorio_pk": $("#processos_default_modulos_obrigatorio_pk").val(),
        "processo_default_grupos_pk": arrGrupos
    }; 
    var arrEnviar = carregarController("processo_default_etapa", "salvar", objParametros);
   // NewWindow(v_last_url)
    if (arrEnviar.result == 'success'){
        //fcRecarregarGridContatos();
        alert(arrEnviar.result);
        sendPost('processo_default_config_res.php',{token: token, pk: ''});
    }else{
        alert(arrEnviar.result);
    }
}


function fcFormatarGrupos(){
    var grupos_pk = $("input[name='grupos_pk']");
    var arrKeys = [];
    arrKeys[0] = "processo_default_grupos_pk";
    arrKeys[1] = "grupos_pk";
    arrKeys[2] = "ic_checkbox";
    
    var arrDados = []; 
    
    for(i = 0; i < grupos_pk.length; i++){
        var ic_checkbox = 2;
        if($("#grupos_pk"+i).prop('checked') == true){
            ic_checkbox = 1;
        }
        
        arrDados[i] = [$("#processo_default_grupos_pk"+i).val(), $("#grupos_pk"+i).val(), ic_checkbox];
    }
    
    return arrayToJson(arrKeys, arrDados);
}

function fcListarHoras(){
    for(var i=1; i<=72; i++){
        $('#tempo_execucao_pk').append('<option value='+i+'> '+i+'h </option>')
    }
}

function fcListaProcessosDefaultModulos(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("processo_default", "listarTodos", objParametros); 
    carregarComboAjax($("#processo_default_pk"), arrCarregar, " ", "pk", "ds_processo_default");
}

function fcListarOcorrencias(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("tipo_ocorrencia", "listarTodos", objParametros);    
    carregarComboAjax($("#tipos_ocorrencias_pk"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia"); 
}

function fcListaModulosObrigatorio(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("processos_default_modulos", "listarTodos", objParametros);    
    carregarComboAjax($("#processos_default_modulos_obrigatorio_pk"), arrCarregar, " ", "pk", "ds_modulo"); 
}

function fcListaOrdem(){
    for(var i=1; i<=10; i++){
        $('#n_ordem').append('<option value='+i+'> '+i+' </option>')
    }
}

function fcListaModulos(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("processos_default_modulos", "listarTodos", objParametros);

    carregarComboAjax($("#processos_default_modulos_pk"), arrCarregar, " ", "pk", "ds_modulo");
}

function fcListaProcessosDefaultGrupos(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("grupo", "listarTodos", objParametros);
    if (arrCarregar.result == 'success'){
        var html = "";
        for(var i=0; i < arrCarregar.data.length; i++){
            html+="<input type='checkbox' name='grupos_pk' id='grupos_pk"+i+"' value='"+arrCarregar.data[i]['pk']+"'>";
            html+="<input type='hidden' name='processo_default_grupos_pk' id='processo_default_grupos_pk"+i+"' value=''>";
            html+="<span for='grupos_pk"+i+"'>"+arrCarregar.data[i]['ds_grupo']+"</span><br>";

        }

        $("#grid_processo_default_grupos").html(html)
    }
}

function fcCarregar(){
    try{
        if(pk != " "){
            var objParametros = {
                "pk": pk
            };
        
            var arrCarregar = carregarController("processo_default_configuracao", "listarPk", objParametros);
                
            if (arrCarregar.result == 'success'){
            
                $("#processo_default_pk").val(arrCarregar.data[0]['processos_default_pk']);
                $("#processos_default_etapas_pk").val(arrCarregar.data[0]['processos_default_etapas_pk']);
                $("#ds_processo_default_etapa").val(arrCarregar.data[0]['ds_processo_default_etapa']);
                $("#ds_processo_default_configuracao").val(arrCarregar.data[0]['ds_processo_default_configuracao']);
                $("#n_ordem").val(arrCarregar.data[0]['n_ordem']);
                $("#ds_cor").val(arrCarregar.data[0]['ds_cor']);
                $("#tempo_execucao_pk").val(arrCarregar.data[0]['tempo_execucao_pk']);
                $("#tipos_ocorrencias_pk").val(arrCarregar.data[0]['tipos_ocorrencias_pk']);
                $("#processos_default_modulos_pk").val(arrCarregar.data[0]['processos_default_modulos_pk']);
                $("#processos_default_modulos_obrigatorio_pk").val(arrCarregar.data[0]['processos_default_modulos_obrigatorio_pk']);
                $("#ic_status").val(arrCarregar.data[0]['ic_status']);
                for(var i=0; i < arrCarregar.data[0]['gruposAcesso'].length; i++){
                    if($("#grupos_pk"+i).val() == arrCarregar.data[0]['gruposAcesso'][i]['grupos_pk']){
                        $("#grupos_pk"+i).prop('checked', true)
                    }
                    $("#processo_default_grupos_pk"+i).val(arrCarregar.data[0]['gruposAcesso'][i]['pk'])
                }
                
            }
            else{
                alert('Falhar ao carregar o registro');
            }
        }
    }catch(e){
        alert(e)
    }
   

}

function fcCancelar(){

    sendPost('processo_default_config_res.php',{token: token, pk: ''});

}

$(document).ready(function(){

    $(document).on('click', '#cmdEnviarTudo', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
    fcListarHoras();    
    fcListaProcessosDefaultModulos();    
    fcListaOrdem();
    
    fcListaModulos();


    fcListaProcessosDefaultGrupos();
    fcListarOcorrencias();
    fcListaModulosObrigatorio();
    fcCarregar();
});