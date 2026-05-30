<?
include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";

$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i:%s') horaatual ";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$horaatual = $row['horaatual'];
mysql_free_result($result);

$codgerenteconta = $_REQUEST['codgerenteconta'];
$dt_base_ini = $_REQUEST['dt_base_ini'];
$dt_base_fim = $_REQUEST['dt_base_fim'];


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
		<font size="+2">Produtividade Comercial Resumo</font>
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

	if(!empty($dt_base_ini)){
		?>
		<tr>
			<td>Data Base (Início): <?= $dt_base_ini;?></td>
		</tr>
		<?
	}
	if(!empty($dt_base_fim)){
		?>
		<tr>
			<td>Data Base (Fim): <?= $dt_base_fim;?></td>
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
<table cellspacing="0" cellpadding="0" align="center" border="1" width="100%" class="sortable">
	<thead>
	<tr  class="titulo" bgcolor="#8080FF">
			<th>
				Consultor
			</th>
			<th>
				Prospecções
			</th>						
			<th>
				Oportunidades
			</th>
			<th>
				O.C.
			</th>
			<th>
				Visitas
			</th>
			<th>
				Qtde Propostas Enviadas
			</th>
			<th>
				Propostas Enviadas
			</th>		
			<th>
				Qtde Previsão Fechamento
			</th>
			<th>
				Previsão Fechamento (75%)
			</th>				
			<th>
				Forecast (80%)
			</th>							
			<th>
				Forecast (85%)
			</th>						
			<th>
				Forecast (90%)
			</th>						
			<th>
				Cliente (100%)
			</th>									
	</tr>
	</thead>
	<tbody>
	<?
	
	$total_prospeccoes = 0;
	$total_oportunidades = 0;
	$total_oc = 0;
	$total_visitas = 0;
	$total_pe = 0;
	$total_valor_pe = 0;
	$total_pf = 0;
	$total_valor_pf = 0;
	
	$total_valor_ra = 0;
	$total_valor_a = 0;
	$total_valor_eco = 0;	
	$total_valor_ea = 0;
	
	//Pega o nome dos consultores ativos
	$sql ="";
	$sql.="select ui.codusuariointerno, ui.nome ";
	$sql.="  from usuariosinternos ui ";
	$sql.=" where ui.desativado = -1 ";
	$sql.="   and ui.gerentecontas = 1 ";
	
	if(!empty($codgerenteconta))
		$sql.=" and ui.codusuariointerno = $codgerenteconta ";
		
	$sql.=" order by ui.nome ";
	
	$result = mysql_query($sql);
	$cor = 0;
	
	while($row = mysql_fetch_array($result)){
		
		if ($cor == 0){
			echo "<tr class='linha'>";
			$cor = 1;
		}
		else{
			echo "<tr class='linha1'>";
			$cor = 0;
		}
		echo "<td class='form' >".$row['nome']."</td>";
		
		$sql ="";
		$sql.="select l.codlead  ";
		$sql.="  from leads l ";
		$sql.="       inner join contatoslead cl on l.codlead = cl.codlead ";
		$sql.=" where l.datacadastro between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";					
		$sql.="   and l.usuariocadastro = ".$row['codusuariointerno'];
		$sql.=" group by l.codlead ";
		
		$rs_item = mysql_query($sql);
		$num = mysql_num_rows($rs_item);
		echo "<td class='form' align='center'>".$num."</td>";
		$total_prospeccoes += $num;
		mysql_free_result($rs_item);

		$sql ="";
		$sql.="select count(0) total ";
		$sql.="  from ocorrenciaslead oc ";
		$sql.=" where codtipoocorrencialead = 5000 ";
		$sql.="   and oc.datacadastro between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";					
		$sql.="   and oc.codusuariointerno = ".$row['codusuariointerno'];
		$rs_item = mysql_query($sql);
		$row_oportunidade = mysql_fetch_array($rs_item);
		echo "<td  class='form' align='center'>".$row_oportunidade['total']."</td>";
		$total_oportunidades += $row_oportunidade['total'];
		mysql_free_result($rs_item);
		
		$sql ="";
		$sql.="select count(0) total ";
		$sql.="  from ocorrenciaslead oc ";
		$sql.=" where oc.datacadastro between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";					
		$sql.="   and oc.codusuariointerno = ".$row['codusuariointerno'];
		$sql.="   and oc.codtipoocorrencialead <> 77 ";
		$rs_item = mysql_query($sql);
		$row_oportunidade = mysql_fetch_array($rs_item);
		echo "<td class='form'  align='center'>".$row_oportunidade['total']."</td>";
		$total_oc += $row_oportunidade['total'];
		mysql_free_result($rs_item);					

		$sql ="";
		$sql.="select count(0) total  ";
		$sql.="  from agendaslead al  ";
		$sql.="		inner join agendagerenteconta agc on al.codagendalead = agc.codagendalead ";
		$sql.=" where (al.codstatus not in (3, 4) or al.codstatus is null) ";
		$sql.="   and agc.codgerenteconta = ".$row['codusuariointerno'];
		$sql.="   and al.datacadastro between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";
		$sql.="   and al.codreagendamento is null ";
		$rs_item = mysql_query($sql);
		$row_oportunidade = mysql_fetch_array($rs_item);
		echo "<td class='form'  align='center'>".$row_oportunidade['total']."</td>";
		$total_visitas += $row_oportunidade['total'];
		mysql_free_result($rs_item);					
		
		$sql ="";		
		$sql.="select p.codproposta	";
		$sql.="  from leads l ";
		$sql.="	      inner join propostas p on l.codlead = p.codlead	";
		$sql.="       inner join data_proposta dp on p.codproposta = dp.codproposta and p.versao = dp.versao and p.codlead = dp.codlead and dp.nome_data = 'envio_lead'	";
		$sql.="        left join data_proposta dp1 on p.codproposta = dp1.codproposta and p.versao = dp1.versao and p.codlead = dp1.codlead and dp1.nome_data = 'previsao_recebe_assinatura'	";
		$sql.=" where dp.valor_data between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";
		$sql.="   and dp1.valor_data is null ";
		$sql.="   and l.codgerenteconta = ".$row['codusuariointerno'];
		$sql.=" group by p.codproposta ";

		$rs_proposta = mysql_query($sql);
		$num = mysql_num_rows($rs_proposta);
		echo "<td class='form'  align='center'>".$num."</td>";
		$total_pe += $num;
		mysql_free_result($rs_proposta);		
		
		$sql ="";		
		$sql.="select ifnull(sum(p.totalproposta),0) valor	";
		$sql.="  from leads l 	";
		$sql.="	      inner join propostas p on l.codlead = p.codlead	";
		$sql.="       inner join data_proposta dp on p.codproposta = dp.codproposta and p.versao = dp.versao and p.codlead = dp.codlead and dp.nome_data = 'envio_lead'	";
		$sql.="        left join data_proposta dp1 on p.codproposta = dp1.codproposta and p.versao = dp1.versao and p.codlead = dp1.codlead and dp1.nome_data = 'previsao_recebe_assinatura'	";
		$sql.=" where dp.valor_data between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";
		$sql.="   and dp1.valor_data is null ";
		$sql.="   and l.codgerenteconta = ".$row['codusuariointerno'];
		$rs_proposta = mysql_query($sql);
		$row_proposta = mysql_fetch_array($rs_proposta);
		echo "<td class='form'  align='right'>".number_format($row_proposta['valor'],2,',','.')."</td>";
		$total_valor_pe += $row_proposta['valor'];
		mysql_free_result($rs_proposta);		
		
		$sql ="";		
		$sql.="select p.codproposta	";
		$sql.="  from leads l ";
		$sql.="	      inner join propostas p on l.codlead = p.codlead	";
		$sql.="       inner join data_proposta dp on p.codproposta = dp.codproposta and p.versao = dp.versao and p.codlead = dp.codlead and dp.nome_data = 'envio_lead'	";
		$sql.="       inner join data_proposta dp1 on p.codproposta = dp1.codproposta and p.versao = dp1.versao and p.codlead = dp1.codlead and dp1.nome_data = 'previsao_recebe_assinatura'	";
		$sql.=" where dp1.valor_data between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";
		$sql.="   and l.codgerenteconta = ".$row['codusuariointerno'];		
		$sql.=" group by p.codproposta ";

		$rs_proposta = mysql_query($sql);
		$num = mysql_num_rows($rs_proposta);
		echo "<td class='form'  align='center'>".$num."</td>";
		$total_pf += $num;		
		mysql_free_result($rs_proposta);		
		
		
		$sql ="";		
		$sql.="select ifnull(sum(p.totalproposta),0) valor	";
		$sql.="  from leads l 	";
		$sql.="	      inner join propostas p on l.codlead = p.codlead	";
		$sql.="       inner join data_proposta dp on p.codproposta = dp.codproposta and p.versao = dp.versao and p.codlead = dp.codlead and dp.nome_data = 'envio_lead'	";
		$sql.="       inner join data_proposta dp1 on p.codproposta = dp1.codproposta and p.versao = dp1.versao and p.codlead = dp1.codlead and dp1.nome_data = 'previsao_recebe_assinatura'	";
		$sql.=" where dp1.valor_data between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";
		$sql.="   and l.codgerenteconta = ".$row['codusuariointerno'];				
		$rs_proposta = mysql_query($sql);
		$row_proposta = mysql_fetch_array($rs_proposta);
		echo "<td class='form'  align='right'>".number_format($row_proposta['valor'],2,',','.')."</td>";
		$total_valor_pf += $row_proposta['valor'];
		mysql_free_result($rs_proposta);		
		
		$sql ="";		
		$sql.="select ifnull(sum(p.totalproposta),0) valor	";
		$sql.="  from leads l 	";
		$sql.="	      inner join propostas p on l.codlead = p.codlead	";
		$sql.="       inner join data_proposta dp on p.codproposta = dp.codproposta and p.versao = dp.versao and p.codlead = dp.codlead and dp.nome_data = 'envio_lead'	";
		$sql.="       inner join data_proposta dp1 on p.codproposta = dp1.codproposta and p.versao = dp1.versao and p.codlead = dp1.codlead and dp1.nome_data = 'recebe_assinatura'	";
		$sql.=" where dp1.valor_data between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";
		$sql.="   and l.codgerenteconta = ".$row['codusuariointerno'];				
		$rs_proposta = mysql_query($sql);
		$row_proposta = mysql_fetch_array($rs_proposta);
		echo "<td class='form'  align='right'>".number_format($row_proposta['valor'],2,',','.')."</td>";
		$total_valor_ra += $row_proposta['valor'];
		mysql_free_result($rs_proposta);				
		
		$sql ="";		
		$sql.="select ifnull(sum(p.totalproposta),0) valor	";
		$sql.="  from leads l 	";
		$sql.="	      inner join propostas p on l.codlead = p.codlead	";
		$sql.="       inner join data_proposta dp on p.codproposta = dp.codproposta and p.versao = dp.versao and p.codlead = dp.codlead and dp.nome_data = 'envio_lead'	";
		$sql.="       inner join data_proposta dp1 on p.codproposta = dp1.codproposta and p.versao = dp1.versao and p.codlead = dp1.codlead and dp1.nome_data = 'auditoria'	";
		$sql.=" where dp1.valor_data between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";
		$sql.="   and l.codgerenteconta = ".$row['codusuariointerno'];				
		$rs_proposta = mysql_query($sql);
		$row_proposta = mysql_fetch_array($rs_proposta);
		echo "<td class='form'  align='right'>".number_format($row_proposta['valor'],2,',','.')."</td>";
		$total_valor_a += $row_proposta['valor'];
		mysql_free_result($rs_proposta);		
		
		$sql ="";		
		$sql.="select ifnull(sum(p.totalproposta),0) valor	";
		$sql.="  from leads l 	";
		$sql.="	      inner join propostas p on l.codlead = p.codlead	";
		$sql.="       inner join data_proposta dp on p.codproposta = dp.codproposta and p.versao = dp.versao and p.codlead = dp.codlead and dp.nome_data = 'envio_lead'	";
		$sql.="       inner join data_proposta dp1 on p.codproposta = dp1.codproposta and p.versao = dp1.versao and p.codlead = dp1.codlead and dp1.nome_data = 'envio_contrato_operadora'	";
		$sql.=" where dp1.valor_data between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";
		$sql.="   and l.codgerenteconta = ".$row['codusuariointerno'];				
		$rs_proposta = mysql_query($sql);
		$row_proposta = mysql_fetch_array($rs_proposta);
		echo "<td class='form'  align='right'>".number_format($row_proposta['valor'],2,',','.')."</td>";
		$total_valor_eco += $row_proposta['valor'];
		mysql_free_result($rs_proposta);				
		
		$sql ="";		
		$sql.="select ifnull(sum(p.totalproposta),0) valor	";
		$sql.="  from leads l 	";
		$sql.="	      inner join propostas p on l.codlead = p.codlead	";
		$sql.="       inner join data_proposta dp on p.codproposta = dp.codproposta and p.versao = dp.versao and p.codlead = dp.codlead and dp.nome_data = 'envio_lead'	";
		$sql.="       inner join data_proposta dp1 on p.codproposta = dp1.codproposta and p.versao = dp1.versao and p.codlead = dp1.codlead and dp1.nome_data = 'entrega_aparelho'	";
		$sql.=" where dp1.valor_data between '".DataYMD($dt_base_ini)." 00:00:00' and  '".DataYMD($dt_base_fim)." 23:59:59' ";
		$sql.="   and l.codgerenteconta = ".$row['codusuariointerno'];				
		$rs_proposta = mysql_query($sql);
		$row_proposta = mysql_fetch_array($rs_proposta);
		echo "<td class='form'  align='right'>".number_format($row_proposta['valor'],2,',','.')."</td>";
		$total_valor_ea += $row_proposta['valor'];
		mysql_free_result($rs_proposta);		
		
		echo "</tr>";		
						
	}
	mysql_free_result($result);
	
	?>
	</tbody>
	<tfoot>
		<tr  class="titulo" bgcolor="#8080FF">
			<th>
				Total:
			</th>
			<th>
				<?= $total_prospeccoes;?>
			</th>						
			<th>
				<?= $total_oportunidades;?>
			</th>
			<th>
				<?= $total_oc;?>
			</th>
			<th>
				<?= $total_visitas;?>
			</th>
			<th>
				<?= $total_pe;?>
			</th>
			<th align='right'>
				<?= number_format($total_valor_pe,2,',','.');?>
			</th>		
			<th>
				<?= $total_pf;?>
			</th>
			<th align='right'>
				<?= number_format($total_valor_pf,2,',','.');?>
			</th>		
			<th align='right'>
				<?= number_format($total_valor_ra,2,',','.');?>
			</th>		
			<th align='right'>
				<?= number_format($total_valor_a,2,',','.');?>
			</th>		
			<th align='right'>
				<?= number_format($total_valor_eco,2,',','.');?>
			</th>					
			<th align='right'>
				<?= number_format($total_valor_ea,2,',','.');?>
			</th>								
		</tr>			
	</tfoot>
</table>
	
</body>
</html>
<?
include_once "../../libs/desconectar.php";
?>
