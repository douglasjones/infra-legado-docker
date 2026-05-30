<?

include_once "datas.php" ;

class campanha {
	
	//cria as variaveis das propriedades
	private $cod_campanha;
	private $nome_campanha;
	private $dt_inicio_campanha;
	private $dt_fim_campanha;
	private $descricao_campanha;
	private $cod_polo;
	private $mailing;
	private $codstatusclassificacaolead;
	private $codmotivo;
	private $dt_vencimento_contrato_de;
	private $cod_operadora;
	private $codgerenteconta;
	private $dt_vencimento_contrato_ate;
	
	//cria os metodos de acesso as propriedades
	function setcod_campanha($cod_campanha){ $this->cod_campanha = $cod_campanha;}
	function setnome_campanha($nome_campanha){ $this->nome_campanha = $nome_campanha;}
	function setdt_inicio_campanha($dt_inicio_campanha){ $this->dt_inicio_campanha = $dt_inicio_campanha;}
	function setdescricao_campanha($descricao_campanha){ $this->descricao_campanha = $descricao_campanha;}
	function setcod_polo($cod_polo){ $this->cod_polo = $cod_polo;}
	function setmailing($mailing){ $this->mailing = $mailing;}
	function setcodstatusclassificacaolead($codstatusclassificacaolead){ $this->codstatusclassificacaolead = $codstatusclassificacaolead;}
	function setCodMotivo($codmotivo){ $this->CodMotivo = $codmotivo;}
	function setdt_vencimento_contrato_de($dt_vencimento_contrato_de){ $this->dt_vencimento_contrato_de = $dt_vencimento_contrato_de;}
	function setcod_operadora($cod_operadora){ $this->cod_operadora = $cod_operadora;}
	function setcodgerenteconta($codgerenteconta){ $this->codgerenteconta = $codgerenteconta;}
	function setdt_vencimento_contrato_ate($dt_vencimento_contrato_ate){ $this->dt_vencimento_contrato_ate = $dt_vencimento_contrato_ate;}
	
	//cria os métodos de leitura das propriedades
	function getcod_campanha(){return $this->cod_campanha;}
	function getnome_campanha(){return $this->nome_campanha;}
	function getdt_inicio_campanha(){return $this->dt_inicio_campanha;}
	function getdt_fim_campanha(){return $this->dt_fim_campanha;}
	function getdescricao_campanha(){return $this->descricao_campanha;}
	function getcod_polo(){return $this->cod_polo;}
	function getmailing(){return $this->mailing;}
	function getcodstatusclassificacaolead(){return $this->codstatusclassificacaolead;}
	function getCodMotivo(){return $this->codmotivo;}
	function getdt_vencimento_contrato_de(){return $this->dt_vencimento_contrato_de;}
	function getcod_operadora(){return $this->cod_operadora;}
	function getcodgerenteconta(){return $this->codgerenteconta;}
	function getdt_vencimento_contrato_ate(){return $this->dt_vencimento_contrato_ate;}
	
