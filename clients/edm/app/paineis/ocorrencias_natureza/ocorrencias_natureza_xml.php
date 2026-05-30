<?

include_once "../../libs/maininclude.php";

//Pega a data do dia.
$sql = "select date_format(sysdate(),'%Y-%m-%d') hoje ";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$hoje = $row['hoje'];
mysql_free_result($result);

$arrCodUsuarioInterno = array();
$indice = 0;

$arrTipoPessoa = array();
$arrTipoPessoa[0] = "PF";
$arrTipoPessoa[1] = "PJ";
$arrTipoPessoa[2] = "Vazio";

$arrCores = array();
$arrCores[0] = "AFD8F8";
$arrCores[1] = "F6BD0F";
$arrCores[2] = "8BBA00";

echo "<graph outCnvBaseFontSize='20' decimalPrecision='0' numberPrefix='' showValues='0'>\n";
echo "<categories>\n";

//Pesquisa o nome dos usuarios
$sql ="";
$sql.="select ui.nome, ui.codusuariointerno, count(0) total ";
$sql.="  from ocorrenciaslead oc  ";
$sql.="        inner join leads l on oc.codlead = l.codlead  ";
$sql.="        inner join usuariosinternos ui on oc.codusuariointerno = ui.codusuariointerno ";
$sql.=" where oc.datacadastro between '".$hoje." 00:00:00' and '".$hoje." 23:59:59' ";
$sql.="   and ui.Atendente = 1 ";
$sql.=" group by ui.nome, ui.codusuariointerno ";
$sql.=" order by 3 ";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	echo "<category name='".$row['nome']."' />\n";
	$arrCodUsuarioInterno[$indice] = $row['codusuariointerno'] ;
	$indice ++;
}
mysql_free_result($result);
echo "</categories>\n";

//Pesquisa as ocorrencias pelo tipo.
for($i = 0; $i < count($arrTipoPessoa); $i++){
	
	echo "<dataset seriesName='".$arrTipoPessoa[$i]."' color='".$arrCores[$i]."' showValues='0'>\n";
	for($j = 0; $j < count($arrCodUsuarioInterno); $j++){
		
		$sql ="";
		$sql.="select count(0) total ";
		$sql.="  from ocorrenciaslead oc  ";
		$sql.="       inner join leads l on oc.codlead = l.codlead  ";
		
		if($arrTipoPessoa[$i] == "Vazio"){
			$sql.=" where (l.tipo_pessoa = '' or l.tipo_pessoa is null) ";
		}
		else{
			$sql.=" where l.tipo_pessoa = '".$arrTipoPessoa[$i]."' ";
		}
			
		$sql.="   and oc.datacadastro between '".$hoje." 00:00:00' and '".$hoje." 23:59:59' ";
		$sql.="   and oc.codusuariointerno = ".$arrCodUsuarioInterno[$j];
		
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		echo "<set value='".$row['total']."' />\n";
		mysql_free_result($result);	
	}
	echo "</dataset>\n";
}

echo "</graph>\n";

include_once "../../libs/desconectar.php";

?>
