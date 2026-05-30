<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/combo.php";
	$acao = "ins";
	if (isset($_REQUEST['cod_polo'])){
	
		$acao = "upd";
		//Faz a pesquisa no banco de dados.
		$sql = "Select
				p.cod_polo
				,p.n_polo
				,p.dat_canc
			from polo p
			where p.cod_polo=". $_REQUEST['cod_polo']; 	
		$sql .= " 	order by p.n_polo";
		$result = sql_query($sql);
		while($row = mysql_fetch_array($result)){
			$n_polo = $row['n_polo'];
			$dat_canc = $row['dat_canc'];
		}
		mysql_free_result($result);
	}
	if(!(($acao == 'ins' && permissao('config_polo', 'ic')) || ($acao == 'upd' && permissao('config_polo', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Polos</title>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
		closeSimpleBox();
	</script>
	<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form id="dados" method="post" action="polo_cad.php">
		<input type="hidden" name="cod_polo" value="<?=$_REQUEST['cod_polo'];?>" />
		<input type="hidden" name="acao" value="<?=$acao?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Polos
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
			<td>&nbsp;<label for="polo">Nome:</label></td>
			<td>
				<input type="text" id="n_polo" name="n_polo" maxlength="50" size="50" value="<?=$n_polo;?>" validate="required" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="status">Status:</label></td>
			<td>
				<select name="status" id="desativado">
					<option value="1" <?=($dat_canc == ""?'selected="selected"':null);?>>Ativo</option>
					<option value="0" <?=($dat_canc != ""?'selected="selected"':null);?>>Desativado</option>
				</select>
			</td>
		</tr>

		<tr>
			<th colspan="2">
				<input type="Submit" value="Enviar"  />
				<input type="button" value="Fechar" onclick="self.close();" />
			</th>
		</tr>
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
