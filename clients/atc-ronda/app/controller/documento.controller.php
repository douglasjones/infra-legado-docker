<?
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/documento.dao.php";
require_once "../model/documento.class.php";

require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";




$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_documento = $arrRequest['ds_documento'];
$ds_obs = $arrRequest['ds_obs'];
$ds_nome_original = $arrRequest['ds_nome_original'];
$colaboradores_pk = $arrRequest['colaboradores_pk'];
$leads_pk = $arrRequest['leads_pk'];
$contratos_pk = $arrRequest['contratos_pk'];
$ocorrencias_pk = $arrRequest['ocorrencias_pk'];
$agenda_colaborador_tarefa_pk = $arrRequest['agenda_colaborador_tarefa_pk'];
$lancamentos_pk = $arrRequest['lancamentos_pk'];
$compras_pk = $arrRequest['compras_pk'];
$agendas_pk = $arrRequest['agendas_pk'];


$documentodao = new documentodao();
$documentodao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    
    case 'download':{
        
    set_time_limit(0);
    // Arqui você faz as validações e/ou pega os dados do banco de dados
    $aquivoNome = $ds_documento; // nome do arquivo que será enviado p/ download
    $arquivoLocal = '../docs/'.$aquivoNome; // caminho absoluto do arquivo
    // Verifica se o arquivo não existe
    if (!file_exists($arquivoLocal)) {
    // Exiba uma mensagem de erro caso ele não exista
    exit;
    }
    // Aqui você pode aumentar o contador de downloads
    // Definimos o novo nome do arquivo
    $novoNome = $aquivoNome;
    // Configuramos os headers que serão enviados para o browser
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename="'.$novoNome.'"');
    header('Content-Type: application/octet-stream');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($aquivoNome));
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Expires: 0');
    // Envia o arquivo para o cliente
    readfile($aquivoNome);
        
        break;
    }
    
    case 'excluir':{
        
        $resultdo = "";
        
        $documento = $documentodao->carregarPorPk($pk);
        if($documento->getpk()>0){
            $log_exclusaodao->salvar("documentos",$documento->getpk());
            $documentodao->excluir($documento);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'documento nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        
            $ds_arquivo = $_REQUEST['ds_arquivo'];
            $documento = $documentodao->carregarPorPk($pk);
            $ic_tipo_documento = $_REQUEST['ic_tipo_documento'];
            if($ds_arquivo != "")
                $arrDsArquivos = json_decode ($ds_arquivo, true);
            
            if(count($arrDsArquivos) > 0){
                for($i = 0; $i < count($arrDsArquivos); $i++){
                    
                    
                    $documento->setds_documento($arrDsArquivos[$i]['ds_documento']);
                    $documento->setds_obs($ds_obs);
                    $documento->setds_nome_original($arrDsArquivos[$i]['ds_nome_original']);
                    $documento->setcolaboradores_pk($colaboradores_pk);
                    $documento->setleads_pk($leads_pk);
                    $documento->setcontratos_pk($contratos_pk);
                    $documento->setocorrencias_pk($ocorrencias_pk);
                    $documento->setagenda_colaborador_tarefa_pk($agenda_colaborador_tarefa_pk);
                    $documento->setlancamentos_pk($lancamentos_pk);
                    $documento->setcompras_pk($compras_pk);
                    $documento->setagendas_pk($agendas_pk);
                    $documento->setic_tipo_documento($ic_tipo_documento);

                    $pk = $documentodao->salvar($documento);  
                }
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
        $query = $documentodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_documento"=>$query[$i]['ds_documento'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],
                    "lancamentos_pk"=>$query[$i]['lancamentos_pk'],
                    "ocorrencias_pk"=>$query[$i]['ocorrencias_pk']
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
        $query = $documentodao->listar_por_ds_documento($ds_documento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_documento"=>$query[$i]['ds_documento'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],
                    "lancamentos_pk"=>$query[$i]['lancamentos_pk'],
                    "ocorrencias_pk"=>$query[$i]['ocorrencias_pk']
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
        $query = $documentodao->listar_por_ds_documento($ds_documento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_documento"=>$query[$i]['ds_documento'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],
                    "t_lancamentos_pk"=>$query[$i]['lancamentos_pk'],
                    "t_agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarDocumentosLead':{
        
        $leads_pk = $_REQUEST['leads_pk'];
        $ic_tipo_documento = $_REQUEST['ic_tipo_documento'];
        $resultado = "";
        if($leads_pk!=""){
            $query = $documentodao->listar_documetos_lead($leads_pk,$ic_tipo_documento);
        }else{
            $mysql_data = [];
        }
        


        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_documento"=>$query[$i]['ds_documento'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],
                    "t_agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],
                    "t_lancamentos_pk"=>$query[$i]['lancamentos_pk'],

                    "t_functions" => ""
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
    case 'listarDocumentosTarefa':{
        
        $agenda_colaborador_tarefa_pk = $_REQUEST['agenda_colaborador_tarefa_pk'];
        $resultado = "";
        if($agenda_colaborador_tarefa_pk!=""){
            $query = $documentodao->listarDocumentosTarefa($agenda_colaborador_tarefa_pk);
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
                    "t_ds_documento"=>$query[$i]['ds_documento'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],
                    "t_agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],
                    "t_lancamentos_pk"=>$query[$i]['lancamentos_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarDocumentosColaborador':{
        
        $colaboradores_pk = $_REQUEST['colaboradores_pk'];
        $resultado = "";
        if($colaboradores_pk!=""){
            $query = $documentodao->listar_documetos_colaboradores($colaboradores_pk);
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
                    "t_ds_documento"=>$query[$i]['ds_documento'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],
                    "t_agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],
                    "t_lancamentos_pk"=>$query[$i]['lancamentos_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    } 
    case 'renomearArquivoImportLancamento':{
        $ds_arquivo = $_REQUEST['ds_arquivo'];
        
        $resultado = "";
        rename("../docs/arquivosImportLancamento/$ds_arquivo", "../docs/arquivosImportLancamento/import-".$ds_arquivo);
        $mysql_data[] = array(
            "t_ds_nome_salvo" => "import-".$ds_arquivo,
            "t_functions" => ""
        );
        $result  = 'success';
        $message = 'query success';
        break;
    }     
    case 'renomearArquivo':{
        
        $leads_pk = $_REQUEST['leads_pk'];
        $ds_arquivo = $_REQUEST['ds_arquivo'];
        
        $resultado = "";
        $query = $documentodao->listarQuantidadeDocumentosLead($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        /*if(count($query) > 0){*/
            rename("../docs/$ds_arquivo", "../docs/L".$leads_pk."-".($query[0]['total']+1)."-".$ds_arquivo);
            $mysql_data[] = array(
                "t_ds_nome_salvo" => "L".$leads_pk."-".($query[0]['total']+1)."-".$ds_arquivo,

                "t_functions" => ""
            );
        /*}
        else{
            $mysql_data = [];
        }*/
		
        break;
    }    
    case 'renomearArquivoAgenda':{
        $ds_arquivo = $_REQUEST['ds_arquivo'];
        
        $resultado = "";
        $query = $documentodao->listarQuantidadeDocumentosAgendas();
        
        $result  = 'success';
        $message = 'query success';

       // if(count($query) > 0){
            rename("../docs/$ds_arquivo", "../docs/Agenda".($query[0]['total']+1)."-".$ds_arquivo);
            $mysql_data[] = array(
                "t_ds_nome_salvo" => "Agenda".($query[0]['total']+1)."-".$ds_arquivo,

                "t_functions" => ""
            );
        /*}
        else{
            $mysql_data = [];
        }*/
		
        break;
    }    
    case 'renomearArquivoCompra':{
        
        $compras_pk = $_REQUEST['compras_pk'];
        $ds_arquivo = $_REQUEST['ds_arquivo'];
        
        $resultado = "";
        $query = $documentodao->listarQuantidadeDocumentosCompra();
        
        $result  = 'success';
        $message = 'query success';

        /*if(count($query) > 0){*/
            rename("../docs/$ds_arquivo", "../docs/L".$leads_pk."-".($query[0]['total']+1)."-".$ds_arquivo);
            $mysql_data[] = array(
                "t_ds_nome_salvo" => "L".$leads_pk."-".($query[0]['total']+1)."-".$ds_arquivo,

                "t_functions" => ""
            );
        /*}
        else{
            $mysql_data = [];
        }*/
		
        break;
    }    
    case 'renomearArquivoTarefa':{
        
        $ds_arquivo = $_REQUEST['ds_arquivo'];
        
        $resultado = "";
        
        $result  = 'success';
        $message = 'query success';

        /*if(count($query) > 0){*/
            rename("../docs/$ds_arquivo", "../docs/TarefaConcluida-".$ds_arquivo);
            $mysql_data[] = array(
                "t_ds_nome_salvo" => "TarefaConcluida-".$ds_arquivo,

                "t_functions" => ""
            );
        /*}
        else{
            $mysql_data = [];
        }*/
		
        break;
    }    
    
    case 'renomearArquivoColaborador':{
        
        $colaboradores_pk = $_REQUEST['colaboradores_pk'];
        $ds_arquivo = $_REQUEST['ds_arquivo'];
        
        $resultado = "";
        $query = $documentodao->listarQuantidadeDocumentosColaborador($colaboradores_pk);
        
        $result  = 'success';
        $message = 'query success';

        /*if(count($query) > 0){*/
        if($colaboradores_pk!=""){
            rename("../docs/$ds_arquivo", "../docs/".$colaboradores_pk."Colab-".($query[0]['total']+1)."-".$ds_arquivo);
            $mysql_data[] = array(
                "t_ds_nome_salvo" => $colaboradores_pk."Colab-".($query[0]['total']+1)."-".$ds_arquivo,
                "t_functions" => ""
            );
        }
        else{
            rename("../docs/$ds_arquivo", "../docs/Colab-".($query[0]['total']+1)."-".$ds_arquivo);
            $mysql_data[] = array(
                "t_ds_nome_salvo" => "Colab-".($query[0]['total']+1)."-".$ds_arquivo,

                "t_functions" => ""
            );
        }
            
        /*}
        else{
            $mysql_data = [];
        }*/
		
        break;
    }    
    case 'renomearArquivoLancamento':{
        
        $lancamentos_pk = $_REQUEST['lancamentos_pk'];
        $ds_arquivo = $_REQUEST['ds_arquivo'];
        
        $resultado = "";
        $query = $documentodao->listarQuantidadeDocumentosLancamentos($lancamentos_pk);
        
        $result  = 'success';
        $message = 'query success';

        /*if(count($query) > 0){*/
        if($lancamentos_pk!=""){
            rename("../docs/$ds_arquivo", "../docs/".$lancamentos_pk."Lanc-".($query[0]['total']+1)."-".$ds_arquivo);
            $mysql_data[] = array(
                "t_ds_nome_salvo" => $lancamentos_pk."Lanc-".($query[0]['total']+1)."-".$ds_arquivo,
                "t_functions" => ""
            );
        }
        else{
            rename("../docs/$ds_arquivo", "../docs/Lanc-".($query[0]['total']+1)."-".$ds_arquivo);
            $mysql_data[] = array(
                "t_ds_nome_salvo" => "Lanc-".($query[0]['total']+1)."-".$ds_arquivo,

                "t_functions" => ""
            );
        }
            
        /*}
        else{
            $mysql_data = [];
        }*/
		
        break;
    }    
    
    case 'removerArquivo':{
        
        $nome_arquivo = $_REQUEST['nome_arquivo'];
        
        unlink("../docs/".$nome_arquivo);
        $result  = 'success';
        $message = 'query success';
        break;
    } 
    case 'listarDocumentosOc':{
        
        $ocorrencias_pk = $_REQUEST['ocorrencias_pk'];
        $resultado = "";
        if($ocorrencias_pk!=""){
            $query = $documentodao->listar_documetos_ocorrencia($ocorrencias_pk);
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
                    "t_ds_documento"=>$query[$i]['ds_documento'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],
                    "t_agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }  
    case 'listarDocumentosAgenda':{
        
        $agendas_pk = $_REQUEST['agendas_pk'];
        $resultado = "";
        if($agendas_pk!=""){
            $query = $documentodao->listarDocumentosAgenda($agendas_pk);
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
                    "t_ds_documento"=>$query[$i]['ds_documento'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_agendas_pk"=>$query[$i]['agendas_pk'],
                    "t_agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }  
    case 'listarDocumentosLancamentos':{
        
        $lancamentos_pk = $_REQUEST['lancamentos_pk'];
        $resultado = "";
        if($lancamentos_pk!=""){
            $query = $documentodao->listar_documetos_lancamentos($lancamentos_pk);
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
                    "t_ds_documento"=>$query[$i]['ds_documento'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],
                    "t_agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }  
    case 'listarDocumentosCompra':{
        
        $compras_pk = $_REQUEST['compras_pk'];
        $resultado = "";
        if($compras_pk!=""){
            $query = $documentodao->listar_documetos_compras($compras_pk);
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
                    "t_ds_documento"=>$query[$i]['ds_documento'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],
                    "t_agenda_colaborador_tarefa_pk"=>$query[$i]['agenda_colaborador_tarefa_pk'],

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

$documentodao = null;

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
