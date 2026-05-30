<?
    /*
Pagina:relfollowupres.php
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
	include_once "../../libs/cla.relfollowup.php";

	$gerequipe = 0;

	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where Fk_Gerente = $codusuario");
	while($row = mysql_fetch_array($result)){
		$gerequipe .= ",".$row['Tk_Equipe'];
	}
	@mysql_free_result($result);

	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);

	if($_REQUEST['codequipe']){
		$codequipe = $_REQUEST['codequipe'];
		$result = mysql_query("Select Fk_Usuario, Fk_Lider from tb_usuarioequipe
				inner join usuariosinternos on CodUsuarioInterno = Fk_Usuario
				left join tb_equipesvendas on Fk_Equipe = Tk_Equipe
				where Fk_Equipe = $codequipe and Desativado = -1") or die(mysql_error());
		$i=0;
		while($row = mysql_fetch_array($result)){
			if(!$i) $gerenteconta = $row['Fk_Lider'];
			$gerenteconta .= ",".$row['Fk_Usuario'];
			$i++;
		}
		mysql_free_result($result);
	}elseif($gerequipe){
		$result = mysql_query("Select Fk_Usuario from tb_usuarioequipe
				inner join usuariosinternos on CodUsuarioInterno = Fk_Usuario
				where Fk_Equipe in ($gerequipe) and Desativado = -1") or die(mysql_error());
		$gerenteconta = $_SESSION['codusuario'];
		while($row = mysql_fetch_array($result)){
			$gerenteconta .= ",".$row['Fk_Usuario'];
		}
		@mysql_free_result($result);
	}elseif($equipe){
	}elseif($GerenteContas && !permissao('leadoutrogerente', 'al')){
		$gerenteconta = $_SESSION['codusuario'];
	} else {
		$gerenteconta = (@$_REQUEST['codgerenteconta']?$_REQUEST['codgerenteconta']:null);
	}
	$target			= (!empty($_REQUEST['tgt'])?$_REQUEST['tgt']:null);
	$lead0			= (!empty($_REQUEST['led0'])?$_REQUEST['led0']:null);
	$lead25			= (!empty($_REQUEST['led25'])?$_REQUEST['led25']:null);
	$lead50			= (!empty($_REQUEST['led50'])?$_REQUEST['led50']:null);
	$forecast75env	= (!empty($_REQUEST['for75env'])?$_REQUEST['for75env']:null);
	$forecast75nao	= (!empty($_REQUEST['for75nao'])?$_REQUEST['for75nao']:null);
	
	function isDiff( &$campo1 , $campo2 , $colspan , $nome )
	{
		if ( $campo1 != $campo2 )
		{

			if ( $nome == 'Equipe' )
			{
				?>
				<tr><td colspan="<?= $colspan ; ?>"><hr></td></tr>
				<tr class="Rsub_total">
					<th colspan="<?= $colspan ; ?>">Equipe: <?= $campo2 ?></th>
				</tr>
				<?
				
			}
			elseif ( $campo2 == null )
			{
				?>
				<tr class="Rsub_total">
					<th colspan="<?= $colspan ; ?>">Sem Consultor</th>
				</tr>	
				<?
			}
			else
			{
				?>
				<tr class="Rgrid">
					<th colspan="<?= $colspan ; ?>">Consultor: <?= $campo2 ?></th>
				</tr>		
				<?
			}
		}
		$campo1 = $campo2 ;
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<!--Cabeçalho-->
<title>Relat&oacute;rio de FollowUp de Leads por Consultor</title>
<?	include_once "../../libs/head.php";?>
<link href="public1.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../../images/menu_back.gif);
	background-repeat: repeat;
}
-->
</style>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="Rcorpo">
<table width="100%" align="center"  height="5"  class="Rtopo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="topo" >
			Relatório de FollowUp de Leads </td>
	</tr>
</table>
</table>
<table width="800"   align="center" border="0" cellpadding="0" cellspacing="0" class="Rparametros">
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
		</td>
	</tr>
<?	if(!empty($_REQUEST['codequipe'])){?>
		<tr><td>Equipe:&nbsp;&nbsp;&nbsp;&nbsp;
<?		$sql = "Select Vc_Nome From tb_equipesvendas Where Tk_Equipe = " . $_REQUEST['codequipe']  ;
		$res1 = sql_query($sql);
?>		
		<?= mysql_result( $res1 , 0 , 0 ) ; ?></td></tr>
<?		
		mysql_free_result($res1);
	}
?>
</table>
<table align="center" cellpadding="1" cellspacing="2" class="Rborda_tabela">
	<tr>
<?
/*if ($target != null) {
?>
 <td valign="top">
	<table cellspacing="0" cellpadding="0" align="left" width="300" border="0" >
			<tr class="Rtitulo_grid">
				<td align="center">#</>Targets</td>
			</tr>
			<tr class="Rtitulo_grid">
				<td align="center">#</>Nome</td>
			</tr>

<?
$targ = relfollowup::reltarg($gerenteconta,$_REQUEST['cod_polo']);
$cor = "#dfdfdf";
$consultor = 'cons' ;
$equip = '' ;

for($i=0; $i < count($targ); $i++) {
	$cor = ( $cor == "#dfdfdf" ) ? "#ffffff" : "#dfdfdf" ;
	isDiff( $equip     , $targ[$i]['Equipe'  ] , 1 , 'Equipe'    ) ;
	isDiff( $consultor , $targ[$i]['Username'] , 1 , 'Consultor' ) ;
	
?>
			<tr onmouseover="muda_cor( this );" onmouseout="volta_cor( this , '<?= $cor ; ?>' )" class="Rlink_cinza" bgcolor="<?=$cor?>">
				<td><a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<? print $targ[$i]['CodLead']; ?>', 650, 480);"><? print $targ[$i]['nome'] ?></a></td>
			</tr>
<? } #loop ?>

			<tr class="Rtotal_grid">
				<td colspan="2">Targets: <? print count($targ); ?></td>
			</tr>

	</table>
  </td>
<? } #endif
*/if ($lead0 != null) {
?>
  <td valign="top">
	<table cellspacing="2" cellpadding="1" align="left" class="Rborda_tabela">

			<tr class="Rgrid" >
				<td colspan="3">Leads 0%</td>
			</tr>
			<tr class="Rtitulo_grid">
				<td>Nome</td>
				<td >&Uacute;ltima ocorr&ecirc;ncia</td>
				<td>Último Contato</td>
			</tr>
<?

$consultor = 'cons' ;
$equip = '' ;
$cor = "#dfdfdf";
$rellead0 = relfollowup::rellead0($gerenteconta,$_REQUEST['cod_polo']);

for($i=0; $i < count($rellead0); $i++) {
	$cor = ( $cor == "#dfdfdf" ) ? "#ffffff" : "#dfdfdf" ;
	isDiff( $equip     , $rellead0[$i]['Equipe'  ] , 3 , 'Equipe'    ) ;
	isDiff( $consultor , $rellead0[$i]['Username'] , 3 , 'Consultor' ) ;
?>
			<tr onMouseOver="muda_cor( this );" onMouseOut="volta_cor( this , '<?= $cor ; ?>' )" class="Rlink_cinza" bgcolor="<?=$cor?>">
				<td><a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<? print $rellead0[$i]['CodLead']; ?>', 650, 480);"><? print $rellead0[$i]['nome'] ?></a></td>
				<td><? print $rellead0[$i]['data'] ?></td>
				<td><?= $rellead0[$i]['UltimoContato'] ; ?> Dia(s)</td>
			</tr>
<? } #loop ?>

			<tr class="Rtotal_grid">
				<td colspan="2">Leads 0%: <? print count($rellead0); ?></td>
			</tr>
	</table>
  </td>
<? } #endif
if ($lead25 != null) {
?>
  <td valign="top">
<table cellspacing="1" cellpadding="1" align="left" class="Rborda_tabela">

			<tr class="Rgrid">
				<td colspan="5">Leads 25%</th>
			</tr>
			<tr class="Rtitulo_grid" >
				<td>Nome</td>
				<td>&Uacute;ltima ocorr&ecirc;ncia</td>
				<td>Dias Último Contato</td>
				<td>&Uacute;ltima visita</td>
				<td>Dias Última Visita</td>
			</tr>

<? $cor = "#dfdfdf";


$rellead25 = relfollowup::rellead25($gerenteconta,$_REQUEST['cod_polo']);

$consultor = 'cons' ;
$equip = '' ;
$cor = "#dfdfdf" ;

for($i=0; $i < count($rellead25); $i++) {
	$cor = ( $cor == "#dfdfdf" ) ? "#ffffff" : "#dfdfdf" ;
	isDiff( $equip     , $rellead25[$i]['Equipe'  ] , 5 , 'Equipe'    ) ;
	isDiff( $consultor , $rellead25[$i]['Username'] , 5 , 'Consultor' ) ;
?>
			<tr onMouseOver="muda_cor( this );" onMouseOut="volta_cor( this , '<?= $cor ; ?>' )" class="Rlink_cinza" bgcolor="<?=$cor?>">
				<td><a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<? print $rellead25[$i]['CodLead']; ?>', 650, 480);"><? print $rellead25[$i]['nome'] ?></a></td>
				<td><? print $rellead25[$i]['data'] ?></td>
				<td style="text-align:center"><?= $rellead25[$i]['UltimoContato'] ; ?> Dia(s)</td>
				<td><? print $rellead25[$i]['datavisita'] ?></td>
				<td style="text-align:center"><?= $rellead25[$i]['UltimaVisita'] ?> Dia(s)</td>
			</tr>
<? } #loop ?>
		</tbody>
		<tfoot>
			<tr class="Rtotal_grid">
				<td colspan="3">Leads 25%: <? print count($rellead25); ?></td>
			</tr>
		</tfoot>
	</table>
  </td>
<? } #endif
if ($lead50 != null) {
?>
  <td valign="top">
	<table cellspacing="2" cellpadding="1" align="left" class="Rborda_tabela" >
			<tr class="Rgrid" >
				<td colspan="6">Leads 50%</td>
			</tr>
			<tr class="Rtitulo_grid">
				<td>Nome</td>
<?				if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip'){ ?>
				<td>Linhas</td>
<?				} ?>
				<td>&Uacute;ltima ocorr&ecirc;ncia</td>
				<td>Dias Último Contato</td>
				<td>&Uacute;ltima visita</td>
				<td>Dias Última Visita</td>
			</tr>

