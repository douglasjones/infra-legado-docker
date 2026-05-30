var tblReceita;
function fcPesquisarReceita() {

    tblReceita.clear().destroy();
    fcCarregarGrid();

}

function fcIncluirReceita() {
    sendPost('inc_receita_cad_form.php', { token: token, pk: '' });
}

function fcExcluirReceita(v_pk, v_status) {
    var objParametros = {
        "ds_dominio_modulo": "excluir_lancamentos",
        "ic_acao": "del"
    };

    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);
    if (arrCarregar.result != 'success') {
        alert("Você não tem Permissão");
        return false;
    }

    if (v_status == 1) {
        var objParametros = {
            "ds_dominio_modulo": "excluir_lancamentos_pagos",
            "ic_acao": "del"
        };

        var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);
        if (arrCarregar.result != 'success') {
            alert("Não é permitido excluir lançamento pago.");
            return false;
        }

    }

    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")) {
        if (v_pk != "") {

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("lancamento", "excluir", objParametros);

            if (arrExcluir.result == 'success') {

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                fcCarregarGriLancamentosMes();
                fcCarregarGriLancamentosVencidoReceitaDia();
                fcCarregarGriLancamentosVencidoDespesaDia();
                fcCarregarGriLancamentosReceitaAtrasado();
                fcCarregarGriLancamentosDespesaAtrasado();

                fcCarregarSaldoContas();
                fcCarregarGraficoLinha();
                fcCarregarExtrato();

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
function fcLimparVariavelReceita() {
    $("#grid_contrato").empty();
    $("#grid_contrato").append("");
    $("#listar_conta_bancaria").empty();
    $("#listar_conta_bancaria").append("");
    $("#lancamento_receita_pk").val("");
    $("#dt_vencimento_receita").val("");
    $("#ds_lancamento_receita").val("");
    $("#vl_lancamento_receita").val("");
    $("#tipo_grupo_pk_receita").val("");
    $("#grupo_leancamento_pk_receita").val("");
    $("#ic_status_pagamento_receita").val("");
    $("#dt_competencia_receita").val("");
    $("#n_documento_receita").val("");
    $("#tipos_operacao_pk_receita").val("");
    $("#metodos_pagamento_pk_receita").val("");
    $("#contas_bancarias_pk_receita").val("");
    $("#tipo_grupo_centro_custo_pk_receita").val("");
    $("#grupo_lancamento_centro_custo_pk_receita").val("");
    $("#ds_ocorrencia_receita").val("");
    $("#tipo_lancamento_modal_receita_pk").val("");
    $("#dt_pagamento").val("");
    $("#contratos_ins_pk").val("");
    $("#dt_faturamento_receita").val("");

    var objParametros = {
        "ds_dominio_modulo": "status_finaceiro",
        "ic_acao": "upd"
    };

    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);

    if (arrCarregar.result != 'success') {
        $("#exibir_pago").hide();
    }
    else {
        $("#exibir_pago").show();
    }

}

function fcGridContrato() {
    $("#grid_contrato").empty();
    $("#grid_contrato").append("");

    var tipo_contrato = "";
    if ($("#tipos_operacao_pk_receita").val() == 1000) {
        tipo_contrato = 1;
    }
    else if ($("#tipos_operacao_pk_receita").val() == 1001) {
        tipo_contrato = 2;
    }
    else if ($("#tipos_operacao_pk_receita").val() == 1002) {
        tipo_contrato = 3;
    }

    var strModal = "";

    $("#qtde_contratos").val("");
    var objParametros = {
        "ic_tipo_contrato": tipo_contrato,
        "lancamento_pk": $("#lancamento_receita_pk").val(),
        "contratos_pk": $("#contratos_ins_pk").val(),
        "leads_pk": $("#grupo_lancamento_centro_custo_pk_receita").val()
    };

    var arrCarregar = carregarController("contrato", "listarGridLancamentoContrato", objParametros);

    if (arrCarregar.result == 'success') {
        if (arrCarregar.data.length > 0) {
            strModal += "<div class='row'>";
            strModal += "    <div class='col-md-12'>";
            strModal += "    <table class='table table-striped table-bordered nowrap' style='width:100%' id='tblLeadColaborador'>";
            strModal += "        <thead>";
            strModal += "            <tr>";
            strModal += "                <th>Posto de Trabalho</th>";
            strModal += "                <th>Contrato</th>";
            strModal += "                <th>Valor</th>";
            strModal += "            </tr>";
            strModal += "        </thead>";
            strModal += "        <tbody>";
            $("#qtde_contratos").val(arrCarregar.data.length);
            for (p = 0; p < arrCarregar.data.length; p++) {

                strModal += "<tr>";
                strModal += "<td >";
                if ($("#contratos_ins_pk").val() == arrCarregar.data[p]['pk']) {
                    strModal += " <input type='radio' id='contratos_pk_radio' name='contratos_pk_radio' value='" + arrCarregar.data[p]['pk'] + "' checked>&nbsp;&nbsp;<b>" + arrCarregar.data[p]['ds_lead'];
                }
                else {
                    strModal += " <input type='radio' id='contratos_pk_radio' name='contratos_pk_radio' value='" + arrCarregar.data[p]['pk'] + "' >&nbsp;&nbsp;<b>" + arrCarregar.data[p]['ds_lead'];
                }
                strModal += "</td>";
                strModal += "<td>";
                strModal += "&nbsp;&nbsp;" + arrCarregar.data[p]['ds_contrato'];
                strModal += "</td>";
                strModal += "<td>";
                strModal += "&nbsp;&nbsp;" + arrCarregar.data[p]['vl_contrato'];
                strModal += "</td>";
                strModal += "</tr>";
            }
            strModal += "</tbody>";
            strModal += "</table>";
            strModal += "</div>";
            strModal += "</div>";
        }
    }
    $("#grid_contrato").append(strModal);



}

function fcCarregarValorContrato() {

    var objParametros = {
        "contratos_pk": $('input:radio[name=contratos_pk_radio]:checked').val()
    };

    var arrCarregar = carregarController("contrato_item", "listarContratoItem", objParametros);
    if (arrCarregar.result == 'success') {
        $("#vl_lancamento_receita").val(arrCarregar.data[0]['t_vl_total']);
    }
    else {
        $("#vl_lancamento_receita").val("");
    }




}

function fcEditarReceita(str_pk) {
    fcLimparVariavelReceita();
    $(".chzn-select").chosen('destroy');

    var objParametros = {
        "pk": str_pk
    };

    var arrCarregar = carregarController("lancamento", "listarPk", objParametros);

    if (arrCarregar.result == 'success') {
        if (arrCarregar.data.length > 0) {

            $("#tipo_lancamento_modal_receita_pk").val(arrCarregar.data[0]['t_operacao_pk']);
            $("#lancamento_receita_pk").val(arrCarregar.data[0]['t_pk']);
            $("#dt_vencimento_receita").val(arrCarregar.data[0]['t_dt_vencimento']);
            var ds_lancamento = arrCarregar.data[0]['t_ds_lancamento'];

            $("#ds_lancamento_receita").val(ds_lancamento);
            $("#vl_lancamento_receita").val(float2moeda(arrCarregar.data[0]['t_vl_lancamento']));
            $("#tipo_grupo_pk_receita").val(arrCarregar.data[0]['t_tipo_grupo_pk']);
            $("#empresas_pk_receita").val(arrCarregar.data[0]['t_empresas_pk']);
            fcListarItensGruposReceita();
            $("#grupo_leancamento_pk_receita").val(arrCarregar.data[0]['t_grupo_leancamento_pk']);
            $("#ic_status_pagamento_receita").val(arrCarregar.data[0]['t_ic_status_pagamento']);

            if ($("#ic_status_pagamento_receita").val() == 1) {
                $("#exibir_dt_pagamento").show();
            }
            else {
                $("#exibir_dt_pagamento").hide();
            }
            $("#dt_competencia_receita").val(arrCarregar.data[0]['t_dt_competencia']);
            $("#n_documento_receita").val(arrCarregar.data[0]['t_n_documento']);
            $("#tipos_operacao_pk_receita").val(arrCarregar.data[0]['t_tipos_operacao_pk']);

            $("#empresa_modal_receita_pk").val(arrCarregar.data[0]['t_empresas_pk']);

            fcListarContaBancariaReceita();

            $("#contas_bancarias_pk_receita").val(arrCarregar.data[0]['t_contas_bancarias_pk']);

            $("#tipo_grupo_centro_custo_pk_receita").val(arrCarregar.data[0]['tipo_grupo_centro_custo_pk']);
            $("#dt_pagamento_receita").val(arrCarregar.data[0]['dt_pagamento']);
            $("#dt_faturamento_receita").val(arrCarregar.data[0]['dt_faturamento']);


            fcListarItensGruposCentroCustoReceita();
            $("#grupo_lancamento_centro_custo_pk_receita").val(arrCarregar.data[0]['grupo_lancamento_centro_custo_pk']);
            //$("#ds_ocorrencia_receita").val(arrCarregar.data[0]['ds_ocorrencia']);
            fcListarMetodosPagamentoReceita()
            $("#metodos_pagamento_pk_receita").val(arrCarregar.data[0]['t_metodos_pagamento_pk']);
            $("#contratos_ins_pk").val(arrCarregar.data[0]['contratos_pk']);
            if ($("#tipo_grupo_centro_custo_pk_receita").val() == 1) {
                fcGridContrato();
            }

            $(".recebido_de_pago_para").html("Recebido de ?:");
            $(".metodo_recebimento_pagamento").html("Método de Recebimento:");
            if ($("#tipo_lancamento_modal_receita_pk").val() == 1) {
                $(".recebido_de_pago_para").html("Recebido de ?:");
                $(".metodo_recebimento_pagamento").html("Método de Recebimento:");
            }
            else {
                $(".recebido_de_pago_para").html("Pago para ?:");
                $(".metodo_recebimento_pagamento").html("Método de Pagamento:");
            }


        }
    }

    if (arrCarregar.data[0]['t_ic_status_pagamento'] == 1) {
        var objParametros = {
            "ds_dominio_modulo": "editar_lancamentos_pagos",
            "ic_acao": "del"
        };

        var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);

        if (arrCarregar.result != 'success') {
            alert("Não é permitido editar lançamento pago.");
            return false;
        }



    }
    $("#modal_receita").modal();

    $(".chzn-select").chosen({ allow_single_deselect: true });

}



