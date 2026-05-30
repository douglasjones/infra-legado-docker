<?
include_once "../../libs/maininclude.php";
include_once "produtos_cla.php";
include_once "../../libs/combo.php";
	
$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];



if(!empty($pk)){
	
	$produtos = new produtos($pk);

	$pk = $produtos->getpk();
	$produtos_tipo_pk = $produtos->getprodutos_tipo_pk();
	$operador_pk = $produtos->getoperador_pk();
	$ds_produto = $produtos->getds_produto();
	$dt_cancelamento = $produtos->getdt_cancelamento();
	$vl_vc1_local = $produtos->getvl_vc1_local();
	$dsc_vc1_local = $produtos->getdsc_vc1_local();
	$visualiza_vc1_local = $produtos->getvisualiza_vc1_local();
	$vl_vc1_Estad = $produtos->getvl_vc1_Estad();
	$dsc_vc1_Estad = $produtos->getdsc_vc1_Estad();
	$visualiza_vc1_Estad = $produtos->getvisualiza_vc1_Estad();
	$vl_vc1_Nac = $produtos->getvl_vc1_Nac();
	$dsc_vc1_Nac = $produtos->getdsc_vc1_Nac();
	$visualiza_vc1_Nac = $produtos->getvisualiza_vc1_Nac();
	$vl_vc2_local = $produtos->getvl_vc2_local();
	$dsc_vc2_local = $produtos->getdsc_vc2_local();
	$visualiza_vc2_local = $produtos->getvisualiza_vc2_local();
	$vl_vc2_Estad = $produtos->getvl_vc2_Estad();
	$dsc_vc2_Estad = $produtos->getdsc_vc2_Estad();
	$visualiza_vc2_Estad = $produtos->getvisualiza_vc2_Estad();
	$vl_vc2_Nac = $produtos->getvl_vc2_Nac();
	$dsc_vc2_Nac = $produtos->getdsc_vc2_Nac();
	$visualiza_vc2_Nac = $produtos->getvisualiza_vc2_Nac();
	$vl_vc3_local = $produtos->getvl_vc3_local();
	$dsc_vc3_local = $produtos->getdsc_vc3_local();
	$visualiza_vc3_local = $produtos->getvisualiza_vc3_local();
	$vl_vc3_Estad = $produtos->getvl_vc3_Estad();
	$dsc_vc3_Estad = $produtos->getdsc_vc3_Estad();
	$visualiza_vc3_Estad = $produtos->getvisualiza_vc3_Estad();
	$vl_vc3_Nac = $produtos->getvl_vc3_Nac();
	$dsc_vc3_Nac = $produtos->getdsc_vc3_Nac();
	$visualiza_vc3_Nac = $produtos->getvisualiza_vc3_Nac();    
	$total_minutos = $produtos->gettotal_minutos(); 
    $total_internet = $produtos->gettotal_internet();
	$tipo_dados = $produtos->gettipo_dados();
	$produto_book_pk = $produtos->getproduto_book_pk();
	$n_produtos_beneficio = $produtos->getn_produtos_beneficio();
}
if(!empty($operador_pk)){
    $cod_operador=$operador_pk; 
}else{
    $cod_operador=$operador_pk;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<!--Cabeçalho-->
	<title>Produtos</title>	
	<!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="JavaScript" src="produtos_cad_form.js"></script>
	<link rel="stylesheet" href="../../extras/lytebox.css" type="text/css" media="screen" />
    <script type="text/javascript" language="javascript" src="../../extras/lytebox.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar(<?=$produtos_tipo_pk;?>)">
<form name="dados" method="post" action="produtos_cad_proc.php">
<input type='hidden' name='acao' id='acao' value='' />
<input type='hidden' name='pk' value='<?=$pk;?>' />
<input type='hidden' name='valores_produto' value='' />

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		<td  class="titulo">
			 PRODUTOS
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
        <td>
            <label>Operadora:</label>
        </td>
        <td>
            <?	
                $sql ="Select 
							o.cod_operador
							,o.dsc_operador
						from operador o
						inner join empresa_operador ep on o.cod_operador = ep.cod_operador
						group by o.dsc_operador
						order by o.dsc_operador";
               combo($sql, "operador_pk", $operador_pk, " ","onchange='sl_book(this.value);'");
            ?>                       
        </td>
    </tr>
    <tr>
        <td>
            <label>Book</label>
        </td>
        <td>
            <label name="combo_book" id="combo_book" >
                <?
                    if(!empty($produto_book_pk)){
                        $sql ="";
                        $sql.="SELECT pk produto_book_pk,n_dsc_book
                               from n_produtos_book";
                        $sql.=" WHERE operador_pk=".$cod_operador;
                        combo($sql, "produto_book_pk", $produto_book_pk, " ", "  ");
                    }
                ?>                                    
            </label>
        </td>
    </tr>
	<tr>
		<td  width="25%">
			Tipo Produto: 
		</td>
		<td>
			<? $sql =  "Select 
							pt.pk
							,pt.ds_tipo_produto
						from n_produtos_tipo pt	
						where pt.pk not in (2) 					
						order by pt.pk";
				combo($sql,"produtos_tipo_pk", $produtos_tipo_pk, " ", 'onchange="tipo_produto(this.value)"');
			 ?>
		</td>
	</tr>	
	<tr>
		<td  width="25%">
			Nome: 
		</td>
		<td>
			<input type='text' id='ds_produto' size=40 maxlength=50 name='ds_produto' value="<?=$ds_produto;?>" />
		</td>
	</tr>
        <tr>
            <td widht="25%">
                Total Minutos:
            </td>
            <td>
                <input type='text' id='total_minutos' size=15 maxlength=10 name='total_minutos' value="<?=$total_minutos;?>" onKeypress='mascara(this,soNumeros)'/>
            </td>
        </tr>
        <tr>
            <td widht="25%">
                Total Internet:
            </td>
            <td>
                <input type='text' id='total_internet' size=5 maxlength=10 name='total_internet' value="<?=$total_internet;?>" onKeypress='mascara(this,soNumeros)'/> 
                Dados: 
                <select name='tipo_dados'>		
					<option value="1" <?if(!empty($tipo_dados)){ echo "selected";}?>> </option>
					<option value="2" <?if(!empty($tipo_dados)){ echo "selected";}?>>MB</option>
					<option value="3" <?if(!empty($tipo_dados)){ echo "selected";}?>>GB</option>
				</select>
            </td>
        </tr>
    <tr>
        <td width="25%">
            Beneficio do Plano:
        </td>
        <td>
            <textarea id="n_produtos_beneficio" name="n_produtos_beneficio" style="width:98%" rows="15" ><?=$n_produtos_beneficio;?></textarea>
        </td>
    </tr>
	<tr>
		<td colspan=2>
			<table width="100%"  border='0' bgcolor="#cccccc" align="center" cellpadding="1" cellspacing="1" class="form">
				<thead>
					<tr>
						<td align=center>
							<b>Adicionar Valor Produto</b>
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
                                        <td>
                                            Tipo de Valor:
                                        </td>
                                        <td colspan="3">
                                            <input type="radio" name="tipo_valor_pk" id="tipo_valor_pk" value='1' onclick="alt_valor(this.value)"> Valor Fechado &nbsp;
                                            <input type="radio" name="tipo_valor_pk" id="tipo_valor_pk" value='2' onclick="alt_valor(this.value)"> Valor Aberto 

                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%">
                                                Valor:	
                                        </td>
                                        <td width="20%">
                                                R$<input type='text' id='vl_produto' size=12 maxlength=12 name='vl_produto'  style="text-align:right" onkeypress='mascara(this,Valor)'/>	
                                        </td>
                                        <td>
                                                Tipo:	
                                        </td>
                                        <td>
                                            <select name="tipo_pk" id="tipo_pk">
                                                <option value=""></option>
                                                <option value="1">Chip</option>
                                                <option value="2">Aparelho</option>
                                            </select>
                                        </td>

                                    </tr>
                                        <tr>
						
                                              
                                                    
					</tr>
					<tr>
						<td colspan=4 align="center">
							<img border=0 src='../../images/adicionar.png' width=20 height=20 title="Adicionar Valor Produto"  onclick='add_valor_produto();'>
						</td>
					</tr>
									
				</thead>
				<tr>
					<td colspan=4>
						<table width="100%"  border='0'  align="center" cellpadding="1" cellspacing="1" class="form" id="tbl" name="tbl">
							<thead>
								<tr bgcolor="#cccccc" >
									<th  nowrap="true">
										<b>Valor</b>
									</th>
                                                                        <th  nowrap="true">
										<b>Tipo</b>
									</th>
									<th width="50px"  align="center">
										<b>Ação</b>
									</th>
								</tr>
							</thead>
							<tbody id="tbl_valor_produto">
								<?if(!empty($pk)){
									$sql ="Select
                                                                                npv.pk,
                                                                                npv.vl_produto,
                                                                                npv.tipo_pk
                                                                        from n_produtos_valores npv
                                                                        where npv.produtos_pk=".$pk;
									$sql.=" order by npv.vl_produto";
									$result = sql_query($sql);
									$I = "0";											
									while($row = mysql_fetch_array($result)){
                                                                                $dsc_tipo = "&nbsp";
                                                                                if($row['tipo_pk']==1){
                                                                                    $dsc_tipo = 'Chip';
                                                                                }elseif($row['tipo_pk']==2){
                                                                                    $dsc_tipo = 'Aparelho';
                                                                                } 
										echo "<tr id='row$I'>";
										echo "	<td align='center' width='200px' nowrap='true'>";
										echo "		<label class='form' name='vl_produto' >".number_format($row['vl_produto'],2,",",".")."</label>";																		
										echo "	</td>";	
                                                                                echo "	<td align='center' width='200px' nowrap='true'>";                                                                               
										echo "		<input type='hidden' name='tipo_pk' id='tipo_pk' value='".$row['tipo_pk']."'>".$dsc_tipo;                                                                                
										echo "	</td>";	
										echo "	<td align='center' width='70px' nowrap='true'>";	
										echo "<a title='Excluir Item' href='javascript:delete_linhavalor_produto(".'"row'.$I.'"'.")'><img border='0' width='15' height='15' src='../../images/btexcluirfaq.jpg'></a>\n";
										echo "	</td>";	
										echo "</tr>";		
										$I ++;
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
	<tr>
		<td colspan=2>
			<div id="dv_vcs" style="display: none;">				
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
							VC1 Nome: <input type='text' id='dsc_vc2_local' size=15 maxlength=20 name='dsc_vc2_local' value="<?=$dsc_vc2_local;?>" />
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
							VC1 Nome: <input type='text' id='dsc_vc3_local' size=15 maxlength=20 name='dsc_vc3_local' value="<?=$dsc_vc3_local;?>" />
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
							VC2 Nome: <input type='text' id='dsc_vc1_Estad' size=15 maxlength=20 name='dsc_vc1_Estad' value="<?=$dsc_vc1_Estad;?>" />
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
							VC2 Nome: <input type='text' id='dsc_vc3_Estad' size=15 maxlength=20 name='dsc_vc3_Estad' value="<?=$dsc_vc3_Estad;?>" />
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
							VC3 Nome: <input type='text' id='dsc_vc1_Nac' size=15 maxlength=20 name='dsc_vc1_Nac' value="<?=$dsc_vc1_Nac;?>" />
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
							VC3 Nome: <input type='text' id='dsc_vc2_Nac' size=15 maxlength=20 name='dsc_vc2_Nac' value="<?=$dsc_vc2_Nac;?>" />
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
			</div>
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
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
