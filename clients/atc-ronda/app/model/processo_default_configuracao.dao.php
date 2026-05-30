<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/processo_default_configuracao.class.php';


class processo_default_configuracaodao{

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

    public function salvar($processo_default_configuracao, $processo_default_grupos_pk){
        $processo_default_gruposdao = new processo_default_gruposdao();
        $processo_default_gruposdao->setToken($token); 
        
        $arrProcesso_default_grupos = array();
        $arrProcesso_default_grupos = json_decode($processo_default_grupos_pk, true);


        $fields = array();
        $fields['processos_default_pk'] = $processo_default_configuracao->getprocessos_default_pk();
        $fields['processos_default_etapas_pk'] = $processo_default_configuracao->getprocessos_default_etapas_pk();
        $fields['ds_processo_default_configuracao'] = $processo_default_configuracao->getds_processo_default_configuracao();
        $fields['ds_cor'] = $processo_default_configuracao->getds_cor();
        $fields['tempo_execucao_pk'] = $processo_default_configuracao->gettempo_execucao_pk();
        $fields['tipos_ocorrencias_pk'] = $processo_default_configuracao->gettipos_ocorrencias_pk();
        $fields['processos_default_modulos_pk'] = $processo_default_configuracao->getprocessos_default_modulos_pk();
        $fields['processos_default_modulos_obrigatorio_pk'] = $processo_default_configuracao->getprocessos_default_modulos_obrigatorio_pk();
        $fields['ic_status'] = $processo_default_configuracao->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($processo_default_configuracao->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("processo_default_configuracao", $fields);
            $processo_default_configuracao->setpk($pk);
        }
        else{
            $this->db->execUpdate("processo_default_configuracao", $fields, " pk = ".$processo_default_configuracao->getpk());
            $pk = $processo_default_configuracao->getpk();

        }

        if($pk != ""){
            for($i=0; $i<count($arrProcesso_default_grupos);$i++){
                $fieldsGrupos = array();
                $fieldsGrupos['grupos_pk'] = $arrProcesso_default_grupos[$i]['grupos_pk'];
                $fieldsGrupos['ic_status'] = $arrProcesso_default_grupos[$i]['ic_checkbox'];
                $fieldsGrupos['processo_default_configuracao_pk'] = $pk;

                $fieldsGrupos["dt_ult_atualizacao"] = "sysdate()";
                $fieldsGrupos["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

                if($arrProcesso_default_grupos[$i]['processo_default_grupos_pk']  == ""){

                    $fieldsGrupos["dt_cadastro"] = "sysdate()";
                    $fieldsGrupos["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                    $pkGrupos = $this->db->execInsert("processo_default_grupos", $fieldsGrupos);
                }
                else{
                    $this->db->execUpdate("processo_default_grupos", $fieldsGrupos, " processo_default_configuracao_pk = ".$arrProcesso_default_grupos[$i]['processo_default_grupos_pk']);
                }
            
            }
        }
        return $pk;

    }

    public function excluir($processo_default_configuracao){
        $this->db->execDelete("processo_default_configuracao"," pk = ".$processo_default_configuracao->getpk());
    }

    public function carregarPorPk($pk){
        $processo_default_configuracao = new processo_default_configuracao();
        if($pk != " "){
            $sql ="select pk ";
            $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
            $sql.="      , usuario_cadastro_pk ";
            $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
            $sql.="      , usuario_ult_atualizacao_pk ";
            $sql.="       ,processos_default_pk ";
            $sql.="       ,processos_default_etapas_pk ";
            $sql.="       ,ds_processo_default_configuracao ";
            $sql.="       ,ds_cor ";
            $sql.="       ,tempo_execucao_pk ";
            $sql.="       ,tipos_ocorrencias_pk ";
            $sql.="       ,processos_default_modulos_pk ";
            $sql.="       ,processos_default_modulos_obrigatorio_pk ";
            $sql.="       ,ic_status ";
            $sql.="  from processo_default_configuracao ";
            $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);

            for($i = 0; $i < count($query); $i++){
                $processo_default_configuracao->setpk($query[$i]["pk"]);
                $processo_default_configuracao->setdt_cadastro($query[$i]["dt_cadastro"]);
                $processo_default_configuracao->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $processo_default_configuracao->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $processo_default_configuracao->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
                $processo_default_configuracao->setprocessos_default_pk($query[$i]['processos_default_pk']);
                $processo_default_configuracao->setprocessos_default_etapas_pk($query[$i]['processos_default_etapas_pk']);
                $processo_default_configuracao->setds_processo_default_configuracao($query[$i]['ds_processo_default_configuracao']);
                $processo_default_configuracao->setds_cor($query[$i]['ds_cor']);
                $processo_default_configuracao->settempo_execucao_pk($query[$i]['tempo_execucao_pk']);
                $processo_default_configuracao->settipos_ocorrencias_pk($query[$i]['tipos_ocorrencias_pk']);
                $processo_default_configuracao->setprocessos_default_modulos_pk($query[$i]['processos_default_modulos_pk']);
                $processo_default_configuracao->setprocessos_default_modulos_obrigatorio_pk($query[$i]['ic_modulo_obrigatorio']);
                $processo_default_configuracao->setic_status($query[$i]['ic_status']);
            }
        }
        return $processo_default_configuracao;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pdc.pk, pdc.dt_cadastro, pdc.usuario_cadastro_pk, pdc.dt_ult_atualizacao, pdc.usuario_ult_atualizacao_pk ";
        $sql.="       ,pdc.processos_default_pk ";
        $sql.="       ,pdc.processos_default_etapas_pk ";
        $sql.="       ,pdc.ds_processo_default_configuracao ";
        $sql.="       ,pdc.ds_cor ";
        $sql.="       ,pdc.tempo_execucao_pk ";
        $sql.="       ,pdc.tipos_ocorrencias_pk ";
        $sql.="       ,pdc.processos_default_modulos_pk ";
        $sql.="       ,pdc.ic_modulo_obrigatorio ";
        $sql.="       ,pdc.ic_status ";
        $sql.="       ,pde.ds_processo_default_etapa ";
        $sql.="       ,pde.n_ordem_etapa ";
        $sql.="       ,pdc.processos_default_modulos_obrigatorio_pk ";
        $sql.="  from  processo_default_configuracao pdc ";
        $sql.="  inner join processos_default_etapas pde on pdc.processos_default_etapas_pk = pde.pk";
        $sql.="  inner join processos_default_modulos pdm on pdc.processos_default_modulos_pk = pdm.pk";
        $sql.=" where pdc.pk = $pk ";
        $query = $this->db->execQuery($sql);

            $sql ="";
            $sql.="Select pk";
            $sql.="       ,grupos_pk ";
            $sql.="       ,ic_status ";
            $sql.="  from  processo_default_grupos";
            $sql.=" where processo_default_configuracao_pk =" .$query[0]['pk'];
            $sql.=" and ic_status = 1";
            $queryGruposAcesso = $this->db->execQuery($sql);
            $result[] = array(
                "pk" => $query[0]["pk"],
                "processos_default_pk"=>$query[0]['processos_default_pk'],
                "processos_default_etapas_pk"=>$query[0]['processos_default_etapas_pk'],
                "ds_processo_default_configuracao"=>$query[0]['ds_processo_default_configuracao'],
                "n_ordem"=>$query[0]['n_ordem_etapa'],
                "ds_cor"=>$query[0]['ds_cor'],
                "ic_status"=>$query[0]['ic_status'],
                "tempo_execucao_pk"=>$query[0]['tempo_execucao_pk'],
                "tipos_ocorrencias_pk"=>$query[0]['tipos_ocorrencias_pk'],
                "processos_default_modulos_pk"=>$query[0]['processos_default_modulos_pk'],
                "processos_default_modulos_obrigatorio_pk"=>$query[0]['processos_default_modulos_obrigatorio_pk'],
                "ds_processo_default_etapa"=>$query[0]['ds_processo_default_etapa'],
                "gruposAcesso"=>$queryGruposAcesso
            );
            return $result;

    }

    public function listar_por_processos_default_pk($processos_default_pk, $ds_processo_default_configuracao, $ic_status){

        $sql ="";
        $sql.="select pdc.pk, pdc.dt_cadastro, pdc.usuario_cadastro_pk, pdc.dt_ult_atualizacao, pdc.usuario_ult_atualizacao_pk ";
        $sql.="       ,pdc.processos_default_pk ";
        $sql.="       ,pdc.processos_default_etapas_pk ";
        $sql.="       ,pdc.ds_processo_default_configuracao ";
        $sql.="       ,pdc.ds_cor ";
        $sql.="       ,pdc.tempo_execucao_pk ";
        $sql.="       ,pdc.tipos_ocorrencias_pk ";
        $sql.="       ,pdc.processos_default_modulos_pk ";
        $sql.="       ,pdc.ic_modulo_obrigatorio ";
        $sql.="       ,pdc.ic_status ";
        $sql.="       ,case WHEN pdc.ic_status = 1 THEN 'Ativo'";
        $sql.="             WHEN pdc.ic_status = 2 THEN 'Inativo'";
        $sql.="            end ds_status";
        $sql.="       ,pde.ds_processo_default_etapa ";
        $sql.="       ,pde.n_ordem_etapa ";
        $sql.="  from  processo_default_configuracao pdc ";
        
        $sql.="  inner join processos_default_etapas pde on pdc.processos_default_etapas_pk = pde.pk";
        $sql.=" where 1=1 ";
        if($processos_default_pk != ""){
            $sql.=" and pdc.processos_default_pk = ".$processos_default_pk;
        }
        if($ds_processo_default_configuracao != " "){
            $sql.=" and pdc.ds_processo_default_configuracao like '%".$ds_processo_default_configuracao."%' ";
        }
        if($ic_status != ""){
            $sql.=" and pdc.ic_status = ".$ic_status;
        }
        $sql.=" order by processos_default_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,processos_default_pk ";
        $sql.="       ,processos_default_etapas_pk ";
        $sql.="       ,ds_processo_default_configuracao ";
        $sql.="       ,ds_cor ";
        $sql.="       ,tempo_execucao_pk ";
        $sql.="       ,tipos_ocorrencias_pk ";
        $sql.="       ,processos_default_modulos_pk ";
        $sql.="       ,ic_modulo_obrigatorio ";

        $sql.="  from processo_default_configuracao ";
        $sql.=" where 1=1 ";
        $sql.=" order by processos_default_pk asc ";
 
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function carregarCaixasECards($ds_processo_default){

        $sql ="";
        $sql.="select pdc.pk, pdc.dt_cadastro, pdc.usuario_cadastro_pk, pdc.dt_ult_atualizacao, pdc.usuario_ult_atualizacao_pk ";
        $sql.="       ,pdc.processos_default_pk ";
        $sql.="       ,pdc.processos_default_etapas_pk ";
        $sql.="       ,pdc.ds_processo_default_configuracao ";
        $sql.="       ,case when pdc.ds_cor = '1' then '#809fff'
                        when pdc.ds_cor = '2' then '#ffff66'
                        when pdc.ds_cor = '3' then '#ff944d'
                        when pdc.ds_cor = '4' then '#ff3333'
                        when pdc.ds_cor = '5' then '#99ff66'
                        when pdc.ds_cor = '6' then '#ff66ff'
                    end ds_cor";
        $sql.="       ,pdc.tempo_execucao_pk ";
        $sql.="       ,pdc.tipos_ocorrencias_pk ";
        $sql.="       ,pdc.processos_default_modulos_pk ";
        $sql.="       ,pdc.ic_modulo_obrigatorio ";
        $sql.="       ,pde.ds_processo_default_etapa ";
        $sql.="       ,pde.n_ordem_etapa ";
        $sql.="       ,pde.processos_default_pk ";
        $sql.="       ,pde.equipes_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,pd.ds_processo_default ";
        $sql.="  from processo_default_configuracao pdc";
        $sql.="  LEFT JOIN processos_default_etapas pde ON pde.pk = pdc.processos_default_etapas_pk";
        $sql.="  INNER JOIN usuarios u ON pdc.usuario_cadastro_pk = u.pk";
        $sql.="  LEFT JOIN processos_default pd ON pdc.processos_default_pk = pd.pk";
        $sql.=" where 1=1 ";
        $sql.="    and pd.ds_processo_default = '".$ds_processo_default."'";
        $sql.=" order by pde.n_ordem_etapa asc ";

       // echo $sql;
        $query = $this->db->execQuery($sql);
        for($i=0; $i<count($query);$i++){
            $sqlMovimentacao = "";
            $sqlMovimentacao .= "SELECT pms.pk, pms.processo_default_configuracao_pk, pms.modulos_pk, l.ds_lead, l.ds_cpf_cnpj, date_format(pms.dt_cadastro, '%d/%m/%Y') dt_cadastro, date_format(pms.dt_cadastro, '%H:%i')hr_cadastro,pms.ic_cartao_movimentado, pms.processo_movimentacao_status_pk_pai";
            $sqlMovimentacao .= "  FROM processo_movimentacao_status pms ";
            $sqlMovimentacao .= " INNER JOIN leads l ON pms.modulos_pk = l.pk";
            $sqlMovimentacao .= " where 1=1 ";
            $sqlMovimentacao .= "    and pms.processo_default_configuracao_pk = '".$query[$i]["pk"]."'";
            $sqlMovimentacao .= "    and ic_cartao_movimentado is null";
            $sqlMovimentacao .= "  order by pms.pk desc";
            $queryMovimentacao = $this->db->execQuery($sqlMovimentacao);

            $result[] = array(
                "pk" => $query[$i]["pk"],
                "processos_default_pk"=>$query[$i]['processos_default_pk'],
                "processos_default_etapas_pk"=>$query[$i]['processos_default_etapas_pk'],
                "ds_processo_default_configuracao"=>$query[$i]['ds_processo_default_configuracao'],
                "n_ordem"=>$query[$i]['n_ordem'],
                "ds_cor"=>$query[$i]['ds_cor'],
                "tempo_execucao_pk"=>$query[$i]['tempo_execucao_pk'],
                "tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                "processos_default_modulos_pk"=>$query[$i]['processos_default_modulos_pk'],
                "processos_default_modulos_obrigatorio_pk"=>$query[$i]['processos_default_modulos_obrigatorio_pk'],
                "arrMovimentacao"=>$queryMovimentacao
            );
        }

        return $result;

    }

    public function listarModulosProcessoDefaultPk($processo_default_pk){

        $sql ="";
        $sql.="SELECT pdcm.processos_default_modulos_pk modulos_pk, pdcm.n_ordem";
        $sql.="  from processos_defalt_config_modulos pdcm";
        $sql.="  LEFT JOIN processos_default_modulos pdm on pdcm.processos_default_modulos_pk = pdm.pk";
        $sql.=" where pdcm.processos_default_pk = $processo_default_pk ";
        $sql.=" order by pdcm.n_ordem asc ";
        $query = $this->db->execQuery($sql);

        return $query;

    }

}

?>
