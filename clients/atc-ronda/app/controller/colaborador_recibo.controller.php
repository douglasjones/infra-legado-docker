<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/colaborador_recibo.dao.php";
require_once "../model/colaborador_recibo.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$vl_total = $arrRequest['vl_total'];
$tipos_recibos_pk = $arrRequest['tipos_recibos_pk'];

$mes_ini_pk = $arrRequest['mes_ini_pk'];
$ano_ini_pk = $arrRequest['ano_ini_pk'];
$mes_fim_pk = $arrRequest['mes_fim_pk'];
$ano_fim_pk = $arrRequest['ano_fim_pk'];

$colaborador_recibodao = new colaborador_recibodao();
$colaborador_recibodao->setToken($token); 

switch($job){

    case 'excluir':{
       
        $resultdo = "";
        
        $colaboradores_recibos_pk = $pk;
        
        $colaborador_recibodao->excluirItens($colaboradores_recibos_pk);
        
        $colaborador_recibo = $colaborador_recibodao->carregarPorPk($pk);
        if($colaborador_recibo->getpk()>0){
            
            $colaborador_recibodao->excluir($colaborador_recibo);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }else{
            $result  = 'error';
            $message = 'colaborador_recibo nao encontrado';
        }
        break;
    }
    case 'salvar':{
      
        $colaborador_recibo = $colaborador_recibodao->carregarPorPk($pk);
         
        $colaborador_recibo->setcolaborador_pk($colaborador_pk);
        $colaborador_recibo->setvl_total($vl_total);
        $colaborador_recibo->settipos_recibos_pk($tipos_recibos_pk);
        $colaborador_recibo->setmes_ini_pk($mes_ini_pk);
        $colaborador_recibo->setano_ini_pk($ano_ini_pk);
        $colaborador_recibo->setmes_fim_pk($mes_fim_pk);
        $colaborador_recibo->setano_fim_pk($ano_fim_pk);

        $pk = $colaborador_recibodao->salvar($colaborador_recibo);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    
    case 'excluirItens':{       
        $resultdo = "";

        $colaboradores_recibos_pk = $_REQUEST['colaboradores_recibos_pk'];
        
        $colaborador_recibodao->excluirItens($colaboradores_recibos_pk);

        $result  = 'success';
        $message = 'Registro excluído com sucesso.';
        
        break;
    }
    
    
    
    case 'salvarItens':{     
        
        $dt_registro = $_REQUEST['dt_registro'];
        $ds_dia_semana = $_REQUEST['ds_dia_semana'];
        $leads_pk = $_REQUEST['leads_pk'];
        $hr_ini_expediente =  $_REQUEST['hr_ini_expediente'];
        $hr_fim_expediente = $_REQUEST['hr_fim_expediente'];
        $ds_total_hr = $_REQUEST['ds_total_hr'];
        $vl_unitario = $_REQUEST['vl_unitario'];
        $colaboradores_recibos_pk = $_REQUEST['colaboradores_recibos_pk'];
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];

        $pk = $colaborador_recibodao->salvarItens($dt_registro,$ds_dia_semana,$leads_pk,$hr_ini_expediente,$hr_fim_expediente,$ds_total_hr,$vl_unitario,$colaboradores_recibos_pk,$produtos_servicos_pk);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarDadosImpressao':{
        
        $colaborador_recibo_pk = $_REQUEST['colaborador_recibo_pk'];        

        $resultado = "";
        $query = $colaborador_recibodao->listarPorPk($colaborador_recibo_pk);
        
        if(count($query) > 0){
            $queryItens = $colaborador_recibodao->listarItensPorPk($colaborador_recibo_pk);
            if(count($queryItens) > 0){
                for($j = 0; $j < count($queryItens); $j++){ 
                    $DadosReciboItens[] = array( 
                        "pk"=>$queryItens[$j]['pk'],
                        "dt_registro"=>$queryItens[$j]['dt_registro'],
                        "dia_registro"=>$queryItens[$j]['dia_registro'],
                        "mes_registro"=>$queryItens[$j]['mes_registro'],
                        "ano_registro"=>$queryItens[$j]['ano_registro'],
                        "ds_dia_semana"=>$queryItens[$j]['ds_dia_semana'],
                        "ds_lead"=>$queryItens[$j]['ds_lead'],
                        "ds_produto_servico"=>$queryItens[$j]['ds_produto_servico'],
                        "hr_ini_expediente"=>$queryItens[$j]['hr_ini_expediente'],
                        "hr_fim_expediente"=>$queryItens[$j]['hr_fim_expediente'],
                        "ds_total_hr"=>$queryItens[$j]['ds_total_hr'],
                        "vl_unitario"=>number_format($queryItens[$j]['vl_unitario'],2,",","."),
                        "leads_pk"=>$queryItens[$j]['leads_pk'],
                        "produtos_servicos_pk"=>$queryItens[$j]['produtos_servicos_pk'],                       
                                                
                    ); 
                }
            }            
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "tipos_recibos_pk"=>$query[$i]['tipos_recibos_pk'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "mes_ini_pk"=>$query[$i]['mes_ini_pk'],
                    "ano_ini_pk"=>$query[$i]['ano_ini_pk'],
                    "mes_fim_pk"=>$query[$i]['mes_fim_pk'],
                    "ano_fim_pk"=>$query[$i]['ano_fim_pk'],
                    "DadosReciboItens"=>$DadosReciboItens
                );
            }
        }else{
            $mysql_data = [];
        }
			
        $result  = 'success';
        $message = 'query success';
        
        break;        
    }  

    
    
    case 'listarPk':{
        
        $resultado = "";
        $query = $colaborador_recibodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "tipos_recibos_pk"=>$query[$i]['tipos_recibos_pk']
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
        $query = $colaborador_recibodao->listar_por_colaborador_pk($colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "tipos_recibos_pk"=>$query[$i]['tipos_recibos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{       
 
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_registro_ini = $_REQUEST['dt_registro_ini'];
        $dt_registro_fim = $_REQUEST['dt_registro_fim'];
        
        $resultado = "";
        $query = $colaborador_recibodao->listarDataTable($tipos_recibos_pk,$colaborador_pk,$leads_pk,$dt_registro_ini,$dt_registro_fim);
        
        $result  = 'success';
        $message = 'query success';

        
                $sql.="                tr.ds_recibo,";
        $sql.="                c.ds_colaborador,";
        $sql.="                l.ds_lead,";
        $sql.="                date_format(cr.dt_cadastro, '%d/%m/%Y') dt_cadastro";
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_recibo"=>$query[$i]['ds_recibo'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    
    
    case 'listarTiposRecibos':{
        
        $resultado = "";
        $query = $colaborador_recibodao->listarTiposRecibos($tipos_recibos_pk);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_recibo"=>$query[$i]['ds_recibo']
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
    
    default:{
        break;
    }
}

$colaborador_recibodao = null;

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
