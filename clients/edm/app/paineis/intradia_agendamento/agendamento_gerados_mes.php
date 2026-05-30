<?php

include_once "../../libs/maininclude.php";

$cor = array("AFD8F8","F6BD0F","00FF00","FF3100");
$dataini = date('Y')."-".date('m')."-01";

$total_agendamentos=0;

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
$valor_maximo = 0;


$strCategoria .= "<categories>  ";

//Pega todos os operadores
$sql ="";
$sql.="select ui.nome, count(*) total ";
$sql.="  from agendaslead al ";
$sql.="       inner join usuariosinternos ui on al.codusuariointerno = ui.codusuariointerno ";
$sql.=" where ui.atendente = 1 ";
$sql.="   and al.datacadastro between '$dataini' and '$datafim 23:59:59' ";
$sql.=" group by ui.nome having count(*) > 0 order by 2 desc ";

$result = sql_query($sql);
while($row = mysql_fetch_array($result)){
	$strCategoria .= "<category name='".$row['nome']."'/> ";
}
$strCategoria .= "</categories> ";

$sql ="";
$sql.="select ui.nome, count(*) total ";
$sql.="  from agendaslead al ";
$sql.="       inner join usuariosinternos ui on al.codusuariointerno = ui.codusuariointerno ";
$sql.=" where ui.atendente = 1 ";
$sql.="   and al.datacadastro between '$dataini' and '$datafim 23:59:59' ";
$sql.=" group by ui.nome having count(*) > 0 order by 2 desc ";
$result = sql_query($sql);
$strDados .= "<dataset seriesName='Agendamentos Realizados' color='F6BD0F' showValues='0'> ";
while($row = mysql_fetch_array($result)){	
	$strDados .= "<set value='".$row['total']."'/> ";
	$total_agendamentos += $row['total'];
}
mysql_free_result($result);

$strDados .= "</dataset> ";

$sql ="";
$sql.="select ui.nome, count(*) total ";
$sql.="  from agendaslead al ";
$sql.="       inner join usuariosinternos ui on al.codusuariointerno = ui.codusuariointerno ";
$sql.=" where ui.atendente = 1 ";
$sql.="   and al.datacadastro between '$dataini' and '$datafim 23:59:59' ";
$sql.=" group by ui.nome ";
$sql.=" having count(*) > 0";
$sql.=" order by 2 desc limit 1 ";
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

$strGrafico .= "<graph outCnvBaseFontSize='20' xAxisName='Operador' yAxisName='$total_agendamentos Agendamento(s)' caption='' subCaption='' decimalPrecision='0' numDivLines='$total_linhas' numberPrefix='' showValues='0'> ";
$strGrafico .= $strCategoria.$strDados;
$strGrafico .= "</graph> ";

echo $strGrafico;o

?>