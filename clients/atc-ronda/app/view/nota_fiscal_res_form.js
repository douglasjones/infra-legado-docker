var tblResultado;
function fcPesquisar(){

    tblResultado.clear().destroy();
    fcCarregarGrid();

}

function fcIncluir(){

    sendPost('nota_fiscal_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_ds_tipo_servico){

    if (confirm("Deseja realmente excluir o registro '" + v_ds_tipo_servico + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("nota_fiscal", "excluir", objParametros);

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
    sendPost('nota_fiscal_cad_form.php', {token: token, pk: v_pk});
}

function fcDetalhar(v_pk){
    sendPost('nota_fiscal_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){


    var objParametros = {
        "ds_tipo_servico": $("#ds_tipo_servico").val(),
        "ic_status": $("#ic_status").val()
    };

    var v_url = montarUrlController("nota_fiscal", "listarDataTable", objParametros);
    NewWindow(v_last_url)

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

           {"targets": -2, "data": "t_vl_liquido"},
           {"targets": -3, "data": "t_vl_bruto"},
           {"targets": -4, "data": "t_dt_emissao"},
           {"targets": -5, "data": "t_ds_tipo_servico"},
           {"targets": -6, "data": "t_ds_lead"},
           {"targets": -7, "data": "t_pk"}

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
        fcExcluir(data['t_pk'], data['t_ds_tipo_servico']);
    } );

}



$(document).ready(function(){

    //faz a carga inicial do grid.
    //fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});


