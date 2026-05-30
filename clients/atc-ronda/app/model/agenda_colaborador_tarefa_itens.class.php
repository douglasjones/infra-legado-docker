<?

class agenda_colaborador_tarefa_itens{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $agenda_colaborador_tarefa_pk;
    private $tarefas_area_pk;
    private $tarefas_tipos_servicos_pk;
    private $ic_dom;
    private $ic_seg;
    private $ic_ter;
    private $ic_qua;
    private $ic_qui;
    private $ic_sex;
    private $ic_sab;
    private $obs;
    private $dt_ini_execucao;
    private $dt_fim_execucao;
    private $colaborador_pk;
    private $obs_execucao;
    private $tarefas_local_pk;
    private $ds_qrcode;
    private $hr_ini_dom;
    private $hr_ini_seg;
    private $hr_ini_ter;
    private $hr_ini_qua;
    private $hr_ini_qui;
    private $hr_ini_sex;
    private $hr_ini_sab;
    private $hr_fim_dom;
    private $hr_fim_seg;
    private $hr_fim_ter;
    private $hr_fim_qua;
    private $hr_fim_qui;
    private $hr_fim_sex;
    private $hr_fim_sab;

    private $ds_tarefa;
    
    private $colaborador_exec_ini_pk;
    private $colaborador_exec_fim_pk;
    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->agenda_colaborador_tarefa_pk = null;
        $this->tarefas_area_pk = null;
        $this->tarefas_tipos_servicos_pk = null;
        $this->ic_dom = null;
        $this->ic_seg = null;
        $this->ic_ter = null;
        $this->ic_qua = null;
        $this->ic_qui = null;
        $this->ic_sex = null;
        $this->ic_sab = null;
        $this->obs = null;
        $this->dt_ini_execucao = null;
        $this->dt_fim_execucao = null;
        $this->colaborador_pk = null;
        $this->obs_execucao = null;
        $this->tarefas_local_pk = null;
        $this->ds_qrcode = null;
        $this->hr_ini_dom = null;
        $this->hr_ini_seg = null;
        $this->hr_ini_ter = null;
        $this->hr_ini_qua = null;
        $this->hr_ini_qui = null;
        $this->hr_ini_sex = null;
        $this->hr_ini_sab = null;
        $this->hr_fim_dom = null;
        $this->hr_fim_seg = null;
        $this->hr_fim_ter = null;
        $this->hr_fim_qua = null;
        $this->hr_fim_qui = null;
        $this->hr_fim_sex = null;
        $this->hr_fim_sab = null;
        $this->ds_tarefa = null;
        $this->colaborador_exec_ini_pk = null;
        $this->colaborador_exec_fim_pk = null;
    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getagenda_colaborador_tarefa_pk(){return $this->agenda_colaborador_tarefa_pk;}
    function gettarefas_area_pk(){return $this->tarefas_area_pk;}
    function gettarefas_tipos_servicos_pk(){return $this->tarefas_tipos_servicos_pk;}
    function getic_dom(){return $this->ic_dom;}
    function getic_seg(){return $this->ic_seg;}
    function getic_ter(){return $this->ic_ter;}
    function getic_qua(){return $this->ic_qua;}
    function getic_qui(){return $this->ic_qui;}
    function getic_sex(){return $this->ic_sex;}
    function getic_sab(){return $this->ic_sab;}
    function getobs(){return $this->obs;}
    function getdt_ini_execucao(){return $this->dt_ini_execucao;}
    function getdt_fim_execucao(){return $this->dt_fim_execucao;}
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getobs_execucao(){return $this->obs_execucao;}
    function gettarefas_local_pk(){return $this->tarefas_local_pk;}
    function getds_qrcode(){return $this->ds_qrcode;}
    function gethr_ini_dom(){return $this->hr_ini_dom;}
    function gethr_ini_seg(){return $this->hr_ini_seg;}
    function gethr_ini_ter(){return $this->hr_ini_ter;}
    function gethr_ini_qua(){return $this->hr_ini_qua;}
    function gethr_ini_qui(){return $this->hr_ini_qui;}
    function gethr_ini_sex(){return $this->hr_ini_sex;}
    function gethr_ini_sab(){return $this->hr_ini_sab;}
    function gethr_fim_dom(){return $this->hr_fim_dom;}
    function gethr_fim_seg(){return $this->hr_fim_seg;}
    function gethr_fim_ter(){return $this->hr_fim_ter;}
    function gethr_fim_qua(){return $this->hr_fim_qua;}
    function gethr_fim_qui(){return $this->hr_fim_qui;}
    function gethr_fim_sex(){return $this->hr_fim_sex;}
    function gethr_fim_sab(){return $this->hr_fim_sab;}
    function getds_tarefa(){return $this->ds_tarefa;}
    function getcolaborador_exec_ini_pk(){return $this->colaborador_exec_ini_pk;}
    function getcolaborador_exec_fim_pk(){return $this->colaborador_exec_fim_pk;}
          
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setagenda_colaborador_tarefa_pk($agenda_colaborador_tarefa_pk){ $this->agenda_colaborador_tarefa_pk = $agenda_colaborador_tarefa_pk;}
    function settarefas_area_pk($tarefas_area_pk){ $this->tarefas_area_pk = $tarefas_area_pk;}
    function settarefas_tipos_servicos_pk($tarefas_tipos_servicos_pk){ $this->tarefas_tipos_servicos_pk = $tarefas_tipos_servicos_pk;}
    function setic_dom($ic_dom){ $this->ic_dom = $ic_dom;}
    function setic_seg($ic_seg){ $this->ic_seg = $ic_seg;}
    function setic_ter($ic_ter){ $this->ic_ter = $ic_ter;}
    function setic_qua($ic_qua){ $this->ic_qua = $ic_qua;}
    function setic_qui($ic_qui){ $this->ic_qui = $ic_qui;}
    function setic_sex($ic_sex){ $this->ic_sex = $ic_sex;}
    function setic_sab($ic_sab){ $this->ic_sab = $ic_sab;}
    function setobs($obs){ $this->obs = $obs;}
    function setdt_ini_execucao($dt_ini_execucao){ $this->dt_ini_execucao = $dt_ini_execucao;}
    function setdt_fim_execucao($dt_fim_execucao){ $this->dt_fim_execucao = $dt_fim_execucao;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setobs_execucao($obs_execucao){ $this->obs_execucao = $obs_execucao;}
    function settarefas_local_pk($tarefas_local_pk){ $this->tarefas_local_pk = $tarefas_local_pk;}
    function setds_qrcode($ds_qrcode){ $this->ds_qrcode = $ds_qrcode;}
    function sethr_ini_dom($hr_ini_dom){ $this->hr_ini_dom = $hr_ini_dom;}
    function sethr_ini_seg($hr_ini_seg){ $this->hr_ini_seg = $hr_ini_seg;}
    function sethr_ini_ter($hr_ini_ter){ $this->hr_ini_ter = $hr_ini_ter;}
    function sethr_ini_qua($hr_ini_qua){ $this->hr_ini_qua = $hr_ini_qua;}
    function sethr_ini_qui($hr_ini_qui){ $this->hr_ini_qui = $hr_ini_qui;}
    function sethr_ini_sex($hr_ini_sex){ $this->hr_ini_sex = $hr_ini_sex;}
    function sethr_ini_sab($hr_ini_sab){ $this->hr_ini_sab = $hr_ini_sab;}
    function sethr_fim_dom($hr_fim_dom){ $this->hr_fim_dom = $hr_fim_dom;}
    function sethr_fim_seg($hr_fim_seg){ $this->hr_fim_seg = $hr_fim_seg;}
    function sethr_fim_ter($hr_fim_ter){ $this->hr_fim_ter = $hr_fim_ter;}
    function sethr_fim_qua($hr_fim_qua){ $this->hr_fim_qua = $hr_fim_qua;}
    function sethr_fim_qui($hr_fim_qui){ $this->hr_fim_qui = $hr_fim_qui;}
    function sethr_fim_sex($hr_fim_sex){ $this->hr_fim_sex = $hr_fim_sex;}
    function sethr_fim_sab($hr_fim_sab){ $this->hr_fim_sab = $hr_fim_sab;}

    function setds_tarefa($ds_tarefa){ $this->ds_tarefa = $ds_tarefa;}
    
    function setcolaborador_exec_ini_pk($colaborador_exec_ini_pk){ $this->colaborador_exec_ini_pk = $colaborador_exec_ini_pk;}
    function setcolaborador_exec_fim_pk($colaborador_exec_fim_pk){ $this->colaborador_exec_fim_pk = $colaborador_exec_fim_pk;}
    
}

?>
