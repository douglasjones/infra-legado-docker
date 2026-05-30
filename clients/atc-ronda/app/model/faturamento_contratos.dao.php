<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/faturamento_contratos.class.php';


class faturamento_contratosdao{

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

    public function salvar($faturamento_contratos, $arrItens){

        $fields = array();
        $fields['ic_tipo_contrato'] = $faturamento_contratos->getic_tipo_contrato();
        $fields['contratos_pk'] = $faturamento_contratos->getcontratos_pk();
        $fields['leads_pk'] = $faturamento_contratos->getleads_pk();
        $fields['faturamento_pk'] = $faturamento_contratos->getfaturamento_pk();
        $fields['vl_total_contrato'] = $faturamento_contratos->getvl_total_contrato();
        $fields['ic_status'] = $faturamento_contratos->getic_status();
        $fields['obs_corpo_nota_fiscal'] = $faturamento_contratos->getobs_corpo_nota_fiscal();
        $fields['dt_vencimento'] = DataYMD($faturamento_contratos->getdt_vencimento());
        $fields['dt_faturamento'] = DataYMD($faturamento_contratos->getdt_faturamento());


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($faturamento_contratos->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("faturamento_contratos", $fields);
            $faturamento_contratos->setpk($pk);
        }
        else{
            $this->db->execUpdate("faturamento_contratos", $fields, " pk = ".$faturamento_contratos->getpk());
            $pk = $faturamento_contratos->getpk();
        }
        $arrItens = json_decode($arrItens, true);
        $fieldsItens = array();
       // echo $arrItens;

        for($i=0; $i<count($arrItens); $i++){
            $fieldsItens['produtos_servicos_pk'] = $arrItens[$i]['produto_servico_pk'];
            $fieldsItens['n_qtde_produtos_servicos'] = $arrItens[$i]['n_qtde_colaborador'];
            $fieldsItens['vl_unitario_produtos_servicos'] = moeda2float($arrItens[$i]['vl_unitario_produtos_servicos']);
            $fieldsItens['ds_periodo'] = $arrItens[$i]['ds_periodo'];
            $fieldsItens['n_qtde_dias_semana'] = $arrItens[$i]['n_qtde_dias_semana'];
            $fieldsItens['faturamento_contratos_pk'] = $pk;
            $fieldsItens['contratos_pk'] = $faturamento_contratos->getcontratos_pk();
            $fieldsItens['ic_status'] = 1;
    
            $fieldsItens["dt_ult_atualizacao"] = "sysdate()";
            $fieldsItens["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
    
            $fieldsItens["dt_cadastro"] = "sysdate()";
            $fieldsItens["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
           // echo $arrItens[$i]['faturamento_contratos_itens_pk']."<br>";

            if($arrItens[$i]['faturamento_contratos_itens_pk']  == ""){

                $fields["dt_cadastro"] = "sysdate()";
                $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
                $this->db->execInsert("faturamento_contratos_itens", $fieldsItens);
                ///echo $this->db->getLastSQL();
            }
            else{
                $this->db->execUpdate("faturamento_contratos_itens", $fieldsItens, " pk = ".$arrItens[$i]['faturamento_contratos_itens_pk']);
                ///echo $this->db->getLastSQL();
            }
        }

        return $faturamento_contratos->getpk();

    }

    public function excluir($faturamento_contratos){
        $this->db->execDelete("faturamento_contratos"," pk = ".$faturamento_contratos->getpk());
    }

    public function carregarPorPk($pk){

        $faturamento_contratos = new faturamento_contratos();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ic_tipo_contrato ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,faturamento_pk ";
        $sql.="       ,vl_total_contrato ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs_corpo_nota_fiscal ";


        $sql.="  from faturamento_contratos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $faturamento_contratos->setpk($query[$i]["pk"]);
                $faturamento_contratos->setdt_cadastro($query[$i]["dt_cadastro"]);
                $faturamento_contratos->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $faturamento_contratos->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $faturamento_contratos->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $faturamento_contratos->setic_tipo_contrato($query[$i]['ic_tipo_contrato']);
                $faturamento_contratos->setcontratos_pk($query[$i]['contratos_pk']);
                $faturamento_contratos->setleads_pk($query[$i]['leads_pk']);
                $faturamento_contratos->setfaturamento_pk($query[$i]['faturamento_pk']);
                $faturamento_contratos->setvl_total_contrato($query[$i]['vl_total_contrato']);
                $faturamento_contratos->setic_status($query[$i]['ic_status']);
                $faturamento_contratos->setobs_corpo_nota_fiscal($query[$i]['obs_corpo_nota_fiscal']);

            }
        }
        return $faturamento_contratos;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ic_tipo_contrato ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,faturamento_pk ";
        $sql.="       ,vl_total_contrato ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs_corpo_nota_fiscal ";

        $sql.="  from faturamento_contratos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ic_tipo_contrato($ic_tipo_contrato){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ic_tipo_contrato ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,faturamento_pk ";
        $sql.="       ,vl_total_contrato ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs_corpo_nota_fiscal ";

        $sql.="  from faturamento_contratos ";
        $sql.=" where 1=1 ";
        if($ic_tipo_contrato != ""){
            $sql.=" and ds_faturamento_contratos like '%".$ic_tipo_contrato."%' ";
        }
        $sql.=" order by ic_tipo_contrato asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ic_tipo_contrato ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,faturamento_pk ";
        $sql.="       ,vl_total_contrato ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs_corpo_nota_fiscal ";

        $sql.="  from faturamento_contratos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ic_tipo_contrato asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
