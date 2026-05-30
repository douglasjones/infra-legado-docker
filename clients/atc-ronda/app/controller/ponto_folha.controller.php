<?
ini_set('max_execution_time', '36000'); //300 seconds = 5 minutes
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/ponto_folha.dao.php";
require_once "../model/ponto_folha.class.php";
require_once "../model/ponto_folha_registro.dao.php";
require_once "../model/ponto_folha_registro.class.php";
require_once "../model/ponto.dao.php";
require_once "../model/ponto.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";
require_once "../model/agenda_colaborador_padrao.dao.php";
require_once "../model/agenda_colaborador_padrao.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];

$arrColaborador = $arrRequest['arrColaborador'];
$dt_periodo_ini = $arrRequest['dt_periodo_ini'];
$dt_periodo_fim = $arrRequest['dt_periodo_fim'];
$obs = $arrRequest['obs'];
$leads_pk = $arrRequest['leads_pk'];
$empresas_pk = $arrRequest['empresas_pk'];
$ic_status = $arrRequest['ic_status'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$ponto_folha_pk = $arrRequest['ponto_folha_pk'];
$dt_registro_ponto = $arrRequest['dt_registro_ponto'];

$ponto_folhadao = new ponto_folhadao();
$ponto_folhadao->setToken($token); 

$ponto_folha_registrodao = new ponto_folha_registrodao();
$ponto_folha_registrodao->setToken($token); 

$pontodao = new pontodao();
$pontodao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

$agenda_colaborador_padraodao = new agenda_colaborador_padraodao();
$agenda_colaborador_padraodao->setToken($token); 

switch($job){
    case 'excluir':{        

        $resultdo = "";        
        $ponto_folha = $ponto_folhadao->carregarPorPk($pk);
        if($ponto_folha->getpk()>0){
            
            //$log_exclusaodao->salvar("ponto_folha",$ponto_folha->getpk());

            $ponto_folha_registrodao->excluir($pk,$colaborador_pk);   

            $ponto_folhadao->excluir_ponto_folha_colaborador($pk);
            $ponto_folhadao->excluir($pk);
                                 
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }else{
            $result  = 'error';
            $message = 'ponto_folha nao encontrado';
        }
        break;
    }
    case 'excluir_apontamento':{
        $ponto_pk = $_REQUEST['pk'];
        if($ponto_pk!=""){
            $pk_folha = $ponto_folhadao->listarPkPontoFolhaRegistro($ponto_pk);
            
            if(count($pk_folha)>0){
                for($i=0;$i<count($pk_folha);$i++){
                    $log_exclusaodao->salvar("ponto_folha_registros", $pk_folha[$i]['pk']);
                }
            }
            $pk_ponto = $ponto_folhadao->listarPkPonto($ponto_pk);

            if(count($pk_ponto)>0){
                for($i=0;$i<count($pk_ponto);$i++){
                    $log_exclusaodao->salvar("ponto", $pk_ponto[$i]['pk']);
                }
            }
        }

        $resultdo = "";
        $ponto = $ponto_folhadao->excluirPontoEPontoFolhaRegistro($ponto_pk);
        
        
        $result  = 'success';
        $message = 'Registro excluído com sucesso.';
        break;
    }
    case 'regerar':{
        $ponto_folha = $ponto_folhadao->carregarPorPk($pk);
        
        $ponto_folha->setpk($pk);
        $ponto_folha->setdt_periodo_ini($dt_periodo_ini);
        $ponto_folha->setdt_periodo_fim($dt_periodo_fim);
        $ponto_folha->setempresas_pk($empresas_pk);
        
        $pk = $ponto_folhadao->regerar($ponto_folha, $arrColaborador, $token);
              
        $mysql_data[] = array(
            'pk'=> $pk
        );        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
//Novo     
    case 'salvar':{  
       
        $ponto_folha = $ponto_folhadao->carregarPorPk($pk);
        
        $ponto_folha->setpk($pk);
        $ponto_folha->setdt_periodo_ini($dt_periodo_ini);
        $ponto_folha->setdt_periodo_fim($dt_periodo_fim);
        $ponto_folha->setobs($obs);
        $ponto_folha->setleads_pk($leads_pk);
        $ponto_folha->setempresas_pk($empresas_pk);

        $pk = $ponto_folhadao->salvar($ponto_folha, $arrColaborador, $token);
              
        $mysql_data[] = array(
            'pk'=> $pk
        );        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }

    case 'listarDadosImpressao':{
      
        $resultado = "";
        $query = $ponto_folhadao->listarDadosImpressao($pk,$colaborador_pk,$leads_pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){  
         
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_periodo"=>$query[$i]['ds_periodo'],                    
                    "ds_empresa"=>$query[$i]['ds_empresa'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_cnpj"=>$query[$i]['ds_cnpj'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "ds_cargo"=>$query[$i]['ds_cargo'],
                    "ds_posto_trabalho"=>$query[$i]['ds_posto_trabalho'],
                    "ds_escala"=>$query[$i]['ds_escala'],
                    "ds_turno"=>$query[$i]['ds_turno'],
                    "ic_folha_finalizada"=>$query[$i]['ic_folha_finalizada'],
                    "ds_hr_expediente"=>$query[$i]['ds_hr_expediente'],
                    "registrosfolha"=>$query[$i]['registrosfolha'],
                    "total_ht"=> $query[$i]['total_ht'],
                    "total_he"=> $query[$i]['total_he'],
                    "total_hf"=> $query[$i]['total_hf'],
                    "total_he50"=> $query[$i]['total_he50'],
                    "total_he100"=> $query[$i]['total_he100'],
                    "total_hadn"=> $query[$i]['total_hadn'],
                    "expediente_diario"=> $query[$i]['expediente_diario'],
                    "dt_admissao"=> $query[$i]['dt_admissao'],
                    "ic_intrajornada"=> $query[$i]['ic_intrajornada'],

        
                    
                    
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }		
        break;
    } 

    case 'listarDadosPrint':{
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $ledas_pk = $_REQUEST['leads_pk'];
        $resultado = "";
        
        $query = $ponto_folhadao->listarDadosPrint($pk,$colaborador_pk,$ledas_pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                
                $query0 = $ponto_folha_registrodao->listarFolhaRegistrosAgrupadoData($query[$i]['ponto_folha_pk'],$query[$i]['colaborador_pk']);
                                   
                for($j = 0; $j < count($query0); $j++){   
     
                    $DadosFolhaRegistros[] = array(
                        "ponto_folha_pk"=>$query0[$j]['ponto_folha_pk'],
                        "ponto_folha_registro_pk"=>$query0[$j]['ponto_folha_registro_pk'],
                        "colaborador_pk"=>$query0[$j]['colaborador_pk'],
                        "dt_registro_ponto"=>$query0[$j]['dt_ponto'],
                        "tipo_ponto_pk"=>$query0[$j]['tipo_ponto_pk'],
                        "hr_ini_expediente"=>$query0[$j]['hr_ini_expediente'],
                        "hr_ini_intervalo"=>$query0[$j]['hr_ini_intervalo'],
                        "hr_fim_intervalo"=>$query0[$j]['hr_fim_intervalo'],
                        "hr_fim_expediente"=>$query0[$j]['hr_fim_expediente'],
                        "hr_trabalhadas"=>$query0[$j]['hr_trabalhadas'],
                        "hr_excedentes"=>$query0[$j]['hr_excedentes'],
                        "hr_faltantes"=>$query0[$j]['hr_faltantes'],
                        "hr_extra50"=>$query0[$j]['hr_extra50'],
                        "hr_extra100"=>$query0[$j]['hr_extra100'],
                        "hr_adicional_noturno"=>$query0[$j]['hr_adicional_noturno'],  
                        "obs"=>$query0[$j]['obs'],
                    );
                }
           
        
                
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_periodo"=>$query[$i]['dt_periodo_ini']." a ".$query[$i]['dt_periodo_fim'],                    
                    "ds_empresa"=>$query[$i]['ds_empresa'],
                    "ds_endereco"=>$query[$i]['ds_endereco']." ,".$query[$i]['ds_numero'],
                    "ds_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "ds_cargo"=>$query[$i]['ds_cargo'],
                    "ds_posto_trabalho"=>$query[$i]['ds_posto_trabalho'],
                    "ds_escala"=>$query[$i]['n_qtde_dias_semana'],
                    "ds_turno"=>$query[$i]['ds_turno'],
                    "ds_hr_expediente"=>$query[$i]['hr_inicio_expediente']." a ".$query[$i]['hr_termino_expediente'],
                    "registrosfolha"=>$DadosFolhaRegistros,
                    "t_functions" => ""
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
        $query = $ponto_folhadao->listarDataTable($empresas_pk,$leads_pk,$colaborador_pk,$dt_periodo_ini,$dt_periodo_fim,$ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_empresa"=>$query[$i]['ds_conta'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_mesesNoAno"=>$query[$i]['mesesNoAno'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }		
        break;
    }    
    //Antigo
    case 'listarFolhasRegstros':{

        $resultado = "";
        $query = $ponto_folhadao->listarFolhasRegstros($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_empresa"=>$query[$i]['ds_conta'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "dt_periodo_ini"=>$query[$i]['dt_periodo_ini'],
                    "dt_periodo_fim"=>$query[$i]['dt_periodo_fim'],
                    "obs"=>$query[$i]['obs']
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
    
    
    //antigo
    case 'listarPk':{
        
        $resultado = "";
        $query = $ponto_folhadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "dt_periodo_ini"=>$query[$i]['dt_periodo_ini'],
                    "dt_periodo_fim"=>$query[$i]['dt_periodo_fim'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "obs"=>$query[$i]['obs']
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
    
    
    
    case 'migrarPontoFolha':{
        
        $resultado = "";
        //LISTA A PARTE DE FOLHA PONTO AGRUPADO .....
        
        $queryP = $ponto_folhadao->query1();


        if(count($queryP)>0){
            for($p=0;$p<count($queryP);$p++){
                //LISTAR OS COLABORADORES VINCULADOS AO PONTO FOLHA 


                


                $query1 = $ponto_folhadao->query2($queryP[$p]['leads_pk'],$queryP[$p]['dt_periodo_ini'],$queryP[$p]['dt_periodo_fim']);
                if(count($query1)>0){
                    //SALVAR PONTO NOVO 

                    $ponto_folha = $ponto_folhadao->carregarPorPk(0);

                    $ponto_folha->setdt_periodo_ini($queryP[$p]['dt_periodo_ini']);
                    $ponto_folha->setdt_periodo_fim($queryP[$p]['dt_periodo_fim']);
                    $ponto_folha->setleads_pk($queryP[$p]['leads_pk']);


                    $novo_ponto_folhapk = $ponto_folhadao->salvar($ponto_folha);

                    //LISTA OS COLABORADORES DE ACORDO COM O PONTO FOLHA ANTIGO
                    for($j=0;$j<count($query1);$j++){

                        //SALVA OS REGISTROS NA TABELA PONTO_FOLHA_COLABORADOR
                  
                        $colaborador_ponto_folha_pk = $ponto_folhadao->salvarColaborador($novo_ponto_folhapk,$query1[$j]['colaborador_pk']);


                        //APOS SALVAR, FAZ TODA A VERIFICAÇÃO DE REGISTRO DE PONTO PARA SALVAR A NA NOVA TABELA PONTO_FOLHA_REGISTRO 

                        //SALVA OS REGISTROS DE PONTO NA FOLHA 
                       $query0 = $pontodao->carregarColaboradorSalvarRegistroPontoFolha($query1[$j]['colaborador_pk'],$queryP[$p]['dt_periodo_ini'],$queryP[$p]['dt_periodo_fim'],$queryP[$p]['leads_pk']);

                        $ds_legenda[] = "";
                        if(count($query0)>0){
                            for($s = 0; $s < count($query0); $s++){

                                //PEGA TODA A REGRA DE VISUALIZAÇÃO DOS HORARIOS DE PONTO
                                $diasemana_numero = date('w', strtotime(DataYMD($query0[$s]['dt_ponto'])));

                                $resultado = "";
                                $query = $pontodao->folhaPonto($query0[$s]['leads_pk'],$query0[$s]['colaborador_pk'],$query0[$s]['dt_ponto'],$query0[$s]['dt_ponto'],$diasemana_numero,$query0[$s]['ic_inverter_folga']);

                                if(count($query) >= 0){
                                    for($i = 0; $i < count($query); $i++){

                                        $ds_total_horas_trabalhadas = "";
                                        $coordernadas_lead = "";
                                        $latitude_lead = "";
                                        $longitude_lead = "";
                                        $distancia_entre_pontos = "";
                                        $endereco_ponto = "";
                                        $ds_registro_ponto = "";

                                        $diasemana_numero = date('w', strtotime($data));

                                        $horaA = "";
                                        $horaB = "";
                                        $hr_diferenca = "";

                                        //if($diasemana_numero==0){
                                            if($query[$i]['ic_dom']==1){
                                                $horaA = $query[$i]['hr_entrada'];
                                                $horaB = $query[$i]['hr_turno_dom'].':00';
                                                $horac = $query[$i]['hr_turno_dom_saida'].':00';

                                                $hr_diferenca = calculaTempo($horaB, $horaA);
                                            }

                                        //}
                                        //else if($diasemana_numero==1){
                                            if($query[$i]['ic_seg']==1){
                                                $horaA = $query[$i]['hr_entrada'];
                                                $horaB = $query[$i]['hr_turno_seg'].':00';
                                                $horac = $query[$i]['hr_turno_seg_saida'].':00';

                                                $hr_diferenca = calculaTempo($horaB, $horaA);
                                            }
                                        //}
                                        //else if($diasemana_numero==2){
                                            if($query[$i]['ic_ter']==1){
                                                $horaA = $query[$i]['hr_entrada'];
                                                $horaB = $query[$i]['hr_turno_ter'].':00';
                                                $horac = $query[$i]['hr_turno_ter_saida'].':00';

                                                $hr_diferenca = calculaTempo($horaB, $horaA);
                                            }
                                        //}
                                        //if($diasemana_numero==3){
                                            if($query[$i]['ic_qua']==1){
                                                $horaA = $query[$i]['hr_entrada'];
                                                $horaB = $query[$i]['hr_turno_qua'].':00';
                                                $horac = $query[$i]['hr_turno_qua_saida'].':00';

                                                $hr_diferenca = calculaTempo($horaB, $horaA);
                                            }
                                        //}
                                        //else if($diasemana_numero==4){
                                            if($query[$i]['ic_qui']==1){
                                                $horaA = $query[$i]['hr_entrada'];
                                                $horaB = $query[$i]['hr_turno_qui'].':00';
                                                $horac = $query[$i]['hr_turno_qui_saida'].':00';

                                                $hr_diferenca = calculaTempo($horaB, $horaA);

                                            }
                                        //}
                                        //else if($diasemana_numero==5){
                                            if($query[$i]['ic_sex']==1){
                                                $horaA = $query[$i]['hr_entrada'];
                                                $horaB = $query[$i]['hr_turno_sex'].':00';
                                                $horac = $query[$i]['hr_turno_sex_saida'].':00';

                                                $hr_diferenca = calculaTempo($horaB, $horaA);
                                            }
                                        //}
                                        //if($diasemana_numero==6){
                                           if($query[$i]['ic_sab']==1){
                                                $horaA = $query[$i]['hr_entrada'];
                                                $horaB = $query[$i]['hr_turno_sab'].':00';
                                                $horac = $query[$i]['hr_turno_sab_saida'].':00';

                                                $hr_diferenca = calculaTempo($horaB, $horaA);
                                            }
                                        //}



                                        $segundos = converterHoraPMinuto($hr_diferenca);

                                        $tipo_ponto_pk = "";
                                        $dt_rh_entratada = "";
                                        $ponto_pk_entratada = "";
                                        $dt_hora_ponto_entrada = "";
                                        $dt_rh_saida = "";
                                        $ponto_pk_saida = "";
                                        $dt_hora_ponto_saida = "";
                                        $ponto_pk_saida_intervalo = "";
                                        $dt_rh_saida_intervalo = "";
                                        $dt_hora_ponto_saida_intervalo = "";
                                        $dt_rh_entratada_retorno = "";
                                        $dt_hora_ponto_entrada_retorno = "";
                                        $ponto_pk_volta_intervalo = "";


                                        if($i==0){
                                            if($query[$i]['tipo_ponto_pk']==1){
                                                $ponto_pk_entratada = $query[$i]['ponto_pk'];
                                                $dt_rh_entratada = $query[$i]['hr_entrada'];
                                                $dt_hora_ponto_entrada = $query[$i]['dt_hora_ponto_registro_folha'];          
                                                $hr_entrada = $query[$i]['hr_entrada'];
                                                $ds_registro_ponto = $query[$i]['hr_entrada'];
                                                $ds_legenda[$i] = "Inicio Expediente";
                                                $tipo_ponto_pk = 1;
                                            }
                                            if($query[$i]['tipo_ponto_pk']==2){
                                                $ponto_pk_saida = $query[$i]['ponto_pk'];
                                                $dt_rh_saida= $query[$i]['hr_entrada'];
                                                $dt_hora_ponto_saida = $query[$i]['dt_hora_ponto_registro_folha'];   
                                                $ds_registro_ponto = $query[$i]['hr_entrada'];
                                                $hr_saida = $query[$i]['hr_entrada'];
                                                $ds_legenda[$i] = "Fim Expediente";
                                                $tipo_ponto_pk = 2;
                                            }
                                            if($query[$i]['tipo_ponto_pk']==3){
                                                $ponto_pk_saida_intervalo = $query[$i]['ponto_pk'];
                                                $dt_rh_saida_intervalo = $query[$i]['hr_entrada'];
                                                $dt_hora_ponto_saida_intervalo = $query[$i]['dt_hora_ponto_registro_folha']; 
                                                $ds_registro_ponto = $query[$i]['hr_entrada'];
                                                $ds_legenda[$i] = "Saída p/ Intervalo";
                                                $tipo_ponto_pk = 3;

                                            }
                                            if($query[$i]['tipo_ponto_pk']==4){
                                                $ponto_pk_volta_intervalo= $query[$i]['ponto_pk'];
                                                $dt_rh_entratada_retorno = $query[$i]['hr_entrada'];
                                                $dt_hora_ponto_entrada_retorno = $query[$i]['dt_hora_ponto_registro_folha'];  

                                                $ds_registro_ponto = $query[$i]['hr_entrada'];
                                                $ds_legenda[$i] = "Retorno do Intervalo";
                                                $tipo_ponto_pk = 4;

                                            }
                                        }
                                        else{
                                            if($query[$i]['tipo_ponto_pk']==1){
                                                $ponto_pk_entratada = $query[$i]['ponto_pk'];
                                                $dt_rh_entratada_retorno = $query[$i]['hr_entrada'];
                                                $dt_hora_ponto_entrada_retorno = $query[$i]['dt_hora_ponto_registro_folha'];  

                                                $ds_registro_ponto = $query[$i]['hr_entrada'];
                                                $ds_legenda[$i] = "Retorno do Intervalo";
                                                $tipo_ponto_pk = 4;
                                            }
                                            if($query[$i]['tipo_ponto_pk']==2){
                                                $hr_diferenca_ponto = calculaTempo($query[0]['hr_entrada'],$query[$i]['hr_entrada']);
                                                $segundos_ponto = converterHoraPMinuto($hr_diferenca_ponto);

                                                if($segundos_ponto<="25200"){

                                                    if(($i+1)==count($query)){
                                                        $ponto_pk_saida = $query[$i]['ponto_pk'];
                                                        $dt_rh_saida= $query[$i]['hr_entrada'];
                                                        $dt_hora_ponto_saida = $query[$i]['dt_hora_ponto_registro_folha'];   
                                                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                                                        $hr_saida = $query[$i]['hr_entrada'];
                                                        $ds_legenda[$i] = "Fim Expediente";
                                                        $tipo_ponto_pk = 2;
                                                    }
                                                    else{
                                                        $ponto_pk_saida_intervalo = $query[$i]['ponto_pk'];
                                                        $dt_rh_saida_intervalo = $query[$i]['hr_entrada'];
                                                        $dt_hora_ponto_saida_intervalo = $query[$i]['dt_hora_ponto_registro_folha']; 
                                                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                                                        $ds_legenda[$i] = "Saída p/ Intervalo";
                                                        $tipo_ponto_pk = 3;
                                                    }



                                                }
                                                else if($segundos_ponto > "25200"){
                                                    $ponto_pk_saida = $query[$i]['ponto_pk'];
                                                    $dt_rh_saida= $query[$i]['hr_entrada'];
                                                    $dt_hora_ponto_saida = $query[$i]['dt_hora_ponto_registro_folha'];   
                                                    $ds_registro_ponto = $query[$i]['hr_entrada'];
                                                    $hr_saida = $query[$i]['hr_entrada'];
                                                    $ds_legenda[$i] = "Fim Expediente";
                                                    $tipo_ponto_pk = 2;
                                                }


                                            }
                                            if($query[$i]['tipo_ponto_pk']==3){
                                                $ponto_pk_saida_intervalo = $query[$i]['ponto_pk'];
                                                $dt_rh_saida_intervalo = $query[$i]['hr_entrada'];
                                                $dt_hora_ponto_saida_intervalo = $query[$i]['dt_hora_ponto_registro_folha']; 
                                                $ds_registro_ponto = $query[$i]['hr_entrada'];
                                                $ds_legenda[$i] = "Saída p/ Intervalo";
                                                $tipo_ponto_pk = 3;

                                            }
                                            if($query[$i]['tipo_ponto_pk']==4){
                                                $ponto_pk_volta_intervalo= $query[$i]['ponto_pk'];
                                                $dt_rh_entratada_retorno = $query[$i]['hr_entrada'];
                                                $dt_hora_ponto_entrada_retorno = $query[$i]['dt_hora_ponto_registro_folha'];  

                                                $ds_registro_ponto = $query[$i]['hr_entrada'];
                                                $ds_legenda[$i] = "Retorno do Intervalo";
                                                $tipo_ponto_pk = 4;

                                            }
                                        }

                                        
                                        //Salva os pontos na tabela de registro de folha ponto    
                                        $ponto_folha_registro = $ponto_folha_registrodao->carregarPorPk(0);
                                        $ponto_folha_registro->setponto_pk($query[$i]['ponto_pk']);
                                        $ponto_folha_registro->settipo_ponto_pk($tipo_ponto_pk);

                                        if($tipo_ponto_pk==1){
                                            $ponto_folha_registro->setdt_hora_ponto($dt_hora_ponto_entrada);
                                        }
                                        else if($tipo_ponto_pk==2){
                                            $ponto_folha_registro->setdt_hora_ponto($dt_hora_ponto_saida);
                                        }
                                        else if($tipo_ponto_pk==3){
                                            $ponto_folha_registro->setdt_hora_ponto($dt_hora_ponto_saida_intervalo);
                                        }
                                        else if($tipo_ponto_pk==4){
                                            $ponto_folha_registro->setdt_hora_ponto($dt_hora_ponto_entrada_retorno);
                                        }

                                        $ponto_folha_registro->settipo_registr_folha($tipo_registr_folha);
                                        $ponto_folha_registro->setponto_folha_pk($novo_ponto_folhapk);


                                        $pk_registro = $ponto_folha_registrodao->salvar($ponto_folha_registro);

                                    }
                                }
                            }
                        }

                    }
                }

            }
        }
        
        $queryDel = $ponto_folhadao->listarPontoFolhaAntigo();
        
        if(count($queryDel)>0){
            for($i=0;$i<count($queryDel);$i++){
                $ponto_folha = $ponto_folhadao->carregarPorPk($queryDel[$i]['pk']);
                if($ponto_folha->getpk()>0){

                    $ponto_folhadao->excluir($ponto_folha);

                    $result  = 'success';
                    $message = 'Registro excluído com sucesso.';

                }
                else{
                    $result  = 'error';
                    $message = 'ponto_folha nao encontrado';
                }
            }
        }
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'salvarApontamentoPontoEPontoFolha':{
        
        $pk = $_REQUEST['pk'];
        $ponto_folha_pk = $_REQUEST['ponto_folha_pk'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $tipo_ponto_pk = $_REQUEST['tipo_ponto_pk'];
        $dt_hora_ponto = $_REQUEST['dt_hora_ponto'];
        $hr_ponto = $_REQUEST['hr_ponto'];
       
        
        
        $ponto = $pontodao->carregarPorPk($pk);
        $ponto->setds_pin($ds_pin);
        $ponto->setcolaborador_pk($colaborador_pk);
        $ponto->settipo_ponto_pk($tipo_ponto_pk);
        $ponto->setdt_hora_ponto(dataYMD($dt_hora_ponto)." ".$hr_ponto);
        $ponto->setds_localizacao($ds_localizacao);
        $ponto->setds_imagem($ds_imagem);
        $ponto->setponto_origem_pk($ponto_origem_pk);
        $ponto->setic_dispositivo($ic_dispositivo);       
        $ponto->setic_status_conferencia($ic_status_conferencia);
        $ponto->setds_total_horas_trabalhadas($ds_total_horas_trabalhadas);        
        
        $ponto_n_pk = $pontodao->salvar($ponto);
        
        
        if($pk==0){
            $ponto_folha_registro = $ponto_folha_registrodao->carregarPorPontoPk(0);
            $ponto_pk = $ponto_n_pk;
            
        }
        else{
            
            $ponto_pk = $pk;
            $ponto_folha_registro = $ponto_folha_registrodao->carregarPorPontoPk($ponto_pk);
            
        }
        
        
        
        
        
        $ponto_folha_registro->setponto_pk($ponto_pk);
        $ponto_folha_registro->settipo_ponto_pk($tipo_ponto_pk);
        $ponto_folha_registro->setdt_hora_ponto(dataYMD($dt_hora_ponto)." ".$hr_ponto);
        $ponto_folha_registro->settipo_registr_folha("");
        $ponto_folha_registro->setponto_folha_pk($ponto_folha_pk);

        
        $pk = $ponto_folha_registrodao->salvar($ponto_folha_registro);
        
        $mysql_data[] = array(
            "pk" => $pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;  
    }    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $ponto_folhadao->listar_por_colaborador_pk($colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "dt_periodo_ini"=>$query[$i]['dt_periodo_ini'],
                    "dt_periodo_fim"=>$query[$i]['dt_periodo_fim'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "obs"=>$query[$i]['obs']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }

    case 'listarGridPontoFolhaPostoTrabalho':{
        $leads_pk= $_REQUEST['leads_pk'];
        $ic_modal_exibicao= $_REQUEST['ic_modal_exibicao'];
        $dt_periodo_ini= $_REQUEST['dt_periodo_ini'];
        $dt_periodo_fim= $_REQUEST['dt_periodo_fim'];
        $colaborador_pk= $_REQUEST['colaborador_pk'];
        
        
        $resultado = "";
        $query = $ponto_folhadao->listarGridPontoFolhaPostoTrabalho($leads_pk,$dt_periodo_ini,$dt_periodo_fim,$colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_dt_periodo_ini"=>$query[$i]['dt_periodo_ini'],
                    "t_dt_periodo_fim"=>$query[$i]['dt_periodo_fim'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_obs"=>$query[$i]['obs'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarImpressaoPontoFolhaPostoTrabalho':{
        $pk= $_REQUEST['pk'];
        $leads_pk= $_REQUEST['leads_pk'];
        $ic_modal_exibicao= $_REQUEST['ic_modal_exibicao'];
        $dt_periodo_ini= $_REQUEST['dt_periodo_ini'];
        $dt_periodo_fim= $_REQUEST['dt_periodo_fim'];
        $colaborador_pk= $_REQUEST['colaborador_pk'];
        
        
        $resultado = "";
        $query = $ponto_folhadao->listarImpressaoPontoFolhaPostoTrabalho($pk,$leads_pk,$dt_periodo_ini,$dt_periodo_fim,$colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_dt_periodo_ini"=>$query[$i]['dt_periodo_ini'],
                    "t_dt_periodo_fim"=>$query[$i]['dt_periodo_fim'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_obs"=>$query[$i]['obs'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarModalPontoFolhaPostoTrabalho':{
        $pk= $_REQUEST['pk'];
        $leads_pk= $_REQUEST['leads_pk'];
        $ic_modal_exibicao= $_REQUEST['ic_modal_exibicao'];
        $dt_periodo_ini= $_REQUEST['dt_periodo_ini'];
        $dt_periodo_fim= $_REQUEST['dt_periodo_fim'];
        $colaborador_pk= $_REQUEST['colaborador_pk'];
        
        
        $resultado = "";
        $query = $ponto_folhadao->listarModalPontoFolhaPostoTrabalho($pk,$leads_pk,$dt_periodo_ini,$dt_periodo_fim,$colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_dt_periodo_ini"=>$query[$i]['dt_periodo_ini'],
                    "t_dt_periodo_fim"=>$query[$i]['dt_periodo_fim'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_obs"=>$query[$i]['obs'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarPontoColaborador':{
        $pk= $_REQUEST['pk'];
        $leads_pk= $_REQUEST['leads_pk'];
        $ic_modal_exibicao= $_REQUEST['ic_modal_exibicao'];
        $dt_periodo_ini= $_REQUEST['dt_periodo_ini'];
        $dt_periodo_fim= $_REQUEST['dt_periodo_fim'];
        $colaborador_pk= $_REQUEST['colaborador_pk'];
        
        
        $resultado = "";
        $query = $ponto_folhadao->listarPontoColaborador($pk,$leads_pk,$dt_periodo_ini,$dt_periodo_fim,$colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                
                $dt_rh_entratada = "";
                $ponto_pk_entratada = "";
                $dt_hora_ponto_entrada = "";
                $dt_rh_saida = "";
                $ponto_pk_saida = "";
                $dt_hora_ponto_saida = "";
                $ponto_pk_saida_intervalo = "";
                $dt_rh_saida_intervalo = "";
                $dt_hora_ponto_saida_intervalo = "";
                $dt_rh_entratada_retorno = "";
                $dt_hora_ponto_entrada_retorno = "";
                $ponto_pk_volta_intervalo = "";
                
                
                if($query[$i]['tipo_ponto_pk']==1){
                    $ponto_pk_entratada = $query[$i]['ponto_pk'];
                    $dt_rh_entratada = $query[$i]['hr_entrada'];
                    $dt_hora_ponto_entrada = $query[$i]['dt_hora_ponto'];          
                    $hr_entrada = $query[$i]['hr_entrada'];
                    $ds_registro_ponto = $query[$i]['hr_entrada'];
                    $ds_legenda[$i] = "Inicio Expediente";
                }
                if($query[$i]['tipo_ponto_pk']==2){
                    $ponto_pk_saida = $query[$i]['ponto_pk'];
                    $dt_rh_saida= $query[$i]['hr_entrada'];
                    $dt_hora_ponto_saida = $query[$i]['dt_hora_ponto'];   
                    $ds_registro_ponto = $query[$i]['hr_entrada'];
                    $hr_saida = $query[$i]['hr_entrada'];
                    $ds_legenda[$i] = "Fim Expediente";
                }
                if($query[$i]['tipo_ponto_pk']==3){
                    $ponto_pk_saida_intervalo = $query[$i]['ponto_pk'];
                    $dt_rh_saida_intervalo = $query[$i]['hr_entrada'];
                    $dt_hora_ponto_saida_intervalo = $query[$i]['dt_hora_ponto']; 
                    $ds_registro_ponto = $query[$i]['hr_entrada'];
                    $ds_legenda[$i] = "Saída p/ Intervalo";

                }
                if($query[$i]['tipo_ponto_pk']==4){
                    $ponto_pk_volta_intervalo= $query[$i]['ponto_pk'];
                    $dt_rh_entratada_retorno = $query[$i]['hr_entrada'];
                    $dt_hora_ponto_entrada_retorno = $query[$i]['dt_hora_ponto'];  

                    $ds_registro_ponto = $query[$i]['hr_entrada'];
                    $ds_legenda[$i] = "Retorno do Intervalo";

                }
                
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ponto_pk_entratada" => $ponto_pk_entratada,
                    "ponto_pk_saida" => $ponto_pk_saida,
                    "ponto_pk_saida_intervalo" => $ponto_pk_saida_intervalo,
                    "ponto_pk_volta_intervalo" => $ponto_pk_volta_intervalo,

                    "dt_hora_ponto_entrada"=>$dt_hora_ponto_entrada,
                    "dt_rh_entratada"=>$dt_rh_entratada,  
                    "dt_hora_ponto_saida"=>$dt_hora_ponto_saida,
                    "dt_rh_saida"=>$dt_rh_saida, 


                    "dt_hora_ponto_saida_intervalo"=>$dt_hora_ponto_saida_intervalo,
                    "dt_rh_saida_intervalo"=>$dt_rh_saida_intervalo,

                    "dt_hora_ponto_entrada_retorno"=>$dt_hora_ponto_entrada_retorno,
                    "dt_rh_entratada_retorno"=>$dt_rh_entratada_retorno,  
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "dt_hora_ponto"=>$query[$i]['dt_hora_ponto'],
                    "ds_legenda"=>$ds_legenda[$i]

                );

            }
        }
                else{
                    
                    $mysql_data = [];
                }
                break;
    }    
    case 'listarPorColaborador':{
        
        
        $resultado = "";
        $colaborador_pk = $_REQUEST['colaboradores_pk'];
        if($colaborador_pk!=""){
           $query = $ponto_folhadao->listarPorColaborador($colaborador_pk);
        
            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){

                    $mysql_data[] = array(
                        "t_pk" => $query[$i]["pk"],
                        "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                        "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                        "t_dt_periodo_ini"=>$query[$i]['dt_periodo_ini'],
                        "t_dt_periodo_fim"=>$query[$i]['dt_periodo_fim'],
                        "t_leads_pk"=>$query[$i]['leads_pk'],
                        "t_obs"=>$query[$i]['obs'],

                        "t_functions" => ""
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

    case 'listarDadosPrintAll':{

        $resultado = "";       
        
        $result  = 'success';
        $message = 'query success';

        $query = $ponto_folhadao->listarDadosPrintAll($ponto_folha_pk,$leads_pk);
        
        if(count($query) > 0){

            for($i = 0; $i < count($query); $i++){ 

                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_periodo"=>$query[$i]['ds_periodo'],                    
                    "ds_empresa"=>$query[$i]['ds_empresa'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_cnpj"=>$query[$i]['ds_cnpj'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "ds_cargo"=>$query[$i]['ds_cargo'],
                    "ds_posto_trabalho"=>$query[$i]['ds_posto_trabalho'],
                    "ds_escala"=>$query[$i]['ds_escala'],
                    "ds_turno"=>$query[$i]['ds_turno'],
                    "ds_hr_expediente"=>$query[$i]['hr_inicio_expediente'],
                    "registrosfolha"=>$query[$i]['registrosfolha'],
                    "total_ht"=> $query[$i]['total_ht'],
                    "total_he"=> $query[$i]['total_he'],
                    "total_hf"=> $query[$i]['total_hf'],
                    "total_he50"=> $query[$i]['total_he50'],
                    "total_he100"=> $query[$i]['total_he100'],
                    "total_hadn"=> $query[$i]['total_hadn'],
                    "expediente_diario"=> $query[$i]['expediente_diario'],
                    "dt_admissao"=> $query[$i]['dt_admissao'],
                    
                    "t_functions" => ""
                ); 
            } 

            
        }
        else{
            $mysql_data = [];
        }		
        break;
    }

}

$ponto_folhadao = null;

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
