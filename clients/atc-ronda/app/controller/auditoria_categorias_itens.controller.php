<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/auditoria_categorias_itens.dao.php";
require_once "../model/auditoria_categorias_itens.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_categoria_item = $arrRequest['ds_categoria_item'];
$tipo_item_pk = $arrRequest['tipo_item_pk'];
$ic_status = $arrRequest['ic_status'];
$auditorias_categorias_pk = $arrRequest['auditorias_categorias_pk'];
$auditorias_categorias_tipos_pk = $arrRequest['auditorias_categorias_tipos_pk'];
$supervisao_auditorias_pk = $arrRequest['supervisao_auditorias_pk'];
$ic_obrigatorio = $arrRequest['ic_obrigatorio'];
$strJSONDadosStatus = $arrRequest['strJSONDadosStatus'];

$auditoria_categorias_itensdao = new auditoria_categorias_itensdao();
$auditoria_categorias_itensdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $auditoria_categorias_itens = $auditoria_categorias_itensdao->carregarPorPk($pk);
        if($auditoria_categorias_itens->getpk()>0){
            
            $auditoria_categorias_itensdao->excluir($auditoria_categorias_itens);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'auditoria_categorias_itens nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $auditoria_categorias_itens = $auditoria_categorias_itensdao->carregarPorPk($pk);
        $auditoria_categorias_itens->setds_categoria_item($ds_categoria_item);
        $auditoria_categorias_itens->settipo_item_pk($tipo_item_pk);
        $auditoria_categorias_itens->setic_status($ic_status);
        $auditoria_categorias_itens->setauditorias_categorias_pk($auditorias_categorias_pk);
        $auditoria_categorias_itens->setauditorias_categorias_tipos_pk($auditorias_categorias_tipos_pk);
        $auditoria_categorias_itens->setic_obrigatorio($ic_obrigatorio);

        
        $pk = $auditoria_categorias_itensdao->salvar($auditoria_categorias_itens);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'atualizarStatus':{

        $auditoria_categorias_itensdao->atualizarStatus($strJSONDadosStatus);
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }

    case 'listarPk':{
        
        $resultado = "";
        $query = $auditoria_categorias_itensdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_categoria_item"=>$query[$i]['ds_categoria_item'],
                    "tipo_item_pk"=>$query[$i]['tipo_item_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "auditorias_categorias_pk"=>$query[$i]['auditorias_categorias_pk'],
                    "auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "ic_obrigatorio"=>$query[$i]['ic_obrigatorio']
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
    case 'listarPorCategoriasTiposPk':{
        
        $resultado = "";
        $query = $auditoria_categorias_itensdao->listarPorCategoriasTiposPk($auditorias_categorias_tipos_pk);
        
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

    case 'listarPorCategoriasTiposSupervisao':{
        
        $resultado = "";
        $query = $auditoria_categorias_itensdao->listarPorCategoriasTiposSupervisao($auditorias_categorias_tipos_pk, $supervisao_auditorias_pk);
        
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
                    "ds_ic_obrigatorio"=>$query[$i]['ds_ic_obrigatorio'],
                    "ds_resultado_dados"=>$query[$i]['ds_resultado_dados']
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
        $query = $auditoria_categorias_itensdao->listar_por_ds_categoria_item($ds_categoria_item);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_categoria_item"=>$query[$i]['ds_categoria_item'],
                    "tipo_item_pk"=>$query[$i]['tipo_item_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "auditorias_categorias_pk"=>$query[$i]['auditorias_categorias_pk'],
                    "auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "ic_obrigatorio"=>$query[$i]['ic_obrigatorio']
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
        $query = $auditoria_categorias_itensdao->listar_por_ds_categoria_item($ds_categoria_item);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_categoria_item"=>$query[$i]['ds_categoria_item'],
                    "t_tipo_item_pk"=>$query[$i]['tipo_item_pk'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_auditorias_categorias_pk"=>$query[$i]['auditorias_categorias_pk'],
                    "t_auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "t_ic_obrigatorio"=>$query[$i]['ic_obrigatorio'],

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

$auditoria_categorias_itensdao = null;

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
