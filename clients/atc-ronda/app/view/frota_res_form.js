var tblResultado;
function fcPesquisar() {

    tblResultado.clear().destroy();
    fcCarregarGrid();

}

function fcIncluir() {

    sendPost('frota_cad_form.php', { token: token, pk: '' });

}

function fcExcluir(v_pk) {

    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")) {
        if (v_pk != "") {

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("frota_checklist", "excluir", objParametros);

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

function fcEditar(v_pk) {

    sendPost('frota_cad_form.php', { token: token, pk: v_pk });
}


function fcCarregarLeads(){
    var arrCarregar = carregarController("lead", "listarLeadsCombo", "");
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "leads_pk", "ds_lead");
}

function fcCarregarCondutor(){    
    var arrCarregar = carregarController("veiculos_condutores", "listarVeiculos", "");
    carregarComboAjax($("#condutores_pk"), arrCarregar, " ", "condutor_pk", "ds_condutor");      
}

function fcCarregarFrota(){
    var arrCarregar = carregarController("frota", "listarTodos", "");
    carregarComboAjax($("#id_veiculo"), arrCarregar, " ", "pk", "id_veiculo");
}

function fcCarregarUsuarioCadastro(){
    var arrCarregar = carregarController("frota", "listarTodos", "");
    carregarComboAjax($("#usuario_cadastro_pk"), arrCarregar, " ", "usuario_cadastro_pk", "ds_usuario");
}

function fcCarregarGrid() {
    var objParametros = {
        "condutores_pk": $("#condutores_pk").val(),
        "leads_pk": $("#leads_pk").val(),
        "frota_pk": $("#id_veiculo").val(),
        "dt_ini_checklist": $("#dt_ini_checklist").val(),
        "dt_fim_checklist": $("#dt_fim_checklist").val(),
        "usuario_cadastro_pk": $("#usuario_cadastro_pk").val()
    };

    var v_url = montarUrlController("frota_checklist", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<a class='function_painel'><span><a class='function_edit'><span><img width=18 height=18 src='../img/copiar.png' title='Editar o Lead'></span></a>\n\
                                  &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=18 height=18 src='../img/excluir.png' title='Excluir o Lead'></span></a>"
        },
        { "targets": -2, "data": "t_id_veiculo" },
        { "targets": -3, "data": "t_ds_condutor" },
        { "targets": -4, "data": "t_ds_lead" },
        { "targets": -5, "data": "t_pk" }

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
        fcEditar(data['t_pk']);

    });

    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcExcluir(data['t_pk']);
    });

}

$(document).ready(function () {
    
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

    //carrega datepicker com a data atual (Agenda)
    $('#dt_fim_checklist').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_fim_checklist").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_ini_checklist').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_ini_checklist").keypress(function () {
        mascara(this, mdata);
    });
    
    fcCarregarLeads();              
    fcCarregarCondutor();              
    fcCarregarFrota();  
    fcCarregarUsuarioCadastro();            
    fcCarregarGrid();              

});
