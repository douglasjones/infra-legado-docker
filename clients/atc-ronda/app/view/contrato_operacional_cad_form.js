var tblContratoItens = "";
var tblPrdutosItens = "";
//SALVA O CONTRATO
function fcSalvarContrato() {

    var strJsonFaturamentoContrato = fcFormatarDadosContratoFaturamento();

    if ($("#qtde_parcelas_pk").val() != "") {
        if (strJsonFaturamentoContrato == 1) {
            alert("Data Pagamento, Data Faturamento e Valor Pagamento sÃ£o ObrigatÃ³rios");
            return false;
        }
    }
    var v_qtde_parcelas_pk = "";
    if (strJsonFaturamentoContrato == 1) {
        if ($("#qtde_parcelas_pk").val() != "") {
            v_qtde_parcelas_pk = $("#qtde_parcelas_pk").val();
        }
    }

    if ($("#empresas_pk").val() == "") {
        $("#alert_empresa").show();
        $("#alert_empresa").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_empresa").slideUp(500);
        });
        return false;
    }
    if ($("#leads_pk_cad_form").val() == "") {
        $("#alert_posto").show();
        $("#alert_posto").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_posto").slideUp(500);
        });
        return false;
    }
    if ($("#dt_inicio_contrato").val() == "") {
        $("#alert_data").show();
        $("#alert_data").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_data").slideUp(500);
        });
        return false;
    }
    if ($("#dt_fim_contrato").val() == "") {
        $("#alert_data").show();
        $("#alert_data").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_data").slideUp(500);
        });
        return false;
    }

    var strJSONDadosTabela = fcFormatarDadosContratoProcesso();
    if (strJSONDadosTabela == "")
        return false;

    var ic_tipo_contrato = 1;
    var v_dt_cancelamento = 0;

    if ($("#ic_contrato").is(":checked") == true) {
        ic_tipo_contrato = 1;
        $('#contrato_pai_pk').val("null");
    }

    else if ($("#ic_aditivo").is(":checked") == true) {
        ic_tipo_contrato = 2;
        if ($('#contrato_pai_pk').val() == "") {
            $("#alert_contrato_pai").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_contrato_pai").slideUp(500);
            });
            $('#contrato_pai_pk').focus();
            return false;
        }
    }
    else if ($("#ic_servico_extra").is(":checked") == true) {
        ic_tipo_contrato = 3;
        $('#contrato_pai_pk').val("null");
    }

    if ($('#dt_cancelamento_contrato').is(":checked")) {
        v_dt_cancelamento = 1;
    } else {
        v_dt_cancelamento = 2;
    }

    var v_vl_mao_oabra = "";
    if ($('#vl_total_mao_obra').html() != '') {
        v_vl_mao_oabra = moeda2float($('#vl_total_mao_obra').html());
    }


    //atualiza o registro no DB, pois jÃ¡ existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#contratos_pk").val(),
        "dt_inicio_contrato": $("#dt_inicio_contrato").val(),
        "dt_fim_contrato": $("#dt_fim_contrato").val(),
        "leads_pk": $("#leads_pk_cad_form").val(),
        "processos_etapas_pk": $('#processos_etapas_pk_1').val(),
        "ic_tipo_contrato": ic_tipo_contrato,
        "contratos_pk": $('#contrato_pai_pk').val(),
        "empresas_pk": $('#empresas_pk').val(),
        "ic_lancar_financeiro": $('#ic_lancar_financeiro').val(),
        "metodos_pagamento_pk": $('#metodos_pagamento_pk').val(),
        "qtde_parcelas_pk": v_qtde_parcelas_pk,
        "vl_total_mao_obra": v_vl_mao_oabra,
        "contratos_itens": strJSONDadosTabela,
        "contrato_dados_faturamento": strJsonFaturamentoContrato,
        "dt_cancelamento": v_dt_cancelamento,
        "ds_obs_motivo_cancelamento": $("#ds_obs_motivo_cancelamento_contrato").val(),
        "ds_identificacao_area": $("#ds_identificacao_area").val(),
        "vl_contrato": $("#vl_contrato").val()
    };
    
    var arrEnviar = carregarController("contrato", "salvar", objParametros);

    if (arrEnviar.result == 'success') {
        //SALVA PRODUTOS ITENS        

        var data = tblPrdutosItens.rows().data();        
            //exclui os itens atuais 
            var objParametros0 = {
                "pk": arrEnviar.data[0]['pk']
            };            
            var arrEnviar0 = carregarController("contrato", "excluirProdutosItens", objParametros0);

        if (data.length > 0) {       
            for (i = 0; i < data.length; i++) {
                var objParametros = {
                    "pk": arrEnviar.data[0]['pk'],
                    "categorias_produto_pk": data[i]['categorias_produto_pk'],
                    "produtos_pk": data[i]['produtos_pk'],
                    "n_qtde_item": data[i]['n_qtde_item'],
                    "vl_item_produto": moeda2float(data[i]['vl_item_produto'])
                };
                var arrEnviar1 = carregarController("contrato", "salvarProdutosItens", objParametros);
            }
        }

        alert(arrEnviar.message);
        $("#janela_contratos").modal("hide");
        fcRecarregarGridContratos();
    } else {
        alert(arrEnviar.result);
    }
    return true;
}

