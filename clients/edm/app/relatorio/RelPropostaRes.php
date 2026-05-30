<?	include_once "libs/maininclude.php";
	include_once "libs/datas.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?	$gerenteconta = null;
	$sql = "Select p.CodProposta, p.Versao, p.CodLead, pr.Nome NomeProduto, l.RazaoSocial, l.CodGerenteConta, u.Nome GerenteConta, date_format(p.DataEnvio, '%d/%m/%Y') DataEnvio, date_format(p.DataPrevisaoRecebimento, '%d/%m/%Y') DataPrevisaoRecebimento, date_format(p.DataRecebimento, '%d/%m/%Y') DataRecebimento, date_format(p.DataEnvioContrato, '%d/%m/%Y') DataEnvioContrato, date_format(p.DataRecebimentoContrato, '%d/%m/%Y') DataRecebimentoContrato";
	$sql .= " From propostas p";
	$sql .= " inner join leads l on p.CodLead = l.CodLead";
	$sql .= " inner join produtos pr on p.CodProduto = pr.CodProduto";
	$sql .= " left join usuariosinternos u on l.CodGerenteConta = u.CodUsuarioInterno";
	$sql .= " Where 1";
	
	if(!empty($_REQUEST['codgerenteconta'])){
		$gerenteconta = $_REQUEST['codgerenteconta'];
		$sql .= " And u.CodUsuarioInterno = ".$gerenteconta;	
	}
	
	if($GerenteContas && !permissao('leadoutrogerente', 'al')){
		$gerenteconta = $_SESSION['codusuario'];
		$sql .= " And u.CodUsuarioInterno = ".$gerenteconta;	
	}
	
	if(!empty($_REQUEST['dataenviode']) && !empty($_REQUEST['dataenvioate'])){
		$dataenviode = dataYMD($_REQUEST['dataenviode']);
		$dataenvioate = dataYMD($_REQUEST['dataenvioate']);
		$sql .= " And p.DataEnvio Between '".$dataenviode . " 00:00:00' AND '" . $dataenvioate . " 23:59:59'";	
//	}else{
//		$sql .= " And p.DataEnvio Is Null";	
	}
	if(!empty($_REQUEST['canceladas'])){
		$sql .= " And p.DataCancelamento Is Null";
	}
	
	if(!empty($_REQUEST['dataprevisaode']) && !empty($_REQUEST['dataprevisaoate'])){
		$dataprevisaode = dataYMD($_REQUEST['dataprevisaode']);
		$dataprevisaoate = dataYMD($_REQUEST['dataprevisaoate']);
		$sql .= " And p.DataPrevisaoRecebimento Between '".$dataprevisaode . " 00:00:00' AND '" . $dataprevisaoate . " 23:59:59'";	
//	}else{
//		$sql .= " And p.DataPrevisaoRecebimento Is Null";	
	}
	if(!empty($_REQUEST['datarecebimentode']) && !empty($_REQUEST['datarecebimentoate'])){
		$datarecebimentode = dataYMD($_REQUEST['datarecebimentode']);
		$datarecebimentoate = dataYMD($_REQUEST['datarecebimentoate']);
		$sql.= " AND p.DataRecebimento BETWEEN '" . $datarecebimentode . " 00:00:00' AND '" . $datarecebimentoate . " 23:59:59'";
//	}else{
//		$sql .= " And p.DataRecebimento Is Null";
	}
	$sql .= " Order By GerenteConta, RazaoSocial"; 
	$result = sql_query($sql);?>
<html>
<head>
	<title>Relatório de Propostas</title>
<?	include_once "libs/head.php";?>
</head>
<body>
	<h2>Relatório de Propostas</h2>
	<br/>
	<br/>
	<h3>Parâmetros</h3>
	<p>
		<dl>
<?	if(!empty($gerenteconta)){?>
			<dt>Consultor:</dt>
<?		$sql = "Select Nome From usuariosinternos Where CodUsuarioInterno = $gerenteconta";
		$res1 = sql_query($sql);
		while($row = mysql_fetch_array($res1)){?>
				<dd><?=$row['Nome'];?></dd>
<?		}
		mysql_free_result($res1);
	}
	if(!empty($dataenviode) && !empty($dataenvioate)){?>
			<dt>Data de envio: <?=$_REQUEST['dataenviode'];?> - <?=$_REQUEST['dataenvioate'];?></dt>
<?	}
	if(!empty($dataprevisaode) && !empty($dataprevisaoate)){?>
			<dt>Data de previsão de recebimento: <?=$_REQUEST['dataprevisaode'];?> - <?=$_REQUEST['dataprevisaoate'];?></dt>
<?	}
	if(!empty($datarecebimentode) && !empty($datarecebimentoate)){?>
			<dt>Data de recebimento: <?=$_REQUEST['datarecebimentode'];?> - <?=$_REQUEST['datarecebimentoate'];?></dt>
<?	}?>
		</dl>
	</p>
	<h4>Relatório gerado em <?=date('d/m/Y', mktime());?> às <?=date('H:i', mktime())?></h4>
	<table style="width:100%;margin-bottom:20px" border="0" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>Gerente Conta</th>
				<th>Núm.Ver</th>
				<th>Razão Social</th>
				<th>Valor</th>
				<th>Nº Linhas</th>
				<th>Envio</th>
				<th>Previsão</th>
				<th>Recebimento</th>
				<th>Envio Contrato</th>
				<th>Recebimento Contrato</th>
			</tr>
		</thead>
		<tbody>
<?	$cont = 0;
	$totalvalor = 0;
	$totallinhas = 0;
	while($row = mysql_fetch_array($result)){
		$cont++;
		$totalvalor += moduloProposta($row['CodProposta'], $row['Versao'], $row['CodLead'], 'totalproposta');
		$totallinhas += moduloProposta($row['CodProposta'], $row['Versao'], $row['CodLead'], 'qtdelinhas', 'chave');
?>
			<tr>
				<td><?=$row['GerenteConta'];?></td>
				<td><?=$row['CodProposta'].'.'.$row['Versao'].'<br />'.$row['NomeProduto'];?></td>
				<td><?=$row['RazaoSocial'];?></td>
				<td style="text-align:right">R$&nbsp;<?=number_format(moduloProposta($row['CodProposta'], $row['Versao'], $row['CodLead'], 'totalproposta'), 2, ",", ".");?></td>
				<td style="text-align:right"><?=moduloProposta($row['CodProposta'], $row['Versao'], $row['CodLead'], 'qtdelinhas', 'chave');?></td>
				<td><?=$row['DataEnvio'];?></td>
				<td><?=$row['DataPrevisaoRecebimento'];?></td>
				<td><?=$row['DataRecebimento'];?></td>
				<td><?=$row['DataEnvioContrato'];?></td>
				<td><?=$row['DataRecebimentoContrato'];?></td>
			</tr>
<?	}
	mysql_free_result($result);?>
		</tbody>
		<tfoot>
			<tr>
				<th>Total</th>
				<th colspan="2"><?=$cont;?> Proposta(s)</th>
				<th style="text-align:right">R$&nbsp;<?=number_format($totalvalor, 2, ",", ".");?></th>
				<th style="text-align:right"><?=$totallinhas;?></th>
				<th colspan="5">&nbsp;</th>
			</tr>
		</tfoot>
	</table>
</body>
</html>