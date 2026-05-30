<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.email.php";
include_once "../../libs/combo.php";
if(!empty($_REQUEST['Enviar'])){	

	//Diretório aonde ficará os arquivos
	$dir = "../../operacao/email/";
	
	//Extensões permitidas
	$ext = array("gif","jpg","png","pdf","html");
	
	//Quant. de campos do tipo FILE
	$campos = 1;
	
	//Obtendo info. dos arquivos
	$f_name = $_FILES['file']['name'];
	$f_tmp = $_FILES['file']['tmp_name'];
	$f_type = $_FILES['file']['type'];
	
	//Contar arquivos enviados
	$cont=0;

	//Repetindo de acordo com a quantidade de campos FILE
	for($i=0;$i<$campos;$i++){
		
		//Pegando o nome
		$name = $f_name[$i];
	
		//Verificando se o campo contem arquivo
	  if ( ($name!="") and (is_file($f_tmp[$i])) and (in_array(substr($name, -3),$ext)) ) {	
	      //Movendo arquivo's do upload
	      $up = move_uploaded_file($f_tmp[$i], $dir.$name);	
	      echo "";
	  }	
	}
		if(!empty($_REQUEST['cod_email_empresa'])){
			if(!empty($name)){
				$_REQUEST['anexo'] = $name;
			}
			email::alterar($_REQUEST);
		}else{
			$_REQUEST['anexo'] = $name;
			email::cadastrar($_REQUEST);
		}
		javascriptalert('Operação executada com sucesso!!!');	
}

if(!empty($_REQUEST['cod_email_empresa'])){
	$sql = "Select 
			  e.cod_email_empresa
			  ,e.cod_tipoemail
			  ,e.email_saida
			  ,e.email_assunto
			  ,e.codtipoocorrencialead
			  ,e.anexo
			  ,e.status
			  ,e.email_texto 	
			  ,e.identificacao
			from email_empresa e
			where e.cod_email_empresa=".$_REQUEST['cod_email_empresa'];
			
			$result = sql_query($sql);
			if($row = mysql_fetch_array($result)){
				array_merge($row, $_REQUEST);
				$_REQUEST = $row;
			}
			$nome_anexo = @$_REQUEST['anexo'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>

<!--Cabeçalho-->
<title>Aparelhos</title>
	
<?	include_once "../../libs/head.php";?>
<script type="text/javascript" src="../../extras/micoxUpload.js"></script>
<script>

</script>
<form method="post" action="<?=$PHP_SELF?>" enctype="multipart/form-data"  onSubmit="return validateForm(this)"> 
<input type="hidden" name="cod_email_empresa" value="<?=$_REQUEST['cod_email_empresa'];?>" />
	<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
		<tr>
			 <td  class="titulo"> 
				&nbsp;Configuração Email
			</td>
		</tr>
	</table>	
	<table width="100%"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">

		<tr>
			<td width=200>&nbsp;<label for="imagem">Status:</label></td>
			<td  align="left">
				<select name="status">
					<option value="1" <?if(@$_REQUEST['status']==1){?>selected="selected"<?}?>>Ativo</option>
					<option value="2"  <?if(@$_REQUEST['status']==2){?>selected="selected"<?}?>>Desativado</option>
				</select>
			</td>
		</tr>	
		<tr>
			<td width=200>&nbsp;<label for="imagem">Tipo Email:</label></td>
			<td  align="left">
				<?
					$sql = "Select
							te.cod_tipoemail
							,te.n_tipoemail
							from tipo_email te
							where te.dt_canc is null
							order by te.cod_tipoemail";
					combo($sql, "cod_tipoemail", @$_REQUEST['cod_tipoemail'], " ", 'validate="required"');
				?>
			</td>
		</tr>
		<tr>
			<td width=200>&nbsp;<label for="imagem">Modelo:</label></td>
			<td  align="left">
				<input type="Text" name="identificacao" size="50" maxlength="80" validate="required"value="<?=@$_REQUEST['identificacao'];?>">
			</td>
		</tr>			
		<tr>
			<td width=200>&nbsp;<label for="imagem">Email de Saída:</label></td>
			<td align="left">
				<input type="Text" name="email_saida" size="50" maxlength="80" validate="required"value="<?=@$_REQUEST['email_saida'];?>">
			</td>
		</tr>
		<tr>
			<td width=200>&nbsp;<label for="imagem">Assunto:</label></td>
			<td align="left">
				<input type="Text" name="email_assunto" size="50" maxlength="80" validate="required"' value="<?=@$_REQUEST['email_assunto'];?>">
			</td>
		</tr>	
		<tr>
			<td width=200>&nbsp;<label for="imagem">Ocorrência:</label></td>
			<td  align="left">
				<?
					$sql = "Select 
							o.CodTipoOcorrenciaLead
							,o.Descricao
							from tipoocorrenciaslead o
							order by o.Descricao";
				combo($sql, "codtipoocorrencialead", @$_REQUEST['codtipoocorrencialead'], " ", "");
				?>
			</td>
		</tr>	
		<tr>
			<td>&nbsp;Anexar Arquivo</td>
			<td><input type="file" name="file[]">&nbsp;<b><?if(!empty($nome_anexo)){?>&nbsp;Arquivo Anexado&nbsp;=&nbsp;<?=$nome_anexo;?><?}?></b></td>
		</tr>
		<tr>
			<td width=200>&nbsp;<label for="imagem">Corpo do Email:</label></td>
			<td align="left">
				<textarea name="email_texto" rows="20" cols="100"><?=@$_REQUEST['email_texto'];?></textarea>
			</td>
		</tr>			
		<tr>
			<th colspan="2" align="right">
				<input type="Submit" value="Enviar" name="Enviar" />&nbsp;
			</th>
		</tr>
	</table>
	</form>
</head>	
</html>	
