<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/financeiro_conciliacao_lancamentos.dao.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$lancamentos_pk = $arrRequest['lancamentos_pk'];
$financeiro_conciliacao_banco_itens_pk = $arrRequest['financeiro_conciliacao_banco_itens_pk'];
$obs = $arrRequest['obs'];
$ic_status = $arrRequest['ic_status'];


$financeiro_conciliacao_lancamentosdao = new financeiro_conciliacao_lancamentosdao();
$financeiro_conciliacao_lancamentosdao->setToken($token); 

switch($job){
    case 'salvar':{
       


        if($pk != ""){
            if(!empty($lancamentos_pk)){
                if($ic_status != 1){
                   
                    $lancamentos_pk = "null";
                    $financeiro_conciliacao_banco_itens_pk = "null";
                }
            }
        }
        $financeiro_conciliacao_lancamentos = [
            "pk"=>$pk,
            "lancamentos_pk"=>$lancamentos_pk,
            "financeiro_conciliacao_banco_itens_pk" =>$financeiro_conciliacao_banco_itens_pk,
            "ic_status"=>$ic_status,
            "obs"=>$obs
        ];
       

        $financeiro_conciliacao_lancamentosdao->salvar($financeiro_conciliacao_lancamentos);

        //VERIFICA NA HORA DE ALTERAR O STATUS DE CONCILIADO PARA OUTRO STATUS, REMOVER CHECKBOX
        
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    default:{
        break;
    }
}

$faturamentodao = null;

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
