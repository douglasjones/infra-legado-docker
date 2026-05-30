
function fcCarregar() {
    var objParametros = {
        "pk": ''
    };     
    
    var v_url = montarUrlController("financeiro_import_lancamentos", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                //"defaultContent": "<a class='function_edit'><span><i class='bi bi-pencil-square' style='font-size:18px; color:black' title='EDITAR'></i></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><i class='bi bi-x-circle' style='font-size:18px; color:black' title='EXCLUIR'></i></span></a>"
                "visible": false
            },           
            {"targets": -2, "data": "t_ic_status"},
            {"targets": -3, "data": "t_dt_cadastro"},
            {"targets": -4, "data": "t_ds_usuario_cadstro"},
            {"targets": -5, "data": "t_pk"},

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
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['t_pk'], data['t_ds_arquivo']);
    } );    
}

function fcVoltar() {
    sendPost('menu_financeiro.php', { token: token });
}

function fcImportar() {
    sendPost('financeiro_import_lancamentos_cad.php', { token: token });
}

$(document).ready(function () {
    fcCarregar();
    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImportar', fcImportar);
})


