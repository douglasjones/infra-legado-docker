var IntContratosPk = "0";
function fcPesquisar() {

    tblResultado.clear().destroy();
    fcCarregarGridConjuntoMateriais();

}

function fcCarregarCategorias() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);
    carregarComboAjax($("#categoria_res_pk"), arrCarregar, " ", "pk", "ds_categoria");
    carregarComboAjax($("#categorias_produto_pk"), arrCarregar, " ", "pk", "ds_categoria");
}

function fcCarregarProdutos(categorias_produto_pk) {
    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros);

    carregarComboAjax($("#produtos_res_pk"), arrCarregar, " ", "pk", "ds_produto");
    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");
}


function fcVerificarMovimentadoParaIns() {
    $("#str_opc_ins").text("");
    if ($("#grupo_para_movimentacao_ins_pk").val() == 1) {

        $("#str_opc_ins").text("Colaborador(es)");
        var objParametros = {
            "pk": ""
        };
        var arrCarregar = carregarController("colaborador", "listarColaboradorLead", objParametros);
        carregarComboAjax($("#movimentar_para_pk"), arrCarregar, " ", "pk", "ds_colaborador");
    }
    else if ($("#grupo_para_movimentacao_ins_pk").val() == 2) {
        $("#str_opc_ins").text("Posto(s) de Trabalho");
        var objParametros = {
            "pk": ""
        };
        var arrCarregar = carregarController("lead", "listarTodos", objParametros);
        carregarComboAjax($("#movimentar_para_pk"), arrCarregar, " ", "pk", "ds_lead");
    }

}

function fcVerificarMovimentadoPara() {
    $("#str_opc").text("");
    if ($("#grupo_para_movimentacao_pk").val() == 1) {

        $("#str_opc").text("Colaborador(es)");
        var objParametros = {
            "pk": ""
        };
        var arrCarregar = carregarController("colaborador", "listarTodos", objParametros);
        carregarComboAjax($("#movimentar_para_pesq_pk"), arrCarregar, " ", "pk", "ds_colaborador");
    }
    else if ($("#grupo_para_movimentacao_pk").val() == 2) {
        $("#str_opc").text("Posto(s) de Trabalho");
        var objParametros = {
            "pk": ""
        };
        var arrCarregar = carregarController("lead", "listarTodos", objParametros);
        carregarComboAjax($("#movimentar_para_pesq_pk"), arrCarregar, " ", "pk", "ds_lead");
    }

}



function pegarPkProdutosItensNotIn(produtos_itens_pk_res) {
    try {
        var produtos_itens_pk = "";

        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "produtos_itens_pk";

        var data = tblResultado.rows().data();

        for (i = 0; i < data.length; i++) {
            if (produtos_itens_pk_res != data[i]['produtos_itens_pk']) {
                produtos_itens_pk = data[i]['produtos_itens_pk'];
                arrDados[i] = [produtos_itens_pk];
            }


        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch (err) {
        alert(err);
    }
}
function fcCarregarProdutosItens(produtos_pk, produtos_itens_pk) {

    var colaborador_pk = "";
    var leads_pk = "";

    if ($("#grupo_para_movimentacao_pk").val() == 1) {
        var colaborador_pk = $("#movimentar_para_pesq_pk").val();
    }
    else if ($("#grupo_para_movimentacao_pk").val() == 2) {
        var leads_pk = $("#movimentar_para_pesq_pk").val();
    }

    var objParametros = {
        "produtos_pk": produtos_pk,
        "leads_pk": leads_pk,
        "colaborador_pk": colaborador_pk,
        "produtos_itens_pk": produtos_itens_pk
        //"strProdutoGrid":strProdGrid
    };

    var arrCarregar = carregarController("produto_iten", "listarPorPkProdutoNotIn", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#produtos_itens_pk"), arrCarregar, " ", "pk", "ds_produto_item");

    $("#count_material").val(arrCarregar.data.length);
}



var tblMaterial;
function fcCarregarGridConjuntoMateriais() {



    var v_colaborador_pk = "";
    var v_leads_pk = "";
    var contratos_pk = "";




    if ($("#contratos_pk").val() == undefined) {
        var IntContratosPk = "";
    }
    else {
        if ($("#contratos_pk").val() != "") {
            var IntContratosPk = $("#contratos_pk").val();
        }
        else {
            var IntContratosPk = "0";
        }

    }


    if ($("#grupo_para_movimentacao_pk").val() == 1) {
        var v_colaborador_pk =colaborador_pk;
    }
    else if ($("#grupo_para_movimentacao_pk").val() == 2) {
        var v_leads_pk = leads_pk;
        if (IntContratosPk != "") {
            contratos_pk = IntContratosPk;
        }
    }





    var objParametros = {
        "leads_pk": v_leads_pk,
        "colaborador_pk": v_colaborador_pk,
        "contratos_pk": contratos_pk,
        "categoria_pk": $("#categoria_res_pk").val(),
        "produtos_pk": $("#produtos_res_pk").val(),
        "grupo_para_movimentacao_pk": $("#grupo_para_movimentacao_pk").val(),
        "dt_movimentacao_ini": $("#dt_movimentacao_ini").val(),
        "dt_movimentacao_fim": $("#dt_movimentacao_fim").val()
    };

var v_url = montarUrlController("conjunto_material", "listarMovimentarMaterialProd", objParametros);
//NewWindow(v_last_url)
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
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
            "defaultContent": "<a class='function_painel'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/impressora.png'></span></a>"
        },
        { "targets": -2, "data": "dt_cadastro" },
        { "targets": -3, "data": "qtde" },
        /*{"targets": -4, "data": "ds_produto"},  */
        { "targets": -4, "data": "ds_categoria" },
        { "targets": -5, "data": "ds_movimentado" },
        { "targets": -6, "data": "ds_grupo_movimentado" },
        { "targets": -7, "data": "conjunto_material_pk" }
        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });

    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_painel', function () {
        var data;

        //rLinhaSelecionada = null;

        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
            //rLinhaSelecionada = $(this).parents('li');
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
            //rLinhaSelecionada = $(this).parents('tr');
        }

        fcEditarConjuntoMaterialProd(data);

    });
    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;

        //rLinhaSelecionada = null;

        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
            //rLinhaSelecionada = $(this).parents('li');
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
            //rLinhaSelecionada = $(this).parents('tr');
        }
        if (data['colaborador_pk'] != null) {
            fcImprimirConjuntoMaterial(data);
        }
        else {
            alert("Posto de Trabalho não gera impressão!");

        }


    });

    return false;
}