<?
$rellead50 = relfollowup::rellead50($gerenteconta,$_REQUEST['cod_polo']);
$totlinhas = 0;
$consultor = 'cons' ;
$equip = '' ;
$cor = "#dfdfdf" ;
for($i=0; $i < count($rellead50); $i++) {

	$totlinhas += $rellead50[$i]['qtdlinhas'];
}
for($i=0; $i < count($rellead50); $i++) {
	$cor = ( $cor == "#dfdfdf" ) ? "#ffffff" : "#dfdfdf" ;
	isDiff( $equip     , $rellead50[$i]['Equipe'  ] , 6 , 'Equipe'    ) ;
	isDiff( $consultor , $rellead50[$i]['Username'] , 6 , 'Consultor' ) ;

?>
			<tr onMouseOver="muda_cor( this );" onMouseOut="volta_cor( this , '<?= $cor ; ?>' );" class="Rlink_cinza" bgcolor="<?=$cor?>">
				<td><a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<? print $rellead50[$i]['CodLead']; ?>', 650, 480);"><? print $rellead50[$i]['nome'] ?></a></td>
<?				if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip'){ ?>
				<td><? print $rellead50[$i]['qtdlinhas'] ?></td>
<?				} ?>
				<td><? print $rellead50[$i]['datavisita'] ?></td>
				<td style="text-align:center"><? print $rellead50[$i]['UltimoContato'] ?> Dia(s)</td>
				<td><? print $rellead50[$i]['data'] ?></td>
				<td style="text-align:center"><? print $rellead50[$i]['UltimaVisita'] ?> Dia(s)</td>
			</tr>
