<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/supervisao_auditorias_itens.dao.php";
require_once "../model/supervisao_auditorias_itens.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$supervisao_auditorias_pk = $arrRequest['supervisao_auditorias_pk'];
$auditoria_categorias_itens_pk = $arrRequest['auditoria_categorias_itens_pk'];
$ds_resultado_dados = $arrRequest['ds_resultado_dados'];
$ds_resultado_textarea = $arrRequest['ds_resultado_textarea'];
$JSONinfoSupervisao = $arrRequest['JSONinfoSupervisao'];
$auditoria_categoria_tipos_pk = $arrRequest['auditoria_categoria_tipos_pk'];


$supervisao_auditorias_itensdao = new supervisao_auditorias_itensdao();
$supervisao_auditorias_itensdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $supervisao_auditorias_itens = $supervisao_auditorias_itensdao->carregarPorPk($pk);
        if($supervisao_auditorias_itens->getpk()>0){
            
            $supervisao_auditorias_itensdao->excluir($supervisao_auditorias_itens);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'supervisao_auditorias_itens nao encontrado';
        }
        break;
    }
    case 'salvar':{

        $supervisao_auditorias_itens = $supervisao_auditorias_itensdao->carregarPorPk($pk);
        $pk = $supervisao_auditorias_itensdao->salvar($supervisao_auditorias_itens, $JSONinfoSupervisao);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $supervisao_auditorias_itensdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "supervisao_auditorias_pk"=>$query[$i]['supervisao_auditorias_pk'],
                    "auditoria_categorias_itens_pk"=>$query[$i]['auditoria_categorias_itens_pk'],
                    "ds_resultado_dados"=>$query[$i]['ds_resultado_dados'],
                    "ds_resultado_textarea"=>$query[$i]['ds_resultado_textarea']
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
    case 'listarValoresCamposForm':{
        
        $resultado = "";
        $query = $supervisao_auditorias_itensdao->listarValoresCamposForm($supervisao_auditorias_pk, $auditoria_categoria_tipos_pk);
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_categoria_item"=>$query[$i]['ds_categoria_item'],
                    "tipo_item_pk"=>$query[$i]['tipo_item_pk'],
                    "ds_tipo_item"=>$query[$i]['ds_tipo_item'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "auditorias_categorias_pk"=>$query[$i]['auditorias_categorias_pk'],
                    "auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "ic_obrigatorio"=>$query[$i]['ic_obrigatorio'],
                    "itensDados"=>$query[$i]['itensDados'],
                    "supervisaoAuditoriasItens"=>$query[$i]['supervisaoAuditoriasItens'],
                    "ds_ic_obrigatorio"=>$query[$i]['ds_ic_obrigatorio']
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
        $query = $supervisao_auditorias_itensdao->listar_por_supervisao_auditorias_pk($supervisao_auditorias_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "supervisao_auditorias_pk"=>$query[$i]['supervisao_auditorias_pk'],
                    "auditoria_categorias_itens_pk"=>$query[$i]['auditoria_categorias_itens_pk'],
                    "ds_resultado_dados"=>$query[$i]['ds_resultado_dados'],
                    "ds_resultado_textarea"=>$query[$i]['ds_resultado_textarea']
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
        $query = $supervisao_auditorias_itensdao->listar_por_supervisao_auditorias_pk($supervisao_auditorias_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_supervisao_auditorias_pk"=>$query[$i]['supervisao_auditorias_pk'],
                    "t_auditoria_categorias_itens_pk"=>$query[$i]['auditoria_categorias_itens_pk'],
                    "t_ds_resultado_dados"=>$query[$i]['ds_resultado_dados'],
                    "t_ds_resultado_textarea"=>$query[$i]['ds_resultado_textarea'],

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

$supervisao_auditorias_itensdao = null;

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