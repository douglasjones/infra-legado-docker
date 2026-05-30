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
		<font size="+2">Relatório Controle Forecast 90%</font>
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
			echo  "Polo: ".$polo['n_polo'];
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
			echo "Equioe: ".$equipe['Vc_Nome'];
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
<table width="100%" cellspacing="0" cellpadding="0" align="center" border="1">	
<?
echo "	<tr>";
echo "		<td class=titulo bgcolor=#8080FF align=center >Equipe</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center >Consultor</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center width=250>Lead</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Proposta</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Dt Rec</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Qtde Dias da Dt. Rec.</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Dt Input Oper</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Qtde Dias<br>entre Dt Rec e Input.</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Qtde Dias Dt. Input.</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Novas</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Adição</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Portab.</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Renov.</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Migraç.</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Transf.</td>";
echo "		<td class=titulo bgcolor=#8080FF align=center  >Total</td>";
echo "	</tr>";
	$sql = "SELECT l.CodLead,
				   np.pk propostas_pk,
				   SUBSTR(l.razaosocial, 1, 25) AS razaosocial,
				   tbe.vc_nome AS equipe,
				   ui.nome AS consultor,
				   TIMESTAMPDIFF(DAY,
								 DATE_FORMAT(MAX(ndp.vl_data_proposta), '%y/%m/%d'),
								 SYSDATE())
					  AS delay,
					TIMESTAMPDIFF(DAY, DATE_FORMAT(MAX(ndp.vl_data_proposta),'%y/%m/%d')  , ndp1.vl_data_proposta) as dt_delay_input,	
					TIMESTAMPDIFF(DAY,
								 DATE_FORMAT(MAX(ndp1.vl_data_proposta), '%y/%m/%d'),
								 SYSDATE())
					  AS delay_operadora,  
					DATE_FORMAT(ndp.vl_data_proposta, '%d/%m/%Y') dt_recebimento, 
					DATE_FORMAT(ndp1.vl_data_proposta, '%d/%m/%Y') dt_imput_operadora, 
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
						 AND ndpo.ds_label_data = 'recebe_assinatura'
					INNER JOIN n_datas_proposta ndp1 ON np.pk = ndp1.propostas_pk
						   INNER JOIN n_data_proposta_operador ndpo1
							  ON     ndp1.data_proposta_operador_pk = ndpo1.pk
								 AND ndpo1.ds_label_data = 'envio_contrato_operadora'";

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
			$sql.="	Where l.CodStatusClassificacaoLead=12
					AND np.dt_cancelamento IS NULL";								
			$sql.="	GROUP BY l.CodLead, np.pk";	
			
			$result80 = mysql_query($sql);
			$v1 = 1;
			
			while($row80 = mysql_fetch_array($result80)){						  			
				$qleads80 ++;//Variavel soma a quantidade de Leads 50%				
				$total_linhas += $row80['n_qtde'];
				echo "	<tr>";
  				echo "		<td class=form align=center>";
			   	echo $row80['equipe'];"</font>";
			   	echo "		&nbsp;</td>";
			   	
			   	echo "		<td class=form  align=center>";
			   	echo $row80['consultor'];"</font>;";
			   	echo "		&nbsp;</td>";
			   	
				echo "		<td class='form'  align=left >";							
							?>			        
								<a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<?=$row80['codlead']; ?>', 800, 600);"><font class="Detalhe" size="2"><?=$row80['razaosocial'];?></font></a>
							<?	
										
				echo "	 </td>";
				
			   	echo "		<td class=form align=center>";
			   				?>			        
								<a href="#" onClick="javascript: NewWindow('../../vendas/leads/propostas_cad_form.php?pk=<?=$row80['propostas_pk']; ?>', 1160, 600);"><font class="Detalhe" size="2"><?=$row80['propostas_pk'];?></font></a>								
							<?	
			   	echo "		</td>";	
			   		
				echo "		<td  width=90 align=center class=form>";
							?>			        
								<a href="#" onClick="javascript: NewWindow('../../vendas/leads/adm_propostas_cad_form.php?codlead=<?=$row80['codlead']; ?>&pk=<?=$row80['propostas_pk'];?>&operador_pk=<?=$row80['operador_pk'];?>', 800, 550);"><font class="Detalhe" size="2"><?=$row80['dt_recebimento'];?></font></a>								
							<?				
			   	echo "		&nbsp;</td>";
			   	
			   	echo "		<td class=form  align=center>";
			   	echo ""		.$row80['delay'];
			   	echo "		&nbsp;</td>";
			   	
			   	echo "		<td class=form  align=center>";
			   	echo ""		.$row80['dt_imput_operadora'];
			   	echo "		&nbsp;</td>";	
			   	
			   	echo "		<td class=form  align=center>";
			   	echo ""		.$row80['dt_delay_input'];
			   	echo "		&nbsp;</td>";	
						
				echo "		<td class=form  align=center>";
			   	echo ""		.$row80['delay_operadora'];
			   	echo "		&nbsp;</td>";
			   	
			   	print "		<td  align=center class=form>";
			   	if($row80['dsc_tipo_linha']=='LI Novas'){
					print "".$row80['n_qtde'];
					$qtdelinhasnovas += $row80['n_qtde'];
				}else{
					print "&nbsp;";
				}
				print "		</td>";
			   	
			   	print "		<td  align=center class=form>";	
			   	if($row80['dsc_tipo_linha']=='LI Adição'){
					print "".$row80['n_qtde'];
					$qtdelinhasadicao +=$row80['n_qtde'];
				}else{
					print "&nbsp;";
				}
				print "		</td>";
				
				print "		<td  align=center class=form>";	
				if($row80['dsc_tipo_linha']=='LI Portabilidade'){
					print "".$row80['n_qtde'];
					$qtdelinhasportabilidade += $row80['n_qtde'];
				}else{
					print "&nbsp;";
				}	
				print "		</td>";
				
				print "		<td   align=center class=form>";
				if($row80['dsc_tipo_linha']=='LI Renovação'){
					print "".$row80['n_qtde'];
					$qtdelinhasrenovacao += $row80['n_qtde'];
				}else{
					print "&nbsp;";
				}
				print "		</td>";
				
				print "		<td   align=center class=form>";
				if($row80['dsc_tipo_linha']=='LI Migração'){
					print "".$row80['n_qtde'];
					$qtdelinhasmigracao = $row80['n_qtde'];
				}else{
					print "&nbsp;";
				}
				print "		</td>";
						print "		<td  align=center class=form>";
				if($row80['dsc_tipo_linha']=='LI Transferência'){
					print "".$row80['n_qtde'];
					$qtdelinhastransferencia +=$row80['n_qtde'];
				}else{
					print "&nbsp;";
				}
				print "		;</td>";
				
			    print "		<td  width=100 align=center class=form>";
			   	print ""		.$total_linhas;"&nbsp;";
			   	print "		</td>";
  				print "	</tr>";	
			  	$total_linhas_geral = $total_linhas_geral + $total_linhas;
			  	$total_linhas = 0;						   				   							   	
			}
			if($qleads80 > 0){
						echo "	<tr>";
						echo "	 	<td class=titulo colspan=9 bgcolor=#8080FF>";
						echo "  		Total Lead(s) &nbsp";	
						echo 			$qleads80;											
						echo "		</td>";
						echo "		<td class=titulo bgcolor=#8080FF align=center>";
						echo 			$qtdelinhasnovas;
						echo "		</td>";
						echo "		<td class=titulo bgcolor=#8080FF  align=center>";
						echo 			$qtdelinhasadicao;
						echo "		</td>";
						echo "		<td class=titulo bgcolor=#8080FF  align=center>";
						echo 			$qtdelinhasportabilidade;
						echo "		</td>";
						echo "		<td class=titulo bgcolor=#8080FF  align=center>";
						echo 			$qtdelinhasrenovacao;
						echo "		</td>";
						echo "		<td  class=titulo bgcolor=#8080FF align=center>";
						echo 			$qtdelinhasmigracao;
						echo "		</td>";
						echo "		<td  class=titulo bgcolor=#8080FF align=center>";
						echo 			$qtdelinhastransferencia;
						echo "		</td>";
					    echo "		<td class=titulo bgcolor=#8080FF align=center>";
						echo 			$total_linhas_geral;
						echo "		</td>";
				    	echo "	</tr>";	
				}

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

