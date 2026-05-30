<?
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/agenda_colaborador_padrao.dao.php";
require_once "../model/agenda_colaborador_padrao.class.php";
require_once "../model/agenda_colaborador_tarefa.dao.php";
require_once "../model/agenda_colaborador_tarefa.class.php";
require_once "../model/colaborador.dao.php";
require_once "../model/colaborador.class.php";
require_once "../model/ponto.class.php";
require_once "../model/ponto.dao.php";

require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_agenda = $arrRequest['ds_agenda'];
$leads_pk = $arrRequest['leads_pk'];
$contratos_pk = $arrRequest['contratos_pk'];
if($arrRequest['dt_inicio_agenda']!=""){
    $dt_inicio_agenda = DataYMD($arrRequest['dt_inicio_agenda']);
}
if($arrRequest['dt_fim_agenda']!=""){
   $dt_fim_agenda = DataYMD($arrRequest['dt_fim_agenda']);
}
$colaboradores_pk = $arrRequest['colaboradores_pk'];
$processos_etapas_pk = $arrRequest['processos_etapas_pk'];
$contratos_itens_pk = $arrRequest['contratos_itens_pk'];
$nao_repetir_proxima_semana_pk = $arrRequest['nao_repetir_proxima_semana_pk'];
$ic_nao_repetir = $arrRequest['ic_nao_repetir'];
$ic_dom = $arrRequest['ic_dom'];
$ic_seg = $arrRequest['ic_seg'];
$ic_ter = $arrRequest['ic_ter'];
$ic_qua = $arrRequest['ic_qua'];
$ic_qui = $arrRequest['ic_qui'];
$ic_sex = $arrRequest['ic_sex'];
$ic_sab = $arrRequest['ic_sab'];
$ic_dom_folga = $arrRequest['ic_dom_folga'];
$ic_seg_folga = $arrRequest['ic_seg_folga'];
$ic_ter_folga = $arrRequest['ic_ter_folga'];
$ic_qua_folga = $arrRequest['ic_qua_folga'];
$ic_qui_folga = $arrRequest['ic_qui_folga'];
$ic_sex_folga = $arrRequest['ic_sex_folga'];
$ic_sab_folga = $arrRequest['ic_sab_folga'];
$ic_folga_inverter = $arrRequest['ic_folga_inverter'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$ds_motivo_cancelamento = $arrRequest['ds_motivo_cancelamento'];
$tipo_escala = $arrRequest['tipo_escala'];
$ic_intrajornada = $arrRequest['ic_intrajornada'];
if($ic_dom==""){
    $ic_dom= 2;
}
if($ic_seg==""){
    $ic_seg= 2;
}
if($ic_ter==""){
    $ic_ter= 2;
}
if($ic_qua==""){
    $ic_qua= 2;
}
if($ic_qui==""){
    $ic_qui= 2;
}
if($ic_sex==""){
    $ic_sex= 2;
}
if($ic_sab==""){
    $ic_sab= 2;
}
$dom_turnos_pk = $arrRequest['dom_turnos_pk'];
$seg_turnos_pk = $arrRequest['seg_turnos_pk'];
$ter_turnos_pk = $arrRequest['ter_turnos_pk'];
$qua_turnos_pk = $arrRequest['qua_turnos_pk'];
$qui_turnos_pk = $arrRequest['qui_turnos_pk'];
$sex_turnos_pk = $arrRequest['sex_turnos_pk'];
$sab_turnos_pk = $arrRequest['sab_turnos_pk'];
$hr_turno_dom = $arrRequest['hr_turno_dom'];
$hr_turno_seg = $arrRequest['hr_turno_seg'];
$hr_turno_ter = $arrRequest['hr_turno_ter'];
$hr_turno_qua = $arrRequest['hr_turno_qua'];
$hr_turno_qui = $arrRequest['hr_turno_qui'];
$hr_turno_sex = $arrRequest['hr_turno_sex'];
$hr_turno_sab = $arrRequest['hr_turno_sab'];
$hr_turno_dom_saida = $arrRequest['hr_turno_dom_saida'];
$hr_turno_seg_saida = $arrRequest['hr_turno_seg_saida'];
$hr_turno_ter_saida = $arrRequest['hr_turno_ter_saida'];
$hr_turno_qua_saida = $arrRequest['hr_turno_qua_saida'];
$hr_turno_qui_saida = $arrRequest['hr_turno_qui_saida'];
$hr_turno_sex_saida = $arrRequest['hr_turno_sex_saida'];
$hr_turno_sab_saida = $arrRequest['hr_turno_sab_saida'];
$hr_intervalo_dom = $arrRequest['hr_intervalo_dom'];
$hr_intervalo_seg = $arrRequest['hr_intervalo_seg'];
$hr_intervalo_ter = $arrRequest['hr_intervalo_ter'];
$hr_intervalo_qua = $arrRequest['hr_intervalo_qua'];
$hr_intervalo_qui = $arrRequest['hr_intervalo_qui'];
$hr_intervalo_sex = $arrRequest['hr_intervalo_sex'];
$hr_intervalo_sab = $arrRequest['hr_intervalo_sab'];
$hr_intervalo_saida_dom = $arrRequest['hr_intervalo_saida_dom'];
$hr_intervalo_saida_seg = $arrRequest['hr_intervalo_saida_seg'];
$hr_intervalo_saida_ter = $arrRequest['hr_intervalo_saida_ter'];
$hr_intervalo_saida_qua = $arrRequest['hr_intervalo_saida_qua'];
$hr_intervalo_saida_qui = $arrRequest['hr_intervalo_saida_qui'];
$hr_intervalo_saida_sex = $arrRequest['hr_intervalo_saida_sex'];
$hr_intervalo_saida_sab = $arrRequest['hr_intervalo_saida_sab'];
$tarefas_agenda = $arrRequest['tarefas_agenda'];
$produtos_servicos_pk = $arrRequest['produtos_servicos_pk'];
$n_qtde_dias_semana = $arrRequest['n_qtde_dias_semana'];
$turnos_pk = $arrRequest['turnos_pk'];
$hr_inicio_expediente = $arrRequest['hr_inicio_expediente'];
$hr_termino_expediente = $arrRequest['hr_termino_expediente'];
$hr_saida_intervalo = $arrRequest['hr_saida_intervalo'];
$hr_retorno_intervalo = $arrRequest['hr_retorno_intervalo'];
$ic_preenchimento_automatico = $arrRequest['ic_preenchimento_automatico'];
$agenda_colaborador_padrao_pk = $arrRequest['agenda_colaborador_padrao_pk'];
$dt_periodo_ini = $arrRequest['dt_periodo_ini'];
$dt_periodo_fim = $arrRequest['dt_periodo_fim'];

$agenda_colaborador_padraodao = new agenda_colaborador_padraodao();
$agenda_colaborador_padraodao->setToken($token); 

$agenda_colaborador_tarefadao = new agenda_colaborador_tarefadao();
$agenda_colaborador_tarefadao->setToken($token);

$colaboradordao = new colaboradordao();
$colaboradordao->setToken($token);

$pontodao = new pontodao();
$pontodao->setToken($token);

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){
    case 'excluir':{
        if(!permissao("agenda_condominio", "del", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
            
        $resultdo = "";
        
        $agenda_colaborador_padrao = $agenda_colaborador_padraodao->carregarPorPk($pk);
        if($agenda_colaborador_padrao->getpk()>0){
            
            $log_exclusaodao->salvar("agenda_colaborador_padrao",$agenda_colaborador_padrao->getpk());
            
            $agenda_colaborador_padraodao->excluir($agenda_colaborador_padrao);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'agenda_colaborador_padrao nao encontrado';
        }
        break;
    }
    
    case 'salvar':{
       
        if($pk!=""){
            $ic_acao = "upd";
        }else{
            $ic_acao = "ins";
        }
        
        if(!permissao("agenda_condominio", $ic_acao, $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];
            break;
        }

        /*if($dt_inicio_agenda!=""){            
           $querytotal = $agenda_colaborador_padraodao->carregarInformacaoPausa($dt_inicio_agenda,$dt_fim_agenda,$colaboradores_pk);
            if($querytotal[0]['pk']!=""){
                $agenda_colaborador_padraodao->excluirPausa($querytotal[0]['pk']);
            }
        }*/

        
        $agenda_colaborador_padrao = $agenda_colaborador_padraodao->carregarPorPk($pk);    

        $agenda_colaborador_padrao->setleads_pk($leads_pk);      
        $agenda_colaborador_padrao->setcontratos_pk($contratos_pk);
        $agenda_colaborador_padrao->setdt_inicio_agenda($dt_inicio_agenda);
        $agenda_colaborador_padrao->setdt_fim_agenda($dt_fim_agenda);
        $agenda_colaborador_padrao->setprodutos_servicos_pk($produtos_servicos_pk);
        $agenda_colaborador_padrao->setcolaboradores_pk($colaboradores_pk);
        $agenda_colaborador_padrao->setprocessos_etapas_pk($processos_etapas_pk);
        $agenda_colaborador_padrao->setcontratos_itens_pk($contratos_itens_pk);
        $agenda_colaborador_padrao->setturnos_pk($turnos_pk);
       
        $agenda_colaborador_padrao->sethr_inicio_expediente($hr_inicio_expediente);
        $agenda_colaborador_padrao->sethr_termino_expediente($hr_termino_expediente);
        $agenda_colaborador_padrao->sethr_saida_intervalo($hr_saida_intervalo);
        $agenda_colaborador_padrao->sethr_retorno_intervalo($hr_retorno_intervalo);
        $agenda_colaborador_padrao->setic_folga_inverter($ic_folga_inverter);
        $agenda_colaborador_padrao->settipo_escala($tipo_escala);
        //$agenda_colaborador_padrao->setic_nao_repetir($ic_nao_repetir);
        $agenda_colaborador_padrao->setic_preenchimento_automatico($ic_preenchimento_automatico);
        $agenda_colaborador_padrao->setic_dom($ic_dom);
        $agenda_colaborador_padrao->setic_seg($ic_seg);
        $agenda_colaborador_padrao->setic_ter($ic_ter);
        $agenda_colaborador_padrao->setic_qua($ic_qua);
        $agenda_colaborador_padrao->setic_qui($ic_qui);
        $agenda_colaborador_padrao->setic_sex($ic_sex);
        $agenda_colaborador_padrao->setic_sab($ic_sab);
        $agenda_colaborador_padrao->setic_dom_folga($ic_dom_folga);
        $agenda_colaborador_padrao->setic_seg_folga($ic_seg_folga);
        $agenda_colaborador_padrao->setic_ter_folga($ic_ter_folga);
        $agenda_colaborador_padrao->setic_qua_folga($ic_qua_folga);
        $agenda_colaborador_padrao->setic_qui_folga($ic_qui_folga);
        $agenda_colaborador_padrao->setic_sex_folga($ic_sex_folga);
        $agenda_colaborador_padrao->setic_sab_folga($ic_sab_folga);
        $agenda_colaborador_padrao->setdom_turnos_pk($dom_turnos_pk);
        $agenda_colaborador_padrao->setseg_turnos_pk($seg_turnos_pk);
        $agenda_colaborador_padrao->setter_turnos_pk($ter_turnos_pk);
        $agenda_colaborador_padrao->setqua_turnos_pk($qua_turnos_pk);
        $agenda_colaborador_padrao->setqui_turnos_pk($qui_turnos_pk);
        $agenda_colaborador_padrao->setsex_turnos_pk($sex_turnos_pk);
        $agenda_colaborador_padrao->setsab_turnos_pk($sab_turnos_pk);
        $agenda_colaborador_padrao->sethr_turno_dom($hr_turno_dom);
        $agenda_colaborador_padrao->sethr_turno_seg($hr_turno_seg);
        $agenda_colaborador_padrao->sethr_turno_ter($hr_turno_ter);
        $agenda_colaborador_padrao->sethr_turno_qua($hr_turno_qua);
        $agenda_colaborador_padrao->sethr_turno_qui($hr_turno_qui);
        $agenda_colaborador_padrao->sethr_turno_sex($hr_turno_sex);
        $agenda_colaborador_padrao->sethr_turno_sab($hr_turno_sab);
        $agenda_colaborador_padrao->sethr_turno_dom_saida($hr_turno_dom_saida);
        $agenda_colaborador_padrao->sethr_turno_seg_saida($hr_turno_seg_saida);
        $agenda_colaborador_padrao->sethr_turno_ter_saida($hr_turno_ter_saida);
        $agenda_colaborador_padrao->sethr_turno_qua_saida($hr_turno_qua_saida);
        $agenda_colaborador_padrao->sethr_turno_qui_saida($hr_turno_qui_saida);
        $agenda_colaborador_padrao->sethr_turno_sex_saida($hr_turno_sex_saida);
        $agenda_colaborador_padrao->sethr_turno_sab_saida($hr_turno_sab_saida);
        $agenda_colaborador_padrao->setcontratos_itens_pk($contratos_itens_pk);      
        $agenda_colaborador_padrao->sethr_intervalo_dom($hr_intervalo_dom);
        $agenda_colaborador_padrao->sethr_intervalo_seg($hr_intervalo_seg);
        $agenda_colaborador_padrao->sethr_intervalo_ter($hr_intervalo_ter);
        $agenda_colaborador_padrao->sethr_intervalo_qua($hr_intervalo_qua);
        $agenda_colaborador_padrao->sethr_intervalo_qui($hr_intervalo_qui);
        $agenda_colaborador_padrao->sethr_intervalo_sex($hr_intervalo_sex);
        $agenda_colaborador_padrao->sethr_intervalo_sab($hr_intervalo_sab);
        $agenda_colaborador_padrao->sethr_intervalo_saida_dom($hr_intervalo_saida_dom);
        $agenda_colaborador_padrao->sethr_intervalo_saida_seg($hr_intervalo_saida_seg);
        $agenda_colaborador_padrao->sethr_intervalo_saida_ter($hr_intervalo_saida_ter);
        $agenda_colaborador_padrao->sethr_intervalo_saida_qua($hr_intervalo_saida_qua);
        $agenda_colaborador_padrao->sethr_intervalo_saida_qui($hr_intervalo_saida_qui);
        $agenda_colaborador_padrao->sethr_intervalo_saida_sex($hr_intervalo_saida_sex);
        $agenda_colaborador_padrao->sethr_intervalo_saida_sab($hr_intervalo_saida_sab);
        $agenda_colaborador_padrao->setdt_cancelamento($dt_cancelamento);
        $agenda_colaborador_padrao->setds_motivo_cancelamento($ds_motivo_cancelamento);
        $agenda_colaborador_padrao->setn_qtde_dias_semana($n_qtde_dias_semana);
        $agenda_colaborador_padrao->setic_intrajornada($ic_intrajornada);


        
        $pk = $agenda_colaborador_padraodao->salvar($agenda_colaborador_padrao);

        $mysql_data[] = array(
                "pk" => $pk
        );   
    
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';      

        break;            
    }

    //NOVO     
    
    
    case 'verificaOutraEscalaColaborador':{        
        $colaboradores_pk = $_REQUEST['colaboradores_pk'];   

        $result = "";
        $query = $agenda_colaborador_padraodao->verificaOutraEscalaColaborador($colaboradores_pk);
            
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk"=>$query[$i]['pk'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento']
                );
            }
        }else{
            $mysql_data[] = array(
                "pk"=>0,
             );
        }            
        
        $result  = 'success';
        $message = 'query success';
        
        break;        
    }            
    
    case 'calendarioDadosEscala':{ 
   
        $dt_atual = date("Ymd"); 
        $mes_pk = $_REQUEST['mes_pk'];
        $ano_pk = $_REQUEST['ano_pk'];  
        $ultimo_dia_mes = $_REQUEST['ultimo_dia_mes'];
        $leads_pk = $_REQUEST['leads_pk'];      
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];
        $n_qtde_dias_semana = $_REQUEST['n_qtde_dias_semana'];
        $tipo_escala_pk = $_REQUEST['tipo_escala_pk'];
        $escala_pesq_agenda = $_REQUEST['escala_pesq_agenda'];

        $dt_ini = $ano_pk."-".$mes_pk."-01";
        $dt_fim = $ano_pk."-".$mes_pk."-".$ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $mes_pk, $ano_pk);
        
        $diasemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');
        
        $result = "";
        $query = $agenda_colaborador_padraodao->calendarioDadosEscala($dt_ini,$dt_fim,$leads_pk,$colaborador_pk,$n_qtde_dias_semana,$tipo_escala_pk,$escala_pesq_agenda,$produtos_servicos_pk);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){ 
                //Consulta Escala por escala posto e colaborador
                $queryEscala = $agenda_colaborador_padraodao->retornaEscalaColaboradorPeriodo1($query[$i]['colaborador_pk'],$dt_ini,$dt_fim,$query[$i]['leads_pk'],$query[$i]['pk']);
                $colaborador_pk = $query[$i]['colaborador_pk'];

                if(count($queryEscala) > 0){
                    for($j = 0; $j < count($queryEscala); $j++){ 
                        $ds_tipo_escala = $queryEscala[$j]['n_qtde_dias_semana'];
                        $ds_lead = $queryEscala[$j]['ds_lead'];
                        
                        //Verifica se a escala é 12x36
                        if($ds_tipo_escala=='12x36'){             
                            if(!empty($queryEscala[$j]['tipo_escala'])){ 
                                //Retorna se a escala do mes de consulta é par ou impar
                                $queryMes = $agenda_colaborador_padraodao->retornarDifMes($queryEscala[$j]['dt_inicio_agenda'],$ano_pk."-".$mes_pk."-".$ultimoDiaMes);  

                                $vtipoEscalaMesAtual = $queryEscala[$j]['tipo_escala'];
                                $v_mes_inicio_agenda = $queryEscala[$j]['mes_inicio_agenda'];
                                $v_ano_inicio_agenda = $queryEscala[$j]['ano_inicio_agenda'];                               
                                $v_tipoEscalaMesFor = "";
                                for ($b=0; $b < $queryMes[$j]['mesdif']; $b++){   
                                    //echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." - ".$colaborador_pk." <br>";                                    
                                    if($v_mes_inicio_agenda!='12'){    
                                        if($b==0){
                                            $v_ultDiaMesAnterior = cal_days_in_month(CAL_GREGORIAN, $v_mes_inicio_agenda,  $v_ano_inicio_agenda); 
                                            if($v_ultDiaMesFor % 2 == 0){
                                                $vTipoMesFor = "par";
                                            } else {
                                                $vTipoMesFor = "impar";
                                            }    
                                            $v_tipoEscalaMesFor = $vtipoEscalaMesAtual;                                                 
                                        }else{
                                            if($v_mes_inicio_agenda == "01"){
                                                $v_ultDiaMesAnterior = cal_days_in_month(CAL_GREGORIAN, 12,  $v_ano_inicio_agenda -1);
                                            }else{
                                                $v_ultDiaMesAnterior = cal_days_in_month(CAL_GREGORIAN, $v_mes_inicio_agenda -1 ,  $v_ano_inicio_agenda);
                                            } 
                                            if($v_ultDiaMesAnterior % 2 == 0){
                                                $vTipoMesAnterior = "par";                                                
                                            } else {
                                                $vTipoMesAnterior = "impar";
                                            }  

                                            $v_ultDiaMesFor = cal_days_in_month(CAL_GREGORIAN, $v_mes_inicio_agenda,  $v_ano_inicio_agenda);
                                            if($v_ultDiaMesFor % 2 == 0){
                                                $vTipoMesFor = "par";
                                            } else {
                                                $vTipoMesFor = "impar";
                                            } 
                                            //echo  $v_mes_inicio_agenda."<br>"; 
                                                   
                                              //echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." - " . $colaborador_pk."<br>";  
                                                                            
                                            if($vTipoMesAnterior == "par"  and  $vTipoMesFor == "impar" and $v_tipoEscalaMesFor==2){                                                
                                                $v_tipoEscalaMesFor=2;
                                              //  echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 0 <br>";
                                            }elseif($vTipoMesAnterior == "impar" and   $vTipoMesFor == "par" and $v_tipoEscalaMesFor==2){                                                
                                                $v_tipoEscalaMesFor=1;
                                                //echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 2 <br>";    
                                            }elseif($vTipoMesAnterior == "par"  and  $vTipoMesFor == "impar" and $v_tipoEscalaMesFor==2){                                                                                            
                                                $v_tipoEscalaMesFor=1;
                                              //  echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 1 <br>";  

                                            }elseif($vTipoMesAnterior == "impar" and   $vTipoMesFor == "par" and $v_tipoEscalaMesFor==1){                                                
                                                $v_tipoEscalaMesFor=2;
                                               // echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 3 <br>";
                                            }elseif($vTipoMesAnterior == "impar" and   $vTipoMesFor == "impar" and $v_tipoEscalaMesFor==1){
                                                $v_tipoEscalaMesFor=2;
                                                //echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 4 <br>";
                                            }elseif($vTipoMesAnterior == "impar" and   $vTipoMesFor == "impar" and $v_tipoEscalaMesFor==2){
                                                $v_tipoEscalaMesFor=1;
                                               // echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 5 <br>";
                                            } 
                                        }                                      
                                        if($v_mes_inicio_agenda != $mes_pk){
                                            $v_mes_inicio_agenda++;
                                        }
                                        
                                        
                                    }else{
                                    
                                        if($b==0){
                                            $vtipoEscalaMesAtual = $vtipoEscalaMesAtual;                                            
                                        }
                                        $vtipoEscalaMesAtual = $vtipoEscalaMesAtual;  
                                            //ultimo dia do mes anterior
                                            
                                            $v_ultDiaMesAnterior = cal_days_in_month(CAL_GREGORIAN, $v_mes_inicio_agenda -1,  $v_ano_inicio_agenda);
                                            if($v_ultDiaMesAnterior % 2 == 0){
                                                $vTipoMesAnterior = "par";                                                
                                            } else {
                                                $vTipoMesAnterior = "impar";
                                            }  

                                            /*if($v_ultDiaMesAnterior % 2 == 0){
                                                $vTipoMesAnterior = "par";
                                                $v_tipoEscalaMesFor=2;
                                            } else {
                                                $vTipoMesAnterior = "impar";
                                                $v_tipoEscalaMesFor=1;
                                            }     */
                                            if($vTipoMesAnterior == "par"  and  $vTipoMesFor == "impar" and $v_tipoEscalaMesFor==2){                                                
                                                $v_tipoEscalaMesFor=2;
                                              //  echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 0 <br>";
                                            }elseif($vTipoMesAnterior == "impar" and   $vTipoMesFor == "par" and $v_tipoEscalaMesFor==2){                                                
                                                $v_tipoEscalaMesFor=1;
                                                //echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 2 <br>";    
                                            }elseif($vTipoMesAnterior == "par"  and  $vTipoMesFor == "impar" and $v_tipoEscalaMesFor==2){                                                                                            
                                                $v_tipoEscalaMesFor=1;
                                              //  echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 1 <br>";  

                                            }elseif($vTipoMesAnterior == "impar" and   $vTipoMesFor == "par" and $v_tipoEscalaMesFor==1){                                                
                                                $v_tipoEscalaMesFor=2;
                                               // echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 3 <br>";
                                            }elseif($vTipoMesAnterior == "impar" and   $vTipoMesFor == "impar" and $v_tipoEscalaMesFor==1){
                                                $v_tipoEscalaMesFor=2;
                                                //echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 4 <br>";
                                            }elseif($vTipoMesAnterior == "impar" and   $vTipoMesFor == "impar" and $v_tipoEscalaMesFor==2){
                                                $v_tipoEscalaMesFor=1;
                                               // echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." 5 <br>";
                                            } 
                                            //echo  $v_mes_inicio_agenda." - ".$vTipoMesAnterior." - ".$vTipoMesFor." - ".$v_tipoEscalaMesFor." <br>";
                                            
                                        $v_mes_inicio_agenda = '01';
                                        $v_ano_inicio_agenda = $v_ano_inicio_agenda +1;  
                                        
                                    }
                                } 
                            }    
                        }

                    
                         //Dias trabalhados na escala 
                        $queryDias = $agenda_colaborador_padraodao->retornarDifData(($dt_ini),($dt_fim));
                        
                        $qtdeDias = ($queryDias[0]['dtdif']+2);
                        
                        $v_dias_escala = 0;    
                      
                        $agenda_colaborador_padrao_pk = $queryEscala[$j]['pk'];
                        if($queryEscala[$j]['n_qtde_dias_semana']=='4x2'){
                            $queryMes = $agenda_colaborador_padraodao->retornarDifMes($queryEscala[$j]['dt_inicio_agenda'],$ano_pk."-".$mes_pk."-".$ultimoDiaMes); 
                            $v_dia = str_replace("0","",$queryEscala[$j]['dia_inicio_agenda']);
                            $v_mes = $queryEscala[$j]['mes_inicio_agenda'];   
                            $v_ano = $queryEscala[$j]['ano_inicio_agenda']; 
                            
                            for ($b=0; $b < ($queryMes[$j]['mesdif']); $b++){                                   
                                $v_ultidi_mes = cal_days_in_month(CAL_GREGORIAN, $v_mes, $v_ano);
                                if($b==0){   
                                    $v_dia_mes = 1;
                                    $v_dia_cont = 1;
                                    $v_tipo_dia = "";                         
                                }else{                                   
                                    $v_dia_mes = 1;
                                    
                                }   
                               // echo $v_dia_cont."<br>";                 
                                for ($c=0; $c < ($v_ultidi_mes); $c++){
                                    if($b==0 && $v_dia_mes >= $v_dia){                                         
                                        if($v_dia_cont <=4){
                                            $v_tipo_dia = "Dia de Trabalho";
                                            $v_dia_cont ++;    
                                        }elseif($v_dia_cont >=5 and $v_dia_cont <=6 ){
                                            $v_tipo_dia = "Dia de Folga";
                                            $v_dia_cont ++;  
                                            if($v_dia_cont==7){
                                                $v_dia_cont=1; 
                                            }
                                        }                   
                                    }elseif ($b>0){
                                        
                                        if($v_dia_cont <=4){
                                            $v_tipo_dia = "Dia de Trabalho";
                                            $v_dia_cont ++;    
                                        }elseif($v_dia_cont >=5 and $v_dia_cont <=6 ){
                                            $v_tipo_dia = "Dia de Folga";
                                            $v_dia_cont ++;  
                                            if($v_dia_cont==7){
                                                $v_dia_cont=1; 
                                            }
                                        } 
                                    }
                                    if($v_mes == $mes_pk){
                                        $ds_data = $v_dia_mes."/".$mes_pk."/".$ano_pk;
                                        
                                        $data_calendario = "";
                                        $ds_background = "";
                                        $diasemana_numero = date('w', strtotime($ano_pk."-".$mes_pk."-".$v_dia_mes));  

                                        //arruma a data do for
                                        $data_calendario = $ano_pk.$mes_pk.$a;
                                        if($a < 10){
                                            $data_calendario = $ano_pk.$mes_pk."0".$v_dia_mes;      
                                        }
                                        if($mes_pk < 10){
                                            $data_calendario = $ano_pk."0".$mes_pk.$v_dia_mes;
                                        }
                                        if($mes_pk < 10 && $a < 10){
                                            $data_calendario = $ano_pk."0".$mes_pk."0".$v_dia_mes;
                                        }   

                                        if($v_tipo_dia=='Dia de Trabalho'){
                                            $ds_dia = $v_dia_mes;
                                            $ic_dia_escala = 'Escala';
                                            $ds_turno = $queryEscala[$j]['ds_turno']; 
                                            $hr_turno_ini = $queryEscala[$j]['hr_turno_dom'];     
                                            $hr_intervalo_ini = $queryEscala[$j]['hr_intervalo_dom'];
                                            $hr_intervalo_fim = $queryEscala[$j]['hr_intervalo_saida_dom'];
                                            $hr_turno_saida = $queryEscala[$j]['hr_turno_dom_saida']; 
                                        }else{
                                            $ds_dia = "";
                                            $ic_dia_escala = '';
                                            $ds_turno = ""; 
                                            $hr_turno_ini = "";     
                                            $hr_intervalo_ini = "";
                                            $hr_intervalo_fim = "";
                                            $hr_turno_saida = ""; 
                                        }  
                                        
                                        //verificação de data, para enviar informações apenas nos dias nessesários
                                        if($data_calendario <=  $dt_atual){
                                            
                                            //query tabela ponto
                                            $queryponto = $pontodao->verificarPontoAgenda($colaborador_pk, $ds_data);
                                            
                                            if(count($queryponto) > 0){
                                                for($l=0; $l < count($queryponto); $l++ ){

                                                    $tipo_ponto_pk = $queryponto[$l]['tipo_ponto_pk'];
                                                    $dt_hora_ponto = $queryponto[$l]['dt_hora_ponto'];
                                                    $colaborador_pk = $queryponto[$l]['colaborador_pk'];
                                                    $dia_atual = $queryponto[$l]['dia_atual'];

                                                    if($tipo_ponto_pk != "" && $dt_hora_ponto != "" && $colaborador_pk != ""){
                                                        $tipo_registro_ponto =  $tipo_ponto_pk;
                                                    }else{
                                                        $tipo_registro_ponto =  "";
                                                    }

                                                    if($dt_hora_ponto != "" && $colaborador_pk != ""){
                                                        
                                                        $dt_registro =  $dt_hora_ponto;
                                                    }else{
                                                        $dt_registro = "";
                                                    }
                                                }
                                            }else{
                                                $dadosPonto[] = array(
                                                    
                                                );
                                            } 
                                                
                                            //query tabela apontamento
                                            $queryapontamento = $pontodao->verificarApontamentoAgenda($colaborador_pk, $ds_data);
                                            if(count($queryapontamento) > 0){
                                                
                                                for($f=0; $f < count($queryapontamento); $f++ ){
                                                    $tipo_apontamento_pk = $queryapontamento[$f]['tipo_apontamento_pk'];
                                                    $dt_apontamento = $queryapontamento[$f]['dt_apontamento'];
                                                    $colaborador_pk = $queryapontamento[$f]['colaborador_pk'];
                                                
                                                    if($tipo_apontamento_pk != "" && $dt_apontamento != "" && $colaborador_pk != ""){
                                                        $tipo_registro_ponto =  $tipo_apontamento_pk;
                                                    }else{
                                                        $tipo_registro_ponto =  "";
                                                    }

                                                    if($dt_apontamento != "" && $colaborador_pk != ""){
                                                        $dt_registro =  $dt_apontamento;
                                                    }else{
                                                        $dt_registro = "";
                                                    } 
                                                }

                                            }else{
                                                $dadosApontamento[] = array(
                                                    
                                                );
                                            } 

                                            //informa o background
                                            if ($tipo_registro_ponto == "1" && $dt_registro != ""){
                                                $ds_background = '#63ed83';
                                            }else{
                                                $ds_background = '#FFFF73';
                                            }
                                        }
                                    
                                        $DadosEscala[] = array( 
                                            "agenda_colaborador_padrao_pk"=>$queryEscala[$j]['pk'],
                                            "ds_data"=>$ds_data,
                                            "ds_dia"=>$ds_dia,
                                            "colaborador_pk"=>$query[$i]['colaborador_pk'],
                                            "tipo_registro_ponto"=> $tipo_registro_ponto,
                                            "dt_registro"=> $dt_registro,
                                            "dt_atual"=> $dt_atual,
                                            //"tipo_apontamento_pk"=>"1",
                                            "ds_tipo_escala"=>$ic_dia_escala,
                                            "ds_background"=> $ds_background,
                                            "ds_turno"=>$ds_turno,
                                            "hr_turno_ini"=>$hr_turno_ini,
                                            "hr_intervalo_ini"=>$hr_intervalo_ini,
                                            "hr_intervalo_fim"=>$hr_intervalo_fim,
                                            "hr_turno_saida"=>$hr_turno_saida    
                                        ); 

                                        //echo "Mês:".$v_mes." - Dia:".$v_dia_mes." - Trallho=".$v_tipo_dia."<br>";
                                            
                                    }
                                    $v_dia_mes ++;  
                                    
                                } 
                                if($v_mes == 12){
                                    $v_mes = 1;
                                    $v_ano = ($v_ano + 1);                                    
                                }else{    
                                    $v_mes ++;
                                }
                            }                           
                        }else{
                            //For dos dias de escala
                            for ($a=1; $a < ($qtdeDias); $a++){   

                                $ds_data = $a."/".$mes_pk."/".$ano_pk;
                                $ds_dia = "";
                                $tipo_apontammento_pk = "";
                                $ic_dia_escala = 'Folga';
                                $ds_turno = "";
                                $hr_turno_ini = "";
                                $hr_intervalo_ini ="";
                                $hr_intervalo_fim = "";
                                $hr_turno_saida = "";
                                $dt_registro = "";
                                $tipo_registro_ponto = "";
                                $ds_background = "";
                                $data_calendario = "";
                                
                                $diasemana_numero = date('w', strtotime($ano_pk."-".$mes_pk."-".$a));  
                                
                                //arruma a data do for
                                $data_calendario = $ano_pk.$mes_pk.$a;
                                if($a < 10){
                                    $data_calendario = $ano_pk.$mes_pk."0".$a;      
                                }
                                if($mes_pk < 10){
                                    $data_calendario = $ano_pk."0".$mes_pk.$a;
                                }
                                if($mes_pk < 10 && $a < 10){
                                    $data_calendario = $ano_pk."0".$mes_pk."0".$a;
                                }     
                    
                                if($queryEscala[$j]['n_qtde_dias_semana']!='12x36'){//Dias corridos   

                                    if($diasemana[$diasemana_numero]=="Dom"){
                                        if($queryEscala[$j]['ic_dom']==1){                       
                                            $ds_dia = $a;
                                            $ic_dia_escala = 'Escala';
                                            $ds_turno = $queryEscala[$j]['ds_turno']; 
                                            $hr_turno_ini = $queryEscala[$j]['hr_turno_dom'];     
                                            $hr_intervalo_ini = $queryEscala[$j]['hr_intervalo_dom'];
                                            $hr_intervalo_fim = $queryEscala[$j]['hr_intervalo_saida_dom'];
                                            $hr_turno_saida = $queryEscala[$j]['hr_turno_dom_saida'];                                
                                        }                        
                                    }elseif($diasemana[$diasemana_numero]=="Seg"){
                                        if($queryEscala[$j]['ic_seg']==1){                                
                                            $ds_dia = $a;
                                            $ic_dia_escala = 'Escala';
                                            $ds_turno = $queryEscala[$j]['ds_turno']; 
                                            $hr_turno_ini = $queryEscala[$j]['hr_turno_seg'];     
                                            $hr_intervalo_ini = $queryEscala[$j]['hr_intervalo_seg'];
                                            $hr_intervalo_fim = $queryEscala[$j]['hr_intervalo_saida_seg'];
                                            $hr_turno_saida = $queryEscala[$j]['hr_turno_seg_saida']; 
                                        } 
                                    }elseif($diasemana[$diasemana_numero]=="Ter"){
                                        if($queryEscala[$j]['ic_ter']==1){                                
                                            $ds_dia = $a;
                                            $ic_dia_escala = 'Escala';
                                            $ds_turno = $queryEscala[$j]['ds_turno']; 
                                            $hr_turno_ini = $queryEscala[$j]['hr_turno_ter'];     
                                            $hr_intervalo_ini = $queryEscala[$j]['hr_intervalo_ter'];
                                            $hr_intervalo_fim = $queryEscala[$j]['hr_intervalo_saida_ter'];
                                            $hr_turno_saida = $queryEscala[$j]['hr_turno_ter_saida']; 
                                        } 
                                    }elseif($diasemana[$diasemana_numero]=="Qua"){
                                        if($queryEscala[$j]['ic_qua']==1){                                
                                            $ds_dia = $a;
                                            $ic_dia_escala = 'Escala';
                                            $ds_turno = $queryEscala[$j]['ds_turno']; 
                                            $hr_turno_ini = $queryEscala[$j]['hr_turno_qua'];     
                                            $hr_intervalo_ini = $queryEscala[$j]['hr_intervalo_qua'];
                                            $hr_intervalo_fim = $queryEscala[$j]['hr_intervalo_saida_qua'];
                                            $hr_turno_saida = $queryEscala[$j]['hr_turno_qua_saida']; 
                                        } 
                                    }elseif($diasemana[$diasemana_numero]=="Qui"){
                                        if($queryEscala[$j]['ic_qui']==1){                                 
                                            $ds_dia = $a;
                                            $ic_dia_escala = 'Escala';
                                            $ds_turno = $queryEscala[$j]['ds_turno']; 
                                            $hr_turno_ini = $queryEscala[$j]['hr_turno_qui'];     
                                            $hr_intervalo_ini = $queryEscala[$j]['hr_intervalo_qui'];
                                            $hr_intervalo_fim = $queryEscala[$j]['hr_intervalo_saida_qui'];
                                            $hr_turno_saida = $queryEscala[$j]['hr_turno_qui_saida']; 
                                        } 
                                    }elseif($diasemana[$diasemana_numero]=="Sex"){
                                        if($queryEscala[$j]['ic_sex']==1){                                
                                            $ds_dia = $a;
                                            $ic_dia_escala = 'Escala';
                                            $ds_turno = $queryEscala[$j]['ds_turno']; 
                                            $hr_turno_ini = $queryEscala[$j]['hr_turno_sex'];     
                                            $hr_intervalo_ini = $queryEscala[$j]['hr_intervalo_sex'];
                                            $hr_intervalo_fim = $queryEscala[$j]['hr_intervalo_saida_sex'];
                                            $hr_turno_saida = $queryEscala[$j]['hr_turno_sex_saida']; 
                                        } 
                                    }elseif($diasemana[$diasemana_numero]=="Sab"){
                                        if($queryEscala[$j]['ic_sab']==1){ 
                                            $ds_dia = $a;
                                            $ic_dia_escala = 'Escala';
                                            $ds_turno = $queryEscala[$j]['ds_turno']; 
                                            $hr_turno_ini = $queryEscala[$j]['hr_turno_sab'];     
                                            $hr_intervalo_ini = $queryEscala[$j]['hr_intervalo_sab'];
                                            $hr_intervalo_fim = $queryEscala[$j]['hr_intervalo_saida_sab'];
                                            $hr_turno_saida = $queryEscala[$j]['hr_turno_sab_saida']; 
                                        } 
                                    } 
                                }elseif($v_tipoEscalaMesFor==1){// Impar

                                    if($a % 2 != 0){
                                        $agenda_colaborador_padrao_pk = $queryEscala[$j]['pk'];
                                        $ds_data = $a."/".$mes_pk."/".$ano_pk;
                                        $ds_dia = $a;
                                        $ic_dia_escala = 'Escala';
                                        $ds_turno = $queryEscala[$j]['ds_turno']; 
                                        $hr_turno_ini = $queryEscala[$j]['hr_turno_dom'];     
                                        $hr_intervalo_ini = $queryEscala[$j]['hr_intervalo_dom'];
                                        $hr_intervalo_fim = $queryEscala[$j]['hr_intervalo_saida_dom'];
                                        $hr_turno_saida = $queryEscala[$j]['hr_turno_dom_saida'];

                                        $v_dias_escala ++;
                                    }
                                }elseif($v_tipoEscalaMesFor==2){// Par
                                    if($a % 2 == 0){
                                        $ds_dia = $a;
                                        $ic_dia_escala = 'Escala';
                                        $ds_turno = $queryEscala[$j]['ds_turno']; 
                                        $hr_turno_ini = $queryEscala[$j]['hr_turno_dom'];     
                                        $hr_intervalo_ini = $queryEscala[$j]['hr_intervalo_dom'];
                                        $hr_intervalo_fim = $queryEscala[$j]['hr_intervalo_saida_dom'];
                                        $hr_turno_saida = $queryEscala[$j]['hr_turno_dom_saida'];
                                        $v_dias_escala ++;
                                    }
                                }  
                                //verificação de data, para enviar informações apenas nos dias nessesários
                                if($data_calendario <=  $dt_atual){
                                    
                                    //query tabela ponto
                                    $queryponto = $pontodao->verificarPontoAgenda($colaborador_pk, $ds_data);
                                    
                                    if(count($queryponto) > 0){
                                        for($l=0; $l < count($queryponto); $l++ ){

                                            $tipo_ponto_pk = $queryponto[$l]['tipo_ponto_pk'];
                                            $dt_hora_ponto = $queryponto[$l]['dt_hora_ponto'];
                                            $colaborador_pk = $queryponto[$l]['colaborador_pk'];
                                            $dia_atual = $queryponto[$l]['dia_atual'];

                                            if($tipo_ponto_pk != "" && $dt_hora_ponto != "" && $colaborador_pk != ""){
                                                $tipo_registro_ponto =  $tipo_ponto_pk;
                                            }else{
                                                $tipo_registro_ponto =  "";
                                            }

                                            if($dt_hora_ponto != "" && $colaborador_pk != ""){
                                                $dt_registro =  $dt_hora_ponto;
                                            }else{
                                                $dt_registro = "";
                                            }

                                            

                                        }
                                    }else{
                                        $dadosPonto[] = array(
                                            
                                        );
                                    } 
                                    
                                    //query tabela apontamento
                                    $queryapontamento = $pontodao->verificarApontamentoAgenda($colaborador_pk, $ds_data);
                                    if(count($queryapontamento) > 0){
                                        
                                        for($f=0; $f < count($queryapontamento); $f++ ){
                                            $tipo_apontamento_pk = $queryapontamento[$f]['tipo_apontamento_pk'];
                                            $dt_apontamento = $queryapontamento[$f]['dt_apontamento'];
                                            $colaborador_pk = $queryapontamento[$f]['colaborador_pk'];
                                        
                                            if($tipo_apontamento_pk != "" && $dt_apontamento != "" && $colaborador_pk != ""){
                                                $tipo_registro_ponto =  $tipo_apontamento_pk;
                                            }else{
                                                $tipo_registro_ponto =  "";
                                            }

                                            if($dt_apontamento != "" && $colaborador_pk != ""){
                                                $dt_registro =  $dt_apontamento;
                                            }else{
                                                $dt_registro = "";
                                            } 
                                    }

                                    }else{
                                        $dadosApontamento[] = array(
                                            
                                        );
                                    } 
                                    //echo $a."-".$tipo_registro_ponto."<br>";
                                    //informa o background
                                    if ($tipo_registro_ponto == "1" && $dt_registro != ""){
                                        $ds_background = '#63ed83';
                                    }else{
                                        $ds_background = '#FFFF73';
                                    }
                                }
                                
                                if($ds_tipo_escala == "12X36" || $ds_tipo_escala == "12x36" ){
                                    if($ds_data % 2 == "0" && $ic_dia_escala == "Escala"){
                                        $ds_escala = "Par";
                                    }else{
                                        $ds_escala = "Impar";
                                    }
                                }else{
                                    $ds_escala = " ";
                                }
                                
                                

                                $DadosEscala[] = array( 
                                    "agenda_colaborador_padrao_pk"=>$queryEscala[$j]['pk'],
                                    "ds_data"=>$ds_data,
                                    "ds_dia"=>$ds_dia,
                                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                                    "tipo_registro_ponto"=> $tipo_registro_ponto,
                                    "dt_registro"=> $dt_registro,
                                    "dt_atual"=> $dt_atual,
                                    //"tipo_apontamento_pk"=>"1",
                                    "ds_tipo_escala"=>$ic_dia_escala,
                                    "ds_background"=> $ds_background,
                                    "ds_turno"=>$ds_turno,
                                    "hr_turno_ini"=>$hr_turno_ini,
                                    "hr_intervalo_ini"=>$hr_intervalo_ini,
                                    "hr_intervalo_fim"=>$hr_intervalo_fim,
                                    "hr_turno_saida"=>$hr_turno_saida    
                                ); 
                                
                            
                            }

                        } 

                         
                    }
                }else{
                    $DadosEscala[] = array(
                        
                    );
                }  

                            
                $mysql_data[] = array(
                    "agenda_colaborador_padrao_pk"=>$query[$i]['pk'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico'], 
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'], 
                    "n_qtde_dias_semana"=>$ds_tipo_escala, 
                    "tipo_escala_pk"=>$query[$i]['tipo_escala_pk'],
                    "ds_tipo_escala"=>$ds_escala,
                    "dt_cancelamento_agenda"=>$query[$i]['dt_cancelamento_agenda'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "DadosEscalaCalendario"=>$DadosEscala
                );
            }
        }else{
            $mysql_data[] = array(
                "pk"=>0,
             );
        }            
        
        $result  = 'success';
        $message = 'query success';
        
        break;        
    }  

    case 'calendarioDados':{ 
        $mes_pk = $_REQUEST['mes_pk'];
        $ano_pk = $_REQUEST['ano_pk'];  
        $ultimo_dia_mes = $_REQUEST['ultimo_dia_mes'];
        $leads_pk = $_REQUEST['leads_pk'];      
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];
        $n_qtde_dias_semana = $_REQUEST['n_qtde_dias_semana'];
        $tipo_escala_pk = $_REQUEST['tipo_escala_pk'];
        $escala_pesq_agenda = $_REQUEST['escala_pesq_agenda'];

        $dt_ini = $ano_pk."-".$mes_pk."-01";
        $dt_fim = $ano_pk."-".$mes_pk."-".$ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $mes_pk, $ano_pk);
        
        $diasemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');
        
        $result = "";
        $query = $agenda_colaborador_padraodao->calendarioDados($dt_ini,$dt_fim,$leads_pk,$colaborador_pk,$n_qtde_dias_semana,$tipo_escala_pk,$escala_pesq_agenda,$produtos_servicos_pk);
        
        if(count($query) > 0){ 
            for($i=0; $i<count($query);$i++){
                $mysql_data[] = array(
                    "agenda_colaborador_padrao_pk"=>$query[$i]['agenda_colaborador_padrao_pk'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico'], 
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'], 
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'], 
                    "tipo_escala_pk"=>$query[$i]['tipo_escala_pk'],
                    "ds_tipo_escala"=>$query[$i]['ds_tipo_escala'],
                    "dt_cancelamento_agenda"=>$query[$i]['dt_cancelamento_agenda'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "dadosEscalaCalendario"=>$query[$i]['DadosEscalaCalendario']
                ); 
            }
        } else{
            
            $mysql_data = [];
        }          
        
        $result  = 'success';
        $message = 'query success';
        
        break;      
    }
        
    case 'escalaCalendarioDia':{

        $dia_pk = $_REQUEST['dia_pk'];
        $mes_pk = $_REQUEST['mes_pk']+1;
        $ano_pk = $_REQUEST['ano_pk']+1;  
        $dia_semana = $_REQUEST['dia_semana'];
        
        $leads_pk = $_REQUEST['leads_pk'];      
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $n_qtde_dias_semana = $_REQUEST['n_qtde_dias_semana'];
        $tipo_escala_pk = $_REQUEST['tipo_escala_pk'];
        $escala_pesq_agenda = $_REQUEST['escala_pesq_agenda'];

        $dt_ini = $ano_pk."-".$mes_pk."-".$dia_pk;
        $dt_fim = $ano_pk."-".$mes_pk."-".$dia_pk;
                
        $result = "";
        $query = $agenda_colaborador_padraodao->escalaCalendarioDia($pk,$dt_ini,$dt_fim,$dia_semana);
        
        if(count($query) > 0){                     
       
                $mysql_data[] = array(
                    "ic_escala"=>$query[0]['pk']                 
                );
           
        }else{

            $mysql_data[] = array(
                "pk"=>0,
             );
        }            
        
        $result  = 'success';
        $message = 'query success';
        
        break;        
    }     
    
   
    case 'retornaTipoEscalaMesAtual':{//Retorna se a escala mes atual é para ou impar
 
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        
        $result = "";
        $query = $agenda_colaborador_padraodao->retornaTipoEscalaMesAtual($pk,$colaborador_pk);
        
        if(count($query) > 0){
                $mysql_data[] = array(
                    "ic_escala"=>$query[0]['pk']                 
                );
           
        }else{

            $mysql_data[] = array(
                "pk"=>0,
             );
        }            
        
        $result  = 'success';
        $message = 'query success';
        
        break;        
    }   
    
    case 'dadosHrTurnoEscala':{//Retorna se a escala mes atual é para ou impar
 
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        
        $result = "";
        $query = $agenda_colaborador_padraodao->dadosHrTurnoEscala($colaborador_pk);
        
        if(count($query) > 0){
                $mysql_data[] = array(
                    "ds_turno"=>$query[0]['ds_turno'],
                    "hr_inicio_expediente"=>$query[0]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[0]['hr_termino_expediente'],
                    "n_qtde_dias_semana"=>$query[0]['n_qtde_dias_semana'],
                );           
        }else{
            $mysql_data[] = array(
                "pk"=>0,
             );
        }           
        
        $result  = 'success';
        $message = 'query success';
        break;        
    }   

   case 'retornoTotalHrTrabalhadasEscala':{//Retorna o total de horas trabalhadas na escala
 
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $dt_periodo_ini = $_REQUEST['dt_periodo_ini'];
        $dt_periodo_fim = $_REQUEST['dt_periodo_fim'];
        
        $result = "";
        $queryEscala = $agenda_colaborador_padraodao->retornaEscalaColaboradorPeriodo($colaborador_pk,$dt_periodo_ini,$dt_periodo_fim);
        
        $dtIni_e = (explode("/",$dt_periodo_ini)); 
        $dtFim_e = (explode("/",$dt_periodo_fim));
        
        $diaIniPeriodo = $dtIni_e[0];  
        $MesIniPeriodo = $dtIni_e[1];
        $AnoIniPeriodo = $dtIni_e[2]; 

        $ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);

    //Roda for do periodo Dias
       $queryDias = $agenda_colaborador_padraodao->retornarDifData(DataYMD($dt_periodo_ini),DataYMD($dt_periodo_fim));

       if($ultimoDiaMes==31){  
           $qtdeDias = $queryDias[0]['dtdif'];
       }else{           
           $qtdeDias = ($queryDias[0]['dtdif']+1);
       }
   
       if(count($queryEscala) > 0){
           $qtde_dias_tr_escala = 0;
           $diasemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');
           for ($a=0; $a < ($qtdeDias); $a++) { 
             
               //variaveis                     
               $ic_escala = "";   
               $hr_ini_turno = "";   
               $hr_fim_turno = "";
               $hr_ini_intervalo = "";
               $hr_termino_intervalo = "";
               $ponto_pk = "";
               $tipo_ponto_pk = "";
               $dt_hora_ponto = "";
               //Verifico os dias de escala 
             
               
               $d = ($diaIniPeriodo."/".$MesIniPeriodo."/".$AnoIniPeriodo);
               
               $diasemana_numero = date('w', strtotime($AnoIniPeriodo."-".$MesIniPeriodo."-".$diaIniPeriodo));     
               
               $n_qtde_dias_semana = $queryEscala[0]['n_qtde_dias_semana'];
               $tipo_escala = $queryEscala[0]['tipo_escala'];

               if($diasemana[$diasemana_numero]=="Dom"){                   
                   $ic_escala = $queryEscala[0]['ic_dom'];   
                   $turno_pk = $queryEscala[0]['dom_turnos_pk'];                        
                   $hr_ini_turno = $queryEscala[0]['hr_turno_dom'];   
                   $hr_fim_turno = $queryEscala[0]['hr_turno_dom_saida'];
                   $hr_ini_intervalo = $queryEscala[0]['hr_intervalo_dom'];
                   $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_dom'];
                   if($queryEscala[0]['ic_dom']==1){
                        $qtde_dias_tr_escala += 1; 
                   }
               }elseif($diasemana[$diasemana_numero]=="Seg"){
                   $ic_escala = $queryEscala[0]['ic_seg'];
                   $turnos_pk = $queryEscala[0]['seg_turnos_pk'];
                   $hr_ini_turno = $queryEscala[0]['hr_turno_seg'];   
                   $hr_fim_turno = $queryEscala[0]['hr_turno_seg_saida'];
                   $hr_ini_intervalo = $queryEscala[0]['hr_intervalo_seg'];
                   $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_seg'];
                   if($queryEscala[0]['ic_seg']==1){
                        $qtde_dias_tr_escala += 1; 
                   }
               }elseif($diasemana[$diasemana_numero]=="Ter"){
                   $ic_escala = $queryEscala[0]['ic_ter'];
                   $turno_pk = $queryEscala[0]['ter_turnos_pk'];
                   $hr_ini_turno = $queryEscala[0]['hr_turno_ter'];   
                   $hr_fim_turno = $queryEscala[0]['hr_turno_ter_saida'];
                   $hr_ini_intervalo = $queryEscala[0]['hr_intervalo_ter'];
                   $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_ter'];
                   if($queryEscala[0]['ic_ter']==1){
                        $qtde_dias_tr_escala += 1; 
                   }
               }elseif($diasemana[$diasemana_numero]=="Qua"){
                   $ic_escala = $queryEscala[0]['ic_qua'];
                   $turnos_pk = $queryEscala[0]['qua_turnos_pk'];
                   $hr_ini_turno = $queryEscala[0]['hr_turno_qua'];   
                   $hr_fim_turno = $queryEscala[0]['hr_turno_qua_saida'];
                   $hr_ini_intervalo = $queryEscala[0]['hr_intervalo_qua'];
                   $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_qua'];
                   if($queryEscala[0]['ic_qua']==1){
                        $qtde_dias_tr_escala += 1; 
                   }
               }elseif($diasemana[$diasemana_numero]=="Qui"){
                   $ic_escala = $queryEscala[0]['ic_qui']; 
                   $turno_pk = $queryEscala[0]['qui_turnos_pk'];
                   $hr_ini_turno = $queryEscala[0]['hr_turno_qui'];   
                   $hr_fim_turno = $queryEscala[0]['hr_turno_qui_saida'];
                   $hr_ini_intervalo = $queryEscala[0]['hr_intervalo_qui'];
                   $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_qui'];
                   if($queryEscala[0]['ic_qui']==1){
                        $qtde_dias_tr_escala += 1; 
                   }
               }elseif($diasemana[$diasemana_numero]=="Sex"){
                   $ic_escala = $queryEscala[0]['ic_sex'];
                   $turnos_pk = $queryEscala[0]['sex_turnos_pk'];
                   $hr_ini_turno = $queryEscala[0]['hr_turno_sex'];   
                   $hr_fim_turno = $queryEscala[0]['hr_turno_sex_saida'];
                   $hr_ini_intervalo = $queryEscala[0]['hr_intervalo_sex'];
                   $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_sex'];
                   if($queryEscala[0]['ic_sex']==1){
                        $qtde_dias_tr_escala += 1; 
                   }
               }elseif($diasemana[$diasemana_numero]=="Sab"){
                   $ic_escala = $queryEscala[0]['ic_sab']; 
                   $turnos_pk = $queryEscala[0]['sab_turnos_pk'];
                   $hr_ini_turno = $queryEscala[0]['hr_turno_sab'];   
                   $hr_fim_turno = $queryEscala[0]['hr_turno_sab_saida'];
                   $hr_ini_intervalo = $queryEscala[0]['hr_intervalo_sab'];
                   $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_sab'];
                   if($queryEscala[0]['ic_sab']==1){
                        $qtde_dias_tr_escala += 1; 
                   }
               }
               if($diaIniPeriodo == $ultimoDiaMes){
                    if($MesIniPeriodo==12 and $ultimoDiaMes==31){             
                        $MesIniPeriodo = "01";
                        $AnoIniPeriodo ++;

                    }else{
                        $MesIniPeriodo++;
                    }
                    $ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);    
                    $diaIniPeriodo = "01"; 
                }else{
                    $diaIniPeriodo++;
                }                 
            }

            $queryHrTra = $agenda_colaborador_padraodao->retornarDifHora($hr_ini_turno,$hr_fim_turno);
            $hr_trabalhadas_sem_intervalo = DataYMD($d)." ".$queryHrTra[0]['dif'];
            $queryHrTra0 = $agenda_colaborador_padraodao->retornarHRSemIntervalo($hr_trabalhadas_sem_intervalo);                                                       
            $hr_trabalhadas = $queryHrTra0[0]['hrSemIntervalo'];

            $total_hr_mes = ($qtde_dias_tr_escala * $hr_trabalhadas);
 
        }    
        
        if(count($queryEscala) > 0){
                $mysql_data[] = array(
                    "total_hr_mes"=>$total_hr_mes
                );           
        }else{
            $mysql_data[] = array(
                "pk"=>0,
             );
        }           
        
        $result  = 'success';
        $message = 'query success';
        break;        
    }   
    case 'consultarEscalaContratosItens':{      
        $contratos_itens_pk = $_REQUEST['contratos_itens_pk'];
        $contratos_pk = $_REQUEST['contratos_pk'];

        $result = "";
        $query = $agenda_colaborador_padraodao->consultarEscalaContratosItens($contratos_pk,$contratos_itens_pk);
        
        if(count($query) > 0){
           
            //for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[0]["pk"],
                    "dt_inicio_agenda"=>$query[0]['dt_inicio_agenda'],
                    "dt_fim_agenda"=>$query[0]['dt_fim_agenda'],
                    "ds_colaborador"=>$query[0]['ds_colaborador']
                );
            //}
        }else{
            $mysql_data[] =  array(
                "pk" => "0"   
            );
        }
                    
        $result  = 'success';
        $message = 'query success.';         
        break;        
    }  


    //ANTIGO   
    case 'listarPk':{
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $resultado = "";
        $query = $agenda_colaborador_padraodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_agenda"=>$query[$i]['ds_agenda'],
                    "dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "ic_dom"=>$query[$i]['ic_dom'],
                    "ic_seg"=>$query[$i]['ic_seg'],
                    "ic_ter"=>$query[$i]['ic_ter'],
                    "ic_qua"=>$query[$i]['ic_qua'],
                    "ic_qui"=>$query[$i]['ic_qui'],
                    "ic_sex"=>$query[$i]['ic_sex'],
                    "ic_sab"=>$query[$i]['ic_sab'],
                    "dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    "hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    "hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "hr_intervalo_dom"=>$query[$i]['hr_intervalo_dom'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_dom"=>$query[$i]['hr_intervalo_saida_dom'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],
                    
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
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $resultado = "";
        $query = $agenda_colaborador_padraodao->listar_por_ds_agenda($ds_agenda);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_agenda"=>$query[$i]['ds_agenda'],
                    "dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "ic_dom"=>$query[$i]['ic_dom'],
                    "ic_seg"=>$query[$i]['ic_seg'],
                    "ic_ter"=>$query[$i]['ic_ter'],
                    "ic_qua"=>$query[$i]['ic_qua'],
                    "ic_qui"=>$query[$i]['ic_qui'],
                    "ic_sex"=>$query[$i]['ic_sex'],
                    "ic_sab"=>$query[$i]['ic_sab'],
                    "hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    "hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    "dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "hr_intervalo_dom"=>$query[$i]['hr_intervalo_dom'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_dom"=>$query[$i]['hr_intervalo_saida_dom'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        
        $resultado = "";
        $query = $agenda_colaborador_padraodao->listar_por_ds_agenda($ds_agenda);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    "t_hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "t_hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    "t_hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "t_hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "t_hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "t_hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "t_hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "t_hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "t_hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    "t_dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "t_seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "t_ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "t_qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "t_qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "t_sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "t_sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "hr_intervalo_dom"=>$query[$i]['hr_intervalo_dom'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_dom"=>$query[$i]['hr_intervalo_saida_dom'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    
    case 'listarAgendaColaboradorLeadProcesso':{
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        
        $leads_pk_pesq = $_REQUEST['leads_pk_pesq'];
        $colaborador_pk_pesq_agenda = $_REQUEST['colaborador_pk_pesq_agenda'];
        $dt_periodo_ini_agenda_pesq = $_REQUEST['dt_periodo_ini_agenda_pesq'];
        $dt_periodo_fim_agenda_pesq = $_REQUEST['dt_periodo_fim_agenda_pesq'];
        $escala_pesq_agenda = $_REQUEST['escala_pesq_agenda'];
        $produtos_pesq_agenda = $_REQUEST['produtos_pesq_agenda'];
        $ic_status_pesq_agenda = $_REQUEST['ic_status_pesq_agenda'];
        $tipo_escala_pesq_agenda = $_REQUEST['tipo_escala_pesq_agenda'];
        
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        
        $resultado = "";

        $query = $agenda_colaborador_padraodao->listar_agenda_colaborador_lead_processo($leads_pk,$processos_pk,$colaborador_pk,$leads_pk_pesq,$colaborador_pk_pesq_agenda,$dt_periodo_ini_agenda_pesq,$dt_periodo_fim_agenda_pesq,$escala_pesq_agenda,$tipo_escala_pesq_agenda,$produtos_pesq_agenda,$ic_status_pesq_agenda);
        
        $result  = 'success';
        $message = 'query success';
        
        

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_dia_semana = "";
                $ds_cancelamento = "";
                if($query[$i]['ic_dom']==1){
                    $ds_dia_semana.= "Dom (".$query[$i]['ds_turno_dom'].")<br> ";
                }
                if($query[$i]['ic_seg']==1){
                    $ds_dia_semana.= "Seg (".$query[$i]['ds_turno_seg'].")<br> ";
                }
                if($query[$i]['ic_ter']==1){
                    $ds_dia_semana.= "Ter (".$query[$i]['ds_turno_ter'].")<br> ";
                }
                if($query[$i]['ic_qua']==1){
                    $ds_dia_semana.= "Qua (".$query[$i]['ds_turno_qua'].")<br>";
                }
                if($query[$i]['ic_qui']==1){
                    $ds_dia_semana.= "Qui (".$query[$i]['ds_turno_qui'].")<br> ";
                }
                if($query[$i]['ic_sex']==1){
                    $ds_dia_semana.= "Sex (".$query[$i]['ds_turno_sex'].")<br> ";
                }
                if($query[$i]['ic_sab']==1){
                    $ds_dia_semana.= "Sab (".$query[$i]['ds_turno_sab'].")<br>";
                }
                if($query[$i]['dt_cancelamento']!=""){
                    $ds_cancelamento = "Inativo";
                }
                else{
                    $ds_cancelamento = "Ativo";
                }
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_ds_turno"=>$query[$i]['ds_turno'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_ds_dia_semana"=>$query[$i]['ds_dia_semana'],
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador']." - ".$query[$i]['ds_re'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_processos_pk"=>$query[$i]['processos_pk'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_cancelamento"=>$ds_cancelamento,
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "ds_tipo_escala"=>$query[$i]['ds_tipo_escala'],
                    
                    "t_ic_dom_folga"=>$query[$i]['ic_dom_folga'],
                    "t_ic_seg_folga"=>$query[$i]['ic_seg_folga'],
                    "t_ic_ter_folga"=>$query[$i]['ic_ter_folga'],
                    "t_ic_qua_folga"=>$query[$i]['ic_qua_folga'],
                    "t_ic_qui_folga"=>$query[$i]['ic_qui_folga'],
                    "t_ic_sex_folga"=>$query[$i]['ic_sex_folga'],
                    "t_ic_sab_folga"=>$query[$i]['ic_sab_folga'],                    
                    
                    "t_hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "t_hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    "t_hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "t_hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "t_hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "t_hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "t_hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "t_hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "t_hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    "t_dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "t_seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "t_ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "t_qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "t_qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "t_sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "t_sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    "t_contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "t_produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "t_ds_dia_semana"=>$ds_dia_semana,
                    "t_ic_folga_inverter"=>$query[$i]['ic_folga_inverter'],
                    "hr_intervalo_dom"=>$query[$i]['hr_intervalo_dom'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_dom"=>$query[$i]['hr_intervalo_saida_dom'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    
                    //"produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "periodo"=>$query[$i]['dt_inicio_agenda']." - ".$query[$i]['dt_fim_agenda'],
                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;

    }  
    
    //Res Padrão
    case 'lisarEscalasResPadrao':{
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        
        $leads_pk_pesq = $_REQUEST['leads_pk_pesq'];
        $colaborador_pk_pesq_agenda = $_REQUEST['colaborador_pk_pesq_agenda'];
        $dt_periodo_ini_agenda_pesq = $_REQUEST['dt_periodo_ini_agenda_pesq'];
        $dt_periodo_fim_agenda_pesq = $_REQUEST['dt_periodo_fim_agenda_pesq'];
        $escala_pesq_agenda = $_REQUEST['escala_pesq_agenda'];
        $produtos_pesq_agenda = $_REQUEST['produtos_pesq_agenda'];
        $ic_status_pesq_agenda = $_REQUEST['ic_status_pesq_agenda'];
        $tipo_escala_pesq_agenda = $_REQUEST['tipo_escala_pesq_agenda'];
        
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $setor_contratos_pk = $_REQUEST['setor_contratos_pk'];
        

        
        $resultado = "";

        $query = $agenda_colaborador_padraodao->lisarEscalasResPadrao($leads_pk,$processos_pk,$colaborador_pk,$leads_pk_pesq,$colaborador_pk_pesq_agenda,$dt_periodo_ini_agenda_pesq,$dt_periodo_fim_agenda_pesq,$escala_pesq_agenda,$tipo_escala_pesq_agenda,$produtos_pesq_agenda,$ic_status_pesq_agenda,$setor_contratos_pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){              
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_lead" => $query[$i]["ds_lead"],
                    "t_ds_colaborador" => $query[$i]["ds_colaborador"],
                    "t_ds_produto_servico" => $query[$i]["ds_produto_servico"],        
                    "t_n_qtde_dias_semana" => $query[$i]["n_qtde_dias_semana"],
                    "t_status" => $query[$i]["status"],
                    "t_dt_periodo_escala" => $query[$i]["dt_inicio_agenda"]." Atê ".$query[$i]["dt_fim_agenda"],
                    "t_dt_cancelamento" => $query[$i]["dt_cancelamento"],
                    "t_ds_motivo_cancelamento" => $query[$i]["ds_motivo_cancelamento"],
                    "t_leads_pk" => $query[$i]["leads_pk"],
                    "t_processos_pk" => $query[$i]["processos_pk"],
                    "t_colaborador_pk" => $query[$i]["colaborador_pk"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_dt_inicio_agenda" => $query[$i]["dt_inicio_agenda"],
                    "t_dt_fim_agenda" => $query[$i]["dt_fim_agenda"],
                    "t_produtos_pk" => $query[$i]["produtos_pk"],
                    "t_ds_identificacao_area" => $query[$i]["ds_identificacao_area"],
                    
                );
            }
        }
        else{           
            $mysql_data = [];
        }		
        break;       
    } 
    case 'lisarEscalasResPadraoColaborador':{
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        if($colaborador_pk==""){
            $mysql_data = [];
            break;
        }

        
        $resultado = "";

        $query = $agenda_colaborador_padraodao->lisarEscalasResPadrao("","",$colaborador_pk,"","","","","","","","","");
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){              
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_lead" => $query[$i]["ds_lead"],
                    "t_ds_colaborador" => $query[$i]["ds_colaborador"],
                    "t_ds_produto_servico" => $query[$i]["ds_produto_servico"],        
                    "t_n_qtde_dias_semana" => $query[$i]["n_qtde_dias_semana"],
                    "t_status" => $query[$i]["status"],
                    "t_dt_periodo_escala" => $query[$i]["dt_inicio_agenda"]." Atê ".$query[$i]["dt_fim_agenda"],
                    "t_dt_cancelamento" => $query[$i]["dt_cancelamento"],
                    "t_ds_motivo_cancelamento" => $query[$i]["ds_motivo_cancelamento"],
                    "t_leads_pk" => $query[$i]["leads_pk"],
                    "t_processos_pk" => $query[$i]["processos_pk"],
                    "t_colaborador_pk" => $query[$i]["colaborador_pk"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_dt_inicio_agenda" => $query[$i]["dt_inicio_agenda"],
                    "t_dt_fim_agenda" => $query[$i]["dt_fim_agenda"],
                    "t_produtos_pk" => $query[$i]["produtos_pk"],
                    "t_ds_identificacao_area" => $query[$i]["ds_identificacao_area"],

                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "t_contratos_itens_pk" => $query[$i]["contratos_itens_pk"],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_produtos_servicos_pk" => $query[$i]["produtos_servicos_pk"], 
                    "t_colaborador_pk" => $query[$i]["colaborador_pk"], 
                    "t_turnos_pk" => $query[$i]["turnos_pk"], 
                    "t_hr_inicio_expediente" => $query[$i]["hr_inicio_expediente"],
                    "t_hr_termino_expediente" => $query[$i]["hr_termino_expediente"],
                    "t_hr_saida_intervalo" => $query[$i]["hr_saida_intervalo"],
                    "t_hr_retorno_intervalo" => $query[$i]["hr_retorno_intervalo"],
                    "t_ic_preenchimento_automatico" => $query[$i]["ic_preenchimento_automatico"], 
                    "t_ic_folga_inverter" => $query[$i]["ic_folga_inverter"], 
                    "t_tipo_escala" => $query[$i]["tipo_escala"],                    
                    "t_ic_dom_folga" => $query[$i]["ic_dom_folga"],
                    "t_ic_seg_folga" => $query[$i]["ic_seg_folga"],
                    "t_ic_ter_folga" => $query[$i]["ic_ter_folga"],
                    "t_ic_qua_folga" => $query[$i]["ic_qua_folga"],
                    "t_ic_qui_folga" => $query[$i]["ic_qui_folga"],
                    "t_ic_sex_folga" => $query[$i]["ic_sex_folga"],
                    "t_ic_sab_folga" => $query[$i]["ic_sab_folga"],                    
                    "t_ic_dom" => $query[$i]["ic_dom"],
                    "t_ic_seg" => $query[$i]["ic_seg"],
                    "t_ic_ter" => $query[$i]["ic_ter"],
                    "t_ic_qua" => $query[$i]["ic_qua"],
                    "t_ic_qui" => $query[$i]["ic_qui"],
                    "t_ic_sex" => $query[$i]["ic_sex"],
                    "t_ic_sab" => $query[$i]["ic_sab"],
                    "t_dom_turnos_pk" => $query[$i]["dom_turnos_pk"],
                    "t_seg_turnos_pk" => $query[$i]["seg_turnos_pk"],
                    "t_ter_turnos_pk" => $query[$i]["ter_turnos_pk"],
                    "t_qua_turnos_pk" => $query[$i]["qua_turnos_pk"],
                    "t_qui_turnos_pk" => $query[$i]["qui_turnos_pk"],
                    "t_sex_turnos_pk" => $query[$i]["sex_turnos_pk"],
                    "t_sab_turnos_pk" => $query[$i]["sab_turnos_pk"],                    
                    "t_hr_turno_dom" => $query[$i]["hr_turno_dom"],
                    "t_hr_turno_seg" => $query[$i]["hr_turno_seg"],
                    "t_hr_turno_ter" => $query[$i]["hr_turno_ter"],
                    "t_hr_turno_qua" => $query[$i]["hr_turno_qua"],
                    "t_hr_turno_qui" => $query[$i]["hr_turno_qui"],
                    "t_hr_turno_sex" => $query[$i]["hr_turno_sex"],
                    "t_hr_turno_sab" => $query[$i]["hr_turno_sab"],
                    "t_hr_intervalo_dom" => $query[$i]["hr_intervalo_dom"],
                    "t_hr_intervalo_seg" => $query[$i]["hr_intervalo_seg"],
                    "t_hr_intervalo_ter" => $query[$i]["hr_intervalo_ter"],
                    "t_hr_intervalo_qua" => $query[$i]["hr_intervalo_qua"],
                    "t_hr_intervalo_qui" => $query[$i]["hr_intervalo_qui"],
                    "t_hr_intervalo_sex" => $query[$i]["hr_intervalo_sex"],
                    "t_hr_intervalo_sab" => $query[$i]["hr_intervalo_sab"],                    
                    "t_hr_intervalo_saida_dom" => $query[$i]["hr_intervalo_saida_dom"],
                    "t_hr_intervalo_saida_seg" => $query[$i]["hr_intervalo_saida_seg"],
                    "t_hr_intervalo_saida_ter" => $query[$i]["hr_intervalo_saida_ter"],
                    "t_hr_intervalo_saida_qua" => $query[$i]["hr_intervalo_saida_qua"],
                    "t_hr_intervalo_saida_qui" => $query[$i]["hr_intervalo_saida_qui"],
                    "t_hr_intervalo_saida_sex" => $query[$i]["hr_intervalo_saida_sex"],
                    "t_hr_intervalo_saida_sab" => $query[$i]["hr_intervalo_saida_sab"],                     
                    "t_hr_turno_dom_saida" => $query[$i]["hr_turno_dom_saida"],
                    "t_hr_turno_sab_saida" => $query[$i]["hr_turno_sab_saida"],
                    "t_hr_turno_seg_saida" => $query[$i]["hr_turno_seg_saida"],
                    "t_hr_turno_ter_saida" => $query[$i]["hr_turno_ter_saida"],
                    "t_hr_turno_qua_saida" => $query[$i]["hr_turno_qua_saida"],
                    "t_hr_turno_qui_saida" => $query[$i]["hr_turno_qui_saida"],
                    "t_hr_turno_sex_saida" => $query[$i]["hr_turno_sex_saida"],
                    "t_hr_turno_sab_saida" => $query[$i]["hr_turno_sab_saida"],                    
                    "t_ic_intrajornada" => $query[$i]["ic_intrajornada"]
                    
                    



                    
                );
            }
        }
        else{           
            $mysql_data = [];
        }		
        break;       
    } 
    
    //consulta editar escala
    case 'lisarEscalaEditar':{
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];
            break;
        }

        $resultado = "";

        $query = $agenda_colaborador_padraodao->lisarEscalaEditar($pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            
            for($i = 0; $i < count($query); $i++){         
            
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_leads_pk" => $query[$i]["leads_pk"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_dt_inicio_agenda" => $query[$i]["dt_inicio_agenda"],
                    "t_dt_fim_agenda" => $query[$i]["dt_fim_agenda"],  
                    "t_dt_cancelamento" => $query[$i]["dt_cancelamento"], 
                    "t_ds_motivo_cancelamento" => $query[$i]["ds_motivo_cancelamento"],
                    "t_produtos_servicos_pk" => $query[$i]["produtos_servicos_pk"], 
                    "t_colaborador_pk" => $query[$i]["colaborador_pk"], 
                    "t_turnos_pk" => $query[$i]["turnos_pk"], 
                    "t_hr_inicio_expediente" => $query[$i]["hr_inicio_expediente"],
                    "t_hr_termino_expediente" => $query[$i]["hr_termino_expediente"],
                    "t_hr_saida_intervalo" => $query[$i]["hr_saida_intervalo"],
                    "t_hr_retorno_intervalo" => $query[$i]["hr_retorno_intervalo"],
                    "t_ic_preenchimento_automatico" => $query[$i]["ic_preenchimento_automatico"], 
                    "t_ic_folga_inverter" => $query[$i]["ic_folga_inverter"], 
                    "t_tipo_escala" => $query[$i]["tipo_escala"],                    
                    "t_ic_dom_folga" => $query[$i]["ic_dom_folga"],
                    "t_ic_seg_folga" => $query[$i]["ic_seg_folga"],
                    "t_ic_ter_folga" => $query[$i]["ic_ter_folga"],
                    "t_ic_qua_folga" => $query[$i]["ic_qua_folga"],
                    "t_ic_qui_folga" => $query[$i]["ic_qui_folga"],
                    "t_ic_sex_folga" => $query[$i]["ic_sex_folga"],
                    "t_ic_sab_folga" => $query[$i]["ic_sab_folga"],                    
                    "t_ic_dom" => $query[$i]["ic_dom"],
                    "t_ic_seg" => $query[$i]["ic_seg"],
                    "t_ic_ter" => $query[$i]["ic_ter"],
                    "t_ic_qua" => $query[$i]["ic_qua"],
                    "t_ic_qui" => $query[$i]["ic_qui"],
                    "t_ic_sex" => $query[$i]["ic_sex"],
                    "t_ic_sab" => $query[$i]["ic_sab"],
                    "t_dom_turnos_pk" => $query[$i]["dom_turnos_pk"],
                    "t_seg_turnos_pk" => $query[$i]["seg_turnos_pk"],
                    "t_ter_turnos_pk" => $query[$i]["ter_turnos_pk"],
                    "t_qua_turnos_pk" => $query[$i]["qua_turnos_pk"],
                    "t_qui_turnos_pk" => $query[$i]["qui_turnos_pk"],
                    "t_sex_turnos_pk" => $query[$i]["sex_turnos_pk"],
                    "t_sab_turnos_pk" => $query[$i]["sab_turnos_pk"],                    
                    "t_hr_turno_dom" => $query[$i]["hr_turno_dom"],
                    "t_hr_turno_seg" => $query[$i]["hr_turno_seg"],
                    "t_hr_turno_ter" => $query[$i]["hr_turno_ter"],
                    "t_hr_turno_qua" => $query[$i]["hr_turno_qua"],
                    "t_hr_turno_qui" => $query[$i]["hr_turno_qui"],
                    "t_hr_turno_sex" => $query[$i]["hr_turno_sex"],
                    "t_hr_turno_sab" => $query[$i]["hr_turno_sab"],
                    "t_hr_intervalo_dom" => $query[$i]["hr_intervalo_dom"],
                    "t_hr_intervalo_seg" => $query[$i]["hr_intervalo_seg"],
                    "t_hr_intervalo_ter" => $query[$i]["hr_intervalo_ter"],
                    "t_hr_intervalo_qua" => $query[$i]["hr_intervalo_qua"],
                    "t_hr_intervalo_qui" => $query[$i]["hr_intervalo_qui"],
                    "t_hr_intervalo_sex" => $query[$i]["hr_intervalo_sex"],
                    "t_hr_intervalo_sab" => $query[$i]["hr_intervalo_sab"],                    
                    "t_hr_intervalo_saida_dom" => $query[$i]["hr_intervalo_saida_dom"],
                    "t_hr_intervalo_saida_seg" => $query[$i]["hr_intervalo_saida_seg"],
                    "t_hr_intervalo_saida_ter" => $query[$i]["hr_intervalo_saida_ter"],
                    "t_hr_intervalo_saida_qua" => $query[$i]["hr_intervalo_saida_qua"],
                    "t_hr_intervalo_saida_qui" => $query[$i]["hr_intervalo_saida_qui"],
                    "t_hr_intervalo_saida_sex" => $query[$i]["hr_intervalo_saida_sex"],
                    "t_hr_intervalo_saida_sab" => $query[$i]["hr_intervalo_saida_sab"],                     
                    "t_hr_turno_dom_saida" => $query[$i]["hr_turno_dom_saida"],
                    "t_hr_turno_sab_saida" => $query[$i]["hr_turno_sab_saida"],
                    "t_hr_turno_seg_saida" => $query[$i]["hr_turno_seg_saida"],
                    "t_hr_turno_ter_saida" => $query[$i]["hr_turno_ter_saida"],
                    "t_hr_turno_qua_saida" => $query[$i]["hr_turno_qua_saida"],
                    "t_hr_turno_qui_saida" => $query[$i]["hr_turno_qui_saida"],
                    "t_hr_turno_sex_saida" => $query[$i]["hr_turno_sex_saida"],
                    "t_hr_turno_sab_saida" => $query[$i]["hr_turno_sab_saida"],                    
                    "t_ic_intrajornada" => $query[$i]["ic_intrajornada"]                  
                );
            }
        }
        else{           
            $mysql_data = [];
        }		
        break;       
    } 
    
    
    case 'listarAgendaColaboradorLeadProdutosServicos':{
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        $qtde_dias_contrato = $_REQUEST['qtde_dias_contrato'];
        $contratos_pk = $_REQUEST['contratos_pk'];
    
        
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->listar_agenda_colaborador($leads_pk,$processos_pk,$qtde_dias_contrato,$contratos_pk);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_dia_semana = "";
                if($query[$i]['ic_dom']==1){
                    $ds_dia_semana.= "Dom (".$query[$i]['ds_turno_dom'].")<br> ";
                }
                if($query[$i]['ic_seg']==1){
                    $ds_dia_semana.= "Seg (".$query[$i]['ds_turno_seg'].")<br> ";
                }
                if($query[$i]['ic_ter']==1){
                    $ds_dia_semana.= "Ter (".$query[$i]['ds_turno_ter'].")<br> ";
                }
                if($query[$i]['ic_qua']==1){
                    $ds_dia_semana.= "Qua (".$query[$i]['ds_turno_qua'].")<br> ";
                }
                if($query[$i]['ic_qui']==1){
                    $ds_dia_semana.= "Qui (".$query[$i]['ds_turno_qui'].")<br> ";
                }
                if($query[$i]['ic_sex']==1){
                    $ds_dia_semana.= "Sex (".$query[$i]['ds_turno_sex'].")<br> ";
                }
                if($query[$i]['ic_sab']==1){
                    $ds_dia_semana.= "Sab (".$query[$i]['ds_turno_sab'].")<br> ";
                }
                    
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_ds_dia_semana"=>$ds_dia_semana,
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "t_tipo_escala"=>$query[$i]['tipo_escala'],
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],
                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }     
    case 'verificarQtdeEscalaPorProduto':{
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];
        $contratos_pk = $_REQUEST['contratos_pk'];
    
        
        $resultado = "";
        
        $query = $agenda_colaborador_padraodao->verificarQtdeContratoPorProduto($produtos_servicos_pk,$contratos_pk);
        $query1 = $agenda_colaborador_padraodao->verificarQtdeEscalaPorProduto($produtos_servicos_pk,$contratos_pk);
        
       
        
        $result  = 'success';
        $message = 'query success';


                
                    
                $mysql_data[] = array(
                    "qtde" => $query[0]['n_qtde'] - $query1[0]['qtde_escala'],
                    
                );
		
        break;
    }     
    case 'RellistarAgendaColaboradorLeadProdutosServicos':{
        
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];
        $qtde_dias_contrato = $_REQUEST['qtde_dias_contrato'];
        $dt_base = $_REQUEST['dt_base'];
        $n_dia_semana = $_REQUEST['n_dia_semana'];
    
        
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->rel_listar_agenda_colaborador_data($leads_pk,$dt_base,$produtos_servicos_pk,$qtde_dias_contrato,$n_dia_semana);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_dia_semana = "";
                if($query[$i]['ic_dom']==1){
                    $ds_dia_semana.= "Dom (".$query[$i]['ds_turno_dom'].")<br> ";
                }
                if($query[$i]['ic_seg']==1){
                    $ds_dia_semana.= "Seg (".$query[$i]['ds_turno_seg'].")<br> ";
                }
                if($query[$i]['ic_ter']==1){
                    $ds_dia_semana.= "Ter (".$query[$i]['ds_turno_ter'].")<br> ";
                }
                if($query[$i]['ic_qua']==1){
                    $ds_dia_semana.= "Qua (".$query[$i]['ds_turno_qua'].")<br> ";
                }
                if($query[$i]['ic_qui']==1){
                    $ds_dia_semana.= "Qui (".$query[$i]['ds_turno_qui'].")<br> ";
                }
                if($query[$i]['ic_sex']==1){
                    $ds_dia_semana.= "Sex (".$query[$i]['ds_turno_sex'].")<br> ";
                }
                if($query[$i]['ic_sab']==1){
                    $ds_dia_semana.= "Sab (".$query[$i]['ds_turno_sab'].")<br> ";
                }
                    
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_ds_dia_semana"=>$ds_dia_semana,
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],
                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }     
    case 'listarData':{
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $dt_agenda = $_REQUEST['dt_agenda'];
        
        $resultado = "";
        $query = $agenda_colaborador_padraodao->listar_data($dt_agenda);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "dia_semana" => $query[$i]["dia_semana"],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarItensContratados':{
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $contratos_pk = $_REQUEST['contratos_pk'];
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];
        
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->listar_qtde_itens_profissionais_contratados_servicos($leads_pk,$contratos_pk,$produtos_servicos_pk);            
        }else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                
                //RETORNA A QUANTIDADE DE FUNCIONARIOS DA AGENDA
                    $query1 = $agenda_colaborador_padraodao->listar_profissionais_qtde_dia_servico($leads_pk,$query[$i]["contratos_pk"],$query[$i]["n_qtde_dias_semana"],$produtos_servicos_pk);
                    if(count($query1[0]["qtde_profissionais"])==0){
                        $qtde_profissionais = 0;
                    }
                    else{
                        $qtde_profissionais += $query1[0]["qtde_profissionais"];
                    }
                     $qtde_contratado = ($query[$i]["qtde_contratado"] - $qtde_profissionais);
                
                                
                $mysql_data[] = array(
                    "t_ds_produto_servico" => $query[$i]["ds_produto_servico"],
                    "t_qtde_contratado" => $query[$i]["qtde_contratado"],
                    "t_qtde_profissional" => $qtde_profissionais,
                    "t_diferenca" => ($query[$i]["qtde_contratado"] - $qtde_profissionais),
                    "t_qtde_dias_semana" => $query[$i]["n_qtde_dias_semana"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_contratos_itens_pk" => $query[$i]["contratos_itens_pk"],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarItensContratadosData':{
        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda_inicio = $_REQUEST['dt_agenda_inicio'];
        $dt_agenda_fim = $_REQUEST['dt_agenda_fim'];
        $contratos_pk = $_REQUEST['contratos_pk'];
        
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->listar_qtde_itens_profissionais_contratados_data($leads_pk,$dt_agenda_inicio,$dt_agenda_fim,$contratos_pk);
        }
        else{
            $mysql_data = [];
        }
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_produto = $query[$i]["ds_produto_servico"]." , ".$ds_produto;
                $qtde_produto = $query[$i]["qtde_contratado"]." , ".$qtde_produto;
                $qtde_prof = $query[$i]["qtde_profissional"]." , ".$qtde_prof;
            }
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_ds_produto_servico" => $ds_produto,
                    "t_qtde_contratado" => $qtde_produto,
                    "t_qtde_profissional" => $qtde_prof,
                    "t_ds_contrato" => $query[$i]["ds_contrato"],
                    "t_dt_inicio_contrato" => $query[$i]["dt_inicio_contrato"],
                    "t_dt_fim_contrato" => $query[$i]["dt_fim_contrato"],
                    "t_diferenca" => $query[$i]["diferenca"],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    
    case 'relatorioAgendaLead':{
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_base = $_REQUEST['dt_base'];
        
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->rel_agenda_lead($leads_pk,$dt_base);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                    $query1 = $agenda_colaborador_padraodao->rel_agenda_lead_qtde_profissiomais($leads_pk,$dt_base,$query[$i]["produtos_servicos_pk"],$query[$i]["n_qtde_dias_semana"]);
                    $qtde_profissionais = 0;
                    if(count($query1) > 0){
                        for($j = 0; $j < count($query1); $j++){
                            if($query1[$j]["qtde_profissionais"]=="" || $query1[$j]["qtde_profissionais"]=="null"){
                                $qtde_profissionais = 0;
                            }
                            else{
                                $qtde_profissionais += $query1[$j]["qtde_profissionais"];
                            }

                        }
                    }
                $mysql_data[] = array(
                    "t_n_itens_contratados" => $query[$i]["n_itens_contratados"],
                    "t_n_profissionais_contratados" => $qtde_profissionais,
                    "t_n_diferenca" => ($query[$i]["n_itens_contratados"] - $qtde_profissionais),
                    "t_ds_produto_servico" => $query[$i]["ds_produto_servico"],
                    "t_produtos_servicos_pk" => $query[$i]["produtos_servicos_pk"],
                    "t_n_qtde_dias_semana" => $query[$i]["n_qtde_dias_semana"],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    
    case 'relatorioAgendaColaborador':{
        $colaboradores_pk = $_REQUEST['colaboradores_pk'];
        $dt_base = $_REQUEST['dt_base'];
        $dia_semana = $_REQUEST['dia_semana'];
        
        $resultado = "";
        if($colaboradores_pk!=""){
            $query = $agenda_colaborador_padraodao->rel_agenda_colaborador($colaboradores_pk,$dt_base,$dia_semana);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($dia_semana==0){
                    $ds_turno = $query[$i]['ds_turno_dom'];
                    if($query[$i]['ic_dom']==1){
                        $ds_dia_semana ="Domingo";
                    }
                }
                else if($dia_semana==1){
                    $ds_turno = $query[$i]['ds_turno_seg'];
                    if($query[$i]['ic_seg']==1){
                        $ds_dia_semana ="Segunda";
                    }
                }
                else if($dia_semana==2){
                    $ds_turno = $query[$i]['ds_turno_ter'];
                    if($query[$i]['ic_ter']==1){
                        $ds_dia_semana ="Terça";
                    }
                }
                else if($dia_semana==3){
                    $ds_turno = $query[$i]['ds_turno_qua'];
                    if($query[$i]['ic_qua']==1){
                        $ds_dia_semana ="Quarta";
                    }
                }
                else if($dia_semana==4){
                    $ds_turno = $query[$i]['ds_turno_qui'];
                    if($query[$i]['ic_qui']==1){
                        $ds_dia_semana ="Quinta";
                    }
                }
                else if($dia_semana==5){
                    $ds_turno = $query[$i]['ds_turno_sex'];
                    if($query[$i]['ic_sex']==1){
                        $ds_dia_semana ="Sexta";
                    }
                }
                else if($dia_semana==6){
                    $ds_turno = $query[$i]['ds_turno_sab'];
                    if($query[$i]['ic_sab']==1){
                        $ds_dia_semana ="Sabado";
                    }
                }
                $mysql_data[] = array(
                    
                    "t_ds_lead" => $query[$i]["ds_lead"],
                    "t_ds_turno" => $ds_turno,
                    "t_ds_dia_semana" => $ds_dia_semana,

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    
    case 'listarAgendaLeadData':{

        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda = $_REQUEST['dt_agenda'];
        $dt_agenda_fim = $_REQUEST['dt_agenda_fim'];
        //$dia_semana = $_REQUEST['dia_semana'];
        

        
      
        $resultado = "";
        if($leads_pk!=""){
                
            $query = $agenda_colaborador_padraodao->listar_agenda_colaborador_lead_data($leads_pk,$dt_agenda,$dt_agenda_fim);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($query[$i]['ic_dom']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_dom'];
                    $turnos_pk_escala = $query[$i]['dom_turnos_pk'];
                }
                else if($query[$i]['ic_seg']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_seg'];
                    $turnos_pk_escala = $query[$i]['seg_turnos_pk'];
                }
                else if($query[$i]['ic_ter']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_ter'];
                    $turnos_pk_escala = $query[$i]['ter_turnos_pk'];
                }
                else if($query[$i]['ic_qua']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qua'];
                    $turnos_pk_escala = $query[$i]['qua_turnos_pk'];
                }
                else if($query[$i]['ic_qui']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qui'];
                    $turnos_pk_escala = $query[$i]['qui_turnos_pk'];
                }
                else if($query[$i]['ic_sex']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sex'];
                    $turnos_pk_escala = $query[$i]['sex_turnos_pk'];
                }
                else if($query[$i]['ic_sab']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sab'];
                    $turnos_pk_escala = $query[$i]['sab_turnos_pk'];
                }
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$turnos_pk_escala,
                    "t_ds_turnos"=>$ds_turno_escala,
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    
                    "t_dom_ds_turnos"=>$query[$i]['ds_turno_dom'],
                    "t_seg_ds_turnos"=>$query[$i]['ds_turno_seg'],
                    "t_ter_ds_turnos"=>$query[$i]['ds_turno_ter'],
                    "t_qua_ds_turnos"=>$query[$i]['ds_turno_qua'],
                    "t_qui_ds_turnos"=>$query[$i]['ds_turno_qui'],
                    "t_sex_ds_turnos"=>$query[$i]['ds_turno_sex'],
                    "t_sab_ds_turnos"=>$query[$i]['ds_turno_sab'],
                    
                    "t_dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "t_seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "t_ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "t_qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "t_qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "t_sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "t_sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    
                    "t_hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "t_hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "t_hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "t_hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "t_hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "t_hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "t_hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "t_hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    
                    
                    
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    
                    "t_ds_colaboradores_dom"=>$query[$i]['ds_colaborador_dom'],
                    "t_ds_produto_servico_dom"=>$query[$i]['ds_produto_servico_dom'],
                    "hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    
                    "t_ds_colaboradores_seg"=>$query[$i]['ds_colaborador_seg'],
                    "t_ds_produto_servico_seg"=>$query[$i]['ds_produto_servico_seg'],
                    "hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    
                    "t_ds_colaboradores_ter"=>$query[$i]['ds_colaborador_ter'],
                    "t_ds_produto_servico_ter"=>$query[$i]['ds_produto_servico_ter'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    
                    "t_ds_colaboradores_qua"=>$query[$i]['ds_colaborador_qua'],
                    "t_ds_produto_servico_qua"=>$query[$i]['ds_produto_servico_qua'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    
                    "t_ds_colaboradores_qui"=>$query[$i]['ds_colaborador_qui'],
                    "t_ds_produto_servico_qui"=>$query[$i]['ds_produto_servico_qui'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    
                    "t_ds_colaboradores_sex"=>$query[$i]['ds_colaborador_sex'],
                    "t_ds_produto_servico_sex"=>$query[$i]['ds_produto_servico_sex'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    
                    "t_ds_colaboradores_sab"=>$query[$i]['ds_colaborador_sab'],
                    "t_ds_produto_servico_sab"=>$query[$i]['ds_produto_servico_sab'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_ds_colaborador_grid"=>$query[$i]['ds_colaborador_grid'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_produto_servico_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    
                    "hr_intervalo_dom"=>$query[$i]['hr_intervalo_dom'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_dom"=>$query[$i]['hr_intervalo_saida_dom'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarAgendaLeadDataGrid':{

        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda = $_REQUEST['dt_agenda'];
        $dt_agenda_fim = $_REQUEST['dt_agenda_fim'];
        $colaboradores_pk = $_REQUEST['colaborador_pk'];
        //$dia_semana = $_REQUEST['dia_semana'];

        $resultado = "";
        if($leads_pk!=""){                
            $query = $agenda_colaborador_padraodao->listarAgendaLeadDataGrid($leads_pk,$dt_agenda,$dt_agenda_fim,$colaboradores_pk);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($query[$i]['ic_dom']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_dom'];
                    $turnos_pk_escala = $query[$i]['dom_turnos_pk'];
                }
                else if($query[$i]['ic_seg']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_seg'];
                    $turnos_pk_escala = $query[$i]['seg_turnos_pk'];
                }
                else if($query[$i]['ic_ter']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_ter'];
                    $turnos_pk_escala = $query[$i]['ter_turnos_pk'];
                }
                else if($query[$i]['ic_qua']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qua'];
                    $turnos_pk_escala = $query[$i]['qua_turnos_pk'];
                }
                else if($query[$i]['ic_qui']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qui'];
                    $turnos_pk_escala = $query[$i]['qui_turnos_pk'];
                }
                else if($query[$i]['ic_sex']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sex'];
                    $turnos_pk_escala = $query[$i]['sex_turnos_pk'];
                }
                else if($query[$i]['ic_sab']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sab'];
                    $turnos_pk_escala = $query[$i]['sab_turnos_pk'];
                }
                
               
                    
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$turnos_pk_escala,
                    "t_ds_turnos"=>$ds_turno_escala,
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    
                    "t_dom_ds_turnos"=>$query[$i]['ds_turno_dom'],
                    "t_seg_ds_turnos"=>$query[$i]['ds_turno_seg'],
                    "t_ter_ds_turnos"=>$query[$i]['ds_turno_ter'],
                    "t_qua_ds_turnos"=>$query[$i]['ds_turno_qua'],
                    "t_qui_ds_turnos"=>$query[$i]['ds_turno_qui'],
                    "t_sex_ds_turnos"=>$query[$i]['ds_turno_sex'],
                    "t_sab_ds_turnos"=>$query[$i]['ds_turno_sab'],
                    
                    "t_dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "t_seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "t_ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "t_qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "t_qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "t_sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "t_sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    
                    "t_ic_dom_folga"=>$query[$i]['ic_dom_folga'],
                    "t_ic_seg_folga"=>$query[$i]['ic_seg_folga'],
                    "t_ic_ter_folga"=>$query[$i]['ic_ter_folga'],
                    "t_ic_qua_folga"=>$query[$i]['ic_qua_folga'],
                    "t_ic_qui_folga"=>$query[$i]['ic_qui_folga'],
                    "t_ic_sex_folga"=>$query[$i]['ic_sex_folga'],
                    "t_ic_sab_folga"=>$query[$i]['ic_sab_folga'],
                    
                    
                    "t_hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "t_hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "t_hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "t_hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "t_hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "t_hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "t_hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "t_hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    
                    
                    
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    
                    "t_ds_colaboradores_dom"=>$query[$i]['ds_colaborador_dom'],
                    "t_ds_produto_servico_dom"=>$query[$i]['ds_produto_servico_dom'],
                    "hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    
                    "t_ds_colaboradores_seg"=>$query[$i]['ds_colaborador_seg'],
                    "t_ds_produto_servico_seg"=>$query[$i]['ds_produto_servico_seg'],
                    "hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    
                    "t_ds_colaboradores_ter"=>$query[$i]['ds_colaborador_ter'],
                    "t_ds_produto_servico_ter"=>$query[$i]['ds_produto_servico_ter'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    
                    "t_ds_colaboradores_qua"=>$query[$i]['ds_colaborador_qua'],
                    "t_ds_produto_servico_qua"=>$query[$i]['ds_produto_servico_qua'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    
                    "t_ds_colaboradores_qui"=>$query[$i]['ds_colaborador_qui'],
                    "t_ds_produto_servico_qui"=>$query[$i]['ds_produto_servico_qui'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    
                    "t_ds_colaboradores_sex"=>$query[$i]['ds_colaborador_sex'],
                    "t_ds_produto_servico_sex"=>$query[$i]['ds_produto_servico_sex'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    
                    "t_ds_colaboradores_sab"=>$query[$i]['ds_colaborador_sab'],
                    "t_ds_produto_servico_sab"=>$query[$i]['ds_produto_servico_sab'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_ds_colaborador_grid"=>$query[$i]['ds_colaborador_grid'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_produto_servico_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "t_ic_folga_inverter"=>$query[$i]['ic_folga_inverter'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "hr_intervalo_dom"=>$query[$i]['hr_intervalo_dom'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_dom"=>$query[$i]['hr_intervalo_saida_dom'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'relatorioEscalaServicoDia':{

        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda = $_REQUEST['dt_ini'];
        $colaboradores_pk = $_REQUEST['colaborador_pk'];
        $turnos_pk = $_REQUEST['turnos_pk'];
        $dia_semana = $_REQUEST['dia_semana'];

        $resultado = "";        
        
        $query = $agenda_colaborador_padraodao->relatorioEscalaServicoDia($leads_pk,$dt_agenda,$dt_agenda,$colaboradores_pk,$turnos_pk,$dia_semana);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($query[$i]['ic_dom']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_dom'];
                    $turnos_pk_escala = $query[$i]['dom_turnos_pk'];
                }
                else if($query[$i]['ic_seg']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_seg'];
                    $turnos_pk_escala = $query[$i]['seg_turnos_pk'];
                }
                else if($query[$i]['ic_ter']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_ter'];
                    $turnos_pk_escala = $query[$i]['ter_turnos_pk'];
                }
                else if($query[$i]['ic_qua']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qua'];
                    $turnos_pk_escala = $query[$i]['qua_turnos_pk'];
                }
                else if($query[$i]['ic_qui']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qui'];
                    $turnos_pk_escala = $query[$i]['qui_turnos_pk'];
                }
                else if($query[$i]['ic_sex']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sex'];
                    $turnos_pk_escala = $query[$i]['sex_turnos_pk'];
                }
                else if($query[$i]['ic_sab']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sab'];
                    $turnos_pk_escala = $query[$i]['sab_turnos_pk'];
                }
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$turnos_pk_escala,
                    "t_ds_turnos"=>$ds_turno_escala,
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    
                    "t_dom_ds_turnos"=>$query[$i]['ds_turno_dom'],
                    "t_seg_ds_turnos"=>$query[$i]['ds_turno_seg'],
                    "t_ter_ds_turnos"=>$query[$i]['ds_turno_ter'],
                    "t_qua_ds_turnos"=>$query[$i]['ds_turno_qua'],
                    "t_qui_ds_turnos"=>$query[$i]['ds_turno_qui'],
                    "t_sex_ds_turnos"=>$query[$i]['ds_turno_sex'],
                    "t_sab_ds_turnos"=>$query[$i]['ds_turno_sab'],
                    
                    "t_dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "t_seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "t_ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "t_qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "t_qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "t_sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "t_sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    
                    "t_ic_dom_folga"=>$query[$i]['ic_dom_folga'],
                    "t_ic_seg_folga"=>$query[$i]['ic_seg_folga'],
                    "t_ic_ter_folga"=>$query[$i]['ic_ter_folga'],
                    "t_ic_qua_folga"=>$query[$i]['ic_qua_folga'],
                    "t_ic_qui_folga"=>$query[$i]['ic_qui_folga'],
                    "t_ic_sex_folga"=>$query[$i]['ic_sex_folga'],
                    "t_ic_sab_folga"=>$query[$i]['ic_sab_folga'],
                    
                    
                    "t_hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "t_hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "t_hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "t_hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "t_hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "t_hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "t_hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "t_hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    
                    
                    
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    
                    "t_ds_colaboradores_dom"=>$query[$i]['ds_colaborador_dom'],
                    "t_ds_produto_servico_dom"=>$query[$i]['ds_produto_servico_dom'],
                    "hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    
                    "t_ds_colaboradores_seg"=>$query[$i]['ds_colaborador_seg'],
                    "t_ds_produto_servico_seg"=>$query[$i]['ds_produto_servico_seg'],
                    "hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    
                    "t_ds_colaboradores_ter"=>$query[$i]['ds_colaborador_ter'],
                    "t_ds_produto_servico_ter"=>$query[$i]['ds_produto_servico_ter'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    
                    "t_ds_colaboradores_qua"=>$query[$i]['ds_colaborador_qua'],
                    "t_ds_produto_servico_qua"=>$query[$i]['ds_produto_servico_qua'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    
                    "t_ds_colaboradores_qui"=>$query[$i]['ds_colaborador_qui'],
                    "t_ds_produto_servico_qui"=>$query[$i]['ds_produto_servico_qui'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    
                    "t_ds_colaboradores_sex"=>$query[$i]['ds_colaborador_sex'],
                    "t_ds_produto_servico_sex"=>$query[$i]['ds_produto_servico_sex'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    
                    "t_ds_colaboradores_sab"=>$query[$i]['ds_colaborador_sab'],
                    "t_ds_produto_servico_sab"=>$query[$i]['ds_produto_servico_sab'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador_grid'],
                    "t_ds_re"=>$query[$i]['ds_re'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_produto_servico_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "t_ic_folga_inverter"=>$query[$i]['ic_folga_inverter'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "hr_intervalo_dom"=>$query[$i]['hr_intervalo_dom'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_dom"=>$query[$i]['hr_intervalo_saida_dom'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'relatorioEscalaServicoDiaGrid':{

        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda = $_REQUEST['dt_ini'];
        $colaboradores_pk = $_REQUEST['colaborador_pk'];
        $turnos_pk = $_REQUEST['turnos_pk'];
        $dia_semana = $_REQUEST['dia_semana'];

        $resultado = "";        
        
        $query = $agenda_colaborador_padraodao->relatorioEscalaServicoDiaGrid($leads_pk,$dt_agenda,$dt_agenda,$colaboradores_pk,$turnos_pk,$dia_semana);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($query[$i]['ic_dom']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_dom'];
                    $turnos_pk_escala = $query[$i]['dom_turnos_pk'];
                }
                else if($query[$i]['ic_seg']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_seg'];
                    $turnos_pk_escala = $query[$i]['seg_turnos_pk'];
                }
                else if($query[$i]['ic_ter']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_ter'];
                    $turnos_pk_escala = $query[$i]['ter_turnos_pk'];
                }
                else if($query[$i]['ic_qua']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qua'];
                    $turnos_pk_escala = $query[$i]['qua_turnos_pk'];
                }
                else if($query[$i]['ic_qui']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qui'];
                    $turnos_pk_escala = $query[$i]['qui_turnos_pk'];
                }
                else if($query[$i]['ic_sex']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sex'];
                    $turnos_pk_escala = $query[$i]['sex_turnos_pk'];
                }
                else if($query[$i]['ic_sab']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sab'];
                    $turnos_pk_escala = $query[$i]['sab_turnos_pk'];
                }
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$turnos_pk_escala,
                    "t_ds_turnos"=>$ds_turno_escala,
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    
                    "t_dom_ds_turnos"=>$query[$i]['ds_turno_dom'],
                    "t_seg_ds_turnos"=>$query[$i]['ds_turno_seg'],
                    "t_ter_ds_turnos"=>$query[$i]['ds_turno_ter'],
                    "t_qua_ds_turnos"=>$query[$i]['ds_turno_qua'],
                    "t_qui_ds_turnos"=>$query[$i]['ds_turno_qui'],
                    "t_sex_ds_turnos"=>$query[$i]['ds_turno_sex'],
                    "t_sab_ds_turnos"=>$query[$i]['ds_turno_sab'],
                    
                    "t_dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "t_seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "t_ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "t_qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "t_qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "t_sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "t_sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    
                    "t_ic_dom_folga"=>$query[$i]['ic_dom_folga'],
                    "t_ic_seg_folga"=>$query[$i]['ic_seg_folga'],
                    "t_ic_ter_folga"=>$query[$i]['ic_ter_folga'],
                    "t_ic_qua_folga"=>$query[$i]['ic_qua_folga'],
                    "t_ic_qui_folga"=>$query[$i]['ic_qui_folga'],
                    "t_ic_sex_folga"=>$query[$i]['ic_sex_folga'],
                    "t_ic_sab_folga"=>$query[$i]['ic_sab_folga'],
                    
                    
                    "t_hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "t_hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "t_hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "t_hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "t_hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "t_hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "t_hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "t_hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    
                    
                    
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    
                    "t_ds_colaboradores_dom"=>$query[$i]['ds_colaborador_dom'],
                    "t_ds_produto_servico_dom"=>$query[$i]['ds_produto_servico_dom'],
                    "hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    
                    "t_ds_colaboradores_seg"=>$query[$i]['ds_colaborador_seg'],
                    "t_ds_produto_servico_seg"=>$query[$i]['ds_produto_servico_seg'],
                    "hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    
                    "t_ds_colaboradores_ter"=>$query[$i]['ds_colaborador_ter'],
                    "t_ds_produto_servico_ter"=>$query[$i]['ds_produto_servico_ter'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    
                    "t_ds_colaboradores_qua"=>$query[$i]['ds_colaborador_qua'],
                    "t_ds_produto_servico_qua"=>$query[$i]['ds_produto_servico_qua'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    
                    "t_ds_colaboradores_qui"=>$query[$i]['ds_colaborador_qui'],
                    "t_ds_produto_servico_qui"=>$query[$i]['ds_produto_servico_qui'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    
                    "t_ds_colaboradores_sex"=>$query[$i]['ds_colaborador_sex'],
                    "t_ds_produto_servico_sex"=>$query[$i]['ds_produto_servico_sex'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    
                    "t_ds_colaboradores_sab"=>$query[$i]['ds_colaborador_sab'],
                    "t_ds_produto_servico_sab"=>$query[$i]['ds_produto_servico_sab'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador_grid'],
                    "t_ds_re"=>$query[$i]['ds_re'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_produto_servico_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "t_ic_folga_inverter"=>$query[$i]['ic_folga_inverter'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "hr_intervalo_dom"=>$query[$i]['hr_intervalo_dom'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_dom"=>$query[$i]['hr_intervalo_saida_dom'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'relatorioFalta':{

        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda = $_REQUEST['dt_ini'];
        $colaboradores_pk = $_REQUEST['colaborador_pk'];
        $turnos_pk = $_REQUEST['turnos_pk'];
        $dia_semana = $_REQUEST['dia_semana'];

        $resultado = "";        
        
        $query = $agenda_colaborador_padraodao->relatorioFalta($leads_pk,$dt_agenda,$dt_agenda,$colaboradores_pk,$turnos_pk,$dia_semana);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    
                    
                    
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    
                    "t_ic_dom_folga"=>$query[$i]['ic_dom_folga'],
                    "t_ic_seg_folga"=>$query[$i]['ic_seg_folga'],
                    "t_ic_ter_folga"=>$query[$i]['ic_ter_folga'],
                    "t_ic_qua_folga"=>$query[$i]['ic_qua_folga'],
                    "t_ic_qui_folga"=>$query[$i]['ic_qui_folga'],
                    "t_ic_sex_folga"=>$query[$i]['ic_sex_folga'],
                    "t_ic_sab_folga"=>$query[$i]['ic_sab_folga'],
                    
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    
                    "t_ds_colaboradores_dom"=>$query[$i]['ds_colaborador_dom'],
                    "t_ds_produto_servico_dom"=>$query[$i]['ds_produto_servico_dom'],
                    
                    "t_ds_colaboradores_seg"=>$query[$i]['ds_colaborador_seg'],
                    "t_ds_produto_servico_seg"=>$query[$i]['ds_produto_servico_seg'],
                    
                    "t_ds_colaboradores_ter"=>$query[$i]['ds_colaborador_ter'],
                    "t_ds_produto_servico_ter"=>$query[$i]['ds_produto_servico_ter'],
                    
                    "t_ds_colaboradores_qua"=>$query[$i]['ds_colaborador_qua'],
                    "t_ds_produto_servico_qua"=>$query[$i]['ds_produto_servico_qua'],
                    
                    "t_ds_colaboradores_qui"=>$query[$i]['ds_colaborador_qui'],
                    "t_ds_produto_servico_qui"=>$query[$i]['ds_produto_servico_qui'],
                    
                    "t_ds_colaboradores_sex"=>$query[$i]['ds_colaborador_sex'],
                    "t_ds_produto_servico_sex"=>$query[$i]['ds_produto_servico_sex'],
                    
                    "t_ds_colaboradores_sab"=>$query[$i]['ds_colaborador_sab'],
                    "t_ds_produto_servico_sab"=>$query[$i]['ds_produto_servico_sab'],
                    
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador_grid'],
                    "t_ds_re"=>$query[$i]['ds_re'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_produto_servico_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "t_ic_folga_inverter"=>$query[$i]['ic_folga_inverter'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "hr_intervalo_dom"=>$query[$i]['hr_intervalo_dom'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_dom"=>$query[$i]['hr_intervalo_saida_dom'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'EscalaServicoDiaGridParaRelatorioFalta':{

        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda = $_REQUEST['dt_ini'];
        $dt_agenda_fim = $_REQUEST['dt_fim'];
        $colaboradores_pk = $_REQUEST['colaborador_pk'];
        $turnos_pk = $_REQUEST['turnos_pk'];
        $dia_semana = $_REQUEST['dia_semana'];

        $resultado = "";        
        
        $query = $agenda_colaborador_padraodao->EscalaServicoDiaGridParaRelatorioFalta($leads_pk,$dt_agenda,$dt_agenda_fim,$colaboradores_pk,$turnos_pk,$dia_semana);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($query[$i]['ic_dom']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_dom'];
                    $turnos_pk_escala = $query[$i]['dom_turnos_pk'];
                }
                else if($query[$i]['ic_seg']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_seg'];
                    $turnos_pk_escala = $query[$i]['seg_turnos_pk'];
                }
                else if($query[$i]['ic_ter']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_ter'];
                    $turnos_pk_escala = $query[$i]['ter_turnos_pk'];
                }
                else if($query[$i]['ic_qua']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qua'];
                    $turnos_pk_escala = $query[$i]['qua_turnos_pk'];
                }
                else if($query[$i]['ic_qui']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qui'];
                    $turnos_pk_escala = $query[$i]['qui_turnos_pk'];
                }
                else if($query[$i]['ic_sex']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sex'];
                    $turnos_pk_escala = $query[$i]['sex_turnos_pk'];
                }
                else if($query[$i]['ic_sab']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sab'];
                    $turnos_pk_escala = $query[$i]['sab_turnos_pk'];
                }
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$turnos_pk_escala,
                    "t_ds_turnos"=>$ds_turno_escala,
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    
                    "t_dom_ds_turnos"=>$query[$i]['ds_turno_dom'],
                    "t_seg_ds_turnos"=>$query[$i]['ds_turno_seg'],
                    "t_ter_ds_turnos"=>$query[$i]['ds_turno_ter'],
                    "t_qua_ds_turnos"=>$query[$i]['ds_turno_qua'],
                    "t_qui_ds_turnos"=>$query[$i]['ds_turno_qui'],
                    "t_sex_ds_turnos"=>$query[$i]['ds_turno_sex'],
                    "t_sab_ds_turnos"=>$query[$i]['ds_turno_sab'],
                    
                    "t_dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "t_seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "t_ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "t_qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "t_qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "t_sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "t_sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    
                    "t_ic_dom_folga"=>$query[$i]['ic_dom_folga'],
                    "t_ic_seg_folga"=>$query[$i]['ic_seg_folga'],
                    "t_ic_ter_folga"=>$query[$i]['ic_ter_folga'],
                    "t_ic_qua_folga"=>$query[$i]['ic_qua_folga'],
                    "t_ic_qui_folga"=>$query[$i]['ic_qui_folga'],
                    "t_ic_sex_folga"=>$query[$i]['ic_sex_folga'],
                    "t_ic_sab_folga"=>$query[$i]['ic_sab_folga'],
                    
                    
                    "t_hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "t_hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "t_hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "t_hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "t_hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "t_hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "t_hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "t_hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    
                    
                    
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    
                    "t_ds_colaboradores_dom"=>$query[$i]['ds_colaborador_dom'],
                    "t_ds_produto_servico_dom"=>$query[$i]['ds_produto_servico_dom'],
                    "hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    
                    "t_ds_colaboradores_seg"=>$query[$i]['ds_colaborador_seg'],
                    "t_ds_produto_servico_seg"=>$query[$i]['ds_produto_servico_seg'],
                    "hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    
                    "t_ds_colaboradores_ter"=>$query[$i]['ds_colaborador_ter'],
                    "t_ds_produto_servico_ter"=>$query[$i]['ds_produto_servico_ter'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    
                    "t_ds_colaboradores_qua"=>$query[$i]['ds_colaborador_qua'],
                    "t_ds_produto_servico_qua"=>$query[$i]['ds_produto_servico_qua'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    
                    "t_ds_colaboradores_qui"=>$query[$i]['ds_colaborador_qui'],
                    "t_ds_produto_servico_qui"=>$query[$i]['ds_produto_servico_qui'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    
                    "t_ds_colaboradores_sex"=>$query[$i]['ds_colaborador_sex'],
                    "t_ds_produto_servico_sex"=>$query[$i]['ds_produto_servico_sex'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    
                    "t_ds_colaboradores_sab"=>$query[$i]['ds_colaborador_sab'],
                    "t_ds_produto_servico_sab"=>$query[$i]['ds_produto_servico_sab'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador_grid'],
                    "t_ds_re"=>$query[$i]['ds_re'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_produto_servico_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "t_ic_folga_inverter"=>$query[$i]['ic_folga_inverter'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'relatorioEscalaServicoDiaGridParaTarefa':{

        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda = $_REQUEST['dt_ini'];
        $colaboradores_pk = $_REQUEST['colaborador_pk'];
        $turnos_pk = $_REQUEST['turnos_pk'];
        $dia_semana = $_REQUEST['dia_semana'];

        $resultado = "";        
        
        $query = $agenda_colaborador_padraodao->relatorioEscalaServicoDiaGridParaTarefa($leads_pk,$dt_agenda,$dt_agenda,$colaboradores_pk,$turnos_pk,$dia_semana);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($query[$i]['ic_dom']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_dom'];
                    $turnos_pk_escala = $query[$i]['dom_turnos_pk'];
                }
                else if($query[$i]['ic_seg']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_seg'];
                    $turnos_pk_escala = $query[$i]['seg_turnos_pk'];
                }
                else if($query[$i]['ic_ter']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_ter'];
                    $turnos_pk_escala = $query[$i]['ter_turnos_pk'];
                }
                else if($query[$i]['ic_qua']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qua'];
                    $turnos_pk_escala = $query[$i]['qua_turnos_pk'];
                }
                else if($query[$i]['ic_qui']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qui'];
                    $turnos_pk_escala = $query[$i]['qui_turnos_pk'];
                }
                else if($query[$i]['ic_sex']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sex'];
                    $turnos_pk_escala = $query[$i]['sex_turnos_pk'];
                }
                else if($query[$i]['ic_sab']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sab'];
                    $turnos_pk_escala = $query[$i]['sab_turnos_pk'];
                }
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$turnos_pk_escala,
                    "t_ds_turnos"=>$ds_turno_escala,
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    
                    "t_dom_ds_turnos"=>$query[$i]['ds_turno_dom'],
                    "t_seg_ds_turnos"=>$query[$i]['ds_turno_seg'],
                    "t_ter_ds_turnos"=>$query[$i]['ds_turno_ter'],
                    "t_qua_ds_turnos"=>$query[$i]['ds_turno_qua'],
                    "t_qui_ds_turnos"=>$query[$i]['ds_turno_qui'],
                    "t_sex_ds_turnos"=>$query[$i]['ds_turno_sex'],
                    "t_sab_ds_turnos"=>$query[$i]['ds_turno_sab'],
                    
                    "t_dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "t_seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "t_ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "t_qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "t_qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "t_sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "t_sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    
                    "t_ic_dom_folga"=>$query[$i]['ic_dom_folga'],
                    "t_ic_seg_folga"=>$query[$i]['ic_seg_folga'],
                    "t_ic_ter_folga"=>$query[$i]['ic_ter_folga'],
                    "t_ic_qua_folga"=>$query[$i]['ic_qua_folga'],
                    "t_ic_qui_folga"=>$query[$i]['ic_qui_folga'],
                    "t_ic_sex_folga"=>$query[$i]['ic_sex_folga'],
                    "t_ic_sab_folga"=>$query[$i]['ic_sab_folga'],
                    
                    
                    "t_hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "t_hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "t_hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "t_hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "t_hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "t_hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "t_hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "t_hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    
                    
                    
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    
                    "t_ds_colaboradores_dom"=>$query[$i]['ds_colaborador_dom'],
                    "t_ds_produto_servico_dom"=>$query[$i]['ds_produto_servico_dom'],
                    "hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    
                    "t_ds_colaboradores_seg"=>$query[$i]['ds_colaborador_seg'],
                    "t_ds_produto_servico_seg"=>$query[$i]['ds_produto_servico_seg'],
                    "hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    
                    "t_ds_colaboradores_ter"=>$query[$i]['ds_colaborador_ter'],
                    "t_ds_produto_servico_ter"=>$query[$i]['ds_produto_servico_ter'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    
                    "t_ds_colaboradores_qua"=>$query[$i]['ds_colaborador_qua'],
                    "t_ds_produto_servico_qua"=>$query[$i]['ds_produto_servico_qua'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    
                    "t_ds_colaboradores_qui"=>$query[$i]['ds_colaborador_qui'],
                    "t_ds_produto_servico_qui"=>$query[$i]['ds_produto_servico_qui'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    
                    "t_ds_colaboradores_sex"=>$query[$i]['ds_colaborador_sex'],
                    "t_ds_produto_servico_sex"=>$query[$i]['ds_produto_servico_sex'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    
                    "t_ds_colaboradores_sab"=>$query[$i]['ds_colaborador_sab'],
                    "t_ds_produto_servico_sab"=>$query[$i]['ds_produto_servico_sab'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador_grid'],
                    "t_ds_re"=>$query[$i]['ds_re'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_produto_servico_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "t_ic_folga_inverter"=>$query[$i]['ic_folga_inverter'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarColaboradorAgendaData':{

        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda = $_REQUEST['dt_agenda'];
        $dt_agenda_fim = $_REQUEST['dt_agenda_fim'];
        //$dia_semana = $_REQUEST['dia_semana'];
        
        $resultado = "";
        if($leads_pk!=""){
                
            $query = $agenda_colaborador_padraodao->listarColaboradorAgendaData($leads_pk,$dt_agenda,$dt_agenda_fim);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_ds_re"=>$query[$i]['ds_re'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarQRCode':{
        
        $leads_pk = $_REQUEST['leads_pk'];
        //$dia_semana = $_REQUEST['dia_semana'];
        
        $resultado = "";
        if($leads_pk!=""){
                
            $query = $agenda_colaborador_padraodao->listarQRCode($leads_pk);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "ds_pin"=>$query[$i]['ds_pin'],
                    "ds_imagem"=>$query[$i]['ds_imagem'],
                    "dt_liberacao"=>$query[$i]['dt_liberacao'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_status"=>$query[$i]['ds_status'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarColaboradorAgendaDataGeral':{

        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda = $_REQUEST['dt_agenda'];
        $dt_agenda_fim = $_REQUEST['dt_agenda_fim'];
        $ic_status = $_REQUEST['ic_status'];
        //$dia_semana = $_REQUEST['dia_semana'];
        
        $resultado = "";

                
        $query = $agenda_colaborador_padraodao->listarColaboradorAgendaDataGeral($dt_agenda,$dt_agenda_fim,$leads_pk,$ic_status);

        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                
                if($query[$i]['dt_demissao']!="" && $query[$i]['ic_status']==2){
                    $queryc = $agenda_colaborador_padraodao->verificarColaboradorAtivo($dt_agenda,$query[$i]['colaborador_pk']);
                    if($queryc[0]['total']==0){
                        $mysql_data[] = array(
                            "t_ds_re"=>$query[$i]['ds_re'],
                            "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                            "t_n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                            "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                            "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                            "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                            "t_processos_pk"=>$query[$i]['processos_pk'],
                            "t_ds_leads"=>$query[$i]['ds_lead'],
                            "t_leads_pk"=>$query[$i]['leads_pk'],
                            "t_ic_status"=>$query[$i]['ic_status'],
                            "t_ic_funcionario"=>$query[$i]['ic_funcionario'],
                            "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                            "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                            "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                            "tipo_escala"=>$query[$i]['tipo_escala'],
                            "t_functions" => ""
                        );
                    }
                    else{
                        $mysql_data = [];
                    }
                }
                else if($query[$i]['dt_cancelamento']!=""){
                    $queryca = $agenda_colaborador_padraodao->verificarAgendaAtivo($dt_agenda,$query[$i]['pk']);
                    if($queryca[0]['total']==0){
                        $mysql_data[] = array(
                            "t_ds_re"=>$query[$i]['ds_re'],
                            "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                            "t_n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                            "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                            "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                            "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                            "t_processos_pk"=>$query[$i]['processos_pk'],
                            "t_ds_leads"=>$query[$i]['ds_lead'],
                            "t_leads_pk"=>$query[$i]['leads_pk'],
                            "t_ic_status"=>$query[$i]['ic_status'],
                            "t_ic_funcionario"=>$query[$i]['ic_funcionario'],
                            "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                            "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                            "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                            "tipo_escala"=>$query[$i]['tipo_escala'],
                            "t_functions" => ""
                        );
                    }
                    else{
                        $mysql_data = [];
                    }
                }
                else{
                    $mysql_data[] = array(
                        "t_ds_re"=>$query[$i]['ds_re'],
                        "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                        "t_n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                        "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                        "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                        "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                        "t_processos_pk"=>$query[$i]['processos_pk'],
                        "t_ds_leads"=>$query[$i]['ds_lead'],
                        "t_leads_pk"=>$query[$i]['leads_pk'],
                        "t_ic_status"=>$query[$i]['ic_status'],
                        "t_ic_funcionario"=>$query[$i]['ic_funcionario'],
                        "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                        "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                        "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                        "tipo_escala"=>$query[$i]['tipo_escala'],
                        "t_functions" => ""
                    );
                }
                
                
                
                
                
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarColaboradorAgendaDataGeralColaborador':{

        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $colaboradores_pk = $_REQUEST['colaboradores_pk'];
        $dt_agenda = $_REQUEST['dt_agenda'];
        $dt_agenda_fim = $_REQUEST['dt_agenda_fim'];
        $ic_status = $_REQUEST['ic_status'];
        //$dia_semana = $_REQUEST['dia_semana'];
        
        $resultado = "";
        $result  = 'success';
        $message = 'query success';
                
        $queryl = $agenda_colaborador_padraodao->listarLeadsPorColaboradorAgenda($dt_agenda,$dt_agenda_fim,$colaboradores_pk,$ic_status);
        
        if(count($queryl) > 0){
            for($l = 0; $l < count($queryl); $l++){
                $query = $agenda_colaborador_padraodao->listarColaboradorAgendaDataGeralColaborador($dt_agenda,$dt_agenda_fim,$colaboradores_pk,$ic_status,$queryl[$l]['leads_pk']);

        
                

                if(count($query) > 0){
                    for($i = 0; $i < count($query); $i++){
                        if($query[$i]['dt_demissao']!="" && $query[$i]['ic_status']==2){
                            $queryc = $agenda_colaborador_padraodao->verificarColaboradorAtivo($dt_agenda,$query[$i]['colaborador_pk']);
                            if($queryc[0]['total']==0){
                                $mysql_data[] = array(
                                    "t_ds_re"=>$query[$i]['ds_re'],
                                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                                    "t_n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                                    "t_processos_pk"=>$query[$i]['processos_pk'],
                                    "t_ds_leads"=>$query[$i]['ds_lead'],
                                    "t_leads_pk"=>$query[$i]['leads_pk'],
                                    "t_ic_status"=>$query[$i]['ic_status'],
                                    "t_ic_funcionario"=>$query[$i]['ic_funcionario'],
                                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                                    "tipo_escala"=>$query[$i]['tipo_escala'],
                                    "t_functions" => ""
                                );
                            }
                            else{
                                $mysql_data = [];
                            }
                        }
                        else if($query[$i]['dt_cancelamento']!=""){
                            $queryca = $agenda_colaborador_padraodao->verificarAgendaAtivo($dt_agenda,$query[$i]['pk']);
                            if($queryca[0]['total']==0){
                                $mysql_data[] = array(
                                    "t_ds_re"=>$query[$i]['ds_re'],
                                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                                    "t_n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                                    "t_processos_pk"=>$query[$i]['processos_pk'],
                                    "t_ds_leads"=>$query[$i]['ds_lead'],
                                    "t_leads_pk"=>$query[$i]['leads_pk'],
                                    "t_ic_status"=>$query[$i]['ic_status'],
                                    "t_ic_funcionario"=>$query[$i]['ic_funcionario'],
                                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                                    "tipo_escala"=>$query[$i]['tipo_escala'],
                                    "t_functions" => ""
                                );
                            }
                            else{
                                $mysql_data = [];
                            }
                        }
                        else{
                            $mysql_data[] = array(
                                "t_ds_re"=>$query[$i]['ds_re'],
                                "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                                "t_n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                                "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                                "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                                "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                                "t_processos_pk"=>$query[$i]['processos_pk'],
                                "t_ds_leads"=>$query[$i]['ds_lead'],
                                "t_leads_pk"=>$query[$i]['leads_pk'],
                                "t_ic_status"=>$query[$i]['ic_status'],
                                "t_ic_funcionario"=>$query[$i]['ic_funcionario'],
                                "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                                "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                                "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                                "tipo_escala"=>$query[$i]['tipo_escala'],
                                "t_functions" => ""
                            );
                        }
                    }
                }
                else{

                    $mysql_data = [];
                }
            }
        }
        else{

            $mysql_data = [];
        }
        
		
        break;
    }    
    case 'RelatorioPostoTrabalhoXColaborador':{

        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $colaboradores_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        //$dia_semana = $_REQUEST['dia_semana'];
        
        $resultado = "";

                
        $query = $agenda_colaborador_padraodao->RelatorioPostoTrabalhoXColaborador($colaboradores_pk,$leads_pk);

        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_status"=>$query[$i]['ds_status'],
                    "ds_re"=>$query[$i]['ds_re'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_status_colaborador"=>$query[$i]['ds_status_colaborador'],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "periodo"=>$query[$i]['periodo'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    
                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarPostoTrabalhoColaboradorEscala':{

        $colaboradores_pk = $_REQUEST['colaboradores_pk'];
        
        $resultado = "";
        
        
        $queryl = $agenda_colaborador_padraodao->listarLeadsPorColaboradorAgenda("","",$colaboradores_pk,"");
        
        if(count($queryl) > 0){
            for($l = 0; $l < count($queryl); $l++){
                $query = $agenda_colaborador_padraodao->listarPostoTrabalhoColaboradorEscala($colaboradores_pk,$queryl[$l]['leads_pk']);

        
                $result  = 'success';
                $message = 'query success';

                if(count($query) > 0){
                    for($i = 0; $i < count($query); $i++){
                        $mysql_data[] = array(
                            "ds_lead"=>$query[$i]['ds_lead'],
                            "leads_pk"=>$query[$i]['leads_pk'],
                            "ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                            "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana']
                        );
                    }
                }
                else{

                    //$mysql_data = [];
                }
            }
        }
        else{

            $mysql_data = [];
        }
        
                
        
		
        break;
    }    
    case 'listarAgendaLeadDataColaborador':{

        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda = $_REQUEST['dt_agenda'];
        $dt_agenda_fim = $_REQUEST['dt_agenda_fim'];
        $dia_semana = $_REQUEST['dia_semana'];
        

        
      
        $resultado = "";
        if($leads_pk!=""){
                
            $query = $agenda_colaborador_padraodao->listarAgendaLeadDataColaborador($leads_pk,$dt_agenda,$dt_agenda_fim,$dia_semana);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($query[$i]['ic_dom']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_dom'];
                    $turnos_pk_escala = $query[$i]['dom_turnos_pk'];
                }
                else if($query[$i]['ic_seg']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_seg'];
                    $turnos_pk_escala = $query[$i]['seg_turnos_pk'];
                }
                else if($query[$i]['ic_ter']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_ter'];
                    $turnos_pk_escala = $query[$i]['ter_turnos_pk'];
                }
                else if($query[$i]['ic_qua']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qua'];
                    $turnos_pk_escala = $query[$i]['qua_turnos_pk'];
                }
                else if($query[$i]['ic_qui']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_qui'];
                    $turnos_pk_escala = $query[$i]['qui_turnos_pk'];
                }
                else if($query[$i]['ic_sex']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sex'];
                    $turnos_pk_escala = $query[$i]['sex_turnos_pk'];
                }
                else if($query[$i]['ic_sab']==1){
                    $ds_turno_escala = $query[$i]['ds_turno_sab'];
                    $turnos_pk_escala = $query[$i]['sab_turnos_pk'];
                }
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$turnos_pk_escala,
                    "t_ds_turnos"=>$ds_turno_escala,
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    
                    "t_dom_ds_turnos"=>$query[$i]['ds_turno_dom'],
                    "t_seg_ds_turnos"=>$query[$i]['ds_turno_seg'],
                    "t_ter_ds_turnos"=>$query[$i]['ds_turno_ter'],
                    "t_qua_ds_turnos"=>$query[$i]['ds_turno_qua'],
                    "t_qui_ds_turnos"=>$query[$i]['ds_turno_qui'],
                    "t_sex_ds_turnos"=>$query[$i]['ds_turno_sex'],
                    "t_sab_ds_turnos"=>$query[$i]['ds_turno_sab'],
                    
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    
                    "t_hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "t_hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "t_hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "t_hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "t_hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "t_hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "t_hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "t_hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    
                    
                    
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    
                    "t_ds_colaboradores_dom"=>$query[$i]['ds_colaborador_dom'],
                    "t_ds_produto_servico_dom"=>$query[$i]['ds_produto_servico_dom'],
                    "hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    
                    "t_ds_colaboradores_seg"=>$query[$i]['ds_colaborador_seg'],
                    "t_ds_produto_servico_seg"=>$query[$i]['ds_produto_servico_seg'],
                    "hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    
                    "t_ds_colaboradores_ter"=>$query[$i]['ds_colaborador_ter'],
                    "t_ds_produto_servico_ter"=>$query[$i]['ds_produto_servico_ter'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    
                    "t_ds_colaboradores_qua"=>$query[$i]['ds_colaborador_qua'],
                    "t_ds_produto_servico_qua"=>$query[$i]['ds_produto_servico_qua'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    
                    "t_ds_colaboradores_qui"=>$query[$i]['ds_colaborador_qui'],
                    "t_ds_produto_servico_qui"=>$query[$i]['ds_produto_servico_qui'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    
                    "t_ds_colaboradores_sex"=>$query[$i]['ds_colaborador_sex'],
                    "t_ds_produto_servico_sex"=>$query[$i]['ds_produto_servico_sex'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    
                    "t_ds_colaboradores_sab"=>$query[$i]['ds_colaborador_sab'],
                    "t_ds_produto_servico_sab"=>$query[$i]['ds_produto_servico_sab'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_ds_colaborador_grid"=>$query[$i]['ds_colaborador_grid'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarAgendaColaboradorDataGrid':{
        if(!permissao("agenda_condominio", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $dt_agenda = $_REQUEST['dt_agenda'];
        $dt_agenda_fim = $_REQUEST['dt_agenda_fim'];
        $dia_semana = $_REQUEST['dia_semana'];
        
        
        
      
        $resultado = "";
        if($colaborador_pk!=""){
            $query = $agenda_colaborador_padraodao->listar_agenda_colaborador_colaborador_data($colaborador_pk,$dt_agenda,$dt_agenda_fim,$dia_semana);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($dia_semana==0){
                    $ds_turno_escala = $query[$i]['ds_turno_dom'];
                    $turnos_pk_escala = $query[$i]['dom_turnos_pk'];
                }
                else if($dia_semana==1){
                    $ds_turno_escala = $query[$i]['ds_turno_seg'];
                    $turnos_pk_escala = $query[$i]['seg_turnos_pk'];
                }
                else if($dia_semana==2){
                    $ds_turno_escala = $query[$i]['ds_turno_ter'];
                    $turnos_pk_escala = $query[$i]['ter_turnos_pk'];
                }
                else if($dia_semana==3){
                    $ds_turno_escala = $query[$i]['ds_turno_qua'];
                    $turnos_pk_escala = $query[$i]['qua_turnos_pk'];
                }
                else if($dia_semana==4){
                    $ds_turno_escala = $query[$i]['ds_turno_qui'];
                    $turnos_pk_escala = $query[$i]['qui_turnos_pk'];
                }
                else if($dia_semana==5){
                    $ds_turno_escala = $query[$i]['ds_turno_sex'];
                    $turnos_pk_escala = $query[$i]['sex_turnos_pk'];
                }
                else if($dia_semana==6){
                    $ds_turno_escala = $query[$i]['ds_turno_sab'];
                    $turnos_pk_escala = $query[$i]['sab_turnos_pk'];
                }
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$turnos_pk_escala,
                    "t_ds_turnos"=>$ds_turno_escala,
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    
                    "t_dom_ds_turnos"=>$query[$i]['ds_turno_dom'],
                    "t_seg_ds_turnos"=>$query[$i]['ds_turno_seg'],
                    "t_ter_ds_turnos"=>$query[$i]['ds_turno_ter'],
                    "t_qua_ds_turnos"=>$query[$i]['ds_turno_qua'],
                    "t_qui_ds_turnos"=>$query[$i]['ds_turno_qui'],
                    "t_sex_ds_turnos"=>$query[$i]['ds_turno_sex'],
                    "t_sab_ds_turnos"=>$query[$i]['ds_turno_sab'],
                    
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    
                    "t_hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                    "t_hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                    "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                    "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                    "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                    "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                    "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                    
                    "t_hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                    "t_hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                    "t_hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                    "t_hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                    "t_hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                    "t_hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                    "t_hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                    
                    
                    
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    
                    "t_ds_colaboradores_dom"=>$query[$i]['ds_colaborador_dom'],
                    "t_ds_colaboradores_seg"=>$query[$i]['ds_colaborador_seg'],
                    "t_ds_colaboradores_ter"=>$query[$i]['ds_colaborador_ter'],
                    "t_ds_colaboradores_qua"=>$query[$i]['ds_colaborador_qua'],
                    "t_ds_colaboradores_qui"=>$query[$i]['ds_colaborador_qui'],
                    "t_ds_colaboradores_sex"=>$query[$i]['ds_colaborador_sex'],
                    "t_ds_colaboradores_sab"=>$query[$i]['ds_colaborador_sab'],
                    
                    "t_ds_colaborador_grid"=>$query[$i]['ds_colaborador_grid'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                    "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                    "tipo_escala"=>$query[$i]['tipo_escala'],
                    "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                    "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                    "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                    "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                    "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                    "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                    "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                    "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                    "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                    "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                    "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                    "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                    
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                    "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                    "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                    "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }  
    case 'listarAgendaColaboradorData':{
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $dt_base = $_REQUEST['dt_base'];
        $dt_base_fim = $_REQUEST['dt_base_fim'];
        $dia = $_REQUEST['Dia'];
        $mes = $_REQUEST['Mes'];
        $ano = $_REQUEST['Ano'];
        $dia_semana = $_REQUEST['dia_semana'];
        
            $resultado = "";
            if($colaborador_pk!=""){
                $query = $agenda_colaborador_padraodao->listar_agenda_colaborador_data($colaborador_pk,$dt_base,$dt_base_fim,$dia_semana);
            }
            else{
                $mysql_data = [];
            }

            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){

                    $mysql_data[] = array(
                        "t_pk" => $query[$i]["pk"],
                        "t_ds_agenda"=>$query[$i]['ds_agenda'],
                        "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                        "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                        "t_turnos_pk"=>$query[$i]['turnos_pk'],
                        "t_ds_turno_dom"=>$query[$i]['ds_turno_dom'],
                        "t_ds_turno_seg"=>$query[$i]['ds_turno_seg'],
                        "t_ds_turno_ter"=>$query[$i]['ds_turno_ter'],
                        "t_ds_turno_qua"=>$query[$i]['ds_turno_qua'],
                        "t_ds_turno_qui"=>$query[$i]['ds_turno_qui'],
                        "t_ds_turno_sex"=>$query[$i]['ds_turno_sex'],
                        "t_ds_turno_sab"=>$query[$i]['ds_turno_sab'],
                        "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                        "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                        "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                        "t_ds_colaboradores_pk"=>$query[$i]['ds_colaborador'],
                        "t_leads_pk"=>$query[$i]['leads_pk'],
                        "t_ds_colaborador_grid"=>$query[$i]['ds_colaborador_grid'],
                        "t_ds_lead"=>$query[$i]['ds_lead'],
                        "t_condominio"=>$query[$i]['condominio'],
                        "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                        "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                        "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],

                        "t_ic_dom"=>$query[$i]['ic_dom'],
                        "t_ic_seg"=>$query[$i]['ic_seg'],
                        "t_ic_ter"=>$query[$i]['ic_ter'],
                        "t_ic_qua"=>$query[$i]['ic_qua'],
                        "t_ic_qui"=>$query[$i]['ic_qui'],
                        "t_ic_sex"=>$query[$i]['ic_sex'],
                        "t_ic_sab"=>$query[$i]['ic_sab'],
                        
                        "t_hr_turno_dom"=>$query[$i]['hr_turno_dom'],
                        "t_hr_turno_seg"=>$query[$i]['hr_turno_seg'],
                        "t_hr_turno_ter"=>$query[$i]['hr_turno_ter'],
                        "t_hr_turno_qua"=>$query[$i]['hr_turno_qua'],
                        "t_hr_turno_qui"=>$query[$i]['hr_turno_qui'],
                        "t_hr_turno_sex"=>$query[$i]['hr_turno_sex'],
                        "t_hr_turno_sab"=>$query[$i]['hr_turno_sab'],
                        "t_hr_turno_dom_saida"=>$query[$i]['hr_turno_dom_saida'],
                        "t_hr_turno_seg_saida"=>$query[$i]['hr_turno_seg_saida'],
                        "t_hr_turno_ter_saida"=>$query[$i]['hr_turno_ter_saida'],
                        "t_hr_turno_qua_saida"=>$query[$i]['hr_turno_qua_saida'],
                        "t_hr_turno_qui_saida"=>$query[$i]['hr_turno_qui_saida'],
                        "t_hr_turno_sex_saida"=>$query[$i]['hr_turno_sex_saida'],
                        "t_hr_turno_sab_saida"=>$query[$i]['hr_turno_sab_saida'],
                        "t_nao_repetir_proxima_semana_pk"=>$query[$i]['nao_repetir_proxima_semana_pk'],
                        "t_ic_nao_repetir"=>$query[$i]['ic_nao_repetir'],
                        "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                        "ds_motivo_cancelamento"=>$query[$i]['ds_motivo_cancelamento'],
                        "tipo_escala"=>$query[$i]['tipo_escala'],
                        "hr_intervalo_seg"=>$query[$i]['hr_intervalo_seg'],
                        "hr_intervalo_ter"=>$query[$i]['hr_intervalo_ter'],
                        "hr_intervalo_qua"=>$query[$i]['hr_intervalo_qua'],
                        "hr_intervalo_qui"=>$query[$i]['hr_intervalo_qui'],
                        "hr_intervalo_sex"=>$query[$i]['hr_intervalo_sex'],
                        "hr_intervalo_sab"=>$query[$i]['hr_intervalo_sab'],
                        "hr_intervalo_saida_seg"=>$query[$i]['hr_intervalo_saida_seg'],
                        "hr_intervalo_saida_ter"=>$query[$i]['hr_intervalo_saida_ter'],
                        "hr_intervalo_saida_qua"=>$query[$i]['hr_intervalo_saida_qua'],
                        "hr_intervalo_saida_qui"=>$query[$i]['hr_intervalo_saida_qui'],
                        "hr_intervalo_saida_sex"=>$query[$i]['hr_intervalo_saida_sex'],
                        "hr_intervalo_saida_sab"=>$query[$i]['hr_intervalo_saida_sab'],
                        
                        "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                        "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                        "turnos_pk"=>$query[$i]['turnos_pk'],
                        "hr_inicio_expediente"=>$query[$i]['hr_inicio_expediente'],
                        "hr_termino_expediente"=>$query[$i]['hr_termino_expediente'],
                        "hr_saida_intervalo"=>$query[$i]['hr_saida_intervalo'],
                        "hr_retorno_intervalo"=>$query[$i]['hr_retorno_intervalo'],
                        "ic_preenchimento_automatico"=>$query[$i]['ic_preenchimento_automatico'],


                        "t_functions" => ""
                    );
                }
            }
            else{

                $mysql_data = [];
            }
        
        
        
		
        break;
    }     
    case 'listarEscalasPostosColaborador':{
        if(!permissao("agenda_colaborador", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $dt_apontamento = dataYMD($_REQUEST['dt_apontamento']);
        
            $resultado = "";
            if($colaborador_pk!=""){
                $query = $agenda_colaborador_padraodao->listarEscalasPostosColaborador($colaborador_pk, $dt_apontamento);
            }
            else{
                $mysql_data = [];
            }

            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){

                    $mysql_data[] = array(
                        "colaborador_pk" => $query[$i]["colaboradores_pk"],
                        "leads_pk"=>$query[$i]['leads_pk'],
                        "agenda_colaborador_padrao_pk"=>$query[$i]['agenda_colaborador_padrao_pk'],
                        "ds_lead"=>$query[$i]['ds_lead'],
                        "ds_escala"=>$query[$i]['ds_escala'],
                        "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                        "ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    );
                }
            }
            else{

                $mysql_data = [];
            }
        
        
        
        
        break;
    }  
    case 'escala_dados_colaborador':{

        $result  = 'success';
        $message = 'query success';
        
        $query = $agenda_colaborador_padraodao->escala_dados_colaborador($colaboradores_pk, $dt_periodo_ini, $dt_periodo_fim, $n_qtde_dias_semana, $leads_pk, $agenda_colaborador_padrao_pk, $tipo_escala);


        $mysql_data[] = array(
            "pk" => $pk
        );   

        $result  = 'success';
        $message = 'Registro salvo com sucesso.';   
    

        break;
    }
    case 'processa_escala':{//Retorna se a escala mes atual é para ou impar
        
        $result = "";
        $query = $agenda_colaborador_padraodao->processa_escala();
        
       /* if(count($query) > 0){
            $mysql_data[] = array(
            );           
        }         */
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso! ';
        break;        
    }  

    case 'cancelarEscalasDemissao':{//Retorna se a escala mes atual é para ou impar

        $result = "";
        $query = $agenda_colaborador_padraodao->cancelarEscalasDemissao($pk);
        
       /* if(count($query) > 0){
            $mysql_data[] = array(
            );           
        }         */
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso! ';
        break;        
    }  


    
    default:{
        break;
    }
}

$agenda_colaborador_padraodao = null;

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
