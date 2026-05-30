function fcCarregarComboBox() {
    var today = new Date();
    var year = today.getFullYear();
    var ano = year;
    var selecionado = "selected";
    var combo = "";

    combo += "<select id='ds_ano' class='btn btn-primary'>";

    combo += "   <option>2020</option>";
    combo += "   <option>2021</option>";
    combo += "   <option>2022</option>";
    if(year=="2023"){
        combo += "   <option selected>2023</option>";
    }else{
        combo += "   <option >2023</option>";
    }
    if(year=="2024"){
        combo += "   <option selected>2024</option>";
    }else{
        combo += "   <option >2024</option>";
    }
    if(year=="2025"){
        combo += "   <option selected>2025</option>";
    }else{
        combo += "   <option >2025</option>";
    }
    if(year=="2026"){
        combo += "   <option selected>2026</option>";
    }else{
        combo += "   <option >2026</option>";
    }
    if(year=="2027"){
        combo += "   <option selected>2027</option>";
    }else{
        combo += "   <option >2027</option>";
    }
    if(year=="2028"){
        combo += "   <option selected>2028</option>";
    }else{
        combo += "   <option >2028</option>";
    }
    if(year=="2029"){
        combo += "   <option selected>2029</option>";
    }else{
        combo += "   <option >2029</option>";
    }
    if(year=="2090"){
        combo += "   <option selected>2030</option>";
    }else{
        combo += "   <option >2030</option>";
    }





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

    try{
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
        var vhtml = "";
        if (arrCarregar.result == 'success') {
            if (arrCarregar.data.length > 0) {
    
                vhtml += "<div style='height:400px;overflow-y: scroll;' >";
                vhtml += "   <table id='tabela' class='table table-striped table-bordered ' style='width:150%;' id='tblExtrato' >";
                vhtml += "       <thead>";
                vhtml += "           <tr style='position: sticky; top: 0px; background-color: white;'>";
                vhtml += "               <th width='5' align='center'><font style='font-size: 15px'><b>#</b></font></th>";
                vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Identificação do Lançamento</b></font></th>";
                vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Cadastro</b></font></th>";
                vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Usuário de Cadastro</b></font></th>";
                vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Faturamento</b></font></th>";
                vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Vencimento</b></font></th>";
                vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Dt Pagamento</b></font></th>";
                vhtml += "               <th width='100' align='center'><font style='font-size: 15px'><b>Tipo</b></font></th>";
                vhtml += "               <th align='center'><font style='font-size: 15px'><b>Tipo Operação</b></font></th>";
                vhtml += "               <th align='center'><font style='font-size: 15px'><b>Grupo do Lançamento</b></font></th>";
                vhtml += "               <th align='center'><font style='font-size: 15px'><b>Recebido de / Pago Para</b></font></th>";
                vhtml += "               <th align='center'><font style='font-size: 15px'><b>Metódo Pag.</b></font></th>";
                vhtml += "               <th align='center'><font style='font-size: 15px'><b>Vl Receita</b></font></th>";
                vhtml += "               <th align='center'><font style='font-size: 15px'><b>Vl Despesa</b></font></th>";
                vhtml += "               <th align='center'><font style='font-size: 15px'><b>Vl Saldo</b></font></th>";
    
                vhtml += "               <th align='center' width='100'><font style='font-size: 15px'><b>Ação</b></font></th>";
                vhtml += "           </tr>";
    
                vhtml += "        </thead>";
                vhtml += "        <tbody>";
                var cont = 1;
                var vl_receita = "";
                var vl_despeda = "";
                var vl_total = "";
                var vl_saldo_mes = "";
    
                vl_receita = arrCarregar.data[0]['vl_total_receita'];
                vl_despeda = arrCarregar.data[0]['vl_total_despesa'];
                vl_total = arrCarregar.data[0]['vl_total'];
                vl_total_saldo_mes = arrCarregar.data[0]['vl_total_saldo_mes'];
                vl_saldo_mes_anterior = arrCarregar.data[0]['vl_saldo_mes_anterior'];
                vl_saldo_atual = arrCarregar.data[0]['vl_saldo_atual'];
                
                    for (i = 0; i < arrCarregar.data[0].DadosExtrato.length; i++) {
                        var v_pk = "";
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
                        var v_ic_status_pagamento = "";

                        v_pk = arrCarregar.data[0].DadosExtrato[i].pk;
                        v_proximo_dt_vencimento = arrCarregar.data[0].DadosExtrato[i].proxima_data;

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

                        if (arrCarregar.data[0].DadosExtrato[i].ic_status_pagamento != null) {
                            v_ic_status_pagamento = arrCarregar.data[0].DadosExtrato[i].ic_status_pagamento;
                        }

                        if (arrCarregar.data[0].DadosExtrato[i].total_dia == null) {
                            total_dia = "";
                        }else{
                            total_dia = arrCarregar.data[0].DadosExtrato[i].total_dia
                        }

                        if (arrCarregar.data[0].DadosExtrato[i].receita_dia == null) {
                            receita_dia = "";
                        }else{
                            receita_dia = arrCarregar.data[0].DadosExtrato[i].receita_dia;
                        }

                        if (arrCarregar.data[0].DadosExtrato[i].despesa_dia == null) {
                            despesa_dia = "";
                        }else{
                            despesa_dia = arrCarregar.data[0].DadosExtrato[i].despesa_dia;
                        }

                        if (arrCarregar.data[0].DadosExtrato[i].vl_total_saldo_dia == null) {
                            vl_total_saldo_dia = "";
                        }else{
                            vl_total_saldo_dia = arrCarregar.data[0].DadosExtrato[i].vl_total_saldo_dia;
                        }
                        
                        if (arrCarregar.data[0].DadosExtrato[i].ds_lancamento == null) {
                            ds_lancamento = "";
                        }else{
                            ds_lancamento = arrCarregar.data[0].DadosExtrato[i].ds_lancamento;
                        }
                            
                        vhtml += "           <tr>";
                        vhtml += "               <td width='100' align='center'>" + cont + "</td>";
                        vhtml += "               <td width='100' align='center'>" + ds_lancamento + "</td>";
                        vhtml += "               <td width='100' align='center'>" + v_dt_cadastro + "</td>";
                        vhtml += "               <td width='100' align='center'>" + v_ds_usuario + "</td>";
                        vhtml += "               <td width='100' align='center'>" + v_dt_faturamento + "</td>";
                        vhtml += "               <td width='100' align='center'>" + v_dt_vencimento + "</td>";
                        vhtml += "               <td width='100' align='center'>" + v_dt_pagamento + "</td>";
                        vhtml += "               <td width='100' align='center'>" + v_ds_operacao + "</td>";
                        vhtml += "               <td width='100' align='center'>" + v_ds_tipo_operacao + "</td>";
                        vhtml += "               <td width='100' align='center'>" + v_ds_tipos_grupo + "</td>";
                        vhtml += "               <td align='center'>" + v_recebido_pago_origem + "</td>";
                        vhtml += "               <td align='center'>" + v_ds_metodo_pagamento + "</td>";
                        vhtml += "               <td align='center'><font color='blue'>" + v_vl_receita + "</font></td>";
                        vhtml += "               <td align='center'><font color='red'>" + v_vl_despesa + "</font></td>";
                        vhtml += "               <td align='center'> &nbsp; </td>";  
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
                        vhtml += "                              <i style='font-size: 15px;' id='cmdExcluir' class='bi bi-x-circle' title='Excluir Lançamento' onclick='fcExcluirLancamento(" + v_pk + "," + v_ic_status_pagamento + ")'></i>";
                        vhtml += "                          </td>";
                        vhtml += "                      </tr>";
                        vhtml += "                  </table>";
                        vhtml += "                </td>";
                        if(v_dt_vencimento != v_proximo_dt_vencimento || v_proximo_dt_vencimento == ""){
                            vhtml += "           <tr style='background-color: ffffdd;'>";
                            vhtml += "               <td align='right' width='100' colspan=11 >&nbsp;<b>Saldo do dia "+ v_dt_vencimento +"</b></td>";
                            vhtml += "               <td width='100' ><b>Totais R$<b/></td>";
                            vhtml += "               <td align='center'><font color='blue'>" + receita_dia; + "</font></td>";
                            vhtml += "               <td align='center'><font color='red'>" + despesa_dia; + "</font></td>";
                            vhtml += "               <td align='center'>" + vl_total_saldo_dia; + "</td>";
                            vhtml += "               <td align='center'>&nbsp; </td>";
                            vhtml += "           </tr>";
                        }
                        
                        cont++;
                    }
                    vhtml += "       </tbody>";
                    vhtml += "       <tfoot style='position: sticky; bottom: 0px; background-color: white;'>";
                    vhtml += "           <tr>";
                    vhtml += "               <td width='100' colspan=11 >&nbsp;</td>";
                    vhtml += "               <td width='100' ><b>Totais R$<b/></td>";
                    vhtml += "               <td align='center'><font color='blue'>" + vl_receita + "</font></td>";
                    vhtml += "               <td align='center'><font color='red'>" + vl_despeda + "</font></td>";
                    vhtml += "               <td align='center'>" + vl_total_saldo_mes + "</td>";
                    vhtml += "               <td align='center'>&nbsp; </td>";
                    vhtml += "           </tr>";
                    vhtml += "           <tr>";
                    vhtml += "               <td align='right' width='100' colspan=11 >&nbsp;<b>Saldo mês Anterior R$<b/></td>";
                    vhtml += "               <td width='100' ></td>";
                    vhtml += "               <td align='center'><font color='blue'> </font></td>";
                    vhtml += "               <td align='center'><font color='red'> </font></td>";
                    vhtml += "               <td align='center'>" + vl_saldo_mes_anterior + "</td>";
                    vhtml += "               <td align='center'>&nbsp; </td>";
                    vhtml += "           </tr>";
                    vhtml += "           <tr>";
                    vhtml += "               <td align='right' width='100' colspan=11 >&nbsp;<b>Saldo do mês Atual R$<b/></td>";
                    vhtml += "               <td width='100' ></td>";
                    vhtml += "               <td align='center'><font color='blue'> </font></td>";
                    vhtml += "               <td align='center'><font color='red'> </font></td>";
                    vhtml += "               <td align='center'>" + vl_saldo_atual + "</td>";
                    vhtml += "               <td align='center'>&nbsp; </td>";
                    vhtml += "           </tr>";
                    vhtml += "       </tfoot>";
                    vhtml += "   </table>";
                    vhtml += "</div>";
                
            }
        }
    
        $("#extrato").html(vhtml);
    }catch(e){
        alert(e)
    }

    
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


