<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/agendas_participantes.dao.php";
require_once "../model/agendas_participantes.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ic_tipo_participante = $arrRequest['ic_tipo_participante'];
$participante_pk = $arrRequest['participante_pk'];
$ds_email = $arrRequest['ds_email'];
$ds_cel = $arrRequest['ds_cel'];
$agendas_pk = $arrRequest['agendas_pk'];
$leads_pk = $arrRequest['leads_pk'];

$agendas_participantesdao = new agendas_participantesdao();
$agendas_participantesdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $agendas_participantes = $agendas_participantesdao->carregarPorPk($pk);
        if($agendas_participantes->getpk()>0){
            
            $agendas_participantesdao->excluir($agendas_participantes);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'agendas_participantes nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $agendas_participantes = $agendas_participantesdao->carregarPorPk($pk);
        $agendas_participantes->setic_tipo_participante($ic_tipo_participante);
        $agendas_participantes->setparticipante_pk($participante_pk);
        $agendas_participantes->setds_email($ds_email);
        $agendas_participantes->setds_cel($ds_cel);
        $agendas_participantes->setagendas_pk($agendas_pk);

        
        $pk = $agendas_participantesdao->salvar($agendas_participantes);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $agendas_participantesdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ic_tipo_participante"=>$query[$i]['ic_tipo_participante'],
                    "participante_pk"=>$query[$i]['participante_pk'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
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
    case 'carregarParicipantes':{
        
        $resultado = "";
        $query = $agendas_participantesdao->carregarParicipantes($ic_tipo_participante, $leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "ds_participante"=>$query[$i]['ds_participante'],
                    "participante_pk"=>$query[$i]['participante_pk'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'carregarParicipantePorParticipantePk':{
        $resultado = "";
        $query = $agendas_participantesdao->listar_por_participante_pk($ic_tipo_participante, $participante_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "ds_participante"=>$query[$i]['ds_participante'],
                    "participante_pk"=>$query[$i]['pk'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel']
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
        $query = $agendas_participantesdao->listar_por_agendas_pk($agendas_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ic_tipo_participante"=>$query[$i]['ic_tipo_participante'],
                    "t_participante_pk"=>$query[$i]['participante_pk'],
                    "t_ds_participante"=>$query[$i]['ds_participante'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
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
    default:{
        break;
    }
}

$agendas_participantesdao = null;

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
