<?

include_once "../../libs/maininclude.php";


//Verifica se o usuario é o administrador

    $codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
	$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
	$codgerenteconta = $_REQUEST['codgerenteconta'];
	$codatendente = $_REQUEST['codatendente'];
	$mailing_pk = $_REQUEST['mailing_pk'];
	$cod_operadora = $_REQUEST['cod_operadora'];
	$cidade = $_REQUEST['cidade'];
    $cep = $_REQUEST['cep'];
	$tipo_pessoa = $_REQUEST['tipo_pessoa'];
	$segmento = $_REQUEST["segmento"];
	$codequipe = $_REQUEST['codequipe'];
	$id_fornecedor = $_REQUEST['id_fornecedor'];
	if(!empty($_REQUEST['cod_polo'])){        
        $cod_polo = $_REQUEST['cod_polo'];        
    }else{        
        $cod_polo = $_SESSION['cod_polo'];
    }

	$sql ="";
	$sql.="select l.codlead,l.cep, dsc_operadora,l.tipo_pessoa,l.cidade,p.n_polo, scl.descricao statusclassificacaolead, ui.nome gerenteconta,ui1.nome as atendente,m.dsc_mailing mailing";
	if(!empty($codequipe)){
        $sql.=" ,tbe.Vc_Nome Equipe";
    }
    $sql.="  from leads l ";
	$sql.="       inner join statusclassificacaolead scl on l.codstatusclassificacaolead = scl.codstatusclassificacaolead ";
	
	if(!empty($codequipe)){
		$sql.=" inner join tb_usuarioequipe tbu on l.codgerenteconta = tbu.Fk_Usuario ";
        $sql.=" left join tb_equipesvendas tbe on tbu.Fk_Equipe = tbe.Tk_Equipe ";
    }
	// só utilizará inner join com a tabela de usuários se o parâmetro gerente de conta for enviado
	if(!empty($codgerenteconta))
		$sql.="       inner ";
	else
		$sql.="       left ";
			
	$sql.="             join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno
						left join usuariosinternos ui1 on l.codatendente = ui1.codusuariointerno";

	$sql.=" left join mailing m on l.mailing_pk = pk";
    $sql.=" left join polo p on l.cod_polo = p.cod_polo";
    $sql.=" left join leads_operadoras lp on l.codlead = lp.codlead";
    $sql.=" left join operadoras op on op.cod_operadora = lp.cod_operadora";
	$sql.=" where 1=1 ";
	
	//COLOCA OS DEMAIS PARÂMETROS
	if(!empty($codstatusclassificacaolead))
		$sql.= " and l.codstatusclassificacaolead = $codstatusclassificacaolead ";
	
	if(!empty($codequipe))
		$sql.=" and tbu.Fk_Equipe=".mysqlnull($codequipe);
		
	if($codgerenteconta > 0){
		$sql.=" and ui.codusuariointerno = $codgerenteconta ";
	}else{
		if($codgerenteconta == '0'){
			$sql.=" and ui.codusuariointerno is null";
		}
		else{
			if(!permissao('visualizar_todos_consultores', 'cs'))
				//if(empty($busca))
					$sql.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		}
	}			
		
	if($codatendente > 0){
		$sql.=" and l.codatendente = $codatendente ";
	}else{
		if($codatendente == '0'){
			$sql.=" and l.codatendente is null ";
		}
	}
	if(!empty($cod_operadora))
		$sql.=" and l.codlead in (select codlead from leads_operadoras where cod_operadora = $cod_operadora) ";
		
	if(!empty($mailing_pk))
		$sql.=" and l.mailing_pk =".$mailing_pk;

	if(!empty($cidade))
		$sql.=" and l.cidade like '%".$cidade."%' ";
	
    if(!empty($_REQUEST['cep'])){
        $sql .= " and l.cep like '".$_REQUEST['cep']."%'";
    }   
    
	if(!empty($tipo_pessoa))
		$sql.=" and l.tipo_pessoa = '".$tipo_pessoa."' ";
		
	if(!empty($segmento))
		$sql.=" and l.segmento like '%".$segmento."%' ";
		
	if(!empty($bairro))
		$sql.=" and l.bairro like '%".$bairro."%' ";
	
	if($cod_polo > 0){
		$sql.=" and l.cod_polo=".$cod_polo;
	}
    
    $sql.=" group by l.codlead ";
	//$sql.=" order by l.razaosocial ";
   // echo $sql;
   // exit;

    $result = mysql_query($sql);

    $strResultado = "";
    $strResultado.="[";

while($row = mysql_fetch_array($result)){
	
	$arrCampos = array();	
	$arrCampos['Polo'] = remover_acentos($row['n_polo']);
    $arrCampos['Status Lead'] = remover_acentos($row['statusclassificacaolead']);
    $arrCampos['Tipo Pessoa'] = remover_acentos($row['tipo_pessoa']);  
    $arrCampos['Equipe'] = remover_acentos($row['Equipe']); 
    $arrCampos['Consultor'] = remover_acentos($row['gerenteconta']); 
    $arrCampos['Atendente'] = remover_acentos($row['atendente']); 
	$arrCampos['Mailing'] = remover_acentos($row['mailing']);  
    $arrCampos['Operadora'] = remover_acentos($row['dsc_operadora']);    
    $arrCampos['Cidade'] = $row['cidade'];
    $arrCampos['Cep'] = $row['cep'];
	$arrCampos['Segmento'] = $row['segmento'];


	
	$arrCampos = array_map('htmlentities',$arrCampos);
	$strResultado.=html_entity_decode(json_encode($arrCampos)).",";
	
}
mysql_free_result($result);
$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]";

echo $strResultado;
include_once "../libs/desconectar.php";
?>
