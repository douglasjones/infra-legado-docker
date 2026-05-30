<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/faturamento_item.class.php';


class faturamento_itemdao{

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

    public function salvar($faturamento_item){

        $fields = array();
        $fields['vl_total_lancamento'] = $faturamento_item->getvl_total_lancamento();
        $fields['faturamento_pk'] = $faturamento_item->getfaturamento_pk();
        $fields['contas_pk'] = $faturamento_item->getcontas_pk();
        $fields['leads_pk'] = $faturamento_item->getleads_pk();
        $fields['contratos_pk'] = $faturamento_item->getcontratos_pk();
        $fields['dt_lancamento_financeiro'] = $faturamento_item->getdt_lancamento_financeiro();
        $fields['ic_item_validado'] = $faturamento_item->getic_item_validado();
        $fields['dt_item_valiado'] = $faturamento_item->getdt_item_valiado();
        $fields['lancamentos_pk'] = $faturamento_item->getlancamentos_pk();
        $fields['ic_status'] = $faturamento_item->getic_status();
        $fields['ic_processamento_lancamento_item_status'] = $faturamento_item->getic_processamento_lancamento_item_status();
        $fields['dt_processamento_lancamento_lancamento'] = $faturamento_item->getdt_processamento_lancamento_lancamento();
        $fields['obs_faturamento_contrato'] = $faturamento_item->getobs_faturamento_contrato();
        $fields['obs_lancamento'] = $faturamento_item->getobs_lancamento();
        $fields['obs_corpo_nota'] = $faturamento_item->getobs_corpo_nota();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($faturamento_item->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("faturamento_itens", $fields);
            $faturamento_item->setpk($pk);
        }
        else{
            $this->db->execUpdate("faturamento_itens", $fields, " pk = ".$faturamento_item->getpk());
        }
        return $faturamento_item->getpk();;

    }

    public function excluir($faturamento_item){
        $this->db->execDelete("faturamento_itens"," pk = ".$faturamento_item->getpk());
    }

    public function carregarPorPk($pk){

        $faturamento_item = new faturamento_item();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,vl_total_lancamento ";
        $sql.="       ,faturamento_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,dt_lancamento_financeiro ";
        $sql.="       ,ic_item_validado ";
        $sql.="       ,dt_item_valiado ";
        $sql.="       ,lancamentos_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,ic_processamento_lancamento_item_status ";
        $sql.="       ,dt_processamento_lancamento_lancamento ";
        $sql.="       ,obs_faturamento_contrato ";
        $sql.="       ,obs_lancamento ";
        $sql.="       ,obs_corpo_nota ";


        $sql.="  from faturamento_itens ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $faturamento_item->setpk($query[$i]["pk"]);
                $faturamento_item->setdt_cadastro($query[$i]["dt_cadastro"]);
                $faturamento_item->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $faturamento_item->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $faturamento_item->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $faturamento_item->setvl_total_lancamento($query[$i]['vl_total_lancamento']);
                $faturamento_item->setfaturamento_pk($query[$i]['faturamento_pk']);
                $faturamento_item->setcontas_pk($query[$i]['contas_pk']);
                $faturamento_item->setleads_pk($query[$i]['leads_pk']);
                $faturamento_item->setcontratos_pk($query[$i]['contratos_pk']);
                $faturamento_item->setdt_lancamento_financeiro($query[$i]['dt_lancamento_financeiro']);
                $faturamento_item->setic_item_validado($query[$i]['ic_item_validado']);
                $faturamento_item->setdt_item_valiado($query[$i]['dt_item_valiado']);
                $faturamento_item->setlancamentos_pk($query[$i]['lancamentos_pk']);
                $faturamento_item->setic_status($query[$i]['ic_status']);
                $faturamento_item->setic_processamento_lancamento_item_status($query[$i]['ic_processamento_lancamento_item_status']);
                $faturamento_item->setdt_processamento_lancamento_lancamento($query[$i]['dt_processamento_lancamento_lancamento']);
                $faturamento_item->setobs_faturamento_contrato($query[$i]['obs_faturamento_contrato']);
                $faturamento_item->setobs_lancamento($query[$i]['obs_lancamento']);
                $faturamento_item->setobs_corpo_nota($query[$i]['obs_corpo_nota']);

            }
        }
        return $faturamento_item;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,vl_total_lancamento ";
        $sql.="       ,faturamento_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,dt_lancamento_financeiro ";
        $sql.="       ,ic_item_validado ";
        $sql.="       ,dt_item_valiado ";
        $sql.="       ,lancamentos_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,ic_processamento_lancamento_item_status ";
        $sql.="       ,dt_processamento_lancamento_lancamento ";
        $sql.="       ,obs_faturamento_contrato ";
        $sql.="       ,obs_lancamento ";
        $sql.="       ,obs_corpo_nota ";

        $sql.="  from faturamento_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_vl_total_lancamento($vl_total_lancamento){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,vl_total_lancamento ";
        $sql.="       ,faturamento_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,dt_lancamento_financeiro ";
        $sql.="       ,ic_item_validado ";
        $sql.="       ,dt_item_valiado ";
        $sql.="       ,lancamentos_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,ic_processamento_lancamento_item_status ";
        $sql.="       ,dt_processamento_lancamento_lancamento ";
        $sql.="       ,obs_faturamento_contrato ";
        $sql.="       ,obs_lancamento ";
        $sql.="       ,obs_corpo_nota ";

        $sql.="  from faturamento_itens ";
        $sql.=" where 1=1 ";
        if($vl_total_lancamento != ""){
            $sql.=" and ds_faturamento_item like '%".$vl_total_lancamento."%' ";
        }
        $sql.=" order by vl_total_lancamento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,vl_total_lancamento ";
        $sql.="       ,faturamento_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,dt_lancamento_financeiro ";
        $sql.="       ,ic_item_validado ";
        $sql.="       ,dt_item_valiado ";
        $sql.="       ,lancamentos_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,ic_processamento_lancamento_item_status ";
        $sql.="       ,dt_processamento_lancamento_lancamento ";
        $sql.="       ,obs_faturamento_contrato ";
        $sql.="       ,obs_lancamento ";
        $sql.="       ,obs_corpo_nota ";

        $sql.="  from faturamento_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by vl_total_lancamento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
                    