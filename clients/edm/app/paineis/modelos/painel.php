<?

include_once "../libs/maininclude.php";

$sites_pk = $_REQUEST['sites_pk'];

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title></title>
    <link rel="stylesheet" href="../libs/public.css" type="text/css" />
    <script language="JavaScript" src="../js/jquery-1.7.2.js"></script>
    <script language="JavaScript" src="../js/public.js"></script>
    <script language="JavaScript" src="../js/FusionCharts.js"></script>
    <script>
    function carregarGraficos(vlr){
		var frm = document.forms[0];
		frm.submit();
	}
	
	function carregarGraficos(){
		
		var frm = document.forms[0];
		
		var chart = new FusionCharts("../swf/MSLine.swf", "ChartId", "1300", "350");
		chart.setDataURL("tx_conversao_loja_x_tx_conversao_media_grupo.php?sites_pk=" + frm.sites_pk.value);		   
		chart.render("tx_conversao_loja_x_tx_conversao_grupo");				

		var chart = new FusionCharts("../swf/MSLine.swf", "ChartId", "1300", "350");
		chart.setDataURL("contagem_loja_x_media_grupo.php?sites_pk=" + frm.sites_pk.value);		   
		chart.render("contagem_loja_x_media_grupo");		
		
		var chart = new FusionCharts("../swf/MSColumn3DLineDY.swf", "ChartId", "1300", "350");
		chart.setDataURL("taxa_conversao_x_contagem.php?sites_pk=" + frm.sites_pk.value);		   
		chart.render("taxa_conversao_x_contagem");		
		
		var chart = new FusionCharts("../swf/MSColumn3DLineDY.swf", "ChartId", "1300", "350");
		chart.setDataURL("contagem_x_ticket_medio.php?sites_pk=" + frm.sites_pk.value);		   
		chart.render("contagem_x_ticket_medio");		
		
		var chart = new FusionCharts("../swf/MSColumn3DLineDY.swf", "ChartId", "1300", "350");
		chart.setDataURL("taxa_conversao_x_ticket_medio.php?sites_pk=" + frm.sites_pk.value);		   
		chart.render("tx_de_conversao_x_ticket_medio");		
		
		var chart = new FusionCharts("../swf/Column3D.swf", "ChartId", "1300", "350");
		chart.setDataURL("contagem_mes.php?sites_pk=" + frm.sites_pk.value);		   
		chart.render("contagem_mes");		
		
	}
	
    </script>
</head>
<body onload='carregarGraficos()'>
<form>
<table width="90%" align='center'>
	<TR>
		<Th>
			Dashboard
		</Th>
	</TR>
	<tr>
		<Td>
			<table align="center">
				<TR>
					<TD class='form'>Site: </TD>
					<TD class='form'>
					<?
						$sql ="select s.pk, s.ds_nome from sites s ";
						$sql.=" where s.empresas_pk = ".$_SESSION['empresas_pk'];
						$sql.=" order by 2 asc ";
						combo($sql, "sites_pk", $sites_pk, "", " onchange='carregarGraficos()'  ", "");
					?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<table width="90%" border="0" cellspacing="0" cellpadding="3" align="center">
	<tr> 
		<td valign="top" class="text" align="center"> 
			<table width="100%" align='center'>
				<TR>
					<Th>
						Tx. Conversão Loja x Tx. Conversão Média do Grupo
					</Th>
				</TR>
			</table>		
			<div id="tx_conversao_loja_x_tx_conversao_grupo" align="center"> 
			</div>
		</td>	
	</tr>		
	<tr> 
		<td valign="top" class="text" align="center"> 
			<table width="100%" align='center'>
				<TR>
					<Th>
						Contagem Loja x Média do Grupo
					</Th>
				</TR>
			</table>		
			<div id="contagem_loja_x_media_grupo" align="center"> 
			</div>
		</td>	
	</tr>			
	<tr> 
		<td valign="top" class="text" align="center"> 
			<table width="100%" align='center'>
				<TR>
					<Th>
						Contagem X Taxa de Conversão
					</Th>
				</TR>
			</table>		
			<div id="taxa_conversao_x_contagem" align="center"> 
			</div>
		</td>	
	</tr>
	<tr> 
		<td valign="top" class="text" align="center"> 
			<table width="100%" align='center'>
				<TR>
					<Th>
						Contagem X Ticket Médio
					</Th>
				</TR>
			</table>		
			<div id="contagem_x_ticket_medio" align="center"> 
			</div>
		</td>	
	</tr>
	<tr> 
		<td valign="top" class="text" align="center"> 
			<table width="100%" align='center'>
				<TR>
					<Th>
						Taxa de Conversão X Ticket Médio
					</Th>
				</TR>
			</table>		
			<div id="tx_de_conversao_x_ticket_medio" align="center"> 
			</div>
		</td>	
	</tr>	
	<tr> 
		<td valign="top" class="text" align="center"> 
			<table width="100%" align='center'>
				<TR>
					<Th>
						Contagem - Acumulado por Mês
					</Th>
				</TR>
			</table>
			<div id="contagem_mes" align="center"> 
			</div>
		</td>	
	</tr>	
<tr>
	<td valign="top" class="text" align="center">&nbsp;</td>
</tr>

</table>
</body>
</html>
<?
include_once "../libs/desconectar.php";
?>
;
