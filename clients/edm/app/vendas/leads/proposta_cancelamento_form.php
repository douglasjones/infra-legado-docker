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
	$operador_pk = $propostas->getoperador_pk();
	$ds_obs_proposta = $propostas->getds_obs_proposta(); 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<!--Cabeçalho-->
		<title>propostas</title>	
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
			<input type='hidden' name='acao' id='acao' value='cancelar' />
			<input type='hidden' name='pk' value='<?=$pk;?>' />	
			<input type='hidden' name='operador_pk' value='<?=$operador_pk;?>' />
			<input type="hidden" name="leads_pk" id="leads_pk" value="<?=$leads_pk;?>" />		
			<input type="hidden" name="nomeusuario" id="nomeusuario" value="<?=$_SESSION['nomeusuario'];?>" />
			<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">				
				<tr>
					<td  class="titulo">
						 <font color="ffffff">Cancelar Proposta</font>
					</td>
				</tr>
			</table>
			<table width="100%"  align="center" border="0" cellpadding="1" cellspacing="0" class="form">			
				<tr>
					<td colspan=2>
						&nbsp;
					</td>
				</tr>
				<tbody>
					<tr>
						<td><label for="codmotivo">Motivo:</label></td>
						<td>
							<?
								$sql = "";
								$sql.="SELECT m.CodMotivoLead,
											   m.Descricao
										  FROM motivoslead m
										ORDER BY m.Descricao";
								
								combo($sql,"motivo_cancelamento_pk","", " ", " validate='required'");							
							?>
						</td>
					</tr>
					<tr>
						<td><label for="descricao">Descrição:</label></td>
						<td><textarea id="dsc_cancelamento_proposta" name="dsc_cancelamento_proposta" rows="5" cols="45"></textarea></td>
					</tr>
				</tbody>
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
				<tfoot>
					<tr>					
						<td colspan="2" align="center" >
							<?
							if($pk != ''){
								?>
								<!--<input type='button' name="cmdExcluir" id='cmdExcluir' value='Excluir' onclick="excluir()" />-->							 
								<?
							}
							?>		
							<input type='button' name='cmdEnviar' id='cmdEnviar' value="Enviar" onclick="enviar_cancelamento();" />
							<input type="button" name="cmdFechar" id='cmdFechar' value="Fechar" onclick="self.close()" />

						</td>
					</tr>
					<tr>
						<td colspan="2">
							&nbsp;
						</td>
					</tr>								
				</tfoot>			
			</table>			
		</form>
	</body>
</html>
<?include_once "../../libs/desconectar.php";?>
