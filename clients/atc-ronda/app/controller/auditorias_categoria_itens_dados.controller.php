<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/auditorias_categoria_itens_dados.dao.php";
require_once "../model/auditorias_categoria_itens_dados.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_item_dados = $arrRequest['ds_item_dados'];
$ic_status = $arrRequest['ic_status'];
$auditorias_categorias_itens_pk = $arrRequest['auditorias_categorias_itens_pk'];
$tipo_item_pk = $arrRequest['tipo_item_pk'];
$dadosItensCampo = $arrRequest['dadosItensCampo'];

$auditorias_categoria_itens_dadosdao = new auditorias_categoria_itens_dadosdao();
$auditorias_categoria_itens_dadosdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $auditorias_categoria_itens_dados = $auditorias_categoria_itens_dadosdao->carregarPorPk($pk);
        if($auditorias_categoria_itens_dados->getpk()>0){
            
            $auditorias_categoria_itens_dadosdao->excluir($auditorias_categoria_itens_dados);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'auditorias_categoria_itens_dados nao encontrado';
        }
        break;
    }
    case 'salvar':{
        $auditorias_categoria_itens_dados = $auditorias_categoria_itens_dadosdao->carregarPorPk($pk);
        $auditorias_categoria_itens_dados->setic_status($ic_status);
        $auditorias_categoria_itens_dados->setauditorias_categorias_itens_pk($auditorias_categorias_itens_pk);
        $pk = $auditorias_categoria_itens_dadosdao->salvar($auditorias_categoria_itens_dados, $dadosItensCampo);
        
        $mysql_data[] = array(
            "pk" => $pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $auditorias_categoria_itens_dadosdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_item_dados"=>$query[$i]['ds_item_dados'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "auditorias_categorias_itens_pk"=>$query[$i]['auditorias_categorias_itens_pk'],
                    "tipo_item_pk"=>$query[$i]['tipo_item_pk']
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
        $query = $auditorias_categoria_itens_dadosdao->listar_por_ds_item_dados($ds_item_dados);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_item_dados"=>$query[$i]['ds_item_dados'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "auditorias_categorias_itens_pk"=>$query[$i]['auditorias_categorias_itens_pk'],
                    "tipo_item_pk"=>$query[$i]['tipo_item_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarPorItens':{
        
        $resultado = "";
        $query = $auditorias_categoria_itens_dadosdao->listarPorItens($auditorias_categorias_itens_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_item_dados"=>$query[$i]['ds_item_dados'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "auditorias_categorias_itens_pk"=>$query[$i]['auditorias_categorias_itens_pk'],
                    "tipo_item_pk"=>$query[$i]['tipo_item_pk']
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
        $query = $auditorias_categoria_itens_dadosdao->listar_por_ds_item_dados($ds_item_dados);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_item_dados"=>$query[$i]['ds_item_dados'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_auditorias_categorias_itens_pk"=>$query[$i]['auditorias_categorias_itens_pk'],
                    "t_tipo_item_pk"=>$query[$i]['tipo_item_pk'],

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

$auditorias_categoria_itens_dadosdao = null;

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
