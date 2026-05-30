<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/supervisao_auditoria.dao.php";
require_once "../model/supervisao_auditoria.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$leads_pk = $arrRequest['leads_pk'];
$auditorias_categorias_pk = $arrRequest['auditorias_categorias_pk'];
$auditorias_categorias_tipos_pk = $arrRequest['auditorias_categorias_tipos_pk'];
$dt_agendamento = $arrRequest['dt_agendamento'];
$usuario_agendamento_pk = $arrRequest['usuario_agendamento_pk'];
$dt_execucao = $arrRequest['dt_execucao'];
$usuario_execucao_pk = $arrRequest['usuario_execucao_pk'];
$ic_contato_cliente = $arrRequest['ic_contato_cliente'];
$obs_contato_cliente = $arrRequest['obs_contato_cliente'];
$obs_geral = $arrRequest['obs_geral'];
$ds_localizacao = $arrRequest['ds_localizacao'];
$dt_ini = $arrRequest['dt_ini'];
$dt_fim = $arrRequest['dt_fim'];
$supervisores_pk = $arrRequest['supervisores_pk'];
//var_dump($_REQUEST);

$supervisao_auditoriadao = new supervisao_auditoriadao();
$supervisao_auditoriadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $supervisao_auditoria = $supervisao_auditoriadao->carregarPorPk($pk);
        if($supervisao_auditoria->getpk()>0){
            
            $supervisao_auditoriadao->excluir($supervisao_auditoria);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'supervisao_auditoria nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $supervisao_auditoria = $supervisao_auditoriadao->carregarPorPk($pk);
        $supervisao_auditoria->setleads_pk($leads_pk);
        $supervisao_auditoria->setauditorias_categorias_pk($auditorias_categorias_pk);
        $supervisao_auditoria->setauditorias_categorias_tipos_pk($auditorias_categorias_tipos_pk);
        $supervisao_auditoria->setdt_agendamento($dt_agendamento);
        $supervisao_auditoria->setusuario_agendamento_pk($usuario_agendamento_pk);
        $supervisao_auditoria->setdt_execucao($dt_execucao);
        $supervisao_auditoria->setusuario_execucao_pk($usuario_execucao_pk);
        $supervisao_auditoria->setic_contato_cliente($ic_contato_cliente);
        $supervisao_auditoria->setobs_contato_cliente($obs_contato_cliente);
        $supervisao_auditoria->setobs_geral($obs_geral);
        $supervisao_auditoria->setds_localizacao($ds_localizacao);

        
        $pk = $supervisao_auditoriadao->salvar($supervisao_auditoria);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $supervisao_auditoriadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "auditorias_categorias_pk"=>$query[$i]['auditorias_categorias_pk'],
                    "auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "dt_agendamento"=>$query[$i]['dt_agendamento'],
                    "usuario_agendamento_pk"=>$query[$i]['usuario_agendamento_pk'],
                    "dt_execucao"=>$query[$i]['dt_execucao'],
                    "usuario_execucao_pk"=>$query[$i]['usuario_execucao_pk'],
                    "ic_contato_cliente"=>$query[$i]['ic_contato_cliente'],
                    "obs_contato_cliente"=>$query[$i]['obs_contato_cliente'],
                    "obs_geral"=>$query[$i]['obs_geral'],
                    "ds_localizacao"=>$query[$i]['ds_localizacao']
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
        $query = $supervisao_auditoriadao->listar_por_leads_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "auditorias_categorias_pk"=>$query[$i]['auditorias_categorias_pk'],
                    "auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "dt_agendamento"=>$query[$i]['dt_agendamento'],
                    "usuario_agendamento_pk"=>$query[$i]['usuario_agendamento_pk'],
                    "dt_execucao"=>$query[$i]['dt_execucao'],
                    "usuario_execucao_pk"=>$query[$i]['usuario_execucao_pk'],
                    "ic_contato_cliente"=>$query[$i]['ic_contato_cliente'],
                    "obs_contato_cliente"=>$query[$i]['obs_contato_cliente'],
                    "obs_geral"=>$query[$i]['obs_geral'],
                    "ds_localizacao"=>$query[$i]['ds_localizacao']
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
        $query = $supervisao_auditoriadao->listar_por_leads_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "auditorias_categorias_pk"=>$query[$i]['auditorias_categorias_pk'],
                    "auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "dt_agendamento"=>$query[$i]['dt_agendamento'],
                    "usuario_agendamento_pk"=>$query[$i]['usuario_agendamento_pk'],
                    "dt_execucao"=>$query[$i]['dt_execucao'],
                    "usuario_execucao_pk"=>$query[$i]['usuario_execucao_pk'],
                    "ic_contato_cliente"=>$query[$i]['ic_contato_cliente'],
                    "obs_contato_cliente"=>$query[$i]['obs_contato_cliente'],
                    "obs_geral"=>$query[$i]['obs_geral'],
                    "ds_localizacao"=>$query[$i]['ds_localizacao'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_categoria"=>$query[$i]['ds_categoria'],
                    "ds_tipo_categoria"=>$query[$i]['ds_auditoria_categoria_tipo'],
                    "dt_execucao"=>$query[$i]['dt_execucao'],
                    "dt_usuario"=>$query[$i]['dt_usuario'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
   case 'listarComboSupervisores':{        
        $resultado = "";
        $query = $supervisao_auditoriadao->listarComboSupervisores();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "supervisores_pk" => $query[$i]["usuario_execucao_pk"],
                    "ds_supervisor" => $query[$i]["ds_usuario"],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }  
    case 'listarDadosRelSupervisao':{

        if($dt_ini!=""){
            $dt_ini = dataYMD($dt_ini);
            $dt_fim = dataYMD($dt_fim);
        }
        
        $resultado = "";
        $query = $supervisao_auditoriadao->listarDadosRelSupervisao($leads_pk, $dt_ini, $dt_fim, $supervisores_pk, $auditorias_categorias_pk, $auditorias_categorias_tipos_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_usuario_cadastro"=>$query[$i]['ds_usuario_cadastro'],
                    "ds_categoria"=>$query[$i]['ds_categoria'],
                    "ds_auditoria_categoria_tipo"=>$query[$i]['ds_auditoria_categoria_tipo'],
                    "supervisao_auditorias_pk"=>$query[$i]['pk'],
                    "auditoria_categoria_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "ds_supervisor"=>$query[$i]['ds_supervisor'],
                    "obs_geral"=>$query[$i]['obs_geral'],
                    "ds_localizacao"=>$query[$i]['ds_localizacao']
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
    default:{
        break;
    }
}

$supervisao_auditoriadao = null;

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
