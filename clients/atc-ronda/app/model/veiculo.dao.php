<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/veiculo.class.php';


class veiculodao{

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

    public function salvar($veiculo){

        $fields = array();
        $fields['id_veiculo'] = $veiculo->getid_veiculo();
        $fields['ds_placa'] = $veiculo->getds_placa();
        $fields['ds_km_inicial'] = $veiculo->getds_km_inicial();
        $fields['ds_cor'] = $veiculo->getds_cor();
        $fields['tipo_veiculo_pk'] = $veiculo->gettipo_veiculo_pk();
        $fields['marcas_veiculos_pk'] = $veiculo->getmarcas_veiculos_pk();
        $fields['modelos_veiculos_pk'] = $veiculo->getmodelos_veiculos_pk();
        $fields['leads_pk'] = $veiculo->getleads_pk();
        $fields['ic_status'] = $veiculo->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($veiculo->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("frota", $fields);

            $veiculo->setpk($pk);
        }
        else{
            $this->db->execUpdate("frota", $fields, " pk = ".$veiculo->getpk());
        }
        return $veiculo->getpk();;

    }

    public function excluir($veiculo){
        $this->db->execDelete("frota"," pk = ".$veiculo->getpk());
    }

    public function carregarPorPk($pk){

        $veiculo = new veiculo();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,id_veiculo ";
        $sql.="       ,ds_placa ";
        $sql.="       ,ds_km_inicial ";
        $sql.="       ,ds_cor ";
        $sql.="       ,tipo_veiculo_pk ";
        $sql.="       ,marcas_veiculos_pk ";
        $sql.="       ,modelos_veiculos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_status ";


        $sql.="  from frota ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $veiculo->setpk($query[$i]["pk"]);
                $veiculo->setdt_cadastro($query[$i]["dt_cadastro"]);
                $veiculo->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $veiculo->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $veiculo->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $veiculo->setid_veiculo($query[$i]['id_veiculo']);
                $veiculo->setds_placa($query[$i]['ds_placa']);
                $veiculo->setds_km_inicial($query[$i]['ds_km_inicial']);
                $veiculo->setds_cor($query[$i]['ds_cor']);
                $veiculo->settipo_veiculo_pk($query[$i]['tipo_veiculo_pk']);
                $veiculo->setmarcas_veiculos_pk($query[$i]['marcas_veiculos_pk']);
                $veiculo->setmodelos_veiculos_pk($query[$i]['modelos_veiculos_pk']);
                $veiculo->setleads_pk($query[$i]['leads_pk']);
                $veiculo->setic_status($query[$i]['ic_status']);

            }
        }
        return $veiculo;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,id_veiculo ";
        $sql.="       ,ds_placa ";
        $sql.="       ,ds_km_inicial ";
        $sql.="       ,ds_cor ";
        $sql.="       ,tipo_veiculo_pk ";
        $sql.="       ,marcas_veiculos_pk ";
        $sql.="       ,modelos_veiculos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from frota ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_id_veiculo($id_veiculo,$ds_placa,$leads_pk,$ic_status){
        $sql ="";
        $sql.="select f.pk, f.dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.id_veiculo ";
        $sql.="       ,f.ds_placa ";        
        $sql.="       ,f.ds_cor ";
        $sql.="       ,tv.ds_tipo_veiculo ";
        $sql.="       ,mv.ds_marca_veiculo ";
        $sql.="       ,mvi.ds_modelo_veiculo ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,case f.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";        
        $sql.="  from frota f ";
        $sql.=" INNER JOIN leads l on f.leads_pk = l.pk";
        $sql.=" LEFT JOIN tipo_veiculo tv on f.tipo_veiculo_pk = tv.pk";
        $sql.=" LEFT JOIN marcas_veiculos mv on f.marcas_veiculos_pk = mv.pk ";
        $sql.=" LEFT JOIN modelos_veiculos mvi on f.modelos_veiculos_pk  = mvi.pk ";
        $sql.=" where 1=1 ";
        if($id_veiculo != ""){
            $sql.=" and f.ds_veiculo = '".$id_veiculo."' ";
        }
        if($ds_placa != ""){
            $sql.=" and f.ds_ds_placa = '".$ds_placa."' ";
        }
        if(!empty($leads_pk)){
            $sql.=" and f.leads_pk=".$leads_pk;
        }
        if(!empty($ic_status)){
            $sql.=" and f.ic_status=".$ic_status;
        }
        $sql.=" order by f.id_veiculo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,id_veiculo ";
        $sql.="       ,ds_placa ";
        $sql.="       ,ds_km_inicial ";
        $sql.="       ,ds_cor ";
        $sql.="       ,tipo_veiculo_pk ";
        $sql.="       ,marcas_veiculos_pk ";
        $sql.="       ,modelos_veiculos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from frota ";
        $sql.=" where 1=1 ";
        $sql.=" order by id_veiculo asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarTiposVeiculos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_tipo_veiculo ";

        $sql.="  from tipo_veiculo ";
        $sql.=" where 1=1 ";


        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarMarcasVeiculos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_marca_veiculo";

        $sql.="  from marcas_veiculos ";
        $sql.=" where 1=1 ";


        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarModelosVeiculos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_modelo_veiculo";

        $sql.="  from modelos_veiculos";
        $sql.=" where 1=1 ";


        $query = $this->db->execQuery($sql);
        return $query;
    }
}

?>
