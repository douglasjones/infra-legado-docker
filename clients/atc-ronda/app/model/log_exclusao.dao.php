<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/log_exclusao.class.php';


class log_exclusaodao{

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
    
    public function salvar($ds_modulo,$pk_modulo){

        $fields = array();
        $fields['ds_modulo'] = $ds_modulo;
        $fields['pk_modulo'] = $pk_modulo;

        //if($log_exclusao->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $this->db->execInsert("log_exclusao", $fields);
        /*    return $pk;
        }
        else{
            return $this->db->execUpdate("log_exclusao", $fields, " pk = ".$log_exclusao->getpk());
        }*/

    }

    public function excluir($log_exclusao){
        $this->db->execDelete("log_exclusao"," pk = ".$log_exclusao->getpk());
    }

    public function carregarPorPk($pk){

        $log_exclusao = new log_exclusao();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";

        $sql.="       ,ds_modulo ";
        $sql.="       ,pk_modulo ";


        $sql.="  from log_exclusao ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $log_exclusao->setpk($query[$i]["pk"]);
                $log_exclusao->setdt_cadastro($query[$i]["dt_cadastro"]);
                $log_exclusao->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);

                $log_exclusao->setds_modulo($query[$i]['ds_modulo']);
                $log_exclusao->setpk_modulo($query[$i]['pk_modulo']);

            }
        }
        return $log_exclusao;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk  ";
        $sql.="       ,ds_modulo ";
        $sql.="       ,pk_modulo ";

        $sql.="  from log_exclusao ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_modulo($ds_modulo){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk ";
        $sql.="       ,ds_modulo ";
        $sql.="       ,pk_modulo ";

        $sql.="  from log_exclusao ";
        $sql.=" where 1=1 ";
        if($ds_modulo != ""){
            $sql.=" and ds_log_exclusao like '%".$ds_modulo."%' ";
        }
        $sql.=" order by ds_modulo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk ";
        $sql.="       ,ds_modulo ";
        $sql.="       ,pk_modulo ";

        $sql.="  from log_exclusao ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_modulo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
