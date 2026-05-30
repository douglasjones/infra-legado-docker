<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";

require_once "../model/processo.dao.php";
require_once "../model/processo.class.php";

require_once "../model/processo_default.dao.php";
require_once "../model/processo_default.class.php";

require_once "../model/contrato.class.php";
require_once "../model/contrato.dao.php";

require_once "../model/contrato_item.class.php";
require_once "../model/contrato_item.dao.php";


require_once "../model/processo_default_etapa.dao.php";
require_once "../model/processo_default_etapa.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$leads_pk = $arrRequest['leads_pk'];


$contratodao = new contratodao();
$contratodao->setToken($token);

$contrato_itemdao = new contrato_itemdao();
$contrato_itemdao->setToken($token); 

$processodao = new processodao();
$processodao->setToken($token); 

$processo_defaultdao = new processo_defaultdao();
$processo_defaultdao->setToken($token); 

$processo_default_etapadao = new processo_default_etapadao();
$processo_default_etapadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $processo= $processodao->carregarPorPk($pk);
        $contrato = $contratodao->listar_contrato_lead_processo($leads_pk,$pk);
        
        if(count($contrato) > 0){
            for($i = 0; $i < count($contrato); $i++){
                $contrato_itemdao->excluirPorContrato($contrato[$i]['pk']);
            }
        }
        
        if($processo->getpk()>0){
            $query = $processodao->listarEtapasPorPk($processo->getpk());
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $processodao->excluirContratos($query[$i]["pk"]);
                    $processodao->excluirAgendaColaborador($query[$i]["pk"]);
                }
            }
            $processodao->excluirProcessosEtapasPk($processo->getpk());
            $processodao->excluir($processo);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'processo nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $processo_default= $processo_defaultdao->carregarPorPk($pk);
        
        if($processo_default->getpk()>0){
            $processo = $processodao->carregarPorPk("");
            $processo->setds_processo($processo_default->getds_processo_default());
            
            $processo->setprocessos_default_pk($processo_default->getpk());
            $processo->setleads_pk($leads_pk);
            
            $processo_pk = $processodao->salvar($processo);
        }       
        
        $mysql_data[] = array(
                "pk" => $processo_pk,
                "processos_default_pk" => $processo_default->getpk()
            );
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $processodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_processo"=>$query[$i]['ds_processo'],
                    "processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
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
    case 'listarEtapas':{
        $pk = $_REQUEST['pk'];
        $resultado = "";
        $query = $processodao->listarEtapasPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $v_ds_etapa = htmlentities($query[$i]['etapas']);
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "etapas"=>$v_ds_etapa,
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
    case 'listarEtapasLeads':{
        $leads_pk = $_REQUEST['leads_pk'];
        $resultado = "";
        $query = $processodao->listarEtapasPorLeadsPk($leads_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "processos_pk" => $query[$i]["processos_pk"],
                    "etapas"=>$query[$i]['etapas'],
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
        $query = $processodao->listar_por_ds_processo($ds_processo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_processo"=>$query[$i]['ds_processo'],
                    "processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "leads_pk"=>$query[$i]['leads_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'verificarQtdeLead':{
        
        $resultado = "";
        $query = $processodao->verificarQtdeLead($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "qtde" => $query[$i]["qtde"]
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarProcessoLead':{
        $resultado = "";
        if($leads_pk!=""){
            $query = $processodao->listarPorLeadsPk($leads_pk);
        
            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "t_pk" => $query[$i]["pk"],
                        "t_ds_processo"=>$query[$i]['ds_processo'],
                        "processos_default_pk"=>$query[$i]['processos_default_pk'],
                        "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                        "leads_pk"=>$query[$i]['leads_pk']
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
        $query = $processodao->listar_por_ds_processo($ds_processo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_processo"=>$query[$i]['ds_processo'],
                    "processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],

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

$processodao = null;

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
