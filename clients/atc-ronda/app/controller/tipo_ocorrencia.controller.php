<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/tipo_ocorrencia.dao.php";
require_once "../model/tipo_ocorrencia.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_tipo_ocorrencia = $arrRequest['ds_tipo_ocorrencia'];
$ic_fechar_ocorrencia_auto = $arrRequest['ic_fechar_ocorrencia_auto'];


$tipo_ocorrenciadao = new tipo_ocorrenciadao();
$tipo_ocorrenciadao->setToken($token); 

switch($job){

    case 'excluir':{

        $resultdo = "";
        
        $tipo_ocorrencia = $tipo_ocorrenciadao->carregarPorPk($pk);
        if($tipo_ocorrencia->getpk()>0){
            
            $tipo_ocorrenciadao->excluir($tipo_ocorrencia);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'tipo_ocorrencia nao encontrado';
        }
        break;
    }
    case 'salvar':{
        if($pk!=""){
            $ic_acao = "upd";
        }
        else{
            $ic_acao = "ins";
        }

        $tipo_ocorrencia = $tipo_ocorrenciadao->carregarPorPk($pk);
        $tipo_ocorrencia->setds_tipo_ocorrencia($ds_tipo_ocorrencia);
        $tipo_ocorrencia->setic_fechar_ocorrencia_auto($ic_fechar_ocorrencia_auto);

        
        $pk = $tipo_ocorrenciadao->salvar($tipo_ocorrencia);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{

        $resultado = "";
        $query = $tipo_ocorrenciadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "ic_fechar_ocorrencia_auto"=>$query[$i]['ic_fechar_ocorrencia_auto']
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
        $query = $tipo_ocorrenciadao->listar_por_ds_tipo_ocorrencia($ds_tipo_ocorrencia,$ic_fechar_ocorrencia_auto);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "ic_fechar_ocorrencia_auto"=>$query[$i]['ic_fechar_ocorrencia_auto']
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
        $query = $tipo_ocorrenciadao->listar_por_ds_tipo_ocorrencia($ds_tipo_ocorrencia,$ic_fechar_ocorrencia_auto);

        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "t_ic_fechar_ocorrencia_auto"=>$query[$i]['ic_fechar_ocorrencia_auto'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }        
		
        break;
    }    
    case 'retornarDadosPreeenchimento':{
    
        $resultado = "";
        $query = $tipo_ocorrenciadao->retornarDadosPreeenchimento($pk);

        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
 
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_classificacao_lead_pk"=>$query[$i]['classificacao_lead_pk'],
                    "t_ds_texto_fixo_oc"=>$query[$i]['ds_texto_fixo_oc'],

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

$tipo_ocorrenciadao = null;

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
