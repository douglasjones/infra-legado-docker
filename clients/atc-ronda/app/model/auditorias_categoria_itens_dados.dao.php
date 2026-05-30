<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/auditorias_categoria_itens_dados.class.php';
require_once '../model/auditorias_categoria_itens_dados.class.php';
require_once "../model/auditoria_categorias_itens.dao.php";


class auditorias_categoria_itens_dadosdao{

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

    public function salvar($auditorias_categoria_itens_dados, $dadosItensCampo){
        

        $arrDados = json_decode ($dadosItensCampo, true);
        

        for($i=0; $i < count($arrDados); $i++){
            $fields = array();
            $fields['ds_item_dados'] = $arrDados[$i]['ds_item'];
            $fields['auditorias_categorias_itens_pk'] = $arrDados[$i]['itens_pk'];
            $fields['tipo_item_pk'] = $arrDados[$i]['tipo_item_pk'];

            $fields["dt_ult_atualizacao"] = "sysdate()";
            $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("auditorias_categoria_itens_dados", $fields);
            $auditorias_categoria_itens_dados->setpk($pk);
        }

        return $auditorias_categoria_itens_dados->getpk();

    }

    public function excluir($auditorias_categoria_itens_dados){
        $this->db->execDelete("auditorias_categoria_itens_dados"," pk = ".$auditorias_categoria_itens_dados->getpk());
    }

    public function carregarPorPk($pk){

        $auditorias_categoria_itens_dados = new auditorias_categoria_itens_dados();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_item_dados ";
        $sql.="       ,ic_status ";
        $sql.="       ,auditorias_categorias_itens_pk ";
        $sql.="       ,tipo_item_pk ";


        $sql.="  from auditorias_categoria_itens_dados ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $auditorias_categoria_itens_dados->setpk($query[$i]["pk"]);
                $auditorias_categoria_itens_dados->setdt_cadastro($query[$i]["dt_cadastro"]);
                $auditorias_categoria_itens_dados->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $auditorias_categoria_itens_dados->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $auditorias_categoria_itens_dados->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $auditorias_categoria_itens_dados->setds_item_dados($query[$i]['ds_item_dados']);
                $auditorias_categoria_itens_dados->setic_status($query[$i]['ic_status']);
                $auditorias_categoria_itens_dados->setauditorias_categorias_itens_pk($query[$i]['auditorias_categorias_itens_pk']);
                $auditorias_categoria_itens_dados->settipo_item_pk($query[$i]['tipo_item_pk']);

            }
        }
        return $auditorias_categoria_itens_dados;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_item_dados ";
        $sql.="       ,ic_status ";
        $sql.="       ,auditorias_categorias_itens_pk ";
        $sql.="       ,tipo_item_pk ";

        $sql.="  from auditorias_categoria_itens_dados ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorItens($auditorias_categorias_itens_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_item_dados ";
        $sql.="       ,ic_status ";
        $sql.="       ,auditorias_categorias_itens_pk ";
        $sql.="       ,tipo_item_pk ";

        $sql.="  from auditorias_categoria_itens_dados ";
        $sql.=" where auditorias_categorias_itens_pk = $auditorias_categorias_itens_pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_item_dados($ds_item_dados){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_item_dados ";
        $sql.="       ,ic_status ";
        $sql.="       ,auditorias_categorias_itens_pk ";
        $sql.="       ,tipo_item_pk ";

        $sql.="  from auditorias_categoria_itens_dados ";
        $sql.=" where 1=1 ";
        if($ds_item_dados != ""){
            $sql.=" and ds_auditorias_categoria_itens_dados like '%".$ds_item_dados."%' ";
        }
        $sql.=" order by ds_item_dados asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_item_dados ";
        $sql.="       ,ic_status ";
        $sql.="       ,auditorias_categorias_itens_pk ";
        $sql.="       ,tipo_item_pk ";

        $sql.="  from auditorias_categoria_itens_dados ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_item_dados asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
