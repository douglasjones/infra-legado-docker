<?
include_once "../../libs/maininclude.php";
include_once "../../libs/combo.php";
if(!permissao('usuarios', 'cs')){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">

<!--Cabeçalho-->
<title>Pesquisar Usuários</title>
<?	include_once "../../libs/head.php";?>

<!--Comandos Javascript-->
<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>	
<script type="text/javascript" language="javascript">
function enviar(){
	var frm = document.forms[0];
	var parametros = "";
	frm.target = "pagina";
	
	parametros += 'nome='+frm.nome.value;
	parametros += '&login='+frm.login.value;
	parametros += '&tel='+frm.tel.value;
	parametros += '&emei='+frm.emei.value;
	parametros += '&email='+frm.email.value;
	parametros += '&cod_polo='+frm.cod_polo.value;
	parametros += '&codgrupousuariointerno='+frm.codgrupousuariointerno.value;
	parametros += '&coddepartamento='+frm.coddepartamento.value;
	parametros += '&codusuariosuperior='+frm.codusuariosuperior.value;
	parametros += '&cod_atividade_profissional='+frm.cod_atividade_profissional.value;
	parametros += '&desativado='+frm.desativado.value;

	opener.top.pagina.location.href = "usuariosinternosres.php?"+parametros;
	
	self.close();
}
function reload_combo(num) {

	var v = $('cod_polo').value;
	if(num==1){
		var pars = 'tipo=1' + '&cod_polo=' + v;		
		new Ajax.Updater('empresa', 'reloadcomboAjax.php', { method: 'post', parameters: pars } );		
		//var pars = 'tipo=2' + '&cod_polo=' + v;
	}
	new Ajax.Updater('div_empresa', 'reloadcomboAjax.php', { method: 'post', parameters: pars } );
}
</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" action="usuariosinternosres.php">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Pesquisar Usuários
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
		<td> &nbsp;<label for="nome">Nome Completo:</label></td>
		<td><input type="text" id="nome" name="nome" maxlength="50" size="50" /></td>
	</tr>
	<tr>
		<td> &nbsp;<label for="login">Login:</label></td>
		<td><input type="text" id="login" name="login" maxlength="15" size="15" /></td>
	</tr>
	<tr bordercolor="f5f5f5">
		<td>
			&nbsp;<label for="dat_dem">Nº Aparelho:</label>
		</td>
		<td>
			
			<input type="text" id="tel" name="tel" maxlength="9" size="10" onKeyPress="mascara(this,telefone1)" value="<?=@$_REQUEST['tel'];?>" validate="required;regexp=/^\d{4}-\d{4}$/" />					
		</td>
	</tr>
	<tr bordercolor="f5f5f5">
		<td>
			&nbsp;<label for="emei">Nº IMEI:</label>
		</td>
		<td>
			<input class="input" id="emei" name="emei" size="30" maxlength="30" value="<?=@$_REQUEST['emei'];?>" />
		</td>
	</tr>	
	<tr bordercolor="f5f5f5">
		<td>&nbsp;<label for="email">E-mail:</label></td>
		<td>
			<input type='text' id="email" size="30" maxlength="50" name="email" value="<?=@$_REQUEST['email'];?>" validate="datatype=email" />
		</td>
	</tr>		
	<tr bordercolor="f5f5f5">
		<td width="150">
			&nbsp;<label for="coddepartamento">Polo:</label>
		</td>					
		<td>
			<?	
				$sql ="";
				$sql.="select p.cod_polo, p.n_polo";
				$sql.="  from polo p ";
				combo($sql,"cod_polo", "", " ", "");
			?>
		</td>
	</tr>
	<tr bordercolor="f5f5f5">
		<td width="150">
			&nbsp;<label for="coddepartamento">Empresa:</label>
		</td>					
		<td>	
		<div id="empresa">							
		<?	
			if(!empty($_REQUEST['cod_polo'] )){
			$sql  = " Select 
					e.cod_empresa
					,case  when e.bairro is null then
						e.razao_social
					else
						concat(e.razao_social, '- ',e.bairro)
					end as empresa	
					from empresa e
						where e.cod_polo=".$_REQUEST['cod_polo'];
		    //Função combo
			combo($sql, "cod_empresa", @$_REQUEST['cod_empresa'], null, "onchange='reload_combo(1);'");
			}else{
			?>
			<select>
				<option></option>
			</select>
			<?
			}	
			?>
			</div>
		</td>
	</tr>
	<tr>
		<td> &nbsp;<label for="codgrupousuariointerno">Grupo:</label></td>
		<td>
		<?	$sql = "select codgrupousuariointerno, nome from gruposusuariosinternos order by Nome;";
		
		    //Função combo
		    combo($sql, "codgrupousuariointerno", 0, "Todos", "");?>
					</td>
				</tr>
				<tr>
					<td> &nbsp;<label for="coddepartamento">Departamento:</label></td>
					<td>
<?	$sql = "Select coddepartamento, Nome from departamento order by Nome;";
	combo($sql, "coddepartamento", 0, "Todos", "");?>
			</td>
		</tr>
		<tr bordercolor="f5f5f5">
			<td>&nbsp;<label for="codusuariosuperior">Superior:</label></td>
			<td>
				<?	
					$sql = "Select codusuariointerno, Nome, Desativado from usuariosinternos order by Desativado, Nome;";
					$tipos[0]['valor'] = '-1';
					$tipos[1]['valor'] = 1;
					$tipos[0]['style'] = 'color:#009900';
					$tipos[1]['style'] = 'color:#990000';
					$tipos['max'] = 2;
					combo_tipos($sql, "codusuariosuperior", $tipos, @$_REQUEST['CodUsuarioSuperior'], " ", null);
				?>
			</td>
		</tr>	
		<tr bordercolor="f5f5f5">					
			<td>					
				&nbsp;<label for="coddepartamento">Atividade Profissional:</label>					
			</td>										
			<td>					
			<?	$sql = "Select cod_atividade_profissional, dsc_atividade from atividade_profissional order by dsc_atividade ;";													
			    //Função combo
				combo($sql, "cod_atividade_profissional", @$_REQUEST['cod_atividade_profissional'], " ", null);?>
			</td>
		</tr>	
		<tr>
			<td> &nbsp;<label for="desativado">Status:</label></td>
			<td>
				<select name="desativado" id="desativado">
					<option value="">-- Todos --</option>
					<option value="1">Desativado</option>
					<option value="-1">Ativo</option>
				</select>
		</tr>
	</tbody>
	<tfoot>
	<tr>
			<td colspan="2" align="right">
				&nbsp;
			</td>
		</tr>
		<tr>
			<th colspan="2" align="right">
				<input type="button" value="Enviar" onclick="enviar()" />
				<input type="button" value="Fechar" onclick="self.close();" />&nbsp;
			</th>
		</tr>
	</tfoot>
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
