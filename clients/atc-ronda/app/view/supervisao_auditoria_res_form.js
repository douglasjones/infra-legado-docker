var tblResultado;
function fcPesquisar(){

    tblResultado.clear().destroy();
    fcCarregarGrid();

}

function fcIncluir(){   
    sendPost('supervisao_auditoria_cad_form.php',{token: token, pk: ''});
}

function fcExcluir(v_pk, v_leads_pk){

    if (confirm("Deseja realmente excluir o registro '" + v_leads_pk + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("supervisao_auditoria", "excluir", objParametros);

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
    sendPost('supervisao_auditoria_cad_form.php', {token: token, pk: v_pk});
}

function fcDetalhar(v_pk){
    sendPost('supervisao_auditoria_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){
    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "ic_status": $("#ic_status").val()
    };

    var v_url = montarUrlController("supervisao_auditoria", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a title='Detalhar' class='function_det'><span><img width=16 height=16 src='../img/detalhar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a title='Editar' class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a title='Incluir' class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "ds_usuario"},
           {"targets": -3, "data": "dt_execucao"},
           {"targets": -4, "data": "ds_categoria"},
           {"targets": -5, "data": "ds_lead"},
           {"targets": -6, "data": "t_pk"}

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
        fcEditar(data['t_pk']);

    } );

    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_det', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcDetalhar(data['t_pk']);

    } );

    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['t_pk'], data['t_leads_pk']);
    } );

}
function fcCarregarLeads() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listarTodos", objParametros); 
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");
}
function fcCarregarCategorias() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("auditoria_categoria", "listarTodos", objParametros);
    carregarComboAjax($("#auditoria_categoria_pk"), arrCarregar, " ", "pk", "ds_categoria");
}
$(document).ready(function(){
    fcCarregarLeads();    
    fcCarregarCategorias();
    $(".chzn-select").chosen({ allow_single_deselect: true });
    //faz a carga inicial do grid.
    fcCarregarGrid();
    
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});


