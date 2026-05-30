<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/proposta.dao.php";
include_once "../model/proposta.class.php";

include_once "../model/proposta_item.dao.php";
include_once "../model/proposta_item.class.php";

include_once "../model/processo.dao.php";
include_once "../model/processo.class.php";

include_once "../model/processo_default_etapa.dao.php";
include_once "../model/processo_default_etapa.class.php";

include_once "../model/ocorrencia.dao.php";
include_once "../model/ocorrencia.class.php";

include_once "../model/tipo_ocorrencia.dao.php";
include_once "../model/tipo_ocorrencia.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$n_versao = $arrRequest['n_versao'];
$responsavel_pk = $arrRequest['responsavel_pk'];
$vl_total = $arrRequest['vl_total'];
$ds_obs = $arrRequest['ds_obs'];
$dt_validade = $arrRequest['dt_validade'];
$dt_envio = $arrRequest['dt_envio'];
$dt_previsao_fechamento = $arrRequest['dt_previsao_fechamento'];
$dt_fechamento = $arrRequest['dt_fechamento'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$ds_obs_motivo_cancelamento = $arrRequest['ds_obs_motivo_cancelamento'];
$processos_etapas_pk = $arrRequest['processos_etapas_pk'];
$agendas_pk = $arrRequest['agendas_pk'];
$leads_pk = $arrRequest['leads_pk'];
$processos_pk = $arrRequest['processos_pk'];
$ds_processo_etapas = $arrRequest['ds_processo_etapas'];
$categorias_produto_pk = $arrRequest['categorias_produto_pk'];
$produtos_pk = $arrRequest['produtos_pk'];
$n_qtde_item = $arrRequest['n_qtde_item'];
$vl_item_produto = $arrRequest['vl_item_produto'];
$produtosItensinfo = $arrRequest['produtosItensinfo'];
$proposta_itens = $arrRequest['proposta_itens'];
$vl_total_materiais = $arrRequest['vl_total_materiais'];

$propostadao = new propostadao();
$propostadao->setToken($token); 

$proposta_itemdao = new proposta_itemdao();
$proposta_itemdao->setToken($token); 

$processodao = new processodao();
$processodao->setToken($token);

$processo_default_etapadao = new processo_default_etapadao();
$processo_default_etapadao->setToken($token);

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token);

$tipo_ocorrenciadao = new tipo_ocorrenciadao();
$tipo_ocorrenciadao->setToken($token);

