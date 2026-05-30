<?
include_once "../../libs/maininclude.php";
include_once "n_aparelhos_cla.php";
include_once "../../libs/combo.php";
	
$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];

if(!empty($pk)){
	$n_aparelhos = new n_aparelhos($pk);
	$pk = $n_aparelhos->getpk();
	$dt_cadastro = $n_aparelhos->getdt_cadastro();
	$usuario_cadastro_nome_pk = $n_aparelhos->getusuario_cadastro_nome_pk();
	$dt_ult_atualizacao = $n_aparelhos->getdt_ult_atualizacao();
	$usuario_ult_atualizacao_nome_pk = $n_aparelhos->getusuario_ult_atualizacao_nome_pk();
	$ds_aparelho = $n_aparelhos->getds_aparelho();
	$ds_link_imagem = $n_aparelhos->getds_link_imagem();
	$fabricante_pk = $n_aparelhos->getfabricante_pk();
	$operador_pk = $n_aparelhos->getoperador_pk();
	$dt_cancelamento = $n_aparelhos->getdt_cancelamento();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<!--Cabeçalho-->
	<title>Aparelhos</title>	
	<!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="JavaScript" src="n_aparelhos_cad_form.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
	<form name="dados" method="post" action="n_aparelhos_cad_proc.php" enctype="multipart/form-data">
		<input type='hidden' name='acao' id='acao' value='' />
		<input type='hidden' name='pk' value='<?= $pk;?>' />
		

		<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
			<tr>
					<td  class="titulo">
					Aparelhos
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
				combo($sql,"operador_pk", $operador_pk, "", " ");
			 ?>
		</td>
	</tr>	
	<tr>
		<td  width="25%">
			Fabricante: 
		</td>
		<td>
			<? $sql = "SELECT 
							npf.pk,
							npf.ds_aparelho_fabricante
					   FROM n_aparelhos_fabricantes npf
					   ORDER BY ds_aparelho_fabricante";
			   		   
			   combo($sql,"fabricante_pk", $fabricante_pk, " ", " ");?>
		</td>
	</tr>		
	<tr>
		<td  width="25%">
			Aparelhos: 
		</td>
		<td>
			<input type='text' id='ds_aparelho' size=40 maxlength=50 name='ds_aparelho' value="<?=$ds_aparelho;?>" />
		</td>
	</tr>		
	<tr>
		<td>
            Arquivo:
		</td>
		<td>
			<input size="60" type="File" name="nom_imagem_cel">			
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" >					
			<input type='button' name='cmdEnviar' id='cmdEnviar' value="Enviar" onclick="enviar();" />			 
			<input type="button" name="cmdFechar" id='cmdFechar' value="Fechar" onclick="self.close()" />
		</td>
	</tr>							
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
