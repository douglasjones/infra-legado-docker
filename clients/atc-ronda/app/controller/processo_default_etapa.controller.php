<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/processo_default_etapa.dao.php";
require_once "../model/processo_default_etapa.class.php";
require_once "../model/processo_default_configuracao.dao.php";
require_once "../model/processo_default_configuracao.class.php";
require_once "../model/processo_default_grupos.dao.php";
require_once "../model/processo_default_grupos.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_processo_default_etapa = $arrRequest['ds_processo_default_etapa'];
$n_ordem_etapa = $arrRequest['n_ordem_etapa'];
$processos_default_pk = $arrRequest['processos_default_pk'];
$ds_processo_default_configuracao = $arrRequest['ds_processo_default_configuracao'];
$ds_cor = $arrRequest['ds_cor'];
$tempo_execucao_pk = $arrRequest['tempo_execucao_pk'];
$tipos_ocorrencias_pk = $arrRequest['tipos_ocorrencias_pk'];
$processos_default_modulos_pk = $arrRequest['processos_default_modulos_pk'];
$ic_status = $arrRequest['ic_status'];
$processo_default_configuracao_pk = $arrRequest['processo_default_configuracao_pk'];
$processos_default_modulos_obrigatorio_pk = $arrRequest['processos_default_modulos_obrigatorio_pk'];
$obs = $arrRequest['obs'];
$arrProcesso_default_configuracao = $arrRequest['arrProcesso_default_configuracao'];
$processo_default_grupos_pk = $arrRequest['processo_default_grupos_pk'];

$processo_default_etapadao = new processo_default_etapadao();
$processo_default_etapadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $processo_default_etapa = $processo_default_etapadao->carregarPorPk($pk);
        if($processo_default_etapa->getpk()>0){
            
            $processo_default_etapadao->excluir($processo_default_etapa);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'processo_default_etapa nao encontrado';
        }
        break;
    }
    case 'salvar':{

        $processo_default_configuracaodao = new processo_default_configuracaodao();
        $processo_default_configuracaodao->setToken($token); 
        
        $processo_default_etapa = $processo_default_etapadao->carregarPorPk($pk);
        $processo_default_etapa->setds_processo_default_etapa($ds_processo_default_etapa);
        $processo_default_etapa->setn_ordem_etapa($n_ordem_etapa);
        $processo_default_etapa->setprocessos_default_pk($processos_default_pk);
        $processo_default_etapa->setequipes_pk($equipes_pk);
        $pk = $processo_default_etapadao->salvar($processo_default_etapa);

        if($pk != ""){
            $processo_default_configuracao = $processo_default_configuracaodao->carregarPorPk($processo_default_configuracao_pk);
            $processo_default_configuracao->setprocessos_default_pk($processos_default_pk);
            $processo_default_configuracao->setprocessos_default_etapas_pk($pk);
            $processo_default_configuracao->setds_processo_default_configuracao($ds_processo_default_configuracao);
            $processo_default_configuracao->setds_cor($ds_cor);
            $processo_default_configuracao->settempo_execucao_pk($tempo_execucao_pk);
            $processo_default_configuracao->settipos_ocorrencias_pk($tipos_ocorrencias_pk);
            $processo_default_configuracao->setprocessos_default_modulos_pk($processos_default_modulos_pk);
            $processo_default_configuracao->setprocessos_default_modulos_obrigatorio_pk($processos_default_modulos_obrigatorio_pk);
            $processo_default_configuracao->setic_status($ic_status);
            $processo_default_configuracao_pk = $processo_default_configuracaodao->salvar($processo_default_configuracao, $processo_default_grupos_pk);

        }
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $processo_default_etapadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_processo_default_etapa"=>$query[$i]['ds_processo_default_etapa'],
                    "n_ordem_etapa"=>$query[$i]['n_ordem_etapa'],
                    "processos_default_pk"=>$query[$i]['processos_default_pk']
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
    case 'listarProcessoDefaultPk':{
        $processo_default_pk = $_REQUEST['processo_default_pk'];
        $resultado = "";
        $query = $processo_default_etapadao->listar_por_processo_default_pk($processo_default_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "t_ds_processo_default_etapa"=>$query[$i]['ds_processo_default_etapa'],
                    "t_n_ordem_etapa"=>$query[$i]['n_ordem_etapa'],
                    "t_processos_default_pk"=>$query[$i]['processos_default_pk']
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
        $query = $processo_default_etapadao->listar_por_ds_processo_default_etapas($ds_processo_default_etapas);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_processo_default_etapas"=>$query[$i]['ds_processo_default_etapa'],
                    "t_n_ordem_etapa"=>$query[$i]['n_ordem_etapa'],
                    "t_processos_default_pk"=>$query[$i]['processos_default_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'carregarBoxes':{
        
        
        $resultado = "";
        $query = $processo_default_etapadao->carregarBoxes();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_processo_default_etapas"=>$query[$i]['ds_processo_default_etapa'],
                    "t_n_ordem_etapa"=>$query[$i]['n_ordem_etapa'],
                    "t_processos_default_pk"=>$query[$i]['processos_default_pk'],

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

$processo_default_etapadao = null;

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
