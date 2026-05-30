<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/propostas_facilities_itens.dao.php";
require_once "../model/propostas_facilities_itens.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_percentual = $arrRequest['ds_percentual'];
$ds_valor = $arrRequest['ds_valor'];
$ic_status = $arrRequest['ic_status'];
$propostas_facilities_label_pk = $arrRequest['propostas_facilities_label_pk'];
$propostas_facilities_grupos_subgrupos_pk = $arrRequest['propostas_facilities_grupos_subgrupos_pk'];
$propostas_facilities_pk = $arrRequest['propostas_facilities_pk'];
$propostas_facilities_pk = $arrRequest['propostas_facilities_pk'];
$arrGrupos = $arrRequest['arrGrupos'];

$propostas_facilities_itensdao = new propostas_facilities_itensdao();
$propostas_facilities_itensdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $propostas_facilities_itens = $propostas_facilities_itensdao->carregarPorPk($pk);
        if($propostas_facilities_itens->getpk()>0){
            
            $propostas_facilities_itensdao->excluir($propostas_facilities_itens);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'propostas_facilities_itens nao encontrado';
        }
        break;
    }
    case 'salvar':{

        
        $pk = $propostas_facilities_itensdao->salvar($arrGrupos);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $propostas_facilities_itensdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_percentual"=>$query[$i]['ds_percentual'],
                    "ds_valor"=>$query[$i]['ds_valor'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "propostas_facilities_label_pk"=>$query[$i]['propostas_facilities_label_pk'],
                    "propostas_facilities_grupos_subgrupos_pk"=>$query[$i]['propostas_facilities_grupos_subgrupos_pk'],
                    "propostas_facilities_pk"=>$query[$i]['propostas_facilities_pk']
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
        $query = $propostas_facilities_itensdao->listar_por_ds_percentual($ds_percentual);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_percentual"=>$query[$i]['ds_percentual'],
                    "ds_valor"=>$query[$i]['ds_valor'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "propostas_facilities_label_pk"=>$query[$i]['propostas_facilities_label_pk'],
                    "propostas_facilities_grupos_subgrupos_pk"=>$query[$i]['propostas_facilities_grupos_subgrupos_pk'],
                    "propostas_facilities_pk"=>$query[$i]['propostas_facilities_pk']
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
        $query = $propostas_facilities_itensdao->listar_por_ds_percentual($ds_percentual);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_percentual"=>$query[$i]['ds_percentual'],
                    "t_ds_valor"=>$query[$i]['ds_valor'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_propostas_facilities_label_pk"=>$query[$i]['propostas_facilities_label_pk'],
                    "t_propostas_facilities_grupos_subgrupos_pk"=>$query[$i]['propostas_facilities_grupos_subgrupos_pk'],
                    "t_propostas_facilities_pk"=>$query[$i]['propostas_facilities_pk'],

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

$propostas_facilities_itensdao = null;

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
