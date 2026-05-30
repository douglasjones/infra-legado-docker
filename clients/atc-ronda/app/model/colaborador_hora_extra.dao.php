<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/colaborador_hora_extra.class.php';


class colaborador_hora_extradao{

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
    
    public function salvar($colaborador_hora_extra){

        $fields = array();
        $fields['colaborador_pk'] = $colaborador_hora_extra->getcolaborador_pk();
        $fields['leads_pk'] = $colaborador_hora_extra->getleads_pk();
        
        $fields['dt_escala'] = DataYMD($colaborador_hora_extra->getdt_escala());
        $fields['hr_extra_ini'] = $colaborador_hora_extra->gethr_extra_ini();
        $fields['hr_extra_fim'] = $colaborador_hora_extra->gethr_extra_fim();
        $fields['obs'] = $colaborador_hora_extra->getobs();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($colaborador_hora_extra->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("colaboradores_hora_extra", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("colaboradores_hora_extra", $fields, " pk = ".$colaborador_hora_extra->getpk());
        }

    }
    public function excluirColaborador($pk){
        $this->db->execDelete("colaboradores_hora_extra"," pk = ".$pk);
    }
    public function carregarPorColaboradorPk($colaborador_pk,$dt_escala,$leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,leads_pk ";

        $sql.="  from colaboradores_hora_extra ";
        $sql.=" where 1=1";
        $sql.=" and colaborador_pk = ".$colaborador_pk;
        if($leads_pk!=""){
            $sql.=" and leads_pk = ".$leads_pk;
        }
        $sql.=" and dt_escala= '".DataYMD($dt_escala)."'";
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function excluir($colaborador_hora_extra){
        $this->db->execDelete("colaboradores_hora_extra"," pk = ".$colaborador_hora_extra->getpk());
    }

    public function carregarPorPk($pk){

        $colaborador_hora_extra = new colaborador_hora_extra();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,hr_extra_ini ";
        $sql.="       ,hr_extra_fim ";
        $sql.="       ,obs ";


        $sql.="  from colaboradores_hora_extra ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $colaborador_hora_extra->setpk($query[$i]["pk"]);
                $colaborador_hora_extra->setdt_cadastro($query[$i]["dt_cadastro"]);
                $colaborador_hora_extra->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $colaborador_hora_extra->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $colaborador_hora_extra->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $colaborador_hora_extra->setcolaborador_pk($query[$i]['colaborador_pk']);
                $colaborador_hora_extra->setleads_pk($query[$i]['leads_pk']);
                $colaborador_hora_extra->setdt_escala($query[$i]['dt_escala']);
                $colaborador_hora_extra->sethr_extra_ini($query[$i]['hr_extra_ini']);
                $colaborador_hora_extra->sethr_extra_fim($query[$i]['hr_extra_fim']);
                $colaborador_hora_extra->setobs($query[$i]['obs']);

            }
        }
        return $colaborador_hora_extra;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,hr_extra_ini ";
        $sql.="       ,hr_extra_fim ";
        $sql.="       ,obs ";

        $sql.="  from colaboradores_hora_extra ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_colaborador_pk($colaborador_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,hr_extra_ini ";
        $sql.="       ,hr_extra_fim ";
        $sql.="       ,obs ";

        $sql.="  from colaboradores_hora_extra ";
        $sql.=" where 1=1 ";
        if($colaborador_pk != ""){
            $sql.=" and ds_colaborador_hora_extra like '%".$colaborador_pk."%' ";
        }
        $sql.=" order by colaborador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,hr_extra_ini ";
        $sql.="       ,hr_extra_fim ";
        $sql.="       ,obs ";

        $sql.="  from colaboradores_hora_extra ";
        $sql.=" where 1=1 ";
        $sql.=" order by colaborador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
