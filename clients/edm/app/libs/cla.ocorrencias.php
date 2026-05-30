<?

//include_once "cla.agendaslead.php";

//include_once "cla.propostas.php";
include_once "cla.email.php";

class ocorrencias {
	function seminteresse($codlead,$codmotivo,$descricao,$vencimentocontrato,$qtdelinhas){		
		//Cancela os agendamentos
		$sql = "Select CodAgendaLead From agendaslead";
		$sql .= " Where CodLead = $codlead";
		$sql .= " And DataHorario > SYSDATE()";
		$sql .= " And CodStatus Is Null ";
		$rs = sql_query($sql);
		while($row = mysql_fetch_array($rs)){
			agendaslead::cancelar($row['CodAgendaLead'], $descricao);
		}
		mysql_free_result($rs);
		
		//Cancela as propostas
		$sql =""; 
		$sql.= "update n_propostas set dt_cancelamento=sysdate() where leads_pk=".$codlead;
		
		sql_query($sql);
		
		/*$sql = "Select CodProposta, Versao From propostas";
        $sql .= " Where CodLead = $codlead ";
        $sql .= " And Codproposta not in (Select codproposta from data_proposta where codlead = $codlead and (nome_data='ativacao' or nome_data='entrega_aparelho'))";
		$sql .= " And DataCancelamento is null ";
		$sql .= " And DataRecebimentoContrato is null ";
        $sql .= " And dt_vencimentocontrato is null ";
        
		$rs = sql_query($sql);	
		while($row = mysql_fetch_array($rs)){
			propostas::alterar($row['CodProposta'], $row['Versao'], $codlead, array('datacancelamento' => 'SYSDATE()', 'codmotivo' => $codmotivo, 'cancelamento' => $descricao));
		}
		mysql_free_result($rs);*/
		
		//Atualiza o Status do Lead
		
		$status = 1;
		$sql = "";
		$sql .= "Update leads ";
		$sql .= " set codmotivo = $codmotivo, ";
		$sql .= " CodStatusClassificacaoLead = $status ";
		if(!empty($qtdelinhas)){ 
			$sql .= " ,qtde_linhas = $qtdelinhas ";
		}
		if(!empty($vencimentocontrato)){ 		
			$sql .= " ,VencimentoContrato = '$vencimentocontrato' ";
		}
		$sql .= "Where CodLead = $codlead";
		
		sql_query($sql);
		
	}
	function alterarstatus($codlead, $codtipo){
		
		$sql = "select * ";
		$sql .= " from tipoocorrenciaslead ";
		$sql .= " where codtipoocorrencialead = $codtipo";
		
		$result = mysql_query($sql);
		if($row = mysql_fetch_array($result))
			$statustipo = $row['Status'];
		mysql_free_result($result);
		if($statustipo == 3){
			$sql = "Update leads set ";
			$sql .= " CodStatusClassificacaoLead = 3 ";
			$sql .= " Where CodLead = $codlead And CodStatusClassificacaoLead = 2";
			mysql_query($sql);
		}
	}
	