switch($job){
    case 'excluir':{
        
        $resultdo = "";
        
        $proposta = $propostadao->carregarPorPk($pk);
        if($proposta->getpk()>0){
            
            $propostadao->excluir($proposta);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'proposta nao encontrado';
        }
        break;
    }

    case 'salvar':{
        if($proposta_itens != "")                     
            $arrPropostaItens = json_decode($proposta_itens, true);

        if($produtosItensinfo != "")  
            $arrprodutosItensinfo = json_decode($produtosItensinfo, true);

        $proposta = $propostadao->carregarPorPk($pk);
        $proposta->setn_versao($n_versao);
        $proposta->setresponsavel_pk($responsavel_pk);
        $proposta->setvl_total($vl_total);
        $proposta->setvl_total_materiais($vl_total_materiais);
        $proposta->setds_obs($ds_obs);        
        $proposta->setdt_validade(DataYMD($dt_validade));
        $proposta->setdt_fechamento($dt_fechamento);
        $proposta->setdt_cancelamento($dt_cancelamento);
        $proposta->setds_obs_motivo_cancelamento($ds_obs_motivo_cancelamento);
        $proposta->setprocessos_etapas_pk($processos_etapas_pk);
        $proposta->setagendas_pk($agendas_pk);
        $proposta->setleads_pk($leads_pk);
        if(!empty($dt_envio)){
            $proposta->setdt_envio(DataYMD($dt_envio));
        }
        if(!empty($dt_previsao_fechamento)){
            $proposta->setdt_previsao_fechamento(DataYMD($dt_previsao_fechamento));
        }   

        $pk = $propostadao->salvar($proposta, $arrPropostaItens, $arrprodutosItensinfo);
       
        $mysql_data[] = array(
            "pk" => $propostas_pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';     
        break;
    }

    case 'listarPk':{
        
        $resultado = "";
        $query = $propostadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "n_versao"=>$query[$i]['n_versao'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "dt_validade"=>$query[$i]['dt_validade'],
                    "dt_envio"=>$query[$i]['dt_envio'],
                    "dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    //"operador_pk"=>$query[$i]['operador_pk'],
                    "agendas_pk"=>$query[$i]['agendas_pk']
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
        $query = $propostadao->listar_por_dt_inicio();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "n_versao"=>$query[$i]['n_versao'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "dt_validade"=>$query[$i]['dt_validade'],
                    "dt_envio"=>$query[$i]['dt_envio'],
                    "dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    //"operador_pk"=>$query[$i]['operador_pks'],
                    "agendas_pk"=>$query[$i]['agendas_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'relatorioFunilVendas':{
        
  
        $leads_pk = $_REQUEST['leads_pk'];
        $responsavel_pk = $_REQUEST['responsavel_pk'];
        $dt_envio_ini = $_REQUEST['dt_envio_ini'];
        $dt_envio_fim = $_REQUEST['dt_envio_fim'];
        $dt_prev_fechamento_ini = $_REQUEST['dt_prev_fechamento_ini'];
        $dt_prev_fechamento_fim = $_REQUEST['dt_prev_fechamento_fim'];
        $dt_fechamento_ini = $_REQUEST['dt_fechamento_ini'];
        $dt_fechamento_fim = $_REQUEST['dt_fechamento_fim'];
        $grupos_pk = $_REQUEST['grupos_pk'];
        $resultado = "";
        $query = $propostadao->listar_rel_funil_vendas($leads_pk,$responsavel_pk,$dt_envio_ini,$dt_envio_fim,$dt_prev_fechamento_ini,$dt_prev_fechamento_fim,$dt_fechamento_ini,$dt_fechamento_fim,$grupos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($query[$i]["ds_lead"]!=null){
                    $mysql_data[] = array(
                        "t_ds_lead"=> $query[$i]["ds_lead"],
                        "t_processos_pk"=> $query[$i]["processos_pk"],
                        "t_classificacao_processo_pk"=> $query[$i]["classificacao_processo_pk"],
                        "t_ds_classficacao_processo"=> $query[$i]["ds_classficacao_processo"],
                        "t_ds_responsavel"=> $query[$i]["ds_responsavel"],
                        "t_n_qtde"=> $query[$i]["n_qtde"],
                        "t_vl_total"=> $query[$i]["vl_total"],
                        "t_dt_envio"=> $query[$i]["dt_envio"],
                        "t_dt_cancelamento"=> $query[$i]["dt_cancelamento"],
                        "t_dt_fechamento"=> $query[$i]["dt_fechamento"],
                        "t_dt_previsao_fechamento"=> $query[$i]["dt_previsao_fechamento"],
                        "t_dt_validade"=> $query[$i]["dt_validade"],
                        //"t_operador_pk"=> $query[$i]["operador_pk"],
                        "t_dt_cadastro"=> $query[$i]["dt_cadastro"]
                    );
                }
                else{
                    $mysql_data = [];
                }
                
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $propostadao->listar_por_dt_inicio();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    
                    "t_n_versao"=>$query[$i]['n_versao'],
                    "t_responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "t_vl_total"=>$query[$i]['vl_total'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_dt_validade"=>$query[$i]['dt_validade'],
                    "t_dt_envio"=>$query[$i]['dt_envio'],
                    "t_dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    //"t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_agendas_pk"=>$query[$i]['agendas_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }
    case 'listarPropostaLeadProcesso':{
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        
        $resultado = "";
        $query = $propostadao->listar_proposta_lead_processo($leads_pk,$processos_pk);
   
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_responsavel"=>$query[$i]['ds_responsavel'],
                    "t_responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "t_n_versao"=>$query[$i]['n_versao'],
                    "t_dt_cad"=>$query[$i]['dt_cad'],
                    "t_dt_validade"=>$query[$i]['dt_validade'], 
                    "t_dt_envio"=>$query[$i]['dt_envio'],  
                    "t_dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],
                    //"t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_vl_total"=>$query[$i]['vl_total'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],                    
                    "t_ds_contato"=>$query[$i]['ds_contato'],                    
                    "t_leads_pk"=>$query[$i]['leads_pk'],                    
                    "t_ds_email_contato"=>$query[$i]['ds_email_contato'],                    
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }     
    case 'listarPropostaDashboard':{
   
        $resultado = "";
        $query = $propostadao->listar_proposta_lead_processo_dashboard($token);
   
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_responsavel"=>$query[$i]['ds_responsavel'],
                    "t_n_versao"=>$query[$i]['n_versao'],
                    "t_dt_cad"=>$query[$i]['dt_cad'],
                    "t_dt_validade"=>$query[$i]['dt_validade'], 
                    "t_dt_envio"=>$query[$i]['dt_envio'],  
                    "t_dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    //"t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_vl_total"=>number_format($query[$i]['vl_total'],2,',','.'),
                    "t_ds_obs"=>$query[$i]['ds_obs'],                    
                    "t_leads_pk"=>$query[$i]['leads_pk'],                                   
                    "t_processos_pk"=>$query[$i]['processos_pk'],                    
                    "t_ds_lead"=>$query[$i]['ds_lead'],                    
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }  
    case 'listarDadosImpressaoProposta':{
        $resultado = "";
        $query = $propostadao->listarDadosImpressaoProposta($pk);
   
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_responsavel" => $query[$i]["ds_responsavel"],
                    "t_dt_cad" => $query[$i]["dt_cad"],
                    "t_dt_validade" => $query[$i]["dt_validade"],
                    "t_dt_envio" => $query[$i]["dt_envio"],
                    "t_vl_total" => $query[$i]["vl_total"],
                    "t_ds_obs" => $query[$i]["ds_obs"],
                    "t_ds_lead" => $query[$i]["ds_lead"],
                    "t_leads_pk" => $query[$i]["leads_pk"],
                    "t_ds_endereco" => $query[$i]["ds_endereco"],
                    "t_ds_cidade" => $query[$i]["ds_cidade"],
                    "t_ds_tel" => $query[$i]["ds_tel"],
                    "t_ds_cep" => $query[$i]["ds_cep"],
                    "t_ds_cpf_cnpj" => $query[$i]["ds_cpf_cnpj"],
                    "t_ds_uf" => $query[$i]["ds_uf"],
                    "t_ds_email" => $query[$i]["ds_email"]
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }   
    case 'salvarProdutosItens':{  
        
        //Salva Produtos itens Contrato
        $resultado = "";
        $query = $propostadao->salvarProdutosItens($pk,$categorias_produto_pk,$produtos_pk,$n_qtde_item,$vl_item_produto);

        $mysql_data[] = array(
            "pk" => $contratos_pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';         
        break;        
    }  
    case 'excluirProdutosItens':{      

        //Excluir Produtos itens Contrato
        $resultado = "";
        $query = $propostadao->excluirProdutosItens($pk);
  
        $mysql_data[] = array(
            "pk" => $contratos_pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';         
        break;        
    }   
    case 'listarProdutosItens':{
   
        if($pk!=''){
            $resultado = "";        
            $query = $propostadao->listarProdutosItens($pk); 
         
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "ds_categoria"=>$query[$i]['ds_categoria'],
                        "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                        "produtos_pk"=>$query[$i]['produtos_pk'],
                        "ds_produto"=>$query[$i]['ds_produto'],
                        "qtde_total_itens"=>$query[$i]['qtde_total_itens'],
                        "vl_total_itens"=>$query[$i]['vl_total_itens'],
                        "vl_total_item"=>$query[$i]['vl_total_item'],
                        "n_qtde_item"=>$query[$i]['n_qtde_item'],
                        "vl_item_produto"=> $query[$i]['vl_item_produto'],  
                        "vl_total_produto"=> $query[$i]['vl_total_produto']
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


    default:{
        break;
    }
}

$propostadao = null;

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
