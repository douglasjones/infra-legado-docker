<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/teto_gastos_itens.dao.php";
require_once "../model/teto_gastos_itens.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$operacao_pk = $arrRequest['operacao_pk'];
$categoria_operacao_pk = $arrRequest['categoria_operacao_pk'];
$tipos_operacao_pk = $arrRequest['tipos_operacao_pk'];
$dt_ini_teto = $arrRequest['dt_ini_teto'];
$dt_fim_teto = $arrRequest['dt_fim_teto'];
$vl_teto_anual = $arrRequest['vl_teto_anual'];
$vl_teto_mensal = $arrRequest['vl_teto_mensal'];
$ic_teto_mensal = $arrRequest['ic_teto_mensal'];
$vl_teto_anual_atual = $arrRequest['vl_teto_anual_atual'];
$vl_teto_mensal_atual = $arrRequest['vl_teto_mensal_atual'];
$ic_status = $arrRequest['ic_status'];
$obs = $arrRequest['obs'];
$teto_gastos_pk = $arrRequest['teto_gastos_pk'];


$teto_gastos_itensdao = new teto_gastos_itensdao();
$teto_gastos_itensdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $teto_gastos_itens = $teto_gastos_itensdao->carregarPorPk($pk);
        if($teto_gastos_itens->getpk()>0){
            
            $teto_gastos_itensdao->excluir($teto_gastos_itens);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'teto_gastos_itens nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $teto_gastos_itens = $teto_gastos_itensdao->carregarPorPk($pk);
        $teto_gastos_itens->setoperacao_pk($operacao_pk);
        $teto_gastos_itens->setcategoria_operacao_pk($categoria_operacao_pk);
        $teto_gastos_itens->settipos_operacao_pk($tipos_operacao_pk);
        $teto_gastos_itens->setdt_ini_teto($dt_ini_teto);
        $teto_gastos_itens->setdt_fim_teto($dt_fim_teto);
        $teto_gastos_itens->setvl_teto_anual($vl_teto_anual);
        $teto_gastos_itens->setvl_teto_mensal($vl_teto_mensal);
        $teto_gastos_itens->setic_teto_mensal($ic_teto_mensal);
        $teto_gastos_itens->setvl_teto_anual_atual($vl_teto_anual_atual);
        $teto_gastos_itens->setvl_teto_mensal_atual($vl_teto_mensal_atual);
        $teto_gastos_itens->setic_status($ic_status);
        $teto_gastos_itens->setobs($obs);
        $teto_gastos_itens->setteto_gastos_pk($teto_gastos_pk);

        
        $return = $teto_gastos_itensdao->salvar($teto_gastos_itens);
        
        $mysql_data[] = array(
                "pk" => $return[0]['pk'],
                "mensagem_erro" => $return[0]['mensagem_erro']
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $teto_gastos_itensdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "operacao_pk"=>$query[$i]['operacao_pk'],
                    "categoria_operacao_pk"=>$query[$i]['categoria_operacao_pk'],
                    "tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "dt_ini_teto"=>$query[$i]['dt_ini_teto'],
                    "dt_fim_teto"=>$query[$i]['dt_fim_teto'],
                    "vl_teto_anual"=>$query[$i]['vl_teto_anual'],
                    "vl_teto_mensal"=>$query[$i]['vl_teto_mensal'],
                    "ic_teto_mensal"=>$query[$i]['ic_teto_mensal'],
                    "vl_teto_anual_atual"=>$query[$i]['vl_teto_anual_atual'],
                    "vl_teto_mensal_atual"=>$query[$i]['vl_teto_mensal_atual'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "obs"=>$query[$i]['obs'],
                    "teto_gastos_pk"=>$query[$i]['teto_gastos_pk']
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
        $query = $teto_gastos_itensdao->listar_por_teto_gastos_pk($teto_gastos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "operacao_pk"=>$query[$i]['operacao_pk'],
                    "categoria_operacao_pk"=>$query[$i]['categoria_operacao_pk'],
                    "tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "dt_ini_teto"=>$query[$i]['dt_ini_teto'],
                    "dt_fim_teto"=>$query[$i]['dt_fim_teto'],
                    "vl_teto_anual"=>$query[$i]['vl_teto_anual'],
                    "vl_teto_mensal"=>$query[$i]['vl_teto_mensal'],
                    "ic_teto_mensal"=>$query[$i]['ic_teto_mensal'],
                    "vl_teto_anual_atual"=>$query[$i]['vl_teto_anual_atual'],
                    "vl_teto_mensal_atual"=>$query[$i]['vl_teto_mensal_atual'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "obs"=>$query[$i]['obs'],
                    "teto_gastos_pk"=>$query[$i]['teto_gastos_pk']
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
        $query = $teto_gastos_itensdao->listar_por_teto_gastos_pk($teto_gastos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_operacao_pk"=>$query[$i]['ds_tipo_operacao'],
                    "t_categoria_operacao_pk"=>$query[$i]['ds_categoria'],
                    "t_tipos_operacao_pk"=>$query[$i]['ds_tipos_operacao'],
                    "t_dt_ini_teto"=>$query[$i]['dt_ini_teto'],
                    "t_dt_fim_teto"=>$query[$i]['dt_fim_teto'],
                    "t_vl_teto_anual"=>number_format($query[$i]['vl_teto_anual'], 2, ',', '.'),
                    "t_vl_teto_mensal"=>number_format($query[$i]['vl_teto_mensal'], 2, ',', '.'),
                    "t_ic_teto_mensal"=>$query[$i]['ic_teto_mensal'],
                    "t_vl_teto_anual_atual"=>number_format($query[$i]['vl_teto_anual_atual'], 2, ',', '.'),
                    "t_vl_teto_mensal_atual"=>number_format($query[$i]['vl_teto_mensal_atual'], 2, ',', '.'),
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_obs"=>$query[$i]['obs'],
                    "t_teto_gastos_pk"=>$query[$i]['teto_gastos_pk'],

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

$teto_gastos_itensdao = null;

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
