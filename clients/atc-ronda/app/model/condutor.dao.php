<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/condutor.class.php';


class condutordao{

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

    public function salvar($condutor){

        $fields = array();
        $fields['ds_condutor'] = $condutor->getds_condutor();
        $fields['ds_cpf'] = $condutor->getds_cpf();
        $fields['ds_rg'] = $condutor->getds_rg();
        $fields['leads_pk'] = $condutor->getleads_pk();
        $fields['ic_status'] = $condutor->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($condutor->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("condutores", $fields);
            $condutor->setpk($pk);
        }
        else{
            $this->db->execUpdate("condutores", $fields, " pk = ".$condutor->getpk());
        }
        return $condutor->getpk();;

    }

    public function excluir($condutor){
        $this->db->execDelete("condutores"," pk = ".$condutor->getpk());
    }

    public function carregarPorPk($pk){

        $condutor = new condutor();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_condutor ";
        $sql.="       ,ds_cpf ";
        $sql.="       ,ds_rg ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_status ";


        $sql.="  from condutores ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $condutor->setpk($query[$i]["pk"]);
                $condutor->setdt_cadastro($query[$i]["dt_cadastro"]);
                $condutor->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $condutor->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $condutor->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $condutor->setds_condutor($query[$i]['ds_condutor']);
                $condutor->setds_cpf($query[$i]['ds_cpf']);
                $condutor->setds_rg($query[$i]['ds_rg']);
                $condutor->setleads_pk($query[$i]['leads_pk']);
                $condutor->setic_status($query[$i]['ic_status']);

            }
        }
        return $condutor;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_condutor ";
        $sql.="       ,ds_cpf ";
        $sql.="       ,ds_rg ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from condutores ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_condutor($ds_condutor,$leads_pk,$ic_status){

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
        $sql.="       ,c.ds_condutor ";
        $sql.="       ,c.ds_cpf ";
        $sql.="       ,c.ds_rg ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,c.ic_status ";
        $sql.="       ,case c.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";
        $sql.="  from condutores c ";
        $sql.=" LEFT JOIN leads l on c.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        if($ds_condutor != ""){
            $sql.=" and c.ds_condutor like '%".$ds_condutor."%' ";
        }
        if(!empty($leads_pk)){
            $sql.=" and c.leads_pk=".$leads_pk;
        }
        if(!empty($ic_status)){
            $sql.=" and c.ic_status=".$ic_status;
        }
        $sql.=" order by c.ds_condutor asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_condutor ";
        $sql.="       ,ds_cpf ";
        $sql.="       ,ds_rg ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from condutores ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_condutor asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
