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
include_once( "../../operacao/produtos/variaveis_tim.php" ) ;

//$cod_polo = $_REQUEST['cod_polo'];
$codequipe = $_REQUEST['codequipe'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$codatendente = $_REQUEST['codatendente'];
$envio_leadini = $_REQUEST['envio_leadini'];
$envio_leadfim = $_REQUEST['envio_leadfim'];
$ativacaoini = $_REQUEST['ativacaoini'];
$ativacaofim = $_REQUEST['ativacaofim'];

if(!empty($envio_leadde))
	$envio_leadde = DataYMD($envio_leadde);
	
if(!empty($envio_leadate))
	$envio_leadate = DataYMD($envio_leadate);

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
		<font size="+2">Vendas</font>
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
				Relatório gerado em 
				<?
				//Pega a data de geração do relatório
				$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i') datageracao ";
				$rs_geracao = mysql_query($sql);
				$row_geracao = mysql_fetch_array($rs_geracao);
				echo $row_geracao['datageracao'];
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
		if(!empty($codatendente)){
			$sql = "select nome from usuariosinternos where codusuariointerno= $codatendente ";
			$q = mysql_query($sql);
			echo "Atendente: ";
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
		if(!empty($codgerenteconta)){
			$sql = "select nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
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
		if(!empty($_REQUEST['codequipe'])){
			$sql = "Select Vc_Nome from tb_equipesvendas where Tk_Equipe = ".$_REQUEST['codequipe'];
			$q = mysql_query($sql);
			$equipe = mysql_fetch_array($q);
			echo "Equipe: ".$equipe['Vc_Nome'];
		}
		?>
		</td>
	</tr>
	<?	
	if(!empty($_REQUEST['envio_leadde'])){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Envio para o Lead:</dt>
				<dd><?=date('d/m/Y', strtotime(dataYMD($_REQUEST['envio_leadde'])));?> até <?=date('d/m/Y', strtotime(dataYMD($_REQUEST['envio_leadate'])));?></dd>
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
			<td class="titulo" bgcolor="#8080FF">#</td>
			<td class="titulo" bgcolor="#8080FF">Código Lead</td>
			<td class="titulo" bgcolor="#8080FF">Lead</td>
			<td class="titulo" bgcolor="#8080FF">Consultor</td>
			<td class="titulo" bgcolor="#8080FF">Atendente</td>
			<td class="titulo" bgcolor="#8080FF">Data Cadastro Proposta</td>
			<td class="titulo" bgcolor="#8080FF">Data Ativação</td>			
			<td class="titulo" bgcolor="#8080FF">Proposta</td>
			<td class="titulo" bgcolor="#8080FF">Versão</td>
			<td class="titulo" bgcolor="#8080FF">Produto</td>
			<td class="titulo" bgcolor="#8080FF">Qtde</td>
			<td class="titulo" bgcolor="#8080FF">Linhas Novas</td>
			<td class="titulo" bgcolor="#8080FF">Linhas Adição</td>
			<td class="titulo" bgcolor="#8080FF">Linhas Portabilidade</td>
			<td class="titulo" bgcolor="#8080FF">Linhas Renovação</td>
			<td class="titulo" bgcolor="#8080FF">Linhas Migração</td>
			<td class="titulo" bgcolor="#8080FF">Linhas Transferência</td>			
			<td class="titulo" bgcolor="#8080FF">Status</td>
			<td class="titulo" bgcolor="#8080FF">Motivo</td>
		</tr>
	</thead>
	<tbody>
	<?	
	
	function pegarVariavel($strVariavel, $codlead, $codproposta, $codversao){
		$sql ="";
		$sql ="select mp.id, (ifnull(mp.valor,0) +  ifnull(mp.calculado,0)) total ";
		$sql.="  from modulosproposta mp ";
		$sql.=" where mp.codlead = $codlead ";
		$sql.="   and mp.codproposta = $codproposta ";
		$sql.="   and mp.versao = $codversao ";
		$sql.="   and mp.id = '".$strVariavel."' ";
		$rs_variavel = mysql_query($sql);
		while($row_variavel = mysql_fetch_array($rs_variavel)){
			$strRetorno = $row_variavel['total'];
		}
		mysql_free_result($rs_variavel);
		return $strRetorno;
	}
	
	$sql ="";
	$sql.="select date_format(p.datacadastro,'%d/%m/%Y %H:%i:%s') datacadastroproposta, ml.descricao motivo, scl.descricao statuslead, l.razaosocial, ui.nome gerenteconta, ui1.nome atendente, l.codlead, p.codproposta, p.versao ";
	$sql.="  from leads l ";
	$sql.="		  inner join statusclassificacaolead scl on l.codstatusclassificacaolead = scl.codstatusclassificacaolead ";
	$sql.="		   left join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno ";
	$sql.="		   left join usuariosinternos ui1 on l.codatendente = ui1.codusuariointerno ";
	$sql.="       inner join propostas p on p.codlead = l.codlead ";
	$sql.="		   left join motivoslead ml on l.codmotivo = ml.codmotivolead ";
	
	if(!empty($ativacaoini)){
		$sql.="       inner join data_proposta dp1 on (dp1.codlead = p.codlead ";
		$sql.="       			                  and dp1.codproposta = p.codproposta ";
		$sql.="       			                  and dp1.versao = p.versao ";
		$sql.="       			                  and dp1.nome_data = 'ativacao') ";
	}
		
	$sql.=" where p.datacancelamento is null ";
	
	if(!empty($ativacaoini)){
		$sql.=" and (dp1.valor_data between '".DataYMD($ativacaoini)."' and '".DataYMD($ativacaofim)."' ) ";
	}
	
	//parametros de pesquisa
	if(!empty($_REQUEST['cod_polo']))
		$sql.="  and l.cod_polo =".$_REQUEST['cod_polo'];
	
	if(!empty($codequipe)){
		$sql.="  and l.codgerenteconta in (";
		$sql.=" select e.fk_usuario ";
		$sql.="   from tb_usuarioequipe e ";
		$sql.="  where fk_equipe = $codequipe ) ";
	}
	
	if(!empty($codgerenteconta))
		$sql.=" and l.codgerenteconta = $codgerenteconta ";
	
	if(!empty($codatendente))
		$sql.=" and l.codatendente = $codatendente ";
	
	$result = mysql_query($sql);
	
	$cont = 0;
	$qtde_total = 0;
	
	while($row = mysql_fetch_array($result)){
		
		$sql ="select mp.id, (ifnull(mp.valor,0) +  ifnull(mp.calculado,0)) total ";
		$sql.="  from modulosproposta mp ";
		$sql.=" where mp.codlead = ".$row['codlead'];
		$sql.="   and mp.codproposta = ".$row['codproposta'];
		$sql.="   and mp.versao = ".$row['versao'];
		$sql.="   and mp.id in (";
		//pega as variaveis dos produtos
		for ($i = 0; $i < count($arrVariavelProduto); $i++){
			$sql.="'".$arrVariavelProduto[$i]."', ";
		}
		$sql.="'') ";
		$sql.="  and (ifnull(mp.valor,0) +  ifnull(mp.calculado,0)) > 0 " ;
		$rs_mp = mysql_query($sql);
		while($row_mp = mysql_fetch_array($rs_mp)){
			
			echo "<tr>";
			echo "<td class='form' align='center'>".($cont+1)."</td>";
			echo "<td class='form' align='center'>".$row['codlead']."</td>";
			echo "<td class='form' align='center'>".$row['razaosocial']."</td>";
			echo "<td class='form' align='center'>".$row['gerenteconta']."</td>";
			echo "<td class='form' align='center'>".$row['atendente']."</td>";
			echo "<td class='form' align='center'>".$row['datacadastroproposta']."</td>";
			//pesquisa a data de envio para o lead e a data da ativacao da proposta
			$sql ="";
			$sql.="select nome_data, date_format(valor_data,'%d/%m/%Y') data from data_proposta ";
			$sql.=" where codproposta = ".$row['codproposta'];
			$sql.="   and versao = ".$row['versao'];
			$sql.="   and codlead = ".$row['codlead'];
			$sql.="   and nome_data = 'ativacao' ";
			$rs_data = mysql_query($sql);
			$dataenvio = "";
			while($row_data = mysql_fetch_array($rs_data)){
				if($row_data['nome_data'] == "ativacao"){
					$ativacao = $row_data['data'];
				}
			}
			mysql_free_result($rs_data);
			echo "<td class='form' align='center'>&nbsp;".$ativacao."&nbsp;</td>";
			//fim da pesquisa das datas da proposta
			
			echo "<td class='form' align='center'>".$row['codproposta']."</td>";
			echo "<td class='form' align='center'>".$row['versao']."</td>";
			echo "<td class='form' align='center'>".$arrTituloProduto[$row_mp['id']]."</td>";
			echo "<td class='form' align='center'>".$row_mp['total']."</td>";
			
			//pega as linhas novas do produto.
			
			echo "<td class='form' align='center'>".pegarVariavel($arrLN[$row_mp['id']], $row['codlead'], $row['codproposta'], $row['versao'])."</td>";
			echo "<td class='form' align='center'>".pegarVariavel($arrLA[$row_mp['id']], $row['codlead'], $row['codproposta'], $row['versao'])."</td>";
			echo "<td class='form' align='center'>".pegarVariavel($arrLP[$row_mp['id']], $row['codlead'], $row['codproposta'], $row['versao'])."</td>";
			echo "<td class='form' align='center'>".pegarVariavel($arrLR[$row_mp['id']], $row['codlead'], $row['codproposta'], $row['versao'])."</td>";
			echo "<td class='form' align='center'>".pegarVariavel($arrLM[$row_mp['id']], $row['codlead'], $row['codproposta'], $row['versao'])."</td>";
			echo "<td class='form' align='center'>".pegarVariavel($arrLT[$row_mp['id']], $row['codlead'], $row['codproposta'], $row['versao'])."</td>";
			
			echo "<td class='form' align='center'>".$row['statuslead']."</td>";
			echo "<td class='form' align='center'>".$row['motivo']."</td>";
			echo "</tr>";
			$cont++;
			$qtde_total += $row['total'];
		}
		mysql_free_result($rs_mp);
	}
	mysql_free_result($result);
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF" colspan="20">&nbsp;</td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>