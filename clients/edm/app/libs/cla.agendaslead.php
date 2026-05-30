<?	include_once "maininclude.php";       
	include_once "cla.ocorrencias.php";
	include_once "cla.leads.php";
	include_once "datas.php";
        //include_once "cla.email.php";
    include_once "cla.layout_email.php";

class agendaslead {
     
    function salvargerentes($codagendalead,$gerentes,$codlead,$acesso){    
       
		if(is_null($gerentes)){
			return false;
		}
		//VERIFICA DE ONDE VEM O ACESSO
		if(!empty($acesso)){

			if(!empty($gerentes)){	
				$sql = "INSERT INTO agendagerenteconta (CodGerenteConta, CodAgendaLead) Values ($gerentes,$codagendalead )";
				
                                sql_query($sql);
			}
		}else{	
                    $sql = "SELECT
                                    CodAgendaLead
                            FROM agendagerenteconta
                            WHERE CodAgendaLead=".$codagendalead;					
                    $res = mysql_query($sql);
                    if($row = mysql_fetch_array($res)){	
                            $ag = $row['CodAgendaLead'];
                    }           
                    mysql_free_result($res);
                    if(!empty($ag)){
         
    			$sql = "SELECT
                                    a.CodGerenteConta,
                                    ui.nome
                            FROM agendagerenteconta a
                                INNER JOIN usuariosinternos ui on ui.codusuariointerno = a.CodGerenteConta
                                WHERE a.CodAgendaLead=".$codagendalead;	
                 
    			$result = sql_query($sql);
                        while($row = mysql_fetch_array($result)){
                            $memo[] = "<tr align=left><td><b> Consultor </b> = ".$row['nome']." - ID= ".$row['CodGerenteConta']."</td></tr>";
                        }
                        mysql_free_result($result);
			//EXCLUI OS REGISTROS DA AGENDA GERENTE
                        $sql = "Delete from agendagerenteconta where CodAgendaLead=".$codagendalead;
                        sql_query($sql);
				
			//INSERE OS NOVOS REGISTROS
                        foreach($gerentes as $codusuariointerno){
                        $sql = "Insert Into agendagerenteconta (CodGerenteConta, CodAgendaLead) Values ($codusuariointerno, $codagendalead)";
                        sql_query($sql);
                        $sql = "Insert Into ordem_gc (CodGerenteContas, CodAgendaGC) Values ($codusuariointerno, $codagendalead)";
                        sql_query($sql);
					
                        $sql = "SELECT
                                    ui.nome
                                FROM usuariosinternos ui
                                WHERE ui.codusuariointerno=".$codusuariointerno;
                   
                        $result = sql_query($sql);
                        if($row = mysql_fetch_array($result)){	
                            $nome = $row['nome'];
			}
                        mysql_free_result($result);
                           $memo_novo[] = "<tr align=left><td><b> Consultor </b> = ".$nome." - ID= ".$codusuariointerno."</td></tr>";
                        }
			$fk =  str_replace ("'", "", "CodAgendaLead = ".$codagendalead); 
			$sql = "insert into log (cod_tipolog,tabela,fk,c_atual,c_novo,codusuariointerno,dt_log,fk_lead) values (1,'agendagerenteconta','".$fk."','".implode(" ",$memo)."','".implode(" ",$memo_novo)."',".$_SESSION['codusuario'].",SYSDATE(),$codlead)";
			                
                        sql_query($sql);					
                    }else{
                        
                        
                        //INSERT
                        foreach($gerentes as $codusuariointerno){
                            
                            $sql ="";
                            $sql.="SELECT DATE_FORMAT(ag.DataHorario, '%d/%m/%Y') dt_agenda,
                                        DATE_FORMAT(ag.DataHorario, '%H:%i') hr_agenda,
                                        l.RazaoSocial,
                                        cl.NomeContato,
                                        cl.Email email_contato,
                                        l.codlead,
                                        l.endereco,
                                        l.numero,
                                        l.bairro,
                                        l.cidade,
                                        l.cep,
                                        l.bairro,
                                        l.uf,
                                        pl.cod_polo,
                                        ag.operador_pk
                                   FROM agendaslead ag
                                        INNER JOIN leads l ON ag.CodLead = l.CodLead
                                        INNER JOIN contatoslead cl ON l.CodLead = cl.CodLead
                                        LEFT JOIN polo pl on l.cod_polo = pl.cod_polo
                                  WHERE ag.CodAgendaLead =".$codagendalead;
                            $result = mysql_query($sql);
                            $row = mysql_fetch_array($result);
                            $sql ="";
                            $sql.="SELECT ui.Nome
                                        ,ui.email email_consultor
                                        ,e.site
                                        ,e.ddd
                                        ,e.tel
                                        ,e.enviar_agenda_email_pk
                                        ,e.razao_social
                                    FROM usuariosinternos ui
                                    left join empresa e on ui.cod_empresa = e.cod_empresa
                                   WHERE ui.CodUsuarioInterno =".$codusuariointerno;
                            $results = mysql_query($sql);
                            $rows = mysql_fetch_array($results);
                            
                            $sql ="";
                            $sql.="SELECT 
                                        e.razao_social
                                       ,e.enviar_agenda_email_pk
                                       ,e.origem_email_agendamento_pk
                                       ,e.agenda_email
                                       ,e.enviar_proposta_email_pk
                                       ,e.origem_email_proposta_pk
                                       ,e.proposta_email
                                   FROM empresa e";
                            
                            $results = mysql_query($sql);
                            $row1 = mysql_fetch_array($results);
                            
                            
                            $sql = "";
                            $sql.="SELECT dsc_operador,
                                       nom.dsc_titulo,
                                       nom.dsc_proposta,
                                       e.cidade,
                                       nom.dsc_rodape,
                                       np.trade_in,
                                       np.vl_total_proposta,
                                       DATE_FORMAT(np.dt_validade, '%d/%m/%Y') dt_validade,
                                       l.razaosocial,
                                       l.CNPJ_CPF,
                                       l.ddd,
                                       l.tel,
                                       cl.nomecontato,
                                       cl.ddd_fone,
                                       cl.fone,
                                       cl.email email_contato,
                                       eo.cod_operador,
                                       cl.nomecontato
                                    FROM operador o
                                       INNER JOIN n_propostas np ON o.cod_operador = np.operador_pk
                                       left join leads l on np.leads_pk = l.codlead
                                       left join contatoslead cl on l.codlead = cl.codlead
                                       INNER JOIN empresa_operador eo ON o.cod_operador = eo.cod_operador
                                       LEFT JOIN empresa e ON eo.cod_empresa = e.cod_empresa			   
                                       LEFT JOIN n_operador_modelo_proposta nom ON o.cod_operador = nom.operador_pk
                                    WHERE np.pk =".$proposta_pk;

                                if(!empty($_SESSION['cod_polo'])){		
                                    $sql.=" AND cod_polo =".$_SESSION['cod_polo'];
                                }

                                $result = mysql_query($sql);
                                $row2 = mysql_fetch_array($result);
                                
                                if($row['operador_pk']==3){
                                    $assunto = "CONFIRMAÇÃO DE VISITA - VIVO EMPRESAS";
                                }else if($row['operador_pk']==2){
                                    $assunto = "CONFIRMAÇÃO DE VISITA - TIM EMPRESAS";
                                }else if ($row['operador_pk']==1){
                                    $assunto= "CONFIRMAÇÃO DE VISITA - CLARO EMPRESAS"; 
                                }else if ($row['operador_pk']==4){
                                    $assunto="CONFIRMAÇÃO DE VISITA - NEXTEL EMPRESAS";
                                }else if ($row['operador_pk']==6){
                                    $assunto="CONFIRMAÇÃO DE VISITA - OI EMPRESAS";
                                }       
                                
                                
                                
                            if($row1['enviar_agenda_email_pk']==1){
                                
                                    ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => 'Email de agendamento enviado ', 'codtipoocorrencialead' => 6038));
                                
                                if($row1['origem_email_agendamento_pk']==1){
                                    
                                    email::envia_email_agendamento($html,$rows['email_consultor'],$row['email_contato'],$body,$msg_body,$assunto,$row['operador_pk']);
                                    
                                }elseif($row1['agenda_email']){
                                    
                                   $rows['email_consultor'] = $row1['agenda_email'] ; 
                                   
                                }     
                            }
                                     
                            if(!empty($row['operador_pk'])){
                                if($row['operador_pk']==3 || $row['operador_pk']==2 || $row['operador_pk']==1 || $row['operador_pk']==4 || $row['operador_pk']==6){
                                    
                                //layout  Claro, Vivo , Tim (agendamento)
                                                
                                $html =   layout_email::layout_agendamento($row['RazaoSocial'],$row['Email'],$rows['Nome'],$row['NomeContato'],$rows['email'],$row['operador_pk'],$row['codlead'],$row['codagendalead'],$row['dt_agenda'],$row['hr_agenda'],$rows['site'],$row['CodGerenteConta'],$rows['tel'],$rows['ddd'],$row['endereco'],$row['numero'],$row['bairro'],$row['cidade'],$row['cep'],$rows['razao_social']);
                                
                                //enviar email
                                email::envia_email_agendamento($html,$rows['email_consultor'],$row['email_contato'],$body,$msg_body,$assunto,$row['operador_pk']);
                                }
                            }
                            
                            
                            
                            
                            mysql_free_result($result);
                            mysql_free_result($results);
                            $sql = "Insert Into agendagerenteconta (CodGerenteConta, CodAgendaLead) Values ($codusuariointerno, $codagendalead)";
                            sql_query($sql);
                            $sql = "Insert Into ordem_gc (CodGerenteContas, CodAgendaGC) Values ($codusuariointerno, $codagendalead)";
                            sql_query($sql);                    
                        }
                       
                            
                    }
		}
                
		return true;
	}
	function leadsgerente( $codagendalead , $gerentes , $codlead, $acesso){
		//VERIFICA DE ONDE VEM O ACESSO MOBILE OU SISTEMA
		if(!empty($acesso)){
			if(!empty($gerentes)){	
				$sql = "update leads set codgerenteconta = $gerentes where codlead =" . ( $codlead ) ;
                
				sql_query( $sql ) ;
			}
		}else{	
		if( is_null( $gerentes) )
		{
			return false;
		}
			foreach( $gerentes as $codusuariointerno )		{
                $sql = "";
                $sql.= "Select
                         ui.cod_polo
                        from usuariosinternos ui
                        where ui.codusuariointerno=".$codusuariointerno;

                $results = sql_query($sql);
                $polo = mysql_fetch_array($results);
                $cod_polo = $polo['cod_polo'];
                mysql_free_result($results);  

                $sql = "Select 
                            l.codgerenteconta,
                            l.cod_polo
                        from leads l";
                $sql .=" inner join agendaslead ag on l.codlead = ag.codlead";
                $sql .=" left join agendagerenteconta a ON ag.codagendalead = a.codagendalead";    
                $sql .=" where l.codgerenteconta=".$codusuariointerno; 
                $sql .=" and a.codagendalead=".$codagendalead;
                $sql .=" group by l.CodGerenteConta";


                $result = sql_query($sql);
    		    $gr = mysql_fetch_array($result); 
        		$gr_lead = $gr['codgerenteconta'];
                $cod_polo1 = $gr['cod_polo'];
                mysql_free_result($result);  
                
               
                if(empty($cod_polo)){
                    
                    $cod_polo = $cod_polo1;
                }
               
                if($gr_lead == $codusuariointerno ){
                    $sql = "update leads set codgerenteconta = $gr_lead, cod_polo= $cod_polo where codlead =" . ( $codlead ) ;
                   
                    sql_query( $sql ) ;
                    return true ;
                }else{
                    $sql = "update leads set codgerenteconta = $codusuariointerno, cod_polo= $cod_polo where codlead =" . ( $codlead ) ;
                    sql_query( $sql ) ;                     
                }            	
		
		    }

		}
         
		return true ;
	}


	function adicionar($value, $reagendar = null, $retorno = null){
		//Valida os dados		
        $codlead = $value['codlead'];
        $acesso = $value['acesso'];
		if(!isset($value['codlead'])) return false;
		if(!isset($value['codusuariointerno'])) $value['codusuariointerno'] = $_SESSION['codusuario'];
		if(!isset($value['agendadopara'])) $value['agendadopara'] = null;
		if(!isset($value['datacadastro']) || is_null($value['datacadastro'])) $value['datacadastro'] = 'SYSDATE()';
		if(!isset($value['datahorario'])) return false;
		if(!isset($value['datacancelamento'])) $value['datacancelamento'] = null;
		if(!isset($value['termino'])) $value['termino'] = null;
		if(!isset($value['descricao'])) $value['descricao'] = null;
		if(!isset($value['codstatus'])) $value['codstatus'] = null;
		if(!isset($value['codtipo'])) $value['codtipo'] = 1;      
    	if(!isset($value['codcontatolead'])) return false;
		if(!isset($value['codocorrencialead'])) $value['codocorrencialead'] = null; 
		if(!isset($value['codreagendamento'])) $value['codreagendamento'] = null;
		if(!isset($value['informacoes'])) $value['informacoes'] = null;
		if(!isset($value['qualityservice'])) $value['qualityservice'] = null;
		if(!isset($value['cancelamento'])) $value['cancelamento'] = null;
		if(!isset($value['gerentecontas'])) $value['gerentecontas'] = null;		
        if(!isset($value['cod_tamanho_visita'])) $value['cod_tamanho_visita'] = null;//RECEBE VALOR DE TAMANHO DA VISITA
        if(!isset($value['linha_nova'])) $value['linha_nova'] = null;//RECEBE VALOR DE TIPOS DE LINHAS
        if(!isset($value['linha_adicao'])) $value['linha_adicao'] = null;
        if(!isset($value['linha_portabilidade'])) $value['linha_portabilidade'] = null;
        if(!isset($value['linha_renovacao'])) $value['linha_renovacao'] = null;
        if(!isset($value['linha_migracao'])) $value['linha_migracao'] = null;
        if(!isset($value['linha_transferencia'])) $value['linha_transferencia'] = null;
        if(!isset($value['auditado'])) $value['auditado'] = 0;
 		if(!isset($value['cod_motivo_reagendamento'])) $value['cod_motivo_reagendamento'] = null;//Reagendamento motivo de reagendamento 06/02/2010
        if(!isset($value['dsc_reagendamento'])) $value['dsc_reagendamento'] = null;//Reagendamento motivo de reagendamento 06/02/2010
        if(!isset($value['endereco'])) $value['endereco'] = null;
        if(!isset($value['cep'])) $value['cep'] = null;
        if(!isset($value['numero'])) $value['numero'] = null;
        if(!isset($value['complemento'])) $value['complemento'] = null;
        if(!isset($value['bairro'])) $value['bairro'] = null;
        if(!isset($value['cidade'])) $value['cidade'] = null;
        if(!isset($value['uf'])) $value['uf'] = null;
        if(!isset($value['pontoref'])) $value['pontoref'] = null;
        if(!isset($value['operador_pk'])) $value['operador_pk'] = null;


		$fields['codlead'] = $value['codlead'];
		$fields['codusuariointerno'] = $value['codusuariointerno'];
		$fields['agendadopara'] = $value['agendadopara'];
		$fields['datacadastro'] = $value['datacadastro'];
		$fields['datahorario'] = $value['datahorario'];
		$fields['datacancelamento'] = $value['datacancelamento'];
		$fields['termino'] = $value['termino'];
		$fields['descricao'] = $value['descricao'];
		$fields['codstatus'] = $value['codstatus'];
		$fields['codtipo'] = $value['codtipo'];
		$fields['codcontatolead'] = $value['codcontatolead'];
		$fields['codocorrencialead'] = $value['codocorrencialead'];
		$fields['codreagendamento'] = $value['codreagendamento'];
		$fields['informacoes'] = $value['informacoes'];
		$fields['qualityservice'] = $value['qualityservice'];
		$fields['cancelamento'] = $value['cancelamento'];
		$fields['cod_tamanho_visita'] = $value['cod_tamanho_visita'];
		$fields['linha_nova'] = $value['linha_nova'];
		$fields['linha_adicao'] = $value['linha_adicao'];
		$fields['linha_portabilidade'] = $value['linha_portabilidade'];
		$fields['linha_renovacao'] = $value['linha_renovacao'];
		$fields['linha_migracao'] = $value['linha_migracao'];
		$fields['linha_transferencia'] = $value['linha_transferencia'];		
		$fields['auditado'] = $value['auditado'];
		$fields['cod_motivo_reagendamento'] = $value['cod_motivo_reagendamento'];//Reagendamento motivo de reagendamento 06/02/2010
		$fields['dsc_reagendamento'] = $value['dsc_reagendamento'];//Reagendamento motivo de reagendamento 06/02/2010
        $fields['endereco'] = $value['endereco'];
        $fields['cep'] = $value['cep'];
        $fields['numero'] = $value['numero'];
        $fields['complemento'] = $value['complemento'];
        $fields['bairro'] = $value['bairro'];
        $fields['cidade'] = $value['cidade'];
        $fields['uf'] = $value['uf'];
        $fields['pontoref'] = $value['pontoref'];
        $fields['operador_pk'] = $value['operador_pk'];

		$sql = sqlinsert('agendaslead', $fields);

        sql_query($sql);
		$codagendalead = mysql_insert_id();
      
        
        
		if(isset($value['operadoras'])) leads::salvarOperadoras($value['codlead'], $value['operadoras']);
		else leads::salvarOperadoras($value['codlead'], '');
        
        //Registra o endereco do agendamento no lead se estiver vazio 
        agendaslead::enderecoleads($value['codlead'],$value['endereco'],$value['numero'],$value['complemento'],$value['bairro'],$value['cep'],$value['cidade'],$value['uf'],$value['pontoref']);      
       
        //FILA DE AGENDAMENTO
        //if(empty($value['gerentecontas'])){
           // agendaslead::fila_agendamento($value['cod_tamanho_visita'],$codagendalead,$value['codlead']);
        //}else{
            //Inclui os consultores na visita
            agendaslead::salvargerentes($codagendalead, $value['gerentecontas'],$value['codlead'],$value['acesso']);
        //}
        
        
        agendaslead::leadsgerente($codagendalead, $value['gerentecontas'], $value['codlead'],$value['acesso']);
       
		//Monta a ocorrência
		$sql = "Select Descricao, SYSDATE() DataCancelamento From tipoagendamento Where CodTipo = ".mysqlnull($value['codtipo']);
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		$tipo = $row['Descricao'];
		$datacancelamento = $row['DataCancelamento'];

		mysql_free_result($rs);
		//Dados Retorno 
		$dt_retorno = date("Y-m-d H:i:s", (strtotime($value['datahorario'])+ 7*86400));		

		$codusuarioretorno = $value['codusuariointerno'];
		$descricaoretorno = $tipo.' - '.date('d/m/Y \à\s H:i:s', strtotime($value['datahorario'])).': '.$value['descricao'];

		if($reagendar != null){
			//FECHANDO A OCORRENCIA DE AGENDAMENTO 			
			$sql1 = "update ocorrenciaslead set datafechamento=SYSDATE(),dt_retorno_fechamento=SYSDATE(),dsc_retorno='Fechamento Automatico Visita Reagendada' where codtipoocorrencialead in (4,40) and codlead =".$value['codlead']." and datafechamento is null "; 
            sql_query($sql1);
			
			//CANCELA AS OCORRENCIAS DO AGENDAMENTO ANTERIOR
			agendaslead::cancelar($reagendar);
			
			agendaslead::alterar($reagendar, array('codstatus' => 3, 'codreagendamento' => $codagendalead));
			//BUSCA OS DADOS DO AGENDAMENTO QUE ESTA SENDO REAGENDADO
			$sql = "Select * from agendaslead Where CodAgendaLead = $reagendar";			
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			
			//Reagendamento motivo de reagendamento 06/02/2010
			$sql =  "SELECT
				ma.dsc_motivo_reagendamento
			FROM agendaslead ag
				INNER JOIN motivo_reagendamento ma on ag.cod_motivo_reagendamento = ma.cod_motivo_reagendamento
				where ag.CodAgendaLead =$codagendalead";			
			$result1 = sql_query($sql);
			$rowre = mysql_fetch_array($result1);				
			
			//descricao da ocorrencia de reagendamento com o motivo de reagendamento
			$descricaoreagendamento = $tipo.' do dia '.date('d/m/Y \à\s H:i:s', strtotime($row['DataHorario'])).' para o dia '.date('d/m/Y \à\s H:i:s', strtotime($value['datahorario'])).'-'.$value['dsc_reagendamento'].' - '.$rowre['dsc_motivo_reagendamento'];
			
			//INCLUI A OCORRENCIA DO REAGENDAMENTO
			$codocorrencia = ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricaoreagendamento, 'codtipoocorrencialead' => 40, 'ocorrenciasuperior' => $row['CodOcorrenciaLead']));
			//VINCULA A OCORRENCIA GERADA A AGENDA REAGENDA
			$sql = "update agendaslead set codocorrencialead=$codocorrencia where codagendalead=$codagendalead";
			sql_query($sql);	
			//recebe a ocorrencia do tipo agendamento
            $codocagendamento = $codocorrencia;
            
			$codocorrencia = ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricao1, 'codtipoocorrencialead' => 23, 'ocorrenciasuperior' =>  $codocorrencia));
			//CRIA OCORRENCIA DE POP UP 
			
			$codocorrencia = ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricaoretorno, 'codtipoocorrencialead' => 6000, 'ocorrenciasuperior' =>  $codocorrencia,'dt_retorno'=> $dt_retorno,'agendadopara' => $codusuarioretorno));	
			//CRIA OCORRENCIA DE ACOMPANHAMENTO DA VEISITA 
			mysql_free_result($result);
		}elseif($retorno != null){
			//AGENDAMENTO
			agendaslead::alterar($retorno, array('codreagendamento' => $codagendalead));
			$sql = "Select * from agendaslead Where CodAgendaLead = $retorno";
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			$descricao1 = 'Retorno referente à visita do dia '.date('d/m/Y \à\s H:i:s', strtotime($row['DataHorario'])).chr(13).chr(10).' '.$descricao1.' - '.$value['descricao'];
			
			$codocorrencia = ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricao1, 'codtipoocorrencialead' => 4));			
			//CRIA OCORRENCIA DE POP UP 
			$codocorrencia = ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricaoretorno, 'codtipoocorrencialead' => 6000,'dt_retorno'=> $dt_retorno,'agendadopara' => $codusuarioretorno));	
			agendaslead::alterar($codagendalead, array('codocorrencialead' => $codocorrencia));
			mysql_free_result($result);
		}else{	

			$descricao1 = $tipo.' - '.date('d/m/Y \à\s H:i:s', strtotime($value['datahorario'])).': '.$value['descricao'];
			$codocorrencia = ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricao1, 'codtipoocorrencialead' => 4));
			
			//INCLUO O NUMERO DA OCORRENCIA GERADA NA AGENDA SEM CHAMAR A FUNCTION DE ALTERACAO
			$sql = "update agendaslead set codocorrencialead=$codocorrencia where codagendalead=$codagendalead";
			sql_query($sql);
			
            //recebe a ocorrencia do tipo agendamento
            $codocagendamento = $codocorrencia;
             
            $codocorrencia = ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricao1, 'codtipoocorrencialead' => 23, 'ocorrenciasuperior' =>  $codocagendamento));
			
			//CRIA OCORRENCIA DE POP UP 
			$codocorrencia = ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricaoretorno, 'codtipoocorrencialead' => 6000, 'ocorrenciasuperior' =>  $codocagendamento,'dt_retorno'=> $dt_retorno,'agendadopara' => $codusuarioretorno));	
			
		}

		if($value['codtipo'] == 1){
			$sql = "update leads set CodStatusClassificacaoLead = 4 Where CodLead = {$value['codlead']} And CodStatusClassificacaoLead In (1, 2, 3,5,6,10,12,15)";
			sql_query($sql);
		}

		//ACESSO MOBILE
		if(!empty($acesso)){
			return array('codagendalead' => $codagendalead, 'codlead' => $codlead, 'reagendar'=>$reagendar);
	    }else{
			return ($codagendalead);
		}	
        
	}
	function alterar($codagendalead, $value ){

	    $codlead = $value['codlead'];
	    $acesso = $value['acesso'];
		if(!isset($value['codlead'])) $value['codlead'] = null;
		if(!isset($value['codusuariointerno'])) $value['codusuariointerno'] = null;
		if(!isset($value['agendadopara'])) $value['agendadopara'] = null;
		if(!isset($value['datacadastro'])) $value['datacadastro'] = null;
		if(!isset($value['datahorario'])) $value['datahorario'] = null;
		if(!isset($value['datacancelamento'])) $value['datacancelamento'] = null;
		if(!isset($value['termino'])) $value['termino'] = null;
		if(!isset($value['descricao'])) $value['descricao'] = null;
		if(!isset($value['codstatus'])) $value['codstatus'] = null;
		if(!isset($value['codtipo'])) $value['codtipo'] = null;
		if(!isset($value['codcontatolead'])) $value['codcontatolead'] = null;
		if(!isset($value['codocorrencialead'])) $value['codocorrencialead'] = null;
		if(!isset($value['codreagendamento'])) $value['codreagendamento'] = null;
		if(!isset($value['informacoes'])) $value['informacoes'] = null;
		if(!isset($value['qualityservice'])) $value['qualityservice'] = null;
		if(!isset($value['cancelamento'])) $value['cancelamento'] = null;
		if(!isset($value['gerentecontas'])) $value['gerentecontas'] = null;
		if(!is_array($value['gerentecontas'])) $value['gerentecontas'] = null;
		if(!isset($value['cod_tamanho_visita'])) $value['cod_tamanho_visita'] = null;//RECEBE VALOR DE TAMANHO DA VISITA
        if(!isset($value['linha_nova'])) $value['linha_nova'] = null;//RECEBE VALOR DE TIPOS DE LINHAS
        if(!isset($value['linha_adicao'])) $value['linha_adicao'] = null;
        if(!isset($value['linha_portabilidade'])) $value['linha_portabilidade'] = null;
        if(!isset($value['linha_renovacao'])) $value['linha_renovacao'] = null;
        if(!isset($value['linha_migracao'])) $value['linha_migracao'] = null;
        if(!isset($value['linha_transferencia'])) $value['linha_transferencia'] = null;
        if(!isset($value['endereco'])) $value['endereco'] = null;
        if(!isset($value['cep'])) $value['cep'] = null;
        if(!isset($value['numero'])) $value['numero'] = null;
        if(!isset($value['complemento'])) $value['complemento'] = null;
        if(!isset($value['bairro'])) $value['bairro'] = null;
        if(!isset($value['cidade'])) $value['cidade'] = null;
        if(!isset($value['uf'])) $value['uf'] = null;
        if(!isset($value['pontoref'])) $value['pontoref'] = null; 
        if(!isset($value['operador_pk'])) $value['operador_pk'] = null; 

		$fields['codlead'] = $value['codlead'];
		$fields['codusuariointerno'] = $value['codusuariointerno'];
		$fields['agendadopara'] = $value['agendadopara'];
		$fields['datacadastro'] = $value['datacadastro'];
		$fields['datahorario'] = $value['datahorario'];
		$fields['datacancelamento'] = $value['datacancelamento'];
		$fields['termino'] = $value['termino'];
		$fields['descricao'] = $value['descricao'];
		$fields['codstatus'] = $value['codstatus'];
		$fields['codtipo'] = $value['codtipo'];
		$fields['codcontatolead'] = $value['codcontatolead'];
		$fields['codocorrencialead'] = $value['codocorrencialead'];
		$fields['codreagendamento'] = $value['codreagendamento'];
		$fields['informacoes'] = $value['informacoes'];
		$fields['qualityservice'] = $value['qualityservice'];
		$fields['cancelamento'] = $value['cancelamento'];
		$fields['cod_tamanho_visita'] = $value['cod_tamanho_visita'];
		$fields['linha_nova'] = $value['linha_nova'];
		$fields['linha_adicao'] = $value['linha_adicao'];
		$fields['linha_portabilidade'] = $value['linha_portabilidade'];
		$fields['linha_renovacao'] = $value['linha_renovacao'];
		$fields['linha_migracao'] = $value['linha_migracao'];
		$fields['linha_transferencia'] = $value['linha_transferencia'];	
        $fields['endereco'] = $value['endereco'];
        $fields['cep'] = $value['cep'];
        $fields['numero'] = $value['numero'];
        $fields['complemento'] = $value['complemento'];
        $fields['bairro'] = $value['bairro'];
        $fields['cidade'] = $value['cidade'];
        $fields['uf'] = $value['uf'];
        $fields['pontoref'] = $value['pontoref'];
        $fields['operador_pk'] = $value['operador_pk'];
  
		$result = sql_query("SELECT * FROM agendaslead WHERE CodAgendaLead = " . mysqlnull($codagendalead));
 
        $anterior = mysql_fetch_assoc($result);
	 
		mysql_free_result($result);
	  
		$codagendalead = mysqlnull($codagendalead);

		$sql = sqlupdate('agendaslead', $fields, "CodAgendaLead = $codagendalead");	
    	sql_query($sql);
       
		if(isset($value['operadoras'])) leads::salvarOperadoras($value['codlead'], $value['operadoras']);
		else leads::salvarOperadoras($value['codlead'], '');

		$sql = "Select * From agendaslead Where CodAgendaLead = $codagendalead";
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		mysql_free_result($rs);
		$sql = "";
		$sql.= "Select Descricao From tipoagendamento Where CodTipo = {$row['CodTipo']}";
		$rs = sql_query($sql);
		$row1 = mysql_fetch_array($rs);
		$tipo = $row1['Descricao'];
		mysql_free_result($rs);

		$descricao = $tipo . ' - ' . date('d/m/Y \à\s H:i:s', strtotime($row['DataHorario'])).': '.$row['Descricao'];
		$codocorrencia = $row['CodOcorrenciaLead'];
		ocorrencias::alterar($codocorrencia, array('descricao' => $descricao));
		$gerentecontas = $value['gerentecontas'];
               
        if($value['datacancelamento']== 'null'){         
          agendaslead::salvargerentes($codagendalead, $gerentecontas,$value['codlead'],$value['acesso']);
		  agendaslead::leadsgerente($codagendalead, $gerentecontas, $value['codlead'],$value['acesso']);
		}
        
		$result = sql_query("SELECT * FROM agendaslead WHERE CodAgendaLead = " . $codagendalead);
		$atual = mysql_fetch_assoc($result);
		mysql_free_result($result);
		//Verifica se foi alterada de improdutiva para cancelada

		if($anterior['CodStatus'] == 2 && $atual['CodStatus'] == 4){
			$result = sql_query("SELECT * FROM ocorrenciaslead WHERE CodOcorrenciaLead = " . $atual['CodOcorrenciaLead']);
			$ocorrencia = mysql_fetch_assoc($result);
			mysql_free_result($result);
			agendaslead::alterar($atual['CodAgendaLead'], array('datacancelamento' => $ocorrencia['DataCadastro'], 'cancelamento' => $atual['Informacoes']));
			ocorrencias::alterar($codocorrencia, array('codtipoocorrencialead' => 38));
		}

        //ACESSO MOBILE
		if(!empty($acesso)){
			return array('codagendalead' => $codagendalead, 'codlead' => $codlead, 'reagendar'=>$reagendar);
	    }else{
			return ($codagendalead);
		}	
	}
	function excluir($codagendalead){

		//agendaslead::cancelar($codagendalead);
		$sql = "Select * From agendaslead Where CodAgendaLead = $codagendalead";
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		if(!$row)
			return false;
		$codocorrencia = $row['CodOcorrenciaLead'];
		mysql_free_result($rs);
		
		if(!empty($codocorrencia)){
			$sql = "Delete From ocorrenciaslead Where (CodOcorrenciaLead = $codocorrencia Or OcorrenciaSuperior = $codocorrencia)";
			sql_query($sql);
		}
		$sql = "Update agendaslead Set CodStatus = null,Datacancelamento=null Where CodStatus = 3 And CodReagendamento = $codagendalead";		
        sql_query($sql);
		
        $sql = "Update agendaslead Set CodReagendamento = null Where CodReagendamento = $codagendalead";
        sql_query($sql);
		$sql = "Delete From agendagerenteconta Where CodAgendaLead = $codagendalead";
		sql_query($sql);
//		$sql = "Delete From agendaslead Where CodAgendaLead = $codagendalead";
//		sql_query($sql);
		
		$sql = sqldelete('agendaslead',' CodAgendaLead = ' . mysqlnull($codagendalead));
		sql_query($sql);		

		return true;
	}
	function auditoria($codagendalead, $descricao,$codlead){
		$fields['auditoria'] = $descricao;
		$fields['CodStatus'] = 6;
		
		$sql = sqlupdate('agendaslead', $fields, ' codagendalead = ' . mysqlnull($codagendalead));

		mysql_query($sql);	
		
		$descricao = "Visita Auditada ".$descricao;	

		ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => $descricao, 'codtipoocorrencialead' => 6026));
		
	}
	function qualityservice($codagendalead, $descricao){
		$sql = "Select a.*, a.DataCadastro, t.Descricao Tipo ";
		$sql.= " From agendaslead a inner join tipoagendamento t on a.CodTipo = t.CodTipo ";
		$sql.= " Where CodAgendaLead = $codagendalead";
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		if(!$row)
			return false;
		$codlead = $row['CodLead'];
		$codocorrencia = $row['CodOcorrenciaLead'];
		agendaslead::alterar($codagendalead, array('qualityservice' => $descricao));
		$descricao = $row['Tipo'].' - '.date('d/m/Y \à\s H:i', strtotime($row['DataCadastro'])).': '.$descricao;
		mysql_free_result($rs);
		$sql = "Select * From ocorrenciaslead Where (CodOcorrenciaLead = $codocorrencia Or OcorrenciaSuperior = $codocorrencia) And CodTipoOcorrenciaLead = 23";
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		if($row){			
			$codocorrencia = $row['CodOcorrenciaLead'];			
			// ATUALIZA A DESCRIACAO DA OCORRENCIA E FECHA
			ocorrencias::alterar($codocorrencia, array('descricao' => $descricao,'datafechamento' => 'SYSDATE()'));			
		}
		else{
			ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => $descricao, 'codtipoocorrencialead' => 23, 'ocorrenciasuperior' => $codocorrencia));
		}
		mysql_free_result($rs);
		return true;
	}
	function cancelar($codagendalead, $cancelamento = null){
        //deleta a ordem de consultor para a agenda
		$sql = "delete from ordem_gc where CodAgendaGC = $codagendalead";
		mysql_query($sql);
		
		$sql = "Select a.*, t.Descricao Tipo";
		$sql.= " From agendaslead a inner join tipoagendamento t on a.CodTipo = t.CodTipo ";
		$sql.= " Where CodAgendaLead = " . mysqlnull($codagendalead);
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		if(!$row)
			return false;
		//if(empty($row['DataCancelamento']))
			//agendaslead::alterar($codagendalead, array('datacancelamento' => 'SYSDATE()'));		

        agendaslead::alterar($codagendalead, array('codstatus' => 4, 'cancelamento' => $cancelamento,'datacancelamento' => 'SYSDATE()'));
		$codlead = $row['CodLead'];
		$codocorrencia = $row['CodOcorrenciaLead'];
		$codtipo = $row['CodTipo'];
		$descricao = $row['Tipo'].' - '.date('d/m/Y \à\s H:i', strtotime($row['DataHorario'])).' - '.$cancelamento;
		mysql_free_result($rs);

		if ( $codocorrencia ){	
			//exclui ocorrencia de quality service
			sql_query("DELETE FROM ocorrenciaslead WHERE OcorrenciaSuperior = $codocorrencia AND CodTipoOcorrenciaLead in (23,6000)");
			$sql = "Select * From ocorrenciaslead Where (CodOcorrenciaLead = $codocorrencia Or OcorrenciaSuperior = $codocorrencia) And CodTipoOcorrenciaLead = 38";
			$rs = sql_query($sql);
			$row = mysql_fetch_array($rs);
				mysql_free_result($rs);
			if($row){
				$codocorrencia = $row['CodOcorrenciaLead'];
				ocorrencias::alterar($codocorrencia, array('descricao' => $descricao));
			}else{
				ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => $descricao, 'codtipoocorrencialead' => 38, 'ocorrenciasuperior' => $codocorrencia));
			}
		}
		if($codtipo == 1){
			$status = 3;
			$sql = "Select * From agendaslead where CodLead = $codlead And DataCancelamento Is Null And DataHorario > SYSDATE()";
			$rs = sql_query($sql);
			if(mysql_num_rows($rs) > 0)
				$status = 4;
			mysql_free_result($rs);
			$sql = "Select * From propostas where CodLead = $codlead And DataCancelamento Is Null";
			$rs = sql_query($sql);
			while($row = mysql_fetch_array($rs)){
				if(empty($row['DataRecebimentoContrato'])){
					if(!empty($row['DataEnvio']))
						$status = 5;
					if(!empty($row['DataPrevisaoRecebimento']))
						$status = 6;
				}
				if(!empty($row['DataRecebimentoo']) && $status < 10)
					$status = 10;
				if(!empty($row['DataEnvioContrato']) && $status < 10)
					$status = 12;
				if(!empty($row['DataEntregaAparelho']) && $status < 10)
					$status = 15;
			}
			$sql = "Update leads set CodStatusClassificacaoLead = $status Where CodLead = $codlead";
			sql_query($sql);
			mysql_free_result($rs);
		}

		return true;
	}

	function informacao($value){
	    //ATUALIZA CLASSIFICACAO DA AGENDA DE VISITAS
        $descricao = $value['informacoes'];
		$codlead = $value['codlead'];
		$acesso = $value['acesso'];
        agendaslead::alterar($value['codagendalead'], array('termino' => $value['termino'],'informacoes' => $value['informacoes'], 'codstatus' => $value['codstatus']));
        
        //CONSULTA DADOS DO AGENDAMENTO
        $sql = "Select 
                a.CodOcorrenciaLead
                , a.DataCadastro
                , t.Descricao Tipo
                From agendaslead a 
                  inner join tipoagendamento t on a.CodTipo = t.CodTipo
                Where CodAgendaLead = ".$value['codagendalead'];    
    
        $result = sql_query($sql);
		$row = mysql_fetch_array($result);
        if(!$row)
			return false;
        $codocorrencia = $row['CodOcorrenciaLead'];
        //DESCRICAO OC CLASSIFICACAO DA VISITA
        $descricao = $row['Tipo'].' - '.date('d/m/Y \á\s H:i', strtotime($row['DataCadastro'])).': '.$descricao;
        mysql_free_result($result);
        if(!empty($codocorrencia)){
     		$sql = "Select 
                    oc.codocorrencialead
                    From ocorrenciaslead oc 
                    Where (oc.CodOcorrenciaLead = $codocorrencia Or oc.OcorrenciaSuperior = $codocorrencia) 
                    And CodTipoOcorrenciaLead = 30";
    
            $result = sql_query($sql);
    		$row = mysql_fetch_array($result);
        }
		if($row){
			$codocorrencia = $row['CodOcorrenciaLead'];
			ocorrencias::alterar($codocorrencia, array('descricao' => $descricao));
		}else{
			ocorrencias::adicionar(array('codlead' => $value['codlead'], 'descricao' => $descricao, 'codtipoocorrencialead' => 30, 'ocorrenciasuperior' => $codocorrencia));
            
            //PROCESSO DE SEM INTERESSE
            if(!empty($value['codmotivolead'])){
               	//DATA DE CADSTRO DA OC
                if(!empty($value['datacadastro'])){
            		if(!empty($value['datacadastro'][0]) && !empty($value['datacadastro'][1])){
            			$value['datacadastro'] = dataYMD($value['datacadastro'][0]) . ' ' . $value['datacadastro'][1];
            		}else{
            			$value['datacadastro'] = null;
            		}
            	}
                //DATA DE VENCIMENTO DO CONTRATO
               	if(!empty($value['vencimentocontrato'])){
            		if(!empty($value['vencimentocontrato'])){
            			$value['vencimentocontrato'] = dataYMD($value['vencimentocontrato']) ;
            		}else{
            			$value['vencimentocontrato'] = null;
            		}
            	}
        	    //DATA DE VENCIMENTO DO CONTRATO   
            	if(!empty($value['datafechamento'])){
            		if(!empty($value['datafechamento'][0]) && !empty($value['datafechamento'][1])){
            			$value['datafechamento'] = dataYMD($value['datafechamento'][0]) . ' ' . $value['datafechamento'][1];
            		}else{
            			$value['datafechamento'] = null;
            		}
            	}
                $value['descricao'] = $value['informacoes'] ;
                ocorrencias::adicionar($value);
            }
		}
		mysql_free_result($rs);
        
        //ACESSO MOBILE
		if(!empty($acesso)){
			return array('codagendalead' => $codagendalead, 'codlead' => $codlead);
	    }else{
			return true;
		}
    
	}
	function fichaoi ($codagendalead, $value){
		$sql = "delete from ficha_visita_oi where agendaslead_pk=".$codagendalead;
		sql_query($sql);
	
		if(!isset($value['total_linha'])) ;
		if(!isset($value['qtde_minuto'])) ;				
		if(!isset($value['valor_atual_linha'])) ;		
		if(!isset($value['plano_atual_pacote']));
		if(!isset($value['plano_atual_linha']));
		if(!isset($value['valor_linha']));		
		if(!isset($value['valor_pacote']));
		if(!isset($value['plano_3g']));
		if(!isset($value['valor_atual_3g']));
		if(!isset($value['plano_atual_3g'])) ;
		if(!isset($value['valor_pacote_3g']));
		if(!isset($value['valor_atual_mes']));
		if(!isset($value['valor_proposto_mes']))
		if(!isset($value['valor_mes_longa'])) ;
		if(!isset($value['valor_mes_proposto_longa']));
		if(!isset($value['valor_nacional_longa']));
		if(!isset($value['valor_atual_pacote_longa']));
		if(!isset($value['plano_pacote_longa']));
		if(!isset($value['valor_pacote_longa']));
		if(!isset($value['valor_internacional_longa'])) ;
		if(!isset($value['valor_nacional_internacional_longa'])) ;
		if(!isset($value['plano_internacional_longa'])) ;
		if(!isset($value['valor_pacote_internacional_longa']));
		if(!isset($value['valor_atual_linha']));
		if(!isset($value['modelo']));
		if(!isset($value['modelo1']));
		if(!isset($value['multa']));
		if(!isset($value['valor_aparelho']));
		if(!isset($value['plano_dados']));
		if(!isset($value['valor_atual_pacote']));

		$fields['agendaslead_pk'] = $codagendalead;
		$fields['total_linha'] = str_replace(",", ".",$value['total_linha']);
		$fields['qtde_minuto'] = $value['total_linha'];
		
		$fields['valor_atual_linha'] = str_replace(",", ".", $value['valor_atual_linha']);
		$fields['plano_atual_pacote'] = str_replace(",", ".", $value['plano_atual_pacote']);
		$fields['plano_atual_linha'] = str_replace(",", ".", $value['plano_atual_linha']);
		$fields['valor_linha'] = str_replace(",", ".", $value['valor_linha']);
		
		$fields['valor_pacote'] = $value['valor_pacote'];
		$fields['plano_3g'] = $value['plano_3g'];
		$fields['valor_atual_3g'] =  $value['valor_atual_3g'];
		$fields['plano_atual_3g'] = $value['plano_atual_3g'];
		$fields['valor_pacote_3g'] = $value['valor_pacote_3g'];
		$fields['valor_atual_mes'] =  $value['valor_atual_mes'];
		$fields['valor_proposto_mes'] =  $value['valor_proposto_mes'];
		$fields['valor_mes_longa'] =  $value['valor_mes_longa'];
		$fields['valor_mes_proposto_longa'] =  $value['valor_mes_proposto_longa'];
		$fields['valor_nacional_longa'] =  $value['valor_nacional_longa'];
		$fields['valor_atual_pacote_longa'] =  $value['valor_atual_pacote_longa'];
		$fields['plano_pacote_longa'] =  $value['plano_pacote_longa'];
		$fields['valor_pacote_longa'] =  $value['valor_pacote_longa'];
		$fields['valor_internacional_longa'] =  $value['valor_internacional_longa'];
		$fields['valor_nacional_internacional_longa'] =  $value['valor_nacional_internacional_longa'];
		$fields['plano_internacional_longa'] =  $value['plano_internacional_longa'];
		$fields['valor_pacote_internacional_longa'] =  $value['valor_pacote_internacional_longa'];
		$fields['valor_atual_linha'] =  $value['valor_atual_linha'];
		$fields['modelo'] = $value['modelo'];
		$fields['modelo1'] = $value['modelo1'];
		$fields['multa'] = $value['multa'];
		$fields['valor_aparelho'] = $value['valor_aparelho'];
		$fields['plano_dados'] = $value['plano_dados'];		
		$fields['valor_atual_pacote'] =$value['valor_atual_pacote'];
		
		$sql = sqlinsert('ficha_visita_oi', $fields);

		sql_query($sql);
	}
    
    function enderecoleads($codlead,$endereco,$numero,$complemento,$bairro,$cep,$cidade,$uf,$pontoref){
        $fields['endereco'] = $endereco;
        $fields['numero'] = $numero;
        $fields['complemento'] = $complemento;
        $fields['bairro'] = $bairro;
        $fields['cep'] = $cep;
        $fields['cidade'] = $cidade;
        $fields['uf'] = $uf;
        $fields['pontoref'] = $pontoref;
        $sql = "Select
                    l.endereco,
                    l.numero,
                    l.complemento                        
                from leads l
                where l.codlead=".$codlead;
        
        $result = sql_query($sql);
  		$row = mysql_fetch_array($result);
          
        if(empty($row['endereco'])){
            $sql = "";
      		$sql.= sqlupdate('leads', $fields, "codlead = $codlead");
        
        
		    sql_query($sql);
        }       
    }
    function fila_agendamento($tamanho_visita_pk,$agendaslead_pk,$leads_pk){
        
        //VERIFICA O TAMANHA DA VISITA SE É PEQUENA OU GRANDE
        if($tamanho_visita_pk == 1 || $tamanho_visita_pk == 2 ){
            
            $sql="";
            $sql.="SELECT nfv.pk,tbu.Fk_Equipe
                    FROM n_fila_visitas nfv
                         INNER JOIN tb_usuarioequipe tbu
                            ON nfv.gerenteconta_pk = tbu.Fk_Usuario
                    ORDER BY nfv.pk DESC";
            
            $result = sql_query($sql);
            $row = mysql_fetch_array($result);            
            $ultima_equipe = $row['Fk_Equipe'];
            mysql_free_result($result);            
            
            $sql="";
            $sql.="SELECT ui.CodUsuarioInterno, ui.Nome
                    FROM usuariosinternos ui
                         INNER JOIN tb_usuarioequipe tbu
                            ON ui.CodUsuarioInterno = tbu.Fk_Usuario
                         LEFT JOIN n_fila_visitas nfv
                            ON ui.CodUsuarioInterno = nfv.gerenteconta_pk
                   WHERE ui.GerenteContas = 1";
            if(!empty($ultima_equipe)){
                $sql.=" and tbu.Fk_Equipe not in (".$ultima_equipe.")";
            }
            $sql.=" ORDER BY nfv.dt_cadastro,  nfv.gerenteconta_pk";
            
           
            $result = sql_query($sql);
            $row = mysql_fetch_array($result);            
            $gerente_conta_pk = $row['CodUsuarioInterno'];
            mysql_free_result($result);
            
            $fields['gerenteconta_pk'] = $gerente_conta_pk;
            $fields['leads_pk'] = $leads_pk;
            $fields['agenda_lead_pk'] = $agendaslead_pk;
            $fields['dt_cadastro'] = "sysdate()";
			$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
            $fields['dt_ult_atualizacao'] = "sysdate()";		
		    $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
            
            //CADASTRA A FILA
            $sql ="";
            $sql = sqlinsert('n_fila_visitas', $fields);                  
			mysql_query($sql); 
            
            
            agendaslead::salvargerentes($agendaslead_pk, $gerente_conta_pk, $leads_pk, $value['acesso']);
        }else{
            
            
        }
    }
}
?>
