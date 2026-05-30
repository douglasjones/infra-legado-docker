<?
include_once "../../libs/datas.php";

class combos{

	private $pk;
	private $dt_cadastro;
	private $usuario_cadastro_pk;
	private $dt_ult_atualizacao;
	private $usuario_ult_atualizacao_pk;		
	private $operador_pk;
	private $ds_combo;
	private $vl_combo;
	private	$dt_cancelamento;
	private $itens_produtos_combo;
	private $n_vigencia_contrato;


	function getpk() {return $this->pk;}
	function getdt_cadastro(){return $this->dt_cadastro;}
	function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
	function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
	function getoperador_pk (){return $this->operador_pk;}
	function getds_combo (){return $this->ds_combo;} 
	function getvl_combo(){return $this->vl_combo;}
	function getdt_cancelamento(){return $this->dt_cancelamento;}
	function getitens_produtos_combo(){return $this->itens_produtos_combo;}
	function getn_vigencia_contrato(){return $this->n_vigencia_contrato;}

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
	function setoperador_pk ($operador_pk){$this->operador_pk = $operador_pk;}
	function setds_combo ($ds_combo){$this->ds_combo  = $ds_combo;}
	function setvl_combo ($vl_combo){$this->vl_combo  = $vl_combo;}
	function setdt_cancelamento($dt_cancelamento){$this->dt_cancelamento = $dt_cancelamento;}
	function setitens_produtos_combo($itens_produtos_combo){$this->itens_produtos_combo = $itens_produtos_combo;}
	function setn_vigencia_contrato($n_vigencia_contrato){$this->n_vigencia_contrato = $n_vigencia_contrato;}
	
	function __construct($pk){
		
		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
		$this->operador_pk = null;
		$this->dt_cancelamento = null;
		$this->ds_combo = null;
		$this->vl_combo = null;
		$this->n_vigencia_contrato = null;
	
			
		if ($pk != 0){
			$sql ="Select
					 nc.pk
					 ,nc.operador_pk
					 ,nc.ds_combo
					 ,nc.vl_combo
					 ,nc.n_vigencia_contrato
					 ,nc.dt_cancelamento
					from n_combos nc
					where nc.pk=".$pk;
			
			
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$this->pk = $row['pk'];				
				$this->operador_pk = $row['operador_pk'];
				$this->ds_combo = $row['ds_combo'];
				$this->dt_cancelamento = $row['dt_cancelamento'];
				$this->vl_combo = $row['vl_combo'];
				$this->n_vigencia_contrato = $row['n_vigencia_contrato'];
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){	

		$fields['operador_pk'] = $this->operador_pk;
		$fields['ds_combo'] = $this->ds_combo;
		$fields['vl_combo'] = (moeda2float($this->vl_combo));
		$fields['n_vigencia_contrato'] = $this->n_vigencia_contrato;
		if($this->dt_cancelamento=="2"){
			$fields['dt_cancelamento'] = "sysdate()";
		}else{
			$fields['dt_cancelamento'] = "null";
		}	
		
		if (empty($this->pk) || trim($this->pk) == ""){
			$fields['dt_cadastro'] = "sysdate()";
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			
			$sql = sqlinsert('n_combos', $fields);	
		
			mysql_query($sql);
			
			$this->pk = mysql_insert_id();	
		}else{
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			
			$sql = sqlupdate('n_combos', $fields, ' pk = ' . mysqlnull($this->pk));
			
			mysql_query($sql);	
		}	

		return $this->pk;
	}
	function add_itens_produto($combos_pk){
		
		$sql = "delete from n_itens_combo where combos_pk=".$combos_pk;
		mysql_query($sql);	 
		
		$fields['combos_pk'] = $combos_pk;
		$fields['dt_cadastro'] = "sysdate()";
		$fields['dt_ult_atualizacao'] = "sysdate()";
		$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
		$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
		
		$arritens_produtos = split("////",$this->itens_produtos_combo);
		
		for($i = 0; $i < count($arritens_produtos) -1; $i++){	
			
			 $fields['produtos_pk'] = $arritens_produtos[$i];
			 $sql = sqlinsert('n_itens_combo', $fields);	
	
			 mysql_query($sql);	 			 
		}	
		
		return true;
	}	
	
	function add_produtos_operadoras($produtos_pk){
		
		$sql = "delete from n_produtos_operadoras where produtos_pk=".$produtos_pk;
		mysql_query($sql);	 
		
		$fields['produtos_pk'] = $produtos_pk;
		$fields['dt_cadastro'] = "sysdate()";
		$fields['dt_ult_atualizacao'] = "sysdate()";
		$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
		$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
		
		$fields['vl_vc1_local'] = (moeda2float($this->vl_vc1_local));
		$fields['dsc_vc1_local'] = $this->dsc_vc1_local;
		$fields['visualiza_vc1_local'] = $this->visualiza_vc1_local;
		$fields['vl_vc1_Estad'] = (moeda2float($this->vl_vc1_Estad));
		$fields['dsc_vc1_Estad'] = $this->dsc_vc1_Estad;
		$fields['visualiza_vc1_Estad'] = $this->visualiza_vc1_Estad;
		$fields['vl_vc1_Nac'] = (moeda2float($this->vl_vc1_Nac));
		$fields['dsc_vc1_Nac'] = $this->dsc_vc1_Nac;
		$fields['visualiza_vc1_Nac'] = $this->visualiza_vc1_Nac;
		
		$fields['vl_vc2_local'] = (moeda2float($this->vl_vc2_local));
		$fields['dsc_vc2_local'] = $this->dsc_vc2_local;
		$fields['visualiza_vc2_local'] = $this->visualiza_vc2_local;
		$fields['vl_vc2_Estad'] = (moeda2float($this->vl_vc2_Estad));
		$fields['dsc_vc2_Estad'] = $this->dsc_vc2_Estad;
		$fields['visualiza_vc2_Estad'] = $this->visualiza_vc2_Estad;
		$fields['vl_vc2_Nac'] = (moeda2float($this->vl_vc2_Nac));
		$fields['dsc_vc2_Nac'] = $this->dsc_vc2_Nac;
		$fields['visualiza_vc2_Nac'] = $this->visualiza_vc2_Nac;

		$fields['vl_vc3_local'] = (moeda2float($this->vl_vc3_local));
		$fields['dsc_vc3_local'] = $this->dsc_vc3_local;
		$fields['visualiza_vc3_local'] = $this->visualiza_vc3_local;
		$fields['vl_vc3_Estad'] = (moeda2float($this->vl_vc3_Estad));
		$fields['dsc_vc3_Estad'] = $this->dsc_vc3_Estad;
		$fields['visualiza_vc3_Estad'] = $this->visualiza_vc3_Estad;
		$fields['vl_vc3_Nac'] = (moeda2float($this->vl_vc3_Nac));
		$fields['dsc_vc3_Nac'] = $this->dsc_vc3_Nac;
		$fields['visualiza_vc3_Nac'] = $this->visualiza_vc3_Nac;
		
		$sql = sqlinsert('n_produtos_operadoras', $fields);			
		
		mysql_query($sql);	
		return true;
	}

	
	function excluir(){
		
		$sql = "delete from n_produtos where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;
		
	}	
	
}
?>
