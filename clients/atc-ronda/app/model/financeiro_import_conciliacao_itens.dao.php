<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/financeiro_import_conciliacao_itens.class.php';


class financeiro_import_conciliacao_itensdao{

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

    public function salvar($financeiro_import_conciliacao_itens){
        
        $fields = array();
        $fields['ic_tipo_transacao'] = $financeiro_import_conciliacao_itens->getic_tipo_transacao();
        $fields['dt_transacao'] = DataYMD($financeiro_import_conciliacao_itens->getdt_transacao());
        $fields['vl_transacao'] = $financeiro_import_conciliacao_itens->getvl_transacao();
        $fields['cod_verificacao_transacao'] = $financeiro_import_conciliacao_itens->getcod_verificacao_transacao();
        $fields['ds_estabelecimento'] = $financeiro_import_conciliacao_itens->getds_estabelecimento();
        $fields['financeiro_conciliacao_banco_pk'] = $financeiro_import_conciliacao_itens->getfinanceiro_conciliacao_banco_pk();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($financeiro_import_conciliacao_itens->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        
            $pk = $this->db->execInsert("financeiro_conciliacao_banco_itens", $fields);           
           
            $financeiro_import_conciliacao_itens->setpk($pk);
        }
        return $financeiro_import_conciliacao_itens->getpk();

    }

    

    public function excluir($financeiro_import_conciliacao_itens){
        $this->db->execDelete("financeiro_import_conciliacao_itens"," pk = ".$financeiro_import_conciliacao_itens->getpk());
    }

