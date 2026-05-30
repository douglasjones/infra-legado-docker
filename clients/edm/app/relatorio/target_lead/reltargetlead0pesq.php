<?
include_once "../../libs/maininclude.php";

include_once "../../libs/cla.combo.php";
$acao = $_REQUEST['acao'];
if(!(($acao == 'cs' && permissao('reltargetlead0pesq.php', 'cs')) || ($acao == 'upd' && permissao('reltargetlead0pesq.php', 'al')))){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<head>

    <!--Include CSS-->

    <link rel="stylesheet" href="../../extras/public.css" type="text/css">



    <!--Cabeçalho-->

	<title>Relatório de Target e Lead 0%</title>

<?	include_once "../../libs/head.php";?>



    <!--Comandos Javascript-->

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

	<form name="dados" method="get" action="reltargetlead0res.php" target="pagina">
	<input type="hidden" name="dirrel" value="target_lead">
	<input type="hidden" name="pgrel" value="reltargetlead0res.php">

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
			<th class="titulo" >Relatório de Target e Lead 0%</th>
	</tr>
</table>
	
			</thead>
<table border="0" cellpadding="3" cellspacing="3" class="form">
			<tbody>

	<tr>

		<td>

			<label  for="datacadastro">Polo:</label>

		</td>

		<td>
			<?//COMBO DE POLO
				$polo = $_SESSION['cod_polo'];
				combo::polo($polo,'');
			?>
		</td>

	</tr>

				<tr>

					<td><label for="codgerenteconta">Consultor:</label></td>

					<td>
		<?	combo::consultor($GerenteContas,$NomeUsuario);?>
					</td>

				</tr>

				<tr>

					<td><label for="mailing">Mailing:</label></td>

					<td>
		<?	combo::mailing();?>
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

<? include_once "../../libs/desconectar.php";?>