function fcCarregarGriLancamentosMes() {
    $("#gridLancamentosMes").html("");
    $("#gridLancamentosMes").append("");

    var strNenhumRegisto = "";
    var strRetorno = "";
    if ($("#dt_vencimento_ini_mes").val() != "") {
        var data_inicio = $("#dt_vencimento_ini_mes").val();
        var data_final = $("#dt_vencimento_fim_mes").val();
    }
    else {
        var data_inicio = primeiroDia;
        var data_final = ultimoDia;
    }



    strRetorno += "<div class='row'><div class='col-md-12 tableFixHead'>";
    //strRetorno+="<div class='overflow-auto' style='height:800px;overflow-y: scroll;' >";
    strRetorno += "<table id='tabela' class='table table-striped table-bordered ' style='width:100%' id='tblResultado' >";
    strRetorno += "<thead class='fixed-content'>";
    strRetorno += "<tr align='center'>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Cód</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Cadastro</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Tipo<br>Lançamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Valor</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Dt Vencimento<br>Recebimento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Método de Recebimento<br>Pagamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Status</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Faturamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Pagamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Tipo Operação<br>Planos Conta</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Empresa do <br>lançamento</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Conta do Bancária</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Identificação do<br>Lançamento</font></th>";
    //strRetorno+="<th width='10%'>Grupo Origem<br>do Lançamento</th>";
    strRetorno += "<th width='5%'class='menu_fixo'><font style='font-size: 12px'>Rebido de ?<br>Pago para ?</font></th>";
    //strRetorno+="<th width='10%'>Grupos Centro<br>de Custo</th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Centro de Custo</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Usuário de<br>Cadastro</font></th>";
    strRetorno += "<th width='12%' class='menu_fixo'><font style='font-size: 12px'>Ação</font></th>";
    strRetorno += "</tr>";
    strRetorno += "</thead>";

    //strRetorno+="<div class='overflow-auto' style='height:400px;overflow-y: scroll;' >";
    strRetorno += "<tbody >";



    var objParametros = {
        pk: $("#pk_mes").val(),
        dt_cadastro_ini: $("#dt_cadastro_ini_mes").val(),
        dt_cadastro_fim: $("#dt_cadastro_fim_mes").val(),
        dt_faturamento_ini: $("#dt_faturamento_ini_mes").val(),
        dt_faturamento_fim: $("#dt_faturamento_fim_mes").val(),
        dt_pagamento_ini: $("#dt_pagamento_ini_mes").val(),
        dt_pagamento_fim: $("#dt_pagamento_fim_mes").val(),
        tipo_lancamento_pk: $("#tipo_lancamento_pk_mes").val(),
        ic_status_pagamento: $("#ic_status_mes").val(),
        "dt_vencimento_ini": data_inicio,
        "dt_vencimento_fim": data_final,
        //"contas_bancarias_pk":$("#contas_pk").val(),
        empresas_pk: $("#empresa_pk_mes").val(),
        tipo_grupo_pk: $("#tipo_grupo_pk_mes").val(),
        grupo_leancamento_pk: $("#grupo_leancamento_pk_mes").val(),
        usuario_cadastro_pk: $("#usuario_cadastro_pk_mes").val()
    };

    var arrCarregar = carregarController("lancamento", "listarLancamentosMes", objParametros);

    if (arrCarregar.result == 'success') {
        if (arrCarregar.data.length > 0) {
            var total_valor = 0.00;
            for (i = 0; i < arrCarregar.data.length; i++) {

                total_valor += arrCarregar.data[i]['t_vl_lancamento'];

                strRetorno += "<tr>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_pk'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_cadastro'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_operacao'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + float2moeda(arrCarregar.data[i]['t_vl_lancamento']) + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_vencimento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_metodo_pagamento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_status_pagamento'] + "</font></th>";
                if (arrCarregar.data[i]['dt_faturamento'] != null) {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['dt_faturamento'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                }
                if (arrCarregar.data[i]['t_dt_pagamento'] != null) {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_pagamento'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                }

                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_tipo_operacao'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_razao_social'] + "</font></th>";
                if (arrCarregar.data[i]['t_ds_conta_bancaria'] != null) {
                    strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_conta_bancaria'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'></font></th>";
                }
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_lancamento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_recebido_de'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_recebido_de_centro_custo'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['ds_usuario'] + "</font></th>";
                strRetorno += "<th width='12%' align='center'><a class='function_edit' onclick='fcEditarReceita(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=16 height=16 src='../img/copiar.png'></span></a><a class='function_painel' onclick='fcAbrirModalDocs(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=18 height=18 src='../img/relatorio.jpg' title='Documentos'></span></a><a class='function_painel' onclick='fcImprimirLancamento(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=18 height=18 src='../img/impressora.png' title='Imprimir'></span></a>&nbsp<a class='function_opcoes' onclick='fcExcluirReceita(" + arrCarregar.data[i]['t_pk'] + ", " + arrCarregar.data[i]['t_ic_status_pagamento'] + ");'><span><img width=16 height=16 src='../img/excluir.png'></span></a></th>";
                strRetorno += "</tr>";
            }
        }
    }

    strRetorno += "</tbody>";
    strRetorno += "<tfoot>";
    strRetorno += "<tr align='center' style='background:#f2f2f2'>";
    strRetorno += "<th colspan=2>&nbsp;</th>";
    strRetorno += "<th align='center'><font style='font-size: 15px' >Total Valor:</font></th>";
    if (arrCarregar.data.length > 0) {
        strRetorno += "<th align='center'><font style='font-size: 15px'>R$ " + float2moeda(arrCarregar.data[(arrCarregar.data.length - 1)]['t_vl_total']) + "</font></th>";
    }
    else {
        strRetorno += "<th align='center'><font style='font-size: 15px'>R$ 0</font></th>";
    }
    strRetorno += "<th colspan=13>&nbsp;</th>";
    strRetorno += "</tr>";
    strRetorno += "</tfoot>";
    strRetorno += "</table>";
    strRetorno += "</div>";
    strRetorno += "</div>";
    //alert(strRetorno);

    $("#gridLancamentosMes").html(strRetorno);

}
function fcCarregarGriLancamentosVencidoReceitaDia() {

    $("#gridVencimentoDia").html("");
    $("#gridVencimentoDia").append("");

    var strNenhumRegisto = "";
    var strRetorno = "";

    strRetorno += "<div class='row'><div class='col-md-12 tableFixHead'>";
    //strRetorno+="<div class='overflow-auto' style='height:800px;overflow-y: scroll;' >";
    strRetorno += "<table id='tabela' class='table table-striped table-bordered ' style='width:100%' id='tblResultado' >";
    strRetorno += "<thead class='fixed-content'>";
    strRetorno += "<tr align='center'>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Cód</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Cadastro</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Tipo<br>Lançamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Valor</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Dt Vencimento<br>Recebimento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Método de Recebimento<br>Pagamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Status</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Faturamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Pagamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Tipo Operação<br>Planos Conta</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Empresa do <br>lançamento</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Conta do Bancária</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Identificação do<br>Lançamento</font></th>";
    //strRetorno+="<th width='10%'>Grupo Origem<br>do Lançamento</th>";
    strRetorno += "<th width='5%'class='menu_fixo'><font style='font-size: 12px'>Rebido de ?<br>Pago para ?</font></th>";
    //strRetorno+="<th width='10%'>Grupos Centro<br>de Custo</th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Centro de Custo</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Usuário de<br>Cadastro</font></th>";
    strRetorno += "<th width='12%' class='menu_fixo'><font style='font-size: 12px'>Ação</font></th>";
    strRetorno += "</tr>";
    strRetorno += "</thead>";

    //strRetorno+="<div class='overflow-auto' style='height:400px;overflow-y: scroll;' >";
    strRetorno += "<tbody >";

    var objParametros = {
        pk: $("#pk_dia").val(),
        dt_vencimento_ini: $("#dt_vencimento_ini_dia").val(),
        dt_vencimento_fim: $("#dt_vencimento_fim_dia").val(),
        dt_cadastro_ini: $("#dt_cadastro_ini_dia").val(),
        dt_cadastro_fim: $("#dt_cadastro_fim_dia").val(),
        dt_faturamento_ini: $("#dt_faturamento_ini_dia").val(),
        dt_faturamento_fim: $("#dt_faturamento_fim_dia").val(),
        tipo_lancamento_pk: 1,
        ic_status_pagamento: $("#ic_status_dia").val(),
        empresas_pk: $("#empresa_pk_dia").val(),
        tipo_grupo_pk: $("#tipo_grupo_pk_dia").val(),
        grupo_leancamento_pk: $("#grupo_leancamento_pk_dia").val(),
        usuario_cadastro_pk: $("#usuario_cadastro_pk_dia").val()
    };
    var arrCarregar = carregarController("lancamento", "listarLancamentosVencidoDia", objParametros);


    if (arrCarregar.result == 'success') {
        var vl_total = 0.00;
        if (arrCarregar.data.length > 0) {
            for (i = 0; i < arrCarregar.data.length; i++) {

                strRetorno += "<tr>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_pk'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_cadastro'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_operacao'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + float2moeda(arrCarregar.data[i]['t_vl_lancamento']) + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_vencimento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_metodo_pagamento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_status_pagamento'] + "</font></th>";
                if (arrCarregar.data[i]['dt_faturamento'] != null) {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['dt_faturamento'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                }
                if (arrCarregar.data[i]['t_dt_pagamento'] != null) {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_pagamento'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                }

                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_tipo_operacao'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_razao_social'] + "</font></th>";
                if (arrCarregar.data[i]['t_ds_conta_bancaria'] != null) {
                    strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_conta_bancaria'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'></font></th>";
                }
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_lancamento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_recebido_de'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_recebido_de_centro_custo'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['ds_usuario'] + "</font></th>";
                strRetorno += "<th width='12%' align='center'><a class='function_edit' onclick='fcEditarReceita(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=16 height=16 src='../img/copiar.png'></span></a><a class='function_painel' onclick='fcAbrirModalDocs(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=18 height=18 src='../img/relatorio.jpg' title='Documentos'></span></a><a class='function_painel' onclick='fcImprimirLancamento(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=18 height=18 src='../img/impressora.png' title='Imprimir'></span></a>&nbsp<a class='function_opcoes' onclick='fcExcluirReceita(" + arrCarregar.data[i]['t_pk'] + ", " + arrCarregar.data[i]['t_ic_status_pagamento'] + ");'><span><img width=16 height=16 src='../img/excluir.png'></span></a></th>";
                strRetorno += "</tr>";

                vl_total = arrCarregar.data[(arrCarregar.data.length - 1)]['t_vl_total'];
            }
        }
    }

    strRetorno += "</tbody>";
    strRetorno += "<tfoot>";
    strRetorno += "<tr>";
    strRetorno += "<th colspan=2>&nbsp;</th>";
    strRetorno += "<th ><font style='font-size: 15px'>Total Valor:</font></th>";
    if (arrCarregar.data.length > 0) {
        strRetorno += "<th ><font style='font-size: 15px'>R$ " + float2moeda(vl_total) + "</font></th>";
    }
    else {
        strRetorno += "<th ><font style='font-size: 15px'></font></th>";
    }
    strRetorno += "<th colspan=13>&nbsp;</th>";
    strRetorno += "</tr>";
    strRetorno += "</tfoot>";
    //strRetorno+="</div>";
    strRetorno += "</table>";
    strRetorno += "</div>";
    strRetorno += "</div>";
    //alert(strRetorno);

    $("#gridVencimentoDia").html(strRetorno);

}
function fcCarregarGriLancamentosVencidoDespesaDia() {

    $("#gridVencimentoDespesaDia").html("");
    $("#gridVencimentoDespesaDia").append("");

    var strNenhumRegisto = "";
    var strRetorno = "";

    strRetorno += "<div class='row'><div class='col-md-12 tableFixHead'>";
    //strRetorno+="<div class='overflow-auto' style='height:800px;overflow-y: scroll;' >";
    strRetorno += "<table id='tabela' class='table table-striped table-bordered ' style='width:100%' id='tblResultado' >";
    strRetorno += "<thead class='fixed-content'>";
    strRetorno += "<tr align='center'>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Cód</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Cadastro</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Tipo<br>Lançamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Valor</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Dt Vencimento<br>Recebimento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Método de Recebimento<br>Pagamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Status</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Faturamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Pagamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Tipo Operação<br>Planos Conta</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Empresa do <br>lançamento</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Conta do Bancária</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Identificação do<br>Lançamento</font></th>";
    //strRetorno+="<th width='10%'>Grupo Origem<br>do Lançamento</th>";
    strRetorno += "<th width='5%'class='menu_fixo'><font style='font-size: 12px'>Rebido de ?<br>Pago para ?</font></th>";
    //strRetorno+="<th width='10%'>Grupos Centro<br>de Custo</th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Centro de Custo</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Usuário de<br>Cadastro</font></th>";
    strRetorno += "<th width='12%' class='menu_fixo'><font style='font-size: 12px'>Ação</font></th>";
    strRetorno += "</tr>";
    strRetorno += "</thead>";

    //strRetorno+="<div class='overflow-auto' style='height:400px;overflow-y: scroll;' >";
    strRetorno += "<tbody >";

    var objParametros = {
        pk: $("#pk_despesa_dia").val(),
        dt_vencimento_ini: $("#dt_vencimento_ini_despesa_dia").val(),
        dt_vencimento_fim: $("#dt_vencimento_fim_despesa_dia").val(),
        dt_cadastro_ini: $("#dt_cadastro_ini_despesa_dia").val(),
        dt_cadastro_fim: $("#dt_cadastro_fim_despesa_dia").val(),
        dt_faturamento_ini: $("#dt_faturamento_ini_despesa_dia").val(),
        dt_faturamento_fim: $("#dt_faturamento_fim_despesa_dia").val(),
        tipo_lancamento_pk: 2,
        ic_status_pagamento: $("#ic_status_despesa_dia").val(),
        empresas_pk: $("#empresa_pk_despesa_dia").val(),
        tipo_grupo_pk: $("#tipo_grupo_pk_despesa_dia").val(),
        grupo_leancamento_pk: $("#grupo_leancamento_pk_despesa_dia").val(),
        usuario_cadastro_pk: $("#usuario_cadastro_pk_despesa_dia").val()
    };
    var arrCarregar = carregarController("lancamento", "listarLancamentosVencidoDia", objParametros);


    if (arrCarregar.result == 'success') {
        var vl_total = 0.00;
        if (arrCarregar.data.length > 0) {
            for (i = 0; i < arrCarregar.data.length; i++) {

                strRetorno += "<tr>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_pk'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_cadastro'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_operacao'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + float2moeda(arrCarregar.data[i]['t_vl_lancamento']) + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_vencimento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_metodo_pagamento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_status_pagamento'] + "</font></th>";
                if (arrCarregar.data[i]['dt_faturamento'] != null) {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['dt_faturamento'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                }
                if (arrCarregar.data[i]['t_dt_pagamento'] != null) {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_pagamento'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                }

                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_tipo_operacao'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_razao_social'] + "</font></th>";
                if (arrCarregar.data[i]['t_ds_conta_bancaria'] != null) {
                    strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_conta_bancaria'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'></font></th>";
                }
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_lancamento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_recebido_de'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_recebido_de_centro_custo'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['ds_usuario'] + "</font></th>";
                strRetorno += "<th width='12%' align='center'><a class='function_edit' onclick='fcEditarReceita(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=16 height=16 src='../img/copiar.png'></span></a><a class='function_painel' onclick='fcAbrirModalDocs(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=18 height=18 src='../img/relatorio.jpg' title='Documentos'></span></a><a class='function_painel' onclick='fcImprimirLancamento(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=18 height=18 src='../img/impressora.png' title='Imprimir'></span></a>&nbsp<a class='function_opcoes' onclick='fcExcluirReceita(" + arrCarregar.data[i]['t_pk'] + ", " + arrCarregar.data[i]['t_ic_status_pagamento'] + ");'><span><img width=16 height=16 src='../img/excluir.png'></span></a></th>";
                strRetorno += "</tr>";
                vl_total = arrCarregar.data[(arrCarregar.data.length - 1)]['t_vl_total'];
            }
        }
    }

    strRetorno += "</tbody>";
    strRetorno += "<tfoot>";
    strRetorno += "<tr>";
    strRetorno += "<th colspan=2>&nbsp;</th>";
    strRetorno += "<th ><font style='font-size: 15px'>Total Valor:</font></th>";
    if (arrCarregar.data.length > 0) {
        strRetorno += "<th ><font style='font-size: 15px'>R$ " + float2moeda(vl_total) + "</font></th>";
    }
    else {
        strRetorno += "<th ><font style='font-size: 15px'></font></th>";
    }

    strRetorno += "<th colspan=13 >&nbsp;</th>";
    strRetorno += "</tr>";
    strRetorno += "</tfoot>";
    //strRetorno+="</div>";
    strRetorno += "</table>";
    strRetorno += "</div>";
    strRetorno += "</div>";
    //alert(strRetorno);

    $("#gridVencimentoDespesaDia").html(strRetorno);

}
function fcCarregarGriLancamentosReceitaAtrasado() {
    $("#gridAtrasado").html("");
    $("#gridAtrasado").append("");

    var strNenhumRegisto = "";
    var strRetorno = "";

    strRetorno += "<div class='row'><div class='col-md-12 tableFixHead'>";
    //strRetorno+="<div class='overflow-auto' style='height:800px;overflow-y: scroll;' >";
    strRetorno += "<table id='tabela' class='table table-striped table-bordered ' style='width:100%' id='tblResultado' >";
    strRetorno += "<thead class='fixed-content'>";
    strRetorno += "<tr align='center'>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Cód</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Cadastro</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Tipo<br>Lançamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Valor</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Dt Vencimento<br>Recebimento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Método de Recebimento<br>Pagamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Status</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Faturamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Pagamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Tipo Operação<br>Planos Conta</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Empresa do <br>lançamento</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Conta do Bancária</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Identificação do<br>Lançamento</font></th>";
    //strRetorno+="<th width='10%'>Grupo Origem<br>do Lançamento</th>";
    strRetorno += "<th width='5%'class='menu_fixo'><font style='font-size: 12px'>Rebido de ?<br>Pago para ?</font></th>";
    //strRetorno+="<th width='10%'>Grupos Centro<br>de Custo</th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Centro de Custo</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Usuário de<br>Cadastro</font></th>";
    strRetorno += "<th width='12%' class='menu_fixo'><font style='font-size: 12px'>Ação</font></th>";
    strRetorno += "</tr>";
    strRetorno += "</thead>";

    //strRetorno+="<div class='overflow-auto' style='height:400px;overflow-y: scroll;' >";
    strRetorno += "<tbody >";

    var objParametros = {
        pk: $("#pk_atrasado").val(),
        dt_vencimento_ini: $("#dt_vencimento_ini_atrasado").val(),
        dt_vencimento_fim: $("#dt_vencimento_fim_atrasado").val(),
        dt_cadastro_ini: $("#dt_cadastro_ini_atrasado").val(),
        dt_cadastro_fim: $("#dt_cadastro_fim_atrasado").val(),
        dt_faturamento_ini: $("#dt_faturamento_ini_atrasado").val(),
        dt_faturamento_fim: $("#dt_faturamento_fim_atrasado").val(),
        tipo_lancamento_pk: 1,
        ic_status_pagamento: $("#ic_status_atrasado").val(),
        empresas_pk: $("#empresa_pk_atrasado").val(),
        tipo_grupo_pk: $("#tipo_grupo_pk_atrasado").val(),
        grupo_leancamento_pk: $("#grupo_leancamento_pk_atrasado").val(),
        usuario_cadastro_pk: $("#usuario_cadastro_pk_atrasado").val()
    };

    var arrCarregar = carregarController("lancamento", "listarLancamentosAtrasado", objParametros);

    if (arrCarregar.result == 'success') {
        if (arrCarregar.data.length > 0) {
            for (i = 0; i < arrCarregar.data.length; i++) {

                strRetorno += "<tr>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_pk'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_cadastro'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_operacao'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + float2moeda(arrCarregar.data[i]['t_vl_lancamento']) + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_vencimento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_metodo_pagamento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_status_pagamento'] + "</font></th>";
                if (arrCarregar.data[i]['dt_faturamento'] != null) {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['dt_faturamento'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                }
                if (arrCarregar.data[i]['t_dt_pagamento'] != null) {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_pagamento'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                }

                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_tipo_operacao'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_razao_social'] + "</font></th>";
                if (arrCarregar.data[i]['t_ds_conta_bancaria'] != null) {
                    strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_conta_bancaria'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'></font></th>";
                }
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_lancamento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_recebido_de'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_recebido_de_centro_custo'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['ds_usuario'] + "</font></th>";
                strRetorno += "<th width='12%' align='center'><a class='function_edit' onclick='fcEditarReceita(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=16 height=16 src='../img/copiar.png'></span></a><a class='function_painel' onclick='fcAbrirModalDocs(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=18 height=18 src='../img/relatorio.jpg' title='Documentos'></span></a><a class='function_painel' onclick='fcImprimirLancamento(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=18 height=18 src='../img/impressora.png' title='Imprimir'></span></a>&nbsp<a class='function_opcoes' onclick='fcExcluirReceita(" + arrCarregar.data[i]['t_pk'] + ", " + arrCarregar.data[i]['t_ic_status_pagamento'] + ");'><span><img width=16 height=16 src='../img/excluir.png'></span></a></th>";
                strRetorno += "</tr>";
            }
        }
    }

    strRetorno += "</tbody>";

    strRetorno += "<tfoot>";
    strRetorno += "<tr>";
    strRetorno += "<th colspan=2>&nbsp;</th>";
    strRetorno += "<th ><font style='font-size: 15px'>Total Valor:</font></th>";
    if (arrCarregar.data.length > 0) {
        strRetorno += "<th ><font style='font-size: 15px'>R$ " + float2moeda(arrCarregar.data[(arrCarregar.data.length - 1)]['t_vl_total']) + "</font></th>";
    }
    else {
        strRetorno += "<th ><font style='font-size: 15px'></font></th>";
    }
    strRetorno += "<th colspan=13>&nbsp;</th>";
    strRetorno += "</tr>";
    strRetorno += "</tfoot>";
    //strRetorno+="</div>";
    strRetorno += "</table>";
    strRetorno += "</div>";
    strRetorno += "</div>";
    //alert(strRetorno);

    $("#gridAtrasado").html(strRetorno);

}
function fcCarregarGriLancamentosDespesaAtrasado() {
    $("#gridDespesaAtrasado").html("");
    $("#gridDespesaAtrasado").append("");

    var strNenhumRegisto = "";
    var strRetorno = "";

    strRetorno += "<div class='row'><div class='col-md-12 tableFixHead'>";
    //strRetorno+="<div class='overflow-auto' style='height:800px;overflow-y: scroll;' >";
    strRetorno += "<table id='tabela' class='table table-striped table-bordered ' style='width:100%' id='tblResultado' >";
    strRetorno += "<thead class='fixed-content'>";
    strRetorno += "<tr align='center'>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Cód</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Cadastro</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Tipo<br>Lançamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Valor</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Dt Vencimento<br>Recebimento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Método de Recebimento<br>Pagamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Status</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Faturamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Pagamento</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Tipo Operação<br>Planos Conta</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Empresa do <br>lançamento</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Conta do Bancária</font></th>";
    strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Identificação do<br>Lançamento</font></th>";
    //strRetorno+="<th width='10%'>Grupo Origem<br>do Lançamento</th>";
    strRetorno += "<th width='5%'class='menu_fixo'><font style='font-size: 12px'>Rebido de ?<br>Pago para ?</font></th>";
    //strRetorno+="<th width='10%'>Grupos Centro<br>de Custo</th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Centro de Custo</font></th>";
    strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Usuário de<br>Cadastro</font></th>";
    strRetorno += "<th width='12%' class='menu_fixo'><font style='font-size: 12px'>Ação</font></th>";
    strRetorno += "</tr>";
    strRetorno += "</thead>";

    //strRetorno+="<div class='overflow-auto' style='height:400px;overflow-y: scroll;' >";
    strRetorno += "<tbody >";

    var objParametros = {
        pk: $("#pk_despesa_atrasado").val(),
        dt_vencimento_ini: $("#dt_vencimento_ini_despesa_atrasado").val(),
        dt_vencimento_fim: $("#dt_vencimento_fim_despesa_atrasado").val(),
        dt_cadastro_ini: $("#dt_cadastro_ini_despesa_atrasado").val(),
        dt_cadastro_fim: $("#dt_cadastro_fim_despesa_atrasado").val(),
        dt_faturamento_ini: $("#dt_faturamento_ini_despesa_atrasado").val(),
        dt_faturamento_fim: $("#dt_faturamento_fim_despesa_atrasado").val(),
        tipo_lancamento_pk: 2,
        ic_status_pagamento: $("#ic_status_despesa_atrasado").val(),
        empresas_pk: $("#empresa_pk_despesa_atrasado").val(),
        tipo_grupo_pk: $("#tipo_grupo_pk_despesa_atrasado").val(),
        grupo_leancamento_pk: $("#grupo_leancamento_pk_despesa_atrasado").val(),
        usuario_cadastro_pk: $("#usuario_cadastro_pk_despesa_atrasado").val()
    };

    var arrCarregar = carregarController("lancamento", "listarLancamentosAtrasado", objParametros);

    if (arrCarregar.result == 'success') {
        if (arrCarregar.data.length > 0) {
            for (i = 0; i < arrCarregar.data.length; i++) {

                strRetorno += "<tr>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_pk'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_cadastro'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_operacao'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + float2moeda(arrCarregar.data[i]['t_vl_lancamento']) + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_vencimento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_metodo_pagamento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_status_pagamento'] + "</font></th>";
                if (arrCarregar.data[i]['dt_faturamento'] != null) {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['dt_faturamento'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                }
                if (arrCarregar.data[i]['t_dt_pagamento'] != null) {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_dt_pagamento'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                }

                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_tipo_operacao'] + "</font></th>";
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_razao_social'] + "</font></th>";
                if (arrCarregar.data[i]['t_ds_conta_bancaria'] != null) {
                    strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_conta_bancaria'] + "</font></th>";
                }
                else {
                    strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'></font></th>";
                }
                strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_lancamento'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_recebido_de'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['t_ds_recebido_de_centro_custo'] + "</font></th>";
                strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['ds_usuario'] + "</font></th>";
                strRetorno += "<th width='12%' align='center'><a class='function_edit' onclick='fcEditarReceita(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=16 height=16 src='../img/copiar.png'></span></a><a class='function_painel' onclick='fcAbrirModalDocs(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=18 height=18 src='../img/relatorio.jpg' title='Documentos'></span></a><a class='function_painel' onclick='fcImprimirLancamento(" + arrCarregar.data[i]['t_pk'] + ")'><span><img width=18 height=18 src='../img/impressora.png' title='Imprimir'></span></a>&nbsp<a class='function_opcoes' onclick='fcExcluirReceita(" + arrCarregar.data[i]['t_pk'] + ", " + arrCarregar.data[i]['t_ic_status_pagamento'] + ");'><span><img width=16 height=16 src='../img/excluir.png'></span></a></th>";
                strRetorno += "</tr>";
            }
        }
    }

    strRetorno += "</tbody>";

    strRetorno += "<tfoot>";
    strRetorno += "<tr>";
    strRetorno += "<th colspan=2>&nbsp;</th>";
    strRetorno += "<th ><font style='font-size: 15px'>Total Valor:</font></th>";
    if (arrCarregar.data.length > 0) {
        strRetorno += "<th ><font style='font-size: 15px'>R$ " + float2moeda(arrCarregar.data[(arrCarregar.data.length - 1)]['t_vl_total']) + "</font></th>";
    }
    else {
        strRetorno += "<th ><font style='font-size: 15px'></font></th>";
    }
    strRetorno += "<th colspan=13 >&nbsp;</th>";
    strRetorno += "</tr>";
    strRetorno += "</tfoot>";
    //strRetorno+="</div>";
    strRetorno += "</table>";
    strRetorno += "</div>";
    strRetorno += "</div>";
    //alert(strRetorno);

    $("#gridDespesaAtrasado").html(strRetorno);

}


function fcImprimirLancamento(pk) {
    sendPost('lancamento_fatura_impressao.php', { token: token, pk: pk });
}


function fcAbrirFormReceita() {
    //limpa os dados de qualquer registro existe
    fcLimparVariavelReceita();

    $(".chzn-select").chosen('destroy');

    $("#modal_receita").modal();

    $(".chzn-select").chosen({ allow_single_deselect: true });
}

function fcListarItensGruposReceita() {

    var objParametros = {
        "tipo_grupo_pk": ""
    };
    if ($("#tipo_grupo_pk_receita").val() == 1) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros);
        //NewWindow(v_last_url);
        carregarComboAjax($("#grupo_leancamento_pk_receita"), arrCarregar, " ", "pk", "ds_lead");
    } else if ($("#tipo_grupo_pk_receita").val() == 2) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);

        carregarComboAjax($("#grupo_leancamento_pk_receita"), arrCarregar, " ", "pk", "ds_colaborador");
    } else if ($("#tipo_grupo_pk_receita").val() == 3) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);
        carregarComboAjax($("#grupo_leancamento_pk_receita"), arrCarregar, " ", "pk", "ds_fornecedor");
    }
}
function fcListarItensGruposDia() {

    var objParametros = {
        "tipo_grupo_pk": ""
    };
    if ($("#tipo_grupo_pk_dia").val() == 1) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros);

        carregarComboAjax($("#grupo_leancamento_pk_dia"), arrCarregar, " ", "pk", "ds_lead");
    } else if ($("#tipo_grupo_pk_dia").val() == 2) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);
        carregarComboAjax($("#grupo_leancamento_pk_dia"), arrCarregar, " ", "pk", "ds_colaborador");
    } else if ($("#tipo_grupo_pk_dia").val() == 3) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);
        carregarComboAjax($("#grupo_leancamento_pk_dia"), arrCarregar, " ", "pk", "ds_fornecedor");
    }
}
function fcListarItensGruposDespesaDia() {

    var objParametros = {
        "tipo_grupo_pk": ""
    };
    if ($("#tipo_grupo_pk_despesa_dia").val() == 1) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros);

        carregarComboAjax($("#grupo_leancamento_pk_despesa_dia"), arrCarregar, " ", "pk", "ds_lead");
    } else if ($("#tipo_grupo_pk_despesa_dia").val() == 2) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);
        carregarComboAjax($("#grupo_leancamento_pk_despesa_dia"), arrCarregar, " ", "pk", "ds_colaborador");
    } else if ($("#tipo_grupo_pk_despesa_dia").val() == 3) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);
        carregarComboAjax($("#grupo_leancamento_pk_despesa_dia"), arrCarregar, " ", "pk", "ds_fornecedor");
    }
}
function fcListarItensGruposAtraso() {

    var objParametros = {
        "tipo_grupo_pk": ""
    };
    if ($("#tipo_grupo_pk_atrasado").val() == 1) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros);

        carregarComboAjax($("#grupo_leancamento_pk_atrasado"), arrCarregar, " ", "pk", "ds_lead");
    } else if ($("#tipo_grupo_pk_atrasado").val() == 2) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);
        carregarComboAjax($("#grupo_leancamento_pk_atrasado"), arrCarregar, " ", "pk", "ds_colaborador");
    } else if ($("#tipo_grupo_pk_atrasado").val() == 3) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);
        carregarComboAjax($("#grupo_leancamento_pk_atrasado"), arrCarregar, " ", "pk", "ds_fornecedor");
    }
}
function fcListarItensGruposDespesaAtraso() {

    var objParametros = {
        "tipo_grupo_pk": ""
    };
    if ($("#tipo_grupo_pk_despesa_atrasado").val() == 1) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros);

        carregarComboAjax($("#grupo_leancamento_pk_despesa_atrasado"), arrCarregar, " ", "pk", "ds_lead");
    } else if ($("#tipo_grupo_pk_despesa_atrasado").val() == 2) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);
        carregarComboAjax($("#grupo_leancamento_pk_despesa_atrasado"), arrCarregar, " ", "pk", "ds_colaborador");
    } else if ($("#tipo_grupo_pk_despesa_atrasado").val() == 3) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);
        carregarComboAjax($("#grupo_leancamento_pk_despesa_atrasado"), arrCarregar, " ", "pk", "ds_fornecedor");
    }
}
function fcListarItensGruposMes() {

    var objParametros = {
        "tipo_grupo_pk": ""
    };
    if ($("#tipo_grupo_pk_mes").val() == 1) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros);

        carregarComboAjax($("#grupo_leancamento_pk_mes"), arrCarregar, " ", "pk", "ds_lead");
    } else if ($("#tipo_grupo_pk_mes").val() == 2) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);
        carregarComboAjax($("#grupo_leancamento_pk_mes"), arrCarregar, " ", "pk", "ds_colaborador");
    } else if ($("#tipo_grupo_pk_mes").val() == 3) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);
        carregarComboAjax($("#grupo_leancamento_pk_mes"), arrCarregar, " ", "pk", "ds_fornecedor");
    }
}
function fcListarItensGruposCentroCustoReceita() {

    var objParametros = {
        "tipo_grupo_pk": ""
    };
    if ($("#tipo_grupo_centro_custo_pk_receita").val() == 1) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros);

        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_receita"), arrCarregar, " ", "pk", "ds_lead");

    } else if ($("#tipo_grupo_centro_custo_pk_receita").val() == 2) {

        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_receita"), arrCarregar, " ", "pk", "ds_colaborador");

    } else if ($("#tipo_grupo_centro_custo_pk_receita").val() == 3) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_receita"), arrCarregar, " ", "pk", "ds_fornecedor");

    }
    else if ($("#tipo_grupo_centro_custo_pk_receita").val() == 4) {
        var arrCarregar = carregarController("equipe", "listarTodos", objParametros);
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_receita"), arrCarregar, " ", "pk", "ds_equipe");
    }
}
function fcListarContaBancariaReceita() {

    var objParametros = {
        "empresas_pk": $("#empresa_modal_receita_pk").val()
    };
    var arrCarregar = carregarController("conta_bancaria", "listarContasLancamento", objParametros);
    if ($("#tipo_lancamento_modal_receita_pk").val() == 6) {
        carregarComboAjax($("#contas_bancarias_pk_receita"), arrCarregar, "", "pk", "ds_dados_conta");
    }
    else {
        carregarComboAjax($("#contas_bancarias_pk_receita"), arrCarregar, " ", "pk", "ds_dados_conta");
    }

}

