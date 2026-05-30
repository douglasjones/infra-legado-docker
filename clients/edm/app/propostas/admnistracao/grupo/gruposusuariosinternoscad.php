<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.paginas.php";
	
	$acao = null;
	
	if(!empty($_REQUEST['acao']))
		$acao = $_REQUEST['acao'];

	if(!empty($_REQUEST['codgrupousuariointerno'])){
		$codgrupousuariointerno = $_REQUEST['codgrupousuariointerno'];
	}

	if(!empty($_REQUEST['nome']))
		$nome = $_REQUEST['nome'];

	if(!empty($_REQUEST['gerente']))
		$gerente = $_REQUEST['gerente'];
	else 
		$gerente = 'null';

	if(!empty($_REQUEST["horarioini"]))
		$horarioini = $_REQUEST["horarioini"];
	else
		$horarioini = "null";

	if(!empty($_REQUEST["horariofim"]))
		$horariofim = $_REQUEST["horariofim"];
	else
		$horariofim = "null";

	if(!empty($_REQUEST["ip"]))
		$ip = $_REQUEST["ip"];
	else
		$ip = "null";


	if ($acao == 'ins'){
		$sql = "insert into gruposusuariosinternos (nome, codgerente, horarioini, horariofim, ip) values (" . mysqlnull($nome) . ", ".mysqlnull($gerente).",".mysqlnull($hroarioini).", ".mysqlnull($horariofim).", ".mysqlnull($ip).")";
		sql_query($sql);

		paginas::salvarpaginas(mysql_insert_id());
		
		javascriptalert('Operação executada com sucesso.');
	}elseif($acao == 'upd'){
		$sql = "update gruposusuariosinternos set ";
		$sql.="  nome =  " . mysqlnull($nome);
		$sql.=", codgerente =  " . mysqlnull($gerente);
		$sql.=", horarioini = ". mysqlnull($horarioini);
		$sql.=", horariofim = ". mysqlnull($horariofim);
		$sql.=", ip = ". mysqlnull($ip);
		$sql.=" where codgrupousuariointerno = " . mysqlnull($codgrupousuariointerno);
		sql_query($sql);
		
		paginas::salvarpaginas($codgrupousuariointerno);
		
		javascriptalert('Operação executada com sucesso.');
	}
	else if($acao == "ex"){
		$sql = "select * from gruposusuariosinternos_usuariosinternos where CodGrupoUsuarioInterno = " . mysqlnull($codgrupousuariointerno);
		$result = sql_query($sql);
		//if(mysql_num_rows($result)){
			$sql = "delete from gruposusuariosinternos_paginas where codgrupousuariointerno = " . mysqlnull($codgrupousuariointerno);
			sql_query($sql);

			$sql = "delete from gruposusuariosinternos where codgrupousuariointerno = " . mysqlnull($codgrupousuariointerno);
			sql_query($sql);
		
			javascriptalert('Operação executada com sucesso.');
		//}else{
		//	javascriptalert('N?o ? poss?vel excluir este Grupo.');
		//}
		mysql_free_result($result);
	}
	include_once "../../libs/desconectar.php";?>
