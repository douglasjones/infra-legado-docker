<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/ronda.class.php';


class rondadao{

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

    public function salvar($ronda){

        $fields = array();
        $fields['leads_pk'] = $ronda->getleads_pk();
        $fields['local_ronda_pk'] = $ronda->getlocal_ronda_pk();
        $fields['dt_ronda'] == "sysdate()";


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = 1;

        if($ronda->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = 1;

            $pk = $this->db->execInsert("ronda", $fields);
            echo $this->db->getLastSQL();

        }
        else{
            $this->db->execUpdate("ronda", $fields, " pk = ".$ronda->getpk());
        }
        return $ronda->getpk();;

    }

    public function excluir($ronda){
        $this->db->execDelete("ronda"," pk = ".$ronda->getpk());
    }

    public function carregarPorPk($pk){

        $ronda = new ronda();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,leads_pk ";
        $sql.="       ,local_ronda_pk ";
        $sql.="       ,dt_ronda ";


        $sql.="  from ronda ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $ronda->setpk($query[$i]["pk"]);
                $ronda->setdt_cadastro($query[$i]["dt_cadastro"]);
                $ronda->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $ronda->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $ronda->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $ronda->setleads_pk($query[$i]['leads_pk']);
                $ronda->setlocal_ronda_pk($query[$i]['local_ronda_pk']);
                $ronda->setdt_ronda($query[$i]['dt_ronda']);

            }
        }
        return $ronda;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,leads_pk ";
        $sql.="       ,local_ronda_pk ";
        $sql.="       ,dt_ronda ";

        $sql.="  from ronda ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_leads_pk($leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,local_ronda_pk ";
        $sql.="       ,dt_ronda ";

        $sql.="  from ronda ";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and ds_ronda like '%".$leads_pk."%' ";
        }
        $sql.=" order by leads_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,local_ronda_pk ";
        $sql.="       ,dt_ronda ";

        $sql.="  from ronda ";
        $sql.=" where 1=1 ";
        $sql.=" order by leads_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function relatorioRonda($leads_pk,$dt_ronda_ini,$dt_ronda_fim){

        $sql ="";
        $sql.="select r.pk, r.dt_cadastro, r.usuario_cadastro_pk, r.dt_ult_atualizacao, r.usuario_ult_atualizacao_pk ";
        $sql.="       ,r.leads_pk ";
        $sql.="       ,r.local_ronda_pk ";
        $sql.="       ,r.leads_pk ds_lead";        
        $sql.="       ,date_format(r.dt_cadastro, '%d/%m/%Y') dt_cad";
        $sql.="       ,date_format(r.dt_cadastro, '%H:%i') hr_ronda";
        $sql.="  from ronda r";
        $sql.=" left join leads l on r.leads_pk = l.ds_lead";
        $sql.=" where 1=1 ";
        if(!empty($dt_ronda_ini)){
            $sql.=" and r.dt_cadastro >='".DataYMD($dt_ronda_ini)." 00:00:00'";
        }       
        if(!empty($dt_ronda_fim)){
            $sql.=" and r.dt_cadastro <='".DataYMD($dt_ronda_fim)." 23:59:59'";
        }
        if($leads_pk!=''){
            //$sql.=" and r.leads_pk like'%".$leads_pk."%'";
        }

        $sql.=" order by r.dt_cadastro asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
