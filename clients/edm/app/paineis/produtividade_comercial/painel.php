<?
include_once "../../libs/maininclude.php";

$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i:%s') horaatual ";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$horaatual = $row['horaatual'];
mysql_free_result($result);

?>
<html>
<head>
	<META HTTP-EQUIV="Refresh" Content="300">
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="-1" />
	
	<title></title>
	<script src="../../extras/FusionCharts.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../../extras/consulta.css" type="text/css">	
	<style>
	.titulo{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		FONT-SIZE: 28px;
		color : #ffffff;
		font-weight : bold;
		text-align : center ;
		background-image: url("../../images/barra_topo.png");*/
	}	
	.form{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		FONT-SIZE: 28px;
		font-weight : bold;
	}		
	
	.linha{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		FONT-SIZE: 26px;
	}
	
	.linha1{
		background-color: #E5E5E5;
		font-family: Verdana, Arial, Helvetica, sans-serif;
		FONT-SIZE: 26px;
	}
		
	
	.grid{
		background-image: url("../../images/header_bg.gif");
		width:100%;
		height:30;
		text-decoration:none;

		font-family: Verdana, Arial, Helvetica, sans-serif;
		FONT-SIZE: 28px;
		color : #000000;
		font-weight : bold;
		text-align : center ;
	}
	</style>	
</head>
<body onload="exibirGrafico()">
<table align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<font face="Arial" size="+2"><b><span id="titulo"></span></b></font>
		</td>
	</tr>
</table>
<table align="center" width="100%">
	<TR><TD align="center" class='titulo'>Produtividade Comercial - Dia <?= $horaatual;?></TD></TR>
</table>							
<table width='100%'>
	<tr class=grid>
			<th>
				Consultor
			</th>
			<th>
				Prospec.
			</th>						
			<th>
				Qtde Opor.
			</th>
			<th>
				Ocorr.
			</th>
			<th>
				Visitas
			</th>
	</tr>
	<?
	
	//Pega o nome dos consultores ativos
	$sql ="";
	$sql.="select ui.codusuariointerno, ui.nome ";
	$sql.="  from usuariosinternos ui ";
	$sql.=" where ui.desativado = -1 ";
	$sql.="   and ui.gerentecontas = 1 ";
	$sql.=" order by ui.nome ";
	
	$result = mysql_query($sql);
	$cor = 0;
	
	while($row = mysql_fetch_array($result)){
		
		if ($cor == 0){
			echo "<tr class='linha'>";
			$cor = 1;
		}
		else{
			echo "<tr class='linha1'>";
			$cor = 0;
		}
		echo "<td>".$row['nome']."</td>";
		
		$sql ="";
		$sql.="select l.codlead  ";
		$sql.="  from leads l ";
		$sql.="       inner join contatoslead cl on l.codlead = cl.codlead ";
		$sql.=" where l.datacadastro between date_format(sysdate(), '%Y-%m-%d 00:00:00') and  date_format(sysdate(), '%Y-%m-%d 23:59:59') ";
		$sql.="   and l.usuariocadastro = ".$row['codusuariointerno'];
		$sql.=" group by l.codlead ";
		$rs_item = mysql_query($sql);
		$num = mysql_num_rows($rs_item);
		echo "<td align='center'>".$num."</td>";
		mysql_free_result($rs_item);

		$sql ="";
		$sql.="select count(0) total ";
		$sql.="  from ocorrenciaslead oc ";
		$sql.=" where codtipoocorrencialead = 5000 ";
		$sql.="   and oc.datacadastro between date_format(sysdate(), '%Y-%m-%d 00:00:00') and  date_format(sysdate(), '%Y-%m-%d 23:59:59') ";					
		$sql.="   and oc.codusuariointerno = ".$row['codusuariointerno'];
		$rs_item = mysql_query($sql);
		$row_oportunidade = mysql_fetch_array($rs_item);
		echo "<td align='center'>".$row_oportunidade['total']."</td>";
		mysql_free_result($rs_item);
		
		$sql ="";
		$sql.="select count(0) total ";
		$sql.="  from ocorrenciaslead oc ";
		$sql.=" where oc.datacadastro between date_format(sysdate(), '%Y-%m-%d 00:00:00') and  date_format(sysdate(), '%Y-%m-%d 23:59:59') ";					
		$sql.="   and oc.codusuariointerno = ".$row['codusuariointerno'];
		$sql.="   and oc.codtipoocorrencialead <> 77 ";
		$rs_item = mysql_query($sql);
		$row_oportunidade = mysql_fetch_array($rs_item);
		echo "<td align='center'>".$row_oportunidade['total']."</td>";
		mysql_free_result($rs_item);					

		$sql ="";
		$sql.="select count(0) total  ";
		$sql.="  from agendaslead al  ";
		$sql.="		inner join agendagerenteconta agc on al.codagendalead = agc.codagendalead ";
		$sql.=" where (al.codstatus not in (3, 4) or al.codstatus is null) ";
		$sql.="   and agc.codgerenteconta = ".$row['codusuariointerno'];
		$sql.="   and al.datahorario between date_format(sysdate(), '%Y-%m-%d 00:00:00') and  date_format(sysdate(), '%Y-%m-%d 23:59:59') ";		
		$sql.="   and al.codreagendamento is null ";
		
		$rs_item = mysql_query($sql);
		$row_oportunidade = mysql_fetch_array($rs_item);
		echo "<td align='center'>".$row_oportunidade['total']."</td>";
		mysql_free_result($rs_item);					
		echo "</tr>";
	}
	mysql_free_result($result);
	
	?>
</table>
	
</body>
</html>
<?
include_once "../../libs/desconectar.php";
?>
