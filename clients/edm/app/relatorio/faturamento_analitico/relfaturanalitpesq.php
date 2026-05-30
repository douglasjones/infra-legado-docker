<?	

/*

Pagina:relfaturanalitpesq.php

modulo:Relatorios



Dados de criação

Criação: 12/09/2008

Empresa: 

Executor ALEXANDRE CABRERA



Histórico das Revisões:

 Criação:

 Empresa: 

 Executor

 

Histórico de Auditorias:

 Criação:

 Empresa: 

 Executor

 */

/* 

 Includes 

*/

include_once "../../libs/maininclude.php";

include_once "../../libs/cla.combo.php";
$acao = $_REQUEST['acao'];
if(!(($acao == 'cs' && permissao('relfaturanalitpesq.php', 'cs')) || ($acao == 'upd' && permissao('relfaturanalitpesq.php', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>

<!--Include CSS-->

<link rel="stylesheet" href="../../extras/public.css" type="text/css">

<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">

<script type="text/javascript" language="javascript" src="../../extras/mascaras.js"></script>

<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>



<!--Cabeçalho-->

<title>Relatório de Faturamento Analítico</title>

<!--Comandos Javascript-->

<?	include_once "../../libs/head.php";?>

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

<form name="dados" method="get" action="../relatorio.php" target="_blank">
<input type="hidden" name="dirrel" value="faturamento_analitico">
<input type="hidden" name="pgrel" value="relfaturanalitres.php">

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">

	<tr>

		 <td  class="titulo"> 

			Relatório de Faturamento Analítico

		</td>

	</tr>

</table>	

<table border="0" cellpadding="0" cellspacing="0" class="form">

	<tbody>

	<tr>

		<td>

			&nbsp;<label  for="datacadastro">Polo:</label>

		</td>

		<td>
		<?	combo::polo();?>
		</td>

	</tr>

		<tr>

			<td>&nbsp;<label for="codequipe">Equipe:</label></td>

			<td>
		<? combo::equipe();?>
			</td>

		</tr>

		<tr>

			<td>&nbsp;<label for="dataenviode">Data de Envio de Contrato:</label></td>

			<td>

					&nbsp;<label for="dataenviode">de&nbsp;</label>

					<input type="text" id="dataenviode" name="dataenviode" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

					&nbsp;<label for="datastatusate">&nbsp;até&nbsp;</label>

					<input type="text" id="dataenvioate" name="dataenvioate" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

			</td>

		</tr>

		<tr>

			<td>&nbsp;<label for="dataativade">Data de Ativação:</label></td>

			<td>

					&nbsp;<label for="dataativade">de&nbsp;</label>

					<input type="text" id="dataativade" name="dataativade" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

					&nbsp;<label for="dataativaate">&nbsp;até&nbsp;</label>

					<input type="text" id="dataativaate" name="dataativaate" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

			</td>

		</tr>

		<tr>

			<td>&nbsp;<label for="dataenviode">Data de Estorno:</label></td>

			<td>

					&nbsp;<label for="dataestornode">de&nbsp;</label>

					<input type="text" id="dataestornode" name="dataestornode" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

					&nbsp;<label for="datastatusate">&nbsp;até&nbsp;</label>

					<input type="text" id="dataestornoate" name="dataestornoate" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

			</td>

		</tr>

		</tbody>

		<tfoot>

		<tr>

		          <td>&nbsp;

		              

		          </td>

  				  </tr>

		<tr>

			<th colspan="2" align="right" >

					<input type="button" value="Enviar" onclick="enviar()" />

					&nbsp;

					<input type="button" value="Fechar" onclick="window.close()" />&nbsp;

			</th>

		</tr>

	</tfoot>

</table>

</form>

</body>

</html>

<?	include_once "../../libs/desconectar.php";?>