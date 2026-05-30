<?

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.extras.php";
include_once "../../libs/cla.combo.php";

$acao = $_REQUEST['acao'];

/*
if(!(($acao == 'cs' && permissao('relagendamentopesq.php', 'cs')) || ($acao == 'upd' && permissao('relagendamentopesq.php', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css" />

    <!--Cabeçalho-->
    <title>Relatório de Agendamentos</title>
<?	include_once "../../libs/head.php";?>

    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		var frm = document.forms[0]
		if(!validateForm(frm)) return false
		
		if(frm.ativacaoini.value != ""){
			if(frm.ativacaofim.value == ""){
				alert("Preencha o final do período de Ativacação");
				frm.ativacaofim.focus();
				return false;
			}
		}
		
		frm.submit()
		self.close()
		return true
	}

	function vai_para( id )
	{
		document.forms[0].action = id;
	}
	</script>
</head>

<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" action="vendas_tim_res.php" id="formula" target="pagina">
<input type="hidden" name="dirrel" value="agendamento">
<input type="hidden" name="pgrel" value="relagendamentores.php">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Vendas
		</td>
	</tr>
</table>		
<table border="0" width="100%" cellpadding="1" cellspacing="0" class="form">
	<tbody>
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
			<td>&nbsp;<label for="datacadastrode">Data Ativação:</&nbsp;<label></td>
			<td>
				&nbsp;<label for="ativacao">de&nbsp;</&nbsp;<label>
				<input type="text" id="ativacaoini" name="ativacaoini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="ativacaofim">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="ativacaofim" name="ativacaofim" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr>				
		<tr>
			<td>&nbsp;<label for="codequipe">Equipe:</label></td>
			<td>
			<?combo::equipe();?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codgerenteconta">Consultor:</&nbsp;<label></td>
			<td>
			<?combo::consultor($GerenteContas, $NomeUsuario);?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="grupousuariointerno">Atendente:</&nbsp;<label></td>
			<td>
			<?combo::atendente($Atendente, $NomeUsuario);?>
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

