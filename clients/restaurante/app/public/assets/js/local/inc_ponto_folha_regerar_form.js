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
    var objParametros = {
        "pk": $('#pk').val(),
        "dt_periodo_ini": $("#dt_ini_periodo").val(),
        "dt_periodo_fim": $("#dt_fim_periodo").val(),
        "arrColaborador": $("#colaboradores_pk").val()
    };

    var arrEnviar = carregarController("ponto_folha", "regerar", objParametros); 
    if (arrEnviar.status == true) {
        
        utilsJS.toastNotify(true, 'Registros regerados com sucesso');
        $("#janela_regerar").modal("hide");
        
        sendPost('ponto_folha','colaboradoresCad',{"pk":$('#pk').val()})
    }
    else {
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcAbrirRegerar(){
    var data;
    var colaboradores_pk = [];

    data = tblResultado.rows('.selected').data();
    for(var l=0; l<data.length; l++){
        if(data[l]['ic_status']=="Finalizada"){
            utilsJS.toastNotify(false, 'Folhas finalizadas não podem ser regeradas. Por favor, escolha folhas que não foram finalizadas.');
            return false;
        }
    }

    for(var i=0; i<data.length; i++){
        colaboradores_pk[i] = data[i]['colaborador_pk']; 
    }
    
    if(colaboradores_pk.length > 0){
        var json_colaboradores = JSON.stringify(colaboradores_pk);
        $("#colaboradores_pk").val(json_colaboradores);
        $("#dt_ini_periodo").val($("#dt_periodo_ini").html());
        $("#dt_fim_periodo").val($("#dt_periodo_fim").html());
        $("#data_periodo_ini").val($("#dt_periodo_ini").html());
        $("#data_periodo_fim").val($("#dt_periodo_fim").html());
    
        $("#janela_regerar").modal("show");
    }else{
        utilsJS.toastNotify(false, 'Selecione ao menos um colaborador.');
    }
}
