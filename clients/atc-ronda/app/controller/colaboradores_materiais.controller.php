<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/colaboradores_materiais.dao.php";
require_once "../model/colaboradores_materiais.class.php";

require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$tipo_material_pk = $arrRequest['tipo_material_pk'];
$material_pk = $arrRequest['material_pk'];
$qtde_material = $arrRequest['qtde_material'];
$dt_entrega = $arrRequest['dt_entrega'];
$dt_devolucao = $arrRequest['dt_devolucao'];
$obs = $arrRequest['obs'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$conjunto_material_pk = $arrRequest['conjunto_material_pk'];


$colaboradores_materiaisdao = new colaboradores_materiaisdao();
$colaboradores_materiaisdao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $colaboradores_materiais = $colaboradores_materiaisdao->carregarPorPk($pk);
        if($colaboradores_materiais->getpk()>0){
            
            $log_exclusaodao->salvar("colaboradores_materiais",$colaboradores_materiais->getpk());
            
            $colaboradores_materiaisdao->excluir($colaboradores_materiais);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'colaboradores_materiais nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $colaboradores_materiais = $colaboradores_materiaisdao->carregarPorPk($pk);
        $colaboradores_materiais->settipo_material_pk($tipo_material_pk);
        $colaboradores_materiais->setmaterial_pk($material_pk);
        $colaboradores_materiais->setqtde_material($qtde_material);
        $colaboradores_materiais->setdt_entrega($dt_entrega);
        $colaboradores_materiais->setdt_devolucao($dt_devolucao);
        $colaboradores_materiais->setobs($obs);
        $colaboradores_materiais->setcolaborador_pk($colaborador_pk);
        $colaboradores_materiais->setconjunto_material_pk($conjunto_material_pk);

        
        $pk = $colaboradores_materiaisdao->salvar($colaboradores_materiais);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $colaboradores_materiaisdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_material_pk"=>$query[$i]['tipo_material_pk'],
                    "material_pk"=>$query[$i]['material_pk'],
                    "qtde_material"=>$query[$i]['qtde_material'],
                    "dt_entrega"=>$query[$i]['dt_entrega'],
                    "dt_devolucao"=>$query[$i]['dt_devolucao'],
                    "obs"=>$query[$i]['obs'],
                    "conjunto_material_pk"=>$query[$i]['conjunto_material_pk'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk']
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
        $query = $colaboradores_materiaisdao->listar_por_tipo_material_pk($tipo_material_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_material_pk"=>$query[$i]['tipo_material_pk'],
                    "material_pk"=>$query[$i]['material_pk'],
                    "qtde_material"=>$query[$i]['qtde_material'],
                    "dt_entrega"=>$query[$i]['dt_entrega'],
                    "dt_devolucao"=>$query[$i]['dt_devolucao'],
                    "obs"=>$query[$i]['obs'],
                    "conjunto_material_pk"=>$query[$i]['conjunto_material_pk'],
                    "colaborador_pk"=>$query[$i]['colaborador_pk']
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
        $query = $colaboradores_materiaisdao->listar_por_tipo_material_pk($tipo_material_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_tipo_material_pk"=>$query[$i]['tipo_material_pk'],
                    "t_material_pk"=>$query[$i]['material_pk'],
                    "t_qtde_material"=>$query[$i]['qtde_material'],
                    "t_dt_entrega"=>$query[$i]['dt_entrega'],
                    "t_dt_devolucao"=>$query[$i]['dt_devolucao'],
                    "t_obs"=>$query[$i]['obs'],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_conjunto_material_pk"=>$query[$i]['conjunto_material_pk'],

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

$colaboradores_materiaisdao = null;

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
