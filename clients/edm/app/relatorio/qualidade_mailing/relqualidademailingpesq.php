<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo.php";
	
	$acao = $_REQUEST['acao'];
	if(!(($acao == 'cs' && permissao('relqualidademailingpesq.php', 'cs')) || ($acao == 'upd' && permissao('relqualidademailingpesq.php', 'al')))){
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
	<title>Relatório de Qualidade de Mailing</title>
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
	<form name="dados" method="get" action="relqualidademailingres.php" target="pagina">
		<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
			<tr>
				 <td  class="titulo"> 
					Relatório de Qualidade de Mailing
				</td>
			</tr>
		</table>	

		<table border="0" align='center' class="form">
			<tbody>
				<tr>
					<td>
						<label  for="cod_polo">Polo:</label>
					</td>
					<td>
						<?//COMBO DE POLO
							$polo = $_SESSION['cod_polo'];
							combo::polo($polo,'');
						?>
					</td>
				</tr>
				<tr>
					<td><label for="mailing">Mailing:</label></td>
					<td>
						<?combo::combo_mailing();?>
					</td>

				</tr>
				<tr>
					<td><label for="gerentecontas">Consultor:</label></td>
					<td>
					<?	combo::consultor_equipe1($_SESSION['codusuario']);?>
					</td>
				</tr>	
				<tr>
					<td><label for="atendente">Atendente:</label></td>
					<td>
					<?	combo::atendente_equipe1($_SESSION['codusuario']);?>
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

