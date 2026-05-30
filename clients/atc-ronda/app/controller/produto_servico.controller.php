<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";

require_once "../model/produto_servico.dao.php";

require_once "../model/produto_servico.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_produto_servico = $arrRequest['ds_produto_servico'];
$ds_obs = $arrRequest['ds_obs'];
$ic_status = $arrRequest['ic_status'];
$ds_cbo = $arrRequest['ds_cbo'];
$vl_servico = $arrRequest['vl_servico'];
//$polos_pk = $arrRequest['polos_pk'];
//$tipos_unidades_pk = $arrRequest['tipos_unidades_pk'];
//$fornecedor_pk = $arrRequest['fornecedor_pk'];


$produto_servicodao = new produto_servicodao();
$produto_servicodao->setToken($token); 

switch($job){

    case 'excluir':{
        if(!permissao("produto_servico", "del", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $resultdo = "";
        
        $produto_servico = $produto_servicodao->carregarPorPk($pk);
        if($produto_servico->getpk()>0){
            
            $produto_servicodao->excluir($produto_servico);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'produto_servico nao encontrado';
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
        if(!permissao("produto_servico", $ic_acao, $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $produto_servico = $produto_servicodao->carregarPorPk($pk);
        $produto_servico->setds_produto_servico($ds_produto_servico);
        $produto_servico->setds_obs($ds_obs);
        $produto_servico->setic_status($ic_status);
        $produto_servico->setds_cbo($ds_cbo);
        $produto_servico->setvl_servico($vl_servico);
        //$produto_servico->setpolos_pk($polos_pk);
        //$produto_servico->settipos_unidades_pk($tipos_unidades_pk);
        //$produto_servico->setfornecedor_pk($fornecedor_pk);

        
        $pk = $produto_servicodao->salvar($produto_servico);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        if(!permissao("produto_servico", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        $resultado = "";
        $query = $produto_servicodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "ds_cbo"=>$query[$i]['ds_cbo'],
                    "vl_servico"=>number_format($query[$i]['vl_servico'], 2, ',', '.')
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
        $query = $produto_servicodao->listar_por_ds_produto_servico($ds_produto_servico,$ds_cob);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarProdutosContrato':{        
        $contratos_pk = $_REQUEST['contratos_pk'];

        $resultado = "";
        $query = $produto_servicodao->listarProdutosContrato($contratos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    
    
    
    //ANTIGO
    case 'listarTodosPorLeads':{
        
        $leads_pk = $_REQUEST['leads_pk'];
        $contratos_pk = $_REQUEST['contratos_pk'];
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $resultado = "";
        $query = $produto_servicodao->listar_por_leads_pk($leads_pk,$contratos_pk,$colaborador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "t_contratos_itens_pk" => $query[$i]["contratos_itens_pk"],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarQualificacaoColaboradores':{
        
        $colaboradores_pk = $_REQUEST['colaboradores_pk'];

        $result  = 'success';
        $message = 'query success';

        if($colaboradores_pk > 0){
            $query = $produto_servicodao->listar_qualificacao_colaboradores($colaboradores_pk);
        }
        else{
            $mysql_data = [];
        }
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_produtos_servicos_pk" => $query[$i]['produtos_servicos_pk'],
                    "t_ic_possui_treinamento"=>$query[$i]['ic_possui_treinamento'],
                    "t_ic_possui_certificado"=>$query[$i]['ic_possui_certificado']
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;        
        
    }
    case 'listarFuncaoColaborador':{
        
        $colaboradores_pk = $_REQUEST['pk'];

        $result  = 'success';
        $message = 'query success';

        if($colaboradores_pk > 0){
            $query = $produto_servicodao->listarFuncaoColaborador($colaboradores_pk);
        }
        else{
            $mysql_data = [];
        }
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "ds_produto_servico" => $query[$i]['ds_produto_servico'],
                    "t_ic_possui_treinamento"=>$query[$i]['ic_possui_treinamento'],
                    "t_ic_possui_certificado"=>$query[$i]['ic_possui_certificado']
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;        
        
    }
    case 'listarDataTable':{
        
        if(!permissao("produto_servico", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }
        
        $resultado = "";
        $query = $produto_servicodao->listar_por_ds_produto_servico($ds_produto_servico,$ds_cbo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_ds_cbo"=>$query[$i]['ds_cbo'],
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
