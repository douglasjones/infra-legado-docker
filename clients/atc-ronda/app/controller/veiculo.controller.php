<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/veiculo.dao.php";
require_once "../model/veiculo.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$id_veiculo = $arrRequest['id_veiculo'];
$ds_placa = $arrRequest['ds_placa'];
$ds_km_inicial = $arrRequest['ds_km_inicial'];
$ds_cor = $arrRequest['ds_cor'];
$tipo_veiculo_pk = $arrRequest['tipo_veiculo_pk'];
$marcas_veiculos_pk = $arrRequest['marcas_veiculos_pk'];
$modelos_veiculos_pk = $arrRequest['modelos_veiculos_pk'];
$leads_pk = $arrRequest['leads_pk'];
$ic_status = $arrRequest['ic_status'];

$veiculodao = new veiculodao();
$veiculodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $veiculo = $veiculodao->carregarPorPk($pk);
        if($veiculo->getpk()>0){
            
            $veiculodao->excluir($veiculo);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'veiculo nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $veiculo = $veiculodao->carregarPorPk($pk);
        $veiculo->setid_veiculo($id_veiculo);
        $veiculo->setds_placa($ds_placa);
        $veiculo->setds_km_inicial($ds_km_inicial);
        $veiculo->setds_cor($ds_cor);
        $veiculo->settipo_veiculo_pk($tipo_veiculo_pk);
        $veiculo->setmarcas_veiculos_pk($marcas_veiculos_pk);
        $veiculo->setmodelos_veiculos_pk($modelos_veiculos_pk);
        $veiculo->setleads_pk($leads_pk);
        $veiculo->setic_status($ic_status);

        
        $pk = $veiculodao->salvar($veiculo);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $veiculodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "id_veiculo"=>$query[$i]['id_veiculo'],
                    "ds_placa"=>$query[$i]['ds_placa'],
                    "ds_km_inicial"=>$query[$i]['ds_km_inicial'],
                    "ds_cor"=>$query[$i]['ds_cor'],
                    "tipo_veiculo_pk"=>$query[$i]['tipo_veiculo_pk'],
                    "marcas_veiculos_pk"=>$query[$i]['marcas_veiculos_pk'],
                    "modelos_veiculos_pk"=>$query[$i]['modelos_veiculos_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }else{
            $mysql_data = [];
        }
			
        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $veiculodao->listar_por_id_veiculo($id_veiculo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "id_veiculo"=>$query[$i]['id_veiculo'],
                    "ds_placa"=>$query[$i]['ds_placa'],
                    "ds_km_inicial"=>$query[$i]['ds_km_inicial'],
                    "ds_cor"=>$query[$i]['ds_cor'],
                    "tipo_veiculo_pk"=>$query[$i]['tipo_veiculo_pk'],
                    "marcas_veiculos_pk"=>$query[$i]['marcas_veiculos_pk'],
                    "modelos_veiculos_pk"=>$query[$i]['modelos_veiculos_pk'],
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
        $query = $veiculodao->listar_por_id_veiculo($id_veiculo,$ds_placa,$leads_pk,$ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_id_veiculo"=>$query[$i]['id_veiculo'],
                    "t_ds_placa"=>$query[$i]['ds_placa'],
                    "t_ds_tipo_veiculo"=>$query[$i]['ds_tipo_veiculo'],
                    "t_ds_marca_veiculo"=>$query[$i]['ds_marca_veiculo'],
                    "t_ds_modelo_veiculo"=>$query[$i]['ds_modelo_veiculo'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_status"=>$query[$i]['ds_status'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }  
    
    case 'listarTiposVeiculos':{
        
        $resultado = "";
        $query = $veiculodao->listarTiposVeiculos();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_tipo_veiculo"=>$query[$i]['ds_tipo_veiculo']
        
                );
            }
        }
        else{
            $mysql_data = [];
        }		
        
        break;
    }

    case 'listarMarcasVeiculos':{
        
        $resultado = "";
        $query = $veiculodao->listarMarcasVeiculos();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_marca_veiculo"=>$query[$i]['ds_marca_veiculo']
        
                );
            }
        }
        else{
            $mysql_data = [];
        }		
        
        break;
    }

    case '"listarModelosVeiculos':{
        
        $resultado = "";
        $query = $veiculodao->listarModelosVeiculos();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_modelo_veiculo"=>$query[$i]['ds_modelo_veiculo']
        
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

$veiculodao = null;

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
