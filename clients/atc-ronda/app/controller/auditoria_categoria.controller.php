<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/auditoria_categoria.dao.php";
require_once "../model/auditoria_categoria.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_categoria = $arrRequest['ds_categoria'];
$ic_status = $arrRequest['ic_status'];


$auditoria_categoriadao = new auditoria_categoriadao();
$auditoria_categoriadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $auditoria_categoria = $auditoria_categoriadao->carregarPorPk($pk);
        if($auditoria_categoria->getpk()>0){
            
            $auditoria_categoriadao->excluir($auditoria_categoria);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'auditoria_categoria nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $auditoria_categoria = $auditoria_categoriadao->carregarPorPk($pk);
        $auditoria_categoria->setds_categoria($ds_categoria);
        $auditoria_categoria->setic_status($ic_status);

        
        $pk = $auditoria_categoriadao->salvar($auditoria_categoria);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $auditoria_categoriadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_categoria"=>$query[$i]['ds_categoria'],
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
    case 'listarCategoriaCombo':{
        
        $resultado = "";
        $query = $auditoria_categoriadao->listarCategoriaCombo($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_categoria"=>$query[$i]['ds_categoria']
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
        $query = $auditoria_categoriadao->listar_por_ds_categoria($ds_categoria, $ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_categoria"=>$query[$i]['ds_categoria'],
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
        $query = $auditoria_categoriadao->listar_por_ds_categoria($ds_categoria, $ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_categoria"=>$query[$i]['ds_categoria'],
                    "t_ic_status"=>$query[$i]['ds_status'],

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

$auditoria_categoriadao = null;

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
