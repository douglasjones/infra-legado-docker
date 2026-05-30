<?
include_once "../../libs/datas.php";

class mobile_login{

	private $pk;
	private $dt_cadastro;
	private $usuario_cadastro_pk;
	private $dt_ult_atualizacao;
	private $usuario_ult_atualizacao_pk;
	
	private $CodUsuarioInterno;
    private $CodDepartamento;
    private $Nome;
    private $Login;
    private $Senha;
    private $CodUsuarioSuperior;
    private $Desativado;
    private $GerenteContas;
    private $Atendente;
    private $Meta;
    private $cod_polo;
    private $cod_atividade_profissional;
    private $cod_classificacao;
    private $cod_regime;
    private $dat_adm;
    private $dat_dem;
    private $meta_moeda;
    private $ddd_tel;
    private $emei;
    private $email;
    private $tel;
    private $cod_empresa;
    private $codigosa3;

	
	function getCodUsuarioInterno(){return $this->CodUsuarioInterno;}
    function getCodDepartamento(){return $this->CodDepartamento;}
    function getNome(){return $this->Nome;}
    function getLogin(){return $this->Login;}
    function getSenha(){return $this->Senha;}
    function getCodUsuarioSuperior(){return $this->CodUsuarioSuperior;}
    function getDesativado(){return $this->Desativado;}
    function getGerenteContas(){return $this->GerenteContas;}
    function getAtendente(){return $this->Atendente;}
    function getMeta(){return $this->Meta;}
    function getcod_polo(){return $this->cod_polo;}
    function getcod_atividade_profissional(){return $this->cod_atividade_profissional;}
    function getcod_classificacao(){return $this->cod_classificacao;}
    function getcod_regime(){return $this->cod_regime;}
    function getdat_adm(){return $this->dat_adm;}
    function getdat_dem(){return $this->dat_dem;}
    function getmeta_moeda(){return $this->meta_moeda;}
    function getddd_tel(){return $this->ddd_tel;}
    function getemei(){return $this->emei;}
    function getemail(){return $this->email;}
    function gettel(){return $this->tel;}
    function getcod_empresa(){return $this->cod_empresa;}
    function getcodigosa3(){return $this->codigosa3;}

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
	function setCodUsuarioInterno($CodUsuarioInterno){ $this->CodUsuarioInterno = $CodUsuarioInterno;}
    function setCodDepartamento($CodDepartamento){ $this->CodDepartamento = $CodDepartamento;}
    function setNome($Nome){ $this->Nome = $Nome;}
    function setLogin($Login){ $this->Login = $Login;}
    function setSenha($Senha){ $this->Senha = $Senha;}
    function setCodUsuarioSuperior($CodUsuarioSuperior){ $this->CodUsuarioSuperior = $CodUsuarioSuperior;}
    function setDesativado($Desativado){ $this->Desativado = $Desativado;}
    function setGerenteContas($GerenteContas){ $this->GerenteContas = $GerenteContas;}
    function setAtendente($Atendente){ $this->Atendente = $Atendente;}
    function setMeta($Meta){ $this->Meta = $Meta;}
    function setcod_polo($cod_polo){ $this->cod_polo = $cod_polo;}
    function setcod_atividade_profissional($cod_atividade_profissional){ $this->cod_atividade_profissional = $cod_atividade_profissional;}
    function setcod_classificacao($cod_classificacao){ $this->cod_classificacao = $cod_classificacao;}
    function setcod_regime($cod_regime){ $this->cod_regime = $cod_regime;}
    function setdat_adm($dat_adm){ $this->dat_adm = $dat_adm;}
    function setdat_dem($dat_dem){ $this->dat_dem = $dat_dem;}
    function setmeta_moeda($meta_moeda){ $this->meta_moeda = $meta_moeda;}
    function setddd_tel($ddd_tel){ $this->ddd_tel = $ddd_tel;}
    function setemei($emei){ $this->emei = $emei;}
    function setemail($email){ $this->email = $email;}
    function settel($tel){ $this->tel = $tel;}
    function setcod_empresa($cod_empresa){ $this->cod_empresa = $cod_empresa;}
    function setcodigosa3($codigosa3){ $this->codigosa3 = $codigosa3;}

