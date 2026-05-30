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
include_once( "../../libs/cla.equipes.php" ) ;

//$cod_polo = $_REQUEST['cod_polo'];
$codequipe = $_REQUEST['codequipe'];
$codatendente = $_REQUEST['codatendente'];
$faixade = DataYMD($_REQUEST['faixade']);
$faixaate = DataYMD($_REQUEST['faixaate']);
$statususuario = $_REQUEST['statususuario'];

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
		var url = "produtividade_tlmkt_analitico_res.php?codequipe=<?= $codequipe?>&cod_polo=<?= $cod_polo;?>&faixade=<?= $faixade;?>&faixaate=<?= $faixaate?>&codusuariointerno=" + vlr;
		window.open( url , "" , "toolbar=no,status=no,menubar=no,scrollbars=yes,width=" + 700 + ",height=" + 500 + ",resizable=yes,maximized=yes" ) ;
	}
</script>
<?
}
?>
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
		<font size="+2">Relatório Produtividade TLMKT</font>
	</td>
</tr>
</table>
<br>
<br>
<table border="0" cellpadding="0" cellspacing="0" class='form'>
	<tr>
		<td class="parametros">
			Parâmetros 
		</td>
	</tr>
	<tr>
		<td class="parametros">
				Relatório gerado em 
				<?
				//Pega a data de geração do relatório
				$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i') datageracao ";
				$rs_geracao = mysql_query($sql);
				$row_geracao = mysql_fetch_array($rs_geracao);
				echo $row_geracao['datageracao'];
				mysql_free_result($rs_geracao);
				?>
		</td>
	</tr>
	<?	
	if(!empty($faixade)){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas:</dt>
				<dd><?=$_REQUEST['faixade'];?> até <?=$_REQUEST['faixaate'];?></dd>
		</td>
	</tr>
	<?	
	}
	?>
	<?	
	if(!empty($statususuario)){
	?>
	<tr>
		<td class="texto_label">
			<dt>Status Usuário:</dt>
			<?
			if($statususuario==1){
			?>
				<dd><?print "&nbsp;Ativo";?></dd>
			<?
			}
			if($statususuario==2){?>
			<dd><?print "&nbsp;Desativado";?></dd>
			<?
			}
			?>
		</td>
	</tr>
	<?	
	}
	?>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center" border="1" width="100%" class="sortable">	
	<thead>
		<tr>
			<td class="titulo" bgcolor="#8080FF">Atendente</td>
			<?
			$arrDiaSemana = array();
			$arrData = array();
			$arrTotalQtde = array();
			$arrTotal = array();
			
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
			<td class="titulo" bgcolor="#8080FF">Total OC</td>
			<td class="titulo" bgcolor="#8080FF">Média por Operador</td>
		</tr>
	</thead>
	<tbody>
	<?
	
	$sql_where = "";
	if(!empty($_REQUEST['cod_polo']))
		$sql_where.=" and ui.cod_polo =".$_REQUEST['cod_polo']." ";
	
	if(!empty($codequipe))
		$sql_where.= " and ui.codusuariointerno in (select fk_usuario from tb_usuarioequipe where fk_equipe = $codequipe) ";
	
	if(!empty($codatendente))
		$sql_where.="  and ui.codusuariointerno = $codatendente ";
	
	//Filtra considerando o critério de equipe.
	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$sql_where.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	//FILTRA OS USUARIOS SE ESTAO ATIVOS OU NAO
	if($statususuario==1)
		$sql_where.= " and ui.desativado <> 1 ";	
	if($statususuario==2)
		$sql_where.= " and ui.desativado = 1 ";	
	
	$sql ="";
	$sql.="select ui.nome,ui.desativado, ui.codusuariointerno, sum(tol.minutos) minutos ";
	$sql.="  from ocorrenciaslead oc ";
	$sql.="       inner join tipoocorrenciaslead tol on oc.codtipoocorrencialead = tol.codtipoocorrencialead ";
	$sql.="       inner join usuariosinternos ui on oc.codusuariointerno = ui.codusuariointerno ";
	$sql.=" where tol.minutos > 0 ";
	$sql.="   and ui.atendente = 1 ";
	$sql.="   and oc.datacadastro between '$faixade' and '$faixaate 23:59:59'  ";
	$sql.= $sql_where;
	$sql.=" group by ui.nome, ui.codusuariointerno ";
	
	$result = mysql_query($sql);
	$total_operadores = 0;
	
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
		if($excel != "S"){
			if($row['desativado'] == 1){
				echo "<td class='form' align='center'><a href='#' onclick=abrir('".$row['codusuariointerno']."')><font color='#990000'>".$row['nome']."</font></a></td>";
			}else{
				echo "<td class='form' align='center'><a href='#' onclick=abrir('".$row['codusuariointerno']."')><font color='#009900'>".$row['nome']."</font></a></td>";
			}
		}else{
			if($row['desativado'] == 1){
				echo "<td class='form' align='center'><font color='#990000'>".$row['nome']."</font></td>";
			}else{
				echo "<td class='form' align='center'><font color='#009900'>".$row['nome']."</font></td>";
			}
		}
		
		$total_linha = 0;
		$total_linha_qtde = 0;
		for($i = 0; $i < count($arrData); $i ++){
		
			$sql="";
			$sql.="select count(oc.codocorrencialead) qtde, ifnull(sum(tol.minutos), 0) minutos ";
			$sql.="  from ocorrenciaslead oc ";
			$sql.="       inner join tipoocorrenciaslead tol on oc.codtipoocorrencialead = tol.codtipoocorrencialead ";
			$sql.="       inner join usuariosinternos ui on oc.codusuariointerno = ui.codusuariointerno ";
			$sql.=" where tol.minutos > 0 ";
			$sql.="   and oc.codusuariointerno = ".$row['codusuariointerno'];
			$sql.="   and oc.datacadastro between '".DataYMD($arrData[$i])."' and '".DataYMD($arrData[$i])." 23:59:59' ";
			
			$rs_minutos = mysql_query($sql);
			$row_minutos = mysql_fetch_array($rs_minutos);
			$total_minutos = $row_minutos['minutos'];
			$total_ocorrencias = $row_minutos['qtde'];
			$qtde_linhaoc  += $row_minutos['qtde'];
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
		
		echo "<td class='form' align='center'>".$qtde_linhaoc."</td>";
		$total_geral_oc += $qtde_linhaoc;
		$qtde_linhaoc = 0;
		echo "<td class='form' align='center'>".number_format($total_linha_qtde/$i,2)." - ".retornarHora(number_format($total_linha/$i,0))."</td>";

		echo "</tr>";
		$total_oc= $total_oc +  $total_linha_qtde;
		$arrTotaloc[$i] += $total_oc;
		$total_operadores++;
		$total_oc_geral =  $total_oc_geral + $total_oc;
		
	}
	mysql_free_result($result);
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF">OC - Média OC - Média Tempo</td>
			<?
			$total = 0;
			for ($i = 0; $i < count($arrTotal); $i++){
			if ($arrTotalQtde[$i] > 0 ){
				$valoroc = $arrTotalQtde[$i];
				$totaloc = $totaloc + $valoroc;
			}else{
				$valoroc = 0;
			}
				if($total_operadores == 0)
					$total_operadores = 1;
				echo "<td align='center' class='titulo' bgcolor='#8080FF'> &nbsp;".$valoroc."&nbsp;&nbsp;&nbsp; ".number_format($arrTotalQtde[$i]/$total_operadores,2)."-".retornarHora(number_format($arrTotal[$i]/$total_operadores,0))."</td>";
				$total += $arrTotal[$i];
				$total_qtde += $arrTotalQtde[$i];
			$totalgeralusuariooc =0;
			}
			
			?>
			<td align="center" class="titulo" bgcolor="#8080FF">&nbsp;<?=$total_geral_oc?></td>
			<td align="center" class="titulo" bgcolor="#8080FF">&nbsp;<?= number_format($total_qtde/$total_operadores,2)." - ".retornarHora(number_format($total/$total_operadores,0))."";?></td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
