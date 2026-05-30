<?
	include_once( "datas.php" ) ;
	include_once( "cla.ocorrencias.php" ) ;
class leads {

	function adicionarOcorrenciaVencimentoContrato($codlead, $vencimentoatual, $vencimentonovo){  

	    if ($vencimentonovo == "null")
            $vencimentonovo = "";			

			
		if(trim($vencimentoatual) != trim($vencimentonovo)){

            if($vencimentonovo != ""){                
                $value = array();
                $value['codlead']=$codlead;
                //$value['descricao'] = "Vencimento do contrato em ".DataDMY($vencimentonovo);
				$value['descricao'] = "Data de vencimento de contrato alterada de ".DataDMY($vencimentoatual)." para ".DataDMY($vencimentonovo);
				$value['agendadopara']= $_SESSION['codusuario'];
				$value['codtipoocorrencialead'] = 5000;
				
                //adiciona a ocorrencia de popup para o usu�rio logado.
                $codocorrencia = ocorrencias::adicionar($value);
				
				//Inclui a CO com o Retorno

                $sql ="";
                $sql.="select date_add('".$vencimentonovo."', interval -1 month) dataretorno ";

				$rs = mysql_query($sql);
                $row_rs = mysql_fetch_array($rs);
                $dt_retorno = $row_rs["dataretorno"];
                mysql_free_result($rs);

				$valor = array();
                $valor['codlead']=$codlead;
                $valor['descricao'] = "Vencimento do contrato em ".DataDMY($vencimentonovo)." com retorno agendado para ".DataDMY($dt_retorno);
                $valor['dt_retorno'] = $dt_retorno;
				$valor['agendadopara']= $_SESSION['codusuario'];
				$valor['codtipoocorrencialead'] = 6001;
                //adiciona a ocorrencia de popup para o usu�rio logado.

                $codocorrencia = ocorrencias::adicionar($valor);
                
            }
		}
	}
	

	function salvarContatos($codlead, $value){
		$del = array();

        
		//ACESSO VIA CELULAR
		if(!empty($value['acesso'])){
			
		    if(!empty($value['nomecontato'])){  
    			if(!isset($value['codlead'])) $value['codlead'] = null;
    			if(!isset($value['nomecontato'])) $value['nomecontato'] = null;
    			if(!isset($value['fone'])) $value['fone'] = null;
    			if(!isset($value['fone'])) $value['fone'] = null;
    			if(!isset($value['ddd_fone'])) $value['ddd_fone'] = null;
    			if(!isset($value['ramal_fone'])) $value['ramal_fone'] = null;			
    			if(!isset($value['cel'])) $value['cel'] = null;			
    			if(!isset($value['ddd_cel'])) $value['ddd_cel'] = null;			
    			if(!isset($value['email'])) $value['email'] = null;
    			if(!isset($value['codsetorcontato'])) $value['codsetorcontato'] = null;	
    			if(!isset($value['codfuncaocontato'])) $value['codfuncaocontato'] = null;
    			if(!isset($value['id_radio'])) $value['id_radio'] = null;
				if(!isset($value['n_rg'])) $value['n_rg'] = null;
				if(!isset($value['n_cpf'])) $value['n_cpf'] = null;	
    
    			$fields = array();
    			$fields['CodLead'] = $codlead;
    			$fields['nomecontato'] = $value['nomecontato'];
    			$fields['nomecontato'] = $value['nomecontato'];	
    			$fields['fone'] = $value['fone'];
    			$fields['ddd_fone'] = $value['ddd_fone'];
    			$fields['ramal_fone'] = $value['ramal_fone'];
    			$fields['cel'] = $value['cel'];
    			$fields['ddd_cel'] = $value['ddd_cel'];
    			$fields['email'] = $value['email'];
    			$fields['codsetorcontato'] = $value['codsetorcontato'];
    			$fields['codfuncaocontato'] = $value['codfuncaocontato'];
    			$fields['id_radio'] = $value['id_radio'];
				$fields['n_rg'] = $value['n_rg'];
				$fields['n_cpf'] = $value['n_cpf'];
				
    			$sql = sqlinsert('contatoslead', $fields);
    
    			sql_query($sql);
                
                return $codlead;
            }
		}else{			
			//ACESSO PELO SISTEMA
			if(!empty($value['contato'])){
				foreach($value['contato'] as $id => $contato){
					if(!empty($contato['codcontatolead'])){
						$del[] = $contato['codcontatolead'];
					}
				}
			}
		}		
        
        if(count($del) > 0){						
			$sql = "Delete From contatoslead Where CodContatoLead Not In (" . implode(',', $del) . ") And CodLead = " . mysqlnull($codlead)." and CodContatoLead not in (select codcontatolead from agendaslead where codlead = ".mysqlnull($codlead).") ";	           
;
            sql_query($sql);
		}else{		
		    if(empty($value['acesso'])){	
				$sql = "Delete From contatoslead Where CodLead = " . mysqlnull($codlead)." and CodContatoLead not in (select codcontatolead from agendaslead where codlead = ".mysqlnull($codlead).") ";               
            	sql_query($sql);
			}
		}        
		if(!empty($value['contato'])){			
			foreach($value['contato'] as $id => $contato){

				$contato['codlead'] = $codlead;	
				if(!empty($contato['codcontatolead'])){	
					$sql = sqlupdate('contatoslead', $contato, 'CodContatoLead = ' . mysqlnull($contato['codcontatolead']));					
					sql_query($sql);
				}else{
					$sql = sqlinsert('contatoslead', $contato);										
					sql_query($sql);				
				}
			}
		}

	}

