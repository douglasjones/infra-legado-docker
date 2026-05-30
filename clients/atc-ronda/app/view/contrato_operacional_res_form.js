var tblContratos;
var tblContratoItens = "";
var tblPrdutosItens = "";
function fcPesquisarContrato() {
    
    tblContratos.clear().destroy();
    fcCarregarGridContrato();
}


function fcCarregarLeadsContratoPesq() {
    //Carrega os grupos
    
    var objParametros = {
        "ic_tipo_lead": 2, 
        "leads_pai_pk": $("#leads_clientes_pk").val(),
        "ic_cliente": 1
    };

    var arrCarregar = carregarController("lead", "listarTodosPostTrabalho", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#leads_postotrabalho_pk"), arrCarregar, " ", "pk", "ds_lead");


}
function fcCarregarClientes() {
    //Carrega os grupos
    
    var objParametros = {
        "ic_tipo_lead": 1,
        "ic_cliente": 1
    };

    var arrCarregar = carregarController("lead", "listarTodosClientes", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#leads_clientes_pk"), arrCarregar, " ", "pk", "ds_lead");

}

function fcCarregarGridContrato() {
   

    var objParametros = {
        "leads_postotrabalho_pk": $("#leads_postotrabalho_pk").val(),
        "ic_tipo_contrato": $("#ic_tipo_contrato").val(),
        "dt_inicio_contrato": $("#dt_inicio").val(),
        "dt_fim_contrato": $("#dt_fim").val(),
        "dt_recisao_contrato_ini": $("#dt_recisao_ini").val(),
        "dt_recisao_contrato_fim": $("#dt_recisao_fim").val(),
        "dt_cancelamento_ini": $("#dt_cancelamento_ini").val(),
        "dt_cancelamento_fim": $("#dt_cancelamento_fim").val(),
        "leads_clientes_pk": $("#leads_clientes_pk").val()
    };

    var v_url = montarUrlController("contrato", "listarContratoOperacional", objParametros);
    //NewWindow(v_last_url)
    //Trata a tabela
    tblContratos = $('#tblContratos').DataTable({
        "searching": true,
        "paging":true,
        "serverSide": true,
        "iDisplayLength":10,
        "pageLength":10,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ até _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "ajax": { "url": v_url, "type": "POST", "datatype":"json" },
        "responsive": true,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
        },
        { "targets": -2, "data": "vl_contrato" },
        { "targets": -3, "data": "vl_total_mao_obra" },
        { "targets": -4, "data": "t_vl_total" },
        { "targets": -5, "data": "t_dt_fim_contrato" },
        { "targets": -6, "data": "t_dt_inicio_contrato" },
        { "targets": -7, "data": "t_ds_tipo_contrato" },
        { "targets": -8, "data": "t_ds_identificacao_area" },
        { "targets": -9, "data": "t_ds_lead"},
        { "targets": -10, "data": "ds_tipo_lead"},
        { "targets": -11, "data": "t_pk" }

        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });


    //Atribui os eventos na coluna ação.
    $('#tblContratos tbody').on('click', '.function_edit', function () {
        var data;

        rLinhaSelecionada = null;

        if (tblContratos.row($(this).parents('li')).data()) {
            data = tblContratos.row($(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if (tblContratos.row($(this).parents('tr')).data()) {
            data = tblContratos.row($(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }

        fcEditarContrato(data);

    });

    $('#tblContratos tbody').on('click', '.function_delete', function () {
        var data;

        if (tblContratos.row($(this).parents('li')).data()) {
            data = tblContratos.row($(this).parents('li')).data();
        }
        else if (tblContratos.row($(this).parents('tr')).data()) {
            data = tblContratos.row($(this).parents('tr')).data();
        }

        if (data['t_pk'] != "") {
            fcExcluirContrato(data['t_pk']);
        }
    });

    return false;
}
function fcExcluirContrato(v_pk) {
    if (v_pk != "") {
        var objParametros = {
            "pk": v_pk
        };

        var arrExcluir = carregarController("contrato", "excluir", objParametros);

        if (arrExcluir.result == 'success') {

            //Exibe a mensagem
            alert(arrExcluir.message);
            fcRecarregarGridContratos();
        }
        else {
        }
    }
    else {
        alert("Código não encontrado");
    }
}

function fcRecarregarGridContratosProcessos() {
    tblContratos.ajax.reload();
    //fcCarregarGridContrato();
}

//abre o formulario para a inclusao de um novo contrato.



function fcCancelar() {
    sendPost("menu_operacao.php", { token: token });
}

$(document).ready(function () {
    //carregar combo de elads
    fcCarregarLeadsContratoPesq();
    fcCarregarClientes();
    $(".chzn-select").chosen({ allow_single_deselect: true });

    

    $("#leads_clientes_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcCarregarLeadsContratoPesq();
        $(".chzn-select").chosen({ allow_single_deselect: true });

    });

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisarContratos', fcPesquisarContrato);

    $(document).on('click', '#cmdIncluir', fcIncluirContrato);

    $('#dt_prazo_execucao').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", "");
    $("#dt_prazo_execucao").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_inicio').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", "");
    $("#dt_inicio").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_fim').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", "");
    $("#dt_fim").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_recisao_ini').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", "");
    $("#dt_recisao_ini").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_recisao_fim').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", "");
    $("#dt_recisao_fim").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_cancelamento_ini').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", "");
    $("#dt_cancelamento_ini").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_cancelamento_fim').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", "");
    $("#dt_cancelamento_fim").keypress(function () {
        mascara(this, mdata);
    });

    fcCarregarGridContrato();
 
    $(document).on('click', '#cmdCancelar', fcCancelar);

});





