<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/processos_default_modulos.class.php';


class processos_default_modulosdao{

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

    public function salvar($processos_default_modulos){

        $fields = array();
        $fields['ds_modulo'] = $processos_default_modulos->getds_modulo();
        $fields['ds_arquivo_res'] = $processos_default_modulos->getds_arquivo_res();
        $fields['ds_arquivo_cad'] = $processos_default_modulos->getds_arquivo_cad();
        $fields['ds_arquivo_controller'] = $processos_default_modulos->getds_arquivo_controller();
        $fields['ds_arquivo_dao'] = $processos_default_modulos->getds_arquivo_dao();
        $fields['ds_ok'] = $processos_default_modulos->getds_ok();
        $fields['ic_status'] = $processos_default_modulos->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($processos_default_modulos->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("processos_default_modulos", $fields);
            $processos_default_modulos->setpk($pk);
        }
        else{
            $this->db->execUpdate("processos_default_modulos", $fields, " pk = ".$processos_default_modulos->getpk());
        }
        return $processos_default_modulos->getpk();;

    }

    public function excluir($processos_default_modulos){
        $this->db->execDelete("processos_default_modulos"," pk = ".$processos_default_modulos->getpk());
    }

    public function carregarPorPk($pk){

        $processos_default_modulos = new processos_default_modulos();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_modulo ";
        $sql.="       ,ds_arquivo_res ";
        $sql.="       ,ds_arquivo_cad ";
        $sql.="       ,ds_arquivo_controller ";
        $sql.="       ,ds_arquivo_dao ";
        $sql.="       ,ds_ok ";
        $sql.="       ,ic_status ";


        $sql.="  from processos_default_modulos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $processos_default_modulos->setpk($query[$i]["pk"]);
                $processos_default_modulos->setdt_cadastro($query[$i]["dt_cadastro"]);
                $processos_default_modulos->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $processos_default_modulos->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $processos_default_modulos->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $processos_default_modulos->setds_modulo($query[$i]['ds_modulo']);
                $processos_default_modulos->setds_arquivo_res($query[$i]['ds_arquivo_res']);
                $processos_default_modulos->setds_arquivo_cad($query[$i]['ds_arquivo_cad']);
                $processos_default_modulos->setds_arquivo_controller($query[$i]['ds_arquivo_controller']);
                $processos_default_modulos->setds_arquivo_dao($query[$i]['ds_arquivo_dao']);
                $processos_default_modulos->setds_ok($query[$i]['ds_ok']);
                $processos_default_modulos->setic_status($query[$i]['ic_status']);

            }
        }
        return $processos_default_modulos;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_modulo ";
        $sql.="       ,ds_arquivo_res ";
        $sql.="       ,ds_arquivo_cad ";
        $sql.="       ,ds_arquivo_controller ";
        $sql.="       ,ds_arquivo_dao ";
        $sql.="       ,ds_ok ";
        $sql.="       ,ic_status ";

        $sql.="  from processos_default_modulos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_modulo($ds_modulo){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_modulo ";
        $sql.="       ,ds_arquivo_res ";
        $sql.="       ,ds_arquivo_cad ";
        $sql.="       ,ds_arquivo_controller ";
        $sql.="       ,ds_arquivo_dao ";
        $sql.="       ,ds_ok ";
        $sql.="       ,ic_status ";

        $sql.="  from processos_default_modulos ";
        $sql.=" where 1=1 ";
        if($ds_modulo != ""){
            $sql.=" and ds_processos_default_modulos like '%".$ds_modulo."%' ";
        }
        $sql.=" order by ds_modulo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_modulo ";
        $sql.="       ,ds_arquivo_res ";
        $sql.="       ,ds_arquivo_cad ";
        $sql.="       ,ds_arquivo_controller ";
        $sql.="       ,ds_arquivo_dao ";
        $sql.="       ,ds_ok ";
        $sql.="       ,ic_status ";

        $sql.="  from processos_default_modulos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_modulo asc ";
     
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarProcessoDefaultPk(){

        $sql ="";
        $sql.="select pdm.pk, pdm.dt_cadastro, pdm.usuario_cadastro_pk, pdm.dt_ult_atualizacao, pdm.usuario_ult_atualizacao_pk ";
        $sql.="       ,pdm.ds_modulo ";

        $sql.="  from processos_default_modulos pdm";
        $sql.="  left join processo_default_configuracao pdc on pdm.processos_default_modulos_pk =  pdc.pk";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_modulo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
