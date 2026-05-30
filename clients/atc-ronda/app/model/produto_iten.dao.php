<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/produto_iten.class.php';


class produto_itendao{

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
    
    public function salvar($produto_iten){

        $fields = array();
        $fields['ds_n_serie'] = $produto_iten->getds_n_serie();
        $fields['qtde'] = $produto_iten->getqtde();
        $fields['vl_item'] = $produto_iten->getvl_item();
        $fields['produtos_pk'] = $produto_iten->getprodutos_pk();
        $fields['entrada_estoque_pk'] = $produto_iten->getentrada_estoque_pk();
        if($produto_iten->getdt_baixa()!=""){
            $fields['dt_baixa'] = DataYMD($produto_iten->getdt_baixa());
            $fields['usuario_baixa_pk'] = $this->arrToken['usuarios_pk'];
        }
        
        $fields['obs_baixa'] = $produto_iten->getobs_baixa();
        $fields['ds_identificacao'] = $produto_iten->getds_identificacao();
        $fields['polos_pk'] = $produto_iten->getpolos_pk();
        $fields['dt_cancelamento'] = $produto_iten->getdt_cancelamento();
        $fields['ds_motivo_cancelamento'] = $produto_iten->getds_motivo_cancelamento();
        $fields['compras_pk'] = $produto_iten->getcompras_pk();
        $fields['ic_entrega'] = $produto_iten->getic_entrega();
        
        
        
        $produto_iten->setds_identificacao($produto_iten->getds_identificacao());
        $produto_iten->setpolos_pk($produto_iten->getpolos_pk());
        $produto_iten->setdt_cancelamento($produto_iten->getdt_cancelamento());
        $produto_iten->setds_motivo_cancelamento($produto_iten->getds_motivo_cancelamento());
        $produto_iten->setcompras_pk($produto_iten->getcompras_pk());
        $produto_iten->setic_entrega($produto_iten->getic_entrega());
        


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($produto_iten->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("produtos_itens", $fields);
            return $pk;
        }
        else{
            $this->db->execUpdate("produtos_itens", $fields, " pk = ".$produto_iten->getpk());
            return $produto_iten->getpk();
        }

    }

    public function excluir($produto_iten){
        $this->db->execDelete("produtos_itens"," pk = ".$produto_iten->getpk());
    }
    public function excluirEstoque($entrada_estoque_pk){
        $this->db->execDelete("produtos_itens"," entrada_estoque_pk = ".$entrada_estoque_pk);
    }