function fcImprimirConjuntoMaterial(objRegistro) {
    if (colaborador_pk != "") {
        sendPost('impressao_material.php', { token: token, pk: colaborador_pk, leads_pk: objRegistro['leads_pk'], conjunto_material_pk: objRegistro['conjunto_material_pk'], local: "" });
    }
    else {
        sendPost('impressao_material.php', { token: token, pk: objRegistro['colaborador_pk'], leads_pk: objRegistro['leads_pk'], conjunto_material_pk: objRegistro['conjunto_material_pk'], local: 2 });
    }

}

function fcCarregarGridMateriais() {
    var colaborador_pk = "";
    var leads_pk = "";
    var contratos_pk = "";
    
    if ($("#contratos_pk").val() == undefined) {
        var IntContratosPk = "";
    }
    else {
        if ($("#contratos_pk").val() != "") {
            var IntContratosPk = $("#contratos_pk").val();
        }
        else {
            var IntContratosPk = "0";
        }

    }

    if ($("#grupo_para_movimentacao_ins_pk").val() == 1) {
        var colaborador_pk = $("#movimentar_para_pk").val();
    }
    else if ($("#grupo_para_movimentacao_ins_pk").val() == 2) {
        var leads_pk = $("#movimentar_para_pk").val();
        if (IntContratosPk != "") {
            contratos_pk = IntContratosPk;
        }
    }

    var objParametros = {
        "leads_pk": leads_pk,
        "colaborador_pk": colaborador_pk,
        "contratos_pk": contratos_pk,
        "conjunto_material_pk": $("#conjunto_material_pk").val()
    };

    var v_url = montarUrlController("movimentacao_estoque", "listar_por_pk_conjunto", objParametros);
    //NewWindow(v_last_url)
    
    //Trata a tabela
    tblMaterial = $('#tblMaterial').DataTable({
        "scrollX": false,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "searching": true,
        "paging": true,
        "bFilter": true,
        "bInfo": false,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<!--a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a-->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><i class='bi bi-x-circle' style='font-size:18px; color:black' title='EXCLUIR'></i></span></a>"
        },
        { "targets": -2, "data": "ds_ic_mateiral_carga" },
        { "targets": -3, "data": "ic_mateiral_carga", visible: false },
        { "targets": -4, "data": "obs_material" },
        { "targets": -5, "data": "dt_devolucao" },
        { "targets": -6, "data": "dt_entrega" },
        { "targets": -7, "data": "produtos_itens_pk", visible: false },
        { "targets": -8, "data": "ds_produtos_itens" },
        { "targets": -9, "data": "produtos_pk", visible: false },
        { "targets": -10, "data": "ds_produtos" },
        { "targets": -11, "data": "categorias_produto_pk", visible: false },
        { "targets": -12, "data": "ds_categorias_produto" },
        { "targets": -13, "data": "pk" },
        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });

    //Atribui os eventos na coluna ação.
    /*$('#tblMaterial tbody').on('click', '.function_edit', function () {
         var data;
        
        rLinhaSelecionadaMaterial = null;
        
        if(tblMaterial.row( $(this).parents('li')).data()){
            data = tblMaterial.row( $(this).parents('li')).data();
            rLinhaSelecionadaMaterial = $(this).parents('li');
        }
        else if(tblMaterial.row( $(this).parents('tr')).data()){
            data = tblMaterial.row( $(this).parents('tr')).data();
            rLinhaSelecionadaMaterial = $(this).parents('tr');
        }
        
        fcEditarMaterial(data);
     
    } );  */


    $('#tblMaterial tbody').on('click', '.function_painel', function () {
        var data;

        rLinhaSelecionadaMaterial = null;

        if (tblMaterial.row($(this).parents('li')).data()) {
            data = tblMaterial.row($(this).parents('li')).data();
            rLinhaSelecionadaMaterial = $(this).parents('li');
        }
        else if (tblMaterial.row($(this).parents('tr')).data()) {
            data = tblMaterial.row($(this).parents('tr')).data();
            rLinhaSelecionadaMaterial = $(this).parents('tr');
        }
        if (data['pk'] != "") {
            fcExcluirMaterial(data['pk']);
        }
        tblMaterial.row($(this).parents('tr')).remove().draw();



    });



    return false;
}

