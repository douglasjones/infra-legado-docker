function fcValidarForm(){

    $("#form").validate({
        rules :{
            leads_pk:{
                required:true
            },
            dt_periodo_ini:{
                required: true
            },
            dt_periodo_fim:{
                required: true
            },
            ds_endereco:{
                required:true,
                minlength:3
            },
            ic_cliente:{
                required:true
            }

        },
        messages:{
            leads_pk:{
                required:"Por favor, selecione Lead"
            },
            dt_periodo_ini:{
                required:"Por favor, informe Período início"
            },
            dt_periodo_fim:{
                required:"Por favor, informe Período fim"
            }
        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    sendPost('rel_agenda_condominio_cad_form.php',{token: token, leads_pk: $("#leads_pk").val(),dt_periodo_ini: $("#dt_periodo_ini").val(),dt_periodo_fim: $("#dt_periodo_fim").val()});

}

function fcExcluir(v_pk, v_ds_lead){

    if (confirm("Deseja realmente excluir o registro '" + v_ds_lead + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("lead", "excluir", objParametros);   

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

            }
            else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}

function fcEditar(v_pk){
    sendPost('agenda_condominio_cad_form.php', {token: token, leads_pk: v_pk});
}

function fcCarregarLead(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");
        
}
$(document).ready(function(){
    var arrCarregar = permissao("rel_condominio", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    var dtHoje = new Date();
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    
    fcCarregarLead();
    //carrega datepicker com a data de diferenca de 1 mes 
    $('#dt_periodo_ini').datepicker({defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            changeMonth: false,
            numberOfMonths: 1,
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker("setDate", new Date(dtHoje.getFullYear(),(dtHoje.getMonth()-1),dtHoje.getDate()));
    
    
    $("#dt_periodo_ini").keypress(function(){
        mascara(this, mdata);
    });
    //carrega datepicker com a data atual
    $('#dt_periodo_fim').datepicker({defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            changeMonth: false,
            numberOfMonths: 1,
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker("setDate", new Date() );
    
    
    $("#dt_periodo_fim").keypress(function(){
        mascara(this, mdata);
    });

});


