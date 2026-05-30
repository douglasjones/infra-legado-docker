<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/fornecedor.dao.php";
require_once "../model/fornecedor.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_fornecedor = $arrRequest['ds_fornecedor'];
$ds_ddd = $arrRequest['ds_ddd'];
$ds_tel = $arrRequest['ds_tel'];
$ds_email = $arrRequest['ds_email'];
$categorias_produto_pk = $arrRequest['categorias_produto_pk'];
$ic_status = $arrRequest['ic_status'];
$ds_cpf_cnpj = $arrRequest['ds_cpf_cnpj'];
$ds_razao_social= $arrRequest['ds_razao_social'];
$ds_endereco= $arrRequest['ds_endereco'];
$ds_numero= $arrRequest['ds_numero'];
$ds_complemento= $arrRequest['ds_complemento'];
$ds_bairro = $arrRequest['ds_bairro'];
$ds_cidade = $arrRequest['ds_cidade'];
$ds_uf = $arrRequest['ds_uf'];
$ds_cep = $arrRequest['ds_cep'];
$ds_contato = $arrRequest['ds_contato'];
$tipo_conta_bancaria= $arrRequest['tipo_conta_bancaria'];
$ds_agencia= $arrRequest['ds_agencia'];
$ds_conta= $arrRequest['ds_conta'];
$ds_digito= $arrRequest['ds_digito'];
$bancos_pk= $arrRequest['bancos_pk'];
$vl_salario = $arrRequest['vl_salario'];
$ds_favorecido_pix = $arrRequest['ds_favorecido_pix'];
$ds_pix = $arrRequest['ds_pix'];


$fornecedordao = new fornecedordao();
$fornecedordao->setToken($token);

$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $fornecedor = $fornecedordao->carregarPorPk($pk);
        if($fornecedor->getpk()>0){
            
            $log_exclusaodao->salvar("fornecedores",$fornecedor->getpk());
            $fornecedordao->excluir($fornecedor);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'fornecedor nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $fornecedor = $fornecedordao->carregarPorPk($pk);
        $fornecedor->setds_fornecedor($ds_fornecedor);
        $fornecedor->setds_ddd($ds_ddd);
        $fornecedor->setds_tel($ds_tel);
        $fornecedor->setds_email($ds_email);
        $fornecedor->setcategorias_produto_pk($categorias_produto_pk);
        $fornecedor->setic_status($ic_status);
        $fornecedor->setds_cpf_cnpj($ds_cpf_cnpj);
        $fornecedor->setds_razao_social($ds_razao_social);
        $fornecedor->setds_endereco($ds_endereco);
        $fornecedor->setds_numero($ds_numero);
        $fornecedor->setds_complemento($ds_complemento);
        $fornecedor->setds_bairro($ds_bairro);
        $fornecedor->setds_cidade($ds_cidade);
        $fornecedor->setds_uf($ds_uf);
        $fornecedor->setds_cep($ds_cep);
        $fornecedor->setds_contato($ds_contato);
        $fornecedor->settipo_conta_bancaria($tipo_conta_bancaria);
        $fornecedor->setds_agencia($ds_agencia);
        $fornecedor->setds_conta($ds_conta);
        $fornecedor->setds_digito($ds_digito);
        $fornecedor->setbancos_pk($bancos_pk);
        $fornecedor->setvl_salario($vl_salario);
        $fornecedor->setds_pix($ds_pix);
        $fornecedor->setds_favorecido_pix($ds_favorecido_pix);
        
        

        
        $pk = $fornecedordao->salvar($fornecedor);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $fornecedordao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_fornecedor"=>$query[$i]['ds_fornecedor'],
                    "ds_ddd"=>$query[$i]['ds_ddd'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_contato"=>$query[$i]['ds_contato'],
                    "tipo_conta_bancaria"=>$query[$i]['tipo_conta_bancaria'],
                    "ds_agencia"=>$query[$i]['ds_agencia'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "bancos_pk"=>$query[$i]['bancos_pk'],
                    "ds_digito"=>$query[$i]['ds_digito'],
                    "vl_salario"=>$query[$i]['vl_salario'],
                    
                    
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
        $query = $fornecedordao->listar_por_ds_fornecedor($ds_fornecedor);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_fornecedor"=>$query[$i]['ds_fornecedor'],
                    "ds_ddd"=>$query[$i]['ds_ddd'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_contato"=>$query[$i]['ds_contato'],
                    "tipo_conta_bancaria"=>$query[$i]['tipo_conta_bancaria'],
                    "ds_agencia"=>$query[$i]['ds_agencia'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "bancos_pk"=>$query[$i]['bancos_pk'],
                    "ds_digito"=>$query[$i]['ds_digito'],
                    "vl_salario"=>$query[$i]['vl_salario'],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarPorCategoria':{
        $categorias_produto_pk = $_REQUEST['categorias_produto_pk'];
        $resultado = "";
        $query = $fornecedordao->listar_por_categorias($categorias_produto_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_fornecedor"=>$query[$i]['ds_fornecedor'],
                    "ds_ddd"=>$query[$i]['ds_ddd'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_contato"=>$query[$i]['ds_contato'],
                    "tipo_conta_bancaria"=>$query[$i]['tipo_conta_bancaria'],
                    "ds_agencia"=>$query[$i]['ds_agencia'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "bancos_pk"=>$query[$i]['bancos_pk'],
                    "ds_digito"=>$query[$i]['ds_digito'],
                    "vl_salario"=>$query[$i]['vl_salario'],
                    "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDadosBancarios':{
        $resultado = "";
        $pk = $_REQUEST['pk'];
        $query = $fornecedordao->listarDadosBancarios($pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_agencia"=>$query[$i]['ds_agencia'],
                    "ds_conta"=>$query[$i]['ds_conta']." - ".$query[$i]['ds_digito'],
                    "ds_banco"=>$query[$i]['ds_banco']
                   
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
        $query = $fornecedordao->listar_por_ds_fornecedor($ds_fornecedor);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_fornecedor"=>$query[$i]['ds_fornecedor'],
                    "t_ds_ddd"=>$query[$i]['ds_ddd'],
                    "t_ds_tel"=>$query[$i]['ds_tel'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_ds_categoria"=>$query[$i]['ds_categoria'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_contato"=>$query[$i]['ds_contato'],
                    "tipo_conta_bancaria"=>$query[$i]['tipo_conta_bancaria'],
                    "ds_agencia"=>$query[$i]['ds_agencia'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "bancos_pk"=>$query[$i]['bancos_pk'],
                    "ds_digito"=>$query[$i]['ds_digito'],
                    "vl_salario"=>$query[$i]['vl_salario'],
                    "t_ic_status"=>$query[$i]['ic_status'],

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

$fornecedordao = null;

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
