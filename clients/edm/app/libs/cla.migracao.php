<?
class migracao{
	function migra_lead($codlead, $bd_orig, $bd_dest, $status, $ger_conta, $atendente){
		$into = array();
		$values = array();
		$sql = "select * from $bd_orig.leads where CodLead = ".mysqlnull($codlead);
		$result = mysql_query($sql) or die(mysql_error());
		$lead = mysql_fetch_array($result);
		mysql_free_result($result);
		$lead['CodGerenteConta'] = $ger_conta;
		$lead['CodAtendente'] = $atendente;
		if($status != 'none')
			$lead['CodStatusClassificacaoLead'] = $status;
		foreach($lead as $field => $value){
			if(!is_int($field) && $field != 'CodLead'){
				$value = (!is_null($value) && empty($value)?'null':$value);
				if(!empty($value)){
					$into[] = $field;
					$values[] = mysqlnull($value);
				}
			}
		}
		$into = implode(", ", $into);
		$values = implode(", ", $values);
		$sql = "Insert Into $bd_dest.leads ($into) Values (" . $values . ")";
		mysql_query($sql);
		$sql = "select CodLead from $bd_dest.leads where RazaoSocial = ".mysqlnull($lead['RazaoSocial']);
		$sql .= " and tel = ".mysqlnull($lead['tel'])." and CodGerenteConta = ".mysqlnull($lead['CodGerenteConta']);
		$sql .= " and CNPJ_CPF = ".mysqlnull($lead['CNPJ_CPF']);
		$result = mysql_query($sql) or die(mysql_error());
		$ret = mysql_fetch_array($result);
		mysql_free_result($result);
		$ret = $ret['CodLead'];
		return $ret;
	}
	function migra_contatos($codlead_orig, $codlead_dest, $bd_orig, $bd_dest){
		$into = array();
		$values = array();
		$sql = "select * from $bd_orig.contatoslead where CodLead = ".mysqlnull($codlead_orig);
		$result = mysql_query($sql);
		while($contato = mysql_fetch_array($result)){
			$contato['CodLead'] = $codlead_dest;
			foreach($contato as $field => $value){
				if(!is_int($field) && $field != 'CodContatoLead'){
					$value = (!is_null($value) && empty($value)?'null':$value);
					if(!empty($value)){
						$into[] = $field;
						$values[] = mysqlnull($value);
					}
				}
			}
			$into = implode(", ", $into);
			$values = implode(", ", $values);
			$sql = "Insert Into $bd_dest.contatoslead ($into) Values (" . $values . ")";
		}
		mysql_free_result($result);
		mysql_query($sql) or die(mysql_error());
//		return $sql;
	}
	function migra_ocorrencia($codlead_orig, $codlead_dest, $bd_orig, $bd_dest, $usr){
		$into = array();
		$values = array();
		$sql2 = '';
		$sql = "select * from $bd_orig.ocorrenciaslead where CodLead = ".mysqlnull($codlead_orig);
		$result = mysql_query($sql);
		while($oc = mysql_fetch_array($result)){;
			$into = array();
			$values = array();
			$oc['CodUsuarioInterno'] = $usr;
			$oc['CodLead'] = $codlead_dest;
			foreach($oc as $field => $value){
				if(!is_int($field) && $field != 'CodOcorrenciaLead'){
					$value = (!is_null($value) && empty($value)?'null':$value);
					if(!empty($value)){
						echo $field;
						$into[] = $field;
						$values[] = mysqlnull($value);
					}
				}
			}
			$into = implode(", ", $into);
			$values = implode(", ", $values);
			$sql = "Insert Into $bd_dest.ocorrenciaslead ($into) Values (" . $values . ")";
			mysql_query($sql) or die(mysql_error());
//			$sql2 .= $sql."<br>";
		}
//		return $sql2;
		mysql_free_result($result);
	}
	function migra_agenda($codlead_orig, $codlead_dest, $bd_orig, $bd_dest, $usr){
		$sql2 = '';
		$into = array();
		$values = array();
		$sql = "select * from $bd_orig.agendaslead where CodLead = ".mysqlnull($codlead_orig);
		$result = mysql_query($sql);
		while($aglead = mysql_fetch_array($result)){
			$into = array();
			$values = array();
			$sql = "select NomeContato from $bd_orig.contatoslead where CodContatoLead = ".mysqlnull($aglead['CodContatoLead']);
			$res1 = mysql_query($sql) or die(mysql_error($link));
			$contato = mysql_fetch_array($res1);
			mysql_free_result($res1);
			$sql = "select CodContatoLead from $bd_dest.contatoslead where CodLead = ".mysqlnull($codlead_dest)." and NomeContato = ".mysqlnull($contato['NomeContato']);
			$res1 = mysql_query($sql);
			$contato = mysql_fetch_array($res1);
			mysql_free_result($res1);
			$sql = "select Descricao, CodTipoOcorrenciaLead, DataCadastro from $bd_orig.ocorrenciaslead where CodOcorrenciaLead = ".mysqlnull($aglead['CodOcorrenciaLead']);
			$oc = mysql_fetch_array(mysql_query($sql));
			$sql = "select CodOcorrenciaLead from $bd_dest.ocorrenciaslead where Descricao = ".mysqlnull($oc['Desricao']);
			$sql .= " and CodTipoOcorrenciaLead = ".mysqlnull($oc['CodTipoOcorrenciaLead'])." and DataCadastro = ".mysqlnull($oc['DataCadastro']);
			$oc = mysql_fetch_array(mysql_query($sql));
			$aglead['CodContatoLead'] = $contato['CodContatoLead'];
			$aglead['CodLead'] = $codlead_dest;
			$aglead['CodUsuarioInterno'] = $usr;
			$aglead['CodOcorrenciaLead'] = $oc['CodOcorrenciaLead'];
			foreach($aglead as $field => $value){
				if(!is_int($field) && $field != 'CodAgendaLead'){
					$value = (!is_null($value) && empty($value)?'null':$value);
					if(!empty($value)){
						$into[] = $field;
						$values[] = mysqlnull($value);
					}
				}
			}
			$into = implode(", ", $into);
			$values = implode(", ", $values);
			$sql = "Insert Into $bd_dest.agendaslead ($into) Values (" . $values . ")";
			
			mysql_query($sql) or die(mysql_error());
//			$sql2 .= $sql."<br>";
		}
//		return $sql2;
		mysql_free_result($result);
	}
}
?>