<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/lead_desconto.dao.php";
require_once "../model/lead_desconto.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";




$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_desconto = $arrRequest['ds_desconto'];
$dt_base = $arrRequest['dt_base'];
$vl_desconto = $arrRequest['vl_desconto'];
$leads_pk = $arrRequest['leads_pk'];


$lead_descontodao = new lead_descontodao();
$lead_descontodao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $lead_desconto = $lead_descontodao->carregarPorPk($pk);
        if($lead_desconto->getpk()>0){
            
            $log_exclusaodao->salvar("leads_documentos",$lead_desconto->getpk());
            $lead_descontodao->excluir($lead_desconto);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'lead_desconto nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $lead_desconto = $lead_descontodao->carregarPorPk($pk);
        $lead_desconto->setds_desconto($ds_desconto);
        $lead_desconto->setdt_base($dt_base);
        $lead_desconto->setvl_desconto($vl_desconto);
        $lead_desconto->setleads_pk($leads_pk);

        
        $pk = $lead_descontodao->salvar($lead_desconto);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $lead_descontodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_desconto"=>$query[$i]['ds_desconto'],
                    "dt_base"=>$query[$i]['dt_base'],
                    "vl_desconto"=>$query[$i]['vl_desconto'],
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
    case 'listarDescontoPorLead':{
        
        $resultado = "";
        if($leads_pk!=""){
             $query = $lead_descontodao->listarDescontoPorLead($leads_pk);
        
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "ds_desconto"=>$query[$i]['ds_desconto'],
                        "dt_base"=>$query[$i]['dt_base'],
                        "vl_desconto"=>$query[$i]['vl_desconto'],
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
        $query = $lead_descontodao->listar_por_ds_desconto($ds_desconto);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_desconto"=>$query[$i]['ds_desconto'],
                    "dt_base"=>$query[$i]['dt_base'],
                    "vl_desconto"=>$query[$i]['vl_desconto'],
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
        $query = $lead_descontodao->listar_por_ds_desconto($ds_desconto);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_desconto"=>$query[$i]['ds_desconto'],
                    "t_dt_base"=>$query[$i]['dt_base'],
                    "t_vl_desconto"=>$query[$i]['vl_desconto'],
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

$lead_descontodao = null;

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
