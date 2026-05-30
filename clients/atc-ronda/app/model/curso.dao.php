<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/curso.class.php';


class cursodao{

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
    
    public function salvar($curso){

        $fields = array();
        $fields['ds_curso'] = $curso->getds_curso();
        $fields['ic_status'] = $curso->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($curso->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("cursos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("cursos", $fields, " pk = ".$curso->getpk());
        }

    }

    public function excluir($curso){
        $this->db->execDelete("cursos"," pk = ".$curso->getpk());
    }

    public function carregarPorPk($pk){

        $curso = new curso();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_curso ";
        $sql.="       ,ic_status ";


        $sql.="  from cursos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $curso->setpk($query[$i]["pk"]);
                $curso->setdt_cadastro($query[$i]["dt_cadastro"]);
                $curso->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $curso->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $curso->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $curso->setds_curso($query[$i]['ds_curso']);
                $curso->setic_status($query[$i]['ic_status']);

            }
        }
        return $curso;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_curso ";
        $sql.="       ,ic_status ";

        $sql.="  from cursos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_curso($ds_curso,$ic_status){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_curso ";
        $sql.="       ,ic_status ";
        $sql.="       ,case ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";

        $sql.="  from cursos ";
        $sql.=" where 1=1 ";
        if($ds_curso != ""){
            $sql.=" and ds_curso like '%".$ds_curso."%' ";
        }
        if($ic_status!=""){
            $sql.=" and ic_status = ".$ic_status;
        }
        $sql.=" order by ds_curso asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_curso ";
        $sql.="       ,ic_status ";

        $sql.="  from cursos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_curso asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarTodosAtivo(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_curso ";
        $sql.="       ,ic_status ";

        $sql.="  from cursos ";
        $sql.=" where 1=1 ";
        $sql.=" and ic_status = 1";
        $sql.=" order by ds_curso asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
