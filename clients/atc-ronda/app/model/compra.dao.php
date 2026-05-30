<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/compra.class.php';

require_once "../model/lancamento.dao.php";
require_once "../model/lancamento.class.php";

require_once "../model/produto_iten.dao.php";
require_once "../model/produto_iten.class.php";

require_once "../model/documento.dao.php";
require_once "../model/documento.class.php";

require_once "../model/entrada_estoque.dao.php";
require_once "../model/entrada_estoque.class.php";


class compradao{

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
    
    public function salvar($compra, $documentos_pk, $produtos_itens_pk, $token){
        $lancamentodao = new lancamentodao();
        $lancamentodao->setToken($token); 

        $produto_itendao = new produto_itendao();
        $produto_itendao->setToken($token); 

        $entrada_estoquedao = new entrada_estoquedao();
        $entrada_estoquedao->setToken($token); 
        
        $documentodao = new documentodao();
        $documentodao->setToken($token); 

        $fields = array();
        $fields['fornecedor_pk'] = $compra->getfornecedor_pk();
        $fields['categoria_pk'] = $compra->getcategoria_pk();
        $fields['conta_pk'] = $compra->getconta_pk();
        if($compra->getdt_pagamento()!=""){
            $fields['dt_pagamento'] = DataYMD($compra->getdt_pagamento());
        }
        
        $fields['vl_pagamento'] = $compra->getvl_pagamento();
        $fields['metodos_pagamento_pk'] = $compra->getmetodos_pagamento_pk();
        $fields['qtde_parcelas'] = $compra->getqtde_parcelas();
        $fields['ds_numero_nota'] = $compra->getds_numero_nota();
        $fields['ds_link_notafiscal'] = $compra->getds_link_notafiscal();
        if($compra->getdt_notafiscal()!=""){
            $fields['dt_notafiscal'] = DataYMD($compra->getdt_notafiscal());
        }
        $fields['vl_notafiscal'] = $compra->getvl_notafiscal();
        $fields['vl_frete'] = $compra->getvl_frete();
        
        if($compra->getdt_entrega()!=""){
            $fields['dt_entrega'] = DataYMD($compra->getdt_entrega());
        }
        $fields['ic_entregue'] = $compra->getic_entregue();
        $fields['obs'] = $compra->getobs();
        $fields['grupo_lancamento_centro_custo_pk'] = $compra->getgrupo_lancamento_centro_custo_pk();
        $fields['centro_custo_pk'] = $compra->getcentro_custo_pk();
        $fields['compra_solicitacao_pk'] = $compra->getcompra_solicitacao_pk();
        $fields['ic_status'] = $compra->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($compra->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("compras", $fields);
        }
        else{
            $this->db->execUpdate("compras", $fields, " pk = ".$compra->getpk());
            $pk = $compra->getpk();
        }

        $compras_pk = $pk;
        $qtde_parcelas = $compra->getqtde_parcelas();
        $dt_pagamento = $compra->getdt_pagamento();
        $conta_pk = $compra->getconta_pk();
        $fornecedor_pk = $compra->getfornecedor_pk();
        $centro_custo_pk = $compra->getcentro_custo_pk();
        $grupo_lancamento_centro_custo_pk = $compra->getgrupo_lancamento_centro_custo_pk();
        $vl_notafiscal = $compra->getvl_notafiscal();
        $metodos_pagamento_pk = $compra->getmetodos_pagamento_pk();
        $ic_status = $compra->getic_status();

        if($ic_status == 1){
            //SALVAR LANÇAMENTOS 
            if($pk==""){            
                if($qtde_parcelas>1){
                    for($i=0;$i<$qtde_parcelas;$i++){                    
                        $dt_parcelas = $this->listarDataDiff($dt_pagamento,$i);                   

                        $conta_bancaria_pk = $lancamentodao->listaContaEmpresa($conta_pk);

                        $lancamento = $lancamentodao->carregarPorPk("");

                        $lancamento->setoperacao_pk(3);
                        $lancamento->settipos_operacao_pk(1020);
                        $lancamento->setempresas_pk($conta_pk);
                        $lancamento->setcontas_bancarias_pk($conta_bancaria_pk[0]['pk']);
                        $lancamento->setds_lancamento("Compras");
                        $lancamento->settipo_grupo_pk(3);
                        $lancamento->setgrupo_leancamento_pk($fornecedor_pk);
                        $lancamento->settipo_grupo_centro_custo_pk($centro_custo_pk);
                        $lancamento->setgrupo_lancamento_centro_custo_pk($grupo_lancamento_centro_custo_pk);
                        $lancamento->setvl_lancamento($vl_notafiscal/$qtde_parcelas);
                        $lancamento->setmetodos_pagamento_pk($metodos_pagamento_pk);
                        $lancamento->setdt_vencimento(DataDMY($dt_parcelas[0]['dt_pagamento']));

                        $lancamento->setic_status_pagamento(2);
                        $lancamento->setcompras_pk($compras_pk);
                        
                        $lancamentos_pk = $lancamentodao->salvar($lancamento);
                    }
                }
                else{
                    $conta_bancaria_pk = $lancamentodao->listaContaEmpresa($conta_pk);

                    $lancamento = $lancamentodao->carregarPorPk("");

                    $lancamento->setoperacao_pk(3);
                    $lancamento->settipos_operacao_pk(1020);
                    $lancamento->setempresas_pk($conta_pk);
                    $lancamento->setcontas_bancarias_pk($conta_bancaria_pk[0]['pk']);
                    $lancamento->setds_lancamento("Compras");
                    $lancamento->settipo_grupo_pk(3);
                    $lancamento->setgrupo_leancamento_pk($fornecedor_pk);
                    $lancamento->settipo_grupo_centro_custo_pk($centro_custo_pk);
                    $lancamento->setgrupo_lancamento_centro_custo_pk($grupo_lancamento_centro_custo_pk);
                    $lancamento->setvl_lancamento($vl_notafiscal);
                    $lancamento->setmetodos_pagamento_pk($metodos_pagamento_pk);
                    $lancamento->setdt_vencimento($dt_pagamento);
                    $lancamento->setic_status_pagamento(2);
                    $lancamento->setcompras_pk($compras_pk);
                    
                    $lancamentos_pk = $lancamentodao->salvar($lancamento);
                        
                }
                
            }
        }
        
        
        //PRODUTOS ITENS 
        if($produtos_itens_pk != "")
            $arrProdutosItens = json_decode ($produtos_itens_pk, true);
        
        
        if(count($arrProdutosItens) > 0){
            for($i = 0; $i < count($arrProdutosItens); $i++){

                $produto_iten = $produto_itendao->carregarPorPk($arrProdutosItens[$i]['pk']);;
                $produto_iten->setvl_item($arrProdutosItens[$i]['vl_item']);
                $produto_iten->setprodutos_pk($arrProdutosItens[$i]['produtos_pk']);
                $produto_iten->setqtde($arrProdutosItens[$i]['qtde']);
                $produto_iten->setic_entrega($arrProdutosItens[$i]['ic_entrega']);
                $produto_iten->setcompras_pk($compras_pk);
                
                $produto_item_pk = $produto_itendao->salvar($produto_iten);
                
                //VERIFICAR SE FAZ CADASTRO EM ENTRADA ESTOQUE
                if($arrProdutosItens[$i]['ic_entrega']==2){
                    $entrada_estoque = $entrada_estoquedao->carregarPorPk("");
                    $entrada_estoque->setds_n_ordem("");
                    $entrada_estoque->setobs_entrada_estoque("");
                    $entrada_estoque->setfornecedor_pk("");
                    $entrada_estoque->setprodutos_pk($arrProdutosItens[$i]['produtos_pk']);
                    $entrada_estoque->setqtde($arrProdutosItens[$i]['qtde']);
                    $entrada_estoque->setvl_unitario($arrProdutosItens[$i]['vl_item']);

                    $entrada_estoque_pk = $entrada_estoquedao->salvar($entrada_estoque);

                    if($arrProdutosItens[$i]['qtde']!=""){
                        for($j = 0; $j < $arrProdutosItens[$i]['qtde']; $j++){

                            $produto_iten = $produto_itendao->carregarPorPk("");
                            $produto_iten->setds_n_serie("");
                            $produto_iten->setvl_item($arrProdutosItens[$i]['vl_item']);
                            $produto_iten->setprodutos_pk($arrProdutosItens[$i]['produtos_pk']);
                            $produto_iten->setentrada_estoque_pk($entrada_estoque_pk);

                            $p_pk_entrada_estoque = $produto_itendao->salvar($produto_iten);

                        }
                    }
                }
            }
        }
        
        if($documentos_pk != "")
            $arrDocs = json_decode ($documentos_pk, true);
        
        if(count($arrDocs) > 0){
            for($i = 0; $i < count($arrDocs); $i++){
                if($arrDocs[$i]['ds_documento']!="" && $arrDocs[$i]['pk']==""){
                    $documento = $documentodao->carregarPorPk("");
                    $documento->setds_documento($arrDocs[$i]['ds_documento']);
                    $documento->setds_nome_original($arrDocs[$i]['ds_nome_original']);
                    $documento->setcompras_pk($compras_pk);

                    $docs_pk = $documentodao->salvar($documento);
                }
                
            }
        }
        
        return $pk;

    }

