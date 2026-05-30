<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/faturamento_contratos.dao.php";
require_once "../model/faturamento_contratos.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ic_tipo_contrato = $arrRequest['ic_tipo_contrato'];
$contratos_pk = $arrRequest['contratos_pk'];
$leads_pk = $arrRequest['leads_pk'];
$faturamento_pk = $arrRequest['faturamento_pk'];
$vl_total_contrato = $arrRequest['vl_total_contrato'];
$ic_status = $arrRequest['ic_status'];
$obs_corpo_nota_fiscal = $arrRequest['obs_corpo_nota_fiscal'];
$dt_faturamento = $arrRequest['dt_faturamento'];
$dt_vencimento = $arrRequest['dt_vencimento'];
$arrItens = $arrRequest['arrItens'];


$faturamento_contratosdao = new faturamento_contratosdao();
$faturamento_contratosdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $faturamento_contratos = $faturamento_contratosdao->carregarPorPk($pk);
        if($faturamento_contratos->getpk()>0){
            
            $faturamento_contratosdao->excluir($faturamento_contratos);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'faturamento_contratos nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $faturamento_contratos = $faturamento_contratosdao->carregarPorPk($pk);
        $faturamento_contratos->setic_tipo_contrato($ic_tipo_contrato);
        $faturamento_contratos->setcontratos_pk($contratos_pk);
        $faturamento_contratos->setleads_pk($leads_pk);
        $faturamento_contratos->setfaturamento_pk($faturamento_pk);
        $faturamento_contratos->setvl_total_contrato($vl_total_contrato);
        $faturamento_contratos->setic_status($ic_status);
        $faturamento_contratos->setobs_corpo_nota_fiscal($obs_corpo_nota_fiscal);
        $faturamento_contratos->setdt_faturamento($dt_faturamento);
        $faturamento_contratos->setdt_vencimento($dt_vencimento);

        
        $pk = $faturamento_contratosdao->salvar($faturamento_contratos, $arrItens);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $faturamento_contratosdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ic_tipo_contrato"=>$query[$i]['ic_tipo_contrato'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "faturamento_pk"=>$query[$i]['faturamento_pk'],
                    "vl_total_contrato"=>$query[$i]['vl_total_contrato'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "obs_corpo_nota_fiscal"=>$query[$i]['obs_corpo_nota_fiscal']
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
        $query = $faturamento_contratosdao->listar_por_ic_tipo_contrato($ic_tipo_contrato);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ic_tipo_contrato"=>$query[$i]['ic_tipo_contrato'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "faturamento_pk"=>$query[$i]['faturamento_pk'],
                    "vl_total_contrato"=>$query[$i]['vl_total_contrato'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "obs_corpo_nota_fiscal"=>$query[$i]['obs_corpo_nota_fiscal']
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
        $query = $faturamento_contratosdao->listar_por_ic_tipo_contrato($ic_tipo_contrato);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ic_tipo_contrato"=>$query[$i]['ic_tipo_contrato'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_faturamento_pk"=>$query[$i]['faturamento_pk'],
                    "t_vl_total_contrato"=>$query[$i]['vl_total_contrato'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_obs_corpo_nota_fiscal"=>$query[$i]['obs_corpo_nota_fiscal'],

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

$faturamento_contratosdao = null;

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
