<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/genero.dao.php";
require_once "../model/genero.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_genero = $arrRequest['ds_genero'];


$generodao = new generodao();
$generodao->setToken($token); 

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        if(!permissao("genero", "del", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $resultdo = "";
        
        $genero = $generodao->carregarPorPk($pk);
        if($genero->getpk()>0){
            $log_exclusaodao->salvar("genero",$genero->getpk());
            $generodao->excluir($genero);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'genero nao encontrado';
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
        if(!permissao("genero", $ic_acao, $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $genero = $generodao->carregarPorPk($pk);
        $genero->setds_genero($ds_genero);

        
        $pk = $generodao->salvar($genero);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        if(!permissao("genero", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $resultado = "";
        $query = $generodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_genero"=>$query[$i]['ds_genero']
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
        $query = $generodao->listar_por_ds_genero($ds_genero);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_genero"=>$query[$i]['ds_genero']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        if(!permissao("genero", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        
        $resultado = "";
        $query = $generodao->listar_por_ds_genero($ds_genero);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_genero"=>$query[$i]['ds_genero'],

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

$generodao = null;

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
