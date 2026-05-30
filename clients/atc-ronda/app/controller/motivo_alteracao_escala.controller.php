<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/motivo_alteracao_escala.dao.php";
require_once "../model/motivo_alteracao_escala.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_motivo_alteracao_escala = $arrRequest['ds_motivo_alteracao_escala'];
$ic_status = $arrRequest['ic_status'];


$motivo_alteracao_escaladao = new motivo_alteracao_escaladao();
$motivo_alteracao_escaladao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $motivo_alteracao_escala = $motivo_alteracao_escaladao->carregarPorPk($pk);
        if($motivo_alteracao_escala->getpk()>0){
            
            $log_exclusaodao->salvar("motivo_alteracao_escala",$motivo_alteracao_escala->getpk());
            
            $motivo_alteracao_escaladao->excluir($motivo_alteracao_escala);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'motivo_alteracao_escala nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $motivo_alteracao_escala = $motivo_alteracao_escaladao->carregarPorPk($pk);
        $motivo_alteracao_escala->setds_motivo_alteracao_escala($ds_motivo_alteracao_escala);
        $motivo_alteracao_escala->setic_status($ic_status);

        
        $pk = $motivo_alteracao_escaladao->salvar($motivo_alteracao_escala);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $motivo_alteracao_escaladao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_motivo_alteracao_escala"=>$query[$i]['ds_motivo_alteracao_escala'],
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
        $query = $motivo_alteracao_escaladao->listar_por_ds_motivo_alteracao_escala($ds_motivo_alteracao_escala);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_motivo_alteracao_escala"=>$query[$i]['ds_motivo_alteracao_escala'],
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
        $query = $motivo_alteracao_escaladao->listar_por_ds_motivo_alteracao_escala($ds_motivo_alteracao_escala);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_motivo_alteracao_escala"=>$query[$i]['ds_motivo_alteracao_escala'],
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

$motivo_alteracao_escaladao = null;

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
