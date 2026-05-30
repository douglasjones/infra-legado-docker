<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/produto_iten.dao.php";
require_once "../model/produto_iten.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_n_serie = $arrRequest['ds_n_serie'];
$qtde = $arrRequest['qtde'];
$vl_item = $arrRequest['vl_item'];
$produtos_pk = $arrRequest['produtos_pk'];
$entrada_estoque_pk = $arrRequest['entrada_estoque_pk'];
$dt_baixa = $arrRequest['dt_baixa'];
$obs_baixa = $arrRequest['obs_baixa'];
$usuario_baixa_pk = $arrRequest['usuario_baixa_pk'];


$ds_identificacao = $arrRequest['ds_identificacao'];
$polos_pk = $arrRequest['polos_pk'];
$dt_cancelamento = $arrRequest['dt_cancelamento']; 
$ds_motivo_cancelamento = $arrRequest['ds_motivo_cancelamento'];   
$compras_pk = $arrRequest['compras_pk'];   
$ic_entrega = $arrRequest['ic_entrega'];  

$produto_itendao = new produto_itendao();
$produto_itendao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $produto_iten = $produto_itendao->carregarPorPk($pk);
        if($produto_iten->getpk()>0){
            
            $produto_itendao->excluir($produto_iten);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'produto_iten nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $produto_iten = $produto_itendao->carregarPorPk($pk);
        $produto_iten->setds_n_serie($ds_n_serie);
        $produto_iten->setqtde($qtde);
        $produto_iten->setvl_item($vl_item);
        $produto_iten->setprodutos_pk($produtos_pk);
        $produto_iten->setentrada_estoque_pk($entrada_estoque_pk);
        $produto_iten->setdt_baixa($dt_baixa);
        $produto_iten->setobs_baixa($obs_baixa);
        $produto_iten->setusuario_baixa_pk($usuario_baixa_pk);
        $produto_iten->setds_identificacao($ds_identificacao);
        $produto_iten->setpolos_pk($polos_pk);
        $produto_iten->setdt_cancelamento($dt_cancelamento);
        $produto_iten->setds_motivo_cancelamento($ds_motivo_cancelamento);
        $produto_iten->setcompras_pk($compras_pk);
        $produto_iten->setic_entrega($ic_entrega);
        
        

        
        $pk = $produto_itendao->salvar($produto_iten);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $produto_itendao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_n_serie"=>$query[$i]['ds_n_serie'],
                    "qtde"=>$query[$i]['qtde'],
                    "vl_item"=>$query[$i]['vl_item'],
                    "entrada_estoque_pk"=>$query[$i]['entrada_estoque_pk'],
                    "produtos_pk"=>$query[$i]['produtos_pk']
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
    
    case 'listarPorPkProduto':{        
        $produtos_pk = $_REQUEST['produtos_pk'];
        $produtos_itens_pk = $_REQUEST['produtos_itens_pk'];
        $strProdutoGrid = $_REQUEST['strProdutoGrid'];
  
        $resultado = "";
        $query = $produto_itendao->listarPorPkProduto($produtos_pk,$produtos_itens_pk,$strProdutoGrid);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_n_serie"=>$query[$i]['ds_n_serie'],
                    "qtde"=>$query[$i]['qtde'],
                    "vl_item"=>$query[$i]['vl_item'],
                    "entrada_estoque_pk"=>$query[$i]['entrada_estoque_pk'],
                    "ds_produto_item"=>$query[$i]["pk"]."-".$query[$i]['ds_produto']." ".$query[$i]['ds_n_serie'],
                    "produtos_pk"=>$query[$i]['produtos_pk']
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
    case 'listarPorPkProdutoNotIn':{ 
        
        $produtos_pk = $_REQUEST['produtos_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $produtos_itens_pk = $_REQUEST['produtos_itens_pk'];
        $strProdutoGrid = $_REQUEST['strProdutoGrid'];
        $str = "";
        
        
        $queryl = $produto_itendao->listarPorLeadsPk($leads_pk,$colaborador_pk);
        
        
        $str .= "not in (";
        if($produtos_itens_pk==""){
            if(count($queryl) > 0){ 

                for($i = 0; $i < count($queryl); $i++){
                    $str .= $queryl[$i]['pk'].",";
                }

            }
        }
        $str .= "0)";
        
        
        
        
  
        $resultado = "";
        $query = $produto_itendao->listarPorPkProduto($produtos_pk,$produtos_itens_pk,$str);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_n_serie"=>$query[$i]['ds_n_serie'],
                    "qtde"=>$query[$i]['qtde'],
                    "vl_item"=>$query[$i]['vl_item'],
                    "entrada_estoque_pk"=>$query[$i]['entrada_estoque_pk'],
                    "ds_produto_item"=>$query[$i]["pk"]."-".$query[$i]['ds_produto']." ".$query[$i]['ds_n_serie'],
                    "produtos_pk"=>$query[$i]['produtos_pk']
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
        $query = $produto_itendao->listar_por_ds_n_serie($ds_n_serie);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_n_serie"=>$query[$i]['ds_n_serie'],
                    "qtde"=>$query[$i]['qtde'],
                    "vl_item"=>$query[$i]['vl_item'],
                    "entrada_estoque_pk"=>$query[$i]['entrada_estoque_pk'],
                    "produtos_pk"=>$query[$i]['produtos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }	
        
        break;
    }
    case 'listarPorProdutosQtde':{
        $produtos_pk = $_REQUEST['produtos_pk'];
        $qtde = $_REQUEST['qtde'];
        $strProdutoGrid = $_REQUEST['strProdutoGrid'];
        $resultado = "";
        $query = $produto_itendao->listarPorProdutosQtde($produtos_pk,$qtde,$strProdutoGrid);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_produto_item"=>$query[$i]["pk"]."-".$query[$i]['ds_produto']." ".$query[$i]['ds_n_serie']
                );
            }
        }
        else{
            $mysql_data = [];
        }	
        
        break;
    }
    case 'listarProdutoEstoque':{
        $entrada_estoque_pk = $_REQUEST['entrada_estoque_pk'];
        $resultado = "";
        $query = $produto_itendao->listar_por_entrada_estoque_pk($entrada_estoque_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_n_serie"=>$query[$i]['ds_n_serie'],
                    "qtde"=>$query[$i]['qtde'],
                    "vl_item"=>$query[$i]['vl_item'],
                    "entrada_estoque_pk"=>$query[$i]['entrada_estoque_pk'],
                    "produtos_pk"=>$query[$i]['produtos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }	
        
        break;
    }
    case 'listarProdutoEstoqueNSerie':{
        $entrada_estoque_pk = $_REQUEST['entrada_estoque_pk'];
        $resultado = "";
        $query = $produto_itendao->listar_por_entrada_estoque_pk_N_serie($entrada_estoque_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_n_serie"=>$query[$i]['ds_n_serie'],
                    "qtde"=>$query[$i]['qtde'],
                    "vl_item"=>$query[$i]['vl_item'],
                    "entrada_estoque_pk"=>$query[$i]['entrada_estoque_pk'],
                    "produtos_pk"=>$query[$i]['produtos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }	
        
        break;
    }
    case 'listarPorCompra':{
        $compras_pk = $_REQUEST['compras_pk'];
        $result  = 'success';
        $message = 'query success';
        if($compras_pk!=""){
            $resultado = "";
            $query = $produto_itendao->listarPorCompra($compras_pk);

            

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "ds_produto"=>$query[$i]['ds_produto'],
                        "ds_categoria"=>$query[$i]['ds_categoria'],
                        "produtos_pk"=>$query[$i]['produtos_pk'],
                        "ic_entrega"=>$query[$i]['ic_entrega'],
                        "ds_entrega"=>$query[$i]['ds_entrega'],
                        "entrada_estoque_pk"=>$query[$i]['entrada_estoque_pk'],
                        "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                        "vl_item"=>number_format($query[$i]['vl_item'],2,',','.'),
                        "qtde"=>$query[$i]['qtde']
                    );
                }
            }
            else{
                $mysql_data = [];
            }
        }
        else{
            $mysql_data = [];
        }
        	
        
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $produto_itendao->listar_por_ds_n_serie($ds_n_serie);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_n_serie"=>$query[$i]['ds_n_serie'],
                    "t_qtde"=>$query[$i]['qtde'],
                    "t_entrada_estoque_pk"=>$query[$i]['entrada_estoque_pk'],
                    "t_vl_item"=>$query[$i]['vl_item'],
                    "t_produtos_pk"=>$query[$i]['produtos_pk'],

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

$produto_itendao = null;

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
