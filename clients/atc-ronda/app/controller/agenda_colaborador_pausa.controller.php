<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/agenda_colaborador_pausa.dao.php";
require_once "../model/agenda_colaborador_pausa.class.php";
require_once "../model/ocorrencia.dao.php";
require_once "../model/ocorrencia.class.php";
require_once "../model/colaborador.dao.php";
require_once "../model/colaborador.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";

require_once "../model/afastamento_ferias_colaborador.dao.php";
require_once "../model/afastamento_ferias_colaborador.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_agenda_colaborador_pausa = $arrRequest['ds_agenda_colaborador_pausa'];
$dt_inicio_pausa = $arrRequest['dt_inicio_pausa'];
$dt_fim_pausa = $arrRequest['dt_fim_pausa'];
$motivos_pausas_pk = $arrRequest['motivos_pausas_pk'];
$colaboradores_pk = $arrRequest['colaboradores_pk'];
$turnos_pk = $arrRequest['turnos_pk'];
$colaborador_substituto_pk = $arrRequest['colaborador_substituto_pk'];
$leads_pk = $arrRequest['leads_pk'];
$ds_obs_exclusao = $arrRequest['ds_obs_exclusao'];
$motivo_exclusao_pk = $arrRequest['motivo_exclusao_pk'];
$motivo_folga_pk = $arrRequest['motivo_folga_pk'];
$ds_obs_folga = $arrRequest['ds_obs_folga'];


$agenda_colaborador_pausadao = new agenda_colaborador_pausadao();
$agenda_colaborador_pausadao->setToken($token); 

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token); 

$colaboradordao = new colaboradordao();
$colaboradordao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

$afastamento_ferias_colaboradordao = new afastamento_ferias_colaboradordao();
$afastamento_ferias_colaboradordao->setToken($token); 


switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $agenda_colaborador_pausa = $agenda_colaborador_pausadao->carregarPorPk($pk);
        if($agenda_colaborador_pausa->getpk()>0){
            
            $log_exclusaodao->salvar("agenda_colaborador_pausa",$agenda_colaborador_pausadao->getpk());
            
            $agenda_colaborador_pausadao->excluir($agenda_colaborador_pausa);
            
            $result  = 'success';
            $message = 'Registro excluÃ­do com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'agenda_colaborador_pausa nao encontrado';
        }
        break;
    }
    case 'excluirColaboradorTroca':{
        
        $resultdo = "";
        $agenda_colaborador_pausa = $agenda_colaborador_pausadao->carregarTroca($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk);
        
        if($agenda_colaborador_pausa->getpk()>0){
            
           $agenda_colaborador_pausadao->excluir($agenda_colaborador_pausa);
            
            

        }
        $result  = 'success';
        $message = 'Registro excluÃ­do com sucesso.';

        break;
    }
    case 'excluirCobertura':{
        
        $resultdo = "";
        $agenda_colaborador_pausa = $agenda_colaborador_pausadao->excluirCobertura($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk);
        
        if($agenda_colaborador_pausa->getpk()>0){
            
           $agenda_colaborador_pausadao->excluir($agenda_colaborador_pausa);
            
            

        }
        $result  = 'success';
        $message = 'Registro excluÃ­do com sucesso.';

        break;
    }
    case 'excluirColaboradorFolga':{
        
        $resultdo = "";
        $agenda_colaborador_pausa = $agenda_colaborador_pausadao->carregarFolga($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk);
        
        if($agenda_colaborador_pausa->getpk()>0){
            
           $agenda_colaborador_pausadao->excluir($agenda_colaborador_pausa);
            
            

        }
        $result  = 'success';
        $message = 'Registro excluÃ­do com sucesso.';

        break;
    }
    case 'excluirColaboradorExclusao':{
        
        $resultdo = "";
        $agenda_colaborador_pausa = $agenda_colaborador_pausadao->carregarExclusao($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk);
        
        if($agenda_colaborador_pausa->getpk()>0){
            
           $agenda_colaborador_pausadao->excluir($agenda_colaborador_pausa);
            
            

        }
        $result  = 'success';
        $message = 'Registro excluÃ­do com sucesso.';

        break;
    }
    case 'excluirColaboradorFerias':{
        
        $resultdo = "";
        $agenda_colaborador_pausa = $agenda_colaborador_pausadao->carregarFerias($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk);
        
        if($agenda_colaborador_pausa->getpk()>0){
            
           $agenda_colaborador_pausadao->excluir($agenda_colaborador_pausa);
            
            

        }
        $result  = 'success';
        $message = 'Registro excluÃ­do com sucesso.';

        break;
    }
    case 'carregarExclusaoNovaEscala':{
        
        $resultdo = "";
        $agenda_colaborador_pausa = $agenda_colaborador_pausadao->carregarExclusaoNovaEscala($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk);
        
        if($agenda_colaborador_pausa->getpk()>0){
            
           $agenda_colaborador_pausadao->excluir($agenda_colaborador_pausa);
            
            

        }
        $result  = 'success';
        $message = 'Registro excluÃ­do com sucesso.';

        break;
    }
    case 'salvar':{
        
        $agenda_colaborador_pausa = $agenda_colaborador_pausadao->carregarPorPk($pk);
        $agenda_colaborador_pausa->setds_agenda_colaborador_pausa($ds_agenda_colaborador_pausa);
        $agenda_colaborador_pausa->setdt_inicio_pausa(DataYMD($dt_inicio_pausa));
        $agenda_colaborador_pausa->setdt_fim_pausa(DataYMD($dt_fim_pausa));
        $agenda_colaborador_pausa->setmotivos_pausas_pk($motivos_pausas_pk);
        $agenda_colaborador_pausa->setcolaboradores_pk($colaboradores_pk);
        $agenda_colaborador_pausa->setturnos_pk($turnos_pk);
        $agenda_colaborador_pausa->setcolaborador_substituto_pk($colaborador_substituto_pk);
        $agenda_colaborador_pausa->setmotivo_exclusao_pk($motivo_exclusao_pk);
        $agenda_colaborador_pausa->setds_obs_exclusao($ds_obs_exclusao);
        $agenda_colaborador_pausa->setmotivo_folga_pk($motivo_folga_pk);
        $agenda_colaborador_pausa->setds_obs_folga($ds_obs_folga);
        

        
        $pk = $agenda_colaborador_pausadao->salvar($agenda_colaborador_pausa);
        
        
        if($colaborador_substituto_pk!=""){
            $ds_colaborador_antigo = $colaboradordao->listarPorPk($colaboradores_pk);
            $ds_colaborador_substituto = $colaboradordao->listarPorPk($colaborador_substituto_pk);
        
        
            $ocorrencia = $ocorrenciadao->carregarPorPk("");

            $ocorrencia->setds_ocorrencia("O colaborador ".$ds_colaborador_antigo[0]['ds_colaborador']." foi substituido pelo colaborador ".$ds_colaborador_substituto[0]['ds_colaborador']." no dia ".$dt_inicio_pausa);
            $ocorrencia->settipos_ocorrencias_pk(1);
            $ocorrencia->setdt_fechamento(1);
            $ocorrencia->setleads_pk($leads_pk);
            
            $ocorrencias_pk = $ocorrenciadao->salvar($ocorrencia);
        }
        

        
        
        
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $agenda_colaborador_pausadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "dt_fim_pausa"=>$query[$i]['dt_fim_pausa'],
                    "motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "colaborador_substituto_pk"=>$query[$i]['colaborador_substituto_pk'],
                    "motivo_folga_pk"=>$query[$i]['motivo_folga_pk'],
                    "ds_obs_folga"=>$query[$i]['ds_obs_folga'],
                    "turnos_pk"=>$query[$i]['turnos_pk']
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
    case 'datediff':{
        $dt_inicio = $_REQUEST['dt_inicio'];
        $dt_fim = $_REQUEST['dt_fim'];
        
        $resultado = "";
        $query = $agenda_colaborador_pausadao->datediff($dt_inicio,$dt_fim);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "diferenca" => $query[$i]["diferenca"],
                    
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
        $query = $agenda_colaborador_pausadao->listar_por_ds_agenda_colaborador_pausa($ds_agenda_colaborador_pausa);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "dt_fim_pausa"=>$query[$i]['dt_fim_pausa'],
                    "motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "colaborador_substituto_pk"=>$query[$i]['colaborador_substituto_pk'],
                    "motivo_folga_pk"=>$query[$i]['motivo_folga_pk'],
                    "ds_obs_folga"=>$query[$i]['ds_obs_folga'],
                    "turnos_pk"=>$query[$i]['turnos_pk']
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
        $query = $agenda_colaborador_pausadao->listar_por_ds_agenda_colaborador_pausa($ds_agenda_colaborador_pausa);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "t_dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "t_dt_fim_pausa"=>$query[$i]['dt_fim_pausa'],
                    "t_motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_colaborador_substituto_pk"=>$query[$i]['colaborador_substituto_pk'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_motivo_folga_pk"=>$query[$i]['motivo_folga_pk'],
                    "t_ds_obs_folga"=>$query[$i]['ds_obs_folga'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarPausa':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $dt_fim = $_REQUEST['dt_agenda_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $turnos_pk = $_REQUEST['turnos_pk'];
        $resultado = "";
        $query = $agenda_colaborador_pausadao->listarPausa($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "t_dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "t_dt_fim_pausa"=>$query[$i]['dt_fim_pausa'],
                    "t_motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_colaborador_substituto_pk"=>$query[$i]['colaborador_substituto_pk'],
                    "t_ds_colaboradores"=>$query[$i]['ds_colaborador'],
                    "t_ds_re"=>$query[$i]['ds_re'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_motivo_folga_pk"=>$query[$i]['motivo_folga_pk'],
                    "t_ds_obs_folga"=>$query[$i]['ds_obs_folga'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarIncluirEscala':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $dt_fim = $_REQUEST['dt_agenda_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $turnos_pk = $_REQUEST['turnos_pk'];
        $resultado = "";
        $query = $agenda_colaborador_pausadao->listarIncluirEscala($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "t_dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "t_dt_fim_pausa"=>$query[$i]['dt_fim_pausa'],
                    "t_motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_colaborador_substituto_pk"=>$query[$i]['colaborador_substituto_pk'],
                    "t_ds_colaboradores"=>$query[$i]['ds_colaborador'],
                    "t_ds_re"=>$query[$i]['ds_re'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_motivo_folga_pk"=>$query[$i]['motivo_folga_pk'],
                    "t_ds_obs_folga"=>$query[$i]['ds_obs_folga'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarPausaColaborador':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $dt_fim = $_REQUEST['dt_agenda_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $turnos_pk = $_REQUEST['turnos_pk'];
        $resultado = "";
        $query = $agenda_colaborador_pausadao->listarPausaColaborador($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "t_dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "t_dt_fim_pausa"=>$query[$i]['dt_fim_pausa'],
                    "t_motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_colaborador_substituto_pk"=>$query[$i]['colaborador_substituto_pk'],
                    "t_ds_colaboradores"=>$query[$i]['ds_colaborador'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_motivo_folga_pk"=>$query[$i]['motivo_folga_pk'],
                    "t_ds_obs_folga"=>$query[$i]['ds_obs_folga'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'RelatorioColaboradorFerias':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $dt_fim = $_REQUEST['dt_agenda_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $resultado = "";
        
        $query = $agenda_colaborador_pausadao->RelatorioColaboradorFerias($dt_inicio,$dt_fim,$colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "t_dt_fim_pausa"=>$query[$i]['dt_fim_pausa'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarCores':{
        
        $dt_ini = $_REQUEST['dt_agenda'];
        $dt_final = $_REQUEST['dt_agenda_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        
        
        
        
        
        $arrData = explode("/", $dt_final);
        
        
        
        
        for($j=1;$j<=$arrData[0];$j++){
            
            $strDiaFolga = "";
            $strObs = "";
            $atribuir_folga = 0;
            $incluir_escala = 0;
            $troca_colaborador = 0;
            $exclusao = 0;
            $ferias = 0;
            $falta = 0;
            $hr_extra = 0;
            $ponto = 0;
            $afastamento = 0;
            
            $data_base_folga = 0;
            $data_base_incluir = 0;
            $data_base_troca = 0;
            $data_base_exclusao = 0;
            $data_base_ferias = 0;
            $data_base_falta = 0;
            $data_base_hr_extra = 0;
            $data_base_ponto = 0;
            $data_base_afastamento = 0;
            
            
            $dt_inicio = $j."/".$arrData[1]."/".$arrData[2];
            $dt_fim = $j."/".$arrData[1]."/".$arrData[2];
            $query = $agenda_colaborador_pausadao->listarAgendaPausa($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk);
        
        
        
            if(count($query) > 0){

                for($i = 0; $i < count($query); $i++){







                    //ATRIBUIR FOLGA
                    if($query[$i]['ds_agenda_colaborador_pausa']=="Folga" && $query[$i]['motivo_folga_pk']!=null){
                        $atribuir_folga = 1;
                        if($query[$i]['ds_motivo_folga']!=null){
                             $strDiaFolga[$i] = "Folga ".$query[$i]['ds_motivo_folga'];
                        }
                        else{
                             $strDiaFolga = "Folga";
                        }

                        if($query[$i]['ds_obs_folga']!=null){
                            $strObs = $query[$i]['ds_obs_folga'];
                        }
                        else{
                            $strObs = "";
                        }

                        $data_base_folga = $query[$i]['dt_inicio'];

                    }
                    //INCLUIR ESCALA
                    if($query[$i]['ds_agenda_colaborador_pausa']!="Folga" && $query[$i]['ds_agenda_colaborador_pausa']!="Substituição Agenda" && $query[$i]['ds_agenda_colaborador_pausa']!="Férias"){
                        $incluir_escala = 1;

                        $strDiaFolga = "(".$query[$i]['ds_agenda_colaborador_pausa'].")";

                        $data_base_incluir = $query[$i]['dt_inicio'];
                    }


                    //TROCA COLABORADOR
                    if($query[$i]['motivos_pausas_pk']!=null && $query[$i]['ds_agenda_colaborador_pausa']=="Substituição Agenda"){

                        $strDiaFolga = "Troca Colaborador";
                        $troca_colaborador = 1;
                        $data_base_troca = $query[$i]['dt_inicio'];

                    }

                    //EXCLUSAO
                    if($query[$i]['motivo_exclusao_pk']!=null && $query[$i]['ds_agenda_colaborador_pausa']=="Exclusão" ){
                        $strDiaFolga = "Exclusão";
                        $data_base_exclusao = $query[$i]['dt_inicio'];
                        if($query[$i]['ds_obs_exclusao']!=null){
                           $strObs = $query[$i]['ds_obs_exclusao'];
                        }
                        else{
                            $strObs = "";
                        }
                        $exclusao = 1;

                    }
                    //FÉRIAS
                    if($query[$i]['motivo_exclusao_pk']==null  && $query[$i]['ds_agenda_colaborador_pausa']=="Férias"){
                        $ferias = 1;
                        $strDiaFolga = "Férias";
                        $data_base_ferias = $query[$i]['dt_inicio'];
                    }
                }
            }

            //FALTA
            $query1 = $agenda_colaborador_pausadao->listarFalta($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk);



            $falta = count($query1);
            if(count($query1)>0){
                for($i = 0 ; $i < count($query1); $i++){
                    $data_base_falta = $query1[0]['dt_escala'];

                    if($query1[0]['ds_colaborador_reserva']!=""){
                        $strDiaFolga = $query1[0]['ds_colaborador_reserva'];
                    }
                    else{
                        $strDiaFolga = "Falta";
                    }
                }
            }

            //HORA EXTRA
            $query2 = $agenda_colaborador_pausadao->listarHoraExtra($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk);
         

            $hr_extra= count($query2);
            if(count($query2)>0){
     
                    $data_base_hr_extra = $query2[0]['dt_escala'];
                    $strDiaFolga = "Hora Extra";
                
            }

            //PONTO
            $query3 = $agenda_colaborador_pausadao->listarPonto($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk);

            $ponto = count($query3);

            if(count($query3)>0){

                

                    $data_base_ponto= $query3[0]['dt_hora_ponto'];

                
            }


            $query4 = $afastamento_ferias_colaboradordao->listarApontamento($colaborador_pk,$dt_inicio,$dt_fim,$leads_pk);

            $afastamento = count($query4);

            if(count($query4)>0){
                $strDiaFolga = "Afastamento";

                    $data_base_afastamento = $query4[0]['dt_inicio'];
                
            }

            $result  = 'success';
            $message = 'query success';


                    $mysql_data[] = array(
                        "atribuir_folga" => $atribuir_folga,
                        "strDiaFolga" => $strDiaFolga,
                        "strObs" =>$strObs,
                        "incluir_escala" =>$incluir_escala,
                        "troca_colaborador" =>$troca_colaborador,
                        "exclusao" =>$exclusao,
                        "ferias" =>$ferias,
                        "falta" =>$falta,
                        "hr_extra" =>$hr_extra,
                        "ponto" =>$ponto,
                        "data_base_folga" =>$data_base_folga,
                        "data_base_incluir" =>$data_base_incluir,
                        "data_base_troca" =>$data_base_troca,
                        "data_base_exclusao" =>$data_base_exclusao,
                        "data_base_ferias" =>$data_base_ferias,
                        "data_base_falta" =>$data_base_falta,
                        "data_base_hr_extra" =>$data_base_hr_extra,
                        "data_base_ponto" =>$data_base_ponto,
                        "data_base_afastamento" =>$data_base_afastamento,
                        "afastamento" =>$afastamento,

                        "t_functions" => ""
                    );

        }
        
        
        
        
     
        
        
        
        
        
		
        break;
    }     
    case 'listarCoresColaborador':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $dt_fim = $_REQUEST['dt_agenda_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $turnos_pk = $_REQUEST['turnos_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        
        
        $diasemana_numero = date('w', strtotime(DataYMD($dt_inicio)));
        
        $resultado = "";
        $query = $agenda_colaborador_pausadao->listarCoresColaborador($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk,$leads_pk,$diasemana_numero);
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
         
            for($i = 0; $i < count($query); $i++){
                $obs_falta = "";
                $obs_hora_extra = "";
                $ds_obs_exclusao = "";
                $ds_re_reserva = "";
                $ds_obs_folga = "";
                
                if($query[$i]['obs_falta']!=""){
                    $obs_falta = $query[$i]['obs_falta'];
                }
                if($query[$i]['obs_hora_extra']!=""){
                    $obs_hora_extra = $query[$i]['obs_hora_extra'];
                }
                if($query[$i]['ds_obs_exclusao']!=""){
                    $ds_obs_exclusao = $query[$i]['ds_obs_exclusao'];
                }
                if($query[$i]['ds_re_reserva']!=""){
                    $ds_re_reserva = $query[$i]['ds_re_reserva'];
                }
                if($query[$i]['ds_obs_folga']!=""){
                    $ds_obs_folga = $query[$i]['ds_obs_folga'];
                }
                
                
                $mysql_data[] = array(
                    "dt_inicio_pausa" => $query[$i]["dt_inicio_pausa"],
                    "motivo_exclusao_pk" => $query[$i]["motivo_exclusao_pk"],
                    "dt_hr_ponto" =>$query[$i]['dt_hora_ponto'],
                    "dt_escala" =>$query[$i]['dt_escala'],
                    "ds_agenda_colaborador_pausa" =>$query[$i]['ds_agenda_colaborador_pausa'],
                    "motivos_pausas_pk" =>$query[$i]['motivos_pausas_pk'],
                    "motivo_folga_pk" =>$query[$i]['motivo_folga_pk'],
                    "ds_obs_folga" =>$query[$i]['ds_obs_folga'],
                    "ds_colaborador_reserva" =>$query[$i]['ds_colaborador_reserva'],
                    "hr_extra_ini" =>$query[$i]['hr_extra_ini'],
                    "dt_hr_extra" =>$query[$i]['dt_hr_extra'],
                    //"ds_colaborador_substituto_ferias" =>$query[$i]['ds_colaborador_substituto_ferias'],
                    "ds_motivo_folga" =>$query[$i]['ds_motivo_folga'],
                    //"ds_motivo_falta" =>$query[$i]['ds_motivo_falta'],
                    
                    /*"obs_falta" =>$obs_falta,
                    "obs_hora_extra"=>$obs_hora_extra,
                    "ds_obs_exclusao"=>$ds_obs_exclusao,
                    "ds_re_reserva"=>$ds_re_reserva,
                    "ds_obs_folga"=>$ds_obs_folga,*/

                    "t_functions" => ""
                );
                
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }     
    case 'listarAgendaPausa':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        
        $query = $agenda_colaborador_pausadao->listarAgendaPausa($dt_inicio,"",$colaborador_pk,$leads_pk);
       
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                   
                    "ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_motivo_folga"=>$query[$i]['ds_motivo_folga'],
                    "motivo_folga_pk"=>$query[$i]['motivo_folga_pk'],
                    "ds_obs_folga"=>$query[$i]['ds_obs_folga'],
                    "motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "motivo_exclusao_pk"=>$query[$i]['motivo_exclusao_pk'],
                    "ds_obs_exclusao"=>$query[$i]['ds_obs_exclusao'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarAgendaPausaRel':{
        
        $dt_inicio = $_REQUEST['dt_ini'];
        $dt_fim = $_REQUEST['dt_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        
        $query = $agenda_colaborador_pausadao->listarAgendaPausaRel($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk);
       
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                   
                    "ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_motivo_folga"=>$query[$i]['ds_motivo_folga'],
                    "motivo_folga_pk"=>$query[$i]['motivo_folga_pk'],
                    "ds_obs_folga"=>$query[$i]['ds_obs_folga'],
                    "motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "motivo_exclusao_pk"=>$query[$i]['motivo_exclusao_pk'],
                    "ds_obs_exclusao"=>$query[$i]['ds_obs_exclusao'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarAgendaPausaFolga':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $dt_fim = $_REQUEST['dt_agenda_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        
        $query = $agenda_colaborador_pausadao->listarAgendaPausaFolga($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk);
       
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                   
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "ds_colaborador_ferias"=>$query[$i]['ds_colaborador_ferias'],
                    "ds_motivo_folga"=>$query[$i]['ds_motivo_folga'],
                    "motivo_folga_pk"=>$query[$i]['motivo_folga_pk'],
                    "ds_obs_folga"=>$query[$i]['ds_obs_folga'],
                    "motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "motivo_exclusao_pk"=>$query[$i]['motivo_exclusao_pk'],
                    "ds_obs_exclusao"=>$query[$i]['ds_obs_exclusao'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarFalta':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        
        $query = $agenda_colaborador_pausadao->listarFalta($dt_inicio,$colaborador_pk,$leads_pk);
       
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                   
                    "obs_falta"=>$query[$i]['obs'],
                    "ds_colaborador_reserva"=>$query[$i]['ds_colaborador_reserva'],
                    "ds_motivo_falta"=>$query[$i]['ds_motivo_falta'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarFaltaRel':{
        
        $dt_inicio = $_REQUEST['dt_ini'];
        $dt_fim = $_REQUEST['dt_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        
        $query = $agenda_colaborador_pausadao->listarFaltaRel($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk);
       
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                   
                    "obs_falta"=>$query[$i]['obs'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "ds_motivo_falta"=>$query[$i]['ds_motivo_falta'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarHoraExtra':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        
        $query = $agenda_colaborador_pausadao->listarHoraExtra($dt_inicio,$colaborador_pk,$leads_pk);
       
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                   
                    "hr_extra_ini"=>$query[$i]['hr_extra_ini'],
                    "obs"=>$query[$i]['obs'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarHoraExtraRel':{
        
       $dt_inicio = $_REQUEST['dt_ini'];
        $dt_fim = $_REQUEST['dt_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        
        $query = $agenda_colaborador_pausadao->listarHoraExtraRel($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk);
       
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                   
                    "hr_extra_ini"=>$query[$i]['hr_extra_ini'],
                    "obs"=>$query[$i]['obs'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarPonto':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        
        $query = $agenda_colaborador_pausadao->listarPonto($dt_inicio,$colaborador_pk,$leads_pk);
       
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                   
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "ds_tipo_ponto"=>$query[$i]['ds_tipo_ponto'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarPontoGridColaborador':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        $diasemana_numero = date('w', strtotime(DataYMD($dt_inicio)));


        $resultado = "";
        
        $query = $agenda_colaborador_pausadao->listarPontoGridColaborador($dt_inicio,$colaborador_pk,$leads_pk,$diasemana_numero);
       
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                   
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "ds_tipo_ponto"=>$query[$i]['ds_tipo_ponto'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarPontoRel':{
        
        $dt_inicio = $_REQUEST['dt_ini'];
        $dt_fim = $_REQUEST['dt_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $resultado = "";
        
        $query = $agenda_colaborador_pausadao->listarPontoRel($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk);
       
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                   
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "dt_hora_ponto"=>$query[$i]['dt_hora_ponto'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarFerias':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $dt_fim = $_REQUEST['dt_agenda_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $turnos_pk = $_REQUEST['turnos_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        $resultado = "";
        $query = $agenda_colaborador_pausadao->listarFerias($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk,$leads_pk);
        
        $result  = 'success';
        $message = 'query success';
      
        if(count($query) > 0){
            
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "dt_inicio_pausa" => $query[$i]["dt_inicio_pausa"],
                    "motivo_exclusao_pk" => $query[$i]["motivo_exclusao_pk"],
                    "dt_hr_ponto"=>$query[$i]['dt_hora_ponto'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "motivo_folga_pk"=>$query[$i]['motivo_folga_pk'],
                    "ds_obs_folga"=>$query[$i]['ds_obs_folga'],
                    "ds_colaborador_reserva"=>$query[$i]['ds_colaborador'],
                    "ds_re_reserva"=>$query[$i]['ds_re'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarExclusaoColaborador':{
        
        $dt_inicio = $_REQUEST['dt_agenda'];
        $dt_fim = $_REQUEST['dt_agenda_fim'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $turnos_pk = $_REQUEST['turnos_pk'];
        $resultado = "";
        $query = $agenda_colaborador_pausadao->listarExclusaoColaborador($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "t_dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "t_dt_fim_pausa"=>$query[$i]['dt_fim_pausa'],
                    "t_motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_colaborador_substituto_pk"=>$query[$i]['colaborador_substituto_pk'],
                    "t_ds_colaboradores"=>$query[$i]['ds_colaborador'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_motivo_folga_pk"=>$query[$i]['motivo_folga_pk'],
                    "t_ds_obs_folga"=>$query[$i]['ds_obs_folga'],

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

$agenda_colaborador_pausadao = null;

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
