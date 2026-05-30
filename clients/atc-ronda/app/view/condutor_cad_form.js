function fcValidarForm(){ 

    if($("#ds_condutor").val()==''){
        alert('Por favor, informe o nome do Condutor!');
        return false;
    }
    if($("#leads_pk").val()==''){
        alert('Por favor, informe o Posto de trabalho do Condutor"!');
        return false;
    }

    fcEnviar(); 

}
function fcEnviar(){

    var v_ds_condutor = $("#ds_condutor").val();
    var v_ds_cpf = $("#ds_cpf").val();
    var v_ds_rg = $("#ds_rg").val();
    var v_leads_pk = $("#leads_pk").val();
    var v_ic_status = $("#ic_status").val();

    var objParametros = {
        "pk": pk,
        "ds_condutor": v_ds_condutor,
        "ds_cpf": v_ds_cpf,
        "ds_rg": v_ds_rg,
        "leads_pk": v_leads_pk,
        "ic_status":v_ic_status      
    };    

    var arrEnviar = carregarController("condutor", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("condutor_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("condutor_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("condutor", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_condutor").val(arrCarregar.data[0]['ds_condutor']);
            $("#ds_cpf").val(arrCarregar.data[0]['ds_cpf']);
            $("#ds_rg").val(arrCarregar.data[0]['ds_rg']);
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
$(document).ready(function(){
    $("#ds_cpf").keypress(function(){
        chama_mascara(this);
    });

    fcCarregarLeads();
    //Atribui os eventos
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdEnviarCondutor ', fcValidarForm);

    //Atribui a validação do formulário dos campos obrigatórios

    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregar();
});
