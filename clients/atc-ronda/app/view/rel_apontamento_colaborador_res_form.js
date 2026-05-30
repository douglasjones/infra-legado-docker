var tblResultado;
var click_id = 0;
function fcValidarForm(){

    $("#form").validate({
        rules :{
            dt_apontamento_ini:{
                required: true
            },
            dt_apontamento_fim:{
                required: true,
            }
        },
        messages:{
            dt_apontamento_ini:{
                required:"Por favor, informe DT Apontamento Ini!"
            },
            dt_apontamento_fim:{
                required:"Por favor, informe DT Apontamento Fim!"
            }

        },
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcCarregarGrid(){
    
    var v_ds_colaborador = $("#colaborador_pk option:selected").text();
    var v_ds_lead = $("#leads_pk option:selected").text();
    var v_ds_tipo_apontamento = $("#tipo_apontamento_pk option:selected").text();
    
    sendPost('rel_apontamento_colaborador_cad_form.php', {token: token,
        colaborador_pk: $("#colaborador_pk").val(),
        ds_colaborador: v_ds_colaborador,
        ds_tipo_apontamento: v_ds_tipo_apontamento,
        tipo_apontamento_pk: $("#tipo_apontamento_pk").val(),
        dt_apontamento_ini: $("#dt_apontamento_ini").val(),
        dt_apontamento_fim: $("#dt_apontamento_fim").val(),
        leads_pk: $("#leads_pk").val(),
        ds_lead: v_ds_lead});
}

function fcCarregarColaborador(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("colaborador", "listarColaboradorAgenda", objParametros);    
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");
        
}

function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}
function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodosAtivo", objParametros);    
    
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
    $('#dt_apontamento_ini').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_apontamento_ini").keypress(function(){
        mascara(this,mdata);      
        $('#sandbox-container input').datepicker({ minDate: 0});
    });
    
    //Datas
    $('#dt_apontamento_fim').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_apontamento_fim").keypress(function(){
        mascara(this,mdata);      
        $('#sandbox-container input').datepicker({ minDate: 0});
    });
    
    
    fcCarregarLeads();
    fcCarregarColaborador();
    
    
    
    $(".chzn-select").chosen({allow_single_deselect: true});
    

});


