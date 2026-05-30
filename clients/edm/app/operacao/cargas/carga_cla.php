<?
include_once "../../libs/datas.php";

class carga{

	private $pk;
	private $dt_cadastro;
	private $usuario_cadastro_pk;
	private $dt_ult_atualizacao;
	private $usuario_ult_atualizacao_pk;

	private $cnpj_cpf;
	private $razaosocial;
	private $ddd;
	private $tel;
	private $ddd1;
	private $endereco;
	private $numero;
	private $complemento;
	private $bairro;
        private $cep;
        private $cidade;
        private $contato;
        private $ddd_tel_contato;
        private $tel_contato;
        private $ddd_cel_contato;
        private $contato_cel;
        private $email;
        private $qtdelinhas;
	private $mailing;
	private $arquivo;
        private $codatendente;
        private $codgerenteconta;
        private $codstatusclassificacaolead;

	function getcnpj_cpf(){return $this->cnpj_cpf;}
	function getrazaosocial(){return $this->razaosocial;}
	function getddd(){return $this->ddd;}
	function gettel(){return $this->tel;}
	function getddd1(){return $this->ddd1;}
	function gettel1(){return $this->tel1;}
	function getendereco(){return $this->endereco;}
	function getnumero(){return $this->numero;}
	function getcomplemento(){return $this->complemento;}
        function getbairro(){return $this->bairro;}
        function getcep(){return $this->cep;}
        function getcidade(){return $this->cidade;}
        function getcontato(){return $this->contato;}
        function getddd_tel_contato(){return $this->ddd_tel_contato;}
        function gettel_contato(){return $this->tel_contato;}
        function getddd_cel_contato(){return $this->ddd_cel_contato;}
        function getcel_contato(){return $this->tcel_contato;}
        function getemail(){return $this->email;}
	function getqtdelinhas(){return $this->qtdelinhas;}
	function getmailing(){return $this->mailing;}
	function getarquivo(){return $this->arquivo;}
        function getcodatendente(){return $this->codatendente;}
        function getcodgerenteconta(){return $this->codgerenteconta;}
        function getcodstatusclassificacaolead(){return $this->codstatusclassificacaolead;}

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
	function setcnpj_cpf($cnpj_cpf){ $this->cnpj_cpf = $cnpj_cpf;}
	function setrazaosocial($razaosocial){ $this->razaosocial = $razaosocial;}
	function setddd($ddd){ $this->ddd = $ddd;}
	function settel($tel){ $this->tel = $tel;}
	function setddd1($ddd1){ $this->ddd1 = $ddd1;}
	function settel1($tel1){ $this->tel1 = $tel1;}
	function setendereco($endereco){ $this->endereco = $endereco;}
	function setnumero($numero){ $this->numero = $numero;}
	function setcomplemento($complemento){ $this->complemento = $complemento;}
        function setbairro($bairro){ $this->bairro = $bairro;}
        function setcep($cep){ $this->cep = $cep;}
        function setcidade($cidade){ $this->cidade = $cidade;}
        function setcontato($contato){ $this->contato = $contato;}
        function setddd_tel_contato($ddd_tel_contato){ $this->ddd_tel_contato = $ddd_tel_contato;}
        function settel_contato($cel_contato){ $this->tel_contato = $tel_contato;}
        function setddd_cel_contato($ddd_cel_contato){ $this->ddd_cel_contato = $ddd_cel_contato;}
        function setcel_contato($cel_contato){ $this->cel_contato = $cel_contato;}
        function setemail($email){ $this->email = $email;}
	function setqtdelinhas($qtdelinhas){ $this->qtdelinhas = $qtdelinhas;}    
	function setmailing($mailing){ $this->mailing = $mailing;}
	function setarquivo($arquivo){ $this->arquivo = $arquivo;}
        function setcodatendente($codatendente){ $this->codatendente = $codatendente;}
        function setcodgerenteconta($codgerenteconta){ $this->codgerenteconta = $codgerenteconta;}
        function setcodstatusclassificacaolead($codstatusclassificacaolead){ $this->codstatusclassificacaolead = $codstatusclassificacaolead;}

