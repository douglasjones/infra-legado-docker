var tblResultado;

function fcValidarForm(){
    $("#form").validate({
        rules :{},
        messages:{},
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}

function fcCarregarGrid(){
    sendPost('rel_auditorias_cad_form.php', {token: token, 
        dt_ini:$("#dt_ini").val(),
        dt_fim:$("#dt_fim").val(),
        leads_pk:$("#leads_pk").val(),
        ds_lead:$("#leads_pk :selected").text(),
        supervisores_pk:$("#supervisores_pk").val(),
        ds_supervisor:$("#supervisores_pk :selected").text(),
        categorias_pk:$("#categorias_pk").val(),
        ds_categorias:$("#categorias_pk :selected").text(),
        tipos_categorias_pk:$("#tipos_categorias_pk").val(),
        ds_tipos_categorias:$("#tipos_categorias_pk :selected").text()
    });
}

function fcCancelar(){
    sendPost("menu_relatorios.php", {token: token});
}

function fcCarregarLeads(){           
    var arrCarregar = carregarController("lead", "listarLeadsCombo", "");   
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "leads_pk", "ds_lead");         
}

function fcCarregarAuditoriaCategoria(){           
    var arrCarregar = carregarController("auditoria_categoria", "listarCategoriaCombo", "");   
    carregarComboAjax($("#categorias_pk"), arrCarregar, " ", "pk", "ds_categoria");         
}

function fcCarregarAuditoriaCategoriaTipos(){           
    var arrCarregar = carregarController("auditoria_categoria_tipos", "listarTodos", "");   
    carregarComboAjax($("#tipos_categorias_pk"), arrCarregar, " ", "pk", "ds_auditoria_categoria_tipo");         
}

function fcCarregarSupervisor(){           
    var arrCarregar = carregarController("supervisao_auditoria", "listarComboSupervisores", ""); 
    carregarComboAjax($("#supervisores_pk"), arrCarregar, " ", "supervisores_pk", "ds_supervisor");         
}

$(document).ready(function(){   
    //Combos
    fcCarregarLeads();
    fcCarregarAuditoriaCategoria();
    fcCarregarAuditoriaCategoriaTipos();
    fcCarregarSupervisor();
    
    //Mascaras
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
    });

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
    });

    //Funcionalidades dos botões
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);

});


