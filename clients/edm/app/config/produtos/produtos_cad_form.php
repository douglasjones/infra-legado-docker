<?
include_once "../../libs/maininclude.php";
include_once "produtos_cla.php";
	
$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];

/*if(!empty($pk)){
	$n_produtos = new n_produtos($pk);
	$pk = $n_produtos->getpk();
	$dt_cadastro = $n_produtos->getdt_cadastro();
	$usuario_cadastro_nome_pk = $n_produtos->getusuario_cadastro_nome_pk();
	$dt_ult_atualizacao = $n_produtos->getdt_ult_atualizacao();
	$usuario_ult_atualizacao_nome_pk = $n_produtos->getusuario_ult_atualizacao_nome_pk();
	$ds_produto = $n_produtos->getds_produto[];
	$vl_produtor = $vl_produtor->getvl_produtor[];
	$operador_pk = $operador_pk->getoperador_pk[];
	$dt_cancelamento = $dt_cancelamento->getdt_cancelamento[];

}*/

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
	<script type="text/javascript" language="JavaScript" src="n_produtos_cad_form.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
<form name="dados" method="post" action="n_produtos_cad_proc.php">
<input type='hidden' name='acao' id='acao' value='' />
<input type='hidden' name='pk' value='<?= $pk;?>' />

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
			<td  class="titulo">
			 n_produtos
		</td>
	</tr>
</table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="1" cellspacing="1" class="form">
	<tr>
		<td colspan="2">
			 
		</td>
	</tr>
	<tr>
<td>
ds_produto,vl_produtor,operador_pk,dt_cancelamento:
</td>
<td>
<input type='text' id='ds_produto,vl_produtor,operador_pk,dt_cancelamento' name='ds_produto,vl_produtor,operador_pk,dt_cancelamento' value='<?=$ds_produto,vl_produtor,operador_pk,dt_cancelamento;?>' />
</td>
</tr>

	<tr>
		<td  width="25%">
			Usuário Cadastro: 
		</td>
		<td>
			<?= $usuario_cadastro_nome_pk; ?>
		</td>
	</tr>	
	<tr>
		<td  width="25%">
			Data de Cadastro: 
		</td>
		<td>
			<?= $dt_cadastro; ?>
		</td>
	</tr>
	<tr>
		<td  width="25%">
			Último Usuário Atualização: 
		</td>
		<td>
			<?= $usuario_ult_atualizacao_nome_pk; ?>
		</td>
	</tr>		
	<tr>
		<td  width="25%">
			Data Última Atualização: 
		</td>
		<td>
			<?= $dt_ult_atualizacao; ?>
		</td>
	</tr>			
	<tr>
		<td colspan="2" align="center" >
			<?
			if($pk != ''){
				?>
				<input type='button' name="cmdExcluir" id='cmdExcluir' value='Excluir' onclick="excluir()" />
				 
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