function fcRecarregarGridContratos() {
    tblContratos.ajax.reload();
}

function fcLimparFormContrato() {
    $(".chzn-select").chosen('destroy');
    $("#leads_pk_cad_form").val("");
    $("#leads_clientes_cad_pk").val("");
    $("#empresas_pk").val("");
    $("#contratos_pk").val("");
    $('#contrato_pai_pk').val("");
    $("#dt_inicio_contrato").val("");
    $("#dt_fim_contrato").val("");
    $('#dt_cancelamento_contrato').prop('checked', false);
    $("input[id=dt_cancelamento_contrato]").prop("disabled", false);
    $("#ds_obs_motivo_cancelamento_contrato").val("");
    $("input[id=ds_obs_motivo_cancelamento_contrato]").prop("disabled", false);
    $('#ic_contrato').prop('checked', false);
    $('#ic_aditivo').prop('checked', false);
    $('#ic_servico_extra').prop('checked', false);
    $('#exib_contrato_pai').hide();
    $("#exibir_servico_extra").hide();
    $("#categorias_produto_pk").val("");
    $("#produtos_pk").val("");
    $("#n_qtde_item").val("");
    $("#vl_item_produto").val("");
    $("#ds_identificacao_area").val("");
    $("#vl_total_mao_obra").html("");
    $("#vl_contrato").val("");
}

//Novo Contrato
function fcIncluirContrato() {
    $(".chzn-select").chosen('destroy');
    fcLimparFormContrato();

    tblContratoItens = $('#tblContratoItens').DataTable({
        retrieve: true,
        paging: false
    });
    //tblContratoItens.clear().destroy();
    carregarListaComboProdutoContrato();

    tblPrdutosItens = $('#tblPrdutosItens').DataTable({
        retrieve: true,
        paging: false
    });
    tblPrdutosItens.clear().destroy();
    fcAtualizarDadosGridProdutoItens();
    $(".chzn-select").chosen('destroy');


    //coloca aqui a parte para carregas os combos de ambos

    
    
    setTimeout(function(){
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true }); 
    }, 1000);

    //fcCarregarLeadsContrato();
    $("#janela_contratos").modal();
}

