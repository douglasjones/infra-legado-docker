function fcAbrirModal(pk) {
    var str = "";
    $("#grid").empty();

    var objParametros = {
        "pk": pk
    };
    var arrCarregar = carregarController("lancamento", "listarDadosImpressao", objParametros);
    //NewWindow(v_last_url)
    if (arrCarregar.result == 'success') {

        //str +="<page size='A4'>";
        str += "";
        str += "<div class='row'>";
        str += "            <div class='col-md-12'>";
        str += "                <h5><b>Dados de Indentificação do Lançamento</b></h5>";
        str += "                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>";
        str += "            </div>";
        str += "        </div>       ";

        str += "        <div class='row'>   ";
        str += "            <div class='col-md-4'>";
        str += "                <label for='tipos_operacao_pk'><b>Cód Lançamento:</b></label>";
        str += " <br>" + pk + "";
        str += "            </div>";
        str += "        </div>   ";
        str += "        <br>   ";

        str += "        <div class='row'>   ";
        str += "            <div class='col-md-4'>";
        str += "                <label for='tipos_operacao_pk'><b>Tipo Lançamento:</b></label>";
        str += " <br>" + arrCarregar.data[0]['t_ds_operacao'] + "";
        str += "            </div>";
        str += "            <div class='col-md-8'>";
        str += "                <label for='tipos_operacao_pk'><b>Tipo Operação / Planos Conta:</b>&nbsp;</label>";
        str += " <br>" + arrCarregar.data[0]['t_ds_tipo_operacao'] + "";
        str += "            </div>";
        str += "        </div>   ";
        str += "        <br>   ";

        str += "        <div class='row'>   ";
        str += "            <div class='col-md-4'>";
        str += "                <label for='tipos_operacao_pk'><b>Empresa para o lançamento:</b>&nbsp;</label>";
        str += " <br>" + arrCarregar.data[0]['t_ds_razao_social'] + "";
        str += "            </div>      ";
        str += "           <div class='col-md-6'>";
        str += "                <label for='contas_pk'><b>Conta do Bancária:</b>&nbsp;</label>";
        if (arrCarregar.data[0]['t_ds_dados_conta'] != null) {
            str += " <br>" + arrCarregar.data[0]['t_ds_dados_conta'] + "";
        }
        str += "            </div>";
        str += "        </div>        ";
        str += "        <br>   ";
        str += "        <div class='row'>";
        str += "            <div class='col-md-10'>";
        str += "                <label for='ds_lancamento'><b>Identificação do Lançamento:</b>&nbsp;</label>";
        str += " <br>" + arrCarregar.data[0]['t_ds_lancamento'] + "";
        str += "            </div>";
        str += "        </div>     ";
        str += "        <br>   ";
        str += "        <div class='row'>";
        str += "            <div class='col-md-4'>";
        str += "                <label for='tipo_grupo_pk'><b>Grupo Origem do Lançamento:</b>&nbsp;</label>";
        str += " <br>" + arrCarregar.data[0]['t_ds_tipo_grupo'] + "";
        str += "            </div>";
        str += "            <div class='col-md-4'>";
        str += "                <label for='vl_lancamento' ><b>Recebido de ? / Pago de ?</b>&nbsp;</label>";
        str += " <br>" + arrCarregar.data[0]['t_ds_recebido_de'] + "";
        str += "            </div>";
        str += "        </div> ";
        str += "        <br>";

        if (arrCarregar.data[0]['ds_agencia'] != null) {


            str += "        <div class='row'>";
            str += "            <div class='col-md-3'>";
            str += "                <label for='ds_lancamento'><b>Banco</b>&nbsp;</label>";
            if (arrCarregar.data[0]['ds_banco'] != null) {
                str += " <br>" + arrCarregar.data[0]['ds_banco'];
            }
            else {
                str += "";
            }
            str += " </div>";
            str += "            <div class='col-md-3'>";
            str += "                <label for='ds_lancamento'><b>Agência</b>&nbsp;</label>";
            if (arrCarregar.data[0]['ds_agencia'] != null) {
                str += " <br>" + arrCarregar.data[0]['ds_agencia'];
            }
            else {
                str += "";
            }
            str += "  </div>";
            str += "            <div class='col-md-3'>";
            str += "              <label for='ds_lancamento'><b>Conta</b>&nbsp;</label>";
            if (arrCarregar.data[0]['ds_conta'] != null) {
                str += " <br>" + arrCarregar.data[0]['ds_conta'] + " - " + arrCarregar.data[0]['ds_digito'];
            }
            else {
                str += "";
            }
            str += " </div>";
            str += " </div>";

        }

        str += "        <br> ";
        str += "        <div class='row'>";
        str += "            <div class='col-md-4'>";
        str += "                <label for='tipo_grupo_pk'><b>Data Pagamento:</b>&nbsp;</label>";
        if (arrCarregar.data[0]['t_dt_pagamento'] != null) {
            str += " <br>" + arrCarregar.data[0]['t_dt_pagamento'] + "";
        }

        str += "            </div>";
        str += "        </div> ";
        str += "        <br> ";

        str += "        <div class='row'>";
        str += "            <div class='col-md-12'>";
        str += "                <h5><b>Centro de Custo</b></h5>";
        str += "                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>";
        str += "            </div>";
        str += "        </div>      ";
        str += "        <br>   ";
        str += "        <div class='row'>";
        str += "            <div class='col-md-4'>";
        str += "                <label for='tipo_grupo_pk'><b>Grupos Centro de Custo:</b>&nbsp;</label>";
        if (arrCarregar.data[0]['t_ds_tipo_grupo_centro_custo'] != null) {
            str += " <br>" + arrCarregar.data[0]['t_ds_tipo_grupo_centro_custo'] + "";
        }

        str += "            </div>";
        str += "            <div class='col-md-4'>";
        str += "                <label for='vl_lancamento'><b>Centro de Custo:</b>&nbsp;</label>";
        if (arrCarregar.data[0]['t_ds_recebido_de_centro_custo'] != null) {
            str += " <br>" + arrCarregar.data[0]['t_ds_recebido_de_centro_custo'] + "";
        }

        str += "            </div>";
        str += "        </div>";

        str += "        <br>";

        str += "        <div class='row'>";
        str += "            <div class='col-md-12'>";
        str += "                <h5><b>Dados de Valor e Data do Lançamento / Status</b></h5>";
        str += "                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>";
        str += "            </div>";
        str += "        </div>          ";
        str += "        <br>   ";
        str += "        <div class='row'>";
        str += "            <div class='col-md-4'>";
        str += "                <label for='vl_lancamento'><b>Valor do Lançamento:</b>&nbsp;</label>";
        if (arrCarregar.data[0]['t_ds_recebido_de_centro_custo'] != null) {
            str += " <br>R$: " + float2moeda(arrCarregar.data[0]['t_vl_lancamento']) + "";
        }
        str += "            </div>";
        str += "            <div class='col-md-4'>";
        str += "                <label for='vl_lancamento' class='metodo_recebimento_pagamento'><b>Método de Recebimento</b></label>";
        if (arrCarregar.data[0]['t_ds_metodo_pagamento'] != null) {
            str += " <br> " + (arrCarregar.data[0]['t_ds_metodo_pagamento']) + "";
        }
        str += "            </div>";
        str += "        </div>";
        str += "        <br>   ";
        str += "        <div class='row'>";
        str += "            <div class='col-md-4'>";
        str += "                <label for='vl_lancamento' class='tipo_data_lancamento'><b>Dt Vencimento / Recebimento:</b>&nbsp;</label>";
        if (arrCarregar.data[0]['t_dt_vencimento'] != null) {
            str += " <br> " + (arrCarregar.data[0]['t_dt_vencimento']) + "";
        }
        str += "            </div>";
        str += "            <div class='col-md-5'>";
        str += "                <label for='dt_competencia'><b>Data de Competência / Referência:</b>&nbsp;</label>";
        if (arrCarregar.data[0]['t_dt_competencia'] != null) {
            str += " <br> " + (arrCarregar.data[0]['t_dt_competencia']) + "";
        }
        str += "            </div>";
        str += "        </div>";

        str += "        <br>   ";
        str += "        <div class='row'>";
        str += "            <div class='col-md-4'>";
        str += "                <label for='tipos_operacao_pk'><b>Status:</b>&nbsp;</label>";
        if (arrCarregar.data[0]['t_ds_status_pagamento'] != null) {
            str += " <br> " + (arrCarregar.data[0]['t_ds_status_pagamento']) + "";
        }
        str += "            </div>";
        str += "        </div>        ";

        str += "        <div class='row'>";
        str += "            <div class='col-md-10'>";
        str += "                <label for='dt_competencia'><b>Observação:</b>&nbsp;</label>";
        if (arrCarregar.data[0]['t_n_documento'] != null) {
            str += " <br> " + (arrCarregar.data[0]['t_n_documento']) + "";
        }
        str += "            </div>";
        str += "        </div> ";
        str += "    </div>";


        //str +="</page>";  
        //str +="<div style='page-break-after:always'></div>";  

    }

    $("#grid").append(str);
    $("#janela_impressao").modal();

}

function printElement(elem) {
    var domClone = elem.cloneNode(true);

    var $printSection = document.getElementById("printSection");

    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }

    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
function fcVoltar() {
    sendPost('financerio_contas_pagar_res_form.php', { token: token });
}
function fcImprimir() {
    window.print();

}
$(document).ready(function () {
    fcAbrirModal(pk);
    $("#loader").hide();
    $("#exibir").show();


    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImprimir', fcImprimir);
    setTimeout(function () {
        //fcImprimir();
    }, 300);



});