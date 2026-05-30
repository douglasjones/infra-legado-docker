var tblResultado;
function fcPesquisar() {

    tblResultado.clear().destroy();
    fcCarregarGrid();

}

function fcIncluir() {

    sendPost('processo_default_config_cad.php', { token: token, pk: ' ', processo_default_etapa_pk: ' ' });

}

function fcExcluir(v_pk) {

    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")) {
        if (v_pk != "") {

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("processo_default_configuracao", "excluir", objParametros);
        

            if (arrExcluir.result == 'success') {

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

            }
            else {
                alert('Falhou a requisição de exclusão.');
            }
        }
        else {
            alert("Código não encontrado");
        }
    }
    return false;
}


function fcCarregarGrid() {

    var objParametros = {
        "processos_default_pk": $("#processo_pk").val(),
        "ic_status": $("#ic_status").val(),
        "ds_processo_default_configuracao": $("#ds_processo_default_configuracao option:selected").text()

    };

    var v_url = montarUrlController("processo_default_configuracao", "listarDataTable", objParametros);
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent":   "<a class='function_edit'><span><img width=18 height=18 src='../img/copiar.png' title='Editar o Lead'></span></a>\n\
                &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=18 height=18 src='../img/excluir.png' title='Excluir o Lead'></span></a>"
        },
        { "targets": -2, "data": "t_ic_status"},
        { "targets": -3, "data": "t_n_ordem" },
        { "targets": -4, "data": "t_ds_processo_default_etapa" },
        { "targets": -5, "data": "t_ds_processo_default_configuracao" },
        { "targets": -6, "data": "t_pk" }

        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });


    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcEditar(data['t_pk'], data['t_processos_default_etapas_pk']);

    });

    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcExcluir(data['t_processos_default_etapas_pk']);
    });
}

function fcCarregarprocessoDefault() {
    var objParametros = {
        "pk": ""
    };      

    var arrCarregar = carregarController("processo_default", "listarTodos", objParametros); 

    carregarComboAjax($("#processo_pk"), arrCarregar, " ", "pk", "ds_processo_default");
}

function fcListaProcessosDefault(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("processo_default_configuracao", "listarTodos", objParametros); 
    //NewWindow(v_last_url)
    carregarComboAjax($("#ds_processo_default_configuracao"), arrCarregar, " ", "pk", "ds_processo_default_configuracao");
}

function fcEditar(v_pk, v_processos_default_etapas_pk) {
    sendPost('processo_default_config_cad.php', { token: token, pk: v_pk, processo_default_etapa_pk: v_processos_default_etapas_pk });
}

$(document).ready(function () {

    fcListaProcessosDefault();

    fcCarregarprocessoDefault();

    fcCarregarGrid();
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);
});





