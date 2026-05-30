<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/propostas_facilities.dao.php";
require_once "../model/propostas_facilities.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_versao = $arrRequest['ds_versao'];
$ds_numero_proposta = $arrRequest['ds_numero_proposta'];
$leads_pk = $arrRequest['leads_pk'];
$ic_tipo_proposta = $arrRequest['ic_tipo_proposta'];
$produtos_servicos_pk = $arrRequest['produtos_servicos_pk'];
$ds_qtde_efetivo = $arrRequest['ds_qtde_efetivo'];
$ds_qtde_hr_semanais = $arrRequest['ds_qtde_hr_semanais'];
$ic_escala = $arrRequest['ic_escala'];
$convencao_coletiva_pk = $arrRequest['convencao_coletiva_pk'];
$dt_base_categoria = $arrRequest['dt_base_categoria'];
$ds_num_registro_mte = $arrRequest['ds_num_registro_mte'];
$vl_salario_piso_categoria = $arrRequest['vl_salario_piso_categoria'];
$vl_total_proposta = $arrRequest['vl_total_proposta'];
$vl_total_percentual_proposta = $arrRequest['vl_total_percentual_proposta'];
$usuario_responsavel_comercial_pk = $arrRequest['usuario_responsavel_comercial_pk'];
$dt_envio_da_proposta = $arrRequest['dt_envio_da_proposta'];
$dt_previsao_fechamento = $arrRequest['dt_previsao_fechamento'];
$dt_fechamento = $arrRequest['dt_fechamento'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$obs_motivo_cancelamento = $arrRequest['obs_motivo_cancelamento'];
$obs_proposta = $arrRequest['obs_proposta'];
$ic_status = $arrRequest['ic_status'];
$contratos_pk = $arrRequest['contratos_pk'];
$ic_versao = $arrRequest['ic_versao'];
$proposta_facilities_pai_pk = $arrRequest['pk'];


$propostas_facilitiesdao = new propostas_facilitiesdao();
$propostas_facilitiesdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $propostas_facilities = $propostas_facilitiesdao->carregarPorPk($pk);
        if($propostas_facilities->getpk()>0){
            
            $propostas_facilitiesdao->excluir($propostas_facilities);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'propostas_facilities nao encontrado';
        }
        break;
    }
    case 'salvar':{

        if($ic_versao > 0){
            $pk = '';
        }
        
        $propostas_facilities = $propostas_facilitiesdao->carregarPorPk($pk);
        $propostas_facilities->setds_versao($ds_versao);
        $propostas_facilities->setds_numero_proposta($ds_numero_proposta);
        $propostas_facilities->setleads_pk($leads_pk);
        $propostas_facilities->setic_tipo_proposta($ic_tipo_proposta);
        $propostas_facilities->setprodutos_servicos_pk($produtos_servicos_pk);
        $propostas_facilities->setds_qtde_efetivo($ds_qtde_efetivo);
        $propostas_facilities->setds_qtde_hr_semanais($ds_qtde_hr_semanais);
        $propostas_facilities->setic_escala($ic_escala);
        $propostas_facilities->setconvencao_coletiva_pk($convencao_coletiva_pk);
        $propostas_facilities->setdt_base_categoria($dt_base_categoria);
        $propostas_facilities->setds_num_registro_mte($ds_num_registro_mte);
        $propostas_facilities->setvl_salario_piso_categoria($vl_salario_piso_categoria);
        $propostas_facilities->setvl_total_proposta($vl_total_proposta);
        $propostas_facilities->setvl_total_percentual_proposta($vl_total_percentual_proposta);
        $propostas_facilities->setusuario_responsavel_comercial_pk($usuario_responsavel_comercial_pk);
        $propostas_facilities->setdt_envio_da_proposta($dt_envio_da_proposta);
        $propostas_facilities->setdt_previsao_fechamento($dt_previsao_fechamento);
        $propostas_facilities->setdt_fechamento($dt_fechamento);
        $propostas_facilities->setdt_cancelamento($dt_cancelamento);
        $propostas_facilities->setobs_motivo_cancelamento($obs_motivo_cancelamento);
        $propostas_facilities->setobs_proposta($obs_proposta);
        $propostas_facilities->setic_status($ic_status);
        $propostas_facilities->setcontratos_pk($contratos_pk);
        $propostas_facilities->setproposta_facilities_pai_pk($proposta_facilities_pai_pk);

        
        $pk = $propostas_facilitiesdao->salvar($propostas_facilities, $ic_versao);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }     
    case 'listarTodos':{
        
        $resultado = "";
        $query = $propostas_facilitiesdao->listar_por_ds_versao($leads_pk, $ic_status, $usuario_cadastro_pk, $usuario_responsavel_comercial_pk, $dt_cadastro);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_versao"=>$query[$i]['ds_versao'],
                    "ds_numero_proposta"=>$query[$i]['ds_numero_proposta'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ic_tipo_proposta"=>$query[$i]['ic_tipo_proposta'],
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "ds_qtde_efetivo"=>$query[$i]['ds_qtde_efetivo'],
                    "ds_qtde_hr_semanais"=>$query[$i]['ds_qtde_hr_semanais'],
                    "ic_escala"=>$query[$i]['ic_escala'],
                    "convencao_coletiva_pk"=>$query[$i]['convencao_coletiva_pk'],
                    "dt_base_categoria"=>$query[$i]['dt_base_categoria'],
                    "ds_num_registro_mte"=>$query[$i]['ds_num_registro_mte'],
                    "vl_salario_piso_categoria"=>$query[$i]['vl_salario_piso_categoria'],
                    "vl_total_proposta"=>$query[$i]['vl_total_proposta'],
                    "usuario_responsavel_comercial_pk"=>$query[$i]['usuario_responsavel_comercial_pk'],
                    "dt_envio_da_proposta"=>$query[$i]['dt_envio_da_proposta'],
                    "dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "obs_motivo_cancelamento"=>$query[$i]['obs_motivo_cancelamento'],
                    "obs_proposta"=>$query[$i]['obs_proposta'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "contratos_pk"=>$query[$i]['contratos_pk']
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
        $query = $propostas_facilitiesdao->listar_por_ds_versao($leads_pk, $ic_status, $usuario_cadastro_pk, $usuario_responsavel_comercial_pk, $dt_cadastro);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_versao"=>$query[$i]['ds_versao'],
                    "t_proposta_facilities_pai_pk"=>$query[$i]['proposta_facilities_pai_pk'],
                    "t_ds_numero_proposta"=>$query[$i]['ds_numero_proposta'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_leads"=>$query[$i]['ds_lead'],
                    "t_ic_tipo_proposta"=>$query[$i]['ic_tipo_proposta'],
                    "t_produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_ds_qtde_efetivo"=>$query[$i]['ds_qtde_efetivo'],
                    "t_ds_qtde_hr_semanais"=>$query[$i]['ds_qtde_hr_semanais'],
                    "t_ic_escala"=>$query[$i]['ic_escala'],
                    "t_convencao_coletiva_pk"=>$query[$i]['convencao_coletiva_pk'],
                    "t_dt_base_categoria"=>$query[$i]['dt_base_categoria'],
                    "t_ds_num_registro_mte"=>$query[$i]['ds_num_registro_mte'],
                    "t_vl_salario_piso_categoria"=>$query[$i]['vl_salario_piso_categoria'],
                    "t_vl_total_proposta"=>$query[$i]['vl_total_proposta'],
                    "t_usuario_responsavel_comercial_pk"=>$query[$i]['usuario_responsavel_comercial_pk'],
                    "t_dt_envio_da_proposta"=>$query[$i]['dt_envio_da_proposta'],
                    "t_dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_obs_motivo_cancelamento"=>$query[$i]['obs_motivo_cancelamento'],
                    "t_obs_proposta"=>$query[$i]['obs_proposta'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ds_usuario_responsavel_comercial"=>$query[$i]['ds_usuario_responsavel_comercial'],
                    "t_ds_usuario_cadastro"=>$query[$i]['ds_usuario_cadastro'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarDataTablePk':{
        
        
        $resultado = "";
        $query = $propostas_facilitiesdao->listar_por_ds_versao_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_versao"=>$query[$i]['ds_versao'],
                    "t_proposta_facilities_pai_pk"=>$query[$i]['proposta_facilities_pai_pk'],
                    "t_ds_numero_proposta"=>$query[$i]['ds_numero_proposta'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_leads"=>$query[$i]['ds_lead'],
                    "t_ic_tipo_proposta"=>$query[$i]['ic_tipo_proposta'],
                    "t_produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_ds_qtde_efetivo"=>$query[$i]['ds_qtde_efetivo'],
                    "t_ds_qtde_hr_semanais"=>$query[$i]['ds_qtde_hr_semanais'],
                    "t_ic_escala"=>$query[$i]['ic_escala'],
                    "t_convencao_coletiva_pk"=>$query[$i]['convencao_coletiva_pk'],
                    "t_dt_base_categoria"=>$query[$i]['dt_base_categoria'],
                    "t_ds_num_registro_mte"=>$query[$i]['ds_num_registro_mte'],
                    "t_vl_salario_piso_categoria"=>$query[$i]['vl_salario_piso_categoria'],
                    "t_vl_total_proposta"=>$query[$i]['vl_total_proposta'],
                    "t_usuario_responsavel_comercial_pk"=>$query[$i]['usuario_responsavel_comercial_pk'],
                    "t_dt_envio_da_proposta"=>$query[$i]['dt_envio_da_proposta'],
                    "t_dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_obs_motivo_cancelamento"=>$query[$i]['obs_motivo_cancelamento'],
                    "t_obs_proposta"=>$query[$i]['obs_proposta'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ds_usuario_responsavel_comercial"=>$query[$i]['ds_usuario_responsavel_comercial'],
                    "t_ds_usuario_cadastro"=>$query[$i]['ds_usuario_cadastro'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarPropostaDetalhada':{
        
        $resultado = "";
        $query = $propostas_facilitiesdao->listarPropostaDetalhada();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ic_tipo_grupo" => $query[$i]["ic_tipo_grupo"],
                    "ds_nome_grupo" => $query[$i]["ds_nome_grupo"],
                    "ic_status" => $query[$i]["ic_status"],
                    "SubGrupos" => $query[$i]["SubGrupos"],
                    "Itens" => $query[$i]["Itens"]
                );
            }
        }
        else{
            $mysql_data = [];
        }	
        
        break;
    }
    case 'pegarDadosItens':{
        
        $resultado = "";
        $query = $propostas_facilitiesdao->pegarDadosItens();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "grupos" => $query[$i]["grupos"],
                    "SubGrupos" => $query[$i]["SubGrupos"]
                );
            }
        }
        else{
            $mysql_data = [];
        }	
        
        break;
    }
    case 'listarDadosPropostaDetalhada':{
        
        $resultado = "";
        $query = $propostas_facilitiesdao->listarDadosPropostaDetalhada($pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[0]["pk"],
                    "leads_pk"=>$query[0]['leads_pk'],
                    "ic_tipo_proposta"=>$query[0]['ic_tipo_proposta'],
                    "produtos_servicos_pk"=>$query[0]['produtos_servicos_pk'],
                    "ds_qtde_efetivo"=>$query[0]['ds_qtde_efetivo'],
                    "ds_qtde_hr_semanais"=>$query[0]['ds_qtde_hr_semanais'],
                    "ic_escala"=>$query[0]['ic_escala'],
                    "convencao_coletiva_pk"=>$query[0]['convencao_coletiva_pk'],
                    "dt_base_categoria"=>$query[0]['dt_base_categoria'],
                    "ds_num_registro_mte"=>$query[0]['ds_num_registro_mte'],
                    "vl_salario_piso_categoria"=>$query[0]['vl_salario_piso_categoria'],
                    "vl_total_percentual_proposta"=>$query[0]['vl_total_percentual_proposta'],
                    "vl_total_proposta"=>$query[0]['vl_total_proposta'],
                    "ic_status"=>$query[0]['ic_status'],
                    "dadosItens"=>$query[0]['dadosItens']
                );
            }
        }
        else{
            $mysql_data = [];
        }	
        
        break;
    }
    case 'listarImpressaoProposta':{
        
        $resultado = "";
        $query = $propostas_facilitiesdao->listarImpressaoProposta($pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "ds_img_cliente" => $query[$i]["ds_img_cliente"],
                    "ds_conta" => $query[$i]["ds_conta"],
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ic_tipo_proposta"=>$query[$i]['ic_tipo_proposta'],
                    "ds_tipo_proposta"=>$query[$i]['ds_tipo_proposta'],
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "ds_qtde_efetivo"=>$query[$i]['ds_qtde_efetivo'],
                    "ds_qtde_hr_semanais"=>$query[$i]['ds_qtde_hr_semanais'],
                    "ic_escala"=>$query[$i]['ic_escala'],
                    "convencao_coletiva_pk"=>$query[$i]['convencao_coletiva_pk'],
                    "dt_base_categoria"=>$query[$i]['dt_base_categoria'],
                    "ds_num_registro_mte"=>$query[$i]['ds_num_registro_mte'],
                    "vl_salario_piso_categoria"=>$query[$i]['vl_salario_piso_categoria'],
                    "vl_total_percentual_proposta"=>$query[$i]['vl_total_percentual_proposta'],
                    "vl_total_proposta"=>$query[$i]['vl_total_proposta'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "dados_proposta"=>$query[$i]["dados_proposta"]
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

$propostas_facilitiesdao = null;

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
