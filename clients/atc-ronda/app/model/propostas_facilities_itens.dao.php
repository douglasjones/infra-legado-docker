<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/propostas_facilities_itens.class.php';


class propostas_facilities_itensdao{

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

    public function salvar($arrGrupos){

        $arrGrupos = json_decode($arrGrupos, true);

        for($i=0; $i<count($arrGrupos);$i++){
            $fields = array();
            $fields['ds_percentual'] = $arrGrupos[$i]['ds_percentual'];
            $fields['ds_valor'] = $arrGrupos[$i]['ds_valor'];
            $fields['ic_status'] = $arrGrupos[$i]['ic_status'];
            $fields['propostas_facilities_label_pk'] = $arrGrupos[$i]['propostas_facilities_label_pk'];
            $fields['propostas_facilities_grupos_subgrupos_pk'] = $arrGrupos[$i]['propostas_facilities_grupos_subgrupos_pk'];
            $fields['propostas_facilities_pk'] = $arrGrupos[$i]['propostas_facilities_pk'];

            $fields["dt_ult_atualizacao"] = "sysdate()";
            $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            if($arrGrupos[$i]['pk'] == ""){
                $fields["dt_ult_atualizacao"] = "sysdate()";
                $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        
                $fields["dt_cadastro"] = "sysdate()";
                $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk']; 
                $pk = $this->db->execInsert("propostas_facilities_itens", $fields);
            }
            else{
                $this->db->execUpdate("propostas_facilities_itens", $fields, " pk = ".$arrGrupos[$i]['pk']);
                $pk = $arrGrupos[$i]['pk'];
            } 
        }
        return $pk;

    }

    public function excluir($propostas_facilities_itens){
        $this->db->execDelete("propostas_facilities_itens"," pk = ".$propostas_facilities_itens->getpk());
    }

    public function carregarPorPk($pk){

        $propostas_facilities_itens = new propostas_facilities_itens();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_percentual ";
        $sql.="       ,ds_valor ";
        $sql.="       ,ic_status ";
        $sql.="       ,propostas_facilities_label_pk ";
        $sql.="       ,propostas_facilities_grupos_subgrupos_pk ";
        $sql.="       ,propostas_facilities_pk ";


        $sql.="  from propostas_facilities_itens ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $propostas_facilities_itens->setpk($query[$i]["pk"]);
                $propostas_facilities_itens->setdt_cadastro($query[$i]["dt_cadastro"]);
                $propostas_facilities_itens->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $propostas_facilities_itens->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $propostas_facilities_itens->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $propostas_facilities_itens->setds_percentual($query[$i]['ds_percentual']);
                $propostas_facilities_itens->setds_valor($query[$i]['ds_valor']);
                $propostas_facilities_itens->setic_status($query[$i]['ic_status']);
                $propostas_facilities_itens->setpropostas_facilities_label_pk($query[$i]['propostas_facilities_label_pk']);
                $propostas_facilities_itens->setpropostas_facilities_grupos_subgrupos_pk($query[$i]['propostas_facilities_grupos_subgrupos_pk']);
                $propostas_facilities_itens->setpropostas_facilities_pk($query[$i]['propostas_facilities_pk']);

            }
        }
        return $propostas_facilities_itens;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_percentual ";
        $sql.="       ,ds_valor ";
        $sql.="       ,ic_status ";
        $sql.="       ,propostas_facilities_label_pk ";
        $sql.="       ,propostas_facilities_grupos_subgrupos_pk ";
        $sql.="       ,propostas_facilities_pk ";

        $sql.="  from propostas_facilities_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_percentual($ds_percentual){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_percentual ";
        $sql.="       ,ds_valor ";
        $sql.="       ,ic_status ";
        $sql.="       ,propostas_facilities_label_pk ";
        $sql.="       ,propostas_facilities_grupos_subgrupos_pk ";
        $sql.="       ,propostas_facilities_pk ";

        $sql.="  from propostas_facilities_itens ";
        $sql.=" where 1=1 ";
        if($ds_percentual != ""){
            $sql.=" and ds_propostas_facilities_itens like '%".$ds_percentual."%' ";
        }
        $sql.=" order by ds_percentual asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_percentual ";
        $sql.="       ,ds_valor ";
        $sql.="       ,ic_status ";
        $sql.="       ,propostas_facilities_label_pk ";
        $sql.="       ,propostas_facilities_grupos_subgrupos_pk ";
        $sql.="       ,propostas_facilities_pk ";

        $sql.="  from propostas_facilities_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_percentual asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
