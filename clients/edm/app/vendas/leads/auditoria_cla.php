<?
include_once "../../libs/datas.php";

class auditoria{

	private $pk;
	private $dt_cadastro;
	private $usuario_cadastro_pk;
	private $dt_ult_atualizacao;
	private $usuario_ult_atualizacao_pk;	
	private $leads_pk;
	private $agendavisita_pk;
	private $contatoslead_pk;
	private $tipo_visita_pk;
	private $dsc_auditoria;
	private $tel_fixo;

	
	function getleads_pk(){return $this->leads_pk;}
	function getagendavisita_pk(){return $this->agendavisita_pk;}
	function getcontatoslead_pk(){return $this->contatoslead_pk;}
	function gettipo_visita_pk(){return $this->tipo_visita_pk;}
	function getdsc_auditoria(){return $this->dsc_auditoria;}
	function gettel_fixo(){return $this->tel_fixo;}
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
	function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
	function setagendavisita_pk($agendavisita_pk){ $this->agendavisita_pk = $agendavisita_pk;}
	function setcontatoslead_pk($contatoslead_pk){ $this->contatoslead_pk = $contatoslead_pk;}
	function settipo_visita_pk($tipo_visita_pk){ $this->tipo_visita_pk = $tipo_visita_pk;}
	function setdsc_auditoria($dsc_auditoria){ $this->dsc_auditoria = $dsc_auditoria;}
	function settel_fixo($tel_fixo){ $this->tel_fixo = $tel_fixo;}


	function __construct($pk){
		
		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
		$this->leads_pk = null;
		$this->agendavisita_pk = null;
		$this->contatoslead_pk = null;
		$this->tipo_visita_pk = null;
		$this->dsc_auditoria = null;
		$this->tel_fixo = null;

		
		if ($pk != 0){
			$sql ="select pk,";
			$sql.="       date_format(dt_cadastro, '%d/%m/%Y %H:%i:%s') dt_cadastro, ";
			$sql.="       date_format(dt_ult_atualizacao, '%d/%m/%Y %H:%i:%s') dt_ult_atualizacao, ";
			$sql.="       usuario_cadastro_pk, ";
			$sql.="       usuario_ult_atualizacao_pk, ";
			$sql.="       leads_pk, ";
			$sql.="		  agendavisita_pk, ";
			$sql.="		  contatoslead_pk, ";
			$sql.="       tipo_visita_pk, ";
			$sql.="       dsc_auditoria,";
			$sql.="       tel_fixo";
			$sql.="  from auditoria ";
			$sql.=" where pk = ".$pk;
			
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$this->pk = $row['pk'];
				$this->dt_cadastro = $row['dt_cadastro'];
				$this->dt_ult_atualizacao = $row['dt_ult_atualizacao'];
				$this->usuario_cadastro_pk = $row['usuario_cadastro_pk'];
				$this->usuario_ult_atualizacao_pk = $row['usuario_ult_atualizacao_pk'];
				$this->leads_pk = $row['leads_pk'];
				$this->agendavisita_pk = $row['agendavisita_pk'];
				$this->contatoslead_pk = $row['contatoslead_pk'];
				$this->tipo_visita_pk = $row['tipo_visita_pk'];
				$this->dsc_auditoria = $row['dsc_auditoria'];
				$this->tel_fixo = $row['tel_fixo'];
			
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){
				
		$fields['leads_pk'] = $this->leads_pk;
		$fields['agendavisita_pk'] = $this->agendavisita_pk;
		$fields['contatoslead_pk'] = $this->contatoslead_pk;
		$fields['tipo_visita_pk'] = $this->tipo_visita_pk;
		$fields['dsc_auditoria'] = $this->dsc_auditoria;
		$fields['tel_fixo'] = $this->tel_fixo;
		
		//salva a ocorrencia no banco de dados.
		if (empty($this->pk) || trim($this->pk) == ""){
			$fields['dt_cadastro'] = "sysdate()";
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlinsert('auditoria', $fields);			
			
			mysql_query($sql);
			
			//altera o status do aagenda
			$sql = "";
			$sql.= "update agendaslead set codstatus=6 where codagendalead=".$this->agendavisita_pk;
			
			mysql_query($sql);
			
			$this->pk = mysql_insert_id();			
		}
		else{
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlupdate('auditoria', $fields, ' pk = ' . mysqlnull($this->pk));
			mysql_query($sql);
		}
		
		return $this->pk;
	}
	
	function excluir(){
		
		$sql = "delete from auditoria where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;
		
	}	
	
}
?>
