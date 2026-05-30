<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.extras.php";
include_once "../../libs/cla.combo.php";

$acao = $_REQUEST['acao'];

if(!(($acao == 'cs' && permissao('relagendamentopesq.php', 'cs')) || ($acao == 'upd' && permissao('relagendamentopesq.php', 'al')))){
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
    <title>Relatório de Agendamentos</title>
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

	function vai_para( id )
	{
		document.forms[0].action = id;
	}
	</script>
</head>

<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" action="relagendamentores.php" id="formula" target="pagina">
<input type="hidden" name="dirrel" value="agendamento">
<input type="hidden" name="pgrel" value="relagendamentores.php">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório de Agendamentos
		</td>
	</tr>
</table>		
<table border="0" width="100%" cellpadding="1" cellspacing="0" class="form">
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
		<td>&nbsp;<label for="razaosocial">Razão Social:</&nbsp;<label></td>
		<td><input type="text" id="razaosocial" name="razaosocial" size="60" maxlength="255" /></td>
	</tr>
		<tr>
			<td>&nbsp;<label for="codstatusclassificacaolead">Status Lead:</&nbsp;<label></td>
			<td>
			<?	combo::status_ld(); ?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codtipo">Tipo Agendamento:</&nbsp;<label></td>
			<td>
			<?	combo::tipo(); ?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codstatus">Status:</&nbsp;<label></td>
			<td>
			<?	
			$sql = "select * from statusagendamento Order By Descricao";
			extras::checkbox2($sql, "codstatus", "all", array("Sem Classificação" => "0"));
			?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="datacadastrode">Data do Agendamento:</&nbsp;<label></td>
			<td>
				&nbsp;<label for="datacadastrode">de&nbsp;</&nbsp;<label>
				<input type="text" id="datacadastrode" name="datacadastrode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="datacadastroate">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="datacadastroate" name="datacadastroate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="datavisitade">Data da visita:</&nbsp;<label></td>
			<td>
				&nbsp;<label for="datavisitade">de&nbsp;</&nbsp;<label>
				<input type="text" id="datavisitade" name="datavisitade" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="datavisitaate">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="datavisitaate" name="datavisitaate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codequipe">Equipe:</label></td>
			<td>
			<?combo::equipe();?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="atendente">Mailing:</label></td>
			<td>
				<?combo::combo_mailing($mailing_pk);?>
			</td>
		</tr>		
		<tr>
			<td>&nbsp;<label for="codgerenteconta">Consultor:</&nbsp;<label></td>
			<td>
			<?	combo::consultor_equipe($codgerenteconta);?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codusuariointerno">Agendado por:</&nbsp;<label></td>
			<td>
			<?	combo::agdo_por();?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="agendadopara">Agendado para operadora:</&nbsp;<label></td>
			<td>
			<?	combo::agdo_para();?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="grupousuariointerno">Grupo de Usuário de Cadastro:</&nbsp;<label></td>
			<td>
			<?	combo::grupo();?>
			</td>
		</tr>
		<tr>
			<td valign="baseline">Tipo:</td>
			<td> <input id="anali" onclick="vai_para(this.value)" type="radio" value="relagendamentores.php"    name="relat" checked />Analitico
				 <input id="sinte" onclick="vai_para(this.value)" type="radio" value="relagendamentosinres.php" name="relat" 		  />Sintético<br><br><br>
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

