<?
include_once "../../libs/datas.php";
include_once "../../libs/cla.ocorrencias.php";
include_once "classifcacao_visita_cla.php";

class propostas{

	private $pk;
	private $dt_cadastro;
	private $usuario_cadastro_pk;
	private $dt_ult_atualizacao;
	private $usuario_ult_atualizacao_pk;		
	private $leads_pk;
	private $agendalead_pk;
	private $ds_obs_proposta;
	private $n_pedido;	
	private $itens_voz;
	private $itens_combo;
	private $itens_dados;
	private $itens_modulos;
	private $itens_aparelhos;
	private $datas_proposta;
	private $operador_pk;
	private $motivo_cancelamento_pk;
    private $dsc_cancelamento_proposta;
	private $razaosocial;
	private $dt_validade;
	private $vl_total_proposta;
	private $trade_in;
	private $ddd;
    private $email_contato; 
    private $vl_desconto_claro;
    private $vl_ult_conta;
    private $h_termino_visita;
    private $dt_cancelamento;


	function getpk() {return $this->pk;}	
	function getdt_cadastro(){return $this->dt_cadastro;}
	function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
	function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
	function getleads_pk(){return $this->leads_pk;}
	function getagendalead_pk(){return $this->agendalead_pk;}
	function getds_obs_proposta(){return $this->ds_obs_proposta;}
	function getn_pedido(){return $this->n_pedido;}
	function getitens_voz(){return $this->itens_voz;}
	function getitens_combo(){return $this->itens_combo;}
	function getitens_dados(){return $this->itens_dados;}
	function getitens_modulos(){return $this->itens_modulos;}
	function getitens_aparelhos(){return $this->itens_aparelhos;}
	function getdatas_proposta(){return $this->datas_proposta;}
	function getoperador_pk(){return $this->operador_pk;}
	function getmotivo_cancelamento_pk(){return $this->motivo_cancelamento_pk;}
	function getdsc_cancelamento_proposta(){return $this->dsc_cancelamento_proposta;}
	function getrazaosocial(){return $this->razaosocial;}
	function getdt_validade(){return $this->dt_validade;}
	function getvl_total_proposta(){return $this->vl_total_proposta;}	
	function gettrade_in(){return $this->trade_in;}	
	function getddd(){return $this->ddd;}	
    function getemail_contato(){return $this->email_contato;}	
    function getdt_cancelamento(){return $this->dt_cancelamento;}	
        
        
    
    function getvl_desconto_claro(){return $this->vl_desconto_claro;}
    function getvl_ult_conta(){return $this->vl_ult_conta;}
    function geth_termino_visita(){return $this->h_termino_visita;}
	
