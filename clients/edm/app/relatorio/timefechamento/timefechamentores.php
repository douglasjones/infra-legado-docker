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
	include_once "../../libs/datas.php";
	include_once "../../libs/cla.rellinhasanalitico.php";

	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);

	$gerequipe = 0;
	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where Fk_Gerente = $codusuario");
	while($row = mysql_fetch_array($result)){
		$gerequipe .= ",".$row['Tk_Equipe'];
	}

	if($gerequipe){
		$result = mysql_query("Select Fk_Usuario from tb_usuarioequipe
				inner join usuariosinternos on CodUsuarioInterno = Fk_Usuario
				where Fk_Equipe in ($gerequipe) and Desativado = -1") or die(mysql_error());
		$gerenteconta = $_SESSION['codusuario'];
		while($row = mysql_fetch_array($result)){
			$gerenteconta .= ",".$row['Fk_Usuario'];
		}
		@mysql_free_result($result);

	}elseif($equipe){
		$result = mysql_query("Select Fk_Usuario from tb_usuarioequipe
				inner join usuariosinternos on CodUsuarioInterno = Fk_Usuario
				where Fk_Equipe = $equipe and Desativado = -1") or die(mysql_error());
		$gerenteconta = $_SESSION['codusuario'];
		while($row = mysql_fetch_array($result)){
			$gerenteconta .= ",".$row['Fk_Usuario'];
		}
		@mysql_free_result($result);

	}elseif($GerenteContas && !permissao('leadoutrogerente', 'al')){
		$gerenteconta = $_SESSION['codusuario'];

	} else {
		$gerenteconta = (@$_REQUEST['codgerenteconta']?$_REQUEST['codgerenteconta']:null);
	}

	$faixade			 = ( @$_REQUEST['faixade' ] ? $_REQUEST['faixade' ] : null ) ;
	$faixaate			 = ( @$_REQUEST['faixaate'] ? $_REQUEST['faixaate'] : null ) ;
	$cod_polo			 = ( @$_REQUEST['cod_polo'] ? $_REQUEST['cod_polo'] : null ) ;
	$codequipe      	 = ( !empty( $_REQUEST['codequipe'] ) ) ? $_REQUEST['codequipe'] : null ;
	$grupousuariointerno = ( !empty( $_REQUEST['grupousuariointerno'] ) ) ? $_REQUEST['grupousuariointerno'] : null ;

	if($faixade){
		$faixade		= explode('/', $faixade);
		$faixade		= strtotime($faixade[1].'/'.$faixade[0].'/'.$faixade[2]);
	}

	if($faixaate){
		$faixaate		= explode('/', $faixaate);
		$faixaate		= strtotime($faixaate[1].'/'.$faixaate[0].'/'.$faixaate[2]);
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

    <!--Include CSS-->
    <link rel="stylesheet" href="../../libs/public1.css" type="text/css">
    <title>Relatório de Linhas Analítico</title>

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
			Relatório de Linhas Analítico
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
	<?	if(!empty($_REQUEST['codequipe'])){
		$sql = "Select Vc_Nome from tb_equipesvendas where Tk_Equipe = ".$_REQUEST['codequipe'];
		$q = mysql_query($sql);
		$equipe = mysql_fetch_array($q);
		echo "<tr><td class='parametros'>Equipe: ".$equipe['Vc_Nome']."</td></tr>";
	}

		if ( $grupousuariointerno )
		{
			$sql = " SELECT Nome FROM gruposusuariosinternos WHERE CodGrupoUsuarioInterno = {$grupousuariointerno}" ;
			$qry = mysql_query( $sql ) ;
			$grupoUser = mysql_result( $qry , 0 , 0 ) ;
			echo "<tr><td class='parametros'>Grupo de Usuário: " . $grupoUser . "</td></tr>" ;
		}
	?>
</table>
<table width="800" align="center"  height="30" cellpadding="0" cellspacing="0">
	<tr>
		 <td  >&nbsp;

		</td>
	</tr>
</table>
<table cellspacing="0" cellpadding="0"  align="center" width="800" border="0" >
	<tr>
		<td class="texto_label">
<?	if(!empty($gerenteconta)){?>
			<dt>Consultor:</dt>
<?		$sql = "Select Nome From usuariosinternos Where CodUsuarioInterno in ($gerenteconta)";
		$res1 = sql_query($sql);
		while($row = mysql_fetch_array($res1)){?>
			<dd><?=$row['Nome'];?></dd>
<?		}
		mysql_free_result($res1);
	}
	if(!empty($faixade) && !empty($faixaate)){?>
			<dt>Faixa de Datas:</dt>
				<dd><?=date('d/m/Y', $faixade);?> até <?=date('d/m/Y', $faixaate);?></dd>
<?	}else if(!empty($faixade)){?>
			<dt>A partir de:</dt>
				<dd><?=date('d/m/Y', $faixade);?></dd>
<?	}else if(!empty($faixaate)){?>
			<dt>Até a data:</dt>
				<dd><?=date('d/m/Y', $faixaate);?></dd>
<?	}?>
		</td>
	</tr>
</table>
<table cellspacing="2" cellpadding="1" align="center" width="900" border="0" class="borda_tabela" >
	<tr >
		<td class="font_grid">Nome do Lead</td>
		<td class="font_grid">Consultor</td>
		<!--<td class="font_grid">Tipo</td>-->
		<td class="font_grid">Linhas Novas</td>
		<td class="font_grid">Linhas de Migra&ccedil;&atilde;o</td>
		<td class="font_grid">Linhas de Renova&ccedil;&atilde;o</td>
	</tr>

<?	$dados = rellinhasanalitico::getReport($gerenteconta, $faixade, $faixaate, $cod_polo , $codequipe , $grupousuariointerno );
	$totlnovas = 0;
	$totlmigra = 0;
	$totlrenova = 0;
	$cor = "#dfdfdf";
	$j = 0 ;
	foreach($dados as $i => $row){
		$totlnovas += $row['lnovas'];
		$totlmigra += $row['lmigra'];
		$totlrenova += $row['lrenova'];

	if($cor=="#dfdfdf"){
		$cor = "#ffffff";
	}Else{
		$cor = "#dfdfdf";
	}
?>			<tr class="link_cinza" onmouseover="muda_cor( this );" onmouseout="volta_cor( this , '<?= $cor ?>' )" id="linha<?= $j ; ?>" bgcolor="<?=$cor?>">
				<td class="font_grid"><a href="../../vendas/leads/leadgerenciamentores.php?codlead=<?=$row['codlead']?>" ><?=$row['nome'];?></a></td>
				<td class="font_grid"><?=$row['gerenteconta'];?></td>
				<!--<td align="center" class="font_grid">< ?=$row['tipo'];?></td>-->
				<td align="center" class="font_grid"><?=$row['lnovas'];?></td>
				<td align="center" class="font_grid"><?=$row['lmigra'];?></td>
				<td align="center" class="font_grid"><?=$row['lrenova'];?></td>
			<tr>
<?	$j++ ;
	}?>
			<tr class="link_cinza">
				<td class="parametros1" colspan="2"><?=count($dados);?></td>
				<td class="parametros1"><?=$totlnovas;?></td>
				<td class="parametros1"><?=$totlmigra;?></td>
				<td class="parametros1"><?=$totlrenova;?></td>
			</tr>
		</tfoot>
	</table>
</body>
</html>
