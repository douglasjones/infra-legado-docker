<?

class agenda_colaborador_tarefa{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_tarefa;
    private $obs_tarefa;
    private $hr_inicio;
    private $usuario_termino_pk;
    private $dt_termino;
    private $obs_termino_tarefa;
    private $dt_alteracao_tarefa;
    private $ic_dia;
    private $agendas_pk;
    private $dt_execucao;
    private $ic_tarefa_recorrente;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_tarefa = null;
        $this->obs_tarefa = null;
        $this->hr_inicio = null;
        $this->usuario_termino_pk = null;
        $this->dt_termino = null;
        $this->obs_termino_tarefa = null;
        $this->dt_alteracao_tarefa = null;
        $this->ic_dia = null;
        $this->agendas_pk = null;
        $this->dt_execucao = null;
        $this->ic_tarefa_recorrente = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_tarefa(){return $this->ds_tarefa;}
    function getobs_tarefa(){return $this->obs_tarefa;}
    function gethr_inicio(){return $this->hr_inicio;}
    function getusuario_termino_pk(){return $this->usuario_termino_pk;}
    function getdt_termino(){return $this->dt_termino;}
    function getobs_termino_tarefa(){return $this->obs_termino_tarefa;}
    function getdt_alteracao_tarefa(){return $this->dt_alteracao_tarefa;}
    function getic_dia(){return $this->ic_dia;}
    function getagendas_pk(){return $this->agendas_pk;}
    function getdt_execucao(){return $this->dt_execucao;}
    function getic_tarefa_recorrente(){return $this->ic_tarefa_recorrente;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_tarefa($ds_tarefa){ $this->ds_tarefa = $ds_tarefa;}
    function setobs_tarefa($obs_tarefa){ $this->obs_tarefa = $obs_tarefa;}
    function sethr_inicio($hr_inicio){ $this->hr_inicio = $hr_inicio;}
    function setusuario_termino_pk($usuario_termino_pk){ $this->usuario_termino_pk = $usuario_termino_pk;}
    function setdt_termino($dt_termino){ $this->dt_termino = $dt_termino;}
    function setobs_termino_tarefa($obs_termino_tarefa){ $this->obs_termino_tarefa = $obs_termino_tarefa;}
    function setdt_alteracao_tarefa($dt_alteracao_tarefa){ $this->dt_alteracao_tarefa = $dt_alteracao_tarefa;}
    function setic_dia($ic_dia){ $this->ic_dia = $ic_dia;}
    function setagendas_pk($agendas_pk){ $this->agendas_pk = $agendas_pk;}
    function setic_tarefa_recorrente($ic_tarefa_recorrente){ $this->ic_tarefa_recorrente= $ic_tarefa_recorrente;}
    function setdt_execucao($dt_execucao){ $this->dt_execucao= $dt_execucao;}

    
}

?>
