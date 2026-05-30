<?
require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/teto_gastos.class.php';


class teto_gastosdao{

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

    public function salvar($teto_gastos){

        $fields = array();
        $fields['empresas_pk'] = $teto_gastos->getempresas_pk();
        $fields['tipo_grupo_pk'] = $teto_gastos->gettipo_grupo_pk();
        $fields['grupo_leancamento_pk'] = $teto_gastos->getgrupo_leancamento_pk();
        $fields['leads_posto_trabalho_pk'] = $teto_gastos->getleads_posto_trabalho_pk();
        $fields['contratos_pk'] = $teto_gastos->getcontratos_pk();
        $fields['colaborador_posto_trabalho_pk'] = $teto_gastos->getcolaborador_posto_trabalho_pk();
        $fields['colaborador_contratos_pk'] = $teto_gastos->getcolaborador_contratos_pk();
        $fields['fornecedor_posto_trabalho_pk'] = $teto_gastos->getfornecedor_posto_trabalho_pk();
        $fields['fornecedor_contratos_pk'] = $teto_gastos->getfornecedor_contratos_pk();
        $fields['vl_total_teto'] = moeda2float($teto_gastos->getvl_total_teto());
        $fields['vl_utilizado_atual'] = '0.00';
        $fields['ic_status'] = $teto_gastos->getic_status();
        $fields['obs'] = $teto_gastos->getobs();
        $fields['ds_ano_vigente_teto'] = $teto_gastos->getds_ano_vigente_teto();
        $fields['grupo_lancamento_centro_custo_pk'] = $teto_gastos->getgrupo_lancamento_centro_custo_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($teto_gastos->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("teto_gastos", $fields);
            $teto_gastos->setpk($pk);
        }
        else{
            $this->db->execUpdate("teto_gastos", $fields, " pk = ".$teto_gastos->getpk());
        }
        return $teto_gastos->getpk();;

    }

    public function excluir($teto_gastos){
        $this->db->execDelete("teto_gastos_itens"," teto_gastos_pk = ".$teto_gastos->getpk());
       /* echo $this->db->getLastSQL();
        exit; */
        $this->db->execDelete("teto_gastos"," pk = ".$teto_gastos->getpk());
    }

