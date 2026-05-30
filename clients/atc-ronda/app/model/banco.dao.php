<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/banco.class.php';


class bancodao{

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
    
    public function salvar($banco){

        $fields = array();
        $fields['ds_banco'] = $banco->getds_banco();
        $fields['cod_banco'] = $banco->getcod_banco();
        $fields['ic_status'] = $banco->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($banco->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("bancos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("bancos", $fields, " pk = ".$banco->getpk());
        }

    }

    public function excluir($banco){
        $this->db->execDelete("bancos"," pk = ".$banco->getpk());
    }

    public function carregarPorPk($pk){

        $banco = new banco();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_banco ";
        $sql.="       ,cod_banco ";
        $sql.="       ,ic_status ";


        $sql.="  from bancos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $banco->setpk($query[$i]["pk"]);
                $banco->setdt_cadastro($query[$i]["dt_cadastro"]);
                $banco->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $banco->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $banco->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $banco->setds_banco($query[$i]['ds_banco']);
                $banco->setcod_banco($query[$i]['cod_banco']);
                $banco->setic_status($query[$i]['ic_status']);

            }
        }
        return $banco;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_banco ";
        $sql.="       ,cod_banco ";
        $sql.="       ,ic_status ";

        $sql.="  from bancos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_banco($ds_banco){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_banco ";
        $sql.="       ,cod_banco ";
        $sql.="       ,ic_status ";

        $sql.="  from bancos ";
        $sql.=" where 1=1 ";
        if($ds_banco != ""){
            $sql.=" and ds_banco like '%".$ds_banco."%' ";
        }
        $sql.=" and ic_status=1 ";
        $sql.=" order by ds_banco asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_banco ";
        $sql.="       ,cod_banco ";
        $sql.="       ,ic_status ";

        $sql.="  from bancos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_banco asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
