<?

include_once "../../libs/maininclude.php";
include_once "carga_cla.php";

$acao = $_REQUEST['acao'];
$mailing = $_REQUEST['mailing_pk'];
$arquivo = $_FILES['ds_nome_documento']['name'];
$codatendente = $_REQUEST['codatendente'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];

if ($acao == "gravar"){	

$uploaddir = 'arquivos/';

$uploadfile = $uploaddir . $_FILES['ds_nome_documento']['name'];
 
	if (move_uploaded_file($_FILES['ds_nome_documento']['tmp_name'], $uploadfile)){
	        
    }

	$carga = new carga(0);

	$carga->setmailing($mailing);
	$carga->setarquivo($arquivo);
        $carga->setcodatendente($codatendente);
        $carga->setcodgerenteconta($codgerenteconta);
	$carga->setcodstatusclassificacaolead($codstatusclassificacaolead);

	$carga->salvar();
	
	javascriptalert('Operação executada com sucesso!!!');
}

if($acao == "excluir"){
	$carga= new carga($pk);
	$carga->excluir();
	javascriptalert('Operação executada com sucesso!!!');
}

include_once "../../libs/desconectar.php";

?>
