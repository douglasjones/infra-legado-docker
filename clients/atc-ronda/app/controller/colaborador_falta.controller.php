<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/colaborador_falta.dao.php";
require_once "../model/colaborador_falta.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";




$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$motivo_falta_pk = $arrRequest['motivo_falta_pk'];
$obs = $arrRequest['obs'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$dt_escala = $arrRequest['dt_escala'];
$leads_pk = $arrRequest['leads_pk'];
$colaborador_reserva_pk = $arrRequest['colaborador_reserva_pk'];


$colaborador_faltadao = new colaborador_faltadao();
$colaborador_faltadao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $colaborador_falta = $colaborador_faltadao->carregarPorPk($pk);
        if($colaborador_falta->getpk()>0){
            
            $log_exclusaodao->salvar("colaborador_falta",$colaborador_falta->getpk());
            
            $colaborador_faltadao->excluir($colaborador_falta);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'colaborador_falta nao encontrado';
        }
        break;
    }
    case 'excluirColaborador':{
        
        $resultdo = "";
            $colaborador_falta_pk = $colaborador_faltadao->carregarPorColaboradorPk($colaborador_pk,$dt_escala,$leads_pk);
            if(count($colaborador_falta_pk) > 0){
                for($i = 0; $i < count($colaborador_falta_pk); $i++){
                    
                    $log_exclusaodao->salvar("colaborador_falta",$colaborador_falta_pk[$i]['pk']);
                    
                    $colaborador_faltadao->excluirColaborador($colaborador_falta_pk[$i]['pk']);
                }
            }
            
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        break;
    }
    case 'salvar':{
        
        $colaborador_falta = $colaborador_faltadao->carregarPorPk($pk);
        $colaborador_falta->setmotivo_falta_pk($motivo_falta_pk);
        $colaborador_falta->setobs($obs);
        $colaborador_falta->setcolaborador_pk($colaborador_pk);
        $colaborador_falta->setdt_escala(DataYMD($dt_escala));
        $colaborador_falta->setleads_pk($leads_pk);
        $colaborador_falta->setcolaborador_reserva_pk($colaborador_reserva_pk);

        
        $pk = $colaborador_faltadao->salvar($colaborador_falta);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $colaborador_faltadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "motivo_falta_pk"=>$query[$i]['motivo_falta_pk'],
                    "obs"=>$query[$i]['obs'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "leads_pk"=>$query[$i]['leads_pk']
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
    case 'RelatorioFalta':{
        $colaboradores_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_inicio = $_REQUEST['dt_ini'];
        $dt_fim = $_REQUEST['dt_fim'];
        $resultado = "";
        $dia_semana = "";
        $dia_semana = pegarDiasSemanaDia(DataYMD($dt_inicio));
                
        $query = $colaborador_faltadao->RelatorioFalta($dt_inicio,$dt_fim,$colaboradores_pk,$leads_pk);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_motivo_falta"=>$query[$i]['ds_motivo_falta'],
                    "obs"=>$query[$i]['obs'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "dt_escala"=>$query[$i]['dt_escala'],
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
    case 'listarFaltaColaborador':{
        
        $resultado = "";
        $query = $colaborador_faltadao->listarFaltaColaborador($colaborador_pk,$dt_escala);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "motivo_falta_pk"=>$query[$i]['motivo_falta_pk'],
                    "obs"=>$query[$i]['obs'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "leads_pk"=>$query[$i]['leads_pk']
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
    case 'RelatorioPostoTrabalhoXColaboradorReserva':{
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_escala_ini = $_REQUEST['dt_escala_ini'];
        $dt_escala_fim = $_REQUEST['dt_escala_fim'];
        
        $resultado = "";
        $query = $colaborador_faltadao->RelatorioPostoTrabalhoXColaboradorReserva($colaborador_pk,$leads_pk,$dt_escala_ini,$dt_escala_fim);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_colaborador_reserva"=>$query[$i]['ds_colaborador_reserva'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico']
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
        $query = $colaborador_faltadao->listar_por_motivo_falta_pk($motivo_falta_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "motivo_falta_pk"=>$query[$i]['motivo_falta_pk'],
                    "obs"=>$query[$i]['obs'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "leads_pk"=>$query[$i]['leads_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarFaltaParaPonto':{
        
        $resultado = "";
        $dt_ini = $_REQUEST['dt_ini'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $query = $colaborador_faltadao->listarFaltaParaPonto($dt_ini,$colaborador_pk,$leads_pk);
        $query1 = $colaborador_faltadao->listarFeriasParaPonto($dt_ini,$colaborador_pk,$leads_pk);
        $query2 = $colaborador_faltadao->listarAfastamentoParaPonto($dt_ini,$colaborador_pk,$leads_pk);
        $query3 = $colaborador_faltadao->listarAtestadoParaPonto($dt_ini,$colaborador_pk,$leads_pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "count_ferias" => "",
                        "count_afastamento" => "",
                        "ds_colaborador_ferias" => "",
                        "count_atestado" => "",
                        "count_falta" => count($query),
                        "ds_colaborador_falta" => $query[$i]["ds_colaborador"],
                    );
                }
            }
            else{
                $mysql_data = [];
            }
        }
        else if(count($query1) > 0){
            
            for($i = 0; $i < count($query1); $i++){
                $mysql_data[] = array(
                    "count_falta" => "",
                    "count_afastamento" => "",
                    "ds_colaborador_falta" => "",
                    "count_atestado" => "",
                    "count_ferias" => count($query1),
                    "ds_colaborador_ferias" => $query1[$i]["ds_colaborador"],
                );
            }
        }
        else if(count($query2) > 0){
            
            for($i = 0; $i < count($query2); $i++){
                $mysql_data[] = array(
                    "count_falta" => "",
                    "ds_colaborador_falta" => "",
                    "count_atestado" => "",
                    "count_ferias" => "",
                    "count_afastamento" => count($query2),
                    "ds_colaborador_ferias" => '',
                );
            }
        }
        else if(count($query3) > 0){
            
            for($i = 0; $i < count($query3); $i++){
                $mysql_data[] = array(
                    "count_falta" => "",
                    "ds_colaborador_falta" => "",
                    "count_ferias" => "",
                    "count_afastamento" => "",
                    "count_atestado" => count($query3),
                    "ds_colaborador_ferias" => '',
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
        $query = $colaborador_faltadao->listar_por_motivo_falta_pk($motivo_falta_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_motivo_falta_pk"=>$query[$i]['motivo_falta_pk'],
                    "t_obs"=>$query[$i]['obs'],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_dt_escala"=>$query[$i]['dt_escala'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],

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

$colaborador_faltadao = null;

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
