
function fcAbrirAcompanhamento(){ 
    if($("#leads_pk").val()==""){
        $("#alert_leads_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_leads_pk").slideUp(500);
        });
        $('#leads_pk').focus();
        return false;
    }  
    if($("#turnos_pk").val()==""){
        $("#alert_turnos_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_turnos_pk").slideUp(500);
        });
        $('#turnos_pk').focus();
        return false;
    }  

    var width = 1432;
    var height = 600;
    var left = 250;
    var top = 150;

    var leads_pk = $("#leads_pk").val();
    var ds_lead = $("#leads_pk option:selected").text();
    var turnos_pk = $("#turnos_pk").val();
    var ds_turno = $("#turnos_pk option:selected").text();
    var URL = "mesa_operacional_cad_form.php?token="+ token + "&leads_pk=" + leads_pk + "&ds_lead=" + ds_lead + "&turnos_pk="+ turnos_pk + "&ds_turno=" + ds_turno;
    window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
        
}

function fcCarregarComboLeads(){        
    var arrCarregar = carregarController("lead", "listarPostosTrabalhoMesaOperacional");  
    //NewWindow(v_last_url)
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "leads_pk", "ds_lead");  
}

function fcCarregarComboTurno(){
    var arrCarregar = carregarController("turno", "listarTodos");  

    carregarComboAjax($("#turnos_pk"), arrCarregar, " ", "pk", "ds_turno");  
}



$(document).ready(function(){

    fcCarregarComboLeads();
    fcCarregarComboTurno();

    $("#cmdAbrirAcompanhamento").on('click', function(){
        fcAbrirAcompanhamento();   
    });

});


