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
include_once "../../libs/cla.equipes.php";

	$acao = "";
	if(!empty($_REQUEST['acao']))
		$acao = $_REQUEST['acao'];

	if(!empty($_REQUEST['codequipe']))
		$codequipe = $_REQUEST['codequipe'];
		
	if(!empty($_REQUEST['nome']))
		$equipe['nome'] = $_REQUEST['nome'];

	if(!empty($_REQUEST['lider']))
		$equipe['lider'] = $_REQUEST['lider'];

	if(!empty($_REQUEST['codusr']))
		$codusr = $_REQUEST['codusr'];
print $codusr;
	if ($acao == 'ins'){
		$ret = equipes::ins_equipe($equipe['nome'], $equipe['lider']);
		javascriptalert($ret);
	}
	else if($acao == 'upd' && !empty($codequipe)){
		$ret = equipes::upd_equipe($codequipe, $equipe['nome'], $equipe['lider']);
		javascriptalert($ret);
	}
	else if($acao == "del" && !empty($codequipe)){
		$ret = equipes::del_equipe($codequipe);
		javascriptalert($ret);
	}
	else if ($acao == 'ins_usr'){
		if (!empty($codequipe) && !empty($codusr)){
			$ret = equipes::ins_usuario($codequipe, $codusr);
			javascriptalert($ret);
		}else
			javascriptalert('Usuário não selecionado');
	}
	else if($acao == "del_usr" && !empty($codusr)){
		
		$ret = equipes::del_usuario($codusr);
		javascriptalert($ret);
	}
	include_once "../../libs/desconectar.php";?>