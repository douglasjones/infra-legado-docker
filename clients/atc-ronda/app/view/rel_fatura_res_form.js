var tblResultado;
var click_id = 0;
function fcValidarForm(){

    $("#form").validate({
        rules :{
            dt_ini:{
                required: true
            },
            dt_fim:{
                required: true,
            }
        },
        messages:{
            dt_ini:{
                required:"Por favor, informe Período De!"
            },
            dt_fim:{
                required:"Por favor, informe Período Até!"
            }

        },
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcCarregarGrid(){
    /*if($("#ds_lead").val()==""){
        $("#alert_lead").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_lead").slideUp(500);
        });
        $('#ds_lead').focus();
        return false;
    }*/
    var v_ds_empresa = $("#empresas_pk option:selected").text()
    var v_ds_lead = $("#leads_pk option:selected").text()
    sendPost('rel_fatura_cad_form.php', {token: token, empresas_pk: $("#empresas_pk").val(),ds_empresa: v_ds_empresa,dt_ini: $("#dt_ini").val(),dt_fim: $("#dt_fim").val(),leads_pk: $("#leads_pk").val(),ds_lead: v_ds_lead});
}

function fcCarregarEmpresa(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("conta", "listarPk", objParametros);    
    carregarComboAjax($("#empresas_pk"), arrCarregar, " ", "pk", "ds_razao_social");
        
}

function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}
function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
    
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");        
}

$(document).ready(function(){    
    /*var arrCarregar = permissao("rel_colaborador", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
           
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
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
    fcCarregarEmpresa()
    
    
    
    $(".chzn-select").chosen({allow_single_deselect: true});
    

});


