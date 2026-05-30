<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo.php";
$acao = $_REQUEST['acao'];
if(!(($acao == 'cs' && permissao('propostas_perdidas_pesq.php', 'cs')) || ($acao == 'upd' && permissao('propostas_perdidas_pesq.php', 'al')))){
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
    <title>Relatório de Propostas Perdidas</title>
<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		this.value='Enviando...';
		var frm = document.forms[0]
		
		frm.submit()
    	self.close()
		return true
	}
	</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <form name="dados" method="get" action="propostas_perdidas_res.php" target="pagina">
	<table width="100%" align="center"  height="5"  class="topo"  cellpadding="2" cellspacing="3">
		<tr>
			 <td  class="titulo"> 
				Relatório de Propostas Perdidas
    		</td>
		</tr>
	</table>	
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
            <td width="45%">
			&nbsp;<label  for="datacadastro">Polo:</label>
		</td>
		<td>
    		<?//COMBO DE POLO
				$polo = $_SESSION['cod_polo'];
				combo::polo($polo,'');
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="codequipe">Equipe:</label></td>
		<td>
		<? 
			combo::equipe($codequipe);
		?>
		</td>
	</tr>
    <tr>
		<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
		<td>
		<?	combo::consultor_equipe($_SESSION['codusuario']); ?>
		</td>
	</tr>
        <tr>
			<td>&nbsp;<label for="datacadastrode">Data Cancelamento Proposta:</&nbsp;<label></td>
			<td>
				&nbsp;<label for="datacadastrode">de&nbsp;</&nbsp;<label>
				<input type="text" id="data_cancelamento_ini" name="data_cancelamento_ini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="datacadastroate">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="data_cancelamento_fim" name="data_cancelamento_fim" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr> 
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
            </tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">
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
<?	include_once "../../libs/desconectar.php";?>