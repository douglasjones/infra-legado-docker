<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/analise_financeira_processos.class.php';


class analise_financeira_processosdao{

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

    public function salvar($analise_financeira_processos, $gestor_aprovacao_pk){

        $sql = "";
        $sql.= "select grupos_pk from usuarios where pk = ".$this->arrToken['usuarios_pk'];
        $query = $this->db->execQuery($sql);

        $fieldsAnaliseFinanceira = array();
        $fields = array();

        if($analise_financeira_processos->getic_aprovacao() == 2){
            $fields["ic_aprovacao"] = 1;
        }else if($analise_financeira_processos->getic_aprovacao() == 3){
            $fields["ic_aprovacao"] = 1;
        }else if($analise_financeira_processos->getic_correcao() == 4){
            $fields["ic_correcao"] = 1;
        }else if($analise_financeira_processos->getic_recusa() == 5){
            $fields["ic_recusa"] = 1;
        }else if($analise_financeira_processos->getic_correcao() == 6){
            $fields["ic_correcao"] = 1;
        }
        
        $fields['obs_recusa'] = $analise_financeira_processos->getobs_recusa();
        $fields['obs_correcao'] = $analise_financeira_processos->getobs_correcao();
        $fields['obs_aprovacao'] = $analise_financeira_processos->getobs_aprovacao();
        $fields['dt_cancelamento'] = $analise_financeira_processos->getdt_cancelamento();
        $fields['obs_cancelamento'] = $analise_financeira_processos->getobs_cancelamento();
        $fields['tipo_nivel_usuario'] = $query[0]["grupos_pk"];
        $fields['analise_financeira_pk'] = $analise_financeira_processos->getanalise_financeira_pk();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($analise_financeira_processos->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("analise_financeira_processos", $fields);
            $analise_financeira_processos->setpk($pk);

            if($analise_financeira_processos->getic_aprovacao() == 2){
                $fieldsAnaliseFinanceira["ic_status"] = $analise_financeira_processos->getic_aprovacao();
            }else if($analise_financeira_processos->getic_aprovacao() == 3){
                $fieldsAnaliseFinanceira["ic_status"] = $analise_financeira_processos->getic_aprovacao();
            }else if($analise_financeira_processos->getic_correcao() == 4){
                $fieldsAnaliseFinanceira["ic_status"] = $analise_financeira_processos->getic_correcao();
            }else if($analise_financeira_processos->getic_recusa() == 5){
                $fieldsAnaliseFinanceira["ic_status"] = $analise_financeira_processos->getic_recusa();
            }else if($analise_financeira_processos->getic_correcao() == 6){
                $fieldsAnaliseFinanceira["ic_status"] = $analise_financeira_processos->getic_correcao();
            }

            $fieldsAnaliseFinanceira["gestor_aprovacao_pk"] = $gestor_aprovacao_pk;
            
            $this->db->execUpdate("analise_financeira", $fieldsAnaliseFinanceira, " pk = ".$analise_financeira_processos->getanalise_financeira_pk());
        }
        else{
            $this->db->execUpdate("analise_financeira_processos", $fields, " pk = ".$analise_financeira_processos->getpk());
        }
        return $analise_financeira_processos->getpk();

    }

    public function excluir($analise_financeira_processos){
        $this->db->execDelete("analise_financeira_processos"," pk = ".$analise_financeira_processos->getpk());
    }

