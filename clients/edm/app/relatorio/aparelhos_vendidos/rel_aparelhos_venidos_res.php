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

//$cod_polo = $_REQUEST['cod_polo'];
$codaparelho = $_REQUEST['codaparelho'];
$datativacaode = $_REQUEST['dataativacaode'];
$datativacaoate = $_REQUEST['dataativacaoate'];
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
		<font size="+2">Aparelhos Vendidos</font>
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
		if(!empty($_REQUEST['codaparelho'])){
			$sql = "Select 
					  a.codaparelho
					  ,a.NomeAparelho
					from aparelhos a";
			$sql .= " where a.codaparelho=".$_REQUEST['codaparelho'];
			
			$q = mysql_query($sql);
			$aparelho = mysql_fetch_array($q);
			echo "Aparelho: ".$aparelho['NomeAparelho'];
		}
		?>
		</td>
	</tr>
	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['codgerenteconta'])){
			$sql = "select nome from usuariosinternos where codusuariointerno= ".$_REQUEST['codgerenteconta'];
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
	if(!empty($_REQUEST['dataativacaode'])){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas Ativação:</dt>
				<dd><?=$_REQUEST['dataativacaode'];?> até <?=$_REQUEST['dataativacaoate'];?></dd>
		</td>
	</tr>
	<?}?>
</table>
<br>
<table cellspacing="0" cellpadding="0" align="center" border="1" width="2000" class="sortable">	
	<thead>
		<tr>
		

			<td class="titulo" bgcolor="#8080FF">Cod. Lead</td>
			<td class="titulo" bgcolor="#8080FF">Razão Social</td>
			<td class="titulo" bgcolor="#8080FF">Consultor</td>
			<td class="titulo" bgcolor="#8080FF">Atendente</td>
			<td class="titulo" bgcolor="#8080FF">Cod. Proposta</td>
			<td class="titulo" bgcolor="#8080FF">Versão</td>
			<td class="titulo" bgcolor="#8080FF">Aparelho</td>
			<td class="titulo" bgcolor="#8080FF">Valor Aparelho</td>
			<td class="titulo" bgcolor="#8080FF">Data Ativação</td>
			<td class="titulo" bgcolor="#8080FF">Data Entrega Aparelhos</td>
		</tr>
	</thead>
	<tbody>
	<?	
	
	$sql ="";
	$sql.="Select
				l.codlead
				,l.RazaoSocial
				,ui.nome as consultor
				,ui1.nome as atendente
				,p.CodProposta
				,p.Versao
				,a.NomeAparelho
				,np.vlr_aparelho
				,case when dp.nome_data = 'ativacao' then
				  date_format(dp.valor_data, '%d/%m/%Y')
				end dtativacao
				,case when dp1.nome_data = 'entrega_aparelho' then
				  date_format(dp1.valor_data, '%d/%m/%Y')
				end dtentrega_aparelho
		    from leads l
				inner join propostas p on l.CodLead = p.CodLead
				inner join numeros_proposta np on np.CodProposta = p.CodProposta and np.Versao = p.Versao
				inner join aparelhos a on np.codaparelho = a.CodAparelho
				left join usuariosinternos ui on l.CodGerenteConta = ui.CodUsuarioInterno
				left join usuariosinternos ui1 on l.CodAtendente = ui1.CodUsuarioInterno
				inner join produtos pr on  p.CodProduto = pr.codproduto
				left join data_proposta_operador dpo on pr.cod_operador = dpo.cod_operador and dpo.nome_data = 'ativacao' 
				left join data_proposta_operador dpo1 on pr.cod_operador = dpo1.cod_operador and dpo1.nome_data = 'entrega_aparelho' 
				left join data_proposta dp on dpo.nome_data = dp.nome_data and dp.codproposta = p.CodProposta and dp.versao = p.Versao
				left join data_proposta dp1 on dpo1.nome_data = dp1.nome_data and dp1.codproposta = p.CodProposta and dp1.versao = p.Versao 
			where p.codproposta >0";
			
	//parametros de pesquisa
	if(!empty($_REQUEST['codaparelho']))
		$sql.="  and a.codaparelho =".$_REQUEST['codaparelho'];
	
	if(!empty($_REQUEST['codgerenteconta']))
		$sql.="  and l.codgerenteconta =".$_REQUEST['codgerenteconta'];
		
	if(!empty($_REQUEST['dataativacaode']))
		$sql.="  and dp.valor_data >= '".DataYMD($_REQUEST['dataativacaode'])." 00:00:00' ";
			
	if(!empty($_REQUEST['dataativacaode']))
		$sql.="  and dp.valor_data >= '".DataYMD($_REQUEST['dataativacaoate'])." 00:00:00' ";
	

	$result = mysql_query($sql);
	$cont = 0;
	while($row = mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td class='form' align='center'>".$row['codlead']."</td>";

		echo "<td class='form'>&nbsp;<a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['RazaoSocial']."</a></td>";
		echo "<td class='form'>&nbsp;".$row['consultor']."</td>";
		echo "<td class='form'>&nbsp;".$row['atendente']."</td>";
		echo "<td class='form'>&nbsp;".$row['CodProposta']."</td>";
		echo "<td class='form'>&nbsp;".$row['Versao']."</td>";
		echo "<td class='form'>&nbsp;".$row['NomeAparelho']."</td>";
		echo "<td class='form'>&nbsp;R$&nbsp;".$row['vlr_aparelho']."</td>";
		echo "<td class='form'>&nbsp;".$row['dtativacao']."</td>";
		echo "<td class='form'>&nbsp;".$row['dtentrega_aparelho']."</td>";
		echo "</tr>";
		$cont++;
	}
	mysql_free_result($result);
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF" colspan="10">Total: <? echo $cont;?> Aparelhos(s)</td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>