<?

include_once "../../libs/maininclude.php";
include_once "n_planilha_aparelhos_cargas_cla.php";

$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
$dt_inicio = $_REQUEST['dt_inicio'];
$dt_cancelamento = $_REQUEST['dt_cancelamento'];
$planilha_carga = $_FILES['planilha_carga']['name'];



if ($acao == "gravar"){
    $uploaddir = 'Arquivos/';//pasta

    $uploadfile = $uploaddir . $_FILES['planilha_carga']['name'];
 
	if (move_uploaded_file($_FILES['planilha_carga']['tmp_name'], $uploadfile)){
	        
    }
    

	$n_planilha_aparelhos_cargas = new n_planilha_aparelhos_cargas(0);
	$n_planilha_aparelhos_cargas->setpk($pk);
    $n_planilha_aparelhos_cargas->setdt_inicio($dt_inicio);
    $n_planilha_aparelhos_cargas->setdt_cancelamento($dt_cancelamento);
    $n_planilha_aparelhos_cargas->setplanilha_carga($planilha_carga);

	$n_planilha_aparelhos_cargas->salvar();
	
	javascriptalert('Operação executada com sucesso!!!');
}

if($acao == "excluir"){
    
	$n_planilha_aparelhos_cargas= new n_planilha_aparelhos_cargas($pk);
	$n_planilha_aparelhos_cargas->excluir();
	javascriptalert('Operação executada com sucesso!!!');
}

include_once "../../libs/desconectar.php";

?>
