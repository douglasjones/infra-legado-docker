<?
include_once "../../libs/datas.php";

class n_aparelhos{

private $pk;
private $dt_cadastro;
private $usuario_cadastro_pk;
private $dt_ult_atualizacao;
private $usuario_ult_atualizacao_pk;	
private $ds_aparelho;
private $ds_link_imagem;
private $fabricante_pk;
private $operador_pk;
private $dt_cancelamento;
private $nom_imagem_cel;

	
function getds_aparelho(){return $this->ds_aparelho;}
function getds_link_imagem(){return $this->ds_link_imagem;}
function getfabricante_pk(){return $this->fabricante_pk;}
function getoperador_pk(){return $this->operador_pk;}
function getpk() {return $this->pk;}
function getdt_cadastro(){return $this->dt_cadastro;}
function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
function getdt_cancelamento(){return $this->dt_cancelamento;}
function getnom_imagem_cel(){return $this->nom_imagem_cel;}
	
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
	function setds_aparelho($ds_aparelho){ $this->ds_aparelho = $ds_aparelho;}
	function setds_link_imagem($ds_link_imagem){ $this->ds_link_imagem = $ds_link_imagem;}
	function setfabricante_pk($fabricante_pk){ $this->fabricante_pk = $fabricante_pk;}
	function setoperador_pk($operador_pk){ $this->operador_pk = $operador_pk;}
	function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setnom_imagem_cel($nom_imagem_cel){ $this->nom_imagem_cel = $nom_imagem_cel;}
    
    
	function __construct($pk){
		
		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
		$this->ds_aparelho = null;
		$this->ds_link_imagem = null;
		$this->fabricante_pk = null;
		$this->operador_pk = null;
		$this->dt_cancelamento = null;
        $this->nom_imagem_cel = null;

		
		if ($pk != 0){
			$sql ="select pk,";
			$sql.="       date_format(dt_cadastro, '%d/%m/%Y %H:%i:%s') dt_cadastro, ";
			$sql.="       date_format(dt_ult_atualizacao, '%d/%m/%Y %H:%i:%s') dt_ult_atualizacao, ";
			$sql.="       usuario_cadastro_pk, ";
			$sql.="       usuario_ult_atualizacao_pk, ";
			$sql.="		  ds_aparelho, ";
			$sql.="       ds_link_imagem, ";
			$sql.="       fabricante_pk, ";
			$sql.="       operador_pk,";
			$sql.="       dt_cancelamento,";
            $sql.="       nom_imagem_cel";
			$sql.="  from n_aparelhos ";
			$sql.=" where pk = ".$pk;
			
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$this->pk = $row['pk'];
				$this->dt_cadastro = $row['dt_cadastro'];
				$this->dt_ult_atualizacao = $row['dt_ult_atualizacao'];
				$this->usuario_cadastro_pk = $row['usuario_cadastro_pk'];
				$this->usuario_ult_atualizacao_pk = $row['usuario_ult_atualizacao_pk'];
				$this->ds_aparelho = $row['ds_aparelho'];
				$this->ds_link_imagem = $row['ds_link_imagem'];
				$this->fabricante_pk = $row['fabricante_pk'];
				$this->operador_pk = $row['operador_pk'];
				$this->dt_cancelamento = $row['dt_cancelamento'];
                $this->nom_imagem_cel = $row['nom_imagem_cel'];
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){
		$fields['ds_aparelho'] = $this->ds_aparelho;
		$fields['ds_link_imagem'] = $this->ds_link_imagem;
		$fields['fabricante_pk'] = $this->fabricante_pk;
		$fields['operador_pk'] = $this->operador_pk;
		if($this->dt_cancelamento=="2"){
			$fields['dt_cancelamento'] = "sysdate()";
		}else{
			$fields['dt_cancelamento'] = "null";
		}	
		$fields['nom_imagem_cel'] = $this->nom_imagem_cel;
        
		//salva a ocorrencia no banco de dados.
		if (empty($this->pk) || trim($this->pk) == ""){
			$fields['dt_cadastro'] = "sysdate()";
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlinsert('n_aparelhos', $fields);
			
			mysql_query($sql);
			$this->pk = mysql_insert_id();
			
		}
		else{
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlupdate('n_aparelhos', $fields, ' pk = ' . mysqlnull($this->pk));
			mysql_query($sql);
		}
		
		return $this->pk;
	}
	
	function excluir(){
		
		$sql = "delete from n_aparelhos where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;
		
	}	
	
}
?>
