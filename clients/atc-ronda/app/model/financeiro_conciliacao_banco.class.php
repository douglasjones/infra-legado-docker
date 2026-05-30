<?

class financeiro_conciliacao_banco{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_link_arquivo;
    private $vl_saldo_conta;
    private $dt_ini_periodo_saldo;
    private $dt_fim_periodo_saldo;
    private $ds_obs;
    private $ic_status;
    private $contas_bancarias_pk;
    private $empresas_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_link_arquivo = null;
        $this->vl_saldo_conta = null;
        $this->dt_ini_periodo_saldo = null;
        $this->dt_fim_periodo_saldo = null;
        $this->ds_obs = null;
        $this->ic_status = null;
        $this->contas_bancarias_pk = null;
        $this->empresas_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_link_arquivo(){return $this->ds_link_arquivo;}
    function getvl_saldo_conta(){return $this->vl_saldo_conta;}
    function getdt_ini_periodo_saldo(){return $this->dt_ini_periodo_saldo;}
    function getdt_fim_periodo_saldo(){return $this->dt_fim_periodo_saldo;}
    function getds_obs(){return $this->ds_obs;}
    function getic_status(){return $this->ic_status;}
    function getcontas_bancarias_pk(){return $this->contas_bancarias_pk;}
    function getempresas_pk(){return $this->empresas_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_link_arquivo($ds_link_arquivo){ $this->ds_link_arquivo = $ds_link_arquivo;}
    function setvl_saldo_conta($vl_saldo_conta){ $this->vl_saldo_conta = $vl_saldo_conta;}
    function setdt_ini_periodo_saldo($dt_ini_periodo_saldo){ $this->dt_ini_periodo_saldo = $dt_ini_periodo_saldo;}
    function setdt_fim_periodo_saldo($dt_fim_periodo_saldo){ $this->dt_fim_periodo_saldo = $dt_fim_periodo_saldo;}
    function setds_obs($ds_obs){ $this->ds_obs = $ds_obs;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setcontas_bancarias_pk($contas_bancarias_pk){ $this->contas_bancarias_pk = $contas_bancarias_pk;}
    function setempresas_pk($empresas_pk){ $this->empresas_pk = $empresas_pk;}

    
}

?>
