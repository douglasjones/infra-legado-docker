<?
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/ponto_folha_registro.dao.php";
require_once "../model/ponto_folha_registro.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ponto_pk = $arrRequest['ponto_pk'];
$tipo_ponto_pk = $arrRequest['tipo_ponto_pk'];
$dt_hora_ponto = $arrRequest['dt_hora_ponto'];

$ponto_folha_pk = $arrRequest['ponto_folha_pk'];

$colaborador_pk = $arrRequest['colaborador_pk'];
$hr_ini_expediente = $arrRequest['hr_ini_expediente'];
$hr_ini_intervalo = $arrRequest['hr_ini_intervalo'];
$hr_fim_intervalo = $arrRequest['hr_fim_intervalo'];   
$hr_fim_expediente = $arrRequest['hr_fim_expediente'];
$hr_trabalhadas = $arrRequest['hr_trabalhadas'];
$hr_excedentes = $arrRequest['hr_excedentes'];
$hr_faltantes = $arrRequest['hr_faltantes'];
$hr_extra50 = $arrRequest['hr_extra50'];
$hr_extra100 = $arrRequest['hr_extra100'];
$hr_adicional_noturno = $arrRequest['hr_adicional_noturno'];
$obs = $arrRequest['obs'];
$ic_status = $arrRequest['ic_status'];

$ponto_folha_registrodao = new ponto_folha_registrodao();
$ponto_folha_registrodao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){
    case 'excluir':{
        
        $resultdo = "";
        
        $ponto_folha_registro = $ponto_folha_registrodao->carregarPorPk($pk);
        
        if($ponto_folha_registro->getpk()>0){            
            $log_exclusaodao->salvar("ponto_folha_registros",$ponto_folha_registro->getpk());
            
            $ponto_folha_registrodao->excluir($ponto_folha_registro);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'ponto_folha_registro nao encontrado';
        }
        break;
    }
    case 'excluirFolhaColaborador':{
        $ponto_folha_pk = $_REQUEST['ponto_folha_pk']; 
        $colaborador_pk = $_REQUEST['colaborador_pk']; 
        $resultdo = "";
        
        $ponto_folha_registrodao->excluir($ponto_folha_pk,$colaborador_pk);
        $ponto_folha_registrodao->ponto_folha_colaborador($ponto_folha_pk,$colaborador_pk);
        
        $result  = 'success';
        $message = 'Registro excluído com sucesso.';
        break;
    }
    case 'salvar':{   
        
        $ponto_folha_registro = $ponto_folha_registrodao->carregarPorPk($pk);
        $ponto_folha_registro->setponto_folha_pk($ponto_folha_pk);           
        $ponto_folha_registro->setponto_pk($ponto_pk);
        $ponto_folha_registro->settipo_ponto_pk($tipo_ponto_pk);
        $ponto_folha_registro->setdt_hora_ponto($dt_hora_ponto);                        
        $ponto_folha_registro->setcolaborador_pk($colaborador_pk);              
        $ponto_folha_registro->setic_status($ic_status);   
        $ponto_folha_registro->sethr_ini_expediente($hr_ini_expediente);
        $ponto_folha_registro->sethr_ini_intervalo($hr_ini_intervalo);
        $ponto_folha_registro->sethr_fim_intervalo($hr_fim_intervalo);  
        $ponto_folha_registro->sethr_fim_expediente($hr_fim_expediente);
        $ponto_folha_registro->sethr_trabalhadas($hr_trabalhadas);
        $ponto_folha_registro->sethr_excedente($hr_excedentes);
        $ponto_folha_registro->sethr_faltantes($hr_faltantes);
        $ponto_folha_registro->sethr_extra50($hr_extra50);
        $ponto_folha_registro->sethr_extra100($hr_extra100);
        $ponto_folha_registro->sethr_adicional_noturno($hr_adicional_noturno);        
        $ponto_folha_registro->setobs($obs);

        $pk = $ponto_folha_registrodao->salvar($ponto_folha_registro);
              
        $mysql_data[] = array(
                "pk" => $pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPontoFolhaPK':{

        $resultado = "";
        $query = $ponto_folha_registrodao->listarPontoFolhaPK($ponto_folha_pk);
        
        $result  = 'success';
        $message = 'query success';
       
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_ponto_folha_pk" => $query[$i]["ponto_folha_pk"],
                    "t_colaborador_pk" => $query[$i]["colaborador_pk"],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_dt_ult_atualizacao"=>$query[$i]['dt_ult_atualizacao'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_ic_status"=>$query[$i]['ic_status'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    } 
    
    
    
    
    
    //antigo
    case 'listarPk':{
        
        $resultado = "";
        $query = $ponto_folha_registrodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ponto_pk"=>$query[$i]['ponto_pk'],
                    "tipo_ponto_pk"=>$query[$i]['tipo_ponto_pk'],
                    "dt_hora_ponto"=>$query[$i]['dt_hora_ponto'],
                    "tipo_registr_folha"=>$query[$i]['tipo_registr_folha'],
                    "ponto_folha_pk"=>$query[$i]['ponto_folha_pk']
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
        $query = $ponto_folha_registrodao->listar_por_ponto_pk($ponto_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ponto_pk"=>$query[$i]['ponto_pk'],
                    "tipo_ponto_pk"=>$query[$i]['tipo_ponto_pk'],
                    "dt_hora_ponto"=>$query[$i]['dt_hora_ponto'],
                    "tipo_registr_folha"=>$query[$i]['tipo_registr_folha'],
                    "ponto_folha_pk"=>$query[$i]['ponto_folha_pk']
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
        $query = $ponto_folha_registrodao->listar_por_ponto_pk($ponto_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ponto_pk"=>$query[$i]['ponto_pk'],
                    "t_tipo_ponto_pk"=>$query[$i]['tipo_ponto_pk'],
                    "t_dt_hora_ponto"=>$query[$i]['dt_hora_ponto'],
                    "t_tipo_registr_folha"=>$query[$i]['tipo_registr_folha'],
                    "t_ponto_folha_pk"=>$query[$i]['ponto_folha_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }   
    
    
    case "salvar_folha_finalizada":{

        $ponto_folha_registro = $ponto_folha_registrodao->carregarPorPk($ponto_folha_pk);  
        $ponto_folha_registro->setic_status($ic_status);   
        $ponto_folha_registro->setcolaborador_pk($colaborador_pk);
        $ponto_folha_registro->setpk($pk); 
        $pk = $ponto_folha_registrodao->salvar_folha_finalizada($ponto_folha_registro);  
        
            $mysql_data[] = array(
                    "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;

     }
    
    default:{
        break;
    }
}

$ponto_folha_registrodao = null;

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
