<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/produto.dao.php";
require_once "../model/produto.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_produto = $arrRequest['ds_produto'];
$obs = $arrRequest['obs'];
$ic_status = $arrRequest['ic_status'];
$categorias_produto_pk = $arrRequest['categorias_produto_pk'];
$tipo_unidade_pk = $arrRequest['tipo_unidade_pk'];
$ic_tempo_troca = $arrRequest['ic_tempo_troca'];
$qtde_minima = $arrRequest['qtde_minima'];


$produtodao = new produtodao();
$produtodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $produto = $produtodao->carregarPorPk($pk);
        if($produto->getpk()>0){
            
            $produtodao->excluir($produto);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'produto nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $produto = $produtodao->carregarPorPk($pk);
        $produto->setds_produto($ds_produto);
        $produto->setobs($obs);
        $produto->setic_status($ic_status);
        $produto->setcategorias_produto_pk($categorias_produto_pk);
        $produto->settipo_unidade_pk($tipo_unidade_pk);
        $produto->setic_tempo_troca($ic_tempo_troca);
        $produto->setqtde_minima($qtde_minima);

        
        $pk = $produtodao->salvar($produto);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $produtodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_produto"=>$query[$i]['ds_produto'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "ic_tempo_troca"=>$query[$i]['ic_tempo_troca'],
                    "tipo_unidade_pk"=>$query[$i]['tipo_unidade_pk'],
                    "qtde_minima"=>$query[$i]['qtde_minima']
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
        $query = $produtodao->listar_por_ds_produto($ds_produto);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_produto"=>$query[$i]['ds_produto'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "ic_tempo_troca"=>$query[$i]['ic_tempo_troca'],
                    "qtde_minima"=>$query[$i]['qtde_minima'],
                    "tipo_unidade_pk"=>$query[$i]['tipo_unidade_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarTodosComTempoTroca':{
        
        $resultado = "";
        $query = $produtodao->listarTodosComTempoTroca($ds_produto);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_produto"=>$query[$i]['ds_produto'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "ic_tempo_troca"=>$query[$i]['ic_tempo_troca'],
                    "qtde_minima"=>$query[$i]['qtde_minima'],
                    "tipo_unidade_pk"=>$query[$i]['tipo_unidade_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarPorCategoria':{
        $categorias_produto_pk = $_REQUEST['categorias_produto_pk'];
        $resultado = "";
        $query = $produtodao->listar_por_categorias($categorias_produto_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_produto"=>$query[$i]['ds_produto'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "ic_tempo_troca"=>$query[$i]['ic_tempo_troca'],
                    "qtde_minima"=>$query[$i]['qtde_minima'],
                    "tipo_unidade_pk"=>$query[$i]['tipo_unidade_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
        case 'listarPorPkCategoria':{
        
        $categorias_produto_pk = $_REQUEST['categorias_produto_pk'];    
            
        $resultado = "";
        $query = $produtodao->listar_por_pk_categoria($categorias_produto_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_produto"=>$query[$i]['ds_produto'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "ic_tempo_troca"=>$query[$i]['ic_tempo_troca'],
                    "qtde_minima"=>$query[$i]['qtde_minima'],
                    "tipo_unidade_pk"=>$query[$i]['tipo_unidade_pk']
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
        $query = $produtodao->listar_por_ds_produto($ds_produto);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_produto"=>$query[$i]['ds_produto'],
                    "t_obs"=>$query[$i]['obs'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_ds_categoria"=>$query[$i]['ds_categoria'],
                    "t_tipo_unidade_pk"=>$query[$i]['tipo_unidade_pk'],
                    "t_qtde_minima"=>$query[$i]['qtde_minima'],
                    "t_ic_tempo_troca"=>$query[$i]['ic_tempo_troca'],

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

$produtodao = null;

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
