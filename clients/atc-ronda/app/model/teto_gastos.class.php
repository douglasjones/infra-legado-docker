<?

class teto_gastos{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $empresas_pk;
    private $tipo_grupo_pk;
    private $grupo_leancamento_pk;
    private $leads_posto_trabalho_pk;
    private $contratos_pk;
    private $colaborador_posto_trabalho_pk;
    private $colaborador_contratos_pk;
    private $fornecedor_posto_trabalho_pk;
    private $fornecedor_contratos_pk;
    private $vl_total_teto;
    private $ic_status;
    private $obs;
    private $ds_ano_vigente_teto;
    private $grupo_lancamento_centro_custo_pk;
    private $vl_utilizado_atual;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->empresas_pk = null;
        $this->tipo_grupo_pk = null;
        $this->grupo_leancamento_pk = null;
        $this->leads_posto_trabalho_pk = null;
        $this->contratos_pk = null;
        $this->colaborador_posto_trabalho_pk = null;
        $this->colaborador_contratos_pk = null;
        $this->fornecedor_posto_trabalho_pk = null;
        $this->fornecedor_contratos_pk = null;
        $this->vl_total_teto = null;
        $this->ic_status = null;
        $this->obs = null;
        $this->ds_ano_vigente_teto = null;
        $this->grupo_lancamento_centro_custo_pk = null;
        $this->vl_utilizado_atual = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getempresas_pk(){return $this->empresas_pk;}
    function gettipo_grupo_pk(){return $this->tipo_grupo_pk;}
    function getgrupo_leancamento_pk(){return $this->grupo_leancamento_pk;}
    function getleads_posto_trabalho_pk(){return $this->leads_posto_trabalho_pk;}
    function getcontratos_pk(){return $this->contratos_pk;}
    function getcolaborador_posto_trabalho_pk(){return $this->colaborador_posto_trabalho_pk;}
    function getcolaborador_contratos_pk(){return $this->colaborador_contratos_pk;}
    function getfornecedor_posto_trabalho_pk(){return $this->fornecedor_posto_trabalho_pk;}
    function getfornecedor_contratos_pk(){return $this->fornecedor_contratos_pk;}
    function getvl_total_teto(){return $this->vl_total_teto;}
    function getic_status(){return $this->ic_status;}
    function getobs(){return $this->obs;}
    function getds_ano_vigente_teto(){return $this->ds_ano_vigente_teto;}
    function getgrupo_lancamento_centro_custo_pk(){return $this->grupo_lancamento_centro_custo_pk;}
    function getvl_utilizado_atual(){return $this->vl_utilizado_atual;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setempresas_pk($empresas_pk){ $this->empresas_pk = $empresas_pk;}
    function settipo_grupo_pk($tipo_grupo_pk){ $this->tipo_grupo_pk = $tipo_grupo_pk;}
    function setgrupo_leancamento_pk($grupo_leancamento_pk){ $this->grupo_leancamento_pk = $grupo_leancamento_pk;}
    function setleads_posto_trabalho_pk($leads_posto_trabalho_pk){ $this->leads_posto_trabalho_pk = $leads_posto_trabalho_pk;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
    function setcolaborador_posto_trabalho_pk($colaborador_posto_trabalho_pk){ $this->colaborador_posto_trabalho_pk = $colaborador_posto_trabalho_pk;}
    function setcolaborador_contratos_pk($colaborador_contratos_pk){ $this->colaborador_contratos_pk = $colaborador_contratos_pk;}
    function setfornecedor_posto_trabalho_pk($fornecedor_posto_trabalho_pk){ $this->fornecedor_posto_trabalho_pk = $fornecedor_posto_trabalho_pk;}
    function setfornecedor_contratos_pk($fornecedor_contratos_pk){ $this->fornecedor_contratos_pk = $fornecedor_contratos_pk;}
    function setvl_total_teto($vl_total_teto){ $this->vl_total_teto = $vl_total_teto;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setobs($obs){ $this->obs = $obs;}
    function setds_ano_vigente_teto($ds_ano_vigente_teto){ $this->ds_ano_vigente_teto = $ds_ano_vigente_teto;}
    function setgrupo_lancamento_centro_custo_pk($grupo_lancamento_centro_custo_pk){ $this->grupo_lancamento_centro_custo_pk = $grupo_lancamento_centro_custo_pk;}
    function setvl_utilizado_atual($vl_utilizado_atual){ $this->vl_utilizado_atual = $vl_utilizado_atual;}

    
}

?>
