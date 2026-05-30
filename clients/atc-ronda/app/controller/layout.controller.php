<?  
class layout{

    function AnaliseFinanceiraSolicitacaoCorrecao($texto){

        setlocale(LC_ALL,'pt_BR.UTF8');
        mb_internal_encoding('UTF8'); 
        mb_regex_encoding('UTF8');
        $html ="";
        $html.='<html style="padding: 0px; margin: 0px;" >';
        $html.='<head>'; 
      //  $html.='<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />';
        $html.='<style>';
        $html.='body{margin:
        0;padding: 0;
        }
        @media only screen and (max-width:640px){
        table, img[class="partial-image"]{
        width:100% !important;
        height:auto !important;
        min-width: 200px !important;}';
        $html.='</style>';
        $html.='</head>';
        $html.='<body>';
        $html.='<table style="border-collapse: collapse; border-spacing:0; min-height: 418px;" cellpadding="0" cellspacing="0" width="100%" bgcolor="#f2f2f2">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td align="center" style="border-collapse: collapse;padding-top: 30px; padding-bottom: 30px;">';
        $html.='<table cellpadding="5" cellspacing="5" width="600" bgcolor="white" style="border-collapse: collapse;border-spacing: 0;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse; padding: 0px;text-align: center; width: 600px;">';
        $html.='<table style="border-collapse: collapse; border-spacing: 0; box-sizing: border-box; min-height: 40px; position: relative; width: 100%; max-width: 600px; padding-bottom: 0px; padding-left: 0px;  padding-right: 0px; padding-top: 0px; text-align: center;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse; font-family: Arial; padding: 30px 0px; line-height: 0px; mso-line-height-rule: exactly;">';
        $html.='<table width="100%" style="border-collapse: collapse;border-spacing: 0; font-family: Arial;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td align="center" style="border-collapse:';

        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='<table style="border-collapse: collapse;
        border-spacing: 0; box-sizing: border-box;
        min-height: 40px; position: relative; width: 100%;
        max-width: 600px; padding-bottom: 0px;
        padding-left: 0px; padding-right: 0px;
        padding-top: 0px;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse; font-family:
        Arial; padding: 0px; line-height: 0px;
        mso-line-height-rule: exactly; background-color:
        rgb(0,0,0);">';
        $html.='<table width="100%" style="border-collapse: collapse; border-spacing:
        0; font-family: Arial;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td align="center" style="border-collapse: collapse; line-height: 0px; padding: 0;  mso-line-height-rule: exactly;"></td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='<table style="border-collapse: collapse;  border-spacing: 0; box-sizing: border-box;   min-height: 40px; position: relative; width: 100%;  font-family: Arial; font-size: 25px;  padding-bottom: 20px; padding-top: 20px;   text-align: center; vertical-align:   middle;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse; font-family: Arial; padding: 10px 15px;">';
        $html.='<table width="100%" style="border-collapse: collapse; border-spacing:   0; font-family: Arial;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse;">';
        $html.='<h2 style="font-weight: normal; margin: 0px; padding:  0px; color: rgb(0,0,0); word-wrap: break-word;  font-size: 35px;">';
        $html.='<a style="display: inline-block;   text-decoration: none; box-sizing: border-box;   font-family: arial; width: 100%; font-size: 35px;   text-align: left; word-wrap: break-word; color:   rgb(0,0,0);" target="_blank">';
        $html.='<span style="font-size: inherit; text-align: center;    width: 100%; color: rgb(0,0,0);">';
        //$html.='Ol&aacute;, '.$ds_usuario.', e seja bem-vindo(a) ao Portal do Chip!';
        $html.='</span>';
        $html.='</a>';
        $html.='</h2>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='<table style="border-collapse: collapse;
        border-spacing: 0; box-sizing: border-box;
        min-height: 40px; position: relative; width:
        100%;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse:
        collapse; font-family: Arial; padding: 10px
        15px;">';
        $html.='<table width="100%" style="border-collapse: collapse; border-spacing:
        0; text-align: left; font-family:
        Arial;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse:
        collapse;">';
        $html.='<div style="font-family: Arial;
        font-size: 15px; font-weight: normal; line-height:
        170%; text-align: left; color: #666; word-wrap:
        break-word;">';
        $html.='<span>';
        $html.= $texto;
        $html.='<span style="line-height: 0; display:   none;">';
        $html.='</span>';
        $html.='<span style="line-height: 0;
        display:
        none;">';
        $html.='</span>';
        $html.='</span>';
        $html.='</div>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';

        $html.='<table style="border-collapse: collapse; border-spacing:
        0; box-sizing: border-box; min-height: 40px;
        position: relative; width: 100%; display:
        table;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse:
        collapse; font-family: Arial; padding: 10px
        15px;">';
        $html.='<table width="100%" style="border-collapse: collapse; border-spacing:
        0; font-family: Arial;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse;">';
        $html.='<hr style="border-color: #BBB; border-style:
        dashed;">';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='<table data-brackets-id="740" style="border-collapse: collapse;
        border-spacing: 0; box-sizing: border-box;
        min-height: 40px; position: relative; width:
        100%;">';
        $html.='<tbody data-brackets-id="741">';
        $html.='<tr data-brackets-id="742">';
        $html.='<td data-brackets-id="743" style="border-collapse:
        collapse; font-family: Arial; padding: 10px
        15px;">';
        $html.='<table data-brackets-id="744" width="100%" style="border-collapse: collapse; border-spacing:
        0; text-align: left; font-family:
        Arial;">';
        
        $html.='</table>';
        $html.='<table data-brackets-id="751" style="border-collapse: collapse;
        border-spacing: 0; box-sizing: border-box;
        min-height: 40px; position: relative; width: 100%;
        padding: 30px 0px;">';
        $html.='<tbody data-brackets-id="752">';
        $html.='<tr data-brackets-id="753">';
        $html.='<td data-brackets-id="754" style="border-collapse: collapse; font-family:
        Arial; padding: 10px 15px;">';
        $html.='<table data-brackets-id="755" width="100%" style="border-collapse: collapse; border-spacing:
        0; font-family: Arial;">';
        $html.='<tbody data-brackets-id="756">';
        $html.='<tr data-brackets-id="757">';
        $html.='<td data-brackets-id="758" class="conteudo-editavel edicao-imagem-link" align="center" style="border-collapse:
        collapse;">';
        $html.='<a data-brackets-id="759" href="http://www.facebook.com/" target="_blank" style="display: inline-block;
        text-decoration: none; box-sizing: border-box;
        font-family: arial; width: auto!important;">';      

        //$html.='<img data-brackets-id="760" style="height: auto; width: 30px;" dfsrc="http://imgnode1.iagentecorp.com/iagentemail/drag-drop/facebook.png" src="../../../Users/msr_j/Downloads/carnaval1/index_files/facebook.png">';               

        $html.='</a>';
        $html.='<span data-brackets-id="761" class="Object" id="OBJ_PREFIX_DWT192_com_zimbra_url">';
        $html.='<a data-brackets-id="762" href="http://www.twitter.com/" target="_blank" style="display: inline-block;
        text-decoration: none; box-sizing: border-box;
        font-family: arial; width: auto!important;">';      

        //$html.='<img data-brackets-id="763" style="height: auto; width: 30px;" dfsrc="http://imgnode1.iagentecorp.com/iagentemail/drag-drop/twitter.png" src="../../../Users/msr_j/Downloads/carnaval1/index_files/twitter.png">';               

        $html.='</a>';
        $html.='</span>';
        $html.='<span data-brackets-id="764" class="Object" id="OBJ_PREFIX_DWT193_com_zimbra_url">';
        $html.='<a data-brackets-id="765" href="http://www.instagram.com/" target="_blank" style="display: inline-block;
        text-decoration: none; box-sizing: border-box;
        font-family: arial; width: auto!important;">';      

        //$html.='<img data-brackets-id="766" style="height: auto; width: 30px;" dfsrc="http://imgnode1.iagentecorp.com/iagentemail/drag-drop/instagram.png" src="../../../Users/msr_j/Downloads/carnaval1/index_files/instagram.png">';               


        $html.='</a>';
        $html.='</span>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</body>';
        $html.='</html>';

  
         return($html);
    }

