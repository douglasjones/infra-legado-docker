function fcCarregarComboBox() {
    var today = new Date();
    var year = today.getFullYear();
    var ano = year;

    var combo = "";
    combo += "<select id='ds_ano' class='btn btn-primary'>";
    combo += "   <option>2020</option>";
    combo += "   <option>2021</option>";
    combo += "   <option selected>2022</option>";
    combo += "   <option>2023</option>";
    combo += "   <option>2024</option>";
    combo += "   <option>2025</option>";
    combo += " </select>";
    $('#ds_ano option[value=' + year + ']').prop('selected', true);
    $("#combo").append(combo);
}

function fcDatasCaleandario(mes, ano) {
    var today = new Date();
    if (mes == "") {
        var mm = today.getMonth() + 1; //January is 0!   
    } else {
        var mm = mes; //January is 0!   
    }

    if (ano == "") {
        var yyyy = today.getFullYear();
    } else {
        var yyyy = ano;
    }

    $("#ds_ano").val(yyyy);

    if (mm == '1') {
        $("#ic_mes").val(1);
        fcRemoverClassActiveButton();
        $('#ic_jan').addClass('active');
    } else if (mm == '2') {
        $("#ic_mes").val(2);
        fcRemoverClassActiveButton();
        $('#ic_fev').addClass('active');
    } else if (mm == '3') {
        $("#ic_mes").val(3);
        fcRemoverClassActiveButton();
        $('#ic_mar').addClass('active');
    } else if (mm == '4') {
        $("#ic_mes").val(4);
        fcRemoverClassActiveButton();
        $('#ic_abr').addClass('active');
    } else if (mm == '5') {
        $("#ic_mes").val(5);
        fcRemoverClassActiveButton();
        $('#ic_mai').addClass('active');
    } else if (mm == '6') {
        $("#ic_mes").val(6);
        fcRemoverClassActiveButton();
        $('#ic_jun').addClass('active');
    } else if (mm == '7') {
        $("#ic_mes").val(7);
        fcRemoverClassActiveButton();
        $('#ic_jul').addClass('active');
    } else if (mm == '8') {
        $("#ic_mes").val(8);
        fcRemoverClassActiveButton();
        $('#ic_ago').addClass('active');
    } else if (mm == '9') {
        $("#ic_mes").val(9);
        fcRemoverClassActiveButton();
        $('#ic_set').addClass('active');
    } else if (mm == '10') {
        $("#ic_mes").val(10);
        fcRemoverClassActiveButton();
        $('#ic_out').addClass('active');
    } else if (mm == '11') {
        $("#ic_mes").val(11);
        fcRemoverClassActiveButton();
        $('#ic_nov').addClass('active');
    } else if (mm == '12') {
        $("#ic_mes").val(12);
        fcRemoverClassActiveButton();
        $('#ic_dez').addClass('active');
    }

    if ($("#dia_ini_pk").val() != "") {
        primeiroDia = $("#dia_ini_pk").val() + "/" + $("#ic_mes").val() + "/" + $("#ds_ano").val();
    } else {
        primeiroDia = "01/" + $("#ic_mes").val() + "/" + $("#ds_ano").val();
    }

    if ($("#dia_fim_pk").val() != "") {
        ultimoDia = $("#dia_fim_pk").val() + "/" + $("#ic_mes").val() + "/" + $("#ds_ano").val();
    } else {
        ultimoDia = "31/" + $("#ic_mes").val() + "/" + $("#ds_ano").val();
    }
    fcCarregarExtrato();
}
function fcRemoverClassActiveButton() {
    $('#ic_jan').removeClass('active');
    $('#ic_fev').removeClass('active');
    $('#ic_mar').removeClass('active');
    $('#ic_abr').removeClass('active');
    $('#ic_mai').removeClass('active');
    $('#ic_jun').removeClass('active');
    $('#ic_jul').removeClass('active');
    $('#ic_ago').removeClass('active');
    $('#ic_set').removeClass('active');
    $('#ic_out').removeClass('active');
    $('#ic_nov').removeClass('active');
    $('#ic_dez').removeClass('active');
}

