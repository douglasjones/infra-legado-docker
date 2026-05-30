<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/frota.class.php';


class frotadao{

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

    public function salvar($frota){

        $fields = array();
        $fields['id_veiculo'] = $frota->getid_veiculo();
        $fields['ds_placa'] = $frota->getds_placa();
        $fields['ds_km_inicial'] = $frota->getds_km_inicial();
        $fields['ds_cor'] = $frota->getds_cor();
        $fields['tipo_veiculo_pk'] = $frota->gettipo_veiculo_pk();
        $fields['marcas_veiculos_pk'] = $frota->getmarcas_veiculos_pk();
        $fields['modelos_veiculos_pk'] = $frota->getmodelos_veiculos_pk();
        $fields['leads_pk'] = $frota->getleads_pk();
        $fields['ic_status'] = $frota->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($frota->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("frota", $fields);
            $frota->setpk($pk);
        }
        else{
            $this->db->execUpdate("frota", $fields, " pk = ".$frota->getpk());
        }
        return $frota->getpk();;

    }

    public function excluir($frota){
        $this->db->execDelete("frota"," pk = ".$frota->getpk());
    }

    public function carregarPorPk($pk){

        $frota = new frota();
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
                $frota->setpk($query[$i]["pk"]);
                $frota->setdt_cadastro($query[$i]["dt_cadastro"]);
                $frota->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $frota->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $frota->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $frota->setid_veiculo($query[$i]['id_veiculo']);
                $frota->setds_placa($query[$i]['ds_placa']);
                $frota->setds_km_inicial($query[$i]['ds_km_inicial']);
                $frota->setds_cor($query[$i]['ds_cor']);
                $frota->settipo_veiculo_pk($query[$i]['tipo_veiculo_pk']);
                $frota->setmarcas_veiculos_pk($query[$i]['marcas_veiculos_pk']);
                $frota->setmodelos_veiculos_pk($query[$i]['modelos_veiculos_pk']);
                $frota->setleads_pk($query[$i]['leads_pk']);
                $frota->setic_status($query[$i]['ic_status']);

            }
        }
        return $frota;
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

    public function listar_por_id_veiculo($id_veiculo){

        $sql ="";
        $sql.="select f.pk, f.dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.id_veiculo ";
        $sql.="       ,f.ds_placa ";
        $sql.="       ,f.ds_km_inicial ";
        $sql.="       ,f.ds_cor ";
        $sql.="       ,f.tipo_veiculo_pk ";
        $sql.="       ,f.marcas_veiculos_pk ";
        $sql.="       ,f.modelos_veiculos_pk ";
        $sql.="       ,f.leads_pk ";
        $sql.="       ,f.ic_status ";
        $sql.="       ,f.ic_status ";
        $sql.="       ,fc.pk frota_checklist_pk";

        $sql.="  from frota f";
        $sql.="  left join frota_checklist fc on fc.frota_pk = f.pk ";
        $sql.=" where 1=1 ";
        if($id_veiculo != ""){
            $sql.=" and f.id_veiculo like '".$id_veiculo."' ";
        }
        $query = $this->db->execQuery($sql);

        if($query[0]['frota_checklist_pk'] > 0){
            $sql ="";
            $sql.="select aci.pk, aci.dt_cadastro, aci.usuario_cadastro_pk, aci.dt_ult_atualizacao, aci.usuario_ult_atualizacao_pk  ";
            $sql.="       ,aci.ds_categoria_item ";
            $sql.="       ,aci.tipo_item_pk";
            $sql.="       , case";
            $sql.="         when aci.tipo_item_pk = 1 then 'Lista Suspensa'";
            $sql.="         when aci.tipo_item_pk = 2 then 'Texto'";
            $sql.="         when aci.tipo_item_pk = 3 then 'Checkbox'";
            $sql.="         when aci.tipo_item_pk = 4 then 'Textarea'";
            $sql.="         end ds_tipo_item";
            $sql.="       ,aci.ic_status ";
            $sql.="       ,aci.auditorias_categorias_pk ";
            $sql.="       ,aci.auditorias_categorias_tipos_pk ";
            $sql.="       ,aci.ic_obrigatorio ";
            $sql.="       ,case ";
            $sql.="        when aci.ic_obrigatorio = 1 then 'Sim' ";
            $sql.="        else 'Não' ";
            $sql.="         end ds_ic_obrigatorio";

            $sql.="  from auditoria_categorias_itens aci";
            $sql.="  inner join auditoria_categorias_tipos act on aci.auditorias_categorias_tipos_pk = act.pk";
            $sql.=" where act.ds_auditoria_categoria_tipo like 'Checklist Frota'";
            $sql.=" and aci.ic_status = 1";
            $DadosForm = $this->db->execQuery($sql);
        
            for($i=0; $i<count($DadosForm);$i++){
                $sql ="";
                $sql.="select pk auditorias_categoria_itens_dados_pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
                $sql.="       ,ds_item_dados ";
                $sql.="       ,ic_status";
                $sql.="       ,auditorias_categorias_itens_pk ";
                $sql.="       ,tipo_item_pk ";
                $sql.="  from auditorias_categoria_itens_dados ";
                $sql.=" where auditorias_categorias_itens_pk = ".$DadosForm[$i]["pk"];
                $sql.=" and ic_status = 1";
                $queryItensDados = $this->db->execQuery($sql);

                for($l=0;$l<count($queryItensDados);$l++){
                   if($l==0){
                       $a=$l;
                   }else{
                       $a=
                       -1;
                   }

                    $sql ="";
                    $sql.="select MAX(fci.pk) pk";
                    $sql.="       , fci.auditoria_categorias_itens_pk ";
                    $sql.="       , fci.ds_resultado_dados";
                    $sql.="       , fci.ds_resultado_textarea ";
                    $sql.="       , fci.auditorias_categoria_itens_dados_pk ";
                    $sql.="       , fci.ic_checkbox ";
                    $sql.="  from frota_checklist_itens fci";
                    $sql.=" where fci.auditorias_categoria_itens_dados_pk = ".$queryItensDados[$l]['auditorias_categoria_itens_dados_pk'];
                    $queryChecklistItens = $this->db->execQuery($sql);

                    if($queryItensDados[$l]['auditorias_categorias_itens_pk'] == $queryItensDados[$a]['auditorias_categorias_itens_pk']){
                        $resultChecklistItens[] = array(
                            "auditorias_categoria_itens_dados_pk" => $queryItensDados[$l]["auditorias_categoria_itens_dados_pk"],
                            "ds_item_dados"=>$queryItensDados[$l]['ds_item_dados'],
                            "ic_status"=>$queryItensDados[$l]['ic_status'],
                            "auditorias_categorias_itens_pk"=>$queryItensDados[$l]['auditorias_categorias_itens_pk'],
                            "tipo_item_pk"=>$queryItensDados[$l]['tipo_item_pk'],
                            "ic_checkbox"=>$queryChecklistItens[0]['ic_checkbox'],
                            "ds_resultado_dados"=>$queryChecklistItens[0]['ds_resultado_dados'],
                            "ds_resultado_textarea"=>$queryChecklistItens[0]['ds_resultado_textarea'],
                            "frota_checklist_pk"=>$queryChecklistItens[0]['frota_checklist_pk'],
                        );
                    }
                }

                $result[] = array(
                    "pk" => $query[$i]["pk"],
                    "id_veiculo"=>$query[$i]['id_veiculo'],
                    "ds_placa"=>$query[$i]['ds_placa'],
                    "ds_km_inicial"=>$query[$i]['ds_km_inicial'],
                    "ds_cor"=>$query[$i]['ds_cor'],
                    "tipo_veiculo_pk"=>$query[$i]['tipo_veiculo_pk'],
                    "marcas_veiculos_pk"=>$query[$i]['marcas_veiculos_pk'],
                    "modelos_veiculos_pk"=>$query[$i]['modelos_veiculos_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "ds_categoria_item"=>$DadosForm[$i]['ds_categoria_item'],
                    "tipo_item_pk"=>$DadosForm[$i]['tipo_item_pk'],
                    "ds_tipo_item"=>$DadosForm[$i]['ds_tipo_item'],
                    "ic_status"=>$DadosForm[$i]['ic_status'],
                    "auditorias_categorias_pk"=>$DadosForm[$i]['auditorias_categorias_pk'],
                    "auditorias_categorias_tipos_pk"=>$DadosForm[$i]['auditorias_categorias_tipos_pk'],
                    "ic_obrigatorio"=>$DadosForm[$i]['ic_obrigatorio'],
                    "itensDados"=>$resultChecklistItens,
                    "ds_ic_obrigatorio"=>$DadosForm[$i]['ds_ic_obrigatorio']
                );
            }
        }else{
            $result[] = array(
                "pk" => $query[0]["pk"],
                "id_veiculo"=>$query[0]['id_veiculo'],
                "ds_placa"=>$query[0]['ds_placa'],
                "ds_km_inicial"=>$query[0]['ds_km_inicial'],
                "ds_cor"=>$query[0]['ds_cor'],
                "tipo_veiculo_pk"=>$query[0]['tipo_veiculo_pk'],
                "marcas_veiculos_pk"=>$query[0]['marcas_veiculos_pk'],
                "modelos_veiculos_pk"=>$query[0]['modelos_veiculos_pk'],
                "leads_pk"=>$query[0]['leads_pk'],
                "ic_status"=>$query[0]['ic_status']
            );
        }
        return $result;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select f.pk, f.dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.id_veiculo ";
        $sql.="       ,f.ds_placa ";
        $sql.="       ,f.ds_km_inicial ";
        $sql.="       ,f.ds_cor ";
        $sql.="       ,f.tipo_veiculo_pk ";
        $sql.="       ,f.marcas_veiculos_pk ";
        $sql.="       ,f.modelos_veiculos_pk ";
        $sql.="       ,f.leads_pk ";
        $sql.="       ,f.ic_status ";
        $sql.="       ,u.ds_usuario ";
        $sql.="  from frota f";
        $sql.="  inner join usuarios u on  u.pk = f.usuario_cadastro_pk";
        $sql.=" where 1=1 ";
        $sql.=" order by id_veiculo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarFormPorIdVeiculo($ds_categoria_item){

        $sql ="";
        $sql.="select aci.pk, aci.dt_cadastro, aci.usuario_cadastro_pk, aci.dt_ult_atualizacao, aci.usuario_ult_atualizacao_pk  ";
        $sql.="       ,aci.ds_categoria_item ";
        $sql.="       ,aci.tipo_item_pk";
        $sql.="       , case";
        $sql.="         when aci.tipo_item_pk = 1 then 'Lista Suspensa'";
        $sql.="         when aci.tipo_item_pk = 2 then 'Texto'";
        $sql.="         when aci.tipo_item_pk = 3 then 'Checkbox'";
        $sql.="         when aci.tipo_item_pk = 4 then 'Textarea'";
        $sql.="         end ds_tipo_item";
        $sql.="       ,aci.ic_status ";
        $sql.="       ,aci.auditorias_categorias_pk ";
        $sql.="       ,aci.auditorias_categorias_tipos_pk ";
        $sql.="       ,aci.ic_obrigatorio ";
        $sql.="       ,case ";
        $sql.="        when aci.ic_obrigatorio = 1 then 'Sim' ";
        $sql.="        else 'Não' ";
        $sql.="         end ds_ic_obrigatorio";

        $sql.="  from auditoria_categorias_itens aci";
        $sql.="  inner join auditoria_categorias_tipos act on aci.auditorias_categorias_tipos_pk = act.pk";
        $sql.=" where act.ds_auditoria_categoria_tipo like '$ds_categoria_item'";
        $sql.=" and aci.ic_status = 1";
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

}

?>
