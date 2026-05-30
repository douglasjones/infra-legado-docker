var tbParcelas = "";
var tblDocumentosLancamento = "";
function fcpermissaoStatusPago() {
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

function fclimpaFormLancamento() {
    $("#lancamento_pk").val("");
    $("#ds_lancamento_modal").val("");
    $("#tipo_lancamento_modal_pk").val("");
    $("#categoria_operacao_modal_pk").val("");
    $("#tipo_lancamento_modal_pk").val("");
    $("#categoria_operacao_modal_pk").val("");
    $("#tipos_operacao_modal_pk").val("");
    $("#tipo_grupo_modal_pk").val("");
    $("#leads_clientes_modal_pk").val("");
    $("#contratos_modal_pk").val("");
    $("#colaborador_modal_pk").val("");
    $("#colaborador_posto_trabalho_modal_pk").val("");
    $("#fornecedor_modal_pk").val("");
    $("#fornecedor_posto_trabalho_modal_pk").val("");
    $("#fornecedor_contratos_modal_pk").val("");
    $("#tipo_grupo_centro_custo_pk_receita").val("");
    $("#grupo_lancamento_centro_custo_pk_receita").val("");
    $("#dt_faturamento_modal1").val("");
    $("#dt_vencimento_modal1").val("");
    $("#vl_lancamento_modal1").val("");
    $("#metodos_pagamento_modal_pk").val("");
    $("#empresa_modal_pk").val("");
    $("#contas_bancarias_modal_pk").val("");
    $("#ic_status_pagamento_modal").val("");
    $("#dt_pagamento_modal").val("");
    $("#obs_lancamento_modal").val("");
    $("#grupo_lancamento_centro_custo_fornecedor_pk").val("");
    $("#grupo_lancamento_centro_custo_colaborador_pk").val("");   
    $("#qtde_parcelas_pk").val("1");
    $("#ds_parcela").text("1");
    $("#div_datas_valores_pagamento").append("");
    $("#ds_num_documento_modal").val("");
    $("#ic_tipo_num_documento").val("");
    $("#div_datas_valores_pagamento").empty();
}


function fcgerenciaLabel() {
    if ($("#tipo_lancamento_modal_pk").val() == 1) {
        $("#label_lancamento").html('Lançar Receta De ?:');
    } else if ($("#tipo_lancamento_modal_pk").val() != 1) {
        $("#label_lancamento").html('Lançar Despesa Para ?:');
    } else if ($("#tipo_lancamento_modal_pk").val() == "") {
        $("#label_lancamento").html('Lançar Para:');
    }
}

function fccarregarCategoriaoperacao() {
    var objParametros = {

    };
    var arrCarregar = carregarController("categoria_financeira", "listarTodos", objParametros);
    carregarComboAjax($("#categoria_operacao_modal_pk"), arrCarregar, " ", "pk", "ds_categoria");
}

function fccarregarTipoPLanoNegocio() {
    var objParametros = {
        "categorias_financeiras_pk": $("#categoria_operacao_modal_pk").val()
    };
    var arrCarregar = carregarController("plano_contas", "listaPorCategoria", objParametros);
    carregarComboAjax($("#tipos_operacao_modal_pk"), arrCarregar, " ", "pk", "ds_tipo_operacao");
}

function fccarregarEmpresaContaleancamento() {
    var objParametros = {

    };
    var arrCarregar = carregarController("conta", "listarTodos", objParametros);
    carregarComboAjax($("#empresa_modal_pk"), arrCarregar, " ", "pk", "ds_conta");
}

function fccarregarContasBancariasLancamento() {
    var objParametros = {
        "empresas_pk": $("#empresa_modal_pk").val()
    };
    var arrCarregar = carregarController("conta_bancaria", "listaPorEmpresa", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#contas_bancarias_modal_pk"), arrCarregar, " ", "pk", "ds_conta");
}

function fcSelecionaGrupo() {

    if ($("#tipo_grupo_modal_pk").val() == 1) {
        fccarregarLeadsClientes();
        $("#div_grupos_lancamento_lead").show();
        $("#div_grupos_lancamento_colaborador").hide();
        $("#div_grupos_lancamento_fornecedor").hide();
    } else if ($("#tipo_grupo_modal_pk").val() == 2) {
        fccarregarColaborador();
        $("#div_grupos_lancamento_lead").hide();
        $("#div_grupos_lancamento_colaborador").show();
        $("#div_grupos_lancamento_fornecedor").hide();

    } else if ($("#tipo_grupo_modal_pk").val() == 3) {
        fccarregarFornecedor();
        fccarregarLeadsClientesCentroCustoForncedor();
        //fccarregarFornecedorPostosTrabalho();
        $("#div_grupos_lancamento_lead").hide();
        $("#div_grupos_lancamento_colaborador").hide();
        $("#div_grupos_lancamento_fornecedor").show();
    } else if ($("#tipo_grupo_modal_pk").val() == '') {
        $("#div_grupos_lancamento_lead").hide();
        $("#div_grupos_lancamento_colaborador").hide();
        $("#div_grupos_lancamento_fornecedor").hide();
    }
}

function fccarregarLeadsClientes() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listaLeadsClientes", objParametros);
  
    carregarComboAjax($("#leads_clientes_modal_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarLeadsPostosTrabalho() {

    var objParametros = {
        "pk": $("#leads_clientes_modal_pk").val()
    };
    var arrCarregar = carregarController("lead", "listaLeadsPostosTrabalho", objParametros);
    
    carregarComboAjax($("#leads_posto_trabalho_modal_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarLeadsContratos() {
    var objParametros = {
        "leads_pk": $("#leads_posto_trabalho_modal_pk").val()
    };
    var arrCarregar = carregarController("contrato", "listaLeadContratos", objParametros);

    carregarComboAjax($("#contratos_modal_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fccarregarColaborador() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("colaborador", "listaColaborador", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#colaborador_modal_pk"), arrCarregar, " ", "colaborador_pk", "ds_colaborador");
}

function fccarregarLeadsClientesCentroCusto() {

    var objParametros = {
        "colaborador_pk": $("#colaborador_modal_pk").val()
    };
    var arrCarregar = carregarController("lead", "listarClienteColaborador", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#grupo_lancamento_centro_custo_colaborador_pk"), arrCarregar, " ", "pk", "ds_lead");
}


function fccarregarColaboradorPostosTrabalho() {

    var objParametros = {
        "colaborador_pk": $("#colaborador_modal_pk").val(),
        "leads_pk": $("#grupo_lancamento_centro_custo_colaborador_pk").val()
    };
    var arrCarregar = carregarController("lead", "listaColaboradorPostosTrabalho", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#colaborador_posto_trabalho_modal_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarColaboradorContratos() {

    var objParametros = {
        "leads_pk": $("#colaborador_posto_trabalho_modal_pk").val(),
        "colaborador_pk": $("#colaborador_modal_pk").val()
    };
    var arrCarregar = carregarController("contrato", "listaColaboradorContratos", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#colaborador_contratos_modal_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fccarregarFornecedor() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("fornecedor", "listarTodos", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#fornecedor_modal_pk"), arrCarregar, " ", "pk", "ds_fornecedor");
}

function fccarregarLeadsClientesCentroCustoForncedor() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listaLeadsClientes", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#grupo_lancamento_centro_custo_fornecedor_pk"), arrCarregar, " ", "pk", "ds_lead");
}


function fccarregarFornecedorPostosTrabalho() {

    var objParametros = {
        "leads_pk": $("#grupo_lancamento_centro_custo_fornecedor_pk").val()
    };
    var arrCarregar = carregarController("lead", "listaFornecedorPostosTrabalho", objParametros);
    carregarComboAjax($("#fornecedor_posto_trabalho_modal_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarFornecedorContratos() {
    var objParametros = {
        "leads_pk": $("#fornecedor_posto_trabalho_modal_pk").val()
    };
    var arrCarregar = carregarController("contrato", "listaLeadContratos", objParametros);
    
    carregarComboAjax($("#fornecedor_contratos_modal_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fccarregarMetodosPagamentoReceita() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("metodo_pagamento", "listarTodos", objParametros);
    carregarComboAjax($("#metodos_pagamento_modal_pk"), arrCarregar, " ", "pk", "ds_metodo_pagamento");
}



function fcvalidarFormLancamentoCad() {

    var  data = tbParcelas.rows; 

    if ($('#ds_lancamento_modal').val() == "") {
        $("#alert_ds_lancamento_modal").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_ds_lancamento_modal").slideUp(500);
        });
        $('#alert_ds_lancamento_modal').focus();
        return false;
    }
    if ($('#tipo_lancamento_modal_pk').val() == "") {
        $("#alert_tipo_lancamento_modal_pk").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_tipo_lancamento_modal_pk").slideUp(500);
        });
        $('#alert_tipo_lancamento_modal_pk').focus();
        return false;
    }
    if ($('#categoria_operacao_modal_pk').val() == "") {
        $("#alert_categoria_operacao_modal_pk").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_categoria_operacao_modal_pk").slideUp(500);
        });
        $('#alert_categoria_operacao_modal_pk').focus();
        return false;
    }
    if ($('#tipos_operacao_modal_pk').val() == "") {
        $("#alert_tipos_operacao_modal_pk").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_tipos_operacao_modal_pk").slideUp(500);
        });
        $('#alert_tipos_operacao_modal_pk').focus();
        return false;
    }
    if ($('#tipo_grupo_modal_pk').val() == "") {
        $("#alert_tipo_grupo_modal_pk").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_tipo_grupo_modal_pk").slideUp(500);
        });
        $('#alert_tipo_grupo_modal_pk').focus();
        return false;
    }
    if ($('#tipo_grupo_modal_pk').val() == 1) {
        if ($('#leads_clientes_modal_pk').val() == "") {
            $("#alert_leads_clientes_modal_pk").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_leads_clientes_modal_pk").slideUp(500);
            });
            $('#alert_leads_clientes_modal_pk').focus();
            return false;
        }
    } else if ($('#tipo_grupo_modal_pk').val() == 2) {
        if ($('#colaborador_modal_pk').val() == "") {
            $("#alert_colaborador_modal_pk").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_colaborador_modal_pk").slideUp(500);
            });
            $('#alert_colaborador_modal_pk').focus();
            return false;
        }
    } else if ($('#tipo_grupo_modal_pk').val() == 3) {
        if ($('#fornecedor_modal_pk').val() == "") {
            $("#alert_fornecedor_modal_pk").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_fornecedor_modal_pk").slideUp(500);
            });
            $('#alert_fornecedor_modal_pk').focus();
            return false;
        }
    }
    if ($('#dt_vencimento_modal').val() == "") {
        $("#alert_dt_vencimento_modal").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_dt_vencimento_modal").slideUp(500);
        });
        $('#alert_dt_vencimento_modal').focus();
        return false;
    }
    if ($('#vl_lancamento_modal').val() == "") {
        $("#alert_vl_lancamento_modal").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_vl_lancamento_modal").slideUp(500);
        });
        $('#alert_vl_lancamento_modal').focus();
        return false;
    }
    if ($('#metodos_pagamento_modal_pk').val() == "") {
        $("#alert_metodos_pagamento_modal_pk").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_metodos_pagamento_modal_pk").slideUp(500);
        });
        $('#alert_metodos_pagamento_modal_pk').focus();
        return false;
    }

    if ($('#ic_status_pagamento_modal').val() == "1") {
        if ($('#empresa_modal_pk').val() == "") {
            $("#alert_empresa_modal_pk").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_empresa_modal_pk").slideUp(500);
            });
            $('#alert_empresa_modal_pk').focus();
            return false;
        }
        if ($('#contas_bancarias_modal_pk').val() == "") {
            $("#alert_contas_bancarias_modal_pk").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_contas_bancarias_modal_pk").slideUp(500);
            });
            $('#alert_contas_bancarias_modal_pk').focus();
            return false;
        }
        if ($('#dt_pagamento_modal').val() == "") {
            $("#alert_dt_pagamento_modal").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_dt_pagamento_modal").slideUp(500);
            });
            $('#alert_dt_pagamento_modal').focus();
            return false;
        }
    } else if ($('#ic_status_pagamento_modal').val() == "") {
        if ($('#ic_status_pagamento_modal').val() == "") {
            $("#alert_ic_status_pagamento_modal").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert_ic_status_pagamento_modal").slideUp(500);
            });
            $('#alert_ic_status_pagamento_modal').focus();
            return false;
        }
    }
    fcEnviarLancamento();
}

