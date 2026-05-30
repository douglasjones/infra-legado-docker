<?php
// Função que busca o cep e retorna array
function busca_cep($cep){   
	//$resultado = file_get_contents('http://www.buscarcep.com.br/?cep='.urlencode($cep).'&formato=string');
	$resultado = file_get_contents('http://cep.gepros1.com.br/buscacep.php?cep='.$cep.'&formato=string');
	//$resultado = file_get_contents('http://localhost:8080/cep/buscacep.php?cep='.$cep.'&formato=string');
	if(empty($resultado)){
		$resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
		echo "<script>\n alert(\"Web service de busca de CEP temporariamente indisponível!\"); \n</script>";
	}
	parse_str($resultado, $retorno);
	return $retorno;
}

?>