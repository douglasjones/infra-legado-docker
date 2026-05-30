<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/metodo_pagamento.dao.php";
require_once "../model/metodo_pagamento.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_metodo_pagamento = $arrRequest['ds_metodo_pagamento'];
$ic_status = $arrRequest['ic_status'];


$metodo_pagamentodao = new metodo_pagamentodao();
$metodo_pagamentodao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $metodo_pagamento = $metodo_pagamentodao->carregarPorPk($pk);
        if($metodo_pagamento->getpk()>0){
            
            $log_exclusaodao->salvar("metodo_pagamento",$metodo_pagamento->getpk());
            $metodo_pagamentodao->excluir($metodo_pagamento);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'metodo_pagamento nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $metodo_pagamento = $metodo_pagamentodao->carregarPorPk($pk);
        $metodo_pagamento->setds_metodo_pagamento($ds_metodo_pagamento);
        $metodo_pagamento->setic_status($ic_status);

        
        $pk = $metodo_pagamentodao->salvar($metodo_pagamento);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $metodo_pagamentodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_metodo_pagamento"=>$query[$i]['ds_metodo_pagamento'],
                    "ic_status"=>$query[$i]['ic_status']
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
    case 'listarTodos':{
        
        $resultado = "";
        $query = $metodo_pagamentodao->listar_por_ds_metodo_pagamento($ds_metodo_pagamento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_metodo_pagamento"=>$query[$i]['ds_metodo_pagamento'],
                    "ic_status"=>$query[$i]['ic_status']
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
        $query = $metodo_pagamentodao->listar_por_ds_metodo_pagamento($ds_metodo_pagamento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_metodo_pagamento"=>$query[$i]['ds_metodo_pagamento'],
                    "t_ic_status"=>$query[$i]['ic_status'],

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

$metodo_pagamentodao = null;

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
