<?

class contrato{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $dt_inicio_contrato;
    private $dt_fim_contrato;
    private $processos_etapas_pk;
    private $ic_tipo_contrato;
    private $contratos_pk;
    private $dt_cancelamento;
    private $ds_obs_motivo_cancelamento;
    private $empresas_pk;
    private $ic_lancar_financeiro;
    private $qtde_parcelas_pk;
    private $vl_total_mao_obra;
    private $ds_identificacao_area;
    private $vl_contrato;
    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->dt_inicio_contrato = null;
        $this->dt_fim_contrato = null;
        $this->processos_etapas_pk = null;
        $this->ic_tipo_contrato = null;
        $this->contratos_pk = null;
        $this->dt_cancelamento = null;
        $this->ds_obs_motivo_cancelamento = null;
        $this->empresas_pk = null;
        $this->ic_lancar_financeiro = null;
        $this->qtde_parcelas_pk = null;
        $this->vl_total_mao_obra = null;
        $this->ds_identificacao_area = null;
        $this->vl_contrato = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getdt_inicio_contrato(){return $this->dt_inicio_contrato;}
    function getdt_fim_contrato(){return $this->dt_fim_contrato;}
    function getprocessos_etapas_pk(){return $this->processos_etapas_pk;}
    function getic_tipo_contrato(){return $this->ic_tipo_contrato;}
    function getcontratos_pk(){return $this->contratos_pk;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getds_obs_motivo_cancelamento(){return $this->ds_obs_motivo_cancelamento;}
    function getempresas_pk(){return $this->empresas_pk;}
    function getic_lancar_financeiro(){return $this->ic_lancar_financeiro;}
    function getqtde_parcelas_pk(){return $this->qtde_parcelas_pk;}
    function getvl_total_mao_obra(){return $this->vl_total_mao_obra;}
    function getds_identificacao_area(){return $this->ds_identificacao_area;}
    function getvl_contrato(){return $this->vl_contrato;}
        
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    public function setic_tipo_contrato($ic_tipo_contrato){$this->ic_tipo_contrato = $ic_tipo_contrato;}
    
    function setdt_inicio_contrato($dt_inicio_contrato){ $this->dt_inicio_contrato = $dt_inicio_contrato;}
    function setdt_fim_contrato($dt_fim_contrato){ $this->dt_fim_contrato = $dt_fim_contrato;}
    function setprocessos_etapas_pk($processos_etapas_pk){ $this->processos_etapas_pk = $processos_etapas_pk;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setds_obs_motivo_cancelamento($ds_obs_motivo_cancelamento){ $this->ds_obs_motivo_cancelamento = $ds_obs_motivo_cancelamento;}
    function setempresas_pk($empresas_pk){ $this->empresas_pk = $empresas_pk;}
    function setic_lancar_financeiro($ic_lancar_financeiro){ $this->ic_lancar_financeiro = $ic_lancar_financeiro;}
    function setqtde_parcelas_pk($qtde_parcelas_pk){ $this->qtde_parcelas_pk = $qtde_parcelas_pk;}
    function setvl_total_mao_obra($vl_total_mao_obra){ $this->vl_total_mao_obra = $vl_total_mao_obra;}
    function setds_identificacao_area($ds_identificacao_area){ $this->ds_identificacao_area = $ds_identificacao_area;}
    function setvl_contrato($vl_contrato){ $this->vl_contrato = $vl_contrato;}

    
}

?>
