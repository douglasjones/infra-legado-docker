<?   

class email {
   function envia_email_agendamento($html,$emailde,$emailpara,$body,$msg_body,$assunto,$operador_pk){       
       
        $from = $emailde;//de:
        $to = $emailpara;//para:
        $body = $html;
        //$cc = "douglas.lopes@gepros.com.br";
        $mailheaders = "From: $from\n";
        $mailheaders .= "Reply-To: $ReplyTo\n";
        $mailheaders .= "Cc: $emailde\n";
        $mailheaders .= "Bcc: $bcc\n";
        $mailheaders .= "X-Mailer: $assunto \n";

        $msg_body = stripslashes($body);

        $mailheaders .= "MIME-version: 1.0\n";
        $mailheaders .= "Content-type: multipart/mixed; ";
        $mailheaders .= "boundary=\"Message-Boundary\"\n";
        $mailheaders .= "Content-transfer-encoding: 7BIT\n";
        //if(!empty($anexo)){
        //	$mailheaders .= "X-attachments: $attach_name";
        //}
        $body_top = "--Message-Boundary\n";
        $body_top .= "Content-type: text/html; charset=US-ASCII\n";
        $body_top .= "Content-transfer-encoding: 7BIT\n";
        $body_top .= "Content-description: Mail message body\n\n";

        $msg_body = $body_top . $msg_body;

        $msg_body .= "\n\n--Message-Boundary\n";
        $msg_body .= "Content-Transfer-Encoding: BASE64\n";
        //$msg_body .= "Content-disposition: attachment; filename=\"$attach_name\"\n\n";
        //$msg_body .= "$encoded_attach\n";
        $msg_body .= "--Message-Boundary--\n";

        mail($to, stripslashes($assunto), $msg_body, $mailheaders);           
        //REGISTRO DE OCORRENCIA
        if(!empty($descricao)){
                ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => $descricao, 'codtipoocorrencialead' => $tipoocorrencia));

        }
    }
    function envia_email_bko($html,$emailpara,$body,$msg_body,$assunto,$operador_pk,$emailde){       
          
        $from = $emailde;//de:
        $to = $emailpara;//para:
        $body = $html;
        //$cc = "douglas.lopes@gepros.com.br";
        $mailheaders = "From: $from\n";
        $mailheaders .= "Reply-To: $from\n";
        $mailheaders .= "Cc: $cc\n";
        $mailheaders .= "Bcc: $bcc\n";
        $mailheaders .= "X-Mailer: $assunto \n";

        $msg_body = stripslashes($body);

        $mailheaders .= "MIME-version: 1.0\n";
        $mailheaders .= "Content-type: multipart/mixed; ";
        $mailheaders .= "boundary=\"Message-Boundary\"\n";
        $mailheaders .= "Content-transfer-encoding: 7BIT\n";
        //if(!empty($anexo)){
        //	$mailheaders .= "X-attachments: $attach_name";
        //}
        $body_top = "--Message-Boundary\n";
        $body_top .= "Content-type: text/html; charset=US-ASCII\n";
        $body_top .= "Content-transfer-encoding: 7BIT\n";
        $body_top .= "Content-description: Mail message body\n\n";

        $msg_body = $body_top . $msg_body;

        $msg_body .= "\n\n--Message-Boundary\n";
        $msg_body .= "Content-Transfer-Encoding: BASE64\n";
        //$msg_body .= "Content-disposition: attachment; filename=\"$attach_name\"\n\n";
        //$msg_body .= "$encoded_attach\n";
        $msg_body .= "--Message-Boundary--\n";

        mail($to, stripslashes($assunto), $msg_body, $mailheaders);           
        //REGISTRO DE OCORRENCIA
        if(!empty($descricao)){
                ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => $descricao, 'codtipoocorrencialead' => $tipoocorrencia));

        }
    }
    function envia_email_proposta($html,$emailde,$emailpara,$body,$msg_body,$assunto,$operador_pk,$nomecontato,$leads_pk,$email_consultor){  
        $from = $emailde;//de:
        $to = $emailpara;//para:
        $body = $html;
        $mailheaders = "From: $from\n";
        $mailheaders .= "Reply-To: $ReplyTo\n";
        $mailheaders .= "Cc: $email_consultor\n";//copia
        $mailheaders .= "Bcc: $bcc\n";
        $mailheaders .= "X-Mailer: $assunto \n";

        $msg_body = ($body);

        $mailheaders .= "MIME-version: 1.0\n";
        $mailheaders .= "Content-type: multipart/mixed; ";
        $mailheaders .= "boundary=\"Message-Boundary\"\n";
        $mailheaders .= "Content-transfer-encoding: 7BIT\n";

        $body_top = "--Message-Boundary\n";
        $body_top .= "Content-type: text/html; charset=US-ASCII\n";
        $body_top .= "Content-transfer-encoding: 7BIT\n";
        $body_top .= "Content-description: Mail message body\n\n";

        $msg_body = $body_top . $msg_body;

        $msg_body .= "\n\n--Message-Boundary\n";
        $msg_body .= "Content-Transfer-Encoding: BASE64\n";

        $msg_body .= "--Message-Boundary--\n";

        mail($to, ($assunto), $msg_body, $mailheaders);           
                //REGISTRO DE OCORRENCIA
        if(!empty($descricao)){
                ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => $descricao, 'codtipoocorrencialead' => $tipoocorrencia));

        }
    }    
    function envia_solicitacao($html,$emailde,$emailpara,$assunto,$operador_pk){  
        $from = $emailde;//de:
        $to = $emailpara;//para:
        $body = $html;
        $mailheaders = "From: $from\n";
        $mailheaders .= "Reply-To: $ReplyTo\n";
        $mailheaders .= "Cc:\n";//copia
        $mailheaders .= "Bcc: $bcc\n";
        $mailheaders .= "X-Mailer: $assunto \n";

        $msg_body = ($body);

        $mailheaders .= "MIME-version: 1.0\n";
        $mailheaders .= "Content-type: multipart/mixed; ";
        $mailheaders .= "boundary=\"Message-Boundary\"\n";
        $mailheaders .= "Content-transfer-encoding: 7BIT\n";

        $body_top = "--Message-Boundary\n";
        $body_top .= "Content-type: text/html; charset=US-ASCII\n";
        $body_top .= "Content-transfer-encoding: 7BIT\n";
        $body_top .= "Content-description: Mail message body\n\n";

        $msg_body = $body_top . $msg_body;

        $msg_body .= "\n\n--Message-Boundary\n";
        $msg_body .= "Content-Transfer-Encoding: BASE64\n";

        $msg_body .= "--Message-Boundary--\n";

        mail($to, ($assunto), $msg_body, $mailheaders);           
        
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
		
		//$sql = sqlupdate('email_empresa', $fields, ' cod_email_empresa = ' . mysqlnull($value['cod_email_empresa']));
	    $sql = "update email_empresa set status='".$value['status']."',codtipoocorrencialead='".$value['codtipoocorrencialead']."',email_assunto='".$value['email_assunto']."',email_saida='".$value['email_saida']."',email_texto='".$value['email_texto']."' where cod_email_empresa =".$value['cod_email_empresa'];

		sql_query($sql);		
	}	
}
?> 
