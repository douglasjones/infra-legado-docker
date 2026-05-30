<?
require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/colaboradores_exames.class.php';

class colaboradores_examesdao{
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
    
    public function salvar($colaboradores_exames){

        $fields = array();
        $fields['exames_pk'] = $colaboradores_exames->getexames_pk();
        $fields['dt_prevista'] = $colaboradores_exames->getdt_prevista();
        $fields['dt_exame'] = $colaboradores_exames->getdt_exame();
        $fields['ic_status'] = $colaboradores_exames->getic_status();
        $fields['obs'] = $colaboradores_exames->getobs();
        $fields['colaborador_pk'] = $colaboradores_exames->getcolaborador_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($colaboradores_exames->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("colaboradores_exames", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("colaboradores_exames", $fields, " pk = ".$colaboradores_exames->getpk());
        }

    }

    public function excluir($colaboradores_exames){
        $this->db->execDelete("colaboradores_exames"," pk = ".$colaboradores_exames->getpk());
    }

    public function carregarPorPk($pk){

        $colaboradores_exames = new colaboradores_exames();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,exames_pk ";
        $sql.="       ,dt_prevista ";
        $sql.="       ,dt_exame ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";


        $sql.="  from colaboradores_exames ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $colaboradores_exames->setpk($query[$i]["pk"]);
                $colaboradores_exames->setdt_cadastro($query[$i]["dt_cadastro"]);
                $colaboradores_exames->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $colaboradores_exames->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $colaboradores_exames->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $colaboradores_exames->setexames_pk($query[$i]['exames_pk']);
                $colaboradores_exames->setdt_prevista($query[$i]['dt_prevista']);
                $colaboradores_exames->setdt_exame($query[$i]['dt_exame']);
                $colaboradores_exames->setic_status($query[$i]['ic_status']);
                $colaboradores_exames->setobs($query[$i]['obs']);
                $colaboradores_exames->setcolaborador_pk($query[$i]['colaborador_pk']);

            }
        }
        return $colaboradores_exames;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,exames_pk ";
        $sql.="       ,dt_prevista ";
        $sql.="       ,dt_exame ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";

        $sql.="  from colaboradores_exames ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_exames_pk($exames_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,exames_pk ";
        $sql.="       ,dt_prevista ";
        $sql.="       ,dt_exame ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";

        $sql.="  from colaboradores_exames ";
        $sql.=" where 1=1 ";
        if($exames_pk != ""){
            $sql.=" and ds_colaboradores_exames like '%".$exames_pk."%' ";
        }
        $sql.=" order by exames_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,exames_pk ";
        $sql.="       ,dt_prevista ";
        $sql.="       ,dt_exame ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";

        $sql.="  from colaboradores_exames ";
        $sql.=" where 1=1 ";
        $sql.=" order by exames_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
