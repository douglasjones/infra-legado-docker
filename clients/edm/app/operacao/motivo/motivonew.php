<?

    include_once "../../libs/maininclude.php";
	include_once "../../libs/combo.php";

	$codmotivolead = null;
	$descricao = null;
	$acao = "ins";

	if(!empty($_REQUEST['codmotivolead'])){
		$codmotivolead = $_REQUEST['codmotivolead'];
		$acao = "upd";
		$sql = "select * from motivoslead where CodMotivoLead = " . mysqlnull($codmotivolead);
		$result = sql_query($sql);
		if(!($row = mysql_fetch_array($result))){
			mysql_free_result($result);
			javascriptalert('Código de motivo inválido.');
			exit();
		}else{
			$descricao = $row['Descricao'];
			$cod_operador = $row['cod_operador'];
		}
		mysql_free_result($result);
	}
	if(!(($acao == 'ins' && permissao('motivos', 'ic')) || ($acao == 'upd' && permissao('motivos', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Motivos</title>
	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <?	include_once "../../libs/head.php";?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form id="dados" method="post" action="motivocad.php" onsubmit="return validateForm(this)">
		<input type="hidden" name="codmotivolead" value="<?php echo $codmotivolead;?>" />
		<input type="hidden" name="acao" value="<?php echo $acao?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Motivos
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
			<td>&nbsp;<label for="descricao">Descrição:</label></td>
			<td><input type="text" id="descricao" name="descricao" size="40" maxlength="255" value="<?=$descricao;?>" validate="required" /></td>
		</tr>
		<tr>
			<td>&nbsp;<label for="operador">Operador:</label></td>
			<td>
			<?	$sql = "select
							op.cod_operador
							,op.dsc_operador
						from  operador op 
						  inner join empresa_operador eo on op.cod_operador = eo.cod_operador
						where eo.dat_canc is null
						order by op.cod_operador";
				combo($sql, "cod_operador", $cod_operador, " ", "");?>
			</td>
		</tr>
	</tbody>
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
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
