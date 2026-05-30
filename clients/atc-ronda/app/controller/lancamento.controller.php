<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/lancamento.dao.php";
require_once "../model/lancamento.class.php";

require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";

require_once "../model/conta_bancaria.dao.php";
require_once "../model/conta_bancaria.class.php";

require_once "../model/produto_servico.dao.php";
require_once "../model/produto_servico.class.php";

require_once "../model/analise_financeira.dao.php";
require_once "../model/analise_financeira.class.php";

require_once "../model/documento.dao.php";

include_once "../model/conta.dao.php";
include_once "../model/conta.class.php";


$arrRequest = tratar_request();
$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_lancamento = $arrRequest['ds_lancamento'];
$operacao_pk = $arrRequest['operacao_pk'];
$categoria_operacao_pk = $arrRequest['categoria_operacao_pk'];
$tipos_operacao_pk = $arrRequest['tipos_operacao_pk'];
$tipo_grupo_pk = $arrRequest['tipo_grupo_pk'];
$grupo_leancamento_pk = $arrRequest['grupo_leancamento_pk'];
$leads_clientes_pk = $arrRequest['leads_clientes_pk'];
$leads_posto_trabalho_pk = $arrRequest['leads_posto_trabalho_pk'];
$contratos_pk = $arrRequest['contratos_pk'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$colaborador_posto_trabalho_pk = $arrRequest['colaborador_posto_trabalho_pk'];
$colaborador_contratos_pk = $arrRequest['colaborador_contratos_pk'];
$fornecedor_pk = $arrRequest['fornecedor_pk'];
$fornecedor_posto_trabalho_pk = $arrRequest['fornecedor_posto_trabalho_pk'];
$fornecedor_contratos_pk = $arrRequest['fornecedor_contratos_pk'];
$tipo_grupo_centro_custo_pk = $arrRequest['tipo_grupo_centro_custo_pk'];
$grupo_lancamento_centro_custo_pk = $arrRequest['grupo_lancamento_centro_custo_pk'];
$dt_faturamento = $arrRequest['dt_faturamento'];
$dt_vencimento = $arrRequest['dt_vencimento'];
$vl_lancamento = $arrRequest['vl_lancamento'];
$metodos_pagamento_pk = $arrRequest['metodos_pagamento_pk'];
$empresas_pk = $arrRequest['empresas_pk'];
$contas_bancarias_pk = $arrRequest['contas_bancarias_pk'];
$ic_status_pagamento = $arrRequest['ic_status_pagamento'];
$dt_pagamento = $arrRequest['dt_pagamento'];
$obs_lancamento = $arrRequest['obs_lancamento'];
$n_documento = $arrRequest['n_documento'];
$parcela_pk = $arrRequest['parcela_pk'];
$usuario_cadastro_pk = $arrRequest['usuario_cadastro_pk'];
$dt_cadastro_ini = $arrRequest['dt_cadastro_ini'];
$dt_cadastro_fim = $arrRequest['dt_cadastro_fim'];      
$dt_faturamento_ini = $arrRequest['dt_faturamento_ini'];
$dt_faturamento_fim = $arrRequest['dt_faturamento_fim'];
$dt_vencimento_ini = $arrRequest['dt_vencimento_ini'];
$dt_vencimento_fim = $arrRequest['dt_vencimento_fim'];          
$dt_pagamento_ini = $arrRequest['dt_pagamento_ini'];
$dt_pagamento_fim = $arrRequest['dt_pagamento_fim'];
$grupo_leancamento_pk = $arrRequest['grupo_lancamento_pk'];
$ic_status_analise = $arrRequest['ic_status_analise'];
$ds_num_documento = $arrRequest['ds_num_documento'];
$ic_tipo_num_documento = $arrRequest['ic_tipo_num_documento'];
$doc_lancamento = $arrRequest['doc_lancamento'];

/*$dt_vencimento = $arrRequest['dt_vencimento'];
$ds_lancamento = $arrRequest['ds_lancamento'];
$vl_lancamento = $arrRequest['vl_lancamento'];
$operacao_pk = $arrRequest['operacao_pk'];
$tipo_grupo_pk = $arrRequest['tipo_grupo_pk'];

$ic_status_pagamento = $arrRequest['ic_status_pagamento'];
$obs_lancamento = $arrRequest['obs_lancamento'];
$dt_competencia = $arrRequest['dt_competencia'];

$contas_bancarias_pk = $arrRequest['contas_bancarias_pk'];
$tipos_operacao_pk = $arrRequest['tipos_operacao_pk'];
$metodos_pagamento_pk = $arrRequest['metodos_pagamento_pk'];
$dt_pagamento = $arrRequest['dt_pagamento'];
$empresas_pk = $arrRequest['empresas_pk'];
$ds_ocorrencia = $arrRequest['ds_ocorrencia'];

$contratos_pk = $arrRequest['contratos_pk'];
$dt_faturamento = $arrRequest['dt_faturamento'];*/


$lancamentodao = new lancamentodao();
$lancamentodao->setToken($token);

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

$conta_bancariadao = new conta_bancariadao();
$conta_bancariadao->setToken($token); 

$produto_servicodao = new produto_servicodao();
$produto_servicodao->setToken($token); 

$analise_financeiradao = new analise_financeiradao();
$analise_financeiradao->setToken($token); 

$contadao = new contadao();
$contadao->setToken($token); 


switch($job){
    case 'excluir':{
        
        $resultdo = "";
        
        $lancamento = $lancamentodao->carregarPorPk($pk);
        if($lancamento->getpk()>0){
            
            
            $pk_documentos = $lancamentodao->listarPkDocumentos($lancamento->getpk());
            
            if(count($pk_documentos)>0){
                for($i=0;$i<count($pk_documentos);$i++){
                    $log_exclusaodao->salvar("documentos", $pk_documentos[$i]['pk']);
                }
            }


            $log_exclusaodao->salvar("lancamentos",$lancamento->getpk());
            
            $lancamentodao->excluirDocsLancamento($lancamento->getpk());
            $lancamentodao->excluir($lancamento);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'lancamento nao encontrado';
        }
        break;
    }
    case 'salvar':{   

        $lancamento = $lancamentodao->carregarPorPk($pk);
    
        /*$lancamento->setds_lancamento($ds_lancamento);
        $lancamento->setoperacao_pk($operacao_pk);
        $lancamento->setcategoria_operacao_pk($categoria_operacao_pk);
        $lancamento->settipos_operacao_pk($tipos_operacao_pk);
        $lancamento->settipo_grupo_pk($tipo_grupo_pk);
        $lancamento->setgrupo_leancamento_pk($grupo_leancamento_pk);
        $lancamento->setleads_clientes_pk($leads_clientes_pk);
        $lancamento->setleads_posto_trabalho_pk($leads_posto_trabalho_pk);
        $lancamento->setcontratos_pk($contratos_pk);
        $lancamento->setcolaborador_pk($colaborador_pk);
        $lancamento->setcolaborador_posto_trabalho_pk($colaborador_posto_trabalho_pk);
        $lancamento->setcolaborador_contratos_pk($colaborador_contratos_pk);        
        $lancamento->setfornecedor_pk($fornecedor_pk);
        $lancamento->setfornecedor_posto_trabalho_pk($fornecedor_posto_trabalho_pk);
        $lancamento->setfornecedor_contratos_pk($fornecedor_contratos_pk);
        $lancamento->settipo_grupo_centro_custo_pk ($tipo_grupo_centro_custo_pk);
        $lancamento->setgrupo_lancamento_centro_custo_pk ($grupo_lancamento_centro_custo_pk);
        $lancamento->setdt_faturamento($dt_faturamento);
        $lancamento->setdt_vencimento($dt_vencimento);
        $lancamento->setvl_lancamento($vl_lancamento);
        $lancamento->setmetodos_pagamento_pk($metodos_pagamento_pk);
        $lancamento->setempresas_pk($empresas_pk);
        $lancamento->setcontas_bancarias_pk($contas_bancarias_pk);
        $lancamento->setic_status_pagamento($ic_status_pagamento);
        $lancamento->setdt_pagamento($dt_pagamento);
        $lancamento->setobs_lancamento($obs_lancamento);
        $lancamento->setds_num_documento($ds_num_documento);
        $lancamento->setic_tipo_num_documento($ic_tipo_num_documento);*/

        $lancamento->setds_lancamento($ds_lancamento);
        $lancamento->setoperacao_pk($operacao_pk);
        $lancamento->setcategoria_operacao_pk($categoria_operacao_pk);
        $lancamento->settipos_operacao_pk($tipos_operacao_pk);
        $lancamento->settipo_grupo_pk($tipo_grupo_pk);
        $lancamento->setgrupo_leancamento_pk($grupo_leancamento_pk);
        $lancamento->setleads_clientes_pk($leads_clientes_pk);
        $lancamento->setleads_posto_trabalho_pk($leads_posto_trabalho_pk);
        $lancamento->setcontratos_pk($contratos_pk);
        $lancamento->setcolaborador_pk($colaborador_pk);
        $lancamento->setparcela_pk($parcela_pk);
        $lancamento->setcolaborador_posto_trabalho_pk($colaborador_posto_trabalho_pk);
        $lancamento->setcolaborador_contratos_pk($colaborador_contratos_pk);        
        $lancamento->setfornecedor_pk($fornecedor_pk);
        $lancamento->setfornecedor_posto_trabalho_pk($fornecedor_posto_trabalho_pk);
        $lancamento->setfornecedor_contratos_pk($fornecedor_contratos_pk);
        $lancamento->settipo_grupo_centro_custo_pk ($tipo_grupo_centro_custo_pk);
        $lancamento->setgrupo_lancamento_centro_custo_pk ($grupo_lancamento_centro_custo_pk);
        $lancamento->setdt_faturamento($dt_faturamento);
        $lancamento->setdt_vencimento($dt_vencimento);
        $lancamento->setvl_lancamento($vl_lancamento);
        $lancamento->setmetodos_pagamento_pk($metodos_pagamento_pk);
        $lancamento->setempresas_pk($empresas_pk);
        $lancamento->setcontas_bancarias_pk($contas_bancarias_pk);
        $lancamento->setic_status_pagamento($ic_status_pagamento);
        $lancamento->setdt_pagamento($dt_pagamento);
        $lancamento->setobs_lancamento($obs_lancamento);
        $lancamento->setds_num_documento($ds_num_documento);
        $lancamento->setic_tipo_num_documento($ic_tipo_num_documento);


        $pk = $lancamentodao->salvar($lancamento, $doc_lancamento, $token);

        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }

    case 'salvarPorParcelas':{
        $dadosPorParcelas = $_REQUEST['dadosPorParcelas'];
       // var_dump($dadosPorParcelas);
        $dadosPorParcelas = json_decode($dadosPorParcelas, true);
        $parcela_pk = count($dadosPorParcelas);
        
        for($i = 0; $i < $parcela_pk; $i ++){

            $lancamento = $lancamentodao->carregarPorPk($dadosPorParcelas[$i]['pk']);
            $lancamento->setds_lancamento($dadosPorParcelas[$i]['ds_lancamento']);
            $lancamento->setoperacao_pk($dadosPorParcelas[$i]['operacao_pk']);
            $lancamento->setcategoria_operacao_pk($dadosPorParcelas[$i]['categoria_operacao_pk']);
            $lancamento->settipos_operacao_pk($dadosPorParcelas[$i]['tipos_operacao_pk']);
            $lancamento->settipo_grupo_pk($dadosPorParcelas[$i]['tipo_grupo_pk']);
            $lancamento->setgrupo_leancamento_pk($dadosPorParcelas[$i]['grupo_leancamento_pk']);
            $lancamento->setleads_clientes_pk($dadosPorParcelas[$i]['leads_clientes_pk']);
            $lancamento->setleads_posto_trabalho_pk($dadosPorParcelas[$i]['leads_posto_trabalho_pk']);
            $lancamento->setcontratos_pk($dadosPorParcelas[$i]['contratos_pk']);
            $lancamento->setcolaborador_pk($dadosPorParcelas[$i]['colaborador_pk']);
            $lancamento->setparcela_pk($dadosPorParcelas[$i]['parcela_pk']);
            $lancamento->setcolaborador_posto_trabalho_pk($dadosPorParcelas[$i]['colaborador_posto_trabalho_pk']);
            $lancamento->setcolaborador_contratos_pk($dadosPorParcelas[$i]['colaborador_contratos_pk']);        
            $lancamento->setfornecedor_pk($dadosPorParcelas[$i]['fornecedor_pk']);
            $lancamento->setfornecedor_posto_trabalho_pk($dadosPorParcelas[$i]['fornecedor_posto_trabalho_pk']);
            $lancamento->setfornecedor_contratos_pk($dadosPorParcelas[$i]['fornecedor_contratos_pk']);
            $lancamento->settipo_grupo_centro_custo_pk ($dadosPorParcelas[$i]['tipo_grupo_centro_custo_pk']);
            $lancamento->setgrupo_lancamento_centro_custo_pk ($dadosPorParcelas[$i]['grupo_lancamento_centro_custo_pk']);
            $lancamento->setdt_faturamento($dadosPorParcelas[$i]['dt_faturamento']);
            $lancamento->setdt_vencimento($dadosPorParcelas[$i]['dt_vencimento']);
            $lancamento->setvl_lancamento($dadosPorParcelas[$i]['vl_lancamento']);
            $lancamento->setmetodos_pagamento_pk($dadosPorParcelas[$i]['metodos_pagamento_pk']);
            $lancamento->setempresas_pk($dadosPorParcelas[$i]['empresas_pk']);
            $lancamento->setcontas_bancarias_pk($dadosPorParcelas[$i]['contas_bancarias_pk']);
            $lancamento->setic_status_pagamento($dadosPorParcelas[$i]['ic_status_pagamento']);
            $lancamento->setdt_pagamento($dadosPorParcelas[$i]['dt_pagamento']);
            $lancamento->setobs_lancamento($dadosPorParcelas[$i]['obs_lancamento']);
            $lancamento->setds_num_documento($dadosPorParcelas[$i]['ds_num_documento']);
            $lancamento->setic_tipo_num_documento($dadosPorParcelas[$i]['ic_tipo_num_documento']);
            //salva o lancamento
            $pk = $lancamentodao->salvar($lancamento, $dadosPorParcelas[0]['doc_lancamento'], $token);

 

          
        }

        $mysql_data[] = array(
            "pk" => $pk
        );
    
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    
    case 'listarExtratoMes':{

        $_ds_mes = $_REQUEST['ds_mes'];
        $_ds_ano = $_REQUEST['ds_ano'];
        
        //Verifica o saldo inicial da conta
        $queryValorInicial = $conta_bancariadao->listarValorInicial($empresas_pk,$contas_bancarias_pk);
        $vl_vl_saldo_inicial = "";        
        if(count($queryValorInicial) > 0){
            $vl_vl_saldo_inicial = $queryValorInicial[0]['vl_saldo_inicial'];
            $ds_mes_anterior = intval($_ds_mes) - 1;
            if($ds_mes_anterior == 1){
                $ds_mes_anterior = 12;
            }


            //verifico o primeiro mes de lancamento
            $queryPriLancamento = $lancamentodao->listaPrimeiroLancamento($empresas_pk,$contas_bancarias_pk);
            $mes_pri_vencimento = "";
            $ano_pri_vencimento = "";
            if(count($queryPriLancamento) > 0){
                $mes_pri_vencimento = $queryPriLancamento[0]['mes_pri_vencimento'];
                $ano_pri_vencimento = $queryPriLancamento[0]['ano_pri_vencimento'];
            }

            $queryMesAnterior = $lancamentodao->listarExtrato($empresas_pk,$contas_bancarias_pk,$mes_pri_vencimento,$ano_pri_vencimento, $ds_mes_anterior,$_ds_ano);
            for($l = 0; $l < count($queryMesAnterior); $l++){


                    if($queryMesAnterior[$l]["operacao_pk"]==1){
                        $vl_receita_mes_anterior += $queryMesAnterior[$l]["vl_lancamento"];
                    }
    
                    if($queryMesAnterior[$l]["operacao_pk"]!=1){
                        $vl_despesa_mes_anterior += $queryMesAnterior[$l]["vl_lancamento"];
                    }
                    $vl_total_mes_anterior += $queryMesAnterior[$l]["vl_lancamento"];
                    
                      
            }
            
                
                //listar saldo mês anterior 
                $query = $lancamentodao->listarExtratoMes($empresas_pk,$contas_bancarias_pk,$_ds_mes,$_ds_ano);
                $result  = 'success';
                $message = 'query success';
                if(count($query) > 0){
                    $vl_receita = 0;
                    $vl_despesa = 0;
                    $vl_total = 0;
                    for($i = 0; $i < count($query); $i++){

                        if($query[$i]['tipo_grupo_pk']==1){
                            $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                            $ds_recebido_de = $queryLead[0]['ds_lead'];
                        }else if($query[$i]['tipo_grupo_pk']==2){
                            $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                            $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                        }else if($query[$i]['tipo_grupo_pk']==3){
                            $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                            $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                        }

                        if($query[$i]["operacao_pk"]==1){
                            $vl_receita += $query[$i]["vl_lancamento"];
                        }

                        if($query[$i]["operacao_pk"]!=1){
                            $vl_despesa += $query[$i]["vl_lancamento"];
                        }

                        

                        $vl_total += $query[$i]["vl_lancamento"];
                        $data = $query[$i]["dt_vencimento"];
                        $l = $i - 1;
                        $a = $i + 1;
                        
                        $data_anterior = $query[$l]["dt_vencimento"];
                        if($data_anterior == null){
                          $data_anterior = "";
                        }
                        $proxima_data = $query[$a]["dt_vencimento"];
                        if($proxima_data == null){
                            $proxima_data = "";
                        }

                        if($data_anterior == $data){
                            $vl_total_dia += $query[$i]["vl_lancamento"];
                            if($query[$i]["operacao_pk"]==1){
                                $vl_receita_dia += $query[$i]["vl_lancamento"];
                            }else if($query[$i]["operacao_pk"]!=1){
                                $vl_despesa_dia += $query[$i]["vl_lancamento"];
                            }
                        }else{
                            $vl_total_dia = $query[$i]["vl_lancamento"];
                            $vl_receita_dia = "";
                            $vl_despesa_dia = "";

                            if($query[$i]["operacao_pk"]==1){
                                $vl_receita_dia += $query[$i]["vl_lancamento"];
                            }else if($query[$i]["operacao_pk"]!=1){
                                $vl_despesa_dia += $query[$i]["vl_lancamento"];
                            }
                            
                        }

                        $extrato[] = array(
                            "pk" => $query[$i]["pk"],
                            "dt_cadastro" => $query[$i]["dt_cadastro"],
                            "dt_vencimento" => $query[$i]["dt_vencimento"],
                            "dt_faturamento" => $query[$i]["dt_faturamento"],
                            "ds_lancamento" => $query[$i]["ds_lancamento"],
                            "dt_pagamento" => $query[$i]["dt_pagamento"],
                            "ds_operacao" => $query[$i]["ds_operacao"],
                            "ds_tipo_grupo" => $query[$i]["ds_tipo_grupo"],                    
                            "ds_recebido_pago_origem" => $ds_recebido_de,
                            "ds_metodo_pagamento" => $query[$i]["ds_metodo_pagamento"],                    
                            "vl_lancamento" =>  number_format($query[$i]["vl_lancamento"], 2, ',', '.'),                            
                            "ds_usuario" => $query[$i]["ds_usuario"],
                            "operacao_pk" => $query[$i]["operacao_pk"],
                            "ic_status_pagamento" => $query[$i]["ic_status_pagamento"],                            
                            "ds_tipo_operacao" => $query[$i]["ds_tipo_operacao"],
                            "total_dia" =>  number_format($vl_total_dia, 2, ',', '.'),
                            "receita_dia" =>  number_format($vl_receita_dia, 2, ',', '.'),
                            "despesa_dia" =>  number_format($vl_despesa_dia, 2, ',', '.'),
                            "vl_total_saldo_dia" =>  number_format(($vl_receita_dia - $vl_despesa_dia), 2, ',', '.'),
                            "proxima_data" => $proxima_data,

                            "t_functions" => ""
                        );
                    }            
                }else{
                    $extrato = [];
                }

                $vl_saldo_mes_anterior = $vl_receita_mes_anterior - $vl_despesa_mes_anterior;
                $vl_total_saldo_mes = $vl_receita - $vl_despesa;
                $vl_saldo_atual = $vl_saldo_mes_anterior + $vl_total_saldo_mes;
            
                $mysql_data[] = array(
                   "vl_inicial_conta" => $vl_vl_saldo_inicial,                 
                   "vl_total_receita" =>  number_format($vl_receita, 2, ',', '.'),
                   "vl_total_despesa" =>  number_format($vl_despesa, 2, ',', '.'),
                   "vl_total" =>  number_format($vl_total, 2, ',', '.'), 
                   "vl_total_saldo_mes" =>  number_format(($vl_receita - $vl_despesa), 2, ',', '.'),
                   "vl_saldo_mes_anterior" =>  number_format(($vl_saldo_mes_anterior), 2, ',', '.'),
                   "vl_saldo_atual" =>  number_format(($vl_saldo_atual), 2, ',', '.'),
                   "DadosExtrato"=>$extrato, 
                   "t_functions" => ""
                );
            
        } else{
            $mysql_data = [];
        }		
        break;       
        
    }
    
    case 'listarDataTableReceitaDespesaConciliacao':{
            
         $dt_periodo_ini = $_REQUEST['dt_periodo_ini'];
         $dt_periodo_fim = $_REQUEST['dt_periodo_fim'];  
         $empresas_pk = $_REQUEST['empresas_pk'];     
         $contas_bancarias_pk = $_REQUEST['contas_bancarias_pk'];
        //listar saldo mês anterior 
        $query = $lancamentodao->listarExtratoConciliacao($empresas_pk,$contas_bancarias_pk,$dt_periodo_ini,$dt_periodo_fim);
        $result  = 'success';
        $message = 'query success';
        if(count($query) > 0){
            $vl_receita = 0;
            $vl_despesa = 0;
            $vl_total = 0;
            for($i = 0; $i < count($query); $i++){

                if($query[$i]["operacao_pk"]==1){
                    $vl_receita += $query[$i]["vl_lancamento"];
                }

                if($query[$i]["operacao_pk"]!=1){
                    $vl_despesa += $query[$i]["vl_lancamento"];
                }
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];
                }else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                }else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                }

                

                $vl_total += $query[$i]["vl_lancamento"];
                $data = $query[$i]["dt_vencimento"];
                $l = $i - 1;
                $a = $i + 1;
                
                $data_anterior = $query[$l]["dt_vencimento"];
                if($data_anterior == null){
                    $data_anterior = "";
                }
                $proxima_data = $query[$a]["dt_vencimento"];
                if($proxima_data == null){
                    $proxima_data = "";
                }

                if($data_anterior == $data){
                    $vl_total_dia += $query[$i]["vl_lancamento"];
                    if($query[$i]["operacao_pk"]==1){
                        $vl_receita_dia += $query[$i]["vl_lancamento"];
                    }else if($query[$i]["operacao_pk"]!=1){
                        $vl_despesa_dia += $query[$i]["vl_lancamento"];
                    }
                }else{
                    $vl_total_dia = $query[$i]["vl_lancamento"];
                    $vl_receita_dia = "";
                    $vl_despesa_dia = "";

                    if($query[$i]["operacao_pk"]==1){
                        $vl_receita_dia += $query[$i]["vl_lancamento"];
                    }else if($query[$i]["operacao_pk"]!=1){
                        $vl_despesa_dia += $query[$i]["vl_lancamento"];
                    }
                    
                }
                
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_cadastro" => $query[$i]["dt_cadastro"],
                    "dt_vencimento" => $query[$i]["dt_vencimento"],
                    "financeiro_conciliacao_banco_itens_pk" => $query[$i]["financeiro_conciliacao_banco_itens_pk"],
                    "ds_recebido_pago_origem" => $ds_recebido_de,
                    "dt_faturamento" => $query[$i]["dt_faturamento"],
                    "ds_lancamento" => $query[$i]["ds_lancamento"],
                    "dt_pagamento" => $query[$i]["dt_pagamento"],
                    "ds_operacao" => $query[$i]["ds_operacao"],
                    "ds_tipo_grupo" => $query[$i]["ds_tipo_grupo"], 
                    "ds_metodo_pagamento" => $query[$i]["ds_metodo_pagamento"],                    
                    "vl_lancamento" =>  number_format($query[$i]["vl_lancamento"], 2, ',', '.'),                            
                    "ds_usuario" => $query[$i]["ds_usuario"],
                    "operacao_pk" => $query[$i]["operacao_pk"],
                    "ic_status_pagamento" => $query[$i]["ic_status_pagamento"],  
                    "ic_status_conciliacao" =>$query[$i]['ic_status_conciliacao'],                          
                    "ds_tipo_operacao" => $query[$i]["ds_tipo_operacao"],
                    "total_dia" =>  number_format($vl_total_dia, 2, ',', '.'),
                    "receita_dia" =>  number_format($vl_receita_dia, 2, ',', '.'),
                    "despesa_dia" =>  number_format($vl_despesa_dia, 2, ',', '.'),
                    "vl_total" =>  number_format($vl_total, 2, ',', '.'),
                    "vl_total_saldo_dia" =>  number_format(($vl_receita_dia - $vl_despesa_dia), 2, ',', '.'),
                    "proxima_data" => $proxima_data,

                    "t_functions" => ""
                );
            }            
        }else{
            $mysql_data = [];
        }	
        break;       
        
    }
    
   
    case 'listarExtratoMesConciliacao':{
        
        $empresas_pk = $_REQUEST['empresas_pk'];
        
        $resultado = "";
        $query = $lancamentodao->listarExtratoMesConciliacao($empresas_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_cadastro" => $query[$i]["dt_cadastro"],
                    "dt_vencimento" => $query[$i]["dt_vencimento"],
                    "dt_faturamento" => $query[$i]["dt_faturamento"],
                    "ds_lancamento" => $query[$i]["ds_lancamento"],
                    "dt_pagamento" => $query[$i]["dt_pagamento"],
                    "ds_operacao" => $query[$i]["ds_operacao"],
                    "ds_tipo_grupo" => $query[$i]["ds_tipo_grupo"],                    
                    //"ds_recebido_pago_origem" => $ds_recebido_de,
                    "ds_metodo_pagamento" => $query[$i]["ds_metodo_pagamento"],                    
                    "vl_lancamento" =>  number_format($query[$i]["vl_lancamento"], 2, ',', '.'),                            
                    "ds_usuario" => $query[$i]["ds_usuario"],
                    "operacao_pk" => $query[$i]["operacao_pk"],
                    "ic_status_pagamento" => $query[$i]["ic_status_pagamento"],                            
                    "ds_tipo_operacao" => $query[$i]["ds_tipo_operacao"],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    } 

    case 'listarReceitaGrid':{
        $usuario_cadastro_pk = $_REQUEST['usuario_cadastro_pk'];
        $dt_cadastro_ini = $_REQUEST['dt_cadastro_ini'];
        $dt_cadastro_fim = $_REQUEST['dt_cadastro_fim'];      
        $dt_faturamento_ini = $_REQUEST['dt_faturamento_ini'];
        $dt_faturamento_fim = $_REQUEST['dt_faturamento_fim'];
        $dt_vencimento_ini = $_REQUEST['dt_vencimento_ini'];
        $dt_vencimento_fim = $_REQUEST['dt_vencimento_fim'];          
        $dt_pagamento_ini = $_REQUEST['dt_pagamento_ini'];
        $dt_pagamento_fim = $_REQUEST['dt_pagamento_fim'];
        $grupo_leancamento_pk = $_REQUEST['grupo_lancamento_pk'];
        $ds_num_documento = $_REQUEST['ds_num_documento'];
        $ic_tipo_num_documento = $_REQUEST['ic_tipo_num_documento'];
 
        $_ds_mes = $_REQUEST['ds_mes'];
        $_ds_ano = $_REQUEST['ds_ano'];


        $query = $lancamentodao->listarGridReceita($_ds_mes,$_ds_ano,$pk,$ic_status_pagamento,$usuario_cadastro_pk,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim,$dt_vencimento_ini,$dt_vencimento_fim,$dt_pagamento_ini,$dt_pagamento_fim, $ds_num_documento,$ic_tipo_num_documento);
                
        $result  = 'success';
        $message = 'query success';
        if(count($query) > 0){
            $vl_receita = 0;
            $vl_receita_pendente  = 0;
            for($i = 0; $i < count($query); $i++){
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];
                }else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                }else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                }

                if($query[$i]["operacao_pk"]==1){
                    $vl_receita += $query[$i]["vl_lancamento"];
                }
                
                if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){         
                    if($query[$i]["operacao_pk"]==1 and $query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){                  
                        $vl_receita_pendente += $query[$i]["vl_lancamento"];
                    }    
                }

                $data = $query[$i]["dt_vencimento"];
                $l = $i - 1;
                $a = $i + 1;
                
                $data_anterior = $query[$l]["dt_vencimento"];
                if($data_anterior == null){
                  $data_anterior = "";
                }
                $proxima_data = $query[$a]["dt_vencimento"];
                if($proxima_data == null){
                    $proxima_data = "";
                }

                if($data_anterior == $data){
                    $vl_total_dia += $query[$i]["vl_lancamento"];
                    if($query[$i]["operacao_pk"]==1){
                        $vl_receita_dia += $query[$i]["vl_lancamento"];
                    }
                    if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){         
                        if($query[$i]["operacao_pk"]==1 and $query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){                  
                            $vl_receita_pendente_dia += $query[$i]["vl_lancamento"];
                        }    
                    }
                }else{
                    $vl_total_dia = $query[$i]["vl_lancamento"];
                    $vl_receita_pendente_dia = "";
                    $vl_receita_dia = "";
                    if($query[$i]["operacao_pk"]==1){
                        $vl_receita_dia += $query[$i]["vl_lancamento"];
                    }
                    if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){         
                        if($query[$i]["operacao_pk"]==1 and $query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){                  
                            $vl_receita_pendente_dia += $query[$i]["vl_lancamento"];
                        }    
                    }
                    
                }
                
                                                
                $extrato[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_cadastro" => $query[$i]["dt_cadastro"],
                    "ds_empresa" => $query[$i]["ds_empresa"],
                    "ds_conta_bancaria" => $query[$i]["ds_conta_bancaria"],
                    "ds_status_pagamento" => $query[$i]["ds_status_pagamento"],                    
                    "dt_vencimento" => $query[$i]["dt_vencimento"],
                    "dt_faturamento" => $query[$i]["dt_faturamento"],
                    "dt_pagamento" => $query[$i]["dt_pagamento"],
                    "ds_operacao" => $query[$i]["ds_operacao"],
                    "ds_lancamento" => $query[$i]["ds_lancamento"],
                    "ds_tipo_grupo" => $query[$i]["ds_tipo_grupo"],                    
                    "ds_recebido_pago_origem" => $ds_recebido_de,
                    "ds_metodo_pagamento" => $query[$i]["ds_metodo_pagamento"],                    
                    "vl_lancamento" =>  number_format($query[$i]["vl_lancamento"], 2, ',', '.'),                            
                    "ds_usuario" => $query[$i]["ds_usuario"],
                    "operacao_pk" => $query[$i]["operacao_pk"],
                    "ds_tipo_operacao" => $query[$i]["ds_tipo_operacao"],
                    "ic_status_pagamento" => $query[$i]["ic_status_pagamento"], 
                    "vl_receita_pendente_dia" =>  number_format($vl_receita_pendente_dia, 2, ',', '.'),
                    "vl_total_dia" =>  number_format($vl_total_dia, 2, ',', '.'),
                    "vl_receita_dia" =>  number_format($vl_receita_dia, 2, ',', '.'),
                    "proxima_data" => $proxima_data,          

                    "t_functions" => ""
                );
            } 
            
            $mysql_data[] = array(             
                "vl_total_receita" =>  number_format($vl_receita, 2, ',', '.'),
                "vl_total_receita_pendente" =>  number_format($vl_receita_pendente, 2, ',', '.'),
                "DadosExtrato"=>$extrato, 
                "t_functions" => ""
            );
            
            
        }else{
            $mysql_data = [];
        }		
        break;       
        
    } 
    
    case 'listarDespesaGrid':{
        $usuario_cadastro_pk = $_REQUEST['usuario_cadastro_pk'];
        $dt_cadastro_ini = $_REQUEST['dt_cadastro_ini'];
        $dt_cadastro_fim = $_REQUEST['dt_cadastro_fim'];      
        $dt_faturamento_ini = $_REQUEST['dt_faturamento_ini'];
        $dt_faturamento_fim = $_REQUEST['dt_faturamento_fim'];
        $dt_vencimento_ini = $_REQUEST['dt_vencimento_ini'];
        $dt_vencimento_fim = $_REQUEST['dt_vencimento_fim'];          
        $dt_pagamento_ini = $_REQUEST['dt_pagamento_ini'];
        $dt_pagamento_fim = $_REQUEST['dt_pagamento_fim'];
        $grupo_leancamento_pk = $_REQUEST['grupo_lancamento_pk'];
        $ic_status_analise = $_REQUEST['ic_status_analise'];
        $ds_num_documento = $_REQUEST['ds_num_documento'];
        $ic_tipo_num_documento = $_REQUEST['ic_tipo_num_documento'];
        
        $_ds_mes = $_REQUEST['ds_mes'];
        $_ds_ano = $_REQUEST['ds_ano'];

        $query = $lancamentodao->listarGridDespesa($_ds_mes,$_ds_ano,$pk,$ic_status_pagamento,$usuario_cadastro_pk,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim,$dt_vencimento_ini,$dt_vencimento_fim,$dt_pagamento_ini,$dt_pagamento_fim, $ic_status_analise,$ds_num_documento,$ic_tipo_num_documento);

        $result  = 'success';
        $message = 'query success';
        if(count($query) > 0){
            $vl_despesa = 0;
            $vl_despesa_pendente  = 0;
            for($i = 0; $i < count($query); $i++){
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];
                }else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                }else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                }

                if($query[$i]["operacao_pk"]!=1){
                    $vl_despesa += $query[$i]["vl_lancamento"];
                }
                
                if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){
                    if($query[$i]["operacao_pk"]!=1 and $query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){
                        $vl_despesa_pendente += $query[$i]["vl_lancamento"];
                    }    
                }

                $data = $query[$i]["dt_vencimento"];
                $l = $i - 1;
                $a = $i + 1;
                
                $data_anterior = $query[$l]["dt_vencimento"];
                if($data_anterior == null){
                  $data_anterior = "";
                }
                $proxima_data = $query[$a]["dt_vencimento"];
                if($proxima_data == null){
                    $proxima_data = "";
                }

                if($data_anterior == $data){
                    $vl_total_dia += $query[$i]["vl_lancamento"];
                    if($query[$i]["operacao_pk"]!=1){
                        $vl_despesa_dia += $query[$i]["vl_lancamento"];
                    }
                    if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){
                        if($query[$i]["operacao_pk"]!=1 and $query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){
                            $vl_despesa_pendente_dia += $query[$i]["vl_lancamento"];
                        }    
                    }
                }else{
                    $vl_total_dia = $query[$i]["vl_lancamento"];
                    $vl_despesa_pendente_dia = "";
                    $vl_despesa_dia = "";
                    if($query[$i]["operacao_pk"]!=1){
                        $vl_despesa_dia += $query[$i]["vl_lancamento"];
                    }
                    if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){
                        if($query[$i]["operacao_pk"]!=1 and $query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){
                            $vl_despesa_pendente_dia += $query[$i]["vl_lancamento"];
                        }    
                    }
                }
                
                                                
                $extrato[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_cadastro" => $query[$i]["dt_cadastro"],
                    "ds_empresa" => $query[$i]["ds_empresa"],
                    "ds_conta_bancaria" => $query[$i]["ds_conta_bancaria"],
                    "ds_status_pagamento" => $query[$i]["ds_status_pagamento"],                    
                    "ds_lancamento" => $query[$i]["ds_lancamento"],                    
                    "dt_vencimento" => $query[$i]["dt_vencimento"],
                    "dt_faturamento" => $query[$i]["dt_faturamento"],
                    "dt_pagamento" => $query[$i]["dt_pagamento"],
                    "ds_operacao" => $query[$i]["ds_operacao"],
                    "ds_tipo_grupo" => $query[$i]["ds_tipo_grupo"],                    
                    "ds_recebido_pago_origem" => $ds_recebido_de,
                    "ds_metodo_pagamento" => $query[$i]["ds_metodo_pagamento"],                    
                    "vl_lancamento" =>  number_format($query[$i]["vl_lancamento"], 2, ',', '.'),                            
                    "vl_despesa_pendente_dia" =>  number_format($vl_despesa_pendente_dia, 2, ',', '.'),                            
                    "vl_despesa_dia" =>  number_format($vl_despesa_dia, 2, ',', '.'),                            
                    "ds_usuario" => $query[$i]["ds_usuario"],
                    "operacao_pk" => $query[$i]["operacao_pk"],
                    "ds_tipo_operacao" => $query[$i]["ds_tipo_operacao"],
                    "ic_status_pagamento" => $query[$i]["ic_status_pagamento"],   
                    "ds_status_analise" => $query[$i]["ds_status_analise"],   
                    "proxima_data" => $proxima_data,                  
                    "t_functions" => ""
                );
            } 
            
            $mysql_data[] = array(             
                "vl_total_despesa" =>  number_format($vl_despesa, 2, ',', '.'),
                "vl_total_despesa_pendente" =>  number_format($vl_despesa_pendente, 2, ',', '.'),
                "DadosExtratoDespesa"=>$extrato, 
                "t_functions" => ""
            );
            
            
        }else{
            $mysql_data = [];
        }		
        break;  
    } 

    case 'listarLancamentoGrid':{

        $query = $lancamentodao->listarGridLancamento($pk,$ic_status_pagamento,$usuario_cadastro_pk,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim,$dt_vencimento_ini,$dt_vencimento_fim,$dt_pagamento_ini,$dt_pagamento_fim, $ds_num_documento,$ic_tipo_num_documento);
                
        $result  = 'success';
        $message = 'query success';
        if(count($query) > 0){
            for($i=0;$i<count($query);$i++){
                $mysql_data[] = array(             
                    "vl_total_lancamento" =>  $query[$i]['vl_total_lancamento'],
                    "vl_total_lancamento_pendente" =>  $query[$i]['vl_total_lancamento_pendente'],
                    "DadosExtratoLancamento"=>$query[$i]['DadosExtratoLancamento'], 
                    "t_functions" => ""
                );
            }
        }else{
            $mysql_data = [];
        }		
        break;    
    }

    case 'listarLancamentoGridUsuarios':{
        $leads_pk = $_REQUEST['leads_pk'];
        $query = $lancamentodao->listarGridLancamentoUsuarios($pk,$ic_status_pagamento,$usuario_cadastro_pk,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim,$dt_vencimento_ini,$dt_vencimento_fim,$dt_pagamento_ini,$dt_pagamento_fim, $ic_status_analise, $ds_num_documento,$ic_tipo_num_documento,$leads_pk);
                
        $result  = 'success';
        $message = 'query success';
        if(count($query) > 0){
            for($i=0;$i<count($query);$i++){
                $mysql_data[] = array(             
                    "vl_total_lancamento" =>  $query[$i]['vl_total_lancamento'],
                    "vl_total_lancamento_pendente" =>  $query[$i]['vl_total_lancamento_pendente'],
                    "DadosExtratoLancamento"=>$query[$i]['DadosExtratoLancamento'], 
                    "t_functions" => ""
                );
            }
        }else{
            $mysql_data = [];
        }		
        break;    
    }

    case 'lisarLancamentoPk':{
        
        $query = $lancamentodao->lisarLancamentoPk($pk);                
        $result  = 'success';
        $message = 'query success';
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_cadastro" => $query[$i]["dt_cadastro"],
                    "ds_lancamento" => $query[$i]["ds_lancamento"],
                    "operacao_pk" => $query[$i]["operacao_pk"],
                    "categoria_operacao_pk" => $query[$i]["categoria_operacao_pk"],                    
                    "tipos_operacao_pk" => $query[$i]["tipos_operacao_pk"],
                    "grupo_leancamento_pk" => $query[$i]["grupo_leancamento_pk"],                    
                    "tipo_grupo_pk" => $query[$i]["tipo_grupo_pk"],
                    "leads_clientes_pk" => $query[$i]["leads_clientes_pk"],
                    "leads_posto_trabalho_pk" => $query[$i]["leads_posto_trabalho_pk"],
                    "leads_contratos_pk" => $query[$i]["contratos_pk"],
                    "colaborador_pk" => $query[$i]["colaborador_pk"],      
                    "colaborador_posto_trabalho_pk" => $query[$i]["colaborador_posto_trabalho_pk"],
                    "colaborador_contratos_pk" => $query[$i]["colaborador_contratos_pk"],
                    "fornecedor_pk" => $query[$i]["fornecedor_pk"],  
                    "fornecedor_posto_trabalho_pk" => $query[$i]["fornecedor_posto_trabalho_pk"], 
                    "fornecedor_contratos_pk" => $query[$i]["fornecedor_contratos_pk"],        
                    "tipo_grupo_centro_custo_pk" => $query[$i]["tipo_grupo_centro_custo_pk"],    
                    "grupo_lancamento_centro_custo_pk" => $query[$i]["grupo_lancamento_centro_custo_pk"], 
                    "dt_faturamento" => $query[$i]["dt_faturamento"], 
                    "dt_vencimento" => $query[$i]["dt_vencimento"],  
                    "vl_lancamento" =>  number_format($query[$i]["vl_lancamento"], 2, ',', '.'), 
                    "metodos_pagamento_pk" => $query[$i]["metodos_pagamento_pk"],  
                    "metodos_pagamento_pk" => $query[$i]["metodos_pagamento_pk"], 
                    "empresas_pk" => $query[$i]["empresas_pk"],  
                    "contas_bancarias_pk" => $query[$i]["contas_bancarias_pk"],  
                    "ic_status_pagamento" => $query[$i]["ic_status_pagamento"],
                    "dt_pagamento" => $query[$i]["dt_pagamento"],
                    "obs_lancamento" => $query[$i]["obs_lancamento"],
                    "parcela_pk" => $query[$i]["parcela_pk"],
                    "ds_num_documento" => $query[$i]["ds_num_documento"],
                    "ic_tipo_num_documento" => $query[$i]["ic_tipo_num_documento"],
                    "t_functions" => ""
                );
            }  
        }else{
            $mysql_data = [];
        }		
        break;    
    }
    case 'listarDadosImpressao':{       
        $resultado = "";
        $query = $lancamentodao->listarPorPk($pk);
       
        $result  = 'success';
        $message = 'query success';
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_recebido_de = "";
                $ds_recebido_de_centro_custo = "";                
                $ds_agencia = "";                
                $ds_conta = "";                
                $ds_digito = "";                
                $ds_banco = "";                


                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];                    
                }
                else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                    $ds_agencia = $queryLead[0]['ds_agencia'];         
                    $ds_conta = $queryLead[0]['ds_conta'];            
                    $ds_digito = $queryLead[0]['ds_digito'];             
                    $ds_banco = $queryLead[0]['ds_banco'];
                    $ds_pix = $queryLead[0]['ds_pix'];
                    $ds_favorecido_pix = $queryLead[0]['ds_conta_favorecido'];
                }
                else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                    $ds_agencia = $queryLead[0]['ds_agencia'];         
                    $ds_conta = $queryLead[0]['ds_conta'];            
                    $ds_digito = $queryLead[0]['ds_digito'];             
                    $ds_banco = $queryLead[0]['ds_banco'];
                    $ds_pix = $queryLead[0]['ds_pix'];
                    $ds_favorecido_pix = $queryLead[0]['ds_favorecido_pix'];
                }
                //echo $query[$i]['grupo_lancamento_centro_custo_pk'];
                //CENTRO CUSTO
                //echo $query[$i]['grupo_lancamento_centro_custo_pk'];
                if($query[$i]['tipo_grupo_centro_custo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
                }else if($query[$i]['tipo_grupo_centro_custo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
                }else if($query[$i]['tipo_grupo_centro_custo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
                }else if($query[$i]['tipo_grupo_centro_custo_pk']==4){
                    $queryLead = $lancamentodao->listaItensGrupoEquipes($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_equipe'];
                }

                //Posto de trabalho
                $lancamento_posto_trabalho_pk = "";
                if(!empty($query[$i]['leads_posto_trabalho_pk'])){
                    $lancamento_posto_trabalho_pk = $query[$i]['leads_posto_trabalho_pk'];
                }else if(!empty($query[$i]['colaborador_posto_trabalho_pk'])){
                    $lancamento_posto_trabalho_pk = $query[$i]['colaborador_posto_trabalho_pk'];
                }else if(!empty($query[$i]['fornecedor_posto_trabalho_pk'])){
                    $lancamento_posto_trabalho_pk = $query[$i]['fornecedor_posto_trabalho_pk'];
                }
                $ds_lancamento_posto_trabalho = "";
                if(!empty($lancamento_posto_trabalho_pk)){
                    $queryPostoTrabalho = $lancamentodao->listaItensGrupoLeads($lancamento_posto_trabalho_pk);
                    $ds_lancamento_posto_trabalho = $queryPostoTrabalho[0]['ds_lead'];              
                }

                //Contratos
                $lancamento_contrato_pk = "";
                $ds_produto_servico = "";                
                if(!empty($query[$i]['colaborador_contratos_pk'])){
                    $lancamento_contrato_pk = $query[$i]['colaborador_contratos_pk'];
                }else if(!empty($query[$i]['fornecedor_contratos_pk'])){
                    $lancamento_contrato_pk = $query[$i]['fornecedor_contratos_pk'];
                }else if(!empty($query[$i]['contratos_pk'])){
                    $lancamento_contrato_pk = $query[$i]['contratos_pk'];
                }         
                
                $ds_lancamento_contrato= "";
                if(!empty($lancamento_contrato_pk)){
                    $queryContrato = $lancamentodao->listarcontratos($lancamento_contrato_pk);
                    $ds_lancamento_contrato = $queryContrato[0]['ds_contrato'];  
                    $queryProdutoServico = $produto_servicodao->listarProdutosContrato($lancamento_contrato_pk);
                    $ds_produto_servico =  $queryProdutoServico[0]['ds_produto_servico'];   
        
                    if(!empty($ds_produto_servico)){
                        $ds_lancamento_contrato  = $ds_lancamento_contrato." Serviço:".$ds_produto_servico; 
                    }                                   
                }

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "ds_agencia"=>$ds_agencia,
                    "ds_conta"=>$ds_conta,
                    "ds_digito"=>$ds_digito,
                    "ds_banco"=>$ds_banco,
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_ds_usuario_cadastro"=>$query[$i]['ds_usuario'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_vl_inicial_conta"=>$query[$i]['vl_saldo_inicial'],
                    "t_dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "t_vl_saldo"=>number_format((($query[$i]['vl_lancamento']-$query[$i]['vl_lancamento']) ),2,",","."),
                    "t_ds_lancamento"=>$query[$i]['ds_lancamento'],
                    "t_vl_lancamento"=>($query[$i]['vl_lancamento']),
                    "t_operacao_pk"=>$query[$i]['operacao_pk'],
                    "t_ds_operacao"=>$query[$i]['ds_operacao'],
                    "t_ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "t_tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "t_ds_tipo_grupo"=>$query[$i]['ds_tipo_grupo'],
                    "t_ds_tipo_grupo_centro_custo"=>$query[$i]['ds_tipo_grupo_centro_custo'],
                    "t_grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "t_ic_status_pagamento"=>$query[$i]['ic_status_pagamento'],
                    "t_ds_status_pagamento"=>$query[$i]['ds_status_pagamento'],
                    "t_obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "t_dt_competencia"=>$query[$i]['dt_competencia'],
                    "t_n_documento"=>$query[$i]['n_documento'],
                    "t_contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "t_tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "t_metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "t_ds_metodo_pagamento"=>$query[$i]['ds_metodo_pagamento'],
                    "t_ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "t_ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],
                    "t_ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "t_ds_dados_conta"=>$query[$i]['ds_dados_conta'],
                    "t_ds_pix"=>$ds_pix,
                    "t_ds_favorecido_pix"=>$ds_favorecido_pix,
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "t_ds_recebido_de"=>$ds_recebido_de,
                    "t_ds_recebido_de_centro_custo"=>$ds_recebido_de_centro_custo,
                    "t_ds_cliente"=>$query[$i]['ds_cliente'],
                    "t_ds_lancamento_posto_trabalho"=>$ds_lancamento_posto_trabalho,   
                    "t_ds_lancamento_contrato"=>$ds_lancamento_contrato,
                    
                    "t_functions" => ""
                );
            }
        }else{
            $mysql_data = [];
        }
		
        break;       
    }   

    
    //Antigo
    case 'listarPk':{
       
        $resultado = "";
        $query = $lancamentodao->listarPorPk($pk);
       
        $result  = 'success';
        $message = 'query success';
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_recebido_de = "";
                $ds_recebido_de_centro_custo = "";                
                $ds_agencia = "";                
                $ds_conta = "";                
                $ds_digito = "";                
                $ds_banco = "";                
                
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                    $ds_agencia = $queryLead[0]['ds_agencia'];         
                    $ds_conta = $queryLead[0]['ds_conta'];            
                    $ds_digito = $queryLead[0]['ds_digito'];             
                    $ds_banco = $queryLead[0]['ds_banco'];
                }
                else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                    $ds_agencia = $queryLead[0]['ds_agencia'];         
                    $ds_conta = $queryLead[0]['ds_conta'];            
                    $ds_digito = $queryLead[0]['ds_digito'];             
                    $ds_banco = $queryLead[0]['ds_banco'];
                }
                                
                //CENTRO CUSTO
                if($query[$i]['tipo_grupo_centro_custo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_fornecedor'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==4){
                    $queryLead = $lancamentodao->listaItensGrupoEquipes($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_equipe'];
                }
                
                //echo $queryReceita[0]['vl_lancamento']." - ".$queryDespesas[0]['vl_lancamento']." + ".$query[$i]['vl_saldo_inicial']."<br>";
                
                $ds_lancamento = "";
                $ds_lancamento = remover_acentos($query[$i]['ds_lancamento']);
                
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "ds_agencia"=>$ds_agencia,
                    "ds_conta"=>$ds_conta,
                    "ds_digito"=>$ds_digito,
                    "ds_banco"=>$ds_banco,
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_vl_inicial_conta"=>$query[$i]['vl_saldo_inicial'],
                    "t_dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "t_vl_saldo"=>number_format((($queryReceita[0]['vl_lancamento']-$queryDespesas[0]['vl_lancamento']) ),2,",","."),
                    "t_ds_lancamento"=>substr($ds_lancamento,0,10),
                    "t_vl_lancamento"=>($query[$i]['vl_lancamento']),
                    "t_operacao_pk"=>$query[$i]['operacao_pk'],
                    "t_ds_operacao"=>$query[$i]['ds_operacao'],
                    "t_ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "t_tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "t_ds_tipo_grupo"=>$query[$i]['ds_tipo_grupo'],
                    "t_ds_tipo_grupo_centro_custo"=>$query[$i]['ds_tipo_grupo_centro_custo'],
                    "t_grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "t_ic_status_pagamento"=>$query[$i]['ic_status_pagamento'],
                    "t_ds_status_pagamento"=>$query[$i]['ds_status_pagamento'],
                    "t_obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "t_dt_competencia"=>$query[$i]['dt_competencia'],
                    "t_n_documento"=>$query[$i]['n_documento'],
                    "t_contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "t_tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "t_metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "t_ds_metodo_pagamento"=>$query[$i]['ds_metodo_pagamento'],
                    "t_ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "t_ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],
                    "t_ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "t_ds_dados_conta"=>$query[$i]['ds_dados_conta'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "t_ds_recebido_de"=>$ds_recebido_de,
                    "t_ds_recebido_de_centro_custo"=>$ds_recebido_de_centro_custo,

                    "t_functions" => ""
                );
            }
        }else{
            $mysql_data = [];
        }
		
        break;       
    }    
   
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $lancamentodao->listar_por_dt_vencimento($dt_vencimento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_ds_lancamento"=>$query[$i]['ds_lancamento'],
                    "t_vl_lancamento"=>$query[$i]['vl_lancamento'],
                    "t_operacao_pk"=>$query[$i]['operacao_pk'],
                    "t_tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "t_grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "t_ic_status_pagamento"=>$query[$i]['ic_status_pagamento'],
                    "t_obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "t_dt_competencia"=>$query[$i]['dt_competencia'],
                    "t_n_documento"=>$query[$i]['n_documento'],
                    "t_contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "t_tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "t_metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    
    
    
    
    
   
    case 'listarReceita':{

        $operacao_pk = $_REQUEST['operacao_pk'];
        $dt_vencimento_ini = $_REQUEST['dt_vencimento_ini'];
        $dt_vencimento_fim = $_REQUEST['dt_vencimento_fim'];
        $contas_bancarias_pk = $_REQUEST['contas_bancarias_pk'];
        
        
        /*echo $dt_vencimento_ini."<br>";
        echo $dt_vencimento_fim."<br>";
        exit;*/
        $resultado = "";
        $query = $lancamentodao->listarReceita($operacao_pk,$dt_vencimento_ini,$dt_vencimento_fim,$contas_bancarias_pk);

        $queryReceita = $lancamentodao->listarValoresReceita($dt_vencimento_ini,$dt_vencimento_fim,$contas_bancarias_pk);
        
        $queryDespesas = $lancamentodao->listarValoresDespesas($dt_vencimento_ini,$dt_vencimento_fim,$contas_bancarias_pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            $vl_receita = 0;
            $vl_despesa = 0;
            for($i = 0; $i < count($query); $i++){
                $ds_recebido_de = "";
                $ds_recebido_de_centro_custo = "";
                
                
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);                   
                    $ds_recebido_de = $queryLead[0]['ds_lead'];  
                }
                else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                }
                
                
                //CENTRO CUSTO
                if($query[$i]['tipo_grupo_centro_custo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_fornecedor'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==4){
                    $queryLead = $lancamentodao->listaItensGrupoEquipes($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_equipe'];
                }
                
                //echo $queryReceita[0]['vl_lancamento']." - ".$queryDespesas[0]['vl_lancamento']." + ".$query[$i]['vl_saldo_inicial']."<br>";

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_vl_inicial_conta"=>$query[$i]['vl_saldo_inicial'],
                    
                    "t_vl_saldo"=>number_format((($queryReceita[0]['vl_lancamento'])-$queryDespesas[0]['vl_lancamento']),2,",","."),
                    "t_vl_total_receita"=>$queryReceita[0]['vl_lancamento'],
                    "t_vl_total_despesa"=>$queryDespesas[0]['vl_lancamento'],
                    "t_ds_lancamento"=>$query[$i]['ds_lancamento'],
                    "t_vl_lancamento"=>($query[$i]['vl_lancamento']),
                    "t_operacao_pk"=>$query[$i]['operacao_pk'],
                    "t_ds_operacao"=>$query[$i]['ds_operacao'],
                    "t_tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "t_ds_tipo_grupo"=>$query[$i]['ds_tipo_grupo'],
                    "t_grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "t_ic_status_pagamento"=>$query[$i]['ic_status_pagamento'],
                    "t_ds_status_pagamento"=>$query[$i]['ds_status_pagamento'],
                    "t_obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "t_dt_competencia"=>$query[$i]['dt_competencia'],
                    "t_n_documento"=>$query[$i]['n_documento'],
                    "t_contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "t_tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "t_metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "t_ds_metodo_pagamento"=>$query[$i]['ds_metodo_pagamento'],
                    "t_ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "t_ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],
                    "t_ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "t_ds_recebido_de"=>$ds_recebido_de,
                    "t_ds_recebido_de_centro_custo"=>$ds_recebido_de_centro_custo,
      
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    

    case 'listarLancamentosMes':{

        $pk = $_REQUEST['pk'];
        $operacao_pk = $_REQUEST['operacao_pk'];
        $tipo_lancamento_pk = $_REQUEST['tipo_lancamento_pk'];
        $dt_vencimento_ini = $_REQUEST['dt_vencimento_ini'];
        $dt_vencimento_fim = $_REQUEST['dt_vencimento_fim'];
        $dt_cadastro_ini = $_REQUEST['dt_cadastro_ini'];
        $dt_cadastro_fim = $_REQUEST['dt_cadastro_fim'];
        $ic_status_pagamento = $_REQUEST['ic_status_pagamento'];
        $empresas_pk = $_REQUEST['empresas_pk'];
        $tipo_grupo_pk= $_REQUEST['tipo_grupo_pk'];
        $grupo_leancamento_pk= $_REQUEST['grupo_leancamento_pk'];
        $usuario_cadastro_pk = $_REQUEST['usuario_cadastro_pk'];
        $contas_bancarias_pk = $_REQUEST['contas_bancarias_pk'];
        $dt_pagamento_ini = $_REQUEST['dt_pagamento_ini'];
        $dt_pagamento_fim = $_REQUEST['dt_pagamento_fim'];
        $dt_faturamento_ini = $_REQUEST['dt_faturamento_ini'];
        $dt_faturamento_fim = $_REQUEST['dt_faturamento_fim'];
        
        $resultado = "";
        $query = $lancamentodao->listarLancamentosMes($pk,$contas_bancarias_pk,$tipo_lancamento_pk,$dt_vencimento_ini,$dt_vencimento_fim,$ic_status_pagamento,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$usuario_cadastro_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_pagamento_ini,$dt_pagamento_fim,$dt_faturamento_ini,$dt_faturamento_fim);
        
        
        //$queryReceita = $lancamentodao->listarValoresReceita($dt_vencimento_ini,$dt_vencimento_fim,$contas_bancarias_pk);
       // $queryDespesas = $lancamentodao->listarValoresDespesas($dt_vencimento_ini,$dt_vencimento_fim,$contas_bancarias_pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            
            for($i = 0; $i < count($query); $i++){
                $ds_recebido_de = "";
                $ds_recebido_de_centro_custo = "";                
                
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                }
                                
                //CENTRO CUSTO
                if($query[$i]['tipo_grupo_centro_custo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_fornecedor'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==4){
                    $queryLead = $lancamentodao->listaItensGrupoEquipes($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_equipe'];
                }
                
                //echo $queryReceita[0]['vl_lancamento']." - ".$queryDespesas[0]['vl_lancamento']." + ".$query[$i]['vl_saldo_inicial']."<br>";
                
                $vl_total += $query[$i]['vl_lancamento'];
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_vl_inicial_conta"=>$query[$i]['vl_saldo_inicial'],
                    "t_vl_saldo"=>number_format((($queryReceita[0]['vl_lancamento']-$queryDespesas[0]['vl_lancamento']) ),2,",","."),
                    "t_ds_lancamento"=>$query[$i]['ds_lancamento'],
                    "t_vl_lancamento"=>($query[$i]['vl_lancamento']),
                    "t_operacao_pk"=>$query[$i]['operacao_pk'],
                    "t_ds_operacao"=>$query[$i]['ds_operacao'],
                    "t_tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "t_ds_tipo_grupo"=>$query[$i]['ds_tipo_grupo'],
                    "t_grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "t_ic_status_pagamento"=>$query[$i]['ic_status_pagamento'],
                    "t_ds_status_pagamento"=>$query[$i]['ds_status_pagamento'],
                    "t_obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "t_dt_competencia"=>$query[$i]['dt_competencia'],
                    "t_n_documento"=>$query[$i]['n_documento'],
                    "t_contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "t_tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "t_metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "t_ds_metodo_pagamento"=>$query[$i]['ds_metodo_pagamento'],
                    "t_dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "t_ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "t_ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],
                    "t_ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "t_ds_recebido_de"=>$ds_recebido_de,
                    "t_vl_total"=>$vl_total,
                    "t_ds_recebido_de_centro_custo"=>$ds_recebido_de_centro_custo,

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'RelatorioLancamento':{

        $operacao_pk = $_REQUEST['operacao_pk'];
        $tipo_lancamento_pk = $_REQUEST['tipo_lancamento_pk'];
        $dt_vencimento_ini = $_REQUEST['dt_vencimento_ini'];
        $dt_vencimento_fim = $_REQUEST['dt_vencimento_fim'];
        $ic_status_pagamento = $_REQUEST['ic_status_pagamento'];
        $empresas_pk = $_REQUEST['empresas_pk'];
        $tipo_grupo_pk= $_REQUEST['tipo_grupo_pk'];
        $grupo_leancamento_pk= $_REQUEST['grupo_leancamento_pk'];
        $usuario_cadastro_pk = $_REQUEST['usuario_cadastro_pk'];
        $dt_lancamento_ini = $_REQUEST['dt_lancamento_ini'];
        $dt_lancamento_fim = $_REQUEST['dt_lancamento_fim'];
        $dt_pagamento_ini = $_REQUEST['dt_pagamento_ini'];
        $dt_pagamento_fim = $_REQUEST['dt_pagamento_fim'];

        $dt_faturamento_ini = $_REQUEST['dt_faturamento_ini'];
        $dt_faturamento_fim = $_REQUEST['dt_faturamento_fim'];
        
        $plano_contas = $_REQUEST['tipos_operacao_pk_receita'];

        $resultado = "";
        $query = $lancamentodao->RelatorioLancamento($tipo_lancamento_pk,$dt_vencimento_ini,$dt_vencimento_fim,$ic_status_pagamento,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$usuario_cadastro_pk,$dt_lancamento_ini,$dt_lancamento_fim,$dt_pagamento_ini,$dt_pagamento_fim,$plano_contas,$dt_faturamento_ini,$dt_faturamento_fim);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            
            for($i = 0; $i < count($query); $i++){
                $ds_recebido_de = "";
                $ds_recebido_de_centro_custo = "";                
                
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                }
                                
                //CENTRO CUSTO
                if($query[$i]['tipo_grupo_centro_custo_pk']==1 or $query[$i]['tipo_grupo_centro_custo_pk']==2 or $query[$i]['tipo_grupo_centro_custo_pk']==3 ){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
                }
                /*else if($query[$i]['tipo_grupo_centro_custo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_fornecedor'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==4){
                    $queryLead = $lancamentodao->listaItensGrupoEquipes($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_equipe'];
                }*/
                
                //echo $queryReceita[0]['vl_lancamento']." - ".$queryDespesas[0]['vl_lancamento']." + ".$query[$i]['vl_saldo_inicial']."<br>";
                
                $vl_total += $query[$i]['vl_lancamento'];
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_dt_competencia"=>$query[$i]['dt_competencia'],
                    "t_dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "t_dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "t_vl_inicial_conta"=>$query[$i]['vl_saldo_inicial'],
                    "t_vl_saldo"=>number_format((($queryReceita[0]['vl_lancamento']-$queryDespesas[0]['vl_lancamento']) ),2,",","."),
                    "t_ds_lancamento"=>$query[$i]['ds_lancamento'],
                    "t_vl_lancamento"=>($query[$i]['vl_lancamento']),
                    "t_operacao_pk"=>$query[$i]['operacao_pk'],
                    "t_ds_operacao"=>$query[$i]['ds_operacao'],
                    "t_tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "t_ds_tipo_grupo"=>$query[$i]['ds_tipo_grupo'],
                    "t_grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "t_ic_status_pagamento"=>$query[$i]['ic_status_pagamento'],
                    "t_ds_status_pagamento"=>$query[$i]['ds_status_pagamento'],
                    "t_obs_lancamento"=>$query[$i]['obs_lancamento'],                    
                    "t_n_documento"=>$query[$i]['n_documento'],
                    "t_contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "t_tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "t_metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "t_ds_metodo_pagamento"=>$query[$i]['ds_metodo_pagamento'],
                    "t_ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "t_ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],
                    "t_ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "t_ds_tipo_grupo_centro_custo"=>$query[$i]['ds_tipo_grupo_centro_custo'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "t_ds_recebido_de"=>$ds_recebido_de,
                    "t_vl_total"=>$vl_total,
                    "t_ds_recebido_de_centro_custo"=>$ds_recebido_de_centro_custo,

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'RelatorioLancamentoPago':{

        $dt_pagamento_ini = $_REQUEST['dt_pagamento_ini'];
        $dt_pagamento_fim = $_REQUEST['dt_pagamento_fim'];
        $dt_lancamento_ini = $_REQUEST['dt_lancamento_ini'];
        $dt_lancamento_fim = $_REQUEST['dt_lancamento_fim'];
        $lancamento_pk = $_REQUEST['lancamento_pk'];
        $pk_cliente = $_REQUEST['pk_cliente'];
        $cnpj_cliente = $_REQUEST['cnpj_cliente'];
        $cnpj_fornecedor = $_REQUEST['cnpj_fornecedor'];
        $tipo_lancamento_pk = $_REQUEST['tipo_lancamento_pk'];
        $grupo_leancamento = "";
        
        
        $str_cliente_sem_mascara = str_replace(".", "", $cnpj_cliente);
        $str1_cliente_sem_mascara = str_replace("/", "", $str_cliente_sem_mascara);
        $cnpj_cliente_sem_mascara = str_replace("-", "", $str1_cliente_sem_mascara);
        
        
        $str_fornecedor_sem_mascara = str_replace(".", "", $cnpj_fornecedor);
        $str1_fornecedor_sem_mascara = str_replace("/", "", $str_fornecedor_sem_mascara);
        $cnpj_fornecedor_sem_mascara = str_replace("-", "", $str1_fornecedor_sem_mascara);
        
        
        
        if($cnpj_cliente!=""){
            $queryLead = $lancamentodao->listaLeadCNPJ($cnpj_cliente,$cnpj_cliente_sem_mascara);
            if(count($queryLead) > 0){
                $grupo_leancamento.=' in(';
                for($i = 0; $i < count($queryLead); $i++){
                    $grupo_leancamento.= $queryLead[$i]['pk'].",";
                }
                $grupo_leancamento.='0)';
            }
            
        }
        
        else if($cnpj_fornecedor!=""){
            $queryLead = $lancamentodao->listaFornecedoresCNPJ($cnpj_fornecedor,$cnpj_fornecedor_sem_mascara); 
            
            if(count($queryLead) > 0){
                $grupo_leancamento .=' in(';
                for($i = 0; $i < count($queryLead); $i++){
                    $grupo_leancamento.= $queryLead[$i]['pk'].",";
                }
                $grupo_leancamento .='0)';
            } 
        }
        else if($cnpj_fornecedor!="" && $cnpj_cliente!=""){
            $queryLead1 = $lancamentodao->listaLeadCNPJ($cnpj_cliente,$cnpj_cliente_sem_mascara);
            $queryLead = $lancamentodao->listaFornecedoresCNPJ($cnpj_fornecedor,$cnpj_fornecedor_sem_mascara); 
            
            if(count($queryLead1) > 0){
                $grupo_leancamento .=' in(';
                for($i = 0; $i < count($queryLead1); $i++){
                    $grupo_leancamento .= $queryLead1[$i]['pk'].",";
                }
                for($i = 0; $i < count($queryLead); $i++){
                    $grupo_leancamento .= $queryLead[$i]['pk'].",";
                }
                
                $grupo_leancamento .='0)';
            }
        }
        
        
        
        $resultado = "";
        $query = $lancamentodao->RelatorioLancamentoPago($dt_pagamento_ini,$dt_pagamento_fim,$pk_cliente,$cnpj_cliente,$cnpj_fornecedor,$grupo_leancamento,$dt_lancamento_ini,$dt_lancamento_fim,$lancamento_pk,$tipo_lancamento_pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            
            for($i = 0; $i < count($query); $i++){
                $ds_recebido_de = "";
                $ds_recebido_de_centro_custo = "";                
                $cpf_cnpj = "";                
                
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                    $cpf_cnpj = $queryLead[0]['ds_cpf'];
                }
                else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                    $cpf_cnpj = $queryLead[0]['ds_cpf_cnpj'];
                }
                                
                //CENTRO CUSTO
                if($query[$i]['tipo_grupo_centro_custo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_fornecedor'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==4){
                    $queryLead = $lancamentodao->listaItensGrupoEquipes($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_equipe'];
                }
                
                //echo $queryReceita[0]['vl_lancamento']." - ".$queryDespesas[0]['vl_lancamento']." + ".$query[$i]['vl_saldo_inicial']."<br>";
                
                $vl_total += $query[$i]['vl_lancamento'];
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_vl_inicial_conta"=>$query[$i]['vl_saldo_inicial'],
                    "t_vl_saldo"=>number_format((($queryReceita[0]['vl_lancamento']-$queryDespesas[0]['vl_lancamento']) ),2,",","."),
                    "t_ds_lancamento"=>$query[$i]['ds_lancamento'],
                    "t_vl_lancamento"=>($query[$i]['vl_lancamento']),
                    "t_operacao_pk"=>$query[$i]['operacao_pk'],
                    "t_ds_operacao"=>$query[$i]['ds_operacao'],
                    "t_tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "t_ds_tipo_grupo"=>$query[$i]['ds_tipo_grupo'],
                    "t_grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "t_ic_status_pagamento"=>$query[$i]['ic_status_pagamento'],
                    "t_ds_status_pagamento"=>$query[$i]['ds_status_pagamento'],
                    "t_obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "t_dt_competencia"=>$query[$i]['dt_competencia'],
                    "t_n_documento"=>$query[$i]['n_documento'],
                    "t_contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "t_tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "t_metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "t_ds_metodo_pagamento"=>$query[$i]['ds_metodo_pagamento'],
                    "t_dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "t_ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "t_ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],
                    "t_ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "t_ds_recebido_de"=>$ds_recebido_de,
                    "t_vl_total"=>$vl_total,
                    "t_cpf_cnpj"=>$cpf_cnpj,
                    "t_ds_recebido_de_centro_custo"=>$ds_recebido_de_centro_custo,

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarLancamentosVencidoDia':{

        $tipo_lancamento_pk = $_REQUEST['tipo_lancamento_pk'];
        $dt_vencimento_ini = $_REQUEST['dt_vencimento_ini'];
        $dt_vencimento_fim = $_REQUEST['dt_vencimento_fim'];
        $ic_status_pagamento = $_REQUEST['ic_status_pagamento'];
        $empresas_pk = $_REQUEST['empresas_pk'];
        $tipo_grupo_pk= $_REQUEST['tipo_grupo_pk'];
        $grupo_leancamento_pk= $_REQUEST['grupo_leancamento_pk'];
        $usuario_cadastro_pk = $_REQUEST['usuario_cadastro_pk'];
        
        $dt_cadastro_ini = $_REQUEST['dt_cadastro_ini'];
        $dt_cadastro_fim = $_REQUEST['dt_cadastro_fim'];
        
        $dt_faturamento_ini = $_REQUEST['dt_faturamento_ini'];
        $dt_faturamento_fim = $_REQUEST['dt_faturamento_fim'];
        
        $resultado = "";
        $query = $lancamentodao->listarLancamentosVencidoDia($pk,$tipo_lancamento_pk,$dt_vencimento_ini,$dt_vencimento_fim,$ic_status_pagamento,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$usuario_cadastro_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim);
        
        
        //$queryReceita = $lancamentodao->listarValoresReceita($dt_vencimento_ini,$dt_vencimento_fim,$contas_bancarias_pk);
       // $queryDespesas = $lancamentodao->listarValoresDespesas($dt_vencimento_ini,$dt_vencimento_fim,$contas_bancarias_pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            
            for($i = 0; $i < count($query); $i++){
                $ds_recebido_de = "";
                $ds_recebido_de_centro_custo = "";                
                
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                }
                                
                //CENTRO CUSTO
                if($query[$i]['tipo_grupo_centro_custo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_fornecedor'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==4){
                    $queryLead = $lancamentodao->listaItensGrupoEquipes($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_equipe'];
                }
                
                //echo $queryReceita[0]['vl_lancamento']." - ".$queryDespesas[0]['vl_lancamento']." + ".$query[$i]['vl_saldo_inicial']."<br>";
                
                
                $vl_total += $query[$i]['vl_lancamento'];
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_vl_inicial_conta"=>$query[$i]['vl_saldo_inicial'],
                    "t_vl_saldo"=>number_format((($queryReceita[0]['vl_lancamento']-$queryDespesas[0]['vl_lancamento']) ),2,",","."),
                    "t_ds_lancamento"=>$query[$i]['ds_lancamento'],
                    "t_vl_lancamento"=>($query[$i]['vl_lancamento']),
                    "t_dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "t_operacao_pk"=>$query[$i]['operacao_pk'],
                    "t_ds_operacao"=>$query[$i]['ds_operacao'],
                    "t_tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "t_ds_tipo_grupo"=>$query[$i]['ds_tipo_grupo'],
                    "t_grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "t_ic_status_pagamento"=>$query[$i]['ic_status_pagamento'],
                    "t_ds_status_pagamento"=>$query[$i]['ds_status_pagamento'],
                    "t_obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "t_dt_competencia"=>$query[$i]['dt_competencia'],
                    "t_n_documento"=>$query[$i]['n_documento'],
                    "t_contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "t_tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "t_metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "t_ds_metodo_pagamento"=>$query[$i]['ds_metodo_pagamento'],
                    "t_ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "t_ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],
                    "t_ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "t_ds_recebido_de"=>$ds_recebido_de,
                    "t_vl_total"=>$vl_total,
                    "t_ds_recebido_de_centro_custo"=>$ds_recebido_de_centro_custo,

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarLancamentosAtrasado':{

        $tipo_lancamento_pk = $_REQUEST['tipo_lancamento_pk'];
        $dt_vencimento_ini = $_REQUEST['dt_vencimento_ini'];
        $dt_vencimento_fim = $_REQUEST['dt_vencimento_fim'];
        $ic_status_pagamento = $_REQUEST['ic_status_pagamento'];
        $empresas_pk = $_REQUEST['empresas_pk'];
        $tipo_grupo_pk= $_REQUEST['tipo_grupo_pk'];
        $grupo_leancamento_pk= $_REQUEST['grupo_leancamento_pk'];
        $usuario_cadastro_pk = $_REQUEST['usuario_cadastro_pk'];
        $dt_cadastro_ini = $_REQUEST['dt_cadastro_ini'];
        $dt_cadastro_fim = $_REQUEST['dt_cadastro_fim'];
        $dt_faturamento_ini = $_REQUEST['dt_faturamento_ini'];
        $dt_faturamento_fim = $_REQUEST['dt_faturamento_fim'];
        
        $resultado = "";
        $query = $lancamentodao->listarLancamentosAtrasado($pk,$tipo_lancamento_pk,$dt_vencimento_ini,$dt_vencimento_fim,$ic_status_pagamento,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$usuario_cadastro_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim);
        
        
        //$queryReceita = $lancamentodao->listarValoresReceita($dt_vencimento_ini,$dt_vencimento_fim,$contas_bancarias_pk);
       // $queryDespesas = $lancamentodao->listarValoresDespesas($dt_vencimento_ini,$dt_vencimento_fim,$contas_bancarias_pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            
            for($i = 0; $i < count($query); $i++){
                $ds_recebido_de = "";
                $ds_recebido_de_centro_custo = "";                
                
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                }
                                
                //CENTRO CUSTO
                if($query[$i]['tipo_grupo_centro_custo_pk']==1){
                    $queryLead = $lancamentodao->listaItensGrupoLeads($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==2){
                    $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_colaborador'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==3){
                    $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_fornecedor'];
                }
                else if($query[$i]['tipo_grupo_centro_custo_pk']==4){
                    $queryLead = $lancamentodao->listaItensGrupoEquipes($query[$i]['grupo_lancamento_centro_custo_pk']);
                    $ds_recebido_de_centro_custo = $queryLead[0]['ds_equipe'];
                }
                
                //echo $queryReceita[0]['vl_lancamento']." - ".$queryDespesas[0]['vl_lancamento']." + ".$query[$i]['vl_saldo_inicial']."<br>";
                
                
                $vl_total += $query[$i]['vl_lancamento'];
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_vl_inicial_conta"=>$query[$i]['vl_saldo_inicial'],
                    "t_vl_saldo"=>number_format((($queryReceita[0]['vl_lancamento']-$queryDespesas[0]['vl_lancamento']) ),2,",","."),
                    "t_ds_lancamento"=>$query[$i]['ds_lancamento'],
                    "t_vl_lancamento"=>($query[$i]['vl_lancamento']),
                    "t_operacao_pk"=>$query[$i]['operacao_pk'],
                    "t_ds_operacao"=>$query[$i]['ds_operacao'],
                    "t_tipo_grupo_pk"=>$query[$i]['tipo_grupo_pk'],
                    "t_ds_tipo_grupo"=>$query[$i]['ds_tipo_grupo'],
                    "t_grupo_leancamento_pk"=>$query[$i]['grupo_leancamento_pk'],
                    "t_ic_status_pagamento"=>$query[$i]['ic_status_pagamento'],
                    "t_ds_status_pagamento"=>$query[$i]['ds_status_pagamento'],
                    "t_obs_lancamento"=>$query[$i]['obs_lancamento'],
                    "t_dt_competencia"=>$query[$i]['dt_competencia'],
                    "t_dt_pagamento"=>$query[$i]['dt_pagamento'],
                    "t_n_documento"=>$query[$i]['n_documento'],
                    "t_contas_bancarias_pk"=>$query[$i]['contas_bancarias_pk'],
                    "t_tipos_operacao_pk"=>$query[$i]['tipos_operacao_pk'],
                    "t_metodos_pagamento_pk"=>$query[$i]['metodos_pagamento_pk'],
                    "t_ds_metodo_pagamento"=>$query[$i]['ds_metodo_pagamento'],
                    "t_ds_conta_bancaria"=>$query[$i]['ds_conta_bancaria'],
                    "t_ds_tipo_operacao"=>$query[$i]['ds_tipo_operacao'],
                    "t_empresas_pk"=>$query[$i]['empresas_pk'],
                    "t_ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centro_custo_pk"=>$query[$i]['grupo_lancamento_centro_custo_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "dt_faturamento"=>$query[$i]['dt_faturamento'],
                    "t_ds_recebido_de"=>$ds_recebido_de,
                    "t_vl_total"=>$vl_total,
                    "t_ds_recebido_de_centro_custo"=>$ds_recebido_de_centro_custo,

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    
    
     //Leads
    case 'listaItensGrupoLeads':{
                       
        $resultado = "";
        $query = $lancamentodao->listaItensGrupoLeads($tipo_grupo_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_lead"=>$query[$i]['ds_lead']
                );
            }
        }else{
            $mysql_data = [];
        }		
        break;
    }
    
    //Colaboradores
    case 'listaItensGrupoColaboradores':{
                       
        $resultado = "";
        $query = $lancamentodao->listaItensGrupoColaboradores($tipo_grupo_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_colaborador"=>$query[$i]['ds_colaborador']." - CPF ".$query[$i]['ds_cpf']
                );
            }
        }else{
            $mysql_data = [];
        }		
        break;
    }
    
    //fornecedores
    case 'listaItensGrupoFornecedores':{
                       
        $resultado = "";
        $query = $lancamentodao->listaItensGrupoFornecedores($tipo_grupo_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_fornecedor"=>$query[$i]['ds_fornecedor']
                );
            }
        }else{
            $mysql_data = [];
        }		
        break;
    }



    case 'relLancamentoPlanoConta':{
        $dt_vencimento_ini = $_REQUEST['dt_vencimento_ini'];
        $dt_vencimento_fim = $_REQUEST['dt_vencimento_fim'];
        $tipos_operacao_pk_receita = $_REQUEST['tipos_operacao_pk_receita'];

        $resultado = "";
        $query = $lancamentodao->relLancamentoPlanoConta($dt_vencimento_ini,$dt_vencimento_fim,$tipos_operacao_pk_receita);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                
                $mysql_data[] = array(
                    "ds_tipo_operacao" => $query[$i]["ds_tipo_operacao"],
                    "DadosLinha"=>$query[$i]['DadosLinha'],
                    "VlTotal"=>number_format($query[$i]['VlTotal'], 2, ',', '.')                                     
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

$lancamentodao = null;

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