//Editar contrato
function fcEditarContrato(objRegistro) {
    fcLimparFormContrato();
  
    //Verifica a permisso de acesso na edição
    var objParametros = {
        "ds_dominio_modulo": "contrato",
        "ic_acao": "upd"
    };
    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);
    if (arrCarregar.result != 'success') {
        alert("Você não tem Permissão");
        return false;
    }

    var objParametros = {
        "pk": objRegistro['t_pk']
    };

    //var arrCarregar = montarUrlController("contrato", "listarContratoOperacional", objParametros);
    var arrCarregar = carregarController("contrato", "listarContratoOperacional", objParametros);
    //NewWindow(v_last_url)

    if (arrCarregar.result == 'success') {
        //arrCarregar.data[0]['ult_dt_pagamento']
        
        $(".chzn-select").chosen('destroy');
        $("#ds_identificacao_area").val(arrCarregar.data[0]['t_ds_identificacao_area']);
        $("#leads_clientes_cad_pk").val();
        $("#processos_pk_cad_form").val(arrCarregar.data[0]['t_processos_pk']);
        $('#dt_cancelamento_contrato').prop('checked', false);
        $("input[id=dt_cancelamento_contrato]").prop("disabled", false);
        $("#ds_obs_motivo_cancelamento_contrato").val("");
        $("input[id=ds_obs_motivo_cancelamento_contrato]").prop("disabled", false);
        $("#contratos_pk").val(arrCarregar.data[0]['t_pk']);
        $("#dt_inicio_contrato").val(arrCarregar.data[0]['t_dt_inicio_contrato']);
        $("#dt_fim_contrato").val(arrCarregar.data[0]['t_dt_fim_contrato']);
        $("#empresas_pk").val(arrCarregar.data[0]['t_empresas_pk']);
        $("#exibir_motivo_cancelamento_contrato").hide();
        $("#dt_cancelamento_contrato").prop('checked', false);
        $("input[id=dt_cancelamento_contrato]").prop("disabled", false);

        if (arrCarregar.data[0]['t_leads_cliente_pk'] != null) {
            $(".chzn-select").chosen('destroy');
            $("#leads_clientes_cad_pk").val(arrCarregar.data[0]['t_leads_cliente_pk']);

        } else {
            
            $(".chzn-select").chosen('destroy');
            $("#leads_clientes_cad_pk").val(arrCarregar.data[0]['t_leads_postotrabalho_pk']);
        }

        if (arrCarregar.data[0]['t_leads_postotrabalho_pk'] != null) {
            $(".chzn-select").chosen('destroy');
            $("#leads_pk_cad_form").val(arrCarregar.data[0]['t_leads_postotrabalho_pk']);

        } 

        if (arrCarregar.data[0]['t_dt_cancelamento'] != null) {
            $('#dt_cancelamento_contrato').prop('checked', true);
            $('#exibir_motivo_cancelamento_contrato').show();
            $("#ds_obs_motivo_cancelamento_contrato").val(objRegistro['t_ds_obs_motivo_cancelamento']);
            if (arrCarregar.data[0]['t_ds_obs_motivo_cancelamento'] != null) {
                $("input[id=ds_obs_motivo_cancelamento_contrato]").prop("disabled", true);
            }
            $("input[id=dt_cancelamento_contrato]").prop("disabled", true);
        }

        //seleciona o tipo de contrato
        if (arrCarregar.data[0]['t_ic_tipo_contrato'] == 1) {
            $('#ic_contrato').prop('checked', true);
            $('#ic_aditivo').prop('checked', false);
            $('#ic_servico_extra').prop('checked', false);
            $('#contrato_pai_pk').val("");
            $('#exib_contrato_pai').hide();
            $("#exibir_servico_extra").hide();
        } else if (arrCarregar.data[0]['t_ic_tipo_contrato'] == 2) {
            $('#ic_contrato').prop('checked', false);
            $('#ic_servico_extra').prop('checked', false);
            $('#ic_aditivo').prop('checked', true);
            $("#contrato_pai_pk").val(objRegistro['t_contratos_pk']);
            $('#exib_contrato_pai').show();
            $("#exibir_servico_extra").hide();
            //carregarComboContratoPai(objRegistro['t_contratos_pk']);
        } else if (arrCarregar.data[0]['t_ic_tipo_contrato'] == 3) {
            $(".chzn-select").chosen('destroy');
            $('#ic_contrato').prop('checked', false);
            $('#ic_servico_extra').prop('checked', true);
            $('#ic_aditivo').prop('checked', false);
            $("#contrato_pai_pk").val("");
            $('#exib_contrato_pai').hide();
            $("#exibir_servico_extra").show();
            fcListarMetodosPagamentoContrato();
            //$(".chzn-select").chosen({ allow_single_deselect: true });
        }

        $("#ic_lancar_financeiro").val(arrCarregar.data[0]['ic_lancar_financeiro']);

        $("#metodos_pagamento_pk").val(arrCarregar.data[0]['metodos_pagamento_pk']);

        if (arrCarregar.data[0]['qtde_parcelas_pk'] != '') {
            fcListarOptionParcelaContrato(arrCarregar.data[0]['qtde_parcelas_pk']);
            fcGridContratoDadosFatura(arrCarregar.data[0]['qtde_parcelas_pk']);
        }

        $("#qtde_parcelas_pk").val(arrCarregar.data[0]['qtde_parcelas_pk']);
        $("#vl_total_mao_obra").html(float2moeda(arrCarregar.data[0]['vl_total_mao_obra']));
        $("#vl_contrato").val(arrCarregar.data[0]['vl_contrato']);

        if (leads_pk != "") {
            //$("#leads_pk_cad_form").val(leads_pk);
            $("#leads_pk_cad_form").prop("disabled", true);
            $("#exibir_insert_processo").show();
            $("#exibir_pesquisa").hide();
        }
        tblContratoItens = $('#tblContratoItens').DataTable({
            retrieve: true,
            paging: false
        });

        carregarListaComboProdutoContrato();

        tblPrdutosItens = $('#tblPrdutosItens').DataTable({
            retrieve: true,
            paging: false
        });

        tblPrdutosItens.clear().destroy();

        fcAtualizarDadosGridProdutoItens();
        
        setTimeout(function(){
            
            $(".chzn-select").chosen('destroy');
            $(".chzn-select").chosen({ allow_single_deselect: true }); 
        
        }, 1000);

        //fcCarregarLeadsContrato();
        $("#janela_contratos").modal();

    }


    //carrega os campor
    //$('#leads_pk_cad_form').val(objRegistro['t_leads_pk']);     



}

//Fechar Modal
function fcFecharModalContrato() {
    $("#janela_contratos").modal("hide");
}

//Carrega combo de empresas
function carregarComboEmpresaContrato() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("conta", "listarPk", objParametros);
    carregarComboAjax($("#empresas_pk"), arrCarregar, " ", "pk", "ds_razao_social");
}

//Careega combo de Leads (Postos de Trabalho)


