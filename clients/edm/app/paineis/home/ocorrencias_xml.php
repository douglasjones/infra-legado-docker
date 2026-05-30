<?php

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.equipes.php";

$cod_polo = $_REQUEST['cod_polo'];

$cor = array("AFD8F8","F6BD0F","00FF00","FF3100");
$tipo_ocorrencia = array(5,1,5000,37);
$data = date('Y')."-".date('m')."-".date('d');

$strGrafico = "";
$strCategoria = "";
$strDados = "";
$total_linhas = 0;
$total_linhas1 = 0;
$total_linhas2 = 0;
$total_ocorrencias = 0;


$strCategoria.= "<categories>  ";

//Pega todos os operadores
$sql ="";
$sql.="select ui.nome, count(*) total ";
$sql.="  from usuariosinternos ui ";
$sql.="       inner join ocorrenciaslead ol on ol.codusuariointerno = ui.codusuariointerno ";
$sql.="       inner join leads l on ol.codlead = l.codlead ";
$sql.=" where ui.atendente = 1 ";
$sql.="  and ol.datacadastro between '$data' and '$data 23:59:59' ";
$sql.="  and ol.codtipoocorrencialead <> 77 ";
if($cod_polo != "")
	$sql.=" and l.cod_polo = $cod_polo ";
	
//COLOCA OS DEMAIS PARÂMETROS
if(!permissao('visualizar_todos_consultores', 'cs'))
	$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
if(!permissao('visualizar_todos_atendentes', 'cs'))
	$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
$sql.=" group by ui.nome having count(*) > 0  ";
$sql.=" order by total desc ";
$sql.=" limit 10";

$result = sql_query($sql);
while($row = mysql_fetch_array($result)){
	$strCategoria.= "<category name='".substr($row['nome'],0,10)."'/> ";
	$total_ocorrencias += $row['total'];
}
mysql_free_result($result);
$strCategoria.= "</categories> ";

for ($i = 0; $i < count($tipo_ocorrencia);$i++){
	$sql ="";
	$sql.="select descricao from tipoocorrenciaslead where codtipoocorrencialead = ".$tipo_ocorrencia[$i];
	$result = sql_query($sql);
	while($row = mysql_fetch_array($result)){
		$strDados.= "<dataset seriesName='".$row['descricao']."' color='".$cor[$i]."' showValues='0'> ";
		$sql ="";
		$sql.="select ui.codusuariointerno, ui.nome, count(*) total ";
		$sql.="  from usuariosinternos ui ";
		$sql.="       inner join ocorrenciaslead ol on ol.codusuariointerno = ui.codusuariointerno ";
		$sql.="       inner join leads l on ol.codlead = l.codlead ";
		$sql.=" where ui.atendente = 1 ";
		$sql.="   and ol.datacadastro between '$data' and '$data 23:59:59' ";
		$sql.="   and ol.codtipoocorrencialead <> 77 ";
		if($cod_polo != "")
			$sql.=" and l.cod_polo = $cod_polo ";
			
		//COLOCA OS DEMAIS PARÂMETROS
		if(!permissao('visualizar_todos_consultores', 'cs'))
			$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
			
		if(!permissao('visualizar_todos_atendentes', 'cs'))
			$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
			
			
		$sql.=" group by ui.codusuariointerno, ui.nome having count(*) > 0 ";
		$sql.=" order by total desc ";
		$sql.=" limit 10";

		$result_oper = sql_query($sql);
		while($row_oper = mysql_fetch_array($result_oper)){
			//Pega a quantidade de ocorrencias
			$sql = "";
			$sql.="select count(*) total ";
			$sql.="  from ocorrenciaslead ol ";
			$sql.="       inner join leads l on ol.codlead = l.codlead ";
			$sql.=" where ol.datacadastro between '$data' and '$data 23:59:59' ";
			$sql.="   and ol.codtipoocorrencialead <> 77 ";
			if($cod_polo != "")
				$sql.=" and l.cod_polo = $cod_polo ";
			
			//COLOCA OS DEMAIS PARÂMETROS
			if(!permissao('visualizar_todos_consultores', 'cs'))
				$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
				
			if(!permissao('visualizar_todos_atendentes', 'cs'))
				$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
			
			$sql.="   and ol.codusuariointerno = ".$row_oper['codusuariointerno']." ";
			$sql.="   and ol.codtipoocorrencialead = ".$tipo_ocorrencia[$i];
			$result_total = sql_query($sql);
			while($row_total = mysql_fetch_array($result_total)){
				$strDados.= "<set value='".$row_total['total']."'/> ";
			}
			mysql_free_result($result_total);
		}
		$strDados.= "</dataset> ";
	}
	mysql_free_result($result);
}

