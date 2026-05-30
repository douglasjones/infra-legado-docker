<?
include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";

//--------------------FUNÃ‡Ã”ES-------------------------//
//cabeÃ§alho do relatorio
function cabecalho(){
	if(!empty($_REQUEST['cod_polo'])){
		$sql = "Select 
					p.cod_polo 
					,p.n_polo
				from polo p
				where p.cod_polo=".$_REQUEST['cod_polo'];
		$sql .= " Order By p.n_polo ";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$polo = $row['n_polo'];
		}	
	}
	//EQUIPE
	if(!empty($_REQUEST['codequipe'])){
		$sql = "Select
				tbe.vc_nome
				from tb_equipesvendas tbe 
				where tbe.tK_equipe=".$_REQUEST['codequipe'];

		$result1 = mysql_query($sql);
		$row1 = mysql_fetch_array($result1);
		$equipe = $row1['vc_nome'];
		
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
		print "					<td class=Cabecalho width=60%><span class=Cabecalho> Relatório Análise de Distribuição de Visitas </span>";
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
		//EQUIPE
		if(!empty($equipe)){
			print "				<tr>";
			print "					<td class=Data width=20%><div class=Data>";
			print "						Equipe:  ".$equipe ;" : <br>";
			print "					</div>";
			print "					</td>";
			print "					<td class=Cabecalho width=60%><span class=Cabecalho> &nbsp;</span>";
			print "					</td>";
			print "					<td class=Cabecalho width=20%>";
			print "					</td>";
			print "				</tr>";
		}
		//DATA DE ENVIO
		if(!empty($_REQUEST['dataini'])){
			print "				<tr>";
			print "					<td class=Data width=20%><div class=Data>";
			print "						Data de Recebimento:  ".$_REQUEST['dataini']." á ".$_REQUEST['datafim']."";
			print "					</div>";
			print "					</td>";
			print "					<td class=Cabecalho width=60%><span class=Cabecalho> &nbsp;</span>";
			print "					</td>";
			print "					<td class=Cabecalho width=20%>";
			print "					</td>";
			print "				</tr>";
		}
		print "			</table>";
		print "		</td>";
		print "	</tr>";
		print "	</table>";
		print "	<br>";
		print "</div>";	
}
function detalhe($cod_polo,$codequipe,$codtipo,$dataini,$datafim){

	$total_pequena = 0;
	$total_media = 0;
	$total_grande = 0;
	$total_geral = 0;

	print "<table cellpadding=0 cellspacing=0 border=0 width=30%>";		
	$sql = "Select
			  tbe.tK_equipe			  		
			  ,tbe.vc_nome as equipe	
			from tb_equipesvendas tbe
				left join tb_usuarioequipe tbu on tbe.tk_equipe = tbu.Fk_Equipe
				left join usuariosinternos ui on tbu.FK_usuario = ui.codusuariointerno and ui.desativado not in (1)
				left join leads l on ui.codusuariointerno = l.codgerenteconta
				left join agendaslead a on l.codlead = a.codlead
			where tbe.tK_equipe > 0";
			
			if(!empty($codequipe))
				$sql .= " and tbe.tK_equipe =".$codequipe;
			if(!empty($codtipo))
					$sql .= " and a.codtipo = ".$codtipo;		
			if(!empty($dataini) and !empty($datafim)){
				$sql .= " and a.datahorario >= '".DataYMD($dataini) . " 00:00:00'";	
				$sql .= " and a.datahorario <= '".DataYMD($datafim) . " 23:59:59'";
			}																						
			$sql .= " group by tbe.tK_equipe ";
			//$sql .= " order by tbe.vc_nome";					
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){			
					print "		<tr >";
					print "			<td >";
					print "  			<table cellpadding=0 cellspacing=0  border=0 width=250>" ;//TABELA DE EQUIPE E CONSULTOR
					print "					<tr>";
					print "						<td colspan=3>";
					print "							&nbsp;";
					print "						</td>";
					print "					</tr>";
					print "					<tr >";
					print "						<td width=20% align=left  >Equipe:</td>";
					print "						<td align=left>".$row['equipe'];"</td>";
					print "					</tr>";				
					print "				</table>";				
					print "			</td>";
					print "		</tr>";
					print "		<tr>";
					print "			<td colspan=3>";//DETALHE DO RELATORIO 
					print "				<table cellspacing=0 cellpadding=0 align=left width=900 border=1 >";
					print "					<tr>";
					print "						<td class=titulo align=center width=300>Consultor</td>";
					print "						<td class=titulo align=center >Pequena</td>";
					print "						<td class=titulo align=center >Media</td>";
					print "						<td class=titulo align=center >Grande</td>";
					print "						<td class=titulo align=center >Total</td>";
					print "					</tr>";	
					$sql = "Select
							 	tbe.tK_equipe	
								,ui.nome
								,ui.codusuariointerno				
							from tb_equipesvendas tbe
								left join tb_usuarioequipe tbu on tbe.tk_equipe = tbu.Fk_Equipe
								inner join usuariosinternos ui on tbu.FK_usuario = ui.codusuariointerno and ui.desativado not in (1)
							where tbe.tK_equipe =".$row['tK_equipe'];
					
					$result0 = mysql_query($sql);
					while($row0 = mysql_fetch_array($result0)){			
										//VISITAS PEQUENAS
						$sql = "Select
									count(a.cod_tamanho_visita) as pequena
								from agendaslead a 
								inner join agendagerenteconta ar on a.codagendalead = ar.codagendalead
								where a.cod_tamanho_visita=1								
								and ar.codgerenteconta=".$row0['codusuariointerno'];
								if(!empty($codtipo))
									$sql .= " and a.codtipo = ".$codtipo;	
								if(!empty($dataini) and !empty($datafim)){
									$sql .= " and a.datahorario >= '".DataYMD($dataini) . " 00:00:00'";	
									$sql .= " and a.datahorario <= '".DataYMD($datafim) . " 23:59:59'";
								}	
								
						$result1 = mysql_query($sql);	
						$row1 = mysql_fetch_array($result1);	
						//VISITAS MEDIA
						$sql = "Select
									count(a.cod_tamanho_visita) as media
								from agendaslead a 	
								inner join agendagerenteconta ar on a.codagendalead = ar.codagendalead
								where a.cod_tamanho_visita=2
								and ar.codgerenteconta=".$row0['codusuariointerno'];
								if(!empty($codtipo))
									$sql .= " and a.codtipo = ".$codtipo;
								if(!empty($dataini) and !empty($datafim)){
									$sql .= " and a.datahorario >= '".DataYMD($dataini) . " 00:00:00'";	
									$sql .= " and a.datahorario <= '".DataYMD($datafim) . " 23:59:59'";
								}									
						$result2 = mysql_query($sql);	
						$row2 = mysql_fetch_array($result2);	
						//VISITAS GRANDE
						$sql = "Select
									count(a.cod_tamanho_visita) as grande
								from agendaslead a 
								inner join agendagerenteconta ar on a.codagendalead = ar.codagendalead
								where a.cod_tamanho_visita=3								
								and ar.codgerenteconta=".$row0['codusuariointerno'];
								if(!empty($codtipo))
									$sql .= " and a.codtipo = ".$codtipo;
								if(!empty($dataini) and !empty($datafim)){
									$sql .= " and a.datahorario >= '".DataYMD($dataini) . " 00:00:00'";	
									$sql .= " and a.datahorario <= '".DataYMD($datafim) . " 23:59:59'";
								}	
						$result3 = mysql_query($sql);	
						$row3 = mysql_fetch_array($result3);	
						//TOTAL POR CONSULTOR
						$total = ($row1['pequena'] + $row2['media'] + $row3['grande']); 					
						//PRINTA RESULTADO POR CONSULTOR
						print "					<tr>";
						print "						<td class=detalhe align=center >".$row0['nome']."</td>";
						print "						<td class=detalhe align=center >".$row1['pequena']."&nbsp;</td>";
						print "						<td class=detalhe align=center >".$row2['media']."</td>";
						print "						<td class=detalhe align=center >".$row3['grande']."</td>";
						print "						<td class=detalhe align=center s>".$total."</td>";
						print "					</tr>";			
						// ZERA O VALOR DA VARIAVAL TOTAL POR CONSULTOR
						
						$total_pequena += $row1['pequena'];
						$total_media += $row2['media'];
						$total_grande += $row3['grande'];
						$total_geral += $total;
						
						$total = "";
					}		
					print "					<tr>";
					print "						<td class=detalhe align=center >&nbsp;</td>";
					print "						<td class=detalhe align=center >".$total_pequena."&nbsp;</td>";
					print "						<td class=detalhe align=center >".$total_media."</td>";
					print "						<td class=detalhe align=center >".$total_grande."</td>";
					print "						<td class=detalhe align=center s>".$total_geral."</td>";
					print "					</tr>";			
					
					$total_pequena = 0;
					$total_media = 0;
					$total_grande = 0;
					$total_geral = 0;					
					
					//Prainta o total geral da equipe.
					print "				</table>";	
					print "			</td>";
					print "		</tr>";
				}
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
detalhe($_REQUEST['cod_polo'],$_REQUEST['codequipe'],$_REQUEST['codtipo'],$_REQUEST['dataini'],$_REQUEST['datafim']);
include_once "../../libs/desconectar.php";
?>



