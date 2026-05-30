<?
    include_once "../../libs/maininclude.php";

	$codlead = $_REQUEST['codlead'];
	$sql = "";
	$sql.= "Select a.*";
	$sql.= ", u1.Nome AgendadoPor";
	$sql.= ", u2.Nome as NomeAgendadoPara";
	$sql.= ", s.Descricao as Status, t.Descricao as Tipo ";
	$sql.= ", l.RazaoSocial ";
	$sql.= ", CONCAT(a.Endereco, IFNULL(CONCAT(', ', a.Numero), ''), IFNULL(CONCAT(' - ', a.Complemento), '')) Endereco1 ";
	$sql.= ", CONCAT(a.Bairro, IFNULL(CONCAT(' - ', a.Cidade), ''), IFNULL(CONCAT('/',a.UF), ''), IFNULL(CONCAT(' - ', a.CEP), '')) Endereco2";
	$sql.= "	From agendaslead a";
	$sql.= "	left join leads l on a.CodLead = l.CodLead";
	$sql.= "	left Join usuariosinternos u1 on a.CodUsuarioInterno = u1.CodUsuarioInterno";
	$sql.= "	left Join usuariosinternos u2 on a.AgendadoPara = u2.CodUsuarioInterno";
	$sql.= "	Left Join statusagendamento s on a.CodStatus = s.CodStatus";
	$sql.= "	left Join tipoagendamento t on a.CodTipo = t.CodTipo";
	$sql.= " 	Where 1 ";
	$sql.= "	and a.Codlead = $codlead";
	$sql.= "	Order by a.DataHorario Desc";
	$result = sql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">

    <!--Cabeçalho-->
	<title>Visualizar Agenda do Lead</title>
	
<?	include_once "../../libs/head.php";?>

	<script type="text/javascript" language="javascript">
function window_Agenda(codagenda){
	NewWindow("leadsagendanew.php?codagendalead="+codagenda+"&HistoricoAgenda=1",590,600)
}

function AgendaCancelada(vrl){
	alert('Agenda ' + vrl + ' Cancelada cadastre uma nova !!');
	window.close()
}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
<?	while($row = mysql_fetch_array($result)){?>
		<thead>
			<tr>
				<th colspan="7" bgcolor="#336699"><font color="#FFFFFF"> <?=date('d/m/Y \- H:i', strtotime($row['DataHorario']));?></font></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>&nbsp;Codigo</td>
				<td colspan="3">
<?		if(permissao('agenda', array('al', 'dt'))){?>
					<a href="javascript:window_Agenda(<?=$row['CodAgendaLead'];?>)"><?=$row['CodAgendaLead'];?></a>
<?		}else{?>
					<?=$row['CodAgendaLead'];?>
<?		}?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;Tipo Agendamento</td>
				<td><?=$row['Tipo'];?></td>
				<td>&nbsp;Status</td>
				<td <?=(empty($row['Status'])?'style="color:red; font-weight:bold"':null);?>><?=(empty($row['Status'])?'Sem classificação':$row['Status']);?></td>
			</tr>
			<tr>
				<td>&nbsp;Gerente(s) Conta</td>
				<td colspan="3">
<?		$sql = "Select u.Nome";
		$sql .= " From agendagerenteconta agc";
		$sql .= " Left Join usuariosinternos u on agc.CodGerenteConta = u.CodUsuarioInterno";
		$sql .= " Where agc.CodAgendaLead=".$row['CodAgendaLead'];
		$result1 = sql_query($sql);
		while($row1 = mysql_fetch_array($result1)){?>
					<?=$row1['Nome'];?><br />
<?		}?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;Agendado por</td>
				<td><?=$row['AgendadoPor'];?></td>
				<td>&nbsp;Agendado para</td>
				<td><?=$row['NomeAgendadoPara'];?></td>
			</tr>
			<tr>
				<td>&nbsp;Lead</td>
				<td colspan="3"><?=$row['RazaoSocial'];?></td>
			</tr>
			<tr>
				<td>&nbsp;Endereço</td>
				<td colspan="3"><?=$row['Endereco1'];?><br /><?=$row['Endereco2'];?></td>
			</tr>
			<tr>
				<td>&nbsp;Descrição</td>
				<td colspan="3"><?=$row['Descricao'];?></td>
			</tr>
<?	}
	mysql_free_result($result);
	//mysql_free_result($result1);?>
		</tbody>
		<tfoot>
				<tr>
			<td colspan="6">
				&nbsp;
			</td>
		</tr>
			<tr>
				<th colspan="6" align="right">
					<input type="button" name="fechar" value="Fechar" onclick="self.close()" />&nbsp;
				</th>
			</tr>
		</tfoot>
	</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
