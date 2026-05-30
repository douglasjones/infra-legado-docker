<?
        /*
Pagina:formulariores.php
modulo:Vendas
submodulo: 

Dados de criação
Criação: 16/08/2008
Empresa:
Executor: RINALDO PELIGRINELI

Histórico das Revisões:
 Criação: 
 Empresa:
 Executor 

Histórico de Auditorias:
 Criação: 
 Empresa:
 Executor:
 */
/*
 Includes
*/
    include_once "../../libs/maininclude.php";
	include_once "../../libs/datas.php";
	include_once "../../libs/grid.php";
	/*if(!permissao('agenda', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	} */?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">

<?	include_once "../../libs/head.php";?>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="post" action="motivodetres.php">
<?	$pagina = 1;
	if(isset($_REQUEST['pagina']))
		$pagina = $_REQUEST['pagina'];
	if($pagina == 0)
		$pagina = 1;
		
	if(isset($_REQUEST['sql'])){
		$sql = $_REQUEST['sql'];
	}else{
		$sql = " Select a.codagendalead, l.RazaoSocial, DATE_FORMAT(a.DataHorario,'%d/%m/%Y às %H:%i') as dataagendamento,ui.Nome";
		$sql .=" from agendaslead a";
		$sql .=" left join agendagerenteconta ag on a.CodAgendaLead = ag.CodAgendaLead";
		$sql .=" left join usuariosinternos ui on ag.CodGerenteConta = ui.CodUsuarioInterno";
		$sql .=" inner join leads l on a.CodLead = l.CodLead";
		$sql .=" where (a.CodStatus is null or a.CodStatus != 5)";
		if(!empty($_REQUEST['cod_polo']) && $_REQUEST['cod_polo'] != 100)
			$sql .= " and l.cod_polo= " . mysqlnull($_REQUEST['cod_polo']);
		if(!empty($_REQUEST['codgerenteconta'])){
			if($_REQUEST['codgerenteconta'] == 'eqp')
				$sql .= " and (ag.CodGerenteConta in (select ue.Fk_Usuario from tb_usuarioequipe ue join tb_equipesvendas e on e.Tk_Equipe = ue.Fk_Equipe where e.Fk_Lider = ".mysqlnull($_SESSION['codusuario']).")
					or ag.CodGerenteConta = ".mysqlnull($_SESSION['codusuario']).")";
			else
				$sql .= " and ag.CodGerenteConta= " . mysqlnull($_REQUEST['codgerenteconta']);
		}
		if(!empty($_REQUEST['dataini']) && !empty($_REQUEST['datafim'])){
			$dataini = dataYMD($_REQUEST['dataini']);
			$datafim = dataYMD($_REQUEST['datafim']);
			$sql.= " And a.DataHorario Between '".$dataini." 00:00:00' And '".$datafim." 23:59:59'";
		}
		$sql .=" group by  a.CodAgendaLead";
		$sql .=" order by a.DataHorario ";
	}
	
	pagegrid($sql, "codagendalead", array("Código", "Lead", "Data Visita", "Consultor"), array("codagendalead", "RazaoSocial", "dataagendamento", "Nome"), 30, $pagina);?>
  


</body>
</html>
<?	include_once "../../libs/desconectar.php";?>