function fcEnviarLancamento() {
       try {
        var doc_lancamento = fcFormatarDadosArquivosLancamento();
        var v_pk = "";
        var v_ds_lancamento = "";
        var v_tipo_lancamento_pk = "";
        var v_categoria_operacao_pk = "";
        var v_tipos_operacao_pk = "";
        var v_tipo_grupo_pk = "";
        var v_grupo_leancamento_pk = "";
        var v_leads_posto_trabalho_pk = "";
        var v_contratos_pk = "";
        var v_colaborador_posto_trabalho_pk = "";
        var v_colaborador_contratos_pk = "";
        var v_fornecedor_posto_trabalho_pk = "";
        var v_fornecedor_contratos_modal_pk = "";
        var v_tipo_grupo_centro_custo_pk_receita = "";
        var v_grupo_lancamento_centro_custo_pk_receita = "";
        var v_dt_faturamento = "";
        var v_dt_vencimento = "";
        var v_vl_lancamento = "";
        var v_metodos_pagamento_pk = "";
        var v_empresa_pk = "";
        var v_contas_bancarias_pk = "";
        var v_ic_status_pagamento = "";
        var v_dt_pagamento = "";
        var v_obs_lancamento = "";
        var v_grupo_lancamento_centro_custo_pk = "";
        var v_tipo_grupo_centro_custo_pk = "";
        var v_qtde_parcelas_pk = "";
        var v_ds_num_documento = "";
        var ic_tipo_num_documento = "";

        v_pk = $("#lancamento_pk").val();
        v_ds_lancamento = $("#ds_lancamento_modal").val();
        v_tipo_lancamento_pk = $("#tipo_lancamento_modal_pk").val();
        v_categoria_operacao_pk = $("#categoria_operacao_modal_pk").val();
        v_tipos_operacao_pk = $("#tipos_operacao_modal_pk").val();
        v_tipo_grupo_pk = $("#tipo_grupo_modal_pk").val();
        v_grupo_leancamento_pk = "";
        if (v_tipo_grupo_pk == 1) {//LEads CLiente
            var v_grupo_leancamento_pk = $("#leads_clientes_modal_pk").val();
        } else if (v_tipo_grupo_pk == 2) {//Colaborador
            var v_grupo_leancamento_pk = $("#colaborador_modal_pk").val();
        } else if (v_tipo_grupo_pk == 3) {//Fornecedor
            v_grupo_leancamento_pk = $("#fornecedor_modal_pk").val();
        } 
        if (v_tipo_grupo_pk == 4) {//Centro Custo 
        }

   

        v_leads_posto_trabalho_pk = $("#leads_posto_trabalho_modal_pk").val();
        v_contratos_pk = $("#contratos_modal_pk").val();
        v_colaborador_posto_trabalho_pk = $("#colaborador_posto_trabalho_modal_pk").val();
        v_colaborador_contratos_pk = $("#colaborador_contratos_modal_pk").val();
        v_fornecedor_posto_trabalho_pk = $("#fornecedor_posto_trabalho_modal_pk").val();
        v_fornecedor_contratos_modal_pk = $("#fornecedor_contratos_modal_pk").val();
        v_tipo_grupo_centro_custo_pk_receita = $("#tipo_grupo_centro_custo_pk_receita").val();
        v_grupo_lancamento_centro_custo_pk_receita = $("#grupo_lancamento_centro_custo_pk_receita").val();
        v_metodos_pagamento_pk = $("#metodos_pagamento_modal_pk").val();
        v_empresa_pk = $("#empresa_modal_pk").val();
        v_contas_bancarias_pk = $("#contas_bancarias_modal_pk").val();
        v_ic_status_pagamento = $("#ic_status_pagamento_modal").val();
        v_dt_pagamento = $("#dt_pagamento_modal").val();
        v_obs_lancamento = $("#obs_lancamento_modal").val();
        v_ds_num_documento = $("#ds_num_documento_modal").val();
        v_ic_tipo_num_documento = $("#ic_tipo_num_documento").val();
        if ($("#grupo_lancamento_centro_custo_colaborador_pk").val() != '') {
            v_grupo_lancamento_centro_custo_pk = $("#grupo_lancamento_centro_custo_colaborador_pk").val();
            v_tipo_grupo_centro_custo_pk = $("#tipo_grupo_modal_pk").val();
        } else if ($("#grupo_lancamento_centro_custo_fornecedor_pk").val() != '') {
            v_grupo_lancamento_centro_custo_pk = $("#grupo_lancamento_centro_custo_fornecedor_pk").val();
            v_tipo_grupo_centro_custo_pk = $("#tipo_grupo_modal_pk").val();
        }
        v_qtde_parcelas_pk = $("#qtde_parcelas_pk").val();

        if(v_pk == ""){
         
            var dados = [];

            for (i = 0; i < v_qtde_parcelas_pk; i++){            
                if(i == 0){
                    l = 1;
                }else{
                    l = i + 1;
                }    
                v_dt_faturamento = $("#dt_faturamento_modal"+l).val();
                v_dt_vencimento = $("#dt_vencimento_modal"+l).val();
                v_vl_lancamento = $("#vl_lancamento_modal"+l).val();
                parcelas_pk = l;

                /*var dadosPorParcelas = [];
                
                dadosPorParcelas[i] = {
                    "pk": v_pk,
                    "ds_lancamento": v_ds_lancamento,
                    "operacao_pk": v_tipo_lancamento_pk,
                    "categoria_operacao_pk": v_categoria_operacao_pk,
                    "tipos_operacao_pk": v_tipos_operacao_pk,
                    "tipo_grupo_pk": v_tipo_grupo_pk,
                    "grupo_leancamento_pk": v_grupo_leancamento_pk,
                    "leads_posto_trabalho_pk": v_leads_posto_trabalho_pk,
                    "contratos_pk": v_contratos_pk,
                    "colaborador_posto_trabalho_pk": v_colaborador_posto_trabalho_pk,
                    "colaborador_contratos_pk": v_colaborador_contratos_pk,
                    "fornecedor_posto_trabalho_pk": v_fornecedor_posto_trabalho_pk,
                    "fornecedor_contratos_pk": v_fornecedor_contratos_modal_pk,
                    "dt_faturamento": v_dt_faturamento,
                    "dt_vencimento": v_dt_vencimento,
                    "vl_lancamento": v_vl_lancamento,
                    "metodos_pagamento_pk": v_metodos_pagamento_pk,
                    "colaborador_pk":  $("#colaborador_modal_pk").val(),
                    "fornecedor_pk":  $("#fornecedor_modal_pk").val(),
                    "empresas_pk": v_empresa_pk,
                    "parcela_pk": parcelas_pk,
                    "contas_bancarias_pk": v_contas_bancarias_pk,
                    "ic_status_pagamento": v_ic_status_pagamento,
                    "dt_pagamento": v_dt_pagamento,
                    "obs_lancamento": v_obs_lancamento,
                    "ds_num_documento": v_ds_num_documento,
                    "grupo_lancamento_centro_custo_pk": v_grupo_lancamento_centro_custo_pk,
                    "ic_tipo_num_documento": v_ic_tipo_num_documento,
                    "tipo_grupo_centro_custo_pk": v_tipo_grupo_centro_custo_pk,       
                    "doc_lancamento": doc_lancamento       
                }
      
                dados = dadosPorParcelas;        
         
                var dados = JSON.stringify(dados);
            
                var objParametros = {
                   "dadosPorParcelas": dados
                };*/


                var objParametros = {
                    "pk": v_pk,
                    "ds_lancamento": v_ds_lancamento,
                    "operacao_pk": v_tipo_lancamento_pk,
                    "categoria_operacao_pk": v_categoria_operacao_pk,
                    "tipos_operacao_pk": v_tipos_operacao_pk,
                    "tipo_grupo_pk": v_tipo_grupo_pk,
                    "grupo_lancamento_pk": v_grupo_leancamento_pk,
                    "leads_posto_trabalho_pk": v_leads_posto_trabalho_pk,
                    "contratos_pk": v_contratos_pk,
                    "colaborador_posto_trabalho_pk": v_colaborador_posto_trabalho_pk,
                    "colaborador_contratos_pk": v_colaborador_contratos_pk,
                    "fornecedor_posto_trabalho_pk": v_fornecedor_posto_trabalho_pk,
                    "fornecedor_contratos_pk": v_fornecedor_contratos_modal_pk,
                    "dt_faturamento": v_dt_faturamento,
                    "dt_vencimento": v_dt_vencimento,
                    "vl_lancamento": v_vl_lancamento,
                    "metodos_pagamento_pk": v_metodos_pagamento_pk,
                    "colaborador_pk":  $("#colaborador_modal_pk").val(),
                    "fornecedor_pk":  $("#fornecedor_modal_pk").val(),
                    "empresas_pk": v_empresa_pk,
                    "parcela_pk": parcelas_pk,
                    "contas_bancarias_pk": v_contas_bancarias_pk,
                    "ic_status_pagamento": v_ic_status_pagamento,
                    "dt_pagamento": v_dt_pagamento,
                    "obs_lancamento": v_obs_lancamento,
                    "ds_num_documento": v_ds_num_documento,
                    "grupo_lancamento_centro_custo_pk": v_grupo_lancamento_centro_custo_pk,
                    "ic_tipo_num_documento": v_ic_tipo_num_documento,
                    "tipo_grupo_centro_custo_pk": v_tipo_grupo_centro_custo_pk,       
                    "doc_lancamento": doc_lancamento     
                };
    
            //    var arrEnviar = carregarController("lancamento", "salvarPorParcelas", objParametros);
            var arrEnviar = carregarController("lancamento", "salvar", objParametros);
                //alert(v_last_url)

            }
    
           

        }else{

            v_dt_faturamento = $("#dt_faturamento_modal1").val();
            v_dt_vencimento = $("#dt_vencimento_modal1").val();
            v_vl_lancamento = $("#vl_lancamento_modal1").val();
            parcelas_pk = $("#ds_parcelas").val();
            

            var objParametros = {
                "pk": v_pk,
                "ds_lancamento": v_ds_lancamento,
                "operacao_pk": v_tipo_lancamento_pk,
                "categoria_operacao_pk": v_categoria_operacao_pk,
                "tipos_operacao_pk": v_tipos_operacao_pk,
                "tipo_grupo_pk": v_tipo_grupo_pk,
                "grupo_leancamento_pk": v_grupo_leancamento_pk,
                "leads_posto_trabalho_pk": v_leads_posto_trabalho_pk,
                "contratos_pk": v_contratos_pk,
                "colaborador_posto_trabalho_pk": v_colaborador_posto_trabalho_pk,
                "colaborador_contratos_pk": v_colaborador_contratos_pk,
                "fornecedor_posto_trabalho_pk": v_fornecedor_posto_trabalho_pk,
                "fornecedor_contratos_pk": v_fornecedor_contratos_modal_pk,
                "dt_faturamento": v_dt_faturamento,
                "dt_vencimento": v_dt_vencimento,
                "vl_lancamento": v_vl_lancamento,
                "metodos_pagamento_pk": v_metodos_pagamento_pk,
                "colaborador_pk":  $("#colaborador_modal_pk").val(),
                "fornecedor_pk":  $("#fornecedor_modal_pk").val(),
                "empresas_pk": v_empresa_pk,
                "parcela_pk": parcelas_pk,
                "contas_bancarias_pk": v_contas_bancarias_pk,
                "ic_status_pagamento": v_ic_status_pagamento,
                "dt_pagamento": v_dt_pagamento,
                "obs_lancamento": v_obs_lancamento,
                "grupo_lancamento_centro_custo_pk": v_grupo_lancamento_centro_custo_pk,
                "ds_num_documento": v_ds_num_documento,
                "ic_tipo_num_documento": v_ic_tipo_num_documento,
                "tipo_grupo_centro_custo_pk": v_tipo_grupo_centro_custo_pk,   
                "doc_lancamento": doc_lancamento       
            };


 
            var arrEnviar = carregarController("lancamento", "salvar", objParametros);

        }
      
        
        if (arrEnviar.result == 'success') {
            alert(arrEnviar.message);

            $("#modal_lancamento").modal("hide");

            var arrCarregar = permissao("lancamento_acesso_impressao", "cons");
            
            if (arrCarregar.result == 'success'){                
                if (confirm("Deseja fazer a impressão do lançamento? ")) {
                    fcImprimirLancamento(arrEnviar.data[0]['pk']);
                }
            }else{
                alert('Cód  Lançamento - '+arrEnviar.data[0]['pk'])
                location.reload();
            }            

        } else {
            alert('Falhou a requisição para salvar o registro');
        }
       } catch (error) {
        alert(error)
       }
}

