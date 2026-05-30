function fcAbrirCarregarInfo(compra_solicitacao_pk, compras_solicitacao_orcamentos_pk) {
    $("#grid").empty();
    var str = "";
    var objParametros = {
        "pk": compras_solicitacao_orcamentos_pk,
        "compra_solicitacao_pk": compra_solicitacao_pk
    };
    var arrCarregar = carregarController("compras_solicitacao_orcamentos", "listarDadosImpressao", objParametros);
    if (arrCarregar.result == 'success') {
        str += "    <div class='row'>";
        str += "        <div class='col-md-12'>";
        str += "           <h5><b>Dados de Indentificação do Solicitação Compra</b></h5>";
        str += "           <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 5px;'>";
        str += "        </div>";
        str += "    </div>";
        str += "    <div class='row'>";
        str += "        <div class='col-md-4'>";
        str += "            <label for='tipos_operacao_pk'><b>Cód Solicitação:</b></label>";
        str += "            <br>" + arrCarregar.data[0]['t_compras_solicitacao_orcamentos_pk'];
        str += "        </div>";
        str += "        <div class='col-md-4'>";
        str += "            <label for='tipos_operacao_pk'><b>Solicitante:</b></label>";
        str += "            <br>" + arrCarregar.data[0]['t_ds_solicitante'];
        str += "        </div>";
        str += "        <div class='col-md-4'>";
        str += "            <label for='tipos_operacao_pk'><b>Empresa:</b></label>";
        str += "            <br>" + arrCarregar.data[0]['t_ds_empresa'];
        str += "        </div>";
        str += "    </div>";
        str += "    <br>";
        str += "    <div class='row'>";
        str += "        <div class='col-md-4'>";
        str += "            <label for='tipos_operacao_pk'><b>Solicitacao:</b></label>";
        str += "            <br>" + arrCarregar.data[0]['t_ds_compra_solicitacao'];
        str += "        </div>";
        str += "        <div class='col-md-4'>";
        str += "            <label for='tipos_operacao_pk'><b>Valor Frete:</b></label>";
        str += "            <br>" + arrCarregar.data[0]['t_vl_frete'];
        str += "        </div>";
        str += "       <div class='col-md-4'>";
        str += "            <label for='tipos_operacao_pk'><b>Valor Total:</b></label>";
        str += "            <br>" + arrCarregar.data[0]['t_vl_total'];
        str += "        </div>";
        str += "    </div>";
        str += "    <br>";
        str += "    <div class='row'>";
        str += "        <div class='col-md-4'>";
        str += "            <label for='tipos_operacao_pk'><b>Fornecedor:</b></label>";
        if(arrCarregar.data[0]['t_ds_fornecedor'] != null){
            str += "            <br>" + arrCarregar.data[0]['t_ds_fornecedor'];
        }
        str += "        </div>";
        str += "        <div class='col-md-4'>";
        str += "            <label for='tipos_operacao_pk'><b>Dt. Previsão Entrega:</b></label>";
        str += "            <br>" + arrCarregar.data[0]['t_dt_pevisao_entrega'];
        str += "        </div>";
        str += "        <div class='col-md-4'>";
        str += "            <label for='tipos_operacao_pk'><b>Status:</b></label>";
        str += "            <br>" + arrCarregar.data[0]['t_ds_status'];
        str += "        </div>";
        str += "    </div>";
        str += "    <br>";
        str += "    <div class='row'>";
        str += "        <div class='col-md-4'>";
        str += "            <label for='tipos_operacao_pk'><b>Dt Solicitação:</b></label>";
        str += "            <br>" + arrCarregar.data[0]['t_dt_solicitacao'];
        str += "        </div>";
        str += "    </div>";
        str += "    <br>";
        str += "    &nbsp;<h6><b>Itens Solicitação compra</b></h6>";
        str += "    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 5px;'>";
        for(var i=0; i < arrCarregar.data.length; i++){
            str += "    <div class='row'>";
            str += "        <div class='col-md-4'>";
            str += "            <label for='tipos_operacao_pk'><b>Produto:</b></label>";
            str += "            <br>" + arrCarregar.data[i]['t_ds_produto'] +"<br>";
            str += "        </div>";
            str += "    </div>";
            str += "    <br>";
            str += "    <div class='row'>";
            str += "        <div class='col-md-4'>";
            str += "            <label for='tipos_operacao_pk'><b>Valor Unitário:</b></label>";
            str += "            <br>" + arrCarregar.data[i]['t_vl_unitario'];
            str += "        </div>";
            str += "        <div class='col-md-4'>";
            str += "            <label for='tipos_operacao_pk'><b>Quantidade:</b></label>";
            str += "            <br>" + arrCarregar.data[i]['t_qtde_produto'];
            str += "        </div>";
            str += "        <div class='col-md-4'>";
            str += "            <label for='tipos_operacao_pk'><b>Categoria:</b></label>";
            str += "            <br>" + arrCarregar.data[i]['t_ds_categoria_produto'];
            str += "        </div>";
            str += "    </div>";
            str += "    <hr>";
        }
    }

    $("#grid").append(str);
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
    sendPost('compras_solicitacao_cad_form.php', {token: token, compra_solicitacao_pk: compra_solicitacao_pk});
}

function fcImprimir() {
    window.print();
}

$(document).ready(function () {
    $("#loader").hide();
    $("#exibir").show();

    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImprimir', fcImprimir);
    fcAbrirCarregarInfo(compra_solicitacao_pk, compras_solicitacao_orcamentos_pk);
    setTimeout(function () {
        //fcImprimir();
    }, 300);



});