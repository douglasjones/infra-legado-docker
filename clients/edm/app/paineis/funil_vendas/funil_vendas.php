<?
include_once "../../libs/maininclude.php";

echo "<graph showNames='1' decimalPrecision='0'>";

$sql ="";
$sql.="select s.descricao, count(l.codlead) total ";
$sql.="  from statusclassificacaolead s ";
$sql.="       inner join leads l on l.codstatusclassificacaolead  = s.codstatusclassificacaolead ";
$sql.=" where s.codstatusclassificacaolead not in (15, 1, 2, 3) ";
$sql.=" group by s.descricao ";
$sql.=" order by s.CodStatusClassificacaoLead desc ";
	$result = sql_query($sql);
	while($row = mysql_fetch_array($result)){
		echo "<set name='".$row['descricao']."' value='".$row['total']."'/>";
	}
	mysql_free_result($result);
echo "</graph>";
include_once "../../libs/desconectar.php";

?>