	//construtor da classe
	function __construct($cod_campanha){
		
		$this->nome_campanha = null;
		$this->dt_inicio_campanha = null;
		$this->dt_fim_campanha = null;
		$this->descricao_campanha = null;
		$this->cod_polo = null;
		$this->mailing = null;
		$this->codstatusclassificacaolead = null;
		$this->codmotivo = null;
		$this->dt_vencimento_contrato_de = null;
		$this->cod_operadora = null;
		$this->codgerenteconta = null;
		$this->dt_vencimento_contrato_ate = null;
		
		//quando for zero, será criada uma classe vazia;
		if ($cod_campanha != 0){
			$sql = "Select cod_campanha, ";
			$sql.="        nome_campanha, ";
			$sql.="        date_format(dt_inicio_campanha,'%d/%m/%Y') dt_inicio_campanha, ";
			$sql.="        date_format(dt_fim_campanha,'%d/%m/%Y') dt_fim_campanha, ";
			$sql.="        descricao_campanha, ";
			$sql.="        cod_polo, ";
			$sql.="        mailing_pk, ";
			$sql.="        codstatusclassificacaolead, ";
			$sql.="        codmotivo, ";
			$sql.="        date_format(dt_vencimento_contrato_de,'%d/%m/%Y') dt_vencimento_contrato_de, ";
			$sql.="        date_format(dt_vencimento_contrato_ate,'%d/%m/%Y') dt_vencimento_contrato_ate, ";
			$sql.="        cod_operadora, ";
			$sql.="        codgerenteconta ";
			$sql.="   from campanha ";
		  	$sql.="  where cod_campanha=$cod_campanha";
			$result = mysql_query($sql);	
			while($row = mysql_fetch_array($result)){
				$this->cod_campanha = $row['cod_campanha'];
				$this->nome_campanha = $row['nome_campanha'];
				$this->dt_inicio_campanha = $row['dt_inicio_campanha'];
				$this->dt_fim_campanha = $row['dt_fim_campanha'];
				$this->descricao_campanha = $row['descricao_campanha'];
				$this->cod_polo = $row['cod_polo'];
				$this->mailing = $row['mailing_pk'];
				$this->codstatusclassificacaolead = $row['codstatusclassificacaolead'];
				$this->codmotivo = $row['codmotivo'];
				$this->dt_vencimento_contrato_de = $row['dt_vencimento_contrato_de'];
				$this->cod_operadora = $row['cod_operadora'];
				$this->codgerenteconta = $row['codgerenteconta'];
				$this->dt_vencimento_contrato_ate = $row['dt_vencimento_contrato_ate'];
			}
			mysql_free_result($result);
		}
		
	}
	
	//ADICIONAR NOVA CAMPANHA
	function salvar(){
		
		$fields['nome_campanha'] = $this->nome_campanha;
		$fields['dt_inicio_campanha'] = DataYMD($this->dt_inicio_campanha);
		$fields['descricao_campanha'] = $this->descricao_campanha;
		$fields['cod_polo'] = $this->cod_polo;
		$fields['mailing_pk'] = $this->mailing;
		$fields['codstatusclassificacaolead'] = $this->codstatusclassificacaolead;
		$fields['CodMotivo'] = $this->CodMotivo;
		$fields['cod_operadora'] = $this->cod_operadora;
		$fields['codgerenteconta'] = $this->codgerenteconta;
		
		if(!empty($this->dt_vencimento_contrato_de))
			$fields['dt_vencimento_contrato_de'] = DataYMD($this->dt_vencimento_contrato_de);
			
		if(!empty($this->dt_vencimento_contrato_ate))
			$fields['dt_vencimento_contrato_ate'] = DataYMD($this->dt_vencimento_contrato_ate);
		
		if (empty($this->cod_campanha) || trim($this->cod_campanha) == ""){
			
			$sql = sqlinsert('campanha', $fields);
			mysql_query($sql);
			$cod_campanha = mysql_insert_id();
			
			$this->cod_campanha = $cod_campanha;
			
		}
		else{
			$sql = sqlupdate('campanha', $fields, ' cod_campanha = ' . mysqlnull($this->cod_campanha));	
			mysql_query($sql);
		}
		
		return $cod_campanha;
	}
	
