<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/itens_fatura.class.php';


class itens_faturadao{

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
    
    public function salvar($itens_fatura){

        $fields = array();
        $fields['tipo_item_fatura'] = $itens_fatura->gettipo_item_fatura();
        $fields['vl_total'] = $itens_fatura->getvl_total();
        $fields['fatura_pk'] = $itens_fatura->getfatura_pk();
        $fields['ds_descricao'] = $itens_fatura->getds_descricao();


        if($itens_fatura->getpk()  == ""){


            $pk = $this->db->execInsert("itens_fatura", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("itens_fatura", $fields, " pk = ".$itens_fatura->getpk());
        }

    }

    public function excluir($itens_fatura){
        $this->db->execDelete("itens_fatura"," pk = ".$itens_fatura->getpk());
    }

    public function carregarPorPk($pk){

        $itens_fatura = new itens_fatura();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,tipo_item_fatura ";
        $sql.="       ,vl_total ";
        $sql.="       ,fatura_pk ";
        $sql.="       ,ds_descricao";


        $sql.="  from itens_fatura ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $itens_fatura->setpk($query[$i]["pk"]);
                $itens_fatura->setdt_cadastro($query[$i]["dt_cadastro"]);
                $itens_fatura->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $itens_fatura->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $itens_fatura->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $itens_fatura->settipo_item_fatura($query[$i]['tipo_item_fatura']);
                $itens_fatura->setvl_total($query[$i]['vl_total']);
                $itens_fatura->setfatura_pk($query[$i]['fatura_pk']);

            }
        }
        return $itens_fatura;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_item_fatura ";
        $sql.="       ,vl_total ";
        $sql.="       ,fatura_pk ";
        $sql.="       ,ds_descricao";

        $sql.="  from itens_fatura ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_tipo_item_fatura($tipo_item_fatura){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_item_fatura ";
        $sql.="       ,vl_total ";
        $sql.="       ,fatura_pk ";
        $sql.="       ,ds_descricao";

        $sql.="  from itens_fatura ";
        $sql.=" where 1=1 ";
        if($tipo_item_fatura != ""){
            $sql.=" and ds_itens_fatura like '%".$tipo_item_fatura."%' ";
        }
        $sql.=" order by tipo_item_fatura asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_item_fatura ";
        $sql.="       ,vl_total ";
        $sql.="       ,fatura_pk ";
        $sql.="       ,ds_descricao";

        $sql.="  from itens_fatura ";
        $sql.=" where 1=1 ";
        $sql.=" order by tipo_item_fatura asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