function fcExcluirMaterial(v_pk) {

    if (v_pk != "") {
        var objParametros = {
            "pk": v_pk
        };

        var arrExcluir = carregarController("movimentacao_estoque", "excluir", objParametros);

        if (arrExcluir.result == 'success') {

            //Exibe a mensagem
            alert(arrExcluir.message);
            fcRecarregarGridMateriais();

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
function fcEditarMaterial(objRegistro) {


    fcLimparFormMaterial();

    $(".chzn-select").chosen('destroy');

    fcCarregarProdutosItens(objRegistro['produtos_pk'], objRegistro['produtos_itens_pk']);


    $("#div_dt_devolucao").show();
    $("#movimentacao_estoque_pk").val("");
    $("#acao").val("upd");

    //Carrega as informações da linha selecionada.
    $("#movimentacao_estoque_pk").val(objRegistro['pk']);
    $("#categorias_produto_pk").val(objRegistro['categorias_produto_pk']);
    $("#produtos_pk").val(objRegistro['produtos_pk']);
    $("#produtos_itens_pk").val(objRegistro['produtos_itens_pk']);
    $("#dt_entrega").val(objRegistro['dt_entrega']);
    $("#dt_devolucao").val(objRegistro['dt_devolucao']);
    $("#observacao_material").val(objRegistro['obs_material']);
    $("input[id=ic_mateiral_carga]").prop("checked", false);
    if (objRegistro['ic_mateiral_carga'] == 1) {
        $("input[id=ic_mateiral_carga]").prop("checked", "true");
    }
    else {
        $("input[id=ic_mateiral_carga]").prop("checked", false);
    }
    $("#qtde_materias").val(1);
    $("#produtos_itens_pk").prop('disabled', false);
    $("#qtde_materias").prop('disabled', true);





    $(".chzn-select").chosen({ allow_single_deselect: true });

}

function fcEditarConjuntoMaterialProd(objRegistro) {
    $(".chzn-select").chosen('destroy');
    if ($('#janela_materiais').is(':visible') == false) {
        //$("#janela_materiais").modal();

        //fcLimparFormMaterial();
        $(".chzn-select").chosen('destroy');


        //limpa os dados de qualquer registro existe
        //fcCarregarProdutos("");
        //fcCarregarProdutosItens("","");
        //$("#conjunto_material_pk").val("");
        $("#ds_conjunto_material").val("");
        $("#grupo_para_movimentacao_ins_pk").val("");
        $("#movimentar_para_pk").val("");
        $("#str_opc_ins").text("");
        $("#conjunto_material_pk").val("");
        $("#contratos_pk").val("");
        $("#janela_materiais").modal();

        $("#movimentar_para_pk").prop('disabled', false);
        $("#grupo_para_movimentacao_ins_pk").prop('disabled', false);







        $("#grupo_para_movimentacao_ins_pk").val("");
        $("#movimentar_para_pk").val("");

        $("#grupo_para_movimentacao_ins_pk").val(objRegistro['grupo_para_movimentacao_pk']);



        fcVerificarMovimentadoParaIns();


        if ($("#grupo_para_movimentacao_ins_pk").val() == 1) {
            $("#movimentar_para_pk").val(objRegistro['colaborador_pk']);
        }
        else if ($("#grupo_para_movimentacao_ins_pk").val() == 2) {
            $("#movimentar_para_pk").val(objRegistro['leads_pk']);
        }



        $("#ds_conjunto_material").val("");
        $("#conjunto_material_pk").val("");
        $("#movimentacao_estoque_pk").val("");
        $("#contratos_pk").val(objRegistro['contratos_pk']);


        $("#movimentar_para_pk").prop('disabled', true);
        $("#grupo_para_movimentacao_ins_pk").prop('disabled', true);

        $("#categorias_produto_pk").val("");
        $("#produtos_pk").val("");
        $("#produtos_itens_pk").val("");
        $("#dt_entrega").val("");
        $("#dt_devolucao").val("");
        $("#observacao_material").val("");
        $("#conjunto_material_pk").val(objRegistro['conjunto_material_pk']);
        $("#ds_conjunto_material").val(objRegistro['ds_conjunto_material']);

        tblMaterial.clear().destroy();
        fcCarregarGridMateriais();

        setTimeout(function () { $(".chzn-select").chosen({ allow_single_deselect: true }); }, 3000);
    }

    $(".chzn-select").chosen('destroy');



}

function fcValidarFormModalMateriais() {
    $("#form_materiais").validate({
        rules: {
            ds_conjunto_material: {
                required: true
            }
        },
        messages: {
            ds_conjunto_material: {
                required: "Por favor, informe Descrição Conjunto Material"
            }
        },
        submitHandler: function (form) {
            fcEnviarConjuntoMateriais(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}

function fcEnviarConjuntoMateriais() {
    fcSalvarConjuntoMateriais();
}

function fcValidarMaterial() {


    if ($("#grupo_para_movimentacao_ins_pk").val() == "") {
        $("#alert_grupo_para_movimentacao").show();
        $("#alert_grupo_para_movimentacao").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_grupo_para_movimentacao").slideUp(500);
        });
        return false;
    }
    if ($("#grupo_para_movimentacao_ins_pk").val() == 1) {
        if ($("#movimentar_para_pk").val() == "") {
            $("#alert_movimentar_colaborador").show();
            $("#alert_movimentar_colaborador").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_movimentar_colaborador").slideUp(500);
            });
            return false;
        }
    }
    if ($("#grupo_para_movimentacao_ins_pk").val() == 2) {
        if ($("#movimentar_para_pk").val() == "") {
            $("#alert_movimentar_lead").show();
            $("#alert_movimentar_lead").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_movimentar_lead").slideUp(500);
            });
            return false;
        }
    }



    if ($('#categorias_produto_pk').val() == "") {
        $("#alert_categoria").show();
        $("#alert_categoria").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_categoria").slideUp(500);
        });
        $('#categorias_produto_pk').focus();
        return false;
    }
    if ($('#produtos_pk').val() == "") {
        $("#alert_produto").show();
        $("#alert_produto").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_produto").slideUp(500);
        });
        $('#produtos_pk').focus();
        return false;
    }
    if ($("#qtde_materias").val() == "" || $("#qtde_materias").val() == 0) {
        if ($('#produtos_itens_pk').val() == "") {
            $("#alert_produtos_itens_pk").show();
            $("#alert_produtos_itens_pk").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_produtos_itens_pk").slideUp(500);
            });
            $('#produtos_itens_pk').focus();
            return false;
        }
    }
    if ($('#dt_entrega').val() == "") {
        $("#alert_dt_entrega").show();
        $("#alert_dt_entrega").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_dt_entrega").slideUp(500);
        });
        $('#dt_entrega').focus();
        return false;
    }

    if ($("#qtde_materias").val() > 0) {
        if (parseInt($("#count_material").val()) < parseInt($("#qtde_materias").val())) {
            alert("Quantidade disponível em estoque inferior. Quantidade disponivel " + $("#count_material").val());
            return false;
        }
    }




    return true;
}
function fcIncluirMateriais() {
    if ($("#conjunto_material_pk").val() == "") {
        if ($("#acao").val() == "ins") {
            if (fcValidarMaterial()) {

                fcIncluirMateriaisSemPk();
                fcLimparFormMaterial();
            }
        }
        else if ($("#acao").val() == "upd") {
            if (fcValidarMaterial()) {
                fcEditarMateriaisSemPk();
                fcLimparFormMaterial();
            }
        }
    }
    else {
        if (fcValidarMaterial()) {
            fcSalvarMateriais();
        }

    }



}