    public function excluir($compra){
        $this->db->execDelete("compras"," pk = ".$compra->getpk());
    }
    public function excluirProdutoItem($compras_pk){
        $this->db->execDelete("produtos_itens"," compras_pk = ".$compras_pk);
    }
    public function excluirDocs($compras_pk){
        $this->db->execDelete("documentos"," compras_pk = ".$compras_pk);
    }
    public function excluirLancamentos($compras_pk){
        $this->db->execDelete("lancamentos"," compras_pk = ".$compras_pk);
    }

    public function carregarPorPk($pk){

        $compra = new compra();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,fornecedor_pk ";
        $sql.="       ,categoria_pk ";
        $sql.="       ,conta_pk ";
        $sql.="       ,dt_pagamento ";
        $sql.="       ,vl_pagamento ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,qtde_parcelas ";
        $sql.="       ,ds_numero_nota";
        $sql.="       ,ds_link_notafiscal";
        $sql.="       ,dt_notafiscal ";
        $sql.="       ,vl_notafiscal ";
        $sql.="       ,vl_frete ";
        $sql.="       ,dt_entrega ";
        $sql.="       ,ic_entregue ";
        $sql.="       ,obs ";
        $sql.="       ,grupo_lancamento_centro_custo_pk ";
        $sql.="       ,centro_custo_pk ";


        $sql.="  from compras ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $compra->setpk($query[$i]["pk"]);
                $compra->setdt_cadastro($query[$i]["dt_cadastro"]);
                $compra->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $compra->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $compra->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $compra->setfornecedor_pk($query[$i]['fornecedor_pk']);
                $compra->setcategoria_pk($query[$i]['categoria_pk']);
                $compra->setconta_pk($query[$i]['conta_pk']);
                $compra->setdt_pagamento($query[$i]['dt_pagamento']);
                $compra->setvl_pagamento($query[$i]['vl_pagamento']);
                $compra->setmetodos_pagamento_pk($query[$i]['metodos_pagamento_pk']);
                $compra->setqtde_parcelas($query[$i]['qtde_parcelas']);
                $compra->setds_numero_nota($query[$i]['ds_numero_nota']);
                $compra->setds_link_notafiscal($query[$i]['ds_link_notafiscal']);
                $compra->setdt_notafiscal($query[$i]['dt_notafiscal']);
                $compra->setvl_notafiscal($query[$i]['vl_notafiscal']);
                $compra->setvl_frete($query[$i]['vl_frete']);
                $compra->setdt_entrega($query[$i]['dt_entrega']);
                $compra->setic_entregue($query[$i]['ic_entregue']);
                $compra->setobs($query[$i]['obs']);
                $compra->setgrupo_lancamento_centro_custo_pk($query[$i]['grupo_lancamento_centro_custo_pk']);
                $compra->setcentro_custo_pk($query[$i]['centro_custo_pk']);

            }
        }
        return $compra;
    }

    public function salvarProduto($pk, $compras_pk, $produtos_pk, $qtde, $vl_item, $ic_entrega, $ic_status, $token){
        $produto_itendao = new produto_itendao();
        $produto_itendao->setToken($token); 
        
        $entrada_estoquedao = new entrada_estoquedao();
        $entrada_estoquedao->setToken($token); 

        $pk_entrada_estoque = '';
        if($pk!=""){
            $queryAnt = $produto_itendao->listarPorPk($pk);
            $pk_entrada_estoque = $queryAnt[0]['entrada_estoque_pk'];
        }
        

        $produto_iten = $produto_itendao->carregarPorPk($pk);
        $produto_iten->setvl_item($vl_item);
        $produto_iten->setprodutos_pk($produtos_pk);
        $produto_iten->setqtde($qtde);
        $produto_iten->setic_entrega($ic_entrega);
        $produto_iten->setcompras_pk($compras_pk);

        $produto_item_pk = $produto_itendao->salvar($produto_iten);

        //VERIFICAR SE FAZ CADASTRO EM ENTRADA ESTOQUE
        if($ic_entrega==2){
            if($ic_status == 1){
                $entrada_estoque = $entrada_estoquedao->carregarPorPk($pk_entrada_estoque);
                $entrada_estoque->setprodutos_pk($produtos_pk);
                $entrada_estoque->setqtde($qtde);
                $entrada_estoque->setvl_unitario($vl_item);
                $entrada_estoque_pk = $entrada_estoquedao->salvar($entrada_estoque);

                if($qtde!=""){
                    for($i = 0; $i < $qtde; $i++){

                        $produto_iten = $produto_itendao->carregarPorPk($pk);
                        $produto_iten->setvl_item($vl_item);
                        $produto_iten->setprodutos_pk($produtos_pk);
                        $produto_iten->setentrada_estoque_pk($entrada_estoque_pk);

                        $produto_itendao->salvar($produto_iten);

                    }
                }
            }
            
        }

        return $produto_item_pk;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,fornecedor_pk ";
        $sql.="       ,categoria_pk ";
        $sql.="       ,conta_pk ";
        $sql.="       ,date_format(dt_pagamento,'%d/%m/%Y') dt_pagamento";
        $sql.="       ,vl_pagamento ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,qtde_parcelas ";
        $sql.="       ,ds_numero_nota";
        $sql.="       ,ds_link_notafiscal";
        $sql.="       ,date_format(dt_notafiscal,'%d/%m/%Y') dt_notafiscal";
        $sql.="       ,vl_notafiscal ";
        $sql.="       ,vl_frete ";
        $sql.="       ,date_format(dt_entrega,'%d/%m/%Y') dt_entrega";
        $sql.="       ,ic_entregue ";
        $sql.="       ,obs ";
        $sql.="       ,grupo_lancamento_centro_custo_pk ";
        $sql.="       ,centro_custo_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from compras ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_fornecedor_pk($fornecedor_pk,$categorias_pk,$ds_numero_nota,$empresas_pk,$dt_cadastro_ini,$dt_cadastro_fim){

        $sql ="";
        $sql.="select cp.pk, date_format(cp.dt_cadastro,'%d/%m/%Y')dt_cadastro, cp.usuario_cadastro_pk, cp.dt_ult_atualizacao, cp.usuario_ult_atualizacao_pk ";
        $sql.="       ,cp.fornecedor_pk ";
        $sql.="       ,cp.categoria_pk ";
        $sql.="       ,cp.conta_pk ";
        $sql.="       ,date_format(cp.dt_pagamento,'%d/%m/%Y')dt_pagamento";
        $sql.="       ,cp.vl_pagamento ";
        $sql.="       ,cp.metodos_pagamento_pk ";
        $sql.="       ,cp.qtde_parcelas ";
        $sql.="       ,cp.ds_numero_nota,cp.ds_link_notafiscal ";
        $sql.="       ,cp.ds_link_notafiscal ";
         $sql.="       ,date_format(cp.dt_notafiscal,'%d/%m/%Y')dt_notafiscal";
        $sql.="       ,cp.vl_notafiscal ";
        $sql.="       ,cp.vl_frete ";
        $sql.="       ,date_format(cp.dt_entrega,'%d/%m/%Y')dt_entrega";
        $sql.="       ,cp.ic_entregue ";
        $sql.="       ,cp.obs ";
        $sql.="       ,cp.grupo_lancamento_centro_custo_pk ";
        $sql.="       ,cp.centro_custo_pk ";
        $sql.="       ,c.ds_categoria";
        $sql.="       ,f.ds_fornecedor";
        $sql.="       ,ct.ds_conta";

        $sql.="  from compras cp";
        $sql.="       left join categorias_produto c on cp.categoria_pk = c.pk";
        $sql.="       inner join fornecedor f on cp.fornecedor_pk = f.pk";
        $sql.="       inner join contas ct on cp.conta_pk = ct.pk";
        $sql.=" where 1=1 ";
        if($fornecedor_pk!=""){
            $sql.=" and cp.fornecedor_pk = ".$fornecedor_pk;
        }
        if($categorias_pk!=""){
            $sql.=" and cp.categoria_pk= ".$categorias_pk;
        }
        if($ds_numero_nota!=""){
             $sql.=" and cp.ds_numero_nota like '%".$ds_numero_nota."%'";
        }
        if($empresas_pk!=""){
            $sql.=" and cp.conta_pk= ".$empresas_pk;
        }
        if($dt_cadastro_ini!=""){
            $sql.=" and cp.dt_pagamento between '".DataYMD($dt_cadastro_ini)."' and '".DataYMD($dt_cadastro_fim)."'";
        }
        
        $sql.=" order by cp.dt_pagamento asc ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarDataDiff($data_base,$i){
            
        $sql="SELECT DATE_ADD('".DataYMD($data_base)."', INTERVAL ".($i)." MONTH)dt_pagamento";
       
        $query = $this->db->execQuery($sql);
        return $query;
    }
            
    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,fornecedor_pk ";
        $sql.="       ,categoria_pk ";
        $sql.="       ,conta_pk ";
        $sql.="       ,dt_pagamento ";
        $sql.="       ,vl_pagamento ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,qtde_parcelas ";
        $sql.="       ,ds_numero_nota";
        $sql.="       ,ds_link_notafiscal ";
        $sql.="       ,dt_notafiscal ";
        $sql.="       ,vl_notafiscal ";
        $sql.="       ,vl_frete ";
        $sql.="       ,dt_entrega ";
        $sql.="       ,ic_entregue ";
        $sql.="       ,obs ";
        $sql.="       ,grupo_lancamento_centro_custo_pk ";
        $sql.="       ,centro_custo_pk ";

        $sql.="  from compras ";
        $sql.=" where 1=1 ";
        $sql.=" order by fornecedor_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
