<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/solicitacao_liberacao_app.dao.php";
require_once "../model/solicitacao_liberacao_app.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_pin = $arrRequest['ds_pin'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$id_cliente = $arrRequest['id_cliente'];
$ds_imagem = $arrRequest['ds_imagem'];
$dt_solit_liberacao = $arrRequest['dt_solit_liberacao'];
$ds_aparelho = $arrRequest['ds_aparelho'];

$dt_liberacao = $arrRequest['dt_liberacao'];
$usuario_aprovacao_pk = $arrRequest['usuario_aprovacao_pk'];
$obs = $arrRequest['obs'];
$ic_status = $arrRequest['ic_status'];


$solicitacao_liberacao_appdao = new solicitacao_liberacao_appdao();
$solicitacao_liberacao_appdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $solicitacao_liberacao_app = $solicitacao_liberacao_appdao->carregarPorPk($pk);
        if($solicitacao_liberacao_app->getpk()>0){
            
            $solicitacao_liberacao_appdao->excluir($solicitacao_liberacao_app);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'solicitacao_liberacao_app nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $solicitacao_liberacao_app = $solicitacao_liberacao_appdao->carregarPorPk($pk);
        $solicitacao_liberacao_app->setds_pin($ds_pin);
        $solicitacao_liberacao_app->setcolaborador_pk($colaborador_pk);
        $solicitacao_liberacao_app->setid_cliente($id_cliente);
        $solicitacao_liberacao_app->setds_imagem($ds_imagem);
        $solicitacao_liberacao_app->setdt_solit_liberacao(DataYMD($dt_solit_liberacao));
        $solicitacao_liberacao_app->setds_aparelho($ds_aparelho);
        $solicitacao_liberacao_app->setdt_liberacao($dt_liberacao);
        $solicitacao_liberacao_app->setusuario_aprovacao_pk($usuario_aprovacao_pk);
        $solicitacao_liberacao_app->setobs($obs);
        $solicitacao_liberacao_app->setic_status($ic_status);
  
        $pk = $solicitacao_liberacao_appdao->salvar($solicitacao_liberacao_app);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'loginPontoApp':{  
 
        $resultado = "";

        $query = $solicitacao_liberacao_appdao->loginPontoApp($ds_pin,$colaborador_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_pin"=>$query[$i]['ds_pin'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "id_cliente"=>$query[$i]['id_cliente'],
                    "ds_imagem"=>$query[$i]['ds_imagem'],
                    "dt_solit_liberacao"=>$query[$i]['dt_solit_liberacao'],
                    "ds_aparelho"=>$query[$i]['ds_aparelho'],
                    "dt_liberacao"=>$query[$i]['dt_liberacao'],
                    "usuario_aprovacao_pk"=>$query[$i]['usuario_aprovacao_pk'],
                    "obs"=>$query[$i]['obs'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [ array(
               "pk" => 0 )
            ];
        }
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarPk':{        
        $resultado = "";
        $query = $solicitacao_liberacao_appdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_pin"=>$query[$i]['ds_pin'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "id_cliente"=>$query[$i]['id_cliente'],
                    "ds_imagem"=>$query[$i]['ds_imagem'],
                    "dt_solit_liberacao"=>$query[$i]['dt_solit_liberacao'],
                    "ds_aparelho"=>$query[$i]['ds_aparelho'],
                    "dt_liberacao"=>$query[$i]['dt_liberacao'],
                    "usuario_aprovacao_pk"=>$query[$i]['usuario_aprovacao_pk'],
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
        $query = $solicitacao_liberacao_appdao->listar_por_ds_pin($ds_pin);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_pin"=>$query[$i]['ds_pin'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "id_cliente"=>$query[$i]['id_cliente'],
                    "ds_imagem"=>$query[$i]['ds_imagem'],
                    "dt_solit_liberacao"=>$query[$i]['dt_solit_liberacao'],
                    "ds_aparelho"=>$query[$i]['ds_aparelho'],
                    "dt_liberacao"=>$query[$i]['dt_liberacao'],
                    "usuario_aprovacao_pk"=>$query[$i]['usuario_aprovacao_pk'],
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
    case 'listarQtdeRegistro':{
        
        $resultado = "";
        $query = $solicitacao_liberacao_appdao->listarQtdeRegistro($ic_status,$colaborador_pk,$dt_liberacao);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "qtde_registro" => $query[$i]["qtde_registro"]
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listar_solicitacoes':{
        
        $ds_re = $_REQUEST['ds_re'];
        
        $resultado = "";
        $query = $solicitacao_liberacao_appdao->listar_solicitacoes($colaborador_pk,$ds_pin,$ds_re,$ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                
                if(!empty($query[$i]['ds_imagem'])){
                    $img = "<img width=30 height=30 src='".$query[$i]['ds_imagem']."'>";
                }else{
                    $img = "";
                }
                                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_ds_pin"=>$query[$i]['ds_pin'],                    
                    "t_ds_re"=>$query[$i]['ds_re'],
                    "t_ds_imagem"=>$img,
                    "t_ds_link_imagem"=>$query[$i]['ds_imagem'],
                    "t_dt_solit_liberacao"=>$query[$i]['dt_solit_liberacao'],
                    "t_dt_liberacao"=>$query[$i]['dt_liberacao'],
                    "t_usuario_aprovacao_pk"=>$query[$i]['usuario_aprovacao_pk'],
                    "t_ds_usuario"=>$query[$i]['ds_usuario'],
                    "t_obs"=>$query[$i]['obs'],
                    "t_status"=>$query[$i]['status'],

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

$solicitacao_liberacao_appdao = null;

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
