<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/fatura.dao.php";
require_once "../model/fatura.class.php";
require_once "../model/itens_fatura.dao.php";
require_once "../model/itens_fatura.class.php";
require_once "../model/lead_imposto.dao.php";
require_once "../model/lead_imposto.class.php";
//require_once "../model/log_exclusao.dao.php";
//require_once "../model/log_exclusao.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$leads_pk = $arrRequest['leads_pk'];
$dt_inicio_fatura = $arrRequest['dt_inicio_fatura'];
$dt_fim_fatura = $arrRequest['dt_fim_fatura'];
$vl_bruto_total = $arrRequest['vl_bruto_total'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$ds_descricao_cancelamento = $arrRequest['ds_descricao_cancelamento'];
$empresas_pk = $arrRequest['empresas_pk'];
$tipo_contrato_pk = $arrRequest['tipo_contrato_pk'];


$faturadao = new faturadao();
$faturadao->setToken($token); 

$itens_faturadao = new itens_faturadao();
$itens_faturadao->setToken($token); 

$lead_impostodao = new lead_impostodao();
$lead_impostodao->setToken($token); 

//$log_exclusaodao = new log_exclusaodao();
//$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $fatura = $faturadao->carregarPorPk($pk);
        if($fatura->getpk()>0){
            
            
            /*$pk_fatura_itens = $faturadao->listarPkItensFatura($fatura->getpk());
            
            if(count($pk_fatura_itens)>0){
                for($i=0;$i<count($pk_fatura_itens);$i++){
                    $log_exclusaodao->salvar("itens_fatura", $pk_fatura_itens[$i]['pk']);
                }
            }


            $log_exclusaodao->salvar("fatura",$fatura->getpk());*/
            
            
            $faturadao->excluirItens($fatura->getpk());
            $faturadao->excluir($fatura);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'fatura nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $fatura = $faturadao->carregarPorPk($pk);
        $fatura->setleads_pk($leads_pk);
        $fatura->setdt_inicio_fatura(DataYMD($dt_inicio_fatura));
        $fatura->setdt_fim_fatura(DataYMD($dt_fim_fatura));
        $fatura->setempresas_pk($empresas_pk);
        $fatura->settipo_contrato_pk($tipo_contrato_pk);

        
        $pk = $faturadao->salvar($fatura);
        
        
        
        
        $valor_servico_prestado = $faturadao->listarValorServicoPrestado($leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$empresas_pk);
     
        
        $arrQtdeFaltas = $faturadao->listarQtdeFalta($leads_pk,$dt_inicio_fatura,$dt_fim_fatura);
       
        //CALCULO DE VALOR DE FALTA (OBS)
        $valor_servico_falta = 0.00;
        if(count($valor_servico_prestado)> 0){
            if(count($arrQtdeFaltas)>0){
                $valor_servico_falta = ($valor_servico_prestado[0]['vl_total'] /30) *count($arrQtdeFaltas) ;
                
            }
            
        }
        
        //VALOR Material de Limpeza 
        $valor_meteriais_consumiveis = $faturadao->listarValorMateriaisConsumiveis($leads_pk,$dt_inicio_fatura,$dt_fim_fatura);
        if(count($valor_meteriais_consumiveis)> 0){
            if($valor_meteriais_consumiveis[0]['qtde']==""){
                $qtde = 1;
            }
            else{
                $qtde = $valor_meteriais_consumiveis[0]['qtde'];
            }

            $vl_materiais_consumiveis = $valor_meteriais_consumiveis[0]['vl_item'] * $qtde;
            $itens_fatura = $itens_faturadao->carregarPorPk(0);
            $itens_fatura->settipo_item_fatura(2);
            $itens_fatura->setvl_total($vl_materiais_consumiveis);
            $itens_fatura->setfatura_pk($pk);
            $itens_fatura_pk1 = $itens_faturadao->salvar($itens_fatura);
           
           
        }
        
       
        if($tipo_contrato_pk==1){
            //VALOR Serviço de Conservação e limpeza
            if(count($valor_servico_prestado)> 0){

                $valor_servico_concervacao_limpeza = $valor_servico_prestado[0]['vl_total'] - $vl_materiais_consumiveis - $valor_servico_falta;

                if($valor_servico_concervacao_limpeza>0){
                    $itens_fatura = $itens_faturadao->carregarPorPk(0);
                    $itens_fatura->settipo_item_fatura(1);
                    $itens_fatura->setvl_total($valor_servico_concervacao_limpeza);
                    $itens_fatura->setfatura_pk($pk);
                    $itens_fatura_pk1 = $itens_faturadao->salvar($itens_fatura);
                }        


            }
            
            //VALOR serviço extra SERVIÇO EXTRA TIPO 3
            $valor_servico_extra = $faturadao->listarValorServicoExtra($leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$empresas_pk);

            if(count($valor_servico_extra)> 0){
                for($i=0;$i<count($valor_servico_extra);$i++){
                    if($valor_servico_extra[$i]['vl_total'] > 0){
                        $itens_fatura = $itens_faturadao->carregarPorPk(0);
                        $itens_fatura->settipo_item_fatura(3);
                        $itens_fatura->setvl_total($valor_servico_extra[$i]['vl_total']);
                        $itens_fatura->setds_descricao($valor_servico_extra[$i]['ds_produto_servico']);
                        $itens_fatura->setfatura_pk($pk);
                        $itens_fatura_pk1 = $itens_faturadao->salvar($itens_fatura);


                        $valor_total_servico_extra += $valor_servico_extra[$i]['vl_total'];
                    }

                }
            }
        }
        else if($tipo_contrato_pk == 2){
             //VALOR serviço extra ADITIVO TIPO 2
            $valor_servico_extra_aditivo = $faturadao->listarValorServicoExtraAditivo($leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$empresas_pk);

            if(count($valor_servico_extra_aditivo)> 0){
                for($i=0;$i<count($valor_servico_extra_aditivo);$i++){
                    if($valor_servico_extra_aditivo[$i]['vl_total'] > 0){
                        $itens_fatura = $itens_faturadao->carregarPorPk(0);
                        $itens_fatura->settipo_item_fatura(3);
                        $itens_fatura->setvl_total($valor_servico_extra_aditivo[$i]['vl_total']);
                        $itens_fatura->setds_descricao($valor_servico_extra_aditivo[$i]['ds_produto_servico']);
                        $itens_fatura->setfatura_pk($pk);
                        $itens_fatura_pk1 = $itens_faturadao->salvar($itens_fatura);


                        $valor_total_servico_extra_tipo2 += $valor_servico_extra_aditivo[$i]['vl_total'];
                    }

                }

            }
        }
        else if ($tipo_contrato_pk==3){
            //VALOR serviço extra SERVIÇO EXTRA TIPO 3
            $valor_servico_extra = $faturadao->listarValorServicoExtra($leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$empresas_pk);

            if(count($valor_servico_extra)> 0){
                for($i=0;$i<count($valor_servico_extra);$i++){
                    if($valor_servico_extra[$i]['vl_total'] > 0){
                        $itens_fatura = $itens_faturadao->carregarPorPk(0);
                        $itens_fatura->settipo_item_fatura(3);
                        $itens_fatura->setvl_total($valor_servico_extra[$i]['vl_total']);
                        $itens_fatura->setds_descricao($valor_servico_extra[$i]['ds_produto_servico']);
                        $itens_fatura->setfatura_pk($pk);
                        $itens_fatura_pk1 = $itens_faturadao->salvar($itens_fatura);


                        $valor_total_servico_extra += $valor_servico_extra[$i]['vl_total'];
                    }

                }
            }
        }
        
    
        
        
      
        
       
       
       
        //VALOR Desconto
        $valor_desconto = $faturadao->listarValorDesconto($leads_pk,$dt_inicio_fatura,$dt_fim_fatura);
        
        if(count($valor_desconto)> 0){
             for($i=0;$i<count($valor_desconto);$i++){
                if($valor_desconto[$i]['vl_total']>0){
                    $itens_fatura = $itens_faturadao->carregarPorPk(0);
                    $itens_fatura->settipo_item_fatura(4);
                    $itens_fatura->setvl_total($valor_desconto[$i]['vl_total']);
                    $itens_fatura->setds_descricao($valor_desconto[$i]['ds_desconto']);
                    $itens_fatura->setfatura_pk($pk);
                    $itens_fatura_pk1 = $itens_faturadao->salvar($itens_fatura);

                    $valor_total_desconto += $valor_desconto[$i]['vl_total'];
                }
                
            }
           
        }

        //UPD VALOR BRUTO TOTAL
        $vl_bruto_total = ($valor_servico_concervacao_limpeza + $vl_materiais_consumiveis + $valor_total_servico_extra_tipo2 + $valor_total_servico_extra) - $valor_total_desconto;
        
   
        $fatura_upd = $faturadao->carregarPorPk($pk);
       
        $fatura_upd->setvl_bruto_total($vl_bruto_total);
        
        $fatura_upd->setvl_falta($valor_servico_falta);
        
        $fatura_upd->setqtde_falta(count($arrQtdeFaltas));
        
        
        $pk_upd = $faturadao->salvar($fatura_upd);
        
        
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'salvarDataCancelamento':{
        
        $fatura_upd = $faturadao->carregarPorPk($pk);
        
        $fatura_upd->setdt_cancelamento($dt_cancelamento);
        $fatura_upd->setds_descricao_cancelamento($ds_descricao_cancelamento);

        $pk_upd = $faturadao->salvar($fatura_upd);
        
        $mysql_data[] = array(
                "pk" => $pk_upd
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
        
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $faturadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "dt_inicio_fatura"=>$query[$i]['dt_inicio_fatura'],
                    "dt_fim_fatura"=>$query[$i]['dt_fim_fatura'],
                    "vl_bruto_total"=>$query[$i]['vl_bruto_total']
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
        $query = $faturadao->listar_por_leads_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "dt_inicio_fatura"=>$query[$i]['dt_inicio_fatura'],
                    "dt_fim_fatura"=>$query[$i]['dt_fim_fatura'],
                    "vl_bruto_total"=>$query[$i]['vl_bruto_total']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarGridFaturamento':{
        $empresas_pk = $_REQUEST['empresas_pk'];
        $resultado = "";
        $query = $faturadao->listarGridFaturamento($leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$empresas_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_tipo_contrato"=>$query[$i]['ds_tipo_contrato'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "periodo"=>$query[$i]['periodo'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "dt_inicio_fatura"=>$query[$i]['dt_inicio_fatura'],
                    "dt_fim_fatura"=>$query[$i]['dt_fim_fatura'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_descricao_cancelamento"=>$query[$i]['ds_descricao_cancelamento'],
                    "vl_bruto_total"=>$query[$i]['vl_bruto_total']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarPorLead':{
        
        $resultado = "";
        $query = $faturadao->listarPorLead($pk,$leads_pk,$dt_inicio_fatura,$dt_fim_fatura);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "periodo"=>$query[$i]['periodo'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_descricao"=>$query[$i]['ds_descricao'],
                    "tipo_item_fatura"=>$query[$i]['tipo_item_fatura'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "dt_inicio_fatura"=>$query[$i]['dt_inicio_fatura'],
                    "dt_fim_fatura"=>$query[$i]['dt_fim_fatura'],
                    "vl_falta"=>$query[$i]['vl_falta'],
                    "qtde_falta"=>$query[$i]['qtde_falta'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "vl_bruto_total"=>$query[$i]['vl_bruto_total']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'relatorioFatura':{
        $empresas_pk = $_REQUEST['empresas_pk'];
        $dt_inicio_fatura = $_REQUEST['dt_ini'];
        $dt_fim_fatura = $_REQUEST['dt_fim'];
        $leads_pk = $_REQUEST['leads_pk'];        
        $tipo_contrato_fixo = $_REQUEST['tipo_contrato_fixo'];
        $tipo_contrato_aditivo = $_REQUEST['tipo_contrato_aditivo'];
        $tipo_contrato_extra = $_REQUEST['tipo_contrato_extra'];
        $dt_ini_contrato = $_REQUEST['dt_ini_contrato'];
        $dt_fim_contrato = $_REQUEST['dt_fim_contrato'];
        $desconto_pk = $_REQUEST['desconto_pk'];

        $result  = 'success';
        $message = 'query success';
        
        $resultado = "";
        $query0 = $faturadao->relatorioLeadFatura($empresas_pk,$leads_pk,$dt_inicio_fatura,$dt_fim_fatura,$tipo_contrato_fixo,$tipo_contrato_aditivo,$tipo_contrato_extra,$dt_ini_contrato,$dt_fim_contrato,$desconto_pk);
        
        if(count($query0) > 0){
            for($j = 0; $j < count($query0); $j++){
                //PEGA TUDO RELACIONADO SEVIÇO  
                $query1 = $faturadao->relatorioFaturaTipoItem($query0[$j]['pk'],$empresas_pk,$query0[$j]['leads_pk'],$query0[$j]['dt_inicio_fatura'],$query0[$j]['dt_fim_fatura'],1);
                //MATERIAL DE LIMPEXA 
                $query2 = $faturadao->relatorioFaturaTipoItem($query0[$j]['pk'],$empresas_pk,$query0[$j]['leads_pk'],$query0[$j]['dt_inicio_fatura'],$query0[$j]['dt_fim_fatura'],2);
                //SERVIÇO EXTRA ADICONAIL
                $query3 = $faturadao->relatorioFaturaServiçoAdicional($query0[$j]['pk'],$empresas_pk,$query0[$j]['leads_pk'],$query0[$j]['dt_inicio_fatura'],$query0[$j]['dt_fim_fatura'],3);
                //DESCONTOS
                $query4 = $faturadao->relatorioFaturaTipoItem($query0[$j]['pk'],$empresas_pk,$query0[$j]['leads_pk'],$query0[$j]['dt_inicio_fatura'],$query0[$j]['dt_fim_fatura'],4);
                
                
                $queryImposto = $lead_impostodao->listarImpostoPorLead($query0[$j]['leads_pk'],$query0[$j]['dt_cadastro']);
                
                $valor_total= 0.00;
                
                $valor_total= $query0[$j]['vl_total'];
                
                $valor_inss= 0.00;
                $valor_issqn= 0.00;
                $valor_total_imposto= 0.00;
                $valor_servico = 0;
                $valor_servico = $query1[0]['vl_total'];
                
                if(count($queryImposto) > 0){
                     for($i=0;$i<count($queryImposto);$i++){
                        if($queryImposto[$i]['imposto_pk']==1){
                            if($queryImposto[$i]['ds_percentual_imposto']!=""){
                                if($valor_servico!=0){
                                     $valor_inss = ($valor_servico * $queryImposto[$i]['ds_percentual_imposto'])/100;
                                }
                                
                            }
                        }
                        if($queryImposto[$i]['imposto_pk']==2){
                            if($queryImposto[$i]['ds_percentual_imposto']!=""){
                                if($valor_servico!=0){
                                    $valor_issqn = ($valor_servico * $queryImposto[$i]['ds_percentual_imposto'])/100; 
                                }
                                
                            }
                        }
                     }
                }
                
                $valor_total_imposto = $valor_inss + $valor_issqn;
                
                $valor_total_a_pagar = 0.00;
                
                if($query4[0]['vl_total']!=0){
                    $valor_total_a_pagar = ($query0[$j]['vl_bruto_total'] + $query2[0]['vl_total']) - $valor_total_imposto;
                }
                else{
                    $valor_total_a_pagar = $query0[$j]['vl_bruto_total'] - $valor_total_imposto;
                }
                                       
                        
                $ds_empresa = $query0[$j]['ds_razao_social'];
                        
                        $mysql_data[] = array(
                            "pk" => $query0[$j]["pk"],
                            "ds_lead"=>$query0[$j]['ds_lead'],
                            "leads_pk"=>$query0[$j]['leads_pk'],
                            "periodo"=>$query0[$j]['periodo'],
                            "dt_cadastro"=>$query0[$j]['dt_cadastro'],
                            "ds_cpf_cnpj"=>$query0[$j]['ds_cpf_cnpj'],
                            "ds_descricao"=>$query0[$j]['ds_descricao'],
                            "ds_endereco"=>$query0[$j]['ds_endereco'],
                            "dt_vencimento"=>$query0[$j]['dt_vencimento'],
                            "dt_inicio_fatura"=>$query0[$j]['dt_inicio_fatura'],
                            "dt_fim_fatura"=>$query0[$j]['dt_fim_fatura'],
                            "vl_falta"=>$query0[$j]['vl_falta'],
                            "ds_descricao_cancelamento"=>$query0[$j]['ds_descricao_cancelamento'],
                            "dt_cancelamento"=>$query0[$j]['dt_cancelamento'],
                            "qtde_falta"=>$query0[$j]['qtde_falta'],
                            "ds_empresa"=>$ds_empresa,
                            "vl_bruto_total"=>$query0[$j]['vl_bruto_total'],
                            "vl_servico"=>$query1[0]['vl_total'],
                            "vl_material"=>$query2[0]['vl_total'],
                            "vl_servico_adicionais"=>$query3[0]['vl_total'],
                            "vl_desconto"=>$query4[0]['vl_total'],
                            "vl_total"=>$valor_total,
                            "valor_inss"=>$valor_inss,
                            "valor_issqn"=>$valor_issqn,
                            "valor_total_a_pagar"=>$valor_total_a_pagar,
                            "periodo_contrato"=>$query0[$j]['periodo_contrato'],
                                                        
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
        $query = $faturadao->listar_por_leads_pk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "dt_inicio_fatura"=>$query[$i]['dt_inicio_fatura'],
                    "dt_fim_fatura"=>$query[$i]['dt_fim_fatura'],
                    "t_vl_bruto_total"=>$query[$i]['vl_bruto_total'],

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

$faturadao = null;

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
