<?

class compras_solicitacao_orcamentos{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $fornecedor_pk;
    private $dt_pevisao_entrega;
    private $vl_frete;
    private $vl_total;
    private $obs_orcamento;
    private $ic_status;
    private $compra_solicitacao_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->fornecedor_pk = null;
        $this->dt_pevisao_entrega = null;
        $this->vl_frete = null;
        $this->vl_total = null;
        $this->obs_orcamento = null;
        $this->ic_status = null;
        $this->compra_solicitacao_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getfornecedor_pk(){return $this->fornecedor_pk;}
    function getdt_pevisao_entrega(){return $this->dt_pevisao_entrega;}
    function getvl_frete(){return $this->vl_frete;}
    function getvl_total(){return $this->vl_total;}
    function getobs_orcamento(){return $this->obs_orcamento;}
    function getic_status(){return $this->ic_status;}
    function getcompra_solicitacao_pk(){return $this->compra_solicitacao_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setfornecedor_pk($fornecedor_pk){ $this->fornecedor_pk = $fornecedor_pk;}
    function setdt_pevisao_entrega($dt_pevisao_entrega){ $this->dt_pevisao_entrega = $dt_pevisao_entrega;}
    function setvl_frete($vl_frete){ $this->vl_frete = $vl_frete;}
    function setvl_total($vl_total){ $this->vl_total = $vl_total;}
    function setobs_orcamento($obs_orcamento){ $this->obs_orcamento = $obs_orcamento;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setcompra_solicitacao_pk($compra_solicitacao_pk){ $this->compra_solicitacao_pk = $compra_solicitacao_pk;}

    
}

?>
