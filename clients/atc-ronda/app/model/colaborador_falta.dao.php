<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/colaborador_falta.class.php';


class colaborador_faltadao{

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
    
    public function salvar($colaborador_falta){

        $fields = array();
        $fields['motivo_falta_pk'] = $colaborador_falta->getmotivo_falta_pk();
        $fields['obs'] = $colaborador_falta->getobs();
        $fields['colaborador_pk'] = $colaborador_falta->getcolaborador_pk();
        $fields['dt_escala'] = $colaborador_falta->getdt_escala();
        $fields['leads_pk'] = $colaborador_falta->getleads_pk();
        $fields['colaborador_reserva_pk'] = $colaborador_falta->getcolaborador_reserva_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($colaborador_falta->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("colaboradores_faltas", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("colaboradores_faltas", $fields, " pk = ".$colaborador_falta->getpk());
        }

    }

    public function excluir($colaborador_falta){
        $this->db->execDelete("colaboradores_faltas"," pk = ".$colaborador_falta->getpk());
    }
    public function excluirColaborador($pk){
        $this->db->execDelete("colaboradores_faltas"," pk = ".$pk);
    }

    public function carregarPorPk($pk){

        $colaborador_falta = new colaborador_falta();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,motivo_falta_pk ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,leads_pk ";


        $sql.="  from colaboradores_faltas ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $colaborador_falta->setpk($query[$i]["pk"]);
                $colaborador_falta->setdt_cadastro($query[$i]["dt_cadastro"]);
                $colaborador_falta->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $colaborador_falta->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $colaborador_falta->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $colaborador_falta->setmotivo_falta_pk($query[$i]['motivo_falta_pk']);
                $colaborador_falta->setobs($query[$i]['obs']);
                $colaborador_falta->setcolaborador_pk($query[$i]['colaborador_pk']);
                $colaborador_falta->setdt_escala($query[$i]['dt_escala']);
                $colaborador_falta->setleads_pk($query[$i]['leads_pk']);

            }
        }
        return $colaborador_falta;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,motivo_falta_pk ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,leads_pk ";

        $sql.="  from colaboradores_faltas ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RelatorioFalta($dt_inicio,$dt_fim,$colaboradores_pk,$leads_pk){

        $sql ="";
        $sql.="select cf.pk, cf.dt_cadastro, cf.usuario_cadastro_pk, cf.dt_ult_atualizacao, cf.usuario_ult_atualizacao_pk  ";
        $sql.="       ,case cf.motivo_falta_pk when 1 then 'Falta sem Justificativa' when 2 then 'Atestado' when 3 then 'Reciclagem' when 4 then 'Posto Vago' when 5 then 'Remanejamento' end ds_motivo_falta";
        $sql.="       ,cf.obs ";
        $sql.="       ,cf.colaborador_pk ";
        $sql.="       ,date_format(cf.dt_escala,'%d/%m/%Y')dt_escala";
        $sql.="       ,cf.leads_pk ";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,l.ds_lead";

