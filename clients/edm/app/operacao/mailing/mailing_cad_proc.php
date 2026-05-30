<?

include_once "../../libs/maininclude.php";
include_once "mailing_cla.php";

$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
$dsc_mailing = $_REQUEST['dsc_mailing'];


if ($acao == "gravar"){
	
	$mailing = new mailing(0);	
	$mailing->setpk($pk);	
	$mailing->setdsc_mailing($dsc_mailing);

	$mailing->salvar();
	
	javascriptalert('Operação executada com sucesso!!!');
}

if($acao == "excluir"){
	$mailing= new mailing($pk);
	$mailing->excluir();
	javascriptalert('Operação executada com sucesso!!!');
}

include_once "../../libs/desconectar.php";

?>