	function adicionar($value, $contatos = true)
	{	
	    
		if(!isset($value['codlead'])) $value['codlead'] = null;
		if(!isset($value['razaosocial'])) return false;
		if(!isset($value['nomefantasia'])) $value['nomefantasia'] = null;
		if(!isset($value['cnpj_cpf'])) $value['cnpj_cpf'] = null;
		if(!isset($value['ie'])) $value['ie'] = null;
		if(!isset($value['inscricaomunicipal'])) $value['inscricaomunicipal'] = null;
		if(!isset($value['senha_cliente'])) $value['senha_cliente'] = null;
		if(!isset($value['identificacao'])) $value['identificacao'] = null;		
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
		if(!isset($value['mailing_pk'])) $value['mailing_pk'] = null;
		if(!isset($value['codmotivo'])) $value['codmotivo'] = null;
		if(!isset($value['vencimentocontrato'])) $value['vencimentocontrato'] = null;
		if(!isset($value['ativacao'])) $value['ativacao'] = null;
		if(!isset($value['cod_polo'])) $value['cod_polo'] = 0;
		if(!isset($value['pontoref'])) $value['pontoref'] = null;
		if(!isset($value['tel_bloqueado'])) $value['tel_bloqueado'] = null;
		if(!isset($value['fax_bloqueado'])) $value['fax_bloqueado'] = null;
		if(!isset($value['iluminado'])) $value['iluminado'] = null;
		if(!isset($value['txtocorrenciaini'])) $value['txtocorrenciaini'] = null;
		if(!isset($value['qtde_linhas'])) $value['qtde_linhas'] = null;
		if(!isset($value['tipo_pessoa'])) $value['tipo_pessoa'] = null;
		if(!isset($value['id_fornecedor'])) $value['id_fornecedor'] = null;
        if(!isset($value['classificacao_claro_pk'])) $value['classificacao_claro_pk'] = null;
        if(!isset($value['classificacao_vivo_pk'])) $value['classificacao_vivo_pk'] = null;
        
		
		$fields = array();
		$fields['razaosocial'] = $value['razaosocial'];
		$fields['nomefantasia'] = $value['nomefantasia'];
		$fields['cnpj_cpf'] = $value['cnpj_cpf'];
		$fields['ie'] = $value['ie'];
		$fields['inscricaomunicipal'] = $value['inscricaomunicipal'];
		$fields['senha_cliente'] = $value['senha_cliente'];
		$fields['identificacao'] = $value['identificacao'];		
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
		$fields['mailing_pk'] = $value['mailing_pk'];
		$fields['codmotivo'] = $value['codmotivo'];
		$fields['vencimentocontrato'] = $value['vencimentocontrato'];
		$fields['ativacao'] = $value['ativacao'];
		$fields['cod_polo'] = $value['cod_polo'];
		$fields['pontoref'] = $value['pontoref'];
		$fields['tel_bloqueado'] = $value['tel_bloqueado'];
		$fields['fax_bloqueado'] = $value['fax_bloqueado'];
		$fields['usuariocadastro'] = $_SESSION['codusuario'];
		$fields['iluminado'] = $value['iluminado'];
		$fields['qtde_linhas'] = $value['qtde_linhas'];
		$fields['tipo_pessoa'] = $value['tipo_pessoa'];
		$fields['id_fornecedor'] = $value['id_fornecedor'];
        $fields['classificacao_claro_pk'] = $value['classificacao_claro_pk'];
        $fields['classificacao_vivo_pk'] = $value['classificacao_vivo_pk'];

		//VERIFICA O CNPJ OU CPF JA ESTA CADASTRADO E BARRA
		if($value['cnpj_cpf'] != null){
			$sql = "SELECT CodLead, RazaoSocial FROM leads WHERE CNPJ_CPF = '".$value['cnpj_cpf']."' and codgerenteconta  = '".$value['codgerenteconta']."' ";
		
			$result = sql_query($sql);
			if($row = mysql_fetch_array($result)){
				mysql_free_result($result);
				javascriptalert("Lead já cadastrado:  ".$row['CodLead']." - ".$row['RazaoSocial']);
                if($value['acesso']==1){
                    ?>
                    <script>
                        location.href = "mobile_vendas_form.php" ;
                    </script>
                <?   
                }
				exit();
			} 
		}
		
		$sql = sqlinsert('leads', $fields);

		sql_query($sql);

		$codlead = mysql_insert_id();
		if(isset($value['contato'])){
			leads::salvarContatos($codlead, $value);
		}
		
		leads::adicionarOcorrenciaVencimentoContrato($codlead, "", $value['vencimentocontrato']);
		
		if(isset($value['operadoras'])) leads::salvarOperadoras($codlead, $value['operadoras']);
		else leads::salvarOperadoras($codlead, '');

				
		//adiciona a ocorrencia com informa��es adicionais da prospeccao.
		if(!empty($value['txtocorrenciaini'])){
			ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => $value['txtocorrenciaini'], 'codtipoocorrencialead' => 48 , 'datafechamento' => 'sysdate()'));
		}
		
		return $codlead;
	}

	function alterar($codlead, $value, $contatos = false){
		if(!isset($value['razaosocial'])) $value['razaosocial'] = null;
		if(!isset($value['nomefantasia'])) $value['nomefantasia'] = null;
		if($value['cnpj_cpf'] == '') $value['cnpj_cpf'] = 'null';
		if($value['ie'] == '') $value['ie'] = 'null';
		if($value['inscricaomunicipal'] == '') $value['inscricaomunicipal'] = 'null';
		if($value['senha_cliente'] == '') $value['senha_cliente'] = 'null';
		if(!isset($value['identificacao'])) $value['identificacao'] = null;		
		if($value['site'] == '') $value['site'] = 'null';
		if(!isset($value['ddd'])) $value['ddd'] = null;
		if(!isset($value['tel'])) $value['tel'] = null;
		if($value['dddfax'] == '') $value['dddfax'] = 'null';
		if($value['fax'] == '') $value['fax'] = 'null';
		if($value['endereco'] == '') $value['endereco'] = 'null';
		if($value['numero'] == '') $value['numero'] = 'null';
		if($value['complemento'] == '') $value['complemento'] = 'null';
		if($value['bairro'] == '') $value['bairro'] = 'null';
		if($value['cep'] == '') $value['cep'] = 'null';
		if($value['cidade'] == '') $value['cidade'] = 'null';
		if($value['uf'] == '') $value['uf'] = 'null';
		if($value['codgerenteconta'] == '') $value['codgerenteconta'] = 'null';
		if(!isset($value['datacadastro'])) $value['datacadastro'] = null;
		if($value['codstatusclassificacaolead'] == '') $value['codstatusclassificacaolead'] = 'null';
		if($value['segmento'] == '') $value['segmento'] = 'null';
		if($value['codatendente'] == '') $value['codatendente'] = 'null';
		if($value['mailing_pk'] == '') $value['mailing_pk'] = 'null';
		if($value['codmotivo'] == '') $value['codmotivo'] = 'null';
		if($value['vencimentocontrato'] == '') $value['vencimentocontrato'] = 'null';
		if($value['ativacao'] == '') $value['ativacao'] = 'null';
		if(!isset($value['cod_polo'])) $value['cod_polo'] = null;
		if($value['pontoref'] == '') $value['pontoref'] = 'null';
		if($value['tel_bloqueado'] == '') $value['tel_bloqueado'] = 'null';
		if($value['fax_bloqueado'] == '') $value['fax_bloqueado'] = 'null';
		if($value['iluminado'] == '') $value['iluminado'] = 'null';
		if($value['qtde_linhas'] == '') $value['qtde_linhas'] = 'null';
		if($value['tipo_pessoa'] == '') $value['tipo_pessoa'] = 'null';
		if($value['id_fornecedor'] == '') $value['id_fornecedor'] = 'null';
        if($value['classificacao_claro_pk'] == '') $value['classificacao_claro_pk'] = 'null';
        if($value['classificacao_vivo_pk'] == '') $value['classificacao_vivo_pk'] = 'null';

		$sql = "Select *, date_format(vencimentocontrato,'%Y-%m-%d') vencimentocontrato from leads Where CodLead = $codlead";
		$anterior = sql_query($sql);
		$anterior = mysql_fetch_array($anterior);

		$fields = array();
		$fields['razaosocial'] = $value['razaosocial'];
		$fields['nomefantasia'] = $value['nomefantasia'];
		$fields['cnpj_cpf'] = $value['cnpj_cpf'];
		$fields['ie'] = $value['ie'];
		$fields['inscricaomunicipal'] = $value['inscricaomunicipal'];
		$fields['senha_cliente'] = $value['senha_cliente'];
		$fields['identificacao'] = $value['identificacao'];	
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
		$fields['mailing_pk'] = $value['mailing_pk'];
		$fields['codmotivo'] = $value['codmotivo'];
		$fields['vencimentocontrato'] = $value['vencimentocontrato'];
		$fields['ativacao'] = $value['ativacao'];
		$fields['cod_polo'] = $value['cod_polo'];
		$fields['pontoref'] = $value['pontoref'];
		$fields['tel_bloqueado'] = $value['tel_bloqueado'];
		$fields['fax_bloqueado'] = $value['fax_bloqueado'];
		$fields['iluminado'] = $value['iluminado'];
		$fields['qtde_linhas'] = $value['qtde_linhas'];
		$fields['tipo_pessoa'] = $value['tipo_pessoa'];
		$fields['id_fornecedor'] = $value['id_fornecedor'];
        $fields['classificacao_claro_pk'] = $value['classificacao_claro_pk'];
        $fields['classificacao_vivo_pk'] = $value['classificacao_vivo_pk'];

				//VERIFICA O CNPJ OU CPF JA ESTA CADASTRADO E BARRA
		if($value['cnpj_cpf'] != null){
			$sql = "SELECT CodLead, RazaoSocial 
					  FROM leads
					 WHERE CNPJ_CPF = '".$value['cnpj_cpf']."'
					   AND codlead <>".$codlead." and codgerenteconta  = '".$value['codgerenteconta']."' ";
					
			$result = sql_query($sql);
			if($row = mysql_fetch_array($result)){
				mysql_free_result($result);
				javascriptalert("Lead j� cadastrado: ".$row['CodLead']." - ".$row['RazaoSocial']);
				exit();
			} 
		}
			
		$sql = sqlupdate('leads', $fields, ' CodLead = ' . mysqlnull($codlead));
		sql_query($sql);
		
		leads::adicionarOcorrenciaVencimentoContrato($codlead, $anterior['vencimentocontrato'], $value['vencimentocontrato']);
		
/*		$sql = "Select * from leads Where CodLead = $codlead";
		$atual = sql_query($sql);
		$atual = mysql_fetch_array($atual);*/

		if($fields['codgerenteconta'] != $anterior['CodGerenteConta'] && !($fields['codgerenteconta'] == 'null' && !$anterior['CodGerenteConta'])){
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
				if(!empty($fields['codgerenteconta'])){
					$sql = sqlinsert('agendagerenteconta', array('CodAgendaLead' => $rwagenda['CodAgendaLead'], 'CodGerenteConta' => $fields['codgerenteconta']));
					sql_query($sql);
				}
			}
			mysql_free_result($rsagenda);
			$desc = "De ".$anterior['CodGerenteConta']." para ".$fields['codgerenteconta'];
			logg::insert(8 , $codlead, $desc );
		}

		if($fields['tel'] != $anterior['tel']){
			$desc = "De ".$anterior['tel']." para ".$fields['tel'];
			logg::insert(14 , $codlead, $desc );
		}

		if($fields['codatendente'] != $anterior['CodAtendente'] && !($fields['codatendente'] == 'null' && !$anterior['CodAtendente'])){
			$desc = "De ".$anterior['CodAtendente']." para ".$fields['codatendente'];
			logg::insert(15 , $codlead, $desc );
		}
		
		leads::salvarContatos($codlead, $value);
		
		if(isset($value['operadoras'])) leads::salvarOperadoras($codlead, $value['operadoras']);
		else leads::salvarOperadoras($codlead, '');		

		return $codlead;
	}

	function excluir($codlead){
		$sql = "Select CodLead, RazaoSocial From leads Where CodLead = ".mysqlnull($codlead);
		$rs = sql_query($sql);
		if(mysql_num_rows($rs) == 0)
			return false;
		$lead = mysql_result($rs,0,"RazaoSocial");
		mysql_free_result($rs);
        logg::insert( 4 , $codlead, $codlead." - ".$lead ) ;
		
        //LEADS
		$sql = sqldelete('leads','Codlead = ' . mysqlnull($codlead ));
		sql_query($sql);

		$sql = "Delete From ocorrenciaslead Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From agendaslead Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From agendaslead Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From modulosproposta Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From propostas Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From contatoslead Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From leads Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);
		$sql = "Delete From leads_operadoras Where CodLead = ".mysqlnull($codlead);
		sql_query($sql);

		return true;
	}
	
		function salvarOperadoras($codlead, $operadoras)
		{
            $sql = "delete from leads_operadoras where CodLead = " . mysqlnull($codlead);
		
            sql_query($sql);
			
			if(!empty($operadoras))
			{
				foreach($operadoras as $operadora){
				$sql = sqlinsert('leads_operadoras', array('cod_operadora' => $operadora, 'CodLead' => $codlead));
				sql_query($sql);}
			}
		}
		
		function operadoras($CodLead)
		{
			$result = sql_query("select cod_operadora from leads_operadoras where CodLead = '".$CodLead."';");
         
			$i=0; $lista = Array();
			while($row = mysql_fetch_array($result))
			{
				$lista[$i] = $row['cod_operadora'];
				$i++;
			}
			return $lista;
		}
}
?>
