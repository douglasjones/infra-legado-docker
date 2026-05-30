<?
class email {
	function envia_email($tipo,$codlead,$contato,$msg_body,$descricao,$cod_email_empresa){
		$sql = "Select 
				ct.codlead
				,ct.email
				from leads l
				inner join contatoslead ct on l.codlead = ct.codlead";
		$sql .= " Where ct.codlead = ".$codlead;

		if(!empty($contato)){
			$sql .= " and ct.codcontatolead=".$contato;
		}
		$sql .= " and ct.email is not null";
		$sql .= " and ct.email <>''";
		$result = mysql_query($sql);
		if($row = mysql_fetch_array($result)){
			array_merge($row, $_REQUEST);
			$_REQUEST = $row;	
			
			//DESTINATARIO
			$destinatario = @$_REQUEST['email'] ;
			$sql = "Select
					ep.email_saida
					,ep.email_assunto
					,ep.email_texto
					,ep.codtipoocorrencialead
					,ep.anexo
					from email_empresa ep
					where ep.cod_email_empresa= $cod_email_empresa
					and ep.cod_tipoemail= ".$tipo;

			$result1 = mysql_query($sql);
			if($row1 = mysql_fetch_array($result1)){
				$email_saida  = $row1['email_saida'];
				$assunto = $row1['email_assunto'];
				$email_texto = $row1['email_texto'];
				$tipoocorrencia = $row1['codtipoocorrencialead'];
				$anexo = $row1['anexo'];
			}
			
			$attach = "../../operacao/email/".$anexo;
			$attach_name = $anexo;
			
			$from = $email_saida ;
			$to = $destinatario ;
			$body = $email_texto;
			
			$mailheaders = "From: $from\n";
			$mailheaders .= "Reply-To: $from\n";
			$mailheaders .= "Cc: $cc\n";
			$mailheaders .= "Bcc: $bcc\n";
			$mailheaders .= "X-Mailer: $assunto \n";
			
			$msg_body = stripslashes($body);
			
			if ($attach != "none"){
				$file = fopen($attach, "r");
				$contents = fread($file, filesize($attach));
				$encoded_attach = chunk_split(base64_encode($contents));
				fclose($file);
				
				$mailheaders .= "MIME-version: 1.0\n";
				$mailheaders .= "Content-type: multipart/mixed; ";
				$mailheaders .= "boundary=\"Message-Boundary\"\n";
				$mailheaders .= "Content-transfer-encoding: 7BIT\n";
				$mailheaders .= "X-attachments: $attach_name";
				
				$body_top = "--Message-Boundary\n";
				$body_top .= "Content-type: text/html; charset=US-ASCII\n";
				$body_top .= "Content-transfer-encoding: 7BIT\n";
				$body_top .= "Content-description: Mail message body\n\n";
				
				$msg_body = $body_top . $msg_body;
				
				$msg_body .= "\n\n--Message-Boundary\n";
				$msg_body .= "Content-type: $attach_type; name=\"$attach_name\"\n";
				$msg_body .= "Content-Transfer-Encoding: BASE64\n";
				$msg_body .= "Content-disposition: attachment; filename=\"$attach_name\"\n\n";
				$msg_body .= "$encoded_attach\n";
				$msg_body .= "--Message-Boundary--\n";
			}
			
			mail($to, stripslashes($subject), $msg_body, $mailheaders);
	
			//REGISTRO DE OCORRENCIA
			if(!empty($descricao)){
				ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => $descricao, 'codtipoocorrencialead' => $tipoocorrencia));
			}
		}
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