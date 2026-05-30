<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/motivo_alteracao_escala.class.php';


class motivo_alteracao_escaladao{

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
    
    public function salvar($motivo_alteracao_escala){

        $fields = array();
        $fields['ds_motivo_alteracao_escala'] = $motivo_alteracao_escala->getds_motivo_alteracao_escala();
        $fields['ic_status'] = $motivo_alteracao_escala->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($motivo_alteracao_escala->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("motivo_alteracao_escala", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("motivo_alteracao_escala", $fields, " pk = ".$motivo_alteracao_escala->getpk());
        }

    }

    public function excluir($motivo_alteracao_escala){
        $this->db->execDelete("motivo_alteracao_escala"," pk = ".$motivo_alteracao_escala->getpk());
    }

    public function carregarPorPk($pk){

        $motivo_alteracao_escala = new motivo_alteracao_escala();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_motivo_alteracao_escala ";
        $sql.="       ,ic_status ";


        $sql.="  from motivo_alteracao_escala ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $motivo_alteracao_escala->setpk($query[$i]["pk"]);
                $motivo_alteracao_escala->setdt_cadastro($query[$i]["dt_cadastro"]);
                $motivo_alteracao_escala->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $motivo_alteracao_escala->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $motivo_alteracao_escala->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $motivo_alteracao_escala->setds_motivo_alteracao_escala($query[$i]['ds_motivo_alteracao_escala']);
                $motivo_alteracao_escala->setic_status($query[$i]['ic_status']);

            }
        }
        return $motivo_alteracao_escala;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_motivo_alteracao_escala ";
        $sql.="       ,ic_status ";

        $sql.="  from motivo_alteracao_escala ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_motivo_alteracao_escala($ds_motivo_alteracao_escala){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_motivo_alteracao_escala ";
        $sql.="       ,ic_status ";

        $sql.="  from motivo_alteracao_escala ";
        $sql.=" where 1=1 ";
        $sql.=" and ic_status = 1";
        $sql.=" order by ds_motivo_alteracao_escala asc ";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_motivo_alteracao_escala ";
        $sql.="       ,ic_status ";

        $sql.="  from motivo_alteracao_escala ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_motivo_alteracao_escala asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
