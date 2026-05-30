var tblResultado;
var click_id = 0;
function fcValidarForm(){

    $("#form").validate({
        rules :{
		dt_abertura_ini:{
                    required:true
                },
                dt_abertura_fim:{
                    required:true
                }

        },
        messages:{
		dt_abertura_ini:{
                    required:"Por favor, informe a Data Abertura"
                },
                dt_abertura_fim:{
                    required:"Por favor, informe a Data Abertura"
                }

        }
        ,
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function fcCarregarGrid(){
    
   
    
    
    var ds_lead = $("#leads_pk option:selected").text();
    var ds_equipe = $("#equipes_pk option:selected").text();
    sendPost('rel_sla_ocorrencia_cad_form.php', {token: token, 
        leads_pk: $("#leads_pk").val(),
        equipes_pk: $("#equipes_pk").val(),
        dt_abertura_ini:$("#dt_abertura_ini").val(),
        dt_abertura_fim:$("#dt_abertura_fim").val(),
        dt_execucao_ini:$("#dt_execucao_ini").val(),
        dt_execucao_fim:$("#dt_execucao_fim").val(),
        dt_fechamento_ini:$("#dt_fechamento_ini").val(),
        dt_fechamento_fim:$("#dt_fechamento_fim").val(),
        ds_lead:ds_lead,
        ds_equipe:ds_equipe
    });
}


function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
}
function fcCarregarLead(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
    
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");         
}
function fcCarregarEquipe(){
    
    var objParametros = {
        "pk": ""
    };  
    
    
    var arrCarregarLogado = carregarController("equipe", "listarEquipeUsuarioLogado", objParametros);  

    if(arrCarregarLogado.data.length > 0){
        carregarComboAjax($("#equipes_pk"), arrCarregarLogado, "", "pk", "ds_equipe"); 
    }
    else{
        var arrCarregar = carregarController("equipe", "listarTodos", objParametros);
        carregarComboAjax($("#equipes_pk"), arrCarregar, " ", "pk", "ds_equipe"); 
    }
        
}
$(document).ready(function(){    
    /*var arrCarregar = permissao("rel_colaborador", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
           
    //$(document).on('click', '#cmdEnviar', fcCarregarGrid);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
        //Datas
    $('#dt_abertura_ini').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_abertura_ini").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_abertura_fim').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_abertura_fim").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_execucao_ini').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_execucao_ini").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_execucao_fim').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_execucao_fim").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_fechamento_ini').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_fechamento_ini").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_fechamento_fim').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_fechamento_fim").keypress(function(){
        mascara(this,mdata);      
        //$('#sandbox-container input').datepicker({ minDate: 0});
    });
    
   
    fcValidarForm();
   
    fcCarregarLead();

    fcCarregarEquipe();
    

    $(".chzn-select").chosen({allow_single_deselect: true});
});


