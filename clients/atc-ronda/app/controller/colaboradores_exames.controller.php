<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/colaboradores_exames.dao.php";
require_once "../model/colaboradores_exames.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";




$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$exames_pk = $arrRequest['exames_pk'];
$dt_prevista = $arrRequest['dt_prevista'];
$dt_exame = $arrRequest['dt_exame'];
$ic_status = $arrRequest['ic_status'];
$obs = $arrRequest['obs'];
$colaborador_pk = $arrRequest['colaborador_pk'];


$colaboradores_examesdao = new colaboradores_examesdao();
$colaboradores_examesdao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);


switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $colaboradores_exames = $colaboradores_examesdao->carregarPorPk($pk);
        if($colaboradores_exames->getpk()>0){
            $log_exclusaodao->salvar("colaboradores_exames",$colaboradores_exames->getpk());
            $colaboradores_examesdao->excluir($colaboradores_exames);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'colaboradores_exames nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $colaboradores_exames = $colaboradores_examesdao->carregarPorPk($pk);
        $colaboradores_exames->setexames_pk($exames_pk);
        $colaboradores_exames->setdt_prevista($dt_prevista);
        $colaboradores_exames->setdt_exame($dt_exame);
        $colaboradores_exames->setic_status($ic_status);
        $colaboradores_exames->setobs($obs);
        $colaboradores_exames->setcolaborador_pk($colaborador_pk);

        
        $pk = $colaboradores_examesdao->salvar($colaboradores_exames);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $colaboradores_examesdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "exames_pk"=>$query[$i]['exames_pk'],
                    "dt_prevista"=>$query[$i]['dt_prevista'],
                    "dt_exame"=>$query[$i]['dt_exame'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "obs"=>$query[$i]['obs'],
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
        $query = $colaboradores_examesdao->listar_por_exames_pk($exames_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "exames_pk"=>$query[$i]['exames_pk'],
                    "dt_prevista"=>$query[$i]['dt_prevista'],
                    "dt_exame"=>$query[$i]['dt_exame'],
                    "ic_status_exames"=>$query[$i]['ic_status'],
                    "obs"=>$query[$i]['obs'],
       
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
        $query = $colaboradores_examesdao->listar_por_exames_pk($exames_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_exames_pk"=>$query[$i]['exames_pk'],
                    "t_dt_prevista"=>$query[$i]['dt_prevista'],
                    "t_dt_exame"=>$query[$i]['dt_exame'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_obs"=>$query[$i]['obs'],
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
}

$colaboradores_examesdao = null;

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
