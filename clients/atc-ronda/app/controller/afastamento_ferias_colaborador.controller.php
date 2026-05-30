<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/afastamento_ferias_colaborador.dao.php";
require_once "../model/afastamento_ferias_colaborador.class.php";

require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$tipo_apontamento = $arrRequest['tipo_apontamento'];
$dt_inicio = $arrRequest['dt_inicio'];
$dt_fim = $arrRequest['dt_fim'];
$ds_obs = $arrRequest['ds_obs'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$leads_pk = $arrRequest['leads_pk'];


$afastamento_ferias_colaboradordao = new afastamento_ferias_colaboradordao();
$afastamento_ferias_colaboradordao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $afastamento_ferias_colaborador = $afastamento_ferias_colaboradordao->carregarPorPk($pk);
        if($afastamento_ferias_colaborador->getpk()>0){
            
            $log_exclusaodao->salvar("afastamento_ferias_colaborador",$afastamento_ferias_colaborador->getpk());
            
            
            $afastamento_ferias_colaboradordao->excluir($afastamento_ferias_colaborador);
            
        
            
            
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'afastamento_ferias_colaborador nao encontrado';
        }
        break;
    }
    case 'excluirColaborador':{
        
        $resultdo = "";
            $colaborador_afastamento_pk = $afastamento_ferias_colaboradordao->carregarPorColaboradorPk($colaborador_pk,$dt_inicio,$tipo_apontamento);
            
            if(count($colaborador_afastamento_pk) > 0){
                for($i = 0; $i < count($colaborador_afastamento_pk); $i++){
                    
                    $log_exclusaodao->salvar("afastamento_ferias_colaborador",$colaborador_afastamento_pk[$i]['pk']);
                    
                    $afastamento_ferias_colaboradordao->excluirPk($colaborador_afastamento_pk[$i]['pk']);
                }
            }
            
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        break;
    }
    case 'salvar':{
        
        $afastamento_ferias_colaborador = $afastamento_ferias_colaboradordao->carregarPorPk($pk);
        $afastamento_ferias_colaborador->settipo_apontamento($tipo_apontamento);
        $afastamento_ferias_colaborador->setdt_inicio(DataYMD($dt_inicio));
        $afastamento_ferias_colaborador->setdt_fim(DataYMD($dt_fim));
        $afastamento_ferias_colaborador->setds_obs($ds_obs);
        $afastamento_ferias_colaborador->setcolaborador_pk($colaborador_pk);
        $afastamento_ferias_colaborador->setleads_pk($leads_pk);

        
        $pk = $afastamento_ferias_colaboradordao->salvar($afastamento_ferias_colaborador);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $afastamento_ferias_colaboradordao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_apontamento"=>$query[$i]['tipo_apontamento'],
                    "dt_inicio"=>$query[$i]['dt_inicio'],
                    "dt_fim"=>$query[$i]['dt_fim'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk']
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
    case 'listarApontamento':{
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $dt_base = $_REQUEST['dt_base'];
        $leads_pk = $_REQUEST['leads_pk'];
        $resultado = "";
        $query = $afastamento_ferias_colaboradordao->listarApontamento($colaborador_pk,$dt_base,$leads_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "tipo_apontamento"=>$query[$i]['tipo_apontamento'],
                    "ds_tipo_apontamento"=>$query[$i]['ds_tipo_apontamento'],
                    "dt_inicio"=>$query[$i]['dt_inicio'],
                    "dt_fim"=>$query[$i]['dt_fim'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk']
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
    case 'listarAfastamentoColaboradores':{
        
        $resultado = "";
        if($colaborador_pk!=""){
            $query = $afastamento_ferias_colaboradordao->listarAfastamentoColaboradores($colaborador_pk);
        
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "tipo_apontamento"=>$query[$i]['tipo_apontamento'],
                        "dt_inicio"=>$query[$i]['dt_inicio'],
                        "dt_fim"=>$query[$i]['dt_fim'],
                        "ds_obs"=>$query[$i]['ds_obs'],
                        "leads_pk"=>$query[$i]['leads_pk'],
                        "colaborador_pk"=>$query[$i]['colaborador_pk']
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
        
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $afastamento_ferias_colaboradordao->listar_por_tipo_apontamento($tipo_apontamento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_apontamento"=>$query[$i]['tipo_apontamento'],
                    "dt_inicio"=>$query[$i]['dt_inicio'],
                    "dt_fim"=>$query[$i]['dt_fim'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk']
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
        $query = $afastamento_ferias_colaboradordao->listar_por_tipo_apontamento($tipo_apontamento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_tipo_apontamento"=>$query[$i]['tipo_apontamento'],
                    "t_dt_inicio"=>$query[$i]['dt_inicio'],
                    "t_dt_fim"=>$query[$i]['dt_fim'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],

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

$afastamento_ferias_colaboradordao = null;

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
