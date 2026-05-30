<?	include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.leads.php";
	include_once "../../libs/cla.ocorrencias.php";
	include_once "../../libs/datas.php";
class propostas {	  
	
    function datalead($codproposta, $codlead, $nomedata, $valordata){
		
		if($nomedata=='ativacao'){
			
			//pesquisa o produto da proposta
			$sql ="select p.codproduto, pp.vigenciacontrato ";
			$sql.="  from propostas p ";
			$sql.="	      inner join produtos pp on p.codproduto = pp.codproduto ";
			$sql.=" where p.codproposta = $codproposta ";
			$rs_produto = mysql_query($sql);
			$row_produto = mysql_fetch_array($rs_produto);
			$vigenciacontrato = $row_produto['vigenciacontrato'];
			mysql_free_result($rs_produto);
			
			//FUNCAO QUE SOMA A DATA
			$vencimento_contrato = '';
			$vencimento_contrato = SomarData($valordata, 0, $vigenciacontrato, 0);
			
			$ativacao = "";
			$ativacao = $valordata;
			
			//INSERE A DATA DE VENCIMENTO 
			$sql = sqlupdate('leads', array("vencimentocontrato" => dataYMD($vencimento_contrato), "ativacao" => dataYMD($ativacao)), 'codlead = ' . $codlead);
			sql_query($sql);
			
		}
	}
	function marcarBase($status, $codlead){
		
		//verifica se a operadora base já está cadastrada para o lead
		$sql ="";
		$sql.="select count(*) total ";
		$sql.="  from leads_operadoras ";
		$sql.=" where codlead = $codlead ";
		$sql.="   and cod_operadora = 8 ";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$total = $row['total'];
		mysql_free_result($result);
		
		//se for cliente, insere o registro "Base" nas operadoras. Só será cadastrado quando o parametro base não foi selecionado
		if ($status == 15 && $total == 0){
			$sql ="";
			$sql.="insert into leads_operadoras(cod_operadora, codlead) values(8, $codlead) ";
			mysql_query($sql);
		}
		//fim do registro da operadora.	
	}
	function salvarModulos($codproposta, $versao, $codlead, $value){
		if(!isset($value['codproduto'])){
			return false;
		}
		$codproduto = $value['codproduto'];
		$sql = "select * from modulosproposta where codproposta = " . mysqlnull($codproposta) . " and versao = " . mysqlnull($versao) . " and codlead = " . mysqlnull($codlead);
		$result = sql_query($sql);
		if(mysql_num_rows($result) == 0){
			mysql_free_result($result);
			$sql = "select * from modulosproduto where codproduto = " . mysqlnull($codproduto);            
			$result = sql_query($sql);
            
		}        
		while($row = mysql_fetch_array($result)){
			$id = $row['ID'];            
            set_time_limit(100);
			$modulos[$id] = array(
				'nome' => $row['Nome'],
				'tipo' => $row['Tipo'],
				'valor' => $row['Valor'],
				'calculado' => null,
				'valorfixo' => $row['ValorFixo'],
				'obrigatorio' => $row['Obrigatorio'],
				'eval' => $row['Eval'],
				'hidden' => $row['Hidden'],
				'grupo' => $row['Grupo'],
                'rotulo' => $row['rotulo']);
			$modulo = $modulos[$id];
			
            if(isset($value['modulo'][$id])){
				if($modulo['eval'] != 1 && $modulo['valorfixo'] != 1 && $modulo['tipo'] != 10 && $modulo['tipo'] != 12){
					switch($modulo['tipo']){
						case 1: //String
							if(isset($value['modulo'][$id]) && $value['modulo'][$id] != "")
								$modulo['valor'] = $value['modulo'][$id];
							break;
						case 2: //Inteiro
							if(isset($value['modulo'][$id]) && is_numeric($value['modulo'][$id]))
								$modulo['valor'] = $value['modulo'][$id];
							break;
						case 3: //Moeda
							if(isset($value['modulo'][$id]) && is_numeric($value['modulo'][$id]))
								$modulo['valor'] = $value['modulo'][$id];
							break;
						case 4: //Data
							if(isset($value['modulo'][$id]) && ereg('^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/[0-9]{4}$', $value['modulo'][$id]))
								$modulo['valor'] = DataYMD($value['modulo'][$id]);
							break;
						case 5: //Hora
							if(isset($value['modulo'][$id]) && ereg('^([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$', $value['modulo'][$id]))
								$modulo['valor'] = $value['modulo'][$id];
							break;
						case 6: //Hora Curta
							if(isset($value['modulo'][$id]) && ereg('^([01][0-9]|2[0-3]):[0-5][0-9]$', $value['modulo'][$id]))
								$modulo['valor'] = $value['modulo'][$id];
							break;
						case 7: //Ponto Flutuante
						if(isset($value['modulo'][$id]) && is_numeric($value['modulo'][$id]))
								$modulo['valor'] = $value['modulo'][$id];
							break;
						case 8: //Lista
							$tmp = explode('|', $modulo['valor']);
							$ret = null;
							foreach($tmp as $opt){
								ereg('(\*?)([^=]*)=?(.*)', $opt, $reg);
								$reg[3] = (empty($reg[3])?$reg[2]:$reg[3]);
								if($value['modulo'][$id] == $reg[2])
									$ret[] = '*' . $reg[2] . '=' . $reg[3];
								else
									$ret[] = $reg[2] . '=' . $reg[3];
							}
							$modulo['valor'] = implode('|', $ret);
							break;
						case 9: //Lista Multipla
							$tmp = explode('|', $modulo['valor']);
							$ret = null;
							foreach($tmp as $opt){
								ereg('(\*?)([^=]*)=?(.*)', $opt, $reg);
								$reg[3] = (empty($reg[3])?$reg[2]:$reg[3]);
								if(in_array($reg[2], $value['modulo'][$id]))
									$ret[] = '*' . $reg[2] . '=' . $reg[3];
								else
									$ret[] = $reg[2] . '=' . $reg[3];
							}
							$modulo['valor'] = implode('|', $ret);
							break;
						case 10: //Array
							break;
						case 11: //Valor x Quantidade
							$tmp = explode('|', $modulo['valor']);
							$valor = (isset($tmp[0])?$tmp[0]:null);
							$qtde = (isset($tmp[1])?$tmp[1]:null);
							$qtde = (isset($value['modulo'][$id]['quantidade'])?$value['modulo'][$id]['quantidade']:$qtde);
							$modulo['valor'] = $valor . '|' . $qtde;
							break;
					}
				}
				$modulos[$id]['valor'] = $modulo['valor'];
                
			}
		}
		mysql_free_result($result);
		$sql = "delete from modulosproposta where CodProposta = " . mysqlnull($codproposta) . " and Versao = " . mysqlnull($versao) . " and CodLead = " . mysqlnull($codlead);
		sql_query($sql);
		foreach($modulos as $id => $modulo){
			$modulo['codproposta'] = $codproposta;
			$modulo['codlead'] = $codlead;
			$modulo['versao'] = $versao;
			$modulo['id'] = $id;
			if($modulo['eval'] == 1){
				$modulo['calculado'] = moduloValor($modulos, $id);
			}
			$sql = sqlinsert('modulosproposta', $modulo);
			            
            sql_query($sql);
		}
		if(isset($modulos['totalproposta'])){
			$sql = sqlupdate('propostas', array('TotalProposta' => moduloValor($modulos, 'totalproposta')), "CodProposta = " . mysqlnull($codproposta) . " And CodLead = " . mysqlnull($codlead) . " And Versao = " . mysqlnull($versao));
			sql_query($sql);
		}
	}
	//CADASTRO DA PROPOSTA
	function adicionar($value, $modulos = true){
		if(!isset($value['codlead'])) $value['codlead'] = null;
		if(!isset($value['datacadastro'])) $value['datacadastro'] = null;
		if(!isset($value['datacancelamento'])) $value['datacancelamento'] = null;
		if(!isset($value['codmotivo'])) $value['codmotivo'] = null;
		if(!isset($value['cancelamento'])) $value['cancelamento'] = null;
		if(!isset($value['observacao'])) $value['observacao'] = null;
		if(!isset($value['codproduto'])) $value['codproduto'] = null;
		if(!isset($value['codocorrencialead'])) $value['codocorrencialead'] = null;
		if(!isset($value['totalproposta'])) $value['totalproposta'] = (isset($value['totalgeral'])?$value['totalgeral']:null);
		if(!isset($value['valorcontrato'])) $value['valorcontrato'] = null;
		if(!isset($value['numpvc'])) $value['numpvc'] = null;
		if(!isset($value['estorno'])) $value['estorno'] = null;
		if(!isset($value['tipoestorno'])) $value['tipoestorno'] = null;
		if(!isset($value['codusuariointerno'])) $value['codusuariointerno'] = null;
		//if(!isset($value['experto'])) $value['experto'] = null;
		if(!isset($value['status_experto'])) $value['status_experto'] = null;
		//COD AGENDA LEAD
        if(!isset($value['codagendalead'])) $value['codagendalead'] = null;
        
        
		//VERIFICA SE O CNPJ É VALIDO E ESTA PREENCHIDO
		if($value['envio_contrato_operadora']){
			$sql = "SELECT CNPJ_CPF FROM leads WHERE CodLead = ".$value['codlead'];
			$result = sql_query($sql);
			if($cnpj = mysql_result($result,0)){
				mysql_free_result($result);
				if(!$cnpj){
					javascriptalert("O CNPJ desse lead não foi cadastrado. Só é possível inserir a data de envio após o cadastro de um CNPJ válido.");
					exit();
				}
			}else{
				javascriptalert("O CNPJ desse lead não foi cadastrado. Só é possível inserir a data de envio após o cadastro de um CNPJ válido.");
				exit();
			}
		}
		//VERIFICA O ULTIMO CODIGO DE PROPOSTA REGISTRADO NA BASE
		if(empty($value['codproposta'])){
			$sql = "Select Max(CodProposta) CodProposta From propostas";
			$result = sql_query($sql);
			if($row = mysql_fetch_array($result))
				$value['codproposta'] = $row['CodProposta'];
			$value['codproposta']++;
			mysql_free_result($result);
		}
		//VERIFICA A ULTIMA VERSAO DA PROPOSTA CADASTRADA
		if(empty($value['versao'])){
			$sql = "Select Max(Versao) Versao From propostas Where codproposta = " . mysqlnull($value['codproposta']);
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			if($row){
				$value['versao'] = $row['Versao'];
			}
			mysql_free_result($result);
			$value['versao']++;
		}
		
		//ARRAY DAS VARIAVEIS PASSADAS DO FORMULARIO
		$fields = array();
		$fields['codproposta'] = $value['codproposta'];
		$fields['versao'] = $value['versao'];
		$fields['codlead'] = $value['codlead'];
		$fields['datacadastro'] = $value['datacadastro'];
		$fields['datacancelamento'] = $value['datacancelamento'];
		$fields['codmotivo'] = $value['codmotivo'];
		$fields['cancelamento'] = $value['cancelamento'];		
		$fields['observacao'] = $value['observacao'];
		$fields['codproduto'] = $value['codproduto'];
		$fields['codocorrencialead'] = $value['codocorrencialead'];
		$fields['totalproposta'] = $value['totalproposta'] = (isset($value['totalgeral'])?$value['totalgeral']:null);
		$fields['valorcontrato'] = $value['valorcontrato'];
		$fields['numpvc'] = $value['numpvc'];
		$fields['estorno'] = $value['estorno'];
		$fields['tipoestorno'] = $value['tipoestorno'];
		$fields['codusuariointerno'] = $value['codusuariointerno'];
		//$fields['experto'] = $value['experto'];
		$fields['status_experto'] = $value['status_experto'];
        //COD AGENDA LEAD
        $fields['codagendalead'] = $value['codagendalead'];
		
		
		//QUERY DE INSERT DA PROPOSTA
		$sql = sqlinsert('propostas', $fields);				

		sql_query($sql);
		//CHAMA FUNCAO DE INSERT DOS MODULOS		
		if(isset($value['modulo'])){
			propostas::salvarModulos($fields['codproposta'], $fields['versao'], $fields['codlead'], $value);
		}	
		
		//INSERT OCORRRENCIA DA PROPOSTA
		$descricao = "Proposta " . $value['codproposta'] . " Versão " . $value['versao'];		
		$value['codocorrencialead'] = ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricao, 'codtipoocorrencialead' => 6));
				
		//UPDATE NA PROPOSTA INSERT DO CODIGO DA OCORRENCIA DE GERAÇÃO DA PROPOSTA
		if(!isset($value['codocorrencialead'])) $value['codocorrencialead'] = null;
		$fields = array(		
			'codocorrencialead' => $value['codocorrencialead']
		);
		$sql = sqlupdate('propostas', $fields, " CodProposta = " . $value['codproposta'] . " AND Versao = " . $value['versao'] . " AND CodLead = " . $value['codlead']);
		sql_query($sql);
		
		$sql = "Select * From propostas Where CodProposta = " . mysqlnull($value['codproposta']) . " And Versao = " . $value['versao'] . " And CodLead = " . $value['codlead'];
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		mysql_free_result($rs);	
		
		//
		if(!empty($row['DataCancelamento'])){			
			$sql = sqlupdate('ocorrenciaslead', array('DataFechamento' => 'SYSDATE()'), "(CodOcorrenciaLead = " . mysqlnull($row['CodOcorrenciaLead']) . " Or OcorrenciaSuperior = " . mysqlnull($row['CodOcorrenciaLead']) . ") And DataFechamento Is Null");
			sql_query($sql);
			if(!empty($row['CodMotivo'])){
				$sql = "Select Descricao from motivoslead Where CodMotivoLead = " . $row['CodMotivo'];
				$rs = sql_query($sql);
				$motivo = null;
				if($row1 = mysql_fetch_array($rs)){
					$motivo = $row1['Descricao'];
				}
				mysql_free_result($rs);
			}
			$motivo .= " - " . $row['Cancelamento'];
			$descricao = "Proposta " . $value['codproposta'] . " Versão " . $value['versao'] . " - Data: " . date('d/m/Y', strtotime($row['DataCancelamento'])) . " - " . $motivo;
			$sql = "Select * from ocorrenciaslead where OcorrenciaSuperior = {$row['CodOcorrenciaLead']} And CodTipoOcorrenciaLead = 31";
			$result = sql_query($sql);
			if($row1 = mysql_fetch_array($result))
				ocorrencias::alterar($row1['CodOcorrenciaLead'], array('descricao' => $descricao));
			else
				ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricao, 'codtipoocorrencialead' => 32, 'ocorrenciasuperior' => $row['CodOcorrenciaLead']));
			mysql_free_result($result);
			if($row['DataCancelamento']){
				$status = 3;
				$sql = "Select * From agendaslead where CodLead = " . $value['codlead'] . " And DataCancelamento Is Null";
				$rs = sql_query($sql);
				if(mysql_num_rows($rs) > 0){
					$status = 4;
				}
				mysql_free_result($rs);
				$sql = "Select * From propostas where CodLead = " . $value['codlead'] . " And DataCancelamento Is Null";
				$rs = sql_query($sql);
				while($row1 = mysql_fetch_array($rs)){
					if(empty($row1['DataRecebimentoContrato'])){
						if(!empty($row1['DataEnvio']))
							$status = 5;
						if(!empty($row1['DataPrevisaoRecebimento']))
							$status = 6;
					}
					if(!empty($row1['DataRecebimento']) && $status < 10)
						$status = 10;
					if(!empty($row1['DataRetornoDocumento']) && $status < 10)
						$status = 12;
					if(!empty($row1['DataEntregaAparelho']) && $status < 10)
						$status = 15;
				}
				mysql_free_result($rs);
				$sql = "Update leads set CodStatusClassificacaoLead = $status Where CodLead = " . $value['codlead'];
				sql_query($sql);
			}
		}else{			
			//INSERE AS DATAS DA PROPOSTA E GERA OCORRENCIAS
			$sql = "Select 
				dpo.cod_data_proposta_operador
				,dpo.dsc_data
				,dpo.obs_data
				,dpo.nome_data
				,dpo.codtipoocorrencialead
				,p.cod_operador
			from data_proposta_operador dpo
			inner join produtos p on dpo.cod_operador = p.cod_operador";			
			$sql .= " where p.codproduto = ". $value['codproduto'];			
			$sql .= " and dpo.dat_canc is null";
			$sql .= " order by dpo.ordem ";	
			
			$result = sql_query($sql);
			while($row = mysql_fetch_array($result)){
				 if(!empty($value[$row['nome_data']])){
					
				 	//INSERE OS PARAMETROS DE DATA E OBSERVACAO NA TABELA RELACIONAL A PROPOSTA				 
				 	$sql = sqlinsert('data_proposta', array('codproposta' => $value['codproposta'],'versao' => $value['versao'],'codlead' => $value['codlead'],'nome_data' => $row['nome_data'],'valor_data' => dataYMD($value[$row['nome_data']]),'obs_data' => "obs_".$row['nome_data'],'cod_data_proposta_operador' => $row['cod_data_proposta_operador'],'valor_obs' => $value["obs_".$row['nome_data']]));
				 	sql_query($sql);
					
					//ATUALIZA A DATA DE VENCIMENTO DO CONTATRATO - COMENTADA POR DOUGLAS EM 28/05/2011
					if($row['nome_data']=='ativacao'){		
						
                                $sql = " Select
                                  p.vigenciacontrato
                                from produtos p
                                where p.codproduto=".$value['codproduto'];
                                
                        $produto = sql_query($sql);
                           if($row_produto = mysql_fetch_array($produto)){
							$vigenciacontrato = $row_produto['vigenciacontrato'];
						  }	        
			
							if(!empty($vigenciacontrato)){
								$fields1['dt_vencimentocontrato'] =  dataYMD(SomarData(($value[$row['nome_data']]), 0, $vigenciacontrato, 0));
							}else{
								$fields1['dt_vencimentocontrato'] =  dataYMD(SomarData(($value[$row['nome_data']]), 0, '24', 0));
							}
												
						$sql = sqlupdate('propostas', $fields1, " CodProposta = " . mysqlnull($value['codproposta']) . " AND Versao = " . mysqlnull($value['versao']) . " AND CodLead = " . mysqlnull($value['codlead']));
						sql_query($sql);
					} 
					//INSERE AS OCORRENCIAS E ATUALIZA O STATUS DO LEAD CONFORME O TIPO DA OCORRENCIA
					if(!empty($row['codtipoocorrencialead'])){
						//INSERE AS OCORRENCIAS
						//ATRIBUI A DESCRICA DADOS COMPLEMENTARES
						$complementar = "";	
						if(!empty($value['status_experto']) and ($row['nome_data']=='experto' or $row['nome_data']=='pre_analise_financeira')){												
							
							switch($value['status_experto']){
								case 1: //REPROVADO
									$complementar = "Reprovado";
								break;
								case 2: //APROVADO
									$complementar = "Aprovado";
								break;
								case 3: //Submeter a análise de crédito
									$complementar = "Submeter a análise de crédito";
								break;
								
							}
							#INSERI A OCORRENCIA QUANDO FOR DE EXPERTO
							
							$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $value['codlead'],'CodUsuarioInterno' =>  $value['codusuariointerno'] ,'DataCadastro' => "SYSDATE()",'DataFechamento' => "SYSDATE()",'codtipoocorrencialead' =>  $row['codtipoocorrencialead'],'descricao' => "Proposta " . $value['codproposta'] . " Versão " . $value['versao'] . " - Data: " . $value[$row['nome_data']]."-  ".$value["obs_".$row['nome_data']]."-  ".$complementar));
						}else{
							
							#INSERI A OCORRENCIA QUANDO FOR DIFERENTE DE EXPERTO
							$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $value['codlead'],'CodUsuarioInterno' =>  $value['codusuariointerno'] ,'DataCadastro' => "SYSDATE()",'DataFechamento' => "SYSDATE()",'codtipoocorrencialead' =>  $row['codtipoocorrencialead'],'descricao' => "Proposta " . $value['codproposta'] . " Versão " . $value['versao'] . " - Data: " . $value[$row['nome_data']]."-  ".$value["obs_".$row['nome_data']]));
 						}
						sql_query($sql);
						//ALTERA O STATUS DO LEAD
						$sql = "Select
									t.status
								from tipoocorrenciaslead t
								where codtipoocorrencialead=".$row['codtipoocorrencialead'];
						$sql .=" and t.status > 0";
						
						$result1 = sql_query($sql);	
						$row1 = mysql_fetch_array($result1);
						if($row1['status'] > 0){
							
							$sql = sqlupdate('leads', array('codstatusclassificacaolead' => $row1['status']), 'codlead = ' . $value['codlead']);
							sql_query($sql);
							
							//marca como base 
							propostas::marcarBase($row1['status'], $value['codlead']);
							
						}
					}
				 }
			}
		}
		return array('codproposta' => $value['codproposta'], 'versao' => $value['versao'], 'codlead' => $value['codlead']);
	}
	function alterar($codproposta, $versao, $codlead, $value, $modulos = false){
		if(!isset($value['codlead'])) $value['codlead'] = null;
		if(!isset($value['datacadastro'])) $value['datacadastro'] = null;
		if(!isset($value['datacancelamento'])) $value['datacancelamento'] = null;
		if(!isset($value['codmotivo'])) $value['codmotivo'] = null;
		if(!isset($value['cancelamento'])) $value['cancelamento'] = null;
		if(!isset($value['observacao'])) $value['observacao'] = null;
		if(!isset($value['codproduto'])) $value['codproduto'] = null;
		if(!isset($value['codocorrencialead'])) $value['codocorrencialead'] = null;
		if(!isset($value['totalproposta'])) $value['totalproposta'] = (isset($value['totalgeral'])?$value['totalgeral']:null);
		if(!isset($value['valorcontrato'])) $value['valorcontrato'] = null;
		if(!isset($value['numpvc'])) $value['numpvc'] = null;
		if(!isset($value['estorno'])) $value['estorno'] = null;
		if(!isset($value['tipoestorno'])) $value['tipoestorno'] = null;
		if(!isset($value['codusuariointerno'])) $value['codusuariointerno'] = null;
		//if(!isset($value['experto'])) $value['experto'] = null;
		if(!isset($value['status_experto'])) $value['status_experto'] = null;
		//VERIFICA SE O CNPJ É VALIDO E ESTA PREENCHIDO
		if($value['envio_contrato_operadora']){
			$sql = "SELECT CNPJ_CPF FROM leads WHERE CodLead = ".$value['codlead'];
			$result = sql_query($sql);
			if($cnpj = mysql_result($result,0)){
				mysql_free_result($result);
				if(!$cnpj){
					javascriptalert("O CNPJ desse lead não foi cadastrado. Só é possível inserir a data de envio após o cadastro de um CNPJ válido.");
					exit();
				}
			}else{
				javascriptalert("O CNPJ desse lead não foi cadastrado. Só é possível inserir a data de envio após o cadastro de um CNPJ válido.");
				exit();
			}
		}
		//VERIFICA O ULTIMO CODIGO DE PROPOSTA REGISTRADO NA BASE
		if(empty($value['codproposta'])){
			$sql = "Select Max(CodProposta) CodProposta From propostas";
			$result = sql_query($sql);
			if($row = mysql_fetch_array($result))
				$value['codproposta'] = $row['CodProposta'];
			$value['codproposta']++;
			mysql_free_result($result);
		}
		//VERIFICA A ULTIMA VERSAO DA PROPOSTA CADASTRADA
		if(empty($value['versao'])){
			$sql = "Select Max(Versao) Versao From propostas Where codproposta = " . mysqlnull($value['codproposta']);
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			if($row){
				$value['versao'] = $row['Versao'];
			}
			mysql_free_result($result);
			$value['versao']++;
		}
		
		//ARRAY DAS VARIAVEIS PASSADAS DO FORMULARIO
		$fields = array();
		//$fields['codproposta'] = $codproposta;
		//$fields['versao'] = $versao;
		//$fields['codlead'] = $codlead;
		$fields['datacadastro'] = $value['datacadastro'];
		$fields['datacancelamento'] = $value['datacancelamento'];
		$fields['codmotivo'] = $value['codmotivo'];
		$fields['cancelamento'] = $value['cancelamento'];		
		$fields['observacao'] = $value['observacao'];
		$fields['codproduto'] = $value['codproduto'];
		$fields['codocorrencialead'] = $value['codocorrencialead'];
		$fields['totalproposta'] = $value['totalproposta'] = (isset($value['totalgeral'])?$value['totalgeral']:null);
		$fields['valorcontrato'] = $value['valorcontrato'];
		$fields['numpvc'] = $value['numpvc'];
		$fields['estorno'] = $value['estorno'];
		$fields['tipoestorno'] = $value['tipoestorno'];
		$fields['codusuariointerno'] = $value['codusuariointerno'];
		$fields['status_experto'] = $value['status_experto'];
		
		//QUERY DE Update DA PROPOSTA
		
		//Dados da proposta
		$sql = "SELECT * FROM propostas WHERE CodProposta = " . mysqlnull($codproposta) . " AND Versao = " . mysqlnull($versao) . " AND CodLead = " . mysqlnull($codlead);
		
		$rs = sql_query($sql);
		$last = mysql_fetch_array($rs);
		mysql_free_result($rs);	
			
		$sql = sqlupdate('propostas', $fields, " CodProposta = " . mysqlnull($codproposta) . " AND Versao = " . mysqlnull($versao) . " AND CodLead = " . mysqlnull($codlead));
		 
		sql_query($sql);
		//CHAMA FUNCAO DE INSERT DOS MODULOS
		if(isset($value['modulo'])){
			propostas::salvarModulos($codproposta, $versao, $codlead, $value);
		}	

		$sql = "Select * From propostas Where CodProposta = " . $codproposta. " And Versao = " . $versao . " And CodLead = " . $codlead;
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		mysql_free_result($rs);	
		
		//
		if(!empty($row['DataCancelamento'])){			
			
			$sql = sqlupdate('ocorrenciaslead', array('DataFechamento' => 'SYSDATE()'), "(CodOcorrenciaLead = " . mysqlnull($row['CodOcorrenciaLead']) . " Or OcorrenciaSuperior = " . mysqlnull($row['CodOcorrenciaLead']) . ") And DataFechamento Is Null");
			sql_query($sql);
			if(!empty($row['CodMotivo'])){
				$sql = "Select Descricao from motivoslead Where CodMotivoLead = " . $row['CodMotivo'];
				$rs = sql_query($sql);
				$motivo = null;
				if($row1 = mysql_fetch_array($rs)){
					$motivo = $row1['Descricao'];
				}
				mysql_free_result($rs);
			}
			$motivo .= " - " . $row['Cancelamento'];
			$descricao = "Proposta " . $codproposta . " Versão " . $versao . " - Data: " . date('d/m/Y', strtotime($row['DataCancelamento'])) . " - " . $motivo;
			$sql = "Select * from ocorrenciaslead where OcorrenciaSuperior = {$row['CodOcorrenciaLead']} And CodTipoOcorrenciaLead = 31";
			$result = sql_query($sql);
			if($row1 = mysql_fetch_array($result))
				ocorrencias::alterar($row1['CodOcorrenciaLead'], array('descricao' => $descricao));
			else
				ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => $descricao, 'codtipoocorrencialead' => 32, 'ocorrenciasuperior' => $row['CodOcorrenciaLead']));
			mysql_free_result($result);
			if($row['DataCancelamento']){
				$status = 3;
				$sql = "Select * From agendaslead where CodLead = " . $codlead . " And DataCancelamento Is Null";
				$rs = sql_query($sql);
				if(mysql_num_rows($rs) > 0){
					$status = 4;
				}
				mysql_free_result($rs);
				$sql = "Select * From propostas where CodLead = " . $codlead . " And DataCancelamento Is Null";
				$rs = sql_query($sql);
				while($row1 = mysql_fetch_array($rs)){
					if(empty($row1['DataRecebimentoContrato'])){
						if(!empty($row1['DataEnvio']))
							$status = 5;
						if(!empty($row1['DataPrevisaoRecebimento']))
							$status = 6;
					}
					if(!empty($row1['DataRecebimento']) && $status < 10)
						$status = 10;
					if(!empty($row1['DataRetornoDocumento']) && $status < 10)
						$status = 12;
					if(!empty($row1['DataEntregaAparelho']) && $status < 10)
						$status = 15;
				}
				mysql_free_result($rs);
				$sql = "Update leads set CodStatusClassificacaoLead = $status Where CodLead = " . $codlead;
				sql_query($sql);
			}
		}else{		
			//UPDATE AS DATAS DA PROPOSTA E GERA OCORRENCIAS
			$sql = "Select 
						dp.cod_data_proposta
						,dp.nome_data
						,DATE_FORMAT(dp.valor_data, '%Y-%m-%d') as valor_data
						,dp.valor_obs
						,dp.cod_data_proposta_operador
						,pro.cod_operador
					from data_proposta dp
					inner join propostas p on dp.codproposta =  p.codproposta and dp.versao = p.versao and dp.codlead = p.codlead
					inner join produtos pro on p.codproduto = pro.codproduto ";
			$sql .= "	where dp.codproposta=".$codproposta;
			$sql .= "		and dp.versao=".$versao;
			$sql .= "		and dp.codlead=".$codlead;
			
			
			$result = sql_query($sql);
			while($row = mysql_fetch_array($result)){
				
				if(empty($value[$row['nome_data']])){

					$valor_data = 'null';
					//VERIFICA SE A DATA E A DATA DE PREVISAO SE FOR INSERE A OCORRENCA 
					if($row['nome_data']=='previsao_recebe_assinatura'){
						$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $codlead,'CodUsuarioInterno' =>  $value['codusuariointerno'] ,'DataCadastro' => "SYSDATE()",'DataFechamento' => "SYSDATE()",'codtipoocorrencialead' =>  '29','descricao' => "Proposta " . $codproposta . " Versão " . $versao . " - Sem Previsão"));
				 	sql_query($sql);
						
						$sql = sqlupdate('leads', array('codstatusclassificacaolead' => '5'), 'codlead = ' . $codlead);
						sql_query($sql);
					}
				}else{
					$valor_data = dataYMD($value[$row['nome_data']]);
					if($row['nome_data']=='previsao_recebe_assinatura'){

						if($valor_data != $row['valor_data']){
							$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $codlead,'CodUsuarioInterno' =>  $value['codusuariointerno'] ,'DataCadastro' => "SYSDATE()",'DataFechamento' => "SYSDATE()",'codtipoocorrencialead' =>  '29','descricao' => "Proposta " . $codproposta . " Versão " . $versao . " Data - ". $value[$row['nome_data']]));
							sql_query($sql);
						
							$sql = sqlupdate('leads', array('codstatusclassificacaolead' => '6'), 'codlead = ' . $codlead);
							sql_query($sql);
						}
						
					}
				}
				
				$sql = sqlupdate('data_proposta', array('valor_data' =>$valor_data,'valor_obs'=>$value["obs_".$row['nome_data']]), 'cod_data_proposta = ' . $row['cod_data_proposta']);
				sql_query($sql);	
			    
              	//ATUALIZA A DATA DE VENCIMENTO DO CONTATRATO - COMENTADA POR DOUGLAS EM 28/05/2011
					if($row['nome_data']=='ativacao'){						
                                $sql = " Select
                                  p.vigenciacontrato
                                from produtos p
                                where p.codproduto=".$value['codproduto'];
                                
                        $produto = sql_query($sql);
                           if($row_produto = mysql_fetch_array($produto)){
							$vigenciacontrato = $row_produto['vigenciacontrato'];
						  }	        
			
							if(!empty($vigenciacontrato)){
								$fields1['dt_vencimentocontrato'] =  dataYMD(SomarData(($value[$row['nome_data']]), 0, $vigenciacontrato, 0));
							}else{
								$fields1['dt_vencimentocontrato'] =  dataYMD(SomarData(($value[$row['nome_data']]), 0, '24', 0));
							}
												
						$sql = sqlupdate('propostas', $fields1, " CodProposta = " . mysqlnull($value['codproposta']) . " AND Versao = " . mysqlnull($value['versao']) . " AND CodLead = " . mysqlnull($value['codlead']));
						sql_query($sql);
					}
				
			}  
			$sql = "Select 
				dpo.cod_data_proposta_operador
				,dpo.dsc_data
				,dpo.obs_data
				,dpo.nome_data
				,dpo.codtipoocorrencialead
				,p.cod_operador
			from data_proposta_operador dpo
			inner join produtos p on dpo.cod_operador = p.cod_operador";			
			$sql .= " where p.codproduto = ". $value['codproduto'];			
			$sql .= " and dpo.nome_data not in(Select 
						dp.nome_data
					from data_proposta dp
				where dp.codproposta=$codproposta
					and dp.versao=$versao
				and dp.codlead=$codlead)";
			$sql .= " and dpo.dat_canc is null";
			$sql .= " order by dpo.ordem ";	

			$result = sql_query($sql);
			while($row = mysql_fetch_array($result)){				
				 if(!empty($value[$row['nome_data']])){
				 	//INSERE OS PARAMETROS DE DATA E OBSERVACAO NA TABELA RELACIONAL A PROPOSTA				 
				 	$sql = sqlinsert('data_proposta', array('codproposta' => $codproposta,'versao' => $versao,'codlead' => $codlead,'nome_data' => $row['nome_data'],'valor_data' => dataYMD($value[$row['nome_data']]),'obs_data' => "obs_".$row['nome_data'],'cod_data_proposta_operador' => $row['cod_data_proposta_operador'],'valor_obs' => $value["obs_".$row['nome_data']]));
				 	sql_query($sql);  
					
					//ATUALIZA A DATA DE VENCIMENTO DO CONTATRATO
					if($row['nome_data']=='ativacao'){		
	
						//INSERE A DATA DE VENCIMENTO COMENTADA POR DOUGLAS EM 14-04-2011
						//propostas::datalead($value['codproposta'], $value['codlead'], $row['nome_data'], $value[$row['nome_data']]);
						//ropostas::datalead($vencimento_contrato,$value['codlead'],'VencimentoContrato');
						
					//ATUALIZA A DATA DE VENCIMENTO DO CONTATRATO - COMENTADA POR DOUGLAS EM 28/05/2011
					if($row['nome_data']=='ativacao'){						
                                $sql = " Select
                                  p.vigenciacontrato
                                from produtos p
                                where p.codproduto=".$value['codproduto'];
                                
                        $produto = sql_query($sql);
                           if($row_produto = mysql_fetch_array($produto)){
							$vigenciacontrato = $row_produto['vigenciacontrato'];
						  }	        
			
							if(!empty($vigenciacontrato)){
								$fields1['dt_vencimentocontrato'] =  dataYMD(SomarData(($value[$row['nome_data']]), 0, $vigenciacontrato, 0));
							}else{
								$fields1['dt_vencimentocontrato'] =  dataYMD(SomarData(($value[$row['nome_data']]), 0, '24', 0));
							}
												
						$sql = sqlupdate('propostas', $fields1, " CodProposta = " . mysqlnull($value['codproposta']) . " AND Versao = " . mysqlnull($value['versao']) . " AND CodLead = " . mysqlnull($value['codlead']));
						sql_query($sql);
					}
					}
					//INSERE AS OCORRENCIAS E ATUALIZA O STATUS DO LEAD CONFORME O TIPO DA OCORRENCIA
					if(!empty($row['codtipoocorrencialead'])){
						//INSERE AS OCORRENCIAS
						//ATRIBUI A DESCRICA DADOS COMPLEMENTARES
						$complementar = "";								
						if(!empty($value['status_experto']) and ($row['nome_data']=='experto' or $row['nome_data']=='pre_analise_financeira')){												
							
							switch($value['status_experto']){
								case 1: //REPROVADO
									$complementar = "Reprovado";
								break;
								case 2: //APROVADO
									$complementar = "Aprovado";
								break;
								case 3: //Submeter a análise de crédito
									$complementar = "Submeter a análise de crédito";
								break;
								
							}
							#INSERI A OCORRENCIA QUANDO FOR DE EXPERTO							
							$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $codlead,'CodUsuarioInterno' =>  $value['codusuariointerno'] ,'DataCadastro' => "SYSDATE()",'DataFechamento' => "SYSDATE()",'codtipoocorrencialead' =>  $row['codtipoocorrencialead'],'descricao' => "Proposta " . $codproposta . " Versão " . $versao . " - Data: " . $value[$row['nome_data']]."-  ".$value["obs_".$row['nome_data']]."-  ".$complementar));
						}else{							
							#INSERI A OCORRENCIA QUANDO FOR DIFERENTE DE EXPERTO
							$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $codlead,'CodUsuarioInterno' =>  $value['codusuariointerno'] ,'DataCadastro' => "SYSDATE()",'DataFechamento' => "SYSDATE()",'codtipoocorrencialead' =>  $row['codtipoocorrencialead'],'descricao' => "Proposta " . $codproposta . " Versão " . $versao . " - Data: " . $value[$row['nome_data']]."-  ".$value["obs_".$row['nome_data']]));
 						}
						

						sql_query($sql);
						//ALTERA O STATUS DO LEAD
						$sql = "Select
									t.status
								from tipoocorrenciaslead t
								where codtipoocorrencialead=".$row['codtipoocorrencialead'];
						$sql .=" and t.status > 0";		
						$result1 = sql_query($sql);	
						
						$row1 = mysql_fetch_array($result1);
						if($row1['status'] > 0){
							$sql = sqlupdate('leads', array('codstatusclassificacaolead' => $row1['status']), 'codlead = ' . $codlead);
							sql_query($sql);
							
							//se for cliente, insere o registro "Base" nas operadoras.
							propostas::marcarBase($row1['status'], $codlead);
							//fim do registro da operadora.
						}
					}
				 }
			} 
			
		}
		return true;
	}
	function excluir($codproposta, $versao, $codlead){
		$sql = "Select * From propostas Where CodProposta =" . mysqlnull($codproposta) . " And Versao =" . mysqlnull($versao) . " And CodLead =" . mysqlnull($codlead);
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		if(!$row)
			return false;
		$codocorrencialead = $row['CodOcorrenciaLead'];
		mysql_free_result($rs);
		if(!empty($codocorrencialead)){
			ocorrencias::excluir($codocorrencialead);
			$sql = "Delete From ocorrenciaslead Where CodOcorrenciaLead = " . mysqlnull($codocorrencialead) . " Or OcorrenciaSuperior = " . mysqlnull($codocorrencialead);
			sql_query($sql);
		}
		$sql = "Delete From modulosproposta Where CodProposta = " . mysqlnull($codproposta) . " And Versao = " . mysqlnull($versao) . " And CodLead = " . mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From data_proposta Where CodProposta = " . mysqlnull($codproposta) . " And Versao = " . mysqlnull($versao) . " And CodLead = " . mysqlnull($codlead);
		sql_query($sql);
		//$sql = "Delete From propostas Where CodProposta = " . mysqlnull($codproposta) . " And Versao = " . mysqlnull($versao) . " And CodLead = " . mysqlnull($codlead);
		//sql_query($sql);
		
		$sql = sqldelete('propostas','CodProposta = ' . mysqlnull($codproposta));
		sql_query($sql);
		
		
		return true;
	}
