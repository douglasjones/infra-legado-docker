<?	
	$acao = $_REQUEST['acao'];
	$dadosempresa = array();

	if($_REQUEST['etapa']==''){	
		//POLO
		if(!empty($_REQUEST['cod_polo']))
		$empresa['cod_polo'] = $_REQUEST['cod_polo'];
		//RAZAO SOCIAL
		if(!empty($_REQUEST['razao_social']))
			$empresa['razao_social'] = $_REQUEST['razao_social'];
		//NOME FANTASIA
		if(!empty($_REQUEST['nome_fantasia']))
			$empresa['nome_fantasia'] = $_REQUEST['nome_fantasia'];	
		//CNPJ
		if(!empty($_REQUEST['cnpj_cpf']))
			$empresa['cnpj'] = $_REQUEST['cnpj_cpf'];	
		//SITE
		if(!empty($_REQUEST['site']))
			$empresa['site'] = $_REQUEST['site'];	
		//EMAIL
		if(!empty($_REQUEST['email']))
			$empresa['email'] = $_REQUEST['email'];	
		//DDD TEL
		if(!empty($_REQUEST['ddd']))
			$empresa['ddd'] = $_REQUEST['ddd'];		
		//TEL
		if(!empty($_REQUEST['tel']))
			$empresa['tel'] = $_REQUEST['tel'];		
		//DDD FAX
		if(!empty($_REQUEST['dddfax']))
			$empresa['ddd_fax'] = $_REQUEST['dddfax'];
		//FAX
		if(!empty($_REQUEST['fax']))
			$empresa['fax'] = $_REQUEST['fax'];				
		//CEP
		if(!empty($_REQUEST['cep']))
			$empresa['cep'] = $_REQUEST['cep'];	
		//ENDERECO
		if(!empty($_REQUEST['endereco']))
			$empresa['endereco'] = $_REQUEST['endereco'];			
		//NUMERO
		if(!empty($_REQUEST['numero']))
			$empresa['numero'] = $_REQUEST['numero'];	
		//COMPLEMENTO
		if(!empty($_REQUEST['complemento']))
			$empresa['complemento'] = $_REQUEST['complemento'];
		//BAIRROO
		if(!empty($_REQUEST['bairro']))
			$empresa['bairro'] = $_REQUEST['bairro'];
		//CIDADE
		if(!empty($_REQUEST['cidade']))
			$empresa['cidade'] = $_REQUEST['cidade'];
		//ESTADO
		if(!empty($_REQUEST['uf']))
			$empresa['uf'] = $_REQUEST['uf'];
		//TIPO EMPRESA
		if(!empty($_REQUEST['cod_tipo_empresa']))
			$empresa['cod_tipo_empresa'] = $_REQUEST['cod_tipo_empresa'];
        //enviar pelo email do consultor
       if(!empty($_REQUEST['origem_email_agendamento_pk']))
		$empresa['origem_email_agendamento_pk'] = $_REQUEST['origem_email_agendamento_pk'];
       // enviar email
       if(!empty($_REQUEST['enviar_agenda_email_pk']))
		$empresa['enviar_agenda_email_pk'] = $_REQUEST['enviar_agenda_email_pk'];
       //email agendamento
       if(!empty($_REQUEST['agenda_email']))
		$empresa['agenda_email'] = $_REQUEST['agenda_email'];
       //origem email proposta
       if(!empty($_REQUEST['origem_email_proposta_pk']))
		$empresa['origem_email_proposta_pk'] = $_REQUEST['origem_email_proposta_pk'];
       //enviar email proposta
       if(!empty($_REQUEST['enviar_proposta_email_pk']))
		$empresa['enviar_proposta_email_pk'] = $_REQUEST['enviar_proposta_email_pk'];
       //email proposta
       if(!empty($_REQUEST['proposta_email']))
		$empresa['proposta_email'] = $_REQUEST['proposta_email'];
	}	
	if ($acao == 'ins'){	
		if($_REQUEST['etapa']==''){				
			$sql = sqlinsert('empresa', $empresa);			
			sql_query($sql);
			$etapa ==1;
		}		
		return $etapa;
	}
	else if($acao == 'upd' && !empty($produto['codproduto'])){
		$sql = sqlupdate('produtos', $produto, 'CodProduto = ' . mysqlnull($produto['codproduto']));
		sql_query($sql);
		produtos::gravaModulos($modulos, $produto['codproduto']);
		javascriptalert('Operação executada com sucesso.');
	}
	include_once "../../libs/desconectar.php";
?>