<? } #loop ?>

			<tr class="Rtotal_grid">
				<td>Leads 50%: <? print count($rellead50); ?></td>
				<td colspan="3"><?	if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip') print $totlinhas ?></td>
			</tr>

	</table>
  </td>
<? } #endif
if ($forecast75env != null) {
?>
  <td valign="top">
	<table cellspacing="2" cellpadding="1" align="left" class="Rbordatabela" >

			<tr class="Rgrid">
				<td align="center" colspan="8">Forecast 75% - Enviados para Claro</td>
			</tr>
			<tr class="Rtitulo_grid">
				<td>Nome</td>
				<td>Linhas</td>
				<td>&Uacute;ltima visita</td>
				<td>Dias Último Contato</td>
				<td>Previs&atilde;o</td>
				<td>Envio</td>
				<td>&Uacute;ltima ocorr&ecirc;ncia</td>
				<td>Dias Última Visita</td>
			</tr>
<?
$rellead75env = relfollowup::rellead75env($gerenteconta,$_REQUEST['cod_polo']);
$totlinhas = 0;
$consultor = 'cons' ;
$equip = '' ;
$cor = "#dfdfdf" ;
for($i=0; $i < count($rellead75env); $i++) {
	
	$cor = ( $cor == "#dfdfdf" ) ? "#ffffff" : "#dfdfdf" ;
	isDiff( $equip     , $rellead75env[$i]['Equipe'  ] , 8 , 'Equipe'    ) ;
	isDiff( $consultor , $rellead75env[$i]['Username'] , 8 , 'Consultor' ) ;
	$totlinhas += $rellead75env[$i]['qtdlinhas'];
?>
			<tr onMouseOver="muda_cor( this );" onMouseOut="volta_cor( this , '<?= $cor ; ?>' )" class="Rlink_cinza" bgcolor="<?=$cor?>">
				<td><a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<? print $rellead75env[$i]['CodLead']; ?>', 650, 480);"><? print $rellead75env[$i]['nome'] ?></a></td>
				<td><? print $rellead75env[$i]['qtdlinhas'] ?></td>
				<td><? print $rellead75env[$i]['datavisita'] ?></td>
				<td style="text-align:center"><? print $rellead75env[$i]['UltimoContato'] ?></td>
				<td><? print $rellead75env[$i]['data_prev'] ?></td>
				<td><? print $rellead75env[$i]['data_envio'] ?></td>
				<td><? print $rellead75env[$i]['data'] ?></td>
				<td style="text-align:center"><? print $rellead75env[$i]['UltimaVisita'] ?></td>
			</tr>
<? } #loop ?>
			<tr class="Rtotal_grid">
				<td>Forecast 75%: <? print count($rellead75env); ?></td>
				<td colspan="5" align="right"><? print $totlinhas ?></td>
			</tr>
	</table>
  </td>
<? } #endif
if ($forecast75nao != null) {
?>
  <td valign="top">
	<table cellspacing="2" cellpadding="1" align="left" class="Rborda_tabela">
		<thead>
			<tr class="Rgrid">
				<td colspan="7">Forecast 75%<?	if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip'){ ?> - Não enviados para Claro<? } ?></td>
			</tr>
			<tr class="Rtitulo_grid">
				<td>Nome</th>
<?				if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip'){ ?>
				<td class="titulo">Linhas</td>
<?				} ?>
				<td>&Uacute;ltima visita</td>
				<td>Dias Útilmo Contato</td>
				<td>Previs&atilde;o</td>
				<td>&Uacute;ltima ocorr&ecirc;ncia</td>
				<td>Dias Última Visita</td>
			</tr>
