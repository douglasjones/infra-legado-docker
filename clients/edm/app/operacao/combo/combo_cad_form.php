<?
include_once "../../libs/maininclude.php";
include_once "combo_cla.php";
include_once "../../libs/combo.php";
	
$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];



if(!empty($pk)){
	
	$combos = new combos($pk);
	
	$pk = $combos->getpk();	
	$operador_pk = $combos->getoperador_pk();
	$ds_combo = $combos->getds_combo();
	$dt_cancelamento = $combos->getdt_cancelamento();
	$vl_combo = $combos->getvl_combo();
	$n_vigencia_contrato = $combos->getn_vigencia_contrato();
	

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<!--Cabeçalho-->
	<title>Combos</title>	
	<!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="JavaScript" src="combo_cad_form.js"></script>
	<link rel="stylesheet" href="../../extras/lytebox.css" type="text/css" media="screen" />
    <script type="text/javascript" language="javascript" src="../../extras/lytebox.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar(<?=$produtos_tipo_pk;?>)">
<form name="dados" method="post" action="combo_cad_proc.php">
<input type='hidden' name='acao' id='acao' value='' />
<input type='hidden' name='pk' value='<?=$pk;?>' />
<input type='hidden' name='valores_produto' value='' />
<input type='hidden' name='itens_produtos_combo' value='' />

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		<td  class="titulo">
			 COMBOS
		</td>
	</tr>
</table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="1" cellspacing="1" class="form">
	<tr>
		<td colspan="2">
			 
		</td>
	</tr>
	<?if(!empty($pk)){?>
		<tr>
			<td>
				Status:
			</td>
			<td>				
				<select name='dt_cancelamento'>		
					<option value="1" <?if(empty($dt_cancelamento)){ echo "selected";}?>>Ativo</option>
					<option value="2" <?if(!empty($dt_cancelamento)){ echo "selected";}?>>Desativado</option>				
				</select>
			</td>
		</tr>
	<?}else{
		echo "<input type='hidden'  name='status_pk' id='status_pk' value='1'>";
	  }
	 ?>
	<tr>
		<td  width="25%">
			Operadora: 
		</td>
		<td>
			<? $sql =  "Select 
							o.cod_operador
							,o.dsc_operador
						from operador o
						inner join empresa_operador ep on o.cod_operador = ep.cod_operador
						group by o.dsc_operador
						order by o.dsc_operador";
				combo($sql,"operador_pk", $operador_pk, " ", " ");
			 ?>
		</td>
	</tr>
	<tr>
		<td  width="25%">
			Nome: 
		</td>
		<td>
			<input type='text' id='ds_combo' size=40 maxlength=50 name='ds_combo' value="<?=$ds_combo;?>" />
		</td>
	</tr>
	<tr>
		<td>
			Valor:	
		</td>
		<td>
			R$<input type='text' id='vl_combo' size=12 maxlength=12 name='vl_combo' value="<?=number_format($vl_combo,2,",",".");?>"  style="text-align:right" onkeypress='mascara(this,Valor)'/>	
		</td>
	</tr>
	<tr>
		<td>
			Vigência Contrato:	
		</td>
		<td>
			<input type='text' id='n_vigencia_contrato' size=5 maxlength=8 name='n_vigencia_contrato' value="<?=$n_vigencia_contrato;?>"  style="text-align:right" onKeypress='mascara(this,soNumeros)'/> Meses	
		</td>
	</tr>			
	<tr>
		<td colspan=2>
			<table width="100%"  border='0' bgcolor="#cccccc" align="center" cellpadding="1" cellspacing="1" class="form">
				<thead>
					<tr>
						<td align=center>
							<b>Adicionar Produto</b>
						</td>
					</tr>					
				</thead>		
			</table>	
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<table width="100%"  border='0'  align="center" cellpadding="1" cellspacing="1" class="form">
				<thead>
					<tr>
						<td width=25%>
							Tipo Produtos:	
						</td>
						<td>
							<? $sql =  "Select 
											pt.pk
											,pt.ds_tipo_produto
										from n_produtos_tipo pt
										where pt.pk not in (2)						
										order by pt.pk";
								combo($sql,"combo_produto_tipo_pk", $produto_tipo_pk, " ", 'onchange="reload_combo(this.value)"');
							 ?>	
						</td>
					</tr>
					<tr>
						<td  width="25%">
							Produto: 
						</td>
						<td>
							<div id="div_produto_combo">
								<?if(!empty($pk)){
									$sql ="Select
												npv.pk,
												npv.vl_produto
											from n_produtos_valores npv
											where npv.produtos_pk=".$pk;
									$sql.=" order by npv.vl_produto";
									$result = sql_query($sql);
									$I = "0";											
									while($row = mysql_fetch_array($result)){
										echo "<tr>";
										echo "	<td align='center' width='200px' nowrap='true'>";
										echo "		<label class='form' name='vl_produto' >".number_format($row['vl_produto'],2,",",".")."</label>";																		
										echo "	</td>";				
										echo "	<td align='center' width='70px' nowrap='true'>";	
										echo "<a title='Excluir Item' href='javascript:delete_linhavalor_produto(".'"row'.$I.'"'.")'><img border='0' width='15' height='15' src='../../images/btexcluirfaq.jpg'></a>\n";
										echo "	</td>";	
										echo "</tr>";		
										$I ++;
									}
								mysql_free_result($result);
								}?>	
							</div>
						</td>
					</tr>	
					<tr>
						<td colspan=2 align="center">
							<img border=0 src='../../images/adicionar.png' width=20 height=20 title="Adicionar Valor Produto"  onclick='add_produto();'>
						</td>
					</tr>
									
				</thead>
				<tr>
					<td colspan=2>
						<table width="100%"  border='0'  align="center" cellpadding="1" cellspacing="1" class="form" id="tbl" name="tbl">
							<thead>
								<tr class="grid">
									<th width="50px" nowrap="true">
										Tipo
									</th>
									<th width="100px" nowrap="true">
										Produto
									</th>
									<!--<th width="50px" nowrap="true">
										Valor
									</th>-->
									<th width="50px" nowrap="true">
										Ação
									</th>
								</tr>
							</thead>
							<tbody id="tbl_produtos">
								<?if(!empty($pk)){
									//lista todos os registros dos itens cadastrados.
									$sql ="";
									$sql.="Select
												nic.pk,
												np.ds_produto,
												npt.ds_tipo_produto,
												nic.produtos_pk
											from n_itens_combo nic
												inner join n_produtos np on nic.produtos_pk = np.pk
												inner join n_produtos_tipo npt on np.produtos_tipo_pk = npt.pk
											where nic.combos_pk=".$pk;                                    
									
									$result = mysql_query($sql);									
									$I=0;
									
									while($row = mysql_fetch_array($result)){
										echo "<tr id='row$I'>";
										echo "<td class='form' align='center'><input type='hidden'  name='produto_combo_pk' id='produto_combo_pk' value='".$row['produtos_pk']."'><input type='hidden'  name='combo_pk' id='combo_pk' value='".$row['combos_pk']."'>".$row['ds_tipo_produto']."</td>\n";
										echo "<td class='form' align='center'>".$row['ds_produto']."</td>\n";
										echo "<td align='center'>";
										echo "<a title='Excluir Item' href='javascript:excluirLinha(".'"row'.$I.'"'.")'><img border='0' width='15' height='15' src='../../images/btexcluirfaq.jpg'></a>\n";
										echo "</td>\n";
										echo "</tr>\n";
										$I++;
									}									
									mysql_free_result($result);
								}?>	
							</tbody>			
						</table>
					</td>
				</tr>
								
			</table>	
		</td>
	</tr>			
	<tr>
		<td colspan=2>
			&nbsp;
		</td>
	</tr>
	<!--<tr>
		<td colspan=2>			
				<table width="100%" border="0" cellpadding="1" cellspacing="1" >
					<tr bgcolor="#cccccc">
						<td  colspan=3 align="center">
							<b>Tarifas Locais</b>
						</td>
					</tr>
					<tr>
						<td>
							VC1 Nome: <input type='text' id='dsc_vc1_local' size=15 maxlength=20 name='dsc_vc1_local' value="<?=$dsc_vc1_local;?>" />
						</td>
						<td>
							R$ <input type='text' id='vl_vc1_local' size=12 maxlength=12 name='vl_vc1_local' value="<?=number_format($vl_vc1_local,2,",",".");?>" style="text-align:right" onkeypress='mascara(this,Valor)'/>	
						</td>
						<td>
							Visível na Proposta <input type='checkbox' <?if(!empty($visualiza_vc1_local)){echo "checked";}?>  name="visualiza_vc1_local" id="visualiza_vc1_local">
						</td>
					</tr>		
					<tr>
						<td>
							VC2 Nome: <input type='text' id='dsc_vc2_local' size=15 maxlength=20 name='dsc_vc2_local' value="<?=$dsc_vc2_local;?>" />
						</td>
						<td>
							R$ <input type='text' id='vl_vc2_local' size=12 maxlength=12 name='vl_vc2_local' value="<?=number_format($vl_vc2_local,2,",",".");?>" style="text-align:right" onkeypress='mascara(this,Valor)'/>
						</td>
						<td>
							Visível na Proposta <input type='checkbox' <?if(!empty($visualiza_vc2_local)){echo "checked";}?>  name="visualiza_vc2_local" id="visualiza_vc2_local">
						</td>
					</tr>
					<tr>
						<td>
							VC3 Nome: <input type='text' id='dsc_vc3_local' size=15 maxlength=20 name='dsc_vc3_local' value="<?=$dsc_vc3_local;?>" />
						</td>
						<td>
							R$ <input type='text' id='vl_vc3_local' size=12 maxlength=12 name='vl_vc3_local' value="<?=number_format($vl_vc3_local,2,",",".");?>" style="text-align:right" onkeypress='mascara(this,Valor)'/>
						</td>
						<td>
							Visível na Proposta <input type='checkbox' <?if(!empty($visualiza_vc3_local)){echo "checked";}?>  name="visualiza_vc3_local" id="visualiza_vc3_local">
						</td>
					</tr>
				</table>
				<table width="100%" border="0" cellpadding="1" cellspacing="1" >
					<tr bgcolor="#cccccc">
						<td  colspan=3 align="center">
							<b>Tarifas Longas Distâncias Estaduais</b>
						</td>
					</tr>
					<tr>
						<td>
							VC1 Nome: <input type='text' id='dsc_vc1_Estad' size=15 maxlength=20 name='dsc_vc1_Estad' value="<?=$dsc_vc1_Estad;?>" />
						</td>
						<td>
							R$ <input type='text' id='vl_vc1_Estad' size=12 maxlength=12 name='vl_vc1_Estad' value="<?=number_format($vl_vc1_Estad,2,",",".");?>" style="text-align:right" onkeypress='mascara(this,Valor)'/>	
						</td>
						<td>
							Visível na Proposta <input type='checkbox' <?if(!empty($visualiza_vc1_Estad)){echo "checked";}?>  name="visualiza_vc1_Estad" id="visualiza_vc1_Estad">
						</td>
					</tr>		
					<tr>
						<td>
							VC2 Nome: <input type='text' id='dsc_vc2_Estad' size=15 maxlength=20 name='dsc_vc2_Estad' value="<?=$dsc_vc2_Estad;?>" />
						</td>
						<td>
							R$ <input type='text' id='vl_vc2_Estad' size=12 maxlength=12 name='vl_vc2_Estad' value="<?=number_format($vl_vc2_Estadl,2,",",".");?>" style="text-align:right" onkeypress='mascara(this,Valor)'/>
						</td>
						<td>
							Visível na Proposta <input type='checkbox'<?if(!empty($visualiza_vc2_Estad)){echo "checked";}?>  name="visualiza_vc2_Estad" id="visualiza_vc2_Estad">
						</td>
					</tr>
					<tr>
						<td>
							VC3 Nome: <input type='text' id='dsc_vc3_Estad' size=15 maxlength=20 name='dsc_vc3_Estad' value="<?=$dsc_vc3_Estad;?>" />
						</td>
						<td>
							R$ <input type='text' id='vl_vc3_Estad' size=12 maxlength=12 name='vl_vc3_Estad' value="<?=number_format($vl_vc3_Estad,2,",",".");?>" style="text-align:right" onkeypress='mascara(this,Valor)'/>
						</td>
						<td>
							Visível na Proposta <input type='checkbox' <?if(!empty($visualiza_vc3_Estad)){echo "checked";}?>  name="visualiza_vc3_Estad" id="visualiza_vc3_Estad">
						</td>
					</tr>
				</table>
				<table width="100%" border="0" cellpadding="1" cellspacing="1" >
					<tr bgcolor="#cccccc">
						<td  colspan=3 align="center">
							<b>Tarifas Longas Distâncias Nacionais</b>
						</td>
					</tr>
					
						<td>
							VC1 Nome: <input type='text' id='dsc_vc1_Nac' size=15 maxlength=20 name='dsc_vc1_Nac' value="<?=$dsc_vc1_Nac;?>" />
						</td>
						<td>
							R$ <input type='text' id='vl_vc1_Nac' size=12 maxlength=12 name='vl_vc1_Nac' value="<?=number_format($vl_vc1_Nac,2,",",".");?>" style="text-align:right" onkeypress='mascara(this,Valor)'/>	
						</td>
						<td>
							Visível na Proposta <input type='checkbox' <?if(!empty($visualiza_vc1_Nac)){echo "checked";}?> name="visualiza_vc1_Nac" id="visualiza_vc1_Nac">
						</td>
					</tr>		
					<tr>
						<td>
							VC2 Nome: <input type='text' id='dsc_vc2_Nac' size=15 maxlength=20 name='dsc_vc2_Nac' value="<?=$dsc_vc2_Nac;?>" />
						</td>
						<td>
							R$ <input type='text' id='vl_vc2_Nac' size=12 maxlength=12 name='vl_vc2_Nac' value="<?=number_format($vl_vc2_Nacl,2,",",".");?>" style="text-align:right" onkeypress='mascara(this,Valor)'/>
						</td>
						<td>
							Visível na Proposta <input type='checkbox' <?if(!empty($visualiza_vc2_Nac)){echo "checked";}?>  name="visualiza_vc2_Nac" id="visualiza_vc2_Nac">
						</td>
					</tr>
					<tr>
						<td>
							VC3 Nome: <input type='text' id='dsc_vc3_Nac' size=15 maxlength=20 name='dsc_vc3_Nac' value="<?=$dsc_vc3_Nac;?>" />
						</td>
						<td>
							R$ <input type='text' id='vl_vc3_Nac' size=12 maxlength=12 name='vl_vc3_Nac' value="<?=number_format($vl_vc3_Nac,2,",",".");?>" style="text-align:right" onkeypress='mascara(this,Valor)'/>
						</td>
						<td>
							Visível na Proposta <input type='checkbox' <?if(!empty($visualiza_vc3_Nac)){echo "checked";}?> name="visualiza_vc3_Nac"  id="visualiza_vc3_Nac">
						</td>
					</tr>
					<tr>
						<td colspan=3>
							&nbsp;
						</td>
					</tr>	
				</table>
		</td>	
	</tr>-->
			
	<tr>
		<td colspan="2" align="center" >
			<?
			if($pk != ''){
				?>
				<!--<input type='button' name="cmdExcluir" id='cmdExcluir' value='Excluir' onclick="excluir()" />-->
				 
				<?
			}
			?>		
			<input type='button' name='cmdEnviar' id='cmdEnviar' value="Enviar" onclick="enviar();" />
			 
			<input type="button" name="cmdFechar" id='cmdFechar' value="Fechar" onclick="self.close()" />
		</td>
	</tr>							
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