function fcCarregarLeadsContrato() {
    //Carrega os grupos
    
    var objParametros = {
        "ic_tipo_lead": "", 
        "leads_pai_pk": $("#leads_clientes_cad_pk").val(),
        "ic_cliente": 1
    };

    var arrCarregar = carregarController("lead", "listarTodosPostTrabalho", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#leads_pk_cad_form"), arrCarregar, " ", "pk", "ds_lead");
     //Carrega os grupos
    
    

}
function fcCarregarClientesCad() {
    //Carrega os grupos
    var objParametros = {
        "ic_tipo_lead": 1,
        "ic_cliente": 1
    };

    var arrCarregar = carregarController("lead", "listarTodosClientes", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#leads_clientes_cad_pk"), arrCarregar, " ", "pk", "ds_lead");


}
//Carrega combo de Contratos Pai
function carregarComboContratoPai(vlr) {
   
    var contrato_pai_pk = "";
    if (vlr > 0) {
        contrato_pai_pk = vlr;
    } else {
        contrato_pai_pk = "";
    }
    var objParametros = {
        "leads_pk": $('#leads_pk_cad_form').val(),
        "contratos_pai_pk": contrato_pai_pk,
        "contratos_pk": $("#contratos_pk").val()
    };

    var arrCarregar = carregarController("contrato", "listarContratoPai", objParametros);

    carregarComboAjax($("#contrato_pai_pk"), arrCarregar, " ", "pk", "ds_contrato");

}
//Carrega combo de metodos de pagamento
function fcListarMetodosPagamentoContrato() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("metodo_pagamento", "listarTodos", objParametros);

    carregarComboAjax($("#metodos_pagamento_pk"), arrCarregar, " ", "pk", "ds_metodo_pagamento");
}
//Carrega combo de quantidade de parcelass
function fcListarOptionParcelaContrato(ini) {
    $("#combo_qtde_parcelas_pk").append("");
    $("#combo_qtde_parcelas_pk").empty();
    var str = "";
    str += "<select class='form-control form-control-sm'  id='qtde_parcelas_pk' name='qtde_parcelas_pk' onchange='fcGridContratoDadosFatura(0)'>";
    str += " <option ></option>";
    for (i = ini; i < 73; i++) {
        str += "<option value='" + i + "'>" + i + " Parcela(s)</option>";
    }
    str += "                        </select>";
    $("#combo_qtde_parcelas_pk").append(str);
}
//Carregar Grid de parcelas
function fcGridContratoDadosFatura(int) {
    $("#contrato_dados_fatura").append("");
    $("#contrato_dados_fatura").empty();

    var qtde_parcela = ($("#qtde_parcelas_pk").val());
    var strModal = "";
    var dt_ult = "";
    var arrDataPag = [];

    var objParametros = {
        "contrato_pk": $("#contratos_pk").val()
    };

    var arrCarregar = carregarController("contrato_dados_faturamento", "listarGridContratoDadosFaturamento", objParametros);

    if (arrCarregar.result == 'success') {
        if (int == 1) {
            var qtde_for = parseInt(arrCarregar.data.length);
        }
        else {
            var qtde_for = parseInt(qtde_parcela) + parseInt(arrCarregar.data.length);
        }
        if (qtde_for > 0) {
            strModal += "<div class='row'>";
            strModal += "    <div class='col-md-12'>";
            strModal += "    <table class='table table-striped table-bordered nowrap' style='width:100%' id='tblDadosContratoFaturamento'>";
            strModal += "        <thead>";
            strModal += "            <tr>";
            strModal += "                <th>Ordem</th>";
            strModal += "                <th>DT. Pagamento</th>";
            strModal += "                <th>DT. Faturamento</th>";
            strModal += "                <th>VL. Pagamento</th>";
            strModal += "            </tr>";
            strModal += "        </thead>";
            strModal += "        <tbody>";
            if (arrCarregar.data.length > 0) {
             
                dt_ult = arrCarregar.data[0]['ult_dt_pagamento'];
                for (p = 0; p < arrCarregar.data.length; p++) {
                    strModal += "<tr>";
                    strModal += "<td >";
                    strModal += "<input type='text'disabled id='num_parcela" + p + "' value='" + (p + 1) + "'>";
                    strModal += "</td>";
                    strModal += "<td >";

                    strModal += " <input type='text' id='dt_pagamento_dados_fatura" + p + "' maxlength=10 class='form-control form-control-sm' name='dt_pagamento_dados_fatura" + p + "' onkeypress='mascara(this,mdata)' value='" + arrCarregar.data[p]['dt_pagamento'] + "'>";
                    strModal += "</td>";
                    strModal += "<td >";

                    strModal += " <input type='text' id='dt_faturamento_dados_fatura" + p + "' maxlength=10 class='form-control form-control-sm' name='dt_faturamento_dados_fatura" + p + "' onkeypress='mascara(this,mdata)' value='" + arrCarregar.data[p]['dt_faturamento'] + "'>";
                    strModal += "</td>";
                    strModal += "<td >";

                    strModal += " <input type='text' maxlength=10 id='vl_pagamento_fatura" + p + "' class='form-control form-control-sm' name='vl_pagamento_fatura" + p + "' onkeypress='mascara(this,moeda)' value='" + float2moeda(arrCarregar.data[p]['vl_servico']) + "'>";
                    strModal += "</td>";
                    strModal += "</tr>";
                }
            }
            for (p = arrCarregar.data.length; p < qtde_for; p++) {
               
                var objParametros1 = {
                    "dt_base": dt_ult,
                    "mes": p
                };
                var arrCarregar1 = carregarController("contrato_dados_faturamento", "addMes", objParametros1);

                if (arrCarregar1.result == 'success') {
                    arrDataPag[p] = arrCarregar1.data[0]['dt_base'];
                }

                strModal += "<tr>";
                strModal += "<td >";
                strModal += "<input type='text'disabled id='num_parcela" + p + "' value='" + (p + 1) + "'>";
                strModal += "</td>";
                strModal += "<td >";

                strModal += " <input type='text' maxlength=10 id='dt_pagamento_dados_fatura" + p + "' class='form-control form-control-sm' name='dt_pagamento_dados_fatura" + p + "' onkeypress='mascara(this,mdata)' value='" + arrDataPag[p] + "'>";
                strModal += "</td>";
                strModal += "<td >";

                strModal += " <input type='text' maxlength=10 id='dt_faturamento_dados_fatura" + p + "' class='form-control form-control-sm' name='dt_faturamento_dados_fatura" + p + "' onkeypress='mascara(this,mdata)' value='" + arrDataPag[p] + "'>";
                strModal += "</td>";
                strModal += "<td >";

                strModal += " <input type='text' maxlength=10 id='vl_pagamento_fatura" + p + "' class='form-control form-control-sm' name='vl_pagamento_fatura" + p + "' onkeypress='mascara(this,moeda)'>";
                strModal += "</td>";
                strModal += "</tr>";
            }
            strModal += "</tbody>";
            strModal += "</table>";
            strModal += "</div>";
            strModal += "</div>";
        }
    }
    $("#contrato_dados_fatura").append(strModal);
}
//Formata dados de faturamento para array salvar
function fcFormatarDadosContratoFaturamento() {

    var num_parcela = "";
    var dt_pagamento = "";
    var vl_pagamento = "";
    var dt_faturamento = "";
    var arrKeys = [];
    arrKeys[0] = "num_parcela";
    arrKeys[1] = "dt_pagamento";
    arrKeys[2] = "vl_pagamento";
    arrKeys[3] = "dt_faturamento";
    var arrDados = [];
    var i = 0;
    var alt = 0;
    $('#tblDadosContratoFaturamento tbody tr').each(function () {
        var colunas = $(this).children();

        if ($("#dt_pagamento_dados_fatura" + i).val() == "") {
            alt = 1;
        }
        if ($("#dt_faturamento_dados_fatura" + i).val() == "") {
            alt = 1;
        }
        if ($("#vl_pagamento_fatura" + i).val() == "") {
            alt = 1;
        }
        num_parcela = $("#num_parcela" + i).val();
        dt_pagamento = $("#dt_pagamento_dados_fatura" + i).val();
        dt_faturamento = $("#dt_faturamento_dados_fatura" + i).val();
        vl_pagamento = moeda2float($("#vl_pagamento_fatura" + i).val());
        arrDados[i] = [num_parcela, dt_pagamento, vl_pagamento, dt_faturamento];
        i++;
    });
    if (alt == 0) {
        return arrayToJson(arrKeys, arrDados);
    }
    else {
        return 1;
    }

}





//CARREGA O COMBO DE PRODUTOS DO CONTRATO
function carregarListaComboProdutoContrato() {

    var url = '../controller/produto_servico.controller.php?job=listarTodos&token=' + token;

    var request = $.ajax({
        url: url,
        cache: false,
        dataType: 'json',
        contentType: 'application/json; charset=utf-8',
        type: 'post'
    });
    request.done(function (output) {
        if (output.result == 'success') {
            strComboModulos = "<select id='produtos_servicos_pk_contrato' name='produtos_servicos_pk_contrato'><option></option>";
            for (i = 0; i < output.data.length; i++) {
                strComboModulos = strComboModulos + "<option value='" + output.data[i]['pk'] + "'>" + output.data[i]['ds_produto_servico'] + "</option>";
            }
            strComboModulos += "</select>";

            //Carrega os dados no combo.


            fcFormatarGridContratoItens();

            fcAtualizarDadosGridContratoItens();
        }
        else {
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function (jqXHR, textStatus) {
        alert('Falha ao carregar o registro: ' + textStatus);
    });

}

function fcFormatarGridContratoItens() {
    tblContratoItens.clear().destroy();
    tblContratoItens = $("#tblContratoItens").DataTable({
        "scrollX": true,
        "responsive": true,
        "searching": false,
        "paging": false,
        "columnDefs": [{
            orderable: false,
            targets: [1, 2, 3, 4, 5, 6, 7, 8]
        }],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });
    return false;
}

//RETORNA OS DADOS CADASTRAIS DO CONTRATO ITENS
function fcAtualizarDadosGridContratoItens() {

    var v_url = "../controller/contrato_item.controller.php?job=listarContratoItem&token=" + token + "&contratos_pk=" + $("#contratos_pk").val();

    var request = $.ajax({
        url: v_url,
        cache: false,
        dataType: 'json',
        contentType: 'application/json; charset=utf-8',
        type: 'post'
    });

    request.done(function (output) {
        if (output.result == 'success') {

            for (i = 0; i < output.data.length; i++) {


                //Adiciona a linha.
                //fcIncluirPermissao();
                fcIncluirContratoItens(output.data[i]['t_pk'], output.data[i]['t_produtos_servicos_pk'], i);

                //Pega as variaveis 
                var contratos_itens_pk_2 = $("input[id='contratos_itens_pk_2']");
                var cboProdutosServicosPk = $("select[id='produtos_servicos_pk_contrato']");
                var n_qtde_contratos_itens = $("input[id='n_qtde_contrato']");
                var periodo = $("select[id='periodo']");
                var n_qtde_dias_semana = $("select[id='n_qtde_dias_semana_contrato']");
                var vl_unit = $("input[id='vl_unit_contrato']");
                var vl_total = $("input[id='vl_total_contrato']");
                var vl_mao_obra = $("input[id='vl_mao_obra']");

                contratos_itens_pk_2.get(i).value = output.data[i]['t_pk'];
                cboProdutosServicosPk.get(i).value = output.data[i]['t_produtos_servicos_pk'];
                n_qtde_contratos_itens.get(i).value = output.data[i]['t_n_qtde'];
                periodo.get(i).value = output.data[i]['t_periodo'];
                n_qtde_dias_semana.get(i).value = output.data[i]['t_n_qtde_dias_semana'];
                vl_unit.get(i).value = output.data[i]['t_vl_unit'];
                vl_total.get(i).value = output.data[i]['t_vl_total'];
                vl_mao_obra.get(i).value = output.data[i]['vl_mao_obra'];
            }
        }
        else {
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function (jqXHR, textStatus) {
        alert('Falha ao carregar o registro: ' + textStatus);
    });
}

//INCLUI CONTRATO ITENS
function fcIncluirContratoItens(contratos_itens_pk, produtos_itens_pk, li) {
    var data = tblContratoItens.rows().data();
    var v_li = "";

    if (data.length == 0) {
        v_li = 0;
    } else {
        v_li = data.length;
    }
    tblContratoItens.row.add(
        [contratos_itens_pk,
            strComboModulos + "<input type='hidden' class='form-control form-control-sm' id='contratos_itens_pk_2' />",
            "<input type='text' class='form-control form-control-sm' onchange='fcCalcularValorVlUnitContrato()' onkeypress='mascara(this,soNumeros)' id='n_qtde_contrato' size='3'/>",
            "<select id='periodo' class='form-control form-control-sm'><option value=''></option><option value='1'>1 Hrs</option><option value='2'>2 Hrs</option><option value='3'>3 Hrs</option><option value='4'>4 Hrs</option><option value='5'>5 Hrs</option><option value='6'>6 Hrs</option><option value='7'>7 Hrs</option><option value='8'>8 Hrs</option><option value='9'>9 Hrs</option><option value='10'>10 Hrs</option><option value='12'>12 Hrs</option><option value='24'>24 Hrs</option></select>",
            "<select id='n_qtde_dias_semana_contrato' class='form-control form-control-sm'><option value=''></option><option value='1D'>1D</option><option value='2D'>2D</option><option value='3D'>3D</option><option value='4D'>4D</option><option value='4x1'>4x1</option><option value='4x2'>4x2</option><option value='5x1'>5x1</option><option value='5x2'>5x2</option><option value='6x1'>6x1</option><option value='12x36'>12x36</option></select>",
            "<input type='text' size='20' class='form-control form-control-sm' onchange='fcCalcularValorVlUnitContrato()' onkeypress='mascara(this,moeda)' id='vl_unit_contrato'   />",
            "<input type='text' class='form-control form-control-sm' onkeypress='mascara(this,moeda)' id='vl_total_contrato' size='5' readonly/>",
            "<input type='text' class='form-control form-control-sm' onchange='fcCalculaTotalMaoObra()' onkeypress='mascara(this,moeda)' id='vl_mao_obra' size='5' />",
            "<a  ><span><img width=16 height=16 src='../img/excluir.png' onclick='fcconsultaEscalaContratoItem(" + contratos_itens_pk + "," + v_li + ")'></span></a>"
        ]
    ).draw(false);

    //Adiciona o evento click na linha que acabou de ser adicionada.
    //$(".function_delete").on("click", fcExcluirLinhaContratosItensContrato());
    $('#tblContratoItens tbody').on('click', '.function_delete1', function () {

        var data;

        if (tblContratoItens.row($(this).parents('li')).data()) {
            data = tblContratoItens.row($(this).parents('li')).data();
        } else if (tblContratoItens.row($(this).parents('tr')).data()) {
            data = tblContratoItens.row($(this).parents('tr')).data();
        }

        alert(tblContratoItens.row($(this).parents('tr')))
        //alert(tblContratoItens.rows().data())
        if (tblContratoItens.row($(this).parents('tr')) == li) {
    
        }


        tblContratoItens.row($(this).parents('tr')).remove().draw();

        //fcExcluir(data['pk']);
    });

}

function fcconsultaEscalaContratoItem(id, li) {
 
    var v_contratos_pk = $("#contratos_pk").val();

    var objParametros = {
        "contratos_pk": v_contratos_pk,
        "contratos_itens_pk": id
    };

    var arrEnviar = carregarController("agenda_colaborador_padrao", "consultarEscalaContratosItens", objParametros);

    if (arrEnviar.result == 'success') {

        if (arrEnviar.data[0]['pk'] > 0) {
            alert("Existe Escala(s) Ativa(s) para este Item")
        } else {
            fcExcluirLinhaContratosItensContrato(id, li)
        }
    }

}

function fcExcluirLinhaContratosItensContrato(vlr, li) {

    var contratos_itens_pk = vlr;
    if (contratos_itens_pk != "") {
        if (confirm("Tem certeza que deseja excluir este registro ?")) {
            var objParametros = {
                "pk": contratos_itens_pk
            };

            var arrExcluir = carregarController("contrato_item", "excluir", objParametros);

            if (arrExcluir.result == 'success') {
                //Exibe a mensagem

                tblContratoItens.row(li).remove().draw();

                alert(arrExcluir.message);
                tblContratos.ajax.reload();
            } else {
                //Exibe a mensagem
                alert(arrExcluir.message);
            }
        }
    }
    return false;
}


//FORMATA OS DADOS DA GRID CONTRATO ITENS
function fcFormatarDadosContratoProcesso() {
    var cboProdutosPk = $("select[id='produtos_servicos_pk_contrato']");
    var periodo = $("select[id='periodo']");
    var n_qtde_contratos_itens = $("input[id='n_qtde_contrato']");
    var contratos_itens_pk_2 = $("input[id='contratos_itens_pk_2']");
    var vl_total = $("input[id='vl_total_contrato']");
    var vl_unit = $("input[id='vl_unit_contrato']");
    var vl_mao_obra = $("input[id='vl_mao_obra']");
    var n_qtde_dias_semana = $("select[id='n_qtde_dias_semana_contrato']");

    var arrKeys = [];
    arrKeys[0] = "contratos_itens_pk";
    arrKeys[1] = "produtos_servicos_pk";
    arrKeys[2] = "n_qtde";
    arrKeys[3] = "vl_unit";
    arrKeys[4] = "vl_total";
    arrKeys[5] = "n_qtde_dias_semana";
    arrKeys[6] = "periodo";
    arrKeys[7] = "vl_mao_obra";
    var arrDados = [];
    for (i = 0; i < (cboProdutosPk.length); i++) {
        try {
            if (cboProdutosPk.get(i).value == "") {
                cboProdutosPk.get(i).focus();
                return "";
            }

            var l_vl_mao_obra = "";
            if (vl_mao_obra.get(i).value != '') {
                l_vl_mao_obra = moeda2float(vl_mao_obra.get(i).value)
            }
            arrDados[i] = [
                contratos_itens_pk_2.get(i).value,
                cboProdutosPk.get(i).value,
                n_qtde_contratos_itens.get(i).value,
                moeda2float(vl_unit.get(i).value),
                moeda2float(vl_total.get(i).value),
                n_qtde_dias_semana.get(i).value,
                periodo.get(i).value,
                l_vl_mao_obra
            ];
        }
        catch (err) {
            alert(err.message);
        }
    }
    return arrayToJson(arrKeys, arrDados);
}

function fcCarregarProcessoLead() {
  
    var objParametros = {
        "leads_pk": $("#leads_pk_cad_form").val()
    };

    var arrCarregar = carregarController("processo", "listarProcessoLead", objParametros);

    $("#processos_pk_cad_form").val(arrCarregar.data[0]['t_pk']);
    $("#processos_etapas_pk_1").val(arrCarregar.data[0]['processos_etapas_pk']);
}

function fcCalculaTotalMaoObra() {
    $('#vl_total_mao_obra').html("");
    var vl_mao_obra = $("input[id='vl_mao_obra']");
    
    var vtotal_vl_mao_obra = 0;
    var data = tblContratoItens.rows().data();
    for (i = 0; i < data.length; i++) {
        vtotal_vl_mao_obra += moeda2float(vl_mao_obra.get(i).value)
    }
    $('#vl_total_mao_obra').html(float2moeda(vtotal_vl_mao_obra));

}

function fcCarregarCategorias() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);
    carregarComboAjax($("#categorias_produto_pk"), arrCarregar, " ", "pk", "ds_categoria");
}

function fcCarregarProdutos(categorias_produto_pk) {

    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros);

    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");
}

function fcValidarCamposProduto() {
    if ($("#categorias_produto_pk").val() == "") {
        $("#alert_categorias_produto_pk").show();
        $("#alert_categorias_produto_pk").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_categorias_produto_pk").slideUp(500);
        });
        return false;
    }
    if ($("#produtos_pk").val() == "") {
        $("#alert_produtos_pk").show();
        $("#alert_produtos_pk").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_produtos_pk").slideUp(500);
        });
        return false;
    }
    if ($("#n_qtde_item").val() == "") {
        $("#alert_n_qtde_item").show();
        $("#alert_n_qtde_item").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_n_qtde_item").slideUp(500);
        });
        return false;
    }
    if ($("#vl_item_produto").val() == "") {
        $("#alert_vl_item_produto").show();
        $("#alert_vl_item_produto").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_vl_item_produto").slideUp(500);
        });
        return false;
    }

    fcIncluirProdutoIten();

}

