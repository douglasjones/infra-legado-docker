<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/frota_checklist_itens.dao.php";
require_once "../model/frota_checklist_itens.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$frota_checklist_pk = $arrRequest['frota_checklist_pk'];
$auditoria_categorias_itens_pk = $arrRequest['auditoria_categorias_itens_pk'];
$ds_resultado_dados = $arrRequest['ds_resultado_dados'];
$ds_resultado_textarea = $arrRequest['ds_resultado_textarea'];
$auditorias_categoria_itens_dados_pk = $arrRequest['auditorias_categoria_itens_dados_pk'];
$ic_checkbox = $arrRequest['ic_checkbox'];


$frota_checklist_itensdao = new frota_checklist_itensdao();
$frota_checklist_itensdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $frota_checklist_itens = $frota_checklist_itensdao->carregarPorPk($pk);
        if($frota_checklist_itens->getpk()>0){
            
            $frota_checklist_itensdao->excluir($frota_checklist_itens);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'frota_checklist_itens nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $frota_checklist_itens = $frota_checklist_itensdao->carregarPorPk($pk);
        $frota_checklist_itens->setfrota_checklist_pk($frota_checklist_pk);
        $frota_checklist_itens->setauditoria_categorias_itens_pk($auditoria_categorias_itens_pk);
        $frota_checklist_itens->setds_resultado_dados($ds_resultado_dados);
        $frota_checklist_itens->setds_resultado_textarea($ds_resultado_textarea);
        $frota_checklist_itens->setauditorias_categoria_itens_dados_pk($auditorias_categoria_itens_dados_pk);
        $frota_checklist_itens->setic_checkbox($ic_checkbox);

        
        $pk = $frota_checklist_itensdao->salvar($frota_checklist_itens);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $frota_checklist_itensdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "frota_checklist_pk"=>$query[$i]['frota_checklist_pk'],
                    "auditoria_categorias_itens_pk"=>$query[$i]['auditoria_categorias_itens_pk'],
                    "ds_resultado_dados"=>$query[$i]['ds_resultado_dados'],
                    "ds_resultado_textarea"=>$query[$i]['ds_resultado_textarea'],
                    "auditorias_categoria_itens_dados_pk"=>$query[$i]['auditorias_categoria_itens_dados_pk'],
                    "ic_checkbox"=>$query[$i]['ic_checkbox']
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
        $query = $frota_checklist_itensdao->listar_por_frota_checklist_pk($frota_checklist_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "frota_checklist_pk"=>$query[$i]['frota_checklist_pk'],
                    "auditoria_categorias_itens_pk"=>$query[$i]['auditoria_categorias_itens_pk'],
                    "ds_resultado_dados"=>$query[$i]['ds_resultado_dados'],
                    "ds_resultado_textarea"=>$query[$i]['ds_resultado_textarea'],
                    "auditorias_categoria_itens_dados_pk"=>$query[$i]['auditorias_categoria_itens_dados_pk'],
                    "ic_checkbox"=>$query[$i]['ic_checkbox']
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
        $query = $frota_checklist_itensdao->listar_por_frota_checklist_pk($frota_checklist_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_frota_checklist_pk"=>$query[$i]['frota_checklist_pk'],
                    "t_auditoria_categorias_itens_pk"=>$query[$i]['auditoria_categorias_itens_pk'],
                    "t_ds_resultado_dados"=>$query[$i]['ds_resultado_dados'],
                    "t_ds_resultado_textarea"=>$query[$i]['ds_resultado_textarea'],
                    "t_auditorias_categoria_itens_dados_pk"=>$query[$i]['auditorias_categoria_itens_dados_pk'],
                    "t_ic_checkbox"=>$query[$i]['ic_checkbox'],

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

$frota_checklist_itensdao = null;

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
