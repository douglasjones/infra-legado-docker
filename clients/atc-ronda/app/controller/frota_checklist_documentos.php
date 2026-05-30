<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/frota_checklist_documentos.dao.php";
require_once "../model/frota_checklist_documentos.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_documento = $arrRequest['ds_documento'];
$ds_obs = $arrRequest['ds_obs'];
$ds_nome_original = $arrRequest['ds_nome_original'];
$frota_checklist_pk = $arrRequest['frota_checklist_pk'];


$frota_checklist_documentosdao = new frota_checklist_documentosdao();
$frota_checklist_documentosdao->setToken($token); 

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
        
        $frota_checklist_documentos = $frota_checklist_documentosdao->carregarPorPk($pk);
        if($frota_checklist_documentos->getpk()>0){
            
            $frota_checklist_documentosdao->excluir($frota_checklist_documentos);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'frota_checklist_documentos nao encontrado';
        }
        break;
    }
    case 'salvar':{

        
        $ds_arquivo = $_REQUEST['ds_arquivo'];
        $frota_checklist_documentos = $frota_checklist_documentosdao->carregarPorPk($pk);
        if($ds_arquivo != "")
            $arrDsArquivos = json_decode ($ds_arquivo, true);
        
        if(count($arrDsArquivos) > 0){
            for($i = 0; $i < count($arrDsArquivos); $i++){
        
                $frota_checklist_documentos = $frota_checklist_documentosdao->carregarPorPk($pk);
                $frota_checklist_documentos->setds_documento($ds_documento);
                $frota_checklist_documentos->setds_obs($ds_obs);
                $frota_checklist_documentos->setds_nome_original($ds_nome_original);
                $frota_checklist_documentos->setfrota_checklist_pk($frota_checklist_pk);
                
                $pk = $frota_checklist_documentosdao->salvar($frota_checklist_documentos);
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
        $query = $frota_checklist_documentosdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_documento"=>$query[$i]['ds_documento'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "frota_checklist_pk"=>$query[$i]['frota_checklist_pk']
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

    case 'removerArquivo':{
        
        $nome_arquivo = $_REQUEST['nome_arquivo'];
        
        unlink("../docs/".$nome_arquivo);
        $result  = 'success';
        $message = 'query success';
        break;
    } 
    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $frota_checklist_documentosdao->listar_por_ds_documento($ds_documento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_documento"=>$query[$i]['ds_documento'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "frota_checklist_pk"=>$query[$i]['frota_checklist_pk']
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
        $query = $frota_checklist_documentosdao->listar_por_ds_documento($ds_documento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_documento"=>$query[$i]['ds_documento'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "t_frota_checklist_pk"=>$query[$i]['frota_checklist_pk'],

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

$frota_checklist_documentosdao = null;

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
