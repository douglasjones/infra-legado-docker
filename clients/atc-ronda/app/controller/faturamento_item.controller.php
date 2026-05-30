<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/faturamento_item.dao.php";
require_once "../model/faturamento_item.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$vl_total_lancamento = $arrRequest['vl_total_lancamento'];
$faturamento_pk = $arrRequest['faturamento_pk'];
$contas_pk = $arrRequest['contas_pk'];
$leads_pk = $arrRequest['leads_pk'];
$contratos_pk = $arrRequest['contratos_pk'];
$dt_lancamento_financeiro = $arrRequest['dt_lancamento_financeiro'];
$ic_item_validado = $arrRequest['ic_item_validado'];
$dt_item_valiado = $arrRequest['dt_item_valiado'];
$lancamentos_pk = $arrRequest['lancamentos_pk'];
$ic_status = $arrRequest['ic_status'];
$ic_processamento_lancamento_item_status = $arrRequest['ic_processamento_lancamento_item_status'];
$dt_processamento_lancamento_lancamento = $arrRequest['dt_processamento_lancamento_lancamento'];
$obs_faturamento_contrato = $arrRequest['obs_faturamento_contrato'];
$obs_lancamento = $arrRequest['obs_lancamento'];
$obs_corpo_nota = $arrRequest['obs_corpo_nota'];


$faturamento_itemdao = new faturamento_itemdao();
$faturamento_itemdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $faturamento_item = $faturamento_itemdao->carregarPorPk($pk);
        if($faturamento_item->getpk()>0){
            
            $faturamento_itemdao->excluir($faturamento_item);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'faturamento_item nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $faturamento_item = $faturamento_itemdao->carregarPorPk($pk);
        $faturamento_item->setvl_total_lancamento($vl_total_lancamento);
        $faturamento_item->setfaturamento_pk($faturamento_pk);
        $faturamento_item->setcontas_pk($contas_pk);
        $faturamento_item->setleads_pk($leads_pk);
        $faturamento_item->setcontratos_pk($contratos_pk);
        $faturamento_item->setdt_lancamento_financeiro($dt_lancamento_financeiro);
        $faturamento_item->setic_item_validado($ic_item_validado);
        $faturamento_item->setdt_item_valiado($dt_item_valiado);
        $faturamento_item->setlancamentos_pk($lancamentos_pk);
        $faturamento_item->setic_status($ic_status);
        $faturamento_item->setic_processamento_lancamento_item_status($ic_processamento_lancamento_item_status);
        $faturamento_item->setdt_processamento_lancamento_lancamento($dt_processamento_lancamento_lancamento);
        $faturamento_item->setobs_faturamento_contrato($obs_faturamento_contrato);
        $faturamento_item->setobs_lancamento($obs_lancamento);
        $faturamento_item->setobs_corpo_nota($obs_corpo_nota);

        
        $pk = $faturamento_itemdao->salvar($faturamento_item);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $faturamento_itemdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "vl_total_lancamento"=>$query[$i]['vl_total_lancamento'],
                    "faturamento_pk"=>$query[$i]['faturamento_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "dt_lancamento_financeiro"=>$query[$i]['dt_lancamento_financeiro'],
                    "ic_item_validado"=>$query[$i]['ic_item_validado'],
                    "dt_item_valiado"=>$query[$i]['dt_item_valiado'],
                    "lancamentos_pk"=>$query[$i]['lancamentos_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "ic_processamento_lancamento_item_status"=>$query[$i]['ic_processamento_lancamento_item_status'],
                    "dt_processamento_lancamento_lancamento"=>$query[$i]['dt_processamento_lancamento_lancamento'],
                    "obs_faturamento_contrato"=>$query[$i]['obs_faturamento_contrato'],
                    "obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "obs_corpo_nota"=>$query[$i]['obs_corpo_nota']
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
        $query = $faturamento_itemdao->listar_por_vl_total_lancamento($vl_total_lancamento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "vl_total_lancamento"=>$query[$i]['vl_total_lancamento'],
                    "faturamento_pk"=>$query[$i]['faturamento_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "dt_lancamento_financeiro"=>$query[$i]['dt_lancamento_financeiro'],
                    "ic_item_validado"=>$query[$i]['ic_item_validado'],
                    "dt_item_valiado"=>$query[$i]['dt_item_valiado'],
                    "lancamentos_pk"=>$query[$i]['lancamentos_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "ic_processamento_lancamento_item_status"=>$query[$i]['ic_processamento_lancamento_item_status'],
                    "dt_processamento_lancamento_lancamento"=>$query[$i]['dt_processamento_lancamento_lancamento'],
                    "obs_faturamento_contrato"=>$query[$i]['obs_faturamento_contrato'],
                    "obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "obs_corpo_nota"=>$query[$i]['obs_corpo_nota']
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
        $query = $faturamento_itemdao->listar_por_vl_total_lancamento($vl_total_lancamento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_vl_total_lancamento"=>$query[$i]['vl_total_lancamento'],
                    "t_faturamento_pk"=>$query[$i]['faturamento_pk'],
                    "t_contas_pk"=>$query[$i]['contas_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_dt_lancamento_financeiro"=>$query[$i]['dt_lancamento_financeiro'],
                    "t_ic_item_validado"=>$query[$i]['ic_item_validado'],
                    "t_dt_item_valiado"=>$query[$i]['dt_item_valiado'],
                    "t_lancamentos_pk"=>$query[$i]['lancamentos_pk'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ic_processamento_lancamento_item_status"=>$query[$i]['ic_processamento_lancamento_item_status'],
                    "t_dt_processamento_lancamento_lancamento"=>$query[$i]['dt_processamento_lancamento_lancamento'],
                    "t_obs_faturamento_contrato"=>$query[$i]['obs_faturamento_contrato'],
                    "t_obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "t_obs_corpo_nota"=>$query[$i]['obs_corpo_nota'],

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

$faturamento_itemdao = null;

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
