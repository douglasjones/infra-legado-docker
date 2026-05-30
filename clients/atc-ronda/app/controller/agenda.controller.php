<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/agenda.dao.php";
require_once "../model/agenda.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$tipo_agendas_pk = $arrRequest['tipo_agendas_pk'];
$dt_ini_agenda_ini = $arrRequest['dt_ini_agenda_ini'];
$dt_hr_agenda_fim = $arrRequest['dt_hr_agenda_fim'];
$ic_lembrete = $arrRequest['ic_lembrete'];
$ic_repetir = $arrRequest['ic_repetir'];
$ds_link_reuniao = $arrRequest['ds_link_reuniao'];
$ds_cep = $arrRequest['ds_cep'];
$ds_endereco = $arrRequest['ds_endereco'];
$ds_complemento = $arrRequest['ds_complemento'];
$ds_numero = $arrRequest['ds_numero'];
$ds_bairro = $arrRequest['ds_bairro'];
$ds_cidade = $arrRequest['ds_cidade'];
$ds_uf = $arrRequest['ds_uf'];
$leads_pk = $arrRequest['leads_pk'];
$ic_status = $arrRequest['ic_status'];
$ds_obs = $arrRequest['ds_obs'];
$agendas_reagendamento_pk = $arrRequest['agendas_reagendamento_pk'];
$ds_obs_reagendamento = $arrRequest['ds_obs_reagendamento'];
$dt_ini_agenda = $arrRequest['dt_ini_agenda'];
$hr_ini_agenda = $arrRequest['hr_ini_agenda'];
$dt_fim_agenda = $arrRequest['dt_fim_agenda'];
$hr_fim_agenda = $arrRequest['hr_fim_agenda'];
$doc_agenda = $arrRequest['doc_agenda'];
$participantes_agenda = $arrRequest['participantes_agenda'];
$motivo_cancelameto_pk = $arrRequest['motivo_cancelameto_pk'];
$classificacao_pk = $arrRequest['classificacao_pk'];
$obs_classificacao = $arrRequest['obs_classificacao'];


$agendadao = new agendadao();
$agendadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $agenda = $agendadao->carregarPorPk($pk);
        if($agenda->getpk()>0){
            $agendadao->excluir($agenda);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'agenda nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $agenda = $agendadao->carregarPorPk($pk);
        $agenda->settipo_agendas_pk($tipo_agendas_pk);
        $agenda->setdt_ini_agenda_ini(DataYMD($dt_ini_agenda)." ".$hr_ini_agenda.":00");
        $agenda->setdt_hr_agenda_fim(DataYMD($dt_fim_agenda)." ".$hr_fim_agenda.":00");
        $agenda->setic_lembrete($ic_lembrete);
        $agenda->setic_repetir($ic_repetir);
        $agenda->setds_link_reuniao($ds_link_reuniao);
        $agenda->setds_cep($ds_cep);
        $agenda->setds_endereco($ds_endereco);
        $agenda->setds_complemento($ds_complemento);
        $agenda->setds_numero($ds_numero);
        $agenda->setds_bairro($ds_bairro);
        $agenda->setds_cidade($ds_cidade);
        $agenda->setds_uf($ds_uf);
        $agenda->setleads_pk($leads_pk);
        $agenda->setic_status($ic_status);
        $agenda->setds_obs($ds_obs);
        $agenda->setagendas_reagendamento_pk($agendas_reagendamento_pk);
        $agenda->setds_obs_reagendamento($ds_obs_reagendamento);
        $agenda->setmotivo_cancelameto_pk($motivo_cancelameto_pk);
        $agenda->setclassificacao_pk($classificacao_pk);
        $agenda->setobs_classificacao($obs_classificacao);
        
        $pk = $agendadao->salvar($agenda, $doc_agenda, $participantes_agenda, $token);
        
        $mysql_data[] = array(
            "pk" => $pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $agendadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_agendas_pk"=>$query[$i]['tipo_agendas_pk'],
                    "dt_agenda_ini"=>$query[$i]['dt_agenda_ini'],
                    "hr_agenda_ini"=>$query[$i]['hr_agenda_ini'],
                    "dt_agenda_fim"=>$query[$i]['dt_agenda_fim'],
                    "hr_agenda_fim"=>$query[$i]['hr_agenda_fim'],
                    "ic_lembrete"=>$query[$i]['ic_lembrete'],
                    "ic_repetir"=>$query[$i]['ic_repetir'],
                    "ds_link_reuniao"=>$query[$i]['ds_link_reuniao'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "agendas_reagendamento_pk"=>$query[$i]['agendas_reagendamento_pk'],
                    "ds_obs_reagendamento"=>$query[$i]['ds_obs_reagendamento'],
                    "motivo_cancelameto_pk"=>$query[$i]['motivo_cancelameto_pk'],
                    "obs_classificacao"=>$query[$i]['obs_classificacao'],
                    "classificacao_pk"=>$query[$i]['classificacao_pk']
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
        $query = $agendadao->listar_por_tipo_agendas_pk($tipo_agendas_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_agendas_pk"=>$query[$i]['tipo_agendas_pk'],
                    "dt_ini_agenda_ini"=>$query[$i]['dt_ini_agenda_ini'],
                    "dt_hr_agenda_fim"=>$query[$i]['dt_hr_agenda_fim'],
                    "ic_lembrete"=>$query[$i]['ic_lembrete'],
                    "ic_repetir"=>$query[$i]['ic_repetir'],
                    "ds_link_reuniao"=>$query[$i]['ds_link_reuniao'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "agendas_reagendamento_pk"=>$query[$i]['agendas_reagendamento_pk'],
                    "ds_obs_reagendamento"=>$query[$i]['ds_obs_reagendamento']
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
        $query = $agendadao->listarTodosPorLeadsPk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_tipo_agendas"=>$query[$i]['ds_tipo_agendas'],
                    "t_ds_usuario"=>$query[$i]['ds_usuario'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_dt_ini_agenda_ini"=>$query[$i]['dt_ini_agenda_ini'],
                    "t_dt_hr_agenda_fim"=>$query[$i]['dt_hr_agenda_fim'],
                    "t_ic_lembrete"=>$query[$i]['ic_lembrete'],
                    "t_ic_repetir"=>$query[$i]['ic_repetir'],
                    "t_ds_link_reuniao"=>$query[$i]['ds_link_reuniao'],
                    "t_ds_cep"=>$query[$i]['ds_cep'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_complemento"=>$query[$i]['ds_complemento'],
                    "t_ds_numero"=>$query[$i]['ds_numero'],
                    "t_ds_bairro"=>$query[$i]['ds_bairro'],
                    "t_ds_cidade"=>$query[$i]['ds_cidade'],
                    "t_ds_uf"=>$query[$i]['ds_uf'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_agendas_reagendamento_pk"=>$query[$i]['agendas_reagendamento_pk'],
                    "t_ds_obs_reagendamento"=>$query[$i]['ds_obs_reagendamento'],

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

$agendadao = null;

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
