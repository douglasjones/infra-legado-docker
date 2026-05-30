<?
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/agenda.dao.php";
require_once "../model/agenda.class.php";


$arrRequest = tratar_request();
$job = $arrRequest['job'];
$token = $arrRequest['token'];
$leads_pk = $arrRequest['leads_pk'];

$agendadao = new agendadao();
$agendadao->setToken($token); 

switch($job){

    case 'listarEventos':{  
        $resultado = "";
        $query = $agendadao->listar_por_tipo_agendas_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $data[] = array(
                    "icon" => $query[$i]["icon"],
                    "title" => $query[$i]["title"],
                    "start" => $query[$i]['start'],
                    "end"=> $query[$i]['end'],
					"color"=> $query[$i]['color'],
					"textColor"=> $query[$i]['textColor'],
                    "id" => $query[$i]["id"]
                );
            }
        }

        break;
    }    
    default:{
        break;
    }
}

$agendadao = null;

// Convert PHP array to JSON array
$json_data = json_encode($data);
echo $json_data;

?>