// PropostaImp.php
	function montarHTMLModulo($id){
		global $modulos;
		global $tmpmodulos;
		global $Root;
		$ret = '';
		if(!isset($modulos[$id]))
			return null;
		$modulo = $modulos[$id];
		$val = null;
		if($modulo['hidden'] == 1){
			return null;
		}
		
		switch($modulo['tipo']){
			case 1: //String
				//print "teste1";
				//$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id).'</span>';
				//print $ret; 
				break;
			case 2: //Inteiro
				$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id, null, true).'</span>';
				break;
			case 3: //Moeda
				$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id, null, true).'</span>';
				break;
			case 4: //Data
				$ret = '<span id="'.$id.'">'.moduloValor($modulos, $id).'</span>';
				break;
			case 5: //Hora
				$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id).'</span>';
				break;
     		case 6: //Hora Curta
				$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id).'</span>';
				break;
			case 7: //Ponto Flutuante
				$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id, null, true).'</span>';
				break;
			case 8: //Lista
				$tmp = explode('|', $modulo['valor']);
				$ret.='<span id="'.$id.'">';
				foreach($tmp as $opt){
					ereg('(\*?)([^=]*)=?(.*)', $opt, $reg);
					$reg[3] = (empty($reg[3])?$reg[2]:$reg[3]);
					if(!empty($reg[1]))
						$ret.= $reg[3].'<br />';
				}
				$ret.='</span>';
				break;
			case 9: //Lista Múltipla
				$tmp = explode('|', $modulo['valor']);
				$ret.='<span id="'.$id.'">';
				foreach($tmp as $opt){
					ereg('(\*?)([^=]*)=?(.*)', $opt, $reg);
					$reg[3] = (empty($reg[3])?$reg[2]:$reg[3]);
					if(!empty($reg[1]))
						$ret.= $reg[3].'<br />';
				}
				$ret.='</span>';
				break;
			case 10: //Array
				$ret = null;
				break;
			case 11: //Valor x Quantidade
				$ret = '<span id="'.$id.'.valor" >'.moduloValor($modulos, $id, 'valor', true).'</span>';
				$ret.= '&nbsp;x&nbsp;';
				$ret.= '<span id="'.$id.'.quantidade">'.moduloValor($modulos, $id, 'quantidade', true).'</span>';
				$ret .= '&nbsp;=&nbsp;<span id="'.$id.'">'.moduloValor($modulos, $id, null, true).'</span>';
				break;
			case 12: //HTML
				$tmp = $modulo['valor'];
				while(ereg('(#([A-Za-z][A-Za-z0-9]+);)', $tmp, $reg)){;
					$html = propostas::montarHTMLModulo($reg[2]);
					$tmp = str_replace($reg[1], $html, $tmp);
					unset($tmpmodulos[$reg[2]]);
				}
				$ret = $tmp;
		}
		return $ret;
	}
	function SalvarCampos(){
		global $codproposta;
		global $versao;
		foreach($_REQUEST as $campo => $valor){
			$sql = "Update camposproposta Set Valor = " . mysqlnull($valor) . " where codproposta = " . mysqlnull($codproposta) . " and versao = " . mysqlnull($versao) . " and nome = " . mysqlnull($campo);
			sql_query($sql);
		}
	}
	function variavelValor($var, $format = false){
		/*indices de $variavel
		0 - Variável completa
		1 - Fonte
		2 - Campo e Valor Default
		3 - Campo
		4 - Valor Default com delimitador
		5 - Valor Default
		6 - Size com Delimitador
		7 - Size*/
		global $modulos;
		global $continput;
		global $codproposta;
		global $versao;
		global $variavel;
		$fonte = $var[1];
		$campo = $var[3];
		$default = propostas::parseString($var[5], true);
		$size = $var[7];
		if(isset($variavel[$fonte])){
			return $variavel[$fonte][$campo];
		}
		switch($fonte){
			case 'input':
				$html = '';
				$continput++;
				$name = 'input' . $continput;
				$rs = sql_query("SELECT Valor FROM camposproposta WHERE CodProposta = " . mysqlnull($codproposta) . " AND Versao = " . mysqlnull($versao) . " AND Nome = " . mysqlnull($name) . " AND Tipo = " . mysqlnull($campo));
				$row = mysql_fetch_assoc($rs);
				mysql_free_result($rs);
				sql_query("DELETE FROM camposproposta WHERE CodProposta = " . mysqlnull($codproposta) . " AND Versao = " . mysqlnull($versao) . " AND Nome = " . mysqlnull($name));
				if($row && !empty($row['Valor'])){
					if($campo == 'image'){
						$info = pathinfo($default);
						$default = $info['dirname'] . '/';
						$info = pathinfo($row['Valor']);
						$default .= $info['basename'];
					}else{
						$default = $row['Valor'];
					}
				}
				sql_query(sqlinsert('camposproposta', array('codproposta' => $codproposta, 'versao' => $versao, 'nome' => $name, 'tipo' => $campo, 'valor' => $default)));
				if(isset($_REQUEST['visimp'])){
					$valor = @$_REQUEST[$name];
					if(empty($valor))
						return null;
					switch($campo){
						case 'string':
						case 'data':
						case 'hora':
						case 'horacurta':
						case 'email':
						case 'cnpj':
						case 'cep':
							return $valor;
						case 'numero':
							return number_format($valor, 0, ',', '.');
						case 'moeda':
							return 'R$ ' . number_format($valor, 2, ',', '.');
						case 'textarea':
							return str_replace(chr(13).chr(10), $valor);
						case 'image':
							if(!empty($_REQUEST[$name]))
								$default = $_REQUEST[$name];
							$info = pathinfo($default);
							$path = $info['dirname'] . '/';
							$file = $info['basename'];
							if($file == '.')
								return null;
							$ret = basename($file, '.' . $info['extension']);
							//$ret .= '<br /><img src=".' . $path . $file . '" height="155px" />';
							$ret .= '<br /><img src="../..' . $path . $file . '" height="155px" />';
							return $ret;
					}
				}
				switch($campo){
					case 'string':
						if($size == 0)
							$size = 50;
						$html = '<input type="text" name="'.$name.'" size="'.$size.'" validate="datatype=string" value="'.$default.'" />';
						break;
					case 'numero':
						if($size == 0)
							$size = 10;
						$html = '<input type="text" name="'.$name.'" size="'.$size.'" maxlength="10" validate="datatype=numeric;decimals=2" value="'.$default.'" />';
						break;
					case 'moeda':
						if($size == 0)
							$size = 10;
						$html = '<input type="text" name="'.$name.'" size="'.$size.'" maxlength="10" validate="datatype=numeric;decimals=2" value="'.$default.'" />';
						break;
					case 'data':
						$html = '<input type="text" name="'.$name.'" size="10" maxlength="10" validate="datatype=date" value="'.$default.'" />';
						break;
					case 'hora':
						$html = '<input type="text" name="'.$name.'" size="8" maxlength="8" validate="datatype=time" value="'.$default.'" />';
						break;
					case 'horacurta':
						$html = '<input type="text" name="'.$name.'" size="5" maxlength="5" validate="datatype=shorttime" value="'.$default.'" />';
						break;
					case 'email':
						if($size == 0)
							$size = 50;
					$html = '<input type="text" name="'.$name.'" size="'.$size.'" validate="datatype=email" value="'.$default.'" />';
						$size = '20';
						break;
					case 'cnpj':
						$html = '<input type="text" name="'.$name.'" size="18" maxlength="18" validate="datatype=cnpj" value="'.$default.'" />';
						break;
					case 'cep':
						$html = '<input type="text" name="'.$name.'" size="9" maxlength="9" validate="datatype=cep" value="'.$default.'" />';
						break;
					case 'textarea':
						$html = '<textarea name="'.$name.'" rows="5" cols="60">'.$default.'</textarea>';
						break;
					case 'image': //#input.imagem[folder]
					$info = pathinfo($default);
					
					$defaultfile = $info['basename'];				
					
					$sql = "Select
							a.imagem
							,a.nomeaparelho
							,f.dsc_fabricante
							from aparelhos a
							left join fabricante f on a.cod_fabricante = f.cod_fabricante
							where Status=1
							group by a.nomeaparelho
							order by a.codaparelho,a.nomeaparelho";
					$result = sql_query($sql);
					$html = '<select name="' . $name . '">';
					$html .= '<option value="' . $path . './" onclick="alteraImagem(\'' . $name . '\', \'.\')">&nbsp;</option>';					
						while($row = mysql_fetch_array($result)){																									
							$html .= '<option value="/images/aparelhos/'. $row['imagem'] . '"' . ($row['imagem'] == $defaultfile?'selected="selected"':'')  . '\')">'. $row['dsc_fabricante'].' '. $row['nomeaparelho'] . '</option>';
						}					
					$html .= '</select>';
					//$html .= '<br /><img id="' . $name . '" src="../../images/aparelhos/'  . $defaultfile . '" width="30%" />';
						
					
					/*$info = pathinfo($default);
					$path = $info['dirname'] . '/';
					$defaultfile = $info['basename'];
					$files = scandir('../..' . $path);
					sort($files);
					$html = '<select name="' . $name . '">';
					$html .= '<option value="' . $path . './" onclick="alteraImagem(\'' . $name . '\', \'.\')">&nbsp;</option>';
					foreach($files as $file){
						$info = pathinfo($path . $file);
						if(ereg('(jpg|gif|bmp|png)$', $info['basename'])){	
							$sql = "Select
							a.Imagem
							,a.nomeaparelho
							from aparelhos a
							where Status=1	
							and imagem='".basename($info['basename'])."'";								
							//print $sql."<br>";
							$result = sql_query($sql);	
							$row = mysql_fetch_array($result);
							if($row['Imagem'] == basename($info['basename'])){	
								echo $path . $file ."<br>";			
								$html .= '<option value="' . $path . $file . '"' . ($file == $defaultfile?'selected="selected"':'') . ' onclick="alteraImagem(\'' . $name . '\',\'' . $path . $file . '\')">' . basename($info['basename'], '.' . $info['extension']) . '</option>';
							}
						}
					}
						$html .= '</select>';
						//$html .= '<br /><img id="' . $name . '" src=".' . $path . $defaultfile . '" width="30%" />';*/
				}
				return $html;
				break;
			default:
				return moduloValor($modulos, $fonte, $campo, $format);
				break;
		}
		return null;
	}
	function parseString($string, $format = false){
		while(ereg('#\{([^}]+)\}\{', $string, $reg)){
			$tmp = html_entity_decode($reg[1]);
			$tmp = propostas::parseString($tmp, false);
			$condicao = false;
			@eval('$condicao = (' . $tmp . ');');
			$start = strpos($string, $reg[0]);
			$cont = 1;
			$i = strlen($reg[0]) + 1;
			while($cont > 0){
				$char = substr($string, $start + $i, 1);
				if($char == '{')
					$cont++;
				elseif($char == '}')
					$cont--;
				$i++;
			}
			$retorno = substr($string, $start + strlen($reg[0]), $i - strlen($reg[0]) - 1);
			if($condicao)
				$retorno = propostas::parseString($retorno, true);
			else
				$retorno = '';
			$string = substr_replace($string, $retorno, $start, $i);
		}
		while(ereg('#\[([^]|]*)(\|([^]]*))?\]\(([^)]\))', $string, $reg)){
			$start = strpos($string, $reg[0]);
			$func = $reg[1].'('.parseString(html_entity_decode($reg[4])).')';
			$tmp = null;
			eval('$tmp = '.$func.';');
			$string = substr_replace($string, $tmp, $start, strlen($reg[0]));
		}
		while(ereg('#([a-z0-9]+)(.([a-z_]+)(\[([^]]*)])?(\[([^]]*)])?)?\;', $string, $reg)){
			$start = strpos($string, $reg[0]);
			$string = substr_replace($string, propostas::variavelValor($reg, $format), $start, strlen($reg[0]));
		}
		return $string;
	}
