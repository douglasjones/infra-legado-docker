<?

include_once "../../libs/maininclude.php";
include_once "produtos_cla.php";

$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
$ds_produto = $_REQUEST['ds_produto'];
$vl_produtor = $_REQUEST['vl_produtor'];
$operador_pk = $_REQUEST['operador_pk'];
$dt_cancelamento = $_REQUEST['dt_cancelamento'];

if ($acao == "gravar"){
	
	$produtos = new produtos(0);
	$produtos->setpk($pk);
	$produtos->setds_produto ($ds_produto);
	$produtos->setvl_produtor ($vl_produtor);
	$produtos->setoperador_pk ($operador_pk);
	$produtos->setdt_cancelamento($dt_cancelamento);

	$produtos->salvar();
	
	javascriptalert('Operação executada com sucesso!!!');
}

if($acao == "excluir"){
	$produtos= new produtos($pk);
	$produtos->excluir();
	javascriptalert('Operação executada com sucesso!!!');
}

include_once "../../libs/desconectar.php";

?>
