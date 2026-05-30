function fcLimparGridLancamentoFormulario() {
    $("#pk_lancamento_lancamento").val();
    $("#ic_status_pagamento_lancamento").val();
    $("#usuario_cadastro_lancamento_pk").val();
    $("#empresa_lancamento_pk").val();
    $("#tipo_grupo_lancamento_pk").val();
    $("#grupo_leancamento_lancamento_pk").val();
    $("#dt_cadastro_ini_lancamento").val();
    $("#dt_cadastro_fim_lancamento").val();
    $("#dt_faturamento_ini_lancamento").val();
    $("#dt_faturamento_fim_lancamento").val();
    $("#dt_faturamento_ini_lancamento").val();
    $("#dt_faturamento_fim_lancamento").val();
    $("#dt_vencimento_ini_lancamento").val();
    $("#dt_vencimento_fim_lancamento").val();
    $("#dt_pagamento_ini_lancamento").val();
    $("#dt_pagamento_fim_lancamento").val();
}

function fcCarregarComboEmpresasLancamento() {
    var objParametros = {

    };
    var arrCarregar = carregarController("conta_bancaria", "listarEmpresaContasAtivas", objParametros);

    carregarComboAjax($("#empresa_lancamento_pk"), arrCarregar, " ", "pk", "ds_conta");
}
function fcCarregarComboContasLancamento() {

    var objParametros = {
        "empresas_pk": $("#empresa_lancamento_pk").val()
    };
    var arrCarregar = carregarController("conta_bancaria", "listarContasLancamento", objParametros);

    carregarComboAjax($("#contas_lancamento_pk"), arrCarregar, " ", "pk", "ds_dados_conta");
}

function fcCarregarComboUsuarios() {
    var objParametros = {

    };
    var arrCarregar = carregarController("usuario", "listarTodosSemAdm", objParametros);
    carregarComboAjax($("#usuario_cadastro_lancamento_pk"), arrCarregar, " ", "pk", "ds_usuario");
}

function fcListarItensGruposLancamento() {

    var objParametros = {
        "tipo_grupo_pk": ""
    };
    if ($("#tipo_grupo_lancamento_pk").val() == 1) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros);
        //NewWindow(v_last_url);
        carregarComboAjax($("#grupo_leancamento_lancamento_pk"), arrCarregar, " ", "pk", "ds_lead");
    } else if ($("#tipo_grupo_lancamento_pk").val() == 2) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);

        carregarComboAjax($("#grupo_leancamento_lancamento_pk"), arrCarregar, " ", "pk", "ds_colaborador");
    } else if ($("#tipo_grupo_lancamento_pk").val() == 3) {
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);
        carregarComboAjax($("#grupo_leancamento_lancamento_pk"), arrCarregar, " ", "pk", "ds_fornecedor");
    }
}


