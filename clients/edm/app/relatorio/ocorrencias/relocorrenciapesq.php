<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo.php";
$acao = $_REQUEST['acao'];
if(!(($acao == 'cs' && permissao('relocorrenciapesq.php', 'cs')) || ($acao == 'upd' && permissao('relocorrenciapesq.php', 'al')))){
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
    <title>Relatório de Ocorrências</title>
<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		this.value='Enviando...';
		var frm = document.forms[0]
		if(!validateForm(frm)) return false
		datacadastrode = document.getElementById('datacadastrode')
		datacadastroate = document.getElementById('datacadastroate')
		datafechamentode = document.getElementById('datafechamentode')
		datafechamentoate = document.getElementById('datafechamentoate')
		if(datacadastrode.value != '' && datacadastroate.value == ''){
			alert('Valor deve ser especificado!')
			datacadastroate.style.borderColor = 'red'
			datacadastroate.style.borderWidth = '3px'
			datacadastroate.focus()
			return false
		}
		if(datacadastroate.value != '' && datacadastrode.value == ''){
			alert('Valor deve ser especificado!')
    		datacadastrode.style.borderColor = 'red'
			datacadastrode.style.borderWidth = '3px'
			datacadastrode.focus()
			return false
		}
		if(datafechamentode.value != '' && datafechamentoate.value == ''){
			alert('Valor deve ser especificado!')
			datafechamentoate.style.borderColor = 'red'
			datafechamentoate.style.borderWidth = '3px'
			datafechamentoate.focus()
			return false
		}
		if(datafechamentoate.value != '' && datafechamentode.value == ''){
			alert('Valor deve ser especificado!')
			datafechamentode.style.borderColor = 'red'
			datafechamentode.style.borderWidth = '3px'
			datafechamentode.focus()
			return false
		}
		frm.submit()
    	self.close()
		return true
	}
	</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form name="dados" method="get" action="relocorrenciares.php" target="pagina">
	<table width="100%" align="center"  height="5"  class="topo"  cellpadding="2" cellspacing="3">
		<tr>
			 <td  class="titulo"> 
				Relatório de Ocorrências
    		</td>
		</tr>
	</table>	
	<table border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td>
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
                <td>&nbsp;<label for="mailing">Mailing:</label></td>
                <td>
                        <?combo::combo_mailing($mailing_pk);?>
                </td>
        </tr>
	<tr>
		<td>&nbsp;<label for="codtipoocorrencialead">Tipo:</label></td>
		<td>
<?	combo::padrao("tipoocorrenciaslead", "codtipoocorrencialead");?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="datacadastrode">Abertura:</label></td>
		<td>
			&nbsp;<label for="datacadastrode">de&nbsp;</label>
			<input type="text" id="datacadastrode" name="datacadastrode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="datacadastroate">&nbsp;até&nbsp;</label>
			<input type="text" id="datacadastroate" name="datacadastroate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
		<tr>
			<td>&nbsp;<label for="datafechamentode">Fechamento:</label></td>
			<td>
				&nbsp;<label for="datafechamentode">de&nbsp;</label>
				<input type="text" id="datafechamentode" name="datafechamentode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="datafechamentoate">&nbsp;até&nbsp;</label>
				<input type="text" id="datafechamentoate" name="datafechamentoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codusuariointerno">Aberto por:</label></td>
			<td>
	<?	combo::user("ocorrenciaslead");?>
			</td>
		</tr>
		<tr>
    		<td>&nbsp;<label for="grupousuariointerno">Equipe:</label></td>
			<td>
	<?	combo::grupo();?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
			<td>
	<?	combo::consultor($GerenteContas,$NomeUsuario);?>
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