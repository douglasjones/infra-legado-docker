<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/condutor.dao.php";
require_once "../model/condutor.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_condutor = $arrRequest['ds_condutor'];
$ds_cpf = $arrRequest['ds_cpf'];
$ds_rg = $arrRequest['ds_rg'];
$leads_pk = $arrRequest['leads_pk'];
$ic_status = $arrRequest['ic_status'];


$condutordao = new condutordao();
$condutordao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $condutor = $condutordao->carregarPorPk($pk);
        if($condutor->getpk()>0){
            
            $condutordao->excluir($condutor);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'condutor nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $condutor = $condutordao->carregarPorPk($pk);
        $condutor->setds_condutor($ds_condutor);
        $condutor->setds_cpf($ds_cpf);
        $condutor->setds_rg($ds_rg);
        $condutor->setleads_pk($leads_pk);
        $condutor->setic_status($ic_status);

        
        $pk = $condutordao->salvar($condutor);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $condutordao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_condutor"=>$query[$i]['ds_condutor'],
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "leads_pk"=>$query[$i]['leads_pk'],
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
        $query = $condutordao->listar_por_ds_condutor($ds_condutor);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_condutor"=>$query[$i]['ds_condutor'],
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "leads_pk"=>$query[$i]['leads_pk'],
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
        $query = $condutordao->listar_por_ds_condutor($ds_condutor,$leads_pk,$ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_condutor"=>$query[$i]['ds_condutor'],
                    "t_ds_cpf"=>$query[$i]['ds_cpf'],
                    "t_ds_rg"=>$query[$i]['ds_rg'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_status"=>$query[$i]['ds_status'],

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

$condutordao = null;

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