	function getusuario_cadastro_nome_pk(){
		$strRetorno = "";
		$sql = "select nome from usuariosinternos where codusuariointerno = ".$this->usuario_cadastro_pk;
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$strRetorno = $row["nome"];
		}
		mysql_free_result($result);
		return $strRetorno;
	}

	function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
	function getusuario_ult_atualizacao_nome_pk(){
		$strRetorno = "";
		$sql = "select nome from usuariosinternos where codusuariointerno = ".$this->usuario_ult_atualizacao_pk;
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$strRetorno = $row["nome"];
		}
		mysql_free_result($result);
		return $strRetorno;
	}
	
	function setpk($pk){$this->pk = $pk;}
	function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
	function setcodproduto($codproduto){ $this->codproduto = $codproduto;}
	function setagendalead_pk($agendalead_pk){ $this->agendalead_pk = $agendalead_pk;}
	function setds_obs_proposta($ds_obs_proposta){ $this->ds_obs_proposta = $ds_obs_proposta;}
	function setn_pedido	($n_pedido){ $this->n_pedido = $n_pedido;}
	function setitens_voz($itens_voz){ $this->itens_voz = $itens_voz;}
	function setitens_combo($itens_combo){ $this->itens_combo = $itens_combo;}
	function setitens_dados($itens_dados){ $this->itens_dados = $itens_dados;}
	function setitens_modulos($itens_modulos){ $this->itens_modulos = $itens_modulos;}
	function setitens_aparelhos($itens_aparelhos){ $this->itens_aparelhos = $itens_aparelhos;}
	function setdatas_proposta($datas_proposta){ $this->datas_proposta = $datas_proposta;}
	function setoperador_pk($operador_pk){ $this->operador_pk = $operador_pk;}
	function setmotivo_cancelamento_pk($motivo_cancelamento_pk){ $this->motivo_cancelamento_pk = $motivo_cancelamento_pk;}
	function setdsc_cancelamento_proposta($dsc_cancelamento_proposta){ $this->dsc_cancelamento_proposta = $dsc_cancelamento_proposta;}
	function setrazaosocial($razaosocial){ $this->razaosocial = $razaosocial;}
	function setdt_validade($dt_validade){ $this->dt_validade = $dt_validade;}
	function setvl_total_proposta($vl_total_proposta){ $this->vl_total_proposta = $vl_total_proposta;}
	function settrade_in($trade_in){ $this->trade_in = $trade_in;}
	function setddd($ddd){ $this->ddd = $ddd;}
    function setemail_contato($email_contato){ $this->email_contato = $email_contato;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
        
        
    
    function setvl_desconto_claro($vl_desconto_claro){ $this->vl_desconto_claro = $vl_desconto_claro;}
    function setvl_ult_conta($vl_ult_conta){ $this->vl_ult_conta = $vl_ult_conta;}
    function seth_termino_visita($h_termino_visita){ $this->h_termino_visita = $h_termino_visita;}
   
	function __construct($pk){
		
		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
		$this->codproposta = null;
		$this->versao = null;
		$this->leads_pk = null;
		$this->codproduto = null;
		$this->codagendalead = null;
		$this->ds_obs_proposta = null;
		$this->n_pedido = null;
		$this->razaosocial = null;
		$this->dt_validade = null;
		$this->vl_total_proposta = null;
		$this->trade_in = null;
		$this->ddd = null;
        $this->email_contato = null;
        $this->vl_desconto_claro = null;
        $this->vl_ult_conta = null;
        $this->h_termino_visita = null;
        $this->dt_cancelamento = null;
		
		if ($pk != 0){
			$sql ="SELECT np.pk,
					   np.leads_pk, 
					   np.n_pedido,
					   np.operador_pk,
					   np.ds_obs_proposta,
					   l.razaosocial,
					   DATE_FORMAT(np.dt_validade, '%d/%m/%Y') dt_validade,
					   np.vl_total_proposta,
					   np.trade_in,
                       np.vl_desconto_claro,
                       np.vl_ult_conta,
                       np.email_contato,
                       ui.email,
                       ui.Nome,
                       np.dt_cancelamento
				  FROM n_propostas np 
				  inner join leads l on np.leads_pk = l.codlead
                  left JOIN usuariosinternos ui ON l.CodGerenteConta = ui.CodUsuarioInterno
				  where np.pk=".$pk;

			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$this->pk = $row['pk'];
				$this->leads_pk = $row['leads_pk'];
				$this->n_pedido = $row['n_pedido'];
				$this->operador_pk = $row['operador_pk'];
				$this->ds_obs_proposta = $row['ds_obs_proposta'];
				$this->razaosocial = $row['razaosocial'];
				$this->dt_validade = $row['dt_validade'];
				$this->vl_total_proposta = $row['vl_total_proposta'];
				$this->trade_in = $row['trade_in'];
                $this->vl_desconto_claro = $row['vl_desconto_claro'];
                $this->vl_ult_conta = $row['vl_ult_conta'];
                $this->email_contato = $row['email_contato'];
                $this->dt_cancelamento = $row['dt_cancelamento'];
                
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){		
		
		$fields['ds_obs_proposta'] = $this->ds_obs_proposta;
		$fields['dt_validade'] = dataYMD($this->dt_validade);
		$fields['n_pedido'] = $this->n_pedido;	
		$fields['vl_total_proposta']= moeda2float($this->vl_total_proposta);
		$fields['trade_in']= $this->trade_in;
		$fields['dt_ult_atualizacao'] = "sysdate()";		
		$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
        $fields['email_contato']= $this->email_contato;
                
        
        $fields['vl_desconto_claro'] = moeda2float($this->vl_desconto_claro);
        $fields['vl_ult_conta']= moeda2float($this->vl_ult_conta);
		
		//SALVA PROPOSTA
		if (empty($this->pk) || trim($this->pk) == ""){
			$fields['leads_pk'] = $this->leads_pk;
			$fields['agendalead_pk'] = $this->agendalead_pk;
			
			$fields['n_pedido'] = $this->n_pedido;
			$fields['operador_pk'] = $this->operador_pk;		
			$fields['dt_cadastro'] = "sysdate()";
			$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
		    
			$sql = sqlinsert('n_propostas', $fields);
           
			mysql_query($sql);
			$this->pk = mysql_insert_id();			
			
			//ADICIONA OC PROPOSTA GERADA
			ocorrencias::adicionar(array('codlead' => $this->leads_pk, 'descricao' => 'Proposta Gerada ID Proposta: '.$this->pk, 'codtipoocorrencialead' => 6));
				
		}else{
			$sql = sqlupdate('n_propostas', $fields, ' pk = ' . mysqlnull($this->pk));	
			mysql_query($sql);			
		}
		
		return $this->pk;
	}
	//SALVAR ITENS  PROPOSTA
	function add_itens_proposta($propostas_pk){	
		$sql ="delete from n_itens_propostas where propostas_pk=".$propostas_pk;
		mysql_query($sql);
		
		$fields['dt_cadastro'] = "sysdate()";
		$fields['dt_ult_atualizacao'] = "sysdate()";	
		$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
		$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
		
		//ITENS VOZ	
		$arrCampos ="";
		
		$arrVoz = split("////",$this->itens_voz);		
		for($i = 0; $i < count($arrVoz); $i++){
			if(trim($arrVoz[$i])!="" && !empty($arrVoz[$i])!=""){
				
				$arrCampos = split("##", $arrVoz[$i]);	
				$fields['propostas_pk']= $propostas_pk;
				$fields['produtos_pk']= $arrCampos[0];
				$fields['n_qtde']= $arrCampos[2];
				$fields['vl_unitario']= moeda2float($arrCampos[3]);
				$fields['ddd']= $arrCampos[9];				
				
				$sql = sqlinsert('n_itens_propostas', $fields);				
				
				mysql_query($sql);
					
				$itens_proposta_pk = mysql_insert_id();
				
				//ITENS PROPOSTA OPERADORA
				$this->add_itens_proposta_operadoras($itens_proposta_pk
                                                    ,$arrCampos[1]												
                                                    ,$arrCampos[5]
                                                    ,$arrCampos[6]
                                                    ,$arrCampos[7]
                                                    ,$arrCampos[8]
                                                    ,$arrCampos[10]
                                                    ,$arrCampos[11]
                                                    ,$arrCampos[12]);			
			}	
		}
     
		
		//ITENS COMBO
		$arrCampos="";
		$arrCombo = split("////",$this->itens_combo);		
		for($i = 0; $i < count($arrCombo); $i++){
			if(trim($arrCombo[$i])!="" && !empty($arrCombo[$i])!=""){
				$arrCampos = split("##", $arrCombo[$i]);
				$fields1['dt_cadastro'] = "sysdate()";
				$fields1['dt_ult_atualizacao'] = "sysdate()";	
				$fields1['usuario_cadastro_pk'] = $_SESSION['codusuario'];
				$fields1['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
				$fields1['propostas_pk']= $propostas_pk;
				$fields1['combos_pk']= $arrCampos[0];
				$fields1['n_qtde']= $arrCampos[1];
				$fields1['vl_unitario']= (moeda2float($arrCampos[2]));				
				
				$sql = sqlinsert('n_itens_propostas', $fields1); 
				
				mysql_query($sql);						
			}	
		}	
		//ITENS DADOS
		$arrCampos = "";
		$arrDados = split("////",$this->itens_dados);		
		for($i = 0; $i < count($arrDados); $i++){
			if(trim($arrDados[$i])!="" && !empty($arrDados[$i])!=""){
				$arrCampos = split("##", $arrDados[$i]);
				
				$fields['propostas_pk']= $propostas_pk;
				$fields['produtos_pk']= $arrCampos[0];
				$fields['n_qtde']= $arrCampos[1];
				$fields['vl_unitario']= (moeda2float($arrCampos[2]));
				
				$sql = sqlinsert('n_itens_propostas', $fields); 
				
				mysql_query($sql);								
			}	
		}
		//ITENS MODULOS
		$arrCampos = "";
		$arrModulos = split("////",$this->itens_modulos);		
		for($i = 0; $i < count($arrModulos); $i++){
			
			if(trim($arrModulos[$i])!="" && !empty($arrModulos[$i])!=""){
				$arrCampos = split("##", $arrModulos[$i]);
				
				$fields['propostas_pk']= $propostas_pk;
				$fields['produtos_pk']= $arrCampos[0];
				$fields['n_qtde']= $arrCampos[1];
				$fields['vl_unitario']= (moeda2float($arrCampos[2]));			
				
				$sql = sqlinsert('n_itens_propostas', $fields); 
				
				mysql_query($sql);				
			}	
		}		
		
	}
	//ITENS PROPOSTA OPERADORA
	function add_itens_proposta_operadoras($itens_propostas_pk,$tipo_linha_pk,$vl_franquia,$vl_vc1ir,$vl_vc1m,$vl_vc1f,$v_vces,$v_vces2m,$v_vces2f){
			
		$sql = "delete from n_itens_propostas_operadoras where itens_propostas_pk=".$itens_propostas_pk;	
		mysql_query($sql);	
				
		$fields['dt_cadastro'] = "sysdate()";
		$fields['dt_ult_atualizacao'] = "sysdate()";	
		$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
		$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
		$fields['itens_propostas_pk']= $itens_propostas_pk;	
		$fields['tipo_linha_pk']= $tipo_linha_pk;
		$fields['vl_franquia']= (moeda2float($vl_franquia));
		$fields['vl_vc1_local']= (moeda2float($vl_vc1ir));
		$fields['vl_vc2_local']= (moeda2float($vl_vc1m));
		$fields['vl_vc3_local']= (moeda2float($vl_vc1f));
                
        $fields['vl_vc1_Inter_Estad']= (moeda2float($v_vces));
		$fields['vl_vc2_Inter_Estad']= (moeda2float($v_vces2m));
		$fields['vl_vc3_Inter_Estad']= (moeda2float($v_vces2f));
		
		$sql = sqlinsert('n_itens_propostas_operadoras', $fields); 

		mysql_query($sql);		
		return;
	}	
	
	//SALVAR APARELHOS
	function add_proposta_aparelhos($propostas_pk){
		
		$sql = "delete from n_propostas_aparelhos where propostas_pk=".$propostas_pk;
		mysql_query($sql);
		
		$fields['dt_cadastro'] = "sysdate()";
		$fields['dt_ult_atualizacao'] = "sysdate()";	
		$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
		$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
		
		//ITENS APARELHOS
		$arrCampos = "";
		$arrAparelhos = split("////",$this->itens_aparelhos);		
		for($i = 0; $i < count($arrAparelhos); $i++){
			if(trim($arrAparelhos[$i])!="" && !empty($arrAparelhos[$i])!=""){
				$arrCampos = split("##", $arrAparelhos[$i]);				
				$fields['propostas_pk']= $propostas_pk;
				$fields['aparelhos_pk']= $arrCampos[0];
				$fields['n_qtde']= $arrCampos[1];
				$fields['vl_unitario']= (moeda2float($arrCampos[2]));
				$fields['forma_aquisicao_pk']= $arrCampos[3];
				$fields['parcelamento_pk']= $arrCampos[4];
				$fields['vl_desconto_aparelho']= (moeda2float($arrCampos[5]));
				
				$sql = sqlinsert('n_propostas_aparelhos', $fields); 
				
				mysql_query($sql);				
			}	
		}	
	}
	function proposta_datas($propostas_pk){
		$fields['dt_ult_atualizacao'] = "sysdate()";		
		$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
		
		//Verifica o status do lead atual e se o CNPJ estï¿½ preenchido		
		$sql = "Select
				l.codstatusclassificacaolead
				,l.cnpj_cpf
			   from leads l
			   where codlead=".$this->leads_pk;
		$result = sql_query($sql);
		$row = mysql_fetch_array($result);
		$v_statusclassificacaolead = $row['codstatusclassificacaolead'];	
		$v_cnpj_cpf = $row['cnpj_cpf'];
		
		
		$arrCampos = "";
		$arrDatas = split("////",$this->datas_proposta);
		for($i = 0; $i < count($arrDatas); $i++){
			
			if(trim($arrDatas[$i])!="" && !empty($arrDatas[$i])!=""){				
				$arrCampos = split("##", $arrDatas[$i]);
							
				$fields['propostas_pk']= $propostas_pk;
				$fields['data_proposta_operador_pk']= $arrCampos[0];
				$fields['vl_data_proposta']= dataYMD($arrCampos[1]);				
				$fields['vl_obs_data']= $arrCampos[2];	
				
				if(!empty($arrCampos[1])){	
					$sql = "Select
							 ndp.pk,
							 ndp.ds_label_data,
							 ndp.ds_data,
							 ndp.tipo_ocorrencia_pk,
							 ndp.statusclassificacaolead_pk
							from n_data_proposta_operador ndp
							where ndp.pk=".$arrCampos[0];
                            
					 $result = sql_query($sql);
					 $row = mysql_fetch_array($result);
                     
					
                            
					 //VERIFICA SE CNPJ ESTA PREENCHIDO NA DATA DE PREVISï¿½O DE RECEBIMENTO DO PEDIDO					
					if(empty($v_cnpj_cpf)){
						if($row['ds_label_data']=="previsao_recebe_assinatura"){
							javascriptalert('Preencha o CNPJ / CPF do Lead para dar continuidade!!!');
							exit;	
						}						
					}
					 $sql = "Select 
								ndp.data_proposta_operador_pk,
								DATE_FORMAT(ndp.vl_data_proposta, '%d/%m/%Y') vl_data,
								 ndpo.ds_label_data
							from n_datas_proposta ndp
							left join n_data_proposta_operador ndpo on ndp.data_proposta_operador_pk = ndpo.pk
								where ndp.propostas_pk=".$propostas_pk;
					 $sql .= "   and ndp.data_proposta_operador_pk=".$arrCampos[0];
					 $results = sql_query($sql);
					 $num = mysql_num_rows($results);
				
					if(empty($num)){
                        
							//Insert Data Proposta
							$fields['dt_cadastro'] = "sysdate()";
							$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
							
							$sql = sqlinsert('n_datas_proposta', $fields);
                                                    
							mysql_query($sql);	 
							
							ocorrencias::adicionar(array('codlead' => $this->leads_pk, 'descricao' => $row['ds_data'].' - '.$arrCampos[1], 'codtipoocorrencialead' => $row['tipo_ocorrencia_pk']));
							
							$fields1['codstatusclassificacaolead'] = $row['statusclassificacaolead_pk'];
							$sql = sqlupdate('leads', $fields1, ' codlead = ' . mysqlnull($this->leads_pk));
							mysql_query($sql);	
                            
                            //Quando a propostas for menor que 75% serão canceladas
                           if($row['ds_label_data']=="previsao_recebe_assinatura"){
                               
                                   $this->cancelamento_proposta();
                            }                      
					}else{	 						 
                    
						$sql = sqlupdate('n_datas_proposta', $fields, ' propostas_pk = ' . mysqlnull($propostas_pk).' and data_proposta_operador_pk='. mysqlnull($arrCampos[0]));		
						
						mysql_query($sql);
                        
					} 	 	 			
				}	
			}
		}				
	}	
	function cancelar($propostas_pk){
        
		$fields['dt_cancelamento'] =  "sysdate()";
		$fields['motivo_cancelamento_pk'] = $this->motivo_cancelamento_pk;
		$fields['dsc_cancelamento_propota'] = $this->dsc_cancelamento_proposta;		
		$sql = sqlupdate('n_propostas', $fields, ' pk = ' . mysqlnull($propostas_pk));		
		mysql_query($sql);
		ocorrencias::adicionar(array('codlead' => $this->leads_pk, 'descricao' => $this->dsc_cancelamento_proposta, 'codtipoocorrencialead' => 32));
        
        
			
		
		$sql ="";
		$sql.=" SELECT 'total_cliente' modulo,
				   count(0) total,
				   max(p.dt_cadastro) dt_cadastro
                FROM n_propostas p
				   INNER JOIN n_datas_proposta ndp ON p.pk = ndp.propostas_pk
				   INNER JOIN n_data_proposta_operador ndpo ON ndp.data_proposta_operador_pk = ndpo.pk
                WHERE p.leads_pk =".$this->leads_pk;
		$sql.=" AND ndpo.ds_label_data = 'cliente'
				AND p.dt_cancelamento IS NULL
                GROUP BY 'total_cliente'";
		$sql.="union";
		$sql.=" SELECT 'total_pedido_operadora' modulo,
				   count(0) total,
				   max(p.dt_cadastro) dt_cadastro
                FROM n_propostas p
                INNER JOIN n_datas_proposta ndp ON p.pk = ndp.propostas_pk
                INNER JOIN n_data_proposta_operador ndpo ON ndp.data_proposta_operador_pk = ndpo.pk
                WHERE p.leads_pk =".$this->leads_pk;
		$sql.=" AND ndpo.ds_label_data = 'envio_contrato_operadora'
				AND p.dt_cancelamento IS NULL
                GROUP BY 'total_pedido_operadora'";
		$sql.="union";
		$sql.=" SELECT 'total_pedido_recebido' modulo,
				   count(0) total,
				   max(p.dt_cadastro) dt_cadastro
                FROM n_propostas p
                INNER JOIN n_datas_proposta ndp ON p.pk = ndp.propostas_pk
                INNER JOIN n_data_proposta_operador ndpo ON ndp.data_proposta_operador_pk = ndpo.pk
                WHERE p.leads_pk =".$this->leads_pk;
		$sql.=" AND ndpo.ds_label_data = 'recebe_assinatura'
				AND p.dt_cancelamento IS NULL
                GROUP BY 'total_pedido_recebido'";
		$sql.="union";	
		$sql.=" SELECT 'total_propostas_previsao' modulo,
				   count(0) total,
				   max(p.dt_cadastro) dt_cadastro
                FROM n_propostas p
				INNER JOIN n_datas_proposta ndp ON p.pk = ndp.propostas_pk
                INNER JOIN n_data_proposta_operador ndpo ON ndp.data_proposta_operador_pk = ndpo.pk
                WHERE p.leads_pk =".$this->leads_pk;
		$sql.=" AND ndpo.ds_label_data = 'previsao_recebe_assinatura'
				AND p.dt_cancelamento IS NULL
                GROUP BY 'total_propostas_previsao'";
		$sql.="union  ";		
		$sql.=" SELECT 'total_propostas_enviadas' modulo,
				   count(0) total,
				   max(p.dt_cadastro) dt_cadastro
                FROM n_propostas p
				INNER JOIN n_datas_proposta ndp ON p.pk = ndp.propostas_pk
				INNER JOIN n_data_proposta_operador ndpo ON ndp.data_proposta_operador_pk = ndpo.pk
                WHERE p.leads_pk =".$this->leads_pk;
		$sql.=" AND ndpo.ds_label_data = 'envio_lead'
				AND p.dt_cancelamento IS NULL
                GROUP BY 'total_propostas_enviadas'";
		$sql.="union";
		$sql.=" SELECT 'total_visitas' modulo, count(0) total, max(datacadastro) dt_cadastro ";
		$sql.=" FROM agendaslead ";
		$sql.=" WHERE codlead = ".$this->leads_pk;
		$sql.=" AND codtipo = 1  ";
		$sql.=" GROUP BY 'total_visitas' ";
		$sql.="union";
		$sql.=" SELECT 'total_ocorrencias_sem_interesse' modulo, count(0) total, max(datacadastro) dt_cadastro ";
		$sql.=" FROM ocorrenciaslead oc ";
		$sql.=" WHERE oc.codlead = ".$this->leads_pk;
		$sql.=" AND oc.codtipoocorrencialead = 5  ";
		$sql.=" GROUP BY 'total_ocorrencias_sem_interesse' ";
		$sql.="order by 3 desc ";
		$result = mysql_query($sql);
		$num = mysql_num_rows($result);
		
		while($row = mysql_fetch_array($result)){
			if($row['modulo'] == 'total_ocorrencias_sem_interesse'){
				$this->alterarStatusLeadSemInteresse();				
			}
			elseif($row['modulo'] == 'total_visitas'){
				$this->alterarStatusLead25();
			}
			elseif($row['modulo'] == 'total_ocorrencias'){
				$this->alterarStatusLead0();
			}	
			elseif($row['modulo'] == 'total_propostas_enviadas'){
				$this->alterarStatusLeadPipe50();
			}
			elseif($row['modulo'] == 'total_propostas_previsao'){
				$this->alterarStatusLeadPipe75();
               
			}
			elseif($row['modulo'] == 'total_pedido_recebido'){
				$this->alterarStatusLeadPipe80();
			}
			elseif($row['modulo'] == 'total_pedido_operadora'){
				$this->alterarStatusLeadPipe90();
			}
			elseif($row['modulo'] == 'total_cliente'){
				$this->alterarStatusLeadCliente();
			}
					
			break;
		}
		mysql_free_result($result);
		return true;		
	}

	function excluir(){		
		$sql = "delete from propostas where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;		
	}	
	
	function alterarStatusLeadTarget(){
		$fields['codstatusclassificacaolead'] = 2;
		$sql = sqlupdate('leads', $fields, ' codlead = ' . mysqlnull($this->leads_pk));
		mysql_query($sql);
	}
	
	function alterarStatusLeadSemInteresse(){
		$fields['codstatusclassificacaolead'] = 1;
		$sql = sqlupdate('leads', $fields, ' codlead = ' . mysqlnull($this->leads_pk));
		mysql_query($sql);
	}			
	
	function alterarStatusLead0(){
		$fields['codstatusclassificacaolead'] = 3;
		$sql = sqlupdate('leads', $fields, ' codlead = ' . mysqlnull($this->leads_pk));
		mysql_query($sql);
	}		
	
	function alterarStatusLead25(){
		$fields['codstatusclassificacaolead'] = 4;
		$sql = sqlupdate('leads', $fields, ' codlead = ' . mysqlnull($this->leads_pk));
		mysql_query($sql);
	}	
	
	function alterarStatusLeadPipe50(){
		$fields['codstatusclassificacaolead'] = 5;
		$sql = sqlupdate('leads', $fields, ' codlead = ' . mysqlnull($this->leads_pk));
		mysql_query($sql);
	}
	
	function alterarStatusLeadPipe75(){
		$fields['codstatusclassificacaolead'] = 6;
		$sql = sqlupdate('leads', $fields, ' codlead = ' . mysqlnull($this->leads_pk));
		mysql_query($sql);
	}
	
	function alterarStatusLeadPipe80(){
		$fields['codstatusclassificacaolead'] = 10;
		$sql = sqlupdate('leads', $fields, ' codlead = ' . mysqlnull($this->leads_pk));
		mysql_query($sql);
	}
	
	function alterarStatusLeadPipe90(){
		$fields['codstatusclassificacaolead'] = 12;
		$sql = sqlupdate('leads', $fields, ' codlead = ' . mysqlnull($this->leads_pk));
		mysql_query($sql);
	}
	
	function alterarStatusLeadCliente(){
		$fields['codstatusclassificacaolead'] = 15;
		$sql = sqlupdate('leads', $fields, ' codlead = ' . mysqlnull($this->leads_pk));
		mysql_query($sql);
	}
    
	function cancelamento_proposta(){ 
        
             $sql="SELECT
                    n_datas_proposta.propostas_pk,
                    max(n_data_proposta_operador.statusclassificacaolead_pk)
                FROM n_datas_proposta
                INNER JOIN n_data_proposta_operador ON n_datas_proposta.data_proposta_operador_pk = n_data_proposta_operador.pk
                LEFT JOIN n_propostas ON n_datas_proposta.propostas_pk = n_propostas.pk 
                WHERE  n_propostas.leads_pk=$this->leads_pk
                AND n_datas_proposta.propostas_pk NOT IN ($this->pk)       
                GROUP BY n_datas_proposta.propostas_pk";
             $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)){
            if($row['max(n_data_proposta_operador.statusclassificacaolead_pk)'] <= 6){
                
                $fields['dt_cancelamento'] =  "sysdate()";	
                
                $sql = sqlupdate('n_propostas', $fields, ' pk = ' . mysqlnull($row['propostas_pk']));		
                mysql_query($sql);
            }
        }
    }
}
?>