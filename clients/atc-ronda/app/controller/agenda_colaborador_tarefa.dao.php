<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/agenda_colaborador_tarefa.class.php';


class agenda_colaborador_tarefadao{

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
    
    public function salvar($agenda_colaborador_tarefa){

        $fields = array();
        $fields['ds_tarefa'] = $agenda_colaborador_tarefa->getds_tarefa();
        $fields['obs_tarefa'] = $agenda_colaborador_tarefa->getobs_tarefa();
        $fields['hr_inicio'] = $agenda_colaborador_tarefa->gethr_inicio();
       
        if($agenda_colaborador_tarefa->getdt_termino()==1){
            $fields['dt_termino'] = "sysdate()";
             $fields['usuario_termino_pk'] = $this->arrToken['usuarios_pk'];
        }
        
        $fields['obs_termino_tarefa'] = $agenda_colaborador_tarefa->getobs_termino_tarefa();
        $fields['dt_alteracao_tarefa'] = $agenda_colaborador_tarefa->getdt_alteracao_tarefa();
        $fields['ic_dia'] = $agenda_colaborador_tarefa->getic_dia();
        $fields['agendas_pk'] = $agenda_colaborador_tarefa->getagendas_pk();
        $fields['ic_tarefa_recorrente'] = $agenda_colaborador_tarefa->getic_tarefa_recorrente();
        if($agenda_colaborador_tarefa->getdt_execucao()!=""){
             $fields['dt_execucao'] = DataYMD($agenda_colaborador_tarefa->getdt_execucao());
        }
       


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($agenda_colaborador_tarefa->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("agenda_colaborador_tarefa", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("agenda_colaborador_tarefa", $fields, " pk = ".$agenda_colaborador_tarefa->getpk());
        }

    }

    public function excluir($agenda_colaborador_tarefa){
        $this->db->execDelete("agenda_colaborador_tarefa"," pk = ".$agenda_colaborador_tarefa->getpk());
    }

    public function carregarPorPk($pk){

        $agenda_colaborador_tarefa = new agenda_colaborador_tarefa();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_tarefa ";
        $sql.="       ,obs_tarefa ";
        $sql.="       ,hr_inicio ";
        $sql.="       ,usuario_termino_pk ";
        $sql.="       ,dt_termino ";
        $sql.="       ,obs_termino_tarefa ";
        $sql.="       ,dt_alteracao_tarefa ";
        $sql.="       ,ic_dia ";
        $sql.="       ,agendas_pk ";
        $sql.="       ,ic_tarefa_recorrente";
        $sql.="       ,dt_execucao";


        $sql.="  from agenda_colaborador_tarefa ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $agenda_colaborador_tarefa->setpk($query[$i]["pk"]);
                $agenda_colaborador_tarefa->setdt_cadastro($query[$i]["dt_cadastro"]);
                $agenda_colaborador_tarefa->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $agenda_colaborador_tarefa->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $agenda_colaborador_tarefa->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $agenda_colaborador_tarefa->setds_tarefa($query[$i]['ds_tarefa']);
                $agenda_colaborador_tarefa->setobs_tarefa($query[$i]['obs_tarefa']);
                $agenda_colaborador_tarefa->sethr_inicio($query[$i]['hr_inicio']);
                $agenda_colaborador_tarefa->setusuario_termino_pk($query[$i]['usuario_termino_pk']);
                $agenda_colaborador_tarefa->setdt_termino($query[$i]['dt_termino']);
                $agenda_colaborador_tarefa->setobs_termino_tarefa($query[$i]['obs_termino_tarefa']);
                $agenda_colaborador_tarefa->setdt_alteracao_tarefa($query[$i]['dt_alteracao_tarefa']);
                $agenda_colaborador_tarefa->setic_dia($query[$i]['ic_dia']);
                $agenda_colaborador_tarefa->setagendas_pk($query[$i]['agendas_pk']);
                $agenda_colaborador_tarefa->setic_tarefa_recorrente($query[$i]['ic_tarefa_recorrente']);
                $agenda_colaborador_tarefa->setdt_execucao($query[$i]['dt_execucao']);

            }
        }
        return $agenda_colaborador_tarefa;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_tarefa ";
        $sql.="       ,obs_tarefa ";
        $sql.="       ,hr_inicio ";
        $sql.="       ,usuario_termino_pk ";
        $sql.="       ,dt_termino ";
        $sql.="       ,obs_termino_tarefa ";
        $sql.="       ,dt_alteracao_tarefa ";
        $sql.="       ,ic_dia ";
        $sql.="       ,agendas_pk ";
        $sql.="       ,ic_tarefa_recorrente";
        $sql.="       ,dt_execucao";

