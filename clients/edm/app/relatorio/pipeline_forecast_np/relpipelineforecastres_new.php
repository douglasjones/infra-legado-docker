<?

set_time_limit(3000);

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
include_once( "../../libs/cla.equipes.php" ) ;

$cod_polo = $_REQUEST['cod_polo'];
$codequipe = $_REQUEST['codequipe'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$mailing_pk = $_REQUEST['mailing_pk'];
$datastatusde = $_REQUEST['datastatusde'];
$datastatusate = $_REQUEST['datastatusate'];
$status_usuario = $_REQUEST['status_usuario'];
$mailling_pk = $_REQUEST['mailing_pk'];


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
		<font size="+2">Pipeline e Forecast</font>
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
	if(!empty($_REQUEST['cod_polo'])){
		$sql ="";
		$sql.="select p.cod_polo, p.n_polo";
		$sql.="  from polo p ";
		$sql.=" where p.cod_polo =".$_REQUEST['cod_polo'];
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		?>
		<tr>
			<td>Pólo: <?= $row['n_polo'];?></td>
		</tr>
		<?
		mysql_free_result($result);
	}
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
	if(!empty($mailing_pk)){
		?>
		<tr>
			<td>
				<?			
				$sql ="";
				$sql.="SELECT m.pk, m.dsc_mailing
							  FROM mailing m
							 WHERE m.dt_cancelamento IS NULL
							
						and pk=".$mailing_pk;
						
				$m = mysql_query($sql);
				$mailing = mysql_fetch_array($m);
				echo "Mailing: ".$mailing['dsc_mailing'];
				?>
			</td>
		</tr>
		<?
	}
	if(!empty($datastatusde)){
		?>
		<tr>
			<td>Data Alteração Status (Início): <?= $datastatusde;?></td>
		</tr>
		<?
	}
	if(!empty($datastatusate)){
		?>
		<tr>
			<td>Data Alteração Status (Fim): <?= $datastatusate;?></td>
		</tr>
		<?
	}
	?>		
	<tr>
		<td class="parametros">
				<br>
				Relatório gerado em <?
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
<?

$arrTotalGeralLeads = array();
$arrTotalGeralLinhas = array();
$arrTotalGeralValor = array();

//zera os totais 
for($i = 4; $i <= 6; $i++){
	$arrTotalGeralLeads[$i] = 0;
	$arrTotalGeralLinhas[$i] = 0;
	$arrTotalGeralValor[$i] = 0;
}

$sql ="";
$sql.="select t.tk_equipe cod_equipe, t.vc_nome nome_equipe ";
$sql.="  from tb_equipesvendas t ";
$sql.=" where 1=1 ";

//Permissão para exibir todas as equipes.
if(!permissao('visualizar_todos_consultores', 'cs'))
	$sql.=" and t.tk_equipe in (".equipes::getEquipe($_SESSION['codusuario']).") ";

if(!empty($codequipe))
	$sql.=" and t.tk_equipe = $codequipe ";
	
if(!empty($codgerenteconta))
	$sql.=" and t.tk_equipe in (select t1.fk_equipe from tb_usuarioequipe t1 where t1.fk_usuario = $codgerenteconta) ";
	
$sql.=" order by t.vc_nome ";

$rs_equipe = mysql_query($sql);
while($row_equipe = mysql_fetch_array($rs_equipe)){
	?>
	<font face="Arial"><em><b>Equipe: <?= $row_equipe['nome_equipe'];?></b></em></font>
	<br>
	<?
	
	$arrTotalEquipeLeads = array();
	$arrTotalEquipeLinhas = array();
	$arrTotalEquipeValor = array();
	
	//zera os totais 
	for($i = 4; $i <= 6; $i++){
		$arrTotalEquipeLeads[$i] = 0;
		$arrTotalEquipeLinhas[$i] = 0;
		$arrTotalEquipeValor[$i] = 0;
	}
	
	$sql ="";
	$sql.="Select ui.nome, ui.codusuariointerno ";
	$sql.="  from usuariosinternos ui ";
	$sql.=" where gerentecontas = 1 ";
	$sql.="   and codusuariointerno in (select fk_usuario from tb_usuarioequipe  where fk_equipe =  ".$row_equipe['cod_equipe'].") ";
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	if(!empty($codgerenteconta))
		$sql.=" and ui.codusuariointerno = $codgerenteconta ";

	if($status_usuario != ""){
		$sql.=" and ui.desativado = $status_usuario ";
	}

	$sql.=" order by ui.nome ";
		
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
	//pega os 25%
		?>
		<br>
		<font face="Arial"><b>Consultor: <?= $row['nome'];?></b></font>
		<br>
		<?
		
		$arrTotalConsultorLeads = array();
		$arrTotalConsultorLinhas = array();
		$arrTotalConsultorValor = array();
		
		$sql ="";
		$sql.="select codstatusclassificacaolead, descricao ";
		$sql.="  from statusclassificacaolead ";
		$sql.=" where codstatusclassificacaolead in (4,5,6) ";
		$sql.=" order by codstatusclassificacaolead ";
		$rs_status = mysql_query($sql);
		while($row_status = mysql_fetch_array($rs_status)){
			
			$total_valor_status = 0;
			$total_qtde_status = 0;
			
			
			$data_propota_envio = "";
			$data_propota_envio.="SELECT ndp.propostas_pk,
									 ndp.vl_data_proposta dt_envio_proposta
						      FROM n_datas_proposta ndp
							  WHERE ndp.data_proposta_operador_pk IN (SELECT pk
																	   FROM n_data_proposta_operador			
																	    WHERE ds_label_data = 'envio_lead')";
			$data_proposta_previ = "";
			$data_proposta_previ.= "SELECT ndp1.propostas_pk,
									 ndp1.vl_data_proposta dt_previsao_proposta
						      FROM n_datas_proposta ndp1
							  WHERE ndp1.data_proposta_operador_pk IN (SELECT pk
																	   FROM n_data_proposta_operador			
																	    WHERE ds_label_data = 'previsao_recebe_assinatura')";														    
			//VOZ		
			$itens_voz = "";
			$itens_voz.= " SELECT nip.propostas_pk,
							   sum(nip.vl_unitario * nip.n_qtde ) vlr_voz,
							   nipo.vl_franquia,
							   sum(nip.n_qtde) qtde_voz
						  FROM n_itens_propostas nip
							   LEFT JOIN n_itens_propostas_operadoras nipo
								  ON nip.pk = nipo.itens_propostas_pk
							   INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk	
					      WHERE npr.produtos_tipo_pk = 1		     
						GROUP BY nip.propostas_pk";		
			//DADOS e MODULOS				
			$itens_produtos ="";
			$itens_produtos.="SELECT nip1.propostas_pk, 
									sum(nip1.vl_unitario * nip1.n_qtde) vlr_produtos,
									sum(nip1.n_qtde) qtde_produtos
							  FROM n_itens_propostas nip1
								   INNER JOIN n_produtos npr ON nip1.produtos_pk = npr.pk
							 WHERE npr.produtos_tipo_pk IN (3, 4)
							GROUP BY nip1.propostas_pk";							
							
			$itens_combo = "";
			$itens_combo.="SELECT nip2.propostas_pk, sum(nip2.vl_unitario * nip2.n_qtde) vlr_combo,
								  sum(nip2.n_qtde) qtde_combo
							  FROM n_itens_propostas nip2
							 WHERE nip2.combos_pk IS NOT NULL
							 GROUP BY nip2.propostas_pk";	
			
			$itens_aparelhos = "";
			$itens_aparelhos.= "Select
								 nap.propostas_pk,
								 sum(nap.vl_unitario * nap.n_qtde) vlr_aparelhos,
								 sum(nap.n_qtde) qtde_aparelhos
								from n_propostas_aparelhos nap
								group by nap.propostas_pk";				 					
			
			
			if($row_status['codstatusclassificacaolead'] == 4){
				
				$total_dias_atraso = 2;
				
				$sql ="";
				$sql.="select l.codlead, l.razaosocial ";
				$sql.="  from leads l ";
				$sql.="       inner join agendaslead al on al.codlead = l.codlead ";
				$sql.=" where l.codstatusclassificacaolead = 4 ";
				$sql.="   and l.codgerenteconta = ".$row['codusuariointerno'];
				$sql.="	and al.codtipo = 1 ";
				$sql.="   and al.datahorario < sysdate() ";
				
				//Regras de visualização de equipe de consultores
				if(!permissao('visualizar_todos_consultores', 'cs'))
					$sql .= " and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).")";
				
				//regras de visualização do polo
				if(!empty($_SESSION['cod_polo']))
					$sql .= " and l.cod_polo = ".$_SESSION['cod_polo']." ";
				
				if(!empty($mailing_pk)) 
					$sql.=" and l.mailing_pk = ".$mailling_pk;
					
				if(!empty($datastatusde))
					$sql.=" and al.datahorario >= '".DataYMD($datastatusde)." 00:00:00' ";
				
				if(!empty($datastatusate))
					$sql.=" and al.datahorario <= '".DataYMD($datastatusate)." 23:59:59' ";
					
				if(!empty($_REQUEST['cod_polo']))
					$sql.="and l.cod_polo =".$_REQUEST['cod_polo'];
					
				$sql.="   and l.codstatusclassificacaolead=4";
				$sql.=" group by l.codlead, l.razaosocial ";
				$sql.=" order by l.razaosocial ";
			
								
			}
			elseif($row_status['codstatusclassificacaolead'] == 5 || $row_status['codstatusclassificacaolead'] == 6){
				
				if($row_status['codstatusclassificacaolead'] == 5){
					$total_dias_atraso = 10;
				}
				else{
					$total_dias_atraso = 2;
				}
				
				$sql ="";
				$sql .="SELECT 	l.codlead
								,l.razaosocial
								,np.pk propostas_pk";
				if($row_status['codstatusclassificacaolead'] == 5){
					$sql.=", datediff(sysdate(), ndp.dt_envio_proposta) dias ";
				}elseif($row_status['codstatusclassificacaolead'] == 6){
					$sql.=", datediff(sysdate(), ndp1.dt_previsao_proposta) dias ";
				}
				$sql.=", nip.vlr_voz";	
				$sql.=", nip.vl_franquia";
				$sql.=", nip.qtde_voz";	
				$sql.=", nip1.vlr_produtos";
				$sql.=", nip1.qtde_produtos";
				$sql.=", nip2.vlr_combo";
				$sql.=", nip2.qtde_combo";
				$sql.=", nap.vlr_aparelhos";
				$sql.=", nap.qtde_aparelhos";	
				$sql.="     FROM leads l
								  INNER JOIN n_propostas np ON l.codlead = np.leads_pk";
				$sql .="		  LEFT JOIN ($data_propota_envio) ndp on np.pk = ndp.propostas_pk";
				$sql .="		  LEFT JOIN ($data_proposta_previ) ndp1 on np.pk = ndp1.propostas_pk";
				$sql .="		  LEFT JOIN ($itens_voz) nip on np.pk = nip.propostas_pk";
				$sql .=" 		  LEFT JOIN ($itens_produtos) nip1 on np.pk = nip1.propostas_pk";
				$sql .=" 		  LEFT JOIN ($itens_combo) nip2 on np.pk = nip2.propostas_pk";
				$sql .=" 		  LEFT JOIN ($itens_aparelhos) nap on np.pk = nap.propostas_pk";																	
				$sql .=" 	WHERE l.CodGerenteConta =".$row['codusuariointerno'];

				//Regras de visualização de equipe de consultores
				if(!permissao('visualizar_todos_consultores', 'cs'))
					$sql .= " and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).")";
				
				//regras de visualização do polo
				if(!empty($_SESSION['cod_polo']))
					$sql .= " and l.cod_polo = ".$_SESSION['cod_polo']." ";

				if(!empty($mailing_pk)) 
					$sql.=" and l.mailing_pk =".$mailling_pk;
				
				if($row_status['codstatusclassificacaolead'] == 5){
					
					if(!empty($datastatusde))
						$sql.=" and  ndp.dt_envio_proposta >= '".DataYMD($datastatusde)." 00:00:00' ";
					
					if(!empty($datastatusate))
						$sql.=" and  ndp.dt_envio_proposta <= '".DataYMD($datastatusate)." 23:59:59' ";
					
					$sql.=" and ndp.dt_envio_proposta is not null ";
					$sql.=" and ndp1.dt_previsao_proposta is null ";
					$sql.=" and l.codstatusclassificacaolead=5";
				}
				
				elseif ($row_status['codstatusclassificacaolead'] == 6){
				
					if(!empty($datastatusde))
						$sql.=" and ndp1.dt_previsao_proposta >= '".DataYMD($datastatusde)." 00:00:00' ";
					
					if(!empty($datastatusate))
						$sql.=" and ndp1.dt_previsao_proposta <= '".DataYMD($datastatusate)." 23:59:59' ";
					
					$sql.=" and ndp.dt_envio_proposta is not null ";
					$sql.=" and ndp1.dt_previsao_proposta is not null ";
					$sql.="   and l.codstatusclassificacaolead=6";
					
				}
				
				if(!empty($_REQUEST['cod_polo']))
					$sql.=" and l.cod_polo = ".$_REQUEST['cod_polo'];
					
				$sql.="   and np.dt_cancelamento is null ";
				
				$sql .=" GROUP BY l.codlead,np.pk";
				$sql.=" order by l.razaosocial ";
				
			}
			
			$rs_leads = mysql_query($sql);
			$total_leads = mysql_num_rows($rs_leads);
			
			if($total_leads > 0){
			
			?>
				<font face="Arial" size="2"><i><?= $row_status['descricao'];?></i></font>
				<table width="100%" cellspacing="0" cellpadding="0" align="center" border="1" class="sortable">	
					<thead>
						<tr>
							<td class="titulo" bgcolor="#8080FF" width="25%">Razão Social</td>
							<?if($row_status['codstatusclassificacaolead'] == 5 || $row_status['codstatusclassificacaolead'] == 6){?>								
								<td class="titulo" bgcolor="#8080FF" width="8%">Proposta</td>
								<td class="titulo" bgcolor="#8080FF" width="90">Qtde Dias</td>								
							<?}else{?>						
								<td class="titulo" bgcolor="#8080FF" >Qtde Dias</td>	
							<?}?>											
							<?if($row_status['codstatusclassificacaolead'] == 5 || $row_status['codstatusclassificacaolead'] == 6){?>								
								<td class="titulo" bgcolor="#8080FF" width="115">Qtde Voz Linhas</td>
								<td class="titulo" bgcolor="#8080FF" width="100">VL Voz Linhas</td>
								<td class="titulo" bgcolor="#8080FF" width="100">Qtde Serviços</td>
								<td class="titulo" bgcolor="#8080FF" width="90">VL Serviços</td>
								<td class="titulo" bgcolor="#8080FF" width="90">Qtde Combo</td>
								<td class="titulo" bgcolor="#8080FF" width="90">VL Combo</td>
								<td class="titulo" bgcolor="#8080FF" width="90">Valor</td>						
							<?}?>
						</tr>
					</thead>
					<tbody>
					<?
					$qtde_total_voz = "";
					$qtde_total_servicos = "";
					$qtde_total_combo = "";
					$vl_total_voz = "";
					$vl_total_servicos = "";
					$vl_total_combo = "";
					$vl_total = "";
					
					while($row_leads = mysql_fetch_array($rs_leads)){
						
						if ($row_leads['dias'] > $total_dias_atraso)
							$cor_fonte = "red";
						else
							$cor_fonte = "";
						
						if($row_status['codstatusclassificacaolead'] == 5){
						}	
						
						
						if($row_status['codstatusclassificacaolead'] == 5 || $row_status['codstatusclassificacaolead'] == 6){
							
							$qtde_total_voz += ($row_leads['qtde_voz']);
							$qtde_total_servicos += ($row_leads['qtde_produtos']);
							$qtde_total_combo += ($row_leads['qtde_combo']);
							$qtde_total += ($row_leads['qtde_voz'] + $row_leads['qtde_produtos'] + $row_leads['qtde_combo']);
							$vl_total_voz += ($row_leads['vlr_voz'] + $row_leads['vl_franquia']);							
							$vl_total_servicos += ($row_leads['vlr_produtos']);
							$vl_total_combo += ($row_leads['vlr_combo']);
							$vl_total += ($row_leads['vlr_voz'] + $row_leads['vl_franquia'] + $row_leads['vlr_produtos'] + $row_leads['vlr_combo']);
						?>
							<tr bgcolor="<?= $cor?>">
								<td class="form"><a href="../../vendas/leads/leadgerenciamentores.php?codlead=<?= $row_leads['codlead'];?>"><?= $row_leads['razaosocial']?></a></td>
								<td class="form" align="center"><?= $row_leads['propostas_pk'];?></td>								
								<td class="form" align="center"><?= $row_leads['dias'];?></td>								
								<td class="form" align="center"><?=$row_leads['qtde_voz'];?>
								<td class="form" align="center"><?= number_format(($row_leads['vlr_voz'] + $row_leads['vl_franquia']),2);?></td>
								<td class="form" align="center"><?=$row_leads['qtde_produtos'];?>
								<td class="form" align="center"><?= number_format(($row_leads['vlr_produtos']),2);?></td>
								<td class="form" align="center"><?=$row_leads['qtde_combo'];?></td>
								<td class="form" align="center"><?= number_format(($row_leads['vlr_combo']),2);?></td>
								<td class="form" align="center"><?= number_format(($row_leads['vlr_voz'] + $row_leads['vl_franquia'] + $row_leads['vlr_produtos'] + $row_leads['vlr_combo']),2);?></td>
							</tr>
						<? }else{
							//Pesquisa as informações da ultima visita.
							$sql ="";
							$sql.="select datediff(sysdate(), ifnull(al.datahorario,'1900-01-01')) dias ";
							$sql.="  from agendaslead al ";
							$sql.=" where al.codlead = ".$row_leads['codlead'];
							$sql.=" order by al.codagendalead desc ";
							$rs_dias = mysql_query($sql);
							$num = mysql_num_rows($rs_dias);
							if($num > 0){
								$row_dias = mysql_fetch_array($rs_dias);
								if($row_dias['dias'] >= 0) {
									?>
									<tr bgcolor="<?= $cor?>">
										<td class="form"><a href="../../vendas/leads/leadgerenciamentores.php?codlead=<?= $row_leads['codlead'];?>"><font color="<?= $cor_fonte;?>"><?= $row_leads['razaosocial']?></font></a></td>
										<td class="form" align="center"><font color="<?= $cor_fonte;?>"><?= $row_dias['dias'];?></font></td>
									</tr>									
									<?
								}
							}
							mysql_free_result($rs_dias);
						}
						?>
					<?
						$n_total_consultor = ($n_total_consultor + $qtde_total);
						
					}?>	
					</tbody>		
					<tfoot>
						<tr class="link_cinza">
							<?
							/*$qtde_total_voz_50 = "";
							$vl_total_voz_50 = "";
							$qtde_total_servicos_50 = "";
							$vl_total_servicos_50 = "";
							$qtde_total_combo_50 = "";
							$vl_total_combo_50 = "";*/
							
							$qtde_total_voz_75 = "";
							$vl_total_voz_75 = "";
							$qtde_total_servicos_75 = "";
							$vl_total_servicos_75 = "";
							$qtde_total_combo_75 = "";
							$vl_total_combo_75 = "";
							
							//calcula os totais gerais
							$arrTotalConsultorLeads[$row_status['codstatusclassificacaolead']] += $total_leads;
							$arrTotalConsultorLinhas[$row_status['codstatusclassificacaolead']] += $qtde_total;
							$arrTotalConsultorValor[$row_status['codstatusclassificacaolead']] += $vl_total;
													
							$arrTotalGeralLeads[$row_status['codstatusclassificacaolead']] += $total_leads;
							$arrTotalGeralLinhas[$row_status['codstatusclassificacaolead']] += $qtde_total;
							$arrTotalGeralValor[$row_status['codstatusclassificacaolead']] += $vl_total;
							
							$arrTotalEquipeLeads[$row_status['codstatusclassificacaolead']] += $total_leads;
							$arrTotalEquipeLinhas[$row_status['codstatusclassificacaolead']] += $qtde_total;
							$arrTotalEquipeValor[$row_status['codstatusclassificacaolead']] += $vl_total;
							
							if($row_status['codstatusclassificacaolead'] == 5){
								$qtde_total_voz_50 = $qtde_total_voz;
								$vl_total_voz_50 = $vl_total_voz;
								$qtde_total_servicos_50 = $qtde_total_servicos;
								$vl_total_servicos_50 = $vl_total_servicos;
								$qtde_total_combo_50 = $qtde_total_combo; 
								$vl_total_combo_50 = $vl_total_combo;								
							}
							if($row_status['codstatusclassificacaolead'] == 6){
								$qtde_total_voz_75 = $qtde_total_voz;
								$vl_total_voz_75 = $vl_total_voz;
								$qtde_total_servicos_75 = $qtde_total_servicos;
								$vl_total_servicos_75 = $vl_total_servicos;
								$qtde_total_combo_75 = $qtde_total_combo; 
								$vl_total_combo_75 = $vl_total_combo;								
							}
							?>
							
							
							<?if($row_status['codstatusclassificacaolead'] == 5 || $row_status['codstatusclassificacaolead'] == 6){?>
								<td align="center" class="titulo" bgcolor="#8080FF" colspan="3">Total: <?= $total_leads;?> Lead(s)</td>
								<td align="center" class="titulo" bgcolor="#8080FF"><?= $qtde_total_voz;?></td>
								<td align="center" class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_voz,2);?></td>
								<td align="center" class="titulo" bgcolor="#8080FF"><?= $qtde_total_servicos;?></td>
								<td align="center" class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_servicos,2);?></td>
								<td align="center" class="titulo" bgcolor="#8080FF"><?= $qtde_total_combo;?></td>
								<td align="center" class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_combo,2);?></td>
								<td align="center" class="titulo" bgcolor="#8080FF"><?= number_format($vl_total,2);?></td>
							<? }else{?>
								<td align="center" class="titulo" bgcolor="#8080FF" colspan="2">Total: <?= $total_leads;?> Visitas(s)</td>
							<?}?>
						</tr>
					</tfoot>
				</table>
				<br>
			<?
			}
			else{?>
				<font face="Arial" size="2"><i>Nenhum <?= $row_status['descricao'];?> encontrado.</i></font>
				<br/>
				
			<?}
			mysql_free_result($rs_leads);
		}
		mysql_free_result($rs_status);
		
		//Verifica se vai exibir o total do consultor
		if (count($arrTotalConsultorLeads) > 0){
		?>
			<font face="Arial"><b>Total Consultor: <?= $row['nome'];?></b></font>
			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="1" class="sortable">	
				<thead>
					<tr>
						<td class="titulo" bgcolor="#8080FF" width="25%">Status</td>
						<td class="titulo" bgcolor="#8080FF" width="16%">Total Leads</td>						
						<td class="titulo" bgcolor="#8080FF" width="115">Qtde Voz Linhas</td>
						<td class="titulo" bgcolor="#8080FF" width="90">VL Voz</td>
						<td class="titulo" bgcolor="#8080FF" width="100">Qtde Serviços</td>
						<td class="titulo" bgcolor="#8080FF" width="90">VL Serviços</td>
						<td class="titulo" bgcolor="#8080FF" width="90">Qtde Combos</td>
						<td class="titulo" bgcolor="#8080FF" width="90">VL Combos</td>
						<td class="titulo" bgcolor="#8080FF" width="90">Valor Total</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="form">Lead 25%</td>
						<td class="form" align="center"><?= $arrTotalConsultorLeads[4]?></td>
						<td class="form" align="center" colspan=7>&nbsp;</td>					
						
					</tr>
					<tr>
						<td class="form">Lead 50%</td>
						<td class="form" align="center"><?= $arrTotalConsultorLeads[5]?></td>						
						<td class="form" align="center"><?= $qtde_total_voz_50;?></td>						
						<td class="form" align="center"><?= number_format($vl_total_voz_50,2);?></td>
						<td class="form" align="center"><?= $qtde_total_servicos_50;?></td>
						<td class="form" align="center"><?= number_format($vl_total_servicos_50,2)?></td>
						<td class="form" align="center"><?= $qtde_total_combo_50;?></td>
						<td class="form" align="center"><?= number_format($vl_total_combo_50,2)?></td>
						<td class="form" align="center"><?= number_format($arrTotalConsultorValor[5],2)?></td>
						
					</tr>
					<tr>
						<td class="form">Forecast 75%</td>
						<td class="form" align="center"><?= $arrTotalConsultorLeads[6]?></td>
						<td class="form" align="center"><?= $qtde_total_voz_75;?></td>						
						<td class="form" align="center"><?= number_format($vl_total_voz_75,2);?></td>
						<td class="form" align="center"><?= $qtde_total_servicos_75;?></td>
						<td class="form" align="center"><?= number_format($vl_total_servicos_75,2)?></td>
						<td class="form" align="center"><?= $qtde_total_combo_75;?></td>
						<td class="form" align="center"><?= number_format($vl_total_combo_75,2)?></td>
						<td class="form" align="center"><?= number_format($arrTotalConsultorValor[6],2)?></td>
					</TR>
				</tbody>
				<tfoot>
					<tr class="link_cinza"  >
						<td align="center" class="titulo" bgcolor="#8080FF">&nbsp;</td>
						<td align="center" class="titulo" bgcolor="#8080FF"><?= $arrTotalConsultorLeads[4] + $arrTotalConsultorLeads[5] + $arrTotalConsultorLeads[6]; ?></td>
						<td class="titulo" bgcolor="#8080FF"><?= $qtde_total_voz_50 + $qtde_total_voz_75;?></td>						
						<td class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_voz_50+$vl_total_voz_75,2);?></td>
						<td class="titulo" bgcolor="#8080FF"><?= $qtde_total_servicos_50+$qtde_total_servicos_75;?></td>
						<td class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_servicos_50+$vl_total_servicos_75,2)?></td>
						<td class="titulo" bgcolor="#8080FF"><?= $qtde_total_combo_50+$qtde_total_combo_75;?></td>
						<td class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_combo_50+$vl_total_combo_75,2)?></td>
						<td align="center" class="titulo" bgcolor="#8080FF"><?= number_format($arrTotalConsultorValor[5] + $arrTotalConsultorValor[6],2); ?></td>
					</tr>
				</tfoot>
			</table>	
			<br />
		<?
			$qtde_total_voz_equipe_50 += $qtde_total_voz_50;
			$vl_total_voz_equipe_50 += $vl_total_voz_50;
			$qtde_total_servicos_equipe_50 += $qtde_total_servicos_50;
			$vl_total_servicos_equipe_50 += $vl_total_servicos_50;
			$qtde_total_combo_equipe_50 += $qtde_total_combo_50;
			$vl_total_combo_equipe_50 += $vl_total_combo_50;
			
			$qtde_total_voz_equipe_75 += $qtde_total_voz_75;
			$vl_total_voz_equipe_75 += $vl_total_voz_75;
			$qtde_total_servicos_equipe_75 += $qtde_total_servicos_75;
			$vl_total_servicos_equipe_75 += $vl_total_servicos_75;
			$qtde_total_combo_equipe_75 += $qtde_total_combo_75;
			$vl_total_combo_equipe_75 += $vl_total_combo_75;
			
		}
	}
	mysql_free_result($result);
	
	$exibe_equipe =0;
	//Verifica se a equipe possui um total.
	for($i = 4; $i <= 6; $i++){
		$exibe_equipe += $arrTotalEquipeLeads[$i];
	}
	if ($exibe_equipe > 0){
	?>
	<br>
	<font face="Arial"><b><em>Total Equipe</em></b></font>
	<table width="100%" cellspacing="0" cellpadding="0" align="center" border="1" class="sortable">	
		<thead>
			<tr>
				<td class="titulo" bgcolor="#8080FF" width="25%">Status</td>
				<td class="titulo" bgcolor="#8080FF" width="16%">Total Leads</td>						
				<td class="titulo" bgcolor="#8080FF" width="115">Qtde Voz Linhas</td>
				<td class="titulo" bgcolor="#8080FF" width="90">VL Voz</td>
				<td class="titulo" bgcolor="#8080FF" width="100">Qtde Serviços</td>
				<td class="titulo" bgcolor="#8080FF" width="90">VL Serviços</td>
				<td class="titulo" bgcolor="#8080FF" width="90">Qtde Combos</td>
				<td class="titulo" bgcolor="#8080FF" width="90">VL Combos</td>
				<td class="titulo" bgcolor="#8080FF" width="90">Valor Total</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="form">Lead 25%</td>
				<td class="form" align="center"><?= $arrTotalEquipeLeads[4]?></td>
				<td class="form" align="center" colspan=7>&nbsp;</td>
								
			</tr>
			<tr>
				<td class="form">Lead 50%</td>
				<td class="form" align="center"><?= $arrTotalEquipeLeads[5]?></td>
				<td class="form" align="center"><?= $qtde_total_voz_equipe_50;?></td>						
				<td class="form" align="center"><?= number_format($vl_total_voz_equipe_50,2);?></td>
				<td class="form" align="center"><?= $qtde_total_servicos_equipe_50;?></td>
				<td class="form" align="center"><?= number_format($vl_total_servicos_equipe_50,2)?></td>
				<td class="form" align="center"><?= $qtde_total_combo_equipe_50;?></td>
				<td class="form" align="center"><?= number_format($vl_total_combo_equipe_50,2)?></td>
				<td class="form" align="center"><?= number_format($arrTotalEquipeValor[5],2)?></td>
			</tr>
			<tr>
				<td class="form">Forecast 75%</td>
				<td class="form" align="center"><?= $arrTotalEquipeLeads[6]?></td>
				<td class="form" align="center"><?= $qtde_total_voz_equipe_75;?></td>						
				<td class="form" align="center"><?= number_format($vl_total_voz_equipe_75,2);?></td>
				<td class="form" align="center"><?= $qtde_total_servicos_equipe_75;?></td>
				<td class="form" align="center"><?= number_format($vl_total_servicos_equipe_75,2)?></td>
				<td class="form" align="center"><?= $qtde_total_combo_equipe_75;?></td>
				<td class="form" align="center"><?= number_format($vl_total_combo_equipe_75,2)?></td>
				<td class="form" align="center"><?= number_format($arrTotalEquipeValor[6],2)?></td>
			</TR>
		</tbody>
		<tfoot>
			<tr class="link_cinza"  >
				<td align="center" class="titulo" bgcolor="#8080FF">&nbsp;</td>
				<td align="center" class="titulo" bgcolor="#8080FF"><?= $arrTotalEquipeLeads[4] + $arrTotalEquipeLeads[5] + $arrTotalEquipeLeads[6]; ?></td>
				<td class="titulo" bgcolor="#8080FF"><?= $qtde_total_voz_equipe_50 + $qtde_total_voz_equipe_75;?></td>						
				<td class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_voz_equipe_50+$vl_total_voz_equipe_75,2);?></td>
				<td class="titulo" bgcolor="#8080FF"><?= $qtde_total_servicos_equipe_50+$qtde_total_servicos_equipe_75;?></td>
				<td class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_servicos_equipe_50+$vl_total_servicos_equipe_75,2)?></td>
				<td class="titulo" bgcolor="#8080FF"><?= $qtde_total_combo_equipe_50+$qtde_total_equipe_combo_75;?></td>
				<td class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_combo_equipe_50+$vl_total_combo_equipe_75,2)?></td>
				<td align="center" class="titulo" bgcolor="#8080FF"><?= number_format($arrTotalEquipeValor[5] + $arrTotalEquipeValor[6],2); ?></td>
			</tr>
		</tfoot>
	</table>	
	<br>
	<?

	
	}
	else{
	?>
	<font face="Arial" size="2"><i>Não existe informações disponíveis para esta equipe.</i></font>
	<br/><br />
	<?
	}
		$qtde_total_voz_geral_50 += $qtde_total_voz_equipe_50;
		$vl_total_voz_geral_50 += $vl_total_voz_equipe_50;
		$qtde_total_servicos_geral_50 += $qtde_total_servicos_equipe_50;
		$vl_total_servicos_geral_50 += $vl_total_servicos_equipe_50;
		$qtde_total_combo_geral_50 += $qtde_total_combo_equipe_50;
		$vl_total_combo_geral_50 += $vl_total_combo_equipe_50;
		
		$qtde_total_voz_geral_75 += $qtde_total_voz_equipe_75;
		$vl_total_voz_geral_75 += $vl_total_voz_equipe_75;
		$qtde_total_servicos_geral_75 += $qtde_total_servicos_equipe_75;
		$vl_total_servicos_geral_75 += $vl_total_servicos_equipe_75;
		$qtde_total_combo_geral_75 += $qtde_total_combo_equipe_75;
		$vl_total_combo_geral_75 += $vl_total_combo_equipe_75;
		
		$qtde_total_voz_equipe_50 ="";
		$vl_total_voz_equipe_50 ="";
		$qtde_total_servicos_equipe_50 ="";
		$vl_total_servicos_equipe_50 ="";
		$qtde_total_combo_equipe_50 ="";
		$vl_total_combo_equipe_50 ="";
		
		
		$qtde_total_voz_equipe_75 = "";
		$vl_total_voz_equipe_75 = "";
		$qtde_total_servicos_equipe_75 = "";
		$vl_total_servicos_equipe_75 = "";
		$qtde_total_combo_equipe_75 = "";
		$vl_total_combo_equipe_75 = "";
}
mysql_free_result($rs_equipe);
?>
<br>
<font face="Arial"><b>Total Geral</b></font>
<table width="100%" cellspacing="0" cellpadding="0" align="center" border="1" class="sortable">	
	<thead>
		<tr>
			<td class="titulo" bgcolor="#8080FF" width="25%">Status</td>
			<td class="titulo" bgcolor="#8080FF" width="16%">Total Leads</td>						
			<td class="titulo" bgcolor="#8080FF" width="115">Qtde Voz Linhas</td>
			<td class="titulo" bgcolor="#8080FF" width="90">VL Voz</td>
			<td class="titulo" bgcolor="#8080FF" width="100">Qtde Serviços</td>
			<td class="titulo" bgcolor="#8080FF" width="90">VL Serviços</td>
			<td class="titulo" bgcolor="#8080FF" width="90">Qtde Combos</td>
			<td class="titulo" bgcolor="#8080FF" width="90">VL Combos</td>
			<td class="titulo" bgcolor="#8080FF" width="90">Valor Total</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="form">Lead 25%</td>
			<td class="form" align="center"><?= $arrTotalGeralLeads[4]?></td>
			<td class="form" align="center" colspan=7>&nbsp;</td>
			
		</tr>
		<tr>
			<td class="form">Lead 50%</td>
			<td class="form" align="center"><?= $arrTotalGeralLeads[5]?></td>
			<td class="form" align="center"><?= $qtde_total_voz_geral_50;?></td>						
			<td class="form" align="center"><?= number_format($vl_total_voz_geral_50,2);?></td>
			<td class="form" align="center"><?= $qtde_total_servicos_geral_50;?></td>
			<td class="form" align="center"><?= number_format($vl_total_servicos_geral_50,2)?></td>
			<td class="form" align="center"><?= $qtde_total_combo_geral_50;?></td>
			<td class="form" align="center"><?= number_format($vl_total_combo_geral_50,2)?></td>
			<td class="form" align="center"><?= number_format($arrTotalGeralValor[5],2)?></td>
		</tr>
		<tr>
			<td class="form">Forecast 75%</td>
			<td class="form" align="center"><?= $arrTotalGeralLeads[6]?></td>
			<td class="form" align="center"><?= $qtde_total_voz_geral_75;?></td>						
			<td class="form" align="center"><?= number_format($vl_total_voz_geral_75,2);?></td>
			<td class="form" align="center"><?= $qtde_total_servicos_geral_75;?></td>
			<td class="form" align="center"><?= number_format($vl_total_servicos_geral_75,2)?></td>
			<td class="form" align="center"><?= $qtde_total_combo_geral_75;?></td>
			<td class="form" align="center"><?= number_format($vl_total_combo_geral_75,2)?></td>
			<td class="form" align="center"><?= number_format($arrTotalGeralValor[6],2)?></td>
		</TR>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF">&nbsp;</td>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= $arrTotalGeralLeads[4] + $arrTotalGeralLeads[5] + $arrTotalGeralLeads[6]; ?></td>
			<td class="titulo" bgcolor="#8080FF"><?= $qtde_total_voz_geral_50 + $qtde_total_voz_geral_75;?></td>						
			<td class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_voz_geral_50+$vl_total_voz_geral_75,2);?></td>
			<td class="titulo" bgcolor="#8080FF"><?= $qtde_total_servicos_geral_50+$qtde_total_servicos_geral_75;?></td>
			<td class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_servicos_geral_50+$vl_total_servicos_geral_75,2)?></td>
			<td class="titulo" bgcolor="#8080FF"><?= $qtde_total_combo_geral_50+$qtde_total_geral_combo_75;?></td>
			<td class="titulo" bgcolor="#8080FF"><?= number_format($vl_total_combo_geral_50+$vl_total_combo_geral_75,2)?></td>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= number_format($arrTotalGeralValor[5] + $arrTotalGeralValor[6],2); ?></td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?	

set_time_limit(300);
include_once "../../libs/desconectar.php";?>
