<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/lead_imposto.class.php';


class lead_impostodao{

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
    
    public function salvar($lead_imposto){

        $fields = array();
        $fields['ds_percentual_imposto'] = $lead_imposto->getds_percentual_imposto();
        $fields['imposto_pk'] = $lead_imposto->getimposto_pk();
        $fields['leads_pk'] = $lead_imposto->getleads_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($lead_imposto->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("leads_impostos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("leads_impostos", $fields, " pk = ".$lead_imposto->getpk());
        }

    }

    public function excluir($lead_imposto){
        $this->db->execDelete("leads_impostos"," pk = ".$lead_imposto->getpk());
    }
    public function excluirPorLead($leads_pk){
        $this->db->execDelete("leads_impostos"," leads_pk = ".$leads_pk);
    }

    public function carregarPorPk($pk){

        $lead_imposto = new lead_imposto();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_percentual_imposto ";
        $sql.="       ,imposto_pk ";
        $sql.="       ,leads_pk ";


        $sql.="  from leads_impostos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $lead_imposto->setpk($query[$i]["pk"]);
                $lead_imposto->setdt_cadastro($query[$i]["dt_cadastro"]);
                $lead_imposto->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $lead_imposto->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $lead_imposto->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $lead_imposto->setds_percentual_imposto($query[$i]['ds_percentual_imposto']);
                $lead_imposto->setimposto_pk($query[$i]['imposto_pk']);
                $lead_imposto->setleads_pk($query[$i]['leads_pk']);

            }
        }
        return $lead_imposto;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_percentual_imposto ";
        $sql.="       ,imposto_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from leads_impostos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarImpostoPorLead($leads_pk,$dt_cadastro){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_percentual_imposto ";
        $sql.="       ,imposto_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from leads_impostos ";
        $sql.=" where leads_pk = $leads_pk ";
        if($dt_cadastro!=""){
            $sql.=" and dt_cadastro <= '".DataYMD($dt_cadastro)." 23:59:59'";
        }
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_percentual_imposto($ds_percentual_imposto){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_percentual_imposto ";
        $sql.="       ,imposto_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from leads_impostos ";
        $sql.=" where 1=1 ";
        if($ds_percentual_imposto != ""){
            $sql.=" and ds_lead_imposto like '%".$ds_percentual_imposto."%' ";
        }
        $sql.=" order by ds_percentual_imposto asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_percentual_imposto ";
        $sql.="       ,imposto_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from leads_impostos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_percentual_imposto asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