    function layoutOcorrencia($dt_oc,$ds_tipo_oc,$ds_oc,$dt_termino){
        $html.='<html lang="en" xmlns="" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">';
        $html.='<head>'; 
        $html.='<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $html.='<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
        $html.='<meta name="viewport" content="width=device-width, initial-scale=1">';
        //$html.="<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>";

        //$html.="<link rel = 'stylesheet'  href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>";
        //$html.="<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>";
        //$html.="<link href='//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>";
        $html.="<title>";
        $html.="Envio E-mail";
        $html.="</title>";
        $html.="</head>";

        $html.="<body>";
        $html.="<p>";$html.="</p>";
        $html.="<p>";$html.="</p>";
        $html.="<div class='container' id='exibir_informativo_agenda'>"; 
        $html.="<div class='row'>";
        $html.="<div class='container'>";
        $html.="<div class='modal-content'>";
        $html.="<div class='modal-content'>";
        $html.="<div class='modal-body' style='box-shadow: 2px 2px 5px grey;'>";
        $html.="<div class='row'>"; 
        $html.="<div class='col-md-6'>";                           
        $html.="<i class='fa fa-list' aria-hidden='true' style='font-size: 25px;' > - Ocorrência";
        $html.="</i>"; 
        $html.="</div>"; 
        $html.="<div class='col-md-6' align='right'>"; 
                                    
        $html.="</div>";           
        $html.="</div>";
        $html.="<hr>";
        $html.="<br>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.="  Data da Ocorrência: ".$dt_oc ;
        $html.="</div>";               	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.=" Tipo Ocorrência: ".$ds_tipo_oc;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.="Descrição: ".$ds_oc;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.= "Data Termino: ".$dt_termino;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";     
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";           
        $html.="</body>";
        $html.="</html>";



         return($html);
    }   
    function layoutAgendaRetorno($agendado_para,$usuario_cadastro,$ds_lead,$pk,$dt_oc,$ds_tipo_oc,$ds_oc){
        
        
        $html.='<html lang="en" xmlns="" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">';
        $html.='<head>'; 
        $html.='<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $html.='<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
        $html.='<meta name="viewport" content="width=device-width, initial-scale=1">';
        $html.='<style>';
        $html.='body{margin:
        0;padding: 0;
        }
        @media only screen and (max-width:640px){
        table, img[class="partial-image"]{
        width:100% !important;
        height:auto !important;
        min-width: 200px !important; 
        }';
        $html.='</style>';
        $html.='</head>';

        $html.="<body>";
        $html.="<p>";
        $html.="</p>";
        $html.="<p>";
        $html.="</p>";
        $html.="<div class='container' id='exibir_informativo_agenda'>"; 
        $html.="<div class='row'>";
        $html.="<div class='container'>";
        $html.="<div class='modal-content'>";
        $html.="<div class='modal-content'>";
        $html.="<div class='modal-body' style='box-shadow: 2px 2px 5px grey;'>";
        $html.="<div class='row'>"; 
        $html.="<div class='col-md-6'>";                           
        $html.="<i class='fa fa-list' aria-hidden='true' style='font-size: 25px;' > Acompanhamento de Ocorrência/Retorno Gerada - ".$ds_tipo_oc;
        $html.="</i>"; 
        $html.="</div>"; 
        $html.="<div class='col-md-6' align='right'>"; 
                                    
        $html.="</div>";           
        $html.="</div>";
        $html.="<hr>";
        $html.="<br>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.="  Lead: ".$ds_lead ;
        $html.="</div>";               	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.=" Código Ocorrência : ".$pk;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.=" Usuário Cadastro : ".$usuario_cadastro;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.="Data Cadastro: ".$dt_oc;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.= "Tipo Ocorrência: ".$ds_tipo_oc;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.= "Descrição: ".$ds_oc;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.= "Agendado Para: ".$agendado_para;
        $html.="</div>";                	 
        $html.="</div>";
        
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";     
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";           
        $html.="</body>";
        $html.="</html>";
        
        return($html);
        
    }   
    function layoutOcorrenciaSupervisor($pk,$ds_tipo_oc,$ds_ocorrencia,$ds_cadastro,$ds_lead,$ic_status_fechamento){
        $html.='<html lang="en" xmlns="" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">';
        $html.='<head>'; 
        $html.='<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $html.='<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
        $html.='<meta name="viewport" content="width=device-width, initial-scale=1">';
        $html.='<style>';
        $html.='body{margin:
        0;padding: 0;
        }
        @media only screen and (max-width:640px){
        table, img[class="partial-image"]{
        width:100% !important;
        height:auto !important;
        min-width: 200px !important; 
        }';
        $html.='</style>';
        $html.='</head>';

        $html.="<body>";
        $html.="<p>";
        $html.="</p>";
        $html.="<p>";
        $html.="</p>";
        $html.="<div class='container' id='exibir_informativo_agenda'>"; 
        $html.="<div class='row'>";
        $html.="<div class='container'>";
        $html.="<div class='modal-content'>";
        $html.="<div class='modal-content'>";
        $html.="<div class='modal-body' style='box-shadow: 2px 2px 5px grey;'>";
        $html.="<div class='row'>"; 
        $html.="<div class='col-md-6'>";                           
        $html.="<i class='fa fa-list' aria-hidden='true' style='font-size: 25px;' > Ocorrência Gerada - ".$ds_tipo_oc;
        $html.="</i>"; 
        $html.="</div>"; 
        $html.="<div class='col-md-6' align='right'>"; 
                                    
        $html.="</div>";           
        $html.="</div>";
        $html.="<hr>";
        $html.="<br>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.="  Lead: ".$ds_lead ;
        $html.="</div>";               	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.=" Código Ocorrência : ".$pk;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.="Data Cadastro: ".$ds_cadastro;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.= "Tipo Ocorrência: ".$ds_tipo_oc;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.= "Descrição: ".$ds_ocorrencia;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        if($ic_status_fechamento==2){
            $html.= "Status Fechamento: Fechado";
        }
        else if($ic_status_fechamento==3){
            $html.= "Status Fechamento: Recusado";
        }
        $html.="</div>";                	 
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";     
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";           
        $html.="</body>";
        $html.="</html>";
         return($html);
    }   
    
