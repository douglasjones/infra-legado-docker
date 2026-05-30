<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/compras_solicitacao_orcamentos.class.php';
require_once '../model/compra.dao.php';
require_once '../model/compras_solicitacao.dao.php';


class compras_solicitacao_orcamentosdao{

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
    
    public function salvar($compras_solicitacao_orcamentos, $token){
        $compradao = new compradao();
        $compradao->setToken($token);

        $compras_solicitacaodao = new compras_solicitacaodao();
        $compras_solicitacaodao->setToken($token);

        $fields = array();
        $fields['fornecedor_pk'] = $compras_solicitacao_orcamentos->getfornecedor_pk();
        $fields['dt_pevisao_entrega'] = DataYMD($compras_solicitacao_orcamentos->getdt_pevisao_entrega());
        $fields['vl_frete'] = moeda2float($compras_solicitacao_orcamentos->getvl_frete());
        $fields['vl_total'] = moeda2float($compras_solicitacao_orcamentos->getvl_total());
        $fields['obs_orcamento'] = $compras_solicitacao_orcamentos->getobs_orcamento();
        $fields['ic_status'] = $compras_solicitacao_orcamentos->getic_status();
        $fields['compra_solicitacao_pk'] = $compras_solicitacao_orcamentos->getcompra_solicitacao_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($compras_solicitacao_orcamentos->getpk()  == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("compras_solicitacao_orcamentos", $fields);
        }
        else{
    
            $this->db->execUpdate("compras_solicitacao_orcamentos", $fields, " pk = ".$compras_solicitacao_orcamentos->getpk());

            $pk = $compras_solicitacao_orcamentos->getpk();
        }

        $compra_solicitacao_pk = $compras_solicitacao_orcamentos->getcompra_solicitacao_pk();
        $ic_status = $compras_solicitacao_orcamentos->getic_status();
        $vl_total = moeda2float($compras_solicitacao_orcamentos->getvl_total());
        $vl_frete = moeda2float($compras_solicitacao_orcamentos->getvl_frete());
        $dt_previsao_entrega = $compras_solicitacao_orcamentos->getdt_pevisao_entrega();
        $fornecedor_pk = $compras_solicitacao_orcamentos->getfornecedor_pk();

        $sql = '';
        $sql .= 'select  grupo_lancamento_centrocusto_pk'; 
        $sql .= '       ,tipo_grupo_centro_custo_pk '; 
        $sql .= '       ,empresas_pk '; 
        $sql .= '  from compras_solicitacao';
        $sql .= '  where pk ='. $compra_solicitacao_pk;
        $query = $this->db->execQuery($sql);  

        if($ic_status == 2){
            $compras_solicitacao = $compras_solicitacaodao->carregarPorPk($compra_solicitacao_pk);
            $compras_solicitacao->setusuario_aprovacao_pk($this->arrToken['usuarios_pk']);
            $compras_solicitacao->setdt_aprovacao("sysdate()");
            $compras_solicitacao_pk = $compras_solicitacaodao->salvar($compras_solicitacao);

            $compra = $compradao->carregarPorPk('');
            $compra->setfornecedor_pk($fornecedor_pk);
            $compra->setconta_pk($query[0]['empresas_pk']);
            $compra->setvl_pagamento($vl_total + $vl_frete);
            $compra->setvl_notafiscal($vl_total);
           
            $compra->setvl_frete($vl_frete);
            $compra->setdt_entrega($dt_previsao_entrega);
            $compra->setgrupo_lancamento_centro_custo_pk($query[0]['grupo_lancamento_centrocusto_pk']);
            $compra->setcentro_custo_pk($query[0]['tipo_grupo_centro_custo_pk']);
            $compra->setcompra_solicitacao_pk($compra_solicitacao_pk);
            $compra->setic_status(2);
            $compras_pk = $compradao->salvar($compra, '', '', $token);
        }

        if($ic_status==3){
            $this->orcamentosReprovados($compra_solicitacao_pk);       
        }
        
        return $pk;

    }
    
