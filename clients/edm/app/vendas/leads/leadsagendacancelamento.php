<?	include_once "../../libs/maininclude.php";
	include_once "../../libs/datas.php";
	include_once "../../libs/cla.agendaslead.php";
	include_once "../../libs/combo.php";
	
	$acao = null;
	
	if(!empty($_REQUEST['enviar']) && !empty($_REQUEST['codagendalead'])){
		agendaslead::cancelar($_REQUEST['codagendalead'], $_REQUEST['cancelamento']);
		javascriptalert('Operação executada com sucesso!!!');
		exit;
	}else{
		if(!empty($_REQUEST['codagendalead'])){
			$codagendalead = $_REQUEST['codagendalead'];
			$sql = "select a.*";
			$sql .= " from agendaslead a";
			$sql .= " where a.CodAgendaLead = " . mysqlnull($_REQUEST['codagendalead']);
			$result = sql_query($sql);
			if($row = mysql_fetch_array($result)){
				$cancelamento = $row['Cancelamento'];
			}else
				exit();
			$acao = (empty($cancelamento)?'ins':'upd');
			mysql_free_result($result);
		}
	}
	if(!(($acao == 'ins' && permissao('cancelarvisita', 'ic')) || ($acao == 'upd' && permissao('cancelarvisita', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<title>Ativo - Cancelamento de Visita</title>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
function validaCampos(){
	if(!validateForm(document.forms[0])) return false
	return true
}
	</script>
</head>
<body>
	<form name="dados" method="post" action="leadsagendacancelamento.php" onsubmit="return validaCampos(this)">
		<input type="hidden" id="codagendalead" name="codagendalead" value="<?=$codagendalead;?>" />
        <table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
        	<tr>
        		 <td  class="titulo"> 
        			&nbsp;Ativo - Cancelamento de Visita
        		</td>
        	</tr>
        </table>		
        <table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
			<tbody>
				<tr>
					<td><textarea cols="55" rows="5" id="cancelamento" name="cancelamento" style="width:100%" validate="required"><?=$cancelamento;?></textarea></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th>
						<input type="submit" name="enviar" value="Enviar" />
						<input type="reset" name="limpar" value="Limpar" />
						<input type="button" name="fechar" value="Fechar" onclick="window.close()" />
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>