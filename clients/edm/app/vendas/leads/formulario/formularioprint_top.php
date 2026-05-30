<?
$codagendalead = $_REQUEST['codagendalead'];

?>
<HTML>
<HEAD>
<TITLE></TITLE>
<LINK rel="stylesheet" type="text/css" href="../libs/Relatorio.css">
<SCRIPT>
<!--
	function Imprimir(){
		//resetaCorpo();
        //resetaCorpo();
		window.parent.frames[1].focus();
		window.parent.Resultado.print();

	}
	

	function selecionar_pagina(){		

		var paginas = "";
		paginas = prompt('Digite os números das páginas separados por ponto-e-virgula:\nEx:2;4;6',document.forms[0].cbopagina.value);

		if (!paginas)
			return false;
			
		var arrPaginas = paginas.split(";");
		var retorno = "";
		var erro = "";
		
		for(i=0;i<arrPaginas.length;i++){
			try{
			retorno += "<div id='dvCabecalho' style='page-break-after:always'>"
			retorno += parent.frames[1].dvCabecalho[arrPaginas[i]-1].innerHTML;
			retorno += "</div>"
			}
			catch(e){
				erro += e.number + ": " + e.description + "\n"
			}
		}

		if(erro!=""){
			//alert("Ocorreram os seguintes erros\n\n" + erro);
			alert("Não foi possível separar as páginas indicadas,\nUtilize o botão Imprimir!");
			return;
		}

		erro = "";

		try{
			document.forms[0].hd_retorno.value = retorno
			document.forms[0].submit();
		}
		catch(e){
			erro += e.number + ": " + e.description + "\n"
		}

		if(erro!=""){
			alert("Não foi possível separar as páginas indicadas,\nUtilize o botão Imprimir!");
			return;
		}

	}

//-->
</SCRIPT>
<script language="Javascript" src="../libs/tamanholetra.js"></script>
</HEAD>
<BODY>
<FORM METHOD=POST ACTION="formularioprint_det.php" target='_blank'>
	<input type="hidden" value="" name="hd_retorno">
	<table cellpadding=0 cellspacing=0 border=0 width="100%">
		<tr>
			<td align="center">
				<!--<input type="Button" value="Excel" onclick="exportarExcel()">&nbsp;&nbsp;-->
				<input type="button" value="Imprimir" onclick="Imprimir()">&nbsp;&nbsp;
				<!--<input type="button" value="Selecionar p&aacute;ginas para impress&atilde;o" onclick="selecionar_pagina()"> &nbsp;&nbsp;
				P&aacute;gina
				<select id="cbopagina" name="cbopagina" onchange="selecionar()">
					<option></option>
				</select>
				<span id="dvLink">
				<a id="buscar" name="buscar" href="#">Ir</a>
				</span>
				&nbsp;&nbsp;Fonte:&nbsp;
				<input type="button" value="+" onclick="aumentaCorpo()">&nbsp;&nbsp;
				<input type="button" value="Reset" onclick="resetaCorpo();">&nbsp;&nbsp;
				<input type="button" value="-" onclick="diminuiCorpo();">&nbsp;&nbsp;	-->		
			</td>
		</tr>
	</table>
</FORM>
<script>opener.location.href=("formularioprint_res.php?Acao=CONS&codagendalead<?=$codagendalead ?>");</script>
</BODY>
</HTML>