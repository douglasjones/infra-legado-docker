<?
include_once "../../libs/datas.php";

class n_planilha_aparelhos_cargas{
    
    private $pk;
    private $dt_inicio;
    private $dt_cancelamento;
	private $dt_cadastro;
	private $usuario_cadastro_pk;
	private $dt_ult_atualizacao;
	private $usuario_ult_atualizacao_pk;
	private $planilha_carga;


	function getpk() {return $this->pk;}	
    function getdt_inicio(){return $this->dt_inicio;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
	function getdt_cadastro(){return $this->dt_cadastro;}
	function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
	function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
	function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
	function getplanilha_carga(){return $this->planilha_carga;}

    
	function setpk($pk){$this->pk = $pk;}
    function setdt_inicio($dt_inicio){ $this->dt_inicio = $dt_inicio;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setplanilha_carga($planilha_carga){ $this->planilha_carga = $planilha_carga;}

	function __construct($pk){
		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
        $this->dt_inicio = null;
        $this->dt_cancelamento = null;
        $this->planilha_carga = null;

        if ($pk != 0){
            $sql.=" SELECT pk,
                            date_format(dt_cadastro, '%d/%m/%Y %H:%i:%s') dt_cadastro, 
                            date_format(dt_ult_atualizacao, '%d/%m/%Y %H:%i:%s') dt_ult_atualizacao, 
                            date_format(dt_inicio, '%d/%m/%Y') dt_inicio, 
                            usuario_cadastro_pk, 
                            usuario_ult_atualizacao_pk, 
                            dt_cancelamento, 
                            planilha_carga
                    FROM n_planilha_aparelhos_cargas ";
			$sql.=" WHERE pk = ".$pk;
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
                
        $this->dt_cadastro = $row['dt_cadastro'];
        $this->dt_ult_atualizacao = $row['dt_ult_atualizacao'];
        $this->usuario_cadastro_pk = $row['usuario_cadastro_pk'];
        $this->usuario_ult_atualizacao_pk = $row['usuario_ult_atualizacao_pk'];
        $this->pk = $row['pk'];
        $this->dt_inicio = $row['dt_inicio'];
        $this->dt_cancelamento = $row['dt_cancelamento'];
        $this->planilha_carga = $row['planilha_carga'];
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){
        
        
        $arquivos_pk = 0;
		$delimitador = ';';
		$cerca = '"';

		$fd = fopen ("arquivos/".$this->planilha_carga,'r');
        
        
        $fields = array();
        $fields['pk'] = $this->pk;
        $fields['dt_inicio'] = DataYMD($this->dt_inicio);
        $fields['dt_cancelamento'] = $this->dt_cancelamento;
        $fields['planilha_carga'] = $this->planilha_carga;
        $fields['dt_cadastro'] = "sysdate()";
        $fields['dt_ult_atualizacao'] = "sysdate()";
        $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
        $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
        
       // $sql = sqlinsert('n_planilha_aparelhos_cargas', $fields);

		//mysql_query($sql);
        
		//$arquivos_pk = mysql_insert_id();
        
        // Ler cabecalho do arquivo
		$cabecalho = fgetcsv($fd, 0, $delimitador, $cerca);

		while (!feof ($fd)) {	
                      
            
			$linha = fgetcsv($fd, 0, $delimitador, $cerca);
			
			$registro = array_combine($cabecalho, $linha);
            
            $fields = array();
            $fields['pk'] = $registro->pk;PHP_EOL;
            $fields['fabricante_pk'] = $registro->fabricante_pk;PHP_EOL;
            $fields['operador_pk'] = $registro->operador_pk;PHP_EOL;
            $fields['dsc_aparelho'] = $registro->dsc_aparelho;PHP_EOL;
            $fields['vl_aparelho'] = $registro->vl_aparelho;PHP_EOL;
            $fields['dt_cadastro'] = "sysdate()";
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlinsert('n_planilha_aparelhos_itens', $fields);
			mysql_query($sql);
            
            $this->pk = mysql_insert_id();
                        
		}
           mysql_free_result($result);
        
		//FIM DA CARGA
            
		return $this->pk;
	}
	
	function excluir(){
		
		$sql = "delete from n_planilha_aparelhos_cargas where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;
		
	}	
	
}
?>
