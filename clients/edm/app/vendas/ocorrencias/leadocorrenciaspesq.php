<?

    include_once "../../libs/maininclude.php";
	include_once "../../libs/combo.php";
include_once "../../libs/cla.combo.php";
	include_once( "../../libs/cla.comboajax.php" ) ;	
	if(!permissao('ocorrencias', 'cs')){
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
	<title>Ocorrêcias Lead</title>
<?	include_once "../../libs/head.php";?>

    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		var frm = document.forms[0]
		if(!validateForm(frm)) return false
		frm.submit()
		self.close()
		return true
	}
	</script>

    </head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" target="pagina" action="leadocorrenciares.php">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Pesquisar&nbsp;Ocorrência
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
			<td>&nbsp;<label for="codocorrencialead">Código:</label></td>
			<td><input type="text" id="codocorrencialead" name="codocorrencialead" size="5" maxlength="10" onkeypress="mascara(this,soNumeros)" validate="datatype=numeric" /></td>
		</tr>
		<tr>
			<td>&nbsp;<label for="nomefantasia">Lead:</label></td>
			<td><input type="text" id="nomefantasia" name="nomefantasia" class="texto" size="50" maxlength="60" /></td>
		</tr>
		<tr>
			<td>&nbsp;<label for="mailing">Mailing:</label></td>
				<td>
				<?combo::combo_mailing($mailing_pk);?>
				</td>
				</tr>
				<tr>
					<td><label for="gerentecontas">&nbsp;Equipe:</label></td>
					<td>
						<?combo::equipe($codequipe);?>
					</td>
				</tr>
				<tr>
					<td><label for="gerentecontas">&nbsp;Consultor:</label></td>
					<td>
					<?	combo::consultor_equipe1($_SESSION['codusuario']);?>
					</td>
				</tr>	
				<tr>
					<td><label for="atendente">&nbsp;Atendente:</label></td>
					<td>
					<?	combo::atendente_equipe1($_SESSION['codusuario']);?>
					</td>
				</tr>			
				<tr>
					<td>&nbsp;<label for="codtipoocorrencialead">Tipo da Ocorrência:</label></td>
					<td>
<?					$sql = "SELECT CodTipoOcorrenciaLead, t.Descricao FROM tipoocorrenciaslead t";
					$sql .= " where (t.cod_operador is null or cod_operador = 0 or cod_operador in (Select cod_operador from empresa_operador) )";		
					$sql .= " Order by t.Descricao";
					
					combo($sql, "codtipoocorrencialead", $codtipoocorrencialead, " ", " ");?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						&nbsp;<label for="semretorno">
							<input type="checkbox" id="semretorno" name="semretorno" value="1" />
							Não incluir ocorrências de retorno
						</label>
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="codusuariointerno">Usuário de Cadastro:</label></td>
					<td>
<?	$sql = "Select Distinct ui.CodUsuarioInterno,ui.Nome,ui.Desativado";
	$sql .= " From usuariosinternos ui left join ocorrenciaslead o ";
	$sql .= " on ui.CodUsuarioInterno = o.CodUsuarioInterno ";
	$sql .= " Order by ui.Desativado, ui.Nome";
	$tipos[0]['valor'] = '-1';
	$tipos[1]['valor'] = 1;
	$tipos[0]['style'] = 'color:#009900';
	$tipos[1]['style'] = 'color:#990000';
	$tipos['max'] = 2;
	
	/* Função combo */
	combo_tipos($sql,"codusuariointerno",$tipos,$_SESSION['codusuario']," ","");?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="codgrupousuariointerno">Grupo de Usuário:</label></td>
					<td>
<?	$sql = "Select Distinct g.CodGrupoUsuarioInterno,g.Nome";
	$sql .= " From gruposusuariosinternos g";
	$sql .= " Order by g.Nome";
	combo($sql,"codgrupousuariointerno",""," ","");?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="dataini">Período da Ocorrência:</label></td>
					<td>&nbsp;<label for="dataini"> de </label><input type="text" id="dataini" name="dataini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />&nbsp;<label for="datafim">&nbsp; a </label><input type="text" id="datafim" name="datafim" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" /></td>
				</tr>
				<tr>
					<td>&nbsp;<label for="aberta">Status:</label></td>
					<td>
						<input type="checkbox" checked="checked" id="aberta" name="aberta" value="1" />&nbsp;<label for="aberta">aberta</label>&nbsp;
						<input type="checkbox" checked="checked" id="fechada" name="fechada" value="1" />&nbsp;<label for="fechada">fechada</label>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2" align="right">&nbsp;
						
					</td>
				</tr>
				<tr>
					<th colspan="2" align="right">
						<input type="button" value="Enviar" onclick="enviar();" />
						<input type="button" value="Fechar"  onclick="window.close()" />&nbsp;
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
