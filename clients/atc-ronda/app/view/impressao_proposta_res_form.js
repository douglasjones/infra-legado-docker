function fcAbrirCarregarInfo() {

    var str = "";
    var objParametros = {
        "pk": proposta_pk
    };
    var arrCarregar = carregarController("proposta", "listarDadosImpressaoProposta", objParametros);

    $("#pk").text(arrCarregar.data[0]['t_pk']);
    $("#dt_proposta").text(arrCarregar.data[0]['t_dt_cad']);
    $("#dt_validade_proposta").text(arrCarregar.data[0]['t_dt_validade']);
    $("#dt_entrega").text(arrCarregar.data[0]['t_dt_envio']);
    $("#ds_lead").text(arrCarregar.data[0]['t_ds_lead']);
    $("#leads_pk").val(arrCarregar.data[0]['t_leads_pk']);
    $("#ds_cpf_cnpj").text(arrCarregar.data[0]['t_ds_cpf_cnpj']);
    $("#ds_endereco").text(arrCarregar.data[0]['t_ds_endereco']);
    $("#ds_cidade").text(arrCarregar.data[0]['t_ds_cidade']);
    $("#ds_cep").text(arrCarregar.data[0]['t_ds_cep']);
    $("#ds_uf").text(arrCarregar.data[0]['t_ds_uf']);
    $("#ds_tel").text(arrCarregar.data[0]['t_ds_tel']);
    $("#ds_email").text(arrCarregar.data[0]['t_ds_email']);
    $("#observacao").text(arrCarregar.data[0]['t_ds_obs']);
    $("#vl_total").text(arrCarregar.data[0]['t_vl_total']);    
}

function fcCarregarGridProdutos(){ 
    var objParametros = {
        "pk": proposta_pk
    };

    var arrCarregar = carregarController("proposta", "listarProdutosItens", objParametros);

    var strhtml = "";
    if(arrCarregar.data.length>0){
        strhtml += "<div class='row'>";
        strhtml += "    <div class='col-md-12'>";
        strhtml += "        <div align='left' style='background-color: #e2e2e2;border:solid 1px #CCCCCC;'>";
        strhtml += "           <b>PRODUTOS</b>";
        strhtml += "        </div>";
        strhtml += "        <table class='table nowrap' >";
        strhtml += "            <thead>";
        strhtml += "                <tr>";
        strhtml += "                    <th>ITEM</th>";
        strhtml += "                    <th>NOME</th>";
        strhtml += "                    <th>QTD.</th>";
        strhtml += "                    <th>VR. UNIT.</th>";
        strhtml += "                    <th>SUBTOTAL</th>";
        strhtml += "                </tr>";
        strhtml += "            </thead>";
        strhtml += "            <tbody>";
    
        if (arrCarregar.result == 'success') {
            for (i = 0; i < arrCarregar.data.length; i++) {
                strhtml += "			<tr>";
                strhtml += "  				<td>";
                strhtml += 						arrCarregar.data[i]['pk'];
                strhtml += "  				</td>";
                strhtml += "  				<td>";
                strhtml += 						arrCarregar.data[i]['ds_produto'];
                strhtml += "  				</td>"; 
                strhtml += "  				<td>";
                strhtml += 						arrCarregar.data[i]['n_qtde_item'];
                strhtml += "  				</td>";
                strhtml += "  				<td>";
                strhtml += 						arrCarregar.data[i]['vl_item_produto'];
                strhtml += "  				</td>";
                strhtml += "  				<td>";
                strhtml += 						arrCarregar.data[i]['vl_total_item'];
                strhtml += "  				</td>";
                strhtml += "			</tr>";
            }
        }  
        strhtml += "            </tbody>";
        strhtml += "            <tfoot>";
        strhtml += "                <tr>";
        strhtml += "  				    <td colspan='2' style='background-color: #e2e2e2;border:solid 1px #CCCCCC;'>";
        strhtml += "					   Total";
        strhtml += "  				    </td>";
        strhtml += "  				    <td style='background-color: #e2e2e2;border:solid 1px #CCCCCC;'>";
        strhtml += 					       arrCarregar.data[0]['qtde_total_itens'];
        strhtml += "  				    </td>";
        strhtml += "  				    <td colspan='2' align='right' style='background-color: #e2e2e2;border:solid 1px #CCCCCC;'>";
        strhtml += 					        arrCarregar.data[0]['vl_total_itens'];
        strhtml += "  				    </td>";
        strhtml += "                </tr>";
        strhtml += "            </tfoot>";
        strhtml += "        </table>";
        strhtml += "    </div>";
        strhtml += "</div>";
    }
   
  
    $("#grid_produtos").append(strhtml);
}

