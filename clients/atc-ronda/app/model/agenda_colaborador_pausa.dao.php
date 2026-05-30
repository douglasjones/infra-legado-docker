<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/agenda_colaborador_pausa.class.php';


class agenda_colaborador_pausadao{

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
    
    public function salvar($agenda_colaborador_pausa){

        $fields = array();
        $fields['ds_agenda_colaborador_pausa'] = $agenda_colaborador_pausa->getds_agenda_colaborador_pausa();
        $fields['dt_inicio_pausa'] = $agenda_colaborador_pausa->getdt_inicio_pausa();
        $fields['dt_fim_pausa'] = $agenda_colaborador_pausa->getdt_fim_pausa();
        $fields['motivos_pausas_pk'] = $agenda_colaborador_pausa->getmotivos_pausas_pk();
        $fields['colaboradores_pk'] = $agenda_colaborador_pausa->getcolaboradores_pk();
        $fields['turnos_pk'] = $agenda_colaborador_pausa->getturnos_pk();
        $fields['colaborador_substituto_pk'] = $agenda_colaborador_pausa->getcolaborador_substituto_pk();
        $fields['ds_obs_exclusao'] = $agenda_colaborador_pausa->getds_obs_exclusao();
        $fields['motivo_exclusao_pk'] = $agenda_colaborador_pausa->getmotivo_exclusao_pk();
        $fields['ds_obs_folga'] = $agenda_colaborador_pausa->getds_obs_folga();
        $fields['motivo_folga_pk'] = $agenda_colaborador_pausa->getmotivo_folga_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($agenda_colaborador_pausa->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("agenda_colaborador_pausa", $fields);
            
            return $pk;
        }
        else{
            return $this->db->execUpdate("agenda_colaborador_pausa", $fields, " pk = ".$agenda_colaborador_pausa->getpk());
        }

    }

    public function excluir($agenda_colaborador_pausa){
        $this->db->execDelete("agenda_colaborador_pausa"," pk = ".$agenda_colaborador_pausa->getpk());
    }

