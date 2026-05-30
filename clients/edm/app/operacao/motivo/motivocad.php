<?
    include_once "../../libs/maininclude.php";
	$acao = 'ins';	
	if(isset($_REQUEST['acao']))
		$acao = $_REQUEST['acao'];
	if(!empty($_REQUEST['codmotivolead']))
		$codmotivolead = $_REQUEST['codmotivolead'];
	if(!empty($_REQUEST['descricao']))
		$descricao = $_REQUEST['descricao'];
	if(!empty($_REQUEST['cod_operador']))
		$cod_operador = $_REQUEST['cod_operador'];
		
		
	if($acao == 'ins'){

		$sql = "Select * from motivoslead where descricao like " . mysqlnull("%$descricao%");
		$rs = sql_query($sql);
		if(mysql_fetch_array($rs)){
			javascriptalert('Motivo já cadastrado.');
			exit();
		}
		mysql_free_result($rs);
		$sql = sqlinsert('motivoslead', array('Descricao' => $descricao,'cod_operador' => $cod_operador));
		sql_query($sql);
		javascriptalert('Operação executada com sucesso.');
	}elseif($acao == 'upd'){
		$sql = "Select * from motivoslead where descricao like " . mysqlnull("%$descricao%");
		$rs = sql_query($sql);
		$sql = sqlupdate('motivoslead', array('Descricao' => $descricao,'cod_operador' => $cod_operador), 'CodMotivoLead = ' . mysqlnull($codmotivolead));
		sql_query($sql);
		javascriptalert('Operação executada com sucesso.');
	}elseif($acao == "ex"){
		$sql = "Select codlead from leads where CodMotivo = " . mysqlnull($codmotivolead);
		$rs = sql_query($sql);
		if(mysql_fetch_array($rs)){
			javascriptalert('Motivo está sendo utilizado.');
			exit();
		}
		mysql_free_result($rs);
	
		$sql = "Select codproposta from propostas where CodMotivo = " . mysqlnull($codmotivolead);
		$rs = sql_query($sql);
		if(mysql_fetch_array($rs)){
			javascriptalert('Motivo está sendo utilizado.');
			exit();
		}
		mysql_free_result($rs);
	
		$sql = "delete from motivoslead where codmotivolead = $codmotivolead";
		mysql_query($sql);
	
		javascriptalert('Operação executada com sucesso.');
	}
	include_once "../../libs/desconectar.php";?>
