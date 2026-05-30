<?
include_once "../../libs/maininclude.php";
include_once "carga_cla.php";
include_once "../../libs/combo.php";
include_once "../../libs/cla.combo.php";
include_once( "../../libs/cla.comboajax.php" ) ;

	
$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<!--Cabeçalho-->
	<title>carga</title>	
	<!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="JavaScript" src="carga_cad_form.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
<form action="carga_cad_proc.php" method="POST" enctype="multipart/form-data">
<input type='hidden' name='acao' id='acao' value='' />
<input type='hidden' name='pk' value='<?= $pk;?>' />

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
			<td  class="titulo">
			 Carga
		</td>
	</tr>
</table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="1" cellspacing="1" class="form">
	<tr>
		<td colspan="2">
			 &nbsp;
		</td>
	</tr>
	<tr>
		<td>
		Selecione o Arquivo:
		</td>
		<td>
			<input size="60" type="File" name="ds_nome_documento">			
		</td>
	</tr>
	<tr>
		<td>
			Nome do Mailing:
		</td>
		<td>
			<?combo::combo_mailing($mailing_pk);?>	
		</td>
	</tr>
    <tr>
		<td>
			Atendente:
		</td>
		<td>
			<?	combo::atendente_equipe1($_SESSION['codusuario']);?>
		</td>
	</tr>
    <tr>
		<td>
			Consultor:
		</td>
		<td>
			<?combo::equipe($codequipe);?>
		</td>
	</tr>
    <tr>
		<td>
			Status Lead:
		</td>
		<td>
			<?	
				$sql = "select codstatusclassificacaolead, descricao from statusclassificacaolead order by codstatusclassificacaolead ";
				combo($sql,"codstatusclassificacaolead", "", " ", "");
			?>
		</td>
	</tr>
	<tr>
		<td colspan=2>&nbsp;</td>
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
