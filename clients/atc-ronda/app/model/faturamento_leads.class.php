<?

class faturamento_leads{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $leads_pk;
    private $vl_total_bruto;
    private $vl_total_faturamento;
    private $obs_faturamento_lead;
    private $dt_cancelamento;
    private $obs_cancelamento;
    private $ic_starus;
    private $faturamento_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->leads_pk = null;
        $this->vl_total_bruto = null;
        $this->vl_total_faturamento = null;
        $this->obs_faturamento_lead = null;
        $this->dt_cancelamento = null;
        $this->obs_cancelamento = null;
        $this->ic_starus = null;
        $this->faturamento_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getleads_pk(){return $this->leads_pk;}
    function getvl_total_bruto(){return $this->vl_total_bruto;}
    function getvl_total_faturamento(){return $this->vl_total_faturamento;}
    function getobs_faturamento_lead(){return $this->obs_faturamento_lead;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getobs_cancelamento(){return $this->obs_cancelamento;}
    function getic_starus(){return $this->ic_starus;}
    function getfaturamento_pk(){return $this->faturamento_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setvl_total_bruto($vl_total_bruto){ $this->vl_total_bruto = $vl_total_bruto;}
    function setvl_total_faturamento($vl_total_faturamento){ $this->vl_total_faturamento = $vl_total_faturamento;}
    function setobs_faturamento_lead($obs_faturamento_lead){ $this->obs_faturamento_lead = $obs_faturamento_lead;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setobs_cancelamento($obs_cancelamento){ $this->obs_cancelamento = $obs_cancelamento;}
    function setic_starus($ic_starus){ $this->ic_starus = $ic_starus;}
    function setfaturamento_pk($faturamento_pk){ $this->faturamento_pk = $faturamento_pk;}

    
}

?>