function fcListarTipoCategoriaReceita() {

    var objParametros = {
        "categorias_financeiras_pk": 2
    };

    var arrCarregar = carregarController("plano_contas", "listaPorCategoria", objParametros);

    carregarComboAjax($("#tipos_operacao_pk_receita"), arrCarregar, " ", "pk", "ds_tipo_operacao");

}
function fcListarMetodosPagamentoReceita() {

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("metodo_pagamento", "listarTodos", objParametros);

    carregarComboAjax($("#metodos_pagamento_pk_receita"), arrCarregar, " ", "pk", "ds_metodo_pagamento");

}
function fcListarTipoCategoriaReceita() {

    var objParametros = {
        "categorias_financeiras_pk": 2
    };

    var arrCarregar = carregarController("plano_contas", "listaPorCategoria", objParametros);

    carregarComboAjax($("#tipos_operacao_pk_receita"), arrCarregar, " ", "pk", "ds_tipo_operacao");

}

function fcCarregarDadosBancariosColaborador() {
    $("#listar_conta_bancaria").html("");
    $("#listar_conta_bancaria").append("");

    var strNenhumRegisto = "";
    var strRetorno = "";



    var objParametros = {
        pk: $("#grupo_leancamento_pk_receita").val()
    };

    var arrCarregar = carregarController("colaborador", "listarDadosBancarios", objParametros);

    if (arrCarregar.result == 'success') {
        if (arrCarregar.data.length > 0) {

            if (arrCarregar.data[0]['ds_agencia'] != null) {
                //strRetorno+="<div class='overflow-auto' style='height:800px;overflow-y: scroll;' >";
                strRetorno += "<table id='tabela' class='table table-striped table-bordered ' style='width:100%'>";
                strRetorno += "<thead class='fixed-content'>";
                strRetorno += "<tr align='center'>";
                strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Banco</font></th>";
                strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Agência</font></th>";
                strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Conta</font></th>";
                strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Pix</font></th>";
                strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Favorecido</font></th>";
                strRetorno += "</tr>";
                strRetorno += "</thead>";

                //strRetorno+="<div class='overflow-auto' style='height:400px;overflow-y: scroll;' >";
                strRetorno += "<tbody >";
            }



            for (i = 0; i < arrCarregar.data.length; i++) {

                if (arrCarregar.data[i]['ds_agencia'] != null) {
                    strRetorno += "<tr>";
                    if (arrCarregar.data[i]['ds_banco'] != null) {
                        strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['ds_banco'] + "</font></th>";
                    }
                    else {
                        strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'></font></th>";
                    }

                    if (arrCarregar.data[i]['ds_pix'] == null) {
                        var v_ds_pis = "";
                    } else {
                        var v_ds_pis = arrCarregar.data[i]['ds_pix'];
                    }

                    if (arrCarregar.data[i]['ds_conta_favorecido'] == null) {
                        var v_ds_conta_favorecido = "";
                    } else {
                        var v_ds_conta_favorecido = arrCarregar.data[i]['ds_conta_favorecido'];
                    }



                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['ds_agencia'] + "</font></th>";
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['ds_conta'] + "</font></th>";
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + v_ds_pis + "</font></th>";
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + v_ds_conta_favorecido + "</font></th>";
                    strRetorno += "</tr>";
                }
            }
        }
    }

    strRetorno += "</tbody>";

    strRetorno += "</table>";
    //alert(strRetorno);

    $("#listar_conta_bancaria").html(strRetorno);
}
function fcCarregarDadosBancariosFornecedor() {
    $("#listar_conta_bancaria").html("");
    $("#listar_conta_bancaria").append("");

    var strNenhumRegisto = "";
    var strRetorno = "";



    var objParametros = {
        pk: $("#grupo_leancamento_pk_receita").val()
    };

    var arrCarregar = carregarController("fornecedor", "listarDadosBancarios", objParametros);

    if (arrCarregar.result == 'success') {
        if (arrCarregar.data.length > 0) {
            if (arrCarregar.data[0]['ds_agencia'] != null) {
                //strRetorno+="<div class='overflow-auto' style='height:800px;overflow-y: scroll;' >";
                strRetorno += "<table id='tabela' class='table table-striped table-bordered ' style='width:100%'>";
                strRetorno += "<thead class='fixed-content'>";
                strRetorno += "<tr align='center'>";
                strRetorno += "<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Banco</font></th>";
                strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Agência</font></th>";
                strRetorno += "<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Conta</font></th>";
                strRetorno += "</tr>";
                strRetorno += "</thead>";

                //strRetorno+="<div class='overflow-auto' style='height:400px;overflow-y: scroll;' >";
                strRetorno += "<tbody >";
            }



            for (i = 0; i < arrCarregar.data.length; i++) {
                if (arrCarregar.data[i]['ds_agencia'] != null) {
                    strRetorno += "<tr>";
                    if (arrCarregar.data[i]['ds_banco'] != null) {
                        strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['ds_banco'] + "</font></th>";
                    }
                    else {
                        strRetorno += "<th width='10%' align='center'><font style='font-size: 13px'></font></th>";
                    }
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['ds_agencia'] + "</font></th>";
                    strRetorno += "<th width='5%' align='center'><font style='font-size: 13px'>" + arrCarregar.data[i]['ds_conta'] + "</font></th>";

                    strRetorno += "</tr>";
                }
            }
        }
    }

    strRetorno += "</tbody>";

    strRetorno += "</table>";
    //alert(strRetorno);

    $("#listar_conta_bancaria").html(strRetorno);
}



