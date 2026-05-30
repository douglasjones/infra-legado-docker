<?
/*___________________G_E_P_R_O_S_______________________________*/
/*   Descricao: Pagina PHP                                   */
/*   File:     Relatorio                                     */
/*-----------------------------------------------------------*/
/*   Autor:   Alex Andrade                            */
/*   Data:    19/01/2010                                     */
/*   Versao:  1..1.35.T.Demo Claro.Novo Relatorio-Alex-19.01.10      */
/*   Descrição: Novo Relatório quantidade de linhas e tipo 
     de linhas                                               */
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
		print "					<td class=Cabecalho width=60%><span class=Cabecalho> Relatório Linhas Ativas </span>";
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
function detalhe($cod_lead,$codequipe,$codgerenteconta,$datini,$datfim){
	print "<table cellpadding=0 cellspacing=0 border=0 width=30%>";		
	print "		<tr >";
	print "			<td colspan=3>";//DETALHE DO RELATORIO 
	print "						<table cellspacing=0 cellpadding=0 align=left width=900 border=1 >";
	print "							<tr>";
	print "								<td class=titulo align=center width=200  >Polo</td>";
	print "								<td class=titulo align=center width=86>Equipe</td>";
	print "								<td class=titulo align=center width=86>Consultor </td>";
	print "								<td class=titulo align=center width=86>Razão Social</td>";
	print "								<td class=titulo align=center width=86>Data Ativação</td>";
	print "								<td class=titulo align=center width=86>Produto</td>";
	print "								<td class=titulo align=center width=86>Linhas Novas</td>";
	print "								<td class=titulo align=center width=86>Linhas Adição</td>";
	print "								<td class=titulo align=center width=86>Linhas Portabilidade</td>";
	print "								<td class=titulo align=center width=86>Linhas Renovação</td>";
	print "								<td class=titulo align=center width=86>Linhas Migração</td>";
	print "								<td class=titulo align=center width=86>Linhas Transfêrencia</td>";
	print "								<td class=titulo align=center width=86>Total</td>";												
	print "							</tr>";			
	$sql = "Select					    			  
			  l.codlead
			  ,SUBSTR(l.razaosocial, 1, 15) as razaosocial							  
			  , DATE_FORMAT(pr.dataativacao,'%d/%m/%y') as data_ativacao
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
			 ,tbe.vc_nome as equipe
			 ,ui.nome as consultor
			 ,pro.nome as produto
			 ,cd.dsc_cidade	as polo				 
			 from leads l
				left join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno
				inner join tb_usuarioequipe tbu on tbu.FK_usuario = ui.codusuariointerno
				inner join tb_equipesvendas tbe on tbe.tk_equipe = tbu.Fk_Equipe							  				
				inner join propostas pr on l.codlead = pr.codlead
				inner join produtos pro on pr.codproduto = pro.codproduto		
				inner join modulosproposta mp on pr.CodProposta = mp.CodProposta and pr.versao = mp.versao and pr.CodLead = mp.codlead and mp.id='qtdelinhasnovas'
				inner join modulosproposta mp1 on pr.CodProposta = mp1.CodProposta and pr.versao = mp1.versao and pr.CodLead = mp1.codlead and mp1.id='qtdelinhasadicao'
				inner join modulosproposta mp2 on pr.CodProposta = mp2.CodProposta and pr.versao = mp2.versao and pr.CodLead = mp2.codlead and mp2.id='qtdelinhasportabilidade'
				inner join modulosproposta mp3 on pr.CodProposta = mp3.CodProposta and pr.versao = mp3.versao and pr.CodLead = mp3.codlead and mp3.id='qtdelinhasrenovacao'
				inner join modulosproposta mp4 on pr.CodProposta = mp4.CodProposta and pr.versao = mp4.versao and pr.CodLead = mp4.codlead and mp4.id='qtdelinhasmigracao'
				inner join modulosproposta mp5 on pr.CodProposta = mp5.CodProposta and pr.versao = mp5.versao and pr.CodLead = mp5.codlead and mp5.id='qtdelinhastransferencia'			  										  					
				inner join polo pl on l.cod_polo = pl.cod_polo
				left join cidade cd on pl.cod_cidade = cd.cod_cidade 
			where l.codstatusclassificacaolead=12";
			if(!empty($consultor)){
				$sql .= " and ui.codusuariointerno = ".$consultor;
			}							
			if(!empty($equipe))	{	
				$sql .= " and tbe.Tk_Equipe = ".$equipe;
			}
			if(!empty($datarecebini) and !empty($datarecebfim)){
				$sql .= " and pr.datarecebimento >= '".DataYMD($datarecebini) . " 00:00:00'";	
				$sql .= " and pr.datarecebimento <= '".DataYMD($datarecebfim) . " 23:59:59'";
			}		
			if(!empty($cod_polo)){
				$sql .= " and l.cod_polo = ".$cod_polo;
			}
			$sql.="	and pr.DataCancelamento Is Null  
				and pr.DataEnvio Is Not Null 
				and pr.DataPrevisaoRecebimento Is not Null  
				and pr.datarecebimento Is not Null
				and pr.dataenviocontrato is null
				and pr.datacadastro > '2009-09-16'
																				
			group by l.codlead,pr.codproposta,pr.versao
			order by cd.dsc_cidade ,tbe.vc_nome ,ui.nome";																							
			$result80 = sql_query($sql);					  			
  					
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
				print "							<tr>";		
				print "	 							</td>";
			   	print "								<td class=detalhe    align=center >";
			   	print ""								.$row1['polo'];"";
			   	print "								</td>";
			   	print "								<td class=detalhe    align=center >";
			   	print ""								.$row1['equipe'];"";
			   	print "								&nbsp;</td>";
				print "								<td class=detalhe    align=center >";
			   	print ""								.$row1['consultor'];"";
			   	print "								</td>";
				print "								<td   align=left   >";
														?><a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<?=$row1['codlead']; ?>', 800, 600);"><font class="Detalhe"><?=$row1['razaosocial'];?></font></a><?				
				print "	 							</td>";
			   	print "								<td class=detalhe    align=center >";
			   	print ""								.$row1['data_ativacao'];"";
			   	print "								&nbsp;</td>";
			   	print "								<td class=detalhe    align=center >";
			   	print ""								.$row1['produto'];"";
			   	print "								</td>";
				print "								<td class=detalhe  align=center>";
			   	print "&nbsp;"								.$row1['qtdelinhasnovas'];"";
			   	print "								</td>";
			    print "								<td class=detalhe  align=center>";
			   	print "&nbsp;"								.$row1['qtdelinhasadicao'];"";
			   	print "								</td>";
			   	print "								<td class=detalhe  align=center>";
			   	print "&nbsp;"								.$row1['qtdelinhasportabilidade'];"";
			   	print "								</td>";
		        print "								<td class=detalhe  align=center>";
			   	print "&nbsp;"								.$row1['qtdelinhasrenovacao'];"";
			   	print "								</td>";
			    print "								<td class=detalhe  align=center>";
			   	print "&nbsp;"								.$row1['qtdelinhasmigracao'];"";
			   	print "								</td>";
			   	print "								<td class=detalhe  align=center>";
			   	print "&nbsp;"								.$row1['qtdelinhastransferencia'];"";
			   	print "								</td>";	
			   	print "								<td class=detalhe  align=center>";
			   	print ""								.$total_linha;"";
			   	print "								</td>";
				print "							</tr>";
				$total_linhas_geral = $total_linhas_geral + $total_linha;
				$total_linha = 0;							   				   							   	
			}		
			print "	<tr>";//Total por consultor
			print "	 	<td class=titulo width=200  >";
			print "  		&nbsp;Total Lead(s) &nbsp";	
			print "     	&nbsp;".$qleads80;"";											
			print "		</td>";
			print "		<td class=titulo  align=center>";
			print "			&nbsp;";
			print "		</td>";
			print "		<td class=titulo  align=center>";
			print "			&nbsp;";
			print "		</td>";
			print "		<td class=titulo  align=center>";
			print "			&nbsp;";
			print "		</td>";
			print "		<td class=titulo  align=center>";
			print "			&nbsp;";
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
		    print "		<td class=titulo  align=center>";
			print ""		.$total_linhas_geral;"";
			print "		</td>";
	    	print "	</tr>";	
							
					//TOTALIZA LEAD  POR EQUIPE	
					$qleads80 = 0;	
					$qtdelinhasnovas = 0;
					$qtdelinhasadicao = 0;
					$qtdelinhasportabilidade = 0;
					$qtdelinhasrenovacao = 0;
					$qtdelinhasmigracao = 0;
					$qtdelinhastransferencia = 0;
					$total_linhas_consultor = 0;						
		print "	</table>";	
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
detalhe($_REQUEST['cod_polo'],$_REQUEST['codequipe'],$_REQUEST['codgerenteconta'],$_REQUEST['dataini'],$_REQUEST['datafim']);
include_once "../../libs/desconectar.php";
?>



