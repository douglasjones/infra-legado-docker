<?
/*
Pagina:relfollowuppesq.php
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
	@mysql_free_result($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css" />
    <!--Cabeçalho-->
    <title>Relatório de FollowUp de Leads</title>
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
    <link href="../../extras/public.css" rel="stylesheet" type="text/css" />
</head>
    <!--HTML-->
    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form name="dados" method="get" action="relfollowupleadsres.php" target="_blank">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
Relatório de FollowUp de Leads		</td>
	</tr>
</table>		
<table border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="2">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label  for="datacadastro">Polo:</label>
		</td>
		<td>
		<?	if(!empty($_SESSION['cod_polo']) && $_SESSION['cod_polo'] != 100){
				//Usuario Padrao
				$sql = "Select p.cod_polo, c.dsc_cidade from polo p";
				$sql .= " inner join cidade c on p.cod_cidade = c.cod_cidade ";
				$sql .= " where p.cod_polo=".$_SESSION['cod_polo'];
				$sql .= " Order By c.dsc_cidade ";
				$result = sql_query($sql);
				$lead = mysql_fetch_array($result);
				echo $lead['dsc_cidade'];
				?>
				<input type="Hidden" name="cod_polo" value="<?=$_SESSION['cod_polo']?>">
				<?
			}else{
				//Usuario Diferenciado
				$sql = "Select p.cod_polo, c.dsc_cidade from polo p";
				$sql .= " inner join cidade c on p.cod_cidade = c.cod_cidade ";
				$sql .= " Order By c.dsc_cidade ";
				combo($sql, "cod_polo", @$_SESSION['cod_polo'], " ", "");
			}?>
		</td>
	</tr>
		<tr>
			<td>&nbsp;<label for="codequipe">Equipe:</label></td>
			<td>
<?	$d = "";
	$sql = "SELECT eq.Tk_Equipe AS cod, eq.Vc_nome AS equipe FROM tb_equipesvendas eq
			INNER JOIN usuariosinternos u ON u.CodUsuarioInterno = eq.Fk_lider WHERE 1";
	if($gerequipe)
		$sql .= " AND Tk_Equipe in ($gerequipe)";
	elseif($equipe)
		$sql .= " AND Tk_Equipe = $equipe";
	elseif($GerenteContas)
		$d = "disabled";
	// Função combo
	combo($sql,"codequipe", "", "-- Todas --", $d); ?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
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

	}elseif($GerenteContas && !permissao('leadoutrogerente', 'al')){
		echo $NomeUsuario;
	}else{
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
		<tr>
			<td colspan="2">
			<!--<input name="tgt" id="tgt" type="checkbox" />Tgt &nbsp;-->
			<input name="led0" id="led0" type="checkbox" />0% &nbsp;
			<input name="led25" id="led25" type="checkbox" />25% &nbsp;
			<input name="led50" id="led50" type="checkbox" />50% &nbsp;
<?			if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip'){ ?>
			<input name="for75env" id="for75env" type="checkbox" onclick="document.getElementById('for75nao').checked=false;" />75% (Enviado Claro) &nbsp;
<?			} ?>
			<input name="for75nao" id="for75nao" type="checkbox" onclick="document.getElementById('for75env').checked=false;" />75% <?			if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip'){ ?>(N&atilde;o Enviado Claro)<? }else{ ?> &nbsp; <? } ?>
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
