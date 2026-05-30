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
$codequipe = $_REQUEST['codequipe'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$recebe_assinatura_de = $_REQUEST['recebe_assinatura_de'];
$recebe_assinatura_ate = $_REQUEST['recebe_assinatura_ate'];

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
<script>
function abrirAnalitico(var_codmotivolead){
	NewWindow("relwinxloss_analitico.php?cod_polo=<?= $cod_polo;?>&codequipe=<?= $codequipe;?>&codgerenteconta=<?= $codgerenteconta;?>&recebe_assinatura_de=<?= $recebe_assinatura_de;?>&recebe_assinatura_ate=<?= $recebe_assinatura_ate;?>&codmotivolead=" + var_codmotivolead, 800,600);
}
</script>
<?
}
?>
<br>
<table cellspacing="0" cellpadding="0" align="left" border="0">	
<tr>
	<td class="form" align="center">
		<font size="+2">Win X Loss Analitico</font>
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
	<tr>
		<td class="parametros">
		<?	
		if(!empty($codequipe)){
			$sql = "Select Vc_Nome from tb_equipesvendas where Tk_Equipe = ".$codequipe;
			$q = mysql_query($sql);
			$equipe = mysql_fetch_array($q);
			echo "Equipe: ".$equipe['Vc_Nome'];
		}
		?>
		</td>
	</tr>
	<?	
	if(!empty($recebe_assinatura_de)){
	?>
	<tr>
		<td class="texto_label">
			Recebimento Pedido: <?= $recebe_assinatura_de; ?> até <?= $recebe_assinatura_ate; ?>
		</td>
	</tr>
	<?	
	}
	?>
</table>
<br>
<?


$arrMotivoSemInteresse = array();
$arrMotivoSemInteresseCodigo = array();
$arrQtdeNegocios = array();
$arrQtdeLinhas = array();

//Carrega primeiro os motivos de sem interesse numa matriz.
$sql ="";
$sql.="select codmotivolead, descricao ";
$sql.="  from motivoslead ";
$sql.=" order by 2 ";
$rs_motivo = mysql_query($sql);
while($row_motivo = mysql_fetch_array($rs_motivo)){
	$arrMotivoSemInteresse[] = $row_motivo['descricao'];
	$arrMotivoSemInteresseCodigo[$row_motivo['descricao']] = $row_motivo['codmotivolead'];
	$arrQtdeNegocios[$row_motivo['descricao']] = 0;
	$arrQtdeLinhas[$row_motivo['descricao']] = 0;
}
mysql_free_result($rs_motivo);


$total_linhas = 0;
$total_negocios = 0;

$sql ="";
$sql.="select tk_equipe, vc_nome ";
$sql.="  from tb_equipesvendas ";
$sql.=" order by vc_nome ";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){

?>
	<table cellspacing="0" cellpadding="0" align="center" border="0" width="90%">	
		<tr>
			<td class='form' width=60px nowrap=true><b>Equipe: </b></td>
			<td class='form'>
				<?= $row['vc_nome']; ?>
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" align="center" border="1" width="90%" class="sortable">	
		<thead>
			<tr>
				<td class="titulo" bgcolor="#8080FF">Razão Social</td>			
				<td class="titulo" bgcolor="#8080FF">Motivo Sem Interesse</td>			
				<td class="titulo" bgcolor="#8080FF">Data Recebimento Assinatura</td>			
				<td class="titulo" bgcolor="#8080FF">Qtde de linhas</td>			
			</tr>
		</thead>
		<tbody>
		<?			
		//Agrupa os motivos de sem interesse e os seus totais.
		$sql ="";
		$sql.="select l.codlead, date_format(dp.valor_data, '%d/%m/%Y') recebe_assinatura, p.codproposta, p.versao, ml.descricao, l.razaosocial ";
		$sql.="  from leads l  ";
		$sql.="        inner join propostas p on l.codlead = p.codlead  ";
		$sql.="        inner join data_proposta dp on (p.codproposta = dp.codproposta and p.versao = dp.versao and p.codlead = dp.codlead and nome_data = 'recebe_assinatura') ";
		$sql.="		inner join motivoslead ml on l.codmotivo = ml.codmotivolead  ";
		$sql.=" where l.codstatusclassificacaolead = 1 ";
		
		if(!empty($cod_polo))
			$sql.="  and l.cod_polo = $cod_polo ";

		if(!empty($recebe_assinatura_de))
			$sql.="  and dp.valor_data >= '".DataYMD($recebe_assinatura_de)." 00:00:00' ";
		
		if(!empty($recebe_assinatura_ate))
			$sql.="  and dp.valor_data <= '".DataYMD($recebe_assinatura_ate)." 23:59:59' ";

		if(!empty($codequipe)){
			$sql.="  and l.codusuariointerno in (";
			$sql.=" select e.fk_usuario ";
			$sql.="   from tb_usuarioequipe e ";
			$sql.="  where fk_equipe = $codequipe ) ";
		}
		$sql.=" order by l.razaosocial ";

		$rs_propostas = mysql_query($sql);
		while($row_propostas = mysql_fetch_array($rs_propostas)){
			
			$valor = 0;
			
			//Pesquisa a quantidade de linhas.
			$sql ="";
			$sql.="select (ifnull(mp.valor,0) + ifnull(mp.calculado,0)) linhas ";
			$sql.="  from modulosproposta mp ";
			$sql.=" where mp.id = 'qtdelinhas' ";
			$sql.="   and mp.codproposta = ".$row_propostas['codproposta'];
			$sql.="   and mp.codlead = ".$row_propostas['codlead'];
			$sql.="   and mp.versao = ".$row_propostas['versao'];
			$rs_qtde_linhas = mysql_query($sql);
			while($row_qtde_linhas = mysql_fetch_array($rs_qtde_linhas)){
				$valor = $row_qtde_linhas['linhas'];
			}
			mysql_free_result($rs_qtde_linhas);
			
			echo "<tr>";
			echo "<td class='form'>".$row_propostas['razaosocial']."</td>";
			echo "<td class='form'>".$row_propostas['descricao']."</td>";
			echo "<td class='form' align='center'>".$row_propostas['recebe_assinatura']."</td>";
			echo "<td class='form' align='center'>".$valor."</td>";
			echo "</tr>";
			
			$total_linhas += $valor;
			
		}
		mysql_free_result($rs_propostas);
			
		?>
		</tbody>
		<tfoot>
			<tr class="link_cinza"  >
				<td align="center" class="titulo" bgcolor="#8080FF" colspan=3>
					Total
				</td>
				<td align="center" class="titulo" bgcolor="#8080FF">
					<?= $total_linhas; ?>
				</td>				
			</tr>
		</tfoot>
	</table>
<?
}
mysql_free_result($result);
?>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
