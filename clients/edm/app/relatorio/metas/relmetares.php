<?
    /*
Pagina:relmetasres.php
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
	include_once "../../libs/datas.php";
	include_once "../../libs/cla.relmeta.php";

	if($GerenteContas && !permissao('leadoutrogerente', 'al')){
		$gerenteconta = $_SESSION['codusuario'];
	}
	else {
		$gerenteconta = (@$_REQUEST['codgerenteconta']?$_REQUEST['codgerenteconta']:null);
	}
	$faixade		= (@$_REQUEST['faixade']?$_REQUEST['faixade']:null);
	$faixaate		= (@$_REQUEST['faixaate']?$_REQUEST['faixaate']:null);
	$faixade2		= (@$_REQUEST['faixade2']?$_REQUEST['faixade2']:null);
	$faixaate2		= (@$_REQUEST['faixaate2']?$_REQUEST['faixaate2']:null);
	$codequipe		= (@$_REQUEST['codequipe']?$_REQUEST['codequipe']:null);
	
	if($faixade){
		$faixade		= explode('/', $faixade);
		$faixade		= strtotime($faixade[1].'/'.$faixade[0].'/'.$faixade[2]);
	}
	
	if($faixaate){
		$faixaate		= explode('/', $faixaate);
		$faixaate		= strtotime($faixaate[1].'/'.$faixaate[0].'/'.$faixaate[2]);
	}

	if($faixade2){
		$faixade2		= explode('/', $faixade2);
		$faixade2		= strtotime($faixade2[1].'/'.$faixade2[0].'/'.$faixade2[2]);
	}
	
	if($faixaate2){
		$faixaate2		= explode('/', $faixaate2);
		$faixaate2		= strtotime($faixaate2[1].'/'.$faixaate2[0].'/'.$faixaate2[2]);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">
    
    <?	include_once "../../libs/head.php";?>

    <!-- Formatação CSS -->
	<style>
	.recebimento {
		color: blue;
	}
	.recebimento a:link, .recebimento a:visited {
		color: blue;
	}
	a:link, a:visited {
		color: black;
		text-decoration: none;
	}
	a:hover {
		color: blue;
		text-decoration: underline;
	}
	
	td, th {
		white-space: nowrap;
	}
	</style>
</head>

    <!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório de Metas
		</td>
	</tr>
</table>	
<table width="800" align="center"  height="30"    cellpadding="0" cellspacing="0">
	<tr>
		 <td  >&nbsp; 
			
		</td>	
	</tr>
</table>	
<table width="800"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td class="parametros">
			Parâmetros 
		</td>
	</tr>
	<tr>
		<td class="parametros">
				Relatório gerado em <?=date('d/m/Y \à\s H:i', mktime());?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
<?	if(!empty($_REQUEST['cod_polo'])){
		$sql = "Select p.cod_polo, c.dsc_cidade from polo p";
		$sql .= " inner join cidade c on p.cod_cidade = c.cod_cidade ";
		$sql .= " where p.cod_polo=".$_REQUEST['cod_polo'];
		$sql .= " Order By c.dsc_cidade ";
		$q = mysql_query($sql);
		$polo = mysql_fetch_array($q);
		echo "Polo: ".$polo['dsc_cidade'];
	}?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
<?	if(!empty($gerenteconta)){?>
			Usuários:
<?		if($gerenteconta == 'all'){ ?>
				Todos
<?		}elseif($gerenteconta == 'allat'){ ?>
				Todos Atendentes
<?		}elseif($gerenteconta == 'allgc'){ ?>
				Todos Consultores
<?		}else{
			$sql = "Select Nome From usuariosinternos Where CodUsuarioInterno = " . mysqlnull($gerenteconta);
			$res1 = sql_query($sql);
			while($row = mysql_fetch_array($res1)){?>
				<?=$row['Nome'];?>
<?			}
			mysql_free_result($res1);
		}
	}
	if(!empty($faixade) && !empty($faixaate)){?>
			<dt>Faixa de Datas do Recebimento da Assinatura:</dt>
				<dd><?=date('d/m/Y', $faixade);?> até <?=date('d/m/Y', $faixaate);?></dd>
<?	}else if(!empty($faixade)){?>
			<dt>Data do Recebimento da Assinatura A Partir de:</dt>
				<dd><?=date('d/m/Y', $faixade);?></dd>
<?	}else if(!empty($faixaate)){?>
			<dt>Data do Recebimento da Assinatura Até:</dt>
				<dd><?=date('d/m/Y', $faixaate);?></dd>
<?	}
	if(!empty($faixade2) && !empty($faixaate2)){?>
			<dt>Faixa de Datas de Entrega de Aparelhos:</dt>
				<dd><?=date('d/m/Y', $faixade2);?> até <?=date('d/m/Y', $faixaate2);?></dd>
<?	}else if(!empty($faixade2)){?>
			<dt>Entrega de Aparelhos A Partir de:</dt>
				<dd><?=date('d/m/Y', $faixade2);?></dd>
<?	}else if(!empty($faixaate2)){?>
			<dt>Entrega de Aparelhos Até a Data:</dt>
				<dd><?=date('d/m/Y', $faixaate2);?></dd>
<?	}?>
		</td>
	</tr>
</table>	
<table cellspacing="0" cellpadding="0" align="center" width="800" border="1" >	
			<tr>
<?	if($gerenteconta == 'allat'){?>
				<td class="font_grid" width="560">Atendente</td>
				<td class="font_grid" width="80">Meta</td>
				<td class="font_grid" width="80">Atingido</td>
				<td class="font_grid" width="80"></td>
<?	}elseif($gerenteconta == 'allgc'){?>
				<td class="font_grid" width="560">Consultor</td>
				<td class="font_grid" width="80">Meta</td>
				<td class="font_grid" width="80">Linhas Novas</td>
				<td class="font_grid" width="80">Renovação</td>
<?	}else{ ?>
				<td class="font_grid" width="560">Usu&aacute;rio</td>
				<td class="font_grid" width="80">Meta</td>
				<td class="font_grid" width="80">Linhas Novas</td>
				<td class="font_grid" width="80">Renovação</td>
<?	} ?>
			</tr>
<?	$totalmeta = 0;
	$totalatingido = 0;
	$sql = "SELECT e.* FROM tb_equipesvendas e INNER JOIN usuariosinternos u ON e.Fk_Lider = u.CodUsuarioInterno WHERE 1";
	if($gerenteconta == 'allat') $sql .= " AND u.Atendente = 1";
	if($gerenteconta == 'allgc') $sql .= " AND u.GerenteContas = 1";
	if($codequipe) $sql .= " AND Tk_Equipe = $codequipe";
	if($_REQUEST['cod_polo'] != 100 && !empty($_REQUEST['cod_polo']))
		$sql .= " AND cod_polo = ".$_REQUEST['cod_polo'];
	$query = mysql_query($sql);
	while($eqp = mysql_fetch_array($query)){?>
		<td class="parametros1" colspan="4">Equipe:<?=$eqp['Vc_Nome'];?></td><?
		$eqpmeta = 0;
		$eqpatingido = 0;
		$eqprenova = 0;
		if($gerenteconta == 'all'){
			$sql = "SELECT CodUsuarioInterno, Nome FROM usuariosinternos WHERE (Atendente = 1 OR GerenteContas = 1) AND Desativado <> 1";
		}elseif($gerenteconta == 'allat'){
			$sql = "SELECT CodUsuarioInterno, Nome FROM usuariosinternos WHERE Atendente = 1 AND Desativado <> 1";
		}elseif($gerenteconta == 'allgc'){
			$sql = "SELECT CodUsuarioInterno, Nome FROM usuariosinternos WHERE GerenteContas = 1 AND Desativado <> 1";
		}else{
			$sql = "SELECT Nome FROM usuariosinternos WHERE CodUsuarioInterno = ".mysqlnull($gerenteconta);
		}
		if($_REQUEST['cod_polo'] != 100 && !empty($_REQUEST['cod_polo']))
			$sql .= " AND cod_polo = ".$_REQUEST['cod_polo'];
		$sql .= " AND (CodUsuarioInterno in (select Fk_Usuario from tb_usuarioequipe where Fk_Equipe = ".$eqp['Tk_Equipe'].") or CodUsuarioInterno = ".$eqp['Fk_Lider'].")";
		$result = mysql_query($sql) or die(mysql_error());
		$cor = "#dfdfdf";
		while($row = mysql_fetch_array($result)){
			if($cor=="#dfdfdf"){
			$cor = "#ffffff";
			}else{
			$cor = "#dfdfdf";
			}
			$usr = $row['Nome'];
			$meta = relmeta::get_meta($row['CodUsuarioInterno']);
			$atingido = relmeta::get_dados($row['CodUsuarioInterno'], $faixade, $faixaate, $faixade2, $faixaate2);
			$renova = relmeta::get_renova($row['CodUsuarioInterno'], $faixade, $faixaate, $faixade2, $faixaate2); ?>
			<tr class="link_cinza" bgcolor="<?=$cor?>">
				<td class="font_grid" ><?=$usr;?></td>
				<td class="font_grid" ><?=$meta;?></td>
				<td class="font_grid" ><?=$atingido;?></td>
				<td class="font_grid" ><?=$renova;?></td>
			</tr>
	<?	
			$eqpmeta += $meta;
			$eqpatingido += $atingido;
			$eqprenova += $renova;
		} ?>
		<tr class="link_cinza">
			<td class="parametros1">Total da equipe</td>
			<td class="parametros1"><?=$eqpmeta;?></td>
			<td class="parametros1"><?=$eqpatingido;?></td>
			<td class="parametros1"><?=$eqprenova;?></td>
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr><?
		mysql_free_result($result);
		$totalmeta += $eqpmeta;
		$totalatingido += $eqpatingido;
		$totalrenova += $eqprenova;
	} ?>
		<tr class="link_cinza">
			<td class="parametros1">Total</td>
			<td class="parametros1"><?=$totalmeta;?></td>
			<td class="parametros1"><?=$totalatingido;?></td>
			<td class="parametros1"><?=$totalrenova;?></td>
		</tr>
	</table>
</body>
</html>
