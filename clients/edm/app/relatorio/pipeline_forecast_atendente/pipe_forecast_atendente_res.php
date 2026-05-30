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

//$cod_polo = $_REQUEST['cod_polo'];
$codequipe = $_REQUEST['codequipe'];
$codatendente = $_REQUEST['codatendente'];
$mailling = $_REQUEST['mailing'];
$datastatusde = $_REQUEST['datastatusde'];
$datastatusate = $_REQUEST['datastatusate'];

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
		<font size="+2">Pipeline e Forecast Atendente</font>
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
	if(!empty($codatendente)){
		$sql = "select nome from usuariosinternos where codusuariointerno = $codatendente ";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		?>
		<tr>
			<td>Atendente: <?= $row['nome'];?></td>
		</tr>
		<?
		mysql_free_result($result);
	}
	if(!empty($mailing)){
		?>
		<tr>
			<td>Mailing: <?= $mailing;?></td>
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
	$sql.="Select codusuariointerno, nome ";
	$sql.="  from usuariosinternos ui ";
	$sql.=" where atendente = 1 ";
	$sql.="    ";
	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$sql.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";

	if(!empty($codatendente))
		$sql.=" and ui.codusuariointerno = $codatendente ";

	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
	//pega os 25%
		?>
		<br>
		<font face="Arial"><b>Atendente: <?= $row['nome'];?></b></font>
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

			//Esta consulta consolida em uma única query o dados da proposta e suas datas principais, é utilizada como subquery nas consultas de statusclassificacao 5 (lead 50%) e 6 (forecast 75%)
			$propostas ="";
			$propostas.="select p.codlead, p.codproduto, p.codproposta, p.versao, p.datacancelamento, p.totalproposta, p.valorcontrato, p.codmotivo, p.numpvc, dp.envio_lead, dp1.previsao_recebe_assinatura, dp2.recebe_assinatura, dp3.envio_contrato_operadora, dp4.ativacao, dp5.entrega_aparelho	";
			$propostas.="  from propostas p	";
			$propostas.="        left join (select valor_data envio_lead, codlead, codproposta, versao	";
			$propostas.="                     from data_proposta	";
			$propostas.="                    where nome_data = 'envio_lead') dp on(p.codlead = dp.codlead	";
			$propostas.="                                                      and p.codproposta = dp.codproposta	";
			$propostas.="                                                      and p.versao = dp.versao)	";
			$propostas.="        left join (select valor_data previsao_recebe_assinatura, codlead, codproposta, versao	";
			$propostas.="                     from data_proposta	";
			$propostas.="                    where nome_data = 'previsao_recebe_assinatura') dp1 on(p.codlead = dp1.codlead	";
			$propostas.="                                                      and p.codproposta = dp1.codproposta	";
			$propostas.="                                                      and p.versao = dp1.versao)	";
			$propostas.="        left join (select valor_data recebe_assinatura, codlead, codproposta, versao	";
			$propostas.="                     from data_proposta	";
			$propostas.="                    where nome_data = 'recebe_assinatura') dp2 on(p.codlead = dp2.codlead	";
			$propostas.="                                                      and p.codproposta = dp2.codproposta	";
			$propostas.="                                                      and p.versao = dp2.versao)	";
			$propostas.="        left join (select valor_data envio_contrato_operadora, codlead, codproposta, versao	";
			$propostas.="                     from data_proposta	";
			$propostas.="                    where nome_data = 'envio_contrato_operadora') dp3 on(p.codlead = dp3.codlead	";
			$propostas.="                                                      and p.codproposta = dp3.codproposta	";
			$propostas.="                                                      and p.versao = dp3.versao)	";
			$propostas.="        left join (select valor_data ativacao, codlead, codproposta, versao	";
			$propostas.="                     from data_proposta	";
			$propostas.="                    where nome_data = 'ativacao') dp4 on(p.codlead = dp4.codlead	";
			$propostas.="                                                      and p.codproposta = dp4.codproposta	";
			$propostas.="                                                      and p.versao = dp4.versao)	";
			$propostas.="        left join (select valor_data entrega_aparelho, codlead, codproposta, versao	";
			$propostas.="                     from data_proposta	";
			$propostas.="                    where nome_data = 'entrega_aparelho') dp5 on(p.codlead = dp5.codlead	";
			$propostas.="                                                      and p.codproposta = dp5.codproposta	";
			$propostas.="                                                      and p.versao = dp5.versao)	";

			if($row_status['codstatusclassificacaolead'] == 4){

				$total_dias_atraso = 2;

				$sql ="";
				$sql.="select l.codlead, l.razaosocial, datediff(sysdate(), ifnull(max(al.datahorario),'1900-01-01')) dias ";
				$sql.="  from leads l ";
				$sql.="		  inner join agendaslead al on al.codlead = l.codlead ";
				$sql.=" where l.codstatusclassificacaolead = 4 ";
				$sql.="   and l.codatendente = ".$row['codusuariointerno'];
				$sql.="	  and al.codtipo = 1 ";
				$sql.="   and al.datahorario < sysdate() ";

				//Regras de visualização de equipe de consultores
				if(!permissao('visualizar_todos_atendentes', 'cs'))
					$sql .= " and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).")";

				//regras de visualização do polo
				if(!empty($_SESSION['cod_polo']))
					$sql .= " and l.cod_polo = ".$_SESSION['cod_polo']." ";

				if(!empty($mailing))
					$sql.=" and l.mailing = '".$mailling."' ";

				if(!empty($datastatusde))
					$sql.=" and al.datahorario >= '".DataYMD($datastatusde)." 00:00:00' ";

				if(!empty($datastatusate))
					$sql.=" and al.datahorario <= '".DataYMD($datastatusate)." 23:59:59' ";

				if(!empty($_REQUEST['cod_polo']))
					$sql.="and l.cod_polo =".$_REQUEST['cod_polo'];

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
				$sql.="select l.codlead ";
				$sql.=", l.razaosocial ";
				$sql.=", prop.codproposta ";
				$sql.=", prop.versao ";
				if($row_status['codstatusclassificacaolead'] == 5){
					$sql.=", datediff(sysdate(), prop.envio_lead) dias ";
				}
				elseif($row_status['codstatusclassificacaolead'] == 6){
					$sql.=", datediff(sysdate(), prop.previsao_recebe_assinatura) dias ";
				}
				$sql.=", pd.nome produto ";
				$sql.=", prop.totalproposta ";
				$sql.=", prop.envio_lead ";
				$sql.=", prop.previsao_recebe_assinatura ";
				$sql.=", prop.recebe_assinatura ";
				$sql.=", prop.envio_contrato_operadora ";
				$sql.=", prop.ativacao ";
				$sql.=", prop.entrega_aparelho ";
				$sql.="  from leads l ";
				$sql.="       inner join ($propostas) prop on prop.codlead = l.codlead ";
				$sql.="       inner join produtos pd on prop.codproduto = pd.codproduto ";
				$sql.=" where l.codatendente = ".$row['codusuariointerno'];

				//Regras de visualização de equipe de consultores
				if(!permissao('visualizar_todos_atendentes', 'cs'))
					$sql .= " and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).")";

				//regras de visualização do polo
				if(!empty($_SESSION['cod_polo']))
					$sql .= " and l.cod_polo = ".$_SESSION['cod_polo']." ";

				if(!empty($mailing))
					$sql.=" and l.mailing = '".$mailling."' ";

				if($row_status['codstatusclassificacaolead'] == 5){

					if(!empty($datastatusde))
						$sql.=" and prop.envio_lead >= '".DataYMD($datastatusde)." 00:00:00' ";

					if(!empty($datastatusate))
						$sql.=" and prop.envio_lead <= '".DataYMD($datastatusate)." 23:59:59' ";

					$sql.=" and prop.envio_lead is not null ";
					$sql.=" and prop.previsao_recebe_assinatura is null ";
					$sql.=" and prop.recebe_assinatura is null ";
					$sql.=" and prop.envio_contrato_operadora is null ";
					$sql.=" and prop.ativacao is null ";
					$sql.=" and prop.entrega_aparelho is null ";
				}
				elseif ($row_status['codstatusclassificacaolead'] == 6){

					if(!empty($datastatusde))
						$sql.=" and prop.previsao_recebe_assinatura >= '".DataYMD($datastatusde)." 00:00:00' ";

					if(!empty($datastatusate))
						$sql.=" and prop.previsao_recebe_assinatura <= '".DataYMD($datastatusate)." 23:59:59' ";

					$sql.=" and prop.envio_lead is not null ";
					$sql.=" and prop.previsao_recebe_assinatura is not null ";
					$sql.=" and prop.recebe_assinatura is null ";
					$sql.=" and prop.envio_contrato_operadora is null ";
					$sql.=" and prop.ativacao is null ";
					$sql.=" and prop.entrega_aparelho is null ";
				}

				if(!empty($_REQUEST['cod_polo']))
					$sql.="and l.cod_polo = ".$_REQUEST['cod_polo'];

				$sql.="   and prop.datacancelamento is null ";
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
							<td class="titulo" bgcolor="#8080FF">Razão Social</td>
							<?if($row_status['codstatusclassificacaolead'] == 5 || $row_status['codstatusclassificacaolead'] == 6){?>
								<td class="titulo" bgcolor="#8080FF">Plano</td>
								<td class="titulo" bgcolor="#8080FF">Proposta</td>
								<td class="titulo" bgcolor="#8080FF">Versão</td>
							<?}?>
							<td class="titulo" bgcolor="#8080FF">Qtde Dias</td>
							<?if($row_status['codstatusclassificacaolead'] == 5 || $row_status['codstatusclassificacaolead'] == 6){?>
								<td class="titulo" bgcolor="#8080FF">Linhas</td>
								<td class="titulo" bgcolor="#8080FF">Valor</td>
							<?}?>
						</tr>
					</thead>
					<tbody>
					<?while($row_leads = mysql_fetch_array($rs_leads)){

						if ($row_leads['dias'] > $total_dias_atraso)
							$cor_fonte = "red";
						else
							$cor_fonte = "";

						if($row_status['codstatusclassificacaolead'] == 5 || $row_status['codstatusclassificacaolead'] == 6){

							$total_linhas = 0;
							//procura na modulosproposta as informações de quantidade de linhas e valor da proposta
							$sql ="";
							$sql.="select (ifnull(mp.valor,0) + ifnull(mp.calculado,0)) linhas ";
							$sql.="  from modulosproposta mp ";
							$sql.=" where mp.id = 'qtdelinhas' ";
							$sql.="   and mp.codproposta = ".$row_leads['codproposta'];
							$sql.="   and mp.codlead = ".$row_leads['codlead'];
							$sql.="   and mp.versao = ".$row_leads['versao'];
							$rs_linhas = mysql_query($sql);
							while($row_linhas = mysql_fetch_array($rs_linhas))
								$total_linhas += $row_linhas['linhas'];
							mysql_free_result($rs_linhas);

							$total_valor_status += $row_leads['totalproposta'];
							$total_qtde_status += $total_linhas;

						?>
							<tr bgcolor="<?= $cor?>">
								<td class="form"><a href="../../vendas/leads/leadgerenciamentores.php?codlead=<?= $row_leads['codlead'];?>"><?= $row_leads['razaosocial']?></a></td>
								<td class="form" align="center"><?= $row_leads['produto'];?></td>
								<td class="form" align="center"><?= $row_leads['codproposta'];?></td>
								<td class="form" align="center"><?= $row_leads['versao'];?></td>
								<td class="form" align="center"><?= $row_leads['dias'];?></td>
								<td class="form" align="center"><?= $total_linhas;?></td>
								<td class="form" align="center"><?= number_format($row_leads['totalproposta'],2);?></td>
							</tr>
						<? }else{?>
							<tr bgcolor="<?= $cor?>">
								<td class="form"><a href="../../vendas/leads/leadgerenciamentores.php?codlead=<?= $row_leads['codlead'];?>"><font color="<?= $cor_fonte;?>"><?= $row_leads['razaosocial']?></font></a></td>
								<td class="form" align="center"><font color="<?= $cor_fonte;?>"><?= $row_leads['dias'];?></font></td>
							</tr>
						<?}?>
					<?}?>
					</tbody>
					<tfoot>
						<tr class="link_cinza">
							<?

							//calcula os totais gerais
							$arrTotalConsultorLeads[$row_status['codstatusclassificacaolead']] += $total_leads;
							$arrTotalConsultorLinhas[$row_status['codstatusclassificacaolead']] += $total_qtde_status;
							$arrTotalConsultorValor[$row_status['codstatusclassificacaolead']] += $total_valor_status;

							$arrTotalGeralLeads[$row_status['codstatusclassificacaolead']] += $total_leads;
							$arrTotalGeralLinhas[$row_status['codstatusclassificacaolead']] += $total_qtde_status;
							$arrTotalGeralValor[$row_status['codstatusclassificacaolead']] += $total_valor_status;

							$arrTotalEquipeLeads[$row_status['codstatusclassificacaolead']] += $total_leads;
							$arrTotalEquipeLinhas[$row_status['codstatusclassificacaolead']] += $total_qtde_status;
							$arrTotalEquipeValor[$row_status['codstatusclassificacaolead']] += $total_valor_status;

							?>
							<?if($row_status['codstatusclassificacaolead'] == 5 || $row_status['codstatusclassificacaolead'] == 6){?>
								<td align="center" class="titulo" bgcolor="#8080FF" colspan="5">Total: <?= $total_leads;?> Lead(s)</td>
								<td align="center" class="titulo" bgcolor="#8080FF"><?= $total_qtde_status;?></td>
								<td align="center" class="titulo" bgcolor="#8080FF"><?= number_format($total_valor_status,2);?></td>
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
			<font face="Arial"><b>Total Atendente: <?= $row['nome'];?></b></font>
			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="1" class="sortable">
				<thead>
					<tr>
						<td class="titulo" bgcolor="#8080FF">Status</td>
						<td class="titulo" bgcolor="#8080FF">Total Leads</td>
						<td class="titulo" bgcolor="#8080FF">Linhas</td>
						<td class="titulo" bgcolor="#8080FF">Valor</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="form">Lead 25%</td>
						<td class="form" align="center"><?= $arrTotalConsultorLeads[4]?></td>
						<td class="form" align="center">&nbsp;</td>
						<td class="form" align="center">&nbsp;</td>
					</tr>
					<tr>
						<td class="form">Lead 50%</td>
						<td class="form" align="center"><?= $arrTotalConsultorLeads[5]?></td>
						<td class="form" align="center"><?= $arrTotalConsultorLinhas[5]?></td>
						<td class="form" align="center"><?= number_format($arrTotalConsultorValor[5],2)?></td>
					</tr>
					<tr>
						<td class="form">Forecast 75%</td>
						<td class="form" align="center"><?= $arrTotalConsultorLeads[6]?></td>
						<td class="form" align="center"><?= $arrTotalConsultorLinhas[6]?></td>
						<td class="form" align="center"><?= number_format($arrTotalConsultorValor[6],2)?></td>
					</TR>
				</tbody>
				<tfoot>
					<tr class="link_cinza"  >
						<td align="center" class="titulo" bgcolor="#8080FF">&nbsp;</td>
						<td align="center" class="titulo" bgcolor="#8080FF"><?= $arrTotalConsultorLeads[4] + $arrTotalConsultorLeads[5] + $arrTotalConsultorLeads[6]; ?></td>
						<td align="center" class="titulo" bgcolor="#8080FF"><?= $arrTotalConsultorLinhas[5] + $arrTotalConsultorLinhas[6]; ?></td>
						<td align="center" class="titulo" bgcolor="#8080FF"><?= number_format($arrTotalConsultorValor[5] + $arrTotalConsultorValor[6],2); ?></td>
					</tr>
				</tfoot>
			</table>
			<br />
		<?
		}
	}
	mysql_free_result($result);
