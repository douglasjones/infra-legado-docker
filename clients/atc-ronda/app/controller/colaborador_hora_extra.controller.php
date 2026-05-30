<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/colaborador_hora_extra.dao.php";
require_once "../model/colaborador_hora_extra.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$leads_pk = $arrRequest['leads_pk'];
$dt_escala = $arrRequest['dt_escala'];
$hr_extra_ini = $arrRequest['hr_extra_ini'];
$hr_extra_fim = $arrRequest['hr_extra_fim'];
$obs = $arrRequest['obs'];


$colaborador_hora_extradao = new colaborador_hora_extradao();
$colaborador_hora_extradao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){
    case 'excluirColaborador':{
        $dt_hora_ponto = $_REQUEST['dt_hora_ponto'];
        $resultdo = "";
            $colaborador_hora_extra_pk = $colaborador_hora_extradao->carregarPorColaboradorPk($colaborador_pk,$dt_hora_ponto,$leads_pk);
            if(count($colaborador_hora_extra_pk) > 0){
                for($i = 0; $i < count($colaborador_hora_extra_pk); $i++){
                    $log_exclusaodao->salvar("colaborador_hora_extra",$colaborador_hora_extra_pk[$i]['pk']);
                    $colaborador_hora_extradao->excluirColaborador($colaborador_hora_extra_pk[$i]['pk']);
                    
                }
            }
            
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        break;
    }
    case 'excluir':{
        
        $resultdo = "";
        
        $colaborador_hora_extra = $colaborador_hora_extradao->carregarPorPk($pk);
        if($colaborador_hora_extra->getpk()>0){
            
            $log_exclusaodao->salvar("colaborador_hora_extra",$colaborador_hora_extra->getpk());
            
            $colaborador_hora_extradao->excluir($colaborador_hora_extra);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'colaborador_hora_extra nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $colaborador_hora_extra = $colaborador_hora_extradao->carregarPorPk($pk);
        $colaborador_hora_extra->setcolaborador_pk($colaborador_pk);
        $colaborador_hora_extra->setleads_pk($leads_pk);
        $colaborador_hora_extra->setdt_escala($dt_escala);
        $colaborador_hora_extra->sethr_extra_ini($hr_extra_ini);
        $colaborador_hora_extra->sethr_extra_fim($hr_extra_fim);
        $colaborador_hora_extra->setobs($obs);

        
        $pk = $colaborador_hora_extradao->salvar($colaborador_hora_extra);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $colaborador_hora_extradao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "hr_extra_ini"=>$query[$i]['hr_extra_ini'],
                    "hr_extra_fim"=>$query[$i]['hr_extra_fim'],
                    "obs"=>$query[$i]['obs']
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
        $query = $colaborador_hora_extradao->listar_por_colaborador_pk($colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "hr_extra_ini"=>$query[$i]['hr_extra_ini'],
                    "hr_extra_fim"=>$query[$i]['hr_extra_fim'],
                    "obs"=>$query[$i]['obs']
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
        $query = $colaborador_hora_extradao->listar_por_colaborador_pk($colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_dt_escala"=>$query[$i]['dt_escala'],
                    "t_hr_extra_ini"=>$query[$i]['hr_extra_ini'],
                    "t_hr_extra_fim"=>$query[$i]['hr_extra_fim'],
                    "t_obs"=>$query[$i]['obs'],

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

$colaborador_hora_extradao = null;

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