// PropostaNew.php
//#[PHP Function|Javascript Function]
	function montarInputModulo($id){
		global $modulos;
		global $tmpmodulos;
		global $data;
		global $Root;
		$ret = null;
		if(empty($modulos[$id]))
			return null;
		$modulo = $modulos[$id];
		$val = null;
		if($modulo['obrigatorio'] == '1')
			$val = 'required';
		if($modulo['hidden'] == 1){
			return null;
		}
		switch($modulo['tipo']){
			case 1: //String
				if((empty($data['dataenvio']) && empty($data['datacancelamento']) || $Root || permissao('propostaenvio', 'al')) && $modulo['valorfixo'] == 0)
					$ret.='<input type="text" id="'.$id.'" name="modulo['.$id.']" value="'.moduloValor($modulos, $id).'" size="50" maxlength="255" '.(!empty($val)?'validate="required"':null).' onchange="calcularModulos()" />';
				else
					$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id).'</span>';
				break;
			case 2: //Inteiro
				if((empty($data['dataenvio']) && empty($data['datacancelamento']) || $Root || permissao('propostaenvio', 'al')) && $modulo['valorfixo'] == 0)
					$ret.='<input type="text" id="'.$id.'" name="modulo['.$id.']" value="'.moduloValor($modulos, $id).'" size="10" maxlength="10" validate="datatype=numeric'.(!empty($val)?';required':null).'" onchange="calcularModulos()" />';
				else
					$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id, null, true).'</span>';
				break;
			case 3: //Moeda
				if((empty($data['dataenvio']) && empty($data['datacancelamento']) || $Root || permissao('propostaenvio', 'al')) && $modulo['valorfixo'] == 0){
					$ret.='R$&nbsp;<input type="text" id="'.$id.'" name="modulo['.$id.']" value="'.moduloValor($modulos, $id).'" size="10" maxlength="10" validate="datatype=numeric;decimals=2'.(!empty($val)?";required":null).'" onchange="calcularModulos()" />';
				}else{
					$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id, null, true).'</span>';
				}
				break;
			case 4: //Data
				if((empty($data['dataenvio']) && empty($data['datacancelamento']) || $Root || permissao('propostaenvio', 'al')) && $modulo['valorfixo'] == 0)
					$ret.='<input type="text" id="'.$id.'" name=modulo["'.$id.']" value="'.moduloValor($modulos, $id).'" size="10" maxlength="10" validate="datatype=date'.(!empty($val)?";required":null).'" onchange="calcularModulos()" />';
				else
					$ret = '<span id="'.$id.'">'.moduloValor($modulos, $id).'</span>';
				break;
			case 5: //Hora
				if((empty($data['dataenvio']) && empty($data['datacancelamento']) || $Root || permissao('propostaenvio', 'al')) && $modulo['valorfixo'] == 0)
					$ret.='<input type="text" id="'.$id.'" name="modulo['.$id.']" value="'.moduloValor($modulos, $id).'" size="8" maxlength="8" validate="datatype=time'.(!empty($val)?";required":null).'" onchange="calcularModulos()" />';
				else
					$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id).'</span>';
				break;
			case 6: //Hora Curta
				if((empty($data['dataenvio']) && empty($data['datacancelamento']) || $Root || permissao('propostaenvio', 'al')) && $modulo['valorfixo'] == 0)
					$ret.='<input type="text" id="'.$id.'" name="modulo['.$id.']" value="'.moduloValor($modulos, $id).'" size="6" maxlength="6" '.($modulo['valorfixo']==1?'readonly="readonly"':'').' validate="datatype=shorttime'.(!empty($val)?";required":null).'" onchange="calcularModulos()" />';
				else
					$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id).'</span>';
				break;
			case 7: //Ponto Flutuante
				if((empty($data['dataenvio']) && empty($data['datacancelamento']) || $Root || permissao('propostaenvio', 'al')) && $modulo['valorfixo'] == 0)
					$ret.='<input type="text" id="'.$id.'" name="modulo['.$id.']" value="'.moduloValor($modulos, $id).'" size="10" maxlength="10" '.(!empty($val)?";required":null).'" onchange="calcularModulos()" />';
				else
					$ret.= '<span id="'.$id.'">'.moduloValor($modulos, $id, null, true).'</span>';
				break;
			case 8: //Lista
				if((empty($data['dataenvio']) && empty($data['datacancelamento']) || $Root || permissao('propostaenvio', 'al')) && $modulo['valorfixo'] == 0){
					$tmp = explode('|', $modulo['valor']);
					$ret.='<select id="'.$id.'" name="modulo['.$id.']" '.($val!=''?'validate="required"':'').' onkeypress="calcularModulos()" onchange="calcularModulos()" >';
					foreach($tmp as $opt){
						ereg('(\*?)([^=]*)=?(.*)', $opt, $reg);
						$reg[3] = (empty($reg[3])?$reg[2]:$reg[3]);
						if(!empty($reg[1]))
							$ret.='<option value="'.$reg[2].'" selected="selected">'.$reg[3].'</option>';
						else
							$ret.='<option value="'.$reg[2].'">'.$reg[3].'</option>';
					}
					$ret.='</select>';
				}else{
					$tmp = explode('|', $modulo['valor']);
					$ret = array();
					foreach($tmp as $opt){
						ereg('(\*?)([^=]*)=?(.*)', $opt, $reg);
						$reg[3] = (empty($reg[3])?$reg[2]:$reg[3]);
						if(!empty($reg[1])){
							$ret[] = $reg[3];
						}
					}
					$ret = '<span id="'.$id.'">' . implode('<br />', $ret) . '</span>';
				}
				break;
			case 9: //Lista Múltipla
				if((empty($data['dataenvio']) && empty($data['datacancelamento']) || $Root || permissao('propostaenvio', 'al')) && $modulo['valorfixo'] == 0){
					$tmp = explode('|', $modulo['valor']);
					$ret.='<select id="'.$id.'" name="modulo['.$id.'][]" size="8" multiple="multiple" '.($val!=''?'validate="required"':'').' onkeypress="calcularModulos()" onchange="calcularModulos()" >';
					foreach($tmp as $opt){
						ereg('(\*?)([^=]*)=?(.*)', $opt, $reg);
						$reg[3] = (empty($reg[3])?$reg[2]:$reg[3]);
						if(!empty($reg[1]))
							$ret.='<option value="'.$reg[2].'" selected="selected">'.$reg[3].'</option>';
						else
							$ret.='<option value="'.$reg[2].'">'.$reg[3].'</option>';
					}
					$ret.='</select>';
				}else{
					$tmp = explode('|', $modulo['valor']);
					$ret = array();
					foreach($tmp as $opt){
						ereg('(\*?)([^=]*)=?(.*)', $opt, $reg);
						$reg[3] = (empty($reg[3])?$reg[2]:$reg[3]);
						if(!empty($reg[1])){
							$ret[] = $reg[3];
						}
					}
					$ret = '<span id="'.$id.'">' . implode('<br />', $ret) . '</span>';
				}
				break;
			case 10: //Array
				break;
			case 11: //Valor x Quantidade
				if(empty($data['dataenvio']) && empty($data['datacancelamento']) || $Root || permissao('propostaenvio', 'al')){
					$ret = moduloValor($modulos, $id, 'valor', true);
					$ret.= '&nbsp;x&nbsp;';
					if($modulo['valorfixo'] == 0)
						$ret.= '<input type="text" id="'.$id.'.quantidade" name="modulo['.$id.'][quantidade]" value="'.moduloValor($modulos, $id, 'quantidade', true).'" size="10" maxlength="10" validate="datatype=numeric'.(!empty($val)?";required":null).'" onchange="calcularModulos()" />';
					else
						$ret.= moduloValor($modulos, $id, 'quantidade', true);
					$ret .= '&nbsp;=&nbsp;<span id="'.$id.'">'.moduloValor($modulos, $id, null, true).'</span>';
				}else{
					$ret = moduloValor($modulos, $id, 'valor', true);
					$ret.= '&nbsp;x&nbsp;';
					$ret.= moduloValor($modulos, $id, 'quantidade', true);
					$ret .= '&nbsp;=&nbsp;<span id="'.$id.'">'.moduloValor($modulos, $id, null, true).'</span>';
				}
			break;
			case 12: //HTML
				$tmp = $modulo['valor'];
				while(ereg('(#([A-Za-z][A-Za-z0-9]+);)', $tmp, $reg)){;
					$html = propostas::montarInputModulo($reg[2]);
					$tmp = str_replace($reg[1], $html, $tmp);
					unset($tmpmodulos[$reg[2]]);
				}
				$ret = $tmp;
		}
		return $ret;
	}
	function getEnvByUsr($usr,$dti,$dtf,$dti2,$dtf2){
//		$dbnames = get_dbnames();
//		$ret = 0;
//		foreach($dbnames as $dbname => $dbname1){
//			if($dbname == 'uniglobe' || $dbname == 'sorocaba_voip'){
			if($_SESSION['bd'] == 'uniglobe' || $_SESSION['bd'] == 'sorocaba_voip'){
				$sql = "SELECT COUNT(distinct p.CodLead) AS a FROM propostas AS p
				INNER JOIN leads as l ON l.CodLead = p.CodLead
				INNER JOIN ocorrenciaslead as o ON l.CodLead = o.CodLead
				WHERE l.CodGerenteConta = $usr
				AND p.DataCancelamento IS null
				AND o.CodTipoOcorrenciaLead = 77";
				if($dti && $dtf){
					$sql .= " AND o.DataCadastro BETWEEN ". mysqlnull(date('Y-m-d', $dti).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
				}else if($dti){
					$sql .= " AND o.DataCadastro >= ". mysqlnull(date('Y-m-d', $dti).' 00:00:00');
				}else if($dtf){
					$sql .= " AND o.DataCadastro <= ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
				}else{
					$sql .= " AND o.DataCadastro IS NOT null";
				}
				if($dti2 && $dtf2){
					$sql .= " AND p.DataAtivacao BETWEEN ". mysqlnull(date('Y-m-d', $dti2).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf2).' 23:59:59');
				}else if($dti2){
					$sql .= " AND p.DataAtivacao >= ". mysqlnull(date('Y-m-d', $dti2).' 00:00:00');
				}else if($dtf2){
					$sql .= " AND p.DataAtivacao <= ". mysqlnull(date('Y-m-d', $dtf2).' 23:59:59');
				}
//				$sql .= " GROUP BY l.CodLead";
				$a = mysql_fetch_array(sql_query($sql));
//				$a = mysql_fetch_array(sql_query($sql, $dbname));
				$ret = $a['a'];
			}else{
				$sql = "SELECT COUNT(distinct p.CodLead) AS a FROM propostas AS p
				INNER JOIN leads as l ON l.CodLead = p.CodLead
				WHERE l.CodGerenteConta = $usr
				AND p.DataCancelamento IS null";
				if($dti && $dtf){
					$sql .= " AND p.DataEnvioContrato BETWEEN ". mysqlnull(date('Y-m-d', $dti).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
				}else if($dti){
					$sql .= " AND p.DataEnvioContrato >= ". mysqlnull(date('Y-m-d', $dti).' 00:00:00');
				}else if($dtf){
					$sql .= " AND p.DataEnvioContrato <= ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
			}else{
					$sql .= " AND p.DataEnvioContrato IS NOT null";
				}
				if($dti2 && $dtf2){
					$sql .= " AND p.DataAtivacao BETWEEN ". mysqlnull(date('Y-m-d', $dti2).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf2).' 23:59:59');
				}else if($dti2){
					$sql .= " AND p.DataAtivacao >= ". mysqlnull(date('Y-m-d', $dti2).' 00:00:00');
				}else if($dtf2){
					$sql .= " AND p.DataAtivacao <= ". mysqlnull(date('Y-m-d', $dtf2).' 23:59:59');
				}
				$a = mysql_fetch_array(sql_query($sql));
				$ret = $a['a'];
			}
//		}
		return $ret;
	}
	function getDetVendas($usr,$dti,$dtf,$dti2,$dtf2){
		$dti = ($dti=='undefined'?null:$dti);
		$dtf = ($dtf=='undefined'?null:$dtf);
		$dti2 = ($dti2=='undefined'?null:$dti2);
		$dtf2 = ($dtf2=='undefined'?null:$dtf2);
//		$dbnames = get_dbnames();
//		$retnum = 0;
//		foreach($dbnames as $dbname => $dbname1){
			if($_SESSION['bd'] == 'uniglobe' || $_SESSION['bd'] == 'sorocaba_voip'){
				$sql = "SELECT MAX(DATE_FORMAT(o.DataCadastro,'%d/%m/%Y')) AS data,
				l.RazaoSocial AS lead,
				l.CodLead AS CodLead
				FROM propostas AS p
				INNER JOIN leads as l ON l.CodLead = p.CodLead
				INNER JOIN ocorrenciaslead as o ON l.CodLead = o.CodLead
				WHERE l.CodGerenteConta = $usr
				AND p.DataCancelamento IS null
				AND o.CodTipoOcorrenciaLead = 77";
				if($dti && $dtf){
					$sql .= " AND o.DataCadastro BETWEEN ". mysqlnull(date('Y-m-d', $dti).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
				}else if($dti){
					$sql .= " AND o.DataCadastro >= ". mysqlnull(date('Y-m-d', $dti).' 00:00:00');
				}else if($dtf){
					$sql .= " AND o.DataCadastro <= ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
				}else{
					$sql .= " AND o.DataCadastro IS NOT null";
				}
				if($dti2 && $dtf2){
					$sql .= " AND p.DataAtivacao BETWEEN ". mysqlnull(date('Y-m-d', $dti2).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf2).' 23:59:59');
				}else if($dti2){
					$sql .= " AND p.DataAtivacao >= ". mysqlnull(date('Y-m-d', $dti2).' 00:00:00');
				}else if($dtf2){
					$sql .= " AND p.DataAtivacao <= ". mysqlnull(date('Y-m-d', $dtf2).' 23:59:59');
				}
				$sql .= " GROUP BY l.CodLead
				ORDER BY o.DataCadastro DESC";
				$ret = sql_query($sql);
//				$ret[$retnum] = sql_query($sql, $dbname);
//				$retnum++;
			}else{
				$sql = "SELECT MAX(DATE_FORMAT(p.DataEnvioContrato,'%d/%m/%Y')) AS data,
				l.RazaoSocial AS lead,
				l.CodLead AS CodLead
				FROM propostas AS p
				INNER JOIN leads AS l ON p.CodLead = l.CodLead
				WHERE l.CodGerenteConta = $usr AND p.DataCancelamento IS null";
				if($dti && $dtf){
					$sql .= " AND p.DataEnvioContrato BETWEEN ". mysqlnull(date('Y-m-d', $dti).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
				}else if($dti){
				$sql .= " AND p.DataEnvioContrato >= ". mysqlnull(date('Y-m-d', $dti).' 00:00:00');
				}else if($dtf){
					$sql .= " AND p.DataEnvioContrato <= ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
				}else{
					$sql .= " AND p.DataEnvioContrato IS NOT null";
				}
				if($dti2 && $dtf2){
					$sql .= " AND p.DataAtivacao BETWEEN ". mysqlnull(date('Y-m-d', $dti2).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf2).' 23:59:59');
				}else if($dti2){
					$sql .= " AND p.DataAtivacao >= ". mysqlnull(date('Y-m-d', $dti2).' 00:00:00');
				}else if($dtf2){
					$sql .= " AND p.DataAtivacao <= ". mysqlnull(date('Y-m-d', $dtf2).' 23:59:59');
			}
				$sql .= " GROUP BY l.CodLead
				ORDER BY p.DataEnvioContrato DESC";
				$ret = sql_query($sql);
//				$retnum++;
			}
//		}
//		$ret['maxbd'] = $retnum;
		return $ret;

	}

}?>
