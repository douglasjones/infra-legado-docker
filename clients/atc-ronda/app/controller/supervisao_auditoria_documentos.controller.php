<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/supervisao_auditoria_documentos.dao.php";
require_once "../model/supervisao_auditoria_documentos.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_documento = $arrRequest['ds_documento'];
$ds_obs = $arrRequest['ds_obs'];
$ds_nome_original = $arrRequest['ds_nome_original'];
$supervisao_auditorias_pk = $arrRequest['supervisao_auditorias_pk'];
$ds_arquivo = $arrRequest['ds_arquivo'];

$supervisao_auditoria_documentosdao = new supervisao_auditoria_documentosdao();
$supervisao_auditoria_documentosdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $supervisao_auditoria_documentos = $supervisao_auditoria_documentosdao->carregarPorPk($pk);
        if($supervisao_auditoria_documentos->getpk()>0){
            
            $supervisao_auditoria_documentosdao->excluir($supervisao_auditoria_documentos);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'supervisao_auditoria_documentos nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $supervisao_auditoria_documentos = $supervisao_auditoria_documentosdao->carregarPorPk($pk);
        if($ds_arquivo != "")
            $arrDsArquivos = json_decode ($ds_arquivo, true);
        
        if(count($arrDsArquivos) > 0){
            for($i = 0; $i < count($arrDsArquivos); $i++){
                
                
                $supervisao_auditoria_documentos->setds_documento($arrDsArquivos[$i]['ds_documento']);
                $supervisao_auditoria_documentos->setds_obs($ds_obs);
                $supervisao_auditoria_documentos->setds_nome_original($arrDsArquivos[$i]['ds_nome_original']);
                $supervisao_auditoria_documentos->setsupervisao_auditorias_pk($supervisao_auditorias_pk);

                $pk = $supervisao_auditoria_documentosdao->salvar($supervisao_auditoria_documentos);  
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
        $query = $supervisao_auditoria_documentosdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_documento"=>$query[$i]['ds_documento'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "supervisao_auditorias_pk"=>$query[$i]['supervisao_auditorias_pk']
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
        $query = $supervisao_auditoria_documentosdao->listar_por_ds_documento($ds_documento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_documento"=>$query[$i]['ds_documento'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "supervisao_auditorias_pk"=>$query[$i]['supervisao_auditorias_pk']
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
        $query = $supervisao_auditoria_documentosdao->listar_supervisao_auditorias_pk($supervisao_auditorias_pk);
        
        $result  = 'success';
        $message = 'query success';
        if($supervisao_auditorias_pk != 0){
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
    
                    $mysql_data[] = array(
                        "t_pk" => $query[$i]["pk"],
                        "t_ds_documento"=>$query[$i]['ds_documento'],
                        "t_ds_obs"=>$query[$i]['ds_obs'],
                        "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                        "t_supervisao_auditorias_pk"=>$query[$i]['supervisao_auditorias_pk'],
    
                        "t_functions" => ""
                    );
                }
            }
            else{
                $mysql_data = [];
            }
            
            break;
        }else{
            $mysql_data = [];
        }

        
    }    
    default:{
        break;
    }
}

$supervisao_auditoria_documentosdao = null;

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
