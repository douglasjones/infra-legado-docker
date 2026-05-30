<?php


// Configurações header para forçar o download
	$arquivo = 'planilha.xls';
	
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/x-msexcel");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
	
	$ano = $_REQUEST['ano'];
	$mes = $_REQUEST['mes'];
	$dataref = $ano.$mes;
	$cod_polo = $_REQUEST['cod_polo'];
	$cod_operadora = $_REQUEST['cod_operadora'];
	
$parametros = "ano=$ano&mes=$mes&cod_polo=$cod_polo&cod_operadora=$cod_operadora";

include_once "../../libs/maininclude.php";
	
?>
<html>
<head>
	<title></title>
</head>
<body leftmargin="10" topmargin="10" marginwidth="0" marginheight="0">

<table align="center">
	<tr>
		<td class="form"><font size="4">Vencimento Contratos</font></td>
	</tr>
</table>
<table>
	<tr>
		<td class="form">
			<b>Parâmetros:</b><br><br>
			
			Pólo: <?= $polo;?><br>
			Mês/Ano: <?= $mes;?> / <?= $ano;?>
		</td>
	</tr>
</table>

<table width="100%" border="1" cellpadding="0" cellspacing="0">
	<tr>
		<th class="titulo" bgcolor="#8080FF">
			Pólo
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Cód. Cliente
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Razão Social
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Data Vencimento
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Operadora
		</th>		
	</tr>
<?
	$total = 0;

	$sql ="";
	$sql.="select l.codlead, l.razaosocial, date_format(l.vencimentocontrato,'%d/%m/%Y') vencimentocontrato, p.dsc_cidade ";
	$sql.="  from leads l ";
	$sql.="       left join (select po.cod_polo, c.dsc_cidade from polo po inner join cidade c on po.cod_cidade = c.cod_cidade) p on l.cod_polo = p.cod_polo ";
	$sql.=" where date_format(l.vencimentocontrato,'%Y%m') = '$dataref' ";
	
	if(!empty($cod_polo) && $cod_polo != 100)
		$sql.=" and l.cod_polo = $cod_polo ";
		
	if(!empty($cod_operadora)){
		$sql.=" and l.codlead in (";
		$sql.="  select lo.codlead ";
		$sql.="    from leads_operadoras lo ";
		$sql.="   where lo.cod_operadora = $cod_operadora ";
		$sql.=" ) ";
	}
	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td align='center' class='form'>".$row['dsc_cidade']."</td>";
		echo "<td align='center' class='form'>".$row['codlead']."</td>";
		echo "<td align='center' class='form'><a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['razaosocial']."</a></td>";
		echo "<td align='center' class='form'>&nbsp;".$row['vencimentocontrato']."</td>";
		
		echo "<td align='center' class='form'>&nbsp;";
		//pesquisa todas as operadoras do lead
		$sql ="";
		$sql.="select o.dsc_operadora ";
		$sql.="  from leads_operadoras lo ";
		$sql.="       inner join operadoras o on o.cod_operadora = lo.cod_operadora ";
		$sql.=" where lo.codlead = ".$row['codlead'];
		$rs_operadora = mysql_query($sql);
		while($row_operadora = mysql_fetch_array($rs_operadora)){
			echo $row_operadora['dsc_operadora']."<br>";
		}
		mysql_free_result($rs_operadora);
		echo "</td>";
		
		echo "</tr>";
		
		$total ++;
	}
	mysql_free_result($result);
?>
	<tr>
		<th class="titulo" bgcolor="#8080FF" colspan="5">
			<?= $total;?> registro(s)
		</th>
	</tr>
</table>
</body>
<?
include_once "../../libs/desconectar.php";
?>
