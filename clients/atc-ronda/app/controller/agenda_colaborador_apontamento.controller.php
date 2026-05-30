<?

require_once "../inc/php/public.php";

require_once "../inc/classes/bestflow/DataBase.php";

require_once "../model/agenda_colaborador_apontamento.dao.php";
require_once "../model/agenda_colaborador_apontamento.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$agenda_colaborador_apontamento_pk = $arrRequest['agenda_colaborador_apontamento_pk'];
$leads_pk = $arrRequest['leads_pk'];
$tipo_apontamento_pk = $arrRequest['tipo_apontamento_pk'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$agenda_colaborador_padrao_pk = $arrRequest['agenda_colaborador_padrao_pk'];
$dt_apontamento = $arrRequest['dt_apontamento'];
$motivo_afastamento_pk = $arrRequest['motivo_afastamento_pk'];
$dt_ini_afastamento = $arrRequest['dt_ini_afastamento'];
$dt_fim_afastamento = $arrRequest['dt_fim_afastamento'];
$colaborador_cobertura_afastamento_pk = $arrRequest['colaborador_cobertura_afastamento_pk'];
$ds_obs_afastamento = $arrRequest['ds_obs_afastamento'];
$ds_obs_falta = $arrRequest['ds_obs_falta'];
$colaborador_cobertura_falta_pk = $arrRequest['colaborador_cobertura_falta_pk'];
$motivo_falta_pk = $arrRequest['motivo_falta_pk'];
$dt_falta = $arrRequest['dt_falta'];
$motivo_folga_pk = $arrRequest['motivo_folga_pk'];
$motivo_ft_pk = $arrRequest['motivo_ft_pk'];
$ds_obs_folga = $arrRequest['ds_obs_folga'];
$dt_folga = $arrRequest['dt_folga'];
$dt_ini_ferias = $arrRequest['dt_ini_ferias'];
$dt_fim_ferias = $arrRequest['dt_fim_ferias'];
$colaborador_cobertura_ferias_pk = $arrRequest['colaborador_cobertura_ferias_pk'];
$ds_obs_ferias = $arrRequest['ds_obs_ferias'];
$tipo_ponto_pk = $arrRequest['tipo_ponto_pk'];
$hr_sistema = $arrRequest['hr_sistema'];
$hr_manual = $arrRequest['hr_manual'];
$ds_obs_ponto = $arrRequest['ds_obs_ponto'];
$dt_ponto = $arrRequest['dt_ponto'];
$ds_obs_troca_escala = $arrRequest['ds_obs_troca_escala'];
$dt_troca_escala = $arrRequest['dt_troca_escala'];
$motivos_troca_escala_pk = $arrRequest['motivos_troca_escala_pk'];
$colaborador_cobertura_troca_escala_pk = $arrRequest['colaborador_cobertura_troca_escala_pk'];
$dt_ini_exec_servico = $arrRequest['dt_ini_exec_servico'];
$dt_fim_exec_servico = $arrRequest['dt_fim_exec_servico'];
$leads_pk_modal = $arrRequest['leads_pk_modal'];
$contrato_pk = $arrRequest['contrato_pk'];
$vl_servico = $arrRequest['vl_servico'];
$ds_obs_servico_extra = $arrRequest['ds_obs_servico_extra'];
$ds_pin = $arrRequest['ds_pin'];
$motivo_cobertura_pk = $arrRequest['motivo_cobertura_falta_pk'];
$lead_cobertura_falta_pk = $arrRequest['lead_cobertura_falta_pk'];
$apontamento_ponto_pk = $arrRequest['apontamento_ponto_pk'];
$lead_cobertura_pk = $arrRequest['lead_cobertura_pk'];
$dt_ini = $arrRequest['dt_ini'];
$dt_fim = $arrRequest['dt_fim'];
$vl_ft = $arrRequest['vl_ft'];
$vl_ft_falta = $arrRequest['vl_ft_falta'];

//var_dump($_REQUEST);
$agenda_colaborador_apontamentodao = new agenda_colaborador_apontamentodao();
$agenda_colaborador_apontamentodao->setToken($token); 

$apontamento_pontodao = new apontamento_pontodao();
$apontamento_pontodao->setToken($token); 

$apontamento_afastamentodao = new apontamento_afastamentodao();
$apontamento_afastamentodao->setToken($token); 

$apontamento_faltadao = new apontamento_faltadao();
$apontamento_faltadao->setToken($token); 

$apontamento_folgadao = new apontamento_folgadao();
$apontamento_folgadao->setToken($token); 

$apontamento_feriasdao = new apontamento_feriasdao();
$apontamento_feriasdao->setToken($token); 

$apontamento_troca_escaladao = new apontamento_troca_escaladao();
$apontamento_troca_escaladao->setToken($token); 

$apontamento_servico_extradao = new apontamento_servico_extradao();
$apontamento_servico_extradao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $agenda_colaborador_apontamento = $agenda_colaborador_apontamentodao->carregarPorPk($pk);
        if($agenda_colaborador_apontamento->getpk()>0){
            
            $agenda_colaborador_apontamentodao->excluir($agenda_colaborador_apontamento, $apontamento_ponto_pk);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'Registro não encontrado';
        }
        break;
    }
    case 'salvar':{
        $agenda_colaborador_apontamento = $agenda_colaborador_apontamentodao->carregarPorPk($pk);
        $horario = $agenda_colaborador_apontamentodao->consultarHorarrio($horario);
        $agenda_colaborador_apontamento->setleads_pk($leads_pk);
        $agenda_colaborador_apontamento->settipo_apontamento_pk($tipo_apontamento_pk);
        $agenda_colaborador_apontamento->setcolaborador_pk($colaborador_pk);
        $agenda_colaborador_apontamento->setagenda_colaborador_padrao_pk($agenda_colaborador_padrao_pk);
        if($hr_manual == ''){
            $agenda_colaborador_apontamento->setdt_apontamento(dataYMD($dt_apontamento) ." ".$horario);
        }else{
            $agenda_colaborador_apontamento->setdt_apontamento(dataYMD($dt_apontamento) ." ".$hr_manual.":00");
        }

        $pk = $agenda_colaborador_apontamentodao->salvar($agenda_colaborador_apontamento);
        
        $mysql_data[] = array(
                "pk" => $pk
        );
 
        if($tipo_apontamento_pk == 1){

            $apontamento_ponto = $apontamento_pontodao->carregarPorPk($ponto_pk);
            $apontamento_ponto->setcolaborador_pk($colaborador_pk);
        
            $apontamento_ponto->setagenda_colaborador_apontamento_pk($agenda_colaborador_apontamento->getpk());
            $apontamento_ponto->settipo_ponto_pk($tipo_ponto_pk);
            if($hr_sistema == 1){
                $apontamento_ponto->sethr_ponto("sysdate()");
            }else{
                $apontamento_ponto->sethr_ponto($hr_manual);
            }
            $apontamento_ponto->setds_obs_ponto($ds_obs_ponto);
            $apontamento_ponto->setdt_ponto(dataYMD($dt_ponto));
            $apontamento_ponto->setds_pin($ds_pin);
            
            $pk = $apontamento_pontodao->salvar($apontamento_ponto);
    
            $mysql_data[] = array(
                    "pk" => $pk
            );
        }
        if($tipo_apontamento_pk == 2){
            $apontamento_falta = $apontamento_faltadao->carregarPorPk($falta_pk);
        
            $apontamento_falta->setagenda_colaborador_apontamento_pk($agenda_colaborador_apontamento->getpk());
            $apontamento_falta->setds_obs_falta($ds_obs_falta);
            $apontamento_falta->setcolaborador_cobertura_falta_pk($colaborador_cobertura_falta_pk);
            $apontamento_falta->setmotivo_falta_pk($motivo_falta_pk);
            $apontamento_falta->setdt_falta(dataYMD($dt_falta));
            $apontamento_falta->setlead_pk($leads_pk);
            $apontamento_falta->setmotivo_cobertura_pk($motivo_cobertura_pk);
            $apontamento_falta->setlead_cobertura_pk($lead_cobertura_falta_pk);
            $apontamento_falta->setvl_ft_falta($vl_ft_falta);
        
            $pk = $apontamento_faltadao->salvar($apontamento_falta);
            
            $mysql_data[] = array(
                    "pk" => $pk
            );
        }
        if($tipo_apontamento_pk == 3){
            $apontamento_folga = $apontamento_folgadao->carregarPorPk($folga_pk);
            
            $apontamento_folga->setagenda_colaborador_apontamento_pk($agenda_colaborador_apontamento->getpk());
            $apontamento_folga->setmotivo_folga_pk($motivo_folga_pk);
            $apontamento_folga->setmotivo_ft_pk($motivo_ft_pk);
            $apontamento_folga->setds_obs_folga($ds_obs_folga);
            $apontamento_folga->setdt_folga(dataYMD($dt_folga));
            $apontamento_folga->setlead_cobertura_pk($lead_cobertura_pk);
            $apontamento_folga->setvl_ft($vl_ft);
            
            $pk = $apontamento_folgadao->salvar($apontamento_folga);
            
            $mysql_data[] = array(
                    "pk" => $pk
            );
        }
        if($tipo_apontamento_pk == 4){
            $apontamento_troca_escala = $apontamento_troca_escaladao->carregarPorPk($folga_pk);
            
            $apontamento_troca_escala->setagenda_colaborador_apontamento_pk($agenda_colaborador_apontamento->getpk());
            $apontamento_troca_escala->setds_obs_troca_escala($ds_obs_troca_escala);
            $apontamento_troca_escala->setdt_troca_escala(dataYMD($dt_troca_escala));
            $apontamento_troca_escala->setmotivos_troca_escala_pk($motivos_troca_escala_pk);
            $apontamento_troca_escala->setcolaborador_cobertura_troca_escala_pk($colaborador_cobertura_troca_escala_pk);

            $pk = $apontamento_troca_escaladao->salvar($apontamento_troca_escala);
            
            $mysql_data[] = array(
                    "pk" => $pk
            );
        }
        if($tipo_apontamento_pk == 5){
            
            $apontamento_afastamento = $apontamento_afastamentodao->carregarPorPk($afastamento_pk);
            $apontamento_afastamento->setagenda_colaborador_apontamento_pk($agenda_colaborador_apontamento->getpk());
            $apontamento_afastamento->setmotivo_afastamento_pk($motivo_afastamento_pk);
            $apontamento_afastamento->setdt_ini_afastamento(dataYMD($dt_ini_afastamento));
            $apontamento_afastamento->setdt_fim_afastamento(dataYMD($dt_fim_afastamento));
            $apontamento_afastamento->setcolaborador_cobertura_afastamento_pk($colaborador_cobertura_afastamento_pk);
            $apontamento_afastamento->setds_obs_afastamento($ds_obs_afastamento);

            $pk = $apontamento_afastamentodao->salvar($apontamento_afastamento);
            
            $mysql_data[] = array(
                    "pk" => $pk
            );
        }
        if($tipo_apontamento_pk == 6){
            
            $apontamento_ferias = $apontamento_feriasdao->carregarPorPk($ferias_pk);
            $apontamento_ferias->setagenda_colaborador_apontamento_pk($agenda_colaborador_apontamento->getpk());
            $apontamento_ferias->setdt_ini_ferias(dataYMD($dt_ini_ferias));
            $apontamento_ferias->setdt_fim_ferias(dataYMD($dt_fim_ferias));
            $apontamento_ferias->setcolaborador_cobertura_ferias_pk($colaborador_cobertura_ferias_pk);
            $apontamento_ferias->setds_obs_ferias($ds_obs_ferias);
            $pk = $apontamento_feriasdao->salvar($apontamento_ferias);
            
            $mysql_data[] = array(
                    "pk" => $pk
            );
        }
        if($tipo_apontamento_pk == 7){
            
            $apontamento_servico_extra = $apontamento_servico_extradao->carregarPorPk($servico_extra_pk);
            $apontamento_servico_extra->setagenda_colaborador_apontamento_pk($agenda_colaborador_apontamento->getpk());
            $apontamento_servico_extra->setdt_ini_exec_servico(dataYMD($dt_ini_exec_servico));
            $apontamento_servico_extra->setdt_fim_exec_servico(dataYMD($dt_fim_exec_servico));
            $apontamento_servico_extra->setcontrato_pk($contrato_pk);
            $apontamento_servico_extra->setvl_servico($vl_servico);
            $apontamento_servico_extra->setleads_pk($leads_pk_modal);
            $apontamento_servico_extra->setds_obs_servico_extra($ds_obs_servico_extra);
            
            $pk = $apontamento_servico_extradao->salvar($apontamento_servico_extra);
            
            $mysql_data[] = array(
                    "pk" => $pk
            );
        }
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }

    case 'listarApontamentoColaboradorDia':{
        $dt_inicio_agenda = $dt_apontamento;

        $resultado = "";

        $query = $agenda_colaborador_apontamentodao->listarApontamentoColaboradorDia($colaborador_pk,$dt_apontamento,$tipo_apontamento_pk);

        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){              
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["agenda_colaborador_apontamento_pk"],        
                    "t_apontamento_ponto_pk" => $query[$i]["apontamento_ponto_pk"],        
                    "t_ds_usuario" => $query[$i]["ds_usuario"],        
                    "t_ds_tipo_apontamento" => $query[$i]["ds_tipo_apontamento"],
                    "t_tipo_apontamento_pk" => $query[$i]["tipo_apontamento_pk"],
                    "t_ds_lead" => $query[$i]["ds_lead"],
                    "t_dt_apontamento" => $query[$i]["dt_apontamento"]
                );
            }
        }
        else{           
            $mysql_data = [];
        }		
        break;       

    }

    case 'relApontamento':{
       
        $resultado = "";
        $query = $agenda_colaborador_apontamentodao->relApontamento($colaborador_pk,$tipo_apontamento_pk,$dt_ini,$dt_fim,$leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){              
                
                $mysql_data[] = array(
                    "t_ds_tipo_apontamento" => $query[$i]["ds_tipo_apontamento"],
                    "t_ds_usuario" => $query[$i]["ds_usuario"],
                    "t_dt_cadastro" => $query[$i]["dt_cadastro"],
                    "t_dt_apontamento" => $query[$i]["dt_apontamento"],
                    "t_ds_colaborador" => $query[$i]["ds_colaborador"],
                    "t_ds_lead" => $query[$i]["ds_lead"],
                    "t_obs" => $query[$i]["obs"],
                    
                    
                );
            }
        }
        else{           
            $mysql_data = [];
        }		
        break;       

    }

    case 'relMovimentacaoFt':{

        if($dt_ini!=""){
            $dt_ini = dataYMD($dt_ini);
            $dt_fim = dataYMD($dt_fim);
        }

        $query = $agenda_colaborador_apontamentodao->relMovimentacaoFt($colaborador_pk,$dt_ini,$dt_fim,$leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){              
                
                $mysql_data[] = array(
                    "t_ds_usuario" => $query[$i]["ds_usuario"],
                    "t_dt_cadastro" => $query[$i]["dt_cadastro"],
                    "t_ds_mes_apontamento" => $query[$i]["ds_mes_apontamento"],
                    "t_dt_apontamento" => $query[$i]["dt_apontamento"],
                    "t_ds_colaborador_cobertura_falta" => $query[$i]["ds_colaborador_cobertura_falta"],
                    "t_ds_colaborador" => $query[$i]["ds_colaborador"],
                    "t_ds_lead" => $query[$i]["ds_lead"],
                    "t_ds_motivo_ft" => $query[$i]["ds_motivo_ft"],
                    "t_ds_motivo_cobertura_falta" => $query[$i]["ds_motivo_cobertura_falta"],
                    "t_vl_ft" => number_format($query[$i]["vl_ft"], 2, ',', ' '),
                    "t_total_vl_ft" => number_format($query[$i]["total_vl_ft"], 2, ',', ' '),
                    "t_ds_obs_falta" => $query[$i]["ds_obs_falta"],
                    "t_ds_obs_folga" => $query[$i]["ds_obs_folga"]
                );
            }
        }
        else{           
            $mysql_data = [];
        }		
        break;       

    }
	
}

$agenda_colaborador_apontamentodao = null;
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