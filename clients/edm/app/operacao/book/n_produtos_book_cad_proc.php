<?

include_once "../../libs/maininclude.php";
include_once "n_produtos_book_cla.php";

$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
$dt_cadastro = $_REQUEST['dt_cadastro'];
$usuario_cadastro_pk = $_REQUEST['usuario_cadastro_pk'];
$dt_ult_atualizacao = $_REQUEST['dt_ult_atualizacao'];
$usuario_ult_atualizacao_pk = $_REQUEST['usuario_ult_atualizacao_pk'];
$dt_cancelamento = $_REQUEST['dt_cancelamento'];
$operador_pk = $_REQUEST['operador_pk'];
$n_dsc_book = $_REQUEST['n_dsc_book'];
$dt_inicio = $_REQUEST['dt_inicio'];
$dt_fim = $_REQUEST['dt_fim'];

if ($acao == "gravar"){
	
	$n_produtos_book = new n_produtos_book(0);
	$n_produtos_book->setpk($pk);
    $n_produtos_book->setdt_cadastro($dt_cadastro);
    $n_produtos_book->setusuario_cadastro_pk($usuario_cadastro_pk);
    $n_produtos_book->setdt_ult_atualizacao($dt_ult_atualizacao);
    $n_produtos_book->setusuario_ult_atualizacao_pk($usuario_ult_atualizacao_pk);
    $n_produtos_book->setdt_cancelamento($dt_cancelamento);
    $n_produtos_book->setoperador_pk($operador_pk);
    $n_produtos_book->setn_dsc_book($n_dsc_book);
    $n_produtos_book->setdt_inicio($dt_inicio);
    $n_produtos_book->setdt_fim($dt_fim);

	$n_produtos_book->salvar();
    
	javascriptalert('Operação executada com sucesso!!!');
}

if($acao == "excluir"){
	$n_produtos_book= new n_produtos_book($pk);
	$n_produtos_book->excluir();
    
	javascriptalert('Operação executada com sucesso!!!');
    
}
include_once "../../libs/desconectar.php";

?>
