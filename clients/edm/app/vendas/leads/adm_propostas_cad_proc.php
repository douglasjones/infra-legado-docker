<?

include_once "../../libs/maininclude.php";
include_once "adm_propostas_cla.php";
include_once "combo_cla.php";
include_once "../../libs/combo.php";
include_once "../../libs/cla.email.php";
include_once "../../libs/cla.layout_email.php";

$acao = $_REQUEST['acao'];
$propotas_pk = $_REQUEST['propotas_pk'];
$leads_pk= $_REQUEST['leads_pk'];
$operador_pk = $_REQUEST['operador_pk'];
$data_proposta_operador_pk = $_REQUEST['data_proposta_operador_pk'];
$vl_data = $_REQUEST['vl_data'];
$vl_obs_data = $_REQUEST['vl_obs_data'];
$vl_pedido = $_REQUEST['vl_pedido'];
$n_pedido = $_REQUEST['n_pedido'];
$email_consultor = $_REQUEST['email_consultor'];
$Consultor = $_REQUEST['Consultor'];
$dsc_processo = $_REQUEST['dsc_processo'];
$razaosocial = $_REQUEST['razaosocial'];
$cnpj_cpf = $_REQUEST['cnpj_cpf'];
$nomeusuario = $_REQUEST['nomeusuario'];
$email_usuario = $_REQUEST['email_usuario'];

if ($acao == "gravar"){
	
	$adm_propostas = new adm_propostas(0);	
	$adm_propostas->setpk($pk);	
	$adm_propostas->setpropostas_pk($propotas_pk);	
	$adm_propostas->setleads_pk($leads_pk);
	$adm_propostas->setoperador_pk($operador_pk);
	$adm_propostas->setdata_proposta_operador_pk($data_proposta_operador_pk);
	$adm_propostas->setvl_data($vl_data);
	$adm_propostas->setvl_obs_data($vl_obs_data);
    $adm_propostas->setn_pedido($n_pedido);
	$adm_propostas->setvl_pedido($vl_pedido);        
	$adm_propostas->setemail_consultor($email_consultor);        
	$adm_propostas->setConsultor($Consultor);                
	$adm_propostas->setdsc_processo($dsc_processo);                
	$adm_propostas->setrazaosocial($razaosocial);                
	$adm_propostas->setcnpj_cpf($cnpj_cpf); 
	$adm_propostas->setnomeusuario($nomeusuario); 
	$adm_propostas->setemail_usuario($email_usuario); 
    
	$adm_propostas->salvar();
	$adm_propostas->add_ocorrencia();
	$adm_propostas->status_lead();
    
    $adm_propostas->add_bko();
   
    $assunto = $dsc_processo;

    $html = layout_email::layout_bko($leads_pk,$operador_pk,$assunto,$vl_data,$vl_obs_data,$n_pedido,$vl_pedido,$Consultor,$razaosocial,$cnpj_cpf,$nomeusuario);
    
    email::envia_email_bko($html,$email_consultor,$body,$msg_body,$assunto,$operador_pk,$email_usuario);
     
	echo "<script>";
	echo 'window.location = "adm_propostas_cad_form.php?pk='.$propotas_pk.'&codlead='.$leads_pk.'&operador_pk='.$operador_pk.'"';
	echo "</script>";		
	
}
if($acao == "select"){
	
}	

if($acao == "excluir"){
	$propostas= new propostas($pk);
	$propostas->excluir();
	javascriptalert('Operação executada com sucesso!!!');
}

include_once "../../libs/desconectar.php";

?>