<?

class apontamento{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $dt_ponto;
    private $hr_entreda;
    private $hr_saida;
    private $ds_local_atual;
    private $apontamento_usuario_pk;
    private $obs;
    private $leads_pk;
    private $ic_status;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->dt_ponto = null;
        $this->hr_entreda = null;
        $this->hr_saida = null;
        $this->ds_local_atual = null;
        $this->apontamento_usuario_pk = null;
        $this->obs = null;
        $this->leads_pk = null;
        $this->ic_status = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getdt_ponto(){return $this->dt_ponto;}
    function gethr_entreda(){return $this->hr_entreda;}
    function gethr_saida(){return $this->hr_saida;}
    function getds_local_atual(){return $this->ds_local_atual;}
    function getapontamento_usuario_pk(){return $this->apontamento_usuario_pk;}
    function getobs(){return $this->obs;}
    function getleads_pk(){return $this->leads_pk;}
    function getic_status(){return $this->ic_status;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setdt_ponto($dt_ponto){ $this->dt_ponto = $dt_ponto;}
    function sethr_entreda($hr_entreda){ $this->hr_entreda = $hr_entreda;}
    function sethr_saida($hr_saida){ $this->hr_saida = $hr_saida;}
    function setds_local_atual($ds_local_atual){ $this->ds_local_atual = $ds_local_atual;}
    function setapontamento_usuario_pk($apontamento_usuario_pk){ $this->apontamento_usuario_pk = $apontamento_usuario_pk;}
    function setobs($obs){ $this->obs = $obs;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}

    
}

?>