    public function carregarPorPk($pk){

        $analise_financeira_processos = new analise_financeira_processos();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,tipo_nivel_usuario ";
        $sql.="       ,ic_recusa ";
        $sql.="       ,obs_recusa ";
        $sql.="       ,ic_correcao ";
        $sql.="       ,obs_correcao ";
        $sql.="       ,ic_aprovacao ";
        $sql.="       ,obs_aprovacao ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,obs_cancelamento ";
        $sql.="       ,analise_financeira_pk ";


        $sql.="  from analise_financeira_processos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $analise_financeira_processos->setpk($query[$i]["pk"]);
                $analise_financeira_processos->setdt_cadastro($query[$i]["dt_cadastro"]);
                $analise_financeira_processos->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $analise_financeira_processos->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $analise_financeira_processos->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $analise_financeira_processos->settipo_nivel_usuario($query[$i]['tipo_nivel_usuario']);
                $analise_financeira_processos->setic_recusa($query[$i]['ic_recusa']);
                $analise_financeira_processos->setobs_recusa($query[$i]['obs_recusa']);
                $analise_financeira_processos->setic_correcao($query[$i]['ic_correcao']);
                $analise_financeira_processos->setobs_correcao($query[$i]['obs_correcao']);
                $analise_financeira_processos->setic_aprovacao($query[$i]['ic_aprovacao']);
                $analise_financeira_processos->setobs_aprovacao($query[$i]['obs_aprovacao']);
                $analise_financeira_processos->setdt_cancelamento($query[$i]['dt_cancelamento']);
                $analise_financeira_processos->setobs_cancelamento($query[$i]['obs_cancelamento']);
                $analise_financeira_processos->setanalise_financeira_pk($query[$i]['analise_financeira_pk']);

            }
        }
        return $analise_financeira_processos;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_nivel_usuario ";
        $sql.="       ,ic_recusa ";
        $sql.="       ,obs_recusa ";
        $sql.="       ,ic_correcao ";
        $sql.="       ,obs_correcao ";
        $sql.="       ,ic_aprovacao ";
        $sql.="       ,obs_aprovacao ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,obs_cancelamento ";
        $sql.="       ,analise_financeira_pk ";

        $sql.="  from analise_financeira_processos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarDataTable(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_nivel_usuario ";
        $sql.="       ,ic_recusa ";
        $sql.="       ,obs_recusa ";
        $sql.="       ,ic_correcao ";
        $sql.="       ,obs_correcao ";
        $sql.="       ,ic_aprovacao ";
        $sql.="       ,obs_aprovacao ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,obs_cancelamento ";
        $sql.="       ,analise_financeira_pk ";

        $sql.="  from analise_financeira_processos ";
        $sql.=" where 1=1 ";
        $sql.=" order by tipo_nivel_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_nivel_usuario ";
        $sql.="       ,ic_recusa ";
        $sql.="       ,obs_recusa ";
        $sql.="       ,ic_correcao ";
        $sql.="       ,obs_correcao ";
        $sql.="       ,ic_aprovacao ";
        $sql.="       ,obs_aprovacao ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,obs_cancelamento ";
        $sql.="       ,analise_financeira_pk ";

        $sql.="  from analise_financeira_processos ";
        $sql.=" where 1=1 ";
        $sql.=" order by tipo_nivel_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function historicoAnaliseFinanceira($analise_financeira_pk){

        $sql ="";
        $sql.=" SELECT  afp.pk";
        $sql.="         ,date_format(afp.dt_cadastro, '%d/%m/%Y') dt_cadastro";
        $sql.="         ,afp.usuario_cadastro_pk";
        $sql.="         ,CASE WHEN afp.ic_recusa = 1 THEN 'Recusado'";
        $sql.="               WHEN afp.ic_correcao = 1 THEN 'Correção'";
        $sql.="               WHEN afp.ic_aprovacao = 1 THEN 'Aprovação'";
        $sql.="           END ic_status";
        $sql.="         ,CASE WHEN afp.ic_recusa = 1 THEN obs_recusa";
        $sql.="               WHEN afp.ic_correcao = 1 THEN obs_correcao";
        $sql.="               WHEN afp.ic_aprovacao = 1 THEN obs_aprovacao";
        $sql.="           END obs";
        $sql.="         ,u.ds_usuario ds_usuario_cadastro";
        $sql.="   FROM analise_financeira_processos afp";
        $sql.="  inner join usuarios u on u.pk = afp.usuario_cadastro_pk";
        $sql.="  where afp.analise_financeira_pk = $analise_financeira_pk";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarObsAnalise($lancamento_pk){

        $sql ="";
        $sql.=" SELECT  afp.pk";
        $sql.="         ,afp.analise_financeira_pk";
        $sql.="         ,CASE WHEN afp.ic_recusa = 1 THEN obs_recusa";
        $sql.="               WHEN afp.ic_correcao = 1 THEN obs_correcao";
        $sql.="               WHEN afp.ic_aprovacao = 1 THEN obs_aprovacao";
        $sql.="           END obs";
        $sql.="         ,CASE WHEN afp.ic_recusa = 1 THEN 'Recusado'";
        $sql.="               WHEN afp.ic_correcao = 1 THEN 'Correção'";
        $sql.="               WHEN afp.ic_aprovacao = 1 THEN 'Aprovação'";
        $sql.="           END ic_status";
        $sql.="   FROM analise_financeira_processos afp";
        $sql.="   left join analise_financeira af on afp.analise_financeira_pk = af.pk";
        $sql.="  where af.lancamentos_pk = $lancamento_pk";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
