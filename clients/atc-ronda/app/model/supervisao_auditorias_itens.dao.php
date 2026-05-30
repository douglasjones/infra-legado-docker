<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/supervisao_auditorias_itens.class.php';


class supervisao_auditorias_itensdao{

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

    public function salvar($supervisao_auditorias_itens, $JSONinfoSupervisao){

        $arrDados = json_decode ($JSONinfoSupervisao, true);
        for($i=0;$i<count($arrDados);$i++){

            $fields = array();
            $fieldsSupervisaoAuditorias = array();
            $fields['supervisao_auditorias_pk'] = $arrDados[$i]['supervisao_auditoria_pk'];
            $fields['auditoria_categorias_itens_pk'] = $arrDados[$i]['auditorias_categorias_itens_pk'];
            
            $fields["dt_ult_atualizacao"] = "sysdate()";
            $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
            $fieldsSupervisaoAuditorias["dt_ult_atualizacao"] = "sysdate()";
            $fieldsSupervisaoAuditorias["usuario_ult_atualizacao_pk"]   = $this->arrToken['usuarios_pk'];
            
            $arrIcCheckbox = explode(',',$arrDados[$i]['arrIcCheckbox']);
            $arrResultadoDados = explode(',',$arrDados[$i]['arrResultadoDados']);
            $arrPkCheckbox = explode(',',$arrDados[$i]['arrPkCheckbox']);

            if($arrDados[$i]['ds_tipo_campo'] == "checkbox"){
                for($l=0; $l<$arrDados[$i]['qtdCheckbox']; $l++){
                    $fields['ds_resultado_dados'] = $arrResultadoDados[$l];
                    $fields['ic_checkbox'] = $arrIcCheckbox[$l];
                    $fields['auditorias_categoria_itens_dados_pk'] = $arrResultadoDados[$l];
                    if($arrPkCheckbox[$l] == ""){
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
                        $fieldsSupervisaoAuditorias["dt_cadastro"] = "sysdate()";
                        $fieldsSupervisaoAuditorias["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
                        $fieldsSupervisaoAuditorias["obs_geral"]  = $arrDados[$i]['ds_obs_geral'];
        
                        $this->db->execInsert("supervisao_auditorias_itens", $fields);
                        $this->db->execUpdate("supervisao_auditorias", $fieldsSupervisaoAuditorias, " pk = ".$arrDados[$i]['supervisao_auditoria_pk']);  
                    }
                    else{
                        $this->db->execUpdate("supervisao_auditorias_itens", $fields, " pk = ".$arrPkCheckbox[$l]);
                        $fieldsSupervisaoAuditorias["obs_geral"]  = $arrDados[$i]['ds_obs_geral'];
                        $this->db->execUpdate("supervisao_auditorias", $fieldsSupervisaoAuditorias, " pk = ".$arrDados[$i]['supervisao_auditoria_pk']);
                    }
                    
                }

            }else{
                if($arrDados[$i]['ds_tipo_campo'] == "textarea"){
                    $fields['ds_resultado_textarea'] = $arrDados[$i]['ds_resultado_dados'];
                }else{
                    $fields['ds_resultado_dados'] = $arrDados[$i]['ds_resultado_dados'];
                }
                if($arrDados[$i]['pk'] == ""){

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
                    $fieldsSupervisaoAuditorias["dt_cadastro"] = "sysdate()";
                    $fieldsSupervisaoAuditorias["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
                    $fieldsSupervisaoAuditorias["obs_geral"]  = $arrDados[$i]['ds_obs_geral'];
    
                    $this->db->execInsert("supervisao_auditorias_itens", $fields);
                    $this->db->execUpdate("supervisao_auditorias", $fieldsSupervisaoAuditorias, " pk = ".$arrDados[$i]['supervisao_auditoria_pk']);  
                }
                else{
                    $this->db->execUpdate("supervisao_auditorias_itens", $fields, " pk = ".$arrDados[$i]['pk']);
                    $fieldsSupervisaoAuditorias["obs_geral"]  = $arrDados[$i]['ds_obs_geral'];
                    $this->db->execUpdate("supervisao_auditorias", $fieldsSupervisaoAuditorias, " pk = ".$arrDados[$i]['supervisao_auditoria_pk']);
                }
            }

            
        }

        return $supervisao_auditorias_itens->getpk();;

    }

    public function excluir($supervisao_auditorias_itens){
        $this->db->execDelete("supervisao_auditorias_itens"," pk = ".$supervisao_auditorias_itens->getpk());
    }

    public function carregarPorPk($pk){

        $supervisao_auditorias_itens = new supervisao_auditorias_itens();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,supervisao_auditorias_pk ";
        $sql.="       ,auditoria_categorias_itens_pk ";
        $sql.="       ,ds_resultado_dados ";
        $sql.="       ,ds_resultado_textarea ";


        $sql.="  from supervisao_auditorias_itens ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $supervisao_auditorias_itens->setpk($query[$i]["pk"]);
                $supervisao_auditorias_itens->setdt_cadastro($query[$i]["dt_cadastro"]);
                $supervisao_auditorias_itens->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $supervisao_auditorias_itens->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $supervisao_auditorias_itens->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $supervisao_auditorias_itens->setsupervisao_auditorias_pk($query[$i]['supervisao_auditorias_pk']);
                $supervisao_auditorias_itens->setauditoria_categorias_itens_pk($query[$i]['auditoria_categorias_itens_pk']);
                $supervisao_auditorias_itens->setds_resultado_dados($query[$i]['ds_resultado_dados']);
                $supervisao_auditorias_itens->setds_resultado_textarea($query[$i]['ds_resultado_textarea']);

            }
        }
        return $supervisao_auditorias_itens;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,supervisao_auditorias_pk ";
        $sql.="       ,auditoria_categorias_itens_pk ";
        $sql.="       ,ds_resultado_dados ";
        $sql.="       ,ds_resultado_textarea ";

        $sql.="  from supervisao_auditorias_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarValoresCamposForm($supervisao_auditorias_pk, $auditoria_categoria_tipos_pk){

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
            $sql.=" where auditorias_categorias_tipos_pk = $auditoria_categoria_tipos_pk ";
            $sql.=" and ic_status = 1";
            $query = $this->db->execQuery($sql);
            
            for($i=0; $i<count($query);$i++){
                $sql ="";
                $sql.="select pk";
                $sql.="       ,ds_item_dados ";
                $sql.="       ,ic_status";
                $sql.="       ,auditorias_categorias_itens_pk ";
                $sql.="       ,tipo_item_pk ";
                $sql.="  from auditorias_categoria_itens_dados ";
                $sql.=" where auditorias_categorias_itens_pk = ".$query[$i]['pk'];
                $queryItensDados = $this->db->execQuery($sql);
                

                    $sql ="";
                    $sql.="select sai.pk";
                    $sql.="       ,sai.auditoria_categorias_itens_pk ";
                    $sql.="       ,sai.ds_resultado_dados";
                    $sql.="       ,sai.ds_resultado_textarea ";
                    $sql.="       ,sai.supervisao_auditorias_pk ";
                    $sql.="       ,sai.auditorias_categoria_itens_dados_pk ";
                    $sql.="       ,sai.ic_checkbox ";
                    $sql.="       ,sa.obs_geral ";
                    $sql.="  from supervisao_auditorias_itens sai";
                    $sql.="  left join supervisao_auditorias sa on sai.supervisao_auditorias_pk = sa.pk ";
                    $sql.=" where 1=1 ";
                    $sql.="  and sai.auditoria_categorias_itens_pk = ".$query[$i]['pk'];
                    $sql.="  and sai.supervisao_auditorias_pk = ".$supervisao_auditorias_pk;
                    $querySupervisaoAuditoriasItens = $this->db->execQuery($sql);
    
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
                        "supervisaoAuditoriasItens"=>$querySupervisaoAuditoriasItens,
                        "ds_ic_obrigatorio"=>$query[$i]['ds_ic_obrigatorio']
                    );
            }

        return $result;

    }

    public function listar_por_supervisao_auditorias_pk($supervisao_auditorias_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,supervisao_auditorias_pk ";
        $sql.="       ,auditoria_categorias_itens_pk ";
        $sql.="       ,ds_resultado_dados ";
        $sql.="       ,ds_resultado_textarea ";

        $sql.="  from supervisao_auditorias_itens ";
        $sql.=" where 1=1 ";
        if($supervisao_auditorias_pk != ""){
            $sql.=" and ds_supervisao_auditorias_itens like '%".$supervisao_auditorias_pk."%' ";
        }
        $sql.=" order by supervisao_auditorias_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,supervisao_auditorias_pk ";
        $sql.="       ,auditoria_categorias_itens_pk ";
        $sql.="       ,ds_resultado_dados ";
        $sql.="       ,ds_resultado_textarea ";

        $sql.="  from supervisao_auditorias_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by supervisao_auditorias_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>