//Monta o outros
$strDados.= "<dataset seriesName='Outros' color='00009C' showValues='0'> ";
$sql ="";
$sql.="select ui.codusuariointerno, ui.nome, count(*) total ";
$sql.="  from usuariosinternos ui ";
$sql.="       inner join ocorrenciaslead ol on ol.codusuariointerno = ui.codusuariointerno ";
$sql.="       inner join leads l on ol.codlead = l.codlead ";
$sql.=" where ui.atendente = 1 ";
$sql.="   and ol.datacadastro between '$data' and '$data 23:59:59' ";
$sql.="  and ol.codtipoocorrencialead <> 77 ";

if($cod_polo != "")
	$sql.=" and l.cod_polo = $cod_polo ";

//COLOCA OS DEMAIS PARÂMETROS
if(!permissao('visualizar_todos_consultores', 'cs'))
	$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
if(!permissao('visualizar_todos_atendentes', 'cs'))
	$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";


$sql.=" group by ui.codusuariointerno, ui.nome having count(*) > 0 ";
$sql.=" order by total desc ";
$sql.=" limit 10";

$result = sql_query($sql);
while($row = mysql_fetch_array($result)){
	$sql ="select count(*) total ";
	$sql.="  from ocorrenciaslead ol ";
	$sql.="       inner join leads l on ol.codlead = l.codlead ";
	$sql.=" where ol.datacadastro between '$data' and '$data 23:59:59' ";
	$sql.="   and ol.codtipoocorrencialead <> 77 ";
	
	if($cod_polo != "")
		$sql.=" and l.cod_polo = $cod_polo ";
	
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	
	$sql.="   and ol.codusuariointerno = ".$row['codusuariointerno']." ";
	$sql.="   and ol.codtipoocorrencialead not in (";
	for($i = 0;$i<count($tipo_ocorrencia);$i++){
		$sql.=$tipo_ocorrencia[$i].",";
	}
	$sql.="0) ";
	$result_oper = sql_query($sql);
	while($row_oper = mysql_fetch_array($result_oper)){
		$strDados.= "<set value='".$row_oper['total']."'/> ";
	}
}
mysql_free_result($result);
$strDados.= "</dataset> ";

$sql="";
$sql.="select ui.nome, count(*) total ";
$sql.="  from usuariosinternos ui ";
$sql.="       inner join ocorrenciaslead ol on ol.codusuariointerno = ui.codusuariointerno ";
$sql.="       inner join leads l on ol.codlead = l.codlead ";
$sql.=" where ui.atendente = 1 ";
$sql.="  and ol.datacadastro between '$data' and '$data 23:59:59' ";
$sql.="  and ol.codtipoocorrencialead <> 77 ";
if($cod_polo != "")
	$sql.=" and l.cod_polo = $cod_polo ";

//COLOCA OS DEMAIS PARÂMETROS
if(!permissao('visualizar_todos_consultores', 'cs'))
	$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
if(!permissao('visualizar_todos_atendentes', 'cs'))
	$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";


$sql.=" group by ui.nome having count(*) > 0 ";
$sql.=" order by total desc ";
$sql.=" limit 1 ";
$result = sql_query($sql);
$row = mysql_fetch_array($result);
$total_linhas = $row['total'];
mysql_free_result($result);

//Testa para ver se não vai estourar a escala
if($total_linhas > 5)
	$total_linhas = 5;

if($total_linhas == 1)
	$total_linhas = 0;

if($total_linhas == 2)
	$total_linhas = 2;

if($total_linhas == 4)
	$total_linhas = 3;

if($total_linhas == 3)
	$total_linhas = 3;

$strGrafico .= "<graph xAxisName='Atendente' yAxisName='$total_ocorrencias Ocorrência(s)' caption='' subCaption='' decimalPrecision='0' numDivLines='$total_linhas' numberPrefix='' showValues='0'> ";
$strGrafico .= $strCategoria.$strDados;
$strGrafico .= "</graph> ";

echo $strGrafico;

include_once "../../libs/desconectar.php";

?>
