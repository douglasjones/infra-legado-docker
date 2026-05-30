var tblResultado;
function fcPesquisar() {
    tblResultado.clear().destroy();
    fcCarregarGrid();

}

function fcIncluir() {
    sendPost('analise_financeira_cad_form.php', { token: token, pk: '' });
}

function fcEditar(v_pk) {
    sendPost('analise_financeira_cad_form.php', { token: token, pk: v_pk });
}

function fcCancelar() {
    sendPost('menu_financeiro.php', { token: token, pk: '' });
}



function fcCarregarGrid() {


    var objParametros = {
        "ic_status": $("#ic_status").val(),
        "lancamento_pk": $("#lancamento_pk").val(),
        "dt_cadastro_ini": $("#dt_cadastro_ini").val(),
        "dt_cadastro_fim": $("#dt_cadastro_fim").val(),
        "dt_aprovacao_ini": $("#dt_aprovacao_ini").val(),
        "dt_aprovacao_fim": $("#dt_aprovacao_fim").val(),
        "dt_correcao_ini": $("#dt_correcao_ini").val(),
        "dt_correcao_fim": $("#dt_correcao_fim").val(),
        "dt_recusa_ini": $("#dt_recusa_ini").val(),
        "dt_recusa_fim": $("#dt_recusa_fim").val(),
        "dt_vencimento_ini": $("#dt_vencimento_ini").val(),
        "dt_vencimento_fim": $("#dt_vencimento_fim").val(),
        "usuario_cadastro_lancamento_pk": $("#usuario_cadastro_lancamento_pk").val(),
        "usuario_cadastro_analista_pk": $("#usuario_cadastro_analista_pk").val(),
        "usuario_cadastro_gestor_pk": $("#usuario_cadastro_gestor_pk").val()

    };

    var v_url = montarUrlController("analise_financeira", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "ordering": false,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<a class='function_edit'><span><img width=18 height=18 src='../img/copiar.png' title='Editar o Lead'></span></a>\n\
                                &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=18 height=18 src='../img/excluir.png' title='Excluir o Lead'></span></a>"
        },
        {"targets": -2, "data": "t_dt_recusa"},
        {"targets": -3, "data": "t_dt_correcao"},
        {"targets": -4, "data": "t_dt_aprovacao"},
        {"targets": -5, "data": "t_ic_status" },
        {"targets": -6, "data": "t_dt_lancamento"},
        {"targets": -7, "data": "t_usuario_cadastro_lancamento_pk" },
        {"targets": -8, "data": "t_lancamentos_pk" },
        {"targets": -9, "data": "t_pk" }

        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });


    //Atribui os eventos na coluna ação.

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
        fcExcluir(data['t_pk'], data['t_ds_lead']);
    });


}

function fcCarregarSolicitante() {

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);

    carregarComboAjax($("#usuario_cadastro_lancamento_pk"), arrCarregar, " ", "pk", "ds_usuario");
}

function fcCarregarAnalista() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("usuario", "listarTodosAnalistas", objParametros);
    carregarComboAjax($("#usuario_cadastro_analista_pk"), arrCarregar, " ", "pk", "ds_usuario");
}

function fcCarregarGestor() {
    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("usuario", "listarTodosGestores", objParametros);
    carregarComboAjax($("#usuario_cadastro_gestor_pk"), arrCarregar, " ", "pk", "ds_usuario");
}

$(document).ready(function () {

    fcCarregarGestor();
    fcCarregarAnalista();
    fcCarregarSolicitante();
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdNovo', fcIncluir);
    $(document).on('click', '#cmdCancelar', fcCancelar);

    $('#dt_cadastro_ini').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_cadastro_ini").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_cadastro_fim').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_cadastro_fim").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_aprovacao_ini').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_aprovacao_ini").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_aprovacao_fim').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_aprovacao_fim").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_correcao_ini').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_correcao_ini").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_correcao_fim').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_correcao_fim").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_recusa_ini').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_recusa_ini").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_recusa_fim').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_recusa_fim").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_vencimento_ini').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_vencimento_ini").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_vencimento_fim').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_vencimento_fim").keypress(function () {
        mascara(this, mdata);
    });

});





