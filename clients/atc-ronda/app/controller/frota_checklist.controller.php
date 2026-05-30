<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/frota_checklist.dao.php";
require_once "../model/frota_checklist.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$leads_pk = $arrRequest['leads_pk'];
$frota_pk = $arrRequest['frota_pk'];
$condutores_pk = $arrRequest['condutores_pk'];
$dt_ini_checklist = $arrRequest['dt_ini_checklist'];
$dt_fim_checklist = $arrRequest['dt_fim_checklist'];
$usuario_cadastro_pk = $arrRequest['usuario_cadastro_pk'];
$JSONinfo = $arrRequest['JSONinfo'];

$frota_checklistdao = new frota_checklistdao();
$frota_checklistdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $frota_checklist = $frota_checklistdao->carregarPorPk($pk);
        if($frota_checklist->getpk()>0){
            
            $frota_checklistdao->excluir($frota_checklist);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'frota_checklist nao encontrado';
        }
        break;
    }
    case 'salvar':{

        $frota_checklist = $frota_checklistdao->carregarPorPk($pk);

        $pk = $frota_checklistdao->salvar($frota_checklist, $JSONinfo);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $frota_checklistdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "frota_pk"=>$query[$i]['frota_pk'],
                    "condutores_pk"=>$query[$i]['condutores_pk']
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
        $query = $frota_checklistdao->listar_por_leads_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "frota_pk"=>$query[$i]['frota_pk'],
                    "condutores_pk"=>$query[$i]['condutores_pk']
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
        $query = $frota_checklistdao->listar_por_leads_pk($leads_pk, $condutores_pk, $frota_pk, $dt_ini_checklist, $dt_fim_checklist, $usuario_cadastro_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_frota_pk"=>$query[$i]['frota_pk'],
                    "t_condutores_pk"=>$query[$i]['condutores_pk'],
                    "t_ds_condutor"=>$query[$i]['ds_condutor'],
                    "t_id_veiculo"=>$query[$i]['id_veiculo'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],

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

$frota_checklistdao = null;

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