	function adicionar($value){
 
		$bolFecharAutomatica = false;
		$codlead = $value['codlead'];
		$acesso = $value['acesso'];
		if(!isset($value['codlead'])) return false;		
		if(!isset($value['descricao'])) $value['descricao'] = null;
		if(!isset($value['codtipoocorrencialead'])) return false;		
		if(!isset($value['datacadastro']) || is_null($value['datacadastro'])) $value['datacadastro'] = "SYSDATE()";
		if(!isset($value['datafechamento'])) $value['datafechamento'] = null;			
		if(!isset($value['codusuariointerno']) || is_null($value['codusuariointerno'])) $value['codusuariointerno'] = $_SESSION['codusuario'];
		if(!isset($value['ocorrenciasuperior'])) $value['ocorrenciasuperior'] = null;
		if(!empty($value['fecharagora'])) $value['datafechamento'] = 'SYSDATE()';
		//=============Fechar Ocorrencia Automatica=======
			if(is_null($value['datafechamento'])){
				$sql = "";
				$sql.="select Fechar ";
				$sql.=" from tipoocorrenciaslead ";
				$sql.=" where codtipoocorrencialead = ".$value['codtipoocorrencialead'];
				$result = mysql_query($sql);
				if($row = mysql_fetch_array($result))
					if($row['Fechar'] == 1)	{
						$value['datafechamento'] = " SYSDATE() ";
						$bolFecharAutomatica = true;
					}
				mysql_free_result($result);
			}
			$fields['codlead'] = $value['codlead'];
        
		//================SEM INTERESSE====================
			if(!empty($value['codmotivolead'])){
				$sql = "Select 
							si.descricao
						from motivoslead si
						where si.CodMotivolead=".$value['codmotivolead'];
	
					   	$result = mysql_query($sql);
						if($row = mysql_fetch_array($result)){
							$dsc_motivo = $row['descricao'];
						}	
						mysql_free_result($result);
					   
				$fields['descricao'] = ($value['descricao']." - Motivo Sem Interesse ".$dsc_motivo);
			}else{
				$fields['descricao'] = $value['descricao'];
			}
         
		//================Envio Carta Apresentacao Observacao===========
			if(!empty($value['envia_carta'])){
				$sql = "Select
							ep.cod_email_empresa
							,ep.identificacao
						from email_empresa ep
                        where status=1";
                
			   	$result = mysql_query($sql);
				if($row = mysql_fetch_array($result)){
					$identificacao = $row['identificacao'];
				}	
			}		
			if(!empty($value['envia_carta'])){
				$sql = "Select 
							ct.email 
						from contatoslead ct
				where ct.codcontatolead=".$value['codcontatolead'];
			   	$result = mysql_query($sql);
				if($row = mysql_fetch_array($result)){
					$email = $row['email'];
				}	
				mysql_free_result($result);
				$fields['descricao'] = ($value['descricao']." - Envio de Email ".$email." - Identificacao = ".$identificacao);
			}

		//==============================
		//Atualiza a data da ultima ocorrencia na tabela de leads. Esta data é utilizada principalmente no relatório de followup de leads.
		//Só atualiza a data se o tipo de ocorrência não estiver com a flag Fechar Ocorrência como "Sim"
		if(!$bolFecharAutomatica){
			$fields_lead['dt_ult_ocorrencia'] = "sysdate()";
			$sql = sqlupdate('leads', $fields_lead, " codlead = ".$fields['codlead']);
			mysql_query($sql);
		}

		//===================================================
		$fields['codtipoocorrencialead'] = $value['codtipoocorrencialead'];
		$fields['datacadastro'] = $value['datacadastro'];
		if(!empty($value['datafechamento'])){
			$fields['datafechamento'] = "SYSDATE()";
		}else{
			$fields['datafechamento'] = $value['datafechamento'];
		}
		$fields['codusuariointerno'] = $value['codusuariointerno'];
		$fields['ocorrenciasuperior'] = $value['ocorrenciasuperior'];
		$fields['agendadopara'] = $value['agendadopara'];
		$fields['dt_retorno'] = $value['dt_retorno'];
		
		$sql = sqlinsert('ocorrenciaslead', $fields);

		mysql_query($sql);
		$codocorrencialead = mysql_insert_id();
		
		//=======ENVIA EMAIL DA CARTA DE APRESENTACAO========
		if(!empty($value['envia_carta'])){
			$headers = $value['email_texto'];
			email::envia_email($value['cod_tipoemail'],$value['codlead'],$value['codcontatolead'],$headers,$descricao,$value['cod_email_empresa']);		
		}
		
		ocorrencias::alterarstatus($value['codlead'], $value['codtipoocorrencialead']);
		//=========SEM INTERESSE=============================
			if(!empty($value['codmotivolead'])){
				$cod_lead = $value['codlead'];
				$vencimentonovo=$value['vencimentocontrato'];
				$vencimentoantigo=$value['vencimento_contrato'];
				ocorrencias::seminteresse($value['codlead'],$value['codmotivolead'],$value['descricao'],$value['vencimentocontrato'],$value['qtde_linhas']);
				
				if(isset($value['operadoras'])) leads::salvarOperadoras($value['codlead'], $value['operadoras']);
				else leads::salvarOperadoras($codlead, '');			
				//GERA OCORRENCIA COM  POPUP PARA A DATA DE VENCIMENTO
				if(trim($vencimentoantigo) != trim($vencimentonovo)){
					if($vencimentonovo != ""){ 
						
						leads::adicionarOcorrenciaVencimentoContrato($cod_lead, $vencimentoantigo, $vencimentonovo);
			           	
		            }
				}
			}
		//ACESSO MOBILE
		if(!empty($acesso)){
			return array('codocorrencialead' => $codocorrencialead, 'codlead' => $codlead);
	    }else{
			return ($codocorrencialead);
		}	
		
	}
	function alterar($codocorrencialead, $value){
		

		if(!isset($value['descricao'])) $value['descricao'] = null;
		if(!isset($value['codtipoocorrencialead'])) $value['codtipoocorrencialead'] = null;
		if(!isset($value['datacadastro'])) $value['datacadastro'] = null;
		if(!isset($value['datafechamento'])) $value['datafechamento'] = null;
		if(!isset($value['codusuariointerno'])) $value['codusuariointerno'] = null;
		if(!isset($value['ocorrenciasuperior'])) $value['ocorrenciasuperior'] = null;
		if(!empty($value['fecharagora'])) $value['datafechamento'] = 'SYSDATE()';
		if(!empty($value['dt_retorno_fechamento'])) $value['dt_retorno_fechamento'] = 'SYSDATE()';
		if(!isset($value['dsc_retorno'])) $value['dsc_retorno'] = null;
		$codlead = $value['codlead'];
		$acesso = $value['acesso'];
		
		$fields['descricao'] = $value['descricao'];
		$fields['codtipoocorrencialead'] = $value['codtipoocorrencialead'];
		$fields['datacadastro'] = $value['datacadastro'];
		if(!empty($value['datafechamento'])){
			$fields['datafechamento'] = "SYSDATE()";
		}else{
			$fields['datafechamento'] = $value['datafechamento'];			
		}
		$fields['codusuariointerno'] = $value['codusuariointerno'];
		$fields['ocorrenciasuperior'] = $value['ocorrenciasuperior'];
		$fields['agendadopara'] = $value['agendadopara'];
		$fields['dt_retorno'] = $value['dt_retorno']; 
		$fields['dt_retorno_fechamento'] = $value['dt_retorno_fechamento'];		
		$fields['dsc_retorno'] = $value['dsc_retorno'];
		
		
		
		$sql = sqlupdate('ocorrenciaslead', $fields, " CodOcorrenciaLead = $codocorrencialead");	
		mysql_query($sql);
		
		if(permissao('retornofollowup', 'ic')){

			//================Follow Retorno==========================
			if(!empty($value['dt_retorno_fechamento'])){	
				if($value['codtipoocorrencialead'] == '5002'){
						$qtde_dias =$value['qtde_dias_retorno'];
						$sql ="";
		                $sql.="Select dt_retorno_fechamento from ocorrenciaslead where codocorrencialead= $codocorrencialead";
					    $rs = mysql_query($sql);
		                $row_rs = mysql_fetch_array($rs);
		                $dt_retorno_fechamento = $row_rs["dt_retorno_fechamento"];
		                mysql_free_result($rs);			
						
					    $value = array();

		                $value['codlead']=$codlead;
						$value['descricao'] = "Retorno Follow-up ";
		                $value['dt_retorno'] = date("Y-m-d H:i:s", (strtotime($dt_retorno_fechamento)+ $qtde_dias*86400));
						$value['agendadopara']= $_SESSION['codusuario'];
						$value['codtipoocorrencialead'] = 5002;
						$value['datacadastro']= 'SYSDATE()';
						$value['codusuariointerno']= $_SESSION['codusuario'];
						$value['agendadopara']= $_SESSION['codusuario'];
						
		                $sql = sqlinsert('ocorrenciaslead', $value);
						mysql_query($sql);
				}
			}
		}
		//ACESSO MOBILE
		if(!empty($acesso)){
			return array('codocorrencialead' => $codocorrencialead, 'codlead' => $codlead);
	    }else{
			return ($codocorrencialead);
		}
	}
	

