
<html>
<head>
	<META HTTP-EQUIV="Refresh" Content="1800">
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="-1" />
	
	<title></title>
	<script src="../../extras/FusionCharts.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../../extras/consulta.css" type="text/css">	
	<script>
		
		var indice = 1;
		var intervalo = window.setInterval(exibirGrafico, 16500);
	
		function exibirGrafico(){
			
			if(indice == 1){
				titulo.innerHTML = "Ocorrências Geradas<br>(Dia)";
				var chart = new FusionCharts("../swf/FCF_StackedBar2D.swf", "ChartId", "1200", "600");
				chart.setDataURL("ocorrencias_geradas_dia.php");		   
				chart.render("painel_dia");					
				indice = 2;
			}
			else if(indice == 2){
				titulo.innerHTML = "Contratos<br>(Dia)";
				var chart = new FusionCharts("../swf/FCF_StackedBar2D.swf", "ChartId", "1200", "600");
				chart.setDataURL("contratos_gerados_dia.php");
				chart.render("painel_dia");		
				indice = 3;
			}
			else if(indice == 3){
				titulo.innerHTML = "Contratos<br>(Mês)";
				var chart = new FusionCharts("../swf/FCF_StackedBar2D.swf", "ChartId", "1200", "600");
				chart.setDataURL("contratos_gerados_mes.php");		   
				chart.render("painel_dia");		
				indice = 1;			
			}
			
		}
	</script>
</head>
<body onload="exibirGrafico()">
<table align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<font face="Arial" size="+2"><b><span id="titulo"></span></b></font>
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
