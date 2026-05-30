<?
/*
Pagina:gerentescad.php
modulo:Operações
Submodulo: Novo
obs: É acionada quando se clica em enviar no submodulo novo

Dados de criação
Criação:
Empresa:
Executor

Histórico das Revisões:
 Criação: 16/04/2008
 Empresa:
 Executor Rinaldo Peligrineli

Histórico de Auditorias:
 Criação: 16/04/2008
 Empresa:
 Executor FELIPE SANTOS
 */

/*
 Includes
*/

include_once "../../libs/maininclude.php";

	$acao = "";
	$codusuariointerno = 0;
	$codusuariointernoa = 0;
	if(!empty($_REQUEST['acao']))
		$acao = $_REQUEST['acao'];

	if(!empty($_REQUEST['codusuariointerno'])){
		$codusuariointerno = $_REQUEST['codusuariointerno'];
	}else{
		javascriptalert("Código usuario interno inválido.");
		exit();
	}

	if(!empty($_REQUEST['codusuariointerno']))
		$codusuariointernoa = $_REQUEST['codusuariointerno'];
	if (!empty($acao)){
		$sql = "update usuariosinternos set gerentecontas = 0 where codusuariointerno = $codusuariointernoa";
		sql_query($sql);
		$sql = "update usuariosinternos set gerentecontas = ".($acao=='ex'?'0':'1')." where codusuariointerno = $codusuariointerno";
		sql_query($sql);		
		javascriptalert('Operação executada com sucesso.');
	}

	include_once "../../libs/desconectar.php";?>
