<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/propostas_facilities.class.php';


class propostas_facilitiesdao{

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

    public function salvar($propostas_facilities){

        $fields = array();
        $fields['ds_versao'] = $propostas_facilities->getds_versao();
        $fields['ds_numero_proposta'] = $propostas_facilities->getds_numero_proposta();
        $fields['leads_pk'] = $propostas_facilities->getleads_pk();
        $fields['ic_tipo_proposta'] = $propostas_facilities->getic_tipo_proposta();
        $fields['produtos_servicos_pk'] = $propostas_facilities->getprodutos_servicos_pk();
        $fields['ds_qtde_efetivo'] = $propostas_facilities->getds_qtde_efetivo();
        $fields['ds_qtde_hr_semanais'] = $propostas_facilities->getds_qtde_hr_semanais();
        $fields['ic_escala'] = $propostas_facilities->getic_escala();
        $fields['convencao_coletiva_pk'] = $propostas_facilities->getconvencao_coletiva_pk();
        $fields['dt_base_categoria'] = $propostas_facilities->getdt_base_categoria();
        $fields['ds_num_registro_mte'] = $propostas_facilities->getds_num_registro_mte();
        $fields['vl_salario_piso_categoria'] = $propostas_facilities->getvl_salario_piso_categoria();
        $fields['vl_total_proposta'] = $propostas_facilities->getvl_total_proposta();
        $fields['usuario_responsavel_comercial_pk'] = $propostas_facilities->getusuario_responsavel_comercial_pk();
        $fields['dt_envio_da_proposta'] = $propostas_facilities->getdt_envio_da_proposta();
        $fields['dt_previsao_fechamento'] = $propostas_facilities->getdt_previsao_fechamento();
        $fields['dt_fechamento'] = $propostas_facilities->getdt_fechamento();
        $fields['dt_cancelamento'] = $propostas_facilities->getdt_cancelamento();
        $fields['obs_motivo_cancelamento'] = $propostas_facilities->getobs_motivo_cancelamento();
        $fields['obs_proposta'] = $propostas_facilities->getobs_proposta();
        $fields['ic_status'] = $propostas_facilities->getic_status();
        $fields['contratos_pk'] = $propostas_facilities->getcontratos_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($propostas_facilities->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("propostas_facilities", $fields);
            $propostas_facilities->setpk($pk);
        }
        else{
            $this->db->execUpdate("propostas_facilities", $fields, " pk = ".$propostas_facilities->getpk());
        }
        return $propostas_facilities->getpk();;

    }

    public function excluir($propostas_facilities){
        $this->db->execDelete("propostas_facilities"," pk = ".$propostas_facilities->getpk());
    }

