<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/beneficio.class.php';


class beneficiodao{

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
    
    public function salvar($beneficio){

        $fields = array();
        $fields['ds_beneficio'] = $beneficio->getds_beneficio();
        $fields['ic_status'] = $beneficio->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($beneficio->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("beneficios", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("beneficios", $fields, " pk = ".$beneficio->getpk());
        }

    }

    public function excluir($beneficio){
        $this->db->execDelete("beneficios"," pk = ".$beneficio->getpk());
    }

    public function carregarPorPk($pk){

        $beneficio = new beneficio();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_beneficio ";
        $sql.="       ,ic_status ";


        $sql.="  from beneficios ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $beneficio->setpk($query[$i]["pk"]);
                $beneficio->setdt_cadastro($query[$i]["dt_cadastro"]);
                $beneficio->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $beneficio->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $beneficio->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $beneficio->setds_beneficio($query[$i]['ds_beneficio']);
                $beneficio->setic_status($query[$i]['ic_status']);

            }
        }
        return $beneficio;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_beneficio ";
        $sql.="       ,ic_status ";

        $sql.="  from beneficios ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_beneficio_colaboradores($colaborador_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,vl_beneficio ";
        $sql.="       ,obs";
        $sql.="       ,ic_status";
        $sql.="       ,beneficios_pk";
        $sql.="       ,colaborador_pk";

        $sql.="  from colaboradores_beneficios ";
        $sql.=" where 1=1 ";
        if($colaborador_pk!=""){
            $sql.=" and colaborador_pk = ".$colaborador_pk;
        }
        
        
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_beneficio($ds_beneficio,$ic_status){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_beneficio ";
        $sql.="       ,case ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ic_status";

        $sql.="  from beneficios ";
        $sql.=" where 1=1 ";
        if($ds_beneficio != ""){
            $sql.=" and ds_beneficio like '%".$ds_beneficio."%' ";
        }
        if($ic_status!=""){
            $sql.=" and ic_status = ".$ic_status;
        }
        $sql.=" order by ds_beneficio asc ";
  

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_beneficio ";
        $sql.="       ,ic_status ";

        $sql.="  from beneficios ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_beneficio asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
