<?php
require "./ajax/xajax_core/xajax.inc.php"; // XAJAX
require "./funBuscarCep.php"; // Função que faz a busca do cep

$ajax = new xajax();
$ajax->registerFunction("buscaCep");

##################################### BUSCA CEP #####################################
function buscaCep($cep, $endereco, $bairro, $cidade, $estado){
	
	//Instancia o objeto XAJAX response
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	if(empty($cep)){
		return $objResponse;
	}

	$cep = str_replace("-", "", $cep);

	$resultado_busca = busca_cep($cep); // Retorna um array
	
	// Coloca os valores dos arrays nos campos do formulário
	$objResponse->assign($endereco, "value", $resultado_busca['tipo_logradouro']." ".$resultado_busca['logradouro']);
	$objResponse->assign($bairro, "value", $resultado_busca['bairro']);
	$objResponse->assign($cidade, "value", $resultado_busca['cidade']);
	$objResponse->assign($estado, "value", $resultado_busca['uf']);

	// Retorna a resposta de XML gerada pelo objeto do xajaxResponse
	return $objResponse;
}

// Manda o ajax processar os pedidos acima
$ajax->processRequest();

$ajax->printJavascript('./ajax/');
?>

<form id="form" name="form" method="post" action="">
  <table width="92%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td width="24%" align="right">&nbsp;</td>
      <td width="76%" align="left" class="txt_maior"><strong>Dados de Endere&ccedil;o</strong></td>
    </tr>
    <tr>
      <td align="right">CEP:</td>
      <td align="left"><input name="cep" type="text" class="forms" id="cep" size="11" maxlength="9" onkeyup="if(this.value.length == 9) xajax_buscaCep(this.value, 'endereco', 'bairro', 'cidade', 'estado');" onblur="xajax_buscaCep(this.value, 'endereco', 'bairro', 'cidade', 'estado');"/></td>
    </tr>
    <tr>
      <td align="right">Logradouro:</td>
      <td align="left"><input name="endereco" type="text" class="forms" id="endereco" size="35" maxlength="75" /></td>
    </tr>
    <tr>
      <td align="right">N&uacute;mero:</td>
      <td align="left"><input name="numero" type="text" class="forms" id="numero" size="8" maxlength="6" /></td>
    </tr>
    <tr>
      <td align="right">Complemento:</td>
      <td align="left"><input name="complemento" type="text" class="forms" id="complemento" size="35" maxlength="75" /></td>
    </tr>
    <tr>
      <td align="right">Bairro:</td>
      <td align="left"><input name="bairro" type="text" class="forms" id="bairro" size="35" maxlength="75" /></td>
    </tr>
    <tr>
      <td align="right">Cidade:</td>
      <td align="left"><input name="cidade" type="text" class="forms" id="cidade" size="35" maxlength="75" /></td>
    </tr>
    <tr>
      <td align="right">Estado:</td>
      <td align="left"><select name="estado" id="estado" class="forms">
          <option value="">Selecione um Estado</option>
          <option value="AC">Acre</option>
          <option value="AL">Alagoas</option>
          <option value="AP">Amap&aacute;</option>
          <option value="AM">Amazonas</option>
          <option value="BA">Bahia</option>
          <option value="CE">Cear&aacute;</option>
          <option value="DF">Distrito Federal</option>
          <option value="ES">Esp&iacute;rito Santo</option>
          <option value="GO">Goi&aacute;s</option>
          <option value="MA">Maranh&atilde;o</option>
          <option value="MT">Mato Grosso</option>
          <option value="MS">Mato Grosso do Sul</option>
          <option value="MG">Minas Gerais</option>
          <option value="PA">Par&aacute;</option>
          <option value="PB">Para&iacute;ba</option>
          <option value="PR">Paran&aacute;</option>
          <option value="PE">Pernambuco</option>
          <option value="PI">Piau&iacute;</option>
          <option value="RJ">Rio de Janeiro</option>
          <option value="RN">Rio Grande do Norte</option>
          <option value="RS">Rio Grande do Sul</option>
          <option value="RO">Rond&ocirc;nia</option>
          <option value="RR">Roraima</option>
          <option value="SC">Santa Catarina</option>
          <option value="SP">S&atilde;o Paulo</option>
          <option value="SE">Sergipe</option>
          <option value="TO">Tocantins</option>
        </select></td>
    </tr>
  </table>
</form>
