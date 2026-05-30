<?

include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";

//Verifica se o usuario é o administrador
if(!permissao("tabela_dinamica_ocorrencias", "cons")){
	javascriptalert("Permissão Negada.", "../branco.php");
	exit(0);
}
	$cod_polo = $_REQUEST['cod_polo'];
	$codtipoocorrencialead = $_REQUEST['codtipoocorrencialead'];	
	$datavisitade = $_REQUEST['datavisitade'];
    $datavisitaate = $_REQUEST['datavisitaate'];
	$datafechamentode = $_REQUEST['datafechamentode'];
    $datafechamentoate = $_REQUEST['datafechamentoate'];
    $abertopor = $_REQUEST['abertopor'];
	$equipe = $_REQUEST['equipe'];
    $codgerenteconta = $_REQUEST['codgerenteconta'];
    $codatendente = $_REQUEST['codatendente'];
    
	$sql ="";
	$sql = "Select
 			o.codocorrencialead
			,DATE_FORMAT(o.DataCadastro, '%d/%m/%Y ás %H:%i' ) as abertura
			,DATE_FORMAT(o.DataFechamento, '%d/%m/%Y ás %H:%i') as fechamento
			,l.RazaoSocial
			,t.Descricao Tipo
			,u.Nome AbertoPor
            ,p.n_polo
            ,ui.nome atendente
            ,g.Nome grupo_cadastro
            ,ui1.Nome gerente
		 From ocorrenciaslead o
			 inner join leads l on o.CodLead = l.CodLead
             left join polo p on l.cod_polo = p.cod_polo
			 inner join tipoocorrenciaslead t on o.CodTipoOcorrenciaLead = t.CodTipoOcorrenciaLead
			 left join usuariosinternos u on o.CodUsuarioInterno = u.CodUsuarioInterno
             left join usuariosinternos ui on l.codatendente = ui.CodUsuarioInterno
             left join usuariosinternos ui1 on l.codgerenteconta = ui1.CodUsuarioInterno
			 left join gruposusuariosinternos_usuariosinternos gu on gu.CodUsuarioInterno = u.CodUsuarioInterno
             left join gruposusuariosinternos g on gu.CodGrupoUsuarioInterno = g.CodGrupoUsuarioInterno
		 Where 1 ";
	
	if(!empty($_REQUEST['cod_polo'])){
		$sql .= " and l.cod_polo=" . mysqlnull($_REQUEST['cod_polo']);
	}
	if(!empty($_REQUEST['codtipoocorrencialead'])){
		$codtipoocorrencialead = $_REQUEST['codtipoocorrencialead'];
		$sql .= " And o.CodTipoOcorrenciaLead = " . mysqlnull($codtipoocorrencialead);
	}
	if(!empty($_REQUEST['datacadastrode']) && !empty($_REQUEST['datacadastroate'])){
		$datacadastrode = dataYMD($_REQUEST['datacadastrode']);
		$datacadastroate = dataYMD($_REQUEST['datacadastroate']);
		$sql .= " And o.DataCadastro Between '$datacadastrode 00:00:00' And '$datacadastroate 23:59:59'";
	}
	if(!empty($_REQUEST['datafechamentode']) && !empty($_REQUEST['datafechamentoate'])){
		$datafechamentode = dataYMD($_REQUEST['datafechamentode']);
		$datafechamentoate = dataYMD($_REQUEST['datafechamentoate']);
		$sql .= " And o.DataFechamento Between '$datafechamentode 00:00:00' And '$datafechamentoate 23:59:59'";	
	}
	if(!empty($_REQUEST['codusuariointerno'])){
		$codusuariointerno = $_REQUEST['codusuariointerno'];
		$sql .= " And o.CodUsuarioInterno = ".$codusuariointerno;
	}
	if(!empty($_REQUEST['equipe'])){
		$equipe = $_REQUEST['equipe'];
		$sql.= " And gu.CodGrupoUsuarioInterno = " . mysqlnull($equipe);
	}
	if(!empty($_REQUEST['codgerenteconta'])){
		$codgerenteconta = $_REQUEST['codgerenteconta'];
		$sql.= " And l.CodGerenteConta = " . mysqlnull($codgerenteconta);
	}
	if($GerenteContas && !permissao('leadoutrogerente', 'al')){
		$gerenteconta = $_SESSION['codusuario'];
		$sql .= " and l.CodGerenteConta = ".$gerenteconta;
	}
    if(!empty($_REQUEST['codatendente'])){		
		$sql.= " And l.codatendente= " .$_REQUEST['codatendente'];
	}
	$sql .= " Order By o.DataCadastro";


$result = mysql_query($sql);
//echo $sql;
//exit;
$strResultado = "";
$strResultado.="[";

while($row = mysql_fetch_array($result)){
	
	$arrCampos = array();	
	$arrCampos['Polo'] = remover_acentos($row['n_polo']); 
    $arrCampos['Tipo Ocoprrencia'] = remover_acentos($row['Tipo']); 
	$arrCampos['Data Abertura'] = remover_acentos($row['abertura']);
	$arrCampos['Data Fechamento'] = remover_acentos($row['fechamento']);
	$arrCampos['Aberto Por'] = $row['AbertoPor'];
    $arrCampos['Atendente'] = $row['atendente'];
    $arrCampos['Consultor'] = remover_acentos($row['gerente']);	
	$arrCampos['Agendado Por'] = remover_acentos($row['agendadopor']);    
    $arrCampos['Grupo de Cadastro'] = remover_acentos($row['grupo_cadastro']);	
    
	
	$arrCampos = array_map('htmlentities',$arrCampos);
	$strResultado.=html_entity_decode(json_encode($arrCampos)).",";
	
}
mysql_free_result($result);
$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]";

echo $strResultado;
include_once "../libs/desconectar.php";
?>
