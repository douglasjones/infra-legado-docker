<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/apontamento_servico_extra.dao.php";
require_once "../model/apontamento_servico_extra.class.php";

require_once "../model/lancamento.dao.php";
require_once "../model/lancamento.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$dt_escala = $arrRequest['dt_escala'];
$leads_pk = $arrRequest['leads_pk'];
$contratos_pk = $arrRequest['contratos_pk'];
$contratos_itens_pk = $arrRequest['contratos_itens_pk'];
$StrServicoExtra = $arrRequest['StrServicoExtra'];


$apontamento_servico_extradao = new apontamento_servico_extradao();
$apontamento_servico_extradao->setToken($token); 

$lancamentodao = new lancamentodao();
$lancamentodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $apontamento_servico_extra = $apontamento_servico_extradao->carregarPorPk($pk);
        if($apontamento_servico_extra->getpk()>0){
            
            $apontamento_servico_extradao->excluir($apontamento_servico_extra);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'apontamento_servico_extra nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        
        
        if($StrServicoExtra != "")
            $arrContratoServicoExtra = json_decode($StrServicoExtra, true);
        
  
        
        if(count($arrContratoServicoExtra) > 0){
          
            for($i = 0; $i < count($arrContratoServicoExtra); $i++){
                
                if($arrContratoServicoExtra[$i]['check']==1){
                    $apontamento_servico_extra = $apontamento_servico_extradao->carregarPorPk(0);
                    $apontamento_servico_extra->setcolaborador_pk($colaborador_pk);
                    $apontamento_servico_extra->setdt_escala(DataYMD($dt_escala));
                    $apontamento_servico_extra->setleads_pk($leads_pk);
                    $apontamento_servico_extra->setcontratos_pk($arrContratoServicoExtra[$i]['contratos_pk']);
                    $apontamento_servico_extra->setcontratos_itens_pk($arrContratoServicoExtra[$i]['contratos_itens_pk']);


                    $pk = $apontamento_servico_extradao->salvar($apontamento_servico_extra);
                
                    
                    $query = $apontamento_servico_extradao->listarContratos($arrContratoServicoExtra[$i]['contratos_pk']);
                    
                    $conta_bancaria_pk = $lancamentodao->listaContaEmpresa($query[0]['empresas_pk']);
                    
                    
                    
                    
                    
                    
                    $lancamento = $lancamentodao->carregarPorPk("");
                    $lancamento->setoperacao_pk(3);
                    $lancamento->settipos_operacao_pk(1021);
                    $lancamento->setempresas_pk($query[0]['empresas_pk']);
                    $lancamento->setcontas_bancarias_pk($conta_bancaria_pk[0]['pk']);
                    $lancamento->setds_lancamento("Mão Obra");
                    $lancamento->settipo_grupo_pk(2);
                    $lancamento->settipo_grupo_centro_custo_pk(1);
                    $lancamento->setmetodos_pagamento_pk(5);
                    $lancamento->setgrupo_leancamento_pk($colaborador_pk);
                    $lancamento->setgrupo_lancamento_centro_custo_pk($leads_pk);
                    
                    $lancamento->setvl_lancamento($arrContratoServicoExtra[$i]['vl_total_mao_obra']);
                    $lancamento->setdt_vencimento($arrContratoServicoExtra[$i]['dt_faturamento']);



                    $lancamento->setic_status_pagamento(2);
                    $lancamento->setcompras_pk($compras_pk);
                    $lancamento->setcontratos_pk($arrContratoServicoExtra[$i]['contratos_pk']);
                    
                    $lancamentos_pk = $lancamentodao->salvar($lancamento);
                    
                    
                    
                    
                    
                    
                    
                }
                
                
                
            }
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
        $query = $apontamento_servico_extradao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk']
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
        $query = $apontamento_servico_extradao->listar_por_colaborador_pk($colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk']
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
        $query = $apontamento_servico_extradao->listar_por_colaborador_pk($colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_dt_escala"=>$query[$i]['dt_escala'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarServicoExtra':{
        
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_base = $_REQUEST['dt_base'];
        $resultado = "";
        $query = $apontamento_servico_extradao->listarServicoExtra($colaborador_pk,$leads_pk,$dt_base);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "dt_escala"=>$query[$i]['dt_escala'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    
    case 'listarLeadComServicoExtra':{
        
        $leads_pk = $_REQUEST['leads_pk'];
        $resultado = "";
        $query = $apontamento_servico_extradao->listarLeadComServicoExtra($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                
                
                //$querya = $apontamento_servico_extradao->verificarApontamento($query[$i]['contratos_pk'],$query[$i]['contratos_itens_pk']);
                //if($querya[0]['total']==0){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "ds_lead"=>$query[$i]['ds_lead']
                    );
                /*}
                else{
                    $mysql_data = [];
                }*/
                
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarContratosItensApontamento':{
        
        $leads_pk = $_REQUEST['leads_pk'];
        $resultado = "";
        $query = $apontamento_servico_extradao->listarContratosItensApontamento($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                
            $querya = $apontamento_servico_extradao->verificarApontamento($query[$i]['contratos_pk'],$query[$i]['contratos_itens_pk']);
            
            
            
                if($querya[0]['total']==0){
                    $mysql_data[] = array(
                        "contratos_pk" => $query[$i]["contratos_pk"],
                        "n_qtde"=>$query[$i]['n_qtde'],
                        "contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                        "periodo"=>$query[$i]['periodo'],
                        "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                        "ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                        "vl_unit"=>number_format($query[$i]['vl_unit'],2,',','.'),
                        "vl_total"=>number_format($query[$i]['vl_total'],2,',','.'),
                        "vl_mao_obra"=>number_format($query[$i]['vl_mao_obra'],2,',','.')
                    );
                }
                
                
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

$apontamento_servico_extradao = null;

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
