<?
/*
Pagina:rellinhasanaliticopesq.php
modulo:Relatorios

Dados de criação
Criação:
Empresa:
Executor

Histórico das Revisões:
 Criação: 26/06/2008
 Empresa:
 Executor RINALDO PELIGRINELI

Histórico de Auditorias:
 Criação: 16/04/2008
 Empresa:
 Executor FELIPE SANTOS
 */
/*
 Includes
*/

    include_once "../../libs/maininclude.php";
	include_once "../../libs/combo.php";

	$gerequipe = 0;
	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where Fk_Gerente = $codusuario");
	while($row = mysql_fetch_array($result)){
		$gerequipe .= ",".$row['Tk_Equipe'];
	}
	@mysql_free_result($result);

	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
<link rel="stylesheet" href="../../libs/public.css" type="text/css">
<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css" />

     <!--Cabeçalho-->
	<title>Lead Time de Fechamento</title>
<?	include_once "../../libs/head.php";?>

     <!--Comandos Javascript-->
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
	<form name="dados" method="get" action="reltimefechamentores.php" target="_blank">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo">
			Lead Time de Fechamento
		</td>
	</tr>
</table>
<table border="0" cellpadding="1" cellspacing="2" class="form">

	<tr>
		<td>
			&nbsp;<label  for="datacadastro">Polo:</label>
		</td>
		<td>
			<?if(!empty($_SESSION['cod_polo']) && $_SESSION['cod_polo'] != 100){
				//Usuario Padrao
				$sql = "";
				$sql .= "Select p.cod_polo, c.dsc_cidade from polo p";
				$sql .= " inner join cidade c on p.cod_cidade = c.cod_cidade ";
				$sql .= " where p.cod_polo=".$_SESSION['cod_polo'];
				$sql .= " Order By c.dsc_cidade ";
				$result = sql_query($sql);
				$lead = mysql_fetch_array($result);
				//combo_disabled($sql, "cod_polo", @$_SESSION['cod_polo'], " ", "disabled");
				print $lead['dsc_cidade'];
				?>
				<input type="Hidden" name="cod_polo" value="<?=$_SESSION['cod_polo']?>">
				<?
			}else{
				//Usuario Diferenciado
				$sql = "";
				$sql .= "Select p.cod_polo, c.dsc_cidade from polo p";
				$sql .= " inner join cidade c on p.cod_cidade = c.cod_cidade ";
				//$sql .= " where p.cod_polo=".$_SESSION['cod_polo'];
				$sql .= " Order By c.dsc_cidade ";
				combo($sql, "cod_polo", @$_SESSION['cod_polo'], " ", "");
			}?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="codequipe">Equipe:</label></td>
		<td>
	<?	if($gerequipe){
			$sql = "select Tk_Equipe, Vc_Nome FROM tb_equipesvendas e
					INNER JOIN usuariosinternos u ON e.Fk_Lider = u.CodUsuarioInterno
					WHERE e.Tk_Equipe in ($gerequipe)";
			combo($sql, "codequipe", "", "-- Todas --", "");
		}else{
			$sql = "select Tk_Equipe, Vc_Nome FROM tb_equipesvendas e
					INNER JOIN usuariosinternos u ON e.Fk_Lider = u.CodUsuarioInterno";
			if($GerenteContas) combo($sql, "codequipe", "", "-- Todas --", "disabled");
			else combo($sql, "codequipe", "", "-- Todas --", "");
		}
	?>
		</td>
	</tr>
				<tr style="padding-top:10px;">
					<td>&nbsp;<labell for="codgerenteconta">Consultor:</label></td>
					<td>
<?	if($gerequipe){
		$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u
				inner join leads l on u.CodUsuarioInterno = l.CodGerenteConta
				join tb_usuarioequipe ue on ue.Fk_Usuario = u.CodUsuarioInterno
				Where l.CodStatusClassificacaoLead In (4, 5, 6)
				and ue.Fk_Equipe in ($gerequipe)
				Order By Desativado, Nome";
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;
		combo_tipos($sql, "codgerenteconta", $tipos, null, "-- Todos --");
	}elseif($equipe){
		$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u
				inner join leads l on u.CodUsuarioInterno = l.CodGerenteConta
				join tb_usuarioequipe ue on ue.Fk_Usuario = u.CodUsuarioInterno
				Where l.CodStatusClassificacaoLead In (4, 5, 6)
				and ue.Fk_Equipe = $equipe
				Order By Desativado, Nome";
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;
		combo_tipos($sql, "codgerenteconta", $tipos, null, "-- Todos --");

	}elseif($GerenteContas && !permissao('leadoutrogerente', 'al')){?>
						<?=$NomeUsuario;?>
<?	}else{
		$sql = "select Distinct CodUsuarioInterno, Nome, Desativado ";
		$sql .= " from usuariosinternos u ";
		$sql .= " inner join leads l ";
		$sql .= " on u.CodUsuarioInterno = l.CodGerenteConta ";
		$sql .= " Where l.CodStatusClassificacaoLead In (4, 5, 6) ";
		$sql .= " Order By Desativado, Nome";
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;

		// Função combo_tipos
		combo_tipos($sql,"codgerenteconta", $tipos, "", "-- Todos --", "");
	}?>
					</td>
				</tr>
				<tr style="padding-top:10px;">
					<td valign="baseline">&nbsp;<labell for="faixadatasde">Data de Recebimento:</label></td>
					<td height="30" valign="baseline">
						&nbsp;<labell for="faixade">de&nbsp;</label>
						<input type="text" id="faixade" name="faixade" size="10" maxlength="10" validate="datatype=date" />
						&nbsp;<labell for="datastatusate">&nbsp;até&nbsp;</label>
						<input type="text" id="faixaate" name="faixaate" size="10" maxlength="10" validate="datatype=date" />
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2">
						<input type="button" value="Enviar" onclick="enviar()" />
						&nbsp;
						<input type="button" value="Fechar" onclick="window.close()" />
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
<? include_once "../../libs/desconectar.php"; ?>
