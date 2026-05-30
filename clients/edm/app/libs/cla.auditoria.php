<?	include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.ocorrencias.php";
	include_once "../../libs/datas.php";

class auditoria {
	function adicionar($value){

		if(!isset($value['codagendalead'])) return false;
		if(!isset($value['codusuariointerno'])) $value['codusuariointerno'] = $_SESSION['codusuariointerno'];
		if(!isset($value['dat_cad']) || is_null($value['dat_cad'])) $value['dat_cad'] = 'SYSDATE()';
		
		$fields['codagendalead'] = $value['codagendalead'];
		$fields['codusuariointerno'] = $value['codusuariointerno'];
		$fields['dat_cad'] = $value['dat_cad'];
		

		$sql = sqlinsert('auditoria', $fields);
		sql_query($sql);
		$codauditoria = mysql_insert_id();
		
		if($value['codagendalead'] <>""){
			$sql = "update agendaslead set auditado =1  where codagendalead =" .($value['codagendalead']);
			sql_query($sql);
		}

		if(!empty($value['1'])) {
		$sql_1 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['1'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_1);
		}
		if(!empty($value['2'])) {
		$sql_2 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['2'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_2);
		}			
		if(!empty($value['3'])) {
		$sql_3 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['3'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_3);
		}	
		if(!empty($value['4'])) {
		$sql_4 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['4'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_4);
		}
		if(!empty($value['5'])) {
		$sql_5 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['5'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_5);
		}
		if(!empty($value['6'])) {
		$sql_6 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['6'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_6);
		}
		if(!empty($value['7'])) {
		$sql_7 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['7'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_7);
		}
		if(!empty($value['8'])) {
		$sql_8 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['8'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_8);
		}	
		if(!empty($value['9'])) {
		$sql_9 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['9'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_9);
		}		
		if(!empty($value['10'])) {
		$sql_10 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['10'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_9);
		}	
		if(!empty($value['11'])) {
		$sql_11 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['11'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_11);
		}	
		if(!empty($value['12'])) {
		$sql_12 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['12'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_12);
		}			
		if(!empty($value['13'])) {
		$sql_13 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['13'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_13);
		}	
		if(!empty($value['14'])) {
		$sql_14 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['14'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_14);
		}	
		if(!empty($value['15'])) {
		$sql_15 = sqlinsert('invalidacao_agenda', array('cod_motivo_invalidacao' => $value['15'],'codagendalead'=> $value['codagendalead']));
		sql_query($sql_15);
		}	
		if(!empty($value['1']) || !empty($value['2']) || !empty($value['3']) || !empty($value['4']) || !empty($value['5']) || !empty($value['6']) || !empty($value['7']) || !empty($value['8']) || !empty($value['9']) || !empty($value['10']) || !empty($value['11']) || !empty($value['12']) || !empty($value['13']) || !empty($value['14']) || !empty($value['15'])) {
			mysql_query("Delete from ordem_gc where CodAgendaGC = ".$value['codagendalead']);
			$sql = "update agendaslead set CodStatus = 5 where codagendalead =" .($value['codagendalead']);
			sql_query($sql);
		}
		return $codauditoria;
	}
	
	
}?>