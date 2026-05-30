<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/teto_gastos.dao.php";
require_once "../model/teto_gastos.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$empresas_pk = $arrRequest['empresas_pk'];
$tipo_grupo_pk = $arrRequest['tipo_grupo_pk'];
$grupo_leancamento_pk = $arrRequest['grupo_leancamento_pk'];
$leads_posto_trabalho_pk = $arrRequest['leads_posto_trabalho_pk'];
$contratos_pk = $arrRequest['contratos_pk'];
$colaborador_posto_trabalho_pk = $arrRequest['colaborador_posto_trabalho_pk'];
$colaborador_contratos_pk = $arrRequest['colaborador_contratos_pk'];
$fornecedor_posto_trabalho_pk = $arrRequest['fornecedor_posto_trabalho_pk'];
$fornecedor_contratos_pk = $arrRequest['fornecedor_contratos_pk'];
$vl_total_teto = $arrRequest['vl_total_teto'];
$vl_utilizado_atual = $arrRequest['vl_utilizado_atual'];
$ic_status = $arrRequest['ic_status'];
$obs = $arrRequest['obs'];
$ds_ano_vigente_teto = $arrRequest['ds_ano_vigente_teto'];
$grupo_lancamento_centro_custo_pk = $arrRequest['grupo_lancamento_centro_custo_pk'];
$posto_trabalho_pk = $arrRequest['posto_trabalho_pk'];


$teto_gastodao = new teto_gastosdao();
$teto_gastodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $teto_gastos = $teto_gastodao->carregarPorPk($pk);
        if($teto_gastos->getpk()>0){
            
            $teto_gastodao->excluir($teto_gastos);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'teto_gastos nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $teto_gastos = $teto_gastodao->carregarPorPk($pk);
        $teto_gastos->setempresas_pk($empresas_pk);
        $teto_gastos->settipo_grupo_pk($tipo_grupo_pk);
        $teto_gastos->setgrupo_leancamento_pk($grupo_leancamento_pk);
        $teto_gastos->setleads_posto_trabalho_pk($leads_posto_trabalho_pk);
        $teto_gastos->setcontratos_pk($contratos_pk);
        $teto_gastos->setcolaborador_posto_trabalho_pk($colaborador_posto_trabalho_pk);
        $teto_gastos->setcolaborador_contratos_pk($colaborador_contratos_pk);
        $teto_gastos->setfornecedor_posto_trabalho_pk($fornecedor_posto_trabalho_pk);
        $teto_gastos->setfornecedor_contratos_pk($fornecedor_contratos_pk);
        $teto_gastos->setvl_total_teto($vl_total_teto);
        $teto_gastos->setvl_utilizado_atual($vl_utilizado_atual);
        $teto_gastos->setic_status($ic_status);
        $teto_gastos->setobs($obs);
        $teto_gastos->setds_ano_vigente_teto($ds_ano_vigente_teto);
        $teto_gastos->setgrupo_lancamento_centro_custo_pk($grupo_lancamento_centro_custo_pk);

        
        $pk = $teto_gastodao->salvar($teto_gastos);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $teto_gastodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "leads_posto_trabalho_pk"=>$query[$i]['leads_posto_trabalho_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "colaborador_posto_trabalho_pk"=>$query[$i]['colaborador_posto_trabalho_pk'],
                    "colaborador_contratos_pk"=>$query[$i]['colaborador_contratos_pk'],
                    "fornecedor_posto_trabalho_pk"=>$query[$i]['fornecedor_posto_trabalho_pk'],
                    "fornecedor_contratos_pk"=>$query[$i]['fornecedor_contratos_pk'],
                    "vl_total_teto"=>number_format($query[$i]['vl_total_teto'], 2, ',', '.'),
                    "ic_status"=>$query[$i]['ic_status'],
                    "obs"=>$query[$i]['obs'],
                    "ds_ano_vigente_teto"=>$query[$i]['ds_ano_vigente_teto'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "vl_utilizado_atual"=>number_format($query[$i]['vl_utilizado_atual'], 2, ',', '.'),
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
        $query = $teto_gastodao->listar_por_empresas_pk($empresas_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "leads_posto_trabalho_pk"=>$query[$i]['leads_posto_trabalho_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "colaborador_posto_trabalho_pk"=>$query[$i]['colaborador_posto_trabalho_pk'],
                    "colaborador_contratos_pk"=>$query[$i]['colaborador_contratos_pk'],
                    "fornecedor_posto_trabalho_pk"=>$query[$i]['fornecedor_posto_trabalho_pk'],
                    "fornecedor_contratos_pk"=>$query[$i]['fornecedor_contratos_pk'],
                    "vl_total_teto"=>$query[$i]['vl_total_teto'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "obs"=>$query[$i]['obs'],
                    "ds_ano_vigente_teto"=>$query[$i]['ds_ano_vigente_teto'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk']
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
        $query = $teto_gastodao->listarDataTable($tipo_grupo_pk, $posto_trabalho_pk, $contratos_pk, $grupo_leancamento_pk, $grupo_lancamento_centro_custo_pk, $ds_ano_vigente_teto, $ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_tipo_grupo_pk"=>$query[$i]['ds_tipo_grupo'],
                    "t_grupo_leancamento_pk"=>$query[$i]['ds_grupo_lancamento'],
                    "t_leads_posto_trabalho_pk"=>$query[$i]['ds_lead'],
                    "t_contratos_pk"=>$query[$i]['ds_contrato'],
                    "t_vl_total_teto"=>number_format($query[$i]['vl_total_teto'], 2, ',', '.'),
                    "t_vl_utilizado_atual"=> number_format($query[$i]['vl_utilizado_atual'], 2, ',', '.'),
                    "t_ic_status"=>$query[$i]['ds_status'],
                    "t_ds_ano_vigente_teto"=>$query[$i]['ds_ano_vigente_teto'],
                    "t_grupo_lancamento_centro_custo_pk"=>$query[$i]['ds_grupo_lancamento_centro_custo'],

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

$teto_gastodao = null;

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
