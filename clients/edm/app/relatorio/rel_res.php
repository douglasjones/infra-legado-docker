<?function cabecalho(){?>	<table cellpadding=0 cellspacing=0 border=0 width='617'>	<tr>	<td><img src='../images/neo_logo1.gif'></td>	</tr>
	<tr>	<td align='center'><span class=Cabecalho>	<B>Nome do Relatorio</B>	</span></td>	</tr>	</table>	<br><?}function rodape($pagina,$valign){	$str_align ;sz	/*if($valignt = "L"){		$str_align = "Left";	}	if($valignt = "C"){		$str_align = "Center";			}	if($valignt = "R"){		$str_align = "Right";	}*/?>	</table>	<br>	<table width=617 cellpadding=0 cellspacing=0 border=0>
		<tr>
			<td align=<?=$str_align?>>
				<b>Página:<?=$pagina?></b>
			</td>
		</tr
	</table>

<?
}
function linha($arrvalor){
?>
	<tr>
		<?//for(1 = 0  $arrvalor){?>
		<td>
			funcao linha
		</td>
		<?//}?>
	</tr>	
<?
}

function imprimetitulo() {
	if($_REQUEST['execel']==""){
?>
	<tr class=Titulo>
		<td width=5% align=center><span class=Titulo>#</span></td>
		<td class=Titulo nowrap align=Center width=5%><a href='rel_res.php?'><span class=Titulo>Coluna1</span></a></td>
		<td class=Titulo nowrap align=Center width=5%><a href='rel_res.php?'><span class=Titulo>Coluna2</span></a></td>
	</tr>
<?
	}else{
?>
	<tr class=Titulo>
		<td width=5% align=center><span class=Titulo>#</span></td>
		<td class=Titulo nowrap align=Center width=5%><span class=Titulo>Coluna1</span></td>
		<td class=Titulo nowrap align=Center width=5%><span class=Titulo>Coluna2</span></td>
	</tr>		
<?
	}
}
function  imprimirtitulomeio(){
?>
	<tr class=Titulo>
		<td width=5% align=center><span class=Titulo>#</span></td>
		<td class=Titulo nowrap align=Center width=5%><span class=Titulo>Coluna1</span></td>
		<td class=Titulo nowrap align=Center width=5%><span class=Titulo>Coluna2</span></td>
	</tr>
<?
}
function imprimirtotal($ptotal){
?>
	</tr>
	<tr>
		<td Class=Titulo colspan=2 align=Right><span class=Titulo>
		&nbsp;
		</td>
		<td class=Titulo nowrap align='Center'><span class=Titulo>Total Coluna1</span></td>
		<td class=Titulo nowrap align='Center'><span class=Titulo>Total Coluna2</span></td>
	</tr>
	</table>
	
<?
}
cabecalho();
rodape(2,C);
linha();
imprimetitulo();
imprimirtitulomeio();
imprimirtotal();
//linha(2);
/*

*/




		
		
?>