function fcEnviarReceita() {


    var contratos_pk = "";
    if ($('input:radio[name=contratos_pk_radio]:checked').val() == undefined) {
        contratos_pk = "";
    }
    else {
        contratos_pk = $('input:radio[name=contratos_pk_radio]:checked').val();
    }

    if ($('#tipo_lancamento_modal_receita_pk').val() == "") {
        $("#alert_tipo_lancamento").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_tipo_lancamento").slideUp(500);
        });
        $('#tipo_lancamento_modal_receita_pk').focus();
        return false;
    }
    if ($('#tipos_operacao_pk_receita').val() == "") {
        $("#alert_tipo_operacao").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_tipo_operacao").slideUp(500);
        });
        $('#tipos_operacao_pk_receita').focus();
        return false;
    }

    if ($('#tipo_lancamento_modal_receita_pk').val() != 6) {
        if ($('#contas_bancarias_pk_receita').val() == "") {
            $("#alert_banco").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_banco").slideUp(500);
            });
            $('#contas_bancarias_pk_receita').focus();
            return false;
        }
    }
    if ($('#ds_lancamento_receita').val() == "") {
        $("#alert_ds_lancamento").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_ds_lancamento").slideUp(500);
        });
        $('#ds_lancamento_receita').focus();
        return false;
    }
    if ($('#tipo_grupo_pk_receita').val() == "") {
        $("#alert_tipo_grupo").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_tipo_grupo").slideUp(500);
        });
        $('#tipo_grupo_pk_receita').focus();
        return false;
    }
    if ($('#vl_lancamento_receita').val() == "") {
        $("#alert_valor").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_valor").slideUp(500);
        });
        $('#vl_lancamento_receita').focus();
        return false;
    }
    if ($('#metodos_pagamento_pk_receita').val() == "") {
        $("#alert_metodo").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_metodo").slideUp(500);
        });
        $('#metodos_pagamento_pk_receita').focus();
        return false;
    }
    if ($('#dt_vencimento_receita').val() == "") {
        $("#alert_dt_vencimento").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_dt_vencimento").slideUp(500);
        });
        $('#dt_vencimento_receita').focus();
        return false;
    }




    if ($('#ic_status_pagamento_receita').val() == "") {
        $("#alert_status").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_status").slideUp(500);
        });
        $('#ic_status_pagamento_receita').focus();
        return false;
    }
    if ($('#ic_status_pagamento_receita').val() == 1) {
        if ($("#dt_pagamento_receita").val() == "") {
            $("#alert_data_pagamento").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_data_pagamento").slideUp(500);
            });
            $('#dt_pagamento_receita').focus();
            return false;
        }
    }
    if ($('#tipo_grupo_centro_custo_pk_receita').val() == 1) {
        if ($("#dt_faturamento_receita").val() == "") {
            $("#alert_dt_faturamento").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_dt_faturamento").slideUp(500);
            });
            $('#dt_faturamento_receita').focus();
            return false;
        }
    }









    var objParametros = {
        "pk": $("#lancamento_receita_pk").val(),
        "dt_vencimento": $("#dt_vencimento_receita").val(),
        "ds_lancamento": $("#ds_lancamento_receita").val(),
        "vl_lancamento": moeda2float($("#vl_lancamento_receita").val()),
        "tipo_grupo_pk": $("#tipo_grupo_pk_receita").val(),
        "grupo_leancamento_pk": $("#grupo_leancamento_pk_receita").val(),
        "ic_status_pagamento": $("#ic_status_pagamento_receita").val(),
        "dt_competencia": $("#dt_competencia_receita").val(),
        "n_documento": $("#n_documento_receita").val(),
        "tipos_operacao_pk": $("#tipos_operacao_pk_receita").val(),
        "metodos_pagamento_pk": $("#metodos_pagamento_pk_receita").val(),
        "contas_bancarias_pk": $("#contas_bancarias_pk_receita").val(),
        "empresas_pk": $("#empresa_modal_receita_pk").val(),
        "tipo_grupo_centro_custo_pk": $("#tipo_grupo_centro_custo_pk_receita").val(),
        "grupo_lancamento_centro_custo_pk": $("#grupo_lancamento_centro_custo_pk_receita").val(),
        "dt_pagamento": $("#dt_pagamento_receita").val(),
        "dt_faturamento": $("#dt_faturamento_receita").val(),
        "contratos_pk": contratos_pk,
        //"ds_ocorrencia": $("#ds_ocorrencia_receita").val(),
        "operacao_pk": $("#tipo_lancamento_modal_receita_pk").val()
    };

    var arrEnviar = carregarController("lancamento", "salvar", objParametros);


    if (arrEnviar.result == 'success') {
        // Reload datable
        alert(arrEnviar.message);
        if ($("#lancamento_receita_pk").val() == "") {
            $("#lancamento_receita_pk").val(arrEnviar.data[0]['pk']);
        }

        $("#modal_receita").modal("hide");

        $("select[id='empresas_pk']").val($("#empresa_modal_receita_pk").val());

        $("#empresas_pk").val($("#empresa_modal_receita_pk").val());



        fcCarregarComboContas();

        $("select[id='contas_pk']").val($("#contas_bancarias_pk_receita").val());
        $("#contas_pk").val($("#contas_bancarias_pk_receita").val());


        if (confirm("Deseja visualizar a Impressão do Lançamento ? ")) {
            fcImprimirLancamento($("#lancamento_receita_pk").val());
        }
        else {

            fcDatasCaleandario($("#ic_mes").val(), $("#ds_ano").val());

        }



        //FATURAMENTO 


        /*setTimeout(function(){
            fcCarregarGriLancamentosMes();
            fcCarregarGriLancamentosVencidoReceitaDia();
            fcCarregarGriLancamentosVencidoDespesaDia();
            fcCarregarGriLancamentosReceitaAtrasado();
            fcCarregarGriLancamentosDespesaAtrasado();


            fcCarregarGraficoLinha();
            fcCarregarExtrato();
        }, 500);*/

    }
    else {
        alert('Falhou a requisição para salvar o registro');
    }
}