	function montarSQLSimulacao (){
		
		$sql = "";
		$sql.="select codlead  ";
		$sql.="  from leads ";
		$sql.=" where 1 = 1 ";
		if (!empty($this->codoperador))
			$sql.="   and codatendente = ".$this->codoperador;
		
		if(!empty($this->dt_vencimento_contrato_de))
			$sql.="   and vencimentocontrato >= '".DataYMD($this->dt_vencimento_contrato_de)."' ";
		
		if(!empty($this->dt_vencimento_contrato_ate))
			$sql.="   and vencimentocontrato <= '".DataYMD($this->dt_vencimento_contrato_ate)."' ";
		
		if(!empty($this->codgerenteconta))
			$sql.="   and codgerenteconta = ".$this->codgerenteconta;
		
		if(!empty($this->codmotivo))
			$sql.="   and codmotivo = ".$this->codmotivo." ";
		
		if(!empty($this->mailing))
			$sql.="   and mailing_pk = '".$this->mailing."' ";
		
		if(!empty($this->codstatusclassificacaolead))
			$sql.="   and codstatusclassificacaolead = ".$this->codstatusclassificacaolead;
			
		if(!empty($this->cod_polo) && $this->cod_polo != 100)
			$sql.="   and cod_polo = ".$this->cod_polo;
		
		$sql.=" and codlead not in (select codlead ";
		$sql.="  from campanha_leads ";
		$sql.=" where cod_campanha = ".$this->cod_campanha;
		$sql.="   and codocorrencia_abertura is not null ";
		$sql.="   and codocorrencia_sucesso is null ";
		$sql.="   and codocorrencia_semsucesso is null ";
		$sql.="   and codocorrencia_fechamento is null ) ";
		
		return $sql;
		
	}
	
	function criarAssociacao(){
		
		$sql = $this->montarSQLSimulacao();
		
		$result = mysql_query($sql);
		$retorno = 0;
		while($row = mysql_fetch_array($result)){
		
			$codocorrencialead = $this->inserirOcorrenciaAbertura($row['codlead']);
			
			$sql = "insert into campanha_leads (cod_campanha, codlead, codocorrencia_abertura) values(".$this->cod_campanha.", ".$row['codlead'].", $codocorrencialead) ";
			mysql_query($sql);
			$retorno ++;
		}
		mysql_free_result($result);
		
		return $retorno;
	
	}
	
	function criarSimulacao(){
		
		$sql = $this->montarSQLSimulacao();
		
		$result = mysql_query($sql);
		$retorno = 0;
		while($row = mysql_fetch_array($result)){
			$retorno ++;
		}
		mysql_free_result($result);
		
		return $retorno;
	}

	function campanha_lead($codlead){
		
		$cod_campanha = 0;
		
		$sql ="";
		$sql.="select cod_campanha ";
		$sql.="  from campanha_leads ";
		$sql.=" where codlead = $codlead ";
		$sql.="   and codocorrencia_abertura is not null ";
		$sql.="   and codocorrencia_sucesso is null ";
		$sql.="   and codocorrencia_semsucesso is null ";
		$sql.="   and codocorrencia_fechamento is null ";
		
		
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$cod_campanha = $row['cod_campanha'];
		}
		mysql_free_result($result);
		
