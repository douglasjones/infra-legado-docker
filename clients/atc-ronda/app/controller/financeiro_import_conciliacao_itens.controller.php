<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/financeiro_import_conciliacao_itens.dao.php";
require_once "../model/financeiro_import_conciliacao_itens.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$dt_vencimento = $arrRequest['dt_vencimento'];
$ds_lancamento = $arrRequest['ds_lancamento'];
$vl_lancamento = $arrRequest['vl_lancamento'];
$operacao_pk = $arrRequest['operacao_pk'];
$tipo_grupo_pk = $arrRequest['tipo_grupo_pk'];
$grupo_leancamento_pk = $arrRequest['grupo_leancamento_pk'];
$ic_status_pagamento = $arrRequest['ic_status_pagamento'];
$obs_lancamento = $arrRequest['obs_lancamento'];
$dt_competencia = $arrRequest['dt_competencia'];
$n_documento = $arrRequest['n_documento'];
$tipos_operacao_pk = $arrRequest['tipos_operacao_pk'];
$metodos_pagamento_pk = $arrRequest['metodos_pagamento_pk'];
$usuario_ult_atualizacao_pk = $arrRequest['usuario_ult_atualizacao_pk'];
$contas_bancarias_pk = $arrRequest['contas_bancarias_pk'];
$empresas_pk = $arrRequest['empresas_pk'];
$tipo_grupo_centro_custo_pk = $arrRequest['tipo_grupo_centro_custo_pk'];
$grupo_lancamento_centro_custo_pk = $arrRequest['grupo_lancamento_centro_custo_pk'];
$ds_ocorrencia = $arrRequest['ds_ocorrencia'];
$dt_pagamento = $arrRequest['dt_pagamento'];
$contratos_pk = $arrRequest['contratos_pk'];
$compras_pk = $arrRequest['compras_pk'];
$dt_faturamento = $arrRequest['dt_faturamento'];
$categoria_operacao_pk = $arrRequest['categoria_operacao_pk'];
$leads_clientes_pk = $arrRequest['leads_clientes_pk'];
$leads_posto_trabalho_pk = $arrRequest['leads_posto_trabalho_pk'];
$colaborador_posto_trabalho_pk = $arrRequest['colaborador_posto_trabalho_pk'];
$colaborador_contratos_pk = $arrRequest['colaborador_contratos_pk'];
$fornecedor_posto_trabalho_pk = $arrRequest['fornecedor_posto_trabalho_pk'];
$fornecedor_contratos_pk = $arrRequest['fornecedor_contratos_pk'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$fornecedor_pk = $arrRequest['fornecedor_pk'];
$parcela_pk = $arrRequest['parcela_pk'];
$teto_gastros_pk = $arrRequest['teto_gastros_pk'];
$teto_gastos_itens_pk = $arrRequest['teto_gastos_itens_pk'];
$ic_status_processamento = $arrRequest['ic_status_processamento'];
$financeiro_import_lancamentos_pk = $arrRequest['financeiro_import_lancamentos_pk'];
$lancamentos_pk = $arrRequest['lancamentos_pk'];
$ds_arquivo = $arrRequest['ds_arquivo'];


$financeiro_import_conciliacao_itensdao = new financeiro_import_conciliacao_itensdao();
$financeiro_import_conciliacao_itensdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $financeiro_import_lancamento_itens = $financeiro_import_lancamento_itensdao->carregarPorPk($pk);
        if($financeiro_import_lancamento_itens->getpk()>0){
            
            $financeiro_import_lancamento_itensdao->excluir($financeiro_import_lancamento_itens);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'financeiro_import_lancamento_itens nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $financeiro_import_lancamento_itens = $financeiro_import_lancamento_itensdao->carregarPorPk($pk);
        $financeiro_import_lancamento_itens->setfinanceiro_import_lancamentos_pk($financeiro_import_lancamentos_pk);
        $financeiro_import_lancamento_itens->setlancamentos_pk($lancamentos_pk);

        $pk = $financeiro_import_lancamento_itensdao->salvar($financeiro_import_lancamento_itens, $ds_arquivo, $token);
        
        $mysql_data[] = array(
            "pk" => $pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $financeiro_import_lancamento_itensdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "ds_lancamento"=>$query[$i]['ds_lancamento'],
                    "vl_lancamento"=>$query[$i]['vl_lancamento'],
                    "operacao_pk"=>$query[$i]['operacao_pk'],
                    "tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "ic_status_pagamento"=>$query[$i]['ic_status_pagamento'],
                    "obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "dt_competencia"=>$query[$i]['dt_competencia'],
                    "n_documento"=>$query[$i]['n_documento'],
                    "tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "usuario_ult_atualizacao_pk"=>$query[$i]['usuario_ult_atualizacao_pk'],
                    "contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "compras_pk"=>$query[$i]['compras_pk'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "categoria_operacao_pk"=>$query[$i]['categoria_operacao_pk'],
                    "leads_clientes_pk"=>$query[$i]['leads_clientes_pk'],
                    "leads_posto_trabalho_pk"=>$query[$i]['leads_posto_trabalho_pk'],
                    "colaborador_posto_trabalho_pk"=>$query[$i]['colaborador_posto_trabalho_pk'],
                    "colaborador_contratos_pk"=>$query[$i]['colaborador_contratos_pk'],
                    "fornecedor_posto_trabalho_pk"=>$query[$i]['fornecedor_posto_trabalho_pk'],
                    "fornecedor_contratos_pk"=>$query[$i]['fornecedor_contratos_pk'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "fornecedor_pk"=>$query[$i]['fornecedor_pk'],
                    "parcela_pk"=>$query[$i]['parcela_pk'],
                    "teto_gastros_pk"=>$query[$i]['teto_gastros_pk'],
                    "teto_gastos_itens_pk"=>$query[$i]['teto_gastos_itens_pk'],
                    "ic_status_processamento"=>$query[$i]['ic_status_processamento'],
                    "financeiro_import_lancamentos_pk"=>$query[$i]['financeiro_import_lancamentos_pk'],
                    "lancamentos_pk"=>$query[$i]['lancamentos_pk']
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
        $query = $financeiro_import_lancamento_itensdao->listar_por_dt_vencimento($dt_vencimento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "ds_lancamento"=>$query[$i]['ds_lancamento'],
                    "vl_lancamento"=>$query[$i]['vl_lancamento'],
                    "operacao_pk"=>$query[$i]['operacao_pk'],
                    "tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "ic_status_pagamento"=>$query[$i]['ic_status_pagamento'],
                    "obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "dt_competencia"=>$query[$i]['dt_competencia'],
                    "n_documento"=>$query[$i]['n_documento'],
                    "tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "usuario_ult_atualizacao_pk"=>$query[$i]['usuario_ult_atualizacao_pk'],
                    "contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "compras_pk"=>$query[$i]['compras_pk'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "categoria_operacao_pk"=>$query[$i]['categoria_operacao_pk'],
                    "leads_clientes_pk"=>$query[$i]['leads_clientes_pk'],
                    "leads_posto_trabalho_pk"=>$query[$i]['leads_posto_trabalho_pk'],
                    "colaborador_posto_trabalho_pk"=>$query[$i]['colaborador_posto_trabalho_pk'],
                    "colaborador_contratos_pk"=>$query[$i]['colaborador_contratos_pk'],
                    "fornecedor_posto_trabalho_pk"=>$query[$i]['fornecedor_posto_trabalho_pk'],
                    "fornecedor_contratos_pk"=>$query[$i]['fornecedor_contratos_pk'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "fornecedor_pk"=>$query[$i]['fornecedor_pk'],
                    "parcela_pk"=>$query[$i]['parcela_pk'],
                    "teto_gastros_pk"=>$query[$i]['teto_gastros_pk'],
                    "teto_gastos_itens_pk"=>$query[$i]['teto_gastos_itens_pk'],
                    "ic_status_processamento"=>$query[$i]['ic_status_processamento'],
                    "financeiro_import_lancamentos_pk"=>$query[$i]['financeiro_import_lancamentos_pk'],
                    "lancamentos_pk"=>$query[$i]['lancamentos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        
        $financeiro_conciliacao_banco_pk = $_REQUEST['financeiro_conciliacao_banco_pk'];
        
        $resultado = "";
        $query = $financeiro_import_conciliacao_itensdao->listarDataTable($financeiro_conciliacao_banco_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_transacao"=>$query[$i]['dt_transacao'],
                    "t_ds_transacao"=>$query[$i]['ds_transacao'],
                    "t_vl_transacao"=>"R$ ".number_format($query[$i]['vl_transacao'], 2, ',', '.'),
                    "t_ic_tipo_transacao"=>$query[$i]['ic_tipo_transacao'],
                    "t_cod_verificacao_transacao"=>$query[$i]['cod_verificacao_transacao'],
                    "t_ds_estabelecimento"=>$query[$i]['ds_estabelecimento'],
                    "t_lancamentos_pk" =>$query[$i]['lancamentos_pk'],
                    "t_ic_status" =>$query[$i]['ic_status_fl'],
                    "t_obs" =>$query[$i]['obs_fl'],
                    "t_financeiro_conciliacao_lancamentos_pk"=>$query[$i]['financeiro_conciliacao_lancamentos_pk'],
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

$financeiro_import_lancamento_itensdao = null;

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