?>
<br>
<font face="Arial"><b>Total Geral</b></font>
<table width="100%" cellspacing="0" cellpadding="0" align="center" border="1" class="sortable">
	<thead>
		<tr>
			<td class="titulo" bgcolor="#8080FF">Status</td>
			<td class="titulo" bgcolor="#8080FF">Total Leads</td>
			<td class="titulo" bgcolor="#8080FF">Linhas</td>
			<td class="titulo" bgcolor="#8080FF">Valor</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="form">Lead 25%</td>
			<td class="form" align="center"><?= $arrTotalGeralLeads[4]?></td>
			<td class="form" align="center">&nbsp;</td>
			<td class="form" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td class="form">Lead 50%</td>
			<td class="form" align="center"><?= $arrTotalGeralLeads[5]?></td>
			<td class="form" align="center"><?= $arrTotalGeralLinhas[5]?></td>
			<td class="form" align="center"><?= number_format($arrTotalGeralValor[5],2)?></td>
		</tr>
		<tr>
			<td class="form">Forecast 75%</td>
			<td class="form" align="center"><?= $arrTotalGeralLeads[6]?></td>
			<td class="form" align="center"><?= $arrTotalGeralLinhas[6]?></td>
			<td class="form" align="center"><?= number_format($arrTotalGeralValor[6],2)?></td>
		</TR>
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF">&nbsp;</td>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= $arrTotalGeralLeads[4] + $arrTotalGeralLeads[5] + $arrTotalGeralLeads[6]; ?></td>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= $arrTotalGeralLinhas[5] + $arrTotalGeralLinhas[6]; ?></td>
			<td align="center" class="titulo" bgcolor="#8080FF"><?= number_format($arrTotalGeralValor[5] + $arrTotalGeralValor[6],2); ?></td>
		</tr>
	</tfoot>
</table>
</body>
</html>
<?

set_time_limit(300);
include_once "../../libs/desconectar.php";?>