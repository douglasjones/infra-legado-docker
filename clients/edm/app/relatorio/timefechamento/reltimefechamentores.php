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
    <title>Relatório Lead Time de Fechachamento</title>

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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="Rcorpo">
<table width="100%" class="Rtopo">
	<tr>
		 <td>
			Relatório Lead Time de Fechachamento
		</td>
	</tr>
</table>
<table class="Rparametros">
	<tr>
		<td>
			Parâmetros
		</td>
	</tr>
	<tr>
		<td>
				Relatório gerado em <?=date('d/m/Y \à\s H:i', mktime());?>
		</td>
	</tr>
<?	if(!empty($_REQUEST['cod_polo'])){
		$sql = "Select p.cod_polo, c.dsc_cidade from polo p";
		$sql .= " inner join cidade c on p.cod_cidade = c.cod_cidade ";
		$sql .= " where p.cod_polo=".$_REQUEST['cod_polo'];
		$sql .= " Order By c.dsc_cidade ";
		$q = mysql_query($sql);
		$polo = mysql_fetch_array($q);
		echo "<tr><td>Polo: ".$polo['dsc_cidade'] . "</td></tr>" ;
	}?>

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
<?	if(!empty($gerenteconta)){?>
			<tr><td>Consultor:
<?		$sql = "Select Nome From usuariosinternos Where CodUsuarioInterno in ($gerenteconta)";
		$res1 = sql_query($sql);
		while($row = mysql_fetch_array($res1)){?>
			<?=$row['Nome'];?></td></tr>
<?		}
		mysql_free_result($res1);
	}
	if(!empty($faixade) && !empty($faixaate)){?>
			<tr><td>Faixa de Datas:
				<?=date('d/m/Y', $faixade);?> até <?=date('d/m/Y', $faixaate);?></td></tr>
<?	}else if(!empty($faixade)){?>
			<tr><td>A partir de:
				<?=date('d/m/Y', $faixade);?></td></tr>
<?	}else if(!empty($faixaate)){?>
			<tr><td>Até a data:
				<?=date('d/m/Y', $faixaate);?></td></tr>
<?	}?>
</table>
<table cellspacing="2" cellpadding="1" align="center" class="Rborda_tabela" >
	<tr class="Rtitulo_grid">
		<td>Nome do Lead</td>
		<td>Consultor</td>
		<td>Data de Agendamento</td>
		<td>Data de Rec.</td>
		<td>Lead Time</td>
		<!--<td>Tipo</td>-->
		<td>Linhas Novas</td>
		<td>Linhas de Migra&ccedil;&atilde;o</td>
		<td>Linhas de Renova&ccedil;&atilde;o</td>
	</tr>

<?	$dados = rellinhasanalitico::getReport2($gerenteconta, $faixade, $faixaate, $cod_polo , $codequipe );

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
?>			<tr class="Rlink_cinza" onmouseover="muda_cor( this );" onmouseout="volta_cor( this , '<?= $cor ?>' )" bgcolor="<?=$cor?>">
				<td><a href="../../vendas/leads/leadgerenciamentores.php?codlead=<?=$row['codlead']?>" ><?=$row['nome'];?></a></td>
				<td><?=$row['gerenteconta'];?></td>
				<td><?= DataDMY( substr( $row['agendado'] , 0 , 10 ) ) ; ?></td>
				<td><?= DataDMY( $row['recebimento'] ) ; ?></td>
				<td align="right"><?=$row['datadif'];?></td>
				<!--<td align="center">< ?=$row['tipo'];?></td>-->
				<td align="center"><?=$row['lnovas'];?></td>
				<td align="center"><?=$row['lmigra'];?></td>
				<td align="center"><?=$row['lrenova'];?></td>
			<tr>
<?	$j++ ;
	}?>
			<tr class="Rtotal_grid" align="center">
				<td colspan="5"><?=count($dados);?></td>
				<td><?=$totlnovas;?></td>
				<td><?=$totlmigra;?></td>
				<td><?=$totlrenova;?></td>
			</tr>
		</tfoot>
	</table>
</body>
</html>
