<?
include_once "../../libs/maininclude.php";

echo "<graph showNames='1' decimalPrecision='0'>\n";

$sql ="";
$sql.="select sc.descricao, sum(mp.valor) total ";
$sql.="  from statusclassificacaolead sc ";
$sql.="       inner join leads l on l.codstatusclassificacaolead = sc.codstatusclassificacaolead ";
$sql.="       inner join propostas p on p.codlead = l.codlead ";
$sql.="       inner join modulosproposta mp on p.codproposta = mp.codproposta ";
$sql.=" where sc.codstatusclassificacaolead not in (1,2,3,4,15) ";
$sql.="   and mp.id = 'qtdelinhas' ";
$sql.="   and p.datacancelamento is null ";
$sql.=" group by sc.descricao ";
$sql.=" order by sc.codstatusclassificacaolead desc ";

	$result = sql_query($sql);
	while($row = mysql_fetch_array($result)){
		echo "<set name='".$row['descricao']."' value='".$row['total']."'/>\n";
	}
	mysql_free_result($result);
echo "</graph>\n";
include_once "../../libs/desconectar.php";

?>