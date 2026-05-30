<?	
include_once "../../libs/maininclude.php";
class modelo_proposta {
	//REGISTRA O MODELO DA PROPOSTA
	function modelo($value){
		//LISTA OS CAMPOS DO FORMULARIO E VALIDA SE ESTAO VASIAS E ATRIBUI NULL
		if(!isset($value['cod_polo'])) $value['cod_polo'] = null;
		if(!isset($value['razao_social'])) $value['razao_social'] = null;		
		if(!isset($value['nome_fantasia'])) $value['nome_fantasia'] = null;		
		if(!isset($value['cnpj_cpf'])) $value['cnpj_cpf'] = null;				
		if(!isset($value['site'])) $value['site'] = null;				
		if(!isset($value['email'])) $value['email'] = null;						
		if(!isset($value['ddd'])) $value['ddd'] = null;						
		if(!isset($value['tel'])) $value['tel'] = null;				
		if(!isset($value['dddfax'])) $value['dddfax'] = null;		
		if(!isset($value['fax'])) $value['fax'] = null;										
		if(!isset($value['cep'])) $value['cep'] = null;				
		if(!isset($value['endereco'])) $value['endereco'] = null;						
		if(!isset($value['numero'])) $value['numero'] = null;						
		if(!isset($value['complemento'])) $value['complemento'] = null;						
		if(!isset($value['bairro'])) $value['bairro'] = null;						
		if(!isset($value['cidade'])) $value['cidade'] = null;						
		if(!isset($value['uh'])) $value['uf'] = null;	
		if(!isset($value['cod_tipo_empresa'])) $value['cod_tipo_empresa'] = null;

		//ARRAY DAS VARIAVEIS PASSADAS DO FORMULARIO
		$fields = array();
		$fields['cod_polo'] = $value['cod_polo'];
		$fields['razao_social'] = $value['razao_social'];		
		$fields['nome_fantasia'] = $value['nome_fantasia'];		
		$fields['cnpj'] = $value['cnpj_cpf'];		
		$fields['site'] = $value['site'];		
		$fields['email'] = $value['email'];		
		$fields['ddd'] = $value['ddd'];		
		$fields['tel'] = $value['tel'];		
		$fields['ddd_fax'] = $value['dddfax'];		
		$fields['cep'] = $value['cep'];		
		$fields['endereco'] = $value['endereco'];		
		$fields['numero'] = $value['numero'];		
		$fields['complemento'] = $value['complemento'];		
		$fields['bairro'] = $value['bairro'];		
		$fields['cidade'] = $value['cidade'];		
		$fields['uf'] = $value['uf'];	
		$fields['cod_tipo_empresa'] = $value['cod_tipo_empresa'];	
		//INSERE OS DADOS DA EMPRESA		
		if($value['config']==1 && $value['acao']=='ins'){		
			$sql = sqlinsert('empresa', $fields);				
			sql_query($sql);
			$cod_empresa = mysql_insert_id();
		}
		
		if($value['config']==1 && $value['acao']=='al'){		
			$sql = sqlupdate('empresa', $fields, 'cod_empresa = '.$value['cod_empresa']);
			sql_query($sql);
			$cod_empresa = $value['cod_empresa'];
		}
		//CONTROLE DE IMAGEM
		if($value['config']==2){
			$sql = sqlupdate('empresa', array('url_logo' => '../../images/logo','largura' => $value['largura'],'altura' => $value['altura']), 'cod_empresa = '.$value['cod_empresa']);
			sql_query($sql);
			$cod_empresa = $value['cod_empresa'];
		}
		//CONTROLE DE IMAGEM
		if($value['config']==3){
			//EXCLUI OS OPERADORES DA EMPRESA
			$sql= "delete from empresa_operador where cod_empresa =".$value['cod_empresa'];		 
	    	sql_query($sql);
			$operador = $value['operador'];			
			if(!empty($operador))
			{
				if(!is_array($operador)) return null;
				$set = array();						
					//INSERE OS OS OPERADORES DA EMPREA		
					foreach($operador as $operadors){					
						$sql = sqlinsert('empresa_operador',array('cod_empresa'=>$value['cod_empresa'],'cod_operador'=>$operadors,'dat_cad'=>"SYSDATE()",'cod_user_cad'=>$_SESSION['codusuario']));												
						sql_query($sql);
					}
			}	
			$cod_empresa = $value['cod_empresa'];
		}
		//EDITA DATAS PROPOSTA OPERADOR
		if($value['config']==4){			
			 $data = "null";
			 if($value['acao']=='del') {
			 	$data = "SYSDATE()";
			 }
			$sql = sqlupdate('data_proposta_operador', array('cod_operador'=> $value['cod_operador'],'dsc_data' => $value['dsc_data'],'obs_data' => $value['obs_data'],'ordem' => $value['ordem'],'nome_data'=> $value['nome_data'],'codtipoocorrencialead'=>  $value['codtipoocorrencialead'],'dat_cad'=>"SYSDATE()",'cod_user_cad'=>$_SESSION['codusuario'],'dat_canc'=>$data), 'cod_data_proposta_operador = '.$value['cod_data_proposta_operador']);
			sql_query($sql);			
			$cod_empresa = $value['cod_empresa'];
			
			
		}
		if($value['config']==5){
			$sql = sqlinsert('data_proposta_operador', array('cod_operador'=> $value['cod_operador'],'dsc_data' => $value['dsc_data'],'obs_data' => $value['obs_data'],'ordem' => $value['ordem'],'nome_data'=> $value['nome_data'],'codtipoocorrencialead'=>  $value['codtipoocorrencialead'],'dat_cad'=>"SYSDATE()",'cod_user_cad'=>$_SESSION['codusuario']));				
			sql_query($sql);			
			$cod_empresa = $value['cod_empresa'];
		}	
		//RETORNA O CODIGO DA EMRPESA		
		return $codmodelo;
	}
}
?>