	function __construct($pk){

		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
		$this->cnpj_cpf = null;
		$this->razaosocial = null;
		$this->ddd = null;
		$this->tel = null;
		$this->ddd1 = null;
		$this->tel1 = null;
		$this->endereco = null;
		$this->nummero = null;        
		$this->complemento = null;
                $this->bairro = null;
                $this->cep = null;
                $this->cidade = null;
                $this->contato = null;
                $this->ddd_tel_contato = null;
                $this->contato_cel = null;
                $this->ddd_cel_contato = null;
                $this->cel_ = null;
		$this->qtdelinhas = null;
		$this->mailing = null;
		$this->arquivo = null;
                $this->codatendente = null;
                $this->codgerenteconta = null;
                $this->codstatusclassificacaolead = null;
        
		if ($pk != 0){
			$sql ="select pk,";
			$sql.="       date_format(dt_cadastro, '%d/%m/%Y %H:%i:%s') dt_cadastro, ";
			$sql.="       usuario_cadastro_pk, ";
			$sql.="cnpj_cpf, ";
			$sql.="razaosocial, ";
			$sql.="ddd, ";
			$sql.="tel, ";
			$sql.="ddd1, ";
			$sql.="tel1, ";	
                        $sql.="endereco, ";
                        $sql.="numero, ";
                        $sql.="complemento, ";
                        $sql.="bairro, ";
                        $sql.="cep, ";
                        $sql.="cidade, ";
			$sql.="contato, ";
                        $sql.="ddd_tel_contato, ";
                        $sql.="tel_contato, ";            
                        $sql.="ddd_cel_contato, ";
                        $sql.="cel_contato, ";
			$sql.="email, ";
			$sql.="qtdelinhas, ";
			$sql.="mailing_pk, ";
                        $sql.="codatendente, ";
                        $sql.="codgerenteconta, ";
                        $sql.="codstatusclassificacaolead ";
			$sql.="  from carga ";
			$sql.=" where pk = ".$pk;
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$this->pk = $row['pk'];
				$this->dt_cadastro = $row['dt_cadastro'];
				$this->dt_ult_atualizacao = $row['dt_ult_atualizacao'];
				$this->usuario_cadastro_pk = $row['usuario_cadastro_pk'];
				$this->usuario_ult_atualizacao_pk = $row['usuario_ult_atualizacao_pk'];
				$this->cnpj_cpf = $row['cnpj_cpf'];
				$this->razaosocial = $row['razaosocial'];
				$this->ddd = $row['ddd'];
				$this->tel = $row['tel'];
				$this->ddd1 = $row['ddd1'];
				$this->tel1 = $row['tel1'];				
				$this->endereco = $row['endereco'];
                                $this->numero = $row['numero'];
                                $this->complemento = $row['complemento'];
                                $this->bairro = $row['bairro'];
                                $this->cep = $row['cep'];
                                $this->cidade = $row['cidade'];
                                $this->contato = $row['contato'];
                                $this->ddd_tel_contato = $row['ddd_tel_contato'];
                                $this->tel_contato = $row['tel_contato'];
                                $this->ddd_cel_contato = $row['ddd_cel_contato'];
                                $this->cel_contato = $row['cel_contato'];
				$this->email = $row['email'];
				$this->qtdelinhas = $row['qtdelinhas'];
				$this->mailing_pk = $row['mailing_pk'];
                                $this->codatendente = $row['codatendente'];
                                $this->codgerenteconta = $row['codgerenteconta'];
                                $this->codstatusclassificacaolead = $row['codstatusclassificacaolead'];
                
			}
			mysql_free_result($result);
		}
	}

	function salvar(){

		$arquivos_pk = 0;
		$delimitador = ';';
		$cerca = '"';

		$fd = fopen ("arquivos/".$this->arquivo,'r');

		//Registra o arquivo que foi recebido.
		$fields = array();
		$fields['dt_cadastro'] = "sysdate()";
		$fields['dt_ult_atualizacao'] = "sysdate()";
		$fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
		$fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
		$fields['ds_arquivo'] = $this->arquivo;
		$fields['ds_mailing'] = $this->mailing;
                $fields['codatendente'] = $this->codatendente;
                $fields['codgerenteconta'] = $this->codgerenteconta;
                $fields['codstatusclassificacaolead'] = $this->codstatusclassificacaolead;
		
		$sql = sqlinsert('arquivos', $fields);

		mysql_query($sql);
		$arquivos_pk = mysql_insert_id();		
		
		// Ler cabecalho do arquivo
		$cabecalho = fgetcsv($fd, 0, $delimitador, $cerca);

		while (!feof ($fd)) {	
                      
                        
			$linha = fgetcsv($fd, 0, $delimitador, $cerca);
			
			$registro = array_combine($cabecalho, $linha);

			$fields = array();
			$fields['cnpj_cpf'] = $registro['cnpj_cpf'].PHP_EOL;
                        $fields['razaosocial'] = $registro['razaosocial'].PHP_EOL;
			$fields['ddd'] = $registro['ddd'].PHP_EOL;
			$fields['tel'] = $registro['tel'].PHP_EOL;
			$fields['ddd1'] = $registro['ddd1'].PHP_EOL;
			$fields['tel1'] = $registro['tel1'].PHP_EOL;
                        $fields['endereco'] = $registro['endereco'].PHP_EOL;
                        $fields['numero'] = $registro['numero'].PHP_EOL;
                        $fields['complemento'] = $registro['complemento'].PHP_EOL;
                        $fields['bairro'] = $registro['bairro'].PHP_EOL;
                        $fields['cep'] = $registro['cep'].PHP_EOL;
                        $fields['cidade'] = $registro['cidade'].PHP_EOL;
			$fields['contato'] = $registro['contato'].PHP_EOL;
                        $fields['ddd_tel_contato'] = $registro['ddd_tel_contato'].PHP_EOL;
                        $fields['tel_contato'] = $registro['tel_contato'].PHP_EOL;
                        $fields['ddd_cel_contato'] = $registro['ddd_cel_contato'].PHP_EOL;
                        $fields['cel_contato'] = $registro['cel_contato'].PHP_EOL;
			$fields['email'] = $registro['email'].PHP_EOL;
			$fields['qtdelinhas'] = $registro['qtdelinhas'].PHP_EOL;
			$fields['mailing_pk'] = $this->mailing_pk;
			$fields['dt_cadastro'] = $registro['Data'].PHP_EOL;
			$fields['ds_nome_arquivo'] = $this->arquivo;
                        $fields['codatendente'] = $this->codatendente;
                        $fields['codgerenteconta'] = $this->codgerenteconta;
                        $fields['codstatusclassificacaolead'] = $this->codstatusclassificacaolead;
            
			$sql = sqlinsert('carga', $fields);
			       
			mysql_query($sql);
                        
		}
               
		mysql_free_result($result);
        
		//FIM DA CARGA

		//REGISTRA LEADS
		$sql ="";
		$sql .="Select
                    c.cnpj_cpf
                    , c.razaosocial
                    , c.ddd
                    , c.tel
                    , c.ddd1
                    , c.tel1
                    , c.endereco
                    , c.numero
                    , c.complemento
                    , c.bairro
                    , c.cep
                    , c.cidade                 
		    , c.contato
                    , c.ddd_tel_contato
                    , c.tel_contato
                    , c.ddd_cel_contato
                    , c.cel_contato                    
                    , c.email					
                    , c.qtdelinhas
                    , c.mailing_pk
				from carga c
				where c.ds_nome_arquivo='".$this->arquivo."'";
				$sql .=" and c.razaosocial is not null";
				$sql .=" group by c.razaosocial";
                
				$result = sql_query($sql);

				while($row = mysql_fetch_array($result)){
					
					$bolJaExiste = false;
					
					//Verifica se o registro já existe na base.
					if(trim($row['cnpj_cpf']) != ""){
						$sql ="";
						$sql.="select count(0) total ";
						$sql.="  from leads ";
						$sql.=" where cnpj_cpf = '".trim($row['cnpj_cpf'])."' ";
						
                                                $rs_lead = mysql_query($sql);
						$row_lead = mysql_fetch_array($rs_lead);
						if($row_lead['total'] > 0){
							$bolJaExiste = true;
						}
						mysql_free_result($rs_lead);
					}
					else{
						$sql ="";
						$sql.="select count(0) total ";
						$sql.="  from leads ";
						$sql.=" where razaosocial = '".trim($row['razaosocial'])."' ";
						
						$rs_lead = mysql_query($sql);
						$row_lead = mysql_fetch_array($rs_lead);
						if($row_lead['total'] > 0){
							$bolJaExiste = true;
						}
						mysql_free_result($rs_lead);							
					}
					
					//Se não existir o registro, cadastra no banco de dados.
					if(!$bolJaExiste){
						
						$fields = array();
						$fields['cnpj_cpf'] = trim($row['cnpj_cpf']);
						$fields['razaosocial'] = trim($row['razaosocial']);						                        
						$fields['ddd'] = trim($row['ddd']);
						$fields['tel'] = trim($row['tel']);
						$fields['dddfax'] = trim($row['ddd1']);
						$fields['fax'] = trim($row['tel1']);
                                                $fields['endereco'] = trim($row['endereco']);
                                                $fields['numero'] = trim($row['numero']);
                                                $fields['complemento'] = trim($row['complemento']);
                                                $fields['bairro'] = trim($row['bairro']);
                                                $fields['cep'] = trim($row['cep']);
                                                $fields['cidade'] = trim($row['cidade']);											
						$fields['qtde_linhas'] = trim($row['qtdelinhas']);
						$fields['mailing_pk'] = trim($this->mailing);
						$fields['datacadastro'] = "sysdate()";
						$fields['codstatusclassificacaolead'] = "2";
						$fields['usuariocadastro'] = $_SESSION['codusuario'];
						$fields['cod_polo'] = "1";
						$fields['tipo_pessoa'] = 'PJ';
						$fields['dt_ult_ocorrencia'] = "sysdate()";
                                                $fields['codatendente'] = trim($this->codatendente);
                                                $fields['codgerenteconta'] = trim($this->codgerenteconta);
                                                $fields['codstatusclassificacaolead'] = trim($this->codstatusclassificacaolead);
                        
						//$fields['arquivos_pk'] = $arquivos_pk;

						$sql = sqlinsert('leads', $fields);
                       
                       // echo $sql."<br>";   
						sql_query($sql);
						$codlead = mysql_insert_id();

						//CONTATO TELEFONE 2 E 3
						//if($row['ddd_tel_contato']!='' or $row['ddd_cel_contato']!=''){
							$this->contato_lead($codlead,trim($row['contato']),trim($row['ddd_tel_contato']),trim($row['tel_contato']),trim($row['ddd_cel_contato']),trim($row['cel_contato']),trim($row['email']));
						//}
						//CONTATO TELEFONE 4 E 5
						//if($row['ddd4']!='' or $row['ddd5']!=''){
						//	$this->contato_lead($codlead,trim($row['Contato']),trim($row['ddd4']),trim($row['tel4']),trim($row['ddd5']),trim($row['tel5']),trim($row['email']));
						//}
					}
				}
                
				mysql_free_result($result);

				//GERA ARQUIVO
				//$this->gera_arquivo_discador($this->mailing,$this->arquivo);

				//Trunca a tabela carga.
				mysql_query("truncate table carga ");
             

	}
	
	function contato_lead($codlead,$contato,$ddd,$tel,$ddd1,$tel1,$email){

		if($contato==''){
		  $contato="contato";
		}

		$fields = array();
		$fields['codlead'] = $codlead;
		$fields['nomecontato'] = $contato;
		$fields['ddd_fone'] = $ddd;
		$fields['fone'] = $tel;
		$fields['ddd_cel'] = $ddd1;
		$fields['cel'] = $tel1;
		$fields['email'] = $email;

		$sql = sqlinsert('contatoslead', $fields);
        
		sql_query($sql);
	}

	function formatarCPF_CNPJ($campo, $formatado = true){
		//retira formato
		$codigoLimpo = ereg_replace("[' '-./ t]",'',$campo);
		// pega o tamanho da string menos os digitos verificadores
		$tamanho = (strlen($codigoLimpo));

		//verifica se o tamanho do código informado é válido
		if ($tamanho < 14){

			if($tamanho=="7"){
				$codigoLimpo  = "0000000".$codigoLimpo;
			}
			if($tamanho=="8"){
				$codigoLimpo  = "000000".$codigoLimpo;
			}
			if($tamanho=="9"){
				$codigoLimpo  = "00000".$codigoLimpo;
			}

			if($tamanho=="10"){
				$codigoLimpo  = "0000".$codigoLimpo;
			}

			if($tamanho=="11"){
				$codigoLimpo  = "000".$codigoLimpo;
			}

			if($tamanho=="12"){
				$codigoLimpo  = "00".$codigoLimpo;
			}
			if($tamanho=="13"){
				$codigoLimpo  = "0".$codigoLimpo;
			}

		}

		if ($formatado){

			// seleciona a máscara para cpf ou cnpj
			$mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';

			$indice = -1;
			for ($i=0; $i < strlen($mascara); $i++) {
				if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
			}
			//retorna o campo formatado
			$retorno = $mascara;

		}else{
			//se não quer formatado, retorna o campo limpo
			$retorno = $codigoLimpo;
		}

		return $retorno;

	}
	function mascara_string($mascara,$string){

		   $string = str_replace(" ","",$string);
		   for($i=0;$i<strlen($string);$i++)
		   {
			  $mascara[strpos($mascara,"#")] = $string[$i];
		   }
		   return $mascara;


	}



	function excluir(){

		$sql = "delete from carta where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;

	}

}
?>
