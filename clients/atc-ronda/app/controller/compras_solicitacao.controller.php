<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/compras_solicitacao.dao.php";
require_once "../model/compras_solicitacao.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$solicitante_pk = $arrRequest['solicitante_pk'];
$ds_compra_solicitacao = $arrRequest['ds_compra_solicitacao'];
$dt_solicitacao = $arrRequest['dt_solicitacao'];
$obs_solicitacao = $arrRequest['obs_solicitacao'];
$usuario_aprovacao_pk = $arrRequest['usuario_aprovacao_pk'];
$dt_aprovacao = $arrRequest['dt_aprovacao'];
$obs_aprovacao = $arrRequest['obs_aprovacao'];
$tipo_grupo_centro_custo_pk = $arrRequest['tipo_grupo_centro_custo_pk'];
$grupo_lancamento_centrocusto_pk = $arrRequest['grupo_lancamento_centrocusto_pk'];
$empresas_pk = $arrRequest['empresas_pk'];

$compras_solicitacaodao = new compras_solicitacaodao();
$compras_solicitacaodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $compras_solicitacao = $compras_solicitacaodao->carregarPorPk($pk);
        if($compras_solicitacao->getpk()>0){
            
            $compras_solicitacaodao->excluir($compras_solicitacao);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'compras_solicitacao nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $compras_solicitacao = $compras_solicitacaodao->carregarPorPk($pk);
        $compras_solicitacao->setsolicitante_pk($solicitante_pk);
        $compras_solicitacao->setds_compra_solicitacao($ds_compra_solicitacao);
        $compras_solicitacao->setdt_solicitacao($dt_solicitacao);
        $compras_solicitacao->setobs_solicitacao($obs_solicitacao);
        $compras_solicitacao->setusuario_aprovacao_pk($usuario_aprovacao_pk);
        $compras_solicitacao->setdt_aprovacao($dt_aprovacao);
        $compras_solicitacao->setobs_aprovacao($obs_aprovacao);
        $compras_solicitacao->settipo_grupo_centro_custo_pk($tipo_grupo_centro_custo_pk);
        $compras_solicitacao->setgrupo_lancamento_centrocusto_pk($grupo_lancamento_centrocusto_pk);
        $compras_solicitacao->setempresas_pk($empresas_pk);

        $pk = $compras_solicitacaodao->salvar($compras_solicitacao);
                      
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $compras_solicitacaodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "empresas_pk"=>$query[$i]['empresas_pk'],
                    "solicitante_pk"=>$query[$i]['solicitante_pk'],
                    "ds_compra_solicitacao"=>$query[$i]['ds_compra_solicitacao'],
                    "dt_solicitacao"=>$query[$i]['dt_solicitacao'],
                    "obs_solicitacao"=>$query[$i]['obs_solicitacao'],
                    "usuario_aprovacao_pk"=>$query[$i]['usuario_aprovacao_pk'],
                    "dt_aprovacao"=>$query[$i]['dt_aprovacao'],
                    "obs_aprovacao"=>$query[$i]['obs_aprovacao'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centrocusto_pk"=>$query[$i]['grupo_lancamento_centrocusto_pk']
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
        $query = $compras_solicitacaodao->listar_por_solicitante_pk($solicitante_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "solicitante_pk"=>$query[$i]['solicitante_pk'],
                    "ds_compra_solicitacao"=>$query[$i]['ds_compra_solicitacao'],
                    "dt_solicitacao"=>$query[$i]['dt_solicitacao'],
                    "obs_solicitacao"=>$query[$i]['obs_solicitacao'],
                    "usuario_aprovacao_pk"=>$query[$i]['usuario_aprovacao_pk'],
                    "dt_aprovacao"=>$query[$i]['dt_aprovacao'],
                    "obs_aprovacao"=>$query[$i]['obs_aprovacao'],
                    "tipo_grupo_centro_custo_pk"=>$query[$i]['tipo_grupo_centro_custo_pk'],
                    "grupo_lancamento_centrocusto_pk"=>$query[$i]['grupo_lancamento_centrocusto_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{        
        
        $empresa_pk = $_REQUEST['empresa_pk'];
        $solicitante_pk = $_REQUEST['solicitante_pk'];
        $usuario_aprovacao_pk = $_REQUEST['usuario_aprovacao_pk'];
        $tipo_grupo_centro_custo_pk = $_REQUEST['tipo_grupo_centro_custo_pk'];
        $grupo_lancamento_centrocusto_pk = $_REQUEST['grupo_lancamento_centrocusto_pk'];
        $ic_status = $_REQUEST['ic_status'];
        $dt_solicitacao_ini = $_REQUEST['dt_solicitacao_ini'];
        $dt_solicitacao_fim = $_REQUEST['dt_solicitacao_fim'];
        $dt_aprovacao_ini = $_REQUEST['dt_aprovacao_ini'];
        $dt_aprovacao_fim = $_REQUEST['dt_aprovacao_fim'];
        
        $resultado = "";
        $query = $compras_solicitacaodao->listar_por_solicitante_pk($empresa_pk,$solicitante_pk,$usuario_aprovacao_pk,$tipo_grupo_centro_custo_pk,$grupo_lancamento_centrocusto_pk,$ic_status,$dt_solicitacao_ini,$dt_solicitacao_fim,$dt_aprovacao_ini,$dt_aprovacao_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){                      
            for($i = 0; $i < count($query); $i++){
         
                $query0 = $compras_solicitacaodao->listarCentroCusto($query[$i]['pk'],$query[$i]['tipo_grupo_centro_custo_pk'],$query[$i]['grupo_lancamento_centrocusto_pk']);

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_empresa"=>$query[$i]['ds_empresa'],
                    "t_ds_solicitante"=>$query[$i]['ds_solicitante'],
                    "t_ds_compra_solicitacao"=>$query[$i]['ds_compra_solicitacao'],
                    "t_dt_solicitacao"=>$query[$i]['dt_solicitacao'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_ds_usuario_aprovacao"=>$query[$i]['ds_usuario_aprovacao'],
                    "t_dt_aprovacao"=>$query[$i]['dt_aprovacao'],   
                    "t_ds_tipo_grupo_centro_custo"=>$query[$i]['ds_tipo_grupo_centro_custo'],
                    "t_ds_grupo_lancamento_centrocusto"=>$query0[0]['ds_grupo_lancamento_centrocusto'],
                    "t_solicitante_pk"=>$query[$i]['solicitante_pk'],
                    "t_usuario_aprovacao_pk"=>$query[$i]['usuario_aprovacao_pk'],                    
                    
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

$compras_solicitacaodao = null;

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
