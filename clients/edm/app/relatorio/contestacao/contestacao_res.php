<?

$excel = $_REQUEST['excel'];

if($excel == "S"){
	$arquivo = 'planilha.xls';
	
	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}


include_once( "../../libs/maininclude.php" ) ;
include_once( "../../libs/datas.php" ) ;

$cod_polo = $_REQUEST['cod_polo'];
$razaosocial = $_REQUEST['razaosocial'];
$id_fornecedor = $_REQUEST['id_fornecedor'];
$dt_contestacao_de = $_REQUEST["dt_contestacao_de"];
$dt_contestacao_ate = $_REQUEST['dt_contestacao_ate'];
$codgerenteconta = $_REQUEST['codgerenteconta'];

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
		<font size="+2">Contestação</font>
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
				Relatório gerado em <?
							$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i:%s') data_geracao ";
							$rs_geracao = mysql_query($sql);
							$row_geracao = mysql_fetch_array($rs_geracao);
							echo $row_geracao['data_geracao'];
							mysql_free_result($rs_geracao);
						    ?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['cod_polo'])){
			$sql = "Select 
					p.cod_polo
					,p.n_polo
					 from polo p";
			$sql .= " where p.cod_polo=".$_REQUEST['cod_polo'];
			$sql .= " Order By p.n_polo ";
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			echo "Polo: ".$polo['n_polo'];
		}
		?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($razaosocial)){
			echo "Razão Social: ".$razaosocial;
		}
		?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($razaosocial)){
			echo "ID Fornecedor: ".$id_fornecedor;
		}
		?>
		</td>
	</tr>		
	<tr>
		<td class="parametros">
		<?	
		if(!empty($codgerenteconta)){
			$sql = "select nome from usuariosinternos where codusuariointerno= ".$codgerenteconta;
			$q = mysql_query($sql);
			echo "Consultor: ";
			while($row = mysql_fetch_array($q)){
				echo $row['nome']." ";
			}
			mysql_free_result($q);
		}
		?>
		</td>
	</tr>			
	<?	
	if(!empty($dt_contestacao_de)){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Contestação:</dt>
				<dd><?= $dt_contestacao_de; ?> até <?= $dt_contestacao_ate; ?></dd>
		</td>
	</tr>
	<?	
	}
	?>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center" border="1" width="2000" class="sortable">	
	<thead>
		<tr>
			<td class="titulo" bgcolor="#8080FF">ID Fornecedor</td>
			<td class="titulo" bgcolor="#8080FF">Cod. Lead</td>
			<td class="titulo" bgcolor="#8080FF">Razão Social</td>
			<td class="titulo" bgcolor="#8080FF">Consultor</td>
			<td class="titulo" bgcolor="#8080FF">Dt. Contestação</td>
			<td class="titulo" bgcolor="#8080FF">Desc. Contestação</td>
			<td class="titulo" bgcolor="#8080FF">Usr. Contestação</td>
			<td class="titulo" bgcolor="#8080FF">Dt. Resposta</td>
			<td class="titulo" bgcolor="#8080FF">Tipo Resposta</td>
			<td class="titulo" bgcolor="#8080FF">Desc. Resposta</td>
			<td class="titulo" bgcolor="#8080FF">Usr. Resposta</td>
		</tr>
	</thead>
	<tbody>
	<?	
	
	$sql ="";
	$sql.="select l.codlead, l.razaosocial, date_format(oc.datacadastro,'%d/%m/%Y %H:%i:%s') dt_cadastro, oc.descricao, ui.nome usuariocadastro, l.id_fornecedor, ui1.nome consultor ";
	$sql.="  from leads l ";
	$sql.="        inner join ocorrenciaslead oc on l.codlead = oc.codlead  ";
	$sql.="        inner join usuariosinternos ui on oc.codusuariointerno = ui.codusuariointerno ";
	$sql.="         left join usuariosinternos ui1 on l.codgerenteconta = ui1.codusuariointerno ";
	$sql.=" where oc.codtipoocorrencialead = 6008 ";
	
	if(!empty($razaosocial))
		$sql.=" and l.razaosocial like '%".$razaosocial."%' ";
	
	if(!empty($id_fornecedor))
		$sql.=" and l.id_fornecedor = '".$id_fornecedor."' ";
	
	if(!empty($dt_contestacao_de))
		$sql.="  and oc.datacadastro >= '".DataYMD($dt_contestacao_de)." 00:00:00' ";	
	
	if(!empty($dt_contestacao_ate))
		$sql.="  and oc.datacadastro <= '".DataYMD($dt_contestacao_ate)." 23:59:59' ";
	
	if(!empty($codgerenteconta))
		$sql.=" and l.codgerenteconta = $codgerenteconta ";
		
	if(!empty($cod_polo))
		$sql.=" and l.cod_polo = $cod_polo ";
	

	$sql.=" order by oc.datacadastro asc ";
	
	$result = mysql_query($sql);
	$cont = 0;
	
	while($row = mysql_fetch_array($result)){
		
		echo "<tr>";
		echo "<td class='form' align='center'>".$row['id_fornecedor']."</td>";
		echo "<td class='form' align='center'>".$row['codlead']."</td>";
		echo "<td class='form'>&nbsp;<a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['razaosocial']."</a></td>";
		echo "<td class='form'  align='center'>&nbsp;".$row['consultor']."</td>";
		echo "<td class='form'  align='center'>&nbsp;".$row['dt_cadastro']."</td>";
		echo "<td class='form'>&nbsp;".$row['descricao']."</td>";
		echo "<td class='form' align='center'>&nbsp;".$row['usuariocadastro']."</td>";
		
		//Pesquisa a resposta da contestação.
		$sql ="";
		$sql.="select date_format(oc.datacadastro,'%d/%m/%Y %H:%i:%s') dt_cadastro, oc.descricao, ui.nome usuariocadastro, tp.descricao tipo_ocorrencia ";
		$sql.="  from ocorrenciaslead oc ";
		$sql.="       inner join usuariosinternos ui on oc.codusuariointerno = ui.codusuariointerno ";
		$sql.="        inner join tipoocorrenciaslead tp on tp.codtipoocorrencialead = oc.codtipoocorrencialead ";
		$sql.=" where oc.codlead = ".$row['codlead'];
		$sql.="   and tp.codtipoocorrencialead in (6009, 6010) ";
		$sql.=" order by oc.datacadastro desc ";
		
		$rs_resposta = mysql_query($sql);
		$num = mysql_num_rows($rs_resposta);
		if($num > 0){
			$row_resposta = mysql_fetch_array($rs_resposta);
			echo "<td class='form' align='center'>&nbsp;".$row_resposta['dt_cadastro']."</td>";
			echo "<td class='form' align='center'>&nbsp;".$row_resposta['tipo_ocorrencia']."</td>";
			echo "<td class='form' align='center'>&nbsp;".$row_resposta['descricao']."</td>";
			echo "<td class='form' align='center'>&nbsp;".$row_resposta['usuariocadastro']."</td>";
		}
		else{
			echo "<td class='form'>&nbsp;</td>";
			echo "<td class='form'>&nbsp;</td>";
			echo "<td class='form'>&nbsp;</td>";
			echo "<td class='form'>&nbsp;</td>";			
		}
		mysql_free_result($rs_resposta);
		
		echo "</tr>";
		$cont++;
	}
	mysql_free_result($result);
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF" colspan="11">Total: <? echo $cont;?> Registro(s)</td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?include_once "../../libs/desconectar.php";?>