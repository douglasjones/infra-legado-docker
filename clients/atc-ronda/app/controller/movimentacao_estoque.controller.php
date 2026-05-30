<?
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/movimentacao_estoque.dao.php";
require_once "../model/movimentacao_estoque.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$leads_pk = $arrRequest['leads_pk'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$produtos_itens_pk = $arrRequest['produtos_itens_pk'];
$qtde = $arrRequest['qtde'];
$dt_entrega = $arrRequest['dt_entrega'];
$dt_devolucao = $arrRequest['dt_devolucao'];
$obs_movimentacao = $arrRequest['obs_material'];
$conjunto_material_pk = $arrRequest['conjunto_material_pk'];
$ic_mateiral_carga = $arrRequest['ic_mateiral_carga'];
$polos_origem_pk = $arrRequest['polos_origem_pk'];
$polos_destino_pk = $arrRequest['polos_destino_pk'];
$contratos_pk = $arrRequest['contratos_pk'];

$movimentacao_estoquedao = new movimentacao_estoquedao();
$movimentacao_estoquedao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){
    
    case 'excluir':{        
        $resultdo = "";        
        $movimentacao_estoque = $movimentacao_estoquedao->carregarPorPk($pk);
        
        $log_exclusaodao->salvar("movimentacao_estoque",$movimentacao_estoque->getpk());
        
        if($movimentacao_estoque->getpk()>0){  
            
            
            $movimentacao_estoquedao->excluir($movimentacao_estoque);            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';
        }else{
            $result  = 'error';
            $message = 'movimentacao_estoque nao encontrado';
        }
        break;
    }
    
    case 'salvar':{   
        
        
        
        
        
        
        $movimentacao_estoque = $movimentacao_estoquedao->carregarPorPk($pk);
        $movimentacao_estoque->setleads_pk($leads_pk);
        $movimentacao_estoque->setcolaborador_pk($colaborador_pk);
        $movimentacao_estoque->setprodutos_itens_pk($produtos_itens_pk);
        $movimentacao_estoque->setqtde($qtde);
        $movimentacao_estoque->setpolos_origem_pk($polos_origem_pk);
        $movimentacao_estoque->setpolos_destino_pk($polos_destino_pk);
        $movimentacao_estoque->setdt_entrega(DataYMD($dt_entrega));
        if($dt_devolucao!=""){
            $movimentacao_estoque->setdt_devolucao(DataYMD($dt_devolucao));
        }
        
        $movimentacao_estoque->setobs_movimentacao($obs_movimentacao);
        $movimentacao_estoque->setconjunto_material_pk($conjunto_material_pk);
        $movimentacao_estoque->setic_mateiral_carga($ic_mateiral_carga);
        $movimentacao_estoque->setcontratos_pk($contratos_pk);

        $pk = $movimentacao_estoquedao->salvar($movimentacao_estoque);
        
        $mysql_data[] = array(
                "pk" => $pk
        );        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';                
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $movimentacao_estoquedao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "produtos_itens_pk"=>$query[$i]['produtos_itens_pk'],
                    "qtde"=>$query[$i]['qtde'],
                    "ic_mateiral_carga"=>$query[$i]['ic_mateiral_carga'],
                    "obs_movimentacao"=>$query[$i]['obs_movimentacao']
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
    
     case 'listarMovimentacoes':{
        
        $catetoria_pk = $_REQUEST['categorias_produto_pk']; 
        $dt_ini = $_REQUEST['dt_ini'];
        $dt_fim = $_REQUEST['dt_fim'];
        
        $resultado = "";
        $query = $movimentacao_estoquedao->listarMovimentacoes($leads_pk,$catetoria_pk,$produtos_pk,$dt_ini,$dt_fim);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ic_mateiral_carga"=>$query[$i]['ic_mateiral_carga'],
                    "t_ds_usuario"=>$query[$i]['ds_usuario'],
                    "t_dt_entrega"=>$query[$i]['dt_entrega']            
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
    
    case 'listar_por_pk':{
        $conjunto_material_pk  = $_REQUEST['conjunto_material_pk'];
        $resultado = "";
        $query = $movimentacao_estoquedao->listar_por_pk($leads_pk,$colaborador_pk,$conjunto_material_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "produtos_itens_pk"=>$query[$i]['produtos_itens_pk'],
                    "qtde"=>$query[$i]['qtde'],
                    "ic_mateiral_carga"=>$query[$i]['ic_mateiral_carga'],
                    "ds_ic_mateiral_carga"=>$query[$i]['ds_ic_mateiral_carga'],
                    "obs_material"=>$query[$i]['obs_material'],
                    "ds_produtos"=>$query[$i]['ds_produto'],
                    "ds_categorias_produto"=>$query[$i]['ds_categorias_produto'],
                    "dt_entrega"=>$query[$i]['dt_entrega'],
                    "dt_devolucao"=>$query[$i]['dt_devolucao'],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "produtos_pk"=>$query[$i]['produtos_pk'],                    
                    "ds_produtos_itens"=>$query[$i]['produtos_itens_pk']." - ".$query[$i]['ds_produto']." ".$query[$i]['ds_n_serie']                    
                );
            }
        }
        else{
            $mysql_data = [];
        }
        break;
    }
    case 'listarEstoqueBaixa':{
        $leads_pk  = $_REQUEST['leads_pk'];
        $categorias_pk  = $_REQUEST['categorias_pk'];
        $produtos_pk  = $_REQUEST['produtos_pk'];
        $dt_inicio  = $_REQUEST['dt_inicio'];
        $dt_fim  = $_REQUEST['dt_fim'];
        $ic_status  = $_REQUEST['ic_status'];
        
        
        $resultado = "";
        $query = $movimentacao_estoquedao->listarEstoqueBaixa($leads_pk,$categorias_pk,$produtos_pk,$dt_inicio,$dt_fim,$ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_categoria"=>$query[$i]['ds_categorias_produto'],                  
                    "dt_entrega"=>$query[$i]['dt_entrega'],                  
                    "dt_devolucao"=>$query[$i]['dt_devolucao'],                  
                    "dt_baixa"=>$query[$i]['dt_baixa'],                  
                    "ic_mateiral_carga"=>$query[$i]['ic_mateiral_carga'],                  
                    "obs_baixa"=>$query[$i]['obs_baixa'],                  
                    "ds_produtos_itens_grid"=>substr($query[$i]['ds_produto'], 0, 15),                    
                    "ds_produtos_itens"=>$query[$i]['ds_produto']." ".$query[$i]['ds_n_serie']                    
                );
            }
        }
        else{
            $mysql_data = [];
        }
        break;
    }
    case 'listar_por_pk_conjunto':{
        $conjunto_material_pk  = $_REQUEST['conjunto_material_pk'];
        $contratos_pk  = $_REQUEST['contratos_pk'];
        $resultado = "";
        $result  = 'success';
        $message = 'query success';
        if($conjunto_material_pk!=""){
            $query = $movimentacao_estoquedao->listar_por_pk($leads_pk,$colaborador_pk,$conjunto_material_pk,$contratos_pk);
        
           

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $ic_mateiral_carga = "";
                    $ds_mateiral_carga = "";
                    if($query[$i]['ic_mateiral_carga']==""){
                        $ic_mateiral_carga = "2";
                        $ds_mateiral_carga = "Não";
                    }
                    else{
                        $ic_mateiral_carga = $query[$i]['ic_mateiral_carga'];
                        $ds_mateiral_carga = $query[$i]['ds_ic_mateiral_carga'];
                    }
                    
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "leads_pk"=>$query[$i]['leads_pk'],
                        "colaborador_pk"=>$query[$i]['colaborador_pk'],
                        "produtos_itens_pk"=>$query[$i]['produtos_itens_pk'],
                        "qtde"=>$query[$i]['qtde'],
                        "ic_mateiral_carga"=>$ic_mateiral_carga,
                        "ds_ic_mateiral_carga"=>$ds_mateiral_carga,
                        "obs_material"=>$query[$i]['obs_material'],
                        "ds_produtos"=>$query[$i]['ds_produto'],
                        "ds_categorias_produto"=>$query[$i]['ds_categorias_produto'],
                        "dt_entrega"=>$query[$i]['dt_entrega'],
                        "dt_devolucao"=>$query[$i]['dt_devolucao'],
                        "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                        "produtos_pk"=>$query[$i]['produtos_pk'],                    
                        "ds_produtos_itens"=>$query[$i]['produtos_itens_pk']." - ".$query[$i]['ds_produto']." ".$query[$i]['ds_n_serie']                 
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
    case 'listar_impressao':{
        $conjunto_material_pk  = $_REQUEST['conjunto_material_pk'];
        $resultado = "";
        if($conjunto_material_pk!=""){
            $query = $movimentacao_estoquedao->listar_impressao($leads_pk,$colaborador_pk,$conjunto_material_pk);
        
            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "qtde"=>$query[$i]['qtde'],
                        "ds_tamanho"=>"",
                        "ds_cor"=>"",
                        "assinatura"=>"",
                        "obs_material"=>$query[$i]['obs_material'],
                        "dt_entrega"=>$query[$i]['dt_entrega'],
                        "ic_mateiral_carga"=>$query[$i]['ic_mateiral_carga'],
                        "dt_devolucao"=>$query[$i]['dt_devolucao'],
                        "ds_produtos"=>$query[$i]['produtos_itens_pk']." - ".$query[$i]['ds_produto'],                   
                        "n_serie"=>$query[$i]['ds_n_serie']                    
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
        $query = $movimentacao_estoquedao->listar_por_leads_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_produtos_itens_pk"=>$query[$i]['produtos_itens_pk'],
                    "t_qtde"=>$query[$i]['qtde'],
                    "t_obs_movimentacao"=>$query[$i]['obs_movimentacao'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'RelatorioEstoqueCarga':{
        $dt_ini = $_REQUEST['dt_movimentacao_ini'];
        $dt_fim = $_REQUEST['dt_movimentacao_fim'];
        $leads_pk = $_REQUEST['leads_pk'];
        $categorias_pk = $_REQUEST['categorias_pk'];
        $produtos_pk = $_REQUEST['produtos_pk'];
        
        $resultado = "";
        $query = $movimentacao_estoquedao->RelatorioEstoqueCarga($leads_pk,$categorias_pk,$produtos_pk,$dt_ini,$dt_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "dt_cadastro" => $query[$i]["dt_cadastro"],
                    "ds_produto"=>$query[$i]['ds_produto'],
                    "ds_categoria"=>$query[$i]['ds_categoria'],
                    "ds_lead"=>$query[$i]['ds_lead'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'RelatorioEstoqueCargaSintetico':{
        $dt_ini = $_REQUEST['dt_movimentacao_ini'];
        $dt_fim = $_REQUEST['dt_movimentacao_fim'];
        $leads_pk = $_REQUEST['leads_pk'];
        $categorias_pk = $_REQUEST['categorias_pk'];
        $produtos_pk = $_REQUEST['produtos_pk'];
        
        $resultado = "";
        $query = $movimentacao_estoquedao->RelatorioEstoqueCargaSintetico($leads_pk,$categorias_pk,$produtos_pk,$dt_ini,$dt_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "qtde" => $query[$i]["qtde"],
                    "ds_produto"=>$query[$i]['ds_produto'],
                    "ds_categoria"=>$query[$i]['ds_categoria'],
                    "ds_lead"=>$query[$i]['ds_lead'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'RelatorioEstoqueMinimo':{
        $categorias_pk = $_REQUEST['categorias_pk'];
        $produtos_pk = $_REQUEST['produtos_pk'];
        
        $resultado = "";
        $query = $movimentacao_estoquedao->RelatorioEstoqueMinimo($categorias_pk,$produtos_pk,$leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                     $qtde_movimentado = "";           
                     
                      $query1 = $movimentacao_estoquedao->RelatorioEstoqueAtual($categorias_pk,$query[$i]["produtos_pk"],$query[$i]["pk"]);

                    if(count($query1) > 0){
                        
                        for($j = 0; $j < count($query1); $j++){
                            $mysql_data1[] = array(
                                $qtde_movimentado = $query1[$j]["qtde_movimentado"],                
                            );                            
                        }
                    }                     
                                      
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "dt_cad_estoque"=>$query[$i]['dt_cadastro_estoque'],
                    "qtde_movimentado"=>$qtde_movimentado,
                    "qtde_inicial"=>$query[$i]['qtde_inicial'],
                    "qtde_minima"=>$query[$i]['qtde_minima'],
                    "ds_produto"=>$query[$i]['ds_produto'],
                    "ds_categoria"=>$query[$i]['ds_categoria'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'RelatorioEstoqueAtual':{
        $categorias_pk = $_REQUEST['categorias_pk'];
        $produtos_pk = $_REQUEST['produtos_pk'];
        
        $resultado = "";
        $query = $movimentacao_estoquedao->RelatorioEstoqueMinimo($categorias_pk,$produtos_pk, '');
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
               
                     $qtde_movimentado = "";                          
                    $query1 = $movimentacao_estoquedao->RelatorioEstoqueAtual($categorias_pk,$query[$i]["produtos_pk"],$query[$i]["pk"]);

                    if(count($query1) > 0){
                        
                        for($j = 0; $j < count($query1); $j++){
                            $mysql_data1[] = array(
                                $qtde_movimentado = $query1[$j]["qtde_movimentado"],                
                            );                            
                        }
                    }                     
                                      
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "dt_cad_estoque"=>$query[$i]['dt_cadastro_estoque'],
                    "qtde_movimentado"=>$qtde_movimentado,
                    "qtde_inicial"=>$query[$i]['qtde_inicial'],
                    "qtde_minima"=>$query[$i]['qtde_minima'],
                    "ds_produto"=>$query[$i]['ds_produto'],
                    "ds_categoria"=>$query[$i]['ds_categoria'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;	
     
    }   
    case 'RelatorioEstoque':{
        $categorias_pk = $_REQUEST['categorias_pk'];
        $produtos_pk = $_REQUEST['produtos_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        $query = $movimentacao_estoquedao->RelatorioEstoqueMinimoAtual($categorias_pk,$produtos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
               
                    $qtde_movimentado = "";                          
                    $query1 = $movimentacao_estoquedao->RelatorioEstoque($categorias_pk,$query[$i]["produtos_pk"],$query[$i]["pk"],$leads_pk);

                    if(count($query1) > 0){
                        
                        for($j = 0; $j < count($query1); $j++){
                            $mysql_data1[] = array(
                                $qtde_movimentado = $query1[$j]["qtde_movimentado"],                
                            );                            
                        }
                    }                     
                                      
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "dt_cad_estoque"=>$query[$i]['dt_cadastro_estoque'],
                    "qtde_movimentado"=>$qtde_movimentado,
                    "qtde_inicial"=>$query[$i]['qtde_inicial'],
                    "qtde_minima"=>$query[$i]['qtde_minima'],
                    "ds_produto"=>$query[$i]['ds_produto'],
                    "ds_categoria"=>$query[$i]['ds_categoria'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;	
     
    }   
    case 'relatorioMovimentacaoEstoqueTroca':{
        $leads_pk =  $_REQUEST['leads_pk'];
        $colaboradores_pk =  $_REQUEST['colaboradores_pk'];
        $produtos_pk =  $_REQUEST['produtos_pk'];
        $categorias_pk = $_REQUEST['categorias_pk'];
        $dt_troca_ini = $_REQUEST['dt_troca_ini'];
        $dt_troca_fim = $_REQUEST['dt_troca_fim'];
        
        $resultado = "";
        $query = $movimentacao_estoquedao->relatorioMovimentacaoEstoqueTroca($leads_pk,$colaboradores_pk,$produtos_pk,$categorias_pk,$dt_troca_ini,$dt_troca_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                //$queryDtTroca = $movimentacao_estoquedao->calcularDataTroca($query[$i]['ic_tempo_troca'],$query[$i]['dt_entrega']);
               
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_categorias_produto"=>$query[$i]['ds_categorias_produto'],
                    "t_ds_produto"=>$query[$i]['ds_produto'],
                    "t_ds_tempo_troca"=>$query[$i]['ic_tempo_troca']." - Meses",
                    "t_dt_movimentacao"=>$query[$i]['dt_entrega'],
                    //"t_dt_troca"=>$queryDtTroca[0]['dt_troca'],
                    //"t_dt_troca_usa"=>$queryDtTroca[0]['dt_troca_usa'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }  
    case 'relatorioMovimentacaoEstoqueProduto':{
        $leads_pk =  $_REQUEST['leads_pk'];
        $dt_troca_ini = $_REQUEST['dt_troca_ini'];
        $dt_troca_fim = $_REQUEST['dt_troca_fim'];
        
        $resultado = "";
        $query = $movimentacao_estoquedao->relatorioMovimentacaoEstoqueProduto($leads_pk,$dt_troca_ini,$dt_troca_fim);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                //$queryDtTroca = $movimentacao_estoquedao->calcularDataTroca($query[$i]['ic_tempo_troca'],$query[$i]['dt_entrega']);
                $vl_total_item = $query[$i]['vl_item'] * $query[$i]['qtde'];

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_categorias_produto"=>$query[$i]['ds_categorias_produto'],
                    "t_ds_produto"=>$query[$i]['ds_produto'],
                    "t_ds_tempo_troca"=>$query[$i]['ic_tempo_troca']." - Meses",
                    "t_dt_movimentacao"=>$query[$i]['dt_entrega'],
                    //"t_dt_troca"=>$queryDtTroca[0]['dt_troca'],
                    //"t_dt_troca_usa"=>$queryDtTroca[0]['dt_troca_usa'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_qtde"=>$query[$i]['qtde'],
                    "t_vl_item"=>$query[$i]['vl_item'],
                    "vl_total_item" => $vl_total_item,
                    "t_tipo_unidade_pk"=>$query[$i]['tipo_unidade_pk'],
                    "t_dt_entrada" => $query[$i]['dt_cadastro'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'relatorioMovimentacaoEstoqueCustoMedio':{
        $produtos_pk =  $_REQUEST['produtos_pk'];
        $dt_troca_ini = $_REQUEST['dt_troca_ini'];
        $dt_troca_fim = $_REQUEST['dt_troca_fim'];
        
        $resultado = "";
        $query = $movimentacao_estoquedao->relatorioMovimentacaoEstoqueCustoMedio($produtos_pk,$dt_troca_ini,$dt_troca_fim);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                //$queryDtTroca = $movimentacao_estoquedao->calcularDataTroca($query[$i]['ic_tempo_troca'],$query[$i]['dt_entrega']);
                $vl_total_item_saida = $query[$i]['vl_item'] * $query[$i]['qtde'];
                $vl_total_item_entrada = $query[$i]['vl_unitario'] * $query[$i]['qtde_inicial'];
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_produto"=>$query[$i]['ds_produto'],
                    "t_dt_movimentacao"=>$query[$i]['dt_entrega'],
                    //"t_ds_lead"=>$query[$i]['ds_lead'],
                    //"t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_qtde_inicial"=>$query[$i]['qtde_inicial'], 
                    "t_qtde"=>$query[$i]['qtde'],
                    "t_ds_n_serie"=>$query[$i]['ds_n_serie'],
                    "t_vl_item"=>$query[$i]['vl_item'],
                    "t_vl_total_item_saida" => $vl_total_item_saida,
                    "t_ds_tipo_unidade"=>$query[$i]['ds_tipo_unidade'],
                    "t_vl_unitario" => $query[$i]['vl_unitario'],
                    "t_vl_total_item_entrada" => $vl_total_item_entrada,

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

$movimentacao_estoquedao = null;

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
