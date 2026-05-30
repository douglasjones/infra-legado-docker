<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/faturamento_leads.dao.php";
require_once "../model/faturamento_leads.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$leads_pk = $arrRequest['leads_pk'];
$vl_total_bruto = $arrRequest['vl_total_bruto'];
$vl_total_faturamento = $arrRequest['vl_total_faturamento'];
$obs_faturamento_lead = $arrRequest['obs_faturamento_lead'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$obs_cancelamento = $arrRequest['obs_cancelamento'];
$ic_starus = $arrRequest['ic_starus'];
$faturamento_pk = $arrRequest['faturamento_pk'];


$faturamento_leadsdao = new faturamento_leadsdao();
$faturamento_leadsdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $faturamento_leads = $faturamento_leadsdao->carregarPorPk($pk);
        if($faturamento_leads->getpk()>0){
            
            $faturamento_leadsdao->excluir($faturamento_leads);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'faturamento_leads nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $faturamento_leads = $faturamento_leadsdao->carregarPorPk($pk);
        $faturamento_leads->setleads_pk($leads_pk);
        $faturamento_leads->setvl_total_bruto($vl_total_bruto);
        $faturamento_leads->setvl_total_faturamento($vl_total_faturamento);
        $faturamento_leads->setobs_faturamento_lead($obs_faturamento_lead);
        $faturamento_leads->setdt_cancelamento($dt_cancelamento);
        $faturamento_leads->setobs_cancelamento($obs_cancelamento);
        $faturamento_leads->setic_starus($ic_starus);
        $faturamento_leads->setfaturamento_pk($faturamento_pk);

        
        $pk = $faturamento_leadsdao->salvar($faturamento_leads);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $faturamento_leadsdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "vl_total_bruto"=>$query[$i]['vl_total_bruto'],
                    "vl_total_faturamento"=>$query[$i]['vl_total_faturamento'],
                    "obs_faturamento_lead"=>$query[$i]['obs_faturamento_lead'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "obs_cancelamento"=>$query[$i]['obs_cancelamento'],
                    "ic_starus"=>$query[$i]['ic_starus'],
                    "faturamento_pk"=>$query[$i]['faturamento_pk']
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
        $query = $faturamento_leadsdao->listar_por_leads_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "vl_total_bruto"=>$query[$i]['vl_total_bruto'],
                    "vl_total_faturamento"=>$query[$i]['vl_total_faturamento'],
                    "obs_faturamento_lead"=>$query[$i]['obs_faturamento_lead'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "obs_cancelamento"=>$query[$i]['obs_cancelamento'],
                    "ic_starus"=>$query[$i]['ic_starus'],
                    "faturamento_pk"=>$query[$i]['faturamento_pk']
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
        $query = $faturamento_leadsdao->listar_por_leads_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_vl_total_bruto"=>$query[$i]['vl_total_bruto'],
                    "t_vl_total_faturamento"=>$query[$i]['vl_total_faturamento'],
                    "t_obs_faturamento_lead"=>$query[$i]['obs_faturamento_lead'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_obs_cancelamento"=>$query[$i]['obs_cancelamento'],
                    "t_ic_starus"=>$query[$i]['ic_starus'],
                    "t_faturamento_pk"=>$query[$i]['faturamento_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarFaturamentoPk':{
        $faturamento_pk = $_REQUEST['faturamento_pk'];
        
        $resultado = "";
        $query = $faturamento_leadsdao->listarFaturamentoPk($faturamento_pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_faturamento_pk" => $query[$i]["faturamento_pk"],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_empresa_pk"=>$query[$i]['empresa_pk'],
                    "t_ds_empresa"=>$query[$i]['ds_empresa'],
                    "t_dt_ini_faturamento"=>$query[$i]['dt_ini_faturamento'],
                    "t_dt_fim_faturamento"=>$query[$i]['dt_fim_faturamento'],
                    "t_tipo_contrato_fixo"=>$query[$i]['tipo_contrato_fixo'],
                    "t_tipo_contrato_aditivo"=>$query[$i]['tipo_contrato_aditivo'],
                    "t_tipo_contrato_extra"=>$query[$i]['tipo_contrato_extra'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }   
    case 'listarContratosLeads':{
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_ini_faturamento = $_REQUEST['dt_ini_faturamento'];
        $dt_fim_faturamento = $_REQUEST['dt_fim_faturamento'];
        $tipo_contrato_fixo = $_REQUEST['tipo_contrato_fixo'];
        $tipo_contrato_aditivo = $_REQUEST['tipo_contrato_aditivo'];
        $tipo_contrato_extra = $_REQUEST['tipo_contrato_extra'];

        $resultado = "";
        $query = $faturamento_leadsdao->listarContratosLeads($leads_pk,$dt_ini_faturamento,$dt_fim_faturamento,$tipo_contrato_fixo,$tipo_contrato_aditivo,$tipo_contrato_extra);
        
        $result  = 'success';
        $message = 'query success';
       
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "t_dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "t_dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "t_ds_tipo_contrato"=>$query[$i]['ds_tipo_contrato'],
                    //"t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    //"t_n_qtde"=>$query[$i]['n_qtde'],
                    //"t_vl_total"=>$query[$i]['vl_total'],    
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }   
    
    case 'listarItensContrato':{
        $contratos_pk = $_REQUEST['contratos_pk'];

        $resultado = "";
        $query = $faturamento_leadsdao->listarItensContrato($contratos_pk);
        
        $result  = 'success';
        $message = 'query success';

        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_n_qtde"=>$query[$i]['n_qtde'],
                    "t_vl_unit"=>$query[$i]['vl_unit'],
                    "t_vl_total"=>$query[$i]['vl_total'],    
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

$faturamento_leadsdao = null;

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