		$this->__construct($cod_campanha);
	}
	
	function participarCampanha($codlead, $resultado_campanha){
		
		$sql ="";
		$sql.="select codlead, codocorrencia_abertura ";
		$sql.="  from campanha_leads ";
		$sql.=" where cod_campanha = ".$this->cod_campanha;
		$sql.="   and codlead = $codlead ";
		$sql.="   and codocorrencia_abertura is not null ";
		$sql.="   and codocorrencia_sucesso is null ";
		$sql.="   and codocorrencia_semsucesso is null ";
		$sql.="   and codocorrencia_fechamento is null ";
		
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			
			//fecha a ocorrencia da campanha que está aberta
			$sql ="update ocorrenciaslead set ";
			$sql.="  datafechamento = sysdate() ";
			$sql.=" where codocorrencialead = ".$row['codocorrencia_abertura'];
			mysql_query($sql);
			
			if($resultado_campanha == 1){
				$codocorrencialead = $this->inserirOcorrenciaSucesso($codlead);
			}
			else{
				$codocorrencialead = $this->inserirOcorrenciaSemSucesso($codlead);
			}
			
			//atualiza a campanha do lead
			$sql = " update campanha_leads set ";
			if($resultado_campanha == 1){
				$sql.= "   codocorrencia_sucesso = $codocorrencialead ";
			}
			else{
				$sql.= "   codocorrencia_semsucesso = $codocorrencialead ";
			}
			$sql.= " where codlead = ".$codlead;
			$sql.= "   and cod_campanha = ".$this->cod_campanha;
			
			mysql_query($sql);
		}
		mysql_query($result);
		
	}
	
	function fecharCampanha(){
		
		//atualiza a data de fechamento da campanha
		$sql ="";
		$sql.="update campanha set ";
		$sql.="   dt_fim_campanha = sysdate() ";
		$sql.=" where cod_campanha = ".$this->cod_campanha;
		mysql_query($sql);
		
		$sql ="";
		$sql.="select codlead, codocorrencia_abertura ";
		$sql.="  from campanha_leads ";
		$sql.=" where cod_campanha = ".$this->cod_campanha;
		$sql.="   and codocorrencia_abertura is not null ";
		$sql.="   and codocorrencia_sucesso is null ";
		$sql.="   and codocorrencia_semsucesso is null ";
		$sql.="   and codocorrencia_fechamento is null ";
		
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			
			//fecha a ocorrencia da campanha que está aberta
			$sql ="update ocorrenciaslead set ";
			$sql.="  datafechamento = sysdate() ";
			$sql.=" where codocorrencialead = ".$row['codocorrencia_abertura'];
			mysql_query($sql);
			
			$codocorrencialead = $this->inserirOcorrenciaFechamento($row['codlead']);
			
			$sql = "";
			$sql.="update campanha_leads set ";
			$sql.="  codocorrencia_fechamento = $codocorrencialead ";
			$sql.=" where codlead = ".$row['codlead'];
			$sql.="   and cod_campanha = ".$this->cod_campanha;
			
			mysql_query($sql);
			
		}
		mysql_free_result($result);
		
	}
	
	//métodos para adicionar ocorrencia
	function inserirOcorrenciaAbertura($codlead){
		$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $codlead,
		                                          'CodUsuarioInterno' =>  $_SESSION['codusuario'], 
												  'DataCadastro' => "SYSDATE()",
												  'codtipoocorrencialead' =>  3000,
												  'cod_campanha' => $this->cod_campanha,
												  'descricao' => "Participação na campanha: ".$this->nome_campanha));
		
		mysql_query($sql);
		return mysql_insert_id();
	}
	
	function inserirOcorrenciaSucesso($codlead){
		$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $codlead,
		                                          'CodUsuarioInterno' =>  $_SESSION['codusuario'],
												  'DataCadastro' => "SYSDATE()",
												  'DataFechamento' => "SYSDATE()",
												  'codtipoocorrencialead' =>  3001,
												  'cod_campanha' => $this->cod_campanha,
												  'descricao' => "SUCESSO na campanha: ".$this->nome_campanha));
		mysql_query($sql);
		return mysql_insert_id();
	}
	
	function inserirOcorrenciaSemSucesso($codlead){
		$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $codlead,
		                                          'CodUsuarioInterno' =>  $_SESSION['codusuario'], 
												  'DataCadastro' => "SYSDATE()",
												  'DataFechamento' => "SYSDATE()",
												  'codtipoocorrencialead' =>  3003,
												  'cod_campanha' => $this->cod_campanha,
												  'descricao' => "SEM SUCESSO na campanha: ".$this->nome_campanha));
		mysql_query($sql);	
		return mysql_insert_id();
	}
	
	function inserirOcorrenciaFechamento($codlead){
		
		$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $codlead,
		                                          'CodUsuarioInterno' =>  $_SESSION['codusuario'], 
												  'DataCadastro' => "SYSDATE()",
												  'DataFechamento' => "SYSDATE()",
												  'codtipoocorrencialead' =>  3002,
												  'cod_campanha' => $this->cod_campanha,
												  'descricao' => "Fechamento da campanha: ".$this->nome_campanha));
		mysql_query($sql);
		return mysql_insert_id();
	}
	
	function listar(){
		
		$sql = " Select cod_campanha, nome_campanha, descricao_campanha, date_format(dt_inicio_campanha, '%d/%m/%Y') dt_inicio_campanha, date_format(dt_fim_campanha, '%d/%m/%Y') dt_fim_campanha from campanha order by dt_inicio_campanha desc, dt_fim_campanha asc ";
		
		$result = mysql_query($sql);
		return $result;
	}
	
}
?>
