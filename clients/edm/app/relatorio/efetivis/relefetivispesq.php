<?	
/*
Pagina:relefetivispesq.php
modulo:Relatorios

Dados de criação
Criação: 02/10/2008
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
if(!(($acao == 'cs' && permissao('relefetivispesq.php', 'cs')) || ($acao == 'upd' && permissao('relefetivispesq.php', 'al')))){
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
<title>Relatório de Efetividade de Visita</title>
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
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" action="relefetivisres.php" target="_blank">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório de Efetividade de Visita
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
			<?//COMBO DE POLO
				$polo = $_SESSION['cod_polo'];
				combo::polo($polo,'');
			?>
		</td>
	</tr>
		<tr>
			<td>&nbsp;<label for="codgerente">Gerente:</label></td>
			<td>
			<?	combo::gerente();?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codequipe">Equipe:</label></td>
			<td>
			<?	combo::equipe();?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="dataagendamentode">Data da Visita:</label></td>
			<td>
					&nbsp;<label for="dataagde">de&nbsp;</label>
					<input type="text" id="dataagde" name="dataagde" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />
					&nbsp;<label for="datastatusate">&nbsp;até&nbsp;</label>
					<input type="text" id="dataagate" name="dataagate" onkeypress="mascara(this,datamask)" size="12" maxlength="10" validate="datatype=date" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="tipo">Tipo:</label></td>
			<td>
				<input type="radio" name="tipo" id="tipo" value="analit" checked>&nbsp;<label for="tipo">Analitico</label>&nbsp;&nbsp;
				<input type="radio" name="tipo" id="tipo" value="sintet">&nbsp;<label for="tipo">Sintetico</label>
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