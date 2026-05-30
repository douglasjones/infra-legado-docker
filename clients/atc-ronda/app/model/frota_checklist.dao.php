<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/frota_checklist.class.php';


class frota_checklistdao{

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

    public function salvar($frota_checklist, $JSONinfoSupervisao){
        
        $arrInfo = array();
        $arrInfo = json_decode($JSONinfoSupervisao, true);

        $fields = array();
        $fields['leads_pk'] = $arrInfo[0]['leads_pk'];
        $fields['frota_pk'] = $arrInfo[0]['frota_pk'];
        $fields['condutores_pk'] = $arrInfo[0]['condutores_pk'];

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($frota_checklist->getpk() == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("frota_checklist", $fields);
            for($i=0;$i<count($arrInfo);$i++){
                
                $arrIcCheckbox = explode(',',$arrInfo[$i]['arrIcCheckbox']);
                $arrResultadoDados = explode(',',$arrInfo[$i]['arrResultadoDados']);
                $arrPkCheckbox = explode(',',$arrInfo[$i]['arrPkCheckbox']);

                if($arrInfo[$i]['ds_tipo_campo'] == "checkbox"){
                    for($l=0; $l<$arrInfo[$i]['qtdCheckbox']; $l++){
                        $fieldsChecklist['frota_checklist_pk'] = $pk;
                        $fieldsChecklist['ds_resultado_dados'] = $arrResultadoDados[$l];
                        $fieldsChecklist['ic_checkbox'] = $arrIcCheckbox[$l];
                        $fieldsChecklist['auditorias_categoria_itens_dados_pk'] = $arrResultadoDados[$l];
                        if($arrPkCheckbox[$l] == ""){
                            $fieldsChecklist["dt_cadastro"] = "sysdate()";
                            $fieldsChecklist["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
                            $fieldsChecklist["dt_ult_atualizacao"] = "sysdate()";
                            $fieldsChecklist["usuario_ult_atualizacao_pk"]   = $this->arrToken['usuarios_pk'];
                            $this->db->execInsert("frota_checklist_itens", $fieldsChecklist);
                        }
                        else{
                            $this->db->execUpdate("frota_checklist_itens", $fields, " pk = ".$arrPkCheckbox[$l]);
                        }
                        
                    }
    
                }else{
                    if($arrInfo[$i]['ds_tipo_campo'] == "textarea"){
                        $fieldsChecklist['ds_resultado_textarea'] = $arrInfo[$i]['ds_resultado_dados'];
                    }else{
                        $fieldsChecklist['ds_resultado_dados'] = $arrInfo[$i]['ds_resultado_dados'];
                    }
                    if($arrInfo[$i]['pk'] == ""){
                        $fieldsChecklist["dt_cadastro"] = "sysdate()";
                        $fieldsChecklist["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
                        $fieldsChecklist["dt_ult_atualizacao"] = "sysdate()";
                        $fieldsChecklist["usuario_ult_atualizacao_pk"]   = $this->arrToken['usuarios_pk'];
                        $this->db->execInsert("frota_checklist_itens", $fields);
                    }
                    else{
                        $this->db->execUpdate("frota_checklist_itens", $fields, " pk = ".$arrInfo[$i]['pk']);
                    }
                }
            }
            
            $frota_checklist->setpk($pk);
        }
        else{
            $this->db->execUpdate("frota_checklist", $fields, " pk = ".$frota_checklist->getpk());
        }
        return $frota_checklist->getpk();;

    }

    public function excluir($frota_checklist){
        $this->db->execDelete("frota_checklist"," pk = ".$frota_checklist->getpk());
    }

    public function carregarPorPk($pk){

        $frota_checklist = new frota_checklist();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,leads_pk ";
        $sql.="       ,frota_pk ";
        $sql.="       ,condutores_pk ";


        $sql.="  from frota_checklist ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $frota_checklist->setpk($query[$i]["pk"]);
                $frota_checklist->setdt_cadastro($query[$i]["dt_cadastro"]);
                $frota_checklist->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $frota_checklist->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $frota_checklist->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $frota_checklist->setleads_pk($query[$i]['leads_pk']);
                $frota_checklist->setfrota_pk($query[$i]['frota_pk']);
                $frota_checklist->setcondutores_pk($query[$i]['condutores_pk']);

            }
        }
        return $frota_checklist;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,leads_pk ";
        $sql.="       ,frota_pk ";
        $sql.="       ,condutores_pk ";

        $sql.="  from frota_checklist ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_leads_pk($leads_pk, $condutores_pk, $frota_pk, $dt_ini_checklist, $dt_fim_checklist, $usuario_cadastro_pk){

        $sql ="";
        $sql.="select fc.pk, fc.dt_cadastro, fc.usuario_cadastro_pk, fc.dt_ult_atualizacao, fc.usuario_ult_atualizacao_pk ";
        $sql.="       ,fc.leads_pk ";
        $sql.="       ,fc.frota_pk ";
        $sql.="       ,fc.condutores_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,c.ds_condutor ";
        $sql.="       ,f.id_veiculo ";

        $sql.="  from frota_checklist fc";
        $sql.="  left join leads l on l.pk = fc.leads_pk";
        $sql.="  left join condutores c on c.pk = fc.condutores_pk";
        $sql.="  left join frota f on f.pk = fc.frota_pk";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and fc.leads_pk = ".$leads_pk;
        }
        if($condutores_pk != ""){
            $sql.=" and fc.condutores_pk = ".$condutores_pk;
        }
        if($frota_pk != ""){
            $sql.=" and fc.frota_pk = ".$frota_pk;
        }
        if($dt_ini_checklist != "" || $dt_fim_checklist != "" ){
            $sql.=" and fc.dt_cadastro <= '".dataYMD($dt_ini_checklist)." 23:59:59'";
            $sql.=" and fc.dt_cadastro >= '".dataYMD($dt_fim_checklist)." 00:00:00'";
        }
        if($usuario_cadastro_pk != "" ){
            $sql.=" and fc.usuario_cadastro_pk = ".$usuario_cadastro_pk;
        }
        $sql.=" order by leads_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,frota_pk ";
        $sql.="       ,condutores_pk ";

        $sql.="  from frota_checklist ";
        $sql.=" where 1=1 ";
        $sql.=" order by leads_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
