<?
include_once "../../libs/datas.php";

class produtos{

	private $pk;
	private $dt_cadastro;
	private $usuario_cadastro_pk;
	private $dt_ult_atualizacao;
	private $usuario_ult_atualizacao_pk;		
	private $operador_pk;
	private $produtos_tipo_pk;
	private $ds_produto;
	private	$dt_cancelamento;
	private $valores_produto;
    private $valor_tipo_pk;
	
	private $vl_vc1_local;	
	private $dsc_vc1_local;				
	private $visualiza_vc1_local;
	private $vl_vc1_Estad;
	private $dsc_vc1_Estad;				
	private $visualiza_vc1_Estad;	
	private $vl_vc1_Nac;
	private $dsc_vc1_Nac;				
	private $visualiza_vc1_Nac;		
	
	private $vl_vc2_local;	
	private $dsc_vc2_local;				
	private $visualiza_vc2_local;
	private $vl_vc2_Estad;
	private $dsc_vc2_Estad;				
	private $visualiza_vc2_Estad;	
	private $vl_vc2_Nac;
	private $dsc_vc2_Nac;				
	private $visualiza_vc2_Nac;
	
	private $vl_vc3_local;	
	private $dsc_vc3_local;				
	private $visualiza_vc3_local;
	private $vl_vc3_Estad;
	private $dsc_vc3_Estad;				
	private $visualiza_vc3_Estad;	
	private $vl_vc3_Nac;
	private $dsc_vc3_Nac;				
	private $visualiza_vc3_Nac;
    private $total_minutos;
    private $total_internet;
    private $tipo_dados;
    private $produto_book_pk;
    private $n_produtos_beneficio;
	


	function getpk() {return $this->pk;}
	function getdt_cadastro(){return $this->dt_cadastro;}
	function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
	function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
	function getoperador_pk (){return $this->operador_pk;}
	function getprodutos_tipo_pk(){return $this->produtos_tipo_pk;}
	function getds_produto (){return $this->ds_produto;} 
	function getdt_cancelamento(){return $this->dt_cancelamento;}
	function getvalores_produto(){return $this->valores_produto;}
    function getvalor_tipo_pk(){return $this->valor_tipo_pk;}
	
	function getvl_vc1_local(){return $this->vl_vc1_local;}
	function getdsc_vc1_local(){return $this->dsc_vc1_local;}
	function getvisualiza_vc1_local(){return $this->visualiza_vc1_local;}	 
	function getvl_vc1_Estad(){return $this->vl_vc1_Estad;}
	function getdsc_vc1_Estad(){return $this->dsc_vc1_Estad;}
	function getvisualiza_vc1_Estad(){return $this->visualiza_vc1_Estad;}
	function getvl_vc1_Nac(){return $this->vl_vc1_Nac;}
	function getdsc_vc1_Nac(){return $this->dsc_vc1_Nac;}
	function getvisualiza_vc1_Nac(){return $this->visualiza_vc1_Nac;}
	
	function getvl_vc2_local(){return $this->vl_vc2_local;}
	function getdsc_vc2_local(){return $this->dsc_vc2_local;}
	function getvisualiza_vc2_local(){return $this->visualiza_vc2_local;}	 
	function getvl_vc2_Estad(){return $this->vl_vc2_Estad;}
	function getdsc_vc2_Estad(){return $this->dsc_vc2_Estad;}
	function getvisualiza_vc2_Estad(){return $this->visualiza_vc2_Estad;}
	function getvl_vc2_Nac(){return $this->vl_vc2_Nac;}
	function getdsc_vc2_Nac(){return $this->dsc_vc2_Nac;}
	function getvisualiza_vc2_Nac(){return $this->visualiza_vc2_Nac;} 
	 
