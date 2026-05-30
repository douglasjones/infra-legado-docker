<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/conta_bancaria.dao.php";
require_once "../model/conta_bancaria.class.php";
include_once "../model/lancamento.dao.php";
include_once "../model/lancamento.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_conta_bancaria = $arrRequest['ds_conta_bancaria'];
$ds_agencia = $arrRequest['ds_agencia'];
$ds_conta = $arrRequest['ds_conta'];
$tipo_conta_pk = $arrRequest['tipo_conta_pk'];
$vl_saldo_inicial = $arrRequest['vl_saldo_inicial'];
$ic_status = $arrRequest['ic_status'];
$bancos_pk = $arrRequest['bancos_pk'];
$empresas_pk = $arrRequest['empresas_pk'];


$conta_bancariadao = new conta_bancariadao();
$conta_bancariadao->setToken($token); 

$lancamentodao = new lancamentodao();
$lancamentodao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $conta_bancaria = $conta_bancariadao->carregarPorPk($pk);
        if($conta_bancaria->getpk()>0){
            
            $log_exclusaodao->salvar("conta_bancaria",$conta_bancaria->getpk());
            
            $conta_bancariadao->excluir($conta_bancaria);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'conta_bancaria nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $conta_bancaria = $conta_bancariadao->carregarPorPk($pk);
        $conta_bancaria->setds_conta_bancaria($ds_conta_bancaria);
        $conta_bancaria->setds_agencia($ds_agencia);
        $conta_bancaria->setds_conta($ds_conta);
        $conta_bancaria->settipo_conta_pk($tipo_conta_pk);
        $conta_bancaria->setvl_saldo_inicial($vl_saldo_inicial);
        $conta_bancaria->setic_status($ic_status);
        $conta_bancaria->setbancos_pk($bancos_pk);
        $conta_bancaria->setempresas_pk($empresas_pk);

        $pk = $conta_bancariadao->salvar($conta_bancaria);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    
   case 'listarEmpresaContasAtivas':{
        
        $resultado = "";
        $query = $conta_bancariadao->listarEmpresaContasAtivas();

        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){

            for($i = 0; $i < count($query); $i++){
                 
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_conta"=>$query[$i]['ds_conta'],           
                );
            }
        }else{
            $mysql_data = [];
        }
        break;
    }

    case 'listaPorEmpresa':{

        $resultado = "";
        $query = $conta_bancariadao->listaPorEmpresa($empresas_pk);

        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){

            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_conta"=>$query[$i]["ds_conta"]          
                );
            }
        }else{
            $mysql_data = [];
        }
        break;
    }



    case 'listarPk':{
        
        $resultado = "";
        $query = $conta_bancariadao->listarPorPk($pk);


        $resultado = "";
        $queryReceita = $lancamentodao->listarValoresReceita("","",$pk);
        $queryDespesas = $lancamentodao->listarValoresDespesas("","",$pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "ds_agencia"=>$query[$i]['ds_agencia'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "vl_inicial_conta"=>$query[$i]['vl_saldo_inicial'],
                    "tipo_conta_pk"=>$query[$i]['tipo_conta_pk'],
                    "vl_saldo_inicial"=>(($queryReceita[0]['vl_lancamento'] - $queryDespesas[0]['vl_lancamento']) + $query[$i]['vl_saldo_inicial']),
                    "ic_status"=> $query[$i]['ic_status'],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "bancos_pk"=>$query[$i]['bancos_pk']
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
        $query = $conta_bancariadao->listarContasLancamento($empresas_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "ds_agencia"=>$query[$i]['ds_agencia'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "tipo_conta_pk"=>$query[$i]['tipo_conta_pk'],
                    "vl_saldo_inicial"=>$query[$i]['vl_saldo_inicial'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "bancos_pk"=>$query[$i]['bancos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        
        break;
    }
    
        case 'listarContasLancamento':{
        
            $empresas_pk = $_REQUEST['empresas_pk'];
        $resultado = "";
        $query = $conta_bancariadao->listarContasLancamento($empresas_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
               
                if($query[$i]['ds_conta']==""){
                    $ds_dados_conta = $query[$i]['ds_conta_bancaria'];
                }
                else{
                    $ds_dados_conta = $query[$i]['ds_dados_conta'];
                }
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "ds_agencia"=>$query[$i]['ds_agencia'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "tipo_conta_pk"=>$query[$i]['tipo_conta_pk'],
                    "vl_saldo_inicial"=>$query[$i]['vl_saldo_inicial'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "bancos_pk"=>$query[$i]['bancos_pk'],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    
                    "ds_dados_conta"=>$ds_dados_conta,
                    
                    
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
        $query = $conta_bancariadao->listar_por_ds_conta_bancaria($bancos_pk,$ds_conta,$ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_banco"=>$query[$i]['ds_banco'],
                    "t_ds_tipo_conta"=>$query[$i]['ds_tipo_conta'],
                    "t_ds_agencia"=>$query[$i]['ds_agencia'],
                    "t_ds_conta"=>$query[$i]['ds_conta'],                    
                    "t_vl_saldo_inicial"=>number_format($query[$i]['vl_saldo_inicial'],2,',','.'),   
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],
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

$conta_bancariadao = null;

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
