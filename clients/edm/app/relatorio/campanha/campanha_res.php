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

$cod_campanha = $_REQUEST['cod_campanha'];
$dt_participacaode = $_REQUEST['dt_participacaode'];
$dt_participacaoate = $_REQUEST['dt_participacaoate'];

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
		<font size="+2">Campanhas - Sintético</font>
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
	if(!empty($_REQUEST['dt_participacaode'])){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Participação em Campanha:</dt>
				<dd><?=date('d/m/Y', strtotime(dataYMD($_REQUEST['dt_participacaoate'])));?> até <?=date('d/m/Y', strtotime(dataYMD($_REQUEST['dt_participacaoate'])));?></dd>
		</td>
	</tr>
	<?	
	}
	?>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center" border="1" width="2000" class="sortable">	
	<thead>
		<tr>
			<td class="titulo" bgcolor="#8080FF">Nome</td>
			<td class="titulo" bgcolor="#8080FF">Início</td>
			<td class="titulo" bgcolor="#8080FF">Fim</td>
			<td class="titulo" bgcolor="#8080FF">Leads</td>
			<td class="titulo" bgcolor="#8080FF">Sucesso</td>
			<td class="titulo" bgcolor="#8080FF">Sem Sucesso</td>
			<td class="titulo" bgcolor="#8080FF">Não Trabalhados</td>
		</tr>
	</thead>
	<tbody>
	<?	
	
	//monta a string de critério
	$sql_ocorrencia ="";
	$sql_ocorrencia.="select cl.cod_campanha ";
	$sql_ocorrencia.="  from campanha_leads cl ";
	$sql_ocorrencia.="       inner join ocorrenciaslead oc on cl.codocorrencia_abertura = oc.codocorrencialead ";
	$sql_ocorrencia.=" where oc.datacadastro between '".DataYMD($dt_participacaode)." 00:00:00' and '".DataYMD($dt_participacaoate)." 23:59:59' ";
	
	$sql ="";
	$sql.="select cod_campanha, date_format(dt_inicio_campanha,'%d/%m/%Y') dt_inicio_campanha,  date_format(dt_fim_campanha,'%d/%m/%Y') dt_fim_campanha, nome_campanha ";
	$sql.="  from campanha ";
	$sql.=" where 1=1 ";

	$result = mysql_query($sql);
	
	$cont = 0;
	$total_quantidade = 0;
	$total_sucesso = 0;
	$total_semsucesso = 0;
	$total_fechamento = 0;
	
	while($row = mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td class='form' align='center'>".$row['nome_campanha']."</td>";
		echo "<td class='form' align='center'>".$row['dt_inicio_campanha']."</td>";
		echo "<td class='form' align='center'>&nbsp;".$row['dt_fim_campanha']."</td>";
		
		$sql ="";
		$sql.="select count(*) total ";
		$sql.="  from campanha_leads ";
		$sql.=" where cod_campanha = ".$row['cod_campanha'];
		
		$rs_quantidade = mysql_query($sql);
		$row_quantidade = mysql_fetch_array($rs_quantidade);
		$total = $row_quantidade['total'];
		$total_quantidade += $total;
		mysql_free_result($rs_quantidade);
		echo "<td class='form' align='center'>$total</td>";
		
		$sql ="";
		$sql.="select count(*) total ";
		$sql.="  from campanha_leads ";
		$sql.=" where cod_campanha = ".$row['cod_campanha'];
		$sql.="   and codocorrencia_sucesso is not null ";
		if(!empty($dt_participacaode) || !empty($dt_participacaoate)){
			$sql.=" and cod_campanha in ($sql_ocorrencia) ";
		}
			
		$rs_quantidade = mysql_query($sql);
		$row_quantidade = mysql_fetch_array($rs_quantidade);
		$total = $row_quantidade['total'];
		$total_sucesso += $total;
		mysql_free_result($rs_quantidade);
		echo "<td class='form' align='center'>$total</td>";

		$sql ="";
		$sql.="select count(*) total ";
		$sql.="  from campanha_leads ";
		$sql.=" where cod_campanha = ".$row['cod_campanha'];
		$sql.="   and codocorrencia_semsucesso is not null ";
		if(!empty($dt_participacaode) || !empty($dt_participacaoate)){
			$sql.=" and cod_campanha in ($sql_ocorrencia) ";
		}
			
		$rs_quantidade = mysql_query($sql);
		$row_quantidade = mysql_fetch_array($rs_quantidade);
		$total = $row_quantidade['total'];
		$total_semsucesso += $total;
		mysql_free_result($rs_quantidade);
		echo "<td class='form' align='center'>$total</td>";
		
		$sql ="";
		$sql.="select count(*) total ";
		$sql.="  from campanha_leads ";
		$sql.=" where cod_campanha = ".$row['cod_campanha'];
		$sql.="   and codocorrencia_sucesso is null ";
		$sql.="   and codocorrencia_semsucesso is null ";
		
		$rs_quantidade = mysql_query($sql);
		$row_quantidade = mysql_fetch_array($rs_quantidade);
		$total = $row_quantidade['total'];
		$total_fechamento += $total;
		mysql_free_result($rs_quantidade);
		echo "<td class='form' align='center'>$total</td>";	
		
		echo "</tr>";
		$cont++;
	}
	mysql_free_result($result);
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF" colspan="3">&nbsp;</td>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= $total_quantidade;?></td>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= $total_sucesso;?></td>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= $total_semsucesso;?></td>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= $total_fechamento;?></td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>