
function fcVoltarLead(){

    sendPost("lead_res_form.php", {token: token, ic_abertura: 1});
}

$(document).ready(function(){
    
    //Atribui os eventos
    $(document).on('click', '#cmdVoltarLead', fcVoltarLead);

    $("#leads_pk").val(leads_pk)

});
