<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/faturamento.dao.php";
require_once "../model/faturamento.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$dt_faturamento_ini = $arrRequest['dt_faturamento_ini'];
$dt_faturamento_fim = $arrRequest['dt_faturamento_fim'];
$ic_contrato_fixo = $arrRequest['ic_contrato_fixo'];
$ic_contrato_aditivo = $arrRequest['ic_contrato_aditivo'];
$ic_contrato_servico_extra = $arrRequest['ic_contrato_servico_extra'];
$ic_gerar_boleto = $arrRequest['ic_gerar_boleto'];
$ic_gerar_nota_fiscal = $arrRequest['ic_gerar_nota_fiscal'];
$ic_gerar_fatura = $arrRequest['ic_gerar_fatura'];
$ic_processar_faturamento = $arrRequest['ic_processar_faturamento'];
$obs = $arrRequest['obs'];
$ic_status = $arrRequest['ic_status'];


$faturamentodao = new faturamentodao();
$faturamentodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $faturamento = $faturamentodao->carregarPorPk($pk);
        if($faturamento->getpk()>0){
            
            $faturamentodao->excluir($faturamento);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'faturamento nao encontrado';
        }
        break;
    }

    case 'processar':{
        try {
            $pk = $faturamentodao->processar($pk, $token);
            $result  = 'success';
            $message = 'Registro salvo com sucesso.';
        }catch (Exception $e) {
            $result  = 'error';
            $message = $e->getMessage();
        }
        break;
    }

    case 'salvar':{
        $faturamento = $faturamentodao->carregarPorPk($pk);
        $faturamento->setdt_faturamento_ini($dt_faturamento_ini);
        $faturamento->setdt_faturamento_fim($dt_faturamento_fim);
        $faturamento->setic_contrato_fixo($ic_contrato_fixo);
        $faturamento->setic_contrato_aditivo($ic_contrato_aditivo);
        $faturamento->setic_contrato_servico_extra($ic_contrato_servico_extra);
        $faturamento->setic_gerar_boleto($ic_gerar_boleto);
        $faturamento->setic_gerar_nota_fiscal($ic_gerar_nota_fiscal);
        $faturamento->setic_gerar_fatura($ic_gerar_fatura);
        $faturamento->setic_processar_faturamento($ic_processar_faturamento);
        $faturamento->setobs($obs);
        $faturamento->setic_status($ic_status);
        
        $pk = $faturamentodao->salvar($faturamento);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{        
        $resultado = "";
        $query = $faturamentodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_faturamento_ini"=>$query[$i]['dt_faturamento_ini'],
                    "dt_faturamento_fim"=>$query[$i]['dt_faturamento_fim'],
                    "ic_contrato_fixo"=>$query[$i]['ic_contrato_fixo'],
                    "ic_contrato_aditivo"=>$query[$i]['ic_contrato_aditivo'],
                    "ic_contrato_servico_extra"=>$query[$i]['ic_contrato_servico_extra'],
                    "ic_gerar_boleto"=>$query[$i]['ic_gerar_boleto'],
                    "ic_gerar_nota_fiscal"=>$query[$i]['ic_gerar_nota_fiscal'],
                    "ic_processar_faturamento"=>$query[$i]['ic_processar_faturamento'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status']
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
        $query = $faturamentodao->listar_por_dt_faturamento_ini($dt_faturamento_ini);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_faturamento_ini"=>$query[$i]['dt_faturamento_ini'],
                    "dt_faturamento_fim"=>$query[$i]['dt_faturamento_fim'],
                    "ic_contrato_fixo"=>$query[$i]['ic_contrato_fixo'],
                    "ic_contrato_aditivo"=>$query[$i]['ic_contrato_aditivo'],
                    "ic_contrato_servico_extra"=>$query[$i]['ic_contrato_servico_extra'],
                    "ic_gerar_boleto"=>$query[$i]['ic_gerar_boleto'],
                    "ic_gerar_nota_fiscal"=>$query[$i]['ic_gerar_nota_fiscal'],
                    "ic_processar_faturamento"=>$query[$i]['ic_processar_faturamento'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status']
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
        $query = $faturamentodao->listar_por_dt_faturamento_ini($dt_faturamento_ini);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_faturamento_ini"=>$query[$i]['dt_faturamento_ini'],
                    "t_dt_faturamento_fim"=>$query[$i]['dt_faturamento_fim'],
                    "t_ic_contrato_fixo"=>$query[$i]['ic_contrato_fixo'],
                    "t_ic_contrato_aditivo"=>$query[$i]['ic_contrato_aditivo'],
                    "t_ic_contrato_servico_extra"=>$query[$i]['ic_contrato_servico_extra'],
                    "t_ic_gerar_boleto"=>$query[$i]['ic_gerar_boleto'],
                    "t_ic_gerar_nota_fiscal"=>$query[$i]['ic_gerar_nota_fiscal'],
                    "t_ic_processar_faturamento"=>$query[$i]['ic_processar_faturamento'],
                    "t_obs"=>$query[$i]['obs'],
                    "t_n_emissoes"=>$query[$i]['n_emissoes'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_status"=>$query[$i]['ds_status'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }  
    case 'listarLancamentos':{        
        
        $resultado = "";
        $query = $faturamentodao->listarLancamentos($pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
  

                $lancamentos_pk = "";
                $dt_lancamento = "";
                $dt_faturamento = "";
                $dt_vencimento = "";
                $notas_pk = "";
                $vl_total_contrato = "";
                if(!empty($query[$i]["lancamentos_pk"])){
                    $lancamentos_pk = $query[$i]["lancamentos_pk"];
                    $notas_pk = "00006380";
                }
                if(!empty($query[$i]["dt_lancamento"])){                    
                    $dt_lancamento = $query[$i]["dt_lancamento"];                    
                }
                if(!empty($query[$i]["dt_faturamento"])){
                    $dt_faturamento = $query[$i]["dt_faturamento"];
                }
                if(!empty($query[$i]["dt_vencimento"])){
                    $dt_vencimento = $query[$i]["dt_vencimento"];
                }
                if(!empty($query[$i]["vl_total_contrato"])){
                    $vl_total_contrato = $query[$i]["vl_total_contrato"];
                }

                $mysql_data[] = array(
                    "ds_lead" => $query[$i]["ds_lead"],
                    "pk" => $query[$i]["contratos_pk"],
                    "lancamentos_pk" => $lancamentos_pk,
                    "tipo_contrato" => $query[$i]["tipo_contrato"],
                    "dt_lancamento" => $dt_lancamento,
                    "dt_faturamento" => $dt_faturamento,
                    "dt_vencimento" => $dt_vencimento,
                    "notas_pk" => $notas_pk,
                    "vl_total_contrato" => $vl_total_contrato
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }
    //CONTAS FATURAMENTO
    case 'excluirFaturamentoContas':{        
        $resultdo = "";        
        
        $faturamentodao->excluirFaturamentoContas($pk);            
        $result  = 'success';
        $message = 'Registro excluído com sucesso.';

        break;
    }
    case 'salvarFaturamentoContas':{        
        $resultdo = "";        
        
        $faturamento_pk = $_REQUEST['faturamento_pk'];
        $contas_pk = $_REQUEST['contas_pk'];
   
        $faturamentodao->salvarFaturamentoContas($faturamento_pk,$contas_pk);            
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';

        break;
    }


    case 'listarDadosFaturamento':{ 
                
        $resultado = "";
        $query = $faturamentodao->listarDadosFaturamento($pk);

        $result  = 'success';
        $message = 'query success';
       
        if(count($query) > 0){
            
            for($i = 0; $i < count($query); $i++){
            
                $mysql_data[] = array(
                    "pk"=>$query[$i]['pk'],
                    "ds_usuario_cadastro"=>$query[$i]['ds_usuario_cadastro'],
                    "ds_usuario_atualizacao"=>$query[$i]['ds_usuario_atualizacao'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "dt_ult_atualizacao"=>$query[$i]['dt_ult_atualizacao'],
                    "dt_faturamento_ini"=>$query[$i]['dt_faturamento_ini'],
                    "dt_faturamento_fim"=>$query[$i]['dt_faturamento_fim'],
                    "ds_usatus_faturamento"=>$query[$i]['ds_usatus_faturamento'], 
                    "ic_contrato_fixo"=>$query[$i]['ic_contrato_fixo'], 
                    "ic_contrato_aditivo"=>$query[$i]['ic_contrato_aditivo'],
                    "ic_contrato_servico_extra"=>$query[$i]['ic_contrato_servico_extra'],
                    "ic_gerar_fatura"=>$query[$i]['ic_gerar_fatura'],
                    "ic_gerar_boleto"=>$query[$i]['ic_gerar_boleto'],
                    "ic_gerar_nota_fiscal"=>$query[$i]['ic_gerar_nota_fiscal'],
                    "obs"=>$query[$i]['obs'],
                    "DadosContas"=>$query[$i]['DadosContas'],
                    "DadosContratos"=>$query[$i]['DadosContratos'],
                    "DadosContratosItens"=>$query[$i]['DadosContratosItens'],                    
                );
            }
        }else{
            $mysql_data = [];
        }	
        break;
    } 

    case 'listarUpdateFaturamento':{  
        $resultado = "";
        $query = $faturamentodao->listarUpdateFaturamento($pk);
   
        $result  = 'success';
        $message = 'query success';
       
        if(count($query) > 0){
            
            for($i = 0; $i < count($query); $i++){
            
                $mysql_data[] = array(
                    "pk"=>$query[$i]['pk'],
                    "ds_usuario_cadastro"=>$query[$i]['ds_usuario_cadastro'],
                    "ds_usuario_atualizacao"=>$query[$i]['ds_usuario_atualizacao'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "dt_ult_atualizacao"=>$query[$i]['dt_ult_atualizacao'],
                    "dt_faturamento_ini"=>$query[$i]['dt_faturamento_ini'],
                    "dt_faturamento_fim"=>$query[$i]['dt_faturamento_fim'],
                    "ds_usatus_faturamento"=>$query[$i]['ds_usatus_faturamento'], 
                    "ic_contrato_fixo"=>$query[$i]['ic_contrato_fixo'], 
                    "ic_contrato_aditivo"=>$query[$i]['ic_contrato_aditivo'],
                    "ic_contrato_servico_extra"=>$query[$i]['ic_contrato_servico_extra'],
                    "ic_gerar_fatura"=>$query[$i]['ic_gerar_fatura'],
                    "ic_gerar_boleto"=>$query[$i]['ic_gerar_boleto'],
                    "ic_gerar_nota_fiscal"=>$query[$i]['ic_gerar_nota_fiscal'],
                    "obs"=>$query[$i]['obs'],
                    "DadosContas"=>$query[$i]['DadosContas'],
                    "DadosContratos"=>$query[$i]['DadosContratos'],
                    "DadosContratosItens"=>$query[$i]['DadosContratosItens'],                    
                );
            }
        }else{
            $mysql_data = [];
        }
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
