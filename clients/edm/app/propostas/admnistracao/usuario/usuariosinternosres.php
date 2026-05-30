<?
include_once "../../libs/maininclude.php";
include_once "../../libs/grid.php";
if(!permissao('usuarios', 'cs')){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
exit;
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">

<?	include_once "../../libs/head.php";?>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?	$pagina = 1;
	if(isset($_REQUEST['pagina']))
		$pagina = $_REQUEST['pagina'];
	if($pagina == 0)
		$pagina = 1;
		
	if(!empty($_REQUEST['sql'])){
		$sql = $_REQUEST['sql'];
	}else{
		$sql = "select 
					Distinct u.CodUsuarioInterno
					,u.Nome
					,u.Login
					,ap.dsc_atividade
					,d.nome as departamento
					,p.n_polo
					,ep.nome_fantasia
					,IF(u.Desativado = 1, 'Desativado', 'Ativo') Status
				from usuariosinternos u 
					left join gruposusuariosinternos_usuariosinternos g on u.CodUsuarioInterno = g.CodUsuarioInterno
					left join atividade_profissional ap on u.cod_atividade_profissional = ap.cod_atividade_profissional
					left join departamento d on u.CodDepartamento  = d.coddepartamento
					left join polo p on u.cod_polo = p.cod_polo
					left join empresa ep on u.cod_empresa = ep.cod_empresa
				Where 1 ";
		if (!empty($_REQUEST['codgrupousuariointerno']))
			$sql .= " and g.CodGrupoUsuarioInterno = " . mysqlnull($_REQUEST['codgrupousuariointerno']);
		if (!empty($_REQUEST['coddepartamento']))
			$sql .= " and u.CodDepartamento=" . mysqlnull($_REQUEST['coddepartamento']);		
		if (!empty($_REQUEST['nome']))
			$sql .= " and u.Nome Like " . mysqlnull("%{$_REQUEST['nome']}%");		
		if (!empty($_REQUEST['login']))
			$sql .= " and u.Login Like " . mysqlnull("%{$_REQUEST['login']}%");		
		if (!empty($_REQUEST['desativado']))		
			$sql .= " and u.Desativado Like " . mysqlnull($_REQUEST['desativado']);		
		//NOVOS FILTORS DE BUSCA
		//POLO
		if (!empty($_REQUEST['cod_polo']))
			$sql .= " and u.cod_polo=" . mysqlnull($_REQUEST['cod_polo']);	
		//EMPRESA
		if (!empty($_REQUEST['cod_empresa']))
			$sql .= " and u.cod_empresa=" . mysqlnull($_REQUEST['cod_empresa']);	
		//SUPERVISOR
		if (!empty($_REQUEST['codusuariosuperior']))
			$sql .= " and u.codusuariosuperior=" . mysqlnull($_REQUEST['codusuariosuperior']);	
		//GRUPO DE ACESSO
		if (!empty($_REQUEST['codgrupousuariointerno']))
			$sql .= " and g.CodGrupoUsuarioInterno=" . mysqlnull($_REQUEST['codgrupousuariointerno']);			
		//DEPARTAMENTO
		if (!empty($_REQUEST['coddepartamento']))
			$sql .= " and u.coddepartamento=" . mysqlnull($_REQUEST['coddepartamento']);			
		//ATIVIDADE PROFISSIONAL
		if (!empty($_REQUEST['cod_atividade_profissional']))
			$sql .= " and u.cod_atividade_profissional=" . mysqlnull($_REQUEST['cod_atividade_profissional']);		
		//NUMEOR DO TELEFONE
		if (!empty($_REQUEST['tel']))		
			$sql .= " and u.tel Like " . mysqlnull($_REQUEST['tel']);	
		//NUMEOR DO EMEI TELEFONE
		if (!empty($_REQUEST['emei']))		
			$sql .= " and u.emei Like " . mysqlnull($_REQUEST['emei']);	
		//EMAI
		if (!empty($_REQUEST['email']))		
			$sql .= " and u.email Like " . mysqlnull($_REQUEST['email']);
		$sql.= " order by Nome, Login";
	}
	pagegrid($sql, "CodUsuarioInterno", array("Código", "Nome", "Login", "Função", "Departamento","Polo","Empresa", "Status"), array("CodUsuarioInterno", "Nome", "Login", "dsc_atividade", "departamento","n_polo","nome_fantasia",  "Status"), 30, $pagina);?>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
