<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";

require_once "../model/financeiro_import_lancamentos.dao.php";
require_once "../model/financeiro_import_lancamentos.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_arquivo = $arrRequest['ds_arquivo'];
$obs = $arrRequest['obs'];
$ic_status = $arrRequest['ic_status'];
$ds_link_arquivo = $arrRequest['ds_link_arquivo'];
$ds_identificacao_lote = $arrRequest['ds_identificacao_lote'];


$financeiro_import_lancamentosdao = new financeiro_import_lancamentosdao();
$financeiro_import_lancamentosdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $financeiro_import_lancamentos = $financeiro_import_lancamentosdao->carregarPorPk($pk);
        if($financeiro_import_lancamentos->getpk()>0){
            
            $financeiro_import_lancamentosdao->excluir($financeiro_import_lancamentos);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'financeiro_import_lancamentos nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $financeiro_import_lancamentos = $financeiro_import_lancamentosdao->carregarPorPk($pk);
        $financeiro_import_lancamentos->setds_arquivo($ds_arquivo);
        $financeiro_import_lancamentos->setds_link_arquivo($ds_link_arquivo);
        $financeiro_import_lancamentos->setobs($obs);
        $financeiro_import_lancamentos->setic_status($ic_status);
        $financeiro_import_lancamentos->setds_identificacao_lote($ds_identificacao_lote);

        
        $pk = $financeiro_import_lancamentosdao->salvar($financeiro_import_lancamentos);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $financeiro_import_lancamentosdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_arquivo"=>$query[$i]['ds_arquivo'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status']
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
        $query = $financeiro_import_lancamentosdao->listar_por_ds_arquivo($ds_arquivo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_arquivo"=>$query[$i]['ds_arquivo'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status']
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
        $query = $financeiro_import_lancamentosdao->listar_por_ds_arquivo($ds_arquivo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_arquivo"=>$query[$i]['ds_arquivo'],
                    "t_obs"=>$query[$i]['obs'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_usuario_cadstro"=>$query[$i]['ds_usuario'],
                    "t_ds_identificacao_lote"=>$query[$i]['ds_identificacao_lote'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],

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

$financeiro_import_lancamentosdao = null;

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