    public function orcamentosReprovados($compra_solicitacao_pk){

        $fields = array();
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["ic_status"] = 3;
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        return $this->db->execUpdate("compras_solicitacao", $fields, " pk = ".$compra_solicitacao_pk);

    }
    
    public function vinculaSolicitacaoOrcamento($pk,$compras_solicitacao_pk){
  
        $fields = array(); 
        $fields['compra_solicitacao_pk'] = $compras_solicitacao_pk;


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        return $this->db->execUpdate("compras_solicitacao_orcamentos", $fields, " pk = ".$pk);
   
    }

    public function excluir($compras_solicitacao_orcamentos){
        $this->db->execDelete("compras_solicitacao_orcamentos"," pk = ".$compras_solicitacao_orcamentos->getpk());
    }
    
    
   public function listarDataTable($compra_solicitacao_pk){

        $sql ="";
        $sql.=" SELECT cso.pk,";
        $sql.=" f.ds_fornecedor,";
        $sql.=" cso.fornecedor_pk,";
        $sql.=" date_format(cso.dt_pevisao_entrega, '%d/%m/%Y') dt_pevisao_entrega,";
        $sql.=" cso.vl_frete,";
        $sql.=" cso.vl_total,";
        $sql.=" cso.ic_status,";
        $sql.=" CASE ";
        $sql.="    WHEN cso.ic_status = 1 THEN 'Em analise'";
        $sql.="    WHEN cso.ic_status = 2 THEN 'Aprovado' ";
        $sql.="    WHEN cso.ic_status = 3 THEN 'Reprovado' ";
        $sql.=" END ds_status, ";
        $sql.=" cso.compra_solicitacao_pk ";
        $sql.=" FROM compras_solicitacao_orcamentos cso ";
        $sql.="      LEFT JOIN fornecedor f ON cso.fornecedor_pk = f.pk ";
        $sql.=" WHERE cso.compra_solicitacao_pk =".$compra_solicitacao_pk;
        $sql.=" order by cso.pk desc ";

        $query = $this->db->execQuery($sql);        
        return $query;

    }

