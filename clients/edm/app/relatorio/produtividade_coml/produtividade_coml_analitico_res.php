<?

$excel = $_REQUEST['excel'];

if($excel == "S"){
	$arquivo = 'planilha.xls';
	
	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}

include_once( "../../libs/maininclude.php" ) ;
include_once( "../../libs/datas.php" ) ;

$cod_polo = $_REQUEST['cod_polo'];
$codequipe = $_REQUEST['codequipe'];
$dataini = DataYMD($_REQUEST['dataini']);
$datafim = DataYMD($_REQUEST['datafim']);
$codusuariointerno = $_REQUEST['codusuariointerno'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
<?
if($excel != "S"){
?>
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<?	include_once "../../libs/head.php";?>
<script src="../../extras/tabela.js"></script>
<?
}

$sql ="";
$sql.="select nome from usuariosinternos where codusuariointerno = $codusuariointerno ";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$nome =  $row['nome'];
mysql_free_result($result);

?>

<title><?= "Relatório Produtividade - ".$nome;?></title>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
if($excel != "S"){
?>
<a name="link_excel" id="link_excel" href="<?= $_SERVER['REQUEST_URI'];?>&excel=S" title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
<br>

<?
}
?>
<br>
<table cellspacing="0" cellpadding="0" align="left" border="0">	
<tr>
	<td class="form" align="center">
		<font size="+2">
		<?
		echo $nome;
		?>
		</font>
	</td>
</tr>
</table>
<br><br>
<br>

<table cellspacing="0" cellpadding="0" align="center" border="1" width="100%" class="sortable">	
	<thead>
		<tr>
			<td class="titulo" bgcolor="#8080FF">Atividade</td>
			<?
			
			$arrDiaSemana = array();
			$arrData = array();
			
			$arrDiaSemana[1] = "Dom";
			$arrDiaSemana[2] = "Seg";
			$arrDiaSemana[3] = "Ter";
			$arrDiaSemana[4] = "Qua";
			$arrDiaSemana[5] = "Qui";
			$arrDiaSemana[6] = "Sex";
			$arrDiaSemana[7] = "Sáb";

			//carrega todos os dias do intervalo das datas.
			$sql ="";
			$sql.=" SELECT DATEDIFF('$datafim 23:59:59','$dataini') diferenca ";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$qtde_dias = $row['diferenca'];
			mysql_free_result($result);
			
			for($i = 0; $i<=$qtde_dias;$i++){
				echo "<td class='titulo' bgcolor='#8080FF'>";
				
				//pega os dias da semana.
				$sql ="";
				$sql.=" SELECT DAYOFWEEK(DATE_ADD('$dataini', INTERVAL $i DAY)) dia, DATE_FORMAT(DATE_ADD('$dataini', INTERVAL $i DAY),'%d/%m/%Y') diames ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				$arrDia = explode("/", $row['diames']);
				
				$dia = $arrDia[0];
				$arrData[$i] = $row['diames'];
				mysql_free_result($result);
				
				echo "$dia";
				echo "</td>";
				
				//zera os totais;
				$arrTotal[$i] = 0;
				$arrTotalQtde[$i] = 0;
			
			}
			?>
			<td class="titulo" bgcolor="#8080FF">Total</td>
		</tr>
	</thead>
	<tbody>
	<?	
	
	//monta os agendamentos	
	$sql ="";
	$sql.="select ta.descricao, ta.codtipo, count(*) qtde, ifnull(sum(ta.minutos),0) minutos ";
	$sql.="  from agendaslead al ";
	$sql.="       inner join tipoagendamento ta on al.codtipo = ta.codtipo ";
	$sql.="       inner join agendagerenteconta agc on al.codagendalead = agc.codagendalead ";
	$sql.=" group by ta.descricao, ta.codtipo ";
	
	$result = mysql_query($sql);
	
	$indice = 0;	
	
	while($row = mysql_fetch_array($result)){
		
		if($indice == 0){
			$cor = "white";
			$indice = 1;
		}
		else{
			$cor = "#dbdbdb";
			$indice = 0;
		}
		
		echo "<tr bgcolor='".$cor."'>";
		echo "<td class='form' align='left'>Agenda de Visitas - ".$row['descricao']."</td>";
		
		$total_linha = 0;
		$total_qtde_linha = 0;
		
		for($i = 0; $i < count($arrData); $i ++){
		
			//pesquisa separado por dia
			$sql ="";
			$sql.="select ta.descricao, ta.codtipo, count(*) qtde, ifnull(sum(ta.minutos),0) minutos ";
			$sql.="  from agendaslead al ";
			$sql.="       inner join tipoagendamento ta on al.codtipo = ta.codtipo ";
			$sql.="       inner join agendagerenteconta agc on al.codagendalead = agc.codagendalead ";
			$sql.=" where agc.codgerenteconta = $codusuariointerno ";
			$sql.="   and ta.codtipo = ".$row['codtipo'];
			$sql.="   and al.datahorario between '".DataYMD($arrData[$i])."' and '".DataYMD($arrData[$i])." 23:59:59' ";
			$sql.="   and (al.codstatus is null or al.codstatus in (1,2)) ";
			$sql.=" group by ta.descricao, ta.codtipo ";
			
			$rs_minutos = mysql_query($sql);
			$row_minutos = mysql_fetch_array($rs_minutos);
			$total_minutos = $row_minutos['minutos'];
			$total_agendas = $row_minutos['qtde'];
			$total_linha += $row_minutos['minutos'];
			$total_qtde_linha += $row_minutos['qtde'];
			mysql_free_result($rs_minutos);
			
			$arrTotal[$i]+= $total_minutos;
			
			if($total_minutos > 0){
				echo "<td class='form' align='center'>$total_agendas - ".retornarHora($total_minutos)."</td>";
			}
			else{
				echo "<td class='form' align='center'>&nbsp;</td>";
			}
			
		}
		echo "<td class='form' align='center'>$total_qtde_linha - ".retornarHora($total_linha)."</td>";
		echo "</tr>";
	}
	mysql_free_result($result);
	
	$total_qtde_linha = 0;
	$total_minutos_linha = 0;
	
	//monta as ocorrencias
	$sql ="";
	$sql.="select count(*) total ";
	$sql.="  from ocorrenciaslead ol ";
	$sql.=" where ol.codusuariointerno = $codusuariointerno ";
	$sql.="   and ol.datacadastro between '$dataini 00:00:00' and '$datafim 23:59:59' ";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row['total'] > 0){

		echo "<tr bgcolor='".$cor."'>";
		echo "<td class='form' align='left'>Ocorrências</td>";
	
		for($i = 0; $i < count($arrData); $i ++){
			
			$sql ="";
			$sql.="select count(*) total ";
			$sql.="  from ocorrenciaslead ol ";
			$sql.=" where ol.codusuariointerno = $codusuariointerno ";
			$sql.="   and ol.datacadastro between '".DataYMD($arrData[$i])." 00:00:00' and '".DataYMD($arrData[$i])." 23:59:59' ";
			
			$rs_ocorrencias = mysql_query($sql);
			$row_ocorrencias = mysql_fetch_array($rs_ocorrencias);
			$total_qtde = $row_ocorrencias['total'];
			$total_minutos = $total_qtde * 5;
			$total_minutos_linha += $total_minutos;
			$total_qtde_linha += $total_qtde;
			
			$arrTotal[$i]+= $total_minutos;
			
			if($total_minutos > 0){
				echo "<td class='form' align='center'>$total_qtde - ".retornarHora($total_minutos)."</td>";
			}
			else{
				echo "<td class='form' align='center'>&nbsp;</td>";
			}
			
			mysql_free_result($rs_ocorrencias);
			
		}
		echo "<td class='form' align='center'>$total_qtde_linha - ".retornarHora($total_minutos_linha)."</td>";
		echo "</tr>";
	}
	mysql_free_result($result);	
	
	$total_qtde_linha = 0;
	$total_minutos_linha = 0;
	
	//monta as prospeccoes
	$sql ="";
	$sql.="select l.codlead ";
	$sql.="  from leads l ";
	$sql.=" 	  inner join contatoslead cl on cl.codlead = l.codlead ";
	$sql.=" where l.usuariocadastro = $codusuariointerno ";
	$sql.="   and l.datacadastro between '$dataini 00:00:00' and '$datafim 23:59:59' ";
	$sql.=" group by l.codlead ";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);
	mysql_free_result($result);
	
	if($num > 0){
		
		echo "<tr bgcolor='".$cor."'>";
		echo "<td class='form' align='left'>Prospecções</td>";
		
		
		for($i = 0; $i < count($arrData); $i ++){
			
			$sql ="";
			$sql.="select l.codlead ";
			$sql.="  from leads l ";
			$sql.=" 	  inner join contatoslead cl on cl.codlead = l.codlead ";
			$sql.=" where l.usuariocadastro = $codusuariointerno ";
			$sql.="   and l.datacadastro between '".DataYMD($arrData[$i])."' and '".DataYMD($arrData[$i])." 23:59:59' ";
			$sql.=" group by l.codlead ";
			$rs_prospeccoes = mysql_query($sql);
			$num = mysql_num_rows($rs_prospeccoes);
			$total_minutos = ($num * 15);
			$total_minutos_linha += $total_minutos;
			$total_qtde_linha += $num;
			
			$arrTotal[$i]+= $total_minutos;
			
			if($total_minutos > 0)
				echo "<td class='form' align='center'>$num - ".retornarHora($total_minutos)."</td>";
			else
				echo "<td class='form' align='center'>&nbsp;</td>";
			
			mysql_free_result($rs_prospeccoes);
		
		}
		echo "<td class='form' align='center'>$total_qtde_linha - ".retornarHora($total_minutos_linha)."</td>";
		echo "</tr>";
	}
	
	
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF">&nbsp;</td>
			<?
			$total = 0;
			for ($i = 0; $i < count($arrTotal); $i++){
				echo "<td align='center' class='titulo' bgcolor='#8080FF'>".retornarHora($arrTotal[$i])."</td>";
				$total += $arrTotal[$i];
				$total_qtde += $arrTotalQtde[$i];
			}
			?>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= retornarHora($total)."";?></td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
