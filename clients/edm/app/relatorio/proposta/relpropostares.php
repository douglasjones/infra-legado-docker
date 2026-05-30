<?

    /*

Pagina:relpropostares.php

modulo:Relatorios



Dados de criação

Criação:

Empresa:

Executor



Histórico das Revisões:

 Criação: 26/06/2008

 Empresa:

 Executor RINALDO PELIGRINELI



Histórico de Auditorias:

 Criação: 16/04/2008

 Empresa:

 Executor FELIPE SANTOS

 */

/*

 Includes

*/



    include_once "../../libs/maininclude.php";

	include_once "../../libs/datas.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?	$gerenteconta = null;

	$sql = "Select p.CodProposta, p.Versao, p.CodLead, pr.Nome NomeProduto, l.RazaoSocial, l.CodGerenteConta, u.Nome GerenteConta, date_format(p.DataEnvio, '%d/%m/%Y') DataEnvio, date_format(p.DataPrevisaoRecebimento, '%d/%m/%Y') DataPrevisaoRecebimento, date_format(p.DataRecebimento, '%d/%m/%Y') DataRecebimento, date_format(p.DataEnvioContrato, '%d/%m/%Y') DataEnvioContrato, date_format(p.DataRecebimentoContrato, '%d/%m/%Y') DataRecebimentoContrato";

	$sql .= " From propostas p";

	$sql .= " inner join leads l on p.CodLead = l.CodLead";

	$sql .= " inner join produtos pr on p.CodProduto = pr.CodProduto";

	$sql .= " left join usuariosinternos u on l.CodGerenteConta = u.CodUsuarioInterno";

	$sql .= " Where 1";

	

	if(!empty($_REQUEST['cod_polo']) && $_REQUEST['cod_polo'] != 100){

		$sql .= " And l.cod_polo = ".$_REQUEST['cod_polo'];

	}

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

    <!--Include CSS-->

    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">

    

     <!--Cabeçalho-->

	<title>Relatório de Propostas</title>

<?	include_once "../../libs/head.php";?>

</head>

<!--HTML-->

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">



<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">

	<tr>

		 <td  class="titulo"> 

			Relatório de Propostas

		</td>

	</tr>

</table>	

<table width="100%" align="center"  height="30"    cellpadding="0" cellspacing="0">

	<tr>

		 <td  >&nbsp; 

			

		</td>	

	</tr>

</table>	

<table width="100%"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">

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

<table width="800" align="center"  height="100%"    cellpadding="0" cellspacing="0">

	<tr>

		 <td  >&nbsp; 

			

		</td>	

	</tr>

</table>	

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



<table cellspacing="0" cellpadding="0" align="center" width="100%" border="1" >	

			<tr >

				<td class="font_grid" align="center">Consultor</td>

				<td class="font_grid" align="center">Núm.Ver</td>

				<td class="font_grid" align="center">Razão Social</td>

				<td class="font_grid" align="center">Valor</td>

				<td class="font_grid" align="center">Nº Linhas</td>

				<td class="font_grid" align="center">Envio</td>

				<td class="font_grid"align="center">Previsão</td>

				<td class="font_grid" align="center">Recebimento</td>

				<td class="font_grid" align="center">Envio Contrato</td>

				<td class="font_grid" align="center">Recebimento Contrato</td>

			</tr>



<?	$cont = 0;

	$totalvalor = 0;

	$totallinhas = 0;

	while($row = mysql_fetch_array($result)){

			if($cor=="#dfdfdf"){

		$cor = "#ffffff";

	}Else{

		$cor = "#dfdfdf";

	}

		$cont++;

		$totalvalor += moduloProposta($row['CodProposta'], $row['Versao'], $row['CodLead'], 'totalproposta');

		$totallinhas += moduloProposta($row['CodProposta'], $row['Versao'], $row['CodLead'], 'qtdelinhas', 'chave');

?>

			<tr class="link_cinza" bgcolor="<?=$cor?>">

				<td class="font_grid"><?=$row['GerenteConta'];?></td>

				<td class="font_grid"><?=$row['CodProposta'].'.'.$row['Versao'].'<br />'.$row['NomeProduto'];?></td>

				<td class="font_grid"><?=$row['RazaoSocial'];?></td>

				<td class="font_grid">R$&nbsp;<?=number_format(moduloProposta($row['CodProposta'], $row['Versao'], $row['CodLead'], 'totalproposta'), 2, ",", ".");?></td>

				<td class="font_grid"><?=moduloProposta($row['CodProposta'], $row['Versao'], $row['CodLead'], 'qtdelinhas', 'chave');?></td>

				<td class="font_grid"><?=$row['DataEnvio'];?></td>

				<td class="font_grid"><?=$row['DataPrevisaoRecebimento'];?></td>

				<td class="font_grid"><?=$row['DataRecebimento'];?></td>

				<td class="font_grid"><?=$row['DataEnvioContrato'];?></td>

				<td class="font_grid"><?=$row['DataRecebimentoContrato'];?></td>

			</tr>

<?	}

	mysql_free_result($result);?>

		</tbody>

		<tfoot>

			<tr class="link_cinza" >

				<td class="parametros"Total</th>

				<td class="parametros" colspan="2"><?=$cont;?> Proposta(s)</td>

				<td class="parametros">R$&nbsp;<?=number_format($totalvalor, 2, ",", ".");?></td>

				<td class="parametros"><?=$totallinhas;?></td>

				<td class="parametros" colspan="5">&nbsp;</td>

			</tr>

		</tfoot>

	</table>

</body>

</html>