function fcSalvarMateriais() {

    var v_movimentacao_estoque_pk = $("#movimentacao_estoque_pk").val();
    var v_produtos_itens_pk = $("#produtos_itens_pk").val();
    var v_dt_entrega = $("#dt_entrega").val();
    if ($("#movimentacao_estoque_pk").val() != "") {
        var v_dt_devolucao = $("#dt_devolucao").val();
    } else {
        var v_dt_devolucao = "";
    }
    var v_obs_material = $("#observacao_material").val();



    if ($("#ic_mateiral_carga").is(":checked") == true) {
        var ds_ic_mateiral_carga = "Sim";
        var ic_mateiral_carga = 1;
    }
    else {
        var ds_ic_mateiral_carga = "Não";
        var ic_mateiral_carga = 2;
    }


    var colaborador_pk = "";
    var leads_pk = "";
    var contratos_pk = "";


    if ($("#contratos_pk").val() == undefined) {
        var IntContratosPk = "";
    }
    else {
        if ($("#contratos_pk").val() != "") {
            var IntContratosPk = $("#contratos_pk").val();
        }
        else {
            var IntContratosPk = "0";
        }

    }



    if ($("#grupo_para_movimentacao_ins_pk").val() == 1) {
        var colaborador_pk = $("#movimentar_para_pk").val();
    }
    else if ($("#grupo_para_movimentacao_ins_pk").val() == 2) {
        var leads_pk = $("#movimentar_para_pk").val();
        if (IntContratosPk != "") {
            contratos_pk = IntContratosPk;
        }
    }


    if ($("#qtde_materias").val() > 0) {

        var data = tblMaterial.rows().data();
        var strProdutoGrid = "";
        if (data.length > 0) {
            strProdutoGrid += "not in ("
            for (i = 0; i < data.length; i++) {
                strProdutoGrid += data[i]['produtos_itens_pk'] + ",";

            }
            strProdutoGrid += "0)";
        }





        var objParametros1 = {
            "produtos_pk": $("#produtos_pk").val(),
            "qtde": $("#qtde_materias").val(),
            "strProdutoGrid": strProdutoGrid
        };
        var arrCarregar1 = carregarController("produto_iten", "listarPorProdutosQtde", objParametros1);

        if (arrCarregar1.data.length > 0) {
            if ($("#qtde_materias").val() > arrCarregar1.data.length) {
                alert("Só existem " + arrCarregar1.data.length + " unidades desse produto.");
                $("#janela_materiais").modal("show");
                return false;
            }
            for (i = 0; i < arrCarregar1.data.length; i++) {

                var objParametros = {
                    "pk": v_movimentacao_estoque_pk,
                    "produtos_itens_pk": arrCarregar1.data[i]['pk'],
                    "conjunto_material_pk": $("#conjunto_material_pk").val(),
                    "dt_entrega": v_dt_entrega,
                    "dt_devolucao": v_dt_devolucao,
                    "obs_material": (v_obs_material),
                    "ic_mateiral_carga": (ic_mateiral_carga),
                    "leads_pk": leads_pk,
                    "contratos_pk": contratos_pk,
                    "colaborador_pk": colaborador_pk
                };

                var arrEnviar = carregarController("movimentacao_estoque", "salvar", objParametros);
                
                if (arrEnviar.result == 'success') {
                    // Reload datable
                    tblResultado.ajax.reload();

                }
                else {
                    alert('Falhou a requisição para salvar o registro');
                }
            }
        }
    }
    else {
        var objParametros = {
            "pk": v_movimentacao_estoque_pk,
            "produtos_itens_pk": v_produtos_itens_pk,
            "conjunto_material_pk": $("#conjunto_material_pk").val(),

            "dt_entrega": v_dt_entrega,
            "dt_devolucao": v_dt_devolucao,
            "ic_mateiral_carga": ic_mateiral_carga,
            "obs_material": (v_obs_material),
            "leads_pk": leads_pk,
            "contratos_pk": contratos_pk,
            "colaborador_pk": colaborador_pk
        };

        var arrEnviar = carregarController("movimentacao_estoque", "salvar", objParametros);

        if (arrEnviar.result == 'success') {
            // Reload datable

        }
        else {
            alert('Falhou a requisição para salvar o registro');
        }
    }

    alert("Registro salvo com sucesso.");
    fcLimparFormMaterial();


    fcRecarregarGridMateriais();



}

