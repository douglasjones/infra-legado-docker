<?  
/*
/---------------------------------------------------\
|						    						|
|DESCRIÇÃO: PRINCIPAIS FUNÇÕES DO SISTEMA EM PHP    |
|						    						|
|					     	    					|
|REVISÕES:					    					|
|						    						|
|						    						| 
|DESESENVOLVIDO POR: DOUGLAS JONES LOPES	    	|
|						    						|
|DATA: 24/07/2008	     			    			|
\____________________G_E_P_R_O_S____________________/
*/

//____________________INCLUDES____________________/
    include_once "../../libs/maininclude.php";
	include_once "../../libs/datas.php";
	include_once "../../libs/grid.php";
	if(!permissao('proposta', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?	include_once "../../libs/head.php";?>

    <!--Comandos Javascript-->
	<script type="text/javascript" language="javascript">
	function abrirGrid(campo, valor){
		switch(campo){
			case 'RazaoSocial':
				top.pagina.location = '../../vendas/leads/leadgerenciamentores.php?codlead=' + valor
				break
		}
	}
	</script>
 	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
</head>

<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?	$pagina = 1;
	if(isset($_REQUEST['pagina']))
		$pagina = $_REQUEST['pagina'];
	if($pagina == 0)
		$pagina = 1;
		
	if(isset($_REQUEST['sql'])){
		$sql = $_REQUEST['sql'];
	}else{
		$sql = "select pro.CodProposta, pro.Versao, Concat(pro.CodProposta, '.', pro.Versao, '.', pro.CodLead) as CodVersaoLead, Concat(pro.CodProposta, '.', pro.Versao, ' - ', p.Nome) as CodVersao, pro.CodLead, l.RazaoSocial, s.Descricao StatusClassificacaoLead, ui.Nome UsuarioInterno, CONCAT(DATE_FORMAT(pro.DataCadastro, '%d/%m/%Y'), IF(DataCancelamento Is Null, '', ' Cancelada')) as DataProposta,  DATE_FORMAT(pro.DataEnvio,'%d/%m/%Y') as DataEnvio, DATE_FORMAT(pro.DataPrevisaoRecebimento,'%d/%m/%Y') as DataPrevisaoRecebimento, DATE_FORMAT(pro.DataRecebimento,'%d/%m/%Y') as DataRecebimento";
		$sql .= " from propostas pro";
		$sql .= " left join leads l on pro.codlead = l.codlead";
		$sql .= " left join statusclassificacaolead s on l.CodStatusClassificacaoLead = s.CodStatusClassificacaoLead";
		$sql .= " left join usuariosinternos ui on pro.CodUsuarioInterno = ui.CodUsuarioInterno";
		$sql .= " left join produtos p on pro.CodProduto = p.CodProduto";
		$sql .= " where 1 ";
		
		if($GerenteContas && !permissao('leadoutrogerente', 'al'))
			$sql .= " and l.CodGerenteConta = " . mysqlnull($_SESSION['codusuario']);
		
		if (!empty($_REQUEST['razaosocial']))
			$sql .= " and l.RazaoSocial like " . mysqlnull("%{$_REQUEST['razaosocial']}%") . " Or l.NomeFantasia like " . mysqlnull("%{$_REQUEST['razaosocial']}%");
		
		if (!empty($_REQUEST['cpf_cnpj']))
			$sql .= " and l.CNPJ_CPF like " . mysqlnull("%{$_REQUEST['cpf_cnpj']}%");
		
		if(!empty($_REQUEST['datacadastrode']) && !empty($_REQUEST['datacadastroate']))
			$sql .= "and pro.DataCadastro Between '" . DataYMD($_REQUEST['datacadastrode']) . " 00:00:00' And '".DataYMD($_REQUEST['datacadastroate']) . " 23:59:59' ";

		if(!empty($_REQUEST['canceladas']))
			$sql .= " and DataCancelamento Is Not Null ";
		else
			$sql .= " and DataCancelamento Is Null ";

		if(!empty($_REQUEST['dataenviode']) && !empty($_REQUEST['dataenvioate'])){
			$sql .= "and pro.DataEnvio Between '" . DataYMD($_REQUEST['dataenviode']) . " 00:00:00' And '" . DataYMD($_REQUEST['dataenvioate']) . " 23:59:59' ";
		}else{
//			$sql .= " and pro.DataEnvio Is Null ";
		}
		
		if(!empty($_REQUEST['dataprevisaode']) && !empty($_REQUEST['dataprevisaoate'])){
			$sql .= "and pro.DataPrevisaoRecebimento Between '" . DataYMD($_REQUEST['dataprevisaode']) . " 00:00:00' And '" . DataYMD($_REQUEST['dataprevisaoate']) . " 23:59:59' ";
		}else{
//			$sql .= " and pro.DataPrevisaoRecebimento Is Null ";
		}
		
		if(!empty($_REQUEST['datarecebimentode']) && !empty($_REQUEST['datarecebimentoate'])){
			$sql .= "and pro.DataRecebimento Between '" . DataYMD($_REQUEST['datarecebimentode']) . " 00:00:00' And '" . DataYMD($_REQUEST['datarecebimentoate']) . " 23:59:59' ";
		}else{
//			$sql .= " and pro.DataRecebimento Is Null ";
		}
			
		if(!empty($_REQUEST['dataenviofirmade']) && !empty($_REQUEST['dataenviofirmaate'])){
			$sql .= "and pro.DataEnvioFirma Between '" . DataYMD($_REQUEST['dataenviofirmade']) . " 00:00:00' And '" . DataYMD($_REQUEST['dataenviofirmaate']) . " 23:59:59' ";
		}else{
//			$sql .= " and pro.DataEnvioFirma Is Null ";
		}
		
		if(!empty($_REQUEST['datarecebimentofirmade']) && !empty($_REQUEST['datarecebimentofirmaate'])){
			$sql .= "and pro.DataRecebimentofirma Between '" . DataYMD($_REQUEST['datarecebimentofirmade']) . " 00:00:00' And '" . DataYMD($_REQUEST['datarecebimentofirmaate']) . " 23:59:59' ";
		}else{
//			$sql .= " and pro.DataRecebimentoFirma Is Null ";
		}
		
		if(!empty($_REQUEST['dataenviocontratode']) && !empty($_REQUEST['dataenviocontratoate'])){
			$sql .= "and pro.DataEnvioContrato Between '" . DataYMD($_REQUEST['dataenviocontratode']) . " 00:00:00' And '" . DataYMD($_REQUEST['dataenviocontratoate']) . " 23:59:59' ";
		}else{
//			$sql .= " and pro.dataenviocontrato Is Null ";
		}
		
		if(!empty($_REQUEST['datarecebimentocontratode']) && !empty($_REQUEST['datarecebimentocontratoate'])){
			$sql .= " and pro.DataRecebimentoContrato Between '" . DataYMD($_REQUEST['datarecebimentocontratode']) . " 00:00:00' And '" . DataYMD($_REQUEST['datarecebimentocontratoate']) . " 23:59:59' ";
		}else{
//			$sql .= " and pro.DataRecebimentoContrato Is Null ";
		}
		
		if(!empty($_REQUEST['codproduto']))
			$sql .= "and pro.CodProduto = " . $_REQUEST['codproduto'];
			
		$sql .= " group by pro.CodProposta, pro.Versao Order By pro.CodProposta Desc, pro.Versao Desc, l.razaosocial ";
	}
	pagegrid($sql, "CodVersaoLead", array("Código.Versão - Produto", "Razão Social", "Status", "Data Cadastro", "Data Envio", "Data Previsão", "Data Recebimento"), array("CodVersao", "RazaoSocial", "StatusClassificacaoLead", "DataProposta", "DataEnvio", "DataPrevisaoRecebimento", "DataRecebimento"), 30, $pagina, array('RazaoSocial' => 'CodLead'));?>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
