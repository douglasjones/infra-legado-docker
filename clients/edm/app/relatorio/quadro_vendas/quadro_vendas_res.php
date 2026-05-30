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


include_once( "../../libs/maininclude.php" ) ;
include_once( "../../libs/datas.php" ) ;

$acao = 'cs';
$cod_polo = $_REQUEST['cod_polo'];
$codequipe = $_REQUEST['codequipe'];
$dataenviocontratode = $_REQUEST['dataenviocontratode'];
$dataenviocontratoate = $_REQUEST['dataenviocontratoate'];
$dataentregaaparelhode = $_REQUEST['dataentregaaparelhode'];
$dataentregaaparelhoate = $_REQUEST['dataentregaaparelhoate'];

// controle de permissão
if(!(($acao == 'cs' && permissao('quadro_vendas_pesq.php', 'cs')) || ($acao == 'upd' && permissao('quadro_vendas_pesq.php', 'al')))){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}

$arrPlanos = array();
$arrTitulosPlanos = array();

$arrModulos = array();
$arrTitulosModulos = array();

$arrTotalPlanos = array();
$arrTotalModulos = array();

$arrTotalGeralPlanos = array();
$arrTotalGeralModulos = array();

$arrPlanos[0] = 'qtdelinhas0';
$arrPlanos[1] = 'qtdelinhas0c';
$arrPlanos[2] = 'qtdelinhas100';
$arrPlanos[3] = 'qtdelinhas200';
$arrPlanos[4] = 'qtdelinhas400';
$arrPlanos[5] = 'qtdelinhas800';
$arrPlanos[6] = 'qtdelinhas1200';
$arrPlanos[7] = 'qtdelinhas1800';
$arrPlanos[8] = 'qtdelinhas102';
$arrPlanos[9] = 'qtdelinhas122';
$arrPlanos[10] = 'qtdelinhas145';
$arrPlanos[11] = 'qtdelinhascdt49';
$arrPlanos[12] = 'qtdelinhas59';
$arrPlanos[13] = 'qtdelinhas69';
$arrPlanos[14] = 'qtdelinhas999';
$arrPlanos[15] = 'qtdelinhascdw';

$arrTitulosPlanos[0] = 'Básico';
$arrTitulosPlanos[1] = 'Controle';
$arrTitulosPlanos[2] = '100';
$arrTitulosPlanos[3] = '200';
$arrTitulosPlanos[4] = '400';
$arrTitulosPlanos[5] = '800';
$arrTitulosPlanos[6] = '1200';
$arrTitulosPlanos[7] = '1800';
$arrTitulosPlanos[8] = 'P 100';
$arrTitulosPlanos[9] = 'P 200';
$arrTitulosPlanos[10] = 'P 400';
$arrTitulosPlanos[11] = 'CDT 49';
$arrTitulosPlanos[12] = 'CDT 59';
$arrTitulosPlanos[13] = 'CDT 69';
$arrTitulosPlanos[14] = 'ANUAL 999';
$arrTitulosPlanos[15] = 'CDW';

$arrModulos[0] = 'qtdeconexaoint';
$arrModulos[1] = 'qtdedirect';
$arrModulos[2] = 'qtdewap';
$arrModulos[3] = 'qtdeinteg';
$arrModulos[4] = 'qtdebis';
$arrModulos[5] = 'qtdedadosi1';
$arrModulos[6] = 'qtdemapasbb';
$arrModulos[7] = 'qtdebkp';
$arrModulos[8] = 'qtdeequipe';
$arrModulos[9] = 'qtdeequipeloca';
$arrModulos[10] = 'qtdelocalizador';
$arrModulos[11] = 'qtdeagps';
$arrModulos[12] = 'qtdesms';
$arrModulos[13] = 'qtdecxplus';
$arrModulos[14] = 'qtdepush';

$arrTitulosModulos[0] = 'Conexão Direta Internacional';
$arrTitulosModulos[1] = 'NOL Direct';
$arrTitulosModulos[2] = 'NOL Wap';
$arrTitulosModulos[3] = 'NOL Integration';
$arrTitulosModulos[4] = 'Pacote Blackberry BIS/BES';
$arrTitulosModulos[5] = 'Pacote de Dados i1';
$arrTitulosModulos[6] = 'GPS Nextel Blackberry';
$arrTitulosModulos[7] = 'Nextel Backup';
$arrTitulosModulos[8] = 'Equipe on Line';
$arrTitulosModulos[9] = 'Equipe on Line + Localizador';
$arrTitulosModulos[10] = 'Localizador';
$arrTitulosModulos[11] = 'AGPS';
$arrTitulosModulos[12] = 'SMS Ilimitado';
$arrTitulosModulos[13] = 'Caixa Postal Plus';
$arrTitulosModulos[14] = 'Push to Alarm';

