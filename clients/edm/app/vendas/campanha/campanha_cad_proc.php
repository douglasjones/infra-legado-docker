<?

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.campanha.php";

$acao = $_REQUEST['acao'];
$cod_campanha = $_REQUEST['cod_campanha'];
$nome_campanha = $_REQUEST['nome_campanha'];
$dt_inicio_campanha = $_REQUEST['dt_inicio_campanha'];
$codusuariointerno = $_REQUEST['codusuariointerno'];
$descricao_campanha = $_REQUEST['descricao_campanha'];
$cod_polo = $_REQUEST['cod_polo'];
$mailing = $_REQUEST['mailing_pk'];
$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
$codmotivo = $_REQUEST['codmotivo'];
$cod_cidade = $_REQUEST['cod_cidade'];
$dt_vencimento_contrato_de = $_REQUEST['dt_vencimento_contrato_de'];
$dt_vencimento_contrato_ate = $_REQUEST['dt_vencimento_contrato_ate'];
$cod_operadora = $_REQUEST['cod_operadora'];
$codgerenteconta = $_REQUEST['codgerenteconta'];

// grava o registro no banco de dados;
if($acao == "gravar"){
	
	$campanha = new campanha(0);
	
	$campanha->setcod_campanha($cod_campanha);
	$campanha->setnome_campanha($nome_campanha);
	$campanha->setdt_inicio_campanha($dt_inicio_campanha);
	$campanha->setdescricao_campanha($descricao_campanha);
	$campanha->setcod_polo($cod_polo);
	$campanha->setmailing($mailing);
	$campanha->setcodstatusclassificacaolead($codstatusclassificacaolead);
	$campanha->setcodmotivo($codmotivo);
	$campanha->setdt_vencimento_contrato_de($dt_vencimento_contrato_de);
	$campanha->setcod_operadora($cod_operadora);
	$campanha->setcodgerenteconta($codgerenteconta);
	$campanha->setdt_vencimento_contrato_ate($dt_vencimento_contrato_ate);
	
	$cod_campanha = $campanha->salvar();
	javascriptalert('Operaчуo executada com sucesso.');
}

if($acao == "fechar"){
	$campanha = new campanha($cod_campanha);
	$campanha->fecharCampanha();
	javascriptalert('Campanha fechada com sucesso.');
}

if($acao == "associar"){
	$campanha = new campanha($cod_campanha);
	
	$campanha->setcod_campanha($cod_campanha);
	$campanha->setnome_campanha($nome_campanha);
	$campanha->setdt_inicio_campanha($dt_inicio_campanha);
	$campanha->setdescricao_campanha($descricao_campanha);
	$campanha->setcod_polo($cod_polo);
	$campanha->setmailing($mailing);
	$campanha->setcodstatusclassificacaolead($codstatusclassificacaolead);
	$campanha->setcodmotivo($codmotivo);
	$campanha->setdt_vencimento_contrato_de($dt_vencimento_contrato_de);
	$campanha->setcod_operadora($cod_operadora);
	$campanha->setcodgerenteconta($codgerenteconta);
	$campanha->setdt_vencimento_contrato_ate($dt_vencimento_contrato_ate);
	
	$cod_campanha = $campanha->salvar();
	
	$total = $campanha->criarAssociacao();
	javascriptalert('Associaчуo criada com sucesso!\n\n'.$total.' Lead(s) participa(m) desta campanha.');
}

if($acao == "simular"){
	$campanha = new campanha($cod_campanha);
	
	$campanha->setcod_campanha($cod_campanha);
	$campanha->setnome_campanha($nome_campanha);
	$campanha->setdt_inicio_campanha($dt_inicio_campanha);
	$campanha->setdescricao_campanha($descricao_campanha);
	$campanha->setcod_polo($cod_polo);
	$campanha->setmailing($mailing);
	$campanha->setcodstatusclassificacaolead($codstatusclassificacaolead);
	$campanha->setcodmotivo($codmotivo);
	$campanha->setdt_vencimento_contrato_de($dt_vencimento_contrato_de);
	$campanha->setcod_operadora($cod_operadora);
	$campanha->setcodgerenteconta($codgerenteconta);
	$campanha->setdt_vencimento_contrato_ate($dt_vencimento_contrato_ate);
	
	$cod_campanha = $campanha->salvar();
	
	$total = $campanha->criarSimulacao();
	javascriptalert('Simulaчуo da Campanha!\n\n'.$total.' Lead(s) encontrados.');
}

include_once "../../libs/desconectar.php";

?>