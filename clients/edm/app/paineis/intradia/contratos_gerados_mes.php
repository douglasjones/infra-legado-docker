<?php

include_once "../../libs/maininclude.php";

$cor = array("AFD8F8","F6BD0F","00FF00","FF3100");
$dataini = date('Y')."-".date('m')."-01";

//captura a data fim do contrato
$sql="SELECT LAST_DAY('$dataini') data";
$result = sql_query($sql);
while ($row = mysql_fetch_array($result)){
	$datafim = $row['data'];
}
mysql_free_result($result);

$strGrafico = "";
$strCategoria = "";
$strDados = "";
$total_linhas = 0;
$total_contratos = 0;

$strCategoria .= "<categories>  ";

//Pega todos os operadores
$sql ="";
$sql.="select u1.nome, count(*) total  ";
$sql.="  from leads l  ";
$sql.="       inner join usuariosinternos u1 on l.codatendente = u1.codusuariointerno  ";
$sql.="       inner join propostas p on p.codlead = l.codlead  ";
$sql.="       inner join data_proposta dp on (dp.codproposta = p.codproposta and dp.codlead = p.codlead and dp.versao = p.versao) ";
$sql.=" where (dp.nome_data = 'envio_contrato_operadora' and valor_data between '$dataini' and '$datafim 23:59:59') ";
$sql.="   and u1.atendente = 1  ";
$sql.="   and p.datacancelamento is null  ";
$sql.=" group by u1.nome having count(*) > 0 order by 2 desc  ";

$result = sql_query($sql);
while($row = mysql_fetch_array($result)){
	$strCategoria .= "<category name='".$row['nome']."'/> ";
	$total_contratos += $row['total'];
}
mysql_free_result($result);
$strCategoria .= "</categories> ";

$strDados .= "<dataset seriesName='Contratos Fechados no Mês' color='F6BD0F' showValues='0'> ";

$sql ="";
$sql.="	select u1.nome, count(*) total ";
$sql.="	  from leads l ";
$sql.="	       inner join usuariosinternos u1 on l.codatendente = u1.codusuariointerno ";
$sql.="	       inner join propostas p on p.codlead = l.codlead ";
$sql.="        inner join data_proposta dp on (dp.codproposta = p.codproposta and dp.codlead = p.codlead and dp.versao = p.versao) ";
$sql.=" where (dp.nome_data = 'envio_contrato_operadora' and valor_data between '$dataini' and '$datafim 23:59:59') ";
$sql.="     and u1.atendente = 1 ";
$sql.="     and p.datacancelamento is null ";
$sql.="   group by u1.nome having count(*) > 0 order by 2 desc ";

$result = sql_query($sql);
while($row = mysql_fetch_array($result)){	
	$strDados .= "<set value='".$row['total']."'/> ";
	if($total_linhas < $row_total['total'])
		$total_linhas = $row_total['total'];
}
mysql_free_result($result);

$strDados .= "</dataset> ";

$sql ="";
$sql.="	select u1.nome, count(*) total ";
$sql.="	  from leads l ";
$sql.="	       inner join usuariosinternos u1 on l.codatendente = u1.codusuariointerno ";
$sql.="	       inner join propostas p on p.codlead = l.codlead ";
$sql.="        inner join data_proposta dp on (dp.codproposta = p.codproposta and dp.codlead = p.codlead and dp.versao = p.versao) ";
$sql.=" where (dp.nome_data = 'envio_contrato_operadora' and valor_data between '$dataini' and '$datafim 23:59:59') ";
$sql.="     and u1.atendente = 1 ";
$sql.="     and p.datacancelamento is null ";
$sql.="   group by u1.nome having count(*) > 0 order by 2 desc limit 1 ";
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


$strGrafico .= "<graph outCnvBaseFontSize='20' xAxisName='Operador' yAxisName='$total_contratos Contrato(s)' caption='' subCaption='' decimalPrecision='0' numDivLines='$total_linhas' numberPrefix='' showValues='0'> ";
$strGrafico .= $strCategoria.$strDados;
$strGrafico .= "</graph> ";

echo $strGrafico;o

?>