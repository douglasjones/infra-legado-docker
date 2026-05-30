function fcValidarForm(){
    var dt_ini_periodo = $("#data_periodo_ini").val();
    var dt_fim_periodo = $("#data_periodo_fim").val();

    if($("#dt_ini_periodo").val()==""){
        $("#alert_dt_ini_periodo").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_ini_periodo").slideUp(500);
        });
        $('#dt_ini_periodo').focus();
        return false;
    }     
    
    if($("#dt_fim_periodo").val()==""){
        $("#alert_dt_fim_periodo").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_fim_periodo").slideUp(500);
        });
        $('#dt_fim_periodo').focus();
        return false;
    } 

    if(DataYMD($("#dt_ini_periodo").val()) > DataYMD($("#dt_fim_periodo").val())){
        alert("A Dt. Ínicio Período não pode ser maior do que a Dt. Fim Período");
        return false;
    }else if(DataYMD($("#dt_fim_periodo").val()) > DataYMD(dt_fim_periodo)){
        alert("A Dt. Fim Período não pode ser maior do que a Dt. Período Folha Fim");
        return false;
    }else if(DataYMD($("#dt_ini_periodo").val()) < DataYMD(dt_ini_periodo)){
        alert("O valor Dt. Ínicio Período não pode ser menor do que a Dt. Período Folha Ini");
        return false;
    }

    fcEnviar();
}

function fcEnviar(){
    var pk = $("#ponto_folha_pk").val();

    var objParametros = {
        "pk": $("#ponto_folha_pk").val(),
        "dt_periodo_ini": $("#dt_ini_periodo").val(),
        "dt_periodo_fim": $("#dt_fim_periodo").val(),
        "arrColaborador": $("#colaboradores_pk").val()
    };

    var arrEnviar = carregarController("ponto_folha", "regerar", objParametros); 
    //NewWindow(v_last_url)
    if (arrEnviar.result == 'success') {
        
        alert(arrEnviar.message);
        sendPost("ponto_folha_registros_res_form.php", { token: token, pk: pk});
    }
    else {
        alert('Falhou a requisição para salvar o registro');
    }
}


$(document).ready(function () {

    $('#dt_ini_periodo').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_ini_periodo").keypress(function () {
        mascara(this, mdata);
    });  

    $('#dt_fim_periodo').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_fim_periodo").keypress(function () {
        mascara(this, mdata);
    });   
    
    $(document).on('click', '#cmdEnviar', fcValidarForm);
});