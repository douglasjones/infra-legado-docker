<?

    include_once "../../libs/maininclude.php";
	include_once "../../libs/datas.php";
	include_once "../../libs/cla.agendaslead.php";
	include_once "../../libs/combo.php";
	
	$acao = null;
	$codagendalead = null;
	$qualityservice = null;
	
	if(!empty($_REQUEST['codagendalead']))
		$codagendalead = $_REQUEST['codagendalead'];
	
	if(!empty($_REQUEST['enviar'])){
		agendaslead::qualityservice($codagendalead, $_REQUEST['qualityservice']);
		javascriptalert('Operação executada com sucesso!!!');
	}else{
		if(!empty($codagendalead)){
			$acao = "upd";
			//Traz os dados da agenda.
			$sql = "select a.*";
			$sql .= " from agendaslead a";
			$sql .= " where a.CodAgendaLead = $codagendalead ";
			$result = sql_query($sql);
			if($row = mysql_fetch_array($result)){
				$qualityservice = $row['QualityService'];
			}else
				exit();
			$acao = (empty($qualityservice)?'ins':'upd');
			mysql_free_result($result);
		}
	}
	if(!(($acao == 'ins' && permissao('qualityservice', 'ic')) || ($acao == 'upd' && permissao('qualityservice', 'al')))){
		//javascriptalert('Você não tem permissão para acessar esta página!!!', false);
		//exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

 	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
    <!--Cabeçalho-->
	<title>Ativo - Quality Service</title>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
function validaCampos(){
	if(!validateForm(document.forms[0])) return false
	return true
}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="post" action="leadsagendaqualityservice.php" onsubmit="return validaCampos(this)">
<input type="hidden" id="codagendalead" name="codagendalead" value="<?=$codagendalead;?>" />
<table width="98%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Ativo - Quality Service
		</td>
	</tr>
</table>		
<table width="98%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">

				<tr>
          <td>
              &nbsp;
          </td>
    </tr>

		<tr>
			<td><textarea cols="55" rows="5" id="qualityservice" name="qualityservice" style="width:100%" validate="required"><?=$qualityservice;?></textarea></td>
		</tr>
		<tr>
          <td>
              &nbsp;
          </td>
    	</tr>
		<tr>
			<td align="right">
				<input type="submit" name="enviar" value="Enviar" />
				<input type="reset" name="limpar" value="Limpar" />
				<input type="button" name="fechar" value="Fechar" onclick="window.close()" />&nbsp;
			</td>
		</tr>
	</tfoot>
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
