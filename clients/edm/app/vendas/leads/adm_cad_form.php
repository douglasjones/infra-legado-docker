<?
include_once "../../libs/maininclude.php";
include_once "propostas_cla.php";
include_once "../../libs/combo.php";


	
$acao = $_REQUEST['acao'];
$leads_pk = $_REQUEST['codlead'];
$pk = $_REQUEST['pk'];
$operador_pk = $_REQUEST['operador_pk'];

if(!empty($pk)){
	$propostas = new propostas($pk);
	$pk = $propostas->getpk();
	$leads_pk = $propostas->getleads_pk();
	$n_pedido = $propostas->getn_pedido();	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<!--Cabeçalho-->
		<title>Processo ADM</title>	
		<!--Include CSS-->
		<link rel="stylesheet" href="../../extras/public.css" type="text/css">
		<link rel="stylesheet" href="../../extras/lytebox.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
		<?	include_once "../../libs/head.php";?>		
		<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
		<script type="text/javascript" language="JavaScript" src="propostas_cad_form.js"></script>
		<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>
		<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
		
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
		<form name="dados" method="post" action="propostas_cad_proc.php">
			<input type='hidden' name='acao' id='acao' value='' />
			<input type='hidden' name='pk' value='<?=$pk;?>' />	
			<input type='hidden' name='operador_pk' value='<?=$operador_pk;?>' />
			<input type="hidden" name="leads_pk" id="leads_pk" value="<?=$leads_pk;?>" />		
			<input type="hidden" name="nomeusuario" id="nomeusuario" value="<?=$_SESSION['nomeusuario'];?>" />
			<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
				
				<tr>
					<td  class="titulo">
						 <font color="ffffff">Processo ADM</font>
					</td>
				</tr>
			</table>
			<table width="100%"  align="center" border="0" cellpadding="1" cellspacing="0" class="form">
			
				<tr>
					<td colspan=2>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan=2>
						<table width='100%' border=0 none; cellpadding='1' cellspacing='1' >
							<!--<tr >
								<td align="center">										
										<img border=0 src='../../images/processo.png' width=60 height=55 title='Retirar Apaelhos' onclick='addItem(-5)' ><br>Processo Proposta
								</td>
							</tr>-->							
							<tr>
								<td>									
									<table width="100%"  border='0' bordercolor="#CCCCCC" align="center" cellpadding="0" cellspacing="0" >											
										<?if(permissao($row['processo_data_bko'], 'ic')){?>
											<thead>
												<tr >
													<td width="20%">
														Processo Operadora:
													</td>
													<td>
														<?$sql = "SELECT dpo.pk,
															   dpo.ds_data														   
														  FROM n_data_proposta_operador dpo       
														  WHERE dpo.operador_pk = 1
														  and dpo.ic_tipo=1";
														  $sql .= " AND dpo.dt_cancelamento is null
														  ORDER BY dpo.n_ordem";
														   
														// combo($sql,"data_proposta_operadora_pk", "", "", "");													  
														 ?>
														 <select>
															<option value="1">1</option>
															<option value="2" disabled>2</option>
														 </select>
													</td>	
												</tr>
												<tr >
													<td >
														Data Processo:
													</td>
													<td>
														<input class="input" id="dt_processo" name="dt_processo" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
													</td>	
												</tr>
												<tr >
													<td >
														Descrição:
													</td>
													<td>
														<textarea id="ds_data_processo" name="ds_data_processo" style="width:50%" rows="5" cols="20"></textarea>
													</td>	
												</tr>
												<tr>
													<td colspan=2>
														&nbsp;
													</td>
												</tr>
												<tr >
													<td colspan=2 align="center">
														<input type='button' value='Incluir Item' onclick='carrega_ProcessoOperadora();' />
													</td>												
												</tr>
											</thead>									
										<?}?>	
									</table>	
								</td>
							</tr>					
							<tr>
								<td colspan=2>
									<table width="100%"  border='1' bordercolor="#CCCCCC" align="center" cellpadding="0" cellspacing="0" >									
										<tr class="grid">
											<th width="200px" nowrap="true">
												Item
											</th>
											<th  nowrap="true">
												Dt Processo
											</th>
											<th  nowrap="true">
												Observação
											</th>	
											<th  nowrap="true">
												User Cadastro
											</th>	
											<th  nowrap="true">
												Dt Cadastro
											</th>							
											<td width="30px" nowrap="true">
												Ação
											</td>
										</tr>										
										<tbody id="tbl_processo_datas_proposta">
											<?if(!empty($pk)){
												$sql ="Select
															ndp.pk,
															ndp.vl_data_proposta, 
															ndp.vl_obs_data,
															ndp.data_proposta_operador_pk,
															ndpo.ds_data,
															DATE_FORMAT(ndp.vl_data_proposta, '%d/%m/%Y') vl_data,
															ui.nome,
															DATE_FORMAT(ndp.dt_cadastro, '%d/%m/%Y') dtcadasro 
														from n_datas_proposta ndp
															inner join n_data_proposta_operador ndpo on ndp.data_proposta_operador_pk = ndpo.pk
															inner join usuariosinternos ui on ndp.usuario_cadastro_pk = ui.CodUsuarioInterno
														where  ic_tipo is null
														and ndp.propostas_pk=".$pk;
												
												$result = sql_query($sql);											
												while($row = mysql_fetch_array($result)){		
											?>
												<tr>
													<td align="center" width="200px" nowrap="true">
														<input type='hidden' name='ds_data' id='ds_data' value='<?=$row['data_proposta_operador_pk'];?>'><label class='form' name='dt_processo_proposta' ><?=$row['ds_data'];?></label>																		
													</td>
													<td align="center" nowrap="true">
														<label class='form' name='dt_processo_proposta' ><?=$row['vl_data'];?></label>
													</td>
													<td align="center" nowrap="true">
														<textarea style='width: 100%' name='dsc_data' id='dsc_data' disabled='disabled'><?=$row['vl_obs_data'];?></textarea>
													</td>	
													<td align="center" nowrap="true">
														<label class='form' name="usuario_cadastro_pk"><?=$row['nome'];?></label>
													</td>	
													<td align="center" nowrap="true">
														<label class='form' name="usuario_cadastro_pk"><?=$row['dtcadasro'];?></label>
													</td>							
													<td align="center" width="30px" nowrap="true">
														<input type='hidden' name='' id='' value='"+arrCampos[0]+"'><a id='excluir' name='excluir' title='Excluir o registro' href='javascript: excluirLinha("+'"'+ row.id +'"'+")'><img border=0 src='../../images/btexcluirfaq.jpg' width=15 height=15></a>
													</td>
												</tr>	
											<?}
											
											}?>	
										</tbody>
									</table>									
								</td>
							</tr>
		
							
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