    public function carregarPorPk($pk){

        $agenda_colaborador_pausa = new agenda_colaborador_pausa();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_agenda_colaborador_pausa ";
        $sql.="       ,dt_inicio_pausa ";
        $sql.="       ,dt_fim_pausa ";
        $sql.="       ,motivos_pausas_pk ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,turnos_pk ";
        $sql.="       ,colaborador_substituto_pk";
        $sql.="       ,motivo_folga_pk";
        $sql.="       ,ds_obs_folga";


        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $agenda_colaborador_pausa->setpk($query[$i]["pk"]);
                $agenda_colaborador_pausa->setdt_cadastro($query[$i]["dt_cadastro"]);
                $agenda_colaborador_pausa->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $agenda_colaborador_pausa->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $agenda_colaborador_pausa->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $agenda_colaborador_pausa->setds_agenda_colaborador_pausa($query[$i]['ds_agenda_colaborador_pausa']);
                $agenda_colaborador_pausa->setdt_inicio_pausa($query[$i]['dt_inicio_pausa']);
                $agenda_colaborador_pausa->setdt_fim_pausa($query[$i]['dt_fim_pausa']);
                $agenda_colaborador_pausa->setmotivos_pausas_pk($query[$i]['motivos_pausas_pk']);
                $agenda_colaborador_pausa->setcolaboradores_pk($query[$i]['colaboradores_pk']);
                $agenda_colaborador_pausa->setturnos_pk($query[$i]['turnos_pk']);

            }
        }
        return $agenda_colaborador_pausa;
    }
    public function carregarExclusao($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk){

        $agenda_colaborador_pausa = new agenda_colaborador_pausa();
       
            
        $sql ="select pk ";
        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where dt_inicio_pausa = '".DataYMD($dt_inicio_pausa)."' and dt_fim_pausa = '".DataYMD($dt_fim_pausa)."' and colaboradores_pk =".$colaboradores_pk." and motivo_exclusao_pk is not null ";
        
        $query = $this->db->execQuery($sql);
        for($i = 0; $i < count($query); $i++){
            $agenda_colaborador_pausa->setpk($query[$i]["pk"]);

        }
        
        return $agenda_colaborador_pausa;
    }
    public function carregarFerias($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk){

        $agenda_colaborador_pausa = new agenda_colaborador_pausa();
       
            
        $sql ="select pk ";
        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where dt_inicio_pausa = '".DataYMD($dt_inicio_pausa)."' and dt_fim_pausa = '".DataYMD($dt_fim_pausa)."' and colaboradores_pk =".$colaboradores_pk." and ds_agenda_colaborador_pausa like '%Férias%'";
       
        $query = $this->db->execQuery($sql);
        for($i = 0; $i < count($query); $i++){
            $agenda_colaborador_pausa->setpk($query[$i]["pk"]);

        }
        
        return $agenda_colaborador_pausa;
    }
    public function carregarFolga($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk){

        $agenda_colaborador_pausa = new agenda_colaborador_pausa();
       
            
        $sql ="select pk ";
        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where dt_inicio_pausa = '".DataYMD($dt_inicio_pausa)."' and dt_fim_pausa = '".DataYMD($dt_fim_pausa)."' and colaboradores_pk =".$colaboradores_pk." and motivo_folga_pk is not null ";
        
        $query = $this->db->execQuery($sql);
        for($i = 0; $i < count($query); $i++){
            $agenda_colaborador_pausa->setpk($query[$i]["pk"]);

        }
        
        return $agenda_colaborador_pausa;
    }
    public function carregarTroca($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk){

        $agenda_colaborador_pausa = new agenda_colaborador_pausa();
       
            
        $sql ="select pk ";
        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where dt_inicio_pausa = '".DataYMD($dt_inicio_pausa)."' and dt_fim_pausa = '".DataYMD($dt_fim_pausa)."' and colaboradores_pk =".$colaboradores_pk." and motivos_pausas_pk is not null";
        
        $query = $this->db->execQuery($sql);
        for($i = 0; $i < count($query); $i++){
            $agenda_colaborador_pausa->setpk($query[$i]["pk"]);

        }
        
        return $agenda_colaborador_pausa;
    }
    public function excluirCobertura($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk){

        $agenda_colaborador_pausa = new agenda_colaborador_pausa();
       
            
        $sql ="select pk ";
        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where dt_inicio_pausa = '".DataYMD($dt_inicio_pausa)."' and dt_fim_pausa = '".DataYMD($dt_fim_pausa)."' and colaboradores_pk =".$colaboradores_pk." and ds_agenda_colaborador_pausa ='Cobertura'";
       
        $query = $this->db->execQuery($sql);
        for($i = 0; $i < count($query); $i++){
            $agenda_colaborador_pausa->setpk($query[$i]["pk"]);

        }
        
        return $agenda_colaborador_pausa;
    }
    public function carregarExclusaoNovaEscala($dt_inicio_pausa,$dt_fim_pausa,$colaboradores_pk){

        $agenda_colaborador_pausa = new agenda_colaborador_pausa();
       
            
        $sql ="select pk ";
        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where dt_inicio_pausa = '".DataYMD($dt_inicio_pausa)."' and dt_fim_pausa = '".DataYMD($dt_fim_pausa)."' and colaboradores_pk =".$colaboradores_pk;
        $sql.="  and ds_agenda_colaborador_pausa != 'Folga' ";
        $query = $this->db->execQuery($sql);
        for($i = 0; $i < count($query); $i++){
            $agenda_colaborador_pausa->setpk($query[$i]["pk"]);

        }
        
        return $agenda_colaborador_pausa;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_agenda_colaborador_pausa ";
        $sql.="       ,dt_inicio_pausa ";
        $sql.="       ,dt_fim_pausa ";
        $sql.="       ,motivos_pausas_pk ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,turnos_pk ";
        $sql.="       ,colaborador_substituto_pk";
        $sql.="       ,motivo_folga_pk";
        $sql.="       ,ds_obs_folga";

        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function datediff($dt_inicio,$dt_fim){

        $sql ="";
        $sql.="select DATEDIFF ('".DataYMD($dt_fim)."', '".DataYMD($dt_inicio)."') AS diferenca  ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_agenda_colaborador_pausa($ds_agenda_colaborador_pausa){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_agenda_colaborador_pausa ";
        $sql.="       ,dt_inicio_pausa ";
        $sql.="       ,dt_fim_pausa ";
        $sql.="       ,motivos_pausas_pk ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,turnos_pk ";
        $sql.="       ,colaborador_substituto_pk";
        $sql.="       ,motivo_folga_pk";
        $sql.="       ,ds_obs_folga";

        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where 1=1 ";
        if($ds_agenda_colaborador_pausa != ""){
            $sql.=" and ds_agenda_colaborador_pausa like '%".$ds_agenda_colaborador_pausa."%' ";
        }
        $sql.=" order by ds_agenda_colaborador_pausa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPausa($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk){

        $sql ="";
        $sql.="select acp.pk, acp.dt_cadastro, acp.usuario_cadastro_pk, acp.dt_ult_atualizacao, acp.usuario_ult_atualizacao_pk ";
        $sql.="       ,acp.ds_agenda_colaborador_pausa ";
        $sql.="       ,acp.dt_inicio_pausa ";
        $sql.="       ,acp.dt_fim_pausa ";
        $sql.="       ,acp.motivos_pausas_pk ";
        $sql.="       ,acp.colaboradores_pk ";
        $sql.="       ,acp.turnos_pk ";
        $sql.="       ,acp.colaborador_substituto_pk";
        $sql.="       ,acp.motivo_folga_pk";
        $sql.="       ,acp.ds_obs_folga";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,c.ds_re";

        $sql.="  from agenda_colaborador_pausa acp";
        $sql.="  inner join colaboradores c on acp.colaboradores_pk = c.pk";
        $sql.=" where 1=1 ";
        if($dt_inicio != ""){
            $sql.=" and acp.dt_inicio_pausa >= '".DataYMD($dt_inicio)."' and  acp.dt_inicio_pausa <= '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and acp.colaboradores_pk =".$colaborador_pk;
        }
        $sql.=" AND (acp.motivos_pausas_pk IS NOT NULL OR acp.motivo_exclusao_pk IS NOT NULL OR acp.motivo_folga_pk IS NOT NULL)";
        /*if($turnos_pk!=""){
            $sql.=" and acp.turnos_pk =".$turnos_pk;
        }*/
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarIncluirEscala($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk){

        $sql ="";
        $sql.="select acp.pk, acp.dt_cadastro, acp.usuario_cadastro_pk, acp.dt_ult_atualizacao, acp.usuario_ult_atualizacao_pk ";
        $sql.="       ,acp.ds_agenda_colaborador_pausa ";
        $sql.="       ,acp.dt_inicio_pausa ";
        $sql.="       ,acp.dt_fim_pausa ";
        $sql.="       ,acp.motivos_pausas_pk ";
        $sql.="       ,acp.colaboradores_pk ";
        $sql.="       ,acp.turnos_pk ";
        $sql.="       ,acp.colaborador_substituto_pk";
        $sql.="       ,acp.motivo_folga_pk";
        $sql.="       ,acp.ds_obs_folga";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,c.ds_re";

        $sql.="  from agenda_colaborador_pausa acp";
        $sql.="  inner join colaboradores c on acp.colaboradores_pk = c.pk";
        $sql.=" where 1=1 ";
        if($dt_inicio != ""){
            $sql.=" and acp.dt_inicio_pausa >= '".DataYMD($dt_inicio)."' and  acp.dt_inicio_pausa <= '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and acp.colaboradores_pk =".$colaborador_pk;
        }
        $sql.=" AND (acp.motivos_pausas_pk IS NULL OR acp.motivo_exclusao_pk IS NULL OR acp.motivo_folga_pk  IS  NULL)";
        $sql.="  and acp.ds_agenda_colaborador_pausa != 'Folga' ";
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPausaColaborador($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk){

        $sql ="";
        $sql.="select acp.pk, acp.dt_cadastro, acp.usuario_cadastro_pk, acp.dt_ult_atualizacao, acp.usuario_ult_atualizacao_pk ";
        $sql.="       ,acp.ds_agenda_colaborador_pausa ";
        $sql.="       ,acp.dt_inicio_pausa ";
        $sql.="       ,acp.dt_fim_pausa ";
        $sql.="       ,acp.motivos_pausas_pk ";
        $sql.="       ,acp.colaboradores_pk ";
        $sql.="       ,acp.turnos_pk ";
        $sql.="       ,acp.colaborador_substituto_pk";
        $sql.="       ,acp.motivo_folga_pk";
        $sql.="       ,acp.ds_obs_folga";

        $sql.="  from agenda_colaborador_pausa acp";
        $sql.=" where 1=1 ";
        if($dt_inicio != ""){
            $sql.=" and acp.dt_inicio_pausa >= '".DataYMD($dt_inicio)."' and  acp.dt_inicio_pausa <= '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and acp.colaboradores_pk =".$colaborador_pk;
        }
        $sql.=" and acp.motivo_exclusao_pk is null";
        /*if($turnos_pk!=""){
            $sql.=" and acp.turnos_pk =".$turnos_pk;
        }*/
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function RelatorioColaboradorFerias($dt_inicio,$dt_fim,$colaborador_pk){

        $sql ="";
        $sql.="select acp.pk, acp.dt_cadastro, acp.usuario_cadastro_pk, acp.dt_ult_atualizacao, acp.usuario_ult_atualizacao_pk ";
        $sql.="       ,min(date_format(acp.dt_inicio_pausa,'%d/%m/%Y'))dt_inicio_pausa ";
        $sql.="       ,max(date_format(acp.dt_fim_pausa,'%d/%m/%Y'))dt_fim_pausa ";
        $sql.="       ,c.ds_colaborador";

        $sql.="  from agenda_colaborador_pausa acp";
        $sql.="      inner join colaboradores c on acp.colaboradores_pk = c.pk";
        $sql.=" where 1=1 ";
        if($dt_inicio != ""){
            $sql.=" and acp.dt_inicio_pausa >= '".DataYMD($dt_inicio)."' and  acp.dt_fim_pausa <= '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and acp.colaboradores_pk =".$colaborador_pk;
        }
        $sql.=" and acp.ds_agenda_colaborador_pausa like '%Férias%'";
        $sql.=" group by c.pk";
       $query = $this->db->execQuery($sql);
        return $query;
        
    }
    public function listarCores($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk,$leads_pk){
        
        
        
        
        
        
        
        
        //VERIFICA SEM EXISTE DADOS NESSA TABELA NO PERIODO
        $sql0="";
        $sql0.="select count(0)total from agenda_colaborador_pausa acp where acp.dt_inicio_pausa >= '".DataYMD($dt_inicio)."' AND acp.dt_fim_pausa <= '".DataYMD($dt_fim)."' and acp.colaboradores_pk = ".$colaborador_pk;

        $queryacp = $this->db->execQuery($sql0);
        
        
        
        $sql2="";
        $sql2.="select count(0)total from colaboradores_faltas cf where cf.dt_escala BETWEEN '".DataYMD($dt_inicio)."' AND '".DataYMD($dt_fim)."' and cf.colaborador_pk = ".$colaborador_pk;
    
        $queryf = $this->db->execQuery($sql2);
        
        $sql3="";
        $sql3.="select count(0)total from colaboradores_hora_extra che where che.dt_escala BETWEEN '".DataYMD($dt_inicio)."' AND '".DataYMD($dt_fim)."' and che.colaborador_pk = ".$colaborador_pk;
       
        $queryh = $this->db->execQuery($sql3);
        

        
        
        
        
        
        $sql ="";
        $sql.="select che.hr_extra_ini,";
        $sql.=" c_ferias.ds_colaborador ds_colaborador_substituto_ferias,";
        $sql.=" acp.motivo_exclusao_pk,acp.ds_agenda_colaborador_pausa,";
        $sql.=" date_format(cf.dt_escala,'%d/%m/%Y')dt_escala,";
        $sql.=" date_format(che.dt_escala,'%d/%m/%Y')dt_hr_extra,";
        $sql.=" acp.motivos_pausas_pk,";
        $sql.=" date_format(acp.dt_inicio_pausa,'%d/%m/%Y')dt_inicio_pausa,";
        $sql.=" acp.motivo_folga_pk,";
        $sql.=" c.ds_colaborador ds_colaborador_reserva,";
        $sql.=" c.ds_re,";
        $sql.=" cf.obs obs_falta,";
        $sql.=" che.obs obs_hora_extra,acp.ds_obs_exclusao,";
        $sql.=" acp.ds_obs_folga,";
        $sql.="       case acp.motivo_folga_pk when 1 then 'Consulta Médica' when 2 then 'Outro motivo folga' when 3 then 'Escala data Errada' when 4 then 'Folga Trabalhada' when 5 then 'Cobertura' end ds_motivo_folga,";
        $sql.="       case cf.motivo_falta_pk when 1 then 'Falta sem Justificativa' when 2 then 'Atestado' when 3 then 'Reciclagem' when 4 then 'Posto Vago' when 5 then 'Remanegamento' end ds_motivo_falta";
        $sql.="  FROM agenda_colaborador_padrao a";
        $sql.=" inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
        $sql.=" inner join processos pr on pe.processos_pk = pr.pk";
        $sql.=" left join agenda_colaborador_pausa acp on a.colaboradores_pk = acp.colaboradores_pk";
        $sql.=" left join colaboradores_faltas cf on a.colaboradores_pk = cf.colaborador_pk and cf.leads_pk = pr.leads_pk";
        $sql.=" left join colaboradores_hora_extra che on a.colaboradores_pk = che.colaborador_pk and che.leads_pk = pr.leads_pk";
        $sql.=" left join colaboradores c on cf.colaborador_reserva_pk = c.pk";
        $sql.=" left join colaboradores c_ferias on acp.colaborador_substituto_pk = c_ferias.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and pr.leads_pk=".$leads_pk;
        }
        if($colaborador_pk!=""){
            $sql.=" and a.colaboradores_pk =".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and pr.leads_pk=".$leads_pk;
        }
        if($dt_inicio!=""){
            if($queryacp[0]["total"]> 0){
                $sql.=" AND acp.dt_inicio_pausa >= '".DataYMD($dt_inicio)."'";
                $sql.=" AND acp.dt_fim_pausa <= '".DataYMD($dt_fim)."'";
            }
            if($queryf[0]["total"]> 0){
                $sql.=" and cf.dt_escala BETWEEN '".DataYMD($dt_inicio)."' AND '".DataYMD($dt_fim)."'";
            }
            if($queryh[0]["total"]> 0){
                 $sql.=" and che.dt_escala BETWEEN '".DataYMD($dt_inicio)."' AND '".DataYMD($dt_fim)."'";
            }
           
           
        }
        
        $sql.=" GROUP BY cf.dt_escala,che.dt_escala,acp.dt_inicio_pausa,acp.pk";
        $sql.=" ORDER BY cf.dt_escala,che.dt_escala,acp.dt_inicio_pausa,acp.pk desc";
       
        
        $sql.=" limit 20000";
        
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarCoresColaborador($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk,$leads_pk,$diasemana_numero){
        
        
        
        
        
        
        
        //VERIFICA SEM EXISTE DADOS NESSA TABELA NO PERIODO
        $sql0="";
        $sql0.="select count(0)total from agenda_colaborador_pausa acp where acp.dt_inicio_pausa >= '".DataYMD($dt_inicio)."' AND acp.dt_fim_pausa <= '".DataYMD($dt_fim)."' and acp.colaboradores_pk = ".$colaborador_pk;

        $queryacp = $this->db->execQuery($sql0);
                
        $sql2="";
        $sql2.="select count(0)total from colaboradores_faltas cf where cf.dt_escala BETWEEN '".DataYMD($dt_inicio)."' AND '".DataYMD($dt_fim)."' and cf.colaborador_pk = ".$colaborador_pk;
    
        $queryf = $this->db->execQuery($sql2);
        
        $sql3="";
        $sql3.="select count(0)total from colaboradores_hora_extra che where che.dt_escala BETWEEN '".DataYMD($dt_inicio)."' AND '".DataYMD($dt_fim)."' and che.colaborador_pk = ".$colaborador_pk;
       
        $queryh = $this->db->execQuery($sql3);
        
        
        
        
        $sql ="";
        $sql.="select che.hr_extra_ini,c_ferias.ds_colaborador ds_colaborador_substituto_ferias,acp.motivo_exclusao_pk,acp.ds_agenda_colaborador_pausa,";
        $sql.=" date_format(cf.dt_escala,'%d/%m/%Y')dt_escala,date_format(che.dt_escala,'%d/%m/%Y')dt_hr_extra,acp.motivos_pausas_pk,date_format(acp.dt_inicio_pausa,'%d/%m/%Y')dt_inicio_pausa,acp.motivo_folga_pk,c.ds_colaborador ds_colaborador_reserva,c.ds_re,cf.obs obs_falta,";
        $sql.=" che.obs obs_hora_extra,acp.ds_obs_exclusao,";
        $sql.=" acp.ds_obs_folga,";
        $sql.="       case acp.motivo_folga_pk when 1 then 'Consulta Médica' when 2 then 'Outro motivo folga' when 3 then 'Escala data Errada' when 4 then 'Folga Trabalhada' when 5 then 'Cobertura' end ds_motivo_folga,";
        $sql.="       case cf.motivo_falta_pk when 1 then 'Falta sem Justificativa' when 2 then 'Atestado' when 3 then 'Reciclagem' when 4 then 'Posto Vago' when 5 then 'Remanegamento' end ds_motivo_falta";
        $sql.="  FROM agenda_colaborador_padrao a";
        $sql.=" inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
        $sql.=" inner join processos pr on pe.processos_pk = pr.pk";
        $sql.=" left join agenda_colaborador_pausa acp on a.colaboradores_pk = acp.colaboradores_pk";
        $sql.=" left join colaboradores_faltas cf on a.colaboradores_pk = cf.colaborador_pk and cf.leads_pk = pr.leads_pk";
        $sql.=" left join colaboradores_hora_extra che on a.colaboradores_pk = che.colaborador_pk and che.leads_pk = pr.leads_pk";
        $sql.=" left join colaboradores c on cf.colaborador_reserva_pk = c.pk";
        $sql.=" left join colaboradores c_ferias on acp.colaborador_substituto_pk = c_ferias.pk";
        
        
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and pr.leads_pk=".$leads_pk;
        }
        if($colaborador_pk!=""){
            $sql.=" and a.colaboradores_pk =".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and pr.leads_pk=".$leads_pk;
        }
        if($dt_inicio!=""){
            if($queryacp[0]["total"]> 0){
                $sql.=" AND acp.dt_inicio_pausa >= '".DataYMD($dt_inicio)."'";
                $sql.=" AND acp.dt_fim_pausa <= '".DataYMD($dt_fim)."'";
            }
            if($queryf[0]["total"]> 0){
                $sql.=" and cf.dt_escala BETWEEN '".DataYMD($dt_inicio)."' AND '".DataYMD($dt_fim)."'";
            }
            if($queryh[0]["total"]> 0){
                 $sql.=" and che.dt_escala BETWEEN '".DataYMD($dt_inicio)."' AND '".DataYMD($dt_fim)."'";
            }
           
        }
        
        $sql.=" GROUP BY cf.dt_escala,che.dt_escala,acp.dt_inicio_pausa,acp.pk";
        $sql.=" ORDER BY cf.dt_escala,che.dt_escala,acp.dt_inicio_pausa,acp.pk desc";
        
        
        $sql.=" limit 20000";
       
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    /*public function listarApontamento($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk,$leads_pk){

        $sql ="";
        $sql.="select che.hr_extra_ini,c_ferias.ds_colaborador ds_colaborador_substituto_ferias,acp.motivo_exclusao_pk,acp.ds_agenda_colaborador_pausa, date_format(p.dt_hora_ponto,'%d/%m/%Y')dt_hora_ponto, date_format(cf.dt_escala,'%d/%m/%Y')dt_escala,date_format(che.dt_escala,'%d/%m/%Y')dt_hr_extra,acp.motivos_pausas_pk,date_format(acp.dt_inicio_pausa,'%d/%m/%Y')dt_inicio_pausa,acp.motivo_folga_pk,c.ds_colaborador,c.ds_re,cf.obs obs_falta,";
        $sql.=" che.obs obs_hora_extra,acp.ds_obs_exclusao,";
        $sql.=" acp.ds_obs_folga,";
        
        $sql.=" ua.ds_usuario ds_usuario_agenda_pausa,";
        $sql.=" ucf.ds_usuario ds_usuario_falta,";
        $sql.=" up.ds_usuario ds_usuario_ponto,";
        $sql.=" uch.ds_usuario ds_usuario_hora_extra,";
        
        $sql.=" date_format(acp.dt_cadastro,'%d/%m/%Y')dt_cadastro_agenda_pausa,";
        $sql.=" date_format(cf.dt_cadastro,'%d/%m/%Y')dt_cadastro_falta,";
        $sql.=" date_format(up.dt_cadastro,'%d/%m/%Y')dt_cadastro_ponto,";
        $sql.=" date_format(che.dt_cadastro,'%d/%m/%Y')dt_cadastro_hora_extra,";
        
        $sql.="       case acp.motivo_folga_pk when 1 then 'Consulta Médica' when 2 then 'Outro motivo folga' when 3 then 'Escala data Errada' when 4 then 'Folga Trabalhada' when 5 then 'Cobertura' end ds_motivo_folga,";
        $sql.="       case cf.motivo_falta_pk when 1 then 'Falta sem Justificativa' when 2 then 'Atestado' when 3 then 'Reciclagem' when 4 then 'Posto Vago' when 5 then 'Remanegamento' end ds_motivo_falta";
        $sql.="  FROM agenda_colaborador_padrao a";
        $sql.=" inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
        $sql.=" inner join processos pr on pe.processos_pk = pr.pk";
        $sql.=" left join agenda_colaborador_pausa acp on a.colaboradores_pk = acp.colaboradores_pk";
        $sql.=" left join ponto p on a.colaboradores_pk = p.colaborador_pk";
        
        
        
        $sql.=" left join colaboradores_faltas cf on a.colaboradores_pk = cf.colaborador_pk and cf.leads_pk = pr.leads_pk";
        $sql.=" left join colaboradores_hora_extra che on a.colaboradores_pk = che.colaborador_pk and che.leads_pk = pr.leads_pk";
        $sql.=" left join colaboradores c on cf.colaborador_reserva_pk = c.pk";
        $sql.=" left join colaboradores c_ferias on acp.colaborador_substituto_pk = c_ferias.pk";
        
        
        
        
        $sql.=" left join usuarios ua on acp.usuario_cadastro_pk = ua.pk";
        $sql.=" left join usuarios ucf on cf.usuario_cadastro_pk = ucf.pk";
        $sql.=" left join usuarios up on p.usuario_cadastro_pk = up.pk";
        $sql.=" left join usuarios uch on che.usuario_cadastro_pk = uch.pk";
        $sql.=" where 1=1 ";
        if($colaborador_pk!=""){
            $sql.=" and a.colaboradores_pk =".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and pr.leads_pk=".$leads_pk;
        }
        
        $sql.=" GROUP BY p.dt_hora_ponto,cf.dt_escala,che.dt_escala,acp.dt_inicio_pausa,acp.pk";
        //$sql.=" GROUP BY acp.dt_inicio_pausa";
        //echo $sql."<br>";
       
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }*/
    public function listarAgendaPausa($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk){

        $sql ="";
        $sql.="select acp.motivo_folga_pk,";
        $sql.="acp.ds_agenda_colaborador_pausa,";
        $sql.="c_ferias.ds_colaborador,";
        $sql.="ua.ds_usuario,";
        $sql.="date_format(acp.dt_cadastro,'%d/%m/%Y')dt_cadastro,";
        $sql.="date_format(acp.dt_inicio_pausa,'%d/%m/%Y')dt_inicio,";
        $sql.="acp.motivos_pausas_pk,";
        $sql.="acp.motivo_exclusao_pk,";
        $sql.="acp.ds_obs_exclusao,acp.ds_obs_folga,";
        $sql.="       case acp.motivo_folga_pk when 1 then 'Consulta Médica' when 2 then 'Outro motivo folga' when 3 then 'Escala data Errada' when 4 then 'Folga Trabalhada' when 5 then 'Cobertura' end ds_motivo_folga";
        $sql.="  FROM agenda_colaborador_padrao a";
        $sql.=" inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
        $sql.=" inner join processos pr on pe.processos_pk = pr.pk";
        $sql.=" inner join agenda_colaborador_pausa acp on a.colaboradores_pk = acp.colaboradores_pk";
        $sql.=" left join colaboradores c_ferias on acp.colaborador_substituto_pk = c_ferias.pk";
        $sql.=" inner join usuarios ua on acp.usuario_cadastro_pk = ua.pk";
        
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and acp.dt_inicio_pausa between '".DataYMD($dt_inicio)."' and '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and acp.colaboradores_pk =".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and pr.leads_pk=".$leads_pk;
        }
        
        //$sql.=" GROUP BY p.dt_hora_ponto,cf.dt_escala,che.dt_escala,acp.dt_inicio_pausa,acp.pk";
        $sql.=" GROUP BY acp.ds_agenda_colaborador_pausa";
        $sql.=" order by date_format(acp.dt_inicio_pausa,'%d/%m/%Y')";
        //echo $sql."<br>";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarAgendaPausaRel($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk){

        $sql ="";
        $sql.="select acp.motivo_folga_pk,acp.ds_agenda_colaborador_pausa,l.ds_lead, c.ds_colaborador,ua.ds_usuario,date_format(acp.dt_cadastro,'%d/%m/%Y')dt_cadastro,acp.motivos_pausas_pk,acp.motivo_exclusao_pk,acp.ds_obs_exclusao,acp.ds_obs_folga,date_format(acp.dt_inicio_pausa,'%d/%m/%Y')dt_inicio_pausa,";
        $sql.="       case acp.motivo_folga_pk when 1 then 'Consulta Médica' when 2 then 'Outro motivo folga' when 3 then 'Escala data Errada' when 4 then 'Folga Trabalhada' when 5 then 'Cobertura' end ds_motivo_folga";
        $sql.="  FROM agenda_colaborador_padrao a";
        $sql.=" inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
        $sql.=" inner join processos pr on pe.processos_pk = pr.pk";
        $sql.=" inner join leads l on pr.leads_pk = l.pk";
        $sql.=" inner join agenda_colaborador_pausa acp on a.colaboradores_pk = acp.colaboradores_pk";
        $sql.=" inner join colaboradores c on acp.colaboradores_pk = c.pk";
        $sql.=" inner join usuarios ua on acp.usuario_cadastro_pk = ua.pk";
        
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and acp.dt_inicio_pausa between '".DataYMD($dt_inicio)."' and '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and acp.colaboradores_pk =".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and pr.leads_pk=".$leads_pk;
        }
        
        //$sql.=" GROUP BY p.dt_hora_ponto,cf.dt_escala,che.dt_escala,acp.dt_inicio_pausa,acp.pk";
        $sql.=" GROUP BY acp.ds_agenda_colaborador_pausa";
        //echo $sql."<br>";
       
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarAgendaPausaFolga($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk){

        $sql ="";
        $sql.="select c.ds_colaborador,date_format(acp.dt_inicio_pausa,'%d/%m/%Y')dt_inicio_pausa,l.ds_lead,acp.motivo_folga_pk,acp.ds_agenda_colaborador_pausa, ua.ds_usuario,date_format(acp.dt_cadastro,'%d/%m/%Y')dt_cadastro,acp.motivos_pausas_pk,acp.motivo_exclusao_pk,acp.ds_obs_exclusao,acp.ds_obs_folga,";
        $sql.="       case acp.motivo_folga_pk when 1 then 'Consulta Médica' when 2 then 'Outro motivo folga' when 3 then 'Escala data Errada' when 4 then 'Folga Trabalhada' when 5 then 'Cobertura' end ds_motivo_folga";
        $sql.="  FROM agenda_colaborador_padrao a";
        $sql.=" inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
        $sql.=" inner join processos pr on pe.processos_pk = pr.pk";
        $sql.=" inner join leads l on pr.leads_pk = l.pk";
        $sql.=" inner join agenda_colaborador_pausa acp on a.colaboradores_pk = acp.colaboradores_pk";
        $sql.=" inner join colaboradores c on acp.colaboradores_pk = c.pk";
        $sql.=" inner join usuarios ua on acp.usuario_cadastro_pk = ua.pk";
        
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and acp.dt_inicio_pausa between '".DataYMD($dt_inicio)."' and '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and acp.colaboradores_pk =".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and pr.leads_pk=".$leads_pk;
        }
        
        $sql.=" and acp.ds_agenda_colaborador_pausa like '%Folga%'";
        $sql.=" GROUP BY acp.pk";
        //echo $sql."<br>";
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarFalta($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk){

        $sql ="";
        $sql.="select cf.obs, c.ds_colaborador ds_colaborador_reserva,ua.ds_usuario,date_format(cf.dt_cadastro,'%d/%m/%Y')dt_cadastro,date_format(cf.dt_escala,'%d/%m/%Y')dt_escala,";
        $sql.="       case cf.motivo_falta_pk when 1 then 'Falta sem Justificativa' when 2 then 'Atestado' when 3 then 'Reciclagem' when 4 then 'Posto Vago' when 5 then 'Remanegamento' end ds_motivo_falta";
        $sql.="  FROM colaboradores_faltas cf";
        $sql.=" left join colaboradores c on cf.colaborador_reserva_pk = c.pk";
        $sql.=" inner join usuarios ua on cf.usuario_cadastro_pk = ua.pk";
        
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and cf.dt_escala between '".DataYMD($dt_inicio)."' and '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and cf.colaborador_pk =".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and cf.leads_pk=".$leads_pk;
        }
        
        
        //$sql.=" GROUP BY p.dt_hora_ponto,cf.dt_escala,che.dt_escala,acp.dt_inicio_pausa,acp.pk";
        $sql.=" GROUP BY cf.dt_escala";
        //echo $sql."<br>";
       
   

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarFaltaRel($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk){

        $sql ="";
        $sql.="select cf.obs, c.ds_colaborador ,ua.ds_usuario,date_format(cf.dt_cadastro,'%d/%m/%Y')dt_cadastro,l.ds_lead,date_format(cf.dt_escala,'%d/%m/%Y')dt_escala,";
        $sql.="       case cf.motivo_falta_pk when 1 then 'Falta sem Justificativa' when 2 then 'Atestado' when 3 then 'Reciclagem' when 4 then 'Posto Vago' when 5 then 'Remanegamento' end ds_motivo_falta";
        $sql.="  FROM colaboradores_faltas cf";
        $sql.=" inner join colaboradores c on cf.colaborador_pk = c.pk";
        $sql.=" inner join usuarios ua on cf.usuario_cadastro_pk = ua.pk";
        $sql.=" inner join leads l on cf.leads_pk = l.pk";
        
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and cf.dt_escala between '".DataYMD($dt_inicio)."' and '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and cf.colaborador_pk =".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and cf.leads_pk=".$leads_pk;
        }
        
        
        //$sql.=" GROUP BY p.dt_hora_ponto,cf.dt_escala,che.dt_escala,acp.dt_inicio_pausa,acp.pk";
        $sql.=" GROUP BY cf.dt_escala";
        //echo $sql."<br>";
       
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarHoraExtra($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk){

        $sql ="";
        $sql.="select cf.hr_extra_ini, cf.obs, c.ds_colaborador ,ua.ds_usuario,date_format(cf.dt_cadastro,'%d/%m/%Y')dt_cadastro,date_format(cf.dt_escala,'%d/%m/%Y')dt_escala";
        $sql.="  FROM colaboradores_hora_extra cf";
        $sql.=" inner join colaboradores c on cf.colaborador_pk = c.pk";
        $sql.=" inner join usuarios ua on cf.usuario_cadastro_pk = ua.pk";
        
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and cf.dt_escala between '".DataYMD($dt_inicio)."' and '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and cf.colaborador_pk =".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and cf.leads_pk=".$leads_pk;
        }
        
        
        //$sql.=" GROUP BY p.dt_hora_ponto,cf.dt_escala,che.dt_escala,acp.dt_inicio_pausa,acp.pk";
        $sql.=" GROUP BY cf.dt_escala";
        //echo $sql."<br>";
       
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarHoraExtraRel($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk){

        $sql ="";
        $sql.="select cf.hr_extra_ini, cf.obs, c.ds_colaborador ,ua.ds_usuario,date_format(cf.dt_cadastro,'%d/%m/%Y')dt_cadastro,date_format(cf.dt_escala,'%d/%m/%Y')dt_escala,l.ds_lead";
        $sql.="  FROM colaboradores_hora_extra cf";
        $sql.=" inner join colaboradores c on cf.colaborador_pk = c.pk";
        $sql.=" inner join usuarios ua on cf.usuario_cadastro_pk = ua.pk";
        $sql.=" inner join leads l on cf.leads_pk = l.pk";
        
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and cf.dt_escala between '".DataYMD($dt_inicio)."' and '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and cf.colaborador_pk =".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and cf.leads_pk=".$leads_pk;
        }
        
        
        //$sql.=" GROUP BY p.dt_hora_ponto,cf.dt_escala,che.dt_escala,acp.dt_inicio_pausa,acp.pk";
        $sql.=" GROUP BY cf.dt_escala";
        //echo $sql."<br>";
       
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPonto($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk){

        $sql ="";
        $sql.="select ua.ds_usuario,date_format(p.dt_cadastro,'%d/%m/%Y')dt_cadastro,date_format(p.dt_hora_ponto,'%d/%m/%Y')dt_hora_ponto,case p.tipo_ponto_pk when 1 then 'Inicio Expediente' when 2 then 'Fim Expediente' when 3 then 'Saida p/ Intervalo' when 4 then 'Retorno do Intervalo' end ds_tipo_ponto";
        $sql.="  FROM ponto p";
        $sql.=" inner join colaboradores c on p.colaborador_pk = c.pk";
        $sql.=" inner join usuarios ua on p.usuario_cadastro_pk = ua.pk";
        
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and p.dt_hora_ponto between '".DataYMD($dt_inicio)." 00:00:00' and '".DataYMD($dt_fim)." 23:59:59'";
        }
        if($colaborador_pk!=""){
            $sql.=" and p.colaborador_pk =".$colaborador_pk;
        }
        $sql.=" group by p.tipo_ponto_pk";
        
       
       
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPontoGridColaborador($dt_inicio,$colaborador_pk,$leads_pk,$diasemana_numero){
        
        
        
        
        $sql ="";
        $sql.="SELECT ";
        if($diasemana_numero==0){
            $sql.="       agp.hr_turno_dom hr_entrada,";  
            $sql.="       agp.hr_turno_dom_saida hr_saida"; 
        }
        if($diasemana_numero==1){
            $sql.="       agp.hr_turno_seg hr_entrada,";  
            $sql.="       agp.hr_turno_seg_saida hr_saida"; 
        }
        if($diasemana_numero==2){
            $sql.="       agp.hr_turno_ter hr_entrada,";  
            $sql.="       agp.hr_turno_ter_saida hr_saida"; 
        }
        if($diasemana_numero==3){
            $sql.="       agp.hr_turno_qua hr_entrada,";  
            $sql.="       agp.hr_turno_qua_saida hr_saida"; 
        }
        if($diasemana_numero==4){
            $sql.="       agp.hr_turno_qui hr_entrada,";  
            $sql.="       agp.hr_turno_qui_saida hr_saida"; 
        }
        if($diasemana_numero==5){
            $sql.="       agp.hr_turno_sex hr_entrada,";  
            $sql.="       agp.hr_turno_sex_saida hr_saida"; 
        }
        if($diasemana_numero==6){
            $sql.="       agp.hr_turno_sab hr_entrada,";  
            $sql.="       agp.hr_turno_sab_saida hr_saida"; 
        }

        $sql.="  FROM leads l";
        $sql.="       INNER JOIN processos p ON l.pk = p.leads_pk";
        $sql.="       INNER JOIN processos_etapas pe ON p.pk = pe.processos_pk";
        $sql.="       INNER JOIN contratos c ON pe.pk = c.processos_etapas_pk";
        $sql.="       INNER JOIN contratos_itens ci ON c.pk = ci.contratos_pk";
        $sql.="       INNER JOIN agenda_colaborador_padrao agp ON ci.pk = agp.contratos_itens_pk";
        $sql.="       INNER JOIN colaboradores col ON agp.colaboradores_pk = col.pk";    
        $sql.="       INNER JOIN ponto pt ON col.pk = pt.colaborador_pk";
        $sql.=" where 1=1 ";

        $sql.=" and pt.dt_hora_ponto between '".DataYMD($dt_inicio)." 00:00:00' and '".DataYMD($dt_inicio)." 23:59:59'";

        if($leads_pk != ""){
            $sql.=" and l.pk = ".$leads_pk;
        }

        if($colaborador_pk != ""){
            $sql.=" and col.pk  = ".$colaborador_pk;
        }
        if($leads_pk != ""){
            $sql.=" and p.leads_pk = ".$leads_pk;
        }
        $sql.=" and agp.dt_cancelamento is null";


        $sql.=" group by DATE_FORMAT(pt.dt_hora_ponto, '%H:%i:%s'),pt.tipo_ponto_pk ";
        $sql.=" order by col.ds_colaborador, date_format(pt.dt_hora_ponto,'%H:%i:%s') asc ";
        

        $query1 = $this->db->execQuery($sql);

        if($query1[0]['hr_entrada']!=""){
            $arrEntrada = explode(":",$query1[0]['hr_entrada']);
            $arrSaida = explode(":",$query1[0]['hr_saida']);
            if($arrEntrada[0] > $arrSaida[0]){
                $hr_entrada = ("00:00:00");
                $hr_saida = ("23:59:59");
            }
            else{

                if($arrEntrada[1] < 30){
                    $hr_entrada = ($arrEntrada[0]-1).":".($arrSaida[1]+29).":00";
                }

                else if($arrEntrada[0] > 11){

                    //$hr_entrada = ($arrEntrada[0]-1).":25:00";
                    $hr_entrada = ($arrEntrada[0]-1).":30:00";
                }
                else{

                    $hr_entrada = ($arrEntrada[0]).":05:00";
                }
                if($arrSaida[1] <= 30){
                    $hr_saida = ($arrSaida[0]).":".($arrSaida[1]+19).":59";
                }
                else{
                   $hr_saida = ($arrSaida[0]).":".($arrSaida[1]+45).":59";
                }
            }

        }
        else{

            $hr_entrada = ("00:00:00");
            $hr_saida = ("23:59:59");
        }



        
        
        

        $sql ="";
        $sql.="select ua.ds_usuario,date_format(p.dt_cadastro,'%d/%m/%Y')dt_cadastro,case p.tipo_ponto_pk when 1 then 'Inicio Expediente' when 2 then 'Fim Expediente' when 3 then 'Saida p/ Intervalo' when 4 then 'Retorno do Intervalo' end ds_tipo_ponto";
        $sql.="  FROM ponto p";
        $sql.=" inner join colaboradores c on p.colaborador_pk = c.pk";
        $sql.=" inner join usuarios ua on p.usuario_cadastro_pk = ua.pk";
        
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and p.dt_hora_ponto between '".DataYMD($dt_inicio)." ".$hr_entrada."' and '".DataYMD($dt_inicio)." ".$hr_saida."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and p.colaborador_pk =".$colaborador_pk;
        }
        $sql.=" group by p.tipo_ponto_pk";
        
       
       
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPontoRel($dt_inicio,$dt_fim,$colaborador_pk,$leads_pk){
        
        

        $sql ="";
        $sql.="select pt.colaborador_pk,l.pk";
        $sql.="  FROM leads l";
        $sql.="       INNER JOIN processos p ON l.pk = p.leads_pk";
        $sql.="       INNER JOIN processos_etapas pe ON p.pk = pe.processos_pk";
        $sql.="       INNER JOIN contratos c ON pe.pk = c.processos_etapas_pk";
        $sql.="       INNER JOIN contratos_itens ci ON c.pk = ci.contratos_pk";
        $sql.="       INNER JOIN agenda_colaborador_padrao agp ON ci.pk = agp.contratos_itens_pk";
        $sql.="       INNER JOIN colaboradores col ON agp.colaboradores_pk = col.pk";
        $sql.="       INNER JOIN produtos_servicos ps ON ci.produtos_servicos_pk = ps.pk";        
        $sql.="       INNER JOIN ponto pt ON col.pk = pt.colaborador_pk";
        
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and pt.dt_hora_ponto between '".DataYMD($dt_inicio)." 00:00:00' and '".DataYMD($dt_fim)." 23:59:59'";
        }
        if($colaborador_pk!=""){
            $sql.=" and pt.colaborador_pk =".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and l.pk =".$leads_pk;
        }
        $sql.=" group by l.pk";
        
        
        $query1 = $this->db->execQuery($sql);
        $str .=" (";
        $strLead .=" (";
        if(count($query1)>0){
            
            for($i=0;$i<count($query1);$i++){
                $str .=$query1[$i]['colaborador_pk'].",";
                $strLead .=$query1[$i]['pk'].",";
            }
        }
        $str .="0)";
        $strLead .="0)";
        
        
        $sql="";
        $sql.="select date_format(pt.dt_hora_ponto,'%d/%m/%Y')dt_hora_ponto,l.ds_lead,col.ds_colaborador";
        $sql.="  FROM leads l";
        $sql.="       INNER JOIN processos p ON l.pk = p.leads_pk";
        $sql.="       INNER JOIN processos_etapas pe ON p.pk = pe.processos_pk";
        $sql.="       INNER JOIN contratos c ON pe.pk = c.processos_etapas_pk";
        $sql.="       INNER JOIN contratos_itens ci ON c.pk = ci.contratos_pk";
        $sql.="       INNER JOIN agenda_colaborador_padrao agp ON ci.pk = agp.contratos_itens_pk";
        $sql.="       INNER JOIN colaboradores col ON agp.colaboradores_pk = col.pk";
        $sql.="       INNER JOIN produtos_servicos ps ON ci.produtos_servicos_pk = ps.pk";        
        $sql.="       INNER JOIN ponto pt ON col.pk = pt.colaborador_pk";
        
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and pt.dt_hora_ponto between '".DataYMD($dt_inicio)." 00:00:00' and '".DataYMD($dt_fim)." 23:59:59'";
        }
        
        $sql.=" and pt.colaborador_pk in".$str;
        
        
        $sql.=" and l.pk in".$strLead;
        
        $sql.=" group by l.pk";
        $sql.=" order by col.ds_colaborador, date_format(pt.dt_hora_ponto,'%H:%i:%s') asc ";

       
       
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarFerias($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk,$leads_pk){

        $sql ="";
        $sql.="select acp.motivo_exclusao_pk,acp.ds_agenda_colaborador_pausa, date_format(p.dt_hora_ponto,'%d/%m/%Y')dt_hora_ponto, date_format(cf.dt_escala,'%d/%m/%Y')dt_escala,acp.motivos_pausas_pk,date_format(acp.dt_inicio_pausa,'%d/%m/%Y')dt_inicio_pausa,acp.motivo_folga_pk,c.ds_colaborador,c.ds_re";
        $sql.="  FROM agenda_colaborador_padrao a";
        $sql.=" left join agenda_colaborador_pausa acp on a.colaboradores_pk = acp.colaboradores_pk";
        $sql.=" left join ponto p on a.colaboradores_pk = p.colaborador_pk";
        $sql.=" left join colaboradores_faltas cf on a.colaboradores_pk = cf.colaborador_pk";
        $sql.=" left join colaboradores c on cf.colaborador_reserva_pk = c.pk";
        $sql.=" where 1=1 ";
        if($colaborador_pk!=""){
            $sql.=" and a.colaboradores_pk =".$colaborador_pk;
        }
        if($dt_inicio != ""){
            $sql.=" and acp.dt_inicio_pausa = '".DataYMD($dt_inicio)."'";
        }
        $sql.=" and acp.ds_agenda_colaborador_pausa like '%férias%'";
        //echo $sql."<br>";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarExclusaoColaborador($dt_inicio,$dt_fim,$colaborador_pk,$turnos_pk){

        $sql ="";
        $sql.="select acp.pk, acp.dt_cadastro, acp.usuario_cadastro_pk, acp.dt_ult_atualizacao, acp.usuario_ult_atualizacao_pk ";
        $sql.="       ,acp.ds_agenda_colaborador_pausa ";
        $sql.="       ,acp.dt_inicio_pausa ";
        $sql.="       ,acp.dt_fim_pausa ";
        $sql.="       ,acp.motivos_pausas_pk ";
        $sql.="       ,acp.colaboradores_pk ";
        $sql.="       ,acp.turnos_pk ";
        $sql.="       ,acp.colaborador_substituto_pk";
        $sql.="       ,acp.motivo_folga_pk";
        $sql.="       ,acp.ds_obs_folga";
        $sql.="       ,c.ds_colaborador";
        $sql.="  from agenda_colaborador_pausa acp";
        $sql.="       inner join colaboradores c on acp.colaboradores_pk = c.pk";
        $sql.=" where 1=1 ";
        if($dt_inicio != ""){
            $sql.=" and acp.dt_inicio_pausa >= '".DataYMD($dt_inicio)."' and  acp.dt_inicio_pausa <= '".DataYMD($dt_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and acp.colaboradores_pk =".$colaborador_pk;
        }
        $sql.=" and acp.motivo_exclusao_pk is not null";
        /*if($turnos_pk!=""){
            $sql.=" and acp.turnos_pk =".$turnos_pk;
        }*/
 
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_agenda_colaborador_pausa ";
        $sql.="       ,dt_inicio_pausa ";
        $sql.="       ,dt_fim_pausa ";
        $sql.="       ,motivos_pausas_pk ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,turnos_pk ";
        $sql.="       ,colaborador_substituto_pk";
        $sql.="       ,motivo_folga_pk";
        $sql.="       ,ds_obs_folga";

        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_agenda_colaborador_pausa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
