<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.ocorrencias.php";
	$acao = "";
   
	if(!empty($_REQUEST['acao']))
		$acao = $_REQUEST['acao'];
//VERIFICA O ULTIMO CODIGO DE PRODUTO POR OPERADOR	
	if ($acao == 'ins'){
		//PRODUTOS CLARO
		if($_REQUEST['cod_operador']==1){			
			$sql = "Select 
					max(oc.CodTipoOcorrenciaLead) as codtipoocorrencialead
					from tipoocorrenciaslead oc
					where oc.cod_operador=1";
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			$codtipoocorrencialead = $row['codtipoocorrencialead'];
			$codtipoocorrencialead = $codtipoocorrencialead + 1;			
		}	
		//PRODUTOS TIM
		if($_REQUEST['cod_operador']==2){			
			$sql = "Select 
					max(oc.CodTipoOcorrenciaLead) as codtipoocorrencialead
					from tipoocorrenciaslead oc
					where oc.cod_operador=2";
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			$codtipoocorrencialead = $row['codtipoocorrencialead'];
			$codtipoocorrencialead = $codtipoocorrencialead + 1;				
		}	
		//PRODUTOS VIVO
		if($_REQUEST['cod_operador']==3){			
			$sql = "Select 
					max(oc.CodTipoOcorrenciaLead) as codtipoocorrencialead
					from tipoocorrenciaslead oc
					where oc.cod_operador=3";
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			$codtipoocorrencialead = $row['codtipoocorrencialead'];
			$codtipoocorrencialead = $codtipoocorrencialead + 1;				
		}	
		//PRODUTOS NEXTEL
		if($_REQUEST['cod_operador']==4){			
			$sql = "Select 
					max(oc.CodTipoOcorrenciaLead) as codtipoocorrencialead
					from tipoocorrenciaslead oc
					where oc.cod_operador4";
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			$codtipoocorrencialead = $row['codtipoocorrencialead'];
			$codtipoocorrencialead = $codtipoocorrencialead + 1;				
		}
	}
    
    
	
    if(!empty($_REQUEST['codtipoocorrenciaLead'])){
		$values['CodTipoOcorrenciaLead'] = $_REQUEST['codtipoocorrenciaLead'];
	}else{
		$values['CodTipoOcorrenciaLead'] = $codtipoocorrencialead;
	}	
	if(!empty($_REQUEST['Descricao']))
		$values['Descricao'] = $_REQUEST['Descricao'];

	if(!empty($_REQUEST['Status']))
		$values['Status'] = $_REQUEST['Status'];

	if(!empty($_REQUEST['Automatica']))
		$values['Automatica'] = $_REQUEST['Automatica'];

	if(!empty($_REQUEST['Fechar']))
		$values['Fechar'] = $_REQUEST['Fechar'];

	if(!empty($_REQUEST['Minutos']))
		$values['Minutos'] = $_REQUEST['Minutos'];
		
	if(!empty($_REQUEST['cod_operador']))
		$values['cod_operador'] = $_REQUEST['cod_operador'];
   
	
    $values['status_pk'] = $_REQUEST['status_pk'];    
    
    
	if ($acao == 'ins'){
		$ret = ocorrencias::addtipo( $values ) ;
		javascriptalert( $ret ) ;
	}

	else if($acao == 'upd' && !empty($values)){
        echo $values['status_pk'];
		$ret = ocorrencias::edittipo($values);
		javascriptalert($ret);
	}
	else if($acao == "ex" ){
		$ret = ocorrencias::deltipo($_REQUEST['codocorrencialead']);
		javascriptalert($ret);
	}
	include_once "../../libs/desconectar.php";?>
