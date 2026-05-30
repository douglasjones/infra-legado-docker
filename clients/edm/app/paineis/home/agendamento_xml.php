<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.equipes.php";

$cod_polo = $_REQUEST['cod_polo'];

$arrMes = array();
$arrMes['01'] = "Jan";
$arrMes['02'] = "Fev";
$arrMes['03'] = "Mar";
$arrMes['04'] = "Abr";
$arrMes['05'] = "Mai";
$arrMes['06'] = "Jun";
$arrMes['07'] = "Jul";
$arrMes['08'] = "Ago";
$arrMes['09'] = "Set";
$arrMes['10'] = "Out";
$arrMes['11'] = "Nov";
$arrMes['12'] = "Dez";

$mes1 = "";

$strGrafico ="";
$strGrafico.="<graph xAxisName='' yAxisName='Visitas' caption='' subCaption='' decimalPrecision='0' rotateNames='1' numDivLines='3' numberPrefix='' showValues='0' formatNumberScale='0'>";

$strGrafico.="<categories>";

$sql ="";
$sql.="SELECT DATE_FORMAT(DATE_SUB(SYSDATE(), INTERVAL 2 MONTH),'%m') MES1,  ";
$sql.="	      DATE_FORMAT(DATE_SUB(SYSDATE(), INTERVAL 1 MONTH),'%m') MES2,  ";
$sql.="	      DATE_FORMAT(SYSDATE(),'%m') MES3, ";
$sql.="       DATE_FORMAT(DATE_SUB(SYSDATE(), INTERVAL 2 MONTH),'%Y-%m-%d') DATA1,  ";
$sql.="	      DATE_FORMAT(DATE_SUB(SYSDATE(), INTERVAL 1 MONTH),'%Y-%m-%d') DATA2,  ";
$sql.="	      DATE_FORMAT(SYSDATE(),'%Y-%m-%d') DATA3, ";
$sql.="	      DATE_FORMAT(DATE_SUB(SYSDATE(), INTERVAL 2 MONTH),'%Y-%m-01') DATAINI1, ";
$sql.="	      DATE_FORMAT(DATE_SUB(SYSDATE(), INTERVAL 1 MONTH),'%Y-%m-01') DATAINI2, ";
$sql.="	      DATE_FORMAT(SYSDATE(),'%Y-%m-01') DATAINI3, ";
$sql.="	      DATE_FORMAT(LAST_DAY(DATE_SUB(SYSDATE(), INTERVAL 2 MONTH)),'%Y-%m-%d') DATAFIM1, ";
$sql.="	      DATE_FORMAT(LAST_DAY(DATE_SUB(SYSDATE(), INTERVAL 1 MONTH)),'%Y-%m-%d') DATAFIM2, ";
$sql.="	      DATE_FORMAT(LAST_DAY(SYSDATE()),'%Y-%m-%d') DATAFIM3, ";
$sql.="       DATE_FORMAT(DATE_SUB(SYSDATE(), INTERVAL 2 MONTH),'%Y-%m') ANOMES1,  ";
$sql.="	      DATE_FORMAT(DATE_SUB(SYSDATE(), INTERVAL 1 MONTH),'%Y-%m') ANOMES2,  ";
$sql.="	      DATE_FORMAT(SYSDATE(),'%Y-%m') ANOMES3 ";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);

$data = array();
$data[1] = $row['DATA1'];
$data[2] = $row['DATA2'];
$data[3] = $row['DATA3'];

$dataini = array();
$dataini[1] = $row['DATAINI1'];
$dataini[2] = $row['DATAINI2'];
$dataini[3] = $row['DATAINI3'];

$datafim = array();
$datafim[1] = $row['DATAFIM1'];
$datafim[2] = $row['DATAFIM2'];
$datafim[3] = $row['DATAFIM3'];

$anomes = array();
$anomes[1] = $row['ANOMES1'];
$anomes[2] = $row['ANOMES2'];
$anomes[3] = $row['ANOMES3'];

$strGrafico.="<category name='".$arrMes[$row['MES1']]."'/>";
$strGrafico.="<category name='".$arrMes[$row['MES2']]."'/>";
$strGrafico.="<category name='".$arrMes[$row['MES3']]."'/>";
mysql_free_result($result);

$strGrafico.="</categories>";

$strGrafico.="<dataset seriesName='Produtiva' color='#66FFB3' showValues='0'>";