function fcEditarLancamento(pk, ic_origin) {
    
try {
    fclimpaFormLancamento();

    var v_pk = pk;

    var objParametros = {
        "pk": v_pk,
    }

    var arrCarregar = carregarController("lancamento", "lisarLancamentoPk", objParametros)

    if (arrCarregar.result == 'success') {
        if (arrCarregar.data[0]['ic_status_pagamento'] == '1' && ic_origin == '2') {
            alert("Registro não pode ser alterado");
            return false;
        }

        $("#lancamento_pk").val(arrCarregar.data[0]['pk']);
        $("#ds_lancamento_modal").val(arrCarregar.data[0]['ds_lancamento']);
        $("#tipo_lancamento_modal_pk").val(arrCarregar.data[0]['operacao_pk']);
        $("#categoria_operacao_modal_pk").val(arrCarregar.data[0]['categoria_operacao_pk']);

        //carrega combo PLano de Contas
        if (arrCarregar.data[0]['categoria_operacao_pk'] != null) {
            $(".chzn-select").chosen('destroy');
            fccarregarTipoPLanoNegocio();
        }

        $("#tipos_operacao_modal_pk").val(arrCarregar.data[0]['tipos_operacao_pk']);
        $("#tipo_grupo_modal_pk").val(arrCarregar.data[0]['tipo_grupo_pk']);
        //Carrega Combo de Lead
        if (arrCarregar.data[0]['tipo_grupo_pk'] != null) {
            $(".chzn-select").chosen('destroy');
            fcSelecionaGrupo();
        }

        $("#leads_clientes_modal_pk").val(arrCarregar.data[0]['grupo_leancamento_pk']);
        if (arrCarregar.data[0]['leads_clientes_pk'] != null) {
            $(".chzn-select").chosen('destroy');
            fccarregarLeadsPostosTrabalho();
        } else if (arrCarregar.data[0]['grupo_leancamento_pk'] != null) {
            $(".chzn-select").chosen('destroy');
            fccarregarLeadsPostosTrabalho();
        }

        $("#leads_posto_trabalho_modal_pk").val(arrCarregar.data[0]['leads_posto_trabalho_pk']);
        if (arrCarregar.data[0]['leads_posto_trabalho_pk'] != null) {
            $(".chzn-select").chosen('destroy');
            fccarregarLeadsContratos();
        }

        $("#contratos_modal_pk").val(arrCarregar.data[0]['leads_contratos_pk']);
        $("#colaborador_modal_pk").val(arrCarregar.data[0]['grupo_leancamento_pk']);

        //Carrega combo postos de trabalho

        if (arrCarregar.data[0]['tipo_grupo_pk'] == 2) {
            $(".chzn-select").chosen('destroy');
            fccarregarColaboradorPostosTrabalho();
        }
        
        if ($("#colaborador_modal_pk").val() != '') {     
            fcCarregarDadosBancariosColaborador();
        }

        $("#colaborador_posto_trabalho_modal_pk").val(arrCarregar.data[0]['colaborador_posto_trabalho_pk']);
        //Carrega Combo Contratos Colaborador
        if (arrCarregar.data[0]['colaborador_posto_trabalho_pk'] != null) {
            $(".chzn-select").chosen('destroy');
            fccarregarColaboradorContratos();
        }

        if (arrCarregar.data[0]['tipo_grupo_centro_custo_pk'] != "") {
            if (arrCarregar.data[0]['tipo_grupo_centro_custo_pk'] == 2) {
                fccarregarLeadsClientesCentroCusto();
                $("#grupo_lancamento_centro_custo_colaborador_pk").val(arrCarregar.data[0]['grupo_lancamento_centro_custo_pk']);

            } else if (arrCarregar.data[0]['tipo_grupo_centro_custo_pk'] == 3) {
                fccarregarLeadsClientesCentroCustoForncedor();
                $("#grupo_lancamento_centro_custo_fornecedor_pk").val(arrCarregar.data[0]['grupo_lancamento_centro_custo_pk']);
            }
        }

        $("#colaborador_contratos_modal_pk").val(arrCarregar.data[0]['colaborador_contratos_pk']);
        if ($("#fornecedor_contratos_modal_pk").val() != '') {
            fcCarregarDadosBancariosColaborador();
        }

        $("#fornecedor_modal_pk").val(arrCarregar.data[0]['grupo_leancamento_pk']);

        fccarregarFornecedorPostosTrabalho();
        $("#fornecedor_posto_trabalho_modal_pk").val(arrCarregar.data[0]['fornecedor_posto_trabalho_pk']);

        if (arrCarregar.data[0]['fornecedor_posto_trabalho_pk'] != null) {
            $(".chzn-select").chosen('destroy');
            fccarregarFornecedorContratos();
        }

        $("#fornecedor_contratos_modal_pk").val(arrCarregar.data[0]['fornecedor_contratos_pk']);
        $("#dt_faturamento_modal1").val(arrCarregar.data[0]['dt_faturamento']);
        $("#dt_vencimento_modal1").val(arrCarregar.data[0]['dt_vencimento']);
        $("#vl_lancamento_modal1").val(arrCarregar.data[0]['vl_lancamento']);
        $("#metodos_pagamento_modal_pk").val(arrCarregar.data[0]['metodos_pagamento_pk']);
        $("#empresa_modal_pk").val(arrCarregar.data[0]['empresas_pk']);
        $("#ds_num_documento_modal").val(arrCarregar.data[0]['ds_num_documento']);
        $("#ic_tipo_num_documento").val(arrCarregar.data[0]['ic_tipo_num_documento']);
        
        if (arrCarregar.data[0]['empresas_pk'] != null) {
            $(".chzn-select").chosen('destroy');
            fccarregarContasBancariasLancamento();
        }

        $("#contas_bancarias_modal_pk").val(arrCarregar.data[0]['contas_bancarias_pk']);
        $("#ic_status_pagamento_modal").val(arrCarregar.data[0]['ic_status_pagamento']);

        if ($("#ic_status_pagamento_modal").val() == 1) {
            $("#exibir_dt_modal").show();
        } else {
            $("#exibir_dt_modal").hide();
            $("#dt_pagamento_modal").val("");
        }

        $("#dt_pagamento_modal").val(arrCarregar.data[0]['dt_pagamento']);
        $("#obs_lancamento_modal").val(arrCarregar.data[0]['obs_lancamento']);

        var parcela_pk = arrCarregar.data[0]['parcela_pk'];
        if(parcela_pk == null){
            parcela_pk = 1;
        }

        $("#qtde_parcelas_pk").val(parcela_pk);
        $("#qtde_parcelas_pk").append("selected", true)

        var ds_parcela = $('#ds_parcela');
        ds_parcela.text(parcela_pk);
        tblDocumentosLancamento.clear().destroy(); 
        fcCarregarGridDocumentosLancamento(v_pk);
        $("#modal_lancamento").modal();
        //$(".chzn-select").chosen({ allow_single_deselect: true });

    } else {
        alert('Falhou a requisição para salvar o registro');
    }
} catch (error) {
    alert(error)
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

function fcCarregarDadosBancariosColaborador() {
    $("#listar_dados_bancarios_colaborador").html("");
    $("#listar_dados_bancarios_colaborador").append("");

    var strNenhumRegisto = "";
    var strRetorno = "";

    var objParametros = {
        pk: $("#colaborador_modal_pk").val()
    };

    var arrCarregar = carregarController("colaborador", "listarDadosBancarios", objParametros);

    if (arrCarregar.result == 'success') {

        if (arrCarregar.data.length > 0) {

            //if (arrCarregar.data[0]['ds_agencia'] != null) {
  
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
            //}



            for (i = 0; i < arrCarregar.data.length; i++) {

                //if (arrCarregar.data[i]['ds_agencia'] != null) {
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
                //}
            }
        }
    }

    strRetorno += "</tbody>";

    strRetorno += "</table>";
    //alert(strRetorno);

    $("#listar_dados_bancarios_colaborador").html(strRetorno);
}

function fcQtdeParcelas(){
    $("#combo_qtde_parcelas_pk").append("");
    $("#combo_qtde_parcelas_pk").empty();
    
    var str = "";
    str += "<select class='form-control form-control-sm'  id='qtde_parcelas_pk' name='qtde_parcelas_pk' onchange='fcGridContratoDadosFatura(0)'>";
    for (i = 1; i < 72; i++) {
        str += "<option value='" + i + "'>" + i + " </option>";
    }
    str += " </select>";
    $("#combo_qtde_parcelas_pk").append(str);
}
function fcArrayDatasVlPagamento(){
    $("#div_datas_valores_pagamento").append("");
    $("#div_datas_valores_pagamento").empty();
    if($("#qtde_parcelas_pk").val()>1){

        var li = $("#qtde_parcelas_pk").val();
        var v_linha = 1;
        var str = "";

        //alert(t[0])

        if($("#dt_faturamento_modal1").val()==''){
            alert('Preencha o campo Dt Faturamento');
            $("#qtde_parcelas_pk").val("1")
            return false;
        }   
        
        if($("dt_vencimento_modal1").val()==''){
            alert('Preencha o campo Dt Vencimento');
            $("#qtde_parcelas_pk").val("1")
            return false;
        }       
        if($("#vl_lancamento_modal1").val()==''){
            alert('Preencha o campo Vl Lancamento!');
            $("#qtde_parcelas_pk").val("1")
            return false;
        }
        //Separa a data do valor de faturamento      
        var dt_faturamento = $("#dt_faturamento_modal1").val()     
       // var d_faturamento = new Date(dt_faturamento[2],dt_faturamento[1],dt_faturamento[0]);// 31 de janeiro de 2016
        //var v_dia_faturamento = d_faturamento.getDate();

       /* if(d_faturamento.getMonth()=="11"){
            var v_mes_faturamento = "01";    
            var v_ano_faturamento = d_faturamento.getFullYear()+1;
        }else{
            var v_mes_faturamento = d_faturamento.getMonth();
            var v_ano_faturamento = d_faturamento.getFullYear();
        }*/

        //Separa a data do valor de vencimento 
        var dt_vencimento = $("#dt_vencimento_modal1").val().split("/")     
        var d_vencimento = new Date(dt_vencimento[2],dt_vencimento[1],dt_vencimento[0]);// 31 de janeiro de 2016
        var v_dia_vencimento = d_vencimento.getDate();
            v_dia_vencimento = v_dia_vencimento<10?"0"+v_dia_vencimento:v_dia_vencimento;

        if(d_vencimento.getMonth()=="11"){
            var v_mes_vencimento = "01";    
            var v_ano_vencimento = d_vencimento.getFullYear()+1;
        }else{
            var v_mes_vencimento = d_vencimento.getMonth()+1;
            var v_ano_vencimento = d_vencimento.getFullYear();
        }
        
        var vl_lancamento_modal = $("#vl_lancamento_modal1").val();       

        for (i = 1; i < li; i++) {  

            //var v_dt_lancamentos_meses =v_dia_faturamento+"/"+v_mes_faturamento+"/"+v_ano_faturamento;
            v_mes_vencimento = v_mes_vencimento<10?"0"+v_mes_vencimento:v_mes_vencimento;
            var v_dt_vencimento_meses =v_dia_vencimento+"/"+v_mes_vencimento+"/"+v_ano_vencimento;
            v_linha = i + 1;

            str += "    <tr>";
            str += "        <td >";
            str += "            Parcela" +v_linha; 
            str += "            <input type='hidden' id='parcela_pk"+v_linha+"' value='"+v_linha+"' />"; 
            str += "        </td>";
            str += "        <td>";
            str += "            <input type='text' class='form-control form-control-sm' id='dt_faturamento_modal"+v_linha+"' name='dt_faturamento_modal' onkeypress='mascara(this,mdata)' maxlength='10' value="+dt_faturamento+" />";
            str += "        </td>";
            str += "        <td>";
            str += "            <input type='text' class='form-control form-control-sm' id='dt_vencimento_modal"+v_linha+"' name='dt_vencimento_modal' onkeypress='mascara(this,mdata)' maxlength='10' value="+v_dt_vencimento_meses+" />";
            str += "        </td>";
            str += "        <td>";
            str += "            <input type='text' class='form-control form-control-sm' id='vl_lancamento_modal"+v_linha+"' name='vl_lancamento_modal' onkeypress='mascara(this,moeda)' value='"+vl_lancamento_modal+"'/>";
            str += "        </td>";
            str += "    </tr>";
            v_linha ++;

            /*if(v_mes_faturamento==12){
                v_mes_faturamento ="01";
                v_ano_faturamento ++;
            }else{
                v_mes_faturamento++;
            }*/

            if(v_mes_vencimento==12){
                v_mes_vencimento ="01";
                v_ano_vencimento ++;
            }else{
                v_mes_vencimento++;
            }
            
        }   
        $("#div_datas_valores_pagamento").append(str);
    }
}


//Documentos
function fcIncluirLinhaArquivoLancamento(nome_original){
    try {
        
    tblDocumentosLancamento.row.add({
        "t_pk":"",
        "t_ds_documento":$("#ds_documento_lancamento").text(),
        "t_ds_nome_original":nome_original,
        "t_functions":"<i class='bi bi-cloud-arrow-up function_download' style='font-size:18px; color:black' title='DOWNLOAD DOCUMENTO'></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class='bi bi-x-circle function_delete' style='font-size:18px; color:black' title='EXCLUIR O DOCUMENTO'></i>"
    }).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcApagarArquivoLancamento);
    return false;
    } catch (error) {
        alert(error)
    }
}

function fsClean() {
    $('#progressLancamento .progress-bar').css('width', '0%');
}

function Reset(){
    $('#progressLancamento .progress-bar').css('width', '0%');
}

$(function () {
    $('#fileuploadLancamento').fileupload({
    
        dataType: 'json',
        done: function (e, data) {
            window.setTimeout('Reset()', 2000);
            $.each(data.files, function (index, file) {
                $("#ds_nome_original_Lancamento").html(file.name);
                fcAlterarNomeArquivoLancamento(file.name);
                fcIncluirLinhaArquivoLancamento(file.name);
                
            });
        },
        fail: function (data) {
            alert("Falha ao subir o arquivo");
        },            
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progressLancamento .progress-bar').css('width', progress + '%');
        }
    });  
});

