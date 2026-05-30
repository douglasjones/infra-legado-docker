<?

include_once "../../libs/maininclude.php";
include_once "n_aparelhos_cla.php";
include_once "../../libs/combo.php";

$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
$ds_aparelho = $_REQUEST['ds_aparelho'];
$ds_link_imagem = $_REQUEST['ds_link_imagem'];
$fabricante_pk = $_REQUEST['fabricante_pk'];
$operador_pk = $_REQUEST['operador_pk'];
$dt_cancelamento = $_REQUEST['dt_cancelamento'];
$arquivo = $_FILES['nom_imagem_cel']['name'];

if ($acao == "gravar"){
	$uploaddir = 'aparelhos/';
        
    $uploadfile = $uploaddir . $_FILES['nom_imagem_cel']['name'];

    if (move_uploaded_file($_FILES['nom_imagem_cel']['tmp_name'], $uploadfile)){
	        
    }
    
	$n_aparelhos = new n_aparelhos(0);
	$n_aparelhos->setpk($pk);
	$n_aparelhos->setds_aparelho($ds_aparelho);
	$n_aparelhos->setds_link_imagem($ds_link_imagem);
	$n_aparelhos->setfabricante_pk($fabricante_pk);
	$n_aparelhos->setoperador_pk($operador_pk);
	$n_aparelhos->setdt_cancelamento($dt_cancelamento);
    $n_aparelhos->setnom_imagem_cel($arquivo);
    
	$n_aparelhos->salvar();
	
	javascriptalert('Operação executada com sucesso!!!');
}

if($acao == "excluir"){
	$n_aparelhos= new n_aparelhos($pk);
	$n_aparelhos->excluir();
	javascriptalert('Operação executada com sucesso!!!');
}

include_once "../../libs/desconectar.php";

?>
