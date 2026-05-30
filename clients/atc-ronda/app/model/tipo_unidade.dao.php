<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/tipo_unidade.class.php';


class tipo_unidadedao{

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
    
    public function salvar($tipo_unidade){

        $fields = array();
        $fields['ds_unidade'] = $tipo_unidade->getds_unidade();
        $fields['ic_status'] = $tipo_unidade->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($tipo_unidade->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("tipos_unidades", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("tipos_unidades", $fields, " pk = ".$tipo_unidade->getpk());
        }

    }

    public function excluir($tipo_unidade){
        $this->db->execDelete("tipos_unidades"," pk = ".$tipo_unidade->getpk());
    }

    public function carregarPorPk($pk){

        $tipo_unidade = new tipo_unidade();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_unidade ";
        $sql.="       ,ic_status ";


        $sql.="  from tipos_unidades ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $tipo_unidade->setpk($query[$i]["pk"]);
                $tipo_unidade->setdt_cadastro($query[$i]["dt_cadastro"]);
                $tipo_unidade->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $tipo_unidade->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $tipo_unidade->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $tipo_unidade->setds_unidade($query[$i]['ds_unidade']);
                $tipo_unidade->setic_status($query[$i]['ic_status']);

            }
        }
        return $tipo_unidade;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_unidade ";
        $sql.="       ,ic_status ";

        $sql.="  from tipos_unidades ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_unidade($ds_unidade){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_unidade ";
        $sql.="       ,ic_status ";

        $sql.="  from tipos_unidades ";
        $sql.=" where 1=1 ";
        if($ds_unidade != ""){
            $sql.=" and ds_tipo_unidade like '%".$ds_unidade."%' ";
        }
        $sql.=" order by ds_unidade asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_unidade ";
        $sql.="       ,ic_status ";

        $sql.="  from tipos_unidades ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_unidade asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
