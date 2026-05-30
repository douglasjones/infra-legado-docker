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
include_once "../../libs/cla.equipes.php";

$codgerenteconta = $_REQUEST['codgerenteconta'];
$codatendente = $_REQUEST['codatendente'];
$mailing_pk = $_REQUEST['mailing_pk'];
$codmotivo = $_REQUEST['codmotivo'];
$dataini = $_REQUEST['dataini'];
$datafim = $_REQUEST['datafim'];
$codequipe = $_REQUEST['codequipe'];

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
		<font size="+2">Sem Interesse</font>
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
    if(!empty($codequipe)){
		$sql = "select t.tk_equipe cod_equipe, t.vc_nome nome_equipe from tb_equipesvendas t where tk_equipe = $codequipe ";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		?>
		<tr>
			<td>Equipe: <?= $row['nome_equipe'];?></td>
		</tr>
		<?
		mysql_free_result($result);
	}	
	if(!empty($codatendente)){
		$sql = "select nome from usuariosinternos where codusuariointerno = $codatendente ";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		?>
		<tr>
			<td>Atendente: <?= $row['nome'];?></td>
		</tr>
		<?
		mysql_free_result($result);
	}
	if(!empty($mailing_pk)){
		?>
		<tr>
			<td><?
	
			$sql ="";
			$sql.="SELECT m.pk, m.dsc_mailing
						  FROM mailing m
						 WHERE m.dt_cancelamento IS NULL
						
					and pk=".$mailing_pk;
					
			$m = mysql_query($sql);
			$mailing = mysql_fetch_array($m);
			echo "Mailing: ".$mailing['dsc_mailing'];

		?></td>
		</tr>
		<?
	}
	if(!empty($codmotivo)){
		$sql = "select descricao from motivoslead where codmotivolead = $codmotivo ";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		?>
		<tr>
			<td>Motivo Sem Interesse: <?= $row['descricao'];?></td>
		</tr>
		<?
		mysql_free_result($result);
	}
	if(!empty($dataini)){
		?>
		<tr>
			<td>Data Alteração (Início): <?= $dataini;?></td>
		</tr>
		<?
	}
	if(!empty($datafim)){
		?>
		<tr>
			<td>Data Alteração (Fim): <?= $datafim;?></td>
		</tr>
		<?
	}
	?>		
	<tr>
		<td class="parametros">
				<br>
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
</table>
<br>
<table width="100%" cellspacing="0" cellpadding="0" align="center" border="1" class="sortable">	
	<thead>
		<tr>
			<td class="titulo" bgcolor="#8080FF">Consultor</td>
			<td class="titulo" bgcolor="#8080FF">Atendente</td>
			<td class="titulo" bgcolor="#8080FF">Mailing</td>
			<td class="titulo" bgcolor="#8080FF">Motivo Sem Interesse</td>
			<td class="titulo" bgcolor="#8080FF">Código Lead</td>
			<td class="titulo" bgcolor="#8080FF">Razão Social</td>
			<td class="titulo" bgcolor="#8080FF">Último Status</td>
			<td class="titulo" bgcolor="#8080FF">Descrição</td>
		</tr>
	</thead>
	<tbody>
	<?
	
	$cont = 0;
	
	$cor = "#ebebeb";
	
	$sql ="";
	$sql.="select m.dsc_mailing mailing, l.codlead, l.razaosocial, ml.descricao motivo, ui.nome gerenteconta, ui1.nome atendente, max(ol.codocorrencialead) codocorrencialead ";
	$sql.="  from leads l ";
	$sql.="		  inner join motivoslead ml on l.codmotivo = ml.codmotivolead  ";
	if(!empty($codgerenteconta))
		$sql.=" inner ";
	else
		$sql.="	left ";
	$sql.=" join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno ";
	if(!empty($codatendente))
		$sql.=" inner ";
	else
		$sql.=" left ";
    $sql.=" join usuariosinternos ui1 on l.codatendente = ui1.codusuariointerno ";
    if(!empty($codequipe))
		$sql.=" inner join tb_usuarioequipe tbu on l.codgerenteconta = tbu.Fk_Usuario ";
	$sql.=" inner join ocorrenciaslead ol on ol.codlead = l.codlead ";
	$sql.=" left join mailing m on l.mailing_pk = m.pk";
	$sql.=" where ol.codtipoocorrencialead = 5 ";
	
    if(!empty($codequipe))
		$sql.=" and tbu.Fk_Equipe=".mysqlnull($codequipe);
    
    if($codgerenteconta > 0){
		$sql.=" and ui.codusuariointerno = $codgerenteconta ";
	}else{
		if($codgerenteconta == '0'){
			$sql.=" and ui.codusuariointerno is null";
		}
		else{
			if(!permissao('visualizar_todos_consultores', 'cs'))
				//if(empty($busca))
					$sql.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		}
	}
    
    
	
	
	if(!empty($codatendente))
		$sql.=" and l.codatendente = $codatendente ";
	
	if(!empty($mailing_pk))
		$sql.="  and l.mailing_pk = ".$mailing_pk;
	
	if(!empty($dataini))
		$sql.=" and ol.datacadastro >= '".DataYMD($dataini)." 00:00:00' ";
	
	if(!empty($datafim))
		$sql.=" and ol.datacadastro <= '".DataYMD($datafim)." 23:59:59' ";
		
	if(!empty($codmotivo))
		$sql.=" and l.codmotivo = $codmotivo ";
	
	$sql.=" group by l.mailing, l.codlead, l.razaosocial, ml.descricao , ui.nome , ui1.nome  ";
	$sql.=" order by ui.nome, ui1.nome, l.mailing, ml.descricao, l.razaosocial ";

	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		if ($cor == "white")
			$cor = "#ebebeb";
		else
			$cor = "white";
		
		echo "<tr bgcolor='$cor'>";
		echo "<td class='form' align='center'>&nbsp;".$row['gerenteconta']."</td>";
		echo "<td class='form' align='center'>&nbsp;".$row['atendente']."</td>";
		echo "<td class='form' align='center'>&nbsp;".$row['mailing']."</td>";
		echo "<td class='form' align='center'>&nbsp;".$row['motivo']."</td>";
		echo "<td class='form' align='center'>&nbsp;".$row['codlead']."</td>";
		echo "<td class='form'><a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['razaosocial']."</a></td>";
		
		//pega o ultimo status do lead
		$sql ="";
		$sql.="select scl.descricao status  ";
		$sql.="  from tipoocorrenciaslead tol ";
		$sql.="  	  inner join statusclassificacaolead scl on tol.status = scl.codstatusclassificacaolead ";
		$sql.="		  inner join ocorrenciaslead oc on tol.codtipoocorrencialead = oc.codtipoocorrencialead ";
		$sql.=" where tol.status > 1  ";
		$sql.="   and oc.codlead = ".$row['codlead'];
		
		if(!empty($dataini))
			$sql.=" and oc.datacadastro >= '".DataYMD($dataini)." 00:00:00' ";
		
		if(!empty($datafim))
			$sql.=" and oc.datacadastro <= '".DataYMD($datafim)." 23:59:59' ";
		
		$sql.="   order by scl.codstatusclassificacaolead ";
		
		$ultimo_status = "";
		$rs_ultimostatus = mysql_query($sql);
		$num = mysql_num_rows($rs_ultimostatus);
		if ($num == 0){
			$ultimo_status = "Target";
		}
		else{
			while($row_ultimostatus = mysql_fetch_array($rs_ultimostatus)){
				$ultimo_status = $row_ultimostatus['status'];
			}
		}
		echo "<td class='form' align='center'>$ultimo_status</td>";
		mysql_free_result($rs_ultimostatus);
		
		//pega a descricao da ultima ocorrencia do lead
		$sql ="";
		$sql.="select descricao from ocorrenciaslead ol where codocorrencialead = ".$row['codocorrencialead'];
		$rs_ocorrencia = mysql_query($sql);
		$row_ocorrencia = mysql_fetch_array($rs_ocorrencia);
		echo "<td class='form'>".$row_ocorrencia['descricao']."</td>";
		mysql_free_result($rs_ocorrencia);
		
		echo "</tr>";
		
		$cont ++;
		
	}
	mysql_free_result($result);
	
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF" colspan="8">Total: <? echo $cont;?> registro(s)</td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