function fcEditarMateriaisSemPk() {
    fcIncluirMateriaisSemPk();
    tblMaterial.row(rLinhaSelecionadaMaterial).remove().draw();
    return false;
}

function fcIncluirMateriaisSemPk() {




    if ($("#ic_mateiral_carga").is(":checked") == true) {
        var ds_ic_mateiral_carga = "Sim";
        var ic_mateiral_carga = 1;
    }
    else {
        var ds_ic_mateiral_carga = "Não";
        var ic_mateiral_carga = 2;
    }

    if ($("#qtde_materias").val() > 0) {

        var data = tblMaterial.rows().data();
        var strProdutoGrid = "";
        if (data.length > 0) {
            strProdutoGrid += "not in ("
            for (i = 0; i < data.length; i++) {
                strProdutoGrid += data[i]['produtos_itens_pk'] + ",";

            }
            strProdutoGrid += "0)";
        }





        var objParametros1 = {
            "produtos_pk": $("#produtos_pk").val(),
            "qtde": $("#qtde_materias").val(),
            "strProdutoGrid": strProdutoGrid
        };
        var arrCarregar1 = carregarController("produto_iten", "listarPorProdutosQtde", objParametros1);

        if (arrCarregar1.data.length > 0) {
            if ($("#qtde_materias").val() > arrCarregar1.data.length) {
                alert("Só existem " + arrCarregar1.data.length + " unidades desse produto.");
                $("#janela_materiais").modal("show");
                return false;
            }
            for (i = 0; i < arrCarregar1.data.length; i++) {
                tblMaterial.row.add(
                    {
                        "pk": "",
                        "ds_categorias_produto": $("#categorias_produto_pk option:selected").text(),
                        "categorias_produto_pk": $("#categorias_produto_pk option:selected").val(),
                        "ds_produtos": $("#produtos_pk option:selected").text(),
                        "produtos_pk": $("#produtos_pk option:selected").val(),
                        "ds_produtos_itens": arrCarregar1.data[i]['ds_produto_item'],
                        "produtos_itens_pk": arrCarregar1.data[i]['pk'],
                        "dt_entrega": $("#dt_entrega").val(),
                        "dt_devolucao": "",
                        "obs_material": $("#observacao_material").val(),
                        "ic_mateiral_carga": ic_mateiral_carga,
                        "ds_ic_mateiral_carga": ds_ic_mateiral_carga,
                        "t_functions": ""
                    }
                ).draw();
            }
        }
    }
    else {
        tblMaterial.row.add(
            {
                "pk": "",
                "ds_categorias_produto": $("#categorias_produto_pk option:selected").text(),
                "categorias_produto_pk": $("#categorias_produto_pk option:selected").val(),
                "ds_produtos": $("#produtos_pk option:selected").text(),
                "produtos_pk": $("#produtos_pk option:selected").val(),
                "ds_produtos_itens": $("#produtos_itens_pk option:selected").text(),
                "produtos_itens_pk": $("#produtos_itens_pk option:selected").val(),
                "dt_entrega": $("#dt_entrega").val(),
                "dt_devolucao": "",
                "obs_material": $("#observacao_material").val(),
                "ic_mateiral_carga": ic_mateiral_carga,
                "ds_ic_mateiral_carga": ds_ic_mateiral_carga,
                "t_functions": ""
            }
        ).draw();
    }
    return false;


}


