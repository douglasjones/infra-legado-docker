<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/veiculos_condutores.dao.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$tipo_veiculo_pk = $arrRequest['tipo_veiculo_pk'];
$marca_veiculo_pk = $arrRequest['marca_veiculo_pk'];
$modelo_veiculo_pk = $arrRequest['modelo_veiculo_pk'];
$condutor_pk = $arrRequest['condutor_pk'];
$ds_tipo_veiculo = $arrRequest['ds_tipo_veiculo'];
$ic_status = $arrRequest['ic_status'];
$ds_marca_veiculo = $arrRequest['ds_marca_veiculo'];
$ic_status = $arrRequest['ic_status'];
$ds_modelo_veiculo = $arrRequest['ds_modelo_veiculo'];
$ic_status = $arrRequest['ic_status'];
$ds_condutor = $arrRequest['ds_condutor'];
$ds_cpf = $arrRequest['ds_cpf'];
$ds_rg = $arrRequest['ds_rg'];
$leads_pk = $arrRequest['leads_pk'];
$ic_status = $arrRequest['ic_status'];


$veiculos_condutoresdao = new veiculos_condutoresdao();
$veiculos_condutoresdao->setToken($token); 

switch($job){
    case 'listarTodos':{
        
        $resultado = "";
        $query = $veiculos_condutoresdao->listarTodos($ds_tipo_veiculo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                     //Tbl Tipo Veiculo
                     "tipo_veiculo_pk" => $query[$i]["tipo_veiculo_pk"],
                     "ds_tipo_veiculo"=>$query[$i]['ds_tipo_veiculo'],
                     "ic_status_tipo_veiculo"=>$query[$i]['ic_status_tipo_veiculo'],
                     //Tbl Marcas Veiculo
                     "marca_veiculo_pk" => $query[$i]["marca_veiculo_pk"],
                     "ds_marca_veiculo"=>$query[$i]['ds_marca_veiculo'],
                     "ic_status_marca_veiculo"=>$query[$i]['ic_status_marca_veiculo'],
                     //Tbl Modelos Veiculo
                     "modelo_veiculo_pk" => $query[$i]["modelo_veiculo_pk"],
                     "ds_modelo_veiculo"=>$query[$i]['ds_modelo_veiculo'],
                     "ic_status_modelo_veiculo"=>$query[$i]['ic_status_modelo_veiculo'],
                     //Tbl Condutor
                     "condutor_pk" => $query[$i]["condutor_pk"],
                     "ds_condutor"=>$query[$i]['ds_condutor'],
                     "ds_cpf"=>$query[$i]['ds_cpf'],
                     "ds_rg"=>$query[$i]['ds_rg'],
                     "leads_pk"=>$query[$i]['leads_pk'],
                     "ic_status_condutor"=>$query[$i]['ic_status_condutor']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarVeiculos':{
        
        $resultado = "";
        $query = $veiculos_condutoresdao->listarCondutores($ds_tipo_veiculo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                     //Tbl Condutor
                     "condutor_pk" => $query[$i]["condutor_pk"],
                     "ds_condutor"=>$query[$i]['ds_condutor']
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

$veiculos_condutoresdao = null;

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
