<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/compras_solicitacao_orcamento_itens.dao.php";
require_once "../model/compras_solicitacao_orcamento_itens.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$categorias_produto_pk = $arrRequest['categorias_produto_pk'];
$produtos_pk = $arrRequest['produtos_pk'];
$ds_produto = $arrRequest['ds_produto'];
$qtde_produto = $arrRequest['qtde_produto'];
$vl_unitario = $arrRequest['vl_unitario'];
$compras_solicitacao_orcamentos_pk = $arrRequest['compras_solicitacao_orcamentos_pk'];

$compras_solicitacao_orcamento_itensdao = new compras_solicitacao_orcamento_itensdao();
$compras_solicitacao_orcamento_itensdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $compras_solicitacao_orcamento_itens = $compras_solicitacao_orcamento_itensdao->carregarPorPk($pk);
        if($compras_solicitacao_orcamento_itens->getpk()>0){
            
            $compras_solicitacao_orcamento_itensdao->excluir($compras_solicitacao_orcamento_itens);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'compras_solicitacao_orcamento_itens nao encontrado';
        }
        break;
    }
    case 'salvar':{

        $compras_solicitacao_orcamento_itens = $compras_solicitacao_orcamento_itensdao->carregarPorPk($pk);
        $compras_solicitacao_orcamento_itens->setcategorias_produto_pk($categorias_produto_pk);
        $compras_solicitacao_orcamento_itens->setprodutos_pk($produtos_pk);
        $compras_solicitacao_orcamento_itens->setds_produto($ds_produto);
        $compras_solicitacao_orcamento_itens->setqtde_produto($qtde_produto);
        $compras_solicitacao_orcamento_itens->setvl_unitario($vl_unitario);
        $compras_solicitacao_orcamento_itens->setcompras_solicitacao_orcamentos_pk($compras_solicitacao_orcamentos_pk);

        
        $pk = $compras_solicitacao_orcamento_itensdao->salvar($compras_solicitacao_orcamento_itens, $token);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    
    case 'excluirPorSolicitacaoOrcamento':{
        $compras_solicitacao_orcamentos_pk = $_REQUEST['compras_solicitacao_orcamentos_pk'];
        $resultdo = "";
        
            $compras_solicitacao_orcamento_itensdao->excluirPorSolicitacaoOrcamento($compras_solicitacao_orcamentos_pk);
            
            $result  = 'success';
     

        break;
    }
    
    
    case 'listarItensOrcamentoPk':{
        $compras_solicitacao_orcamentos_pk = $_REQUEST['compras_solicitacao_orcamentos_pk'];

        $resultado = "";
        if(!empty($compras_solicitacao_orcamentos_pk)){

            $query = $compras_solicitacao_orcamento_itensdao->listarItensOrcamentoPk($compras_solicitacao_orcamentos_pk);
            
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                        "ds_categoria"=>substr($query[$i]['ds_categoria'],0,15),
                        "produtos_pk"=>$query[$i]['produtos_pk'],
                        "ds_produto"=>substr($query[$i]['ds_produto'],0,15),
                        "ds_produto_itens"=>$query[$i]['ds_produto_itens'],
                        "qtde_produto"=>$query[$i]['qtde_produto'],
                        "vl_unitario"=>$query[$i]['vl_unitario'],
                        "compras_solicitacao_orcamentos_pk"=>$query[$i]['compras_solicitacao_orcamentos_pk']
                    );
                }
            }
            else{
                $mysql_data = [];
            }        
        }else{
            $mysql_data = [];
        } 			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }   
    
    
    case 'listarPk':{        
        $resultado = "";
        $query = $compras_solicitacao_orcamento_itensdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "produtos_pk"=>$query[$i]['produtos_pk'],
                    "qtde_produto"=>$query[$i]['qtde_produto'],
                    "vl_unitario"=>$query[$i]['vl_unitario'],
                    "compras_solicitacao_orcamentos_pk"=>$query[$i]['compras_solicitacao_orcamentos_pk']
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
        $query = $compras_solicitacao_orcamento_itensdao->listar_por_categorias_produto_pk($categorias_produto_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "produtos_pk"=>$query[$i]['produtos_pk'],
                    "qtde_produto"=>$query[$i]['qtde_produto'],
                    "vl_unitario"=>$query[$i]['vl_unitario'],
                    "compras_solicitacao_orcamentos_pk"=>$query[$i]['compras_solicitacao_orcamentos_pk']
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
        $query = $compras_solicitacao_orcamento_itensdao->listar_por_categorias_produto_pk($categorias_produto_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "t_produtos_pk"=>$query[$i]['produtos_pk'],
                    "t_qtde_produto"=>$query[$i]['qtde_produto'],
                    "t_vl_unitario"=>$query[$i]['vl_unitario'],
                    "t_compras_solicitacao_orcamentos_pk"=>$query[$i]['compras_solicitacao_orcamentos_pk'],

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

$compras_solicitacao_orcamento_itensdao = null;

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