<?
$rellead75nao = relfollowup::rellead75($gerenteconta,$_REQUEST['cod_polo']);
$totlinhas = 0;
$consultor = 'cons' ;
$equip = '' ;
$cor = "#dfdfdf" ;

for($i=0; $i < count($rellead75nao); $i++) {
	$cor = ( $cor == "#dfdfdf" ) ? "#ffffff" : "#dfdfdf" ;
	isDiff( $equip     , $rellead75nao[$i]['Equipe'  ] , 7 , 'Equipe'    ) ;
	isDiff( $consultor , $rellead75nao[$i]['Username'] , 7 , 'Consultor' ) ;
	$totlinhas += $rellead75nao[$i]['qtdlinhas'];
?>
			<tr onMouseOver="muda_cor( this );" onMouseOut="volta_cor( this , '<?= $cor ; ?>' )" class="Rlink_cinza" bgcolor="<?=$cor;?>">
				<td><a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<? print $rellead75nao[$i]['CodLead']; ?>', 650, 480);"><? print $rellead75nao[$i]['nome'] ?></a></td>
<?				if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip'){ ?>
				<td><? print $rellead75nao[$i]['qtdlinhas'] ?></td>
<?				} ?>
				<td><? print $rellead75nao[$i]['datavisita'] ?></td>
				<td style="text-align:center"><? print $rellead75nao[$i]['UltimoContato'] ?></td>
				<td><? print $rellead75nao[$i]['data_prev'] ?></td>
				<td><? print $rellead75nao[$i]['data'] ?></td>
				<td style="text-align:center"><? print $rellead75nao[$i]['UltimaVisita'] ?></td>
			</tr>
<? } #loop ?>
		</tbody>
		<tfoot>
			<tr class="Rtotal_grid">
				<td>Forecast 75%: <? print count($rellead75nao); ?></td>
				<td colspan="4"><?	if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip') print $totlinhas; ?></td>
			</tr>
		</tfoot>
	</table>
  </td>
<? } #endif
include_once "../../libs/desconectar.php";?>

  </tr>
</table>
</body>
</html>
