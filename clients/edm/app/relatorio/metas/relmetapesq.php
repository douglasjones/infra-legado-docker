<?

    /*

Pagina:relmetapesq.php

modulo:Relatorios



Dados de criação

Criação:

Empresa:

Executor



Histórico das Revisões:

 Criação: 16/04/2008

 Empresa:

 Executor FELIPE SANTOS



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
if(!(($acao == 'cs' && permissao('relmetapesq.php', 'cs')) || ($acao == 'upd' && permissao('relmetapesq.php', 'al')))){
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

	<title>Relatório de Metas</title>

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

	<form name="dados" method="get" action="../relatorio.php" target="_blank">
	<input type="hidden" name="dirrel" value="metas">
	<input type="hidden" name="pgrel" value="relmetares.php">

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">

	<tr>

		 <td  class="titulo"> 

			Relatório de Metas

		</td>

	</tr>

</table>

	

	<table border="0" cellpadding="0" cellspacing="0" class="form">



	<tr>

		<td>

			&nbsp;<label  for="datacadastro">Polo:</label>

		</td>

		<td>
		<? combo::polo();?>
		</td>

	</tr>

		<tr>

			<td>&nbsp;<label for="codequipe">Equipe:</label></td>

			<td>
		<? combo::equipe();?>
			</td>

		</tr>

			<tr>

				<td>&nbsp;<label for="codgerenteconta">Usuário:</label></td>

				<td>
			<?	combo::usuario($GerenteContas,$NomeUsuario);?>
				</td>

			</tr>

			<tr>
				<td>&nbsp;<label for="faixadatasde" id="label_datas">Data da Assinatura(Cons.)/Visita(Atend.):</label></td>
				<td>
					&nbsp;<label for="faixade">de&nbsp;</label>
					<input type="text" id="faixade" name="faixade" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
					&nbsp;<label for="datastatusate">&nbsp;até&nbsp;</label>
					<input type="text" id="faixaate" name="faixaate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				</td>
			</tr>
			<tr id="datas2">
				<td>&nbsp;<label for="faixadatasde" id="label_datas2">Entrega de Aparelhos(Cons.):</label></td>
				<td>
					&nbsp;<label for="faixade">de&nbsp;</label>
					<input type="text" id="faixade2" name="faixade2" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
					&nbsp;<label for="datastatusate">&nbsp;até&nbsp;</label>
					<input type="text" id="faixaate2" name="faixaate2" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
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

			<tr>

				<th colspan="2">&nbsp;</th>

			</tr>

			<tr>

				<td colspan="2">Obs: Este relatório apenas leva em consideração linhas novas.</td>

			</tr>

		</tfoot>

	</table>

	</form>

</body>

</html>

<? include_once "../../libs/desconectar.php"; ?>