function fcCarregarComboEmpresas() {
    var objParametros = {

    };
    var arrCarregar = carregarController("conta_bancaria", "listarEmpresaContasAtivas", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#empresas_pk"), arrCarregar, "", "pk", "ds_conta");
}

function fcCarregarComboContas() {
    var objParametros = {
        "empresas_pk": $("#empresas_pk").val()
    };
    var arrCarregar = carregarController("conta_bancaria", "listarContasLancamento", objParametros);
    carregarComboAjax($("#contas_pk"), arrCarregar, "", "pk", "ds_dados_conta");
}

function fcCarregarExtrato() {

    var v_empresas_pk = $("#empresas_pk").val();
    var v_contas_bancarias_pk = $("#contas_pk").val();
    var v_ano = $("#ds_ano").val();
    var v_mes = $("#ic_mes").val();

    var objParametros = {
        "empresas_pk": v_empresas_pk,
        "contas_bancarias_pk": v_contas_bancarias_pk,
        "ds_mes": v_mes,
        "ds_ano": v_ano,
    };

    var arrCarregar = carregarController("lancamento", "listarExtratoMes", objParametros);
    //NewWindow(v_last_url)
    var vhtml = "";
    if (arrCarregar.result == 'success') {
        if (arrCarregar.data.length > 0) {

            vhtml += "<div class='overflow-auto' style='height:400px;overflow-y: scroll;' >";
            vhtml += "   <table id='tabela' class='table table-striped table-bordered ' style='width:100%' id='tblExtrato' >";
            vhtml += "       <thead>";
            vhtml += "           <tr>";
            vhtml += "               <th width='5' align='center'><font style='font-size: 15px'><b>#</b></font></th>";
            vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Cadastro</b></font></th>";
            vhtml += "               <th width='250' align='center'><font style='font-size: 15px'><b>Useário Cadastro</b></font></th>";
            vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Faturamento</b></font></th>";
            vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Vencimento</b></font></th>";
            vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Pagamento</b></font></th>";
            vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Tipo</b></font></th>";
            vhtml += "               <th align='center'><font style='font-size: 15px'><b>Tipo Operação</b></font></th>";
            vhtml += "               <th align='center'><font style='font-size: 15px'><b>Tipo Grupo</b></font></th>";
            vhtml += "               <th align='center'><font style='font-size: 15px'><b>Recebido de</b></font></th>";
            vhtml += "               <th align='center'><font style='font-size: 15px'><b>Metódo Pag.</b></font></th>";
            vhtml += "               <th align='center'><font style='font-size: 15px'><b>Vl Rec</b></font></th>";
            vhtml += "               <th align='center'><font style='font-size: 15px'><b>Vl Desp</b></font></th>";
            vhtml += "               <th align='center'><font style='font-size: 15px'><b>Vl Lançamento</b></font></th>";
            vhtml += "           </tr>";

            vhtml += "        </thead>";
            vhtml += "        <tbody>";
            var cont = 1;
            var vl_receita = "";
            var vl_despeda = "";
            var vl_total = "";

            vl_receita = arrCarregar.data[0]['vl_total_receita'];
            vl_despeda = arrCarregar.data[0]['vl_total_despesa'];
            vl_total = arrCarregar.data[0]['vl_total'];

            for (i = 0; i < arrCarregar.data[0].DadosExtrato.length; i++) {

                var v_dt_cadastro = "";
                var v_ds_usuario = "";
                var v_dt_faturamento = "";
                var v_dt_vencimento = "";
                var v_dt_pagamento = "";
                var v_ds_operacao = "";
                var v_ds_tipo_operacao = "";
                var v_ds_tipos_grupo = "";
                var v_recebido_pago_origem = "";
                var v_ds_metodo_pagamento = "";
                var v_vl_receita = "";
                var v_vl_despesa = "";
                var v_vl_lancamento = "";


                if (arrCarregar.data[0].DadosExtrato[i].dt_cadastro != null) {
                    v_dt_cadastro = arrCarregar.data[0].DadosExtrato[i].dt_cadastro;
                }

                if (arrCarregar.data[0].DadosExtrato[i].ds_usuario != null) {
                    v_ds_usuario = arrCarregar.data[0].DadosExtrato[i].ds_usuario;
                }

                if (arrCarregar.data[0].DadosExtrato[i].dt_faturamento != null) {
                    v_dt_faturamento = arrCarregar.data[0].DadosExtrato[i].dt_faturamento;
                }

                if (arrCarregar.data[0].DadosExtrato[i].dt_vencimento != null) {
                    v_dt_vencimento = arrCarregar.data[0].DadosExtrato[i].dt_vencimento;
                }

                if (arrCarregar.data[0].DadosExtrato[i].dt_pagamento != null) {
                    v_dt_pagamento = arrCarregar.data[0].DadosExtrato[i].dt_pagamento;
                }

                if (arrCarregar.data[0].DadosExtrato[i].ds_operacao != null) {
                    v_ds_operacao = arrCarregar.data[0].DadosExtrato[i].ds_operacao;
                }

                if (arrCarregar.data[0].DadosExtrato[i].ds_tipo_operacao != null) {
                    v_ds_tipo_operacao = arrCarregar.data[0].DadosExtrato[i].ds_tipo_operacao;
                }

                if (arrCarregar.data[0].DadosExtrato[i].ds_tipo_grupo != null) {
                    v_ds_tipos_grupo = arrCarregar.data[0].DadosExtrato[i].ds_tipo_grupo;
                }

                if (arrCarregar.data[0].DadosExtrato[i].ds_recebido_pago_origem != null) {
                    v_recebido_pago_origem = arrCarregar.data[0].DadosExtrato[i].ds_recebido_pago_origem;
                }

                if (arrCarregar.data[0].DadosExtrato[i].ds_metodo_pagamento != null) {
                    v_ds_metodo_pagamento = arrCarregar.data[0].DadosExtrato[i].ds_metodo_pagamento;
                }

                if (arrCarregar.data[0].DadosExtrato[i].vl_lancamento != null && arrCarregar.data[0].DadosExtrato[i].operacao_pk == 1) {
                    v_vl_receita = arrCarregar.data[0].DadosExtrato[i].vl_lancamento;
                }

                if (arrCarregar.data[0].DadosExtrato[i].vl_lancamento != null && arrCarregar.data[0].DadosExtrato[i].operacao_pk != 1) {
                    v_vl_despesa = arrCarregar.data[0].DadosExtrato[i].vl_lancamento;
                }

                if (arrCarregar.data[0].DadosExtrato[i].vl_lancamento != null) {
                    v_vl_lancamento = arrCarregar.data[0].DadosExtrato[i].vl_lancamento;
                }

                vhtml += "           <tr>";
                vhtml += "               <td width='100' align='center'>" + cont + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_dt_cadastro + "</td>";
                vhtml += "               <td width='250' align='center'>" + v_ds_usuario + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_dt_faturamento + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_dt_vencimento + "</td>";
                vhtml += "               <td width='100'align='center'>" + v_dt_pagamento + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_ds_operacao + "</td>";
                vhtml += "               <td width='100' align='center'>" + v_ds_tipo_operacao + "</td>";
                vhtml += "               <td width='100'align='center'>" + v_ds_tipos_grupo + "</td>";
                vhtml += "               <td align='center'>" + v_recebido_pago_origem + "</td>";
                vhtml += "               <td align='center'>" + v_ds_metodo_pagamento + "</td>";
                vhtml += "               <td align='center'><font color='blue'>" + v_vl_receita + "</font></td>";
                vhtml += "               <td align='center'><font color='red'>" + v_vl_despesa + "</font></td>";
                vhtml += "               <td align='center'>" + v_vl_lancamento + "</td>";
                vhtml += "           </tr>";
                cont++;
            }

            vhtml += "       </tbody>";

            vhtml += "       <tfoot>";
            vhtml += "           <tr>";
            vhtml += "               <td width='100' colspan=10 >&nbsp;</td>";
            vhtml += "               <td width='100' ><b>Totais R$<b/></td>";
            vhtml += "               <td align='center'><font color='blue'>" + vl_receita + "</font></td>";
            vhtml += "               <td align='center'><font color='red'>" + vl_despeda + "</font></td>";
            vhtml += "               <td align='center'><b>" + vl_total + "</b></td>";
            vhtml += "           </tr>";
            vhtml += "       </tfoot>";
            vhtml += "   </table>";
            vhtml += "</div>";

        }
    }

    $("#extrato").html(vhtml);
}




$(document).ready(function () {
    //Combo de Ano
    fcCarregarComboBox();

    $(document).on('click', '#ic_jan', function () {
        fcDatasCaleandario('1', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $(document).on('click', '#ic_fev', function () {
        fcDatasCaleandario('2', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $(document).on('click', '#ic_mar', function () {
        fcDatasCaleandario('3', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $(document).on('click', '#ic_abr', function () {
        fcDatasCaleandario('4', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $(document).on('click', '#ic_mai', function () {
        fcDatasCaleandario('5', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $(document).on('click', '#ic_jun', function () {
        fcDatasCaleandario('6', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $(document).on('click', '#ic_jul', function () {

        fcDatasCaleandario('7', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });

    });
    $(document).on('click', '#ic_ago', function () {
        fcDatasCaleandario('8', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $(document).on('click', '#ic_set', function () {
        fcDatasCaleandario('9', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $(document).on('click', '#ic_out', function () {
        fcDatasCaleandario('10', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $(document).on('click', '#ic_nov', function () {
        fcDatasCaleandario('11', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $(document).on('click', '#ic_dez', function () {
        fcDatasCaleandario('12', $("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });

    var today = new Date();

    var mm = today.getMonth() + 1;

    setTimeout(function () {

        if (mm == 1) {
            $("#ic_jan").trigger("click");
        }
        else if (mm == 2) {
            $("#ic_fev").trigger("click");
        }
        else if (mm == 3) {
            $("#ic_mar").trigger("click");
        }
        else if (mm == 4) {
            $('#ic_abr').trigger('click');
        }
        else if (mm == 5) {
            $("#ic_mai").trigger("click");
        }
        else if (mm == 6) {
            $("#ic_jun").trigger("click");
        }
        else if (mm == 7) {
            $("#ic_jul").trigger("click");
        }
        else if (mm == 8) {
            $("#ic_ago").trigger("click");
        }
        else if (mm == 9) {
            $("#ic_set").trigger("click");
        }
        else if (mm == 10) {
            $("#ic_out").trigger("click");
        }
        else if (mm == 11) {
            $("#ic_nov").trigger("click");
        }
        else if (mm == 12) {
            $("#ic_dez").trigger("click");
        }
    }, 500);

    //Combo de empresas
    fcCarregarComboEmpresas();
    //Combo de Contas
    fcCarregarComboContas();

    $("#empresas_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcCarregarComboContas();
        $(".chzn-select").chosen({ allow_single_deselect: true });
        fcCarregarExtrato();
    });

    $("#contas_pk").change(function () {
        fcCarregarExtrato();
    });

    $("#ds_ano").change(function () {
        fcCarregarExtrato();
    });


    var objParametros = {
        "ds_dominio_modulo": "exibir_extrato",
        "ic_acao": "upd"
    };

});