    public function carregarPorPk($pk){

        $financeiro_import_conciliacao_itens = new financeiro_import_conciliacao_itens();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ic_tipo_transacao ";
        $sql.="       ,dt_transacao ";
        $sql.="       ,vl_transacao ";
        $sql.="       ,cod_verificacao_transacao ";
        $sql.="       ,ds_estabelecimento ";
        $sql.="       ,financeiro_conciliacao_banco_pk ";
        $sql.="  from financeiro_import_conciliacao_itens ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $financeiro_import_conciliacao_itens->setpk($query[$i]["pk"]);
                $financeiro_import_conciliacao_itens->setdt_cadastro($query[$i]["dt_cadastro"]);
                $financeiro_import_conciliacao_itens->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $financeiro_import_conciliacao_itens->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $financeiro_import_conciliacao_itens->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $financeiro_import_conciliacao_itens->setic_tipo_transacao($query[$i]['ic_tipo_transacao']);
                $financeiro_import_conciliacao_itens->setdt_transacao($query[$i]['dt_transacao']);
                $financeiro_import_conciliacao_itens->setvl_transacao($query[$i]['vl_transacao']);
                $financeiro_import_conciliacao_itens->setcod_verificacao_transacao($query[$i]['cod_verificacao_transacao']);
                $financeiro_import_conciliacao_itens->setds_estabelecimento($query[$i]['ds_estabelecimento']);
                $financeiro_import_conciliacao_itens->setfinanceiro_conciliacao_banco_pk($query[$i]['financeiro_conciliacao_banco_pk']);

            }
        }
        return $financeiro_import_conciliacao_itens;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,dt_vencimento ";
        $sql.="       ,ds_lancamento ";
        $sql.="       ,vl_lancamento ";
        $sql.="       ,operacao_pk ";
        $sql.="       ,tipo_grupo_pk ";
        $sql.="       ,grupo_leancamento_pk ";
        $sql.="       ,ic_status_pagamento ";
        $sql.="       ,obs_lancamento ";
        $sql.="       ,dt_competencia ";
        $sql.="       ,n_documento ";
        $sql.="       ,tipos_operacao_pk ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,usuario_ult_atualizacao_pk ";
        $sql.="       ,contas_bancarias_pk ";
        $sql.="       ,empresas_pk ";
        $sql.="       ,tipo_grupo_centro_custo_pk ";
        $sql.="       ,grupo_lancamento_centro_custo_pk ";
        $sql.="       ,ds_ocorrencia ";
        $sql.="       ,dt_pagamento ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,compras_pk ";
        $sql.="       ,dt_faturamento ";
        $sql.="       ,categoria_operacao_pk ";
        $sql.="       ,leads_clientes_pk ";
        $sql.="       ,leads_posto_trabalho_pk ";
        $sql.="       ,colaborador_posto_trabalho_pk ";
        $sql.="       ,colaborador_contratos_pk ";
        $sql.="       ,fornecedor_posto_trabalho_pk ";
        $sql.="       ,fornecedor_contratos_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,fornecedor_pk ";
        $sql.="       ,parcela_pk ";
        $sql.="       ,teto_gastros_pk ";
        $sql.="       ,teto_gastos_itens_pk ";
        $sql.="       ,ic_status_processamento ";
        $sql.="       ,financeiro_import_lancamentos_pk ";
        $sql.="       ,lancamentos_pk ";

        $sql.="  from financeiro_import_conciliacao_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarDataTable($financeiro_conciliacao_banco_pk){
        $sql ="";
        $sql.="SELECT distinct(f.pk)pk,";
        $sql.="       DATE_FORMAT(f.dt_transacao,'%d/%m/%Y')dt_transacao,";
        $sql.="       CASE f.ic_tipo_transacao WHEN 1 THEN 'Crédito' when 2 then 'Débito' end ds_transacao,";
        $sql.="       f.vl_transacao,";
        $sql.="       f.ic_tipo_transacao,";
        $sql.="       f.cod_verificacao_transacao,";
        $sql.="       f.ds_estabelecimento, ";
        $sql.="       fl.lancamentos_pk, ";
        $sql.="       fl.ic_status ic_status_fl, ";
        $sql.="       fl.obs obs_fl ,";
        $sql.="       fl.pk financeiro_conciliacao_lancamentos_pk";
        $sql.="  from financeiro_conciliacao_banco_itens f";
        $sql.="  left join financeiro_conciliacao_lancamentos fl on fl.financeiro_conciliacao_banco_itens_pk = f.pk";
        $sql.=" where 1=1 ";
        if($financeiro_conciliacao_banco_pk != ""){
            $sql.=" and f.financeiro_conciliacao_banco_pk =".$financeiro_conciliacao_banco_pk;
        }
        $sql.=" order by f.dt_transacao asc ";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_vencimento ";
        $sql.="       ,ds_lancamento ";
        $sql.="       ,vl_lancamento ";
        $sql.="       ,operacao_pk ";
        $sql.="       ,tipo_grupo_pk ";
        $sql.="       ,grupo_leancamento_pk ";
        $sql.="       ,ic_status_pagamento ";
        $sql.="       ,obs_lancamento ";
        $sql.="       ,dt_competencia ";
        $sql.="       ,n_documento ";
        $sql.="       ,tipos_operacao_pk ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,usuario_ult_atualizacao_pk ";
        $sql.="       ,contas_bancarias_pk ";
        $sql.="       ,empresas_pk ";
        $sql.="       ,tipo_grupo_centro_custo_pk ";
        $sql.="       ,grupo_lancamento_centro_custo_pk ";
        $sql.="       ,ds_ocorrencia ";
        $sql.="       ,dt_pagamento ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,compras_pk ";
        $sql.="       ,dt_faturamento ";
        $sql.="       ,categoria_operacao_pk ";
        $sql.="       ,leads_clientes_pk ";
        $sql.="       ,leads_posto_trabalho_pk ";
        $sql.="       ,colaborador_posto_trabalho_pk ";
        $sql.="       ,colaborador_contratos_pk ";
        $sql.="       ,fornecedor_posto_trabalho_pk ";
        $sql.="       ,fornecedor_contratos_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,fornecedor_pk ";
        $sql.="       ,parcela_pk ";
        $sql.="       ,teto_gastros_pk ";
        $sql.="       ,teto_gastos_itens_pk ";
        $sql.="       ,ic_status_processamento ";
        $sql.="       ,financeiro_import_lancamentos_pk ";
        $sql.="       ,lancamentos_pk ";

        $sql.="  from financeiro_import_conciliacao_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_vencimento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
