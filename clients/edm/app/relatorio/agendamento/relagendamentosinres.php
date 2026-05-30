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
$razaosocial = $_REQUEST['razaosocial'];
$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
$codtipo = $_REQUEST['codtipo'];
$datacadastrode = $_REQUEST['datacadastrode'];
$datacadastroate = $_REQUEST['datacadastroate'];
$datavisitade = $_REQUEST['datavisitade'];
$datavisitaate = $_REQUEST['datavisitaate'];
$codequipe = $_REQUEST['codequipe'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$codusuariointerno = $_REQUEST['codusuariointerno'];
$agendadopara = $_REQUEST['agendadopara'];
$grupousuariointerno = $_REQUEST['grupousuariointerno'];
$mailing_pk = $_REQUEST['mailing_pk'];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title></title>
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<?
if($excel != "S"){
?>
<a name="link_excel" id="link_excel" href="<?= $_SERVER['REQUEST_URI'];?>&excel=S" title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
<br>

<?
}
?>
<br>

<table width="100%" align="center"  height="5"  cellpadding="0" cellspacing="0">
	<tr>
		 <td class="form"> 
			<font size="+2">Agendamento</font>
		</td>
	</tr>
</table>	
<table width="90%" align="center"  height="30"    cellpadding="0" cellspacing="0">
	<tr>
		 <td>
		 &nbsp; 
		</td>	
	</tr>
</table>	
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
		if(count($_REQUEST['codstatus'])>0){
			$sql = "select descricao from statusagendamento where codstatus in ( ";
			for($i=0;$i<count($codstatus);$i++){
				$sql.= $_REQUEST['codstatus'][$i].",";
				// monta critério se for sem classificacao
				if($_REQUEST['codstatus'][$i] == "0"){
					$descricao2 = " Sem Classificação ";
				}
			}
			$sql.=" 0) ";
			$q = mysql_query($sql);
			echo "Status: ";
			while($row = mysql_fetch_array($q)){
				echo $row['descricao']."; ";
			}
			echo $descricao2;
			mysql_free_result($q);
		}
		?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['grupousuariointerno'])){
			$sql = "select nome from gruposusuariosinternos where codgrupousuariointerno= ".$_REQUEST['grupousuariointerno'];
			$q = mysql_query($sql);
			echo "Grupo Usuário Agendamento: ";
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
		if(!empty($_REQUEST['codusuariointerno'])){
			$sql = "select nome from usuariosinternos where codusuariointerno= ".$_REQUEST['codusuariointerno'];
			$q = mysql_query($sql);
			echo "Agendado por: ";
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
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['agendadopara'])){
			$sql = "select nome from usuariosinternos where codusuariointerno= ".$_REQUEST['agendadopara'];
			$q = mysql_query($sql);
			echo "Agendado para: ";
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
		if(!empty($_REQUEST['codtipo'])){
			$sql = "select codtipo, descricao from tipoagendamento where codtipo = ".$_REQUEST['codtipo'];
			$q = mysql_query($sql);
			echo "Tipo Agendamento: ";
			while($row = mysql_fetch_array($q)){
				echo $row['descricao']." ";
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
	if(!empty($_REQUEST['datacadastrode'])){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Agendamento:</dt>
				<dd><?=date('d/m/Y', strtotime(dataYMD($_REQUEST['datacadastrode'])));?> até <?=date('d/m/Y', strtotime(dataYMD($_REQUEST['datacadastroate'])));?></dd>
		</td>
	</tr>
	<?	
	}
	if(!empty($_REQUEST['datavisitade'])){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Visita:</dt>
				<dd><?=date('d/m/Y', strtotime(dataYMD($_REQUEST['datavisitade'])));?> até <?=date('d/m/Y', strtotime(dataYMD($_REQUEST['datavisitaate'])));?></dd>
		</td>
	</tr>
	<?
	}
	?>
	<tr>
		<td class="texto_label">
		<?
		
			if(!empty($mailing_pk)){
			$sql ="";
			$sql.="SELECT m.pk, m.dsc_mailing
						  FROM mailing m
						 WHERE m.dt_cancelamento IS NULL
						
					and pk=".$mailing_pk;
					
			$m = mysql_query($sql);
			$mailing = mysql_fetch_array($m);
			echo "Mailing: ".$mailing['dsc_mailing'];
		}
		?>
		</td>
	</tr>
	
</table>
<br>

<table cellspacing="0" cellpadding="0" align="center" width="100%" border="1" class="sortable" >	
	<thead>
		<tr>
			<td align="center" class='titulo' bgcolor='#8080FF'>Operador</td>
			<?
			$arrStatus = array();
			$arrStatusTotal = array();
			
			//monta o cabecalho
			$sql ="";
			$sql.="select codstatus, descricao from statusagendamento order by 1 ";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				echo "<td class='titulo' bgcolor='#8080FF' align='center'>".$row['descricao']."</td>";
				$arrStatus["'".$row['descricao']."'"]=0;
				$arrStatusTotal["'".$row['descricao']."'"]=0;
			}
			$arrStatus['Sem Classificação']=0;
			$arrStatusTotal['Sem Classificação']=0;
			echo "<td class='titulo' bgcolor='#8080FF' align='center'>Sem Classificação</td>";
			mysql_free_result($result);
			?>
			<td class='titulo' bgcolor='#8080FF' align="center">Total</td>
		</tr>
	</thead>
	<tbody>
		<?	
		$sql ="";
		$sql.="select ui1.codusuariointerno, ui1.nome agendadopor , ifnull(sa.descricao,'Sem Classificação') statusclassificacao, count(*) total ";
		$sql.="  from agendaslead al ";
		$sql.="       inner join leads l on al.codlead = l.codlead ";
		$sql.="        left join agendaslead al1 on al1.codreagendamento = al.codagendalead ";
		$sql.="        left join usuariosinternos ui on al.agendadopara = ui.codusuariointerno ";
		$sql.="        left join usuariosinternos ui1 on al.codusuariointerno = ui1.codusuariointerno ";
		$sql.="        left join tipoagendamento ta on al.codtipo = ta.codtipo ";
		$sql.="        left join statusagendamento sa on al.codstatus = sa.codstatus ";
		$sql.=" where 1=1 ";
		
		//parametros de pesquisa
		if(!empty($_REQUEST['cod_polo']) )
			$sql.="  and l.cod_polo =".$_REQUEST['cod_polo'];
		
		if(!empty($razaosocial))
			$sql.="	 and l.razaosocial like '%$razaosocial%' ";
		
		if(count($codstatus)>0){
			$sql.=" and (al.codstatus in (";
			for($i=0;$i<count($codstatus);$i++){
				$sql.=$codstatus[$i].",";
				if($codstatus[$i]=="0"){
					$sql2 = " or al.codstatus is null ";
				}
			}
			$sql.=" 0) ";
			$sql.= $sql2." ) ";
		}
		
		if(!empty($codstatusclassificacaolead))
			$sql.="  and l.codstatusclassificacaolead = $codstatusclassificacaolead ";
		
		if(!empty($codtipo))
			$sql.="	 and al.codtipo = $codtipo ";
		
		if(!empty($datacadastrode))
			$sql.="  and al.datacadastro >= '".DataYMD($datacadastrode)." 00:00:00' ";
		
		if(!empty($datacadastroate))
			$sql.="  and al.datacadastro <= '".DataYMD($datacadastroate)." 23:59:59' ";
		
		if(!empty($datavisitade))
			$sql.="  and al.datahorario >= '".DataYMD($datavisitade)." 00:00:00' ";
		
		if(!empty($datavisitaate))
			$sql.="  and al.datahorario <= '".DataYMD($datavisitaate)." 23:59:59' ";
		
		if(!empty($codequipe)){
			$sql.="  and al.codusuariointerno in (";
			$sql.=" select e.fk_usuario ";
			$sql.="   from tb_usuarioequipe e ";
			$sql.="  where fk_equipe = $codequipe ) ";
		}
		
		if(!empty($codgerenteconta))
			$sql.=" and al.codagendalead in (select codagendalead from agendagerenteconta where codgerenteconta = $codgerenteconta) ";
			
		if(!empty($codusuariointerno))
			$sql.=" and al.codusuariointerno = $codusuariointerno ";
			
		if(!empty($agendadopara))
			$sql.=" and al.agendadopara = $agendadopara ";
			
		if(!empty($mailing_pk))
			$sql.="  and l.mailing_pk = ".$mailing_pk;		
			
			
		if(!empty($grupousuariointerno)){
			$sql.=" and ui1.codusuariointerno in (";
			$sql.="select codusuariointerno ";
			$sql.="  from gruposusuariosinternos_usuariosinternos ";
			$sql.=" where codgrupousuariointerno = $grupousuariointerno ";
			$sql.=" ) ";
		}
		//fim dos parametros
		$sql.= $where;
		$sql.=" group by ui1.codusuariointerno, ui1.nome, sa.descricao ";
	
		$i = 0;
		
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			
			if($i == 0){
				$codusuariointerno = $row['codusuariointerno'];
				$agendadopor = $row['agendadopor'];
				$total = 0;
				echo "<tr>";
			}
			
			if($codusuariointerno != $row['codusuariointerno']){
				
				echo "<td class='form'>".$agendadopor."</td>";
				
				//pega o total de agendamento do operador por status
				$sql = "";
				$sql.="select codstatus, descricao from statusagendamento order by 1 ";
				$rs_status = mysql_query($sql);
				while($row_status = mysql_fetch_array($rs_status)){
					echo "<td align='center' class='form'>";
					echo $arrStatus["'".$row_status['descricao']."'"]."";
					$total += $arrStatus["'".$row_status['descricao']."'"];
					echo "</td>";
				}
				echo "<td align='center' class='form'>";
				echo $arrStatus['Sem Classificação']."\n";
				$total += $arrStatus['Sem Classificação'];
				echo "</td>";
	
				echo "<td align='center' class='form'>";
				echo $total;
				echo "</td>";
				
				mysql_free_result($rs_status);
				echo "</tr>";
				
				//zera os totais
				$sql ="";
				$sql.="select codstatus, descricao from statusagendamento order by 1 ";
				$rs_status = mysql_query($sql);
				while($row_status = mysql_fetch_array($rs_status)){
					$arrStatus["'".$row_status['descricao']."'"]=0;
				}
				$arrStatus['Sem Classificação']=0;
				
				$total=0;
				$codusuariointerno = $row['codusuariointerno'];
				$agendadopor = $row['agendadopor'];
			}
			
			$i++;
			
			//atualiza os totais
			if($row['statusclassificacao'] == 'Sem Classificação'){
				$arrStatus['Sem Classificação']=$row["total"];
				$arrStatusTotal['Sem Classificação']+=$row["total"];
			}
			else{
				$arrStatus["'".$row['statusclassificacao']."'"]=$row["total"];
				$arrStatusTotal["'".$row['statusclassificacao']."'"]+=$row["total"];
			}
		}
		
		//adiciona a ultima linha na tabela
		echo "<tr>";
		echo "<td class='form'>$agendadopor</td>";
		
		//pega o total de agendamento do operador por status
		$sql = "";
		$sql.="select codstatus, descricao from statusagendamento order by 1 ";
		$rs_status = mysql_query($sql);
		while($row_status = mysql_fetch_array($rs_status)){
			echo "<td align='center' class='form'>";
			echo $arrStatus["'".$row_status['descricao']."'"]."";
			$total += $arrStatus["'".$row_status['descricao']."'"];
			echo "</td>";
		}
		echo "<td align='center' class='form'>";
		echo $arrStatus['Sem Classificação']."\n";
		$total += $arrStatus['Sem Classificação'];
		echo "</td>";
	
		echo "<td align='center' class='form'>";
		echo $total;
		echo "</td>";
	
		echo "</tr>";
		?>
	</tbody>
	<tfoot>
		<?
		//total das colunas
		$total = 0;
		echo "<tr>";
		echo "<td align='center' class='titulo' bgcolor='#8080FF'>Total</td>";
		$sql = "";
		$sql.="select codstatus, descricao from statusagendamento order by 1 ";
		$rs_status = mysql_query($sql);
		while($row_status = mysql_fetch_array($rs_status)){
			echo "<td align='center' class='titulo' bgcolor='#8080FF'>";
			echo $arrStatusTotal["'".$row_status['descricao']."'"]."";
			$total += $arrStatusTotal["'".$row_status['descricao']."'"];
			echo "</td>";
		}
		echo "<td align='center' class='titulo' bgcolor='#8080FF'>";
		echo $arrStatusTotal['Sem Classificação']."\n";
		$total += $arrStatusTotal['Sem Classificação'];
		echo "</td>";
		echo "<td align='center' class='titulo' bgcolor='#8080FF'>";
		echo $total;
		echo "</td>";
		echo "</tr>";
		
		
		mysql_free_result($result);
		?>
	</tfoot>
	</table>
</body>
</html>