function fcSalvarConjuntoMateriais() {



    if ($("#grupo_para_movimentacao_ins_pk").val() == "") {
        $("#alert_grupo_para_movimentacao").show();
        $("#alert_grupo_para_movimentacao").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_grupo_para_movimentacao").slideUp(500);
        });
        return false;
    }
    if ($("#grupo_para_movimentacao_ins_pk").val() == 1) {
        if ($("#movimentar_para_pk").val() == "") {
            $("#alert_movimentar_colaborador").show();
            $("#alert_movimentar_colaborador").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_movimentar_colaborador").slideUp(500);
            });
            return false;
        }
    }
    if ($("#grupo_para_movimentacao_ins_pk").val() == 2) {
        if ($("#movimentar_para_pk").val() == "") {
            $("#alert_movimentar_lead").show();
            $("#alert_movimentar_lead").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_movimentar_lead").slideUp(500);
            });
            return false;
        }
    }



    //Esta função está em colaborador_cad_form.js
    var strJSONDadosMateriais = fcFormatarDadosMateriais();
    var data = tblMaterial.rows().data();
    if (data.length == 0) {
        alert("Por favor, Incluir um Material");
        return false;
    }

    var v_colaborador_pk = "";
    var v_leads_pk = "";
    var contratos_pk = "";

    if ($("#grupo_para_movimentacao_ins_pk").val() == 1) {
        var v_colaborador_pk = colaborador_pk;
    }
    else if ($("#grupo_para_movimentacao_ins_pk").val() == 2) {
        var v_leads_pk = leads_pk;
        if (IntContratosPk != "") {
            contratos_pk = IntContratosPk;
        }
    }
    var v_ds_conjunto_material = $("#ds_conjunto_material").val();


    var objParametros = {
        "pk": $("#conjunto_material_pk").val(),
        "ds_conjunto_material": v_ds_conjunto_material,
        "colaborador_pk": v_colaborador_pk,
        "leads_pk": v_leads_pk,
        "contratos_pk": contratos_pk,
        "materiais_pk": strJSONDadosMateriais
    };

    var arrEnviar = carregarController("conjunto_material", "salvar", objParametros);

    if (arrEnviar.result == 'success') {
        // Reload datable

        alert(arrEnviar.message);
        $("#janela_materiais").modal("hide");



        fcRecarregarGridConjuntoMateriais();
    }
    else {
        alert('Falhou a requisição para salvar o registro');
    }
}
function fcRecarregarGridMateriais() {
    tblMaterial.clear().destroy();
    fcCarregarGridMateriais();
}
function fcRecarregarGridConjuntoMateriais() {
    tblResultado.ajax.reload();
    //fcCarregarGridConjuntoMateriais();
}


