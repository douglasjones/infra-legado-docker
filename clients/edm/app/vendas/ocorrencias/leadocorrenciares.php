<?

    include_once "../../libs/maininclude.php";
	include_once "../../libs/grid.php";
	include_once "../../libs/datas.php";
	include_once "../../libs/cla.equipes.php";
	if(!permissao('ocorrencias', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
	$codequipe = $_REQUEST['codequipe'];
	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
 	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
    <!-- Cabeçalho -->
	<title></title>
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
		$sql = "Select Distinct o.CodOcorrenciaLead , o.Descricao , DATE_FORMAT(o.DataCadastro,'%d/%m/%Y às %H:%i') as DataCadastro, DATE_FORMAT(o.DataFechamento,'%d/%m/%Y às %H:%i') as DataFechamento, l.RazaoSocial, t.Descricao as TipoOcorrencia, u.Nome as NomeUsuarioInterno , l.CodLead ";
		$sql .= " from ocorrenciaslead o";
		$sql .= " Inner Join leads l on o.CodLead = l.CodLead";
		$sql .= " Inner Join tipoocorrenciaslead t on o.CodTipoOcorrenciaLead = t.CodTipoOcorrenciaLead";
		
		if(!empty($codequipe))
			$sql.=" inner join tb_usuarioequipe tbu on l.codgerenteconta = tbu.Fk_Usuario ";
		
		$sql .= " left Join usuariosinternos u on o.CodUsuarioInterno = u.CodUsuarioInterno";
		$sql .= " left join gruposusuariosinternos_usuariosinternos gu on gu.CodUsuarioInterno = u.CodUsuarioInterno";
		$sql .= " left join gruposusuariosinternos g on gu.CodGrupoUsuarioInterno = g.CodGrupoUsuarioInterno";
		$sql .= " Where 1";

		if(!empty($_REQUEST['codocorrencialead']))
			$sql .= " And o.CodOcorrenciaLead = " . mysqlnull($_REQUEST['codocorrencialead']);

		if(!empty($_REQUEST['razaosocial']))
			$sql .= " And l.RazaoSocial Like " . mysqlnull("%{$_REQUEST['razaosocial']}%");

		if(!empty($_REQUEST['nomefantasia']))
			$sql .= " And l.Nomefantasia Like " . mysqlnull("%{$_REQUEST['nomefantasia']}%");

		if(!empty($_REQUEST['mailing_pk']))
			$sql .= " and l.mailing_pk =".$_REQUEST['mailing_pk'];

		if(!empty($_REQUEST['codusuariointerno']))
			$sql .= " And o.CodUsuarioInterno = " . mysqlnull($_REQUEST['codusuariointerno']);

		if(!empty($_REQUEST['codgrupousuariointerno']))
			$sql .= " And g.CodGrupoUsuarioInterno = " . mysqlnull($_REQUEST['codgrupousuariointerno']);

		if(!empty($_REQUEST['codtipoocorrencialead']))
			$sql .= " and o.CodTipoOcorrenciaLead = " . mysqlnull($_REQUEST['codtipoocorrencialead']);

		if(!empty($_REQUEST['semretorno']))
			$sql .= " and o.CodTipoOcorrenciaLead <> 3";

		if(!empty($codequipe))
			$sql.=" and tbu.Fk_Equipe=".mysqlnull($codequipe);

		if(!empty($_REQUEST['codgerenteconta']))
			$sql .= " and l.CodGerenteConta = " . mysqlnull($_REQUEST['codgerenteconta']);

		if(!empty($_REQUEST['dataini']))
			$sql .= " and o.DataCadastro >= '" . DataYMD($_REQUEST['dataini']) . " 00:00:00'";

		if(!empty($_REQUEST['datafim']))
			$sql .= " and o.DataCadastro <= '" . DataYMD($_REQUEST['datafim']) . " 23:59:59'";

		if(!empty($_REQUEST['codatendente'])){
			$sql .= " And l.codatendente = " . mysqlnull($_REQUEST['codatendente']);
		}

		//COLOCA OS DEMAIS PARÂMETROS
		if(!permissao('visualizar_todos_consultores', 'cs'))
			$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
			
		if(!permissao('visualizar_todos_atendentes', 'cs'))
			$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";


		$aberta = !empty($_REQUEST['aberta']);
		$fechada = !empty($_REQUEST['fechada']);
		if($aberta && !$fechada)
			$sql .= " and o.DataFechamento is Null";

		if(!$aberta && $fechada)
			$sql .= " And o.DataFechamento is Not Null";

		$sql .= " order by ";
		$sql .= " o.DataCadastro Desc, o.CodOcorrenciaLead Desc";
	}
	
	pagegrid($sql, "CodOcorrenciaLead", array("Lead", "Usuário de Cadastro", "Ocorrência", "Descrição", "Data Abertura", "Data Fechamento"), array("RazaoSocial", "NomeUsuarioInterno", "TipoOcorrencia", "Descricao","DataCadastro", "DataFechamento"), 30, $pagina, array('RazaoSocial' => 'CodLead'));?>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
