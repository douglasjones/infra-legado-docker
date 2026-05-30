<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/categoria_produto.class.php';


class categoria_produtodao{

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
    
    public function salvar($categoria_produto){

        $fields = array();
        $fields['ds_categoria'] = $categoria_produto->getds_categoria();
        $fields['ic_status'] = $categoria_produto->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($categoria_produto->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("categorias_produto", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("categorias_produto", $fields, " pk = ".$categoria_produto->getpk());
        }

    }

    public function excluir($categoria_produto){
        $this->db->execDelete("categorias_produto"," pk = ".$categoria_produto->getpk());
    }

    public function carregarPorPk($pk){

        $categoria_produto = new categoria_produto();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_categoria ";
        $sql.="       ,ic_status ";


        $sql.="  from categorias_produto ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $categoria_produto->setpk($query[$i]["pk"]);
                $categoria_produto->setdt_cadastro($query[$i]["dt_cadastro"]);
                $categoria_produto->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $categoria_produto->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $categoria_produto->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $categoria_produto->setds_categoria($query[$i]['ds_categoria']);
                $categoria_produto->setic_status($query[$i]['ic_status']);

            }
        }
        return $categoria_produto;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_categoria ";
        $sql.="       ,ic_status ";

        $sql.="  from categorias_produto ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_categoria($ds_categoria){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_categoria ";
        $sql.="       ,CASE  WHEN ic_status=1 THEN 'Ativo' ELSE 'Desativado' END ds_status  ";
        $sql.="       ,ic_status ";
        $sql.="  from categorias_produto ";
        $sql.=" where 1=1 ";
        if($ds_categoria != ""){
            $sql.=" and ds_categoria_produto like '%".$ds_categoria."%' ";
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

        $sql.="  from categorias_produto ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_categoria asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }

}

?>
