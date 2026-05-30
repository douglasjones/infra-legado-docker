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

$codgerenteconta = $_REQUEST['codgerenteconta'];
$codatendente = $_REQUEST['codatendente'];
$mailing_pk = $_REQUEST['mailing_pk'];
$codmotivo = $_REQUEST['codmotivo'];
$dataini = $_REQUEST['dataini'];
$datafim = $_REQUEST['datafim'];
$codequipe = $_REQUEST['codequipe'];

//strSQL 
$strSQL.="  from leads l ";
$strSQL.="		  inner join motivoslead ml on l.codmotivo = ml.codmotivolead  ";
if(!empty($codgerenteconta))
	$strSQL.=" inner ";
else
	$strSQL.="	left ";
$strSQL.=" join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno ";
if(!empty($codatendente))
	$strSQL.=" inner ";
else
	$strSQL.=" left ";
$strSQL.=" join usuariosinternos ui1 on l.codatendente = ui1.codusuariointerno ";
$strSQL.=" inner join ocorrenciaslead ol on ol.codlead = l.codlead ";
$strSQL.=" left join mailing m on l.mailing_pk = pk";
$strSQL.=" where ol.codtipoocorrencialead = 5 ";

		if(!permissao('visualizar_todos_consultores', 'cs'))
					$sql .= " and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).")";
				


//parametros
if(!empty($codgerenteconta))
	$where.=" and l.codgerenteconta = $codgerenteconta ";

if(!empty($codatendente))
	$where.=" and l.codatendente = $codatendente ";

if(!empty($mailing_pk))
	$where.=" and l.mailing_pk =".$mailing_pk;

if(!empty($dataini))
	$where.=" and ol.datacadastro >= '".DataYMD($dataini)." 00:00:00' ";

if(!empty($datafim))
	$where.=" and ol.datacadastro <= '".DataYMD($datafim)." 23:59:59' ";

if(!empty($codmotivo))
	$where.=" and l.codmotivo = $codmotivo ";

echo $sql;
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
		<font size="+2">Sem Interesse</font>
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
	if(!empty($codatendente)){
		$sql = "select nome from usuariosinternos where codusuariointerno = $codatendente ";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		?>
		<tr>
			<td>Atendente: <?= $row['nome'];?></td>
		</tr>
		<?
		mysql_free_result($result);
	}
	if(!empty($mailing_pk)){
		?>
		<tr>
			<td>		<?
		
			if(!empty($mailing_pk)){
			$sql ="";
			$sql.="SELECT m.pk, m.dsc_mailing
						  FROM mailing m
						 WHERE m.dt_cancelamento IS NULL
						
					and pk=".$mailing_pk;
					
			$m = mysql_query($sql);
			$mailing = mysql_fetch_array($m);
			echo "Mailing: ".$mailing['dsc_mailing'];
		}
		?></td>
		</tr>
		<?
	}
	if(!empty($codmotivo)){
		$sql = "select descricao from motivoslead where codmotivolead = $codmotivo ";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		?>
		<tr>
			<td>Motivo Sem Interesse: <?= $row['descricao'];?></td>
		</tr>
		<?
		mysql_free_result($result);
	}
	if(!empty($dataini)){
		?>
		<tr>
			<td>Data Alteração (Início): <?= $dataini;?></td>
		</tr>
		<?
	}
	if(!empty($datafim)){
		?>
		<tr>
			<td>Data Alteração (Fim): <?= $datafim;?></td>
		</tr>
		<?
	}
	?>		
	<tr>
		<td class="parametros">
				<br>
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
</table>
<br>
<table width="100%" cellspacing="0" cellpadding="0" align="center" border="1" class="sortable">	
	<thead>
		<tr>
			<td class="titulo" bgcolor="#8080FF">Mailing</td>
			<?
			
			$indice = 0;
			$arrMotivo = array();
			$arrTotal = array();
			
			$sql ="";
			$sql.="select ml.descricao motivo, l.codmotivo ";
			$sql.=$strSQL;
			$sql.=$where;
			$sql.=" group by ml.descricao, l.codmotivo ";
			
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				echo "<td class='titulo' bgcolor='#8080FF'>".$row['motivo']."</td>";
				$arrMotivo[$indice] = $row['codmotivo'];
				$arrTotal[$row['codmotivo']]=0;
				$indice++ ; 
			}
			mysql_free_result($result);
			
			?>
		</tr>
	</thead>
	<tbody>
	<?
		$sql ="";
		$sql.="select m.dsc_mailing mailing,l.mailing_pk ";
		$sql.=$strSQL;
		$sql.=$where;
		$sql.=" group by l.mailing_pk ";
		
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			
			echo "<tr>";
			echo "<td class='form'>".$row['mailing']."</td>";
			
			for($i = 0; $i < count($arrMotivo); $i++){
			
				$sql ="";
				$sql.="select distinct l.codlead ";
				$sql.=$strSQL;
				$sql.=$where;
				$sql.="  and l.mailing_pk = ".$row['mailing_pk'];
				$sql.="  and l.codmotivo = '".$arrMotivo[$i]."' ";
				
				$rs_total = mysql_query($sql);
				$num = mysql_num_rows($rs_total);
				echo "<td class='form' align='center'>".$num."</td>";
				mysql_free_result($rs_total);
				
				$arrTotal[$arrMotivo[$i]] += $num;
				
			}
			
			echo "</tr>";
			
		}
		mysql_free_result($result);	
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF">&nbsp;</td>
			<?
			for($i = 0; $i < count($arrMotivo); $i++){
			?>
				<td align="center" class="titulo" bgcolor="#8080FF"><?= $arrTotal[$arrMotivo[$i]];?></td>
			<?
			}
			?>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
