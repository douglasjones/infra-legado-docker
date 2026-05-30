<?php

include_once "../../libs/maininclude.php";
require("PHPMailer-master/src/PHPMailer.php");
require("PHPMailer-master/src/SMTP.php");

include_once "email_cla.php";



$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
$mailing = $_REQUEST['Mailing'];
$email_modelo_pk = $_REQUEST['email_modelo_pk'];

$strEmails = $_REQUEST['strEmails'];

$emails = str_replace('&nbsp', "", $_REQUEST['strEmails']);
$arrEmails= explode("////", $emails);


if ($acao == "gravar"){	       

    $email = new email(0);
    $email->setpk($pk);
    $email->setmailing($mailing);
    $email->setemail_modelo_pk($email_modelo_pk);        
 
    $pk = $email->salvar();
    
    //Carrega modelo de Email
    $sql ="";
    $sql.="SELECT em.ds_conteudo
            FROM email_modelo em
            WHERE em.pk =".$email_modelo_pk;
    
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    
    $html = $row['ds_conteudo'];
        
         
    
    //envio de email 
    for($i = 0; $i < count($arrEmails) -1; $i++){
        $arrCampos = explode("##",$arrEmails[$i]);
        $email->registra_envio_Email($arrCampos[0],$arrCampos[2],$html,$email_modelo_pk);        
    }
    //javascriptalert('Opera��o executada com sucesso!!!');
    javascriptalert1('Opera��o executada com sucesso!!!','email_res_form.php');
}

if ($acao == "gravarGepros"){	       
    
    $email = new email(0);
    $email->setpk($pk);
    $email->setmailing($mailing);
    $email->setemail_modelo_pk($email_modelo_pk);        
    $pk = $email->salvar();
    
    //Carrega modelo de Email
    $sql ="";
    $sql.="SELECT em.ds_conteudo
            FROM email_modelo em
            WHERE em.pk =".$email_modelo_pk;

    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    
    $html = $row['ds_conteudo'];
    $v = 0;
    
    $remetente = "sistema@gepros.com.br";

    $psw = "@Vectra_10";
    $assunto = "Gepros";
    $msg = $html;
    
    //envio de email 
    for($i = 0; $i < count($arrEmails) -1; $i++){
        
        $arrCampos = explode("##",$arrEmails[$i]);
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = "vps-4378124.gepros.com.br";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = $remetente;
            $mail->Password = $psw;
            $mail->SetFrom($remetente);
            $mail->Subject = $assunto;
            $mail->Body = $html;
            $mail->AddAddress(strtolower($arrCampos[0]));

            $mail->Send();

        } catch (Exception $e) {
            echo 'Error: ' . $e;
        }        
       
        $email->registra_envio_Email_Gepros($arrCampos[0],$arrCampos[2],$html,$email_modelo_pk);   
        
        
    }
    
    
    /*$to = "sistema@gepros.com.br";
    $subject = "Gepros";


    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <marcelo1999.mesquita@gmail.com>' . "\r\n";

    mail($to,$subject,$html,$headers);*/
    
    
    javascriptalert1('Opera��o executada com sucesso!!!','email_res_form.php');
}


if($acao == "excluir"){
    $email = new email(0);
    $email->excluir($_REQUEST['codcontato']);
    javascriptalert1('Opera��o executada com sucesso!!!','email_cad_form.php?Mailing='.$mailing);
}
include_once "../../libs/desconectar.php";
?>