//Zera os totais
foreach($arrPlanos as $variavel){
	$arrTotalPlanos[$variavel] = 0;
	$arrTotalGeralPlanos[$variavel] = 0;
}

foreach($arrModulos as $variavel){
	$arrTotalModulos[$variavel] = 0;
	$arrTotalGeralModulos[$variavel] = 0;
}

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
<script>
function exportar_xls(){
	window.open(location.href+"&excel=S");
}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
if($excel != "S"){
?>
<a name="link_excel" id="link_excel" href='javascript:exportar_xls();' title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
<br>

<?
}
?>
<br>
<table cellspacing="0" cellpadding="0" align="left" border="0">	
<tr>
	<td class="form" align="center">
		<font size="+2">Quadro de Vendas</font>
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
			Relatório gerado em <?=date('d/m/Y \à\s H:i', mktime());?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($cod_polo)){
			$sql = "Select p.cod_polo, c.dsc_cidade from polo p";
			$sql .= " inner join cidade c on p.cod_cidade = c.cod_cidade ";
			$sql .= " where p.cod_polo=$cod_polo ";
			$sql .= " Order By c.dsc_cidade ";
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			echo "Polo: ".$polo['dsc_cidade'];
		}
		?>
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
	<tr>
		<td class="parametros">
		<?	
		if(!empty($dataenviocontratode) || !empty($dataenviocontratoate)){
			echo "Data envio contrato para a operadora $dataenviocontratode até $dataenviocontratoate ";
		}
		?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($dataentregaaparelhode) || !empty($dataentregaaparelhoate)){
			echo "Data entrega aparelhos $dataentregaaparelhode até $dataentregaaparelhoate ";
		}
		?>
		</td>
	</tr>	
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center" border="1" width="4000" class="sortable">	
	<thead>
		<tr>
			<td bgcolor="#4040FF">
				&nbsp;
			</td>
			<td align="center" bgcolor="#4040FF" class="titulo" colspan="<?= count($arrTitulosPlanos)+1;?>">
				<font color="White">Planos</font>
			</td>
			<td align="center" bgcolor="#4040FF" class="titulo" colspan="<?= count($arrTitulosModulos);?>">
				<font color="White">Módulos</font>
			</td>
		</tr>
		<tr>
			<td class='titulo' bgcolor='#8080FF'>Consultor</td>
			<?
			foreach ($arrTitulosPlanos as $titulo){
				echo "<td class='titulo' bgcolor='#8080FF'>$titulo</td>";
			}
			?>
			<td bgcolor="#8080FF" class="titulo">Total</td>
			<?
			foreach ($arrTitulosModulos as $titulo){
				echo "<td class='titulo' bgcolor='#8080FF'>$titulo</td>";
			}
			?>
			
		</tr>
	</thead>
	<tbody>
	<?	
	$sql ="";
	$sql.="select l.codgerenteconta, ui.nome gerenteconta, l.codlead, p.codproposta, p.versao, mp.id, mp.valor, mp.calculado ";
	$sql.="  from leads l ";
	$sql.="       inner join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno ";
	$sql.="       inner join propostas p on p.codlead = l.codlead ";
	$sql.="       inner join modulosproposta mp on (mp.codlead = p.codlead and mp.codproposta = p.codproposta and mp.versao = mp.versao) ";
	$sql.=" where p.datacancelamento is null and mp.id in (";
	foreach($arrPlanos as $variavel){
		$sql.="'$variavel',";
	}
	foreach($arrModulos as $variavel){
		$sql.="'$variavel',";
	}	
	$sql.="'') ";
	
	//PARAMETROS DE PESQUISA
	if(!empty($cod_polo) && $cod_polo != 100)
		$sql.=" and l.cod_polo = $cod_polo ";
		
	if(!empty($codequipe)){
		$sql.=" and l.codgerenteconta in (";
		$sql.=" select e.fk_usuario ";
		$sql.="   from tb_usuarioequipe e ";
		$sql.="  where fk_equipe = $codequipe ) ";
	}
	
	if(!empty($dataenviocontratode))
		$sql.=" and p.dataenviocontrato >= '".DataYMD($dataenviocontratode)." 00:00:00' ";
		
	if(!empty($dataenviocontratoate))
		$sql.=" and p.dataenviocontrato <= '".DataYMD($dataenviocontratoate)." 23:59:59' ";
		
	if(!empty($dataentregaaparelhode))
		$sql.=" and p.dataentregaaparelho >= '".DataYMD($dataentregaaparelhode)." 00:00:00' ";
		
	if(!empty($dataentregaaparelhoate))
		$sql.=" and p.dataentregaaparelho <= '".DataYMD($dataentregaaparelhoate)." 23:59:59' ";
		
	//fim dos parametros
	$sql.=" order by gerenteconta ";
	
	$result = mysql_query($sql);
	$cont = 0;
	while($row = mysql_fetch_array($result)){
		
		if($i == 0){
			$gerenteconta = $row['gerenteconta'];
			echo "<tr>";
		}
		
		if($gerenteconta != $row['gerenteconta']){
			
			$totallinha = 0;
			
			echo "<td class='form'>".$gerenteconta."</td>";
			
			//imprime os totais.
			for($j = 0; $j < count($arrPlanos); $j++){
				echo "<td class='form' align='center'>".$arrTotalPlanos[$arrPlanos[$j]]."</td>";
				$totallinha += $arrTotalPlanos[$arrPlanos[$j]];
			}
			echo "<td align='center' class='form'>".$totallinha."</td>";
			
			//imprime os valores por modulo.
			for($j = 0; $j < count($arrModulos); $j++){
				echo "<td class='form' align='center'>".$arrTotalModulos[$arrModulos[$j]]."</td>";
			}
			//Zera os totais
			foreach($arrPlanos as $variavel){
				$arrTotalPlanos[$variavel] = 0;
			}
			foreach($arrModulos as $variavel){
				$arrTotalModulos[$variavel] = 0;
			}
			
			$gerenteconta = $row['gerenteconta'];
			echo "</tr>";
			
			//inicia o processo
			echo "<tr>";
		}
		
		if($row['calculado']>0){
			$arrTotalPlanos[$row['id']] += $row['calculado'];
			$arrTotalModulos[$row['id']] += $row['calculado'];
			
			$arrTotalGeralPlanos[$row['id']] += $row['calculado'];
			$arrTotalGeralModulos[$row['id']] += $row['calculado'];
		}
		else{
			$arrTotalPlanos[$row['id']] += $row['valor'];
			$arrTotalModulos[$row['id']] += $row['valor'];
			
			$arrTotalGeralPlanos[$row['id']] += $row['valor'];
			$arrTotalGeralModulos[$row['id']] += $row['valor'];
		}
		
		$i ++;
		$cont++;
	}
	
	//imprime a ultima linha
	$totallinha = 0;
	echo "<td class='form'>".$gerenteconta."</td>";
	//imprime os totais.
	for($j = 0; $j < count($arrPlanos); $j++){
		echo "<td class='form' align='center'>".$arrTotalPlanos[$arrPlanos[$j]]."</td>";
		$totallinha += $arrTotalPlanos[$arrPlanos[$j]];
	}
	echo "<td align='center' class='form'>".$totallinha."</td>";
	
	//imprime os totais.
	for($j = 0; $j < count($arrModulos); $j++){
		echo "<td class='form' align='center'>".$arrTotalModulos[$arrModulos[$j]]."</td>";
	}
	echo "</tr>";
	//fim da ultima linha
	
	mysql_free_result($result);
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align='center' class='titulo' bgcolor='#8080FF'>&nbsp;</td>
			<?
			$totalgeral = 0;
			foreach($arrPlanos as $variavel){
				echo "<td align='center' class='titulo' bgcolor='#8080FF'>".$arrTotalGeralPlanos[$variavel]."</td>";
				$totalgeral += $arrTotalGeralPlanos[$variavel];
			}
			echo "<td align='center' class='titulo' bgcolor='#8080FF'>".$totalgeral."</td>";
			foreach($arrModulos as $variavel){
				echo "<td align='center' class='titulo' bgcolor='#8080FF'>".$arrTotalGeralModulos[$variavel]."</td>";
			}
			?>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>