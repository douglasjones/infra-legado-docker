<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/entrada_estoque.dao.php";
require_once "../model/entrada_estoque.class.php";
require_once "../model/produto_iten.dao.php";
require_once "../model/produto_iten.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";




$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_n_ordem = $arrRequest['ds_n_ordem'];
$obs_entrada_estoque = $arrRequest['obs_entrada_estoque'];
$fornecedor_pk = $arrRequest['fornecedor_pk'];
$produtos_pk = $arrRequest['produtos_pk'];
$qtde = $arrRequest['qtde'];
$vl_unitario = $arrRequest['vl_unitario'];
$produtos_itens = $arrRequest['produtos_itens'];


$entrada_estoquedao = new entrada_estoquedao();
$entrada_estoquedao->setToken($token);

$produto_itendao = new produto_itendao();
$produto_itendao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $entrada_estoque = $entrada_estoquedao->carregarPorPk($pk);
        if($entrada_estoque->getpk()>0){
            
            $pk_estoque = $entrada_estoquedao->listarPkProdutoItem($entrada_estoque->getpk());
            
            if(count($pk_estoque)>0){
                for($i=0;$i<count($pk_estoque);$i++){
                    $log_exclusaodao->salvar("produtos_itens", $pk_estoque[$i]['pk']);
                }
            }


            $log_exclusaodao->salvar("entrada_estoque",$entrada_estoque->getpk());
            
            
            
            
            
            $produto_itendao->excluirEstoque($entrada_estoque->getpk());
            $entrada_estoquedao->excluir($entrada_estoque);
            
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'entrada_estoque nao encontrado';
        }
        break;
    }
    case 'salvar':{

        $entrada_estoque = $entrada_estoquedao->carregarPorPk($pk);
        $entrada_estoque->setds_n_ordem($ds_n_ordem);
        $entrada_estoque->setobs_entrada_estoque($obs_entrada_estoque);
        $entrada_estoque->setfornecedor_pk($fornecedor_pk);
        $entrada_estoque->setprodutos_pk($produtos_pk);
        $entrada_estoque->setqtde($qtde);
        $entrada_estoque->setvl_unitario($vl_unitario);

        
        $pk = $entrada_estoquedao->salvar($entrada_estoque);
        
        
        if($produtos_itens != "")
            $arrProdutosItens = json_decode ($produtos_itens, true);
        
        if(count($arrProdutosItens) > 0){
            for($i = 0; $i < count($arrProdutosItens); $i++){

                $produto_iten = $produto_itendao->carregarPorPk($arrProdutosItens[$i]['produtos_itens_pk']);
                $produto_iten->setds_n_serie($arrProdutosItens[$i]['ds_n_serie']);
                $produto_iten->setvl_item($vl_unitario);
                $produto_iten->setprodutos_pk($produtos_pk);
                $produto_iten->setentrada_estoque_pk($pk);
                
                $produto_itens_pk = $produto_itendao->salvar($produto_iten);

            }
        }
        else if($qtde!=""){
            for($i = 0; $i < $qtde; $i++){

                $produto_iten = $produto_itendao->carregarPorPk("");
                $produto_iten->setds_n_serie("");
                $produto_iten->setvl_item($vl_unitario);
                $produto_iten->setprodutos_pk($produtos_pk);
                $produto_iten->setentrada_estoque_pk($pk);
                
                $produto_itens_pk = $produto_itendao->salvar($produto_iten);

            }
        }

        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $entrada_estoquedao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_n_ordem"=>$query[$i]['ds_n_ordem'],
                    "obs_entrada_estoque"=>$query[$i]['obs_entrada_estoque'],
                    "fornecedor_pk"=>$query[$i]['fornecedor_pk'],
                    "produtos_pk"=>$query[$i]['produtos_pk'],
                    "vl_unitario"=>$query[$i]['vl_unitario'],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "qtde"=>$query[$i]['qtde']
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
        $query = $entrada_estoquedao->listar_por_ds_n_ordem($ds_n_ordem);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_n_ordem"=>$query[$i]['ds_n_ordem'],
                    "obs_entrada_estoque"=>$query[$i]['obs_entrada_estoque'],
                    "fornecedor_pk"=>$query[$i]['fornecedor_pk'],
                    "produtos_pk"=>$query[$i]['produtos_pk'],
                    "vl_unitario"=>$query[$i]['vl_unitario'],
                    "qtde"=>$query[$i]['qtde']
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
        $query = $entrada_estoquedao->listar_por_ds_n_ordem($ds_n_ordem);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_cadastro" => $query[$i]["dt_cadastro"],
                    "t_ds_n_ordem"=>$query[$i]['ds_n_ordem'],
                    "t_obs_entrada_estoque"=>$query[$i]['obs_entrada_estoque'],
                    "t_ds_fornecedor"=>$query[$i]['ds_fornecedor'],
                    "t_ds_produto"=>$query[$i]['ds_produto'],
                    "t_qtde"=>$query[$i]['qtde'],
                    "t_vl_unitario"=>$query[$i]['vl_unitario'],

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

$entrada_estoquedao = null;

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
