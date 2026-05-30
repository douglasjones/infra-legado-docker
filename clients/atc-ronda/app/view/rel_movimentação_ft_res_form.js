var tblResultado;

function fcCarregarGrid(){
    sendPost('rel_movimentação_ft_cad_form.php', {token: token, 
        ds_lead: $("#leads_pk :selected").text(),
        leads_pk: $("#leads_pk").val(),
        dt_ini: $("#dt_ini").val(),
        dt_fim: $("#dt_fim").val(),
        colaboradores_pk: $("#colaboradores_pk").val(),
        ds_colaborador: $("#colaboradores_pk :selected").text()});
}


function fcCarregarLeadsCombo(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("lead", "listarLeadsCombo", objParametros);    
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "leads_pk", "ds_lead");        
}

function fcCarregarColaboradores(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("colaborador", "listarTodosRel", objParametros);    
   
    carregarComboAjax($("#colaboradores_pk"), arrCarregar, " ", "pk", "ds_colaborador");         
}


function fcCancelar(){
    sendPost("menu_relatorios.php", {token: token});
}

$(document).ready(function(){
    //carrega cadastro ini
    $('#dt_ini').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_ini").keypress(function(){
       mascara(this,mdata);
    });
        
    //carrega cadastro fim
    $('#dt_fim').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_fim").keypress(function(){
       mascara(this,mdata);
    });
    
    fcCarregarColaboradores();    
    fcCarregarLeadsCombo();    
    
    //Valida Campos Ocorrencia
     $(document).on('click', '#cmdEnviar', fcCarregarGrid);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    

});