//INCLUI CONTRATO ITENS
function fcIncluirProdutoIten() {
    var v_categoria_pk = $("#categorias_produto_pk option:selected").val();
    var v_categoria_text = $("#categorias_produto_pk option:selected").text();
    var v_item_pk = $("#produtos_pk option:selected").val();
    var v_item_text = $("#produtos_pk option:selected").text();
    var v_qtde = $("#n_qtde_item").val();
    var v_vl_item_produto = $("#vl_item_produto").val();


    tblPrdutosItens.row.add(
        {
            "pk": "",
            "categorias_produto_pk": $("#categorias_produto_pk option:selected").val(),
            "ds_categoria": $("#categorias_produto_pk option:selected").text().substring(0, 15),
            "produtos_pk": $("#produtos_pk option:selected").val(),
            "ds_produto": $("#produtos_pk option:selected").text().substring(0, 15),
            "n_qtde_item": $("#n_qtde_item").val(),
            "vl_item_produto": $("#vl_item_produto").val(),

            "t_functions": ""
        }
    ).draw();
    $("#categorias_produto_pk").val("");
    $("#produtos_pk").val("");
    $("#n_qtde_item").val("");
    $("#vl_item_produto").val("");
}

function fcAtualizarDadosGridProdutoItens() {
    var objParametros = {
        "pk": $("#contratos_pk").val()
    };

    var v_url = montarUrlController("contrato", "listarProdutosItens", objParametros);
    //NewWindow(v_last_url)
    //Trata a tabela
    tblPrdutosItens = $('#tblPrdutosItens').DataTable({
        "scrollX": false,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
        },
        { "targets": -2, "data": "vl_item_produto" },
        { "targets": -3, "data": "n_qtde_item" },
        { "targets": -4, "data": "ds_produto" },
        { "targets": -5, "data": "produtos_pk", visible: false },
        { "targets": -6, "data": "ds_categoria" },
        { "targets": -7, "data": "categorias_produto_pk", visible: false }
        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });
    $('#tblPrdutosItens tbody').on('click', '.function_delete', function () {

        var data;

        if (tblPrdutosItens.row($(this).parents('li')).data()) {
            data = tblPrdutosItens.row($(this).parents('li')).data();
        } else if (tblPrdutosItens.row($(this).parents('tr')).data()) {
            data = tblPrdutosItens.row($(this).parents('tr')).data();
        }

        tblPrdutosItens.row($(this).parents('tr')).remove().draw();
        //fcExcluir(data['pk']);
    });

}


