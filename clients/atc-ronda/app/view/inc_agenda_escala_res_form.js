var tblAgenda;
function fcPesquisarGridAgenda() {
    tblAgenda.clear().destroy();
    fcCarregarGridEscala();
}

function atualiza() {
    location.reload();
}
function fcCarregarGridEscala() {

    var v_leads_pk = "";
    var processo_pk = "";
    if (leads_pk != '') {
        v_leads_pk = leads_pk;
    }
    if (pk != '') {
        processo_pk = pk;
    }

    var objParametros = {
        "leads_pk_pesq": $("#leads_pk_pesq_agenda").val(),
        "colaborador_pk_pesq_agenda": $("#colaborador_pk_pesq_agenda").val(),
        "dt_periodo_ini_agenda_pesq": $("#dt_periodo_ini_agenda_pesq").val(),
        "dt_periodo_fim_agenda_pesq": $("#dt_periodo_fim_agenda_pesq").val(),
        "tipo_escala_pesq_agenda": $("#tipo_escala_pesq_agenda").val(),
        "escala_pesq_agenda": $("#escala_pesq_agenda").val(),
        "produtos_pesq_agenda": $("#produtos_pesq_agenda").val(),
        "ic_status_pesq_agenda": $("#ic_status_pesq_agenda").val(),
        "leads_pk": v_leads_pk,
        "processos_pk": pk,
        "setor_contratos_pk": $("#setor_contratos_pk").val()
    };

    var v_url = montarUrlController("agenda_colaborador_padrao", "lisarEscalasResPadrao", objParametros);
 
    //Trata a tabela
    tblAgenda = $('#tblAgenda').DataTable({
        "scrollX": true,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "searching": true,
        "paging": true,
        "bFilter": true,
        "bInfo": true,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
        },
        { "targets": -2, "data": "t_ds_motivo_cancelamento" },

        { "targets": -3, "data": "t_dt_cancelamento" },
        { "targets": -4, "data": "t_dt_periodo_escala" },
        { "targets": -5, "data": "t_status" },
        { "targets": -6, "data": "t_n_qtde_dias_semana" },
        { "targets": -7, "data": "t_ds_produto_servico" },
        { "targets": -8, "data": "t_ds_colaborador" },
        { "targets": -9, "data": "t_ds_identificacao_area" },
        { "targets": -10, "data": "t_ds_lead" },
        { "targets": -11, "data": "t_pk" }
        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });
    //Atribui os eventos na coluna ação.
    $('#tblAgenda tbody').on('click', '.function_edit', function () {
        var data;
        rLinhaSelecionada = null;
        if (tblAgenda.row($(this).parents('li')).data()) {
            data = tblAgenda.row($(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if (tblAgenda.row($(this).parents('tr')).data()) {
            data = tblAgenda.row($(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarAgenda(data);
    });

    $('#tblAgenda tbody').on('click', '.function_delete', function () {
        var data;
        if (tblAgenda.row($(this).parents('li')).data()) {
            data = tblAgenda.row($(this).parents('li')).data();
        }
        else if (tblAgenda.row($(this).parents('tr')).data()) {
            data = tblAgenda.row($(this).parents('tr')).data();
        }

        if (data['t_pk'] != "") {
            fcExcluirAgenda(data['t_pk']);
        }
        tblAgenda.row($(this).parents('tr')).remove().draw();
    });
    return false;
}

function fcComboPesqLead() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listarTodosAtivo", objParametros);

    carregarComboAjax($("#leads_pk_pesq_agenda"), arrCarregar, " ", "pk", "ds_lead");

}

function fcComboSetorContratos() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("contrato", "listarSotorContratos", objParametros);

    carregarComboAjax($("#setor_contratos_pk"), arrCarregar, " ", "ds_identificacao_area", "ds_identificacao_area");

}


function fcComboPesqColaboradores() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("colaborador", "listarColaboradorLead", objParametros);
   
    carregarComboAjax($("#colaborador_pk_pesq_agenda"), arrCarregar, " ", "pk", "ds_colaborador");

}

function fcComboPesqProdutosServicos() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("produto_servico", "listarTodos", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#produtos_pesq_agenda"), arrCarregar, " ", "pk", "ds_produto_servico");

}

function fcIncluir() {
    $("#janela_agendas").modal();
}

$(document).ready(function () {

    //Libera pesquisa    
    if (leads_pk == '' || pk == '') {
        $("#exibir_pesquisa_agenda").show();
        $("#exibir_campos_pesq_hidden").hide();
        fcComboPesqLead();   
       
        fcComboSetorContratos();
 
        fcComboPesqColaboradores();

        $('#dt_periodo_ini_agenda_pesq').datepicker({
            defaultDate: "",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker();
        $("#dt_periodo_ini_agenda_pesq").keypress(function () {
            mascara(this, mdata);
        });

        $('#dt_periodo_fim_agenda_pesq').datepicker({
            defaultDate: "",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker();
        $("#dt_periodo_fim_agenda_pesq").keypress(function () {
            mascara(this, mdata);
        });

        fcComboPesqProdutosServicos();

        $(document).on('click', '#cmdPesquisarAgenda', fcPesquisarGridAgenda);

    } else {

        $("#exibir_pesquisa_agenda").hide();
        $("#exibir_campos_pesq_hidden").show();
    }

    //carregar table escala
    fcCarregarGridEscala();


});    