        $sql.="  from agenda_colaborador_tarefa ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_tarefa($ds_tarefa){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_tarefa ";
        $sql.="       ,obs_tarefa ";
        $sql.="       ,hr_inicio ";
        $sql.="       ,usuario_termino_pk ";
        $sql.="       ,dt_termino ";
        $sql.="       ,obs_termino_tarefa ";
        $sql.="       ,dt_alteracao_tarefa ";
        $sql.="       ,ic_dia ";
        $sql.="       ,agendas_pk ";
        $sql.="       ,ic_tarefa_recorrente";
        $sql.="       ,dt_execucao";

        $sql.="  from agenda_colaborador_tarefa ";
        $sql.=" where 1=1 ";
        if($ds_tarefa != ""){
            $sql.=" and ds_agenda_colaborador_tarefa like '%".$ds_tarefa."%' ";
        }
        $sql.=" order by ds_tarefa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarTarefaPorIcDiaAgenda($agendas_pk,$ic_dia,$dt_execucao){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_tarefa ";
        $sql.="       ,obs_tarefa ";
        $sql.="       ,hr_inicio ";
        $sql.="       ,usuario_termino_pk ";
        $sql.="       ,dt_termino ";
        $sql.="       ,obs_termino_tarefa ";
        $sql.="       ,dt_alteracao_tarefa ";
        $sql.="       ,ic_dia ";
        $sql.="       ,agendas_pk ";
        $sql.="       ,ic_tarefa_recorrente";
        $sql.="       ,date_format(dt_execucao,'%d/%m/%Y')dt_execucao";

        $sql.="  from agenda_colaborador_tarefa ";
        $sql.=" where 1=1 ";
        if($agendas_pk != ""){
            $sql.=" and agendas_pk = ".$agendas_pk;
        }
        if($ic_dia != ""){
            $sql.=" and ic_dia = ".$ic_dia;
        }
        if($dt_execucao != ""){
            $sql.=" and dt_execucao = '".DataYMD($dt_execucao)."'";
        }
        $sql.=" order by ds_tarefa asc ";
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarTarefasColaboradoresPorData($dt_execucao){
        
        $sql ="";
        $sql.="select act.pk, act.dt_cadastro, act.usuario_cadastro_pk, act.dt_ult_atualizacao, act.usuario_ult_atualizacao_pk ";
        $sql.="       ,act.ds_tarefa ";
        $sql.="       ,act.obs_tarefa ";
        $sql.="       ,act.hr_inicio ";
        $sql.="       ,act.usuario_termino_pk ";
        $sql.="       ,act.dt_termino ";
        $sql.="       ,act.obs_termino_tarefa ";
        $sql.="       ,act.dt_alteracao_tarefa ";
        $sql.="       ,act.ic_dia ";
        $sql.="       ,act.agendas_pk ";
        $sql.="       ,act.ic_tarefa_recorrente";
        $sql.="       ,act.dt_execucao";

        $sql.="  from agenda_colaborador_tarefa act";
        $sql.="        inner join agenda_colaborador_padrao acp on acp.pk = act.agendas_pk";
        $sql.=" where 1=1 ";
        if($dt_execucao != ""){
            $sql.=" and act.dt_execucao = '".DataYMD($dt_execucao)."'";
        }
        //$sql.=" and act.dt_termino is null";
        $sql.=" and acp.colaboradores_pk  = ".$this->arrToken['colaboradores_pk'];
        $sql.=" order by ds_tarefa asc ";
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_tarefa ";
        $sql.="       ,obs_tarefa ";
        $sql.="       ,hr_inicio ";
        $sql.="       ,usuario_termino_pk ";
        $sql.="       ,dt_termino ";
        $sql.="       ,obs_termino_tarefa ";
        $sql.="       ,dt_alteracao_tarefa ";
        $sql.="       ,ic_dia ";
        $sql.="       ,agendas_pk ";
        $sql.="       ,ic_tarefa_recorrente";
        $sql.="       ,dt_execucao";

        $sql.="  from agenda_colaborador_tarefa ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_tarefa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarTarefasDia($ds_pin,$lead_posto_pk,$dt_tarefa_dia){        
        $sql ="";
        $sql.="SELECT act.pk,";
        $sql.=" act.dt_execucao,";
        $sql.=" act.ds_tarefa,";
        $sql.=" act.obs_tarefa,";
        $sql.=" act.hr_inicio,";
        $sql.=" act.dt_termino, ";
        $sql.=" act.obs_termino_tarefa ";        
        $sql.=" FROM agenda_colaborador_tarefa act ";
        $sql.=" INNER JOIN agenda_colaborador_padrao acp ON acp.pk = act.agendas_pk ";
        $sql.=" INNER JOIN colaboradores c ON acp.colaboradores_pk - c.pk ";
        $sql.=" WHERE     c.ds_pin ='".$ds_pin."'"; 
        $sql.=" AND act.dt_execucao >= '".DataYMD($dt_tarefa_dia)."'";
        $sql.=" AND act.dt_execucao <= '". DataYMD($dt_tarefa_dia)."'";

        $sql.=" order by act.hr_inicio asc ";
               
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    
    

}

?>