function carregarComboEmpresaReceitaCaixinha() {
    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("conta", "listarEmpresaCaixinha", objParametros);

    carregarComboAjax($("#empresa_modal_receita_pk"), arrCarregar, "", "pk", "ds_razao_social");
}


function fcSelecionaGrupo() {
    if ($("#tipo_grupo_pk_receita").val() == 1) {
        fcListaComboLeadsClientes();
        $("#div_grupos_lancamento_lead").show();
        $("#div_grupos_lancamento_colaborador").hide();
        $("#div_grupos_lancamento_fornecedor").hide();
    } else if ($("#tipo_grupo_pk_receita").val() == 2) {

        $("#div_grupos_lancamento_lead").hide();
        $("#div_grupos_lancamento_colaborador").show();
        $("#div_grupos_lancamento_fornecedor").hide();
    } else if ($("#tipo_grupo_pk_receita").val() == 3) {
        $("#div_grupos_lancamento_lead").hide();
        $("#div_grupos_lancamento_colaborador").hide();
        $("#div_grupos_lancamento_fornecedor").show();
    } else if ($("#tipo_grupo_pk_receita").val() == '') {
        $("#div_grupos_lancamento_lead").hide();
        $("#div_grupos_lancamento_colaborador").hide();
        $("#div_grupos_lancamento_fornecedor").hide();
    }
}

