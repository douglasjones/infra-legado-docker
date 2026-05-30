<?
header('Content-Type: text/html; charset=ISO-8859-1');
include_once "../../libs/maininclude.php";
include_once "../../libs/combo.php";


 
$cod=2;
switch($cod){
	case 1:
		$html = '<select name="Imagem_new" id="Imagem_new">';
		$html .= '<option value=""></option>';
		$files = scandir('../../images/aparelhos');
		foreach($files as $file){
			if(ereg('(jpg|gif|bmp|png)$', $file)){
				$nome = explode(".",$file);
				$nome = $nome[0];
				$html .= '<option value="' . $file . '" > ' . $nome . '</option>';
			}
		}
		$html .= '</select>';?>
	<table>
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
	case 2: 
	$sql = "Select 
 				ct.CodContatoLead
				,ct.CodLead
				,ct.NomeContato
				,ct.Fone
				,ct.DDD_Fone
				,ct.Ramal_Fone
				,ct.Cel
				,ct.DDD_Cel
				,ct.Email
				,ct.CodSetorContato
				,ct.CodFuncaoContato
				,ct.id_radio
				, sc.Descricao as NomeSetor
				, fc.Descricao as NomeFuncao 
				,ct.n_rg
				,ct.n_cpf
        	From contatoslead ct
        		left join setorcontatos sc on ct.CodSetorContato = sc.CodSetorContato
        		left join funcaocontato fc on ct.CodFuncaoContato = fc.CodFuncaoContato
       		where ct.CodContatoLead = ".$_REQUEST['codcontatolead'];
		$result = sql_query($sql);
		if($row = mysql_fetch_array($result)){
			array_merge($row, $_REQUEST);
			$_REQUEST = $row;
		}
?>

<form name="upaImg" id="upaImg" action="upa.php" method="post">
<table class="form1" width="400"  border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td colspan="2">
				<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
				<tr><td class="titulo_contato">Contato</td></tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="nomecontato">Nome:</label></td>
			<td>
				<?=@$_REQUEST['NomeContato']?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="ddd_fone">Telefone:</label></td>
			<td>
				(<?=@$_REQUEST['DDD_Fone']?>)&nbsp;<?=@$_REQUEST['Fone']?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="ramal_fone">Ramal:</label></td>
			<td>
				<?=@$_REQUEST['Ramal_Fone']?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="id_nexte;">ID Radio:</label></td>
			<td>
				<?=@$_REQUEST['id_radio']?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="ddd_cel">Celular:</label></td>
			<td>
				(<?=@$_REQUEST['DDD_Cel']?>)&nbsp;<?=@$_REQUEST['Cel']?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="email">E-mail:</label></td>
			<td>
				<?=@$_REQUEST['Email']?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="n_rg">RG:</label></td>
			<td>
				<?=@$_REQUEST['n_rg']?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="n_cpf">CPF:</label></td>
			<td>
				<?=@$_REQUEST['n_cpf']?>
			</td>
		</tr>		
		<tr>
			<td>&nbsp;<label for="codsetorcontato">Setor:</label></td>
			<td>
				<?=@$_REQUEST['NomeSetor']?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codfuncaocontato">Função:</label></td>
			<td>
				<?=@$_REQUEST['NomeFuncao']?>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">
				<input type="button" value="Fechar" onclick="fecharAjax();" />&nbsp;
			</th>
		</tr>
	</tfoot>
</table>
	</form>
<?		break;
}

?>
