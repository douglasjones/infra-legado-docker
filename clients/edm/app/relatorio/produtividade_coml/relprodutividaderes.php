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

$cod_polo = $_REQUEST['cod_polo'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$codequipe = $_REQUEST['codequipe'];
$codatendente = $_REQUEST['codatendente'];
$mailing = $_REQUEST['mailing'];
$codmotivo = $_REQUEST['codmotivo'];
$dataini = $_REQUEST['dataini'];
$datafim = $_REQUEST['datafim'];

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
		var url = "produtividade_coml_analitico_res.php?codequipe=<?= $codequipe?>&cod_polo=<?= $cod_polo;?>&dataini=<?= $dataini;?>&datafim=<?= $datafim?>&codusuariointerno=" + vlr;
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
		<font size="+2">Produtividade Comercial</font>
	</td>
</tr>
</table>
<br>
<br>

<table border="0" cellpadding="0" cellspacing="0" class='form'>
	<tr>
		<td class="parametros">
			Parâmetros 
			<br><br>
			
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($codequipe)){
			$sql = "Select Vc_Nome from tb_equipesvendas where Tk_Equipe = $codequipe ";
			$q = mysql_query($sql);
			$equipe = mysql_fetch_array($q);
			echo "Equipe: ".$equipe['Vc_Nome'];
		}
		?>
		</td>
	</tr>	
	<?
	if(!empty($codgerenteconta)){
		$sql = "select nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		?>
		<tr>
			<td>Consultor: <?= $row['nome'];?></td>
		</tr>
		<?
		mysql_free_result($result);
	}
	if(!empty($dataini)){
		?>
		<tr>
			<td>Período (Início): <?= $dataini;?></td>
		</tr>
		<?
	}
	if(!empty($datafim)){
		?>
		<tr>
			<td>Período (Fim): <?= $datafim;?></td>
		</tr>
		<?
	}
	?>		
	<tr>
		<td class="parametros">
				<br>
				Relatório gerado em <?
				//Pega a data de geração do relatório
				$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i') datageracao ";
				$rs_geracao = mysql_query($sql);
				$row_geracao = mysql_fetch_array($rs_geracao);
				echo $row_geracao['datageracao'];
				mysql_free_result($rs_geracao);
				?>	
		</td>
	</tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center" border="1" class="sortable" width="100%">	
	<thead>
		<tr>
			<td class="titulo" bgcolor="#8080FF">Consultor</td>
			<?
			
			$dataini = DataYMD($dataini);
			$datafim = DataYMD($datafim);
			
			
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
			<td class="titulo" bgcolor="#8080FF">Média por Operador</td>
		</tr>
	</thead>
	<tbody>
	<?
	
	$sql ="";
	$sql.="select ui.codusuariointerno, nome, ui.desativado ";
	$sql.="  from usuariosinternos ui ";
	$sql.=" where ui.gerentecontas = 1 " ;
	
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	if(!empty($codgerenteconta))
		$sql.=" and ui.codusuariointerno = $codgerenteconta ";
	
	if(!empty($codequipe)){
		$sql.="  and ui.codusuariointerno in (";
		$sql.=" select e.fk_usuario ";
		$sql.="   from tb_usuarioequipe e ";
		$sql.="  where fk_equipe = $codequipe ) ";
	}
	
	if(!empty($cod_polo)){
		$sql.=" and ui.cod_polo = $cod_polo ";
	}
	
	$sql.=" order by ui.desativado, ui.nome ";
	
	$result = mysql_query($sql);
	$totalconsutores = mysql_num_rows($result);
	
	if ($totalconsutores ==0){
		$totalconsutores = 1;
	}
	
	while($row = mysql_fetch_array($result)){
		
		$total_linha = 0;
		$total_linha_qtde = 0;
		
		echo "<tr>";
		if($row['desativado'] == 1)
			echo "<td class='form' align='center'><a href='#' onclick=abrir('".$row['codusuariointerno']."')><font color='red'>".$row['nome']."</font></a></td>";
		else
			echo "<td class='form' align='center'><a href='#' onclick=abrir('".$row['codusuariointerno']."')><font color='green'>".$row['nome']."</font></a></td>";
		
		for($i = 0; $i < count($arrData); $i ++){
			
			$total_minutos = 0;
			
			//pega o total das agendas de visitas
			$sql ="";
			$sql.="select count(al.codagendalead) qtde, ifnull(sum(ta.minutos),0) minutos ";
			$sql.="  from agendaslead al ";
			$sql.="       inner join tipoagendamento ta on al.codtipo = ta.codtipo ";
			$sql.="		  inner join agendagerenteconta agc on al.codagendalead = agc.codagendalead ";
			$sql.=" where agc.codgerenteconta = ".$row['codusuariointerno'];
			$sql.="   and (al.codstatus is null or al.codstatus in (1,2)) ";
			$sql.="   and al.datahorario between '".DataYMD($arrData[$i])."' and '".DataYMD($arrData[$i])." 23:59:59' ";
			
			$rs_minutos = mysql_query($sql);
			$row_minutos = mysql_fetch_array($rs_minutos);
			$total_minutos = $row_minutos['minutos'];
			$total_agendas = $row_minutos['qtde'];
			mysql_free_result($rs_minutos);
			
			//pega o total de ocorrencias
			$sql ="";
			$sql.="select count(*) total ";
			$sql.="  from ocorrenciaslead ol ";
			$sql.=" where ol.codusuariointerno = ".$row['codusuariointerno'];
			$sql.="   and ol.datacadastro between '".DataYMD($arrData[$i])."' and '".DataYMD($arrData[$i])." 23:59:59' ";
			
			$rs_ocorrencias = mysql_query($sql);
			$row_minutos = mysql_fetch_array($rs_ocorrencias);
			$total_minutos += ($row_minutos['total'] * 5);
			mysql_free_result($rs_ocorrencias);
			
			//pega o total de prospecoes
			$sql ="";
			$sql.="select l.codlead ";
			$sql.="  from leads l ";
			$sql.=" 	  inner join contatoslead cl on cl.codlead = l.codlead ";
			$sql.=" where l.usuariocadastro = ".$row['codusuariointerno'];
			$sql.="   and l.datacadastro between '".DataYMD($arrData[$i])."' and '".DataYMD($arrData[$i])." 23:59:59' ";
			$sql.=" group by l.codlead ";
			
			$rs_prospeccoes = mysql_query($sql);
			$num = mysql_num_rows($rs_prospeccoes);
			$total_minutos += ($num * 15);
			mysql_free_result($rs_prospeccoes);
			
			if($total_minutos > 0)
				echo "<td class='form' align='center'>".retornarHora($total_minutos)."</td>";
			else
				echo "<td class='form' align='center'>&nbsp;</td>";
			
			$total_linha_qtde += $total_agendas;
			$arrTotalQtde[$i] += $total_agendas;
			
			$total_linha += $total_minutos;
			$arrTotal[$i] += $total_minutos;
			
		}
		echo "<td class='form' align='center'>".retornarHora(number_format($total_linha/$i,0))."</td>";
		echo "</tr>";
		
	}
	mysql_free_result($result);
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF">Média por Dia</td>
			<?
			$total = 0;
			for ($i = 0; $i < count($arrTotal); $i++){
				echo "<td align='center' class='titulo' bgcolor='#8080FF'>".retornarHora(number_format($arrTotal[$i]/$totalconsutores,0))."</td>";
				$total += $arrTotal[$i];
				$total_qtde += $arrTotalQtde[$i];
			}
			?>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= retornarHora(number_format($total/$totalconsutores,0))."";?></td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
