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
$codstatus = $_REQUEST['codstatus'];
$mailing_pk = $_REQUEST['mailing_pk'];

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
		<font size="+2">Agendamento</font>
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
<table cellspacing="0" cellpadding="0" align="center" border="1" width="2000" class="sortable">	
	<thead>
		<tr>
                    <td class="titulo" bgcolor="#8080FF">Cod. Agenda</td>
                    <td class="titulo" bgcolor="#8080FF">Agendamento</td>
                    <td class="titulo" bgcolor="#8080FF">Data Visita</td>
                    <td class="titulo" bgcolor="#8080FF">Lead</td>
                    <td class="titulo" bgcolor="#8080FF">CNPJ</td>
                    <td class="titulo" bgcolor="#8080FF">Operadora Atual</td>
                    <td class="titulo" bgcolor="#8080FF">Qtde Linhas</td>
                    <td class="titulo" bgcolor="#8080FF">Cidade</td>
                    <td class="titulo" bgcolor="#8080FF">Status Lead</td>			
                    <td class="titulo" bgcolor="#8080FF">Agendado por</td>
                    <td class="titulo" bgcolor="#8080FF">Agendado para Operadora</td>
                    <td class="titulo" bgcolor="#8080FF">Consultor</td>
                    <td class="titulo" bgcolor="#8080FF">Tipo</td>
                    <td class="titulo" bgcolor="#8080FF">Descrição Age</td>
                    <td class="titulo" bgcolor="#8080FF">Status Ag. Visita</td>
		</tr>
	</thead>
	<tbody>
	<?	
	
	$sql ="";
	$sql.="select al.codlead,al.descricao obs_ag,l.qtde_linhas,al.codagendalead, l.cidade, l.razaosocial, scl.descricao statusclassificacaolead, al.datacadastro, al.datahorario, ui.nome agendadopara, ui1.nome agendadopor, ta.descricao tipoagendamento, sa.descricao statusagendamento, al.codreagendamento, al1.codagendalead reagendamento,l.cnpj_cpf";
	$sql.="  from agendaslead al ";
	$sql.="       inner join leads l on al.codlead = l.codlead ";
	$sql.="		  inner join statusclassificacaolead scl on l.codstatusclassificacaolead = scl.codstatusclassificacaolead ";
	$sql.="		  left join agendaslead al1 on al1.codreagendamento = al.codagendalead and l.codlead = al1.codlead";
	$sql.="       left join usuariosinternos ui on al.agendadopara = ui.codusuariointerno ";
	$sql.="       left join usuariosinternos ui1 on al.codusuariointerno = ui1.codusuariointerno ";
	$sql.="       left join tipoagendamento ta on al.codtipo = ta.codtipo ";
	$sql.="       left join statusagendamento sa on al.codstatus = sa.codstatus ";
	$sql.=" where 1=1 ";
	
	//parametros de pesquisa
	if(!empty($_REQUEST['cod_polo']))
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
	
	if(!empty($mailing_pk))
		$sql.="  and l.mailing_pk = ".$mailing_pk;	
	
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
				
	if(!empty($grupousuariointerno)){
		$sql.=" and ui1.codusuariointerno in (";
		$sql.="select codusuariointerno ";
		$sql.="  from gruposusuariosinternos_usuariosinternos ";
		$sql.=" where codgrupousuariointerno = $grupousuariointerno ";
		$sql.=" ) ";
	}
	
    $sql.=" order by al.datacadastro ";
    
	$result = mysql_query($sql);
	
	$cont = 0;
	while($row = mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td class='form' align='center'>".$row['codagendalead']."</td>";
		echo "<td class='form'>&nbsp;".date('d/m/Y \à\s H:i', strtotime($row['datacadastro']))."</td>";
		echo "<td class='form'>&nbsp;".date('d/m/Y \à\s H:i', strtotime($row['datahorario']))."</td>";
		echo "<td class='form'>&nbsp;<a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['razaosocial']."</a></td>";
                echo "<td class='form' align='center'>".$row['cnpj_cpf']."</td>";
                $sql ="";
                $sql.="SELECT op.dsc_operadora
                        FROM leads_operadoras lo
                             INNER JOIN operadoras op ON lo.cod_operadora = op.cod_operadora
                       WHERE lo.CodLead =".$row['codlead'];
                
                $results = mysql_query($sql);
                echo "<td class='form'>&nbsp;";
                while($rows = mysql_fetch_array($results)){
                    echo $rows['dsc_operadora']."&nbsp&nbsp";
                }
                echo  "</td>";
                echo "<td class='form'>&nbsp;".$row['qtde_linhas']."</td>";
		echo "<td class='form'>&nbsp;".$row['cidade']."</td>";
		echo "<td class='form'>&nbsp;".$row['statusclassificacaolead']."</td>";
		echo "<td class='form'>&nbsp;".$row['agendadopor']."</td>";
		echo "<td class='form'>&nbsp;".$row['agendadopara']."</td>";
		echo "<td class='form'>&nbsp;";
		
		$sql = "Select u.Nome from agendagerenteconta agc inner join usuariosinternos u on agc.CodGerenteConta = u.CodUsuarioInterno Where agc.CodAgendaLead = ".$row['codagendalead']."";
		$rsgerente = mysql_query($sql);
		while($rwgerente = mysql_fetch_array($rsgerente)){
			echo "".$rwgerente['Nome']."; ";
		}
		mysql_free_result($rsgerente); 
		echo "</td>";
		
		if(!empty($row['reagendamento']))
			$reagendado = "<span style='color:red'>(Reagendamento)</span>";
		else
			$reagendado = "";
		
		echo "<td class='form'>&nbsp;".$row['tipoagendamento']."&nbsp;".$reagendado."</td>";
                echo "<td class='form' align='center'>".str_replace(chr(13), '<br />', $row['obs_ag'])."</td>";
		echo "<td class='form'>&nbsp;".$row['statusagendamento']."</td>";
		echo "</tr>";
		$cont++;
	}
	mysql_free_result($result);
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF" colspan="15">Total: <? echo $cont;?> Agendamento(s)</td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
