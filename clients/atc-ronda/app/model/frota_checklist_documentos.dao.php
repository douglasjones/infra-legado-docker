<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/frota_checklist_documentos.class.php';


class frota_checklist_documentosdao{

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

    public function salvar($frota_checklist_documentos){

        $fields = array();
        $fields['ds_documento'] = $frota_checklist_documentos->getds_documento();
        $fields['ds_obs'] = $frota_checklist_documentos->getds_obs();
        $fields['ds_nome_original'] = $frota_checklist_documentos->getds_nome_original();
        $fields['frota_checklist_pk'] = $frota_checklist_documentos->getfrota_checklist_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($frota_checklist_documentos->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("frota_checklist_documentos", $fields);
            $frota_checklist_documentos->setpk($pk);
        }
        else{
            $this->db->execUpdate("frota_checklist_documentos", $fields, " pk = ".$frota_checklist_documentos->getpk());
        }
        return $frota_checklist_documentos->getpk();;

    }

    public function excluir($frota_checklist_documentos){
        $this->db->execDelete("frota_checklist_documentos"," pk = ".$frota_checklist_documentos->getpk());
    }

    public function carregarPorPk($pk){

        $frota_checklist_documentos = new frota_checklist_documentos();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,frota_checklist_pk ";


        $sql.="  from frota_checklist_documentos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $frota_checklist_documentos->setpk($query[$i]["pk"]);
                $frota_checklist_documentos->setdt_cadastro($query[$i]["dt_cadastro"]);
                $frota_checklist_documentos->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $frota_checklist_documentos->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $frota_checklist_documentos->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $frota_checklist_documentos->setds_documento($query[$i]['ds_documento']);
                $frota_checklist_documentos->setds_obs($query[$i]['ds_obs']);
                $frota_checklist_documentos->setds_nome_original($query[$i]['ds_nome_original']);
                $frota_checklist_documentos->setfrota_checklist_pk($query[$i]['frota_checklist_pk']);

            }
        }
        return $frota_checklist_documentos;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,frota_checklist_pk ";

        $sql.="  from frota_checklist_documentos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarQuantidadeDocumentosFrotaChecklist($frota_checklist_pk){

        $sql ="";
        $sql.="select count(*) total from frota_checklist_documentos where 1=1 ";
        if($frota_checklist_pk!=""){
            $sql.=" and frota_checklist_pk = $frota_checklist_pk";
        }
        

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_documento($ds_documento){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,frota_checklist_pk ";

        $sql.="  from frota_checklist_documentos ";
        $sql.=" where 1=1 ";
        if($ds_documento != ""){
            $sql.=" and ds_frota_checklist_documentos like '%".$ds_documento."%' ";
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
        $sql.="       ,frota_checklist_pk ";

        $sql.="  from frota_checklist_documentos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_documento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
