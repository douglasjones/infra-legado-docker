
function fcCarregarMovimentacaoEstoque() {

//alert("dentro")

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
        "colaborador_pk": colaborador_pk
    };

var v_url = montarUrlController("conjunto_material", "listarMovimentarMaterialProdPK", objParametros);
//NewWindow(v_last_url)
    //Trata a tabela
    tblResultadoEstoque = $('#tblResultadoEstoque').DataTable({
        "scrollX": true,
        "responsive": false,
        "searching": true,
        "paging":true,
        "serverSide": false,
        "iDisplayLength":10,
        "pageLength":10,
        "ajax": { "url": v_url, "type": "POST", "datatype":"json" },
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
    $('#tblResultadoEstoque tbody').on('click', '.function_painel', function () {
        var data;

        //rLinhaSelecionada = null;

        if (tblResultadoEstoque.row($(this).parents('li')).data()) {
            data = tblResultadoEstoque.row($(this).parents('li')).data();
            //rLinhaSelecionada = $(this).parents('li');
        }
        else if (tblResultadoEstoque.row($(this).parents('tr')).data()) {
            data = tblResultadoEstoque.row($(this).parents('tr')).data();
            //rLinhaSelecionada = $(this).parents('tr');
        }

        fcEditarConjuntoMaterialProd(data);

    });
    //Atribui os eventos na coluna ação.
    $('#tblResultadoEstoque tbody').on('click', '.function_delete', function () {
        var data;

        //rLinhaSelecionada = null;

        if (tblResultadoEstoque.row($(this).parents('li')).data()) {
            data = tblResultadoEstoque.row($(this).parents('li')).data();
            //rLinhaSelecionada = $(this).parents('li');
        }
        else if (tblResultadoEstoque.row($(this).parents('tr')).data()) {
            data = tblResultadoEstoque.row($(this).parents('tr')).data();
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






function recarregarGridEstoque(){
    setTimeout(function(){
        tblResultadoEstoque.ajax.reload(); 
    }, 500);
    
}



$(document).ready(function(){
    $(".chzn-select").chosen('destroy');
    fcCarregarMovimentacaoEstoque();
    $(document).on('click', '#cmdIncluirConjuntoMaterial', fcAbrirFormNovoMaterial);
    //alert("aqui")
    //fcCarregarGridConjuntoMateriais();
    //$(document).on('click', '#cmdIncluirConjuntoMaterial', fcIncluir);
});

