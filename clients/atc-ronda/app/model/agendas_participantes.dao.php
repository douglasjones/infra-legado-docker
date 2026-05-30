<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/agendas_participantes.class.php';


class agendas_participantesdao{

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

    public function salvar($agendas_participantes){

        $fields = array();
        $fields['ic_tipo_participante'] = $agendas_participantes->getic_tipo_participante();
        $fields['participante_pk'] = $agendas_participantes->getparticipante_pk();
        $fields['ds_email'] = $agendas_participantes->getds_email();
        $fields['ds_cel'] = $agendas_participantes->getds_cel();
        $fields['agendas_pk'] = $agendas_participantes->getagendas_pk();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($agendas_participantes->getpk()  == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
            $pk = $this->db->execInsert("agendas_participantes", $fields);
        }
        else{
            $this->db->execUpdate("agendas_participantes", $fields, " pk = ".$agendas_participantes->getpk());
        }
        return $pk;

    }

    public function excluir($agendas_participantes){
        $this->db->execDelete("agendas_participantes"," pk = ".$agendas_participantes->getpk());
    }

    public function carregarPorPk($pk){

        $agendas_participantes = new agendas_participantes();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ic_tipo_participante ";
        $sql.="       ,participante_pk ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,agendas_pk ";


        $sql.="  from agendas_participantes ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $agendas_participantes->setpk($query[$i]["pk"]);
                $agendas_participantes->setdt_cadastro($query[$i]["dt_cadastro"]);
                $agendas_participantes->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $agendas_participantes->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $agendas_participantes->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $agendas_participantes->setic_tipo_participante($query[$i]['ic_tipo_participante']);
                $agendas_participantes->setparticipante_pk($query[$i]['participante_pk']);
                $agendas_participantes->setds_email($query[$i]['ds_email']);
                $agendas_participantes->setds_cel($query[$i]['ds_cel']);
                $agendas_participantes->setagendas_pk($query[$i]['agendas_pk']);

            }
        }
        return $agendas_participantes;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ic_tipo_participante ";
        $sql.="       ,participante_pk ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,agendas_pk ";

        $sql.="  from agendas_participantes ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_agendas_pk($agendas_pk){

        if($agendas_pk != ""){
            $sql ="";
            $sql.="select ap.pk, ap.dt_cadastro, ap.usuario_cadastro_pk, ap.dt_ult_atualizacao, ap.usuario_ult_atualizacao_pk ";
            $sql.="       ,ap.ic_tipo_participante ";
            $sql.="       ,ap.participante_pk ";
            $sql.="       ,ap.ds_email ";
            $sql.="       ,ap.ds_cel ";
            $sql.="       ,ap.agendas_pk ";
            $sql.="       ,case when ap.ic_tipo_participante = 1 then ds_contato ";
            $sql.="             when ap.ic_tipo_participante = 2 then ds_usuario ";
            $sql.="             end ds_participante ";
            $sql.="  from agendas_participantes ap";
            $sql.="  left join usuarios u on ap.participante_pk = u.pk ";
            $sql.="  left join contatos c on ap.participante_pk = c.pk ";
            $sql.=" where 1=1 ";
            $sql.=" and ap.agendas_pk = ".$agendas_pk;
            $sql.=" order by ap.ic_tipo_participante asc ";
    
            $query = $this->db->execQuery($sql);
        }else{
            $query = [];
        }
        return $query;


    }
    
    public function listar_por_participante_pk($ic_tipo_participante, $participante_pk){

        if($ic_tipo_participante == 2){
            $sql ="";
            $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
            $sql.="       ,ds_usuario ds_participante ";
            $sql.="       ,ds_login ";
            $sql.="       ,ds_senha ";
            $sql.="       ,ds_email ";
            $sql.="       ,ds_cel ";
            $sql.="       ,ic_status ";
            $sql.="       ,grupos_pk ";
            $sql.="       ,leads_pk";

            $sql.="  from usuarios ";
            $sql.=" where 1=1 ";
            if($participante_pk!=""){
                $sql.=" and pk = ".$participante_pk;
            }
            $sql.=" order by ds_usuario asc ";
            $query = $this->db->execQuery($sql);

        }else if($ic_tipo_participante == 1){
            $sql ="";
            $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
            $sql.="       ,ds_contato ds_participante";
            $sql.="       ,ds_email ";
            $sql.="       ,ds_cel ";
            $sql.="       ,leads_pk";

            $sql.="  from contatos ";
            $sql.=" where 1=1 ";
            if($participante_pk!=""){
                $sql.=" and pk = ".$participante_pk;
            }
            $query = $this->db->execQuery($sql);
        }
        return $query;


    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ic_tipo_participante ";
        $sql.="       ,participante_pk ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,agendas_pk ";

        $sql.="  from agendas_participantes ";
        $sql.=" where 1=1 ";
        $sql.=" order by ic_tipo_participante asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function carregarParicipantes($ic_tipo_participante, $leads_pk){
        if($ic_tipo_participante == 1){
            $sql = "";
            $sql.= "SELECT pk participante_pk, ds_contato ds_participante, ds_email, ds_cel";
            $sql.= "  FROM contatos";
            $sql.= " where leads_pk =".$leads_pk;
            $query = $this->db->execQuery($sql);
            return $query;

        }else if($ic_tipo_participante == 2){
            $sql = "";
            $sql.= "SELECT pk participante_pk, ds_usuario ds_participante, ds_email, ds_cel";
            $sql.= "  FROM usuarios";
            $query = $this->db->execQuery($sql);
            return $query;
        }

    }

}

?>
