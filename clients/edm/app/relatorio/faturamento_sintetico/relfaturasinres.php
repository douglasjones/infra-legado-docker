<?
    /*
Pagina:relfaturasinres.php
modulo:Relatorios

Dados de criação
Criação: 15/09/2008
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
    <link rel="stylesheet" href="../../libs/public1.css" type="text/css">
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
			Relatório de Faturamento Sintético
		</td>
	</tr>
</table>
</td></tr>
<tr><td width="100%">
<table width="800" align="left"  height="30"    cellpadding="0" cellspacing="0">
	<tr>
		 <td>&nbsp; 
			
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
<table width="800" align="left"  height="30" cellpadding="0" cellspacing="0">
	<tr>
		<td>&nbsp; 
		</td>	
	</tr>
</table>	
</td></tr>
<tr><td width="100%">
<table cellspacing="0" cellpadding="0" align="left" width="800" border="0">
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
<table cellspacing="2" cellpadding="2" align="left" width="800" border="0" class="form">
	<tbody>
<?	$sql = "SELECT e.Vc_Nome Equipe, u.Nome Lider, Tk_Equipe FROM tb_equipesvendas e INNER JOIN usuariosinternos u ON e.Fk_Lider = u.CodUsuarioInterno WHERE 1";
	if($codequipe) $sql .= " AND Tk_Equipe = $codequipe";
	if($cod_polo != 100 && $cod_polo != null) $sql .= " and (u.cod_polo = $cod_polo or u.cod_polo = 100) ";
	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result)){
		$totgeral = array();
		while($row = mysql_fetch_array($result)){ ?>
<?			$totequipe = array();
			$equiper = equipes::get_equipe($row['Tk_Equipe']);
			$j=0;
			while($usr = mysql_fetch_array($equiper)){
				$valores = relfatura::sintetico($usr['codusr'], $cod_polo, $dataenviode, $dataenvioate, $dataativade, $dataativaate, $dataestornode, $dataestornoate);
				if($valores['i'] > 0){
					if($j==0){
					?><tr><th colspan="16" align="left">Equipe: <?=$row['Equipe']?></th></tr><?
					}
				?><tr><th colspan="16" align="left">Consultor: <?=$usr['usuario']?></th></tr><?
?>				<tr>
					<td>L. NOVAS</td>
					<td>L. RENOV</td>
					<td>L. MIGR</td>
					<td>10MB</td>
					<td>40MB</td>
					<td>100MB</td>
					<td>500MB</td>
					<td>2000MB</td>
					<td>20GB</td>
					<td>BBERRY</td>
					<td>INTELLIS</td>
					<td>BL250</td>
					<td>BL500</td>
					<td>BL1MB</td>
					<td>ESTORNO</td>
				</tr>
				<tr>
					<td><?=$valores['lnovas'];?></td>
					<td><?=$valores['lrenov'];?></td>
					<td><?=$valores['lmigr'];?></td>
					<td><?=$valores['10mb'];?></td>
					<td><?=$valores['40mb'];?></td>
					<td><?=$valores['100mb'];?></td>
					<td><?=$valores['500mb'];?></td>
					<td><?=$valores['2000mb'];?></td>
					<td><?=$valores['20gb'];?></td>
					<td><?=$valores['bberry'];?></td>
					<td><?=$valores['intellis'];?></td>
					<td><?=$valores['bl250'];?></td>
					<td><?=$valores['bl500'];?></td>
					<td><?=$valores['bl1mb'];?></td>
					<td><?=$valores['estorno'];?></td>
				</tr><?
				}
				foreach($valores as $coluna => $valor) $totequipe[$coluna] += $valor;
				$i++;
			}
			if($totequipe['i'] > 0){
		?>	<tr>
				<th colspan="16">Totalização por Equipe:</th>
			</tr>
			<tr>
				<td>L. NOVAS</td>
				<td>L. RENOV</td>
				<td>L. MIGR</td>
				<td>10MB</td>
				<td>40MB</td>
				<td>100MB</td>
				<td>500MB</td>
				<td>2000MB</td>
				<td>20GB</td>
				<td>BBERRY</td>
				<td>INTELLIS</td>
				<td>BL250</td>
				<td>BL500</td>
				<td>BL1MB</td>
				<td>ESTORNO</td>
			</tr>
			<tr>
				<td><?=$totequipe['lnovas'];?></td>
				<td><?=$totequipe['lrenov'];?></td>
				<td><?=$totequipe['lmigr'];?></td>
				<td><?=$totequipe['10mb'];?></td>
				<td><?=$totequipe['40mb'];?></td>
				<td><?=$totequipe['100mb'];?></td>
				<td><?=$totequipe['500mb'];?></td>
				<td><?=$totequipe['2000mb'];?></td>
				<td><?=$totequipe['20gb'];?></td>
				<td><?=$totequipe['bberry'];?></td>
				<td><?=$totequipe['intellis'];?></td>
				<td><?=$totequipe['bl250'];?></td>
				<td><?=$totequipe['bl500'];?></td>
				<td><?=$totequipe['bl1mb'];?></td>
				<td><?=$totequipe['estorno'];?></td>
			</tr><?
			}
			foreach($totequipe as $coluna => $valor) $totgeral[$coluna] += $valor;
		}
		?>	<tr>
				<th colspan="16">Totalização Geral:</th>
			</tr>
			<tr>
				<td>L. NOVAS</td>
				<td>L. RENOV</td>
				<td>L. MIGR</td>
				<td>10MB</td>
				<td>40MB</td>
				<td>100MB</td>
				<td>500MB</td>
				<td>2000MB</td>
				<td>20GB</td>
				<td>BBERRY</td>
				<td>INTELLIS</td>
				<td>BL250</td>
				<td>BL500</td>
				<td>BL1MB</td>
				<td>ESTORNO</td>
			</tr>
			<tr>
				<td><?=$totgeral['lnovas'];?></td>
				<td><?=$totgeral['lrenov'];?></td>
				<td><?=$totgeral['lmigr'];?></td>
				<td><?=$totgeral['10mb'];?></td>
				<td><?=$totgeral['40mb'];?></td>
				<td><?=$totgeral['100mb'];?></td>
				<td><?=$totgeral['500mb'];?></td>
				<td><?=$totgeral['2000mb'];?></td>
				<td><?=$totgeral['20gb'];?></td>
				<td><?=$totgeral['bberry'];?></td>
				<td><?=$totgeral['intellis'];?></td>
				<td><?=$totgeral['bl250'];?></td>
				<td><?=$totgeral['bl500'];?></td>
				<td><?=$totgeral['bl1mb'];?></td>
				<td><?=$totgeral['estorno'];?></td>
			</tr><?
	}else{ ?>
		<tr>
			<th>A equipe selecionada não pertence ao polo selecionado.</th>
		</tr>
<?	}
	mysql_free_result($result);
?>
	</tbody>
	<tfoot>
		<tr>
			<th>
			</th>
		</tr>
  </tfoot>
  </table>
</td></tr>
</table>
</body>
</html>