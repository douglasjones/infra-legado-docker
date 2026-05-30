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
include_once "libs/maininclude.php";

class usuarios {
	function salvar($value){
		if(empty($value['CodUsuarioInterno'])){
			return usuarios::adicionar($value);
		}else{
			return usuarios::alterar($value['CodUsuarioInterno'], $value);
		}
	}
	
	function adicionar($value){
		if(empty($value['coddepartamento'])) $value['coddepartamento'] = null;
		if(empty($value['nome'])) return false;
		if(empty($value['login'])) return false;
		if(empty($value['senha'])) $value['senha'] = 'NoVaSeNhA';
		if(empty($value['codusuariosuperior'])) $value['codusuariosuperior'] = null;
		if(empty($value['desativado'])) $value['desativado'] = -1;
		if(empty($value['gerentecontas'])) $value['gerentecontas'] = null;
		if(empty($value['atendente'])) $value['atendente'] = null;

		$fields = array();
		$fields['coddepartamento'] = $value['coddepartamento'];
		$fields['nome'] = $value['nome'];
		$fields['login'] = $value['login'];
		$fields['senha'] = $value['senha'];
		$fields['codusuariosuperior'] = $value['codusuariosuperior'];
		$fields['desativado'] = $value['desativado'];
		$fields['gerentecontas'] = $value['gerentecontas'];
		$fields['atendente'] = $value['atendente'];
		
		$sql = sqlinsert('usuariosinternos', $fields);
		sql_query($sql);
		
		$codusuariointerno = mysql_insert_id();
		if(isset($value['codgrupousuariointerno']))
			usuarios::salvarGrupos($codusuariointerno, $value['codgrupousuariointerno']);
		return $codusuariointerno;
	}
	
	function alterar($codusuariointerno, $value){
		if(empty($value['coddepartamento'])) $value['coddepartamento'] = null;
		if(empty($value['nome'])) return false;
		if(empty($value['login'])) return false;
		if(empty($value['codusuariosuperior'])) $value['codusuariosuperior'] = null;
		if(empty($value['desativado'])) $value['desativado'] = -1;
		if(empty($value['gerentecontas'])) $value['gerentecontas'] = null;
		if(empty($value['atendente'])) $value['atendente'] = null;

		$fields = array();
		$fields['coddepartamento'] = $value['coddepartamento'];
		$fields['nome'] = $value['nome'];
		$fields['login'] = $value['login'];
		if(!empty($value['senha'])){
			$fields['senha'] = $value['senha'];
		}
		$fields['codusuariosuperior'] = $value['codusuariosuperior'];
		$fields['desativado'] = $value['desativado'];
		$fields['gerentecontas'] = $value['gerentecontas'];
		$fields['atendente'] = $value['atendente'];
		
		$sql = sqlupdate('usuariosinternos', $fields, ' CodUsuarioInterno = ' . mysqlnull($codusuariointerno));
		sql_query($sql);
		
		if(!empty($value['codgrupousuariointerno'])){
			usuarios::salvarGrupos($codusuariointerno, $value['codgrupousuariointerno']);
		}
		return $codusuariointerno;
	}
	
	function salvarGrupos($codusuariointerno, $grupos){
		$sql = "delete from gruposusuariosinternos_usuariosinternos where codusuariointerno = " . mysqlnull($codusuariointerno);
		sql_query($sql);
		foreach($grupos as $grupo){
			$sql = sqlinsert('gruposusuariosinternos_usuariosinternos', array('codgrupousuariointerno' => $grupo, 'codusuariointerno' => $codusuariointerno));
			sql_query($sql);
		}
	}
}
?>