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
	
	$status = null;
	$gerenteconta = null;
	$mailing = null;
	$sql = "Select u.Nome, COUNT(l.CodLead) Leads";
	$sql .= " From usuariosinternos u inner join leads l on u.CodUsuarioInterno = l.CodGerenteConta";
	$sql .= " Where 1";
	if(!empty($_REQUEST['mailing'])){
		$mailing = $_REQUEST['mailing'];
		$sql .= " And l.Mailing Like " . mysqlnull("%$mailing%");
	}
	if(!empty($_REQUEST['cod_polo'])){
		$sql .= " And l.cod_polo = ".$_REQUEST['cod_polo'];
	}
	if(!empty($_REQUEST['codgerenteconta'])){
		$gerenteconta = $_REQUEST['codgerenteconta'];
		$sql .= " And u.CodUsuarioInterno = " . mysqlnull($gerenteconta);
	}
	if($GerenteContas && !permissao('leadoutrogerente', 'al')){
		$gerenteconta = $_SESSION['codusuario'];
		$sql .= " and u.CodUsuarioInterno = " . mysqlnull($gerenteconta);
	}
	$status = array('2' => 'Target', '3' => 'Lead 0%');
	$usuarios = array();
	foreach($status as $codstatus => $descricao){
		$rs = sql_query($sql . " And l.CodStatusClassificacaoLead = $codstatus Group By u.Nome");
		while($row = mysql_fetch_array($rs)){
			$usuarios[$row['Nome']][$descricao] = $row['Leads'];
		}
	}
	$total = array('Target' => 0, 'Lead 0%' => 0);?>
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
<!--HTML-->
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
<table width="100%" align="center"  height="5"  cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<font size="+2" face="Arial">Target e Lead 0% por Consultor</font>
		</td>	
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="0" class="form">	
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
<?	if(!empty($gerenteconta)){?>	
	<tr>		
		<td class="texto_label">			
			Consultor:
			<? $sql = "Select Nome From usuariosinternos Where CodUsuarioInterno = $gerenteconta";
			   $res1 = sql_query($sql);
			   while($row = mysql_fetch_array($res1)){?>
			<dd><?=$row['Nome'];?></dd>
<?		}
	}
			if(!empty($mailing)){?>
			<dt>Mailing:</dt>
				<dd><?=$mailing;?></dd>
<?	}
	if(!empty($datastatusde)){?>
			<dt>Data de Alteração de Status:</dt>
				<dd><?=date('d/m/Y', strtotime($datastatusde));?> até <?=date('d/m/Y', strtotime($datastatusate));?></dd>	
<?	}?>		</td>	
		</tr>	
		<tr>		
			<td class="parametros">
				Relatório gerado em 			<?=date('d/m/Y', mktime());?> às <?=date('H:i', mktime())?>		
			</td>	
		</tr>
</table>
<br>
<br>
		
	<table width="100%" border="1" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<th class="titulo" bgcolor="#8080FF">Consultor</th>
				<?	foreach($status as $descricao){?>
						<th class="titulo" bgcolor="#8080FF"><?=$descricao;?></th>
				<?	}?>
			</tr>
			<?	foreach($usuarios as $nome => $usuario){?>
						<tr>
							<td class="form"><?=$nome;?></td>
			<?		foreach($status as $codstatus => $descricao){
						if(!empty($usuario[$descricao])){
							$total[$descricao] += $usuario[$descricao];?>
							<td align="center" class="form"><?=$usuario[$descricao];?></td>
			<?			}else{?>
							<td>&nbsp;</td>
			<?			}
					}?>
						</tr>
			<?	}?>		
			
			<tr>
				<td class="titulo" align="center" bgcolor="#8080FF">
					Total
				</td>
				<?	foreach($status as $codstatus => $descricao){?>
					<td class="titulo" align="center" bgcolor="#8080FF"><?=$total[$descricao];?></td>
				<?	}?>
			</tr>	
		</tbody>
	</table>
</body>
</html>
