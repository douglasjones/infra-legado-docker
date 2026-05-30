<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/processos_default_modulos.dao.php";
require_once "../model/processos_default_modulos.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_modulo = $arrRequest['ds_modulo'];
$ds_arquivo_res = $arrRequest['ds_arquivo_res'];
$ds_arquivo_cad = $arrRequest['ds_arquivo_cad'];
$ds_arquivo_controller = $arrRequest['ds_arquivo_controller'];
$ds_arquivo_dao = $arrRequest['ds_arquivo_dao'];
$ds_ok = $arrRequest['ds_ok'];
$ic_status = $arrRequest['ic_status'];
$processo_default_pk = $arrRequest['processo_default_pk'];


$processos_default_modulosdao = new processos_default_modulosdao();
$processos_default_modulosdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $processos_default_modulos = $processos_default_modulosdao->carregarPorPk($pk);
        if($processos_default_modulos->getpk()>0){
            
            $processos_default_modulosdao->excluir($processos_default_modulos);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'processos_default_modulos nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $processos_default_modulos = $processos_default_modulosdao->carregarPorPk($pk);
        $processos_default_modulos->setds_modulo($ds_modulo);
        $processos_default_modulos->setds_arquivo_res($ds_arquivo_res);
        $processos_default_modulos->setds_arquivo_cad($ds_arquivo_cad);
        $processos_default_modulos->setds_arquivo_controller($ds_arquivo_controller);
        $processos_default_modulos->setds_arquivo_dao($ds_arquivo_dao);
        $processos_default_modulos->setds_ok($ds_ok);
        $processos_default_modulos->setic_status($ic_status);

        
        $pk = $processos_default_modulosdao->salvar($processos_default_modulos);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $processos_default_modulosdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_modulo"=>$query[$i]['ds_modulo'],
                    "ds_arquivo_res"=>$query[$i]['ds_arquivo_res'],
                    "ds_arquivo_cad"=>$query[$i]['ds_arquivo_cad'],
                    "ds_arquivo_controller"=>$query[$i]['ds_arquivo_controller'],
                    "ds_arquivo_dao"=>$query[$i]['ds_arquivo_dao'],
                    "ds_ok"=>$query[$i]['ds_ok'],
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
        $query = $processos_default_modulosdao->listar_por_ds_modulo($ds_modulo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_modulo"=>$query[$i]['ds_modulo'],
                    "ds_arquivo_res"=>$query[$i]['ds_arquivo_res'],
                    "ds_arquivo_cad"=>$query[$i]['ds_arquivo_cad'],
                    "ds_arquivo_controller"=>$query[$i]['ds_arquivo_controller'],
                    "ds_arquivo_dao"=>$query[$i]['ds_arquivo_dao'],
                    "ds_ok"=>$query[$i]['ds_ok'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "processos_default_modulos_obrigatorio_pk"=>$query[$i]['processos_default_modulos_obrigatorio_pk']
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
        $query = $processos_default_modulosdao->listar_por_ds_modulo($ds_modulo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_modulo"=>$query[$i]['ds_modulo'],
                    "t_ds_arquivo_res"=>$query[$i]['ds_arquivo_res'],
                    "t_ds_arquivo_cad"=>$query[$i]['ds_arquivo_cad'],
                    "t_ds_arquivo_controller"=>$query[$i]['ds_arquivo_controller'],
                    "t_ds_arquivo_dao"=>$query[$i]['ds_arquivo_dao'],
                    "t_ds_ok"=>$query[$i]['ds_ok'],
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
    case 'listarModulosProcessoDefaultPk':{
        
        
        $resultado = "";
        $query = $processos_default_modulosdao->listarModulosProcessoDefaultPk($ds_modulo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_modulo"=>$query[$i]['ds_modulo'],

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

$processos_default_modulosdao = null;

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
