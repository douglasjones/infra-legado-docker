var tblResultado;
function fcPesquisar(){
    tblResultado.clear().destroy();
    fcCarregarGrid();
}

function fcIncluir(){
    sendPost('auditoria_supervisao_postos_trabalho_cad_form.php',{token: token, pk: ''});
}

function fcCarregarPostoTrabalho(){
    var objParametros = {
        
    };

    var arrCarregar = carregarController("lead", "listarLeadsCombo", objParametros);
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "leads_pk", "ds_lead");
}

function fcCarregarCategorias(){
    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("auditoria_categoria", "listarCategoriaCombo", objParametros);
    carregarComboAjax($("#auditoria_categorias_pk"), arrCarregar, " ", "pk", "ds_categoria");
}

function fcCarregarTiposCategorias(auditoria_categorias_pk){
    var objParametros = {
        "auditoria_categorias_pk": auditoria_categorias_pk
    };

    var arrCarregar = carregarController("auditoria_categoria_tipos", "listarPorAuditoriaCategoriasPk", objParametros);
    carregarComboAjax($("#auditoria_categoria_tipos_pk"), arrCarregar, " ", "pk", "ds_auditoria_categoria_tipo");
}

function fcCarregarGrid(){
    var objParametros = {
        
    };

    var v_url = montarUrlController("supervisao_auditoria", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
        "ordering": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a title='Editar' class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a title='Excluir' class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "ds_tipo_categoria"},
           {"targets": -3, "data": "ds_categoria"},
           {"targets": -4, "data": "ds_lead"},
           {"targets": -5, "data": "pk"}

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

    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['pk']);
    } );

}

function fcEditar(v_pk){
    sendPost('auditoria_supervisao_postos_trabalho_cad_form.php', {token: token, pk: v_pk});
}

function fcExcluir(v_pk){

    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")){
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

$(document).ready(function(){

    fcCarregarPostoTrabalho();
    fcCarregarCategorias();
    $('#auditoria_categorias_pk').change(function(){
        var auditoria_categorias_pk = $('#auditoria_categorias_pk').val();
        fcCarregarTiposCategorias(auditoria_categorias_pk);
    });

    //faz a carga inicial do grid.
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});