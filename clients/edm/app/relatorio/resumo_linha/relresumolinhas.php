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

$led50 = $_REQUEST['led50'];
$led75 = $_REQUEST['led75'];
$cod_polo = $_REQUEST['cod_polo'];
$regentesconta = $_REQUEST['codgerenteconta'];
$dataenviopropostaini = $_REQUEST['dataenviopropostaini'];
$dataenviopropostafim = $_REQUEST['dataenviopropostafim'];
$codequipe = $_REQUEST['codequipe'];
$codatendente = $_REQUEST['codatendente'];


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
		<font size="+2">Resumo de Linhas</font>
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
			print  "Polo: ".$polo['n_polo'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['led50'])){
			print "Status = Lead 50%";
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['led75'])){
			print "Status = Lead 75%";
		}
		?>
		</td>
	</tr>
	<?
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
	?>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['codgerenteconta'])){
			$sql = "Select
					nome
					from usuariosinternos
					where codusuariointerno=".$_REQUEST['codgerenteconta'];
			$result = mysql_query($sql);
			$consultor = mysql_fetch_array($result);
			echo "Consultor = : ".$consultor['nome'];
		}
		?>
		</td>
	</tr>
		<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['codatendente'])){
			$sql = "Select
					nome
					from usuariosinternos
					where codusuariointerno=".$_REQUEST['codatendente'];
			$result = mysql_query($sql);
			$atendente = mysql_fetch_array($result);
			echo "Atendente = : ".$atendente['nome'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
				<br>
				Relatório gerado em 
				<?
				//Pegade geração do relatório
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
<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0" class="sortable">	
<?
$sql = "Select
			  tbe.tK_equipe			  		
			  ,tbe.vc_nome as equipe
			  ,ui.nome				
			from tb_equipesvendas tbe
				left join tb_usuarioequipe tbu on tbe.tk_equipe = tbu.Fk_Equipe
				left join usuariosinternos ui on tbu.FK_usuario = ui.codusuariointerno				
			where tbe.tK_equipe >0";	
		    if(!empty($codequipe))
				$sql.=" and tbe.tk_equipe = $codequipe ";									
			$sql .= " group by tbe.tK_equipe";
			$sql .= " order by tbe.vc_nome";
			
						
			$result = mysql_query($sql);	
	while($row = mysql_fetch_array($result)){	
		
		$sql = "Select
			  tbe.tK_equipe			  		
			  ,tbe.vc_nome as equipe
			  ,ui.nome
			  ,ui.codusuariointerno	
			  ,ui.atendente
			  ,ui.gerentecontas					
			from tb_equipesvendas tbe
				left join tb_usuarioequipe tbu on tbe.tk_equipe = tbu.Fk_Equipe
				left join usuariosinternos ui on tbu.FK_usuario = ui.codusuariointerno
				inner join leads l on ui.codusuariointerno = l.codgerenteconta or ui.codusuariointerno = l.codatendente
				Inner join propostas pr on l.codlead = pr.codlead						
			where tbe.tK_equipe =".$row['tK_equipe']; 
			if(!empty($led50))				
					$sql .= " and l.CodStatusClassificacaoLead = 5 ";
			if(!empty($led75))
					$sql .= " and l.CodStatusClassificacaoLead = 6 ";
			if(empty($led50) and empty($led75))
					$sql .= " and l.CodStatusClassificacaoLead in (5,6) ";
			if(!empty($regentesconta))
					$sql .= " and ui.codusuariointerno = ".$regentesconta;
			if(!empty($codatendente))
					$sql .= " and ui.codusuariointerno = ".$codatendente;		
			if(!empty($dataenviopropostaini) and !empty($dataenviopropostafim)){
					$sql .= " and pr.dataenvio >= '".DataYMD($dataenviopropostaini) . " 00:00:00'";	
					$sql .= " and pr.dataenvio <= '".DataYMD($dataenviopropostafim) . " 23:59:59'";
			}
							
			if(!empty($cod_polo))
				$sql .= " and l.cod_polo = ".$cod_polo;															
			$sql .= " group by ui.codusuariointerno";
			$sql .= " order by tbe.vc_nome";
			
			$result0 = mysql_query($sql);		
		while($row0 = mysql_fetch_array($result0)){	
			
			if($row0['atendente']=="1"){
				$tipo = "Atendenete";
			}else{
				$tipo = "Consultor";
			}
			$codequipe = $row0{'tK_equipe'};
			$equipe = $row0['equipe'];
?>
		<tr >
			<td >
					<table cellpadding=0 cellspacing=0  border=0 width=500>
					<tr>
						<td colspan=3>
							&nbsp;
						</td>
					</tr>
					<tr >
						<td align=left width=15%><font face="Arial"><b>Equipe:</b></font></td>
						<td  align=left>&nbsp;<?=$row0['equipe'];?></td>
					</tr>				
					<tr>
						<td class=detalhe align=left >&nbsp;</td>
						<td class=detalhe align=left>
							<table cellpadding=0 cellspacing=0 border=0 width=100%>
								<tr>									
									<td class=total align=left width=15%>&nbsp;<b><?=$tipo;?>:</b></td>									
									<td class=total align=left>&nbsp;<?=$row0['nome'];?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>				
			</td>
		</tr>
		<tr>		
			<td >
				<table width="100%" border="1" cellpadding="0" cellspacing="0"> 
					<tr>
						<td class="titulo" bgcolor="#8080FF" align=center width=200>Lead</td>
						<td class="titulo" bgcolor="#8080FF" align=center width=100>Status</td>
						<td class="titulo" bgcolor="#8080FF" align=center width=90>Linhas Novas</td>
						<td class="titulo" bgcolor="#8080FF" align=center width=90>Linhas Adição</td>
						<td class="titulo" bgcolor="#8080FF" align=center width=90>Linhas Portabilidade</td>
						<td class="titulo" bgcolor="#8080FF" align=center width=90>Linhas Renovação</td>
						<td class="titulo" bgcolor="#8080FF" align=center width=90>Linhas Migração</td>
						<td class="titulo" bgcolor="#8080FF" align=center width=90>Linhas Transfêrencia</td>
						<td class="titulo" bgcolor="#8080FF" align=center width=90>Total</td>	
					</tr>

<?	
			$sql = "Select
					   l.codlead
					  ,l.razaosocial
					  , DATE_FORMAT(pr.datarecebimento,'%d/%m/%y') as recebe_assinatura
					  ,DATE_FORMAT(pr.dataenviocontrato,'%d/%m/%y') as envio_contrato
					  ,TIMESTAMPDIFF( DAY , DATE_FORMAT(MAX(pr.datarecebimento),'%y/%m/%d')  ,DATE_FORMAT(MAX(dataenviocontrato),'%y/%m/%d') ) AS lead_time
					   ,case when mp.id='qtdelinhasnovas' then
					    mp.valor
					  end qtdelinhasnovas
					  	  ,case when mp1.id='qtdelinhasadicao' then
					    mp1.valor
					  end qtdelinhasadicao
					  ,case when mp2.id='qtdelinhasportabilidade' then
					    mp2.valor
					  end qtdelinhasportabilidade
					  ,case when mp3.id='qtdelinhasrenovacao' then
					    mp3.valor
					  end qtdelinhasrenovacao
					  ,case when mp4.id='qtdelinhasmigracao' then
					    mp4.valor
					  end qtdelinhasmigracao
					,case when mp5.id='qtdelinhastransferencia' then
					    mp5.valor
					  end qtdelinhastransferencia
					,scl.descricao as status  										 
					 from leads l 
					 	inner join statusclassificacaolead scl on l.codstatusclassificacaolead = scl.codstatusclassificacaolead	
						left join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno
						left join tb_usuarioequipe tbu on tbu.FK_usuario = ui.codusuariointerno						  				
		  				Inner join propostas pr on l.codlead = pr.codlead
		  				inner join produtos p on pr.CodProduto = p.codproduto
		  				inner join modulosproposta mp on pr.CodProposta = mp.CodProposta and pr.versao = mp.versao and pr.CodLead = mp.codlead and mp.id='qtdelinhasnovas'
		  				inner join modulosproposta mp1 on pr.CodProposta = mp1.CodProposta and pr.versao = mp1.versao and pr.CodLead = mp1.codlead and mp1.id='qtdelinhasadicao'
						inner join modulosproposta mp2 on pr.CodProposta = mp2.CodProposta and pr.versao = mp2.versao and pr.CodLead = mp2.codlead and mp2.id='qtdelinhasportabilidade'
						inner join modulosproposta mp3 on pr.CodProposta = mp3.CodProposta and pr.versao = mp3.versao and pr.CodLead = mp3.codlead and mp3.id='qtdelinhasrenovacao'
						inner join modulosproposta mp4 on pr.CodProposta = mp4.CodProposta and pr.versao = mp4.versao and pr.CodLead = mp4.codlead and mp4.id='qtdelinhasmigracao'
						inner join modulosproposta mp5 on pr.CodProposta = mp5.CodProposta and pr.versao = mp5.versao and pr.CodLead = mp5.codlead and mp5.id='qtdelinhastransferencia'					  										  					
		  			where (l.codgerenteconta=".$row0['codusuariointerno']." or l.codatendente=".$row0['codusuariointerno'].")";
		  			$sql.="	and pr.DataCancelamento Is Null";
					if(!empty($led50))				
						$sql .= " and l.CodStatusClassificacaoLead = 5 ";
					if(!empty($led75))
						$sql .= " and l.CodStatusClassificacaoLead = 6 ";
					if(empty($led50) and empty($led75))
						$sql .= " and l.CodStatusClassificacaoLead in (5,6) ";
					if(!empty($dataenviopropostaini) and !empty($dataenviopropostafim)){
						$sql .= " and pr.dataenvio >= '".DataYMD($dataenviopropostaini) . " 00:00:00'";	
						$sql .= " and pr.dataenvio <= '".DataYMD($dataenviopropostafim) . " 23:59:59'";
					}			
					if(!empty($cod_polo))
						$sql .= " and l.cod_polo = ".$cod_polo;																
					$sql .= " group by l.codlead,pr.codproposta,pr.versao";					  			
										
			$result1 = mysql_query($sql);
			$total_linha = 0 ;//ZERA A VARIAVEL TOTAL POR LINHA A CADA LOOP
			while($row1 = mysql_fetch_array($result1)){
				$qleads ++;//Variavel soma a quantidade de Leads %
				$qtdelinhasnovas = $qtdelinhasnovas + $row1['qtdelinhasnovas'];//Totaliza a quantidade de linhas novas		
				$qtdelinhasadicao = $qtdelinhasadicao + $row1['qtdelinhasadicao'];//Totaliza a quantidade de linhas adicao			  			
				$qtdelinhasportabilidade = $qtdelinhasportabilidade + $row1['qtdelinhasportabilidade'];//Totaliza a quantidade de linhas portabilidade
				$qtdelinhasrenovacao = $qtdelinhasrenovacao + $row1['qtdelinhasrenovacao']; //Totaliza a quantidade de linhas renovacao
				$qtdelinhasmigracao = $qtdelinhasmigracao + $row1['qtdelinhasmigracao'];;//Totaliza a quantidade de linhas migracao
				$qtdelinhastransferencia = $qtdelinhastransferencia+ $row1['qtdelinhastransferencia'];//Totaliza a quantidade de linhas transferencia
				$total_linha = $row1['qtdelinhasnovas'] + $row1['qtdelinhasadicao'] + $row1['qtdelinhasportabilidade'] + $row1['qtdelinhasrenovacao'] + $row1['qtdelinhasmigracao'] + $row1['qtdelinhastransferencia'] ;
				print "	<tr>";		
				print "		<td   align=left   >";
								?><a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<?=$row1['codlead']; ?>', 800, 600);"><font class="Detalhe" size="2"><?=$row1['razaosocial'];?></font></a><?				
				print "	 	</td>";
			   	print "		<td class=form     align=center >";
			   	print ""	.$row1['status'];"";
			   	print "		</td>";
				print "		<td class=form   align=center>";
			   	print "&nbsp;"	.$row1['qtdelinhasnovas'];"";
			   	print "		</td>";
			    print "		<td class=form  align=center>";
			   	print "&nbsp;".$row1['qtdelinhasadicao'];"";
			   	print "		</td>";
			   	print "		<td class=form  align=center>";
			   	print "&nbsp;".$row1['qtdelinhasportabilidade'];"";
			   	print "		</td>";
		        print "		<td class=form  align=center>";
			   	print "&nbsp;".$row1['qtdelinhasrenovacao'];"";
			   	print "		</td>";
			    print "		<td class=form  align=center>";
			   	print "&nbsp;".$row1['qtdelinhasmigracao'];"";
			   	print "		</td>";
			   	print "		<td class=form  align=center>";
			   	print "&nbsp;".$row1['qtdelinhastransferencia'];"";
			   	print "		</td>";	
			   	print "		<td class=form  align=center>";
			   	print ""	.$total_linha;"";
			   	print "		</td>";
				print "	</tr>";

				$total_linha_consultor = $total_linha_consultor + $total_linha;
				$total_linha = 0 ;//ZERA A VARIAVEL TOTAL POR LINHA A CADA LOOP
			}
			print "	<tr>";//LINHA TOTALIZADORA POR CONSULTOR	
			print "		<td class=titulo bgcolor=#8080FF  align=left   >";
			print "  		&nbsp;Total Lead(s) &nbsp";	
			print "     	&nbsp;".$qleads;"";					
			print "	    </td>";
		   	print "		<td class=titulo bgcolor=#8080FF align=center >";
		   	print "			&nbsp;";
		   	print "		</td>";
			print "		<td class=titulo bgcolor=#8080FF  align=center>";
		   	print "         &nbsp;".$qtdelinhasnovas;"";
		   	print "		</td>";
		    print "		<td class=titulo bgcolor=#8080FF  align=center>";
		   	print "         &nbsp;".$qtdelinhasadicao;"";
		   	print "		</td>";
		   	print "		<td class=titulo bgcolor=#8080FF  align=center>";
		   	print "         &nbsp;".$qtdelinhasportabilidade;"";
		   	print "		</td>";
	        print "		<td class=titulo bgcolor=#8080FF  align=center>";
		   	print "         &nbsp;"	.$qtdelinhasrenovacao;"";
		   	print "		</td>";
		    print "		<td class=titulo bgcolor=#8080FF  align=center>";
		   	print "        &nbsp;".$qtdelinhasmigracao;"";
		   	print "		</td>";
		   	print "		<td class=titulo bgcolor=#8080FF  align=center>";
		   	print "       &nbsp;".$qtdelinhastransferencia;"";
		   	print "		</td>";	
		   	print "		<td class=titulo bgcolor=#8080FF  align=center>";
		   	print ""		    .$total_linha_consultor;"";
		   	print "		</td>";
			print "	</tr>";
			$qtotalleads = $qtotalleads + $qleads;
			$qleads = 0;	
			$qtdelinhasnovastotal =  $qtdelinhasnovastotal + $qtdelinhasnovas; 
			$qtdelinhasnovas = 0;
			$qtdelinhasadicaototal = $qtdelinhasadicaototal + $qtdelinhasadicao;
			$qtdelinhasadicao = 0;
			$qtdelinhasportabilidadetotal = $qtdelinhasportabilidadetotal + $qtdelinhasportabilidade; 
			$qtdelinhasportabilidade = 0;
			$qtdelinhasrenovacaototal = $qtdelinhasrenovacaototal + $qtdelinhasrenovacao;
			$qtdelinhasrenovacao = 0;
			$qtdelinhasmigracaototal = $qtdelinhasmigracaototal + $qtdelinhasmigracao;
			$qtdelinhasmigracao = 0;
			$qtdelinhastransferenciatotal = $qtdelinhastransferenciatotal + $qtdelinhastransferencia; 
			$qtdelinhastransferencia = 0;
			$total_linha_consultor_total = $total_linha_consultor_total + $total_linha_consultor;		
			$total_linha_consultor = 0;
			print "</table>";
			print "</td>";
			print "</tr>";
		}
		if(!empty($codequipe)){//TOTAL POR EQUIPE
				print "		<tr>";
				print "			<td colspan=3>";
				print "				&nbsp;";
				print "			</td>";
				print "		</tr>";
				print "		<tr>";
				print "			<td  align=left colspan=4 >";
				print "     		&nbsp;<b>Total por Equipe</b>";	
				print "             &nbsp;".$equipe;"";	
				print "			</td>";
				print "		</tr>";	
				print "		<tr>";//LINHA TOTALIZADORA POR CONSULTOR	
				print "			<td colspan=3>";
				print "				<table cellspacing=0 cellpadding=0 align=left width=100% border=1 >";
				print "					<tr>";
				print "						<td class=titulo bgcolor=#8080FF align=left  width=200 >";
				print "  						&nbsp;Total Lead(s) &nbsp";	
				print "     					&nbsp;".$qtotalleads;"";					
				print "	 					</td>";
			   	print "						<td class=titulo bgcolor=#8080FF  align=center width=100 >";
			   	print "							&nbsp;";
			   	print "						</td>";
				print "						<td class=titulo bgcolor=#8080FF align=center width=90>";
			   	print "&nbsp;"					.$qtdelinhasnovastotal;"";
			   	print "						</td>";
			    print "						<td class=titulo bgcolor=#8080FF  align=center width=90>";
			   	print "&nbsp;"					.$qtdelinhasadicaototal;"";
			   	print "						</td>";
			   	print "						<td class=titulo bgcolor=#8080FF align=center width=90>";
			   	print "&nbsp;"					.$qtdelinhasportabilidadetotal;"";
			   	print "						</td>";
		        print "						<td class=titulo bgcolor=#8080FF align=center width=90>";
			   	print "&nbsp;"					.$qtdelinhasrenovacaototal;"";
			   	print "						</td>";
			    print "						<td class=titulo bgcolor=#8080FF align=center width=90>";
			   	print "&nbsp;"					.$qtdelinhasmigracaototal;"";
			   	print "						</td>";
			   	print "						<td class=titulo bgcolor=#8080FF align=center width=90>";
			   	print "&nbsp;"					.$qtdelinhastransferenciatotal;"";
			   	print "						</td>";	
			   	print "						<td class=titulo bgcolor=#8080FF align=center width=90>";
			   	print ""						.$total_linha_consultor_total;"";
			   	print "						</td>";
			   	print "					</tr>";
			   	print "				</table>";
			   	print "			</td>";
				print "		</tr>";
				$codequipe = "";
				$equipe = "";
				$qtotalleadsgeral = $qtotalleadsgeral + $qtotalleads;
				$qtotalleads = 0;
				
				$qtdelinhasnovastotalgeral = $qtdelinhasnovastotalgeral + $qtdelinhasnovastotal;//total Geral linhas novoas
				$qtdelinhasnovastotal = 0;//Zera variavel total de linhas novas para o proximo loop
				$qtdelinhasadicaototalgeral = $qtdelinhasadicaototalgeral + $qtdelinhasadicaototal;//Total Geral linhas de Adição
				$qtdelinhasadicaototal = 0;//Zera variavel total de linhas de adição
				$qtdelinhasportabilidadetotalgeral = $qtdelinhasportabilidadetotalgeral + $qtdelinhasportabilidadetotal;//Total Geral Linhas de portabilidade
				$qtdelinhasportabilidadetotal = 0;//Zera variavel total de linhas de portabilidade
				$qtdelinhasrenovacaototalgeral = $qtdelinhasrenovacaototalgeral + $qtdelinhasrenovacaototal;//Total Geral de linhas renivacao
				$qtdelinhasrenovacaototal = 0;//Zera variavel total de linhas de renovação
				$qtdelinhasmigracaototalgeral = $qtdelinhasmigracaototalgeral + $qtdelinhasmigracaototal;//talta Geral de linhas migração
				$qtdelinhasmigracaototal = 0 ;
				$qtdelinhastransferenciatotalgeral = $qtdelinhastransferenciatotalgeral + $qtdelinhastransferenciatotal;//Total geral de linhas de migraçõ
				$qtdelinhastransferenciatotal = 0;
				$total_linha_consultor_total_geral = $total_linha_consultor_total + $total_linha_consultor_total;
				$total_linha_consultor_total = 0;			
			$equipegeral = "";
			}
	}
		print "		<tr>";
		print "			<td colspan=3>";
		print "				&nbsp;";
		print "			</td>";
		print "		</tr>";
		print "		<tr>";
		print "			<td  align=left colspan=5 >";
		print "     		&nbsp;<b>Total Geral</b>";
		print "			</td>";
		print "		</tr>";	
		print "			<td colspan=3>";
		print "				<table cellspacing=0 cellpadding=0 align=left width=100% border=1 >";
		print "					<tr>";
		print "						<td class=titulo bgcolor=#8080FF  align=left  width=200 >";
		print "  						&nbsp;Total Lead(s) &nbsp";	
		print "     					&nbsp;".$qtotalleadsgeral;"";					
		print "	 					</td>";
	   	print "						<td class=titulo bgcolor=#8080FF  align=center width=100 >";
	   	print "							&nbsp;";
	   	print "						</td>";
		print "						<td class=titulo bgcolor=#8080FF  align=center width=90>";
	   	print "&nbsp;"					.$qtdelinhasnovastotalgeral;"";
	   	print "						</td>";
	    print "						<td class=titulo bgcolor=#8080FF  align=center width=90>";
	   	print "&nbsp;"					.$qtdelinhasadicaototalgeral;"";
	   	print "						</td>";
	   	print "						<td class=titulo bgcolor=#8080FF  align=center width=90>";
	   	print "&nbsp;"					.$qtdelinhasportabilidadetotalgeral;"";
	   	print "						</td>";
        print "						<td class=titulo bgcolor=#8080FF  align=center width=90>";
	   	print "&nbsp;"					.$qtdelinhasrenovacaototalgeral;"";
	   	print "						</td>";
	    print "						<td class=titulo bgcolor=#8080FF  align=center width=90>";
	   	print "&nbsp;"					.$qtdelinhasmigracaototalgeral;"";
	   	print "						</td>";
	   	print "						<td class=titulo bgcolor=#8080FF  align=center width=90>";
	   	print "&nbsp;"					.$qtdelinhastransferenciatotalgeral;"";
	   	print "						</td>";	
	   	print "						<td class=titulo bgcolor=#8080FF  align=center width=90>";
	   	print ""						.$total_linha_consultor_total_geral;"";
	   	print "						</td>";
	   	print "					</tr>";
	   	print "				</table>";
		print "			</td>";
		print "		</tr>";	
?>
</table>


