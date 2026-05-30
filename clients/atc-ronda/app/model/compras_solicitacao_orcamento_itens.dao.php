<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/compras_solicitacao_orcamento_itens.class.php';
require_once '../model/compra.dao.php';


class compras_solicitacao_orcamento_itensdao{

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
    
    public function salvar($compras_solicitacao_orcamento_itens, $token){
        $fields = array();
        $fields['categorias_produto_pk'] = $compras_solicitacao_orcamento_itens->getcategorias_produto_pk();
        $fields['produtos_pk'] = $compras_solicitacao_orcamento_itens->getprodutos_pk();
        $fields['ds_produto'] = $compras_solicitacao_orcamento_itens->getds_produto();
        $fields['qtde_produto'] = $compras_solicitacao_orcamento_itens->getqtde_produto();
        $fields['vl_unitario'] = moeda2float($compras_solicitacao_orcamento_itens->getvl_unitario());
        $fields['compras_solicitacao_orcamentos_pk'] = $compras_solicitacao_orcamento_itens->getcompras_solicitacao_orcamentos_pk();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($compras_solicitacao_orcamento_itens->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("compras_solicitacao_orcamento_itens", $fields);
        }
        else{
            $this->db->execUpdate("compras_solicitacao_orcamento_itens", $fields, " pk = ".$compras_solicitacao_orcamento_itens->getpk());
            $pk = $compras_solicitacao_orcamento_itens->getpk();
        } 

        $sql = '';
        $sql .= 'Select c.pk compras_pk from compras_solicitacao_orcamentos cso'; 
        $sql .= ' inner join compras c on c.compra_solicitacao_pk = cso.compra_solicitacao_pk ';
        $sql .= ' where cso.pk ='.$compras_solicitacao_orcamento_itens->getcompras_solicitacao_orcamentos_pk();
        $query = $this->db->execQuery($sql);
        $compras_pk = $query[0]['compras_pk'];

        $produtos_pk = $compras_solicitacao_orcamento_itens->getprodutos_pk();
        $qtde = $compras_solicitacao_orcamento_itens->getqtde_produto();
        $vl_item = $compras_solicitacao_orcamento_itens->getvl_unitario();
        $vl_item = $compras_solicitacao_orcamento_itens->getvl_unitario();

        if($compras_pk > 0){
            $compradao = new compradao();
            $compradao->setToken($token);
            $compradao->salvarProduto('', $compras_pk, $produtos_pk, $qtde, $vl_item, '', $token);
        }
        return $pk;

    }

    public function excluir($compras_solicitacao_orcamento_itens){
        $this->db->execDelete("compras_solicitacao_orcamento_itens"," pk = ".$compras_solicitacao_orcamento_itens->getpk());
    }

     public function excluirPorSolicitacaoOrcamento($compras_solicitacao_orcamentos_pk){
        $this->db->execDelete("compras_solicitacao_orcamento_itens"," compras_solicitacao_orcamentos_pk = ".$compras_solicitacao_orcamentos_pk);
    }
    
    
    public function carregarPorPk($pk){

        $compras_solicitacao_orcamento_itens = new compras_solicitacao_orcamento_itens();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,categorias_produto_pk ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,qtde_produto ";
        $sql.="       ,vl_unitario ";
        $sql.="       ,compras_solicitacao_orcamentos_pk ";


        $sql.="  from compras_solicitacao_orcamento_itens ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $compras_solicitacao_orcamento_itens->setpk($query[$i]["pk"]);
                $compras_solicitacao_orcamento_itens->setdt_cadastro($query[$i]["dt_cadastro"]);
                $compras_solicitacao_orcamento_itens->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $compras_solicitacao_orcamento_itens->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $compras_solicitacao_orcamento_itens->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $compras_solicitacao_orcamento_itens->setcategorias_produto_pk($query[$i]['categorias_produto_pk']);
                $compras_solicitacao_orcamento_itens->setprodutos_pk($query[$i]['produtos_pk']);
                $compras_solicitacao_orcamento_itens->setqtde_produto($query[$i]['qtde_produto']);
                $compras_solicitacao_orcamento_itens->setvl_unitario($query[$i]['vl_unitario']);
                $compras_solicitacao_orcamento_itens->setcompras_solicitacao_orcamentos_pk($query[$i]['compras_solicitacao_orcamentos_pk']);

            }
        }
        return $compras_solicitacao_orcamento_itens;
    }

    public function listarItensOrcamentoPk($compras_solicitacao_orcamentos_pk){

        $sql ="";
        $sql.="select cs.pk, cs.dt_cadastro, cs.usuario_cadastro_pk, cs.dt_ult_atualizacao, cs.usuario_ult_atualizacao_pk  ";
        $sql.="       ,cs.categorias_produto_pk ";
        $sql.="       ,cp.ds_categoria "; 
        $sql.="       ,cs.produtos_pk ";
        $sql.="       ,p.ds_produto ";
        $sql.="       ,cs.ds_produto ds_produto_itens ";
        $sql.="       ,cs.qtde_produto ";
        $sql.="       ,cs.vl_unitario ";
        $sql.="       ,cs.compras_solicitacao_orcamentos_pk ";
        $sql.="  from compras_solicitacao_orcamento_itens cs "; 
        $sql.="  inner join categorias_produto cp on cs.categorias_produto_pk = cp.pk";
        $sql.="  left join produtos p on cs.produtos_pk = p.pk";
        $sql.=" where cs.compras_solicitacao_orcamentos_pk =".$compras_solicitacao_orcamentos_pk;

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,categorias_produto_pk ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,qtde_produto ";
        $sql.="       ,vl_unitario ";
        $sql.="       ,compras_solicitacao_orcamentos_pk ";

        $sql.="  from compras_solicitacao_orcamento_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_categorias_produto_pk($categorias_produto_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,categorias_produto_pk ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,qtde_produto ";
        $sql.="       ,vl_unitario ";
        $sql.="       ,compras_solicitacao_orcamentos_pk ";

        $sql.="  from compras_solicitacao_orcamento_itens ";
        $sql.=" where 1=1 ";
        if($categorias_produto_pk != ""){
            $sql.=" and ds_compras_solicitacao_orcamento_itens like '%".$categorias_produto_pk."%' ";
        }
        $sql.=" order by categorias_produto_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,categorias_produto_pk ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,qtde_produto ";
        $sql.="       ,vl_unitario ";
        $sql.="       ,compras_solicitacao_orcamentos_pk ";

        $sql.="  from compras_solicitacao_orcamento_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by categorias_produto_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
