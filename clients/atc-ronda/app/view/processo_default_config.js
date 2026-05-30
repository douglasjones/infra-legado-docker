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
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "processo_default_pk": $("#processo_default_pk").val(),
        "ds_processo_default_etapa":  $("#ds_processo_default_etapa").val(),
        "ds_processo_default_configuracao": $("#ds_processo_default_configuracao").val(),
        "n_ordem": $("#n_ordem").val(),
        "ds_cor": $("#ds_cor").val(),
        "tempo_execucao_pk": $("#tempo_execucao_pk").val(),
        "tipos_ocorrencias_pk": $("#tipos_ocorrencias_pk").val(),
        "processos_default_modulos_pk": $("#processos_default_modulos_pk").val(),
        "ic_status": $("#ic_status").val(),
        "processo_default_configuracao_pk": $("#processo_default_configuracao_pk").val(),
        "obs": $("#obs").val(),
    }; 
    var arrEnviar = carregarController("contato", "salvar", objParametros);
    
    if (arrEnviar.result == 'success'){
        fcRecarregarGridContatos();
    }else{
        alert(arrEnviar.result);
    }
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

function fcListaOrdem(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("processo_default_configuracao", "listarTodos", objParametros); 
    carregarComboAjax($("#n_ordem"), arrCarregar, " ", "pk", "n_ordem");
}

function fcListaCor(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("processo_default_configuracao", "listarTodos", objParametros);
    carregarComboAjax($("#ds_cor"), arrCarregar, " ", "pk", "ds_cor");
}

function fcListaModulos(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("processos_default_modulos", "listarTodos", objParametros); 
    carregarComboAjax($("#processos_default_modulos_pk"), arrCarregar, " ", "pk", "processos_default_modulos_pk");
}

function fcListaProcessosDefaultGrupos(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("processo_default_grupos", "listarTodos", objParametros); 
    carregarComboAjax($("#processo_default_configuracao_pk"), arrCarregar, " ", "pk", "processo_default_configuracao_pk");
}

$(document).ready(function(){

    $(document).on('click', '#cmdEnviarTudo', fcValidarForm);
    
    fcListarHoras();
    fcListaProcessosDefaultModulos();
    fcListaOrdem();
    fcListaCor();
    fcListaModulos();
    fcListaProcessosDefaultGrupos();
});