<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";

require_once "../model/financeiro_conciliacao_banco.dao.php";
require_once "../model/financeiro_conciliacao_banco.class.php";

require_once "../model/financeiro_import_lancamentos.dao.php";
require_once "../model/financeiro_import_lancamentos.class.php";

require_once "../model/financeiro_import_lancamento_itens.dao.php";


$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_link_arquivo = $arrRequest['ds_link_arquivo'];
$vl_saldo_conta = $arrRequest['vl_saldo_conta'];
$dt_ini_periodo_saldo = $arrRequest['dt_ini_periodo_saldo'];
$dt_fim_periodo_saldo = $arrRequest['dt_fim_periodo_saldo'];
$ds_obs = $arrRequest['obs'];
$ic_status = $arrRequest['ic_status'];
$contas_bancarias_pk = $arrRequest['contas_pk'];
$empresas_pk = $arrRequest['empresas_pk'];


$financeiro_conciliacao_bancodao = new financeiro_conciliacao_bancodao();
$financeiro_conciliacao_bancodao->setToken($token); 


$financeiro_import_lancamento_itensdao = new financeiro_import_lancamento_itensdao();
$financeiro_import_lancamento_itensdao->setToken($token); 


$financeiro_import_lancamentosdao = new financeiro_import_lancamentosdao();
$financeiro_import_lancamentosdao->setToken($token); 



switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $financeiro_conciliacao_banco = $financeiro_conciliacao_bancodao->carregarPorPk($pk);
        if($financeiro_conciliacao_banco->getpk()>0){
            
            $financeiro_conciliacao_bancodao->excluir($financeiro_conciliacao_banco);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'financeiro_conciliacao_banco nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
            if($_FILES[0]['type'] != "application/octet-stream"){
                $mysql_data[] = array(
                    "pk" => 0
                );
              
                $result  = 'error';
                $message = 'Arquivo precisa ser do tipo .OFX .';    
                break;
            }           
            
            $name = $_FILES[0]['name'];
            
            
            $arrDados = $financeiro_import_lancamentosdao->abrirArquivoOfx($_FILES[0]);
           
            //PEGANDO ARRAY E JOGANDO NAS VARIAVEIS.
            $vl_saldo_conta = $arrDados['saldoConta'];
            $dt_ini_periodo_saldo = $arrDados['dtPeriodoInicio'];
            $dt_fim_periodo_saldo = $arrDados['dtPeriodoFim'];
            $ds_link_arquivo = '../docs/arquivoImportLancamento/'.$name;
           
            $financeiro_conciliacao_banco = $financeiro_conciliacao_bancodao->carregarPorPk($pk);
            $financeiro_conciliacao_banco->setds_link_arquivo($ds_link_arquivo);
            $financeiro_conciliacao_banco->setvl_saldo_conta($vl_saldo_conta);
           
            $financeiro_conciliacao_banco->setdt_ini_periodo_saldo($dt_ini_periodo_saldo);
            
            $financeiro_conciliacao_banco->setdt_fim_periodo_saldo($dt_fim_periodo_saldo);
            
            $financeiro_conciliacao_banco->setds_obs($ds_obs);
            $financeiro_conciliacao_banco->setic_status(1);
            $financeiro_conciliacao_banco->setcontas_bancarias_pk($contas_bancarias_pk);
            $financeiro_conciliacao_banco->setempresas_pk($empresas_pk);
            
            if($pk==""){
                //SALVANDO DADOS BANCARIOS
                $pk = $financeiro_conciliacao_bancodao->salvar($financeiro_conciliacao_banco);

                
                //SALVAR EXTRATO POR ITEM
                foreach($arrDados['arrExtratoItens'] as $v){
                    if(floatval($v['valor']) < 0){
                        //CRÉDITO
                        $ic_tipo_transacao = 1;
                    }
                    else{
                        //DEBITO
                        $ic_tipo_transacao = 2;
                    }
                    
                    $desctipoTransacao = $v['tipoTransacao'];
                    $dataTransacao = $v['dtTransacao'];
                    
                    $valor = str_replace("-","",$v['valor']);
                    $estabelecimento = $v['nomeEstabelecimento'];
                    $cod_verificacao_transacao = $v['codTransacao'];
                    
                    $financeiro_import_lancamento_itens =[
                        "ic_tipo_transacao"=>$ic_tipo_transacao,
                        "dt_transacao"=>$dataTransacao,
                        "vl_transacao"=>$valor,
                        "cod_verificacao_transacao"=>$cod_verificacao_transacao,
                        "ds_estabelecimento" =>$estabelecimento,
                        "financeiro_conciliacao_banco_pk"=>$pk
                    ];
                    $financeiro_import_lancamento_itensdao->salvar($financeiro_import_lancamento_itens);
                }
            }
            else{
                //SALVANDO DADOS BANCARIOS
                $pk = $financeiro_conciliacao_bancodao->salvar($financeiro_conciliacao_banco);
            }

        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $financeiro_conciliacao_bancodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "vl_saldo_conta"=>$query[$i]['vl_saldo_conta'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "dt_ini_periodo_saldo"=>$query[$i]['dt_ini_periodo_saldo'],
                    "dt_fim_periodo_saldo"=>$query[$i]['dt_fim_periodo_saldo']
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
        $query = $financeiro_conciliacao_bancodao->listar_por_ds_link_arquivo($ds_link_arquivo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_link_arquivo"=>$query[$i]['ds_link_arquivo'],
                    "vl_saldo_conta"=>$query[$i]['vl_saldo_conta'],
                    "dt_ini_periodo_saldo"=>$query[$i]['dt_ini_periodo_saldo'],
                    "dt_fim_periodo_saldo"=>$query[$i]['dt_fim_periodo_saldo'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk']
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
        $query = $financeiro_conciliacao_bancodao->listarDataTable();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_conta"=>$query[$i]['ds_conta'],
                    "t_ds_banco"=>$query[$i]['ds_banco'],
                    "t_ds_agencia"=>$query[$i]['ds_agencia'],
                    "t_ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "t_dt_periodo_saldo"=>$query[$i]['dt_ini_periodo_saldo']." - ".$query[$i]['dt_fim_periodo_saldo'],

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

$financeiro_conciliacao_bancodao = null;

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
