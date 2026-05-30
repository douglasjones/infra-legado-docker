<?	
       /*
Pagina:leadnew.php
modulo:Vendas
submodulo: Lead

Dados de criação
Criação:
Empresa:
Executor

Histórico das Revisões:
 Criação: 25/06/2008
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
include_once "libs/maininclude.php";



	if(empty($_REQUEST['codagendaretorno'])){
		exit;
	}
	$codagendaretorno = $_REQUEST['codagendaretorno'];
	$sql = "SELECT a.*, l.RazaoSocial, ui.Nome AgendadoPor FROM agendaretorno a INNER JOIN leads l ON a.CodLead = l.CodLead LEFT JOIN usuariosinternos ui ON a.CodUsuarioInterno = ui.CodUsuarioInterno LEFT JOIN ocorrenciaslead o ON a.CodOcorrenciaLead = o.CodOcorrenciaLead WHERE a.CodAgendaRetorno = " . mysqlnull($codagendaretorno);

	$rs = sql_query($sql);
	$row = mysql_fetch_array($rs);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Retorno Atrasado</title>
<link rel="stylesheet" href="libs/public.css" type="text/css">	
<?	include_once "libs/head.php";?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Retorno Atrasado
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
	<tbody>
		<tr>
			<td> &nbsp;Agendado por</td>
			<td><?=$row['AgendadoPor'];?></td>
		</tr>
		<tr>
			<td> &nbsp;Lead</td>
			<td>
				<a href="vendas/leads/leadgerenciamentores.php?codlead=<?=$row['CodLead'];?>" target="pagina";"><?=$row['RazaoSocial'];?></a>
			</td>
		</tr>
		<tr>
			<td> &nbsp;Data e Horário</td>
			<td><?=date('d/m/Y \à\s H:i', strtotime($row['DataRetorno']));?></td>
		</tr>
		<tr>
			<td> &nbsp;Descrição</td>
			<td><?=$row['Descricao'];?></td>
		</tr>
		<tr>
			<th colspan="2" align="right">
				<input type="button" value="Fechar" onclick="self.close();" />
			</th>
		</tr>
	</tbody>
</table>
</body>
</html>
