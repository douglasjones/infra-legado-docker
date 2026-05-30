<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/frota_checklist_itens.class.php';


class frota_checklist_itensdao{

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

    public function salvar($frota_checklist_itens){

        $fields = array();
        $fields['frota_checklist_pk'] = $frota_checklist_itens->getfrota_checklist_pk();
        $fields['auditoria_categorias_itens_pk'] = $frota_checklist_itens->getauditoria_categorias_itens_pk();
        $fields['ds_resultado_dados'] = $frota_checklist_itens->getds_resultado_dados();
        $fields['ds_resultado_textarea'] = $frota_checklist_itens->getds_resultado_textarea();
        $fields['auditorias_categoria_itens_dados_pk'] = $frota_checklist_itens->getauditorias_categoria_itens_dados_pk();
        $fields['ic_checkbox'] = $frota_checklist_itens->getic_checkbox();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($frota_checklist_itens->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("frota_checklist_itens", $fields);
            $frota_checklist_itens->setpk($pk);
        }
        else{
            $this->db->execUpdate("frota_checklist_itens", $fields, " pk = ".$frota_checklist_itens->getpk());
        }
        return $frota_checklist_itens->getpk();;

    }

    public function excluir($frota_checklist_itens){
        $this->db->execDelete("frota_checklist_itens"," pk = ".$frota_checklist_itens->getpk());
    }

    public function carregarPorPk($pk){

        $frota_checklist_itens = new frota_checklist_itens();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,frota_checklist_pk ";
        $sql.="       ,auditoria_categorias_itens_pk ";
        $sql.="       ,ds_resultado_dados ";
        $sql.="       ,ds_resultado_textarea ";
        $sql.="       ,auditorias_categoria_itens_dados_pk ";
        $sql.="       ,ic_checkbox ";


        $sql.="  from frota_checklist_itens ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $frota_checklist_itens->setpk($query[$i]["pk"]);
                $frota_checklist_itens->setdt_cadastro($query[$i]["dt_cadastro"]);
                $frota_checklist_itens->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $frota_checklist_itens->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $frota_checklist_itens->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $frota_checklist_itens->setfrota_checklist_pk($query[$i]['frota_checklist_pk']);
                $frota_checklist_itens->setauditoria_categorias_itens_pk($query[$i]['auditoria_categorias_itens_pk']);
                $frota_checklist_itens->setds_resultado_dados($query[$i]['ds_resultado_dados']);
                $frota_checklist_itens->setds_resultado_textarea($query[$i]['ds_resultado_textarea']);
                $frota_checklist_itens->setauditorias_categoria_itens_dados_pk($query[$i]['auditorias_categoria_itens_dados_pk']);
                $frota_checklist_itens->setic_checkbox($query[$i]['ic_checkbox']);

            }
        }
        return $frota_checklist_itens;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,frota_checklist_pk ";
        $sql.="       ,auditoria_categorias_itens_pk ";
        $sql.="       ,ds_resultado_dados ";
        $sql.="       ,ds_resultado_textarea ";
        $sql.="       ,auditorias_categoria_itens_dados_pk ";
        $sql.="       ,ic_checkbox ";

        $sql.="  from frota_checklist_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_frota_checklist_pk($frota_checklist_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,frota_checklist_pk ";
        $sql.="       ,auditoria_categorias_itens_pk ";
        $sql.="       ,ds_resultado_dados ";
        $sql.="       ,ds_resultado_textarea ";
        $sql.="       ,auditorias_categoria_itens_dados_pk ";
        $sql.="       ,ic_checkbox ";

        $sql.="  from frota_checklist_itens ";
        $sql.=" where 1=1 ";
        if($frota_checklist_pk != ""){
            $sql.=" and ds_frota_checklist_itens like '%".$frota_checklist_pk."%' ";
        }
        $sql.=" order by frota_checklist_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,frota_checklist_pk ";
        $sql.="       ,auditoria_categorias_itens_pk ";
        $sql.="       ,ds_resultado_dados ";
        $sql.="       ,ds_resultado_textarea ";
        $sql.="       ,auditorias_categoria_itens_dados_pk ";
        $sql.="       ,ic_checkbox ";

        $sql.="  from frota_checklist_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by frota_checklist_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
