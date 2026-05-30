<?
    include_once "libs/maininclude.php";
    include_once "libs/pwcr.php";

	if(!empty($_REQUEST['codusuariointerno']))

		$codusuariointerno = $_REQUEST['codusuariointerno'];



	$senha1 = null;

	$senha2 = null;

	$mensagem = null;

	if(!empty($_REQUEST['senha1']) && !empty($_REQUEST['senha2'])){

		$senha1 = $_REQUEST['senha1'];

		$senha2 = $_REQUEST['senha2'];

		if($senha1 != $senha2){

			$mensagem = "<script type='text/javascript'>";

			$mensagem .= "alert('Senhas não coincidem.');";

			$mensagem .= "document.forms[0].senha1.focus();";

			$mensagem .= "</script>";

		}

		if(empty($mensagem)){

			$sql = sqlupdate('usuariosinternos', array('Senha' => pwcrypt($senha1)), 'CodUsuarioInterno = ' . mysqlnull($codusuariointerno));

			sql_query($sql);

			$mensagem = "<script type='text/javascript'>";

			$mensagem .= "alert('Operação executada com sucesso.');";

			$mensagem .= 'parent.location.href = "index.php";';

			$mensagem .= "</script>";

		}

	}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<head>

    <!--Include CSS-->

    <link rel="stylesheet" href="extras/public.css" type="text/css">

    

    <!--Cabeçalho-->

	<title>Alterar Senha do Usuário</title>

<?	include_once "libs/head.php";?>



    <!--Comandos Javascript-->

	<script type="text/javascript" language="javascript" src="extras/prototype.js"></script>
	<script type="text/javascript" language="javascript">

		function validaForm(frm)

		{

			if(!validateForm(frm)) return false

			if(frm.senha1.value != frm.senha2.value)

			{

				alert("Senhas não coincidem.");

				frm.senha1.focus();

				return false;

			}

			return true;

		}

	</script>

</head>

<!--HTML-->

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div align="center" style="position:absolute; width:300px; height:200px; top:15%; left:50%; margin-left:-150px">
	<form method="post" action="" onsubmit="return validaForm(this)">

		<input type="hidden" name="codusuariointerno" value="<?=$codusuariointerno;?>" />

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">

	<tr>

		 <td  class="titulo"> 

			&nbsp;Alterar Senha

		</td>

	</tr>

</table>		

<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">

	<tbody>

   	<tr>

          <td>&nbsp;

              

          </td>

    </tr>

		<tr>

			<td>&nbsp;<label for="senha1">Nova Senha:</label></td>

			<td><input type="password" id="senha1" name="senha1" value="<?=$senha1;?>" maxlength="15" size="15" validate="required" /></td>

		</tr>

		<tr>

			<td>&nbsp;<label for="senha2">Repetir nova senha:</label></td>

			<td><input type="password" id="senha2" name="senha2" value="<?=$senha2;?>" maxlength="15" size="15" validate="required" /></td>

		</tr>

	</tbody>



		<tr>

			<td colspan="2" align="right">&nbsp;

				

			</td>

		</tr>

		<tr>

			<td colspan="2" align="right">

				<input type="submit" class="botao" value="Enviar" />

			</td>

		</tr>



</table>

	</form>
</div>
	<?=$mensagem;?>

</body>

</html>

<?	include_once "libs/desconectar.php";?>

