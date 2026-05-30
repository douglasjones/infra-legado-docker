<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/apontamento.dao.php";
require_once "../model/apontamento.class.php";

require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";


$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$dt_ponto = $arrRequest['dt_ponto'];
$hr_entreda = $arrRequest['hr_entreda'];
$hr_saida = $arrRequest['hr_saida'];
$ds_local_atual = $arrRequest['ds_local_atual'];
$apontamento_usuario_pk = $arrRequest['apontamento_usuario_pk'];
$obs = $arrRequest['obs'];
$leads_pk = $arrRequest['leads_pk'];
$ic_status = $arrRequest['ic_status'];


$apontamentodao = new apontamentodao();
$apontamentodao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $apontamento = $apontamentodao->carregarPorPk($pk);
        if($apontamento->getpk()>0){
            
            $log_exclusaodao->salvar("apontamento",$apontamento->getpk());
            $apontamentodao->excluir($apontamento);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'apontamento nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $apontamento = $apontamentodao->carregarPorPk($pk);
        $apontamento->setdt_ponto($dt_ponto);
        $apontamento->sethr_entreda($hr_entreda);
        $apontamento->sethr_saida($hr_saida);
        $apontamento->setds_local_atual($ds_local_atual);
        $apontamento->setapontamento_usuario_pk($apontamento_usuario_pk);
        $apontamento->setobs($obs);
        $apontamento->setleads_pk($leads_pk);
        $apontamento->setic_status($ic_status);

        
        $pk = $apontamentodao->salvar($apontamento);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $apontamentodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_ponto"=>$query[$i]['dt_ponto'],
                    "hr_entreda"=>$query[$i]['hr_entreda'],
                    "hr_saida"=>$query[$i]['hr_saida'],
                    "ds_local_atual"=>$query[$i]['ds_local_atual'],
                    "apontamento_usuario_pk"=>$query[$i]['apontamento_usuario_pk'],
                    "obs"=>$query[$i]['obs'],
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
        $query = $apontamentodao->listar_por_dt_ponto($dt_ponto);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_ponto"=>$query[$i]['dt_ponto'],
                    "hr_entreda"=>$query[$i]['hr_entreda'],
                    "hr_saida"=>$query[$i]['hr_saida'],
                    "ds_local_atual"=>$query[$i]['ds_local_atual'],
                    "apontamento_usuario_pk"=>$query[$i]['apontamento_usuario_pk'],
                    "obs"=>$query[$i]['obs'],
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
        $query = $apontamentodao->listar_por_dt_ponto($dt_ponto);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_ponto"=>$query[$i]['dt_ponto'],
                    "t_hr_entreda"=>$query[$i]['hr_entreda'],
                    "t_hr_saida"=>$query[$i]['hr_saida'],
                    "t_ds_local_atual"=>$query[$i]['ds_local_atual'],
                    "t_apontamento_usuario_pk"=>$query[$i]['apontamento_usuario_pk'],
                    "t_obs"=>$query[$i]['obs'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
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

$apontamentodao = null;

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
