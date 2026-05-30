<?

$excel = $_REQUEST['excel'];

if($excel == "S"){
	$arquivo = 'planilha.xls';
	
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/x-msexcel");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}

include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/cla.equipes.php";
	
$cod_polo = $_REQUEST['cod_polo'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$cod_operadora = $_REQUEST['cod_operadora'];

$mailing_pk = $_REQUEST['mailing_pk'];

?>
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
<!--HTML-->
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
<table width="100%" align="center"  height="5"  cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<font size="+2" face="Arial">Carteira Consultor</font>
		</td>	
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="0" class="form">	
	<tr>		
		<td class="parametros">
		<?	if(!empty($cod_polo)){
			$sql = "Select 
					p.cod_polo
					,p.n_polo
					 from polo p";
			$sql .= " where p.cod_polo= $cod_polo ";
			$sql .= " Order By p.n_polo ";
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			echo "Polo: ".$polo['n_polo'];
			}?>		
		</td>
	</tr>	
	
	<tr>		
		<td class="parametros">
		<?	if(!empty($codgerenteconta)){
				$sql = "Select Nome From usuariosinternos Where CodUsuarioInterno = $codgerenteconta";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)){
					echo "Consultor: ".$row['nome'];
				}
				mysql_free_result($result);
			
			}?>		
		</td>
	</tr>	
	<tr>		
		<td class="parametros">
		<?	if(!empty($cod_operadora)){
				$sql = "select dsc_operadora from operadoras where cod_operadora = $cod_operadora ";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)){
					echo "Operadora: ".$row['dsc_operadora'];
				}
				mysql_free_result($result);
			
			}?>		
		</td>
	</tr>			
	<tr>		
		<td class="parametros">
		<?
		
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
		?>	
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
</table>
<br>
<br>
<table width="100%" border="1" cellpadding="0" cellspacing="0">
	<tr>
		<th width="400" nowrap class='titulo' bgcolor='#8080FF'>Consultor</th>
		<?
		$arrStatus = array();
		$arrStatusTotal = array();
		$arrTitulo = array();
		
		$arrTitulo[1]= 'Sem Inter.';
		$arrTitulo[2]= 'Trgt';
		$arrTitulo[3]= '0%';
		$arrTitulo[4]= '25%';
		$arrTitulo[5]= '50%';
		$arrTitulo[6]= '75%';
		$arrTitulo[10]= '80%';
		$arrTitulo[12]= '90%';
		$arrTitulo[15]= 'Cliente';
		
		$sql = "";
		$sql.= "select descricao, codstatusclassificacaolead from statusclassificacaolead order by codstatusclassificacaolead ";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			echo "<th class='titulo' bgcolor='#8080FF'>".$arrTitulo[$row['codstatusclassificacaolead']]."</th>";
			$arrStatus[$row['descricao']] = 0;
			$arrStatusTotal[$row['descricao']] = 0;
		}
		mysql_free_result($result);
		?>
		<th class="titulo" bgcolor="#8080FF">
			Total
		</th>
	</tr>
	<?
	
	$cor = "white";
	
	//Pega todas as linhas sem gerente de conta
	if(permissao('visualizar_todos_consultores', 'cs') && empty($codgerenteconta)){
		
		$sql ="";
		$sql.="select scl.descricao, count(*) total ";
		$sql.="  from statusclassificacaolead scl ";
		$sql.="       inner join leads l on l.codstatusclassificacaolead = scl.codstatusclassificacaolead ";
		$sql.=" where l.codgerenteconta is null ";
		$sql.=" group by scl.descricao ";

		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$arrStatus[$row['descricao']] = $row['total'];
			$arrStatusTotal[$row['descricao']] += $row['total'];
		}
		mysql_free_result($result);
		
		echo "<tr bgcolor='$cor'>";
		echo "<td align='center' class='form'>&nbsp;</td>";
		foreach($arrStatus as $total){
			echo "<td align='center' class='form'>$total</td>";
			$totallinha += $total;
		}		
		echo "<td align='center' class='form'>$totallinha</td>";
		echo "</tr>";
		
		$sql = "";
		$sql.= "select descricao from statusclassificacaolead order by codstatusclassificacaolead ";
		$rs_status = mysql_query($sql);
		while($rs = mysql_fetch_array($rs_status)){
			$arrStatus[$rs['descricao']] = 0;
		}
		mysql_free_result($rs_status);
		$totallinha = 0;

	}
		
	
	$i = 0;
	
	$sql = "";
	$sql.="select ui.nome gerenteconta, ui.desativado, scl.descricao, count(*) total ";
	$sql.="  from usuariosinternos ui ";
	$sql.="       left join leads l on l.codgerenteconta = ui.codusuariointerno ";
	$sql.="       left join statusclassificacaolead scl on l.codstatusclassificacaolead = scl.codstatusclassificacaolead ";
	$sql.=" where ui.GerenteContas = 1 ";
	
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	//parametros de filtro
	if(!empty($codgerenteconta))
		$sql.=" and l.codgerenteconta = $codgerenteconta ";
	
	if(!empty($mailing))
		$sql.="  and l.mailing_pk = ".$mailing_pk;	
	
	if(!empty($_REQUEST['cod_polo']))
		$sql.=" and l.cod_polo =". $_REQUEST['cod_polo'];
        
	if(!empty($cod_operadora)){
		$sql.= " and l.codlead in (select lo.codlead from leads_operadoras lo where lo.cod_operadora = $cod_operadora) ";
	}        
	//fim dos parametros
	
	$sql.=" group by ui.nome, ui.desativado, scl.descricao ";
	$sql.=" order by ui.desativado, ui.nome, scl.codstatusclassificacaolead ";
	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		if($i == 0){
			
			if($cor == '#dbdbdb'){
				$cor = "white";
			}
			else{
				$cor = "#dbdbdb";
			}	
			
			$gerenteconta = $row['gerenteconta'];
			$desativado = $row['desativado'];
			
			echo "<tr bgcolor='$cor'>";
		}
		if($gerenteconta != $row['gerenteconta']){
			
			if($desativado == 1){				
				echo "<td class='form'><font color='#990000'>$gerenteconta</font></td>";
			}
			else{
				
				echo "<td class='form'><font color='#009900'>$gerenteconta</font></td>";
			}
			
			//echo "<td class='form'>$gerenteconta</td>";
			
			foreach($arrStatus as $total){
				echo "<td align='center' class='form'>$total</td>";
				$totallinha += $total;
			}
			
			//imprime os totais
			echo "<td align='center' class='form'>$totallinha</td>";
			echo "</tr>";
			
			if($cor == '#dbdbdb'){
				$cor = "white";
			}
			else{
				$cor = "#dbdbdb";
			}
			
			echo "<tr bgcolor='$cor'>";
			
			//zera os valores
			$sql = "";
			$sql.= "select descricao from statusclassificacaolead order by codstatusclassificacaolead ";
			$rs_status = mysql_query($sql);
			while($rs = mysql_fetch_array($rs_status)){
				$arrStatus[$rs['descricao']] = 0;
			}
			mysql_free_result($rs_status);
			$totallinha = 0;
			
			$gerenteconta = $row['gerenteconta'];
			$desativado = $row['desativado'];
			
		}

	
		if(!empty($row['descricao'])){		
			$arrStatus[$row['descricao']] = $row['total'];
			$arrStatusTotal[$row['descricao']] += $row['total'];
		}
		$i ++;
		
	}
	mysql_free_result($result);
		
	if($desativado == 1){
		echo "<td class='form'><font color='#990000'>$gerenteconta</font></td>";
	}
	else{
		echo "<td class='form'><font color='#009900'>$gerenteconta</font></td>";
	}
			
	foreach($arrStatus as $total){
		echo "<td align='center' class='form'>$total</td>";
		$totallinha += $total;

}
	echo "<td align='center' class='form'>$totallinha</td>";
	echo "</tr>";
	
	
	$totallinha = 0;
	//exibe os totais.
	echo "<tr>";
	echo "<td class='titulo' bgcolor='#8080FF'>Total</td>";
	foreach($arrStatusTotal as $total){
		echo "<td align='center' class='titulo' bgcolor='#8080FF'>$total</td>";
		$totallinha += $total;
	}
	echo "<td align='center' class='titulo' bgcolor='#8080FF'>$totallinha</td>";
	echo "</tr>";
	?>
</table>
</body>
</html>