//Pesquisa todas as produtivas
for($i = 1; $i <= 3; $i++){
	$sql ="";
	$sql.="select count(*) total ";
	$sql.="  from agendaslead adl ";
	$sql.="       inner join leads l on adl.codlead = l.codlead ";
	$sql.=" where adl.datahorario between '".$dataini[$i]." 00:00:00' and '".$datafim[$i]." 23:59:59' ";
	if($cod_polo != "")
		$sql.=" and l.cod_polo = $cod_polo ";
		
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";

	$sql.="   and adl.codstatus = 1 ";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);	
	if($num > 0){
		$row = mysql_fetch_array($result);
		$strGrafico.="<set value='".$row['total']."'/>";
	}
	else{
		$strGrafico.="<set value='0'/>";
	}
}
$strGrafico.="</dataset>";

$strGrafico.="<dataset seriesName='Improdutiva' color='#FF6D6D' showValues='0'>";
for($i = 1; $i <= 3; $i++){
	$sql ="";
	$sql.="select count(*) total ";
	$sql.="  from agendaslead adl ";
	$sql.="       inner join leads l on adl.codlead = l.codlead ";
	$sql.=" where adl.datahorario between '".$dataini[$i]." 00:00:00' and '".$datafim[$i]." 23:59:59' ";
	if($cod_polo != "")
		$sql.=" and l.cod_polo = $cod_polo ";
	
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	
	$sql.="   and adl.codstatus = 2 ";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);	
	if($num > 0){
		$row = mysql_fetch_array($result);
		$strGrafico.="<set value='".$row['total']."'/>";
	}
	else{
		$strGrafico.="<set value='0'/>";
	}
}
$strGrafico.="</dataset>";

$strGrafico.="<dataset seriesName='Reagendada' color='#FFFF66' showValues='0'>";
for($i = 1; $i <= 3; $i++){
	$sql ="";
	$sql.="select count(*) total ";
	$sql.="  from agendaslead adl ";
	$sql.="       inner join leads l on adl.codlead = l.codlead ";
	$sql.=" where adl.datahorario between '".$dataini[$i]." 00:00:00' and '".$datafim[$i]." 23:59:59' ";
	if($cod_polo != "")
		$sql.=" and l.cod_polo = $cod_polo ";
		
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
	
	$sql.="   and adl.codstatus = 3 ";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);	
	if($num > 0){
		$row = mysql_fetch_array($result);
		$strGrafico.="<set value='".$row['total']."'/>";
	}
	else{
		$strGrafico.="<set value='0'/>";
	}
}
$strGrafico.="</dataset>";

$strGrafico.="<dataset seriesName='Cancelada' color='#3333FF' showValues='0'>";
for($i = 1; $i <= 3; $i++){
	$sql ="";
	$sql.="select count(*) total ";
	$sql.="  from agendaslead adl ";
	$sql.="       inner join leads l on adl.codlead = l.codlead ";
	$sql.=" where adl.datahorario between '".$dataini[$i]." 00:00:00' and '".$datafim[$i]." 23:59:59' ";
	if($cod_polo != "")
		$sql.=" and l.cod_polo = $cod_polo ";
	
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	$sql.="   and adl.codstatus = 4 ";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);	
	if($num > 0){
		$row = mysql_fetch_array($result);
		$strGrafico.="<set value='".$row['total']."'/>";
	}
	else{
		$strGrafico.="<set value='0'/>";
	}
}
$strGrafico.="</dataset>";

$strGrafico.="<dataset seriesName='Sem Classificação' color='#FFFFFF' showValues='0'>";
for($i = 1; $i <= 3; $i++){
	$sql ="";
	$sql.="select count(*) total ";
	$sql.="  from agendaslead adl ";
	$sql.="       inner join leads l on adl.codlead = l.codlead ";
	$sql.=" where adl.datahorario between '".$dataini[$i]." 00:00:00' and '".$datafim[$i]." 23:59:59' ";
	if($cod_polo != "")
		$sql.=" and l.cod_polo = $cod_polo ";
		
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	$sql.="   and adl.codstatus is null ";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);	
	if($num > 0){
		$row = mysql_fetch_array($result);
		$strGrafico.="<set value='".$row['total']."'/>";
	}
	else{
		$strGrafico.="<set value='0'/>";
	}
}
$strGrafico.="</dataset>";

$strGrafico.="</graph>";
echo $strGrafico;
include_once "../../libs/desconectar.php";
?>
