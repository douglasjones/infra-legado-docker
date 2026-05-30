<?php
//----------------------//
//	   index.php        //
//----------------------//

//------------------------------------------------------------------//
// Editor de Texto com formatação de HTML e Gerador de TAGs         //
// Autor: Fábio Gonçalves       Versão: 2.0    Data: 22/07/2003     //
// limone@catanduva.com.br                                          //
// Participação de pessoas que não se identificaram                 //
// Na distribuição deste identificar o autor                        //
//------------------------------------------------------------------//
?>

<HTML>
<HEAD>
<TITLE>Editor de Html e Gerador de TAGs</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</HEAD>

<script language="JavaScript">
function ImpTAGs(){

document.form.texto2.value = document.all.Editor.html;

}

function ExpTAGs(){

	document.all.Editor.html = document.form.texto2.value;

}

</script>


<BODY bgcolor="#CCCCCC" leftmargin="7" topmargin="0">
<form name="form" method="get">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Texto 
        com forma&ccedil;&atilde;o</strong></font></td>
    </tr>
    <tr> 
      <td> </td>
    </tr>
    <tr>
      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Texto 
        com TAGs HTML</strong></font></td>
    </tr>
    <tr> 
      <td><textarea name="texto2" cols="92" rows="8" id="texto2"></textarea></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="center"> 
          <input type="button" name="Submit" value="Ver C&oacute;digo HTML" onClick="ImpTAGs()">
          &nbsp; 
          <input type="button" name="Submit2" value="Ver Texto Formatado" onClick="ExpTAGs()">
        </div></td>
    </tr>
  </table>
  </form>
</BODY>
</HTML>