	function __construct($pk){
		
		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
		$this->CodUsuarioInterno = null;
        $this->CodDepartamento = null;
        $this->Nome = null;
        $this->Login = null;
        $this->Senha = null;
        $this->CodUsuarioSuperior = null;
        $this->Desativado = null;
        $this->GerenteContas = null;
        $this->Atendente = null;
        $this->Meta = null;
        $this->cod_polo = null;
        $this->cod_atividade_profissional = null;
        $this->cod_classificacao = null;
        $this->cod_regime = null;
        $this->dat_adm = null;
        $this->dat_dem = null;
        $this->meta_moeda = null;
        $this->ddd_tel = null;
        $this->emei = null;
        $this->email = null;
        $this->tel = null;
        $this->cod_empresa = null;
        $this->codigosa3 = null;



		
		if ($pk != 0){
			$sql ="select pk,";
			$sql.="       date_format(dt_cadastro, '%d/%m/%Y %H:%i:%s') dt_cadastro, ";
			$sql.="       date_format(dt_ult_atualizacao, '%d/%m/%Y %H:%i:%s') dt_ult_atualizacao, ";
			$sql.="       usuario_cadastro_pk, ";
			$sql.="       usuario_ult_atualizacao_pk, ";
			$sql.="CodUsuarioInterno, ";
            $sql.="CodDepartamento, ";
            $sql.="Nome, ";
            $sql.="Login, ";
            $sql.="Senha, ";
            $sql.="CodUsuarioSuperior, ";
            $sql.="Desativado, ";
            $sql.="GerenteContas, ";
            $sql.="Atendente, ";
            $sql.="Meta, ";
            $sql.="cod_polo, ";
            $sql.="cod_atividade_profissional, ";
            $sql.="cod_classificacao, ";
            $sql.="cod_regime, ";
            $sql.="dat_adm, ";
            $sql.="dat_dem, ";
            $sql.="meta_moeda, ";
            $sql.="ddd_tel, ";
            $sql.="emei, ";
            $sql.="email, ";
            $sql.="tel, ";
            $sql.="cod_empresa, ";
            $sql.="codigosa3, ";
			$sql.="  from usuariosinternos ";
			$sql.=" where pk = ".$pk;
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$this->pk = $row['pk'];
				$this->dt_cadastro = $row['dt_cadastro'];
				$this->dt_ult_atualizacao = $row['dt_ult_atualizacao'];
				$this->usuario_cadastro_pk = $row['usuario_cadastro_pk'];
				$this->usuario_ult_atualizacao_pk = $row['usuario_ult_atualizacao_pk'];
				$this->CodUsuarioInterno = $row['CodUsuarioInterno'];
                $this->CodDepartamento = $row['CodDepartamento'];
                $this->Nome = $row['Nome'];
                $this->Login = $row['Login'];
                $this->Senha = $row['Senha'];
                $this->CodUsuarioSuperior = $row['CodUsuarioSuperior'];
                $this->Desativado = $row['Desativado'];
                $this->GerenteContas = $row['GerenteContas'];
                $this->Atendente = $row['Atendente'];
                $this->Meta = $row['Meta'];
                $this->cod_polo = $row['cod_polo'];
                $this->cod_atividade_profissional = $row['cod_atividade_profissional'];
                $this->cod_classificacao = $row['cod_classificacao'];
                $this->cod_regime = $row['cod_regime'];
                $this->dat_adm = $row['dat_adm'];
                $this->dat_dem = $row['dat_dem'];
                $this->meta_moeda = $row['meta_moeda'];
                $this->ddd_tel = $row['ddd_tel'];
                $this->emei = $row['emei'];
                $this->email = $row['email'];
                $this->tel = $row['tel'];
                $this->cod_empresa = $row['cod_empresa'];
                $this->codigosa3 = $row['codigosa3'];			
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){
		
		
		$fields['CodUsuarioInterno'] = $this->CodUsuarioInterno;
        $fields['CodDepartamento'] = $this->CodDepartamento;
        $fields['Nome'] = $this->Nome;
        $fields['Login'] = $this->Login;
        $fields['Senha'] = $this->Senha;
        $fields['CodUsuarioSuperior'] = $this->CodUsuarioSuperior;
        $fields['Desativado'] = $this->Desativado;
        $fields['GerenteContas'] = $this->GerenteContas;
        $fields['Atendente'] = $this->Atendente;
        $fields['Meta'] = $this->Meta;
        $fields['cod_polo'] = $this->cod_polo;
        $fields['cod_atividade_profissional'] = $this->cod_atividade_profissional;
        $fields['cod_classificacao'] = $this->cod_classificacao;
        $fields['cod_regime'] = $this->cod_regime;
        $fields['dat_adm'] = $this->dat_adm;
        $fields['dat_dem'] = $this->dat_dem;
        $fields['meta_moeda'] = $this->meta_moeda;
        $fields['ddd_tel'] = $this->ddd_tel;
        $fields['emei'] = $this->emei;
        $fields['email'] = $this->email;
        $fields['tel'] = $this->tel;
        $fields['cod_empresa'] = $this->cod_empresa;
        $fields['codigosa3'] = $this->codigosa3;

		
		//salva a ocorrencia no banco de dados.
		if (empty($this->pk) || trim($this->pk) == ""){
			$fields['dt_cadastro'] = "sysdate()";
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlinsert('usuariosinternos', $fields);
			mysql_query($sql);
			$this->pk = mysql_insert_id();
			
		}
		else{
			$fields['dt_ult_atualizacao'] = "sysdate()";
			$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
			$sql = sqlupdate('usuariosinternos', $fields, ' pk = ' . mysqlnull($this->pk));
			mysql_query($sql);
		}
		
		return $this->pk;
	}
	
	function excluir(){
		
		$sql = "delete from usuariosinternos where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;
		
	}	
	
}
?>
