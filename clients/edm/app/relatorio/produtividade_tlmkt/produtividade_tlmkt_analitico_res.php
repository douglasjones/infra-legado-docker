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
$faixade = $_REQUEST['faixade'];
$faixaate = $_REQUEST['faixaate'];
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
<script>
	function abrir(vlr){
		NewWindow("produtividade_tlmkt_analitico_res.php?faixade=<?= $faixade;?>&faixaate=<?= $faixaate?>&codusuariointerno=" + vlr,700,400)
	}
</script>
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
			<td class="titulo" bgcolor="#8080FF">Atendente</td>
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
			$sql.=" SELECT DATEDIFF('$faixaate 23:59:59','$faixade') diferenca ";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$qtde_dias = $row['diferenca'];
			mysql_free_result($result);
			
			
			
			for($i = 0; $i<=$qtde_dias;$i++){
				echo "<td class='titulo' bgcolor='#8080FF'>";
				
				//pega os dias da semana.
				$sql ="";
				$sql.=" SELECT DAYOFWEEK(DATE_ADD('$faixade', INTERVAL $i DAY)) dia, DATE_FORMAT(DATE_ADD('$faixade', INTERVAL $i DAY),'%d/%m/%Y') diames ";
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
	
	$sql_where = "";
	if(!empty($cod_polo) && $cod_polo =! 100)
		$sql_where.=" and ui.cod_polo = $cod_polo ";
	
	if(!empty($codequipe))
		$sql_where.= " and ui.codusuariointerno in (select fk_usuario from tb_usuarioequipe where fk_equipe = $codequipe) ";	
	
	$sql ="";
	$sql.="select tol.descricao, tol.codtipoocorrencialead, ifnull(sum(tol.minutos),0) minutos ";
	$sql.="  from ocorrenciaslead oc ";
	$sql.="       inner join tipoocorrenciaslead tol on oc.codtipoocorrencialead = tol.codtipoocorrencialead ";
	$sql.="       inner join usuariosinternos ui on oc.codusuariointerno = ui.codusuariointerno ";
	$sql.=" where tol.minutos > 0 ";
	$sql.="   and ui.atendente = 1 ";
	$sql.="   and oc.codusuariointerno = $codusuariointerno ";
	$sql.="   and oc.datacadastro between '$faixade' and '$faixaate 23:59:59' ";
	$sql.=$sql_where;
	$sql.="group by tol.descricao, tol.codtipoocorrencialead having ifnull(sum(tol.minutos),0) > 0 ";
	
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
		echo "<td class='form' align='left'>".$row['descricao']."</td>";
		
		$total_linha = 0;
		$total_linha_qtde = 0;
		
		for($i = 0; $i < count($arrData); $i ++){

		
			$sql="";
			$sql.="select count(oc.codocorrencialead) qtde, ifnull(sum(tol.minutos), 0) minutos ";
			$sql.="  from ocorrenciaslead oc ";
			$sql.="       inner join tipoocorrenciaslead tol on oc.codtipoocorrencialead = tol.codtipoocorrencialead ";
			$sql.="       inner join usuariosinternos ui on oc.codusuariointerno = ui.codusuariointerno ";
			$sql.=" where tol.minutos > 0 ";
			$sql.="   and oc.codusuariointerno = $codusuariointerno ";
			$sql.="   and tol.codtipoocorrencialead = ".$row['codtipoocorrencialead'];
			$sql.="   and oc.datacadastro between '".DataYMD($arrData[$i])."' and '".DataYMD($arrData[$i])." 23:59:59' ";
			$sql.=$sql_where;
			$rs_minutos = mysql_query($sql);
			$row_minutos = mysql_fetch_array($rs_minutos);
			$total_minutos = $row_minutos['minutos'];
			$total_ocorrencias = $row_minutos['qtde'];
			mysql_free_result($rs_minutos);

			if($total_minutos > 0)
				echo "<td class='form' align='center'>$total_ocorrencias - ".retornarHora($total_minutos)."</td>";
			else
				echo "<td class='form' align='center'>&nbsp;</td>";


			$total_linha_qtde += $total_ocorrencias;
			$arrTotalQtde[$i] += $total_ocorrencias;
			
			$total_linha += $total_minutos;
			$arrTotal[$i] += $total_minutos;
		}
		echo "<td class='form' align='center'>$total_linha_qtde - ".retornarHora($total_linha)."</td>";
		echo "</tr>";
	}
	mysql_free_result($result);
	
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF">&nbsp;</td>
			<?
			$total = 0;
			for ($i = 0; $i < count($arrTotal); $i++){
				echo "<td align='center' class='titulo' bgcolor='#8080FF'>".$arrTotalQtde[$i]." - ".retornarHora($arrTotal[$i])."</td>";
				$total += $arrTotal[$i];
				$total_qtde += $arrTotalQtde[$i];
			}
			?>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= $total_qtde." - ".retornarHora($total)."";?></td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>