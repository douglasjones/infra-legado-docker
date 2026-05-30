<?
ini_set('max_execution_time', '36000');
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/compra.dao.php";
require_once "../model/compra.class.php";

require_once "../model/produto_iten.dao.php";
require_once "../model/produto_iten.class.php";

require_once "../model/lancamento.dao.php";
require_once "../model/lancamento.class.php";

require_once "../model/documento.dao.php";
require_once "../model/documento.class.php";

require_once "../model/entrada_estoque.dao.php";
require_once "../model/entrada_estoque.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$fornecedor_pk = $arrRequest['fornecedor_pk'];
$categoria_pk = $arrRequest['categoria_pk'];
$conta_pk = $arrRequest['conta_pk'];
$dt_pagamento = $arrRequest['dt_pagamento'];
$vl_pagamento = $arrRequest['vl_notafiscal'] + $arrRequest['vl_frete'];
$metodos_pagamento_pk = $arrRequest['metodos_pagamento_pk'];
$qtde_parcelas = $arrRequest['qtde_parcelas'];
$ds_numero_nota = $arrRequest['ds_numero_nota'];
$ds_link_notafiscal = $arrRequest['ds_link_notafiscal'];
$dt_notafiscal = $arrRequest['dt_notafiscal'];
$vl_notafiscal = $arrRequest['vl_notafiscal'];
$vl_frete = $arrRequest['vl_frete'];
$dt_entrega = $arrRequest['dt_entrega'];
$ic_entregue = $arrRequest['ic_entregue'];
$obs = $arrRequest['obs'];
$grupo_lancamento_centro_custo_pk = $arrRequest['grupo_lancamento_centro_custo_pk'];
$centro_custo_pk = $arrRequest['centro_custo_pk'];
$documentos_pk = $arrRequest['documentos_pk'];
$produtos_itens_pk = $arrRequest['produtos_itens_pk'];
$ic_status = $arrRequest['ic_status'];


$compradao = new compradao();
$compradao->setToken($token);

$produto_itendao = new produto_itendao();
$produto_itendao->setToken($token); 

$lancamentodao = new lancamentodao();
$lancamentodao->setToken($token); 

$documentodao = new documentodao();
$documentodao->setToken($token); 

