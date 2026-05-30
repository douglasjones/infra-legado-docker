<?php
//----------------------//
//	   editor.php        //
//----------------------//

//------------------------------------------------------------------//
// Editor de Texto com formatação de HTML e Gerador de TAGs         //
// Autor: Fábio Gonçalves       Versão: 2.0    Data: 22/07/2002     //
// limone@catanduva.com.br                                          //
// Participação de pessoas que não se identificaram                 //
// Na distribuição deste identificar o autor                        //
//------------------------------------------------------------------//
?>

<HTML>
<HEAD>
  
<TITLE>Editor</TITLE>
  
<STYLE TYPE="text/css">
    BODY {margin: 0pt; padding: 0pt; border: none}
    IFRAME {width: 100%; border: none}
    SELECT {background-color: #F4F4F4; font-family: "Verdana"; font-size: 8pt;}
    TABLE {width:"100%"; text-align: center}
    INPUT {width: 20px; font-family: "Verdana"; font-size: 8pt;}
    LABEL {font-family: "Verdana"; font-size: 8pt;}
    .heading {BACKGROUND: #FFFFFF}
    .current {color: "red";}
  .ponteiro {
	cursor: hand;
}
</STYLE>
  
<SCRIPT LANGUAGE="JavaScript">
    // O formato default é WYSIWYG HTML.
    var formato="HTML";
    var bMode=true;

    // Exportando funções.
    var public_description = new public_description_nt;
    function public_description_nt() {  
      this.put_html=insere_html;
      this.get_html=retorna_html;
      this.bReady = false
    }

    // Função de limpeza do código fonte.
    function limpaHTML() {
      bodyTags=textEdit.document.body.all
      for (i=bodyTags.tags("FONT").length-1;i >= 0;i--)
        if (bodyTags.tags("FONT")[i].style.backgroundColor="#ffffff") {
          bodyTags.tags("FONT")[i].style.backgroundColor=""
          if (bodyTags.tags("FONT")[i].outerHTML.substring(0,6)=="<FONT>")
            bodyTags.tags("FONT")[i].outerHTML=bodyTags.tags("FONT")[i].innerHTML
        }
    }

    // Função que retorna o texto digitado e formatado.
    // Será chamada no evento OnSubmit do Form.
    function retorna_html() {
      if (formato=="HTML") {
        limpaHTML()
        return textEdit.document.body.innerHTML
      }
	}

    // Função que coloca um texto no editor.
    function insere_html(v) {
      if (formato=="HTML")
        textEdit.document.body.innerHTML=v
	}	

    // Inicializa o editor com um documento em branco.
    function iniciaEditor() {
      textEdit.document.designMode="On"
      textEdit.document.open()
      textEdit.document.write("")
      textEdit.document.close()
      textEdit.focus()
    }

    // Executa um comando no editor.
    // Pelo menos um argumento é requerido. Alguns comandos
    // requerem um segundo argumento opicional:
    // ex., ("formatblock","<H1>") para colocar uma marca <H1>.
    function Formatacao(comando) {
      if (formato=="HTML") {
        if (arguments[1]=="CustomFont") {
	  arguments[1] = prompt("Com qual fonte você deseja formatar o texto?","Verdana, Arial, Helvetica, sans-serif")
	}
        if ((arguments[1]=="") && (arguments[0]=="forecolor")) {
          arguments[1] = prompt("Qual a cor que você deseja?\n(Em inglês ou código hexadecimal)","Black")
        }
        var edit = textEdit.document.selection.createRange()
        if (arguments[1]==null)
          edit.execCommand(comando)
        else
          edit.execCommand(comando,false, arguments[1])
        edit.select()
        textEdit.focus()
      }
    }

    // Função para criação de links.
    function criaLink() {
      var isA = getEl("A",textEdit.document.selection.createRange().parentElement())
      var str=prompt("Para qual URL você quer criar o link? (ex.: http:\/\/www.genisis.kit.net\/)",isA ? isA.href : "http:\/\/")
      if ((str!=null) && (str!="../../..//default.htm")) {
        if ((textEdit.document.selection.type=="None") && (!isA)) {
          var strNome=prompt("Que texto você quer que seja o link?",isA ? isA.href : "texto")
          var sel=textEdit.document.selection.createRange()
          sel.pasteHTML("<A HREF=\""+str+"\" alt=\"blank\">"+strNome+"</A> ")
          sel.select()
        }
        else
          Formatacao("CreateLink",str)
      }
      else
        textEdit.focus()
    }
    function getEl(sTag,start) {
      while ((start!=null) && (start.tagName!=sTag))
        start = start.parentElement
      return start
    }

    // Coloca o foco no editor.
    function setFocus() {
      textEdit.focus()
    }

    window.onload = iniciaEditor
  </SCRIPT>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></HEAD>
<BODY bgcolor="#CCCCCC" leftmargin="0" topmargin="0" OnFocus="setFocus()" SCROLL=No>
<TABLE width="100%" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" ID=editbar3>
  <TR>
    <TD width="788" height="38" noWrap> 
      <table width="100%" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" onClick="setFocus()" id=editbar>
        <tr> 
          <td width="614" height="24" noWrap> <div align="center">
              <SELECT NAME="Paragrafo" id="Paragrafo" onChange="Formatacao('formatBlock',this[this.selectedIndex].value);this.selectedIndex=0;setFocus()">
                <OPTION value="&lt;P&gt;" selected>Normal &lt;P&gt;</OPTION>
                <OPTION value="&lt;H1&gt;">T&iacute;tulo 1 &lt;H1&gt;</OPTION>
                <OPTION value="&lt;H2&gt;">T&iacute;tulo 2 &lt;H2&gt;</OPTION>
                <OPTION value="&lt;H3&gt;">T&iacute;tulo 3 &lt;H3&gt;</OPTION>
                <OPTION value="&lt;H4&gt;">T&iacute;tulo 4 &lt;H4&gt;</OPTION>
                <OPTION value="&lt;H5&gt;">T&iacute;tulo 5 &lt;H5&gt;</OPTION>
                <OPTION value="&lt;H6&gt;">T&iacute;tulo 6 &lt;H6&gt;</OPTION>
                <OPTION value="&lt;PRE&gt;">Pre &lt;PRE&gt;</OPTION>
              </SELECT>
              <SELECT NAME="Fontes" onChange="Formatacao('fontname',this[this.selectedIndex].value);this.selectedIndex=0;setFocus()">
                <OPTION value="Arial, Helvetica, sans-serif" selected>Arial</OPTION>
                <OPTION value="Times New Roman, Times, serif">Times New Roman</OPTION>
                <OPTION value="Courier New, Courier, mono">Courier New</OPTION>
                <OPTION value="Georgia, Times New Roman, Times, serif">Georgia</OPTION>
                <OPTION value="Verdana, Arial, Helvetica, sans-serif">Verdana</OPTION>
                <OPTION value="CustomFont">Outra Fonte...</OPTION>
              </SELECT>
              <SELECT NAME="Tamanhos" onChange="Formatacao('fontSize',this[this.selectedIndex].text);this.selectedIndex=0;setFocus()">
                <OPTION selected>1</OPTION>
                <OPTION>2</OPTION>
                <OPTION>3</OPTION>
                <OPTION>4</OPTION>
                <OPTION>5</OPTION>
                <OPTION>6</OPTION>
                <OPTION>7</OPTION>
              </SELECT>
			 <SELECT NAME="Cores" onChange="Formatacao('forecolor',this[this.selectedIndex].style.color);this.selectedIndex=0;setFocus()">
				<OPTION class="heading" style="COLOR: black" SELECTED>Preto</OPTION>
				<OPTION style="COLOR: gray">Cinza</OPTION>
				<OPTION style="COLOR: white">Branco</OPTION>
				<OPTION style="COLOR: yellow">Amarelo</OPTION>
				<OPTION style="COLOR: blue">Azul</OPTION>
				<OPTION style="COLOR: green">Verde</OPTION>
				<OPTION style="COLOR: red">Vermelho</OPTION>
				<OPTION style="COLOR: pink">Rosa</OPTION>
				<OPTION style="COLOR: brown">Marrom</OPTION>
				<OPTION>Outra...</OPTION>
			</SELECT>
              <img src="imagens/linha1.gif" width="2" height="18"><img src="imagens/negrito.gif" alt="Negrito" class="ponteiro" onClick="Formatacao('Bold');setFocus();"> 
              <img src="imagens/italico.gif" onClick="Formatacao('Italic');setFocus();" alt="Itálico" class="ponteiro"> 
              <img src="imagens/sublinhado.gif" onClick="Formatacao('Underline');setFocus();" alt="Sublinhado" class="ponteiro"> 
              <img src="imagens/linha1.gif" width="2" height="18"><img src="imagens/al_esq.gif" onClick="Formatacao('JustifyLeft');setFocus();" alt="Alinhar &agrave; esquerda" class="ponteiro"> 
              <img src="imagens/al_centro.gif" onClick="Formatacao('JustifyCenter');setFocus();" alt="Centralizar" class="ponteiro"> 
              <img src="imagens/al_dir.gif" onClick="Formatacao('JustifyRight');setFocus();" alt="Alinhar &agrave; direita" class="ponteiro"> 
              <img src="imagens/linha1.gif" width="2" height="18"> <img src="imagens/lista_ord.gif" onClick="Formatacao('insertorderedlist');setFocus();" alt="Numeração" class="ponteiro"> 
              <img src="imagens/lista_nord.gif" onClick="Formatacao('insertunorderedlist');setFocus();" alt="Marcadores" class="ponteiro"> 
              <img src="imagens/linha1.gif" width="2" height="18"><img src="imagens/av_tab.gif" onClick="Formatacao('indent');setFocus();" alt="Identar" class="ponteiro">&nbsp; 
              <img src="imagens/rec_tab.gif" onClick="Formatacao('outdent');setFocus();" alt="Recuar" class="ponteiro"> 
              <img src="imagens/linha1.gif" width="2" height="18"><img src="imagens/link.gif" onClick="criaLink();setFocus();" alt="Inserir Link" class="ponteiro"></div></td>
        </tr>
      </table>
      <font size="1" face="Verdana, Arial, Helvetica"> <strong><font color="#000000">(Shift 
      + Enter -Pr&oacute;xima linha)</font></strong></font> </TD>
  </TR>
</TABLE>
<IFRAME ID=textEdit WIDTH="93" HEIGHT="145"></IFRAME> 
</BODY>
</HTML>
