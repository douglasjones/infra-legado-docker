<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/processo_default_configuracao.dao.php";
require_once "../model/processo_default_configuracao.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$processos_default_pk = $arrRequest['processos_default_pk'];
$processo_default_pk = $arrRequest['processo_default_pk'];
$processos_default_etapas_pk = $arrRequest['processos_default_etapas_pk'];
$ds_processo_default_configuracao = $arrRequest['ds_processo_default_configuracao'];
$n_ordem = $arrRequest['n_ordem'];
$ds_cor = $arrRequest['ds_cor'];
$tempo_execucao_pk = $arrRequest['tempo_execucao_pk'];
$tipos_ocorrencias_pk = $arrRequest['tipos_ocorrencias_pk'];
$processos_default_modulos_pk = $arrRequest['processos_default_modulos_pk'];
$processos_default_modulos_obrigatorio_pk = $arrRequest['processos_default_modulos_obrigatorio_pk'];
$ic_status = $arrRequest['ic_status'];
$ds_processo_default = $arrRequest['ds_processo_default'];


$processo_default_configuracaodao = new processo_default_configuracaodao();
$processo_default_configuracaodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $processo_default_configuracao = $processo_default_configuracaodao->carregarPorPk($pk);
        if($processo_default_configuracao->getpk()>0){
            
            $processo_default_configuracaodao->excluir($processo_default_configuracao);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'processo_default_configuracao nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $processo_default_configuracao = $processo_default_configuracaodao->carregarPorPk($pk);
        $processo_default_configuracao->setprocessos_default_pk($processos_default_pk);
        $processo_default_configuracao->setprocessos_default_etapas_pk($processos_default_etapas_pk);
        $processo_default_configuracao->setds_processo_default_configuracao($ds_processo_default_configuracao);
        $processo_default_configuracao->setds_cor($ds_cor);
        $processo_default_configuracao->settempo_execucao_pk($tempo_execucao_pk);
        $processo_default_configuracao->settipos_ocorrencias_pk($tipos_ocorrencias_pk);
        $processo_default_configuracao->setprocessos_default_modulos_pk($processos_default_modulos_pk);
        $processo_default_configuracao->setprocessos_default_modulos_obrigatorio_pk($processos_default_modulos_obrigatorio_pk);
        $processo_default_configuracao->setic_status($ic_status);
        
        $pk = $processo_default_configuracaodao->salvar($processo_default_configuracao);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $processo_default_configuracaodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "processos_default_etapas_pk"=>$query[$i]['processos_default_etapas_pk'],
                    "ds_processo_default_configuracao"=>$query[$i]['ds_processo_default_configuracao'],
                    "n_ordem"=>$query[$i]['n_ordem'],
                    "ds_cor"=>$query[$i]['ds_cor'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "tempo_execucao_pk"=>$query[$i]['tempo_execucao_pk'],
                    "tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "processos_default_modulos_pk"=>$query[$i]['processos_default_modulos_pk'],
                    "processos_default_modulos_obrigatorio_pk"=>$query[$i]['processos_default_modulos_obrigatorio_pk'],
                    "ds_processo_default_etapa"=>$query[$i]['ds_processo_default_etapa'],
                    "gruposAcesso"=>$query[$i]['gruposAcesso']
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
        $query = $processo_default_configuracaodao->listar_por_processos_default_pk($processos_default_pk, $ds_processo_default_configuracao, $ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "processos_default_etapas_pk"=>$query[$i]['processos_default_etapas_pk'],
                    "ds_processo_default_configuracao"=>$query[$i]['ds_processo_default_configuracao'],
                    "n_ordem"=>$query[$i]['n_ordem'],
                    "ds_cor"=>$query[$i]['ds_cor'],
                    "tempo_execucao_pk"=>$query[$i]['tempo_execucao_pk'],
                    "tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "processos_default_modulos_pk"=>$query[$i]['processos_default_modulos_pk'],
                    "processos_default_modulos_obrigatorio_pk"=>$query[$i]['processos_default_modulos_obrigatorio_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarTodos':{
        
        $resultado = "";
        $query = $processo_default_configuracaodao->listar_por_processos_default_pk($processos_default_pk, $ds_processo_default_configuracao, $ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "processos_default_etapas_pk"=>$query[$i]['processos_default_etapas_pk'],
                    "ds_processo_default_configuracao"=>$query[$i]['ds_processo_default_configuracao'],
                    "n_ordem"=>$query[$i]['n_ordem'],
                    "ds_cor"=>$query[$i]['ds_cor'],
                    "tempo_execucao_pk"=>$query[$i]['tempo_execucao_pk'],
                    "tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "processos_default_modulos_pk"=>$query[$i]['processos_default_modulos_pk'],
                    "processos_default_modulos_obrigatorio_pk"=>$query[$i]['processos_default_modulos_obrigatorio_pk']
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
        $query = $processo_default_configuracaodao->listar_por_processos_default_pk($processos_default_pk, $ds_processo_default_configuracao, $ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "t_processos_default_etapas_pk"=>$query[$i]['processos_default_etapas_pk'],
                    "t_ds_processo_default_configuracao"=>$query[$i]['ds_processo_default_configuracao'],
                    "t_n_ordem"=>$query[$i]['n_ordem_etapa'],
                    "t_ds_cor"=>$query[$i]['ds_cor'],
                    "t_tempo_execucao_pk"=>$query[$i]['tempo_execucao_pk'],
                    "t_tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "t_processos_default_modulos_pk"=>$query[$i]['processos_default_modulos_pk'],
                    "t_processos_default_modulos_obrigatorio_pk"=>$query[$i]['processos_default_modulos_obrigatorio_pk'],
                    "t_ds_processo_default_etapa"=>$query[$i]['ds_processo_default_etapa'],
                    "t_ic_status"=>$query[$i]['ds_status'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'carregarCaixasECards':{
        
        
        $resultado = "";
        $query = $processo_default_configuracaodao->carregarCaixasECards($ds_processo_default);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "processos_default_etapas_pk"=>$query[$i]['processos_default_etapas_pk'],
                    "ds_processo_default_configuracao"=>$query[$i]['ds_processo_default_configuracao'],
                    "n_ordem"=>$query[$i]['n_ordem'],
                    "ds_cor"=>$query[$i]['ds_cor'],
                    "tempo_execucao_pk"=>$query[$i]['tempo_execucao_pk'],
                    "tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "processos_default_modulos_pk"=>$query[$i]['processos_default_modulos_pk'],
                    "processos_default_modulos_obrigatorio_pk"=>$query[$i]['processos_default_modulos_obrigatorio_pk'],
                    "arrMovimentacao"=>$query[$i]['arrMovimentacao']
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarModulosProcessoDefaultPk':{
        
        
        $resultado = "";
        $query = $processo_default_configuracaodao->listarModulosProcessoDefaultPk($processo_default_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "modulos_pk" => $query[$i]["modulos_pk"],
                    "n_ordem"=>$query[$i]['n_ordem']
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

$processo_default_configuracaodao = null;

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
