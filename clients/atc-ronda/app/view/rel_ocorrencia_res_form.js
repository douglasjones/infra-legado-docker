var tblResultado;

function fcCarregarGrid(){
    sendPost('rel_ocorrencia_cad_form.php', {token: token, 
        ds_lead: $("#ds_lead").val(),
        tipos_ocorrencias_pk: $("#tipo_ocorrencia_res_pk").val(),
        ic_status: $("#ic_status").val(),
        usuario_cadastro_pk: $("#usuario_cadastro_res_pk").val(),
        dt_cadastro: $("#dt_cadastro").val(),
        usuario_agendado_para: $("#usuario_agendado_para").val(),
        dt_cadastro_fim: $("#dt_cadastro_fim").val()});
}


function fcCarregarTipoOcorrenciaRes(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("tipo_ocorrencia", "listarTodos", objParametros);    
    carregarComboAjax($("#tipo_ocorrencia_res_pk"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia");        
}
function fcCarregarComboUsuarioRes(){    
    var objParametros = {
        "pk": ""
    };  
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);    
    carregarComboAjax($("#usuario_cadastro_res_pk"), arrCarregar, " ", "pk", "ds_usuario");        
    carregarComboAjax($("#usuario_agendado_para"), arrCarregar, " ", "pk", "ds_usuario");        
}
function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}

$(document).ready(function(){
    //carrega cadastro ini
    $('#dt_cadastro').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_cadastro").keypress(function(){
       mascara(this,mdata);
    });
        
    //carrega cadastro fim
    $('#dt_cadastro_fim').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_cadastro_fim").keypress(function(){
       mascara(this,mdata);
    });
    
    fcCarregarTipoOcorrenciaRes();    
    fcCarregarComboUsuarioRes();    
    
    //Valida Campos Ocorrencia
     $(document).on('click', '#cmdEnviar', fcCarregarGrid);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    

});


