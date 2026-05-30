<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.equipes.php";

$cod_polo = $_REQUEST['cod_polo'];

echo "<graph showNames='1' decimalPrecision='0'>";

$sql ="";
$sql.="select s.descricao, count(l.codlead) total ";
$sql.="  from statusclassificacaolead s ";
$sql.="       inner join leads l on l.codstatusclassificacaolead  = s.codstatusclassificacaolead ";
$sql.=" where s.codstatusclassificacaolead in (5,6,10,12,15) ";

if($cod_polo != "")
	$sql.=" and l.cod_polo = $cod_polo ";
	
//COLOCA OS DEMAIS PARÂMETROS
if(!permissao('visualizar_todos_consultores', 'cs'))
	$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
if(!permissao('visualizar_todos_atendentes', 'cs'))
	$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	

$sql.=" group by s.descricao ";
$sql.=" order by s.CodStatusClassificacaoLead  ";
$result = sql_query($sql);
while($row = mysql_fetch_array($result)){
	echo "<set name='".$row['descricao']."' value='".$row['total']."'/>";
}
mysql_free_result($result);
echo "</graph>";
include_once "../../libs/desconectar.php";

?>