function fcListaComboLeadsClientes() {
    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("lead", "listaLeadsClientes", objParametros);

    carregarComboAjax($("#leads_clientes_pk"), arrCarregar, " ", "pk", "ds_lead");

}

function fcListaComboLeadsPostosTrabalho() {
    var objParametros = {
        "pk": $("#leads_clientes_pk").val()
    };

    var arrCarregar = carregarController("lead", "listaLeadsPostosTrabalho", objParametros);
    carregarComboAjax($("#leads_posto_trabalho_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fcListaComboLeadsContratos() {
    var objParametros = {
        "leads_pk": $("#leads_posto_trabalho_pk").val()
    };

    var arrCarregar = carregarController("contrato", "listaLeadContratos", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#contratos_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fcListaColaborador() {
    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("colaborador", "listaColaborador", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");
}


$(document).ready(function () {
    //RECEITA 
    $(document).on('click', '#cmdIncluirReceita', fcAbrirFormReceita);
    $(document).on('click', '#cmdPesquisarDia', fcCarregarGriLancamentosVencidoReceitaDia);
    $(document).on('click', '#cmdPesquisarDespesaDia', fcCarregarGriLancamentosVencidoDespesaDia);
    $(document).on('click', '#cmdPesquisarAtrasado', fcCarregarGriLancamentosReceitaAtrasado);
    $(document).on('click', '#cmdPesquisarDespesaAtrasado', fcCarregarGriLancamentosDespesaAtrasado);
    $(document).on('click', '#cmdPesquisarMes', fcCarregarGriLancamentosMes);

    $("#leads_clientes_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListaComboLeadsPostosTrabalho();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });


    $("#leads_posto_trabalho_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListaComboLeadsContratos();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });


    $("#tipo_grupo_pk_dia").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposDia();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $("#tipo_grupo_pk_despesa_dia").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposDespesaDia();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $("#tipo_grupo_pk_atrasado").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposAtraso();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $("#tipo_grupo_pk_despesa_atrasado").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposDespesaAtraso();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $("#tipo_grupo_pk_mes").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposMes();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });

    $("#tipo_grupo_pk_receita").change(function () {
        $(".chzn-select").chosen('destroy');
        fcSelecionaGrupo();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });


    /*$("#tipo_grupo_pk_receita").change(function(){ 
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposReceita();   
        $(".chzn-select").chosen({allow_single_deselect: true});
    });*/

    $("#tipo_grupo_centro_custo_pk_receita").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposCentroCustoReceita();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $("#empresa_modal_receita_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarContaBancariaReceita();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });

    $(".recebido_de_pago_para").html("Recebido de ?:");
    $(".metodo_recebimento_pagamento").html("Método de Recebimento:");
    $("#tipo_lancamento_modal_receita_pk").change(function () {
        if ($("#tipo_lancamento_modal_receita_pk").val() == 1) {
            $(".recebido_de_pago_para").html("Recebido de ?:");
            $(".metodo_recebimento_pagamento").html("Método de Recebimento:");
        }
        else {
            $(".recebido_de_pago_para").html("Pago para ?:");
            $(".metodo_recebimento_pagamento").html("Método de Pagamento:");
        }


        //LISTAR EMPRESA CAIXINHA
        if ($("#tipo_lancamento_modal_receita_pk").val() == 6) {

            $(".chzn-select").chosen('destroy');
            carregarComboEmpresaReceitaCaixinha();
            fcListarContaBancariaReceita();
            $(".chzn-select").chosen({ allow_single_deselect: true });
        }
        else {

            $(".chzn-select").chosen('destroy');
            carregarComboEmpresaPk();
            fcListarContaBancariaReceita();
            $(".chzn-select").chosen({ allow_single_deselect: true });
        }

    });
    //carregarComboEmpresaReceita();

    fcListarTipoCategoriaReceita();

    fcListarContaBancariaReceita();

    fcListarMetodosPagamentoReceita();

    fcValidarFormReceita();
    var data = new Date();
    var dia = String(data.getDate()).padStart(2, '0');
    var mes = String(data.getMonth() + 1).padStart(2, '0');
    var ano = data.getFullYear();
    var dataAtual = dia + '/' + mes + '/' + ano;

    $(".DataAtual").text(dataAtual);

    $('#dt_vencimento_receita').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date());
    $("#dt_vencimento_receita").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_competencia_receita').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date());
    $("#dt_competencia_receita").keypress(function () {
        mascara(this, mdata);
    });

    $("#vl_lancamento_receita").keypress(function () {
        mascara(this, moeda);
    });

    $('#dt_cadastro_ini_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_ini_dia").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_cadastro_fim_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_fim_dia").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_faturamento_ini_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_ini_dia").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_faturamento_fim_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_fim_dia").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_vencimento_ini_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_ini_dia").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_vencimento_fim_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_fim_dia").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_cadastro_ini_despesa_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_ini_despesa_dia").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_cadastro_fim_despesa_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_fim_despesa_dia").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_faturamento_ini_despesa_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_ini_despesa_dia").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_faturamento_fim_despesa_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_fim_despesa_dia").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_vencimento_ini_despesa_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_ini_despesa_dia").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_vencimento_fim_despesa_dia').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_fim_despesa_dia").keypress(function () {
        mascara(this, mdata);
    });


    $('#dt_cadastro_ini_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_ini_atrasado").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_cadastro_fim_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_fim_atrasado").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_faturamento_ini_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_ini_atrasado").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_faturamento_fim_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_fim_atrasado").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_vencimento_ini_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_ini_atrasado").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_vencimento_fim_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_fim_atrasado").keypress(function () {
        mascara(this, mdata);
    });


    $('#dt_cadastro_ini_despesa_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_ini_despesa_atrasado").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_cadastro_fim_despesa_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_fim_despesa_atrasado").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_faturamento_ini_despesa_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_ini_despesa_atrasado").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_faturamento_fim_despesa_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_fim_despesa_atrasado").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_vencimento_ini_despesa_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_ini_despesa_atrasado").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_vencimento_fim_atrasado').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_fim_despesa_atrasado").keypress(function () {
        mascara(this, mdata);
    });


    $('#dt_cadastro_ini_mes').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_ini_mes").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_cadastro_fim_mes').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_fim_mes").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_faturamento_ini_mes').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_ini_mes").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_faturamento_fim_mes').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_fim_mes").keypress(function () {
        mascara(this, mdata);
    });


    $('#dt_vencimento_ini_mes').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_ini_mes").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_vencimento_fim_mes').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();

    $("#dt_vencimento_fim_mes").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_pagamento_ini_mes').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_pagamento_ini_mes").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_pagamento_fim_mes').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();

    $("#dt_pagamento_fim_mes").keypress(function () {
        mascara(this, mdata);
    });


    $('#dt_pagamento_receita').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();

    $("#dt_pagamento_receita").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_faturamento_receita').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();

    $("#dt_faturamento_receita").keypress(function () {
        mascara(this, mdata);
    });



    $("#pk_dia").keypress(function () {
        mascara(this, soNumeros);
    });
    $("#pk_despesa_dia").keypress(function () {
        mascara(this, soNumeros);
    });
    $("#pk_atrasado").keypress(function () {
        mascara(this, soNumeros);
    });
    $("#pk_despesa_atrasado").keypress(function () {
        mascara(this, soNumeros);
    });
    $("#pk_mes").keypress(function () {
        mascara(this, soNumeros);
    });

    $("#exibir_dt_pagamento").hide();

    $("#ic_status_pagamento_receita").change(function () {
        if ($("#ic_status_pagamento_receita").val() == 1) {
            $("#exibir_dt_pagamento").show();
        }
        else {
            $("#exibir_dt_pagamento").hide();
            $("#dt_pagamento").val("");
        }

    });


    $(document).on('change', 'input[type=radio][name=contratos_pk_radio]', function (event) {
        fcCarregarValorContrato();
    });

    $("#grupo_lancamento_centro_custo_pk_receita").change(function () {

        if ($("#grupo_lancamento_centro_custo_pk_receita").val() != "") {
            if ($("#tipos_operacao_pk_receita").val() == 1000) {
                if ($("#tipo_grupo_centro_custo_pk_receita").val() == 1) {
                    if ($("#grupo_lancamento_centro_custo_pk_receita").val() != "") {
                        $("#contratos_ins_pk").val("");
                        fcGridContrato();
                    }

                }

            }
            else if ($("#tipos_operacao_pk_receita").val() == 1001) {
                if ($("#tipo_grupo_centro_custo_pk_receita").val() == 1) {
                    if ($("#grupo_lancamento_centro_custo_pk_receita").val() != "") {
                        $("#contratos_ins_pk").val("");
                        fcGridContrato();
                    }

                }
            }
            else if ($("#tipos_operacao_pk_receita").val() == 1002) {
                if ($("#tipo_grupo_centro_custo_pk_receita").val() == 1) {
                    if ($("#grupo_lancamento_centro_custo_pk_receita").val() != "") {
                        $("#contratos_ins_pk").val("");
                        fcGridContrato();
                    }

                }
            }
            else {
                $("#grid_contrato").empty();
                $("#grid_contrato").append("");
            }
        }
        else {
            $("#grid_contrato").empty();
            $("#grid_contrato").append("");
            $("#vl_lancamento_receita").val("");
        }


    });

    $("#tipo_grupo_pk_receita").change(function () {
        $("#listar_conta_bancaria").empty();
        $("#listar_conta_bancaria").append("");

        if ($("#tipo_grupo_pk_receita").val() != "") {
            if ($("#tipo_grupo_pk_receita").val() == 2) {
                //COLABORADOR
                $("#grupo_leancamento_pk_receita").change(function () {
                    if ($("#grupo_leancamento_pk_receita").val() != "") {
                        $("#listar_conta_bancaria").empty();
                        $("#listar_conta_bancaria").append("");
                        fcCarregarDadosBancariosColaborador();
                    }
                    else {
                        $("#listar_conta_bancaria").empty();
                        $("#listar_conta_bancaria").append("");
                    }
                });



            }
            else if ($("#tipo_grupo_pk_receita").val() == 3) {
                //FORNECEDOR
                $("#grupo_leancamento_pk_receita").change(function () {
                    if ($("#grupo_leancamento_pk_receita").val() != "") {
                        $("#listar_conta_bancaria").empty();
                        $("#listar_conta_bancaria").append("");
                        fcCarregarDadosBancariosFornecedor();
                    }
                    else {
                        $("#listar_conta_bancaria").empty();
                        $("#listar_conta_bancaria").append("");
                    }
                });


            }
            else {
                $("#listar_conta_bancaria").empty();
                $("#listar_conta_bancaria").append("");
            }
        }
        else {
            $("#listar_conta_bancaria").empty();
            $("#listar_conta_bancaria").append("");
        }
    });



    //Receita DIa
    var objParametros = {
        "ds_dominio_modulo": "grid_receita_dia",
        "ic_acao": "ins"
    };

    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);

    if (arrCarregar.result == 'success') {
        $("#exibir_grid_receita_dia").show();
    } else {
        $("#exibir_grid_receita_dia").hide();
    }

    //Despesa dia
    var objParametros = {
        "ds_dominio_modulo": "grid_despesa_dia",
        "ic_acao": "ins"
    };

    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);

    if (arrCarregar.result == 'success') {
        $("#exibir_grid_despesa_dia").show();
    } else {
        $("#exibir_grid_despesa_dia").hide();
    }


    //$("#exibir_grid_despesa_dia").show();


    //$("#exibir_grid_receita_atrasado").show();
    //Recenta_atroaso
    var objParametros = {
        "ds_dominio_modulo": "grid_despesa_atrasado",
        "ic_acao": "ins"
    };

    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);

    if (arrCarregar.result == 'success') {

        $("#exibir_grid_despesa_atrasado").show();
    } else {

        $("#exibir_grid_despesa_atrasado").hide();
    }



    //Despesa_atroaso
    var objParametros = {
        "ds_dominio_modulo": "grid_receita_atrasado",
        "ic_acao": "ins"
    };

    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);

    if (arrCarregar.result == 'success') {

        $("#exibir_grid_receita_atrasado").show();
    } else {

        $("#exibir_grid_receita_atrasado").hide();
    }

    //$("#exibir_grid_despesa_atrasado").show();


    // $("#exibir_grid_lancamento_mes").show();



    $("#exibir_opc_caixinha").hide();

    var objParametros = {
        "ds_dominio_modulo": "tipo_lancamento_caixinha",
        "ic_acao": "ins"
    };

    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);
    if (arrCarregar.result != 'success') {
        $("#exibir_opc_caixinha").hide();
    }
    else {
        $("#exibir_opc_caixinha").show();
    }

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros);

    var ds_usuario_logado = arrCarregar.data[0]['ds_usuario']

    var objParametros = {
        "ds_usuario": ds_usuario_logado
    };

    var arrCarregar = carregarController("usuario", "listarDataTable", objParametros);

    if (arrCarregar.data[0]['t_ds_grupo'] != "Administração do Sistema") {
        $("#usuario_cadastro_pk_mes").val(arrCarregar.data[0]['t_pk'])
        $("#usuario_cadastro_pk_mes").prop('disabled', 'disabled');
    }

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisarReceita);
    $(document).on('click', '#cmdIncluir', fcIncluirReceita);

});


