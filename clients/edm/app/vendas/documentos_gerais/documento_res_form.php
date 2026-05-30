<?php

include_once "../../libs/maininclude.php";


if(!empty($_REQUEST['coddocumento'])){
	
	if(!permissao('documentos_gerais', 'ex')){
		echo "<script>alert('Acesso negado.');</script>";
	}
	else{
		$sql ="";
		$sql.="select ds_nome_documento ";
		$sql.="  from documentos_gerais dg ";
		$sql.=" where dg.pk = ".$_REQUEST['coddocumento'];
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			unlink($row['ds_nome_documento']);
		}
		mysql_free_result($result);
		
		
		$sql = "";
		$sql.="update documentos_gerais set ic_ativo = 0 where pk = ".$_REQUEST['coddocumento'];
		sql_query($sql);
		echo "<script>opener.refresh();</script>";
	}
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Histórico de documentos_gerais</title>
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<script>
	function excluir(vlr){
		if(confirm("Deseja excluir o arquivo?")){
			frm.coddocumento.value = vlr;
			frm.submit();
		}
	}
	</script>
</head>
<body onload="carregar()">
<form name="frm" method="post">
<input type="Hidden" name="coddocumento">
<table id="tbl" name="tbl" border=0 cellpadding="1" cellspacing="1" width="100%">
	<tr>
		<th align="center" class="titulo" bgcolor="#8080FF">
			Documento
		</th>
		<th align="center" class="titulo" bgcolor="#8080FF">
			Nome Original
		</th>		
		<th align="center" class="titulo" bgcolor="#8080FF">
			Data Cadastro
		</th>
		<th align="center" class="titulo" bgcolor="#8080FF">
			Descrição
		</th>
		<th align="center" class="titulo" bgcolor="#8080FF">
			Usuário de Cadastro
		</th>		
		<th align="center" class="titulo" bgcolor="#8080FF">
			Ação
		</th>		
	</tr>
	<?
	
	$i = 0;
	$total_arquivos=0;
	
	$sql =" select ds_nome_original, pk, ds_nome_documento, ds_documento, date_format(datacadastro, '%d/%m/%Y %H:%i:%s') dt_ins, ui.nome ";
	$sql.="   from documentos_gerais d ";
	$sql.="		   inner join usuariosinternos ui on d.codusuariointerno = ui.codusuariointerno ";
	$sql.=" where d.ic_ativo = 1 ";
	$sql.=" order by pk desc ";
	
	$result = sql_query($sql);
	while ($row = mysql_fetch_array($result)){
		if($i == 0){
			$cor = "#DDDDFF";
			$i = 1;
		}
		else{
			$cor = "";
			$i = 0;
		}
			
		echo "<tr>";
		echo "<td class='form' align='center' bgcolor='$cor'><a href='".$row['ds_nome_documento']."'>".$row['ds_nome_documento']."</a></td>";
		echo "<td class='form' align='center' bgcolor='$cor'>".$row['ds_nome_original']."</td>";
		echo "<td class='form' align='center' bgcolor='$cor'>".$row['dt_ins']."</td>";
		echo "<td class='form' align='center' bgcolor='$cor'>".$row['ds_documento']."</td>";
		echo "<td class='form' align='center' bgcolor='$cor'>".$row['nome']."</td>";
		echo "<td class='form' align='center' bgcolor='$cor'><a href='javascript:excluir(".$row['pk'].")'>Excluir</a></td>";
		echo "</tr>";
		$total_arquivos++;
	}
	mysql_free_result($result);
	?>
	<tr>
		<th align="center" class="titulo" bgcolor="#8080FF" colspan="6">
			<?= $total_arquivos?> Arquivo(s)
		</th>
	</tr>
</table>

<br>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>