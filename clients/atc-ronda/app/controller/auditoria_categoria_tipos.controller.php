<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/auditoria_categoria_tipos.dao.php";
require_once "../model/auditoria_categoria_tipos.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$auditoria_categorias_pk = $arrRequest['auditoria_categorias_pk'];
$ds_auditoria_categoria_tipo = $arrRequest['ds_auditoria_categoria_tipo'];
$ic_status = $arrRequest['ic_status'];


$auditoria_categoria_tiposdao = new auditoria_categoria_tiposdao();
$auditoria_categoria_tiposdao->setToken($token); 

switch($job){
    case 'excluir':{
        
        $resultdo = "";
        
        $auditoria_categoria_tipos = $auditoria_categoria_tiposdao->carregarPorPk($pk);
        if($auditoria_categoria_tipos->getpk()>0){
            
            $auditoria_categoria_tiposdao->excluir($auditoria_categoria_tipos);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'auditoria_categoria_tipos nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $auditoria_categoria_tipos = $auditoria_categoria_tiposdao->carregarPorPk($pk);
        $auditoria_categoria_tipos->setauditoria_categorias_pk($auditoria_categorias_pk);
        $auditoria_categoria_tipos->setds_auditoria_categoria_tipo($ds_auditoria_categoria_tipo);
        $auditoria_categoria_tipos->setic_status($ic_status);

        
        $pk = $auditoria_categoria_tiposdao->salvar($auditoria_categoria_tipos);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $auditoria_categoria_tiposdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "auditoria_categorias_pk"=>$query[$i]['auditoria_categorias_pk'],
                    "ds_auditoria_categoria_tipo"=>$query[$i]['ds_auditoria_categoria_tipo'],
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
        $query = $auditoria_categoria_tiposdao->listar_por_auditoria_categorias_pk($auditoria_categorias_pk, $ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "auditoria_categorias_pk"=>$query[$i]['auditoria_categorias_pk'],
                    "ds_auditoria_categoria_tipo"=>$query[$i]['ds_auditoria_categoria_tipo'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarPorAuditoriaCategoriasPk':{
        
        $resultado = "";
        $query = $auditoria_categoria_tiposdao->listarPorAuditoriaCategoriasPk($auditoria_categorias_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "auditoria_categorias_pk"=>$query[$i]['auditoria_categorias_pk'],
                    "ds_auditoria_categoria_tipo"=>$query[$i]['ds_auditoria_categoria_tipo']
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
        $query = $auditoria_categoria_tiposdao->listar_por_auditoria_categorias_pk();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_auditoria_categorias_pk"=>$query[$i]['auditoria_categorias_pk'],
                    "t_ds_categoria"=>$query[$i]['ds_categoria'],
                    "t_ds_auditoria_categoria_tipo"=>$query[$i]['ds_auditoria_categoria_tipo'],
                    "t_ic_status"=>$query[$i]['ds_status'],

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

$auditoria_categoria_tiposdao = null;

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
