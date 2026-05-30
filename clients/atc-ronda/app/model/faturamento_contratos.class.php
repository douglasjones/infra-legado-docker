<?

class faturamento_contratos{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ic_tipo_contrato;
    private $contratos_pk;
    private $leads_pk;
    private $faturamento_pk;
    private $vl_total_contrato;
    private $ic_status;
    private $obs_corpo_nota_fiscal;
    private $dt_faturamento;
    private $dt_vencimento;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ic_tipo_contrato = null;
        $this->contratos_pk = null;
        $this->leads_pk = null;
        $this->faturamento_pk = null;
        $this->vl_total_contrato = null;
        $this->ic_status = null;
        $this->obs_corpo_nota_fiscal = null;
        $this->dt_faturamento = null;
        $this->dt_vencimento = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getic_tipo_contrato(){return $this->ic_tipo_contrato;}
    function getcontratos_pk(){return $this->contratos_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function getfaturamento_pk(){return $this->faturamento_pk;}
    function getvl_total_contrato(){return $this->vl_total_contrato;}
    function getic_status(){return $this->ic_status;}
    function getobs_corpo_nota_fiscal(){return $this->obs_corpo_nota_fiscal;}
    function getdt_faturamento(){return $this->dt_faturamento;}
    function getdt_vencimento(){return $this->dt_vencimento;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setic_tipo_contrato($ic_tipo_contrato){ $this->ic_tipo_contrato = $ic_tipo_contrato;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setfaturamento_pk($faturamento_pk){ $this->faturamento_pk = $faturamento_pk;}
    function setvl_total_contrato($vl_total_contrato){ $this->vl_total_contrato = $vl_total_contrato;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setobs_corpo_nota_fiscal($obs_corpo_nota_fiscal){ $this->obs_corpo_nota_fiscal = $obs_corpo_nota_fiscal;}
    function setdt_faturamento($dt_faturamento){ $this->dt_faturamento = $dt_faturamento;}
    function setdt_vencimento($dt_vencimento){ $this->dt_vencimento = $dt_vencimento;}

    
}

?>