    public function carregarPorPk($pk){

        $teto_gastos = new teto_gastos();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,empresas_pk ";
        $sql.="       ,tipo_grupo_pk ";
        $sql.="       ,grupo_leancamento_pk ";
        $sql.="       ,leads_posto_trabalho_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,colaborador_posto_trabalho_pk ";
        $sql.="       ,colaborador_contratos_pk ";
        $sql.="       ,fornecedor_posto_trabalho_pk ";
        $sql.="       ,fornecedor_contratos_pk ";
        $sql.="       ,vl_total_teto ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs ";
        $sql.="       ,ds_ano_vigente_teto ";
        $sql.="       ,grupo_lancamento_centro_custo_pk ";


        $sql.="  from teto_gastos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $teto_gastos->setpk($query[$i]["pk"]);
                $teto_gastos->setdt_cadastro($query[$i]["dt_cadastro"]);
                $teto_gastos->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $teto_gastos->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $teto_gastos->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $teto_gastos->setempresas_pk($query[$i]['empresas_pk']);
                $teto_gastos->settipo_grupo_pk($query[$i]['tipo_grupo_pk']);
                $teto_gastos->setgrupo_leancamento_pk($query[$i]['grupo_leancamento_pk']);
                $teto_gastos->setleads_posto_trabalho_pk($query[$i]['leads_posto_trabalho_pk']);
                $teto_gastos->setcontratos_pk($query[$i]['contratos_pk']);
                $teto_gastos->setcolaborador_posto_trabalho_pk($query[$i]['colaborador_posto_trabalho_pk']);
                $teto_gastos->setcolaborador_contratos_pk($query[$i]['colaborador_contratos_pk']);
                $teto_gastos->setfornecedor_posto_trabalho_pk($query[$i]['fornecedor_posto_trabalho_pk']);
                $teto_gastos->setfornecedor_contratos_pk($query[$i]['fornecedor_contratos_pk']);
                $teto_gastos->setvl_total_teto($query[$i]['vl_total_teto']);
                $teto_gastos->setic_status($query[$i]['ic_status']);
                $teto_gastos->setobs($query[$i]['obs']);
                $teto_gastos->setds_ano_vigente_teto($query[$i]['ds_ano_vigente_teto']);
                $teto_gastos->setgrupo_lancamento_centro_custo_pk($query[$i]['grupo_lancamento_centro_custo_pk']);

            }
        }
        return $teto_gastos;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,empresas_pk ";
        $sql.="       ,tipo_grupo_pk ";
        $sql.="       ,grupo_leancamento_pk ";
        $sql.="       ,leads_posto_trabalho_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,colaborador_posto_trabalho_pk ";
        $sql.="       ,colaborador_contratos_pk ";
        $sql.="       ,fornecedor_posto_trabalho_pk ";
        $sql.="       ,fornecedor_contratos_pk ";
        $sql.="       ,vl_total_teto ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs ";
        $sql.="       ,ds_ano_vigente_teto ";
        $sql.="       ,grupo_lancamento_centro_custo_pk ";
        $sql.="       ,vl_utilizado_atual ";

        $sql.="  from teto_gastos ";
        $sql.=" where pk = $pk ";
        //echo $sql;
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarDataTable($tipo_grupo_pk, $posto_trabalho_pk, $contratos_pk, $grupo_leancamento_pk, $grupo_lancamento_centro_custo_pk, $ds_ano_vigente_teto, $ic_status){

        $sql ="";
        $sql.=" SELECT  tg.pk,";
        $sql.="         tg.tipo_grupo_pk,";
        $sql.="         tg.vl_total_teto,";
        $sql.="         tg.vl_utilizado_atual,";
        $sql.="         tg.ic_status,";
        $sql.="         tg.ds_ano_vigente_teto,";
        $sql.="         tg.grupo_lancamento_centro_custo_pk, tg.contratos_pk, l.ds_lead,";
        $sql.="         CASE";
        $sql.="         WHEN c.ic_tipo_contrato = 1 THEN CONCAT('FIXO',  ' - Cód:', c.pk,  ' - Periódo:', DATE_FORMAT(c.dt_inicio_contrato, '%d/%m/%Y'), ' - ', DATE_FORMAT(c.dt_fim_contrato, '%d/%m/%Y'))";
        $sql.="         WHEN c.ic_tipo_contrato = 2 THEN CONCAT('Aditivo',  ' - Cód:', c.pk, ' - Periódo:',  DATE_FORMAT(c.dt_inicio_contrato, '%d/%m/%Y'), ' - ', DATE_FORMAT(c.dt_fim_contrato, '%d/%m/%Y'))";
        $sql.="         WHEN c.ic_tipo_contrato = 3 THEN CONCAT('EXTRA :', c.ds_identificacao_area)";
        $sql.="          END ds_contrato,";
        $sql.="         CASE
                        WHEN tg.tipo_grupo_pk = 1 THEN 'Cliente'
                        WHEN tg.tipo_grupo_pk = 2 THEN 'Colaborador'
                        WHEN tg.tipo_grupo_pk = 3 THEN 'Fornecedor'
                        END ds_tipo_grupo, ";
        $sql.="         CASE
                        WHEN tg.ic_status = 1 THEN 'Ativo'
                        WHEN tg.ic_status = 2 THEN 'Inativo'
                        END ds_status, ";
        $sql.="         tg.grupo_leancamento_pk,";
        $sql.="         le.ds_lead ds_grupo_lancamento";
        $sql.="  FROM teto_gastos tg";
        $sql.="  LEFT JOIN leads l ON tg.leads_posto_trabalho_pk = l.pk AND l.ic_tipo_lead = 2";
        $sql.="  LEFT JOIN contratos c ON tg.contratos_pk = c.pk";
        $sql.="  LEFT JOIN processos_etapas pe ON c.processos_etapas_pk = pe.pk";
        $sql.="  LEFT JOIN processos p ON pe.processos_pk = p.pk";
        $sql.="  LEFT JOIN leads le ON tg.grupo_leancamento_pk = le.pk AND le.ic_tipo_lead = 1";
        $sql.=" where 1=1";
        if($tipo_grupo_pk == 1 || $tipo_grupo_pk == ""){
            $sql.="     and tg.tipo_grupo_pk = 1";
            if($posto_trabalho_pk != ""){
                $sql.="     and tg.leads_posto_trabalho_pk = $posto_trabalho_pk";
            }
            if($contratos_pk != ""){
                $sql.="     and tg.contratos_pk = $contratos_pk";
            }
            if($grupo_leancamento_pk != ""){
                $sql.="     and tg.grupo_leancamento_pk = $grupo_leancamento_pk";
            }
            if($ds_ano_vigente_teto != ""){
                $sql.="     and tg.ds_ano_vigente_teto like '%$ds_ano_vigente_teto%'";
            }
            if($ic_status != ""){
                $sql.="     and tg.ic_status = $ic_status";
            }
        }else{
            $sql.="     and tg.tipo_grupo_pk = 0";
        }
        $sql.=" union ";
        $sql.=" SELECT  tg.pk,";
        $sql.="         tg.tipo_grupo_pk,";
        $sql.="         tg.vl_total_teto,";
        $sql.="         tg.vl_utilizado_atual,";
        $sql.="         tg.ic_status,";
        $sql.="         tg.ds_ano_vigente_teto,";
        $sql.="         tg.grupo_lancamento_centro_custo_pk, tg.colaborador_contratos_pk, l.ds_lead,";
        $sql.="         CASE";
        $sql.="         WHEN c.ic_tipo_contrato = 1 THEN CONCAT('FIXO',  ' - Cód:', c.pk,  ' - Periódo:', DATE_FORMAT(c.dt_inicio_contrato, '%d/%m/%Y'), ' - ', DATE_FORMAT(c.dt_fim_contrato, '%d/%m/%Y'))";
        $sql.="         WHEN c.ic_tipo_contrato = 2 THEN CONCAT('Aditivo',  ' - Cód:', c.pk, ' - Periódo:',  DATE_FORMAT(c.dt_inicio_contrato, '%d/%m/%Y'), ' - ', DATE_FORMAT(c.dt_fim_contrato, '%d/%m/%Y'))";
        $sql.="         WHEN c.ic_tipo_contrato = 3 THEN CONCAT('EXTRA :', c.ds_identificacao_area)";
        $sql.="          END ds_contrato,";
        $sql.="         CASE
                        WHEN tg.tipo_grupo_pk = 1 THEN 'Cliente'
                        WHEN tg.tipo_grupo_pk = 2 THEN 'Colaborador'
                        WHEN tg.tipo_grupo_pk = 3 THEN 'Fornecedor'
                        END ds_tipo_grupo, ";
        $sql.="          CASE
                        WHEN tg.ic_status = 1 THEN 'Ativo'
                        WHEN tg.ic_status = 2 THEN 'Inativo'
                        END ds_status, ";                
        $sql.="         tg.grupo_leancamento_pk,";
        $sql.="         co.ds_colaborador ds_grupo_lancamento";
        $sql.="  FROM teto_gastos tg";
        $sql.="  LEFT JOIN leads l ON tg.colaborador_posto_trabalho_pk = l.pk ";
        $sql.="  LEFT JOIN contratos c ON tg.colaborador_contratos_pk = c.pk";
        $sql.="  LEFT JOIN processos_etapas pe ON c.processos_etapas_pk = pe.pk";
        $sql.="  LEFT JOIN processos p ON pe.processos_pk = p.pk";
        $sql.="  LEFT JOIN colaboradores co ON tg.grupo_leancamento_pk = co.pk";
        $sql.=" where 1=1";
        if($tipo_grupo_pk == 2 || $tipo_grupo_pk == ""){
            $sql.="     and tg.tipo_grupo_pk = 2";
            if($posto_trabalho_pk != ""){
                $sql.="     and tg.leads_posto_trabalho_pk = $posto_trabalho_pk";
            }
            if($contratos_pk != ""){
                $sql.="     and tg.contratos_pk = $contratos_pk";
            }
            if($grupo_leancamento_pk != ""){
                $sql.="     and tg.grupo_leancamento_pk = $grupo_leancamento_pk";
            }
            if($ds_ano_vigente_teto != ""){
                $sql.="     and tg.ds_ano_vigente_teto like '%$ds_ano_vigente_teto%'";
            }
            if($ic_status != ""){
                $sql.="     and tg.ic_status = $ic_status";
            }
        }else{
            $sql.="     and tg.tipo_grupo_pk = 0";
        }
        $sql.=" union";
        $sql.=" SELECT  tg.pk,";
        $sql.="         tg.tipo_grupo_pk,";
        $sql.="         tg.vl_total_teto,";
        $sql.="         tg.vl_utilizado_atual,";
        $sql.="         tg.ic_status,";
        $sql.="         tg.ds_ano_vigente_teto,";
        $sql.="         tg.grupo_lancamento_centro_custo_pk, tg.fornecedor_posto_trabalho_pk, l.ds_lead,";
        $sql.="         CASE";
        $sql.="         WHEN c.ic_tipo_contrato = 1 THEN CONCAT('FIXO',  ' - Cód:', c.pk,  ' - Periódo:', DATE_FORMAT(c.dt_inicio_contrato, '%d/%m/%Y'), ' - ', DATE_FORMAT(c.dt_fim_contrato, '%d/%m/%Y'))";
        $sql.="         WHEN c.ic_tipo_contrato = 2 THEN CONCAT('Aditivo',  ' - Cód:', c.pk, ' - Periódo:',  DATE_FORMAT(c.dt_inicio_contrato, '%d/%m/%Y'), ' - ', DATE_FORMAT(c.dt_fim_contrato, '%d/%m/%Y'))";
        $sql.="         WHEN c.ic_tipo_contrato = 3 THEN CONCAT('EXTRA :', c.ds_identificacao_area)";
        $sql.="          END ds_contrato,"; 
        $sql.="         CASE
                        WHEN tg.tipo_grupo_pk = 1 THEN 'Cliente'
                        WHEN tg.tipo_grupo_pk = 2 THEN 'Colaborador'
                        WHEN tg.tipo_grupo_pk = 3 THEN 'Fornecedor'
                        END ds_tipo_grupo, ";
        $sql.="          CASE
                        WHEN tg.ic_status = 1 THEN 'Ativo'
                        WHEN tg.ic_status = 2 THEN 'Inativo'
                        END ds_status, ";    
        $sql.="         tg.grupo_leancamento_pk,";
        $sql.="         f.ds_fornecedor ds_grupo_lancamento";
        $sql.=" FROM teto_gastos tg";
        $sql.=" LEFT JOIN leads l ON tg.fornecedor_posto_trabalho_pk = l.pk ";
        $sql.=" LEFT JOIN contratos c ON tg.fornecedor_contratos_pk = c.pk";
        $sql.=" LEFT JOIN processos_etapas pe ON c.processos_etapas_pk = pe.pk";
        $sql.=" LEFT JOIN processos p ON pe.processos_pk = p.pk";
        $sql.=" LEFT JOIN fornecedor f ON tg.grupo_leancamento_pk = f.pk";
        $sql.=" where 1=1";
        if($tipo_grupo_pk == 3 || $tipo_grupo_pk == ""){
            $sql.="     and tg.tipo_grupo_pk = 3";
            if($posto_trabalho_pk != ""){
                $sql.="     and tg.leads_posto_trabalho_pk = $posto_trabalho_pk";
            }
            if($grupo_lancamento_centro_custo_pk != ""){
                $sql.="     and tg.grupo_lancamento_centro_custo_pk = $grupo_lancamento_centro_custo_pk";
            }
            if($contratos_pk != ""){
                $sql.="     and tg.contratos_pk = $contratos_pk";
            }
            if($grupo_leancamento_pk != ""){
                $sql.="     and tg.grupo_leancamento_pk = $grupo_leancamento_pk";
            }
            if($ds_ano_vigente_teto != ""){
                $sql.="     and tg.ds_ano_vigente_teto like '%$ds_ano_vigente_teto%'";
            }
            if($ic_status != ""){
                $sql.="     and tg.ic_status = $ic_status";
            }
        }else{
            $sql.="     and tg.tipo_grupo_pk = 0";
        }
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,empresas_pk ";
        $sql.="       ,tipo_grupo_pk ";
        $sql.="       ,grupo_leancamento_pk ";
        $sql.="       ,leads_posto_trabalho_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,colaborador_posto_trabalho_pk ";
        $sql.="       ,colaborador_contratos_pk ";
        $sql.="       ,fornecedor_posto_trabalho_pk ";
        $sql.="       ,fornecedor_contratos_pk ";
        $sql.="       ,vl_total_teto ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs ";
        $sql.="       ,ds_ano_vigente_teto ";
        $sql.="       ,grupo_lancamento_centro_custo_pk ";

        $sql.="  from teto_gastos ";
        $sql.=" where 1=1 ";
        $sql.=" order by empresas_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
