<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/plano_contas.dao.php";
require_once "../model/plano_contas.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_tipo_operacao = $arrRequest['ds_tipo_operacao'];
$ic_status = $arrRequest['ic_status'];
$categorias_financeiras_pk = $arrRequest['categorias_financeiras_pk'];


$plano_contasdao = new plano_contasdao();
$plano_contasdao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $plano_contas = $plano_contasdao->carregarPorPk($pk);
        if($plano_contas->getpk()>0){
            $log_exclusaodao->salvar("plano_contas",$plano_contas->getpk());
            $plano_contasdao->excluir($plano_contas);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'plano_contas nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $plano_contas = $plano_contasdao->carregarPorPk($pk);
        $plano_contas->setds_tipo_operacao($ds_tipo_operacao);
        $plano_contas->setic_status($ic_status);
        $plano_contas->setcategorias_financeiras_pk($categorias_financeiras_pk);

        
        $pk = $plano_contasdao->salvar($plano_contas);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $plano_contasdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "categorias_financeiras_pk"=>$query[$i]['categorias_financeiras_pk']
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
    case 'listaPorCategoria':{
        
        $categorias_financeiras_pk = $_REQUEST['categorias_financeiras_pk'];
        $resultado = "";
        $query = $plano_contasdao->listaPorCategoria($categorias_financeiras_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "categorias_financeiras_pk"=>$query[$i]['categorias_financeiras_pk']
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
        $query = $plano_contasdao->listar_por_ds_tipo_operacao($ds_tipo_operacao);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "categorias_financeiras_pk"=>$query[$i]['categorias_financeiras_pk']
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
        $query = $plano_contasdao->listar_por_ds_tipo_operacao($ds_tipo_operacao,$categorias_financeiras_pk,$ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "t_ds_status"=>$query[$i]['ds_status'],          
                    "t_ds_categoria"=>$query[$i]['ds_categoria'],

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

$plano_contasdao = null;

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
