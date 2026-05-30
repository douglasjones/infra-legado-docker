function fcObservacaoAnaliseFinanceira(pk){
   
    fcCarregarUsuarioGridObs(pk)
    $("#modal_correcao_obs").modal()
}

function fcCarregarUsuarioGridObs(pk){
    var objParametros = {
        "lancamento_pk": pk
    };

    var arrCarregar = carregarController("analise_financeira_processos", "listarObsAnalise", objParametros);
    var obs = "";
    for(var i=0; i<arrCarregar.data.length; i++){
        var obs = arrCarregar.data[i]['t_obs']
        var ic_status = arrCarregar.data[i]['t_ic_status']
        var analise_financeira_pk = arrCarregar.data[i]['t_analise_financeira_pk']
    }
    $("#analise_financeira_pk").val(analise_financeira_pk)
    
    if(ic_status == "Recusado" ){
        $("#usuario_obs").hide()
    }
    $("#obs").text(obs)
}

function fcValidarFormCorrecao(){
    if($("#obs_correcao").val()==""){
        $("#alert_obs_correcao").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_obs_correcao").slideUp(500);
        });
        $('#obs_correcao').focus();
        return false;
    }     
    fcSalvarCorrecao()
}

function fcSalvarCorrecao(){
    var v_obs_correcao = $("#obs_correcao").val();
    var v_analise_financeira_pk = $("#analise_financeira_pk").val();
    var objParametros = {
        "obs_correcao": v_obs_correcao,      
        "ic_correcao": 6 , 
        "analise_financeira_pk": v_analise_financeira_pk
    };  
    
    var arrEnviar = carregarController("analise_financeira_processos", "salvar", objParametros);      
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("financeiro_usuarios_lancamentos_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }

}

$(document).ready(function () {
    $(document).on('click', '#cmdCorrecaoFeita', function () {
        fcValidarFormCorrecao();
    });
    fcCarregarGridObs();
});