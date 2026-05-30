var tblResultado;
function fcPesquisar(){
    tblResultado.clear().destroy();
    fcCarregarGrid();
}
function fcIncluir(){
    sendPost('teto_gasto_cad_form.php',{token: token, pk: ''});
}

function fcExcluir(v_pk){

    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("teto_gastos", "excluir", objParametros);

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
    sendPost('teto_gasto_cad_form.php', {token: token, pk: v_pk});
}

function fcDetalhar(v_pk){
    sendPost('teto_gasto_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){
try {
    var objParametros = {
        "tipo_grupo_pk": $("#tipo_grupo_pk").val(),
        "grupo_leancamento_pk": $("#grupo_leancamento_pk").val(),
        "grupo_lancamento_centro_custo_pk": $("#grupo_lancamento_centro_custo_pk").val(),
        "posto_trabalho_pk": $("#posto_trabalho_pk").val(),
        "contratos_pk": $("#contratos_pk").val(),
        "ds_ano_vigente_teto": $("#ds_ano_vigente_teto").val(),
        "ic_status": $("#ic_status").val()
    };

    var v_url = montarUrlController("teto_gastos", "listarDataTable", objParametros);
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
            {"targets": -2, "data": "t_ic_status"}, 
            {"targets": -3, "data": "t_vl_utilizado_atual"},
            {"targets": -4, "data": "t_vl_total_teto"},
            {"targets": -5, "data": "t_ds_ano_vigente_teto"},
            {"targets": -6, "data": "t_contratos_pk"},
            {"targets": -7, "data": "t_leads_posto_trabalho_pk"},
            {"targets": -8, "data": "t_grupo_leancamento_pk"},
            {"targets": -9, "data": "t_tipo_grupo_pk"},
            {"targets": -10, "data": "t_pk"}

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
        fcExcluir(data['t_pk'], data['t_tipo_origem_teto_gastos']);
    } );

} catch (error) {
    alert(error)
}
    
}

function  fcVoltar(){
    sendPost("menu_financeiro.php", {token: token});
}

function fccarregarLeadsClientes() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listaLeadsClientes", objParametros);
    carregarComboAjax($("#grupo_leancamento_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarLeadsPostosTrabalho() {
    var objParametros = {
        "pk": $("#grupo_leancamento_pk").val()
    };
    var arrCarregar = carregarController("lead", "listaLeadsPostosTrabalho", objParametros);
    carregarComboAjax($("#posto_trabalho_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarLeadsContratos() {
    var objParametros = {
        "leads_pk": $("#posto_trabalho_pk").val()
    };
    var arrCarregar = carregarController("contrato", "listaLeadContratos", objParametros);
    carregarComboAjax($("#contratos_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fccarregarColaboradorContratos() {

    var objParametros = {
        "leads_pk": $("#posto_trabalho_pk").val(),
        "colaborador_pk": $("#colaborador_pk").val()
    };
    var arrCarregar = carregarController("contrato", "listaColaboradorContratos", objParametros);
    carregarComboAjax($("#contratos_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fccarregarColaborador() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("colaborador", "listaColaborador", objParametros);
    carregarComboAjax($("#grupo_leancamento_pk"), arrCarregar, " ", "colaborador_pk", "ds_colaborador");
}

function fccarregarColaboradorPostosTrabalho() {

    var objParametros = {
        "colaborador_pk": $("#grupo_leancamento_pk").val(),
    };
    var arrCarregar = carregarController("lead", "listaColaboradorPostosTrabalho", objParametros);
    carregarComboAjax($("#posto_trabalho_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarFornecedor() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("fornecedor", "listarTodos", objParametros);
    carregarComboAjax($("#grupo_leancamento_pk"), arrCarregar, " ", "pk", "ds_fornecedor");
}

function fccarregarFornecedorPostosTrabalho() {

    var objParametros = {
        "leads_pk": $("#grupo_lancamento_centro_custo_pk").val()
    };
    var arrCarregar = carregarController("lead", "listaFornecedorPostosTrabalho", objParametros);
    carregarComboAjax($("#posto_trabalho_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarLeadsClientesCentroCustoForncedor() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listaLeadsClientes", objParametros);
    carregarComboAjax($("#grupo_lancamento_centro_custo_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarFornecedorContratos() {
    var objParametros = {
        "leads_pk": $("#posto_trabalho_pk").val()
    };
    var arrCarregar = carregarController("contrato", "listaLeadContratos", objParametros);
    carregarComboAjax($("#contratos_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fcSelecionaGrupo() {

    $("#div_grupo_lancamento_centro_custo").hide()
    if ($("#tipo_grupo_pk").val() == 1) {
        fccarregarLeadsClientes();
    } else if ($("#tipo_grupo_pk").val() == 2) {
        fccarregarColaborador();
    } else if ($("#tipo_grupo_pk").val() == 3) {
        $("#div_grupo_lancamento_centro_custo").show()
        fccarregarFornecedor();
        fccarregarLeadsClientesCentroCustoForncedor();
    }
}

$(document).ready(function(){

    $("#tipo_grupo_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcSelecionaGrupo();
        
        if($("#tipo_grupo_pk").val() == '1'){
            $("#grupo_leancamento_pk").change(function () {
                $(".chzn-select").chosen('destroy');
                fccarregarLeadsPostosTrabalho();
            });
            
            $("#posto_trabalho_pk").change(function () {
                $(".chzn-select").chosen('destroy');
                fccarregarLeadsContratos();
            });
        }
        if($("#tipo_grupo_pk").val() == '2'){
            $("#grupo_leancamento_pk").change(function () {
                $(".chzn-select").chosen('destroy');
                fccarregarColaboradorPostosTrabalho();
            });
        
            $("#posto_trabalho_pk").change(function () {
                $(".chzn-select").chosen('destroy');
                fccarregarColaboradorContratos()
            });
        }
        if($("#tipo_grupo_pk").val() == '3'){
            $("#grupo_leancamento_pk").change(function () {
                $(".chzn-select").chosen('destroy');
                fccarregarFornecedorPostosTrabalho();
            });
        
            $("#posto_trabalho_pk").change(function () {
                $(".chzn-select").chosen('destroy');
                fccarregarFornecedorContratos()
            });
        }
    });

    //faz a carga inicial do grid.
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);
    $(document).on('click', '#cmdVoltar', fcVoltar);


});


