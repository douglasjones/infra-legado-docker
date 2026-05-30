function carregar(){
	carregarGraficoPizza();
}

function calcularPercentuais(){
	var dblTotal = 0;
	var tbl = document.getElementById("grid");
	for (i = 0 ; i < tbl.rows.length; i++){
		dblTotal += parseInt(tbl.rows[i].cells[tbl.rows[i].cells.length - 2].innerHTML);
	}
	for (i = 0 ; i < tbl.rows.length; i++){
		tbl.rows[i].cells[tbl.rows[i].cells.length - 1].innerHTML = float2moeda((parseInt(tbl.rows[i].cells[tbl.rows[i].cells.length - 2].innerHTML) / dblTotal) * 100);
	}
}

function capturarDadosPizza(strTitulo, intIndice){
	
	var tbl = document.getElementById("grid");
	
	var intMaior = 0;
	//Pesquisa o maior.
	for(i = 0; i < tbl.rows.length; i++){
		if(!isNaN(parseInt(tbl.rows[i].cells[intIndice].innerHTML))){
			if(intMaior < parseInt(tbl.rows[i].cells[intIndice].innerHTML))
				intMaior = parseInt(tbl.rows[i].cells[intIndice].innerHTML);
		}
	}
	
	var strXML ="";
	strXML+="<chart palette='4' caption='"+strTitulo+"' bgColor='FFFFFF'>\n";
	for(i = 0; i < tbl.rows.length; i++){
		if(!isNaN(parseInt(tbl.rows[i].cells[intIndice].innerHTML))){			
			strXML += "<set label='"+tbl.rows[i].cells[0].innerHTML.trim()+"' value='"+tbl.rows[i].cells[intIndice].innerHTML.trim()+"' ";
			if(intMaior == parseInt(tbl.rows[i].cells[intIndice].innerHTML))
				strXML += " isSliced='1' ";
			strXML += " />";
		}
	}
	strXML+="</chart>";
	
	return strXML;
	
}

function carregarGraficoPizza(){
	
	var strXMLPizza = capturarDadosPizza("Total", 6);
	var chart = new FusionCharts("../swf/Pie2D.swf", "ChartId", "600", "300");
	chart.setDataXML(strXMLPizza);
	chart.render("grafico_total");	
	
	var tbl = document.getElementById("cabecalho");
	for (z = 1 ; z < tbl.rows[0].cells.length - 1; z++){
		
		var strXMLPizza = capturarDadosPizza(tbl.rows[0].cells[z].innerHTML, z);
		var strObj = "div_"+z;
		var chart = new FusionCharts("../swf/Pie2D.swf", "ChartId", "600", "300");
		chart.setDataXML(strXMLPizza);
		chart.render(strObj);			
		
	}

	

}
