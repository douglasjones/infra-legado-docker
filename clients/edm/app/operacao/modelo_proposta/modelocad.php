<?
/*
/---------------------------------------------------\
|						    						|
|DESCRIÇÃO: PRINCIPAIS FUNÇÕES DO SISTEMA EM PHP    |
|						    						|
|					     	    					|
|REVISÕES:					    					|
|						    						|
|						    						| 
|DESESENVOLVIDO POR: DOUGLAS JONES LOPES	    	|
|						    						|
|DATA: 24/09/2008	     			    			|
\___________________G_E_P_R_O_S_____________________/
*/
    include_once "../../libs/maininclude.php";
	include_once "../../libs/datas.php";

	$acao = null;
	$codmodelo = null;
	$nome = null;
	$style = null;
	$modelo = null;

	if(!empty($_REQUEST['acao'])) $acao = $_REQUEST['acao'];

	if(!empty($_REQUEST['codmodelo']))
		$codmodelo = $_REQUEST['codmodelo'];
	if(!empty($_REQUEST['nome']))
		$nome = $_REQUEST['nome'];
	if(!empty($_REQUEST['style'])){
		$style = $_REQUEST['style'];
	}else{
		$style = 'null';
	}
	if(!empty($_REQUEST['modelo'])){
		$modelo = $_REQUEST['modelo'];
	}else{
		$modelo ='null';
	}	

	if(empty($acao)){
		$acao = "ins";
		if(!empty($codmodelo))
			$acao = "upd";
	}

	if ($acao == 'ins'){
		$sql = sqlinsert('modelos', array('Nome' => $nome, 'Style' => $style, 'Modelo' => $modelo));
		print $sql;
		sql_query($sql);
		$codmodelo = mysql_insert_id();
	}elseif($acao == 'upd'){
		$sql = sqlupdate('modelos', array('Nome' => $nome, 'Style' => $style, 'Modelo' => $modelo), 'CodModelo = '.mysqlnull($codmodelo));
		sql_query($sql);
	}elseif($acao == "ex"){
		$sql = "delete from modelos where CodModelo = " . mysqlnull($codmodelo);
		sql_query($sql);
	}
	javascriptalert('Opração executada com sucesso.');

	include_once "../../libs/desconectar.php";?>
