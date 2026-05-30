<?

//include_once "maininclude.php";

function naoperturbe($telefone){
	
	$resultado = file_get_contents("http://naoperturbe.gepros1.com.br/naoperturbe.php?telefone=$telefone");
	parse_str($resultado, $retorno);
	return $retorno;
	
}

?>
