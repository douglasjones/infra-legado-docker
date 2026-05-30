<?
include_once "../../libs/maininclude.php";
include_once "produtos_cla.php";
include_once "../../libs/combo.php";
	
$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];

if(!empty($pk)){
	
	$produtos = new produtos($pk);
	$pk = $produtos->getpk();
	$dt_cadastro = $produtos->getdt_cadastro();
	$usuario_cadastro_nome_pk = $produtos->getusuario_cadastro_nome_pk();
	$dt_ult_atualizacao = $produtos->getdt_ult_atualizacao();
	$usuario_ult_atualizacao_nome_pk = $produtos->getusuario_ult_atualizacao_nome_pk();	
	$ds_produto = $produtos->getds_produto();
	$vl_produto = $produtos->getvl_produto();
	$operador_pk = $produtos->getoperador_pk();
	$produto_tipo_pk = $produtos->getproduto_tipo_pk();
	$dt_cancelamento = $produtos->getdt_cancelamento();
	$vl_vc1 = $produtos->getvl_vc1();
	$vl_vc2 = $produtos->getvl_vc2();

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<!--Cabeçalho-->
	<title>n_produtos</title>	
	<!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="JavaScript" src="produtos_cad_form.js"></script>
	<link rel="stylesheet" href="../../extras/lytebox.css" type="text/css" media="screen" />
    <script type="text/javascript" language="javascript" src="../../extras/lytebox.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
<form name="combo" method="post" action="combo_res_form.php" target="pagina">
<input type='hidden' name='acao' id='acao' value='' />
<input type='hidden' name='pk' value='<?=$pk;?>' />

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
			<td  class="titulo">
			 <font color="#fffff">Produtos</font>
		</td>
	</tr>
</table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="1" cellspacing="1" class="form">
	<tbody id="tbl_produtos_combo">
									</tbody>	
	<tr>
		<td colspan="2">
			 
		</td>
	</tr>
	<tr>
		<td>
			Status:
		</td>
		<td>				
			<select name='dt_cancelamento'>					
				<option value="1" >Ativo</option>
				<option value="2" >Desativado</option>				
			</select>
		</td>
	</tr>
	<tr>
		<td  width="25%">
			Operadora: 
		</td>
		<td>
			<? $sql = "Select
						o.cod_operador operador_pk
						,o.dsc_operador
					from operador o
						inner join empresa_operador eo on o.cod_operador = eo.cod_operador
					group by o.dsc_operador
					order by o.cod_operador";

				combo($sql,"operador_pk", $operador_pk, "", " ");
			 ?>
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
						
				combo($sql,"produto_tipo_pk", $produto_tipo_pk, " ", 'onchange="reload_combo(this.value)"');
								
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
		<td colspan="2" align="center" >			
			<input type="Button" class="botao" value="Enviar" onclick="document.forms[0].submit();self.close();" />
			<input type="Button" class="botao" value="Fechar" onclick="self.close();" />&nbsp;
		</td>
	</tr>							
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
