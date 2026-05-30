<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/categoria_financeira.class.php';


class categoria_financeiradao{

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
    
    public function salvar($categoria_financeira){

        $fields = array();
        $fields['ds_categoria'] = $categoria_financeira->getds_categoria();
        $fields['ic_status'] = $categoria_financeira->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($categoria_financeira->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("categorias_financeiras", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("categorias_financeiras", $fields, " pk = ".$categoria_financeira->getpk());
        }

    }

    public function excluir($categoria_financeira){
        $this->db->execDelete("categorias_financeiras"," pk = ".$categoria_financeira->getpk());
    }

    public function carregarPorPk($pk){

        $categoria_financeira = new categoria_financeira();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_categoria ";
        $sql.="       ,ic_status ";


        $sql.="  from categorias_financeiras ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $categoria_financeira->setpk($query[$i]["pk"]);
                $categoria_financeira->setdt_cadastro($query[$i]["dt_cadastro"]);
                $categoria_financeira->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $categoria_financeira->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $categoria_financeira->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $categoria_financeira->setds_categoria($query[$i]['ds_categoria']);
                $categoria_financeira->setic_status($query[$i]['ic_status']);

            }
        }
        return $categoria_financeira;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_categoria ";
        $sql.="       ,ic_status ";

        $sql.="  from categorias_financeiras ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_categoria($ds_categoria){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_categoria ";
        $sql.="       ,ic_status ";

        $sql.="  from categorias_financeiras ";
        $sql.=" where 1=1 ";
        if($ds_categoria != ""){
            $sql.=" and ds_categoria_financeira like '%".$ds_categoria."%' ";
        }
        $sql.=" order by ds_categoria asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_categoria ";
        $sql.="       ,ic_status ";

        $sql.="  from categorias_financeiras ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_categoria asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
