<?

class faturamento_item{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $vl_total_lancamento;
    private $faturamento_pk;
    private $contas_pk;
    private $leads_pk;
    private $contratos_pk;
    private $dt_lancamento_financeiro;
    private $ic_item_validado;
    private $dt_item_valiado;
    private $lancamentos_pk;
    private $ic_status;
    private $ic_processamento_lancamento_item_status;
    private $dt_processamento_lancamento_lancamento;
    private $obs_faturamento_contrato;
    private $obs_lancamento;
    private $obs_corpo_nota;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->vl_total_lancamento = null;
        $this->faturamento_pk = null;
        $this->contas_pk = null;
        $this->leads_pk = null;
        $this->contratos_pk = null;
        $this->dt_lancamento_financeiro = null;
        $this->ic_item_validado = null;
        $this->dt_item_valiado = null;
        $this->lancamentos_pk = null;
        $this->ic_status = null;
        $this->ic_processamento_lancamento_item_status = null;
        $this->dt_processamento_lancamento_lancamento = null;
        $this->obs_faturamento_contrato = null;
        $this->obs_lancamento = null;
        $this->obs_corpo_nota = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getvl_total_lancamento(){return $this->vl_total_lancamento;}
    function getfaturamento_pk(){return $this->faturamento_pk;}
    function getcontas_pk(){return $this->contas_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function getcontratos_pk(){return $this->contratos_pk;}
    function getdt_lancamento_financeiro(){return $this->dt_lancamento_financeiro;}
    function getic_item_validado(){return $this->ic_item_validado;}
    function getdt_item_valiado(){return $this->dt_item_valiado;}
    function getlancamentos_pk(){return $this->lancamentos_pk;}
    function getic_status(){return $this->ic_status;}
    function getic_processamento_lancamento_item_status(){return $this->ic_processamento_lancamento_item_status;}
    function getdt_processamento_lancamento_lancamento(){return $this->dt_processamento_lancamento_lancamento;}
    function getobs_faturamento_contrato(){return $this->obs_faturamento_contrato;}
    function getobs_lancamento(){return $this->obs_lancamento;}
    function getobs_corpo_nota(){return $this->obs_corpo_nota;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setvl_total_lancamento($vl_total_lancamento){ $this->vl_total_lancamento = $vl_total_lancamento;}
    function setfaturamento_pk($faturamento_pk){ $this->faturamento_pk = $faturamento_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
    function setdt_lancamento_financeiro($dt_lancamento_financeiro){ $this->dt_lancamento_financeiro = $dt_lancamento_financeiro;}
    function setic_item_validado($ic_item_validado){ $this->ic_item_validado = $ic_item_validado;}
    function setdt_item_valiado($dt_item_valiado){ $this->dt_item_valiado = $dt_item_valiado;}
    function setlancamentos_pk($lancamentos_pk){ $this->lancamentos_pk = $lancamentos_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setic_processamento_lancamento_item_status($ic_processamento_lancamento_item_status){ $this->ic_processamento_lancamento_item_status = $ic_processamento_lancamento_item_status;}
    function setdt_processamento_lancamento_lancamento($dt_processamento_lancamento_lancamento){ $this->dt_processamento_lancamento_lancamento = $dt_processamento_lancamento_lancamento;}
    function setobs_faturamento_contrato($obs_faturamento_contrato){ $this->obs_faturamento_contrato = $obs_faturamento_contrato;}
    function setobs_lancamento($obs_lancamento){ $this->obs_lancamento = $obs_lancamento;}
    function setobs_corpo_nota($obs_corpo_nota){ $this->obs_corpo_nota = $obs_corpo_nota;}

    
}

?>
