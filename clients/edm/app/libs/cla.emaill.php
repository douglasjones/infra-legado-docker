<?
class emaill {
	function envia_email($tipo,$codlead,$contato,$msg_body,$descricao,$cod_email_empresa){
        // Script criado por Alexx Ares - alexxares@bol.com.br
        // © 2004 - Pode usar a vontade! 
        
        // Inicialmente, vamos setar os dados de configuração.
        // Podem ser campos enviados por um fórmulário, ou 
        // resgatados do banco de dados... basta adicionar os 
        // scripts que forem necessários.
        // Ex: $nome = "$HTTP_POST_VARS[nome]";
        
        // Primeiro, o nome e email de quem envia
        $nome_r = "Douglas Lopes";
        $email_r = "douglas.lopes@gepros.com.br";
        
        // Depois, nome e email do destinatário
        $nome_d = "Cliente";
        $email_d = "douglas.lopes@gepros.com.br";
        
        // Assunto da mensagem
        $assunto = "Envio de E-mail Proposta";
        
        // Texto principal da mensagem
        $texto = "Texto do seu email. Pode ser formatado com <b>HTML</b>";
        
        // Para enviar cópia oculta, deixe $copia = "sim"
        $copia = "sim";
        
        // Email para cópia oculta. Pode ser uma lista de emails, separados por ","
        $email_c = "email@oculto.com.br";
        if($copia=="sim"){ $bcc = "Bcc: $email_c\n"; } else { $bcc = ""; }
        
        // Pronto, configurado.
        // Agora vamos criar as partes do email, corpo e imagens.
        
        // Abaixo o script para adicionar um logotipo no email.
        // Para cada imagem que for utilizar, copie e cole o script
        // alterando o nome ( no caso, "top" )
        $img_top_nome = "cel.gif";
        $img_top_abre = fopen("images/$img_top_nome", "r");
        $img_top_show = fread($img_top_abre, filesize("images/$img_top_nome"));
        $img_top_code = chunk_split(base64_encode($img_top_show));
        $img_top_cid = "identificador_da_imagem";
        
        // Abaixo vai o código HTML.
        // Lembre-se das regras do PHP, como incluir \ antes de ", etc..
        // Não copie e cole direto do seu Frontpage ou Dreamweaver...
        $body_html = "<html><head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
        </head><body bgcolor=\"#FFFFFF\"><div align=\"center\">
        <table width=\"478\" border=\"0\" cellspacing=\"10\" cellpadding=\"0\"><tr><td>
        <img src=\"cid:$img_top_cid\"></td></tr><tr><td>
        <p><font face=\"Verdana, Arial\" size=\"1\">$texto</font></p>
        <p><font face=\"Verdana, Arial\" size=\"1\"><b>
        Sua assinatura vai aqui!
        </a></b></font></p></td></tr></table></div></body></html>";
        
        // Script para transformar o código em texto simples
        // Não é necessário alterar.
        $body_text = str_replace("<br>","\n",$body_html);
        $body_text = strip_tags("$body_text");
        
        
        // O Email é no formato MIME multipart.
        // Abaixo os separadores das partes
        $sep_0 = "===SEPARADOR_0000000000===";
        $sep_1 = "===SEPARADOR_1111111111===";
        
        // Aqui começa o Header da mensagem. Não é necessário alterar nada.
        $header = "";
        $header.= "From: $nome_r <$email_r>\n";
        $header.= "$bcc";
        $header.= "Content-type: multipart/related; type=\"multipart/alternative\";\n";
        $header.= "              boundary=\"$sep_0\"\n";
        $header.= "MIME-Version: 1.0\n";
        
        // Altere para 1 e para High e o email terá "urgência"
        $header.= "Priority: 3\n";
        $header.= "X-Priority: Normal\n";
        
        // Programa que enviou o email  =)
        $header.= "X-Mailer: Alexx Ares HTML Mail 2004\n";
        $header.= "          © Alexx Ares - alexxares@bol.com.br\n";
        $header.= "\n\n";
        
        // Aviso para emails antigos que não suportam MIME
        $header.= "Esta é uma mensagem multi-partes em formato MIME.\n";
        $header.= "\n";
        $header.= "This is a multi-part message in MIME format.\n";
        $header.= "\n\n";
        
        // Aqui começa o corpo do email. 
        // Ele vai com dois códigos alternativos, HTML e texto puro
        // O próprio programa de email escolhe o melhor
        // No final, vão as imagens.
        $mensagem = "--$sep_0\n";
        $mensagem.= "Content-Type: multipart/alternative; boundary=\"$sep_1\"\n";
        $mensagem.= "\n";
        
        $mensagem.= "--$sep_1\n";
        $mensagem.= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
        $mensagem.= "Content-Transfer-Encoding: 7bit\n";
        $mensagem.= "\n$body_text\n";
        $mensagem.= "\n";
        
        $mensagem.= "--$sep_1\n";
        $mensagem.= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
        $mensagem.= "Content-Transfer-Encoding: 7bit\n";
        $mensagem.= "\n$body_html\n";
        $mensagem.= "\n";
        
        $mensagem.= "--$sep_1--\n";
        $mensagem.= "\n";
        
        // Aqui o código para uma imagem.
        // para mais imagens, copie e cole, alterando o nome "top"
        $mensagem.= "--$sep_0\n";
        $mensagem.= "Content-Type: image/gif; name=\"$img_top_nome\"\n";
        $mensagem.= "Content-Transfer-Encoding: base64\n";
        $mensagem.= "Content-ID: <$img_top_cid>\n";
        $mensagem.= "\n$img_top_code\n";
        $mensagem.= "\n";
        
        // Fim da mensagem!
        $mensagem.= "--$sep_0--";
        
        // Agora é só enviar!!
        $enviar = @mail("$nome_d<$email_d>","$assunto",$mensagem,$header);
        
        print "Funcionou";
        exit;
	}
	function cadastrar($value){
		if(!isset($value['cod_tipoemail'])) $value['cod_tipoemail'] = null;
		if(!isset($value['email_saida'])) $value['email_saida'] = null;
		if(!isset($value['email_assunto'])) $value['email_assunto'] = null;
		if(!isset($value['codtipoocorrencialead'])) $value['codtipoocorrencialead'] = null;
		if(!isset($value['anexo'])) $value['anexo'] = null;
		if(!isset($value['email_texto'])) $value['email_texto'] = null;
		if(!isset($value['status'])) $value['status'] = null;
		if(!isset($value['email_texto'])) $value['email_texto'] = null;
		if(!isset($value['identificacao'])) $value['identificacao'] = null;
		$fields = array();
		$fields['cod_tipoemail'] = $value['cod_tipoemail'];
		$fields['email_saida'] = $value['email_saida'];		
		$fields['email_assunto'] = $value['email_assunto'];				
		$fields['codtipoocorrencialead'] = $value['codtipoocorrencialead'];
		$fields['anexo'] = $value['anexo'];
		$fields['dat_cad'] = 'SYSDATE()';
		$fields['user_cad'] = $_SESSION['codusuario'] ;
		$fields['status'] = $value['status'];
		$fields['email_texto'] = $value['email_texto'];
		$fields['identificacao'] = $value['identificacao'];
		
		$sql = sqlinsert('email_empresa', $fields);
		sql_query($sql);		
	}
	function alterar($value){
		if(!isset($value['cod_tipoemail'])) $value['cod_tipoemail'] = null;
		if(!isset($value['email_saida'])) $value['email_saida'] = null;
		if(!isset($value['email_assunto'])) $value['email_assunto'] = null;
		if(!isset($value['codtipoocorrencialead'])) $value['codtipoocorrencialead'] = null;
		if(!isset($value['anexo'])) $value['anexo'] = null;
		if(!isset($value['email_texto'])) $value['email_texto'] = null;
		if(!isset($value['status'])) $value['status'] = null;
		if(!isset($value['email_texto'])) $value['email_texto'] = null;
		if(!isset($value['identificacao'])) $value['identificacao'] = null;
		
		$fields = array();
		$fields['cod_tipoemail'] = $value['cod_tipoemail'];
		$fields['email_saida'] = $value['email_saida'];		
		$fields['email_assunto'] = $value['email_assunto'];				
		$fields['codtipoocorrencialead'] = $value['codtipoocorrencialead'];
		$fields['anexo'] = $value['anexo'];
		$fields['user_cad'] = $_SESSION['codusuario'] ;
		$fields['status'] = $value['status'];
		$fields['email_texto'] = $value['email_texto'];
		$fields['identificacao'] = $value['identificacao'];

		$sql = sqlupdate('email_empresa', $fields, ' cod_email_empresa = ' . mysqlnull($value['cod_email_empresa']));
		sql_query($sql);		
	}	
}
?> 