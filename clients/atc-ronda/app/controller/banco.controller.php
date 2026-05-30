<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/banco.dao.php";
require_once "../model/banco.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_banco = $arrRequest['ds_banco'];
$cod_banco = $arrRequest['cod_banco'];
$ic_status = $arrRequest['ic_status'];


$bancodao = new bancodao();
$bancodao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $banco = $bancodao->carregarPorPk($pk);
        if($banco->getpk()>0){
            
            $log_exclusaodao->salvar("bancos",$banco->getpk());
            $bancodao->excluir($banco);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'banco nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $banco = $bancodao->carregarPorPk($pk);
        $banco->setds_banco($ds_banco);
        $banco->setcod_banco($cod_banco);
        $banco->setic_status($ic_status);

        
        $pk = $bancodao->salvar($banco);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $bancodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_banco"=>$query[$i]['ds_banco'],
                    "cod_banco"=>$query[$i]['cod_banco'],
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
        $query = $bancodao->listar_por_ds_banco($ds_banco);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_banco"=>$query[$i]['ds_banco'],
                    "cod_banco"=>$query[$i]['cod_banco'],
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
        $query = $bancodao->listar_por_ds_banco($ds_banco);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_banco"=>$query[$i]['ds_banco'],
                    "t_cod_banco"=>$query[$i]['cod_banco'],
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

$bancodao = null;

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