	function getvl_vc3_local(){return $this->vl_vc3_local;}
	function getdsc_vc3_local(){return $this->dsc_vc3_local;}
	function getvisualiza_vc3_local(){return $this->visualiza_vc3_local;}	 
	function getvl_vc3_Estad(){return $this->vl_vc3_Estad;}
	function getdsc_vc3_Estad(){return $this->dsc_vc3_Estad;}
	function getvisualiza_vc3_Estad(){return $this->visualiza_vc3_Estad;}
	function getvl_vc3_Nac(){return $this->vl_vc3_Nac;}
	function getdsc_vc3_Nac(){return $this->dsc_vc3_Nac;}
	function getvisualiza_vc3_Nac(){return $this->visualiza_vc3_Nac;}
    function gettotal_minutos(){return $this->total_minutos;}
	function gettotal_internet(){return $this->total_internet;} 
	function gettipo_dados(){return $this->tipo_dados;}
	function getproduto_book_pk(){return $this->produto_book_pk;}
	function getn_produtos_beneficio(){return $this->n_produtos_beneficio;}
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
	function setprodutos_tipo_pk($protudo_tipo_pk){$this->produtos_tipo_pk = $protudo_tipo_pk;}
	function setds_produto ($ds_produto ){$this->ds_produto  = $ds_produto ;}
	function setdt_cancelamento($dt_cancelamento){$this->dt_cancelamento = $dt_cancelamento;}
	function setvalores_produto($valores_produto){$this->valores_produto = $valores_produto;}
    function setvalor_tipo_pk($valor_tipo_pk){$this->valor_tipo_pk = $valor_tipo_pk;}
	
	function setvl_vc1_local($vl_vc1_local){$this->vl_vc1_local = $vl_vc1_local;}
	function setdsc_vc1_local($dsc_vc1_local){$this->dsc_vc1_local = $dsc_vc1_local;}
	function setvisualiza_vc1_local($visualiza_vc1_local){$this->visualiza_vc1_local = $visualiza_vc1_local;}
	function setvl_vc1_Estad($vl_vc1_Estad){$this->vl_vc1_Estad = $vl_vc1_Estad;}
	function setdsc_vc1_Estad($dsc_vc1_Estad){$this->dsc_vc1_Estad = $dsc_vc1_Estad;}
	function setvisualiza_vc1_Estad($visualiza_vc1_Estad){$this->visualiza_vc1_Estad = $visualiza_vc1_Estad;}
	function setvl_vc1_Nac($vl_vc1_Nac){$this->vl_vc1_Nac = $vl_vc1_Nac;}
	function setdsc_vc1_Nac($dsc_vc1_Nac){$this->dsc_vc1_Nac = $dsc_vc1_Nac;}
	function setvisualiza_vc1_Nac($visualiza_vc1_Nac){$this->visualiza_vc1_Nac = $visualiza_vc1_Nac;}
	
	function setvl_vc2_local($vl_vc2_local){$this->vl_vc2_local = $vl_vc2_local;}
	function setdsc_vc2_local($dsc_vc2_local){$this->dsc_vc2_local = $dsc_vc2_local;}
	function setvisualiza_vc2_local($visualiza_vc2_local){$this->visualiza_vc2_local = $visualiza_vc2_local;}
	function setvl_vc2_Estad($vl_vc2_Estad){$this->vl_vc2_Estad = $vl_vc2_Estad;}
	function setdsc_vc2_Estad($dsc_vc2_Estad){$this->dsc_vc2_Estad = $dsc_vc2_Estad;}
	function setvisualiza_vc2_Estad($visualiza_vc2_Estad){$this->visualiza_vc2_Estad = $visualiza_vc2_Estad;}
	function setvl_vc2_Nac($vl_vc2_Nac){$this->vl_vc2_Nac = $vl_vc2_Nac;}
	function setdsc_vc2_Nac($dsc_vc2_Nac){$this->dsc_vc2_Nac = $dsc_vc2_Nac;}
	function setvisualiza_vc2_Nac($visualiza_vc2_Nac){$this->visualiza_vc2_Nac = $visualiza_vc2_Nac;}
	
