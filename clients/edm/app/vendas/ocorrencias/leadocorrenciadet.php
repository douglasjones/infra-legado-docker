<?
/*
/---------------------------------------------------\
|						    						|
|DESCRIÇÃO: PRINCIPAIS FUNÇÕES DO SISTEMA EM PHP    |
|						    						|
|					     	    					|
|REVISÕES:					    					|
|						    						|
|						    						| 
|DESESENVOLVIDO POR: DOUGLAS JONES LOPES	    	|
|						    						|
|DATA: 24/09/2008	     			    			|
\___________________G_E_P_R_O_S_____________________/
*/

    include_once "../../libs/maininclude.php";
	if(!permissao('ocorrencias', 'dt')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}

	$vCodOcorrenciaLead = $_REQUEST["codocorrencialead"];
	$sql = "Select oc.DataFechamento , oc.DataCadastro , oc.CodOcorrenciaLead , oc.Descricao , ui.Nome as NomeUsuario,tpo.Descricao as TipoOcorrencia,oc.Descricao";
	$sql .= " From ocorrenciaslead oc";
	$sql .= " left Join usuariosinternos ui on oc.CodUsuarioInterno = ui.CodUsuarioInterno";
	$sql .= " Inner Join tipoocorrenciaslead tpo on oc.CodTipoOcorrenciaLead = tpo.CodTipoOcorrenciaLead";
	$sql .= " Where oc.CodOcorrenciaLead=".$vCodOcorrenciaLead."";
	end;
	$result = sql_query($sql);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
   <!--Include CSS-->
   <link rel="stylesheet" href="../../extras/public.css" type="text/css">

    <!--Cabeçalho-->
	<title>Ocorrências Leads</title>
<?	include_once "../../libs/head.php";?>
</head>

<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<table border="0" cellpadding="0" cellspacing="0" class="form">
		<thead>
			<tr>
				<th colspan="2">Detalhes da Ocorrência</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Ocorrência:</td>
				<td><?=$row['CodOcorrenciaLead'];?></td>
			</tr>
			<tr>
				<td>Data Abertura:</td>
				<td><?=date('d/m/Y \à\s H:i:s', strtotime($row['DataCadastro']));?></td>
			</tr>
			<tr>
				<td>Tipo:</td>
				<td><?=$row['TipoOcorrencia'];?></td>
			</tr>
			<tr>
				<td>Descrição:</td>
				<td><?=$row['Descricao'];?></td>
			</tr>
			<tr>
				<td>Usuário:</td>
				<td><?=$row['NomeUsuario'];?></td>
			</tr>
			<tr>
				<td>Data Fechamento:</td>
				<td><?=(!empty($row['DataFechamento'])?date('d/m/Y \à\s H:i:s', strtotime($row['DataFechamento'])):null);?></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2">
					<input type="button" value="Fechar" onclick="window.close()" />
				</th>
			</tr>
		</tfoot>
	</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