    function layoutOcorrenciaCliente($pk,$ds_tipo_oc,$ds_ocorrencia,$ds_cadastro,$ds_lead,$ic_status_fechamento,$ds_status,$ic_status,$ds_recusa,$dt_execucao,$dt_finalizada){                      
        $html.='<html lang="en" xmlns="" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">';
        $html.='<head>'; 
        $html.='<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $html.='<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
        $html.='<meta name="viewport" content="width=device-width, initial-scale=1">';
        $html.='<style>';
        $html.='body{margin:
        0;padding: 0;
        }
        @media only screen and (max-width:640px){
        table, img[class="partial-image"]{
        width:100% !important;
        height:auto !important;
        min-width: 200px !important; 
        }';
        $html.='</style>';
        $html.='</head>';

        $html.="<body>";
        $html.="<p>";
        $html.="</p>";
        $html.="<p>";
        $html.="</p>";
        $html.="<div class='container' id='exibir_informativo_agenda'>"; 
        $html.="<div class='row'>";
        $html.="<div class='container'>";
        $html.="<div class='modal-content'>";
        $html.="<div class='modal-content'>";
        $html.="<div class='modal-body' style='box-shadow: 2px 2px 5px grey;'>";
        $html.="<div class='row'>"; 
        $html.="<div class='col-md-6'>";                           
        $html.="<i class='fa fa-list' aria-hidden='true' style='font-size: 25px;' > Acompanhamento de Ocorrência Gerada - ".$ds_tipo_oc;
        $html.="</i>"; 
        $html.="</div>"; 
        $html.="<div class='col-md-6' align='right'>"; 
                                    
        $html.="</div>";           
        $html.="</div>";
        $html.="<hr>";
        $html.="<br>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.="  Lead: ".$ds_lead ;
        $html.="</div>";               	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.=" Código Ocorrência : ".$pk;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.="Data Cadastro: ".$ds_cadastro;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.= "Tipo Ocorrência: ".$ds_tipo_oc;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.= "Descrição: ".$ds_ocorrencia;
        $html.="</div>";                	 
        $html.="</div>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        $html.= "Status Atual: ".$ds_status;
        $html.="</div>";                	 
        $html.="</div>";        
        $html.="<div class='row'>";   
        $html.="<div class='col-md-4'>"; 
        if($ic_status==1){
            $html.= "Ocorrência recusada:".$ds_recusa;
        }else if($ic_status==2){
            $html.= "Ocorrência Dt Execuão:".$dt_execuçao;
        }else if($ic_status==3){
            $html.= "Ocorrência Dt Finalizada:".$dt_finalizada;
        }else if($ic_status==4){
            $html.= "Ocorrência em verificação:";
        }
        $html.="</div>";                	 
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";     
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";           
        $html.="</body>";
        $html.="</html>";
        
        return($html);
    }   
    
    
    /*function layoutUsuário($ds_usuario,$ds_email,$ds_senha){
x
       // $host = $_SERVER[HTTP_HOST];
        
        
        $html.='<html lang="en" xmlns="" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">';
        $html.='<head>'; 
        $html.='<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $html.='<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1>';
        $html.='<meta name="viewport" content="width=device-width, initial-scale=1">';
        $html.='<style>';
        $html.='body{margin: 0;padding: 0;} @media only screen and (max-width:640px){table, img[class="partial-image"]{ width:100% !important; height:auto !important; min-width: 200px !important;}';
        $html.='</style>';
        $html.='</head>';
        $html.='<body>';
        $html.='<table style="border-collapse: collapse; border-spacing: 0; min-height: 418px;" cellpadding="0" cellspacing="0" width="100%" bgcolor="#f2f2f2">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td align="center" style="border-collapse: collapse; padding-top: 30px; padding-bottom: 30px;">';
        $html.='<table cellpadding="5" cellspacing="5" width="600" bgcolor="white" style="border-collapse: collapse;border-spacing: 0;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse; padding: 0px;text-align: center; width: 600px;">';
        $html.='<table style="border-collapse: collapse; border-spacing: 0; box-sizing: border-box; min-height: 40px; position: relative; width: 100%; max-width: 600px;padding-bottom: 0px; padding-left: 0px;padding-right: 0px; padding-top: 0px; text-align:
        center;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse; font-family:Arial; padding: 30px 0px; line-height: 0px; mso-line-height-rule: exactly;">';
        $html.='<table width="100%" style="border-collapse: collapse;border-spacing: 0; font-family: Arial;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='<table style="border-collapse: collapse;
        border-spacing: 0; box-sizing: border-box;
        min-height: 40px; position: relative; width: 100%;
        max-width: 600px; padding-bottom: 0px;
        padding-left: 0px; padding-right: 0px;
        padding-top: 0px;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse; font-family:
        Arial; padding: 0px; line-height: 0px;
        mso-line-height-rule: exactly; background-color:
        rgb(0,0,0);">';
        $html.='<table width="100%" style="border-collapse: collapse; border-spacing:
        0; font-family: Arial;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='<table style="border-collapse: collapse;
        border-spacing: 0; box-sizing: border-box;
        min-height: 40px; position: relative; width: 100%;
        font-family: Arial; font-size: 25px;
        padding-bottom: 20px; padding-top: 20px;
        text-align: center; vertical-align:
        middle;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse; font-family:
        Arial; padding: 10px 15px;">';
        $html.='<table width="100%" style="border-collapse: collapse; border-spacing:
        0; font-family: Arial;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse;">';
        $html.='<h2 style="font-weight: normal; margin: 0px; padding:
        0px; color: rgb(0,0,0); word-wrap: break-word;
        font-size: 35px;">';
        $html.='<a style="display: inline-block;
        text-decoration: none; box-sizing: border-box;
        font-family: arial; width: 100%; font-size: 35px;
        text-align: left; word-wrap: break-word; color:
        rgb(0,0,0);" target="_blank">';
        $html.='<span style="font-size: inherit; text-align: center;
        width: 100%; color: rgb(0,0,0);">';
        $html.='Olá! '.$ds_usuario.', Bem Vindo !';
        $html.='</span>';
        $html.='</a>';
        $html.='</h2>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='<table style="border-collapse: collapse;
        border-spacing: 0; box-sizing: border-box;
        min-height: 40px; position: relative; width:
        100%;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse:
        collapse; font-family: Arial; padding: 10px
        15px;">';
        $html.='<table width="100%" style="border-collapse: collapse; border-spacing:
        0; text-align: left; font-family:
        Arial;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse:
        collapse;">';
        $html.='<div style="font-family: Arial;
        font-size: 15px; font-weight: normal; line-height:
        170%; text-align: left; color: #666; word-wrap:
        break-word;">';
        
        $html.='<span>';  
        $html.='Seu Login de acesso é '.$ds_email;
        $html.='<span style="line-height: 0; display:
        none;">';
        $html.='</span>';
        $html.='<span>';
        $html.='<span style="line-height: 0; display:
        none;">';
        $html.='</span>';
        $html.='<span style="line-height: 0;
        display:
        none;">';
        $html.='</span>';
        $html.='</span>';
        $html.='</div>';
        $html.='</td>';
        $html.='</tr>';
        $html.='<tr>';
        $html.='<td style="border-collapse:
        collapse;">';
        $html.='<div style="font-family: Arial;
        font-size: 15px; font-weight: normal; line-height:
        170%; text-align: left; color: #666; word-wrap:
        break-word;">';
        $html.='<span>';  
        $html.='E sua Senha Padrão:<b>'.$ds_senha.'</b>';
        $html.='<span style="line-height: 0; display:
        none;">';
        $html.='</span>';
        $html.='<span>';
        $html.='<span style="line-height: 0; display:
        none;">';
        $html.='</span>';
        $html.='<span style="line-height: 0;
        display:
        none;">';
        $html.='</span>';
        $html.='</span>';
        $html.='</div>';
        $html.='</td>';
        $html.='</tr>';
        $html.='<tr>';
        $html.='<td style="border-collapse:
        collapse;">';
        $html.='<div style="font-family: Arial;
        font-size: 15px; font-weight: normal; line-height:
        170%; text-align: left; color: #666; word-wrap:
        break-word;">';
        
        $html.='<span>';  
        $html.='<span style="line-height: 0; display:
        none;">';
        $html.='</span>';
        $html.='<span>';
        $html.='Para o primeiro acesso ao sistema clique neste   
        <a href="'.$host.'">link</a> e registre uma nova senha.';
        $html.='<span style="line-height: 0; display:
        none;">';
        $html.='</span>';
        $html.='<span style="line-height: 0;
        display:
        none;">';
        $html.='</span>';
        $html.='</span>';
        $html.='</div>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='<table style="border-collapse: collapse; border-spacing:
        0; box-sizing: border-box; min-height: 40px;
        position: relative; width: 100%; display:
        table;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse:
        collapse; font-family: Arial; padding: 10px
        15px;">';
        $html.='<table width="100%" style="border-collapse: collapse; border-spacing:
        0; font-family: Arial;">';
        $html.='<tbody>';
        $html.='<tr>';
        $html.='<td style="border-collapse: collapse;">';
        $html.='<hr style="border-color: #BBB; border-style:
        dashed;">';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='<table data-brackets-id="740" style="border-collapse: collapse;
        border-spacing: 0; box-sizing: border-box;
        min-height: 40px; position: relative; width:
        100%;">';
        $html.='<tbody data-brackets-id="741">';
        $html.='<tr data-brackets-id="742">';
        $html.='<td data-brackets-id="743" style="border-collapse:
        collapse; font-family: Arial; padding: 10px
        15px;">';
        $html.='<table data-brackets-id="744" width="100%" style="border-collapse: collapse; border-spacing:
        0; text-align: left; font-family:
        Arial;">';
        $html.='<tbody data-brackets-id="745">';
        $html.='<tr data-brackets-id="746">';
        $html.='<td data-brackets-id="747" class="conteudo-editavel edicao-link" style="border-collapse:
        collapse;font-family: Arial;
        font-size: 15px; font-weight: normal; line-height:
        170%; color: #666; word-wrap:
        break-word;text-align:center;">';
        $html.='<br data-brackets-id="749">';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</td>';
        $html.='</tr>';
        $html.='</tbody>';
        $html.='</table>';
        $html.='</body>';
        $html.='</html>';



         return($html);
    }   */
    
}
    

