<?
include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/cla.equipes.php";
include_once "../../libs/cla.relefetivis.php";

$codpolo		= (@$_REQUEST['cod_polo']?$_REQUEST['cod_polo']:null);
$codequipe		= (@$_REQUEST['codequipe']?$_REQUEST['codequipe']:null);
$codgerente		= (@$_REQUEST['codgerente']?$_REQUEST['codgerente']:null);
$dataagde	= (@$_REQUEST['dataagde']?$_REQUEST['dataagde']:null);
$dataagate	= (@$_REQUEST['dataagate']?$_REQUEST['dataagate']:null);

if($dataagde){
	$dataagde	= explode('/', $dataagde);
	$dataagde	= strtotime($dataagde[1].'/'.$dataagde[0].'/'.$dataagde[2]);
}
if($dataagate){
	$dataagate	= explode('/', $dataagate);
	$dataagate	= strtotime($dataagate[1].'/'.$dataagate[0].'/'.$dataagate[2]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">
<?	include_once "../../libs/head.php";?>

    <!-- Formatação CSS -->
	<style>
	.recebimento {
		color: blue;
	}
	.recebimento a:link, .recebimento a:visited {
		color: blue;
	}
	a:link, a:visited {
		color: black;
		text-decoration: none;
	}
	a:hover {
		color: blue;
		text-decoration: underline;
	}
	
	td, th {
		white-space: nowrap;
	}
	</style>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="100%">
<table width="100%" align="left"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório de Efetividade de Visita
		</td>
	</tr>
</table>	
</td></tr>
<tr><td width="100%">
<table width="800" align="left"  height="30"    cellpadding="0" cellspacing="0">
	<tr>
		 <td  >&nbsp; 
			
		</td>	
	</tr>
</table>	
</td></tr>
<tr><td width="100%">
<table width="800"   align="left" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td class="parametros">
			Parâmetros 
		</td>
	</tr>
	<tr>
		<td class="parametros">
				Relatório gerado em <?=date( 'd/m/Y \à\s H:i', mktime());?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
<?	if(!empty($_REQUEST['cod_polo'])){
			$sql = "Select 
					p.cod_polo
					,p.n_polo
					 from polo p";
			$sql .= " where p.cod_polo=".$_REQUEST['cod_polo'];
			$sql .= " Order By p.n_polo ";
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			echo "Polo: ".$polo['n_polo'];
	}?>
		</td>
	</tr>
</table>
</td></tr>
<tr><td width="100%">
<table width="800" align="left"  height="30"    cellpadding="0" cellspacing="0">
	<tr>
		 <td  >&nbsp; 
			
		</td>	
	</tr>
</table>	
</td></tr>
<tr><td width="100%">
<table cellspacing="0" cellpadding="0"  align="left" width="800" border="0" >
	<tr>
		<td class="texto_label">
<?	if(!empty($dataagde)){?>
			<dt>Faixa de Datas de Agendamento:</dt>
				<dd><?=date('d/m/Y', $dataagde);?> até <?=date('d/m/Y', $dataagate);?></dd>
<?	}?>
		</td>
	</tr>
</table>
</td></tr>
<tr><td width="100%">
<table cellspacing="2" cellpadding="2"  align="left"  border="0" class="form">
	<tbody>
<?	$sql = "SELECT e.Vc_Nome Equipe, u.Nome Lider, Tk_Equipe FROM tb_equipesvendas e INNER JOIN usuariosinternos u ON e.Fk_Lider = u.CodUsuarioInterno WHERE 1";
	 
	if($codgerente) $sql .= " AND Fk_Gerente = $codgerente";
	if($codequipe) $sql .= " AND Tk_Equipe = $codequipe";
	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result)){
		$totgeral = array();
		$totgeral[0] = 0;
		$totgeral[1] = 0;
		$totgeral[2] = 0;
		$totgeral[3] = 0;
		$totgeral[4] = 0;
		$totgeral[5] = 0;
		$totgeral[6] = 0;
		$totgeral[7] = 0;
		$totgeral[8] = 0;
		$totgeral[9] = 0;
		$totgeral[10] = 0;
		$totgeral[11] = 0;
		while($row = mysql_fetch_array($result)){
			if($_REQUEST['tipo'] == 'analit')
				$releqp = relefetivis::analitico($row['Tk_Equipe'], $row['Equipe'], $codpolo, $dataagde, $dataagate);
			elseif($_REQUEST['tipo'] == 'sintet')
				$releqp = relefetivis::sintetico($row['Tk_Equipe'], $row['Equipe'], $codpolo, $dataagde, $dataagate);
			echo $releqp['html'];
			if($releqp['toteqp'] > 0){
			?>	<tr>
					<td><b>Totalização por Equipe:</b></td>
					<td><b>Prod.</b></td>
					<td><b>Improd.</b></td>
					<td><b>Indef.</b></td>
					<td><b>SI I</b></td>
					<td><b>SI P</b></td>
					<td><b>25%</b></td>
					<td><b>50%</b></td>
					<td><b>75%</b></td>
					<td><b>80%</b></td>
					<td><b>90%</b></td>
					<td><b>Cliente</b></td>
				</tr>
				<tr>
				<td><?=$releqp['toteqp'];?></td>
				<td><?=$releqp['toteqp1'];?> (<?=number_format(($releqp['toteqp1']*100/$releqp['toteqp']),2,',','.');?>%)</td>
				<td><?=$releqp['toteqp2'];?> (<?=number_format(($releqp['toteqp2']*100/$releqp['toteqp']),2,',','.');?>%)</td>
				<td><?=$releqp['toteqp3'];?> (<?=number_format(($releqp['toteqp3']*100/$releqp['toteqp']),2,',','.');?>%)</td>
				<td><?=$releqp['toteqp4b'];?> (<?=number_format(($releqp['toteqp4b']*100/$releqp['toteqp']),2,',','.');?>%)</td>
				<td><?=$releqp['toteqp4a'];?> (<?=($releqp['toteqp1']?number_format(($releqp['toteqp4a']*100/$releqp['toteqp1']),2,',','.'):'0,00');?>%)</td>
				<td><?=$releqp['toteqp5'];?> (<?=($releqp['toteqp1']?number_format(($releqp['toteqp5']*100/$releqp['toteqp1']),2,',','.'):'0,00');?>%)</td>
				<td><?=$releqp['toteqp6'];?> (<?=($releqp['toteqp1']?number_format(($releqp['toteqp6']*100/$releqp['toteqp1']),2,',','.'):'0,00');?>%)</td>
				<td><?=$releqp['toteqp7'];?> (<?=($releqp['toteqp1']?number_format(($releqp['toteqp7']*100/$releqp['toteqp1']),2,',','.'):'0,00');?>%)</td>
				<td><?=$releqp['toteqp8'];?> (<?=($releqp['toteqp1']?number_format(($releqp['toteqp8']*100/$releqp['toteqp1']),2,',','.'):'0,00');?>%)</td>
				<td><?=$releqp['toteqp9'];?> (<?=($releqp['toteqp1']?number_format(($releqp['toteqp9']*100/$releqp['toteqp1']),2,',','.'):'0,00');?>%)</td>
				<td><?=$releqp['toteqp10'];?> (<?=($releqp['toteqp1']?number_format(($releqp['toteqp10']*100/$releqp['toteqp1']),2,',','.'):'0,00');?>%)</td>
				</tr>
				<tr><td colspan='12'><hr></td></tr><?
				$totgeral[0] += $releqp['toteqp'];
				$totgeral[1] += $releqp['toteqp1'];
				$totgeral[2] += $releqp['toteqp2'];
				$totgeral[3] += $releqp['toteqp3'];
				$totgeral[4] += $releqp['toteqp4a'];
				$totgeral[5] += $releqp['toteqp5'];
				$totgeral[6] += $releqp['toteqp6'];
				$totgeral[7] += $releqp['toteqp7'];
				$totgeral[8] += $releqp['toteqp8'];
				$totgeral[9] += $releqp['toteqp9'];
				$totgeral[10] += $releqp['toteqp9'];
				$totgeral[11] += $releqp['toteqp4b'];
			}
		}
	?>	<tr>
			<td><b>Totalização Geral:</b></td>
			<td><b>Prod.</b></td>
			<td><b>Improd.</b></td>
			<td><b>Indef.</b></td>
			<td><b>SI I</b></td>
			<td><b>SI P</b></td>
			<td><b>25%</b></td>
			<td><b>50%</b></td>
			<td><b>75%</b></td>
			<td><b>80%</b></td>
			<td><b>90%</b></td>
			<td><b>Cliente</b></td>
		</tr>
		<tr>
			<td><?=$totgeral[0];?></td>
			<td><?=$totgeral[1];?> (<?=number_format(($totgeral[0]?$totgeral[1]*100/$totgeral[0]:0),2,',','.');?>%)</td>
			<td><?=$totgeral[2];?> (<?=number_format(($totgeral[0]?$totgeral[2]*100/$totgeral[0]:0),2,',','.');?>%)</td>
			<td><?=$totgeral[3];?> (<?=number_format(($totgeral[0]?$totgeral[3]*100/$totgeral[0]:0),2,',','.');?>%)</td>
			<td><?=$totgeral[10];?>(<?=number_format(($totgeral[0]?$totgeral[10]*100/$totgeral[0]:0),2,',','.');?>%)</td>
			<td><?=$totgeral[4];?> (<?=number_format(($totgeral[1]?$totgeral[4]*100/$totgeral[1]:0),2,',','.');?>%)</td>
			<td><?=$totgeral[5];?> (<?=number_format(($totgeral[1]?$totgeral[5]*100/$totgeral[1]:0),2,',','.');?>%)</td>
			<td><?=$totgeral[6];?> (<?=number_format(($totgeral[1]?$totgeral[6]*100/$totgeral[1]:0),2,',','.');?>%)</td>
			<td><?=$totgeral[7];?> (<?=number_format(($totgeral[1]?$totgeral[7]*100/$totgeral[1]:0),2,',','.');?>%)</td>
			<td><?=$totgeral[8];?> (<?=number_format(($totgeral[1]?$totgeral[8]*100/$totgeral[1]:0),2,',','.');?>%)</td>
			<td><?=$totgeral[9];?> (<?=number_format(($totgeral[1]?$totgeral[9]*100/$totgeral[1]:0),2,',','.');?>%)</td>
			<td><?=$totgeral[10];?> (<?=number_format(($totgeral[1]?$totgeral[10]*100/$totgeral[1]:0),2,',','.');?>%)</td>
		</tr>
		<tr><td colspan="12"><hr></td></tr><?
	}else{ ?>
		<tr>
			<th>A equipe selecionada não pertence ao polo selecionado.</th>
		</tr>
<?	}
	mysql_free_result($result);?>
	</tbody>
  </table>
</td></tr>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>