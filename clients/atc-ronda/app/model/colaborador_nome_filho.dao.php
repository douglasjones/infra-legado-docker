<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/colaborador_nome_filho.class.php';


class colaborador_nome_filhodao{

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
    
    public function salvar($colaborador_nome_filho){

        $fields = array();
        $fields['colaborador_pk'] = $colaborador_nome_filho->getcolaborador_pk();
        $fields['ds_nome_filho'] = $colaborador_nome_filho->getds_nome_filho();
        $fields['ds_cpf_filho'] = $colaborador_nome_filho->getds_cpf_filho();
        $fields['dt_nascimento_filho'] = $colaborador_nome_filho->getdt_nascimento_filho();

        $fields['ds_tipo_sanguineo_dependente'] = $colaborador_nome_filho->getds_tipo_sanguineo_dependente();
        $fields['ds_num_cartao_sus_dependente'] = $colaborador_nome_filho->getds_num_cartao_sus_dependente();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($colaborador_nome_filho->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("colaboradores_nome_filho", $fields);

            return $pk;
        }
        else{
            return $this->db->execUpdate("colaboradores_nome_filho", $fields, " pk = ".$colaborador_nome_filho->getpk());
        }

    }

    public function excluir($colaborador_nome_filho){
        $this->db->execDelete("colaboradores_nome_filho"," pk = ".$colaborador_nome_filho->getpk());
    }
    public function excluirColaboradorPk($colaborador_pk){
        $this->db->execDelete("colaboradores_nome_filho"," colaborador_pk = ".$colaborador_pk);
    }

    public function carregarPorPk($pk){

        $colaborador_nome_filho = new colaborador_nome_filho();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,colaborador_pk ";
        $sql.="       ,ds_nome_filho ";
        $sql.="       ,ds_cpf_filho ";
        $sql.="       ,dt_nascimento_filho ";


        $sql.="  from colaboradores_nome_filho ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $colaborador_nome_filho->setpk($query[$i]["pk"]);
                $colaborador_nome_filho->setdt_cadastro($query[$i]["dt_cadastro"]);
                $colaborador_nome_filho->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $colaborador_nome_filho->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $colaborador_nome_filho->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $colaborador_nome_filho->setcolaborador_pk($query[$i]['colaborador_pk']);
                $colaborador_nome_filho->setds_nome_filho($query[$i]['ds_nome_filho']);
                $colaborador_nome_filho->setds_cpf_filho($query[$i]['ds_cpf_filho']);
                $colaborador_nome_filho->setdt_nascimento_filho($query[$i]['dt_nascimento_filho']);

            }
        }
        return $colaborador_nome_filho;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,ds_nome_filho ";
        $sql.="       ,ds_cpf_filho ";
        $sql.="       ,dt_nascimento_filho ";

        $sql.="  from colaboradores_nome_filho ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_colaborador_pk($colaborador_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,ds_nome_filho ";
        $sql.="       ,ds_cpf_filho ";
        $sql.="       ,dt_nascimento_filho ";

        $sql.="  from colaboradores_nome_filho ";
        $sql.=" where 1=1 ";
        if($colaborador_pk != ""){
            $sql.=" and ds_colaborador_nome_filho like '%".$colaborador_pk."%' ";
        }
        $sql.=" order by colaborador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarNomeFilhoColaboradorPk($colaborador_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,ds_nome_filho ";
        $sql.="       ,ds_cpf_filho ";
        $sql.="       ,ds_tipo_sanguineo_dependente ";
        $sql.="       ,ds_num_cartao_sus_dependente ";
        $sql.="       ,date_format(dt_nascimento_filho,'%d/%m/%Y')dt_nascimento_filho ";

        $sql.="  from colaboradores_nome_filho ";
        $sql.=" where 1=1 ";
        if($colaborador_pk != ""){
            $sql.=" and colaborador_pk = ".$colaborador_pk;
        }
        $sql.=" order by colaborador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,ds_nome_filho ";
        $sql.="       ,ds_cpf_filho ";
        $sql.="       ,dt_nascimento_filho ";

        $sql.="  from colaboradores_nome_filho ";
        $sql.=" where 1=1 ";
        $sql.=" order by colaborador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