function fcFormatarDadosMateriais() {
    try {
        var movimentacao_estoquePk = "";
        var categorias_produto_pk = "";
        var produtos_pk = "";
        var produtos_itens_pk = "";
        var dt_entrega = "";
        var dt_devolucao = "";
        var obs_material = "";
        var ic_mateiral_carga = "";

        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "movimentacao_estoque_pk";
        arrKeys[1] = "categorias_produto_pk";
        arrKeys[2] = "produtos_pk";
        arrKeys[3] = "produtos_itens_pk";
        arrKeys[4] = "dt_entrega";
        arrKeys[5] = "dt_devolucao";
        arrKeys[6] = "obs_material";
        arrKeys[7] = "ic_mateiral_carga";

        var data = tblMaterial.rows().data();

        for (i = 0; i < data.length; i++) {
            if (data[i]['pk'] == "") {
                movimentacao_estoquePk = data[i]['pk'];
                categorias_produto_pk = data[i]['categorias_produto_pk'];
                produtos_pk = data[i]['produtos_pk'];
                produtos_itens_pk = data[i]['produtos_itens_pk'];
                dt_entrega = data[i]['dt_entrega'];
                dt_devolucao = data[i]['dt_devolucao'];
                obs_material = data[i]['obs_material'];
                ic_mateiral_carga = data[i]['ic_mateiral_carga'];
                arrDados[i] = [movimentacao_estoquePk, categorias_produto_pk, produtos_pk, produtos_itens_pk, dt_entrega, dt_devolucao, obs_material, ic_mateiral_carga];
            }

        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch (err) {
        alert(err);
    }
}

function fcAbrirFormNovoMaterial() {
    
    $(".chzn-select").chosen('destroy');
    
    //if ($('#janela_materiais').is(':visible') == false) {

        fcLimparFormMaterial();
        $(".chzn-select").chosen('destroy');


        //limpa os dados de qualquer registro existe
        //fcCarregarProdutos("");
        //fcCarregarProdutosItens("","");
        //$("#conjunto_material_pk").val("");
        $("#ds_conjunto_material").val("");
        $("#grupo_para_movimentacao_ins_pk").val("");
        $("#movimentar_para_pk").val("");
        $("#str_opc_ins").text("");
        $("#conjunto_material_pk").val("");
        $("#janela_materiais").modal();

        $("#movimentar_para_pk").prop('disabled', false);
        $("#grupo_para_movimentacao_ins_pk").prop('disabled', false);

    
        if (colaborador_pk != "") {

            $("#grupo_para_movimentacao_ins_pk").val(1);
            fcVerificarMovimentadoParaIns();
            $("#movimentar_para_pk").val(colaborador_pk);
            $("#grupo_para_movimentacao_ins_pk").prop('disabled', true);
            $("#movimentar_para_pk").prop('disabled', true);

        }
        if (leads_pk != "") {
            $("#grupo_para_movimentacao_ins_pk").val(2);
            fcVerificarMovimentadoParaIns();
            $("#movimentar_para_pk").val(leads_pk);
            $("#grupo_para_movimentacao_ins_pk").prop('disabled', true);
            $("#movimentar_para_pk").prop('disabled', true);
        }


        if (IntContratosPk != 0) {


            $("#grupo_para_movimentacao_ins_pk").val(2);
            fcVerificarMovimentadoParaIns();
            if ($("#leads_pk_cad_form").val() != "") {
                $("#movimentar_para_pk").val($("#leads_pk_cad_form").val());
            }

            $("#leads_pk_cad_form").change(function () {

                if ($("#leads_pk_cad_form").val() != "") {
                    $("#movimentar_para_pk").val($("#leads_pk_cad_form").val());
                }


            });

            $("#grupo_para_movimentacao_ins_pk").prop('disabled', true);
            $("#movimentar_para_pk").prop('disabled', true);


        }


        tblMaterial.clear().destroy();
        fcCarregarGridMateriais();
        
        $("#acao").val("ins");
        setTimeout(function () {
            $(".chzn-select").chosen('destroy');
            $(".chzn-select").chosen({ allow_single_deselect: true });
            fcCarregarProdutos("");
            fcCarregarProdutosItens("", "");

            if (colaborador_pk != "") {
                $("#movimentar_para_pk").val(colaborador_pk);
            }
            if (leads_pk != "") {
                $("#movimentar_para_pk").val(leads_pk);
            }
           
        }, 3000);
    //}
}



function fcLimparFormMaterial() {


    $("#produtos_itens_pk").prop('disabled', false);
    $("#qtde_materias").prop('disabled', false);
    $("#categorias_produto_pk").val("");
    //$("#grupo_para_movimentacao_ins_pk").val("");
    //$("#movimentar_para_pk").val("");
    $("#produtos_pk").val("");
    $("#produtos_itens_pk").val("");
    $("#dt_entrega").val("");
    $("#observacao_material").val("");
    $("input[id=ic_mateiral_carga]").prop("checked", false);
    $("#dt_devolucao").val("");
    $("#qtde_materias").val("");
    $("#count_material").val("");
}

function fcFecharModalMovimentacao() {
    tblResultado.ajax.reload();
    $("#janela_materiais").modal("hide");
}

let mat = 0;
$(document).ready(function(){
    if(mat==0){
        
        $(".chzn-select").chosen('destroy');

        //Atribui os eventos
        //$(document).on('click', '#cmdCancelar', fcCancelar);
        $(document).on('click', '#cmdIncluirConjuntoMaterial', fcAbrirFormNovoMaterial);
        $(document).on('click', '#cmdIncluirMaterial', fcIncluirMateriais);
        $(document).on('click', '.fechar_modal_movimentacao', fcFecharModalMovimentacao);

        var contratos_pk = "";
        if ($("#contratos_pk").val() == undefined) {
            var IntContratosPk = "";
        }
        else {
            if ($("#contratos_pk").val() != "") {
                var IntContratosPk = $("#contratos_pk").val();
            }
            else {
                var IntContratosPk = "0";
            }

        }






        $("#exibir_lead_colaborador").hide();
        $("#exibir_em_menu_estoque").show();
        $("#exibir_titulo").show();

        $("#grupo_para_movimentacao_pk").change(function () {
            if ($("#grupo_para_movimentacao_pk").val() == 1) {
                $(".chzn-select").chosen('destroy');
                fcVerificarMovimentadoPara();
                $(".chzn-select").chosen({ allow_single_deselect: true });
            }
            else if ($("#grupo_para_movimentacao_pk").val() == 2) {
                $(".chzn-select").chosen('destroy');
                fcVerificarMovimentadoPara();
                $(".chzn-select").chosen({ allow_single_deselect: true });

            }

        });
        $(".chzn-select").chosen('destroy');

        $("#grupo_para_movimentacao_ins_pk").prop('disabled', false);
        $("#movimentar_para_pk").prop('disabled', false);

        if (IntContratosPk != "") {


            $("#grupo_para_movimentacao_pk").val(2);
            fcVerificarMovimentadoPara();

            $("#grupo_para_movimentacao_ins_pk").val(2);
            fcVerificarMovimentadoParaIns();


            $("#leads_pk_cad_form").change(function () {

                if ($("#leads_pk_cad_form").val() != "") {
                    $("#movimentar_para_pesq_pk").val($("#leads_pk_cad_form").val());
                    $("#movimentar_para_pk").val($("#leads_pk_cad_form").val());
                }


            });

            $("#grupo_para_movimentacao_ins_pk").prop('disabled', false);
            $("#movimentar_para_pk").prop('disabled', true);

            $("#exibir_lead_colaborador").show();
            $("#exibir_em_menu_estoque").hide();
            $("#exibir_titulo").hide();



        }
        if (leads_pk != "") {

            $("#grupo_para_movimentacao_pk").val(2);
            fcVerificarMovimentadoPara();
            $("#movimentar_para_pesq_pk").val(leads_pk);
            $("#grupo_para_movimentacao_ins_pk").val(2);
            fcVerificarMovimentadoParaIns();
            $("#movimentar_para_pk").val(leads_pk);
            $("#grupo_para_movimentacao_ins_pk").prop('disabled', false);
            $("#movimentar_para_pk").prop('disabled', true);

            $("#exibir_lead_colaborador").show();
            $("#exibir_em_menu_estoque").hide();

        }
        if (colaborador_pk != "") {
            $("#grupo_para_movimentacao_pk").val(1);
            fcVerificarMovimentadoPara();
            $("#movimentar_para_pesq_pk").val(colaborador_pk);
            $("#grupo_para_movimentacao_ins_pk").val(1);
            fcVerificarMovimentadoParaIns();
            $("#movimentar_para_pk").val(colaborador_pk);
            $("#grupo_para_movimentacao_ins_pk").prop('disabled', false);
            $("#movimentar_para_pk").prop('disabled', true);

            $("#exibir_lead_colaborador").show();
            $("#exibir_em_menu_estoque").hide();
        }
        fcCarregarGridConjuntoMateriais();



        $(".chzn-select").chosen('destroy');



        fcCarregarCategorias("");
        //Produtos
        fcCarregarProdutos("");


        $("#categorias_produto_pk").change(function () {
            $(".chzn-select").chosen('destroy');

            fcCarregarProdutos($("#categorias_produto_pk").val());
            $(".chzn-select").chosen({ allow_single_deselect: true });
        });




        $(".chzn-select").chosen({ allow_single_deselect: true });

        $("#grupo_para_movimentacao_pk").change(function () {
            if ($("#grupo_para_movimentacao_pk").val() == 1) {
                $(".chzn-select").chosen('destroy');
                fcVerificarMovimentadoPara();
                $(".chzn-select").chosen({ allow_single_deselect: true });
            }
            else if ($("#grupo_para_movimentacao_pk").val() == 2) {
                $(".chzn-select").chosen('destroy');
                fcVerificarMovimentadoPara();
                $(".chzn-select").chosen({ allow_single_deselect: true });

            }

        });


        $("#dt_movimentacao_ini").on('keyup', function () {
            mascara(this, mdata);
        });
        $("#dt_movimentacao_fim").on('keyup', function () {
            mascara(this, mdata);
        });


        $('#dt_movimentacao_ini').datepicker({
            defaultDate: "",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker();
        $('#dt_movimentacao_fim').datepicker({
            defaultDate: "",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker();





        $(document).on('click', '#cmdPesquisar', fcPesquisar);
        $(document).on('click', '#cmdEnviarMateriais', fcSalvarConjuntoMateriais);

        //------------------------MODAL------------------------------//
        
        fcCarregarProdutosItens("", "");
        


        $("#categorias_produto_pk").change(function () {
            $(".chzn-select").chosen('destroy');
            fcCarregarProdutos($("#categorias_produto_pk").val());
            $(".chzn-select").chosen({ allow_single_deselect: true });
        });

        //Seleciona o produto
        $("#produtos_pk").change(function () {
            //Itens Material
            $(".chzn-select").chosen('destroy');
            fcCarregarProdutosItens($("#produtos_pk").val(), "");
            $(".chzn-select").chosen({ allow_single_deselect: true });
        });
        $("#produtos_itens_pk").change(function () {
            if ($("#produtos_itens_pk").val() != "") {
                $("#qtde_materias").prop('disabled', true);
                $("#qtde_materias").val("");
            }
            else {
                $("#qtde_materias").prop('disabled', false);
            }

        });

        $("#qtde_materias").keypress(function () {
            mascara(this, soNumeros);
        });

        $("#qtde_materias").change(function () {
            if ($("#qtde_materias").val() != "") {
                if ($("#qtde_materias").val() > 0) {
                    $("#produtos_itens_pk").prop('disabled', true);
                    $("#produtos_itens_pk").val("");
                }
                else {
                    $("#produtos_itens_pk").prop('disabled', false);
                }
            }
            else {
                $("#produtos_itens_pk").prop('disabled', false);
            }
        });

        $('#dt_entrega').datepicker({
            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker("setDate", new Date());
        $("#dt_entrega").keypress(function () {
            mascara(this, mdata);
        });
        $("#dt_entrega").keypress(function () {
            mascara(this, horamask);
        });


        $('#dt_devolucao').datepicker({
            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker("setDate", new Date());
        $("#dt_devolucao").keypress(function () {
            mascara(this, mdata);
        });
        $("#dt_devolucao").keypress(function () {
            mascara(this, horamask);
        });

        $("#grupo_para_movimentacao_ins_pk").change(function () {
            if ($("#grupo_para_movimentacao_ins_pk").val() == 1) {
                $(".chzn-select").chosen('destroy');
                fcVerificarMovimentadoParaIns();
                $(".chzn-select").chosen({ allow_single_deselect: true });
            }
            else if ($("#grupo_para_movimentacao_ins_pk").val() == 2) {
                $(".chzn-select").chosen('destroy');
                fcVerificarMovimentadoParaIns();
                $(".chzn-select").chosen({ allow_single_deselect: true });

            }

        });
        fcCarregarGridMateriais();
        
        mat ++;
    }
    




    
});

