<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/propostas_facilities_grupos_subgrupos.dao.php";
require_once "../model/propostas_facilities_grupos_subgrupos.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ic_tipo_grupo = $arrRequest['ic_tipo_grupo'];
$ds_nome_grupo = $arrRequest['ds_nome_grupo'];
$grupo_pai_pk = $arrRequest['grupo_pai_pk'];
$ic_status = $arrRequest['ic_status'];


$propostas_facilities_grupos_subgruposdao = new propostas_facilities_grupos_subgruposdao();
$propostas_facilities_grupos_subgruposdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $propostas_facilities_grupos_subgrupos = $propostas_facilities_grupos_subgruposdao->carregarPorPk($pk);
        if($propostas_facilities_grupos_subgrupos->getpk()>0){
            
            $propostas_facilities_grupos_subgruposdao->excluir($propostas_facilities_grupos_subgrupos);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'propostas_facilities_grupos_subgrupos nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $propostas_facilities_grupos_subgrupos = $propostas_facilities_grupos_subgruposdao->carregarPorPk($pk);
        $propostas_facilities_grupos_subgrupos->setic_tipo_grupo($ic_tipo_grupo);
        $propostas_facilities_grupos_subgrupos->setds_nome_grupo($ds_nome_grupo);
        $propostas_facilities_grupos_subgrupos->setgrupo_pai_pk($grupo_pai_pk);
        $propostas_facilities_grupos_subgrupos->setic_status($ic_status);

        
        $pk = $propostas_facilities_grupos_subgruposdao->salvar($propostas_facilities_grupos_subgrupos);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $propostas_facilities_grupos_subgruposdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ic_tipo_grupo"=>$query[$i]['ic_tipo_grupo'],
                    "ds_nome_grupo"=>$query[$i]['ds_nome_grupo'],
                    "grupo_pai_pk"=>$query[$i]['grupo_pai_pk'],
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
        $query = $propostas_facilities_grupos_subgruposdao->listar_por_ic_tipo_grupo($ic_tipo_grupo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ic_tipo_grupo"=>$query[$i]['ic_tipo_grupo'],
                    "ds_nome_grupo"=>$query[$i]['ds_nome_grupo'],
                    "grupo_pai_pk"=>$query[$i]['grupo_pai_pk'],
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
        $query = $propostas_facilities_grupos_subgruposdao->listar_por_ic_tipo_grupo($ic_tipo_grupo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ic_tipo_grupo"=>$query[$i]['ic_tipo_grupo'],
                    "t_ds_nome_grupo"=>$query[$i]['ds_nome_grupo'],
                    "t_grupo_pai_pk"=>$query[$i]['grupo_pai_pk'],
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

$propostas_facilities_grupos_subgruposdao = null;

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
