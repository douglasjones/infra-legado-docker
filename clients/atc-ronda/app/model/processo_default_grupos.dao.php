<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/processo_default_grupos.class.php';


class processo_default_gruposdao{

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

    public function salvar($processo_default_grupos){
        //var_dump($processo_default_grupos);

        $fields = array();
        $fields['grupos_pk'] = $processo_default_grupos->getgrupos_pk();
        $fields['ic_status'] = $processo_default_grupos->getic_status();
        $fields['processo_default_configuracao_pk'] = $processo_default_grupos->getprocesso_default_configuracao_pk();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($processo_default_grupos->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("processo_default_grupos", $fields);
        }
        else{
            $this->db->execUpdate("processo_default_grupos", $fields, " processo_default_configuracao_pk = ".$processo_default_grupos->getprocesso_default_configuracao_pk());
        }
        
        return $pk;

    }

    public function excluir($processo_default_grupos){
        $this->db->execDelete("processo_default_grupos"," pk = ".$processo_default_grupos->getpk());
    }

    public function carregarPorPk($pk){

        $processo_default_grupos = new processo_default_grupos();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,processo_default_configuracao_pk ";
        $sql.="  from processo_default_grupos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $processo_default_grupos->setpk($query[$i]["pk"]);
                $processo_default_grupos->setdt_cadastro($query[$i]["dt_cadastro"]);
                $processo_default_grupos->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $processo_default_grupos->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $processo_default_grupos->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $processo_default_grupos->setgrupos_pk($query[$i]['grupos_pk']);
                $processo_default_grupos->setic_status($query[$i]['ic_status']);
                $processo_default_grupos->setprocesso_default_configuracao_pk($query[$i]['processo_default_configuracao_pk']);

            }
        }
        return $processo_default_grupos;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,processo_default_configuracao_pk ";

        $sql.="  from processo_default_grupos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_grupos_pk($grupos_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,processo_default_configuracao_pk ";

        $sql.="  from processo_default_grupos ";
        $sql.=" where 1=1 ";
        if($grupos_pk != ""){
            $sql.=" and ds_processo_default_grupos like '%".$grupos_pk."%' ";
        }
        $sql.=" order by grupos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,processo_default_configuracao_pk ";

        $sql.="  from processo_default_grupos ";
        $sql.=" where 1=1 ";
        $sql.=" order by grupos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
