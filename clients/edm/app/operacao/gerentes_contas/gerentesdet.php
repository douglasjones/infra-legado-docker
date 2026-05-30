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
 Executor Douglas Jones

Histórico de Auditorias:
 Criação: 16/04/2008
 Empresa:
 Executor FELIPE SANTOS
 */

/*
 Includes
*/	include_once "../../libs/maininclude.php";
	if(!permissao('gerentecontas', 'dt')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}

	$codusuarioInterno = null;
	$nome = null;

	if (!empty($_REQUEST['codusuariointerno'])){
		$codusuarioInterno = $_REQUEST['codusuariointerno'];
		$sql = "select * ";
		$sql .= " from usuariosinternos ";
		$sql .= " where CodUsuarioInterno = $codusuariointerno ";
		$sql .= " And GerenteContas = 1";
		$result = sql_query($sql);
		if(!($row = mysql_fetch_array($result)))
		{
			mysql_free_result($result);
			javascriptalert('Código de Gerente inválido.');
			exit();
		}else{
			$nome = $row['Nome'];
		}
		mysql_free_result($result);
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
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Gerentes Contas
		</td>
	</tr>
</table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tbody>
		<tr>
	            <td>
	                &nbsp;
	            </td>
	       </tr>
		<tr>
			<td>&nbsp;Nome:</td>
			<td><?=$nome;?></td>
		</tr>
		<tr>
			<th colspan="2">Leads</th>
		</tr>
		<tr>
			<td colspan="2">
				<table border="0" cellpadding="0" cellspacing="0" border="0" class="grid">
					<thead>
						<tr>
							<th>#</th>
							<th>Razão Social</th>
						</tr>
					</thead>
					<tbody>
<?	$sql = "select *";
	$sql .= " from leads";
	$sql .= " where codgerenteconta = $codusuariointerno ";
	$sql .= " order by RazaoSocial";
	$result = sql_query($sql);
	while($row= mysql_fetch_array($result)){?>
							<tr>
								<td><?=$row['CodLead'];?></td>
								<td><?=$row['RazaoSocial'];?></td>
							</tr>
<?	}
	mysql_free_result($result);?>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
		<tfoot>
		<tr>
			<td colspan="2" align="right">
				&nbsp;
			</td>
		</tr>	
			<tr>
				<th colspan="2" align="right">
					<input type="button" value="Fechar" onclick="self.close();" />&nbsp;
				</th>
			</tr>
		</tfoot>
	</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
