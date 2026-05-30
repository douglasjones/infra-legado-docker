<?

include_once "../../libs/maininclude.php";
include_once "mobile_login_cla.php";

$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
$CodUsuarioInterno = $_REQUEST['CodUsuarioInterno'];
$CodDepartamento = $_REQUEST['CodDepartamento'];
$Nome = $_REQUEST['Nome'];
$Login = $_REQUEST['Login'];
$Senha = $_REQUEST['Senha'];
$CodUsuarioSuperior = $_REQUEST['CodUsuarioSuperior'];
$Desativado = $_REQUEST['Desativado'];
$GerenteContas = $_REQUEST['GerenteContas'];
$Atendente = $_REQUEST['Atendente'];
$Meta = $_REQUEST['Meta'];
$cod_polo = $_REQUEST['cod_polo'];
$cod_atividade_profissional = $_REQUEST['cod_atividade_profissional'];
$cod_classificacao = $_REQUEST['cod_classificacao'];
$cod_regime = $_REQUEST['cod_regime'];
$dat_adm = $_REQUEST['dat_adm'];
$dat_dem = $_REQUEST['dat_dem'];
$meta_moeda = $_REQUEST['meta_moeda'];
$ddd_tel = $_REQUEST['ddd_tel'];
$emei = $_REQUEST['emei'];
$email = $_REQUEST['email'];
$tel = $_REQUEST['tel'];
$cod_empresa = $_REQUEST['cod_empresa'];
$codigosa3 = $_REQUEST['codigosa3'];



if ($acao == "gravar"){	
	$mobile_login = new mobile_login(0);
	$mobile_login->setpk($pk);
	$mobile_login->setCodUsuarioInterno($CodUsuarioInterno);
    $mobile_login->setCodDepartamento($CodDepartamento);
    $mobile_login->setNome($Nome);
    $mobile_login->setLogin($Login);
    $mobile_login->setSenha($Senha);
    $mobile_login->setCodUsuarioSuperior($CodUsuarioSuperior);
    $mobile_login->setDesativado($Desativado);
    $mobile_login->setGerenteContas($GerenteContas);
    $mobile_login->setAtendente($Atendente);
    $mobile_login->setMeta($Meta);
    $mobile_login->setcod_polo($cod_polo);
    $mobile_login->setcod_atividade_profissional($cod_atividade_profissional);
    $mobile_login->setcod_classificacao($cod_classificacao);
    $mobile_login->setcod_regime($cod_regime);
    $mobile_login->setdat_adm($dat_adm);
    $mobile_login->setdat_dem($dat_dem);
    $mobile_login->setmeta_moeda($meta_moeda);
    $mobile_login->setddd_tel($ddd_tel);
    $mobile_login->setemei($emei);
    $mobile_login->setemail($email);
    $mobile_login->settel($tel);
    $mobile_login->setcod_empresa($cod_empresa);
    $mobile_login->setcodigosa3($codigosa3);
    
	$mobile_login->salvar();
	
	javascriptalert('Operação executada com sucesso!!!');
}

if($acao == "excluir"){
	$mobile_login= new mobile_login($pk);
	$mobile_login->excluir();
	javascriptalert('Operação executada com sucesso!!!');
}

include_once "../../libs/desconectar.php";

?>
