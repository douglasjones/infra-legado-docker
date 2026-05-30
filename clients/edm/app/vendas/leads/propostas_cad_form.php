<?
include_once "../../libs/maininclude.php";
include_once "propostas_cla.php";
include_once "../../libs/combo.php";

$acao = $_REQUEST['acao'];
$leads_pk = $_REQUEST['codlead'];
$agendalead_pk = $_REQUEST['agendalead_pk'];
$h_termino_visita = $_REQUEST['termino'];
$status_classificacao_pk = $_REQUEST['status_classificacao_pk'];
$pk = $_REQUEST['pk'];
$operador_pk = $_REQUEST['operador_pk'];
$tipo_proposta = $_REQUEST['tipo_proposta'];
$informacoes1 = $_REQUEST['informacoes1'];
$dt_cancelamento = $_REQUEST['dt_cancelamento'];

if(!empty($pk)){
	$propostas = new propostas($pk);
	$pk = $propostas->getpk();
	$leads_pk = $propostas->getleads_pk();
	$n_pedido = $propostas->getn_pedido();
	$operador_pk = $propostas->getoperador_pk();
	$ds_obs_proposta = $propostas->getds_obs_proposta(); 
	$dt_validade = $propostas->getdt_validade();
	$vl_total_proposta = $propostas->getvl_total_proposta();
	$trade_in = $propostas->gettrade_in();
    $vl_desconto_claro = $propostas->getvl_desconto_claro();
    $vl_ult_conta = $propostas->getvl_ult_conta();
    $email_contato = $propostas->getemail_contato();
    $dt_cancelamento = $propostas->getdt_cancelamento();
}           
            
