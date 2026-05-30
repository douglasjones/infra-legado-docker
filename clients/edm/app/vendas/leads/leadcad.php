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
class leads {
	function salvarContatos($codlead, $value){
		$del = array();
		if(!empty($value['contato'])){
			foreach($value['contato'] as $id => $contato){
				if(!empty($contato['codcontatolead'])){
					$del[] = $contato['codcontatolead'];
				}
			}
		}
		if(count($del) > 0){
			$sql = "Delete From contatoslead Where CodContatoLead Not In (" . implode(',', $del) . ") And CodLead = " . mysqlnull($codlead);
		}else{
			$sql = "Delete From contatoslead Where CodLead = " . mysqlnull($codlead);
		}
		sql_query($sql);
		if(!empty($value['contato'])){
			foreach($value['contato'] as $id => $contato){
				$contato['codlead'] = $codlead;
				if(!empty($contato['codcontatolead'])){
					$sql = sqlupdate('contatoslead', $contato, 'CodContatoLead = ' . mysqlnull($contato['codcontatolead']));
				}else{
					$sql = sqlinsert('contatoslead', $contato);
				}
				sql_query($sql);
			}
		}
	}
	
	function adicionar($value, $contatos = true){
		if(!isset($value['codlead'])) $value['codlead'] = null;
		if(!isset($value['razaosocial'])) return false;
		if(!isset($value['nomefantasia'])) $value['nomefantasia'] = null;
		if(!isset($value['cnpj_cpf'])) $value['cnpj_cpf'] = null;
		if(!isset($value['ie'])) $value['ie'] = null;
		if(!isset($value['inscricaomunicipal'])) $value['inscricaomunicipal'] = null;
		if(!isset($value['site'])) $value['site'] = null;
		if(!isset($value['ddd'])) $value['ddd'] = null;
		if(!isset($value['tel'])) $value['tel'] = null;
		if(!isset($value['dddfax'])) $value['dddfax'] = null;
		if(!isset($value['fax'])) $value['fax'] = null;
		if(!isset($value['endereco'])) $value['endereco'] = null;
		if(!isset($value['numero'])) $value['numero'] = null;
		if(!isset($value['complemento'])) $value['complemento'] = null;
		if(!isset($value['referencia'])) $value['referencia'] = null;
		if(!isset($value['bairro'])) $value['bairro'] = null;
		if(!isset($value['cep'])) $value['cep'] = null;
		if(!isset($value['cidade'])) $value['cidade'] = null;
		if(!isset($value['uf'])) $value['uf'] = null;
		if(!isset($value['codgerenteconta'])) $value['codgerenteconta'] = null;
		if(!isset($value['datacadastro'])) $value['datacadastro'] = 'SYSDATE()';
		if(!isset($value['codstatusclassificacaolead'])) $value['codstatusclassificacaolead'] = 2;
		if(!isset($value['segmento'])) $value['segmento'] = null;
		if(!isset($value['codatendente'])) $value['codatendente'] = null;
		if(!isset($value['mailing'])) $value['mailing'] = null;
		if(!isset($value['codmotivo'])) $value['codmotivo'] = null;
		if(!isset($value['vencimentocontrato'])) $value['vencimentocontrato'] = null;
		if(!isset($value['ativacao'])) $value['ativacao'] = null;
		
		$fields = array();
		$fields['razaosocial'] = $value['razaosocial'];
		$fields['nomefantasia'] = $value['nomefantasia'];
		$fields['cnpj_cpf'] = $value['cnpj_cpf'];
		$fields['ie'] = $value['ie'];
		$fields['inscricaomunicipal'] = $value['inscricaomunicipal'];
		$fields['site'] = $value['site'];
		$fields['ddd'] = $value['ddd'];
		$fields['tel'] = $value['tel'];
		$fields['dddfax'] = $value['dddfax'];
		$fields['fax'] = $value['fax'];
		$fields['endereco'] = $value['endereco'];
		$fields['numero'] = $value['numero'];
		$fields['complemento'] = $value['complemento'];
		$fields['bairro'] = $value['bairro'];
		$fields['cep'] = $value['cep'];
		$fields['cidade'] = $value['cidade'];
		$fields['uf'] = $value['uf'];
		$fields['codgerenteconta'] = $value['codgerenteconta'];
		$fields['datacadastro'] = $value['datacadastro'];
		$fields['codstatusclassificacaolead'] = $value['codstatusclassificacaolead'];
		$fields['segmento'] = $value['segmento'];
		$fields['codatendente'] = $value['codatendente'];
		$fields['mailing'] = $value['mailing'];
		$fields['codmotivo'] = $value['codmotivo'];
		$fields['vencimentocontrato'] = $value['vencimentocontrato'];
		$fields['ativacao'] = $value['ativacao'];

		$sql = sqlinsert('leads', $fields);
		sql_query($sql);
		
		$codlead = mysql_insert_id();
		if(isset($value['contato'])){
			leads::salvarContatos($codlead, $value);
		}
		return $codlead;
	}
	
