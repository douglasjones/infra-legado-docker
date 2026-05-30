function fcGerarProposta(){
    if($("#ic_tipo_proposta").val() == 1){
        if(ic_abertura == 1){
            sendPost('proposta_detalhada_cad_form.php',{token: token, pk: '', ic_versao: '', ic_abertura: 1});
            //sendPost('proposta_facilities_res_form.php', {token: token, ic_abertura: 1});
        }else{
            sendPost('proposta_detalhada_cad_form.php',{token: token, pk: '', ic_versao: '', leads_pk: leads_pk, ic_abertura: 2});
            //sendPost('lead_main_form.php', {token: token, ic_abertura: 2, leads_pk: leads_pk});
        }
        //sendPost('proposta_detalhada_cad_form.php',{token: token, pk: '', ic_versao: '', leads_pk: leads_pk});
    }else if($("#ic_tipo_proposta").val() == 2){
        //sendPost('proposta_basica_cad_form.php',{token: token, pk: ''});
    }else{
        $("#alert_ic_tipo_proposta").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_ic_tipo_proposta").slideUp(500);
        });
        $('#ic_tipo_proposta').focus();
        return false;
    }
}

function fcVoltar(){
    if(ic_abertura == 1){
        sendPost('proposta_facilities_res_form.php', {token: token, ic_abertura: 1});
    }else{
        sendPost('lead_main_form.php', {token: token, ic_abertura: 2, leads_pk: leads_pk});
    }
    
}

$(document).ready(function(){
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdGerarProposta', fcGerarProposta);
    $(document).on('click', '#cmdVoltar', fcVoltar);
    

});