function criarComboStatus($sql, $nomecombo, $valordefault = null, $textoinicial = null, $complemento = null, $valorinicial = null){
	$result = mysql_query($sql) or die (mysql_error());
	echo "<select id=".$nomecombo." name=".$nomecombo." ".$complemento.">";
	if(!empty($textoinicial)){
		echo 	"<option value=".$valorinicial.">".$valorinicial."</option>";
	}
	while($row = mysql_fetch_array($result)){
		if($row[2]==""){
			$status = 'color:#009900';
		}else{
			$status = 'color:#990000';
		}			
		if ($row[0] == $valordefault){			
			echo "<option value=".$row[0]." style=".$status." selected='selected'>".$row[1]."</option>";			
		}else{			
			echo "<option value=".$row[0]."  style=".$status.">".$row[1]."</option>";			
		}	
	}
	mysql_free_result($result);
	echo "</select>";	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<!--Cabeçalho-->
		<title>propostas</title>	
		<!--Include CSS-->
		<link rel="stylesheet" href="../../extras/public.css" type="text/css">
		<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
		<?	include_once "../../libs/head.php";?>		
		<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
		<script type="text/javascript" language="JavaScript" src="propostas_cad_form.js"></script>
		<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>
		<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
		<script>
			<?
            //Cód do book de ofertas
                    $sql="";
                    $sql.="SELECT npb.pk FROM n_produtos_book npb WHERE npb.operador_pk=".$operador_pk;
                    $result = mysql_query($sql);
					while($row = mysql_fetch_array($result))
                        $pk_book=$row['pk'];
                    
				//Carrega a lista de produtos VOZ.
                $sql ="";
                $sql.=" SELECT np.pk produto_pk,
						   np.ds_produto,
						   np.dt_cancelamento	
                        FROM n_produtos np
                        LEFT JOIN n_produtos_operadoras npo ON np.pk = npo.produtos_pk
                        WHERE np.produtos_tipo_pk =1
                        AND np.operador_pk	=$operador_pk	
                        AND np.produto_book_pk=$pk_book
                        AND np.dt_cancelamento IS NULL
                        GROUP BY np.pk	
                        ORDER BY np.ds_produto";
				$arrProdutosVoz = result_to_array($sql);
				echo result_to_jsarray("arrProdutosVoz", $arrProdutosVoz);
				
				//Carrega a lista de produtos Combo.
				$sql ="";
				$sql.="Select
							nc.pk,
							nc.ds_combo,
							nc.dt_cancelamento
						from n_combos nc
						where nc.operador_pk=".$operador_pk;
				$sql.="	and nc.dt_cancelamento is null";
				$sql.="		order by nc.ds_combo";
                
								
				$arrProdutosCombo = result_to_array($sql);
				echo result_to_jsarray("arrProdutosCombo", $arrProdutosCombo);
				
				//Carrega a lista de produtos Dados.
				$sql ="";
                $sql.=" SELECT np.pk produto_pk,
						   np.ds_produto,
						   np.dt_cancelamento	
                        FROM n_produtos np
                        LEFT JOIN n_produtos_operadoras npo ON np.pk = npo.produtos_pk
                        WHERE np.produtos_tipo_pk =3
                        AND np.operador_pk	=$operador_pk	
                        AND np.produto_book_pk=$pk_book
                        AND np.dt_cancelamento IS NULL
                        GROUP BY np.pk	
                        ORDER BY np.ds_produto";
		               			
				$arrProdutosDados = result_to_array($sql);
				echo result_to_jsarray("arrProdutosDados", $arrProdutosDados);
				
				//Carrega a lista de produtos Modulos.
				$sql ="";
                $sql.=" SELECT np.pk produto_pk,
						   np.ds_produto,
						   np.dt_cancelamento	
                        FROM n_produtos np
                        LEFT JOIN n_produtos_operadoras npo ON np.pk = npo.produtos_pk
                        WHERE np.produtos_tipo_pk =4
                        AND np.operador_pk	=$operador_pk	
                        AND np.produto_book_pk=$pk_book
                        AND np.dt_cancelamento IS NULL
                        GROUP BY np.pk	
                        ORDER BY np.ds_produto";
								
				$arrProdutosModulos = result_to_array($sql);
				echo result_to_jsarray("arrProdutosModulos", $arrProdutosModulos);
				
				$sql ="";
				$sql.="Select 
					  nap.pk,
					  nap.ds_aparelho,
					  nap.dt_cancelamento
					from n_aparelhos nap
					left join n_aparelhos_fabricantes npf on nap.fabricante_pk = npf.pk
					where nap.operador_pk=".$operador_pk;
				$sql.="	and nap.dt_cancelamento is null";
				$sql.="		order by npf.ds_aparelho_fabricante,nap.ds_aparelho";
				
				$arrAparelhos = result_to_array($sql);
				echo result_to_jsarray("arrAparelhos", $arrAparelhos);	
				
				$sql = "";
				$sql.= "Select
							npl.pk,
							npl.dsc_tipo_linha
						from n_produto_tipo_linha npl";
				$arrTipoLinha = result_to_array($sql);
				echo result_to_jsarray("arrTipoLinha", $arrTipoLinha);	
				
				  $sql = "";
				$sql.= "Select
							npa.pk
							,npa.dsc_parcelamento
							,npa.dt_cancelamento
						from n_parcelamento npa
						order by npa.pk";
				$arrParcelamento = result_to_array($sql);
				echo result_to_jsarray("arrParcelamento", $arrParcelamento);	
			   
			    //Forma Aquisicao
			    $sql = "";
				$sql.= "Select
							nfa.pk
							,nfa.dsc_forma_aquisicao
							,nfa.dt_cancelamento
						from n_forma_aquisicao nfa
						order by nfa.pk";
				$arrFormaAquisicao = result_to_array($sql);
				echo result_to_jsarray("arrFormaAquisicao", $arrFormaAquisicao); 	
					
			?>
		</script>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
		<form name="dados" method="post" action="propostas_cad_proc.php">
			<input type='hidden' name='acao' id='acao' value='' />
			<input type='hidden' name='pk' value='<?=$pk;?>' />	
			<input type='hidden' name='operador_pk' value='<?=$operador_pk;?>' />
			<input type="hidden" name="leads_pk" id="leads_pk" value="<?=$leads_pk;?>" />
			<input type="hidden" name="agendalead_pk" id="agendalead_pk" value="<?=$agendalead_pk;?>" />				
			<input type="hidden" name="itens_voz" id="itens_voz" value="" />
			<input type="hidden" name="itens_combo" id="itens_combo" value="" />
			<input type="hidden" name="itens_dados" id="itens_dados" value="" />
			<input type="hidden" name="itens_modulos" id="itens_modulos" value="" />
			<input type="hidden" name="itens_aparelhos" id="itens_aparelhos" value="" />
			<input type="hidden" name="datas_proposta" id="datas_proposta" value="" />
			<input type="hidden" name="processo_datas_proposta" id="processo_datas_proposta" value="" />
			<input type="hidden" name="vl_total_proposta" id="vl_total_proposta" value="" />
			<input type="hidden" name="tipo_proposta" id="tipo_proposta" value="<?=$tipo_proposta;?>"/>
            <input type="hidden" name="informacoes1" id="informacoes1" value="<?=$informacoes1;?>"/>
            <input type="hidden" name="dt_cancelamento" id="dt_cancelamento" value="<?=$dt_cancelamento;?>"/>
                        
            <input type="hidden" name="h_termino_visita" id="h_termino_visita" value="<?=$h_termino_visita;?>"/>
            <input type="hidden" name="status_classificacao_pk" id="status_classificacao_pk" value="<?=$status_classificacao_pk;?>"/>
            
			
			<input type="hidden" name="nomeusuario" id="nomeusuario" value="<?=$_SESSION['nomeusuario'];?>"/>
			<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
				
				<tr>
					<td  class="titulo">
						 <font color="ffffff">Proposta</font>
					</td>
				</tr>
			</table>
			<table width="100%"  align="center" border="0" cellpadding="1" cellspacing="0" class="form">
				<tr>
					<td colspan="2">
						
					</td>
				</tr>
				<tr>
					<td colspan=2>
						<table width="100%"  cellpadding="1" cellspacing="0" class="form">
							<tr>					
								<td width="10%">
									Código Lead:
								</td>
								<td>
									<?=$leads_pk;?>
								</td>
							</tr>
							<tr>
								<td>
									Razão Social:
								</td>
								<td>
									<?
									
										$sql = "";
										$sql.= "Select l.razaosocial from leads l where l.codlead=".$leads_pk;
										$result = sql_query($sql);
										$row = mysql_fetch_array($result);
										echo $row['razaosocial'];
										mysql_free_result($result);
										
									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<? 
                
					$sql ="";
					$sql.="Select 
								npt.pk
								,npt.ds_tipo_produto
							from n_produtos_tipo npt";
					$sql.="	order by npt.n_ordem";
                    
                
                   
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result)){
						$sql = "";
						$sql.= "Select
									np.pk
								from n_produtos np
								where np.operador_pk=".$operador_pk;
						$sql.= " and np.produtos_tipo_pk=".$row['pk']; 		
						$sql.= " group by np.produtos_tipo_pk";	
						$sql.= " Union ";
						$sql.= " Select
									nc.pk
								 from n_combos nc
									where nc.operador_pk=".$operador_pk;
						$sql.= " group by nc.pk";
						$tipo = mysql_query($sql);
						$num = mysql_num_rows($tipo);	

                        
							
						if(!empty($num)){	
						$v_tabela = $row['ds_tipo_produto'];?>			
						<tr>
							<td colspan=2>						
								<div id=<?=$v_tabela;?> style='display: incline;'>									
									<table width='100%' border=0 none; cellpadding='1' cellspacing='1' >
										<tr style="border:1px solid black;">
												<td align="center">										
                                                    <b><?
                                                    if($operador_pk==3){
                                                        if($v_tabela=='Voz'){
                                                            echo "PLANOS VIVO EMPRESAS";
                                                        }else if($v_tabela=='Modulos'){
                                                            echo "VIVO GESTÃO / PACOTES ADICIONAIS"; 
                                                        }else if($v_tabela=='Dados'){
                                                            echo "DADOS"; 
                                                        }else if($v_tabela=='Combo'){
                                                            echo "SERVIÇOS DIGITAIS"; 
                                                        }                                                                                                                 
                                                    }else{
                                                     echo $v_tabela;
                                                    }
                                                    ?></b>	
												</td>
											</td>
										</tr>
										<tr>	
											<td>
												<table width='100%' border='1' bordercolor="#CCCCCC" cellpadding='0' cellspacing='0' id='tbl' name='tbl'>
													<thead>
														<tr class='grid'>
															<?if($row['pk']==1){?>
																<th width='180px' nowrap='true'>
																	Produto
																</th>
																<th  nowrap='true'>
																	Tipo Linha
																</th>
																<th  nowrap='true'>
																	DDD
																</th>	
																<th  nowrap='true'>
																	Qtde
																</th>		
																<th  nowrap='true'>
																	Valor Unit
																</th>														
																<th  nowrap='true'>
																	Assinatura
																</th>
																<th  nowrap='true'>
																	Franquia
																</th>	
																<th  nowrap='true'>
																	Tarifas Locais
																</th>
																<th  nowrap='true'>
																	Tarifas Longa Distancia
																</th>																
																<th  nowrap='true'>
																	Total
																</th>
																<th  nowrap='true'>
																	Ação
																</th>	
															<?}else{?>	
																<th width='220px' nowrap='true'>
																	Produto
																</th>
																<th  nowrap='true'>
																	Qtde
																</th>																									
																<th  nowrap='true'>
																	Valor Unit
																</th>
																<th  nowrap='true'>
																	Total
																</th>
																<th  nowrap='true'>
																	Ação
																</th>		
															<?}?>
														</tr>
													</thead>
													<tbody id="tbl_<?=$row['ds_tipo_produto'];?>">
														<?if(!empty($pk)){
															if($row['pk']!=2){
                                                               $sql = "";
																$sql .= "SELECT nip.pk,
																			   nip.produtos_pk,
																			   npr.ds_produto,
																			   nip.n_qtde,
																			   nip.vl_unitario,
																			   nipo.vl_franquia,
																			   nipo.tipo_linha_pk,
																			   nip.ddd       
																		  FROM n_itens_propostas nip
																			   INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
																			   left JOIN n_itens_propostas_operadoras nipo ON nipo.itens_propostas_pk = nip.pk
																		where nip.propostas_pk=".$pk;
																  $sql .= " and npr.produtos_tipo_pk=".$row['pk'];
                                                            }else{
																$sql = "SELECT nip.pk,
																	   nip.combos_pk,
																	   nc.ds_combo,
																	   nip.n_qtde,
																	   nip.vl_unitario
																  FROM n_itens_propostas nip
																  INNER JOIN n_combos nc ON nip.combos_pk = nc.pk
																 WHERE nip.propostas_pk=".$pk;																 
                                                            }  
															  $results = sql_query($sql);
                                                                            $v_linha = "0";
                                                                            $v_total_li = "";
                                                                            $v_total_qtde = "";
                                                                            $v_total = "";
                                                                            $I=0;
															  while($row1 = mysql_fetch_array($results)){
																$v_total_qtde = $v_total_qtde + $row1['n_qtde'];
																$v_total = $v_total +($row1['vl_franquia']+ ($row1['n_qtde'] * $row1['vl_unitario']));
															  ?>
																<tr id="row<?=$I;?>">
															     <?if($row['pk']==1){?>
																		<td align="center"  nowrap='true'>
																			<?
																			
																				$sql = "Select
																						  npr.pk,
																						  npr.ds_produto,
																						  npr.dt_cancelamento
																						from n_produtos npr
																						where npr.produtos_tipo_pk=".$row['pk'];
																				$sql.=" and npr.operador_pk=".$operador_pk;
                                                                                //$sql.=" and npr.produto_book_pk=".$pk_book;
																				$sql.=" ORDER BY npr.ds_produto";

																				criarComboStatus($sql,"produto_pk", $row1['produtos_pk'], " ", "");
																			?>
																		</td>
																		<td align="center"  nowrap='true'>
																			<?
																				$sql = "Select
																						 nptl.pk tipo_linha_pk,
																						 nptl.dsc_tipo_linha
																						from n_produto_tipo_linha nptl";
																				combo($sql,"tipo_linha_pk", $row1['tipo_linha_pk'], " ", "");
																			?>
																		</td>
																		<td align="center">
                                                                            <input type='text' maxlength="2" name='ddd' id='ddd' size='2' style='text-align:right' value='<?=$row1['ddd'];?>' onKeypress='mascara(this,soNumeros)' >
																		</td>
																		<td align="center">
																			<input type='text' name='n_qtde' id='n_qtde' size='5' style='text-align:right' value='<?=$row1['n_qtde'];?>' onKeypress='mascara(this,soNumeros)' onblur="ValoresVoz(this.value,'row<?=$v_linha;?>','tbl_<?=$row['ds_tipo_produto'];?>');">
																		</td>
																		<td align="center"  nowrap='true'>
																			<?
																				$sql = "Select
																							npv.pk
																							,npv.vl_produto
																						from n_produtos_valores npv
																						where npv.produtos_pk=".$row1['produtos_pk'];
																				$sql .= " order by npv.vl_produto desc";
																				$rs = sql_query($sql);
																				echo "<select>";
																				while($rows = mysql_fetch_array($rs)){
																					if($row1['vl_unitario'] == $rows['vl_produto']){
																						echo "<option value=".$rows["pk"]." selected='selected'>".number_format($row1['vl_unitario'],2,",",".")."</option>";
																					}else{
																						echo "<option value=".$rows["pk"].">".number_format($row1['vl_unitario'],2,",",".")."</option>";	
																					}
																				}
																				echo "</select>";
																			?>
																		</td>
																		<td align="center"  nowrap='true'>
																			<input type='text' name='vl_assinatura' id='vl_assinatura' size='10' value='<?=number_format(($row1['n_qtde'] * $row1['vl_unitario']),2,",",".");?>' style='text-align:right' disabled='disabled'  onkeypress='mascara(this,Valor)' >
																		</td>
																		<td align="center"  nowrap='true'>
																			<input type='text' name='vl_franquia' id='vl_franquia' size='10' value='<?=number_format($row1['vl_franquia'],2,",",".");?>' style='text-align:right' onblur="ValoresVoz(this.value,'row<?=$v_linha;?>','tbl_<?=$row['ds_tipo_produto'];?>');" onkeypress='mascara(this,Valor)'>
																		</td>
																		<td align="left"  nowrap='true'>
																			<?
																				$sql = "SELECT  npo.visualiza_vc1_local,
																								npo.dsc_vc1_local,
																								npo.vl_vc1_local,
																								npo.visualiza_vc2_local,
																								npo.dsc_vc2_local,
																								npo.vl_vc3_local,
																								npo.visualiza_vc3_local,
																								npo.dsc_vc3_local,
																								npo.vl_vc2_local,
																								npo.visualiza_vc1_Estad,
																								npo.dsc_vc1_Estad,
																								npo.vl_vc1_Estad,
																								npo.visualiza_vc2_Estad,
																								npo.dsc_vc2_Estad,
																								npo.vl_vc2_Estad,
																								npo.visualiza_vc3_Estad,
																								npo.dsc_vc3_Estad,
																								npo.vl_vc3_Estad
																						FROM n_produtos_operadoras npo
																						WHERE npo.produtos_pk =".$row1['produtos_pk'];
																					
																				$rs_n = sql_query($sql);
																				$num = mysql_num_rows($rs_n);
																				$rss = mysql_fetch_array($rs_n);
																				if(!empty($num)){
																					echo "<table aling=left cellpadding='0' cellspacing='0'>";		
																					echo "<tr >";
																						$sql = "Select
																								  ipo.pk,
																								  ipo.vl_vc1_local,
																								  ipo.vl_vc2_local,
																								  ipo.vl_vc3_local,
                                                                                                  ipo.vl_vc1_Inter_Estad,
																								  ipo.vl_vc2_Inter_Estad,
																								  ipo.vl_vc3_Inter_Estad
																								from n_itens_propostas_operadoras ipo
																								where ipo.itens_propostas_pk=".$row1['pk'];
																						$rs1 = sql_query($sql);
																						$row2 = mysql_fetch_array($rs1);
																					if(!empty($row2['vl_vc1_local'])){
																						echo "<td>";
																						echo "<b><font size='-2'>".$rss['dsc_vc1_local']."</font></b>&nbsp;<input type='text' size='3' id='vc1ir' name='vc1ir' value=".number_format($row2['vl_vc1_local'],2,",",".").">";
																						echo "</td>";
																					}else{
																						echo "<input type='hidden' size='3' id='vc1ir' name='vc1ir' value=''>";
																					}			
																					if(!empty($row2['vl_vc2_local'])){
																						echo "<td>";
																						echo "&nbsp;<b><font size=-2>".$rss['dsc_vc2_local']."</font></b>&nbsp;<input type='text' size='3' id='vc1m' name='vc1m' value=".number_format($row2['vl_vc2_local'],2,",",".").">";
																						echo "</td>";
																					}else{
																						echo "<input type='hidden' size='3' id='vc1m' name='vc1m' value=''>";
																					}	
																					if(!empty($row2['vl_vc3_local'])){
																						echo "<td>";
																						echo "&nbsp;<b><font size=-2>".$rss['dsc_vc3_local']."</font></b>&nbsp;<input type='text' size='3' id='vc1f' name='vc1f' value=".number_format($row2['vl_vc3_local'],2,",",".").">";
																						echo "</td>";
																					}else{
																						echo "<input type='hidden' size='3' id='vc1f' name='vc1f' value=''>";
																					}
                                                                                                                                                                        
                                                                                                                                                                       
																					echo "</tr>";
																					echo "</table>";
																					mysql_free_result($rs1);
																				}
																				
																				mysql_free_result($rs_n);
																			?>
																		</td>
																		<td align="center"  nowrap='true'>
																			<?
																				$sql = "SELECT  npo.visualiza_vc1_local,
																								npo.dsc_vc1_local,
																								npo.vl_vc1_local,
																								npo.visualiza_vc2_local,
																								npo.dsc_vc2_local,
																								npo.vl_vc3_local,
																								npo.visualiza_vc3_local,
																								npo.dsc_vc3_local,
																								npo.vl_vc2_local,
																								npo.visualiza_vc1_Estad,
																								npo.dsc_vc1_Estad,
																								npo.vl_vc1_Estad,
																								npo.visualiza_vc2_Estad,
																								npo.dsc_vc2_Estad,
																								npo.vl_vc2_Estad,
																								npo.visualiza_vc3_Estad,
																								npo.dsc_vc3_Estad,
																								npo.vl_vc3_Estad
																						FROM n_produtos_operadoras npo
																						WHERE npo.produtos_pk =".$row1['produtos_pk'];
																					
																				$rs_n = sql_query($sql);
																				$num = mysql_num_rows($rs_n);
																				$rss = mysql_fetch_array($rs_n);
																				if(!empty($num)){
																					echo "<table aling=left cellpadding='0' cellspacing='0'>";		
																					echo "<tr >";
																						$sql = "Select
																								  ipo.pk,
																								  ipo.vl_vc1_local,
																								  ipo.vl_vc2_local,
																								  ipo.vl_vc3_local,
                                                                                                  ipo.vl_vc1_Inter_Estad,
																								  ipo.vl_vc2_Inter_Estad,
																								  ipo.vl_vc3_Inter_Estad
																								from n_itens_propostas_operadoras ipo
																								where ipo.itens_propostas_pk=".$row1['pk'];
																						
                                                                                            $rs1 = sql_query($sql);
																						$row2 = mysql_fetch_array($rs1);		
																					                                                                                                                                                                        
                                                                                                                                                                        if(!empty($row2['vl_vc1_Inter_Estad'])){
																						echo "<td>";
																						echo "<b><font size='-2'>".$rss['dsc_vc1_Estad']."</font></b>&nbsp;<input type='text' size='3' id='vces' name='vces' value=".number_format($row2['vl_vc1_Inter_Estad'],2,",",".").">";
																						echo "</td>";
																					}else{
																						echo "<input type='hidden' size='3' id='vces' name='vces' value=''>";
																					}			
																					if(!empty($row2['vl_vc2_Inter_Estad'])){
																						echo "<td>";
																						echo "&nbsp;<b><font size=-2>".$rss['dsc_vc2_Estad']."</font></b>&nbsp;<input type='text' size='3' id='vces2m' name='vces2m' value=".number_format($row2['vl_vc2_Inter_Estad'],2,",",".").">";
																						echo "</td>";
																					}else{
																						echo "<input type='hidden' size='3' id='vces2m' name='vces2m' value=''>";
																					}	
																					if(!empty($row2['vl_vc3_Inter_Estad'])){
																						echo "<td>";
																						echo "&nbsp;<b><font size=-2>".$rss['dsc_vc3_Estad']."</font></b>&nbsp;<input type='text' size='3' id='vces2f' name='vces2f' value=".number_format($row2['vl_vc3_Inter_Estad'],2,",",".").">";
																						echo "</td>";
																					}else{
																						echo "<input type='hidden' size='3' id='vces2f' name='vces2f' value=''>";
																					}
																					echo "</tr>";
																					echo "</table>";
																					mysql_free_result($rs1);
																				}
																				
																				mysql_free_result($rs_n);
																			?>
																		</td>
																		<td align="right" width='50px' nowrap='true'>
																			<label name='vl_total'><?=number_format($row1['vl_franquia']+($row1['n_qtde']*$row1['vl_unitario']),2,",",".");?></label>
																		</td>
																		<td align="center" width='50px' nowrap='true'>
																			<a id='excluir' name='excluir' title='Excluir o registro' href='javascript: excluirLinhaItens("row<?=$v_linha;?>","<?=$row['ds_tipo_produto'];?>")'><img border=0 src='../../images/btexcluirfaq.jpg' width=15 height=15></a>
																		</td>
																	<?}else{?>	
																		<td align="center"  nowrap='true'>
																			<?	if($row['pk']!=2){
																					$sql = "Select
																							  npr.pk,
																							  npr.ds_produto,
																							  npr.dt_cancelamento
																							from n_produtos npr
																							where npr.produtos_tipo_pk=".$row['pk'];
																					$sql.=" and npr.operador_pk=".$operador_pk;	
																					//$sql.=" and npr.prodtuo_book_pk=".$pk_book;																				        
																					$sql.="		ORDER BY npr.ds_produto";
																					
																					criarComboStatus($sql,"produto_pk", $row1['produtos_pk'], " ", "");
																				}else{
																					$sql = "Select
																							 nc.pk,
																							 nc.ds_combo,
																							 nc.dt_cancelamento
																							from n_combos nc
																							where nc.dt_cancelamento is null";
																					
																					criarComboStatus($sql,"combos_pk", $row1['combos_pk'], " ", "");		
																				}
																			?>
																		</td>
																	    <td align="center"  nowrap='true'>	
																			<input type='text' name='n_qtde' id='n_qtde' size='5' style='text-align:right' value='<?=$row1['n_qtde'];?>' onKeypress='mascara(this,soNumeros)' onblur="ValoresProdutos(this.value,'row<?=$v_linha;?>','<?=$row['ds_tipo_produto'];?>');">
																		</td>																																											
																		<td align="center"  nowrap='true'>
																			<?
																				if($row['pk']!=2){
																					$sql = "Select
																								npv.pk
																								,npv.vl_produto vl_produto
																							from n_produtos_valores npv
																							where npv.produtos_pk=".$row1['produtos_pk'];
																					$sql .= " order by npv.vl_produto desc";
																				}else{
																					$sql = "Select
																						 nc.pk,
																						 nc.vl_combo as vl_produto
																						from n_combos nc";
																				}
																				$rs = sql_query($sql);
																				echo "<select>";
																				while($rows = mysql_fetch_array($rs)){	
																					if($row1['vl_unitario'] == $rows['vl_produto']){																					
																						echo "<option value=".$rows["pk"]." selected='selected'>".number_format($rows['vl_produto'],2,",",".")."</option>";
																					}else{
																						echo "<option value=".$rows["pk"].">".number_format($rows['vl_produto'],2,",",".")."</option>";	
																					}																					
																				}																				
																				echo "</select>";
																			?>
																		</td>
																		<td align="right" width='50px' nowrap='true'>
																			<label name='vl_total'><?=number_format($row1['n_qtde'] * $row1['vl_unitario'],2,",",".");?></label>
																		</td>
																		<td align="center" width='50px' nowrap='true'>
																			<a id='excluir' name='excluir' title='Excluir o registro' href='javascript: excluirLinhaItens("row<?=$v_linha;?>","<?=$row['ds_tipo_produto'];?>")'><img border=0 src='../../images/btexcluirfaq.jpg' width=15 height=15></a>
																		</td>
																	<?}?>																																										
																</tr>															
															  <?
																$I++;
																$v_linha ++;
																
															  }?>	  
														<?}?>	
													</tbody>
													<tfoot>														
														<tr class="grid">
															<?if($row['pk']==1){?>
																<td colspan="3" align="right">Qtde Linha(s)</td>
																<td class="form" align="center"><label id='n_qtde_total_linhas'  style='text-align:right'><?=$v_total_qtde;?></label></td>
																<td class="form" align="right" colspan="5">Total Voz</td>
																<td class="form" align="right"><label id='vl_total' style='text-align:right'><?=number_format($v_total,2,",",".")?></label></td>
																<td class="form" align="right" >&nbsp;</td>
															<?}else{?>
																<td  align="right">Qtde</td>
																<td class="form" align="center"><label id='n_qtde_total_<?=$v_tabela;?>'  style='text-align:right'><?=$v_total_qtde;?></label></td>
																<td class="form" align="right" >Total <?=$v_tabela;?></td>
                                                                <td class="form" align="right"><label id='n_total_<?=$v_tabela;?>'  style='text-align:right'><?if(!empty($v_total)){echo number_format($v_total,2,",",".");}?></label></td>
																<td class="form" align="right" >&nbsp;</td>																
															<?}?>	
														</tr>
													</tfoot>						
												</table>				
											</td>
										</tr>	
										<tr>
											<td align='center'>
												<input type='button' value='Incluir Item' onclick='addProduto("<?=$v_tabela?>");' />
											</td>
										</tr>
										<tr>
											<td align='center'>
												&nbsp;
											</td>
										</tr>																	
									</table>
								</div>
							</td>
						</tr>								
					<?}}?>
				<tr>
					<td align='center' colspan=2>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan=2>						
						<table width='100%' border=0 none; cellpadding='1' cellspacing='1' >														<tr>	
								<td>
									<table width='80%' border='1' align="center" bordercolor="#CCCCCC" cellpadding='0' cellspacing='0' id='tbl1' name='tbl1'>
										<thead>
											<tr class='grid'>												
												<td width='80%' nowrap='true' align="right">
													Valor Total Plano(s) + Serviço(s)&nbsp;
												</td>
												<td width='150px' nowrap='true'>													
													<label id="v_planos_servicos_proposta" name="v_planos_servicos_proposta"><?=number_format($vl_total_proposta,2,",",".")?></label>
												</td>	
										</thead>
									</table>
								</td>
							</tr>			
						</table>												
					</td>			
				</tr>
				<tr>
					<td align='center' colspan=2>
						&nbsp;
					</td>
				</tr>	
				<tr>
					<td colspan=2>						
						<div id="Aparelhos" style='display: incline;'>									
							<table width='100%' border=0 none; cellpadding='1' cellspacing='1' >
								<tr style="border:1px solid black;">
									<td align="center">										
                                        <b>Aparelhos</b>	
									</td>
								</tr>
								<tr>	
									<td>
										<table width='100%' border='1' bordercolor="#CCCCCC" cellpadding='0' cellspacing='0' id='tbl1' name='tbl1'>
											<thead>
												<tr class='grid'>												
													<th width='150px' nowrap='true'>
														Aparelho(s)
													</th>	
													<th width='30px' nowrap='true'>
														Qtde
													</th>									
													<th width='50px' nowrap='true'>
														Valor Unit
													</th>	
													<th width='80px' nowrap='true'>
														Forma Aquisição
													</th>	
													<th width='80px' nowrap='true'>
														Parcelamento
													</th>
													<th width='80px' nowrap='true'>
														Desconto Total
													</th>															
													<th width='50px' nowrap='true'>
														Total da Parcela
													</th>
													<th width='50px' nowrap='true'>
														Ação
													</th>																																										
												</tr>												
											</thead>
											<tbody id="tbl_aparelhos">
												<?if(!empty($pk)){
													$li = "0";
													$v_total_aparelho_li = "";
													$v_total_qtde_aparelhos = "";
													$v_total_aparelhos = "";
													$sql = "SELECT 	npa.pk, 
																	npa.n_qtde,
																	npa.vl_unitario,
																	npa.aparelhos_pk,
																	npa.parcelamento_pk,
																	npa.forma_aquisicao_pk,
																	npa.vl_desconto_aparelho
															  FROM n_propostas_aparelhos npa															  
															 WHERE npa.propostas_pk =".$pk;
															 		
															
													$result = sql_query($sql);
													$I = 0;
													while($row = mysql_fetch_array($result)){
													$v_total_qtde_aparelhos = $v_total_qtde_aparelhos + $row['n_qtde'];
													$v_total_aparelho_li = (($row['n_qtde']*$row['vl_unitario'] - $row['vl_desconto_aparelho'])/ $row['parcelamento_pk']);
													$v_total_aparelhos = $v_total_aparelhos + $v_total_aparelho_li; 	
												?>
													<tr id="row<?=$I;?>">												
														<td align="center" width='150px' nowrap='true'>
															<?	
																$sql ="";
																$sql.= "Select
																		 nap.pk
																		 ,nap.ds_aparelho
																		from n_aparelhos nap
																		where nap.dt_cancelamento is null
																		order by nap.ds_aparelho";
																		
																combo($sql,"aparelhos_pk", $row['aparelhos_pk'], " ", "");	
															?>
														</td>	
														<td align="center" width='30px' nowrap='true'>
															<input type='text' align="center" name='n_qtde' style='text-align:right' id='n_qtde' size='5' value='<?=$row['n_qtde'];?>' onKeypress='mascara(this,soNumeros)' onblur='calculaValorAparelhos(this.value,"row$li")'>
														</td>									
														<td align="center" width='50px' nowrap='true'>
															<input type='text' align="center" name='' size='10' id='' value='<?=number_format($row['vl_unitario'],2,",",".");?>' style='text-align:right'  onkeypress='mascara(this,Valor)' onblur='calculaValorAparelhos(this.value,"+'"'+ row$li +'"'+")'>
														</td>
														<td align="center" width='50px' nowrap='true'>
															<?	
																$sql ="";
																$sql.= "Select
																		 nfa.pk
																		 ,nfa.dsc_forma_aquisicao
																		from n_forma_aquisicao nfa
																		where nfa.dt_cancelamento is null
																		order by nfa.pk";
																		
																combo($sql,"forma_aquisicao_pk", $row['forma_aquisicao_pk'], " ", "");	
															?>
														</td>	
														<td align="center" width='150px' nowrap='true'>
															<?	
																$sql ="";
																$sql.= "Select
																		npa.pk
																		,npa.dsc_parcelamento
																	from n_parcelamento npa
																	where npa.dt_cancelamento is null
																	order by npa.pk";
																
																combo($sql,"parcelamento_pk", $row['parcelamento_pk'], " ", "");	
															?>
														</td>	
														<td align="center" width='50px' nowrap='true'>
															<input type='text' name='vl_desconto_aparelho' id='vl_desconto_aparelho' size='10' value='<?=number_format($row['vl_desconto_aparelho'],2,",",".");?>' style='text-align:right'   onkeypress='mascara(this,Valor)' onblur='calculaValorAparelhos(this.value,"row$li")'>
														</td>											
														<td align="center" width='50px' nowrap='true'>
															<label name='vl_total_aparelhos'Valor ultima conta *** Cliente</label>
														</td>
														<td align="center" width='50px' nowrap='true'>
															<a id='excluir' name='excluir' title='Excluir o registro' href='javascript: excluirLinhaAparelhos("row<?=$I;?>","aparelhos")'><img border=0 src='../../images/btexcluirfaq.jpg' width=15 height=15></a>
														</td>																																										
													</tr>	
												<? 
													$li ++;
													}
												  mysql_free_result($result);
												}?>	
											</tbody>
											<tfoot>													
												<tr class="grid">
													<td align="right">Qtde Aparelho(s)</td>
													<td class="form" align="center"><label id='n_qtde_total_aparelhos'  style='text-align:right'><?=$v_total_qtde_aparelhos;?></label></td>
													<td class="form" align="center" colspan=3>&nbsp;</td>
													<td class="form" align="right" >Total Aparelho(s)</td>
													<td class="form" align="right"><label id='vl_total_aparelhos'  style='text-align:right'><?if(!empty($v_total_aparelhos)){echo number_format($v_total_aparelhos,2,",",".");}?></label></td>
													<td class="form" align="right" >&nbsp;</td>
												</tr>
											</tfoot>	
									    </table>
									</td>
								</tr>
								<tr>
									<td align='center'>
										<input type='button' value='Incluir Item' onclick='addAparelhos();' />
									</td>
								</tr>
								<tr>
									<td align='center' colspan=2>
										&nbsp;
									</td>
								</tr>
																
								<tr>
									<td colspan="2">
										&nbsp;
									</td>
								</tr>
							</table>
						</div>	
					</td>
				</tr>
				<tr>
					<td align='center' colspan=2>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan=2>						
						<table width='100%' border=0 none; cellpadding='1' cellspacing='1' >
							<tr style="border:1px solid black;">
								<td align="center">										
									<b>Total Proposta</b>	
								</td>
							</tr>
							<tr>	
								<td>
									<table width='80%' border='1' align="center" bordercolor="#CCCCCC" cellpadding='0' cellspacing='0' id='tbl1' name='tbl1'>
										<thead>
											<tr class='grid'>												
												<td width='80%' nowrap='true' align="right">
													Valor Total Plano(s) + Aparelho(s)&nbsp;
												</td>
												<td width='150px' nowrap='true'>
													<label id="v_total_proposta" name="v_total_proposta"><?=number_format($vl_total_proposta,2);?></label>
												</td>	
										</thead>
									</table>
								</td>
							</tr>			
						</table>												
					</td>			
				</tr>
				<tr>
					<td colspan="2">
						&nbsp;
					</td>
				</tr>						
				<tr>
					<td colspan=2>						
						<table width='100%' border=0 none; cellpadding='1' cellspacing='1' >
							<tr style="border:1px solid black;">
								<td align="center">										
									<b>Trade In</b>	
								</td>
							</tr>
							<tr>	
								<td>
									
									<table width='80%' border='1' align="center" bordercolor="#CCCCCC" cellpadding='0' cellspacing='0' id='tbl1' name='tbl1'>
										<thead>
											<tr class='grid'>												
												<td width='100%' nowrap='true' align="right">
													DESCONTO DE  <select name="trade_in">
																	<option value=""></option>
																    <option value="1" <?if($trade_in==1){echo "selected";}?>>1</option>
																	<option value="2" <?if($trade_in==2){echo "selected";}?>>2</option>
																	<option value="3" <?if($trade_in==3){echo "selected";}?>>3</option>
                                                                    <option value="4" <?if($trade_in==4){echo "selected";}?>>4</option>
                                                                    <option value="5" <?if($trade_in==5){echo "selected";}?>>5</option>
																</select>  MES(ES) &nbsp;
												</td>
													
										</thead>
									</table>
								</td>
							</tr>			
						</table>												
					</td>			
				</tr>
                               <tr>
					<td colspan="2">
						&nbsp;
					</td>
				</tr>
                <?
                //SOMENTE SE FOR CLARO
                if($operador_pk==1){
                ?>               
                    <tr>
                        <td colspan=2>						
                            <table width='100%' border=0 none; cellpadding='1' cellspacing='1' >
                                <tr style="border:1px solid black;">
                                    <td align="center">										
                                        <b>Desconto Claro</b>	
                                    </td>
                                </tr>
                                <tr>	
                                    <td>

                                        <table width='80%' border='1' align="center" bordercolor="#CCCCCC" cellpadding='0' cellspacing='0' id='tbl1' name='tbl1'>
                                            <thead>
                                                <tr class='grid'>												
                                                    <td width='100%' nowrap='true' align="right">
                                                       Valor desconto Claro R$ <input type="text" name="vl_desconto_claro" id="vl_desconto_claro" size="12" maxlength="12" value="<?=number_format($vl_desconto_claro,2);?>" onkeypress='mascara(this,Valor)'>
                                                       &nbsp;
                                                    </td>

                                            </thead>
                                        </table>
                                    </td>
                                </tr>			
                            </table>												
                        </td>			
                    </tr>
                <?}?>               
                <tr>
					<td colspan="2">
						&nbsp;
					</td>
				</tr>						
				<tr>
					<td colspan=2>						
						<table width='100%' border=0 none; cellpadding='1' cellspacing='1' >
							<tr style="border:1px solid black;">
								<td align="center">										
									<b>Dados da Ultima Conta</b>	
								</td>
							</tr>
							<tr>	
								<td>
									
									<table width='80%' border='1' align="center" bordercolor="#CCCCCC" cellpadding='0' cellspacing='0' id='tbl1' name='tbl1'>
										<thead>
											<tr class='grid'>												
												<td width='100%' nowrap='true' align="right">
                                                   Valor ultima conta *** Cliente R$ <input type="text" name="vl_ult_conta" id="vl_ult_conta" size="12" maxlength="12" value="<?=number_format($vl_ult_conta,2);?>" onkeypress='mascara(this,Valor)'>
                                                   &nbsp;
                                                </td>
													
										</thead>
									</table>
								</td>
							</tr>			
						</table>												
					</td>			
				</tr>
				<tr>
					<td colspan="2">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colsapn=2>
						<table width='100%' border=0 none; cellpadding='1' cellspacing='1' >
							<tr >
								<td align="center">										
										<!--<img border=0 src='../../images/calendario.png' width=50 height=50 title='Retirar Apaelhos' onclick='addItem(-5)' ><br>--><b>Datas Proposta</b>
								</td>
							</tr>
							<tr>
								<td>									
									<table width="80%"  border='1' bordercolor="#CCCCCC" align="center" cellpadding="0" cellspacing="0" >											
										<thead>
											<tr class="grid">
												<th width="130px" nowrap="true">
													Item
												</th>
												<th width="50px" nowrap="true">
													Data
												</th>
												<th width="200px" nowrap="true">
													Observção
												</th>								
												<!--<td width="30px" nowrap="true">
													Ação
												</td>-->
											</tr>
										</thead>
										<tbody id="tbl_datas_proposta">
										</tbody>
									</table>
										<?										
											//CONSTRUTOR DE DATAS
											$sql = "SELECT dpo.pk,
														   dpo.ds_data,
														   dpo.ds_label_data,
														   dpo.tipo_ocorrencia_pk,
														   dpo.statusclassificacaolead_pk";
											if(!empty($pk)){
													$sql .= " ,ndp.vl_obs_data
													,DATE_FORMAT(ndp.vl_data_proposta, '%d/%m/%Y') dt_processo ";
											}			   
											$sql .= "	  FROM n_data_proposta_operador dpo"; 
											if(!empty($pk)){
											 $sql .= " left join n_datas_proposta ndp on ndp.data_proposta_operador_pk = dpo.pk and ndp.propostas_pk=".$pk;	
											}			        
											$sql .= "  WHERE dpo.operador_pk = ".$operador_pk;
											$sql .= " 	  and dpo.ic_tipo is null";
											$sql .= " AND dpo.dt_cancelamento is null
													  group by dpo.pk	
													  ORDER BY dpo.n_ordem";
											$result = sql_query($sql);
											while($row = mysql_fetch_array($result)){																																	
												if(permissao($row['ds_label_data'], 'al')){	
                                                    if(!empty($row['dt_processo'])){
                                                        $date = $row['dt_processo'];
                                                    }else{
                                                        if($row['ds_label_data']=='envio_lead'){
                                                            $date = date ("d/m/Y");
                                                        }  else {
                                                            $date = "";
                                                        } 
                                                    }
													echo "<script>incluirdatasProposta('".$row['ds_data']."','".$row['pk']."','".$date."','".$row['tipo_ocorrencia_pk']."','".$row['statusclassificacaolead_pk']."','".$row['vl_obs_data']."')</script>";										
												    echo "<input type='hidden' name='ds_data_".$row['pk']."' id='ds_data_".$row['pk']."' value='".$row['ds_label_data']."'>";
												}
											}	
											mysql_free_result($result);
										?>
									
								</td>
							</tr>
						</table>	
					</td>
				</tr>
				<tr>
					<td colsapn=2>
						&nbsp;
					</td>
				</tr>                                                       
                <tr>
					<td colsapn=2>
						<table width='100%' border=0 none; cellpadding='1' cellspacing='1' >
				</tr>
                <tr>               
					<td colsapn=2>
						&nbsp;
					</td>
				</tr>                   
				<tr>
					<td colsapn=2>
						<table width='100%' border=0 none; cellpadding='1' cellspacing='1' >
							<tr>
								<td align="center">										
                                    <b>Validade da Proposta</b>
								</td>
							</tr>
							<tr>
								<td>									
									<table width="80%"  border='1' bordercolor="#CCCCCC" align="center" cellpadding="0" cellspacing="0" >											
										<thead>
											<tr>
												<td width="30%" >
													&nbsp;Data de validade proposta
												</td>
												<td>
													&nbsp;<input class="input" id="dt_validade" name="dt_validade" size="12" maxlength="10" onkeypress="mascara(this,datamask)" value="<?=$dt_validade;?>" validate="datatype=date" />
												</td>
											</tr>
										</thead>
									</table>
								</td>
							</tr>			
						</table>
					</td>
				</tr>
				<tr>
					<td colsapn=2>
						&nbsp;
					</td>
				</tr>
				<tr>
					<th colspan="2" class="grid"><label for="observacao">Observações:</label></th>
				</tr>
				<tr valign="top">
					<td colspan="2" align="center">
						<textarea id="ds_obs_proposta" name="ds_obs_proposta" style="width:98%" rows="15" ><?=$ds_obs_proposta;?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						&nbsp;
					</td>
				</tr>				
				<tr>
					<td colspan="2" align="center" >
					    <?if(!empty($pk)){?>
                            <?if ($dt_cancelamento=="" AND $dt_validade >= date('d/m/y')){?>
                                <input type='button' name='cmdEnviar' id='cmdEnviar' value="Enviar" onclick="enviar();" />
                            <?}?>
                        <?}else{?> 
                            <input type='button' name='cmdEnviar' id='cmdEnviar' value="Enviar" onclick="enviar();" />    
                        <?}?>        
                                
						<?if(empty($agendalead_pk)){?>
							<input type="button" name="cmdFechar" id='cmdFechar' value="Fechar" onclick="self.close()" />
						<?}?>
                        
					</td>
				</tr>
				<tr>
					<td colspan="2">
						&nbsp;
					</td>
				</tr>								
			</table>			
		</form>
	</body>
</html>
<?include_once "../../libs/desconectar.php";?>
