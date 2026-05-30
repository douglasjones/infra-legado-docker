<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/combo.php";
	
	if(!permissao('contatoslead', 'ic')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}

	$codlead = null;
	if(!empty($_REQUEST['codlead']))
		$codlead = $_REQUEST['codlead'];

	if(!empty($_REQUEST['enviar'])){
		$fields = array(
			'codlead' => $_REQUEST['codlead'],
			'nomecontato' => $_REQUEST['nomecontato'],
			'ddd_fone' => $_REQUEST['ddd_fone'],
			'fone' => $_REQUEST['fone'],
			'ramal_fone' => $_REQUEST['ramal'],
			'ddd_cel' => $_REQUEST['ddd_cel'],
			'cel' => $_REQUEST['cel'],
			'email' => $_REQUEST['email'],
			'codsetorcontato' => $_REQUEST['codsetorcontato'],
			'codfuncaocontato' => $_REQUEST['codfuncaocontato']);
		sql_query(sqlinsert('contatoslead', $fields));
		$codcontatolead = mysql_insert_id();?>
	<script type="text/javascript" language="javascript">
	var d = opener.document.forms[0]
	var elemento = opener.document.createElement("OPTION")
	elemento.value = <?=$codcontatolead;?>;
	elemento.text = "<?=$_REQUEST['nomecontato'];?>"
	try	{
		d.codcontatolead.add(elemento, null)
	}catch(e){
		d.codcontatolead.add(elemento, 0)
	}
	d.codcontatolead.selectedIndex = d.codcontatolead.options.length - 1
	self.close()
	function consulta_np_telefone_contato(){
		var frm = document.forms['formcontato'];
		var strTelefone = frm.ddd_fone.value+""+frm.fone.value.replace("-","");
		if(strTelefone.length >= 10)
			xajax_buscar_nao_perturbe(strTelefone, "tel_contato_descricao_bloqueado", 'tel_contato_bloqueado');
	}
	function consulta_np_celular_contato(){
		var frm = document.forms['formcontato'];
		var strTelefone = frm.ddd_cel.value+""+frm.cel.value.replace("-","");
		if(strTelefone.length >= 10)
			xajax_buscar_nao_perturbe(strTelefone, "celular_contato_descricao_bloqueado", 'cel_contato_bloqueado');
	}
	</script>
<?	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
<head>
	<title>Adicionar Contato</title>
	<script language="javascript" src="../../extras/mascaras.js"></script>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
function gravarContato(frm){
	if(!validateForm(frm)) return false
	return true;
}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form id="dados" method="post" action="leadsagendacontatos.php" onsubmit="return gravarContato(this)">
		<input type="hidden" id="codlead" name="codlead" value="<?=$codlead;?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Agendamento
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
			<td>  &nbsp;  &nbsp; <label for="nomecontato">Nome:</label></td>
			<td>
				<input type="text" id="nomecontato" name="nomecontato" maxlength="50" size="25" validate="required" />
			</td>
		</tr>
		<tr>
			<td>  &nbsp;  &nbsp; <label for="ddd_fone">Telefone:</label></td>
			<td>
				(<input type='text' id="ddd_fone" name='ddd_fone' value="" size="2" onblur="consulta_np_telefone_contato()" onKeyPress="mascara(this,soNumeros)" maxlength="2" validate="regexp=/^\d{2}$/" />
				)&nbsp;<input type="text" id="fone" name="fone" value="" size="11" maxlength="10" onblur="consulta_np_telefone_contato()" onKeyPress="mascara(this,telefone1)" validate="datatype=tel" />
				<input type="hidden" id="tel_contato_bloqueado" name="tel_contato_bloqueado" value="">
				
			</td>
		</tr>
		<tr>
			<td>  &nbsp;  &nbsp; <label for="ramal">Ramal:</label></td>
			<td>
				<input type="text" id="ramal" name="ramal" size="5" maxlength="5" />
			</td>
		</tr>
		<tr>
			<td>  &nbsp;  &nbsp; <label for="ddd_cel">Celular:</label></td>
			<td>
				(<input type='text' id="ddd_cel" name='ddd_cel' value="" size="2" onblur="consulta_np_celular_contato()" onKeyPress="mascara(this,soNumeros)" maxlength="2" validate="regexp=/^\d{2}$/" />
				)&nbsp;<input type="text" id="cel" name="cel" value="" size="11" maxlength="10" onblur="consulta_np_celular_contato()" onKeyPress="mascara(this,telefone1)" validate="datatype=tel" />
				<input type="hidden" name="cel_contato_bloqueado" id="cel_contato_bloqueado" value="">
				
			</td>
		</tr>
		<tr>
			<td>  &nbsp;  &nbsp; <label for="email">E-mail:</label></td>
			<td>
				<input type='text' id="email" size="25" maxlength="50" name="email" validate="datatype=email" />
			</td>
		</tr>
		<tr>
			<td>  &nbsp;  &nbsp; <label for="codsetorcontato">Setor:</label></td>
			<td>
<?	$sql = "Select codsetorcontato, descricao from setorcontatos order by descricao;";
combo($sql,"codsetorcontato", "", " ", "");?>
			</td>
		</tr>
		<tr>
			<td>  &nbsp;  &nbsp; <label for="codfuncaocontato">Função:</label></td>
			<td>
<?	$sql = "select CodFuncaoContato, Descricao from funcaocontato order by Descricao";
combo($sql,"codfuncaocontato",""," ","");?>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="submit" name="enviar" value="Enviar" />
				<input type="Button" value="Fechar" onclick="self.close();" />&nbsp;
			</td>
		</tr>
	</tfoot>
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
