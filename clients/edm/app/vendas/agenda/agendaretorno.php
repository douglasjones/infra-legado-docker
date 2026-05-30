<?php

//____________________INCLUDES____________________/
include_once "../../libs/maininclude.php";
include_once "../../libs/combo.php";
include_once "../../libs/cla.equipes.php";

$status = $_REQUEST['status'];
$codtipoocorrencialead = $_REQUEST['codtipoocorrencialead'];
$agendadopara = $_REQUEST['agendadopara'];
$agendadopor = $_REQUEST['agendadopor'];


if($agendadopara == "" && $agendadopor == ""){
    $agendadopara = $_SESSION['codusuario'];
}


//Defini��es de Visualiza��o..
$mes = 0;
$ano = 0;
$nomemes = array(1 => 'Janeiro', 'Fevereiro', 'Mar�o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

$nomemes = array(1 => 'Janeiro', 'Fevereiro', 'Mar�o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$nomesemana = array(0 => 'Domingo', 1 => 'Segunda', 2 => 'Ter�a', 3 => 'Quarta', 4 => 'Quinta', 5 => 'Sexta', 6 => 'Sabado');

if(!empty($_REQUEST['mes']))
	$mes = $_REQUEST['mes'];
if(!empty($_REQUEST['ano']))
	$ano = $_REQUEST['ano'];
if($mes <= 0 || $mes > 12)
	$mes = date('n');
if($ano <= 0)
	$ano = date('Y');
$dtinicio = mktime(0, 0, 0, $mes, 1, $ano);
$dtfim = mktime(0, 0, 0, $mes + 1, 0, $ano);
while(date('w', $dtinicio) != 0)
	$dtinicio = mktime(0, 0, 0, date('n', $dtinicio), date('d', $dtinicio) - 1, date('Y', $dtinicio));
while(date('w', $dtfim) != 6)
	$dtfim = mktime(0, 0, 0, date('n', $dtfim), date('d', $dtfim) + 1, date('Y', $dtfim));
$dtfim = mktime(0, 0, 0, date('n', $dtfim), date('d', $dtfim) + 1, date('Y', $dtfim));
	?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?	include_once "../../libs/head.php";?>

     <!--Comandos Javascript-->

	<script type="text/javascript" language="javascript">
	function editarCliente(codlead){
	NewWindow('../../vendas/leads/leadnew.php?codlead=' + codlead,700,500)
}


function historico(cod){
    NewWindow('../../vendas/leads/leadhistoricoocorrencia.php?codlead=' + cod, 1000,600);
}

function adicionar_oc(cod){
    NewWindow('../../vendas/leads/leadocorrencianew.php?codlead=' + cod, 500,400);
}

function historico_documentos(cod){
    NewWindow('../../vendas/leads/documentosres.php?codlead=' + cod, 1000,600);
}

function adicionar_documentos(cod){
    NewWindow('../../vendas/leads/documentos_cad_form.php?codlead=' + cod, 1000,600);
}

function editarretorno(cod){

	NewWindow("../../vendas/leads/leadocorrencianew.php?acao=upd&codocorrencialead="+cod,500,400)
}

	</script>
	<style type="text/css">
	a:link {
		text-decoration:none;
	}
	a:visited {
		text-decoration:none;
	}
	a:hover {
		text-decoration:underline;
	}
	.visita {
		margin-bottom:0.3em;
	}
	.atrasado {
		background-color:rgb(255, 100, 100);
	}
	.respondido {
		background-color:yellow;
	}	
	.concluido {
		background-color:#00CC66;
}
    </style>

 	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">

</head>

<!--HTML-->

    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form action="agendaretorno.php" method="get">
		<input type="hidden" name="mes" value="<?=$mes;?>" />
		<input type="hidden" name="ano" value="<?=$ano;?>" />
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="grid">
	<tr>
		<td align="center">
		<a href="agendaretorno.php?codagendadopara=<?=$codagendadopara;?>&mes=<?=$mes;?>&ano=<?=$ano - 1;?>">&#60;&#60; Ano</a>
		&nbsp;
		<a href="agendaretorno.php?codagendadopara=<?=$codagendadopara;?>&mes=<?=($mes == 1)?12:$mes - 1;?>&ano=<?=($mes == 1)?$ano - 1:$ano;?>">&#60;&#60; M�s</a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?=$nomemes[$mes].'/'.$ano;?>&nbsp;-&nbsp;
		<?=$qtde.' Retorno'.($qtde==1?null:'s');?>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="agendaretorno.php?codagendadopara=<?=$codagendadopara;?>&mes=<?=($mes == 12)?1:$mes + 1;?>&ano=<?=($mes == 12)?$ano + 1:$ano;?>">M�s &#62;&#62;</a>
		&nbsp;
		<a href="agendaretorno.php?codagendadopara=<?=$codagendadopara;?>&mes=<?=$mes;?>&ano=<?=$ano + 1;?>">Ano &#62;&#62;</a>
		</td>
	</tr>
</table>		

<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td>
			<table width="100%">
				<tr>
					<td align="right">Agendado para: </td>
					<td>
					<?
					$sql = "select u.CodUsuarioInterno, u.Nome, u.Desativado ";
					$sql.= "  from usuariosinternos u ";
					$sql.= " order by u.Desativado, u.Nome;";
					$tipos[0]['valor'] = '-1';
					$tipos[1]['valor'] = 1;
					$tipos[0]['style'] = 'color:#009900';
					$tipos[1]['style'] = 'color:#990000';
					$tipos['max'] = 2;
					combo_tipos($sql, "agendadopara", $tipos, $agendadopara, " ", '','');
					?>
					</td>
					<td align="right">Status</td>
					<td>
						<select id="status" name='status'>
							<option value=''></option>
							
							<option value='1' <?if($status == 1){echo "selected";}?>>Atrasado</option>
							<option value='2' <?if($status == 2){echo "selected";}?>>Respondido</option>
							<option value='3' <?if($status == 3){echo "selected";}?>>Conclu�do</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">Agendado por:</td>
					<td>
					<?
					$sql = "select u.CodUsuarioInterno, u.Nome, u.Desativado ";
					$sql.= "  from usuariosinternos u ";
					$sql.= " order by u.Desativado, u.Nome;";
					$tipos[0]['valor'] = '-1';
					$tipos[1]['valor'] = 1;
					$tipos[0]['style'] = 'color:#009900';
					$tipos[1]['style'] = 'color:#990000';
					$tipos['max'] = 2;
					combo_tipos($sql, "agendadopor", $tipos, $agendadopor, " ", '', '');
					?>					
					</td>
					<td align="right">Tipo da Ocorr�ncia: </td>
					<td>
						<?
						$sql = "select CodTipoOcorrenciaLead, t.descricao ";
						$sql.= "  from tipoocorrenciaslead t";
						$sql.= " where (t.cod_operador is null or t.cod_operador=0 or cod_operador in (Select cod_operador from empresa_operador))";
						$sql.= " order by t.descricao";
						combo($sql, "codtipoocorrencialead", $codtipoocorrencialead, " ", " ");
						?>
					</td>
					
				</tr>
				<tr>
					<td colspan="4" align="center"><input type="submit" class="button" value="Filtrar" /></td>
				</tr>
			</table>
		</td>
	</tr>
</table>		

<table border="1" cellspacing="0" cellpadding="0" style="width:100%" class="form">
	<thead>
		<tr class="grid">
			<td style="width:14%">Domingo</td>
			<td style="width:14%">Segunda</td>
			<td style="width:14%">Ter�a</td>
			<td style="width:14%">Quarta</td>
			<td style="width:14%">Quinta</td>
			<td style="width:14%">Sexta</td>
			<td style="width:14%">Sabado</td>
		</tr>
	</thead>
	<tbody>
<?	$dia = $dtinicio;
	while($dia != $dtfim){
		$qtde = 0;
		$sql ="select oc.dt_retorno_fechamento, l.RazaoSocial, l.codlead, ui1.nome agendadopor, ui.Nome Usuario, tc.descricao, oc.codocorrencialead, DATE_FORMAT(oc.dt_retorno, '%H:%i') dt_retorno, (SYSDATE() > oc.dt_retorno AND oc.dt_retorno_fechamento IS NULL) Atrasado,  (oc.datafechamento IS NOT NULL) Concluido, (oc.dt_retorno_fechamento is not null and oc.datafechamento is null) respondido ";
 		$sql.="  from ocorrenciaslead oc ";
		$sql.="       inner join leads l ON oc.codlead = l.codlead ";
		$sql.="       inner join usuariosinternos ui on oc.agendadopara = ui.CodUsuarioInterno ";
		$sql.="	      inner join usuariosinternos ui1 on oc.codusuariointerno = ui1.codusuariointerno ";
		$sql.="       inner join tipoocorrenciaslead tc on oc.codtipoocorrencialead = tc.codtipoocorrencialead ";
		$sql.=" where oc.dt_retorno Between '" . date('Y-m-d', $dia) . " 00:00:00' And '" . date('Y-m-d', $dia) . " 23:59:59'";
		
		if(!permissao('visualizar_todos_consultores', 'cs'))
			$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
		if(!permissao('visualizar_todos_atendentes', 'cs'))
			$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
		if($agendadopara != ""){
			$sql.=" and oc.agendadopara = ".$agendadopara ;
		}
		if($agendadopor != ""){
			$sql.=" and oc.codusuariointerno = ".$agendadopor." ";
		}
		if($codtipoocorrencialead != ""){
			$sql.=" and oc.codtipoocorrencialead = ".$codtipoocorrencialead." ";
		}
		if($status != ""){
			if($status == 1){
				$sql.=" and (SYSDATE() > oc.dt_retorno AND oc.dt_retorno_fechamento IS NULL) = true ";
			}
			if($status == 2){
				$sql.=" and (oc.dt_retorno_fechamento is not null and oc.datafechamento is null) = true ";
			}
			if($status == 3){
				$sql.=" and (oc.datafechamento IS NOT NULL) = true ";
			}
		}
		
		$sql .= " order by oc.dt_retorno";

		$result = sql_query($sql);
		$qtde = mysql_num_rows($result);?>
				<?=(date('w', $dia) == 0?'<tr>':null);?>
		<td style="vertical-align:top;<?=(date('n', $dia) != $mes?"color:gray;":"");?><?=($dia == mktime(0, 0, 0)?"border:solid 2px red;":"");?>">
		<a name="<?=date('Ymd', $dia);?>"></a>
		<?	if(date('n', $dia) != $mes){?>
			<a href="agendaretorno.php?mes=<?=date('n', $dia);?>&ano=<?=date('Y', $dia);?>#<?=date('Ymd', $dia);?>">
		<?	}?>
		<span>
			<?=date('d', $dia);?><?=($qtde >0?' - '.$qtde.' retorno'.($qtde == 1?null:'s'):null);?>
		</span>
		<?=(date('n', $dia) != $mes?'</a>':null);?>
<?if(date('n', $dia) == $mes){?>
	<div>
		<?while($row = mysql_fetch_array($result)){?>
			<div class="visita <?=($row['Concluido']==1?'concluido':($row['Atrasado']==1?'atrasado':($row['respondido']==1?'respondido':null)));?>">
				<a name="<?=$row['pk'];?>"></a>
				<?	
				if(permissao('../../agenda/agendaretorno', array('al', 'dt'))){?>
					<a href="javascript:editarretorno(<?=$row['codocorrencialead'];?>)"><?=$row['dt_retorno'];?></a>					
					
				<?}else{?>
					<a href="javascript:editarretorno(<?=$row['codocorrencialead'];?>)"><?=$row['dt_retorno'];?></a>	
				<?}?>
				<br><b><?=$row['descricao'];?></b><br>
				<?if(permissao('leads', 'dt')){?>
					<a href="../../vendas/leads/leadgerenciamentores.php?codlead=<?=$row['codlead'];?>" target="pagina" title="<?=$row['RazaoSocial'];?>"><?=$row['RazaoSocial'];?></a><br />
				<?}else{?>
					<?=$row['RazaoSocial'];?><br />
				<?}?>
								
				<strong>Agendado Para: </strong><?=$row['Usuario'];?>
                                <strong>Agendado Por: </strong><?=$row['agendadopor'];?><Br><br>
                                        <a href="javascript:historico(<?= $row['codlead'];?>)" title="Histórico de Ocorrências"><img src="../../n_images/People_012.gif"></a>&nbsp;
                                        <a href="javascript:adicionar_oc(<?= $row['codlead'];?>)" title="Adicionar Nova Ocorrência"><img src="../../n_images/salvar.png" height="16" width="16"></a>&nbsp;
                                        <a href="javascript:historico_documentos(<?= $row['codlead'];?>)" title="Histórico de Documentos"><img src="../../n_images/doc.jpg" height="16" width="16"></a>&nbsp;
                                        <a href="javascript:adicionar_documentos(<?= $row['codlead'];?>)" title="Adicionar Documentos"><img src="../../n_images/historico_doc.jpg" height="16" width="16"></a><br />
                                <br>
			</div>
		<?}
		mysql_free_result($result);
		?>
	</div>
<?}?>
&nbsp;
	  </td>
				<?=(date('w', $dia) == 6?'</tr>':null);?>
<?		$dia = mktime(0, 0, 0, date('n', $dia), date('d', $dia) + 1, date('Y', $dia));
	}?>
			</tbody>
	  </table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="grid">
	<tr>
		<td align="center">
		<a href="agendaretorno.php?mes=<?=$mes;?>&ano=<?=$ano - 1;?>">&#60;&#60; Ano</a>
		&nbsp;
		<a href="agendaretorno.php?mes=<?=($mes == 1)?12:$mes - 1;?>&ano=<?=($mes == 1)?$ano - 1:$ano;?>">&#60;&#60; M�s</a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?=$nomemes[$mes].'/'.$ano;?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="agendaretorno.php?mes=<?=($mes == 12)?1:$mes + 1;?>&ano=<?=($mes == 12)?$ano + 1:$ano;?>">M�s &#62;&#62;</a>
		&nbsp;
		<a href="agendaretorno.php?mes=<?=$mes;?>&ano=<?=$ano + 1;?>">Ano &#62;&#62;</a>
		</td>
	</tr>
</table>				
	</form>
<table border="0" cellpadding="0" cellspacing="0" class="form" width="60%" align="center">
<tbody>
<tr><td>&nbsp;</td>
</tr>
<tr>
	<td class="atrasado" align="center"><b>Atrasado</b></td>
	<td class="respondido" align="center"><b>Respondido</b></td>
	<td class="concluido" align="center"><b>Concluído</b></td>
</tr>
</tbody>
</table>
</body>

</html>