	function excluir($codocorrencia){
		//EXCLUIR OCORRENCIAS
		$sql = sqldelete('ocorrenciaslead',' CodOcorrenciaLead = ' . mysqlnull($codocorrencia));
		sql_query($sql);		
		
		return ;
	}

	function addtipo($values){
		
        $values['status_pk'] = ($values['status_pk'] == ''?0:$values['status_pk']);
		$values['Status'] = ($values['Status'] == ''?0:$values['Status']);
		$values['Automatica'] = ($values['Automatica'] == ''?0:$values['Automatica']);
		$values['Fechar'] = ($values['Fechar'] == ''?0:$values['Fechar']);
		$values['Minutos'] = ($values['Minutos'] == '' ? 0 : $values['Minutos']);
		//CODIGO OPERADOR NAO OBRIGATORIO QUE RELACIONA O TIPO DA OCORRENCIA AO SEGUMENTO E A EMPRESA OPERDORA
		$values['cod_operador'] = ($values['cod_operador'] == ''?0 : $values['cod_operador']);
		$sql = "insert into tipoocorrenciaslead (Descricao, Status, Automatica, Fechar , Minutos,cod_operador)";
		$sql .= "values (".mysqlnull($values['Descricao']).", ".mysqlnull($values['Status']).", ".mysqlnull($values['Automatica']).", ".mysqlnull( $values['Fechar'] ) . ", " . mysqlnull( $values['Minutos'] ) .", " . mysqlnull( $values['cod_operador'] ).  ")";
		mysql_query($sql) or die(mysql_error());
		return "Tipo de Ocorrencia cadastrada com sucesso.";
	}
	//CLASSE COMENTADA E DESNECESSARIA JA QUE A CONSULTA DOS TIPOS ESTA DIRETO NA PAGINA
	/*function listtipo(){
		$sql = "select t.CodTipoOcorrenciaLead, t.Descricao, s.Descricao Status, t.Automatica, t.Fechar , t.Minutos
				from tipoocorrenciaslead t left join statusclassificacaolead s on t.Status = s.CodStatusClassificacaoLead order by t.Descricao";
		$result = mysql_query($sql);
		return $result;
	}*/

