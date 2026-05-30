<?	require_once 'datas.php';
	if(!empty($_REQUEST['selectdate']))
		$selectdate = strtotime(dataYMD($_REQUEST['selectdate']));
	else
		$selectdate = mktime();
	if(!empty($_REQUEST['date']))
		$date = strtotime(dataYMD($_REQUEST['date']));
	else
		$date = $selectdate;
	$dateobject = $_REQUEST['dateobject'];
	$mes = 0;
	$ano = 0;
	$nomemes = array(1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
	$nomesemana = array(0 => 'Domingo', 1 => 'Segunda', 2 => 'Terça', 3 => 'Quarta', 4 => 'Quinta', 5 => 'Sexta', 6 => 'Sabado');

	$mes = date('n', $date);
	$ano = date('Y', $date);
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
	$dtfim = mktime(0, 0, 0, date('n', $dtfim), date('d', $dtfim) + 1, date('Y', $dtfim));?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="public1.css" />
	<script type="text/javascript" language="javascript" src="/public.js"></script>
	<script type="text/javascript" language="javascript">
	function setDate(dia, mes, ano){
		try {
			opener.document.getElementsByName('<?=$dateobject;?>')[0].value = dia + '/' + mes + '/' + ano
		}catch(e){}
		self.close()
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
	.outromes {
		color:gray;
	}
	</style>
</head>
<body>
	<table cellspacing="0" cellpadding="0" style="width:100%;clear:both" border="0" class="form">
		<thead>
			<tr>
				<th nowrap="nowrap">
					<a href="calendar.php?dateobject=<?=$dateobject;?>&selectdate=<?=date('d/m/Y', $selectdate);?>&date=<?=date('d/m/Y', mktime(0, 0, 0, date('n', $date), date('d', $date), date('Y', $date) - 1));?>">&#60;&#60;</a>
					&nbsp;
					<a href="calendar.php?dateobject=<?=$dateobject;?>&selectdate=<?=date('d/m/Y', $selectdate);?>&date=<?=date('d/m/Y', mktime(0, 0, 0, date('n', $date) - 1, date('d', $date), date('Y', $date)));?>">&#60;</a>
				</th>
				<th colspan="5">
					<?=$nomemes[$mes].'/'.$ano;?>
				</th>
				<th nowrap="nowrap">
<?	$prox = mktime(0, 0, 0, date('n', $date) + 1, date('d', $date), date('Y', $date));
	if(date('n', $prox) > date('n', $date) + 1)
		$prox = mktime(0, 0, 0, date('n', $date), date('d', $date) + 1, date('Y', $date));
?>
					<a href="calendar.php?dateobject=<?=$dateobject;?>&selectdate=<?=date('d/m/Y', $selectdate);?>&date=<?=date('d/m/Y', $prox);?>">&#62;</a>
					&nbsp;
					<a href="calendar.php?dateobject=<?=$dateobject;?>&selectdate=<?=date('d/m/Y', $selectdate);?>&date=<?=date('d/m/Y', mktime(0, 0, 0, date('n', $date), date('d', $date), date('Y', $date) + 1));?>">&#62;&#62;</a>
				</th>
			</tr>
			<tr>
				<th style="width:14%">Dom</th>
				<th style="width:14%">Seg</th>
				<th style="width:14%">Ter</th>
				<th style="width:14%">Qua</th>
				<th style="width:14%">Qui</th>
				<th style="width:14%">Sex</th>
				<th style="width:14%">Sab</th>
			</tr>
		</thead>
		<tbody>
<?	$dia = $dtinicio;
	while($dia != $dtfim){?>
		<?=(date('w', $dia) == 0?'<tr>':'');?>
				<td style="text-align:center;vertical-align:middle;<?=($dia == mktime(0, 0, 0)?"border:solid 2px red;":"");?><?=($selectdate == $dia?"background-color:rgb(255,150,150);":"");?>">
<?	if(date('n', $dia) == $mes){?>
					<a href="javascript:setDate(<?=date("'d'\, 'm'\, 'Y'", $dia);?>)" style="display:block">
						<?=date('d', $dia);?>
					</a>
<?	}else{?>
						&nbsp;
<?	}?>
				</td>
			<?=(date('w', $dia) == 6?'</tr>':'');?>
<?	$dia = mktime(0, 0, 0, date('n', $dia), date('d', $dia) + 1, date('Y', $dia));
}?>
		</tbody>
	</table>
	<table style="width:100%">
		<tr>
			<td>
				<div style="float:left;width:20px;height:1em;border:solid 2px red">&nbsp;</div>&nbsp;<a href="calendar.php?selectdate=<?=date('d/m/Y', $selectdate);?>&date=<?=date('d/m/Y', mktime(0,0,0));?>&dateobject=<?=$dateobject;?>">Hoje</a>
			</td>
			<td>
				<div style="float:left;width:20px;height:1em;border:solid 2px rgb(255,150,150);background-color:rgb(255,150,150)">&nbsp;</div>&nbsp;<a href="calendar.php?selectdate=<?=date('d/m/Y', $selectdate);?>&date=<?=date('d/m/Y', $selectdate);?>&dateobject=<?=$dateobject;?>">Selecionado</a>
			</td>
		</tr>
	</table>
</body>
</html>