$(document).ready(function () {
    fcCarregarClientesCad();
    fcCarregarLeadsContrato()
    $(".chzn-select").chosen({ allow_single_deselect: true });

    $("#leads_clientes_cad_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcCarregarLeadsContrato();
        $(".chzn-select").chosen({ allow_single_deselect: true });

    });

    $('#dt_inicio_contrato').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_inicio_contrato").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_fim_contrato').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_fim_contrato").keypress(function () {
        mascara(this, mdata);
    });

    //Mostra ou esconde partes do formulario
    $("#exibir_servico_extra").hide();
    $("#exibir_pesquisa").show();
    $("#exibir_insert_processo").hide()
    $("#exib_contrato_pai").hide();

    //Careega do combo de Contrato
    $("#leads_pk_cad_form").change(function () {
        if ($("#leads_pk_cad_form").val() != "") {
            carregarComboContratoPai(0);
            fcCarregarProcessoLead();
            //carregarComboContrato();
        }
    });

    if (leads_pk != "") {
        $("#leads_pk_cad_form").val(leads_pk);
        $("#leads_pk_cad_form").prop("disabled", true);
        $("#exibir_insert_processo").show();
        $("#exibir_pesquisa").hide();
        $("#leads_pk_contrato_pesq").val(leads_pk);
    }
    $('#ic_aditivo').click(function () {
        $('#ic_contrato').prop('checked', false);
        $('#ic_servico_extra').prop('checked', false);
        $('#ic_aditivo').prop('checked', true);
        $('#exib_contrato_pai').show();
        $("#exibir_servico_extra").hide();
    });
    $('#ic_contrato').click(function () {
        $('#ic_contrato').prop('checked', true);
        $('#ic_aditivo').prop('checked', false);
        $('#ic_servico_extra').prop('checked', false);
        $('#contrato_pai_pk').val("null");
        $('#agenda_responsavel_visible').show();
        $('#exib_contrato_pai').hide();
        $("#exibir_servico_extra").hide();
    });

    $('#ic_servico_extra').click(function () {
        fcListarMetodosPagamentoContrato();
        fcListarOptionParcelaContrato(1);
        $(".chzn-select").chosen('destroy');
        $('#ic_contrato').prop('checked', false);
        $('#ic_aditivo').prop('checked', false);
        $('#ic_servico_extra').prop('checked', true);
        $('#contrato_pai_pk').val("null");
        $('#agenda_responsavel_visible').show();
        $('#exib_contrato_pai').hide();
        $("#exibir_servico_extra").show();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    //Incluir nova linha do itens contrato
    $(document).on('click', '#cmdIncluirContratosItens', function () {
        fcIncluirContratoItens("");
    });
    $(document).on('click', '#cmdEnviarContrato', function () {
        fcSalvarContrato();
    });

    //Chama o combo de empresas Conta
    carregarComboEmpresaContrato();

    //formata o grid de itens contrato   
    //fcFormatarGridContratoItens()

    //Dados de materiais do contrato
    fcCarregarCategorias("");
    fcCarregarProdutos("");

    $("#categorias_produto_pk").change(function () {
        if ($("#categorias_produto_pk").val() != '') {
            $(".chzn-select").chosen('destroy');
            fcCarregarProdutos($("#categorias_produto_pk").val());
        }
    });
    $("#vl_item_produto").keypress(function () {
        mascara(this, moeda);
    });
    $("#vl_contrato").keypress(function () {
        mascara(this, moeda);
    });

    $(document).on('click', '#cmdIncluirMaterial', function () {
        fcValidarCamposProduto();
    });
    //carregarListaComboProdutoContrato();
    //fcFormatarGridProdutoItens();    
});
