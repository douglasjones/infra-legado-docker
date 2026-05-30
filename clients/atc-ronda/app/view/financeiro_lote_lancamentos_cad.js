function fcAddLinha(){
    try{
        var rowCount = $('#tblResultado tr').length;
        fcVeriricarUltimaLinhaSalva(rowCount);
        
        var tr = $('#tblResultado tbody').append('<tr id="tr'+rowCount+'"></tr>');
        tr.append('<td width="50px" id="td'+rowCount+'">\n\
                    <i style="color:000;" style="margin:20px" onclick="fcSalvarAlterar('+rowCount+')" class="bi bi-database-fill-check fa-lg" id="icon'+rowCount+'"></i><br><br>\n\
                    <i style="color:000;" style="margin:20px" onclick="fcExcluir('+rowCount+')" class="bi bi-trash fa-lg" id="remove'+rowCount+'"></i>\n\
                    <input type="hidden" id="financeiro_lote_lancamento_itens_pk'+rowCount+'"></td>')
        .append('<td style="text-align:center;" id="lancamentos_pk'+rowCount+'"></td>')
        .append('<td style="text-align:center;">'+rowCount+'</td>')
        .append('<td>*<input type="text" class="ds_lancamento" id="ds_lancamento'+rowCount+'"></td>')
        .append('<td>&ensp;<input type="text" class="ds_num_documento" id="ds_num_documento'+rowCount+'" id="ds_num_documento'+rowCount+'"></td>')
        .append('<td>&ensp;<select class="ic_tipo_num_documento" id="ic_tipo_num_documento'+rowCount+'"></select></td>')
        .append('<td>*<select class="operacao_pk" id="operacao_pk'+rowCount+'"></select></td>')
        .append('<td>*<select class="categoria_operacao_pk" onChange="fccarregarTipoPlanoNegocio('+rowCount+')" id="categoria_operacao_pk'+rowCount+'"></select></td>')
        .append('<td>*<select class="tipos_operacao_pk" id="tipos_operacao_pk'+rowCount+'"></select></td>')
        .append('<td>*<select class="tipo_grupo_pk" onChange="verificarFuncaoTipoGrupo('+rowCount+')" id="tipo_grupo_pk'+rowCount+'"></select>')
        .append('<td>*<select class="grupo_lancamento_pk" onChange="(fcCarregarPostoTrabalho('+rowCount+'), fcCarregarFuncaoCliente('+rowCount+'))" id="grupo_lancamento_pk'+rowCount+'"></select></td>')
        .append('<td>&ensp;<select class="clientes_pk" onChange="fcCarregarPostoTrabalho('+rowCount+')" onChange="fcCarregarLeadsPostosTrabalho('+rowCount+')" id="clientes_pk'+rowCount+'"></select></td>')
        .append('<td>&ensp;<select class="posto_trabalho_pk" onChange="fcCarregarContratos('+rowCount+')" id="posto_trabalho_pk'+rowCount+'"></select></td>')
        .append('<td>&ensp;<select class="contratos_pk" id="contratos_pk'+rowCount+'"></select></td>')
        .append('<td>*<select class="metodos_pagamento_pk" id="metodos_pagamento_pk'+rowCount+'"></select></td>')
        .append('<td>*<input type="text" class="dt_faturamento" onkeypress="mascara(this, mdata)" id="dt_faturamento'+rowCount+'"></td>')
        .append('<td>*<input type="text" class="dt_vencimento" onkeypress="mascara(this, mdata)" id="dt_vencimento'+rowCount+'"></td>')
        .append('<td>&ensp;<input type="text" class="vl_lancamento" onkeypress="mascara(this, moeda)" id="vl_lancamento'+rowCount+'"></td>')
        .append('<td>&ensp;<select class="empresas_pk" id="empresas_pk'+rowCount+'"></select></td>')
        .append('<td>*<select class="ic_status_pagamento" id="ic_status_pagamento'+rowCount+'"></select></td>')
        .append('<td>&ensp;<textarea class="obs_lancamento" id="obs_lancamento'+rowCount+'"></textarea></td>');

        fcMontarComboStatusPagamento(rowCount);        
        fcMontarComboTipoGrupo(rowCount);
        fcMontarComboTipoNumDocumento(rowCount);    
        fcMontarComboOperacao(rowCount);
        fcCarregarCategoriaOperacao(rowCount);
        fcCarregarMetodosPagamentoReceita(rowCount);
        fcCarregarEmpresaContaLancamento(rowCount);


        $('#dt_faturamento'+rowCount).datepicker({
            defaultDate: "",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker();
    
        $('#dt_vencimento'+rowCount).datepicker({
            defaultDate: "",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker();
    }catch(e){
        alert(e)
    }
    
}

function fcExcluir(rowCount){
    try {
        if($('#financeiro_lote_lancamento_itens_pk'+rowCount).val() > 0){
            if($("#lancamentos_pk"+rowCount).html() > 0){
                alert("Item não pode ser excluido, lançamento já registrado.")
            }else{
                var objParametros = {
                    "pk": $('#financeiro_lote_lancamento_itens_pk'+rowCount).val()
                }
                var arrCarregar = carregarController("financeiro_import_lancamento_itens", "excluir", objParametros); 
                if(arrCarregar.result == 'success'){
                    location.reload();
                }
            }
        }else{
            location.reload();
        }
    } catch (error) {
        console.log(error)
    }
   
    
    
}

function fcAlterararIdentificacaoLote(){
    var objParametros = {
        "pk": financeiro_import_lancamentos_pk,
        "ds_identificacao_lote": $('#ds_identificacao_lote').val()
    }
    var arrEnviar = carregarController("financeiro_import_lancamentos", "salvar", objParametros); 
    if(arrEnviar.data[0]['pk'] > 0){
        alert('Identificação salva com sucesso!')
    }
}

function fcVeriricarUltimaLinhaSalva(rowCount){
    if(rowCount != 1){
        linhaAnterior = rowCount - 1;
        fcSalvarAlterar(linhaAnterior) 
    }
}

function fcSalvarAlterar(rowCount){
    v_tipo_grupo_pk = $('#tipo_grupo_pk'+rowCount).val();
    var leads_posto_trabalho_pk = "";
    var contratos_pk = "";
    var colaborador_posto_trabalho_pk = "";
    var colaborador_contratos_pk = "";
    var fornecedor_posto_trabalho_pk = "";
    var fornecedor_contratos_pk = "";
    var leads_clientes_pk = "";
    var colaborador_pk = "";
    var fornecedor_pk = "";

    if (v_tipo_grupo_pk == 1) {
        leads_posto_trabalho_pk = $("#posto_trabalho_pk"+rowCount).val();
        contratos_pk = $("#contratos_pk"+rowCount).val();
        leads_clientes_pk = $("#grupo_lancamento_pk"+rowCount).val();

    } else if (v_tipo_grupo_pk == 2) {
        colaborador_posto_trabalho_pk = $("#posto_trabalho_pk"+rowCount).val();
        colaborador_contratos_pk = $("#contratos_pk"+rowCount).val();
        colaborador_pk = $("#grupo_lancamento_pk"+rowCount).val();

    } else if (v_tipo_grupo_pk == 3) {
        fornecedor_posto_trabalho_pk = $("#posto_trabalho_pk"+rowCount).val();
        fornecedor_contratos_pk = $("#contratos_pk"+rowCount).val();
        fornecedor_pk = $("#grupo_lancamento_pk"+rowCount).val();
    }

    var objParametros = {
        "pk": $('#financeiro_lote_lancamento_itens_pk'+rowCount).val(),
        "lancamentos_pk": $('#lancamentos_pk'+rowCount).html(),
        "financeiro_import_lancamentos_pk": financeiro_import_lancamentos_pk,
        "ds_lancamento": $("#ds_lancamento"+rowCount).val(),
        "ds_num_documento": $("#ds_num_documento"+rowCount).val(),
        "ic_tipo_num_documento": $("#ic_tipo_num_documento"+rowCount).val(),
        "operacao_pk": $("#operacao_pk"+rowCount).val(),
        "categoria_operacao_pk": $("#categoria_operacao_pk"+rowCount).val(),
        "tipos_operacao_pk": $("#tipos_operacao_pk"+rowCount).val(),
        "tipo_grupo_pk": $("#tipo_grupo_pk"+rowCount).val(),
        "grupo_leancamento_pk": $("#grupo_lancamento_pk"+rowCount).val(),
        "grupo_lancamento_centro_custo_pk": $("#clientes_pk"+rowCount).val(),
        "leads_posto_trabalho_pk": leads_posto_trabalho_pk,
        "contratos_pk": contratos_pk,
        "colaborador_posto_trabalho_pk": colaborador_posto_trabalho_pk,
        "colaborador_contratos_pk": colaborador_contratos_pk,
        "fornecedor_posto_trabalho_pk": fornecedor_posto_trabalho_pk,
        "fornecedor_contratos_pk": fornecedor_contratos_pk,
        "leads_clientes_pk": leads_clientes_pk,
        "colaborador_pk": colaborador_pk,
        "fornecedor_pk": fornecedor_pk,
        "metodos_pagamento_pk": $("#metodos_pagamento_pk"+rowCount).val(),
        "dt_faturamento": $("#dt_faturamento"+rowCount).val(),
        "dt_vencimento": $("#dt_vencimento"+rowCount).val(),
        "vl_lancamento": $("#vl_lancamento"+rowCount).val(),
        "empresas_pk": $("#empresas_pk"+rowCount).val(),
        "ic_status_pagamento": $("#ic_status_pagamento"+rowCount).val(),
        "obs_lancamento": $("#obs_lancamento"+rowCount).val()
    }
    var arrEnviar = carregarController("financeiro_import_lancamento_itens", "salvarItensLote", objParametros); 
    if(arrEnviar.data[0]['pk'] > 0){
        $('#financeiro_lote_lancamento_itens_pk'+rowCount).val(arrEnviar.data[0]['pk'])
        if(arrEnviar.data[0]['lancamentos_pk'] > 0){
            $('#icon'+rowCount).css('color', '#33cc33')
            $('#lancamentos_pk'+rowCount).html(arrEnviar.data[0]['lancamentos_pk'])
        }else{
            $('#icon'+rowCount).css('color', '#ffcc00')
        }
    }
}

function fcMontarComboOperacao(rowCount){
    $('#operacao_pk'+rowCount).append('<option value=""></option>')                               
    .append('<option value="1">Receita</option>')
    .append('<option value="7">Custo Fixo</option>')
    .append('<option value="8">Custo Variável</option>')
    .append('<option value="2">Despesa Fixa</option>')
    .append('<option value="3">Despesa Variável</option>')
    .append('<option value="4">Imposto</option>')
    .append('<option value="5">Transferência</option>')
    .append('<option value="6" class="exibir_opc_caixinha">Caixinha</option>');

}

function fcMontarComboTipoNumDocumento(rowCount){
    $('#ic_tipo_num_documento'+rowCount).append('<option value=""></option>')
    .append('<option value="1">Num Boleto</option>')
    .append('<option value="2">Num NF</option>');
}

function fcMontarComboTipoGrupo(rowCount){
    $('#tipo_grupo_pk'+rowCount).append('<option value=""></option>');
    $('#tipo_grupo_pk'+rowCount).append('<option value="1">Clientes</option>');
    $('#tipo_grupo_pk'+rowCount).append('<option value="2">Colaboradores</option>');
    $('#tipo_grupo_pk'+rowCount).append('<option value="3">Fornecedores</option>');
}

function fcMontarComboStatusPagamento(rowCount){
    $('#ic_status_pagamento'+rowCount).append('<option value=""></option>');
    $('#ic_status_pagamento'+rowCount).append('<option id="exibir_pago" value="1">Pago</option>');
    $('#ic_status_pagamento'+rowCount).append('<option value="2">Pendente</option>');
    $('#ic_status_pagamento'+rowCount).append('<option value="3">Aprovado</option>');
    $('#ic_status_pagamento'+rowCount).append('<option value="4">Atrasado</option>');
    $('#ic_status_pagamento'+rowCount).append('<option value="5">Cancelado</option>');
}

function fcCarregarCategoriaOperacao(rowCount) {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("categoria_financeira", "listarTodos", objParametros);
    carregarComboAjax($("#categoria_operacao_pk"+rowCount), arrCarregar, " ", "pk", "ds_categoria");
}

function fccarregarTipoPlanoNegocio(rowCount){
    var objParametros = {
        "categorias_financeiras_pk": $("#categoria_operacao_pk"+rowCount).val()
    };
    var arrCarregar = carregarController("plano_contas", "listaPorCategoria", objParametros);
    carregarComboAjax($("#tipos_operacao_pk"+rowCount), arrCarregar, " ", "pk", "ds_tipo_operacao");
    $('#tipos_operacao_pk'+rowCount).select2();
}

function fcCarregarMetodosPagamentoReceita(rowCount) {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("metodo_pagamento", "listarTodos", objParametros);
    carregarComboAjax($("#metodos_pagamento_pk"+rowCount), arrCarregar, " ", "pk", "ds_metodo_pagamento");
}

function fcCarregarEmpresaContaLancamento(rowCount) {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("conta", "listarTodos", objParametros);
    carregarComboAjax($("#empresas_pk"+rowCount), arrCarregar, " ", "pk", "ds_conta");
    $('#empresas_pk'+rowCount).select2();
}

function fccarregarEmpresaContaleancamento(rowCount) {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("conta", "listarTodos", objParametros);
    carregarComboAjax($("#empresas_pk"+rowCount), arrCarregar, " ", "pk", "ds_conta");
}

function verificarFuncaoTipoGrupo(rowCount){
    $('#contratos_pk'+rowCount).val('')
    $('#clientes_pk'+rowCount).val('')
    $('#posto_trabalho_pk'+rowCount).val('')
    $('#grupo_lancamento_pk'+rowCount).val('')
    
    v_tipo_grupo_pk = $('#tipo_grupo_pk'+rowCount).val();
    if (v_tipo_grupo_pk == 1) {
        fcCarregarLeadsClientes(rowCount)
    } else if (v_tipo_grupo_pk == 2) {
        fcCarregarColaborador(rowCount)
    } else if (v_tipo_grupo_pk == 3) {
        fcCarregarFornecedor(rowCount)
    }
   
    $('#grupo_lancamento_pk'+rowCount).select2();
}

function fcCarregarFuncaoCliente(rowCount){
    v_tipo_grupo_pk = $('#tipo_grupo_pk'+rowCount).val();
    if (v_tipo_grupo_pk == 1) {
    } else if (v_tipo_grupo_pk == 2) {
        fcCarregarClientesColaboradores(rowCount)
    } else if (v_tipo_grupo_pk == 3) {
        fcCarregarClientesFornecedor(rowCount)
    }
    $('#clientes_pk'+rowCount).select2();

}

function fcCarregarPostoTrabalho(rowCount){
    v_tipo_grupo_pk = $('#tipo_grupo_pk'+rowCount).val();
    if (v_tipo_grupo_pk == 1) {
        fcCarregarLeadsPostosTrabalho(rowCount)
    } else if (v_tipo_grupo_pk == 2) {
        fccarregarColaboradorPostosTrabalho(rowCount)
    } else if (v_tipo_grupo_pk == 3) {
        fccarregarFornecedorPostosTrabalho(rowCount)
    }
    $('#posto_trabalho_pk'+rowCount).select2();
}

function fcCarregarContratos(rowCount){
    v_tipo_grupo_pk = $('#tipo_grupo_pk'+rowCount).val();
    if (v_tipo_grupo_pk == 1) {
        fccarregarLeadsContratos(rowCount)
    } else if (v_tipo_grupo_pk == 2) {
        fccarregarColaboradorContratos(rowCount)
    } else if (v_tipo_grupo_pk == 3) {
        fccarregarFornecedorContratos(rowCount)
    }
    $('#contratos_pk'+rowCount).select2();
}

function fcCarregarLeadsClientes(rowCount) {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listaLeadsClientes", objParametros);
    carregarComboAjax($("#grupo_lancamento_pk"+rowCount), arrCarregar, " ", "pk", "ds_lead");
}

function fcCarregarColaborador(rowCount) {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("colaborador", "listaColaborador", objParametros);
    carregarComboAjax($("#grupo_lancamento_pk"+rowCount), arrCarregar, " ", "colaborador_pk", "ds_colaborador");
}

function fcCarregarFornecedor(rowCount) {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("fornecedor", "listarTodos", objParametros);
    carregarComboAjax($("#grupo_lancamento_pk"+rowCount), arrCarregar, " ", "pk", "ds_fornecedor");
}

function fcCarregarClientesColaboradores(rowCount) {

    var objParametros = {
        "colaborador_pk": $("#grupo_lancamento_pk"+rowCount).val()
    };
    var arrCarregar = carregarController("lead", "listarClienteColaborador", objParametros);
    carregarComboAjax($("#clientes_pk"+rowCount), arrCarregar, " ", "pk", "ds_lead");
}

function fcCarregarClientesFornecedor(rowCount) {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listaLeadsClientes", objParametros);
    carregarComboAjax($("#clientes_pk"+rowCount), arrCarregar, " ", "pk", "ds_lead");
}

function fcCarregarLeadsPostosTrabalho(rowCount) {
    var objParametros = {
        "pk": $("#grupo_lancamento_pk"+rowCount).val()
    };
    var arrCarregar = carregarController("lead", "listaLeadsPostosTrabalho", objParametros);
    carregarComboAjax($("#posto_trabalho_pk"+rowCount), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarColaboradorPostosTrabalho(rowCount) {

    var objParametros = {
        "colaborador_pk": $("#grupo_lancamento_pk"+rowCount).val(),
        "leads_pk": $("#clientes_pk"+rowCount).val()
    };
    var arrCarregar = carregarController("lead", "listaColaboradorPostosTrabalho", objParametros);
    carregarComboAjax($("#posto_trabalho_pk"+rowCount), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarFornecedorPostosTrabalho(rowCount) {
    var objParametros = {
        "leads_pk": $("#clientes_pk"+rowCount).val()
    };
    var arrCarregar = carregarController("lead", "listaFornecedorPostosTrabalho", objParametros);
    carregarComboAjax($("#posto_trabalho_pk"+rowCount), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarLeadsContratos(rowCount) {
    var objParametros = {
        "leads_pk": $("#posto_trabalho_pk"+rowCount).val()
    };
    var arrCarregar = carregarController("contrato", "listaLeadContratos", objParametros);

    carregarComboAjax($("#contratos_pk"+rowCount), arrCarregar, " ", "pk", "ds_contrato");
}

function fccarregarColaboradorContratos(rowCount) {

    var objParametros = {
        "leads_pk": $("#posto_trabalho_pk"+rowCount).val(),
        "colaborador_pk": $("#grupo_lancamento_pk"+rowCount).val()
    };
    var arrCarregar = carregarController("contrato", "listaColaboradorContratos", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#contratos_pk"+rowCount), arrCarregar, " ", "pk", "ds_contrato");
}

function fccarregarFornecedorContratos(rowCount) {
    var objParametros = {
        "leads_pk": $("#posto_trabalho_pk"+rowCount).val()
    };
    var arrCarregar = carregarController("contrato", "listaLeadContratos", objParametros);
    
    carregarComboAjax($("#contratos_pk"+rowCount), arrCarregar, " ", "pk", "ds_contrato");
}

function fcListarItens(){
    try {
        var objParametros = {
            "financeiro_import_lancamentos_pk": financeiro_import_lancamentos_pk
        }
        var arrCarregar = carregarController("financeiro_import_lancamento_itens", "listarPorImportLancamentoPk", objParametros); 
        //NewWindow(v_last_url)
        for(var i=0; i < arrCarregar.data.length; i++){
            var linha = "";
                linha = i+1;
            var tr = $('#tblResultado tbody').append('<tr id="tr'+linha+'"></tr>');
            tr.append('<td id="td'+linha+'">\n\
                        <i style="color:000;" onclick="fcSalvarAlterar('+linha+')" class="bi bi-database-fill-check fa-lg" id="icon'+linha+'"></i><br><br>\n\
                        <i style="color:000;" onclick="fcExcluir('+linha+')" class="bi bi-trash fa-lg"></i>\n\
                        <input type="hidden" id="financeiro_lote_lancamento_itens_pk'+linha+'"></td>')
            .append('<td style="text-align:center;" id="lancamentos_pk'+linha+'"></td>')
            .append('<td style="text-align:center;">'+linha+'</td>')
            .append('<td>*<input type="text" class="ds_lancamento" id="ds_lancamento'+linha+'"></td>')
            .append('<td>&ensp;<input type="text" class="ds_num_documento" id="ds_num_documento'+linha+'" id="ds_num_documento'+linha+'"></td>')
            .append('<td>&ensp;<select class="ic_tipo_num_documento" id="ic_tipo_num_documento'+linha+'"></select></td>')
            .append('<td>*<select class="operacao_pk" id="operacao_pk'+linha+'"></select></td>')
            .append('<td>*<select class="categoria_operacao_pk" onChange="fccarregarTipoPlanoNegocio('+linha+')" id="categoria_operacao_pk'+linha+'"></select></td>')
            .append('<td>*<select class="tipos_operacao_pk" id="tipos_operacao_pk'+linha+'"></select></td>')
            .append('<td>*<select class="tipo_grupo_pk" onChange="verificarFuncaoTipoGrupo('+linha+')" id="tipo_grupo_pk'+linha+'"></select>')
            .append('<td>*<select class="grupo_lancamento_pk" onChange="(fcCarregarPostoTrabalho('+linha+'), fcCarregarFuncaoCliente('+linha+'))" id="grupo_lancamento_pk'+linha+'"></select></td>')
            .append('<td>&ensp;<select class="clientes_pk" onChange="fcCarregarPostoTrabalho('+linha+')" onChange="fcCarregarLeadsPostosTrabalho('+linha+')" id="clientes_pk'+linha+'"></select></td>')
            .append('<td>&ensp;<select class="posto_trabalho_pk" onChange="fcCarregarContratos('+linha+')" id="posto_trabalho_pk'+linha+'"></select></td>')
            .append('<td>&ensp;<select class="contratos_pk" id="contratos_pk'+linha+'"></select></td>')
            .append('<td>*<select class="metodos_pagamento_pk" id="metodos_pagamento_pk'+linha+'"></select></td>')
            .append('<td>*<input type="text" class="dt_faturamento" onkeypress="mascara(this, mdata)" id="dt_faturamento'+linha+'"></td>')
            .append('<td>*<input type="text" class="dt_vencimento" onkeypress="mascara(this, mdata)" id="dt_vencimento'+linha+'"></td>')
            .append('<td>&ensp;<input type="text" class="vl_lancamento" onkeypress="mascara(this, moeda)" id="vl_lancamento'+linha+'"></td>')
            .append('<td>&ensp;<select class="empresas_pk" id="empresas_pk'+linha+'"></select></td>')
            .append('<td>*<select class="ic_status_pagamento" id="ic_status_pagamento'+linha+'"></select></td>')
            .append('<td>&ensp;<textarea class="obs_lancamento" id="obs_lancamento'+linha+'"></textarea></td>');
        
            fcMontarComboOperacao(linha)
            fcMontarComboTipoNumDocumento(linha)
            fcMontarComboTipoGrupo(linha)
            fcMontarComboStatusPagamento(linha)

            $("#categoria_operacao_pk"+linha).append("<option></option>");
            for(var l=0; l<arrCarregar.data[i]['arrCategoria'].length; l++){
                $("#categoria_operacao_pk"+linha).append("<option value='"+arrCarregar.data[i]['arrCategoria'][l]['pk']+"'>"+arrCarregar.data[i]['arrCategoria'][l]['ds_categoria']+"</option>");
            }
            
            $("#tipos_operacao_pk"+linha).append("<option></option>");
            for(var l=0; l<arrCarregar.data[i]['arrTiposOperacao'].length; l++){
                $("#tipos_operacao_pk"+linha).append("<option value='"+arrCarregar.data[i]['arrTiposOperacao'][l]['pk']+"'>"+arrCarregar.data[i]['arrTiposOperacao'][l]['ds_tipo_operacao']+"</option>");
            }
            
            $("#metodos_pagamento_pk"+linha).append("<option></option>");
            for(var l=0; l<arrCarregar.data[i]['arrMetodoPagamento'].length; l++){
                $("#metodos_pagamento_pk"+linha).append("<option value='"+arrCarregar.data[i]['arrMetodoPagamento'][l]['pk']+"'>"+arrCarregar.data[i]['arrMetodoPagamento'][l]['ds_metodo_pagamento']+"</option>");
            }
            
            $("#grupo_lancamento_pk"+linha).append("<option></option>");
            for(var l=0; l<arrCarregar.data[i]['arrGrupoLancamento'].length; l++){
                $("#grupo_lancamento_pk"+linha).append("<option value='"+arrCarregar.data[i]['arrGrupoLancamento'][l]['pk']+"'>"+arrCarregar.data[i]['arrGrupoLancamento'][l]['ds_grupo_lancamento']+"</option>");
            }

            $("#clientes_pk"+linha).append("<option></option>");
            for(var l=0; l<arrCarregar.data[i]['arrCliente'].length; l++){
                $("#clientes_pk"+linha).append("<option value='"+arrCarregar.data[i]['arrCliente'][l]['pk']+"'>"+arrCarregar.data[i]['arrCliente'][l]['ds_cliente']+"</option>");
            }

            $("#posto_trabalho_pk"+linha).append("<option></option>");
            for(var l=0; l<arrCarregar.data[i]['arrPostoTrabalho'].length; l++){
                $("#posto_trabalho_pk"+linha).append("<option value='"+arrCarregar.data[i]['arrPostoTrabalho'][l]['pk']+"'>"+arrCarregar.data[i]['arrPostoTrabalho'][l]['ds_lead']+"</option>");
            }

            $("#contratos_pk"+linha).append("<option></option>");
            for(var l=0; l<arrCarregar.data[i]['arrContrato'].length; l++){
                $("#contratos_pk"+linha).append("<option value='"+arrCarregar.data[i]['arrContrato'][l]['pk']+"'>"+arrCarregar.data[i]['arrContrato'][l]['ds_contrato']+"</option>");
            }

            $("#empresas_pk"+linha).append("<option></option>");
            for(var l=0; l<arrCarregar.data[i]['arrEmpresa'].length; l++){
                $("#empresas_pk"+linha).append("<option value='"+arrCarregar.data[i]['arrEmpresa'][l]['pk']+"'>"+arrCarregar.data[i]['arrEmpresa'][l]['ds_conta']+"</option>");
            }
        
            $('#financeiro_lote_lancamento_itens_pk'+linha).val(arrCarregar.data[i]['arrItens']['pk'])
            $('#ds_identificacao_lote').val(arrCarregar.data[i]['arrItens']['ds_identificacao_lote'])
            $('#lancamentos_pk'+linha).html(arrCarregar.data[i]['arrItens']['lancamentos_pk'])
            $('#ds_lancamento'+linha).val(arrCarregar.data[i]['arrItens']['ds_lancamento'])
            $('#ds_num_documento'+linha).val(arrCarregar.data[i]['arrItens']['ds_num_documento'])
            $('#ic_tipo_num_documento'+linha).val(arrCarregar.data[i]['arrItens']['ic_tipo_num_documento'])
            $('#operacao_pk'+linha).val(arrCarregar.data[i]['arrItens']['operacao_pk'])
            $('#tipos_operacao_pk'+linha).val(arrCarregar.data[i]['arrItens']['tipos_operacao_pk'])
            $('#categoria_operacao_pk'+linha).val(arrCarregar.data[i]['arrItens']['categoria_operacao_pk'])
            $('#tipo_grupo_pk'+linha).val(arrCarregar.data[i]['arrItens']['tipo_grupo_pk'])
            $('#dt_faturamento'+linha).val(arrCarregar.data[i]['arrItens']['dt_faturamento'])
            $('#dt_vencimento'+linha).val(arrCarregar.data[i]['arrItens']['dt_vencimento'])
            if(arrCarregar.data[i]['arrItens']['tipo_grupo_pk'] == 1){
                $('#grupo_lancamento_pk'+linha).val(arrCarregar.data[i]['arrItens']['leads_clientes_pk'])
                $('#posto_trabalho_pk'+linha).val(arrCarregar.data[i]['arrItens']['leads_posto_trabalho_pk'])
                $('#contratos_pk'+linha).val(arrCarregar.data[i]['arrItens']['contratos_pk'])
            }else if(arrCarregar.data[i]['arrItens']['tipo_grupo_pk'] == 2){
                $('#grupo_lancamento_pk'+linha).val(arrCarregar.data[i]['arrItens']['colaborador_pk'])
                $('#posto_trabalho_pk'+linha).val(arrCarregar.data[i]['arrItens']['colaborador_posto_trabalho_pk'])
                $('#contratos_pk'+linha).val(arrCarregar.data[i]['arrItens']['colaborador_contratos_pk'])
            }else if(arrCarregar.data[i]['arrItens']['tipo_grupo_pk'] == 3){
                $('#grupo_lancamento_pk'+linha).val(arrCarregar.data[i]['arrItens']['fornecedor_pk'])
                $('#posto_trabalho_pk'+linha).val(arrCarregar.data[i]['arrItens']['fornecedor_posto_trabalho_pk'])
                $('#contratos_pk'+linha).val(arrCarregar.data[i]['arrItens']['fornecedor_contratos_pk'])
            }
            $('#clientes_pk'+linha).val(arrCarregar.data[i]['arrItens']['grupo_lancamento_centro_custo_pk'])
            $('#vl_lancamento'+linha).val(float2moeda(arrCarregar.data[i]['arrItens']['vl_lancamento']))
            $('#metodos_pagamento_pk'+linha).val(arrCarregar.data[i]['arrItens']['metodos_pagamento_pk'])
            $('#ic_status_pagamento'+linha).val(arrCarregar.data[i]['arrItens']['ic_status_pagamento'])
            $('#empresas_pk'+linha).val(arrCarregar.data[i]['arrItens']['empresas_pk'])
            $('#obs_lancamento'+linha).val(arrCarregar.data[i]['arrItens']['obs_lancamento'])
            
            $('#tipos_operacao_pk'+linha).select2();
            $('#grupo_lancamento_pk'+linha).select2();
            $('#clientes_pk'+linha).select2();
            $('#posto_trabalho_pk'+linha).select2();
            $('#contratos_pk'+linha).select2();
            $('#empresas_pk'+linha).select2();

            if(arrCarregar.data[i]['arrItens']['lancamentos_pk'] > 0){
                $('#icon'+linha).css('color', '#33cc33')
            }else{
                $('#icon'+linha).css('color', '#ffcc00')
            }
            
        }
    } catch (error) {
        alert(error)
    }
    
}

function fcFechar(){
    if($('#ds_identificacao_lote').val() != ""){
        window.close()
    }else{
        alert('O campo Identificação do Lote é obrigatório')
    }
    
}

$(document).ready(function () {
    $(document).on('click', '#cmdAddLinha', fcAddLinha);
    $(document).on('click', '#cmdAlterarIdentificao', fcAlterararIdentificacaoLote);
    $(document).on('click', '#cmdFechar', fcFechar);

    fcListarItens();
})