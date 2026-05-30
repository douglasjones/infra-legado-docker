<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/fornecedor.class.php';


class fornecedordao{

    private $db;
    private $arrToken;

    public function __construct(){
        
        $this->db = new DataBase();
        $this->db->conectar();
        
    }
    
    public function __destruct() {
        $this->db->desconectar();
    }
    
    
    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }       
    
    public function salvar($fornecedor){

        $fields = array();
        $fields['ds_fornecedor'] = $fornecedor->getds_fornecedor();
        $fields['ds_ddd'] = $fornecedor->getds_ddd();
        $fields['ds_tel'] = $fornecedor->getds_tel();
        $fields['ds_email'] = $fornecedor->getds_email();
        $fields['categorias_produto_pk'] = $fornecedor->getcategorias_produto_pk();
        $fields['ic_status'] = $fornecedor->getic_status();
        $fields['ds_cpf_cnpj'] = $fornecedor->getds_cpf_cnpj();
        $fields['ds_razao_social'] = $fornecedor->getds_razao_social();
        $fields['ds_endereco'] = $fornecedor->getds_endereco();
        $fields['ds_numero'] = $fornecedor->getds_numero();
        $fields['ds_complemento'] = $fornecedor->getds_complemento();
        $fields['ds_bairro'] = $fornecedor->getds_bairro();
        $fields['ds_cidade'] = $fornecedor->getds_cidade();
        $fields['ds_uf'] = $fornecedor->getds_uf();
        $fields['ds_cep'] = $fornecedor->getds_cep();
        $fields['ds_contato'] = $fornecedor->getds_contato();
        $fields['tipo_conta_bancaria'] = $fornecedor->gettipo_conta_bancaria();
        $fields['ds_agencia'] = $fornecedor->getds_agencia();
        $fields['ds_conta'] = $fornecedor->getds_conta();
        $fields['bancos_pk'] = $fornecedor->getbancos_pk();
        $fields['ds_digito'] = $fornecedor->getds_digito();
        $fields['vl_salario'] = $fornecedor->getvl_salario();
        $fields['ds_pix'] = $fornecedor->getds_pix();
        $fields['ds_favorecido_pix'] = $fornecedor->getds_favorecido_pix();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($fornecedor->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("fornecedor", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("fornecedor", $fields, " pk = ".$fornecedor->getpk());
        }

    }

    public function excluir($fornecedor){
        $this->db->execDelete("fornecedor"," pk = ".$fornecedor->getpk());
    }

    public function carregarPorPk($pk){

        $fornecedor = new fornecedor();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_fornecedor ";
        $sql.="       ,ds_ddd ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_email ";
        $sql.="       ,categorias_produto_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,ds_cpf_cnpj";
        $sql.="       ,ds_razao_social";
        $sql.="       ,ds_endereco";
        $sql.="       ,ds_numero";
        $sql.="       ,ds_complemento";
        $sql.="       ,ds_bairro";
        $sql.="       ,ds_cidade";
        $sql.="       ,ds_uf";
        $sql.="       ,ds_cep";
        $sql.="       ,ds_contato";
        $sql.="       ,tipo_conta_bancaria";
        $sql.="       ,ds_agencia";
        $sql.="       ,ds_conta";
        $sql.="       ,bancos_pk";
        $sql.="       ,ds_digito";
        $sql.="       ,vl_salario";


        $sql.="  from fornecedor ";
        
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $fornecedor->setpk($query[$i]["pk"]);
                $fornecedor->setdt_cadastro($query[$i]["dt_cadastro"]);
                $fornecedor->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $fornecedor->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $fornecedor->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $fornecedor->setds_fornecedor($query[$i]['ds_fornecedor']);
                $fornecedor->setds_ddd($query[$i]['ds_ddd']);
                $fornecedor->setds_tel($query[$i]['ds_tel']);
                $fornecedor->setds_email($query[$i]['ds_email']);
                $fornecedor->setcategorias_produto_pk($query[$i]['categorias_produto_pk']);
                $fornecedor->setic_status($query[$i]['ic_status']);

            }
        }
        return $fornecedor;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_fornecedor ";
        $sql.="       ,ds_ddd ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_email ";
        $sql.="       ,categorias_produto_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,ds_cpf_cnpj";
        $sql.="       ,ds_razao_social";
        $sql.="       ,ds_endereco";
        $sql.="       ,ds_numero";
        $sql.="       ,ds_complemento";
        $sql.="       ,ds_bairro";
        $sql.="       ,ds_cidade";
        $sql.="       ,ds_uf";
        $sql.="       ,ds_cep";
        $sql.="       ,ds_contato";
        $sql.="       ,tipo_conta_bancaria";
        $sql.="       ,ds_agencia";
        $sql.="       ,ds_conta";
        $sql.="       ,bancos_pk";
        $sql.="       ,ds_digito";
        $sql.="       ,vl_salario";

        $sql.="  from fornecedor ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_fornecedor($ds_fornecedor){

        $sql ="";
        $sql.="select f.pk, f.dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.ds_fornecedor ";
        $sql.="       ,f.ds_ddd ";
        $sql.="       ,f.ds_tel ";
        $sql.="       ,f.ds_email ";
        $sql.="       ,f.categorias_produto_pk ";
        $sql.="       ,f.ic_status ";
        $sql.="       ,f.ds_cpf_cnpj";
        $sql.="       ,f.ds_razao_social";
        $sql.="       ,f.ds_endereco";
        $sql.="       ,f.ds_numero";
        $sql.="       ,f.ds_complemento";
        $sql.="       ,f.ds_bairro";
        $sql.="       ,f.ds_cidade";
        $sql.="       ,f.ds_uf";
        $sql.="       ,f.ds_cep";
        $sql.="       ,f.ds_contato";
        $sql.="       ,f.tipo_conta_bancaria";
        $sql.="       ,f.ds_agencia";
        $sql.="       ,f.ds_conta";
        $sql.="       ,f.bancos_pk";
        $sql.="       ,f.ds_digito";
        $sql.="       ,f.vl_salario";
        $sql.="       ,cp.ds_categoria ";
        $sql.="  from fornecedor f";
        $sql.="  left join categorias_produto cp on f.categorias_produto_pk = cp.pk  ";
        $sql.=" where 1=1 ";
        if($ds_fornecedor != ""){
            $sql.=" and f.ds_fornecedor like '%".$ds_fornecedor."%' ";
        }
        $sql.=" order by f.ds_fornecedor asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_categorias($categorias_produto_pk){

        $sql ="";
        $sql.="select f.pk, f.dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.ds_fornecedor ";
        $sql.="       ,f.ds_ddd ";
        $sql.="       ,f.ds_tel ";
        $sql.="       ,f.ds_email ";
        $sql.="       ,f.categorias_produto_pk ";
        $sql.="       ,f.ic_status ";
        $sql.="       ,f.ds_cpf_cnpj";
        $sql.="       ,f.ds_razao_social";
        $sql.="       ,f.ds_endereco";
        $sql.="       ,f.ds_numero";
        $sql.="       ,f.ds_complemento";
        $sql.="       ,f.ds_bairro";
        $sql.="       ,f.ds_cidade";
        $sql.="       ,f.ds_uf";
        $sql.="       ,f.ds_cep";
        $sql.="       ,f.ds_contato";
        $sql.="       ,f.tipo_conta_bancaria";
        $sql.="       ,f.ds_agencia";
        $sql.="       ,f.ds_conta";
        $sql.="       ,f.bancos_pk";
        $sql.="       ,f.ds_digito";
        $sql.="       ,f.vl_salario";
        $sql.="       ,cp.ds_categoria ";
        $sql.="  from fornecedor f";
        $sql.="  left join categorias_produto cp on f.categorias_produto_pk = cp.pk  ";
        $sql.=" where 1=1 ";
        if($categorias_produto_pk != ""){
            $sql.=" and f.categorias_produto_pk = ".$categorias_produto_pk;
        }
        $sql.=" order by f.ds_fornecedor asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarDadosBancarios($pk){

        $sql ="";
        $sql.="select f.pk, f.dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.ds_agencia";
        $sql.="       ,f.ds_conta";
        $sql.="       ,f.bancos_pk";
        $sql.="       ,f.ds_digito";
        $sql.="       ,b.ds_banco";
        $sql.="  from fornecedor f";
        $sql.="  left join bancos b on f.bancos_pk= b.pk  ";
        $sql.=" where 1=1 ";
        $sql.=" and f.pk = ".$pk;
        $sql.=" group by f.pk";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_fornecedor ";
        $sql.="       ,ds_ddd ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_email ";
        $sql.="       ,categorias_produto_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,ds_cpf_cnpj";
        $sql.="       ,ds_razao_social";
        $sql.="       ,ds_endereco";
        $sql.="       ,ds_numero";
        $sql.="       ,ds_complemento";
        $sql.="       ,ds_bairro";
        $sql.="       ,ds_cidade";
        $sql.="       ,ds_uf";
        $sql.="       ,ds_cep";
        $sql.="       ,ds_contato";
        $sql.="       ,tipo_conta_bancaria";
        $sql.="       ,ds_agencia";
        $sql.="       ,ds_conta";
        $sql.="       ,bancos_pk";
        $sql.="       ,ds_digito";
        $sql.="       ,vl_salario";

        $sql.="  from fornecedor ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_fornecedor asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
