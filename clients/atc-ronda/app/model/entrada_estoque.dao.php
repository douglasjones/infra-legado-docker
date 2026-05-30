<?
require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/entrada_estoque.class.php';

class entrada_estoquedao{
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
    
    public function salvar($entrada_estoque){
        $fields = array();
        $fields['ds_n_ordem'] = $entrada_estoque->getds_n_ordem();
        $fields['obs_entrada_estoque'] = $entrada_estoque->getobs_entrada_estoque();
        $fields['fornecedor_pk'] = $entrada_estoque->getfornecedor_pk();
        $fields['produtos_pk'] = $entrada_estoque->getprodutos_pk();
        $fields['qtde'] = $entrada_estoque->getqtde();
        $fields['vl_unitario'] = $entrada_estoque->getvl_unitario();
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($entrada_estoque->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("entrada_estoque", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("entrada_estoque", $fields, " pk = ".$entrada_estoque->getpk());
        }

    }

    public function excluir($entrada_estoque){
        $this->db->execDelete("entrada_estoque"," pk = ".$entrada_estoque->getpk());
    }

    public function carregarPorPk($pk){

        $entrada_estoque = new entrada_estoque();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_n_ordem ";
        $sql.="       ,obs_entrada_estoque ";
        $sql.="       ,fornecedor_pk ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,qtde ";
        $sql.="       ,vl_unitario ";
        $sql.="  from entrada_estoque ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $entrada_estoque->setpk($query[$i]["pk"]);
                $entrada_estoque->setdt_cadastro($query[$i]["dt_cadastro"]);
                $entrada_estoque->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $entrada_estoque->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $entrada_estoque->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
                $entrada_estoque->setds_n_ordem($query[$i]['ds_n_ordem']);
                $entrada_estoque->setobs_entrada_estoque($query[$i]['obs_entrada_estoque']);
                $entrada_estoque->setfornecedor_pk($query[$i]['fornecedor_pk']);
                $entrada_estoque->setprodutos_pk($query[$i]['produtos_pk']);
                $entrada_estoque->setqtde($query[$i]['qtde']);
            }
        }
        return $entrada_estoque;
    }

    public function listarPorPk($pk){
        $sql ="";
        $sql.="select ee.pk, ee.dt_cadastro, ee.usuario_cadastro_pk, ee.dt_ult_atualizacao, ee.usuario_ult_atualizacao_pk  ";
        $sql.="       ,ee.ds_n_ordem ";
        $sql.="       ,ee.obs_entrada_estoque ";
        $sql.="       ,ee.fornecedor_pk ";
        $sql.="       ,ee.produtos_pk ";
        $sql.="       ,ee.qtde ";
        $sql.="       ,ee.vl_unitario";
        $sql.="       ,p.categorias_produto_pk";
        $sql.="  from entrada_estoque ee";
        $sql.="       inner join produtos p on ee.produtos_pk = p.pk";
        $sql.=" where ee.pk = $pk ";
       
        
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkProdutoItem($pk){
        $sql ="";
        $sql.="select pk";
        $sql.="  from produtos_itens";
        $sql.=" where entrada_estoque_pk = $pk ";
       
        
        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listar_por_ds_n_ordem($ds_n_ordem){
        $sql ="";
        $sql.="select ee.pk";
        $sql.="       ,date_format(ee.dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="       ,ee.usuario_cadastro_pk, ee.dt_ult_atualizacao, ee.usuario_ult_atualizacao_pk ";
        $sql.="       ,ee.ds_n_ordem ";
        $sql.="       ,ee.obs_entrada_estoque ";
        $sql.="       ,ee.fornecedor_pk ";
        $sql.="       ,ee.produtos_pk ";
        $sql.="       ,ee.qtde ";
        $sql.="       ,ee.vl_unitario";
        $sql.="       ,f.ds_fornecedor ";
        $sql.="       ,p.ds_produto ";
        $sql.="  from entrada_estoque ee";
        $sql.="  left join fornecedor f on ee.fornecedor_pk = f.pk ";
        $sql.="  left join produtos p on ee.produtos_pk = p.pk ";
        $sql.=" where 1=1 ";
        
        
        $sql.=" order by ee.ds_n_ordem asc ";  

        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarTodos(){
        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_n_ordem ";
        $sql.="       ,obs_entrada_estoque ";
        $sql.="       ,fornecedor_pk ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,qtde ";
        $sql.="       ,vl_unitario ";

        $sql.="  from entrada_estoque ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_n_ordem asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
}
?>
