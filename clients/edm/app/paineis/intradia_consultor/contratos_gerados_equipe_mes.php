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

//Pega todos os operadores
$sql ="";
$sql.="select equipe.vc_nome nome, sum(mp.calculado) total ";
$sql.="  from leads l ";
$sql.="       inner join usuariosinternos u1 on l.codgerenteconta = u1.codusuariointerno ";
$sql.="       inner join (select te.vc_nome, tu.fk_usuario codusuariointerno ";
$sql.="                     from tb_equipesvendas te ";
$sql.="                          inner join tb_usuarioequipe tu on te.tk_equipe = tu.fk_equipe) equipe on u1.codusuariointerno = equipe.codusuariointerno ";
$sql.="       inner join propostas p on p.codlead = l.codlead ";
$sql.="       inner join data_proposta dp on (dp.codproposta = p.codproposta and dp.codlead = p.codlead and dp.versao = p.versao) ";
$sql.="       inner join modulosproposta mp on p.codproposta = mp.codproposta ";
$sql.=" where mp.id = 'qtdelinhas' ";
$sql.="   and p.datacancelamento is null ";
$sql.="   and (dp.nome_data = 'envio_contrato_operadora' and valor_data between '$dataini' and '$datafim 23:59:59') ";
$sql.=" group by equipe.vc_nome ";
$sql.=" having sum(mp.calculado) > 0 order by 2 desc ";

//monta o segmento de categorias
$strCategoria .= "<categories>  ";
$result = sql_query($sql);
while($row = mysql_fetch_array($result)){
	$strCategoria .= "<category name='".$row['nome']."'/> ";
}
mysql_free_result($result);
$strCategoria .= "</categories> ";

//monta o segmento de dados.
$strDados .= "<dataset seriesName='Contratos Fechados por Equipe no Mês' color='00FF00' showValues='0'> ";
$result = sql_query($sql);
while($row = mysql_fetch_array($result)){	
	$strDados .= "<set value='".$row['total']."'/> ";
	$total_contratos += $row['total'];
	if($total_linhas < $row_total['total'])
		$total_linhas = $row_total['total'];
}
mysql_free_result($result);
$strDados .= "</dataset> ";

//monta os totalizadores
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


$strGrafico .= "<graph outCnvBaseFontSize='20' xAxisName='Equipe' yAxisName='$total_contratos Linha(s)' caption='' subCaption='' decimalPrecision='0' numDivLines='$total_linhas' numberPrefix='' showValues='0'> ";
$strGrafico .= $strCategoria.$strDados;
$strGrafico .= "</graph> ";

echo $strGrafico;o

?>