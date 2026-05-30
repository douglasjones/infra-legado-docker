
<html>
<head>
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="-1" />
	
	<title></title>
	<script src="../../extras/FusionCharts.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../../extras/consulta.css" type="text/css">	
	<script>
		var intervalo = window.setInterval(exibirGrafico, 16500);
	
		function exibirGrafico(){
			var chart = new FusionCharts("../swf/FCF_StackedBar2D.swf", "ChartId", "1200", "600");
			chart.setDataURL("ocorrencias_geradas_dia.php");		   
			chart.render("painel_dia");					
		}
	</script>
</head>
<body onload="exibirGrafico()">
<table align="center">
	<tr>
		<td align="center">
			<font face="Arial" size="+2"><b><span id="titulo">Ocorrências Geradas<br>(Dia)</span></b></font>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="1" cellspacing="1">
	<tr>
		<td align="center">
			<span id="painel_dia" align="center"></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="form" align="center">
			<b>By Gepros</b>
		</td>
	</tr>
</table>
</body>
</html>
