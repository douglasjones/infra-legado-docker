var tblResultado;
function fcPesquisar(){

    tblResultado.clear().destroy();
    fcCarregarGrid();

}

function fcIncluir(){

    sendPost('veiculo_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_id_veiculo){

    if (confirm("Deseja realmente excluir o registro '" + v_id_veiculo + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("veiculo", "excluir", objParametros);

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
    sendPost('veiculo_cad_form.php', {token: token, pk: v_pk});
}

function fcDetalhar(v_pk){
    sendPost('veiculo_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){


    var objParametros = {
        "id_veiculo": $("#id_veiculo").val(),
        "ds_placa": $("#ds_placa").val(),
        "leads_pk": $("#leads_pk").val(),
        "ic_status": $("#ic_status").val()
    };

    var v_url = montarUrlController("veiculo", "listarDataTable", objParametros);
    //NewWindow(v_last_url)
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a title='Editar' class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a title='Incluir' class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_status"},
           {"targets": -3, "data": "t_ds_lead"},
           {"targets": -4, "data": "t_ds_modelo_veiculo"},
           {"targets": -5, "data": "t_ds_marca_veiculo"},
           {"targets": -6, "data": "t_ds_tipo_veiculo"},
           {"targets": -7, "data": "t_ds_placa"},
           {"targets": -8, "data": "t_id_veiculo"},
           {"targets": -9, "data": "t_pk"}

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
        fcExcluir(data['t_pk'], data['t_id_veiculo']);
    } );

}

function fcCarregarLeads() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);  
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fcCancelar(){

    sendPost("menu_frota.php", {token: token});
}

$(document).ready(function(){

    //faz a carga inicial do grid.
    fcCarregarLeads();
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdVoltar', fcCancelar);
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});


