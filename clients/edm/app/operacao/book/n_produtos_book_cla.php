<?
include_once "../../libs/datas.php";

class n_produtos_book{

	
	private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    private $dt_cancelamento;
    private $operador_pk;
    private $n_dsc_book;
    private $dt_inicio;
    private $dt_fim;

	function getpk(){return $this->pk;}
    function getdt_cadastro(){return $this->dt_cadastro;}
    function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getoperador_pk(){return $this->operador_pk;}
    function getn_dsc_book(){return $this->n_dsc_book;}
    function getdt_inicio(){return $this->dt_inicio;}
    function getdt_fim(){return $this->dt_fim;}

	function setpk($pk){ $this->pk = $pk;}
    function setdt_cadastro($dt_cadastro){ $this->dt_cadastro = $dt_cadastro;}
    function setusuario_cadastro_pk($usuario_cadastro_pk){ $this->usuario_cadastro_pk = $usuario_cadastro_pk;}
    function setdt_ult_atualizacao($dt_ult_atualizacao){ $this->dt_ult_atualizacao = $dt_ult_atualizacao;}
    function setusuario_ult_atualizacao_pk($usuario_ult_atualizacao_pk){ $this->usuario_ult_atualizacao_pk = $usuario_ult_atualizacao_pk;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setoperador_pk($operador_pk){ $this->operador_pk = $operador_pk;}
    function setn_dsc_book($n_dsc_book){ $this->n_dsc_book = $n_dsc_book;}
    function setdt_inicio($dt_inicio){ $this->dt_inicio = $dt_inicio;}
    function setdt_fim($dt_fim){ $this->dt_fim = $dt_fim;}


	function __construct($pk){
		
		$this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        $this->dt_cancelamento = null;
        $this->operador_pk = null;
        $this->n_dsc_book = null;
        $this->dt_inicio = null;
        $this->dt_fim = null;
        
		if ($pk != 0){
			$sql =" select pk,
                        date_format(dt_cadastro,'%d/%m/%Y %H:%i:%s') dt_cadastro, 
                        date_format(dt_ult_atualizacao,'%d/%m/%Y %H:%i:%s') dt_ult_atualizacao, 
                        usuario_cadastro_pk, 
                        usuario_ult_atualizacao_pk, 
                        date_format(dt_cancelamento,'%d/%m/%Y %H:%i:%s') dt_cancelamento, 
                        operador_pk, 
                        n_dsc_book,
                        date_format(dt_inicio, '%d/%m/%Y') dt_inicio, 
                        date_format(dt_fim , '%d/%m/%Y') dt_fim 
                    from n_produtos_book";
			$sql.=" where pk = ".$pk;
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
                
				$this->pk = $row['pk'];
                $this->dt_cadastro = $row['dt_cadastro'];
                $this->usuario_cadastro_pk = $row['usuario_cadastro_pk'];
                $this->dt_ult_atualizacao = $row['dt_ult_atualizacao'];
                $this->usuario_ult_atualizacao_pk = $row['usuario_ult_atualizacao_pk'];
                $this->dt_cancelamento = $row['dt_cancelamento'];
                $this->operador_pk = $row['operador_pk'];
                $this->n_dsc_book = $row['n_dsc_book'];
                $this->dt_inicio = $row['dt_inicio'];
                $this->dt_fim = $row['dt_fim'];
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){
		$fields['pk'] = $this->pk;
        $fields['dt_cadastro'] = $this->dt_cadastro;
        $fields['usuario_cadastro_pk'] = $this->usuario_cadastro_pk;
        $fields['dt_ult_atualizacao'] = $this->dt_ult_atualizacao;
        $fields['usuario_ult_atualizacao_pk'] = $this->usuario_ult_atualizacao_pk;
        $fields['dt_cancelamento'] = $this->dt_cancelamento;
        $fields['operador_pk'] = $this->operador_pk;
        $fields['n_dsc_book'] = $this->n_dsc_book;
        $fields['dt_inicio'] = DataYMD($this->dt_inicio);
        $fields['dt_fim'] = DataYMD($this->dt_fim);
        
        
		//salva a ocorrencia no banco de dados.
		if (empty($this->pk) || trim($this->pk) == ""){
			$fields['dt_cadastro'] = "sysdate()";
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlinsert('n_produtos_book', $fields);
			mysql_query($sql);
			$this->pk = mysql_insert_id();
		}
		else{
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlupdate('n_produtos_book', $fields, ' pk = ' . mysqlnull($this->pk));
			mysql_query($sql);
		}
		return $this->pk;
	}
	function excluir(){
		$sql = "delete from n_produtos_book where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;
	}
}
?>
