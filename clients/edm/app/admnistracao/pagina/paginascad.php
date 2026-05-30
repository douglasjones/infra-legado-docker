<?
/* D-0908130-A
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

	$acao = "";
	if(!empty($_REQUEST['acao']))
		$acao = $_REQUEST['acao'];

	if(!empty($_REQUEST['codpagina']))
		$codpagina = $_REQUEST['codpagina'];
		
	if(!empty($_REQUEST['nome']))
		$pagina['Nome'] = $_REQUEST['nome'];

	if(!empty($_REQUEST['descricao']))
		$pagina['Descricao'] = $_REQUEST['descricao'];

	if ($acao == 'ins'){
		$sql = sqlinsert('paginas', array( "Nome" => $_REQUEST['nome'] , "Descricao" => $_REQUEST['descricao'] ) ) ;

		sql_query($sql);
		javascriptalert('Operação executada com sucesso.');
	}
	else if($acao == 'upd' && !empty($codpagina)){
		$sql = sqlupdate('paginas',  array( "Nome" => $_REQUEST['nome'] , "Descricao" => $_REQUEST['descricao'] ), 'CodPagina = ' . mysqlnull($codpagina));
		sql_query($sql);
		javascriptalert('Operação executada com sucesso.');
	}
	else if($acao == "ex" && !empty($codpagina)){
		$sql = "delete from paginas where CodPagina = $codpagina";
		sql_query($sql);
		javascriptalert('Operação executada com sucesso.');
	}
	include_once "../../libs/desconectar.php";?>
