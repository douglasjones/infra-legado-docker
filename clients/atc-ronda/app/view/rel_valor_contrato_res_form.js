var tblResultado;
var click_id = 0;
function fcValidarForm(){

    $("#form").validate({
        rules :{
            dt_ini:{
                required: true
            }
        },
        messages:{
            dt_ini:{
                required:"Por favor, informe o dia da escala!"
            }
        },
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcCarregarGrid(){
    var ds_lead = $("#leads_pk option:selected").text();
    

    sendPost('rel_valor_contrato_cad_form.php', {token: token, 
        leads_pk: $("#leads_pk").val(),
        dt_contrato_ini:$("#dt_contrato_ini").val(),
        dt_contrato_fim:$("#dt_contrato_fim").val(),
        ds_lead:ds_lead
    });
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
    $('#dt_contrato_ini').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_contrato_ini").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_contrato_fim').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_contrato_fim").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    
   
    
   
    
    
   
    fcCarregarLeads();

    $(".chzn-select").chosen({allow_single_deselect: true});
});


