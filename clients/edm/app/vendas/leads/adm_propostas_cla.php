<?
include_once "../../libs/datas.php";
include_once "../../libs/cla.ocorrencias.php";


class adm_propostas{
	
	private $pk;
	private $dt_cadastro;
	private $usuario_cadastro_pk;
	private $dt_ult_atualizacao;
	private $usuario_ult_atualizacao_pk;
	private $propostas_pk;
	private $leads_pk;
	private $operador_pk;
	private $data_proposta_operador_pk;
	private $vl_data;
	private $vl_obs_data;
    private $n_pedido;
    private $vl_pedido;
    private $email_consultor;
    private $Consultor;
    private $dsc_processo;
    private $razaosocial;
    private $cnpj_cpf;
    private $nomeusuario;
    private  $email_usuario;
    
    function getpk() {return $this->pk;}
	function getdt_cadastro(){return $this->dt_cadastro;}
	function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
	function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
	function getpropostas_pk(){return $this->propostas_pk;}
	function getleads_pk(){return $this->leads_pk;}
	function getoperador_pk(){return $this->operador_pk;}
	function getdata_proposta_operador_pk(){return $this->data_proposta_operador_pk;}
	function getvl_data(){return $this->vl_data;}
	function getvl_obs_data(){return $this->vl_obs_data;}
    function getn_pedido(){return $this->n_pedido;}
    function getvl_pedido(){return $this->vl_pedido;}
    function getemail_consultor(){return $this->email_consultor;}
    function getConsultor(){return $this->Consultor;}
    function getdsc_processo(){return $this->dsc_processo;}
    function getrazaosocial(){return $this->razaosocial;}
    function getcnpj_cpf(){return $this->cnpj_cpf;}
    function getnomeusuario(){return $this->nomeusuario;}
    function getemail_usuario(){return $this->email_usuario;}
    
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
	function setpropostas_pk($propostas_pk){ $this->propostas_pk = $propostas_pk;}
	function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
	function setoperador_pk($operador_pk){ $this->operador_pk = $operador_pk;}
	function setdata_proposta_operador_pk($data_proposta_operador_pk){ $this->data_proposta_operador_pk = $data_proposta_operador_pk;}
	function setvl_data($vl_data){ $this->vl_data = $vl_data;}
	function setvl_obs_data($vl_obs_data){ $this->vl_obs_data = $vl_obs_data;}
    function setn_pedido($n_pedido){ $this->n_pedido = $n_pedido;}
    function setvl_pedido($vl_pedido){ $this->vl_pedido = $vl_pedido;}
    function setemail_consultor($email_consultor){ $this->email_consultor = $email_consultor;}
    function setConsultor($Consultor){ $this->Consultor = $Consultor;}
    function setdsc_processo($dsc_processo){ $this->dsc_processo = $dsc_processo;}
    function setrazaosocial ($razaosocial) { $this->razaosocial = $razaosocial;}
    function setcnpj_cpf ($cnpj_cpf) { $this->cnpj_cpf = $cnpj_cpf;}
    function setnomeusuario ($nomeusuario) { $this->nomeusuario = $nomeusuario;}
    function setemail_usuario ($email_usuario) { $this->email_usuario = $email_usuario;}
    
