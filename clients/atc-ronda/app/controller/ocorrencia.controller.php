<?php
set_time_limit(10000000);
require_once "../inc/php/public.php";

require_once "../inc/classes/bestflow/DataBase.php";



require_once "../model/ocorrencia.dao.php";
require_once "../model/ocorrencia.class.php";

require_once "../model/retorno.dao.php";
require_once "../model/retorno.class.php";

require_once "../model/documento.dao.php";
require_once "../model/documento.class.php";

require_once "../model/usuario.dao.php";
require_once "../model/usuario.class.php";
require_once "../model/tipo_ocorrencia.dao.php";
require_once "../model/tipo_ocorrencia.class.php";

require_once "../model/lead.dao.php";
require_once "../model/lead.class.php";


include_once "layout.controller.php";
include_once "../model/enviar_email.dao.php";

require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";


$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_ocorrencia = $arrRequest['ds_ocorrencia'];
$tipos_ocorrencias_pk = $arrRequest['tipos_ocorrencias_pk'];
$processos_etapas_pk = $arrRequest['processos_etapas_pk'];
$dt_fechamento = $arrRequest['dt_fechamento'];
$leads_pk = $arrRequest['leads_pk'];
$dt_prazo_execucao = $arrRequest['dt_prazo_execucao'];
$clientes_pk = $arrRequest['clientes_pk'];
$obs_execucao = $arrRequest['obs_execucao'];
$obs_recusa = $arrRequest['obs_recusa'];
$ic_recusa = $arrRequest['ic_recusa'];
$colaborador_pk = $arrRequest['colaborador_pk'];

$ds_lead = $arrRequest['ds_lead'];
$ic_status = $arrRequest['ic_status'];
$usuario_cadastro_pk = $arrRequest['usuario_cadastro_pk'];
$dt_cadastro = $arrRequest['dt_cadastro'];
$dt_cadastro_fim = $arrRequest['dt_cadastro_fim'];
$doc_oc = $arrRequest['doc_oc'];

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token); 

$tipo_ocorrenciadao = new tipo_ocorrenciadao();
$tipo_ocorrenciadao->setToken($token); 

$leaddao = new leaddao();
$leaddao->setToken($token); 

$retornodao = new retornodao();
$retornodao->setToken($token);

$documentodao = new documentodao();
$documentodao->setToken($token); 

$usuariodao = new usuariodao();
$usuariodao->setToken($token); 

