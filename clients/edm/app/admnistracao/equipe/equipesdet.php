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
	include_once "../../libs/cla.equipes.php";
	//if(!permissao('equipes', 'dt')){
	//	javascriptalert('Você não tem permissão para acessar esta página!!!');
	//	exit;
	//}

	$codpagina = null;
	$nome = null;
	$descricao = null;

	if (!empty($_REQUEST['codequipe'])){
		$codequipe = $_REQUEST['codequipe'];
		$equipe = equipes::get_equipe($codequipe);
		$sql = "SELECT eq.Vc_Nome AS equipe,
				u.Nome as lider
				FROM tb_equipesvendas AS eq 
				INNER JOIN  usuariosinternos AS u
				ON u.CodUsuarioInterno = eq.Fk_lider
				WHERE eq.Tk_Equipe = $codequipe";
		$query = sql_query($sql);
		$result = mysql_fetch_array($query);
		$nomeequipe = $result['equipe'];
		$lider = $result['lider'];
		mysql_free_result($query);
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    
    <!--Cabeçalho-->
	<title>Equipe</title>
<?	include_once "../../libs/head.php";?>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<table border="0" cellpadding="0" cellspacing="0" class="form">
		<thead>
			<tr>
				<th colspan="2">Equipe: <?=$nomeequipe?></th>
			</tr>
			<tr>
				<td>Lider:</th>
				<td><?=$lider;?></td>
			</tr>
		</thead>
		<tbody>
<?	while($row = mysql_fetch_array($equipe)){?>
			<tr>
				<td>Participante:</td>
				<td><?=$row['usuario'];?></td>
			</tr>
<?	}?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2">
					<input type="Button" value="Fechar" onclick="self.close();" />
				</th>
			</tr>
		</tfoot>
	</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
