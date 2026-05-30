<?
    include_once("../../libs/mpdf/mpdf.php");
	include_once '../../libs/conectar.php';
	
	conectar();
?>
<script>
		function selecionaPolo(vlr){
			var frm = document.forms[0];
			frm.submit();
		}
		
		function carregarGraficos(v_cod_polo){
			var chart = new FusionCharts("../swf/FCF_Funnel.swf", "ChartId", "250", "300");
			chart.setDataURL("funil_xml.php?cod_polo="+v_cod_polo);		   
			chart.render("div_funil");
			
			var chart = new FusionCharts("../swf/FCF_Column3D.swf", "ChartId", "500", "350");
			chart.setDataURL("contratos_fechados_xml.php?cod_polo="+v_cod_polo);
			chart.render("div_contratos_fechados");
			
			var chart = new FusionCharts("../swf/FCF_Column3D.swf", "ChartId", "500", "350");
			chart.setDataURL("oportunidades_xml.php?cod_polo="+v_cod_polo);		   
			chart.render("div_oportunidades");
			
			var chart = new FusionCharts("../swf/FCF_Column3D.swf", "ChartId", "500", "350");
			chart.setDataURL("oportunidades_a_vencer_xml.php?cod_polo="+v_cod_polo);		   
			chart.render("div_oportunidades_a_vencer");
			
			var chart = new FusionCharts("../swf/FCF_StackedColumn3D.swf", "ChartId", "500", "350");
			chart.setDataURL("agendamento_xml.php?cod_polo="+v_cod_polo);
			chart.render("div_agendamento");
			
			var chart = new FusionCharts("../swf/FCF_StackedBar2D.swf", "ChartId", "500", "350");
			chart.setDataURL("ocorrencias_xml.php?cod_polo="+v_cod_polo);
			chart.render("div_ocorrencias");

			var chart = new FusionCharts("../swf/FCF_StackedBar2D.swf", "ChartId", "500", "350");
			chart.setDataURL("ocorrencias_xml.php?cod_polo="+v_cod_polo);
			chart.render("div_produtividade_comercial");
			
		}
		
	</script>


<?	
	
				
			$header .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0' >";
			$header .=	"<tr>";
			$header .=		"<td width='50%' align='left'>";
			$header .=			"<div><img src='../../images/logo/logo.png' alt='' width='120'  /></div>";
			$header .=		"</td>";
			$header .=		"<td  align='right'>";
			$header .=			"<div><img src='../../images/logo/".$v_operadora.".png' alt='' width='120' width='120'  /></div>";
			$header .=		"</td>";
			$header .=	"</tr>";
			$header .="</table>";
			
			$html .="<p>";			
			$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
			$html .=	"<tr>";
			$html .=		"<td  align='right'>";
			$html .=			"<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>";
			$html .=				$v_cidade."&nbsp;,".$dia."&nbsp;de&nbsp;".$mes_extenso["$mes"]."&nbsp;de&nbsp;".$ano;
			$html .=			"</font>";
			$html .=		"</td>";
			$html .=	 "</tr>";
			$html .="</table>";		
				
			
		
		$footer.="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
		if(!empty($gerenteconta)){	            
			
			$footer .=	"<tr>";
			$footer .=		"<td class='texto' align='left' >";
			$footer .=			"<b>";
			$footer .=			$gerenteconta;
			$footer .=			"</b>";					
			$footer .=		"</td>";
			$footer .=	"</tr>";
			if(!empty($tel)){
				$footer .=	"<tr>";
				$footer .=		"<td class='texto'  align='left' >";
				$footer .=			"<b> ";
				$footer .=			"Cel.: (".$ddd_tel.") ".$tel;
				$footer .=			"</b>";					
				$footer .=		"</td>";
				$footer .=	"</tr>";
			}			

			if(!empty($gerenteemail)){
				$footer .=	"<tr>";
				$footer .=		"<td class='texto' align='left' >";
				$footer .=			"<b>";
				$footer .=			"Email: ".$gerenteemail;
				$footer .=			"</b>";					
				$footer .=		"</td>";
				$footer .=	"</tr>";
			}				
		}	
		$footer.=	"<tr>";
		$footer.=		"<td class='texto' align='center' >";	
		$footer.=			"&nbsp;";			
		$footer.=		"</td>";
		$footer.=	"</tr>";
		$footer.=	"<tr>";
		$footer.=		"<td  class='texto' align='center' >";
		$footer.=			$v_dsc_rodape;
		$footer.=		"</td>";
		$footer.=	"</tr>";	
		$footer.=	"<tr>";
		$footer.=		"<td class='texto'  align='right' >";
		$footer.=			'{PAGENO}/{nb}';
		$footer.=		"</td>";
		$footer.=	"</tr>";					
		$footer.="</table>";
		$mpdf=new mPDF('', // mode - default '' 
						'',    // format - A4, for example, default '' 
						0,     // font size - default 0 
						'',    // default font family 
						15,    // margin_left
						15,    // margin right 
						45,     // margin top
						45,    // margin bottom 
						9,     // margin header 
						2,     // margin footer 
						'L' );
	$mpdf->charset_in='iso-8859-1';
	$mpdf->SetHTMLHeader($header);	
    $mpdf->SetHTMLFooter($footer);
	 
	$mpdf->WriteHTML($html);
	$mpdf->Output();

	exit();

	mysql_close($con);

?>
