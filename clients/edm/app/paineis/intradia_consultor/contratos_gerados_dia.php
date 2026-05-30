<?php

include_once "../../libs/maininclude.php";

$cor = array("AFD8F8","F6BD0F","00FF00","FF3100");
$data = date('Y')."-".date('m')."-".date('d');

$strGrafico = "";
$strCategoria = "";
$strDados = "";
$total_linhas = 0;
$total_contratos = 0;

//Pega todos os operadores
$sql ="";
$sql.="select u1.nome, sum(ifnull(mp.valor,0)+ifnull(mp.calculado,0)) total ";
$sql.="  from leads l ";
$sql.="       inner join usuariosinternos u1 on l.codgerenteconta = u1.codusuariointerno ";
$sql.="       inner join propostas p on p.codlead = l.codlead ";
$sql.="       inner join data_proposta dp on (dp.codproposta = p.codproposta and dp.codlead = p.codlead and dp.versao = p.versao) ";
$sql.="       inner join modulosproposta mp on p.codproposta = mp.codproposta ";
$sql.=" where mp.id = 'qtdelinhas' ";
$sql.="   and (dp.nome_data = 'envio_contrato_operadora' and valor_data between '$data' and '$data 23:59:59') ";
$sql.="   and p.datacancelamento is null ";
$sql.=" group by u1.nome ";
$sql.=" having sum(ifnull(mp.valor,0)+ifnull(mp.calculado,0)) > 0 order by 2 desc ";

$strCategoria .= "<categories>\n  ";
$result = sql_query($sql);
while($row = mysql_fetch_array($result)){
	$strCategoria .= "<category name='".$row['nome']."'/>\n ";
}
mysql_free_result($result);
$strCategoria .= "</categories> ";

$strDados .= "<dataset seriesName='Contratos Fechados no Dia' color='8BBA00' showValues='0'>\n ";
$result = sql_query($sql);
while($row = mysql_fetch_array($result)){	
	$strDados .= "<set value='".$row['total']."'/>\n ";
	$total_contratos += $row['total'];
}
mysql_free_result($result);
$strDados .= "</dataset>\n ";

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

$strGrafico .= "<graph outCnvBaseFontSize='20' xAxisName='Consultor' yAxisName='$total_contratos Linha(s)' caption='' subCaption='' decimalPrecision='0' numDivLines='$total_linhas' numberPrefix='' showValues='0'>\n ";
$strGrafico .= $strCategoria.$strDados;
$strGrafico .= "</graph>\n ";

echo $strGrafico;o

?>