function fcCarregarGridLancamento() {

    var v_cod = $("#pk_lancamento_lancamento").val();
    var v_ic_status = $("#ic_status_pagamento_lancamento").val();
    var v_usuario_cadastro_pk = $("#usuario_cadastro_lancamento_pk").val();
    var v_empresa_pk = $("#empresa_lancamento_pk").val();
    var v_tipo_grupo_pk = $("#tipo_grupo_lancamento_pk").val();
    var v_grupo_lancamento_pk = $("#grupo_leancamento_lancamento_pk").val();
    var v_dt_cadastro_ini = $("#dt_cadastro_ini_lancamento").val();
    var v_dt_cadastro_fim = $("#dt_cadastro_fim_lancamento").val();
    var v_dt_faturamento_ini = $("#dt_faturamento_ini_lancamento").val();
    var v_dt_faturamento_fim = $("#dt_faturamento_fim_lancamento").val();

    var v_dt_vencimento_ini = $("#dt_vencimento_ini_lancamento").val();
    var v_dt_vencimento_fim = $("#dt_vencimento_fim_lancamento").val();
    var v_dt_pagamento_ini = $("#dt_pagamento_ini_lancamento").val();
    var v_dt_pagamento_fim = $("#dt_pagamento_fim_lancamento").val();
    var v_ds_num_documento_lancamento = $("#ds_num_documento_lancamento").val();
    var v_ic_tipo_num_documento_lancamento = $("#ic_tipo_num_documento_lancamento").val();


    var hoje = new Date();
    var dia = hoje.getDate();
    var mes = hoje.getMonth() + 1;
    var ano = hoje.getFullYear();
    var data = dia + '/' + mes + '/' + ano;

    var v_ano = ano;
    var v_mes = mes;

    var objParametros = {
        "pk": v_cod,
        "ds_mes": v_mes,
        "ds_ano": v_ano,
        "ic_status_pagamento": v_ic_status,
        "usuario_cadastro_pk": v_usuario_cadastro_pk,
        "empresas_pk": v_empresa_pk,
        "tipo_grupo_pk": v_tipo_grupo_pk,
        "grupo_lancamento_pk": v_grupo_lancamento_pk,
        "dt_cadastro_ini": v_dt_cadastro_ini,
        "dt_cadastro_fim": v_dt_cadastro_fim,
        "dt_faturamento_ini": v_dt_faturamento_ini,
        "dt_faturamento_fim": v_dt_faturamento_fim,
        "dt_vencimento_ini": v_dt_vencimento_ini,
        "dt_vencimento_fim": v_dt_vencimento_fim,
        "dt_pagamento_ini": v_dt_pagamento_ini,
        "dt_pagamento_fim": v_dt_pagamento_fim,
        "ds_num_documento": v_ds_num_documento_lancamento,
        "ic_tipo_num_documento": v_ic_tipo_num_documento_lancamento
    };

    var arrCarregar = carregarController("lancamento", "listarLancamentoGrid", objParametros);
    //NewWindow(v_last_url)
    var vhtml = "";
    if (arrCarregar.result == 'success') {
        vhtml += "<div class='overflow-auto' style='height:500px;overflow-y: scroll;' >";
        vhtml += "   <table id='tabela' class='table table-striped table-bordered ' style='width:100%' id='tblResultado' >";
        vhtml += "       <thead style='position: sticky; top: 0px; background-color: white;'>";
        vhtml += "           <tr>";
        vhtml += "               <th width='5' align='center'><font style='font-size: 15px'><b>#</b></font></th>";
        vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Identificação do Lançamento</b></font></th>";
        vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Cadastro</b></font></th>";
        vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Usuário de<br>Cadastro</b></font></th>";
        vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Empresa</b></font></th>";
        vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Conta</b></font></th>";
        vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Faturamento</b></font></th>";
        vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Vencimento</b></font></th>";
        vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Pagamento</b></font></th>";
        vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Status</b></font></th>";
        vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Tipo</b></font></th>";
        vhtml += "               <th align='center'><font style='font-size: 15px'><b>Tipo Operação</b></font></th>";
        vhtml += "               <th align='center'><font style='font-size: 15px'><b>Grupo de Lançamento</b></font></th>";
        vhtml += "               <th align='center'><font style='font-size: 15px'><b>Recebido de / Pago Para</b></font></th>";
        vhtml += "               <th align='center'><font style='font-size: 15px'><b>Metódo Pag.</b></font></th>";
        vhtml += "               <th align='center'><font style='font-size: 15px'><b>Vl Lançamento</b></font></th>";
        vhtml += "               <th align='center'><font style='font-size: 15px'><b>Vl Pendente</b></font></th>";
        vhtml += "               <th align='center'><font style='font-size: 15px'><b>Ação</b></font></th>";
        vhtml += "           </tr>";
        vhtml += "        </thead>";
        var vl_lancamento = "0";
        var vl_pendente = "0";
        if (arrCarregar.data.length > 0) {

            vhtml += "        <tbody>";
            var cont = 1;

            vl_lancamento = arrCarregar.data[0]['vl_total_lancamento'];
            vl_pendente = arrCarregar.data[0]['vl_total_lancamento_pendente'];

            for (i = 0; i < arrCarregar.data[0].DadosExtratoLancamento.length; i++) {
                var v_pk = arrCarregar.data[0].DadosExtratoLancamento[i].pk;
                var v_dt_cadastro = "";
                var v_ds_usuario = "";
                var v_ds_empresa = "";
                var v_ds_conta_bancaria = "";
                var v_dt_faturamento = "";
                var v_dt_vencimento = "";
                var v_dt_pagamento = "";
                var v_ds_status_pagamento = "";
                var v_ds_operacao = "";
                var v_ds_tipo_operacao = "";
                var v_ds_tipos_grupo = "";
                var v_recebido_pago_origem = "";
                var v_ds_metodo_pagamento = "";
                var v_vl_lancamento = "";
                var v_vl_lancamento = "";
                var v_vl_lancamento = "";
                var v_vl_pendente = "";
                var ic_status_pagamento = "";

                v_proximo_dt_vencimento = arrCarregar.data[0].DadosExtratoLancamento[i].proxima_data;

                if (arrCarregar.data[0].DadosExtratoLancamento[i].dt_cadastro != null) {
                    v_dt_cadastro = arrCarregar.data[0].DadosExtratoLancamento[i].dt_cadastro;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].ds_usuario != null) {
                    v_ds_usuario = arrCarregar.data[0].DadosExtratoLancamento[i].ds_usuario;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].ds_empresa != null) {
                    v_ds_empresa = arrCarregar.data[0].DadosExtratoLancamento[i].ds_empresa;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].ds_conta_bancaria != null) {
                    v_ds_conta_bancaria = arrCarregar.data[0].DadosExtratoLancamento[i].ds_conta_bancaria;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].dt_faturamento != null) {
                    v_dt_faturamento = arrCarregar.data[0].DadosExtratoLancamento[i].dt_faturamento;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].dt_vencimento != null) {
                    v_dt_vencimento = arrCarregar.data[0].DadosExtratoLancamento[i].dt_vencimento;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].dt_pagamento != null) {
                    v_dt_pagamento = arrCarregar.data[0].DadosExtratoLancamento[i].dt_pagamento;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].ds_status_pagamento != null) {
                    v_ds_status_pagamento = arrCarregar.data[0].DadosExtratoLancamento[i].ds_status_pagamento;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].ds_operacao != null) {
                    v_ds_operacao = arrCarregar.data[0].DadosExtratoLancamento[i].ds_operacao;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].ds_tipo_operacao != null) {
                    v_ds_tipo_operacao = arrCarregar.data[0].DadosExtratoLancamento[i].ds_tipo_operacao;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].ds_tipo_grupo != null) {
                    v_ds_tipos_grupo = arrCarregar.data[0].DadosExtratoLancamento[i].ds_tipo_grupo;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].ds_recebido_pago_origem != null) {
                    v_recebido_pago_origem = arrCarregar.data[0].DadosExtratoLancamento[i].ds_recebido_pago_origem;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].ds_metodo_pagamento != null) {
                    v_ds_metodo_pagamento = arrCarregar.data[0].DadosExtratoLancamento[i].ds_metodo_pagamento;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento != null && arrCarregar.data[0].DadosExtratoLancamento[i].operacao_pk == 1) {
                    v_vl_lancamento = arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento != null && arrCarregar.data[0].DadosExtratoLancamento[i].operacao_pk != 1) {
                    v_vl_lancamento = arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento != null) {
                    v_vl_lancamento = arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].ic_status_pagamento != null) {
                    ic_status_pagamento = arrCarregar.data[0].DadosExtratoLancamento[i].ic_status_pagamento;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento_pendente_dia == null) {
                    vl_lancamento_pendente_dia = "";
                }else{
                    vl_lancamento_pendente_dia = arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento_pendente_dia;
                }
               
                if (arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento_dia == null) {
                    vl_lancamento_dia = "";
                }else{
                    vl_lancamento_dia = arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento_dia;
                }

                if (arrCarregar.data[0].DadosExtratoLancamento[i].ds_lancamento == null) {
                    ds_lancamento = "";
                }else{
                    ds_lancamento = arrCarregar.data[0].DadosExtratoLancamento[i].ds_lancamento;
                }

                var v_cor_linha = "";
                if (v_dt_vencimento < data) {
                    if (arrCarregar.data[0].DadosExtratoLancamento[i].ic_status_pagamento != 1 && v_dt_pagamento == "") {
                        v_cor_linha = "style='color: red'";

                        if (arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento != null && arrCarregar.data[0].DadosExtratoLancamento[i].operacao_pk == 1) {
                            v_vl_pendente = arrCarregar.data[0].DadosExtratoLancamento[i].vl_lancamento;
                        }

                    }
                }
                vhtml += "           <tr " + v_cor_linha + " >";
                vhtml += "               <td width='100' align='center'>" + v_pk + "</td>";
                vhtml += "               <td width='100' align='center'>" + ds_lancamento + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_dt_cadastro + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_ds_usuario + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_ds_empresa + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_ds_conta_bancaria + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_dt_faturamento + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_dt_vencimento + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_dt_pagamento + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_ds_status_pagamento + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_ds_operacao + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_ds_tipo_operacao + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_ds_tipos_grupo + "</td>";
                vhtml += "               <td align='center'>" + v_recebido_pago_origem + "</td>";
                vhtml += "               <td align='center'>" + v_ds_metodo_pagamento + "</td>";
                vhtml += "               <td align='center'>" + v_vl_lancamento + "</td>";
                vhtml += "               <td align='center'>" + v_vl_pendente + "</td>";
                vhtml += "               <td>";
                vhtml += "                  <table>";
                vhtml += "                      <tr>";
                vhtml += "                          <td>";
                vhtml += "                              <i style='font-size: 15px;' class='bi bi-pencil-square' title='Editar Lançamento' onclick='fcEditarLancamento(" + v_pk + ")' ></i>";
                vhtml += "                          </td>";
                vhtml += "                          <td>";
                vhtml += "                              <i style='font-size: 15px;' id='cmdDocumentos' class='bi bi-file-earmark-arrow-up' title='Anexo de Documentos' onclick='fcAnexarDocumento(" + v_pk + ")'></i>";
                vhtml += "                          </td>";
                vhtml += "                      </tr>";
                vhtml += "                      <tr>";
                vhtml += "                          <td>";
                vhtml += "                              <i style='font-size: 15px;' id='cmdImprimir' class='bi bi-printer' title='Imprimir Lançamento' onclick='fcImprimirLancamento(" + v_pk + ")'></i>";
                vhtml += "                          </td>";
                vhtml += "                          <td>";
                vhtml += "                              <i style='font-size: 15px;' id='cmdExcluir' class='bi bi-x-circle' title='Excluir Lançamento' onclick='fcExcluirLancamento(" + v_pk + "," + ic_status_pagamento + ")'></i>";
                vhtml += "                          </td>";
                vhtml += "                      </tr>";
                vhtml += "                  </table>";
                vhtml += "                </td>";
                vhtml += "           </tr>";
                if(v_dt_vencimento != v_proximo_dt_vencimento || v_proximo_dt_vencimento == ""){
                    vhtml += "            <tr style='background-color: ffffdd;'>";
                    vhtml += "               <td width='100' colspan=14 >&nbsp;</td>";
                    vhtml += "               <td width='100' ><b>Total R$<b/></td>";
                    vhtml += "               <td align='center'>" + vl_lancamento_dia + "</td>";
                    vhtml += "               <td align='center'><font color='red'>" + vl_lancamento_pendente_dia + "</font></td>";
                    vhtml += "               <td align='center'>&nbsp;</td>";
                    vhtml += "           </tr>";
            }
            cont++;
        }
            vhtml += "       </tbody>";
        }
        vhtml += "       <tfoot style='position: sticky; bottom: 0px; background-color: white;'>";
        vhtml += "           <tr>";
        vhtml += "               <td width='100' colspan=14 >&nbsp;</td>";
        vhtml += "               <td width='100' ><b>Total R$<b/></td>";
        vhtml += "               <td align='center'>" + vl_lancamento + "</td>";
        vhtml += "               <td align='center'><font color='red'>" + vl_pendente + "</font></td>";
        vhtml += "               <td align='center'>&nbsp;</td>";
        vhtml += "           </tr>";
        vhtml += "       </tfoot>";
        vhtml += "   </table>";
        vhtml += "</div>";

    }
    $("#grid_lancamento").html(vhtml);
}

