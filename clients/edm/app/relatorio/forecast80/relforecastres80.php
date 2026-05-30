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
		<font size="+2">Relatório Controle Forecast 80%</font>
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
			print  "Pólo: ".$polo['n_polo'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['codequipe'])){
			$sql = "Select
					Vc_Nome
					from tb_equipesvendas
					where Tk_Equipe=".$_REQUEST['codequipe'];
			$result = mysql_query($sql);
			$equipe = mysql_fetch_array($result);
			echo "Equipe: ".$equipe['Vc_Nome'];
		}
		?>
		</td>
	</tr>		
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
			echo "Consultor: ".$consultor['nome'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
			<?
			if(!empty($_REQUEST['datarecebini'])){
				echo "Data de Recebimento entre: ".$_REQUEST['datarecebini']." e ".$_REQUEST['datarecebfim'];
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
<table width="100%" cellspacing="0" cellpadding="0" align="center" border="1" >	
<?
	print "	<tr>";
	print "		<td class=titulo bgcolor=#8080FF align=center > Equipe</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center > Consultor</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center width=250 >Lead</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center  >Proposta</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center  >Dt de Rec</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center  >Qtde Dias da Dt. Rec.</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center  >Novas</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center  >Adição</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center  >Portab.</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center  >Renov.</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center  >Migraç.</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center  >Transf.</td>";
	print "		<td class=titulo bgcolor=#8080FF align=center  >Total</td>";
	print "	</tr>";
	$sql = "SELECT l.CodLead,
				   np.pk propostas_pk,
				   SUBSTR(l.razaosocial, 1, 25) AS razaosocial,
				   tbe.vc_nome AS equipe,
				   ui.nome AS consultor,
				   TIMESTAMPDIFF(DAY,
								 DATE_FORMAT(MAX(ndp.vl_data_proposta), '%y/%m/%d'),
								 SYSDATE())
					  AS delay,
					DATE_FORMAT(ndp.vl_data_proposta, '%d/%m/%Y') dt_recebimento, 
					nip.n_qtde,
					nptl.dsc_tipo_linha,
					l.codlead,
					np.operador_pk
			  FROM leads l
				   LEFT JOIN usuariosinternos ui
					  ON l.codgerenteconta = ui.codusuariointerno
				   LEFT JOIN tb_usuarioequipe tbu
					  ON tbu.FK_usuario = ui.codusuariointerno
				   LEFT JOIN tb_equipesvendas tbe ON tbe.tk_equipe = tbu.Fk_Equipe
				   INNER JOIN n_propostas np ON l.CodLead = np.leads_pk
				   LEFT JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
				   LEFT JOIN n_itens_propostas_operadoras nipo ON nip.pk = nipo.itens_propostas_pk
				   LEFT JOIN n_produto_tipo_linha nptl ON nipo.tipo_linha_pk = nptl.pk
				   INNER JOIN n_datas_proposta ndp ON np.pk = ndp.propostas_pk
				   INNER JOIN n_data_proposta_operador ndpo
					  ON     ndp.data_proposta_operador_pk = ndpo.pk
						 AND ndpo.ds_label_data = 'recebe_assinatura'";

	if(!empty($_REQUEST['codgerenteconta'])){
		$sql .= " and ui.codusuariointerno = ".$_REQUEST['codgerenteconta'];
	}							
	if(!empty($_REQUEST['codequipe']))	{	
		$sql .= " and tbe.Tk_Equipe = ".$_REQUEST['codequipe'];
	}
	if(!empty($_REQUEST['datarecebini']) and !empty($_REQUEST['datarecebfim'])){
		$sql .= " and dp.valor_data >= '".DataYMD($_REQUEST['datarecebini']) . " 00:00:00'";	
		$sql .= " and dp.valor_data <= '".DataYMD($_REQUEST['datarecebfim']) . " 23:59:59'";
	}		
	if(!empty($_REQUEST['cod_polo'])){			
		$sql .= " and l.cod_polo = ".$_REQUEST['cod_polo'];
	}
	$sql.="	Where l.CodStatusClassificacaoLead=10 
			AND np.dt_cancelamento IS NULL";								
	$sql.="	GROUP BY l.CodLead, np.pk";	
		
			$result80 = mysql_query($sql);	
			while($row80 = mysql_fetch_array($result80)){						  			
				$qleads80 ++;//Variavel soma a quantidade de Leads 50%
				
				$total_linhas += $row80['n_qtde'];
				
				print "	<tr>";
  				print "		<td  width=90 align=center class='form'>";
			   	print ""		.$row80['equipe'];"&nbsp;";
			   	print "		&nbsp;</td>";
			   	print "		<td  width=90 align=center class='form'>";
			   	print ""		.$row80['consultor'];"&nbsp;";
			   	print "		&nbsp;</td>";
				print "		<td   align=left width=290 class=form>";
							?>			        
								<a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<?=$row80['codlead']; ?>', 800, 600);"><font class="Detalhe" size="2"><?=$row80['razaosocial'];?></font></a>
							<?				
				print "	 </td>";
				print "		<td  width=90 align=center class=form>";
							?>			        
								<a href="#" onClick="javascript: NewWindow('../../vendas/leads/propostas_cad_form.php?pk=<?=$row80['propostas_pk']; ?>', 1160, 600);"><font class="Detalhe" size="2"><?=$row80['propostas_pk'];?></font></a>								
							<?	
			   	print "		&nbsp;</td>";
			   	print "		<td  width=90 align=center class=form>";
			   				?>			        
								<a href="#" onClick="javascript: NewWindow('../../vendas/leads/adm_propostas_cad_form.php?codlead=<?=$row80['codlead']; ?>&pk=<?=$row80['propostas_pk'];?>&operador_pk=<?=$row80['operador_pk'];?>', 800, 550);"><font class="Detalhe" size="2"><?=$row80['dt_recebimento'];?></font></a>								
							<?	
			   	//print ""		.$row80['dt_recebimento'];"&nbsp;";
			   	print "		&nbsp;</td>";
			    print "		<td  width=90 align=center class=form>";
			   	print ""		.$row80['delay'];"&nbsp;";
			   	print "		&nbsp;</td>";
			   	print "		<td  width=90 align=center class=form>";
			   	if($row80['dsc_tipo_linha']=='LI Novas'){
					print "".$row80['n_qtde'];"&nbsp;";
					$qtdelinhasnovas += $row80['n_qtde'];
				}else{
					print "&nbsp;";
				}
				print "		&nbsp;</td>";
				print "		<td  width=90 align=center class=form>";	
			   	if($row80['dsc_tipo_linha']=='LI Adição'){
					print "".$row80['n_qtde'];"&nbsp;";
					$qtdelinhasadicao +=$row80['n_qtde'];
				}else{
					print "&nbsp;";
				}
				print "		&nbsp;</td>";
				print "		<td  width=90 align=center class=form>";	
				if($row80['dsc_tipo_linha']=='LI Portabilidade'){
					print "".$row80['n_qtde'];"&nbsp;";
					$qtdelinhasportabilidade += $row80['n_qtde'];
				}else{
					print "&nbsp;";
				}	
				print "		&nbsp;</td>";
				print "		<td  width=90 align=center class=form>";
				if($row80['dsc_tipo_linha']=='LI Renovação'){
					print "".$row80['n_qtde'];"&nbsp;";
					$qtdelinhasrenovacao += $row80['n_qtde'];
				}else{
					print "&nbsp;";
				}
				print "		&nbsp;</td>";
				print "		<td  width=90 align=center class=form>";
				if($row80['dsc_tipo_linha']=='LI Migração'){
					print "".$row80['n_qtde'];"&nbsp;";
					$qtdelinhasmigracao = $row80['n_qtde'];
				}else{
					print "&nbsp;";
				}
				print "		&nbsp;</td>";
				print "		<td  width=90 align=center class=form>";
				if($row80['dsc_tipo_linha']=='LI Transferência'){
					print "".$row80['n_qtde'];"&nbsp;";
					$qtdelinhastransferencia +=$row80['n_qtde'];
				}else{
					print "&nbsp;";
				}
				print "		&nbsp;</td>";
				
			    print "		<td  width=100 align=center class=form>";
			   	print ""		.$total_linhas;"&nbsp;";
			   	print "		</td>";
  				print "	</tr>";	
			  	$total_linhas_geral = $total_linhas_geral + $total_linhas;
			  	$total_linhas = 0;							   				   							   	
			}	
			if($qleads80 > 0 ){
						print "	<tr>";
						print "	 	<td class=titulo bgcolor=#8080FF colspan='6'>";
						print "  		&nbsp;Total Lead(s) &nbsp";	
						print "     	&nbsp;".$qleads80;"";
						print "		</td>";
						print "		<td class=titulo bgcolor=#8080FF  align=center>";
						print ""		.$qtdelinhasnovas;"";
						print "		</td>";
						print "		<td class=titulo bgcolor=#8080FF  align=center>";
						print ""		.$qtdelinhasadicao;"";
						print "		</td>";
						print "		<td class=titulo bgcolor=#8080FF  align=center>";
						print ""		.$qtdelinhasportabilidade;"";
						print "		</td>";
						print "		<td class=titulo bgcolor=#8080FF  align=center>";
						print ""		.$qtdelinhasrenovacao;"";
						print "		</td>";
						print "		<td class=titulo bgcolor=#8080FF  align=center>";
						print ""		.$qtdelinhasmigracao;"";
						print "		</td>";
						print "		<td class=titulo bgcolor=#8080FF  align=center>";
						print ""		.$qtdelinhastransferencia;"";
						print "		</td>";
					    print "		<td class=titulo bgcolor=#8080FF  align=center>";
						print ""		.$total_linhas_geral;"";
						print "		</td>";
				    	print "	</tr>";	
				}
						//print "</table>";							
					//TOTALIZA LEAD  POR EQUIPE	
					$qleads80 = 0;	
					$qtdelinhasnovas = 0;
					$qtdelinhasadicao = 0;
					$qtdelinhasportabilidade = 0;
					$qtdelinhasrenovacao = 0;
					$qtdelinhasmigracao = 0;
					$qtdelinhastransferencia = 0;
					$total_linhas_consultor = 0;				
?>
</table>
