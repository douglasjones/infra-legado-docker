<?

$excel = $_REQUEST['excel'];

if($excel == "S"){
	$arquivo = 'planilha.xls';
	
	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}

include_once "../../libs/maininclude.php";

$mailing_pk = $_REQUEST['mailing_pk'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$codatendente = $_REQUEST['codatendente'];
$cod_polo = $_REQUEST['cod_polo'];

?>
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <!--Cabeçalho-->
	<title>Relatório de Qualidade de Mailing</title>
<?	include_once "../../libs/head.php";?>
<?
if($excel != "S"){
?>
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<?	include_once "../../libs/head.php";?>
<script src="../../extras/tabela.js"></script>
<script>
	function abrirAgenda(vlr){
		NewWindow("../../vendas/leads/leadsagendanew.php?codagendalead="+vlr,590,600);
	}
</script>
<?
}
?>
</head>
<body>
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
		<font size="+2">Qualidade de Mailings</font>
	</td>
</tr>
</table>
<br>
	
<table width="100%"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td class="parametros">
			&nbsp;
		</td>
	</tr>		
	<tr>
		<td class="parametros">
			Relatório gerado em 
			<?
				$sql ="";
				$sql.="select date_format(sysdate(),'%d/%m/%Y %H:%i:%s') hoje ";
				$result =  mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['hoje'];
				mysql_free_result($result);
			?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
			&nbsp;
		</td>
	</tr>	
	<tr>
		<td class="parametros">
			<B>Parâmetros </B>
		</td>
	</tr>
	<tr>
		<td class="parametros">
			<?	
			if(!empty($cod_polo)){
				
				$sql = "Select p.cod_polo, p.n_polo from polo p";
				$sql.= " where p.cod_polo= $cod_polo ";
				$sql.= " Order By p.n_polo ";
				
				$result = mysql_query($sql);
				$polo = mysql_fetch_array($result);
				echo "Polo: ".$polo['n_polo'];
				mysql_free_result($result);
			}
			?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
			<?	
			if(!empty($mailing_pk)){

				$sql ="select pk, dsc_mailing ";
				$sql.="  from mailing ";
				$sql.=" where pk = $mailing_pk ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo "Mailing: ".$row['dsc_mailing'];
				mysql_free_result($result);
			}
			?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
			<?	
			if(!empty($codgerenteconta)){
				$sql ="select codusuariointerno, nome ";
				$sql.="  from usuariosinternos ui ";
				$sql.=" where codusuariointerno = $codgerenteconta ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo "Consultor: ".$row['nome'];
				mysql_free_result($result);
			}
			?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
			<?	
			if(!empty($codatendente)){
				$sql ="select codusuariointerno, nome ";
				$sql.="  from usuariosinternos ui ";
				$sql.=" where codusuariointerno = $codatendente ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo "Atendente: ".$row['nome'];
				mysql_free_result($result);
			}
			?>
		</td>
	</tr>		
	<tr>
		<td class="parametros">
			&nbsp;
		</td>
	</tr>		

</table>
<table width="100%" cellpadding="0" cellspacing="0" border="1" class="sortable">
	<thead>
		<tr>
			<th class='titulo' bgcolor="#A6A6FF">
				Mailing
			</th>
			<?
			$total = 0;
			
			$arrStatus = array();
			$arrTotalStatus = array();
			$sql ="";
			$sql.="select codstatusclassificacaolead, descricao from statusclassificacaolead order by 1";
			$result = sql_query($sql);
			while($row = mysql_fetch_array($result)){
				echo "<th class='titulo'  bgcolor='#A6A6FF'>";
				echo $row['descricao'];
				$arrStatus[]=$row['codstatusclassificacaolead'];
				$arrTotalStatus[] = 0;
				echo "</th>";
			}
			//Adiciona um item a mais 
			$arrTotalStatus[] = 0;
			mysql_free_result($result);
			?>
			<th class='titulo' bgcolor="#A6A6FF">
				Total
			</th>		
		</tr>
	</thead>
	<tbody>
	<?
	
	$sql ="";
	$sql.="select pk, dsc_mailing ";
	$sql.="  from mailing ";
	$sql.=" where 1=1 ";
	if(!empty($mailing_pk))
		$sql.=" and pk = $mailing_pk ";
	
	$sql.=" order by 2 ";
	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		
		$total_linha = 0;
		
		echo "<tr class=form>";
		echo "<td>".$row['dsc_mailing']."</td>";
				
		for($i = 0; $i < count($arrStatus); $i++){
			
			//Pega os demais status 
			$sql ="";
			$sql.="select count(0) total ";
			$sql.="  from leads l ";
			$sql.=" where l.codstatusclassificacaolead = ".$arrStatus[$i];
			$sql.="   and l.mailing_pk = ".$row['pk'];
			if(!empty($cod_polo))
				$sql.=" and l.cod_polo = $cod_polo ";
			if(!empty($codatendente))
				$sql.=" and l.codatendente = $codatendente ";
			if(!empty($codgerenteconta))
				$sql.=" and l.codgerenteconta = $codgerenteconta ";			
			
            
			$rs_status = mysql_query($sql);
			while($row_status = mysql_fetch_array($rs_status)){
				echo "<td align='center'>";
				echo $row_status['total'];
				echo "</td>";
				
				$total_linha += $row_status['total'];
				$arrTotalStatus[$arrStatus[$i]] += $row_status['total'];
			}
			mysql_free_result($rs_status);
			
		}
		
		echo "<td align='center'>$total_linha</td>";
		
		echo "</tr>";
	}
	mysql_free_result($result);
	
	?>
	</tbody>
	<tfoot>
		<tr class='titulo' bgcolor="#A6A6FF" >
			<th>&nbsp;</th>
			<?
				$total_geral = 0;
				//echo "<th>".$arrTotalStatus[0]."</th>";
				
				
				//$total_geral+= $arrTotalStatus[0] + $arrTotalStatus[1];
				
				for($i = 0; $i < count($arrStatus); $i++){
					echo "<th>".$arrTotalStatus[$arrStatus[$i]]."</th>";
					$total_geral += $arrTotalStatus[$arrStatus[$i]];
				}
				
				echo "<th>$total_geral</th>";
				
				
			?>
		</tr>
	</tfoot>
</table>
</body>
</html>