	function setvl_vc3_local($vl_vc3_local){$this->vl_vc3_local = $vl_vc3_local;}
	function setdsc_vc3_local($dsc_vc3_local){$this->dsc_vc3_local = $dsc_vc3_local;}
	function setvisualiza_vc3_local($visualiza_vc3_local){$this->visualiza_vc3_local = $visualiza_vc3_local;}
	function setvl_vc3_Estad($vl_vc3_Estad){$this->vl_vc3_Estad = $vl_vc3_Estad;}
	function setdsc_vc3_Estad($dsc_vc3_Estad){$this->dsc_vc3_Estad = $dsc_vc3_Estad;}
	function setvisualiza_vc3_Estad($visualiza_vc3_Estad){$this->visualiza_vc3_Estad = $visualiza_vc3_Estad;}
	function setvl_vc3_Nac($vl_vc3_Nac){$this->vl_vc3_Nac = $vl_vc3_Nac;}
	function setdsc_vc3_Nac($dsc_vc3_Nac){$this->dsc_vc3_Nac = $dsc_vc3_Nac;}
	function setvisualiza_vc3_Nac($visualiza_vc3_Nac){$this->visualiza_vc3_Nac = $visualiza_vc3_Nac;}		
	function settotal_minutos($total_minutos){$this->total_minutos = $total_minutos;}
    function settotal_internet($total_internet){$this->total_internet = $total_internet;}
    function settipo_dados($tipo_dados){$this->tipo_dados = $tipo_dados;}
    function setproduto_book_pk($produto_book_pk){$this->produto_book_pk = $produto_book_pk;}
    function setn_produtos_beneficio($n_produtos_beneficio){$this->n_produtos_beneficio = $n_produtos_beneficio;}
        
