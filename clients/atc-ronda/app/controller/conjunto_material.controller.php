<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/conjunto_material.dao.php";
require_once "../model/conjunto_material.class.php";
require_once "../model/movimentacao_estoque.dao.php";
require_once "../model/movimentacao_estoque.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$colaborador_pk = $arrRequest['colaborador_pk'];
$leads_pk = $arrRequest['leads_pk'];
$contratos_pk = $arrRequest['contratos_pk'];
$ds_conjunto_material = $arrRequest['ds_conjunto_material'];


$conjunto_materialdao = new conjunto_materialdao();
$conjunto_materialdao->setToken($token); 

$movimentacao_estoquedao = new movimentacao_estoquedao();
$movimentacao_estoquedao->setToken($token);
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $conjunto_material = $conjunto_materialdao->carregarPorPk($pk);
        if($conjunto_material->getpk()>0){
            
            $log_exclusaodao->salvar("conjunto_material",$conjunto_material->getpk());
            
            $conjunto_materialdao->excluir($conjunto_material);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'conjunto_material nao encontrado';
        }
        break;
    }
    case 'excluirConjuntoEProdutosContrato0':{
        
        $resultdo = "";
        
        $con_pk = $conjunto_materialdao->pegarPkConjuntoMaterial0(0);
        if(count($con_pk)>0){
            for($i=0;$i<count($con_pk);$i++){
                $conjunto_materialdao->excluirConjuntoMaterial0($con_pk[$i]['pk']);
            }
        }
        $mat_pk = $conjunto_materialdao->pegarPkMaterial0(0);
        if(count($con_pk)>0){
            for($i=0;$i<count($con_pk);$i++){
               $conjunto_materialdao->excluirMaterial0($mat_pk[$i]['pk']);
            }
        }
        
        
            
        $result  = 'success';
        $message = 'Registro excluído com sucesso.';
        break;
    }
    case 'salvar':{
        
        $conjunto_material = $conjunto_materialdao->carregarPorPk($pk);
        $conjunto_material->setcolaborador_pk($colaborador_pk);
        $conjunto_material->setleads_pk($leads_pk);
        $conjunto_material->setcontratos_pk($contratos_pk);
        $conjunto_material->setds_conjunto_material($ds_conjunto_material);

        
        $pk = $conjunto_materialdao->salvar($conjunto_material);
        
        
        
         //Materiais Lead
        $materiais_lead = $_REQUEST['materiais_pk'];        
        if($materiais_lead != "")
            $arrMateriaisLead = json_decode ($materiais_lead, true);
        
        
        
        if(count($arrMateriaisLead) > 0){  
            
            for($i = 0; $i < count($arrMateriaisLead); $i++){ 

                $movimentacao_estoque = $movimentacao_estoquedao->carregarPorPk($arrMateriaisLead[$i]['movimentacao_estoque_pk']);                  

                $movimentacao_estoque->setcolaborador_pk($colaborador_pk);
                $movimentacao_estoque->setleads_pk($leads_pk);
                $movimentacao_estoque->setcontratos_pk($contratos_pk);

                
                $movimentacao_estoque->setprodutos_itens_pk($arrMateriaisLead[$i]['produtos_itens_pk']);
                $movimentacao_estoque->setqtde("1");
                $movimentacao_estoque->setdt_entrega(DataYMD($arrMateriaisLead[$i]['dt_entrega']));
                $movimentacao_estoque->setconjunto_material_pk($pk);
                $movimentacao_estoque->setic_mateiral_carga($arrMateriaisLead[$i]['ic_mateiral_carga']);
   
                if($arrMateriaisLead[$i]['dt_devolucao']!=""){
                    $movimentacao_estoque->setdt_devolucao(DataYMD($arrMateriaisLead[$i]['dt_devolucao']));
                }                
                $movimentacao_estoque->setobs_movimentacao($arrMateriaisLead[$i]['obs_movimentacao']);

                $movimentacao_pk = $movimentacao_estoquedao->salvar($movimentacao_estoque);
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
        $query = $conjunto_materialdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "ds_conjunto_material"=>$query[$i]['ds_conjunto_material'],
                    "leads_pk"=>$query[$i]['leads_pk']
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
    case 'listarColaboradorPk':{
        
        $resultado = "";
        if($colaborador_pk!=""){
            $query = $conjunto_materialdao->listarColaboradorPk($colaborador_pk);
        
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "colaborador_pk"=>$query[$i]['colaborador_pk'],
                        "ds_conjunto_material"=>$query[$i]['ds_conjunto_material'],
                        "leads_pk"=>$query[$i]['leads_pk']
                    );
                }
            }
            else{
                $mysql_data = [];
            }
        }
        else{
            $mysql_data = [];
        }
        
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    
     case 'listarMovimentarMaterialProd':{
 
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        $categoria_pk = $_REQUEST['categoria_pk'];
        $produtos_pk = $_REQUEST['produtos_pk'];
        $dt_movimentacao_ini = $_REQUEST['dt_movimentacao_ini'];
        $dt_movimentacao_fim = $_REQUEST['dt_movimentacao_fim'];
        $contratos_pk = $_REQUEST['contratos_pk'];
        $int_grupo_para_movimentacao_pk = $_REQUEST['grupo_para_movimentacao_pk'];
        
        
            $resultado = "";
            $arrDados = $conjunto_materialdao->listarMovimentarMaterialProd($colaborador_pk,$leads_pk,$categoria_pk,$produtos_pk,$dt_movimentacao_ini,$dt_movimentacao_fim,$int_grupo_para_movimentacao_pk,$contratos_pk);
            
            $result  = 'success';
            $message = 'query success';
            
            if(count($arrDados['query']) > 0){
                for($i = 0; $i < count($arrDados['query']); $i++){
                    $ds_movimentado = "";
                    $ds_grupo_movimentado = "";
                    $grupo_para_movimentacao_pk = "";
                    
                    
                    if($arrDados['query'][$i]['grupo_para_movimentacao_pk']==""){
                        if($arrDados['query'][$i]['colaborador_pk']!=""){
                            $grupo_para_movimentacao_pk = 1;
                            $ds_grupo_movimentado = "Colaborador";
                        }
                        else if($arrDados['query'][$i]['leads_pk']!=""){
                            $grupo_para_movimentacao_pk = 2;
                            $ds_grupo_movimentado = "Posto de Trabalho";
                        }
                    }
                    else{
                        $grupo_para_movimentacao_pk = $arrDados['query'][$i]['grupo_para_movimentacao_pk'];
                    }
                    
                    
                    
                    if($arrDados['query'][$i]['colaborador_pk']!=""){
                        $queryc = $conjunto_materialdao->pegarNomeColaborador($arrDados['query'][$i]['colaborador_pk']);
                        $ds_movimentado = $queryc[0]['ds_colaborador'];
                        $ds_grupo_movimentado = "Colaborador";
                    }
                    else if($arrDados['query'][$i]['leads_pk']!=""){
                        $queryl = $conjunto_materialdao->pegarNomeLead($arrDados['query'][$i]['leads_pk']);
                        $ds_movimentado =$queryl[0]['ds_lead'];
                        $ds_grupo_movimentado = "Posto de Trabalho";
                    }
                    
                    
                    
                    $queryQtde = $conjunto_materialdao->listarQtde($arrDados['query'][$i]['conjunto_material_pk']);
                    
                    $mysql_data[] = array(
                        "pk" => $arrDados['query'][$i]["pk"],
                        "grupo_para_movimentacao_pk"=>$grupo_para_movimentacao_pk,
                        "leads_pk"=>$arrDados['query'][$i]['leads_pk'],
                        "colaborador_pk"=>$arrDados['query'][$i]['colaborador_pk'],
                        "ds_conjunto_material"=>$arrDados['query'][$i]['ds_conjunto_material'],
                        "conjunto_material_pk"=>$arrDados['query'][$i]['conjunto_material_pk'],
                        "ds_grupo_movimentado"=>$ds_grupo_movimentado,
                        "ds_movimentado"=>$ds_movimentado,
                        "ds_categoria"=>$arrDados['query'][$i]['ds_categoria'],
                        "contratos_pk"=>$arrDados['query'][$i]['contratos_pk'],
                        "categoria_pk"=>$arrDados['query'][$i]['categoria_pk'],
                        "qtde"=>$queryQtde[0]['qtde'],
                        
                        "dt_cadastro"=>$arrDados['query'][$i]['dt_cadastro'],
                        "ds_produto"=>$arrDados['query'][$i]['produto_iten_pk']." - ".$arrDados['query'][$i]['ds_produto']
                    );
                }
            }
            else{
                $mysql_data = [];
                $iTotalDisplayRecords = 0;
            }
        
        
			

        
        
        break;        
    }
    case 'listarMovimentarMaterialProdPK':{
 
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        //$leads_pk = $_REQUEST['leads_pk'];
        
            $resultado = "";
            $arrDados = $conjunto_materialdao->listarMovimentarMaterialProd($colaborador_pk,"","","","","","","");
            
            $result  = 'success';
            $message = 'query success';
            
            if(count($arrDados['query']) > 0){
                for($i = 0; $i < count($arrDados['query']); $i++){
                    $ds_movimentado = "";
                    $ds_grupo_movimentado = "";
                    $grupo_para_movimentacao_pk = "";
                    
                    
                    if($arrDados['query'][$i]['grupo_para_movimentacao_pk']==""){
                        if($arrDados['query'][$i]['colaborador_pk']!=""){
                            $grupo_para_movimentacao_pk = 1;
                            $ds_grupo_movimentado = "Colaborador";
                        }
                        else if($arrDados['query'][$i]['leads_pk']!=""){
                            $grupo_para_movimentacao_pk = 2;
                            $ds_grupo_movimentado = "Posto de Trabalho";
                        }
                    }
                    else{
                        $grupo_para_movimentacao_pk = $arrDados['query'][$i]['grupo_para_movimentacao_pk'];
                    }
                    
                    
                    
                    if($arrDados['query'][$i]['colaborador_pk']!=""){
                        $queryc = $conjunto_materialdao->pegarNomeColaborador($arrDados['query'][$i]['colaborador_pk']);
                        $ds_movimentado = $queryc[0]['ds_colaborador'];
                        $ds_grupo_movimentado = "Colaborador";
                    }
                    else if($arrDados['query'][$i]['leads_pk']!=""){
                        $queryl = $conjunto_materialdao->pegarNomeLead($arrDados['query'][$i]['leads_pk']);
                        $ds_movimentado =$queryl[0]['ds_lead'];
                        $ds_grupo_movimentado = "Posto de Trabalho";
                    }
                    
                    
                    
                    $queryQtde = $conjunto_materialdao->listarQtde($arrDados['query'][$i]['conjunto_material_pk']);
                    
                    $mysql_data[] = array(
                        "pk" => $arrDados['query'][$i]["pk"],
                        "grupo_para_movimentacao_pk"=>$grupo_para_movimentacao_pk,
                        "leads_pk"=>$arrDados['query'][$i]['leads_pk'],
                        "colaborador_pk"=>$arrDados['query'][$i]['colaborador_pk'],
                        "ds_conjunto_material"=>$arrDados['query'][$i]['ds_conjunto_material'],
                        "conjunto_material_pk"=>$arrDados['query'][$i]['conjunto_material_pk'],
                        "ds_grupo_movimentado"=>$ds_grupo_movimentado,
                        "ds_movimentado"=>$ds_movimentado,
                        "ds_categoria"=>$arrDados['query'][$i]['ds_categoria'],
                        "contratos_pk"=>$arrDados['query'][$i]['contratos_pk'],
                        "categoria_pk"=>$arrDados['query'][$i]['categoria_pk'],
                        "qtde"=>$queryQtde[0]['qtde'],
                        
                        "dt_cadastro"=>$arrDados['query'][$i]['dt_cadastro'],
                        "ds_produto"=>$arrDados['query'][$i]['produto_iten_pk']." - ".$arrDados['query'][$i]['ds_produto']
                    );
                }
            }
            else{
                $mysql_data = [];
                $iTotalDisplayRecords = 0;
            }
        
        
			

        
        
        break;        
    }
    case 'listarTodos':{
        
        $resultado = "";
        $query = $conjunto_materialdao->listar_por_colaborador_pk($colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "ds_conjunto_material"=>$query[$i]['ds_conjunto_material'],
                    "leads_pk"=>$query[$i]['leads_pk']
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
        $query = $conjunto_materialdao->listar_por_colaborador_pk($colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_colaborador_pk"=>$query[$i]['colaborador_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_conjunto_material"=>$query[$i]['ds_conjunto_material'],

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

$conjunto_materialdao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data,
    "iTotalDisplayRecords"=>$iTotalDisplayRecords,
    "iTotalRecords"=>$iTotalDisplayRecords
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
echo $json_data;


?>
