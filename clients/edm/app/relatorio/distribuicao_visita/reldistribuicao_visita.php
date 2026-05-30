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
		<font size="+2">Distribuição de Visitas</font>
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
	if(!empty($_REQUEST['codtipo'])){
		$sql = "Select CodTipo, Descricao" ;
		$sql .= " From tipoagendamento";
		$sql .= " Where codtipo=".$_REQUEST['codtipo'];
		$sql .= " Order by Descricao";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		?>
		<tr>
			<td>Tipo Agendamento: <?= $row['Descricao'];?></td>
		</tr>
		<?
		mysql_free_result($result);
	}
	if(!empty($_REQUEST['datavisitaini'])){
		?>
		<tr>
			<td>Data Visita (Início): <?= $_REQUEST['datavisitafim'];?></td>
		</tr>
		<?
	}
	if(!empty($_REQUEST['datavisitaini'])){
		?>
		<tr>
			<td>Data Visita (Fim): <?= $_REQUEST['datavisitafim'];?></td>
		</tr>
		<?
	}
	?>		
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
			<td class="titulo" bgcolor="#8080FF" width=10  >#</td>
			<td class="titulo" bgcolor="#8080FF" width=200>Razão Social</td>
			<td class="titulo" bgcolor="#8080FF" width=100>Dt Visita</td>
			<td class="titulo" bgcolor="#8080FF" width=100>Hr Visita</td>
			<td class="titulo" bgcolor="#8080FF" width=100>Consultor</td>
			<td class="titulo" bgcolor="#8080FF" width=100>Tam. Visita</td>
			<td class="titulo" bgcolor="#8080FF" width=100>Tipo Linhas</td>
			<td class="titulo" bgcolor="#8080FF" width=100>Bairro</td>
			<td class="titulo" bgcolor="#8080FF" width=100>Cidade</td>
			<td class="titulo" bgcolor="#8080FF" width=100>Agendado por</td>
		</tr>
	</thead>
	<tbody>
<?
		$sql = "Select 
					l.razaosocial
					,l.codlead
					,ag.codagendalead		
					,DATE_FORMAT(ag.DataHorario,'%d/%m/%y') as data_visita
					,DATE_FORMAT(ag.DataHorario,'%H:%i') as hora_visita 
					,ui.nome as consultor
					,case ag.cod_tamanho_visita 
						when 1 then
							'Pequena'
						when 2 then
							'Média'
						when 3 then
							'Grande'
					end tamanho_visita		
					,ag.linha_nova
					,ag.linha_adicao
					,ag.linha_portabilidade
					,ag.linha_renovacao
					,ag.linha_migracao
					,ag.linha_transferencia
					,l.bairro	
					,l.cidade
					,ui1.Nome as agendado_por
				from leads l
					inner join agendaslead ag on l.CodLead = ag.codlead
					left join agendagerenteconta agc on ag.CodAgendaLead = agc.CodAgendaLead
					left join usuariosinternos ui on agc.CodGerenteConta = ui.codusuariointerno
					left join usuariosinternos ui1 on ag.codusuariointerno = ui1.CodUsuarioInterno						
			where ag.codagendalead > 0 
			and ui1.desativado<>1"; //verifica se os usuarios estao ativos
			if(!empty($_REQUEST['cod_polo']))
					$sql .= " and l.cod_polo = ".$_REQUEST['cod_polo'];	
				
			if(!empty($_REQUEST['bairro']))
					$sql.=" and l.bairro like '%".$_REQUEST['bairro']."%' ";
					
			if(!empty($_REQUEST['cidade']))
					$sql.=" and l.cidade like '%".$_REQUEST['cidade']."%' ";		
				
			if(!empty($_REQUEST['datavisitaini']) and !empty($_REQUEST['datavisitafim'])){
					$sql .= " and ag.DataHorario >= '".DataYMD($_REQUEST['datavisitaini']) . " 00:00:00'";	
					$sql .= " and ag.DataHorario <= '".DataYMD($_REQUEST['datavisitafim']) . " 23:59:59'";
			}
	
			if(!empty($_REQUEST['codtipo']))
					$sql .= " and ag.codtipo = ".$_REQUEST['codtipo'];	

			$sql .= " order by ag.cod_tamanho_visita ";	
            
			$vcount = 1 ;
			
			$result = mysql_query($sql);			
	//	print "	<table cellspacing=0 cellpadding=0 align=left width=900 border=1 >";
		while($row = mysql_fetch_array($result)){
			print "	<tr>";	
			print "		<td class='form' align='center' >";
		   	print ""		.$vcount;"";		   	
		   	print "		</td>";		
			print "		<td  class='form' align='left'  >";
				?><a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<?=$row['codlead']; ?>', 800, 600);"><font class="Detalhe"><?=$row['razaosocial'];?></font></a><?				
			print "	 	</td>";		
			print "		<td   align=center   >";
				?><a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadsagendanew.php?codagendalead=<?=$row['codagendalead']; ?>', 800, 600);"><font class="Detalhe"><?=$row['data_visita'];?></font></a><?				
			print "	 	</td>";
			print "		<td class='form' align='center' >";
		   	print ""		.$row['hora_visita'];"";		   	
		   	print "		</td>";
		   	print "		<td class='form' align='center' >";
		   	print "&nbsp;"		.$row['consultor'];"";		   	
		   	print "		</td>";
		   	print "		<td class='form' align='center' >";
		   	print "&nbsp;"		.$row['tamanho_visita'];"";		   	
		   	print "		</td>";
		   	print "		<td class='form' align='center' >";		   				
					   	if(!empty($row['linha_nova'])){
							print " Linha Nova<br>";
						}
						if(!empty($row['linha_adicao'])){
							print " Linha Adição<br>";
						}
						if(!empty($row['linha_portabilidade'])){
							print " Linha Portabilidade<br>";
						}        
						if(!empty($row['linha_renovacao'])){
							print " Linha Renovação<br>";
						}  	
						if(!empty($row['linha_migracao'])){
							print " Linha Migração<br>";
						}
						if(!empty($row['linha_transferencia'])){
							print " Linha Transferenciao";
						} 
						print "&nbsp;";  	
		   	print "		</td>";
		   	print "		<td class='form' align='center'>";
		   	print ""		.$row['bairro'];"";		   	
		   	print "		</td>";
		    print "		<td class='form' align='center'>";
		   	print ""		.$row['cidade'];"";		   	
		   	print "		</td>";
		   	print "		<td class='form' align='center' >";
		   	print "&nbsp;"		.$row['agendado_por'];"";		   	
		   	print "		</td>";
			print "	</tr>";
			$vcount = $vcount + 1;	
			//$totalleads = $totalleads + $vcount;
		}
		print " 	<tr>";
		print "			<td class=titulo bgcolor=#8080FF colspan=9>";
		//print "			Total&nbsp;";
		//print "			".$vcount;"";
		print "			</td>";
		print " 	</tr>";		
		print " </table>";

include_once "../../libs/desconectar.php";
?>



