function fcValidarForm(){

    
    if($("#dt_ini").val()==''){
        alert('Por favir informe a Dt do registro do Ponto De');
        return false;
    }
    

    if($("#dt_fim").val()==''){
        alert('Por favir informe a Dt do registro do Ponto Até');
        return false;
    }

    fcGeraRelatorio();
}

function fcGeraRelatorio(){
    
    var v_ds_colaborador = $("#colaboradores_pk option:selected").text()
    var v_ds_lead = $("#ds_lead option:selected").text()
    sendPost('ponto_rel_sintetico_dados_form.php', {token: token, colaboradores_pk: $("#colaboradores_pk").val(),ds_colaboradores: v_ds_colaborador,dt_ini: $("#dt_ini").val(),dt_fim: $("#dt_fim").val(),leads_pk: $("#ds_lead").val(),ds_lead: v_ds_lead});
}
function fcVoltar(){
    sendPost("menu_relatorios_ponto_falta.php", {token: token});
}

function fcCarregarColaborador(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("colaborador", "listarTodosRel", objParametros);  

    carregarComboAjax($("#colaboradores_pk"), arrCarregar, " ", "pk", "ds_colaborador");        
}

function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);       
    carregarComboAjax($("#ds_lead"), arrCarregar, " ", "pk", "ds_lead");        
}

$(document).ready(function(){   
    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdGerarRelatorio', fcValidarForm)     
        //Datas
        $('#dt_ini').datepicker({

            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: false,
            todayBtn: "linked",
            minDate: new Date()       
        });
        $("#dt_ini").keypress(function(){
            mascara(this,mdata);      
            $('#sandbox-container input').datepicker({ minDate: 0});
        });
        
        //Datas
        $('#dt_fim').datepicker({
    
            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: false,
            todayBtn: "linked",
            minDate: new Date()       
        });
        $("#dt_fim").keypress(function(){
            mascara(this,mdata);      
            $('#sandbox-container input').datepicker({ minDate: 0});
        });                
        fcCarregarLeads();     
        fcCarregarColaborador();

        $(".chzn-select").chosen({allow_single_deselect: true});
    
});