<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";

require_once "../model/contrato.dao.php";

require_once "../model/contrato.class.php";

require_once "../model/agenda_colaborador_padrao.dao.php";
require_once "../model/agenda_colaborador_padrao.class.php";

require_once "../model/contrato_item.dao.php";
require_once "../model/contrato_item.class.php";

require_once "../model/contrato_dados_faturamento.dao.php";
require_once "../model/contrato_dados_faturamento.class.php";

require_once "../model/lancamento.dao.php";
require_once "../model/lancamento.class.php";

require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";

require_once "../model/produto_servico.dao.php";
require_once "../model/produto_servico.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$dt_inicio_contrato = $arrRequest['dt_inicio_contrato'];
$dt_fim_contrato = $arrRequest['dt_fim_contrato'];
$processos_etapas_pk = $arrRequest['processos_etapas_pk'];
$contratos_itens = $arrRequest['contratos_itens'];
$contrato_pai_pk = $arrRequest['contratos_pk'];
$ic_tipo_contrato = $arrRequest['ic_tipo_contrato'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$ds_obs_motivo_cancelamento = $arrRequest['ds_obs_motivo_cancelamento'];
$empresas_pk = $arrRequest['empresas_pk'];
$leads_pk = $arrRequest['leads_pk'];
$leads_postotrabalho_pk = $arrRequest['leads_postotrabalho_pk'];
$ic_lancar_financeiro = $arrRequest['ic_lancar_financeiro'];
$qtde_parcelas_pk = $arrRequest['qtde_parcelas_pk'];
$vl_total_mao_obra = $arrRequest['vl_total_mao_obra'];
$metodos_pagamento_pk = $arrRequest['metodos_pagamento_pk'];
$contrato_dados_faturamento = $arrRequest['contrato_dados_faturamento'];
$ic_tipo_lead = $arrRequest['ic_tipo_lead'];

$ds_identificacao_area = $arrRequest['ds_identificacao_area'];
$vl_contrato =  $arrRequest['vl_contrato'];
$contratodao = new contratodao();
$contratodao->setToken($token); 

$contrato_itemdao = new contrato_itemdao();
$contrato_itemdao->setToken($token); 

$lancamentodao = new lancamentodao();
$lancamentodao->setToken($token); 

$contrato_dados_faturamentodao = new contrato_dados_faturamentodao();
$contrato_dados_faturamentodao->setToken($token); 

$agenda_colaborador_padraodao = new agenda_colaborador_padraodao();
$agenda_colaborador_padraodao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

$produto_servicodao = new produto_servicodao();
$produto_servicodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $contrato = $contratodao->carregarPorPk($pk);
        if($contrato->getpk()>0){
            
            $query = $agenda_colaborador_padraodao->listarAgendaPorContratosPk($contrato->getpk());
            
            if(count($query) > 0){
                $result  = 'success';
                $message = 'Existe uma agenda com este contrato.';
            }else{
                
                $pk_contratos_itens = $contratodao->listarPkContratosItens($contrato->getpk());
            
                /*if(count($pk_contratos_itens)>0){
                    for($i=0;$i<count($pk_contratos_itens);$i++){
                        $log_exclusaodao->salvar("contratos_itens", $pk_contratos_itens[$i]['pk']);
                    }
                }*/

                $log_exclusaodao->salvar("contratos",$contrato->getpk());
                
                
                $contratodao->excluirMaterial($contrato->getpk());
                $contratodao->excluirConjuntoMaterial($contrato->getpk());
                $contratodao->excluirContratoDadosFaturamento($contrato->getpk());
                $contratodao->excluirContratoItens($contrato->getpk());
                $contratodao->excluirContratosPai($contrato->getpk());
                $contratodao->excluirLancamento($contrato->getpk());
                $contratodao->excluir($contrato);

                $result  = 'success';
                $message = 'Registro excluído com sucesso.';
            }            

        }
        else{
            $result  = 'error';
            $message = 'contrato nao encontrado';
        }
        break;
    }
    case 'salvar':{
        if($contratos_itens != "")
            $arrContratoItens = json_decode($contratos_itens, true);
        
        if($contrato_dados_faturamento != "")
            $arrContratoDadosFaturamento = json_decode($contrato_dados_faturamento, true);
        
        $contrato = $contratodao->carregarPorPk($pk);
        if($dt_inicio_contrato!=""){
            $contrato->setdt_inicio_contrato(DataYMD($dt_inicio_contrato));
        }else{
            $contrato->setdt_inicio_contrato("sysdate()");
        }
        if($dt_inicio_contrato!=""){
            $contrato->setdt_fim_contrato(DataYMD($dt_fim_contrato));
        }else{
            $contrato->setdt_fim_contrato("sysdate()");
        }

        $contrato->setprocessos_etapas_pk($processos_etapas_pk);
        $contrato->setic_tipo_contrato($ic_tipo_contrato);
        $contrato->setcontratos_pk($contrato_pai_pk);
        $contrato->setdt_cancelamento($dt_cancelamento);
        $contrato->setds_obs_motivo_cancelamento($ds_obs_motivo_cancelamento);
        $contrato->setempresas_pk($empresas_pk);
        $contrato->setic_lancar_financeiro($ic_lancar_financeiro);
        $contrato->setqtde_parcelas_pk($qtde_parcelas_pk);
        $contrato->setvl_total_mao_obra($vl_total_mao_obra);
        $contrato->setds_identificacao_area($ds_identificacao_area);
        $contrato->setvl_contrato($vl_contrato);

        $c_pk = $contratodao->salvar($contrato);
        
        if($pk==""){
            $contratos_pk = $c_pk;
        }
        else{
            $contratos_pk = $pk;
        }
       
        if(count($arrContratoItens) > 0){          
            for($i = 0; $i < count($arrContratoItens); $i++){  
  
                //tira ponto e a virgula para salvar o valor no BD 
                $valor_unitario= ($arrContratoItens[$i]["vl_unit"]);
                //$valor_total= ($arrContratoItens[$i]["vl_total"]);
                //$valor_total= moeda2float($arrContratoItens[$i]['n_qtde']*$arrContratoItens[$i]["vl_unit"]);  
                $valor_total= $arrContratoItens[$i]['n_qtde']*$arrContratoItens[$i]["vl_unit"]; 
            
                $contratodao->adicionarContratoItens($arrContratoItens[$i]['contratos_itens_pk'],$contratos_pk,$arrContratoItens[$i]['n_qtde_dias_semana'], $arrContratoItens[$i]['n_qtde'], $valor_unitario, $valor_total, $arrContratoItens[$i]["produtos_servicos_pk"],$arrContratoItens[$i]["periodo"],$arrContratoItens[$i]["vl_mao_obra"]);
           
            }     
              
        }

        $contratodao->excluirContratoDadosFaturamento($contratos_pk);   
 
        if(count($arrContratoDadosFaturamento) > 0){          
            for($i = 0; $i < count($arrContratoDadosFaturamento); $i++){                
                $contrato_dados_faturamento = $contrato_dados_faturamentodao->carregarPorPk(0);
                $contrato_dados_faturamento->setmetodos_pagamento_pk($metodos_pagamento_pk);
                $contrato_dados_faturamento->setnum_parcela($arrContratoDadosFaturamento[$i]['num_parcela']);
                $contrato_dados_faturamento->setdt_pagamento(DataYMD($arrContratoDadosFaturamento[$i]['dt_pagamento']));
                $contrato_dados_faturamento->setdt_faturamento(DataYMD($arrContratoDadosFaturamento[$i]['dt_faturamento']));
                $contrato_dados_faturamento->setvl_servico(moeda2float($arrContratoDadosFaturamento[$i]['vl_pagamento']));
                $contrato_dados_faturamento->setcontratos_pk($contratos_pk);
                
                $contrato_dados_faturamento_pk = $contrato_dados_faturamentodao->salvar($contrato_dados_faturamento);
                
            }            
        }        

        //Lançar no financeiro
        if($pk==""){            
            if($ic_lancar_financeiro==1){
                if(count($arrContratoDadosFaturamento) > 0){
          
                    for($i = 0; $i < count($arrContratoDadosFaturamento); $i++){

                        $conta_bancaria_pk = $lancamentodao->listaContaEmpresa($empresas_pk);

                        $lancamento = $lancamentodao->carregarPorPk("");

                        $lancamento->setoperacao_pk(1);
                        $lancamento->settipos_operacao_pk(1002);
                        $lancamento->setempresas_pk($empresas_pk);
                        $lancamento->setcontas_bancarias_pk($conta_bancaria_pk[0]['pk']);
                        $lancamento->setds_lancamento("Serviço Extra");
                        $lancamento->settipo_grupo_pk(1);
                        $lancamento->setgrupo_leancamento_pk($leads_pk);
                        $lancamento->setvl_lancamento($arrContratoDadosFaturamento[$i]['vl_pagamento']);
                        $lancamento->setmetodos_pagamento_pk($metodos_pagamento_pk);
                        $lancamento->setdt_vencimento(($arrContratoDadosFaturamento[$i]['dt_pagamento']));
                        $lancamento->setdt_faturamento(($arrContratoDadosFaturamento[$i]['dt_faturamento']));
                        $lancamento->setic_status_pagamento(2);
                        $lancamento->setcontratos_pk($contratos_pk);

                        $lancamentos_pk = $lancamentodao->salvar($lancamento);
                    }
                }
            }            
        }

        $mysql_data[] = array(
            "pk" => $contratos_pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';    
              
        
        break;
    }    
    //NOVO
    case 'listarPk':{        
        $resultado = "";
        $query = $contratodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento']
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
    
   case 'listarSotorContratos':{        
        $resultado = "";
        $query = $contratodao->listarSotorContratos($pk);
   
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_identificacao_area"=>$query[$i]['ds_identificacao_area']
                );
            }
        }else{
            $mysql_data = [];
        }	
        $result  = 'success';
        $message = 'query success';        
        break;        
    }    
    
   
    case 'salvarProdutosItens':{     
        
        $categorias_produto_pk = $_REQUEST['categorias_produto_pk'];
        $produtos_pk = $_REQUEST['produtos_pk'];
        $n_qtde_item = $_REQUEST['n_qtde_item'];
        $vl_item_produto = $_REQUEST['vl_item_produto'];
        
        //Salva Produtos itens Contrato
        $resultado = "";
        $query = $contratodao->salvarProdutosItens($pk,$categorias_produto_pk,$produtos_pk,$n_qtde_item,$vl_item_produto);

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
        $query = $contratodao->excluirProdutosItens($pk);
  
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
            $query = $contratodao->listarProdutosItens($pk); 
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "ds_categoria"=>$query[$i]['ds_categoria'],
                        "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                        "produtos_pk"=>$query[$i]['produtos_pk'],
                        "ds_produto"=>$query[$i]['ds_produto'],
                        "n_qtde_item"=>$query[$i]['n_qtde_item'],
                        "vl_item_produto"=> number_format($query[$i]['vl_item_produto'] ,2,',','.'),                       
                        
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
    
    case 'listarLeadsPk':{
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $dt_inicio_contrato = $_REQUEST['dt_inicio_contrato'];
        $resultado = "";
        $query = $contratodao->listarPorLeadsPk($leads_pk,$processos_pk,$dt_inicio_contrato,$colaborador_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "ds_combo_contrato"=>$query[$i]['ds_combo_contrato']."  ".$query[$i]['ds_identificacao_area'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento']
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
    
     case 'listarContratosLedasColaboradoeEscala':{  

        $leads_pk = $_REQUEST['leads_pk'];
        $contratos_pk = $_REQUEST['contratos_pk'];
        
        $resultado = "";
        $query = $contratodao->listarContratosLedasColaboradoeEscala($leads_pk,$contratos_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento']
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
    //Lista contratos lançamento financeiro Leads
    case 'listaLeadContratos':{
        $leads_pk = $_REQUEST['leads_pk'];

        $resultado = "";
        $query = $contratodao->listaLeadContratos($leads_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_contrato_posto = "";
                $ds_contrato_posto = $query[$i]['ds_contrato'];
                $ds_produto_servico = "";
       
                $queryProdutoServico = $produto_servicodao->listarProdutosContrato($query[$i]['pk']);

                $ds_produto_servico =  $queryProdutoServico[0]['ds_produto_servico'];   

                if(!empty($ds_produto_servico )){
                    $ds_contrato_posto = $ds_contrato_posto." Serviços: ".$ds_produto_servico;
                }

                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_contrato"=>$ds_contrato_posto
                );
            }
        }else{
            $mysql_data = [];
        }			
        $result  = 'success';
        $message = 'query success';
        
        break;        
    } 
    //Lista contratos vinculados ao colaborador e escalas
    case 'listaColaboradorContratos':{

        $leads_pk = $_REQUEST['leads_pk'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
 
        $resultado = "";
        $query = $contratodao->listaColaboradorContratos($leads_pk,$colaborador_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_contrato_posto = "";
                $ds_contrato_posto = $query[$i]['ds_contrato'];
                $ds_produto_servico = "";
       
                $queryProdutoServico = $produto_servicodao->listarProdutosContrato($query[$i]['pk']);

                $ds_produto_servico =  $queryProdutoServico[0]['ds_produto_servico'];   

                if(!empty($ds_produto_servico )){
                    $ds_contrato_posto = $ds_contrato_posto." Serviços: ".$ds_produto_servico;
                }
              


                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_contrato"=>$ds_contrato_posto
                );
            }
        }else{
            $mysql_data = [];
        }			
        $result  = 'success';
        $message = 'query success';        
        break;        
    } 
    
    
    //ANTIGO
    case 'listarLeadsPkPeriodo':{
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        $dt_inicio_contrato = $_REQUEST['dt_inicio_contrato'];
        $dt_fim_contrato = $_REQUEST['dt_fim_contrato'];
        $resultado = "";
        $query = $contratodao->listarPorLeadsPkPeriodo($leads_pk,$processos_pk,$dt_inicio_contrato,$dt_fim_contrato);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "ds_combo_contrato"=>$query[$i]['ds_combo_contrato'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento']
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
    case 'listarGridLancamentoContrato':{
        $ic_tipo_contrato = $_REQUEST['ic_tipo_contrato'];
        $lancamento_pk = $_REQUEST['lancamento_pk'];
        $contratos_pk = $_REQUEST['contratos_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        $resultado = "";
        $query = $contratodao->listarGridLancamentoContrato($ic_tipo_contrato,$lancamento_pk,$contratos_pk,$leads_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_contrato"=>$query[$i]['ds_contrato'],
                    "vl_contrato"=>number_format($query[$i]['vl_total'],2,',','.'),
                    "ds_lead"=>$query[$i]['ds_lead']
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
    //Grid de Contratos calendatio Agenda de Escalas Lead
    case 'listarDadosContratoLead':{
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        $dt_inicio_contrato = $_REQUEST['dt_inicio_contrato'];
        $dt_fim_contrato = $_REQUEST['dt_fim_contrato'];
        $resultado = "";
        $query = $contratodao->listarDadosContratoLead($leads_pk,$processos_pk,$dt_inicio_contrato,$dt_fim_contrato);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],        
                    "dt_periodo"=>"De ".$query[$i]['dt_inicio_contrato']." Até ".$query[$i]['dt_fim_contrato'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "n_qtde"=>$query[$i][' n_qtde'],
                   
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico']
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
        $query = $contratodao->listar_por_dt_inicio_contrato($dt_inicio_contrato);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarContratoPai':{
        $leads_pk = $_REQUEST['leads_pk'];
        $contratos_pk = $_REQUEST['contratos_pk'];
        $contrato_pai_pk = $_REQUEST['contrato_pai_pk'];
        $resultado = "";
        $query = $contratodao->listar_contrato_pai($leads_pk,$contratos_pk,$contrato_pai_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_contrato"=>$query[$i]['ds_combo_contrato'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento']
                    
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
        $query = $contratodao->listar_por_dt_inicio_contrato($dt_inicio_contrato);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "t_dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'relatorioContratoValor':{
        
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_contrato_ini = $_REQUEST['dt_contrato_ini'];
        $dt_contrato_fim = $_REQUEST['dt_contrato_fim'];
        $resultado = "";
        $query = $contratodao->relatorioContratoValor($leads_pk,$dt_contrato_ini,$dt_contrato_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "vl_total"=>number_format($query[$i]['vl_total'],2,",","."),
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    
    case 'listarQtdeDeDiasProdutoServico':{
        $contratos_pk = $_REQUEST['contratos_pk'];
        $contratos_itens_pk = $_REQUEST['contratos_itens_pk'];
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        
        $resultado = "";
        $query = $contratodao->listar_qtde_dias_contratados_produtos_servicos($contratos_pk,$contratos_itens_pk,$produtos_servicos_pk,$processos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_qtde_dias_semana" => $query[$i]["n_qtde_dias_semana"],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data[] = array(
                "t_qtde_dias_semana" => "",

                "t_functions" => ""
            );
        }
		
        break;
    }    
    case 'listarContratoLeadProcesso':{
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        
        $resultado = "";
        $query = $contratodao->listar_contrato_lead_processo($leads_pk,$processos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "t_dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_ic_tipo_contrato"=>$query[$i]['ic_tipo_contrato'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],
                    "t_ds_empresa"=>$query[$i]['ds_empresa'],
                    "t_ds_tipo_contrato"=>$query[$i]['ds_tipo_contrato'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],
                    "t_vl_total"=>number_format($query[$i]['vl_total'],2,',','.'),

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarContratoOperacional':{
        $leads_postotrabalho_pk = $_REQUEST['leads_postotrabalho_pk'];
        $ic_tipo_contrato = $_REQUEST['ic_tipo_contrato'];
        $dt_inicio_contrato = $_REQUEST['dt_inicio_contrato'];
        $dt_fim_contrato = $_REQUEST['dt_fim_contrato'];
        $dt_recisao_contrato_ini = $_REQUEST['dt_recisao_contrato_ini'];
        $dt_recisao_contrato_fim = $_REQUEST['dt_recisao_contrato_fim'];
        $dt_cancelamento_ini = $_REQUEST['dt_cancelamento_ini'];
        $dt_cancelamento_fim = $_REQUEST['dt_cancelamento_fim'];
        $leads_clientes_pk = $_REQUEST['leads_clientes_pk'];
        
        
        $resultado = "";
        $arrDados = $contratodao->listarContratoOperacional($pk,$leads_postotrabalho_pk,$ic_tipo_contrato,$dt_inicio_contrato,$dt_fim_contrato,$dt_recisao_contrato_ini,$dt_recisao_contrato_fim,$dt_cancelamento_ini,$dt_cancelamento_fim,$leads_clientes_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($arrDados['query']) > 0){
            $iTotalDisplayRecords = $arrDados['count'];
            for($i = 0; $i < count($arrDados['query']); $i++){
                                
                $querci = $contratodao->pegarValorTotal($arrDados['query'][$i]["pk"]);
     
                $query1 = $contrato_itemdao->listarContratoItem($arrDados['query'][$i]["pk"]);
                $v_vl_total = 0;
                if(count($query1) > 0){
                    for($j = 0; $j < count($arrDados['query']); $j++){
                       
                        $v_vl_total += $query1[$j]['vl_total'];         
                    }
                }


                $mysql_data[] = array(
                    "t_pk" => $arrDados['query'][$i]["pk"],
                    "t_dt_inicio_contrato"=>$arrDados['query'][$i]['dt_inicio_contrato'],
                    "t_dt_fim_contrato"=>$arrDados['query'][$i]['dt_fim_contrato'],
                    "t_processos_etapas_pk"=>$arrDados['query'][$i]['processos_etapas_pk'],
                    "t_ic_tipo_contrato"=>$arrDados['query'][$i]['ic_tipo_contrato'],
                    "t_contratos_pk"=>$arrDados['query'][$i]['contratos_pk'],
                    "t_empresas_pk"=>$arrDados['query'][$i]['empresas_pk'],
                    "t_ds_empresa"=>$arrDados['query'][$i]['ds_empresa'],
                    "t_ds_tipo_contrato"=>$arrDados['query'][$i]['ds_tipo_contrato'],
                    "t_dt_cancelamento"=>$arrDados['query'][$i]['dt_cancelamento'],
                    "qtde_parcelas_pk"=>$arrDados['query'][$i]['qtde_parcelas_pk'],
                    "vl_total_mao_obra"=>number_format($arrDados['query'][$i]['vl_total_mao_obra'],2,',','.'),
                    "vl_contrato"=>number_format($arrDados['query'][$i]['vl_contrato'],2,',','.'),
                    "ic_lancar_financeiro"=>$arrDados['query'][$i]['ic_lancar_financeiro'],
                    "metodos_pagamento_pk"=>$arrDados['query'][$i]['metodos_pagamento_pk'],
                    "t_ds_obs_motivo_cancelamento"=>$arrDados['query'][$i]['ds_obs_motivo_cancelamento'],
                    "t_ds_lead"=>$arrDados['query'][$i]['ds_lead'],
                    "t_leads_postotrabalho_pk"=>$arrDados['query'][$i]['leads_pk'],
                    "t_processos_pk"=>$arrDados['query'][$i]['processos_pk'],
                    "t_ds_identificacao_area"=>$arrDados['query'][$i]['ds_identificacao_area'],    
                    "ic_tipo_lead"=>$arrDados['query'][$i]['ic_tipo_lead'],  
                    "ds_tipo_lead"=>$arrDados['query'][$i]['ds_tipo_lead'],      
                    "t_leads_cliente_pk"=>$arrDados['query'][$i]['leads_pai_pk'],         
                    "t_vl_total"=>number_format($v_vl_total,2,',','.'),

                    "t_functions" => ""
                );
            }
        }else{
            $mysql_data = [];
            $iTotalDisplayRecords = 0;
        }
		
        break;
    }    
    default:{
        break;
    }
}

$contratodao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data,
    "iTotalDisplayRecords"=>$iTotalDisplayRecords,
    "iTotalRecords"=>$iTotalDisplayRecords
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
echo $json_data;


?>
