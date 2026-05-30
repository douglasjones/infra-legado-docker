<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/auditoria_categorias_itens.class.php';


class auditoria_categorias_itensdao{

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

    public function salvar($auditoria_categorias_itens){

        $fields = array();
        $fields['ds_categoria_item'] = $auditoria_categorias_itens->getds_categoria_item();
        $fields['tipo_item_pk'] = $auditoria_categorias_itens->gettipo_item_pk();
        if($auditoria_categorias_itens->getic_status() == ""){
            $fields['ic_status'] = 1;
        }else{
           $fields['ic_status'] = $auditoria_categorias_itens->getic_status();
        }
        $fields['auditorias_categorias_pk'] = $auditoria_categorias_itens->getauditorias_categorias_pk();
        $fields['auditorias_categorias_tipos_pk'] = $auditoria_categorias_itens->getauditorias_categorias_tipos_pk();
        $fields['ic_obrigatorio'] = $auditoria_categorias_itens->getic_obrigatorio();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($auditoria_categorias_itens->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("auditoria_categorias_itens", $fields);
            $auditoria_categorias_itens->setpk($pk);
        }
        else{
            $this->db->execUpdate("auditoria_categorias_itens", $fields, " pk = ".$auditoria_categorias_itens->getpk());
        }
        return $auditoria_categorias_itens->getpk();;

    }

    public function excluir($auditoria_categorias_itens){
        $this->db->execDelete("auditoria_categorias_itens"," pk = ".$auditoria_categorias_itens->getpk());
    }

    public function atualizarStatus($strJSONDadosStatus){
        $arrDados = json_decode ($strJSONDadosStatus, true);
        for($i=0;$i<count($arrDados);$i++){
            $fieldsItens = array();
            $fieldsItens["dt_ult_atualizacao"] = "sysdate()";
            $fieldsItens["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
            $fieldsItens['ic_status'] = $arrDados[$i]['ic_status'];
            $this->db->execUpdate("auditoria_categorias_itens", $fieldsItens, " pk = ".$arrDados[$i]['auditoria_categorias_itens_pk']);
            $this->db->execUpdate("auditorias_categoria_itens_dados", $fieldsItens, " auditorias_categorias_itens_pk = ".$arrDados[$i]['auditoria_categorias_itens_pk']);
        }   
    }

    public function carregarPorPk($pk){

        $auditoria_categorias_itens = new auditoria_categorias_itens();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_categoria_item ";
        $sql.="       ,tipo_item_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,auditorias_categorias_pk ";
        $sql.="       ,auditorias_categorias_tipos_pk ";
        $sql.="       ,ic_obrigatorio ";


        $sql.="  from auditoria_categorias_itens ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $auditoria_categorias_itens->setpk($query[$i]["pk"]);
                $auditoria_categorias_itens->setdt_cadastro($query[$i]["dt_cadastro"]);
                $auditoria_categorias_itens->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $auditoria_categorias_itens->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $auditoria_categorias_itens->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $auditoria_categorias_itens->setds_categoria_item($query[$i]['ds_categoria_item']);
                $auditoria_categorias_itens->settipo_item_pk($query[$i]['tipo_item_pk']);
                $auditoria_categorias_itens->setic_status($query[$i]['ic_status']);
                $auditoria_categorias_itens->setauditorias_categorias_pk($query[$i]['auditorias_categorias_pk']);
                $auditoria_categorias_itens->setauditorias_categorias_tipos_pk($query[$i]['auditorias_categorias_tipos_pk']);
                $auditoria_categorias_itens->setic_obrigatorio($query[$i]['ic_obrigatorio']);

            }
        }
        return $auditoria_categorias_itens;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_categoria_item ";
        $sql.="       ,tipo_item_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,auditorias_categorias_pk ";
        $sql.="       ,auditorias_categorias_tipos_pk ";
        $sql.="       ,ic_obrigatorio ";

        $sql.="  from auditoria_categorias_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarPorCategoriasTiposPk($auditorias_categorias_tipos_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_categoria_item ";
        $sql.="       ,tipo_item_pk";
        $sql.="       , case";
        $sql.="         when tipo_item_pk = 1 then 'Lista Suspensa'";
        $sql.="         when tipo_item_pk = 2 then 'Texto'";
        $sql.="         when tipo_item_pk = 3 then 'Checkbox'";
        $sql.="         when tipo_item_pk = 4 then 'Textarea'";
        $sql.="         end ds_tipo_item";
        $sql.="       ,ic_status ";
        $sql.="       ,auditorias_categorias_pk ";
        $sql.="       ,auditorias_categorias_tipos_pk ";
        $sql.="       ,ic_obrigatorio ";
        $sql.="       ,case ";
        $sql.="        when ic_obrigatorio = 1 then 'Sim' ";
        $sql.="        else 'Não' ";
        $sql.="         end ds_ic_obrigatorio";

