<html>
<head>
	<title></title>
	<script src="../../extras/FusionCharts.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../../extras/consulta.css" type="text/css">	
	<script>
		function exibirGrafico(){
			var chart = new FusionCharts("../swf/FCF_Funnel.swf", "ChartId", "450", "550");
			chart.setDataURL("contratos_status.php");		   
			chart.render("funil_vendas");		
		}
	</script>
</head>

<body onload="exibirGrafico()">
	<center><b><font face='arial' size="2">Funil de Vendas - Quantidade de Linhas</font></b></center>
	<div id="funil_vendas" align="center"></div>
</body>
</html>
