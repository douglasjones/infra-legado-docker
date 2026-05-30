<?

/*

Pagina:relpropostapesq.php

modulo:Relatorios



Dados de criação

Criação:

Empresa:

Executor



Histórico das Revisões:

 Criação: 26/06/2008

 Empresa:

 Executor RINALDO PELIGRINELI



Histórico de Auditorias:

 Criação: 16/04/2008

 Empresa:

 Executor FELIPE SANTOS

 */

/*

 Includes

*/

    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo.php";
	$acao = $_REQUEST['acao'];
	if(!(($acao == 'cs' && permissao('relpropostapesq.php', 'cs')) || ($acao == 'upd' && permissao('relpropostapesq.php', 'al')))){
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

	<title>Relatório de Propostas</title>

<?	include_once "../../libs/head.php";?>



    <!--Comandos Javascript-->

	<script type="text/javascript" language="javascript" src="../../extras/mascaras.js"></script>

	<script type="text/javascript" language="javascript">

	function enviar(){

		var frm = document.forms[0]

		if(!validateForm(frm)) return false

		dataenviode = document.getElementById('dataenviode')

		dataenvioate = document.getElementById('dataenvioate')

		dataprevisaode = document.getElementById('dataprevisaode')

		dataprevisaoate = document.getElementById('dataprevisaoate')

		datarecebimentode = document.getElementById('datarecebimentode')

		datarecebimentoate = document.getElementById('datarecebimentoate')

		if(dataenviode.value != '' && dataenvioate.value == ''){

			alert('Valor deve ser especificado!')

			dataenvioate.style.borderColor = 'red'

			dataenvioate.style.borderWidth = '3px'

			dataenvioate.focus()

			return false

		}

		if(dataenvioate.value != '' && dataenviode.value == ''){

			alert('Valor deve ser especificado!')

			dataenviode.style.borderColor = 'red'

			dataenviode.style.borderWidth = '3px'

			dataenviode.focus()

			return false

		}

		if(dataprevisaode.value != '' && dataprevisaoate.value == ''){

			alert('Valor deve ser especificado!')

			dataprevisaoate.style.borderColor = 'red'

			dataprevisaoate.style.borderWidth = '3px'

			dataprevisaoate.focus()

			return false

		}

		if(dataprevisaoate.value != '' && dataprevisaode.value == ''){

			alert('Valor deve ser especificado!')

			dataprevisaode.style.borderColor = 'red'

			dataprevisaode.style.borderWidth = '3px'

			dataprevisaode.focus()

			return false

		}

		if(datarecebimentode.value != '' && datarecebimentoate.value == ''){

			alert('Valor deve ser especificado!')

			datarecebimentoate.style.borderColor = 'red'

			datarecebimentoate.style.borderWidth = '3px'

			datarecebimentoate.focus()

			return false

		}

		if(datarecebimentoate.value != '' && datarecebimentode.value == ''){

			alert('Valor deve ser especificado!')

			datarecebimentode.style.borderColor = 'red'

			datarecebimentode.style.borderWidth = '3px'

			datarecebimentode.focus()

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

	<form name="dados" method="get" action="../relatorio.php" target="_blank">
	<input type="hidden" name="dirrel" value="proposta">
	<input type="hidden" name="pgrel" value="relpropostares.php">

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">

	<tr>

		 <td  class="titulo"> 

			Relatório de Propostas

		</td>

	</tr>

</table>		

	<table border="0" cellpadding="0" cellspacing="0" class="form">



	<tr>

		<td>

			&nbsp;<label  for="cod_polo">Polo:</label>

		</td>

		<td>
		<? combo::polo();?>
		</td>

	</tr>

				<tr>

					<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>

					<td>
		<?	combo::consultor($GerenteContas,$NomeUsuario);?>
					</td>

				</tr>

				<tr>

					<td>&nbsp;<label for="dataenviode">Data de envio:</label></td>

					<td>

						&nbsp;<label for="dataenviode">de&nbsp;</label>

						<input type="text" id="dataenviode" name="dataenviode" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

						&nbsp;<label for="dataenvioate">&nbsp;até&nbsp;</label>

						<input type="text" id="dataenvioate" name="dataenvioate" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

					</td>

				</tr>

				<tr>

					<td>&nbsp;</td>

					<td>&nbsp;<label for="canceladas"><input type="checkbox" id="canceladas" name="canceladas" value="1" checked="checked"/>Não incluir canceladas</label></td>

				</tr>

				<tr>

					<td>&nbsp;<label for="dataprevisaode">Data de previsão recebimento:</label></td>

					<td>

						&nbsp;<label for="dataprevisaode">de&nbsp;</label>

						<input type="text" id="dataprevisaode" name="dataprevisaode" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

						&nbsp;<label for="dataprevisaoate">&nbsp;até&nbsp;</label>

						<input type="text" id="dataprevisaoate" name="dataprevisaoate" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

					</td>

				</tr>

				<tr>

					<td>&nbsp;<label for="datarecebimentode">Data de recebimento:</label></td>

					<td>

						&nbsp;<label for="datarecebimentode">de&nbsp;</label>

						<input type="text" id="datarecebimentode" name="datarecebimentode" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

						&nbsp;<label for="datarecebimentoate">&nbsp;até&nbsp;</label>

						<input type="text" id="datarecebimentoate" name="datarecebimentoate" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />

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

