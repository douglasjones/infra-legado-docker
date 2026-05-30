<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/auditoria_categoria.class.php';


class auditoria_categoriadao{

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

    public function salvar($auditoria_categoria){

        $fields = array();
        $fields['ds_categoria'] = $auditoria_categoria->getds_categoria();
        $fields['ic_status'] = $auditoria_categoria->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($auditoria_categoria->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("auditoria_categorias", $fields);
            $auditoria_categoria->setpk($pk);
        }
        else{
            $this->db->execUpdate("auditoria_categorias", $fields, " pk = ".$auditoria_categoria->getpk());
        }
        return $auditoria_categoria->getpk();;

    }

    public function excluir($auditoria_categoria){
        $this->db->execDelete("auditoria_categorias"," pk = ".$auditoria_categoria->getpk());
    }

    public function carregarPorPk($pk){

        $auditoria_categoria = new auditoria_categoria();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_categoria ";
        $sql.="       ,ic_status ";


        $sql.="  from auditoria_categorias ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $auditoria_categoria->setpk($query[$i]["pk"]);
                $auditoria_categoria->setdt_cadastro($query[$i]["dt_cadastro"]);
                $auditoria_categoria->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $auditoria_categoria->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $auditoria_categoria->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $auditoria_categoria->setds_categoria($query[$i]['ds_categoria']);
                $auditoria_categoria->setic_status($query[$i]['ic_status']);

            }
        }
        return $auditoria_categoria;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_categoria ";
        $sql.="       ,ic_status ";

        $sql.="  from auditoria_categorias ";
        $sql.=" where pk = $pk ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarCategoriaCombo($pk){

        $sql ="";
        $sql.="select pk";
        $sql.="      ,ds_categoria ";
        $sql.="  from auditoria_categorias ";
        $sql.=" where 1=1";
        if($pk != ""){
            $sql.="   and pk = $pk ";
        }
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_categoria($ds_categoria, $ic_status){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_categoria ";
        $sql.="       ,ic_status ";
        $sql.="       ,CASE
                        WHEN ic_status = 1 THEN 'Ativo'
                        WHEN ic_status = 2 THEN 'Inativo'
                        END ds_status";
        $sql.="  from auditoria_categorias ";
        $sql.=" where 1=1 ";
        if($ds_categoria != ""){
            $sql.=" and ds_categoria like '%".$ds_categoria."%' ";
        }
        if($ic_status != ""){
            $sql.=" and ic_status = ".$ic_status;
        }
        $sql.=" order by ds_categoria asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_categoria ";
        $sql.="       ,ic_status ";

        $sql.="  from auditoria_categorias ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_categoria asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
