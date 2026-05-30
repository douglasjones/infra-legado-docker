<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/agenda_colaborador_tarefa_itens.class.php';


class agenda_colaborador_tarefa_itensdao{

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
    
    public function salvar($agenda_colaborador_tarefa_itens){
    
        $fields = array();
        $fields['agenda_colaborador_tarefa_pk'] = $agenda_colaborador_tarefa_itens->getagenda_colaborador_tarefa_pk();
        $fields['tarefas_area_pk'] = $agenda_colaborador_tarefa_itens->gettarefas_area_pk();
        $fields['tarefas_tipos_servicos_pk'] = $agenda_colaborador_tarefa_itens->gettarefas_tipos_servicos_pk();
        $fields['ic_dom'] = $agenda_colaborador_tarefa_itens->getic_dom();
        $fields['ic_seg'] = $agenda_colaborador_tarefa_itens->getic_seg();
        $fields['ic_ter'] = $agenda_colaborador_tarefa_itens->getic_ter();
        $fields['ic_qua'] = $agenda_colaborador_tarefa_itens->getic_qua();
        $fields['ic_qui'] = $agenda_colaborador_tarefa_itens->getic_qui();
        $fields['ic_sex'] = $agenda_colaborador_tarefa_itens->getic_sex();
        $fields['ic_sab'] = $agenda_colaborador_tarefa_itens->getic_sab();
        $fields['obs'] = $agenda_colaborador_tarefa_itens->getobs();
        if($agenda_colaborador_tarefa_itens->getdt_ini_execucao()==1){
            //$fields['dt_ini_execucao'] = $agenda_colaborador_tarefa_itens->getdt_ini_execucao();
            $fields['dt_ini_execucao'] = "sysdate()";
        }
        if($agenda_colaborador_tarefa_itens->getdt_fim_execucao()){
            //$fields['dt_fim_execucao'] = $agenda_colaborador_tarefa_itens->getdt_fim_execucao();
            $fields['dt_fim_execucao'] = "sysdate()";
        }
        
        $fields['colaborador_pk'] = $agenda_colaborador_tarefa_itens->getcolaborador_pk();
        $fields['obs_execucao'] = $agenda_colaborador_tarefa_itens->getobs_execucao();
        $fields['tarefas_local_pk'] = $agenda_colaborador_tarefa_itens->gettarefas_local_pk();
        $fields['ds_qrcode'] = $agenda_colaborador_tarefa_itens->getds_qrcode();
        $fields['hr_ini_dom'] = $agenda_colaborador_tarefa_itens->gethr_ini_dom();
        $fields['hr_ini_seg'] = $agenda_colaborador_tarefa_itens->gethr_ini_seg();
        $fields['hr_ini_ter'] = $agenda_colaborador_tarefa_itens->gethr_ini_ter();
        $fields['hr_ini_qua'] = $agenda_colaborador_tarefa_itens->gethr_ini_qua();
        $fields['hr_ini_qui'] = $agenda_colaborador_tarefa_itens->gethr_ini_qui();
        $fields['hr_ini_sex'] = $agenda_colaborador_tarefa_itens->gethr_ini_sex();
        $fields['hr_ini_sab'] = $agenda_colaborador_tarefa_itens->gethr_ini_sab();
        $fields['hr_fim_dom'] = $agenda_colaborador_tarefa_itens->gethr_fim_dom();
        $fields['hr_fim_seg'] = $agenda_colaborador_tarefa_itens->gethr_fim_seg();
        $fields['hr_fim_ter'] = $agenda_colaborador_tarefa_itens->gethr_fim_ter();
        $fields['hr_fim_qua'] = $agenda_colaborador_tarefa_itens->gethr_fim_qua();
        $fields['hr_fim_qui'] = $agenda_colaborador_tarefa_itens->gethr_fim_qui();
        $fields['hr_fim_sex'] = $agenda_colaborador_tarefa_itens->gethr_fim_sex();
        $fields['hr_fim_sab'] = $agenda_colaborador_tarefa_itens->gethr_fim_sab();

        $fields['ds_tarefa'] = $agenda_colaborador_tarefa_itens->getds_tarefa();  
        
        $fields['colaborador_exec_ini_pk'] = $agenda_colaborador_tarefa_itens->getcolaborador_exec_ini_pk();
        $fields['colaborador_exec_fim_pk'] = $agenda_colaborador_tarefa_itens->getcolaborador_exec_fim_pk();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];


        
        if($agenda_colaborador_tarefa_itens->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("agenda_colaborador_tarefa_itens", $fields);

            return $pk;
        }
        else{

            return $this->db->execUpdate("agenda_colaborador_tarefa_itens", $fields, " pk = ".$agenda_colaborador_tarefa_itens->getpk());
            
          
        }

    }

    public function excluir($agenda_colaborador_tarefa_itens){
        $this->db->execDelete("agenda_colaborador_tarefa_itens"," pk = ".$agenda_colaborador_tarefa_itens->getpk());

    }

    public function carregarPorPk($pk){

        $agenda_colaborador_tarefa_itens = new agenda_colaborador_tarefa_itens();
        if($pk != ""){            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";
        $sql.="       ,agenda_colaborador_tarefa_pk ";
        $sql.="       ,tarefas_area_pk ";
        $sql.="       ,tarefas_tipos_servicos_pk ";
        $sql.="       ,ic_dom ";
        $sql.="       ,ic_seg ";
        $sql.="       ,ic_ter ";
        $sql.="       ,ic_qua ";
        $sql.="       ,ic_qui ";
        $sql.="       ,ic_sex ";
        $sql.="       ,ic_sab ";
        $sql.="       ,obs ";
        $sql.="       ,dt_ini_execucao ";
        $sql.="       ,dt_fim_execucao ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,obs_execucao ";
        $sql.="       ,tarefas_local_pk ";
        $sql.="       ,ds_qrcode ";
        $sql.="       ,hr_ini_dom ";
        $sql.="       ,hr_ini_seg ";
        $sql.="       ,hr_ini_ter ";
        $sql.="       ,hr_ini_qua ";
        $sql.="       ,hr_ini_qui ";
        $sql.="       ,hr_ini_sex ";
        $sql.="       ,hr_ini_sab ";
        $sql.="       ,hr_fim_dom ";
        $sql.="       ,hr_fim_seg ";
        $sql.="       ,hr_fim_ter ";
        $sql.="       ,hr_fim_qua ";
        $sql.="       ,hr_fim_qui ";
        $sql.="       ,hr_fim_sex ";
        $sql.="       ,hr_fim_sab ";

        $sql.="  from agenda_colaborador_tarefa_itens ";
        $sql.=" where pk = $pk ";

            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $agenda_colaborador_tarefa_itens->setpk($query[$i]["pk"]);
                $agenda_colaborador_tarefa_itens->setdt_cadastro($query[$i]["dt_cadastro"]);
                $agenda_colaborador_tarefa_itens->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $agenda_colaborador_tarefa_itens->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $agenda_colaborador_tarefa_itens->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $agenda_colaborador_tarefa_itens->setagenda_colaborador_tarefa_pk($query[$i]['agenda_colaborador_tarefa_pk']);
                $agenda_colaborador_tarefa_itens->settarefas_area_pk($query[$i]['tarefas_area_pk']);
                $agenda_colaborador_tarefa_itens->settarefas_tipos_servicos_pk($query[$i]['tarefas_tipos_servicos_pk']);
                $agenda_colaborador_tarefa_itens->setic_dom($query[$i]['ic_dom']);
                $agenda_colaborador_tarefa_itens->setic_seg($query[$i]['ic_seg']);
                $agenda_colaborador_tarefa_itens->setic_ter($query[$i]['ic_ter']);
                $agenda_colaborador_tarefa_itens->setic_qua($query[$i]['ic_qua']);
                $agenda_colaborador_tarefa_itens->setic_qui($query[$i]['ic_qui']);
                $agenda_colaborador_tarefa_itens->setic_sex($query[$i]['ic_sex']);
                $agenda_colaborador_tarefa_itens->setic_sab($query[$i]['ic_sab']);
                $agenda_colaborador_tarefa_itens->setobs($query[$i]['obs']);
                $agenda_colaborador_tarefa_itens->setdt_ini_execucao($query[$i]['dt_ini_execucao']);
                $agenda_colaborador_tarefa_itens->setdt_fim_execucao($query[$i]['dt_fim_execucao']);
                $agenda_colaborador_tarefa_itens->setcolaborador_pk($query[$i]['colaborador_pk']);
                $agenda_colaborador_tarefa_itens->setobs_execucao($query[$i]['obs_execucao']);
                $agenda_colaborador_tarefa_itens->settarefas_local_pk($query[$i]['tarefas_local_pk']);
                $agenda_colaborador_tarefa_itens->setds_qrcode($query[$i]['ds_qrcode']);
                $agenda_colaborador_tarefa_itens->sethr_ini_dom($query[$i]['hr_ini_dom']);
                $agenda_colaborador_tarefa_itens->sethr_ini_seg($query[$i]['hr_ini_seg']);
                $agenda_colaborador_tarefa_itens->sethr_ini_ter($query[$i]['hr_ini_ter']);
                $agenda_colaborador_tarefa_itens->sethr_ini_qua($query[$i]['hr_ini_qua']);
                $agenda_colaborador_tarefa_itens->sethr_ini_qui($query[$i]['hr_ini_qui']);
                $agenda_colaborador_tarefa_itens->sethr_ini_sex($query[$i]['hr_ini_sex']);
                $agenda_colaborador_tarefa_itens->sethr_ini_sab($query[$i]['hr_ini_sab']);
                $agenda_colaborador_tarefa_itens->sethr_fim_dom($query[$i]['hr_fim_dom']);
                $agenda_colaborador_tarefa_itens->sethr_fim_seg($query[$i]['hr_fim_seg']);
                $agenda_colaborador_tarefa_itens->sethr_fim_ter($query[$i]['hr_fim_ter']);
                $agenda_colaborador_tarefa_itens->sethr_fim_qua($query[$i]['hr_fim_qua']);
                $agenda_colaborador_tarefa_itens->sethr_fim_qui($query[$i]['hr_fim_qui']);
                $agenda_colaborador_tarefa_itens->sethr_fim_sex($query[$i]['hr_fim_sex']);
                $agenda_colaborador_tarefa_itens->sethr_fim_sab($query[$i]['hr_fim_sab']);

            }
        }
        return $agenda_colaborador_tarefa_itens;
    }

    public function listarPkTarefas($agenda_colaborador_tarefa_pk){
        $sql ="";
        $sql.="SELECT agi.pk,";
        $sql.="        agi.ds_tarefa,";
        $sql.="        l.ds_lead,";
        $sql.="        l.pk leads_pk,";
        $sql.="        tl.ds_local,";
        $sql.="        tl.pk tarefas_local_pk,";
        $sql.="        ta.ds_area,";
        $sql.="        ta.pk tarefas_area_pk,";
        $sql.="        c.ds_colaborador,";
        $sql.="        agi.colaborador_pk,";
        $sql.="        tts.ds_tarefa_tipo_servico,";
        $sql.="        agi.tarefas_area_pk,";
        $sql.="        agi.tarefas_tipos_servicos_pk,";
        $sql.="        agi.ic_dom,";
        $sql.="        agi.ic_seg,";
        $sql.="        agi.ic_ter,";
        $sql.="        agi.ic_qua,";
        $sql.="        agi.ic_qui,";
        $sql.="        agi.ic_sex,";
        $sql.="        agi.ic_sab,";
        $sql.="        agi.obs,";
        $sql.="        agi.dt_ini_execucao,";
        $sql.="        agi.dt_fim_execucao,";
        $sql.="        agi.colaborador_pk,";
        $sql.="        agi.obs_execucao,";
        $sql.="        agi.tarefas_local_pk,";
        $sql.="        agi.ds_qrcode,";
        $sql.="        TIME_FORMAT(agi.hr_ini_dom, '%H:%i') hr_ini_dom,";
        $sql.="        TIME_FORMAT(agi.hr_ini_seg, '%H:%i') hr_ini_seg,";
        $sql.="        TIME_FORMAT(agi.hr_ini_ter, '%H:%i') hr_ini_ter,";
        $sql.="        TIME_FORMAT(agi.hr_ini_qua, '%H:%i') hr_ini_qua,";
        $sql.="        TIME_FORMAT(agi.hr_ini_qui, '%H:%i') hr_ini_qui,";
        $sql.="        TIME_FORMAT(agi.hr_ini_sex, '%H:%i') hr_ini_sex,";
        $sql.="        TIME_FORMAT(agi.hr_ini_sab, '%H:%i') hr_ini_sab,";
        $sql.="        TIME_FORMAT(agi.hr_fim_dom, '%H:%i') hr_fim_dom,";
        $sql.="        TIME_FORMAT(agi.hr_fim_seg, '%H:%i') hr_fim_seg,";
        $sql.="        TIME_FORMAT(agi.hr_fim_ter, '%H:%i') hr_fim_ter,";
        $sql.="        TIME_FORMAT(agi.hr_fim_qua, '%H:%i') hr_fim_qua,";
        $sql.="        TIME_FORMAT(agi.hr_fim_qui, '%H:%i') hr_fim_qui,";
        $sql.="        TIME_FORMAT(agi.hr_fim_sex, '%H:%i') hr_fim_sex,";
        $sql.="        TIME_FORMAT(agi.hr_fim_sab, '%H:%i') hr_fim_sab";
        $sql.=" FROM agenda_colaborador_tarefa_itens agi";
        $sql.="      INNER JOIN tarefas_local tl ON agi.tarefas_local_pk = tl.pk";
        $sql.="      INNER JOIN leads l ON tl.leads_pk = l.pk";
        $sql.="      INNER JOIN tarefas_area ta ON agi.tarefas_area_pk = ta.pk";
        $sql.="      LEFT JOIN colaboradores c ON agi.colaborador_pk = c.pk";
        $sql.="      INNER JOIN tarefas_tipos_servicos tts ON agi.tarefas_tipos_servicos_pk = tts.pk";
        $sql.=" WHERE agi.agenda_colaborador_tarefa_pk =".$agenda_colaborador_tarefa_pk;

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarAgendaTarefas($agenda_colaborador_tarefa_pk){
        $sql ="";
        $sql.="SELECT agi.pk,";
        $sql.="        agi.agenda_colaborador_tarefa_pk,";
        $sql.="        agi.ds_tarefa,";
        $sql.="        l.ds_lead,";
        $sql.="        l.pk leads_pk,";
        $sql.="        tl.ds_local,";
        $sql.="        tl.pk tarefas_local_pk,";
        $sql.="        ta.ds_area,";
        $sql.="        ta.pk tarefas_area_pk,";
        $sql.="        c.ds_colaborador,";
        $sql.="        agi.colaborador_pk,";
        $sql.="        tts.ds_tarefa_tipo_servico,";
        $sql.="        agi.tarefas_area_pk,";
        $sql.="        agi.tarefas_tipos_servicos_pk,";
        $sql.="        agi.ic_dom,";
        $sql.="        agi.ic_seg,";
        $sql.="        agi.ic_ter,";
        $sql.="        agi.ic_qua,";
        $sql.="        agi.ic_qui,";
        $sql.="        agi.ic_sex,";
        $sql.="        agi.ic_sab,";
        $sql.="        agi.obs,";
        $sql.="        agi.dt_ini_execucao,";
        $sql.="        agi.dt_fim_execucao,";
        $sql.="        agi.colaborador_pk,";
        $sql.="        agi.obs_execucao,";
        $sql.="        agi.tarefas_local_pk,";
        $sql.="        agi.ds_qrcode,";
        $sql.="        TIME_FORMAT(agi.hr_ini_dom, '%H:%i') hr_ini_dom,";
        $sql.="        TIME_FORMAT(agi.hr_ini_seg, '%H:%i') hr_ini_seg,";
        $sql.="        TIME_FORMAT(agi.hr_ini_ter, '%H:%i') hr_ini_ter,";
        $sql.="        TIME_FORMAT(agi.hr_ini_qua, '%H:%i') hr_ini_qua,";
        $sql.="        TIME_FORMAT(agi.hr_ini_qui, '%H:%i') hr_ini_qui,";
        $sql.="        TIME_FORMAT(agi.hr_ini_sex, '%H:%i') hr_ini_sex,";
        $sql.="        TIME_FORMAT(agi.hr_ini_sab, '%H:%i') hr_ini_sab,";
        $sql.="        TIME_FORMAT(agi.hr_fim_dom, '%H:%i') hr_fim_dom,";
        $sql.="        TIME_FORMAT(agi.hr_fim_seg, '%H:%i') hr_fim_seg,";
        $sql.="        TIME_FORMAT(agi.hr_fim_ter, '%H:%i') hr_fim_ter,";
        $sql.="        TIME_FORMAT(agi.hr_fim_qua, '%H:%i') hr_fim_qua,";
        $sql.="        TIME_FORMAT(agi.hr_fim_qui, '%H:%i') hr_fim_qui,";
        $sql.="        TIME_FORMAT(agi.hr_fim_sex, '%H:%i') hr_fim_sex,";
        $sql.="        TIME_FORMAT(agi.hr_fim_sab, '%H:%i') hr_fim_sab";
        $sql.=" FROM agenda_colaborador_tarefa_itens agi";
        $sql.="      INNER JOIN tarefas_local tl ON agi.tarefas_local_pk = tl.pk";
        $sql.="      INNER JOIN leads l ON tl.leads_pk = l.pk";
        $sql.="      INNER JOIN tarefas_area ta ON agi.tarefas_area_pk = ta.pk";
        $sql.="      LEFT JOIN colaboradores c ON agi.colaborador_pk = c.pk";
        $sql.="      INNER JOIN tarefas_tipos_servicos tts ON agi.tarefas_tipos_servicos_pk = tts.pk";   
        
        $sql.=" WHERE 1=1";
        
        //$sql.=" WHERE agi.agenda_colaborador_tarefa_pk =".$agenda_colaborador_tarefa_pk;
        
        $sql.=" Group by l.pk,tl.pk";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    
    public function listarPorPk($pk){

        $sql ="";
        $sql.="SELECT agi.pk,";
        $sql.="        agi.ds_tarefa,";
        $sql.="        l.ds_lead,";
        $sql.="        l.pk leads_pk,";
        $sql.="        tl.ds_local,";
        $sql.="        tl.pk tarefas_local_pk,";
        $sql.="        ta.ds_area,";
        $sql.="        ta.pk tarefas_area_pk,";
        $sql.="        c.ds_colaborador,";
        $sql.="        agi.colaborador_pk,";
        $sql.="        tts.ds_tarefa_tipo_servico,";
        $sql.="        agi.tarefas_area_pk,";
        $sql.="        agi.tarefas_tipos_servicos_pk,";
        $sql.="        agi.ic_dom,";
        $sql.="        agi.ic_seg,";
        $sql.="        agi.ic_ter,";
        $sql.="        agi.ic_qua,";
        $sql.="        agi.ic_qui,";
        $sql.="        agi.ic_sex,";
        $sql.="        agi.ic_sab,";
        $sql.="        agi.obs,";
        $sql.="        date_format(agi.dt_ini_execucao, '%d/%m/%Y %H:%i')dt_ini_execucao,";
        $sql.="        date_format(agi.dt_fim_execucao, '%d/%m/%Y %H:%i')dt_fim_execucao,";
        $sql.="        agi.colaborador_pk,";
        $sql.="        agi.obs_execucao,";
        $sql.="        agi.tarefas_local_pk,";
        $sql.="        agi.ds_qrcode,";
        $sql.="        TIME_FORMAT(agi.hr_ini_dom, '%H:%i') hr_ini_dom,";
        $sql.="        TIME_FORMAT(agi.hr_ini_seg, '%H:%i') hr_ini_seg,";
        $sql.="        TIME_FORMAT(agi.hr_ini_ter, '%H:%i') hr_ini_ter,";
        $sql.="        TIME_FORMAT(agi.hr_ini_qua, '%H:%i') hr_ini_qua,";
        $sql.="        TIME_FORMAT(agi.hr_ini_qui, '%H:%i') hr_ini_qui,";
        $sql.="        TIME_FORMAT(agi.hr_ini_sex, '%H:%i') hr_ini_sex,";
        $sql.="        TIME_FORMAT(agi.hr_ini_sab, '%H:%i') hr_ini_sab,";
        $sql.="        TIME_FORMAT(agi.hr_fim_dom, '%H:%i') hr_fim_dom,";
        $sql.="        TIME_FORMAT(agi.hr_fim_seg, '%H:%i') hr_fim_seg,";
        $sql.="        TIME_FORMAT(agi.hr_fim_ter, '%H:%i') hr_fim_ter,";
        $sql.="        TIME_FORMAT(agi.hr_fim_qua, '%H:%i') hr_fim_qua,";
        $sql.="        TIME_FORMAT(agi.hr_fim_qui, '%H:%i') hr_fim_qui,";
        $sql.="        TIME_FORMAT(agi.hr_fim_sex, '%H:%i') hr_fim_sex,";
        $sql.="        TIME_FORMAT(agi.hr_fim_sab, '%H:%i') hr_fim_sab";
        $sql.=" FROM agenda_colaborador_tarefa_itens agi";
        $sql.="      INNER JOIN tarefas_local tl ON agi.tarefas_local_pk = tl.pk";
        $sql.="      INNER JOIN leads l ON tl.leads_pk = l.pk";
        $sql.="      INNER JOIN tarefas_area ta ON agi.tarefas_area_pk = ta.pk";
        $sql.="      LEFT JOIN colaboradores c ON agi.colaborador_pk = c.pk";
        $sql.="      INNER JOIN tarefas_tipos_servicos tts ON agi.tarefas_tipos_servicos_pk = tts.pk";
        $sql.=" WHERE agi.pk=".$pk;
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_agenda_colaborador_tarefa_pk($agenda_colaborador_tarefa_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,agenda_colaborador_tarefa_pk ";
        $sql.="       ,tarefas_area_pk ";
        $sql.="       ,tarefas_tipos_servicos_pk ";
        $sql.="       ,ic_dom ";
        $sql.="       ,ic_seg ";
        $sql.="       ,ic_ter ";
        $sql.="       ,ic_qua ";
        $sql.="       ,ic_qui ";
        $sql.="       ,ic_sex ";
        $sql.="       ,ic_sab ";
        $sql.="       ,obs ";
        $sql.="       ,dt_ini_execucao ";
        $sql.="       ,dt_fim_execucao ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,obs_execucao ";
        $sql.="       ,tarefas_local_pk ";
        $sql.="       ,ds_qrcode ";
        $sql.="       ,hr_ini_dom ";
        $sql.="       ,hr_ini_seg ";
        $sql.="       ,hr_ini_ter ";
        $sql.="       ,hr_ini_qua ";
        $sql.="       ,hr_ini_qui ";
        $sql.="       ,hr_ini_sex ";
        $sql.="       ,hr_ini_sab ";
        $sql.="       ,hr_fim_dom ";
        $sql.="       ,hr_fim_seg ";
        $sql.="       ,hr_fim_ter ";
        $sql.="       ,hr_fim_qua ";
        $sql.="       ,hr_fim_qui ";
        $sql.="       ,hr_fim_sex ";
        $sql.="       ,hr_fim_sab ";

        $sql.="  from agenda_colaborador_tarefa_itens ";
        $sql.=" where 1=1 ";
        if($agenda_colaborador_tarefa_pk != ""){
            $sql.=" and ds_agenda_colaborador_tarefa_itens like '%".$agenda_colaborador_tarefa_pk."%' ";
        }
        $sql.=" order by agenda_colaborador_tarefa_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,agenda_colaborador_tarefa_pk ";
        $sql.="       ,tarefas_area_pk ";
        $sql.="       ,tarefas_tipos_servicos_pk ";
        $sql.="       ,ic_dom ";
        $sql.="       ,ic_seg ";
        $sql.="       ,ic_ter ";
        $sql.="       ,ic_qua ";
        $sql.="       ,ic_qui ";
        $sql.="       ,ic_sex ";
        $sql.="       ,ic_sab ";
        $sql.="       ,obs ";
        $sql.="       ,dt_ini_execucao ";
        $sql.="       ,dt_fim_execucao ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,obs_execucao ";
        $sql.="       ,tarefas_local_pk ";
        $sql.="       ,ds_qrcode ";
        $sql.="       ,hr_ini_dom ";
        $sql.="       ,hr_ini_seg ";
        $sql.="       ,hr_ini_ter ";
        $sql.="       ,hr_ini_qua ";
        $sql.="       ,hr_ini_qui ";
        $sql.="       ,hr_ini_sex ";
        $sql.="       ,hr_ini_sab ";
        $sql.="       ,hr_fim_dom ";
        $sql.="       ,hr_fim_seg ";
        $sql.="       ,hr_fim_ter ";
        $sql.="       ,hr_fim_qua ";
        $sql.="       ,hr_fim_qui ";
        $sql.="       ,hr_fim_sex ";
        $sql.="       ,hr_fim_sab ";

        $sql.="  from agenda_colaborador_tarefa_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by agenda_colaborador_tarefa_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
