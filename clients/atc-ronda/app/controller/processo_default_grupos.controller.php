<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/processo_default_grupos.dao.php";
require_once "../model/processo_default_grupos.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$grupos_pk = $arrRequest['grupos_pk'];
$ic_status = $arrRequest['ic_status'];
$processo_default_configuracao_pk = $arrRequest['processo_default_configuracao_pk'];


$processo_default_gruposdao = new processo_default_gruposdao();
$processo_default_gruposdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $processo_default_grupos = $processo_default_gruposdao->carregarPorPk($pk);
        if($processo_default_grupos->getpk()>0){
            
            $processo_default_gruposdao->excluir($processo_default_grupos);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'processo_default_grupos nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $processo_default_grupos = $processo_default_gruposdao->carregarPorPk($pk);
        $processo_default_grupos->setgrupos_pk($grupos_pk);
        $processo_default_grupos->setic_status($ic_status);
        $processo_default_grupos->setprocesso_default_configuracao_pk($processo_default_configuracao_pk);

        
        $pk = $processo_default_gruposdao->salvar($processo_default_grupos);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $processo_default_gruposdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "processo_default_configuracao_pk"=>$query[$i]['processo_default_configuracao_pk']
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
        $query = $processo_default_gruposdao->listar_por_grupos_pk($grupos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "processo_default_configuracao_pk"=>$query[$i]['processo_default_configuracao_pk']
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
        $query = $processo_default_gruposdao->listar_por_grupos_pk($grupos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_grupos_pk"=>$query[$i]['grupos_pk'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_processo_default_configuracao_pk"=>$query[$i]['processo_default_configuracao_pk'],

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

$processo_default_gruposdao = null;

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
