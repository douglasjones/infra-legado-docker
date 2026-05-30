<?

$codlead = $_REQUEST['codlead'];
$operadora_pk = $_REQUEST['operadora_pk'];

?>

<html>
<head>
	<title>Adicionar documentos ao Lead</title>
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
</head>
<body>
<form method="post" action="documentos_cad_proc.php" enctype="multipart/form-data" >
<input type="hidden" name="codlead" value='<?= $codlead?>'>
<input type="hidden" name="operadora_pk" value='<?= $operadora_pk;?>'>
<table border=0 cellpadding="1" cellspacing="1" width="100%">
<tr>
	<th align="center" class="titulo" bgcolor="#8080FF">
		Documentos
	</th>
</tr>
</table>
<div><font size=1>&nbsp;</font></div>
<table width="100%" border="0" cellpadding="1" cellspacing="1">
	<tr>
		<td class="form">
			<b>Arquivo 1:</b>
		</td>
		<td>
			<input size="60" type="File" name="ds_nome_documento1">
		</td>
	</tr>
	<tr>
		<td class="form">
			<b>Descrição 1:</b>
		</td>
		<td>
			<input type="Text" name="ds_documento1" maxlength="60" size="60">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td class="form">
			<b>Arquivo 2:</b>
		</td>
		<td>
			<input size="60" type="File" name="ds_nome_documento2">
		</td>
	</tr>
	<tr>
		<td class="form">
			<b>Descrição 2:</b>
		</td>
		<td>
			<input type="Text" name="ds_documento2" maxlength="60" size="60">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td class="form">
			<b>Arquivo 3:</b>
		</td>
		<td>
			<input size="60" type="File" name="ds_nome_documento3">
		</td>
	</tr>
	<tr>
		<td class="form">
			<b>Descrição 3:</b>
		</td>
		<td>
			<input type="Text" name="ds_documento3" maxlength="60" size="60">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td class="form">
			<b>Arquivo 4:</b>
		</td>
		<td>
			<input size="60" type="File" name="ds_nome_documento4">
		</td>
	</tr>
	<tr>
		<td class="form">
			<b>Descrição 4:</b>
		</td>
		<td>
			<input type="Text" name="ds_documento4" maxlength="60" size="60">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td class="form">
			<b>Arquivo 5:</b>
		</td>
		<td>
			<input size="60" type="File" name="ds_nome_documento5">
		</td>
	</tr>
	<tr>
		<td class="form">
			<b>Descrição 5:</b>
		</td>
		<td>
			<input type="Text" name="ds_documento5" maxlength="60" size="60">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input type="Submit" value="Gravar">
			<input type="Button" value="Fechar" onclick="self.close()">
		</td>
	</tr>
</table>

</form>
</body>
</html>
