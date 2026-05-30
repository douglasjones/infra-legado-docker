<?

class condutor{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_condutor;
    private $ds_cpf;
    private $ds_rg;
    private $leads_pk;
    private $ic_status;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_condutor = null;
        $this->ds_cpf = null;
        $this->ds_rg = null;
        $this->leads_pk = null;
        $this->ic_status = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_condutor(){return $this->ds_condutor;}
    function getds_cpf(){return $this->ds_cpf;}
    function getds_rg(){return $this->ds_rg;}
    function getleads_pk(){return $this->leads_pk;}
    function getic_status(){return $this->ic_status;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_condutor($ds_condutor){ $this->ds_condutor = $ds_condutor;}
    function setds_cpf($ds_cpf){ $this->ds_cpf = $ds_cpf;}
    function setds_rg($ds_rg){ $this->ds_rg = $ds_rg;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}

    
}

?>
