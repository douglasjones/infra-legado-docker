<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/colaborador_beneficio.class.php';


class colaborador_beneficiodao{

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
    
    public function salvar($colaborador_beneficio){

        $fields = array();
        $fields['vl_beneficio'] = $colaborador_beneficio->getvl_beneficio();
        $fields['obs'] = $colaborador_beneficio->getobs();
        $fields['ic_status'] = $colaborador_beneficio->getic_status();
        $fields['beneficios_pk'] = $colaborador_beneficio->getbeneficios_pk();
        $fields['colaborador_pk'] = $colaborador_beneficio->getcolaborador_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($colaborador_beneficio->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("colaboradores_beneficios", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("colaboradores_beneficios", $fields, " pk = ".$colaborador_beneficio->getpk());
        }

    }

    public function excluir($colaborador_beneficio){
        $this->db->execDelete("colaboradores_beneficios"," pk = ".$colaborador_beneficio->getpk());
    }
    public function excluirColaborador($colaborador_pk){
        $this->db->execDelete("colaboradores_beneficios"," colaborador_pk = ".$colaborador_pk);
    }

    public function carregarPorPk($pk){

        $colaborador_beneficio = new colaborador_beneficio();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,vl_beneficio ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";
        $sql.="       ,beneficios_pk ";
        $sql.="       ,colaborador_pk ";


        $sql.="  from colaboradores_beneficios ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $colaborador_beneficio->setpk($query[$i]["pk"]);
                $colaborador_beneficio->setdt_cadastro($query[$i]["dt_cadastro"]);
                $colaborador_beneficio->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $colaborador_beneficio->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $colaborador_beneficio->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $colaborador_beneficio->setvl_beneficio($query[$i]['vl_beneficio']);
                $colaborador_beneficio->setobs($query[$i]['obs']);
                $colaborador_beneficio->setic_status($query[$i]['ic_status']);
                $colaborador_beneficio->setbeneficios_pk($query[$i]['beneficios_pk']);
                $colaborador_beneficio->setcolaborador_pk($query[$i]['colaborador_pk']);

            }
        }
        return $colaborador_beneficio;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,vl_beneficio ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";
        $sql.="       ,beneficios_pk ";
        $sql.="       ,colaborador_pk ";

        $sql.="  from colaboradores_beneficios ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_vl_beneficio($vl_beneficio){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,vl_beneficio ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";
        $sql.="       ,beneficios_pk ";
        $sql.="       ,colaborador_pk ";

        $sql.="  from colaboradores_beneficios ";
        $sql.=" where 1=1 ";
        if($vl_beneficio != ""){
            $sql.=" and ds_colaborador_beneficio like '%".$vl_beneficio."%' ";
        }
        $sql.=" order by vl_beneficio asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function relColaboradorBebeficio($colaborador_pk,$leads_pk,$beneficios_pk){

        $sql ="";
        $sql.="SELECT cb.pk,";
        $sql.="        l.ds_lead,";
        $sql.="        c.ds_colaborador,";
        $sql.="        b.ds_beneficio,";
        $sql.="        cb.vl_beneficio";
        $sql.=" FROM colaboradores_beneficios cb";
        $sql.="      INNER JOIN colaboradores c ON cb.colaborador_pk = c.pk";
        $sql.="      INNER JOIN beneficios b ON cb.beneficios_pk = b.pk";
        $sql.="      LEFT JOIN agenda_colaborador_padrao a ON cb.colaborador_pk = a.colaboradores_pk";
        $sql.="      LEFT JOIN leads l ON a.leads_pk = l.pk";
        $sql.=" WHERE 1 = 1";
                
        $sql.=" and c.ic_status=1";
        
        if(!empty($colaborador_pk)){
            $sql.=" and cb.colaborador_pk=".$colaborador_pk;
        }
        if(!empty($leads_pk)){
            $sql.=" and l.pk=".$leads_pk;
        }        
        if(!empty($beneficios_pk)){
            $sql.=" and cb.beneficios_pk=".$beneficios_pk;
        }           
        $sql.=" ORDER BY c.ds_colaborador";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,vl_beneficio ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";
        $sql.="       ,beneficios_pk ";
        $sql.="       ,colaborador_pk ";

        $sql.="  from colaboradores_beneficios ";
        $sql.=" where 1=1 ";
        $sql.=" order by vl_beneficio asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