function fcFormatarDadosArquivosLancamento(){

    try {
        var DocLancamentoPk = "";
        var dsDocumento = "";
        var dsNomeOriginal = "";
        
        var arrKeys = [];
        arrKeys[0] = "doc_lancamento_pk";
        arrKeys[1] = "ds_documento";
        arrKeys[2] = "ds_nome_original";
        
        var arrDados = [];
            var i = 0;
            $('#tblDocumentosLancamento tbody tr').each(function () {
            var colunas = $(this).children();
                DocLancamentoPk =  $(colunas[0]).text(); 
                dsDocumento =  $(colunas[1]).text(); 
                dsNomeOriginal = $(colunas[2]).text();
                
                
                arrDados[i] = [DocLancamentoPk,dsDocumento, dsNomeOriginal];
                i++;
            });
            
        return arrayToJson(arrKeys, arrDados);
    } catch (error) {
        alert(error)
    }
   
    
}

function fcAlterarNomeArquivoLancamento(v_arquivo){  
    var objParametros = {
        "ds_arquivo": v_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "renomearArquivoLancamento", objParametros);
    
    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#ds_documento_lancamento").text(arrEnviar.data[0]['t_ds_nome_salvo']);
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }  
}

function fcApagarArquivoLancamento(){
    var nome_arquivo = "";
    $('#tblDocumentosLancamento tbody tr').click(function () {
        var colunas = $(this).children();
        nome_arquivo = $(colunas[0]).text();
        fcExcluirArquivoLancamento(nome_arquivo);
    });
    
    tblDocumentosLancamento.row($(this).parents('tr')).remove().draw();
}