	function __construct($pk){
		
		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
		$this->operador_pk = null;
		$this->produtos_tipo_pk = null;
		$this->dt_cancelamento = null;
		$this->ds_produto = null;
        $this->valor_tipo_pk = null;
		$this->total_minutos = null;
        $this->total_internet = null;
        $this->tipo_dados = null;
        $this->produto_book_pk = null;
        $this->n_produtos_beneficio = null;
        
		if ($pk != 0){
			$sql ="SELECT
					np.pk,
					np.produtos_tipo_pk,
					np.operador_pk,
					np.ds_produto,
					np.dt_cancelamento,
					npo.vl_vc1_local,
					npo.dsc_vc1_local,
					npo.visualiza_vc1_local,
					npo.vl_vc1_Estad,
					npo.dsc_vc1_Estad,
					npo.visualiza_vc1_Estad,
					npo.vl_vc1_Nac,
					npo.dsc_vc1_Nac,
					npo.visualiza_vc1_Nac,
					npo.vl_vc2_local,
					npo.dsc_vc2_local,
					npo.visualiza_vc2_local,
					npo.vl_vc2_Estad,
					npo.dsc_vc2_Estad,
					npo.visualiza_vc2_Estad,
					npo.vl_vc2_Nac,
					npo.dsc_vc2_Nac,
					npo.visualiza_vc2_Nac,
					npo.vl_vc3_local,
					npo.dsc_vc3_local,
					npo.visualiza_vc3_local,
					npo.vl_vc3_Estad,
					npo.dsc_vc3_Estad,
					npo.visualiza_vc3_Estad,
					npo.vl_vc3_Nac,
					npo.dsc_vc3_Nac,
					npo.visualiza_vc3_Nac,
                    npv.valor_tipo_pk,
                    np.total_minutos,
                    np.total_internet,
                    np.tipo_dados,
                    np.n_produtos_beneficio,
                    np.produto_book_pk
				FROM n_produtos np
					LEFT JOIN n_produtos_valores npv on np.pk = npv.produtos_pk
					LEFT JOIN n_produtos_operadoras npo on np.pk = npo.produtos_pk
                    
				where np.pk=".$pk;
           
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$this->pk = $row['pk'];
				$this->produtos_tipo_pk = $row['produtos_tipo_pk'];
				$this->operador_pk = $row['operador_pk'];
				$this->ds_produto = $row['ds_produto'];
				$this->dt_cancelamento = $row['dt_cancelamento'];
				$this->vl_vc1_local = $row['vl_vc1_local'];
				$this->dsc_vc1_local = $row['dsc_vc1_local'];
				$this->visualiza_vc1_local = $row['visualiza_vc1_local'];
				$this->vl_vc1_Estad = $row['vl_vc1_Estad'];
				$this->dsc_vc1_Estad = $row['dsc_vc1_Estad'];
				$this->visualiza_vc1_Estad = $row['visualiza_vc1_Estad'];
				$this->vl_vc1_Nac = $row['vl_vc1_Nac'];
				$this->dsc_vc1_Nac = $row['dsc_vc1_Nac'];
				$this->visualiza_vc1_Nac = $row['visualiza_vc1_Nac'];
				$this->vl_vc2_local = $row['vl_vc2_local'];
				$this->dsc_vc2_local = $row['dsc_vc2_local'];
				$this->visualiza_vc2_local = $row['visualiza_vc2_local'];
				$this->vl_vc2_Estad = $row['vl_vc2_Estad'];
				$this->dsc_vc2_Estad = $row['dsc_vc2_Estad'];
				$this->visualiza_vc2_Estad = $row['visualiza_vc2_Estad'];
				$this->vl_vc2_Nac = $row['vl_vc2_Nac'];
				$this->dsc_vc2_Nac = $row['dsc_vc2_Nac'];
				$this->visualiza_vc2_Nac = $row['visualiza_vc2_Nac'];
				$this->vl_vc3_local = $row['vl_vc3_local'];
				$this->dsc_vc3_local = $row['dsc_vc3_local'];
				$this->visualiza_vc3_local = $row['visualiza_vc3_local'];
				$this->vl_vc3_Estad = $row['vl_vc3_Estad'];
				$this->dsc_vc3_Estad = $row['dsc_vc3_Estad'];
				$this->visualiza_vc3_Estad = $row['visualiza_vc3_Estad'];
				$this->vl_vc3_Nac = $row['vl_vc3_Nac'];
				$this->dsc_vc3_Nac = $row['dsc_vc3_Nac'];
				$this->visualiza_vc3_Nac = $row['visualiza_vc3_Nac'];
                $this->valor_tipo_pk = $row['valor_tipo_pk'];
                $this->total_minutos = $row['total_minutos'];
                $this->total_internet = $row['total_internet'];
                $this->tipo_dados = $row['tipo_dados'];
                $this->produto_book_pk = $row['produto_book_pk'];
                $this->n_produtos_beneficio = $row['n_produtos_beneficio'];
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){

		$fields['operador_pk'] = $this->operador_pk;
		$fields['produtos_tipo_pk'] = $this->produtos_tipo_pk;
		$fields['ds_produto'] = $this->ds_produto;
        $fields['total_minutos'] = $this->total_minutos;
        $fields['total_internet'] = $this->total_internet;
        $fields['tipo_dados'] = $this->tipo_dados;
        $fields['produto_book_pk'] = $this->produto_book_pk;
        $fields['n_produtos_beneficio'] = $this->n_produtos_beneficio;
		if($this->dt_cancelamento=="2"){
			$fields['dt_cancelamento'] = "sysdate()";
		}else{
			$fields['dt_cancelamento'] = "null";
		}
		
		
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
	function add_produtos_valores($produtos_pk){
		
		$sql = "delete from n_produtos_valores where produtos_pk=".$produtos_pk;
		mysql_query($sql);	 
		
		$fields['produtos_pk'] = $produtos_pk;
		$fields['dt_cadastro'] = "sysdate()";
		$fields['dt_ult_atualizacao'] = "sysdate()";
		$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
		$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
		
		
		$arrvl_produto = split("////",$this->valores_produto);
		
		/*for($i = 0; $i < count($arrvl_produto) -1; $i++){	
			
			 $fields['vl_produto'] = (moeda2float($arrvl_produto[$i]));
			 $sql = sqlinsert('n_produtos_valores', $fields);	
			 
			 mysql_query($sql);	 			 
		}*/
                

                for($i = 0; $i < count($arrvl_produto); $i++){ 
                    
                    //if(trim($arrvl_produto[$i])!="" && !empty($arrvl_produto[$i])!=""){
			 $arrCampos = split("##", $arrvl_produto[$i]); 
			 $fields['vl_produto'] = (moeda2float($arrCampos[0]));
                         $fields['tipo_pk'] = $arrCampos[1];
                         $fields['valor_tipo_pk'] = $this->valor_tipo_pk;
			 $sql = sqlinsert('n_produtos_valores', $fields);	
			
			 mysql_query($sql);
                    //}     
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
