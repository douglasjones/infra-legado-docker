<?	
	include_once "../../libs/maininclude.php";
	
	$acao = null;
	$polo = array();
	$cidade = array();
	//VERIFICA O ULTIMO POLO CADASTRADO
		$acao = $_REQUEST['acao'];
		$polo['dat_cad'] = 'sysdate()';			
		$polo['codusuariointerno'] = $_SESSION['codusuario'];	
		//$polo['cod_polo'] = $_REQUEST['cod_polo'];
		if($_REQUEST['status']==0){
			$polo['dat_canc'] = 'sysdate()';
		}else{
			$polo['dat_canc'] = "null";
		}
		$polo['n_polo'] = $_REQUEST['n_polo'];

	//CADASTRA O POLO
	if ($acao == 'ins'){
		
		$sql = sqlinsert('polo', $polo);
		sql_query($sql);		
		javascriptalert('Operação executada com sucesso.');
	}
	else if($acao == 'upd' && !empty($_REQUEST['cod_polo'])){
		$sql = sqlupdate('polo', $polo, 'cod_polo = ' . mysqlnull($_REQUEST['cod_polo']));
		sql_query($sql);
		javascriptalert('Operação executada com sucesso.');
	}
	include_once "../../libs/desconectar.php";
?>
