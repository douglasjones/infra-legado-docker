<?

include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php" ;

//Verifica se o usuario é o administrador
if(!permissao("tabela_dinamica_atendimentos", "cons")){
	javascriptalert("Permissão Negada.", "../branco.php");
	exit(0);
}


	$cod_polo = $_REQUEST['cod_polo'];	
	$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
	$codtipo = $_REQUEST['codtipo'];
	$datacadastrode = $_REQUEST['datacadastrode'];
	$datacadastroate = $_REQUEST['datacadastroate'];
	$datavisitade = $_REQUEST['datavisitade'];
	$datavisitaate = $_REQUEST['datavisitaate'];
	$codequipe = $_REQUEST['codequipe'];
	$codgerenteconta = $_REQUEST['codgerenteconta'];
	$codusuariointerno = $_REQUEST['codusuariointerno'];
	$agendadopara = $_REQUEST['agendadopara'];
	$grupousuariointerno = $_REQUEST['grupousuariointerno'];
	$codstatus = str_replace("\'", "", $_REQUEST['codstatus']);
	$mailing_pk = $_REQUEST['mailing_pk'];

	$sql ="";
	$sql.="select 
            al.CodAgendaLead,  
			l.cidade,			
			scl.descricao statusclassificacaolead,
			date_format(al.datacadastro, '%d/%m/%Y') datacadastro,
			date_format(al.datahorario, '%d/%m/%Y') datavisita,
			date_format(al.datahorario, '%H hr') horariovisita,
			ui2.nome consultor,
			ui1.nome agendadopor,
			ta.descricao tipoagendamento,
			sa.descricao statusagendamento,
			al.codreagendamento,
			al1.codagendalead reagendamento,
			m.dsc_mailing,
            gu.Nome grupo_cadastro,
            ui.nome agendadopara";
	$sql.="  from agendaslead al ";
	$sql.="       inner join leads l on al.codlead = l.codlead ";
	$sql.="       left join mailing m on l.mailing_pk = m.pk ";
	$sql.="		  inner join statusclassificacaolead scl on l.codstatusclassificacaolead = scl.codstatusclassificacaolead ";
	$sql.="		  left join agendaslead al1 on al1.codreagendamento = al.codagendalead and l.codlead = al1.codlead";
	$sql.="       left join usuariosinternos ui1 on al.codusuariointerno = ui1.codusuariointerno ";
    $sql.="       left join usuariosinternos ui on al.agendadopara = ui.codusuariointerno";
	$sql.="       left join tipoagendamento ta on al.codtipo = ta.codtipo ";
	$sql.="       left join statusagendamento sa on al.codstatus = sa.codstatus ";
	$sql.="		  left join agendagerenteconta agc on al.codagendalead = agc.codagendalead";
	$sql.="       left join usuariosinternos ui2 on agc.CodGerenteConta = ui2.CodUsuarioInterno ";
    $sql.="       left join gruposusuariosinternos_usuariosinternos gru on ui1.codusuariointerno = gru.codusuariointerno";
    $sql.="       left join gruposusuariosinternos gu on gru.CodGrupoUsuarioInterno = gu.CodGrupoUsuarioInterno";
	$sql.=" where 1=1 ";
	
	//parametros de pesquisa
	if(!empty($_REQUEST['cod_polo']))
		$sql.="  and l.cod_polo =".$_REQUEST['cod_polo'];

	/*if(count($codstatus)>0){
		$sql.=" and (al.codstatus in (";
		for($i=0;$i<count($codstatus);$i++){
			$sql.=$codstatus[$i].",";
			if($codstatus[$i]=="0"){
				$sql2 = " or al.codstatus is null ";
			}
		}
		$sql.=" 0) ";
		$sql.= $sql2." ) ";
	}*/
    
    if(!empty($codstatus)){
        //for($i=0;$i<count($codstatus);$i++){            
            $sql.="  and al.codstatus in (".$codstatus.")"; 
        //}
    }
    
    
	
	if(!empty($mailing_pk))
		$sql.="  and l.mailing_pk = ".$mailing_pk;	
	
	if(!empty($codstatusclassificacaolead))
		$sql.="  and l.codstatusclassificacaolead = $codstatusclassificacaolead ";
	
	if(!empty($codtipo))
		$sql.="	 and al.codtipo = $codtipo ";
	
	if(!empty($datacadastrode))
		$sql.="  and al.datacadastro >= '".$datacadastrode." 00:00:00' ";
	
	if(!empty($datacadastroate))
		$sql.="  and al.datacadastro <= '".$datacadastroate." 23:59:59' ";
	
	if(!empty($datavisitade))
		$sql.="  and al.datahorario >= '".$datavisitade." 00:00:00' ";
	
	if(!empty($datavisitaate))
		$sql.="  and al.datahorario <= '".$datavisitaate." 23:59:59' ";
	
	if(!empty($codequipe)){
		$sql.="  and al.codusuariointerno in (";
		$sql.=" select e.fk_usuario ";
		$sql.="   from tb_usuarioequipe e ";
		$sql.="  where fk_equipe = $codequipe ) ";
	}
	
	if(!empty($codgerenteconta))
		$sql.=" and al.codagendalead in (select codagendalead from agendagerenteconta where codgerenteconta = $codgerenteconta) ";
		
	if(!empty($codusuariointerno))
		$sql.=" and al.codusuariointerno = $codusuariointerno ";
		
	if(!empty($agendadopara))
		$sql.=" and al.agendadopara = $agendadopara ";
				
	if(!empty($grupousuariointerno)){
		$sql.=" and gru.codgrupousuariointerno in ($grupousuariointerno)";
	}
    
    $sql.=" Group by al.CodAgendaLead ";
	$sql.=" order by al.datacadastro ";
    
$result = mysql_query($sql);

$strResultado = "";
$strResultado.="[";

while($row = mysql_fetch_array($result)){
	
	$arrCampos = array();	
    $arrCampos['CodAgendaLead'] = remover_acentos($row['CodAgendaLead']);

	$arrCampos['Status Agendamento'] = remover_acentos($row['statusagendamento']);
	$arrCampos['Tipo Agendamento'] = remover_acentos($row['tipoagendamento']);    
	$arrCampos['Status Lead'] = $row['statusclassificacaolead'];
	$arrCampos['Data Agendamento'] = remover_acentos($row['datacadastro']);
	$arrCampos['Data Visita'] = remover_acentos($row['datavisita']);
	$arrCampos['Horario Visita'] = $row['horariovisita'];
	$arrCampos['Agendado Por'] = remover_acentos($row['agendadopor']);	
    $arrCampos['Agendado Para'] = $row['agendadopara'];
    $arrCampos['Grupo de Cadastro'] = $row['grupo_cadastro'];
	$arrCampos['Consultor'] = $row['consultor'];
    $arrCampos['Cidade'] = $row['Cidade'];	
	$arrCampos['Mailing'] = $row['dsc_mailing'];
	
	$arrCampos = array_map('htmlentities',$arrCampos);
	$strResultado.=html_entity_decode(json_encode($arrCampos)).",";
	
}
mysql_free_result($result);
$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]";

echo $strResultado;
include_once "../libs/desconectar.php";
?>
