function fcValidarForm(){ 

    if($("#id_veiculo").val()==''){
        alert('Por favor, informe o nome do Condutor!');
        return false;
    }
    if($("#tipo_veiculo_pk").val()==''){
        alert('Por favor, informe o tipo do veiculo!');
        return false;
    }
    if($("#marcas_veiculos_pk").val()==''){
        alert('Por favor, informe a marca do veiculo!');
        return false;
    }
    if($("#leads_pk").val()==''){
        alert('Por favor, informe o Posto de trabalho do Condutor"!');
        return false;
    }

    fcEnviar(); 

}
function fcEnviar(){

    var v_id_veiculo = $("#id_veiculo").val();
    var v_ds_placa = $("#ds_placa").val();
    var v_ds_km_inicial = $("#ds_km_inicial").val();
    var v_ds_cor = $("#ds_cor").val();
    var v_tipo_veiculo_pk = $("#tipo_veiculo_pk").val();
    var v_marcas_veiculos_pk = $("#marcas_veiculos_pk").val();
    var v_modelos_veiculos_pk = $("#modelos_veiculos_pk").val();
    var v_leads_pk = $("#leads_pk").val();
    var v_ic_status = $("#ic_status").val();

    var objParametros = {
        "pk": pk,
        "id_veiculo": (v_id_veiculo),
        "ds_placa": (v_ds_placa),
        "ds_km_inicial": (v_ds_km_inicial),
        "ds_cor": (v_ds_cor),
        "tipo_veiculo_pk": (v_tipo_veiculo_pk),
        "marcas_veiculos_pk": (v_marcas_veiculos_pk),
        "modelos_veiculos_pk": (v_modelos_veiculos_pk),
        "leads_pk": (v_leads_pk),
        "ic_status": (v_ic_status)        
    };    

    var arrEnviar = carregarController("veiculo", "salvar", objParametros);           
    
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("veiculo_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("veiculo_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("veiculo", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#id_veiculo").val(arrCarregar.data[0]['id_veiculo']);
            $("#ds_placa").val(arrCarregar.data[0]['ds_placa']);
            $("#ds_km_inicial").val(arrCarregar.data[0]['ds_km_inicial']);
            $("#ds_cor").val(arrCarregar.data[0]['ds_cor']);
            $("#tipo_veiculo_pk").val(arrCarregar.data[0]['tipo_veiculo_pk']);
            $("#marcas_veiculos_pk").val(arrCarregar.data[0]['marcas_veiculos_pk']);
            $("#modelos_veiculos_pk").val(arrCarregar.data[0]['modelos_veiculos_pk']);
            $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}
function fcCarregarLeads() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);  
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fcCarregarTiposVeiculos(){
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("veiculo", "listarTiposVeiculos", objParametros);  
    carregarComboAjax($("#tipo_veiculo_pk"), arrCarregar, " ", "pk", "ds_tipo_veiculo");
}

function fcCarrgarMarcasVeiculos(){
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("veiculo", "listarMarcasVeiculos", objParametros);  
    carregarComboAjax($("#marcas_veiculos_pk"), arrCarregar, " ", "pk", "ds_marca_veiculo");
}

function fcModelosVeiculos(){
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("veiculo", "listarModelosVeiculos", objParametros);  
    carregarComboAjax($("#modelos_veiculos_pk"), arrCarregar, " ", "pk", "ds_modelo_veiculo");
}

$(document).ready(function(){
    fcCarregarLeads();
    fcCarregarTiposVeiculos();
    fcCarrgarMarcasVeiculos();
    //fcModelosVeiculos();
    
    //Atribui os eventos
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdEnviarVeiculo', fcValidarForm);
    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregar();
});