        $sql.="  from colaboradores_faltas cf";
        $sql.="       inner join leads l on l.pk = cf.leads_pk";
        $sql.="       inner join colaboradores c on c.pk = cf.colaborador_pk";
        $sql.=" where 1=1";
        if($dt_inicio!=""){
            $sql.=" and cf.dt_escala between '".DataYMD($dt_inicio)."' and '".DataYMD($dt_fim)."'";
        }
        if($leads_pk!=""){
            $sql.=" and l.pk =".$leads_pk;
        }
        if($colaboradores_pk!=""){
            $sql.=" and c.pk =".$colaboradores_pk;
        }
        $sql.=" group by cf.dt_escala, cf.colaborador_pk";
        $sql.=" order by cf.dt_escala asc";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function verificarEscala($dt_inicio,$dt_fim,$colaboradores_pk,$leads_pk,$dia_semana){

        $sql ="";
        $sql.="select acp.colaboradores_pk,l.ds_lead,c.ds_colaborador";
        $sql.="        from agenda_colaborador_padrao acp";
        $sql.="        inner join processos_etapas pe on acp.processos_etapas_pk = pe.pk";
        $sql.="        inner join processos p on pe.processos_pk = p.pk";
        $sql.="        inner join leads l on p.leads_pk = l.pk";
        $sql.="        inner join colaboradores c on c.pk = acp.colaboradores_pk";
        if($dt_inicio!=""){
            
            $sql.=" AND acp.dt_inicio_agenda <= '".DataYMD($dt_inicio)."'";
            $sql.=" AND acp.dt_fim_agenda >= '".DataYMD($dt_fim)."'";
        }
        if($leads_pk!=""){
            $sql.=" and l.pk =".$leads_pk;
        }
        if($colaboradores_pk!=""){
            $sql.=" and acp.colaboradores_pk =".$colaboradores_pk;
        }
        if($dia_semana==0){
            $sql.=" and acp.ic_dom =1";
        }
        else if($dia_semana==1){
            $sql.=" and acp.ic_seg =1";
        }
        else if($dia_semana==2){
            $sql.=" and acp.ic_ter = 1";
        }
        else if($dia_semana==3){
            $sql.=" and acp.ic_qua = 1";
        }
        else if($dia_semana==4){
            $sql.=" and acp.ic_qui = 1";
        }
        else if($dia_semana==5){
            $sql.=" and acp.ic_sex = 1";
        }
        else if($dia_semana==6){
            $sql.=" and acp.ic_sab = 1";
        }
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function verificarPonto($dt_inicio,$dt_fim,$colaboradores_pk){

        $sql ="";
        $sql.="select c.ds_colaborador";
        $sql.="        from ponto p ";
        $sql.="        inner join colaboradores c on p.colaborador_pk = c.pk";
        if($dt_inicio!=""){
            $sql.=" AND p.dt_hora_ponto between '".DataYMD($dt_inicio)." 00:00:00' and '".DataYMD($dt_fim)." 23:59:59'";
        }
        if($colaboradores_pk!=""){
            $sql.=" and p.colaborador_pk =".$colaboradores_pk;
        }
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarFaltaColaborador($colaborador_pk,$dt_escala){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,motivo_falta_pk ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,leads_pk ";

        $sql.="  from colaboradores_faltas ";
        $sql.=" where 1=1";
        $sql.=" and colaborador_pk = ".$colaborador_pk;
        $sql.=" and dt_escala= '".DataYMD($dt_escala)."'";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RelatorioPostoTrabalhoXColaboradorReserva($colaborador_pk,$leads_pk,$dt_escala_ini,$dt_escala_fim){

        $sql ="";
        $sql.="select cf.pk, cf.dt_cadastro, cf.usuario_cadastro_pk, cf.dt_ult_atualizacao, cf.usuario_ult_atualizacao_pk  ";
        $sql.="       ,cf.motivo_falta_pk ";
        $sql.="       ,cf.obs ";
        $sql.="       ,cf.colaborador_pk ";
        $sql.="       ,date_format(cf.dt_escala,'%d/%m/%Y')dt_escala ";
        $sql.="       ,cf.leads_pk ";
        $sql.="       ,ps.ds_produto_servico ";
        $sql.="       ,l.ds_lead";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,cr.ds_colaborador ds_colaborador_reserva";

        $sql.="  from colaboradores_faltas cf";
        $sql.="       inner join colaboradores c on cf.colaborador_pk = c.pk";
        $sql.="       inner join colaboradores_produtos_servicos cps on c.pk = cps.colaboradores_pk";
        $sql.="       inner join produtos_servicos ps on cps.produtos_servicos_pk = ps.pk";
        $sql.="       inner join colaboradores cr on cf.colaborador_reserva_pk = cr.pk";
        $sql.="       inner join leads l on cf.leads_pk = l.pk";
        $sql.=" where 1=1";
        if($colaborador_pk!=""){
            $sql.=" and cf.colaborador_reserva_pk = ".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and cf.leads_pk = ".$leads_pk;
        }
        if($dt_escala_ini!=""){
            $sql.=" and cf.dt_escala between '".DataYMD($dt_escala_ini)."' and '".DataYMD($dt_escala_fim)."'";
        }
      
        echo $sql;
        exit;
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function carregarPorColaboradorPk($colaborador_pk,$dt_escala,$leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,motivo_falta_pk ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,leads_pk ";

        $sql.="  from colaboradores_faltas ";
        $sql.=" where 1=1";
        $sql.=" and colaborador_pk = ".$colaborador_pk;
        if($leads_pk!=""){
            $sql.=" and leads_pk = ".$leads_pk;
        }
        $sql.=" and dt_escala= '".DataYMD($dt_escala)."'";
       
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_motivo_falta_pk($motivo_falta_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,motivo_falta_pk ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,leads_pk ";

        $sql.="  from colaboradores_faltas ";
        $sql.=" where 1=1 ";
        if($motivo_falta_pk != ""){
            $sql.=" and ds_colaborador_falta like '%".$motivo_falta_pk."%' ";
        }
        $sql.=" order by motivo_falta_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarFaltaParaPonto($dt_ini,$colaborador_pk,$leads_pk){

        $sql ="";
        $sql.="select cf.pk, cf.dt_cadastro, cf.usuario_cadastro_pk, cf.dt_ult_atualizacao, cf.usuario_ult_atualizacao_pk ";
        $sql.="       ,cf.motivo_falta_pk ";
        $sql.="       ,cf.obs ";
        $sql.="       ,cf.colaborador_pk ";
        $sql.="       ,cf.dt_escala ";
        $sql.="       ,cf.leads_pk ";
        $sql.="       ,c.ds_colaborador";

        $sql.="  from colaboradores_faltas cf";
        $sql.="        left join colaboradores c on cf.colaborador_reserva_pk = c.pk";
        $sql.=" where 1=1 ";
        if($colaborador_pk!=""){
            $sql.=" and cf.colaborador_pk =".$colaborador_pk;
        }
        if($dt_ini!=""){
            $sql.=" and cf.dt_escala ='".DataYMD($dt_ini)."'";
        }
        if($leads_pk!=""){
            $sql.=" and cf.leads_pk = ".$leads_pk;
        }
        $sql.=" group by cf.dt_escala";
        //echo $sql."<br>";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarFeriasParaPonto($dt_ini,$colaborador_pk,$leads_pk){

        $sql ="";
        $sql.="select c.ds_colaborador, date_format(a.dt_inicio_pausa,'%d/%m/%Y')dt_inicio_pausa";

        $sql.="  from agenda_colaborador_pausa a";
        $sql.="        left join colaboradores c on a.colaborador_substituto_pk = c.pk";
        $sql.=" where 1=1 ";
        $sql.=" and a.ds_agenda_colaborador_pausa = 'Férias'";
        if($colaborador_pk!=""){
            $sql.=" and a.colaboradores_pk =".$colaborador_pk;
        }
        if($dt_ini!=""){
            $sql.=" and a.dt_inicio_pausa ='".DataYMD($dt_ini)."'";
        }
        
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarAfastamentoParaPonto($dt_ini,$colaborador_pk,$leads_pk){

        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,dt_inicio ";
        $sql.="       ,dt_fim ";
        $sql.="       ,tipo_apontamento ";
        $sql.="       ,ds_obs ";

        $sql.="  from afastamento_ferias_colaborador ";
        $sql.=" where 1=1";
        $sql.=" and tipo_apontamento = 1";
        if($colaborador_pk!=""){
            $sql.=" and colaborador_pk = ".$colaborador_pk;
        }
        
        if($dt_ini!=""){
            $sql.=" and dt_inicio = '".DataYMD($dt_ini)."'";
        }
        
        
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarAtestadoParaPonto($dt_ini,$colaborador_pk,$leads_pk){

        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,dt_inicio ";
        $sql.="       ,dt_fim ";
        $sql.="       ,tipo_apontamento ";
        $sql.="       ,ds_obs ";

        $sql.="  from afastamento_ferias_colaborador ";
        $sql.=" where 1=1";
        $sql.=" and tipo_apontamento = 2";
        if($colaborador_pk!=""){
            $sql.=" and colaborador_pk = ".$colaborador_pk;
        }
        
        if($dt_ini!=""){
            $sql.=" and dt_inicio = '".DataYMD($dt_ini)."'";
        }
        
        
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,motivo_falta_pk ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,leads_pk ";

        $sql.="  from colaboradores_faltas ";
        $sql.=" where 1=1 ";
        $sql.=" order by motivo_falta_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
