<?
      /*
Pagina:formulariopesq.php
modulo:formulario
Submodulo: Lead / Pesquisar formulario pre-agendamento

Dados de criação
Criação:
Empresa:
Executor

Histórico das Revisões:
 Criação: 22/08/2008
 Empresa:
 Executor DOUGLAS JONES


 */

/*
 Includes
*/
    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo.php";
	if(!permissao('leads', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Pesquisar Formulário</title>
	<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
<script type="text/javascript" language="javascript" src="../../libs/datepicker.js"></script>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
		function enviar(){
			document.forms[0].submit();
			self.close();
		}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form id="dados" method="get" target="pagina" action="formulariores.php">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Pesquisar Formulário
		</td>
	</tr>
</table>

<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tbody>
        <tr>
             <td>&nbsp;
                 
             </td>
        </tr>
		<tr>
		<td>
			&nbsp;<label  for="datacadastro">Polo:</label>
		</td>
		<td>
<?		combo::polo();?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="gerentecontas">Consultor:</label></td>
		<td>
		<?	combo::cons_eqp($GerenteContas) ?>&nbsp;
		</td>
	</tr>	
	<tr>
		<td>&nbsp;<label for="dataini">Data de Visita:</label></td>
		<td>&nbsp;<label for="dataini"> de </label><input class="input" id="dataini" name="dataini" size="12" maxlength="10" validate="datatype=date" />&nbsp;<label for="datafim">&nbsp; a </label><input class="input" id="datafim" name="datafim" size="12" maxlength="10" validate="datatype=date" /></td>
	</tr>
	</tbody>
		<tr>
			<td colspan="2" align="right">&nbsp;
				
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="Button" class="botao" value="Enviar" onclick="document.forms[0].submit();self.close();" />
				<input type="Button" class="botao" value="Fechar" onclick="self.close();" />&nbsp;
				
			</td>
		</tr>
</table>

	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>