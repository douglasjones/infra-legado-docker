<?
include_once "../../libs/datas.php";

class mailing{

	private $pk;
	private $dt_cadastro;
	private $usuario_cadastro_pk;
	private $dt_ult_atualizacao;
	private $usuario_ult_atualizacao_pk;
	private $dsc_mailing;

	function getdsc_mailing(){return $this->dsc_mailing;}
	function getpk() {return $this->pk;}
	function getdt_cadastro(){return $this->dt_cadastro;}
	function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
	function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
	
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
	function setdsc_mailing($dsc_mailing){ $this->dsc_mailing = $dsc_mailing;}


	function __construct($pk){
		
		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
		$this->dsc_mailing = null;


		
		if ($pk != 0){
			$sql ="select pk,";
			$sql.="       date_format(dt_cadastro, '%d/%m/%Y %H:%i:%s') dt_cadastro, ";
			$sql.="       date_format(dt_ult_atualizacao, '%d/%m/%Y %H:%i:%s') dt_ult_atualizacao, ";
			$sql.="       usuario_cadastro_pk, ";
			$sql.="       usuario_ult_atualizacao_pk, ";
			$sql.="		  dsc_mailing ";
			$sql.="  from mailing ";
			$sql.=" where pk = ".$pk;
			
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$this->pk = $row['pk'];
				$this->dt_cadastro = $row['dt_cadastro'];
				$this->dt_ult_atualizacao = $row['dt_ult_atualizacao'];
				$this->usuario_cadastro_pk = $row['usuario_cadastro_pk'];
				$this->usuario_ult_atualizacao_pk = $row['usuario_ult_atualizacao_pk'];
				$this->dsc_mailing = $row['dsc_mailing'];

			
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){
		$fields['dsc_mailing'] = $this->dsc_mailing;		
		//salva a ocorrencia no banco de dados.
		if (empty($this->pk) || trim($this->pk) == ""){
			$fields['dt_cadastro'] = "sysdate()";
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlinsert('mailing', $fields);
			
			mysql_query($sql);
			$this->pk = mysql_insert_id();
			
		}
		else{
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlupdate('mailing', $fields, ' pk = ' . mysqlnull($this->pk));
			
			mysql_query($sql);
		}
		
		return $this->pk;
	}
	
	function excluir(){
		
		$sql = "delete from maling where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;
		
	}	
	
}
?>
