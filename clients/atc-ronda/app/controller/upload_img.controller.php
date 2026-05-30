<?
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-type: application/json; charset=utf-8");
header("Content-type: text/plain; charset=utf-8");
header('Content-Type: text/plain');

require_once "../inc/php/public.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];

$img_foto = $_FILES['img_foto'];

echo $img_foto;
exit;

switch($job){    
    //Loga usuário App na base Webservice e fornece um token
    case 'uploadImg':{ 

 
        echo "aqui1";
        exit;              
        break;
    }    
    
    
}

$usuariodao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
echo $json_data;
?>


