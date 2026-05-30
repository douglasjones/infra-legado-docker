<?	

/*___________________G_E_P_R_O_S_____________________________*/
/*   Descricao: Pagina PHP                                   */
/*   File:     Classe                                        */
/*-----------------------------------------------------------*/

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.ocorrencias.php";
include_once "../../libs/datas.php";

class agendaretorno {
	function adicionar($value, $reagendar = null){
		//Valida os dados
		if(!isset($value['codlead'])) return false;
		if(!isset($value['codusuariointerno'])) $value['codusuariointerno'] = $_SESSION['codusuario'];
		if(!isset($value['agendadopara'])) $value['agendadopara'] = $_SESSION['codusuario'];
		if(!isset($value['datacadastro']) || is_null($value['datacadastro'])) $value['datacadastro'] = 'SYSDATE()';
		if(!isset($value['dataretorno'])) return false;
		if(!isset($value['descricao'])) $value['descricao'] = null;
		if(!isset($value['codocorrencialead'])) $value['codocorrencialead'] = null;
		if(!isset($value['codagendalead'])) $value['codagendalead'] = null;
		if(!isset($value['ocorrenciasuperior'])) $value['ocorrenciasuperior'] = null;
		//Adiciona o retorno
		$fields = array();
		$fields['codlead'] = $value['codlead'];
		$fields['codusuariointerno'] = $value['codusuariointerno'];
		$fields['agendadopara'] = $value['agendadopara'];
		$fields['datacadastro'] = $value['datacadastro'];
		$fields['dataretorno'] = $value['dataretorno'];
		$fields['descricao'] = $value['descricao'];
		$fields['codocorrencialead'] = $value['codocorrencialead'];
		$fields['codagendalead'] = $value['codagendalead'];

		$sql = sqlinsert('agendaretorno', $fields);
		
		sql_query($sql);
		$codagendaretorno = mysql_insert_id();

		//Adicionar ocorrência
		$descricao = date('d/m/Y \à\s H:i:s', strtotime($value['dataretorno'])).': '.$value['descricao'];
		$codocorrencialead = ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricao, 'codtipoocorrencialead' => 3));
		agendaretorno::alterar($codagendaretorno, array('codocorrencialead' => $codocorrencialead));

		if($reagendar != null){
			$sql = "Select CodOcorrenciaLead ";
			$sql.= " from agendaretorno ";
			$sql.= " Where CodAgendaRetorno = $reagendar";
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			$codocorrenciasuperior = $row['CodOcorrenciaLead'];
			mysql_free_result($result);
			ocorrencias::alterar($codocorrenciasuperior, array('datafechamento' => $value['datacadastro']));
			ocorrencias::alterar($codocorrencialead, array('ocorrenciasuperior' => $codocorrenciasuperior));
		}
		return $codagendaretorno;
	}
	
	function alterar($codagendaretorno, $value){ //$value = array(nomecampo => valor)
		if(!isset($value['codlead'])) $value['codlead'] = null;
		if(!isset($value['codusuariointerno'])) $value['codusuariointerno'] = null;
		if(!isset($value['agendadopara'])) $value['agendadopara'] = null;
		if(!isset($value['datacadastro'])) $value['datacadastro'] = null;
		if(!isset($value['dataretorno'])) $value['dataretorno'] = null;
		if(!isset($value['descricao'])) $value['descricao'] = null;
		if(!isset($value['codocorrencialead'])) $value['codocorrencialead'] = null;
		if(!isset($value['codagendalead'])) $value['codagendalead'] = null;

		$fields = array();
		$fields['codlead'] = $value['codlead'];
		$fields['codusuariointerno'] = $value['codusuariointerno'];
		$fields['agendadopara'] = $value['agendadopara'];
		$fields['datacadastro'] = $value['datacadastro'];
		$fields['dataretorno'] = $value['dataretorno'];
		$fields['descricao'] = $value['descricao'];
		$fields['codocorrencialead'] = $value['codocorrencialead'];
		$fields['codagendalead'] = $value['codagendalead'];
		
		$sql = sqlupdate('agendaretorno', $fields, " CodAgendaRetorno = $codagendaretorno");
		sql_query($sql);

		$sql = "Select * From agendaretorno Where CodAgendaRetorno = $codagendaretorno";
		$result = sql_query($sql);
		$row = mysql_fetch_array($result);
		mysql_free_result($result);
		$descricao = date('d/m/Y \à\s H:i:s', strtotime($row['DataRetorno'])).': '.$row['Descricao'];
		if(!empty($row['CodOcorrenciaLead'])){
			ocorrencias::alterar($row['CodOcorrenciaLead'], array('descricao' => $descricao));
		}else{
			$codocorrencialead = ocorrencias::adicionar(array('codlead' => $row['CodLead'], 'descricao' => $descricao, 'codtipoocorrencialead' => 30));
			agendaretorno::alterar($agendaretorno, array('codocorrencialead' => $codocorrencialead));
		}
		return true;
	}
	
	function excluir($codagendaretorno){
		$sql = "Select * From agendaretorno Where CodAgendaRetorno = $codagendaretorno";
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		if(!$row)
			return false;
		if(!empty($row['CodOcorrenciaLead'])){
			$codocorrencialead = $row['CodOcorrenciaLead'];
			mysql_free_result($rs);
			ocorrencias::excluir($codocorrencialead);
		}
		$sql = "Delete From agendaretorno Where CodAgendaRetorno = $codagendaretorno";
		sql_query($sql);
		return true;
	}
}
?>