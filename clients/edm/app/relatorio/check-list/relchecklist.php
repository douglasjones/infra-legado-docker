<?
/*___________________G_E_P_R_O_S_____________________________*/
/*   Descricao: Pagina PHP                                   */
/*   File:     Relatorio                                     */
/*-----------------------------------------------------------*/
/*   Autor:   Douglas Jones Lopes                            */
/*   Data:    33/11/2009                                     */
/*   Versao:  1.0.6.T.5T.Relatorio novo-Douglas-05/11/2009   */
/*   Descrição: Novo relatoro novo status 80                 */
/*-----------------------------------------------------------*/
include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";

//--------------------FUNÃ‡Ã”ES-------------------------//
//cabeÃ§alho do relatorio
function cabecalho(){
	if(!empty($_REQUEST['cod_polo'])){
		$sql = "Select 
					p.cod_polo 
					,c.dsc_cidade 
				from polo p
					inner join cidade c on p.cod_cidade = c.cod_cidade 
				where p.cod_polo=".$_REQUEST['cod_polo'];
		$sql .= " Order By c.dsc_cidade ";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$polo = $row['dsc_cidade'];
		}	
	}
	//Imprime o cabecalho
		print "<div id=dvCabecalho style=page-break-after:always><a name= $int_page ></a>";
		print "<table cellpadding=0 cellspacing=0 border=0 width=100%>";
		print "	<tr class=cabecalho>";
		print "		<td align=left><img src=../../images/logo/logo.png width=60></td>";
		print "	</tr>";
		print "	<tr class=cabecalho>";
		print "		<td align=left>&nbsp;</td>";
		print "	</tr>";
		print "	<tr>";
		print "		<td>";
		print "			<table cellpadding=0 cellspacing=0 border=0 width=100%>";
		print "				<tr>";
		print "					<td class=Data width=20%><div class=Data>";
		print "						Emitido em  ".date('d/m/Y \a\s H:i', mktime());"  <br>";
		print "					</div>";
		print "					</td>";
		print "					<td class=Cabecalho width=60%><span class=Cabecalho> Relatório Controle Forecast 80% </span>";
		print "					</td>";
		print "					<td class=Cabecalho width=20%>";
		print "					</td>";
		print "				</tr>";
		print "				<tr>";
		print "					<td class=Data width=20%><div class=Data>";
		print "						Polo:  ".$polo ;" : <br>";
		print "					</div>";
		print "					</td>";
		print "					<td class=Cabecalho width=60%><span class=Cabecalho> &nbsp;</span>";
		print "					</td>";
		print "					<td class=Cabecalho width=20%>";
		print "					</td>";
		print "				</tr>";
		print "			</table>";
		print "		</td>";
		print "	</tr>";
		print "	</table>";
		print "	<br>";
		print "</div>";	
}
function pipelineforecast($equipe,$consultor,$mailing,$cod_polo){	
	$sql = "Select
			  tbe.tK_equipe 
			  ,tbe.vc_nome
			from tb_equipesvendas tbe
				left join tb_usuarioequipe tbu on tbe.tk_equipe = tbu.Fk_Equipe
				left join usuariosinternos ui on tbu.FK_usuario = ui.codusuariointerno
				left join leads l on ui.codusuariointerno = l.codgerenteconta	
				
			where tbe.tK_equipe >0"; 
			if(!empty($equipe))		
				$sql .= " and tbe.tK_equipe = ".$equipe;
			if(!empty($consultor))
				$sql .= " and ui.codusuariointerno = ".$consultor;
			if(!empty($mailing))
				$sql .= " and l.mailing = '".$consultor;"'";
			if(!empty($mailing))
				$sql .= " and l.cod_polo = '".$cod_polo;"'";
			$sql .= " group by tbe.tK_equipe";
			$sql .= " order by tbe.vc_nome";	
			
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_array($result)){			
		$equipe = $row['vc_nome'];
		$sql = "Select
				  ui.codusuariointerno
				  ,ui.nome
				from tb_equipesvendas tbe
				  inner join tb_usuarioequipe tbu on tbe.tk_equipe = tbu.Fk_Equipe
				  inner join usuariosinternos ui on tbu.FK_usuario = ui.codusuariointerno
				  inner join leads l on ui.codusuariointerno = l.codgerenteconta				  		
				Where tbe.tK_equipe=".$row['tK_equipe'];
				$sql .= " and l.CodStatusClassificacaoLead in (10)";
				if(!empty($consultor))
				$sql .= " and ui.codusuariointerno = ".$consultor;								
				$sql .= " group by ui.codusuariointerno";
					
		$result1 = mysql_query($sql);
		while($row1 = mysql_fetch_array($result1)){
			print "<table cellpadding=0 cellspacing=0 border=0 width=30%>";
			print "	<tr >";
			print "		<td >";
			print "  		<table cellpadding=0 cellspacing=0  border=0 width=250>" ;
			print "				<tr >";
			print "					<td align=left  >Equipe:</td>";
			print "					<td align=left>".$equipe;"</td>";
			print "				</tr>";				
			print "				<tr>";
			print "					<td class=detalhe align=left >&nbsp;</td>";
			print "					<td class=detalhe align=left>";
			print " 					<table cellpadding=0 cellspacing=0 border=0 width=100%>";
			print "							<tr>";
			print "								<td class=detalhe align=left width=20% >&nbsp;Consultor:</td>";
			print "								<td class=detalhe align=left>".$row1['nome'];"</td>";
			print "							</tr>";
			print "						</table>";
			print "					</td>";
			print "				</tr>";
			print "			</table>";				
			print "		</td>";
			print "	</tr>";
			print "	<tr>";
			print "	<td colspan=3>";//PRINT DOS LEADS 80
						$sql = " SELECT					
					 				l.CodLead as  codlead80											  
								from leads l
										left join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno
										left join tb_usuarioequipe tbu on tbu.FK_usuario = ui.codusuariointerno
									  	Inner join propostas pr on l.codlead = pr.codlead
								where l.CodStatusClassificacaoLead in (10)";
								$sql.="	and pr.DataCancelamento Is Null  
										and pr.DataEnvio Is Not Null 
										and pr.DataPrevisaoRecebimento Is not Null  
										and pr.datarecebimento Is not Null
										and pr.dataenviocontrato is null";
						if(!empty($row1['codusuariointerno'])){
							$sql .= " and l.codgerenteconta=".$row1['codusuariointerno'];
						}
						if(!empty($row['tK_equipe'])){
							$sql .= " and tbu.Fk_Equipe=".$row['tK_equipe'];
						}
					$sql .= " GROUP BY l.CodLead
						ORDER BY l.RazaoSocial";		
					
					print " <table cellspacing=0 cellpadding=0 align=left width=900 border=1 >";
					print "	<tr>";
					print "		<td class=titulo align=center width=300   >Lead</td>";
					print "		<td class=titulo align=center  >Dt. Rec. Assin</td>";
					print "		<td class=titulo align=center  >Linhas Novas</td>";
					print "		<td class=titulo align=center  >Linhas Adição</td>";
					print "		<td class=titulo align=center  >Linhas Portabilidade</td>";
					print "		<td class=titulo align=center  >Linhas Renovação</td>";
					print "		<td class=titulo align=center  >Linhas Migração</td>";
					print "		<td class=titulo align=center  >Linhas Transferência</td>";
					print "	</tr>";
					$result2 = sql_query($sql);		
								
					while($row2 = mysql_fetch_array($result2)){
						//print "<tr>";		 		 				   
					    //print "<td  colspan=9>";
		 				if(!empty($row2['codlead80'])){ //============ Lead 80% ============//
					    	$sql = "Select
					    			  l.razaosocial
									  ,pr.datarecebimento as recebe_assinatura
									  , DATE_FORMAT(pr.datarecebimento,'%d/%m/%y') as recebe_assinatura
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
					    			 from leads l
					    				left join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno
										left join tb_usuarioequipe tbu on tbu.FK_usuario = ui.codusuariointerno						  				
						  				Inner join propostas pr on l.codlead = pr.codlead
						  				inner join modulosproposta mp on pr.CodProposta = mp.CodProposta and pr.versao = mp.versao and pr.CodLead = mp.codlead and mp.id='qtdelinhasnovas'
										inner join modulosproposta mp1 on pr.CodProposta = mp1.CodProposta and pr.versao = mp1.versao and pr.CodLead = mp1.codlead and mp1.id='qtdelinhasadicao'
										inner join modulosproposta mp2 on pr.CodProposta = mp2.CodProposta and pr.versao = mp2.versao and pr.CodLead = mp2.codlead and mp2.id='qtdelinhasportabilidade'
										inner join modulosproposta mp3 on pr.CodProposta = mp3.CodProposta and pr.versao = mp3.versao and pr.CodLead = mp3.codlead and mp3.id='qtdelinhasrenovacao'
										inner join modulosproposta mp4 on pr.CodProposta = mp4.CodProposta and pr.versao = mp4.versao and pr.CodLead = mp4.codlead and mp4.id='qtdelinhasmigracao'
										inner join modulosproposta mp5 on pr.CodProposta = mp5.CodProposta and pr.versao = mp5.versao and pr.CodLead = mp5.codlead and mp5.id='qtdelinhastransferencia'			  										  					
						  			where l.codlead=".$row2['codlead80'];
						  			$sql.="	and pr.DataCancelamento Is Null  
										and pr.DataEnvio Is Not Null 
										and pr.DataPrevisaoRecebimento Is not Null  
										and pr.datarecebimento Is not Null
										and pr.dataenviocontrato is null										
									group by l.codlead,pr.codproposta,pr.versao";																
						  			$result80 = sql_query($sql);
												  			
						  			$v1 = 1;						  			
									//print " <table cellspacing=0 cellpadding=0 align=left width=900 border=1 >";			
						  			while($row80 = mysql_fetch_array($result80)){
									$qleads80 ++;//Variavel soma a quantidade de Leads 50%
									$qtdelinhasnovas = $qtdelinhasnovas + $row80['qtdelinhasnovas'];//Totaliza a quantidade de linhas novas		
									$qtdelinhasadicao = $qtdelinhasadicao + $row80['qtdelinhasadicao'];//Totaliza a quantidade de linhas adicao			  			
						  			$qtdelinhasportabilidade = $qtdelinhasportabilidade + $row80['qtdelinhasportabilidade'];//Totaliza a quantidade de linhas portabilidade
						  			$qtdelinhasrenovacao = $qtdelinhasrenovacao + $row80['qtdelinhasrenovacao']; //Totaliza a quantidade de linhas renovacao
						  			$qtdelinhasmigracao = $qtdelinhasmigracao + $row80['qtdelinhasmigracao'];;//Totaliza a quantidade de linhas migracao
						  			$qtdelinhastransferencia = $qtdelinhastransferencia+ $row80['qtdelinhastransferencia'];//Totaliza a quantidade de linhas transferencia
						  			//$t$otaçpropostas80 =$totaçpropostas80+ $row80['TotalProposta'];//Variavel total proposta soma os valores da proposta lead 50%
						  				print "	<tr>";
										print "		<td   align=left width=290 >";							
										//if($v1 == 1 ){								
											?>			        
			     							<a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<?=$row2['codlead80']; ?>', 800, 600);"><font class="Detalhe"><?=$row80['razaosocial'];?></font></a><?				
										//}
										print "	 </td>";
									   	print "		<td class=detalhe width=90 align=center>";
									   	print ""		.$row80['recebe_assinatura'];"";
									   	print "		</td>";
									   	print "		<td class=detalhe width=90 align=center>";
									   	print ""		.$row80['qtdelinhasnovas'];"";
									   	print "		</td>";
									    print "		<td class=detalhe width=100 align=center>";
									   	print ""		.$row80['qtdelinhasadicao'];"";
									   	print "		</td>";
									   	print "		<td class=detalhe width=100 align=center>";
									   	print ""		.$row80['qtdelinhasportabilidade'];"";
									   	print "		</td>";
								        print "		<td class=detalhe width=100 align=center>";
									   	print ""		.$row80['qtdelinhasrenovacao'];"";
									   	print "		</td>";
									    print "		<td class=detalhe width=100 align=center>";
									   	print ""		.$row80['qtdelinhasmigracao'];"";
									   	print "		</td>";
									   	print "		<td class=detalhe width=100 align=center>";
									   	print ""		.$row80['qtdelinhastransferencia'];"";
									   	print "		</td>";
				    					print "	</tr>";	
									  	$v1 ++;							   				   							   	
									}		
																
									//print "</table>";
						}else{
									    print "&nbsp;";							    
						}			 		
		     		      
						$total ++; 	
					}
						print "	<tr>";//Total por consultor
						print "	 	<td class=titulo  >";
						print "  		&nbsp;Total Lead(s) &nbsp";	
						print "     	&nbsp;".$qleads80;"";											
						print "		</td>";
						print "		<td class=titulo  align=center>";
						print "			&nbsp;";
						print "		</td>";
						print "		<td class=titulo  align=center>";
						print ""		.$qtdelinhasnovas;"";
						print "		</td>";
						print "		<td class=titulo  align=center>";
						print ""		.$qtdelinhasadicao;"";
						print "		</td>";
						print "		<td class=titulo  align=center>";
						print ""		.$qtdelinhasportabilidade;"";
						print "		</td>";
						print "		<td class=titulo  align=center>";
						print ""		.$qtdelinhasrenovacao;"";
						print "		</td>";
						print "		<td class=titulo  align=center>";
						print ""		.$qtdelinhasmigracao;"";
						print "		</td>";
						print "		<td class=titulo  align=center>";
						print ""		.$qtdelinhastransferencia;"";
						print "		</td>";
				    	print "	</tr>";	
							
					//TOTALIZA LEAD  POR EQUIPE	
					$qtotalleads80 = $qtotalleads80 + $qleads80;
					$qleads80 = 0;	
					
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
					
			print " </table>";			
			print "		</td>";
			print "	</tr>";				
			print "</table>";
			print "<br>";	
			}	
			if($qtotalleads80 <> 0){			
				print "<table cellpadding=0 cellspacing=0 border=0 width=900>";//TOTAL POR EQUIPE
				print "	<tr>";
				print "		<td  align=left>";
				print "     	&nbsp;<b>Total por Equipe</b>";	
				print "                 &nbsp;".$equipe;"";	
				print "		</td>";
				print "	</tr>";	
				print "	<tr>";
				print "		<td class=totaltitulo  align=center>"; 
				print "			<table cellpadding=0 cellspacing=0 border=0 width=900 >";  		
				print "				<tr>";
				print "					<td class=titulo  width=340>";
				print "                 &nbsp;Total Lead(s) Equipe &nbsp";	
				print "                 &nbsp;".$qtotalleads80;"";						
				print "					</td>";
				print "		<td class=titulo width=95 align=center>";
				print ""		.$qtdelinhasnovastotal;"";
				print "		</td>";
				print "		<td class=titulo width=95 align=center>";
				print ""		.$qtdelinhasadicaototal;"";
				print "		</td>";
				print "		<td class=titulo width=95 align=center>";
				print ""		.$qtdelinhasportabilidadetotal;"";
				print "		</td>";
				print "		<td class=titulo width=95  align=center>";
				print ""		.$qtdelinhasrenovacaototal;"";
				print "		</td>";
				print "		<td class=titulo width=95 align=center>";
				print ""		.$qtdelinhasmigracaototal;"";
				print "		</td>";
				print "		<td class=titulo width=95 align=center>";
				print ""		.$qtdelinhastransferenciatotal;"";
				print "		</td>";
				print "				</tr>";					
				print "			</table>";
				print "     </td>";
				print "	</tr>";	
				print "</table>";	
				print "<br>";
				print "<br>";
				
				$qtotalleads80geral = $qtotalleads80geral + $qtotalleads80;//Total Geral de Leads							
				$qtotalleads80 = 0;//Zera variavel de leads para o proximo loop
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
			}		
									
	}
				print "<table cellpadding=0 cellspacing=0 border=0 width=900>";//TOTAL POR EQUIPE
				print "	<tr>";
				print "		<td  align=left>";
				print "     	&nbsp;<b>Total por Total Geral</b>";	
				print "		</td>";
				print "	</tr>";	
				print "	<tr>";
				print "		<td class=totaltitulo  align=center>"; 
				print "			<table cellpadding=0 cellspacing=0 border=0 width=900 >";  		
				print "				<tr>";
				print "					<td class=titulo  width=340>";
				print "                 &nbsp;Total Lead(s) Equipe &nbsp";	
				print "                 &nbsp;".$qtotalleads80geral;"";											
				print "					</td>";
				print "		<td class=titulo width=95 align=center>";
				print ""		.$qtdelinhasnovastotalgeral;"";
				print "		</td>";
				print "		<td class=titulo width=95 align=center>";
				print ""		.$qtdelinhasadicaototalgeral;"";
				print "		</td>";
				print "		<td class=titulo width=95 align=center>";
				print ""		.$qtdelinhasportabilidadetotalgeral;"";
				print "		</td>";
				print "		<td class=titulo width=95  align=center>";
				print ""		.$qtdelinhasrenovacaototalgeral;"";
				print "		</td>";
				print "		<td class=titulo width=95 align=center>";
				print ""		.$qtdelinhasmigracaototalgeral;"";
				print "		</td>";
				print "		<td class=titulo width=95 align=center>";
				print ""		.$qtdelinhastransferenciatotalgeral;"";
				print "		</td>";
				print "				</tr>";					
				print "			</table>";
				print "     </td>";
				print "	</tr>";	
				print "</table>";	
}

?>
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/relatorio.css" type="text/css">
<!--CabeÃ§alho-->
<title>GEPROS - Relat&oacute;rio</title>
	<?	include_once "../../libs/head.php";?>
</head>
<!--HTML-->
<body leftmargin="10" topmargin="10" marginwidth="0" marginheight="0">
<?
//---cabeÃ§alho----//
cabecalho(0);
pipelineforecast($_REQUEST['codequipe'],$_REQUEST['codgerenteconta'],$_REQUEST['mailing'],$_REQUEST['cod_polo']);
include_once "../../libs/desconectar.php";
?>



