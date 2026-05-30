var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluir(){

    sendPost('tarefas_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_ds_tarefas){

    if (confirm("Deseja realmente excluir o registro '" + v_ds_tarefas + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("tarefas", "excluir", objParametros);   

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
    sendPost('tarefas_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){
    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "tarefas_local_pk": $("#tarefas_local_pk").val(),
        "tarefas_area_pk": $("#tarefas_area_pk").val(),        
        "tarefas_tipos_servicos_pk": $("#tarefas_tipos_servicos_pk").val(),        
        "colaborador_pk": $("#colaborador_pk").val()
    };     
    
    var v_url = montarUrlController("agenda_colaborador_tarefa_itens", "listarAgendaTarefas", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_print'><span><img width=20 height=20 src='../img/QrCode.png'></span></a>"
            },
           {"targets": -2, "data": "ds_local"},
           {"targets": -3, "data": "ds_lead"},
           {"targets": -4, "data": "agenda_colaborador_tarefa_pk"}
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcEditar(data['agenda_colaborador_tarefa_pk']);
        
    } );   
    
    $('#tblResultado tbody').on('click', '.function_print', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcPrintQrcode(data['agenda_colaborador_tarefa_pk']);
    } );            
    
}

function fcPrintQrcode(v_pk){
    sendPost('tarefas_qrcode_form.php', {token: token, pk: v_pk});
}

//combos
function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("lead", "listarTodos", objParametros); 
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");    
}
function fcCarregarTarefasTipoServicos(){         
    var objParametros = {

    };   
    var arrCarregar = carregarController("agenda_colaborador_tarefa", "listarTarefasTipoServicos", objParametros);
    carregarComboAjax($("#tarefas_tipos_servicos_pk"), arrCarregar, " ", "pk", "ds_tarefa_tipo_servico");     
}
function fcCarregarColaborador(){   
    var objParametros = {
        "leads_pk": $("#leads_pk").val()
    };          
    var arrCarregar = carregarController("colaborador", "listarColaboradorLead", objParametros); 
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");    
}
function fcCarregarTarfaLocal(){         
    var objParametros = {

    };   
    var arrCarregar = carregarController("agenda_colaborador_tarefa", "listarTarefaLocal", objParametros);
    carregarComboAjax($("#tarefa_local_pk"), arrCarregar, " ", "pk", "ds_local");     
}

function fcCarregarTarfaLocal(){         
    var objParametros = {
        "leads_pk": $("#leads_pk").val()
    };   
    var arrCarregar = carregarController("agenda_colaborador_tarefa", "listarTarefaLocal", objParametros);
    
    carregarComboAjax($("#tarefas_local_pk"), arrCarregar, " ", "pk", "ds_local");     
}

function fcCarregarTarfaArea(){    

    var objParametros = {
        "tarefas_local_pk": $("#tarefas_local_pk").val()
    };   

    var arrCarregar = carregarController("agenda_colaborador_tarefa", "listarTarefaArea", objParametros);

    carregarComboAjax($("#tarefas_area_pk"), arrCarregar, " ", "pk", "ds_area");     
}

$(document).ready(function(){

    //carregar combos / mascara
    fcCarregarLeads();
    fcCarregarTarefasTipoServicos();
    fcCarregarColaborador();

    $("#leads_pk").change(function(){
        $(".chzn-select").chosen('destroy');
        fcCarregarTarfaLocal();
        $(".chzn-select").chosen({allow_single_deselect: true}); 

        $(".chzn-select").chosen('destroy');
        fcCarregarColaborador();        
        $(".chzn-select").chosen({allow_single_deselect: true});   
        
        $(".chzn-select").chosen('destroy');
        fcCarregarColaborador();
        $(".chzn-select").chosen({allow_single_deselect: true});  
    });
    
    $(".chzn-select").chosen({allow_single_deselect: true});
    
    $('#dt_execucao_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate",  ); 
    $("#dt_execucao_ini").keypress(function(){
       mascara(this,mdata);
    });  
    $('#dt_execucao_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate",  ); 
    $("#dt_execucao_fim").keypress(function(){
       mascara(this,mdata);
    });      
    
    
    //faz a carga inicial do grid.
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});


