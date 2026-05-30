<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/contrato_dados_faturamento.dao.php";
require_once "../model/contrato_dados_faturamento.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$metodos_pagamento_pk = $arrRequest['metodos_pagamento_pk'];
$num_parcela = $arrRequest['num_parcela'];
$dt_pagamento = $arrRequest['dt_pagamento'];
$vl_servico = $arrRequest['vl_servico'];
$contratos_pk = $arrRequest['contratos_pk'];
$dt_faturamento = $arrRequest['dt_faturamento'];


$contrato_dados_faturamentodao = new contrato_dados_faturamentodao();
$contrato_dados_faturamentodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $contrato_dados_faturamento = $contrato_dados_faturamentodao->carregarPorPk($pk);
        if($contrato_dados_faturamento->getpk()>0){
            
            $contrato_dados_faturamentodao->excluir($contrato_dados_faturamento);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'contrato_dados_faturamento nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $contrato_dados_faturamento = $contrato_dados_faturamentodao->carregarPorPk($pk);
        $contrato_dados_faturamento->setmetodos_pagamento_pk($metodos_pagamento_pk);
        $contrato_dados_faturamento->setnum_parcela($num_parcela);
        $contrato_dados_faturamento->setdt_pagamento($dt_pagamento);
        $contrato_dados_faturamento->setvl_servico($vl_servico);
        $contrato_dados_faturamento->setdt_faturamento($dt_faturamento);
        $contrato_dados_faturamento->setcontratos_pk($contratos_pk);

        
        $pk = $contrato_dados_faturamentodao->salvar($contrato_dados_faturamento);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $contrato_dados_faturamentodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "num_parcela"=>$query[$i]['num_parcela'],
                    "dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "vl_servico"=>$query[$i]['vl_servico'],
                    "contratos_pk"=>$query[$i]['contratos_pk']
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
    case 'listarGridContratoDadosFaturamento':{
        $contratos_pk = $_REQUEST['contrato_pk'];
        $resultado = "";
        if($contratos_pk!=""){
            $query = $contrato_dados_faturamentodao->listarGridContratoDadosFaturamento($contratos_pk);
        
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                        "num_parcela"=>$query[$i]['num_parcela'],
                        "dt_pagamento"=>$query[$i]['dt_pagamento'],
                        "dt_faturamento"=>$query[$i]['dt_faturamento'],
                        "vl_servico"=>$query[$i]['vl_servico'],
                        "ult_dt_pagamento"=>$query[(count($query)-1)]['dt_pagamento'],
                        "contratos_pk"=>$query[$i]['contratos_pk']
                    );
                }
            }
            else{
                $mysql_data = [];
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
        $query = $contrato_dados_faturamentodao->listar_por_metodos_pagamento_pk($metodos_pagamento_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "num_parcela"=>$query[$i]['num_parcela'],
                    "dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "vl_servico"=>$query[$i]['vl_servico'],
                    "contratos_pk"=>$query[$i]['contratos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'addMes':{
        $dt_base = $_REQUEST['dt_base'];
        $mes = $_REQUEST['mes'];
        $resultado = "";
        $query = $contrato_dados_faturamentodao->addMes($dt_base,$mes);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "dt_base" => $query[$i]["dt_base"]
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
        $query = $contrato_dados_faturamentodao->listar_por_metodos_pagamento_pk($metodos_pagamento_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "t_num_parcela"=>$query[$i]['num_parcela'],
                    "t_dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "t_dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "t_vl_servico"=>$query[$i]['vl_servico'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],

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

$contrato_dados_faturamentodao = null;

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