    public function carregarPorPk($pk){

        $produto_iten = new produto_iten();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_n_serie ";
        $sql.="       ,qtde ";
        $sql.="       ,vl_item ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,entrada_estoque_pk";
        $sql.="       ,dt_baixa";
        $sql.="       ,obs_baixa";
        $sql.="       ,usuario_baixa_pk";


        $sql.="  from produtos_itens ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $produto_iten->setpk($query[$i]["pk"]);
                $produto_iten->setdt_cadastro($query[$i]["dt_cadastro"]);
                $produto_iten->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $produto_iten->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $produto_iten->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $produto_iten->setds_n_serie($query[$i]['ds_n_serie']);
                $produto_iten->setqtde($query[$i]['qtde']);
                $produto_iten->setvl_item($query[$i]['vl_item']);
                $produto_iten->setprodutos_pk($query[$i]['produtos_pk']);
                $produto_iten->setentrada_estoque_pk($query[$i]['entrada_estoque_pk']);

            }
        }
        return $produto_iten;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_n_serie ";
        $sql.="       ,qtde ";
        $sql.="       ,vl_item ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,entrada_estoque_pk";
        $sql.="       ,dt_baixa";
        $sql.="       ,obs_baixa";
        $sql.="       ,usuario_baixa_pk";
        $sql.="       ,ic_entrega";

        $sql.="  from produtos_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPorLeadsPk($leads_pk,$colaborador_pk){

        $sql ="";
        $sql.="select pi.pk";

        $sql.="  from produtos_itens pi";
        $sql.="  inner join movimentacao_estoque me on pi.pk = me.produtos_itens_pk";
        $sql.="  where 1=1";
        if($leads_pk!=""){
            $sql.=" and me.leads_pk = $leads_pk ";
        }
        if($colaborador_pk!=""){
            $sql.=" and me.colaborador_pk = $colaborador_pk ";
        }
     
        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    public function listarPorPkProduto($produtos_pk,$produtos_itens_pk,$strProdutoGrid){
            $data = date("Y-m-d");
            //VERIFICA OS PRODUTOS_ITENS QUE JA FORAM MOVIMENTADOS
            $sql="";
            $sql.="select me.produtos_itens_pk from movimentacao_estoque me inner join produtos_itens pi on me.produtos_itens_pk = pi.pk";
            $sql.=" where 1=1 ";
            if($produtos_pk!=""){
                $sql.=" and pi.produtos_pk  = ".$produtos_pk;
            }
            if($produtos_itens_pk!=""){
                $sql.=" and me.produtos_itens_pk not in (".$produtos_itens_pk.")";
            }
            //$sql.=" and (me.dt_devolucao is null or dt_devolucao < '".$data."')";
            $query_movimentacao_estoque = $this->db->execQuery($sql);

           
        //CARREGA A QUANTIDADE DE PRODUTOS CADASTRADA NO ESTOQUE.
        $sql="";
        $sql.="select sum(qtde)qtde from entrada_estoque where 1=1";
        if($produtos_pk!=""){
            $sql.=" and produtos_pk = ".$produtos_pk;
        }

        $query_qtde = $this->db->execQuery($sql);
        
        $sql ="select pi.pk ";
        $sql.="     ,date_format(pi.dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="     ,pi.usuario_cadastro_pk ";
        $sql.="     ,date_format(pi.dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="     ,pi.usuario_ult_atualizacao_pk ";
        $sql.="     ,pi.ds_n_serie ";
        $sql.="     ,pi.qtde ";
        $sql.="     ,pi.vl_item ";
        $sql.="     ,pi.produtos_pk ";
        $sql.="     ,pi.entrada_estoque_pk";
        $sql.="     ,p.ds_produto ";
        $sql.="       ,pi.dt_baixa";
        $sql.="       ,pi.obs_baixa";
        $sql.="       ,pi.usuario_baixa_pk";
        $sql.="  from produtos_itens pi ";
        $sql.="     inner join produtos p on pi.produtos_pk = p.pk";
        $sql.="     inner join entrada_estoque ee on pi.entrada_estoque_pk = ee.pk";
        $sql.=" where 1=1";
        if($produtos_pk!=""){
            $sql.=" and pi.produtos_pk = ".$produtos_pk;
        }
        if(count($query_movimentacao_estoque) > 0){
            $sql.=" and pi.pk not in (";
            for($i=0;$i < count($query_movimentacao_estoque);$i++){
                $sql.=$query_movimentacao_estoque[$i]['produtos_itens_pk'].",";
            }
            $sql.=" 0)";
        }
        if($strProdutoGrid!=""){
            $sql.=" and pi.pk ".$strProdutoGrid;
        }
        if($query_qtde[0]['qtde']==null){
            $sql.=" limit 0";
        }
        else{
            $sql.=" limit ".$query_qtde[0]['qtde'];
        }
     

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_n_serie($ds_n_serie){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_n_serie ";
        $sql.="       ,qtde ";
        $sql.="       ,vl_item ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,entrada_estoque_pk";
        $sql.="       ,dt_baixa";
        $sql.="       ,obs_baixa";
        $sql.="       ,usuario_baixa_pk";
        $sql.="  from produtos_itens ";
        $sql.=" where 1=1 ";
        if($ds_n_serie != ""){
            $sql.=" and ds_produto_iten like '%".$ds_n_serie."%' ";
        }
        $sql.=" order by ds_n_serie asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorProdutosQtde($produtos_pk,$qtde){
        
        
         $data = date("Y-m-d");
            //VERIFICA OS PRODUTOS_ITENS QUE JA FORAM MOVIMENTADOS
            $sql="";
            $sql.="select me.produtos_itens_pk from movimentacao_estoque me inner join produtos_itens pi on me.produtos_itens_pk = pi.pk";
            $sql.=" where 1=1 ";
            if($produtos_pk!=""){
                $sql.=" and pi.produtos_pk  = ".$produtos_pk;
            }
            if($produtos_itens_pk!=""){
                $sql.=" and me.produtos_itens_pk not in (".$produtos_itens_pk.")";
            }
            //$sql.=" and (me.dt_devolucao is null or dt_devolucao < '".$data."')";
            $query_movimentacao_estoque = $this->db->execQuery($sql);

           
        //CARREGA A QUANTIDADE DE PRODUTOS CADASTRADA NO ESTOQUE.
        $sql="";
        $sql.="select sum(qtde)qtde from entrada_estoque where 1=1";
        if($produtos_pk!=""){
            $sql.=" and produtos_pk = ".$produtos_pk;
        }
        if($query_qtde[0]['qtde']!=null){
            $quantidade = $qtde - $query_qtde[0]['qtde'];
        }
        else{
            $quantidade = $qtde;
        }
        

        $sql ="";
        $sql.="select pi.pk ";
        $sql.="     ,date_format(pi.dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="     ,pi.usuario_cadastro_pk ";
        $sql.="     ,date_format(pi.dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="     ,pi.usuario_ult_atualizacao_pk ";
        $sql.="     ,pi.ds_n_serie ";
        $sql.="     ,pi.qtde ";
        $sql.="     ,pi.vl_item ";
        $sql.="     ,pi.produtos_pk ";
        $sql.="     ,pi.entrada_estoque_pk";
        $sql.="     ,p.ds_produto ";
        $sql.="       ,pi.dt_baixa";
        $sql.="       ,pi.obs_baixa";
        $sql.="       ,pi.usuario_baixa_pk";
        $sql.="  from produtos_itens pi ";
        $sql.="     inner join produtos p on pi.produtos_pk = p.pk";
        $sql.="     inner join entrada_estoque ee on pi.entrada_estoque_pk = ee.pk";
        $sql.=" where 1=1 ";
        if($produtos_pk != ""){
            $sql.=" and pi.produtos_pk  = ".$produtos_pk;
        }
        
        if(count($query_movimentacao_estoque) > 0){
            $sql.=" and pi.pk not in (";
            for($i=0;$i < count($query_movimentacao_estoque);$i++){
                $sql.=$query_movimentacao_estoque[$i]['produtos_itens_pk'].",";
            }
            $sql.=" 0)";
        }
        if($strProdutoGrid!=""){
            $sql.=" and pi.pk ".$strProdutoGrid;
        }
        
        
        $sql.=" order by pi.pk asc ";
        if($quantidade > 0){
            $sql.=" limit ".$quantidade;
        }
        else{
            $sql.=" limit 0";
        }
            
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_entrada_estoque_pk($entrada_estoque_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_n_serie ";
        $sql.="       ,qtde ";
        $sql.="       ,vl_item ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,entrada_estoque_pk";
        $sql.="       ,dt_baixa";
        $sql.="       ,obs_baixa";
        $sql.="       ,usuario_baixa_pk";
        $sql.="  from produtos_itens ";
        $sql.=" where 1=1 ";
        if($entrada_estoque_pk != ""){
            $sql.=" and entrada_estoque_pk =".$entrada_estoque_pk;
        }
        $sql.=" order by ds_n_serie asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_entrada_estoque_pk_N_serie($entrada_estoque_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_n_serie ";
        $sql.="       ,qtde ";
        $sql.="       ,vl_item ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,entrada_estoque_pk";
        $sql.="       ,dt_baixa";
        $sql.="       ,obs_baixa";
        $sql.="       ,usuario_baixa_pk";
        $sql.="  from produtos_itens ";
        $sql.=" where 1=1 ";
        if($entrada_estoque_pk != ""){
            $sql.=" and entrada_estoque_pk =".$entrada_estoque_pk;
        }
        $sql.=" and ds_n_serie is not null";
        $sql.=" order by ds_n_serie asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){
        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_n_serie ";
        $sql.="       ,qtde ";
        $sql.="       ,vl_item ";
        $sql.="       ,produtos_pk ";
        $sql.="       ,entrada_estoque_pk";
        $sql.="       ,dt_baixa";
        $sql.="       ,obs_baixa";
        $sql.="       ,usuario_baixa_pk";
        $sql.="  from produtos_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_n_serie asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPorCompra($compras_pk){
        $sql ="";
        $sql.="select pi.pk, pi.dt_cadastro, pi.usuario_cadastro_pk, pi.dt_ult_atualizacao, pi.usuario_ult_atualizacao_pk ";
        $sql.="       ,pi.ds_n_serie ";
        $sql.="       ,pi.qtde ";
        $sql.="       ,pi.vl_item ";
        $sql.="       ,pi.produtos_pk ";
        $sql.="       ,pi.entrada_estoque_pk";
        $sql.="       ,pi.dt_baixa";
        $sql.="       ,pi.obs_baixa";
        $sql.="       ,pi.usuario_baixa_pk";
        $sql.="       ,pi.ic_entrega";
        $sql.="       ,case pi.ic_entrega when 1 then 'Não' when 2 then 'Sim' end ds_entrega";
        $sql.="       ,cp.ds_categoria";
        $sql.="       ,p.categorias_produto_pk";
        $sql.="       ,p.ds_produto";
        $sql.="  from produtos_itens pi";
        $sql.="  inner join produtos p on pi.produtos_pk = p.pk";
        $sql.="  inner join categorias_produto cp on p.categorias_produto_pk = cp.pk";
        $sql.=" where 1=1 ";
        if($compras_pk!=""){
            $sql.=" and pi.compras_pk = ".$compras_pk;
        }

        $query = $this->db->execQuery($sql);
        return $query;
    }
}

?>
