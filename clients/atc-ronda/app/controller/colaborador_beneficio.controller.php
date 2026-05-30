<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/colaborador_beneficio.dao.php";
require_once "../model/colaborador_beneficio.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";


$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$vl_beneficio = $arrRequest['vl_beneficio'];
$obs = $arrRequest['obs'];
$ic_status = $arrRequest['ic_status'];
$beneficios_pk = $arrRequest['beneficios_pk'];
$colaborador_pk = $arrRequest['colaborador_pk'];


$colaborador_beneficiodao = new colaborador_beneficiodao();
$colaborador_beneficiodao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $colaborador_beneficio = $colaborador_beneficiodao->carregarPorPk($pk);
        if($colaborador_beneficio->getpk()>0){
            
            $log_exclusaodao->salvar("colaborador_beneficios",$colaborador_beneficio->getpk());
            $colaborador_beneficiodao->excluir($colaborador_beneficio);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'colaborador_beneficio nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $colaborador_beneficio = $colaborador_beneficiodao->carregarPorPk($pk);
        $colaborador_beneficio->setvl_beneficio($vl_beneficio);
        $colaborador_beneficio->setobs($obs);
        $colaborador_beneficio->setic_status($ic_status);
        $colaborador_beneficio->setbeneficios_pk($beneficios_pk);
        $colaborador_beneficio->setcolaborador_pk($colaborador_pk);

        
        $pk = $colaborador_beneficiodao->salvar($colaborador_beneficio);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $colaborador_beneficiodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "vl_beneficio"=>$query[$i]['vl_beneficio'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "beneficios_pk"=>$query[$i]['beneficios_pk'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk']
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
        $query = $colaborador_beneficiodao->listar_por_vl_beneficio($vl_beneficio);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "vl_beneficio"=>$query[$i]['vl_beneficio'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "beneficios_pk"=>$query[$i]['beneficios_pk'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk']
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
        $query = $colaborador_beneficiodao->listar_por_vl_beneficio($vl_beneficio);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_vl_beneficio"=>$query[$i]['vl_beneficio'],
                    "t_obs"=>$query[$i]['obs'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_beneficios_pk"=>$query[$i]['beneficios_pk'],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],

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
    
    case 'relColaboradorBebeficio':{
        
        $leads_pk= $_REQUEST['leads_pk'];
        
        $resultado = "";
        $query = $colaborador_beneficiodao->relColaboradorBebeficio($colaborador_pk,$leads_pk,$beneficios_pk);
        
        $result  = 'success';
        $message = 'query success';

        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_beneficio"=>$query[$i]['ds_beneficio'],
                    "vl_beneficio"=>$query[$i]['vl_beneficio'],

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

$colaborador_beneficiodao = null;

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
