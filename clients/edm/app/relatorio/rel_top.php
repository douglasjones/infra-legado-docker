<?	$rel = "../".$_GET['dirrel']."/".$_GET['pgrel'];
	$param = "";
	foreach($_GET as $nome => $parametro){
		if($nome != 'pgrel' && $nome != 'dirrel' && $nome != 'Acao') $param .= "&".$nome."=".$parametro;
	}?>
<HTML>
<HEAD>
<TITLE>Relatório</TITLE>
<LINK rel="stylesheet" type="text/css" href="../extras/relatorio.css">
<link rel="stylesheet" type="text/css" href="../extras/publicprint.css" media="print" />
<link rel="stylesheet" type="text/css" href="../extras/datepicker.css" />
<SCRIPT language="javascript">

	function Imprimir(){
		//reseta as alterações de FONTE!
		//resetaCorpo();
		window.parent.frames[1].focus();
		window.parent.Resultado.print();
	}

	function exportarExcel(){
		parent.Resultado.location.href=("print/rel_print.php?rel=<?=$rel;?><?=$param;?>");
	}
	
	function aumenta()
	{
		var topo = document.getElementById( 'teste' ).innerHTML ;
		var rel  = parent.Resultado.document.childNodes ;
		alert( topo ) ;
		//topo = rel ;
		//alert( topo ) ;
	}


</SCRIPT>

</HEAD>
<BODY>

<FORM METHOD="POST" ACTION="">
	<table cellpadding=0 cellspacing=0 border=0 width="100%">
		<tr>
			<td align="center">
				<input type="Button" value="Excel" onclick="exportarExcel()" />&nbsp;&nbsp;
				<input type="button" value="Imprimir" onclick="Imprimir()" />&nbsp;&nbsp;
				<!--<input type="button" value="Selecionar páginas para impressão" onclick="selecionar();" />&nbsp;&nbsp;
				Fonte: <input type="button" value="+" onclick="aumenta();" />&nbsp;&nbsp;
				<input type="button" value="Reset" onclick="resetar();" />&nbsp;&nbsp;
				<input type="button" value="-" onclick="diminui();" />&nbsp;&nbsp;
				<input type="button" value="Selecionar p&aacute;ginas para impress&atilde;o" onclick="selecionar_pagina()"> &nbsp;&nbsp;
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
<?	$link = $_GET['dirrel']."/".$_GET['pgrel']."?Acao=CONS";
	foreach($_GET as $nome => $parametro){
		if($nome != 'pgrel' && $nome != 'dirrel' && $nome != 'Acao') $link .= "&".$nome."=".$parametro;
	}?>
<script>parent.Resultado.location.href=("<?=$link;?>");</script>
</BODY>
</HTML>