function fcExcluirArquivoLancamento(v_nome_arquivo){
    var objParametros = {
        "nome_arquivo": v_nome_arquivo
    };       
    carregarController("documento", "removerArquivo", objParametros);   
}



function fcNovoLancamento() {
    try {
        
    fclimpaFormLancamento();
    tblDocumentosLancamento.clear().destroy();  
    fcCarregarGridDocumentosLancamento("");
    $("#modal_lancamento").modal();
    } catch (error) {
        alert(error)
    }
}


function fcCarregarGridDocumentosLancamento(v_pk){
    var objParametros = {
        "lancamentos_pk": v_pk
    };     

    var v_url = montarUrlController("documento", "listarDocumentosLancamentos", objParametros);  
    //Trata a tabela
    tblDocumentosLancamento = $('#tblDocumentosLancamento').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_download'><span><i class='bi bi-cloud-arrow-up' style='font-size:18px; color:black' title='DOWNLOAD DOCUMENTO'></i></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><i class='bi bi-x-circle ' style='font-size:18px; color:black' title='EXCLUIR O DOCUMENTO'></i></span></a>"
            },
            {"targets": -2, "data": "t_ds_nome_original"},
            {"targets": -3, "data": "t_ds_documento"},
            {"targets": -4, "data": "t_pk"}

        ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblDocumentosLancamento tbody').on('click', '.function_download', function () {
        var data;
        if(tblDocumentosLancamento.row( $(this).parents('li') ).data()){
            data = tblDocumentosLancamento.row( $(this).parents('li') ).data();
        }else if(tblDocumentosLancamento.row( $(this).parents('tr') ).data()){
            data = tblDocumentosLancamento.row( $(this).parents('tr') ).data();
        }
            
        fcDownloadDocumentoLancamento(data['t_ds_documento']);
    });
    $('#tblDocumentosLancamento tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblDocumentosLancamento.row( $(this).parents('li') ).data()){
            data = tblDocumentosLancamento.row( $(this).parents('li') ).data();
        }else if(tblDocumentosLancamento.row( $(this).parents('tr') ).data()){
            data = tblDocumentosLancamento.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirDocumentoLancamento(data['t_pk'],data['t_ds_documento']);
        }
    });
}

