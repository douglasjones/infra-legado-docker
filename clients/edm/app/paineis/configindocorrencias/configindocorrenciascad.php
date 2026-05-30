<?
	include_once "../../libs/maininclude.php";
	
	if(count($_REQUEST['chk']) > 0){
		//exclui todos os registros;
		$sql = "delete from config_painel";
		sql_query($sql);
		
		for($i = 0; $i<count($_REQUEST["chk"]); $i++){
			//adiciona somente os registros que foram selecionados
		 	$sql = "insert into config_painel(codusuariointerno, ic_exibir) values(".$_REQUEST["chk"][$i].",true) ";
			sql_query($sql);
		}
		echo "<script>alert('Registros atualizados com sucesso!!!');</script>";
	}
	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <!--Cabeçalho-->
	<title>Configuração Painel Indicações de Ocorrências</title>
    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		var frm = document.forms[0];
		frm.submit();
	}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frm" method="post">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Configuração Painel Indicações de Ocorrências
		</td>
	</tr>
</table>
<table border="0" cellpadding="1" cellspacing="1" class="form" width="100%">
	<tr>
		<th bgcolor="#0080C0" class="titulo">#</th>
		<th bgcolor="#0080C0" class="titulo">Atendente</th>
	</tr>
	<?
	$cor = 0;
	
	$sql ="";
	$sql.="select ui.codusuariointerno, ui.nome, ifnull(cp.ic_exibir, 0) exibir ";
	$sql.="  from usuariosinternos ui ";
	$sql.="       left join config_painel cp on ui.codusuariointerno = cp.codusuariointerno ";
	$sql.=" where atendente = 1"; 
	
	$result = sql_query($sql);
	while($row = mysql_fetch_array($result)){
		
		if($cor == 0)
			echo "<tr>";
		else
			echo "<tr bgcolor='#D5D5FF'>";
		
		echo "<td align='center'><input type='checkbox' name='chk[]' value='".$row["codusuariointerno"]."'";
		if($row['exibir'] == 0){
			echo "></td>";
		}
		else{
			echo " checked></td>";
		}
		echo "<td align='center'>".$row["nome"]."</td>";
		echo "</tr>";
		
		if($cor == 0)
			$cor = 1;
		else
			$cor = 0;
			
	}
	mysql_free_result($result);
	?>	
	<tr>
		<th colspan="2">
			<br>
			<input type="button" value="Enviar" onclick="enviar()" />
			&nbsp;
			<input type="button" value="Fechar" onclick="window.close()" />
		</th>
	</tr>
</table>
</form>
</body>
</html>