	function gettipo($cod){
		$sql = "select * from tipoocorrenciaslead where CodTipoOcorrenciaLead = $cod";
		$result = mysql_query($sql);
		return $result;
	}

	function edittipo($values){
       
        
		$values['Status'] = ($values['Status'] == ''?0:$values['Status']);
		$values['Automatica'] = ($values['Automatica'] == ''?0:$values['Automatica']);
		$values['Fechar'] = ($values['Fechar'] == ''?0:$values['Fechar']);
		$values['Minutos'] = ($values['Minutos'] == ''?0:$values['Minutos']);
		//CODIGO OPERADOR NAO OBRIGATORIO QUE RELACIONA O TIPO DA OCORRENCIA AO SEGUMENTO E A EMPRESA OPERDORA
		$values['cod_operador'] = ($values['cod_operador'] == ''?0 : $values['cod_operador']);
        $values['stautus_pk'] = ($values['stautus_pk'] == ''?0 : $values['stautus_pk']);
		$sql = "update tipoocorrenciaslead set Descricao = ".mysqlnull($values['Descricao']).", ";
		$sql .= "Status = ".mysqlnull($values['Status']).", ";
        $sql .= "status_pk = ".mysqlnull($values['status_pk']).", ";
		$sql .= "Automatica = ".mysqlnull($values['Automatica']).", ";
		$sql .= "Fechar = ".mysqlnull($values['Fechar']) . ", ";
		$sql .= "cod_operador = ".mysqlnull($values['cod_operador']) . ", ";
		$sql .= "Minutos = ". mysqlnull($values['Minutos']);
        
		$sql .= " where CodTipoOcorrenciaLead = ".$values['CodTipoOcorrenciaLead'];

        mysql_query($sql);
		return "Tipo de Ocorrencia editada com sucesso.";
	}

	function deltipo($cod){
		$sql = "delete from tipoocorrenciaslead where CodTipoOcorrenciaLead = ".mysqlnull($cod);
		mysql_query($sql);
		return "Tipo de Ocorrencia excluida com sucesso.";
	}

}?>
