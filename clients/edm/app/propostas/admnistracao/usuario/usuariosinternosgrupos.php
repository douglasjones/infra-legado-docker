<?	



/*

/---------------------------------------------------\
|						    						|
|DESCRIÇÃO: PRINCIPAIS FUNÇÕES DO SISTEMA EM PHP    |
|						    						|
|					     	    					|
|REVISÕES:					    					|
|						    						|
|						    						| 
|DESESENVOLVIDO POR: DOUGLAS JONES LOPES	    	|
|						    						|
|DATA: 24/09/2008	     			    			|
\___________________G_E_P_R_O_S_____________________/

*/

include_once "../../libs/maininclude.php";
	if(!permissao('usuarios', 'ic') && !permissao('usuarios', 'al')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
	if(isset($_REQUEST['CodGrupoUsuarioInterno'])){
		$selecionados = $_REQUEST['CodGrupoUsuarioInterno'];
	}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
     <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <!--Cabeçalho-->
	<title>Grupos</title>
<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
	<script type="text/javascript" language="javascript">
		function enviar(){
			var d = opener.document.forms[0];
			var frm = document.forms[0];
			var elemento = opener.document.createElement("OPTION");
			elemento.value = frm.codgrupousuariointerno.options[frm.codgrupousuariointerno.selectedIndex].value;
			elemento.text = frm.codgrupousuariointerno.options[frm.codgrupousuariointerno.selectedIndex].text;
			try {
				d.codgrupousuariointerno.add(elemento, null);
			}catch(e) {
				d.codgrupousuariointerno.add(elemento, 0);
			}
			self.close();
		}
	</script>
</head>
<body>
	<form>
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Grupo
		</td>
	</tr>
</table>		
<table cellpadding="0" cellspacing="0" border="0" class="form">
	<tbody>
		<tr>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td><label for="codgrupousuariointerno">Selecione:</label></td>
			<td>
			<?
							$sql = "Select gu.codgrupousuariointerno,gu.Nome";
				$sql .= " from gruposusuariosinternos gu";
				$sql .= " inner join gruposusuariosinternos_usuariosinternos g on gu.codgrupousuariointerno = g.codgrupousuariointerno";
				$sql .= " where g.codusuariointerno=".$_SESSION['codusuario'];
					$result = sql_query($sql);
				$grupo = mysql_fetch_array($result);
				
			?>
			
				<select id="codgrupousuariointerno" name="codgrupousuariointerno">
				<?	
				

					$sql = "";
					$sql .= " select CodGrupoUsuarioInterno, Nome from gruposusuariosinternos where codgrupousuariointerno > 0 ";
					if(!empty($selecionados))
					$sql .= " and codgrupousuariointerno not in ($selecionados 0)";
					if ($grupo['codgrupousuariointerno']<>17){
						$sql .= " and codgrupousuariointerno not in (17)";
						
					}
					
					$sql .= " order by nome";
					$result = sql_query($sql);
					while ($row = mysql_fetch_array($result)){?>
						<option value="<?=$row['CodGrupoUsuarioInterno'];?>" ><?=$row['Nome'];?></option>
				<?	}
					mysql_free_result($result);?>
				</select>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">
					&nbsp;
				</td>
			</tr>
		</tr>
		<tr>	
			<td colspan="2" align="right">
				<input type="button" value="Enviar" onclick="enviar()" />&nbsp;
				<input type="button" value="Fechar" onclick="self.close()" />
			</td>
		</tr>
	</tfoot>
</table>
	</form>

</body>

</html>

<?	include_once "../../libs/desconectar.php";?>