    public function carregarPorPk($pk){

        $propostas_facilities = new propostas_facilities();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_versao ";
        $sql.="       ,ds_numero_proposta ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_tipo_proposta ";
        $sql.="       ,produtos_servicos_pk ";
        $sql.="       ,ds_qtde_efetivo ";
        $sql.="       ,ds_qtde_hr_semanais ";
        $sql.="       ,ic_escala ";
        $sql.="       ,convencao_coletiva_pk ";
        $sql.="       ,dt_base_categoria ";
        $sql.="       ,ds_num_registro_mte ";
        $sql.="       ,vl_salario_piso_categoria ";
        $sql.="       ,vl_total_proposta ";
        $sql.="       ,usuario_responsavel_comercial_pk ";
        $sql.="       ,dt_envio_da_proposta ";
        $sql.="       ,dt_previsao_fechamento ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,obs_motivo_cancelamento ";
        $sql.="       ,obs_proposta ";
        $sql.="       ,ic_status ";
        $sql.="       ,contratos_pk ";


        $sql.="  from propostas_facilities ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $propostas_facilities->setpk($query[$i]["pk"]);
                $propostas_facilities->setdt_cadastro($query[$i]["dt_cadastro"]);
                $propostas_facilities->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $propostas_facilities->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $propostas_facilities->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $propostas_facilities->setds_versao($query[$i]['ds_versao']);
                $propostas_facilities->setds_numero_proposta($query[$i]['ds_numero_proposta']);
                $propostas_facilities->setleads_pk($query[$i]['leads_pk']);
                $propostas_facilities->setic_tipo_proposta($query[$i]['ic_tipo_proposta']);
                $propostas_facilities->setprodutos_servicos_pk($query[$i]['produtos_servicos_pk']);
                $propostas_facilities->setds_qtde_efetivo($query[$i]['ds_qtde_efetivo']);
                $propostas_facilities->setds_qtde_hr_semanais($query[$i]['ds_qtde_hr_semanais']);
                $propostas_facilities->setic_escala($query[$i]['ic_escala']);
                $propostas_facilities->setconvencao_coletiva_pk($query[$i]['convencao_coletiva_pk']);
                $propostas_facilities->setdt_base_categoria($query[$i]['dt_base_categoria']);
                $propostas_facilities->setds_num_registro_mte($query[$i]['ds_num_registro_mte']);
                $propostas_facilities->setvl_salario_piso_categoria($query[$i]['vl_salario_piso_categoria']);
                $propostas_facilities->setvl_total_proposta($query[$i]['vl_total_proposta']);
                $propostas_facilities->setusuario_responsavel_comercial_pk($query[$i]['usuario_responsavel_comercial_pk']);
                $propostas_facilities->setdt_envio_da_proposta($query[$i]['dt_envio_da_proposta']);
                $propostas_facilities->setdt_previsao_fechamento($query[$i]['dt_previsao_fechamento']);
                $propostas_facilities->setdt_fechamento($query[$i]['dt_fechamento']);
                $propostas_facilities->setdt_cancelamento($query[$i]['dt_cancelamento']);
                $propostas_facilities->setobs_motivo_cancelamento($query[$i]['obs_motivo_cancelamento']);
                $propostas_facilities->setobs_proposta($query[$i]['obs_proposta']);
                $propostas_facilities->setic_status($query[$i]['ic_status']);
                $propostas_facilities->setcontratos_pk($query[$i]['contratos_pk']);

            }
        }
        return $propostas_facilities;
    }

    public function listar_por_ds_versao($leads_pk, $ic_status, $usuario_cadastro_pk, $usuario_responsavel_comercial_pk, $dt_cadastro){

        $sql ="";
        $sql.="select pf.pk, pf.dt_cadastro, pf.usuario_cadastro_pk, pf.dt_ult_atualizacao, pf.usuario_ult_atualizacao_pk ";
        $sql.="       ,pf.ds_versao ";
        $sql.="       ,pf.ds_numero_proposta ";
        $sql.="       ,pf.leads_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,pf.ic_tipo_proposta ";
        $sql.="       ,pf.produtos_servicos_pk ";
        $sql.="       ,pf.ds_qtde_efetivo ";
        $sql.="       ,pf.ds_qtde_hr_semanais ";
        $sql.="       ,pf.ic_escala ";
        $sql.="       ,pf.convencao_coletiva_pk ";
        $sql.="       ,pf.dt_base_categoria ";
        $sql.="       ,pf.ds_num_registro_mte ";
        $sql.="       ,pf.vl_salario_piso_categoria ";
        $sql.="       ,pf.vl_total_proposta ";
        $sql.="       ,pf.usuario_responsavel_comercial_pk ";
        $sql.="       ,u.ds_usuario ds_usuario_responsavel_comercial ";
        $sql.="       ,us.ds_usuario ds_usuario_cadastro ";
        $sql.="       ,pf.dt_envio_da_proposta ";
        $sql.="       ,date_format(pf.dt_previsao_fechamento,'%d/%m/%Y') dt_previsao_fechamento ";
        $sql.="       ,pf.dt_fechamento ";
        $sql.="       ,pf.dt_cancelamento ";
        $sql.="       ,pf.obs_motivo_cancelamento ";
        $sql.="       ,pf.obs_proposta ";
        $sql.="       ,case when pf.ic_status = 1 then 'Cadastrada' ";
        $sql.="             when pf.ic_status = 2 then 'Enviada para o Cliente' ";
        $sql.="             when pf.ic_status = 3 then 'Previsão de Fechamento' ";
        $sql.="             when pf.ic_status = 4 then 'Proposta Aprovada' ";
        $sql.="             when pf.ic_status = 5 then 'Cancelada' ";
        $sql.="        end ds_status ";
        $sql.="       ,pf.ic_status ";
        $sql.="       ,pf.contratos_pk ";

        $sql.="  from propostas_facilities pf";
        $sql.="  inner join leads l on l.pk = pf.leads_pk ";
        $sql.="  inner join usuarios u on u.pk = pf.usuario_responsavel_comercial_pk ";
        $sql.="  inner join usuarios us on us.pk = pf.dt_cadastro ";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and leads_pk = ".$leads_pk;
        }
        if($ic_status != ""){
            $sql.=" and ic_status = ".$ic_status;
        }
        if($usuario_cadastro_pk != ""){
            $sql.=" and usuario_cadastro_pk = ".$usuario_cadastro_pk;
        }
        if($usuario_responsavel_comercial_pk != ""){
            $sql.=" and usuario_responsavel_comercial_pk = ".$usuario_responsavel_comercial_pk;
        }
        if($dt_cadastro != ""){
            $sql.=" and dt_cadastro = '".$dt_cadastro."'";
        }
        $sql.=" order by l.ds_lead asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarGrupo_Subgrupos(){
        $sql = "";
        $sql.="Select  pk";
        $sql.="       ,ic_tipo_grupo";
        $sql.="       ,ds_nome_grupo ";
        $sql.="       ,ic_status ";
        $sql.="  from propostas_facilities_grupos_subgrupos ";
        $sql.=" where ic_tipo_grupo = 1";
        $sql.=" order by pk asc ";
        $query = $this->db->execQuery($sql);

        for($i=0;$i<count($query);$i++){
            $subGrupos = [];
            $sqlItensGrupos ="";
            $sqlItensGrupos.="Select pfl.ds_label";
            $sqlItensGrupos.="      ,pfl.ic_ordem";
            $sqlItensGrupos.="      ,pfl.ic_status";
            $sqlItensGrupos.="      ,pfl.propostas_facilities_grupos_subgrupos_pk";
            $sqlItensGrupos.="      ,pfl.subgrupo_pk";
            $sqlItensGrupos.="  from propostas_facilities_label pfl";
            $sqlItensGrupos.="  inner join propostas_facilities_grupos_subgrupos pfgs on pfgs.pk = pfl.propostas_facilities_grupos_subgrupos_pk";
            $sqlItensGrupos.=" where pfgs.ic_tipo_grupo = 1";
            $sqlItensGrupos.="   and pfl.propostas_facilities_grupos_subgrupos_pk = ".$query[$i]['pk'];
            $sqlItensGrupos.="   and (pfl.subgrupo_pk is null or pfl.subgrupo_pk = 0)";
            $sqlItensGrupos.=" order by pfl.ic_ordem asc ";
            $queryItens = $this->db->execQuery($sqlItensGrupos);

            $sqlSubgrupo = "";
            $sqlSubgrupo.= "select pk";
            $sqlSubgrupo.= "      ,ic_tipo_grupo";
            $sqlSubgrupo.= "      ,ds_nome_grupo";
            $sqlSubgrupo.="       ,grupo_pai_pk ";
            $sqlSubgrupo.="       ,ic_status ";
            $sqlSubgrupo.="  from propostas_facilities_grupos_subgrupos ";
            $sqlSubgrupo.=" where ic_tipo_grupo = 2 and grupo_pai_pk =".$query[$i]['pk'];
            $sqlSubgrupo.=" order by grupo_pai_pk, pk asc ";
            $querySubgrupo = $this->db->execQuery($sqlSubgrupo);

            for($l=0;$l<count($querySubgrupo);$l++){
    
                $sqlItensSubGrupos ="";
                $sqlItensSubGrupos.="Select pfl.ds_label";
                $sqlItensSubGrupos.="      ,pfl.ic_ordem";
                $sqlItensSubGrupos.="      ,pfl.ic_status";
                $sqlItensSubGrupos.="      ,pfl.propostas_facilities_grupos_subgrupos_pk";
                $sqlItensSubGrupos.="      ,pfl.subgrupo_pk";
                $sqlItensSubGrupos.="  from propostas_facilities_label pfl";
                $sqlItensSubGrupos.="  left join propostas_facilities_grupos_subgrupos pfgs on pfgs.pk = pfl.subgrupo_pk";
                $sqlItensSubGrupos.=" where pfgs.ic_tipo_grupo = 2";
                $sqlItensSubGrupos.="   and pfl.propostas_facilities_grupos_subgrupos_pk = ".$query[$i]['pk'];
                $sqlItensSubGrupos.="   and pfl.subgrupo_pk = ".$querySubgrupo[$l]['pk'];
                $sqlItensSubGrupos.=" order by pfl.ic_ordem asc ";
                $queryItensSubGrupos = $this->db->execQuery($sqlItensSubGrupos);

                $subGrupos[] = array(
                    "pk" => $querySubgrupo[$l]["pk"],
                    "ic_tipo_grupo" => $querySubgrupo[$l]["ic_tipo_grupo"],
                    "ds_nome_grupo" => $querySubgrupo[$l]["ds_nome_grupo"],
                    "grupo_pai_pk" => $querySubgrupo[$l]["grupo_pai_pk"],
                    "ic_status" => $querySubgrupo[$l]["ic_status"],
                    "ItensSubGrupos" => $queryItensSubGrupos
                );

            }


            $result[] = array(
                "pk" => $query[$i]["pk"],
                "ic_tipo_grupo" => $query[$i]["ic_tipo_grupo"],
                "ds_nome_grupo" => $query[$i]["ds_nome_grupo"],
                "ic_status" => $query[$i]["ic_status"],
                "Itens" => $queryItens,
                "SubGrupos" => $subGrupos
            );
        }

        return $result;
    }

}

?>
