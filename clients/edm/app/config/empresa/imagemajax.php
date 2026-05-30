<?
header('Content-Type: text/html; charset=ISO-8859-1');
include_once "../../libs/maininclude.php";
include_once "../../libs/combo.php";

switch($_REQUEST['cod']){
	case 1:
		$html = '<select name="Imagem_new" id="Imagem_new">';
		$html .= '<option value=""></option>';
		$files = scandir('../../images/logo');
		foreach($files as $file){
			if(ereg('(jpg|gif|bmp|png)$', $file)){
				$nome = explode(".",$file);
				$nome = $nome[0];
				$html .= '<option value="' . $file . '" > ' . $nome . '</option>';
			}
		}
		$html .= '</select>';?>
	<table border="1">
		<tr>
			<td>&nbsp;<label for="login">Imagem:</label></td>
			<td><?=$html;?></td>
		</tr>
		<tr>
			<th colspan="2" align="right">
				<input type="button" value="Enviar" name="enviar" onclick="trocarImagem();"/>
				<input type="button" value="Fechar" onclick="fecharAjax();" />&nbsp;
			</th>
		</tr>
	</table>
		
<?		break;
	case 2: ?>
	<form name="upaImg" id="upaImg" action="upa.php" method="post">
	<table border="1" bordercolor="#808080">
		<tr bordercolor="#f5f5f5">
			<td>&nbsp;<label for="login">Imagem:</label></td>
			<td><input type="file" id="Imagem_new" name="Imagem_new" maxlength="50" size="30" validate="required" /></td>
		</tr>
		<tr bordercolor="#f5f5f5">
			<td colspan="2" align="right">
				<input type="button" value="Enviar" name="enviar" onclick="fazerUpload();" />
				<input type="button" value="Fechar" onclick="fecharAjax();" />&nbsp;
			</td>
		</tr>
	</table>
	</form>
<?		break;
}

?>