<?
    /*
Pagina:relequipesres.php
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
	include_once "../../libs/cla.equipes.php";
	include_once "../../libs/cla.propostas.php";

	$faixade		= (@$_REQUEST['faixade']?$_REQUEST['faixade']:null);
	$faixaate		= (@$_REQUEST['faixaate']?$_REQUEST['faixaate']:null);

	if($faixade){
		$faixade		= explode('/', $faixade);
		$faixade		= strtotime($faixade[1].'/'.$faixade[0].'/'.$faixade[2]);
	}
	
	if($faixaate){
		$faixaate		= explode('/', $faixaate);
		$faixaate		= strtotime($faixaate[1].'/'.$faixaate[0].'/'.$faixaate[2]);
	}

	$faixade2		= (@$_REQUEST['faixade2']?$_REQUEST['faixade2']:null);
	$faixaate2		= (@$_REQUEST['faixaate2']?$_REQUEST['faixaate2']:null);

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

<?	include_once "../../libs/head.php";
?>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<script src="../../extras/prototype.js" language="JavaScript" type="text/javascript"></script>
	<script src="../../extras/equipes.js" language="JavaScript" type="text/javascript"></script>
	<div style="display:none; position:absolute; top:20px; left: 100px; background-color:#CCCCCC" id="detalhes">
	Carregando...
	</div>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório de Vendas por Equipes
		</td>
	</tr>
</table>		
<!--<table width="90%" align="left"  height="30"    cellpadding="0" cellspacing="0">
	<tr>
		 <td  >&nbsp; 
			
		</td>	
	</tr>
</table>	-->
<table border="0" width="100%"   align="left" border="0" cellpadding="1" cellspacing="0" class="form">
	<tr>
		<td align="left" class="parametros">
			Parâmetros 
		</td>
	</tr>
	<tr>
		<td class="parametros">
				Relatório gerado em <?=date('d/m/Y \à\s H:i', mktime());?>
		</td>
	</tr>
</table>
<br>
<br><br>
<br>
<table width="100%"   align="left" border="0" cellpadding="0" cellspacing="0" class="form">
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
<?	if(!empty($faixade) && !empty($faixaate)){?>
<?	if($_SESSION['bd'] == 'uniglobe' || $_SESSION['bd'] == 'sorocaba_voip'){?>
			<dt>Faixa de Datas(Abertura de Try&amp;Buy):</dt>
<?	}else{?>
			<dt>Faixa de Datas(Entrega para Claro):</dt>
<?	}?>
				<dd><?=date('d/m/Y', $faixade);?> até <?=date('d/m/Y', $faixaate);?></dd>
<?	}else if(!empty($faixade)){?>
			<dt>A partir de:</dt>
				<dd><?=date('d/m/Y', $faixade);?></dd>
<?	}else if(!empty($faixaate)){?>
			<dt>Até a data:</dt>
				<dd><?=date('d/m/Y', $faixaate);?></dd>
<?	}?>
<?	if(!empty($faixade2) && !empty($faixaate2)){?>
			<dt>Faixa de Datas(Ativação):</dt>
				<dd><?=date('d/m/Y', $faixade2);?> até <?=date('d/m/Y', $faixaate2);?></dd>
<?	}else if(!empty($faixade2)){?>
			<dt>A partir de:</dt>
				<dd><?=date('d/m/Y', $faixade2);?></dd>
<?	}else if(!empty($faixaate2)){?>
			<dt>Até a data:</dt>
				<dd><?=date('d/m/Y', $faixaate2);?></dd>
<?	}?>
		</td>
	</tr>
</table>
<br>
<?
	$equipe = equipes::get_equipes($_REQUEST['cod_polo']);
	$qtdeqp = 0;
	while($row = mysql_fetch_array($equipe)){
		$equipes[$qtdeqp]['cod'] = $row['cod'];
		$equipes[$qtdeqp]['lider'] = $row['lider'];
		$equipes[$qtdeqp]['nome'] = $row['equipe'];
		$usuarios = equipes::get_equipe($row['cod']);
		$equipes[$qtdeqp]['qtdusr'] = 0;
		$maxusr = 0;
		while($rowusr = mysql_fetch_array($usuarios)){
			$equipes[$qtdeqp]['usuario'][$equipes[$qtdeqp]['qtdusr']] = $rowusr['usuario'];
			$equipes[$qtdeqp]['codusr'][$equipes[$qtdeqp]['qtdusr']] = $rowusr['codusr'];
			$equipes[$qtdeqp]['qtdusr']++;
			$maxusr = ($maxusr<$equipes[$qtdeqp]['qtdusr']?$equipes[$qtdeqp]['qtdusr']:$maxusr);
		}
		mysql_free_result($usuarios);
		$qtdeqp++;
	}
	mysql_free_result($equipe);
?>

<table   align="left" border="0" cellpadding="0" cellspacing="0" class="form">
  <tr>
	<td>&nbsp;
		
	</td>
   <td>&nbsp;
<?	for($i=0; $i < $qtdeqp; $i++){ ?>

	<table width="400"  align="center" border="1" cellpadding="0" cellspacing="0" class="topo">		
			<tr  >
				<td class="titulo"  colspan="2" nowrap="nowrap"><?=$equipes[$i]['nome'];?></td>
			</tr>
			<tr c colspan="2" nowrap="nowrap">
			<td class="titulo" >Lider: <?=$equipes[$i]['lider'];?></td>
			</tr>

	</table>	
	<table width="400"  align="center" border="1" cellpadding="0" cellspacing="0" class="form">
			<tr class="link_cinza">
				<td class="font_grid"   nowrap="nowrap">Consultor</td>
				<td class="font_grid"  nowrap="nowrap">N° de vendas</td>
			</tr>	
<?		$totequipe = 0;
		for($j=0; $j < $equipes[$i]['qtdusr']; $j++){ 
			$npropusr = propostas::getEnvByUsr($equipes[$i]['codusr'][$j], $faixade, $faixaate, $faixade2, $faixaate2);
			$totequipe += $npropusr;
?>
			<tr class="link_cinza" >
				<td nowrap="nowrap"><?=$equipes[$i]['usuario'][$j];?></td>
<?				$params = $equipes[$i]['codusr'][$j];
				if($faixade) $params .= ','.$faixade; else $params.= ',undefined';
				if($faixaate)$params .= ','.$faixaate; else $params.= ',undefined';
				if($faixade2) $params .= ','.$faixade2; else $params.= ',undefined';
				if($faixaate2)$params .= ','.$faixaate2; else $params.= ',undefined';
?>
				<td nowrap="nowrap"><a href="javascript:showDetVendas(<?=$params?>);"><?=$npropusr;?></a></td>
			</tr>
<?		} 
		while($j < $maxusr){
?>
			<tr lass="link_cinza">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
<?			$j++;
		} ?>
			<tr>
				<td class="parametros">Total:</td>
				<td lass="parametros"><?=$totequipe?></td>
			</tr>

	</table>
	<br>
	

<? } ?>
   </td>
  </tr>
 </tbody>
</table>
</body>
</html>
