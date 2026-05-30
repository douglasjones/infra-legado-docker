<?
/*
Pagina:gerentesnew.php
modulo:Operações
Submodulo: Novo

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
include_once "../../libs/combo.php";

	$codgerenteconta = 0;
	$acao = "ins";

	if (!empty($_REQUEST['codgerenteconta'])){
		$codgerenteconta = $_REQUEST['codgerenteconta'];
		$acao = "upd";
		$sql = "select * ";
		$sql .= " from usuariosinternos ";
		$sql .= " where CodUsuarioInterno = $codgerenteconta ";
		$sql .= " And GerenteContas = 1";
		$result = sql_query($sql);
		if(!($row = mysql_fetch_array($result))){
			mysql_free_result($result);
			javascriptalert('Código de Gerente inválido.');
			exit();
		}
		mysql_free_result($result);
	}
	if(!(($acao == 'ins' && permissao('gerentecontas', 'ic')) || ($acao == 'upd' && permissao('gerentecontas', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../libs/public.css" type="text/css">
<title>Gerentes Contas</title>
<?	include_once "../../libs/head.php";?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form id="dados" method="post" action="gerentescad.php" onsubmit="return validateForm(this)">
		<input type="hidden" name="codusuariointernoa" value="<?=$codgerenteconta;?>" />
		<input type="hidden" name="acao" value="<?=$acao;?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Gerentes Contas
		</td>
	</tr>
</table>		
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
     <tr>
          <td>
              &nbsp;
          </td>
     </tr>
	<tr>
			<td>&nbsp;<label for="codusuariointerno">Nome:</label></td>
			<td>
<?	$sql = "Select codusuariointerno, Nome from usuariosinternos Where GerenteContas = 0 or CodUsuarioInterno = " . mysqlnull($codgerenteconta) . " And Desativado <> 1 Order By Nome";
	combo($sql, "codusuariointerno", $codgerenteconta, "", ' validate="required"');?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				&nbsp;
			</td>
		</tr>		
		<tr>
			<th colspan="2" align="right">
				<input type="submit" value="Enviar" />
				<input type="button" value="Fechar" onclick="self.close();" />&nbsp;
			</th>
		</tr>
	</tbody>
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
