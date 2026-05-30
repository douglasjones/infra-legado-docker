<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/ronda.dao.php";
require_once "../model/ronda.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$leads_pk = $arrRequest['leads_pk'];
$local_ronda_pk = $arrRequest['local_ronda_pk'];
$dt_ronda = $arrRequest['dt_ronda'];


$rondadao = new rondadao();
$rondadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $ronda = $rondadao->carregarPorPk($pk);
        if($ronda->getpk()>0){
            
            $rondadao->excluir($ronda);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'ronda nao encontrado';
        }
        break;
    }
    case 'salvar':{
   
        

        $ronda = $rondadao->carregarPorPk($pk);
        $ronda->setleads_pk($leads_pk);
        $ronda->setlocal_ronda_pk($local_ronda_pk);
        $ronda->setdt_ronda($dt_ronda);

        
        $pk = $rondadao->salvar($ronda);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $rondadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "local_ronda_pk"=>$query[$i]['local_ronda_pk'],
                    "dt_ronda"=>$query[$i]['dt_ronda']
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
        $query = $rondadao->listar_por_leads_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "local_ronda_pk"=>$query[$i]['local_ronda_pk'],
                    "dt_ronda"=>$query[$i]['dt_ronda']
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
        $query = $rondadao->listar_por_leads_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_local_ronda_pk"=>$query[$i]['local_ronda_pk'],
                    "t_dt_ronda"=>$query[$i]['dt_ronda'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }  
    case 'relatorioRonda':{       
        
        $leads_pk = $_REQUEST["leads_pk"];
        $dt_ronda_ini = $_REQUEST["dt_contrato_ini"];
        $$dt_ronda_fim = $_REQUEST["dt_contrato_fim"]; 

        $resultado = "";
        $query = $rondadao->relatorioRonda($leads_pk,$dt_ronda_ini,$$dt_ronda_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_local_ronda"=>$query[$i]['local_ronda_pk'],
                    "t_dt_honda"=>$query[$i]['dt_cad'],
                    "t_hr_ronda"=>$query[$i]['hr_ronda'],

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

$rondadao = null;

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