        $sql.="  from auditoria_categorias_itens ";
        $sql.=" where auditorias_categorias_tipos_pk = $auditorias_categorias_tipos_pk ";
        $query = $this->db->execQuery($sql);
        
        for($i=0; $i<count($query);$i++){
            $sql ="";
            $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
            $sql.="       ,ds_item_dados ";
            $sql.="       ,ic_status";
            $sql.="       ,auditorias_categorias_itens_pk ";
            $sql.="       ,tipo_item_pk ";
            $sql.="  from auditorias_categoria_itens_dados ";
            $sql.=" where auditorias_categorias_itens_pk = ".$query[$i]["pk"];
            $queryItensDados = $this->db->execQuery($sql);
                $result[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_categoria_item"=>$query[$i]['ds_categoria_item'],
                    "tipo_item_pk"=>$query[$i]['tipo_item_pk'],
                    "ds_tipo_item"=>$query[$i]['ds_tipo_item'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "auditorias_categorias_pk"=>$query[$i]['auditorias_categorias_pk'],
                    "auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "ic_obrigatorio"=>$query[$i]['ic_obrigatorio'],
                    "itensDados"=>$queryItensDados,
                    "ds_ic_obrigatorio"=>$query[$i]['ds_ic_obrigatorio']
                );

        }
        return $result;

    }

    public function listarPorCategoriasTiposSupervisao($auditorias_categorias_tipos_pk, $supervisao_auditorias_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_categoria_item ";
        $sql.="       ,tipo_item_pk";
        $sql.="       , case";
        $sql.="         when tipo_item_pk = 1 then 'Lista Suspensa'";
        $sql.="         when tipo_item_pk = 2 then 'Texto'";
        $sql.="         when tipo_item_pk = 3 then 'Checkbox'";
        $sql.="         when tipo_item_pk = 4 then 'Textarea'";
        $sql.="         end ds_tipo_item";
        $sql.="       ,ic_status ";
        $sql.="       ,auditorias_categorias_pk ";
        $sql.="       ,auditorias_categorias_tipos_pk ";
        $sql.="       ,ic_obrigatorio ";
        $sql.="       ,case ";
        $sql.="        when ic_obrigatorio = 1 then 'Sim' ";
        $sql.="        else 'Não' ";
        $sql.="         end ds_ic_obrigatorio";

        $sql.="  from auditoria_categorias_itens ";
        $sql.=" where auditorias_categorias_tipos_pk = $auditorias_categorias_tipos_pk ";
        $sql.=" and ic_status = 1";
        $query = $this->db->execQuery($sql);
        
        for($i=0; $i<count($query);$i++){
            $sql ="";
            $sql.="select pk auditorias_categoria_itens_dados_pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
            $sql.="       ,ds_item_dados ";
            $sql.="       ,ic_status";
            $sql.="       ,auditorias_categorias_itens_pk ";
            $sql.="       ,tipo_item_pk ";
            $sql.="  from auditorias_categoria_itens_dados ";
            $sql.=" where auditorias_categorias_itens_pk = ".$query[$i]["pk"];
            $sql.=" and ic_status = 1";
            $queryItensDados = $this->db->execQuery($sql);

                $result[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_categoria_item"=>$query[$i]['ds_categoria_item'],
                    "tipo_item_pk"=>$query[$i]['tipo_item_pk'],
                    "ds_tipo_item"=>$query[$i]['ds_tipo_item'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "auditorias_categorias_pk"=>$query[$i]['auditorias_categorias_pk'],
                    "auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "ic_obrigatorio"=>$query[$i]['ic_obrigatorio'],
                    "itensDados"=>$queryItensDados,
                    "ds_ic_obrigatorio"=>$query[$i]['ds_ic_obrigatorio']
                );

        }
        return $result;

    }

    public function listar_por_ds_categoria_item($ds_categoria_item){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_categoria_item ";
        $sql.="       ,tipo_item_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,auditorias_categorias_pk ";
        $sql.="       ,auditorias_categorias_tipos_pk ";
        $sql.="       ,ic_obrigatorio ";

        $sql.="  from auditoria_categorias_itens ";
        $sql.=" where 1=1 ";
        if($ds_categoria_item != ""){
            $sql.=" and ds_auditoria_categorias_itens like '%".$ds_categoria_item."%' ";
        }
        $sql.=" order by ds_categoria_item asc ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_categoria_item ";
        $sql.="       ,tipo_item_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,auditorias_categorias_pk ";
        $sql.="       ,auditorias_categorias_tipos_pk ";
        $sql.="       ,ic_obrigatorio ";

        $sql.="  from auditoria_categorias_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_categoria_item asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