function fcPesquisarLancamentosLancamento() {
    if($("#ic_status_pagamento_lancamento").val() == ""){
        if($("#usuario_cadastro_lancamento_pk").val() == ""){
            if($("#ds_num_documento_lancamento").val() == ""){
                if($("#ic_tipo_num_documento_lancamento").val() == ""){
                    if($("#empresa_lancamento_pk").val() == ""){
                        if($("#contas_lancamento_pk").val() == ""){
                            if($("#tipo_grupo_lancamento_pk").val() == ""){
                                if($("#grupo_leancamento_lancamento_pk").val() == ""){
                                    if($("#dt_cadastro_ini_lancamento").val() == "" && $("#dt_cadastro_fim_lancamento").val() == ""){
                                        if($("#dt_faturamento_ini_lancamento").val() == "" && $("#dt_faturamento_fim_lancamento").val() == ""){
                                            if($("#dt_pagamento_ini_lancamento").val() == "" && $("#dt_pagamento_fim_lancamento").val() == ""){
                                                if($("#pk_lancamento_lancamento").val() == ""){
                                                    if($("#dt_vencimento_ini_lancamento").val() == "" && $("#dt_vencimento_fim_lancamento").val() == ""){
                                                        alert('Preencha os campos dt. vencimento ou cód lançamento');
                                                        return false;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

   

   /* if ($("#dt_cadastro_ini_lancamento").val() != "" && $("#dt_cadastro_fim_lancamento").val() == '' ) {
        alert('Preencha a Data de Cadastro fim!');
        return false;
    }

    if ($("#dt_faturamento_ini_lancamento").val() != "" && $("#dt_faturamento_fim_lancamento").val() == ''  && $("#pk_lancamento_lancamento").val() == '') {
        alert('Preencha a Data de Faturamento fim!');
        return false;
    }

    if ($("#dt_vencimento_ini_lancamento").val() != "" || $("#dt_vencimento_fim_lancamento").val() != "") {
            alert('Preencha a Data de Vencimento ou Cód de Lançamento!');
            return false;
    }

    if ($("#dt_pagamento_ini_lancamento").val() != "" && $("#dt_pagamento_fim_lancamento").val() == '') {
        alert('Preencha a Data de Pagamento fim!');
        return false;
    }*/

    fcCarregarGridLancamento();
}

$(document).ready(function () {
    fcLimparGridLancamentoFormulario();
    fcCarregarComboEmpresasLancamento();
    fcCarregarComboUsuarios();

    $(".chzn-select").chosen({ allow_single_deselect: true });

    $("#empresa_lancamento_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcCarregarComboContasLancamento();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });

    $("#tipo_grupo_lancamento_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposLancamento();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });


    $('#dt_cadastro_ini_lancamento').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_ini_lancamento").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_cadastro_fim_lancamento').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_fim_lancamento").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_faturamento_ini_lancamento').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_ini_lancamento").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_faturamento_fim_lancamento').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_faturamento_fim_lancamento").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_vencimento_ini_lancamento').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_ini_lancamento").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_vencimento_fim_lancamento').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_fim_lancamento").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_pagamento_ini_lancamento').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_pagamento_ini_lancamento").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_pagamento_fim_lancamento').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_pagamento_fim_lancamento").keypress(function () {
        mascara(this, mdata);
    });

    var hoje = new Date();
    var mes = hoje.getMonth() + 1;
    var ano = hoje.getFullYear();

    var udm = (new Date(ano, parseInt(hoje.getMonth()) + 1, 0, 0, 0, 0)).getDate();

    //$("#dt_vencimento_ini_lancamento").val("01/" + mes + "/" + ano)
   // $("#dt_vencimento_fim_lancamento").val(udm + "/" + mes + "/" + ano)

    $(document).on('click', '#cmdPesqLancamento', function () {
        fcPesquisarLancamentosLancamento();
    });

    //fcCarregarGridLancamento();

});