$entrada_estoquedao = new entrada_estoquedao();
$entrada_estoquedao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $compra = $compradao->carregarPorPk($pk);
        if($compra->getpk()>0){
            
            $compradao->excluir($compra);
            $compradao->excluirProdutoItem($compra->getpk());
            $compradao->excluirDocs($compra->getpk());
            $compradao->excluirLancamentos($compra->getpk());
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'compra nao encontrado';
        }
        break;
    }
    case 'salvar':{
        $compra = $compradao->carregarPorPk($pk);
        $compra->setfornecedor_pk($fornecedor_pk);
        $compra->setcategoria_pk($categoria_pk);
        $compra->setconta_pk($conta_pk);
        $compra->setdt_pagamento($dt_pagamento);
        $compra->setvl_pagamento($vl_notafiscal + $vl_frete);
        $compra->setmetodos_pagamento_pk($metodos_pagamento_pk);
        $compra->setqtde_parcelas($qtde_parcelas);
        $compra->setds_numero_nota($ds_numero_nota);
        $compra->setds_link_notafiscal($ds_link_notafiscal);
        $compra->setdt_notafiscal($dt_notafiscal);
        $compra->setvl_notafiscal($vl_notafiscal);
       
        $compra->setvl_frete($vl_frete);
        $compra->setdt_entrega($dt_entrega);
        $compra->setic_entregue($ic_entregue);
        $compra->setobs($obs);
        $compra->setgrupo_lancamento_centro_custo_pk($grupo_lancamento_centro_custo_pk);
        $compra->setcentro_custo_pk($centro_custo_pk);
        $compra->setcompra_solicitacao_pk($compra_solicitacao_pk);
        $compra->setic_status($ic_status);
        
        $pk = $compradao->salvar($compra, $documentos_pk, $produtos_itens_pk, $token);
        
        $mysql_data[] = array(
            "pk" => $pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'salvarProduto':{
        
        $pk = $_REQUEST['pk'];
        $compras_pk = $_REQUEST['compras_pk'];
        $produtos_pk = $_REQUEST['produtos_pk'];
        $qtde = $_REQUEST['qtde'];
        $vl_item = $_REQUEST['vl_item'];
        $ic_entrega = $_REQUEST['ic_entrega'];
        $ic_status = $_REQUEST['ic_status'];
        
        $pk = $compradao->salvarProduto($pk, $compras_pk, $produtos_pk, $qtde, $vl_item, $ic_entrega, $ic_status, $token);

        $mysql_data[] = array(
            "pk" => $pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    
    case 'listarPk':{
        
        $resultado = "";
        $query = $compradao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "fornecedor_pk"=>$query[$i]['fornecedor_pk'],
                    "categoria_pk"=>$query[$i]['categoria_pk'],
                    "conta_pk"=>$query[$i]['conta_pk'],
                    "dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "vl_pagamento"=>number_format($query[$i]['vl_pagamento'] , 2, ',', '.'),
                    "metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "qtde_parcelas"=>$query[$i]['qtde_parcelas'],
                    "ds_numero_nota"=>$query[$i]['ds_numero_nota'],
                    "ds_link_notafiscal"=>$query[$i]['ds_link_notafiscal'],
                    "dt_notafiscal"=>$query[$i]['dt_notafiscal'],
                    "vl_notafiscal"=>number_format($query[$i]['vl_notafiscal'] , 2, ',', '.'),
                    "vl_frete"=>number_format($query[$i]['vl_frete'] , 2, ',', '.'),
                    "dt_entrega"=>$query[$i]['dt_entrega'],
                    "ic_entregue"=>$query[$i]['ic_entregue'],
                    "obs"=>$query[$i]['obs'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "centro_custo_pk"=>$query[$i]['centro_custo_pk']
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
        $query = $compradao->listar_por_fornecedor_pk("","","","","","");
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "fornecedor_pk"=>$query[$i]['fornecedor_pk'],
                    "categoria_pk"=>$query[$i]['categoria_pk'],
                    "conta_pk"=>$query[$i]['conta_pk'],
                    "dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "vl_pagamento"=>$query[$i]['vl_pagamento'],
                    "metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "qtde_parcelas"=>$query[$i]['qtde_parcelas'],
                    "ds_numero_notads_link_notafiscal"=>$query[$i]['ds_numero_notads_link_notafiscal'],
                    "dt_notafiscal"=>$query[$i]['dt_notafiscal'],
                    "vl_notafiscal"=>$query[$i]['vl_notafiscal'],
                    "vl_frete"=>$query[$i]['vl_frete'],
                    "dt_entrega"=>$query[$i]['dt_entrega'],
                    "ic_entregue"=>$query[$i]['ic_entregue'],
                    "obs"=>$query[$i]['obs'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "centro_custo_pk"=>$query[$i]['centro_custo_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        
        
        $fornecedor_pk = $_REQUEST['fornecedor_pk'];
        $categorias_pk = $_REQUEST['categorias_pk'];
        $ds_numero_nota = $_REQUEST['ds_numero_nota'];
        $empresas_pk = $_REQUEST['contas_pk'];
        $dt_cadastro_ini = $_REQUEST['dt_cadastro_ini'];
        $dt_cadastro_fim = $_REQUEST['dt_cadastro_fim'];
        
        
        $resultado = "";
        $query = $compradao->listar_por_fornecedor_pk($fornecedor_pk,$categorias_pk,$ds_numero_nota,$empresas_pk,$dt_cadastro_ini,$dt_cadastro_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                
                
                
            $ds_fornecedor = remover_acentos($query[$i]['ds_fornecedor']);
            $ds_conta = remover_acentos($query[$i]['ds_conta']);
                
                
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_fornecedor"=>substr($ds_fornecedor,0,25),
                    "ds_categoria"=>$query[$i]['ds_categoria'],
                    "ds_numero_nota"=>$query[$i]['ds_numero_nota'],
                    "ds_conta"=>substr($ds_conta,0,25),
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "vl_pagamento"=>$query[$i]['vl_pagamento'],
                    "fornecedor_pk"=>$query[$i]['fornecedor_pk'],
                    "categoria_pk"=>$query[$i]['categoria_pk'],
                    "conta_pk"=>$query[$i]['conta_pk'],
                    "dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "vl_pagamento"=>$query[$i]['vl_pagamento'],
                    "metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "qtde_parcelas"=>$query[$i]['qtde_parcelas'],
                    "ds_link_notafiscal"=>$query[$i]['ds_link_notafiscal'],
                    "ds_numero_nota"=>$query[$i]['ds_numero_nota'],
                    "dt_notafiscal"=>$query[$i]['dt_notafiscal'],
                    "vl_notafiscal"=>$query[$i]['vl_notafiscal'],
                    "vl_frete"=>$query[$i]['vl_frete'],
                    "dt_entrega"=>$query[$i]['dt_entrega'],
                    "ic_entregue"=>$query[$i]['ic_entregue'],
                    "obs"=>$query[$i]['obs'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['centro_custo_pk'],
                    "centro_custo_pk"=>$query[$i]['centro_custo_pk'],

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

$compradao = null;

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
