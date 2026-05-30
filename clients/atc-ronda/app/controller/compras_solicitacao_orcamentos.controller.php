<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/compras_solicitacao_orcamentos.dao.php";
require_once "../model/compras_solicitacao_orcamentos.class.php";
//require_once "../model/entrada_estoque.dao.php";
//require_once "../model/entrada_estoque.class.php";
$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$fornecedor_pk = $arrRequest['fornecedor_pk'];
$dt_pevisao_entrega = $arrRequest['dt_pevisao_entrega'];
$vl_frete = $arrRequest['vl_frete'];
$vl_total = $arrRequest['vl_total'];
$obs_orcamento = $arrRequest['obs_orcamento'];
$ic_status = $arrRequest['ic_status'];
$compra_solicitacao_pk = $arrRequest['compra_solicitacao_pk'];


$compras_solicitacao_orcamentosdao = new compras_solicitacao_orcamentosdao();
$compras_solicitacao_orcamentosdao->setToken($token); 

//$compradao = new compradao();
//$compradao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $compras_solicitacao_orcamentos = $compras_solicitacao_orcamentosdao->carregarPorPk($pk);
        if($compras_solicitacao_orcamentos->getpk()>0){
            
            $compras_solicitacao_orcamentosdao->excluir($compras_solicitacao_orcamentos);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'compras_solicitacao_orcamentos nao encontrado';
        }
        break;
    }
    case 'salvar':{     
  
        $compras_solicitacao_orcamentos = $compras_solicitacao_orcamentosdao->carregarPorPk($pk);
        $compras_solicitacao_orcamentos->setfornecedor_pk($fornecedor_pk);
        $compras_solicitacao_orcamentos->setdt_pevisao_entrega($dt_pevisao_entrega);
        $compras_solicitacao_orcamentos->setvl_frete($vl_frete);
        $compras_solicitacao_orcamentos->setvl_total($vl_total);
        $compras_solicitacao_orcamentos->setobs_orcamento($obs_orcamento);
        $compras_solicitacao_orcamentos->setic_status($ic_status);
        $compras_solicitacao_orcamentos->setcompra_solicitacao_pk($compra_solicitacao_pk);
        
        $pk = $compras_solicitacao_orcamentosdao->salvar($compras_solicitacao_orcamentos, $token);       
        $mysql_data[] = array(
            "pk" => $pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    
    case 'vinculaSolicitacaoOrcamento':{
        $compras_solicitacao_orcamentos_pk = $_REQUEST['compras_solicitacao_orcamentos_pk'];
        $compras_solicitacao_pk= $_REQUEST['compras_solicitacao_pk'];

        $pk = $compras_solicitacao_orcamentosdao->vinculaSolicitacaoOrcamento($compras_solicitacao_orcamentos_pk,$compras_solicitacao_pk);
        
        $mysql_data = [];
        
        $result  = 'success';
        $message = 'query success';
        
        break; 
    }
    
    case 'listarPk':{
        
        $resultado = "";
        $query = $compras_solicitacao_orcamentosdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "fornecedor_pk"=>$query[$i]['fornecedor_pk'],
                    "dt_pevisao_entrega"=>$query[$i]['dt_pevisao_entrega'],
                    "vl_frete"=>$query[$i]['vl_frete'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "obs_orcamento"=>$query[$i]['obs_orcamento'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "compra_solicitacao_pk"=>$query[$i]['compra_solicitacao_pk']
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
        $query = $compras_solicitacao_orcamentosdao->listar_por_fornecedor_pk($fornecedor_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "fornecedor_pk"=>$query[$i]['fornecedor_pk'],
                    "dt_pevisao_entrega"=>$query[$i]['dt_pevisao_entrega'],
                    "vl_frete"=>$query[$i]['vl_frete'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "obs_orcamento"=>$query[$i]['obs_orcamento'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "compra_solicitacao_pk"=>$query[$i]['compra_solicitacao_pk']
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
        if(!empty($compra_solicitacao_pk)){
       
            $query = $compras_solicitacao_orcamentosdao->listarDataTable($compra_solicitacao_pk);

            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){

                    $mysql_data[] = array(
                        "t_compras_solicitacao_orcamentos_pk" => $query[$i]["pk"],
                        "t_fornecedor_pk"=>$query[$i]['fornecedor_pk'],
                        "t_ds_fornecedor"=>$query[$i]['ds_fornecedor'],
                        "t_dt_pevisao_entrega"=>$query[$i]['dt_pevisao_entrega'],
                        "t_vl_frete"=>$query[$i]['vl_frete'],
                        "t_vl_total"=>$query[$i]['vl_total'],
                        "t_obs_orcamento"=>$query[$i]['obs_orcamento'],
                        "t_ic_status"=>$query[$i]['ic_status'],
                        "t_ds_status"=>$query[$i]['ds_status'],
                        "t_compra_solicitacao_pk"=>$query[$i]['compra_solicitacao_pk'],

                        "t_functions" => ""
                    );
                }
            }else{
                $mysql_data = [];
            }
        }else{
            $mysql_data = [];
        }	
        
        break;
    }
    case 'listarDadosImpressao':{
        $query = $compras_solicitacao_orcamentosdao->listarDadosImpressao($pk, $compra_solicitacao_pk);
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_compras_solicitacao_orcamentos_pk" => $query[$i]["pk"],
                    "t_ds_fornecedor"=>$query[$i]['ds_fornecedor'],
                    "t_dt_pevisao_entrega"=>$query[$i]['dt_pevisao_entrega'],
                    "t_vl_frete"=>$query[$i]['vl_frete'],
                    "t_vl_total"=>$query[$i]['vl_total'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_ds_compra_solicitacao"=>$query[$i]['ds_compra_solicitacao'],
                    "t_dt_solicitacao"=>$query[$i]['dt_solicitacao'],
                    "t_ds_empresa"=>$query[$i]['ds_empresa'],
                    "t_ds_solicitante"=>$query[$i]['ds_solicitante'],
                    "t_vl_unitario"=>$query[$i]['vl_unitario'],
                    "t_qtde_produto"=>$query[$i]['qtde_produto'],
                    "t_ds_produto"=>$query[$i]['ds_produto'],
                    "t_ds_categoria_produto"=>$query[$i]['ds_categoria_produto'],
                    "t_ds_grupo_lancamento_centrocusto"=>$query[$i]['ds_grupo_lancamento_centrocusto'],
                    "t_ds_tipo_grupo_centro_custo"=>$query[$i]['ds_tipo_grupo_centro_custo'],

                    "t_functions" => ""
                );
            }
        }else{
            $mysql_data = [];
        }
        break;
    }
    default:{
        break;
    }
}

$compras_solicitacao_orcamentosdao = null;

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
