<?

class processo_default_configuracao{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $processos_default_pk;
    private $processos_default_etapas_pk;
    private $ds_processo_default_configuracao;
    private $ds_cor;
    private $tempo_execucao_pk;
    private $tipos_ocorrencias_pk;
    private $processos_default_modulos_pk;
    private $processos_default_modulos_obrigatorio_pk;
    private $ic_status;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->processos_default_pk = null;
        $this->processos_default_etapas_pk = null;
        $this->ds_processo_default_configuracao = null;
        $this->ds_cor = null;
        $this->tempo_execucao_pk = null;
        $this->tipos_ocorrencias_pk = null;
        $this->processos_default_modulos_pk = null;
        $this->processos_default_modulos_obrigatorio_pk = null;
        $this->ic_status = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getprocessos_default_pk(){return $this->processos_default_pk;}
    function getprocessos_default_etapas_pk(){return $this->processos_default_etapas_pk;}
    function getds_processo_default_configuracao(){return $this->ds_processo_default_configuracao;}
    function getds_cor(){return $this->ds_cor;}
    function gettempo_execucao_pk(){return $this->tempo_execucao_pk;}
    function gettipos_ocorrencias_pk(){return $this->tipos_ocorrencias_pk;}
    function getprocessos_default_modulos_pk(){return $this->processos_default_modulos_pk;}
    function getprocessos_default_modulos_obrigatorio_pk(){return $this->processos_default_modulos_obrigatorio_pk;} 
    function getic_status(){return $this->ic_status;} 

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setprocessos_default_pk($processos_default_pk){ $this->processos_default_pk = $processos_default_pk;}
    function setprocessos_default_etapas_pk($processos_default_etapas_pk){ $this->processos_default_etapas_pk = $processos_default_etapas_pk;}
    function setds_processo_default_configuracao($ds_processo_default_configuracao){ $this->ds_processo_default_configuracao = $ds_processo_default_configuracao;}
    function setds_cor($ds_cor){ $this->ds_cor = $ds_cor;}
    function settempo_execucao_pk($tempo_execucao_pk){ $this->tempo_execucao_pk = $tempo_execucao_pk;}
    function settipos_ocorrencias_pk($tipos_ocorrencias_pk){ $this->tipos_ocorrencias_pk = $tipos_ocorrencias_pk;}
    function setprocessos_default_modulos_pk($processos_default_modulos_pk){ $this->processos_default_modulos_pk = $processos_default_modulos_pk;}
    function setprocessos_default_modulos_obrigatorio_pk($processos_default_modulos_obrigatorio_pk){ $this->processos_default_modulos_obrigatorio_pk = $processos_default_modulos_obrigatorio_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}

    
}

?>
