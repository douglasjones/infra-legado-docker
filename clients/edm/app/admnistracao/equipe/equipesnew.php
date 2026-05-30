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
	include_once "../../libs/combo.php";
	include_once "../../libs/grid.php";
	include_once "../../libs/cla.equipes.php";

	$codequipe = null;
	$nome = null;
	$lider = null;
	$acao = "ins";

	if (!empty($_REQUEST['codequipe'])){
		$codequipe = $_REQUEST['codequipe'];
		$acao = "upd";
		
		//Faz a pesquisa no banco de dados.
		$sql = "select * from tb_equipesvendas where Tk_Equipe = $codequipe";
		$result = sql_query($sql);
		if($row = mysql_fetch_array($result)){
			$nome = $row['Vc_Nome'];
			$lider = $row['Fk_Lider'];
			$gerente = $row['Fk_Gerente'];
		}
		mysql_free_result($result);
	}
	if(!(($acao == 'ins' && permissao('equipes', 'ic')) || ($acao == 'upd' && permissao('equipes', 'al')))){
		//javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">

    <!--Cabeçalho-->
	<title>Equipes</title>
<?	include_once "../../libs/head.php";?>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<script type="text/javascript" language="javascript" src="../../extras/equipes.js"></script>
	<form name="dados" method="post" action="equipescad.php">
		<input type="hidden" name="codequipe" value="<?=$codequipe;?>" />
		<input type="hidden" name="acao" value="<?=$acao?>" />
		
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Equipes
		</td>
	</tr>
</table>		
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tbody>
   	<tr>
          <td>&nbsp;
              
          </td>
    </tr>
	<tbody>
		<tr>
			<td>&nbsp;<label for="nome">Nome:</label></td>
			<td><input type="text" name="nome" value="<?=$nome;?>" maxlength="50" size="25" validate="required" /></td>
		</tr>
		<tr>
			<td>&nbsp;<label for="descricao">Supervisor:</label></td>
			<td>
<?	$sql = "Select codusuariointerno AS lider, Nome, Desativado from usuariosinternos order by Desativado, Nome;";
$tipos[0]['valor'] = '-1';
$tipos[1]['valor'] = 1;
$tipos[0]['style'] = 'color:#009900';
$tipos[1]['style'] = 'color:#990000';
$tipos['max'] = 2;
combo_tipos($sql, "lider", $tipos, $lider, " ", null);?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="gerente">Gerente:</label></td>
			<td>
<?	$sql = "Select codusuariointerno AS gerente, Nome, Desativado from usuariosinternos order by Desativado, Nome;";
$tipos[0]['valor'] = '-1';
$tipos[1]['valor'] = 1;
$tipos[0]['style'] = 'color:#009900';
$tipos[1]['style'] = 'color:#990000';
$tipos['max'] = 2;
combo_tipos($sql, "gerente", $tipos, $gerente, " ", null);?>
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
				<input type="submit" value="Enviar" />
				<input type="button" value="Fechar" onclick="self.close();" />&nbsp;
			</th>
		</tr>
	</tfoot>
</table>
	</form>
<?
if ($codequipe){
	$equipe = equipes::get_equipe($codequipe);
	grid($equipe, "codusr", "Participante", "usuario");
?>
	<table border="0" cellpadding="0" cellspacing="0" >
		
			<tr  align="center">
				<td >
					<form name="ins_usuarios" method="post" action="javascript:UserIns(<?=$codequipe;?>)">
						<input type="submit" class="button"  value="Adicionar" />
					</form>
				</td>
				<td>
					<form name="del_usuarios" class="button" method="post" action="javascript:UserDel(getSel())">
						<input type="submit" value="Deletar" />
					</form>
				</td>
			</tr>
		
	</table>
<? } ?>
</body>
</html>
<? include_once "../../libs/desconectar.php";?>