function fcCarregarGridServicos(){ 
    var objParametros = {
        "propostas_pk": proposta_pk
    };
    var arrCarregar = carregarController("proposta_item", "listarProdutosServicosProposta", objParametros);

    var strhtml = "";
    if(arrCarregar.data.length>0){
        strhtml += "<div class='row'>";
        strhtml += "    <div class='col-md-12'>";
        strhtml += "        <div align='left' style='background-color: #e2e2e2;border:solid 1px #CCCCCC;'>";
        strhtml += "           <b>SERVIÇOS</b>";
        strhtml += "        </div>";
        strhtml += "        <table class='table nowrap' >";
        strhtml += "            <thead>";
        strhtml += "                <tr>";
        strhtml += "                    <th>ITEM</th>";
        strhtml += "                    <th>NOME</th>";
        strhtml += "                    <th>QTD.</th>";
        strhtml += "                    <th>VR. UNIT.</th>";
        strhtml += "                    <th>SUBTOTAL</th>";
        strhtml += "                </tr>";
        strhtml += "            </thead>";
        strhtml += "            <tbody>";
        if (arrCarregar.result == 'success') {
            for (i = 0; i < arrCarregar.data.length; i++) {
                strhtml += "			<tr>";
                strhtml += "  				<td>";
                strhtml += 						arrCarregar.data[i]['pk'];
                strhtml += "  				</td>";
                strhtml += "  				<td>";
                strhtml += 						arrCarregar.data[i]['ds_produto_servico'];
                strhtml += "  				</td>"; 
                strhtml += "  				<td>";
                strhtml += 						arrCarregar.data[i]['n_qtde'];
                strhtml += "  				</td>";
                strhtml += "  				<td>";
                strhtml += 						arrCarregar.data[i]['vl_unit'];
                strhtml += "  				</td>";
                strhtml += "  				<td>";
                strhtml += 						arrCarregar.data[i]['vl_total'];
                strhtml += "  				</td>";
                strhtml += "			</tr>";
            }
        }
        strhtml += "            </tbody>";
        strhtml += "            <tfoot>";
        strhtml += "                <tr>";
        strhtml += "  				    <td colspan='2' style='background-color: #e2e2e2;border:solid 1px #CCCCCC;'>";
        strhtml += "					   Total";
        strhtml += "  				    </td>";
        strhtml += "  				    <td style='background-color: #e2e2e2;border:solid 1px #CCCCCC;'>";
        strhtml += 					       arrCarregar.data[0]['total_n_qtde'];
        strhtml += "  				    </td>";
        strhtml += "  				    <td colspan='2' align='right' style='background-color: #e2e2e2;border:solid 1px #CCCCCC;'>";
        strhtml += 					        arrCarregar.data[0]['total'];
        strhtml += "  				    </td>";
        strhtml += "                </tr>";
        strhtml += "            </tfoot>";
        strhtml += "        </table>";
        strhtml += "    </div>";
        strhtml += "</div>";
    }  
    
    $("#grid_servicos").append(strhtml);
}

function fcCarregarInfoCliente(){
    var objParametros = {
        "pk": ""
    };
    
    var arrCarregar = carregarController("conta", "listarContaPrincipal", objParametros);

    var ds_img_cliente = arrCarregar.data[0]['ds_img_cliente'];
    var ds_razao_social = arrCarregar.data[0]['ds_razao_social'];
    var ds_cpf_cnpj = arrCarregar.data[0]['ds_cpf_cnpj'];
    var ds_cel = arrCarregar.data[0]['ds_cel'];
    var ds_tel = arrCarregar.data[0]['ds_tel'];
    var ds_email = arrCarregar.data[0]['ds_email'];
    var ds_endereco = arrCarregar.data[0]['ds_endereco'];
    var ds_numero = arrCarregar.data[0]['ds_numero'];
    var ds_bairro = arrCarregar.data[0]['ds_bairro'];
    var ds_cidade = arrCarregar.data[0]['ds_cidade'];
    var ds_uf = arrCarregar.data[0]['ds_uf'];
    var ds_cep = arrCarregar.data[0]['ds_cep'];
    var html = "";
    
    html += "        <table>";
            if(ds_img_cliente != "" && ds_img_cliente != null){
                html += "    <td> &nbsp;<img width='70' src='"+ds_img_cliente+"'>  </td>";
            }
            html += "        <tr>";
            if(ds_razao_social != "" && ds_razao_social != null){
                html += "            <td><b>"+ds_razao_social+"</b></td>";
            }
            html += "        </tr>";
            html += "        <tr>";
            
            if(ds_cpf_cnpj != "" && ds_cpf_cnpj != null){
                html += "            <td> CNPJ:"+ds_cpf_cnpj+"</td>";
            }
            
            if(ds_tel != "" && ds_tel != null){
                html += "            <td> "+ds_tel;
            }else{
                html += "            <td> ";
            }

            if(ds_cel != "" && ds_cel != null){
                html +=                 "-"+ds_cel+"</td>"
            }else{
                html +=         "</td>"
            }

            html += "        </tr>";
            html += "        <tr>";
            if(ds_endereco != "" && ds_endereco != null){
                html += "            <td>"+ds_endereco;
            }else{
                html += "            <td>";
            }
            if(ds_numero != "" && ds_numero != null){
                html +=     ","+ds_numero+" ";
            }
            if(ds_bairro != "" && ds_bairro != null){
                html +=             ds_bairro+"</td>";
            }else{
                html +=         "</td>"
            }
            if(ds_email != "" && ds_email != null){
                html += "            <td>"+ds_email+"</td>";
            }
            html += "        </tr>";
            html += "        <tr>";
            if(ds_endereco != "" && ds_endereco != null){
                html += "            <td>"+ds_cidade;
            }else{
                html += "            <td>";
            }
            if(ds_numero != "" && ds_numero != null){
                html += "            /"+ds_uf
            }
            if(ds_bairro != "" && ds_bairro != null){
                html +=           "-CEP:"+ds_cep+"</td>";
            }else{
                html +=         "</td>"
            }
            html += "        </tr>";
	html += "        </table>";
	

    $("#ds_info_cliente").append(html);
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
    var leads_pk = $("#leads_pk").val()
    sendPost('processo_cad_form.php', {token: token, leads_pk: leads_pk, pk: processos_pk, processos_default_pk: processos_default_pk});
}

function fcImprimir() {
    window.print();
}

$(document).ready(function () {
    $("#loader").hide();
    $("#exibir").show();
    fcAbrirCarregarInfo();
    fcCarregarGridProdutos();

    fcCarregarGridServicos();
    fcCarregarInfoCliente();

    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImprimir', fcImprimir);
    setTimeout(function () {
        //fcImprimir();
    }, 300);



});