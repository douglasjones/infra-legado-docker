<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/lead_imposto.dao.php";
require_once "../model/lead_imposto.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_percentual_imposto = $arrRequest['ds_percentual_imposto'];
$imposto_pk = $arrRequest['imposto_pk'];
$leads_pk = $arrRequest['leads_pk'];


$lead_impostodao = new lead_impostodao();
$lead_impostodao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $lead_imposto = $lead_impostodao->carregarPorPk($pk);
        if($lead_imposto->getpk()>0){
            $log_exclusaodao->salvar("leads_impostos",$lead_imposto->getpk());
            
            $lead_impostodao->excluir($lead_imposto);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'lead_imposto nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $lead_imposto = $lead_impostodao->carregarPorPk($pk);
        $lead_imposto->setds_percentual_imposto($ds_percentual_imposto);
        $lead_imposto->setimposto_pk($imposto_pk);
        $lead_imposto->setleads_pk($leads_pk);

        
        $pk = $lead_impostodao->salvar($lead_imposto);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $lead_impostodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_percentual_imposto"=>$query[$i]['ds_percentual_imposto'],
                    "imposto_pk"=>$query[$i]['imposto_pk'],
                    "leads_pk"=>$query[$i]['leads_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarImpostoPorLead':{
        $dt_cadastro = $_REQUEST['dt_cadastro'];
        $resultado = "";
        if($leads_pk!=""){
            $query = $lead_impostodao->listarImpostoPorLead($leads_pk,$dt_cadastro);
        
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "ds_percentual_imposto"=>$query[$i]['ds_percentual_imposto'],
                        "imposto_pk"=>$query[$i]['imposto_pk'],
                        "leads_pk"=>$query[$i]['leads_pk']
                    );
                }
            }
            else{
                $mysql_data = [];
            }
        }
        else{
            $mysql_data = [];
        }
        
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $lead_impostodao->listar_por_ds_percentual_imposto($ds_percentual_imposto);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_percentual_imposto"=>$query[$i]['ds_percentual_imposto'],
                    "imposto_pk"=>$query[$i]['imposto_pk'],
                    "leads_pk"=>$query[$i]['leads_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $lead_impostodao->listar_por_ds_percentual_imposto($ds_percentual_imposto);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_percentual_imposto"=>$query[$i]['ds_percentual_imposto'],
                    "t_imposto_pk"=>$query[$i]['imposto_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    default:{
        break;
    }
}

$lead_impostodao = null;

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