    public function carregarPorPk($pk){

        $compras_solicitacao_orcamentos = new compras_solicitacao_orcamentos();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,fornecedor_pk ";
        $sql.="       ,dt_pevisao_entrega ";
        $sql.="       ,vl_frete ";
        $sql.="       ,vl_total ";
        $sql.="       ,obs_orcamento ";
        $sql.="       ,ic_status ";
        $sql.="       ,compra_solicitacao_pk ";


        $sql.="  from compras_solicitacao_orcamentos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $compras_solicitacao_orcamentos->setpk($query[$i]["pk"]);
                $compras_solicitacao_orcamentos->setdt_cadastro($query[$i]["dt_cadastro"]);
                $compras_solicitacao_orcamentos->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $compras_solicitacao_orcamentos->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $compras_solicitacao_orcamentos->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $compras_solicitacao_orcamentos->setfornecedor_pk($query[$i]['fornecedor_pk']);
                $compras_solicitacao_orcamentos->setdt_pevisao_entrega($query[$i]['dt_pevisao_entrega']);
                $compras_solicitacao_orcamentos->setvl_frete($query[$i]['vl_frete']);
                $compras_solicitacao_orcamentos->setvl_total($query[$i]['vl_total']);
                $compras_solicitacao_orcamentos->setobs_orcamento($query[$i]['obs_orcamento']);
                $compras_solicitacao_orcamentos->setic_status($query[$i]['ic_status']);
                $compras_solicitacao_orcamentos->setcompra_solicitacao_pk($query[$i]['compra_solicitacao_pk']);

            }
        }
        return $compras_solicitacao_orcamentos;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,fornecedor_pk ";
        $sql.="       ,date_format(dt_pevisao_entrega,'%d/%m/%Y')dt_pevisao_entrega ";
        $sql.="       ,vl_frete ";
        $sql.="       ,vl_total ";
        $sql.="       ,obs_orcamento ";
        $sql.="       ,ic_status ";
        $sql.="       ,compra_solicitacao_pk ";

        $sql.="  from compras_solicitacao_orcamentos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_fornecedor_pk($compra_solicitacao_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,fornecedor_pk ";
        $sql.="       ,dt_pevisao_entrega ";
        $sql.="       ,vl_frete ";
        $sql.="       ,vl_total ";
        $sql.="       ,obs_orcamento ";
        $sql.="       ,ic_status ";
        $sql.="       ,compra_solicitacao_pk ";

        $sql.="  from compras_solicitacao_orcamentos ";
        $sql.=" where 1=1 ";
        if($fornecedor_pk != ""){
            $sql.=" and ds_compras_solicitacao_orcamentos like '%".$fornecedor_pk."%' ";
        }
        $sql.=" order by fornecedor_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,fornecedor_pk ";
        $sql.="       ,dt_pevisao_entrega ";
        $sql.="       ,vl_frete ";
        $sql.="       ,vl_total ";
        $sql.="       ,obs_orcamento ";
        $sql.="       ,ic_status ";
        $sql.="       ,compra_solicitacao_pk ";

        $sql.="  from compras_solicitacao_orcamentos ";
        $sql.=" where 1=1 ";
        $sql.=" order by fornecedor_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarDadosImpressao($pk, $compra_solicitacao_pk){

        $sql ="";
        $sql.="select cs.pk, cs.dt_cadastro, cs.usuario_cadastro_pk, cs.dt_ult_atualizacao, cs.usuario_ult_atualizacao_pk, ";
        $sql.="       cs.ds_compra_solicitacao,";
        $sql.="       date_format(cs.dt_solicitacao,'%d/%m/%Y') dt_solicitacao,";
        $sql.="       cs.empresas_pk,";
        $sql.="       c.ds_conta ds_empresa,";
        $sql.="       cs.solicitante_pk,";
        $sql.="       u.ds_usuario ds_solicitante,";
        $sql.="       cs.grupo_lancamento_centrocusto_pk,";
        $sql.="       cs.tipo_grupo_centro_custo_pk,";
        $sql.="       cso.pk compras_solicitacao_orcamentos_pk,";
        $sql.="       cso.vl_frete,";
        $sql.="       cso.vl_total,";
        $sql.="       cso.ic_status,";
        $sql.="       CASE WHEN cso.ic_status = 1 THEN 'Em analise' ";
        $sql.="            WHEN cso.ic_status = 2 THEN 'Aprovado' ";
        $sql.="            END ds_status,";
        $sql.="       date_format(cso.dt_pevisao_entrega,'%d/%m/%Y') dt_pevisao_entrega,";
        $sql.="       cso.fornecedor_pk,";
        $sql.="       f.ds_fornecedor,";
        $sql.="       csoi.vl_unitario,";
        $sql.="       csoi.qtde_produto,";
        $sql.="       csoi.produtos_pk,";
        $sql.="       csoi.ds_produto,";
        $sql.="       csoi.categorias_produto_pk,";
        $sql.="       cp.ds_categoria ds_categoria_produto";
        $sql.="  FROM compras_solicitacao cs";
        $sql.="  LEFT JOIN compras_solicitacao_orcamentos cso ON cso.compra_solicitacao_pk = cs.pk";
        $sql.="  LEFT JOIN compras_solicitacao_orcamento_itens csoi ON csoi.compras_solicitacao_orcamentos_pk = cso.pk";
        $sql.="  LEFT JOIN fornecedor f ON cso.fornecedor_pk = f.pk";
        $sql.="  LEFT JOIN contas c ON cs.empresas_pk = c.pk";
        $sql.="  LEFT JOIN usuarios u ON cs.solicitante_pk = u.pk";
        $sql.="  LEFT JOIN categorias_produto cp ON csoi.categorias_produto_pk = cp.pk";
        $sql.="    where 1=1";
        if($pk != ""){
            $sql.="       and cso.pk = $pk ";
        }
        if($compra_solicitacao_pk != ""){
            $sql.="       and cs.pk = $compra_solicitacao_pk ";
        }
        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
