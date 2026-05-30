<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.modelo_proposta.php";
include_once "../../libs/htmlArea.php";

if(!empty($_REQUEST['Salvar'])){	
	$codmodelo = modelo_proposta::modelo($_REQUEST);
	javascriptalert('Operação executada com sucesso!!!' , false );
}

	if (isset($_REQUEST['codmodelo'])){
		$codmodelo = $_REQUEST['codmodelo'];
		$acao = 'upd';
		//Faz a pesquisa no banco de dados.
		$sql = "select * ";
		$sql .= "  from modelos ";
		$sql .= " where CodModelo = $codmodelo";
		$result = sql_query($sql);
		if($row = mysql_fetch_array($result)){
			$nome = $row['Nome'];
			$style = stripslashes($row['Style']);
			$modelo = stripslashes($row['Modelo']);
		}
		mysql_free_result($result);
	}
	/*if(!(($acao == 'ins' && permissao('modelosproposta', 'ic')) || ($acao == 'upd' && permissao('modelosproposta', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Modelos</title>
	
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
</head>
<script type="text/javascript">
  _editor_url = "../../libs/htmlArea";
  _editor_lang = "pt_br";
	function validaForm(frm){
		if(!validateForm(frm)) return false
		if(!confirm("Deseja enviar os dados digitados?")){
			return false
		}
		return true
	}  
</script>
<script type="text/javascript" src="../../libs/htmlArea/htmlarea.js"></script>

<!-- Tags HTML -->

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="initEditor()">
<form id="dados" method="post" action="modelocad.php" onsubmit="return validaForm(this)">
<input type="hidden" name="codmodelo" value="<?=$codmodelo;?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Modelos
		</td>
	</tr>
</table>		
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
  <tr>
          <td>
              &nbsp;
          </td>
    </tr>
	<tr>
		<td> &nbsp;<label for="nome">Nome:</label></td>
		<td>
			<input type="text" id="nome" name="nome" value="<?=$nome;?>" size="60" maxlength="100" />
		</td>
	</tr>
	<tr>
		<td> &nbsp;<label for="nome">Estilo:</label></td>
		<td>
			<textarea id="style" name="style" rows="5" style="width:98%"><?=$style;?></textarea>
		</td>
	</tr>
			<tr bgcolor="silver" align="middle" > 
		  	<td align="center" colspan="3" class='titulo_c'> 
				<b>Observações</b>
			</td>
		</tr>
		<tr bgcolor="#ededed" align="middle" > 
		  	<td align="left" colspan="3"> 
				<textarea id="ta" name="Obsevacao" style="width:99%" rows="20" cols="20""  ></textarea>
			</td>
		</tr>

<tr>
			<td colspan="2" align="right">
				&nbsp;
			</td>
		</tr>
	<tr>
		<th colspan="2" align="right">
			<input type="submit" class="botao" value="Enviar" />&nbsp;
			<input type="button" class="botao" value="Fechar" onclick="self.close();" />&nbsp;
		</th>
	</tr>

</table>
<input type="hidden" name="textoarea">
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
