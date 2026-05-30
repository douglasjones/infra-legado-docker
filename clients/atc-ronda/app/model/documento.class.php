<?

class documento{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_documento;
    private $ds_obs;
    private $ds_nome_original;
    private $colaboradores_pk;
    private $leads_pk;
    private $contratos_pk;
    private $ocorrencias_pk;
    private $agenda_colaborador_tarefa_pk;
    private $lancamentos_pk;
    private $compras_pk;
    private $agendas_pk;

    private $ic_tipo_documento;    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_documento = null;
        $this->ds_obs = null;
        $this->ds_nome_original = null;
        $this->colaboradores_pk = null;
        $this->leads_pk = null;
        $this->contratos_pk = null;
        $this->ocorrencias_pk = null;
        $this->agenda_colaborador_tarefa_pk = null;
        $this->lancamentos_pk = null;
        $this->compras_pk = null;
        $this->agendas_pk = null;
        $this->ic_tipo_documento = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_documento(){return $this->ds_documento;}
    function getds_obs(){return $this->ds_obs;}
    function getds_nome_original(){return $this->ds_nome_original;}
    function getcolaboradores_pk(){return $this->colaboradores_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function getcontratos_pk(){return $this->contratos_pk;}
    function getocorrencias_pk(){return $this->ocorrencias_pk;}
    function getagenda_colaborador_tarefa_pk(){return $this->agenda_colaborador_tarefa_pk;}
    function getlancamentos_pk(){return $this->lancamentos_pk;}
    function getcompras_pk(){return $this->compras_pk;}
    function getagendas_pk(){return $this->agendas_pk;}
    function getic_tipo_documento(){return $this->ic_tipo_documento;}    

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_documento($ds_documento){ $this->ds_documento = $ds_documento;}
    function setds_obs($ds_obs){ $this->ds_obs = $ds_obs;}
    function setds_nome_original($ds_nome_original){ $this->ds_nome_original = $ds_nome_original;}
    function setcolaboradores_pk($colaboradores_pk){ $this->colaboradores_pk = $colaboradores_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
    function setocorrencias_pk($ocorrencias_pk){ $this->ocorrencias_pk = $ocorrencias_pk;}
    function setagenda_colaborador_tarefa_pk($agenda_colaborador_tarefa_pk){ $this->agenda_colaborador_tarefa_pk = $agenda_colaborador_tarefa_pk;}
    function setlancamentos_pk($lancamentos_pk){ $this->lancamentos_pk = $lancamentos_pk;}
    function setcompras_pk($compras_pk){ $this->compras_pk = $compras_pk;}
    function setagendas_pk($agendas_pk){ $this->agendas_pk = $agendas_pk;}
    function setic_tipo_documento($ic_tipo_documento){ $this->ic_tipo_documento = $ic_tipo_documento;}
    
}

?>
