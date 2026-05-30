<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/supervisao_auditoria_documentos.class.php';


class supervisao_auditoria_documentosdao{

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

    public function salvar($supervisao_auditoria_documentos){

        $fields = array();
        $fields['ds_documento'] = $supervisao_auditoria_documentos->getds_documento();
        $fields['ds_obs'] = $supervisao_auditoria_documentos->getds_obs();
        $fields['ds_nome_original'] = $supervisao_auditoria_documentos->getds_nome_original();
        $fields['supervisao_auditorias_pk'] = $supervisao_auditoria_documentos->getsupervisao_auditorias_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($supervisao_auditoria_documentos->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("supervisao_auditoria_documentos", $fields);
            $supervisao_auditoria_documentos->setpk($pk);
        }
        else{
            $this->db->execUpdate("supervisao_auditoria_documentos", $fields, " pk = ".$supervisao_auditoria_documentos->getpk());
        }
        return $supervisao_auditoria_documentos->getpk();;

    }

    public function excluir($supervisao_auditoria_documentos){
        $this->db->execDelete("supervisao_auditoria_documentos"," pk = ".$supervisao_auditoria_documentos->getpk());
    }

    public function carregarPorPk($pk){

        $supervisao_auditoria_documentos = new supervisao_auditoria_documentos();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,supervisao_auditorias_pk ";


        $sql.="  from supervisao_auditoria_documentos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $supervisao_auditoria_documentos->setpk($query[$i]["pk"]);
                $supervisao_auditoria_documentos->setdt_cadastro($query[$i]["dt_cadastro"]);
                $supervisao_auditoria_documentos->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $supervisao_auditoria_documentos->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $supervisao_auditoria_documentos->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $supervisao_auditoria_documentos->setds_documento($query[$i]['ds_documento']);
                $supervisao_auditoria_documentos->setds_obs($query[$i]['ds_obs']);
                $supervisao_auditoria_documentos->setds_nome_original($query[$i]['ds_nome_original']);
                $supervisao_auditoria_documentos->setsupervisao_auditorias_pk($query[$i]['supervisao_auditorias_pk']);

            }
        }
        return $supervisao_auditoria_documentos;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,supervisao_auditorias_pk ";

        $sql.="  from supervisao_auditoria_documentos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_supervisao_auditorias_pk($supervisao_auditorias_pk){

            $sql ="";
            $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
            $sql.="       ,ds_documento ";
            $sql.="       ,ds_obs ";
            $sql.="       ,ds_nome_original ";
            $sql.="       ,supervisao_auditorias_pk ";

            $sql.="  from supervisao_auditoria_documentos ";
            $sql.=" where 1=1 ";
            if($supervisao_auditorias_pk > 0){
                $sql.=" and supervisao_auditorias_pk = ".$supervisao_auditorias_pk;
            }
            $sql.=" order by ds_documento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,supervisao_auditorias_pk ";

        $sql.="  from supervisao_auditoria_documentos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_documento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