function fcDownloadDocumentoLancamento(ds_documento){
    var arrCarregar = permissao("documento", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    var v_url = "../docs/"+ds_documento;
    window.open(v_url, '_blank');
}

function fcExcluirDocumentoLancamento(v_pk,v_ds_documento){
    var arrCarregar = permissao("documento", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if(v_pk != ""){
        
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("documento", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            fcExcluirArquivoLancamento(v_ds_documento);
            tblDocumentosLancamento.clear().destroy();    
            fcCarregarGridDocumentosLancamento();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

$(document).ready(function () {

    //var data = ;
    //data.setDate(data.getDate() + 4)
    //alert()

    fclimpaFormLancamento();
    //prmissões
    fcpermissaoStatusPago();
    $("#label_lancamento").html('Lançar Para:');

    fccarregarCategoriaoperacao();
    //fccarregarTipoPLanoNegocio();
    fccarregarEmpresaContaleancamento();

    $("#tipo_lancamento_modal_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcgerenciaLabel();
    });

    $("#categoria_operacao_modal_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fccarregarTipoPLanoNegocio();
    });

    $("#empresa_modal_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fccarregarContasBancariasLancamento();
    });

    $("#tipo_grupo_modal_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcSelecionaGrupo();
    });

    $("#leads_clientes_modal_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fccarregarLeadsPostosTrabalho();
    });

    $("#leads_posto_trabalho_modal_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fccarregarLeadsContratos();
    });

    $("#colaborador_modal_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fccarregarLeadsClientesCentroCusto();
        fccarregarColaboradorPostosTrabalho();
    });

    $("#grupo_lancamento_centro_custo_colaborador_pk").change(function () {
        $(".chzn-select").chosen('destroy');

        fccarregarColaboradorPostosTrabalho();
    });

    $("#colaborador_posto_trabalho_modal_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fccarregarColaboradorContratos()
    });

    $("#grupo_lancamento_centro_custo_fornecedor_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fccarregarFornecedorPostosTrabalho();
    });

    //Função de parcelas

    fcQtdeParcelas();
    //fcArrayDatasVlPagamento();

    $("#qtde_parcelas_pk").change(function () {
       
        fcArrayDatasVlPagamento();
    });

    $("#fornecedor_posto_trabalho_modal_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fccarregarFornecedorContratos()
    });

    $(".chzn-select").chosen({ allow_single_deselect: true });

    var arrCarregar = permissao("lancar_dt_atual_retroativa", "ins");
    //var arrCarregar = permissao("colaborador", "ins");
    
    if (arrCarregar.result == 'success'){
        $('#dt_faturamento_modal1').datepicker({
            //startDate: "+0d",
            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: false,
            todayBtn: "linked",
            minDate: new Date()
        });
    
        $("#dt_faturamento_modal1").keypress(function () {
            mascara(this, mdata);
        });
    
        $('#dt_vencimento_modal1').datepicker({
            //startDate: "+0d",
            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: false,
            todayBtn: "linked",
            minDate: new Date()
        }).datepicker();
    
        $("#dt_vencimento_modal1").keypress(function () {
            mascara(this, mdata);
        });
    
        $('#dt_pagamento_modal').datepicker({
            //startDate: "+0d",
            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: false,
            todayBtn: "linked",
            minDate: new Date()
        }).datepicker();
    
        $("#dt_pagamento_modal").keypress(function () {
            mascara(this, mdata);
        });
    }else{
        $('#dt_faturamento_modal1').datepicker({
            startDate: "",
            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: false,
            todayBtn: "linked",
            minDate: new Date()
        });
    
        $("#dt_faturamento_modal1").keypress(function () {
            mascara(this, mdata);
        });
    
        $('#dt_vencimento_modal1').datepicker({
            startDate: "+4d",
            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: false,
            todayBtn: "linked",
            minDate: new Date()
        }).datepicker();
    
        $("#dt_vencimento_modal1").keypress(function () {
            mascara(this, mdata);
        });
    
        $('#dt_pagamento_modal').datepicker({
            startDate: "",
            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: false,
            todayBtn: "linked",
            minDate: new Date()
        }).datepicker();
    
        $("#dt_pagamento_modal").keypress(function () {
            mascara(this, mdata);
        });
    }


    $("#vl_lancamento_modal1").keypress(function () {
        mascara(this, moeda);
    });

    fccarregarMetodosPagamentoReceita();

    $("#exibir_dt_modal").hide();

    $("#ic_status_pagamento_modal").change(function () {
        if ($("#ic_status_pagamento_modal").val() == 1) {
            $("#exibir_dt_modal").show();
        } else {
            $("#exibir_dt_modal").hide();
            $("#dt_pagamento_modal").val("");
        }
    });

    //Esta função deixar show apenas para o cliente ECol
    $("#divExibirCentroCustol").hide();

    $("#tipo_grupo_centro_custo_pk_receita").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposCentroCustoReceita();
        //$(".chzn-select").chosen({ allow_single_deselect: true });
    });

    $("#colaborador_modal_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcCarregarDadosBancariosColaborador();
        //$(".chzn-select").chosen({ allow_single_deselect: true });
    });

    fcCarregarGridDocumentosLancamento("");
    $(document).on('click', '#btnSalvarLancamento', fcvalidarFormLancamentoCad);

    var arrCarregar = permissao("lancamento_empresa", "cons");  
    if (arrCarregar.result != 'success') {
        $("#div_lancar_empresa").hide();
        return false;
    }

    
    var arrCarregar = permissao("lancamento_contabancaria", "cons");  
    if (arrCarregar.result != 'success') {
        $("#div_conta_bancarias").hide();
        return false;
    }


});

