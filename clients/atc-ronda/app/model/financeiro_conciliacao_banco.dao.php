<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/financeiro_conciliacao_banco.class.php';


class financeiro_conciliacao_bancodao{

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

    public function salvar($financeiro_conciliacao_banco){
        
        $fields = array();
        $fields['ds_link_arquivo'] = $financeiro_conciliacao_banco->getds_link_arquivo();
        $fields['vl_saldo_conta'] = $financeiro_conciliacao_banco->getvl_saldo_conta();
        $fields['dt_ini_periodo_saldo'] = DataYMD($financeiro_conciliacao_banco->getdt_ini_periodo_saldo());
        $fields['dt_fim_periodo_saldo'] = DataYMD($financeiro_conciliacao_banco->getdt_fim_periodo_saldo());
        $fields['ds_obs'] = $financeiro_conciliacao_banco->getds_obs();
        $fields['ic_status'] = $financeiro_conciliacao_banco->getic_status();
        $fields['contas_bancarias_pk'] = $financeiro_conciliacao_banco->getcontas_bancarias_pk();
        $fields['empresas_pk'] = $financeiro_conciliacao_banco->getempresas_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($financeiro_conciliacao_banco->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("financeiro_conciliacao_banco", $fields);
            $financeiro_conciliacao_banco->setpk($pk);
        }
        else{
            $this->db->execUpdate("financeiro_conciliacao_banco", $fields, " pk = ".$financeiro_conciliacao_banco->getpk());
        }
        return $financeiro_conciliacao_banco->getpk();;

    }

    public function excluir($financeiro_conciliacao_banco){
        $this->db->execDelete("financeiro_conciliacao_banco_itens"," financeiro_conciliacao_banco_pk = ".$financeiro_conciliacao_banco->getpk());
        $this->db->execDelete("financeiro_conciliacao_banco"," pk = ".$financeiro_conciliacao_banco->getpk());
    }

    public function carregarPorPk($pk){

        $financeiro_conciliacao_banco = new financeiro_conciliacao_banco();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_link_arquivo ";
        $sql.="       ,vl_saldo_conta ";
        $sql.="       ,dt_ini_periodo_saldo ";
        $sql.="       ,dt_fim_periodo_saldo ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ic_status ";
        $sql.="       ,contas_bancarias_pk ";
        $sql.="       ,empresas_pk ";


        $sql.="  from financeiro_conciliacao_banco ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $financeiro_conciliacao_banco->setpk($query[$i]["pk"]);
                $financeiro_conciliacao_banco->setdt_cadastro($query[$i]["dt_cadastro"]);
                $financeiro_conciliacao_banco->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $financeiro_conciliacao_banco->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $financeiro_conciliacao_banco->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $financeiro_conciliacao_banco->setds_link_arquivo($query[$i]['ds_link_arquivo']);
                $financeiro_conciliacao_banco->setvl_saldo_conta($query[$i]['vl_saldo_conta']);
                $financeiro_conciliacao_banco->setdt_ini_periodo_saldo($query[$i]['dt_ini_periodo_saldo']);
                $financeiro_conciliacao_banco->setdt_fim_periodo_saldo($query[$i]['dt_fim_periodo_saldo']);
                $financeiro_conciliacao_banco->setds_obs($query[$i]['ds_obs']);
                $financeiro_conciliacao_banco->setic_status($query[$i]['ic_status']);
                $financeiro_conciliacao_banco->setcontas_bancarias_pk($query[$i]['contas_bancarias_pk']);
                $financeiro_conciliacao_banco->setempresas_pk($query[$i]['empresas_pk']);

            }
        }
        return $financeiro_conciliacao_banco;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.=" SELECT  f.pk,";
        $sql.="         f.vl_saldo_conta,";
        $sql.="         f.ds_obs,";
        $sql.="         f.empresas_pk,";
        $sql.="         f.contas_bancarias_pk,";
        $sql.="         DATE_FORMAT(f.dt_ini_periodo_saldo, '%d/%m/%Y')dt_ini_periodo_saldo,";
        $sql.="         DATE_FORMAT(f.dt_fim_periodo_saldo, '%d/%m/%Y')dt_fim_periodo_saldo";
        $sql.=" FROM financeiro_conciliacao_banco f ";
        $sql.=" where f.pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarDataTable(){

        $sql ="";
        $sql.=" SELECT  f.pk,";
        $sql.="         c.ds_conta,";
        $sql.="         b.ds_banco,";
        $sql.="         cb.ds_agencia,";
        $sql.="         cb.ds_conta ds_conta_bancaria,";
        $sql.="         DATE_FORMAT(f.dt_ini_periodo_saldo, '%d/%m/%Y')dt_ini_periodo_saldo,";
        $sql.="         DATE_FORMAT(f.dt_fim_periodo_saldo, '%d/%m/%Y')dt_fim_periodo_saldo";
        $sql.=" FROM financeiro_conciliacao_banco f ";
        $sql.=" INNER JOIN contas_bancarias cb on f.contas_bancarias_pk = cb.pk";
        $sql.=" INNER JOIN contas c on f.empresas_pk = c.pk";
        $sql.=" INNER JOIN bancos b on cb.bancos_pk = b.pk";
        $sql.=" WHERE 1=1";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_link_arquivo ";
        $sql.="       ,vl_saldo_conta ";
        $sql.="       ,dt_ini_periodo_saldo ";
        $sql.="       ,dt_fim_periodo_saldo ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ic_status ";
        $sql.="       ,contas_bancarias_pk ";

        $sql.="  from financeiro_conciliacao_banco ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_link_arquivo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
