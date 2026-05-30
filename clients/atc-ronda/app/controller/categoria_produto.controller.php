<?
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/categoria_produto.dao.php";
require_once "../model/categoria_produto.class.php";

require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_categoria = $arrRequest['ds_categoria'];
$ic_status = $arrRequest['ic_status'];

$categoria_produtodao = new categoria_produtodao();
$categoria_produtodao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){
    case 'excluir':{        
        $resultdo = "";        
        $categoria_produto = $categoria_produtodao->carregarPorPk($pk);
        if($categoria_produto->getpk()>0){           
            $log_exclusaodao->salvar("categoria_produto",$categoria_produto->getpk());
            $categoria_produtodao->excluir($categoria_produto);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }else{
            $result  = 'error';
            $message = 'categoria_produto nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $categoria_produto = $categoria_produtodao->carregarPorPk($pk);
        $categoria_produto->setds_categoria($ds_categoria);
        $categoria_produto->setic_status($ic_status);
        $pk = $categoria_produtodao->salvar($categoria_produto);
        
        $mysql_data[] = array(
            "pk" => $pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $categoria_produtodao->listarPorPk($pk);
        
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
    case 'listarTodos':{
        
        $resultado = "";
        $query = $categoria_produtodao->listar_por_ds_categoria($ds_categoria);
        
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
        $query = $categoria_produtodao->listar_por_ds_categoria($ds_categoria);
        
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

$categoria_produtodao = null;

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
