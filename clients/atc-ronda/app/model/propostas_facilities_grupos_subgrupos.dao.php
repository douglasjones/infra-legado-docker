<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/propostas_facilities_grupos_subgrupos.class.php';


class propostas_facilities_grupos_subgruposdao{

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

    public function salvar($propostas_facilities_grupos_subgrupos){

        $fields = array();
        $fields['ic_tipo_grupo'] = $propostas_facilities_grupos_subgrupos->getic_tipo_grupo();
        $fields['ds_nome_grupo'] = $propostas_facilities_grupos_subgrupos->getds_nome_grupo();
        $fields['grupo_pai_pk'] = $propostas_facilities_grupos_subgrupos->getgrupo_pai_pk();
        $fields['ic_status'] = $propostas_facilities_grupos_subgrupos->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($propostas_facilities_grupos_subgrupos->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("propostas_facilities_grupos_subgrupos", $fields);
            $propostas_facilities_grupos_subgrupos->setpk($pk);
        }
        else{
            $this->db->execUpdate("propostas_facilities_grupos_subgrupos", $fields, " pk = ".$propostas_facilities_grupos_subgrupos->getpk());
        }
        return $propostas_facilities_grupos_subgrupos->getpk();;

    }

    public function excluir($propostas_facilities_grupos_subgrupos){
        $this->db->execDelete("propostas_facilities_grupos_subgrupos"," pk = ".$propostas_facilities_grupos_subgrupos->getpk());
    }

    public function carregarPorPk($pk){

        $propostas_facilities_grupos_subgrupos = new propostas_facilities_grupos_subgrupos();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ic_tipo_grupo ";
        $sql.="       ,ds_nome_grupo ";
        $sql.="       ,grupo_pai_pk ";
        $sql.="       ,ic_status ";


        $sql.="  from propostas_facilities_grupos_subgrupos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $propostas_facilities_grupos_subgrupos->setpk($query[$i]["pk"]);
                $propostas_facilities_grupos_subgrupos->setdt_cadastro($query[$i]["dt_cadastro"]);
                $propostas_facilities_grupos_subgrupos->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $propostas_facilities_grupos_subgrupos->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $propostas_facilities_grupos_subgrupos->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $propostas_facilities_grupos_subgrupos->setic_tipo_grupo($query[$i]['ic_tipo_grupo']);
                $propostas_facilities_grupos_subgrupos->setds_nome_grupo($query[$i]['ds_nome_grupo']);
                $propostas_facilities_grupos_subgrupos->setgrupo_pai_pk($query[$i]['grupo_pai_pk']);
                $propostas_facilities_grupos_subgrupos->setic_status($query[$i]['ic_status']);

            }
        }
        return $propostas_facilities_grupos_subgrupos;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ic_tipo_grupo ";
        $sql.="       ,ds_nome_grupo ";
        $sql.="       ,grupo_pai_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from propostas_facilities_grupos_subgrupos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ic_tipo_grupo($ic_tipo_grupo){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ic_tipo_grupo ";
        $sql.="       ,ds_nome_grupo ";
        $sql.="       ,grupo_pai_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from propostas_facilities_grupos_subgrupos ";
        $sql.=" where 1=1 ";
        if($ic_tipo_grupo != ""){
            $sql.=" and ds_propostas_facilities_grupos_subgrupos like '%".$ic_tipo_grupo."%' ";
        }
        $sql.=" order by ic_tipo_grupo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ic_tipo_grupo ";
        $sql.="       ,ds_nome_grupo ";
        $sql.="       ,grupo_pai_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from propostas_facilities_grupos_subgrupos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ic_tipo_grupo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