	function alterar($codlead, $value, $contatos = false){
		if(!isset($value['razaosocial'])) $value['razaosocial'] = null;
		if(!isset($value['nomefantasia'])) $value['nomefantasia'] = null;
		if(!isset($value['cnpj_cpf'])) $value['cnpj_cpf'] = null;
		if(!isset($value['ie'])) $value['ie'] = null;
		if(!isset($value['inscricaomunicipal'])) $value['inscricaomunicipal'] = null;
		if(!isset($value['site'])) $value['site'] = null;
		if(!isset($value['ddd'])) $value['ddd'] = null;
		if(!isset($value['tel'])) $value['tel'] = null;
		if(!isset($value['dddfax'])) $value['dddfax'] = null;
		if(!isset($value['fax'])) $value['fax'] = null;
		if(!isset($value['endereco'])) $value['endereco'] = null;
		if(!isset($value['numero'])) $value['numero'] = null;
		if(!isset($value['complemento'])) $value['complemento'] = null;
		if(!isset($value['bairro'])) $value['bairro'] = null;
		if(!isset($value['cep'])) $value['cep'] = null;
		if(!isset($value['cidade'])) $value['cidade'] = null;
		if(!isset($value['uf'])) $value['uf'] = null;
		if(!isset($value['codgerenteconta'])) $value['codgerenteconta'] = null;
		if(!isset($value['datacadastro'])) $value['datacadastro'] = null;
		if(!isset($value['codstatusclassificacaolead'])) $value['codstatusclassificacaolead'] = null;
		if(!isset($value['segmento'])) $value['segmento'] = null;
		if(!isset($value['codatendente'])) $value['codatendente'] = null;
		if(!isset($value['mailing'])) $value['mailing'] = null;
		if(!isset($value['codmotivo'])) $value['codmotivo'] = null;
		if(!isset($value['vencimentocontrato'])) $value['vencimentocontrato'] = null;
		if(!isset($value['ativacao'])) $value['ativacao'] = null;
		
		$sql = "Select * from leads Where CodLead = $codlead";
		$anterior = sql_query($sql);
		$anterior = mysql_fetch_array($anterior);
		
		$fields = array();
		$fields['razaosocial'] = $value['razaosocial'];
		$fields['nomefantasia'] = $value['nomefantasia'];
		$fields['cnpj_cpf'] = $value['cnpj_cpf'];
		$fields['ie'] = $value['ie'];
		$fields['inscricaomunicipal'] = $value['inscricaomunicipal'];
		$fields['site'] = $value['site'];
		$fields['ddd'] = $value['ddd'];
		$fields['tel'] = $value['tel'];
		$fields['dddfax'] = $value['dddfax'];
		$fields['fax'] = $value['fax'];
		$fields['endereco'] = $value['endereco'];
		$fields['numero'] = $value['numero'];
		$fields['complemento'] = $value['complemento'];
		$fields['bairro'] = $value['bairro'];
		$fields['cep'] = $value['cep'];
		$fields['cidade'] = $value['cidade'];
		$fields['uf'] = $value['uf'];
		$fields['codgerenteconta'] = $value['codgerenteconta'];
		$fields['datacadastro'] = $value['datacadastro'];
		$fields['codstatusclassificacaolead'] = $value['codstatusclassificacaolead'];
		$fields['segmento'] = $value['segmento'];
		$fields['codatendente'] = $value['codatendente'];
		$fields['mailing'] = $value['mailing'];
		$fields['codmotivo'] = $value['codmotivo'];
		$fields['vencimentocontrato'] = $value['vencimentocontrato'];
		$fields['ativacao'] = $value['ativacao'];

		$sql = sqlupdate('leads', $fields, ' CodLead = ' . mysqlnull($codlead));
		sql_query($sql);
		
		$sql = "Select * from leads Where CodLead = $codlead";
		$atual = sql_query($sql);
		$atual = mysql_fetch_array($atual);
		
		if($atual['CodGerenteConta'] != $anterior['CodGerenteConta']){
			$sql = "Select * From agendaslead a inner join agendagerenteconta agc on a.CodAgendaLead = agc.CodAgendaLead Where a.CodLead = " . mysqlnull($codlead) . " And a.DataHorario > NOW()";
			if(!empty($anterior['CodGerenteConta'])){
				$sql .= " And agc.CodGerenteConta = " . mysqlnull($anterior['CodGerenteConta']);
			}
			$rsagenda = sql_query($sql);
			while($rwagenda = mysql_fetch_array($rsagenda)){
				if(!empty($anterior['CodGerenteConta'])){
					$sql = "Delete From agendagerenteconta Where CodAgendaLead = " . mysqlnull($rwagenda['CodAgendaLead']) . " And CodGerenteConta = " . mysqlnull($anterior['CodGerenteConta']);
					sql_query($sql);
				}
				if(!empty($atual['CodGerenteConta'])){
					$sql = sqlinsert('agendagerenteconta', array('CodAgendaLead' => $rwagenda['CodAgendaLead'], 'CodGerenteConta' => $atual['CodGerenteConta']));
					sql_query($sql);
				}
			}
		}
		
		if(isset($value['contato'])){
			leads::salvarContatos($codlead, $value);
		}
		return true;
	}
	
	function excluir($codlead){
		$sql = "Select CodLead From leads Where CodLead = ".mysqlnull($codlead);
		$rs = sql_query($sql);
		if(mysql_num_rows($rs) == 0)
			return false;
		$sql = "Delete From ocorrenciaslead Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From agendaslead Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From modulosproposta Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From propostas Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From agendaretorno Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From contatoslead Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From leads Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		return true;
	}
}
?>
