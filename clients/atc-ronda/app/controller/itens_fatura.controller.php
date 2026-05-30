<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/itens_fatura.dao.php";
require_once "../model/itens_fatura.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";


$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$tipo_item_fatura = $arrRequest['tipo_item_fatura'];
$vl_total = $arrRequest['vl_total'];
$fatura_pk = $arrRequest['fatura_pk'];


$itens_faturadao = new itens_faturadao();
$itens_faturadao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $itens_fatura = $itens_faturadao->carregarPorPk($pk);
        if($itens_fatura->getpk()>0){
            $log_exclusaodao->salvar("itens_fatura",$itens_fatura->getpk());
            $itens_faturadao->excluir($itens_fatura);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'itens_fatura nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $itens_fatura = $itens_faturadao->carregarPorPk($pk);
        $itens_fatura->settipo_item_fatura($tipo_item_fatura);
        $itens_fatura->setvl_total($vl_total);
        $itens_fatura->setfatura_pk($fatura_pk);

        
        $pk = $itens_faturadao->salvar($itens_fatura);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $itens_faturadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_item_fatura"=>$query[$i]['tipo_item_fatura'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "fatura_pk"=>$query[$i]['fatura_pk']
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
        $query = $itens_faturadao->listar_por_tipo_item_fatura($tipo_item_fatura);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_item_fatura"=>$query[$i]['tipo_item_fatura'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "fatura_pk"=>$query[$i]['fatura_pk']
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
        $query = $itens_faturadao->listar_por_tipo_item_fatura($tipo_item_fatura);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_tipo_item_fatura"=>$query[$i]['tipo_item_fatura'],
                    "t_vl_total"=>$query[$i]['vl_total'],
                    "t_fatura_pk"=>$query[$i]['fatura_pk'],

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

$itens_faturadao = null;

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
