<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/auditoria_categoria_tipos.class.php';


class auditoria_categoria_tiposdao{

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

    public function salvar($auditoria_categoria_tipos){

        $fields = array();
        $fields['auditoria_categorias_pk'] = $auditoria_categoria_tipos->getauditoria_categorias_pk();
        $fields['ds_auditoria_categoria_tipo'] = $auditoria_categoria_tipos->getds_auditoria_categoria_tipo();
        $fields['ic_status'] = $auditoria_categoria_tipos->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($auditoria_categoria_tipos->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("auditoria_categorias_tipos", $fields);
            $auditoria_categoria_tipos->setpk($pk);
            return $pk;
        }
        else{
            return $this->db->execUpdate("auditoria_categorias_tipos", $fields, " pk = ".$auditoria_categoria_tipos->getpk());
        }

    }

    public function excluir($auditoria_categoria_tipos){
        $this->db->execDelete("auditoria_categorias_tipos"," pk = ".$auditoria_categoria_tipos->getpk());
    }

    public function carregarPorPk($pk){

        $auditoria_categoria_tipos = new auditoria_categoria_tipos();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,auditoria_categorias_pk ";
        $sql.="       ,ds_auditoria_categoria_tipo ";
        $sql.="       ,ic_status ";


        $sql.="  from auditoria_categorias_tipos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $auditoria_categoria_tipos->setpk($query[$i]["pk"]);
                $auditoria_categoria_tipos->setdt_cadastro($query[$i]["dt_cadastro"]);
                $auditoria_categoria_tipos->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $auditoria_categoria_tipos->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $auditoria_categoria_tipos->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $auditoria_categoria_tipos->setauditoria_categorias_pk($query[$i]['auditoria_categorias_pk']);
                $auditoria_categoria_tipos->setds_auditoria_categoria_tipo($query[$i]['ds_auditoria_categoria_tipo']);
                $auditoria_categoria_tipos->setic_status($query[$i]['ic_status']);

            }
        }
        return $auditoria_categoria_tipos;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,auditoria_categorias_pk ";
        $sql.="       ,ds_auditoria_categoria_tipo ";
        $sql.="       ,ic_status ";

        $sql.="  from auditoria_categorias_tipos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarPorAuditoriaCategoriasPk($auditoria_categorias_pk){

        $sql ="";
        $sql.="select act.pk, act.dt_cadastro, act.usuario_cadastro_pk, act.dt_ult_atualizacao, act.usuario_ult_atualizacao_pk ";
        $sql.="       ,act.auditoria_categorias_pk ";
        $sql.="       ,ac.ds_categoria ";
        $sql.="       ,act.ds_auditoria_categoria_tipo ";
        $sql.="       ,act.ic_status ";
        $sql.="       ,CASE
                        WHEN act.ic_status = 1 THEN 'Ativo'
                        WHEN act.ic_status = 2 THEN 'Inativo'
                        END ds_status";
        $sql.="  from auditoria_categorias_tipos act ";
        $sql.="  inner join auditoria_categorias ac on act.auditoria_categorias_pk = ac.pk";
        $sql.=" where 1=1 ";
        if($auditoria_categorias_pk != ""){
            $sql.=" and act.auditoria_categorias_pk = ".$auditoria_categorias_pk;
        }
        $sql.=" order by act.auditoria_categorias_pk asc ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_auditoria_categorias_pk(){

        $sql ="";
        $sql.="select act.pk, act.dt_cadastro, act.usuario_cadastro_pk, act.dt_ult_atualizacao, act.usuario_ult_atualizacao_pk ";
        $sql.="       ,act.auditoria_categorias_pk ";
        $sql.="       ,ac.ds_categoria ";
        $sql.="       ,act.ds_auditoria_categoria_tipo ";
        $sql.="       ,act.ic_status ";
        $sql.="       ,CASE
                        WHEN act.ic_status = 1 THEN 'Ativo'
                        WHEN act.ic_status = 2 THEN 'Inativo'
                        END ds_status";
        $sql.="  from auditoria_categorias_tipos act ";
        $sql.="  inner join auditoria_categorias ac on act.auditoria_categorias_pk = ac.pk";
        $sql.=" where 1=1 ";
        $sql.=" order by act.auditoria_categorias_pk asc ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,auditoria_categorias_pk ";
        $sql.="       ,ds_auditoria_categoria_tipo ";
        $sql.="       ,ic_status ";

        $sql.="  from auditoria_categorias_tipos ";
        $sql.=" where 1=1 ";
        $sql.=" order by auditoria_categorias_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