$enviar_emaildao = new enviar_emaildao();
$enviar_emaildao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{

        $resultdo = "";

        
        //exclui o retorno da ocorrencia
        $retornodao->excluir_pk_oc($pk);
        
        $ocorrencia = $ocorrenciadao->carregarPorPk($pk);
        
        if($ocorrencia->getpk()>0){
            
            $pk_retorno = $ocorrenciadao->listarPkRetorno($ocorrencia->getpk());
            
            if(count($pk_retorno)>0){
                for($i=0;$i<count($pk_retorno);$i++){
                    $log_exclusaodao->salvar("retornos", $pk_retorno[$i]['pk']);
                }
            }


            $log_exclusaodao->salvar("ocorrencia",$ocorrencia->getpk());
            
            
            $ocorrenciadao->excluir($ocorrencia);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'ocorrencia nao encontrado';
        }
        break;
    }
    case 'salvar':{
        if($pk!=""){
            $ic_acao = "upd";
        }
        else{
            $ic_acao = "ins";
        }
        
        $ocorrencia = $ocorrenciadao->carregarPorPk($pk);

        $ocorrencia->setds_ocorrencia($ds_ocorrencia);
        $ocorrencia->settipos_ocorrencias_pk($tipos_ocorrencias_pk);
        $ocorrencia->setprocessos_etapas_pk($processos_etapas_pk);
        $ocorrencia->setdt_fechamento($dt_fechamento);
        $ocorrencia->setleads_pk($leads_pk);
        $ocorrencia->setic_recusa($ic_recusa);
        $ocorrencia->setdt_prazo_execucao($dt_prazo_execucao);
        $ocorrencia->setclientes_pk($clientes_pk);              
        $ocorrencia->setcolaborador_pk($colaborador_pk);              

        $ocorrencia->setobs_execucao($obs_execucao);
        $ocorrencia->setobs_recusa($obs_recusa);
        
        $pk = $ocorrenciadao->salvar($ocorrencia);

        if($pk!=""){
            $ocorrencias_pk = $pk;
        }
        else{
            $ocorrencias_pk = $ocorrencia->getpk();
        }
        
        //ENVIAR EMAIL
        /*if($leads_pk!=""){  
            
            $query_oc = $ocorrenciadao->listarPorPk($ocorrencias_pk);

            $query_tipo_oc = $tipo_ocorrenciadao->listarPorPk($tipos_ocorrencias_pk);
            $ds_tipo_oc = $query_tipo_oc[0]['ds_tipo_ocorrencia'];
  
            //ENVIO EMAIL PARA SUPERVISOR
            $query_lead = $leaddao->listarPorPk($leads_pk);
            if($ic_acao=="ins"){                
                if($query_lead[0]['ds_email_supervisor']!=""){                    
                    $html = layout::layoutOcorrenciaSupervisor($pk,$ds_tipo_oc,$ds_ocorrencia,$query_oc[0]['dt_cadastro_email'],$query_lead[0]['ds_lead'],"");
                    
                    $enviar_emaildao->enviaEmailAutenticado($html, 'gepros@gepros.com.br', $query_lead[0]['ds_email_supervisor'], "Ocorrência - ".$ds_tipo_oc,"");
                } 
            }
            else{
                //ENVIO EMAIL CLIENTE
               if($ocorrencias_pk!=""){  
     
                   $ds_status = "";
                    $ic_status = "";
                    if($dt_prazo_execucao!=''){ 
                        $ds_status = "Dt de Execução";
                        $ic_status = 2;
                        $dt_execucao = $dt_prazo_execucao;
                    }else if($ic_recusa==1 and $dt_fechamento!=''){        
                        $ds_status = "Ocorrência recusada";
                        $ic_status = 1; 
                        $ds_recusa = $obs_recusa;  
                    }else if($dt_fechamento !=1){      
                        $ds_status = "Dt de termino da Ocorrência";
                        $ic_status = 3;
                        $dt_finalizada = $dt_fechamento;
                    }else if($dt_fechamento !=4){     
                        $ds_status = "Ocorrência em verificação";
                        $ic_status = 4;
                    }
                    
                    $html =   layout::layoutOcorrenciaCliente($pk,$ds_tipo_oc,$ds_ocorrencia,$query_oc[0]['dt_cadastro_email'],$query_lead[0]['ds_lead'],"",$ds_status,$ic_status,$ds_recusa,$dt_execucao,$dt_finalizada);
                    
                    $query_usuario = $usuariodao->listarDadosCliente($leads_pk);
                    
                    

                    //$enviar_emaildao->enviaEmailAutenticado($html, /*De*//*'gepros@gepros.com.br', /*Para*//*$query_usuario[0]['ds_email'], "Ocorrência - ".$ds_tipo_oc,/*copia*//*$query_lead[0]['ds_email_supervisor']);

                   
                    
                    
                }
            }   
        }    */


        
        if($doc_oc != "")
            $arrDocOc = json_decode ($doc_oc, true);
        
        
        if(count($arrDocOc) > 0){
           
            for($i = 0; $i < count($arrDocOc); $i++){
                if($arrDocOc[$i]['doc_oc_pk']!="Nenhum registro encontrado"){
                    if($arrDocOc[$i]['doc_oc_pk']!="Carregando..."){
                        $documento = $documentodao->carregarPorPk($arrDocOc[$i]['doc_oc_pk']);
                        $documento->setds_documento($arrDocOc[$i]['ds_documento']);

                        $documento->setds_nome_original($arrDocOc[$i]['ds_nome_original']);
                        $documento->setleads_pk($leads_pk);
                        $documento->setocorrencias_pk($ocorrencias_pk);

                        $documentos_pk = $documentodao->salvar($documento);
                    }
                }
                  
            }
        }
        
              
        $agenda_retorno_pk = $_REQUEST['agenda_retorno_pk'];
        $dt_retorno = $_REQUEST['dt_retorno'];
        $hr_retorno = $_REQUEST['hr_retorno'];
        $equipes_pk = $_REQUEST['equipes_pk'];
        $responsavel_pk = $_REQUEST['responsavel_pk'];
        $ds_retorno = $_REQUEST['ds_retorno'];
        $agenda_retorno = $_REQUEST['agenda_retorno'];
        $dt_termino_retorno = $_REQUEST['dt_termino_retorno'];
        $hr_termino_retorno = $_REQUEST['hr_termino_retorno'];
        $tipo_lembrete_pk = $_REQUEST['tipo_lembrete_pk'];
       
        if($dt_retorno!='' || $dt_termino_retorno==1){            
            $retorno = $retornodao->carregarPorPk($agenda_retorno_pk);  

            if($dt_retorno!=""){
                $retorno->setdt_retorno(DataYMD(trim($dt_retorno))." ".$hr_retorno);
            }		

            $retorno->setequipes_pk($equipes_pk);
            $retorno->setresponsavel_pk($responsavel_pk);
            $retorno->setdt_termino_retorno($dt_termino_retorno);	           
            $retorno->setds_retorno($ds_retorno);
            $retorno->setocorrencias_pk($ocorrencias_pk);  
            //$retorno->settipo_lembrete_pk($tipo_lembrete_pk);  

            $retornos_pk = $retornodao->salvar($retorno);
            
            
            
             
            if($equipes_pk!=""){
                $query_lead = $leaddao->listarPorPk($leads_pk);
                $query_tipo_oc = $tipo_ocorrenciadao->listarPorPk($tipos_ocorrencias_pk);
                $ds_tipo_oc = $query_tipo_oc[0]['ds_tipo_ocorrencia'];
                $query_usuario = $usuariodao->listar_por_equipes($equipes_pk);
                
                $html =   layout::layoutAgendaRetorno($query_usuario[$i]['ds_equipe'],$ocorrencia->getusuario_cadastro_pk(),$query_lead[0]['ds_lead'],$ocorrencias_pk,(trim($dt_retorno))." ".$hr_retorno,$ds_tipo_oc,$ds_ocorrencia);

                
               
                if(count($query_usuario)>0){
                    for($i=0;$i<count($query_usuario);$i++){
                        //$enviar_emaildao->enviaEmailAutenticado($html, /*De*//*'gepros@gepros.com.br', /*Para*//*$query_usuario[$i]['ds_email'], "Agendamento Retorno Ocorrência ".$ds_tipo_oc,"");
                    }
                } 
            }
            else if($responsavel_pk!=""){
                
                $query_tipo_oc = $tipo_ocorrenciadao->listarPorPk($tipos_ocorrencias_pk);
                $ds_tipo_oc = $query_tipo_oc[0]['ds_tipo_ocorrencia'];
                $query_usuario = $usuariodao->listarPorPk($responsavel_pk);
                
                $html =   layout::layoutAgendaRetorno($query_usuario[$i]['ds_usuario'],$ocorrencia->getusuario_cadastro_pk(),$query_lead[0]['ds_lead'],$ocorrencias_pk,(trim($dt_retorno))." ".$hr_retorno,$ds_tipo_oc,$ds_ocorrencia);

                
                
                if(count($query_usuario)>0){
                    
                    for($i=0;$i<count($query_usuario);$i++){
                        if($query_usuario[$i]['ds_email']!=""){
                           
                           //$enviar_emaildao->enviaEmailAutenticado($html, /*De*//*'gepros@gepros.com.br', /*Para*//*$query_usuario[$i]['ds_email'], "Agendamento Retorno Ocorrência ".$ds_tipo_oc,"");
                       
                           
                       }
                        
                    }
                }
                
            } 
            
        }
      
        $mysql_data[] = array(
                "pk" => $ocorrencias_pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    
    case 'enviar_email':{
        $resultado = "";
        
        
        $enviar_email = $_REQUEST['enviar_email'];
        $dt_ocorrencia = $_REQUEST['dt_ocorrencia'];
        $ds_tipo_oc = $_REQUEST['ds_tipo_oc'];
        $ds_oc = $_REQUEST['ds_oc'];
        $dt_termino = $_REQUEST['dt_termino'];
        
        if($enviar_email != "")
            $arrEnvioEmail = json_decode ($enviar_email, true);
	
        if(count($arrEnvioEmail) > 0){

            for($i = 0; $i < count($arrEnvioEmail); $i++){
                if($arrEnvioEmail[$i]['check_envio']==1){
                    
                    $html =   layout::layoutOcorrencia($dt_ocorrencia,$ds_tipo_oc,$ds_oc,$dt_termino);
                
                
                    $ds_email_usuario = $usuariodao->listarUsuarioLogado();
                    
                    if(!empty($ds_email_usuario)){
                        //CHAMA A FUNÇÃO DO ENVIO DE EMAIL
                        $enviar_emaildao->envia_email($html, /*De*/'douglas.lopes@gepros.com.br', /*Para*/$arrEnvioEmail[$i]['ds_email_contato'], "Ocorrência","");
                    }
                }
            }
        }
        
        
        

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarOcorrenciaClientes':{

        $leads_pk = $_REQUEST['leads_pk'];
        $leads_usuarios_pk = $_REQUEST['leads_usuarios_pk'];
        $dt_cadastro_ini = $_REQUEST['dt_cadastro_ini'];
        $dt_cadastro_fim = $_REQUEST['dt_cadastro_fim'];
        $oc_aberta_fechado = $_REQUEST['oc_aberta_fechado'];

        $resultado = "";
        $query = $ocorrenciadao->listarOcorrenciaClientes($leads_pk,$dt_cadastro_ini,$dt_cadastro_fim,$tipos_ocorrencias_pk,$oc_aberta_fechado,$leads_usuarios_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                                
                $ds_status = "";

                if($query[$i]["ic_recusa"]=="1"){
                    $ds_status = "Chamado recusado";
                }
                else if ($query[$i]['dt_prazo_execucao']=="") {
                    $ds_status = "Não lido";    
                }
                else if ($query[$i]['dt_fechamento'] !=''){
                    $ds_status = "Finalizado"; 
                }
                else if ($query[$i]['dt_prazo_execucao'] >= date("d/m/Y")  ){
                    $ds_status = "Dentro do prazo"; 
                }
                else if ($query[$i]['dt_prazo_execucao'] < date("d/m/Y")  ){
                    $ds_status = "Chamado atrasado"; 
                }
                
                
                
                $mysql_data[] = array(
                   
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],                    
                    "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "t_tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "t_ds_ocorrencia"=>wordwrap($query[$i]['ds_ocorrencia'], 30, "<br />\n"),
                    "t_nome_usuario_cadastro"=>$query[$i]['nome_usuario_cadastro'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_agendado_para"=>$query[$i]['nome_agendado_para'],
                    "t_dt_retorno"=>$query[$i]['dt_retorno'],
                    "t_ds_retorno"=>wordwrap($query[$i]['ds_retorno'], 30, "<br />\n"),
                    "t_dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],                    
                    "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "t_ds_processo_etapa"=>$query[$i]['ds_processo_etapa'],
                    "t_ds_processo"=>$query[$i]['ds_processo'],  
                    "t_ic_recusa"=>$query[$i]['ic_recusa'],
                    "t_dt_prazo_execucao"=>$query[$i]['dt_prazo_execucao'],
                    "t_clientes_pk"=>$query[$i]['clientes_pk'],
                    "t_obs_execucao"=>$query[$i]['obs_execucao'],
                    "t_obs_recusa"=>$query[$i]['obs_recusa'],
                    "t_dt_visualizacao"=>$query[$i]['dt_visualizacao'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_ds_status"=>$ds_status,
                                                 
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
    case 'listarPk':{

        $resultado = "";
        $query = $ocorrenciadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "ic_status_fechamento"=>$query[$i]['ic_status_fechamento'],
                    "dt_prazo_execucao"=>$query[$i]['dt_prazo_execucao'],
                    "clientes_pk"=>$query[$i]['clientes_pk'],
                    "obs_execucao"=>$query[$i]['obs_execucao'],
                    "obs_status"=>$query[$i]['obs_status'],
                    "dt_visualizacao"=>$query[$i]['dt_visualizacao'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "dt_fechamento"=>$query[$i]['dt_fechamento']
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
    case 'verificarOcorrenciaLancamento':{
        $ds_ocorrencia = $_REQUEST['ds_ocorrencia'];
        
        $resultado = "";
        $query = $ocorrenciadao->verificarOcorrenciaLancamento($ds_ocorrencia);
        $query1 = $ocorrenciadao->verificarOcorrenciaLancamentoDespesa($ds_ocorrencia);
        
        $mysql_data[] = array(
            "qtde" => $query[0]['qtde'] + $query1[0]['qtde']
        );
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarTodos':{

        $resultado = "";
        $query = $ocorrenciadao->listar_por_ds_ocorrencia($ds_lead,$tipos_ocorrencias_pk,$ic_status,$usuario_cadastro_pk,$dt_cadastro,$dt_cadastro_fim,$usuario_agendado_para,$dt_prazo_execucao_ini,$dt_prazo_execucao_fim,$ic_status_fechamento,$colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                     "ic_status_fechamento"=>$query[$i]['ic_status_fechamento'],
                    "dt_prazo_execucao"=>$query[$i]['dt_prazo_execucao'],
                    "clientes_pk"=>$query[$i]['clientes_pk'],
                    "obs_execucao"=>$query[$i]['obs_execucao'],
                    "obs_status"=>$query[$i]['obs_status'],
                    "dt_visualizacao"=>$query[$i]['dt_visualizacao'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "dt_fechamento"=>$query[$i]['dt_fechamento']
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
        $query = $ocorrenciadao->listar_por_ds_ocorrencia($ds_lead,$tipos_ocorrencias_pk,$ic_status,$usuario_cadastro_pk,$dt_cadastro,$dt_cadastro_fim,$usuario_agendado_para,$dt_prazo_execucao_ini,$dt_prazo_execucao_fim,$ic_status_fechamento,$colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],                    
                    "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "t_ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "t_nome_usuario_cadastro"=>$query[$i]['nome_usuario_cadastro'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_agendado_para"=>$query[$i]['nome_agendado_para'],
                    "t_dt_retorno"=>$query[$i]['dt_retorno'],
                    "t_ds_retorno"=>$query[$i]['ds_retorno'],
                    "t_dt_fechamento_retorno"=>$query[$i]['dt_fechamento_retorno'],
                    "t_tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "t_ds_processo_etapa"=>$query[$i]['ds_processo_etapa'],
                    "t_ds_processo"=>$query[$i]['ds_processo'],
                    "t_ic_status_fechamento"=>$query[$i]['ic_status_fechamento'],
                    "t_ds_status_fechamento"=>$query[$i]['ds_status_fechamento'],
                    "t_clientes_pk"=>$query[$i]['clientes_pk'],
                    "t_obs_execucao"=>$query[$i]['obs_execucao'],
                    "t_obs_status"=>$query[$i]['obs_status'],
                    "t_dt_prazo_execucao"=>$query[$i]['dt_prazo_execucao'],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_dt_visualizacao"=>$query[$i]['dt_visualizacao'],
                             
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }   
    case 'RelatorioOcorrenciaTempo':{ 
        $leads_pk = $_REQUEST['leads_pk'];
        $supervisor_pk = $_REQUEST['supervisor_pk'];
        $tipo_ocorrencia_pk = $_REQUEST['tipo_ocorrencia_pk'];
        $dt_abertura_ini = $_REQUEST['dt_abertura_ini'];
        $dt_abertura_fim = $_REQUEST['dt_abertura_fim'];
        $dt_atendimento_ini = $_REQUEST['dt_atendimento_ini'];
        $dt_atendimento_fim = $_REQUEST['dt_atendimento_fim'];
        $resultado = "";
        $query = $ocorrenciadao->RelatorioOcorrenciaTempo($leads_pk,$supervisor_pk,$tipo_ocorrencia_pk,$dt_abertura_ini,$dt_abertura_fim,$dt_atendimento_ini,$dt_atendimento_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $qtde_dias_atendimentos = 0;
                
                if($query[$i]['dt_prazo_execucao']!=""){
                    $query_qtde_dias_atendimentos = $ocorrenciadao->dateDiff($query[$i]['dt_cadastro'],$query[$i]['dt_prazo_execucao']);
                    $qtde_dias_atendimentos = $query_qtde_dias_atendimentos[0]['datediff'];
                }
                else{
                    $qtde_dias_atendimentos = 0;
                }
                
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "dt_cadastro" => $query[$i]["dt_cadastro"],
                    "dt_prazo_execucao" => $query[$i]["dt_prazo_execucao"],
                    "ds_lead" => $query[$i]["ds_lead"],
                    "ds_supervisor" => $query[$i]["ds_supervisor"],
                    "ds_tipo_oc" => $query[$i]["ds_tipo_ocorrencia"],
                    "qtde_dias_atendimento" => $qtde_dias_atendimentos,
                    
                             
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }   
    case 'listarDataTableGrid':{ 
        
        $usuario_agendado_para = $_REQUEST['usuario_agendado_para'];
        $dt_prazo_execucao_ini = $_REQUEST['dt_prazo_execucao_ini'];
        $dt_prazo_execucao_fim = $_REQUEST['dt_prazo_execucao_fim'];
        $ic_status_fechamento = $_REQUEST['ic_status_fechamento'];
        $equipes_pk = $_REQUEST['equipes_pk'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];

        
        $resultado = "";
        $arrDados = $ocorrenciadao->listar_por_ds_ocorrencia($ds_lead,$tipos_ocorrencias_pk,$ic_status,$usuario_cadastro_pk,$dt_cadastro,$dt_cadastro_fim,$usuario_agendado_para,$dt_prazo_execucao_ini,$dt_prazo_execucao_fim,$ic_status_fechamento,$equipes_pk,$colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($arrDados['query']) > 0){
            $iTotalDisplayRecords = $arrDados['count'];
            for($i = 0; $i < count($arrDados['query']); $i++){
                
                $ds_status = "";
                
                $data1 = $arrDados['query'][$i]['dt_prazo_execucao_comp'];
                $data2 = date("Y-m-d");

                if($arrDados['query'][$i]["ic_recusa"]=="1"){
                    $ds_status = "Chamado recusado";
                }elseif ($arrDados['query'][$i]['dt_prazo_execucao']=="") {
                    $ds_status = "Não lido";    
                }elseif ($arrDados['query'][$i]['dt_fechamento'] !=''){
                    $ds_status = "Finalizado"; 
                }elseif (strtotime($data1) >= strtotime($data2)){
                    $ds_status = "Dentro do prazo"; 
                }elseif (strtotime($data1) < strtotime($data2)){
                    $ds_status = "Chamado atrasado"; 
                }
                
                
                if($arrDados['query'][$i]["resposanvel_pk"]!=""){
                    $ds_agendado = "Responsável: ".$arrDados['query'][$i]["resposanvel_pk"];
                }
                else if($arrDados['query'][$i]["equipes_pk"]!=""){
                    $ds_agendado = "Equipe: ".$arrDados['query'][$i]["equipes_pk"];
                }
                
                $mysql_data[] = array(
                    "t_pk" => $arrDados['query'][$i]["pk"],
                    "t_ds_lead"=>$arrDados['query'][$i]['ds_lead'],
                    "t_leads_pk"=>$arrDados['query'][$i]['leads_pk'],
                    "t_dt_cadastro"=>$arrDados['query'][$i]['dt_cadastro'],                    
                    "t_ds_tipo_ocorrencia"=>$arrDados['query'][$i]['ds_tipo_ocorrencia'],
                    "t_tipos_ocorrencias_pk"=>$arrDados['query'][$i]['tipos_ocorrencias_pk'],
                    "t_ds_ocorrencia"=>wordwrap($arrDados['query'][$i]['ds_ocorrencia'], 30, "<br />\n"),
                    "t_nome_usuario_cadastro"=>$arrDados['query'][$i]['nome_usuario_cadastro'],
                    "t_dt_fechamento"=>$arrDados['query'][$i]['dt_fechamento'],
                    "t_agendado_para"=>$ds_agendado,
                    "t_dt_retorno"=>$arrDados['query'][$i]['dt_retorno'],
                    "t_ds_retorno"=>wordwrap($arrDados['query'][$i]['ds_retorno'], 30, "<br />\n"),
                    "t_dt_termino_retorno"=>$arrDados['query'][$i]['dt_termino_retorno'],                    
                    "t_ds_tipo_ocorrencia"=>$arrDados['query'][$i]['ds_tipo_ocorrencia'],
                    "t_ds_processo_etapa"=>$arrDados['query'][$i]['ds_processo_etapa'],
                    "t_ds_processo"=>$arrDados['query'][$i]['ds_processo'], 
                    "t_obs_recusa"=>$arrDados['query'][$i]["obs_recusa"],
                    "t_ic_recusa"=>$arrDados['query'][$i]["ic_recusa"],
                    "t_ds_status"=>$ds_status,
                    "t_dt_prazo_execucao"=>$arrDados['query'][$i]['dt_prazo_execucao'],
                    "t_clientes_pk"=>$arrDados['query'][$i]['clientes_pk'],
                    "t_obs_execucao"=>$arrDados['query'][$i]['obs_execucao'],
                    "t_obs_status"=>$arrDados['query'][$i]['obs_status'],
                    "t_colaborador_pk"=>$arrDados['query'][$i]['colaborador_pk'],
                    "t_ds_colaborador"=>$arrDados['query'][$i]['ds_colaborador'],
                    "t_dt_visualizacao"=>$arrDados['query'][$i]['dt_visualizacao'],
                             
                    "t_functions" => ""
                );
            }
        }else{
            $mysql_data = [];
            $iTotalDisplayRecords = 0;
        }
		
        break;
    }
    case 'listarEquipecorrencia':{ 

        $equipes_pk = $_REQUEST['equipes_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_abertura_ini = $_REQUEST['dt_abertura_ini'];
        $dt_abertura_fim = $_REQUEST['dt_abertura_fim'];
        $dt_execucao_ini = $_REQUEST['dt_execucao_ini'];
        $dt_execucao_fim = $_REQUEST['dt_execucao_fim'];
        $dt_fechamento_ini = $_REQUEST['dt_fechamento_ini'];
        $dt_fechamento_fim = $_REQUEST['dt_fechamento_fim'];
        
        $resultado = "";
        $query = $ocorrenciadao->listarEquipeOcorrencia($equipes_pk,$leads_pk,$dt_abertura_ini,$dt_abertura_fim,$dt_execucao_ini,$dt_execucao_fim,$dt_fechamento_ini,$dt_fechamento_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){ 
                if($query[$i]["ds_equipe"]==""){
                    $ds_equipe = "Sem Equipe ";
                }
                else{
                     $ds_equipe = $query[$i]["ds_equipe"];
                }
                        $mysql_data[] = array(
                   
                            "ds_equipe" => $ds_equipe,
                            "usuario_cadastro_pk" => $query[$i]["usuario_cadastro_pk"],
                            "equipes_pk"=>$query[$i]['equipes_pk'],

                            "t_functions" => ""
                        );
                        
                        
                        
                       
                    }
                }
        else{
            $mysql_data = [];
        }
		
        break;
    } 
    case 'listarSLAOcorrencia':{ 

        $equipes_pk = $_REQUEST['equipes_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_abertura_ini = $_REQUEST['dt_abertura_ini'];
        $dt_abertura_fim = $_REQUEST['dt_abertura_fim'];
        $dt_execucao_ini = $_REQUEST['dt_execucao_ini'];
        $dt_execucao_fim = $_REQUEST['dt_execucao_fim'];
        $dt_fechamento_ini = $_REQUEST['dt_fechamento_ini'];
        $dt_fechamento_fim = $_REQUEST['dt_fechamento_fim'];
        $strUsuario = "";
        $resultado = "";
        $result  = 'success';
        $message = 'query success';
        
        
        
        /*if($leads_pk=="" && $equipes_pk!="null"){
            $query = $ocorrenciadao->listarUsuarioEquipe($equipes_pk,$leads_pk);
            $strUsuario = " (";
            if(count($query)>0){ 

                for($i = 0; $i < count($query); $i++){
                    $strUsuario.= $query[$i]['usuarios_pk'].",";
                }
                $strUsuario.= "0)";
            }
            else{
                 $strUsuario.= "0)";
            }
        }
        else{*/
            $query = $ocorrenciadao->listarUsuarioCadastroOc($leads_pk);
            $strUsuario = " (";
            if(count($query)>0){ 

                for($i = 0; $i < count($query); $i++){
                    $strUsuario.= $query[$i]['usuario_cadastro_pk'].",";
                }
                $strUsuario.= "0)";
            }
            else{
                 $strUsuario.= "0)";
            }
        //}
        
       
        
        
       
                
        $query1 = $ocorrenciadao->listarTipoOcorrenciaPorEquipe($equipes_pk,$leads_pk,$dt_abertura_ini,$dt_abertura_fim,$dt_execucao_ini,$dt_execucao_fim,$dt_fechamento_ini,$dt_fechamento_fim,$strUsuario);

        if(count($query1)>0){    
            for($j = 0; $j < count($query1); $j++){

                $query2 = $ocorrenciadao->relatorioSLAOcorrencia($equipes_pk,$leads_pk,$dt_abertura_ini,$dt_abertura_fim,$dt_execucao_ini,$dt_execucao_fim,$dt_fechamento_ini,$dt_fechamento_fim,$query1[$j]['tipos_ocorrencias_pk'],$strUsuario);

                $qtde_executada = 0;
                $qtde_executada_atrasado = 0;
                $qtde_nao_executado = 0;
                $nota = 0;
                for($t = 0; $t < count($query2); $t++){


                    $data1 = $query2[$t]['dt_fechamento'];
                    $data2 = $query2[$t]['dt_prazo_execucao_comp'];


                    if($query2[$t]['dt_fechamento'] !=''){
                        $qtde_executada ++;
                    }
                    else if($query2[$t]['dt_fechamento'] !='' && strtotime($data1) > strtotime($data2)){
                        $qtde_executada_atrasado ++;
                    }
                    else if($query2[$t]['dt_fechamento'] ==''){
                        $qtde_nao_executado++;
                    }
                    $nota = ($qtde_executada / count($query2))*100;
                }
                
                $mysql_data[] = array(

                    "ds_tipo_ocorrencia"=>$query1[$j]['ds_tipo_ocorrencia'],
                    "qtde_atendimentos"=>count($query2), 
                    "qtde_executada"=>$qtde_executada, 
                    "qtde_executada_atrasado"=>$qtde_executada_atrasado, 
                    "qtde_nao_executado"=>$qtde_nao_executado,
                    "nota"=>number_format($nota,0,',','.')."%",

                    "t_functions" => ""
                );
                
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    } 
    case 'listarOcorrenciaProcessoLead':{

        $leads_pk = $_REQUEST['leads_pk'];
        $dt_cadastro_ini = $_REQUEST['dt_cadastro_ini'];
        $dt_cadastro_fim = $_REQUEST['dt_cadastro_fim'];
        $oc_aberta_fechado = $_REQUEST['oc_aberta_fechado'];
        $resultado = "";
        $query = $ocorrenciadao->listar_ocorrencia_processo_lead($leads_pk,$dt_cadastro_ini,$dt_cadastro_fim,$tipos_ocorrencias_pk,$oc_aberta_fechado);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                                
                $ds_status = "";

                if($query[$i]["ic_recusa"]=="1"){
                    $ds_status = "Chamado recusado";
                }
                else if ($query[$i]['dt_prazo_execucao']=="") {
                    $ds_status = "Não lido";    
                }
                else if ($query[$i]['dt_fechamento'] !=''){
                    $ds_status = "Finalizado"; 
                }
                else if ($query[$i]['dt_prazo_execucao'] >= date("d/m/Y")  ){
                    $ds_status = "Dentro do prazo"; 
                }
                else if ($query[$i]['dt_prazo_execucao'] < date("d/m/Y")  ){
                    $ds_status = "Chamado atrasado"; 
                }
                
                
                
                $mysql_data[] = array(
                   
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],                    
                    "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "t_tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "t_ds_ocorrencia"=>wordwrap($query[$i]['ds_ocorrencia'], 30, "<br />\n"),
                    "t_nome_usuario_cadastro"=>$query[$i]['nome_usuario_cadastro'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_agendado_para"=>$query[$i]['nome_agendado_para'],
                    "t_dt_retorno"=>$query[$i]['dt_retorno'],
                    "t_ds_retorno"=>wordwrap($query[$i]['ds_retorno'], 30, "<br />\n"),
                    "t_dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],                    
                    "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "t_ds_processo_etapa"=>$query[$i]['ds_processo_etapa'],
                    "t_ds_processo"=>$query[$i]['ds_processo'],  
                    "t_ic_recusa"=>$query[$i]['ic_recusa'],
                    "t_dt_prazo_execucao"=>$query[$i]['dt_prazo_execucao'],
                    "t_clientes_pk"=>$query[$i]['clientes_pk'],
                    "t_obs_execucao"=>$query[$i]['obs_execucao'],
                    "t_obs_recusa"=>$query[$i]['obs_recusa'],
                    "t_dt_visualizacao"=>$query[$i]['dt_visualizacao'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_ds_status"=>$ds_status,
                                                 
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    } 
    case 'listarOcorrenciasLeadPk':{
        $result  = 'success';
        $message = 'query success';

        if(!empty($leads_pk)){        
            $resultado = "";
            $query = $ocorrenciadao->listarOcorrenciasLeadPk($leads_pk);
               if(count($query) > 0){
                    for($i = 0; $i < count($query); $i++){
                        $mysql_data[] = array(
                        
                            "t_pk" => $query[$i]["pk"],
                            "t_ds_lead"=>$query[$i]['ds_lead'],
                            "t_dt_cadastro"=>$query[$i]['dt_cadastro'],                    
                            "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                            "t_tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                            "t_ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                            "t_nome_usuario_cadastro"=>$query[$i]['ds_usuario_cadastro'],
                            "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                            "t_agendado_para"=>$query[$i]['ds_agendado_para'],
                            "t_dt_retorno"=>$query[$i]['dt_retorno'],
                            "t_ds_retorno"=>$query[$i]['ds_retorno'],
                            "t_dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],    
                            //"t_ds_processo_etapa"=>$query[$i]['ds_processo_etapa'],
                            //"t_ds_processo"=>$query[$i]['ds_processo'],  
                            "t_dt_prazo_execucao"=>$query[$i]['dt_prazo_execucao'],         
                            "t_ds_status"=>$query[$i]['ds_status'],
                                                        
                            "t_functions" => ""
                        );
                    }
                }
                else{
                    $mysql_data = [];
                }
        }else{
            $mysql_data = [];
        }
        break;
    }
    case 'listarPorPk':{
        
        $resultado = "";
        $query = $ocorrenciadao->listarOcorrenciaPorPk($pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){  
            $mysql_data[] = array(
                "t_pk" => $query[0]["pk"],
                "t_ds_lead"=>$query[0]['ds_lead'],
                "t_dt_cadastro"=>$query[0]['dt_cadastro'],                    
                "t_ds_tipo_ocorrencia"=>$query[0]['ds_tipo_ocorrencia'],
                "t_tipos_ocorrencias_pk"=>$query[0]['tipos_ocorrencias_pk'],
                "t_ds_ocorrencia"=>$query[0]['ds_ocorrencia'],
                "t_nome_usuario_cadastro"=>$query[0]['nome_usuario_cadastro'],
                "t_dt_fechamento"=>$query[0]['dt_fechamento'],
                "t_agendado_para"=>$query[0]['nome_agendado_para'],
                "t_dt_retorno"=>$query[0]['dt_retorno'],
                "t_ds_retorno"=>$query[0]['ds_retorno'],
                "t_dt_termino_retorno"=>$query[0]['dt_termino_retorno'],                    
                "t_ds_tipo_ocorrencia"=>$query[0]['ds_tipo_ocorrencia'],
                "t_ds_processo_etapa"=>$query[0]['ds_processo_etapa'],
                "t_ds_processo"=>$query[0]['ds_processo'],  
                "t_dt_prazo_execucao"=>$query[0]['dt_prazo_execucao'], 
                "t_retornos_pk"=>$query[0]['retornos_pk'],  
                "t_motivo_sem_interesse_pk"=>$query[0]['motivo_sem_interesse_pk'],  
                "t_ds_motivo_sem_interesse"=>$query[0]['ds_motivo_sem_interesse'],         
                "t_ds_status"=>$query[0]['ds_status'],
                "t_colaborador_pk"=>$query[0]['colaborador_pk'],
                                                
                "t_functions" => ""
            );
            
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

$ocorrenciadao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data,
    "iTotalDisplayRecords"=>$iTotalDisplayRecords,
    "iTotalRecords"=>$iTotalDisplayRecords
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
echo $json_data;


?>
