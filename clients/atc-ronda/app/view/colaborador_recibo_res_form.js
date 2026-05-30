var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluir(){

    sendPost('colaborador_recibo_cad_form.php',{token: token, colaborador_recibo_pk: ''});

}

function fcExcluir(v_pk, v_colaborador_pk){

    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")){
        if(v_pk != ""){
            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("colaborador_recibo", "excluir", objParametros);   

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
    sendPost('colaborador_recibo_cad_form.php', {token: token, colaborador_recibo_pk: v_pk});
}

function fcPrint(v_pk){

    sendPost('colaborador_recibo_print_form.php', {token: token, colaborador_recibo_pk: v_pk});
}

function fcCarregarGrid(){

    var objParametros = {
        "tipos_recibos_pk":  $("#tipos_recibo_pk").val(),
        "colaborador_pk": $("#colaborador_pk").val(),
        "leads_pk": $("#leads_pk").val(),
        "dt_registro_ini": $("#dt_registro_ini").val(),
        "dt_registro_fim": $("#dt_registro_fim").val()
    };     

    var v_url = montarUrlController("colaborador_recibo", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_print'><span><img width=16 height=16 src='../img/impressora.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "dt_cadastro"},
           {"targets": -3, "data": "ds_lead"},
           {"targets": -4, "data": "ds_colaborador"},
           {"targets": -5, "data": "ds_recibo"},
           {"targets": -6, "data": "pk"}

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
        fcEditar(data['pk']);
        
    } );   

        //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_print', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcPrint(data['pk']);        
    } );   
    
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['pk'], data['colaborador_pk']);
    } );            
    
}

function fclistarTiposRecibos(){    
    var objParametros = {
        "tipos_recibo_pk": $("#tipos_recibo_pk").val()
    };
    var arrCarregar = carregarController("colaborador_recibo", "listarTiposRecibos", objParametros);   
    carregarComboAjax($("#tipos_recibo_pk"), arrCarregar, " ", "pk", "ds_recibo");
}

function fcCarregarColaborador(){
    var objParametros = {
        "leads_pk": $("#leads_pk").val()
    };          
    var arrCarregar = carregarController("colaborador", "listarColaboradoresPK", objParametros); 
    //NewWindow(v_last_url)
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");    
}

function fcCarregarLeads(){
    var objParametros = {
        "pk": ""
    };   
    var arrCarregar = carregarController("lead", "listarTodos", objParametros); 
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");    
}




$(document).ready(function(){
    fclistarTiposRecibos();
    fcCarregarColaborador();    
    fcCarregarLeads()
    $(".chzn-select").chosen({allow_single_deselect: true});


    $('#dt_registro_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", "" ); 
    $("#dt_registro_ini").keypress(function(){
       mascara(this,mdata);
    });

    $('#dt_registro_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", "" ); 
    $("#dt_registro_fim").keypress(function(){
       mascara(this,mdata);
    });

    //faz a carga inicial do grid.
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});


