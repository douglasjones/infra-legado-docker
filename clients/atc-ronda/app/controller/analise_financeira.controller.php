<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/analise_financeira.dao.php";
require_once "../model/analise_financeira.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$lancamentos_pk = $arrRequest['lancamentos_pk'];
$lancamentos_financeiros_pk = $arrRequest['lancamentos_financeiros_pk'];
$usuario_cadastro_lancamento_pk = $arrRequest['usuario_cadastro_lancamento_pk'];
$ic_status = $arrRequest['ic_status'];
$gestor_aprovacao_pk = $arrRequest['gestor_aprovacao_pk'];
$obs = $arrRequest['obs'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$dt_cadastro_ini = $arrRequest['dt_cadastro_ini'];
$dt_cadastro_fim = $arrRequest['dt_cadastro_fim'];
$dt_aprovacao_ini = $arrRequest['dt_aprovacao_ini'];
$dt_aprovacao_fim = $arrRequest['dt_aprovacao_fim'];
$dt_correcao_ini = $arrRequest['dt_correcao_ini'];
$dt_correcao_fim = $arrRequest['dt_correcao_fim'];
$dt_recusa_ini = $arrRequest['dt_recusa_ini'];
$dt_recusa_fim = $arrRequest['dt_recusa_fim'];
$usuario_cadastro_lancamento_pk = $arrRequest['usuario_cadastro_lancamento_pk'];
$usuario_cadastro_pk = $arrRequest['usuario_cadastro_pk'];
$usuario_cadastro_analista_pk = $arrRequest['usuario_cadastro_analista_pk'];
$usuario_cadastro_gestor_pk = $arrRequest['usuario_cadastro_gestor_pk'];

$analise_financeiradao = new analise_financeiradao();
$analise_financeiradao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $analise_financeira = $analise_financeiradao->carregarPorPk($pk);
        if($analise_financeira->getpk()>0){
            
            $analise_financeiradao->excluir($analise_financeira);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'analise_financeira nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $analise_financeira = $analise_financeiradao->carregarPorPk($pk);
        $analise_financeira->setlancamentos_pk($lancamentos_pk);
        $analise_financeira->setlancamentos_financeiros_pk($lancamentos_financeiros_pk);
        $analise_financeira->setusuario_cadastro_lancamento_pk($usuario_cadastro_lancamento_pk);
        $analise_financeira->setic_status($ic_status);
        $analise_financeira->setgestor_aprovacao_pk($gestor_aprovacao_pk);
        $analise_financeira->setobs($obs);
        $analise_financeira->setdt_cancelamento($dt_cancelamento);

        
        $pk = $analise_financeiradao->salvar($analise_financeira);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $analise_financeiradao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "lancamento_pk" => $query[0]["lancamentos_pk"],
                    "ds_agencia"=>$query[0]["ds_agencia"],
                    "ds_conta"=>$query[0]["ds_conta"],
                    "ds_digito"=>$query[0]["ds_digito"],
                    "ds_banco"=>$query[0]["ds_banco"],
                    "dt_vencimento"=>$query[0]['dt_vencimento'],
                    "ds_usuario_cadastro"=>$query[0]['ds_usuario_cadastro'],
                    "dt_cadastro"=>$query[0]['dt_cadastro'],
                    "vl_inicial_conta"=>$query[0]['vl_inicial_conta'],
                    "dt_pagamento"=>$query[0]['dt_pagamento'],
                    "vl_saldo"=>$query[0]["vl_saldo"],
                    "ds_lancamento"=>$query[0]['ds_lancamento'],
                    "vl_lancamento"=>$query[0]['vl_lancamento'],
                    "operacao_pk"=>$query[0]['operacao_pk'],
                    "ds_operacao"=>$query[0]['ds_operacao'],
                    "ds_tipo_operacao"=>$query[0]['ds_tipo_operacao'],
                    "tipo_grupo_pk"=>$query[0]['tipo_grupo_pk'],
                    "ds_tipo_grupo"=>$query[0]['ds_tipo_grupo'],
                    "ds_tipo_grupo_centro_custo"=>$query[0]['ds_tipo_grupo_centro_custo'],
                    "grupo_leancamento_pk"=>$query[0]['grupo_leancamento_pk'],
                    "ic_status_pagamento"=>$query[0]['ic_status_pagamento'],
                    "ds_status_pagamento"=>$query[0]['ds_status_pagamento'],
                    "obs_lancamento"=>$query[0]['obs_lancamento'],
                    "dt_competencia"=>$query[0]['dt_competencia'],
                    "parcela_pk"=>$query[0]['parcela_pk'],
                    "n_documento"=>$query[0]['n_documento'],
                    "contas_bancarias_pk"=>$query[0]['contas_bancarias_pk'],
                    "tipos_operacao_pk"=>$query[0]['tipos_operacao_pk'],
                    "metodos_pagamento_pk"=>$query[0]['metodos_pagamento_pk'],
                    "ds_metodo_pagamento"=>$query[0]['ds_metodo_pagamento'],
                    "ds_conta_bancaria"=>$query[0]['ds_conta_bancaria'],
                    "ds_tipo_operacao"=>$query[0]['ds_tipo_operacao'],
                    "empresas_pk"=>$query[0]['empresas_pk'],
                    "ds_razao_social"=>$query[0]['ds_razao_social'],
                    "ds_dados_conta"=>$query[0]['ds_dados_conta'],
                    "ds_pix"=>$query[0]["ds_pix"],
                    "ds_favorecido_pix"=>$query[0]["ds_favorecido_pix"],
                    "tipo_grupo_centro_custo_pk"=>$query[0]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centro_custo_pk"=>$query[0]['grupo_lancamento_centro_custo_pk'],
                    "ds_ocorrencia"=>$query[0]['ds_ocorrencia'],
                    "dt_pagamento"=>$query[0]['dt_pagamento'],
                    "contratos_pk"=>$query[0]['contratos_pk'],
                    "ds_usuario"=>$query[0]['ds_usuario'],
                    "dt_faturamento"=>$query[0]['dt_faturamento'],
                    "ds_recebido_de"=>$query[0]["ds_recebido_de"],
                    "ds_recebido_de_centro_custo"=>$query[0]["ds_recebido_de_centro_custo"],
                    "ds_cliente"=>$query[0]['ds_cliente'],
                    "ds_lancamento_posto_trabalho"=>$query[0]["ds_lancamento_posto_trabalho"],  
                    "obs"=>$query[0]['obs'],    
                    "ds_lancamento_contrato"=>$query[0]["ds_lancamento_contrato"]
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
        $query = $analise_financeiradao->listar_por_lancamentos_pk($lancamentos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "lancamentos_pk"=>$query[$i]['lancamentos_pk'],
                    "lancamentos_financeiros_pk"=>$query[$i]['lancamentos_financeiros_pk'],
                    "usuario_cadastro_lancamento_pk"=>$query[$i]['usuario_cadastro_lancamento_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "gestor_aprovacao_pk"=>$query[$i]['gestor_aprovacao_pk'],
                    "obs"=>$query[$i]['obs'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento']
                );
            }
        }
        else{
            $mysql_data = [];
        }
        
        break;
    }
    case 'listarDataTable':{
        $dt_vencimento_ini = $_REQUEST['dt_vencimento_ini'];
        $dt_vencimento_fim = $_REQUEST['dt_vencimento_fim'];
        


        $resultado = "";
        $query = $analise_financeiradao->listar_por_lancamentos_pk($ic_status, $lancamento_pk, $dt_cadastro_ini, $dt_cadastro_fim, $dt_aprovacao_ini, $dt_aprovacao_fim, $dt_correcao_ini, $dt_correcao_fim, $dt_recusa_ini, $dt_recusa_fim, $usuario_cadastro_lancamento_pk, $usuario_cadastro_gestor_pk, $usuario_cadastro_analista_pk,$dt_vencimento_ini,$dt_vencimento_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_lancamentos_pk"=>$query[$i]['lancamentos_pk'],
                    "t_lancamentos_financeiros_pk"=>$query[$i]['lancamentos_financeiros_pk'],
                    "t_usuario_cadastro_lancamento_pk"=>$query[$i]['ds_usuario_cadastro_lancamento'],
                    "t_dt_lancamento"=>$query[$i]['dt_cadastro_financeiro'],
                    "t_ic_status"=>$query[$i]['ds_status'],
                    "t_gestor_aprovacao_pk"=>$query[$i]['gestor_aprovacao_pk'],
                    "t_dt_recusa"=>$query[$i]['dt_recusa'],
                    "t_dt_aprovacao"=>$query[$i]['dt_aprovacao'],
                    "t_dt_correcao"=>$query[$i]['dt_correcao'],
                    "t_obs"=>$query[$i]['obs'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],

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

$analise_financeiradao = null;

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
