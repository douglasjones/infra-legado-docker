<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/frota.dao.php";
require_once "../model/frota.class.php";

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
$ds_categoria_item = $arrRequest['ds_categoria_item'];


$frotadao = new frotadao();
$frotadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $frota = $frotadao->carregarPorPk($pk);
        if($frota->getpk()>0){
            
            $frotadao->excluir($frota);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'frota nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $frota = $frotadao->carregarPorPk($pk);
        $frota->setid_veiculo($id_veiculo);
        $frota->setds_placa($ds_placa);
        $frota->setds_km_inicial($ds_km_inicial);
        $frota->setds_cor($ds_cor);
        $frota->settipo_veiculo_pk($tipo_veiculo_pk);
        $frota->setmarcas_veiculos_pk($marcas_veiculos_pk);
        $frota->setmodelos_veiculos_pk($modelos_veiculos_pk);
        $frota->setleads_pk($leads_pk);
        $frota->setic_status($ic_status);

        
        $pk = $frotadao->salvar($frota);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $frotadao->listarPorPk($pk);
        
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
                    "ic_status"=>$query[$i]['ic_status'],
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
        $query = $frotadao->listarTodos();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "id_veiculo"=>$query[$i]['id_veiculo'],
                    "usuario_cadastro_pk"=>$query[$i]['usuario_cadastro_pk'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
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
    case 'listarPorIdVeiculo':{
        
        $resultado = "";
        $query = $frotadao->listar_por_id_veiculo($id_veiculo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "id_veiculo"=>$query[$i]['id_veiculo'],
                    "usuario_cadastro_pk"=>$query[$i]['usuario_cadastro_pk'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_placa"=>$query[$i]['ds_placa'],
                    "ds_km_inicial"=>$query[$i]['ds_km_inicial'],
                    "ds_cor"=>$query[$i]['ds_cor'],
                    "tipo_veiculo_pk"=>$query[$i]['tipo_veiculo_pk'],
                    "marcas_veiculos_pk"=>$query[$i]['marcas_veiculos_pk'],
                    "modelos_veiculos_pk"=>$query[$i]['modelos_veiculos_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "ds_categoria_item"=>$query[$i]['ds_categoria_item'],
                    "tipo_item_pk"=>$query[$i]['tipo_item_pk'],
                    "ds_tipo_item"=>$query[$i]['ds_tipo_item'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "auditorias_categorias_pk"=>$query[$i]['auditorias_categorias_pk'],
                    "auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "ic_obrigatorio"=>$query[$i]['ic_obrigatorio'],
                    "itensDados"=>$query[$i]['itensDados'],
                    "checklistItens"=>$query[$i]['checklistItens'],
                    "ds_ic_obrigatorio"=>$query[$i]['ds_ic_obrigatorio']
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
        $query = $frotadao->listar_por_id_veiculo($id_veiculo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_id_veiculo"=>$query[$i]['id_veiculo'],
                    "t_ds_placa"=>$query[$i]['ds_placa'],
                    "t_ds_km_inicial"=>$query[$i]['ds_km_inicial'],
                    "t_ds_cor"=>$query[$i]['ds_cor'],
                    "t_tipo_veiculo_pk"=>$query[$i]['tipo_veiculo_pk'],
                    "t_marcas_veiculos_pk"=>$query[$i]['marcas_veiculos_pk'],
                    "t_modelos_veiculos_pk"=>$query[$i]['modelos_veiculos_pk'],
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
    case 'listarFormPorIdVeiculo':{

        $resultado = "";
        $query = $frotadao->listarFormPorIdVeiculo($ds_categoria_item);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_categoria_item"=>$query[$i]['ds_categoria_item'],
                    "tipo_item_pk"=>$query[$i]['tipo_item_pk'],
                    "ds_tipo_item"=>$query[$i]['ds_tipo_item'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "auditorias_categorias_pk"=>$query[$i]['auditorias_categorias_pk'],
                    "auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "itensDados"=>$query[$i]['itensDados'],
                    "ic_obrigatorio"=>$query[$i]['ic_obrigatorio'],
                    "ds_ic_obrigatorio"=>$query[$i]['ds_ic_obrigatorio']
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
    default:{
        break;
    }
}

$frotadao = null;

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
