<?

include_once "../../libs/maininclude.php";
include_once "auditoria_cla.php";



$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
$leads_pk = $_REQUEST['leads_pk'];
$agendavisita_pk = $_REQUEST['agendavisita_pk'];
$contatoslead_pk = $_REQUEST['contatoslead_pk'];
$tipo_visita_pk = $_REQUEST['tipo_visita_pk'];
$dsc_auditoria = $_REQUEST['dsc_auditoria'];
$tel_fixo = $_REQUEST['tel_fixo'];

if ($acao == "gravar"){
	
	$auditoria = new auditoria(0);
	$auditoria->setpk($pk);
	$auditoria->setleads_pk($leads_pk);
	$auditoria->setagendavisita_pk($agendavisita_pk);
	$auditoria->setcontatoslead_pk($contatoslead_pk);
	$auditoria->settipo_visita_pk($tipo_visita_pk);
	$auditoria->setdsc_auditoria($dsc_auditoria);
	$auditoria->settel_fixo($tel_fixo);

	$auditoria->salvar();
	
	javascriptalert('Operação executada com sucesso!!!');
}

if($acao == "excluir"){
	$auditoria= new auditoria($pk);
	$auditoria->excluir();
	javascriptalert('Operação executada com sucesso!!!');
}

include_once "../../libs/desconectar.php";

?>
