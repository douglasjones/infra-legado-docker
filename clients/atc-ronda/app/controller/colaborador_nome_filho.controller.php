<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/colaborador_nome_filho.dao.php";
require_once "../model/colaborador_nome_filho.class.php";

require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$ds_nome_filho = $arrRequest['ds_nome_filho'];
$ds_cpf_filho = $arrRequest['ds_cpf_filho'];
$dt_nascimento_filho = $arrRequest['dt_nascimento_filho'];


$colaborador_nome_filhodao = new colaborador_nome_filhodao();
$colaborador_nome_filhodao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $colaborador_nome_filho = $colaborador_nome_filhodao->carregarPorPk($pk);
        if($colaborador_nome_filho->getpk()>0){
            $log_exclusaodao->salvar("colaborador_nome_filho",$colaborador_nome_filho->getpk());
            $colaborador_nome_filhodao->excluir($colaborador_nome_filho);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'colaborador_nome_filho nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $colaborador_nome_filho = $colaborador_nome_filhodao->carregarPorPk($pk);
        $colaborador_nome_filho->setcolaborador_pk($colaborador_pk);
        $colaborador_nome_filho->setds_nome_filho($ds_nome_filho);
        $colaborador_nome_filho->setds_cpf_filho($ds_cpf_filho);
        $colaborador_nome_filho->setdt_nascimento_filho($dt_nascimento_filho);

        
        $pk = $colaborador_nome_filhodao->salvar($colaborador_nome_filho);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $colaborador_nome_filhodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "ds_nome_filho"=>$query[$i]['ds_nome_filho'],
                    "ds_cpf_filho"=>$query[$i]['ds_cpf_filho'],
                    "dt_nascimento_filho"=>$query[$i]['dt_nascimento_filho']
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
        $query = $colaborador_nome_filhodao->listar_por_colaborador_pk($colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "ds_nome_filho"=>$query[$i]['ds_nome_filho'],
                    "ds_cpf_filho"=>$query[$i]['ds_cpf_filho'],
                    "dt_nascimento_filho"=>$query[$i]['dt_nascimento_filho']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarNomeFilhoColaboradorPk':{
        
        $resultado = "";
        $result  = 'success';
        $message = 'query success';
        if($colaborador_pk!=""){
            $query = $colaborador_nome_filhodao->listarNomeFilhoColaboradorPk($colaborador_pk);
        
            

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "colaborador_pk"=>$query[$i]['colaborador_pk'],
                        "ds_nome_filho"=>$query[$i]['ds_nome_filho'],
                        "ds_cpf_filho"=>$query[$i]['ds_cpf_filho'],
                        "dt_nascimento_filho"=>$query[$i]['dt_nascimento_filho'],
                        "ds_tipo_sanguineo_dependente"=>$query[$i]['ds_tipo_sanguineo_dependente'],
                        "ds_num_cartao_sus_dependente"=>$query[$i]['ds_num_cartao_sus_dependente']
                        
                    );
                }
            }
            else{
                $mysql_data = [];
            }
        }
        else{
            $mysql_data = [];
        }
        
			
        
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $colaborador_nome_filhodao->listar_por_colaborador_pk($colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_ds_nome_filho"=>$query[$i]['ds_nome_filho'],
                    "t_ds_cpf_filho"=>$query[$i]['ds_cpf_filho'],
                    "t_dt_nascimento_filho"=>$query[$i]['dt_nascimento_filho'],

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

$colaborador_nome_filhodao = null;

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
