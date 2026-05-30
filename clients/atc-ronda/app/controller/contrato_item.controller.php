<?
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/contrato_item.dao.php";
require_once "../model/contrato_item.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$n_qtde = $arrRequest['n_qtde'];
$vl_unit = $arrRequest['vl_unit'];
$vl_total = $arrRequest['vl_total'];
$contratos_pk = $arrRequest['contratos_pk'];
$produtos_servicos_pk = $arrRequest['produtos_servicos_pk'];
$n_qtde_dias_semana = $arrRequest['n_qtde_dias_semana'];
$periodo = $arrRequest['periodo'];
$vl_mao_obra = $arrRequest['vl_mao_obra'];

$contrato_itemdao = new contrato_itemdao();
$contrato_itemdao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){
    case 'excluir':{        
        $resultdo = "";        
        $contrato_item = $contrato_itemdao->carregarPorPk($pk);
               
        if($contrato_item->getpk()>0){            
            $log_exclusaodao->salvar("contratos_itens",$contrato_item->getpk());            
            $contrato_itemdao->excluir($contrato_item);            
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'contrato_item nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $contrato_item = $contrato_itemdao->carregarPorPk($pk);
        $contrato_item->setn_qtde($n_qtde);
        $contrato_item->setvl_unit($vl_unit);
        $contrato_item->setvl_total($vl_total);
        $contrato_item->setcontratos_pk($contratos_pk);
        $contrato_item->setprodutos_servicos_pk($produtos_servicos_pk);
        $contrato_item->setn_qtde_dias_semana($n_qtde_dias_semana);
        $contrato_item->setperiodo($periodo);
        $contrato_item->setvl_mao_obra($vl_mao_obra);

        
        $pk = $contrato_itemdao->salvar($contrato_item);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    
    //NOVO
     case 'listarItensEscala':{        
        $resultado = "";
        $query = $contrato_itemdao->listarItensEscala($contratos_pk,$produtos_servicos_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_n_qtde"=>$query[$i]['n_qtde'],
                    "t_n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],                 
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
    
   //VERIFICA SE A QUANTIDADE CONTRATADA NÃO ESTA SENDO EXCEDIDA NA ESCALA    
    case 'verificaServidoQtdeEscala':{
        $contratos_pk = $_REQUEST['contratos_pk'];
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];
        
        
        $qtde_servico_item_contrato = 0;
        $dias_escala = "";
        
        //Pefa a quantida de serviços no contrato
        $query = $contrato_itemdao->listarItensEscala($contratos_pk,$produtos_servicos_pk);        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){            
                  $qtde_servico_item_contrato +=  $query[$i]["n_qtde"];
                  $dias_escala = $query[$i]["n_qtde_dias_semana"];
            }
        }
        
        $query0 = $contrato_itemdao->verificaServidoQtdeEscala($contratos_pk,$produtos_servicos_pk);
        
        if(count($query0) > 0){
            for($i = 0; $i < count($query0); $i++){

                $mysql_data[] = array(
                    "qtde_servico_escala" => $query0[$i]["qtde_servico_escala"]+1,
                    "qtde_servico_item_contrato" => $qtde_servico_item_contrato,
                    "dias_escala" =>$dias_escala
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
    
    case 'listarContratosItemPK':{     
              
        
        $resultado = "";
        $query = $contrato_itemdao->listarContratosItemPK($contratos_pk,$produtos_servicos_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "contratos_itens_pk" => $query[$i]["pk"],
                    "n_qtde_dias_semana" => $query[$i]["n_qtde_dias_semana"]    
                        
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
    
    
    //ANTIGO
    case 'listarPk':{        
        $resultado = "";
        $query = $contrato_itemdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "n_qtde"=>$query[$i]['n_qtde'],
                    "vl_unit"=>$query[$i]['vl_unit'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "periodo"=>$query[$i]['periodo'],
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk']
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
        $query = $contrato_itemdao->listar_por_n_qtde($n_qtde);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "n_qtde"=>$query[$i]['n_qtde'],
                    "vl_unit"=>$query[$i]['vl_unit'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "periodo"=>$query[$i]['periodo'],
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk']
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
        $query = $contrato_itemdao->listar_por_n_qtde($n_qtde);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_n_qtde"=>$query[$i]['n_qtde'],
                    "t_vl_unit"=>$query[$i]['vl_unit'],
                    "t_vl_total"=>$query[$i]['vl_total'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "t_periodo"=>$query[$i]['periodo'],
                    "t_produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarContratoItem':{

        $resultado = "";
        if($contratos_pk!=""){
            $query = $contrato_itemdao->listarContratoItem($contratos_pk);
        }
        else{
            $mysql_data = [];
        }
        
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_n_qtde"=>$query[$i]['n_qtde'],
                    "t_vl_unit"=>number_format($query[$i]['vl_unit'],2,',','.'),
                    "t_vl_total"=>number_format($query[$i]['vl_total'],2,',','.'),
                    "vl_mao_obra"=>number_format($query[$i]['vl_mao_obra'],2,',','.'),
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_periodo"=>$query[$i]['periodo'],
                    "t_produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],

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

$contrato_itemdao = null;

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
