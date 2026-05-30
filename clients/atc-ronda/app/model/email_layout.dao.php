<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/enviar_email.dao.php";

class email_layoutdao{

    private $db;
    private $arrToken;

    public function __construct(){

        $this->db = new DataBase();
        $this->db->conectar();

    }

    public function __destruct() {
        $this->db->desconectar();
    }


    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }
    
    public function agendaAvisoParticipantes($emailde, $emailpara, $assunto, $token){

        $enviar_emaildao = new enviar_emaildao();
        $enviar_emaildao->setToken($token); 

        setlocale(LC_ALL,'pt_BR.UTF8');
        mb_internal_encoding('UTF8'); 
        mb_regex_encoding('UTF8');

        $html ="";
        $html.='<html style="padding: 0px; margin: 0px;" >';
        $html.='    <head>'; 
        $html.='        <style>';
        $html.='            body{margin:0;padding: 0;}
                            @media only screen and (max-width:640px){
                                table, img[class="partial-image"]{
                                    width:100% !important;
                                    height:auto !important;
                                    min-width: 200px !important;
                                }
                            }';
        $html.='        </style>';
        $html.='    </head>';
        $html.='    <body>';
        $html.='        <table style="border-collapse: collapse; border-spacing:0; min-height: 418px;" cellpadding="0" cellspacing="0" width="100%" bgcolor="#f2f2f2">';
        $html.='            <tbody>';
        $html.='                <tr>';
        $html.='                    <td align="center" style="border-collapse: collapse;padding-top: 30px; padding-bottom: 30px;">';
        $html.='                        <table cellpadding="5" cellspacing="5" width="600" bgcolor="white" style="border-collapse: collapse;border-spacing: 0;">';
        $html.='                            <tbody>';
        $html.='                                <tr>';
        $html.='                                    <td style="border-collapse: collapse; padding: 0px;text-align: center; width: 600px;">';
        $html.='                                        <table style="border-collapse: collapse; border-spacing: 0; box-sizing: border-box; min-height: 40px; position: relative; width: 100%; max-width: 600px; padding-bottom: 0px; padding-left: 0px;  padding-right: 0px; padding-top: 0px; text-align: center;">';
        $html.='                                            <tbody>';
        $html.='                                                <tr>';
        $html.='                                                    <td style="border-collapse: collapse; font-family: Arial; padding: 30px 0px; line-height: 0px; mso-line-height-rule: exactly;">';
        $html.='                                                        <table width="100%" style="border-collapse: collapse;border-spacing: 0; font-family: Arial;">';
        $html.='                                                            <tbody>';
        $html.='                                                                 <tr>';
        $html.='                                                                    <td align="center" style="border-collapse:';
        $html.='                                                                    </td>';
        $html.='                                                                 </tr>';
        $html.='                                                            </tbody>';
        $html.='                                                        </table>';
        $html.='                                                    </td>';
        $html.='                                                </tr>';
        $html.='                                            </tbody>';
        $html.='                                        </table>';
        $html.='                                        <table style="border-collapse: collapse; border-spacing: 0; box-sizing: border-box; min-height: 40px; position: relative; width: 100%; max-width: 600px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px;">';
        $html.='                                            <tbody>';
        $html.='                                                <tr>';
        $html.='                                                    <td style="border-collapse: collapse; font-family: Arial; padding: 0px; line-height: 0px; mso-line-height-rule: exactly; background-color: rgb(0,0,0);">';
        $html.='                                                        <table width="100%" style="border-collapse: collapse; border-spacing: 0; font-family: Arial;">';
        $html.='                                                            <tbody>';
        $html.='                                                                <tr>';
        $html.='                                                                    <td align="center" style="border-collapse: collapse; line-height: 0px; padding: 0;  mso-line-height-rule: exactly;"></td>';
        $html.='                                                                </tr>';
        $html.='                                                            </tbody>';
        $html.='                                                        </table>';
        $html.='                                                    </td>';
        $html.='                                                </tr>';
        $html.='                                            </tbody>';
        $html.='                                        </table>';
        $html.='                                        <table style="border-collapse: collapse;  border-spacing: 0; box-sizing: border-box;   min-height: 40px; position: relative; width: 100%;  font-family: Arial; font-size: 25px;  padding-bottom: 20px; padding-top: 20px;   text-align: center; vertical-align:   middle;">';
        $html.='                                            <tbody>';
        $html.='                                                <tr>';
        $html.='                                                    <td style="border-collapse: collapse; font-family: Arial; padding: 10px 15px;">';
        $html.='                                                        <table width="100%" style="border-collapse: collapse; border-spacing:   0; font-family: Arial;">';
        $html.='                                                            <tbody>';
        $html.='                                                                <tr>';
        $html.='                                                                    <td style="border-collapse: collapse;">';
        $html.='                                                                        <h2 style="font-weight: normal; margin: 0px; padding:  0px; color: rgb(0,0,0); word-wrap: break-word;  font-size: 35px;">';
        $html.='                                                                            <a style="display: inline-block;   text-decoration: none; box-sizing: border-box;   font-family: arial; width: 100%; font-size: 35px;   text-align: left; word-wrap: break-word; color:   rgb(0,0,0);" target="_blank">';
        $html.='                                                                                <span style="font-size: inherit; text-align: center;    width: 100%; color: rgb(0,0,0);">';
        $html.='                                                                                </span>';
        $html.='                                                                            </a>';
        $html.='                                                                        </h2>';
        $html.='                                                                    </td>';
        $html.='                                                                </tr>';
        $html.='                                                            </tbody>';
        $html.='                                                        </table>';
        $html.='                                                    </td>';
        $html.='                                                </tr>';
        $html.='                                            </tbody>';
        $html.='                                        </table>';
        $html.='                                        <table style="border-collapse: collapse; border-spacing: 0; box-sizing: border-box; min-height: 40px; position: relative; width: 100%;">';
        $html.='                                            <tbody>';
        $html.='                                                <tr>';
        $html.='                                                    <td style="border-collapse: collapse; font-family: Arial; padding: 10px 15px;">';
        $html.='                                                        <table width="100%" style="border-collapse: collapse; border-spacing: 0; text-align: left; font-family: Arial;">';
        $html.='                                                            <tbody>';
        $html.='                                                                <tr>';
        $html.='                                                                    <td style="border-collapse: collapse;">';
        $html.='                                                                        <div style="font-family: Arial; font-size: 15px; font-weight: normal; line-height: 170%; text-align: left; color: #666; word-wrap: break-word;">';
        $html.='                                                                            <span>';
        $html.=                                                                                 $texto;
        $html.='                                                                                <span style="line-height: 0; display:none;"> </span>';
        $html.='                                                                                <span style="line-height: 0; display:none;"></span>';
        $html.='                                                                            </span>';
        $html.='                                                                        </div>';
        $html.='                                                                    </td>';
        $html.='                                                                </tr>';
        $html.='                                                            </tbody>';
        $html.='                                                        </table>';
        $html.='                                                    </td>';
        $html.='                                                </tr>';
        $html.='                                            </tbody>';
        $html.='                                        </table>';
        $html.='                                        <table style="border-collapse: collapse; border-spacing: 0; box-sizing: border-box; min-height: 40px; position: relative; width: 100%; display: table;">';
        $html.='                                            <tbody>';
        $html.='                                                <tr>';
        $html.='                                                    <td style="border-collapse: collapse; font-family: Arial; padding: 10px 15px;">';
        $html.='                                                        <table width="100%" style="border-collapse: collapse; border-spacing: 0; font-family: Arial;">';
        $html.='                                                            <tbody>';
        $html.='                                                                <tr>';
        $html.='                                                                    <td style="border-collapse: collapse;">';
        $html.='                                                                        <hr style="border-color: #BBB; border-style:  dashed;">';
        $html.='                                                                    </td>';
        $html.='                                                                </tr>';
        $html.='                                                            </tbody>';
        $html.='                                                        </table>';
        $html.='                                                    </td>';
        $html.='                                                </tr>';
        $html.='                                            </tbody>';
        $html.='                                        </table>';
        $html.='                                        <table data-brackets-id="740" style="border-collapse: collapse; border-spacing: 0; box-sizing: border-box; min-height: 40px; position: relative; width: 100%;">';
        $html.='                                            <tbody data-brackets-id="741">';
        $html.='                                                <tr data-brackets-id="742">';
        $html.='                                                    <td data-brackets-id="743" style="border-collapse: collapse; font-family: Arial; padding: 10px 15px;">';
        $html.='                                                        <table data-brackets-id="744" width="100%" style="border-collapse: collapse; border-spacing: 0; text-align: left; font-family: Arial;">';
        $html.='                                                        </table>';
        $html.='                                                        <table data-brackets-id="751" style="border-collapse: collapse; border-spacing: 0; box-sizing: border-box; min-height: 40px; position: relative; width: 100%; padding: 30px 0px;">';
        $html.='                                                            <tbody data-brackets-id="752">';
        $html.='                                                                <tr data-brackets-id="753">';
        $html.='                                                                    <td data-brackets-id="754" style="border-collapse: collapse; font-family: Arial; padding: 10px 15px;">';
        $html.='                                                                        <table data-brackets-id="755" width="100%" style="border-collapse: collapse; border-spacing: 0; font-family: Arial;">';
        $html.='                                                                            <tbody data-brackets-id="756">';
        $html.='                                                                                <tr data-brackets-id="757">';
        $html.='                                                                                    <td data-brackets-id="758" class="conteudo-editavel edicao-imagem-link" align="center" style="border-collapse: collapse;">';
        $html.='                                                                                        <a data-brackets-id="759" href="http://www.facebook.com/" target="_blank" style="display: inline-block; text-decoration: none; box-sizing: border-box; font-family: arial; width: auto!important;">';      
        $html.='                                                                                        </a>';
        $html.='                                                                                        <span data-brackets-id="761" class="Object" id="OBJ_PREFIX_DWT192_com_zimbra_url">';
        $html.='                                                                                            <a data-brackets-id="762" href="http://www.twitter.com/" target="_blank" style="display: inline-block; text-decoration: none; box-sizing: border-box; font-family: arial; width: auto!important;">';      
        $html.='                                                                                            </a>';
        $html.='                                                                                        </span>';
        $html.='                                                                                        <span data-brackets-id="764" class="Object" id="OBJ_PREFIX_DWT193_com_zimbra_url">';
        $html.='                                                                                            <a data-brackets-id="765" href="http://www.instagram.com/" target="_blank" style="display: inline-block; text-decoration: none; box-sizing: border-box; font-family: arial; width: auto!important;">';      
        $html.='                                                                                            </a>';
        $html.='                                                                                        </span>';
        $html.='                                                                                    </td>';
        $html.='                                                                                </tr>';
        $html.='                                                                            </tbody>';
        $html.='                                                                        </table>';
        $html.='                                                                    </td>';
        $html.='                                                                </tr>';
        $html.='                                                            </tbody>';
        $html.='                                                        </table>';
        $html.='                                                    </td>';
        $html.='                                                </tr>';
        $html.='                                            </tbody>';
        $html.='                                        </table>';
        $html.='                                    </td>';
        $html.='                                </tr>';
        $html.='                             </table>';
        $html.='                         </td>';
        $html.='                    </tr>';
        $html.='              </tbody>';
        $html.='         </table>';
        $html.='   </body>';
        $html.='</html>';
        $enviar_emaildao->enviaEmailAutenticado($html,$emailde,$emailpara,$assunto,'');         
       // echo "l1<br>";        
    }
}


?>
