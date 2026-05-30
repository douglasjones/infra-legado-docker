var tblResultado;
var click_id = 0;
function fcValidarForm(){

    $("#form").validate({
        rules :{
        },
        messages:{
        },
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcCarregarGrid(){
    var ds_lead = $("#leads_pk option:selected").text();
    var ds_ic_tipo_lead = $("#ic_tipo_lead option:selected").text();
    var ds_ic_cliente = $("#ic_cliente option:selected").text();
    

    sendPost('rel_posto_trabalho_analitico_cad_form.php', {token: token, 
        ds_cidade: $("#ds_cidade").val(),
        leads_pk: $("#leads_pk").val(),
        ic_tipo_lead: $("#ic_tipo_lead").val(),
        ic_cliente: $("#ic_cliente").val(),
        ds_ic_tipo_lead: ds_ic_tipo_lead,
        ds_ic_cliente: ds_ic_cliente,
        ds_lead:ds_lead,
    });
}

function fcCancelar(){

    sendPost("menu_relatorios_lead.php", {token: token});
}

function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
   
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");         
}
function fcCarregarCidades(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarEnderecoPorLead", objParametros);    
   
    carregarComboAjax($("#ds_cidade"), arrCarregar, " ", "ds_cidade", "ds_cidade");         
}

$(document).ready(function(){    
    /*var arrCarregar = permissao("rel_colaborador", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
           
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
    
    
    
    fcCarregarLeads();
    fcCarregarCidades();
    
    

    $(".chzn-select").chosen({allow_single_deselect: true});
});


