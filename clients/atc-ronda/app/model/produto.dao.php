<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/produto.class.php';


class produtodao{

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
    
    public function salvar($produto){

        $fields = array();
        $fields['ds_produto'] = $produto->getds_produto();
        $fields['obs'] = $produto->getobs();
        $fields['ic_status'] = $produto->getic_status();
        $fields['categorias_produto_pk'] = $produto->getcategorias_produto_pk();
        $fields['tipo_unidade_pk'] = $produto->gettipo_unidade_pk();
        $fields['ic_tempo_troca'] = $produto->getic_tempo_troca();
        $fields['qtde_minima'] = $produto->getqtde_minima();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($produto->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("produtos", $fields);
            //echo $this->db->getLastSQL();
            return $pk;
        }
        else{
            return $this->db->execUpdate("produtos", $fields, " pk = ".$produto->getpk());
        }

    }

    public function excluir($produto){
        $this->db->execDelete("produtos"," pk = ".$produto->getpk());
    }

    public function carregarPorPk($pk){

        $produto = new produto();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_produto ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";
        $sql.="       ,categorias_produto_pk ";
        $sql.="       ,tipo_unidade_pk ";
        $sql.="       ,ic_tempo_troca";
        $sql.="       ,qtde_minima";


        $sql.="  from produtos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $produto->setpk($query[$i]["pk"]);
                $produto->setdt_cadastro($query[$i]["dt_cadastro"]);
                $produto->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $produto->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $produto->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $produto->setds_produto($query[$i]['ds_produto']);
                $produto->setobs($query[$i]['obs']);
                $produto->setic_status($query[$i]['ic_status']);
                $produto->setcategorias_produto_pk($query[$i]['categorias_produto_pk']);
                $produto->settipo_unidade_pk($query[$i]['tipo_unidade_pk']);
                $produto->setic_tempo_troca($query[$i]['ic_tempo_troca']);
                $produto->setqtde_minima($query[$i]['qtde_minima']);

            }
        }
        return $produto;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_produto ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";
        $sql.="       ,categorias_produto_pk ";
        $sql.="       ,tipo_unidade_pk ";
        $sql.="       ,ic_tempo_troca";
        $sql.="       ,qtde_minima";

        $sql.="  from produtos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_produto($ds_produto){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_produto ";
        $sql.="       ,p.obs ";
        $sql.="       ,p.ic_status ";
        $sql.="       ,CASE  WHEN p.ic_status=1 THEN 'Ativo' ELSE 'Desativado' END ds_status  ";
        $sql.="       ,p.categorias_produto_pk ";
        $sql.="       ,p.tipo_unidade_pk ";
        $sql.="       ,p.ic_tempo_troca";
        $sql.="       ,p.qtde_minima";
        $sql.="       ,cp.ds_categoria ";
        $sql.="  from produtos p ";
        $sql.="  left join categorias_produto cp on p.categorias_produto_pk = cp.pk";
        $sql.=" where 1=1 ";
        if($ds_produto != ""){
            $sql.=" and p.ds_produto like '%".$ds_produto."%' ";
        }
        $sql.=" order by p.ds_produto asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarTodosComTempoTroca($ds_produto){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_produto ";
        $sql.="       ,p.obs ";
        $sql.="       ,p.ic_status ";
        $sql.="       ,CASE  WHEN p.ic_status=1 THEN 'Ativo' ELSE 'Desativado' END ds_status  ";
        $sql.="       ,p.categorias_produto_pk ";
        $sql.="       ,p.tipo_unidade_pk ";
        $sql.="       ,p.ic_tempo_troca";
        $sql.="       ,p.qtde_minima";
        $sql.="       ,cp.ds_categoria ";
        $sql.="  from produtos p ";
        $sql.="  left join categorias_produto cp on p.categorias_produto_pk = cp.pk";
        $sql.=" where 1=1 ";
        if($ds_produto != ""){
            $sql.=" and p.ds_produto like '%".$ds_produto."%' ";
        }
        $sql.=" and p.ic_tempo_troca is not null";
        $sql.=" order by p.ds_produto asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listar_por_categorias($categorias_produto_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_produto ";
        $sql.="       ,p.obs ";
        $sql.="       ,p.ic_status ";
        $sql.="       ,CASE  WHEN p.ic_status=1 THEN 'Ativo' ELSE 'Desativado' END ds_status  ";
        $sql.="       ,p.categorias_produto_pk ";
        $sql.="       ,p.tipo_unidade_pk ";
        $sql.="       ,p.ic_tempo_troca";
        $sql.="       ,p.qtde_minima";
        $sql.="       ,cp.ds_categoria ";
        $sql.="  from produtos p ";
        $sql.="  left join categorias_produto cp on p.categorias_produto_pk = cp.pk";
        $sql.=" where 1=1 ";
        if($categorias_produto_pk != ""){
            $sql.=" and p.categorias_produto_pk =".$categorias_produto_pk;
        }
        $sql.=" order by p.ds_produto asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    
    public function listar_por_pk_categoria($categorias_produto_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_produto ";
        $sql.="       ,p.obs ";
        $sql.="       ,p.ic_status ";
        $sql.="       ,CASE  WHEN p.ic_status=1 THEN 'Ativo' ELSE 'Desativado' END ds_status  ";
        $sql.="       ,p.categorias_produto_pk ";
        $sql.="       ,p.tipo_unidade_pk ";
        $sql.="       ,p.ic_tempo_troca";
        $sql.="       ,p.qtde_minima";
        $sql.="       ,cp.ds_categoria ";
        $sql.="  from produtos p ";
        $sql.="  left join categorias_produto cp on p.categorias_produto_pk = cp.pk";
        $sql.=" where 1=1 ";
        if($categorias_produto_pk != ""){
            $sql.=" and cp.pk".$categorias_produto_pk;
        }
        $sql.=" order by p.ds_produto asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_produto ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";
        $sql.="       ,categorias_produto_pk ";
        $sql.="       ,tipo_unidade_pk ";
        $sql.="       ,ic_tempo_troca";
        $sql.="       ,qtde_minima";

        $sql.="  from produtos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_produto asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
