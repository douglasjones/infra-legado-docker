<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo.php";
$acao = $_REQUEST['acao'];

if(!(($acao == 'cs' && permissao('relprocessopesq.php', 'cs')) || ($acao == 'upd' && permissao('relprocessopesq.php', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}	
	
	?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css" />
    <!--Cabeçalho-->
	<title>Acompanhamento de Processo</title>
<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		var frm = document.forms[0]
		if(!validateForm(frm)) return false
		frm.submit()
		self.close()
		return true
	}
	</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" action="relprocessores.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Acompanhamento de Processo
		</td>
	</tr>
</table>		
<br>
<table border="0" cellpadding="0" cellspacing="0" class="form" width="100%">
		<tr>
			<td>&nbsp;<label for="datarecebimento">DT Previsão de assinatura do Contrato:</label></td>
			<td>
				&nbsp;<label for="datarecebimentode">de&nbsp;</label>
				<input type="text" id="datarecebimentode" name="datarecebimentode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date;required" />
				&nbsp;<label for="datarecebimentoate">&nbsp;até&nbsp;</label>
				<input type="text" id="datarecebimentoate" name="datarecebimentoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)"  validate="datatype=date;required" />
			</td>
		</tr>
	<tr>
		<td>
			&nbsp;<label  for="datacadastro">Polo:</label>
		</td>
		<td>
		<? 
				$polo = $_SESSION['cod_polo'];
				combo::polo($polo,'');
		?>
		</td>
	</tr>
		<tr>
			<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
			<td>
			<?	combo::consultor_equipe($_SESSION['codusuario'], $_SESSION['codusuario'], " "); ?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codgerenteconta">Atendente:</label></td>
			<td>
			<?	combo::atendente_equipe($_SESSION['codusuario'], $_SESSION['codusuario'], " "); ?>
			</td>
		</tr>		
		<!-- tr>
			<td>&nbsp;<label for="pendencia">Pendência:</label></td>
			<td>
				<select name="pendencia" id="pendencia">
					<option value="0">-- Todos --</option>
					<option value="envio_contrato_operadora">Envio Contrato Operadora</option>
					<option value="entrega_aparelho">Entrega Aparelho</option>
					<option value="ativacao">Ativação da Linha</option>
				</select>
			</td>
		</tr -->
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">
				<br>
				<br>
				
				<input type="button" value="Enviar" onclick="enviar()" />
				&nbsp;
				<input type="button" value="Fechar" onclick="window.close()" />
			</th>
		</tr>
	</tfoot>
</table>
</form>
</body>
</html>
