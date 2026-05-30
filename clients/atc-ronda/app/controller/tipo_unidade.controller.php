<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/tipo_unidade.dao.php";
require_once "../model/tipo_unidade.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_unidade = $arrRequest['ds_unidade'];
$ic_status = $arrRequest['ic_status'];


$tipo_unidadedao = new tipo_unidadedao();
$tipo_unidadedao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $tipo_unidade = $tipo_unidadedao->carregarPorPk($pk);
        if($tipo_unidade->getpk()>0){
            
            $tipo_unidadedao->excluir($tipo_unidade);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'tipo_unidade nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $tipo_unidade = $tipo_unidadedao->carregarPorPk($pk);
        $tipo_unidade->setds_unidade($ds_unidade);
        $tipo_unidade->setic_status($ic_status);

        
        $pk = $tipo_unidadedao->salvar($tipo_unidade);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $tipo_unidadedao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_unidade"=>$query[$i]['ds_unidade'],
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
        $query = $tipo_unidadedao->listar_por_ds_unidade($ds_unidade);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_unidade"=>$query[$i]['ds_unidade'],
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
        $query = $tipo_unidadedao->listar_por_ds_unidade($ds_unidade);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_unidade"=>$query[$i]['ds_unidade'],
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

$tipo_unidadedao = null;

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
