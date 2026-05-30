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
                required:"Por favor, informe uma data inicial!"
            },
            dt_fim:{
                required:"Por favor, informe uma data final!"
            }
        },
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcCarregarGrid(){
    
    var v_ds_colaborador = $("#colaboradores_pk option:selected").text()
    var v_ds_lead = $("#ds_lead option:selected").text()
    sendPost('rel_ponto_sistema_colaborador_cad_form.php', {token: token, colaboradores_pk: $("#colaboradores_pk").val(),ds_colaboradores: v_ds_colaborador,dt_ini: $("#dt_ini").val(),dt_fim: $("#dt_fim").val(),leads_pk: $("#ds_lead").val(),ds_lead: v_ds_lead});
}

function fcCarregarColaborador(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("colaborador", "listarTodosRel", objParametros);    
    carregarComboAjax($("#colaboradores_pk"), arrCarregar, " ", "pk", "ds_colaborador");
        
}

function fcCancelar(){

    sendPost("menu_relatorios_ponto_falta.php", {token: token});
}
function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
    
    carregarComboAjax($("#ds_lead"), arrCarregar, " ", "pk", "ds_lead");        
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
    fcCarregarColaborador();
    
    $(".chzn-select").chosen({allow_single_deselect: true});
    
    $("#ds_ano").keypress(function(){
        mascara(this, soNumeros);
    });

});


