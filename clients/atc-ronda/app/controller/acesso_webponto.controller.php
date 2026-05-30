<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";

require_once "../model/usuario.dao.php";
require_once "../model/usuario.class.php";

include_once "../model/conta.dao.php";
include_once "../model/conta.class.php";

require_once "../model/lead.dao.php";
require_once "../model/lead.class.php";

require_once "../model/colaborador.dao.php";
require_once "../model/colaborador.class.php";

require_once "../model/solicitacao_liberacao_app.dao.php";
require_once "../model/solicitacao_liberacao_app.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];

//Dados Usuario App Acesso
$ds_usuario = $arrRequest['ds_usuario'];
$ds_login = $arrRequest['ds_login'];
$ds_senha = $arrRequest['ds_senha'];

//Dados Conta CLiente
$contas_pk = $arrRequest['contas_pk'];
$id_cliente = $arrRequest['id_cliente'];
$ds_pin=$arrRequest['ds_pin'];

//Dados Colaborador
$colaborador_pk = $arrRequest['colaborador_pk'];
$ds_imagem = $arrRequest['ds_imagem'];
$ds_aparelho = $arrRequest['ds_aparelho'];
$dt_solit_liberacao = $arrRequest['dt_solit_liberacao'];

$usuariodao = new usuariodao();
$usuariodao->setToken($token);

$colaboradordao = new colaboradordao();
$colaboradordao->setToken($token);

$solicitacao_liberacao_appdao = new solicitacao_liberacao_appdao();
$solicitacao_liberacao_appdao->setToken($token); 


switch($job){
   
    case 'webPontoIdeintificaColaborador':{
        $resultado = "";
        $query = $colaboradordao->webPontoIdeintificaColaborador($colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "colaborador_pk" => $query[$i]["colaborador_pk"],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],                    
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "ds_pin"=>$query[$i]['ds_pin'],
                    "cliente_pk"=>$query[$i]['cliente_pk'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_cpf_cnpj"=>$query[$i]['id_cliente'],
                    "ic_status_solicitacao_app"=>$query[$i]['ic_status_solicitacao_app'],
                );
            }
        }else{
            $mysql_data = [];
        }	
        break;
    } 

    case 'webPontoCadSolicitacaoLiberacaoAcessoApp':{

        $solicitacao_liberacao_app = $solicitacao_liberacao_appdao->carregarPorPk($pk);
        $solicitacao_liberacao_app->setds_pin($ds_pin);
        $solicitacao_liberacao_app->setcolaborador_pk($colaborador_pk);
        $solicitacao_liberacao_app->setid_cliente($id_cliente);
        $solicitacao_liberacao_app->setds_imagem($ds_imagem);
        $solicitacao_liberacao_app->setdt_solit_liberacao($dt_solit_liberacao);
        $solicitacao_liberacao_app->setds_aparelho($ds_aparelho);
        $solicitacao_liberacao_app->setdt_liberacao($dt_liberacao);
        $solicitacao_liberacao_app->setusuario_aprovacao_pk($usuario_aprovacao_pk);
        $solicitacao_liberacao_app->setobs($obs);
        $solicitacao_liberacao_app->setic_status($ic_status);

        $pk = $solicitacao_liberacao_appdao->salvar($solicitacao_liberacao_app);
        
        if(!empty($pk)){
            $mysql_data[] = array(
                "status" =>'1' 
            );
            $result  = 'true';
            $message = 'Nova cadastro registrado com sucesso!';        
        
        }else{
            $mysql_data[] = array(
                "status" =>'2' 
            );
            $result  = 'false';
            $message = 'O processo não foi finalizado feche o App e realize o cadastro novamente';     
        } 
        
        break;
    } 
  
    default:{
        break;
    }
}

$produto_servicodao = null;

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
