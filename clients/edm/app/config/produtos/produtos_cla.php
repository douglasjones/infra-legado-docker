<?
include_once "../../libs/datas.php";

class produtos{

	private $pk;
	private $dt_cadastro;
	private $usuario_cadastro_pk;
	private $dt_ult_atualizacao;
	private $usuario_ult_atualizacao_pk;	
	private $ds_produto;
	private $vl_produtor;
	private $operador_pk;
	private	$dt_cancelamento;

	function getpk() {return $this->pk;}
	function getdt_cadastro(){return $this->dt_cadastro;}
	function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
	function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
	function getds_produto (){return $this->ds_produto;} 
	function getvl_produtor (){return $this->vl_produtor;}
	function getoperador_pk (){return $this->operador_pk;}
	function getdt_cancelamento(){return $this->dt_cancelamento;}
	
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
	function setds_produto ($ds_produto ){$this->ds_produto  = $ds_produto ;}
	function setvl_produtor ($vl_produtor){$this->vl_produtor = $vl_produtor;}
	function setoperador_pk ($operador_pk){$this->operador_pk = $operador_pk;}
	function setdt_cancelamento($dt_cancelamento){$this->dt_cancelamento = $dt_cancelamento;}


	function __construct($pk){

		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
		$this->ds_produto = null;
		$this->vl_produtor = null;
		$this->operador_pk = null;
		$this->dt_cancelamento = null;
				
		if ($pk != 0){
			$sql ="select pk,";
			$sql.="       date_format(dt_cadastro, '%d/%m/%Y %H:%i:%s') dt_cadastro, ";
			$sql.="       date_format(dt_ult_atualizacao, '%d/%m/%Y %H:%i:%s') dt_ult_atualizacao, ";
			$sql.="       usuario_cadastro_pk, ";
			$sql.="       usuario_ult_atualizacao_pk, ";
			$sql.="       ds_produto,":
			$sql.="       vl_produtor,";
			$sql.="       operador_pk,";
			$sql.="       dt_cancelamentos";
			$sql.="  from n_produtos ";
			$sql.=" where pk = ".$pk;
			
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$this->pk = $row['pk'];
				$this->dt_cadastro = $row['dt_cadastro'];
				$this->dt_ult_atualizacao = $row['dt_ult_atualizacao'];
				$this->usuario_cadastro_pk = $row['usuario_cadastro_pk'];
				$this->usuario_ult_atualizacao_pk = $row['usuario_ult_atualizacao_pk'];
				$this->ds_produto = $row['ds_produto'];
				$this->vl_produtor = $row['vl_produtor'];
				$this->operador_pk = $row['operador_pk'];
				$this->dt_cancelamento = $row['dt_cancelamento'];			
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){		
		
		$fields['ds_produto'] = $this->ds_produto;
		$fields['vl_produtor'] = $this->vl_produtor;
		$fields['operador_pk'] = $this->operador_pk;
		$fields['dt_cancel amento'] = $this->dt_cancel amento;
		
		//salva a ocorrencia no banco de dados.
		if (empty($this->pk) || trim($this->pk) == ""){
			$fields['dt_cadastro'] = "sysdate()";
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlinsert('n_produtos', $fields);
			mysql_query($sql);
			$this->pk = mysql_insert_id();
			
		}
		else{
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlupdate('n_produtos', $fields, ' pk = ' . mysqlnull($this->pk));
			mysql_query($sql);
		}
		
		return $this->pk;
	}
	
	function excluir(){
		
		$sql = "delete from n_produtos where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;
		
	}	
	
}
?>
