<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/lead_desconto.class.php';


class lead_descontodao{

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
    
    public function salvar($lead_desconto){

        $fields = array();
        $fields['ds_desconto'] = $lead_desconto->getds_desconto();
        $fields['dt_base'] = $lead_desconto->getdt_base();
        $fields['vl_desconto'] = $lead_desconto->getvl_desconto();
        $fields['leads_pk'] = $lead_desconto->getleads_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($lead_desconto->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("leads_desconto", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("leads_desconto", $fields, " pk = ".$lead_desconto->getpk());
        }

    }

    public function excluir($lead_desconto){
        $this->db->execDelete("leads_desconto"," pk = ".$lead_desconto->getpk());
    }
    public function excluirPorLead($leads_pk){
        $this->db->execDelete("leads_desconto"," leads_pk = ".$leads_pk);
    }

    public function carregarPorPk($pk){

        $lead_desconto = new lead_desconto();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_desconto ";
        $sql.="       ,dt_base ";
        $sql.="       ,vl_desconto ";
        $sql.="       ,leads_pk ";


        $sql.="  from leads_desconto ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $lead_desconto->setpk($query[$i]["pk"]);
                $lead_desconto->setdt_cadastro($query[$i]["dt_cadastro"]);
                $lead_desconto->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $lead_desconto->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $lead_desconto->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $lead_desconto->setds_desconto($query[$i]['ds_desconto']);
                $lead_desconto->setdt_base($query[$i]['dt_base']);
                $lead_desconto->setvl_desconto($query[$i]['vl_desconto']);
                $lead_desconto->setleads_pk($query[$i]['leads_pk']);

            }
        }
        return $lead_desconto;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_desconto ";
        $sql.="       ,dt_base ";
        $sql.="       ,vl_desconto ";
        $sql.="       ,leads_pk ";

        $sql.="  from leads_desconto ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarDescontoPorLead($leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_desconto ";
        $sql.="       ,date_format(dt_base,'%d/%m/%Y')dt_base";
        $sql.="       ,vl_desconto ";
        $sql.="       ,leads_pk ";

        $sql.="  from leads_desconto ";
        $sql.=" where leads_pk = $leads_pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_desconto($ds_desconto){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_desconto ";
        $sql.="       ,dt_base ";
        $sql.="       ,vl_desconto ";
        $sql.="       ,leads_pk ";

        $sql.="  from leads_desconto ";
        $sql.=" where 1=1 ";
        if($ds_desconto != ""){
            $sql.=" and ds_lead_desconto like '%".$ds_desconto."%' ";
        }
        $sql.=" order by ds_desconto asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_desconto ";
        $sql.="       ,dt_base ";
        $sql.="       ,vl_desconto ";
        $sql.="       ,leads_pk ";

        $sql.="  from leads_desconto ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_desconto asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
