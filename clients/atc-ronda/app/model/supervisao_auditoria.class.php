<?

class supervisao_auditoria{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $leads_pk;
    private $auditorias_categorias_pk;
    private $auditorias_categorias_tipos_pk;
    private $dt_agendamento;
    private $usuario_agendamento_pk;
    private $dt_execucao;
    private $usuario_execucao_pk;
    private $ic_contato_cliente;
    private $obs_contato_cliente;
    private $obs_geral;
    private $ds_localizacao;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->leads_pk = null;
        $this->auditorias_categorias_pk = null;
        $this->auditorias_categorias_tipos_pk = null;
        $this->dt_agendamento = null;
        $this->usuario_agendamento_pk = null;
        $this->dt_execucao = null;
        $this->usuario_execucao_pk = null;
        $this->ic_contato_cliente = null;
        $this->obs_contato_cliente = null;
        $this->obs_geral = null;
        $this->ds_localizacao = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getleads_pk(){return $this->leads_pk;}
    function getauditorias_categorias_pk(){return $this->auditorias_categorias_pk;}
    function getauditorias_categorias_tipos_pk(){return $this->auditorias_categorias_tipos_pk;}
    function getdt_agendamento(){return $this->dt_agendamento;}
    function getusuario_agendamento_pk(){return $this->usuario_agendamento_pk;}
    function getdt_execucao(){return $this->dt_execucao;}
    function getusuario_execucao_pk(){return $this->usuario_execucao_pk;}
    function getic_contato_cliente(){return $this->ic_contato_cliente;}
    function getobs_contato_cliente(){return $this->obs_contato_cliente;}
    function getobs_geral(){return $this->obs_geral;}
    function getds_localizacao(){return $this->ds_localizacao;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setauditorias_categorias_pk($auditorias_categorias_pk){ $this->auditorias_categorias_pk = $auditorias_categorias_pk;}
    function setauditorias_categorias_tipos_pk($auditorias_categorias_tipos_pk){ $this->auditorias_categorias_tipos_pk = $auditorias_categorias_tipos_pk;}
    function setdt_agendamento($dt_agendamento){ $this->dt_agendamento = $dt_agendamento;}
    function setusuario_agendamento_pk($usuario_agendamento_pk){ $this->usuario_agendamento_pk = $usuario_agendamento_pk;}
    function setdt_execucao($dt_execucao){ $this->dt_execucao = $dt_execucao;}
    function setusuario_execucao_pk($usuario_execucao_pk){ $this->usuario_execucao_pk = $usuario_execucao_pk;}
    function setic_contato_cliente($ic_contato_cliente){ $this->ic_contato_cliente = $ic_contato_cliente;}
    function setobs_contato_cliente($obs_contato_cliente){ $this->obs_contato_cliente = $obs_contato_cliente;}
    function setobs_geral($obs_geral){ $this->obs_geral = $obs_geral;}
    function setds_localizacao($ds_localizacao){ $this->ds_localizacao = $ds_localizacao;}

    
}

?>
