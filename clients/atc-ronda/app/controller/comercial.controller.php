<?
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/comercial.dao.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];   
$processo_default_configuracao_pk = $arrRequest['processo_default_configuracao_pk'];     
$modulos_pk = $arrRequest['modulos_pk'];
$processo_movimentacao_status_pk_pai = $arrRequest['processo_movimentacao_status_pk_pai']; 
$ic_cartao_movimentado = $arrRequest['ic_cartao_movimentado'];

$comercialdao = new comercialdao();
$comercialdao->setToken($token);


switch($job){
    case 'salvarProcessoMovimentacaoStatus':{  
        $pk = $comercialdao->salvarProcessoMovimentacaoStatus($processo_default_configuracao_pk, $modulos_pk, $processo_movimentacao_status_pk_pai, $ic_cartao_movimentado);

        $mysql_data[] = array(
                "pk" => $pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'salvarProcessoMovimentacaoPesquisa':{  
        $message = $comercialdao->salvarProcessoMovimentacaoPesquisa($modulos_pk);

        $mysql_data[] = array(
            "pk" => ''
        );
        
        $result  = 'success';
        $message = $message;        
        
        break;
    }
    case 'verificacaoModuloObrigatorio':{
        $query = $comercialdao->verificacaoModuloObrigatorio($processo_default_configuracao_pk);

        $mysql_data[] = array(
            "pk" => $query[0]['pk'],
            "ds_processo_default_configuracao"=> $query[0]['ds_processo_default_configuracao']
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';          
        
        break;
    }
    case 'pesquisarModuloAgenda':{
        $query = $comercialdao->pesquisarModuloAgenda($modulos_pk);

        $mysql_data[] = array(
            "pk" => $query[0]['pk'],
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';         
        
        break; 
    }default:{
        break;
    }
}

$comercialdao = null;

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
