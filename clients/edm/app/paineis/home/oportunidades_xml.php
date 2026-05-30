
<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.equipes.php";

$cod_polo = $_REQUEST['cod_polo'];

$strGrafico ="";

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

$arrCor['01']="AFD8F8";
$arrCor['02']="F6BD0F";
$arrCor['03']="8BBA00";
$arrCor['04']="FF8E46";
$arrCor['05']="008E8E";
$arrCor['06']="D64646";
$arrCor['07']="8E468E";
$arrCor['08']="588526";
$arrCor['09']="B3AA00";
$arrCor['10']="008ED6";
$arrCor['11']="9D080D";
$arrCor['12']="A186BE";

$strGrafico.="<graph caption='' xAxisName='' yAxisName='Oportunidades' decimalPrecision='0' formatNumberScale='0'>	 ";
for($i = 12; $i >= 0; $i--){
	//pega as ocorrencias
	$sql ="";
	$sql.="select date_format(oc.datacadastro, '%m') mes, count(*) total ";
	$sql.="  from ocorrenciaslead oc ";
	$sql.="       inner join leads l on l.codlead = oc.codlead ";
	$sql.=" where (oc.datacadastro between DATE_FORMAT(DATE_SUB(SYSDATE(), INTERVAL $i MONTH),'%Y-%m-01 00:00:00') ";
	$sql.="                        and DATE_FORMAT(LAST_DAY(DATE_SUB(SYSDATE(), INTERVAL $i MONTH)),'%Y-%m-%d 23:59:59')) ";
	$sql.="  and oc.codtipoocorrencialead = 5000 ";
	
	if($cod_polo != "")
		$sql.=" and l.cod_polo = $cod_polo ";
	
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	
	$sql.=" group by date_format(datacadastro, '%m') ";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		$strGrafico.="<set name='".$arrMes[$row['mes']]."' value='".$row['total']."' color='".$arrCor[$row['mes']]."'/> ";
	}
	mysql_free_result($result);
}
$strGrafico.="</graph> ";
echo $strGrafico;
include_once "../../libs/desconectar.php";
?>
