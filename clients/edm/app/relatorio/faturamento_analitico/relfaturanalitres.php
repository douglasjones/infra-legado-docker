<?
    /*
Pagina:relfaturanalitres.php
modulo:Relatorios

Dados de criação
Criação: 12/09/2008
Empresa:
Executor ALEXANDRE CABRERA

Histórico das Revisões:
 Criação: 
 Empresa:
 Executor 

Histórico de Auditorias:
 Criação: 
 Empresa:
 Executor 
 */
/*
 Includes
*/

    include_once "../../libs/maininclude.php";
	include_once "../../libs/datas.php";
	include_once "../../libs/cla.equipes.php";
	include_once "../../libs/cla.faixa.php";
	include_once "../../libs/cla.relfatura.php";

	$cod_polo		= (@$_REQUEST['cod_polo']?$_REQUEST['cod_polo']:null);
	$codequipe		= (@$_REQUEST['codequipe']?$_REQUEST['codequipe']:null);
	$dataenviode	= (@$_REQUEST['dataenviode']?$_REQUEST['dataenviode']:null);
	$dataenvioate	= (@$_REQUEST['dataenvioate']?$_REQUEST['dataenvioate']:null);
	$dataativade	= (@$_REQUEST['dataativade']?$_REQUEST['dataativade']:null);
	$dataativaate	= (@$_REQUEST['dataativaate']?$_REQUEST['dataativaate']:null);
	$dataestornode	= (@$_REQUEST['dataestornode']?$_REQUEST['dataestornode']:null);
	$dataestornoate	= (@$_REQUEST['dataestornoate']?$_REQUEST['dataestornoate']:null);
	
	if($dataenviode){
		$dataenviode	= explode('/', $dataenviode);
		$dataenviode	= strtotime($dataenviode[1].'/'.$dataenviode[0].'/'.$dataenviode[2]);
	}
	if($dataenvioate){
		$dataenvioate	= explode('/', $dataenvioate);
		$dataenvioate	= strtotime($dataenvioate[1].'/'.$dataenvioate[0].'/'.$dataenvioate[2]);
	}
	if($dataativade){
		$dataativade	= explode('/', $dataativade);
		$dataativade	= strtotime($dataativade[1].'/'.$dataativade[0].'/'.$dataativade[2]);
	}
	if($dataativaate){
		$dataativaate	= explode('/', $dataativaate);
		$dataativaate	= strtotime($dataativaate[1].'/'.$dataativaate[0].'/'.$dataativaate[2]);
	}
	if($dataestornode){
		$dataestornode	= explode('/', $dataestornode);
		$dataestornode	= strtotime($dataestornode[1].'/'.$dataestornode[0].'/'.$dataestornode[2]);
	}
	if($dataestornoate){
		$dataestornoate	= explode('/', $dataestornoate);
		$dataestornoate	= strtotime($dataestornoate[1].'/'.$dataestornoate[0].'/'.$dataestornoate[2]);
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
			Relatório de Faturamento Analítico
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
		$sql = "Select p.cod_polo, c.dsc_cidade from polo p";
		$sql .= " inner join cidade c on p.cod_cidade = c.cod_cidade ";
		$sql .= " where p.cod_polo=".$_REQUEST['cod_polo'];
		$sql .= " Order By c.dsc_cidade ";
		$q = mysql_query($sql);
		$polo = mysql_fetch_array($q);
		echo "Polo: ".$polo['dsc_cidade'];
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
<?	if(!empty($dataenviode)){?>
			<dt>Faixa de Datas de Envio do Contrato para a Claro:</dt>
				<dd><?=date('d/m/Y', $dataenviode);?> até <?=date('d/m/Y', $dataenvioate);?></dd>
<?	}
	if(!empty($dataativade)){?>
			<dt>Faixa de Datas de Ativação:</dt>
				<dd><?=date('d/m/Y', $dataativade);?> até <?=date('d/m/Y', $dataativaate);?></dd>
<?	}
	if(!empty($dataestornode)){?>
			<dt>Faixa de Datas de Estorno:</dt>
				<dd><?=date('d/m/Y', $dataestornode);?> até <?=date('d/m/Y', $dataestornoate);?></dd>
<?	}?>
		</td>
	</tr>
</table>
</td></tr>
<tr><td width="100%">
<table cellspacing="2" cellpadding="2"  align="left"  border="0" class="form">
	<tbody>
<?	$sql = "SELECT e.Vc_Nome Equipe, u.Nome Lider, Tk_Equipe FROM tb_equipesvendas e INNER JOIN usuariosinternos u ON e.Fk_Lider = u.CodUsuarioInterno WHERE 1";
	if($codequipe) $sql .= " AND Tk_Equipe = $codequipe";
	if($cod_polo != 100 && $cod_polo != null) $sql .= " and (u.cod_polo = $cod_polo or u.cod_polo = 100) ";
	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result)){
		$totgeral = array();
		$totgeral['propostas'] = 0;
		$totgeral['valor'] = 0;
		$totgeral['lnovas'] = 0;
		$totgeral['lrenov'] = 0;
		$totgeral['lmigr'] = 0;
		$totgeral['dados'] = 0;
		$totgeral['bberry'] = 0;
		$totgeral['intellis'] = 0;
		$totgeral['bl250'] = 0;
		$totgeral['bl500'] = 0;
		$totgeral['bl1mb'] = 0;
		$totgeral['estorno'] = 0;
		while($row = mysql_fetch_array($result)){ ?>
<?			$totequipe = array();
			$totequipe['propostas'] = 0;
			$totequipe['valor'] = 0;
			$totequipe['lnovas'] = 0;
			$totequipe['lrenov'] = 0;
			$totequipe['lmigr'] = 0;
			$totequipe['dados'] = 0;
			$totequipe['bberry'] = 0;
			$totequipe['intellis'] = 0;
			$totequipe['bl250'] = 0;
			$totequipe['bl500'] = 0;
			$totequipe['bl1mb'] = 0;
			$totequipe['estorno'] = 0;
			$equiper = equipes::get_equipe($row['Tk_Equipe']);
			$i=0;
			while($usr = mysql_fetch_array($equiper)){
				$leadrows = relfatura::get_leads($usr['codusr'], $cod_polo, $dataenviode, $dataenvioate, $dataativade, $dataativaate, $dataestornode, $dataestornoate);
				$tot = array();
				$tot['propostas'] = 0;
				$tot['valor'] = 0;
				$tot['lnovas'] = 0;
				$tot['lrenov'] = 0;
				$tot['lmigr'] = 0;
				$tot['dados'] = 0;
				$tot['bberry'] = 0;
				$tot['intellis'] = 0;
				$tot['bl250'] = 0;
				$tot['bl500'] = 0;
				$tot['bl1mb'] = 0;
				$tot['estorno'] = 0;
				$j=0;
				foreach($leadrows as $numero => $leads){
				if($i==0&&$j==0){
				?><tr><th colspan="20">Equipe: <?=$row['Equipe']?></th></tr><?
				}if($j==0){
				?><tr><th colspan="20">Consultor: <?=$usr['usuario']?></th></tr>
				<tr>
					<td>CNPJ</td>
					<td colspan="2">RAZAO SOCIAL</td>
					<td>PVC</td>
					<td>PLANO</td>
					<td>VALOR PLANO</td>
					<td>MEDIA CTR</td>
					<td>FX REMUN.</td>
					<td>DT ENVIO</td>
					<td>DT ATV</td>
					<td>L. NOVAS</td>
					<td>L. RENOV</td>
					<td>L. MIGR</td>
					<td>DADOS</td>
					<td>BBERRY</td>
					<td>INTELLIS</td>
					<td>BL250</td>
					<td>BL500</td>
					<td>BL1MB</td>
					<td>ESTORNO</td>
				</tr><?
				} ?>
				<tr>
					<td><?=$leads['cnpj'];?></td>
					<td colspan="2"><?=$leads['razaosocial'];?></td>
					<td><?=$leads['pvc'];?></td>
					<td><?=$leads['plano'];?></td>
					<td>R$<?=number_format($leads['valorplano'],2,',','.');?></td>
					<td>R$<?=$leads['mediactr'];?></td>
					<td><?=$leads['fxremun'];?></td>
					<td><?=$leads['dtenvio'];?></td>
					<td><?=$leads['dtatv'];?></td>
					<td><?=$leads['lnovas'];?></td>
					<td><?=$leads['lrenov'];?></td>
					<td><?=$leads['lmigr'];?></td>
					<td><?=$leads['dados'];?></td>
					<td><?=$leads['bberry'];?></td>
					<td><?=$leads['intellis'];?></td>
					<td><?=$leads['bl250'];?></td>
					<td><?=$leads['bl500'];?></td>
					<td><?=$leads['bl1mb'];?></td>
					<td><?=$leads['estorno'];?></td>
				</tr>
				<tr><td colspan="20"><hr></td></tr>
<?					$tot['propostas'] += 1;
					$tot['valor'] += $leads['valorplano'];
					$tot['lnovas'] += $leads['lnovas'];
					$tot['lrenov'] += $leads['lrenov'];
					$tot['lmigr'] += $leads['lmigr'];
					$tot['dados'] += $leads['dados'];
					$tot['bberry'] += $leads['bberry'];
					$tot['intellis'] += $leads['intellis'];
					$tot['bl250'] += $leads['bl250'];
					$tot['bl500'] += $leads['bl500'];
					$tot['bl1mb'] += $leads['bl1mb'];
					$tot['estorno'] += ($leads['estorno']?1:0);
					$j++;
				}
				if($tot['propostas'] > 0){
			?>	<tr>
					<td colspan="2"><b>Totalização por Consultor:</b></td>
					<td colspan="3"><b>Propostas:<?=$tot['propostas'];?></b></td>
					<td colspan="5"><b>R$<?=number_format($tot['valor'],2,',','.');?></b></td>
					<td><b><?=$tot['lnovas'];?></b></td>
					<td><b><?=$tot['lrenov'];?></b></td>
					<td><b><?=$tot['lmigr'];?></b></td>
					<td><b><?=$tot['dados'];?></b></td>
					<td><b><?=$tot['bberry'];?></b></td>
					<td><b><?=$tot['intellis'];?></b></td>
					<td><b><?=$tot['bl250'];?></b></td>
					<td><b><?=$tot['bl500'];?></b></td>
					<td><b><?=$tot['bl1mb'];?></b></td>
					<td><b><?=$tot['estorno'];?></b></td>
				</tr>
				<tr><td colspan="20"><hr></td></tr>
		<?		}
				$totequipe['propostas'] += $tot['propostas'];
				$totequipe['valor'] += $tot['valor'];
				$totequipe['lnovas'] += $tot['lnovas'];
				$totequipe['lrenov'] += $tot['lrenov'];
				$totequipe['lmigr'] += $tot['lmigr'];
				$totequipe['dados'] += $tot['dados'];
				$totequipe['bberry'] += $tot['bberry'];
				$totequipe['intellis'] += $tot['intellis'];
				$totequipe['bl250'] += $tot['bl250'];
				$totequipe['bl500'] += $tot['bl500'];
				$totequipe['bl1mb'] += $tot['bl1mb'];
				$totequipe['estorno'] += $tot['estorno'];
				$i++;
			}
			if($totequipe['propostas'] > 0){
		?>	<tr>
				<td colspan="2"><b>Totalização por Equipe:</b></td>
				<td colspan="3"><b>Propostas:<?=$totequipe['propostas'];?></b></td>
				<td colspan="5"><b>R$<?=number_format($totequipe['valor'],2,',','.');?></b></td>
				<td><b><?=$totequipe['lnovas'];?></b></td>
				<td><b><?=$totequipe['lrenov'];?></b></td>
				<td><b><?=$totequipe['lmigr'];?></b></td>
				<td><b><?=$totequipe['dados'];?></b></td>
				<td><b><?=$totequipe['bberry'];?></b></td>
				<td><b><?=$totequipe['intellis'];?></b></td>
				<td><b><?=$totequipe['bl250'];?></b></td>
				<td><b><?=$totequipe['bl500'];?></b></td>
				<td><b><?=$totequipe['bl1mb'];?></b></td>
				<td><b><?=$totequipe['estorno'];?></b></td>
			</tr>
			<tr><td colspan="20"><hr></td></tr><?
			}
			$totgeral['propostas'] += $totequipe['propostas'];
			$totgeral['valor'] += $totequipe['valor'];
			$totgeral['lnovas'] += $totequipe['lnovas'];
			$totgeral['lrenov'] += $totequipe['lrenov'];
			$totgeral['lmigr'] += $totequipe['lmigr'];
			$totgeral['dados'] += $totequipe['dados'];
			$totgeral['bberry'] += $totequipe['bberry'];
			$totgeral['intellis'] += $totequipe['intellis'];
			$totgeral['bl250'] += $totequipe['bl250'];
			$totgeral['bl500'] += $totequipe['bl500'];
			$totgeral['bl1mb'] += $totequipe['bl1mb'];
			$totgeral['estorno'] += $totequipe['estorno'];
		}
	?>	<tr>
			<td colspan="2"><b>Totalização Geral:</b></td>
			<td colspan="3"><b>Propostas:<?=$totgeral['propostas'];?></b></td>
			<td colspan="5"><b>R$<?=number_format($totgeral['valor'],2,',','.');?></b></td>
			<td><b><?=$totgeral['lnovas'];?></b></td>
			<td><b><?=$totgeral['lrenov'];?></b></td>
			<td><b><?=$totgeral['lmigr'];?></b></td>
			<td><b><?=$totgeral['dados'];?></b></td>
			<td><b><?=$totgeral['bberry'];?></b></td>
			<td><b><?=$totgeral['intellis'];?></b></td>
			<td><b><?=$totgeral['bl250'];?></b></td>
			<td><b><?=$totgeral['bl500'];?></b></td>
			<td><b><?=$totgeral['bl1mb'];?></b></td>
			<td><b><?=$totgeral['estorno'];?></b></td>
		</tr>
		<tr><td colspan="20"><hr></td></tr><?
	}else{ ?>
		<tr>
			<th>A equipe selecionada não pertence ao polo selecionado.</th>
		</tr>
<?	}
	mysql_free_result($result);
?>
	</tbody>
  </table>
</td></tr>
</table>
</body>
</html>