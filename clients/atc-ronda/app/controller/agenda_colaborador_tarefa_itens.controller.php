<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/agenda_colaborador_tarefa_itens.dao.php";
require_once "../model/agenda_colaborador_tarefa_itens.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$agenda_colaborador_tarefa_pk = $arrRequest['agenda_colaborador_tarefa_pk'];
$tarefas_area_pk = $arrRequest['tarefas_area_pk'];
$tarefas_tipos_servicos_pk = $arrRequest['tarefas_tipos_servicos_pk'];
$ic_dom = $arrRequest['ic_dom'];
$ic_seg = $arrRequest['ic_seg'];
$ic_ter = $arrRequest['ic_ter'];
$ic_qua = $arrRequest['ic_qua'];
$ic_qui = $arrRequest['ic_qui'];
$ic_sex = $arrRequest['ic_sex'];
$ic_sab = $arrRequest['ic_sab'];
$obs = $arrRequest['obs'];
$dt_ini_execucao = $arrRequest['dt_ini_execucao'];
$dt_fim_execucao = $arrRequest['dt_fim_execucao'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$obs_execucao = $arrRequest['obs_execucao'];
$tarefas_local_pk = $arrRequest['tarefas_local_pk'];
$ds_qrcode = $arrRequest['ds_qrcode'];
$hr_ini_dom = $arrRequest['hr_ini_dom'];
$hr_ini_seg = $arrRequest['hr_ini_seg'];
$hr_ini_ter = $arrRequest['hr_ini_ter'];
$hr_ini_qua = $arrRequest['hr_ini_qua'];
$hr_ini_qui = $arrRequest['hr_ini_qui'];
$hr_ini_sex = $arrRequest['hr_ini_sex'];
$hr_ini_sab = $arrRequest['hr_ini_sab'];
$hr_fim_dom = $arrRequest['hr_fim_dom'];
$hr_fim_seg = $arrRequest['hr_fim_seg'];
$hr_fim_ter = $arrRequest['hr_fim_ter'];
$hr_fim_qua = $arrRequest['hr_fim_qua'];
$hr_fim_qui = $arrRequest['hr_fim_qui'];
$hr_fim_sex = $arrRequest['hr_fim_sex'];
$hr_fim_sab = $arrRequest['hr_fim_sab'];

$colaborador_exec_ini_pk = $arrRequest['colaborador_exec_ini_pk'];
$colaborador_exec_fim_pk = $arrRequest['colaborador_exec_fim_pk'];



$agenda_colaborador_tarefa_itensdao = new agenda_colaborador_tarefa_itensdao();
$agenda_colaborador_tarefa_itensdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";

        $agenda_colaborador_tarefa_itens = $agenda_colaborador_tarefa_itensdao->carregarPorPk($pk);
        if($agenda_colaborador_tarefa_itens->getpk()>0){
            
            $agenda_colaborador_tarefa_itensdao->excluir($agenda_colaborador_tarefa_itens);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'agenda_colaborador_tarefa_itens nao encontrado';
        }
        break;
    }
    case 'salvar':{
      
        $agenda_colaborador_tarefa_itens = $agenda_colaborador_tarefa_itensdao->carregarPorPk($pk);
        $agenda_colaborador_tarefa_itens->setagenda_colaborador_tarefa_pk($agenda_colaborador_tarefa_pk);
        $agenda_colaborador_tarefa_itens->settarefas_area_pk($tarefas_area_pk);
        $agenda_colaborador_tarefa_itens->settarefas_tipos_servicos_pk($tarefas_tipos_servicos_pk);
        $agenda_colaborador_tarefa_itens->setic_dom($ic_dom);
        $agenda_colaborador_tarefa_itens->setic_seg($ic_seg);
        $agenda_colaborador_tarefa_itens->setic_ter($ic_ter);
        $agenda_colaborador_tarefa_itens->setic_qua($ic_qua);
        $agenda_colaborador_tarefa_itens->setic_qui($ic_qui);
        $agenda_colaborador_tarefa_itens->setic_sex($ic_sex);
        $agenda_colaborador_tarefa_itens->setic_sab($ic_sab);
        $agenda_colaborador_tarefa_itens->setobs($obs);
        $agenda_colaborador_tarefa_itens->setdt_ini_execucao($dt_ini_execucao);
        $agenda_colaborador_tarefa_itens->setdt_fim_execucao($dt_fim_execucao);
        $agenda_colaborador_tarefa_itens->setcolaborador_pk($colaborador_pk);
        $agenda_colaborador_tarefa_itens->setobs_execucao($obs_execucao);
        $agenda_colaborador_tarefa_itens->settarefas_local_pk($tarefas_local_pk);
        $agenda_colaborador_tarefa_itens->setds_qrcode($ds_qrcode);
        $agenda_colaborador_tarefa_itens->sethr_ini_dom($hr_ini_dom);
        $agenda_colaborador_tarefa_itens->sethr_ini_seg($hr_ini_seg);
        $agenda_colaborador_tarefa_itens->sethr_ini_ter($hr_ini_ter);
        $agenda_colaborador_tarefa_itens->sethr_ini_qua($hr_ini_qua);
        $agenda_colaborador_tarefa_itens->sethr_ini_qui($hr_ini_qui);
        $agenda_colaborador_tarefa_itens->sethr_ini_sex($hr_ini_sex);
        $agenda_colaborador_tarefa_itens->sethr_ini_sab($hr_ini_sab);
        $agenda_colaborador_tarefa_itens->sethr_fim_dom($hr_fim_dom);
        $agenda_colaborador_tarefa_itens->sethr_fim_seg($hr_fim_seg);
        $agenda_colaborador_tarefa_itens->sethr_fim_ter($hr_fim_ter);
        $agenda_colaborador_tarefa_itens->sethr_fim_qua($hr_fim_qua);
        $agenda_colaborador_tarefa_itens->sethr_fim_qui($hr_fim_qui);
        $agenda_colaborador_tarefa_itens->sethr_fim_sex($hr_fim_sex);
        $agenda_colaborador_tarefa_itens->sethr_fim_sab($hr_fim_sab);
        
        $agenda_colaborador_tarefa_itens->setcolaborador_exec_ini_pk($colaborador_exec_ini_pk);
        $agenda_colaborador_tarefa_itens->setcolaborador_exec_fim_pk($colaborador_exec_fim_pk);

        $pk = $agenda_colaborador_tarefa_itensdao->salvar($agenda_colaborador_tarefa_itens);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPkTarefas':{
       
        if(!empty($agenda_colaborador_tarefa_pk)){
            $resultado = "";
            $query = $agenda_colaborador_tarefa_itensdao->listarPkTarefas($agenda_colaborador_tarefa_pk);

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                                      
                    
                    
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],
                        "ds_tarefa" => $query[$i]["ds_tarefa"],
                        "ds_lead" => $query[$i]["ds_lead"],
                        "leads_pk" => $query[$i]["leads_pk"],                    
                        "ds_local" => $query[$i]["ds_local"],
                        "tarefas_local_pk"=>$query[$i]['tarefas_local_pk'],
                        "ds_area" => $query[$i]["ds_area"],
                        "tarefas_area_pk"=>$query[$i]['tarefas_area_pk'],
                        "ds_colaborador"=>$query[$i]['ds_colaborador'],
                        "colaborador_pk"=>$query[$i]['colaborador_pk'],
                        "ds_tarefa_tipo_servico"=>$query[$i]['ds_tarefa_tipo_servico'], 
                        "tarefas_tipos_servicos_pk"=>$query[$i]['tarefas_tipos_servicos_pk'],
                        "obs"=>$query[$i]['obs'],
                        "ds_dias_hr"=>$ds_dias_hr,
                        "ic_dom"=>$query[$i]['ic_dom'],
                        "ic_seg"=>$query[$i]['ic_seg'],
                        "ic_ter"=>$query[$i]['ic_ter'],
                        "ic_qua"=>$query[$i]['ic_qua'],
                        "ic_qui"=>$query[$i]['ic_qui'],
                        "ic_sex"=>$query[$i]['ic_sex'],
                        "ic_sab"=>$query[$i]['ic_sab'],
                        "dt_ini_execucao"=>$query[$i]['dt_ini_execucao'],
                        "dt_fim_execucao"=>$query[$i]['dt_fim_execucao'],
                        "obs_execucao"=>$query[$i]['obs_execucao'],                    
                        "ds_qrcode"=>$query[$i]['ds_qrcode'],
                        "hr_ini_dom"=>$query[$i]['hr_ini_dom'],
                        "hr_ini_seg"=>$query[$i]['hr_ini_seg'],
                        "hr_ini_ter"=>$query[$i]['hr_ini_ter'],
                        "hr_ini_qua"=>$query[$i]['hr_ini_qua'],
                        "hr_ini_qui"=>$query[$i]['hr_ini_qui'],
                        "hr_ini_sex"=>$query[$i]['hr_ini_sex'],
                        "hr_ini_sab"=>$query[$i]['hr_ini_sab'],
                        "hr_fim_dom"=>$query[$i]['hr_fim_dom'],
                        "hr_fim_seg"=>$query[$i]['hr_fim_seg'],
                        "hr_fim_ter"=>$query[$i]['hr_fim_ter'],
                        "hr_fim_qua"=>$query[$i]['hr_fim_qua'],
                        "hr_fim_qui"=>$query[$i]['hr_fim_qui'],
                        "hr_fim_sex"=>$query[$i]['hr_fim_sex'],
                        "hr_fim_sab"=>$query[$i]['hr_fim_sab']
                    );
                }
            }
            else{
                $mysql_data = [];
            }
        }else{
             $mysql_data = [];
        }    

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }  
    
    case 'listarAgendaTarefas':{
   
        $resultado = "";
        $query = $agenda_colaborador_tarefa_itensdao->listarAgendaTarefas($agenda_colaborador_tarefa_pk);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){


                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],
                    "ds_tarefa" => $query[$i]["ds_tarefa"],
                    "ds_lead" => $query[$i]["ds_lead"],
                    "leads_pk" => $query[$i]["leads_pk"],                    
                    "ds_local" => $query[$i]["ds_local"],
                    "tarefas_local_pk"=>$query[$i]['tarefas_local_pk'],
                    "ds_area" => $query[$i]["ds_area"],
                    "tarefas_area_pk"=>$query[$i]['tarefas_area_pk'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "ds_tarefa_tipo_servico"=>$query[$i]['ds_tarefa_tipo_servico'], 
                    "tarefas_tipos_servicos_pk"=>$query[$i]['tarefas_tipos_servicos_pk'],
                    "obs"=>$query[$i]['obs'],
                    "ds_dias_hr"=>$ds_dias_hr,
                    "ic_dom"=>$query[$i]['ic_dom'],
                    "ic_seg"=>$query[$i]['ic_seg'],
                    "ic_ter"=>$query[$i]['ic_ter'],
                    "ic_qua"=>$query[$i]['ic_qua'],
                    "ic_qui"=>$query[$i]['ic_qui'],
                    "ic_sex"=>$query[$i]['ic_sex'],
                    "ic_sab"=>$query[$i]['ic_sab'],
                    "dt_ini_execucao"=>$query[$i]['dt_ini_execucao'],
                    "dt_fim_execucao"=>$query[$i]['dt_fim_execucao'],
                    "obs_execucao"=>$query[$i]['obs_execucao'],                    
                    "ds_qrcode"=>$query[$i]['ds_qrcode'],
                    "hr_ini_dom"=>$query[$i]['hr_ini_dom'],
                    "hr_ini_seg"=>$query[$i]['hr_ini_seg'],
                    "hr_ini_ter"=>$query[$i]['hr_ini_ter'],
                    "hr_ini_qua"=>$query[$i]['hr_ini_qua'],
                    "hr_ini_qui"=>$query[$i]['hr_ini_qui'],
                    "hr_ini_sex"=>$query[$i]['hr_ini_sex'],
                    "hr_ini_sab"=>$query[$i]['hr_ini_sab'],
                    "hr_fim_dom"=>$query[$i]['hr_fim_dom'],
                    "hr_fim_seg"=>$query[$i]['hr_fim_seg'],
                    "hr_fim_ter"=>$query[$i]['hr_fim_ter'],
                    "hr_fim_qua"=>$query[$i]['hr_fim_qua'],
                    "hr_fim_qui"=>$query[$i]['hr_fim_qui'],
                    "hr_fim_sex"=>$query[$i]['hr_fim_sex'],
                    "hr_fim_sab"=>$query[$i]['hr_fim_sab']
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
    case 'listarPk':{        
        $resultado = "";
        $query = $agenda_colaborador_tarefa_itensdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                     "pk" => $query[$i]["pk"],
                    "agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],
                    "ds_tarefa" => $query[$i]["ds_tarefa"],
                    "ds_lead" => $query[$i]["ds_lead"],
                    "leads_pk" => $query[$i]["leads_pk"],                    
                    "ds_local" => $query[$i]["ds_local"],
                    "tarefas_local_pk"=>$query[$i]['tarefas_local_pk'],
                    "ds_area" => $query[$i]["ds_area"],
                    "tarefas_area_pk"=>$query[$i]['tarefas_area_pk'],
                    
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "ds_tarefa_tipo_servico"=>$query[$i]['ds_tarefa_tipo_servico'], 
                    "tarefas_tipos_servicos_pk"=>$query[$i]['tarefas_tipos_servicos_pk'],
                    "obs"=>$query[$i]['obs'],
                    "ds_dias_hr"=>$ds_dias_hr,
                    "ic_dom"=>$query[$i]['ic_dom'],
                    "ic_seg"=>$query[$i]['ic_seg'],
                    "ic_ter"=>$query[$i]['ic_ter'],
                    "ic_qua"=>$query[$i]['ic_qua'],
                    "ic_qui"=>$query[$i]['ic_qui'],
                    "ic_sex"=>$query[$i]['ic_sex'],
                    "ic_sab"=>$query[$i]['ic_sab'],
                    "dt_ini_execucao"=>$query[$i]['dt_ini_execucao'],
                    "dt_fim_execucao"=>$query[$i]['dt_fim_execucao'],
                    "obs_execucao"=>$query[$i]['obs_execucao'],                    
                    "ds_qrcode"=>$query[$i]['ds_qrcode'],
                    "hr_ini_dom"=>$query[$i]['hr_ini_dom'],
                    "hr_ini_seg"=>$query[$i]['hr_ini_seg'],
                    "hr_ini_ter"=>$query[$i]['hr_ini_ter'],
                    "hr_ini_qua"=>$query[$i]['hr_ini_qua'],
                    "hr_ini_qui"=>$query[$i]['hr_ini_qui'],
                    "hr_ini_sex"=>$query[$i]['hr_ini_sex'],
                    "hr_ini_sab"=>$query[$i]['hr_ini_sab'],
                    "hr_fim_dom"=>$query[$i]['hr_fim_dom'],
                    "hr_fim_seg"=>$query[$i]['hr_fim_seg'],
                    "hr_fim_ter"=>$query[$i]['hr_fim_ter'],
                    "hr_fim_qua"=>$query[$i]['hr_fim_qua'],
                    "hr_fim_qui"=>$query[$i]['hr_fim_qui'],
                    "hr_fim_sex"=>$query[$i]['hr_fim_sex'],
                    "hr_fim_sab"=>$query[$i]['hr_fim_sab']
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
        $query = $agenda_colaborador_tarefa_itensdao->listar_por_agenda_colaborador_tarefa_pk($agenda_colaborador_tarefa_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],
                    "tarefas_area_pk"=>$query[$i]['tarefas_area_pk'],
                    "tarefas_tipos_servicos_pk"=>$query[$i]['tarefas_tipos_servicos_pk'],
                    "ic_dom"=>$query[$i]['ic_dom'],
                    "ic_seg"=>$query[$i]['ic_seg'],
                    "ic_ter"=>$query[$i]['ic_ter'],
                    "ic_qua"=>$query[$i]['ic_qua'],
                    "ic_qui"=>$query[$i]['ic_qui'],
                    "ic_sex"=>$query[$i]['ic_sex'],
                    "ic_sab"=>$query[$i]['ic_sab'],
                    "obs"=>$query[$i]['obs'],
                    "dt_ini_execucao"=>$query[$i]['dt_ini_execucao'],
                    "dt_fim_execucao"=>$query[$i]['dt_fim_execucao'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "obs_execucao"=>$query[$i]['obs_execucao'],
                    "tarefas_local_pk"=>$query[$i]['tarefas_local_pk'],
                    "ds_qrcode"=>$query[$i]['ds_qrcode'],
                    "hr_ini_dom"=>$query[$i]['hr_ini_dom'],
                    "hr_ini_seg"=>$query[$i]['hr_ini_seg'],
                    "hr_ini_ter"=>$query[$i]['hr_ini_ter'],
                    "hr_ini_qua"=>$query[$i]['hr_ini_qua'],
                    "hr_ini_qui"=>$query[$i]['hr_ini_qui'],
                    "hr_ini_sex"=>$query[$i]['hr_ini_sex'],
                    "hr_ini_sab"=>$query[$i]['hr_ini_sab'],
                    "hr_fim_dom"=>$query[$i]['hr_fim_dom'],
                    "hr_fim_seg"=>$query[$i]['hr_fim_seg'],
                    "hr_fim_ter"=>$query[$i]['hr_fim_ter'],
                    "hr_fim_qua"=>$query[$i]['hr_fim_qua'],
                    "hr_fim_qui"=>$query[$i]['hr_fim_qui'],
                    "hr_fim_sex"=>$query[$i]['hr_fim_sex'],
                    "hr_fim_sab"=>$query[$i]['hr_fim_sab']
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
        $query = $agenda_colaborador_tarefa_itensdao->listar_por_agenda_colaborador_tarefa_pk($agenda_colaborador_tarefa_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],
                    "t_tarefas_area_pk"=>$query[$i]['tarefas_area_pk'],
                    "t_tarefas_tipos_servicos_pk"=>$query[$i]['tarefas_tipos_servicos_pk'],
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    "t_obs"=>$query[$i]['obs'],
                    "t_dt_ini_execucao"=>$query[$i]['dt_ini_execucao'],
                    "t_dt_fim_execucao"=>$query[$i]['dt_fim_execucao'],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_obs_execucao"=>$query[$i]['obs_execucao'],
                    "t_tarefas_local_pk"=>$query[$i]['tarefas_local_pk'],
                    "t_ds_qrcode"=>$query[$i]['ds_qrcode'],
                    "t_hr_ini_dom"=>$query[$i]['hr_ini_dom'],
                    "t_hr_ini_seg"=>$query[$i]['hr_ini_seg'],
                    "t_hr_ini_ter"=>$query[$i]['hr_ini_ter'],
                    "t_hr_ini_qua"=>$query[$i]['hr_ini_qua'],
                    "t_hr_ini_qui"=>$query[$i]['hr_ini_qui'],
                    "t_hr_ini_sex"=>$query[$i]['hr_ini_sex'],
                    "t_hr_ini_sab"=>$query[$i]['hr_ini_sab'],
                    "t_hr_fim_dom"=>$query[$i]['hr_fim_dom'],
                    "t_hr_fim_seg"=>$query[$i]['hr_fim_seg'],
                    "t_hr_fim_ter"=>$query[$i]['hr_fim_ter'],
                    "t_hr_fim_qua"=>$query[$i]['hr_fim_qua'],
                    "t_hr_fim_qui"=>$query[$i]['hr_fim_qui'],
                    "t_hr_fim_sex"=>$query[$i]['hr_fim_sex'],
                    "t_hr_fim_sab"=>$query[$i]['hr_fim_sab'],

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

$agenda_colaborador_tarefa_itensdao = null;

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