	function __construct($pk){
		
		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
		$this->leads_pk = null;
		$this->n_pedido = null;
        $this->vl_pedido = null;
        $this->email_consultor = null;
        $this->Consultor = null;
        $this->dsc_processo = null;
        $this->razaosocial = null;
        $this->cnpj_cpf = null;
        $this->nomeusuario = null;
        $this->email_usuario = null;
		if ($pk != 0){
			$sql ="SELECT np.pk,
					   np.leads_pk, 
					   np.n_pedido,
					   np.operador_pk,
					   np.ds_obs_proposta,
                       np.n_pedido,
                       np.vl_pedido
				  FROM n_propostas np
				  where np.pk=".$pk;
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
                
				$this->pk = $row['pk'];
				$this->leads_pk = $row['leads_pk'];
				$this->n_pedido = $row['n_pedido'];
				$this->operador_pk = $row['operador_pk'];
				$this->ds_obs_proposta = $row['ds_obs_proposta'];
                $this->n_pedido = $row['n_pedido'];
                $this->vl_pedido = $row['vl_pedido'];
                $this->email_consultor = $row['email_consultor'];
                $this->Consultor = $row['Consultor'];
                $this->dsc_processo = $row['dsc_processo'];
                $this->razaosocial = $row['razaosocial'];
                $this->cnpj_cpf = $row['cnpj_cpf'];
                $this->nomeusuario = $row['nomeusuario'];
                $this->email_usuario = $row1['email_usuario'];
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){
		$fields['dt_ult_atualizacao'] = "sysdate()";
		$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
		$fields['propostas_pk'] = $this->propostas_pk;
		$fields['data_proposta_operador_pk'] = $this->data_proposta_operador_pk;
		$fields['vl_data_proposta'] = dataYMD($this->vl_data);
		$fields['vl_obs_data'] = $this->vl_obs_data;
				
		//SALVA PROPOSTA
		if (empty($this->pk) || trim($this->pk) == ""){
			$fields['dt_cadastro'] = "sysdate()";
			$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
		    $sql = "";
			$sql.= sqlinsert('n_datas_proposta', $fields);
			mysql_query($sql);
            
            
            
            //CADASTRA O NUMERO DO PEDIDO E VALOR

           $sql = "";
           $sql.= sqlupdate('n_propostas', array("n_pedido" => $this->n_pedido,"vl_pedido" =>  (moeda2float($this->vl_pedido))), 'pk = ' . $this->propostas_pk);
       
           mysql_query($sql);
			
			//ATUALIZA DATA VENCIMENTO CONTRATO
            $sql = "";
			$sql.= "Select
						ndpo.statusclassificacaolead_pk
					from n_data_proposta_operador ndpo
					where ndpo.pk=".$this->data_proposta_operador_pk;

		    $result = sql_query($sql);
		    $row = mysql_fetch_array($result);
           
           
                
		    if($row['statusclassificacaolead_pk']==15){
                        //ALTERA DATA DE VENCIMENTO DE CONTRATO
                      $vencimento_contrato = '';
                      $vencimento_contrato = SomarData($this->vl_data, 0, 12, 0);

                      $sql = "";
                      $sql = sqlupdate('leads', array("vencimentocontrato" => dataYMD($vencimento_contrato), "ativacao" => dataYMD($this->vl_data)), 'codlead = ' . $this->leads_pk);

                      sql_query($sql);
                      
                      /*$vencimento_contrato = '';
                      $vencimento_contrato = SomarData("sysdate()", 0, 12, 0);
                      $sql = "";
                      $sql = sqlupdate('n_leads_dados_vencimento', array("dt_vencimento" => dataYMD($vencimento_contrato)), 'leads_pk = ' . $this->leads_pk);

                      sql_query($sql);*/
                      //CHAMA FUNวรO SETA OPERADORA E BASE O LEAD
                      
                      $this->marca_operadora();
                      $this->cliente();
                      $this->dt_ativacao();
                      $this->dt_cancelamento();
                     
			}			
		}	
		return $this->pk;
	}
	
	function add_ocorrencia(){
		$sql = "Select
				 ndp.tipo_ocorrencia_pk,
				 ndp.ds_data
				from n_data_proposta_operador ndp
				where ndp.pk=".$this->data_proposta_operador_pk;
				
				$result = sql_query($sql);
				$row = mysql_fetch_array($result);
				
				if(!empty($row['tipo_ocorrencia_pk'])){
                    
                    
					ocorrencias::adicionar(array('codlead' => $this->leads_pk, 'descricao' => $row['ds_data'].' - Data: ' .$this->vl_data.'  '.$this->vl_obs_data, 'codtipoocorrencialead' => $row['tipo_ocorrencia_pk']));
                    
                    
				}	
			return;
					
	}
	function status_lead(){
		$sql = "Select
				 ndp.statusclassificacaolead_pk
				from n_data_proposta_operador ndp
				where ndp.pk=".$this->data_proposta_operador_pk;
				$result = sql_query($sql);
				$row = mysql_fetch_array($result);
				
				if(!empty($row['statusclassificacaolead_pk'])){
					$fields['CodStatusClassificacaoLead'] = $row['statusclassificacaolead_pk'];
					$sql = sqlupdate('leads', $fields, ' codlead = ' . mysqlnull($this->leads_pk));
					mysql_query($sql);
				}
			return;
	}
    function marca_operadora(){
		$sql ="";
		$sql.="SELECT op.cod_operadora, op.dsc_operadora
                        FROM operadoras op
                             INNER JOIN operador o ON op.dsc_operadora = o.dsc_operador
                             INNER JOIN empresa_operador eo ON o.cod_operador = eo.cod_operador
                      where o.cod_operador=".$this->operador_pk;
		
                    $result = mysql_query($sql);
                    $row = mysql_fetch_array($result);
                    $operadora_pk = $row['cod_operadora'];
		
                mysql_free_result($result);
                
                
        $sql = "delete from n_leads_dados_base where leads_pk=".$this->leads_pk." and operadora_pk=".$operadora_pk;

                mysql_query($sql);

                $fields['dt_cadastro'] = "sysdate()";
                $fields['dt_ult_atualizacao'] = "sysdate()";
                $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
                $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
                $fields['leads_pk']= $this->leads_pk;
                $fields['operadora_pk']= $operadora_pk;
                $fields['lead_cliente_base']= 1;
                
                $sql = "";
                $sql.= sqlinsert('n_leads_dados_base', $fields);
                
                mysql_query($sql);
	}
    
    function add_bko(){
        if($this->data_proposta_operador_pk==206){
            $sql="";
            $sql.="SELECT ui.CodUsuarioInterno, ui.Nome
                    FROM usuariosinternos ui
                         INNER JOIN gruposusuariosinternos_usuariosinternos gu
                            ON ui.CodUsuarioInterno = gu.CodUsuarioInterno
                         INNER JOIN n_fila_bko nf ON ui.CodUsuarioInterno = nf.bko_pk
                   WHERE gu.CodGrupoUsuarioInterno = 4
                  ORDER BY  nf.dt_cadastro";
            
            $result = sql_query($sql);
            $row = mysql_fetch_array($result);
            $bko = $row['CodUsuarioInterno'];
            mysql_free_result($result);
            
            $fields1['propostas_pk'] = $this->propostas_pk;
            $fields1['leads_pk'] = $this->leads_pk;
            $fields1['bko_pk'] = $bko;
            $fields1['dt_cadastro'] = "sysdate()";
			$fields1['usuario_cadastro_pk'] = $_SESSION['codusuario'];
            $fields1['dt_ult_atualizacao'] = "sysdate()";
		    $fields1['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
            
            //CADASTRA A FILA
            $sql ="";
            $sql = sqlinsert('n_fila_bko', $fields1);
             
			mysql_query($sql);
            
            //CADASTRA BKO NA PROPOSTA
            $sql = "";
            $sql = sqlupdate('n_propostas', array("bko_pk" => $bko), 'pk = ' . $this->propostas_pk);
            sql_query($sql);
            //GERA OCORRENCIA COM RETORNO PARA BKO
            $fields2['codlead'] = $this->leads_pk;
            $fields2['Descricao'] = "Aviso de novo Pedido para BKO";
            $fields2['CodTipoOcorrenciaLead'] = '6036';
            $fields2['DataCadastro'] = "sysdate()";
            $fields2['CodUsuarioInterno'] = $bko;
            $fields2['agendadopara'] = $bko;
            $fields2['dt_retorno'] = "sysdate()";
            $fields2['dt_retorno'] = "sysdate()";
                
            $sql ="";
            $sql = sqlinsert('ocorrenciaslead', $fields2);
            sql_query($sql);    
        }
    }
    
	function excluir(){
		$sql = "delete from propostas where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;
	}
    function cliente(){
        $sql ="";
		$sql.="SELECT op.cod_operadora, op.dsc_operadora
                        FROM operadoras op
                             INNER JOIN operador o ON op.dsc_operadora = o.dsc_operador
                             INNER JOIN empresa_operador eo ON o.cod_operador = eo.cod_operador
                      WHERE o.cod_operador=".$this->operador_pk;
		
                $result = mysql_query($sql);
                $row = mysql_fetch_array($result);
                $operadora_pk = $row['cod_operadora'];

                mysql_free_result($result);

        $sql = "DELETE FROM n_leads_dados_cliente WHERE leads_pk=".$this->leads_pk." and operadora_pk=".$operadora_pk;

                mysql_query($sql);

                $fields['dt_cadastro'] = "sysdate()";
                $fields['dt_ult_atualizacao'] = "sysdate()";
                $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
                $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
                $fields['leads_pk']= $this->leads_pk;
                $fields['operadora_pk']= $operadora_pk;
                $fields['lead_cliente']= 1;
                
        $sql = "";
        $sql.= sqlinsert('n_leads_dados_cliente', $fields);

                mysql_query($sql);
    }
   function dt_ativacao(){
        $sql ="";
		$sql.="SELECT op.cod_operadora, op.dsc_operadora
                        FROM operadoras op
                             INNER JOIN operador o ON op.dsc_operadora = o.dsc_operador
                             INNER JOIN empresa_operador eo ON o.cod_operador = eo.cod_operador
                      WHERE o.cod_operador=".$this->operador_pk;
		
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$operadora_pk = $row['cod_operadora'];
		
		mysql_free_result($result);
        
        
        $sql = "DELETE FROM n_leads_dados_ativacao WHERE leads_pk=".$this->leads_pk." AND operadora_pk=".$operadora_pk;

        mysql_query($sql);
     
        $fields['dt_cadastro'] = "sysdate()";
        $fields['dt_ult_atualizacao'] = "sysdate()";
        $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
        $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
        $fields['leads_pk']= $this->leads_pk;
        $fields['operadora_pk']= $operadora_pk;
        $fields['dt_ativacao']= "sysdate()";
        $sql = "";
        $sql.= sqlinsert('n_leads_dados_ativacao', $fields);
        mysql_query($sql);
    }
    
   function dt_cancelamento(){
        $sql ="";
		$sql.="SELECT op.cod_operadora, op.dsc_operadora
                        FROM operadoras op
                             INNER JOIN operador o ON op.dsc_operadora = o.dsc_operador
                             INNER JOIN empresa_operador eo ON o.cod_operador = eo.cod_operador
                      WHERE o.cod_operador=".$this->operador_pk;
		
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$operadora_pk = $row['cod_operadora'];
		
		mysql_free_result($result);
        
        
        $sql = "DELETE FROM n_leads_dados_vencimento WHERE leads_pk=".$this->leads_pk." AND operadora_pk=".$operadora_pk;

        mysql_query($sql);
        
        date_default_timezone_set('America/Sao_Paulo');
        $dt_vencimento = date('d/m/y');
        
        $fields['dt_cadastro'] = "sysdate()";
        $fields['dt_ult_atualizacao'] = "sysdate()";
        $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
        $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
        $fields['leads_pk']= $this->leads_pk;
        $fields['operadora_pk']= $operadora_pk;
        $fields['dt_vencimento']=  SomarData($dt_vencimento,0,12,0);
        $sql = "";
        $sql.= sqlinsert('n_leads_dados_vencimento', $fields);
        mysql_query($sql);
        
        
    }
}
?>